<?php

namespace App\Models\Arsip;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class ArsipMutasi extends Model
{
    protected $table = 'arsip_mutasi';

    protected $fillable = ['arsip_id', 'lokasi_asal_id', 'lokasi_tujuan_id', 'alasan', 'user_id'];

    public function arsip()
    {
        return $this->belongsTo(Arsip::class);
    }

    public function lokasiAsal()
    {
        return $this->belongsTo(ArsipLokasi::class, 'lokasi_asal_id');
    }

    public function lokasiTujuan()
    {
        return $this->belongsTo(ArsipLokasi::class, 'lokasi_tujuan_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
