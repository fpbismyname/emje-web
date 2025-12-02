<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Utils\PaginateSize;
use App\Http\Controllers\Controller;
use App\Models\ProfilUser;
use Illuminate\Http\Request;

class KontrakkerjaPesertaController extends Controller
{
    protected $relations = ['users'];
    public function index(Request $request, ProfilUser $profil_user_model)
    {
        $filters = $request->only('jenis_kelamin', 'pendidikan_terakhir');

        $query = $profil_user_model->with($this->relations);

        foreach ($filters as $key => $value) {
            match ($key) {
                'search' => $query->search($value),
                default => $query->search_by_column($key, $value),
            };
        }

        $datas = $query->latest()->paginate(PaginateSize::SMALL->value)->withQueryString();

        $payload = compact('datas');
        return view('admin.kontrak-kerja-peserta.index', $payload);
    }
    public function show(string $id, ProfilUser $profil_user_model)
    {
        $profil_user = $profil_user_model->findOrFail($id);
        $pengajuan_kontrak_kerja = $profil_user->users->pengajuan_kontrak_kerja()->paginate(PaginateSize::SMALL->value);
        $payload = compact('profil_user', 'pengajuan_kontrak_kerja');
        return view('admin.kontrak-kerja-peserta.show', $payload);
    }
}
