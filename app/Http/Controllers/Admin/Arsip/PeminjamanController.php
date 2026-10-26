<?php

namespace App\Http\Controllers\Admin\Arsip;

use App\Http\Controllers\Controller;
use App\Models\Arsip\Arsip;
use App\Models\Arsip\ArsipPeminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $tab = in_array($request->tab, ['dipinjam', 'terlambat', 'riwayat']) ? $request->tab : 'dipinjam';

        $query = ArsipPeminjaman::with(['arsip.lokasi', 'petugas']);
        match ($tab) {
            'dipinjam' => $query->where('status', 'dipinjam')->orderBy('tanggal_rencana_kembali'),
            'terlambat' => $query->terlambat()->orderBy('tanggal_rencana_kembali'),
            'riwayat' => $query->where('status', 'dikembalikan')->orderByDesc('tanggal_kembali'),
        };

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(fn ($q) => $q->where('nama_peminjam', 'like', "%{$search}%")
                ->orWhere('unit_peminjam', 'like', "%{$search}%")
                ->orWhereHas('arsip', fn ($a) => $a->where('nomor_arsip', 'like', "%{$search}%")->orWhere('judul', 'like', "%{$search}%")));
        }

        return view('admin.arsip.peminjaman.index', [
            'tab' => $tab,
            'peminjaman' => $query->orderByDesc('id')->paginate(15)->withQueryString(),
            'jumlah' => [
                'dipinjam' => ArsipPeminjaman::where('status', 'dipinjam')->count(),
                'terlambat' => ArsipPeminjaman::terlambat()->count(),
            ],
            'arsipTersedia' => Arsip::whereIn('status', ['aktif', 'inaktif'])->orderBy('nomor_arsip')->get(['id', 'nomor_arsip', 'judul']),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'arsip_id' => ['required', 'exists:arsip,id'],
            'nama_peminjam' => ['required', 'string', 'max:255'],
            'unit_peminjam' => ['nullable', 'string', 'max:255'],
            'tanggal_pinjam' => ['required', 'date'],
            'tanggal_rencana_kembali' => ['required', 'date', 'after_or_equal:tanggal_pinjam'],
            'catatan' => ['nullable', 'string'],
        ], [], [
            'arsip_id' => 'arsip',
            'tanggal_rencana_kembali' => 'tanggal rencana kembali',
        ]);

        $arsip = Arsip::findOrFail($data['arsip_id']);
        if (!in_array($arsip->status, ['aktif', 'inaktif'])) {
            return back()->withInput()->with('ERR', "Arsip {$arsip->nomor_arsip} berstatus {$arsip->status_label} dan tidak bisa dipinjam.");
        }

        DB::transaction(function () use ($arsip, $data) {
            ArsipPeminjaman::create($data + [
                'status' => 'dipinjam',
                'status_arsip_sebelum' => $arsip->status,
                'user_id' => auth()->id(),
            ]);
            $arsip->update(['status' => 'dipinjam']);
        });

        return back()->with('OK', "Peminjaman arsip {$arsip->nomor_arsip} berhasil dicatat.");
    }

    public function kembali(Request $request, ArsipPeminjaman $peminjaman)
    {
        $data = $request->validate([
            'tanggal_kembali' => ['required', 'date', 'after_or_equal:' . $peminjaman->tanggal_pinjam->toDateString()],
            'catatan' => ['nullable', 'string'],
        ]);

        if ($peminjaman->status !== 'dipinjam') {
            return back()->with('ERR', 'Peminjaman ini sudah dikembalikan.');
        }

        DB::transaction(function () use ($peminjaman, $data) {
            $peminjaman->update([
                'status' => 'dikembalikan',
                'tanggal_kembali' => $data['tanggal_kembali'],
                'catatan' => trim(($peminjaman->catatan ? $peminjaman->catatan . "\n" : '') . ($data['catatan'] ?? '')) ?: null,
            ]);
            $peminjaman->arsip->update(['status' => $peminjaman->status_arsip_sebelum]);
        });

        return back()->with('OK', "Arsip {$peminjaman->arsip->nomor_arsip} telah dikembalikan.");
    }
}
