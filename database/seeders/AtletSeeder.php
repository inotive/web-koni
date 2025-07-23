<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Atlet;
use App\Models\CabangOlahraga;

class AtletSeeder extends Seeder
{
    public function run()
    {
        $basket = CabangOlahraga::where('nama_cabor', 'Bola Basket')->first();

        Atlet::create([
            'cabang_olahraga_id' => $basket->id,
            'nama' => 'Joko Slamet',
            'jenis_kelamin' => 'Laki-laki',
            'tanggal_lahir' => '2003-05-12',
        ]);

        Atlet::create([
            'cabang_olahraga_id' => $basket->id,
            'nama' => 'Budi Santoso',
            'jenis_kelamin' => 'Laki-laki',
            'tanggal_lahir' => '2004-02-20',
        ]);
    }
}
