<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prestasi extends Model
{
    protected $fillable = ['pelatih_id', 'nama_prestasi', 'tempat', 'tahun'];

    public function pelatih()
    {
        return $this->belongsTo(Pelatih::class);
    }
}

