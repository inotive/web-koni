<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SumberDaya;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SumberdayaController extends Controller
{
    public function index(Request $request)
    {
        $query = SumberDaya::query();

        // Apply filters
        if ($request->jenis_kegiatan_filter) {
            $query->where('nama_kegiatan', 'like', "%{$request->jenis_kegiatan_filter}%");
        }
        if ($request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('nama_program', 'like', "%{$request->search}%")
                  ->orWhere('nama_kegiatan', 'like', "%{$request->search}%");
            });
        }

        // Handle sorting
        $allowedSorts = ['nama_program', 'nama_kegiatan', 'volume', 'jumlah_harga_satuan', 'jumlah_harga', 'created_at'];
        $sort = $request->get('sort', 'created_at');
        $direction = $request->get('direction', 'desc');

        if (!in_array($sort, $allowedSorts)) {
            $sort = 'created_at';
        }
        if (!in_array($direction, ['asc', 'desc'])) {
            $direction = 'desc';
        }

        $sumberDayaData = $query
            ->orderBy($sort, $direction)
            ->paginate($request->get('per_page', 10));

        // If AJAX request, return table partial
        if ($request->ajax()) {
            return view('admin.laporan-lpj.bidang.mobilisasi-sumberdaya.table', compact('sumberDayaData'))->render();
        }

        return view('admin.laporan-lpj.bidang.mobilisasi-sumberdaya.index', compact('sumberDayaData'));
    }

    public function create()
    {
        return view('admin.laporan-lpj.bidang.mobilisasi-sumberdaya.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_program' => 'required|string|max:255',
            'nama_kegiatan' => 'required|string|max:255',
            'volume' => 'required|string|max:255',
            'jumlah_harga_satuan' => 'required|numeric|min:0',
            'jumlah_harga' => 'required|numeric|min:0',
            'keterangan_tambahan' => 'nullable|string',
            'foto_jurnal' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'dokumen_lpj' => 'nullable|array',
            'dokumen_lpj.*' => 'file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
        ]);

        $data = $request->only([
            'nama_program',
            'nama_kegiatan',
            'volume',
            'jumlah_harga_satuan',
            'jumlah_harga',
            'keterangan_tambahan'
        ]);

        // Handle foto_jurnal upload
        if ($request->hasFile('foto_jurnal')) {
            $fotoPath = $request->file('foto_jurnal')->store('sumber_daya/foto_jurnal', 'public');
            $data['foto_jurnal'] = [$fotoPath]; // Store as array
        }

        // Handle dokumen_lpj uploads
        if ($request->hasFile('dokumen_lpj')) {
            $dokumenPaths = [];
            foreach ($request->file('dokumen_lpj') as $file) {
                $dokumenPaths[] = $file->store('sumber_daya/dokumen_lpj', 'public');
            }
            $data['dokumen_lpj'] = $dokumenPaths;
        }

        SumberDaya::create($data);

        return redirect()->route('admin.laporan-lpj.bidang.mobilisasi-sumberdaya.index')
                         ->with('success', 'Data sumber daya berhasil ditambahkan.');
    }

    public function show(SumberDaya $sumberdaya)
    {
        return view('admin.laporan-lpj.bidang.mobilisasi-sumberdaya.show', compact('sumberdaya'));
    }

    public function edit(SumberDaya $sumberdaya)
    {
        return view('admin.laporan-lpj.bidang.mobilisasi-sumberdaya.edit', compact('sumberdaya'));
    }

    public function update(Request $request, SumberDaya $sumberdaya)
    {
        $request->validate([
            'nama_program' => 'required|string|max:255',
            'nama_kegiatan' => 'required|string|max:255',
            'volume' => 'required|string|max:255',
            'jumlah_harga_satuan' => 'required|numeric|min:0',
            'jumlah_harga' => 'required|numeric|min:0',
            'keterangan_tambahan' => 'nullable|string',
            'foto_jurnal' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'dokumen_lpj' => 'nullable|array',
            'dokumen_lpj.*' => 'file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
        ]);

        $data = $request->only([
            'nama_program',
            'nama_kegiatan',
            'volume',
            'jumlah_harga_satuan',
            'jumlah_harga',
            'keterangan_tambahan'
        ]);

        // Handle foto_jurnal upload
        if ($request->hasFile('foto_jurnal')) {
            // Delete old foto if exists
            if ($sumberdaya->foto_jurnal) {
                foreach ($sumberdaya->foto_jurnal as $oldFoto) {
                    Storage::disk('public')->delete($oldFoto);
                }
            }

            $fotoPath = $request->file('foto_jurnal')->store('sumber_daya/foto_jurnal', 'public');
            $data['foto_jurnal'] = [$fotoPath];
        }

        // Handle dokumen_lpj uploads
        if ($request->hasFile('dokumen_lpj')) {
            // Delete old documents if exists
            if ($sumberdaya->dokumen_lpj) {
                foreach ($sumberdaya->dokumen_lpj as $oldDokumen) {
                    Storage::disk('public')->delete($oldDokumen);
                }
            }

            $dokumenPaths = [];
            foreach ($request->file('dokumen_lpj') as $file) {
                $dokumenPaths[] = $file->store('sumber_daya/dokumen_lpj', 'public');
            }
            $data['dokumen_lpj'] = $dokumenPaths;
        }

        $sumberdaya->update($data);

        return redirect()->route('admin.laporan-lpj.bidang.mobilisasi-sumberdaya.index')
                         ->with('success', 'Data sumber daya berhasil diperbarui.');
    }

    public function destroy(SumberDaya $sumberdaya)
    {
        // Delete associated files
        if ($sumberdaya->foto_jurnal) {
            foreach ($sumberdaya->foto_jurnal as $foto) {
                Storage::disk('public')->delete($foto);
            }
        }

        if ($sumberdaya->dokumen_lpj) {
            foreach ($sumberdaya->dokumen_lpj as $dokumen) {
                Storage::disk('public')->delete($dokumen);
            }
        }

        $sumberdaya->delete();

        return redirect()->route('admin.laporan-lpj.bidang.mobilisasi-sumberdaya.index')
                         ->with('success', 'Data sumber daya berhasil dihapus.');
    }

    /**
     * Generate sort URL helper
     */
    private function sortUrl($column)
    {
        $direction = request()->get('direction', 'asc');
        $newDirection = (request()->get('sort') == $column && $direction == 'asc') ? 'desc' : 'asc';

        return request()->fullUrlWithQuery([
            'sort' => $column,
            'direction' => $newDirection
        ]);
    }
}
