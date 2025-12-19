<?php

namespace App\Enums\KontrakKerja;

use Illuminate\Support\Str;

enum SumberDanaEnum: string
{
    case DANA_TALANG = 'dana_talang';
    case MANDIRI = 'mandiri';
    public function label()
    {
        return Str::of($this->value)->replace("_", " ")->ucfirst();
    }
    public static function getValues()
    {
        return collect(self::cases())->pluck('value')->toArray();
    }
}
