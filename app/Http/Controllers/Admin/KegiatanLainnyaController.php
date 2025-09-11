<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lpj;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str; // Tambahkan ini

class KegiatanLainnyaController extends Controller
{
    // Konstanta untuk mengidentifikasi jenis kegiatan kegiatan-lainnya
    const PARENT_CATEGORY = 'kegiatan-lainnya';

    public function index(Request $request)
{
    // Cari atau buat parent kategori kegiatan-lainnya
    $parentCategory = $this->getOrCreateParentCategory();

    $query = Lpj::where('parent_id', $parentCategory->id);

    // Filter berdasarkan jenis kegiatan
    if ($request->jenis_kegiatan_filter) {
        $query->where('nama_kegiatan', 'like', "%{$request->jenis_kegiatan_filter}%");
    }
    
    // Filter berdasarkan tanggal
    if ($request->start_date) {
        $query->whereDate('created_at', '>=', $request->start_date);
    }
    if ($request->end_date) {
        $query->whereDate('created_at', '<=', $request->end_date);
    }
    
    // Filter berdasarkan pencarian
    if ($request->search) {
        $query->where(function($q) use ($request) {
            $q->where('nama_program', 'like', "%{$request->search}%")
              ->orWhere('nama_kegiatan', 'like', "%{$request->search}%");
        });
    }

    // Hitung total kegiatan dan total anggaran SEBELUM pagination berdasarkan filter yang diterapkan
    $totalKegiatan = (clone $query)->count();
    $totalAnggaran = (clone $query)->sum('jumlah_harga');

    // Sorting
    $allowedSorts = ['nama_program', 'nama_kegiatan', 'volume', 'jumlah_harga_satuan', 'jumlah_harga', 'created_at'];
    $sort = $request->get('sort_by', 'created_at');
    $direction = $request->get('sort_order', 'desc');

    if (!in_array($sort, $allowedSorts)) {
        $sort = 'created_at';
    }
    if (!in_array($direction, ['asc', 'desc'])) {
        $direction = 'desc';
    }

    $kegiatanLainnya = $query
        ->orderBy($sort, $direction)
        ->paginate($request->get('per_page', 10))
        ->appends($request->except('page'));

    // Untuk AJAX request (filtering/searching), return partial view dengan data summary
    if ($request->ajax()) {
        return view('admin.laporan-lpj.kegiatan-lainnya._table', compact('kegiatanLainnya', 'totalKegiatan', 'totalAnggaran'))->render();
    }

    // Untuk request biasa, return full view dengan data summary
    return view('admin.laporan-lpj.kegiatan-lainnya.index', compact('kegiatanLainnya', 'totalKegiatan', 'totalAnggaran'));
}

    public function create()
    {
        return view('admin.laporan-lpj.kegiatan-lainnya.create');
    }

