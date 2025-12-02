<?php

namespace App\Http\Controllers\Sertifikasi;

use App\Http\Controllers\Controller;
use App\Models\Sertifikasi;
use Barryvdh\DomPDF\PDF;

class SertifikasiController extends Controller
{
    public function download(string $id, PDF $pdf)
    {
        $sertifikasi = Sertifikasi::findOrFail($id);

        $data = [
            'nama_lengkap' => $sertifikasi->pelatihan_peserta->pendaftaran_pelatihan->users->profil_user->nama_lengkap,
            'nama_pelatihan' => $sertifikasi->pelatihan_peserta->gelombang_pelatihan->pelatihan->nama_pelatihan,
        ];

        $pdf = $pdf->loadView('admin.sertifikasi.view-sertifikasi', compact('data'));

        return $pdf->download();
    }
}
