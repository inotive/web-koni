<div id="kt_aside" class="aside" data-kt-drawer="true" data-kt-drawer-name="aside"
    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true"
    data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start"
    data-kt-drawer-toggle="#kt_aside_mobile_toggle" style="box-shadow: 4px 0 6px -4px rgba(0, 0, 0, 0.1);">

    <div class="aside-toolbar flex-column-auto" id="kt_aside_toolbar">
    </div>
    <div class="bg-white aside-menu flex-column-fluid">
        <div class="mx-5 my-5 hover-scroll-overlay-y my-lg-5" id="kt_aside_menu_wrapper" data-kt-scroll="true"
            data-kt-scroll-height="auto"
            data-kt-scroll-dependencies="{default: '#kt_aside_toolbar, #kt_aside_footer', lg: '#kt_header, #kt_aside_toolbar, #kt_aside_footer'}"
            data-kt-scroll-wrappers="#kt_aside_menu" data-kt-scroll-offset="5px">

            <div class="menu-column menu-title-gray-800" id="#kt_aside_menu" data-kt-menu="true">

                <div class="menu-item">
                    <div class="menu-content">
                        <span class="text-gray-800 menu-heading fw-bold text-uppercase fs-7">Menu Utama</span>
                    </div>
                </div>

                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('admin.dashboard.index') ? 'active bg-orange' : '' }}"
                        href="{{ route('admin.dashboard.index') }}">
                        <span class="menu-icon">
                            <i class="fa-solid fa-house fs-2 {{ request()->routeIs('admin.dashboard.index') ? 'text-orange' : 'text-gray-600' }}"></i>
                        </span>
                        <span class="menu-title">Dashboard</span>
                    </a>
                </div>

              <div class="menu-item">
    <a class="menu-link d-flex justify-content-between {{ request()->is('admin/kegiatan-lainnya*') ? 'active bg-orange' : '' }}"
        data-bs-toggle="collapse" href="#submenu-kegiatan-lainnya" role="button"
        aria-expanded="{{ request()->is('admin/kegiatan-lainnya*') ? 'true' : 'false' }}"
        aria-controls="submenu-kegiatan-lainnya">
        <span class="d-flex align-items-center">
            <span class="menu-icon">
                <i
                    class="fa-solid fa-file-invoice fs-2 {{ request()->is('admin/kegiatan-lainnya*') ? 'text-orange' : 'text-gray-600' }}"></i>
            </span>
            <span class="menu-title">Laporan LPJ (Kegiatan Lainnya)</span>
        </span>
        <i
            class="fa-solid {{ request()->is('admin/kegiatan-lainnya*') ? 'fa-angle-up' : 'fa-angle-down' }} fs-4"></i>
    </a>
    <div class="collapse {{ request()->is('admin/kegiatan-lainnya*') ? 'show' : '' }}"
        id="submenu-kegiatan-lainnya">
        <ul class="menu flex-column ms-5">
            <li class="menu-item">
                <a class="menu-link {{ request()->is('admin/kegiatan-lainnya*') ? 'active' : '' }}"
                    href="{{ route('admin.kegiatan-lainnya.index') }}">
                    <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                    <span class="menu-title">Kegiatan Lainnya</span>
                </a>
            </li>
        </ul>
    </div>
</div>


                <div class="menu-item">
                    <a class="menu-link d-flex justify-content-between {{ request()->is('admin/laporan-pj*') ? 'active bg-orange' : '' }}"
                        data-bs-toggle="collapse" href="#submenu-laporan-lpj" role="button"
                        aria-expanded="{{ request()->is('admin/laporan-pj*') ? 'true' : 'false' }}"
                        aria-controls="submenu-laporan-lpj">
                        <span class="d-flex align-items-center">
                            <span class="menu-icon">
                                <i
                                    class="fa-solid fa-file-invoice fs-2 {{ request()->is('admin/laporan-pj*') ? 'text-orange' : 'text-gray-600' }}"></i>
                            </span>
                            <span class="menu-title">Laporan LPJ</span>
                        </span>
                        <i
                            class="fa-solid {{ request()->is('admin/kegiatan-lainnya*') ? 'fa-angle-up' : 'fa-angle-down' }} fs-4"></i>
                    </a>
                    <div class="collapse {{ request()->is('admin/kegiatan-lainnya*') ? 'show' : '' }}"
                        id="submenu-laporan-lpj">
                        <ul class="menu flex-column ms-5">
                            <li class="menu-item">
                                <a class="menu-link {{ request()->is('admin/laporan-pj/kegiatan-lainnya*') ? 'active' : '' }}"
                                    href="{{ route('admin.kegiatan-lainnya.index') }}">
                                    <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                    <span class="menu-title">Kegiatan Lainnya</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

               

                <div class="menu-item pt-10">
                    <div class="menu-content">
                        <span class="text-gray-800 menu-heading fw-bold text-uppercase fs-7">Konfigurasi</span>
                    </div>
                </div>

                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('admin.konfigurasi.atlet.index') ? 'active bg-orange' : '' }}"
                        href="{{ route('admin.konfigurasi.atlet.index') }}">
                        <span class="menu-icon">
                            <i
                                class="fa-solid fa-running fs-2 {{ request()->routeIs('admin.konfigurasi.atlet.index') ? 'text-orange' : 'text-gray-600' }}"></i>
                        </span>
                        <span class="menu-title">Atlet</span>
                    </a>
                </div>

                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('admin.konfigurasi.pelatih.index') ? 'active bg-orange' : '' }}"
                        href="{{ route('admin.konfigurasi.pelatih.index') }}">
                        <span class="menu-icon">
                            <i
                                class="fa-solid fa-chalkboard-user fs-2 {{ request()->routeIs('admin.konfigurasi.pelatih.index') ? 'text-orange' : 'text-gray-600' }}"></i>
                        </span>
                        <span class="menu-title">Pelatih</span>
                    </a>
                </div>

                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('admin.konfigurasi.cabang-olahraga.index') ? 'active bg-orange' : '' }}"
                        href="{{ route('admin.konfigurasi.cabang-olahraga.index') }}">
                        <span class="menu-icon">
                            <i class="fa-solid fa-basketball fs-2 {{ request()->routeIs('admin.konfigurasi.cabang-olahraga.index') ? 'text-orange' : 'text-gray-600' }}"></i>
                        </span>
                        <span class="menu-title">Cabang Olahraga</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>