    public function store(Request $request)
    {
        // Custom validation for numeric fields
        $request->validate([
            'nama_program_kegiatan' => 'required|string|max:255',
            'jenis_kegiatan' => 'required|string|max:255',
            'keterangan_tambahan' => 'nullable|string',
            'volume' => 'nullable|string|max:255',
            'jumlah_harga_satuan' => 'nullable|string',
            'jumlah_harga' => 'required|string',
            'foto_jurnal' => 'required|array',
            'foto_jurnal.*' => 'image|mimes:jpeg,png,jpg,gif|max:10240',
            'dokumen_lpj' => 'nullable|array|max:10',
            'dokumen_lpj.*' => 'file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
            'dokumen_lpj_pdf' => 'nullable|array',
            'dokumen_lpj_pdf.*' => 'file|mimes:pdf|max:10240',
        ], [
            'foto_jurnal.required' => 'Foto jurnal wajib diisi.',
            'foto_jurnal.min' => 'Minimal 1 foto jurnal harus diunggah.',
            'foto_jurnal.*.image' => 'File harus berupa gambar.',
            'foto_jurnal.*.mimes' => 'Format foto harus: jpeg, png, jpg, gif.',
            'foto_jurnal.*.max' => 'Ukuran foto maksimal 10MB.',
            'dokumen_lpj.max' => 'Maksimal 10 dokumen yang dapat diunggah.',
            'dokumen_lpj.*.file' => 'File dokumen tidak valid.',
            'dokumen_lpj.*.mimes' => 'Format dokumen harus: pdf, doc, docx, xls, xlsx.',
            'dokumen_lpj.*.max' => 'Ukuran dokumen maksimal 10MB.',
            'dokumen_lpj_pdf.*.file' => 'File dokumen LPJ tidak valid.',
            'dokumen_lpj_pdf.*.mimes' => 'Format dokumen LPJ harus PDF.',
            'dokumen_lpj_pdf.*.max' => 'Ukuran dokumen LPJ maksimal 10MB.',
        ]);
        
        // Parse numeric values
        $jumlahHargaSatuan = $this->parseNumber($request->jumlah_harga_satuan);
        $jumlahHarga = $this->parseNumber($request->jumlah_harga);

        // Validate numeric values
        if ($jumlahHargaSatuan < 0) {
            return back()->withErrors(['jumlah_harga_satuan' => 'Jumlah harga satuan tidak boleh negatif.'])->withInput();
        }
        
        if ($jumlahHarga < 0) {
            return back()->withErrors(['jumlah_harga' => 'Jumlah harga tidak boleh negatif.'])->withInput();
        }

        // Cari atau buat parent kategori
        $parentCategory = $this->getOrCreateParentCategory();

        $data = [
            'parent_id' => $parentCategory->id,
            'nama_program' => $request->nama_program_kegiatan, // Map ke nama_program
            'nama_kegiatan' => $request->jenis_kegiatan, // Map ke nama_kegiatan
            'volume' => $request->volume ?? '', // Default ke string kosong jika null
            'jumlah_harga_satuan' => $jumlahHargaSatuan ?? 0, // Default ke 0 jika null
            'jumlah_harga' => $jumlahHarga,
            'keterangan_tambahan' => $request->keterangan_tambahan,
            'icon' => 'fas fa-clipboard-list' // Default icon untuk kegiatan-lainnya
        ];

        if ($request->hasFile('foto_jurnal')) {
            $fotoPaths = [];
            foreach ($request->file('foto_jurnal') as $file) {
                // Simpan dengan nama file asli
                $originalName = $file->getClientOriginalName();
                $fotoPaths[] = $file->storeAs('kegiatan-lainnya/foto_jurnal', $originalName, 'public');
            }
            $data['foto_jurnal'] = $fotoPaths;
        }

        if ($request->hasFile('dokumen_lpj')) {
            $dokumenPaths = [];
            foreach ($request->file('dokumen_lpj') as $file) {
                // Simpan dengan nama file asli
                $originalName = $file->getClientOriginalName();
                $dokumenPaths[] = $file->storeAs('kegiatan-lainnya/dokumen_pendukung', $originalName, 'public');
            }
            $data['dokumen_lpj'] = $dokumenPaths; // Map ke dokumen_lpj
        }

        // Handle dokumen_lpj_pdf uploads
        if ($request->hasFile('dokumen_lpj_pdf')) {
            $dokumenLpjPdfPaths = [];
            foreach ($request->file('dokumen_lpj_pdf') as $file) {
                // Simpan dengan nama file asli
                $originalName = $file->getClientOriginalName();
                $dokumenLpjPdfPaths[] = $file->storeAs('kegiatan-lainnya/dokumen_lpj_pdf', $originalName, 'public');
            }
            $data['dokumen_lpj_pdf'] = $dokumenLpjPdfPaths;
        }

        Lpj::create($data);

        return redirect()->route('admin.laporan-lpj.kegiatan-lainnya.index')
                         ->with('OK', 'Kegiatan berhasil ditambahkan.');
    }

    public function show($id)
{
    $kegiatanLainnya = Lpj::where('parent_id', $this->getOrCreateParentCategory()->id)
                      ->findOrFail($id);
    return view('admin.laporan-lpj.kegiatan-lainnya.show', compact('kegiatanLainnya'));
}

    public function edit($id)
    {
        if (!auth()->user()->hasRole('superadmin')) {
            abort(403, 'Akses ditolak. Hanya superadmin yang dapat mengedit data.');
        }

        $kegiatanLainnya = Lpj::where('parent_id', $this->getOrCreateParentCategory()->id)
                          ->findOrFail($id);
        return view('admin.laporan-lpj.kegiatan-lainnya.edit', compact('kegiatanLainnya'));
    }

