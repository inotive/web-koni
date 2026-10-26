<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surat_penomoran', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('format');
            $table->unsignedTinyInteger('digit')->default(3);
            $table->enum('reset_period', ['tahunan', 'bulanan', 'tidak'])->default('tahunan');
            $table->enum('scope', ['bersama', 'per_kode'])->default('bersama');
            $table->boolean('editable')->default(true);
            $table->enum('berlaku_untuk', ['keluar', 'masuk'])->default('keluar');
            $table->boolean('is_default')->default(false);
            $table->boolean('is_active')->default(true);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });

        Schema::create('surat_penomoran_counter', function (Blueprint $table) {
            $table->id();
            $table->foreignId('surat_penomoran_id')->constrained('surat_penomoran')->cascadeOnDelete();
            $table->string('periode', 7);
            $table->string('kode', 50)->default('');
            $table->unsignedInteger('last_number')->default(0);
            $table->timestamps();

            $table->unique(['surat_penomoran_id', 'periode', 'kode'], 'surat_penomoran_counter_unique');
        });

        Schema::create('surat_template', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('kode', 50);
            $table->string('kode_klasifikasi', 50)->nullable();
            $table->foreignId('surat_penomoran_id')->nullable()->constrained('surat_penomoran')->nullOnDelete();
            $table->string('kop_surat')->nullable();
            $table->longText('isi');
            $table->json('fields')->nullable();
            $table->boolean('tampilkan_ttd')->default(true);
            $table->string('penandatangan_nama')->nullable();
            $table->string('penandatangan_jabatan')->nullable();
            $table->string('penandatangan_nip')->nullable();
            $table->string('ttd')->nullable();
            $table->string('kota_surat')->nullable();
            $table->enum('ukuran_kertas', ['a4', 'f4'])->default('a4');
            $table->boolean('is_active')->default(true);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });

        Schema::table('surat', function (Blueprint $table) {
            $table->string('sumber', 20)->default('upload')->after('jenis_surat');
            $table->date('tanggal_surat')->nullable()->after('no_surat');
            $table->string('no_agenda')->nullable()->unique()->after('tanggal_surat');
            $table->foreignId('surat_template_id')->nullable()->after('sumber')->constrained('surat_template')->nullOnDelete();
            $table->foreignId('surat_penomoran_id')->nullable()->after('surat_template_id')->constrained('surat_penomoran')->nullOnDelete();
            $table->json('data_template')->nullable()->after('surat_penomoran_id');
        });
    }

    public function down(): void
    {
        Schema::table('surat', function (Blueprint $table) {
            $table->dropConstrainedForeignId('surat_template_id');
            $table->dropConstrainedForeignId('surat_penomoran_id');
            $table->dropUnique(['no_agenda']);
            $table->dropColumn(['sumber', 'tanggal_surat', 'no_agenda', 'data_template']);
        });

        Schema::dropIfExists('surat_template');
        Schema::dropIfExists('surat_penomoran_counter');
        Schema::dropIfExists('surat_penomoran');
    }
};
