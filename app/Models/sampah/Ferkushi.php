<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FERKUSHI extends Model
{
    protected $table = 'FERKUSHI';

    protected $fillable = [
        'nama_program',
        'nama_kegiatan',
        'volume',
        'jumlah_harga_satuan',
        'jumlah_harga',
        'dokumen_lpj',
        'foto_jurnal',
        'keterangan_tambahan',
    ];

    protected $casts = [
        'dokumen_lpj' => 'array',
        'foto_jurnal' => 'array',
    ];
}
