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
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

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

        // Mengambil kegiatan dari LPJ hanya sampai ID 8 (Perencanaan Program dan Anggaran)
        // Mengecualikan Sekretariat (ID 59) dan kegiatan lain setelah ID 8
        $kegiatan = Lpj::whereNull('parent_id')
                      ->where('id', '<=', 8)
                      ->get();
        
        // Membagi total RKA secara merata ke setiap kegiatan yang sesuai
        $jumlah_kegiatan = $kegiatan->count();
        $rka_per_kegiatan = ($jumlah_kegiatan > 0 && $total_rka > 0) ? $total_rka / $jumlah_kegiatan : 0;
        
        // Menghitung total serapan hanya dari kegiatan yang ditampilkan
        // Hanya menghitung data yang benar-benar ditambahkan oleh user (bukan default)
        $total_serapan = 0;
        $kegiatan_berjalan_count = 0;
        
        $kegiatan = $kegiatan->map(function ($item) use ($rka_per_kegiatan, &$total_serapan, &$kegiatan_berjalan_count) {
            // Menetapkan total budget untuk setiap kegiatan
            $item->total_budget = $rka_per_kegiatan;
            
            // Untuk Pembinaan Prestasi (ID 6), kita perlu membagi anggarannya ke anak-anak
            if ($item->id == 6 && $rka_per_kegiatan > 0) {
                $anak_kegiatan = $item->children;
                $jumlah_anak = $anak_kegiatan->count();
                if ($jumlah_anak > 0) {
                    $anggaran_per_anak = $rka_per_kegiatan / $jumlah_anak;
                    // Menetapkan anggaran per anak
                    $anak_kegiatan->each(function($anak) use ($anggaran_per_anak) {
                        $anak->allocated_budget = $anggaran_per_anak;
                    });
                }
            }
            
            // Menghitung serapan untuk setiap kegiatan
            // Menghitung total serapan (induk + anak-anak)
            $serapan_induk = $item->jumlah_harga;
            $serapan_anak = $item->children->sum('jumlah_harga');
            $serapan = $serapan_induk + $serapan_anak;
            
            // Untuk perhitungan dashboard, hanya nilai > 1 yang dihitung sebagai serapan aktif
            $serapan_aktif_induk = $item->jumlah_harga > 1 ? $item->jumlah_harga : 0;
            $serapan_aktif_anak = $item->children->sum(function($child) {
                return $child->jumlah_harga > 1 ? $child->jumlah_harga : 0;
            });
            $serapan_aktif = $serapan_aktif_induk + $serapan_aktif_anak;
            
            $item->serapan = $serapan_aktif;
            $item->total_serapan = $serapan; // Total serapan termasuk default
            
            // Menambahkan ke total serapan
            $total_serapan += $serapan_aktif;
            
            // Menghitung kegiatan berjalan
            if ($serapan_aktif > 0) {
                $kegiatan_berjalan_count++;
            }
            
            return $item;
        });
        
        // Filter kegiatan berdasarkan parameter request SETELAH menghitung serapan
        if ($request->has('filter') && $request->filter != '') {
            switch ($request->filter) {
                case 'tertinggi':
                    $kegiatan = $kegiatan->sortByDesc(function($item) {
                        return $item->serapan;
                    })->values();
                    break;
                case 'terendah':
                    $kegiatan = $kegiatan->sortBy(function($item) {
                        return $item->serapan;
                    })->values();
                    break;
            }
        }

        // Mengambil semua prestasi terbaru dengan pagination (tanpa pencarian di index)
        // Gunakan per_page default 10 untuk halaman index
        $latest_prestasi = Prestasi::with(['subject', 'subject.cabangOlahraga'])
            ->where('subject_type', Atlet::class)
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        $cabor_chart_data = CabangOlahraga::withCount(['atlets', 'pelatihs'])->get();

        return view('admin.dashboard.index', [
            'title' => 'Dashboard',
            'total_rka' => $total_rka,
            'total_serapan' => $total_serapan,
            'total_pengurus' => $total_pengurus,
            'total_atlet' => $total_atlet,
            'total_pelatih' => $total_pelatih,
            'total_cabor' => $total_cabor,
            'kegiatan' => $kegiatan,
            'kegiatan_berjalan_count' => $kegiatan_berjalan_count,
            'latest_prestasi' => $latest_prestasi,
            'cabor_chart_data' => $cabor_chart_data,
        ]);
    }

    public function prestasiPagination(Request $request)
    {
        try {
            $perPage = $request->get('per_page', 5);
            if (!in_array($perPage, [5, 10, 25, 50, 100])) {
                $perPage = 5;
            }

            $query = Prestasi::with(['subject', 'subject.cabangOlahraga'])
                ->orderBy('created_at', 'desc');

            // Determine the type of subject to query
            $type = $request->get('type', 'atlet');
            if ($type === 'atlet') {
                $query->where('subject_type', Atlet::class);
            } elseif ($type === 'pelatih') {
                $query->where('subject_type', Pelatih::class);
            }

            // Apply search filter
            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $query->whereHas('subject', function ($q) use ($search) {
                    $q->where('nama', 'LIKE', "%{$search}%");
                });
            }

            $latest_prestasi = $query->paginate($perPage)
                ->appends($request->only(['search', 'per_page', 'type']));

            // Determine which partial view to render based on the type
            $partialView = 'admin.dashboard.partials._prestasi-atlet-table';
            if ($type === 'pelatih') {
                $partialView = 'admin.dashboard.partials._prestasi-pelatih-table';
            }

            return response()->json([
                'success' => true,
                'html' => view($partialView, [
                    'prestasi_list' => $latest_prestasi,
                    'type' => $type
                ])->render()
            ]);

        } catch (\Exception $e) {
            \Log::error('Error in prestasiPagination: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memuat data. Silakan coba lagi.'
            ], 500);
        }
    }

    public function exportData(Request $request)
    {
        // Mengambil total RKA dari model LaporanRKA
        $total_rka = \App\Models\LaporanRKA::sum('total_anggaran');

        // Mengambil kegiatan dari LPJ hanya sampai ID 8 (Perencanaan Program dan Anggaran)
        $kegiatan = Lpj::whereNull('parent_id')
                      ->where('id', '<=', 8)
                      ->get();

        // Membagi total RKA secara merata ke setiap kegiatan yang sesuai
        $jumlah_kegiatan = $kegiatan->count();
        $rka_per_kegiatan = ($jumlah_kegiatan > 0 && $total_rka > 0) ? $total_rka / $jumlah_kegiatan : 0;

        // Menyiapkan data untuk export
        $exportData = [];
        foreach ($kegiatan as $item) {
            // Menetapkan total budget untuk setiap kegiatan
            $item->total_budget = $rka_per_kegiatan;

            // Menghitung serapan untuk setiap kegiatan
            $serapan_induk = $item->jumlah_harga;
            $serapan_anak = $item->children->sum('jumlah_harga');
            $serapan = $serapan_induk + $serapan_anak;

            // Untuk perhitungan dashboard, hanya nilai > 1 yang dihitung sebagai serapan aktif
            $serapan_aktif_induk = $item->jumlah_harga > 1 ? $item->jumlah_harga : 0;
            $serapan_aktif_anak = $item->children->sum(function($child) {
                return $child->jumlah_harga > 1 ? $child->jumlah_harga : 0;
            });
            $serapan_aktif = $serapan_aktif_induk + $serapan_aktif_anak;

            $persen = ($rka_per_kegiatan > 0) ? round(($serapan_aktif / $rka_per_kegiatan) * 100) : 0;

            $exportData[] = [
                'no' => count($exportData) + 1,
                'nama_kegiatan' => $item->nama_program,
                'serapan' => $serapan_aktif,
                'anggaran' => $rka_per_kegiatan,
                'persen' => $persen,
                'jumlah_anak' => $item->children->count(),
            ];
        }

        // Return view untuk export sebagai gambar
        return view('admin.dashboard.export', [
            'exportData' => $exportData,
            'total_rka' => $total_rka,
            'total_serapan' => array_sum(array_column($exportData, 'serapan')),
        ]);
    }
}

