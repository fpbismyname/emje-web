<?php

namespace App\Http\Controllers\Client\KontrakKerja;

use App\Enums\Utils\PaginateSize;
use App\Http\Controllers\Controller;
use App\Models\KontrakKerja;
use Illuminate\Http\Request;

class DaftarKontrakKerjaController extends Controller
{
    public function index(Request $request, KontrakKerja $kontrak_kerja_model)
    {
        $filters = $request->only('search', 'kategori_pelatihan');

        $query = $kontrak_kerja_model->kontrak_kerja_aktif();

        foreach ($filters as $key => $value) {
            match ($key) {
                'search' => $query->search($value),
                default => $query->search_by_column($key, $value)
            };
        }

        $datas = $query->latest()->paginate(PaginateSize::SMALL->value)->withQueryString();

        $payload = compact('datas');
        return view('client.kontrak-kerja.daftar-kontrak-kerja.index', $payload);
    }

    public function show(string $id, KontrakKerja $kontrak_kerja_model)
    {
        $kontrak_kerja = $kontrak_kerja_model->findOrFail($id);
        $payload = compact('kontrak_kerja');
        return view('client.kontrak-kerja.daftar-kontrak-kerja.show', $payload);
    }
}
