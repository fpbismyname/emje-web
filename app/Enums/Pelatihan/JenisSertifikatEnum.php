<?php

namespace App\Enums\Pelatihan;

use Illuminate\Support\Str;

enum JenisSertifikatEnum: string
{
    case SSW = 'ssw';
    case PELATIHAN = 'pelatihan';
    case BAHASA = 'bahasa';

    public function label()
    {
        return Str::of($this->value)->replace("_", " ")->ucfirst();
    }
    public static function getValues()
    {
        return collect(self::cases())->pluck('value')->toArray();
    }
}
