<?php

namespace App\Http\Controllers\Client\Pelatihan;

use App\Enums\Utils\PaginateSize;
use App\Http\Controllers\Controller;
use App\Models\PelatihanPeserta;
use App\Models\PendaftaranPelatihan;
use Illuminate\Http\Request;

class PelatihanDiikutiController extends Controller
{
    protected $relations = ['pendaftaran_pelatihan', 'gelombang_pelatihan'];
    public function index(Request $request, PelatihanPeserta $pelatihan_peserta_model)
    {
        $filters = $request->only('search', 'kategori_pelatihan');

        $query = $pelatihan_peserta_model->with($this->relations)->whereHas('pendaftaran_pelatihan', fn($q) => $q->where('users_id', auth()->user()->id));

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
    public function show(string $id, PelatihanPeserta $pelatihan_peserta_model)
    {
        $pelatihan_diikuti = $pelatihan_peserta_model->findOrFail($id);
        $payload = compact('pelatihan_diikuti');
        return view('client.pelatihan.pelatihan-diikuti.show', $payload);
    }
}
