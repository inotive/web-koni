<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function () {
        // $permission = [
        //     // Manajemen Halaman
        //     ['name' => 'create-page', 'group' => 'Manajemen Halaman', 'display_name' => 'Tambah Halaman'],
        //     ['name' => 'read-page', 'group' => 'Manajemen Halaman', 'display_name' => 'Lihat Halaman'],
        //     ['name' => 'edit-page', 'group' => 'Manajemen Halaman', 'display_name' => 'Edit Halaman'],
        //     ['name' => 'delete-page', 'group' => 'Manajemen Halaman', 'display_name' => 'Hapus Halaman'],

        //     // Media Informasi
        //     ['name' => 'create-media', 'group' => 'Media Informasi', 'display_name' => 'Tambah Media'],
        //     ['name' => 'read-media', 'group' => 'Media Informasi', 'display_name' => 'Lihat Media'],
        //     ['name' => 'edit-media', 'group' => 'Media Informasi', 'display_name' => 'Edit Media'],
        //     ['name' => 'delete-media', 'group' => 'Media Informasi', 'display_name' => 'Hapus Media'],

        //     // Projek
        //     ['name' => 'create-project', 'group' => 'Projek', 'display_name' => 'Tambah Proyek'],
        //     ['name' => 'read-project', 'group' => 'Projek', 'display_name' => 'Lihat Proyek'],
        //     ['name' => 'edit-project', 'group' => 'Projek', 'display_name' => 'Edit Proyek'],
        //     ['name' => 'delete-project', 'group' => 'Projek', 'display_name' => 'Hapus Proyek'],

        //     // Client & Vendor
        //     ['name' => 'create-client-vendor', 'group' => 'Client & Vendor', 'display_name' => 'Tambah Data'],
        //     ['name' => 'read-client-vendor', 'group' => 'Client & Vendor', 'display_name' => 'Lihat Data'],
        //     ['name' => 'edit-client-vendor', 'group' => 'Client & Vendor', 'display_name' => 'Edit Data'],
        //     ['name' => 'delete-client-vendor', 'group' => 'Client & Vendor', 'display_name' => 'Hapus Data'],

        //     // Kontak
        //     ['name' => 'read-contact', 'group' => 'Kontak', 'display_name' => 'Lihat Kontak'],
        //     ['name' => 'reply-contact', 'group' => 'Kontak', 'display_name' => 'Balas Pesan'],

        //     // Manajemen Pengguna
        //     ['name' => 'create-users', 'group' => 'Manajemen Pengguna', 'display_name' => 'Tambah Pengguna'],
        //     ['name' => 'read-users', 'group' => 'Manajemen Pengguna', 'display_name' => 'Lihat Pengguna'],
        //     ['name' => 'edit-users', 'group' => 'Manajemen Pengguna', 'display_name' => 'Edit Pengguna'],
        //     ['name' => 'delete-users', 'group' => 'Manajemen Pengguna', 'display_name' => 'Hapus Pengguna'],
        // ];

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
            $data = Permission::create([
                'name' => $value['name'],
                'guard_name' => 'web',
                'group' => $value['group'],
                'display_name' => $value['display_name'],
            ]);

            $role = Role::where('id', 1)->first();
            $role->givePermissionTo($data->id);
        }

        $this->command->info('Seeding Permissions sesuai UI telah selesai!');
    });

    }
}
