<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PelatihanPeserta;
use App\Models\ProfilUser;
use Illuminate\Http\Request;

class PelatihanPesertaDiikutiController extends Controller
{
    public function show(string $id_profil_user, string $id_pelatihan_diikuti, ProfilUser $profil_user_model, PelatihanPeserta $pelatihan_peserta_model)
    {
        $profil_user = $profil_user_model->findOrFail($id_profil_user);
        $pelatihan_diikuti = $pelatihan_peserta_model->findOrFail($id_pelatihan_diikuti);
        $payload = compact('profil_user', 'pelatihan_diikuti');
        return view('admin.pelatihan-peserta.pelatihan-diikuti.show', $payload);
    }
}
