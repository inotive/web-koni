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
    Schema::create('atlets', function (Blueprint $table) {
        $table->id();
        $table->foreignId('cabang_olahraga_id')->constrained()->onDelete('cascade');
        $table->string('nama');
        $table->string('jenis_kelamin');
        $table->date('tanggal_lahir')->nullable();
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
