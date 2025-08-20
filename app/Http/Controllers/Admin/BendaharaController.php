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
            'judul', 'tanggal', 'created_at', 'updated_at', 'file_size'
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
                // Add more searchable fields if needed in the future
                // $q->orWhere('description', 'like', '%' . $searchTerm . '%');
            });
        }

        // Date filtering - Enhanced with better date handling
        if ($request->filled('date_from') || $request->filled('date_to')) {
            try {
                if ($request->filled('date_from') && $request->filled('date_to')) {
                    // Both dates provided - filter between dates (inclusive)
                    $dateFrom = Carbon::parse($request->date_from)->startOfDay();
                    $dateTo = Carbon::parse($request->date_to)->endOfDay();

                    // Ensure date_from is not greater than date_to
                    if ($dateFrom->gt($dateTo)) {
                        $temp = $dateFrom;
                        $dateFrom = $dateTo->copy()->startOfDay();
                        $dateTo = $temp->copy()->endOfDay();
                    }

                    $query->whereBetween('tanggal', [$dateFrom, $dateTo]);
                } elseif ($request->filled('date_from')) {
                    // Only start date provided - filter from this date onwards
                    $dateFrom = Carbon::parse($request->date_from)->startOfDay();
                    $query->where('tanggal', '>=', $dateFrom);
                } elseif ($request->filled('date_to')) {
                    // Only end date provided - filter up to this date
                    $dateTo = Carbon::parse($request->date_to)->endOfDay();
                    $query->where('tanggal', '<=', $dateTo);
                }
            } catch (\Exception $e) {
                // Log the error but continue without date filtering
                Log::warning('Invalid date format in bendahara filter', [
                    'date_from' => $request->date_from,
                    'date_to' => $request->date_to,
                    'error' => $e->getMessage()
                ]);
            }
        }

        // File type filtering - Applied BEFORE pagination
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
                          ->where('dokumen', 'not like', '%.xlsx')
                          ->whereNotNull('dokumen');
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

                // Re-apply search and filter conditions to the new query
                $this->reapplyFilters($query, $request);
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
     * Re-apply filters to a query (used for file size sorting)
     */
    private function reapplyFilters($query, Request $request)
    {
        // Re-apply search
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('judul', 'like', '%' . $searchTerm . '%');
            });
        }

        // Re-apply date filters
        if ($request->filled('date_from') || $request->filled('date_to')) {
            try {
                if ($request->filled('date_from') && $request->filled('date_to')) {
                    $dateFrom = Carbon::parse($request->date_from)->startOfDay();
                    $dateTo = Carbon::parse($request->date_to)->endOfDay();

                    if ($dateFrom->gt($dateTo)) {
                        $temp = $dateFrom;
                        $dateFrom = $dateTo->copy()->startOfDay();
                        $dateTo = $temp->copy()->endOfDay();
                    }

                    $query->whereBetween('created_at', [$dateFrom, $dateTo]);
                } elseif ($request->filled('date_from')) {
                    $dateFrom = Carbon::parse($request->date_from)->startOfDay();
                    $query->where('created_at', '>=', $dateFrom);
                } elseif ($request->filled('date_to')) {
                    $dateTo = Carbon::parse($request->date_to)->endOfDay();
                    $query->where('created_at', '<=', $dateTo);
                }
            } catch (\Exception $e) {
                Log::warning('Invalid date format in reapply filters', [
                    'error' => $e->getMessage()
                ]);
            }
        }

        // Re-apply file type filters
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
                          ->where('dokumen', 'not like', '%.xlsx')
                          ->whereNotNull('dokumen');
                    });
                    break;
            }
        }
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

        // Apply date filters to count query
        if ($request->filled('date_from') || $request->filled('date_to')) {
            try {
                if ($request->filled('date_from') && $request->filled('date_to')) {
                    $dateFrom = Carbon::parse($request->date_from)->startOfDay();
                    $dateTo = Carbon::parse($request->date_to)->endOfDay();

                    if ($dateFrom->gt($dateTo)) {
                        $temp = $dateFrom;
                        $dateFrom = $dateTo->copy()->startOfDay();
                        $dateTo = $temp->copy()->endOfDay();
                    }

                    $baseQuery->whereBetween('created_at', [$dateFrom, $dateTo]);
                } elseif ($request->filled('date_from')) {
                    $dateFrom = Carbon::parse($request->date_from)->startOfDay();
                    $baseQuery->where('created_at', '>=', $dateFrom);
                } elseif ($request->filled('date_to')) {
                    $dateTo = Carbon::parse($request->date_to)->endOfDay();
                    $baseQuery->where('created_at', '<=', $dateTo);
                }
            } catch (\Exception $e) {
                // Continue without date filtering if there's an error
            }
        }

        $counts = [
            'all' => (clone $baseQuery)->count(),
            'pdf' => (clone $baseQuery)->where('dokumen', 'like', '%.pdf')->count(),
            'excel' => (clone $baseQuery)->where(function ($q) {
                $q->where('dokumen', 'like', '%.xls')
                  ->orWhere('dokumen', 'like', '%.xlsx');
            })->count(),
            'other' => (clone $baseQuery)->where(function ($q) {
                $q->where('dokumen', 'not like', '%.pdf')
                  ->where('dokumen', 'not like', '%.xls')
                  ->where('dokumen', 'not like', '%.xlsx')
                  ->whereNotNull('dokumen');
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
            // Enhanced validation with better error messages
            $data = $request->validate([
                'judul' => 'required|string|max:255',
                'tanggal' => 'required|date',
                'dokumen' => 'required|mimes:pdf,xls,xlsx|max:10240',
            ], [
                'judul.required' => 'Judul laporan wajib diisi.',
                'tanggal.required' => 'Tanggal laporan wajib diisi.',
                'judul.max' => 'Judul laporan tidak boleh lebih dari 255 karakter.',
                'dokumen.required' => 'Dokumen wajib diunggah.',
                'dokumen.mimes' => 'Format file harus PDF, XLS, atau XLSX.',
                'dokumen.max' => 'Ukuran file tidak boleh lebih dari 10MB.',
            ]);

            // Handle file upload with additional validation
            if ($request->hasFile('dokumen')) {
                $file = $request->file('dokumen');

                // Additional file validation
                if (!$file->isValid()) {
                    throw new \Exception('File yang diunggah tidak valid atau rusak.');
                }

                // Generate unique filename
                $filename = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
                $data['dokumen'] = $file->storeAs('bendahara', $filename, 'public');

                // Verify file was stored successfully
                if (!Storage::disk('public')->exists($data['dokumen'])) {
                    throw new \Exception('Gagal menyimpan file ke storage.');
                }
            }

            $laporanBendahara = Bendahara::create($data);

            // Log successful creation
            Log::info('Bendahara laporan created successfully', [
                'id' => $laporanBendahara->id,
                'judul' => $laporanBendahara->judul,
                'user_id' => auth()->id() ?? 'unknown'
            ]);

            // Check if it's AJAX request
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Laporan bendahara berhasil disimpan.',
                    'data' => [
                        'id' => $laporanBendahara->id,
                        'judul' => $laporanBendahara->judul
                    ]
                ]);
            }

            return redirect()->route('admin.bendahara.index')
                ->with('OK', 'Laporan bendahara berhasil disimpan.')
                ->with('action', 'store');

        } catch (ValidationException $e) {
            Log::warning('Validation failed in bendahara store', [
                'errors' => $e->errors(),
                'input' => $request->except(['dokumen'])
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
            Log::error('Failed to store bendahara laporan', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'input' => $request->except(['dokumen'])
            ]);

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
        try {
            $laporanBendahara = Bendahara::findOrFail($id);
            return view('admin.bendahara.show', compact('laporanBendahara'));
        } catch (\Exception $e) {
            return redirect()->route('admin.bendahara.index')
                ->with('error', 'Laporan tidak ditemukan.');
        }
    }

    public function edit($id)
    {
        try {
            $laporanBendahara = Bendahara::findOrFail($id);
            return view('admin.bendahara.edit', compact('laporanBendahara'));
        } catch (\Exception $e) {
            return redirect()->route('admin.bendahara.index')
                ->with('error', 'Laporan tidak ditemukan.');
        }
    }

    public function update(Request $request, Bendahara $bendahara)
    {
        try {
            Log::info('Update request received', [
                'bendahara_id' => $bendahara->id,
                'judul' => $request->input('judul'),
                'has_file' => $request->hasFile('dokumen'),
                'request_method' => $request->method()
            ]);

            // Enhanced validation
            $data = $request->validate([
                'judul' => 'required|string|max:255',
                'tanggal' => 'required|date',
                'dokumen' => 'nullable|mimes:pdf,xls,xlsx|max:10240',
            ], [
                'judul.required' => 'Judul laporan wajib diisi.',
                'tanggal.required' => 'Tanggal laporan wajib diisi.',
                'judul.max' => 'Judul laporan tidak boleh lebih dari 255 karakter.',
                'dokumen.mimes' => 'Format file harus PDF, XLS, atau XLSX.',
                'dokumen.max' => 'Ukuran file tidak boleh lebih dari 10MB.',
            ]);

            Log::info('Validation passed', ['validated_data' => $data]);

            // Handle file upload if provided
            if ($request->hasFile('dokumen')) {
                $file = $request->file('dokumen');

                // Additional file validation
                if (!$file->isValid()) {
                    throw new \Exception('File yang diunggah tidak valid atau rusak.');
                }

                // Delete old file if exists
                if ($bendahara->dokumen && Storage::disk('public')->exists($bendahara->dokumen)) {
                    Storage::disk('public')->delete($bendahara->dokumen);
                    Log::info('Old file deleted', ['file' => $bendahara->dokumen]);
                }

                // Store new file with unique name
                $filename = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
                $data['dokumen'] = $file->storeAs('bendahara', $filename, 'public');

                // Verify file was stored successfully
                if (!Storage::disk('public')->exists($data['dokumen'])) {
                    throw new \Exception('Gagal menyimpan file baru ke storage.');
                }

                Log::info('New file uploaded', ['file' => $data['dokumen']]);
            }

            $bendahara->update($data);

            // Log successful update
            Log::info('Bendahara laporan updated successfully', [
                'id' => $bendahara->id,
                'judul' => $bendahara->judul,
                'file_updated' => $request->hasFile('dokumen'),
                'user_id' => auth()->id() ?? 'unknown'
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Laporan bendahara berhasil diperbarui.',
                    'data' => [
                        'id' => $bendahara->id,
                        'judul' => $bendahara->judul
                    ]
                ]);
            }

            return redirect()->route('admin.bendahara.index')
                ->with('OK', 'Laporan bendahara berhasil diubah.')
                ->with('action', 'update');

        } catch (ValidationException $e) {
            Log::error('Validation failed in bendahara update', [
                'bendahara_id' => $bendahara->id,
                'errors' => $e->errors(),
                'input' => $request->except(['dokumen']),
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
            Log::error('Failed to update bendahara laporan', [
                'bendahara_id' => $bendahara->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'input' => $request->except(['dokumen'])
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
            $deletedTitle = $bendahara->judul;
            $deletedFile = $bendahara->dokumen;

            // Delete file if exists
            if ($bendahara->dokumen && Storage::disk('public')->exists($bendahara->dokumen)) {
                Storage::disk('public')->delete($bendahara->dokumen);
                Log::info('File deleted from storage', ['file' => $bendahara->dokumen]);
            }

            $bendahara->delete();

            // Log successful deletion
            Log::info('Bendahara laporan deleted successfully', [
                'deleted_title' => $deletedTitle,
                'deleted_file' => $deletedFile,
                'user_id' => auth()->id() ?? 'unknown'
            ]);

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
            Log::error('Failed to delete bendahara laporan', [
                'bendahara_id' => $bendahara->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

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
        try {
            $laporanBendahara = Bendahara::findOrFail($id);

            if (!$laporanBendahara->dokumen) {
                return back()->with('error', 'Dokumen tidak tersedia.');
            }

            $filePath = storage_path('app/public/' . $laporanBendahara->dokumen);

            if (!file_exists($filePath)) {
                Log::warning('Download requested but file not found', [
                    'laporan_id' => $id,
                    'expected_path' => $filePath
                ]);
                return back()->with('error', 'File tidak ditemukan.');
            }

            // Generate a clean filename for download
            $extension = pathinfo($laporanBendahara->dokumen, PATHINFO_EXTENSION);
            $fileName = str_replace(['/', '\\', ':', '*', '?', '"', '<', '>', '|'], '_', $laporanBendahara->judul);
            $fileName = $fileName . '_' . date('Y-m-d') . '.' . $extension;

            // Log the download
            Log::info('File downloaded', [
                'laporan_id' => $id,
                'judul' => $laporanBendahara->judul,
                'filename' => $fileName,
                'user_id' => auth()->id() ?? 'unknown'
            ]);

            return response()->download($filePath, $fileName);

        } catch (\Exception $e) {
            Log::error('Failed to download file', [
                'laporan_id' => $id,
                'error' => $e->getMessage()
            ]);
            return back()->with('error', 'Gagal mengunduh file: ' . $e->getMessage());
        }
    }

    /**
     * Bulk delete multiple records
     */
    public function bulkDelete(Request $request)
    {
        try {
            $ids = $request->validate([
                'ids' => 'required|array|min:1',
                'ids.*' => 'exists:bendahara,id'
            ])['ids'];

            $deletedCount = 0;
            $errors = [];

            foreach ($ids as $id) {
                try {
                    $bendahara = Bendahara::find($id);
                    if ($bendahara) {
                        // Delete file if exists
                        if ($bendahara->dokumen && Storage::disk('public')->exists($bendahara->dokumen)) {
                            Storage::disk('public')->delete($bendahara->dokumen);
                        }
                        $bendahara->delete();
                        $deletedCount++;
                    }
                } catch (\Exception $e) {
                    $errors[] = "Gagal menghapus laporan ID {$id}: " . $e->getMessage();
                }
            }

            Log::info('Bulk delete completed', [
                'requested_count' => count($ids),
                'deleted_count' => $deletedCount,
                'errors' => $errors
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => "{$deletedCount} laporan berhasil dihapus." .
                                (count($errors) > 0 ? " Beberapa item gagal dihapus." : ""),
                    'deleted_count' => $deletedCount,
                    'errors' => $errors
                ]);
            }

            $message = "{$deletedCount} laporan berhasil dihapus.";
            if (count($errors) > 0) {
                $message .= " Namun ada beberapa item yang gagal dihapus.";
            }

            return redirect()->route('admin.bendahara.index')->with('OK', $message);

        } catch (ValidationException $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak valid.',
                    'errors' => $e->errors()
                ], 422);
            }
            return back()->withErrors($e->errors());
        } catch (\Exception $e) {
            Log::error('Bulk delete failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus laporan: ' . $e->getMessage()
                ], 500);
            }
            return back()->with('error', 'Gagal menghapus laporan: ' . $e->getMessage());
        }
    }

    /**
     * Export laporan data to Excel/CSV
     */
    public function export(Request $request)
    {
        try {
            $format = $request->get('format', 'excel'); // excel or csv
            $query = Bendahara::query();

            // Apply same filters as index
            if ($request->filled('search')) {
                $searchTerm = $request->search;
                $query->where('judul', 'like', '%' . $searchTerm . '%');
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
                              ->where('dokumen', 'not like', '%.xlsx')
                              ->whereNotNull('dokumen');
                        });
                        break;
                }
            }

            $data = $query->orderBy('created_at', 'desc')->get();

            // For now, return JSON data. In a real implementation,
            // you'd use something like Laravel Excel for proper export
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'data' => $data->map(function ($item) {
                        return [
                            'id' => $item->id,
                            'judul' => $item->judul,
                            'dokumen' => $item->dokumen ? basename($item->dokumen) : null,
                            'file_size' => $item->dokumen && Storage::disk('public')->exists($item->dokumen)
                                ? Storage::disk('public')->size($item->dokumen) : 0,
                            'created_at' => $item->created_at->format('Y-m-d H:i:s'),
                            'updated_at' => $item->updated_at->format('Y-m-d H:i:s'),
                        ];
                    })
                ]);
            }

            return back()->with('info', 'Export feature will be implemented with proper Excel/CSV library.');

        } catch (\Exception $e) {
            Log::error('Export failed', [
                'error' => $e->getMessage(),
                'request' => $request->all()
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mengekspor data: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Gagal mengekspor data: ' . $e->getMessage());
        }
    }

    /**
     * Get statistics for dashboard
     */
    public function getStats()
    {
        try {
            $totalLaporan = Bendahara::count();
            $laporanBulanIni = Bendahara::whereMonth('created_at', now()->month)
                                       ->whereYear('created_at', now()->year)
                                       ->count();

            $fileCounts = [
                'pdf' => Bendahara::where('dokumen', 'like', '%.pdf')->count(),
                'excel' => Bendahara::where(function ($q) {
                    $q->where('dokumen', 'like', '%.xls')
                      ->orWhere('dokumen', 'like', '%.xlsx');
                })->count(),
                'other' => Bendahara::where(function ($q) {
                    $q->where('dokumen', 'not like', '%.pdf')
                      ->where('dokumen', 'not like', '%.xls')
                      ->where('dokumen', 'not like', '%.xlsx')
                      ->whereNotNull('dokumen');
                })->count()
            ];

            return response()->json([
                'success' => true,
                'stats' => [
                    'total_laporan' => $totalLaporan,
                    'laporan_bulan_ini' => $laporanBulanIni,
                    'file_counts' => $fileCounts
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to get stats', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil statistik: ' . $e->getMessage()
            ], 500);
        }
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

    /**
     * Cleanup orphaned files (files in storage without database records)
     */
    public function cleanupOrphanedFiles()
    {
        try {
            $storageFiles = Storage::disk('public')->files('bendahara');
            $dbFiles = Bendahara::whereNotNull('dokumen')
                                ->pluck('dokumen')
                                ->toArray();

            $orphanedFiles = array_diff($storageFiles, $dbFiles);
            $deletedCount = 0;

            foreach ($orphanedFiles as $file) {
                if (Storage::disk('public')->delete($file)) {
                    $deletedCount++;
                }
            }

            Log::info('Cleanup completed', [
                'total_storage_files' => count($storageFiles),
                'total_db_files' => count($dbFiles),
                'orphaned_files' => count($orphanedFiles),
                'deleted_files' => $deletedCount
            ]);

            return response()->json([
                'success' => true,
                'message' => "Cleanup selesai. {$deletedCount} file orphan berhasil dihapus dari {$orphanedFiles} file yang ditemukan.",
                'deleted_count' => $deletedCount
            ]);

        } catch (\Exception $e) {
            Log::error('Cleanup failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal melakukan cleanup: ' . $e->getMessage()
            ], 500);
        }
    }
}
