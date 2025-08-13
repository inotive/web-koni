<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surat', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kegiatan');
            $table->string('no_surat')->unique();
            $table->enum('jenis_surat', ['masuk', 'keluar']);
            $table->string('dokumen_surat')->nullable();
            $table->timestamps();
            
            $table->index(['jenis_surat', 'created_at']);
            $table->index('no_surat');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat');
    }
};