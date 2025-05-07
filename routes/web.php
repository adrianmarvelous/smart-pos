<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SocialiteController;

Route::get('/auth/google', [SocialiteController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [SocialiteController::class, 'handleGoogleCallback']);

Route::get('/', function () {
    return view('index');
});

Route::prefix('dashboard')->group(function () {
    Route::get('/', function () {
        return view('dashboard.index');
    });

});