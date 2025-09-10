<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CabangOlahraga;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CabangOlahragaController extends Controller
{
    public function index(Request $request)
    {
        // Tambahkan eager loading untuk menghindari N+1 query problem
        $query = CabangOlahraga::with(['atlets', 'pelatihs']);

        // PERBAIKAN: Search functionality - Konsisten menggunakan 'search'
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_cabor', 'LIKE', "%{$search}%")
                    ->orWhere('ketua_penanggung_jawab', 'LIKE', "%{$search}%");
            });
        }

        // Apply status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Apply sorting - MODIFIKASI: Default sorting berdasarkan data terbaru
        $sortBy = $request->get('sort_by', 'terakhir_update'); // Ubah default ke terakhir_update
        $order = $request->get('order', 'desc'); // Ubah default ke desc (terbaru dulu)

        // Validate sort fields
        $allowedSortFields = [
            'nama_cabor',
            'ketua_penanggung_jawab',
            'status',
            'tanggal_pembentukan',
            'terakhir_update',
            'created_at', // Tambahkan created_at untuk sorting
            'id' // Tambahkan id untuk sorting
        ];

        if (in_array($sortBy, $allowedSortFields)) {
            $query->orderBy($sortBy, $order);
        } else {
            // Default sorting: data terbaru dulu
            $query->orderBy('terakhir_update', 'desc')
                  ->orderBy('created_at', 'desc'); // Sebagai backup sorting
        }

        // PERBAIKAN: Per page handling yang lebih robust
        $perPage = (int) $request->get('per_page', 10);

        // Validasi perPage
        $allowedPerPage = [10, 25, 50, 100];
        if (!in_array($perPage, $allowedPerPage)) {
            $perPage = 10;
        }

        // PERBAIKAN: Paginate dengan append query yang konsisten
        /** @var \Illuminate\Contracts\Pagination\LengthAwarePaginator $cabors */
        $cabors = $query->paginate($perPage);

        // Tambahkan semua query parameters ke pagination links
        $cabors->appends($request->only([
            'search',
            'status',
            'sort_by',
            'order',
            'per_page'
        ]));

        // PERBAIKAN: Debug logging untuk development (bisa dihapus di production)
        if (config('app.debug')) {
            Log::info('CabangOlahraga Index Query', [
                'search' => $request->input('search'),
                'status' => $request->input('status'),
                'sort_by' => $sortBy,
                'order' => $order,
                'per_page' => $perPage,
                'total_results' => $cabors->total(),
                'current_page' => $cabors->currentPage()
            ]);
        }

        // TAMBAHAN: Handle AJAX requests untuk compatibility dengan frontend
        if ($request->ajax() || $request->wantsJson()) {
            try {
                // Render table partial
                $tableHtml = view('admin.cabang-olahraga.partials.table', compact('cabors'))->render();

                // Render pagination partial
                $paginationHtml = view('admin.cabang-olahraga.partials.pagination', compact('cabors'))->render();

                return response()->json([
                    'success' => true,
                    'html' => $tableHtml,
                    'pagination' => $paginationHtml,
                    'total' => $cabors->total(),
                    'current_page' => $cabors->currentPage(),
                    'last_page' => $cabors->lastPage(),
                    'per_page' => $cabors->perPage(),
                    'from' => $cabors->firstItem(),
                    'to' => $cabors->lastItem(),
                ]);
            } catch (\Exception $e) {
                Log::error('Error rendering AJAX response: ' . $e->getMessage(), [
                    'request' => $request->all(),
                    'exception' => $e->getTraceAsString()
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat memuat data.',
                    'error' => config('app.debug') ? $e->getMessage() : null
                ], 500);
            }
        }

        return view('admin.cabang-olahraga.index', compact('cabors'));
    }

    public function create()
    {
        return view('admin.cabang-olahraga.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_cabor' => 'required|string|max:50',
            'ketua_penanggung_jawab' => 'required|string|max:100',
            'status' => 'required|in:Aktif,Pembinaan',
            'tanggal_pembentukan' => 'required|date',
            'icon_cabor' => 'nullable|file|mimes:png,webp,svg|max:2048',
        ], [
            'icon_cabor.mimes' => 'Ikon cabang olahraga harus berupa file PNG, WebP, atau SVG.',
            'icon_cabor.max' => 'Ukuran file ikon tidak boleh lebih dari 2MB.',
        ]);

        if ($request->hasFile('icon_cabor')) {
            $path = $this->handleIconUpload($request->file('icon_cabor'));
            $validatedData['icon_cabor'] = $path;
        }

        $validatedData['terakhir_update'] = now();
        $validatedData['created_at'] = now(); // Pastikan created_at di-set

        CabangOlahraga::create($validatedData);

        // SOLUSI 1: Redirect dengan parameter untuk memastikan halaman pertama dan sorting terbaru
        return redirect()->route('admin.konfigurasi.cabang-olahraga.index', [
            'page' => 1, // Paksa ke halaman pertama
            'sort_by' => 'terakhir_update', // Sorting berdasarkan terakhir update
            'order' => 'desc' // Order descending (terbaru dulu)
        ])->with('cabor_created', 'Cabang olahraga berhasil ditambahkan.');

        // ALTERNATIF SOLUSI 2: Jika ingin lebih sederhana
        // return redirect()->route('admin.konfigurasi.cabang-olahraga.index')
        //     ->with('cabor_created', 'Cabang olahraga berhasil ditambahkan.')
        //     ->with('show_new_data', true); // Flag untuk highlight data baru
    }

    public function show($cabor)
    {
        $cabor = CabangOlahraga::with(['atlets', 'pelatihs'])->findOrFail($cabor);

        // Tambahkan paginate untuk atlet dan pelatih
        $atlets = $cabor->atlets()->paginate(10, ['*'], 'atlet_page');
        $pelatihs = $cabor->pelatihs()->paginate(10, ['*'], 'pelatih_page');

        return view('admin.cabang-olahraga.show', compact('cabor', 'atlets', 'pelatihs'));
    }

    public function edit($cabor)
    {
        $cabor = CabangOlahraga::findOrFail($cabor);
        return view('admin.cabang-olahraga.edit', compact('cabor'));
    }

    public function update(Request $request, $cabor)
    {
        $cabor = CabangOlahraga::findOrFail($cabor);

        $validatedData = $request->validate([
            'nama_cabor' => 'required|string|max:50',
            'ketua_penanggung_jawab' => 'required|string|max:100',
            'status' => 'required|in:Aktif,Pembinaan',
            'tanggal_pembentukan' => 'required|date',
            'icon_cabor' => 'nullable|file|mimes:png,webp,svg|max:2048',
        ], [
            'icon_cabor.mimes' => 'Ikon cabang olahraga harus berupa file PNG, WebP, atau SVG.',
            'icon_cabor.max' => 'Ukuran file ikon tidak boleh lebih dari 2MB.',
        ]);

        if ($request->hasFile('icon_cabor')) {
            // Hapus icon lama jika ada
            if ($cabor->icon_cabor) {
                Storage::disk('public')->delete($cabor->icon_cabor);
            }

            $path = $this->handleIconUpload($request->file('icon_cabor'));
            $validatedData['icon_cabor'] = $path;
        }

        $validatedData['terakhir_update'] = now();

        $cabor->update($validatedData);

        // MODIFIKASI: Redirect dengan parameter untuk highlight data yang diupdate
        return redirect()->route('admin.konfigurasi.cabang-olahraga.index', [
            'page' => 1,
            'sort_by' => 'terakhir_update',
            'order' => 'desc'
        ])->with('cabor_updated', 'Cabang olahraga berhasil diperbarui.');
    }

    public function destroy(Request $request, $cabor)
    {
        // Check if this is a POST request with _method=DELETE (method spoofing)
        if ($request->method() === 'POST' && $request->input('_method') === 'DELETE') {
            // Continue with the deletion process
        } 
        // Check if this is a direct DELETE request
        elseif ($request->method() === 'DELETE') {
            // Continue with the deletion process
        }
        // If neither, return error
        else {
            return response()->json([
                'success' => false,
                'message' => 'Method not allowed'
            ], 405);
        }

        try {
            $cabor = CabangOlahraga::with(['atlets', 'pelatihs'])->findOrFail($cabor);

            // Cek apakah masih ada atlet yang terkait
            $jumlahAtlet = $cabor->atlets()->count();
            $jumlahPelatih = $cabor->pelatihs()->count();
            $totalData = $jumlahAtlet + $jumlahPelatih;

            if ($totalData > 0) {
                return response()->json([
                    'success' => false,
                    'reason' => 'has_dependencies',
                    'cabor_name' => $cabor->nama_cabor,
                    'atlet_count' => $jumlahAtlet,
                    'pelatih_count' => $jumlahPelatih,
                    'message' => "Tidak dapat menghapus cabang olahraga '{$cabor->nama_cabor}' karena masih ada data terkait."
                ], 400);
            }

            // Jika tidak ada data terkait, lanjutkan penghapusan
            if ($cabor->icon_cabor) {
                Storage::disk('public')->delete($cabor->icon_cabor);
            }

            $cabor->delete();

            return response()->json([
                'success' => true,
                'message' => 'Cabang olahraga berhasil dihapus.'
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            // Tangkap error foreign key constraint dari database
            if ($e->getCode() == '23000') {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak dapat menghapus cabang olahraga ini karena masih ada data terkait. Silakan hapus data terkait terlebih dahulu.'
                ], 400);
            }

            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus cabang olahraga: ' . $e->getMessage()
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus: ' . $e->getMessage()
            ], 500);
        }
    }

    // Method untuk nonaktifkan cabor (sebagai alternatif)
    public function deactivate($cabor)
    {
        try {
            $cabor = CabangOlahraga::findOrFail($cabor);

            $cabor->update([
                'status' => 'Pembinaan',
                'terakhir_update' => now()
            ]);

            return redirect()->route('admin.konfigurasi.cabang-olahraga.index', [
                'page' => 1,
                'sort_by' => 'terakhir_update',
                'order' => 'desc'
            ])->with('cabor_updated', "Cabang olahraga '{$cabor->nama_cabor}' berhasil dinonaktifkan.");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menonaktifkan cabang olahraga: ' . $e->getMessage());
        }
    }

    // Method untuk cek dependency (untuk AJAX call jika diperlukan)
    public function checkDependencies($cabor)
    {
        try {
            $cabor = CabangOlahraga::with(['atlets', 'pelatihs'])->findOrFail($cabor);

            $jumlahAtlet = $cabor->atlets()->count();
            $jumlahPelatih = $cabor->pelatihs()->count();
            $totalData = $jumlahAtlet + $jumlahPelatih;

            return response()->json([
                'can_delete' => $totalData === 0,
                'dependencies' => [
                    'atlet' => $jumlahAtlet,
                    'pelatih' => $jumlahPelatih,
                    'total' => $totalData
                ],
                'message' => $totalData > 0 ?
                    "Masih ada {$jumlahAtlet} atlet dan {$jumlahPelatih} pelatih yang terkait" :
                    'Dapat dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // Method untuk force destroy (menghapus permanen meskipun ada data terkait)
    public function forceDestroy($cabor)
    {
        try {
            $cabor = CabangOlahraga::findOrFail($cabor);

            // Hapus icon jika ada
            if ($cabor->icon_cabor) {
                Storage::disk('public')->delete($cabor->icon_cabor);
            }

            // Hapus cabang olahraga (akan menghapus data terkait karena ada constraint foreign key)
            $cabor->delete();

            return redirect()->route('admin.konfigurasi.cabang-olahraga.index')
                ->with('cabor_deleted', 'Cabang olahraga berhasil dihapus permanen.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus permanen cabang olahraga: ' . $e->getMessage());
        }
    }

    // TAMBAHAN: Method untuk menampilkan data terbaru (alternatif)
    public function latest()
    {
        return redirect()->route('admin.konfigurasi.cabang-olahraga.index', [
            'page' => 1,
            'sort_by' => 'created_at',
            'order' => 'desc',
            'per_page' => 10
        ]);
    }

    // TAMBAHAN: Method untuk export data ke Excel
     public function exportExcel(Request $request)
    {
        try {
            $startTime = microtime(true);
            
            Log::info('Export Excel request initiated', [
                'user_id' => auth()->id(),
                'filters' => $request->only(['search', 'status', 'sort_by', 'order']),
                'timestamp' => now()
            ]);

            // ✅ FIXED: Use withCount for better performance
            $query = CabangOlahraga::withCount(['atlets', 'pelatihs']);

            // Apply search filter
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('nama_cabor', 'LIKE', "%{$search}%")
                      ->orWhere('singkatan', 'LIKE', "%{$search}%")
                      ->orWhere('ketua_penanggung_jawab', 'LIKE', "%{$search}%");
                });
            }

            // Apply status filter
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            // Apply sorting
            $sortBy = $request->get('sort_by', 'terakhir_update');
            $order = $request->get('order', 'desc');

            $allowedSortFields = [
                'nama_cabor', 
                'singkatan',
                'ketua_penanggung_jawab', 
                'status', 
                'tanggal_pembentukan', 
                'terakhir_update', 
                'created_at', 
                'id'
            ];

            if (in_array($sortBy, $allowedSortFields)) {
                $query->orderBy($sortBy, $order);
            } else {
                $query->orderBy('terakhir_update', 'desc')
                      ->orderBy('created_at', 'desc');
            }

            // ✅ FIXED: Get all filtered data (no pagination for export)
            $cabors = $query->get();

            Log::info('Export data prepared', [
                'total_records' => $cabors->count(),
                'memory_usage' => memory_get_usage(true),
                'elapsed_time' => microtime(true) - $startTime
            ]);

            // ✅ FIXED: Create StreamedResponse for memory efficiency with proper Excel format
            $response = new StreamedResponse(function() use ($cabors, $request, $startTime) {
                $handle = fopen('php://output', 'w');
                
                // ✅ FIXED: Add UTF-8 BOM for proper Excel encoding
                fwrite($handle, "\xEF\xBB\xBF");

                // ✅ FIXED: Proper CSV Headers for Cabang Olahraga
                $headers = [
                    'No',
                    'Nama Cabang Olahraga',
                    'Singkatan',
                    'Ketua Penanggung Jawab',
                    'Status',
                    'Tanggal Pembentukan',
                    'Jumlah Atlet',
                    'Jumlah Pelatih',
                    'Total Data',
                    'Terakhir Update',
                    'Tanggal Dibuat'
                ];
                
                fputcsv($handle, $headers);

                // ✅ FIXED: Data rows with proper formatting
                foreach ($cabors as $index => $cabor) {
                    $row = [
                        $index + 1,
                        $cabor->nama_cabor ?? '-',
                        $cabor->singkatan ?? '-',
                        $cabor->ketua_penanggung_jawab ?? '-',
                        $cabor->status ?? '-',
                        $cabor->tanggal_pembentukan ? 
                            \Carbon\Carbon::parse($cabor->tanggal_pembentukan)->format('d/m/Y') : '-',
                        $cabor->atlets_count ?? 0,
                        $cabor->pelatihs_count ?? 0,
                        ($cabor->atlets_count ?? 0) + ($cabor->pelatihs_count ?? 0),
                        $cabor->terakhir_update ? 
                            \Carbon\Carbon::parse($cabor->terakhir_update)->format('d/m/Y H:i:s') : '-',
                        $cabor->created_at ? 
                            \Carbon\Carbon::parse($cabor->created_at)->format('d/m/Y H:i:s') : '-'
                    ];
                    
                    fputcsv($handle, $row);
                }

                fclose($handle);
                
                Log::info('Export completed', [
                    'total_time' => microtime(true) - $startTime,
                    'final_memory' => memory_get_usage(true)
                ]);
            });

            // ✅ FIXED: Generate filename with current timestamp and filters
            $timestamp = now()->format('Y-m-d_H-i-s');
            $filterSuffix = '';
            
            if ($request->filled('search') || $request->filled('status')) {
                $filters = [];
                if ($request->filled('search')) {
                    $filters[] = 'search-' . str_replace(' ', '-', substr($request->search, 0, 10));
                }
                if ($request->filled('status')) {
                    $filters[] = strtolower($request->status);
                }
                $filterSuffix = '_' . implode('_', $filters);
            }
            
            $filename = "Data_Cabang_Olahraga_{$timestamp}{$filterSuffix}.csv";

            // ✅ FIXED: Set proper response headers for Excel download
            $response->headers->set('Content-Type', 'text/csv; charset=utf-8');
            $response->headers->set('Content-Disposition', "attachment; filename=\"$filename\"");
            $response->headers->set('Cache-Control', 'no-cache, no-store, must-revalidate');
            $response->headers->set('Pragma', 'no-cache');
            $response->headers->set('Expires', '0');
            
            return $response;

        } catch (\Exception $e) {
            Log::error('Error exporting cabang olahraga', [
                'error_message' => $e->getMessage(),
                'error_file' => $e->getFile(),
                'error_line' => $e->getLine(),
                'request_data' => $request->all(),
                'user_id' => auth()->id()
            ]);

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mengekspor data: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'Gagal mengekspor data: ' . $e->getMessage());
        }
    }

