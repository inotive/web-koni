<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\LaporanRKA;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class LaporanRKAController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
            'rka_id' => 'required|exists:manajemen_rkas,id',
            'total_anggaran' => 'required|max:255',
            'file' => 'required|mimes:pdf|max:10240',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();

        try {
            $file = $request->file('file');
            $file_size = $file->getSize();
            $file_path = $file->store('laporan_rka', 'public');
            $name = $file->getClientOriginalName();

            LaporanRKA::create([
                'manajemen_rka_id' => $request->rka_id,
                'total_anggaran' => (int) str_replace('.', '', $request->total_anggaran),
                'file_size' => $file_size,
                'file_path' => $file_path,
                'name' => $name,
            ]);

            DB::commit();

            session()->flash('OK', 'Laporan Berhasil Disimpan.');

            return response()->json([
                'success' => true,
                'message' => 'Laporan Berhasil Disimpan.',
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, String $id)
    {
        $validator = Validator::make($request->all(), [
            'total_anggaran' => 'required|string|max:255',
            'file' => 'mimes:pdf|max:10240',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();

        try {
            $laporan = LaporanRKA::findOrFail($id);

            $data = [
                'total_anggaran' => (int) str_replace('.', '', $request->total_anggaran),
            ];

            if ($request->hasFile('file')) {
                Storage::disk('public')->delete($laporan->file_path);

                $file = $request->file('file');
                $file_path = $file->store('laporan_rka', 'public');

                $data['file_path'] = $file_path;
                $data['file_size'] = $file->getSize();
                $data['name'] = $file->getClientOriginalName();
            }

            $laporan->update($data);

            DB::commit();

            session()->flash('OK', 'Laporan Berhasil Diperbarui.');

            return response()->json([
                'success' => true,
                'message' => 'Laporan Berhasil Diperbarui.',
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
    public function destroy(string $id)
    {
        $data = LaporanRKA::find($id);

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Laporan tidak ditemukan.'
            ], 404);
        }

        $data->delete();

        return response()->json([
            'success' => true,
            'message' => 'Laporan berhasil dihapus.'
        ], 200);
    }
}
