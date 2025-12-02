<?php

namespace App\Http\Controllers\Pengaturan;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PengaturanRequest;
use App\Models\User;
use App\Services\Utils\Toast;
use Illuminate\Support\Facades\Hash;

class PengaturanController extends Controller
{
    public function edit()
    {
        $user = auth()->user();
        $payload = compact('user');
        return view('admin.pengaturan.edit', $payload);
    }
    public function update_pengguna(PengaturanRequest $request, User $user_model)
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
}
