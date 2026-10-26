<?php

namespace App\Http\Controllers\Admin\Arsip;

use App\Http\Controllers\Controller;
use App\Models\Arsip\Arsip;
use App\Models\Arsip\ArsipKategori;
use App\Models\Arsip\ArsipLokasi;
use App\Models\Arsip\ArsipPeminjaman;

class DashboardArsipController extends Controller
{
    public function index()
    {
        $perStatus = Arsip::selectRaw('status, COUNT(*) as total')->groupBy('status')->pluck('total', 'status');

        $perKategori = ArsipKategori::withCount(['arsip' => fn ($q) => $q->tersimpan()])
            ->orderByDesc('arsip_count')->limit(8)->get()
            ->filter(fn ($k) => $k->arsip_count > 0);

        // Box dengan kapasitas, diurutkan dari yang paling penuh
        $box = ArsipLokasi::where('tipe', 'box')->whereNotNull('kapasitas')
            ->withCount(['arsip as terisi' => fn ($q) => $q->tersimpan()])
            ->with('parent.parent.parent.parent')
            ->get()
            ->map(function ($b) {
                $b->persen = $b->kapasitas ? min(100, round($b->terisi / $b->kapasitas * 100)) : 0;
                return $b;
            })
            ->sortByDesc('persen')->take(8);

        return view('admin.arsip.dashboard.index', [
            'total' => $perStatus->sum(),
            'perStatus' => $perStatus,
            'perKategori' => $perKategori,
            'box' => $box,
            'jumlahLokasi' => ArsipLokasi::selectRaw('tipe, COUNT(*) as total')->groupBy('tipe')->pluck('total', 'tipe'),
            'terlambat' => ArsipPeminjaman::terlambat()->with('arsip')->orderBy('tanggal_rencana_kembali')->limit(5)->get(),
            'jumlahTerlambat' => ArsipPeminjaman::terlambat()->count(),
            'jumlahJatuhTempoInaktif' => Arsip::jatuhTempoInaktif()->count(),
            'jumlahJatuhTempoRetensi' => Arsip::jatuhTempoRetensi()->count(),
            'terbaru' => Arsip::with('lokasi')->latest()->limit(5)->get(),
        ]);
    }
}
