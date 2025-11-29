<?php

namespace App\Enums\Pelatihan;

use Illuminate\Support\Str;

enum SkemaPembayaranEnum: string
{
    case CASH = 'cash';
    case CICILAN = 'cicilan';
    public function label()
    {
        return Str::of($this->value)->replace("_", " ")->ucfirst();
    }
    public static function getValues()
    {
        return collect(self::cases())->pluck('value')->toArray();
    }
}
