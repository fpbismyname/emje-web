<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Utils\PaginateSize;
use App\Http\Controllers\Controller;
use App\Models\PelatihanPeserta;
use App\Models\ProfilUser;

class PelatihanPesertaDiikutiController extends Controller
{
    public function show(string $id_profil_user, string $id_pelatihan_diikuti, ProfilUser $profil_user_model, PelatihanPeserta $pelatihan_peserta_model)
    {
        $profil_user = $profil_user_model->findOrFail($id_profil_user);
        $pelatihan_diikuti = $pelatihan_peserta_model->findOrFail($id_pelatihan_diikuti);

        $jadwal_ujian = $pelatihan_diikuti->gelombang_pelatihan->jadwal_ujian_pelatihan()->paginate(PaginateSize::SMALL->value);

        $sertifikasi = $pelatihan_diikuti->sertifikasi;
        $payload = compact('profil_user', 'pelatihan_diikuti', 'jadwal_ujian', 'sertifikasi');
        return view('admin.pelatihan-peserta.pelatihan-diikuti.show', $payload);
    }
}
