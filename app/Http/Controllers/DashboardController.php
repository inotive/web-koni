<?php

namespace App\Http\Controllers;

use App\Models\Atlet;
use App\Models\CabangOlahraga;
use App\Models\Lpj;
use App\Models\ManajemenRKA;
use App\Models\Pelatih;
use App\Models\User;
use App\Models\Prestasi;

class DashboardController extends Controller
{
    public function index()
    {
        // Mengambil total RKA dari model LaporanRKA
        $total_rka = \App\Models\LaporanRKA::sum('total_anggaran');
        
        $total_pengurus = User::role('admin')->count();
        $total_atlet = Atlet::count();
        $total_pelatih = Pelatih::count();
        $total_cabor = CabangOlahraga::count();
        
        // Mengambil kegiatan dari LPJ
        $kegiatan = Lpj::whereNull('parent_id')->get();
        
        // Mengambil 5 prestasi terbaru
        $latest_prestasi = Prestasi::with(['subject', 'subject.cabangOlahraga'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

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
}
