<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\CabangOlahragaController;
// Removed: use App\Http\Controllers\Admin\AtletController;
// Removed: use App\Http\Controllers\Admin\PelatihController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Login
Route::get('login', [LoginController::class, 'show'])->middleware('guest')->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login-post');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

// Admin (auth protected)
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // Profile
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/{profile}', [ProfileController::class, 'profile'])->name('index');
        Route::put('/{profile}/update-profile', [ProfileController::class, 'updateProfile'])->name('profile-update');
    });

    // Hak Akses
    Route::prefix('hak-akses')->name('hak-akses.')->group(function () {
        Route::resource('permission', PermissionController::class)->except('show', 'create', 'edit');
        Route::resource('user', UserController::class)->except('show');
    });

    // Manajemen Pengguna
    Route::prefix('manajemen-pengguna')->name('manajemen-pengguna.')->group(function () {
        Route::resource('/user', UserController::class)->except('show');
        Route::resource('pengguna', UserController::class);
        Route::get('/pengguna/get-user', [UserController::class, 'getUsers'])->name('pengguna.getUsers');
        Route::post('/pengguna/image', [UserController::class, 'image'])->name('pengguna.image');

        Route::resource('role', RoleController::class)->except('create', 'edit');
        Route::post('/role/updatePermissions', [RoleController::class, 'updatePermissions'])->name('role.updatePermissions');
        Route::post('/role/deletePermissions', [RoleController::class, 'deletePermissions'])->name('role.deletePermissions');
        Route::post('/role/updateSinglePermissions', [RoleController::class, 'updateSinglePermissions'])->name('role.updateSinglePermissions');
    });

    // Konfigurasi
    Route::prefix('konfigurasi')->name('konfigurasi.')->group(function () {
        Route::resource('cabang-olahraga', CabangOlahragaController::class);
    });

    // Removed: Tambahan route show untuk atlet & pelatih (lihat profil)
    // Removed: Route::resource('atlet', AtletController::class)->only(['show']);
    // Removed: Route::resource('pelatih', PelatihController::class)->only(['show']);
});