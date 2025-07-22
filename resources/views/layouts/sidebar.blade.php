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
        <div class="mx-5 my-5 hover-scroll-overlay-y my-lg-5" id="kt_aside_menu_wrapper"
            data-kt-scroll="true"
            data-kt-scroll-height="auto"
            data-kt-scroll-dependencies="{default: '#kt_aside_toolbar, #kt_aside_footer', lg: '#kt_header, #kt_aside_toolbar, #kt_aside_footer'}"
            data-kt-scroll-wrappers="#kt_aside_menu"
            data-kt-scroll-offset="5px">

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
                    <a class="menu-link {{ request()->routeIs('admin.dashboard.index') ? 'active bg-orange' : '' }}"
                        href="{{ route('admin.dashboard.index') }}">
                        <span class="menu-icon">
                            <i class="fa-solid fa-house fs-2 {{ request()->routeIs('admin.dashboard.index') ? 'text-orange' : 'text-gray-600' }}"></i>
                        </span>
                        <span class="menu-title">Dashboard</span>
                    </a>
                </div>

                <!-- Manajemen Pengguna -->
                <div class="menu-item">
                    <a class="menu-link d-flex justify-content-between {{ request()->is('admin/manajemen-pengguna*') ? 'active bg-orange' : '' }}"
                        data-bs-toggle="collapse" href="#submenu-pengguna" role="button"
                        aria-expanded="{{ request()->is('admin/manajemen-pengguna*') ? 'true' : 'false' }}"
                        aria-controls="submenu-pengguna">
                        <span class="d-flex align-items-center">
                            <span class="menu-icon">
                                <i class="fa-solid fa-users fs-2 {{ request()->is('admin/manajemen-pengguna*') ? 'text-orange' : 'text-gray-600' }}"></i>
                            </span>
                            <span class="menu-title">Manajemen Pengguna</span>
                        </span>
                        <i class="fa-solid {{ request()->is('admin/manajemen-pengguna*') ? 'fa-angle-up' : 'fa-angle-down' }} fs-4"></i>
                    </a>
                    <div class="collapse {{ request()->is('admin/manajemen-pengguna*') ? 'show' : '' }}" id="submenu-pengguna">
                        <ul class="menu flex-column ms-5">
                            <li class="menu-item">
                                <a class="menu-link {{ request()->is('admin/manajemen-pengguna/pengguna*') ? 'active' : '' }}"
                                    href="{{ route('admin.manajemen-pengguna.pengguna.index') }}">
                                    <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                    <span class="menu-title">Pengguna</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a class="menu-link {{ request()->is('admin/manajemen-pengguna/role*') ? 'active' : '' }}"
                                    href="{{ route('admin.manajemen-pengguna.role.index') }}">
                                    <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                    <span class="menu-title">Jabatan</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Konfigurasi -->
                <div class="menu-item pt-10">
                    <div class="menu-content">
                        <span class="text-gray-800 menu-heading fw-bold text-uppercase fs-7">Konfigurasi</span>
                    </div>
                </div>

                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('admin.konfigurasi.atlet.index') ? 'active bg-orange' : '' }}"
                        href="{{ route('admin.konfigurasi.atlet.index') }}">
                        <span class="menu-icon">
                            <i class="fa-solid fa-dumbbell fs-2 {{ request()->routeIs('admin.konfigurasi.atlet.index') ? 'text-orange' : 'text-gray-600' }}"></i>
                        </span>
                        <span class="menu-title">Atlet</span>
                    </a>
                </div>

            </div>
            <!--end::Menu-->
        </div>
    </div>
    <!--end::Aside menu-->

    <!--begin::Footer-->
    {{-- <div class="p-0 aside-footer flex-column-auto" id="kt_aside_footer">
        <div class="aside-footer-content">
            <!-- Optional footer content -->
        </div>
    </div> --}}
    <!--end::Footer-->

</div>
