<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bendahara;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class BendaharaController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);

        $allowedSorts = [
            'judul', 'created_at', 'updated_at'
        ];

        $sortBy = $request->get('sort_by', 'created_at');
        $order = strtolower($request->get('order', 'desc'));

        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'created_at';
        }

        if (!in_array($order, ['asc', 'desc'])) {
            $order = 'desc';
        }

        $query = Bendahara::query();

        // Handle sorting
        $query->orderBy($sortBy, $order);

        // Search functionality
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('judul', 'like', '%' . $searchTerm . '%');
            });
        }

        // Add secondary sorting for consistency
        if ($sortBy !== 'created_at') {
            $query->orderBy('created_at', 'desc');
        }

        // Add final ordering by ID for consistency
        $query->orderBy('id', 'desc');

        $laporanBendahara = $query->paginate($perPage);
        $laporanBendahara->appends($request->query());

        if ($request->ajax()) {
            return view('admin.bendahara._table', compact('laporanBendahara'))->render();
        }

        return view('admin.bendahara.index', compact('laporanBendahara'));
    }

    public function create()
    {
        return view('admin.bendahara.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'judul' => 'required|string|max:255',
            'dokumen' => 'nullable|mimes:pdf,doc,docx,xls,xlsx|max:5120',
        ]);

        try {
            if ($request->hasFile('dokumen')) {
                $data['dokumen'] = $request->file('dokumen')->store('bendahara', 'public');
            }

            $laporanBendahara = Bendahara::create($data);

            return redirect()->route('admin.bendahara.index')
                ->with('OK', 'Laporan bendahara berhasil disimpan.')
                ->with('action', 'store');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Gagal menyimpan laporan bendahara. Error: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $laporanBendahara = Bendahara::findOrFail($id);
        return view('admin.bendahara.show', compact('laporanBendahara'));
    }

    public function edit($id)
    {
        $laporanBendahara = Bendahara::findOrFail($id);
        return view('admin.bendahara.edit', compact('laporanBendahara'));
    }

    public function update(Request $request, Bendahara $Bendahara)
    {
        $data = $request->validate([
            'judul' => 'required|string|max:255',
            'dokumen' => 'nullable|mimes:pdf,doc,docx,xls,xlsx|max:5120',
        ]);

        try {
            if ($request->hasFile('dokumen')) {
                if ($Bendahara->dokumen) {
                    Storage::disk('public')->delete($Bendahara->dokumen);
                }
                $data['dokumen'] = $request->file('dokumen')->store('bendahara', 'public');
            }

            $Bendahara->update($data);

            return redirect()->route('admin.bendahara.index')
                ->with('OK', 'Laporan bendahara berhasil diubah.')
                ->with('action', 'update');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Gagal mengubah laporan bendahara. Error: ' . $e->getMessage());
        }
    }

    public function destroy(Request $request, Bendahara $Bendahara)
    {
        try {
            // Delete file if exists
            if ($Bendahara->dokumen) {
                Storage::disk('public')->delete($Bendahara->dokumen);
            }

            $Bendahara->delete();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Laporan bendahara berhasil dihapus.'
                ]);
            }

            return redirect()->route('admin.bendahara.index')
                ->with('OK', 'Laporan bendahara berhasil dihapus.')
                ->with('action', 'destroy');

        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus laporan bendahara. Error: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Gagal menghapus laporan bendahara. Error: ' . $e->getMessage());
        }
    }

    public function download($id)
    {
        $laporanBendahara = Bendahara::findOrFail($id);

        if (!$laporanBendahara->dokumen) {
            return back()->with('error', 'Dokumen tidak tersedia.');
        }

        $filePath = storage_path('app/public/' . $laporanBendahara->dokumen);

        if (!file_exists($filePath  )) {
            return back()->with('error', 'File tidak ditemukan.');
        }

        $fileName = $laporanBendahara->judul . '_' . date('Y-m-d') . '.' . pathinfo($laporanBendahara->dokumen, PATHINFO_EXTENSION);

        return response()->download($filePath, $fileName);
    }
}
