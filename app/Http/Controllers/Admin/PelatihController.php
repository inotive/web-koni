<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pelatih;
use Illuminate\Support\Facades\Storage;

class PelatihController extends Controller
{
    public function index(Request $request)
    {
        $query = Pelatih::with(['prestasis' => function ($q) {
            $q->orderByDesc('tahun')->limit(1);
        }]);

        if ($request->filled('sort') && $request->sort === 'prestasi') {
        $query->with(['prestasis' => function ($q) {
            $q->orderByDesc('tahun')->limit(1);
        }])->leftJoin('prestasis', 'pelatih.id', '=', 'prestasis.pelatih_id')
            ->select('pelatih.*')
            ->orderBy('prestasis.tahun', $request->order === 'desc' ? 'desc' : 'asc');
        }



        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', "%{$request->search}%")
                ->orWhere('cabor', 'like', "%{$request->search}%")
                ->orWhere('alamat', 'like', "%{$request->search}%")
                ->orWhere('email', 'like', "%{$request->search}%");
            });
        }

        if ($request->filled('kelamin')) {
            $query->where('kelamin', $request->kelamin);
        }

        if ($request->filled('cabor')) {
            $query->where('cabor', $request->cabor);
        }

        if ($request->filled('sort') && in_array($request->sort, ['nama', 'tanggal_lahir', 'kelamin', 'alamat', 'updated_at'])) {
            $query->orderBy($request->sort, $request->order === 'desc' ? 'desc' : 'asc');
        }

        $pelatih = $query->paginate($request->per_page ?? 10);

        $allCabor = Pelatih::select('cabor')->distinct()->pluck('cabor');
        $allKelamin = Pelatih::select('kelamin')->distinct()->pluck('kelamin');

        return view('admin.pelatih.index', compact('pelatih', 'allCabor', 'allKelamin'));
    }

    public function create()
    {
        $allCabor = Pelatih::select('cabor')->distinct()->pluck('cabor');
        $allKelamin = ['Laki - Laki', 'Perempuan'];

        return view('admin.pelatih.create', compact('allCabor', 'allKelamin'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required',
            'cabor' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required',
            'kelamin' => 'required',
            'prestasi' => 'nullable',
            'no_telepon' => 'nullable',
            'email' => 'nullable|email',
            'foto' => 'nullable|image|max:10000'
        ]);

        try {
            if ($request->hasFile('foto')) {
                $data['foto'] = $request->file('foto')->store('pelatih', 'public');
            }

            Pelatih::create($data);

            return redirect()->route('admin.konfigurasi.pelatih.index')->with('OK', 'Data pelatih berhasil disimpan.');
        } catch (\Exception $e) {
            return back()->withInput()->with('ERR', 'Gagal menyimpan data pelatih. Coba lagi.');
        }
    }

    public function show($id)
    {
        $pelatih = Pelatih::with('prestasis')->findOrFail($id);
        return view('admin.pelatih.show', compact('pelatih'));
    }


    public function edit($id)
    {
        $pelatih = Pelatih::findOrFail($id);
        $allCabor = Pelatih::select('cabor')->distinct()->pluck('cabor');
        $allKelamin = ['Laki - Laki', 'Perempuan'];

        return view('admin.pelatih.edit', compact('pelatih', 'allCabor', 'allKelamin'));
    }

    public function update(Request $request, Pelatih $pelatih)
    {
        $data = $request->validate([
            'nama' => 'required',
            'cabor' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required',
            'kelamin' => 'required',
            'prestasi' => 'nullable',
            'no_telepon' => 'nullable',
            'email' => 'nullable|email',
            'foto' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('foto')) {
            if ($pelatih->foto) {
                Storage::disk('public')->delete($pelatih->foto);
            }
            $data['foto'] = $request->file('foto')->store('pelatih', 'public');
        }

        $pelatih->update($data);

        return redirect()->route('admin.konfigurasi.pelatih.index')->with('OK', 'Data pelatih berhasil diubah.');
    }

    public function destroy(Pelatih $pelatih)
    {
        if ($pelatih->foto) {
            Storage::disk('public')->delete($pelatih->foto);
        }

        $pelatih->delete();

        return redirect()->back()->with('OK', 'Data pelatih telah dihapus.');
    }

    public function addPrestasi(Request $request, $id)
    {
        $request->validate([
            'tahun' => 'required|digits:4',
            'tempat' => 'required|string|max:255',
            'prestasi' => 'required|string|max:255',
        ]);

        $pelatih = Pelatih::findOrFail($id);
        $newEntry = "{$request->prestasi} {$request->tahun} {$request->tempat}";

        $pelatih->prestasi = trim($pelatih->prestasi . "\n" . $newEntry);
        $pelatih->save();

        return redirect()->back()->with('success', 'Prestasi berhasil ditambahkan.');
    }

}
