<?php

namespace Database\Factories;

use App\Enums\KontrakKerja\StatusKontrakKerjaEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\KontrakKerja>
 */
class KontrakKerjaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = StatusKontrakKerjaEnum::getValues();

        // salary range realistic: min < max
        $min = $this->faker->numberBetween(8, 10) * 1000000;
        $max = $this->faker->numberBetween(15, 20) * 1000000;

        // Deskripsi kontrak kerja
        $deskripsi_kontrak_kerja = "Kualifikasi kontrak kerja : " . $this->faker->paragraph(10);
        return [
            'nama_perusahaan' => $this->faker->company(),
            'gaji_terendah' => $min,
            'gaji_tertinggi' => $max,
            'status' => $this->faker->randomElement($status),
            'deskripsi' => $deskripsi_kontrak_kerja,
            'durasi_kontrak_kerja' => $this->faker->numberBetween(1, 7),
        ];
    }
}
