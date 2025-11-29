<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Utils\PaginateSize;
use App\Http\Controllers\Controller;
use App\Models\Rekening;
use Illuminate\Http\Request;

class RekeningController extends Controller
{
    public function index(Request $request, Rekening $rekening_model)
    {
        $filters = $request->only('search', 'tipe_transaksi');

        $rekening_bendahara = $rekening_model->rekening_bendahara()->first();

        $query_transaksi = $rekening_bendahara->transaksi_rekening();

        foreach ($filters as $key => $value) {
            match ($key) {
                'search' => $query_transaksi->search($value),
                default => $query_transaksi->search_by_column($key, $value)
            };
        }

        $datas_rekening = $rekening_bendahara;
        $datas_transaksi = $query_transaksi->latest()->paginate(PaginateSize::SMALL->value)->withQueryString();

        $payload = compact('datas_rekening', 'datas_transaksi');
        return view('admin.rekening.index', $payload);
    }
}
