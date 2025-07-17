<div id="kt_header" class="header align-items-stretch">
    <!--begin::Brand-->
    <div class="px-5 py-2 bg-white d-flex justify-content-between">
        <!--begin::Logo-->
        <div class="gap-3 px-4 d-flex align-items-center" style="width:220px; min-width:180px">
            <a href="/" class="d-flex align-items-center">
                <img alt="Logo" src="{{ asset('landing-assets/img/logo.png') }}" class="h-45px me-2" />
                <div class="d-flex flex-column lh-1">
                    <span class="fw-bold" style="font-size:1.2rem; letter-spacing:1px; color:#003C77">Perumda <span
                            class="fw-bold" style="font-size:1.2rem; letter-spacing:1px; color:#FF6224">Varia
                            Niaga</span></span>
                    <small class="text-muted" style="font-size:.85rem; margin-top:2px;">Samarinda</small>
                </div>
            </a>
        </div>
        <!--end::Logo-->
        <!--begin::Aside minimize-->
        {{-- <div id="kt_aside_toggle" class="px-0 w-auto btn btn-icon btn-active-color-primary aside-minimize"
            data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body"
            data-kt-toggle-name="aside-minimize">
            <i class="ki-duotone ki-entrance-right fs-1 me-n1 minimize-default">
                <span class="path1"></span>
                <span class="path2"></span>
            </i>
            <i class="ki-duotone ki-entrance-left fs-1 minimize-active">
                <span class="path1"></span>
                <span class="path2"></span>
            </i>
        </div> --}}
        <!--end::Aside minimize-->
        <!--begin::Aside toggle-->
        <div class="d-flex align-items-center d-lg-none me-n2" title="Show aside menu">
            <div class="btn btn-icon btn-active-color-primary w-30px h-30px" id="kt_aside_mobile_toggle">
                <i class="ki-duotone ki-abstract-14 fs-1">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
            </div>
        </div>
        <!--end::Aside toggle-->
    </div>
    <!--end::Brand-->
    <!--begin::Toolbar-->
    <div class="toolbar d-flex align-items-stretch position-relative">
        <!--begin::Toolbar container-->
        {{-- <img src="{{ asset('assets/media/patterns/header.png') }}" alt="bg-img" class="position-absolute"
            style="z-index: -1; width: 100%; max-height: 74px; object-fit: cover;"> --}}
        <div class="app-container container-fluid d-flex align-items-stretch justify-content-between">
            <!--begin::Page title-->
            <div class="page-title d-flex align-items-center justify-content-start me-5">
                <!--begin::Text Content-->
                <div class="mx-2 d-flex flex-column">
                    <!--begin::Title-->
                    <h1 class="mb-0 text-orange fw-bold fs-3">
                        @yield('pageTitle')
                    </h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ol class="breadcrumb breadcrumb-separatorless fs-7 fw-semibold">
                        <li class="breadcrumb-item text-muted mx-0 px-0">@yield('mainSection')</li>
                        <i class="ki-duotone ki-right mx-1 px-0"></i>
                        @hasSection('subSection')
                            <li class="breadcrumb-item mx-0 px-0">@yield('subSection')</li>                        
                            <i class="ki-duotone ki-right mx-1 px-0"></i>
                        @endif
                        <li class="breadcrumb-item mx-0 px-0" style="color: #071437">@yield('currentSection')</li>
                    </ol>
                    {{-- <ul class="pt-1 breadcrumb breadcrumb-separatorless fw-semibold fs-7 d-flex align-items-center">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            @yield('mainSection')
                        </li>
                        <!--end::Item-->
                        <!--begin::Separator-->
                        <li class="breadcrumb-item">
                            <span class="bg-gray-300 bullet w-5px h-2px"></span>
                        </li>
                        <!--end::Separator-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            @yield('currentSection')
                        </li>
                        <!--end::Item-->
                    </ul> --}}
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Text Content-->

                <!--begin::Image-->
                {{-- <img src="{{ asset('assets/media/logos/logo-bpn-nyaman.png') }}" alt="Logo"
                    style="width: auto; max-height: 40px; margin-left: 1rem;"> --}}
                <!--end::Image-->

            </div>
            <!--end::Page title-->
            <!--begin::Action group-->
            <div class="overflow-auto pt-3 d-flex align-items-stretch pt-lg-0">
                <!-- Your existing Action group content here -->
            </div>
            <!--end::Action group-->
        </div>
        <!--end::Toolbar container-->
    </div>


    <div class="p-5 aside-user d-none d-lg-flex align-items-center justify-content-end" style="border: none;">
        <!--begin::Wrapper-->
        <div class="flex-wrap aside-user-info flex-row-fluid ms-5">
            <!--begin::Section-->
            <div class="d-flex">
                <!--begin::Info-->
                <div class="flex-grow-1 me-2">
                    <!--begin::Username-->
                    <a href="#" class="text-gray-400 text-hover-light fs-8 fw-bold">{{ Auth::user()->name }}</a>
                    <!--end::Username-->
                    <!--begin::Description-->
                    <span
                        class="mb-1 text-gray-400 fw-semibold d-block fs-8">{{ Auth::user()->roles()->first()->name }}</span>
                    <!--end::Description-->
                    <!--begin::Label-->
                    {{-- <div class="d-flex align-items-center text-success fs-9">
                        <span class="bullet bullet-dot bg-success me-1"></span>online
                    </div> --}}
                    <!--end::Label-->
                </div>
                <!--end::Info-->
            </div>
            <!--end::Section-->
        </div>
        <!--end::Wrapper-->
        <!--begin::Symbol-->
        <!--begin::User symbol + trigger-->
        <a href="#" class="symbol symbol-35px symbol-circle mt-n2" data-kt-menu-trigger="click"
            data-kt-menu-placement="bottom-start" data-kt-menu-overflow="true">
            @if (Auth::user()->foto)
                <img src="{{ asset('/storage/' . Auth::user()->foto) }}" alt="User foto" class="symbol-label" />
            @else
                @php
                    $user = Auth::user();
                    $nameParts = explode(' ', $user->name);
                    $initials = strtoupper(
                        substr($nameParts[0], 0, 1) . (isset($nameParts[1]) ? substr($nameParts[1], 0, 1) : ''),
                    );
                @endphp
                <div class="symbol-label fs-2 fw-semibold bg-primary text-inverse-danger">{{ $initials }}</div>
            @endif
        </a>
        <!--end::User symbol-->

        <!--begin::User account menu-->
        <div class="py-4 menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold fs-6 w-275px"
            data-kt-menu="true">
            <!--begin::Menu item-->
            <div class="px-5 my-1 menu-item">
                <a href="account/settings.html" class="px-5 menu-link">
                    Account Settings
                </a>
            </div>
            <!--end::Menu item-->
            <!--begin::Menu item-->
            <div class="px-5 menu-item">
                <a href="{{ route('logout') }}" class="px-5 menu-link">
                    Sign Out
                </a>
            </div>
            <!--end::Menu item-->
        </div>
        <!--end::User account menu-->
        <!--end::Symbol-->
    </div>

    <!--end::Toolbar-->
</div>
