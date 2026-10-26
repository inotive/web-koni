<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratKop extends Model
{
    protected $table = 'surat_kop';

    protected $fillable = [
        'nama',
        'jenis',
        'gambar',
        'logo_kiri',
        'logo_kanan',
        'baris',
        'garis',
        'is_default',
        'is_active',
    ];

    protected $casts = [
        'baris' => 'array',
        'is_default' => 'boolean',
        'is_active' => 'boolean',
    ];

    public const JENIS = [
        'gambar' => 'Upload gambar kop',
        'susun' => 'Susun logo & teks',
    ];

    public const GARIS = [
        'tidak' => 'Tanpa garis',
        'tunggal' => 'Garis tunggal',
        'ganda' => 'Garis ganda',
    ];

    public function templates()
    {
        return $this->hasMany(SuratTemplate::class, 'surat_kop_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public static function default(): ?self
    {
        return self::active()->orderByDesc('is_default')->orderBy('id')->first();
    }

    public function getBarisListAttribute(): array
    {
        return $this->baris ?? [];
    }
}
