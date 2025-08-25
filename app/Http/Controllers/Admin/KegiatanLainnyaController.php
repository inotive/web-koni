<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lpj;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class KegiatanLainnyaController extends Controller
{
    // Konstanta untuk mengidentifikasi jenis kegiatan lainnya
    const PARENT_CATEGORY = 'Kegiatan Lainnya';

    public function index(Request $request)
    {
        // Cari atau buat parent kategori Kegiatan Lainnya
        $parentCategory = $this->getOrCreateParentCategory();

        $perPage = $request->input('per_page', 10);
        $search = $request->input('search');
        $jenisKegiatanFilter = $request->input('jenis_kegiatan_filter');

        $sortBy = $request->input('sort_by', 'created_at');
        $sortOrder = $request->input('sort_order', 'desc');

        $query = Lpj::where('parent_id', $parentCategory->id);

        // Search
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->whereRaw('LOWER(nama_program) LIKE ?', ['%'.strtolower($search).'%'])
                  ->orWhereRaw('LOWER(nama_kegiatan) LIKE ?', ['%'.strtolower($search).'%'])
                  ->orWhereRaw('LOWER(volume) LIKE ?', ['%'.strtolower($search).'%']);
            });
        }

        // Filter jenis kegiatan
        if ($jenisKegiatanFilter) {
            $query->where('nama_kegiatan', $jenisKegiatanFilter);
        }

        // Validasi column sorting untuk prevent SQL injection
        $allowedSortColumns = ['nama_program', 'volume', 'jumlah_harga_satuan', 'jumlah_harga', 'created_at'];
        if (!in_array($sortBy, $allowedSortColumns)) {
            $sortBy = 'created_at';
        }

        // Sorting
        $query->orderBy($sortBy, $sortOrder);

        // Pagination dengan semua parameter
        $kegiatanLainnya = $query->paginate($perPage)->appends([
            'search' => $search,
            'jenis_kegiatan_filter' => $jenisKegiatanFilter,
            'sort_by' => $sortBy,
            'sort_order' => $sortOrder,
            'per_page' => $perPage
        ]);

        return view('admin.laporan-lpj.kegiatan_lainnya.index', compact('kegiatanLainnya'));
    }

    public function create()
    {
        return view('admin.laporan-lpj.kegiatan_lainnya.create');
    }

    public function store(Request $request)
    {
        // Custom validation messages
        $messages = [
            'nama_program_kegiatan.required' => 'Nama Program & Kegiatan wajib diisi.',
            'nama_program_kegiatan.unique' => 'Nama Program & Kegiatan sudah terdaftar. Silakan gunakan nama yang berbeda.',
            'nama_program_kegiatan.max' => 'Nama Program & Kegiatan maksimal 255 karakter.',
            'jenis_kegiatan.required' => 'Jenis Kegiatan wajib diisi.',
            'jenis_kegiatan.max' => 'Jenis Kegiatan maksimal 255 karakter.',
            'volume.required' => 'Volume wajib diisi.',
            'volume.max' => 'Volume maksimal 255 karakter.',
            'jumlah_harga_satuan.required' => 'Jumlah Harga Satuan wajib diisi.',
            'jumlah_harga_satuan.numeric' => 'Jumlah Harga Satuan harus berupa angka.',
            'jumlah_harga_satuan.min' => 'Jumlah Harga Satuan tidak boleh kurang dari 0.',
            'jumlah_harga.required' => 'Jumlah Harga wajib diisi.',
            'jumlah_harga.numeric' => 'Jumlah Harga harus berupa angka.',
            'jumlah_harga.min' => 'Jumlah Harga tidak boleh kurang dari 0.',
            'foto_jurnal.required' => 'Foto Jurnal wajib diunggah.',
            'foto_jurnal.image' => 'File Foto Jurnal harus berupa gambar.',
            'foto_jurnal.mimes' => 'Format Foto Jurnal harus: JPEG, PNG, JPG, GIF, atau WebP.',
            'foto_jurnal.max' => 'Ukuran Foto Jurnal maksimal 10MB.',
            'dokumen_pendukung.file' => 'File Dokumen Pendukung tidak valid.',
            'dokumen_pendukung.mimes' => 'Format Dokumen Pendukung harus: PDF, DOC, DOCX, XLS, atau XLSX.',
            'dokumen_pendukung.max' => 'Ukuran Dokumen Pendukung maksimal 10MB.',
            'keterangan_tambahan.max' => 'Keterangan Tambahan maksimal 500 karakter.',
        ];

        // Get parent category
        $parentCategory = $this->getOrCreateParentCategory();

        // Validation with custom messages
        $validated = $request->validate([
            'nama_program_kegiatan' => [
                'required',
                'string',
                'max:255',
                Rule::unique('lpj', 'nama_program')->where('parent_id', $parentCategory->id)
            ],
            'jenis_kegiatan' => 'required|string|max:255',
            'volume' => 'required|string|max:255',
            'jumlah_harga_satuan' => 'required|numeric|min:0',
            'jumlah_harga' => 'required|numeric|min:0',
            'foto_jurnal' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'dokumen_pendukung' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
            'keterangan_tambahan' => 'nullable|string|max:500'
        ], $messages);

        // Check for duplicate combination of program name and jenis kegiatan
        $existingData = Lpj::where('parent_id', $parentCategory->id)
            ->where('nama_program', $validated['nama_program_kegiatan'])
            ->where('nama_kegiatan', $validated['jenis_kegiatan'])
            ->first();

        if ($existingData) {
            return back()->withInput()->withErrors([
                'nama_program_kegiatan' => 'Kombinasi Nama Program & Jenis Kegiatan ini sudah ada dalam database.',
                'jenis_kegiatan' => 'Kombinasi Nama Program & Jenis Kegiatan ini sudah ada dalam database.'
            ]);
        }

        DB::beginTransaction();
        try {
            $data = [
                'parent_id' => $parentCategory->id,
                'nama_program' => $validated['nama_program_kegiatan'],
                'nama_kegiatan' => $validated['jenis_kegiatan'],
                'volume' => $validated['volume'],
                'jumlah_harga_satuan' => $validated['jumlah_harga_satuan'],
                'jumlah_harga' => $validated['jumlah_harga'],
                'keterangan_tambahan' => $validated['keterangan_tambahan'],
                'icon' => 'fas fa-tasks' // Default icon untuk Kegiatan Lainnya
            ];

            // Handle file uploads with better error handling
            if ($request->hasFile('foto_jurnal')) {
                if (!$request->file('foto_jurnal')->isValid()) {
                    throw new \Exception('File foto jurnal tidak valid atau corrupt.');
                }

                $fotoPath = $request->file('foto_jurnal')->store('kegiatan_lainnya/foto', 'public');

                if (!$fotoPath) {
                    throw new \Exception('Gagal mengunggah foto jurnal.');
                }

                $data['foto_jurnal'] = [$fotoPath]; // Array format untuk konsistensi
            }

            if ($request->hasFile('dokumen_pendukung')) {
                if (!$request->file('dokumen_pendukung')->isValid()) {
                    throw new \Exception('File dokumen pendukung tidak valid atau corrupt.');
                }

                $dokumenPath = $request->file('dokumen_pendukung')->store('kegiatan_lainnya/dokumen', 'public');

                if (!$dokumenPath) {
                    throw new \Exception('Gagal mengunggah dokumen pendukung.');
                }

                $data['dokumen_lpj'] = [$dokumenPath]; // Array format dan map ke dokumen_lpj
            }

            // Create the record
            $kegiatanLainnya = Lpj::create($data);

            if (!$kegiatanLainnya) {
                throw new \Exception('Gagal menyimpan data ke database.');
            }

            DB::commit();

            return redirect()->route('admin.laporan-lpj.kegiatan_lainnya.index')
                ->with('success', 'Data Kegiatan Lainnya berhasil ditambahkan!');

        } catch (\Exception $e) {
            DB::rollback();

            // Clean up uploaded files if any
            if (isset($fotoPath) && Storage::disk('public')->exists($fotoPath)) {
                Storage::disk('public')->delete($fotoPath);
            }
            if (isset($dokumenPath) && Storage::disk('public')->exists($dokumenPath)) {
                Storage::disk('public')->delete($dokumenPath);
            }

            return back()->withInput()
                ->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $parentCategory = $this->getOrCreateParentCategory();
        $kegiatan_lainnya = Lpj::where('parent_id', $parentCategory->id)->findOrFail($id);

        return view('admin.laporan-lpj.kegiatan_lainnya.edit', compact('kegiatan_lainnya'));
    }

    public function update(Request $request, $id)
    {
        $parentCategory = $this->getOrCreateParentCategory();
        $kegiatan_lainnya = Lpj::where('parent_id', $parentCategory->id)->findOrFail($id);

        // Custom validation messages for update
        $messages = [
            'nama_program_kegiatan.required' => 'Nama Program & Kegiatan wajib diisi.',
            'nama_program_kegiatan.unique' => 'Nama Program & Kegiatan sudah terdaftar. Silakan gunakan nama yang berbeda.',
            'nama_program_kegiatan.max' => 'Nama Program & Kegiatan maksimal 255 karakter.',
            'jenis_kegiatan.required' => 'Jenis Kegiatan wajib diisi.',
            'jenis_kegiatan.max' => 'Jenis Kegiatan maksimal 255 karakter.',
            'volume.required' => 'Volume wajib diisi.',
            'volume.max' => 'Volume maksimal 255 karakter.',
            'jumlah_harga_satuan.required' => 'Jumlah Harga Satuan wajib diisi.',
            'jumlah_harga_satuan.numeric' => 'Jumlah Harga Satuan harus berupa angka.',
            'jumlah_harga_satuan.min' => 'Jumlah Harga Satuan tidak boleh kurang dari 0.',
            'jumlah_harga.required' => 'Jumlah Harga wajib diisi.',
            'jumlah_harga.numeric' => 'Jumlah Harga harus berupa angka.',
            'jumlah_harga.min' => 'Jumlah Harga tidak boleh kurang dari 0.',
            'foto_jurnal.image' => 'File Foto Jurnal harus berupa gambar.',
            'foto_jurnal.mimes' => 'Format Foto Jurnal harus: JPEG, PNG, JPG, GIF, atau WebP.',
            'foto_jurnal.max' => 'Ukuran Foto Jurnal maksimal 10MB.',
            'dokumen_pendukung.file' => 'File Dokumen Pendukung tidak valid.',
            'dokumen_pendukung.mimes' => 'Format Dokumen Pendukung harus: PDF, DOC, DOCX, XLS, atau XLSX.',
            'dokumen_pendukung.max' => 'Ukuran Dokumen Pendukung maksimal 10MB.',
            'keterangan_tambahan.max' => 'Keterangan Tambahan maksimal 500 karakter.',
        ];

        $validated = $request->validate([
            'nama_program_kegiatan' => [
                'required',
                'string',
                'max:255',
                Rule::unique('lpj', 'nama_program')
                    ->where('parent_id', $parentCategory->id)
                    ->ignore($kegiatan_lainnya->id)
            ],
            'jenis_kegiatan' => 'required|string|max:255',
            'volume' => 'required|string|max:255',
            'jumlah_harga_satuan' => 'required|numeric|min:0',
            'jumlah_harga' => 'required|numeric|min:0',
            'foto_jurnal' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'dokumen_pendukung' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
            'keterangan_tambahan' => 'nullable|string|max:500'
        ], $messages);

        // Check for duplicate combination (excluding current record)
        $existingData = Lpj::where('parent_id', $parentCategory->id)
            ->where('nama_program', $validated['nama_program_kegiatan'])
            ->where('nama_kegiatan', $validated['jenis_kegiatan'])
            ->where('id', '!=', $kegiatan_lainnya->id)
            ->first();

        if ($existingData) {
            return back()->withInput()->withErrors([
                'nama_program_kegiatan' => 'Kombinasi Nama Program & Jenis Kegiatan ini sudah ada dalam database.',
                'jenis_kegiatan' => 'Kombinasi Nama Program & Jenis Kegiatan ini sudah ada dalam database.'
            ]);
        }

        DB::beginTransaction();
        try {
            $oldFotoJurnal = $kegiatan_lainnya->foto_jurnal;
            $oldDokumenLpj = $kegiatan_lainnya->dokumen_lpj;

            $data = [
                'nama_program' => $validated['nama_program_kegiatan'],
                'nama_kegiatan' => $validated['jenis_kegiatan'],
                'volume' => $validated['volume'],
                'jumlah_harga_satuan' => $validated['jumlah_harga_satuan'],
                'jumlah_harga' => $validated['jumlah_harga'],
                'keterangan_tambahan' => $validated['keterangan_tambahan']
            ];

            // Handle foto jurnal upload
            if ($request->hasFile('foto_jurnal')) {
                if (!$request->file('foto_jurnal')->isValid()) {
                    throw new \Exception('File foto jurnal tidak valid atau corrupt.');
                }

                $fotoPath = $request->file('foto_jurnal')->store('kegiatan_lainnya/foto', 'public');

                if (!$fotoPath) {
                    throw new \Exception('Gagal mengunggah foto jurnal baru.');
                }

                $data['foto_jurnal'] = [$fotoPath];
            }

            // Handle dokumen pendukung upload
            if ($request->hasFile('dokumen_pendukung')) {
                if (!$request->file('dokumen_pendukung')->isValid()) {
                    throw new \Exception('File dokumen pendukung tidak valid atau corrupt.');
                }

                $dokumenPath = $request->file('dokumen_pendukung')->store('kegiatan_lainnya/dokumen', 'public');

                if (!$dokumenPath) {
                    throw new \Exception('Gagal mengunggah dokumen pendukung baru.');
                }

                $data['dokumen_lpj'] = [$dokumenPath];
            }

            // Update the record
            $updated = $kegiatan_lainnya->update($data);

            if (!$updated) {
                throw new \Exception('Gagal memperbarui data di database.');
            }

            // Delete old files only after successful update and if new files were uploaded
            if ($request->hasFile('foto_jurnal') && $oldFotoJurnal && is_array($oldFotoJurnal)) {
                foreach ($oldFotoJurnal as $oldFoto) {
                    Storage::disk('public')->delete($oldFoto);
                }
            }

            if ($request->hasFile('dokumen_pendukung') && $oldDokumenLpj && is_array($oldDokumenLpj)) {
                foreach ($oldDokumenLpj as $oldDokumen) {
                    Storage::disk('public')->delete($oldDokumen);
                }
            }

            DB::commit();

            return redirect()->route('admin.laporan-lpj.kegiatan_lainnya.index')
                     ->with('success', 'Data berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollback();

            // Clean up newly uploaded files if any
            if (isset($fotoPath) && Storage::disk('public')->exists($fotoPath)) {
                Storage::disk('public')->delete($fotoPath);
            }
            if (isset($dokumenPath) && Storage::disk('public')->exists($dokumenPath)) {
                Storage::disk('public')->delete($dokumenPath);
            }

            return back()->withInput()
                ->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $parentCategory = $this->getOrCreateParentCategory();
        $kegiatan = Lpj::where('parent_id', $parentCategory->id)->findOrFail($id);
        return view('admin.laporan-lpj.kegiatan_lainnya.detail', compact('kegiatan'));
    }

    public function destroy($id)
    {
        $parentCategory = $this->getOrCreateParentCategory();
        $kegiatan_lainnya = Lpj::where('parent_id', $parentCategory->id)->findOrFail($id);

        DB::beginTransaction();
        try {
            // Store file paths before deletion
            $fotoJurnal = $kegiatan_lainnya->foto_jurnal;
            $dokumenLpj = $kegiatan_lainnya->dokumen_lpj;

            // Delete the record first
            $deleted = $kegiatan_lainnya->delete();

            if (!$deleted) {
                throw new \Exception('Gagal menghapus data dari database.');
            }

            // Delete associated files only after successful database deletion
            if ($fotoJurnal && is_array($fotoJurnal)) {
                foreach ($fotoJurnal as $foto) {
                    if (Storage::disk('public')->exists($foto)) {
                        Storage::disk('public')->delete($foto);
                    }
                }
            }

            if ($dokumenLpj && is_array($dokumenLpj)) {
                foreach ($dokumenLpj as $dokumen) {
                    if (Storage::disk('public')->exists($dokumen)) {
                        Storage::disk('public')->delete($dokumen);
                    }
                }
            }

            DB::commit();

            return redirect()->route('admin.laporan-lpj.kegiatan_lainnya.index')
                ->with('success', 'Data Kegiatan Lainnya berhasil dihapus!');

        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->route('admin.laporan-lpj.kegiatan_lainnya.index')
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    public function export(Request $request)
    {
        try {
            $parentCategory = $this->getOrCreateParentCategory();
            $query = Lpj::where('parent_id', $parentCategory->id);

            // Filter pencarian
            if ($request->has('search') && !empty($request->input('search'))) {
                $search = $request->input('search');
                $query->where(function($q) use ($search) {
                    $q->whereRaw('LOWER(nama_program) LIKE ?', ['%'.strtolower($search).'%'])
                      ->orWhereRaw('LOWER(nama_kegiatan) LIKE ?', ['%'.strtolower($search).'%'])
                      ->orWhereRaw('LOWER(volume) LIKE ?', ['%'.strtolower($search).'%']);
                });
            }

            // Filter jenis kegiatan
            if ($request->has('jenis_kegiatan_filter') && !empty($request->input('jenis_kegiatan_filter'))) {
                $query->where('nama_kegiatan', $request->input('jenis_kegiatan_filter'));
            }

            $data = $query->orderBy('created_at', 'desc')->get();

            if ($data->isEmpty()) {
                return redirect()->back()->with('error', 'Tidak ada data untuk di-export');
            }

            $viewPath = 'admin.laporan-lpj.kegiatan_lainnya.export';
            if (!view()->exists($viewPath)) {
                return redirect()->back()->with('error', 'Template export tidak ditemukan');
            }

            $filename = 'LPJ_Kegiatan_Lainnya_' . now()->format('Ymd_His') . '.pdf';

            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView($viewPath, [
                'data' => $data,
                'title' => 'Laporan Pertanggungjawaban Kegiatan Lainnya'
            ]);

            return $pdf->download($filename);

        } catch (\Exception $e) {
            Log::error('Export Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mengexport data: ' . $e->getMessage());
        }
    }

    public function getDetail($id)
    {
        try {
            if (!is_numeric($id) || $id <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'ID tidak valid atau tidak ditemukan'
                ], 400);
            }

            $parentCategory = $this->getOrCreateParentCategory();
            $kegiatan = Lpj::where('parent_id', $parentCategory->id)->find($id);

            if (!$kegiatan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data kegiatan dengan ID ' . $id . ' tidak ditemukan'
                ], 404);
            }

            // Validasi file paths dan convert ke URL yang benar
            $fotoJurnalUrl = null;
            $dokumenPendukungUrl = null;
            $dokumenInfo = null;

            // Cek dan validasi foto jurnal
            if ($kegiatan->foto_jurnal && is_array($kegiatan->foto_jurnal) && !empty($kegiatan->foto_jurnal)) {
                $fotoPath = 'storage/' . $kegiatan->foto_jurnal[0]; // Ambil foto pertama
                if (file_exists(public_path($fotoPath))) {
                    $fotoJurnalUrl = asset($fotoPath);
                }
            }

            // Cek dan validasi dokumen pendukung
            if ($kegiatan->dokumen_lpj && is_array($kegiatan->dokumen_lpj) && !empty($kegiatan->dokumen_lpj)) {
                $dokumenPath = 'storage/' . $kegiatan->dokumen_lpj[0]; // Ambil dokumen pertama
                if (file_exists(public_path($dokumenPath))) {
                    $dokumenPendukungUrl = asset($dokumenPath);

                    $pathInfo = pathinfo($kegiatan->dokumen_lpj[0]);
                    $fileExtension = strtolower($pathInfo['extension'] ?? '');
                    $fileName = $pathInfo['filename'] ?? 'Dokumen';

                    $iconClass = match($fileExtension) {
                        'pdf' => 'fas fa-file-pdf text-danger',
                        'doc', 'docx' => 'fas fa-file-word text-primary',
                        'xls', 'xlsx' => 'fas fa-file-excel text-success',
                        'ppt', 'pptx' => 'fas fa-file-powerpoint text-warning',
                        'txt' => 'fas fa-file-alt text-secondary',
                        'zip', 'rar' => 'fas fa-file-archive text-info',
                        default => 'fas fa-file text-secondary'
                    };

                    $dokumenInfo = [
                        'url' => $dokumenPendukungUrl,
                        'fileName' => $fileName,
                        'extension' => strtoupper($fileExtension),
                        'iconClass' => $iconClass,
                        'originalName' => $pathInfo['basename'] ?? 'dokumen.' . $fileExtension
                    ];
                }
            }

            $kegiatanData = [
                'id' => $kegiatan->id,
                'nama_program_kegiatan' => $kegiatan->nama_program, // Map dari nama_program
                'jenis_kegiatan' => $kegiatan->nama_kegiatan, // Map dari nama_kegiatan
                'volume' => $kegiatan->volume,
                'jumlah_harga_satuan' => $kegiatan->jumlah_harga_satuan,
                'jumlah_harga' => $kegiatan->jumlah_harga,
                'keterangan_tambahan' => $kegiatan->keterangan_tambahan,
                'created_at' => $kegiatan->created_at,
                'updated_at' => $kegiatan->updated_at,
                'foto_jurnal_url' => $fotoJurnalUrl,
                'dokumen_info' => $dokumenInfo
            ];

            $viewPath = 'admin.laporan-lpj.kegiatan_lainnya.detail-ajax';
            if (!view()->exists($viewPath)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Template detail tidak ditemukan. Silakan hubungi administrator.'
                ], 500);
            }

            $html = view($viewPath, ['kegiatan' => (object) $kegiatanData])->render();

            return response()->json([
                'success' => true,
                'html' => $html,
                'data' => [
                    'id' => $kegiatan->id,
                    'nama_program_kegiatan' => $kegiatan->nama_program,
                    'export_url' => route('admin.laporan-lpj.kegiatan_lainnya.export', ['id' => $kegiatan->id])
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error in getDetail method: ' . $e->getMessage(), [
                'id' => $id,
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mendapatkan atau membuat parent kategori untuk Kegiatan Lainnya
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
                'icon' => 'fas fa-tasks'
            ]
        );
    }
}
