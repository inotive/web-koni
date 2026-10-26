<?php

namespace App\Http\Controllers\Admin\Arsip;

use App\Http\Controllers\Controller;
use App\Models\Arsip\Arsip;
use App\Models\Arsip\ArsipPemusnahan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class RetensiController extends Controller
{
    public function index(Request $request)
    {
        $tab = in_array($request->tab, ['inaktif', 'retensi', 'berita-acara']) ? $request->tab : 'retensi';

        $data = match ($tab) {
            'inaktif' => Arsip::jatuhTempoInaktif()->with(['kategori', 'lokasi'])->orderBy('tanggal_arsip')->paginate(25)->withQueryString(),
            'retensi' => Arsip::jatuhTempoRetensi()->with(['kategori', 'lokasi'])->orderBy('tanggal_arsip')->paginate(25)->withQueryString(),
            'berita-acara' => ArsipPemusnahan::withCount('arsip')->with('user')->latest('tanggal')->latest('id')->paginate(15)->withQueryString(),
        };

        return view('admin.arsip.retensi.index', [
            'tab' => $tab,
            'data' => $data,
            'jumlah' => [
                'inaktif' => Arsip::jatuhTempoInaktif()->count(),
                'retensi' => Arsip::jatuhTempoRetensi()->count(),
            ],
            'nomorBaru' => ArsipPemusnahan::generateNomor(),
        ]);
    }

    /** Pindahkan arsip aktif yang masa aktifnya habis menjadi inaktif. */
    public function inaktifkan(Request $request)
    {
        $request->validate(['ids' => ['required', 'array', 'min:1'], 'ids.*' => ['integer']], [
            'ids.required' => 'Pilih minimal satu arsip.',
        ]);

        $count = Arsip::jatuhTempoInaktif()->whereIn('id', $request->ids)->update(['status' => 'inaktif']);

        return back()->with('OK', "{$count} arsip dipindahkan ke status inaktif.");
    }

    /** Buat berita acara pemusnahan / penyerahan permanen untuk arsip terpilih. */
    public function proses(Request $request)
    {
        $data = $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['integer'],
            'jenis' => ['required', Rule::in(array_keys(ArsipPemusnahan::JENIS))],
            'nomor_berita_acara' => ['required', 'string', 'max:100', 'unique:arsip_pemusnahan,nomor_berita_acara'],
            'tanggal' => ['required', 'date'],
            'keterangan' => ['nullable', 'string'],
        ], [
            'ids.required' => 'Pilih minimal satu arsip.',
        ]);

        $arsip = Arsip::jatuhTempoRetensi()->whereIn('id', $data['ids'])->get();
        $dipinjam = $arsip->where('status', 'dipinjam');
        if ($dipinjam->isNotEmpty()) {
            return back()->with('ERR', 'Arsip berikut masih dipinjam: ' . $dipinjam->pluck('nomor_arsip')->implode(', '));
        }
        if ($arsip->isEmpty()) {
            return back()->with('ERR', 'Tidak ada arsip valid yang dipilih.');
        }

        $ba = DB::transaction(function () use ($data, $arsip) {
            $ba = ArsipPemusnahan::create([
                'nomor_berita_acara' => $data['nomor_berita_acara'],
                'tanggal' => $data['tanggal'],
                'jenis' => $data['jenis'],
                'keterangan' => $data['keterangan'] ?? null,
                'user_id' => auth()->id(),
            ]);

            Arsip::whereIn('id', $arsip->pluck('id'))->update([
                'status' => $data['jenis'] === 'musnah' ? 'dimusnahkan' : 'permanen',
                'arsip_pemusnahan_id' => $ba->id,
            ]);

            return $ba;
        });

        return redirect()->route('admin.arsip.retensi.index', ['tab' => 'berita-acara'])
            ->with('OK', "Berita acara {$ba->nomor_berita_acara} dibuat untuk {$arsip->count()} arsip.");
    }

    public function beritaAcara(ArsipPemusnahan $pemusnahan)
    {
        $pemusnahan->load(['arsip.kategori', 'arsip.lokasi', 'user']);

        return Pdf::loadView('admin.arsip.retensi.berita-acara-pdf', compact('pemusnahan'))
            ->setPaper('a4')
            ->stream(str_replace('/', '-', $pemusnahan->nomor_berita_acara) . '.pdf');
    }
}
