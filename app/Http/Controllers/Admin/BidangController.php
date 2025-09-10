<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lpj;
use App\Models\Target;

class BidangController extends Controller
{
    /**
     * Display the main bidang index page
     */
    public function index()
    {
        // Define the parent IDs for each bidang
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

        // Initialize totals
        $total_anggaran = 0;
        $total_kegiatan = 0;

        // Calculate counts and totals for each bidang
        $bidangInfo = [];
        foreach ($bidangParentIds as $key => $id) {
            $info = $this->getDescendantsInfo($id);
            $bidangInfo[$key . 'Count'] = $info['count'];
            $total_anggaran += $info['anggaran'];
            $total_kegiatan += $info['count'];
        }

        // Get target values
        $target_anggaran = Target::sum('target_anggaran');
        $target_kegiatan = Target::sum('target_kegiatan');

        return view('admin.laporan-lpj.bidang.index', array_merge($bidangInfo, [
            'total_anggaran' => $total_anggaran,
            'total_kegiatan' => $total_kegiatan,
            'target_anggaran' => $target_anggaran,
            'target_kegiatan' => $target_kegiatan,
        ]));
    }

    /**
     * Recursively get descendants' information (count and budget)
     */
    private function getDescendantsInfo($parentId)
    {
        $children = Lpj::where('parent_id', $parentId)->get();

        $count = 0;
        $anggaran = 0;

        foreach ($children as $child) {
            $subChildren = Lpj::where('parent_id', $child->id)->get();
            if ($subChildren->isEmpty()) {
                // This is a leaf node (an activity)
                $count++;
                $anggaran += $child->jumlah_harga;
            } else {
                // This is a category, recurse
                $info = $this->getDescendantsInfo($child->id);
                $count += $info['count'];
                $anggaran += $info['anggaran'];
            }
        }

        return ['count' => $count, 'anggaran' => $anggaran];
    }


    /**
     * Recursively count all descendants of a parent
     * Use this if you want total count including sub-levels
     */
    private function countAllDescendants($parentId)
    {
        $count = 0;

        $children = Lpj::where('parent_id', $parentId)->get();
        $count += $children->count();

        foreach ($children as $child) {
            $count += $this->countAllDescendants($child->id);
        }

        return $count;
    }

    /**
     * Get count of data entries only (not categories)
     * Use this if you only want to count actual data entries, not parent categories
     */
    private function getDataEntriesCount($parentId)
    {
        return Lpj::where('parent_id', $parentId)
                  ->where(function($query) {
                      $query->whereNotNull('volume')
                            ->orWhereNotNull('jumlah_harga_satuan')
                            ->orWhereNotNull('jumlah_harga');
                  })
                  ->count();
    }

    /**
     * Display the pembinaan prestasi page
     */
    public function prestasiIndex()
    {
        // Get prestasi parent and its children for the prestasi index page
        $prestasiParentId = 6; // Adjust based on your seeded data
        $parent = Lpj::find($prestasiParentId);
        $children = Lpj::where('parent_id', $prestasiParentId)
                       ->withCount('children')
                       ->orderBy('nama_program', 'asc')
                       ->get();

        return view('admin.laporan-lpj.bidang.prestasi.index', compact('children', 'parent'));
    }

    /**
     * Cabor Akurasi - Updated to match your new structure
     */
    public function caborAkurasi(Request $request)
    {
        // The ID for 'Cabor Akurasi' - adjust based on your seeded data
        $caborAkurasiParentId = 10;

        // Eager load children count for performance
        $parent = Lpj::findOrFail($caborAkurasiParentId);
        $children = Lpj::where('parent_id', $caborAkurasiParentId)
                        ->withCount('children') // Counts sub-items (dokumen)
                        ->orderBy('nama_program', 'asc')
                        ->get();

        if ($request->ajax()) {
            return view('admin.laporan-lpj.bidang.prestasi.Akurasi._table', compact('children'))->render();
        }

        return view('admin.laporan-lpj.bidang.prestasi.Akurasi.index', compact('children', 'parent'));
    }

    public function caborBeladiri(Request $request)
    {
        $caborBeladiriParentId = 12; // Adjust based on your seeded data

        $parent = Lpj::findOrFail($caborBeladiriParentId);
        $children = Lpj::where('parent_id', $caborBeladiriParentId)
                        ->withCount('children')
                        ->orderBy('nama_program', 'asc')
                        ->get();

        if ($request->ajax()) {
            return view('admin.laporan-lpj.bidang.prestasi.Beladiri._table', compact('children'))->render();
        }

        return view('admin.laporan-lpj.bidang.prestasi.Beladiri.index', compact('children', 'parent'));
    }

    public function caborPermainan(Request $request)
    {
        $caborPermainanParentId = 11; // Adjust based on your seeded data

        $parent = Lpj::findOrFail($caborPermainanParentId);
        $children = Lpj::where('parent_id', $caborPermainanParentId)
                        ->withCount('children')
                        ->orderBy('nama_program', 'asc')
                        ->get();

        if ($request->ajax()) {
            return view('admin.laporan-lpj.bidang.prestasi.Permainan._table', compact('children'))->render();
        }

        return view('admin.laporan-lpj.bidang.prestasi.Permainan.index', compact('children', 'parent'));
    }

    public function caborTerukur(Request $request)
    {
        $caborTerukurParentId = 9; // Adjust based on your seeded data

        $parent = Lpj::findOrFail($caborTerukurParentId);
        $children = Lpj::where('parent_id', $caborTerukurParentId)
                        ->withCount('children')
                        ->orderBy('nama_program', 'asc')
                        ->get();

        if ($request->ajax()) {
            return view('admin.laporan-lpj.bidang.prestasi.Terukur._table', compact('children'))->render();
        }

        return view('admin.laporan-lpj.bidang.prestasi.Terukur.index', compact('children', 'parent'));
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
