<?php

namespace App\Enums\Pelatihan;

enum StatusCicilanPelatihanEnum: string
{
    case DIBAYAR = 'dibayar';
    case BELUM_DIBAYAR = 'belum_dibayar';
    case DIBATALKAN = 'DIBATALKAN';
}
