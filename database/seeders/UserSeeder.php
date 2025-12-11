<?php

namespace Database\Seeders;

use App\Enums\KontrakKerja\StatusPengajuanKontrakKerja;
use App\Enums\Pelatihan\JenisPembayaranEnum;
use App\Enums\Pelatihan\SesiGelombangPelatihanEnum;
use App\Enums\Pelatihan\SkemaPembayaranEnum;
use App\Enums\Pelatihan\StatusHasilUjianPelatihanEnum;
use App\Enums\Pelatihan\StatusJadwalUjianPelatihanEnum;
use App\Enums\Pelatihan\StatusPelatihanPesertaEnum;
use App\Enums\Pelatihan\StatusPembayaranPelatihanEnum;
use App\Enums\Pelatihan\StatusPendaftaranPelatihanEnum;
use App\Enums\Pelatihan\TenorCicilanPelatihanEnum;
use App\Enums\Rekening\TipeTransaksiEnum;
use App\Enums\User\RoleEnum;
use App\Models\GelombangPelatihan;
use App\Models\KontrakKerja;
use App\Models\Pelatihan;
use App\Models\ProfilUser;
use App\Models\Rekening;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $now = now();

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

        // Seeder kontrak kekrja
        $kontrak_kerja = KontrakKerja::factory()->count(5)->create();

        // Seeder Batch untuk tiap pelatihan
        foreach ($pelatihan as $p) {
            // Misal tiap pelatihan punya 1 batch
            $gelombang = GelombangPelatihan::create([
                'nama_gelombang' => "{$p->nama_pelatihan} - Gelombang ke 1",
                'pelatihan_id' => $p->id,
                'tanggal_mulai' => now(),
                'tanggal_selesai' => now()->addMonths($p->durasi_pelatihan),
                'sesi' => SesiGelombangPelatihanEnum::PENDAFTARAN,
                'maksimal_peserta' => random_int(100, 200),
            ]);

            // jadwal ujian gelombang
            $gelombang->jadwal_ujian_pelatihan()->create([
                'nama_ujian' => "Ujian $p->nama_pelatihan",
                'lokasi' => Arr::random(['Cianjur', 'Sukabumi', 'Cipanas']),
                'tanggal_mulai' => $now,
                'tanggal_selesai' => $now->clone()->addWeeks(1),
                'status' => StatusJadwalUjianPelatihanEnum::TERJADWAL
            ]);
        }

        // Seeder Profil User dan Pendaftaran
        $seeder_profil_user = ProfilUser::factory()->withUser()->count(25)->create();
        foreach ($seeder_profil_user as $profil_user) {
            $pelatihan_user = $pelatihan->random();

            $pembayaran_menyicil = Arr::random([true, false]);
            $tenor_cicilan = Arr::random([TenorCicilanPelatihanEnum::TIGA_BULAN, TenorCicilanPelatihanEnum::ENAM_BULAN, TenorCicilanPelatihanEnum::SEMBILAN_BULAN, TenorCicilanPelatihanEnum::DUA_BELAS_BULAN]);

            // Pendaftaran
            $pendaftaran = $profil_user->users->pendaftaran_pelatihan()->create([
                'status' => Arr::random([StatusPendaftaranPelatihanEnum::DALAM_PROSES, StatusPendaftaranPelatihanEnum::DITERIMA]),
                'pelatihan_id' => $pelatihan_user->id,
                'skema_pembayaran' => $pembayaran_menyicil ? SkemaPembayaranEnum::CICILAN : SkemaPembayaranEnum::CASH,
                'tenor' => $pembayaran_menyicil ? $tenor_cicilan : null,
                'gelombang_pelatihan_id' => $pelatihan_user->gelombang_pelatihan->first()->id
            ]);

            // Pembayaran pelatihan
            $rekening_bendahara = Rekening::rekening_bendahara()->first();
            if ($pendaftaran->skema_pembayaran === SkemaPembayaranEnum::CASH) {
                $pendaftaran->pembayaran_pelatihan()->create([
                    'nominal' => $pelatihan_user->nominal_biaya,
                    'status' => StatusPembayaranPelatihanEnum::SUDAH_BAYAR,
                    'jenis_pembayaran' => JenisPembayaranEnum::CASH,
                    'bukti_pembayaran' => 'users/pembayaran_pelatihan/bukti_bayar.jpg',
                    'tanggal_pembayaran' => $now->clone(),
                ]);

                $transaksi_cash = $rekening_bendahara->transaksi_rekening()->create([
                    'nominal_transaksi' => $pelatihan_user->nominal_biaya,
                    'tipe_transaksi' => TipeTransaksiEnum::PEMASUKAN,
                    'keterangan' => "Pembayaran cash untuk pelatihan {$pelatihan_user->nama_pelatihan} dari {$profil_user->nama_lengkap}",
                ]);

                if ($transaksi_cash->wasRecentlyCreated) {
                    $rekening_bendahara->increment('saldo', $transaksi_cash->nominal_transaksi);
                    $rekening_bendahara->save();
                }
            }
            if ($pendaftaran->skema_pembayaran === SkemaPembayaranEnum::CICILAN) {
                $nominal_dp = ($pelatihan_user->persentase_dp / 100) * $pelatihan_user->nominal_biaya;
                $pendaftaran->pembayaran_pelatihan()->create([
                    'nominal' => $nominal_dp,
                    'status' => StatusPembayaranPelatihanEnum::SUDAH_BAYAR,
                    'jenis_pembayaran' => JenisPembayaranEnum::DP,
                    'bukti_pembayaran' => 'users/pembayaran_pelatihan/bukti_bayar.jpg',
                    'tanggal_pembayaran' => $now->clone(),
                ]);

                $transaksi_cicilan = $rekening_bendahara->transaksi_rekening()->create([
                    'nominal_transaksi' => $nominal_dp,
                    'tipe_transaksi' => TipeTransaksiEnum::PEMASUKAN,
                    'keterangan' => "Pembayaran dp untuk pelatihan {$pelatihan_user->nama_pelatihan} dari {$profil_user->nama_lengkap}",
                ]);

                if ($transaksi_cicilan->wasRecentlyCreated) {
                    $rekening_bendahara->increment('saldo', $transaksi_cicilan->nominal_transaksi);
                    $rekening_bendahara->save();
                }

                $nominal_cicilan = ($pelatihan_user->nominal_biaya - $nominal_dp) / $tenor_cicilan->value;
                $tanggal_jatuh_tempo_cicilan = Carbon::parse($pendaftaran->gelombang_pelatihan->tanggal_mulai);

                for ($i = 0; $i < $tenor_cicilan->value; $i++) {
                    $pendaftaran->pembayaran_pelatihan()->create([
                        'nominal' => $nominal_cicilan,
                        'status' => StatusPembayaranPelatihanEnum::BELUM_BAYAR,
                        'jenis_pembayaran' => JenisPembayaranEnum::ANGSURAN,
                        'bukti_pembayaran' => null,
                        'tanggal_pembayaran' => $tanggal_jatuh_tempo_cicilan->clone()->addMonths($i),
                    ]);
                }
            }


            if ($pendaftaran->status === StatusPendaftaranPelatihanEnum::DITERIMA) {
                $gelombang = $pelatihan_user->gelombang_pelatihan()->first();
                if (isset($gelombang->id)) {
                    $pelatihan_peserta = $pendaftaran->pelatihan_peserta()->create([
                        'status' => StatusPelatihanPesertaEnum::BERLANGSUNG,
                        'gelombang_pelatihan_id' => $gelombang->id
                    ]);
                }
            }
        }
    }
}
