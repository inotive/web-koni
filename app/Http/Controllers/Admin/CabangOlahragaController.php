<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CabangOlahraga;
use Illuminate\Support\Facades\Storage;

class CabangOlahragaController extends Controller
{
    /**
     * Menampilkan daftar cabang olahraga dengan fitur search, sort, dan pagination.
     */
    public function index(Request $request)
    {
        $query = CabangOlahraga::query();

        // Pencarian berdasarkan nama cabang olahraga atau ketua penanggung jawab
        if ($search = $request->input('search')) {
            $query->where('nama_cabor', 'like', '%' . $search . '%')
                  ->orWhere('ketua_penanggung_jawab', 'like', '%' . $search . '%');
        }

        // Filter berdasarkan status keaktifan
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

        $perPage = $request->get('perPage', 10);

        /** @var \Illuminate\Contracts\Pagination\LengthAwarePaginator $cabors */
        $cabors = $query->paginate($perPage)->appends(request()->query());

        // CHANGED: Path now includes 'konfigurasi' and uses hyphen
        return view('admin.cabang-olahraga.index', compact('cabors'));
    }

    /**
     * Menampilkan form untuk membuat cabang olahraga baru.
     */
    public function create()
    {
        // CHANGED: Path now includes 'konfigurasi' and uses hyphen
        return view('admin.cabang-olahraga.create');
    }

    /**
     * Menyimpan data cabang olahraga baru ke database.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_cabor' => 'required|string|max:50',
            'ketua_penanggung_jawab' => 'required|string|max:100',
            'status' => 'required|in:Aktif,Tidak Aktif',
            'tanggal_pembentukan' => 'required|date',
            'jumlah_atlet' => 'required|integer|min:0',
            'jumlah_pelatih' => 'required|integer|min:0',
            'icon_cabor' => 'nullable|image|mimes:png|dimensions:width=80,height=80|max:2048',
        ]);

        if ($request->hasFile('icon_cabor')) {
            $path = $request->file('icon_cabor')->store('icons/cabor', 'public');
            $validatedData['icon_cabor'] = $path;
        }

        $validatedData['terakhir_update'] = now();

        CabangOlahraga::create($validatedData);

        // This redirect uses the route name, which should be correct based on web.php
        return redirect()->route('admin.konfigurasi.cabang-olahraga.index')
            ->with('success', 'Cabang olahraga berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit data cabang olahraga.
     */
    public function edit($id)
    {
        $cabor = CabangOlahraga::findOrFail($id);
        // CHANGED: Path now includes 'konfigurasi' and uses hyphen
        return view('admin.cabang-olahraga.edit', compact('cabor'));
    }

    /**
     * Memperbarui data cabang olahraga.
     */
    public function update(Request $request, $id)
    {
        $cabor = CabangOlahraga::findOrFail($id);

        $validatedData = $request->validate([
            'nama_cabor' => 'required|string|max:50',
            'ketua_penanggung_jawab' => 'required|string|max:100',
            'status' => 'required|in:Aktif,Tidak Aktif',
            'tanggal_pembentukan' => 'required|date',
            'jumlah_atlet' => 'required|integer|min:0',
            'jumlah_pelatih' => 'required|integer|min:0',
            'icon_cabor' => 'nullable|image|mimes:png|dimensions:width=80,height=80|max:2048',
        ]);

        if ($request->hasFile('icon_cabor')) {
            if ($cabor->icon_cabor) {
                Storage::disk('public')->delete($cabor->icon_cabor);
            }
            $path = $request->file('icon_cabor')->store('icons/cabor', 'public');
            $validatedData['icon_cabor'] = $path;
        }

        $validatedData['terakhir_update'] = now();

        $cabor->update($validatedData);

        // This redirect uses the route name, which should be correct based on web.php
        return redirect()->route('admin.konfigurasi.cabang-olahraga.index')
            ->with('success', 'Cabang olahraga berhasil diperbarui.');
    }

    /**
     * Menghapus data cabang olahraga.
     */
    public function destroy($id)
    {
        $cabor = CabangOlahraga::findOrFail($id);

        if ($cabor->icon_cabor) {
            Storage::disk('public')->delete($cabor->icon_cabor);
        }

        $cabor->delete();

        // This redirect uses the route name, which should be correct based on web.php
        return redirect()->route('admin.konfigurasi.cabang-olahraga.index')
            ->with('success', 'Cabang olahraga berhasil dihapus.');
    }

    /**
     * Menampilkan detail cabang olahraga beserta atlet dan pelatih.
     */
    public function show($id)
    {
        $item = CabangOlahraga::with(['atlets', 'pelatihs'])->findOrFail($id);
        // CHANGED: Path now includes 'konfigurasi' and uses hyphen
        return view('admin.cabang-olahraga.show', compact('item'));
    }
}
