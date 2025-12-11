<?php

namespace App\Http\Controllers\Client;

use App\Enums\Pelatihan\StatusPelatihanPesertaEnum;
use App\Http\Controllers\Controller;
use App\Models\KontrakKerja;
use App\Models\PelatihanPeserta;
use App\Models\PendaftaranPelatihan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(PendaftaranPelatihan $pendaftaran_pelatihan_model, KontrakKerja $kontrak_kerja_model)
    {
        $jumlah_pelatihan_lulus = $pendaftaran_pelatihan_model
            ->whereHas('users', fn($q) => $q->where('id', auth()->user()->id))
            ->whereHas('pelatihan_peserta', fn($q) => $q->where('status', StatusPelatihanPesertaEnum::LULUS))->count();
        $jumlah_kontrak_kerja_saat_ini = $kontrak_kerja_model->get()->count();
        $kelengkapan_profil = auth()->user()->formatted_kelengkapan_profil_user;
        $payload = compact('jumlah_pelatihan_lulus', 'jumlah_kontrak_kerja_saat_ini', 'kelengkapan_profil');
        return view('client.dashboard.index', $payload);
    }
}
