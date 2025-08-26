<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FileKesekretariat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log; // Tambahkan ini untuk Log
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
            
            // TAMBAHKAN: Format tanggal untuk konsistensi
            if ($file->tanggal_dokumen) {
                $file->tanggal_dokumen_formatted = $file->tanggal_dokumen->format('Y-m-d');
            }
            
            return $file;
        });

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
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_dokumen' => 'required|string|max:255',
            'dokumen_file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
        ]);


        try {
            $file = $request->file('dokumen_file');
            $fileName = $file->getClientOriginalName(); // ✅ tanpa prefix
            $path = $file->storeAs('documents', $fileName, 'public');
            $path = $file->storeAs('documents', $fileName, 'public');

            FileKesekretariat::create([
                'nama_dokumen' => $validated['nama_dokumen'],
                'dokumen_file' => $fileName,
            ]);

            return redirect()
                ->route('admin.file-kesekretariat.index')
                ->with('success', 'File berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Error storing file: ' . $e->getMessage()); // Diubah dari \Log ke Log
            return back()
                ->withInput()
                ->with('error', 'Gagal menyimpan file. Silakan coba lagi.');
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
    public function edit(FileKesekretariat $fileKesekretariat): JsonResponse
{
    try {
        // Pastikan file exists di storage
        $filePath = 'documents/' . $fileKesekretariat->dokumen_file;
        $fileExists = Storage::disk('public')->exists($filePath);
        
        // Format tanggal dengan benar untuk input date HTML
        $tanggalDokumen = null;
        if ($fileKesekretariat->tanggal_dokumen) {
            // Pastikan dalam format Y-m-d untuk input type="date"
            if ($fileKesekretariat->tanggal_dokumen instanceof \Carbon\Carbon) {
                $tanggalDokumen = $fileKesekretariat->tanggal_dokumen->format('Y-m-d');
            } else {
                // Jika string, parse dulu
                $tanggalDokumen = date('Y-m-d', strtotime($fileKesekretariat->tanggal_dokumen));
            }
        }
        
        // Format data untuk response JSON
        $data = [
            'id' => $fileKesekretariat->id,
            'nama_dokumen' => $fileKesekretariat->nama_dokumen,
            'tanggal_dokumen' => $tanggalDokumen, // ✅ Format yang benar
            'dokumen_file' => $fileKesekretariat->dokumen_file,
            'file_exists' => $fileExists,
            'current_file_size' => $fileExists ? 
                $this->formatFileSize(Storage::disk('public')->size($filePath)) : 
                '0 KB',
            'file_extension' => pathinfo($fileKesekretariat->dokumen_file, PATHINFO_EXTENSION),
        ];

        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => 'Data berhasil dimuat'
        ]);

    } catch (\Exception $e) {
        Log::error('Error in edit method: ' . $e->getMessage());
        
        return response()->json([
            'success' => false,
            'message' => 'Gagal memuat data file'
        ], 500);
    }
}


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FileKesekretariat $fileKesekretariat): JsonResponse
{
    // Validasi
    $validated = $request->validate([
        'nama_dokumen' => 'required|string|max:255',
        'tanggal_dokumen' => 'nullable|date',
        'dokumen_file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
    ]);

    try {
        $data = [
            'nama_dokumen' => $validated['nama_dokumen'],
            'tanggal_dokumen' => $validated['tanggal_dokumen'] ?? null,
        ];

        if ($request->hasFile('dokumen_file')) {
            // Hapus file lama jika ada
            if ($fileKesekretariat->dokumen_file) {
                Storage::disk('public')->delete('documents/' . $fileKesekretariat->dokumen_file);
            }

            // Simpan file baru
            $file = $request->file('dokumen_file');
            $fileName = $file->getClientOriginalName();
            $file->storeAs('documents', $fileName, 'public');

            $data['dokumen_file'] = $fileName;
        }

        $fileKesekretariat->update($data);

        return response()->json([
            'success' => true, 
            'message' => 'File berhasil diupdate.',
            'data' => $fileKesekretariat
        ]);

    } catch (\Exception $e) {
        Log::error('Error updating file: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Gagal mengupdate file. Silakan coba lagi.'
        ], 500);
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
