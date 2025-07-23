<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            $users = [
                [
                    'name'  => 'Super Admin',
                    'username' => 'superadmin',
                    'email'    => 'superadmin@gmail.com',
                    'role'     => 'superadmin',
                ],
                [
                    'name'  => 'Admin',
                    'username' => 'admin',
                    'email'    => 'admin@gmail.com',
                    'role'     => 'admin',
                ],
                [
                    'name'  => 'tes1',
                    'username' => 'pengawas',
                    'email'    => 'pengawas@gmail.com',
                    'role'     => 'superadmin', // sesuai dataset bosmu
                ],
                [
                    'name'  => 'tes2',
                    'username' => 'operator',
                    'email' => 'operator@gmail.com',
                    'role'  => 'dashboard',
                ],
            ];

            foreach ($users as $value) {
                // cari berdasarkan email, kalau belum ada buat
                $user = User::updateOrCreate(
                    ['email' => $value['email']],
                    [
                        'username' => $value['username'],
                        'password' => Hash::make('123123'),
                    ]
                );

                // assign role
                $user->syncRoles([$value['role']]);
            }

            $this->command->info('Seeding User has been completed!');
        });
    }
}
