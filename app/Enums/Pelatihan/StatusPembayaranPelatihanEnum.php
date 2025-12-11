<?php

namespace App\Enums\Pelatihan;

use Illuminate\Support\Str;

enum StatusPembayaranPelatihanEnum: string
{
    case DIKEMBALIKAN = 'dikembalikan';
    case SUDAH_BAYAR = 'sudah_bayar';
    case BELUM_BAYAR = 'belum_bayar';
    public function label()
    {
        return Str::of($this->value)->replace("_", " ")->ucfirst();
    }
    public static function getValues()
    {
        return collect(self::cases())->pluck('value')->toArray();
    }
}
