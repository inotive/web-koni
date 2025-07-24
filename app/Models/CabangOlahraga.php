<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CabangOlahraga extends Model
{
    protected $table = 'cabang_olahragas';

    protected $fillable = [
        'nama_cabor',
        'ketua_penanggung_jawab',
        'status',
        'tanggal_pembentukan',
        'icon_cabor',
        'terakhir_update',
    ];

    public function atlets()
    {
        return $this->hasMany(Atlet::class, 'cabor_id');
    }

    public function pelatihs()
    {
        return $this->hasMany(Pelatih::class, 'cabor_id');
    }

        public function getJumlahAtletAttribute()
    {
        return $this->atlets()->count();
    }

    public function getJumlahPelatihAttribute()
    {
        return $this->pelatihs()->count();
    }
}