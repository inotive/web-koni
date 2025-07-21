<?php

namespace App\Http\Controllers\Admin;

use App\Models\Prestasi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PrestasiController extends Controller
{
    public function store(Request $request, $pelatihId)
    {
        $validated = $request->validate([
            'nama_prestasi' => 'required|string',
            'tempat' => 'required|string',
            'tahun' => 'required|integer|min:1900|max:' . date('Y'),
        ]);

        Prestasi::create([
            'pelatih_id' => $pelatihId,
            'nama_prestasi' => $validated['nama_prestasi'],
            'tempat' => $validated['tempat'],
            'tahun' => $validated['tahun'],
        ]);

        return redirect()->back()->with('success', 'Prestasi berhasil ditambahkan');
    }

}
