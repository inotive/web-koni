<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FileKesekretariat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Illuminate\Support\Facades\Cache;

class FileKesekretariatController extends Controller
{
    /**
     * Display a listing of the resource.
     * Fetches all files, ordered by the latest first.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        // Create cache key based on request parameters
        $cacheKey = 'file_kesekretariat_' . md5(serialize($request->query()));
        
        // Start with a base query for all files
        $query = FileKesekretariat::query();

        // Handle the search functionality
        if ($request->filled('search')) {
            $searchTerm = trim($request->input('search'));
            $query->where('nama_dokumen', 'like', '%' . $searchTerm . '%');
        }

        // Handle the file type filter
        if ($request->filled('file_type')) {
            $fileType = $request->input('file_type');
            // Filter by file extension (more precise matching)
            $query->where('dokumen_file', 'like', '%.' . $fileType);
        }

        // Apply sorting with validation
        $allowedSortColumns = ['nama_dokumen', 'created_at', 'updated_at'];
        $sortBy = $request->get('sort_by', 'created_at');
        $order = $request->get('order', 'desc');
        
        // Validate sort parameters
        if (!in_array($sortBy, $allowedSortColumns)) {
            $sortBy = 'created_at';
        }
        
        if (!in_array($order, ['asc', 'desc'])) {
            $order = 'desc';
        }

        // Apply sorting - prioritize latest data by default
        $query->orderBy($sortBy, $order);
        
        // Add secondary sort by ID for consistent ordering (prevent duplicates)
        if ($sortBy !== 'created_at') {
            $query->orderBy('created_at', 'desc');
        }
        $query->orderBy('id', 'desc');

        // Pagination settings with validation
        $perPage = $this->getValidPerPage($request->input('per_page'));
        
        // Execute query with pagination
        $files = $query->paginate($perPage)
                ->withQueryString()
                ->through(function ($file) {
                    $file->path = 'documents/' . $file->dokumen_file;
                    $file->file_exists = Storage::disk('public')->exists($file->path);
                    $file->file_size = $file->file_exists 
                        ? $this->formatFileSize(Storage::disk('public')->size($file->path))
                        : '0 KB';
                    $file->file_extension = pathinfo($file->dokumen_file, PATHINFO_EXTENSION);
                    return $file;
                });

        // If AJAX request, return only table partial
        if ($request->ajax() || $request->wantsJson()) {
            return view('admin.file-kesekretariat._table', compact('files'));
        }

        return view('admin.file-kesekretariat.index', compact('files'));
    }

    /**
     * Validate and return proper per_page value
     */
    protected function getValidPerPage($inputPerPage): int
    {
        $allowedPerPage = [10, 20, 30, 40, 50];
        $perPage = (int) ($inputPerPage ?? session('per_page', 10));
        
        return in_array($perPage, $allowedPerPage) ? $perPage : 10;
    }

    /**
     * Format file size to human readable format
     */
    protected function formatFileSize($bytes): string
    {
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            return $bytes . ' bytes';
        } elseif ($bytes == 1) {
            return '1 byte';
        } else {
            return '0 bytes';
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.file-kesekretariat.create');
    }

