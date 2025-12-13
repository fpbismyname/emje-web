<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use App\Http\Requests\Client\RegisterRequest;
use App\Models\User;
use App\Services\Utils\Toast;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Admin auth
     */
    public function admin_login()
    {
        return view('admin.auth.login');
    }
    public function admin_submit_login(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (Auth::attempt($credentials)) {
            Toast::success('Login berhasil.');
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard.index');
        }
        Toast::success('Kombinasi email atau password tidak cocok.');

        return redirect()->back()->withInput();
    }
    public function admin_submit_logout(Request $request)
    {
        $request->session()->invalidate();
        return redirect()->route('admin.login');
    }

    /**
     * Client auth
     */
    public function client_login(
    ) {
        return view('client.auth.login');
    }
    public function client_register(
    ) {
        return view('client.auth.register');
    }
    public function client_submit_login(\App\Http\Requests\Client\LoginRequest $request)
    {
        $credentials = $request->validated();

        if (Auth::attempt($credentials)) {
            Toast::success('Login berhasil.');
            $request->session()->regenerate();
            return redirect()->route('client.dashboard.index');
        }
        Toast::success('Kombinasi email atau password tidak cocok.');

        return redirect()->back()->withInput();
    }
    public function client_submit_register(RegisterRequest $request, User $user_model)
    {
        // $users = $request->validated();
        // $users['password'] = Hash::make($users['password']);
        // $create_user = $user_model->create($users);
        // if ($create_user->wasRecentlyCreated) {
        //     Toast::success('Pendaftaran berhasil. Silahkan login untuk melanjutkan.');
        //     return redirect()->route('client.login');
        // }
        // Toast::error('Terjadi kesalahan.');
        // return redirect()->back()->withInput();
        $user = $request->validated();

        $redirect_route = config('site.contact.whatsapp');

        $message = urlencode(
            "Halo admin,\n"
            . "Saya ingin mengajukan pendaftaran untuk mengikuti pelatihan dan kontrak kerja.\n"
            . "Nama: {$user['name']}\n"
            . "Email: {$user['email']}"
        );
        return redirect("{$redirect_route}?text={$message}");
    }
    public function client_submit_logout(Request $request)
    {
        $request->session()->invalidate();
        Toast::success('Logout berhasil.');
        return redirect()->route('client.login');
    }
}
