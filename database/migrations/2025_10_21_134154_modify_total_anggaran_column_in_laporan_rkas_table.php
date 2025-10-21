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
        Schema::table('laporan_rkas', function (Blueprint $table) {
            $table->decimal('total_anggaran', 20, 0)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('laporan_rkas', function (Blueprint $table) {
            $table->unsignedBigInteger('total_anggaran')->change();
        });
    }
};
