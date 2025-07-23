<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function () {
            app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
            $roles = ['superadmin', 'admin', 'dashboard', 'manajemen-rka'];
            foreach ($roles as $value) {
                // Cek dulu, kalau belum ada baru buat
                if (!Role::where('name', $value)->exists()) {
                    Role::create(['name' => $value]);
                }
            }

            $this->command->info('Seeding Roles has been completed!');
        });
    }
}
