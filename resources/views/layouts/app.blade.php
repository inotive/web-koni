<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>KONI Tabalong - @yield('title')</title>

    <link rel="shortcut icon" href="{{ asset('assets/img/logo-koni-simplified.png') }}" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">

    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/custom-sidebar.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet"
        type="text/css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">


    @yield('style')
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .justify {
            text-align: justify;
            line-height: 2rem;
        }

        .bg-orange {
            background-color: #FEF9EC !important;
            font-weight: bold;
        }

        .bg-orange-strong {
            background-color: #F8285A !important;
            font-weight: bold;
        }

        .border-orange {
            border-color: #F8285A !important;
        }

        .truncate {
            display: -webkit-box;
            -webkit-line-clamp: 2; /* Jumlah baris maksimal */
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 250px;
        }

        .text-orange {
            color: #F8285A !important;
        }

        .muted-hover:hover {
            color: #F8285A !important;
        }

        .percentage-option {
            transition: background-color 0.3s ease;
        }

        .percentage-option:hover {
            background-color: #FEF9EC;
        }

        .percentage-option.selected {
            background-color: #F8285A;
            color: white;
        }

        button:focus,
        button:active {
            box-shadow: none !important;
            outline: none !important;
        }

        .bootstrap-select .dropdown-toggle:focus,
        .bootstrap-select .dropdown-toggle:active,
        .bootstrap-select .dropdown-toggle {
            box-shadow: none !important;
            outline: none !important;
        }

        /* Custom container dengan max-width 1600px */
        .container-fluid-limited {
            width: 100%;
            padding-right: var(--bs-gutter-x, 0.75rem);
            padding-left: var(--bs-gutter-x, 0.75rem);
            margin-right: auto;
            margin-left: auto;
            max-width: 1150px;
        }

        .ck.ck-content.ck-editor__editable {
        white-space: pre-wrap !important;
        word-break: break-word !important;
        min-width: 0 !important; /* Fix untuk flexbox */
    }
    /* Batasi lebar parent */
    .col-12.w-100.mb-4 {
        max-width: 100%;
        overflow: hidden;
    }

    </style>
    @stack('stack-css')




</head>
<body id="kt_body" class="aside-enabled">
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
    <div class="d-flex flex-column flex-root">
        <div class="flex-row page d-flex flex-column-fluid">
            @include('layouts.sidebar')
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                @include('layouts.header')
                <div class="container-fluid-limited mt-5">
    <div class="mb-5">
        <h1 class="text-2xl font-semibold text-gray-800">@yield('breadcrumb-title')</h1>
        <nav class="text-sm mt-1" aria-label="Breadcrumb">
            <ol class="flex space-x-2 text-gray-600">
                @yield('breadcrumb-items')
            </ol>
        </nav>
    </div>
</div>
{{-- START NOTIFIKASI --}}
@if (session('success'))
    <div class="container-fluid-limited mt-0 mb-5"> {{-- Container yang sama dengan breadcrumb --}}
        <div class="alert alert-dismissible bg-light-success border border-success d-flex flex-stack flex-row p-5 rounded">
            <div class="d-flex flex-column justify-content-center flex-grow-1">
                <span class="fs-2hx text-success me-4">
                    <i class="ki-duotone ki-check-circle fs-2hx"></i> {{-- Icon Centang --}}
                </span>
            </div>
            <div class="d-flex flex-column text-success pe-0 pe-sm-10 flex-grow-1">
                <h4 class="fw-bold text-success mb-1">Success!</h4> {{-- Teks "Success!" --}}
                <span>{{ session('success') }}</span> {{-- Pesan dinamis dari controller --}}
            </div>
            <button type="button" class="position-absolute position-sm-relative top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
                <i class="ki-duotone ki-cross fs-1 text-success"></i> {{-- Icon Tutup --}}
            </button>
        </div>
    </div>
@endif

@if (session('error'))
    <div class="container-fluid-limited mt-0 mb-5"> {{-- Container yang sama dengan breadcrumb --}}
        <div class="alert alert-dismissible bg-light-danger border border-danger d-flex flex-stack flex-row p-5 rounded">
            <div class="d-flex flex-column justify-content-center flex-grow-1">
                <span class="fs-2hx text-danger me-4">
                    <i class="ki-duotone ki-triangle-exclamation fs-2hx"></i> {{-- Icon Exclamation untuk error --}}
                </span>
            </div>
            <div class="d-flex flex-column text-danger pe-0 pe-sm-10 flex-grow-1">
                <h4 class="fw-bold text-danger mb-1">Error!</h4>
                <span>{{ session('error') }}</span>
            </div>
            <button type="button" class="position-absolute position-sm-relative top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
                <i class="ki-duotone ki-cross fs-1 text-danger"></i>
            </button>
        </div>
    </div>
@endif
{{-- END NOTIFIKASI --}}
                @yield('content')
                @include('layouts.footer')
                </div>
            </div>
        </div>
    <div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
        <i class="ki-duotone ki-arrow-up">
            <span class="path1"></span>
            <span class="path2"></span>
        </i>
    </div>
    @include('layouts.js-file')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // let myDropzone = '';
        // let cliendId = 0;
    </script>
    @stack('modal')
    @yield('script')
    @stack('stack-script')

<script src="https://unpkg.com/lucide@latest"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        lucide.createIcons();
    });
</script>



</body>
</html>