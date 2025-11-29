<?php

namespace App\Enums\Pelatihan;

use Illuminate\Support\Str;

enum JenisPembayaranEnum: string
{
    case PELUNASAN = 'pelunasan';
    case ANGSURAN = 'angsuran';
    case DP = 'dp';
    public function label()
    {
        return Str::of($this->value)->replace("_", " ")->ucfirst();
    }
    public static function getValues()
    {
        return collect(self::cases())->pluck('value')->toArray();
    }
}
