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
use App\Http\Controllers\Admin\FAJIController;
use App\Http\Controllers\Admin\FPTIController;
use App\Http\Controllers\Admin\IMIController;
use App\Http\Controllers\Admin\ISSIController;
use App\Http\Controllers\Admin\PABERSIController;
use App\Http\Controllers\Admin\PASIController;
use App\Http\Controllers\Admin\PORSEROSIController;
use App\Http\Controllers\Admin\POSISIController;
use App\Http\Controllers\Admin\ESIController;
use App\Http\Controllers\Admin\FASIController;
use App\Http\Controllers\Admin\FTIController;
use App\Http\Controllers\Admin\IODIController;
use App\Http\Controllers\Admin\PBFIController;
use App\Http\Controllers\Admin\PERBAIKINController;
use App\Http\Controllers\Admin\PERPANIController;
use App\Http\Controllers\Admin\PERSANIController;
use App\Http\Controllers\Admin\PGIController;
use App\Http\Controllers\Admin\POBSIController;
use App\Http\Controllers\Admin\PORDASIController;
use App\Http\Controllers\Admin\ABTIController;
use App\Http\Controllers\Admin\AFKABController;
use App\Http\Controllers\Admin\GABSIController;
use App\Http\Controllers\Admin\PBSIController;
use App\Http\Controllers\Admin\PBVSIController;
use App\Http\Controllers\Admin\PDBIController;
use App\Http\Controllers\Admin\PELTIController;
use App\Http\Controllers\Admin\PERBASIController;
use App\Http\Controllers\Admin\PERCASIController;
use App\Http\Controllers\Admin\PSSIController;
use App\Http\Controllers\Admin\PSTIController;
use App\Http\Controllers\Admin\PTMSIController;
use App\Http\Controllers\Admin\FERKUSHIController;
use App\Http\Controllers\Admin\FORKIController;
use App\Http\Controllers\Admin\IBCAController;
use App\Http\Controllers\Admin\IKASIController;
use App\Http\Controllers\Admin\IPSIController;
use App\Http\Controllers\Admin\KBIController;
use App\Http\Controllers\Admin\MIController;
use App\Http\Controllers\Admin\PERKEMIController;
use App\Http\Controllers\Admin\PERSAMBIController;
use App\Http\Controllers\Admin\PERTINAController;
use App\Http\Controllers\Admin\PGSIController;
use App\Http\Controllers\Admin\PJSIController;
use App\Http\Controllers\Admin\TIController;
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

                        Route::prefix('FAJI')->name('FAJI.')->group(function () {
                            Route::get('/', [App\Http\Controllers\Admin\FAJIController::class, 'index'])->name('index');
                            Route::get('/create', [App\Http\Controllers\Admin\FAJIController::class, 'create'])->name('create');
                            Route::post('/', [App\Http\Controllers\Admin\FAJIController::class, 'store'])->name('store');
                            Route::get('/{FAJI}', [App\Http\Controllers\Admin\FAJIController::class, 'show'])->name('show');
                            Route::get('/{FAJI}/edit', [App\Http\Controllers\Admin\FAJIController::class, 'edit'])->name('edit');
                            Route::put('/{FAJI}', [App\Http\Controllers\Admin\FAJIController::class, 'update'])->name('update');
                            Route::delete('/{FAJI}', [App\Http\Controllers\Admin\FAJIController::class, 'destroy'])->name('destroy');
                        });

                        Route::prefix('FPTI')->name('FPTI.')->group(function () {
                            Route::get('/', [App\Http\Controllers\Admin\FPTIController::class, 'index'])->name('index');
                            Route::get('/create', [App\Http\Controllers\Admin\FPTIController::class, 'create'])->name('create');
                            Route::post('/', [App\Http\Controllers\Admin\FPTIController::class, 'store'])->name('store');
                            Route::get('/{FPTI}', [App\Http\Controllers\Admin\FPTIController::class, 'show'])->name('show');
                            Route::get('/{FPTI}/edit', [App\Http\Controllers\Admin\FPTIController::class, 'edit'])->name('edit');
                            Route::put('/{FPTI}', [App\Http\Controllers\Admin\FPTIController::class, 'update'])->name('update');
                            Route::delete('/{FPTI}', [App\Http\Controllers\Admin\FPTIController::class, 'destroy'])->name('destroy');
                        });

                        Route::prefix('IMI')->name('IMI.')->group(function () {
                            Route::get('/', [App\Http\Controllers\Admin\IMIController::class, 'index'])->name('index');
                            Route::get('/create', [App\Http\Controllers\Admin\IMIController::class, 'create'])->name('create');
                            Route::post('/', [App\Http\Controllers\Admin\IMIController::class, 'store'])->name('store');
                            Route::get('/{IMI}', [App\Http\Controllers\Admin\IMIController::class, 'show'])->name('show');
                            Route::get('/{IMI}/edit', [App\Http\Controllers\Admin\IMIController::class, 'edit'])->name('edit');
                            Route::put('/{IMI}', [App\Http\Controllers\Admin\IMIController::class, 'update'])->name('update');
                            Route::delete('/{IMI}', [App\Http\Controllers\Admin\IMIController::class, 'destroy'])->name('destroy');
                        });

                        Route::prefix('ISSI')->name('ISSI.')->group(function () {
                            Route::get('/', [App\Http\Controllers\Admin\ISSIController::class, 'index'])->name('index');
                            Route::get('/create', [App\Http\Controllers\Admin\ISSIController::class, 'create'])->name('create');
                            Route::post('/', [App\Http\Controllers\Admin\ISSIController::class, 'store'])->name('store');
                            Route::get('/{ISSI}', [App\Http\Controllers\Admin\ISSIController::class, 'show'])->name('show');
                            Route::get('/{ISSI}/edit', [App\Http\Controllers\Admin\ISSIController::class, 'edit'])->name('edit');
                            Route::put('/{ISSI}', [App\Http\Controllers\Admin\ISSIController::class, 'update'])->name('update');
                            Route::delete('/{ISSI}', [App\Http\Controllers\Admin\ISSIController::class, 'destroy'])->name('destroy');
                        });

                        Route::prefix('PABERSI')->name('PABERSI.')->group(function () {
                            Route::get('/', [App\Http\Controllers\Admin\PABERSIController::class, 'index'])->name('index');
                            Route::get('/create', [App\Http\Controllers\Admin\PABERSIController::class, 'create'])->name('create');
                            Route::post('/', [App\Http\Controllers\Admin\PABERSIController::class, 'store'])->name('store');
                            Route::get('/{PABERSI}', [App\Http\Controllers\Admin\PABERSIController::class, 'show'])->name('show');
                            Route::get('/{PABERSI}/edit', [App\Http\Controllers\Admin\PABERSIController::class, 'edit'])->name('edit');
                            Route::put('/{PABERSI}', [App\Http\Controllers\Admin\PABERSIController::class, 'update'])->name('update');
                            Route::delete('/{PABERSI}', [App\Http\Controllers\Admin\PABERSIController::class, 'destroy'])->name('destroy');
                        });

                        Route::prefix('PARSI')->name('PARSI.')->group(function () {
                            Route::get('/', [App\Http\Controllers\Admin\PARSIController::class, 'index'])->name('index');
                            Route::get('/create', [App\Http\Controllers\Admin\PARSIController::class, 'create'])->name('create');
                            Route::post('/', [App\Http\Controllers\Admin\PARSIController::class, 'store'])->name('store');
                            Route::get('/{PARSI}', [App\Http\Controllers\Admin\PARSIController::class, 'show'])->name('show');
                            Route::get('/{PARSI}/edit', [App\Http\Controllers\Admin\PARSIController::class, 'edit'])->name('edit');
                            Route::put('/{PARSI}', [App\Http\Controllers\Admin\PARSIController::class, 'update'])->name('update');
                            Route::delete('/{PARSI}', [App\Http\Controllers\Admin\PARSIController::class, 'destroy'])->name('destroy');
                        });

                        Route::prefix('PASI')->name('PASI.')->group(function () {
                            Route::get('/', [App\Http\Controllers\Admin\PASIController::class, 'index'])->name('index');
                            Route::get('/create', [App\Http\Controllers\Admin\PASIController::class, 'create'])->name('create');
                            Route::post('/', [App\Http\Controllers\Admin\PASIController::class, 'store'])->name('store');
                            Route::get('/{PASI}', [App\Http\Controllers\Admin\PASIController::class, 'show'])->name('show');
                            Route::get('/{PASI}/edit', [App\Http\Controllers\Admin\PASIController::class, 'edit'])->name('edit');
                            Route::put('/{PASI}', [App\Http\Controllers\Admin\PASIController::class, 'update'])->name('update');
                            Route::delete('/{PASI}', [App\Http\Controllers\Admin\PASIController::class, 'destroy'])->name('destroy');
                        });

                        Route::prefix('PORSEROSI')->name('PORSEROSI.')->group(function () {
                            Route::get('/', [App\Http\Controllers\Admin\PORSEROSIController::class, 'index'])->name('index');
                            Route::get('/create', [App\Http\Controllers\Admin\PORSEROSIController::class, 'create'])->name('create');
                            Route::post('/', [App\Http\Controllers\Admin\PORSEROSIController::class, 'store'])->name('store');
                            Route::get('/{PORSEROSI}', [App\Http\Controllers\Admin\PORSEROSIController::class, 'show'])->name('show');
                            Route::get('/{PORSEROSI}/edit', [App\Http\Controllers\Admin\PORSEROSIController::class, 'edit'])->name('edit');
                            Route::put('/{PORSEROSI}', [App\Http\Controllers\Admin\PORSEROSIController::class, 'update'])->name('update');
                            Route::delete('/{PORSEROSI}', [App\Http\Controllers\Admin\PORSEROSIController::class, 'destroy'])->name('destroy');
                        });

                        Route::prefix('POSISI')->name('POSISI.')->group(function () {
                            Route::get('/', [App\Http\Controllers\Admin\POSISIController::class, 'index'])->name('index');
                            Route::get('/create', [App\Http\Controllers\Admin\POSISIController::class, 'create'])->name('create');
                            Route::post('/', [App\Http\Controllers\Admin\POSISIController::class, 'store'])->name('store');
                            Route::get('/{POSISI}', [App\Http\Controllers\Admin\POSISIController::class, 'show'])->name('show');
                            Route::get('/{POSISI}/edit', [App\Http\Controllers\Admin\POSISIController::class, 'edit'])->name('edit');
                            Route::put('/{POSISI}', [App\Http\Controllers\Admin\POSISIController::class, 'update'])->name('update');
                            Route::delete('/{POSISI}', [App\Http\Controllers\Admin\POSISIController::class, 'destroy'])->name('destroy');
                        });

                    });

                Route::get('/cabor-permainan', [App\Http\Controllers\Admin\BidangController::class, 'caborPermainan'])->name('cabor-permainan');
                    Route::prefix('cabor-permainan')->name('cabor-permainan.')->group(function () {
                        Route::prefix('ABTI')->name('ABTI.')->group(function () {
                            Route::get('/', [App\Http\Controllers\Admin\ABTIController::class, 'index'])->name('index');
                            Route::get('/create', [App\Http\Controllers\Admin\ABTIController::class, 'create'])->name('create');
                            Route::post('/', [App\Http\Controllers\Admin\ABTIController::class, 'store'])->name('store');
                            Route::get('/{ABTI}', [App\Http\Controllers\Admin\ABTIController::class, 'show'])->name('show');
                            Route::get('/{ABTI}/edit', [App\Http\Controllers\Admin\ABTIController::class, 'edit'])->name('edit');
                            Route::put('/{ABTI}', [App\Http\Controllers\Admin\ABTIController::class, 'update'])->name('update');
                            Route::delete('/{ABTI}', [App\Http\Controllers\Admin\ABTIController::class, 'destroy'])->name('destroy');
                        });
                        Route::prefix('AFKAB')->name('AFKAB.')->group(function () {
                            Route::get('/', [App\Http\Controllers\Admin\AFKABController::class, 'index'])->name('index');
                            Route::get('/create', [App\Http\Controllers\Admin\AFKABController::class, 'create'])->name('create');
                            Route::post('/', [App\Http\Controllers\Admin\AFKABController::class, 'store'])->name('store');
                            Route::get('/{AFKAB}', [App\Http\Controllers\Admin\AFKABController::class, 'show'])->name('show');
                            Route::get('/{AFKAB}/edit', [App\Http\Controllers\Admin\AFKABController::class, 'edit'])->name('edit');
                            Route::put('/{AFKAB}', [App\Http\Controllers\Admin\AFKABController::class, 'update'])->name('update');
                            Route::delete('/{AFKAB}', [App\Http\Controllers\Admin\AFKABController::class, 'destroy'])->name('destroy');
                        });
                        Route::prefix('GABSI')->name('GABSI.')->group(function () {
                            Route::get('/', [App\Http\Controllers\Admin\GABSIController::class, 'index'])->name('index');
                            Route::get('/create', [App\Http\Controllers\Admin\GABSIController::class, 'create'])->name('create');
                            Route::post('/', [App\Http\Controllers\Admin\GABSIController::class, 'store'])->name('store');
                            Route::get('/{GABSI}', [App\Http\Controllers\Admin\GABSIController::class, 'show'])->name('show');
                            Route::get('/{GABSI}/edit', [App\Http\Controllers\Admin\GABSIController::class, 'edit'])->name('edit');
                            Route::put('/{GABSI}', [App\Http\Controllers\Admin\GABSIController::class, 'update'])->name('update');
                            Route::delete('/{GABSI}', [App\Http\Controllers\Admin\GABSIController::class, 'destroy'])->name('destroy');
                        });
                        Route::prefix('PBSI')->name('PBSI.')->group(function () {
                            Route::get('/', [App\Http\Controllers\Admin\PBSIController::class, 'index'])->name('index');
                            Route::get('/create', [App\Http\Controllers\Admin\PBSIController::class, 'create'])->name('create');
                            Route::post('/', [App\Http\Controllers\Admin\PBSIController::class, 'store'])->name('store');
                            Route::get('/{PBSI}', [App\Http\Controllers\Admin\PBSIController::class, 'show'])->name('show');
                            Route::get('/{PBSI}/edit', [App\Http\Controllers\Admin\PBSIController::class, 'edit'])->name('edit');
                            Route::put('/{PBSI}', [App\Http\Controllers\Admin\PBSIController::class, 'update'])->name('update');
                            Route::delete('/{PBSI}', [App\Http\Controllers\Admin\PBSIController::class, 'destroy'])->name('destroy');
                        });
                        Route::prefix('PBVSI')->name('PBVSI.')->group(function () {
                            Route::get('/', [App\Http\Controllers\Admin\PBVSIController::class, 'index'])->name('index');
                            Route::get('/create', [App\Http\Controllers\Admin\PBVSIController::class, 'create'])->name('create');
                            Route::post('/', [App\Http\Controllers\Admin\PBVSIController::class, 'store'])->name('store');
                            Route::get('/{PBVSI}', [App\Http\Controllers\Admin\PBVSIController::class, 'show'])->name('show');
                            Route::get('/{PBVSI}/edit', [App\Http\Controllers\Admin\PBVSIController::class, 'edit'])->name('edit');
                            Route::put('/{PBVSI}', [App\Http\Controllers\Admin\PBVSIController::class, 'update'])->name('update');
                            Route::delete('/{PBVSI}', [App\Http\Controllers\Admin\PBVSIController::class, 'destroy'])->name('destroy');
                        });
                        Route::prefix('PDBI')->name('PDBI.')->group(function () {
                            Route::get('/', [App\Http\Controllers\Admin\PDBIController::class, 'index'])->name('index');
                            Route::get('/create', [App\Http\Controllers\Admin\PDBIController::class, 'create'])->name('create');
                            Route::post('/', [App\Http\Controllers\Admin\PDBIController::class, 'store'])->name('store');
                            Route::get('/{PDBI}', [App\Http\Controllers\Admin\PDBIController::class, 'show'])->name('show');
                            Route::get('/{PDBI}/edit', [App\Http\Controllers\Admin\PDBIController::class, 'edit'])->name('edit');
                            Route::put('/{PDBI}', [App\Http\Controllers\Admin\PDBIController::class, 'update'])->name('update');
                            Route::delete('/{PDBI}', [App\Http\Controllers\Admin\PDBIController::class, 'destroy'])->name('destroy');
                        });
                        Route::prefix('PELTI')->name('PELTI.')->group(function () {
                            Route::get('/', [App\Http\Controllers\Admin\PELTIController::class, 'index'])->name('index');
                            Route::get('/create', [App\Http\Controllers\Admin\PELTIController::class, 'create'])->name('create');
                            Route::post('/', [App\Http\Controllers\Admin\PELTIController::class, 'store'])->name('store');
                            Route::get('/{PELTI}', [App\Http\Controllers\Admin\PELTIController::class, 'show'])->name('show');
                            Route::get('/{PELTI}/edit', [App\Http\Controllers\Admin\PELTIController::class, 'edit'])->name('edit');
                            Route::put('/{PELTI}', [App\Http\Controllers\Admin\PELTIController::class, 'update'])->name('update');
                            Route::delete('/{PELTI}', [App\Http\Controllers\Admin\PELTIController::class, 'destroy'])->name('destroy');
                        });
                        Route::prefix('PERBASI')->name('PERBASI.')->group(function () {
                            Route::get('/', [App\Http\Controllers\Admin\PERBASIController::class, 'index'])->name('index');
                            Route::get('/create', [App\Http\Controllers\Admin\PERBASIController::class, 'create'])->name('create');
                            Route::post('/', [App\Http\Controllers\Admin\PERBASIController::class, 'store'])->name('store');
                            Route::get('/{PERBASI}', [App\Http\Controllers\Admin\PERBASIController::class, 'show'])->name('show');
                            Route::get('/{PERBASI}/edit', [App\Http\Controllers\Admin\PERBASIController::class, 'edit'])->name('edit');
                            Route::put('/{PERBASI}', [App\Http\Controllers\Admin\PERBASIController::class, 'update'])->name('update');
                            Route::delete('/{PERBASI}', [App\Http\Controllers\Admin\PERBASIController::class, 'destroy'])->name('destroy');
                        });
                        Route::prefix('PERCASI')->name('PERCASI.')->group(function () {
                            Route::get('/', [App\Http\Controllers\Admin\PERCASIController::class, 'index'])->name('index');
                            Route::get('/create', [App\Http\Controllers\Admin\PERCASIController::class, 'create'])->name('create');
                            Route::post('/', [App\Http\Controllers\Admin\PERCASIController::class, 'store'])->name('store');
                            Route::get('/{PERCASI}', [App\Http\Controllers\Admin\PERCASIController::class, 'show'])->name('show');
                            Route::get('/{PERCASI}/edit', [App\Http\Controllers\Admin\PERCASIController::class, 'edit'])->name('edit');
                            Route::put('/{PERCASI}', [App\Http\Controllers\Admin\PERCASIController::class, 'update'])->name('update');
                            Route::delete('/{PERCASI}', [App\Http\Controllers\Admin\PERCASIController::class, 'destroy'])->name('destroy');
                        });
                        Route::prefix('PSSI')->name('PSSI.')->group(function () {
                            Route::get('/', [App\Http\Controllers\Admin\PSSIController::class, 'index'])->name('index');
                            Route::get('/create', [App\Http\Controllers\Admin\PSSIController::class, 'create'])->name('create');
                            Route::post('/', [App\Http\Controllers\Admin\PSSIController::class, 'store'])->name('store');
                            Route::get('/{PSSI}', [App\Http\Controllers\Admin\PSSIController::class, 'show'])->name('show');
                            Route::get('/{PSSI}/edit', [App\Http\Controllers\Admin\PSSIController::class, 'edit'])->name('edit');
                            Route::put('/{PSSI}', [App\Http\Controllers\Admin\PSSIController::class, 'update'])->name('update');
                            Route::delete('/{PSSI}', [App\Http\Controllers\Admin\PSSIController::class, 'destroy'])->name('destroy');
                        });

                        Route::prefix('PSTI')->name('PSTI.')->group(function () {
                            Route::get('/', [App\Http\Controllers\Admin\PSTIController::class, 'index'])->name('index');
                            Route::get('/create', [App\Http\Controllers\Admin\PSTIController::class, 'create'])->name('create');
                            Route::post('/', [App\Http\Controllers\Admin\PSTIController::class, 'store'])->name('store');
                            Route::get('/{PSTI}', [App\Http\Controllers\Admin\PSTIController::class, 'show'])->name('show');
                            Route::get('/{PSTI}/edit', [App\Http\Controllers\Admin\PSTIController::class, 'edit'])->name('edit');
                            Route::put('/{PSTI}', [App\Http\Controllers\Admin\PSTIController::class, 'update'])->name('update');
                            Route::delete('/{PSTI}', [App\Http\Controllers\Admin\PSTIController::class, 'destroy'])->name('destroy');
                        });

                        Route::prefix('PTMSI')->name('PTMSI.')->group(function () {
                            Route::get('/', [App\Http\Controllers\Admin\PTMSIController::class, 'index'])->name('index');
                            Route::get('/create', [App\Http\Controllers\Admin\PTMSIController::class, 'create'])->name('create');
                            Route::post('/', [App\Http\Controllers\Admin\PTMSIController::class, 'store'])->name('store');
                            Route::get('/{PTMSI}', [App\Http\Controllers\Admin\PTMSIController::class, 'show'])->name('show');
                            Route::get('/{PTMSI}/edit', [App\Http\Controllers\Admin\PTMSIController::class, 'edit'])->name('edit');
                            Route::put('/{PTMSI}', [App\Http\Controllers\Admin\PTMSIController::class, 'update'])->name('update');
                            Route::delete('/{PTMSI}', [App\Http\Controllers\Admin\PTMSIController::class, 'destroy'])->name('destroy');
                        });
                    });

                Route::get('/cabor-beladiri', [App\Http\Controllers\Admin\BidangController::class, 'caborBeladiri'])->name('cabor-beladiri');
                    Route::prefix('cabor-beladiri')->name('cabor-beladiri.')->group(function () {
                        Route::prefix('FERKUSHI')->name('FERKUSHI.')->group(function () {
                            Route::get('/', [App\Http\Controllers\Admin\FERKUSHIController::class, 'index'])->name('index');
                            Route::get('/create', [App\Http\Controllers\Admin\FERKUSHIController::class, 'create'])->name('create');
                            Route::post('/', [App\Http\Controllers\Admin\FERKUSHIController::class, 'store'])->name('store');
                            Route::get('/{FERKUSHI}', [App\Http\Controllers\Admin\FERKUSHIController::class, 'show'])->name('show');
                            Route::get('/{FERKUSHI}/edit', [App\Http\Controllers\Admin\FERKUSHIController::class, 'edit'])->name('edit');
                            Route::put('/{FERKUSHI}', [App\Http\Controllers\Admin\FERKUSHIController::class, 'update'])->name('update');
                            Route::delete('/{FERKUSHI}', [App\Http\Controllers\Admin\FERKUSHIController::class, 'destroy'])->name('destroy');
                        });

                        Route::prefix('FORKI')->name('FORKI.')->group(function () {
                            Route::get('/', [App\Http\Controllers\Admin\FORKIController::class, 'index'])->name('index');
                            Route::get('/create', [App\Http\Controllers\Admin\FORKIController::class, 'create'])->name('create');
                            Route::post('/', [App\Http\Controllers\Admin\FORKIController::class, 'store'])->name('store');
                            Route::get('/{FORKI}', [App\Http\Controllers\Admin\FORKIController::class, 'show'])->name('show');
                            Route::get('/{FORKI}/edit', [App\Http\Controllers\Admin\FORKIController::class, 'edit'])->name('edit');
                            Route::put('/{FORKI}', [App\Http\Controllers\Admin\FORKIController::class, 'update'])->name('update');
                            Route::delete('/{FORKI}', [App\Http\Controllers\Admin\FORKIController::class, 'destroy'])->name('destroy');
                        });

                        Route::prefix('IBCA-MMA')->name('IBCA-MMA.')->group(function () {
                            Route::get('/', [App\Http\Controllers\Admin\IBCAController::class, 'index'])->name('index');
                            Route::get('/create', [App\Http\Controllers\Admin\IBCAController::class, 'create'])->name('create');
                            Route::post('/', [App\Http\Controllers\Admin\IBCAController::class, 'store'])->name('store');
                            Route::get('/{IBCA}', [App\Http\Controllers\Admin\IBCAController::class, 'show'])->name('show');
                            Route::get('/{IBCA}/edit', [App\Http\Controllers\Admin\IBCAController::class, 'edit'])->name('edit');
                            Route::put('/{IBCA}', [App\Http\Controllers\Admin\IBCAController::class, 'update'])->name('update');
                            Route::delete('/{IBCA}', [App\Http\Controllers\Admin\IBCAController::class, 'destroy'])->name('destroy');
                        });

                        Route::prefix('IKASI')->name('IKASI.')->group(function () {
                            Route::get('/', [App\Http\Controllers\Admin\IKASIController::class, 'index'])->name('index');
                            Route::get('/create', [App\Http\Controllers\Admin\IKASIController::class, 'create'])->name('create');
                            Route::post('/', [App\Http\Controllers\Admin\IKASIController::class, 'store'])->name('store');
                            Route::get('/{IKASI}', [App\Http\Controllers\Admin\IKASIController::class, 'show'])->name('show');
                            Route::get('/{IKASI}/edit', [App\Http\Controllers\Admin\IKASIController::class, 'edit'])->name('edit');
                            Route::put('/{IKASI}', [App\Http\Controllers\Admin\IKASIController::class, 'update'])->name('update');
                            Route::delete('/{IKASI}', [App\Http\Controllers\Admin\IKASIController::class, 'destroy'])->name('destroy');
                        });

                        Route::prefix('IPSI')->name('IPSI.')->group(function () {
                            Route::get('/', [App\Http\Controllers\Admin\IPSIController::class, 'index'])->name('index');
                            Route::get('/create', [App\Http\Controllers\Admin\IPSIController::class, 'create'])->name('create');
                            Route::post('/', [App\Http\Controllers\Admin\IPSIController::class, 'store'])->name('store');
                            Route::get('/{IPSI}', [App\Http\Controllers\Admin\IPSIController::class, 'show'])->name('show');
                            Route::get('/{IPSI}/edit', [App\Http\Controllers\Admin\IPSIController::class, 'edit'])->name('edit');
                            Route::put('/{IPSI}', [App\Http\Controllers\Admin\IPSIController::class, 'update'])->name('update');
                            Route::delete('/{IPSI}', [App\Http\Controllers\Admin\IPSIController::class, 'destroy'])->name('destroy');
                        });

                        Route::prefix('KBI')->name('KBI.')->group(function () {
                            Route::get('/', [App\Http\Controllers\Admin\KBIController::class, 'index'])->name('index');
                            Route::get('/create', [App\Http\Controllers\Admin\KBIController::class, 'create'])->name('create');
                            Route::post('/', [App\Http\Controllers\Admin\KBIController::class, 'store'])->name('store');
                            Route::get('/{KBI}', [App\Http\Controllers\Admin\KBIController::class, 'show'])->name('show');
                            Route::get('/{KBI}/edit', [App\Http\Controllers\Admin\KBIController::class, 'edit'])->name('edit');
                            Route::put('/{KBI}', [App\Http\Controllers\Admin\KBIController::class, 'update'])->name('update');
                            Route::delete('/{KBI}', [App\Http\Controllers\Admin\KBIController::class, 'destroy'])->name('destroy');
                        });

                        Route::prefix('MI')->name('MI.')->group(function () {
                            Route::get('/', [App\Http\Controllers\Admin\MIController::class, 'index'])->name('index');
                            Route::get('/create', [App\Http\Controllers\Admin\MIController::class, 'create'])->name('create');
                            Route::post('/', [App\Http\Controllers\Admin\MIController::class, 'store'])->name('store');
                            Route::get('/{MI}', [App\Http\Controllers\Admin\MIController::class, 'show'])->name('show');
                            Route::get('/{MI}/edit', [App\Http\Controllers\Admin\MIController::class, 'edit'])->name('edit');
                            Route::put('/{MI}', [App\Http\Controllers\Admin\MIController::class, 'update'])->name('update');
                            Route::delete('/{MI}', [App\Http\Controllers\Admin\MIController::class, 'destroy'])->name('destroy');
                        });

                        Route::prefix('PERKEMI')->name('PERKEMI.')->group(function () {
                            Route::get('/', [App\Http\Controllers\Admin\PERKEMIController::class, 'index'])->name('index');
                            Route::get('/create', [App\Http\Controllers\Admin\PERKEMIController::class, 'create'])->name('create');
                            Route::post('/', [App\Http\Controllers\Admin\PERKEMIController::class, 'store'])->name('store');
                            Route::get('/{PERKEMI}', [App\Http\Controllers\Admin\PERKEMIController::class, 'show'])->name('show');
                            Route::get('/{PERKEMI}/edit', [App\Http\Controllers\Admin\PERKEMIController::class, 'edit'])->name('edit');
                            Route::put('/{PERKEMI}', [App\Http\Controllers\Admin\PERKEMIController::class, 'update'])->name('update');
                            Route::delete('/{PERKEMI}', [App\Http\Controllers\Admin\PERKEMIController::class, 'destroy'])->name('destroy');
                        });

                        Route::prefix('PERSAMBI')->name('PERSAMBI.')->group(function () {
                            Route::get('/', [App\Http\Controllers\Admin\PERSAMBIController::class, 'index'])->name('index');
                            Route::get('/create', [App\Http\Controllers\Admin\PERSAMBIController::class, 'create'])->name('create');
                            Route::post('/', [App\Http\Controllers\Admin\PERSAMBIController::class, 'store'])->name('store');
                            Route::get('/{PERSAMBI}', [App\Http\Controllers\Admin\PERSAMBIController::class, 'show'])->name('show');
                            Route::get('/{PERSAMBI}/edit', [App\Http\Controllers\Admin\PERSAMBIController::class, 'edit'])->name('edit');
                            Route::put('/{PERSAMBI}', [App\Http\Controllers\Admin\PERSAMBIController::class, 'update'])->name('update');
                            Route::delete('/{PERSAMBI}', [App\Http\Controllers\Admin\PERSAMBIController::class, 'destroy'])->name('destroy');
                        });

                        Route::prefix('PERTINA')->name('PERTINA.')->group(function () {
                            Route::get('/', [App\Http\Controllers\Admin\PERTINAController::class, 'index'])->name('index');
                            Route::get('/create', [App\Http\Controllers\Admin\PERTINAController::class, 'create'])->name('create');
                            Route::post('/', [App\Http\Controllers\Admin\PERTINAController::class, 'store'])->name('store');
                            Route::get('/{PERTINA}', [App\Http\Controllers\Admin\PERTINAController::class, 'show'])->name('show');
                            Route::get('/{PERTINA}/edit', [App\Http\Controllers\Admin\PERTINAController::class, 'edit'])->name('edit');
                            Route::put('/{PERTINA}', [App\Http\Controllers\Admin\PERTINAController::class, 'update'])->name('update');
                            Route::delete('/{PERTINA}', [App\Http\Controllers\Admin\PERTINAController::class, 'destroy'])->name('destroy');
                        });

                        Route::prefix('PGSI')->name('PGSI.')->group(function () {
                            Route::get('/', [App\Http\Controllers\Admin\PGSIController::class, 'index'])->name('index');
                            Route::get('/create', [App\Http\Controllers\Admin\PGSIController::class, 'create'])->name('create');
                            Route::post('/', [App\Http\Controllers\Admin\PGSIController::class, 'store'])->name('store');
                            Route::get('/{PGSI}', [App\Http\Controllers\Admin\PGSIController::class, 'show'])->name('show');
                            Route::get('/{PGSI}/edit', [App\Http\Controllers\Admin\PGSIController::class, 'edit'])->name('edit');
                            Route::put('/{PGSI}', [App\Http\Controllers\Admin\PGSIController::class, 'update'])->name('update');
                            Route::delete('/{PGSI}', [App\Http\Controllers\Admin\PGSIController::class, 'destroy'])->name('destroy');
                        });

                        Route::prefix('PJSI')->name('PJSI.')->group(function () {
                            Route::get('/', [App\Http\Controllers\Admin\PJSIController::class, 'index'])->name('index');
                            Route::get('/create', [App\Http\Controllers\Admin\PJSIController::class, 'create'])->name('create');
                            Route::post('/', [App\Http\Controllers\Admin\PJSIController::class, 'store'])->name('store');
                            Route::get('/{PJSI}', [App\Http\Controllers\Admin\PJSIController::class, 'show'])->name('show');
                            Route::get('/{PJSI}/edit', [App\Http\Controllers\Admin\PJSIController::class, 'edit'])->name('edit');
                            Route::put('/{PJSI}', [App\Http\Controllers\Admin\PJSIController::class, 'update'])->name('update');
                            Route::delete('/{PJSI}', [App\Http\Controllers\Admin\PJSIController::class, 'destroy'])->name('destroy');
                        });

                        Route::prefix('TI')->name('TI.')->group(function () {
                            Route::get('/', [App\Http\Controllers\Admin\TIController::class, 'index'])->name('index');
                            Route::get('/create', [App\Http\Controllers\Admin\TIController::class, 'create'])->name('create');
                            Route::post('/', [App\Http\Controllers\Admin\TIController::class, 'store'])->name('store');
                            Route::get('/{TI}', [App\Http\Controllers\Admin\TIController::class, 'show'])->name('show');
                            Route::get('/{TI}/edit', [App\Http\Controllers\Admin\TIController::class, 'edit'])->name('edit');
                            Route::put('/{TI}', [App\Http\Controllers\Admin\TIController::class, 'update'])->name('update');
                            Route::delete('/{TI}', [App\Http\Controllers\Admin\TIController::class, 'destroy'])->name('destroy');
                        });
                    });

                Route::get('/cabor-akurasi', [App\Http\Controllers\Admin\BidangController::class, 'caborAkurasi'])->name('cabor-akurasi');
                    Route::prefix('cabor-akurasi')->name('cabor-akurasi.')->group(function () {
                        Route::prefix('ESI')->name('ESI.')->group(function () {
                            Route::get('/', [App\Http\Controllers\Admin\ESIController::class, 'index'])->name('index');
                            Route::get('/create', [App\Http\Controllers\Admin\ESIController::class, 'create'])->name('create');
                            Route::post('/', [App\Http\Controllers\Admin\ESIController::class, 'store'])->name('store');
                            Route::get('/{ESI}', [App\Http\Controllers\Admin\ESIController::class, 'show'])->name('show');
                            Route::get('/{ESI}/edit', [App\Http\Controllers\Admin\ESIController::class, 'edit'])->name('edit');
                            Route::put('/{ESI}', [App\Http\Controllers\Admin\ESIController::class, 'update'])->name('update');
                            Route::delete('/{ESI}', [App\Http\Controllers\Admin\ESIController::class, 'destroy'])->name('destroy');
                        });
                        Route::prefix('FASI')->name('FASI.')->group(function () {
                            Route::get('/', [App\Http\Controllers\Admin\FASIController::class, 'index'])->name('index');
                            Route::get('/create', [App\Http\Controllers\Admin\FASIController::class, 'create'])->name('create');
                            Route::post('/', [App\Http\Controllers\Admin\FASIController::class, 'store'])->name('store');
                            Route::get('/{FASI}', [App\Http\Controllers\Admin\FASIController::class, 'show'])->name('show');
                            Route::get('/{FASI}/edit', [App\Http\Controllers\Admin\FASIController::class, 'edit'])->name('edit');
                            Route::put('/{FASI}', [App\Http\Controllers\Admin\FASIController::class, 'update'])->name('update');
                            Route::delete('/{FASI}', [App\Http\Controllers\Admin\FASIController::class, 'destroy'])->name('destroy');
                        });
                        Route::prefix('FTI')->name('FTI.')->group(function () {
                            Route::get('/', [App\Http\Controllers\Admin\FTIController::class, 'index'])->name('index');
                            Route::get('/create', [App\Http\Controllers\Admin\FTIController::class, 'create'])->name('create');
                            Route::post('/', [App\Http\Controllers\Admin\FTIController::class, 'store'])->name('store');
                            Route::get('/{FTI}', [App\Http\Controllers\Admin\FTIController::class, 'show'])->name('show');
                            Route::get('/{FTI}/edit', [App\Http\Controllers\Admin\FTIController::class, 'edit'])->name('edit');
                            Route::put('/{FTI}', [App\Http\Controllers\Admin\FTIController::class, 'update'])->name('update');
                            Route::delete('/{FTI}', [App\Http\Controllers\Admin\FTIController::class, 'destroy'])->name('destroy');
                        });
                        Route::prefix('IODI')->name('IODI.')->group(function () {
                            Route::get('/', [App\Http\Controllers\Admin\IODIController::class, 'index'])->name('index');
                            Route::get('/create', [App\Http\Controllers\Admin\IODIController::class, 'create'])->name('create');
                            Route::post('/', [App\Http\Controllers\Admin\IODIController::class, 'store'])->name('store');
                            Route::get('/{IODI}', [App\Http\Controllers\Admin\IODIController::class, 'show'])->name('show');
                            Route::get('/{IODI}/edit', [App\Http\Controllers\Admin\IODIController::class, 'edit'])->name('edit');
                            Route::put('/{IODI}', [App\Http\Controllers\Admin\IODIController::class, 'update'])->name('update');
                            Route::delete('/{IODI}', [App\Http\Controllers\Admin\IODIController::class, 'destroy'])->name('destroy');
                        });
                        Route::prefix('PBFI')->name('PBFI.')->group(function () {
                            Route::get('/', [App\Http\Controllers\Admin\PBFIController::class, 'index'])->name('index');
                            Route::get('/create', [App\Http\Controllers\Admin\PBFIController::class, 'create'])->name('create');
                            Route::post('/', [App\Http\Controllers\Admin\PBFIController::class, 'store'])->name('store');
                            Route::get('/{PBFI}', [App\Http\Controllers\Admin\PBFIController::class, 'show'])->name('show');
                            Route::get('/{PBFI}/edit', [App\Http\Controllers\Admin\PBFIController::class, 'edit'])->name('edit');
                            Route::put('/{PBFI}', [App\Http\Controllers\Admin\PBFIController::class, 'update'])->name('update');
                            Route::delete('/{PBFI}', [App\Http\Controllers\Admin\PBFIController::class, 'destroy'])->name('destroy');
                        });
                        Route::prefix('PERBAIKIN')->name('PERBAIKIN.')->group(function () {
                            Route::get('/', [App\Http\Controllers\Admin\PERBAIKINController::class, 'index'])->name('index');
                            Route::get('/create', [App\Http\Controllers\Admin\PERBAIKINController::class, 'create'])->name('create');
                            Route::post('/', [App\Http\Controllers\Admin\PERBAIKINController::class, 'store'])->name('store');
                            Route::get('/{PERBAIKIN}', [App\Http\Controllers\Admin\PERBAIKINController::class, 'show'])->name('show');
                            Route::get('/{PERBAIKIN}/edit', [App\Http\Controllers\Admin\PERBAIKINController::class, 'edit'])->name('edit');
                            Route::put('/{PERBAIKIN}', [App\Http\Controllers\Admin\PERBAIKINController::class, 'update'])->name('update');
                            Route::delete('/{PERBAIKIN}', [App\Http\Controllers\Admin\PERBAIKINController::class, 'destroy'])->name('destroy');
                        });
                        Route::prefix('PERPANI')->name('PERPANI.')->group(function () {
                            Route::get('/', [App\Http\Controllers\Admin\PERPANIController::class, 'index'])->name('index');
                            Route::get('/create', [App\Http\Controllers\Admin\PERPANIController::class, 'create'])->name('create');
                            Route::post('/', [App\Http\Controllers\Admin\PERPANIController::class, 'store'])->name('store');
                            Route::get('/{PERPANI}', [App\Http\Controllers\Admin\PERPANIController::class, 'show'])->name('show');
                            Route::get('/{PERPANI}/edit', [App\Http\Controllers\Admin\PERPANIController::class, 'edit'])->name('edit');
                            Route::put('/{PERPANI}', [App\Http\Controllers\Admin\PERPANIController::class, 'update'])->name('update');
                            Route::delete('/{PERPANI}', [App\Http\Controllers\Admin\PERPANIController::class, 'destroy'])->name('destroy');
                        });
                        Route::prefix('PERSANI')->name('PERSANI.')->group(function () {
                            Route::get('/', [App\Http\Controllers\Admin\PERSANIController::class, 'index'])->name('index');
                            Route::get('/create', [App\Http\Controllers\Admin\PERSANIController::class, 'create'])->name('create');
                            Route::post('/', [App\Http\Controllers\Admin\PERSANIController::class, 'store'])->name('store');
                            Route::get('/{PERSANI}', [App\Http\Controllers\Admin\PERSANIController::class, 'show'])->name('show');
                            Route::get('/{PERSANI}/edit', [App\Http\Controllers\Admin\PERSANIController::class, 'edit'])->name('edit');
                            Route::put('/{PERSANI}', [App\Http\Controllers\Admin\PERSANIController::class, 'update'])->name('update');
                            Route::delete('/{PERSANI}', [App\Http\Controllers\Admin\PERSANIController::class, 'destroy'])->name('destroy');
                        });
                        Route::prefix('PGI')->name('PGI.')->group(function () {
                            Route::get('/', [App\Http\Controllers\Admin\PGIController::class, 'index'])->name('index');
                            Route::get('/create', [App\Http\Controllers\Admin\PGIController::class, 'create'])->name('create');
                            Route::post('/', [App\Http\Controllers\Admin\PGIController::class, 'store'])->name('store');
                            Route::get('/{PGI}', [App\Http\Controllers\Admin\PGIController::class, 'show'])->name('show');
                            Route::get('/{PGI}/edit', [App\Http\Controllers\Admin\PGIController::class, 'edit'])->name('edit');
                            Route::put('/{PGI}', [App\Http\Controllers\Admin\PGIController::class, 'update'])->name('update');
                            Route::delete('/{PGI}', [App\Http\Controllers\Admin\PGIController::class, 'destroy'])->name('destroy');
                        });
                        Route::prefix('POBSI')->name('POBSI.')->group(function () {
                            Route::get('/', [App\Http\Controllers\Admin\POBSIController::class, 'index'])->name('index');
                            Route::get('/create', [App\Http\Controllers\Admin\POBSIController::class, 'create'])->name('create');
                            Route::post('/', [App\Http\Controllers\Admin\POBSIController::class, 'store'])->name('store');
                            Route::get('/{POBSI}', [App\Http\Controllers\Admin\POBSIController::class, 'show'])->name('show');
                            Route::get('/{POBSI}/edit', [App\Http\Controllers\Admin\POBSIController::class, 'edit'])->name('edit');
                            Route::put('/{POBSI}', [App\Http\Controllers\Admin\POBSIController::class, 'update'])->name('update');
                            Route::delete('/{POBSI}', [App\Http\Controllers\Admin\POBSIController::class, 'destroy'])->name('destroy');
                        });
                        Route::prefix('PORDASI')->name('PORDASI.')->group(function () {
                            Route::get('/', [App\Http\Controllers\Admin\PORDASIController::class, 'index'])->name('index');
                            Route::get('/create', [App\Http\Controllers\Admin\PORDASIController::class, 'create'])->name('create');
                            Route::post('/', [App\Http\Controllers\Admin\PORDASIController::class, 'store'])->name('store');
                            Route::get('/{PORDASI}', [App\Http\Controllers\Admin\PORDASIController::class, 'show'])->name('show');
                            Route::get('/{PORDASI}/edit', [App\Http\Controllers\Admin\PORDASIController::class, 'edit'])->name('edit');
                            Route::put('/{PORDASI}', [App\Http\Controllers\Admin\PORDASIController::class, 'update'])->name('update');
                            Route::delete('/{PORDASI}', [App\Http\Controllers\Admin\PORDASIController::class, 'destroy'])->name('destroy');
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
