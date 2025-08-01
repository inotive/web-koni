<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Atlet;
use App\Models\CabangOlahraga;
use Illuminate\Support\Facades\Storage;

class AtletController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $sortBy = $request->get('sort_by', 'updated_at');
        $order = $request->get('order', 'desc');
        $search = $request->get('search');

        $allowedSortFields = [
            'nama',
            'tanggal_lahir',
            'alamat',
            'jenis_kelamin',
            'no_telepon',
            'email',
            'updated_at',
            'created_at',
            'prestasi'
        ];

        if (!in_array($sortBy, $allowedSortFields)) {
            $sortBy = 'created_at';
        }

        if (!in_array($order, ['asc', 'desc'])) {
            $order = 'desc';
        }

        $query = Atlet::with(['cabangOlahraga', 'prestasis' => function($q) {
            $q->orderBy('created_at', 'desc')->limit(1);
        }]);

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('no_telepon', 'LIKE', "%{$search}%")
                  ->orWhere('alamat', 'LIKE', "%{$search}%")
                  ->orWhere('tempat_lahir', 'LIKE', "%{$search}%")
                  ->orWhereHas('cabangOlahraga', function($subQ) use ($search) {
                      $subQ->where('nama_cabor', 'LIKE', "%{$search}%");
                  });
            });
        }

        if ($sortBy === 'prestasi') {
            $query->leftJoin('prestasis', function($join) {
                $join->on('atlets.id', '=', 'prestasis.atlet_id')
                     ->whereRaw('prestasis.id = (
                         SELECT MAX(p2.id) FROM prestasis p2
                         WHERE p2.atlet_id = atlets.id
                     )');
            })
            ->orderByRaw('prestasis.nama_prestasi IS NULL, prestasis.nama_prestasi ' . $order)
            ->select('atlets.*');
        } else {
            $query->orderBy($sortBy, $order);
        }

        if ($sortBy !== 'updated_at') {
            $query->orderBy('updated_at', 'desc');
        }

        $atlets = $query->paginate($perPage);

        $atlets->appends($request->query());

        $allCabor = CabangOlahraga::pluck('nama_cabor', 'id');

        return view('admin.atlet.index', compact('atlets', 'allCabor'));
    }

    public function create()
    {
        $cabors = CabangOlahraga::select('id', 'nama_cabor')->get();
        return view('admin.atlet.create', compact('cabors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'cabor_id' => 'required|exists:cabang_olahragas,id',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'no_telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100|unique:atlets,email',
            'foto_atlet' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('foto_atlet')) {
            $foto = $request->file('foto_atlet')->store('foto_atlet', 'public');
            $validated['foto_atlet'] = $foto;
        }

        Atlet::create($validated);

        return redirect()->route('admin.konfigurasi.atlet.index')
            ->with('OK', 'Atlet berhasil ditambahkan.')
            ->with('action', 'store');
    }

    public function edit($id)
    {
        $atlet = Atlet::findOrFail($id);
        $cabors = CabangOlahraga::select('id', 'nama_cabor')->get();
        return view('admin.atlet.edit', compact('atlet', 'cabors'));
    }

    public function update(Request $request, $id)
    {
        $atlet = Atlet::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'cabor_id' => 'required|exists:cabang_olahragas,id',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'no_telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100|unique:atlets,email,' . $id,
            'foto_atlet' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('foto_atlet')) {
            if ($atlet->foto_atlet) {
                Storage::disk('public')->delete($atlet->foto_atlet);
            }
            $foto = $request->file('foto_atlet')->store('foto_atlet', 'public');
            $validated['foto_atlet'] = $foto;
        }

        $atlet->update($validated);

        return redirect()->route('admin.konfigurasi.atlet.index')
            ->with('OK', 'Data atlet berhasil diperbarui.')
            ->with('action', 'update');
    }

    public function destroy($id)
    {
        $atlet = Atlet::findOrFail($id);

        if ($atlet->foto_atlet) {
            Storage::disk('public')->delete($atlet->foto_atlet);
        }

        $atlet->delete();

        return redirect()->route('admin.konfigurasi.atlet.index')
            ->with('OK', 'Data atlet berhasil dihapus.')
            ->with('action', 'destroy');
    }

    public function show($id)
    {
        $atlet = Atlet::with(['prestasis' => function($q) {
            $q->orderBy('tahun', 'desc');
        }, 'cabangOlahraga'])->findOrFail($id);

        return view('admin.atlet.show', compact('atlet'));
    }
}
