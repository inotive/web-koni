<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('lpj', function (Blueprint $table) {
            $table->decimal('target_anggaran', 15, 2)->nullable()->after('jumlah_harga');
            $table->integer('target_kegiatan')->nullable()->after('target_anggaran');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lpj', function (Blueprint $table) {
            $table->dropColumn(['target_anggaran', 'target_kegiatan']);
        });
    }
};