/**
 * Export data with custom date range (optional enhancement)
 */
public function exportExcelWithDateRange(Request $request)
    {
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date'
        ]);

        // Add date filtering to the query if dates provided
        if ($request->filled('start_date') || $request->filled('end_date')) {
            $originalMethod = $this->exportExcel($request);
            return $originalMethod;
        }

        return $this->exportExcel($request);
    }

    public function resetFilters(Request $request)
    {
        return redirect()->route('admin.konfigurasi.cabang-olahraga.index');
    }

/**
 * Get export preview (first 10 rows) for validation
 */
    public function exportPreview(Request $request)
    {
        try {
            $query = CabangOlahraga::withCount(['atlets', 'pelatihs']);

            // Apply same filters as export
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('nama_cabor', 'LIKE', "%{$search}%")
                      ->orWhere('singkatan', 'LIKE', "%{$search}%")
                      ->orWhere('ketua_penanggung_jawab', 'LIKE', "%{$search}%");
                });
            }

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            $total = $query->count();
            $preview = $query->limit(10)->get();

            return response()->json([
                'success' => true,
                'total_records' => $total,
                'preview_data' => $preview->map(function($cabor) {
                    return [
                        'nama_cabor' => $cabor->nama_cabor,
                        'singkatan' => $cabor->singkatan,
                        'ketua_penanggung_jawab' => $cabor->ketua_penanggung_jawab,
                        'status' => $cabor->status,
                        'jumlah_atlet' => $cabor->atlets_count ?? 0,
                        'jumlah_pelatih' => $cabor->pelatihs_count ?? 0,
                    ];
                }),
                'message' => "Siap mengekspor {$total} records"
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat preview: ' . $e->getMessage()
            ], 500);
        }
    }

    // Method untuk export atlet berdasarkan cabang olahraga
    public function exportAtlet(Request $request, $caborId)
    {
        // Redirect ke AtletController dengan parameter cabor_id
        $request->merge(['cabor_id' => $caborId]);
        return redirect()->route('admin.konfigurasi.atlet.export', ['cabor_id' => $caborId]);
    }

    // Method untuk export pelatih berdasarkan cabang olahraga
    public function exportPelatih(Request $request, $caborId)
    {
        // Redirect ke PelatihController dengan parameter cabor_id
        $request->merge(['cabor_id' => $caborId]);
        return redirect()->route('admin.konfigurasi.pelatih.export', ['cabor_id' => $caborId]);
    }

    // Method untuk export gabungan atlet dan pelatih dalam satu file Excel
    public function exportExcelGabungan(Request $request, $caborId)
    {
        try {
            // Ambil data cabang olahraga
            $cabor = CabangOlahraga::findOrFail($caborId);
            
            // Ambil data atlet dengan relasi
            $atlets = $cabor->atlets()->with(['cabangOlahraga', 'prestasis' => function ($q) {
                $q->orderByDesc('tahun');
            }])->withCount('prestasis')->get();
            
            // Ambil data pelatih dengan relasi
            $pelatihs = $cabor->pelatihs()->with('cabangOlahraga')->get();
            
            // Buat response streamed
            $response = new StreamedResponse(function() use ($cabor, $atlets, $pelatihs) {
                $handle = fopen('php://output', 'w');
                
                // Set UTF-8 BOM untuk kompatibilitas Excel
                fwrite($handle, "\xEF\xBB\xBF");
                
                // Informasi Cabang Olahraga
                fputcsv($handle, ["DATA GABUNGAN CABANG OLAHRAGA " . strtoupper($cabor->nama_cabor)]);
                fputcsv($handle, []);
                fputcsv($handle, ["INFORMASI UMUM"]);
                fputcsv($handle, ['Nama Cabang Olahraga', $cabor->nama_cabor]);
                fputcsv($handle, ['Ketua Penanggung Jawab', $cabor->ketua_penanggung_jawab ?? '-']);
                fputcsv($handle, ['Tanggal Pembentukan', $cabor->tanggal_pembentukan ? \Carbon\Carbon::parse($cabor->tanggal_pembentukan)->format('d/m/Y') : '-']);
                fputcsv($handle, ['Status', $cabor->status]);
                fputcsv($handle, []);
                fputcsv($handle, []);
                
                // Bagian Atlet
                fputcsv($handle, ["DATA ATLET"]);
                fputcsv($handle, [
                    'No',
                    'Nama Atlet',
                    'Cabang Olahraga',
                    'Jenis Kelamin',
                    'Tempat Lahir',
                    'Tanggal Lahir',
                    'Usia',
                    'Alamat Lengkap',
                    'No Telepon',
                    'Email',
                    'Ketersediaan',
                    'Total Prestasi',
                    'Prestasi Terbaru',
                    'Tahun Prestasi Terbaru',
                    'Tempat Prestasi Terbaru'
                ]);
                
                foreach ($atlets as $index => $atlet) {
                    $prestasiTerbaru = $atlet->prestasis->first();
                    
                    // Hitung usia
                    $age = $atlet->tanggal_lahir
                        ? \Carbon\Carbon::parse($atlet->tanggal_lahir)->age
                        : 'N/A';
                    
                    // Gabungkan komponen alamat
                    $alamatLengkap = collect([
                        $atlet->alamat,
                        $atlet->alamatkota,
                        $atlet->alamatprovinsi
                    ])->filter()->implode(', ');
                    
                    fputcsv($handle, [
                        $index + 1,
                        $atlet->nama,
                        $atlet->cabangOlahraga->nama_cabor ?? '-',
                        $atlet->jenis_kelamin,
                        $atlet->tempat_lahir,
                        $atlet->tanggal_lahir
                            ? \Carbon\Carbon::parse($atlet->tanggal_lahir)->format('d/m/Y')
                            : '-',
                        $age . ' tahun',
                        $alamatLengkap ?: '-',
                        $atlet->no_telepon ?: '-',
                        $atlet->email ?: '-',
                        $atlet->ketersediaan,
                        $atlet->prestasis_count,
                        $prestasiTerbaru ? $prestasiTerbaru->nama_prestasi : '-',
                        $prestasiTerbaru ? $prestasiTerbaru->tahun : '-',
                        $prestasiTerbaru ? $prestasiTerbaru->tempat : '-'
                    ]);
                }
                
                fputcsv($handle, []);
                fputcsv($handle, []);
                
                // Bagian Pelatih
                fputcsv($handle, ["DATA PELATIH"]);
                fputcsv($handle, [
                    'No',
                    'Nama Pelatih',
                    'Cabang Olahraga',
                    'Jenis Kelamin',
                    'Tempat Lahir',
                    'Tanggal Lahir',
                    'Usia',
                    'Alamat Lengkap',
                    'No Telepon',
                    'Email',
                    'Ketersediaan',
                ]);
                
                foreach ($pelatihs as $index => $pelatih) {
                    // Hitung usia
                    $age = $pelatih->tanggal_lahir
                        ? \Carbon\Carbon::parse($pelatih->tanggal_lahir)->age
                        : 'N/A';
                    
                    // Gabungkan komponen alamat
                    $alamatLengkap = collect([
                        $pelatih->alamat,
                        $pelatih->alamatkota,
                        $pelatih->alamatprovinsi
                    ])->filter()->implode(', ');
                    
                    fputcsv($handle, [
                        $index + 1,
                        $pelatih->nama,
                        $pelatih->cabangOlahraga->nama_cabor ?? '-',
                        $pelatih->kelamin,
                        $pelatih->tempat_lahir,
                        $pelatih->tanggal_lahir
                            ? \Carbon\Carbon::parse($pelatih->tanggal_lahir)->format('d/m/Y')
                            : '-',
                        $age . ' tahun',
                        $alamatLengkap ?: '-',
                        $pelatih->no_telepon ?: '-',
                        $pelatih->email ?: '-',
                        $pelatih->ketersediaan,
                    ]);
                }
                
                fclose($handle);
            });
            
            // Buat nama file
            $timestamp = now()->format('Y-m-d_H-i-s');
            $filename = "Data_Gabungan_{$cabor->nama_cabor}_{$timestamp}.csv";
            
            // Set header response
            $response->headers->set('Content-Type', 'text/csv; charset=utf-8');
            $response->headers->set('Content-Disposition', "attachment; filename=\"{$filename}\"");
            $response->headers->set('Cache-Control', 'no-cache, no-store, must-revalidate');
            $response->headers->set('Pragma', 'no-cache');
            $response->headers->set('Expires', '0');
            
            return $response;
            
        } catch (\Exception $e) {
            Log::error('Error exporting gabungan data', [
                'error_message' => $e->getMessage(),
                'error_file' => $e->getFile(),
                'error_line' => $e->getLine(),
                'cabor_id' => $caborId,
                'user_id' => auth()->id()
            ]);
            
            return redirect()->back()->with('error', 'Gagal mengekspor data gabungan: ' . $e->getMessage());
        }
    }

    /**
     * Menangani upload icon dan resize ke 80x80px
     */
    private function handleIconUpload($file)
    {
        $extension = strtolower($file->getClientOriginalExtension());
        $filename = time() . '_' . uniqid() . '.' . $extension;
        $path = 'icons/cabor/' . $filename;

        // Untuk file SVG, langsung simpan
        if ($extension === 'svg') {
            $file->storeAs('icons/cabor', $filename, 'public');
            return $path;
        }

        // Gunakan library GD untuk resize
        $this->resizeImageGD($file->getRealPath(), storage_path('app/public/' . $path), 80, 80);

        return $path;
    }

    /**
     * Resize gambar menggunakan library GD
     */
    private function resizeImageGD($sourcePath, $destinationPath, $width, $height)
    {
        $info = \getimagesize($sourcePath);
        if (!$info) {
            return false;
        }

        $mime = $info['mime'];

        switch ($mime) {
            case 'image/jpeg':
                $source = \imagecreatefromjpeg($sourcePath);
                break;
            case 'image/png':
                $source = \imagecreatefrompng($sourcePath);
                break;
            case 'image/webp':
                if (\function_exists('imagecreatefromwebp')) {
                    $source = \imagecreatefromwebp($sourcePath);
                } else {
                    return false;
                }
                break;
            default:
                return false;
        }

        if (!$source) {
            return false;
        }

        // Dapatkan dimensi asli
        $originalWidth = \imagesx($source);
        $originalHeight = \imagesy($source);

        // Hitung dimensi baru dengan mempertahankan aspect ratio
        $aspectRatio = $originalWidth / $originalHeight;
        if ($width / $height > $aspectRatio) {
            $newWidth = $height * $aspectRatio;
            $newHeight = $height;
        } else {
            $newWidth = $width;
            $newHeight = $width / $aspectRatio;
        }

        // Buat canvas dengan ukuran yang diinginkan
        $dest = \imagecreatetruecolor($width, $height);

        // Set background transparan untuk PNG dan WebP
        if ($mime == 'image/png' || $mime == 'image/webp') {
            \imagealphablending($dest, false);
            \imagesavealpha($dest, true);
            $transparent = \imagecolorallocatealpha($dest, 0, 0, 0, 127);
            \imagefill($dest, 0, 0, $transparent);
        }

        // Hitung posisi untuk center crop
        $srcX = 0;
        $srcY = 0;
        $dstX = ($width - $newWidth) / 2;
        $dstY = ($height - $newHeight) / 2;

        // Resize dan copy gambar
        \imagecopyresampled(
            $dest,
            $source,
            $dstX,
            $dstY,
            $srcX,
            $srcY,
            $newWidth,
            $newHeight,
            $originalWidth,
            $originalHeight
        );

        // Pastikan direktori ada
        $directory = dirname($destinationPath);
        if (!\file_exists($directory)) {
            \mkdir($directory, 0755, true);
        }

        // Simpan gambar sesuai format
        $result = false;
        if (strpos($destinationPath, '.webp') !== false) {
            if (\function_exists('imagewebp')) {
                $result = \imagewebp($dest, $destinationPath, 90);
            }
        } elseif (strpos($destinationPath, '.jpg') !== false || strpos($destinationPath, '.jpeg') !== false) {
            $result = \imagejpeg($dest, $destinationPath, 90);
        } else {
            $result = \imagepng($dest, $destinationPath, 8);
        }

        // Bersihkan memory
        \imagedestroy($source);
        \imagedestroy($dest);

        return $result;
    }

    
}