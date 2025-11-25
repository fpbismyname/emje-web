<?php

namespace App\Enums\Pelatihan;

enum KategoriPelatihanEnum: string
{
    case MANUFAKTUR = 'manufaktur';
    case PENGOLAHAN_MAKANAN = 'pengolahan_makanan';
    case PERTANIAN = 'pertanian';
    case KONSTRUKSI = 'konstruksi';
    case KAIGO = 'kaigo';
    case LOGISTIK = 'logistik';
    case METAL = 'metal';
}
