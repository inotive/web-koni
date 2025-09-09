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
use App\Http\Controllers\Admin\BendaharaController;
use App\Http\Controllers\Admin\SuratController;
use App\Http\Controllers\Admin\BidangController;
use App\Http\Controllers\Admin\LpjController;
use App\Http\Controllers\LaporanRKAController;
use App\Http\Controllers\Admin\KegiatanLainnyaController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Di sini Anda dapat mendaftarkan rute web untuk aplikasi Anda. Rute-rute ini
| akan dimuat oleh RouteServiceProvider dan semuanya akan ditetapkan ke
| grup middleware "web". Buat sesuatu yang hebat!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('login', [LoginController::class, 'show'])->middleware('guest')->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login-post');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::group(['middleware' => ['auth'], 'as' => 'admin.', 'prefix' => 'admin'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/dashboard/prestasi', [DashboardController::class, 'prestasiPagination'])->name('dashboard.prestasi-pagination');
    Route::get('/dashboard/export', [DashboardController::class, 'exportData'])->name('dashboard.export');


    Route::group(['as' => 'profile.', 'prefix' => 'profile'], function () {
        Route::get('profile/{profile}', [ProfileController::class, 'profile'])->name('index');
        Route::put('profile/{profile}/update-profile', [ProfileController::class, 'updateProfile'])->name('profile-update');
    });

    // File Kesekretariat routes
    Route::get('file-kesekretariat', [\App\Http\Controllers\Admin\FileKesekretariatController::class, 'index'])
        ->name('file-kesekretariat.index');
    Route::get('file-kesekretariat/create', [\App\Http\Controllers\Admin\FileKesekretariatController::class, 'create'])
        ->name('file-kesekretariat.create');
    Route::post('file-kesekretariat', [\App\Http\Controllers\Admin\FileKesekretariatController::class, 'store'])
        ->name('file-kesekretariat.store');
    Route::get('file-kesekretariat/{fileKesekretariat}', [\App\Http\Controllers\Admin\FileKesekretariatController::class, 'show'])
        ->name('file-kesekretariat.show');
    Route::get('file-kesekretariat/{fileKesekretariat}/edit', [\App\Http\Controllers\Admin\FileKesekretariatController::class, 'edit'])
        ->name('file-kesekretariat.edit');
    Route::put('file-kesekretariat/{fileKesekretariat}', [\App\Http\Controllers\Admin\FileKesekretariatController::class, 'update'])
        ->name('file-kesekretariat.update');
    Route::delete('file-kesekretariat/{fileKesekretariat}', [\App\Http\Controllers\Admin\FileKesekretariatController::class, 'destroy'])
        ->name('file-kesekretariat.destroy');

    // File download route
    Route::get('file-kesekretariat/{fileKesekretariat}/download', [\App\Http\Controllers\Admin\FileKesekretariatController::class, 'download'])
        ->name('file-kesekretariat.download');

    // File preview route
    Route::get('file-kesekretariat/{fileKesekretariat}/preview', [\App\Http\Controllers\Admin\FileKesekretariatController::class, 'preview'])
        ->name('file-kesekretariat.preview');


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
    Route::resource('laporan-rka', LaporanRKAController::class);

    Route::resource('surat', SuratController::class);

    Route::prefix('konfigurasi')->name('konfigurasi.')->group(function () {
        Route::get('atlet/export', [AtletController::class, 'exportCsv'])->name('atlet.export');
        Route::resource('atlet', AtletController::class);
        Route::get('pelatih/export', [PelatihController::class, 'exportCsv'])->name('pelatih.export');
        Route::resource('pelatih', PelatihController::class);
        Route::patch('pelatih/{pelatih}/ketersediaan', [PelatihController::class, 'updateKetersediaan'])
            ->name('pelatih.updateKetersediaan');
        Route::post('pelatih/{pelatih}/prestasi', [PrestasiController::class, 'store'])
            ->name('pelatih.prestasi.store');
        Route::patch('atlet/{atlet}/ketersediaan', [AtletController::class, 'updateKetersediaan'])
            ->name('atlet.updateKetersediaan');
        Route::post('atlet/{atlet}/prestasi', [PrestasiController::class, 'store'])
            ->name('atlet.prestasi.store');

        // PERBAIKAN: Rute Cabang Olahraga - Dipisahkan dan Diperbaiki
        Route::prefix('cabang-olahraga')->name('cabang-olahraga.')->group(function () {
            // Rute CRUD standar
            Route::get('/', [CabangOlahragaController::class, 'index'])->name('index');
            Route::get('/create', [CabangOlahragaController::class, 'create'])->name('create');
            Route::post('/', [CabangOlahragaController::class, 'store'])->name('store');
            Route::get('/{cabor}', [CabangOlahragaController::class, 'show'])->name('show');
            Route::get('/{cabor}/edit', [CabangOlahragaController::class, 'edit'])->name('edit');
            Route::put('/{cabor}', [CabangOlahragaController::class, 'update'])->name('update');
            Route::delete('/{cabor}', [CabangOlahragaController::class, 'destroy'])->name('destroy');

            // TAMBAHAN: Rute untuk fitur khusus CabangOlahraga
            Route::get('/reset-filters', [CabangOlahragaController::class, 'resetFilters'])->name('reset-filters');
            Route::get('/export', [CabangOlahragaController::class, 'export'])->name('export');
            Route::patch('/{cabor}/deactivate', [CabangOlahragaController::class, 'deactivate'])->name('deactivate');
            Route::get('/{cabor}/check-dependencies', [CabangOlahragaController::class, 'checkDependencies'])->name('check-dependencies');
            Route::delete('/{cabor}/force', [CabangOlahragaController::class, 'forceDestroy'])->name('force-destroy');
        });

        // Rute Prestasi - Diperbaiki struktur
        Route::prefix('prestasi')->name('prestasi.')->group(function () {
            // Rute utama prestasi
            Route::get('/', [PrestasiController::class, 'index'])->name('index');
            Route::get('/export', [PrestasiController::class, 'exportCsv'])->name('export');
            Route::get('/create', [PrestasiController::class, 'create'])->name('create');
            Route::post('/', [PrestasiController::class, 'store'])->name('store');
            Route::get('/{prestasi}', [PrestasiController::class, 'show'])->name('show');
            Route::get('/{prestasi}/edit', [PrestasiController::class, 'edit'])->name('edit');
            Route::put('/{prestasi}', [PrestasiController::class, 'update'])->name('update');
            Route::delete('/{prestasi}', [PrestasiController::class, 'destroy'])->name('destroy');

            // Prestasi untuk Atlet
            Route::prefix('atlet')->name('atlet.')->group(function () {
                Route::get('/{atlet}/export-detail', [AtletController::class, 'exportDetail'])->name('exportDetail');
                Route::get('/{atlet}/export-pdf', [AtletController::class, 'exportPdf'])->name('exportPdf');
                Route::get('/{atlet}/create', [PrestasiController::class, 'createForAtlet'])->name('create');
                Route::post('/{atlet}', [PrestasiController::class, 'storeForAtlet'])->name('store');
            });

            // Prestasi untuk Pelatih
            Route::prefix('pelatih')->name('pelatih.')->group(function () {
                Route::get('/{pelatih}/create', [PrestasiController::class, 'createForPelatih'])->name('create');
                Route::post('/{pelatih}', [PrestasiController::class, 'storeForPelatih'])->name('store');
            });
        });

        // Rute tambahan Pelatih
        Route::get('pelatih/{id}/deskripsi', [PelatihController::class, 'deskripsi'])
            ->name('pelatih.deskripsi');
    });
    Route::prefix('laporan-lpj/bidang')->name('laporan-lpj.bidang.')->group(function () {

        // Dynamic LPJ Routes with hierarchical support
        Route::prefix('dynamic')->name('dynamic.')->group(function () {

            // Root level routes (no parent)
            Route::get('/', [App\Http\Controllers\Admin\LpjController::class, 'index'])->name('index');
            Route::get('/create', [App\Http\Controllers\Admin\LpjController::class, 'create'])->name('create');
            Route::post('/store', [App\Http\Controllers\Admin\LpjController::class, 'store'])->name('store');
            Route::get('/create-category', [App\Http\Controllers\Admin\LpjController::class, 'createCategory'])->name('create-category');
            Route::post('/store-category', [App\Http\Controllers\Admin\LpjController::class, 'storeCategory'])->name('store-category');

            // Export routes
            Route::get('/export-csv', [App\Http\Controllers\Admin\LpjController::class, 'exportCsv'])->name('export-csv');

            // Child level routes (with parent)
            Route::prefix('{parentId}')->group(function () {
                Route::get('/', [App\Http\Controllers\Admin\LpjController::class, 'index'])->name('child.index');
                Route::get('/create', [App\Http\Controllers\Admin\LpjController::class, 'create'])->name('child.create');
                Route::post('/store', [App\Http\Controllers\Admin\LpjController::class, 'store'])->name('child.store');
                Route::get('/create-category', [App\Http\Controllers\Admin\LpjController::class, 'createCategory'])->name('child.create-category');
                Route::post('/store-category', [App\Http\Controllers\Admin\LpjController::class, 'storeCategory'])->name('child.store-category');
                Route::get('/navigate', [App\Http\Controllers\Admin\LpjController::class, 'navigate'])->name('navigate');
                Route::get('/export-csv', [App\Http\Controllers\Admin\LpjController::class, 'exportCsv'])->name('child.export-csv');

                // Nested child routes (for deeper hierarchies)
                Route::prefix('{childId}')->group(function () {
                    Route::get('/', [App\Http\Controllers\Admin\LpjController::class, 'index'])->name('nested.index');
                    Route::get('/create', [App\Http\Controllers\Admin\LpjController::class, 'create'])->name('nested.create');
                    Route::post('/store', [App\Http\Controllers\Admin\LpjController::class, 'store'])->name('nested.store');
                    Route::get('/create-category', [App\Http\Controllers\Admin\LpjController::class, 'createCategory'])->name('nested.create-category');
                    Route::post('/store-category', [App\Http\Controllers\Admin\LpjController::class, 'storeCategory'])->name('nested.store-category');
                });
            });

            // Individual item routes (can be at any level)
            Route::get('/item/{id}', [App\Http\Controllers\Admin\LpjController::class, 'show'])->name('show');
            Route::get('/item/{id}/edit', [App\Http\Controllers\Admin\LpjController::class, 'edit'])->name('edit');
            Route::put('/item/{id}', [App\Http\Controllers\Admin\LpjController::class, 'update'])->name('update');
            Route::delete('/item/{id}', [App\Http\Controllers\Admin\LpjController::class, 'destroy'])->name('destroy');

            // API routes for tree structure
            Route::get('/api/tree/{parentId?}', [App\Http\Controllers\Admin\LpjController::class, 'getTreeStructure'])->name('api.tree');
        });
    });

    Route::prefix('laporan-lpj')->name('laporan-lpj.')->group(function () {

        Route::prefix('sekretariat')->name('sekretariat.')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\SekretariatController::class, 'index'])->name('index');
            Route::get('/create', [App\Http\Controllers\Admin\SekretariatController::class, 'create'])->name('create');
            Route::post('/', [App\Http\Controllers\Admin\SekretariatController::class, 'store'])->name('store');
            Route::get('/{sekretariat}', [App\Http\Controllers\Admin\SekretariatController::class, 'show'])->name('show');
            Route::get('/{sekretariat}/edit', [App\Http\Controllers\Admin\SekretariatController::class, 'edit'])->name('edit');
            Route::put('/{sekretariat}', [App\Http\Controllers\Admin\SekretariatController::class, 'update'])->name('update');
            Route::delete('/{sekretariat}', [App\Http\Controllers\Admin\SekretariatController::class, 'destroy'])->name('destroy');
            Route::get('/{sekretariat}/export', [App\Http\Controllers\Admin\SekretariatController::class, 'export'])->name('export');
        });

        // Route untuk Bidang
        Route::prefix('bidang')->name('bidang.')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\BidangController::class, 'index'])->name('index');

            // Pembinaan Prestasi routes
            Route::prefix('prestasi')->name('prestasi.')->group(function () {
                Route::get('/', [App\Http\Controllers\Admin\BidangController::class, 'prestasiIndex'])->name('index');
                Route::get('/cabor-terukur', [App\Http\Controllers\Admin\BidangController::class, 'caborTerukur'])->name('cabor-terukur');
                Route::get('/cabor-permainan', [App\Http\Controllers\Admin\BidangController::class, 'caborPermainan'])->name('cabor-permainan');
                Route::get('/cabor-beladiri', [App\Http\Controllers\Admin\BidangController::class, 'caborBeladiri'])->name('cabor-beladiri');
                Route::get('/cabor-akurasi', [App\Http\Controllers\Admin\BidangController::class, 'caborAkurasi'])->name('cabor-akurasi');
            });
        });

        Route::prefix('pengajuan')->name('pengajuan.')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\PengajuanController::class, 'index'])->name('index');
            Route::post('/', [App\Http\Controllers\Admin\PengajuanController::class, 'store'])->name('store');
            Route::patch('/{pengajuan}/status', [App\Http\Controllers\Admin\PengajuanController::class, 'updateStatus'])->name('updateStatus');
        });

        Route::prefix('kegiatan-lainnya')->name('kegiatan-lainnya.')->group(function () {
            Route::get('/', [KegiatanLainnyaController::class, 'index'])->name('index');
            Route::get('/create', [KegiatanLainnyaController::class, 'create'])->name('create');
            Route::post('/', [KegiatanLainnyaController::class, 'store'])->name('store');

            // Export route - generates: admin.laporan-lpj.kegiatan-lainnya.export
            Route::post('/export', [KegiatanLainnyaController::class, 'export'])->name('export');

    Route::get('/{id}/detail-ajax', [KegiatanLainnyaController::class, 'getDetail'])
        ->name('detail-ajax')
        ->where('id', '[0-9]+');

            Route::get('/{id}', [KegiatanLainnyaController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [KegiatanLainnyaController::class, 'edit'])->name('edit');
            Route::put('/{id}', [KegiatanLainnyaController::class, 'update'])->name('update');
            Route::delete('/{id}', [KegiatanLainnyaController::class, 'destroy'])->name('destroy');
            Route::post('/{id}/approve', [KegiatanLainnyaController::class, 'approve'])->name('approve');
        });
    }); //Batas LPJ
    Route::prefix('bendahara')->name('bendahara.')->group(function () {
        Route::get('/', [BendaharaController::class, 'index'])->name('index');
        Route::get('/create', [BendaharaController::class, 'create'])->name('create');
        Route::post('/', [BendaharaController::class, 'store'])->name('store');
        Route::get('/{bendahara}', [BendaharaController::class, 'show'])->name('show');
        Route::get('/{bendahara}/edit', [BendaharaController::class, 'edit'])->name('edit');
        Route::put('/{bendahara}', [BendaharaController::class, 'update'])->name('update');
        Route::delete('/{bendahara}', [BendaharaController::class, 'destroy'])->name('destroy');
        Route::get('/{bendahara}/download', [BendaharaController::class, 'download'])->name('download');
    });
}); //Batas Admin

// TAMBAHAN: Rute untuk panggilan API jika diperlukan (opsional)
Route::prefix('api/admin')->name('api.admin.')->middleware('auth')->group(function () {
    Route::prefix('cabang-olahraga')->name('cabang-olahraga.')->group(function () {
        Route::get('/search', [CabangOlahragaController::class, 'search'])->name('search');
        Route::get('/{id}/dependencies', [CabangOlahragaController::class, 'checkDependencies'])->name('dependencies');
    });
});
