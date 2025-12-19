<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DetailKontrakKerjaPeserta;
use App\Http\Controllers\Admin\DetailPelatihanPesertaController;
use App\Http\Controllers\Admin\GelombangPelatihanController;
use App\Http\Controllers\Admin\HasilUjianPelatihanController;
use App\Http\Controllers\Admin\JadwalUjianPelatihanController;
use App\Http\Controllers\Admin\KontrakKerjaController;
use App\Http\Controllers\Admin\KontrakkerjaPesertaController;
use App\Http\Controllers\Admin\PelatihanController;
use App\Http\Controllers\Admin\PelatihanPesertaController;
use App\Http\Controllers\Admin\PembayaranDanaTalangController;
use App\Http\Controllers\Admin\PembayaranPelatihanController;
use App\Http\Controllers\Admin\PendaftaranPelatihanController;
use App\Http\Controllers\Admin\PengajuanKontrakKerjaController;
use App\Http\Controllers\Admin\RekeningController;
use App\Http\Controllers\Admin\SertifikasiPelatihanController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Pengaturan\PengaturanController;
use App\Http\Controllers\Sertifikasi\SertifikasiController;
use App\Http\Middleware\Auth\AdminMiddleware;
use App\Models\Sertifikasi;

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
            // Gelombang pelatihan
            'gelombang-pelatihan' => GelombangPelatihanController::class,
            'gelombang-pelatihan.jadwal-ujian-pelatihan' => JadwalUjianPelatihanController::class,
            // Pelatihan peserta
            'pelatihan-peserta' => PelatihanPesertaController::class,
            'pelatihan-peserta.detail' => DetailPelatihanPesertaController::class,
            'pelatihan-peserta.detail.sertifikasi' => SertifikasiPelatihanController::class,
            'pelatihan-peserta.detail.jadwal-ujian.hasil-ujian' => HasilUjianPelatihanController::class,
            // Pembayaran pelatihan
            'pembayaran-pelatihan' => PembayaranPelatihanController::class,

            // Kontrak kerja
            'kontrak-kerja' => KontrakKerjaController::class,
            'pengajuan-kontrak-kerja' => PengajuanKontrakKerjaController::class,
            // Kontrak kerja peserta
            'kontrak-kerja-peserta' => KontrakkerjaPesertaController::class,
            'kontrak-kerja-peserta.detail' => DetailKontrakKerjaPeserta::class,
            // Pembayaran pelatihan
            'pembayaran-dana-talang' => PembayaranDanaTalangController::class,
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

        // Sertifikasi
        Route::prefix("/sertifikasi")->name('sertifikasi.')->group(function () {
            Route::get("/download/{id}", [SertifikasiController::class, 'download'])->name('download');
            Route::get("/view/{id}", [SertifikasiController::class, 'view'])->name('show');
        });

        // Pengaturan
        Route::prefix('/pengaturan')->name('pengaturan.')->group(function () {
            Route::get('/', [PengaturanController::class, 'admin_edit'])->name('edit');
            Route::put('/update-pengguna', [PengaturanController::class, 'admin_update_pengguna'])->name('update-pengguna');
        });

        // Exports data
        Route::prefix('/export')->name('export.')->group(function () {
            // Transaksi rekening
            Route::get('/transaksi-rekening', [RekeningController::class, 'export'])->name('transaksi-rekening');
            // Pembayaran pelatihan
            Route::get('/pembayaran-pelatihan', [PembayaranPelatihanController::class, 'export'])->name('pembayaran_pelatihan');
            // Pembayaran kontrak kerja
            Route::get('/pembayaran-dana-talang', [PembayaranDanaTalangController::class, 'export'])->name('pembayaran_dana_talang');
        });

    });
});