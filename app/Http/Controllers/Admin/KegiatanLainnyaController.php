<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KegiatanLainnya;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KegiatanLainnyaController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $search = $request->input('search');
        $jenisKegiatanFilter = $request->input('jenis_kegiatan_filter');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $sortBy = $request->input('sort', 'created_at');
        $sortDirection = $request->input('direction', 'desc');

        $query = KegiatanLainnya::query();

        // Apply search filter
        if ($search) {
            $query->where('nama_program_kegiatan', 'like', '%' . $search . '%')
                  ->orWhere('jenis_kegiatan', 'like', '%' . $search . '%')
                  ->orWhere('volume', 'like', '%' . $search . '%');
        }

        // Apply jenis kegiatan filter
        if ($jenisKegiatanFilter) {
            $query->where('jenis_kegiatan', $jenisKegiatanFilter);
        }

        // Apply date range filter
        if ($startDate) {
            $query->whereDate('tanggal_kegiatan', '>=', $startDate);
        }
        if ($endDate) {
            $query->whereDate('tanggal_kegiatan', '<=', $endDate);
        }

        // Apply sorting
        $query->orderBy($sortBy, $sortDirection);

        // Paginate with appends to preserve query parameters
        $kegiatanLainnya = $query->paginate($perPage)->appends($request->query());

        return view('admin.laporan-lpj.kegiatan_lainnya.index', compact('kegiatanLainnya'));
    }

    public function create()
    {
        return view('admin.laporan-lpj.kegiatan_lainnya.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_program_kegiatan' => 'required|string|max:255',
            'jenis_kegiatan' => 'required|string|max:255',
            'tanggal_kegiatan' => 'required|date',
            'volume' => 'required|string|max:255',
            'jumlah_harga_satuan' => 'required|numeric|min:0',
            'jumlah_harga' => 'required|numeric|min:0',
            'foto_jurnal' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'dokumen_pendukung' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:5120'
        ]);

        try {
            // Handle file uploads
            if ($request->hasFile('foto_jurnal')) {
                $validated['foto_jurnal'] = $request->file('foto_jurnal')
                    ->store('kegiatan_lainnya/foto', 'public');
            }

            if ($request->hasFile('dokumen_pendukung')) {
                $validated['dokumen_pendukung'] = $request->file('dokumen_pendukung')
                    ->store('kegiatan_lainnya/dokumen', 'public');
            }

            KegiatanLainnya::create($validated);

            return redirect()->route('admin.laporan-lpj.kegiatan_lainnya.index')
                ->with('success', 'Data berhasil ditambahkan!');

        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    public function show(KegiatanLainnya $kegiatanLainnya)
    {
        return view('admin.laporan-lpj.kegiatan_lainnya.show', compact('kegiatanLainnya'));
    }

    public function edit(KegiatanLainnya $kegiatan_lainnya)
    {
        return view('admin.laporan-lpj.kegiatan_lainnya.edit', compact('kegiatan_lainnya'));
    }

    public function update(Request $request, KegiatanLainnya $kegiatan_lainnya)
    {
        $validated = $request->validate([
            'nama_program_kegiatan' => 'required|string|max:255',
            'jenis_kegiatan' => 'required|string|max:255',
            'tanggal_kegiatan' => 'required|date',
            'volume' => 'required|string|max:255',
            'jumlah_harga_satuan' => 'required|numeric|min:0',
            'jumlah_harga' => 'required|numeric|min:0',
            'foto_jurnal' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'dokumen_pendukung' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:5120'
        ]);

        // Handle file uploads
        if ($request->hasFile('foto_jurnal')) {
            if ($kegiatan_lainnya->foto_jurnal) {
                Storage::disk('public')->delete($kegiatan_lainnya->foto_jurnal);
            }
            $validated['foto_jurnal'] = $request->file('foto_jurnal')->store('kegiatan_lainnya/foto', 'public');
        }

        if ($request->hasFile('dokumen_pendukung')) {
            if ($kegiatan_lainnya->dokumen_pendukung) {
                Storage::disk('public')->delete($kegiatan_lainnya->dokumen_pendukung);
            }
            $validated['dokumen_pendukung'] = $request->file('dokumen_pendukung')->store('kegiatan_lainnya/dokumen', 'public');
        }

        $kegiatan_lainnya->update($validated);

        return redirect()->route('admin.laporan-lpj.kegiatan_lainnya.index')
            ->with('success', 'Data berhasil diperbarui!');
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

        return redirect()->route('admin.laporan-lpj.kegiatan_lainnya.index')
            ->with('success', 'Data berhasil dihapus!');
    }
}