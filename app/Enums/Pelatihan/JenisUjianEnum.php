<?php

namespace App\Enums\Pelatihan;

use Illuminate\Support\Str;

enum JenisUjianEnum: string
{
    case PELATIHAN = 'pelatihan';
    case SSW = 'SSW';

    public function label()
    {
        return Str::of($this->value)->replace("_", " ")->ucfirst();
    }
    public static function getValues()
    {
        return collect(self::cases())->pluck('value')->toArray();
    }
}
