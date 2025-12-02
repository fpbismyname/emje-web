<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PelatihanPeserta;
use App\Models\ProfilUser;

class DetailPelatihanPesertaController extends Controller
{
    public function show(string $id_profil_user, string $id_pelatihan_peserta, PelatihanPeserta $pelatihan_peserta_model, ProfilUser $profil_user_model)
    {
        $pelatihan_peserta = $pelatihan_peserta_model->findOrFail($id_pelatihan_peserta);
        $profil_user = $profil_user_model->findOrFail($id_profil_user);
        $payload = compact('pelatihan_peserta', 'profil_user');
        return view('admin.pelatihan-peserta.detail.show', $payload);
    }
}
