<?php

namespace App\Enums\Pelatihan;

use Illuminate\Support\Str;

enum StatusHasilUjianPelatihanEnum: string
{
    case LULUS = 'lulus';
    case TIDAK_LULUS = 'tidak_lulus';
    case REMEDIAL = 'remedial';
    public function label()
    {
        return Str::of($this->value)->replace("_", " ")->ucfirst();
    }
    public static function getValues()
    {
        return collect(self::cases())->pluck('value')->toArray();
    }
}
