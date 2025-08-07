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
        Schema::table('pelatih', function (Blueprint $table) {
            $table->string('alamatkota');
            $table->string('alamatprovinsi');
            $table->enum('ketersediaan', ['Tersedia', 'Tidak-Tersedia'])->default('Tersedia');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
