<?php

namespace App\Enums\KontrakKerja;

enum StatusKontrakKerjaDiikutiEnum: string
{
    case BERLANGSUNG = 'berlangsung';
    case SELESAI = 'selesai';
    case DIBATALKAN = 'dibatalkan';
}
