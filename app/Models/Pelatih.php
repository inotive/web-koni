<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelatih extends Model
{
    protected $table = 'pelatih';

    protected $fillable = [
        'nama', 'cabor', 'tempat_lahir', 'tanggal_lahir', 'alamat',
        'kelamin', 'prestasi', 'no_telepon', 'email', 'foto'
    ];

    public function prestasis()
    {
        return $this->hasMany(Prestasi::class);
    }
}


