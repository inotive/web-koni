<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KegiatanLainnya;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class KegiatanLainnyaController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $search = $request->input('search');
        $jenisKegiatanFilter = $request->input('jenis_kegiatan_filter');
        $sortBy = $request->input('sort', 'created_at');
        $sortDirection = $request->input('direction', 'desc');

        // PERBAIKAN: Pastikan jika tidak ada sorting custom, selalu gunakan created_at desc
        // untuk memastikan data terbaru selalu di atas
        if (!$request->has('sort')) {
            $sortBy = 'created_at';
            $sortDirection = 'desc';
        }

        $query = KegiatanLainnya::query();

        // Search
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->whereRaw('LOWER(nama_program_kegiatan) LIKE ?', ['%'.strtolower($search).'%'])
                  ->orWhereRaw('LOWER(jenis_kegiatan) LIKE ?', ['%'.strtolower($search).'%'])
                  ->orWhereRaw('LOWER(volume) LIKE ?', ['%'.strtolower($search).'%']);
            });
        }

        // Filter jenis kegiatan
        if ($jenisKegiatanFilter) {
            $query->where('jenis_kegiatan', $jenisKegiatanFilter);
        }

        // Sorting - PERBAIKAN: Tambahkan secondary sort untuk konsistensi
        $query->orderBy($sortBy, $sortDirection);
        
        // Tambahkan secondary sort berdasarkan created_at desc jika primary sort bukan created_at
        if ($sortBy !== 'created_at') {
            $query->orderBy('created_at', 'desc');
        }

        // Pagination
        $kegiatanLainnya = $query->paginate($perPage)->appends($request->query());

        return view('admin.laporan-lpj.kegiatan_lainnya.index', compact('kegiatanLainnya'));
    }

    public function create()
    {
        return view('admin.laporan-lpj.kegiatan_lainnya.create');
    }

    public function store(Request $request)
    {
        // Custom validation messages
        $messages = [
            'nama_program_kegiatan.required' => 'Nama Program & Kegiatan wajib diisi.',
            'nama_program_kegiatan.unique' => 'Nama Program & Kegiatan sudah terdaftar. Silakan gunakan nama yang berbeda.',
            'nama_program_kegiatan.max' => 'Nama Program & Kegiatan maksimal 255 karakter.',
            'jenis_kegiatan.required' => 'Jenis Kegiatan wajib diisi.',
            'jenis_kegiatan.max' => 'Jenis Kegiatan maksimal 255 karakter.',
            'volume.required' => 'Volume wajib diisi.',
            'volume.max' => 'Volume maksimal 255 karakter.',
            'jumlah_harga_satuan.required' => 'Jumlah Harga Satuan wajib diisi.',
            'jumlah_harga_satuan.numeric' => 'Jumlah Harga Satuan harus berupa angka.',
            'jumlah_harga_satuan.min' => 'Jumlah Harga Satuan tidak boleh kurang dari 0.',
            'jumlah_harga.required' => 'Jumlah Harga wajib diisi.',
            'jumlah_harga.numeric' => 'Jumlah Harga harus berupa angka.',
            'jumlah_harga.min' => 'Jumlah Harga tidak boleh kurang dari 0.',
            'foto_jurnal.required' => 'Foto Jurnal wajib diunggah.',
            'foto_jurnal.image' => 'File Foto Jurnal harus berupa gambar.',
            'foto_jurnal.mimes' => 'Format Foto Jurnal harus: JPEG, PNG, JPG, GIF, atau WebP.',
            'foto_jurnal.max' => 'Ukuran Foto Jurnal maksimal 10MB.',
            'dokumen_pendukung.file' => 'File Dokumen Pendukung tidak valid.',
            'dokumen_pendukung.mimes' => 'Format Dokumen Pendukung harus: PDF, DOC, DOCX, XLS, atau XLSX.',
            'dokumen_pendukung.max' => 'Ukuran Dokumen Pendukung maksimal 10MB.',
            'keterangan_tambahan.max' => 'Keterangan Tambahan maksimal 500 karakter.',
        ];

        // Validation with custom messages
        $validated = $request->validate([
            'nama_program_kegiatan' => [
                'required',
                'string',
                'max:255',
                Rule::unique('kegiatan_lainnya', 'nama_program_kegiatan')
            ],
            'jenis_kegiatan' => 'required|string|max:255',
            'volume' => 'required|string|max:255',
            'jumlah_harga_satuan' => 'required|numeric|min:0',
            'jumlah_harga' => 'required|numeric|min:0',
            'foto_jurnal' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'dokumen_pendukung' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
            'keterangan_tambahan' => 'nullable|string|max:500'
        ], $messages);

        // Check for duplicate combination of program name and jenis kegiatan
        $existingData = KegiatanLainnya::where('nama_program_kegiatan', $validated['nama_program_kegiatan'])
            ->where('jenis_kegiatan', $validated['jenis_kegiatan'])
            ->first();

        if ($existingData) {
            return back()->withInput()->withErrors([
                'nama_program_kegiatan' => 'Kombinasi Nama Program & Jenis Kegiatan ini sudah ada dalam database.',
                'jenis_kegiatan' => 'Kombinasi Nama Program & Jenis Kegiatan ini sudah ada dalam database.'
            ]);
        }

        DB::beginTransaction();
        try {
            // Handle file uploads with better error handling
            if ($request->hasFile('foto_jurnal')) {
                if (!$request->file('foto_jurnal')->isValid()) {
                    throw new \Exception('File foto jurnal tidak valid atau corrupt.');
                }
                
                $validated['foto_jurnal'] = $request->file('foto_jurnal')
                    ->store('kegiatan_lainnya/foto', 'public');
                
                if (!$validated['foto_jurnal']) {
                    throw new \Exception('Gagal mengunggah foto jurnal.');
                }
            }

            if ($request->hasFile('dokumen_pendukung')) {
                if (!$request->file('dokumen_pendukung')->isValid()) {
                    throw new \Exception('File dokumen pendukung tidak valid atau corrupt.');
                }
                
                $validated['dokumen_pendukung'] = $request->file('dokumen_pendukung')
                    ->store('kegiatan_lainnya/dokumen', 'public');
                
                if (!$validated['dokumen_pendukung']) {
                    throw new \Exception('Gagal mengunggah dokumen pendukung.');
                }
            }
            
            // Create the record
            $kegiatanLainnya = KegiatanLainnya::create($validated);
            
            if (!$kegiatanLainnya) {
                throw new \Exception('Gagal menyimpan data ke database.');
            }

            DB::commit();

            // PERBAIKAN: Redirect tanpa parameter sorting untuk memastikan data baru muncul di atas
            return redirect()->route('admin.laporan-lpj.kegiatan_lainnya.index')
                ->with('success', 'Data Kegiatan Lainnya berhasil ditambahkan!');

        } catch (\Exception $e) {
            DB::rollback();
            
            // Clean up uploaded files if any
            if (isset($validated['foto_jurnal']) && Storage::disk('public')->exists($validated['foto_jurnal'])) {
                Storage::disk('public')->delete($validated['foto_jurnal']);
            }
            if (isset($validated['dokumen_pendukung']) && Storage::disk('public')->exists($validated['dokumen_pendukung'])) {
                Storage::disk('public')->delete($validated['dokumen_pendukung']);
            }

            return redirect()->route('admin.laporan-lpj.kegiatan_lainnya.index', [
    'sort' => 'created_at',
    'direction' => 'desc'
])->with('success', 'Data Kegiatan Lainnya berhasil ditambahkan!');

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
        // Custom validation messages for update
        $messages = [
            'nama_program_kegiatan.required' => 'Nama Program & Kegiatan wajib diisi.',
            'nama_program_kegiatan.unique' => 'Nama Program & Kegiatan sudah terdaftar. Silakan gunakan nama yang berbeda.',
            'nama_program_kegiatan.max' => 'Nama Program & Kegiatan maksimal 255 karakter.',
            'jenis_kegiatan.required' => 'Jenis Kegiatan wajib diisi.',
            'jenis_kegiatan.max' => 'Jenis Kegiatan maksimal 255 karakter.',
            'volume.required' => 'Volume wajib diisi.',
            'volume.max' => 'Volume maksimal 255 karakter.',
            'jumlah_harga_satuan.required' => 'Jumlah Harga Satuan wajib diisi.',
            'jumlah_harga_satuan.numeric' => 'Jumlah Harga Satuan harus berupa angka.',
            'jumlah_harga_satuan.min' => 'Jumlah Harga Satuan tidak boleh kurang dari 0.',
            'jumlah_harga.required' => 'Jumlah Harga wajib diisi.',
            'jumlah_harga.numeric' => 'Jumlah Harga harus berupa angka.',
            'jumlah_harga.min' => 'Jumlah Harga tidak boleh kurang dari 0.',
            'foto_jurnal.image' => 'File Foto Jurnal harus berupa gambar.',
            'foto_jurnal.mimes' => 'Format Foto Jurnal harus: JPEG, PNG, JPG, GIF, atau WebP.',
            'foto_jurnal.max' => 'Ukuran Foto Jurnal maksimal 10MB.',
            'dokumen_pendukung.file' => 'File Dokumen Pendukung tidak valid.',
            'dokumen_pendukung.mimes' => 'Format Dokumen Pendukung harus: PDF, DOC, DOCX, XLS, atau XLSX.',
            'dokumen_pendukung.max' => 'Ukuran Dokumen Pendukung maksimal 10MB.',
            'keterangan_tambahan.max' => 'Keterangan Tambahan maksimal 500 karakter.',
        ];

        $validated = $request->validate([
            'nama_program_kegiatan' => [
                'required',
                'string',
                'max:255',
                Rule::unique('kegiatan_lainnya', 'nama_program_kegiatan')
                    ->ignore($kegiatan_lainnya->id)
            ],
            'jenis_kegiatan' => 'required|string|max:255',
            'volume' => 'required|string|max:255',
            'jumlah_harga_satuan' => 'required|numeric|min:0',
            'jumlah_harga' => 'required|numeric|min:0',
            'foto_jurnal' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'dokumen_pendukung' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
            'keterangan_tambahan' => 'nullable|string|max:500'
        ], $messages);

        // Check for duplicate combination (excluding current record)
        $existingData = KegiatanLainnya::where('nama_program_kegiatan', $validated['nama_program_kegiatan'])
            ->where('jenis_kegiatan', $validated['jenis_kegiatan'])
            ->where('id', '!=', $kegiatan_lainnya->id)
            ->first();

        if ($existingData) {
            return back()->withInput()->withErrors([
                'nama_program_kegiatan' => 'Kombinasi Nama Program & Jenis Kegiatan ini sudah ada dalam database.',
                'jenis_kegiatan' => 'Kombinasi Nama Program & Jenis Kegiatan ini sudah ada dalam database.'
            ]);
        }

        DB::beginTransaction();
        try {
            $oldFotoJurnal = $kegiatan_lainnya->foto_jurnal;
            $oldDokumenPendukung = $kegiatan_lainnya->dokumen_pendukung;

            // Handle foto jurnal upload
            if ($request->hasFile('foto_jurnal')) {
                if (!$request->file('foto_jurnal')->isValid()) {
                    throw new \Exception('File foto jurnal tidak valid atau corrupt.');
                }

                $validated['foto_jurnal'] = $request->file('foto_jurnal')
                    ->store('kegiatan_lainnya/foto', 'public');

                if (!$validated['foto_jurnal']) {
                    throw new \Exception('Gagal mengunggah foto jurnal baru.');
                }
            }

            // Handle dokumen pendukung upload
            if ($request->hasFile('dokumen_pendukung')) {
                if (!$request->file('dokumen_pendukung')->isValid()) {
                    throw new \Exception('File dokumen pendukung tidak valid atau corrupt.');
                }

                $validated['dokumen_pendukung'] = $request->file('dokumen_pendukung')
                    ->store('kegiatan_lainnya/dokumen', 'public');

                if (!$validated['dokumen_pendukung']) {
                    throw new \Exception('Gagal mengunggah dokumen pendukung baru.');
                }
            }

            // Update the record
            $updated = $kegiatan_lainnya->update($validated);
            
            if (!$updated) {
                throw new \Exception('Gagal memperbarui data di database.');
            }

            // Delete old files only after successful update
            if ($request->hasFile('foto_jurnal') && $oldFotoJurnal) {
                Storage::disk('public')->delete($oldFotoJurnal);
            }

            if ($request->hasFile('dokumen_pendukung') && $oldDokumenPendukung) {
                Storage::disk('public')->delete($oldDokumenPendukung);
            }

            DB::commit();

            return redirect()->route('admin.laporan-lpj.kegiatan_lainnya.index')
                ->with('success', 'Data Kegiatan Lainnya berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollback();

            // Clean up newly uploaded files if any
            if (isset($validated['foto_jurnal']) && $validated['foto_jurnal'] !== $oldFotoJurnal) {
                Storage::disk('public')->delete($validated['foto_jurnal']);
            }
            if (isset($validated['dokumen_pendukung']) && $validated['dokumen_pendukung'] !== $oldDokumenPendukung) {
                Storage::disk('public')->delete($validated['dokumen_pendukung']);
            }

            return back()->withInput()
                ->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    public function destroy(KegiatanLainnya $kegiatan_lainnya)
    {
        DB::beginTransaction();
        try {
            // Store file paths before deletion
            $fotoJurnal = $kegiatan_lainnya->foto_jurnal;
            $dokumenPendukung = $kegiatan_lainnya->dokumen_pendukung;

            // Delete the record first
            $deleted = $kegiatan_lainnya->delete();
            
            if (!$deleted) {
                throw new \Exception('Gagal menghapus data dari database.');
            }

            // Delete associated files only after successful database deletion
            if ($fotoJurnal && Storage::disk('public')->exists($fotoJurnal)) {
                Storage::disk('public')->delete($fotoJurnal);
            }

            if ($dokumenPendukung && Storage::disk('public')->exists($dokumenPendukung)) {
                Storage::disk('public')->delete($dokumenPendukung);
            }

            DB::commit();

            return redirect()->route('admin.laporan-lpj.kegiatan_lainnya.index')
                ->with('success', 'Data Kegiatan Lainnya berhasil dihapus!');

        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->route('admin.laporan-lpj.kegiatan_lainnya.index')
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    public function export(Request $request)
{
    try {
        $query = KegiatanLainnya::query();
        
        // Filter pencarian
        if ($request->has('search') && !empty($request->input('search'))) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->whereRaw('LOWER(nama_program_kegiatan) LIKE ?', ['%'.strtolower($search).'%'])
                  ->orWhereRaw('LOWER(jenis_kegiatan) LIKE ?', ['%'.strtolower($search).'%'])
                  ->orWhereRaw('LOWER(volume) LIKE ?', ['%'.strtolower($search).'%']);
            });
        }

        // Filter jenis kegiatan
        if ($request->has('jenis_kegiatan_filter') && !empty($request->input('jenis_kegiatan_filter'))) {
            $query->where('jenis_kegiatan', $request->input('jenis_kegiatan_filter'));
        }

        // Pastikan ada data sebelum export
        $data = $query->orderBy('created_at', 'desc')->get();

        // Jika tidak ada data, kembalikan response dengan pesan
        if ($data->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada data untuk di-export');
        }

        // Pastikan view export ada
        $viewPath = 'admin.laporan-lpj.kegiatan_lainnya.export';
        if (!view()->exists($viewPath)) {
            return redirect()->back()->with('error', 'Template export tidak ditemukan');
        }

        $filename = 'LPJ_Kegiatan_Lainnya_' . now()->format('Ymd_His') . '.pdf';

        // Gunakan try-catch untuk PDF generation
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView($viewPath, [
            'data' => $data,
            'title' => 'Laporan Pertanggungjawaban Kegiatan Lainnya'
        ]);

        return $pdf->download($filename);

    } catch (\Exception $e) {
        Log::error('Export Error: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Gagal mengexport data: ' . $e->getMessage());
    }
}
}