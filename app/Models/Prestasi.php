<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestasi extends Model
{
    use HasFactory;

    protected $table = 'prestasis'; // Make sure this matches your table name

    protected $fillable = [
        'nama_prestasi',
        'tempat',
        'tahun',
        'medali',
        'subject_id',
        'subject_type'
    ];

    protected $casts = [
        'tahun' => 'integer',
    ];

    /**
     * Get the owning subject (Atlet or Pelatih)
     */
    public function subject()
    {
        return $this->morphTo();
    }

    /**
     * Get the atlet that owns the prestasi (if applicable)
     */
    // public function atlet()
    // {
    //     return $this->morphedByMany(Atlet::class, 'subject');
    // }

    // /**
    //  * Get the pelatih that owns the prestasi (if applicable)
    //  */
    // public function pelatih()
    // {
    //     return $this->morphedByMany(Pelatih::class, 'subject');
    // }
}
