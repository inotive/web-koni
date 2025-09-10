<?php
    use App\Models\Pengajuan;
    $pengajuanCount = Pengajuan::where('status', 'menunggu persetujuan')->count();
?>

<div id="kt_aside" class="aside" data-kt-drawer="true" data-kt-drawer-name="aside"
    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true"
    data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start"
    data-kt-drawer-toggle="#kt_aside_mobile_toggle" style="box-shadow: 4px 0 6px -4px rgba(0, 0, 0, 0.1);">

    <!--begin::Aside Toolbar-->
    <div class="aside-toolbar flex-column-auto" id="kt_aside_toolbar"></div>
    <!--end::Aside Toolbar-->

    <!--begin::Aside menu-->
    <div class="bg-white aside-menu flex-column-fluid">
        <div class="mx-5 my-5 hover-scroll-overlay-y my-lg-5" id="kt_aside_menu_wrapper" data-kt-scroll="true"
            data-kt-scroll-height="auto"
            data-kt-scroll-dependencies="{default: '#kt_aside_toolbar, #kt_aside_footer', lg: '#kt_header, #kt_aside_toolbar, #kt_aside_footer'}"
            data-kt-scroll-wrappers="#kt_aside_menu" data-kt-scroll-offset="5px">

            <!--begin::Menu-->
            <div class="menu-column menu-title-gray-800" id="kt_aside_menu" data-kt-menu="true">

                <!-- Menu Utama Section -->
                <?php if(auth()->user()->can('dashboard') ||
                        auth()->user()->can('manajemen-rka') ||
                        auth()->user()->can('laporan-lpj') ||
                        auth()->user()->can('database-bendahara') ||
                        auth()->user()->can('file-kesekretariatan') ||
                        auth()->user()->can('surat-masuk-keluar')): ?>
                    <div class="menu-item">
                        <div class="menu-content">
                            <span class="text-gray-800 menu-heading fw-bold text-uppercase fs-7">Menu Utama</span>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Dashboard -->
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('dashboard')): ?>
                    <div class="menu-item">
                        <a class="menu-link <?php echo e(request()->is('admin/dashboard') ? 'active bg-red' : ''); ?>"
                            href="<?php echo e(route('admin.dashboard.index')); ?>">
                            <span class="menu-icon">
                                <i class="fs-1 ki-solid ki-category"></i>
                            </span>
                            <span class="menu-title">Dashboard</span>
                        </a>
                    </div>
                <?php endif; ?>

                <!-- Manajemen RKA -->
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manajemen-rka')): ?>
                    <div class="menu-item">
                        <a class="menu-link <?php echo e(request()->is('admin/manajemen-rka*') ? 'active bg-red' : ''); ?>"
                            href="<?php echo e(route('admin.manajemen-rka.index')); ?>">
                            <span class="menu-icon">
                                <i class="fs-1 ki-solid ki-tablet-text-up"></i>
                            </span>
                            <span class="menu-title">Manajemen RKA</span>
                        </a>
                    </div>
                <?php endif; ?>

                <!-- Laporan LPJ -->
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('laporan-lpj')): ?>
                    <?php
                        $isLaporanLPJActive =
                            request()->is('admin/laporan-lpj*') ||
                            request()->is('admin/bidang*') ||
                            (isset($mainSection) && $mainSection == 'Laporan LPJ');
                    ?>
                    <div class="menu-item">
                        <a class="menu-link d-flex justify-content-between <?php echo e($isLaporanLPJActive ? 'active bg-orange' : ''); ?>"
                            data-bs-toggle="collapse" href="#submenu-laporan" role="button"
                            aria-expanded="<?php echo e($isLaporanLPJActive ? 'true' : 'false'); ?>" aria-controls="submenu-laporan">
                            <span class="d-flex align-items-center">
                                <span class="menu-icon">
                                    <i class="fa-solid fa-money-bill fs-2 <?php echo e($isLaporanLPJActive ? 'text-orange' : 'text-gray-600'); ?>"></i>
                                </span>
                                <span class="menu-title <?php echo e($isLaporanLPJActive ? 'text-orange' : 'text-gray-800'); ?>">
                                    Laporan LPJ
                                </span>
                                <?php if($pengajuanCount > 0): ?>
                                    <span class="badge bg-danger text-white ms-2"
                                        style="font-size: 0.7rem; border-radius: 50%; min-width: 20px; height: 20px; display: flex; align-items: center; justify-content: center;">
                                        <?php echo e($pengajuanCount); ?>

                                    </span>
                                <?php endif; ?>
                            </span>
                            <i class="fa-solid <?php echo e($isLaporanLPJActive ? 'fa-angle-up' : 'fa-angle-down'); ?> fs-4 <?php echo e($isLaporanLPJActive ? 'text-orange' : 'text-gray-600'); ?>"></i>
                        </a>
                        <div class="collapse <?php echo e($isLaporanLPJActive ? 'show' : ''); ?>" id="submenu-laporan">
                            <ul class="menu flex-column ms-5">
                                <li class="menu-item">
                                    <a class="menu-link <?php echo e(request()->is('admin/laporan-lpj/sekretariat*') ? 'active' : ''); ?>"
                                        href="<?php echo e(route('admin.laporan-lpj.sekretariat.index')); ?>">
                                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                        <span class="menu-title">Sekretariat</span>
                                    </a>
                                </li>
                                <li class="menu-item">
                                    <a class="menu-link <?php echo e(request()->is('admin/laporan-lpj/bidang*') ? 'active' : ''); ?>"
                                        href="<?php echo e(route('admin.laporan-lpj.bidang.index')); ?>">
                                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                        <span class="menu-title">Bidang Bidang</span>
                                    </a>
                                </li>
                                <li class="menu-item">
                                    <a class="menu-link <?php echo e(request()->is('admin/laporan-lpj/kegiatan-lainnya*') ? 'active' : ''); ?>"
                                        href="<?php echo e(route('admin.laporan-lpj.kegiatan-lainnya.index')); ?>">
                                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                        <span class="menu-title">Kegiatan Lainnya</span>
                                    </a>
                                </li>
                                <li class="menu-item">
                                    <a class="menu-link <?php echo e(request()->is('admin/laporan-lpj/pengajuan*') ? 'active' : ''); ?>"
                                        href="<?php echo e(route('admin.laporan-lpj.pengajuan.index')); ?>">
                                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                        <span class="menu-title">
                                            Pengajuan Modifikasi LPJ
                                            <?php if($pengajuanCount > 0): ?>
                                                <span class="badge bg-danger text-white ms-2" style="font-size: 0.7rem; border-radius: 50%;">
                                                    <?php echo e($pengajuanCount); ?>

                                                </span>
                                            <?php endif; ?>
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('database-bendahara')): ?>
                    <div class="menu-item">
                        <a class="menu-link <?php echo e(request()->is('admin/bendahara*') ? 'active' : ''); ?>"
                            href="<?php echo e(route('admin.bendahara.index')); ?>">
                            <span class="menu-icon">
                                <i class="fa-solid fa-address-book fs-2"></i>
                            </span>
                            <span class="menu-title">Database Bendahara</span>
                        </a>
                    </div>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('surat-masuk-keluar')): ?>
                    <div class="menu-item">
                        <a class="menu-link <?php echo e(request()->is('admin/surat*') ? 'active bg-red' : ''); ?>"
                            href=" <?php echo e(route('admin.surat.index')); ?>">
                            <span class="menu-icon">
                                <i class="fs-1 fa-solid fa-message"></i>
                            </span>
                            <span class="menu-title">Surat Masuk & Keluar</span>
                        </a>
                    </div>
                <?php endif; ?>

                <!-- File Kesekretariat - MENU BARU -->
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('file-kesekretariatan')): ?>
                    <?php
                        $isFileKesekretariatActive =
                            request()->routeIs('admin.file-kesekretariat*') ||
                            request()->is('admin/file-kesekretariat*') ||
                            (isset($mainSection) && $mainSection == 'File Kesekretariat');
                    ?>
                    <div class="menu-item">
                        <a class="menu-link <?php echo e($isFileKesekretariatActive ? 'active bg-red' : ''); ?>"
                            href="<?php echo e(route('admin.file-kesekretariat.index')); ?>">
                            <span class="menu-icon">
                                <i class="fa-solid fa-folder-open fs-2"></i>
                            </span>
                            <span class="menu-title">File Kesekretariat</span>
                        </a>
                    </div>
                <?php endif; ?>

                <!-- Konfigurasi Section -->
                <?php if(auth()->user()->can('atlet') ||
                        auth()->user()->can('pelatih') ||
                        auth()->user()->can('cabang-olahraga') ||
                        auth()->user()->can('kejuaraan')): ?>
                    <div class="menu-item pt-10">
                        <div class="menu-content">
                            <span class="text-gray-800 menu-heading fw-bold text-uppercase fs-7">Konfigurasi</span>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Atlet -->
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('atlet')): ?>
                    <?php
                        $isAtletActive =
                            request()->routeIs('admin.konfigurasi.atlet*') ||
                            (isset($mainSection) && $mainSection == 'Atlet');
                    ?>
                    <div class="menu-item">
                        <a class="menu-link <?php echo e($isAtletActive ? 'active' : ''); ?>"
                            href="<?php echo e(route('admin.konfigurasi.atlet.index')); ?>"
                            style="<?php echo e($isAtletActive ? 'background-color: #D20A11;' : ''); ?>">
                            <span class="menu-icon">
                                <i class="fa-solid fa-running fs-2"
                                    style="color: <?php echo e($isAtletActive ? '#ffffff' : '#6c757d'); ?>"></i>
                            </span>
                            <span class="menu-title <?php echo e($isAtletActive ? 'text-white' : 'text-gray-800'); ?>">Atlet</span>
                        </a>
                    </div>
                <?php endif; ?>

                <!-- Pelatih -->
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('pelatih')): ?>
                    <?php
                        $isPelatihActive =
                            request()->routeIs('admin.konfigurasi.pelatih*') ||
                            (isset($mainSection) && $mainSection == 'Pelatih');
                    ?>
                    <div class="menu-item">
                        <a class="menu-link <?php echo e($isPelatihActive ? 'active' : ''); ?>"
                            href="<?php echo e(route('admin.konfigurasi.pelatih.index')); ?>"
                            style="<?php echo e($isPelatihActive ? 'background-color: #D20A11;' : ''); ?>">
                            <span class="menu-icon">
                                <i class="fa-solid fa-chalkboard-user fs-2"
                                    style="color: <?php echo e($isPelatihActive ? '#ffffff' : '#6c757d'); ?>"></i>
                            </span>
                            <span
                                class="menu-title <?php echo e($isPelatihActive ? 'text-white' : 'text-gray-800'); ?>">Pelatih</span>
                        </a>
                    </div>
                <?php endif; ?>

                <!-- Cabang Olahraga -->
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('cabang-olahraga')): ?>
                    <?php
                        $isCabangOlahragaActive =
                            request()->routeIs('admin.konfigurasi.cabang-olahraga*') ||
                            (isset($mainSection) && $mainSection == 'Cabang Olahraga');
                    ?>
                    <div class="menu-item">
                        <a class="menu-link <?php echo e($isCabangOlahragaActive ? 'active' : ''); ?>"
                            href="<?php echo e(route('admin.konfigurasi.cabang-olahraga.index')); ?>"
                            style="<?php echo e($isCabangOlahragaActive ? 'background-color: #D20A11;' : ''); ?>">
                            <span class="menu-icon">
                                <i class="fa-solid fa-basketball fs-2"
                                    style="color: <?php echo e($isCabangOlahragaActive ? '#ffffff' : '#6c757d'); ?>"></i>
                            </span>
                            <span class="menu-title <?php echo e($isCabangOlahragaActive ? 'text-white' : 'text-gray-800'); ?>">Cabang
                                Olahraga</span>
                        </a>
                    </div>
                <?php endif; ?>

                <!-- Kejuaraan/Prestasi -->
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('kejuaraan')): ?>
                    <?php
                        $isPrestasiActive =
                            request()->routeIs('admin.konfigurasi.prestasi*') ||
                            (isset($mainSection) && $mainSection == 'Kejuaraan');
                    ?>
                    <div class="menu-item">
                        <a class="menu-link <?php echo e($isPrestasiActive ? 'active' : ''); ?>"
                            href="<?php echo e(route('admin.konfigurasi.prestasi.index')); ?>"
                            style="<?php echo e($isPrestasiActive ? 'background-color: #D20A11;' : ''); ?>">
                            <span class="menu-icon">
                                <i class="fa-solid fa-trophy fs-2"
                                    style="color: <?php echo e($isPrestasiActive ? '#ffffff' : '#6c757d'); ?>"></i>
                            </span>
                            <span
                                class="menu-title <?php echo e($isPrestasiActive ? 'text-white' : 'text-gray-800'); ?>">Kejuaraan</span>
                        </a>
                    </div>
                <?php endif; ?>

                <!-- Manajemen Pengguna Section -->
                <?php if(auth()->user()->can('pengguna') || auth()->user()->can('jabatan')): ?>
                    <div class="menu-item pt-10">
                        <div class="menu-content">
                            <span class="text-gray-800 menu-heading fw-bold text-uppercase fs-7">Manajemen
                                Pengguna</span>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('pengguna')): ?>
                    <?php
                        $isManajemenPenggunaActive =
                            request()->is('admin/manajemen-pengguna*') ||
                            (isset($mainSection) && $mainSection == 'Manajemen Pengguna');
                    ?>
                    <div class="menu-item">
                        <a class="menu-link <?php echo e(request()->is('admin/manajemen-pengguna/pengguna*') ? 'active' : ''); ?>"
                            href="<?php echo e(route('admin.manajemen-pengguna.pengguna.index')); ?>"
                            style="<?php echo e(request()->is('admin/manajemen-pengguna/pengguna*') ? 'background-color: #D20A11;' : ''); ?>">
                            <span class="menu-icon">
                                <i class="fa-solid fa-users fs-2"
                                    style="color: <?php echo e(request()->is('admin/manajemen-pengguna/pengguna*') ? '#ffffff' : '#6c757d'); ?>"></i>
                            </span>
                            <span
                                class="menu-title <?php echo e(request()->is('admin/manajemen-pengguna/pengguna*') ? 'text-white' : 'text-gray-800'); ?>">Pengguna</span>
                        </a>
                    </div>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('jabatan')): ?>
                    <div class="menu-item">
                        <a class="menu-link <?php echo e(request()->is('admin/manajemen-pengguna/role*') ? 'active' : ''); ?>"
                            href="<?php echo e(route('admin.manajemen-pengguna.role.index')); ?>"
                            style="<?php echo e(request()->is('admin/manajemen-pengguna/role*') ? 'background-color: #D20A11;' : ''); ?>">
                            <span class="menu-icon">
                                <i class="fa-solid fa-diagram-project fs-2"
                                    style="color: <?php echo e(request()->is('admin/manajemen-pengguna/role*') ? '#ffffff' : '#6c757d'); ?>"></i>
                            </span>
                            <span
                                class="menu-title <?php echo e(request()->is('admin/manajemen-pengguna/role*') ? 'text-white' : 'text-gray-800'); ?>">Jabatan</span>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
            <!--end::Menu-->
        </div>
    </div>
    <!--end::Aside menu-->

</div>
<?php /**PATH C:\Users\ThinkPad\OneDrive\Dokumen\GitHub\web-koni\resources\views/layouts/sidebar.blade.php ENDPATH**/ ?>