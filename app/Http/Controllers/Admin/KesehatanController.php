<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\kesehatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class kesehatanController extends Controller
{
    public function index(Request $request)
    {
        $query = kesehatan::query();

        // Apply filters
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

        // Handle sorting
        $allowedSorts = ['nama_program', 'nama_kegiatan', 'volume', 'jumlah_harga_satuan', 'jumlah_harga', 'created_at'];
        $sort = $request->get('sort', 'created_at');
        $direction = $request->get('direction', 'desc');

        if (!in_array($sort, $allowedSorts)) {
            $sort = 'created_at';
        }
        if (!in_array($direction, ['asc', 'desc'])) {
            $direction = 'desc';
        }

        $kesehatanData = $query
            ->orderBy($sort, $direction)
            ->paginate($request->get('per_page', 10));

        // If AJAX request, return table partial
        if ($request->ajax()) {
            return view('admin.laporan-lpj.bidang.kesehatan._table', compact('kesehatanData'))->render();
        }

        return view('admin.laporan-lpj.bidang.kesehatan.index', compact('kesehatanData'));
    }

    public function create()
    {
        return view('admin.laporan-lpj.bidang.kesehatan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_program' => 'required|string|max:255',
            'nama_kegiatan' => 'required|string|max:255',
            'volume' => 'required|string|max:255',
            'jumlah_harga_satuan' => 'required|numeric|min:0',
            'jumlah_harga' => 'required|numeric|min:0',
            'keterangan_tambahan' => 'nullable|string',
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

        $data = $request->only([
            'nama_program',
            'nama_kegiatan',
            'volume',
            'jumlah_harga_satuan',
            'jumlah_harga',
            'keterangan_tambahan'
        ]);

        // Handle foto_jurnal uploads
        if ($request->hasFile('foto_jurnal')) {
            $fotoPaths = [];
            foreach ($request->file('foto_jurnal') as $file) {
                $fotoPaths[] = $file->store('kesehatan/foto_jurnal', 'public');
            }
            $data['foto_jurnal'] = $fotoPaths;
        }

        // Handle dokumen_lpj uploads
        if ($request->hasFile('dokumen_lpj')) {
            $dokumenPaths = [];
            foreach ($request->file('dokumen_lpj') as $file) {
                $dokumenPaths[] = $file->store('kesehatan/dokumen_lpj', 'public');
            }
            $data['dokumen_lpj'] = $dokumenPaths;
        }

        kesehatan::create($data);

        return redirect()->route('admin.laporan-lpj.bidang.kesehatan.index')
                         ->with('OK', 'Data sumber daya berhasil ditambahkan.');
    }

    public function show(kesehatan $kesehatan)
    {
        return view('admin.laporan-lpj.bidang.kesehatan.show', compact('kesehatan'));
    }

    public function edit(kesehatan $kesehatan)
    {
        // Check if user has permission to edit
        if (!auth()->user()->hasRole('superadmin')) {
            abort(403, 'Akses ditolak. Hanya superadmin yang dapat mengedit data.');
        }

        return view('admin.laporan-lpj.bidang.kesehatan.edit', compact('kesehatan'));
    }

    public function update(Request $request, kesehatan $kesehatan)
    {
        // Check if user has permission to update
        if (!auth()->user()->hasRole('superadmin')) {
            abort(403, 'Akses ditolak. Hanya superadmin yang dapat memperbarui data.');
        }

        $request->validate([
            'nama_program' => 'required|string|max:255',
            'nama_kegiatan' => 'required|string|max:255',
            'volume' => 'required|string|max:255',
            'jumlah_harga_satuan' => 'required|numeric|min:0',
            'jumlah_harga' => 'required|numeric|min:0',
            'keterangan_tambahan' => 'nullable|string',
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

        $data = $request->only([
            'nama_program',
            'nama_kegiatan',
            'volume',
            'jumlah_harga_satuan',
            'jumlah_harga',
            'keterangan_tambahan'
        ]);

        // Handle foto_jurnal uploads
        if ($request->hasFile('foto_jurnal')) {
            // Delete old photos if exists
            if ($kesehatan->foto_jurnal) {
                foreach ($kesehatan->foto_jurnal as $oldFoto) {
                    Storage::disk('public')->delete($oldFoto);
                }
            }

            $fotoPaths = [];
            foreach ($request->file('foto_jurnal') as $file) {
                $fotoPaths[] = $file->store('kesehatan/foto_jurnal', 'public');
            }
            $data['foto_jurnal'] = $fotoPaths;
        }

        // Handle dokumen_lpj uploads
        if ($request->hasFile('dokumen_lpj')) {
            // Delete old documents if exists
            if ($kesehatan->dokumen_lpj) {
                foreach ($kesehatan->dokumen_lpj as $oldDokumen) {
                    Storage::disk('public')->delete($oldDokumen);
                }
            }

            $dokumenPaths = [];
            foreach ($request->file('dokumen_lpj') as $file) {
                $dokumenPaths[] = $file->store('kesehatan/dokumen_lpj', 'public');
            }
            $data['dokumen_lpj'] = $dokumenPaths;
        }

        $kesehatan->update($data);

        return redirect()->route('admin.laporan-lpj.bidang.kesehatan.index')
                         ->with('OK', 'Data sumber daya berhasil diperbarui.');
    }

    public function destroy(kesehatan $kesehatan)
    {
        // Check if user has permission to delete
        if (!auth()->user()->hasRole('superadmin')) {
            abort(403, 'Akses ditolak. Hanya superadmin yang dapat menghapus data.');
        }

        // Delete associated files
        if ($kesehatan->foto_jurnal) {
            foreach ($kesehatan->foto_jurnal as $foto) {
                Storage::disk('public')->delete($foto);
            }
        }

        if ($kesehatan->dokumen_lpj) {
            foreach ($kesehatan->dokumen_lpj as $dokumen) {
                Storage::disk('public')->delete($dokumen);
            }
        }

        $kesehatan->delete();

        return redirect()->route('admin.laporan-lpj.bidang.kesehatan.index')
                         ->with('OK', 'Data sumber daya berhasil dihapus.');
    }

    /**
     * Generate sort URL helper
     */
    private function sortUrl($column)
    {
        $direction = request()->get('direction', 'asc');
        $newDirection = (request()->get('sort') == $column && $direction == 'asc') ? 'desc' : 'asc';

        return request()->fullUrlWithQuery([
            'sort' => $column,
            'direction' => $newDirection
        ]);
    }

    /**
     * Remove individual file from the collection
     */
    public function removeFile(Request $request, kesehatan $kesehatan)
    {
        // Check if user has permission to modify files
        if (!auth()->user()->hasRole('superadmin')) {
            return response()->json(['error' => 'Akses ditolak'], 403);
        }

        $request->validate([
            'file_type' => 'required|in:foto_jurnal,dokumen_lpj',
            'file_index' => 'required|integer|min:0'
        ]);

        $fileType = $request->file_type;
        $fileIndex = $request->file_index;
        $files = $kesehatan->$fileType ?? [];

        if (!isset($files[$fileIndex])) {
            return response()->json(['error' => 'File tidak ditemukan'], 404);
        }

        // Delete the file from storage
        $filePath = $files[$fileIndex];
        Storage::disk('public')->delete($filePath);

        // Remove from array
        unset($files[$fileIndex]);
        $files = array_values($files); // Reindex array

        // Update the model
        $kesehatan->update([$fileType => $files]);

        return response()->json([
            'success' => true,
            'message' => 'File berhasil dihapus',
            'remaining_files' => count($files)
        ]);
    }
}
