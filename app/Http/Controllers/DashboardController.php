<?php

namespace App\Http\Controllers;

use App\Models\Atlet;
use App\Models\CabangOlahraga;
use App\Models\Lpj;
use App\Models\ManajemenRKA;
use App\Models\Pelatih;
use App\Models\User;
use App\Models\Prestasi;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Mengambil total RKA dari model LaporanRKA
        $total_rka = \App\Models\LaporanRKA::sum('total_anggaran');

        $total_pengurus = User::count();
        $total_atlet = Atlet::count();
        $total_pelatih = Pelatih::count();
        $total_cabor = CabangOlahraga::count();

        // Mengambil kegiatan dari LPJ
        $kegiatan = Lpj::whereNull('parent_id')->get();

        // Mengambil semua prestasi terbaru dengan pagination
        $latest_prestasi = Prestasi::with(['subject', 'subject.cabangOlahraga'])
            ->orderBy('created_at', 'desc')
            ->paginate(10); // 10 items per page

        $cabor_chart_data = CabangOlahraga::withCount(['atlets', 'pelatihs'])->get();

        return view('admin.dashboard.index', [
            'title' => 'Dashboard',
            'total_rka' => $total_rka,
            'total_pengurus' => $total_pengurus,
            'total_atlet' => $total_atlet,
            'total_pelatih' => $total_pelatih,
            'total_cabor' => $total_cabor,
            'kegiatan' => $kegiatan,
            'latest_prestasi' => $latest_prestasi,
            'cabor_chart_data' => $cabor_chart_data,
        ]);
    }

    public function prestasiPagination(Request $request)
    {
        // Debugging
        \Log::info('Prestasi pagination called with page: ' . ($request->page ?? 'none'));
        
        // Mengambil semua prestasi terbaru dengan pagination
        $latest_prestasi = Prestasi::with(['subject', 'subject.cabangOlahraga'])
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'page', $request->page ?? 1); // 10 items per page

        // Debugging
        \Log::info('Total items: ' . $latest_prestasi->total() . ', Current page: ' . $latest_prestasi->currentPage());
        
        // Return hanya tabel dan pagination
        return view('admin.dashboard.partials.prestasi-table', [
            'latest_prestasi' => $latest_prestasi
        ])->render();
    }
}
