<?php

namespace App\Http\Controllers\Admin;

use App\Models\Arsip\ArsipKategori;
use App\Models\Surat;
use App\Models\SuratPenomoran;
use App\Models\SuratTemplate;
use App\Services\NomorSuratGenerator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SuratController extends Controller
{
    public function __construct(private NomorSuratGenerator $generator)
    {
    }

    public function index(Request $request)
    {
        $query = Surat::with('template:id,nama');

        // Expanded allowed sorts to include all sortable columns
        $allowedSorts = ['nama_kegiatan', 'no_surat', 'dokumen_surat', 'created_at', 'updated_at'];
        $sortBy = $request->get('sort_by', 'created_at');
        $order = strtolower($request->get('order', 'desc'));

        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'created_at';
        }

        if (!in_array($order, ['asc', 'desc'])) {
            $order = 'desc';
        }

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('nama_kegiatan', 'LIKE', "%{$search}%")
                  ->orWhere('no_surat', 'LIKE', "%{$search}%");
            });
        }

        // Filter by jenis_surat
        if ($request->filled('jenis_surat') && $request->get('jenis_surat') !== 'all') {
            $query->where('jenis_surat', $request->get('jenis_surat'));
        }

        // Filter by date
        if ($request->filled('created_date')) {
            $query->whereDate('created_at', $request->get('created_date'));
        }
        
        // Filter by date range (start and end dates)
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [
                $request->get('start_date') . ' 00:00:00',
                $request->get('end_date') . ' 23:59:59'
            ]);
        } elseif ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->get('start_date'));
        } elseif ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->get('end_date'));
        }

        $perPage = $request->get('per_page', 10);

        // Apply sorting with special handling for different columns
        if ($sortBy === 'dokumen_surat') {
            // For dokumen_surat, we'll sort by whether the document exists or not, then by filename
            $query->orderByRaw("CASE WHEN dokumen_surat IS NULL OR dokumen_surat = '' THEN 1 ELSE 0 END")
                  ->orderBy('dokumen_surat', $order);
        } else {
            $query->orderBy($sortBy, $order);
        }

        // Add secondary sorting to ensure consistent results
        if ($sortBy !== 'created_at') {
            $query->orderBy('created_at', 'desc');
        }
        $query->orderBy('id', 'desc');

        $currentTab = $request->get('tab', 'masuk');

        // Handle AJAX requests for dynamic table loading
        if ($request->ajax()) {
            $tabQuery = clone $query;
            $tabQuery->where('jenis_surat', $currentTab);
            $suratData = $tabQuery->paginate($perPage);

            // Preserve query parameters in pagination
            $suratData->appends($request->query());

            return view('admin.surat._table', [
                'suratData' => $suratData,
                'tableId' => $currentTab
            ])->render();
        }

        // For non-AJAX requests, get data for both tabs
        $suratMasukQuery = clone $query;
        $suratMasuk = $suratMasukQuery->where('jenis_surat', 'masuk')->paginate($perPage);
        $suratMasuk->appends($request->query());

        $suratKeluarQuery = clone $query;
        $suratKeluar = $suratKeluarQuery->where('jenis_surat', 'keluar')->paginate($perPage);
        $suratKeluar->appends($request->query());

        $templates = SuratTemplate::active()->orderBy('nama')->get(['id', 'nama', 'kode']);
        $penomoranKeluar = SuratPenomoran::defaultUntuk('keluar');
        $penomoranMasuk = SuratPenomoran::defaultUntuk('masuk');
        $klasifikasiList = ArsipKategori::orderBy('kode_klasifikasi')->get(['kode_klasifikasi', 'nama']);

        return view('admin.surat.index', compact('suratMasuk', 'suratKeluar', 'templates', 'penomoranKeluar', 'penomoranMasuk', 'klasifikasiList'));
    }

    public function store(Request $request)
    {
        try {
            $penomoranKeluar = SuratPenomoran::defaultUntuk('keluar');
            // Nomor otomatis dipaksa bila format default tidak boleh diedit manual
            $otomatis = $request->input('jenis_surat') === 'keluar' && $penomoranKeluar
                && ($request->boolean('nomor_otomatis') || !$penomoranKeluar->editable);
            if ($otomatis) {
                // Nomor di form hanya perkiraan; nomor final dibuat di bawah
                $request->merge(['no_surat' => null]);
            }

            $validated = $request->validate([
                'nama_kegiatan' => 'required|string|max:255',
                'no_surat' => [$otomatis ? 'nullable' : 'required', 'string', 'max:255', 'unique:surat,no_surat'],
                'jenis_surat' => 'required|in:masuk,keluar',
                'tanggal_surat' => 'nullable|date',
                'kode_surat' => 'nullable|string|max:50',
                'kode_klasifikasi' => 'nullable|string|max:50',
                'dokumen_surat' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            ]);

            $tanggal = isset($validated['tanggal_surat']) ? Carbon::parse($validated['tanggal_surat']) : now();

            DB::transaction(function () use ($request, $validated, $otomatis, $penomoranKeluar, $tanggal) {
                $surat = new Surat();
                $surat->nama_kegiatan = $validated['nama_kegiatan'];
                $surat->jenis_surat = $validated['jenis_surat'];
                $surat->tanggal_surat = $tanggal;
                $surat->sumber = 'upload';
                $surat->kode_klasifikasi = $validated['kode_klasifikasi'] ?? null;

                if ($otomatis) {
                    $surat->no_surat = $this->generator->generate($penomoranKeluar, $tanggal, [
                        'kode' => strtoupper($validated['kode_surat'] ?? ''),
                        'klasifikasi' => (string) $surat->kode_klasifikasi,
                    ]);
                    $surat->surat_penomoran_id = $penomoranKeluar->id;
                } else {
                    $surat->no_surat = $validated['no_surat'];
                }

                // Nomor agenda surat masuk selalu otomatis bila formatnya sudah diatur
                if ($surat->jenis_surat === 'masuk' && ($penomoranMasuk = SuratPenomoran::defaultUntuk('masuk'))) {
                    $surat->no_agenda = $this->generator->generate($penomoranMasuk, $tanggal);
                }

                if ($request->hasFile('dokumen_surat')) {
                    $file = $request->file('dokumen_surat');
                    $filename = $file->getClientOriginalName();
                    $path = $file->storeAs('surat', $filename, 'public');
                    $surat->dokumen_surat = $path;
                }

                $surat->save();
            });

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Surat berhasil ditambahkan!'
                ]);
            }

            return redirect()->route('admin.surat.index')
                ->with('success', 'Surat berhasil ditambahkan!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $e->errors()
                ], 422);
            }

            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();

        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menyimpan data')
                ->withInput();
        }
    }

    /** Perkiraan nomor berikutnya untuk ditampilkan di form (tidak mengambil nomor). */
    public function nomorPreview(Request $request)
    {
        $request->validate([
            'jenis' => 'required|in:masuk,keluar',
            'tanggal' => 'nullable|date',
            'template_id' => 'nullable|exists:surat_template,id',
            'kode' => 'nullable|string|max:50',
            'klasifikasi' => 'nullable|string|max:50',
        ]);

        $template = $request->filled('template_id') ? SuratTemplate::find($request->template_id) : null;
        $penomoran = $template ? $template->penomoranEfektif() : SuratPenomoran::defaultUntuk($request->jenis);

        if (!$penomoran) {
            return response()->json(['tersedia' => false]);
        }

        $tanggal = $request->filled('tanggal') ? Carbon::parse($request->tanggal) : now();
        // Klasifikasi yang dipilih di form menggantikan klasifikasi bawaan template
        $klasifikasi = $request->has('klasifikasi') ? (string) $request->klasifikasi : (string) $template?->kode_klasifikasi;
        $context = [
            'kode' => $template ? $template->kode : strtoupper((string) $request->kode),
            'klasifikasi' => $klasifikasi,
        ];

        return response()->json([
            'tersedia' => true,
            'nomor' => $this->generator->preview($penomoran, $tanggal, $context),
            'editable' => $penomoran->editable,
            'format' => $penomoran->nama,
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            $surat = Surat::findOrFail($id);

            $validated = $request->validate([
                'nama_kegiatan' => 'required|string|max:255',
                'no_surat' => 'required|string|max:255|unique:surat,no_surat,' . $id,
                'jenis_surat' => 'required|in:masuk,keluar',
                'tanggal_surat' => 'nullable|date',
                'dokumen_surat' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            ]);

            $surat->nama_kegiatan = $validated['nama_kegiatan'];
            $surat->no_surat = $validated['no_surat'];
            $surat->jenis_surat = $validated['jenis_surat'];
            $surat->tanggal_surat = $validated['tanggal_surat'] ?? $surat->tanggal_surat;

            if ($request->hasFile('dokumen_surat')) {
                // Delete old file if exists
                if ($surat->dokumen_surat && Storage::disk('public')->exists($surat->dokumen_surat)) {
                    Storage::disk('public')->delete($surat->dokumen_surat);
                }

                $file = $request->file('dokumen_surat');
                $filename = $file->getClientOriginalName();
                $path = $file->storeAs('surat', $filename, 'public');
                $surat->dokumen_surat = $path;
            }

            $surat->save();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Surat berhasil diperbarui!'
                ]);
            }

            return redirect()->route('admin.surat.index')
                ->with('success', 'Surat berhasil diperbarui!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $e->errors()
                ], 422);
            }

            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();

        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memperbarui data')
                ->withInput();
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $surat = Surat::findOrFail($id);

            // Delete associated file if exists
            if ($surat->dokumen_surat && Storage::disk('public')->exists($surat->dokumen_surat)) {
                Storage::disk('public')->delete($surat->dokumen_surat);
            }

            $surat->delete();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Surat berhasil dihapus!'
                ]);
            }

            return redirect()->route('admin.surat.index')
                ->with('success', 'Surat berhasil dihapus!');

        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menghapus data');
        }
    }
}
