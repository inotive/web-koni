<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratPenomoranCounter extends Model
{
    protected $table = 'surat_penomoran_counter';

    protected $fillable = [
        'surat_penomoran_id',
        'periode',
        'kode',
        'last_number',
    ];

    protected $casts = [
        'last_number' => 'integer',
    ];

    public function penomoran()
    {
        return $this->belongsTo(SuratPenomoran::class, 'surat_penomoran_id');
    }
}
