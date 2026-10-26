<?php

namespace App\Http\Controllers\Admin\Arsip;

use App\Http\Controllers\Controller;
use App\Models\Arsip\ArsipKategori;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KategoriController extends Controller
{
    public function index(Request $request)
    {
        $kategori = ArsipKategori::withCount('arsip')
            ->when($request->filled('search'), function ($q) use ($request) {
                $q->where(fn ($q) => $q->where('kode_klasifikasi', 'like', "%{$request->search}%")
                    ->orWhere('nama', 'like', "%{$request->search}%"));
            })
            ->orderBy('kode_klasifikasi')
            ->paginate(15)
            ->withQueryString();

        return view('admin.arsip.kategori.index', compact('kategori'));
    }

    public function store(Request $request)
    {
        ArsipKategori::create($this->validated($request));

        return back()->with('OK', 'Klasifikasi arsip berhasil ditambahkan.');
    }

    public function update(Request $request, ArsipKategori $kategori)
    {
        $kategori->update($this->validated($request, $kategori));

        return back()->with('OK', 'Klasifikasi arsip berhasil diperbarui.');
    }

    public function destroy(ArsipKategori $kategori)
    {
        if ($kategori->arsip()->exists()) {
            return back()->with('ERR', 'Klasifikasi tidak bisa dihapus karena masih dipakai oleh arsip.');
        }

        $kategori->delete();

        return back()->with('OK', 'Klasifikasi arsip berhasil dihapus.');
    }

    private function validated(Request $request, ?ArsipKategori $kategori = null): array
    {
        return $request->validate([
            'kode_klasifikasi' => ['required', 'string', 'max:50', Rule::unique('arsip_kategori')->ignore($kategori?->id)],
            'nama' => ['required', 'string', 'max:255'],
            'retensi_aktif_tahun' => ['required', 'integer', 'min:0', 'max:100'],
            'retensi_inaktif_tahun' => ['required', 'integer', 'min:0', 'max:100'],
            'tindakan_akhir' => ['required', Rule::in(array_keys(ArsipKategori::TINDAKAN_AKHIR))],
            'keterangan' => ['nullable', 'string'],
        ]);
    }
}
