<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lpj;
use App\Models\Pengajuan;
use App\Models\Target; // Fixed capitalization
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Barryvdh\DomPDF\Facade\Pdf;
use setasign\Fpdi\Fpdi;
use setasign\Fpdi\PdfReader\PageBoundaries;

class LpjController extends Controller
{
    /**
     * DIPAKE BUAT BIDANG-BIDANG, BUKAN UNTUK SEMUA LPJ
     */
    public function index(Request $request, $parentId = null)
    {
        $query = Lpj::query();

        $target = null;
        $current_budget = 0;
        $kegiatan_count = 0;

        // Filter by parent ID
        if ($parentId) {
            $parent = Lpj::findOrFail($parentId);
            $query->where('parent_id', $parentId);

            // Fixed model reference
            $target = Target::where('id_lpj', $parentId)->first();

            // Fixed budget calculation - use proper field names
            $children = Lpj::where('parent_id', $parentId)->get();
            foreach ($children as $child) {
                // Use jumlah_harga instead of getTotalBudget() method
                $current_budget += ($child->jumlah_harga ?? 0);
            }
            $kegiatan_count = $children->count();
        } else {
            $query->whereNull('parent_id');
        }

        // Year filter and available years (use 'year' column)
        $selectedYear = $request->get('year');
        if ($selectedYear) {
            $query->where('year', $selectedYear);
        }

        // Build available years list based on current scope (children of parent or root)
        $yearsBase = Lpj::query();
        if ($parentId) {
            $yearsBase->where('parent_id', $parentId);
        } else {
            $yearsBase->whereNull('parent_id');
        }
        $availableYears = $yearsBase
            ->whereNotNull('year')
            ->select('year')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year');

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
            'parentId',
            'target',
            'current_budget',
            'kegiatan_count',
            'availableYears',
            'selectedYear'
        ));
    }

    // ... rest of your methods remain the same ...

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
            'volume' => 'nullable|string|max:255',
            'jumlah_harga_satuan' => 'nullable|numeric|min:0',
            'jumlah_harga' => 'required|numeric|min:0',
            'keterangan_tambahan' => 'nullable|string',
            'year' => 'nullable|integer|min:2000|max:2100',
            'foto_jurnal.*' => 'nullable|image|max:10240', // 10MB
            'dokumen_pendukung.*' => 'nullable|mimes:pdf,doc,docx,xls,xlsx|max:10240',
            'dokumen_lpj.*' => 'nullable|mimes:pdf,doc,docx,xls,xlsx|max:10240'
        ]);

        // Handle file uploads
        $fotoJurnal = $this->handleFileUploads($request, 'foto_jurnal', 'lpj/foto');
        $dokumenPendukung = $this->handleFileUploads($request, 'dokumen_pendukung', 'lpj/dokumen');
        $dokumenLpj = $this->handleFileUploads($request, 'dokumen_lpj', 'lpj/dokumen');

        $lpj = Lpj::create([
            'parent_id' => $parentId,
            'nama_program' => $validated['nama_program'],
            'nama_kegiatan' => $validated['nama_kegiatan'],
            'volume' => $validated['volume'],
            'jumlah_harga_satuan' => $validated['jumlah_harga_satuan'] ?? 0,
            'jumlah_harga' => $validated['jumlah_harga'] ?? 0,
            'keterangan_tambahan' => $validated['keterangan_tambahan'],
            'year' => $validated['year'] ?? now()->year,
            'foto_jurnal' => $fotoJurnal,
            'dokumen_pendukung' => $dokumenPendukung,
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

        if ($lpj->modifiable_by_user_id === Auth::id()) {
            $pengajuan = Pengajuan::where('lpj_id', $lpj->id)
                                    ->where('user_id', Auth::id())
                                    ->where('status', 'disetujui')
                                    ->orderBy('approved_at', 'desc')
                                    ->first();

            if (!$pengajuan || $pengajuan->token <= 0) {
                return response()->json(['success' => false, 'message' => 'Anda tidak memiliki izin untuk mengedit laporan ini lagi.'], 403);
            }
        } elseif (!Auth::user()->can('pengajuan-modifikasi-laporan')) {
            return response()->json(['success' => false, 'message' => 'Anda tidak memiliki izin untuk mengedit laporan ini.'], 403);
        }

        $validated = $request->validate([
            'nama_program' => 'required|string|max:255',
            'nama_kegiatan' => 'required|string|max:255',
            'volume' => 'nullable|string|max:255',
            'jumlah_harga_satuan' => 'nullable|numeric|min:0',
            'jumlah_harga' => 'required|numeric|min:0',
            'keterangan_tambahan' => 'nullable|string',
            'year' => 'nullable|integer|min:2000|max:2100',
            'foto_jurnal.*' => 'nullable|image|max:10240',
            'dokumen_pendukung.*' => 'nullable|mimes:pdf,doc,docx,xls,xlsx|max:10240',
            'dokumen_lpj.*' => 'nullable|mimes:pdf,doc,docx,xls,xlsx|max:10240',
            'existing_foto_jurnal' => 'nullable|array',
            'existing_dokumen_pendukung' => 'nullable|array',
            'existing_dokumen_lpj' => 'nullable|array',
        ]);

        // Handle existing files
        $existingFotoJurnal = $request->get('existing_foto_jurnal', []);
        $existingDokumenPendukung = $request->input('existing_dokumen_pendukung', []);
        $existingDokumenLpj = $request->get('existing_dokumen_lpj', []);

        // Delete removed files
        if ($lpj->foto_jurnal) {
            foreach ($lpj->foto_jurnal as $foto) {
                if (!in_array($foto, $existingFotoJurnal)) {
                    Storage::delete($foto);
                }
            }
        }

        if ($lpj->dokumen_pendukung) { // Fixed typo here
            foreach ($lpj->dokumen_pendukung as $dokumen) {
                if (!in_array($dokumen, $existingDokumenPendukung)) {
                    Storage::delete($dokumen);
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
        $newDokumenPendukung = $this->handleFileUploads($request, 'dokumen_pendukung', 'lpj/dokumen');
        $newDokumenLpj = $this->handleFileUploads($request, 'dokumen_lpj', 'lpj/dokumen');

        // Merge existing and new files
        $allFotoJurnal = array_merge($existingFotoJurnal, $newFotoJurnal);
        $allDokumenPendukung = array_merge($existingDokumenPendukung, $newDokumenPendukung);
        $allDokumenLpj = array_merge($existingDokumenLpj, $newDokumenLpj);

        $lpj->update([
            'nama_program' => $validated['nama_program'],
            'nama_kegiatan' => $validated['nama_kegiatan'],
            'volume' => $validated['volume'],
            'jumlah_harga_satuan' => $validated['jumlah_harga_satuan'] ?? 0,
            'jumlah_harga' => $validated['jumlah_harga'] ?? 0,
            'keterangan_tambahan' => $validated['keterangan_tambahan'],
            'year' => $validated['year'] ?? $lpj->year ?? now()->year,
            'foto_jurnal' => $allFotoJurnal,
            'dokumen_pendukung' => $allDokumenPendukung,
            'dokumen_lpj' => $allDokumenLpj,
        ]);

        if ($lpj->modifiable_by_user_id === Auth::id()) {
            $pengajuan->token -= 1;
            $pengajuan->save();
        }

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

            if ($lpj->modifiable_by_user_id === Auth::id()) {
                $pengajuan = Pengajuan::where('lpj_id', $lpj->id)
                                        ->where('user_id', Auth::id())
                                        ->where('status', 'disetujui')
                                        ->orderBy('approved_at', 'desc')
                                        ->first();

                if (!$pengajuan || $pengajuan->token <= 0) {
                    return response()->json(['success' => false, 'message' => 'Anda tidak memiliki izin untuk menghapus laporan ini lagi.'], 403);
                }
            } elseif (!Auth::user()->can('pengajuan-modifikasi-laporan')) {
                return response()->json(['success' => false, 'message' => 'Anda tidak memiliki izin untuk menghapus laporan ini.'], 403);
            }

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

            if ($lpj->modifiable_by_user_id === Auth::id()) {
                $pengajuan->token -= 1;
                $pengajuan->save();
            }

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
     * Export specific LPJ data to PDF with letterhead
     */
    public function exportPdf($id)
    {
        try {
            $lpj = Lpj::findOrFail($id);

            // Create initial PDF with letterhead and content
            $pdf = Pdf::loadView('admin.laporan-lpj.bidang_new.dynamic.pdf-export', compact('lpj'));
            $pdf->setPaper('A4', 'portrait');

            // Generate initial PDF content
            $tempMainFile = tempnam(sys_get_temp_dir(), 'main_pdf_');
            file_put_contents($tempMainFile, $pdf->output());

            // Initialize FPDI for PDF merging
            $fpdi = new Fpdi();

            // Add main content pages
            $pageCount = $fpdi->setSourceFile($tempMainFile);
            for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                $templateId = $fpdi->importPage($pageNo, PageBoundaries::MEDIA_BOX);
                $fpdi->AddPage();
                $fpdi->useTemplate($templateId);
            }

            // Merge PDF attachments (dokumen_pendukung only, excluding dokumen_lpj)
            if ($lpj->dokumen_pendukung && count($lpj->dokumen_pendukung) > 0) {
                foreach ($lpj->dokumen_pendukung as $dokumen) {
                    $filePath = storage_path('app/public/' . $dokumen);

                    if (file_exists($filePath)) {
                        $fileExtension = strtolower(pathinfo($dokumen, PATHINFO_EXTENSION));

                        // Only merge PDF files
                        if ($fileExtension === 'pdf') {
                            try {
                                $attachmentPageCount = $fpdi->setSourceFile($filePath);

                                for ($pageNo = 1; $pageNo <= $attachmentPageCount; $pageNo++) {
                                    $templateId = $fpdi->importPage($pageNo, PageBoundaries::MEDIA_BOX);
                                    $fpdi->AddPage();
                                    $fpdi->useTemplate($templateId);
                                }
                            } catch (\Exception $e) {
                                // Log error but continue with other files
                                \Log::warning("Could not merge PDF file: {$dokumen}. Error: " . $e->getMessage());
                            }
                        }
                    }
                }
            }

            // Clean up temporary file
            unlink($tempMainFile);

            // Generate final PDF
            $finalPdf = $fpdi->Output('S');

            // Generate filename
            $filename = 'Laporan_' . Str::slug($lpj->nama_program) . '_' . date('Y-m-d') . '.pdf';

            return response($finalPdf, 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
                'Content-Length' => strlen($finalPdf)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error generating PDF: ' . $e->getMessage()
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
        try {
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

            // Create initial PDF with letterhead and content
            $pdf = Pdf::loadView('admin.laporan-lpj.bidang_new.dynamic.pdf-export-all', compact('lpjData'));
            $pdf->setPaper('A4', 'portrait');

            // Generate initial PDF content
            $tempMainFile = tempnam(sys_get_temp_dir(), 'main_pdf_');
            file_put_contents($tempMainFile, $pdf->output());

            // Initialize FPDI for PDF merging
            $fpdi = new Fpdi();

            // Add main content pages
            $pageCount = $fpdi->setSourceFile($tempMainFile);
            for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                $templateId = $fpdi->importPage($pageNo, PageBoundaries::MEDIA_BOX);
                $fpdi->AddPage();
                $fpdi->useTemplate($templateId);
            }

            // Merge PDF attachments from all LPJ documents
            foreach ($lpjData as $lpj) {
                if ($lpj->dokumen_pendukung && count($lpj->dokumen_pendukung) > 0) {
                    foreach ($lpj->dokumen_pendukung as $dokumen) {
                        $filePath = storage_path('app/public/' . $dokumen);

                        if (file_exists($filePath)) {
                            $fileExtension = strtolower(pathinfo($dokumen, PATHINFO_EXTENSION));

                            // Only merge PDF files
                            if ($fileExtension === 'pdf') {
                                try {
                                    $attachmentPageCount = $fpdi->setSourceFile($filePath);

                                    for ($pageNo = 1; $pageNo <= $attachmentPageCount; $pageNo++) {
                                        $templateId = $fpdi->importPage($pageNo, PageBoundaries::MEDIA_BOX);
                                        $fpdi->AddPage();
                                        $fpdi->useTemplate($templateId);
                                    }
                                } catch (\Exception $e) {
                                    // Log error but continue with other files
                                    \Log::warning("Could not merge PDF file: {$dokumen}. Error: " . $e->getMessage());
                                }
                            }
                        }
                    }
                }
            }

            // Clean up temporary file
            unlink($tempMainFile);

            // Generate final PDF
            $finalPdf = $fpdi->Output('S');

            // Generate filename
            $filename = 'Laporan_LPJ_All_' . date('Y-m-d') . '.pdf';

            return response($finalPdf, 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
                'Content-Length' => strlen($finalPdf)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error generating PDF: ' . $e->getMessage()
            ], 500);
        }
    }
}
