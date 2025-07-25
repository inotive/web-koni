<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CabangOlahraga;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image; // Import untuk Laravel 9+
// use Intervention\Image\Facades\Image; // Gunakan ini untuk Laravel 8 ke bawah

class CabangOlahragaController extends Controller
{

    public function index(Request $request)
    {
        $query = CabangOlahraga::query();

        if ($search = $request->input('search')) {
            $query->where('nama_cabor', 'like', '%' . $search . '%')
                  ->orWhere('ketua_penanggung_jawab', 'like', '%' . $search . '%');
        }

        if ($status = $request->input('filter_status')) {
            $query->where('status', $status);
        }

        if ($sortBy = $request->input('sort_by')) {
            $order = $request->input('order', 'asc');
            $query->orderBy($sortBy, $order);
        } else {
            $query->orderBy('terakhir_update', 'desc');
        }

        $perPage = $request->get('perPage', 10);

        /** @var \Illuminate\Contracts\Pagination\LengthAwarePaginator $cabors */
        $cabors = $query->paginate($perPage)->appends(request()->query());

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
            ->with('success', 'Cabang olahraga berhasil ditambahkan.');
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
            ->with('success', 'Cabang olahraga berhasil diperbarui.');
    }


    public function destroy($id)
    {
        $cabor = CabangOlahraga::findOrFail($id);

        if ($cabor->icon_cabor) {
            Storage::disk('public')->delete($cabor->icon_cabor);
        }

        $cabor->delete();

        return redirect()->route('admin.konfigurasi.cabang-olahraga.index')
            ->with('success', 'Cabang olahraga berhasil dihapus.');
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
        $info = getimagesize($sourcePath);
        if (!$info) {
            return false;
        }
        
        $mime = $info['mime'];
        
        switch ($mime) {
            case 'image/jpeg':
                $source = imagecreatefromjpeg($sourcePath);
                break;
            case 'image/png':
                $source = imagecreatefrompng($sourcePath);
                break;
            case 'image/webp':
                if (function_exists('imagecreatefromwebp')) {
                    $source = imagecreatefromwebp($sourcePath);
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
        $originalWidth = imagesx($source);
        $originalHeight = imagesy($source);
        
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
        $dest = imagecreatetruecolor($width, $height);
        
        // Set background transparan untuk PNG dan WebP
        if ($mime == 'image/png' || $mime == 'image/webp') {
            imagealphablending($dest, false);
            imagesavealpha($dest, true);
            $transparent = imagecolorallocatealpha($dest, 0, 0, 0, 127);
            imagefill($dest, 0, 0, $transparent);
        }
        
        // Hitung posisi untuk center crop
        $srcX = 0;
        $srcY = 0;
        $dstX = ($width - $newWidth) / 2;
        $dstY = ($height - $newHeight) / 2;
        
        // Resize dan copy gambar
        imagecopyresampled(
            $dest, $source, 
            $dstX, $dstY, $srcX, $srcY,
            $newWidth, $newHeight, $originalWidth, $originalHeight
        );
        
        // Pastikan direktori ada
        $directory = dirname($destinationPath);
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }
        
        // Simpan gambar sesuai format
        $result = false;
        if (strpos($destinationPath, '.webp') !== false) {
            if (function_exists('imagewebp')) {
                $result = imagewebp($dest, $destinationPath, 90);
            }
        } elseif (strpos($destinationPath, '.jpg') !== false || strpos($destinationPath, '.jpeg') !== false) {
            $result = imagejpeg($dest, $destinationPath, 90);
        } else {
            $result = imagepng($dest, $destinationPath, 8);
        }
        
        // Bersihkan memory
        imagedestroy($source);
        imagedestroy($dest);
        
        return $result;
    }
}