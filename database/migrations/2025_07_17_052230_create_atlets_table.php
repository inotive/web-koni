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
Schema::create('atlets', function (Blueprint $table) {
    $table->id();
    $table->string('nama');
    $table->string('cabor');
    $table->string('tempat_lahir');
    $table->date('tanggal_lahir');
    $table->text('alamat');
    $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
    $table->text('prestasi_terbaru')->nullable();
    $table->string('no_telepon')->nullable();
    $table->string('email')->nullable();
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('atlets');
    }
};
