<?php

namespace App\Enums\Pelatihan;

use Illuminate\Support\Str;

enum KategoriPelatihanEnum: string
{
    case MANUFAKTUR = 'manufaktur';
    case PENGOLAHAN_MAKANAN = 'pengolahan_makanan';
    case PERTANIAN = 'pertanian';
    case KONSTRUKSI = 'konstruksi';
    case KAIGO = 'kaigo';
    case LOGISTIK = 'logistik';
    case METAL = 'metal';
    public function label()
    {
        return Str::of($this->value)->replace("_", " ")->ucfirst();
    }
    public static function getValues()
    {
        return collect(self::cases())->pluck('value')->toArray();
    }
}
