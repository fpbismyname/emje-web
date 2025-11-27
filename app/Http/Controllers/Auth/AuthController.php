<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use App\Services\Utils\Toast;
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
        return view('admin.auth.login');
    }
}
