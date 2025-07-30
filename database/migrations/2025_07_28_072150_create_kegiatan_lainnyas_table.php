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
        Schema::create('kegiatan_lainnya', function (Blueprint $table) {
            $table->id(); // Kolom ID auto-incrementing primary key
            $table->string('nama_program_kegiatan'); // Nama program atau kegiatan, tipe string
            $table->string('jenis_kegiatan'); // Jenis kegiatan, tipe string
            $table->date('tanggal_kegiatan'); // Tanggal kegiatan, tipe date
            $table->string('volume'); // Volume (misal: "10 unit", "2 hari"), tipe string
            $table->decimal('jumlah_harga_satuan', 15, 2); // Jumlah harga per satuan, tipe decimal (total 15 digit, 2 di belakang koma)
            $table->decimal('jumlah_harga', 15, 2); // Total jumlah harga, tipe decimal
            $table->string('foto_jurnal')->nullable(); // Path/lokasi file foto jurnal, bisa kosong (nullable)
            $table->string('dokumen_pendukung')->nullable(); // Path/lokasi file dokumen pendukung, bisa kosong (nullable)
            $table->timestamps(); // Kolom `created_at` dan `updated_at` (timestamp)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kegiatan_lainnya'); // Menghapus tabel jika migrasi di-rollback
    }
};