<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use app\models\pembinaanhukum;
use app\models\hubunganlembaga;
use app\models\Kesehatan;
use app\models\organisasi;
use app\models\perencanaanprogram;
use app\models\sportscience;
use app\models\sumberdaya;

class BidangController extends Controller
{
    /**
     * Display the main bidang index page
     */
    public function index()
    {
        return view('admin.bidang.index');
    }

    /**
     * Display the pembinaan prestasi page
     */
    public function prestasiIndex()
    {
        return view('admin.bidang.prestasi.index');
    }

    /**
     * Display other bidang sections (placeholder methods)
     */
    public function mobilisasiSumberdayaIndex()
    {
        // Placeholder for Mobilisasi Sumberdaya page
        return view('admin.bidang.mobilisasi-sumberdaya.index');
    }

    public function hubunganAntarLembaga()
    {
        // Placeholder for Hubungan Antar Lembaga page
        return view('admin.bidang.hubungan-antar-lembaga.index');
    }

    public function kesehatan()
    {
        // Placeholder for Kesehatan page
        return view('admin.bidang.kesehatan.index');
    }

    public function organisasi()
    {
        // Placeholder for Organisasi page
        return view('admin.bidang.organisasi.index');
    }

    public function pembinaanHukum()
    {
        // Placeholder for Pembinaan Hukum page
        return view('admin.bidang.pembinaan-hukum.index');
    }

    public function sportScience()
    {
        // Placeholder for Sport Science & Iptek page
        return view('admin.bidang.sport-science.index');
    }

    public function perencanaanProgram()
    {
        // Placeholder for Perencanaan Program page
        return view('admin.bidang.perencanaan-program.index');
    }
}
