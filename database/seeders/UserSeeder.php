<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function () {
            $users = [
                [
                    'name'  => 'Super Admin',
                    'username' => 'superadmin',
                    'email' => 'superadmin@gmail.com',
                    'role'  => 'superadmin',
                ],
                [
                    'name'  => 'Admin',
                    'username' => 'admin',
                    'email' => 'admin@gmail.com',
                    'role'  => 'admin',
                ],
                [
                    'name'  => 'tes1',
                    'username' => 'pengawas',
                    'email' => 'pengawas@gmail.com',
                    'role'  => 'superadmin',
                ],
                [
                    'name'  => 'tes2',
                    'username' => 'operator',
                    'email' => 'operator@gmail.com',
                    'role'  => 'dashboard',
                ],
            ];

            foreach ($users as $value) {
                $user = User::create([
                    // 'name'      => $value['name'],
                    'username'     => $value['username'],
                    'email'     => $value['email'],
                    'password'  => bcrypt('123123')
                ]);

                $user->syncRoles([$value['role']]);
            }

            $this->command->info('Seeding User has been completed!');
        });
    }
}
