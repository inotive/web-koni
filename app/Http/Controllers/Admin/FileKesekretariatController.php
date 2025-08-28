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
            $search = trim($request->input('search'));
            $query->where(function ($q) use ($search) {
                $q->where('nama_dokumen', 'like', '%' . $search . '%')
                  ->orWhere('dokumen_file', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('file_type')) {
            $query->where('file_extension', $request->input('file_type'));
        }

        $allowedSortColumns = ['nama_dokumen', 'tanggal_dokumen', 'created_at', 'updated_at', 'file_size'];
        $sortBy = $request->get('sort_by', 'created_at');
        $order = $request->get('order', 'desc');

        if (!in_array($sortBy, $allowedSortColumns)) $sortBy = 'created_at';
        if (!in_array($order, ['asc', 'desc'])) $order = 'desc';

        $query->orderBy($sortBy, $order)->orderBy('id', 'desc');

        $perPage = $this->getValidPerPage($request->input('per_page'));
        
        $files = $query->paginate($perPage)->withQueryString();

        $files->through(function ($file) {
            $file->file_size = $this->formatFileSize($file->file_size ?? 0);
            $file->display_filename = $this->getOriginalFileName($file->dokumen_file);
            if ($file->tanggal_dokumen) {
                $file->tanggal_dokumen_formatted = $file->tanggal_dokumen->format('Y-m-d');
            }
            return $file;
        });

        if ($request->ajax() || $request->wantsJson()) {
            return view('admin.file-kesekretariat._table', compact('files'));
        }

        return view('admin.file-kesekretariat.index', compact('files'));
    }

    private function getOriginalFileName($fileName)
    {
        return preg_replace('/^\\d+_/', '', $fileName);
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
        return $bytes > 0 ? $bytes . ' bytes' : '0 KB';
    }

    public function create(): View
    {
        return view('admin.file-kesekretariat.create');
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nama_dokumen' => 'required|string|max:255',
            'tanggal_dokumen' => 'required|date',
            'dokumen_file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
        ], [
            'nama_dokumen.required' => 'Nama dokumen wajib diisi',
            'tanggal_dokumen.required' => 'Tanggal dokumen wajib diisi', 
            'tanggal_dokumen.date' => 'Format tanggal tidak valid',
            'dokumen_file.required' => 'File dokumen wajib diunggah',
            'dokumen_file.mimes' => 'Format file harus PDF, DOC, DOCX, XLS, atau XLSX',
            'dokumen_file.max' => 'Ukuran file maksimal 10MB',
        ]);

        try {
            $file = $request->file('dokumen_file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            
            $fileSize = $file->getSize();
            $fileExtension = $file->getClientOriginalExtension();

            $file->storeAs('documents', $fileName, 'public');

            $fileKesekretariat = FileKesekretariat::create([
                'nama_dokumen' => $validated['nama_dokumen'],
                'tanggal_dokumen' => $validated['tanggal_dokumen'],
                'dokumen_file' => $fileName,
                'file_extension' => $fileExtension,
                'file_size' => $fileSize,
            ]);

            $fileData = [
                'id' => $fileKesekretariat->id,
                'nama_dokumen' => $fileKesekretariat->nama_dokumen,
                'tanggal_dokumen' => $fileKesekretariat->tanggal_dokumen->format('Y-m-d'),
                'tanggal_dokumen_formatted' => $fileKesekretariat->tanggal_dokumen->format('d/m/Y'),
                'dokumen_file' => $this->getOriginalFileName($fileName),
                'actual_filename' => $fileName,
                'file_url' => Storage::url('documents/' . $fileName),
                'extension' => $fileKesekretariat->file_extension,
                'file_size' => $this->formatFileSize($fileKesekretariat->file_size)
            ];

            return response()->json([
                'success' => true,
                'message' => 'File berhasil ditambahkan.',
                'file' => $fileData,
                'total_records' => FileKesekretariat::count()
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid',
                'errors' => $e->errors()
            ], 422);
        } catch (\Throwable $e) {
            Log::error('Error storing file: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan file: ' . $e->getMessage()
            ], 500);
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
            'file_size' => $this->formatFileSize($fileKesekretariat->file_size ?? 0),
        ]);
    }

    public function edit(FileKesekretariat $fileKesekretariat): JsonResponse
    {
        try {
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $fileKesekretariat->id,
                    'nama_dokumen' => $fileKesekretariat->nama_dokumen,
                    'tanggal_dokumen' => optional($fileKesekretariat->tanggal_dokumen)->format('Y-m-d'),
                    'dokumen_file' => $this->getOriginalFileName($fileKesekretariat->dokumen_file),
                    'actual_filename' => $fileKesekretariat->dokumen_file,
                    'current_file_size' => $this->formatFileSize($fileKesekretariat->file_size ?? 0),
                    'file_extension' => $fileKesekretariat->file_extension,
                ],
                'message' => 'Data berhasil dimuat'
            ]);
        } catch (\Throwable $e) {
            Log::error('Error in edit: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Gagal memuat data'], 500);
        }
    }

    public function update(Request $request, FileKesekretariat $fileKesekretariat): JsonResponse
    {
        $validated = $request->validate([
            'nama_dokumen' => 'required|string|max:255',
            'tanggal_dokumen' => 'required|date',
            'dokumen_file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
        ]);

        try {
            $data = [
                'nama_dokumen' => $validated['nama_dokumen'],
                'tanggal_dokumen' => $validated['tanggal_dokumen'],
            ];

            if ($request->hasFile('dokumen_file')) {
                if ($fileKesekretariat->dokumen_file) {
                    Storage::disk('public')->delete('documents/' . $fileKesekretariat->dokumen_file);
                }

                $file = $request->file('dokumen_file');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('documents', $fileName, 'public');
                
                $data['dokumen_file'] = $fileName;
                $data['file_extension'] = $file->getClientOriginalExtension();
                $data['file_size'] = $file->getSize();
            }

            $fileKesekretariat->update($data);

            $fileData = [
                'id' => $fileKesekretariat->id,
                'nama_dokumen' => $fileKesekretariat->nama_dokumen,
                'tanggal_dokumen' => $fileKesekretariat->tanggal_dokumen->format('Y-m-d'),
                'tanggal_dokumen_formatted' => $fileKesekretariat->tanggal_dokumen->format('d/m/Y'),
                'dokumen_file' => $this->getOriginalFileName($fileKesekretariat->dokumen_file),
                'actual_filename' => $fileKesekretariat->dokumen_file,
                'file_url' => Storage::url('documents/' . $fileKesekretariat->dokumen_file),
                'extension' => $fileKesekretariat->file_extension,
                'file_size' => $this->formatFileSize($fileKesekretariat->file_size)
            ];

            return response()->json([
                'success' => true,
                'message' => 'File berhasil diupdate.',
                'file' => $fileData
            ]);

        } catch (\Throwable $e) {
            Log::error('Error updating file: ' . $e->getMessage());
            return response()->json([
                'success' => false, 
                'message' => 'Gagal update file: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy(FileKesekretariat $fileKesekretariat): JsonResponse
    {
        try {
            if ($fileKesekretariat->dokumen_file) {
                Storage::disk('public')->delete('documents/' . $fileKesekretariat->dokumen_file);
            }
            $fileKesekretariat->delete();

            return response()->json([
                'success' => true,
                'message' => 'File berhasil dihapus.'
            ]);
        } catch (\Throwable $e) {
            Log::error('Error deleting file: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus file.'
            ], 500);
        }
    }

    public function download(FileKesekretariat $fileKesekretariat): BinaryFileResponse|RedirectResponse
    {
        $filePath = storage_path('app/public/documents/' . $fileKesekretariat->dokumen_file);

        if (!file_exists($filePath)) {
            return back()->with('error', 'File tidak ditemukan.');
        }

        $extension = $fileKesekretariat->file_extension ?? pathinfo($filePath, PATHINFO_EXTENSION);
        $downloadName = str_replace([' ', '.' . $extension], ['_', ''], $fileKesekretariat->nama_dokumen) . '.' . $extension;

        return response()->download($filePath, $downloadName);
    }
}