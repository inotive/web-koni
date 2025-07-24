<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function () {

            $permission = [
                ['name' => 'dashboard', 'group' => 'Sistem', 'display_name' => 'Dashboard'],
                ['name' => 'manajemen-rka', 'group' => 'Keuangan', 'display_name' => 'Manajemen RKA'],
                ['name' => 'laporan-lpj', 'group' => 'Keuangan', 'display_name' => 'Laporan LPJ'],
                ['name' => 'database-bendahara', 'group' => 'Keuangan', 'display_name' => 'Database Bendahara'],
                ['name' => 'file-kesekretariatan', 'group' => 'Kesekretariatan', 'display_name' => 'File Kesekretariatan'],
                ['name' => 'surat-masuk-keluar', 'group' => 'Kesekretariatan', 'display_name' => 'Surat Masuk & Keluar'],

                // Konfigurasi
                ['name' => 'pelatih', 'group' => 'Konfigurasi', 'display_name' => 'Pelatih'],
                ['name' => 'atlet', 'group' => 'Konfigurasi', 'display_name' => 'Atlet'],
                ['name' => 'pengguna', 'group' => 'Manajemen Pengguna', 'display_name' => 'Pengguna'],
                ['name' => 'jabatan', 'group' => 'Manajemen Pengguna', 'display_name' => 'Jabatan & Hak Akses'],
                ['name' => 'tahun-anggaran', 'group' => 'Keuangan', 'display_name' => 'Tahun Anggaran'],
                ['name' => 'cabang-olahraga', 'group' => 'Konfigurasi', 'display_name' => 'Cabang Olahraga'],
                ['name' => 'kejuaraan', 'group' => 'Konfigurasi', 'display_name' => 'Kejuaraan'],
            ];

            foreach ($permission as $value) {
                $data = Permission::create([
                    'name' => $value['name'],
                    'guard_name' => 'web',
                    'group' => $value['group'],
                    'display_name' => $value['display_name'],
                ]);

                $role = Role::where('id', 1)->first();
                $role->givePermissionTo($data->id);
            }

            $this->command->info('Seeding telah selesai!');
        });
    }
}
