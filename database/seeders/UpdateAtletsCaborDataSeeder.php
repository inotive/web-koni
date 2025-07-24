<?php

namespace Database\Seeders;

use App\Models\Atlet;
use App\Models\CabangOlahraga;
use Illuminate\Database\Seeder;

class UpdateAtletsCaborDataSeeder extends Seeder
{
    public function run(): void
    {
        $atlets = Atlet::whereNull('cabor_id')->get();
        
        foreach ($atlets as $atlet) {
            $cabor = CabangOlahraga::where('nama_cabor', $atlet->cabor)->first();
            if ($cabor) {
                $atlet->update(['cabor_id' => $cabor->id]);
            }
        }
    }
}