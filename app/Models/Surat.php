<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surat extends Model
{
    use HasFactory;

    protected $table = 'surat';

    protected $fillable = [
        'nama_kegiatan',
        'no_surat',
        'jenis_surat',
        'dokumen_surat',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function scopeByJenisSurat($query, $jenis)
    {
        return $query->where('jenis_surat', $jenis);
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        if ($startDate && $endDate) {
            return $query->whereBetween('created_at', [$startDate, $endDate]);
        } elseif ($startDate) {
            return $query->where('created_at', '>=', $startDate);
        } elseif ($endDate) {
            return $query->where('created_at', '<=', $endDate);
        }

        return $query;
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('nama_kegiatan', 'like', "%{$search}%")
              ->orWhere('no_surat', 'like', "%{$search}%");
        });
    }

    public function getFormattedDateAttribute()
    {
        return $this->created_at->format('d M Y H:i');
    }

    public function getJenisSuratBadgeAttribute()
    {
        return $this->jenis_surat == 'masuk' ? 'success' : 'primary';
    }

    public function getJenisSuratTextAttribute()
    {
        return $this->jenis_surat == 'masuk' ? 'Surat Masuk' : 'Surat Keluar';
    }
}