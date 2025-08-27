<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lpj;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class KegiatanLainnyaController extends Controller
{
    // Konstanta untuk mengidentifikasi jenis kegiatan Sekretariat
    const PARENT_CATEGORY = 'Sekretariat';

    public function index(Request $request)
    {
        // Cari atau buat parent kategori Sekretariat
        $parentCategory = $this->getOrCreateParentCategory();

        $query = Lpj::where('parent_id', $parentCategory->id);

        if ($request->jenis_kegiatan_filter) {
            $query->where('nama_kegiatan', 'like', "%{$request->jenis_kegiatan_filter}%");
        }
        if ($request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('nama_program', 'like', "%{$request->search}%")
                  ->orWhere('nama_kegiatan', 'like', "%{$request->search}%");
            });
        }

        $allowedSorts = ['nama_program', 'nama_kegiatan', 'volume', 'jumlah_harga_satuan', 'jumlah_harga', 'created_at'];
        $sort = $request->get('sort', 'created_at');
        $direction = $request->get('direction', 'desc');

        if (!in_array($sort, $allowedSorts)) {
            $sort = 'created_at';
        }
        if (!in_array($direction, ['asc', 'desc'])) {
            $direction = 'desc';
        }

        $kegiatanLainnya = $query
            ->orderBy($sort, $direction)
            ->paginate($request->get('per_page', 10));

        if ($request->ajax()) {
            return view('admin.laporan-lpj.kegiatan_lainnya._table', compact('kegiatanLainnya'))->render();
        }

        return view('admin.laporan-lpj.kegiatan_lainnya.index', compact('kegiatanLainnya'));
    }

    public function create()
    {
        return view('admin.laporan-lpj.kegiatan_lainnya.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_program_kegiatan' => 'required|string|max:255',
            'jenis_kegiatan' => 'required|string|max:255',
            'keterangan_tambahan' => 'nullable|string',
            'volume' => 'required|string|max:255',
            'jumlah_harga_satuan' => 'required|numeric|min:0',
            'jumlah_harga' => 'required|numeric|min:0',
            'foto_jurnal' => 'nullable|array|max:10',
            'foto_jurnal.*' => 'image|mimes:jpeg,png,jpg,gif|max:10240',
            'dokumen_pendukung' => 'nullable|array|max:10',
            'dokumen_pendukung.*' => 'file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
        ], [
            'foto_jurnal.max' => 'Maksimal 10 foto yang dapat diunggah.',
            'foto_jurnal.*.image' => 'File harus berupa gambar.',
            'foto_jurnal.*.mimes' => 'Format foto harus: jpeg, png, jpg, gif.',
            'foto_jurnal.*.max' => 'Ukuran foto maksimal 10MB.',
            'dokumen_pendukung.max' => 'Maksimal 10 dokumen yang dapat diunggah.',
            'dokumen_pendukung.*.file' => 'File dokumen tidak valid.',
            'dokumen_pendukung.*.mimes' => 'Format dokumen harus: pdf, doc, docx, xls, xlsx.',
            'dokumen_pendukung.*.max' => 'Ukuran dokumen maksimal 10MB.',
        ]);

        // Cari atau buat parent kategori
        $parentCategory = $this->getOrCreateParentCategory();

        $data = [
            'parent_id' => $parentCategory->id,
            'nama_program' => $request->nama_program_kegiatan, // Map ke nama_program
            'nama_kegiatan' => $request->jenis_kegiatan, // Map ke nama_kegiatan
            'volume' => $request->volume,
            'jumlah_harga_satuan' => $request->jumlah_harga_satuan,
            'jumlah_harga' => $request->jumlah_harga,
            'keterangan_tambahan' => $request->keterangan_tambahan,
            'icon' => 'fas fa-clipboard-list' // Default icon untuk Sekretariat
        ];

        if ($request->hasFile('foto_jurnal')) {
            $fotoPaths = [];
            foreach ($request->file('foto_jurnal') as $file) {
                $fotoPaths[] = $file->store('sekretariat/foto_jurnal', 'public');
            }
            $data['foto_jurnal'] = $fotoPaths;
        }

        if ($request->hasFile('dokumen_pendukung')) {
            $dokumenPaths = [];
            foreach ($request->file('dokumen_pendukung') as $file) {
                $dokumenPaths[] = $file->store('sekretariat/dokumen_pendukung', 'public');
            }
            $data['dokumen_lpj'] = $dokumenPaths; // Map ke dokumen_lpj
        }

        Lpj::create($data);

        return redirect()->route('admin.laporan-lpj.kegiatan_lainnya.index')
                         ->with('OK', 'Kegiatan berhasil ditambahkan.');
    }

    public function show($id)
    {
        $sekretariat = Lpj::where('parent_id', $this->getOrCreateParentCategory()->id)
                          ->findOrFail($id);
        return view('admin.laporan-lpj.kegiatan_lainnya.show', compact('sekretariat'));
    }

    public function edit($id)
    {
        if (!auth()->user()->hasRole('superadmin')) {
            abort(403, 'Akses ditolak. Hanya superadmin yang dapat mengedit data.');
        }

        $sekretariat = Lpj::where('parent_id', $this->getOrCreateParentCategory()->id)
                          ->findOrFail($id);
        return view('admin.laporan-lpj.kegiatan_lainnya.edit', compact('sekretariat'));
    }

    public function update(Request $request, $id)
    {
        if (!auth()->user()->hasRole('superadmin')) {
            abort(403, 'Akses ditolak. Hanya superadmin yang dapat memperbarui data.');
        }

        $sekretariat = Lpj::where('parent_id', $this->getOrCreateParentCategory()->id)
                          ->findOrFail($id);

        $request->validate([
            'nama_program_kegiatan' => 'required|string|max:255',
            'jenis_kegiatan' => 'required|string|max:255',
            'keterangan_tambahan' => 'nullable|string',
            'volume' => 'required|string|max:255',
            'jumlah_harga_satuan' => 'required|numeric|min:0',
            'jumlah_harga' => 'required|numeric|min:0',
            'foto_jurnal' => 'nullable|array|max:10',
            'foto_jurnal.*' => 'image|mimes:jpeg,png,jpg,gif|max:10240',
            'dokumen_pendukung' => 'nullable|array|max:10',
            'dokumen_pendukung.*' => 'file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
        ], [
            'foto_jurnal.max' => 'Maksimal 10 foto yang dapat diunggah.',
            'foto_jurnal.*.image' => 'File harus berupa gambar.',
            'foto_jurnal.*.mimes' => 'Format foto harus: jpeg, png, jpg, gif.',
            'foto_jurnal.*.max' => 'Ukuran foto maksimal 10MB.',
            'dokumen_pendukung.max' => 'Maksimal 10 dokumen yang dapat diunggah.',
            'dokumen_pendukung.*.file' => 'File dokumen tidak valid.',
            'dokumen_pendukung.*.mimes' => 'Format dokumen harus: pdf, doc, docx, xls, xlsx.',
            'dokumen_pendukung.*.max' => 'Ukuran dokumen maksimal 10MB.',
        ]);

        $data = [
            'nama_program' => $request->nama_program_kegiatan,
            'nama_kegiatan' => $request->jenis_kegiatan,
            'volume' => $request->volume,
            'jumlah_harga_satuan' => $request->jumlah_harga_satuan,
            'jumlah_harga' => $request->jumlah_harga,
            'keterangan_tambahan' => $request->keterangan_tambahan
        ];

        if ($request->hasFile('foto_jurnal')) {
            if ($sekretariat->foto_jurnal) {
                foreach ($sekretariat->foto_jurnal as $oldFoto) {
                    Storage::disk('public')->delete($oldFoto);
                }
            }

            $fotoPaths = [];
            foreach ($request->file('foto_jurnal') as $file) {
                $fotoPaths[] = $file->store('sekretariat/foto_jurnal', 'public');
            }
            $data['foto_jurnal'] = $fotoPaths;
        }

        if ($request->hasFile('dokumen_pendukung')) {
            if ($sekretariat->dokumen_lpj) {
                foreach ($sekretariat->dokumen_lpj as $oldDokumen) {
                    Storage::disk('public')->delete($oldDokumen);
                }
            }

            $dokumenPaths = [];
            foreach ($request->file('dokumen_pendukung') as $file) {
                $dokumenPaths[] = $file->store('sekretariat/dokumen_pendukung', 'public');
            }
            $data['dokumen_lpj'] = $dokumenPaths;
        }

        $sekretariat->update($data);

        return redirect()->route('admin.laporan-lpj.kegiatan_lainnya.index')
                         ->with('OK', 'Kegiatan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        if (!auth()->user()->hasRole('superadmin')) {
            abort(403, 'Akses ditolak. Hanya superadmin yang dapat menghapus data.');
        }

        $sekretariat = Lpj::where('parent_id', $this->getOrCreateParentCategory()->id)
                          ->findOrFail($id);

        if ($sekretariat->foto_jurnal) {
            foreach ($sekretariat->foto_jurnal as $foto) {
                Storage::disk('public')->delete($foto);
            }
        }

        if ($sekretariat->dokumen_lpj) {
            foreach ($sekretariat->dokumen_lpj as $dokumen) {
                Storage::disk('public')->delete($dokumen);
            }
        }

        $sekretariat->delete();

        return redirect()->route('admin.laporan-lpj.kegiatan_lainnya.index')
                         ->with('OK', 'Kegiatan berhasil dihapus.');
    }

    public function removeFile(Request $request, $id)
    {
        if (!auth()->user()->hasRole('superadmin')) {
            return response()->json(['error' => 'Akses ditolak'], 403);
        }

        $sekretariat = Lpj::where('parent_id', $this->getOrCreateParentCategory()->id)
                          ->findOrFail($id);

        $request->validate([
            'file_type' => 'required|in:foto_jurnal,dokumen_lpj', // Ubah dokumen_pendukung ke dokumen_lpj
            'file_index' => 'required|integer|min:0'
        ]);

        $fileType = $request->file_type;
        $fileIndex = $request->file_index;
        $files = $sekretariat->$fileType ?? [];

        if (!isset($files[$fileIndex])) {
            return response()->json(['error' => 'File tidak ditemukan'], 404);
        }

        $filePath = $files[$fileIndex];
        Storage::disk('public')->delete($filePath);

        unset($files[$fileIndex]);
        $files = array_values($files);

        $sekretariat->update([$fileType => $files]);

        return response()->json([
            'success' => true,
            'message' => 'File berhasil dihapus',
            'remaining_files' => count($files)
        ]);
    }

    /**
     * Mendapatkan atau membuat parent kategori untuk Sekretariat
     */
    private function getOrCreateParentCategory()
    {
        return Lpj::firstOrCreate(
            ['parent_id' => null, 'nama_program' => self::PARENT_CATEGORY],
            [
                'nama_kegiatan' => 'Kategori ' . self::PARENT_CATEGORY,
                'volume' => '',
                'jumlah_harga_satuan' => 0,
                'jumlah_harga' => 0,
                'icon' => 'fas fa-building'
            ]
        );
    }

    public function export(Request $request)
{
    $data = json_decode($request->data, true);
    $title = $request->title ?? 'LPJ_Export_' . date('Ymd_His');
    
    $pdf = PDF::loadView('admin.laporan-lpj.kegiatan_lainnya.export', [
        'data' => [$data], // Wrap in array for consistency
        'title' => $title
    ]);
    
    return $pdf->download($title . '.pdf');
}
}
