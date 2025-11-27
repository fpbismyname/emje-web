<?php

namespace App\Enums\User;

use Illuminate\Support\Str;

enum RoleEnum: string
{
    case ADMIN = 'admin';
    case PESERTA = 'peserta';
    case BENDAHARA = 'bendahara';
    case PENGELOLA_PENDAFTARAN = 'pengelola_pendaftaran';
    public static function admin_user()
    {
        return collect(RoleEnum::cases())->filter(fn($role) => $role != RoleEnum::PESERTA)->toArray();
    }
    public static function client_user()
    {
        return collect(RoleEnum::cases())->filter(fn($role) => $role == RoleEnum::PESERTA)->toArray();
    }
    public function label()
    {
        return Str::of($this->value)->replace("_", " ")->ucfirst();
    }
    public static function getValues($type = "all")
    {
        return match ($type) {
            'all' => collect(self::cases())->pluck('value')->toArray(),
            'client_user' => collect(self::client_user())->pluck('value')->toArray(),
            'admin_user' => collect(self::admin_user())->pluck('value')->toArray(),
        };
    }
}
