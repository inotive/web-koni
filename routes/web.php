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
use App\Http\Controllers\Admin\AkuatikController;
use App\Http\Controllers\Admin\FajiController;
use App\Http\Controllers\Admin\FptiController;
use App\Http\Controllers\Admin\ImiController;
use App\Http\Controllers\Admin\IssiController;
use App\Http\Controllers\Admin\PabersiController;
use App\Http\Controllers\Admin\PasiController;
use App\Http\Controllers\Admin\PorserosiController;
use App\Http\Controllers\Admin\PosisiController;
use App\Http\Controllers\Admin\EsiController;
use App\Http\Controllers\Admin\FasiController;
use App\Http\Controllers\Admin\FtiController;
use App\Http\Controllers\Admin\IodiController;
use App\Http\Controllers\Admin\PbfiController;
use App\Http\Controllers\Admin\PerbaikinController;
use App\Http\Controllers\Admin\PerpaniController;
use App\Http\Controllers\Admin\PersaniController;
use App\Http\Controllers\Admin\PgiController;
use App\Http\Controllers\Admin\PobsiController;
use App\Http\Controllers\Admin\PordasiController;
use App\Http\Controllers\Admin\AbtiController;
use App\Http\Controllers\Admin\AfkabController;
use App\Http\Controllers\Admin\GabsiController;
use App\Http\Controllers\Admin\PbsiController;
use App\Http\Controllers\Admin\PbvsiController;
use App\Http\Controllers\Admin\PdbiController;
use App\Http\Controllers\Admin\PeltiController;
use App\Http\Controllers\Admin\PerbasiController;
use App\Http\Controllers\Admin\PercasiController;
use App\Http\Controllers\Admin\PssiController;
use App\Http\Controllers\Admin\PstiController;
use App\Http\Controllers\Admin\PtmsiController;
use App\Http\Controllers\Admin\FerkushiController;
use App\Http\Controllers\Admin\ForkiController;
use App\Http\Controllers\Admin\IbcaController;
use App\Http\Controllers\Admin\IkasiController;
use App\Http\Controllers\Admin\IpsiController;
use App\Http\Controllers\Admin\KbiController;
use App\Http\Controllers\Admin\MiController;
use App\Http\Controllers\Admin\PerkemiController;
use App\Http\Controllers\Admin\PersambiController;
use App\Http\Controllers\Admin\PertinaController;
use App\Http\Controllers\Admin\PgsiController;
use App\Http\Controllers\Admin\PjsiController;
use App\Http\Controllers\Admin\TiController;
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
    // Letakkan rute 'download' sebelum rute resource
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
        });

        // Route untuk Bidang
        Route::prefix('bidang')->name('bidang.')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\BidangController::class, 'index'])->name('index');

            // Prestasi routes (menghapus duplikasi dari kode sebelumnya)
            Route::prefix('prestasi')->name('prestasi.')->group(function () {
                Route::get('/', [App\Http\Controllers\Admin\BidangController::class, 'prestasiIndex'])->name('index');
                Route::get('/cabor-terukur', [App\Http\Controllers\Admin\BidangController::class, 'caborTerukur'])->name('cabor-terukur');

                Route::prefix('cabor-terukur')->name('cabor-terukur.')->group(function () {
                    Route::prefix('akuatik')->name('akuatik.')->group(function () {
                        Route::get('/', [App\Http\Controllers\Admin\AkuatikController::class, 'index'])->name('index');
                        Route::get('/create', [App\Http\Controllers\Admin\AkuatikController::class, 'create'])->name('create');
                        Route::post('/', [App\Http\Controllers\Admin\AkuatikController::class, 'store'])->name('store');
                        Route::get('/{akuatik}', [App\Http\Controllers\Admin\AkuatikController::class, 'show'])->name('show');
                        Route::get('/{akuatik}/edit', [App\Http\Controllers\Admin\AkuatikController::class, 'edit'])->name('edit');
                        Route::put('/{akuatik}', [App\Http\Controllers\Admin\AkuatikController::class, 'update'])->name('update');
                        Route::delete('/{akuatik}', [App\Http\Controllers\Admin\AkuatikController::class, 'destroy'])->name('destroy');
                    });

                    Route::prefix('faji')->name('faji.')->group(function () {
                        Route::get('/', [App\Http\Controllers\Admin\FajiController::class, 'index'])->name('index');
                        Route::get('/create', [App\Http\Controllers\Admin\FajiController::class, 'create'])->name('create');
                        Route::post('/', [App\Http\Controllers\Admin\FajiController::class, 'store'])->name('store');
                        Route::get('/{faji}', [App\Http\Controllers\Admin\FajiController::class, 'show'])->name('show');
                        Route::get('/{faji}/edit', [App\Http\Controllers\Admin\FajiController::class, 'edit'])->name('edit');
                        Route::put('/{faji}', [App\Http\Controllers\Admin\FajiController::class, 'update'])->name('update');
                        Route::delete('/{faji}', [App\Http\Controllers\Admin\FajiController::class, 'destroy'])->name('destroy');
                    });

                    Route::prefix('fpti')->name('fpti.')->group(function () {
                        Route::get('/', [App\Http\Controllers\Admin\FptiController::class, 'index'])->name('index');
                        Route::get('/create', [App\Http\Controllers\Admin\FptiController::class, 'create'])->name('create');
                        Route::post('/', [App\Http\Controllers\Admin\FptiController::class, 'store'])->name('store');
                        Route::get('/{fpti}', [App\Http\Controllers\Admin\FptiController::class, 'show'])->name('show');
                        Route::get('/{fpti}/edit', [App\Http\Controllers\Admin\FptiController::class, 'edit'])->name('edit');
                        Route::put('/{fpti}', [App\Http\Controllers\Admin\FptiController::class, 'update'])->name('update');
                        Route::delete('/{fpti}', [App\Http\Controllers\Admin\FptiController::class, 'destroy'])->name('destroy');
                    });

                    Route::prefix('imi')->name('imi.')->group(function () {
                        Route::get('/', [App\Http\Controllers\Admin\ImiController::class, 'index'])->name('index');
                        Route::get('/create', [App\Http\Controllers\Admin\ImiController::class, 'create'])->name('create');
                        Route::post('/', [App\Http\Controllers\Admin\ImiController::class, 'store'])->name('store');
                        Route::get('/{imi}', [App\Http\Controllers\Admin\ImiController::class, 'show'])->name('show');
                        Route::get('/{imi}/edit', [App\Http\Controllers\Admin\ImiController::class, 'edit'])->name('edit');
                        Route::put('/{imi}', [App\Http\Controllers\Admin\ImiController::class, 'update'])->name('update');
                        Route::delete('/{imi}', [App\Http\Controllers\Admin\ImiController::class, 'destroy'])->name('destroy');
                    });

                    Route::prefix('issi')->name('issi.')->group(function () {
                        Route::get('/', [App\Http\Controllers\Admin\IssiController::class, 'index'])->name('index');
                        Route::get('/create', [App\Http\Controllers\Admin\IssiController::class, 'create'])->name('create');
                        Route::post('/', [App\Http\Controllers\Admin\IssiController::class, 'store'])->name('store');
                        Route::get('/{issi}', [App\Http\Controllers\Admin\IssiController::class, 'show'])->name('show');
                        Route::get('/{issi}/edit', [App\Http\Controllers\Admin\IssiController::class, 'edit'])->name('edit');
                        Route::put('/{issi}', [App\Http\Controllers\Admin\IssiController::class, 'update'])->name('update');
                        Route::delete('/{issi}', [App\Http\Controllers\Admin\IssiController::class, 'destroy'])->name('destroy');
                    });

                    Route::prefix('pabersi')->name('pabersi.')->group(function () {
                        Route::get('/', [App\Http\Controllers\Admin\PabersiController::class, 'index'])->name('index');
                        Route::get('/create', [App\Http\Controllers\Admin\PabersiController::class, 'create'])->name('create');
                        Route::post('/', [App\Http\Controllers\Admin\PabersiController::class, 'store'])->name('store');
                        Route::get('/{pabersi}', [App\Http\Controllers\Admin\PabersiController::class, 'show'])->name('show');
                        Route::get('/{pabersi}/edit', [App\Http\Controllers\Admin\PabersiController::class, 'edit'])->name('edit');
                        Route::put('/{pabersi}', [App\Http\Controllers\Admin\PabersiController::class, 'update'])->name('update');
                        Route::delete('/{pabersi}', [App\Http\Controllers\Admin\PabersiController::class, 'destroy'])->name('destroy');
                    });

                    Route::prefix('parsi')->name('parsi.')->group(function () {
                        Route::get('/', [App\Http\Controllers\Admin\ParsiController::class, 'index'])->name('index');
                        Route::get('/create', [App\Http\Controllers\Admin\ParsiController::class, 'create'])->name('create');
                        Route::post('/', [App\Http\Controllers\Admin\ParsiController::class, 'store'])->name('store');
                        Route::get('/{parsi}', [App\Http\Controllers\Admin\ParsiController::class, 'show'])->name('show');
                        Route::get('/{parsi}/edit', [App\Http\Controllers\Admin\ParsiController::class, 'edit'])->name('edit');
                        Route::put('/{parsi}', [App\Http\Controllers\Admin\ParsiController::class, 'update'])->name('update');
                        Route::delete('/{parsi}', [App\Http\Controllers\Admin\ParsiController::class, 'destroy'])->name('destroy');
                    });

                    Route::prefix('pasi')->name('pasi.')->group(function () {
                        Route::get('/', [App\Http\Controllers\Admin\PasiController::class, 'index'])->name('index');
                        Route::get('/create', [App\Http\Controllers\Admin\PasiController::class, 'create'])->name('create');
                        Route::post('/', [App\Http\Controllers\Admin\PasiController::class, 'store'])->name('store');
                        Route::get('/{pasi}', [App\Http\Controllers\Admin\PasiController::class, 'show'])->name('show');
                        Route::get('/{pasi}/edit', [App\Http\Controllers\Admin\PasiController::class, 'edit'])->name('edit');
                        Route::put('/{pasi}', [App\Http\Controllers\Admin\PasiController::class, 'update'])->name('update');
                        Route::delete('/{pasi}', [App\Http\Controllers\Admin\PasiController::class, 'destroy'])->name('destroy');
                    });

                    Route::prefix('porserosi')->name('porserosi.')->group(function () {
                        Route::get('/', [App\Http\Controllers\Admin\PorserosiController::class, 'index'])->name('index');
                        Route::get('/create', [App\Http\Controllers\Admin\PorserosiController::class, 'create'])->name('create');
                        Route::post('/', [App\Http\Controllers\Admin\PorserosiController::class, 'store'])->name('store');
                        Route::get('/{porserosi}', [App\Http\Controllers\Admin\PorserosiController::class, 'show'])->name('show');
                        Route::get('/{porserosi}/edit', [App\Http\Controllers\Admin\PorserosiController::class, 'edit'])->name('edit');
                        Route::put('/{porserosi}', [App\Http\Controllers\Admin\PorserosiController::class, 'update'])->name('update');
                        Route::delete('/{porserosi}', [App\Http\Controllers\Admin\PorserosiController::class, 'destroy'])->name('destroy');
                    });

                    Route::prefix('posisi')->name('posisi.')->group(function () {
                        Route::get('/', [App\Http\Controllers\Admin\PosisiController::class, 'index'])->name('index');
                        Route::get('/create', [App\Http\Controllers\Admin\PosisiController::class, 'create'])->name('create');
                        Route::post('/', [App\Http\Controllers\Admin\PosisiController::class, 'store'])->name('store');
                        Route::get('/{posisi}', [App\Http\Controllers\Admin\PosisiController::class, 'show'])->name('show');
                        Route::get('/{posisi}/edit', [App\Http\Controllers\Admin\PosisiController::class, 'edit'])->name('edit');
                        Route::put('/{posisi}', [App\Http\Controllers\Admin\PosisiController::class, 'update'])->name('update');
                        Route::delete('/{posisi}', [App\Http\Controllers\Admin\PosisiController::class, 'destroy'])->name('destroy');
                    });
                });

                Route::get('/cabor-permainan', [App\Http\Controllers\Admin\BidangController::class, 'caborPermainan'])->name('cabor-permainan');
                Route::prefix('cabor-permainan')->name('cabor-permainan.')->group(function () {
                    Route::prefix('abti')->name('abti.')->group(function () {
                        Route::get('/', [App\Http\Controllers\Admin\AbtiController::class, 'index'])->name('index');
                        Route::get('/create', [App\Http\Controllers\Admin\AbtiController::class, 'create'])->name('create');
                        Route::post('/', [App\Http\Controllers\Admin\AbtiController::class, 'store'])->name('store');
                        Route::get('/{abti}', [App\Http\Controllers\Admin\AbtiController::class, 'show'])->name('show');
                        Route::get('/{abti}/edit', [App\Http\Controllers\Admin\AbtiController::class, 'edit'])->name('edit');
                        Route::put('/{abti}', [App\Http\Controllers\Admin\AbtiController::class, 'update'])->name('update');
                        Route::delete('/{abti}', [App\Http\Controllers\Admin\AbtiController::class, 'destroy'])->name('destroy');
                    });
                    Route::prefix('afkab')->name('afkab.')->group(function () {
                        Route::get('/', [App\Http\Controllers\Admin\AfkabController::class, 'index'])->name('index');
                        Route::get('/create', [App\Http\Controllers\Admin\AfkabController::class, 'create'])->name('create');
                        Route::post('/', [App\Http\Controllers\Admin\AfkabController::class, 'store'])->name('store');
                        Route::get('/{afkab}', [App\Http\Controllers\Admin\AfkabController::class, 'show'])->name('show');
                        Route::get('/{afkab}/edit', [App\Http\Controllers\Admin\AfkabController::class, 'edit'])->name('edit');
                        Route::put('/{afkab}', [App\Http\Controllers\Admin\AfkabController::class, 'update'])->name('update');
                        Route::delete('/{afkab}', [App\Http\Controllers\Admin\AfkabController::class, 'destroy'])->name('destroy');
                    });
                    Route::prefix('gabsi')->name('gabsi.')->group(function () {
                        Route::get('/', [App\Http\Controllers\Admin\GabsiController::class, 'index'])->name('index');
                        Route::get('/create', [App\Http\Controllers\Admin\GabsiController::class, 'create'])->name('create');
                        Route::post('/', [App\Http\Controllers\Admin\GabsiController::class, 'store'])->name('store');
                        Route::get('/{gabsi}', [App\Http\Controllers\Admin\GabsiController::class, 'show'])->name('show');
                        Route::get('/{gabsi}/edit', [App\Http\Controllers\Admin\GabsiController::class, 'edit'])->name('edit');
                        Route::put('/{gabsi}', [App\Http\Controllers\Admin\GabsiController::class, 'update'])->name('update');
                        Route::delete('/{gabsi}', [App\Http\Controllers\Admin\GabsiController::class, 'destroy'])->name('destroy');
                    });
                    Route::prefix('pbsi')->name('pbsi.')->group(function () {
                        Route::get('/', [App\Http\Controllers\Admin\PbsiController::class, 'index'])->name('index');
                        Route::get('/create', [App\Http\Controllers\Admin\PbsiController::class, 'create'])->name('create');
                        Route::post('/', [App\Http\Controllers\Admin\PbsiController::class, 'store'])->name('store');
                        Route::get('/{pbsi}', [App\Http\Controllers\Admin\PbsiController::class, 'show'])->name('show');
                        Route::get('/{pbsi}/edit', [App\Http\Controllers\Admin\PbsiController::class, 'edit'])->name('edit');
                        Route::put('/{pbsi}', [App\Http\Controllers\Admin\PbsiController::class, 'update'])->name('update');
                        Route::delete('/{pbsi}', [App\Http\Controllers\Admin\PbsiController::class, 'destroy'])->name('destroy');
                    });
                    Route::prefix('pbvsi')->name('pbvsi.')->group(function () {
                        Route::get('/', [App\Http\Controllers\Admin\PbvsiController::class, 'index'])->name('index');
                        Route::get('/create', [App\Http\Controllers\Admin\PbvsiController::class, 'create'])->name('create');
                        Route::post('/', [App\Http\Controllers\Admin\PbvsiController::class, 'store'])->name('store');
                        Route::get('/{pbvsi}', [App\Http\Controllers\Admin\PbvsiController::class, 'show'])->name('show');
                        Route::get('/{pbvsi}/edit', [App\Http\Controllers\Admin\PbvsiController::class, 'edit'])->name('edit');
                        Route::put('/{pbvsi}', [App\Http\Controllers\Admin\PbvsiController::class, 'update'])->name('update');
                        Route::delete('/{pbvsi}', [App\Http\Controllers\Admin\PbvsiController::class, 'destroy'])->name('destroy');
                    });
                    Route::prefix('pdbi')->name('pdbi.')->group(function () {
                        Route::get('/', [App\Http\Controllers\Admin\PdbiController::class, 'index'])->name('index');
                        Route::get('/create', [App\Http\Controllers\Admin\PdbiController::class, 'create'])->name('create');
                        Route::post('/', [App\Http\Controllers\Admin\PdbiController::class, 'store'])->name('store');
                        Route::get('/{pdbi}', [App\Http\Controllers\Admin\PdbiController::class, 'show'])->name('show');
                        Route::get('/{pdbi}/edit', [App\Http\Controllers\Admin\PdbiController::class, 'edit'])->name('edit');
                        Route::put('/{pdbi}', [App\Http\Controllers\Admin\PdbiController::class, 'update'])->name('update');
                        Route::delete('/{pdbi}', [App\Http\Controllers\Admin\PdbiController::class, 'destroy'])->name('destroy');
                    });
                    Route::prefix('pelti')->name('pelti.')->group(function () {
                        Route::get('/', [App\Http\Controllers\Admin\PeltiController::class, 'index'])->name('index');
                        Route::get('/create', [App\Http\Controllers\Admin\PeltiController::class, 'create'])->name('create');
                        Route::post('/', [App\Http\Controllers\Admin\PeltiController::class, 'store'])->name('store');
                        Route::get('/{pelti}', [App\Http\Controllers\Admin\PeltiController::class, 'show'])->name('show');
                        Route::get('/{pelti}/edit', [App\Http\Controllers\Admin\PeltiController::class, 'edit'])->name('edit');
                        Route::put('/{pelti}', [App\Http\Controllers\Admin\PeltiController::class, 'update'])->name('update');
                        Route::delete('/{pelti}', [App\Http\Controllers\Admin\PeltiController::class, 'destroy'])->name('destroy');
                    });
                    Route::prefix('perbasi')->name('perbasi.')->group(function () {
                        Route::get('/', [App\Http\Controllers\Admin\PerbasiController::class, 'index'])->name('index');
                        Route::get('/create', [App\Http\Controllers\Admin\PerbasiController::class, 'create'])->name('create');
                        Route::post('/', [App\Http\Controllers\Admin\PerbasiController::class, 'store'])->name('store');
                        Route::get('/{perbasi}', [App\Http\Controllers\Admin\PerbasiController::class, 'show'])->name('show');
                        Route::get('/{perbasi}/edit', [App\Http\Controllers\Admin\PerbasiController::class, 'edit'])->name('edit');
                        Route::put('/{perbasi}', [App\Http\Controllers\Admin\PerbasiController::class, 'update'])->name('update');
                        Route::delete('/{perbasi}', [App\Http\Controllers\Admin\PerbasiController::class, 'destroy'])->name('destroy');
                    });
                    Route::prefix('percasi')->name('percasi.')->group(function () {
                        Route::get('/', [App\Http\Controllers\Admin\PercasiController::class, 'index'])->name('index');
                        Route::get('/create', [App\Http\Controllers\Admin\PercasiController::class, 'create'])->name('create');
                        Route::post('/', [App\Http\Controllers\Admin\PercasiController::class, 'store'])->name('store');
                        Route::get('/{percasi}', [App\Http\Controllers\Admin\PercasiController::class, 'show'])->name('show');
                        Route::get('/{percasi}/edit', [App\Http\Controllers\Admin\PercasiController::class, 'edit'])->name('edit');
                        Route::put('/{percasi}', [App\Http\Controllers\Admin\PercasiController::class, 'update'])->name('update');
                        Route::delete('/{percasi}', [App\Http\Controllers\Admin\PercasiController::class, 'destroy'])->name('destroy');
                    });
                    Route::prefix('pssi')->name('pssi.')->group(function () {
                        Route::get('/', [App\Http\Controllers\Admin\PssiController::class, 'index'])->name('index');
                        Route::get('/create', [App\Http\Controllers\Admin\PssiController::class, 'create'])->name('create');
                        Route::post('/', [App\Http\Controllers\Admin\PssiController::class, 'store'])->name('store');
                        Route::get('/{pssi}', [App\Http\Controllers\Admin\PssiController::class, 'show'])->name('show');
                        Route::get('/{pssi}/edit', [App\Http\Controllers\Admin\PssiController::class, 'edit'])->name('edit');
                        Route::put('/{pssi}', [App\Http\Controllers\Admin\PssiController::class, 'update'])->name('update');
                        Route::delete('/{pssi}', [App\Http\Controllers\Admin\PssiController::class, 'destroy'])->name('destroy');
                    });

                    Route::prefix('psti')->name('psti.')->group(function () {
                        Route::get('/', [App\Http\Controllers\Admin\PstiController::class, 'index'])->name('index');
                        Route::get('/create', [App\Http\Controllers\Admin\PstiController::class, 'create'])->name('create');
                        Route::post('/', [App\Http\Controllers\Admin\PstiController::class, 'store'])->name('store');
                        Route::get('/{psti}', [App\Http\Controllers\Admin\PstiController::class, 'show'])->name('show');
                        Route::get('/{psti}/edit', [App\Http\Controllers\Admin\PstiController::class, 'edit'])->name('edit');
                        Route::put('/{psti}', [App\Http\Controllers\Admin\PstiController::class, 'update'])->name('update');
                        Route::delete('/{psti}', [App\Http\Controllers\Admin\PstiController::class, 'destroy'])->name('destroy');
                    });

                    Route::prefix('ptmsi')->name('ptmsi.')->group(function () {
                        Route::get('/', [App\Http\Controllers\Admin\PtmsiController::class, 'index'])->name('index');
                        Route::get('/create', [App\Http\Controllers\Admin\PtmsiController::class, 'create'])->name('create');
                        Route::post('/', [App\Http\Controllers\Admin\PtmsiController::class, 'store'])->name('store');
                        Route::get('/{ptmsi}', [App\Http\Controllers\Admin\PtmsiController::class, 'show'])->name('show');
                        Route::get('/{ptmsi}/edit', [App\Http\Controllers\Admin\PtmsiController::class, 'edit'])->name('edit');
                        Route::put('/{ptmsi}', [App\Http\Controllers\Admin\PtmsiController::class, 'update'])->name('update');
                        Route::delete('/{ptmsi}', [App\Http\Controllers\Admin\PtmsiController::class, 'destroy'])->name('destroy');
                    });
                });

                Route::get('/cabor-beladiri', [App\Http\Controllers\Admin\BidangController::class, 'caborBeladiri'])->name('cabor-beladiri');
                Route::prefix('cabor-beladiri')->name('cabor-beladiri.')->group(function () {
                    Route::prefix('ferkushi')->name('ferkushi.')->group(function () {
                        Route::get('/', [App\Http\Controllers\Admin\FerkushiController::class, 'index'])->name('index');
                        Route::get('/create', [App\Http\Controllers\Admin\FerkushiController::class, 'create'])->name('create');
                        Route::post('/', [App\Http\Controllers\Admin\FerkushiController::class, 'store'])->name('store');
                        Route::get('/{ferkushi}', [App\Http\Controllers\Admin\FerkushiController::class, 'show'])->name('show');
                        Route::get('/{ferkushi}/edit', [App\Http\Controllers\Admin\FerkushiController::class, 'edit'])->name('edit');
                        Route::put('/{ferkushi}', [App\Http\Controllers\Admin\FerkushiController::class, 'update'])->name('update');
                        Route::delete('/{ferkushi}', [App\Http\Controllers\Admin\FerkushiController::class, 'destroy'])->name('destroy');
                    });

                    Route::prefix('forki')->name('forki.')->group(function () {
                        Route::get('/', [App\Http\Controllers\Admin\ForkiController::class, 'index'])->name('index');
                        Route::get('/create', [App\Http\Controllers\Admin\ForkiController::class, 'create'])->name('create');
                        Route::post('/', [App\Http\Controllers\Admin\ForkiController::class, 'store'])->name('store');
                        Route::get('/{forki}', [App\Http\Controllers\Admin\ForkiController::class, 'show'])->name('show');
                        Route::get('/{forki}/edit', [App\Http\Controllers\Admin\ForkiController::class, 'edit'])->name('edit');
                        Route::put('/{forki}', [App\Http\Controllers\Admin\ForkiController::class, 'update'])->name('update');
                        Route::delete('/{forki}', [App\Http\Controllers\Admin\ForkiController::class, 'destroy'])->name('destroy');
                    });

                    Route::prefix('ibca-mma')->name('ibca-mma.')->group(function () {
                        Route::get('/', [App\Http\Controllers\Admin\IbcaController::class, 'index'])->name('index');
                        Route::get('/create', [App\Http\Controllers\Admin\IbcaController::class, 'create'])->name('create');
                        Route::post('/', [App\Http\Controllers\Admin\IbcaController::class, 'store'])->name('store');
                        Route::get('/{ibca}', [App\Http\Controllers\Admin\IbcaController::class, 'show'])->name('show');
                        Route::get('/{ibca}/edit', [App\Http\Controllers\Admin\IbcaController::class, 'edit'])->name('edit');
                        Route::put('/{ibca}', [App\Http\Controllers\Admin\IbcaController::class, 'update'])->name('update');
                        Route::delete('/{ibca}', [App\Http\Controllers\Admin\IbcaController::class, 'destroy'])->name('destroy');
                    });

                    Route::prefix('ikasi')->name('ikasi.')->group(function () {
                        Route::get('/', [App\Http\Controllers\Admin\IkasiController::class, 'index'])->name('index');
                        Route::get('/create', [App\Http\Controllers\Admin\IkasiController::class, 'create'])->name('create');
                        Route::post('/', [App\Http\Controllers\Admin\IkasiController::class, 'store'])->name('store');
                        Route::get('/{ikasi}', [App\Http\Controllers\Admin\IkasiController::class, 'show'])->name('show');
                        Route::get('/{ikasi}/edit', [App\Http\Controllers\Admin\IkasiController::class, 'edit'])->name('edit');
                        Route::put('/{ikasi}', [App\Http\Controllers\Admin\IkasiController::class, 'update'])->name('update');
                        Route::delete('/{ikasi}', [App\Http\Controllers\Admin\IkasiController::class, 'destroy'])->name('destroy');
                    });

                    Route::prefix('ipsi')->name('ipsi.')->group(function () {
                        Route::get('/', [App\Http\Controllers\Admin\IpsiController::class, 'index'])->name('index');
                        Route::get('/create', [App\Http\Controllers\Admin\IpsiController::class, 'create'])->name('create');
                        Route::post('/', [App\Http\Controllers\Admin\IpsiController::class, 'store'])->name('store');
                        Route::get('/{ipsi}', [App\Http\Controllers\Admin\IpsiController::class, 'show'])->name('show');
                        Route::get('/{ipsi}/edit', [App\Http\Controllers\Admin\IpsiController::class, 'edit'])->name('edit');
                        Route::put('/{ipsi}', [App\Http\Controllers\Admin\IpsiController::class, 'update'])->name('update');
                        Route::delete('/{ipsi}', [App\Http\Controllers\Admin\IpsiController::class, 'destroy'])->name('destroy');
                    });

                    Route::prefix('kbi')->name('kbi.')->group(function () {
                        Route::get('/', [App\Http\Controllers\Admin\KbiController::class, 'index'])->name('index');
                        Route::get('/create', [App\Http\Controllers\Admin\KbiController::class, 'create'])->name('create');
                        Route::post('/', [App\Http\Controllers\Admin\KbiController::class, 'store'])->name('store');
                        Route::get('/{kbi}', [App\Http\Controllers\Admin\KbiController::class, 'show'])->name('show');
                        Route::get('/{kbi}/edit', [App\Http\Controllers\Admin\KbiController::class, 'edit'])->name('edit');
                        Route::put('/{kbi}', [App\Http\Controllers\Admin\KbiController::class, 'update'])->name('update');
                        Route::delete('/{kbi}', [App\Http\Controllers\Admin\KbiController::class, 'destroy'])->name('destroy');
                    });

                    Route::prefix('mi')->name('mi.')->group(function () {
                        Route::get('/', [App\Http\Controllers\Admin\MiController::class, 'index'])->name('index');
                        Route::get('/create', [App\Http\Controllers\Admin\MiController::class, 'create'])->name('create');
                        Route::post('/', [App\Http\Controllers\Admin\MiController::class, 'store'])->name('store');
                        Route::get('/{mi}', [App\Http\Controllers\Admin\MiController::class, 'show'])->name('show');
                        Route::get('/{mi}/edit', [App\Http\Controllers\Admin\MiController::class, 'edit'])->name('edit');
                        Route::put('/{mi}', [App\Http\Controllers\Admin\MiController::class, 'update'])->name('update');
                        Route::delete('/{mi}', [App\Http\Controllers\Admin\MiController::class, 'destroy'])->name('destroy');
                    });

                    Route::prefix('perkemi')->name('perkemi.')->group(function () {
                        Route::get('/', [App\Http\Controllers\Admin\PerkemiController::class, 'index'])->name('index');
                        Route::get('/create', [App\Http\Controllers\Admin\PerkemiController::class, 'create'])->name('create');
                        Route::post('/', [App\Http\Controllers\Admin\PerkemiController::class, 'store'])->name('store');
                        Route::get('/{perkemi}', [App\Http\Controllers\Admin\PerkemiController::class, 'show'])->name('show');
                        Route::get('/{perkemi}/edit', [App\Http\Controllers\Admin\PerkemiController::class, 'edit'])->name('edit');
                        Route::put('/{perkemi}', [App\Http\Controllers\Admin\PerkemiController::class, 'update'])->name('update');
                        Route::delete('/{perkemi}', [App\Http\Controllers\Admin\PerkemiController::class, 'destroy'])->name('destroy');
                    });

                    Route::prefix('persambi')->name('persambi.')->group(function () {
                        Route::get('/', [App\Http\Controllers\Admin\PersambiController::class, 'index'])->name('index');
                        Route::get('/create', [App\Http\Controllers\Admin\PersambiController::class, 'create'])->name('create');
                        Route::post('/', [App\Http\Controllers\Admin\PersambiController::class, 'store'])->name('store');
                        Route::get('/{persambi}', [App\Http\Controllers\Admin\PersambiController::class, 'show'])->name('show');
                        Route::get('/{persambi}/edit', [App\Http\Controllers\Admin\PersambiController::class, 'edit'])->name('edit');
                        Route::put('/{persambi}', [App\Http\Controllers\Admin\PersambiController::class, 'update'])->name('update');
                        Route::delete('/{persambi}', [App\Http\Controllers\Admin\PersambiController::class, 'destroy'])->name('destroy');
                    });

                    Route::prefix('pertina')->name('pertina.')->group(function () {
                        Route::get('/', [App\Http\Controllers\Admin\PertinaController::class, 'index'])->name('index');
                        Route::get('/create', [App\Http\Controllers\Admin\PertinaController::class, 'create'])->name('create');
                        Route::post('/', [App\Http\Controllers\Admin\PertinaController::class, 'store'])->name('store');
                        Route::get('/{pertina}', [App\Http\Controllers\Admin\PertinaController::class, 'show'])->name('show');
                        Route::get('/{pertina}/edit', [App\Http\Controllers\Admin\PertinaController::class, 'edit'])->name('edit');
                        Route::put('/{pertina}', [App\Http\Controllers\Admin\PertinaController::class, 'update'])->name('update');
                        Route::delete('/{pertina}', [App\Http\Controllers\Admin\PertinaController::class, 'destroy'])->name('destroy');
                    });

                    Route::prefix('pgsi')->name('pgsi.')->group(function () {
                        Route::get('/', [App\Http\Controllers\Admin\PgsiController::class, 'index'])->name('index');
                        Route::get('/create', [App\Http\Controllers\Admin\PgsiController::class, 'create'])->name('create');
                        Route::post('/', [App\Http\Controllers\Admin\PgsiController::class, 'store'])->name('store');
                        Route::get('/{pgsi}', [App\Http\Controllers\Admin\PgsiController::class, 'show'])->name('show');
                        Route::get('/{pgsi}/edit', [App\Http\Controllers\Admin\PgsiController::class, 'edit'])->name('edit');
                        Route::put('/{pgsi}', [App\Http\Controllers\Admin\PgsiController::class, 'update'])->name('update');
                        Route::delete('/{pgsi}', [App\Http\Controllers\Admin\PgsiController::class, 'destroy'])->name('destroy');
                    });

                    Route::prefix('pjsi')->name('pjsi.')->group(function () {
                        Route::get('/', [App\Http\Controllers\Admin\PjsiController::class, 'index'])->name('index');
                        Route::get('/create', [App\Http\Controllers\Admin\PjsiController::class, 'create'])->name('create');
                        Route::post('/', [App\Http\Controllers\Admin\PjsiController::class, 'store'])->name('store');
                        Route::get('/{pjsi}', [App\Http\Controllers\Admin\PjsiController::class, 'show'])->name('show');
                        Route::get('/{pjsi}/edit', [App\Http\Controllers\Admin\PjsiController::class, 'edit'])->name('edit');
                        Route::put('/{pjsi}', [App\Http\Controllers\Admin\PjsiController::class, 'update'])->name('update');
                        Route::delete('/{pjsi}', [App\Http\Controllers\Admin\PjsiController::class, 'destroy'])->name('destroy');
                    });

                    Route::prefix('ti')->name('ti.')->group(function () {
                        Route::get('/', [App\Http\Controllers\Admin\TiController::class, 'index'])->name('index');
                        Route::get('/create', [App\Http\Controllers\Admin\TiController::class, 'create'])->name('create');
                        Route::post('/', [App\Http\Controllers\Admin\TiController::class, 'store'])->name('store');
                        Route::get('/{ti}', [App\Http\Controllers\Admin\TiController::class, 'show'])->name('show');
                        Route::get('/{ti}/edit', [App\Http\Controllers\Admin\TiController::class, 'edit'])->name('edit');
                        Route::put('/{ti}', [App\Http\Controllers\Admin\TiController::class, 'update'])->name('update');
                        Route::delete('/{ti}', [App\Http\Controllers\Admin\TiController::class, 'destroy'])->name('destroy');
                    });
                });

                Route::get('/cabor-akurasi', [App\Http\Controllers\Admin\BidangController::class, 'caborAkurasi'])->name('cabor-akurasi');
                Route::prefix('cabor-akurasi')->name('cabor-akurasi.')->group(function () {
                    Route::prefix('esi')->name('esi.')->group(function () {
                        Route::get('/', [App\Http\Controllers\Admin\EsiController::class, 'index'])->name('index');
                        Route::get('/create', [App\Http\Controllers\Admin\EsiController::class, 'create'])->name('create');
                        Route::post('/', [App\Http\Controllers\Admin\EsiController::class, 'store'])->name('store');
                        Route::get('/{esi}', [App\Http\Controllers\Admin\EsiController::class, 'show'])->name('show');
                        Route::get('/{esi}/edit', [App\Http\Controllers\Admin\EsiController::class, 'edit'])->name('edit');
                        Route::put('/{esi}', [App\Http\Controllers\Admin\EsiController::class, 'update'])->name('update');
                        Route::delete('/{esi}', [App\Http\Controllers\Admin\EsiController::class, 'destroy'])->name('destroy');
                    });
                    Route::prefix('fasi')->name('fasi.')->group(function () {
                        Route::get('/', [App\Http\Controllers\Admin\FasiController::class, 'index'])->name('index');
                        Route::get('/create', [App\Http\Controllers\Admin\FasiController::class, 'create'])->name('create');
                        Route::post('/', [App\Http\Controllers\Admin\FasiController::class, 'store'])->name('store');
                        Route::get('/{fasi}', [App\Http\Controllers\Admin\FasiController::class, 'show'])->name('show');
                        Route::get('/{fasi}/edit', [App\Http\Controllers\Admin\FasiController::class, 'edit'])->name('edit');
                        Route::put('/{fasi}', [App\Http\Controllers\Admin\FasiController::class, 'update'])->name('update');
                        Route::delete('/{fasi}', [App\Http\Controllers\Admin\FasiController::class, 'destroy'])->name('destroy');
                    });
                    Route::prefix('fti')->name('fti.')->group(function () {
                        Route::get('/', [App\Http\Controllers\Admin\FtiController::class, 'index'])->name('index');
                        Route::get('/create', [App\Http\Controllers\Admin\FtiController::class, 'create'])->name('create');
                        Route::post('/', [App\Http\Controllers\Admin\FtiController::class, 'store'])->name('store');
                        Route::get('/{fti}', [App\Http\Controllers\Admin\FtiController::class, 'show'])->name('show');
                        Route::get('/{fti}/edit', [App\Http\Controllers\Admin\FtiController::class, 'edit'])->name('edit');
                        Route::put('/{fti}', [App\Http\Controllers\Admin\FtiController::class, 'update'])->name('update');
                        Route::delete('/{fti}', [App\Http\Controllers\Admin\FtiController::class, 'destroy'])->name('destroy');
                    });
                    Route::prefix('iodi')->name('iodi.')->group(function () {
                        Route::get('/', [App\Http\Controllers\Admin\IodiController::class, 'index'])->name('index');
                        Route::get('/create', [App\Http\Controllers\Admin\IodiController::class, 'create'])->name('create');
                        Route::post('/', [App\Http\Controllers\Admin\IodiController::class, 'store'])->name('store');
                        Route::get('/{iodi}', [App\Http\Controllers\Admin\IodiController::class, 'show'])->name('show');
                        Route::get('/{iodi}/edit', [App\Http\Controllers\Admin\IodiController::class, 'edit'])->name('edit');
                        Route::put('/{iodi}', [App\Http\Controllers\Admin\IodiController::class, 'update'])->name('update');
                        Route::delete('/{iodi}', [App\Http\Controllers\Admin\IodiController::class, 'destroy'])->name('destroy');
                    });
                    Route::prefix('pbfi')->name('pbfi.')->group(function () {
                        Route::get('/', [App\Http\Controllers\Admin\PbfiController::class, 'index'])->name('index');
                        Route::get('/create', [App\Http\Controllers\Admin\PbfiController::class, 'create'])->name('create');
                        Route::post('/', [App\Http\Controllers\Admin\PbfiController::class, 'store'])->name('store');
                        Route::get('/{pbfi}', [App\Http\Controllers\Admin\PbfiController::class, 'show'])->name('show');
                        Route::get('/{pbfi}/edit', [App\Http\Controllers\Admin\PbfiController::class, 'edit'])->name('edit');
                        Route::put('/{pbfi}', [App\Http\Controllers\Admin\PbfiController::class, 'update'])->name('update');
                        Route::delete('/{pbfi}', [App\Http\Controllers\Admin\PbfiController::class, 'destroy'])->name('destroy');
                    });
                    Route::prefix('perbaikin')->name('perbaikin.')->group(function () {
                        Route::get('/', [App\Http\Controllers\Admin\PerbaikinController::class, 'index'])->name('index');
                        Route::get('/create', [App\Http\Controllers\Admin\PerbaikinController::class, 'create'])->name('create');
                        Route::post('/', [App\Http\Controllers\Admin\PerbaikinController::class, 'store'])->name('store');
                        Route::get('/{perbaikin}', [App\Http\Controllers\Admin\PerbaikinController::class, 'show'])->name('show');
                        Route::get('/{perbaikin}/edit', [App\Http\Controllers\Admin\PerbaikinController::class, 'edit'])->name('edit');
                        Route::put('/{perbaikin}', [App\Http\Controllers\Admin\PerbaikinController::class, 'update'])->name('update');
                        Route::delete('/{perbaikin}', [App\Http\Controllers\Admin\PerbaikinController::class, 'destroy'])->name('destroy');
                    });
                    Route::prefix('perpani')->name('perpani.')->group(function () {
                        Route::get('/', [App\Http\Controllers\Admin\PerpaniController::class, 'index'])->name('index');
                        Route::get('/create', [App\Http\Controllers\Admin\PerpaniController::class, 'create'])->name('create');
                        Route::post('/', [App\Http\Controllers\Admin\PerpaniController::class, 'store'])->name('store');
                        Route::get('/{perpani}', [App\Http\Controllers\Admin\PerpaniController::class, 'show'])->name('show');
                        Route::get('/{perpani}/edit', [App\Http\Controllers\Admin\PerpaniController::class, 'edit'])->name('edit');
                        Route::put('/{perpani}', [App\Http\Controllers\Admin\PerpaniController::class, 'update'])->name('update');
                        Route::delete('/{perpani}', [App\Http\Controllers\Admin\PerpaniController::class, 'destroy'])->name('destroy');
                    });
                    Route::prefix('persani')->name('persani.')->group(function () {
                        Route::get('/', [App\Http\Controllers\Admin\PersaniController::class, 'index'])->name('index');
                        Route::get('/create', [App\Http\Controllers\Admin\PersaniController::class, 'create'])->name('create');
                        Route::post('/', [App\Http\Controllers\Admin\PersaniController::class, 'store'])->name('store');
                        Route::get('/{persani}', [App\Http\Controllers\Admin\PersaniController::class, 'show'])->name('show');
                        Route::get('/{persani}/edit', [App\Http\Controllers\Admin\PersaniController::class, 'edit'])->name('edit');
                        Route::put('/{persani}', [App\Http\Controllers\Admin\PersaniController::class, 'update'])->name('update');
                        Route::delete('/{persani}', [App\Http\Controllers\Admin\PersaniController::class, 'destroy'])->name('destroy');
                    });
                    Route::prefix('pgi')->name('pgi.')->group(function () {
                        Route::get('/', [App\Http\Controllers\Admin\PgiController::class, 'index'])->name('index');
                        Route::get('/create', [App\Http\Controllers\Admin\PgiController::class, 'create'])->name('create');
                        Route::post('/', [App\Http\Controllers\Admin\PgiController::class, 'store'])->name('store');
                        Route::get('/{pgi}', [App\Http\Controllers\Admin\PgiController::class, 'show'])->name('show');
                        Route::get('/{pgi}/edit', [App\Http\Controllers\Admin\PgiController::class, 'edit'])->name('edit');
                        Route::put('/{pgi}', [App\Http\Controllers\Admin\PgiController::class, 'update'])->name('update');
                        Route::delete('/{pgi}', [App\Http\Controllers\Admin\PgiController::class, 'destroy'])->name('destroy');
                    });
                    Route::prefix('pobsi')->name('pobsi.')->group(function () {
                        Route::get('/', [App\Http\Controllers\Admin\PobsiController::class, 'index'])->name('index');
                        Route::get('/create', [App\Http\Controllers\Admin\PobsiController::class, 'create'])->name('create');
                        Route::post('/', [App\Http\Controllers\Admin\PobsiController::class, 'store'])->name('store');
                        Route::get('/{pobsi}', [App\Http\Controllers\Admin\PobsiController::class, 'show'])->name('show');
                        Route::get('/{pobsi}/edit', [App\Http\Controllers\Admin\PobsiController::class, 'edit'])->name('edit');
                        Route::put('/{pobsi}', [App\Http\Controllers\Admin\PobsiController::class, 'update'])->name('update');
                        Route::delete('/{pobsi}', [App\Http\Controllers\Admin\PobsiController::class, 'destroy'])->name('destroy');
                    });
                    Route::prefix('pordasi')->name('pordasi.')->group(function () {
                        Route::get('/', [App\Http\Controllers\Admin\PordasiController::class, 'index'])->name('index');
                        Route::get('/create', [App\Http\Controllers\Admin\PordasiController::class, 'create'])->name('create');
                        Route::post('/', [App\Http\Controllers\Admin\PordasiController::class, 'store'])->name('store');
                        Route::get('/{pordasi}', [App\Http\Controllers\Admin\PordasiController::class, 'show'])->name('show');
                        Route::get('/{pordasi}/edit', [App\Http\Controllers\Admin\PordasiController::class, 'edit'])->name('edit');
                        Route::put('/{pordasi}', [App\Http\Controllers\Admin\PordasiController::class, 'update'])->name('update');
                        Route::delete('/{pordasi}', [App\Http\Controllers\Admin\PordasiController::class, 'destroy'])->name('destroy');
                    });
                });
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

            // Route untuk AJAX detail - HARUS sebelum {kegiatan_lainnya}
            Route::get('/{id}/detail-ajax', [KegiatanLainnyaController::class, 'getDetail'])
                ->name('detail-ajax')
                ->where('id', '[0-9]+');

            // Parameterized routes
            Route::get('/{kegiatan_lainnya}', [KegiatanLainnyaController::class, 'show'])->name('show');
            Route::get('/{kegiatan_lainnya}/edit', [KegiatanLainnyaController::class, 'edit'])->name('edit');
            Route::put('/{kegiatan_lainnya}', [KegiatanLainnyaController::class, 'update'])->name('update');
            Route::delete('/{kegiatan_lainnya}', [KegiatanLainnyaController::class, 'destroy'])->name('destroy');

            // Export route
            Route::get('/export', [KegiatanLainnyaController::class, 'export'])
                ->name('export');
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
