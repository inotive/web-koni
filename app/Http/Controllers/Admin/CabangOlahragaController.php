<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CabangOlahraga;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class CabangOlahragaController extends Controller
{
    public function index(Request $request)
    {
        // Tambahkan eager loading untuk menghindari N+1 query problem
        $query = CabangOlahraga::with(['atlets', 'pelatihs']);

        // Search functionality
        if ($search = $request->input('search')) {
            $query->where('nama_cabor', 'like', '%' . $search . '%')
                ->orWhere('ketua_penanggung_jawab', 'like', '%' . $search . '%');
        }

        // Status filter
        if ($status = $request->input('filter_status')) {
            $query->where('status', $status);
        }

        // Sorting
        if ($sortBy = $request->input('sort_by')) {
            $order = $request->input('order', 'asc');
            $query->orderBy($sortBy, $order);
        } else {
            $query->orderBy('terakhir_update', 'desc');
        }

        // PERBAIKAN: Ubah parameter dari 'perPage' ke 'per_page' 
        // untuk konsisten dengan form di view
        $perPage = $request->get('per_page', 10);

        // Pastikan perPage adalah integer dan dalam range yang valid
        $perPage = (int) $perPage;
        if (!in_array($perPage, [10, 25, 50, 100])) {
            $perPage = 10;
        }

        /** @var \Illuminate\Contracts\Pagination\LengthAwarePaginator $cabors */
        $cabors = $query->paginate($perPage)->appends($request->query());

        return view('admin.cabang-olahraga.index', compact('cabors'));
    }

    public function create()
    {
        return view('admin.cabang-olahraga.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_cabor' => 'required|string|max:50',
            'ketua_penanggung_jawab' => 'required|string|max:100',
            'status' => 'required|in:Aktif,Tidak Aktif',
            'tanggal_pembentukan' => 'required|date',
            'icon_cabor' => 'nullable|file|mimes:png,webp,svg|max:2048',
        ], [
            'icon_cabor.mimes' => 'Ikon cabang olahraga harus berupa file PNG, WebP, atau SVG.',
            'icon_cabor.max' => 'Ukuran file ikon tidak boleh lebih dari 2MB.',
        ]);

        if ($request->hasFile('icon_cabor')) {
            $path = $this->handleIconUpload($request->file('icon_cabor'));
            $validatedData['icon_cabor'] = $path;
        }

        $validatedData['terakhir_update'] = now();

        CabangOlahraga::create($validatedData);

        return redirect()->route('admin.konfigurasi.cabang-olahraga.index')
            ->with('cabor_created', 'Cabang olahraga berhasil ditambahkan.');
    }

    public function show($id)
    {
        $cabor = CabangOlahraga::with(['atlets', 'pelatihs'])->findOrFail($id);
        return view('admin.cabang-olahraga.show', compact('cabor'));
    }

    public function edit($id)
    {
        $cabor = CabangOlahraga::findOrFail($id);
        return view('admin.cabang-olahraga.edit', compact('cabor'));
    }

    public function update(Request $request, $id)
    {
        $cabor = CabangOlahraga::findOrFail($id);

        $validatedData = $request->validate([
            'nama_cabor' => 'required|string|max:50',
            'ketua_penanggung_jawab' => 'required|string|max:100',
            'status' => 'required|in:Aktif,Tidak Aktif',
            'tanggal_pembentukan' => 'required|date',
            'icon_cabor' => 'nullable|file|mimes:png,webp,svg|max:2048',
        ], [
            'icon_cabor.mimes' => 'Ikon cabang olahraga harus berupa file PNG, WebP, atau SVG.',
            'icon_cabor.max' => 'Ukuran file ikon tidak boleh lebih dari 2MB.',
        ]);

        if ($request->hasFile('icon_cabor')) {
            // Hapus icon lama jika ada
            if ($cabor->icon_cabor) {
                Storage::disk('public')->delete($cabor->icon_cabor);
            }

            $path = $this->handleIconUpload($request->file('icon_cabor'));
            $validatedData['icon_cabor'] = $path;
        }

        $validatedData['terakhir_update'] = now();

        $cabor->update($validatedData);

        return redirect()->route('admin.konfigurasi.cabang-olahraga.index')
            ->with('cabor_updated', 'Cabang olahraga berhasil diperbarui.');
    }

    public function destroy($id)
    {
        try {
            $cabor = CabangOlahraga::with(['atlets', 'pelatihs'])->findOrFail($id);
            
            // Cek apakah masih ada atlet yang terkait
            $jumlahAtlet = $cabor->atlets()->count();
            $jumlahPelatih = $cabor->pelatihs()->count();
            $totalData = $jumlahAtlet + $jumlahPelatih;
            
            if ($totalData > 0) {
                $pesanError = "Tidak dapat menghapus cabang olahraga '{$cabor->nama_cabor}' karena masih ada data terkait:";
                
                if ($jumlahAtlet > 0) {
                    $pesanError .= " {$jumlahAtlet} atlet";
                }
                
                if ($jumlahPelatih > 0) {
                    if ($jumlahAtlet > 0) {
                        $pesanError .= " dan {$jumlahPelatih} pelatih";
                    } else {
                        $pesanError .= " {$jumlahPelatih} pelatih";
                    }
                }
                
                $pesanError .= " yang terdaftar. Silakan pindahkan atau hapus data tersebut terlebih dahulu, atau nonaktifkan cabang olahraga ini.";
                
                return redirect()->back()->with('error', $pesanError);
            }
            
            // Jika tidak ada data terkait, lanjutkan penghapusan
            if ($cabor->icon_cabor) {
                Storage::disk('public')->delete($cabor->icon_cabor);
            }
            
            $cabor->delete();
            
            return redirect()->route('admin.konfigurasi.cabang-olahraga.index')
                ->with('cabor_deleted', 'Cabang olahraga berhasil dihapus.');
                
        } catch (\Illuminate\Database\QueryException $e) {
            // Tangkap error foreign key constraint dari database
            if ($e->getCode() == '23000') {
                return redirect()->back()->with('error', 
                    'Tidak dapat menghapus cabang olahraga ini karena masih ada data terkait. Silakan hapus data terkait terlebih dahulu.'
                );
            }
            
            return redirect()->back()->with('error', 'Gagal menghapus cabang olahraga: ' . $e->getMessage());
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus: ' . $e->getMessage());
        }
    }

    // Method baru untuk nonaktifkan cabor (sebagai alternatif)
    public function deactivate($id)
    {
        try {
            $cabor = CabangOlahraga::findOrFail($id);
            
            $cabor->update([
                'status' => 'Tidak Aktif',
                'terakhir_update' => now()
            ]);
            
            return redirect()->route('admin.konfigurasi.cabang-olahraga.index')
                ->with('cabor_updated', "Cabang olahraga '{$cabor->nama_cabor}' berhasil dinonaktifkan.");
                
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menonaktifkan cabang olahraga: ' . $e->getMessage());
        }
    }

    // Method untuk cek dependency (untuk AJAX call jika diperlukan)
    public function checkDependencies($id)
    {
        try {
            $cabor = CabangOlahraga::with(['atlets', 'pelatihs'])->findOrFail($id);
            
            $jumlahAtlet = $cabor->atlets()->count();
            $jumlahPelatih = $cabor->pelatihs()->count();
            $totalData = $jumlahAtlet + $jumlahPelatih;
            
            return response()->json([
                'can_delete' => $totalData === 0,
                'dependencies' => [
                    'atlet' => $jumlahAtlet,
                    'pelatih' => $jumlahPelatih,
                    'total' => $totalData
                ],
                'message' => $totalData > 0 ? 
                    "Masih ada {$jumlahAtlet} atlet dan {$jumlahPelatih} pelatih yang terkait" : 
                    'Dapat dihapus'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // Method untuk force delete dengan cascade (gunakan dengan hati-hati)
    public function forceDestroy($id)
    {
        try {
            DB::beginTransaction();
            
            $cabor = CabangOlahraga::with(['atlets', 'pelatihs'])->findOrFail($id);
            
            // Hitung jumlah data yang akan dihapus
            $jumlahAtlet = $cabor->atlets()->count();
            $jumlahPelatih = $cabor->pelatihs()->count();
            
            // Hapus semua atlet terkait
            $cabor->atlets()->delete();
            
            // Hapus semua pelatih terkait  
            $cabor->pelatihs()->delete();
            
            // Hapus ikon
            if ($cabor->icon_cabor) {
                Storage::disk('public')->delete($cabor->icon_cabor);
            }
            
            // Hapus cabor
            $cabor->delete();
            
            DB::commit();
            
            $pesan = "Cabang olahraga '{$cabor->nama_cabor}' beserta {$jumlahAtlet} atlet dan {$jumlahPelatih} pelatih berhasil dihapus.";
            
            return redirect()->route('admin.konfigurasi.cabang-olahraga.index')
                ->with('cabor_deleted', $pesan);
                
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Gagal menghapus: ' . $e->getMessage());
        }
    }

    /**
     * Menangani upload icon dan resize ke 80x80px
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @return string
     */
    private function handleIconUpload($file)
    {
        $extension = strtolower($file->getClientOriginalExtension());
        $filename = time() . '_' . uniqid() . '.' . $extension;
        $path = 'icons/cabor/' . $filename;

        // Untuk file SVG, langsung simpan
        if ($extension === 'svg') {
            $file->storeAs('icons/cabor', $filename, 'public');
            return $path;
        }

        // Gunakan library GD untuk resize
        // Pastikan ekstensi GD di PHP sudah aktif
        $this->resizeImageGD($file->getRealPath(), storage_path('app/public/' . $path), 80, 80);

        return $path;
    }

    /**
     * Resize gambar menggunakan library GD
     *
     * @param string $sourcePath
     * @param string $destinationPath
     * @param int $width
     * @param int $height
     * @return bool
     */
    private function resizeImageGD($sourcePath, $destinationPath, $width, $height)
    {
        $info = \getimagesize($sourcePath);
        if (!$info) {
            return false;
        }

        $mime = $info['mime'];

        switch ($mime) {
            case 'image/jpeg':
                $source = \imagecreatefromjpeg($sourcePath);
                break;
            case 'image/png':
                $source = \imagecreatefrompng($sourcePath);
                break;
            case 'image/webp':
                if (\function_exists('imagecreatefromwebp')) {
                    $source = \imagecreatefromwebp($sourcePath);
                } else {
                    return false;
                }
                break;
            default:
                return false;
        }

        if (!$source) {
            return false;
        }

        // Dapatkan dimensi asli
        $originalWidth = \imagesx($source);
        $originalHeight = \imagesy($source);

        // Hitung dimensi baru dengan mempertahankan aspect ratio
        $aspectRatio = $originalWidth / $originalHeight;
        if ($width / $height > $aspectRatio) {
            $newWidth = $height * $aspectRatio;
            $newHeight = $height;
        } else {
            $newWidth = $width;
            $newHeight = $width / $aspectRatio;
        }

        // Buat canvas dengan ukuran yang diinginkan
        $dest = \imagecreatetruecolor($width, $height);

        // Set background transparan untuk PNG dan WebP
        if ($mime == 'image/png' || $mime == 'image/webp') {
            \imagealphablending($dest, false);
            \imagesavealpha($dest, true);
            $transparent = \imagecolorallocatealpha($dest, 0, 0, 0, 127);
            \imagefill($dest, 0, 0, $transparent);
        }

        // Hitung posisi untuk center crop
        $srcX = 0;
        $srcY = 0;
        $dstX = ($width - $newWidth) / 2;
        $dstY = ($height - $newHeight) / 2;

        // Resize dan copy gambar
        \imagecopyresampled(
            $dest, $source,
            $dstX, $dstY, $srcX, $srcY,
            $newWidth, $newHeight, $originalWidth, $originalHeight
        );

        // Pastikan direktori ada
        $directory = dirname($destinationPath);
        if (!\file_exists($directory)) {
            \mkdir($directory, 0755, true);
        }

        // Simpan gambar sesuai format
        $result = false;
        if (strpos($destinationPath, '.webp') !== false) {
            if (\function_exists('imagewebp')) {
                $result = \imagewebp($dest, $destinationPath, 90);
            }
        } elseif (strpos($destinationPath, '.jpg') !== false || strpos($destinationPath, '.jpeg') !== false) {
            $result = \imagejpeg($dest, $destinationPath, 90);
        } else {
            $result = \imagepng($dest, $destinationPath, 8);
        }

        // Bersihkan memory
        \imagedestroy($source);
        \imagedestroy($dest);

        return $result;
    }
}