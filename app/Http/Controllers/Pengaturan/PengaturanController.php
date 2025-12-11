<?php

namespace App\Http\Controllers\Pengaturan;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PengaturanRequest;
use App\Http\Requests\Admin\UserRequest;
use App\Models\ProfilUser;
use App\Models\User;
use App\Services\Utils\Toast;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PengaturanController extends Controller
{
    public function admin_edit()
    {
        $user = auth()->user();
        $payload = compact('user');
        return view('admin.pengaturan.edit', $payload);
    }
    public function admin_update_pengguna(PengaturanRequest $request, User $user_model)
    {
        $update_entries = $request->validated();

        $is_reset_password = isset($update_entries['reset_password']) ? $update_entries['reset_password'] == 'on' : false;

        $user = $user_model->findOrFail(auth()->user()->id);

        if ($is_reset_password) {
            $user->password = Hash::make($update_entries['new_password']);
            $user->save();
            if (auth()->user()->name === $update_entries['name']) {
                $request->session()->invalidate();
            }
        }

        // Setup datafor update
        $data_user = $request->only($user_model->getFillable());

        $user->update($data_user);

        if ($user->wasChanged() || $user->profil_user->wasChanged()) {
            Toast::success("Data akun pengguna {$user->name} berhasil diperbarui.");
        } else {
            Toast::error('Terjadi kesalahan.');
        }

        return redirect()->back();
    }

    public function client_edit()
    {
        $user = auth()->user();
        $payload = compact('user');
        return view('client.pengaturan.edit', $payload);
    }
    public function client_update_pengguna(\App\Http\Requests\Client\PengaturanRequest $request, User $user_model, ProfilUser $profil_user_model)
    {
        $update_entries = $request->validated();

        $is_reset_password = isset($update_entries['reset_password']) ? $update_entries['reset_password'] == 'on' : false;

        $user = $user_model->findOrFail(auth()->user()->id);

        if ($is_reset_password) {
            $user->password = Hash::make($update_entries['new_password']);
            $user->save();
            Toast::success('Password berhasil direset. Silahkan login kembali.');
            $request->session()->invalidate();
        }

        // Setup datafor update
        $data_user = $request->only($user_model->getFillable());
        $data_profil_user = $request->only($profil_user_model->getFillable());

        // Upload files
        $uploadedFiles = [
            'ktp' => $request->file('ktp'),
            'foto_profil' => $request->file('foto_profil'),
            'ijazah' => $request->file('ijazah'),
        ];

        $private_storage = Storage::disk('local');

        $path_uploaded_file = [];

        foreach ($uploadedFiles as $key => $file) {
            if ($file) {
                if ($user->profil_user()->exists()) {
                    $current_file_path = $user->profil_user->{$key};
                    if ($current_file_path && $private_storage->exists($user->profil_user->{$key})) {
                        $private_storage->delete($user->profil_user->{$key});
                    }
                }
                $ext = $file->getClientOriginalExtension();
                $safeName = Str::slug($user->name);

                $fileName = "{$user->id}_{$safeName}_{$key}." . $ext;

                $path_uploaded_file[$key] = $private_storage->putFileAs("users/{$key}", $file, $fileName);
            }
        }

        // set path
        foreach ($path_uploaded_file as $key => $value) {
            $data_profil_user[$key] = $value;
        }


        $update_user = $user->update($data_user);

        if (!$user->profil_user()->exists()) {
            $user->profil_user()->create($data_profil_user);
        } else {
            $user->profil_user->update($data_profil_user);
        }


        if ($update_user) {
            Toast::success("Data akun pengguna {$user->name} berhasil diperbarui.");
        } else {
            Toast::error('Terjadi kesalahan.');
        }

        return redirect()->back();
    }
}
