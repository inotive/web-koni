<?php

namespace App\Http\Controllers;

use App\Models\Atlet;
use App\Models\CabangOlahraga;
use App\Models\Lpj;
use App\Models\ManajemenRKA;
use App\Models\Pelatih;
use App\Models\User;
use App\Models\Prestasi;
use App\Models\Target;
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
        $kegiatan_utama = Lpj::whereNull('parent_id')
                      ->where('id', '<=', 8)
                      ->get();
                      
        // Mengambil data Sekretariat (ID 59) dan Kegiatan Lainnya (ID 88)
        $kegiatan_tambahan = Lpj::whereNull('parent_id')
                              ->whereIn('id', [59, 88])
                              ->get();
                              
        // Gabungkan data kegiatan tambahan di awal
        $kegiatan = $kegiatan_tambahan->merge($kegiatan_utama);
        
        // Membagi total RKA secara merata ke setiap kegiatan yang sesuai untuk perhitungan persentase
        // Termasuk Sekretariat dan Kegiatan Lainnya dalam perhitungan
        $jumlah_kegiatan = $kegiatan->count();
        $rka_per_kegiatan = ($jumlah_kegiatan > 0 && $total_rka > 0) ? $total_rka / $jumlah_kegiatan : 0;
        
        // Menghitung total serapan hanya dari kegiatan yang ditampilkan
        // Hanya menghitung data yang benar-benar ditambahkan oleh user (bukan default)
        $total_serapan = 0;
        $kegiatan_berjalan_count = 0;
        
        $kegiatan = $kegiatan->map(function ($item) use ($rka_per_kegiatan, $total_rka, &$total_serapan, &$kegiatan_berjalan_count) {
            // Menetapkan total budget untuk setiap kegiatan (untuk perhitungan persentase per kegiatan)
            $item->total_budget = $rka_per_kegiatan;
            // Menetapkan total RKA keseluruhan (untuk ditampilkan di dashboard)
            $item->total_rka_keseluruhan = $total_rka;
            
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
            // Kecualikan nilai 2 yang merupakan data default/test
            $serapan_aktif_induk = ($item->jumlah_harga > 1 && $item->jumlah_harga != 2) ? $item->jumlah_harga : 0;
            $serapan_aktif_anak = $item->children->sum(function($child) {
                return ($child->jumlah_harga > 1 && $child->jumlah_harga != 2) ? $child->jumlah_harga : 0;
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
        
        // Sort kegiatan by default order (no filter options)
        $kegiatan = $kegiatan->values();

        // Mengambil semua prestasi terbaru dengan pagination (tanpa pencarian di index)
        // Gunakan per_page default 10 untuk halaman index
        $latest_prestasi_atlet = Prestasi::with(['subject', 'subject.cabangOlahraga'])
            ->where('subject_type', Atlet::class)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
            
        $latest_prestasi_pelatih = Prestasi::with(['subject', 'subject.cabangOlahraga'])
            ->where('subject_type', Pelatih::class)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $cabor_chart_data = CabangOlahraga::withCount(['atlets', 'pelatihs'])->get();

        $total_kegiatan_all = Target::sum('target_kegiatan');

        // Mengambil kegiatan berjalan dari semua halaman LPJ
        // 1. Sekretariat (ID 59) - hitung anak-anak dengan jumlah_harga > 0
        $kegiatan_berjalan_sekretariat = Lpj::where('parent_id', 59)->where('jumlah_harga', '>', 0)->count();
        
        // 2. Kegiatan Lainnya (ID 88) - hitung anak-anak dengan jumlah_harga > 0
        $kegiatan_berjalan_lainnya = Lpj::where('parent_id', 88)->where('jumlah_harga', '>', 0)->count();
        
        // 3. Bidang-bidang (ID 1-8) - hitung anak-anak dengan jumlah_harga > 0
        $kegiatan_berjalan_bidang = 0;
        for ($i = 1; $i <= 8; $i++) {
            // Untuk bidang dengan ID 6 (Pembinaan Prestasi), kita perlu menghitung kegiatan berjalan dari cucu-anaknya (great-grandchildren)
            if ($i == 6) {
                $children = Lpj::where('parent_id', $i)->get(); // Level 1 (Cabor)
                foreach ($children as $child) {
                    $grandchildren = Lpj::where('parent_id', $child->id)->get(); // Level 2 (Anak Cabor)
                    foreach ($grandchildren as $grandchild) {
                        // Level 3 (Kegiatan) - ini yang kita hitung jika jumlah_harga > 0
                        $greatGrandchildrenCount = Lpj::where('parent_id', $grandchild->id)->where('jumlah_harga', '>', 0)->count();
                        $kegiatan_berjalan_bidang += $greatGrandchildrenCount;
                    }
                }
            } else {
                // Untuk bidang lainnya, kita hitung anak-anak langsung jika jumlah_harga > 0
                $childrenCount = Lpj::where('parent_id', $i)->where('jumlah_harga', '>', 0)->count();
                $kegiatan_berjalan_bidang += $childrenCount;
            }
        }
        
        // Total kegiatan berjalan dari semua halaman LPJ
        $kegiatan_berjalan_all = $kegiatan_berjalan_sekretariat + $kegiatan_berjalan_lainnya + $kegiatan_berjalan_bidang;

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
            'latest_prestasi' => $latest_prestasi_atlet,
            'latest_prestasi_pelatih' => $latest_prestasi_pelatih,
            'cabor_chart_data' => $cabor_chart_data,
            'total_kegiatan_all' => $total_kegiatan_all,
            'kegiatan_berjalan_all' => $kegiatan_berjalan_all,
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
        // Menyertakan Sekretariat (ID 59) dan Kegiatan Lainnya (ID 88)
        $kegiatan_utama = Lpj::whereNull('parent_id')
                      ->where('id', '<=', 8)
                      ->get();
                      
        // Mengambil data Sekretariat (ID 59) dan Kegiatan Lainnya (ID 88)
        $kegiatan_tambahan = Lpj::whereNull('parent_id')
                              ->whereIn('id', [59, 88])
                              ->get();
                              
        // Gabungkan data kegiatan tambahan di awal
        $kegiatan = $kegiatan_tambahan->merge($kegiatan_utama);

        // Membagi total RKA secara merata ke setiap kegiatan yang sesuai
        $jumlah_kegiatan = $kegiatan->count();
        $rka_per_kegiatan = ($jumlah_kegiatan > 0 && $total_rka > 0) ? $total_rka / $jumlah_kegiatan : 0;

        // Menyiapkan data untuk export
        $exportKegiatan = collect();
        foreach ($kegiatan as $item) {
            // Menetapkan total budget untuk setiap kegiatan
            $item->total_budget = $rka_per_kegiatan;

            // Menghitung serapan untuk setiap kegiatan
            $serapan_induk = $item->jumlah_harga;
            $serapan_anak = $item->children->sum('jumlah_harga');
            $serapan = $serapan_induk + $serapan_anak;

            // Untuk perhitungan dashboard, hanya nilai > 1 yang dihitung sebagai serapan aktif
            // Kecualikan nilai 2 yang merupakan data default/test
            $serapan_aktif_induk = ($item->jumlah_harga > 1 && $item->jumlah_harga != 2) ? $item->jumlah_harga : 0;
            $serapan_aktif_anak = $item->children->sum(function($child) {
                return ($child->jumlah_harga > 1 && $child->jumlah_harga != 2) ? $child->jumlah_harga : 0;
            });
            $serapan_aktif = $serapan_aktif_induk + $serapan_aktif_anak;

            $item->serapan = $serapan_aktif;
            
            $exportKegiatan->push($item);
        }

        // Return view untuk export sebagai gambar
        return view('admin.dashboard.export', [
            'kegiatan' => $exportKegiatan,
            'total_rka' => $total_rka,
        ]);
    }
}

