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
        'approval_notes'
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
        return $this->status_approval === 'pending';
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
        return $query->where('status_approval', 'pending');
    }

    public function scopeRejected($query)
    {
        return $query->where('status_approval', 'rejected');
    }
}