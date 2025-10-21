<?php

namespace App\Http\Controllers\Admin;

use App\Models\Surat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class SuratController extends Controller
{
    public function index(Request $request)
    {
        $query = Surat::query();

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

        return view('admin.surat.index', compact('suratMasuk', 'suratKeluar'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nama_kegiatan' => 'required|string|max:255',
                'no_surat' => 'required|string|max:255|unique:surat,no_surat',
                'jenis_surat' => 'required|in:masuk,keluar',
                'dokumen_surat' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            ]);

            $surat = new Surat();
            $surat->nama_kegiatan = $validated['nama_kegiatan'];
            $surat->jenis_surat = $validated['jenis_surat'];
            $surat->no_surat = $validated['no_surat']; // Use the provided no_surat instead of generating

            if ($request->hasFile('dokumen_surat')) {
                $file = $request->file('dokumen_surat');
                $filename = $file->getClientOriginalName();
                $path = $file->storeAs('surat', $filename, 'public');
                $surat->dokumen_surat = $path;
            }

            $surat->save();

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

    public function update(Request $request, $id)
    {
        try {
            $surat = Surat::findOrFail($id);

            $validated = $request->validate([
                'nama_kegiatan' => 'required|string|max:255',
                'no_surat' => 'required|string|max:255|unique:surat,no_surat,' . $id,
                'jenis_surat' => 'required|in:masuk,keluar',
                'dokumen_surat' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            ]);

            $surat->nama_kegiatan = $validated['nama_kegiatan'];
            $surat->no_surat = $validated['no_surat'];
            $surat->jenis_surat = $validated['jenis_surat'];

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


    private function generateNoSurat($jenisSurat)
    {
        $prefix = $jenisSurat == 'masuk' ? 'SM' : 'SK';
        $year = date('Y');
        $month = date('m');

        $lastSurat = Surat::where('jenis_surat', $jenisSurat)
            ->where('no_surat', 'like', "{$prefix}/{$year}/{$month}%")
            ->orderBy('no_surat', 'desc')
            ->first();

        if ($lastSurat) {
            $lastNumber = (int) substr($lastSurat->no_surat, -3);
            $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '001';
        }

        return "{$prefix}/{$year}/{$month}/{$newNumber}";
    }
}
