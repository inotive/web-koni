<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lpj;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SekretariatController extends Controller
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
            return view('admin.laporan-lpj.sekretariat._table', compact('kegiatanLainnya'))->render();
        }

        return view('admin.laporan-lpj.sekretariat.index', compact('kegiatanLainnya'));
    }

    public function create()
    {
        return view('admin.laporan-lpj.sekretariat.create');
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
            'dokumen_lpj' => 'nullable|array|max:10',
            'dokumen_lpj.*' => 'file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
        ], [
            'foto_jurnal.max' => 'Maksimal 10 foto yang dapat diunggah.',
            'foto_jurnal.*.image' => 'File harus berupa gambar.',
            'foto_jurnal.*.mimes' => 'Format foto harus: jpeg, png, jpg, gif.',
            'foto_jurnal.*.max' => 'Ukuran foto maksimal 10MB.',
            'dokumen_lpj.max' => 'Maksimal 10 dokumen yang dapat diunggah.',
            'dokumen_lpj.*.file' => 'File dokumen tidak valid.',
            'dokumen_lpj.*.mimes' => 'Format dokumen harus: pdf, doc, docx, xls, xlsx.',
            'dokumen_lpj.*.max' => 'Ukuran dokumen maksimal 10MB.',
        ]);

        // Cari atau buat parent kategori
        $parentCategory = $this->getOrCreateParentCategory();

        $data = [
            'parent_id' => $parentCategory->id,
            'nama_program' => $request->nama_program_kegiatan,
            'nama_kegiatan' => $request->jenis_kegiatan,
            'volume' => $request->volume,
            'jumlah_harga_satuan' => $request->jumlah_harga_satuan,
            'jumlah_harga' => $request->jumlah_harga,
            'keterangan_tambahan' => $request->keterangan_tambahan,
            'icon' => 'fas fa-clipboard-list'
        ];

        if ($request->hasFile('foto_jurnal')) {
            $fotoPaths = [];
            foreach ($request->file('foto_jurnal') as $file) {
                $path = $file->store('sekretariat/foto_jurnal', 'public');
                $fotoPaths[] = [
                    'path' => $path,
                    'original_name' => $file->getClientOriginalName(),
                ];
            }
            $data['foto_jurnal'] = $fotoPaths;
        }

        if ($request->hasFile('dokumen_lpj')) {
            $dokumenPaths = [];
            foreach ($request->file('dokumen_lpj') as $file) {
                $path = $file->store('sekretariat/dokumen_lpj', 'public');
                $dokumenPaths[] = [
                    'path' => $path,
                    'original_name' => $file->getClientOriginalName(),
                ];
            }
            $data['dokumen_lpj'] = $dokumenPaths;
        }

        Lpj::create($data);

        return redirect()->route('admin.laporan-lpj.sekretariat.index')
                         ->with('OK', 'Kegiatan berhasil ditambahkan.');
    }

    public function show($id)
    {
        $sekretariat = Lpj::where('parent_id', $this->getOrCreateParentCategory()->id)
                          ->findOrFail($id);
        return view('admin.laporan-lpj.sekretariat.show', compact('sekretariat'));
    }

    public function edit($id)
    {
        if (!auth()->user()->hasRole('superadmin')) {
            abort(403, 'Akses ditolak. Hanya superadmin yang dapat mengedit data.');
        }

        $sekretariat = Lpj::where('parent_id', $this->getOrCreateParentCategory()->id)
                          ->findOrFail($id);
        return view('admin.laporan-lpj.sekretariat.edit', compact('sekretariat'));
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
            'dokumen_lpj' => 'nullable|array|max:10',
            'dokumen_lpj.*' => 'file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
            'existing_foto_jurnal' => 'nullable|array',
            'existing_dokumen_lpj' => 'nullable|array',
            'deleted_fotos' => 'nullable|array',
            'deleted_dokumens' => 'nullable|array',
        ], [
            'foto_jurnal.max' => 'Maksimal 10 foto yang dapat diunggah.',
            'foto_jurnal.*.image' => 'File harus berupa gambar.',
            'foto_jurnal.*.mimes' => 'Format foto harus: jpeg, png, jpg, gif.',
            'foto_jurnal.*.max' => 'Ukuran foto maksimal 10MB.',
            'dokumen_lpj.max' => 'Maksimal 10 dokumen yang dapat diunggah.',
            'dokumen_lpj.*.file' => 'File dokumen tidak valid.',
            'dokumen_lpj.*.mimes' => 'Format dokumen harus: pdf, doc, docx, xls, xlsx.',
            'dokumen_lpj.*.max' => 'Ukuran dokumen maksimal 10MB.',
        ]);

        $data = [
            'nama_program' => $request->nama_program_kegiatan,
            'nama_kegiatan' => $request->jenis_kegiatan,
            'volume' => $request->volume,
            'jumlah_harga_satuan' => $request->jumlah_harga_satuan,
            'jumlah_harga' => $request->jumlah_harga,
            'keterangan_tambahan' => $request->keterangan_tambahan
        ];

        // Handle foto_jurnal
        $existingFotos = [];
        if ($request->existing_foto_jurnal) {
            foreach ($request->existing_foto_jurnal as $foto) {
                // Jika $foto adalah string (path langsung)
                if (is_string($foto)) {
                    $existingFotos[] = [
                        'path' => $foto,
                        'original_name' => basename($foto)
                    ];
                }
                // Jika $foto adalah array dengan struktur yang benar
                elseif (is_array($foto)) {
                    // Pastikan array memiliki key yang diperlukan
                    if (isset($foto['path'])) {
                        $existingFotos[] = [
                            'path' => $foto['path'],
                            'original_name' => $foto['original_name'] ?? basename($foto['path'])
                        ];
                    }
                }
            }
        }

        if ($request->hasFile('foto_jurnal')) {
            foreach ($request->file('foto_jurnal') as $file) {
                $path = $file->store('sekretariat/foto_jurnal', 'public');
                $existingFotos[] = [
                    'path' => $path,
                    'original_name' => $file->getClientOriginalName(),
                ];
            }
        }
        $data['foto_jurnal'] = !empty($existingFotos) ? $existingFotos : null;

        // Handle dokumen_lpj
        $existingDokumens = [];
        if ($request->existing_dokumen_lpj) {
            foreach ($request->existing_dokumen_lpj as $dokumen) {
                // Jika $dokumen adalah string (path langsung)
                if (is_string($dokumen)) {
                    $existingDokumens[] = [
                        'path' => $dokumen,
                        'original_name' => basename($dokumen)
                    ];
                }
                // Jika $dokumen adalah array dengan struktur yang benar
                elseif (is_array($dokumen)) {
                    // Pastikan array memiliki key yang diperlukan
                    if (isset($dokumen['path'])) {
                        $existingDokumens[] = [
                            'path' => $dokumen['path'],
                            'original_name' => $dokumen['original_name'] ?? basename($dokumen['path'])
                        ];
                    }
                }
            }
        }

        if ($request->hasFile('dokumen_lpj')) {
            foreach ($request->file('dokumen_lpj') as $file) {
                $path = $file->store('sekretariat/dokumen_lpj', 'public');
                $existingDokumens[] = [
                    'path' => $path,
                    'original_name' => $file->getClientOriginalName(),
                ];
            }
        }
        $data['dokumen_lpj'] = !empty($existingDokumens) ? $existingDokumens : null;

        $sekretariat->update($data);

        return redirect()->route('admin.laporan-lpj.sekretariat.index')
                         ->with('OK', 'Kegiatan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        if (!auth()->user()->hasRole('superadmin')) {
            return response()->json(['message' => 'Akses ditolak. Hanya superadmin yang dapat menghapus data.'], 403);
        }

        try {
            $sekretariat = Lpj::where('parent_id', $this->getOrCreateParentCategory()->id)
                              ->findOrFail($id);

            // Hapus file terkait
            if ($sekretariat->foto_jurnal) {
                foreach ($sekretariat->foto_jurnal as $foto) {
                    // Jika $foto adalah array dengan key 'path'
                    if (is_array($foto) && isset($foto['path'])) {
                        Storage::disk('public')->delete($foto['path']);
                    } 
                    // Jika $foto adalah string path
                    else if (is_string($foto)) {
                        Storage::disk('public')->delete($foto);
                    }
                }
            }

            if ($sekretariat->dokumen_lpj) {
                foreach ($sekretariat->dokumen_lpj as $dokumen) {
                    // Jika $dokumen adalah array dengan key 'path'
                    if (is_array($dokumen) && isset($dokumen['path'])) {
                        Storage::disk('public')->delete($dokumen['path']);
                    } 
                    // Jika $dokumen adalah string path
                    else if (is_string($dokumen)) {
                        Storage::disk('public')->delete($dokumen);
                    }
                }
            }

            $sekretariat->delete();

            return response()->json(['message' => 'Kegiatan berhasil dihapus.']);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Data tidak ditemukan.'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan saat menghapus data.'], 500);
        }
    }

    public function removeFile(Request $request, $id)
    {
        if (!auth()->user()->hasRole('superadmin')) {
            return response()->json(['error' => 'Akses ditolak'], 403);
        }

        $sekretariat = Lpj::where('parent_id', $this->getOrCreateParentCategory()->id)
                          ->findOrFail($id);

        $request->validate([
            'file_type' => 'required|in:foto_jurnal,dokumen_lpj',
            'file_index' => 'required|integer|min:0'
        ]);

        $fileType = $request->file_type;
        $fileIndex = $request->file_index;
        $files = $sekretariat->$fileType ?? [];

        if (!isset($files[$fileIndex])) {
            return response()->json(['error' => 'File tidak ditemukan'], 404);
        }

        $filePath = $files[$fileIndex];
        // Jika $filePath adalah array dengan key 'path'
        if (is_array($filePath) && isset($filePath['path'])) {
            Storage::disk('public')->delete($filePath['path']);
        } 
        // Jika $filePath adalah string path
        else if (is_string($filePath)) {
            Storage::disk('public')->delete($filePath);
        }

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
}
