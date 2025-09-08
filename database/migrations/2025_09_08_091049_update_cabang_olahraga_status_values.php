<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update existing records with status 'Tidak Aktif' to 'Pembinaan'
        DB::table('cabang_olahragas')
            ->where('status', 'Tidak Aktif')
            ->update(['status' => 'Pembinaan']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert 'Pembinaan' back to 'Tidak Aktif'
        DB::table('cabang_olahragas')
            ->where('status', 'Pembinaan')
            ->update(['status' => 'Tidak Aktif']);
    }
};
