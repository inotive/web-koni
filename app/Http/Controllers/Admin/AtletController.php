<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CabangOlahraga;
use App\Models\Atlet;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AtletController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);


        // Add 'prestasi' to the allowed sorts array
        $allowedSorts = [
            'nama', 'tanggal_lahir', 'jenis_kelamin', 'alamat',
            'no_telepon', 'email', 'updated_at', 'created_at', 'prestasi'
        ];

        $sortBy = $request->get('sort_by', 'created_at');
        $order = strtolower($request->get('order', 'desc'));

        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'created_at';
        }

        if (!in_array($order, ['asc', 'desc'])) {
            $order = 'desc';
        }

        $query = Atlet::with(['cabangOlahraga', 'prestasis' => function ($q) {
            $q->orderByDesc('tahun');
        }])
        ->withCount('prestasis');

        // Handle prestasi sorting separately
        if ($sortBy === 'prestasi') {
            // Simple approach: just sort by prestasis_count
            $query->orderBy('prestasis_count', $order);
        } else {
            // Handle regular sorting
            $query->orderBy($sortBy, $order);
        }

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('nama', 'like', '%' . $searchTerm . '%')
                ->orWhere('email', 'like', '%' . $searchTerm . '%')
                ->orWhere('no_telepon', 'like', '%' . $searchTerm . '%')
                ->orWhere('alamat', 'like', '%' . $searchTerm . '%')
                ->orWhere('alamatkota', 'like', '%' . $searchTerm . '%')
                ->orWhere('alamatprovinsi', 'like', '%' . $searchTerm . '%')
                ->orWhere('tempat_lahir', 'like', '%' . $searchTerm . '%')
                ->orWhereHas('cabangOlahraga', function ($q) use ($searchTerm) {
                    $q->where('nama_cabor', 'like', '%' . $searchTerm . '%');
                })
                ->orWhereHas('prestasis', function ($q) use ($searchTerm) {
                    $q->where('nama_prestasi', 'like', '%' . $searchTerm . '%')
                    ->orWhere('tempat', 'like', '%' . $searchTerm . '%');
                });
            });
        }

        if ($request->filled('cabor') || $request->filled('filter_cabor')) {
            $caborValue = $request->filled('cabor') ? $request->cabor : $request->filter_cabor;
            $query->whereHas('cabangOlahraga', function ($q) use ($caborValue) {
                $q->where('nama_cabor', $caborValue);
            });
        }

        if ($request->filled('gender') || $request->filled('filter_gender')) {
            $genderValue = $request->filled('gender') ? $request->gender : $request->filter_gender;
            $query->where('jenis_kelamin', $genderValue);
        }

        if ($request->filled('age') || $request->filled('filter_age')) {
            $ageValue = $request->filled('age') ? $request->age : $request->filter_age;

            if ($ageValue === '60+' || $ageValue === '36+') {
                $minAge = $ageValue === '60+' ? 60 : 36;
                $query->whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) >= ?', [$minAge]);
            } else {
                [$min, $max] = array_map('intval', explode('-', $ageValue));
                $query->whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN ? AND ?', [$min, $max]);
            }
        }

        if ($request->filled('prestasi') || $request->filled('filter_prestasi')) {
            $prestasiValue = $request->filled('prestasi') ? $request->prestasi : $request->filter_prestasi;

            switch ($prestasiValue) {
                case 'ada':
                    $query->has('prestasis');
                    break;
                case 'tidak':
                    $query->doesntHave('prestasis');
                    break;
                case 'emas':
                case 'perak':
                case 'perunggu':
                    $query->whereHas('prestasis', function ($q) use ($prestasiValue) {
                        $q->where('medali', ucfirst($prestasiValue));
                    });
                    break;
            }
        }

        if ($request->filled('filter_ketersediaan')) {
            $query->where('ketersediaan', $request->filter_ketersediaan);
        }

        // Add secondary sorting for non-prestasi sorts
        if ($sortBy !== 'created_at' && $sortBy !== 'prestasi') {
            $query->orderBy('created_at', 'desc');
        }

        // Add final ordering by ID for consistency
        $query->orderBy('id', 'desc');

        $atlet = $query->paginate($perPage);

        $atlet->appends($request->query());

        $allCabor = CabangOlahraga::pluck('nama_cabor', 'id');
        $allKelamin = Atlet::select('jenis_kelamin')->distinct()->whereNotNull('jenis_kelamin')->pluck('jenis_kelamin');

        if ($request->ajax()) {
            return view('admin.atlet._table', compact('atlet'))->render();
        }

        return view('admin.atlet.index', compact('atlet', 'allCabor', 'allKelamin'));
}
    public function create()
    {
        $cabors = CabangOlahraga::pluck('nama_cabor', 'id');
        $allKelamin = ['Laki-Laki', 'Perempuan'];

        return view('admin.atlet.create', compact('cabors', 'allKelamin'));
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'cabor_id' => 'required|exists:cabang_olahragas,id',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'alamatkota' => 'nullable|string|max:255',
            'alamatprovinsi' => 'nullable|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-Laki,Perempuan',
            'no_telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'foto' => 'nullable|image|max:2048',
            'ketersediaan' => 'required|in:Tersedia,Tidak-Tersedia',
        ]);

        try {
            if ($request->hasFile('foto')) {
                $data['foto'] = $request->file('foto')->store('atlet', 'public');
            }

            $atlet = Atlet::create($data);

            return redirect()->route('admin.konfigurasi.atlet.index')
                ->with('OK', 'Data atlet berhasil disimpan.')
                ->with('action', 'store');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Gagal menyimpan data atlet. Error: ' . $e->getMessage());
        }
    }

    public function show($id, Request $request)
    {
        $atlet = Atlet::with(['cabangOlahraga', 'prestasis'])->findOrFail($id);

        $backUrl = match (request('back')) {
            'cabor'     => route('admin.konfigurasi.cabang-olahraga.show', $atlet->cabor_id),
            'prestasi' => route('admin.konfigurasi.prestasi.index', $atlet->id),
            default     => route('admin.konfigurasi.atlet.index'),
        };

        $backUrl = request('back') === 'cabor'
        ? route('admin.konfigurasi.cabang-olahraga.show', $atlet->cabor_id)
        : route('admin.konfigurasi.atlet.index');


        if ($request->ajax() || $request->get('ajax')) {
            $perPage = $request->get('per_page', 3);
            $sortBy = $request->get('sort_by', 'created_at');
            $order = $request->get('order', 'desc');

            $allowedSortColumns = ['created_at', 'nama_prestasi', 'tahun', 'tempat', 'medali'];
            if (!in_array($sortBy, $allowedSortColumns)) {
                $sortBy = 'created_at';
            }

            $order = in_array(strtolower($order), ['asc', 'desc']) ? $order : 'desc';

            try {
                $prestasis = $atlet->prestasis()
                    ->orderBy($sortBy, $order)
                    ->paginate($perPage);

                $response = [
                    'success' => true,
                    'prestasis' => $prestasis->items(),
                    'pagination' => [
                        'current_page' => $prestasis->currentPage(),
                        'last_page' => $prestasis->lastPage(),
                        'per_page' => $prestasis->perPage(),
                        'total' => $prestasis->total(),
                        'from' => $prestasis->firstItem(),
                        'to' => $prestasis->lastItem(),
                        'has_more_pages' => $prestasis->hasMorePages()
                    ]
                ];

                return response()->json($response);

            } catch (\Exception $e) {
                Log::error('Error loading prestasi: ' . $e->getMessage());

                return response()->json([
                    'success' => false,
                    'message' => 'Error loading prestasi data',
                    'error' => $e->getMessage()
                ], 500);
            }
        }

        $prestasis = $atlet->prestasis()
            ->orderBy('created_at', 'desc')
            ->paginate(3);

        return view('admin.atlet.show', compact('atlet', 'prestasis','backUrl'));
    }


    public function edit($id)
    {
        $atlet = Atlet::findOrFail($id);
        $cabors = CabangOlahraga::pluck('nama_cabor', 'id');
        $allKelamin = ['Laki-Laki', 'Perempuan'];

        return view('admin.atlet.edit', compact('atlet', 'cabors', 'allKelamin'));
    }

    public function update(Request $request, Atlet $atlet)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'cabor_id' => 'required|exists:cabang_olahragas,id',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'alamatkota' => 'nullable|string|max:255',
            'alamatprovinsi' => 'nullable|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-Laki,Perempuan',
            'no_telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'foto' => 'nullable|image|max:2048',
            'ketersediaan' => 'required|in:Tersedia,Tidak-Tersedia',
        ]);

        try {
            if ($request->hasFile('foto')) {
                if ($atlet->foto) {
                    Storage::disk('public')->delete($atlet->foto);
                }
                $data['foto'] = $request->file('foto')->store('atlet', 'public');
            }

            $atlet->update($data);

            return redirect()->route('admin.konfigurasi.atlet.index')
                ->with('OK', 'Data atlet berhasil diubah.')
                ->with('action', 'update');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Gagal mengubah data atlet. Error: ' . $e->getMessage());
        }
    }

    public function destroy(Request $request, Atlet $atlet)
    {
        try {
            if ($atlet->prestasis()->exists()) {
                $prestasiCount = $atlet->prestasis()->count();
                $prestasiList = $atlet->prestasis()->pluck('nama_prestasi')->toArray();

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Atlet tidak dapat dihapus karena masih memiliki prestasi terkait.',
                    'reason' => 'has_prestasis',
                    'prestasi_count' => $prestasiCount,
                    'prestasi_list' => $prestasiList,
                    'atlet_name' => $atlet->nama
                ], 422);
            }

                return back()->with('error', "Atlet tidak dapat dihapus karena masih memiliki {$prestasiCount} prestasi terkait.");
            }

            if ($atlet->foto) {
                Storage::disk('public')->delete($atlet->foto);
            }

            $atlet->delete();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Data atlet berhasil dihapus.'
                ]);
            }

            return redirect()->route('admin.konfigurasi.atlet.index')
                ->with('OK', 'Data atlet berhasil dihapus.')
                ->with('action', 'destroy');

        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'OK' => false,
                    'message' => 'Gagal menghapus data atlet. Error: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Gagal menghapus data atlet. Error: ' . $e->getMessage());
        }
    }

    public function addPrestasi(Request $request, $id)
    {
        $request->validate([
            'tahun' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'tempat' => 'required|string|max:255',
            'nama_prestasi' => 'required|string|max:255',
        ]);

        try {
            $atlet = Atlet::findOrFail($id);

            $atlet->prestasis()->create([
                'tahun' => $request->tahun,
                'tempat' => $request->tempat,
                'nama_prestasi' => $request->nama_prestasi
            ]);

            return redirect()->back()
                ->with('OK', 'Prestasi berhasil ditambahkan.');
        } catch (\Exception $e) {
            return back()->with('ERR', 'Gagal menambahkan prestasi. Error: ' . $e->getMessage());
        }
    }

    public function updateKetersediaan(Request $request, $id)
    {
        Log::info('updateKetersediaan called', [
            'id' => $id,
            'request_data' => $request->all(),
            'method' => $request->method(),
            'is_ajax' => $request->ajax()
        ]);

        try {
            $validated = $request->validate([
                'ketersediaan' => 'required|in:Tersedia,Tidak-Tersedia'
            ]);

            Log::info('Validation passed', $validated);

            $atlet = Atlet::findOrFail($id);
            Log::info('Atlet found', ['atlet_id' => $atlet->id, 'current_ketersediaan' => $atlet->ketersediaan]);

            $previousValue = $atlet->ketersediaan;

            $atlet->ketersediaan = $request->ketersediaan;
            $result = $atlet->save();

            Log::info('Save result', ['save_result' => $result, 'new_value' => $atlet->ketersediaan]);

            if ($request->ajax()) {
                $response = [
                    'success' => true,
                    'message' => 'Ketersediaan berhasil diperbarui',
                    'new_value' => $request->ketersediaan,
                    'previous_value' => $previousValue,
                    'debug_info' => [
                        'atlet_id' => $atlet->id,
                        'save_result' => $result
                    ]
                ];

                Log::info('Sending AJAX response', $response);
                return response()->json($response);
            }

            return redirect()->back()->with('OK', 'Ketersediaan berhasil diperbarui');

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error', ['errors' => $e->errors()]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak valid',
                    'errors' => $e->errors()
                ], 422);
            }

            return redirect()->back()->withErrors($e->errors());

        } catch (\Exception $e) {
            Log::error('General error', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
                    'debug_info' => [
                        'error_file' => $e->getFile(),
                        'error_line' => $e->getLine()
                    ]
                ], 500);
            }

            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui data');
        }
    }

    public function exportCsv(Request $request)
    {
        // Build the same query as the index method to ensure consistency
        $allowedSorts = [
            'nama', 'tanggal_lahir', 'jenis_kelamin', 'alamat',
            'no_telepon', 'email', 'updated_at', 'created_at', 'prestasi'
        ];

        $sortBy = $request->get('sort_by', 'created_at');
        $order = strtolower($request->get('order', 'desc'));

        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'created_at';
        }

        if (!in_array($order, ['asc', 'desc'])) {
            $order = 'desc';
        }

        $query = Atlet::with(['cabangOlahraga', 'prestasis' => function ($q) {
            $q->orderByDesc('tahun');
        }])
        ->withCount('prestasis');

        // Handle prestasi sorting separately
        if ($sortBy === 'prestasi') {
            $query->orderBy('prestasis_count', $order);
        } else {
            $query->orderBy($sortBy, $order);
        }

        // If cabor_id is provided in the request, filter by that cabang olahraga
        if ($request->filled('cabor_id')) {
            $query->where('cabor_id', $request->cabor_id);
        }

        // Apply the same filters as the index method
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('nama', 'like', '%' . $searchTerm . '%')
                ->orWhere('email', 'like', '%' . $searchTerm . '%')
                ->orWhere('no_telepon', 'like', '%' . $searchTerm . '%')
                ->orWhere('alamat', 'like', '%' . $searchTerm . '%')
                ->orWhere('alamatkota', 'like', '%' . $searchTerm . '%')
                ->orWhere('alamatprovinsi', 'like', '%' . $searchTerm . '%')
                ->orWhere('tempat_lahir', 'like', '%' . $searchTerm . '%')
                ->orWhereHas('cabangOlahraga', function ($q) use ($searchTerm) {
                    $q->where('nama_cabor', 'like', '%' . $searchTerm . '%');
                })
                ->orWhereHas('prestasis', function ($q) use ($searchTerm) {
                    $q->where('nama_prestasi', 'like', '%' . $searchTerm . '%')
                    ->orWhere('tempat', 'like', '%' . $searchTerm . '%');
                });
            });
        }

        // Apply all filters using the same logic as index method
        if ($request->filled('cabor') || $request->filled('filter_cabor')) {
            $caborValue = $request->filled('cabor') ? $request->cabor : $request->filter_cabor;
            $query->whereHas('cabangOlahraga', function ($q) use ($caborValue) {
                $q->where('nama_cabor', $caborValue);
            });
        }

        if ($request->filled('gender') || $request->filled('filter_gender')) {
            $genderValue = $request->filled('gender') ? $request->gender : $request->filter_gender;
            $query->where('jenis_kelamin', $genderValue);
        }

        if ($request->filled('age') || $request->filled('filter_age')) {
            $ageValue = $request->filled('age') ? $request->age : $request->filter_age;

            if ($ageValue === '60+' || $ageValue === '36+') {
                $minAge = $ageValue === '60+' ? 60 : 36;
                $query->whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) >= ?', [$minAge]);
            } else {
                [$min, $max] = array_map('intval', explode('-', $ageValue));
                $query->whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN ? AND ?', [$min, $max]);
            }
        }

        if ($request->filled('prestasi') || $request->filled('filter_prestasi')) {
            $prestasiValue = $request->filled('prestasi') ? $request->prestasi : $request->filter_prestasi;

            switch ($prestasiValue) {
                case 'ada':
                    $query->has('prestasis');
                    break;
                case 'tidak':
                    $query->doesntHave('prestasis');
                    break;
                case 'emas':
                case 'perak':
                case 'perunggu':
                    $query->whereHas('prestasis', function ($q) use ($prestasiValue) {
                        $q->where('medali', ucfirst($prestasiValue));
                    });
                    break;
            }
        }

        if ($request->filled('filter_ketersediaan')) {
            $query->where('ketersediaan', $request->filter_ketersediaan);
        }

        // Add secondary sorting for non-prestasi sorts
        if ($sortBy !== 'created_at' && $sortBy !== 'prestasi') {
            $query->orderBy('created_at', 'desc');
        }

        // Add final ordering by ID for consistency
        $query->orderBy('id', 'desc');

        // Get all matching records for export
        $atletData = $query->get();

        // Generate the CSV response using StreamedResponse like in LpjController
        $response = new StreamedResponse(function() use ($atletData) {
            $handle = fopen('php://output', 'w');

            // Set UTF-8 BOM for proper Excel compatibility
            fwrite($handle, "\xEF\xBB\xBF");

            // CSV Headers
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

            foreach ($atletData as $index => $atlet) {
                $prestasiTerbaru = $atlet->prestasis->first();

                // Calculate age
                $age = $atlet->tanggal_lahir
                    ? \Carbon\Carbon::parse($atlet->tanggal_lahir)->age
                    : 'N/A';

                // Combine address components
                $alamatLengkap = collect([
                    $atlet->alamat,
                    $atlet->alamatkota,
                    $atlet->alamatprovinsi
                ])->filter()->implode(', ');

                fputcsv($handle, [
                    $index + 1, // Row number
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

            fclose($handle);
        });

        // Generate filename with timestamp and applied filters
        $timestamp = now()->format('Y-m-d_H-i-s');
        $filterInfo = '';

        if ($request->filled('search')) {
            $filterInfo .= '_search';
        }
        if ($request->filled('filter_cabor') || $request->filled('cabor_id')) {
            $filterInfo .= '_cabor';
        }
        if ($request->filled('filter_gender')) {
            $filterInfo .= '_gender';
        }
        if ($request->filled('filter_age')) {
            $filterInfo .= '_age';
        }
        if ($request->filled('filter_prestasi')) {
            $filterInfo .= '_prestasi';
        }
        if ($request->filled('filter_ketersediaan')) {
            $filterInfo .= '_ketersediaan';
        }

        $filename = "atlet_export{$filterInfo}_{$timestamp}.csv";

        $response->headers->set('Content-Type', 'text/csv; charset=utf-8');
        $response->headers->set('Content-Disposition', "attachment; filename=\"{$filename}\"");
        $response->headers->set('Cache-Control', 'no-cache, no-store, must-revalidate');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', '0');

        return $response;
    }

    public function exportDetail(Atlet $atlet)
    {
        try {
            // Load atlet with related data
            $atlet->load(['cabangOlahraga', 'prestasis' => function ($query) {
                $query->orderBy('tahun', 'desc');
            }]);

            // Generate the CSV response using StreamedResponse
            $response = new StreamedResponse(function() use ($atlet) {
                $handle = fopen('php://output', 'w');

                // Set UTF-8 BOM for proper Excel compatibility
                fwrite($handle, "\xEF\xBB\xBF");

                // CSV Headers for atlet details
                fputcsv($handle, ['DATA DETAIL ATLET']);
                fputcsv($handle, []);
                
                // Personal Info
                fputcsv($handle, ['INFORMASI PRIBADI']);
                fputcsv($handle, ['Nama', $atlet->nama]);
                fputcsv($handle, ['Cabang Olahraga', $atlet->cabangOlahraga->nama_cabor ?? '-']);
                fputcsv($handle, ['Email', $atlet->email ?? '-']);
                fputcsv($handle, ['No Telepon', $atlet->no_telepon ?? '-']);
                fputcsv($handle, ['Tempat Lahir', $atlet->tempat_lahir ?? '-']);
                fputcsv($handle, ['Tanggal Lahir', $atlet->tanggal_lahir ? \Carbon\Carbon::parse($atlet->tanggal_lahir)->format('d/m/Y') : '-']);
                fputcsv($handle, ['Jenis Kelamin', $atlet->jenis_kelamin]);
                fputcsv($handle, ['Ketersediaan', $atlet->ketersediaan]);
                fputcsv($handle, []);
                
                // Address Info
                fputcsv($handle, ['ALAMAT']);
                fputcsv($handle, ['Alamat', $atlet->alamat ?? '-']);
                fputcsv($handle, ['Kota', $atlet->alamatkota ?? '-']);
                fputcsv($handle, ['Provinsi', $atlet->alamatprovinsi ?? '-']);
                fputcsv($handle, []);
                
                // Prestasi Info
                fputcsv($handle, ['RIWAYAT PRESTASI']);
                fputcsv($handle, ['Total Prestasi', $atlet->prestasis->count()]);
                fputcsv($handle, []);
                
                // Prestasi details header
                if ($atlet->prestasis->count() > 0) {
                    fputcsv($handle, [
                        'No',
                        'Nama Prestasi',
                        'Kejuaraan',
                        'Cabang Olahraga',
                        'Tingkat',
                        'Tempat',
                        'Tahun',
                        'Medali'
                    ]);
                    
                    foreach ($atlet->prestasis as $index => $prestasi) {
                        fputcsv($handle, [
                            $index + 1,
                            $prestasi->nama_prestasi ?? '-',
                            $prestasi->kejuaraan ?? '-',
                            $prestasi->cabangOlahraga->nama_cabor ?? '-',
                            $prestasi->tingkat ?? '-',
                            $prestasi->tempat ?? '-',
                            $prestasi->tahun ?? '-',
                            $prestasi->medali ?? '-'
                        ]);
                    }
                } else {
                    fputcsv($handle, ['Belum ada data prestasi']);
                }

                fclose($handle);
            });

            // Generate filename
            $timestamp = now()->format('Y-m-d_H-i-s');
            $filename = "detail_atlet_{$atlet->id}_{$timestamp}.csv";

            $response->headers->set('Content-Type', 'text/csv; charset=utf-8');
            $response->headers->set('Content-Disposition', "attachment; filename=\"{$filename}\"");
            $response->headers->set('Cache-Control', 'no-cache, no-store, must-revalidate');
            $response->headers->set('Pragma', 'no-cache');
            $response->headers->set('Expires', '0');

            return $response;
        } catch (\Exception $e) {
            \Log::error('Error exporting atlet detail: ' . $e->getMessage(), [
                'atlet_id' => $atlet->id,
                'exception' => $e
            ]);
            
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengekspor data atlet.');
        }
    }
}
