<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Prestasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'atlet_id',
        'nama_prestasi',
        'tempat',
        'tahun',
        'medali',
    ];

    public function atlet(): BelongsTo
    {
        return $this->belongsTo(Atlet::class);
    }
}
