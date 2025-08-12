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
        $query = Surat::query();

        // Filter berdasarkan pencarian
        if ($request->has('search') && $request->search) {
            $query->search($request->search);
        }

        // Filter berdasarkan jenis surat
        if ($request->has('jenis_surat') && $request->jenis_surat) {
            $query->byJenisSurat($request->jenis_surat);
        }

        // Filter berdasarkan rentang tanggal
        if ($request->has('start_date') || $request->has('end_date')) {
            $query->byDateRange($request->start_date, $request->end_date);
        }

        // Sorting
        $sortBy = $request->get('sort', 'created_at');
        $sortOrder = $request->get('order', 'desc');

        // Validasi kolom yang bisa di-sort
        $allowedSorts = ['nama_kegiatan', 'created_at', 'jenis_surat'];
        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        // Pagination
        $perPage = $request->get('per_page', 10);
        $suratMasukKeluar = $query->paginate($perPage);

        // Untuk backward compatibility dengan view yang menggunakan $surat
        $surat = $suratMasukKeluar;

        return view('admin.surat.index', compact('suratMasukKeluar', 'surat'));
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
            'dokumen_surat' => 'nullable|file|mimes:pdf,doc,docx|max:10240', // 10MB max
        ]);

        $data = $request->only(['nama_kegiatan', 'no_surat', 'jenis_surat']);

        // Handle file upload
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

        // Handle file upload
        if ($request->hasFile('dokumen_surat')) {
            // Delete old file if exists
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
        // Delete file if exists
        if ($surat->dokumen_surat && Storage::disk('public')->exists($surat->dokumen_surat)) {
            Storage::disk('public')->delete($surat->dokumen_surat);
        }

        $surat->delete();

        return redirect()->route('admin.surat.index')
                        ->with('success', 'Surat berhasil dihapus!');
    }
}
