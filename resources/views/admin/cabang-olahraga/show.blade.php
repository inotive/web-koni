@extends('layouts.app')
@section('title', 'Detail Cabang Olahraga')

{{-- Menggunakan pola yang sama seperti index --}}
@section('pageTitle', 'Detail ' . $cabor->nama_cabor)
@section('mainSection', 'Konfigurasi')
@section('currentSection', 'Detail Cabang Olahraga ' . $cabor->nama_cabor)

{{-- Hapus bagian breadcrumb-title dan breadcrumb-items karena sudah ditangani oleh layout --}}

@section('content')
    <style>
        /* Base Styles - Consistent with paste 1 */
        body {
            background-color: #f5f5f5;
        }

        .main-content {
            background-color: #f5f5f5;
            min-height: 100vh;
            padding: 20px 0;
        }

        /* Card Styles - UPDATED TO MATCH PASTE 1 */
        .card {
    background-color: white;
    border-radius: 12px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
    border: 1px solid #e9ecef;
    overflow: hidden !important; /* <-- Ubah ini */
}

        .card-body {
            padding: 0;
            overflow: visible !important;
        }


        /* Page Header */
        .page-header {
            background-color: transparent;
            padding: 0;
            margin-bottom: 20px;
        }

        .page-header h3 {
            color: #2c3e50;
            font-size: 1.8rem;
            font-weight: 700;
        }

        /* Buttons */
        .btn-add-pelatih {
            background: linear-gradient(135deg, #F8285A 0%, #e91e63 100%);
            border: none;
            border-radius: 8px;
            padding: 12px 24px;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(248, 40, 90, 0.3);
        }

        .btn-add-pelatih:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(248, 40, 90, 0.4);
        }

        /* Table Container - UPDATED TO MATCH PASTE 1 */
        .table-container {
            background-color: white;
            border-radius: 0px 0px 12px 12px;
            overflow: hidden;
        }

        /* Table Header - UPDATED TO MATCH PASTE 1 */
        .table-header {
            background-color: white;
            padding: 20px 25px;
            border-bottom: 1px solid #e9ecef;
            border-radius: 12px 12px 0px 0px;
            overflow: visible !important;
            position: relative;
            z-index: 10;
        }

        /* Card Header - UPDATED TO MATCH PASTE 1 */
        .card-header {
            background-color: white;
            padding: 20px 25px;
            border-bottom: 1px solid #e9ecef;
            border-radius: 12px 12px 0px 0px;
            overflow: visible !important;
            position: relative;
            z-index: 10;
        }

        .table-footer {
            background-color: white;
            padding: 15px 25px;
            border-top: 1px solid #e9ecef;
        }

        /* Table Responsive */
        .table-responsive {
            overflow-x: auto;
            overflow-y: visible;
            -webkit-overflow-scrolling: touch;
            border-radius: 8px;
            border: 1px solid #e9ecef;
            background-color: white;
        }

        /* Table Base Styles */
        .table {
            border-collapse: separate !important;
            border-spacing: 0 !important;
            margin: 0 !important;
            background-color: white;
            width: 100%;
            min-width: 1200px;
            border: none;
        }

        /* Table Header Styles with Sort Fix */
        .table thead th {
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
            border-top: none;
            font-weight: 600;
            font-size: 0.875rem;
            color: #495057;
            white-space: nowrap;
            padding: 12px 8px !important;
            position: relative;
            text-align: center !important;
        }

        .table thead th:last-child {
            border-right: none;
        }

        /* Sort Link Styles - NEW */
        .table thead th .sort-link {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            text-decoration: none;
            color: inherit;
            gap: 8px;
        }

        .table thead th .sort-link:hover {
            text-decoration: none;
            color: inherit;
        }

        .table thead th .sort-link i {
            flex-shrink: 0;
            margin-left: auto;
        }

        /* Table Body Styles */
        .table tbody tr {
            border: 1px solid #e9ecef;
            transition: background-color 0.2s ease;
        }

        .table tbody tr:first-child {
            border-top: none;
        }

        .table tbody tr:last-child {
            border-bottom: none;
        }

        .table tbody tr:hover,
        .table tbody tr:hover td {
            background-color: #f8f9fa;
        }

        .table tbody tr td {
            border: 1px solid #e9ecef !important;
            padding: 8px !important;
            font-size: 0.875rem;
            white-space: nowrap;
            vertical-align: middle;
            word-wrap: break-word;
            max-width: 200px;
            text-align: left !important;
            background-color: white;
        }

        .table tbody tr td:last-child {
            border-right: none !important;
        }

        /* Column Widths and Alignments */
        .table td:first-child,
        .table th:first-child {
            padding-left: 20px !important;
            padding-right: 20px !important;
        }

        .table td:last-child,
        .table th:last-child {
            padding-right: 12px !important;
        }

        /* Specific column widths for 10 columns */
        .table th:nth-child(1), .table td:nth-child(1) { width: 40px; text-align: center !important; }
        .table th:nth-child(2), .table td:nth-child(2) { width: 80px; text-align: center !important; }
        .table th:nth-child(3), .table td:nth-child(3) { width: 150px; text-align: left !important; }
        .table th:nth-child(4), .table td:nth-child(4) { width: 200px; text-align: left !important; }
        .table th:nth-child(5), .table td:nth-child(5) { width: 200px; text-align: left !important; }
        .table th:nth-child(6), .table td:nth-child(6) { width: 120px; text-align: center !important; }
        .table th:nth-child(7), .table td:nth-child(7) { width: 80px; text-align: center !important; }
        .table th:nth-child(8), .table td:nth-child(8) { width: 180px; text-align: left !important; }
        .table th:nth-child(9), .table td:nth-child(9) { width: 150px; text-align: left !important; }
        .table th:nth-child(10), .table td:nth-child(10) { width: 100px; text-align: center !important; }

        /* Center alignment for specific columns */
        .table td:nth-child(1),
        .table td:nth-child(2),
        .table td:nth-child(6),
        .table td:nth-child(7),
        .table td:nth-child(10) {
            text-align: center !important;
        }

        /* Utility Classes - Including ellipsis from paste 1 */
        .text-truncate-custom {
            max-width: 120px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* Ellipsis for specific columns */
        .table td:nth-child(3) span,
        .table td:nth-child(4) div,
        .table td:nth-child(5) span,
        .table td:nth-child(8) span,
        .table td:nth-child(9) div {
            display: block;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* Specific ellipsis widths */
        .table td:nth-child(3) span { max-width: 140px; } /* Nama */
        .table td:nth-child(4) div { max-width: 180px; } /* Tempat Lahir */
        .table td:nth-child(5) span { max-width: 180px; } /* Alamat */
        .table td:nth-child(8) span { max-width: 160px; } /* Prestasi */
        .table td:nth-child(9) .text-gray-600 { max-width: 140px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; } /* Email */

        .text-bronze {
            color: #CD7F32 !important;
        }

        .object-fit-cover {
            object-fit: cover;
        }

        .badge-circle {
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            color: #6c757d;
            padding: 60px 25px;
            background-color: white;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            margin: 20px;
        }

        /* Form Controls */
        .form-select {
            border-radius: 6px;
            border: 1px solid #dee2e6;
            transition: all 0.2s ease;
        }

        .form-select:focus {
            border-color: #F8285A;
            box-shadow: 0 0 0 0.2rem rgba(248, 40, 90, 0.25);
        }

        .btn-outline-secondary:hover {
            background-color: #f5f5f5;
            border-color: #f5f5f5;
        }

        /* Dropdowns */
        .dropdown-menu {
            border: none;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            border-radius: 8px;
            z-index: 1050 !important;
            position: absolute !important;
        }

        /* Pagination - Added from paste 1 */
        .pagination {
            margin-bottom: 0;
        }

        .pagination .page-item {
            margin: 0 1px;
        }

        .pagination-sm .page-link {
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
            border-radius: 4px;
            border: 1px solid #dee2e6;
            color: #6c757d;
            margin: 0 2px;
        }

        .pagination-sm .page-item.active .page-link {
            background-color: #F8285A;
            border-color: #F8285A;
            color: white;
        }

        .pagination-sm .page-link:hover {
            background-color: #f8f9fa;
            border-color: #dee2e6;
            color: #495057;
        }

        .pagination-sm .page-item.disabled .page-link {
            color: #6c757d;
            background-color: #fff;
            border-color: #dee2e6;
        }

        /* Gaya Tab Baru - Kotak Penuh */
        .nav-tabs .nav-link {
            border: none !important;
            border-radius: 8px !important;
            padding: 0.75rem 1.5rem !important;
            margin-right: 0.5rem !important;
            color: #6c757d !important;
            background-color: #f8f9fa !important;
            transition: all 0.3s ease !important;
            position: relative;
            display: flex;
            align-items: center;
        }

        .nav-tabs .nav-link.active {
            background-color: #4772f4 !important;
            color: white !important;
            box-shadow: 0 4px 8px rgba(71, 114, 244, 0.2);
        }

        .nav-tabs .nav-link:hover:not(.active) {
            background-color: #e9ecef !important;
            color: #495057 !important;
        }

        .nav-tabs .nav-link i {
            margin-right: 8px;
            font-size: 1.2rem;
        }

        .nav-tabs .nav-link .badge {
            margin-left: 8px;
            font-weight: 500;
        }

        .nav-tabs .nav-link.active .badge {
            background-color: rgba(255, 255, 255, 0.2) !important;
            color: white !important;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        /* Menu positioning fix */
        .menu.menu-sub {
            border: none !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15) !important;
            border-radius: 8px !important;
            z-index: 1055 !important;
        }

        /* Responsive Styles - Enhanced from paste 1 */
        @media (max-width: 768px) {
            .card-header,
            .table-header {
                padding: 15px;
            }

            .d-flex.justify-content-between.align-items-center.flex-wrap {
                flex-direction: column;
                gap: 15px;
            }

            .d-flex.align-items-center.gap-2.flex-wrap {
                justify-content: center;
                width: 100%;
            }

            .table-responsive {
                border-radius: 6px;
            }

            .table thead th,
            .table tbody tr td {
                padding: 8px 6px !important;
                font-size: 0.8rem;
            }

            .page-heading {
                font-size: 1.5rem !important;
                text-align: center;
            }

            .nav-tabs {
                border-bottom: 1px solid #e4e6ea;
                overflow-x: auto;
                flex-wrap: nowrap !important;
            }

            .nav-tabs .nav-link {
                padding: 0.75rem 1rem !important;
                white-space: nowrap;
                font-size: 0.875rem;
                margin-right: 0.25rem !important;
            }

            .nav-tabs .nav-link i {
                font-size: 1rem;
                margin-right: 6px;
            }

            /* Mobile responsive untuk search dan filter */
            .card-toolbar .d-flex {
                flex-direction: column;
                align-items: stretch !important;
                gap: 0.75rem;
            }

            .card-toolbar .d-flex .position-relative {
                width: 100% !important;
            }

            .card-toolbar .d-flex .form-control {
                width: 100% !important;
            }

            .card-header {
                padding: 15px !important;
                flex-direction: column;
                align-items: stretch !important;
                gap: 1rem;
            }

            .card-title {
                margin-bottom: 0;
                text-align: center;
            }

            /* Header button styling */
            .btn.btn-light-primary {
                width: 100%;
                justify-content: center;
                margin-bottom: 1rem;
            }

            /* Text alignment fixes for mobile */
            .text-muted.fs-6.mt-2 {
                text-align: center;
                flex-direction: column;
                align-items: center;
            }

            .text-muted.fs-6.mt-2 span {
                display: block;
                margin: 0.25rem 0;
            }

            .d-flex.justify-content-between.align-items-center.flex-wrap {
                flex-direction: column;
                gap: 1rem;
                align-items: center !important;
            }

            .d-flex.align-items-center.gap-3 {
                flex-direction: column;
                gap: 0.5rem !important;
            }
        }

        @media (max-width: 576px) {
            .page-heading {
                font-size: 1.25rem !important;
            }

            .table-responsive {
                font-size: 0.875rem;
            }

            .symbol {
                width: 40px !important;
                height: 40px !important;
            }

            .btn-sm {
                padding: 0.375rem 0.5rem;
                font-size: 0.75rem;
            }

            .card-header {
                padding: 12px !important;
            }

            .nav-tabs .nav-link {
                padding: 0.5rem 0.75rem !important;
                font-size: 0.8rem;
            }

            .text-muted {
                font-size: 0.875rem;
            }

            /* Better mobile spacing */
            .container-fluid {
                padding: 0.5rem;
            }

            .mb-6 {
                margin-bottom: 1rem !important;
            }

            .pagination-sm .page-link {
                padding: 0.2rem 0.4rem;
                font-size: 0.7rem;
            }
        }

        /* Additional responsive fixes for header */
        @media (max-width: 992px) {
            .d-flex.justify-content-between.align-items-center.mb-6 {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
            }

            .flex-shrink-0.me-3 {
                margin-right: 0 !important;
                width: 100%;
            }

            .flex-grow-1 {
                width: 100%;
            }

            .btn.btn-light-primary {
                width: auto;
                min-width: 120px;
            }
        }

        /* Ensure proper horizontal scrolling for table */
        .table-responsive {
            -webkit-overflow-scrolling: touch;
            overflow-x: auto;
        }

        /* Better alignment for search and filter */
        .card-toolbar .d-flex.align-items-center {
            gap: 0.75rem;
        }

        /* Ellipsis utility classes */
        .text-ellipsis {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .text-ellipsis-2-lines {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Loading States - Added from paste 1 */
        .loading-spinner {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 10;
        }

        .table-loading {
            position: relative;
            opacity: 0.7;
            pointer-events: none;
        }

        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
        }

        /* Toast Notifications - Added from paste 1 */
        .notification-toast {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            min-width: 300px;
        }

        .toast-success { background-color: #51a351; color: white; }
        .toast-error { background-color: #bd362f; color: white; }
        .toast-warning { background-color: #f89406; color: white; }
        .toast-info { background-color: #2f96b4; color: white; }
    </style>

    <div class="container-fluid">
        {{-- Header Section --}}
        <div class="d-flex justify-content-between align-items-center mb-6">
            <div class="flex-shrink-0 me-3">
                <a href="{{ route('admin.konfigurasi.cabang-olahraga.index') }}" class="btn btn-light-primary">
                    <i class="ki-duotone ki-arrow-left fs-2">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    Kembali
                </a>
            </div>
            <div class="flex-grow-1">
                <h1 class="page-heading d-flex text-dark fw-bold fs-1 my-0 align-items-center justify-content-center justify-content-md-start">
                    {{-- Tampilkan icon jika ada --}}
                    @if ($cabor->icon_cabor)
                        <div class="symbol symbol-40px me-3">
                            <img src="{{ asset('storage/' . $cabor->icon_cabor) }}" alt="{{ $cabor->nama_cabor }}"
                                class="rounded">
                        </div>
                    @else
                        <i class="ki-duotone ki-sport fs-1 text-primary me-3">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    @endif
                    <span class="text-ellipsis">Detail {{ $cabor->nama_cabor }}</span>
                </h1>
                {{-- Info tambahan --}}
                <div class="text-muted fs-6 mt-2 d-flex flex-wrap justify-content-center justify-content-md-start">
                    <span class="me-3 mb-1">
                        <i class="ki-duotone ki-user fs-6 me-1"></i>
                        <span class="text-ellipsis d-inline-block" style="max-width: 150px;">
                            PJ: {{ $cabor->ketua_penanggung_jawab }}
                        </span>
                    </span>
                    <span class="me-3 mb-1">
                        <i class="ki-duotone ki-calendar fs-6 me-1"></i>
                        Dibentuk: {{ \Carbon\Carbon::parse($cabor->tanggal_pembentukan)->format('d M Y') }}
                    </span>
                    <span class="badge badge-{{ $cabor->status === 'Aktif' ? 'success' : 'danger' }} mb-1">
                        {{ $cabor->status }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Main Card --}}
        <div class="card">
            <div class="card-header border-0">
                <div class="card-title w-100">
                    <div class="nav nav-tabs nav-line-tabs nav-stretch fs-6 border-0 overflow-auto flex-nowrap">
                        <div class="nav-item flex-shrink-0">
                            <a class="nav-link active fw-bold" data-bs-toggle="tab" href="#kt_tab_pane_atlet">
                                <i class="ki-duotone ki-people fs-2 me-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                    <span class="path4"></span>
                                    <span class="path5"></span>
                                </i>
                                <span class="d-none d-sm-inline">Informasi </span>Atlet
                                <span class="badge badge-light-primary ms-2">{{ $atlets->total() ?? 0 }}</span>
                            </a>
                        </div>
                        <div class="nav-item flex-shrink-0">
                            <a class="nav-link fw-bold" data-bs-toggle="tab" href="#kt_tab_pane_pelatih">
                                <i class="ki-duotone ki-teacher fs-2 me-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                <span class="d-none d-sm-inline">Informasi </span>Pelatih
                                <span class="badge badge-light-success ms-2">{{ $pelatihs->total() ?? 0 }}</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="tab-content">
                    {{-- Tab Atlet --}}
                    <div class="tab-pane fade show active" id="kt_tab_pane_atlet" role="tabpanel">
                        @if ($atlets->count() > 0)
                            {{-- Search dan Filter Atlet --}}
                            <div class="table-header">
                                <div class="card-title">
                                    <h3 class="fw-bold">Data Atlet</h3>
                                </div>
                                <div class="card-toolbar">
                                    <div class="d-flex justify-content-end align-items-center flex-wrap"
                                        data-kt-user-table-toolbar="base">
                                        {{-- Search Input --}}
                                        <div class="d-flex align-items-center position-relative me-3 mb-2 mb-md-0">
                                            <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                            <input type="text" id="search-atlet"
                                                class="form-control form-control-solid w-250px ps-13"
                                                placeholder="Cari atlet..." />
                                        </div>
                                        {{-- Filter Button --}}
                                        <button type="button" class="btn btn-light-primary" data-kt-menu-trigger="click"
                                            data-kt-menu-placement="bottom-end">
                                            <i class="ki-duotone ki-filter fs-2">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                            Filter
                                            <span id="filter-count-atlet"
                                                class="badge badge-light-danger d-none ms-2">0</span>
                                        </button>
                                        <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-kt-menu="true">
                                            <div class="px-7 py-5">
                                                <div class="fs-5 text-dark fw-bold">Filter Atlet</div>
                                            </div>
                                            <div class="separator border-gray-200"></div>
                                            <div class="px-7 py-5">
                                                <div class="mb-10">
                                                    <label class="form-label fw-semibold">Jenis Kelamin:</label>
                                                    <select id="filter-jenis-kelamin-atlet"
                                                        class="form-select form-select-solid fw-bold">
                                                        <option value="">Semua</option>
                                                        <option value="laki-laki">Laki-laki</option>
                                                        <option value="perempuan">Perempuan</option>
                                                    </select>
                                                </div>
                                                <div class="d-flex justify-content-end">
                                                    <button type="button" id="reset-filters-atlet"
                                                        class="btn btn-light btn-active-light-primary fw-bold me-2 px-6">Reset</button>
                                                    <button type="button" id="apply-filters-atlet"
                                                        class="btn btn-primary fw-bold px-6">Terapkan</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="table-container">
                                <div class="table-responsive">
                                    <table class="table table-row-dashed table-row-gray-300 gy-7 mb-0">
                                        <thead>
                                            <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                                <th class="min-w-50px ps-6">No</th>
                                                <th class="min-w-80px">Foto</th>
                                                <th class="min-w-150px">Nama Atlet</th>
                                                <th class="min-w-200px">Tempat & Tanggal Lahir</th>
                                                <th class="min-w-200px">Alamat Domisili</th>
                                                <th class="min-w-120px">Jenis Kelamin</th>
                                                <th class="min-w-80px">Usia</th>
                                                <th class="min-w-180px">Prestasi</th>
                                                <th class="min-w-150px">Kontak</th>
                                                <th class="min-w-100px text-end pe-6">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($atlets as $index => $atlet)
                                                <tr>
                                                    <td class="ps-6">
                                                        <span class="text-gray-800 fw-bold">
                                                            {{ ($atlets->currentPage() - 1) * $atlets->perPage() + $index + 1 }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            @if ($atlet->foto)
                                                                <div class="symbol symbol-50px">
                                                                    <img src="{{ asset('storage/' . $atlet->foto) }}"
                                                                        alt="Foto {{ $atlet->nama }}"
                                                                        class="rounded object-fit-cover">
                                                                </div>
                                                            @else
                                                                <div class="symbol symbol-50px">
                                                                    <div class="symbol-label bg-light-primary text-primary">
                                                                        <i class="ki-duotone ki-user fs-2">
                                                                            <span class="path1"></span>
                                                                            <span class="path2"></span>
                                                                        </i>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="text-gray-800 fw-bold text-ellipsis">{{ $atlet->nama ?? '-' }}</span>
                                                    </td>
                                                    <td>
                                                        <div class="text-gray-800 fw-semibold">
                                                            <div class="text-ellipsis">{{ $atlet->tempat_lahir ?? '-' }}</div>
                                                            <div class="text-muted fs-7">
                                                                {{ isset($atlet->tanggal_lahir) ? \Carbon\Carbon::parse($atlet->tanggal_lahir)->translatedFormat('d M Y') : '-' }}
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-start">
                                                            <i class="ki-duotone ki-geolocation fs-5 text-muted mt-1 me-2 flex-shrink-0"></i>
                                                            <span class="text-gray-600 fs-7 text-ellipsis">
                                                                {{ $atlet->alamat ?? '-' }}
                                                            </span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="badge badge-light-info">{{ ucfirst($atlet->jenis_kelamin ?? '-') }}</span>
                                                    </td>
                                                    <td>
                                                        <span class="text-gray-800 fw-semibold">
                                                            {{ isset($atlet->tanggal_lahir) ? \Carbon\Carbon::parse($atlet->tanggal_lahir)->age . ' th' : '-' }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="text-gray-600 text-ellipsis">
                                                            {{ optional($atlet->prestasiTerbaru)->nama_prestasi ?? '-' }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex flex-column">
                                                            @if ($atlet->no_telepon)
                                                                <span class="text-gray-800 fs-7 mb-1">
                                                                    <i class="ki-duotone ki-phone fs-6 me-1">
                                                                        <span class="path1"></span>
                                                                        <span class="path2"></span>
                                                                    </i>
                                                                    {{ $atlet->no_telepon }}
                                                                </span>
                                                            @endif
                                                            @if ($atlet->email)
                                                                <span class="text-gray-600 fs-7 text-ellipsis">
                                                                    <i class="ki-duotone ki-sms fs-6 me-1">
                                                                        <span class="path1"></span>
                                                                        <span class="path2"></span>
                                                                    </i>
                                                                    {{ $atlet->email }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="text-end pe-6">
                                                        <a href="{{ route('admin.konfigurasi.atlet.show', $atlet->id) }}?back=cabor&cabor_id={{ $cabor->id }}"
                                                            class="btn btn-sm btn-light-primary">
                                                            <i class="ki-duotone ki-eye fs-5"></i>
                                                            <span class="d-none d-md-inline ms-1">Lihat Profil</span>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            {{-- Pagination untuk atlet --}}
                            @if ($atlets->hasPages())
                                <div class="table-footer">
                                    <div class="d-flex justify-content-center">
                                        {{ $atlets->appends(['pelatih_page' => $pelatihs->currentPage()])->links() }}
                                    </div>
                                </div>
                            @endif
                        @else
                            <div class="empty-state">
                                <img src="{{ asset('assets/media/illustrations/sketchy-1/2.png') }}" alt=""
                                    class="mw-400px">
                                <div class="pt-10 pb-10">
                                    <h2 class="fs-2 fw-bold text-gray-600">Belum Ada Atlet</h2>
                                    <p class="text-gray-400 fs-6 fw-semibold">
                                        Belum ada atlet yang terdaftar untuk cabang olahraga {{ $cabor->nama_cabor }}.
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- Tab Pelatih --}}
                    <div class="tab-pane fade" id="kt_tab_pane_pelatih" role="tabpanel">
                        @if ($pelatihs->count() > 0)
                            {{-- Search dan Filter Pelatih --}}
                            <div class="table-header">
                                <div class="card-title">
                                    <h3 class="fw-bold">Data Pelatih</h3>
                                </div>
                                <div class="card-toolbar">
                                    <div class="d-flex justify-content-end align-items-center flex-wrap" data-kt-user-table-toolbar="base">
                                        {{-- Search Input --}}
                                        <div class="d-flex align-items-center position-relative me-3 mb-2 mb-md-0">
                                            <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                            <input type="text" id="search-pelatih"
                                                class="form-control form-control-solid w-250px ps-13"
                                                placeholder="Cari pelatih..." />
                                        </div>

                                        {{-- Filter Button --}}
                                        <button type="button" class="btn btn-light-primary" data-kt-menu-trigger="click"
                                            data-kt-menu-placement="bottom-end">
                                            <i class="ki-duotone ki-filter fs-2">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                            Filter
                                            <span id="filter-count-pelatih" class="badge badge-light-danger d-none ms-2">0</span>
                                        </button>

                                        {{-- Dropdown Filter Pelatih --}}
                                        <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-kt-menu="true">
                                            <div class="px-7 py-5">
                                                <div class="fs-5 text-dark fw-bold">Filter Pelatih</div>
                                            </div>
                                            <div class="separator border-gray-200"></div>
                                            <div class="px-7 py-5">
                                                <div class="mb-10">
                                                    <label class="form-label fw-semibold">Jenis Kelamin:</label>
                                                    <select id="filter-jenis-kelamin-pelatih"
                                                        class="form-select form-select-solid fw-bold">
                                                        <option value="">Semua</option>
                                                        <option value="laki-laki">Laki-laki</option>
                                                        <option value="perempuan">Perempuan</option>
                                                    </select>
                                                </div>
                                                <div class="d-flex justify-content-end">
                                                    <button type="button" id="reset-filters-pelatih"
                                                        class="btn btn-light btn-active-light-primary fw-bold me-2 px-6">Reset</button>
                                                    <button type="button" id="apply-filters-pelatih"
                                                        class="btn btn-primary fw-bold px-6">Terapkan</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="table-container">
                                <div class="table-responsive">
                                    <table class="table table-row-dashed table-row-gray-300 gy-7 mb-0">
                                        <thead>
                                            <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                                <th class="min-w-50px ps-6">No</th>
                                                <th class="min-w-80px">Foto</th>
                                                <th class="min-w-150px">Nama Pelatih</th>
                                                <th class="min-w-200px">Tempat & Tanggal Lahir</th>
                                                <th class="min-w-200px">Alamat Domisili</th>
                                                <th class="min-w-120px">Jenis Kelamin</th>
                                                <th class="min-w-80px">Usia</th>
                                                <th class="min-w-180px">Prestasi</th>
                                                <th class="min-w-150px">Kontak</th>
                                                <th class="min-w-100px text-end pe-6">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($pelatihs as $index => $pelatih)
                                                <tr>
                                                    <td class="ps-6">
                                                        <span class="text-gray-800 fw-bold">
                                                            {{ ($pelatihs->currentPage() - 1) * $pelatihs->perPage() + $index + 1 }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            @if ($pelatih->foto)
                                                                <div class="symbol symbol-50px">
                                                                    <img src="{{ asset('storage/' . $pelatih->foto) }}"
                                                                        alt="Foto {{ $pelatih->nama }}"
                                                                        class="rounded object-fit-cover">
                                                                </div>
                                                            @else
                                                                <div class="symbol symbol-50px">
                                                                    <div class="symbol-label bg-light-success text-success">
                                                                        <i class="ki-duotone ki-teacher fs-2">
                                                                            <span class="path1"></span>
                                                                            <span class="path2"></span>
                                                                        </i>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="text-gray-800 fw-bold text-ellipsis">{{ $pelatih->nama ?? '-' }}</span>
                                                    </td>
                                                    <td>
                                                        <div class="text-gray-800 fw-semibold">
                                                            <div class="text-ellipsis">{{ $pelatih->tempat_lahir ?? '-' }}</div>
                                                            <div class="text-muted fs-7">
                                                                {{ isset($pelatih->tanggal_lahir) ? \Carbon\Carbon::parse($pelatih->tanggal_lahir)->translatedFormat('d M Y') : '-' }}
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-start">
                                                            <i class="ki-duotone ki-geolocation fs-5 text-muted mt-1 me-2 flex-shrink-0"></i>
                                                            <span class="text-gray-600 fs-7 text-ellipsis">
                                                                {{ $pelatih->alamat ?? '-' }}
                                                            </span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="badge badge-light-info">{{ ucfirst($pelatih->jenis_kelamin ?? '-') }}</span>
                                                    </td>
                                                    <td>
                                                        <span class="text-gray-800 fw-semibold">
                                                            {{ isset($pelatih->tanggal_lahir) ? \Carbon\Carbon::parse($pelatih->tanggal_lahir)->age . ' th' : '-' }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="text-gray-600 text-ellipsis">{{ $pelatih->prestasi_terbaru ?? '-' }}</span>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex flex-column">
                                                            @if ($pelatih->no_telepon)
                                                                <span class="text-gray-800 fs-7 mb-1">
                                                                    <i class="ki-duotone ki-phone fs-6 me-1">
                                                                        <span class="path1"></span>
                                                                        <span class="path2"></span>
                                                                    </i>
                                                                    {{ $pelatih->no_telepon }}
                                                                </span>
                                                            @endif
                                                            @if ($pelatih->email)
                                                                <span class="text-gray-600 fs-7 text-ellipsis">
                                                                    <i class="ki-duotone ki-sms fs-6 me-1">
                                                                        <span class="path1"></span>
                                                                        <span class="path2"></span>
                                                                    </i>
                                                                    {{ $pelatih->email }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="text-end pe-6">
                                                        <a href="{{ route('admin.konfigurasi.pelatih.show', $pelatih->id) }}?back=cabor&cabor_id={{ $cabor->id }}"
                                                            class="btn btn-sm btn-light-primary">
                                                            <i class="ki-duotone ki-eye fs-5">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                                <span class="path3"></span>
                                                            </i>
                                                            <span class="d-none d-md-inline ms-1">Lihat Profil</span>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            {{-- Pagination untuk pelatih --}}
                            @if ($pelatihs->hasPages())
                                <div class="table-footer">
                                    <div class="d-flex justify-content-center">
                                        {{ $pelatihs->appends(['atlet_page' => $atlets->currentPage()])->links() }}
                                    </div>
                                </div>
                            @endif
                        @else
                            <div class="empty-state">
                                <img src="{{ asset('assets/media/illustrations/sketchy-1/2.png') }}" alt=""
                                    class="mw-400px">
                                <div class="pt-10 pb-10">
                                    <h2 class="fs-2 fw-bold text-gray-600">Belum Ada Pelatih</h2>
                                    <p class="text-gray-400 fs-6 fw-semibold">
                                        Belum ada pelatih yang terdaftar untuk cabang olahraga {{ $cabor->nama_cabor }}.
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
    // Initialize Bootstrap tabs
    var triggerTabList = [].slice.call(document.querySelectorAll('.nav-tabs a'))
    triggerTabList.forEach(function(triggerEl) {
        var tabTrigger = new bootstrap.Tab(triggerEl)

        triggerEl.addEventListener('click', function(event) {
            event.preventDefault()
            tabTrigger.show()
        })
    });

    // Fungsi untuk tabel Atlet
    function initAtletFilter() {
        const atletTable = $('#kt_tab_pane_atlet table');
        const atletRows = atletTable.find('tbody tr');

        $('#search-atlet').on('keyup', function () {
            const searchText = $(this).val().toLowerCase();
            const jenisKelamin = $('#filter-jenis-kelamin-atlet').val().toLowerCase();
            filterAtletTable(searchText, jenisKelamin);
        });

        $('#apply-filters-atlet').on('click', function () {
            const searchText = $('#search-atlet').val().toLowerCase();
            const jenisKelamin = $('#filter-jenis-kelamin-atlet').val().toLowerCase();
            filterAtletTable(searchText, jenisKelamin);
            updateAtletFilterCount();
            $('[data-kt-menu="true"]').removeClass('show');
        });

        $('#reset-filters-atlet').on('click', function () {
            $('#search-atlet').val('');
            $('#filter-jenis-kelamin-atlet').val('');
            filterAtletTable('', '');
            updateAtletFilterCount();
        });

        function filterAtletTable(searchText, jenisKelamin) {
            let visibleCount = 0;
            atletRows.each(function () {
                const row = $(this);
                const text = row.text().toLowerCase().trim();
                const jk = row.find('td:nth-child(6) .badge').text().toLowerCase().trim();

                const cocokSearch = searchText === '' || text.includes(searchText);
                const cocokFilter = jenisKelamin === '' || jk.includes(jenisKelamin);

                if (cocokSearch && cocokFilter) {
                    row.show();
                    visibleCount++;
                } else {
                    row.hide();
                }
            });
            showNoResultsMessage('#kt_tab_pane_atlet', visibleCount, 'atlet');
        }

        function updateAtletFilterCount() {
            const jumlah = $('#filter-jenis-kelamin-atlet').val() ? 1 : 0;
            const badge = $('#filter-count-atlet');
            jumlah > 0 ? badge.text(jumlah).removeClass('d-none') : badge.addClass('d-none');
        }
    }
    

    // Fungsi untuk tabel Pelatih
    function initPelatihFilter() {
        const pelatihTable = $('#kt_tab_pane_pelatih table');
        const pelatihRows = pelatihTable.find('tbody tr');

        $('#search-pelatih').on('keyup', function () {
            const searchText = $(this).val().toLowerCase();
            const jenisKelamin = $('#filter-jenis-kelamin-pelatih').val().toLowerCase();
            filterPelatihTable(searchText, jenisKelamin);
        });

        $('#apply-filters-pelatih').on('click', function () {
            const searchText = $('#search-pelatih').val().toLowerCase();
            const jenisKelamin = $('#filter-jenis-kelamin-pelatih').val().toLowerCase();
            filterPelatihTable(searchText, jenisKelamin);
            updatePelatihFilterCount();
            $('[data-kt-menu="true"]').removeClass('show');
        });

        $('#reset-filters-pelatih').on('click', function () {
            $('#search-pelatih').val('');
            $('#filter-jenis-kelamin-pelatih').val('');
            filterPelatihTable('', '');
            updatePelatihFilterCount();
        });

        function filterPelatihTable(searchText, jenisKelamin) {
            let visibleCount = 0;
            pelatihRows.each(function () {
                const row = $(this);
                const text = row.text().toLowerCase().trim();
                const jk = row.find('td:nth-child(6) .badge').text().toLowerCase().trim();

                const cocokSearch = searchText === '' || text.includes(searchText);
                const cocokFilter = jenisKelamin === '' || jk.includes(jenisKelamin);

                if (cocokSearch && cocokFilter) {
                    row.show();
                    visibleCount++;
                } else {
                    row.hide();
                }
            });
            showNoResultsMessage('#kt_tab_pane_pelatih', visibleCount, 'pelatih');
        }

        function updatePelatihFilterCount() {
            const jumlah = $('#filter-jenis-kelamin-pelatih').val() ? 1 : 0;
            const badge = $('#filter-count-pelatih');
            jumlah > 0 ? badge.text(jumlah).removeClass('d-none') : badge.addClass('d-none');
        }
    }

    // Function to show/hide no results message
    function showNoResultsMessage(tabSelector, visibleCount, type) {
        const tab = $(tabSelector);
        const existingMessage = tab.find('.no-results-message');

        if (visibleCount === 0) {
            if (existingMessage.length === 0) {
                const message = `
                    <div class="no-results-message d-flex flex-column flex-center text-center p-10">
                        <div class="pt-10 pb-10">
                            <h3 class="fs-4 fw-bold text-gray-600">Tidak Ada Hasil Ditemukan</h3>
                            <p class="text-gray-400 fs-6 fw-semibold">
                                Coba ubah kata kunci pencarian atau filter yang digunakan.
                            </p>
                        </div>
                    </div>
                `;
                tab.find('.table-responsive').after(message);
            }
        } else {
            existingMessage.remove();
        }
    }

    if ($('#kt_tab_pane_atlet table tbody tr').length > 0) initAtletFilter();
    if ($('#kt_tab_pane_pelatih table tbody tr').length > 0) initPelatihFilter();

    $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
        const targetTab = $(e.target).attr('href');
        $('.no-results-message').remove();

        if (targetTab === '#kt_tab_pane_atlet') {
            $('#search-atlet').val('');
            $('#filter-jenis-kelamin-atlet').val('');
            $('#filter-count-atlet').addClass('d-none');
            $('#kt_tab_pane_atlet table tbody tr').show();
        } else if (targetTab === '#kt_tab_pane_pelatih') {
            $('#search-pelatih').val('');
            $('#filter-jenis-kelamin-pelatih').val('');
            $('#filter-count-pelatih').addClass('d-none');
            $('#kt_tab_pane_pelatih table tbody tr').show();
        }
    });

    $(document).on('click', function (e) {
        if (!$(e.target).closest('[data-kt-menu-trigger]').length &&
            !$(e.target).closest('[data-kt-menu="true"]').length) {
            $('[data-kt-menu="true"]').removeClass('show');
        }
    });
});
    </script>

    <style>
        /* Additional responsive styles */
        @media (max-width: 768px) {
            .d-flex.justify-content-between {
                flex-direction: column;
                align-items: stretch !important;
                gap: 1rem;
            }

            .page-heading {
                font-size: 1.5rem !important;
            }

            .nav-tabs {
                border-bottom: 1px solid #e4e6ea;
            }

            .nav-tabs .nav-link {
                padding: 0.75rem 1rem;
                white-space: nowrap;
            }

            /* Mobile responsive untuk search dan filter */
            .card-toolbar .d-flex {
                flex-direction: column;
                align-items: stretch !important;
                gap: 0.75rem;
            }

            .card-toolbar .d-flex .position-relative {
                width: 100% !important;
            }

            .card-toolbar .d-flex .form-control {
                width: 100% !important;
            }
        }

        @media (max-width: 576px) {
            .page-heading {
                font-size: 1.25rem !important;
            }

            .table-responsive {
                font-size: 0.875rem;
            }

            .symbol {
                width: 40px !important;
                height: 40px !important;
            }

            .btn-sm {
                padding: 0.375rem 0.5rem;
            }

            .card-header {
                flex-direction: column;
                align-items: stretch !important;
                gap: 1rem;
            }

            .card-title {
                margin-bottom: 0;
            }
        }

        /* Ensure proper horizontal scrolling for table */
        .table-responsive {
            -webkit-overflow-scrolling: touch;
            overflow-x: auto;
        }

        /* Fix for long text overflow */
        .text-truncate {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* Better alignment for search and filter */
        .card-toolbar .d-flex.align-items-center {
            gap: 0.75rem;
        }
    </style>
@endsection
