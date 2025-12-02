<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\HasilUjianPelatihanRequest;
use App\Models\HasilUjianPelatihan;
use App\Models\JadwalUjianPelatihan;
use App\Models\PelatihanPeserta;
use App\Services\Utils\Toast;

class HasilUjianPelatihanController extends Controller
{
    public function create(
        string $id_profil_user,
        string $id_pelatihan_peserta,
        string $id_jadwal_ujian,
        JadwalUjianPelatihan $jadwal_ujian_pelatihan_model
    ) {
        $jadwal_ujian_pelatihan = $jadwal_ujian_pelatihan_model->findOrFail($id_jadwal_ujian);
        $payload = compact('id_profil_user', 'id_pelatihan_peserta', 'id_jadwal_ujian', 'jadwal_ujian_pelatihan');
        return view('admin.pelatihan-peserta.detail.hasil-ujian.create', $payload);
    }
    public function store(
        HasilUjianPelatihanRequest $request,
        string $id_profil_user,
        string $id_pelatihan_peserta,
        string $id_jadwal_ujian,
        JadwalUjianPelatihan $jadwal_ujian_pelatihan_model
    ) {
        $store_entries = $request->validated();
        $jadwal_ujian = $jadwal_ujian_pelatihan_model->findOrFail($id_jadwal_ujian);
        $create_hasil_ujian = $jadwal_ujian->hasil_ujian_pelatihan()->create($store_entries);

        if ($create_hasil_ujian->wasRecentlyCreated) {
            Toast::success("Hasil ujian {$jadwal_ujian->nama_ujian} berhasil ditambahkan.");
        } else {
            Toast::error("Terjadi kesalahan.");
        }

        return redirect()->route('admin.pelatihan-peserta.detail.show', [$id_profil_user, $id_pelatihan_peserta]);
    }
    public function edit(
        string $id_profil_user,
        string $id_pelatihan_peserta,
        string $id_jadwal_ujian,
        string $id_hasil_ujian,
        JadwalUjianPelatihan $jadwal_ujian_pelatihan_model,
        HasilUjianPelatihan $hasil_ujian_pelatihan_model
    ) {
        $jadwal_ujian_pelatihan = $jadwal_ujian_pelatihan_model->findOrFail($id_jadwal_ujian);
        $hasil_ujian_pelatihan = $hasil_ujian_pelatihan_model->findOrFail($id_hasil_ujian);
        $payload = compact('id_profil_user', 'id_pelatihan_peserta', 'id_jadwal_ujian', 'id_hasil_ujian', 'jadwal_ujian_pelatihan', 'hasil_ujian_pelatihan');
        return view('admin.pelatihan-peserta.detail.hasil-ujian.edit', $payload);
    }
    public function update(
        HasilUjianPelatihanRequest $request,
        string $id_profil_user,
        string $id_pelatihan_peserta,
        string $id_jadwal_ujian,
        string $id_hasil_ujian,
        JadwalUjianPelatihan $jadwal_ujian_pelatihan_model
    ) {
        $update_entries = $request->validated();
        $jadwal_ujian = $jadwal_ujian_pelatihan_model->findOrFail($id_jadwal_ujian);
        $hasil_ujian = $jadwal_ujian->hasil_ujian_pelatihan()->findOrFail($id_hasil_ujian);

        $hasil_ujian->update($update_entries);

        if ($hasil_ujian->wasChanged()) {
            Toast::success("Hasil ujian {$jadwal_ujian->nama_ujian} berhasil diperbarui.");
        } elseif (!$hasil_ujian->getChanges()) {
            Toast::info("Tidak ada perubahan yang dilakukan.");
        } else {
            Toast::error("Terjadi kesalahan.");
        }

        return redirect()->back();
    }
    public function destroy(string $id_profil_user, string $id_pelatihan_peserta, string $id_jadwal_ujian, string $id_hasil_ujian, JadwalUjianPelatihan $jadwal_ujian_pelatihan_model)
    {
        $jadwal_ujian = $jadwal_ujian_pelatihan_model->findOrFail($id_jadwal_ujian);
        $hasil_ujian = $jadwal_ujian->hasil_ujian_pelatihan()->findOrFail($id_hasil_ujian);
        $delete_hasil_ujian = $hasil_ujian->delete();

        if ($delete_hasil_ujian) {
            Toast::success("Hasil ujian {$hasil_ujian->nama_materi} berhasil dihapus.");
        } else {
            Toast::error("Terjadi kesalahan.");
        }
        return redirect()->back();
    }
}
