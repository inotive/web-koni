<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KegiatanLainnya extends Model
{
    use HasFactory;

    protected $table = 'kegiatan_lainnya'; // Pastikan nama tabelnya benar jika tidak standar Laravel

    protected $fillable = [
        'nama_program_kegiatan',
        'jenis_kegiatan',
        'tanggal_kegiatan',
        'volume',
        'jumlah_harga_satuan',
        'jumlah_harga',
        'foto_jurnal',
        'dokumen_pendukung',
    ];

    // Jika Anda ingin mengelola tanggal secara otomatis oleh Carbon
    protected $dates = ['tanggal_kegiatan'];
}