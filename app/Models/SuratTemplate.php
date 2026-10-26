<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratTemplate extends Model
{
    protected $table = 'surat_template';

    protected $fillable = [
        'nama',
        'kode',
        'kode_klasifikasi',
        'surat_penomoran_id',
        'kop_surat',
        'tampilkan_kop',
        'surat_kop_id',
        'isi',
        'fields',
        'tampilkan_ttd',
        'penandatangan_nama',
        'penandatangan_jabatan',
        'penandatangan_nip',
        'ttd',
        'kota_surat',
        'ukuran_kertas',
        'is_active',
        'keterangan',
    ];

    protected $casts = [
        'fields' => 'array',
        'tampilkan_ttd' => 'boolean',
        'tampilkan_kop' => 'boolean',
        'is_active' => 'boolean',
    ];

    public const FIELD_TYPES = [
        'text' => 'Teks singkat',
        'textarea' => 'Teks panjang',
        'date' => 'Tanggal',
        'number' => 'Angka',
    ];

    /** Placeholder bawaan yang selalu tersedia di isi template. */
    public const PLACEHOLDERS = [
        'nomor_surat' => 'Nomor surat',
        'tanggal_surat' => 'Tanggal surat (26 Oktober 2026)',
        'perihal' => 'Perihal / nama kegiatan',
        'kota_surat' => 'Kota surat',
        'penandatangan_nama' => 'Nama penandatangan',
        'penandatangan_jabatan' => 'Jabatan penandatangan',
        'penandatangan_nip' => 'NIP / NIK penandatangan',
    ];

    public function penomoran()
    {
        return $this->belongsTo(SuratPenomoran::class, 'surat_penomoran_id');
    }

    public function surat()
    {
        return $this->hasMany(Surat::class, 'surat_template_id');
    }

    public function kop()
    {
        return $this->belongsTo(SuratKop::class, 'surat_kop_id');
    }

    /**
     * Kop yang dipakai saat render: gambar khusus template (lama) lebih dulu,
     * lalu kop yang dipilih, lalu kop default. Null bila kop dimatikan.
     */
    public function kopEfektif(): ?SuratKop
    {
        if (!$this->tampilkan_kop || $this->kop_surat) {
            return null;
        }

        // Cari berdasarkan id, bukan relasi yang mungkin sudah ter-cache (mis. saat preview dari form)
        $kop = $this->surat_kop_id ? SuratKop::active()->find($this->surat_kop_id) : null;

        return $kop ?? SuratKop::default();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /** Format penomoran template, atau format default surat keluar. */
    public function penomoranEfektif(): ?SuratPenomoran
    {
        return ($this->penomoran && $this->penomoran->is_active)
            ? $this->penomoran
            : SuratPenomoran::defaultUntuk('keluar');
    }

    public function getFieldListAttribute(): array
    {
        return $this->fields ?? [];
    }
}
