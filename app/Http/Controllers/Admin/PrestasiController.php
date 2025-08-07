<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Atlet;
use App\Models\Pelatih;
use App\Models\Prestasi;
use App\Models\CabangOlahraga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PrestasiController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);

        $allowedSorts = [
            'nama_prestasi', 'tingkat', 'tempat', 'tahun', 'medali', 'updated_at', 'created_at'
        ];

        $sortBy = $request->get('sort_by', 'created_at');
        $order = strtolower($request->get('order', 'desc'));

        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'created_at';
        }
        if (!in_array($order, ['asc', 'desc'])) {
            $order = 'desc';
        }

        $query = Prestasi::with(['subject', 'cabangOlahraga'])
            ->select('prestasis.*')
            ->orderBy($sortBy, $order);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_prestasi', 'like', "%{$search}%")
                    ->orWhere('tingkat', 'like', "%{$search}%")
                    ->orWhere('tempat', 'like', "%{$search}%")
                    ->orWhereHasMorph('subject', [Atlet::class, Pelatih::class], function ($q) use ($search) {
                        $q->where('nama', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('medali')) {
            $query->where('medali', $request->medali);
        }

        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }

        if ($request->filled('tingkat')) {
            $query->where('tingkat', $request->tingkat);
        }

        if ($request->filled('subject_type')) {
            $query->where('subject_type', $request->subject_type === 'atlet' ? Atlet::class : Pelatih::class);
        }

        if ($request->filled('cabor')) {
              $query->whereHasMorph('subject', [Atlet::class, Pelatih::class], function ($q) use ($request) {
        $q->where('cabor_id', $request->cabor);
    });
}

        $prestasis = $query->paginate($perPage);
        $prestasis->appends($request->except('page'));

        $allCabors = DB::table('cabang_olahragas')->pluck('nama_cabor', 'id');
        $allTingkats = ['Nasional', 'Regional', 'Provinsi', 'Kota/Kabupaten'];
        $allMedalis = ['Emas', 'Perak', 'Perunggu'];
        $allYears = range(date('Y'), 2015);

        if ($request->get('get_tahun')) {
            $years = Prestasi::distinct()->pluck('tahun')->sortDesc()->values();
            return response()->json($years);
        }

        if ($request->ajax()) {
            return view('admin.prestasi._table', compact('prestasis'))->render();
        }

        return view('admin.prestasi.index', compact('prestasis', 'allCabors', 'allTingkats', 'allMedalis', 'allYears'));
    }

    public function create()
    {
        $atlets = Atlet::with('cabangOlahraga:id,nama_cabor')
                       ->select('id', 'nama', 'jenis_kelamin', 'cabor_id')
                       ->get();

        $pelatihs = Pelatih::with('cabangOlahraga:id,nama_cabor')
                           ->select('id', 'nama', 'kelamin', 'cabor_id')
                           ->get();

        $cabors = CabangOlahraga::orderBy('nama_cabor')->get();
        return view('admin.prestasi.create', compact('atlets', 'pelatihs', 'cabors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject_type' => 'required|in:atlet,pelatih',
            'subject_id' => 'required|exists:' . ($request->subject_type === 'pelatih' ? 'pelatih' : 'atlets') . ',id',
            'nama_prestasi' => 'required|string|max:255',
            'tingkat' => 'required|string|max:255',
            'tempat' => 'required|string|max:255',
            'tahun' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'medali' => 'required|in:Emas,Perak,Perunggu',
            'cabor_id' => 'required|exists:cabang_olahragas,id',
        ]);

        $subject = $request->subject_type === 'pelatih'
            ? Pelatih::find($request->subject_id)
            : Atlet::find($request->subject_id);

        $prestasi = new Prestasi($request->only([
            'nama_prestasi', 'tingkat', 'tempat', 'tahun', 'medali', 'cabor_id'
        ]));

        $prestasi->subject()->associate($subject);
        $prestasi->save();

        return redirect()->route('admin.konfigurasi.prestasi.index')
            ->with('OK', 'Prestasi berhasil ditambahkan!')
            ->with('action', 'store');
    }
