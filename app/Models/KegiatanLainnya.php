<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KegiatanLainnya extends Model
{
    use HasFactory;

    protected $table = 'kegiatan_lainnya';
    
    protected $fillable = [
        'nama_program_kegiatan',
        'jenis_kegiatan',
        'volume',
        'jumlah_harga_satuan',
        'jumlah_harga',
        'foto_jurnal',
        'dokumen_pendukung',
        'keterangan_tambahan',
        'status_approval',
        'approved_at',
        'approved_by',
        'catatan_approval',  // sesuaikan dengan controller
        'approval_notes'     // untuk fleksibilitas future
    ];

    protected $casts = [
        'jumlah_harga_satuan' => 'decimal:2',
        'jumlah_harga' => 'decimal:2',
        'approved_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationship dengan user yang meng-approve
    public function approvedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // Helper methods untuk status
    public function isApproved(): bool
    {
        return $this->status_approval === 'approved';
    }

    public function isPending(): bool
    {
        return $this->status_approval === 'pending' || is_null($this->status_approval);
    }

    public function isRejected(): bool
    {
        return $this->status_approval === 'rejected';
    }

    // Scope untuk filter berdasarkan status
    public function scopeApproved($query)
    {
        return $query->where('status_approval', 'approved');
    }

    public function scopePending($query)
    {
        return $query->where(function($q) {
            $q->where('status_approval', 'pending')
              ->orWhereNull('status_approval');
        });
    }

    public function scopeRejected($query)
    {
        return $query->where('status_approval', 'rejected');
    }

    // Accessor untuk format currency
    public function getFormattedJumlahHargaSatuanAttribute()
    {
        return 'Rp ' . number_format($this->jumlah_harga_satuan, 0, ',', '.');
    }

    public function getFormattedJumlahHargaAttribute()
    {
        return 'Rp ' . number_format($this->jumlah_harga, 0, ',', '.');
    }

    // Accessor untuk status approval dalam bahasa Indonesia
    public function getStatusApprovalTextAttribute()
    {
        return match($this->status_approval) {
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            'pending' => 'Menunggu Persetujuan',
            default => 'Menunggu Persetujuan'
        };
    }

    // Accessor untuk status badge class
    public function getStatusBadgeClassAttribute()
    {
        return match($this->status_approval) {
            'approved' => 'badge-light-success',
            'rejected' => 'badge-light-danger',
            'pending' => 'badge-light-warning',
            default => 'badge-light-warning'
        };
    }
}