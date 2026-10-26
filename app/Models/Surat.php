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
        'sumber',
        'tanggal_surat',
        'no_agenda',
        'kode_klasifikasi',
        'surat_template_id',
        'surat_penomoran_id',
        'data_template',
    ];

    protected $casts = [
        'tanggal_surat' => 'date',
        'data_template' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function template()
    {
        return $this->belongsTo(SuratTemplate::class, 'surat_template_id');
    }

    public function penomoran()
    {
        return $this->belongsTo(SuratPenomoran::class, 'surat_penomoran_id');
    }

    public function isFromTemplate(): bool
    {
        return $this->sumber === 'template' && (bool) $this->surat_template_id;
    }

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
              ->orWhere('no_surat', 'like', "%{$search}%")
              ->orWhere('no_agenda', 'like', "%{$search}%");
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