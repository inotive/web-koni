<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surat_kop', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->enum('jenis', ['gambar', 'susun'])->default('gambar');
            $table->string('gambar')->nullable();
            $table->string('logo_kiri')->nullable();
            $table->string('logo_kanan')->nullable();
            $table->json('baris')->nullable();
            $table->enum('garis', ['tidak', 'tunggal', 'ganda'])->default('ganda');
            $table->boolean('is_default')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::table('surat_template', function (Blueprint $table) {
            $table->boolean('tampilkan_kop')->default(true)->after('kop_surat');
            $table->foreignId('surat_kop_id')->nullable()->after('tampilkan_kop')->constrained('surat_kop')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('surat_template', function (Blueprint $table) {
            $table->dropConstrainedForeignId('surat_kop_id');
            $table->dropColumn('tampilkan_kop');
        });

        Schema::dropIfExists('surat_kop');
    }
};
