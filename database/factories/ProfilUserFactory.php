<?php

namespace Database\Factories;

use App\Enums\User\JenisKelaminEnum;
use App\Enums\User\PendidikanTerakhirEnum;
use App\Enums\User\RoleEnum;
use App\Models\User;
use Closure;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProfilUser>
 */
class ProfilUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $gender = $this->faker->randomElement([JenisKelaminEnum::PRIA->value, JenisKelaminEnum::WANITA->value]);
        $fullname = "{$this->faker->firstName($gender)} {$this->faker->lastName($gender)}";
        return [
            'nama_lengkap' => $fullname,
            'alamat' => $this->faker->address(),
            'nomor_telepon' => $this->faker->numerify("08##########"),
            'pendidikan_terakhir' => $this->faker->randomElement([PendidikanTerakhirEnum::SMK_SMA->value, PendidikanTerakhirEnum::D3_S1->value]),
            'jenis_kelamin' => $gender,
            'tanggal_lahir' => $this->faker->dateTimeBetween(now()->subYears(30), now()->subYears(15)),
            'ktp' => '',
            'foto_profil' => '',
            'ijazah' => '',
        ];
    }
    public function withUser()
    {
        return $this->afterCreating(function ($profil_user) {
            $user = User::factory()->create([
                'name' => $profil_user->nama_lengkap,
                'email' => Str::of($profil_user->nama_lengkap)->lower()->replace(" ", "_") . "@gmail.com",
                'password' => Str::of($profil_user->nama_lengkap)->lower()->replace(" ", "_") . "123",
                'role' => RoleEnum::PESERTA
            ]);
            $profil_user->users_id = $user->id;
            $profil_user->save();
        });
    }
}
