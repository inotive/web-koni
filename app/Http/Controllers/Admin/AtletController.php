<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Atlet;
use App\Models\CabangOlahraga;
use Illuminate\Support\Facades\Storage;

class AtletController extends Controller
{
  public function index(Request $request)
{
    $perPage = $request->get('per_page', 10);

    // Eager-load relasi yang dibutuhkan
    $query = Atlet::with(['cabangOlahraga', 'prestasis'])
                  ->orderBy('created_at', 'DESC');

    if ($request->filled('search')) {
        $query->where('nama', 'like', '%' . $request->search . '%');
    }

    if ($request->filled('cabor')) {
        $query->whereHas('cabangOlahraga', function ($q) use ($request) {
            $q->where('nama_cabor', $request->cabor);
        });
    }

    if ($request->filled('gender')) {
        $query->where('jenis_kelamin', $request->gender);
    }

    if ($request->filled('age')) {
        $age = $request->age;
        if ($age === '36+') {
            $query->whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) >= 36');
        } else {
            [$min, $max] = array_map('intval', explode('-', $age));
            $query->whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN ? AND ?', [$min, $max]);
        }
    }

    if ($request->filled('prestasi')) {
        switch ($request->prestasi) {
            case 'ada':
                $query->has('prestasis');
                break;
            case 'tidak':
                $query->doesntHave('prestasis');
                break;
            case 'emas':
            case 'perak':
            case 'perunggu':
                $query->whereHas('prestasis', fn($q) => $q->where('medali', ucfirst($request->prestasi)));
                break;
        }
    }

    $atlets = $query->paginate($perPage);

    $allCabor = CabangOlahraga::pluck('nama_cabor', 'id');

    if ($request->ajax()) {
        return view('admin.atlet._table', compact('atlets'))->render();
    }

    return view('admin.atlet.index', compact('atlets', 'allCabor'));
}

    public function create()
    {
        $cabors = CabangOlahraga::select('id', 'nama_cabor')->get();
        return view('admin.atlet.create', compact('cabors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'cabor_id' => 'required|exists:cabang_olahragas,id',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'no_telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'foto_atlet' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('foto_atlet')) {
            $foto = $request->file('foto_atlet')->store('foto_atlet', 'public');
            $validated['foto_atlet'] = $foto;
        }

        Atlet::create($validated);

return redirect()->route('admin.konfigurasi.atlet.index')
    ->with('OK', 'Atlet berhasil ditambahkan.')
    ->with('action', 'store');
    }

    public function edit($id)
    {
        $atlet = Atlet::findOrFail($id);
        $cabors = CabangOlahraga::select('id', 'nama_cabor')->get();
        return view('admin.atlet.edit', compact('atlet', 'cabors'));
    }

    public function update(Request $request, $id)
    {
        $atlet = Atlet::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'cabor_id' => 'required|exists:cabang_olahragas,id',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'no_telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'foto_atlet' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('foto_atlet')) {

            if ($atlet->foto_atlet) {
                Storage::disk('public')->delete($atlet->foto_atlet);
            }
            $foto = $request->file('foto_atlet')->store('foto_atlet', 'public');
            $validated['foto_atlet'] = $foto;
        }

        $atlet->update($validated);

    return redirect()->route('admin.konfigurasi.atlet.index')
    ->with('OK', 'Data atlet berhasil diperbarui.')
    ->with('action', 'update');
    }

    public function destroy($id)
{
    $atlet = Atlet::withCount('prestasis')->findOrFail($id);

    if ($atlet->prestasis_count > 0) {
        return redirect()
            ->route('admin.konfigurasi.atlet.index')
            ->with('error', "Gagal dihapus – atlet ini masih memiliki {$atlet->prestasis_count} prestasi.");
    }

    if ($atlet->foto_atlet) {
        Storage::disk('public')->delete($atlet->foto_atlet);
    }

    $atlet->delete();

    return redirect()
        ->route('admin.konfigurasi.atlet.index')
        ->with('OK', 'Data atlet berhasil dihapus.')
        ->with('action', 'destroy');
}

    public function show($id)
    {
        $atlet = Atlet::with('prestasis')->findOrFail($id);
        return view('admin.atlet.show', compact('atlet'));
    }
}
