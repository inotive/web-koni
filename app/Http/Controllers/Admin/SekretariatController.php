<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sekretariat;
use Illuminate\Http\Request;

class SekretariatController extends Controller
{
    public function index(Request $request)
    {
        $query = Sekretariat::query();

        if ($request->jenis_kegiatan_filter) {
            $query->where('jenis_kegiatan', $request->jenis_kegiatan_filter);
        }
        if ($request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }
        if ($request->search) {
            $query->where('nama_program_kegiatan', 'like', "%{$request->search}%");
        }

        $kegiatanLainnya = $query
            ->orderBy($request->get('sort', 'created_at'), $request->get('direction', 'desc'))
            ->paginate($request->get('per_page', 10));

        return view('admin.laporan-lpj.sekretariat.index', compact('kegiatanLainnya'));
    }

    public function create()
    {
        return view('admin.laporan-lpj.sekretariat.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'nama_program_kegiatan' => 'required',
        'jenis_kegiatan'        => 'required',
        'keterangan_tambahan'   => 'nullable', // atau 'required' jika kolom ini wajib diisi
        'volume'                => 'required',
        'jumlah_harga_satuan'   => 'required|numeric',
        'jumlah_harga'          => 'required|numeric',
        'foto_jurnal'           => 'nullable|image|max:2048',
        'dokumen_pendukung'     => 'nullable|mimes:pdf,doc,docx,xls,xlsx|max:5120',
    ]);

    $data = $request->all();

    if ($request->hasFile('foto_jurnal')) {
        $data['foto_jurnal'] = $request->file('foto_jurnal')->store('foto_jurnal', 'public');
    }
    if ($request->hasFile('dokumen_pendukung')) {
        $data['dokumen_pendukung'] = $request->file('dokumen_pendukung')->store('dokumen_pendukung', 'public');
    }

    Sekretariat::create($data);

    return redirect()->route('admin.laporan-lpj.sekretariat.index')
                     ->with('success', 'Kegiatan berhasil ditambahkan.');
}

    public function edit(Sekretariat $sekretariat)
    {
        return view('admin.laporan-lpj.sekretariat.edit', compact('sekretariat'));
    }

    public function update(Request $request, Sekretariat $sekretariat)
    {
        $request->validate([
            'nama_program_kegiatan' => 'required',
            'jenis_kegiatan'        => 'required',
            'keterangan_tambahan'   => 'nullable',
            'volume'                => 'required',
            'jumlah_harga_satuan'   => 'required|numeric',
            'jumlah_harga'          => 'required|numeric',
            'foto_jurnal'           => 'nullable|image|max:2048',
            'dokumen_pendukung'     => 'nullable|mimes:pdf,doc,docx,xls,xlsx|max:5120',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto_jurnal')) {
            $data['foto_jurnal'] = $request->file('foto_jurnal')->store('foto_jurnal', 'public');
        }
        if ($request->hasFile('dokumen_pendukung')) {
            $data['dokumen_pendukung'] = $request->file('dokumen_pendukung')->store('dokumen_pendukung', 'public');
        }

        $sekretariat->update($data);

        return redirect()->route('admin.laporan-lpj.sekretariat.index')
                         ->with('success', 'Kegiatan berhasil diperbarui.');
    }

    public function destroy(Sekretariat $sekretariat)
    {
        $sekretariat->delete();
        return redirect()->route('admin.laporan-lpj.sekretariat.index')
                         ->with('success', 'Kegiatan berhasil dihapus.');
    }
}
