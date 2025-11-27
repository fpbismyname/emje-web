<?php

namespace App\Enums\Pelatihan;

use Illuminate\Support\Str;

enum StatusPendaftaranPelatihanEnum: string
{
    case DITERIMA = 'diterima';
    case DITOLAK = 'ditolak';
    case DALAM_PROSES = 'dalam_proses';
    case DIBATALKAN = 'dibatalkan';
    public function label()
    {
        return Str::of($this->value)->replace("_", " ")->ucfirst();
    }
    public static function getValues()
    {
        return collect(self::cases())->pluck('value')->toArray();
    }
}
