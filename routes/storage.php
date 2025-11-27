<?php

use App\Http\Controllers\Storage\StorageController;
use App\Http\Middleware\Storage\StorageMiddleware;


Route::prefix('/storage')->name('storage.')->group(function () {
    // Get public files
    Route::prefix('/public')->name('public.')->group(function () {
        Route::get('/show', [StorageController::class, 'public_show'])->name('show');
        Route::get('/download', [StorageController::class, 'public_download'])->name('download');
    });

    // Get private files
    Route::middleware([StorageMiddleware::class])
        ->prefix('/private')->name('private.')->group(function () {
            Route::get('/show', [StorageController::class, 'private_show'])->name('show');
            Route::get('/download', [StorageController::class, 'private_download'])->name('download');
        });
});