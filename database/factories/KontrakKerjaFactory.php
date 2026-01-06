<?php

namespace Database\Factories;

use App\Enums\KontrakKerja\StatusKontrakKerjaEnum;
use App\Enums\Pelatihan\KategoriPelatihanEnum;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class KontrakKerjaFactory extends Factory
{
    public function definition(): array
    {
        // Salary range realistic
        $min = $this->faker->numberBetween(12, 20) * 1000000;
        $max = $this->faker->numberBetween(25, 45) * 1000000;
        if ($min >= $max) {
            $max = $min + 5000000;
        }

        // Deskripsi kontrak kerja
        $deskripsi_kontrak_kerja = implode("\n", [
            'Kualifikasi:',
            '- Pendidikan minimal SMK/SMA relevan',
            '- Memiliki keterampilan dan kedisiplinan',
            '- Memahami standar kerja internasional',
            '- Mampu bekerja di lingkungan multikultural',
            '',
            'Tanggung Jawab:',
            '- Menjalankan operasional sesuai SOP',
            '- Membuat laporan berkala',
            '- Mematuhi standar keselamatan kerja',
        ]);

        // Pilih kategori kontrak kerja random
        $kategori = Arr::random(KategoriPelatihanEnum::getValues());

        return [
            'nama_perusahaan' => $this->faker->company(),
            'gaji_terendah' => $min,
            'gaji_tertinggi' => $max,
            'status' => StatusKontrakKerjaEnum::AKTIF->value,
            'deskripsi' => $deskripsi_kontrak_kerja,
            'maksimal_pelamar' => $this->faker->numberBetween(20, 400),
            'durasi_kontrak_kerja' => $this->faker->numberBetween(1, 6),
            'kategori_kontrak_kerja' => $kategori,
        ];
    }
}
