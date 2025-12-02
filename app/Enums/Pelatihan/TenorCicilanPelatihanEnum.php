<?php

namespace App\Enums\Pelatihan;

use Illuminate\Support\Str;

enum TenorCicilanPelatihanEnum: int
{
    case TIGA_BULAN = 3;
    case ENAM_BULAN = 6;
    case SEMBILAN_BULAN = 9;
    case DUA_BELAS_BULAN = 12;
    public function label()
    {
        return Str::of($this->value)->replace("_", " ")->ucfirst() . " Bulan";
    }
}
