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
        Schema::table('file_kesekretariats', function (Blueprint $table) {
            $table->index('nama_dokumen');
            $table->index('dokumen_file');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('file_kesekretariats', function (Blueprint $table) {
            $table->dropIndex(['nama_dokumen']);
            $table->dropIndex(['dokumen_file']);
        });
    }
};