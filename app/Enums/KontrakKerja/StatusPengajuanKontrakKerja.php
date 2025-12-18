<?php

namespace App\Enums\KontrakKerja;

use Illuminate\Support\Str;

enum StatusPengajuanKontrakKerja: string
{
    case DITOLAK = 'ditolak';
    case DITERIMA = 'diterima';
    case PROSES_PENGAJUAN = 'proses_pengajuan';
    case DIBATALKAN = 'dibatalkan';
    public static function case_review()
    {
        return collect(self::cases())->filter(fn($case) => in_array($case, [self::DITERIMA, self::DITOLAK]));
    }
    public function label()
    {
        return Str::of($this->value)->replace("_", " ")->ucfirst();
    }
    public static function getValues()
    {
        return collect(self::cases())->pluck('value')->toArray();
    }
}
