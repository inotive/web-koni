<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lpj;
use App\Models\Target;
use Illuminate\Support\Facades\DB;

class BidangController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:laporan-lpj-bidang');
    }

    /**
     * Display the main bidang index page
     */
    public function index(Request $request)
    {
        $selectedYear = $request->input('year', now()->year);
        $availableYears = Lpj::select(DB::raw('YEAR(created_at) as year'))
                            ->distinct()
                            ->orderBy('year', 'desc')
                            ->pluck('year');

        $bidangParentIds = [
            'mobilisasi' => 1,
            'hubungan_lembaga' => 2,
            'kesehatan' => 3,
            'organisasi' => 4,
            'pembinaan_hukum' => 5,
            'prestasi' => 6,
            'science' => 7,
            'perencanaan_program' => 8,
        ];

        $total_anggaran = 0;
        $total_kegiatan = 0;
        $bidangInfo = [];
        $bidangDetails = [];
        
        foreach ($bidangParentIds as $key => $id) {
            $target = Target::where('id_lpj', $id)->whereYear('created_at', $selectedYear)->first();

            if ($id == 6) { // Special handling for Pembinaan Prestasi
                $info = $this->getPrestasiInfo($id, $selectedYear);
                
                $prestasi_children_ids = Lpj::where('parent_id', $id)->pluck('id');
                $prestasi_grandchildren_ids = Lpj::whereIn('parent_id', $prestasi_children_ids)->pluck('id');
                $prestasi_target_kegiatan = Target::whereIn('id_lpj', $prestasi_grandchildren_ids)->whereYear('created_at', $selectedYear)->sum('target_kegiatan');
                $prestasi_target_anggaran = Target::whereIn('id_lpj', $prestasi_grandchildren_ids)->whereYear('created_at', $selectedYear)->sum('target_anggaran');

                $bidangDetails[$key] = [
                    'anggaran' => $info['anggaran'],
                    'target_anggaran' => $prestasi_target_anggaran,
                    'kegiatan' => $info['count'],
                    'target_kegiatan' => $prestasi_target_kegiatan
                ];
            } else {
                $info = $this->getDescendantsInfo($id, $selectedYear);
                $bidangDetails[$key] = [
                    'anggaran' => $info['anggaran'],
                    'target_anggaran' => $target->target_anggaran ?? 0,
                    'kegiatan' => $info['count'],
                    'target_kegiatan' => $target->target_kegiatan ?? 0
                ];
            }
            
            $bidangInfo[$key . 'Count'] = $info['count'];
            $total_anggaran += $info['anggaran'];
            $total_kegiatan += $info['count'];
        }

        $target_anggaran = Target::whereIn('id_lpj', array_values($bidangParentIds))->whereYear('created_at', $selectedYear)->sum('target_anggaran');
        $target_kegiatan = Target::whereIn('id_lpj', array_values($bidangParentIds))->whereYear('created_at', $selectedYear)->sum('target_kegiatan');

        return view('admin.laporan-lpj.bidang.index', array_merge($bidangInfo, [
            'total_anggaran' => $total_anggaran,
            'total_kegiatan' => $total_kegiatan,
            'target_anggaran' => $target_anggaran,
            'target_kegiatan' => $target_kegiatan,
            'bidangDetails' => $bidangDetails,
            'selectedYear' => $selectedYear,
            'availableYears' => $availableYears,
        ]));
    }

    private function getAllDescendantIds($parentId) {
        $children = Lpj::where('parent_id', $parentId)->get();
        $ids = $children->pluck('id')->toArray();
        foreach ($children as $child) {
            $ids = array_merge($ids, $this->getAllDescendantIds($child->id));
        }
        return $ids;
    }

    private function getPrestasiInfo($parentId, $year)
    {
        $info = ['count' => 0, 'anggaran' => 0];
        $children_ids = Lpj::where('parent_id', $parentId)->pluck('id');
        $grandchildren_ids = Lpj::whereIn('parent_id', $children_ids)->pluck('id');
        
        $reports = Lpj::whereIn('parent_id', $grandchildren_ids)->whereYear('created_at', $year)->get();
        
        $info['count'] = $reports->count();
        $info['anggaran'] = $reports->sum('jumlah_harga');

        return $info;
    }

    private function getDescendantsInfo($parentId, $year)
    {
        $allDescendantIds = $this->getAllDescendantIds($parentId);
        array_push($allDescendantIds, $parentId);

        $reports = Lpj::whereIn('parent_id', $allDescendantIds)
                        ->whereYear('created_at', $year)
                        ->whereDoesntHave('children')
                        ->get();

        return [
            'count' => $reports->count(),
            'anggaran' => $reports->sum('jumlah_harga')
        ];
    }

    public function prestasiIndex(Request $request)
    {
        $selectedYear = $request->input('year', now()->year);
        $availableYears = Lpj::select(DB::raw('YEAR(created_at) as year'))->distinct()->orderBy('year', 'desc')->pluck('year');

        $prestasiParentId = 6;
        $parent = Lpj::find($prestasiParentId);
        $children = Lpj::where('parent_id', $prestasiParentId)
                       ->withCount('children')
                       ->orderBy('nama_program', 'asc')
                       ->get();
        
        return view('admin.laporan-lpj.bidang.prestasi.index', compact('children', 'parent', 'selectedYear', 'availableYears'));
    }

    private function getCaborData(Request $request, $parentId)
    {
        $selectedYear = $request->input('year', now()->year);
        $availableYears = Lpj::select(DB::raw('YEAR(created_at) as year'))->distinct()->orderBy('year', 'desc')->pluck('year');

        $parent = Lpj::findOrFail($parentId);
        
        $children = Lpj::where('parent_id', $parentId)
                        ->with(['target' => function($query) use ($selectedYear) {
                            $query->whereYear('created_at', $selectedYear);
                        }])
                        ->orderBy('nama_program', 'asc')
                        ->get();
        
        foreach ($children as $child) {
            $reports = Lpj::where('parent_id', $child->id)->whereYear('created_at', $selectedYear)->get();
            $anggaran = $reports->sum('jumlah_harga');
            $kegiatan = $reports->count();

            $child->realisasi_anggaran = $anggaran;
            $child->children_count = $kegiatan;
            $child->target_anggaran_value = $child->target->target_anggaran ?? 0;
            $child->target_kegiatan_value = $child->target->target_kegiatan ?? 0;
        }

        return compact('children', 'parent', 'selectedYear', 'availableYears');
    }

    public function caborAkurasi(Request $request)
    {
        $data = $this->getCaborData($request, 10);
        if ($request->ajax()) {
            return view('admin.laporan-lpj.bidang.prestasi.Akurasi._table', $data)->render();
        }
        return view('admin.laporan-lpj.bidang.prestasi.Akurasi.index', $data);
    }

    public function caborBeladiri(Request $request)
    {
        $data = $this->getCaborData($request, 12);
        if ($request->ajax()) {
            return view('admin.laporan-lpj.bidang.prestasi.Beladiri._table', $data)->render();
        }
        return view('admin.laporan-lpj.bidang.prestasi.Beladiri.index', $data);
    }

    public function caborPermainan(Request $request)
    {
        $data = $this->getCaborData($request, 11);
        if ($request->ajax()) {
            return view('admin.laporan-lpj.bidang.prestasi.Permainan._table', $data)->render();
        }
        return view('admin.laporan-lpj.bidang.prestasi.Permainan.index', $data);
    }

    public function caborTerukur(Request $request)
    {
        $data = $this->getCaborData($request, 9);
        if ($request->ajax()) {
            return view('admin.laporan-lpj.bidang.prestasi.Terukur._table', $data)->render();
        }
        return view('admin.laporan-lpj.bidang.prestasi.Terukur.index', $data);
    }

    /**
     * Legacy methods - you can remove these if you're not using separate models anymore
     */
    public function mobilisasiSumberdayaIndex()
    {
        return redirect()->route('admin.laporan-lpj.bidang.dynamic.child.index', ['parentId' => 1]);
    }

    public function hubunganAntarLembaga()
    {
        return redirect()->route('admin.laporan-lpj.bidang.dynamic.child.index', ['parentId' => 2]);
    }

    public function kesehatan()
    {
        return redirect()->route('admin.laporan-lpj.bidang.dynamic.child.index', ['parentId' => 3]);
    }

    public function organisasi()
    {
        return redirect()->route('admin.laporan-lpj.bidang.dynamic.child.index', ['parentId' => 4]);
    }

    public function pembinaanHukum()
    {
        return redirect()->route('admin.laporan-lpj.bidang.dynamic.child.index', ['parentId' => 5]);
    }

    public function sportScience()
    {
        return redirect()->route('admin.laporan-lpj.bidang.dynamic.child.index', ['parentId' => 7]);
    }

    public function perencanaanProgram()
    {
        return redirect()->route('admin.laporan-lpj.bidang.dynamic.child.index', ['parentId' => 8]);
    }
}