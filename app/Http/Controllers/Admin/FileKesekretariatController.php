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

class FileKesekretariatController extends Controller
{
    public function index(Request $request): View
    {
        $query = FileKesekretariat::query();

        if ($request->filled('search')) {
            $query->where('nama_dokumen', 'like', '%' . trim($request->input('search')) . '%');
        }

        if ($request->filled('file_type')) {
            $fileType = $request->input('file_type');
            $query->where('dokumen_file', 'like', '%.' . $fileType);
        }

        $allowedSortColumns = ['nama_dokumen', 'created_at', 'updated_at'];
        $sortBy = $request->get('sort_by', 'created_at');
        $order = $request->get('order', 'desc');

        if (!in_array($sortBy, $allowedSortColumns)) $sortBy = 'created_at';
        if (!in_array($order, ['asc', 'desc'])) $order = 'desc';

        $query->orderBy($sortBy, $order)->orderBy('id', 'desc');

        $perPage = $this->getValidPerPage($request->input('per_page'));
        $files = $query->paginate($perPage)->withQueryString()->through(function ($file) {
            $file->path = 'documents/' . $file->dokumen_file;
            $file->file_exists = Storage::disk('public')->exists($file->path);
            $file->file_size = $file->file_exists
                ? $this->formatFileSize(Storage::disk('public')->size($file->path))
                : '0 KB';
            $file->file_extension = pathinfo($file->dokumen_file, PATHINFO_EXTENSION);
            if ($file->tanggal_dokumen) {
                $file->tanggal_dokumen_formatted = $file->tanggal_dokumen->format('Y-m-d');
            }
            return $file;
        });

        return view('admin.file-kesekretariat.index', compact('files'));
    }

    protected function getValidPerPage($inputPerPage): int
    {
        $allowed = [10, 20, 30, 40, 50];
        return in_array((int) $inputPerPage, $allowed) ? (int) $inputPerPage : 10;
    }

    protected function formatFileSize($bytes): string
    {
        if ($bytes >= 1073741824) return number_format($bytes / 1073741824, 2) . ' GB';
        if ($bytes >= 1048576) return number_format($bytes / 1048576, 2) . ' MB';
        if ($bytes >= 1024) return number_format($bytes / 1024, 2) . ' KB';
        return $bytes > 1 ? $bytes . ' bytes' : '0 bytes';
    }

    public function create(): View
    {
        return view('admin.file-kesekretariat.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_dokumen' => 'required|string|max:255',
            'dokumen_file' => 'required|array|max:10',
            'dokumen_file.*' => 'file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
        ]);

        try {
            foreach ($request->file('dokumen_file') as $file) {
                $fileName = $file->getClientOriginalName();
                $file->storeAs('documents', $fileName, 'public');

                FileKesekretariat::create([
                    'nama_dokumen' => $validated['nama_dokumen'],
                    'dokumen_file' => $fileName,
                ]);
            }

            return redirect()
                ->route('admin.file-kesekretariat.index')
                ->with('success', 'File berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Error storing file: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal menyimpan file.');
        }
    }

    public function show(FileKesekretariat $fileKesekretariat): View
    {
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

    public function edit(FileKesekretariat $fileKesekretariat): JsonResponse
    {
        try {
            $filePath = 'documents/' . $fileKesekretariat->dokumen_file;
            $fileExists = Storage::disk('public')->exists($filePath);

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $fileKesekretariat->id,
                    'nama_dokumen' => $fileKesekretariat->nama_dokumen,
                    'tanggal_dokumen' => optional($fileKesekretariat->tanggal_dokumen)->format('Y-m-d'),
                    'dokumen_file' => $fileKesekretariat->dokumen_file,
                    'file_exists' => $fileExists,
                    'current_file_size' => $fileExists
                        ? $this->formatFileSize(Storage::disk('public')->size($filePath))
                        : '0 KB',
                    'file_extension' => pathinfo($fileKesekretariat->dokumen_file, PATHINFO_EXTENSION),
                ],
                'message' => 'Data berhasil dimuat'
            ]);
        } catch (\Exception $e) {
            Log::error('Error in edit: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Gagal memuat data'], 500);
        }
    }

    public function update(Request $request, FileKesekretariat $fileKesekretariat): JsonResponse
    {
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
                if ($fileKesekretariat->dokumen_file) {
                    Storage::disk('public')->delete('documents/' . $fileKesekretariat->dokumen_file);
                }

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
            return response()->json(['success' => false, 'message' => 'Gagal update file.'], 500);
        }
    }

    public function download(FileKesekretariat $fileKesekretariat): BinaryFileResponse|RedirectResponse
    {
        $filePath = storage_path('app/public/documents/' . $fileKesekretariat->dokumen_file);

        if (!file_exists($filePath)) {
            return back()->with('error', 'File tidak ditemukan.');
        }

        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        $downloadName = str_replace([' ', '.' . $extension], ['_', ''], $fileKesekretariat->nama_dokumen) . '.' . $extension;

        return response()->download($filePath, $downloadName);
    }
}