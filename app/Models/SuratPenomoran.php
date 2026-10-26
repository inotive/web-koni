<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratPenomoran extends Model
{
    protected $table = 'surat_penomoran';

    protected $fillable = [
        'nama',
        'format',
        'digit',
        'reset_period',
        'scope',
        'editable',
        'berlaku_untuk',
        'is_default',
        'is_active',
        'keterangan',
    ];

    protected $casts = [
        'digit' => 'integer',
        'editable' => 'boolean',
        'is_default' => 'boolean',
        'is_active' => 'boolean',
    ];

    public const RESET_PERIOD = [
        'tahunan' => 'Setiap Tahun',
        'bulanan' => 'Setiap Bulan',
        'tidak' => 'Tidak Pernah',
    ];

    public const SCOPE = [
        'bersama' => 'Bersama (satu urutan untuk semua surat)',
        'per_kode' => 'Terpisah per kode surat',
    ];

    public const BERLAKU_UNTUK = [
        'keluar' => 'Nomor Surat Keluar',
        'masuk' => 'Nomor Agenda Surat Masuk',
    ];

    /** Token yang bisa dipakai di format nomor, beserta penjelasannya. */
    public const TOKENS = [
        '{no}' => 'Nomor urut otomatis',
        '{kode}' => 'Kode template / jenis surat',
        '{klasifikasi}' => 'Kode klasifikasi arsip',
        '{tanggal}' => 'Tanggal (2 digit)',
        '{bulan}' => 'Bulan (2 digit)',
        '{bulan_romawi}' => 'Bulan romawi (I-XII)',
        '{tahun}' => 'Tahun (4 digit)',
        '{tahun_2}' => 'Tahun (2 digit)',
    ];

    public function counters()
    {
        return $this->hasMany(SuratPenomoranCounter::class, 'surat_penomoran_id');
    }

    public function templates()
    {
        return $this->hasMany(SuratTemplate::class, 'surat_penomoran_id');
    }

    public function surat()
    {
        return $this->hasMany(Surat::class, 'surat_penomoran_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeUntuk($query, string $jenis)
    {
        return $query->where('berlaku_untuk', $jenis);
    }

    /** Format default yang aktif untuk jenis surat tertentu. */
    public static function defaultUntuk(string $jenis): ?self
    {
        return self::active()->untuk($jenis)->orderByDesc('is_default')->orderBy('id')->first();
    }

    public function getResetPeriodLabelAttribute(): string
    {
        return self::RESET_PERIOD[$this->reset_period] ?? $this->reset_period;
    }

    public function getBerlakuUntukLabelAttribute(): string
    {
        return self::BERLAKU_UNTUK[$this->berlaku_untuk] ?? $this->berlaku_untuk;
    }
}
