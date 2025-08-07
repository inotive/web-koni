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
        Schema::create('laporan_rkas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('manajemen_rka_id')->nullable()->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('total_anggaran');
            $table->unsignedBigInteger('file_size');
            $table->string('file_path');
            $table->string('name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_rkas');
    }
};
