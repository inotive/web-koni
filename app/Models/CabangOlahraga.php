<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

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

    protected $casts = [
        'tanggal_pembentukan' => 'date',
        'terakhir_update' => 'datetime'
    ];

    // ✅ Relasi dengan foreign key yang konsisten
    public function atlets()
    {
        return $this->hasMany(Atlet::class, 'cabor_id');
    }

    public function pelatihs()
    {
        return $this->hasMany(Pelatih::class, 'cabor_id');
    }

    // ✅ Accessor dengan eager loading untuk optimasi
    public function jumlahAtlet(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->atlets()->count(),
        )->shouldCache();
    }

    public function jumlahPelatih(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->pelatihs()->count(),
        )->shouldCache();
    }

        public function prestasis()
        {
            return $this->hasManyThrough(
                Prestasi::class,
                Atlet::class,
                'cabor_id',  // foreign key di tabel atlets
                'atlet_id',  // foreign key di tabel prestasis (asumsi memang ada)
                'id',
                'id'
            );
        }
}




