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
                ['name' => 'beranda', 'group' => 'Manajemen Halaman', 'display_name' => 'Beranda'],
                ['name' => 'tentang-kami', 'group' => 'Manajemen Halaman', 'display_name' => 'Tentang Kami'],
                ['name' => 'direksi', 'group' => 'Direksi', 'display_name' => 'Direksi'],
                ['name' => 'agenda', 'group' => 'Media Informasi', 'display_name' => 'Agenda'],
                ['name' => 'berita', 'group' => 'Media Informasi', 'display_name' => 'Berita'],
                ['name' => 'karir', 'group' => 'Media Informasi', 'display_name' => 'Karir'],
                ['name' => 'sektor-proyek', 'group' => 'Proyek', 'display_name' => 'Sektor Proyek'],
                ['name' => 'portofolio-proyek', 'group' => 'Proyek', 'display_name' => 'Portofolio Proyek'],
                ['name' => 'produk-pangan', 'group' => 'Layanan Usaha', 'display_name' => 'Produk Pangan'],
                ['name' => 'pergudangan', 'group' => 'Layanan Usaha', 'display_name' => 'Pergudangan'],
                ['name' => 'rusunawa', 'group' => 'Layanan Usaha', 'display_name' => 'Rusunawa'],
                ['name' => 'client-&-vendor', 'group' => 'Client & Vendor', 'display_name' => 'Client & Vendor'],
                ['name' => 'kontak', 'group' => 'Kontak', 'display_name' => 'Kontak'],
                ['name' => 'pengguna', 'group' => 'Manajemen Pengguna', 'display_name' => 'Pengguna'],
                ['name' => 'jabatan', 'group' => 'Manajemen Pengguna', 'display_name' => 'Jabatan'],
            ];

            foreach ($permission as $value) {
                $existing = Permission::where('name', $value['name'])
                    ->where('guard_name', 'web')
                    ->first();

                if (!$existing) {
                    $data = Permission::create([
                        'name' => $value['name'],
                        'guard_name' => 'web',
                        'group' => $value['group'],
                        'display_name' => $value['display_name'],
                    ]);
                } else {
                    $data = $existing;
                }

                $role = Role::find(1);
                if ($role && !$role->hasPermissionTo($data)) {
                    $role->givePermissionTo($data);
                }
            }

            $this->command->info('Seeding Permissions sesuai UI telah selesai!');
        });
    }
}
