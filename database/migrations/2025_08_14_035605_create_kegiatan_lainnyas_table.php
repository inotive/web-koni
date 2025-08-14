<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('kegiatan_lainnya', function (Blueprint $table) {
            $table->id();
            $table->string('nama_program_kegiatan');
            $table->string('jenis_kegiatan');
            $table->date('tanggal_kegiatan');
            $table->string('volume');
            $table->decimal('jumlah_harga_satuan', 15, 2);
            $table->decimal('jumlah_harga', 15, 2);
            $table->string('foto_jurnal')->nullable();
            $table->string('dokumen_pendukung')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kegiatan_lainnya');
    }
};