<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KontrakKerjaPeserta;
use App\Models\ProfilUser;
use Illuminate\Http\Request;

class DetailKontrakKerjaPeserta extends Controller
{
    public function show(string $id_profil_user, string $id_kontrak_kerja_peserta, KontrakKerjaPeserta $kontrak_kerja_peserta_model, ProfilUser $profil_user_model)
    {
        $kontrak_kerja_peserta = $kontrak_kerja_peserta_model->findOrFail($id_kontrak_kerja_peserta);
        $profil_user = $profil_user_model->findOrFail($id_profil_user);
        $payload = compact('kontrak_kerja_peserta', 'profil_user');
        return view('admin.kontrak-kerja-peserta.detail.show', $payload);
    }
}
