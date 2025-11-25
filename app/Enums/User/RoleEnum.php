<?php

namespace App\Enums\User;

enum RoleEnum: string
{
    case ADMIN = 'admin';
    case PESERTA = 'peserta';
    case BENDAHARA = 'bendahara';
    case PENGELOLA_PENDAFTARAN = 'pengelola_pendaftaran';
    public static function admin_user()
    {
        return collect(self::cases())->except(['peserta'])->toArray();
    }
    public static function client_user()
    {
        return collect(self::cases())->only(['peserta'])->toArray();
    }
}
