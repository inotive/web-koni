<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CabangOlahraga;
use App\Models\Pelatih;
use Illuminate\Support\Facades\Storage;

class PelatihController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);

        $query = Pelatih::with(['cabangOlahraga', 'prestasis' => function ($q) {
            $q->orderByDesc('tahun');
        }]);

        // Search functionality (server-side search is still useful for large datasets)
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('pelatih.nama', 'like', "%{$request->search}%")
                    ->orWhereHas('cabangOlahraga', function ($q) use ($request) {
                        $q->where('nama_cabor', 'like', "%{$request->search}%");
                    })
                    ->orWhere('pelatih.alamat', 'like', "%{$request->search}%")
                    ->orWhere('pelatih.email', 'like', "%{$request->search}%");
            });
        }

        // Filter jenis kelamin
        if ($request->filled('kelamin')) {
            $query->where('kelamin', $request->kelamin);
        }

        // Filter cabang olahraga
        if ($request->filled('cabor_id')) {
            $query->where('cabor_id', $request->cabor_id);
        }

        // REMOVED ALL SORTING LOGIC - Let DataTables handle it on client-side
        // Only keep a consistent default order for initial load
        $query->orderByDesc('pelatih.created_at');

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

        // Preserve query parameters in pagination links
        $pelatih->appends($request->query());

        $allCabor = CabangOlahraga::pluck('nama_cabor', 'id');
        $allKelamin = Pelatih::select('kelamin')->distinct()->pluck('kelamin');

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
            'kelamin' => 'required|in:Laki-Laki,Perempuan',
            'no_telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'foto' => 'nullable|image|max:2048'
        ]);

        try {
            if ($request->hasFile('foto')) {
                $data['foto'] = $request->file('foto')->store('pelatih', 'public');
            }

            $pelatih = Pelatih::create($data);

            return redirect()->route('admin.konfigurasi.pelatih.index')
                ->with('OK', 'Data pelatih berhasil disimpan.');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('ERR', 'Gagal menyimpan data pelatih. Error: ' . $e->getMessage());
        }
    }

    public function show($id, Request $request)
    {
        $pelatih = Pelatih::with(['cabangOlahraga', 'prestasis'])->findOrFail($id);

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
                \Log::error('Error loading prestasi: ' . $e->getMessage());

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

        return view('admin.pelatih.show', compact('pelatih', 'prestasis'));
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
            'kelamin' => 'required|in:Laki-Laki,Perempuan',
            'no_telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'foto' => 'nullable|image|max:2048'
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
                ->with('OK', 'Data pelatih berhasil diubah.');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('ERR', 'Gagal mengubah data pelatih. Error: ' . $e->getMessage());
        }
    }

    public function destroy(Pelatih $pelatih)
    {
        try {
            if ($pelatih->foto) {
                Storage::disk('public')->delete($pelatih->foto);
            }

            $pelatih->delete();

            return redirect()->route('admin.konfigurasi.pelatih.index')
                ->with('OK', 'Data pelatih berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('ERR', 'Gagal menghapus data pelatih. Error: ' . $e->getMessage());
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
}
