<?php

namespace Database\Seeders;

use App\Models\ManajemenRKA;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ManajemenRKASeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $names = [
            'Lembaga 1',
            'Lembaga 2',
            'Lembaga 3',
            'Lembaga 4',
            'Lembaga 5',
            'Lembaga 6',
        ];

        foreach ($names as $name) {
            ManajemenRKA::create([
                'name' => $name,
            ]);
        }
    }
}
