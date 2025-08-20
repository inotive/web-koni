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
        Schema::create('PORDASI', function (Blueprint $table) {
            $table->id();
            $table->string('nama_program');
            $table->string('nama_kegiatan');
            $table->string('volume');
            $table->bigInteger('jumlah_harga_satuan');
            $table->bigInteger('jumlah_harga');
            $table->json('dokumen_lpj')->nullable();
            $table->json('foto_jurnal')->nullable();
            $table->text('keterangan_tambahan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('PORDASI');
    }
};
