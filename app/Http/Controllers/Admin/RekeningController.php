<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Utils\PaginateSize;
use App\Exports\TransaksiRekeningExport;
use App\Http\Controllers\Controller;
use App\Models\Rekening;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;

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
    public function export(Request $request, Rekening $rekening_model, Excel $excel)
    {
        // Get search query
        $filters = $request->only('search', 'tipe_transaksi');

        // Query model
        $rekening_bendahara = $rekening_model->rekening_bendahara()->first();
        $query = $rekening_bendahara->transaksi_rekening();

        // Search data if any search input
        if (!empty($filters)) {
            foreach ($filters as $key => $value) {
                match ($key) {
                    'search' => $query->search($value),
                    default => $query->search_by_column($key, $value),
                };

            }
        }
        $data_export = $query->get();

        $today = now()->format('d_M_Y-H_i_s');
        $file_name = "data_transaksi_rekening_{$rekening_bendahara->nama_rekening}_{$today}.xlsx";

        return $excel->download(new TransaksiRekeningExport($data_export), $file_name);
    }
}
