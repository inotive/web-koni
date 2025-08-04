<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('cabang_olahragas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_cabor', 50);
            $table->string('ketua_penanggung_jawab', 100);
            $table->enum('status', ['Aktif', 'Tidak Aktif'])->default('Aktif');
            $table->date('tanggal_pembentukan');
            $table->integer('jumlah_atlet')->default(0);
            $table->integer('jumlah_pelatih')->default(0);
            $table->string('icon_cabor')->nullable();
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