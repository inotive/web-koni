<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Atlet;
use App\Models\CabangOlahraga;
use Illuminate\Support\Facades\Storage;

class AtletController extends Controller
{
    public function index()
    {
        $atlets = Atlet::with('prestasiTerbaru')->latest()->paginate(10);

        return view('admin.atlet.index', compact('atlets'));
    }

    public function create()
    {
 $cabors = CabangOlahraga::all();
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

        return redirect()->route('admin.konfigurasi.atlet.index')->with('success', 'Data atlet berhasil ditambahkan.');
    }

    public function edit($id)
{
    $atlet = Atlet::findOrFail($id);
    $cabors = CabangOlahraga::all(); 
    return view('admin.atlet.edit', compact('atlet', 'cabors'));
}

   public function update(Request $request, $id)
{
    $atlet = Atlet::findOrFail($id);

    $validated = $request->validate([
        'nama' => 'required|string|max:255',
        'cabor_id' => 'required|exists:cabang_olahragas,id', // Ubah dari 'cabor' ke 'cabor_id'
        'tempat_lahir' => 'required|string|max:100',
        'tanggal_lahir' => 'required|date',
        'alamat' => 'required|string',
        'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
        'no_telepon' => 'nullable|string|max:20',
        'email' => 'nullable|email|max:100',
        'foto_atlet' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    if ($request->hasFile('foto_atlet')) {
        // Hapus foto lama jika ada
        if ($atlet->foto_atlet) {
            Storage::disk('public')->delete($atlet->foto_atlet);
        }
        $foto = $request->file('foto_atlet')->store('foto_atlet', 'public');
        $validated['foto_atlet'] = $foto;
    }

    $atlet->update($validated);

    return redirect()->route('admin.konfigurasi.atlet.index')
           ->with('success', 'Data atlet berhasil diperbarui.');
}

    public function destroy($id)
    {
        $atlet = Atlet::findOrFail($id);
        $atlet->delete();

        return redirect()->route('admin.konfigurasi.atlet.index')->with('success', 'Data atlet berhasil dihapus.');
    }

    public function show($id)
    {
        $atlet = Atlet::with('prestasis')->findOrFail($id);
        return view('admin.atlet.show', compact('atlet'));
    }
}
