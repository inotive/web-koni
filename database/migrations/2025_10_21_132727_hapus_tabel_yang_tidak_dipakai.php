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
        schema::dropIfExists('HubunganLembaga');
        schema::dropIfExists('Kesehatan');
        schema::dropIfExists('Organisasi');
        schema::dropIfExists('PembinaanHukum');
        schema::dropIfExists('PerencanaanProgram');
        schema::dropIfExists('SportScience');
        schema::dropIfExists('sumber_daya');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
