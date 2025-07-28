<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Store\StoreController;
use App\Http\Controllers\Store\ProductController;

Route::get('/auth/google', [SocialiteController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [SocialiteController::class, 'handleGoogleCallback']);
Route::get('/logout', [SocialiteController::class, 'logout'])->name('logout');


Route::get('/', function () {
    return view('index');
})->name('home');

Route::prefix('dashboard')->middleware('auth')->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/store/join', [StoreController::class, 'join'])->name('store.join');
    Route::post('/store/join/apply', [StoreController::class, 'apply'])->name('store.apply');
    Route::get('/store/change_store/{id}', [StoreController::class, 'change_store'])->name('store.change_store');

    Route::middleware(['auth', 'role:hhead_store'])->group(function () {
        Route::get('/store', [StoreController::class, 'index'])->name('store.index');
        Route::get('/store/list_crew', [StoreController::class, 'list_crew'])->name('store.list_crew');
        Route::get('/store/create', [StoreController::class, 'create'])->name('store.create');
        Route::get('/store/create_store', [StoreController::class, 'create_store'])->name('store.create_store');
        Route::post('/store/update', [StoreController::class, 'update'])->name('store.update');
        Route::post('/store/delete', [StoreController::class, 'delete'])->name('store.delete');
        Route::get('/store/update_unique_code/{id}', [StoreController::class, 'update_unique_code'])->name('store.update_unique_code');
        Route::post('/store/update_role', [StoreController::class, 'update_role'])->name('store.update_role');
    });

    
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::post('/product/store', [ProductController::class, 'store'])->name('product.store');
    Route::post('/product/delete', [ProductController::class, 'delete'])->name('product.delete');
    Route::get('/product/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
    Route::put('/product/update', [ProductController::class, 'update'])->name('product.update');
});