<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KegiatanLainnya extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'kegiatan_lainnyas'; // Make sure this matches your migration's table name

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_program_kegiatan',
        'volume',
        'jumlah_harga_satuan',
        'jumlah_harga',
        'foto_jurnal_path',
        'dokumen_path',
    ];
}