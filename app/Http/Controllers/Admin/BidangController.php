<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PembinaanHukum;
use App\Models\HubunganLembaga;
use App\Models\Kesehatan;
use App\Models\Organisasi;
use App\Models\PerencanaanProgram;
use App\Models\SportScience;
use App\Models\SumberDaya;

class BidangController extends Controller
{
    /**
     * Display the main bidang index page
     */
    public function index()
    {
        // Get count for Mobilisasi Sumberdaya
        $mobilisasiCount = SumberDaya::count();

        // You can also get counts for other bidang if needed
        // $hubunganLembagaCount = HubunganLembaga::count();
        // $kesehatanCount = Kesehatan::count();
        // $organisasiCount = Organisasi::count();
        // $pembinaanHukumCount = PembinaanHukum::count();
        // $sportScienceCount = SportScience::count();
        // $perencanaanProgramCount = PerencanaanProgram::count();

        return view('admin.laporan-lpj.bidang.index', compact('mobilisasiCount'));
    }

    /**
     * Display the pembinaan prestasi page
     */
    public function prestasiIndex()
    {
        return view('admin.laporan-lpj.bidang.prestasi.index');
    }

    /**
     * Display other bidang sections (placeholder methods)
     */
    public function mobilisasiSumberdayaIndex()
    {
        // Placeholder for Mobilisasi Sumberdaya page
        return view('admin.laporan-lpj.bidang.mobilisasi-sumberdaya.index');
    }

    public function hubunganAntarLembaga()
    {
        // Placeholder for Hubungan Antar Lembaga page
        return view('admin.laporan-lpj.bidang.hubungan-antar-lembaga.index');
    }

    public function kesehatan()
    {
        // Placeholder for Kesehatan page
        return view('admin.laporan-lpj.bidang.kesehatan.index');
    }

    public function organisasi()
    {
        // Placeholder for Organisasi page
        return view('admin.laporan-lpj.bidang.organisasi.index');
    }

    public function pembinaanHukum()
    {
        // Placeholder for Pembinaan Hukum page
        return view('admin.laporan-lpj.bidang.pembinaan-hukum.index');
    }

    public function sportScience()
    {
        // Placeholder for Sport Science & Iptek page
        return view('admin.laporan-lpj.bidang.sport-science.index');
    }

    public function perencanaanProgram()
    {
        // Placeholder for Perencanaan Program page
        return view('admin.laporan-lpj.bidang.perencanaan-program.index');
    }

    public function caborAkurasi(){
        return view ('admin.laporan-lpj.bidang.prestasi.Akurasi.index');
    }

    public function caborBeladiri(){
        return view ('admin.laporan-lpj.bidang.prestasi.Beladiri.index');
    }

    public function caborPermainan(){
        return view ('admin.laporan-lpj.bidang.prestasi.Permainan.index');
    }

    public function caborTerukur(){
        return view ('admin.laporan-lpj.bidang.prestasi.Terukur.index');
    }
}
