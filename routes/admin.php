<?php

use App\Http\Controllers\Admin\DashboardController;

Route::prefix('/admin')->name('admin.')->group(function () {
    // Auth
    Route::get('/login');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // Resource
    Route::resources([

    ]);
});