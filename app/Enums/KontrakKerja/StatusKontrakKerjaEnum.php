<?php

namespace App\Enums\KontrakKerja;

use Illuminate\Support\Str;

enum StatusKontrakKerjaEnum: string
{
    case AKTIF = 'aktif';
    case NONAKTIF = 'nonaktif';
    public function label()
    {
        return Str::of($this->value)->replace("_", " ")->ucfirst();
    }
    public static function getValues()
    {
        return collect(self::cases())->pluck('value')->toArray();
    }
}
