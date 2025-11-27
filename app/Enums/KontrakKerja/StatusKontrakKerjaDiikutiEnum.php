<?php

namespace App\Enums\KontrakKerja;

use Illuminate\Support\Str;

enum StatusKontrakKerjaDiikutiEnum: string
{
    case BERLANGSUNG = 'berlangsung';
    case SELESAI = 'selesai';
    case DIBATALKAN = 'dibatalkan';
    public function label()
    {
        return Str::of($this->value)->replace("_", " ")->ucfirst();
    }
}
