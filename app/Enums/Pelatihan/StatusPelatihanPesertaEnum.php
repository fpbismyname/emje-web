<?php

namespace App\Enums\Pelatihan;

use Illuminate\Support\Str;

enum StatusPelatihanPesertaEnum: string
{
    case BERLANGSUNG = 'berlangsung';
    case SELESAI = 'selesai';
    case DIBATALKAN = 'dibatalkan';
    public function label()
    {
        return Str::of($this->value)->replace("_", " ")->ucfirst();
    }
}
