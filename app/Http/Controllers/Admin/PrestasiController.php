<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Atlet;
use App\Models\Pelatih;
use App\Models\Prestasi;
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

        $query = Prestasi::with(['subject'])
            ->select('prestasis.*')
            ->orderBy($sortBy, $order);

        // Search functionality
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

        // Medal filter
        if ($request->filled('medali')) {
            $query->where('medali', $request->medali);
        }

        // Year filter - Fixed logic
        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }

        // Level filter
        if ($request->filled('tingkat')) {
            $query->where('tingkat', $request->tingkat);
        }

        // Subject type filter
        if ($request->filled('subject_type')) {
            $query->where('subject_type', $request->subject_type === 'atlet' ? Atlet::class : Pelatih::class);
        }

        // Sport category filter
        if ($request->filled('cabor')) {
            $query->whereHasMorph('subject', [Atlet::class, Pelatih::class], function ($q) use ($request) {
                $q->whereHas('cabangOlahraga', function ($q2) use ($request) {
                    $q2->where('nama_cabor', $request->cabor);
                });
            });
        }

        $prestasis = $query->paginate($perPage);
        $prestasis->appends($request->except('page'));

        // Get filter data
        $allCabors = DB::table('cabang_olahragas')->pluck('nama_cabor', 'id');
        $allTingkats = ['Nasional', 'Regional', 'Provinsi', 'Kota/Kabupaten'];
        $allMedalis = ['Emas', 'Perak', 'Perunggu'];
        $allYears = range(date('Y'), 2015);

        // Special endpoint for getting years
        if ($request->get('get_tahun')) {
            $years = Prestasi::distinct()->pluck('tahun')->sortDesc()->values();
            return response()->json($years);
        }

        // AJAX request - return only table partial
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

        return view('admin.prestasi.create', compact('atlets', 'pelatihs'));
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
            'medali' => 'required|in:Emas,Perak,Perunggu'
        ]);

        $subject = $request->subject_type === 'pelatih'
            ? Pelatih::find($request->subject_id)
            : Atlet::find($request->subject_id);

        $prestasi = new Prestasi($request->only([
            'nama_prestasi', 'tingkat', 'tempat', 'tahun', 'medali'
        ]));

        $prestasi->subject()->associate($subject);
        $prestasi->save();

        return redirect()->route('admin.konfigurasi.prestasi.index')
            ->with('success', 'Prestasi berhasil ditambahkan!')
            ->with('action', 'store');
    }

    public function edit(Prestasi $prestasi)
    {
        $atlets = Atlet::all();
        $pelatihs = Pelatih::all();
        return view('admin.prestasi.edit', compact('prestasi', 'atlets', 'pelatihs'));
    }

    public function update(Request $request, Prestasi $prestasi)
    {
        $request->validate([
            'nama_prestasi' => 'required|string|max:255',
            'tingkat' => 'required|string|max:255',
            'tempat' => 'required|string|max:255',
            'tahun' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'medali' => 'required|in:Emas,Perak,Perunggu'
        ]);

        $prestasi->update($request->only([
            'nama_prestasi', 'tingkat', 'tempat', 'tahun', 'medali'
        ]));

        return redirect()->route('admin.konfigurasi.prestasi.index')
            ->with('success', 'Prestasi berhasil diperbarui!')
            ->with('action', 'update');
    }

    public function destroy(Prestasi $prestasi)
    {
        $prestasi->delete();
        return back()->with('success', 'Prestasi berhasil dihapus!')
            ->with('action', 'destroy');
    }

    public function createForAtlet(Atlet $atlet)
    {
        return view('admin.prestasi.create-atlet', compact('atlet'));
    }

    public function storeForAtlet(Request $request, Atlet $atlet)
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

        $prestasi->subject()->associate($atlet);
        $prestasi->save();

        return redirect()->route('admin.konfigurasi.atlet.show', $atlet)
            ->with('success', 'Prestasi atlet berhasil ditambahkan!');
    }

    public function createForPelatih(Pelatih $pelatih)
    {
        return view('admin.prestasi.create-pelatih', compact('pelatih'));
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
            ->with('success', 'Prestasi pelatih berhasil ditambahkan!');
    }
}
