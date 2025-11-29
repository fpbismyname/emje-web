<?php

namespace App\Enums\Pelatihan;

use Illuminate\Support\Str;

enum StatusJadwalUjianPelatihanEnum: string
{
    case BERLANGSUNG = 'berlangsung';
    case TERJADWAL = 'terjadwal';
    case SELESAI = 'selesai';
    public function label()
    {
        return Str::of($this->value)->replace("_", " ")->ucfirst();
    }
}
