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
    public function index(Request $request)
    {
        // Mengambil total RKA dari model LaporanRKA
        $total_rka = \App\Models\LaporanRKA::sum('total_anggaran');

        $total_pengurus = User::count();
        $total_atlet = Atlet::count();
        $total_pelatih = Pelatih::count();
        $total_cabor = CabangOlahraga::count();

        // Mengambil kegiatan dari LPJ
        $kegiatan = Lpj::whereNull('parent_id')->get();

        // Mengambil semua prestasi terbaru dengan pagination (tanpa pencarian di index)
        $latest_prestasi = Prestasi::with(['subject', 'subject.cabangOlahraga'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

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
        \Log::info('Prestasi pagination called with page: ' . ($request->page ?? 'none') . ' and search: ' . ($request->search ?? 'none'));
        
        // Mengambil semua prestasi terbaru dengan pagination dan pencarian
        $query = Prestasi::with(['subject', 'subject.cabangOlahraga'])
            ->orderBy('created_at', 'desc');

        // Tambahkan pencarian jika ada parameter search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('subject', function ($q) use ($search) {
                $q->where('nama', 'LIKE', "%{$search}%");
            });
        }

        $latest_prestasi = $query->paginate(10, ['*'], 'page', $request->page ?? 1);

        // Tambahkan appends untuk mempertahankan parameter pencarian
        $latest_prestasi = $latest_prestasi->appends($request->only('search'));

        // Debugging
        \Log::info('Total items: ' . $latest_prestasi->total() . ', Current page: ' . $latest_prestasi->currentPage());
        
        // Return hanya tabel dan pagination
        return response()->json([
            'success' => true,
            'html' => view('admin.dashboard.partials.prestasi-table', [
                'latest_prestasi' => $latest_prestasi
            ])->render()
        ]);
    }
}
