<?php

namespace App\Enums\User;

use Illuminate\Support\Str;

enum JenisKelaminEnum: string
{
    case PRIA = 'pria';
    case WANITA = 'wanita';
    public function label()
    {
        return Str::of($this->value)->replace("_", " ")->ucfirst();
    }
    public static function getValues()
    {
        return collect(self::cases())->pluck('value')->all();
    }
}
