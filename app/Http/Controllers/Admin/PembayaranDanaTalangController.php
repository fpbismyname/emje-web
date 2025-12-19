<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Utils\PaginateSize;
use App\Exports\PembayaranDanaTalangExport;
use App\Http\Controllers\Controller;
use App\Models\PengajuanKontrakKerja;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;

class PembayaranDanaTalangController extends Controller
{
    public function index(Request $request, PengajuanKontrakKerja $pengajuan_kontrak_kerja_model)
    {
        $filters = $request->only('search', 'sumber_dana');

        $query = $pengajuan_kontrak_kerja_model->query();

        foreach ($filters as $key => $value) {
            match ($key) {
                'search' => $query->search($value),
                default => $query->search_by_column($key, $value)
            };
        }

        $datas = $query->latest()->paginate(PaginateSize::SMALL->value)->withQueryString();

        $payload = compact('datas');
        return view('admin.pembayaran-dana-talang.index', $payload);
    }
    public function show(string $id, PengajuanKontrakKerja $pengajuan_kontrak_kerja_model)
    {
        $pengajuan_kontrak_kerja = $pengajuan_kontrak_kerja_model->findOrFail($id);
        $payload = compact('pengajuan_kontrak_kerja');
        return view('admin.pembayaran-dana-talang.show', $payload);
    }
    public function export(Request $request, PengajuanKontrakKerja $pengajuan_kontrak_kerja_model, Excel $excel)
    {
        $filters = $request->only('search', 'sumber_dana');

        $query = $pengajuan_kontrak_kerja_model->query();

        foreach ($filters as $key => $value) {
            match ($key) {
                'search' => $query->search($value),
                default => $query->search_by_column($key, $value)
            };
        }

        $data_export = $query->get();

        $today = now()->format('d_M_Y-H_i_s');
        $file_name = "data_pembayaran_dana_talang_{$today}.xlsx";

        return $excel->download(new PembayaranDanaTalangExport($data_export), $file_name);
    }
}
