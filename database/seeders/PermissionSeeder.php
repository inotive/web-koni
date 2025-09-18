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
            // Reset cached roles and permissions
            app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

            // Old permission to be removed
            Permission::where('name', 'pengajuan-modifikasi-laporan')->delete();

            $permissions = [
                ['name' => 'dashboard', 'group' => 'Sistem', 'display_name' => 'Dashboard'],
                ['name' => 'manajemen-rka', 'group' => 'Keuangan', 'display_name' => 'Manajemen RKA'],
                ['name' => 'laporan-lpj-sekretariat', 'group' => 'Keuangan', 'display_name' => 'Laporan LPJ Sekretariat'],
                ['name' => 'laporan-lpj-bidang', 'group' => 'Keuangan', 'display_name' => 'Laporan LPJ Bidang'],
                ['name' => 'laporan-lpj-kegiatan-lainnya', 'group' => 'Keuangan', 'display_name' => 'Laporan LPJ Kegiatan Lainnya'],
                ['name' => 'database-bendahara', 'group' => 'Keuangan', 'display_name' => 'Database Bendahara'],
                ['name' => 'file-kesekretariatan', 'group' => 'Kesekretariatan', 'display_name' => 'File Kesekretariatan'],
                ['name' => 'surat-masuk-keluar', 'group' => 'Kesekretariatan', 'display_name' => 'Surat Masuk & Keluar'],
                ['name' => 'pengajuan-modifikasi-laporan-view', 'group' => 'Sistem', 'display_name' => 'Lihat Pengajuan Modifikasi Laporan'],
                ['name' => 'pengajuan-modifikasi-laporan-manage', 'group' => 'Sistem', 'display_name' => 'Kelola Pengajuan Modifikasi Laporan'],

                // Konfigurasi
                ['name' => 'pelatih', 'group' => 'Konfigurasi', 'display_name' => 'Pelatih'],
                ['name' => 'atlet', 'group' => 'Konfigurasi', 'display_name' => 'Atlet'],
                ['name' => 'pengguna', 'group' => 'Manajemen Pengguna', 'display_name' => 'Pengguna'],
                ['name' => 'jabatan', 'group' => 'Manajemen Pengguna', 'display_name' => 'Jabatan & Hak Akses'],
                ['name' => 'tahun-anggaran', 'group' => 'Keuangan', 'display_name' => 'Tahun Anggaran'],
                ['name' => 'cabang-olahraga', 'group' => 'Konfigurasi', 'display_name' => 'Cabang Olahraga'],
                ['name' => 'kejuaraan', 'group' => 'Konfigurasi', 'display_name' => 'Kejuaraan'],
            ];

            foreach ($permissions as $permissionData) {
                $permission = Permission::updateOrCreate(
                    ['name' => $permissionData['name']],
                    [
                        'guard_name' => 'web',
                        'group' => $permissionData['group'],
                        'display_name' => $permissionData['display_name'],
                    ]
                );
                
                // Assign all permissions to superadmin role (ID 1)
                $role = Role::find(1);
                if ($role) {
                    $role->givePermissionTo($permission);
                }
            }

            $this->command->info('Seeding permissions has been completed!');
        });
    }
}