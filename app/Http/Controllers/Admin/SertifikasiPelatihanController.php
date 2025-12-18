<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SertifikatRequest;
use App\Models\PelatihanPeserta;
use App\Models\ProfilUser;
use App\Models\Sertifikasi;
use App\Services\Utils\Toast;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SertifikasiPelatihanController extends Controller
{
    public function create(
        string $id_profil,
        string $id_pelatihan_peserta,
        ProfilUser $profil_user_model,
        PelatihanPeserta $pelatihan_peserta_model
    ) {
        $pelatihan_peserta = $pelatihan_peserta_model->findOrFail($id_pelatihan_peserta);
        $profil_user = $profil_user_model->findOrFail($id_profil);
        $payload = compact('profil_user', 'pelatihan_peserta');
        return view('admin.pelatihan-peserta.detail.sertifikasi.create', $payload);
    }
    public function store(
        SertifikatRequest $request,
        string $id_profil,
        string $id_pelatihan_peserta,
        ProfilUser $profil_user_model,
        PelatihanPeserta $pelatihan_peserta_model,
    ) {

        $data_sertifikat = $request->validated();
        $profil_user = $profil_user_model->findOrFail($id_profil);
        $pelatihan_peserta = $pelatihan_peserta_model->findOrFail($id_pelatihan_peserta);

        $nama_pelatihan = $pelatihan_peserta->gelombang_pelatihan->pelatihan->nama_pelatihan;

        // Upload files
        $uploadedFiles = [
            'sertifikat' => $request->file('sertifikat'),
        ];

        $private_storage = Storage::disk('local');

        $path_uploaded_file = [];

        foreach ($uploadedFiles as $key => $file) {
            if ($file) {
                $ext = $file->getClientOriginalExtension();
                $safeName = Str::slug($profil_user->users->name);
                $fileName = "{$profil_user->users->id}_{$safeName}_{$key}_{$nama_pelatihan}_{$data_sertifikat['jenis_sertifikat']}." . $ext;

                $path_uploaded_file[$key] = $private_storage->putFileAs("users/{$key}", $file, $fileName);
            }
        }

        // set path
        foreach ($path_uploaded_file as $key => $value) {
            $data_sertifikat[$key] = $value;
        }

        // upload sertifikat
        $store_sertifikat = $pelatihan_peserta->sertifikasi()->create($data_sertifikat);

        if ($store_sertifikat->wasRecentlyCreated) {
            Toast::success('Sertifikat berhasil diupload.');
        } else {
            Toast::error('Terjadi kesalahan.');
        }

        return redirect()->route('admin.pelatihan-peserta.detail.show', [$profil_user->id, $pelatihan_peserta->id]);

    }
    public function edit(
        string $id_profil,
        string $id_pelatihan_peserta,
        string $id_sertifikat,
        ProfilUser $profil_user_model,
        PelatihanPeserta $pelatihan_peserta_model,
        Sertifikasi $sertifikasi_model
    ) {
        $pelatihan_peserta = $pelatihan_peserta_model->findOrFail($id_pelatihan_peserta);
        $profil_user = $profil_user_model->findOrFail($id_profil);
        $sertifikat = $sertifikasi_model->findOrFail($id_sertifikat);
        $payload = compact('profil_user', 'sertifikat', 'pelatihan_peserta');
        return view('admin.pelatihan-peserta.detail.sertifikasi.edit', $payload);
    }
    public function update(
        SertifikatRequest $request,
        string $id_profil,
        string $id_pelatihan_peserta,
        string $id_sertifikat,
        ProfilUser $profil_user_model,
        PelatihanPeserta $pelatihan_peserta_model,
        Sertifikasi $sertifikasi_model
    ) {

        $data_sertifikat = $request->validated();
        $sertifikat = $sertifikasi_model->findOrFail($id_sertifikat);
        $profil_user = $profil_user_model->findOrFail($id_profil);
        $pelatihan_peserta = $pelatihan_peserta_model->findOrFail($id_pelatihan_peserta);

        $nama_pelatihan = $pelatihan_peserta->gelombang_pelatihan->pelatihan->nama_pelatihan;

        // Upload files
        $uploadedFiles = [
            'sertifikat' => $request->file('sertifikat'),
        ];

        $private_storage = Storage::disk('local');

        $path_uploaded_file = [];

        foreach ($uploadedFiles as $key => $file) {
            if ($file) {
                if ($private_storage->exists($sertifikat->sertifikat)) {
                    $private_storage->delete($sertifikat->sertifikat);
                }
                $ext = $file->getClientOriginalExtension();
                $safeName = Str::slug($profil_user->users->name);
                $fileName = "{$profil_user->users->id}_{$safeName}_{$key}_{$nama_pelatihan}_{$data_sertifikat['jenis_sertifikat']}." . $ext;

                $path_uploaded_file[$key] = $private_storage->putFileAs("users/{$key}", $file, $fileName);
            }
        }

        // set path
        foreach ($path_uploaded_file as $key => $value) {
            $data_sertifikat[$key] = $value;
        }

        // upload sertifikat
        $update_sertifikat = $sertifikat->update($data_sertifikat);

        if ($update_sertifikat) {
            Toast::success('Sertifikat berhasil diperbarui.');
        } else {
            Toast::error('Terjadi kesalahan.');
        }

        return redirect()->route('admin.pelatihan-peserta.detail.show', [$profil_user->id, $pelatihan_peserta->id]);

    }
    public function destroy(string $id_profil, string $id_pelatihan_peserta, string $id_sertifikat, Sertifikasi $sertifikasi_model)
    {
        $sertifikat = $sertifikasi_model->findOrFail($id_sertifikat);

        $private_storage = Storage::disk('local');
        $files = $sertifikat->sertifikat;
        if ($private_storage->exists($files)) {
            $private_storage->delete($files);
        }

        if ($sertifikat->delete()) {
            Toast::success('Sertifikat berhasil dihapus.');
        } else {
            Toast::error('Terjadi kesalahan.');
        }
        return redirect()->back();
    }
}
