<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sekretariat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'keterangan_tambahan'   => 'nullable',
            'volume'                => 'required',
            'jumlah_harga_satuan'   => 'required|numeric',
            'jumlah_harga'          => 'required|numeric',
            'foto_jurnal.*'         => 'nullable|image|mimes:jpeg,jpg,png,gif|max:10240',
            'foto_jurnal'           => 'nullable|array|max:10',
            'dokumen_pendukung.*'   => 'nullable|mimes:pdf,doc,docx,xls,xlsx|max:10240',
            'dokumen_pendukung'     => 'nullable|array|max:10',
        ]);

        $data = $request->except(['foto_jurnal', 'dokumen_pendukung']);

        if ($request->hasFile('foto_jurnal')) {
            $fotoJurnalPaths = [];
            foreach ($request->file('foto_jurnal') as $foto) {
                $path = $foto->store('foto_jurnal', 'public');
                $fotoJurnalPaths[] = $path;
            }
            $data['foto_jurnal'] = json_encode($fotoJurnalPaths);
        }

        if ($request->hasFile('dokumen_pendukung')) {
            $dokumenPendukungPaths = [];
            foreach ($request->file('dokumen_pendukung') as $dokumen) {
                $path = $dokumen->store('dokumen_pendukung', 'public');
                $dokumenPendukungPaths[] = $path;
            }
            $data['dokumen_pendukung'] = json_encode($dokumenPendukungPaths);
        }

        Sekretariat::create($data);

        return redirect()->route('admin.laporan-lpj.sekretariat.index')
                         ->with('OK', 'Kegiatan berhasil ditambahkan.');
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
            'foto_jurnal.*'         => 'nullable|image|mimes:jpeg,jpg,png,gif|max:10240',
            'foto_jurnal'           => 'nullable|array|max:10',
            'dokumen_pendukung.*'   => 'nullable|mimes:pdf,doc,docx,xls,xlsx|max:10240',
            'dokumen_pendukung'     => 'nullable|array|max:10',
        ]);

        $data = $request->except(['foto_jurnal', 'dokumen_pendukung']);

        if ($request->hasFile('foto_jurnal')) {
            if ($sekretariat->foto_jurnal) {
                $oldFotos = json_decode($sekretariat->foto_jurnal, true);
                if (is_array($oldFotos)) {
                    foreach ($oldFotos as $oldFoto) {
                        Storage::disk('public')->delete($oldFoto);
                    }
                }
            }

            $fotoJurnalPaths = [];
            foreach ($request->file('foto_jurnal') as $foto) {
                $path = $foto->store('foto_jurnal', 'public');
                $fotoJurnalPaths[] = $path;
            }
            $data['foto_jurnal'] = json_encode($fotoJurnalPaths);
        }

        if ($request->hasFile('dokumen_pendukung')) {
            if ($sekretariat->dokumen_pendukung) {
                $oldDokumens = json_decode($sekretariat->dokumen_pendukung, true);
                if (is_array($oldDokumens)) {
                    foreach ($oldDokumens as $oldDokumen) {
                        Storage::disk('public')->delete($oldDokumen);
                    }
                }
            }

            $dokumenPendukungPaths = [];
            foreach ($request->file('dokumen_pendukung') as $dokumen) {
                $path = $dokumen->store('dokumen_pendukung', 'public');
                $dokumenPendukungPaths[] = $path;
            }
            $data['dokumen_pendukung'] = json_encode($dokumenPendukungPaths);
        }

        $sekretariat->update($data);

        return redirect()->route('admin.laporan-lpj.sekretariat.index')
                         ->with('OK', 'Kegiatan berhasil diperbarui.');
    }

    public function destroy(Sekretariat $sekretariat)
    {
        if ($sekretariat->foto_jurnal) {
            $fotos = json_decode($sekretariat->foto_jurnal, true);
            if (is_array($fotos)) {
                foreach ($fotos as $foto) {
                    Storage::disk('public')->delete($foto);
                }
            }
        }

        if ($sekretariat->dokumen_pendukung) {
            $dokumens = json_decode($sekretariat->dokumen_pendukung, true);
            if (is_array($dokumens)) {
                foreach ($dokumens as $dokumen) {
                    Storage::disk('public')->delete($dokumen);
                }
            }
        }

        $sekretariat->delete();
        return redirect()->route('admin.laporan-lpj.sekretariat.index')
                         ->with('OK', 'Kegiatan berhasil dihapus.');
    }
}