    public function update(Request $request, $id)
    {
        if (!auth()->user()->hasRole('superadmin')) {
            abort(403, 'Akses ditolak. Hanya superadmin yang dapat memperbarui data.');
        }

        $kegiatanLainnya = Lpj::where('parent_id', $this->getOrCreateParentCategory()->id)
                          ->findOrFail($id);

        // Custom validation for numeric fields
        $request->validate([
            'nama_program_kegiatan' => 'required|string|max:255',
            'jenis_kegiatan' => 'required|string|max:255',
            'keterangan_tambahan' => 'nullable|string',
            'volume' => 'nullable|string|max:255',
            'jumlah_harga_satuan' => 'nullable|string',
            'jumlah_harga' => 'required|string',
            'foto_jurnal' => 'nullable|array',
            'foto_jurnal.*' => 'image|mimes:jpeg,png,jpg,gif|max:10240',
            'dokumen_lpj' => 'nullable|array|max:10',
            'dokumen_lpj.*' => 'file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
            'dokumen_lpj_pdf' => 'nullable|array',
            'dokumen_lpj_pdf.*' => 'file|mimes:pdf|max:10240',
            'existing_foto_jurnal' => 'nullable|array',
            'existing_dokumen_lpj' => 'nullable|array',
            'existing_dokumen_lpj_pdf' => 'nullable|array',
        ], [
            'foto_jurnal.*.image' => 'File harus berupa gambar.',
            'foto_jurnal.*.mimes' => 'Format foto harus: jpeg, png, jpg, gif.',
            'foto_jurnal.*.max' => 'Ukuran foto maksimal 10MB.',
            'dokumen_lpj.max' => 'Maksimal 10 dokumen yang dapat diunggah.',
            'dokumen_lpj.*.file' => 'File dokumen tidak valid.',
            'dokumen_lpj.*.mimes' => 'Format dokumen harus: pdf, doc, docx, xls, xlsx.',
            'dokumen_lpj.*.max' => 'Ukuran dokumen maksimal 10MB.',
            'dokumen_lpj_pdf.*.file' => 'File dokumen LPJ tidak valid.',
            'dokumen_lpj_pdf.*.mimes' => 'Format dokumen LPJ harus PDF.',
            'dokumen_lpj_pdf.*.max' => 'Ukuran dokumen LPJ maksimal 10MB.',
        ]);
        
        // Validasi tambahan: jika tidak ada foto lama dan tidak ada foto baru diunggah
        // Diabaikan karena kita mengizinkan user mengupload foto tanpa batasan jumlah
        
        // Parse numeric values
        $jumlahHargaSatuan = $this->parseNumber($request->jumlah_harga_satuan);
        $jumlahHarga = $this->parseNumber($request->jumlah_harga);

        // Validate numeric values
        if ($jumlahHargaSatuan < 0) {
            return back()->withErrors(['jumlah_harga_satuan' => 'Jumlah harga satuan tidak boleh negatif.'])->withInput();
        }
        
        if ($jumlahHarga < 0) {
            return back()->withErrors(['jumlah_harga' => 'Jumlah harga tidak boleh negatif.'])->withInput();
        }

        // Handle existing files
        $existingFotoJurnal = $request->input('existing_foto_jurnal', []);
        $existingDokumenLpj = $request->input('existing_dokumen_lpj', []);
        $existingDokumenLpjPdf = $request->input('existing_dokumen_lpj_pdf', []);

        // Delete removed foto_jurnal files
        if ($kegiatanLainnya->foto_jurnal) {
            foreach ($kegiatanLainnya->foto_jurnal as $oldFoto) {
                if (!in_array($oldFoto, $existingFotoJurnal)) {
                    Storage::disk('public')->delete($oldFoto);
                }
            }
        }

        // Delete removed dokumen_lpj files
        if ($kegiatanLainnya->dokumen_lpj) {
            foreach ($kegiatanLainnya->dokumen_lpj as $oldDokumen) {
                if (!in_array($oldDokumen, $existingDokumenLpj)) {
                    Storage::disk('public')->delete($oldDokumen);
                }
            }
        }

        // Delete removed dokumen_lpj_pdf files
        if ($kegiatanLainnya->dokumen_lpj_pdf) {
            foreach ($kegiatanLainnya->dokumen_lpj_pdf as $oldDokumen) {
                if (!in_array($oldDokumen, $existingDokumenLpjPdf)) {
                    Storage::disk('public')->delete($oldDokumen);
                }
            }
        }

        // Handle new file uploads
        $newFotoJurnal = [];
        if ($request->hasFile('foto_jurnal')) {
            foreach ($request->file('foto_jurnal') as $file) {
                $originalName = $file->getClientOriginalName();
                $newFotoJurnal[] = $file->storeAs('kegiatan-lainnya/foto_jurnal', $originalName, 'public');
            }
        }

        $newDokumenLpj = [];
        if ($request->hasFile('dokumen_lpj')) {
            foreach ($request->file('dokumen_lpj') as $file) {
                $originalName = $file->getClientOriginalName();
                $newDokumenLpj[] = $file->storeAs('kegiatan-lainnya/dokumen_pendukung', $originalName, 'public');
            }
        }

        $newDokumenLpjPdf = [];
        if ($request->hasFile('dokumen_lpj_pdf')) {
            foreach ($request->file('dokumen_lpj_pdf') as $file) {
                $originalName = $file->getClientOriginalName();
                $newDokumenLpjPdf[] = $file->storeAs('kegiatan-lainnya/dokumen_lpj_pdf', $originalName, 'public');
            }
        }

        // Merge existing and new files
        $allFotoJurnal = array_merge($existingFotoJurnal, $newFotoJurnal);
        $allDokumenLpj = array_merge($existingDokumenLpj, $newDokumenLpj);
        $allDokumenLpjPdf = array_merge($existingDokumenLpjPdf, $newDokumenLpjPdf);

        $data = [
            'nama_program' => $request->nama_program_kegiatan,
            'nama_kegiatan' => $request->jenis_kegiatan,
            'volume' => $request->volume ?? '', // Default ke string kosong jika null
            'jumlah_harga_satuan' => $jumlahHargaSatuan ?? 0, // Default ke 0 jika null
            'jumlah_harga' => $jumlahHarga,
            'keterangan_tambahan' => $request->keterangan_tambahan,
            'foto_jurnal' => $allFotoJurnal,
            'dokumen_lpj' => $allDokumenLpj,
            'dokumen_lpj_pdf' => $allDokumenLpjPdf
        ];

        $kegiatanLainnya->update($data);

        return redirect()->route('admin.laporan-lpj.kegiatan-lainnya.index')
                         ->with('OK', 'Kegiatan berhasil diperbarui.');
    }

