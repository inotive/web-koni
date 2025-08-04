<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\ManajemenRKA;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ManajemenRKAController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ManajemenRKA::query();

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

        try {
            DB::beginTransaction();

            ManajemenRKA::create([
                'name' => $request->judul,
            ]);

            DB::commit();

            session()->flash('OK', 'Folder Berhasil Dibuat');

            return response()->json([
                'success' => true,
                'message' => 'Folder berhasil dibuat',
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
    public function show(ManajemenRKA $manajemenRKA)
    {
        //
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
    public function update(ManajemenRKA $manajemenRKA)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ManajemenRKA $manajemenRKA)
    {
        //
    }
}
