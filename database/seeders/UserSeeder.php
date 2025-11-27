<?php

namespace Database\Seeders;

use App\Enums\Pelatihan\MetodePembayaranEnum;
use App\Enums\Pelatihan\StatusPendaftaranPelatihanEnum;
use App\Enums\Pelatihan\TenorCicilanPelatihanEnum;
use App\Enums\User\RoleEnum;
use App\Models\CicilanBiayaPelatihan;
use App\Models\KontrakKerja;
use App\Models\Pelatihan;
use App\Models\PendaftaranPelatihan;
use App\Models\ProfilUser;
use App\Models\User;
use Arr;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create profil seeder for client user
        ProfilUser::factory()->withUser()->count(25)->create();

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

        // Make pelatihan seeder
        $pelatihan = Pelatihan::factory()->count(20)->create();

        // Make kontrak kerja seeder
        $kontrak_kerja = KontrakKerja::factory()->count(10)->create();

        // Make peserta seeder
        $seeder_profil_user = ProfilUser::factory()->withUser()->count(25)->create();
        foreach ($seeder_profil_user as $profil_user) {
            $pelatihan_id = $pelatihan->random()->id;
            $profil_user->users->pendaftaran_pelatihan()->create([
                'status' => StatusPendaftaranPelatihanEnum::DALAM_PROSES,
                'bukti_pembayaran' => null,
                'metode_pembayaran' => MetodePembayaranEnum::CICILAN,
                'tanggal_dibayar' => null,
                'pelatihan_id' => $pelatihan_id
            ]);
        }
    }
}
