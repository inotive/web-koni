<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lpj extends Model
{
    use HasFactory;

    protected $table = 'lpj';

    protected $fillable = [
        'modifiable_by_user_id',
        'parent_id',
        'icon',
        'nama_program',
        'nama_kegiatan',
        'volume',
        'jumlah_harga_satuan',
        'jumlah_harga',
        'dokumen_pendukung',
        'dokumen_lpj',
        'dokumen_lpj_pdf',
        'foto_jurnal',
        'keterangan_tambahan',
        'is_approved',
        'approved_by',
        'approved_at',
        'catatan_approval',
        'target_anggaran',
        'target_kegiatan'
    ];

    protected $casts = [
        'dokumen_pendukung' => 'array',
        'dokumen_lpj' => 'array',
        'dokumen_lpj_pdf' => 'array',
        'foto_jurnal' => 'array',
        'is_approved' => 'boolean',
        'approved_at' => 'datetime',
        'target_anggaran' => 'decimal:2',
        'target_kegiatan' => 'integer'
    ];

    public function setJumlahHargaSatuanAttribute($value)
    {
        // Handle both numeric and formatted string inputs
        if (is_string($value)) {
            $this->attributes['jumlah_harga_satuan'] = preg_replace('/[^\d.]/', '', $value);
        } else {
            $this->attributes['jumlah_harga_satuan'] = $value;
        }
    }

    public function setJumlahHargaAttribute($value)
    {
        // Handle both numeric and formatted string inputs
        if (is_string($value)) {
            $this->attributes['jumlah_harga'] = preg_replace('/[^\d.]/', '', $value);
        } else {
            $this->attributes['jumlah_harga'] = $value;
        }
    }

    // Accessor untuk mendapatkan harga satuan dalam format Rupiah
    public function getFormattedJumlahHargaSatuanAttribute()
    {
        return 'Rp ' . number_format($this->jumlah_harga_satuan, 0, ',', '.');
    }

    // Accessor untuk mendapatkan jumlah harga dalam format Rupiah
    public function getFormattedJumlahHargaAttribute()
    {
        return 'Rp ' . number_format($this->jumlah_harga, 0, ',', '.');
    }

    /**
     * Get the parent LPJ
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Lpj::class, 'parent_id');
    }

    /**
     * Get all children LPJ entries
     */
    public function children(): HasMany
    {
        return $this->hasMany(Lpj::class, 'parent_id')
            ->orderBy('nama_program');
    }

    /**
     * Get all descendants recursively
     */
    public function descendants(): HasMany
    {
        return $this->children()->with('descendants');
    }

    /**
     * Get ancestors (breadcrumb trail)
     */
    public function ancestors()
    {
        $ancestors = collect();
        $current = $this->parent;

        while ($current) {
            $ancestors->prepend($current);
            $current = $current->parent;
        }

        return $ancestors;
    }

    /**
     * Get the full breadcrumb path
     */
    public function getBreadcrumbAttribute()
    {
        return $this->ancestors()->pluck('nama_program')->push($this->nama_program)->implode(' > ');
    }

    public function pengajuan()
    {
        return $this->hasOne(Pengajuan::class);
    }

    /**
     * Check if LPJ is a root entry (no parent)
     */
    public function isRoot(): bool
    {
        return is_null($this->parent_id);
    }

    /**
     * Check if LPJ has children
     */
    public function hasChildren(): bool
    {
        return $this->children()->count() > 0;
    }

    /**
     * Get depth level of the LPJ entry
     */
    public function getDepthAttribute(): int
    {
        return $this->ancestors()->count();
    }

    /**
     * Check if this is a data entry (has actual data, not just a category)
     */
    public function isDataEntry(): bool
    {
        return !empty($this->volume) || !empty($this->jumlah_harga_satuan) || !empty($this->jumlah_harga);
    }

    /**
     * Check if this is a category (parent with no actual data)
     */
    public function isCategory(): bool
    {
        return $this->hasChildren() && !$this->isDataEntry();
    }

    /**
     * Scope for root entries only
     */
    public function scopeRoot($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Scope for data entries only (not categories)
     */
    public function scopeDataEntries($query)
    {
        return $query->where(function ($q) {
            $q->whereNotNull('volume')
                ->orWhereNotNull('jumlah_harga_satuan')
                ->orWhereNotNull('jumlah_harga');
        });
    }

    /**
     * Scope for categories only (parents with children but no data)
     */
    public function scopeCategories($query)
    {
        return $query->has('children')
            ->where(function ($q) {
                $q->whereNull('volume')
                    ->whereNull('jumlah_harga_satuan')
                    ->whereNull('jumlah_harga');
            });
    }

    /**
     * Get children by parent ID
     */
    public static function getByParent($parentId = null)
    {
        return static::where('parent_id', $parentId)
            ->orderBy('nama_program')
            ->get();
    }

    /**
     * Build hierarchical tree structure
     */
    public static function buildTree($parentId = null)
    {
        return static::where('parent_id', $parentId)
            ->orderBy('nama_program')
            ->with(['children' => function ($query) {
                $query->orderBy('nama_program');
            }])
            ->get()
            ->map(function ($item) {
                if ($item->hasChildren()) {
                    $item->children = static::buildTree($item->id);
                }
                return $item;
            });
    }

    /**
     * Get total budget for this entry and all children
     */
    public function getTotalBudget(): int
    {
        $total = $this->jumlah_harga ?? 0;

        foreach ($this->children as $child) {
            $total += $child->getTotalBudget();
        }

        return $total;
    }

    /**
     * Get navigation path for routing
     */
    public function getNavigationPath(): array
    {
        $path = [];
        $ancestors = $this->ancestors();

        foreach ($ancestors as $ancestor) {
            $path[] = $ancestor->id;
        }

        return $path;
    }

    /**
     * Generate slug from nama_program
     */
    public function getSlugAttribute(): string
    {
        return \Str::slug($this->nama_program);
    }

    /**
     * Get route name based on depth level
     */
    public function getRouteNameAttribute(): string
    {
        $depth = $this->depth;
        $baseName = 'admin.laporan-lpj.bidang';

        if ($depth === 0) {
            return $baseName . '.index';
        } elseif ($depth === 1) {
            return $baseName . '.show';
        } else {
            return $baseName . '.sub.index';
        }
    }
}
