<?php

namespace App\Enums\Pelatihan;

use Illuminate\Support\Str;

enum MetodePembayaranEnum: string
{
    case CASH = 'cash';
    case CICILAN = 'cicilan';
    public function label()
    {
        return Str::of($this->value)->replace("_", " ")->ucfirst();
    }
}
