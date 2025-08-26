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
                @if(auth()->user()->can('dashboard') || auth()->user()->can('manajemen-rka') || auth()->user()->can('laporan-lpj') || auth()->user()->can('database-bendahara') || auth()->user()->can('file-kesekretariatan') || auth()->user()->can('surat-masuk-keluar'))
                    <div class="menu-item">
                        <div class="menu-content">
                            <span class="text-gray-800 menu-heading fw-bold text-uppercase fs-7">Menu Utama</span>
                        </div>
                    </div>
                @endif

                <!-- Dashboard -->
                @can('dashboard')
                    <div class="menu-item">
                        <a class="menu-link {{ request()->is('admin/dashboard') ? 'active bg-red' : '' }}"
                            href="{{ route('admin.dashboard.index') }}">
                            <span class="menu-icon">
                                <i class="fs-1 ki-solid ki-category"></i>
                            </span>
                            <span class="menu-title">Dashboard</span>
                        </a>
                    </div>
                @endcan

                <!-- Manajemen RKA -->
                @can('manajemen-rka')
                    <div class="menu-item">
                        <a class="menu-link {{ request()->is('admin/manajemen-rka*') ? 'active bg-red' : '' }}"
                            href="{{ route('admin.manajemen-rka.index') }}">
                            <span class="menu-icon">
                                <i class="fs-1 ki-solid ki-tablet-text-up"></i>
                            </span>
                            <span class="menu-title">Manajemen RKA</span>
                        </a>
                    </div>
                @endcan

                <!-- Laporan LPJ -->
                @can('laporan-lpj')
                    @php
                        $isLaporanLPJActive =
                            request()->is('admin/laporan-lpj*') ||
                            request()->is('admin/bidang*') ||
                            (isset($mainSection) && $mainSection == 'Laporan LPJ');
                    @endphp
                    <div class="menu-item">
                        <a class="menu-link d-flex justify-content-between {{ $isLaporanLPJActive ? 'active bg-orange' : '' }}"
                            data-bs-toggle="collapse" href="#submenu-laporan" role="button"
                            aria-expanded="{{ $isLaporanLPJActive ? 'true' : 'false' }}" aria-controls="submenu-laporan">
                            <span class="d-flex align-items-center">
                                <span class="menu-icon">
                                    <i
                                        class="fa-solid fa-money-bill fs-2 {{ $isLaporanLPJActive ? 'text-orange' : 'text-gray-600' }}"></i>
                                </span>
                                <span class="menu-title {{ $isLaporanLPJActive ? 'text-orange' : 'text-gray-800' }}">Laporan
                                    LPJ</span>
                            </span>
                            <i
                                class="fa-solid {{ $isLaporanLPJActive ? 'fa-angle-up' : 'fa-angle-down' }} fs-4 {{ $isLaporanLPJActive ? 'text-orange' : 'text-gray-600' }}"></i>
                        </a>
                        <div class="collapse {{ $isLaporanLPJActive ? 'show' : '' }}" id="submenu-laporan">
                            <ul class="menu flex-column ms-5">
                                <li class="menu-item">
                                    <a class="menu-link {{ request()->is('admin/laporan-lpj/sekretariat*') ? 'active' : '' }}"
                                        href="{{ route('admin.laporan-lpj.sekretariat.index') }}">
                                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                        <span class="menu-title">Sekretariat</span>
                                    </a>
                                </li>
                                <li class="menu-item">
                                    <a class="menu-link {{ request()->is('admin/laporan-lpj/bidang*') ? 'active' : '' }}"
                                        href="{{ route('admin.laporan-lpj.bidang.index') }}">
                                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                        <span class="menu-title">Bidang Bidang</span>
                                    </a>
                                </li>
                                <li class="menu-item">
                                    <a class="menu-link {{ request()->is('admin/laporan-lpj/kegiatan-lainnya*') ? 'active' : '' }}"
                                        href="{{ route('admin.laporan-lpj.kegiatan_lainnya.index') }}">
                                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                        <span class="menu-title">Kegiatan Lainnya</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ request()->is('admin/bendahara*') ? 'active' : '' }}"
                                href="{{ route('admin.bendahara.index') }}">
                                <span class="menu-icon">
                                    <i class="fa-solid fa-address-book fs-2"></i>
                                </span>
                                <span class="menu-title">Database Bendahara</span>
                            </a>
                        </div>
                    </div>
                @endcan

                @can('surat-masuk-keluar')
                <div class="menu-item">
                    <a class="menu-link {{ request()->is('admin/surat*') ? 'active bg-red' : '' }}"
                        href=" {{ route('admin.surat.index') }}">
                        <span class="menu-icon">
                            <i class="fs-1 fa-solid fa-message"></i>
                        </span>
                        <span class="menu-title">Surat Masuk & Keluar</span>
                    </a>
                </div>
                @endcan

                <!-- File Kesekretariat - MENU BARU -->
                @can('file-kesekretariatan')
                @php
                    $isFileKesekretariatActive =
                        request()->routeIs('admin.file-kesekretariat*') ||
                        request()->is('admin/file-kesekretariat*') ||
                        (isset($mainSection) && $mainSection == 'File Kesekretariat');
                @endphp
                <div class="menu-item">
                    <a class="menu-link {{ $isFileKesekretariatActive ? 'active bg-red' : '' }}"
                        href="{{ route('admin.file-kesekretariat.index') }}">
                        <span class="menu-icon">
                            <i class="fa-solid fa-folder-open fs-2"></i>
                        </span>
                        <span class="menu-title">File Kesekretariat</span>
                    </a>
                </div>
                @endcan

                <!-- Konfigurasi Section -->
                @if(auth()->user()->can('atlet') || auth()->user()->can('pelatih') || auth()->user()->can('cabang-olahraga') || auth()->user()->can('kejuaraan'))
                    <div class="menu-item pt-10">
                        <div class="menu-content">
                            <span class="text-gray-800 menu-heading fw-bold text-uppercase fs-7">Konfigurasi</span>
                        </div>
                    </div>
                @endif

                <!-- Atlet -->
                @can('atlet')
                @php
                    $isAtletActive =
                        request()->routeIs('admin.konfigurasi.atlet*') ||
                        (isset($mainSection) && $mainSection == 'Atlet');
                @endphp
                <div class="menu-item">
                    <a class="menu-link {{ $isAtletActive ? 'active' : '' }}"
                        href="{{ route('admin.konfigurasi.atlet.index') }}"
                        style="{{ $isAtletActive ? 'background-color: #D20A11;' : '' }}">
                        <span class="menu-icon">
                            <i class="fa-solid fa-running fs-2"
                                style="color: {{ $isAtletActive ? '#ffffff' : '#6c757d' }}"></i>
                        </span>
                        <span class="menu-title {{ $isAtletActive ? 'text-white' : 'text-gray-800' }}">Atlet</span>
                    </a>
                </div>
                @endcan

                <!-- Pelatih -->
                @can('pelatih')
                @php
                    $isPelatihActive =
                        request()->routeIs('admin.konfigurasi.pelatih*') ||
                        (isset($mainSection) && $mainSection == 'Pelatih');
                @endphp
                <div class="menu-item">
                    <a class="menu-link {{ $isPelatihActive ? 'active' : '' }}"
                        href="{{ route('admin.konfigurasi.pelatih.index') }}"
                        style="{{ $isPelatihActive ? 'background-color: #D20A11;' : '' }}">
                        <span class="menu-icon">
                            <i class="fa-solid fa-chalkboard-user fs-2"
                                style="color: {{ $isPelatihActive ? '#ffffff' : '#6c757d' }}"></i>
                        </span>
                        <span
                            class="menu-title {{ $isPelatihActive ? 'text-white' : 'text-gray-800' }}">Pelatih</span>
                    </a>
                </div>
                @endcan

                <!-- Cabang Olahraga -->
                @can('cabang-olahraga')
                @php
                    $isCabangOlahragaActive =
                        request()->routeIs('admin.konfigurasi.cabang-olahraga*') ||
                        (isset($mainSection) && $mainSection == 'Cabang Olahraga');
                @endphp
                <div class="menu-item">
                    <a class="menu-link {{ $isCabangOlahragaActive ? 'active' : '' }}"
                        href="{{ route('admin.konfigurasi.cabang-olahraga.index') }}"
                        style="{{ $isCabangOlahragaActive ? 'background-color: #D20A11;' : '' }}">
                        <span class="menu-icon">
                            <i class="fa-solid fa-basketball fs-2"
                                style="color: {{ $isCabangOlahragaActive ? '#ffffff' : '#6c757d' }}"></i>
                        </span>
                        <span class="menu-title {{ $isCabangOlahragaActive ? 'text-white' : 'text-gray-800' }}">Cabang
                            Olahraga</span>
                    </a>
                </div>
                @endcan

                <!-- Kejuaraan/Prestasi -->
                @can('kejuaraan')
                @php
                    $isPrestasiActive =
                        request()->routeIs('admin.konfigurasi.prestasi*') ||
                        (isset($mainSection) && $mainSection == 'Kejuaraan');
                @endphp
                <div class="menu-item">
                    <a class="menu-link {{ $isPrestasiActive ? 'active' : '' }}"
                        href="{{ route('admin.konfigurasi.prestasi.index') }}"
                        style="{{ $isPrestasiActive ? 'background-color: #D20A11;' : '' }}">
                        <span class="menu-icon">
                            <i class="fa-solid fa-trophy fs-2"
                                style="color: {{ $isPrestasiActive ? '#ffffff' : '#6c757d' }}"></i>
                        </span>
                        <span
                            class="menu-title {{ $isPrestasiActive ? 'text-white' : 'text-gray-800' }}">Kejuaraan</span>
                    </a>
                </div>
                @endcan

                <!-- Manajemen Pengguna Section -->
                @if(auth()->user()->can('pengguna') || auth()->user()->can('jabatan'))
                    <div class="menu-item pt-10">
                        <div class="menu-content">
                            <span class="text-gray-800 menu-heading fw-bold text-uppercase fs-7">Manajemen Pengguna</span>
                        </div>
                    </div>
                @endif

                @can('pengguna')
                @php
                    $isManajemenPenggunaActive =
                        request()->is('admin/manajemen-pengguna*') ||
                        (isset($mainSection) && $mainSection == 'Manajemen Pengguna');
                @endphp
                <div class="menu-item">
                    <a class="menu-link {{ request()->is('admin/manajemen-pengguna/pengguna*') ? 'active' : '' }}"
                        href="{{ route('admin.manajemen-pengguna.pengguna.index') }}"
                        style="{{ request()->is('admin/manajemen-pengguna/pengguna*') ? 'background-color: #D20A11;' : '' }}">
                        <span class="menu-icon">
                            <i class="fa-solid fa-users fs-2"
                                style="color: {{ request()->is('admin/manajemen-pengguna/pengguna*') ? '#ffffff' : '#6c757d' }}"></i>
                        </span>
                        <span
                            class="menu-title {{ request()->is('admin/manajemen-pengguna/pengguna*') ? 'text-white' : 'text-gray-800' }}">Pengguna</span>
                    </a>
                </div>
                @endcan
                @can('jabatan')
                <div class="menu-item">
                    <a class="menu-link {{ request()->is('admin/manajemen-pengguna/role*') ? 'active' : '' }}"
                        href="{{ route('admin.manajemen-pengguna.role.index') }}"
                        style="{{ request()->is('admin/manajemen-pengguna/role*') ? 'background-color: #D20A11;' : '' }}">
                        <span class="menu-icon">
                            <i class="fa-solid fa-diagram-project fs-2"
                                style="color: {{ request()->is('admin/manajemen-pengguna/role*') ? '#ffffff' : '#6c757d' }}"></i>
                        </span>
                        <span
                            class="menu-title {{ request()->is('admin/manajemen-pengguna/role*') ? 'text-white' : 'text-gray-800' }}">Jabatan</span>
                    </a>
                </div>
                @endcan
            </div>
            <!--end::Menu-->
        </div>
    </div>
    <!--end::Aside menu-->

</div>
