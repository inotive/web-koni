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
            CabangOlahragaSeeder::class,
            AtletSeeder::class,
            PelatihSeeder::class,
            PrestasiSeeder::class,
            ManajemenRKASeeder::class,
            LpjSeeder::class,
            FileKesekretariatSeeder::class,
            SuratSeeder::class,
            SekretariatSeeder::class,
        ]);
    }
}
