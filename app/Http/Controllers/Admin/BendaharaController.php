<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bendahara;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class BendaharaController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);

        // Validate per_page value
        $allowedPerPage = [10, 25, 50, 100];
        if (!in_array($perPage, $allowedPerPage)) {
            $perPage = 10;
        }

        $allowedSorts = [
            'judul', 'created_at', 'updated_at', 'file_size'
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

         if ($request->filled('date_from') || $request->filled('date_to')) {
            if ($request->filled('date_from') && $request->filled('date_to')) {
                // Both dates provided - filter between dates (inclusive)
                $dateFrom = Carbon::parse($request->date_from)->startOfDay();
                $dateTo = Carbon::parse($request->date_to)->endOfDay();

                $query->whereBetween('created_at', [$dateFrom, $dateTo]);
            } elseif ($request->filled('date_from')) {
                // Only start date provided - filter from this date onwards
                $dateFrom = Carbon::parse($request->date_from)->startOfDay();
                $query->where('created_at', '>=', $dateFrom);
            } elseif ($request->filled('date_to')) {
                // Only end date provided - filter up to this date
                $dateTo = Carbon::parse($request->date_to)->endOfDay();
                $query->where('created_at', '<=', $dateTo);
            }
        }

        // File type filtering - Applied BEFORE pagination (Updated for PDF and Excel only)
        if ($request->filled('filter_type') && $request->filter_type !== 'all') {
            $filterType = $request->filter_type;

            switch ($filterType) {
                case 'pdf':
                    $query->where('dokumen', 'like', '%.pdf');
                    break;
                case 'excel':
                    $query->where(function ($q) {
                        $q->where('dokumen', 'like', '%.xls')
                          ->orWhere('dokumen', 'like', '%.xlsx');
                    });
                    break;
                case 'other':
                    $query->where(function ($q) {
                        $q->where('dokumen', 'not like', '%.pdf')
                          ->where('dokumen', 'not like', '%.xls')
                          ->where('dokumen', 'not like', '%.xlsx');
                    });
                    break;
            }
        }

        // Handle sorting
        if ($sortBy === 'file_size') {
            // For file size sorting, we need to get all records first to sort by actual file size
            $allRecords = $query->get()->map(function ($item) {
                if ($item->dokumen && Storage::disk('public')->exists($item->dokumen)) {
                    $item->actual_file_size = Storage::disk('public')->size($item->dokumen);
                } else {
                    $item->actual_file_size = 0;
                }
                return $item;
            });

            // Sort by file size
            if ($order === 'desc') {
                $allRecords = $allRecords->sortByDesc('actual_file_size');
            } else {
                $allRecords = $allRecords->sortBy('actual_file_size');
            }

            // Get the IDs in the sorted order
            $sortedIds = $allRecords->pluck('id')->toArray();

            // Create a new query with the sorted order
            if (!empty($sortedIds)) {
                $orderByIds = implode(',', $sortedIds);
                $query = Bendahara::whereIn('id', $sortedIds)
                    ->orderByRaw("FIELD(id, $orderByIds)");

                // Re-apply search and filter conditions
                if ($request->filled('search')) {
                    $searchTerm = $request->search;
                    $query->where(function ($q) use ($searchTerm) {
                        $q->where('judul', 'like', '%' . $searchTerm . '%');
                    });
                }

                if ($request->filled('date_from') || $request->filled('date_to')) {
                    if ($request->filled('date_from') && $request->filled('date_to')) {
                        $dateFrom = Carbon::parse($request->date_from)->startOfDay();
                        $dateTo = Carbon::parse($request->date_to)->endOfDay();
                        $query->whereBetween('created_at', [$dateFrom, $dateTo]);
                    } elseif ($request->filled('date_from')) {
                        $dateFrom = Carbon::parse($request->date_from)->startOfDay();
                        $query->where('created_at', '>=', $dateFrom);
                    } elseif ($request->filled('date_to')) {
                        $dateTo = Carbon::parse($request->date_to)->endOfDay();
                        $query->where('created_at', '<=', $dateTo);
                    }
                }

                if ($request->filled('filter_type') && $request->filter_type !== 'all') {
                    $filterType = $request->filter_type;
                    switch ($filterType) {
                        case 'pdf':
                            $query->where('dokumen', 'like', '%.pdf');
                            break;
                        case 'excel':
                            $query->where(function ($q) {
                                $q->where('dokumen', 'like', '%.xls')
                                  ->orWhere('dokumen', 'like', '%.xlsx');
                            });
                            break;
                        case 'other':
                            $query->where(function ($q) {
                                $q->where('dokumen', 'not like', '%.pdf')
                                  ->where('dokumen', 'not like', '%.xls')
                                  ->where('dokumen', 'not like', '%.xlsx');
                            });
                            break;
                    }
                }
            }
        } else {
            // Handle normal sorting
            $query->orderBy($sortBy, $order);
        }

        // Add secondary sorting for consistency (only if not already sorting by created_at)
        if ($sortBy !== 'created_at') {
            $query->orderBy('created_at', 'desc');
        }

        // Add final ordering by ID for consistency
        $query->orderBy('id', 'desc');

        $laporanBendahara = $query->paginate($perPage);
        $laporanBendahara->appends($request->query());

        // Get file counts for all data (for filter dropdown)
        $fileCounts = $this->getFileCounts($request);

        // Get current sort parameters for the view
        $currentSort = [
            'sort_by' => $sortBy,
            'order' => $order
        ];

        if ($request->ajax()) {
            return view('admin.bendahara._table', compact('laporanBendahara', 'fileCounts', 'currentSort'))->render();
        }

        return view('admin.bendahara.index', compact('laporanBendahara', 'fileCounts', 'currentSort'));
    }

    /**
     * Get file counts for filter dropdown (Updated for PDF and Excel only)
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
            'excel' => (clone $baseQuery)->where(function ($q) {
                $q->where('dokumen', 'like', '%.xls')
                  ->orWhere('dokumen', 'like', '%.xlsx');
            })->count(),
            'other' => (clone $baseQuery)->where(function ($q) {
                $q->where('dokumen', 'not like', '%.pdf')
                  ->where('dokumen', 'not like', '%.xls')
                  ->where('dokumen', 'not like', '%.xlsx');
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
            // Updated validation for PDF and Excel only
            $data = $request->validate([
                'judul' => 'required|string|max:255',
                'dokumen' => 'required|mimes:pdf,xls,xlsx|max:10240',
            ], [
                'judul.required' => 'Judul laporan wajib diisi.',
                'judul.max' => 'Judul laporan tidak boleh lebih dari 255 karakter.',
                'dokumen.required' => 'Dokumen wajib diunggah.',
                'dokumen.mimes' => 'Format file harus PDF, XLS, atau XLSX.',
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
                    'errors' => $e->errors(),
                    'message' => 'Validasi gagal. Periksa kembali form Anda.'
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
            \Log::info('Update request data:', [
                'judul' => $request->input('judul'),
                'all_data' => $request->all(),
                'has_file' => $request->hasFile('dokumen')
            ]);

            $data = $request->validate([
                'judul' => 'required|string|max:255',
                'dokumen' => 'nullable|mimes:pdf,xls,xlsx|max:10240',
            ], [
                'judul.required' => 'Judul laporan wajib diisi.',
                'judul.max' => 'Judul laporan tidak boleh lebih dari 255 karakter.',
                'dokumen.mimes' => 'Format file harus PDF, XLS, atau XLSX.',
                'dokumen.max' => 'Ukuran file tidak boleh lebih dari 10MB.',
            ]);

            \Log::info('Validated data:', $data);

            if ($request->hasFile('dokumen')) {
                if ($bendahara->dokumen) {
                    Storage::disk('public')->delete($bendahara->dokumen);
                }
                $data['dokumen'] = $request->file('dokumen')->store('bendahara', 'public');
            }

            $bendahara->update($data);

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
            \Log::error('Validation failed:', [
                'errors' => $e->errors(),
                'request_data' => $request->all(),
                'validator_failed_rules' => $e->validator->failed()
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'errors' => $e->errors(),
                    'message' => 'Validasi gagal. Periksa kembali form Anda.'
                ], 422);
            }
            return back()->withInput()->withErrors($e->errors());
        } catch (\Exception $e) {
            \Log::error('Update failed:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);

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
