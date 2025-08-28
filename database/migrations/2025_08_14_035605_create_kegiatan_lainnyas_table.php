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
            $table->string('volume');
            $table->decimal('jumlah_harga_satuan', 15, 2);
            $table->decimal('jumlah_harga', 15, 2);
            $table->string('foto_jurnal')->nullable();
            $table->string('dokumen_pendukung')->nullable();
            
            // Kolom yang hilang - sesuaikan dengan controller dan model
            $table->text('keterangan_tambahan')->nullable();
            $table->enum('status_approval', ['pending', 'approved', 'rejected'])->default('pending');
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->text('catatan_approval')->nullable(); // sesuaikan dengan controller
            $table->text('approval_notes')->nullable(); // sesuaikan dengan model
            
            $table->timestamps();
            
            // Foreign key constraint
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('kegiatan_lainnya');
    }
};