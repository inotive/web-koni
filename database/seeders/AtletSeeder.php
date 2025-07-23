<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Atlet;
use Illuminate\Support\Str;

class AtletSeeder extends Seeder
{
    public function run()
    {
        for ($i = 1; $i <= 12; $i++) {
            Atlet::create([
                'nama' => "Atlet $i",
                'cabor' => ['Renang', 'Lari', 'Bulu Tangkis', 'Sepak Bola'][rand(0, 3)],
                'tempat_lahir' => 'Kota ' . $i,
                'tanggal_lahir' => now()->subYears(rand(17, 30))->subDays(rand(0, 365)),
                'alamat' => "Alamat Atlet $i",
                'jenis_kelamin' => ['Laki-laki', 'Perempuan'][rand(0, 1)],
                'no_telepon' => '08' . rand(1111111111, 9999999999),
                'email' => "atlet$i@example.com",
                'foto_atlet' => null, // atau default image jika ada
            ]);
        }
    }
}
