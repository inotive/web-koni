<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KegiatanLainnya;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage; // <--- PASTIKAN BARIS INI ADA!

class KegiatanLainnyaController extends Controller
{
    public function index(Request $request)
    {
        // ... (kode index method Anda)
        $search = $request->query('search');
        $jenis_kegiatan_filter = $request->query('jenis_kegiatan_filter');
        $start_date = $request->query('start_date');
        $end_date = $request->query('end_date');
        $perPage = $request->query('per_page', 10);
        $sortBy = $request->query('sort_by', 'created_at');
        $sortOrder = $request->query('sort_order', 'desc');

        $query = KegiatanLainnya::query();

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama_program_kegiatan', 'like', '%' . $search . '%')
                  ->orWhere('jenis_kegiatan', 'like', '%' . $search . '%')
                  ->orWhere('volume', 'like', '%' . $search . '%');
            });
        }

        if ($jenis_kegiatan_filter) {
            $query->where('jenis_kegiatan', $jenis_kegiatan_filter);
        }

        if ($start_date) {
            $query->whereDate('tanggal_kegiatan', '>=', $start_date);
        }
        if ($end_date) {
            $query->whereDate('tanggal_kegiatan', '<=', $end_date);
        }

        $query->orderBy($sortBy, $sortOrder);

        $kegiatanLainnya = $query->paginate($perPage)->withQueryString();

        return view('admin.kegiatan_lainnya.index', compact('kegiatanLainnya'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_program_kegiatan' => 'required|string|max:255',
            'jenis_kegiatan' => 'required|string|max:255',
            'tanggal_kegiatan' => 'required|date',
            'volume' => 'required|string|max:255',
            'jumlah_harga_satuan' => 'required|numeric',
            'jumlah_harga' => 'required|numeric',
            'foto_jurnal' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'dokumen_pendukung' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:5120',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto_jurnal')) {
            $data['foto_jurnal'] = $request->file('foto_jurnal')->store('kegiatan_lainnya/foto_jurnal', 'public');
        }
        if ($request->hasFile('dokumen_pendukung')) {
            $data['dokumen_pendukung'] = $request->file('dokumen_pendukung')->store('kegiatan_lainnya/dokumen_pendukung', 'public');
        }

        KegiatanLainnya::create($data);

        // PASTIKAN NAMA RUTE UNTUK REDIRECT INI BENAR!
        return redirect()->route('admin.laporan-pj.kegiatan-lainnya.index')->with('success', 'Kegiatan berhasil ditambahkan!');
    }

    public function show(KegiatanLainnya $kegiatan_lainnya)
    {
        return view('admin.kegiatan_lainnya.show', compact('kegiatan_lainnya'));
    }

    public function edit(KegiatanLainnya $kegiatan_lainnya)
    {
        return view('admin.kegiatan_lainnya.edit', compact('kegiatan_lainnya'));
    }

    public function update(Request $request, KegiatanLainnya $kegiatan_lainnya)
    {
        $request->validate([
            'nama_program_kegiatan' => 'required|string|max:255',
            'jenis_kegiatan' => 'required|string|max:255',
            'tanggal_kegiatan' => 'required|date',
            'volume' => 'required|string|max:255',
            'jumlah_harga_satuan' => 'required|numeric',
            'jumlah_harga' => 'required|numeric',
            'foto_jurnal' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'dokumen_pendukung' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:5120',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto_jurnal')) {
            if ($kegiatan_lainnya->foto_jurnal) {
                Storage::disk('public')->delete($kegiatan_lainnya->foto_jurnal);
            }
            $data['foto_jurnal'] = $request->file('foto_jurnal')->store('kegiatan_lainnya/foto_jurnal', 'public');
        }
        if ($request->hasFile('dokumen_pendukung')) {
            if ($kegiatan_lainnya->dokumen_pendukung) {
                Storage::disk('public')->delete($kegiatan_lainnya->dokumen_pendukung);
            }
            $data['dokumen_pendukung'] = $request->file('dokumen_pendukung')->store('kegiatan_lainnya/dokumen_pendukung', 'public');
        }

        $kegiatan_lainnya->update($data);

        // PASTIKAN NAMA RUTE UNTUK REDIRECT INI BENAR!
        return redirect()->route('admin.laporan-pj.kegiatan-lainnya.index')->with('success', 'Kegiatan berhasil diperbarui!');
    }

    public function destroy(KegiatanLainnya $kegiatan_lainnya)
    {
        if ($kegiatan_lainnya->foto_jurnal) {
            Storage::disk('public')->delete($kegiatan_lainnya->foto_jurnal);
        }
        if ($kegiatan_lainnya->dokumen_pendukung) {
            Storage::disk('public')->delete($kegiatan_lainnya->dokumen_pendukung);
        }

        $kegiatan_lainnya->delete();

        // PASTIKAN NAMA RUTE UNTUK REDIRECT INI BENAR!
        return redirect()->route('admin.laporan-pj.kegiatan-lainnya.index')->with('success', 'Kegiatan berhasil dihapus!');
    }
}