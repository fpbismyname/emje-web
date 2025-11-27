<?php

namespace App\Enums\Rekening;

use Illuminate\Support\Str;

enum TipeTransaksiEnum: string
{
    case PEMASUKAN = 'pemasukan';
    case PENGELUARAN = 'pengeluaran';
    public function label()
    {
        return Str::of($this->value)->replace("_", " ")->ucfirst();
    }
}
