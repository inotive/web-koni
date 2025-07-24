<?php

namespace Database\Seeders;

use App\Models\Pelatih;
use App\Models\CabangOlahraga;
use Illuminate\Database\Seeder;

class UpdatePelatihCaborDataSeeder extends Seeder
{
    public function run(): void
    {
        $pelatihs = Pelatih::whereNull('cabor_id')->get();
        
        foreach ($pelatihs as $pelatih) {
            $cabor = CabangOlahraga::where('nama_cabor', $pelatih->cabor)->first();
            if ($cabor) {
                $pelatih->update(['cabor_id' => $cabor->id]);
            }
        }
    }
}