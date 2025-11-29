<?php

namespace App\Enums\Pelatihan;

use Illuminate\Support\Str;

enum SesiGelombangPelatihanEnum: string
{
    case BERLANGSUNG = 'berlangsung';
    case SELESAI = 'selesai';
    case PENDAFTARAN = 'pendaftaran';
    public function label()
    {
        return Str::of($this->value)->replace("_", " ")->ucfirst();
    }
}
