<div id="kt_aside" class="aside" data-kt-drawer="true" data-kt-drawer-name="aside"
    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true"
    data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start"
    data-kt-drawer-toggle="#kt_aside_mobile_toggle" style="box-shadow: 4px 0 6px -4px rgba(0, 0, 0, 0.1);">
    <!--begin::Aside Toolbarl-->
    <div class="aside-toolbar flex-column-auto" id="kt_aside_toolbar">
        <!--begin::Aside user-->
        <!--begin::User-->

        <!--end::User-->
        <!--end::Aside user-->
    </div>
    <!--end::Aside Toolbarl-->
    <!--begin::Aside menu-->
    <div class="bg-white aside-menu flex-column-fluid">
        <!--begin::Aside Menu-->
        <div class="mx-5 my-5 hover-scroll-overlay-y my-lg-5" id="kt_aside_menu_wrapper" data-kt-scroll="true"
            data-kt-scroll-height="auto"
            data-kt-scroll-dependencies="{default: '#kt_aside_toolbar, #kt_aside_footer', lg: '#kt_header, #kt_aside_toolbar, #kt_aside_footer'}"
            data-kt-scroll-wrappers="#kt_aside_menu" data-kt-scroll-offset="5px">
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
                    <a class="menu-link {{ request()->routeIs('dashboard') ? 'active bg-orange' : '' }}"
                        href="{{ route('admin.dashboard.index') }}">
                        <span class="menu-icon"><i
                                class="fa-solid fa-house fs-2 {{ request()->routeIs('dashboard') ? 'text-orange' : 'text-gray-600' }}"></i></span>
                        <span class="menu-title">Dashboard</span>
                    </a>
                </div>

                <!-- Manajemen Pengguna (induk) -->
                <div class="menu-item">
                    <a class="menu-link d-flex justify-content-between {{ request()->is('admin/manajemen-pengguna*') ? 'active bg-orange' : '' }}"
                        data-bs-toggle="collapse" href="#submenu-pengguna" role="button"
                        aria-expanded="{{ request()->is('admin/manajemen-pengguna*') ? 'true' : 'false' }}"
                        aria-controls="submenu-pengguna">
                        <span class="d-flex align-items-center">
                            <span class="menu-icon"><i
                                    class="fa-solid fa-users fs-2 {{ request()->is('admin/manajemen-pengguna*') ? 'text-orange' : 'text-gray-600' }}"></i></span>
                            <span class="menu-title">Manajemen Pengguna</span>
                        </span>
                        <i
                            class="fa-solid {{ request()->is('admin/manajemen-pengguna*') ? 'fa-angle-up' : 'fa-angle-down' }} fs-4"></i>
                    </a>
                    <div class="{{ request()->is('admin/manajemen-pengguna*') ? 'show' : '' }} collapse"
                        id="submenu-pengguna">
                        <ul class="menu flex-column ms-5">
                            <li class="menu-item">
                                <a class="menu-link {{ request()->is('admin/manajemen-pengguna/pengguna*') ? 'active' : '' }}"
                                    href="{{ route('admin.manajemen-pengguna.pengguna.index') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Pengguna</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a class="menu-link {{ request()->is('admin/manajemen-pengguna/role*') ? 'active' : '' }}"
                                    href="{{ route('admin.manajemen-pengguna.role.index') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Jabatan</span>
                                </a>
                            </li>
                            {{-- <li class="menu-item">
                                <a class="menu-link {{ request()->routeIs('nota-penebusan.create') ? 'active' : '' }}"
                                    href="{{ route('nota-penebusan.create') }}"><span class="menu-bullet"><span
                                            class="bullet bullet-dot"></span></span><span class="menu-title">Transaksi
                                        Penebusan</span></a>
                            </li> --}}
                        </ul>
                    </div>
                </div>

                <div class="menu-item">
                    <a class="menu-link d-flex justify-content-between {{ request()->is('admin/konfigurasi*') ? 'active bg-orange' : '' }}"
                        data-bs-toggle="collapse" href="#submenu-pengguna" role="button"
                        aria-expanded="{{ request()->is('admin/konfigurasi*') ? 'true' : 'false' }}"
                        aria-controls="submenu-pengguna">
                        <span class="d-flex align-items-center">
                            <span class="menu-icon"><i
                                    class="fa-solid fa-users fs-2 {{ request()->is('admin/konfigurasi*') ? 'text-orange' : 'text-gray-600' }}"></i></span>
                            <span class="menu-title">Konfigurasi</span>
                        </span>
                        <i
                            class="fa-solid {{ request()->is('admin/konfigurasi*') ? 'fa-angle-up' : 'fa-angle-down' }} fs-4"></i>
                    </a>
                    <div class="{{ request()->is('admin/konfigurasi*') ? 'show' : '' }} collapse"
                        id="submenu-pengguna">
                        <ul class="menu flex-column ms-5">
                            <li class="menu-item">
                                <a class="menu-link {{ request()->is('admin/konfigurasi/pelatih*') ? 'active' : '' }}"
                                    href="{{ route('admin.konfigurasi.pelatih.index') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Pelatih</span>
                                </a>
                            </li>
                            {{-- <li class="menu-item">
                                <a class="menu-link {{ request()->is('admin/manajemen-pengguna/role*') ? 'active' : '' }}"
                                    href="{{ route('admin.manajemen-pengguna.role.index') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Jabatan</span>
                                </a>
                            </li> --}}
                            {{-- <li class="menu-item">
                                <a class="menu-link {{ request()->routeIs('nota-penebusan.create') ? 'active' : '' }}"
                                    href="{{ route('nota-penebusan.create') }}"><span class="menu-bullet"><span
                                            class="bullet bullet-dot"></span></span><span class="menu-title">Transaksi
                                        Penebusan</span></a>
                            </li> --}}
                        </ul>
                    </div>
                </div>


            </div>
            <!--end::Menu-->
        </div>
        <!--end::Aside Menu-->
    </div>
    <!--end::Aside menu-->
    <!--begin::Footer-->
    {{-- <div class="p-0 aside-footer flex-column-auto" id="kt_aside_footer">
        <div class="aside-footer-content">
            <!-- Tambahkan konten footer lain jika ada -->
        </div>
    </div> --}}
    <!--end::Footer-->
</div>
