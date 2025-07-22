<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Atlet;
use App\Models\Prestasi;
use Illuminate\Http\Request;

class PrestasiController extends Controller
{
    public function store(Request $request, Atlet $atlet)
    {
        $validated = $request->validate([
            'nama_prestasi' => 'required|string|max:255',
            'tempat' => 'required|string|max:255',
            'tahun' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'medali' => 'required|in:Emas,Perak,Perunggu',
        ]);

        $atlet->prestasis()->create($validated);

        return back()->with('success', 'Prestasi berhasil ditambahkan.');
    }

    public function destroy(Prestasi $prestasi)
    {
        $prestasi->delete();

        return back()->with('success', 'Prestasi berhasil dihapus.');
    }
}
