<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Utils\PaginateSize;
use App\Exports\PembayaranPelatihanExport;
use App\Http\Controllers\Controller;
use App\Models\PembayaranPelatihan;
use App\Models\PendaftaranPelatihan;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;

class PembayaranPelatihanController extends Controller
{
    public function index(Request $request, PendaftaranPelatihan $pendaftaran_pelatihan_model)
    {
        $filters = $request->only('search', 'skema_pembayaran');

        $query = $pendaftaran_pelatihan_model->query();

        foreach ($filters as $key => $value) {
            match ($key) {
                'search' => $query->search($value),
                default => $query->search_by_column($key, $value)
            };
        }

        $datas = $query->latest()->paginate(PaginateSize::SMALL->value)->withQueryString();

        $payload = compact('datas');
        return view('admin.pembayaran-pelatihan.index', $payload);
    }
    public function show(string $id, PendaftaranPelatihan $pendaftaran_pelatihan_model)
    {
        $pendaftaran_pelatihan = $pendaftaran_pelatihan_model->findOrFail($id);
        $payload = compact('pendaftaran_pelatihan');
        return view('admin.pembayaran-pelatihan.show', $payload);
    }
    public function export(Request $request, PendaftaranPelatihan $pendaftaran_pelatihan_model, Excel $excel)
    {
        // Get search query
        $filters = $request->only('search', 'skema_pembayaran');

        $query = $pendaftaran_pelatihan_model->query();

        foreach ($filters as $key => $value) {
            match ($key) {
                'search' => $query->search($value),
                default => $query->search_by_column($key, $value)
            };
        }

        $data_export = $query->get();

        $today = now()->format('d_M_Y-H_i_s');
        $file_name = "data_pembayaran_pelatihan_{$today}.xlsx";

        return $excel->download(new PembayaranPelatihanExport($data_export), $file_name);
    }
}
