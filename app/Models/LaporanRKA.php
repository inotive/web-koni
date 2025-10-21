<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanRKA extends Model
{
    use HasFactory;

    protected $table = 'laporan_rkas';

    protected $fillable = [
        'manajemen_rka_id',
        'total_anggaran',
        'file_size',
        'file_path',
        'name',
    ];

    protected $casts = [
        'total_anggaran' => 'decimal:0',
    ];

    public function rka()
    {
        return $this->belongsTo(ManajemenRKA::class, 'manajemen_rka_id');
    }
}