public function edit(Prestasi $prestasi)
{
    $prestasi->load(['subject', 'cabangOlahraga']);

    $atlets = Atlet::all();
    $pelatihs = Pelatih::all();
    $cabors = CabangOlahraga::orderBy('nama_cabor', 'asc')->get();

    // PERBAIKAN: Jika cabor_id NULL, ambil dari subject
    if (!$prestasi->cabor_id && $prestasi->subject && $prestasi->subject->cabor_id) {
        \Log::info('Prestasi cabor_id is NULL, using subject cabor_id', [
            'prestasi_id' => $prestasi->id,
            'subject_cabor_id' => $prestasi->subject->cabor_id
        ]);

        // Set cabor_id dari subject untuk tampilan
        $prestasi->cabor_id = $prestasi->subject->cabor_id;

        // OPSIONAL: Update database juga
        // $prestasi->update(['cabor_id' => $prestasi->subject->cabor_id]);
    }

    \Log::info('Final prestasi data for edit:', [
        'prestasi_id' => $prestasi->id,
        'prestasi_cabor_id' => $prestasi->cabor_id,
        'subject_cabor_id' => $prestasi->subject->cabor_id ?? null,
        'subject_name' => $prestasi->subject->nama ?? null,
    ]);

    return view('admin.prestasi.edit', compact('prestasi', 'atlets', 'pelatihs', 'cabors'));
}

public function update(Request $request, Prestasi $prestasi)
{
    $request->validate([
        'nama_prestasi' => 'required|string|max:255',
        'tingkat' => 'required|string|max:255',
        'tempat' => 'required|string|max:255',
        'tahun' => 'required|integer|min:1900|max:' . (date('Y') + 1),
        'medali' => 'required|in:Emas,Perak,Perunggu',
        'cabor_id' => 'required|exists:cabang_olahragas,id',
    ]);

    $prestasi->update($request->only([
        'nama_prestasi', 'tingkat', 'tempat', 'tahun', 'medali', 'cabor_id'
    ]));

    return redirect()->route('admin.konfigurasi.prestasi.index')
        ->with('OK', 'Prestasi berhasil diperbarui!')
        ->with('action', 'update');
}

    public function destroy(Prestasi $prestasi)
    {
        $prestasi->delete();
        return back()->with('OK', 'Prestasi berhasil dihapus!')
            ->with('action', 'destroy');
    }

    public function createForAtlet(Atlet $atlet)
{
    $cabors = CabangOlahraga::orderBy('nama_cabor')->get();
    return view('admin.prestasi.create-atlet', compact('atlet', 'cabors'));
}

    public function storeForAtlet(Request $request, Atlet $atlet)
    {
        $request->validate([
            'nama_prestasi' => 'required|string|max:255',
            'tingkat' => 'required|string|max:255',
            'tempat' => 'required|string|max:255',
            'tahun' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'medali' => 'required|in:Emas,Perak,Perunggu',
             'cabor_id' => 'required|exists:cabang_olahragas,id',
        ]);

        $prestasi = new Prestasi($request->only([
            'nama_prestasi', 'tingkat', 'tempat', 'tahun', 'medali', 'cabor_id'
        ]));

        $prestasi->subject()->associate($atlet);
        $prestasi->save();

        return redirect()->route('admin.konfigurasi.atlet.show', $atlet)
            ->with('OK', 'Prestasi atlet berhasil ditambahkan!');
    }

   public function createForPelatih(Pelatih $pelatih)
{
    $cabors = CabangOlahraga::orderBy('nama_cabor')->get();
    return view('admin.prestasi.create-pelatih', compact('pelatih', 'cabors'));
}

    public function storeForPelatih(Request $request, Pelatih $pelatih)
    {
        $request->validate([
            'nama_prestasi' => 'required|string|max:255',
            'tingkat' => 'required|string|max:255',
            'tempat' => 'required|string|max:255',
            'tahun' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'medali' => 'required|in:Emas,Perak,Perunggu'
        ]);

        $prestasi = new Prestasi($request->only([
            'nama_prestasi', 'tingkat', 'tempat', 'tahun', 'medali'
        ]));

        $prestasi->subject()->associate($pelatih);
        $prestasi->save();

        return redirect()->route('admin.konfigurasi.pelatih.show', $pelatih)
            ->with('OK', 'Prestasi pelatih berhasil ditambahkan!');
    }
}
