<?php

namespace Database\Seeders;

// database/seeders/CabangOlahragaSeeder.php
use Illuminate\Database\Seeder;
use App\Models\CabangOlahraga;

class CabangOlahragaSeeder extends Seeder
{
    public function run()
    {
        CabangOlahraga::create([
            'nama_cabor' => 'Bola Basket',
            'ketua_penanggung_jawab' => 'Andi Pratama Kusnandi',
            'status' => 'Aktif',
            'tanggal_pembentukan' => '2017-10-30',
            'jumlah_atlet' => 25,
            'jumlah_pelatih' => 3,
            'created_at' => now(),
        ]);

        // Tambah data lainnya sesuai contoh UI...
    }
}

