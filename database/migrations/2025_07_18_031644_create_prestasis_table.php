<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
Schema::create('prestasis', function (Blueprint $table) {
    $table->id();
    $table->string('nama_prestasi');
    $table->string('tempat');
    $table->integer('tahun');
    $table->enum('medali', ['Emas', 'Perak', 'Perunggu']);
    $table->string('tingkat');
    $table->unsignedBigInteger('cabor_id')->nullable();

    $table->unsignedBigInteger('subject_id');
    $table->string('subject_type');

    $table->timestamps();

    $table->index(['subject_id', 'subject_type']);
});
    }

    public function down()
    {
        Schema::dropIfExists('prestasis');
    }
};
