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
        // Get selected year from request, default to current year
        $selectedYear = $request->input('year', now()->year);
        
        // Get all available years for the dropdown
        $availableYears = Lpj::selectRaw('YEAR(created_at) as year')
                            ->distinct()
                            ->orderBy('year', 'desc')
                            ->pluck('year')
                            ->toArray();

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
                      ->where(function($query) use ($selectedYear) {
                          $query->whereYear('created_at', $selectedYear)
                                ->orWhereNull('created_at');
                      })
                      ->with(['children' => function($query) use ($selectedYear) {
                          $query->where(function($subQuery) use ($selectedYear) {
                              $subQuery->whereYear('created_at', $selectedYear)
                                       ->orWhereNull('created_at');
                          });
                          $query->with(['children' => function($subQuery) use ($selectedYear) {
                              $subQuery->where(function($subSubQuery) use ($selectedYear) {
                                  $subSubQuery->whereYear('created_at', $selectedYear)
                                              ->orWhereNull('created_at');
                              });
                              $subQuery->with(['children' => function($subSubQuery) use ($selectedYear) {
                                  $subSubQuery->where(function($subSubQueryInner) use ($selectedYear) {
                                      $subSubQueryInner->whereYear('created_at', $selectedYear)
                                                       ->orWhereNull('created_at');
                                  });
                              }]);
                          }]);
                      }])
                      ->get();
                      
        // Dapatkan ID untuk Kegiatan Lainnya secara dinamis
        $kegiatanLainnyaParent = Lpj::whereNull('parent_id')
                                   ->where('nama_program', 'kegiatan-lainnya')
                                   ->first();
        $kegiatanLainnyaId = $kegiatanLainnyaParent ? $kegiatanLainnyaParent->id : null;

        // Mengambil data Sekretariat (ID 59) dan Kegiatan Lainnya (dinamis)
        $kegiatan_tambahan = Lpj::whereNull('parent_id')
                              ->where(function($query) use ($kegiatanLainnyaId) {
                                  $query->where('id', 59); // Sekretariat
                                  if ($kegiatanLainnyaId) {
                                      $query->orWhere('id', $kegiatanLainnyaId); // Kegiatan Lainnya
                                  }
                              })
                              ->where(function($query) use ($selectedYear) {
                                  $query->whereYear('created_at', $selectedYear)
                                        ->orWhereNull('created_at');
                              })
                              ->with(['children' => function($query) use ($selectedYear) {
                                  $query->where(function($subQuery) use ($selectedYear) {
                                      $subQuery->whereYear('created_at', $selectedYear)
                                               ->orWhereNull('created_at');
                                  });
                              }])
                              ->get();
                              
        // Gabungkan data kegiatan tambahan di awal
        $kegiatan = $kegiatan_tambahan->merge($kegiatan_utama);
        
        // Menghitung total serapan hanya dari kegiatan yang ditampilkan
        // Hanya menghitung data yang benar-benar ditambahkan oleh user (bukan default)
        $total_serapan = 0;
        $kegiatan_berjalan_count = 0;

        // Mengambil semua target dan mengindeksnya berdasarkan id_lpj untuk pencarian efisien
        $targets = Target::all()->keyBy('id_lpj');
        
        $kegiatan = $kegiatan->map(function ($item) use ($total_rka, &$total_serapan, &$kegiatan_berjalan_count, $targets, $selectedYear, $kegiatanLainnyaId) {
            // Menghitung dan menetapkan total budget untuk setiap kegiatan
            $item_budget = 0;
            if ($item->id == 6) { // Special handling for Pembinaan Prestasi
                if ($item->children->count() > 0) {
                    // For Pembinaan Prestasi, budget might be stored at different levels (children or grandchildren)
                    $prestasi_children_ids = $item->children->pluck('id');
                    $prestasi_grandchildren_ids = \App\Models\Lpj::whereIn('parent_id', $prestasi_children_ids)->pluck('id');
                    
                    // First, try summing from grandchildren (deeper level)
                    foreach ($prestasi_grandchildren_ids as $grandchild_id) {
                        $grandchild_target = $targets->get((string)$grandchild_id);
                        if ($grandchild_target && isset($grandchild_target->target_anggaran)) {
                            $item_budget += (int)$grandchild_target->target_anggaran;
                        }
                    }
                    
                    // If no budget found at deepest level, try direct children (IDs 9-12)
                    if ($item_budget == 0) {
                        foreach ($item->children as $child_item) {
                            $child_target = $targets->get((string)$child_item->id);
                            if ($child_target && isset($child_target->target_anggaran)) {
                                $item_budget += (int) $child_target->target_anggaran;
                            }
                        }
                    }
                }
            } else { // Default logic for other items
                $target = $targets->get((string)$item->id);
                if ($target && isset($target->target_anggaran)) {
                    $item_budget = (int) $target->target_anggaran;
                }
            }
            $item->total_budget = $item_budget;
            
            // Menetapkan total RKA keseluruhan (untuk ditampilkan di dashboard)
            $item->total_rka_keseluruhan = $total_rka;

            // Hitung target kegiatan secara khusus untuk parent categories with children
            if ($item->children->count() > 0) {
                $total_target_parent = 0;
                
                // Special handling for Pembinaan Prestasi (ID 6) - target values are stored at grandchildren level (under IDs 9-12)
                if ($item->id == 6) {
                    // Get all IDs under the children of ID 6 (which are IDs 9-12)
                    $prestasi_children_ids = $item->children->pluck('id');
                    $prestasi_grandchildren_ids = \App\Models\Lpj::whereIn('parent_id', $prestasi_children_ids)->pluck('id');
                    
                    // Sum targets from all entries under the Cabor (ID 9-12) sections
                    foreach ($prestasi_grandchildren_ids as $grandchild_id) {
                        // Check if this grandchild_id exists in the targets collection
                        $grandchild_target = $targets->get((string)$grandchild_id);
                        if ($grandchild_target && isset($grandchild_target->target_kegiatan)) {
                            $total_target_parent += (int)$grandchild_target->target_kegiatan;
                        }
                    }
                    
                    // If no targets found at deepest level, try looking at direct children level
                    if ($total_target_parent == 0) {
                        foreach ($item->children as $child) { // IDs 9-12
                            $child_target = $targets->get((string)$child->id);
                            if ($child_target && isset($child_target->target_kegiatan)) {
                                $total_target_parent += (int)$child_target->target_kegiatan;
                            }
                        }
                    }
                } else {
                    // For other parent categories, look for targets at grandchild level
                    foreach ($item->children as $child) { // Child level
                        foreach ($child->children as $grandchild) { // Folders level
                            $grandchild_target = $targets->get((string)$grandchild->id);
                            if ($grandchild_target && isset($grandchild_target->target_kegiatan)) {
                                $total_target_parent += (int)$grandchild_target->target_kegiatan;
                            }
                        }
                    }
                }
                
                $item->target_kegiatan = $total_target_parent;
            } else {
                $target = $targets->get($item->id);
                $item->target_kegiatan = $target ? $target->target_kegiatan : 0;
            }

            // Hitung kegiatan berjalan
            if ($item->children->count() > 0) {
                if ($item->id == 59 || ($kegiatanLainnyaId && $item->id == $kegiatanLainnyaId)) {
                    $item->kegiatan_berjalan_count = $item->children->where('jumlah_harga', '>', 0)->filter(function($child) use ($selectedYear) {
                        return (!$child->created_at) || $child->created_at->year == $selectedYear;
                    })->count();
                } else {
                    // Special handling for Pembinaan Prestasi (ID 6)
                    if ($item->id == 6) {
                        $kegiatan_berjalan_count = 0;
                        // For Pembinaan Prestasi, count activities at the great-grandchildren level
                        foreach ($item->children as $child) { // Cabor level (IDs 9-12)
                            foreach ($child->children as $grandchild) { // Folders level
                                // Count grandchildren's children (great-grandchildren level) with jumlah_harga > 0
                                $activities = $grandchild->children->filter(function($greatGrandchild) use ($selectedYear) {
                                    return (!$greatGrandchild->created_at) || $greatGrandchild->created_at->year == $selectedYear;
                                })->filter(function($greatGrandchild) {
                                    return (int)($greatGrandchild->jumlah_harga ?? 0) > 0;
                                });
                                
                                $kegiatan_berjalan_count += $activities->count();
                            }
                        }
                        $item->kegiatan_berjalan_count = $kegiatan_berjalan_count;
                    } else {
                        $kegiatan_berjalan_parent = 0;
                        foreach ($item->children as $child) { // Child level
                            foreach ($child->children as $grandchild) { // Folders level
                                // Count grandchildren with jumlah_harga > 0 (filtered by year in the query)
                                $kegiatan_berjalan_parent += $grandchild->children->where('jumlah_harga', '>', 0)->filter(function($greatGrandchild) use ($selectedYear) {
                                    return (!$greatGrandchild->created_at) || $greatGrandchild->created_at->year == $selectedYear;
                                })->count();
                            }
                        }
                        $item->kegiatan_berjalan_count = $kegiatan_berjalan_parent;
                    }
                }
            } else {
                // Count children with jumlah_harga > 0 (filtered by year in the query)
                $item->kegiatan_berjalan_count = $item->children->where('jumlah_harga', '>', 0)->filter(function($child) use ($selectedYear) {
                    return (!$child->created_at) || $child->created_at->year == $selectedYear;
                })->count();
            }
            
            // Untuk Pembinaan Prestasi (ID 6) dan semua parent dengan children, tetapkan anggaran spesifik untuk setiap anak
            if ($item->children->count() > 0) {
                foreach ($item->children as $child) {
                    $child_target = $targets->get((string)$child->id);
                    $child_budget = 0;
                    if ($child_target && isset($child_target->target_anggaran)) {
                        $child_budget = (int) $child_target->target_anggaran;
                    }
                    $child->allocated_budget = $child_budget;
                }
            }
            
            // Menghitung serapan untuk setiap kegiatan
            $serapan_aktif = 0;

            if ($item->children->count() > 0) {
                // Special handling for parent categories with children
                $total_serapan_parent = 0;

                // Handle Sekretariat (ID 59) and Kegiatan Lainnya (dinamis) which have a flatter structure
                if ($item->id == 59 || ($kegiatanLainnyaId && $item->id == $kegiatanLainnyaId)) {
                    $total_serapan_parent = $item->children->sum(function($child) {
                        $harga = (int)($child->jumlah_harga ?? 0);
                        return ($harga > 1 && $harga != 2) ? $harga : 0;
                    });
                } else {
                    // Loop through each child to calculate its specific absorption for other items
                    foreach ($item->children as $child) {
                        $serapan_child = 0;
                        
                        // Check for deeper level data (grandchildren's children - 4th level)
                        $grandchild_ids = Lpj::where('parent_id', $child->id)
                            ->where(function($query) use ($selectedYear) {
                                $query->whereYear('created_at', $selectedYear)
                                    ->orWhereNull('created_at');
                            })->pluck('id');
                        
                        if ($grandchild_ids->count() > 0) {
                            $greatGrandchildren = Lpj::whereIn('parent_id', $grandchild_ids)
                                ->where(function($query) use ($selectedYear) {
                                    $query->whereYear('created_at', $selectedYear)
                                        ->orWhereNull('created_at');
                                })
                                ->get();
                            
                            $serapan_child = $greatGrandchildren->sum(function($greatGrandchild) {
                                $harga = (int)($greatGrandchild->jumlah_harga ?? 0);
                                return ($harga > 1 && $harga != 2) ? $harga : 0;
                            });
                        }
                        
                        // If no deeper level data found and this is not Pembinaan Prestasi, also consider direct child data
                        if ($serapan_child == 0 && $item->id != 6) {
                            $harga = (int)($child->jumlah_harga ?? 0);
                            if ($harga > 1 && $harga != 2) {
                                $serapan_child = $harga;
                            }
                        }
                        
                        // Attach the calculated absorption to the child object for the view
                        if ($item->id == 6) {
                            $child->serapan_cabor = $serapan_child;
                        } else {
                            $child->serapan_child = $serapan_child;
                        }
                        
                        // Add to the total for the parent category
                        $total_serapan_parent += $serapan_child;
                    }
                }
                $serapan_aktif = $total_serapan_parent;

            } else {
                // Original logic for activities without children
                $serapan_aktif_induk = ($item->jumlah_harga > 1 && $item->jumlah_harga != 2) ? $item->jumlah_harga : 0;
                $serapan_aktif = $serapan_aktif_induk;
            }

            $item->serapan = $serapan_aktif;
            $item->total_serapan = $serapan_aktif; // Set total_serapan to the active absorption
            
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
            ->whereYear('created_at', $selectedYear)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
            
        $latest_prestasi_pelatih = Prestasi::with(['subject', 'subject.cabangOlahraga'])
            ->where('subject_type', Pelatih::class)
            ->whereYear('created_at', $selectedYear)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $cabor_chart_data = CabangOlahraga::withCount(['atlets', 'pelatihs'])->get();

        $total_kegiatan_all = Target::sum('target_kegiatan');

        // Dapatkan ID untuk Kegiatan Lainnya secara dinamis (untuk kegiatan_berjalan)
        $kegiatanLainnyaParent = Lpj::whereNull('parent_id')
                                   ->where('nama_program', 'kegiatan-lainnya')
                                   ->first();
        $kegiatanLainnyaId = $kegiatanLainnyaParent ? $kegiatanLainnyaParent->id : null;

        // Mengambil kegiatan berjalan dari semua halaman LPJ
        // 1. Sekretariat (ID 59) - hitung anak-anak dengan jumlah_harga > 0
        $kegiatan_berjalan_sekretariat = Lpj::where('parent_id', 59)
            ->where('jumlah_harga', '>', 0)
            ->where(function($query) use ($selectedYear) {
                $query->whereYear('created_at', $selectedYear)
                      ->orWhereNull('created_at');
            })->count();
        
        // 2. Kegiatan Lainnya (dinamis) - hitung anak-anak dengan jumlah_harga > 0
        $kegiatan_berjalan_lainnya = $kegiatanLainnyaId ? Lpj::where('parent_id', $kegiatanLainnyaId)
            ->where('jumlah_harga', '>', 0)
            ->where(function($query) use ($selectedYear) {
                $query->whereYear('created_at', $selectedYear)
                      ->orWhereNull('created_at');
            })->count() : 0;
        
        // 3. Bidang-bidang (ID 1-8) - hitung anak-anak dengan jumlah_harga > 0
        $kegiatan_berjalan_bidang = 0;
        for ($i = 1; $i <= 8; $i++) {
            // Check if this parent has children (like how Pembinaan Prestasi does)
            $children = Lpj::where('parent_id', $i)
                ->where(function($query) use ($selectedYear) {
                    $query->whereYear('created_at', $selectedYear)
                          ->orWhereNull('created_at');
                })->get();
            if ($children->count() > 0) {
                // Special handling for Pembinaan Prestasi (ID 6)
                if ($i == 6) {
                    // For Pembinaan Prestasi, calculate from the great-grandchildren level
                    foreach ($children as $child) { // Cabor level (IDs 9-12)
                        $grandchildren = Lpj::where('parent_id', $child->id)
                            ->where(function($query) use ($selectedYear) {
                                $query->whereYear('created_at', $selectedYear)
                                      ->orWhereNull('created_at');
                            })->get(); // Level 2
                        foreach ($grandchildren as $grandchild) { // Level 2
                            $greatGrandchildren = Lpj::where('parent_id', $grandchild->id)->where('jumlah_harga', '>', 0)->get();
                            $greatGrandchildrenCount = $greatGrandchildren->filter(function($greatGrandchild) use ($selectedYear) {
                                return (!$greatGrandchild->created_at) || $greatGrandchild->created_at->year == $selectedYear;
                            })->count();
                            $kegiatan_berjalan_bidang += $greatGrandchildrenCount;
                        }
                    }
                } else {
                    // For other parent categories, calculate from grand-grandchildren level
                    foreach ($children as $child) {
                        $grandchildren = Lpj::where('parent_id', $child->id)
                            ->where(function($query) use ($selectedYear) {
                                $query->whereYear('created_at', $selectedYear)
                                      ->orWhereNull('created_at');
                            })->get(); // Level 2
                        foreach ($grandchildren as $grandchild) {
                            // Level 3 (Kegiatan) - ini yang kita hitung jika jumlah_harga > 0
                            $greatGrandchildren = Lpj::where('parent_id', $grandchild->id)->where('jumlah_harga', '>', 0)->get();
                            $greatGrandchildrenCount = $greatGrandchildren->filter(function($greatGrandchild) use ($selectedYear) {
                                return (!$greatGrandchild->created_at) || $greatGrandchild->created_at->year == $selectedYear;
                            })->count();
                            $kegiatan_berjalan_bidang += $greatGrandchildrenCount;
                        }
                    }
                }
            } else {
                // For parent categories without children, calculate from direct children level
                $children = Lpj::where('parent_id', $i)
                    ->where('jumlah_harga', '>', 0)
                    ->where(function($query) use ($selectedYear) {
                        $query->whereYear('created_at', $selectedYear)
                              ->orWhereNull('created_at');
                    })->get();
                $childrenCount = $children->filter(function($child) use ($selectedYear) {
                    return (!$child->created_at) || $child->created_at->year == $selectedYear;
                })->count();
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
            'selectedYear' => $selectedYear,
            'availableYears' => $availableYears,
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
        $kegiatan_utama = Lpj::whereNull('parent_id')
                      ->where('id', '<=', 8)
                      ->get();
        
        // Dapatkan ID untuk Kegiatan Lainnya secara dinamis
        $kegiatanLainnyaParent = Lpj::whereNull('parent_id')
                                   ->where('nama_program', 'kegiatan-lainnya')
                                   ->first();
        $kegiatanLainnyaId = $kegiatanLainnyaParent ? $kegiatanLainnyaParent->id : null;

        // Mengambil data Sekretariat (ID 59) dan Kegiatan Lainnya (dinamis)
        $kegiatan_tambahan = Lpj::whereNull('parent_id')
                              ->where(function($query) use ($kegiatanLainnyaId) {
                                  $query->where('id', 59); // Sekretariat
                                  if ($kegiatanLainnyaId) {
                                      $query->orWhere('id', $kegiatanLainnyaId); // Kegiatan Lainnya
                                  }
                              })
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

