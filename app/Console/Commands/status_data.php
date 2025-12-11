<?php

namespace App\Console\Commands;

use App\Enums\KontrakKerja\StatusKontrakKerjaPesertaEnum;
use App\Enums\Pelatihan\JenisPembayaranEnum;
use App\Enums\Pelatihan\SesiGelombangPelatihanEnum;
use App\Enums\Pelatihan\StatusHasilUjianPelatihanEnum;
use App\Enums\Pelatihan\StatusJadwalUjianPelatihanEnum;
use App\Enums\Pelatihan\StatusPelatihanPesertaEnum;
use App\Enums\Pelatihan\StatusPembayaranPelatihanEnum;
use App\Models\GelombangPelatihan;
use App\Models\HasilUjianPelatihan;
use App\Models\JadwalUjianPelatihan;
use App\Models\KontrakKerjaPeserta;
use App\Models\PelatihanPeserta;
use App\Models\PembayaranPelatihan;
use App\Models\User;
use Illuminate\Console\Command;

class status_data extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:status-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check all status data in pelatihan, and kontrak kerja';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = now();

        /**
         * 1. Update status gelombang pelatihan
         */
        GelombangPelatihan::query()->chunk(100, function ($items) use ($now) {
            foreach ($items as $gelombang) {

                if ($now->lte($gelombang->tanggal_mulai)) {
                    $newSesi = SesiGelombangPelatihanEnum::PENDAFTARAN;

                }
                if ($now->between($gelombang->tanggal_mulai, $gelombang->tanggal_selesai)) {
                    $newSesi = SesiGelombangPelatihanEnum::BERLANGSUNG;

                }
                if ($now->gte($gelombang->tanggal_selesai)) {
                    // berarti $now > tanggal_selesai
                    $newSesi = SesiGelombangPelatihanEnum::SELESAI;
                }

                if ($gelombang->sesi !== $newSesi) {
                    $gelombang->update(['sesi' => $newSesi]);
                }

            }
        });

        JadwalUjianPelatihan::query()->chunk(100, function ($items) use ($now) {
            foreach ($items as $jadwal) {
                if ($now->lt($jadwal->tanggal_mulai)) {
                    $new = StatusJadwalUjianPelatihanEnum::TERJADWAL;
                } elseif ($now->between($jadwal->tanggal_mulai, $jadwal->tanggal_selesai)) {
                    $new = StatusJadwalUjianPelatihanEnum::BERLANGSUNG;
                } else {
                    $new = StatusJadwalUjianPelatihanEnum::SELESAI;
                }

                if ($jadwal->status !== $new) {
                    $jadwal->update(['status' => $new]);
                }
            }
        });

        HasilUjianPelatihan::query()->chunk(100, function ($items) {
            foreach ($items as $hasil) {

                $min = config('rules-lpk.nilai_ujian.remedial_minimum');

                if ($hasil->nilai < $min) {
                    $new = StatusHasilUjianPelatihanEnum::TIDAK_LULUS;
                } elseif ($hasil->nilai == $min) {
                    $new = StatusHasilUjianPelatihanEnum::REMEDIAL;
                } else {
                    $new = StatusHasilUjianPelatihanEnum::LULUS;
                }

                if ($hasil->status !== $new) {
                    $hasil->update(['status' => $new]);
                }
            }
        });


        PelatihanPeserta::query()
            ->with('hasil_ujian_pelatihan')
            ->where('status', StatusPelatihanPesertaEnum::BERLANGSUNG)
            ->chunk(100, function ($items) {
                foreach ($items as $peserta) {

                    $jadwal_ujian_selesai = $peserta->gelombang_pelatihan->jadwal_ujian_pelatihan()->get()->every(fn($q) => $q->status === StatusJadwalUjianPelatihanEnum::SELESAI);

                    if ($peserta->gelombang_pelatihan->sesi === SesiGelombangPelatihanEnum::SELESAI && $jadwal_ujian_selesai) {
                        if ($peserta->hasil_ujian_pelatihan->isEmpty())
                            continue;

                        $semuaLulus = $peserta->hasil_ujian_pelatihan
                            ->every(fn($h) => $h->status === StatusHasilUjianPelatihanEnum::LULUS);

                        $peserta->update([
                            'status' => $semuaLulus
                                ? StatusPelatihanPesertaEnum::LULUS
                                : StatusPelatihanPesertaEnum::TIDAK_LULUS
                        ]);
                    }
                }
            });


        PelatihanPeserta::where('status', StatusPelatihanPesertaEnum::LULUS)
            ->doesntHave('sertifikasi')
            ->get()
            ->each(function ($peserta) {
                $peserta->sertifikasi()->create([
                    'nomor_sertifikat' => config('rules-lpk.prefix-sertifikasi') . now()->format('Y-m-d') . $peserta->id,
                    'tanggal_terbit' => now(),
                ]);
            });

        PembayaranPelatihan::query()
            ->where('jenis_pembayaran', JenisPembayaranEnum::ANGSURAN)
            ->chunk(100, function ($items) {
                foreach ($items as $angsuran) {

                    $newStatus = $angsuran->bukti_pembayaran
                        ? StatusPembayaranPelatihanEnum::SUDAH_BAYAR
                        : StatusPembayaranPelatihanEnum::BELUM_BAYAR;

                    if ($angsuran->status !== $newStatus) {
                        $angsuran->update(['status' => $newStatus]);
                    }
                }
            });
        KontrakKerjaPeserta::query()
            ->where('status', StatusKontrakKerjaPesertaEnum::BERLANGSUNG)
            ->chunk(100, function ($items) {
                foreach ($items as $kontrak_kerja_peserta) {
                    $durasi_kontrak_tahun = $kontrak_kerja_peserta->pengajuan_kontrak_kerja->kontrak_kerja->durasi_kontrak_kerja;
                    $mulai_kontrak = $kontrak_kerja_peserta->created_at;
                    if ($mulai_kontrak->addYears($durasi_kontrak_tahun)->lt(now())) {
                        $kontrak_kerja_peserta->status = StatusKontrakKerjaPesertaEnum::SELESAI;
                    }
                }
            });

        $this->info('Status data updated successfully.');
    }
}
