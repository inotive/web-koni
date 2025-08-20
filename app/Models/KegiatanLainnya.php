<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KegiatanLainnya extends Model
{
    use HasFactory;

    protected $table = 'kegiatan_lainnya';

    protected $fillable = [
        'nama_program_kegiatan',
        'jenis_kegiatan',
        'tanggal_kegiatan',
        'volume',
        'jumlah_harga_satuan',
        'jumlah_harga',
        'foto_jurnal',
        'dokumen_pendukung'
    ];

    protected $dates = [
        'tanggal_kegiatan',
        'created_at',
        'updated_at'
    ];
}