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
        // UBAH NAMA TABEL MENJADI BENTUK JAMAK DI SINI
        Schema::create('kegiatan_lainnyas', function (Blueprint $table) {
            $table->id(); // This will serve as your 'No' column (primary key, auto-incrementing)
            $table->string('nama_program_kegiatan'); // For 'Nama Program & Kegiatan'
            $table->integer('volume')->nullable(); // For 'Volume', assuming it's a number
            $table->decimal('jumlah_harga_satuan', 10, 2)->nullable(); // For 'Jumlah harga Satuan', decimal for currency
            $table->decimal('jumlah_harga', 12, 2)->nullable(); // For 'Jumlah harga', decimal for currency
            $table->string('foto_jurnal_path')->nullable(); // For 'Foto Jurnal', storing the file path
            $table->string('dokumen_path')->nullable(); // For 'Dokumen', storing the file path
            $table->timestamps(); // Adds 'created_at' and 'updated_at' columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // UBAH NAMA TABEL MENJADI BENTUK JAMAK DI SINI JUGA
        Schema::dropIfExists('kegiatan_lainnyas');
    }
};