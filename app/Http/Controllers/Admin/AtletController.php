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
        $sortBy = $request->get('sort_by', 'created_at');
        $order = $request->get('order', 'desc');
        $search = $request->get('search');

        // Validate sort fields to prevent SQL injection
        $allowedSortFields = [
            'nama',
            'tanggal_lahir',
            'alamat',
            'jenis_kelamin',
            'no_telepon',
            'email',
            'updated_at',
            'created_at'
        ];

        if (!in_array($sortBy, $allowedSortFields)) {
            $sortBy = 'created_at';
        }

        if (!in_array($order, ['asc', 'desc'])) {
            $order = 'desc';
        }

        // Start building the query
        $query = Atlet::with(['cabangOlahraga', 'prestasis' => function($q) {
            $q->orderBy('created_at', 'desc')->limit(1);
        }]);

        // Apply search if provided
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

        // Apply sorting with special cases
        if ($sortBy === 'prestasi') {
            // Special handling for prestasi sorting
            $query->leftJoin('prestasis', function($join) {
                $join->on('atlets.id', '=', 'prestasis.atlet_id')
                     ->whereRaw('prestasis.id = (
                         SELECT MAX(id) FROM prestasis p2
                         WHERE p2.atlet_id = atlets.id
                     )');
            })->orderBy('prestasis.nama_prestasi', $order)
              ->select('atlets.*');
        } elseif ($sortBy === 'cabor') {
            // Sort by cabang olahraga name
            $query->join('cabang_olahragas', 'atlets.cabor_id', '=', 'cabang_olahragas.id')
                  ->orderBy('cabang_olahragas.nama_cabor', $order)
                  ->select('atlets.*');
        } else {
            // Regular sorting
            $query->orderBy($sortBy, $order);
        }

        // Add secondary sort to ensure consistent ordering
        if ($sortBy !== 'created_at') {
            $query->orderBy('created_at', 'desc');
        }

        $atlets = $query->paginate($perPage);

        // Preserve query parameters in pagination links
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
            'email' => 'nullable|email|max:100',
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
            'email' => 'nullable|email|max:100',
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
        $atlet = Atlet::with('prestasis')->findOrFail($id);
        return view('admin.atlet.show', compact('atlet'));
    }
}
