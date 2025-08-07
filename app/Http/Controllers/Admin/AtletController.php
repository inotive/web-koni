<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Atlet;
use App\Models\CabangOlahraga;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class AtletController extends Controller
{
  public function index(Request $request)
{
    $perPage = $request->get('per_page', 10);

$allowedSorts = [
    'nama', 'tanggal_lahir', 'jenis_kelamin', 'alamat',
    'no_telepon', 'email', 'updated_at', 'created_at'
];

$sortBy   = $request->get('sort_by', 'created_at');
$order    = strtolower($request->get('order', 'desc'));

if (!in_array($sortBy, $allowedSorts)) {
    $sortBy = 'created_at';
}
if (!in_array($order, ['asc', 'desc'])) {
    $order = 'desc';
}

$query = Atlet::with(['cabangOlahraga', 'prestasis'])
              ->orderBy($sortBy, $order);

    if ($request->filled('search')) {
        $query->where('nama', 'like', '%' . $request->search . '%');
    }

    if ($request->filled('cabor')) {
        $query->whereHas('cabangOlahraga', function ($q) use ($request) {
            $q->where('nama_cabor', $request->cabor);
        });
    }

    if ($request->filled('gender')) {
        $query->where('jenis_kelamin', $request->gender);
    }

    if ($request->filled('age')) {
        $age = $request->age;
        if ($age === '36+') {
            $query->whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) >= 36');
        } else {
            [$min, $max] = array_map('intval', explode('-', $age));
            $query->whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN ? AND ?', [$min, $max]);
        }
    }

    if ($request->filled('prestasi')) {
        switch ($request->prestasi) {
            case 'ada':
                $query->has('prestasis');
                break;
            case 'tidak':
                $query->doesntHave('prestasis');
                break;
            case 'emas':
            case 'perak':
            case 'perunggu':
                $query->whereHas('prestasis', fn($q) => $q->where('medali', ucfirst($request->prestasi)));
                break;
        }
        $latestPrestasiSub = DB::table('prestasis')
    ->select('atlet_id', DB::raw('MAX(updated_at) as latest_prestasi_at'))
    ->groupBy('atlet_id');

$query = Atlet::with(['cabangOlahraga', 'prestasis'])
    ->leftJoinSub($latestPrestasiSub, 'latest_prestasi', function ($join) {
        $join->on('atlets.id', '=', 'latest_prestasi.atlet_id');
    });

$allowedSorts = [
    'nama', 'tanggal_lahir', 'jenis_kelamin', 'alamat',
    'no_telepon', 'email', 'updated_at', 'created_at',
    'latest_prestasi_at'
];

$sortBy   = $request->get('sort_by', 'created_at');
$order    = strtolower($request->get('order', 'desc'));

if (!in_array($sortBy, $allowedSorts)) {
    $sortBy = 'created_at';
}
if (!in_array($order, ['asc', 'desc'])) {
    $order = 'desc';
}
if ($sortBy === 'latest_prestasi_at') {
    // kalau sort by prestasi terbaru
    $query->orderByRaw('latest_prestasi.latest_prestasi_at ' . $order . ' NULLS LAST');
} else {
    $query->orderBy('atlets.' . $sortBy, $order);
}

$query->select('atlets.*');
    }

    $atlets = $query->paginate($perPage);

    $allCabor = CabangOlahraga::pluck('nama_cabor', 'id');

    if ($request->ajax()) {
        return view('admin.atlet._table', compact('atlets'))->render();
    }

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
    $atlet = Atlet::withCount('prestasis')->findOrFail($id);

        if ($atlet->prestasis_count > 0) {
            return redirect()
                ->route('admin.konfigurasi.atlet.index')
                ->with('error', "Gagal dihapus – atlet ini masih memiliki {$atlet->prestasis_count} prestasi.");
        }

        if ($atlet->foto_atlet) {
            Storage::disk('public')->delete($atlet->foto_atlet);
        }

        $atlet->delete();

        return redirect()->route('admin.konfigurasi.atlet.index')
            ->with('OK', 'Atlet berhasil dihapus.');
    }

    public function show($id)
    {
        $atlet = Atlet::with('prestasis')->findOrFail($id);

        $backUrl = request('back') === 'cabor'
            ? route('admin.konfigurasi.cabang-olahraga.show', $atlet->cabor_id)
            : route('admin.konfigurasi.atlet.index');

        return view('admin.atlet.show', compact('atlet', 'backUrl'));
    }

    $atlet->delete();

    return redirect()
        ->route('admin.konfigurasi.atlet.index')
        ->with('OK', 'Data atlet berhasil dihapus.')
        ->with('action', 'destroy');
}

public function show(Atlet $atlet, Request $request)
{
    if ($request->has('from')) {
        session(['detail_referrer' => $request->get('from')]);
    } elseif (!session()->has('detail_referrer') && $request->header('referer')) {
        $referrer = $request->header('referer');
        if (str_contains($referrer, 'prestasi')) {
            session(['detail_referrer' => 'prestasi']);
        } else {
            session(['detail_referrer' => 'atlet']);
        }
    }

    $atlet->load(['cabangOlahraga', 'prestasis']);

    return view('admin.atlet.show', compact('atlet'));
}
}
