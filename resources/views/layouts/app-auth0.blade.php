<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<!--begin::Head-->

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>KONI Tabalong - @yield('title')</title>
    <link rel="shortcut icon" href="{{ asset('assets/media/logos/logo-mustikagadai-tiga-puteri.png') }}" />
    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->
    @yield('style')

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body" class="auth-bg bgi-size-cover bgi-attachment-fixed bgi-position-center bgi-no-repeat">
    <!--begin::Theme mode setup on page load-->
    <script>
        var defaultThemeMode = "light";
        var themeMode;
        if (document.documentElement) {
            if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
                themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
            } else {
                if (localStorage.getItem("data-bs-theme") !== null) {
                    themeMode = localStorage.getItem("data-bs-theme");
                } else {
                    themeMode = defaultThemeMode;
                }
            }
            if (themeMode === "system") {
                themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
            }
            document.documentElement.setAttribute("data-bs-theme", themeMode);
        }
    </script>
    <!--end::Theme mode setup on page load-->
    <!--begin::Main-->
    <!--begin::Root-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Page bg image-->
        <style>
            body {

                background-image: url('assets/media/misc/auth-bg.png');
                background-size: cover;
                background-repeat: no-repeat;
            }

            [data-bs-theme="dark"] body {
                background-image: url('assets/media/misc/auth-bg.png');
            }
        </style>
        <!--end::Page bg image-->
        <!--begin::Authentication - Sign-in -->
        <div class="d-flex flex-column flex-column-fluid flex-lg-row-reverse">
            <!--begin::Aside-->
            <div class="px-10 bg-white d-flex px-lg-15 pt-15 pt-lg-0" style="min-width: 35%">
                <!--begin::Aside-->

                <div class="d-flex justify-content-center w-100">
                    @yield('content')
                </div>

            </div>
            <!--begin::Aside-->

            <div class="order-1 d-flex flex-lg-row-fluid w-lg-50">
                <div class="px-5 d-flex flex-column flex-center py-7 py-lg-15 px-md-15 w-100">
                    <div class="px-5 d-flex flex-column flex-center py-7 py-lg-15 px-md-15 w-100">
                        <!--begin::Logo-->
                    </div>
                </div>
                <!--end::Aside-->
            </div>

            <!--end::Card-->
        </div>
        <!--end::Body-->
    </div>
    <!--end::Authentication - Sign-in-->
    </div>
    <!--end::Root-->
    <!--end::Main-->
    <!--begin::Javascript-->
    <!--begin::Global Javascript Bundle(mandatory for all pages)-->
    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
    <!--end::Global Javascript Bundle-->
    <!--begin::Custom Javascript(used for this page only)-->
    <script src="{{ asset('assets/js/custom/authentication/sign-in/general.js') }}"></script>
    <!--end::Custom Javascript-->
    <!--end::Javascript-->

    @include('layouts.js-file')
    @yield('script')
</body>
<!--end::Body-->


</html>
