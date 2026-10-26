<?php

namespace App\Models\Arsip;

use Illuminate\Database\Eloquent\Model;

class ArsipLokasi extends Model
{
    protected $table = 'arsip_lokasi';

    protected $fillable = ['parent_id', 'tipe', 'kode', 'nama', 'kapasitas', 'keterangan', 'is_aktif'];

    protected $casts = [
        'is_aktif' => 'boolean',
    ];

    public const TIPE = [
        'gedung' => 'Gedung',
        'ruang' => 'Ruang',
        'rak' => 'Rak / Lemari',
        'baris' => 'Baris / Ambalan',
        'box' => 'Box',
    ];

    public const IKON = [
        'gedung' => 'fa-building',
        'ruang' => 'fa-door-open',
        'rak' => 'fa-table-cells',
        'baris' => 'fa-grip-lines',
        'box' => 'fa-box-archive',
    ];

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('kode');
    }

    public function arsip()
    {
        return $this->hasMany(Arsip::class, 'arsip_lokasi_id');
    }

    /** Daftar leluhur dari root sampai lokasi ini. */
    public function ancestors(): array
    {
        $chain = [];
        $node = $this;
        while ($node) {
            array_unshift($chain, $node);
            $node = $node->parent;
        }
        return $chain;
    }

    public function getKodeLengkapAttribute(): string
    {
        return collect($this->ancestors())->pluck('kode')->implode('-');
    }

    public function getPathAttribute(): string
    {
        return collect($this->ancestors())->pluck('nama')->implode(' › ');
    }

    public function getTipeLabelAttribute(): string
    {
        return self::TIPE[$this->tipe] ?? ucfirst($this->tipe);
    }

    public function getIkonAttribute(): string
    {
        return self::IKON[$this->tipe] ?? 'fa-folder';
    }

    /** Id lokasi ini beserta seluruh turunannya. */
    public function descendantIds(): array
    {
        $ids = [$this->id];
        $frontier = [$this->id];
        while ($frontier) {
            $frontier = self::whereIn('parent_id', $frontier)->pluck('id')->all();
            $ids = array_merge($ids, $frontier);
        }
        return $ids;
    }

    public function jumlahTersimpan(): int
    {
        return $this->arsip()->tersimpan()->count();
    }

    public function isPenuh(): bool
    {
        return $this->kapasitas !== null && $this->jumlahTersimpan() >= $this->kapasitas;
    }

    /** Opsi select berindentasi untuk seluruh lokasi aktif. */
    public static function options(?int $exceptId = null): array
    {
        $all = self::where('is_aktif', true)->orderBy('kode')->get()->groupBy('parent_id');
        $exclude = $exceptId ? (self::find($exceptId)?->descendantIds() ?? []) : [];
        $result = [];

        $walk = function ($parentId, $depth, $prefix) use (&$walk, &$result, $all, $exclude) {
            foreach ($all->get($parentId ?? '', []) as $node) {
                if (in_array($node->id, $exclude)) {
                    continue;
                }
                $kode = $prefix ? "{$prefix}-{$node->kode}" : $node->kode;
                $result[] = [
                    'id' => $node->id,
                    'label' => str_repeat('— ', $depth) . "[{$kode}] {$node->nama}",
                    'tipe' => $node->tipe,
                ];
                $walk($node->id, $depth + 1, $kode);
            }
        };
        $walk(null, 0, '');

        return $result;
    }
}
