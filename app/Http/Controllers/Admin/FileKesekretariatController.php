<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FileKesekretariat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

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
        // Start with a base query for all files
        $query = FileKesekretariat::query();

        // Handle the search functionality
        if ($request->filled('search')) {
            $query->where('nama_dokumen', 'like', '%' . $request->input('search') . '%');
        }

        // Handle the file type filter
        if ($request->filled('filter_file_type')) {
            // The file type filter in the front-end checks the file extension.
            // We'll assume the 'dokumen_file' column contains the full file name.
            $query->where('dokumen_file', 'like', '%' . $request->input('filter_file_type') . '%');
        }
        
        // Always order by the latest file first
        $query->orderBy('created_at', 'desc');

        // Get the files from the database.
        // In a real application, you should add pagination here,
        // for example: ->paginate(10);
        $perPage = (int) $request->input('per_page', 10); // default 10
$perPage = in_array($perPage, [10,25,50,100]) ? $perPage : 10;

$files = $query->orderBy(
            $request->get('sort_by', 'created_at'),
            $request->get('order', 'desc')
         )
         ->paginate($perPage)
         ->withQueryString(); // agar filter/search tetap terbawa

        // Return the view and pass the $files variable to it using compact()
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
     * @return RedirectResponse
     */
    public function destroy(FileKesekretariat $fileKesekretariat)
{
    // Hapus file fisik
    if ($fileKesekretariat->dokumen_file &&
        Storage::disk('public')->exists('documents/' . $fileKesekretariat->dokumen_file)) {
        Storage::disk('public')->delete('documents/' . $fileKesekretariat->dokumen_file);
    }

        // Then, delete the record from the database
        $fileKesekretariat->delete();

        return response()->json(['message' => 'Data berhasil dihapus']);
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