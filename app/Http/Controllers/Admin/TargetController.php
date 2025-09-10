<?php

namespace App\Http\Controllers\Admin;

use App\Models\Target;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class TargetController extends Controller
{
    public function storeOrUpdate(Request $request)
    {
        $request->validate([
            'id_lpj' => 'required|exists:lpj,id',
            'target_anggaran' => 'required|numeric|min:0',
            'target_kegiatan' => 'required|numeric|min:0',
        ]);

        try {
            $target = Target::updateOrCreate(
                ['id_lpj' => $request->id_lpj],
                [
                    'target_anggaran' => $request->target_anggaran,
                    'target_kegiatan' => $request->target_kegiatan,
                ]
            );

            Log::info('Target updated successfully', [
                'id_lpj' => $request->id_lpj,
                'target_anggaran' => $request->target_anggaran,
                'target_kegiatan' => $request->target_kegiatan,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Target berhasil diperbarui.',
                'target' => $target // Changed from 'data' to 'target'
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to update target', [
                'error' => $e->getMessage(),
                'id_lpj' => $request->id_lpj
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui target: ' . $e->getMessage()
            ], 500);
        }
    }
}
