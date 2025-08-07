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
    Schema::table('atlets', function (Blueprint $table) {
        // Pastikan tidak ada data penting sebelum menghapus
        if (Schema::hasColumn('atlets', 'prestasi_terbaru')) {
            $table->dropColumn('prestasi_terbaru');
        }
    });
}

public function down(): void
{
    Schema::table('atlets', function (Blueprint $table) {
        $table->text('prestasi_terbaru')->nullable();
    });
}
};

