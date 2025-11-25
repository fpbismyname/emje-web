<?php

namespace App\Enums\Rekening;

enum TipeTransaksiEnum: string
{
    case PEMASUKAN = 'pemasukan';
    case PENGELUARAN = 'pengeluaran';
}
