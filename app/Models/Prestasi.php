<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestasi extends Model
{
    use HasFactory;

    protected $table = 'prestasis';

    protected $fillable = [
        'nama_prestasi',
        'tempat',
        'tahun',
        'medali',
        'tingkat',
        'cabor_id',
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
     * Scope untuk filter berdasarkan subject type
     */
    public function scopeForAtlet($query)
    {
        return $query->where('subject_type', Atlet::class);
    }

    public function scopeForPelatih($query)
    {
        return $query->where('subject_type', Pelatih::class);
    }

    /**
     * Get medal color
     */
    public function getMedalColorAttribute()
    {
        return [
            'Emas' => 'text-warning',
            'Perak' => 'text-secondary',
            'Perunggu' => 'text-danger'
        ][$this->medali] ?? 'text-primary';
    }

    public function cabangOlahraga()
{
    return $this->belongsTo(CabangOlahraga::class, 'cabor_id');
}
}
