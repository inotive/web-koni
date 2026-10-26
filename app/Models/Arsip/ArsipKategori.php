<?php

namespace App\Models\Arsip;

use Illuminate\Database\Eloquent\Model;

class ArsipKategori extends Model
{
    protected $table = 'arsip_kategori';

    protected $fillable = [
        'kode_klasifikasi',
        'nama',
        'retensi_aktif_tahun',
        'retensi_inaktif_tahun',
        'tindakan_akhir',
        'keterangan',
    ];

    public const TINDAKAN_AKHIR = [
        'musnah' => 'Musnah',
        'permanen' => 'Permanen',
        'dinilai_kembali' => 'Dinilai Kembali',
    ];

    public function arsip()
    {
        return $this->hasMany(Arsip::class, 'arsip_kategori_id');
    }

    public function getTindakanAkhirLabelAttribute(): string
    {
        return self::TINDAKAN_AKHIR[$this->tindakan_akhir] ?? $this->tindakan_akhir;
    }
}
