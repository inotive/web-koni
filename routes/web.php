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
use App\Http\Controllers\Admin\SumberdayaController;
use App\Http\Controllers\Admin\SportScienceController;
use App\Http\Controllers\Admin\BidangController;
use App\Http\Controllers\Admin\perencanaanprogramController;
use App\Http\Controllers\Admin\pembinaanhukumController;
use App\Http\Controllers\Admin\organisasiController;
use App\Http\Controllers\Admin\kesehatanController;
use App\Http\Controllers\Admin\hubunganlembagaController;
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


    Route::group(['as' => 'profile.', 'prefix' => 'profile'], function () {
        Route::get('profile/{profile}', [ProfileController::class, 'profile'])->name('index');
        Route::put('profile/{profile}/update-profile', [ProfileController::class, 'updateProfile'])->name('profile-update');
    });

    Route::resource('file-kesekretariat', \App\Http\Controllers\Admin\FileKesekretariatController::class);
    // Letakkan rute 'download' sebelum rute resourc    e
    Route::get('file-kesekretariat/{fileKesekretariat}/download', [\App\Http\Controllers\Admin\FileKesekretariatController::class, 'download'])
        ->name('file-kesekretariat.download');


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
        Route::resource('atlet', AtletController::class);
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
            Route::get('/{cabang_olahraga}', [CabangOlahragaController::class, 'show'])->name('show');
            Route::get('/{cabang_olahraga}/edit', [CabangOlahragaController::class, 'edit'])->name('edit');
            Route::put('/{cabang_olahraga}', [CabangOlahragaController::class, 'update'])->name('update');
            Route::delete('/{cabang_olahraga}', [CabangOlahragaController::class, 'destroy'])->name('destroy');

            // TAMBAHAN: Rute untuk fitur khusus CabangOlahraga
            Route::get('/reset-filters', [CabangOlahragaController::class, 'resetFilters'])->name('reset-filters');
            Route::get('/export', [CabangOlahragaController::class, 'export'])->name('export');
            Route::patch('/{cabang_olahraga}/deactivate', [CabangOlahragaController::class, 'deactivate'])->name('deactivate');
            Route::get('/{cabang_olahraga}/check-dependencies', [CabangOlahragaController::class, 'checkDependencies'])->name('check-dependencies');
            Route::delete('/{cabang_olahraga}/force', [CabangOlahragaController::class, 'forceDestroy'])->name('force-destroy');
        });

        // Rute Prestasi - Diperbaiki struktur
        Route::prefix('prestasi')->name('prestasi.')->group(function () {
            // Rute utama prestasi
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

        // Rute tambahan Pelatih
        Route::get('pelatih/{id}/deskripsi', [PelatihController::class, 'deskripsi'])
            ->name('pelatih.deskripsi');
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
        Route::prefix('sekretariat')->name('sekretariat.')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\SekretariatController::class, 'index'])->name('index');
            Route::get('/create', [App\Http\Controllers\Admin\SekretariatController::class, 'create'])->name('create');
            Route::post('/', [App\Http\Controllers\Admin\SekretariatController::class, 'store'])->name('store');
            Route::get('/{sekretariat}', [App\Http\Controllers\Admin\SekretariatController::class, 'show'])->name('show');
            Route::get('/{sekretariat}/edit', [App\Http\Controllers\Admin\SekretariatController::class, 'edit'])->name('edit');
            Route::put('/{sekretariat}', [App\Http\Controllers\Admin\SekretariatController::class, 'update'])->name('update');
            Route::delete('/{sekretariat}', [App\Http\Controllers\Admin\SekretariatController::class, 'destroy'])->name('destroy');
        });

        // Route untuk Bidang
        Route::prefix('bidang')->name('bidang.')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\BidangController::class, 'index'])->name('index');

            // Prestasi routes (menghapus duplikasi dari kode sebelumnya)
            Route::prefix('prestasi')->name('prestasi.')->group(function () {
                Route::get('/', [App\Http\Controllers\Admin\BidangController::class, 'prestasiIndex'])->name('index');
                Route::get('/cabor-terukur', [App\Http\Controllers\Admin\BidangController::class, 'caborTerukur'])->name('cabor-terukur');
                Route::get('/cabor-permainan', [App\Http\Controllers\Admin\BidangController::class, 'caborPermainan'])->name('cabor-permainan');
                Route::get('/cabor-beladiri', [App\Http\Controllers\Admin\BidangController::class, 'caborBeladiri'])->name('cabor-beladiri');
                Route::get('/cabor-akurasi', [App\Http\Controllers\Admin\BidangController::class, 'caborAkurasi'])->name('cabor-akurasi');
            });

            //sumberdaya
            Route::prefix('mobilisasi-sumberdaya')->name('mobilisasi-sumberdaya.')->group(function () {
                Route::get('/', [App\Http\Controllers\Admin\SumberdayaController::class, 'index'])->name('index');
                Route::get('/create', [App\Http\Controllers\Admin\SumberdayaController::class, 'create'])->name('create');
                Route::post('/', [App\Http\Controllers\Admin\SumberdayaController::class, 'store'])->name('store');
                Route::get('/{sumberdaya}', [App\Http\Controllers\Admin\SumberdayaController::class, 'show'])->name('show');
                Route::get('/{sumberdaya}/edit', [App\Http\Controllers\Admin\SumberdayaController::class, 'edit'])->name('edit');
                Route::put('/{sumberdaya}', [App\Http\Controllers\Admin\SumberdayaController::class, 'update'])->name('update');
                Route::delete('/{sumberdaya}', [App\Http\Controllers\Admin\SumberdayaController::class, 'destroy'])->name('destroy');
            });

            Route::prefix('sport-science')->name('sport-science.')->group(function () {
                Route::get('/', [App\Http\Controllers\Admin\SportScienceController::class, 'index'])->name('index');
                Route::get('/create', [App\Http\Controllers\Admin\SportScienceController::class, 'create'])->name('create');
                Route::post('/', [App\Http\Controllers\Admin\SportScienceController::class, 'store'])->name('store');
                Route::get('/{sportscience}', [App\Http\Controllers\Admin\SportScienceController::class, 'show'])->name('show');
                Route::get('/{sportscience}/edit', [App\Http\Controllers\Admin\SportScienceController::class, 'edit'])->name('edit');
                Route::put('/{sportscience}', [App\Http\Controllers\Admin\SportScienceController::class, 'update'])->name('update');
                Route::delete('/{sportscience}', [App\Http\Controllers\Admin\SportScienceController::class, 'destroy'])->name('destroy');
            });

            Route::prefix('perencanaan-program')->name('perencanaan-program.')->group(function () {
                Route::get('/', [App\Http\Controllers\Admin\PerencanaanProgramController::class, 'index'])->name('index');
                Route::get('/create', [App\Http\Controllers\Admin\PerencanaanProgramController::class, 'create'])->name('create');
                Route::post('/', [App\Http\Controllers\Admin\PerencanaanProgramController::class, 'store'])->name('store');
                Route::get('/{perencanaanprogram}', [App\Http\Controllers\Admin\PerencanaanProgramController::class, 'show'])->name('show');
                Route::get('/{perencanaanprogram}/edit', [App\Http\Controllers\Admin\PerencanaanProgramController::class, 'edit'])->name('edit');
                Route::put('/{perencanaanprogram}', [App\Http\Controllers\Admin\PerencanaanProgramController::class, 'update'])->name('update');
                Route::delete('/{perencanaanprogram}', [App\Http\Controllers\Admin\PerencanaanProgramController::class, 'destroy'])->name('destroy');
            });

            Route::prefix('pembinaan-hukum')->name('pembinaan-hukum.')->group(function () {
                Route::get('/', [App\Http\Controllers\Admin\pembinaanhukumController::class, 'index'])->name('index');
                Route::get('/create', [App\Http\Controllers\Admin\pembinaanhukumController::class, 'create'])->name('create');
                Route::post('/', [App\Http\Controllers\Admin\pembinaanhukumController::class, 'store'])->name('store');
                Route::get('/{pembinaanhukum}', [App\Http\Controllers\Admin\pembinaanhukumController::class, 'show'])->name('show');
                Route::get('/{pembinaanhukum}/edit', [App\Http\Controllers\Admin\pembinaanhukumController::class, 'edit'])->name('edit');
                Route::put('/{pembinaanhukum}', [App\Http\Controllers\Admin\pembinaanhukumController::class, 'update'])->name('update');
                Route::delete('/{pembinaanhukum}', [App\Http\Controllers\Admin\pembinaanhukumController::class, 'destroy'])->name('destroy');
            });

            Route::prefix('organisasi')->name('organisasi.')->group(function () {
                Route::get('/', [App\Http\Controllers\Admin\organisasiController::class, 'index'])->name('index');
                Route::get('/create', [App\Http\Controllers\Admin\organisasiController::class, 'create'])->name('create');
                Route::post('/', [App\Http\Controllers\Admin\organisasiController::class, 'store'])->name('store');
                Route::get('/{organisasi}', [App\Http\Controllers\Admin\organisasiController::class, 'show'])->name('show');
                Route::get('/{organisasi}/edit', [App\Http\Controllers\Admin\organisasiController::class, 'edit'])->name('edit');
                Route::put('/{organisasi}', [App\Http\Controllers\Admin\organisasiController::class, 'update'])->name('update');
                Route::delete('/{organisasi}', [App\Http\Controllers\Admin\organisasiController::class, 'destroy'])->name('destroy');
            });

            Route::prefix('kesehatan')->name('kesehatan.')->group(function () {
                Route::get('/', [App\Http\Controllers\Admin\kesehatanController::class, 'index'])->name('index');
                Route::get('/create', [App\Http\Controllers\Admin\kesehatanController::class, 'create'])->name('create');
                Route::post('/', [App\Http\Controllers\Admin\kesehatanController::class, 'store'])->name('store');
                Route::get('/{kesehatan}', [App\Http\Controllers\Admin\kesehatanController::class, 'show'])->name('show');
                Route::get('/{kesehatan}/edit', [App\Http\Controllers\Admin\kesehatanController::class, 'edit'])->name('edit');
                Route::put('/{kesehatan}', [App\Http\Controllers\Admin\kesehatanController::class, 'update'])->name('update');
                Route::delete('/{kesehatan}', [App\Http\Controllers\Admin\kesehatanController::class, 'destroy'])->name('destroy');
            });

            Route::prefix('hubungan-antar-lembaga')->name('hubungan-antar-lembaga.')->group(function () {
                Route::get('/', [App\Http\Controllers\Admin\hubunganlembagaController::class, 'index'])->name('index');
                Route::get('/create', [App\Http\Controllers\Admin\hubunganlembagaController::class, 'create'])->name('create');
                Route::post('/', [App\Http\Controllers\Admin\hubunganlembagaController::class, 'store'])->name('store');
                Route::get('/{hubunganlembaga}', [App\Http\Controllers\Admin\hubunganlembagaController::class, 'show'])->name('show');
                Route::get('/{hubunganlembaga}/edit', [App\Http\Controllers\Admin\hubunganlembagaController::class, 'edit'])->name('edit');
                Route::put('/{hubunganlembaga}', [App\Http\Controllers\Admin\hubunganlembagaController::class, 'update'])->name('update');
                Route::delete('/{hubunganlembaga}', [App\Http\Controllers\Admin\hubunganlembagaController::class, 'destroy'])->name('destroy');
            });
        });
        Route::prefix('kegiatan_lainnya')->name('kegiatan_lainnya.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\KegiatanLainnyaController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\Admin\KegiatanLainnyaController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\Admin\KegiatanLainnyaController::class, 'store'])->name('store');
        Route::get('/{kegiatanLainnya}', [App\Http\Controllers\Admin\KegiatanLainnyaController::class, 'show'])->name('show');
        Route::get('/{kegiatanLainnya}/edit', [App\Http\Controllers\Admin\KegiatanLainnyaController::class, 'edit'])->name('edit');
        Route::put('/{kegiatanLainnya}', [App\Http\Controllers\Admin\KegiatanLainnyaController::class, 'update'])->name('update');
        Route::delete('/{kegiatanLainnya}', [App\Http\Controllers\Admin\KegiatanLainnyaController::class, 'destroy'])->name('destroy');
    });

    // Route untuk Bidang
    Route::prefix('bidang')->name('bidang.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\BidangController::class, 'index'])->name('index');

        // Prestasi routes
        Route::prefix('prestasi')->name('prestasi.')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\BidangController::class, 'prestasiIndex'])->name('index');
            Route::get('/cabor-terukur', [App\Http\Controllers\Admin\BidangController::class, 'caborTerukur'])->name('cabor-terukur');
            Route::get('/cabor-permainan', [App\Http\Controllers\Admin\BidangController::class, 'caborPermainan'])->name('cabor-permainan');
            Route::get('/cabor-beladiri', [App\Http\Controllers\Admin\BidangController::class, 'caborBeladiri'])->name('cabor-beladiri');
            Route::get('/cabor-akurasi', [App\Http\Controllers\Admin\BidangController::class, 'caborAkurasi'])->name('cabor-akurasi');
        });

        //sumberdaya
        Route::prefix('mobilisasi-sumberdaya')->name('mobilisasi-sumberdaya.')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\SumberdayaController::class, 'index'])->name('index');
            Route::get('/create', [App\Http\Controllers\Admin\SumberdayaController::class, 'create'])->name('create');
            Route::post('/', [App\Http\Controllers\Admin\SumberdayaController::class, 'store'])->name('store');
            Route::get('/{sumberdaya}', [App\Http\Controllers\Admin\SumberdayaController::class, 'show'])->name('show');
            Route::get('/{sumberdaya}/edit', [App\Http\Controllers\Admin\SumberdayaController::class, 'edit'])->name('edit');
            Route::put('/{sumberdaya}', [App\Http\Controllers\Admin\SumberdayaController::class, 'update'])->name('update');
            Route::delete('/{sumberdaya}', [App\Http\Controllers\Admin\SumberdayaController::class, 'destroy'])->name('destroy');
        });

        Route::get('/hubungan-antar-lembaga', [App\Http\Controllers\Admin\BidangController::class, 'hubunganAntarLembaga'])->name('hubungan-antar-lembaga');
        Route::get('/kesehatan', [App\Http\Controllers\Admin\BidangController::class, 'kesehatan'])->name('kesehatan');
        Route::get('/organisasi', [App\Http\Controllers\Admin\BidangController::class, 'organisasi'])->name('organisasi');
        Route::get('/pembinaan-hukum', [App\Http\Controllers\Admin\BidangController::class, 'pembinaanHukum'])->name('pembinaan-hukum');
        Route::get('/sport-science', [App\Http\Controllers\Admin\BidangController::class, 'sportScience'])->name('sport-science');
        Route::get('/perencanaan-program', [App\Http\Controllers\Admin\BidangController::class, 'perencanaanProgram'])->name('perencanaan-program');
    });

    // FIXED: Kegiatan Lainnya Routes - Properly structured
    Route::prefix('kegiatan_lainnya')->name('kegiatan_lainnya.')->group(function () {
        Route::get('/', [KegiatanLainnyaController::class, 'index'])->name('index');
        Route::get('/create', [KegiatanLainnyaController::class, 'create'])->name('create');
        Route::post('/', [KegiatanLainnyaController::class, 'store'])->name('store');

        // IMPORTANT: Export route must come BEFORE parameterized routes
        Route::get('/export', [KegiatanLainnyaController::class, 'export'])->name('export');

        // Parameterized routes come after static routes
        Route::get('/{kegiatan_lainnya}', [KegiatanLainnyaController::class, 'show'])->name('show');
        Route::get('/{kegiatan_lainnya}/detail', [KegiatanLainnyaController::class, 'showDetail'])
        ->name('detail');
        Route::get('/{kegiatan_lainnya}/edit', [KegiatanLainnyaController::class, 'edit'])->name('edit');
        Route::put('/{kegiatan_lainnya}', [KegiatanLainnyaController::class, 'update'])->name('update');
        Route::delete('/{kegiatan_lainnya}', [KegiatanLainnyaController::class, 'destroy'])->name('destroy');
        Route::get('/{id}/detail-ajax', [KegiatanLainnyaController::class, 'getDetail'])->name('detail-ajax');
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
