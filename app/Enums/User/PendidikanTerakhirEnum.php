<?php

namespace App\Enums\User;

use Illuminate\Support\Str;

enum PendidikanTerakhirEnum: string
{
    case D3_S1 = "d3/s1";
    case SMK_SMA = "smk/sma";
    case SMP = "smp";
    case SD = "sd";
    public function label()
    {
        return Str::of($this->value)->replace("_", " ")->upper();
    }
    public static function getValues()
    {
        return collect(self::cases())->pluck('value')->all();
    }
}
