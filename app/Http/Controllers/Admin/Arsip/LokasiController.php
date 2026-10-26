<?php

namespace App\Http\Controllers\Admin\Arsip;

use App\Http\Controllers\Controller;
use App\Models\Arsip\ArsipLokasi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LokasiController extends Controller
{
    use QrLabel;

    public function index(Request $request)
    {
        $nodes = ArsipLokasi::withCount([
            'arsip as jumlah_arsip' => fn ($q) => $q->tersimpan(),
        ])->orderBy('kode')->get();

        $tree = $nodes->groupBy(fn ($n) => $n->parent_id ?? 0);

        $selected = null;
        $arsip = collect();
        if ($request->filled('id')) {
            $selected = ArsipLokasi::with('parent')->findOrFail($request->id);
            $arsip = $selected->arsip()->with('kategori')->tersimpan()->orderBy('nomor_arsip')->get();
        }

        $lokasiOptions = ArsipLokasi::options($selected?->id);

        return view('admin.arsip.lokasi.index', compact('tree', 'selected', 'arsip', 'lokasiOptions'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $lokasi = ArsipLokasi::create($data);

        return redirect()->route('admin.arsip.lokasi.index', ['id' => $lokasi->id])
            ->with('OK', "{$lokasi->tipe_label} {$lokasi->nama} berhasil ditambahkan.");
    }

    public function update(Request $request, ArsipLokasi $lokasi)
    {
        $data = $this->validated($request, $lokasi);
        $lokasi->update($data);

        return redirect()->route('admin.arsip.lokasi.index', ['id' => $lokasi->id])
            ->with('OK', 'Lokasi berhasil diperbarui.');
    }

    public function destroy(ArsipLokasi $lokasi)
    {
        if ($lokasi->children()->exists()) {
            return back()->with('ERR', 'Lokasi tidak bisa dihapus karena masih memiliki sub-lokasi.');
        }
        if ($lokasi->arsip()->exists()) {
            return back()->with('ERR', 'Lokasi tidak bisa dihapus karena masih tercatat sebagai lokasi arsip. Pindahkan arsipnya terlebih dahulu.');
        }

        $parentId = $lokasi->parent_id;
        $lokasi->delete();

        return redirect()->route('admin.arsip.lokasi.index', array_filter(['id' => $parentId]))
            ->with('OK', 'Lokasi berhasil dihapus.');
    }

    /** Label PDF (dengan QR code) untuk lokasi ini, atau seluruh box di bawahnya. */
    public function label(Request $request, ArsipLokasi $lokasi)
    {
        $targets = $request->boolean('semua_box')
            ? ArsipLokasi::whereIn('id', $lokasi->descendantIds())->where('tipe', 'box')->orderBy('kode')->get()
            : collect([$lokasi]);

        if ($targets->isEmpty()) {
            return back()->with('ERR', 'Tidak ada box di bawah lokasi ini.');
        }

        $labels = $targets->map(fn ($item) => [
            'judul' => $item->tipe_label,
            'kode' => $item->kode_lengkap,
            'nama' => $item->nama,
            'sub' => $item->parent?->path,
            'qr' => $this->qrDataUri(route('admin.arsip.lokasi.index', ['id' => $item->id])),
        ]);

        return Pdf::loadView('admin.arsip.label-pdf', compact('labels'))
            ->setPaper('a4')
            ->stream('label-' . $lokasi->kode_lengkap . '.pdf');
    }

    private function validated(Request $request, ?ArsipLokasi $lokasi = null): array
    {
        $data = $request->validate([
            'parent_id' => ['nullable', 'exists:arsip_lokasi,id'],
            'tipe' => ['required', Rule::in(array_keys(ArsipLokasi::TIPE))],
            'kode' => [
                'required', 'string', 'max:50', 'regex:/^[A-Za-z0-9.]+$/',
                Rule::unique('arsip_lokasi')
                    ->where(fn ($q) => $request->parent_id ? $q->where('parent_id', $request->parent_id) : $q->whereNull('parent_id'))
                    ->ignore($lokasi?->id),
            ],
            'nama' => ['required', 'string', 'max:255'],
            'kapasitas' => ['nullable', 'integer', 'min:1'],
            'keterangan' => ['nullable', 'string'],
            'is_aktif' => ['nullable', 'boolean'],
        ], [
            'kode.regex' => 'Kode hanya boleh berisi huruf, angka, dan titik.',
            'kode.unique' => 'Kode sudah dipakai di lokasi induk yang sama.',
        ]);

        $data['is_aktif'] = $request->boolean('is_aktif', true);

        $urutan = array_keys(ArsipLokasi::TIPE);
        if (!empty($data['parent_id'])) {
            $parent = ArsipLokasi::findOrFail($data['parent_id']);

            if ($lokasi && in_array($parent->id, $lokasi->descendantIds())) {
                abort(back()->withInput()->with('ERR', 'Lokasi induk tidak boleh lokasi itu sendiri atau turunannya.'));
            }
            if (array_search($data['tipe'], $urutan) <= array_search($parent->tipe, $urutan)) {
                abort(back()->withInput()->with('ERR', "Tipe {$data['tipe']} tidak bisa berada di dalam {$parent->tipe}. Urutan: " . implode(' › ', $urutan) . '.'));
            }
        }

        if ($lokasi) {
            $tipeIndex = array_search($data['tipe'], $urutan);
            $childTerlalu = $lokasi->children->first(fn ($c) => array_search($c->tipe, $urutan) <= $tipeIndex);
            if ($childTerlalu) {
                abort(back()->withInput()->with('ERR', "Tipe tidak bisa diubah karena sub-lokasi {$childTerlalu->nama} bertipe {$childTerlalu->tipe}."));
            }
        }

        return $data;
    }
}
