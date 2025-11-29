<?php

namespace Database\Factories;

use App\Enums\Pelatihan\KategoriPelatihanEnum;
use App\Enums\Pelatihan\StatusPelatihanEnum;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pelatihan>
 */
class PelatihanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $kategori_pelatihan = KategoriPelatihanEnum::getValues();

        // nama pelatihan realistis
        $title = "Pelatihan " . $this->faker->unique()->jobTitle();
        $durasi = $this->faker->numberBetween(3, 12);
        $biaya = $this->faker->numberBetween(10, 50) * 100000;

        return [
            'nama_pelatihan' => Str::title($title),
            'nominal_biaya' => $biaya,
            'persentasi_dp' => $this->faker->numberBetween(10, 20),
            'durasi_pelatihan' => $durasi,
            'kategori_pelatihan' => $this->faker->randomElement($kategori_pelatihan),
            'deskripsi' => $this->faker->paragraphs(2, true),
            'status' => StatusPelatihanEnum::AKTIF,
        ];
    }
}
