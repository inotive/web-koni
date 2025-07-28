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
            <div class="menu-column menu-title-gray-800" id="#kt_aside_menu" data-kt-menu="true">

                <!-- Menu Utama -->
                <div class="menu-item">
                    <div class="menu-content">
                        <span class="text-gray-800 menu-heading fw-bold text-uppercase fs-7">Menu Utama</span>
                    </div>
                </div>

                <!-- Dashboard -->
                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('admin.dashboard.index') ? 'active' : '' }}"
                        href="{{ route('admin.dashboard.index') }}"
                        style="{{ request()->routeIs('admin.dashboard.index') ? 'background-color: #D20A11;' : '' }}">
                        <span class="menu-icon">
                            <i class="fa-solid fa-house fs-2"
                                style="color: {{ request()->routeIs('admin.dashboard.index') ? '#D20A11' : '#6c757d' }}"></i>
                        </span>
                        <span class="menu-title text-gray-800">Dashboard</span>
                    </a>
                </div>

                <!-- Konfigurasi -->
                <div class="menu-item pt-10">
                    <div class="menu-content">
                        <span class="text-gray-800 menu-heading fw-bold text-uppercase fs-7">Konfigurasi</span>
                    </div>
                </div>

                <!-- Pengguna -->
                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('admin.manajemen-pengguna.pengguna.index') ? 'active' : '' }}"
                        href="{{ route('admin.manajemen-pengguna.pengguna.index') }}"
                        style="{{ request()->routeIs('admin.manajemen-pengguna.pengguna.index') ? 'background-color: #D20A11;' : '' }}">
                        <span class="menu-icon">
                            <i class="fa-solid fa-users fs-2"
                                style="color: {{ request()->routeIs('admin.manajemen-pengguna.pengguna.index') ? '#D20A11' : '#6c757d' }}"></i>
                        </span>
                        <span class="menu-title text-gray-800">Pengguna</span>
                    </a>
                </div>

                <!-- Jabatan & Hak Akses -->
                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('admin.manajemen-pengguna.role.index') ? 'active' : '' }}"
                        href="{{ route('admin.manajemen-pengguna.role.index') }}"
                        style="{{ request()->routeIs('admin.manajemen-pengguna.role.index') ? 'background-color: #D20A11;' : '' }}">
                        <span class="menu-icon">
                            <i class="fa-solid fa-diagram-project fs-2"
                                style="color: {{ request()->routeIs('admin.manajemen-pengguna.role.index') ? '#D20A11' : '#6c757d' }}"></i>
                        </span>
                        <span class="menu-title text-gray-800">Jabatan & Hak Akses</span>
                    </a>
                </div>

                <!-- Atlet -->
                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('admin.konfigurasi.atlet.index') ? 'active' : '' }}"
                        href="{{ route('admin.konfigurasi.atlet.index') }}"
                        style="{{ request()->routeIs('admin.konfigurasi.atlet.index') ? 'background-color: #D20A11;' : '' }}">
                        <span class="menu-icon">
                            <i class="fa-solid fa-running fs-2"
                                style="color: {{ request()->routeIs('admin.konfigurasi.atlet.index') ? '#D20A11' : '#6c757d' }}"></i>
                        </span>
                        <span class="menu-title text-gray-800">Atlet</span>
                    </a>
                </div>

                <!-- Pelatih -->
                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('admin.konfigurasi.pelatih.index') ? 'active' : '' }}"
                        href="{{ route('admin.konfigurasi.pelatih.index') }}"
                        style="{{ request()->routeIs('admin.konfigurasi.pelatih.index') ? 'background-color: #D20A11;' : '' }}">
                        <span class="menu-icon">
                            <i class="fa-solid fa-chalkboard-user fs-2"
                                style="color: {{ request()->routeIs('admin.konfigurasi.pelatih.index') ? '#D20A11' : '#6c757d' }}"></i>
                        </span>
                        <span class="menu-title text-gray-800">Pelatih</span>
                    </a>
                </div>

                <!-- Cabang Olahraga -->
                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('admin.konfigurasi.cabang-olahraga.index') ? 'active' : '' }}"
                        href="{{ route('admin.konfigurasi.cabang-olahraga.index') }}"
                        style="{{ request()->routeIs('admin.konfigurasi.cabang-olahraga.index') ? 'background-color: #D20A11;' : '' }}">
                        <span class="menu-icon">
                            <i class="fa-solid fa-basketball fs-2"
                                style="color: {{ request()->routeIs('admin.konfigurasi.cabang-olahraga.index') ? '#D20A11' : '#6c757d' }}"></i>
                        </span>
                        <span class="menu-title text-gray-800">Cabang Olahraga</span>
                    </a>
                </div>
            </div>
            <div class="menu-item">
                <a class="menu-link {{ request()->routeIs('admin.konfigurasi.prestasi.index') ? 'active bg-orange' : '' }}"
                    href="{{ route('admin.konfigurasi.prestasi.index') }}">
                    <span class="menu-icon">
                        <i
                            class="fa-solid fa-trophy fs-2 {{ request()->routeIs('admin.konfigurasi.prestasi.index') ? 'text-orange' : 'text-gray-600' }}"></i>
                    </span>
                    <span class="menu-title text-gray-800">Kejuaraan</span>
                </a>
            </div>
            <!--end::Menu-->
        </div>
    </div>
    <!--end::Aside menu-->

</div>
