<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\LaporanRKA;
use App\Models\ManajemenRKA;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use PhpParser\Node\Expr\Cast\String_;
use Illuminate\Support\Facades\Validator;

class ManajemenRKAController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ManajemenRKA::with('laporans');

        $search = $request->search;
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        $sortBy = $request->input('sortBy', 'ASC');

        $data = $query->orderBy('name', $sortBy)->get();

        if ($request->ajax()) {
            return view('admin.manajemen-rka.components.table-grid', compact('data'))->render();
        }

        return view('admin.manajemen-rka.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();

        try {
            ManajemenRKA::create([
                'name' => $request->judul,
            ]);

            DB::commit();

            session()->flash('OK', 'Folder Berhasil Dibuat.');

            return response()->json([
                'success' => true,
                'message' => 'Folder berhasil dibuat.',
            ]);
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'errors' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, String $id)
    {
        $data = ManajemenRKA::with('laporans')->findOrFail($id);

        $sortBy = $request->input('sortBy', 'DESC');
        $query = LaporanRKA::where('manajemen_rka_id', $id)
            ->orderBy('id', $sortBy);

        $search = $request->search;
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        $perPage = $request->input('per_page', 10);
        $laporan = $query->paginate($perPage);

        if ($request->ajax()) {
            return view('admin.manajemen-rka.components.table-laporan', compact('data', 'laporan'))->render();
        }

        return view('admin.manajemen-rka.show', compact('data', 'laporan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ManajemenRKA $manajemenRKA)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, String $id)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();
            $data = ManajemenRKA::findOrFail($id);

            $data->name = $request->judul;
            $data->save();
            DB::commit();

            session()->flash('OK', 'Berhasil mengubah nama folder.');

            return response()->json([
                'success' => true,
                'message' => 'Berhasil mengubah nama folder.',
            ]);
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'errors' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $id)
    {
        $data = ManajemenRKA::find($id);

        if ($data) {
            if ($data->laporans->count() > 0) {
                return redirect()->back()->with('ERR', 'Folder memiliki laporan!');
            }

            $data->delete();
            return redirect()->back()->with('OK', 'Folder berhasil dihapus.');
        } else {
            return redirect()->back()->with('ERR', 'Folder tidak ditemukan.');
        }
    }
}
