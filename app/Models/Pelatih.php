<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Pelatih extends Model
{
    use HasFactory;

    protected $table = 'pelatih';

    protected $fillable = [
        'nama',
        'cabor_id',
        'email',
        'no_telepon',
        'tempat_lahir',
        'tanggal_lahir',
        'kelamin',
        'alamat',
        'foto'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date'
    ];

    public function getJenisKelaminAttribute()
    {
        return $this->kelamin;
    }

    public function getAlamatDomisiliAttribute()
    {
        return $this->alamat;
    }

    public function getPrestasiTerbaruAttribute()
    {
        $prestasi = $this->prestasis()->latest('tahun')->first();
        return $prestasi ? $prestasi->nama_prestasi : '-';
    }

    public function prestasis()
    {
        return $this->morphMany(Prestasi::class, 'subject');
    }

    public function cabangOlahraga()
    {
        return $this->belongsTo(CabangOlahraga::class, 'cabor_id');
    }
}