<?php

namespace App\Http\Controllers;

use App\Models\Atlet;
use App\Models\CabangOlahraga;
use App\Models\Lpj;
use App\Models\ManajemenRKA;
use App\Models\Pelatih;
use App\Models\User;
use App\Models\Prestasi;
use App\Models\Surat;
use App\Models\Target;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Get selected year from request, default to current year
        $selectedYear = (int) $request->input('year', now()->year);

        // Get all available years for the dropdown
        $availableYears = Lpj::selectRaw('YEAR(created_at) as year')
                            ->whereNotNull('created_at')
                            ->distinct()
                            ->orderBy('year', 'desc')
                            ->pluck('year')
                            ->toArray();

        // Mengambil total RKA dari model LaporanRKA
        $total_rka = \App\Models\LaporanRKA::sum('total_anggaran');

        $units = $this->buildUnits($selectedYear);

        $total_serapan = $units->sum('serapan');
        $kegiatan_berjalan_all = $units->sum('kegiatan');
        $total_kegiatan_all = $units->sum('target_kegiatan');

        $suratTahunIni = Surat::whereYear('created_at', $selectedYear);
        $total_surat_masuk = (clone $suratTahunIni)->where('jenis_surat', 'masuk')->count();
        $total_surat_keluar = (clone $suratTahunIni)->where('jenis_surat', 'keluar')->count();

        $latest_lpj = Lpj::entries()
            ->with('parent')
            ->whereYear('created_at', $selectedYear)
            ->latest()
            ->limit(5)
            ->get();

        $latest_surat_masuk = Surat::where('jenis_surat', 'masuk')
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard.index', [
            'title' => 'Dashboard',
            'total_rka' => $total_rka,
            'total_serapan' => $total_serapan,
            'units' => $units,
            'total_bidang' => $units->where('jenis', 'bidang')->count(),
            'total_lpj' => $units->sum('jumlah_lpj'),
            'total_surat_masuk' => $total_surat_masuk,
            'total_surat_keluar' => $total_surat_keluar,
            'latest_lpj' => $latest_lpj,
            'latest_surat_masuk' => $latest_surat_masuk,
            'total_kegiatan_all' => $total_kegiatan_all,
            'kegiatan_berjalan_all' => $kegiatan_berjalan_all,
            'selectedYear' => $selectedYear,
            'availableYears' => $availableYears,
        ]);
    }

    /**
     * Unit yang ditampilkan di Informasi Serapan: Sekretariat, setiap Bidang, dan Kegiatan Lainnya.
     * Serapan dan jumlah kegiatan dihitung dari seluruh isi folder, termasuk subfolder.
     */
    private function buildUnits(int $year)
    {
        $units = collect();

        $sekretariat = Lpj::folders()->whereNull('parent_id')->where('modul', 'sekretariat')->first();
        if ($sekretariat) {
            // Target Sekretariat & Kegiatan Lainnya tidak dibedakan per tahun (mengikuti halaman masing-masing)
            $units->push($this->summarizeFolder($sekretariat, $year, false) + [
                'jenis' => 'sekretariat',
                'nama' => 'Sekretariat',
                'url' => route('admin.laporan-lpj.sekretariat.index'),
            ]);
        }

        $bidangFolders = Lpj::folders()->whereNull('parent_id')->where('modul', 'bidang')->orderBy('id')->get();
        foreach ($bidangFolders as $bidang) {
            $units->push($this->summarizeFolder($bidang, $year, true) + [
                'jenis' => 'bidang',
                'nama' => $bidang->nama_program,
                'url' => route('admin.laporan-lpj.bidang.dynamic.child.index', ['parentId' => $bidang->id, 'year' => $year]),
            ]);
        }

        $kegiatanLainnya = Lpj::whereNull('parent_id')->where('nama_program', 'kegiatan-lainnya')->first();
        if ($kegiatanLainnya) {
            $units->push($this->summarizeFolder($kegiatanLainnya, $year, false) + [
                'jenis' => 'lainnya',
                'nama' => 'Kegiatan Lainnya',
                'url' => route('admin.laporan-lpj.kegiatan-lainnya.index'),
            ]);
        }

        return $units->map(function ($unit) use ($year) {
            $unit['subfolders'] = Lpj::folders()
                ->where('parent_id', $unit['id'])
                ->orderBy('nama_program')
                ->get()
                ->map(fn ($folder) => $this->summarizeFolder($folder, $year, $unit['jenis'] === 'bidang') + [
                    'nama' => $folder->nama_program,
                ]);

            return $unit;
        });
    }

    private function summarizeFolder(Lpj $folder, int $year, bool $targetPerTahun): array
    {
        $entries = Lpj::entries()
            ->whereIn('parent_id', $folder->folderTreeIds())
            ->whereYear('created_at', $year)
            ->pluck('jumlah_harga');

        // Nilai 1 dan 2 adalah data bawaan/dummy dari seeder, tidak dihitung sebagai serapan
        $aktif = $entries->filter(fn ($harga) => (int) $harga > 2);

        $targetQuery = Target::where('id_lpj', $folder->id);
        if ($targetPerTahun) {
            $targetQuery->whereYear('created_at', $year);
        }
        $target = $targetQuery->first();

        $targetAnggaran = (int) ($target->target_anggaran ?? 0);
        $serapan = (int) $aktif->sum();

        return [
            'id' => $folder->id,
            'serapan' => $serapan,
            'kegiatan' => $aktif->count(),
            'jumlah_lpj' => $entries->count(),
            'target_anggaran' => $targetAnggaran,
            'target_kegiatan' => (int) ($target->target_kegiatan ?? 0),
            'persen' => $targetAnggaran > 0 ? min(100, (int) round($serapan / $targetAnggaran * 100)) : 0,
        ];
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
        $selectedYear = (int) $request->input('year', now()->year);

        return view('admin.dashboard.export', [
            'units' => $this->buildUnits($selectedYear),
            'selectedYear' => $selectedYear,
        ]);
    }
}

