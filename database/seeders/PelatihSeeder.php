<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pelatih;
use App\Models\CabangOlahraga;

class PelatihSeeder extends Seeder
{
    public function run()
    {
        $basket = CabangOlahraga::where('nama_cabor', 'Bola Basket')->first();

        Pelatih::create([
            'cabang_olahraga_id' => $basket->id,
            'nama' => 'Pak Surya',
            'jenis_kelamin' => 'Laki-laki',
            'tanggal_lahir' => '1980-01-15',
            'spesialisasi' => 'Pelatih Utama',
        ]);

        Pelatih::create([
            'cabang_olahraga_id' => $basket->id,
            'nama' => 'Bu Rina',
            'jenis_kelamin' => 'Perempuan',
            'tanggal_lahir' => '1985-06-10',
            'spesialisasi' => 'Asisten Pelatih',
        ]);
    }
}
