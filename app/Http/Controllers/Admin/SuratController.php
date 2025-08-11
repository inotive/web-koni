<?php

namespace App\Http\Controllers\Admin;

use App\Models\Surat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class SuratController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $baseQuery = Surat::query();

        if ($request->has('search') && $request->search) {
            $baseQuery->search($request->search);
        }

        if ($request->has('start_date') || $request->has('end_date')) {
            $baseQuery->byDateRange($request->start_date, $request->end_date);
        }

        $sortBy = $request->get('sort', 'created_at');
        $sortOrder = $request->get('order', 'desc');

        $allowedSorts = ['nama_kegiatan', 'created_at', 'jenis_surat'];
        if (in_array($sortBy, $allowedSorts)) {
            $baseQuery->orderBy($sortBy, $sortOrder);
        } else {
            $baseQuery->orderBy('created_at', 'desc');
        }

        $perPage = $request->get('per_page', 10);

        $suratMasukKeluar = clone $baseQuery;
        $suratMasukKeluar = $suratMasukKeluar->paginate($perPage, ['*'], 'page');

        $suratMasuk = clone $baseQuery;
        $suratMasuk = $suratMasuk->byJenisSurat('masuk')->paginate($perPage, ['*'], 'masuk_page');

        $suratKeluar = clone $baseQuery;
        $suratKeluar = $suratKeluar->byJenisSurat('keluar')->paginate($perPage, ['*'], 'keluar_page');

        $surat = $suratMasukKeluar;

        return view('admin.surat.index', compact(
            'suratMasukKeluar',
            'suratMasuk',
            'suratKeluar',
            'surat'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.surat.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'no_surat' => 'required|string|max:255|unique:surat',
            'jenis_surat' => 'required|in:masuk,keluar',
            'dokumen_surat' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ]);

        $data = $request->only(['nama_kegiatan', 'no_surat', 'jenis_surat']);

        if ($request->hasFile('dokumen_surat')) {
            $data['dokumen_surat'] = $request->file('dokumen_surat')->store('surat', 'public');
        }

        Surat::create($data);

        return redirect()->route('admin.surat.index')
                        ->with('success', 'Surat berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Surat $surat)
    {
        return view('admin.surat.show', compact('surat'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Surat $surat)
    {
        return view('admin.surat.edit', compact('surat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Surat $surat)
    {
        $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'no_surat' => 'required|string|max:255|unique:surat,no_surat,' . $surat->id,
            'jenis_surat' => 'required|in:masuk,keluar',
            'dokumen_surat' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ]);

        $data = $request->only(['nama_kegiatan', 'no_surat', 'jenis_surat']);

        if ($request->hasFile('dokumen_surat')) {
            if ($surat->dokumen_surat && Storage::disk('public')->exists($surat->dokumen_surat)) {
                Storage::disk('public')->delete($surat->dokumen_surat);
            }

            $data['dokumen_surat'] = $request->file('dokumen_surat')->store('surat', 'public');
        }

        $surat->update($data);

        return redirect()->route('admin.surat.index')
                        ->with('success', 'Surat berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Surat $surat)
    {
        if ($surat->dokumen_surat && Storage::disk('public')->exists($surat->dokumen_surat)) {
            Storage::disk('public')->delete($surat->dokumen_surat);
        }

        $surat->delete();

        return redirect()->route('admin.surat.index')
                        ->with('success', 'Surat berhasil dihapus!');
    }
}
