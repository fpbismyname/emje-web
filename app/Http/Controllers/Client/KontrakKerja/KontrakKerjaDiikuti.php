<?php

namespace App\Http\Controllers\Client\KontrakKerja;

use App\Enums\Utils\PaginateSize;
use App\Http\Controllers\Controller;
use App\Models\KontrakKerjaPeserta;
use Illuminate\Http\Request;

class KontrakKerjaDiikuti extends Controller
{
    protected $relations = ['pengajuan_kontrak_kerja'];
    public function index(Request $request, KontrakKerjaPeserta $kontrak_kerja_peserta_model)
    {
        $filters = $request->only('search', 'kategori_kontrak_kerja');

        $query = $kontrak_kerja_peserta_model->with($this->relations)->whereHas('pengajuan_kontrak_kerja', fn($q) => $q->where('users_id', auth()->user()->id));

        foreach ($filters as $key => $value) {
            match ($key) {
                'search' => $query->whereHas('pengajuan_kontrak_kerja.kontrak_kerja', fn($q) => $q->search($value)),
                default => $query->whereHas('pengajuan_kontrak_kerja.kontrak_kerja', fn($q) => $q->search_by_column($key, $value))
            };
        }

        $datas = $query->latest()->paginate(PaginateSize::SMALL->value)->withQueryString();

        $payload = compact('datas');
        return view('client.kontrak-kerja.kontrak-kerja-diikuti.index', $payload);
    }
    public function show(string $id, KontrakKerjaPeserta $kontrak_kerja_peserta_model)
    {
        $kontrak_kerja_diikuti = $kontrak_kerja_peserta_model->findOrFail($id);
        $payload = compact('kontrak_kerja_diikuti');
        return view('client.kontrak-kerja.kontrak-kerja-diikuti.show', $payload);
    }
}
