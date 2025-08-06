<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\AtletController;
use App\Http\Controllers\Admin\PelatihController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\PrestasiController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\CabangOlahragaController;
use App\Http\Controllers\Admin\ManajemenRKAController;
use App\Http\Controllers\Admin\SekretariatController;


Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('login', [LoginController::class, 'show'])->middleware('guest')->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login-post');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::group(['middleware' => ['auth'], 'as' => 'admin.', 'prefix' => 'admin'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    Route::group(['as' => 'profile.', 'prefix' => 'profile'], function () {
        Route::get('profile/{profile}', [ProfileController::class, 'profile'])->name('index');
        Route::put('profile/{profile}/update-profile', [ProfileController::class, 'updateProfile'])->name('profile-update');
    });

    Route::group(['as' => 'hak-akses.', 'prefix' => 'hak-akses'], function () {
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

    Route::resource('manajemen-rka', ManajemenRKAController::class);

    Route::prefix('konfigurasi')->name('konfigurasi.')->group(function () {
        Route::resource('atlet', AtletController::class);
        Route::resource('pelatih', PelatihController::class);
        Route::post('pelatih/{pelatih}/prestasi', [PrestasiController::class, 'store'])
            ->name('pelatih.prestasi.store');

        // PERBAIKAN: Cabang Olahraga Routes - Dipisahkan dan Diperbaiki
        Route::prefix('cabang-olahraga')->name('cabang-olahraga.')->group(function () {
            // Standard CRUD routes
            Route::get('/', [CabangOlahragaController::class, 'index'])->name('index');
            Route::get('/create', [CabangOlahragaController::class, 'create'])->name('create');
            Route::post('/', [CabangOlahragaController::class, 'store'])->name('store');
            Route::get('/{cabang_olahraga}', [CabangOlahragaController::class, 'show'])->name('show');
            Route::get('/{cabang_olahraga}/edit', [CabangOlahragaController::class, 'edit'])->name('edit');
            Route::put('/{cabang_olahraga}', [CabangOlahragaController::class, 'update'])->name('update');
            Route::delete('/{cabang_olahraga}', [CabangOlahragaController::class, 'destroy'])->name('destroy');

            // TAMBAHAN: Routes untuk fitur khusus CabangOlahraga
            Route::get('/reset-filters', [CabangOlahragaController::class, 'resetFilters'])->name('reset-filters');
            Route::get('/export', [CabangOlahragaController::class, 'export'])->name('export');
            Route::patch('/{cabang_olahraga}/deactivate', [CabangOlahragaController::class, 'deactivate'])->name('deactivate');
            Route::get('/{cabang_olahraga}/check-dependencies', [CabangOlahragaController::class, 'checkDependencies'])->name('check-dependencies');
            Route::delete('/{cabang_olahraga}/force', [CabangOlahragaController::class, 'forceDestroy'])->name('force-destroy');
        });

        // Prestasi Routes - Diperbaiki struktur
        Route::prefix('prestasi')->name('prestasi.')->group(function () {
            // Main prestasi routes
            Route::get('/', [PrestasiController::class, 'index'])->name('index');
            Route::get('/create', [PrestasiController::class, 'create'])->name('create');
            Route::post('/', [PrestasiController::class, 'store'])->name('store');
            Route::get('/{prestasi}', [PrestasiController::class, 'show'])->name('show');
            Route::get('/{prestasi}/edit', [PrestasiController::class, 'edit'])->name('edit');
            Route::put('/{prestasi}', [PrestasiController::class, 'update'])->name('update');
            Route::delete('/{prestasi}', [PrestasiController::class, 'destroy'])->name('destroy');

            // Prestasi untuk Atlet
            Route::prefix('atlet')->name('atlet.')->group(function () {
                Route::get('/{atlet}/create', [PrestasiController::class, 'createForAtlet'])->name('create');
                Route::post('/{atlet}', [PrestasiController::class, 'storeForAtlet'])->name('store');
            });

            // Prestasi untuk Pelatih
            Route::prefix('pelatih')->name('pelatih.')->group(function () {
                Route::get('/{pelatih}/create', [PrestasiController::class, 'createForPelatih'])->name('create');
                Route::post('/{pelatih}', [PrestasiController::class, 'storeForPelatih'])->name('store');
            });
        });

        // Pelatih additional routes
        Route::get('pelatih/{id}/deskripsi', [PelatihController::class, 'deskripsi'])
            ->name('pelatih.deskripsi');
    });
    Route::prefix('laporan-lpj')
        ->name('laporan-lpj.')
        ->group(function () {
            Route::resource('sekretariat', SekretariatController::class);


            Route::prefix('bidang')->name('bidang.')->group(function () {
                Route::get('/', [App\Http\Controllers\Admin\BidangController::class, 'index'])->name('index');

                // Prestasi routes
                Route::prefix('prestasi')->name('prestasi.')->group(function () {
                    Route::get('/', [App\Http\Controllers\Admin\BidangController::class, 'prestasiIndex'])->name('index');
                });
                Route::get('/mobilisasi-sumberdaya', [App\Http\Controllers\Admin\BidangController::class, 'mobilisasiSumberdayaIndex'])->name('mobilisasi-sumberdaya');
                Route::get('/hubungan-antar-lembaga', [App\Http\Controllers\Admin\BidangController::class, 'hubunganAntarLembaga'])->name('hubungan-antar-lembaga');
                Route::get('/kesehatan', [App\Http\Controllers\Admin\BidangController::class, 'kesehatan'])->name('kesehatan');
                Route::get('/organisasi', [App\Http\Controllers\Admin\BidangController::class, 'organisasi'])->name('organisasi');
                Route::get('/pembinaan-hukum', [App\Http\Controllers\Admin\BidangController::class, 'pembinaanHukum'])->name('pembinaan-hukum');
                Route::get('/sport-science', [App\Http\Controllers\Admin\BidangController::class, 'sportScience'])->name('sport-science');
                Route::get('/perencanaan-program', [App\Http\Controllers\Admin\BidangController::class, 'perencanaanProgram'])->name('perencanaan-program');
            });
        });
});
