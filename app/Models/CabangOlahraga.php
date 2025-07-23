<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CabangOlahraga extends Model
{
    protected $fillable = [
        'nama_cabor',
        'ketua_penanggung_jawab',
        'status',
        'tanggal_pembentukan',
        'jumlah_atlet',
        'jumlah_pelatih',
        'icon_cabor',
    ];

    public function atlets()
    {
        return $this->hasMany(Atlet::class);
    }

    public function pelatihs()
    {
        return $this->hasMany(Pelatih::class);
    }
}
