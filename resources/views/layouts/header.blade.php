{{-- File: resources/views/layouts/partials/header.blade.php --}}
<div id="kt_header" class="header align-items-stretch">
    <!--begin::Brand-->
    <div class="px-5 py-2 bg-white d-flex justify-content-between">
        <!--begin::Logo-->
        <div class="gap-3 px-4 d-flex align-items-center" style="width:220px; min-width:180px">
            <a href="/" class="d-flex align-items-center">
                <img alt="Logo" src="{{ asset('assets/koni.png') }}" class="h-45px me-2" />
            </a>
        </div>
        <!--end::Logo-->
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
        <div class="app-container container-fluid d-flex align-items-stretch justify-content-between">
            <!--begin::Page title-->
            <div class="page-title d-flex align-items-center justify-content-start me-5">
                <!--begin::Text Content-->
                <div class="mx-2 d-flex flex-column">
                    <!--begin::Title-->
                    <h1 class="mb-0 fw-bold fs-3" style="color: #F8285A;">
                        @yield('pageTitle')
                    </h1>

                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-separatorless fs-7 fw-semibold">
                            {{-- Main Section - Selalu clickable --}}
                            <li class="breadcrumb-item mx-0 px-0">
                                @if (View::hasSection('mainSectionUrl'))
                                    <a href="@yield('mainSectionUrl')" class="text-muted text-hover-primary">
                                        @yield('mainSection')
                                    </a>
                                @else
                                    <span class="text-muted">@yield('mainSection')</span>
                                @endif
                            </li>

                            {{-- Separator --}}
                            <i class="ki-duotone ki-right mx-1 px-0 text-muted"></i>

                            {{-- Sub Section - Conditional --}}
                            @hasSection('subSection')
                                <li class="breadcrumb-item mx-0 px-0">
                                    @if (View::hasSection('subSectionUrl'))
                                        <a href="@yield('subSectionUrl')" class="text-muted text-hover-primary">
                                            @yield('subSection')
                                        </a>
                                    @else
                                        <span class="text-muted">@yield('subSection')</span>
                                    @endif
                                </li>
                                <i class="ki-duotone ki-right mx-1 px-0 text-muted"></i>
                            @endif

                            {{-- Current Section - Active (tidak clickable) --}}
                            <li class="breadcrumb-item mx-0 px-0 active" aria-current="page">
                                <span style="color: #071437; font-weight: 500;">@yield('currentSection')</span>
                            </li>
                        </ol>
                    </nav>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Text Content-->
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

    {{-- User Profile Section --}}
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

<style>
    /* Breadcrumb Navigation Styles */
    .breadcrumb a {
        text-decoration: none;
        transition: color 0.2s ease;
    }

    .breadcrumb a:hover {
        color: #071437 !important;
    }

    .breadcrumb-item.active span {
        color: #071437 !important;
    }

    .breadcrumb-item:not(.active) a {
        cursor: pointer;
    }
</style>
