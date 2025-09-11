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
            '2020',
            '2021',
            '2022',
            '2023',
            '2024',
            '2025',
        ];

        foreach ($names as $name) {
            ManajemenRKA::create([
                'name' => $name,
            ]);
        }
    }
}
