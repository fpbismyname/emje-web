<?php

namespace App\Enums\Pelatihan;

enum StatusPelatihanDiikutiEnum: string
{
    case BERLANGSUNG = 'berlangsung';
    case SELESAI = 'selesai';
    case DIBATALKAN = 'dibatalkan';
    case DALAM_PROSES = 'dalam_proses';
}