    public function destroy($id)
{
    if (!auth()->user()->hasRole('superadmin')) {
        return response()->json(['error' => 'Akses ditolak'], 403);
    }

    try {
        $kegiatanLainnya = Lpj::where('parent_id', $this->getOrCreateParentCategory()->id)
                          ->findOrFail($id);

        // Hapus file foto_jurnal
        if ($kegiatanLainnya->foto_jurnal) {
            foreach ($kegiatanLainnya->foto_jurnal as $foto) {
                Storage::disk('public')->delete($foto);
            }
        }

        // Hapus file dokumen_lpj
        if ($kegiatanLainnya->dokumen_lpj) {
            foreach ($kegiatanLainnya->dokumen_lpj as $dokumen) {
                Storage::disk('public')->delete($dokumen);
            }
        }

        // Hapus file dokumen_lpj_pdf
        if ($kegiatanLainnya->dokumen_lpj_pdf) {
            foreach ($kegiatanLainnya->dokumen_lpj_pdf as $dokumen) {
                Storage::disk('public')->delete($dokumen);
            }
        }

        $kegiatanLainnya->delete();

        // Return JSON response untuk AJAX
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Kegiatan berhasil dihapus.'
            ]);
        }

        return redirect()->route('admin.laporan-lpj.kegiatan-lainnya.index')
                         ->with('OK', 'Kegiatan berhasil dihapus.');
                         
    } catch (\Exception $e) {
        if (request()->ajax()) {
            return response()->json([
                'error' => true,
                'message' => 'Gagal menghapus kegiatan: ' . $e->getMessage()
            ], 500);
        }

        return back()->with('error', 'Gagal menghapus kegiatan.');
    }
}

    public function removeFile(Request $request, $id)
    {
        if (!auth()->user()->hasRole('superadmin')) {
            return response()->json(['error' => 'Akses ditolak'], 403);
        }

        $kegiatanLainnya = Lpj::where('parent_id', $this->getOrCreateParentCategory()->id)
                          ->findOrFail($id);

        $request->validate([
            'file_type' => 'required|in:foto_jurnal,dokumen_lpj,dokumen_lpj_pdf',
            'file_index' => 'required|integer|min:0'
        ]);

        $fileType = $request->file_type;
        $fileIndex = $request->file_index;
        $files = $kegiatanLainnya->$fileType ?? [];

        if (!isset($files[$fileIndex])) {
            return response()->json(['error' => 'File tidak ditemukan'], 404);
        }

        $filePath = $files[$fileIndex];
        Storage::disk('public')->delete($filePath);

        unset($files[$fileIndex]);
        $files = array_values($files);

        $kegiatanLainnya->update([$fileType => $files]);

        return response()->json([
            'success' => true,
            'message' => 'File berhasil dihapus',
            'remaining_files' => count($files)
        ]);
    }

    /**
     * Parse number from formatted string
     */
    private function parseNumber($value)
    {
        if (is_null($value)) {
            return 0;
        }
        
        // Remove non-numeric characters except decimal point
        $numericValue = preg_replace('/[^\d.]/', '', $value);
        
        // Convert to float
        return floatval($numericValue);
    }

    /**
     * Mendapatkan atau membuat parent kategori untuk kegiatan-lainnya
     */
    private function getOrCreateParentCategory()
    {
        return Lpj::firstOrCreate(
            ['parent_id' => null, 'nama_program' => self::PARENT_CATEGORY],
            [
                'nama_kegiatan' => 'Kategori ' . self::PARENT_CATEGORY,
                'volume' => '',
                'jumlah_harga_satuan' => 0,
                'jumlah_harga' => 0,
                'icon' => 'fas fa-building'
            ]
        );
    }

    public function approve(Request $request, $id)
{
    if (!auth()->user()->hasRole('superadmin')) {
        return response()->json(['error' => 'Akses ditolak. Hanya superadmin yang dapat menyetujui data.'], 403);
    }

    try {
        $kegiatanLainnya = Lpj::where('parent_id', $this->getOrCreateParentCategory()->id)
                          ->findOrFail($id);

        // Update status approval
        $kegiatanLainnya->update([
            'is_approved' => true,
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'catatan_approval' => $request->catatan_approval ?? null
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kegiatan berhasil disetujui.'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'error' => true,
            'message' => 'Gagal menyetujui kegiatan: ' . $e->getMessage()
        ], 500);
    }
}

public function exportDetail($id)
{
    try {
        \Log::info('Exporting kegiatan lainnya LPJ with ID: ' . $id);
        
        $kegiatanLainnya = Lpj::where('parent_id', $this->getOrCreateParentCategory()->id)
                              ->findOrFail($id);

        // Data untuk ditampilkan di PDF
        $data = [
            'kegiatanLainnya' => $kegiatanLainnya,
        ];

        // Generate PDF menggunakan DomPDF
        $pdf = Pdf::loadView('admin.laporan-lpj.kegiatan-lainnya.export', $data)
                  ->setPaper('a4', 'portrait');

        // Nama file PDF
        $fileName = 'Laporan_Kegiatan_Lainnya_' . Str::slug($kegiatanLainnya->nama_program) . '.pdf';

        \Log::info('Successfully generated PDF for kegiatan lainnya LPJ: ' . $fileName);
        return $pdf->download($fileName);
    } catch (\Exception $e) {
        // Log error
        \Log::error('Error exporting PDF: ' . $e->getMessage() . ' in ' . $e->getFile() . ' on line ' . $e->getLine());
        
        // Return error response with redirect
        return redirect()->back()->with('error', 'Terjadi kesalahan saat mengekspor laporan. Silakan coba lagi.');
    }
}
}
