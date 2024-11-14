<?php

use App\Http\Controllers\DashboardControlller;
use App\Http\Controllers\KadminController;
use App\Http\Controllers\KPembeliController;
use App\Http\Controllers\KProductController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RatingController;
use App\Http\Middleware\AutoLogout;
use Illuminate\Support\Facades\Route;

Route::get('/',[LandingController::class,'index'])->name('landing-page');

Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::get('/admin/login', [LoginController::class, 'index'])->name('admin.login');
Route::post('/login-proses', [LoginController::class, 'proses'])->name('login-proses');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/product', [LandingController::class, 'product'])->name('product');
Route::get('/customer', [LandingController::class, 'customer'])->name('customer');
Route::get('/testimoni', [LandingController::class, 'testimoni'])->name('testimoni');
Route::get('/kontak', [LandingController::class, 'kontak'])->name('kontak');
Route::get('/about', [LandingController::class, 'about'])->name('about');

Route::middleware([AutoLogout::class])->group(function () {

    Route::prefix('profile')->group(function () {
        Route::get('/profile',[ProfileController::class, 'index'])->name('profile');
        Route::post('/profile/update/{id}',[ProfileController::class, 'update'])->name('profile.update');
    });


    Route::group(['prefix' => 'admin', 'middleware' => ['admin'], 'as' => 'admin.'], function () {
        Route::get('/dash',[DashboardControlller::class, 'index'])->name('dashboard');
        Route::prefix('k-admin')->group(function () {
            Route::get('/',[KadminController::class, 'index'])->name('k-admin');
            Route::post('/store',[KadminController::class, 'store'])->name('k-admin.store');
            Route::put('/update/{id}',[KadminController::class, 'update'])->name('k-admin.update');
            Route::delete('/delete/{id}',[KadminController::class, 'delete'])->name('k-admin.delete');
        });
        Route::prefix('k-pembeli')->group(function () {
            Route::get('/',[KPembeliController::class, 'index'])->name('k-pembeli');
            Route::post('/store',[KPembeliController::class, 'store'])->name('k-pembeli.store');
            Route::put('/update/{id}',[KPembeliController::class, 'update'])->name('k-pembeli.update');
            Route::delete('/delete/{id}',[KPembeliController::class, 'delete'])->name('k-pembeli.delete');
        });
        Route::prefix('product')->group(function () {
            Route::get('/',[KProductController::class, 'index'])->name('product');
            Route::post('/store',[KProductController::class, 'store'])->name('product.store');
            Route::post('/kategori',[KProductController::class, 'kategori'])->name('product.kategori');
            Route::post('/jenis',[KProductController::class, 'jenis'])->name('product.jenis');
            Route::get('/edit/{id}',[KProductController::class, 'edit'])->name('product.edit');
            Route::put('/update/{id}',[KProductController::class, 'update'])->name('product.update');
            Route::delete('/delete/{id}',[KProductController::class, 'delete'])->name('product.delete');
        });
        Route::prefix('rekomendasi')->group(function () {
            Route::get('/',[KPembeliController::class, 'index'])->name('rekomendasi');

        });
        Route::prefix('pemesanan')->group(function () {
            Route::get('/',[KPembeliController::class, 'index'])->name('pemesanan');

        });
        Route::prefix('slider')->group(function () {
            Route::get('/',[KPembeliController::class, 'index'])->name('slider');

        });
        Route::prefix('customer')->group(function () {
            Route::get('/',[KPembeliController::class, 'index'])->name('customer');

        });
        Route::prefix('project')->group(function () {
            Route::get('/',[KPembeliController::class, 'index'])->name('project');

        });
        Route::prefix('testimoni')->group(function () {
            Route::get('/',[KPembeliController::class, 'index'])->name('testimoni');

        });
        Route::prefix('kontak')->group(function () {
            Route::get('/',[KPembeliController::class, 'index'])->name('kontak');

        });
        Route::prefix('rating')->group(function () {
            Route::get('/',[KPembeliController::class, 'index'])->name('rating');

        });
        Route::prefix('pesanan')->group(function () {
            Route::get('/',[KPembeliController::class, 'index'])->name('pesanan');

        });
        Route::prefix('about')->group(function () {
            Route::get('/',[KPembeliController::class, 'index'])->name('about');

        });

    });

    Route::group(['prefix' => 'pembeli', 'middleware' => ['pembeli'], 'as' => 'pembeli.'], function () {
        Route::prefix('rating')->group(function () {
            Route::get('/',[RatingController::class, 'index'])->name('rating');

        });
        Route::prefix('pesanan')->group(function () {
            Route::get('/',[PesananController::class, 'index'])->name('pesanan');

        });
    });

});