<?php

use App\Http\Controllers\Client\HomepageController;
use Illuminate\Support\Facades\Route;


Route::prefix('/')->name('homepage.')->group(function () {
    // Homepage
    Route::get('/', [HomepageController::class, 'index'])->name('index');
});