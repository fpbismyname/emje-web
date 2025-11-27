<?php

namespace App\Enums\Pelatihan;

use Illuminate\Support\Str;

enum StatusCicilanPelatihanEnum: string
{
    case DIBAYAR = 'dibayar';
    case BELUM_DIBAYAR = 'belum_dibayar';
    case DIBATALKAN = 'DIBATALKAN';
    public function label()
    {
        return Str::of($this->value)->replace("_", " ")->ucfirst();
    }
}
