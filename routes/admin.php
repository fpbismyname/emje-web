<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GelombangPelatihanController;
use App\Http\Controllers\Admin\JadwalUjianPelatihanController;
use App\Http\Controllers\Admin\KontrakKerjaController;
use App\Http\Controllers\Admin\PelatihanController;
use App\Http\Controllers\Admin\PelatihanPesertaController;
use App\Http\Controllers\Admin\PelatihanPesertaDiikutiController;
use App\Http\Controllers\Admin\PendaftaranPelatihanController;
use App\Http\Controllers\Admin\RekeningController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Middleware\Auth\AdminMiddleware;

Route::prefix('/admin')->name('admin.')->group(function () {
    // Auth
    Route::get('/login', [AuthController::class, 'admin_login'])->name('login');
    Route::post('/login', [AuthController::class, 'admin_submit_login'])->name('login.submit');
    Route::post('/logout', [AuthController::class, 'admin_submit_logout'])->name('logout.submit');

    // Internal page
    Route::middleware([AdminMiddleware::class])->group(function () {
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

        // Resource
        Route::resources([
            'users' => UserController::class,
            // Pelatihan
            'pelatihan' => PelatihanController::class,
            'pendaftaran-pelatihan' => PendaftaranPelatihanController::class,
            'gelombang-pelatihan' => GelombangPelatihanController::class,
            'pelatihan-peserta' => PelatihanPesertaController::class,
            'pelatihan-peserta.pelatihan-diikuti' => PelatihanPesertaDiikutiController::class,
            'jadwal-ujian-pelatihan' => JadwalUjianPelatihanController::class,
            // Kontrak kerja
            'kontrak-kerja' => KontrakKerjaController::class,
        ]);

        // Users
        Route::prefix('/users')->name('users.')->group(function () {
            Route::get('/create/admin-user', [UserController::class, 'admin_create'])->name('admin_create');
            Route::get('/create/client-user', [UserController::class, 'client_create'])->name('client_create');
        });

        // Rekening Controller
        Route::prefix('/rekening')->name('rekening.')->group(function () {
            Route::get("/", [RekeningController::class, "index"])->name('index');
        });

    });
});