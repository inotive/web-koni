<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Atlet;
use App\Models\Pelatih;
use App\Models\Prestasi;
use Illuminate\Http\Request;

class PrestasiController extends Controller
{
    public function index()
    {
        $prestasis = Prestasi::with('subject')->latest()->paginate(10);
        return view('admin.prestasi.index', compact('prestasis'));
    }

    public function create()
    {
        $atlets = Atlet::with('cabangOlahraga:id,nama_cabor')
                       ->select('id', 'nama', 'jenis_kelamin', 'cabor_id')
                       ->get();

        $pelatihs = Pelatih::with('cabangOlahraga:id,nama_cabor')
                           ->select('id', 'nama', 'kelamin', 'cabor_id')
                           ->get();

        return view('admin.prestasi.create', compact('atlets', 'pelatihs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject_type' => 'required|in:atlet,pelatih',
            'subject_id' => 'required|exists:' . ($request->subject_type === 'pelatih' ? 'pelatih' : 'atlets') . ',id',
            'nama_prestasi' => 'required|string|max:255',
            'tingkat' => 'required|string|max:255',
            'tempat' => 'required|string|max:255',
            'tahun' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'medali' => 'required|in:Emas,Perak,Perunggu'
        ]);

        $subject = $request->subject_type === 'pelatih'
            ? Pelatih::find($request->subject_id)
            : Atlet::find($request->subject_id);

        $prestasi = new Prestasi($request->only([
            'nama_prestasi', 'tingkat', 'tempat', 'tahun', 'medali'
        ]));

        $prestasi->subject()->associate($subject);
        $prestasi->save();

        return redirect()->route('admin.konfigurasi.prestasi.index')
            ->with('success', 'Prestasi berhasil ditambahkan!');
    }

    public function edit(Prestasi $prestasi)
    {
        $atlets = Atlet::all();
        $pelatihs = Pelatih::all();
        return view('admin.prestasi.edit', compact('prestasi', 'atlets', 'pelatihs'));
    }

    public function update(Request $request, Prestasi $prestasi)
    {
        $request->validate([
            'nama_prestasi' => 'required|string|max:255',
            'tingkat' => 'required|string|max:255',
            'tempat' => 'required|string|max:255',
            'tahun' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'medali' => 'required|in:Emas,Perak,Perunggu'
        ]);

        $prestasi->update($request->only([
            'nama_prestasi', 'tingkat', 'tempat', 'tahun', 'medali'
        ]));

        return redirect()->route('admin.konfigurasi.prestasi.index')
            ->with('success', 'Prestasi berhasil diperbarui!');
    }

    public function destroy(Prestasi $prestasi)
    {
        $prestasi->delete();
        return back()->with('success', 'Prestasi berhasil dihapus!');
    }

    public function createForAtlet(Atlet $atlet)
    {
        return view('admin.prestasi.create-atlet', compact('atlet'));
    }

    public function storeForAtlet(Request $request, Atlet $atlet)
    {
        $request->validate([
            'nama_prestasi' => 'required|string|max:255',
            'tingkat' => 'required|string|max:255',
            'tempat' => 'required|string|max:255',
            'tahun' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'medali' => 'required|in:Emas,Perak,Perunggu'
        ]);

        $prestasi = new Prestasi($request->only([
            'nama_prestasi', 'tingkat', 'tempat', 'tahun', 'medali'
        ]));

        $prestasi->subject()->associate($atlet);
        $prestasi->save();

        return redirect()->route('admin.konfigurasi.atlet.show', $atlet)
            ->with('success', 'Prestasi atlet berhasil ditambahkan!');
    }

    public function createForPelatih(Pelatih $pelatih)
    {
        return view('admin.prestasi.create-pelatih', compact('pelatih'));
    }

    public function storeForPelatih(Request $request, Pelatih $pelatih)
    {
        $request->validate([
            'nama_prestasi' => 'required|string|max:255',
            'tingkat' => 'required|string|max:255',
            'tempat' => 'required|string|max:255',
            'tahun' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'medali' => 'required|in:Emas,Perak,Perunggu'
        ]);

        $prestasi = new Prestasi($request->only([
            'nama_prestasi', 'tingkat', 'tempat', 'tahun', 'medali'
        ]));

        $prestasi->subject()->associate($pelatih);
        $prestasi->save();

        return redirect()->route('admin.konfigurasi.pelatih.show', $pelatih)
            ->with('success', 'Prestasi pelatih berhasil ditambahkan!');
    }
}
