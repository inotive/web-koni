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
        'cabor',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'jenis_kelamin',
        'no_telepon',
        'email',
        'foto_atlet'
    ];

    public function cabor()
    {
        return $this->belongsTo(CabangOlahraga::class);
    }

    public function getUmurAttribute()
    {
        if ($this->tanggal_lahir) {
            return Carbon::parse($this->tanggal_lahir)->age . ' tahun';
        }
        return '-';
    }


    public function prestasiTerbaru()
    {
        return $this->morphOne(Prestasi::class, 'subject')->latestOfMany('tahun');
    }

    public function prestasis()
    {
        return $this->morphMany(Prestasi::class, 'subject');
    }

    public function cabangOlahraga()
    {
        return $this->belongsTo(CabangOlahraga::class);
    }
}
