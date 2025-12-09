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

        // Seeder kontrak kekrja
        $kontrak_kerja = KontrakKerja::factory()->count(5)->create();

        // Seeder Batch untuk tiap pelatihan
        foreach ($pelatihan as $p) {
            // Misal tiap pelatihan punya 1 batch
            $gelombang = GelombangPelatihan::create([
                'nama_gelombang' => "{$p->nama_pelatihan} - Gelombang ke 1",
                'pelatihan_id' => $p->id,
                'tanggal_mulai' => now()->addDays(rand(1, 30)),
                'tanggal_selesai' => now()->addMonths($p->durasi_pelatihan),
                'sesi' => SesiGelombangPelatihanEnum::PENDAFTARAN,
                'maksimal_peserta' => random_int(100, 200),
            ]);

            // jadwal ujian gelombang
            $gelombang->jadwal_ujian_pelatihan()->create([
                'nama_ujian' => "Ujian $p->nama_pelatihan",
                'lokasi' => Arr::random(['Cianjur', 'Sukabumi', 'Cipanas']),
                'tanggal_mulai' => now()->subWeeks(1),
                'tanggal_selesai' => now()->subWeeks(2),
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
            ]);

            // pembayaran dp
            $rekening_bendahara = Rekening::rekening_bendahara()->first();

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

            if ($pendaftaran->skema_pembayaran === SkemaPembayaranEnum::CASH) {
                $pendaftaran->pembayaran_pelatihan()->create([
                    'nominal' => $pelatihan_user->nominal_biaya - $nominal_dp,
                    'status' => StatusPembayaranPelatihanEnum::SUDAH_BAYAR,
                    'jenis_pembayaran' => JenisPembayaranEnum::PELUNASAN,
                    'bukti_pembayaran' => 'users/pembayaran_pelatihan/bukti_bayar.jpg',
                    'tanggal_pembayaran' => now(),
                ]);

                $transaksi = $rekening_bendahara->transaksi_rekening()->create([
                    'nominal_transaksi' => $pelatihan_user->nominal_biaya - $nominal_dp,
                    'tipe_transaksi' => TipeTransaksiEnum::PEMASUKAN,
                    'keterangan' => "Pembayaran pelunasan untuk pelatihan {$pelatihan_user->nama_pelatihan} dari {$profil_user->nama_lengkap}",
                ]);
            }

            if ($transaksi->wasRecentlyCreated) {
                $rekening_bendahara->increment('saldo', $transaksi->nominal_transaksi);
                $rekening_bendahara->save();
            }

            if ($pendaftaran->status === StatusPendaftaranPelatihanEnum::DITERIMA) {
                $gelombang = $pelatihan_user->gelombang_pelatihan()->first();
                if (isset($gelombang->id)) {
                    $pelatihan_peserta = $pendaftaran->pelatihan_peserta()->create([
                        'status' => Arr::random([StatusPelatihanPesertaEnum::LULUS, StatusPelatihanPesertaEnum::BERLANGSUNG]),
                        'gelombang_pelatihan_id' => $gelombang->id
                    ]);

                    if ($pelatihan_peserta->status === StatusPelatihanPesertaEnum::LULUS) {
                        $jadwal_ujian = $gelombang->jadwal_ujian_pelatihan;
                        if ($jadwal_ujian) {
                            foreach ($jadwal_ujian as $jadwal) {
                                $jadwal->hasil_ujian_pelatihan()->create([
                                    'nama_materi' => "Materi $jadwal->nama_ujian",
                                    'nilai' => random_int(85, 94),
                                    'status' => StatusHasilUjianPelatihanEnum::LULUS
                                ]);
                            }
                        }

                        $pelatihan_peserta->pendaftaran_pelatihan->users->pengajuan_kontrak_kerja()->create([
                            'kontrak_kerja_id' => $kontrak_kerja->random()->id,
                            'surat_lamaran' => 'users/surat_lamaran/surat_lamaran.pdf',
                            'status' => StatusPengajuanKontrakKerja::DALAM_PROSES
                        ]);
                    }
                }
            }

            if ($pendaftaran->skema_pembayaran === SkemaPembayaranEnum::CASH) {
                $pendaftaran->pembayaran_pelatihan()->create([
                    'nominal' => $pelatihan_user->nominal_biaya - $nominal_dp,
                    'status' => StatusPembayaranPelatihanEnum::SUDAH_BAYAR,
                    'jenis_pembayaran' => JenisPembayaranEnum::PELUNASAN,
                    'bukti_pembayaran' => 'users/pembayaran_pelatihan/bukti_bayar.jpg',
                    'tanggal_pembayaran' => now(),
                ]);

                $transaksi = $rekening_bendahara->transaksi_rekening()->create([
                    'nominal_transaksi' => $pelatihan_user->nominal_biaya - $nominal_dp,
                    'tipe_transaksi' => TipeTransaksiEnum::PEMASUKAN,
                    'keterangan' => "Pembayaran pelunasan untuk pelatihan {$pelatihan_user->nama_pelatihan} dari {$profil_user->nama_lengkap}",
                ]);
            }

            if ($transaksi->wasRecentlyCreated) {
                $rekening_bendahara->increment('saldo', $transaksi->nominal_transaksi);
                $rekening_bendahara->save();
            }
        }
    }
}
