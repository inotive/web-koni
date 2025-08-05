<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sekretariat extends Model
{
    use HasFactory;

    protected $table = 'sekretariat';
    protected $fillable = [
        'nama_program_kegiatan',
        'jenis_kegiatan',
        'keterangan_tambahan',
        'volume',
        'jumlah_harga_satuan',
        'jumlah_harga',
        'foto_jurnal',
        'dokumen_pendukung',
    ];
}
