@extends('layouts.app')

@section('pageTitle', 'Database Bendahara')
@section('mainSection', 'Main Menu')
@section('currentSection', 'Database Bendahara')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@section('style')
    <style>

        .preview:hover {
            background-color: #F4EEFF !important;
        }

        .edit:hover {
            background-color: rgb(249, 245, 172) !important;
        }

        .delete:hover {
            background-color: #ffcad7ff !important;
        }

        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Enhanced search and filter styling */
        .filter-container {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .search-container {
            position: relative;
            width: 180px;
        }

        .search-input {
            padding-left: 45px !important;
        }

        .search-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            pointer-events: none;
            z-index: 10;
        }

        /* Filter dropdown styling */
        .filter-dropdown {
            position: relative;
            width: 200px;
        }

        .filter-btn {
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 8px 16px;
            font-size: 0.95rem;
            color: #495057;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            text-align: left;
        }

        .filter-btn:hover {
            border-color: #F8285A;
            color: #F8285A;
        }

        .filter-btn.filter-active {
            background-color: #F8285A;
            border-color: #F8285A;
            color: white;
        }

        .filter-menu {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            z-index: 1000;
            margin-top: 4px;
            display: none;
        }

        .filter-menu.show {
            display: block;
        }

        .filter-option {
            padding: 12px 16px;
            cursor: pointer;
            transition: background-color 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #f8f9fa;
        }

        .filter-option:last-child {
            border-bottom: none;
        }

        .filter-option:hover {
            background-color: #f8f9fa;
        }

        .filter-option.active {
            background-color: #F8285A;
            color: white;
        }

        .filter-option .file-type-icon {
            margin-right: 8px;
            font-size: 16px;
        }

        .filter-option .filter-count {
            font-size: 0.85rem;
            opacity: 0.8;
        }

        /* Search highlight */
        .search-highlight {
            background-color: #fff3cd;
            padding: 1px 3px;
            border-radius: 3px;
            font-weight: bold;
        }

        /* File type badges with consistent colors */
        .badge-danger { background-color: #dc3545 !important; }
        .badge-success { background-color: #198754 !important; }
        .badge-secondary { background-color: #6c757d !important; }

        /* Loading state */
        .table-loading {
            opacity: 0.6;
            pointer-events: none;
        }

        /* Dropdown action styles from surat */
        .dropdown-action {
            position: relative;
            display: inline-block;
        }

        .dropdown-toggle-custom {
            background: none;
            border: none;
            cursor: pointer;
            padding: 5px;
            border-radius: 4px;
            transition: all 0.2s ease;
            position: relative;
        }

        .dropdown-toggle-custom:hover {
            background-color: rgba(0, 0, 0, 0.05);
            transform: scale(1.05);
        }

        /* Add loading state for hover delay */
        .dropdown-action.loading .dropdown-toggle-custom::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 16px;
            height: 16px;
            border: 2px solid transparent;
            border-top: 2px solid rgba(27, 132, 255, 0.3);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            pointer-events: none;
        }

        @keyframes spin {
            0% { transform: translate(-50%, -50%) rotate(0deg); }
            100% { transform: translate(-50%, -50%) rotate(360deg); }
        }

        .dropdown-menu-custom {
            position: absolute;
            right: 0;
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            min-width: 180px;
            padding: 8px 0;
            margin-top: 5px;
            display: none;
            list-style: none;
            opacity: 0;
            transform: translateY(-10px);
            transition: all 0.2s ease;
            pointer-events: none;
        }

        .dropdown-menu-custom.show {
            display: block;
            opacity: 1;
            transform: translateY(0);
            pointer-events: auto;
            animation: dropdownFadeIn 0.2s ease forwards;
        }

        @keyframes dropdownFadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Dropup style with enhanced animation */
        .dropup .dropdown-menu-custom {
            bottom: 100%;
            top: auto;
            margin-top: 0;
            margin-bottom: 5px;
            transform: translateY(10px);
        }

        .dropup .dropdown-menu-custom.show {
            transform: translateY(0);
        }

        @keyframes dropupFadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .dropup .dropdown-menu-custom.show {
            animation: dropupFadeIn 0.2s ease forwards;
        }

        .dropdown-item {
            padding: 8px 16px;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            color: #495057;
            text-decoration: none;
            font-size: 0.9rem;
            position: relative;
            overflow: hidden;
        }

        .dropdown-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 0;
            background: linear-gradient(90deg, transparent, rgba(248, 40, 90, 0.1));
            transition: width 0.3s ease;
            z-index: -1;
        }

        .dropdown-item:hover::before {
            width: 100%;
        }

        .dropdown-item i {
            margin-right: 8px;
            width: 20px;
            text-align: center;
            transition: transform 0.2s ease;
        }

        .dropdown-item:hover i {
            transform: scale(1.1);
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
            transform: translateX(2px);
        }

        .dropdown-item.preview:hover {
            background-color: #F4EEFF !important;
            color: #6f42c1;
        }

        .dropdown-item.edit:hover {
            background-color: rgb(249, 245, 172) !important;
            color: #856404;
        }

        .dropdown-item.delete:hover {
            background-color: #ffcad7 !important;
            color: #721c24;
        }

        /* Enhanced hover states for action buttons */
        .dropdown-action:hover .dropdown-toggle-custom svg {
            transition: transform 0.2s ease;
        }

        .dropdown-action:hover .dropdown-toggle-custom svg {
            transform: scale(1.1);
        }

        /* Mobile responsive adjustments */
        @media (max-width: 768px) {
            .dropdown-menu-custom {
                position: fixed;
                right: 10px;
                left: auto;
                min-width: 200px;
                max-width: calc(100vw - 20px);
            }

            .dropdown-item {
                padding: 12px 16px;
                font-size: 1rem;
            }

            /* Disable hover effects on mobile */
            .dropdown-item:hover::before {
                width: 0;
            }

            .dropdown-item:hover {
                transform: none;
            }
        }

        /* Loading state for dropdown during cooldown */
        .dropdown-action.hover-loading .dropdown-toggle-custom {
            opacity: 0.7;
        }

        .dropdown-action.hover-loading .dropdown-toggle-custom svg {
            animation: pulse 1s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        /* Fix pagination dropdown arrow */
        .per-page-select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6,9 12,15 18,9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 8px center;
            background-size: 16px;
            padding-right: 32px !important;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .filter-container {
                flex-direction: column;
                align-items: stretch;
                gap: 10px;
            }

            .search-container {
                width: 100%;
            }

            .filter-dropdown {
                width: 100%;
            }
        }

        /* File preview modal styling */
        .preview-modal .modal-dialog {
            max-width: 90vw;
            height: 90vh;
        }

        .preview-modal .modal-content {
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .preview-modal .modal-body {
            flex: 1;
            padding: 0;
            overflow: hidden;
        }

        .preview-modal iframe {
            width: 100%;
            height: 100%;
            border: none;
        }

        .preview-error {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 300px;
            text-align: center;
            color: #6c757d;
        }

        .preview-error i {
            font-size: 4rem;
            margin-bottom: 1rem;
            color: #dc3545;
        }

        /* Loading button states */
        .btn-loading {
            position: relative;
            pointer-events: none;
            opacity: 0.7;
        }

        .btn-loading::after {
            content: '';
            position: absolute;
            width: 16px;
            height: 16px;
            top: 50%;
            left: 50%;
            margin-left: -8px;
            margin-top: -8px;
            border: 2px solid transparent;
            border-top-color: currentColor;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Error input styling */
        .form-control.is-invalid {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
        }

        .invalid-feedback {
            display: block;
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        /* Pagination styling */
        .pagination-arrow {
            color: #6c757d;
            text-decoration: none;
            padding: 6px 8px;
            transition: color 0.2s ease;
            cursor: pointer;
        }

        .pagination-arrow:hover {
            color: #0b0b0b;
            text-decoration: none;
        }

        .pagination-arrow.disabled {
            color: #adb5bd;
            cursor: not-allowed;
            opacity: 0.6;
        }

        .pagination-number {
            color: #6c757d;
            text-decoration: none;
            padding: 6px 10px;
            margin: 0 1px;
            border-radius: 4px;
            transition: all 0.2s ease;
            background-color: #f8f9fa;
            border: 1px solid transparent;
            font-size: 0.875rem;
        }

        .pagination-number:hover {
            color: #89add1;
            background-color: #e9ecef;
            text-decoration: none;
        }

        .pagination-number.active {
            background-color: #e4e6e9;
            color: rgb(4, 4, 4);
            border-color: #e0e1e4;
        }

        .date-filter-dropdown {
            position: relative;
            width: auto;
        }

        .date-filter-btn {
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 8px 12px;
            font-size: 0.95rem;
            color: #495057;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 44px;
            height: 38px;
        }

        .date-filter-btn:hover {
            border-color: #F8285A;
            color: #F8285A;
        }

        .date-filter-btn.date-filter-active {
            background-color: #F8285A;
            border-color: #F8285A;
            color: white;
        }

        .date-filter-menu {
            position: absolute;
            top: 100%;
            right: 0;
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            z-index: 1000;
            margin-top: 4px;
            display: none;
            min-width: 300px;
            padding: 16px;
        }

        .date-filter-menu.show {
            display: block;
        }

        .date-filter-header {
            font-weight: 600;
            font-size: 0.95rem;
            color: #495057;
            margin-bottom: 16px;
            text-align: center;
        }

        .date-range-container {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .date-input-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .date-input-label {
            font-size: 0.85rem;
            font-weight: 500;
            color: #6c757d;
        }

        .date-input {
            padding: 8px 12px;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            font-size: 0.9rem;
            transition: border-color 0.2s ease;
        }

        .date-input:focus {
            outline: none;
            border-color: #F8285A;
            box-shadow: 0 0 0 0.2rem rgba(248, 40, 90, 0.25);
        }

        .date-filter-actions {
            display: flex;
            gap: 8px;
            margin-top: 16px;
            padding-top: 16px;
            border-top: 1px solid #f8f9fa;
        }

        .date-filter-btn-action {
            flex: 1;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            border: none;
        }

        .date-filter-reset {
            background-color: #f8f9fa;
            color: #6c757d;
        }

        .date-filter-reset:hover {
            background-color: #e9ecef;
        }

        .date-filter-apply {
            background-color: #F8285A;
            color: white;
        }

        .date-filter-apply:hover {
            background-color: #d91e4a;
        }

        /* Quick date presets */
        .date-presets {
            margin-bottom: 16px;
            padding-bottom: 16px;
            border-bottom: 1px solid #f8f9fa;
        }

        .date-presets-label {
            font-size: 0.85rem;
            font-weight: 500;
            color: #6c757d;
            margin-bottom: 8px;
        }

        .date-preset-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }

        .date-preset-btn {
            padding: 4px 12px;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 16px;
            font-size: 0.8rem;
            color: #6c757d;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .date-preset-btn:hover {
            background-color: #e9ecef;
            border-color: #adb5bd;
        }

        .date-preset-btn.active {
            background-color: #F8285A;
            border-color: #F8285A;
            color: white;
        }
    </style>
@endsection

@section('content')
    <div class="d-grid gap-5 border-0">
        <div class="d-flex justify-content-between align-items-center container">
            <div class="d-none d-md-block">
                <h1>Database Bendahara</h1>
                <span>Kelola laporan bendahara</span>
            </div>
            <form id="filter" class="d-flex gap-3 filter-container">
                <button type="button" data-bs-toggle="modal" data-bs-target="#add"
                    class="btn btn-active-light-danger d-flex bg-danger align-items-center btn-facebook fw-bold gap-2 rounded border-0 px-4 py-2 text-white">
                    Tambah Laporan
                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_851_8468)">
                            <path
                                d="M12.3782 17.0625H5.61375C4.37344 17.0582 3.18528 16.5631 2.309 15.6853C1.43272 14.8075 0.939624 13.6185 0.9375 12.3782V5.62182C0.939624 4.38151 1.43272 3.19249 2.309 2.3147C3.18528 1.43692 4.37344 0.941767 5.61375 0.937507H12.3701C12.9853 0.936447 13.5946 1.05656 14.1633 1.29099C14.7321 1.52542 15.2491 1.86958 15.6848 2.30381C16.1205 2.73804 16.4664 3.25384 16.7028 3.82176C16.9392 4.38968 17.0614 4.9986 17.0625 5.61375V12.3701C17.0636 12.986 16.9432 13.596 16.7082 14.1652C16.4733 14.7345 16.1284 15.2518 15.6933 15.6876C15.2583 16.1235 14.7415 16.4692 14.1727 16.7052C13.6038 16.9411 12.994 17.0625 12.3782 17.0625ZM13.0312 8.19375H9.80625V4.96876C9.80625 4.75492 9.7213 4.54985 9.5701 4.39865C9.4189 4.24745 9.21383 4.16251 9 4.16251C8.78617 4.16251 8.58109 4.24745 8.42989 4.39865C8.27869 4.54985 8.19375 4.75492 8.19375 4.96876V8.19375H4.96875C4.75492 8.19375 4.54984 8.2787 4.39864 8.4299C4.24744 8.5811 4.1625 8.78617 4.1625 9C4.1625 9.21383 4.24744 9.41891 4.39864 9.57011C4.54984 9.72131 4.75492 9.80625 4.96875 9.80625H8.19375V13.0313C8.19375 13.2451 8.27869 13.4502 8.42989 13.6014C8.58109 13.7526 8.78617 13.8375 9 13.8375C9.21383 13.8375 9.4189 13.7526 9.5701 13.6014C9.7213 13.4502 9.80625 13.2451 9.80625 13.0313V9.80625H13.0312C13.2451 9.80625 13.4501 9.72131 13.6013 9.57011C13.7526 9.41891 13.8375 9.21383 13.8375 9C13.8375 8.78617 13.7526 8.5811 13.6013 8.4299C13.4501 8.2787 13.2451 8.19375 13.0312 8.19375Z"
                                fill="white" />
                        </g>
                        <defs>
                            <clipPath id="clip0_851_8468">
                                <rect width="18" height="18" fill="white" />
                            </clipPath>
                        </defs>
                    </svg>
                </button>

                <!-- Enhanced Search Container -->
                <div class="search-container">
                    <div class="position-relative bg-light">
                        <i class="ki-outline ki-magnifier fs-2 search-icon"></i>
                        <input type="text" name="search" value="{{ request('search') }}" data-kt-docs-table-filter="search"
                            placeholder="Cari Laporan" class="form-control border border-gray-500 py-2 search-input" />
                    </div>
                </div>

                <!-- Enhanced Filter Dropdown -->
                <div class="filter-dropdown">
                    <div class="filter-btn {{ (request('filter_type') && request('filter_type') != 'all') ? 'filter-active' : '' }}" id="filterBtn">
                        <span>
                            @if(request('filter_type') == 'pdf')
                                <i class="fas fa-file-pdf me-2" style="color: #dc3545;"></i>File PDF
                            @elseif(request('filter_type') == 'excel')
                                <i class="fas fa-file-excel me-2" style="color: #198754;"></i>File Excel
                            @elseif(request('filter_type') == 'other')
                                <i class="fas fa-file me-2" style="color: #6c757d;"></i>File Lain
                            @else
                                <i class="fas fa-filter me-2"></i>Filter Tipe File
                            @endif
                        </span>
                        <i class="fas fa-chevron-down" style="font-size: 0.8rem;"></i>
                    </div>

                    <div class="filter-menu" id="filterMenu" data-filter-counts="{{ json_encode($fileCounts ?? []) }}">
                        <div class="filter-option {{ (request('filter_type', 'all') == 'all') ? 'active' : '' }}" data-filter="all">
                            <span>
                                <i class="fas fa-list file-type-icon"></i>
                                Semua File
                            </span>
                            <span class="filter-count">{{ $fileCounts['all'] ?? 0 }}</span>
                        </div>
                        <div class="filter-option {{ (request('filter_type') == 'pdf') ? 'active' : '' }}" data-filter="pdf">
                            <span>
                                <i class="fas fa-file-pdf file-type-icon" style="color: #dc3545;"></i>
                                File PDF
                            </span>
                            <span class="filter-count">{{ $fileCounts['pdf'] ?? 0 }}</span>
                        </div>
                        <div class="filter-option {{ (request('filter_type') == 'excel') ? 'active' : '' }}" data-filter="excel">
                            <span>
                                <i class="fas fa-file-excel file-type-icon" style="color: #198754;"></i>
                                File Excel
                            </span>
                            <span class="filter-count">{{ $fileCounts['excel'] ?? 0 }}</span>
                        </div>
                        <div class="filter-option {{ (request('filter_type') == 'other') ? 'active' : '' }}" data-filter="other">
                            <span>
                                <i class="fas fa-file file-type-icon" style="color: #6c757d;"></i>
                                File Lain
                            </span>
                            <span class="filter-count">{{ $fileCounts['other'] ?? 0 }}</span>
                        </div>
                    </div>
                </div>

            <div class="date-filter-dropdown">
                    <div class="date-filter-btn {{ (request('date_from') || request('date_to')) ? 'date-filter-active' : '' }}" id="dateFilterBtn">
                        <i class="fa-solid fa-calendar-days"></i>
                    </div>

                    <div class="date-filter-menu" id="dateFilterMenu">
                        <div class="date-filter-header">Filter Berdasarkan Tanggal</div>

                        <!-- Quick Date Presets -->
                        <div class="date-presets">
                            <div class="date-presets-label">Preset Cepat:</div>
                            <div class="date-preset-buttons">
                                <button type="button" class="date-preset-btn" data-preset="today">Hari Ini</button>
                                <button type="button" class="date-preset-btn" data-preset="this-week">Minggu Ini</button>
                                <button type="button" class="date-preset-btn" data-preset="this-month">Bulan Ini</button>
                                <button type="button" class="date-preset-btn" data-preset="this-year">Tahun Ini</button>
                                <button type="button" class="date-preset-btn" data-preset="last-30-days">30 Hari Terakhir</button>
                            </div>
                        </div>

                        <!-- Custom Date Range -->
                        <div class="date-range-container">
                            <div class="date-input-group">
                                <label class="date-input-label">Dari Tanggal:</label>
                                <input type="date" name="date_from" id="dateFrom" class="date-input" value="{{ request('date_from') }}">
                            </div>
                            <div class="date-input-group">
                                <label class="date-input-label">Sampai Tanggal:</label>
                                <input type="date" name="date_to" id="dateTo" class="date-input" value="{{ request('date_to') }}">
                            </div>
                        </div>

                        <div class="date-filter-actions">
                            <button type="button" class="date-filter-btn-action date-filter-reset" id="resetDateFilter">Reset</button>
                            <button type="button" class="date-filter-btn-action date-filter-apply" id="applyDateFilter">Terapkan</button>
                        </div>
                    </div>
                </div>

                <!-- Hidden inputs for maintaining filter state -->
                <input type="hidden" name="filter_type" id="filter_type_input" value="{{ request('filter_type', 'all') }}">
                <input type="hidden" name="date_from" id="date_from_input" value="{{ request('date_from') }}">
                <input type="hidden" name="date_to" id="date_to_input" value="{{ request('date_to') }}">
            </form>
        </div>

        <div id="table" class="container">
            @include('admin.bendahara._table', compact('laporanBendahara', 'fileCounts'))
        </div>

        <!-- Add Modal -->
        <div class="modal fade" id="add" tabindex="-1" aria-labelledby="add" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content rounded-4 gap-5 px-10 py-8">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="fs-2 fw-bold leading-5">Tambah Laporan Bendahara</div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form id="formAdd" action="{{ route('admin.bendahara.store') }}" method="POST"
                        enctype="multipart/form-data" class="d-grid gap-4">
                        @csrf

                        <div>
                            <div class="fw-semibold required mb-3 text-gray-800">Judul Laporan</div>
                            <input type="text" name="judul" placeholder="Masukkan Judul Laporan"
                                class="form-control bg-light border border-gray-400" required />
                            <div class="invalid-feedback"></div>
                        </div>

                        <div>
                            <div class="fw-semibold required mb-3 text-gray-800">Unggah Dokumen</div>
                            <div class="fv-row">
                                <div class="dropzone" id="dropzone-formAdd">
                                    <div class="dz-message needsclick">
                                        <i class="ki-duotone ki-file-up fs-3x text-primary">
                                            <span class="path1"></span><span class="path2"></span>
                                        </i>
                                        <div class="ms-4">
                                            <h3 class="fs-5 fw-bold mb-1 text-gray-900">Seret atau pilih dokumen.</h3>
                                            <span class="fs-7 fw-semibold text-gray-500">Format: PDF, XLS, XLSX. Max. 10 MB.</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </form>

                    <div class="d-grid py-4">
                        <button type="button" onclick="submitForm('formAdd')" id="submitBtnAdd"
                            class="bg-danger fw-bold d-flex align-items-center justify-content-center gap-2 rounded border-0 p-4 text-white">
                            <span class="btn-text">Tambah Laporan</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- File Preview Modal -->
        <div class="modal fade preview-modal" id="filePreviewModal" tabindex="-1" aria-labelledby="filePreviewModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="filePreviewModalLabel">Preview Dokumen</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-0">
                        <div id="previewContainer" class="w-100 h-100">
                            <!-- Preview content will be loaded here -->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a id="downloadBtn" href="#" class="btn btn-primary" target="_blank">
                            <i class="ki-outline ki-down me-2"></i>Download File
                        </a>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
        // Global variables
        let isSubmitting = false;
        let hasUnsavedChanges = false;
        let originalFormData = {};
        const dropzones = {};
        let currentFilter = '{{ request("filter_type", "all") }}';
        let currentDateFilter = {
            from: '{{ request("date_from") }}',
            to: '{{ request("date_to") }}'
        };

        // Dropzone configuration
        Dropzone.autoDiscover = false;

        // ==================== UTILITY FUNCTIONS ====================

        function debounce(func, delay) {
            let timeout;
            return function() {
                const context = this, args = arguments;
                clearTimeout(timeout);
                timeout = setTimeout(() => func.apply(context, args), delay);
            };
        }

        function formatDate(date) {
            return date.toISOString().split('T')[0];
        }

        function enablePageInteractions() {
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
            $('body').css('padding-right', '');
            $('html, body').css('overflow', '');
        }

        // ==================== FORM HANDLING ====================

        function clearFormErrors(formId) {
            const form = document.getElementById(formId);
            if (!form) {
                console.warn(`Form not found: ${formId}`);
                return;
            }

            form.querySelectorAll('.form-control').forEach(input => {
                if (input) input.classList.remove('is-invalid');
            });

            form.querySelectorAll('.invalid-feedback').forEach(feedback => {
                if (feedback) feedback.textContent = '';
            });
        }

        function showFormErrors(formId, errors) {
            const form = document.getElementById(formId);
            if (!form) {
                console.warn(`Form not found: ${formId}`);
                return;
            }

            clearFormErrors(formId);

            for (const field in errors) {
                const input = form.querySelector(`[name="${field}"]`);
                if (!input) {
                    console.warn(`Input field not found: ${field} in form ${formId}`);
                    continue;
                }

                const feedback = input.parentElement?.querySelector('.invalid-feedback');
                if (input && feedback) {
                    input.classList.add('is-invalid');
                    feedback.textContent = errors[field][0];
                }
            }
        }

        function setButtonLoading(buttonId, isLoading) {
            const button = document.getElementById(buttonId);
            if (!button) {
                console.warn(`Button not found: ${buttonId}`);
                return;
            }

            const btnText = button.querySelector('.btn-text');

            if (isLoading) {
                button.classList.add('btn-loading');
                button.disabled = true;
                if (btnText) btnText.style.opacity = '0';
            } else {
                button.classList.remove('btn-loading');
                button.disabled = false;
                if (btnText) btnText.style.opacity = '1';
            }
        }

        // ==================== DROPZONE MANAGEMENT ====================

        function initializeDropzones() {
            // Clear existing dropzones
            Object.keys(dropzones).forEach(key => {
                if (dropzones[key] && typeof dropzones[key].destroy === 'function') {
                    dropzones[key].destroy();
                    delete dropzones[key];
                }
            });

            // Common dropzone config
            const dropzoneConfig = {
                url: "#",
                autoProcessQueue: false,
                paramName: 'dokumen',
                maxFiles: 1,
                maxFilesize: 10,
                addRemoveLinks: true,
                acceptedFiles: '.pdf,.xls,.xlsx',
                dictInvalidFileType: 'Format file tidak didukung. Hanya PDF dan Excel yang diperbolehkan.',
                dictFileTooBig: 'Ukuran file terlalu besar. Maksimal 10MB.',
            };

            // Initialize add form dropzone
            if (document.getElementById('dropzone-formAdd')) {
                dropzones['formAdd'] = new Dropzone("#dropzone-formAdd", {
                    ...dropzoneConfig,
                    dictDefaultMessage: 'Seret atau pilih dokumen.<br><small>Format: PDF, XLS, XLSX. Max. 10 MB.</small>',
                });
            }

            // Initialize edit form dropzones
            document.querySelectorAll('[id^="dropzone-form-"]').forEach(element => {
                const formId = element.id.replace('dropzone-', '');
                if (!dropzones[formId]) {
                    dropzones[formId] = new Dropzone(`#${element.id}`, {
                        ...dropzoneConfig,
                        dictDefaultMessage: 'Seret atau pilih dokumen baru.<br><small>Format: PDF, XLS, XLSX. Max. 10 MB. Kosongkan jika tidak ingin mengubah file.</small>',
                    });
                }
            });

            // Add dropzone event listeners for change tracking
            Object.keys(dropzones).forEach(formId => {
                if (dropzones[formId]) {
                    dropzones[formId].on('addedfile', function() {
                        if (formId.startsWith('form-')) {
                            hasUnsavedChanges = true;
                            console.log(`Dropzone file added to ${formId}, marking as changed`);
                        }
                    });

                    dropzones[formId].on('removedfile', function() {
                        if (formId.startsWith('form-')) {
                            const itemId = formId.replace('form-', '');
                            const hasFiles = this.getAcceptedFiles().length > 0;

                            if (!hasFiles && originalFormData[itemId]) {
                                const $form = $(`#${formId}`);
                                const currentJudul = $form.find('input[name="judul"]').val() || '';
                                const originalJudul = originalFormData[itemId].judul || '';
                                hasUnsavedChanges = currentJudul !== originalJudul;
                            }
                            console.log(`Dropzone file removed from ${formId}, checking changes:`, hasUnsavedChanges);
                        }
                    });
                }
            });
        }

        // ==================== ENHANCED MODAL MANAGEMENT ====================

        function initializeModalHandlers() {
            // Remove existing handlers
            $(document).off('show.bs.modal', '[id^="edit-"]');
            $(document).off('hide.bs.modal', '[id^="edit-"]');
            $(document).off('hidden.bs.modal', '[id^="edit-"]');

            // Edit modal show handler
            $(document).on('show.bs.modal', '[id^="edit-"]', function() {
                const modalId = $(this).attr('id');
                const itemId = modalId.replace('edit-', '');

                console.log(`Opening modal: ${modalId}`);

                // Wait for modal to be fully rendered
                setTimeout(() => {
                    const form = document.getElementById(`form-${itemId}`);
                    console.log(`Looking for form: form-${itemId}`, form);

                    if (form) {
                        const judulInput = form.querySelector('input[name="judul"]');
                        console.log(`Looking for judul input in form-${itemId}:`, judulInput);

                        if (judulInput) {
                            originalFormData[itemId] = {
                                judul: judulInput.value || '',
                                dropzoneFiles: [],
                            };
                            console.log(`Storing original data for ${itemId}:`, originalFormData[itemId]);
                        } else {
                            console.error(`Judul input not found in form-${itemId}`);
                            // Try alternative selector
                            const altJudulInput = $(`#form-${itemId} input[name="judul"]`)[0];
                            console.log('Alternative judul input search:', altJudulInput);
                            if (altJudulInput) {
                                originalFormData[itemId] = {
                                    judul: altJudulInput.value || '',
                                    dropzoneFiles: [],
                                };
                            }
                        }

                        clearFormErrors(`form-${itemId}`);
                        isSubmitting = false;
                        hasUnsavedChanges = false;
                        setButtonLoading(`submitBtn${itemId}`, false);

                        const dropzone = dropzones[`form-${itemId}`];
                        if (dropzone) dropzone.removeAllFiles(true);
                    } else {
                        console.error(`Form not found: form-${itemId}`);
                    }
                }, 200); // Increased timeout to ensure modal is rendered
            });

            // Edit modal hide handler
            $(document).on('hide.bs.modal', '[id^="edit-"]', function(e) {
                const modalId = $(this).attr('id');
                const focusedElement = this.querySelector(':focus');
                if (focusedElement) focusedElement.blur();

                const wasSuccessfullySubmitted = $(this).data('success-submitted');

                if (hasUnsavedChanges && !wasSuccessfullySubmitted) {
                    e.preventDefault();
                    e.stopImmediatePropagation();

                    Swal.fire({
                        title: 'Perubahan Belum Disimpan',
                        text: 'Anda memiliki perubahan yang belum disimpan. Apakah Anda yakin ingin menutup tanpa menyimpan?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, Tutup',
                        cancelButtonText: 'Tetap Edit'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            hasUnsavedChanges = false;
                            $(this).modal('hide');
                        }
                    });
                    return false;
                }
            });

            // Edit modal hidden handler
            $(document).on('hidden.bs.modal', '[id^="edit-"]', function() {
                const modalId = $(this).attr('id');
                const itemId = modalId.replace('edit-', '');
                const form = document.getElementById(`form-${itemId}`);

                console.log(`Modal closed: ${modalId}`);

                enablePageInteractions();

                const wasSuccessfullySubmitted = $(this).data('success-submitted');

                if (form && originalFormData[itemId] && !wasSuccessfullySubmitted) {
                    console.log('Resetting form to original state for item:', itemId);

                    const judulInput = form.querySelector('input[name="judul"]') ||
                                     $(`#form-${itemId} input[name="judul"]`)[0];

                    if (judulInput && originalFormData[itemId].judul !== undefined) {
                        judulInput.value = originalFormData[itemId].judul;
                        console.log(`Reset judul to: "${originalFormData[itemId].judul}"`);
                    }

                    const dropzone = dropzones[`form-${itemId}`];
                    if (dropzone) {
                        dropzone.removeAllFiles(true);
                    }

                    clearFormErrors(`form-${itemId}`);
                }

                delete originalFormData[itemId];
                $(this).removeData('success-submitted');
                isSubmitting = false;
                hasUnsavedChanges = false;
                setButtonLoading(`submitBtn${itemId}`, false);

                setTimeout(() => {
                    initializeDropzones();
                }, 50);
            });

            // Add modal handlers
            $('#add').on('show.bs.modal', function() {
                isSubmitting = false;
                hasUnsavedChanges = false;
                clearFormErrors('formAdd');
                setButtonLoading('submitBtnAdd', false);

                setTimeout(() => {
                    if (dropzones['formAdd']) {
                        dropzones['formAdd'].removeAllFiles(true);
                    }
                }, 50);
            });

            $('#add').on('hidden.bs.modal', function() {
                const form = document.getElementById('formAdd');
                if (form) form.reset();

                if (dropzones['formAdd']) {
                    dropzones['formAdd'].removeAllFiles(true);
                }

                clearFormErrors('formAdd');
                isSubmitting = false;
                hasUnsavedChanges = false;
                setButtonLoading('submitBtnAdd', false);
                enablePageInteractions();

                setTimeout(() => {
                    initializeDropzones();
                }, 50);
            });
        }

        // ==================== ENHANCED FORM SUBMISSION ====================

        function submitForm(formId) {
            if (isSubmitting) return;

            let form = document.getElementById(formId);
            if (!form) {
                console.error(`Form not found: ${formId}`);
                return;
            }

            console.log('=== FORM SUBMISSION DEBUG START ===');
            console.log('Form ID:', formId);
            console.log('Form element:', form);

            // Check for judul input with multiple selectors
            let judulInput = form.querySelector('input[name="judul"]');
            if (!judulInput) {
                judulInput = $(`#${formId} input[name="judul"]`)[0];
            }

            console.log('Judul input element:', judulInput);

            if (!judulInput || !judulInput.value.trim()) {
                console.error('Judul is required but missing or empty');
                if (judulInput) {
                    judulInput.classList.add('is-invalid');
                    const feedback = judulInput.parentElement?.querySelector('.invalid-feedback');
                    if (feedback) {
                        feedback.textContent = 'Judul laporan wajib diisi.';
                    }
                }
                toastr.error('Silakan isi semua field yang wajib diisi.', 'Validasi Gagal!');
                return;
            }

            let formData = new FormData(form);
            const isEditForm = formId.startsWith('form-') && formId !== 'formAdd';

            if (isEditForm) {
                if (!formData.has('_method')) {
                    formData.append('_method', 'PUT');
                }
            } else {
                formData.delete('_method');
            }

            let csrfToken = formData.get('_token');
            if (!csrfToken) {
                csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
                        document.querySelector('input[name="_token"]')?.value;
                if (csrfToken) {
                    formData.append('_token', csrfToken);
                }
            }

            let submitBtnId = formId === 'formAdd' ? 'submitBtnAdd' : `submitBtn${formId.replace('form-', '')}`;

            clearFormErrors(formId);
            isSubmitting = true;
            setButtonLoading(submitBtnId, true);

            // Add dropzone files
            const dz = dropzones[formId];
            if (dz) {
                const files = dz.getAcceptedFiles();
                files.forEach((file) => {
                    formData.append('dokumen', file);
                });
            }

            fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: formData,
                })
                .then(async response => {
                    const responseText = await response.text();
                    let data;

                    try {
                        data = JSON.parse(responseText);
                    } catch (e) {
                        console.error('Failed to parse JSON response:', e);
                        throw new Error('Invalid JSON response from server');
                    }

                    if (!response.ok) {
                        if (response.status === 422 && data.errors) {
                            showFormErrors(formId, data.errors);
                            const firstError = Object.values(data.errors)[0][0];
                            toastr.error(firstError, "Validasi Gagal!");
                        } else {
                            const currentModal = $('.modal.show');
                            if (currentModal.length) {
                                currentModal.modal('hide');
                            }
                            toastr.error(data.message || "Gagal menyimpan data", "Error!");
                        }
                    } else {
                        const currentModal = $('.modal.show');
                        if (currentModal.length) {
                            currentModal.data('success-submitted', true);
                            currentModal.modal('hide');
                        }

                        toastr.success(data.message || "Data berhasil disimpan", "Success!");

                        if (formId === 'formAdd') {
                            form.reset();
                        }

                        if (dropzones[formId]) {
                            dropzones[formId].removeAllFiles(true);
                        }

                        hasUnsavedChanges = false;
                        setTimeout(() => reloadTable(), 100);
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                    const currentModal = $('.modal.show');
                    if (currentModal.length) {
                        currentModal.modal('hide');
                    }
                    toastr.error("Terjadi kesalahan jaringan. Silakan coba lagi.", "Error!");
                })
                .finally(() => {
                    isSubmitting = false;
                    setButtonLoading(submitBtnId, false);
                });
        }

        // ==================== DELETE FUNCTION ====================

        function deleteItem(id, title) {
            Swal.fire({
                title: 'Hapus Laporan?',
                text: `Apakah Anda yakin ingin menghapus laporan "${title}"?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'swal2-popup',
                    title: 'swal2-title',
                    content: 'swal2-content',
                    confirmButton: 'btn btn-danger',
                    cancelButton: 'btn btn-secondary'
                },
                buttonsStyling: false,
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `{{ route('admin.bendahara.index') }}/${id}`;
                    form.style.display = 'none';

                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                    if (csrfToken) {
                        const tokenInput = document.createElement('input');
                        tokenInput.type = 'hidden';
                        tokenInput.name = '_token';
                        tokenInput.value = csrfToken;
                        form.appendChild(tokenInput);
                    }

                    const methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = 'DELETE';
                    form.appendChild(methodInput);

                    document.body.appendChild(form);

                    const formData = new FormData(form);

                    fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: data.message,
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false,
                                customClass: {
                                    popup: 'swal2-popup'
                                }
                            });
                            setTimeout(() => reloadTable(), 500);
                        } else {
                            throw new Error(data.message || 'Gagal menghapus data');
                        }
                    })
                    .catch(error => {
                        console.error('Delete error:', error);
                        Swal.fire({
                            title: 'Error!',
                            text: error.message || 'Gagal menghapus laporan. Silakan coba lagi.',
                            icon: 'error',
                            confirmButtonText: 'OK',
                            customClass: {
                                popup: 'swal2-popup',
                                confirmButton: 'btn btn-primary'
                            },
                            buttonsStyling: false
                        });
                    })
                    .finally(() => {
                        document.body.removeChild(form);
                    });
                }
            });
        }

        // ==================== TABLE AND FILTERING ====================

        function reloadTable(url = null) {
            let formData = $('#filter').serialize();
            let target = url ?? "{{ route('admin.bendahara.index') }}";

            const urlParams = new URLSearchParams(window.location.search);
            const sortBy = urlParams.get('sort_by');
            const order = urlParams.get('order');

            if (sortBy) formData += '&sort_by=' + encodeURIComponent(sortBy);
            if (order) formData += '&order=' + encodeURIComponent(order);

            $.ajax({
                url: target,
                data: formData,
                beforeSend: function() {
                    $('#table').addClass('table-loading');
                    $('#table').html('<div class="py-20 text-center"><span class="spinner-border text-danger"></span></div>');
                },
                success: function(response) {
                    $('#table').removeClass('table-loading');
                    $('#table').html(response);

                    setTimeout(() => {
                        initializeDropzones();
                        initializeDropdownEvents();
                        initializeSortingEvents();
                        initializeModalHandlers();
                        updateFilterCountsFromResponse(response);
                        updateURL(formData);
                        enablePageInteractions();
                    }, 50);
                },
                error: function(xhr) {
                    $('#table').removeClass('table-loading');
                    $('#table').html('<div class="py-20 text-center text-danger fw-bold">Terjadi kesalahan saat memuat data.</div>');
                    enablePageInteractions();
                }
            });
        }

        function handleSort(sortBy, order) {
            let formData = $('#filter').serialize();
            formData += '&sort_by=' + encodeURIComponent(sortBy) + '&order=' + encodeURIComponent(order);

            $.ajax({
                url: "{{ route('admin.bendahara.index') }}",
                data: formData,
                beforeSend: function() {
                    $('#table').addClass('table-loading');
                },
                success: function(response) {
                    $('#table').removeClass('table-loading');
                    $('#table').html(response);

                    initializeDropzones();
                    initializeDropdownEvents();
                    initializeSortingEvents();
                    updateFilterCountsFromResponse(response);

                    const url = new URL(window.location);
                    url.searchParams.set('sort_by', sortBy);
                    url.searchParams.set('order', order);

                    const formParams = new URLSearchParams($('#filter').serialize());
                    for (const [key, value] of formParams.entries()) {
                        if (key !== 'sort_by' && key !== 'order') {
                            if (value) {
                                url.searchParams.set(key, value);
                            } else {
                                url.searchParams.delete(key);
                            }
                        }
                    }

                    window.history.pushState({}, '', url);
                }
            });
        }

        function initializeSortingEvents() {
            $(document).off('click', '.sortable');
            $(document).on('click', '.sortable', function(e) {
                e.preventDefault();
                const sortBy = $(this).data('sort');
                const order = $(this).data('order');
                handleSort(sortBy, order);
            });
        }

        function updateURL(formData) {
            if (window.history && window.history.pushState) {
                const url = new URL(window.location);
                const searchParams = new URLSearchParams(formData);

                for (const [key, value] of searchParams.entries()) {
                    if (value) {
                        url.searchParams.set(key, value);
                    } else {
                        url.searchParams.delete(key);
                    }
                }

                window.history.pushState({}, '', url);
            }
        }

        function updateFilterCountsFromResponse(response) {
            try {
                const tempDiv = $('<div>').html(response);
                const countData = tempDiv.find('[data-filter-counts]').data('filter-counts');

                if (countData) {
                    $('.filter-option[data-filter="all"] .filter-count').text(countData.all || 0);
                    $('.filter-option[data-filter="pdf"] .filter-count').text(countData.pdf || 0);
                    $('.filter-option[data-filter="excel"] .filter-count').text(countData.excel || 0);
                    $('.filter-option[data-filter="other"] .filter-count').text(countData.other || 0);
                }
            } catch (e) {
                console.log('Could not update filter counts from response');
            }
        }

        // ==================== DROPDOWN MANAGEMENT ====================

        function initializeDropdownEvents() {
            $(document).off('click', '.dropdown-toggle-custom');
            $(document).off('mouseenter', '.dropdown-action');
            $(document).off('mouseleave', '.dropdown-action');

            let showTimeout, hideTimeout;

            $(document).on('click', '.dropdown-toggle-custom', function(e) {
                e.preventDefault();
                e.stopPropagation();

                const $dropdownAction = $(this).closest('.dropdown-action');
                const $menu = $dropdownAction.find('.dropdown-menu-custom');

                clearTimeout(showTimeout);
                clearTimeout(hideTimeout);

                $('.dropdown-menu-custom').not($menu).removeClass('show');
                $menu.toggleClass('show');
                checkDropdownPosition($dropdownAction);
            });

            function checkDropdownPosition($dropdownAction) {
                const $menu = $dropdownAction.find('.dropdown-menu-custom');
                if (!$menu.hasClass('show')) return;

                $dropdownAction.removeClass('dropup');

                const $row = $dropdownAction.closest('tr');
                const $table = $row.closest('tbody');
                const rowIndex = $table.find('tr').index($row);
                const totalRows = $table.find('tr').length;

                if (rowIndex >= totalRows - 2) {
                    $dropdownAction.addClass('dropup');
                }
            }

            if (window.innerWidth > 768) {
                $(document).on('mouseenter', '.dropdown-action', function() {
                    const $dropdownAction = $(this);
                    const $menu = $dropdownAction.find('.dropdown-menu-custom');

                    clearTimeout(hideTimeout);

                    showTimeout = setTimeout(() => {
                        $('.dropdown-menu-custom').not($menu).removeClass('show');
                        $menu.addClass('show');
                        checkDropdownPosition($dropdownAction);
                    }, 300);
                });

                $(document).on('mouseleave', '.dropdown-action', function() {
                    const $dropdownAction = $(this);
                    const $menu = $dropdownAction.find('.dropdown-menu-custom');

                    clearTimeout(showTimeout);

                    hideTimeout = setTimeout(() => {
                        if (!$menu.is(':hover') && !$dropdownAction.is(':hover')) {
                            $menu.removeClass('show');
                        }
                    }, 200);
                });
            }

            $(document).on('click', function(e) {
                if (!$(e.target).closest('.dropdown-action').length) {
                    clearTimeout(showTimeout);
                    clearTimeout(hideTimeout);
                    $('.dropdown-menu-custom').removeClass('show');
                }
            });
        }

        // ==================== FILE PREVIEW ====================

        function previewFile(fileUrl, fileName, fileExtension) {
            const modal = new bootstrap.Modal(document.getElementById('filePreviewModal'));
            const previewContainer = document.getElementById('previewContainer');
            const modalTitle = document.getElementById('filePreviewModalLabel');
            const downloadBtn = document.getElementById('downloadBtn');

            modalTitle.textContent = fileName;
            downloadBtn.href = fileUrl;
            previewContainer.innerHTML = '';

            const ext = fileExtension.toLowerCase();

            if (ext === 'pdf') {
                previewContainer.innerHTML = `
                    <iframe src="${fileUrl}" style="width: 100%; height: 70vh;" frameborder="0">
                        <div class="preview-error">
                            <i class="fas fa-file-pdf"></i>
                            <h5>Cannot display PDF</h5>
                            <p>Your browser doesn't support PDF preview. Please download the file to view it.</p>
                        </div>
                    </iframe>
                `;
            } else if (['xls', 'xlsx'].includes(ext)) {
                previewContainer.innerHTML = `
                    <iframe src="https://docs.google.com/gview?url=${encodeURIComponent(fileUrl)}&embedded=true"
                            style="width: 100%; height: 70vh;" frameborder="0">
                        <div class="preview-error">
                            <i class="fas fa-file-excel"></i>
                            <h5>Preview not available</h5>
                            <p>Cannot preview this Excel document. Please download the file to view it.</p>
                        </div>
                    </iframe>
                `;
            } else {
                previewContainer.innerHTML = `
                    <div class="preview-error">
                        <i class="fas fa-file"></i>
                        <h5>Preview not available</h5>
                        <p>This file type cannot be previewed. Please download the file to view it.</p>
                        <small class="text-muted">File type: ${ext.toUpperCase()}</small>
                    </div>
                `;
            }

            modal.show();
        }

        // ==================== DOCUMENT READY ====================

        $(document).ready(function() {
            console.log('Document ready - initializing...');

            enablePageInteractions();

            // Initialize all functionality in the correct order
            initializeDropzones();
            initializeDropdownEvents();
            initializeSortingEvents();
            initializeModalHandlers();

            // Set global function references
            window.submitForm = submitForm;
            window.deleteItem = deleteItem;
            window.previewFile = previewFile;

            // Enhanced form change tracking
            $(document).on('input change', '[id^="form-"] input, [id^="form-"] select, [id^="form-"] textarea', function(e) {
                setTimeout(() => {
                    const $input = $(this);
                    const formId = $input.closest('form').attr('id');

                    if (formId && formId.startsWith('form-')) {
                        const itemId = formId.replace('form-', '');

                        if (originalFormData[itemId]) {
                            const currentValue = $input.val() || '';
                            const fieldName = $input.attr('name');

                            if (fieldName === 'judul') {
                                const originalValue = originalFormData[itemId].judul || '';
                                const hasChanged = currentValue !== originalValue;
                                hasUnsavedChanges = hasChanged;
                                console.log(`Judul changed: "${originalValue}" -> "${currentValue}", hasUnsavedChanges:`, hasUnsavedChanges);
                            } else {
                                hasUnsavedChanges = true;
                                console.log(`Field ${fieldName} changed in ${formId}, hasUnsavedChanges:`, hasUnsavedChanges);
                            }
                        } else if (formId !== 'formAdd') {
                            hasUnsavedChanges = true;
                            console.log('No original data found for edit form, marking as changed');
                        }
                    }
                }, 10);
            });

            // ==================== FILTER FUNCTIONALITY ====================

            // Main filter dropdown
            $(document).off('click', '#filterBtn');
            $(document).on('click', '#filterBtn', function(e) {
                e.preventDefault();
                e.stopPropagation();
                console.log('Filter button clicked');

                const $menu = $('#filterMenu');
                const $dateMenu = $('#dateFilterMenu');

                $dateMenu.removeClass('show');
                $menu.toggleClass('show');

                console.log('Filter menu show class:', $menu.hasClass('show'));
            });

            // Filter option selection
            $(document).off('click', '.filter-option');
            $(document).on('click', '.filter-option', function(e) {
                e.preventDefault();
                e.stopPropagation();

                const filterType = $(this).data('filter');
                console.log('Filter option clicked:', filterType);

                if (filterType === currentFilter) return;

                $('.filter-option').removeClass('active');
                $(this).addClass('active');

                const filterContent = $(this).find('span').first().html();
                $('#filterBtn span').html(filterContent);

                if (filterType === 'all') {
                    $('#filterBtn').removeClass('filter-active');
                } else {
                    $('#filterBtn').addClass('filter-active');
                }

                currentFilter = filterType;
                $('#filter_type_input').val(filterType);
                reloadTable();
                $('#filterMenu').removeClass('show');
            });

            // ==================== DATE FILTER FUNCTIONALITY ====================

            // Date filter button
            $(document).off('click', '#dateFilterBtn');
            $(document).on('click', '#dateFilterBtn', function(e) {
                e.preventDefault();
                e.stopPropagation();
                console.log('Date filter button clicked');

                const $menu = $('#dateFilterMenu');
                const $filterMenu = $('#filterMenu');

                $filterMenu.removeClass('show');
                $menu.toggleClass('show');

                console.log('Date filter menu show class:', $menu.hasClass('show'));
            });

            // Date preset buttons
            $(document).off('click', '.date-preset-btn');
            $(document).on('click', '.date-preset-btn', function(e) {
                e.preventDefault();

                const preset = $(this).data('preset');
                const today = new Date();
                let fromDate, toDate;

                $('.date-preset-btn').removeClass('active');
                $(this).addClass('active');

                switch (preset) {
                    case 'today':
                        fromDate = toDate = formatDate(today);
                        break;
                    case 'this-week':
                        const startOfWeek = new Date(today);
                        startOfWeek.setDate(today.getDate() - today.getDay());
                        const endOfWeek = new Date(startOfWeek);
                        endOfWeek.setDate(startOfWeek.getDate() + 6);
                        fromDate = formatDate(startOfWeek);
                        toDate = formatDate(endOfWeek);
                        break;
                    case 'this-month':
                        fromDate = formatDate(new Date(today.getFullYear(), today.getMonth(), 1));
                        toDate = formatDate(new Date(today.getFullYear(), today.getMonth() + 1, 0));
                        break;
                    case 'this-year':
                        fromDate = formatDate(new Date(today.getFullYear(), 0, 1));
                        toDate = formatDate(new Date(today.getFullYear(), 11, 31));
                        break;
                    case 'last-30-days':
                        const thirtyDaysAgo = new Date(today);
                        thirtyDaysAgo.setDate(today.getDate() - 30);
                        fromDate = formatDate(thirtyDaysAgo);
                        toDate = formatDate(today);
                        break;
                }

                $('#dateFrom').val(fromDate);
                $('#dateTo').val(toDate);
            });

            // Apply date filter
            $(document).off('click', '#applyDateFilter');
            $(document).on('click', '#applyDateFilter', function(e) {
                e.preventDefault();

                const dateFrom = $('#dateFrom').val();
                const dateTo = $('#dateTo').val();

                if (dateFrom && dateTo && new Date(dateFrom) > new Date(dateTo)) {
                    toastr.error('Tanggal mulai tidak boleh lebih besar dari tanggal akhir', 'Error!');
                    return;
                }

                $('#date_from_input').val(dateFrom);
                $('#date_to_input').val(dateTo);

                if (dateFrom || dateTo) {
                    $('#dateFilterBtn').addClass('date-filter-active');
                } else {
                    $('#dateFilterBtn').removeClass('date-filter-active');
                }

                currentDateFilter = { from: dateFrom, to: dateTo };
                reloadTable();
                $('#dateFilterMenu').removeClass('show');

                if (dateFrom || dateTo) {
                    toastr.success('Filter tanggal berhasil diterapkan', 'Success!');
                }
            });

            // Reset date filter
            $(document).off('click', '#resetDateFilter');
            $(document).on('click', '#resetDateFilter', function(e) {
                e.preventDefault();

                $('#dateFrom').val('');
                $('#dateTo').val('');
                $('#date_from_input').val('');
                $('#date_to_input').val('');
                $('#dateFilterBtn').removeClass('date-filter-active');
                $('.date-preset-btn').removeClass('active');

                currentDateFilter = { from: '', to: '' };
                reloadTable();
                $('#dateFilterMenu').removeClass('show');
                toastr.success('Filter tanggal berhasil direset', 'Success!');
            });

            // ==================== SEARCH AND PAGINATION ====================

            // Search functionality with debounce
            $(document).on('input', '#filter input[name="search"]', debounce(function() {
                let keyword = $(this).val();
                if (keyword.length >= 1 || keyword.length === 0) {
                    reloadTable();
                }
            }, 300));

            // Per page change
            $(document).on('change', 'select[name="per_page"]', function() {
                const newPerPage = $(this).val();
                let formData = $('#filter').serialize() + '&per_page=' + newPerPage;

                const urlParams = new URLSearchParams(window.location.search);
                const sortBy = urlParams.get('sort_by');
                const order = urlParams.get('order');

                if (sortBy) formData += '&sort_by=' + encodeURIComponent(sortBy);
                if (order) formData += '&order=' + encodeURIComponent(order);

                reloadTableWithData(formData);
            });

            // Pagination clicks
            $(document).on('click', '.pagination-link', function(e) {
                e.preventDefault();
                let url = $(this).attr('href');
                if (url) {
                    const urlObj = new URL(url);
                    const page = urlObj.searchParams.get('page');

                    let formData = $('#filter').serialize();
                    formData += '&page=' + page;

                    const currentUrlParams = new URLSearchParams(window.location.search);
                    const sortBy = currentUrlParams.get('sort_by');
                    const order = currentUrlParams.get('order');

                    if (sortBy) formData += '&sort_by=' + encodeURIComponent(sortBy);
                    if (order) formData += '&order=' + encodeURIComponent(order);

                    reloadTableWithData(formData);
                }
            });

            // ==================== DROPDOWN CLOSE HANDLERS ====================

            // Close dropdowns when clicking outside
            $(document).on('click', function(e) {
                const $target = $(e.target);

                // Check if click is outside filter dropdowns
                if (!$target.closest('.filter-dropdown, .date-filter-dropdown, #filterBtn, #dateFilterBtn').length) {
                    $('#filterMenu').removeClass('show');
                    $('#dateFilterMenu').removeClass('show');
                    console.log('Clicked outside filters, closing menus');
                }
            });

            // Prevent dropdowns from closing when clicking inside them
            $(document).on('click', '#filterMenu, #dateFilterMenu', function(e) {
                e.stopPropagation();
                console.log('Clicked inside menu, preventing close');
            });

            // Also prevent closing when clicking the buttons themselves
            $(document).on('click', '#filterBtn, #dateFilterBtn', function(e) {
                e.stopPropagation();
            });

            // ==================== HELPER FUNCTION FOR TABLE RELOAD ====================

            function reloadTableWithData(formData) {
                $.ajax({
                    url: "{{ route('admin.bendahara.index') }}",
                    data: formData,
                    beforeSend: function() {
                        $('#table').addClass('table-loading');
                        $('#table').html('<div class="py-20 text-center"><span class="spinner-border text-danger"></span></div>');
                    },
                    success: function(response) {
                        $('#table').removeClass('table-loading');
                        $('#table').html(response);

                        setTimeout(() => {
                            initializeDropzones();
                            initializeDropdownEvents();
                            initializeSortingEvents();
                            initializeModalHandlers();
                            updateURL(formData);
                            console.log('Table reloaded and re-initialized');
                        }, 50);
                    },
                    error: function(xhr) {
                        $('#table').removeClass('table-loading');
                        $('#table').html('<div class="py-20 text-center text-danger fw-bold">Terjadi kesalahan saat memuat data.</div>');
                    }
                });
            }

            // ==================== INITIALIZATION ====================

            // Initialize filter from URL on page load
            const urlParams = new URLSearchParams(window.location.search);
            const filterFromURL = urlParams.get('filter_type') || 'all';
            if (filterFromURL !== currentFilter) {
                $(`.filter-option[data-filter="${filterFromURL}"]`).trigger('click');
            }

            // Initialize date filter state on page load
            if (currentDateFilter.from || currentDateFilter.to) {
                $('#dateFilterBtn').addClass('date-filter-active');

                const from = currentDateFilter.from;
                const to = currentDateFilter.to;
                const today = formatDate(new Date());

                if (from === today && to === today) {
                    $('.date-preset-btn[data-preset="today"]').addClass('active');
                }
            }

            console.log('Document ready initialization completed');
        });

        // ==================== SWEETALERT2 STYLING ====================

        // Add CSS for better SweetAlert2 styling
        const additionalCSS = `
        <style>
        .swal2-popup {
            border-radius: 12px !important;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2) !important;
        }

        .swal2-title {
            font-size: 1.5rem !important;
            font-weight: 600 !important;
            color: #2c3e50 !important;
        }

        .swal2-content {
            font-size: 1rem !important;
            color: #495057 !important;
        }

        .swal2-confirm.btn-danger {
            background-color: #dc3545 !important;
            border-color: #dc3545 !important;
        }

        .swal2-cancel.btn-secondary {
            color: white !important;
            background-color: #424874 !important;
            border-color: #424874 !important;
        }

        .swal2-loading .swal2-title {
            color: #007bff !important;
        }

        .swal2-timer-progress-bar {
            background: rgba(0, 123, 255, 0.7) !important;
        }
        </style>
        `;

        // Inject the CSS
        $('head').append(additionalCSS);

    </script>
@endsection
