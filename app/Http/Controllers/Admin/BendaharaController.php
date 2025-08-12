<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bendahara;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class BendaharaController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);

        $allowedSorts = [
            'judul', 'created_at', 'updated_at'
        ];

        $sortBy = $request->get('sort_by', 'created_at');
        $order = strtolower($request->get('order', 'desc'));

        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'created_at';
        }

        if (!in_array($order, ['asc', 'desc'])) {
            $order = 'desc';
        }

        $query = Bendahara::query();

        // Search functionality - Applied BEFORE pagination
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('judul', 'like', '%' . $searchTerm . '%');
                // Add more searchable fields if needed
                // $q->orWhere('description', 'like', '%' . $searchTerm . '%');
            });
        }

        // File type filtering - Applied BEFORE pagination
        if ($request->filled('filter_type') && $request->filter_type !== 'all') {
            $filterType = $request->filter_type;

            switch ($filterType) {
                case 'pdf':
                    $query->where('dokumen', 'like', '%.pdf');
                    break;
                case 'doc':
                    $query->where(function ($q) {
                        $q->where('dokumen', 'like', '%.doc')
                          ->orWhere('dokumen', 'like', '%.docx');
                    });
                    break;
                case 'excel':
                    $query->where(function ($q) {
                        $q->where('dokumen', 'like', '%.xls')
                          ->orWhere('dokumen', 'like', '%.xlsx');
                    });
                    break;
                case 'image':
                    $query->where(function ($q) {
                        $q->where('dokumen', 'like', '%.jpg')
                          ->orWhere('dokumen', 'like', '%.jpeg')
                          ->orWhere('dokumen', 'like', '%.png')
                          ->orWhere('dokumen', 'like', '%.gif')
                          ->orWhere('dokumen', 'like', '%.bmp')
                          ->orWhere('dokumen', 'like', '%.svg');
                    });
                    break;
                case 'other':
                    $query->where(function ($q) {
                        $q->where('dokumen', 'not like', '%.pdf')
                          ->where('dokumen', 'not like', '%.doc')
                          ->where('dokumen', 'not like', '%.docx')
                          ->where('dokumen', 'not like', '%.xls')
                          ->where('dokumen', 'not like', '%.xlsx')
                          ->where('dokumen', 'not like', '%.jpg')
                          ->where('dokumen', 'not like', '%.jpeg')
                          ->where('dokumen', 'not like', '%.png')
                          ->where('dokumen', 'not like', '%.gif')
                          ->where('dokumen', 'not like', '%.bmp')
                          ->where('dokumen', 'not like', '%.svg');
                    });
                    break;
            }
        }

        // Handle sorting
        $query->orderBy($sortBy, $order);

        // Add secondary sorting for consistency
        if ($sortBy !== 'created_at') {
            $query->orderBy('created_at', 'desc');
        }

        // Add final ordering by ID for consistency
        $query->orderBy('id', 'desc');

        $laporanBendahara = $query->paginate($perPage);
        $laporanBendahara->appends($request->query());

        // Get file counts for all data (for filter dropdown)
        $fileCounts = $this->getFileCounts($request);

        if ($request->ajax()) {
            return view('admin.bendahara._table', compact('laporanBendahara', 'fileCounts'))->render();
        }

        return view('admin.bendahara.index', compact('laporanBendahara', 'fileCounts'));
    }

    /**
     * Get file counts for filter dropdown
     */
    private function getFileCounts(Request $request)
    {
        $baseQuery = Bendahara::query();

        // Apply search to count query if search is active
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $baseQuery->where(function ($q) use ($searchTerm) {
                $q->where('judul', 'like', '%' . $searchTerm . '%');
            });
        }

        $counts = [
            'all' => $baseQuery->count(),
            'pdf' => (clone $baseQuery)->where('dokumen', 'like', '%.pdf')->count(),
            'doc' => (clone $baseQuery)->where(function ($q) {
                $q->where('dokumen', 'like', '%.doc')
                  ->orWhere('dokumen', 'like', '%.docx');
            })->count(),
            'excel' => (clone $baseQuery)->where(function ($q) {
                $q->where('dokumen', 'like', '%.xls')
                  ->orWhere('dokumen', 'like', '%.xlsx');
            })->count(),
            'image' => (clone $baseQuery)->where(function ($q) {
                $q->where('dokumen', 'like', '%.jpg')
                  ->orWhere('dokumen', 'like', '%.jpeg')
                  ->orWhere('dokumen', 'like', '%.png')
                  ->orWhere('dokumen', 'like', '%.gif')
                  ->orWhere('dokumen', 'like', '%.bmp')
                  ->orWhere('dokumen', 'like', '%.svg');
            })->count(),
            'other' => (clone $baseQuery)->where(function ($q) {
                $q->where('dokumen', 'not like', '%.pdf')
                  ->where('dokumen', 'not like', '%.doc')
                  ->where('dokumen', 'not like', '%.docx')
                  ->where('dokumen', 'not like', '%.xls')
                  ->where('dokumen', 'not like', '%.xlsx')
                  ->where('dokumen', 'not like', '%.jpg')
                  ->where('dokumen', 'not like', '%.jpeg')
                  ->where('dokumen', 'not like', '%.png')
                  ->where('dokumen', 'not like', '%.gif')
                  ->where('dokumen', 'not like', '%.bmp')
                  ->where('dokumen', 'not like', '%.svg');
            })->count()
        ];

        return $counts;
    }

    public function create()
    {
        return view('admin.bendahara.create');
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'judul' => 'required|string|max:255',
                'dokumen' => 'required|mimes:pdf,doc,docx,xls,xlsx|max:10240',
            ], [
                'judul.required' => 'Judul laporan wajib diisi.',
                'judul.max' => 'Judul laporan tidak boleh lebih dari 255 karakter.',
                'dokumen.required' => 'Dokumen wajib diunggah.',
                'dokumen.mimes' => 'Format file harus PDF, DOC, DOCX, XLS, atau XLSX.',
                'dokumen.max' => 'Ukuran file tidak boleh lebih dari 10MB.',
            ]);

            if ($request->hasFile('dokumen')) {
                $data['dokumen'] = $request->file('dokumen')->store('bendahara', 'public');
            }

            $laporanBendahara = Bendahara::create($data);

            // Check if it's AJAX request
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Laporan bendahara berhasil disimpan.'
                ]);
            }

            return redirect()->route('admin.bendahara.index')
                ->with('OK', 'Laporan bendahara berhasil disimpan.')
                ->with('action', 'store');

        } catch (ValidationException $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'errors' => $e->errors()
                ], 422);
            }
            return back()->withInput()->withErrors($e->errors());
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menyimpan laporan bendahara: ' . $e->getMessage()
                ], 500);
            }
            return back()->withInput()
                ->with('error', 'Gagal menyimpan laporan bendahara. Error: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $laporanBendahara = Bendahara::findOrFail($id);
        return view('admin.bendahara.show', compact('laporanBendahara'));
    }

    public function edit($id)
    {
        $laporanBendahara = Bendahara::findOrFail($id);
        return view('admin.bendahara.edit', compact('laporanBendahara'));
    }

    public function update(Request $request, Bendahara $bendahara)
    {
        try {
            $data = $request->validate([
                'judul' => 'required|string|max:255',
                'dokumen' => 'nullable|mimes:pdf,doc,docx,xls,xlsx|max:10240',
            ], [
                'judul.required' => 'Judul laporan wajib diisi.',
                'judul.max' => 'Judul laporan tidak boleh lebih dari 255 karakter.',
                'dokumen.mimes' => 'Format file harus PDF, DOC, DOCX, XLS, atau XLSX.',
                'dokumen.max' => 'Ukuran file tidak boleh lebih dari 10MB.',
            ]);

            // Handle file update if new file is uploaded
            if ($request->hasFile('dokumen')) {
                // Delete old file if exists
                if ($bendahara->dokumen) {
                    Storage::disk('public')->delete($bendahara->dokumen);
                }
                $data['dokumen'] = $request->file('dokumen')->store('bendahara', 'public');
            }

            $bendahara->update($data);

            // Check if it's AJAX request
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Laporan bendahara berhasil diperbarui.'
                ]);
            }

            return redirect()->route('admin.bendahara.index')
                ->with('OK', 'Laporan bendahara berhasil diubah.')
                ->with('action', 'update');

        } catch (ValidationException $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'errors' => $e->errors()
                ], 422);
            }
            return back()->withInput()->withErrors($e->errors());
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal memperbarui laporan bendahara: ' . $e->getMessage()
                ], 500);
            }
            return back()->withInput()
                ->with('error', 'Gagal mengubah laporan bendahara. Error: ' . $e->getMessage());
        }
    }

    public function destroy(Request $request, Bendahara $bendahara)
    {
        try {
            // Delete file if exists
            if ($bendahara->dokumen) {
                Storage::disk('public')->delete($bendahara->dokumen);
            }

            $bendahara->delete();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Laporan bendahara berhasil dihapus.'
                ]);
            }

            return redirect()->route('admin.bendahara.index')
                ->with('OK', 'Laporan bendahara berhasil dihapus.')
                ->with('action', 'destroy');

        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus laporan bendahara. Error: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Gagal menghapus laporan bendahara. Error: ' . $e->getMessage());
        }
    }

    public function download($id)
    {
        $laporanBendahara = Bendahara::findOrFail($id);

        if (!$laporanBendahara->dokumen) {
            return back()->with('error', 'Dokumen tidak tersedia.');
        }

        $filePath = storage_path('app/public/' . $laporanBendahara->dokumen);

        if (!file_exists($filePath)) {
            return back()->with('error', 'File tidak ditemukan.');
        }

        $fileName = $laporanBendahara->judul . '_' . date('Y-m-d') . '.' . pathinfo($laporanBendahara->dokumen, PATHINFO_EXTENSION);

        return response()->download($filePath, $fileName);
    }

    /**
     * Helper method to format file size
     */
    private function formatBytes($size, $precision = 2)
    {
        if ($size == 0) return '0 B';

        $base = log($size, 1024);
        $suffixes = array('B', 'KB', 'MB', 'GB', 'TB');

        return round(pow(1024, $base - floor($base)), $precision) . ' ' . $suffixes[floor($base)];
    }
}


