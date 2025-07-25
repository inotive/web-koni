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
        $query = Pelatih::with(['cabangOlahraga', 'prestasis' => function ($q) {
            $q->orderByDesc('tahun');
        }]);

        // Sorting berdasarkan prestasi terbaru
        if ($request->filled('sort') && $request->sort === 'prestasi') {
            $query->with(['prestasis' => function ($q) {
                $q->orderByDesc('tahun')->limit(1);
            }])->leftJoin('prestasis', 'pelatih.id', '=', 'prestasis.pelatih_id')
                ->select('pelatih.*')
                ->orderBy('prestasis.tahun', $request->order === 'desc' ? 'desc' : 'asc');
        }

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

        if ($request->filled('cabor_id')) {
            $query->where('cabor_id', $request->cabor_id);
        }

        // Sorting
        if ($request->filled('sort') && in_array($request->sort, ['nama', 'tanggal_lahir', 'kelamin', 'alamat', 'updated_at'])) {
            $query->orderBy($request->sort, $request->order === 'desc' ? 'desc' : 'asc');
        } else {
            $query->orderByDesc('created_at');
        }

        $pelatih = $query->paginate($request->per_page ?? 10);

        $allCabor = CabangOlahraga::pluck('nama_cabor', 'id');
        $allKelamin = Pelatih::select('kelamin')->distinct()->pluck('kelamin');

        return view('admin.pelatih.index', compact('pelatih', 'allCabor', 'allKelamin'));
    }

    public function create()
    {
        $cabors = CabangOlahraga::pluck('nama_cabor', 'id');
        $allKelamin = ['Laki-laki', 'Perempuan'];

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
            'kelamin' => 'required|in:Laki-laki,Perempuan',
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

    public function show($id)
    {
        $pelatih = Pelatih::with(['cabangOlahraga', 'prestasis' => function ($q) {
            $q->orderByDesc('tahun');
        }])->findOrFail($id);

        return view('admin.pelatih.show', compact('pelatih'));
    }

    public function edit($id)
    {
        $pelatih = Pelatih::findOrFail($id);
        $cabors = CabangOlahraga::pluck('nama_cabor', 'id');
        $allKelamin = ['Laki-laki', 'Perempuan'];

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
            'kelamin' => 'required|in:Laki-laki,Perempuan',
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
