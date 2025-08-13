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

        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where('nama_kegiatan', 'LIKE', "%{$search}%");
        }

        if ($request->filled('jenis_surat') && $request->get('jenis_surat') !== 'all') {
            $query->where('jenis_surat', $request->get('jenis_surat'));
        }

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->get('start_date'));
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->get('end_date'));
        }

        $perPage = $request->get('per_page', 10);
        $query->orderBy('created_at', 'desc');

        $currentTab = $request->get('tab', 'masuk');

        if ($request->ajax()) {
            $tabQuery = clone $query;
            $tabQuery->where('jenis_surat', $currentTab);
            $suratData = $tabQuery->paginate($perPage);
            
            return view('admin.surat._table', [
                'suratData' => $suratData,
                'tableId' => $currentTab
            ])->render();
        }

        $suratMasukQuery = clone $query;
        $suratMasuk = $suratMasukQuery->where('jenis_surat', 'masuk')->paginate($perPage);

        $suratKeluarQuery = clone $query;
        $suratKeluar = $suratKeluarQuery->where('jenis_surat', 'keluar')->paginate($perPage);

        return view('admin.surat.index', compact('suratMasuk', 'suratKeluar'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nama_kegiatan' => 'required|string|max:255',
                'jenis_surat' => 'required|in:masuk,keluar',
                'dokumen_surat' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            ]);

            $surat = new Surat();
            $surat->nama_kegiatan = $validated['nama_kegiatan'];
            $surat->jenis_surat = $validated['jenis_surat'];
            $surat->no_surat = $this->generateNoSurat($validated['jenis_surat']);

            if ($request->hasFile('dokumen_surat')) {
                $file = $request->file('dokumen_surat');
                $filename = time() . '_' . $file->getClientOriginalName();
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
                'jenis_surat' => 'required|in:masuk,keluar',
                'dokumen_surat' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            ]);

            $surat->nama_kegiatan = $validated['nama_kegiatan'];
            $surat->jenis_surat = $validated['jenis_surat'];

            if ($request->hasFile('dokumen_surat')) {
                if ($surat->dokumen_surat && Storage::disk('public')->exists($surat->dokumen_surat)) {
                    Storage::disk('public')->delete($surat->dokumen_surat);
                }

                $file = $request->file('dokumen_surat');
                $filename = time() . '_' . $file->getClientOriginalName();
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