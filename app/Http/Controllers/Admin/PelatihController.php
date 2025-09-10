<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CabangOlahraga;
use App\Models\Pelatih;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PelatihController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);

        // Add 'prestasi' to the allowed sorts array
        $allowedSorts = [
            'nama', 'tanggal_lahir', 'kelamin', 'alamat',
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

        $query = Pelatih::with(['cabangOlahraga', 'prestasis' => function ($q) {
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
            $query->where('kelamin', $genderValue);
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

        $pelatih = $query->paginate($perPage);

        $pelatih->appends($request->query());

        $allCabor = CabangOlahraga::pluck('nama_cabor', 'id');
        $allKelamin = Pelatih::select('kelamin')->distinct()->whereNotNull('kelamin')->pluck('kelamin');

        if ($request->ajax()) {
            return view('admin.pelatih._table', compact('pelatih'))->render();
        }

        return view('admin.pelatih.index', compact('pelatih', 'allCabor', 'allKelamin'));
}
    public function create()
    {
        $cabors = CabangOlahraga::pluck('nama_cabor', 'id');
        $allKelamin = ['Laki-Laki', 'Perempuan'];

        return view('admin.pelatih.create', compact('cabors', 'allKelamin'));
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
            'kelamin' => 'required|in:Laki-Laki,Perempuan',
            'no_telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'foto' => 'nullable|image|max:2048',
            'ketersediaan' => 'required|in:Tersedia,Tidak-Tersedia',
        ]);

        try {
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $filename = $file->getClientOriginalName();
                $data['foto'] = $file->storeAs('pelatih', $filename, 'public');
            }

            $pelatih = Pelatih::create($data);

            return redirect()->route('admin.konfigurasi.pelatih.index')
                ->with('OK', 'Data pelatih berhasil disimpan.')
                ->with('action', 'store');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Gagal menyimpan data pelatih. Error: ' . $e->getMessage());
        }
    }

    public function show($id, Request $request)
    {
        $pelatih = Pelatih::with(['cabangOlahraga', 'prestasis'])->findOrFail($id);

        $backUrl = match (request('back')) {
            'cabor'     => route('admin.konfigurasi.cabang-olahraga.show', $pelatih->cabor_id),
            'prestasi' => route('admin.konfigurasi.prestasi.index', $pelatih->id),
            default     => route('admin.konfigurasi.pelatih.index'),
        };


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
                $prestasis = $pelatih->prestasis()
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

        $prestasis = $pelatih->prestasis()
            ->orderBy('created_at', 'desc')
            ->paginate(3);

        return view('admin.pelatih.show', compact('pelatih', 'prestasis','backUrl'));
    }


    public function edit($id)
    {
        $pelatih = Pelatih::findOrFail($id);
        $cabors = CabangOlahraga::pluck('nama_cabor', 'id');
        $allKelamin = ['Laki-Laki', 'Perempuan'];

        return view('admin.pelatih.edit', compact('pelatih', 'cabors', 'allKelamin'));
    }

    public function update(Request $request, Pelatih $pelatih)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'cabor_id' => 'required|exists:cabang_olahragas,id',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'alamatkota' => 'nullable|string|max:255',
            'alamatprovinsi' => 'nullable|string|max:255',
            'kelamin' => 'required|in:Laki-Laki,Perempuan',
            'no_telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'foto' => 'nullable|image|max:2048',
            'ketersediaan' => 'required|in:Tersedia,Tidak-Tersedia',
        ]);

        try {
            if ($request->hasFile('foto')) {
                if ($pelatih->foto) {
                    Storage::disk('public')->delete($pelatih->foto);
                }
                $data['foto'] = $request->file('foto')->store('pelatih', 'public');
            }

            $pelatih->update($data);

            return redirect()->route('admin.konfigurasi.pelatih.index')
                ->with('OK', 'Data pelatih berhasil diubah.')
                ->with('action', 'update');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Gagal mengubah data pelatih. Error: ' . $e->getMessage());
        }
    }

    public function destroy(Request $request, Pelatih $pelatih)
    {
        try {
            if ($pelatih->prestasis()->exists()) {
                $prestasiCount = $pelatih->prestasis()->count();
                $prestasiList = $pelatih->prestasis()->pluck('nama_prestasi')->toArray();

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pelatih tidak dapat dihapus karena masih memiliki prestasi terkait.',
                    'reason' => 'has_prestasis',
                    'prestasi_count' => $prestasiCount,
                    'prestasi_list' => $prestasiList,
                    'pelatih_name' => $pelatih->nama
                ], 422);
            }

                return back()->with('error', "Pelatih tidak dapat dihapus karena masih memiliki {$prestasiCount} prestasi terkait.");
            }

            if ($pelatih->foto) {
                Storage::disk('public')->delete($pelatih->foto);
            }

            $pelatih->delete();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Data pelatih berhasil dihapus.'
                ]);
            }

            return redirect()->route('admin.konfigurasi.pelatih.index')
                ->with('OK', 'Data pelatih berhasil dihapus.')
                ->with('action', 'destroy');

        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'OK' => false,
                    'message' => 'Gagal menghapus data pelatih. Error: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Gagal menghapus data pelatih. Error: ' . $e->getMessage());
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
            $pelatih = Pelatih::findOrFail($id);

            $pelatih->prestasis()->create([
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

            $pelatih = Pelatih::findOrFail($id);
            Log::info('Pelatih found', ['pelatih_id' => $pelatih->id, 'current_ketersediaan' => $pelatih->ketersediaan]);

            $previousValue = $pelatih->ketersediaan;

            $pelatih->ketersediaan = $request->ketersediaan;
            $result = $pelatih->save();

            Log::info('Save result', ['save_result' => $result, 'new_value' => $pelatih->ketersediaan]);

            if ($request->ajax()) {
                $response = [
                    'success' => true,
                    'message' => 'Ketersediaan berhasil diperbarui',
                    'new_value' => $request->ketersediaan,
                    'previous_value' => $previousValue,
                    'debug_info' => [
                        'pelatih_id' => $pelatih->id,
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
            'nama', 'tanggal_lahir', 'kelamin', 'alamat',
            'no_telepon', 'email', 'updated_at', 'created_at'
        ];

        $sortBy = $request->get('sort_by', 'created_at');
        $order = strtolower($request->get('order', 'desc'));

        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'created_at';
        }

        if (!in_array($order, ['asc', 'desc'])) {
            $order = 'desc';
        }

        $query = Pelatih::with('cabangOlahraga');

        $query->orderBy($sortBy, $order);

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
            $query->where('kelamin', $genderValue);
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

        if ($request->filled('filter_ketersediaan')) {
            $query->where('ketersediaan', $request->filter_ketersediaan);
        }

        // Add secondary sorting
        if ($sortBy !== 'created_at') {
            $query->orderBy('created_at', 'desc');
        }

        // Add final ordering by ID for consistency
        $query->orderBy('id', 'desc');

        // Get all matching records for export
        $pelatihData = $query->get();

        // Generate the CSV response using StreamedResponse
        $response = new StreamedResponse(function() use ($pelatihData) {
            $handle = fopen('php://output', 'w');

            // Set UTF-8 BOM for proper Excel compatibility
            fwrite($handle, "\xEF\xBB\xBF");

            // CSV Headers
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

            foreach ($pelatihData as $index => $pelatih) {
                // Calculate age
                $age = $pelatih->tanggal_lahir
                    ? \Carbon\Carbon::parse($pelatih->tanggal_lahir)->age
                    : 'N/A';

                // Combine address components
                $alamatLengkap = collect([
                    $pelatih->alamat,
                    $pelatih->alamatkota,
                    $pelatih->alamatprovinsi
                ])->filter()->implode(', ');

                fputcsv($handle, [
                    $index + 1, // Row number
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
        if ($request->filled('filter_ketersediaan')) {
            $filterInfo .= '_ketersediaan';
        }

        $filename = "pelatih_export{$filterInfo}_{$timestamp}.csv";

        $response->headers->set('Content-Type', 'text/csv; charset=utf-8');
        $response->headers->set('Content-Disposition', "attachment; filename=\"$filename\"");
        $response->headers->set('Cache-Control', 'no-cache, no-store, must-revalidate');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', '0');

        return $response;
    }

    public function exportSinglePdf($id)
    {
        $pelatih = Pelatih::with('cabangOlahraga')->findOrFail($id);
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.pelatih.pdf-export', compact('pelatih'));
        return $pdf->download('pelatih-' . Str::slug($pelatih->nama) . '.pdf');
    }
}
