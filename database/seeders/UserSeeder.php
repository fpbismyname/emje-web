<?php

namespace Database\Seeders;

use App\Enums\Pelatihan\JenisPembayaranEnum;
use App\Enums\Pelatihan\JenisUjianEnum;
use App\Enums\Pelatihan\KategoriPelatihanEnum;
use App\Enums\Pelatihan\SesiGelombangPelatihanEnum;
use App\Enums\Pelatihan\SkemaPembayaranEnum;
use App\Enums\Pelatihan\StatusJadwalUjianPelatihanEnum;
use App\Enums\Pelatihan\StatusPelatihanEnum;
use App\Enums\Pelatihan\StatusPelatihanPesertaEnum;
use App\Enums\Pelatihan\StatusPembayaranPelatihanEnum;
use App\Enums\Pelatihan\StatusPendaftaranPelatihanEnum;
use App\Enums\Pelatihan\TenorCicilanPelatihanEnum;
use App\Enums\Rekening\TipeTransaksiEnum;
use App\Enums\User\JenisKelaminEnum;
use App\Enums\User\RoleEnum;
use App\Models\GelombangPelatihan;
use App\Models\KontrakKerja;
use App\Models\Pelatihan;
use App\Models\ProfilUser;
use App\Models\Rekening;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

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
        $pelatihan_list = [
            ['title' => 'Sistem Akuakultur Cerdas Berbasis IoT dan AI', 'biaya' => config('rules-lpk.biaya_pelatihan'), 'durasi' => 8],
            ['title' => 'Recirculating Aquaculture System (RAS) Tingkat Lanjut', 'biaya' => config('rules-lpk.biaya_pelatihan'), 'durasi' => 6],
            ['title' => 'Akuakultur Berkelanjutan dan Manajemen Lingkungan', 'biaya' => config('rules-lpk.biaya_pelatihan'), 'durasi' => 9],
            ['title' => 'Manajemen Kesehatan Ikan dan Biosek    uriti Global', 'biaya' => config('rules-lpk.biaya_pelatihan'), 'durasi' => 6],
            ['title' => 'Pengolahan Hasil Perikanan dan Standar Mutu Internasional', 'biaya' => config('rules-lpk.biaya_pelatihan'), 'durasi' => 4],
            ['title' => 'Pertanian Presisi Berbasis Drone dan GIS', 'biaya' => config('rules-lpk.biaya_pelatihan'), 'durasi' => 7],
            ['title' => 'Greenhouse dan Vertical Farming Modern', 'biaya' => config('rules-lpk.biaya_pelatihan'), 'durasi' => 6],
            ['title' => 'Sistem Irigasi Cerdas dan Manajemen Air', 'biaya' => config('rules-lpk.biaya_pelatihan'), 'durasi' => 7],
            ['title' => 'Manajemen Pertanian Digital dan Traceability', 'biaya' => config('rules-lpk.biaya_pelatihan'), 'durasi' => 9],
            ['title' => 'Pertanian Sirkular dan Bioekonomi Berkelanjutan', 'biaya' => config('rules-lpk.biaya_pelatihan'), 'durasi' => 6],
        ];
        $pelatihan = [];

        foreach ($pelatihan_list as $item) {
            $pelatihan[] = Pelatihan::create([
                'nama_pelatihan' => Str::title($item['title']),
                'nominal_biaya' => $item['biaya'],
                'persentase_dp' => fake()->numberBetween(10, 20),
                'durasi_pelatihan' => $item['durasi'],
                'kategori_pelatihan' => Arr::random(KategoriPelatihanEnum::getValues()),
                'deskripsi' => fake()->paragraph(2, true),
                'status' => StatusPelatihanEnum::AKTIF->value,
            ]);
        }

        // Seeder kontrak kekrja
        $kontrak_kerja = KontrakKerja::factory()->count(20)->create();

        // Seeder Batch untuk tiap pelatihan
        foreach ($pelatihan as $p) {
            // Misal tiap pelatihan punya 1 batch
            $gelombang = GelombangPelatihan::create([
                'nama_gelombang' => "{$p->nama_pelatihan} - Gelombang 1",
                'pelatihan_id' => $p->id,
                'tanggal_mulai' => now(),
                'tanggal_selesai' => now()->addMonths($p->durasi_pelatihan),
                'sesi' => SesiGelombangPelatihanEnum::PENDAFTARAN,
                'maksimal_peserta' => random_int(100, 200),
            ]);

            // jadwal ujian gelombang
            $start_date = now();

            $ujian_pelatihan = JenisUjianEnum::cases();


            if (!empty($ujian_pelatihan)) {
                foreach ($ujian_pelatihan as $ujian) {
                    $gelombang->jadwal_ujian_pelatihan()->create([
                        'nama_ujian' => "Ujian {$ujian->value}",
                        'lokasi' => fake()->city(),
                        'jenis_ujian' => $ujian,
                        'tanggal_mulai' => $start_date,
                        'tanggal_selesai' => $start_date->copy()->addWeek(),
                        'status' => StatusJadwalUjianPelatihanEnum::TERJADWAL,
                    ]);
                    $start_date->addWeek();
                }
            }
        }

        // Seeder Profil User dan Pendaftaran
        $users = [
            ['nama_lengkap' => 'Avi', 'gender' => JenisKelaminEnum::PRIA],
            ['nama_lengkap' => 'Dedi Hidayat', 'gender' => JenisKelaminEnum::PRIA],
            ['nama_lengkap' => 'Dimas Ariandi', 'gender' => JenisKelaminEnum::PRIA],
            ['nama_lengkap' => 'Donny Renaldi', 'gender' => JenisKelaminEnum::PRIA],
            ['nama_lengkap' => 'Fitrah Alfiansyah', 'gender' => JenisKelaminEnum::PRIA],
            ['nama_lengkap' => 'Gunanta Barus', 'gender' => JenisKelaminEnum::PRIA],
            ['nama_lengkap' => 'Prima Renaldi Sitepu', 'gender' => JenisKelaminEnum::PRIA],
            ['nama_lengkap' => 'Rafli Kurniawan', 'gender' => JenisKelaminEnum::PRIA],
            ['nama_lengkap' => 'Riza Rinaldi', 'gender' => JenisKelaminEnum::PRIA],
            ['nama_lengkap' => 'Sandi Erlangga', 'gender' => JenisKelaminEnum::PRIA],
        ];
        $seeder_profil_user = [];
        foreach ($users as $user) {
            $seeder_profil_user[] = ProfilUser::factory()->withUser()->create([
                'nama_lengkap' => $user['nama_lengkap'],
                'jenis_kelamin' => $user['gender'],
            ]);
        }
        // $seeder_profil_user = ProfilUser::factory()->withUser()->count(25)->create();
        foreach ($seeder_profil_user as $profil_user) {
            $pelatihan_user = collect($pelatihan)->random();

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
