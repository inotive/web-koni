<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pelatih;

class PelatihSeeder extends Seeder
{
    public function run()
    {
        Pelatih::create([
            'nama' => 'Andrew Arief Muhidin',
            'cabor' => 'Bola Basket',
            'tempat_lahir' => 'Balikpapan',
            'tanggal_lahir' => '2003-01-20',
            'alamat' => 'Tanjung',
            'kelamin' => 'Laki - Laki',
            'prestasi' => 'Juara 1 PON Aceh 2025',
            'no_telepon' => '0812145563412',
            'email' => 'curtis.weaver@example.com',
            'foto' => 'andrew.jpg',
        ]);
    }
}
