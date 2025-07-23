<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Atlet;
use App\Models\Pelatih; // ← Tambahkan ini yang missing
use App\Models\Prestasi;
use Illuminate\Http\Request;

class PrestasiController extends Controller
{
    public function store(Request $request, $pelatihId)
    {
        $request->validate([
            'nama_prestasi' => 'required|string|max:255',
            'tempat' => 'required|string|max:255',
            'tahun' => 'required|integer',
            'medali' => 'required|in:Emas,Perak,Perunggu'
        ]);

        $pelatih = Pelatih::findOrFail($pelatihId);

        // Create prestasi with polymorphic relationship
        $prestasi = new Prestasi([
            'nama_prestasi' => $request->nama_prestasi,
            'tempat' => $request->tempat,
            'tahun' => $request->tahun,
            'medali' => $request->medali,
        ]);

        // Set the polymorphic relationship
        $prestasi->subject()->associate($pelatih);
        $prestasi->save();

        return redirect()->route('admin.konfigurasi.pelatih.show', $pelatihId)
            ->with('success', 'Prestasi berhasil ditambahkan!');
    }

    public function destroy(Prestasi $prestasi)
    {
        $prestasi->delete();
        return back()->with('success', 'Prestasi berhasil dihapus.');
    }
}
