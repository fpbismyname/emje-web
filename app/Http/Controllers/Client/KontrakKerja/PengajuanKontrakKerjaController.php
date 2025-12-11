<?php

namespace App\Http\Controllers\Client\KontrakKerja;

use App\Enums\Utils\PaginateSize;
use App\Http\Controllers\Controller;
use App\Models\KontrakKerja;
use App\Models\PengajuanKontrakKerja;
use Illuminate\Http\Request;

class PengajuanKontrakKerjaController extends Controller
{
    protected $relations = ['pendaftaran_pelatihan', 'gelombang_pelatihan'];
    public function index(Request $request, PengajuanKontrakKerja $pengajuan_kontrak_kerja_model)
    {
        $filters = $request->only('search', 'kategori_pelatihan');

        $query = $pengajuan_kontrak_kerja_model->with($this->relations)->where('users_id', auth()->user()->id);

        foreach ($filters as $key => $value) {
            match ($key) {
                'search' => $query->whereHas('gelombang_pelatihan', fn($q) => $q->search($value)),
                default => $query->whereHas('gelombang_pelatihan', fn($q) => $q->search_by_column($key, $value))
            };
        }

        $datas = $query->latest()->paginate(PaginateSize::SMALL->value)->withQueryString();

        $payload = compact('datas');
        return view('client.pelatihan.pelatihan-diikuti.index', $payload);
    }
    public function show(string $id, PengajuanKontrakKerja $pengajuan_kontrak_kerja_model)
    {
        $datas = $pengajuan_kontrak_kerja_model->findOrFail($id);
        $payload = compact('datas');
        return view('client.kontrak-kerja.pengajuan-kontrak-kerja.show', $payload);
    }
    public function create(Request $request, KontrakKerja $kontrak_kerja_model)
    {
        $kontrak_kerja_id = $request->query('kontrak_kerja_id');
        $datas = $kontrak_kerja_model->findOrFail($kontrak_kerja_id);
        $payload = compact('datas');
        return view('client.kontrak-kerja.pengajuan-kontrak-kerja.create', $payload);
    }
}
