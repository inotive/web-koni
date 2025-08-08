<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Carbon\Carbon;

class Atlet extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'cabor_id',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'jenis_kelamin',
        'prestasi_terbaru',
        'no_telepon',
        'email',
        'foto_atlet',
        'alamatkota',
        'alamatprovinsi',
        'ketersediaan'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'created_at'    => 'datetime',
        'updated_at'    => 'datetime',
    ];

    public function getUmurAttribute()
    {
        if ($this->tanggal_lahir) {
            return Carbon::parse($this->tanggal_lahir)->age . ' tahun';
        }
        return '-';
    }

    // Di model Atlet.php
    public function prestasiTerbaru()
    {
        return $this->morphOne(Prestasi::class, 'subject')
            ->orderBy('tahun', 'desc')
            ->limit(1);
    }

    public function prestasis()
    {
        return $this->morphMany(Prestasi::class, 'subject')
            ->orderBy('tahun', 'desc');
    }

    public function cabangOlahraga()
    {
        return $this->belongsTo(CabangOlahraga::class, 'cabor_id');
    }
}
