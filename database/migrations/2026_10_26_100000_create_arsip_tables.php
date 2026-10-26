<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Lokasi penyimpanan bertingkat: gedung > ruang > rak > baris > box
        Schema::create('arsip_lokasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable()->constrained('arsip_lokasi')->restrictOnDelete();
            $table->enum('tipe', ['gedung', 'ruang', 'rak', 'baris', 'box']);
            $table->string('kode', 50);
            $table->string('nama');
            $table->unsignedInteger('kapasitas')->nullable();
            $table->text('keterangan')->nullable();
            $table->boolean('is_aktif')->default(true);
            $table->timestamps();

            $table->unique(['parent_id', 'kode']);
            $table->index('tipe');
        });

        // Klasifikasi arsip + Jadwal Retensi Arsip (JRA)
        Schema::create('arsip_kategori', function (Blueprint $table) {
            $table->id();
            $table->string('kode_klasifikasi', 50)->unique();
            $table->string('nama');
            $table->unsignedSmallInteger('retensi_aktif_tahun')->default(1);
            $table->unsignedSmallInteger('retensi_inaktif_tahun')->default(1);
            $table->enum('tindakan_akhir', ['musnah', 'permanen', 'dinilai_kembali'])->default('musnah');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });

        Schema::create('arsip', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_arsip', 50)->unique();
            $table->string('judul');
            $table->text('uraian')->nullable();
            $table->foreignId('arsip_kategori_id')->nullable()->constrained('arsip_kategori')->nullOnDelete();
            $table->foreignId('arsip_lokasi_id')->nullable()->constrained('arsip_lokasi')->restrictOnDelete();
            $table->date('tanggal_arsip');
            $table->unsignedInteger('jumlah')->default(1);
            $table->string('satuan', 20)->default('berkas');
            $table->enum('media', ['fisik', 'digital', 'keduanya'])->default('fisik');
            $table->enum('tingkat_perkembangan', ['asli', 'salinan', 'tembusan'])->default('asli');
            $table->enum('status', ['aktif', 'inaktif', 'dipinjam', 'dimusnahkan', 'permanen'])->default('aktif');
            $table->string('file_path')->nullable();
            $table->nullableMorphs('sumber');
            $table->text('keterangan')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['status', 'tanggal_arsip']);
        });

        Schema::create('arsip_peminjaman', function (Blueprint $table) {
            $table->id();
            $table->foreignId('arsip_id')->constrained('arsip')->cascadeOnDelete();
            $table->string('nama_peminjam');
            $table->string('unit_peminjam')->nullable();
            $table->date('tanggal_pinjam');
            $table->date('tanggal_rencana_kembali');
            $table->date('tanggal_kembali')->nullable();
            $table->enum('status', ['dipinjam', 'dikembalikan'])->default('dipinjam');
            $table->string('status_arsip_sebelum', 20)->default('aktif');
            $table->text('catatan')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['status', 'tanggal_rencana_kembali']);
        });

        Schema::create('arsip_mutasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('arsip_id')->constrained('arsip')->cascadeOnDelete();
            $table->foreignId('lokasi_asal_id')->nullable()->constrained('arsip_lokasi')->nullOnDelete();
            $table->foreignId('lokasi_tujuan_id')->nullable()->constrained('arsip_lokasi')->nullOnDelete();
            $table->string('alasan')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('arsip_pemusnahan', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_berita_acara', 100)->unique();
            $table->date('tanggal');
            $table->enum('jenis', ['musnah', 'permanen']);
            $table->text('keterangan')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::table('arsip', function (Blueprint $table) {
            $table->foreignId('arsip_pemusnahan_id')->nullable()->after('status')
                ->constrained('arsip_pemusnahan')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('arsip', function (Blueprint $table) {
            $table->dropConstrainedForeignId('arsip_pemusnahan_id');
        });
        Schema::dropIfExists('arsip_pemusnahan');
        Schema::dropIfExists('arsip_mutasi');
        Schema::dropIfExists('arsip_peminjaman');
        Schema::dropIfExists('arsip');
        Schema::dropIfExists('arsip_kategori');
        Schema::dropIfExists('arsip_lokasi');
    }
};
