<?php

namespace App\Enums\Pelatihan;

use Illuminate\Support\Str;

enum StatusPelatihanEnum: string
{
    case AKTIF = 'aktif';
    case NONAKTIF = 'nonaktif';
    public function label()
    {
        return Str::of($this->value)->replace("_", " ")->ucfirst();
    }
    public static function getValues()
    {
        return collect(self::cases())->pluck('value')->toArray();
    }
}
