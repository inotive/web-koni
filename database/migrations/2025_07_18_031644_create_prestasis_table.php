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
    Schema::create('prestasis', function (Blueprint $table) {
        $table->id();
        $table->foreignId('atlet_id')->constrained()->onDelete('cascade');
        $table->string('nama_prestasi');
        $table->string('tempat');
        $table->year('tahun');
        $table->enum('medali', ['Emas', 'Perak', 'Perunggu']);
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prestasis');
    }
};
