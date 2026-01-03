<?php

namespace Database\Seeders;


use App\Enums\User\RoleEnum;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        // Datas for created admin user
        $datas = [
            [
                'name' => 'Pengelola pendaftaran',
                'email' => 'pengelola_pendaftaran@gmail.com',
                'password' => 'pengelola123',
                'role' => RoleEnum::PENGELOLA_PENDAFTARAN
            ],
            [
                'name' => 'Administrasi',
                'email' => 'administrasi@gmail.com',
                'password' => 'admin123',
                'role' => RoleEnum::ADMIN
            ],
            [
                'name' => 'Bendahara',
                'email' => 'bendahara@gmail.com',
                'password' => 'bendahara123',
                'role' => RoleEnum::BENDAHARA
            ],
        ];

        foreach ($datas as $account) {
            User::create($account);
        }
    }
}
