<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Atlet;
use App\Models\Pelatih;
use App\Models\Prestasi;
use App\Models\CabangOlahraga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PrestasiController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);

        $allowedSorts = [
            'nama', 'jenis_kelamin', 'nama_prestasi', 'cabor', 'tingkat',
            'tempat', 'tahun', 'medali', 'updated_at', 'created_at'
        ];

        $sortBy = $request->get('sort_by', 'created_at');
        $order = strtolower($request->get('order', 'desc'));

        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'created_at';
        }
        if (!in_array($order, ['asc', 'desc'])) {
            $order = 'desc';
        }

        // PERBAIKAN: Cek request get_tahun di awal sebelum query besar
        if ($request->get('get_tahun')) {
            $years = Prestasi::distinct()
                ->pluck('tahun')
                ->filter(function($year) {
                    return !is_null($year) && $year !== '';
                })
                ->sortDesc()
                ->values()
                ->toArray();

            \Log::info('Years data:', ['years' => $years]);
            return response()->json($years);
        }

        $query = Prestasi::with(['subject', 'cabangOlahraga'])
            ->select('prestasis.*');

        switch ($sortBy) {
            case 'nama':
                $query->join(DB::raw("(
                    SELECT id, nama, 'App\Models\Atlet' as type FROM atlets
                    UNION ALL
                    SELECT id, nama, 'App\Models\Pelatih' as type FROM pelatih
                ) as subjects"), function($join) {
                    $join->on('prestasis.subject_id', '=', 'subjects.id')
                         ->on('prestasis.subject_type', '=', 'subjects.type');
                })->orderBy('subjects.nama', $order);
                break;

            case 'jenis_kelamin':
                $query->join(DB::raw("(
                    SELECT id,
                           CASE WHEN jenis_kelamin = 'L' OR jenis_kelamin = 'Laki-laki' THEN 'Laki-laki'
                                WHEN jenis_kelamin = 'P' OR jenis_kelamin = 'Perempuan' THEN 'Perempuan'
                                ELSE jenis_kelamin END as gender,
                           'App\Models\Atlet' as type
                    FROM atlets
                    UNION ALL
                    SELECT id,
                           CASE WHEN kelamin = 'L' OR kelamin = 'Laki-laki' THEN 'Laki-laki'
                                WHEN kelamin = 'P' OR kelamin = 'Perempuan' THEN 'Perempuan'
                                ELSE kelamin END as gender,
                           'App\Models\Pelatih' as type
                    FROM pelatih
                ) as subjects"), function($join) {
                    $join->on('prestasis.subject_id', '=', 'subjects.id')
                         ->on('prestasis.subject_type', '=', 'subjects.type');
                })->orderBy('subjects.gender', $order);
                break;

            case 'cabor':
                $query->join(DB::raw("(
                    SELECT id, cabor_id, 'App\Models\Atlet' as type FROM atlets
                    UNION ALL
                    SELECT id, cabor_id, 'App\Models\Pelatih' as type FROM pelatih
                ) as subjects"), function($join) {
                    $join->on('prestasis.subject_id', '=', 'subjects.id')
                         ->on('prestasis.subject_type', '=', 'subjects.type');
                })
                ->join('cabang_olahragas', 'subjects.cabor_id', '=', 'cabang_olahragas.id')
                ->orderBy('cabang_olahragas.nama_cabor', $order);
                break;

            default:
                $query->orderBy($sortBy, $order);
                break;
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_prestasi', 'like', "%{$search}%")
                    ->orWhere('tingkat', 'like', "%{$search}%")
                    ->orWhere('tempat', 'like', "%{$search}%")
                    ->orWhereHasMorph('subject', [Atlet::class, Pelatih::class], function ($q) use ($search) {
                        $q->where('nama', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('medali')) {
            $query->where('medali', $request->medali);
        }

        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }

        if ($request->filled('tingkat')) {
            $query->where('tingkat', $request->tingkat);
        }

        if ($request->filled('subject_type')) {
            $query->where('subject_type', $request->subject_type === 'atlet' ? Atlet::class : Pelatih::class);
        }

        if ($request->filled('cabor')) {
            $query->whereHasMorph('subject', [Atlet::class, Pelatih::class], function ($q) use ($request) {
                $q->where('cabor_id', $request->cabor);
            });
        }

        $prestasis = $query->paginate($perPage);
        $prestasis->appends($request->except('page'));

        if ($request->ajax()) {
            return view('admin.prestasi._table', compact('prestasis'))->render();
        }

        $allCabors = DB::table('cabang_olahragas')->pluck('nama_cabor', 'id');
        $allTingkats = ['Nasional', 'Regional', 'Provinsi', 'Kota/Kabupaten'];
        $allMedalis = ['Emas', 'Perak', 'Perunggu'];

        // PERBAIKAN: Hapus $allYears karena tahun sudah diambil via AJAX
        return view('admin.prestasi.index', compact(
            'prestasis',
            'allCabors',
            'allTingkats',
            'allMedalis'
        ));
    }

    public function create()
    {
        $atlets = Atlet::with('cabangOlahraga:id,nama_cabor')
                       ->select('id', 'nama', 'jenis_kelamin', 'cabor_id')
                       ->get();

        $pelatihs = Pelatih::with('cabangOlahraga:id,nama_cabor')
                           ->select('id', 'nama', 'kelamin', 'cabor_id')
                           ->get();

        $cabors = CabangOlahraga::orderBy('nama_cabor')->get();
        return view('admin.prestasi.create', compact('atlets', 'pelatihs', 'cabors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject_type' => 'required|in:atlet,pelatih',
            'subject_id' => 'required|exists:' . ($request->subject_type === 'pelatih' ? 'pelatih' : 'atlets') . ',id',
            'nama_prestasi' => 'required|string|max:255',
            'kejuaraan' => 'required|string|max:255',
            'tingkat' => 'required|string|max:255',
            'tempat' => 'required|string|max:255',
            'tahun' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'medali' => 'required|in:Emas,Perak,Perunggu',
            'cabor_id' => 'required|exists:cabang_olahragas,id',
        ]);

        $subject = $request->subject_type === 'pelatih'
            ? Pelatih::find($request->subject_id)
            : Atlet::find($request->subject_id);

        $prestasi = new Prestasi($request->only([
            'nama_prestasi', 'kejuaraan', 'tingkat', 'tempat', 'tahun', 'medali', 'cabor_id'
        ]));

        $prestasi->subject()->associate($subject);
        $prestasi->save();

        return redirect()->route('admin.konfigurasi.prestasi.index')
            ->with('OK', 'Prestasi berhasil ditambahkan!')
            ->with('action', 'store');
    }

    public function edit(Prestasi $prestasi)
    {
        $prestasi->load(['subject', 'cabangOlahraga']);

        $atlets = Atlet::all();
        $pelatihs = Pelatih::all();
        $cabors = CabangOlahraga::orderBy('nama_cabor', 'asc')->get();

        if (!$prestasi->cabor_id && $prestasi->subject && $prestasi->subject->cabor_id) {
            \Log::info('Prestasi cabor_id is NULL, using subject cabor_id', [
                'prestasi_id' => $prestasi->id,
                'subject_cabor_id' => $prestasi->subject->cabor_id
            ]);

            $prestasi->cabor_id = $prestasi->subject->cabor_id;
        }

        \Log::info('Final prestasi data for edit:', [
            'prestasi_id' => $prestasi->id,
            'prestasi_cabor_id' => $prestasi->cabor_id,
            'subject_cabor_id' => $prestasi->subject->cabor_id ?? null,
            'subject_name' => $prestasi->subject->nama ?? null,
        ]);

        return view('admin.prestasi.edit', compact('prestasi', 'atlets', 'pelatihs', 'cabors'));
    }

    public function update(Request $request, Prestasi $prestasi)
    {
        $request->validate([
            'nama_prestasi' => 'required|string|max:255',
            'kejuaraan' => 'required|string|max:255',
            'tingkat' => 'required|string|max:255',
            'tempat' => 'required|string|max:255',
            'tahun' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'medali' => 'required|in:Emas,Perak,Perunggu',
            'cabor_id' => 'required|exists:cabang_olahragas,id',
        ]);

        // Log before update
        \Log::info('Updating prestasi', [
            'prestasi_id' => $prestasi->id,
            'old_cabor_id' => $prestasi->cabor_id,
            'new_cabor_id' => $request->cabor_id,
            'request_data' => $request->only([
                'nama_prestasi', 'kejuaraan', 'tingkat', 'tempat', 'tahun', 'medali', 'cabor_id'
            ])
        ]);

        $prestasi->update($request->only([
            'nama_prestasi', 'kejuaraan', 'tingkat', 'tempat', 'tahun', 'medali', 'cabor_id'
        ]));

        // Log after update
        \Log::info('Prestasi updated successfully', [
            'prestasi_id' => $prestasi->id,
            'updated_cabor_id' => $prestasi->cabor_id
        ]);

        return redirect()->route('admin.konfigurasi.prestasi.index')
            ->with('OK', 'Prestasi berhasil diperbarui!')
            ->with('action', 'update');
    }

    public function destroy(Prestasi $prestasi)
    {
        $prestasi->delete();
        return back()->with('OK', 'Prestasi berhasil dihapus!')
            ->with('action', 'destroy');
    }

    public function show(Prestasi $prestasi)
    {
        // Untuk sementara kita redirect ke index
        // Karena halaman ini tidak memerlukan detail prestasi secara individual
        return redirect()->route('admin.konfigurasi.prestasi.index');
    }

    public function createForAtlet(Atlet $atlet)
    {
        $cabors = CabangOlahraga::orderBy('nama_cabor')->get();
        return view('admin.prestasi.create-atlet', compact('atlet', 'cabors'));
    }

    public function storeForAtlet(Request $request, Atlet $atlet)
    {
        $request->validate([
            'nama_prestasi' => 'required|string|max:255',
            'kejuaraan' => 'required|string|max:255',
            'tingkat' => 'required|string|max:255',
            'tempat' => 'required|string|max:255',
            'tahun' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'medali' => 'required|in:Emas,Perak,Perunggu',
            'cabor_id' => 'required|exists:cabang_olahragas,id',
        ]);

        $prestasi = new Prestasi($request->only([
            'nama_prestasi', 'kejuaraan', 'tingkat', 'tempat', 'tahun', 'medali', 'cabor_id'
        ]));

        $prestasi->subject()->associate($atlet);
        $prestasi->save();

        return redirect()->route('admin.konfigurasi.atlet.show', $atlet)
            ->with('OK', 'Prestasi atlet berhasil ditambahkan!');
    }

    public function createForPelatih(Pelatih $pelatih)
    {
        $cabors = CabangOlahraga::orderBy('nama_cabor')->get();
        return view('admin.prestasi.create-pelatih', compact('pelatih', 'cabors'));
    }

    public function storeForPelatih(Request $request, Pelatih $pelatih)
    {
        $request->validate([
            'nama_prestasi' => 'required|string|max:255',
            'kejuaraan' => 'required|string|max:255',
            'tingkat' => 'required|string|max:255',
            'tempat' => 'required|string|max:255',
            'tahun' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'medali' => 'required|in:Emas,Perak,Perunggu',
            'cabor_id' => 'required|exists:cabang_olahragas,id',
        ]);

        $prestasi = new Prestasi($request->only([
            'nama_prestasi', 'kejuaraan', 'tingkat', 'tempat', 'tahun', 'medali', 'cabor_id'
        ]));

        $prestasi->subject()->associate($pelatih);
        $prestasi->save();

        return redirect()->route('admin.konfigurasi.pelatih.show', $pelatih)
            ->with('OK', 'Prestasi pelatih berhasil ditambahkan!');
    }

    public function exportCsv(Request $request)
    {
        \Log::info('Export CSV method called', [
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'route' => $request->route() ? $request->route()->getName() : 'unknown',
            'user_id' => auth()->id(),
            'user_authenticated' => auth()->check()
        ]);
        
        // Log all request parameters
        \Log::info('Request parameters', ['params' => $request->all()]);
        
        // Redirect to login if user is not authenticated
        if (!auth()->check()) {
            \Log::warning('Unauthenticated access to export route');
            return redirect()->route('login');
        }
        
        try {
            \Log::info('Export CSV called', ['request' => $request->all()]);
            
            // Build the same query as the index method to ensure consistency
            $allowedSorts = [
                'nama', 'jenis_kelamin', 'nama_prestasi', 'cabor', 'tingkat',
                'tempat', 'tahun', 'medali', 'updated_at', 'created_at'
            ];

            $sortBy = $request->get('sort_by', 'created_at');
            $order = strtolower($request->get('order', 'desc'));

            if (!in_array($sortBy, $allowedSorts)) {
                $sortBy = 'created_at';
            }
            if (!in_array($order, ['asc', 'desc'])) {
                $order = 'desc';
            }

            $query = Prestasi::with(['subject', 'cabangOlahraga'])
                ->select('prestasis.*');

            switch ($sortBy) {
                case 'nama':
                    $query->join(DB::raw("(
                        SELECT id, nama, 'App\Models\Atlet' as type FROM atlets
                        UNION ALL
                        SELECT id, nama, 'App\Models\Pelatih' as type FROM pelatih
                    ) as subjects"), function($join) {
                        $join->on('prestasis.subject_id', '=', 'subjects.id')
                             ->on('prestasis.subject_type', '=', 'subjects.type');
                    })->orderBy('subjects.nama', $order);
                    break;

                case 'jenis_kelamin':
                    $query->join(DB::raw("(
                        SELECT id,
                               CASE WHEN jenis_kelamin = 'L' OR jenis_kelamin = 'Laki-laki' THEN 'Laki-laki'
                                    WHEN jenis_kelamin = 'P' OR jenis_kelamin = 'Perempuan' THEN 'Perempuan'
                                    ELSE jenis_kelamin END as gender,
                               'App\Models\Atlet' as type
                        FROM atlets
                        UNION ALL
                        SELECT id,
                               CASE WHEN kelamin = 'L' OR kelamin = 'Laki-laki' THEN 'Laki-laki'
                                    WHEN kelamin = 'P' OR kelamin = 'Perempuan' THEN 'Perempuan'
                                    ELSE kelamin END as gender,
                               'App\Models\Pelatih' as type
                        FROM pelatih
                    ) as subjects"), function($join) {
                        $join->on('prestasis.subject_id', '=', 'subjects.id')
                             ->on('prestasis.subject_type', '=', 'subjects.type');
                    })->orderBy('subjects.gender', $order);
                    break;

                case 'cabor':
                    $query->join(DB::raw("(
                        SELECT id, cabor_id, 'App\Models\Atlet' as type FROM atlets
                        UNION ALL
                        SELECT id, cabor_id, 'App\Models\Pelatih' as type FROM pelatih
                    ) as subjects"), function($join) {
                        $join->on('prestasis.subject_id', '=', 'subjects.id')
                             ->on('prestasis.subject_type', '=', 'subjects.type');
                    })
                    ->join('cabang_olahragas', 'subjects.cabor_id', '=', 'cabang_olahragas.id')
                    ->orderBy('cabang_olahragas.nama_cabor', $order);
                    break;

                default:
                    $query->orderBy($sortBy, $order);
                    break;
            }

            // Apply the same filters as the index method
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('nama_prestasi', 'like', "%{$search}%")
                        ->orWhere('tingkat', 'like', "%{$search}%")
                        ->orWhere('tempat', 'like', "%{$search}%")
                        ->orWhereHasMorph('subject', [Atlet::class, Pelatih::class], function ($q) use ($search) {
                            $q->where('nama', 'like', "%{$search}%");
                        });
                });
            }

            if ($request->filled('medali')) {
                $query->where('medali', $request->medali);
            }

            if ($request->filled('tahun')) {
                $query->where('tahun', $request->tahun);
            }

            if ($request->filled('tingkat')) {
                $query->where('tingkat', $request->tingkat);
            }

            if ($request->filled('subject_type')) {
                $query->where('subject_type', $request->subject_type === 'atlet' ? Atlet::class : Pelatih::class);
            }

            if ($request->filled('cabor')) {
                $query->whereHasMorph('subject', [Atlet::class, Pelatih::class], function ($q) use ($request) {
                    $q->where('cabor_id', $request->cabor);
                });
            }

            // Get all matching records for export
            $prestasiData = $query->get();
            
            \Log::info('Export data count', ['count' => $prestasiData->count()]);

            // Check if there's any data to export
            if ($prestasiData->isEmpty()) {
                \Log::info('No data to export');
                // Redirect back with message
                return redirect()->back()->with('warning', 'Tidak ada data untuk diexport.');
            }

            // Generate the CSV response using StreamedResponse
            $response = new StreamedResponse(function() use ($prestasiData) {
                try {
                    $handle = fopen('php://output', 'w');

                    // Set UTF-8 BOM for proper Excel compatibility
                    fwrite($handle, "\xEF\xBB\xBF");

                    // CSV Headers
                    fputcsv($handle, [
                        'No',
                        'Nama',
                        'Role',
                        'Jenis Kelamin',
                        'Nama Prestasi',
                        'Kejuaraan',
                        'Cabang Olahraga',
                        'Tingkat',
                        'Tempat',
                        'Tahun',
                        'Medali'
                    ]);

                    foreach ($prestasiData as $index => $prestasi) {
                        // Get subject information
                        $subject = $prestasi->subject;
                        $role = $subject instanceof Atlet ? 'Atlet' : 'Pelatih';
                        
                        // Get jenis kelamin
                        $jenisKelamin = '';
                        if ($subject) {
                            if (isset($subject->jenis_kelamin)) {
                                $jk = $subject->jenis_kelamin;
                                if ($jk === 'L' || $jk === 'Laki-laki') {
                                    $jenisKelamin = 'Laki-laki';
                                } elseif ($jk === 'P' || $jk === 'Perempuan') {
                                    $jenisKelamin = 'Perempuan';
                                } else {
                                    $jenisKelamin = $jk;
                                }
                            } elseif (isset($subject->kelamin)) {
                                $jk = $subject->kelamin;
                                if ($jk === 'L' || $jk === 'Laki-laki') {
                                    $jenisKelamin = 'Laki-laki';
                                } elseif ($jk === 'P' || $jk === 'Perempuan') {
                                    $jenisKelamin = 'Perempuan';
                                } else {
                                    $jenisKelamin = $jk;
                                }
                            }
                        }

                        fputcsv($handle, [
                            $index + 1, // Row number
                            $subject ? $subject->nama : '-',
                            $role,
                            $jenisKelamin ?: '-',
                            $prestasi->nama_prestasi,
                            $prestasi->kejuaraan,
                            $prestasi->cabangOlahraga ? $prestasi->cabangOlahraga->nama_cabor : '-',
                            $prestasi->tingkat,
                            $prestasi->tempat,
                            $prestasi->tahun,
                            $prestasi->medali
                        ]);
                    }

                    fclose($handle);
                } catch (\Exception $e) {
                    \Log::error('Error in streamed response: ' . $e->getMessage(), [
                        'exception' => $e,
                        'trace' => $e->getTraceAsString()
                    ]);
                }
            });

            // Generate filename with timestamp and applied filters
            $timestamp = now()->format('Y-m-d_H-i-s');
            $filterInfo = '';

            if ($request->filled('search')) {
                $filterInfo .= '_search';
            }
            if ($request->filled('medali')) {
                $filterInfo .= '_medali';
            }
            if ($request->filled('tahun')) {
                $filterInfo .= '_tahun';
            }
            if ($request->filled('tingkat')) {
                $filterInfo .= '_tingkat';
            }
            if ($request->filled('subject_type')) {
                $filterInfo .= '_role';
            }
            if ($request->filled('cabor')) {
                $filterInfo .= '_cabor';
            }

            $filename = "prestasi_export{$filterInfo}_{$timestamp}.csv";

            $response->headers->set('Content-Type', 'text/csv; charset=utf-8');
            $response->headers->set('Content-Disposition', "attachment; filename=\"{$filename}\"");
            $response->headers->set('Cache-Control', 'no-cache, no-store, must-revalidate');
            $response->headers->set('Pragma', 'no-cache');
            $response->headers->set('Expires', '0');

            \Log::info('Export response created', ['filename' => $filename]);
            return $response;
        } catch (\Exception $e) {
            \Log::error('Export CSV Error: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);
            // Return a proper response even in error cases
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['error' => 'Terjadi kesalahan saat export data: ' . $e->getMessage()], 500);
            }
            return redirect()->back()->with('error', 'Terjadi kesalahan saat export data: ' . $e->getMessage());
        } catch (\Throwable $e) {
            \Log::error('Export CSV Throwable: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);
            // Return a proper response even in error cases
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['error' => 'Terjadi kesalahan tak terduga saat export data.'], 500);
            }
            return redirect()->back()->with('error', 'Terjadi kesalahan tak terduga saat export data.');
        }
    }
}
