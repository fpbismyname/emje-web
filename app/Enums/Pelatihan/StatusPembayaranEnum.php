<?php

namespace App\Enums\Pelatihan;

use Illuminate\Support\Str;

enum StatusPembayaranEnum: string
{
    case LUNAS = 'lunas';
    case BELUM_LUNAS = 'belum_lunas';
    public function label()
    {
        return Str::of($this->value)->replace("_", " ")->ucfirst();
    }
    public static function getValues()
    {
        return collect(self::cases())->pluck('value')->toArray();
    }
}
