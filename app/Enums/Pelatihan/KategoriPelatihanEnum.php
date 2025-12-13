<?php

namespace App\Enums\Pelatihan;

use Illuminate\Support\Str;

enum KategoriPelatihanEnum: string
{
    case PERIKANAN = 'perikanan';
    case PERTANIAN = 'pertanian';
    public function label()
    {
        return Str::of($this->value)->replace("_", " ")->ucfirst();
    }
    public static function getValues()
    {
        return array_column(self::cases(), 'value');
    }
}
