<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lpj;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LpjController extends Controller
{
    /**
     * Display a listing based on parent ID
     */
    public function index(Request $request, $parentId = null)
    {
        $query = Lpj::query();

        // Filter by parent ID
        if ($parentId) {
            $parent = Lpj::findOrFail($parentId);
            $query->where('parent_id', $parentId);
        } else {
            $query->whereNull('parent_id');
        }

        // Apply search filter
        if ($request->filled('search')) {
            $searchTerm = $request->get('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('nama_program', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('nama_kegiatan', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('keterangan_tambahan', 'LIKE', "%{$searchTerm}%");
            });
        }

        // Apply kegiatan filter
        if ($request->filled('jenis_kegiatan_filter')) {
            $query->where('nama_kegiatan', $request->get('jenis_kegiatan_filter'));
        }

        // Apply sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');

        $allowedSorts = ['nama_program', 'nama_kegiatan', 'volume', 'jumlah_harga_satuan', 'jumlah_harga', 'created_at'];
        if (in_array($sortField, $allowedSorts)) {
            $query->orderBy($sortField, $sortDirection);
        }

        // Pagination
        $perPage = $request->get('per_page', 10);
        $lpjData = $query->paginate($perPage)->withQueryString();

        // Get current parent and breadcrumb data
        $parent = $parentId ? Lpj::findOrFail($parentId) : null;
        $currentParent = $parentId ? Lpj::find($parentId) : null;
        $breadcrumbs = $this->buildBreadcrumbs($currentParent);

        // Get unique kegiatan for filter
        $uniqueKegiatan = Lpj::where('parent_id', $parentId)
                            ->select(['*', 'modifiable_by_user_id'])
                            ->whereNotNull('nama_kegiatan')
                            ->pluck('nama_kegiatan')
                            ->unique()
                            ->filter();

        if ($request->ajax()) {
            return view('admin.laporan-lpj.bidang_new.dynamic._table', compact('lpjData', 'currentParent'))->render();
        }

        return view('admin.laporan-lpj.bidang_new.dynamic.index', compact(
            'lpjData',
            'currentParent',
            'parent',
            'breadcrumbs',
            'uniqueKegiatan',
            'parentId'
        ));
    }

    /**
     * Show the form for creating a new resource
     */
    public function create($parentId = null)
    {
        $parent = $parentId ? Lpj::findOrFail($parentId) : null;
        $breadcrumbs = $this->buildBreadcrumbs($parent);

        return view('admin.laporan-lpj.bidang_new.dynamic.create', compact('parent', 'breadcrumbs', 'parentId'));
    }

    /**
     * Store a newly created resource
     */
    public function store(Request $request, $parentId = null)
    {
        $validated = $request->validate([
            'nama_program' => 'required|string|max:255',
            'nama_kegiatan' => 'required|string|max:255',
            'volume' => 'required|string|max:255',
            'jumlah_harga_satuan' => 'required|numeric|min:0',
            'jumlah_harga' => 'required|numeric|min:0',
            'keterangan_tambahan' => 'nullable|string',
            'foto_jurnal.*' => 'nullable|image|max:10240', // 10MB
            'dokumen_lpj.*' => 'nullable|mimes:pdf,doc,docx,xls,xlsx|max:10240'
        ]);

        // Handle file uploads
        $fotoJurnal = $this->handleFileUploads($request, 'foto_jurnal', 'lpj/foto');
        $dokumenLpj = $this->handleFileUploads($request, 'dokumen_lpj', 'lpj/dokumen');

        $lpj = Lpj::create([
            'parent_id' => $parentId,
            'nama_program' => $validated['nama_program'],
            'nama_kegiatan' => $validated['nama_kegiatan'],
            'volume' => $validated['volume'],
            'jumlah_harga_satuan' => $validated['jumlah_harga_satuan'] ?? 0,
            'jumlah_harga' => $validated['jumlah_harga'] ?? 0,
            'keterangan_tambahan' => $validated['keterangan_tambahan'],
            'foto_jurnal' => $fotoJurnal,
            'dokumen_lpj' => $dokumenLpj,
        ]);

        $message = 'Data berhasil ditambahkan';

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => $message]);
        }

        return redirect()
            ->route($parentId ? 'admin.laporan-lpj.bidang.dynamic.child.index' : 'admin.laporan-lpj.bidang.dynamic.index',
                    $parentId ? ['parentId' => $parentId] : [])
            ->with('OK', $message);
    }

    /**
     * Display the specified resource
     */
    public function show($id)
    {
        $lpj = Lpj::findOrFail($id);
        $breadcrumbs = $this->buildBreadcrumbs($lpj->parent);

        return view('admin.laporan-lpj.bidang_new.dynamic.show', compact('lpj', 'breadcrumbs'));
    }

    /**
     * Show the form for editing
     */
    public function edit($id)
    {
        $lpj = Lpj::findOrFail($id);
        $breadcrumbs = $this->buildBreadcrumbs($lpj->parent);

        return view('admin.laporan-lpj.bidang_new.dynamic.edit', compact('lpj', 'breadcrumbs'));
    }

    /**
     * Update the specified resource
     */
    public function update(Request $request, $id)
    {
        $lpj = Lpj::findOrFail($id);

        $validated = $request->validate([
            'nama_program' => 'required|string|max:255',
            'nama_kegiatan' => 'required|string|max:255',
            'volume' => 'required|string|max:255',
            'jumlah_harga_satuan' => 'required|numeric|min:0',
            'jumlah_harga' => 'required|numeric|min:0',
            'keterangan_tambahan' => 'nullable|string',
            'foto_jurnal.*' => 'nullable|image|max:10240',
            'dokumen_lpj.*' => 'nullable|mimes:pdf,doc,docx,xls,xlsx|max:10240',
            'existing_foto_jurnal' => 'nullable|array',
            'existing_dokumen_lpj' => 'nullable|array',
        ]);

        // Handle existing files
        $existingFotoJurnal = $request->get('existing_foto_jurnal', []);
        $existingDokumenLpj = $request->get('existing_dokumen_lpj', []);

        // Delete removed files
        if ($lpj->foto_jurnal) {
            foreach ($lpj->foto_jurnal as $foto) {
                if (!in_array($foto, $existingFotoJurnal)) {
                    Storage::delete($foto);
                }
            }
        }

        if ($lpj->dokumen_lpj) {
            foreach ($lpj->dokumen_lpj as $dokumen) {
                if (!in_array($dokumen, $existingDokumenLpj)) {
                    Storage::delete($dokumen);
                }
            }
        }

        // Handle new file uploads
        $newFotoJurnal = $this->handleFileUploads($request, 'foto_jurnal', 'lpj/foto');
        $newDokumenLpj = $this->handleFileUploads($request, 'dokumen_lpj', 'lpj/dokumen');

        // Merge existing and new files
        $allFotoJurnal = array_merge($existingFotoJurnal, $newFotoJurnal);
        $allDokumenLpj = array_merge($existingDokumenLpj, $newDokumenLpj);

        $lpj->update([
            'nama_program' => $validated['nama_program'],
            'nama_kegiatan' => $validated['nama_kegiatan'],
            'volume' => $validated['volume'],
            'jumlah_harga_satuan' => $validated['jumlah_harga_satuan'] ?? 0,
            'jumlah_harga' => $validated['jumlah_harga'] ?? 0,
            'keterangan_tambahan' => $validated['keterangan_tambahan'],
            'foto_jurnal' => $allFotoJurnal,
            'dokumen_lpj' => $allDokumenLpj,
        ]);

        $message = 'Data berhasil diperbarui';

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => $message]);
        }

        return redirect()
            ->route($lpj->parent_id ? 'admin.laporan-lpj.bidang.dynamic.child.index' : 'admin.laporan-lpj.bidang.dynamic.index',
                    $lpj->parent_id ? ['parentId' => $lpj->parent_id] : [])
            ->with('OK', $message);
    }

    /**
     * Remove the specified resource
     */
    public function destroy($id)
    {
        try {
            $lpj = Lpj::findOrFail($id);
            $parentId = $lpj->parent_id;

            // Delete associated files
            if ($lpj->foto_jurnal) {
                foreach ($lpj->foto_jurnal as $foto) {
                    Storage::delete($foto);
                }
            }

            if ($lpj->dokumen_lpj) {
                foreach ($lpj->dokumen_lpj as $dokumen) {
                    Storage::delete($dokumen);
                }
            }

            $lpj->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil dihapus'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create a new category/parent
     */
    public function createCategory($parentId = null)
    {
        $parent = $parentId ? Lpj::findOrFail($parentId) : null;
        $breadcrumbs = $this->buildBreadcrumbs($parent);

        return view('admin.laporan-lpj.bidang_new.dynamic.create-category', compact('parent', 'breadcrumbs', 'parentId'));
    }

    /**
     * Store a new category/parent
     */
    public function storeCategory(Request $request, $parentId = null)
    {
        $validated = $request->validate([
            'nama_program' => 'required|string|max:255',
            'nama_kegiatan' => 'required|string|max:255',
            'icon' => 'nullable|string|max:255',
            'keterangan_tambahan' => 'nullable|string',
        ]);

        $category = Lpj::create([
            'parent_id' => $parentId,
            'nama_program' => $validated['nama_program'],
            'nama_kegiatan' => $validated['nama_kegiatan'],
            'icon' => $validated['icon'],
            'keterangan_tambahan' => $validated['keterangan_tambahan'],
            'volume' => $request->input('volume', ''),
            'jumlah_harga_satuan' => 0,
            'jumlah_harga' => 0,
        ]);

        $message = 'Kategori berhasil ditambahkan';

        return redirect()
            ->route($parentId ? 'admin.laporan-lpj.bidang.dynamic.child.index' : 'admin.laporan-lpj.bidang.dynamic.index',
                    $parentId ? ['parentId' => $parentId] : [])
            ->with('OK', $message);
    }

    /**
     * Navigate to child entries
     */
    public function navigate($id)
    {
        $lpj = Lpj::findOrFail($id);

        return redirect()->route('admin.laporan-lpj.bidang.dynamic.child.index', ['parentId' => $id]);
    }

    /**
     * Handle file uploads
     */
    private function handleFileUploads(Request $request, string $fieldName, string $path, array $existingFiles = []): array
    {
        $uploadedFiles = [];

        if ($request->hasFile($fieldName)) {
            foreach ($request->file($fieldName) as $file) {
                $filename = $file->getClientOriginalName();
                $filePath = $file->storeAs($path, $filename, 'public');
                $uploadedFiles[] = $filePath;
            }
        }

        return $uploadedFiles;
    }

    /**
     * Build breadcrumb navigation
     */
    private function buildBreadcrumbs($currentItem = null): array
    {
        $breadcrumbs = [
            [
                'title' => 'Dashboard',
                'url' => route('admin.dashboard.index'),
                'active' => false
            ],
            [
                'title' => 'Laporan LPJ',
                'url' => route('admin.dashboard.index'),
                'active' => false
            ],
            [
                'title' => 'Bidang',
                'url' => route('admin.laporan-lpj.bidang.dynamic.index'),
                'active' => false
            ]
        ];

        if ($currentItem) {
            // Get ancestors if the model has this method
            if (method_exists($currentItem, 'ancestors')) {
                $ancestors = $currentItem->ancestors();

                foreach ($ancestors as $ancestor) {
                    $breadcrumbs[] = [
                        'title' => $ancestor->nama_program,
                        'url' => route('admin.laporan-lpj.bidang.dynamic.child.index', ['parentId' => $ancestor->id]),
                        'active' => false
                    ];
                }
            }

            $breadcrumbs[] = [
                'title' => $currentItem->nama_program,
                'url' => null,
                'active' => true
            ];
        } else {
            $breadcrumbs[] = [
                'title' => 'Root Level',
                'url' => null,
                'active' => true
            ];
        }

        return $breadcrumbs;
    }

    /**
     * Get tree structure for navigation
     */
    public function getTreeStructure($parentId = null)
    {
        $items = Lpj::where('parent_id', $parentId)
                   ->orderBy('nama_program')
                   ->get();

        $tree = [];
        foreach ($items as $item) {
            $hasChildren = Lpj::where('parent_id', $item->id)->exists();
            $isDataEntry = !$hasChildren;

            $tree[] = [
                'id' => $item->id,
                'nama_program' => $item->nama_program,
                'nama_kegiatan' => $item->nama_kegiatan,
                'has_children' => $hasChildren,
                'is_data_entry' => $isDataEntry,
                'url' => $hasChildren
                    ? route('admin.laporan-lpj.bidang.dynamic.child.index', ['parentId' => $item->id])
                    : route('admin.laporan-lpj.bidang.dynamic.show', $item->id)
            ];
        }

        return response()->json($tree);
    }

    public function exportCsv(Request $request, $parentId = null)
    {
        $query = Lpj::query();

        // Filter by parent ID
        if ($parentId) {
            $query->where('parent_id', $parentId);
        } else {
            $query->whereNull('parent_id');
        }

        // Apply search filter
        if ($request->filled('search')) {
            $searchTerm = $request->get('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('nama_program', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('nama_kegiatan', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('keterangan_tambahan', 'LIKE', "%{$searchTerm}%");
            });
        }

        // Apply kegiatan filter
        if ($request->filled('jenis_kegiatan_filter')) {
            $query->where('nama_kegiatan', $request->get('jenis_kegiatan_filter'));
        }

        $lpjData = $query->get();

        $response = new StreamedResponse(function() use ($lpjData) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, [
                'Nama Program',
                'Nama Kegiatan',
                'Volume',
                'Harga Satuan',
                'Jumlah',
                'Keterangan'
            ]);

            foreach ($lpjData as $lpj) {
                fputcsv($handle, [
                    $lpj->nama_program,
                    $lpj->nama_kegiatan,
                    $lpj->volume,
                    $lpj->jumlah_harga_satuan,
                    $lpj->jumlah_harga,
                    $lpj->keterangan_tambahan
                ]);
            }

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="lpj_export.csv"');

        return $response;
    }
}