    /**
     * Store a newly created resource in storage and database.
     */
    public function store(Request $request)
    {
        // Log request untuk debug
        Log::info('Store request received', [
            'has_file' => $request->hasFile('dokumen_file'),
            'nama_dokumen' => $request->input('nama_dokumen'),
            'tanggal_dokumen' => $request->input('tanggal_dokumen'),
            'all_files' => $request->allFiles()
        ]);

        // Validasi input
        $validated = $request->validate([
            'nama_dokumen' => 'required|string|max:255',
            'tanggal_dokumen' => 'required|date',
            'dokumen_file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx|max:10240', // 10MB max
        ], [
            'nama_dokumen.required' => 'Nama dokumen harus diisi.',
            'nama_dokumen.max' => 'Nama dokumen maksimal 255 karakter.',
            'tanggal_dokumen.required' => 'Tanggal dokumen harus diisi.',
            'tanggal_dokumen.date' => 'Format tanggal tidak valid.',
            'dokumen_file.required' => 'File dokumen harus diupload.',
            'dokumen_file.file' => 'File dokumen tidak valid.',
            'dokumen_file.mimes' => 'File harus berformat PDF, DOC, DOCX, XLS, atau XLSX.',
            'dokumen_file.max' => 'Ukuran file maksimal 10MB.',
        ]);

        try {
            // Pastikan directory ada
            $documentsPath = storage_path('app/public/documents');
            if (!is_dir($documentsPath)) {
                mkdir($documentsPath, 0755, true);
                Log::info('Created documents directory: ' . $documentsPath);
            }

            $file = $request->file('dokumen_file');
            
            // Buat nama file yang unik
            $originalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $fileName = time() . '_' . uniqid() . '.' . $extension;
            
            Log::info('File upload attempt', [
                'original_name' => $originalName,
                'new_name' => $fileName,
                'size' => $file->getSize(),
                'mime_type' => $file->getMimeType()
            ]);

            // Simpan file
            $path = $file->storeAs('documents', $fileName, 'public');
            
            if (!$path) {
                throw new \Exception('Gagal menyimpan file ke storage');
            }

            Log::info('File stored successfully', ['path' => $path]);

            // Simpan ke database
            $fileRecord = FileKesekretariat::create([
                'nama_dokumen' => $validated['nama_dokumen'],
                'tanggal_dokumen' => $validated['tanggal_dokumen'],
                'dokumen_file' => $fileName,
            ]);

            Log::info('Database record created', ['id' => $fileRecord->id]);

            // Response untuk AJAX
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'File berhasil ditambahkan.',
                    'data' => $fileRecord
                ]);
            }

            return redirect()
                ->route('admin.file-kesekretariat.index')
                ->with('success', 'File berhasil ditambahkan.');

        } catch (\Exception $e) {
            Log::error('Error storing file', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menyimpan file: ' . $e->getMessage(),
                    'errors' => []
                ], 500);
            }

            return back()
                ->withInput()
                ->with('error', 'Gagal menyimpan file: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(FileKesekretariat $fileKesekretariat): View
    {
        // Perbaikan untuk method url()
        $fileUrl = Storage::disk('public')->exists('documents/' . $fileKesekretariat->dokumen_file)
            ? Storage::url('documents/' . $fileKesekretariat->dokumen_file)
            : null;

        return view('admin.file-kesekretariat.show', [
            'file' => $fileKesekretariat,
            'file_path' => $fileUrl,
            'file_size' => $this->formatFileSize(
                Storage::disk('public')->size('documents/' . $fileKesekretariat->dokumen_file)
            ),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FileKesekretariat $fileKesekretariat): View
    {
        return view('admin.file-kesekretariat.edit', [
            'file' => $fileKesekretariat,
            'fileKesekretariat' => $fileKesekretariat,
            'current_file_size' => $this->formatFileSize(
                Storage::disk('public')->size('documents/' . $fileKesekretariat->dokumen_file)
            ),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FileKesekretariat $fileKesekretariat)
    {
        // Validasi
        $validated = $request->validate([
            'nama_dokumen' => 'required|string|max:255',
            'tanggal_dokumen' => 'required|date',
            'dokumen_file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
        ], [
            'nama_dokumen.required' => 'Nama dokumen harus diisi.',
            'nama_dokumen.max' => 'Nama dokumen maksimal 255 karakter.',
            'tanggal_dokumen.required' => 'Tanggal dokumen harus diisi.',
            'tanggal_dokumen.date' => 'Format tanggal tidak valid.',
            'dokumen_file.file' => 'File dokumen tidak valid.',
            'dokumen_file.mimes' => 'File harus berformat PDF, DOC, DOCX, XLS, atau XLSX.',
            'dokumen_file.max' => 'Ukuran file maksimal 10MB.',
        ]);

        try {
            $data = [
                'nama_dokumen' => $validated['nama_dokumen'],
                'tanggal_dokumen' => $validated['tanggal_dokumen']
            ];

            if ($request->hasFile('dokumen_file')) {
                // Hapus file lama jika ada
                if ($fileKesekretariat->dokumen_file) {
                    Storage::disk('public')->delete('documents/' . $fileKesekretariat->dokumen_file);
                }
                
                // Simpan file baru
                $file = $request->file('dokumen_file');
                $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('documents', $fileName, 'public');
                
                $data['dokumen_file'] = $fileName;
            }

            $fileKesekretariat->update($data);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'File berhasil diupdate.'
                ]);
            }

            return redirect()
                ->route('admin.file-kesekretariat.index')
                ->with('success', 'File berhasil diupdate.');

        } catch (\Exception $e) {
            Log::error('Error updating file: ' . $e->getMessage());
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mengupdate file: ' . $e->getMessage()
                ], 500);
            }

            return back()
                ->withInput()
                ->with('error', 'Gagal mengupdate file: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FileKesekretariat $fileKesekretariat, Request $request)
    {
        try {
            // Delete physical file
            if ($fileKesekretariat->dokumen_file) {
                Storage::disk('public')->delete('documents/' . $fileKesekretariat->dokumen_file);
            }
            
            // Delete record
            $fileKesekretariat->delete();

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Data berhasil dihapus.'
                ]);
            }

            return redirect()
                ->route('admin.file-kesekretariat.index')
                ->with('success', 'Data berhasil dihapus.');
                           
        } catch (\Exception $e) {
            Log::error('Error deleting file: ' . $e->getMessage());
            
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus data. Silakan coba lagi.'
                ], 500);
            }

            return redirect()
                ->route('admin.file-kesekretariat.index')
                ->with('error', 'Gagal menghapus data. Silakan coba lagi.');
        }
    }

    /**
     * Download the specified file to the user's device.
     */
    public function download(FileKesekretariat $fileKesekretariat): BinaryFileResponse|RedirectResponse
    {
        $filePath = storage_path('app/public/documents/' . $fileKesekretariat->dokumen_file);

        if (!file_exists($filePath)) {
            return back()->with('error', 'File tidak ditemukan.');
        }

        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        $downloadName = str_replace([' ', '.' . $extension], ['_', ''], $fileKesekretariat->nama_dokumen);
        $downloadName .= '.' . $extension;

        return response()->download($filePath, $downloadName);
    }
}