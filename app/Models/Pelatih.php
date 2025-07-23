<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Pelatih extends Model
{
    use HasFactory;

     protected $table = 'pelatih';

    protected $fillable = [
        'nama',
        'cabor',
        'email',
        'no_telepon',
        'tempat_lahir',
        'tanggal_lahir',
        'kelamin',
        'alamat',
        'foto'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date'
    ];


    public function prestasis(): MorphMany
    {
        return $this->morphMany(Prestasi::class, 'subject');
    }
    public function cabangOlahraga()
    {
        return $this->belongsTo(CabangOlahraga::class);
    }
}
