<?php

namespace App\Enums\Pelatihan;

use Illuminate\Support\Str;

enum StatusPelatihanDiikutiEnum: string
{
    case BERLANGSUNG = 'berlangsung';
    case SELESAI = 'selesai';
    case DIBATALKAN = 'dibatalkan';
    case DALAM_PROSES = 'dalam_proses';
    public function label()
    {
        return Str::of($this->value)->replace("_", " ")->ucfirst();
    }
}
