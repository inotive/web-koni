<?php

namespace App\Models\Arsip;

use App\Models\FileKesekretariat;
use App\Models\Surat;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Arsip extends Model
{
    protected $table = 'arsip';

    protected $fillable = [
        'nomor_arsip',
        'judul',
        'uraian',
        'arsip_kategori_id',
        'arsip_lokasi_id',
        'tanggal_arsip',
        'jumlah',
        'satuan',
        'media',
        'tingkat_perkembangan',
        'status',
        'arsip_pemusnahan_id',
        'file_path',
        'sumber_type',
        'sumber_id',
        'keterangan',
        'created_by',
    ];

    protected $casts = [
        'tanggal_arsip' => 'date',
    ];

    public const STATUS = [
        'aktif' => 'Aktif',
        'inaktif' => 'Inaktif',
        'dipinjam' => 'Dipinjam',
        'dimusnahkan' => 'Dimusnahkan',
        'permanen' => 'Permanen',
    ];

    public const STATUS_BADGE = [
        'aktif' => 'badge-light-success',
        'inaktif' => 'badge-light-warning',
        'dipinjam' => 'badge-light-info',
        'dimusnahkan' => 'badge-light-danger',
        'permanen' => 'badge-light-primary',
    ];

    public const MEDIA = ['fisik' => 'Fisik', 'digital' => 'Digital', 'keduanya' => 'Fisik & Digital'];

    public const TINGKAT = ['asli' => 'Asli', 'salinan' => 'Salinan', 'tembusan' => 'Tembusan'];

    /** Sumber data yang bisa ditautkan ke arsip (key dipakai di form). */
    public const SUMBER = [
        'surat' => Surat::class,
        'file_kesekretariat' => FileKesekretariat::class,
    ];

    public function kategori()
    {
        return $this->belongsTo(ArsipKategori::class, 'arsip_kategori_id');
    }

    public function lokasi()
    {
        return $this->belongsTo(ArsipLokasi::class, 'arsip_lokasi_id');
    }

    public function peminjaman()
    {
        return $this->hasMany(ArsipPeminjaman::class)->latest('tanggal_pinjam')->latest('id');
    }

    public function peminjamanAktif()
    {
        return $this->hasOne(ArsipPeminjaman::class)->where('status', 'dipinjam');
    }

    public function mutasi()
    {
        return $this->hasMany(ArsipMutasi::class)->latest()->latest('id');
    }

    public function pemusnahan()
    {
        return $this->belongsTo(ArsipPemusnahan::class, 'arsip_pemusnahan_id');
    }

    public function sumber()
    {
        return $this->morphTo();
    }

    public function pembuat()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public static function generateNomor(?Carbon $tanggal = null): string
    {
        $tahun = ($tanggal ?? now())->format('Y');
        $prefix = "ARS-{$tahun}-";
        $last = self::where('nomor_arsip', 'like', $prefix . '%')->orderByDesc('nomor_arsip')->value('nomor_arsip');
        $next = $last ? ((int) substr($last, strlen($prefix))) + 1 : 1;

        return $prefix . str_pad($next, 5, '0', STR_PAD_LEFT);
    }

    /** Tanggal arsip berpindah dari aktif ke inaktif. */
    public function getJatuhTempoInaktifAttribute(): ?Carbon
    {
        if (!$this->kategori) {
            return null;
        }
        return $this->tanggal_arsip->copy()->addYears($this->kategori->retensi_aktif_tahun);
    }

    /** Tanggal arsip harus ditindaklanjuti (musnah/permanen/dinilai kembali). */
    public function getJatuhTempoRetensiAttribute(): ?Carbon
    {
        if (!$this->kategori) {
            return null;
        }
        return $this->tanggal_arsip->copy()
            ->addYears($this->kategori->retensi_aktif_tahun + $this->kategori->retensi_inaktif_tahun);
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUS[$this->status] ?? $this->status;
    }

    public function getStatusBadgeAttribute(): string
    {
        return self::STATUS_BADGE[$this->status] ?? 'badge-light';
    }

    public function getSumberKeyAttribute(): ?string
    {
        return array_search($this->sumber_type, self::SUMBER, true) ?: null;
    }

    public function getSumberLabelAttribute(): ?string
    {
        $sumber = $this->sumber;

        return match (true) {
            $sumber instanceof Surat => 'Surat ' . ucfirst($sumber->jenis_surat) . ': ' . $sumber->no_surat . ' (' . $sumber->nama_kegiatan . ')',
            $sumber instanceof FileKesekretariat => 'File Kesekretariat: ' . $sumber->nama_dokumen,
            default => null,
        };
    }

    /** Arsip yang masih tersimpan (belum dimusnahkan/diserahkan permanen). */
    public function scopeTersimpan(Builder $query): Builder
    {
        return $query->whereNotIn('arsip.status', ['dimusnahkan', 'permanen']);
    }

    /** Arsip yang masa retensinya (aktif + inaktif) sudah lewat pada tanggal tertentu. */
    public function scopeJatuhTempoRetensi(Builder $query, ?Carbon $per = null): Builder
    {
        $per = ($per ?? now())->toDateString();

        return $query->tersimpan()
            ->whereHas('kategori', function ($q) use ($per) {
                $q->whereRaw(
                    'DATE_ADD(arsip.tanggal_arsip, INTERVAL (arsip_kategori.retensi_aktif_tahun + arsip_kategori.retensi_inaktif_tahun) YEAR) <= ?',
                    [$per]
                );
            });
    }

    /** Arsip aktif yang masa aktifnya sudah lewat (perlu dipindah ke inaktif). */
    public function scopeJatuhTempoInaktif(Builder $query, ?Carbon $per = null): Builder
    {
        $per = ($per ?? now())->toDateString();

        return $query->where('arsip.status', 'aktif')
            ->whereHas('kategori', function ($q) use ($per) {
                $q->whereRaw('DATE_ADD(arsip.tanggal_arsip, INTERVAL arsip_kategori.retensi_aktif_tahun YEAR) <= ?', [$per]);
            });
    }
}
