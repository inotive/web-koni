<?php

namespace App\Models\Arsip;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class ArsipPemusnahan extends Model
{
    protected $table = 'arsip_pemusnahan';

    protected $fillable = ['nomor_berita_acara', 'tanggal', 'jenis', 'keterangan', 'user_id'];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public const JENIS = ['musnah' => 'Pemusnahan', 'permanen' => 'Penyerahan Arsip Permanen'];

    public function arsip()
    {
        return $this->hasMany(Arsip::class, 'arsip_pemusnahan_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function generateNomor(): string
    {
        $tahun = now()->format('Y');
        $count = self::whereYear('created_at', $tahun)->count() + 1;

        return sprintf('BA/ARSIP/%03d/%s', $count, $tahun);
    }
}
