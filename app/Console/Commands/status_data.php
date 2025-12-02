<?php

namespace App\Console\Commands;

use App\Enums\Pelatihan\SesiGelombangPelatihanEnum;
use App\Enums\Pelatihan\StatusHasilUjianPelatihanEnum;
use App\Enums\Pelatihan\StatusJadwalUjianPelatihanEnum;
use App\Enums\Pelatihan\StatusPelatihanPesertaEnum;
use App\Models\GelombangPelatihan;
use App\Models\HasilUjianPelatihan;
use App\Models\JadwalUjianPelatihan;
use App\Models\PelatihanPeserta;
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
        $gelombang_pelatihan = GelombangPelatihan::query()->get();
        $jadwal_ujian_pelatihan = JadwalUjianPelatihan::query()->get();
        $list_pelatihan_peserta = PelatihanPeserta::query()->get();

        foreach ($gelombang_pelatihan as $gelombang) {
            match (true) {
                $gelombang->tanggal_selesai < now() => $gelombang->update(['sesi' => SesiGelombangPelatihanEnum::SELESAI]),
                $gelombang->tanggal_mulai > now() => $gelombang->update(['sesi' => SesiGelombangPelatihanEnum::PENDAFTARAN]),
                $gelombang->tanggal_mulai < now() && $gelombang->tanggal_selesai > now() => $gelombang->update(['sesi' => SesiGelombangPelatihanEnum::BERLANGSUNG]),
                default => null
            };

            foreach ($jadwal_ujian_pelatihan as $jadwal_ujian) {
                match (true) {
                    $jadwal_ujian->tanggal_selesai <= now() => $jadwal_ujian->update(['status' => StatusJadwalUjianPelatihanEnum::SELESAI]),
                    $jadwal_ujian->tanggal_mulai >= now() => $jadwal_ujian->update(['status' => StatusJadwalUjianPelatihanEnum::TERJADWAL]),
                    $jadwal_ujian->tanggal_mulai <= now() && $jadwal_ujian->tanggal_selesai >= now() => $jadwal_ujian->update(['status' => StatusJadwalUjianPelatihanEnum::BERLANGSUNG]),
                    default => null
                };
                $data_ujian = HasilUjianPelatihan::where('jadwal_ujian_pelatihan_id', $jadwal_ujian->id)->get();
                $pelatihan_peserta = PelatihanPeserta::where('gelombang_pelatihan_id', $gelombang->id)->first();
                if ($gelombang->sesi === SesiGelombangPelatihanEnum::SELESAI) {
                    foreach ($data_ujian as $hasil_ujian) {
                        match (true) {
                            $hasil_ujian->nilai >= config('rules-lpk.nilai_ujian.remedial_minimum') && $hasil_ujian->nilai <= config('rules-lpk.nilai_ujian.remedial_maximum') => $hasil_ujian->update(['status' => StatusHasilUjianPelatihanEnum::REMEDIAL]),
                            $hasil_ujian->nilai < config('rules-lpk.nilai_ujian.remedial_minimum') => $hasil_ujian->update(['status' => StatusHasilUjianPelatihanEnum::TIDAK_LULUS]),
                            $hasil_ujian->nilai > config('rules-lpk.nilai_ujian.remedial_maximum') => $hasil_ujian->update(['status' => StatusHasilUjianPelatihanEnum::LULUS]),
                            default => null
                        };
                    }

                    $hasil_ujian_bagus = $data_ujian->each(fn($hasil) => $hasil->status === StatusHasilUjianPelatihanEnum::LULUS);

                    match (true) {
                        $hasil_ujian_bagus && $gelombang->status === SesiGelombangPelatihanEnum::SELESAI => $pelatihan_peserta->update(['status' => StatusPelatihanPesertaEnum::LULUS]),
                        !$hasil_ujian_bagus && $gelombang->status === SesiGelombangPelatihanEnum::SELESAI => $pelatihan_peserta->update(['status' => StatusPelatihanPesertaEnum::TIDAK_LULUS]),
                        default => null
                    };
                }
            }
        }

        foreach ($list_pelatihan_peserta as $pelatihan) {
            if ($pelatihan->status === StatusPelatihanPesertaEnum::LULUS && !$pelatihan->sertifikasi) {
                $pelatihan->sertifikasi()->create([
                    'nomor_sertifikat' => config('rules-lpk.prefix-sertifikasi') . now()->format('Y-m-d') . $pelatihan->id,
                    'tanggal_terbit' => now()
                ]);
            }
        }

        $this->info('Status data updated successfully.');
    }
}
