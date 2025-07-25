<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\PermissionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('login', [LoginController::class, 'show'])->middleware('guest')->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login-post');


Route::group(['middleware' => ['auth'], 'as' => 'admin.', 'prefix' => 'admin'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::group(['middleware' => [], 'as' => 'profile.', 'prefix' => 'profile'], function () {
        Route::get('profile/{profile}', [ProfileController::class, 'profile'])->name('index');
        Route::put('profile/{profile}/update-profile', [ProfileController::class, 'updateProfile'])->name('profile-update');
    });

    Route::group(['middleware' => [], 'as' => 'hak-akses.', 'prefix' => 'hak-akses'], function () {
        Route::resource('permission', PermissionController::class)->except('show', 'create', 'edit');
        Route::resource('user', UserController::class)->except('show');
    });

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
});

Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
