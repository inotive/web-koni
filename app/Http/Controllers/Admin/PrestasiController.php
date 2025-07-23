<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Atlet;
use App\Models\Pelatih;
use App\Models\Prestasi;
use Illuminate\Http\Request;

class PrestasiController extends Controller
{
    // Store prestasi for Atlet
    public function storeForAtlet(Request $request, $atletId)
    {
        $request->validate([
            'nama_prestasi' => 'required|string|max:255',
            'tempat' => 'required|string|max:255',
            'tahun' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'medali' => 'required|in:Emas,Perak,Perunggu'
        ]);

        $atlet = Atlet::findOrFail($atletId);

        // Create prestasi with polymorphic relationship
        $prestasi = new Prestasi([
            'nama_prestasi' => $request->nama_prestasi,
            'tempat' => $request->tempat,
            'tahun' => $request->tahun,
            'medali' => $request->medali,
        ]);

        // Set the polymorphic relationship for Atlet
        $prestasi->subject()->associate($atlet);
        $prestasi->save();

        return redirect()->route('admin.konfigurasi.atlet.show', $atletId)
            ->with('success', 'Prestasi berhasil ditambahkan!');
    }

    // Store prestasi for Pelatih
    public function storeForPelatih(Request $request, $pelatihId)
    {
        $request->validate([
            'nama_prestasi' => 'required|string|max:255',
            'tempat' => 'required|string|max:255',
            'tahun' => 'required|integer|min:1900|max:' . (date('Y') + 1),
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

        // Set the polymorphic relationship for Pelatih
        $prestasi->subject()->associate($pelatih);
        $prestasi->save();

        return redirect()->route('admin.konfigurasi.pelatih.show', $pelatihId)
            ->with('success', 'Prestasi berhasil ditambahkan!');
    }

    // Generic store method (if you want to keep one method)
    public function store(Request $request, $id, $type = 'atlet')
    {
        $request->validate([
            'nama_prestasi' => 'required|string|max:255',
            'tempat' => 'required|string|max:255',
            'tahun' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'medali' => 'required|in:Emas,Perak,Perunggu'
        ]);

        // Determine the model based on type
        if ($type === 'pelatih') {
            $subject = Pelatih::findOrFail($id);
            $redirectRoute = 'admin.konfigurasi.pelatih.show';
        } else {
            $subject = Atlet::findOrFail($id);
            $redirectRoute = 'admin.konfigurasi.atlet.show';
        }

        // Create prestasi with polymorphic relationship
        $prestasi = new Prestasi([
            'nama_prestasi' => $request->nama_prestasi,
            'tempat' => $request->tempat,
            'tahun' => $request->tahun,
            'medali' => $request->medali,
        ]);

        // Set the polymorphic relationship
        $prestasi->subject()->associate($subject);
        $prestasi->save();

        return redirect()->route($redirectRoute, $id)
            ->with('success', 'Prestasi berhasil ditambahkan!');
    }

    public function destroy(Prestasi $prestasi)
    {
        try {
            // Get the subject info before deleting for redirect
            $subjectType = $prestasi->subject_type;
            $subjectId = $prestasi->subject_id;

            $prestasi->delete();

            // Determine redirect route based on subject type
            if (str_contains($subjectType, 'Pelatih')) {
                $redirectRoute = 'admin.konfigurasi.pelatih.show';
            } else {
                $redirectRoute = 'admin.konfigurasi.atlet.show';
            }

            return redirect()->route($redirectRoute, $subjectId)
                ->with('success', 'Prestasi berhasil dihapus.');

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat menghapus prestasi.');
        }
    }

    // Alternative destroy method if you know the context
    public function destroyForAtlet(Prestasi $prestasi, $atletId)
    {
        try {
            $prestasi->delete();
            return redirect()->route('admin.konfigurasi.atlet.show', $atletId)
                ->with('success', 'Prestasi berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat menghapus prestasi.');
        }
    }

    public function destroyForPelatih(Prestasi $prestasi, $pelatihId)
    {
        try {
            $prestasi->delete();
            return redirect()->route('admin.konfigurasi.pelatih.show', $pelatihId)
                ->with('success', 'Prestasi berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat menghapus prestasi.');
        }
    }
}
