<?php

use App\Http\Controllers\DashboardControlller;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\LoginController;
use App\Http\Middleware\AutoLogout;
use Illuminate\Support\Facades\Route;

Route::get('/',[LandingController::class,'index'])->name('landing-page');

Route::get('/admin/login', [LoginController::class, 'index'])->name('login');
Route::post('/admin/login', [LoginController::class, 'proses'])->name('login-proses');
Route::get('/admin/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware([AutoLogout::class])->group(function () {

    Route::group(['prefix' => 'admin', 'middleware' => ['admin'], 'as' => 'admin.'], function () {
        Route::get('/',[DashboardControlller::class, 'index'])->name('dashboard');
    });


});