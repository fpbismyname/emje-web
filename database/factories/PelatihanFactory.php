<?php

namespace Database\Factories;

use App\Enums\Pelatihan\KategoriPelatihanEnum;
use App\Enums\Pelatihan\StatusPelatihanEnum;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class PelatihanFactory extends Factory
{
    public function definition(): array
    {
        $pelatihan_list = [
            ['title' => 'Sistem Akuakultur Cerdas Berbasis IoT dan AI', 'biaya' => 7500000, 'durasi' => 8],
            ['title' => 'Recirculating Aquaculture System (RAS) Tingkat Lanjut', 'biaya' => 9000000, 'durasi' => 6],
            ['title' => 'Akuakultur Berkelanjutan dan Manajemen Lingkungan', 'biaya' => 6500000, 'durasi' => 9],
            ['title' => 'Manajemen Kesehatan Ikan dan Biosekuriti Global', 'biaya' => 7000000, 'durasi' => 6],
            ['title' => 'Pengolahan Hasil Perikanan dan Standar Mutu Internasional', 'biaya' => 8000000, 'durasi' => 4],
            ['title' => 'Pertanian Presisi Berbasis Drone dan GIS', 'biaya' => 8500000, 'durasi' => 7],
            ['title' => 'Greenhouse dan Vertical Farming Modern', 'biaya' => 9000000, 'durasi' => 6],
            ['title' => 'Sistem Irigasi Cerdas dan Manajemen Air', 'biaya' => 6000000, 'durasi' => 7],
            ['title' => 'Manajemen Pertanian Digital dan Traceability', 'biaya' => 7000000, 'durasi' => 9],
            ['title' => 'Pertanian Sirkular dan Bioekonomi Berkelanjutan', 'biaya' => 6500000, 'durasi' => 6],
        ];

        // Ambil salah satu pelatihan list per instance
        $item = Arr::random($pelatihan_list);

        return [
            'nama_pelatihan' => Str::title($item['title']),
            'nominal_biaya' => $item['biaya'],
            'persentase_dp' => $this->faker->numberBetween(10, 20),
            'durasi_pelatihan' => $item['durasi'],
            'kategori_pelatihan' => Arr::random(KategoriPelatihanEnum::getValues()),
            'deskripsi' => $this->faker->paragraph(2, true),
            'status' => StatusPelatihanEnum::AKTIF->value,
        ];
    }
}
