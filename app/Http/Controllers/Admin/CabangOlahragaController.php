<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CabangOlahraga;
use Illuminate\Support\Facades\Storage;

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
            'icon_cabor' => 'nullable|image|mimes:png|dimensions:width=80,height=80|max:2048',
        ]);

        if ($request->hasFile('icon_cabor')) {
            $path = $request->file('icon_cabor')->store('icons/cabor', 'public');
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
}