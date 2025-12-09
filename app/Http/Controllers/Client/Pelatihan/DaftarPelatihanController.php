<?php

namespace App\Http\Controllers\Client\Pelatihan;

use App\Enums\Pelatihan\SesiGelombangPelatihanEnum;
use App\Enums\Utils\PaginateSize;
use App\Http\Controllers\Controller;
use App\Models\GelombangPelatihan;
use App\Models\Pelatihan;
use Illuminate\Http\Request;

class DaftarPelatihanController extends Controller
{
    protected $relations = ['pelatihan'];
    public function index(Request $request, GelombangPelatihan $gelombang_pelatihan_model)
    {
        $filters = $request->only('search', 'kategori_pelatihan');

        $query = $gelombang_pelatihan_model->query()->tersedia_untuk_registrasi();

        foreach ($filters as $key => $value) {
            match ($key) {
                'search' => $query->whereHas('pelatihan', fn($q) => $q->search($value)),
                default => $query->whereHas('pelatihan', fn($q) => $q->search_by_column($key, $value))
            };
        }

        $datas = $query->latest()->paginate(PaginateSize::SMALL->value)->withQueryString();

        $payload = compact('datas');
        return view('client.pelatihan.daftar-pelatihan.index', $payload);
    }

    public function show(string $id, GelombangPelatihan $gelombang_pelatihan_model)
    {
        $gelombang_pelatihan = $gelombang_pelatihan_model->with($this->relations)->findOrFail($id);

        $payload = compact('gelombang_pelatihan');
        return view('client.pelatihan.daftar-pelatihan.show', $payload);

    }
}
