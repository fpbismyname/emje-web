<?php

namespace Database\Seeders;

use App\Enums\User\RoleEnum;
use App\Models\Rekening;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RekeningSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Rekening::create([
            'nama_rekening' => RoleEnum::BENDAHARA,
            'saldo' => 0
        ]);
    }
}
