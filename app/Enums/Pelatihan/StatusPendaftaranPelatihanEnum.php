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
    public static function cases_review()
    {
        return collect(self::cases())->filter(fn($case) => in_array($case, [self::DITERIMA, self::DITOLAK]))->toArray();
    }
    public static function getValues($type = null)
    {
        return match ($type) {
            'cases_review' => collect(self::cases_review())->pluck('value')->toArray(),
            default => collect(self::cases())->pluck('value')->toArray()
        };
    }
}
