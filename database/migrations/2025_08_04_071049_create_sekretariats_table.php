<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sekretariat', function (Blueprint $table) {
            $table->id();
            $table->string('nama_program_kegiatan');
            $table->string('jenis_kegiatan');
            $table->string('keterangan_tambahan');
            $table->string('volume');
            $table->decimal('jumlah_harga_satuan', 15, 2);
            $table->decimal('jumlah_harga', 15, 2);
            $table->string('foto_jurnal')->nullable();
            $table->string('dokumen_pendukung')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sekretariat');
    }
};
