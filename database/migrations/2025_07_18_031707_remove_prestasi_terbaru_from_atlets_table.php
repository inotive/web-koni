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
        $table->dropColumn('prestasi_terbaru');
    });
}

public function down(): void // Jika Anda perlu membatalkan (rollback)
{
    Schema::table('atlets', function (Blueprint $table) {
        $table->text('prestasi_terbaru')->nullable();
    });
}
};
