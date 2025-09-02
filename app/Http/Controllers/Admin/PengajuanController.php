<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lpj;
use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PengajuanController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengajuan::with(['lpj', 'user']);

        // Sorting
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');

        $allowedSortFields = ['nama_program', 'user', 'status', 'created_at', 'approved_at'];
        if (!in_array($sortField, $allowedSortFields)) {
            $sortField = 'created_at';
        }

        if (!in_array($sortDirection, ['asc', 'desc'])) {
            $sortDirection = 'desc';
        }

        if ($sortField === 'nama_program') {
            $query->orderBy(
                Lpj::select('nama_program')
                    ->whereColumn('lpj.id', 'pengajuans.lpj_id'),
                $sortDirection
            );
        } elseif ($sortField === 'user') {
            $query->orderBy(
                \App\Models\User::select('username')
                    ->whereColumn('users.id', 'pengajuans.user_id'),
                $sortDirection
            );
        } else {
            $query->orderBy($sortField, $sortDirection);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->whereHas('lpj', function ($q2) use ($search) {
                    $q2->where('nama_program', 'like', "%{$search}%")
                    ->orWhere('nama_kegiatan', 'like', "%{$search}%");
                })
                ->orWhereHas('user', function ($q2) use ($search) {
                    $q2->where('username', 'like', "%{$search}%");
                });
            });
        }

        // Pagination
        $perPage = (int) $request->get('per_page', 10);
        $allowedPerPage = [10, 25, 50, 100];
        if (!in_array($perPage, $allowedPerPage)) {
            $perPage = 10;
        }

        try {
            $pengajuans = $query->paginate($perPage)->appends($request->query());
        } catch (\Exception $e) {
            \Log::error('Pengajuan query error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }

        if ($request->ajax()) {
            return view('admin.laporan-lpj.pengajuan._table', compact('pengajuans'))->render();
        }

        return view('admin.laporan-lpj.pengajuan.index', compact('pengajuans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'lpj_id' => 'required|exists:lpj,id',
            'alasan' => 'required|string|max:1000',
            'user_id' => 'required|exists:users,id',
        ]);

        $existingPengajuan = Pengajuan::where('lpj_id', $request->lpj_id)
                                        ->where('status', 'menunggu persetujuan')
                                        ->exists();

        if ($existingPengajuan) {
            return response()->json(['success' => false, 'message' => 'Pengajuan untuk laporan ini sudah ada dan sedang menunggu persetujuan.']);
        }

        Pengajuan::create([
            'lpj_id' => $request->lpj_id,
            'user_id' => $request->user_id,
            'alasan' => $request->alasan,
        ]);

        return response()->json(['success' => true]);
    }

    public function updateStatus(Request $request, Pengajuan $pengajuan)
    {
        $request->validate([
            'status' => 'required|in:disetujui,ditolak',
        ]);

        if (!Auth::user()->can('pengajuan-modifikasi-laporan')) {
            return response()->json(['success' => false, 'message' => 'Anda tidak memiliki izin.'], 403);
        }

        $pengajuan->status      = $request->status;
        $pengajuan->approved_by = Auth::id();

        $nowGmt8 = Carbon::now('Asia/Singapore'); // GMT+8

        if (in_array($request->status, ['disetujui', 'ditolak'])) {
            $pengajuan->approved_at = $nowGmt8;
        } else {
            $pengajuan->approved_at = null;
        }

        if ($request->status === 'disetujui') {
            $pengajuan->token = 1;
            $lpj = Lpj::find($pengajuan->lpj_id);
            if ($lpj) {
                $lpj->modifiable_by_user_id = $pengajuan->user_id;
                $lpj->save();
            }
        }
        
        $pengajuan->save();

        return response()->json(['success' => true, 'message' => 'Status pengajuan berhasil diperbarui.']);
    }
}
