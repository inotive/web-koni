<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            PermissionSeeder::class,
            UserSeeder::class,
            CabangOlahragaSeeder::class, // Tambahkan langsung di dalam array ini
            AtletSeeder::class,
            PelatihSeeder::class,
        

        ]);
    }
}
