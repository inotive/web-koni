<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FileKesekretariat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
        $perPage = (int) $request->input('per_page', 10);
        $perPage = in_array($perPage, [10, 25, 50, 100]) ? $perPage : 10;

        // Execute query with pagination
        $files = $query->paginate($perPage)
                      ->withQueryString();

        // Add file path for each file (for easier access in view)
        $files->getCollection()->transform(function ($file) {
            $file->path = 'documents/' . $file->dokumen_file;
            $file->file_exists = Storage::disk('public')->exists($file->path);
            $file->file_size = $file->file_exists ? Storage::disk('public')->size($file->path) : 0;
            $file->file_extension = pathinfo($file->dokumen_file, PATHINFO_EXTENSION);
            return $file;
        });

        // Cache the results for 5 minutes (only if no search/filter)
        if (!$request->filled('search') && !$request->filled('file_type')) {
            Cache::put($cacheKey, $files, now()->addMinutes(5));
        }

        return view('admin.file-kesekretariat.index', compact('files'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.file-kesekretariat.create');
    }

    /**
     * Store a newly created resource in storage and database.
     *
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate the input from the form
        $request->validate([
            'nama_dokumen' => 'required|string|max:255',
            'dokumen_file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx|max:2048', // Max 2MB
        ]);

        // Save the file to the 'storage/app/public/documents' directory
        $fileName = time() . '_' . $request->file('dokumen_file')->getClientOriginalName();
        $request->file('dokumen_file')->storeAs('documents', $fileName, 'public');

        // Save the document name and file name to the database
        FileKesekretariat::create([
            'nama_dokumen' => $request->nama_dokumen,
            'dokumen_file' => $fileName,
        ]);

        return redirect()->route('admin.file-kesekretariat.index')
                         ->with('success', 'File berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  FileKesekretariat  $fileKesekretariat
     * @return View
     */
    public function show(FileKesekretariat $fileKesekretariat): View
    {
        return view('admin.file-kesekretariat.show', compact('fileKesekretariat'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  FileKesekretariat  $fileKesekretariat
     * @return View
     */
    public function edit(FileKesekretariat $fileKesekretariat): View
    {
        return view('admin.file-kesekretariat.edit', compact('fileKesekretariat'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  FileKesekretariat  $fileKesekretariat
     * @return RedirectResponse
     */
    public function update(Request $request, FileKesekretariat $fileKesekretariat): RedirectResponse
    {
        // Validate the request, 'nullable' allows the file to be optional on update
        $request->validate([
            'nama_dokumen' => 'required|string|max:255',
            'dokumen_file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:2048',
        ]);

        $data = [
            'nama_dokumen' => $request->nama_dokumen,
        ];

        // Check if a new file has been uploaded
        if ($request->hasFile('dokumen_file')) {
            // Delete the old file from storage if it exists
            if ($fileKesekretariat->dokumen_file && Storage::disk('public')->exists('documents/' . $fileKesekretariat->dokumen_file)) {
                Storage::disk('public')->delete('documents/' . $fileKesekretariat->dokumen_file);
            }

            // Upload the new file
            $fileName = time() . '_' . $request->file('dokumen_file')->getClientOriginalName();
            $request->file('dokumen_file')->storeAs('documents', $fileName, 'public');
            $data['dokumen_file'] = $fileName;
        }

        // Update the file record in the database
        $fileKesekretariat->update($data);

        return redirect()->route('admin.file-kesekretariat.index')
                         ->with('success', 'File berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  FileKesekretariat  $fileKesekretariat
     * @param  Request  $request
     * @return JsonResponse|RedirectResponse
     */
    public function destroy(FileKesekretariat $fileKesekretariat, Request $request)
    {
        try {
            // Hapus file fisik jika ada
            if ($fileKesekretariat->dokumen_file &&
                Storage::disk('public')->exists('documents/' . $fileKesekretariat->dokumen_file)) {
                Storage::disk('public')->delete('documents/' . $fileKesekretariat->dokumen_file);
            }

            // Hapus record dari database
            $fileKesekretariat->delete();

            // Jika request AJAX, return JSON response
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Data berhasil dihapus.'
                ]);
            }

            // Untuk request biasa, redirect dengan flash message
            return redirect()->route('admin.file-kesekretariat.index')
                           ->with('success', 'Data berhasil dihapus.');
                           
        } catch (\Exception $e) {
            // Log error untuk debugging
            \Log::error('Error deleting file: ' . $e->getMessage());
            
            // Jika request AJAX, return JSON error response
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus data. Silakan coba lagi.'
                ], 500);
            }

            // Untuk request biasa, redirect dengan error message
            return redirect()->route('admin.file-kesekretariat.index')
                           ->with('error', 'Gagal menghapus data. Silakan coba lagi.');
        }
    }

    /**
     * Download the specified file to the user's device.
     *
     * @param  FileKesekretariat  $fileKesekretariat
     * @return BinaryFileResponse|RedirectResponse
     */
    public function download(FileKesekretariat $fileKesekretariat): BinaryFileResponse|RedirectResponse
    {
        // Define the file path
        $filePath = storage_path('app/public/documents/' . $fileKesekretariat->dokumen_file);

        // Check if the file actually exists
        if (file_exists($filePath)) {
            // Download the file with the correct extension
            return response()->download($filePath, $fileKesekretariat->nama_dokumen . '.' . pathinfo($filePath, PATHINFO_EXTENSION));
        }

        return redirect()->back()->with('error', 'File tidak ditemukan.');
    }
}