<?php

namespace App\Enums\Pelatihan;

enum StatusUjianPelatihanEnum: string
{
    case LULUS = 'lulus';
    case TIDAK_LULUS = 'tidak_lulus';
    case BERLANGSUNG = 'berlangsung';
}
