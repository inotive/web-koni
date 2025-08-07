<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManajemenRKA extends Model
{
    use HasFactory;

    protected $table = 'manajemen_rkas';

    protected $fillable = [
        'name',
    ];

    public function laporans()
    {
        return $this->hasMany(LaporanRKA::class, 'manajemen_rka_id')->orderBy('id', 'desc');
    }
}
