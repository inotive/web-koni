<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class FileKesekretariat extends Model
{
    use HasFactory;

    protected $table = 'file_kesekretariats';

    protected $fillable = [
        'nama_dokumen',
        'tanggal_dokumen',
        'dokumen_file'
    ];

    // ✅ PENTING: Cast tanggal_dokumen sebagai date
    protected $casts = [
        'tanggal_dokumen' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // ✅ TAMBAHAN: Accessor untuk format konsisten
    public function getTanggalDokumenFormattedAttribute()
    {
        return $this->tanggal_dokumen ? $this->tanggal_dokumen->format('Y-m-d') : null;
    }

    // ✅ TAMBAHAN: Accessor untuk format Indonesia
    public function getTanggalDokumenIndonesiaAttribute()
    {
        return $this->tanggal_dokumen ? $this->tanggal_dokumen->format('d/m/Y') : null;
    }
}