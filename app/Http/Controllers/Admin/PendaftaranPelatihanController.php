<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Utils\PaginateSize;
use App\Http\Controllers\Controller;
use App\Models\PendaftaranPelatihan;
use Illuminate\Http\Request;

class PendaftaranPelatihanController extends Controller
{

    public function index(Request $request, PendaftaranPelatihan $pendaftaran_pelatihan_model)
    {
        $filters = $request->only('search', 'status', 'metode_pembayaran');

        $query = $pendaftaran_pelatihan_model->query();

        foreach ($filters as $key => $value) {
            match ($key) {
                'search' => $query->search($value),
                default => $query->search_by_column($key, $value),
            };
        }

        $datas = $query->latest()->paginate(PaginateSize::SMALL->value)->withQueryString();

        $payload = compact('datas');
        return view('admin.pendaftaran-pelatihan.index', $payload);
    }

    public function edit(string $id, PendaftaranPelatihan $pendaftaran_pelatihan_model)
    {
        $pendaftaran_pelatihan = $pendaftaran_pelatihan_model->findOrFail($id);
        $payload = compact('pendaftaran_pelatihan');
        return view('admin.pendaftaran-pelatihan.edit', $payload);
    }

    public function update(Request $request, string $id)
    {
        //
    }
}
