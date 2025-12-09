<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Client\DashboardController;
use App\Http\Controllers\Client\HomepageController;
use App\Http\Controllers\Client\KontrakKerja\DaftarKontrakKerjaController;
use App\Http\Controllers\Client\KontrakKerja\KontrakKerjaDiikuti;
use App\Http\Controllers\Client\KontrakKerja\PengajuanKontrakKerjaController;
use App\Http\Controllers\Client\Pelatihan\DaftarPelatihanController;
use App\Http\Controllers\Client\Pelatihan\PelatihanDiikutiController;
use App\Http\Controllers\Client\Pelatihan\PendaftaranPelatihanController;
use App\Http\Middleware\Auth\ClientMiddleware;
use Illuminate\Support\Facades\Route;


Route::prefix('/')->name('client.')->group(function () {
    // Homepage
    Route::get('/', [HomepageController::class, 'index'])->name('homepage.index');

    // Auth Dashboard
    Route::get('/login', [AuthController::class, 'client_login'])->name('login');
    Route::post('/login/submit', [AuthController::class, 'client_submit_login'])->name('login.submit');
    Route::get('/register', [AuthController::class, 'client_register'])->name('register');
    Route::post('/register/submit', [AuthController::class, 'client_submit_register'])->name('register.submit');
    Route::post('/logout', [AuthController::class, 'client_submit_logout'])->name('logout');

    // Resources 
    Route::middleware([ClientMiddleware::class])->group(function () {
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
        // Pelatihan
        Route::prefix('/pelatihan')->name('pelatihan.')->group(function () {
            Route::resources([
                'daftar-pelatihan' => DaftarPelatihanController::class,
                'pendaftaran-pelatihan' => PendaftaranPelatihanController::class,
                'pelatihan-diikuti' => PelatihanDiikutiController::class,
            ]);
        });
        // Kontrak kerja
        Route::prefix('/kontrak-kerja')->name('kontrak-kerja.')->group(function () {
            Route::resources([
                'daftar-kontrak-kerja' => DaftarKontrakKerjaController::class,
                'pengajuan-kontrak-kerja' => PengajuanKontrakKerjaController::class,
                'kontrak-kerja-diikuti' => KontrakKerjaDiikuti::class
            ]);
        });
    });
});