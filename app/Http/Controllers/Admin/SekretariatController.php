<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lpj;
use App\Models\Pengajuan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use setasign\Fpdi\Fpdi;
use setasign\Fpdi\PdfParser\StreamReader;
use setasign\Fpdi\PdfReader\PageBoundaries;

class SekretariatController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:laporan-lpj-sekretariat');
    }

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
            ->select(['*', 'modifiable_by_user_id']) // Pastikan field modifiable_by_user_id selalu diambil
            ->orderBy($sort, $direction)
            ->paginate($request->get('per_page', 10));

        // Get total budget and kegiatan count for sekretariat
        $current_budget = Lpj::where('parent_id', $parentCategory->id)->sum('jumlah_harga');
        $kegiatan_count = Lpj::where('parent_id', $parentCategory->id)->count();
        $target = \App\Models\Target::where('id_lpj', $parentCategory->id)->first();
        $target_anggaran = $target->target_anggaran ?? 0;
        $target_kegiatan = $target->target_kegiatan ?? 0;

        if ($request->ajax()) {
            return view('admin.laporan-lpj.sekretariat._table', compact('kegiatanLainnya'))->render();
        }

        return view('admin.laporan-lpj.sekretariat.index', compact(
            'kegiatanLainnya', 
            'current_budget', 
            'kegiatan_count', 
            'target_anggaran', 
            'target_kegiatan',
            'parentCategory'
        ));
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
            'volume' => 'nullable|string|max:255',
            'jumlah_harga_satuan' => 'nullable|numeric|min:0',
            'jumlah_harga' => 'required|numeric|min:0',
            'foto_jurnal' => 'nullable|array',
            'foto_jurnal.*' => 'image|mimes:jpeg,png,jpg,gif|max:10240',
            'dokumen_lpj' => 'nullable|array',
            'dokumen_lpj.*' => 'file|mimes:pdf|max:10240',
            'dokumen_lpj_pdf' => 'required|file|mimes:pdf|max:10240',
        ], [
            'foto_jurnal.*.image' => 'File harus berupa gambar.',
            'foto_jurnal.*.mimes' => 'Format foto harus: jpeg, png, jpg, gif.',
            'foto_jurnal.*.max' => 'Ukuran foto maksimal 10MB.',
            'dokumen_lpj.*.file' => 'File dokumen tidak valid.',
            'dokumen_lpj.*.mimes' => 'Format dokumen harus PDF.',
            'dokumen_lpj.*.max' => 'Ukuran dokumen maksimal 10MB.',
            'dokumen_lpj_pdf.required' => 'Dokumen LPJ PDF wajib diunggah.',
            'dokumen_lpj_pdf.file' => 'File Dokumen LPJ PDF tidak valid.',
            'dokumen_lpj_pdf.mimes' => 'Format Dokumen LPJ PDF harus PDF.',
            'dokumen_lpj_pdf.max' => 'Ukuran Dokumen LPJ PDF maksimal 10MB.',
        ]);

        // Cari atau buat parent kategori
        $parentCategory = $this->getOrCreateParentCategory();

        $data = [
            'parent_id' => $parentCategory->id,
            'nama_program' => $request->nama_program_kegiatan,
            'nama_kegiatan' => $request->jenis_kegiatan,
            'volume' => $request->volume ?? '',
            'jumlah_harga_satuan' => $request->jumlah_harga_satuan ?? 0,
            'jumlah_harga' => $request->jumlah_harga,
            'keterangan_tambahan' => $request->keterangan_tambahan,
            'icon' => 'fas fa-clipboard-list'
        ];

        // Handle foto_jurnal dengan nama asli
        if ($request->hasFile('foto_jurnal')) {
            $fotoPaths = [];
            foreach ($request->file('foto_jurnal') as $file) {
                // Gunakan nama asli file
                $originalName = $file->getClientOriginalName();
                $path = $file->storeAs('sekretariat/foto_jurnal', $originalName, 'public');
                $fotoPaths[] = [
                    'path' => $path,
                    'original_name' => $originalName,
                ];
            }
            $data['foto_jurnal'] = $fotoPaths;
        }

        // Handle dokumen_lpj dengan nama asli
        if ($request->hasFile('dokumen_lpj')) {
            $dokumenPaths = [];
            foreach ($request->file('dokumen_lpj') as $file) {
                // Gunakan nama asli file
                $originalName = $file->getClientOriginalName();
                $path = $file->storeAs('sekretariat/dokumen_lpj', $originalName, 'public');
                $dokumenPaths[] = [
                    'path' => $path,
                    'original_name' => $originalName,
                ];
            }
            $data['dokumen_lpj'] = $dokumenPaths;
        }

        // Handle dokumen_lpj_pdf
        if ($request->hasFile('dokumen_lpj_pdf')) {
            $file = $request->file('dokumen_lpj_pdf');
            $originalName = $file->getClientOriginalName();
            $path = $file->storeAs('sekretariat/dokumen_lpj_pdf', $originalName, 'public');
            $data['dokumen_lpj_pdf'] = [
                'path' => $path,
                'original_name' => $originalName,
            ];
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
        $sekretariat = Lpj::where('parent_id', $this->getOrCreateParentCategory()->id)
                          ->findOrFail($id);

        // Cek apakah user adalah superadmin atau memiliki izin modifikasi
        if (!auth()->user()->hasRole('superadmin') && 
            (!isset($sekretariat->modifiable_by_user_id) || 
             auth()->user()->id != $sekretariat->modifiable_by_user_id)) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk mengedit data ini.');
        }

        return view('admin.laporan-lpj.sekretariat.edit', compact('sekretariat'));
    }

    public function update(Request $request, $id)
    {
        $sekretariat = Lpj::where('parent_id', $this->getOrCreateParentCategory()->id)
                          ->findOrFail($id);

        // Cek apakah user adalah superadmin atau memiliki izin modifikasi
        if (!auth()->user()->hasRole('superadmin') && 
            (!isset($sekretariat->modifiable_by_user_id) || 
             auth()->user()->id != $sekretariat->modifiable_by_user_id)) {
            return response()->json([
                'message' => 'Akses ditolak. Anda tidak memiliki izin untuk memperbarui data ini.'
            ], 403);
        }

        $rules = [
            'nama_program_kegiatan' => 'required|string|max:255',
            'jenis_kegiatan' => 'required|string|max:255',
            'keterangan_tambahan' => 'nullable|string',
            'volume' => 'nullable|string|max:255',
            'jumlah_harga_satuan' => 'nullable|numeric|min:0',
            'jumlah_harga' => 'required|numeric|min:0',
            'foto_jurnal' => 'nullable|array',
            'foto_jurnal.*' => 'image|mimes:jpeg,png,jpg,gif|max:10240',
            'dokumen_lpj' => 'nullable|array',
            'dokumen_lpj.*' => 'file|mimes:pdf|max:10240',
            'existing_foto_jurnal' => 'nullable|array',
            'existing_dokumen_lpj' => 'nullable|array',
            'deleted_fotos' => 'nullable|array',
            'deleted_dokumens' => 'nullable|array',
        ];

        $dokumenLpjExists = $sekretariat->dokumen_lpj_pdf && !$request->has('deleted_dokumen_lpj_pdf');

        if (!$dokumenLpjExists && !$request->hasFile('dokumen_lpj_pdf')) {
            $rules['dokumen_lpj_pdf'] = 'required|file|mimes:pdf|max:10240';
        } else {
            $rules['dokumen_lpj_pdf'] = 'nullable|file|mimes:pdf|max:10240';
        }

        $request->validate($rules, [
            'foto_jurnal.*.image' => 'File harus berupa gambar.',
            'foto_jurnal.*.mimes' => 'Format foto harus: jpeg, png, jpg, gif.',
            'foto_jurnal.*.max' => 'Ukuran foto maksimal 10MB.',
            'dokumen_lpj.*.file' => 'File dokumen tidak valid.',
            'dokumen_lpj.*.mimes' => 'Format dokumen harus PDF.',
            'dokumen_lpj.*.max' => 'Ukuran dokumen maksimal 10MB.',
            'dokumen_lpj_pdf.required' => 'Dokumen LPJ PDF wajib diunggah.',
            'dokumen_lpj_pdf.file' => 'File Dokumen LPJ PDF tidak valid.',
            'dokumen_lpj_pdf.mimes' => 'Format Dokumen LPJ PDF harus PDF.',
            'dokumen_lpj_pdf.max' => 'Ukuran Dokumen LPJ PDF maksimal 10MB.',
        ]);

        $data = [
            'nama_program' => $request->nama_program_kegiatan,
            'nama_kegiatan' => $request->jenis_kegiatan,
            'volume' => $request->volume ?? '',
            'jumlah_harga_satuan' => $request->jumlah_harga_satuan ?? 0,
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
                // Gunakan nama asli file
                $originalName = $file->getClientOriginalName();
                // Cek jika file dengan nama yang sama sudah ada, tambahkan timestamp jika perlu
                $path = 'sekretariat/foto_jurnal/' . $originalName;
                if (Storage::disk('public')->exists($path)) {
                    $filename = pathinfo($originalName, PATHINFO_FILENAME);
                    $extension = $file->getClientOriginalExtension();
                    $timestamp = time();
                    $originalName = $filename . '_' . $timestamp . '.' . $extension;
                }
                $path = $file->storeAs('sekretariat/foto_jurnal', $originalName, 'public');
                $existingFotos[] = [
                    'path' => $path,
                    'original_name' => $originalName,
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
                // Gunakan nama asli file
                $originalName = $file->getClientOriginalName();
                // Cek jika file dengan nama yang sama sudah ada, tambahkan timestamp jika perlu
                $path = 'sekretariat/dokumen_lpj/' . $originalName;
                if (Storage::disk('public')->exists($path)) {
                    $filename = pathinfo($originalName, PATHINFO_FILENAME);
                    $extension = $file->getClientOriginalExtension();
                    $timestamp = time();
                    $originalName = $filename . '_' . $timestamp . '.' . $extension;
                }
                $path = $file->storeAs('sekretariat/dokumen_lpj', $originalName, 'public');
                $existingDokumens[] = [
                    'path' => $path,
                    'original_name' => $originalName,
                ];
            }
        }
        $data['dokumen_lpj'] = !empty($existingDokumens) ? $existingDokumens : null;

        // Handle dokumen_lpj_pdf
        if ($request->hasFile('dokumen_lpj_pdf')) {
            $file = $request->file('dokumen_lpj_pdf');
            $originalName = $file->getClientOriginalName();
            // Cek jika file dengan nama yang sama sudah ada, tambahkan timestamp jika perlu
            $path = 'sekretariat/dokumen_lpj_pdf/' . $originalName;
            if (Storage::disk('public')->exists($path)) {
                $filename = pathinfo($originalName, PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $timestamp = time();
                $originalName = $filename . '_' . $timestamp . '.' . $extension;
            }
            $path = $file->storeAs('sekretariat/dokumen_lpj_pdf', $originalName, 'public');
            $data['dokumen_lpj_pdf'] = [
                'path' => $path,
                'original_name' => $originalName,
            ];
        } else if ($request->has('existing_dokumen_lpj_pdf')) {
            // Keep existing dokumen_lpj_pdf if no new file was uploaded
            $data['dokumen_lpj_pdf'] = $sekretariat->dokumen_lpj_pdf;
        } else if ($request->has('deleted_dokumen_lpj_pdf')) {
            // Delete the file if marked for deletion
            if ($sekretariat->dokumen_lpj_pdf && isset($sekretariat->dokumen_lpj_pdf['path'])) {
                Storage::disk('public')->delete($sekretariat->dokumen_lpj_pdf['path']);
            }
            $data['dokumen_lpj_pdf'] = null;
        }

        $sekretariat->update($data);

        // Jika yang mengedit bukan superadmin/admin dengan permission, konsumsi token
        if (!auth()->user()->hasRole('superadmin') && !auth()->user()->can('pengajuan-modifikasi-laporan')) {
            $pengajuan = Pengajuan::where('lpj_id', $sekretariat->id)
                ->where('status', 'disetujui')
                ->where('token', '>', 0)
                ->orderBy('approved_at', 'desc')
                ->first();

            if ($pengajuan) {
                $pengajuan->update(['token' => 0]);
            }
            
            // Set modifiable_by_user_id to null after editing
            $sekretariat->update(['modifiable_by_user_id' => null]);
        }

        return redirect()->route('admin.laporan-lpj.sekretariat.index')
                         ->with('OK', 'Kegiatan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $sekretariat = Lpj::where('parent_id', $this->getOrCreateParentCategory()->id)
                          ->findOrFail($id);

        // Cek apakah user adalah superadmin atau memiliki izin modifikasi
        if (!auth()->user()->hasRole('superadmin') && 
            (!isset($sekretariat->modifiable_by_user_id) || 
             auth()->user()->id != $sekretariat->modifiable_by_user_id)) {
            return response()->json([
                'message' => 'Akses ditolak. Anda tidak memiliki izin untuk menghapus data ini.'
            ], 403);
        }

        try {
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

            // Hapus dokumen_lpj_pdf jika ada
            if ($sekretariat->dokumen_lpj_pdf && isset($sekretariat->dokumen_lpj_pdf['path'])) {
                Storage::disk('public')->delete($sekretariat->dokumen_lpj_pdf['path']);
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
        $sekretariat = Lpj::where('parent_id', $this->getOrCreateParentCategory()->id)
                          ->findOrFail($id);

        // Cek apakah user adalah superadmin atau memiliki izin modifikasi
        if (!auth()->user()->hasRole('superadmin') && 
            (!isset($sekretariat->modifiable_by_user_id) || 
             auth()->user()->id != $sekretariat->modifiable_by_user_id)) {
            return response()->json(['error' => 'Akses ditolak'], 403);
        }

        $request->validate([
            'file_type' => 'required|in:foto_jurnal,dokumen_lpj,dokumen_lpj_pdf',
            'file_index' => 'required|integer|min:0'
        ]);

        $fileType = $request->file_type;
        $fileIndex = $request->file_index;
        $files = $sekretariat->$fileType ?? [];

        if ($fileType === 'dokumen_lpj_pdf') {
            // Handle dokumen_lpj_pdf (single file, not array)
            if ($sekretariat->dokumen_lpj_pdf && isset($sekretariat->dokumen_lpj_pdf['path'])) {
                Storage::disk('public')->delete($sekretariat->dokumen_lpj_pdf['path']);
                $sekretariat->update(['dokumen_lpj_pdf' => null]);
                return response()->json([
                    'success' => true,
                    'message' => 'File berhasil dihapus',
                    'remaining_files' => 0
                ]);
            } else {
                return response()->json(['error' => 'File tidak ditemukan'], 404);
            }
        } else {
            // Handle array files (foto_jurnal, dokumen_lpj)
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

    /**
     * Export laporan sekretariat ke PDF dengan kop surat
     */
    public function export($id)
    {
        try {
            $sekretariat = Lpj::where('parent_id', $this->getOrCreateParentCategory()->id)
                              ->findOrFail($id);

            // Create initial PDF with letterhead and content
            $pdf = Pdf::loadView('admin.laporan-lpj.sekretariat.export', compact('sekretariat'));
            $pdf->setPaper('A4', 'portrait');

            // Generate initial PDF content
            $tempMainFile = tempnam(sys_get_temp_dir(), 'main_pdf_');
            file_put_contents($tempMainFile, $pdf->output());

            // Initialize FPDI for PDF merging
            $fpdi = new Fpdi();

            // Add main content pages
            $pageCount = $fpdi->setSourceFile($tempMainFile);
            for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                $templateId = $fpdi->importPage($pageNo, PageBoundaries::MEDIA_BOX);
                $fpdi->AddPage();
                $fpdi->useTemplate($templateId);
            }

            // Collect all PDF documents
            $pdfFiles = [];
            if ($sekretariat->dokumen_lpj && is_array($sekretariat->dokumen_lpj)) {
                foreach ($sekretariat->dokumen_lpj as $dokumen) {
                    $path = is_array($dokumen) ? ($dokumen['path'] ?? null) : (is_string($dokumen) ? $dokumen : null);
                    if ($path && strtolower(pathinfo($path, PATHINFO_EXTENSION)) === 'pdf') {
                        $pdfFiles[] = $path;
                    }
                }
            }
            if ($sekretariat->dokumen_lpj_pdf) {
                 $path = is_array($sekretariat->dokumen_lpj_pdf) ? ($sekretariat->dokumen_lpj_pdf['path'] ?? null) : (is_string($sekretariat->dokumen_lpj_pdf) ? $sekretariat->dokumen_lpj_pdf : null);
                if ($path) {
                    $pdfFiles[] = $path;
                }
            }
            
            // Merge PDF attachments
            foreach ($pdfFiles as $pdfFile) {
                $filePath = storage_path('app/public/' . $pdfFile);

                if (file_exists($filePath)) {
                    try {
                        $attachmentPageCount = $fpdi->setSourceFile($filePath);
                        for ($pageNo = 1; $pageNo <= $attachmentPageCount; $pageNo++) {
                            $templateId = $fpdi->importPage($pageNo, PageBoundaries::MEDIA_BOX);
                            $fpdi->AddPage();
                            $fpdi->useTemplate($templateId);
                        }
                    } catch (\Exception $e) {
                        \Log::warning("Could not merge PDF file: {$pdfFile}. Error: " . $e->getMessage());
                    }
                }
            }

            // Clean up temporary file
            unlink($tempMainFile);

            // Generate final PDF
            $finalPdf = $fpdi->Output('S');

            // Generate filename
            $filename = 'Laporan_Sekretariat_' . Str::slug($sekretariat->nama_program) . '_' . date('Y-m-d') . '.pdf';

            return response($finalPdf, 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ]);

        } catch (\Exception $e) {
            \Log::error('Error exporting PDF for Sekretariat: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal membuat laporan PDF. Terjadi kesalahan.');
        }
    }

    /**
     * Update target anggaran and kegiatan for sekretariat
     */
    public function updateTarget(Request $request)
    {
        $request->validate([
            'target_anggaran' => 'required|numeric|min:0',
            'target_kegiatan' => 'required|integer|min:0',
        ]);

        try {
            $parentCategory = $this->getOrCreateParentCategory();
            
            $target = \App\Models\Target::updateOrCreate(
                ['id_lpj' => $parentCategory->id],
                [
                    'target_anggaran' => $request->target_anggaran,
                    'target_kegiatan' => $request->target_kegiatan,
                ]
            );

            return response()->json([
                'success' => true,
                'message' => 'Target berhasil diperbarui.',
                'target' => $target
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui target: ' . $e->getMessage()
            ], 500);
        }
    }
}
