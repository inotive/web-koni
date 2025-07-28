<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KegiatanLainnya;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // This line is correct and necessary!

class KegiatanLainnyaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kegiatanLainnya = KegiatanLainnya::all();
        // Assuming your admin views are also nested, e.g., resources/views/admin/kegiatan_lainnya/index.blade.php
        return view('admin.kegiatan_lainnya.index', compact('kegiatanLainnya'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.kegiatan_lainnya.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_program_kegiatan' => 'required|string|max:255',
            'volume' => 'nullable|integer',
            'jumlah_harga_satuan' => 'nullable|numeric',
            'jumlah_harga' => 'nullable|numeric',
            'foto_jurnal' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'dokumen' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:5000',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto_jurnal')) {
            $data['foto_jurnal_path'] = $request->file('foto_jurnal')->store('public/kegiatan_lainnya/foto_jurnal');
        }
        if ($request->hasFile('dokumen')) {
            $data['dokumen_path'] = $request->file('dokumen')->store('public/kegiatan_lainnya/dokumen');
        }

        KegiatanLainnya::create($data);

        // IMPORTANT: Update this redirect to match your actual route name
        // Based on your routes/web.php, it should be 'admin.konfigurasi.kegiatan-lainnya.index'
        return redirect()->route('admin.konfigurasi.kegiatan-lainnya.index')->with('success', 'Kegiatan Lainnya berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(KegiatanLainnya $kegiatanLainnya)
    {
        return view('admin.kegiatan_lainnya.show', compact('kegiatanLainnya'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KegiatanLainnya $kegiatanLainnya)
    {
        return view('admin.kegiatan_lainnya.edit', compact('kegiatanLainnya'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KegiatanLainnya $kegiatanLainnya)
    {
        $request->validate([
            'nama_program_kegiatan' => 'required|string|max:255',
            'volume' => 'nullable|integer',
            'jumlah_harga_satuan' => 'nullable|numeric',
            'jumlah_harga' => 'nullable|numeric',
            'foto_jurnal' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'dokumen' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:5000',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto_jurnal')) {
            if ($kegiatanLainnya->foto_jurnal_path) {
                Storage::delete($kegiatanLainnya->foto_jurnal_path); // <--- Removed backslash
            }
            $data['foto_jurnal_path'] = $request->file('foto_jurnal')->store('public/kegiatan_lainnya/foto_jurnal');
        }
        if ($request->hasFile('dokumen')) {
            if ($kegiatanLainnya->dokumen_path) {
                Storage::delete($kegiatanLainnya->dokumen_path); // <--- Removed backslash
            }
            $data['dokumen_path'] = $request->file('dokumen')->store('public/kegiatan_lainnya/dokumen');
        }

        $kegiatanLainnya->update($data);

        // IMPORTANT: Update this redirect to match your actual route name
        // Based on your routes/web.php, it should be 'admin.konfigurasi.kegiatan-lainnya.index'
        return redirect()->route('admin.konfigurasi.kegiatan-lainnya.index')->with('success', 'Kegiatan Lainnya berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KegiatanLainnya $kegiatanLainnya)
    {
        if ($kegiatanLainnya->foto_jurnal_path) {
            Storage::delete($kegiatanLainnya->foto_jurnal_path); // <--- Removed backslash
        }
        if ($kegiatanLainnya->dokumen_path) {
            Storage::delete($kegiatanLainnya->dokumen_path); // <--- Removed backslash
        }

        $kegiatanLainnya->delete();

        // IMPORTANT: Update this redirect to match your actual route name
        // Based on your routes/web.php, it should be 'admin.konfigurasi.kegiatan-lainnya.index'
        return redirect()->route('admin.konfigurasi.kegiatan-lainnya.index')->with('success', 'Kegiatan Lainnya berhasil dihapus!');
    }
}