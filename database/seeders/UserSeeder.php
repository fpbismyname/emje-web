<?php

namespace Database\Seeders;

use App\Enums\Pelatihan\JenisPembayaranEnum;
use App\Enums\Pelatihan\SesiGelombangPelatihanEnum;
use App\Enums\Pelatihan\SkemaPembayaranEnum;
use App\Enums\Pelatihan\StatusPembayaranPelatihanEnum;
use App\Enums\Pelatihan\StatusPendaftaranPelatihanEnum;
use App\Enums\Pelatihan\TenorCicilanPelatihanEnum;
use App\Enums\Rekening\TipeTransaksiEnum;
use App\Enums\User\RoleEnum;
use App\Models\GelombangPelatihan;
use App\Models\Pelatihan;
use App\Models\ProfilUser;
use App\Models\Rekening;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

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

        // Seeder Pelatihan
        $pelatihan = Pelatihan::factory()->count(5)->create();

        // Seeder Batch untuk tiap pelatihan
        foreach ($pelatihan as $p) {
            // Misal tiap pelatihan punya 1 batch
            GelombangPelatihan::create([
                'nama_gelombang' => "{$p->nama_pelatihan} - Gelombang ke 1",
                'pelatihan_id' => $p->id,
                'tanggal_mulai' => now()->addDays(rand(1, 30)),
                'tanggal_selesai' => now()->addMonths($p->durasi_pelatihan),
                'sesi' => SesiGelombangPelatihanEnum::PENDAFTARAN,
                'maksimal_peserta' => random_int(100, 200),
            ]);
        }

        // Seeder Profil User dan Pendaftaran
        $seeder_profil_user = ProfilUser::factory()->withUser()->count(25)->create();
        foreach ($seeder_profil_user as $profil_user) {
            $pelatihan_user = $pelatihan->random();

            // Pendaftaran
            $pendaftaran = $profil_user->users->pendaftaran_pelatihan()->create([
                'status' => StatusPendaftaranPelatihanEnum::DALAM_PROSES,
                'pelatihan_id' => $pelatihan_user->id,
                'skema_pembayaran' => SkemaPembayaranEnum::CICILAN,
                'tenor' => TenorCicilanPelatihanEnum::ENAM_BULAN,
            ]);

            // Optional: DP
            $rekening_bendahara = Rekening::rekening_bendahara()->first();
            $membayar_dp = Arr::random([true, false]);
            if ($membayar_dp) {
                $nominal_dp = ($pelatihan_user->persentasi_dp / 100) * $pelatihan_user->nominal_biaya;
                $pendaftaran->pembayaran_pelatihan()->create([
                    'nominal' => $nominal_dp,
                    'status' => StatusPembayaranPelatihanEnum::SUDAH_BAYAR,
                    'jenis_pembayaran' => JenisPembayaranEnum::DP,
                    'bukti_pembayaran' => 'users/pembayaran_pelatihan/bukti_bayar.jpg',
                    'tanggal_pembayaran' => now(),
                ]);
                $transaksi = $rekening_bendahara->transaksi_rekening()->create([
                    'nominal_transaksi' => $nominal_dp,
                    'tipe_transaksi' => TipeTransaksiEnum::PEMASUKAN,
                    'keterangan' => "Pembayaran DP untuk pelatihan {$pelatihan_user->nama_pelatihan} dari {$profil_user->nama_lengkap}",
                ]);

                if ($transaksi->wasRecentlyCreated) {
                    $rekening_bendahara->increment('saldo', $transaksi->nominal_transaksi);
                    $rekening_bendahara->save();
                }
            }
        }
    }
}
