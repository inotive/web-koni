<?php

namespace App\Models\Arsip;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class ArsipPeminjaman extends Model
{
    protected $table = 'arsip_peminjaman';

    protected $fillable = [
        'arsip_id',
        'nama_peminjam',
        'unit_peminjam',
        'tanggal_pinjam',
        'tanggal_rencana_kembali',
        'tanggal_kembali',
        'status',
        'status_arsip_sebelum',
        'catatan',
        'user_id',
    ];

    protected $casts = [
        'tanggal_pinjam' => 'date',
        'tanggal_rencana_kembali' => 'date',
        'tanggal_kembali' => 'date',
    ];

    public function arsip()
    {
        return $this->belongsTo(Arsip::class);
    }

    public function petugas()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getIsTerlambatAttribute(): bool
    {
        return $this->status === 'dipinjam' && $this->tanggal_rencana_kembali->lt(today());
    }

    public function scopeTerlambat($query)
    {
        return $query->where('status', 'dipinjam')->whereDate('tanggal_rencana_kembali', '<', today());
    }
}
