<div id="kt_aside" class="aside" data-kt-drawer="true" data-kt-drawer-name="aside"
    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true"
    data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start"
    data-kt-drawer-toggle="#kt_aside_mobile_toggle"
    style="box-shadow: 4px 0 6px -4px rgba(0, 0, 0, 0.1);">

    <!--begin::Aside Toolbar-->
    <div class="aside-toolbar flex-column-auto" id="kt_aside_toolbar">
        <!-- Placeholder for future user/profile -->
    </div>
    <!--end::Aside Toolbar-->

    <!--begin::Aside menu-->
    <div class="bg-white aside-menu flex-column-fluid">
        <!--begin::Aside Menu-->
        <div class="mx-5 my-5 hover-scroll-overlay-y my-lg-5" id="kt_aside_menu_wrapper" data-kt-scroll="true"
            data-kt-scroll-height="auto"
            data-kt-scroll-dependencies="{default: '#kt_aside_toolbar, #kt_aside_footer', lg: '#kt_header, #kt_aside_toolbar, #kt_aside_footer'}"
            data-kt-scroll-wrappers="#kt_aside_menu"
            data-kt-scroll-offset="5px">

            <!--begin::Menu-->
            <div class="menu-column menu-title-gray-800" id="#kt_aside_menu" data-kt-menu="true">
                <!-- Menu Utama (label) -->
                <div class="menu-item">
                    <div class="menu-content">
                        <span class="text-gray-800 menu-heading fw-bold text-uppercase fs-7">Menu Utama</span>
                    </div>
                </div>

                <!-- Dashboard -->
                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('admin.dashboard.index') ? 'active bg-orange' : '' }}"
                        href="{{ route('admin.dashboard.index') }}">
                        <span class="menu-icon">
                            <i class="fa-solid fa-house fs-2 {{ request()->routeIs('admin.dashboard.index') ? 'text-orange' : 'text-gray-600' }}"></i>
                        </span>
                        <span class="menu-title">Dashboard</span>
                    </a>
                </div>

                <!-- Pengguna -->
                <div class="menu-item">
                    <a class="menu-link {{ request()->is('admin/manajemen-pengguna/pengguna*') ? 'active bg-orange' : '' }}"
                        href="{{ route('admin.manajemen-pengguna.pengguna.index') }}">
                        <span class="menu-icon">
                            <i class="fa-solid fa-user fs-2 {{ request()->is('admin/manajemen-pengguna/pengguna*') ? 'text-orange' : 'text-gray-600' }}"></i>
                        </span>
                        <span class="menu-title">Pengguna</span>
                    </a>
                </div>

                <!-- Jabatan -->
                <div class="menu-item">
                    <a class="menu-link {{ request()->is('admin/manajemen-pengguna/role*') ? 'active bg-orange' : '' }}"
                        href="{{ route('admin.manajemen-pengguna.role.index') }}">
                        <span class="menu-icon">
                            <i class="fa-solid fa-user-tie fs-2 {{ request()->is('admin/manajemen-pengguna/role*') ? 'text-orange' : 'text-gray-600' }}"></i>
                        </span>
                        <span class="menu-title">Jabatan</span>
                    </a>
                </div>

                <!-- Konfigurasi Section -->
                <div class="menu-item pt-10">
                    <div class="menu-content">
                        <span class="text-gray-800 menu-heading fw-bold text-uppercase fs-7">Konfigurasi</span>
                    </div>
                </div>

                <!-- Pelatih -->
                <div class="menu-item">
                    <a class="menu-link {{ request()->is('admin/konfigurasi/pelatih*') ? 'active bg-orange' : '' }}"
                        href="{{ route('admin.konfigurasi.pelatih.index') }}">
                        <span class="menu-icon">
                            <i class="fa-solid fa-chalkboard-user fs-2 {{ request()->is('admin/konfigurasi/pelatih*') ? 'text-orange' : 'text-gray-600' }}"></i>
                        </span>
                        <span class="menu-title">Pelatih</span>
                    </a>
                </div>

                <!-- Atlet -->
                <div class="menu-item">
                    <a class="menu-link {{ request()->is('admin/konfigurasi/atlet*') ? 'active bg-orange' : '' }}"
                        href="{{ route('admin.konfigurasi.atlet.index') }}">
                        <span class="menu-icon">
                            <i class="fa-solid fa-running fs-2 {{ request()->is('admin/konfigurasi/atlet*') ? 'text-orange' : 'text-gray-600' }}"></i>
                        </span>
                        <span class="menu-title">Atlet</span>
                    </a>
                </div>

            </div>
            <!--end::Menu-->
        </div>
        <!--end::Aside Menu-->
    </div>
    <!--end::Aside menu-->

</div>
