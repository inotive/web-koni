<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_xx_xx_create_cabang_olahragas_table.php
public function up()
{
    Schema::create('cabang_olahragas', function (Blueprint $table) {
        $table->id();
        $table->string('nama_cabor', 50);
        $table->string('ketua_penanggung_jawab', 100);
        $table->enum('status', ['Aktif', 'Tidak Aktif']);
        $table->date('tanggal_pembentukan');
        $table->integer('jumlah_atlet');
        $table->integer('jumlah_pelatih');
        $table->string('icon_cabor')->nullable(); // <-- Add this line for the icon path
        $table->timestamp('terakhir_update')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cabang_olahragas');
    }
};
