<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\DashboardController;

Route::get('/auth/google', [SocialiteController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [SocialiteController::class, 'handleGoogleCallback']);

Route::get('/', function () {
    return view('index');
});

<<<<<<< HEAD
Route::prefix('dashboard')->middleware(['auth'])->group(function () {
=======
Route::prefix('dashboard')->middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('dashboard.index');
    });
>>>>>>> refs/remotes/origin/main
    Route::get('/', [DashboardController::class, 'index']);
});