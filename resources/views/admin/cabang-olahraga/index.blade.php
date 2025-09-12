@extends('layouts.app')

@section('pageTitle', 'Cabang Olahraga')
@section('mainSection', 'Konfigurasi')
@section('currentSection', 'Cabang Olahraga')
@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endpush
@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
@endpush
@php
    if (!function_exists('sortIcon')) {
        function sortIcon($field)
        {
            $currentSort = request('sort_by');
            $currentOrder = request('order');

            if ($currentSort === $field) {
                return $currentOrder === 'asc' ? '<i class="fas fa-sort-up"></i>' : '<i class="fas fa-sort-down"></i>';
            }

            return '<i class="fas fa-sort text-muted"></i>';
        }
    }

    if (!function_exists('sortUrl')) {
        function sortUrl($field)
        {
            $currentSort = request('sort_by');
            $currentOrder = request('order');

            $order = $currentSort === $field && $currentOrder === 'asc' ? 'desc' : 'asc';

            return request()->fullUrlWithQuery([
                'sort_by' => $field,
                'order' => $order,
            ]);
        }
    }
@endphp

@section('content')
    <style>
        body {
            background-color: #f5f5f5;
        }

        .main-content {
            background-color: #f5f5f5;
            min-height: 100vh;
            padding: 20px 0;
        }

        /* Card Styles - MATCHING PASTE 1 EXACTLY */
        .card {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
            border: 1px solid #e9ecef;
            overflow: visible !important;
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
        .btn-add-cabor {
            background: linear-gradient(135deg, #F8285A 0%, #e91e63 100%);
            border: none;
            border-radius: 8px;
            padding: 12px 24px;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(248, 40, 90, 0.3);
        }

        .btn-add-cabor:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(248, 40, 90, 0.4);
        }

        /* Table Container - MATCHING PASTE 1 EXACTLY */
        .table-container {
            background-color: white;
            border-radius: 0px 0px 12px 12px;
            overflow: hidden;
        }

        .table-header {
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

        /* Table Responsive - MATCHING PASTE 1 EXACTLY */
        .table-responsive {
            overflow-x: auto;
            overflow-y: visible;
            -webkit-overflow-scrolling: touch;
            border-radius: 8px;
            border: 1px solid #e9ecef;
            background-color: white;
        }

        /* Table Base Styles - MATCHING PASTE 1 EXACTLY */
        .table {
            border-collapse: separate !important;
            border-spacing: 0 !important;
            margin: 0 !important;
            background-color: white;
            width: 100%;
            min-width: 1200px;
            border: none;
        }

        /* Table Header Styles with Sort Fix - MATCHING PASTE 1 EXACTLY */
        .table thead th {
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
            border-top: none;
            font-weight: bold !important;
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

        /* Sort Link Styles - MATCHING PASTE 1 EXACTLY */
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

        /* Column-specific alignments - Adjusted for Cabor columns */
        .table th:nth-child(2) .sort-link,
        .table th:nth-child(3) .sort-link,
        .table th:nth-child(5) .sort-link,
        .table th:nth-child(8) .sort-link {
            justify-content: space-between;
            text-align: left;
        }

        .table th:nth-child(1) .sort-link,
        .table th:nth-child(4) .sort-link,
        .table th:nth-child(6) .sort-link,
        .table th:nth-child(7) .sort-link,
        .table th:nth-child(9) .sort-link {
            justify-content: center;
            text-align: center;
        }

        /* Table Body Styles - MATCHING PASTE 1 EXACTLY */
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

        /* Column Widths and Alignments - Adjusted for Cabor */
        .table td:first-child,
        .table th:first-child {
            padding-left: 20px !important;
            padding-right: 20px !important;
        }

        .table td:last-child,
        .table th:last-child {
            padding-right: 12px !important;
        }

        /* Specific column widths for Cabor table */
        .table th:nth-child(1),
        .table td:nth-child(1) {
            width: 40px;
            text-align: center !important;
        }

        .table th:nth-child(2),
        .table td:nth-child(2) {
            width: 250px;
            text-align: left !important;
        }

        .table th:nth-child(3),
        .table td:nth-child(3) {
            width: 200px;
            text-align: left !important;
        }

        .table th:nth-child(4),
        .table td:nth-child(4) {
            width: 120px;
            text-align: center !important;
        }

        .table th:nth-child(5),
        .table td:nth-child(5) {
            width: 150px;
            text-align: left !important;
        }

        .table th:nth-child(6),
        .table td:nth-child(6) {
            width: 100px;
            text-align: center !important;
        }

        .table th:nth-child(7),
        .table td:nth-child(7) {
            width: 100px;
            text-align: center !important;
        }

        .table th:nth-child(8),
        .table td:nth-child(8) {
            width: 150px;
            text-align: left !important;
        }

        .table th:nth-child(9),
        .table td:nth-child(9) {
            width: 120px;
            text-align: center !important;
        }

        .table td:nth-child(1),
        .table td:nth-child(4),
        .table td:nth-child(6),
        .table td:nth-child(7),
        .table td:nth-child(9) {
            text-align: center;
        }

        /* Utility Classes - MATCHING PASTE 1 EXACTLY */
        .text-truncate-custom {
            max-width: 120px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
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

        /* Empty State - MATCHING PASTE 1 EXACTLY */
        .empty-state {
            text-align: center;
            color: #6c757d;
            padding: 60px 25px;
            background-color: white;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            margin: 20px;
        }

        /* Dropdowns - MATCHING PASTE 1 EXACTLY */
        .dropdown-menu {
            border: none;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            border-radius: 8px;
            z-index: 1050 !important;
            position: absolute !important;
        }

        /* Form Controls - MATCHING PASTE 1 EXACTLY */
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

        /* Pagination - MATCHING PASTE 1 EXACTLY */
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

        /* Simple Pagination Styles - MATCHING PASTE 1 EXACTLY */
        .simple-pagination .page-link {
            border: none !important;
            margin: 0 2px;
            border-radius: 4px !important;
            padding: 6px 12px !important;
            color: #6c757d !important;
            background-color: #f8f9fa !important;
            transition: all 0.2s ease;
        }

        .simple-pagination .page-link:hover {
            background-color: #e9ecef !important;
            color: #495057 !important;
        }

        .simple-pagination .page-item.active .page-link {
            background-color: #007bff !important;
            color: white !important;
        }

        .simple-pagination .page-link:focus {
            box-shadow: none !important;
        }

        /* Pagination Arrows and Numbers - MATCHING PASTE 1 EXACTLY */
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

        /* Loading States - MATCHING PASTE 1 EXACTLY */
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

        /* Toast Notifications - MATCHING PASTE 1 EXACTLY */
        .notification-toast {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            min-width: 300px;
        }

        .toast-success {
            background-color: #51a351;
            color: white;
        }

        .toast-error {
            background-color: #bd362f;
            color: white;
        }

        .toast-warning {
            background-color: #f89406;
            color: white;
        }

        .toast-info {
            background-color: #2f96b4;
            color: white;
        }

        /* AJAX Loading Overlay */
        .loading-overlay {
            position: absolute !important;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.85);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            border-radius: 8px;
            backdrop-filter: blur(2px);
        }

        /* Button Icon Styles */
        .btn-icon.btn-sm {
            width: 32px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0;
        }

        .btn-light-danger[style*="opacity"] {
            cursor: not-allowed;
        }

        #dependencyList {
            padding-left: 1.5rem;
        }

        #dependencyList li {
            margin-bottom: 0.25rem;
            color: #dc3545;
        }

        /* Responsive Styles - MATCHING PASTE 1 EXACTLY */
        @media (max-width: 768px) {

            .table-header,
            .table-footer {
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

            .table thead th .sort-link {
                gap: 4px;
                font-size: 0.8rem;
            }

            .d-flex.justify-content-between.align-items-center.flex-wrap {
                flex-direction: column;
                gap: 1rem;
                align-items: center !important;
            }

            .pagination-sm .page-link {
                padding: 0.25rem 0.5rem;
                font-size: 0.75rem;
            }

            .d-flex.align-items-center.gap-3 {
                flex-direction: column;
                gap: 0.5rem !important;
            }

            .pagination-arrow,
            .pagination-number {
                padding: 4px 6px;
                font-size: 0.75rem;
            }
        }

        @media (max-width: 576px) {
            .pagination-sm .page-link {
                padding: 0.2rem 0.4rem;
                font-size: 0.7rem;
            }

            .text-muted {
                font-size: 0.875rem;
            }
        }


        /* Style untuk tombol filter seperti di halaman Pelatih */
        .filter-btn-custom {
            border: 1px solid #dee2e6 !important;
            background-color: white;
            border-radius: 6px;
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
            transition: all 0.2s ease-in-out;
            color: #000;
        }

        .filter-btn-custom:hover {
            background-color: #f8f9fa;
            border-color: #dee2e6;
            color: #000;
        }

        /* Style untuk badge count filter */
        .badge-circle {
            border-radius: 50%;
            width: 18px;
            height: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
        }

        /* Container demo */
        .demo-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        }

        .demo-title {
            text-align: center;
            margin-bottom: 2rem;
            color: #2c3e50;
            font-weight: 700;
        }

        .button-comparison {
            display: flex;
            justify-content: space-around;
            align-items: center;
            margin: 2rem 0;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .button-item {
            text-align: center;
            padding: 1rem;
            border-radius: 8px;
            background: #f8f9fa;
            width: 250px;
        }

        .button-item h4 {
            margin-bottom: 1rem;
            color: #495057;
        }

        .code-block {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 8px;
            margin-top: 2rem;
            font-family: monospace;
            white-space: pre-wrap;
            border-left: 4px solid #F8285A;
        }

        .badge-circle {
            border-radius: 50%;
            width: 18px;
            height: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
        }
    </style>

    @if (session('success'))
        <div class="alert alert-{{ session('action') === 'store' ? 'success' : (session('action') === 'update' ? 'warning' : 'danger') }} alert-dismissible fade show"
            role="alert">
            <i
                class="fas {{ session('action') === 'store' ? 'fa-check-circle' : (session('action') === 'update' ? 'fa-exclamation-circle' : 'fa-trash-alt') }} me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center flex-wrap mb-4" style="padding:10px 30px">
        <h2 class="fw-bold fs-2 mb-0 text-dark">Cabang Olahraga</h2>
        <a href="{{ route('admin.konfigurasi.cabang-olahraga.create') }}" class="btn"
            style="background-color: #F8285A !important; color: white !important; border-color: #F8285A !important; border-radius: 8px; padding: 12px 20px; font-weight: 500;">
            <i class="ki-duotone ki-plus fs-4 me-2" style="color: white !important;"></i>Tambah Cabang Olahraga
        </a>
    </div>

    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-header" style="border-radius: 12px 12px 0px 0px">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h3 class="mb-0 fw-semibold text-dark">Table Daftar Cabor Tabalong</h3>

                                    <div class="d-flex align-items-center gap-2 flex-wrap">
                                        <a href="{{ route('admin.konfigurasi.cabang-olahraga.export') }}"
                                            id="export-excel-btn" class="btn btn-outline-secondary filter-btn-custom"
                                            title="Export ke Excel">
                                            <i class="fas fa-file-excel me-1"></i> Export
                                        </a>

                                        <div class="input-group" style="width: 250px;">
                                            <input type="search" name="search" id="search" class="form-control"
                                                placeholder="Cari cabang olahraga..." value="{{ request('search') }}" autocomplete="off">
                                            <button class="btn btn-outline-secondary" type="button">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>

                                        <div class="dropdown">
                                            <button class="btn btn-outline-secondary dropdown-toggle filter-btn-custom"
                                                type="button" data-bs-toggle="dropdown">
                                                <i class="fas fa-filter me-1"></i> Filter
                                                <span id="filter-count"
                                                    class="badge badge-circle badge-danger ms-1 {{ request('status') ? '' : 'd-none' }}">
                                                    {{ request('status') ? 1 : 0 }}
                                                </span>
                                            </button>
                                            <div class="dropdown-menu p-3 shadow" style="min-width: 320px;">
                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">Status Keaktifan</label>
                                                    <select id="filter-status" name="status" class="form-select">
                                                        <option value="">Semua Status</option>
                                                        <option value="Aktif"
                                                            {{ request('status') == 'Aktif' ? 'selected' : '' }}>
                                                            Aktif
                                                        </option>
                                                        <option value="Pembinaan"
                                                            {{ request('status') == 'Pembinaan' ? 'selected' : '' }}>
                                                            Pembinaan</option>
                                                    </select>
                                                </div>

                                                <div class="d-flex gap-2">
                                                    <button type="button" id="apply-filters"
                                                        class="btn btn-primary btn-sm flex-fill">
                                                        <i class="fas fa-check"></i> Terapkan
                                                    </button>
                                                    <button type="button" id="reset-filters"
                                                        class="btn btn-light btn-sm flex-fill">
                                                        <i class="fas fa-redo"></i> Reset
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if (!(isset($cabors) && $cabors->isEmpty()))
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div id="filter-info" class="text-muted">
                                            Menampilkan <span
                                                id="showing-count">{{ isset($cabors) ? $cabors->count() : 0 }}</span>
                                            dari <span id="total-count">{{ isset($cabors) ? $cabors->total() : 0 }}</span>
                                            cabang olahraga
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="table-container">
                                @if (isset($cabors) && $cabors->isEmpty())
                                    <div class="empty-state">
                                        <i class="fas fa-info-circle fs-3x mb-3"></i>
                                        <h4>Tidak ada data cabang olahraga.</h4>
                                    </div>
                                @else
                                    <div class="table-responsive" id="tableContainer">
                                        @include('admin.cabang-olahraga.partials.table', [
                                            'cabors' => $cabors,
                                        ])
                                    </div>

                                    <!-- Pagination Section -->
                                    @if (isset($cabors) && $cabors->total() > 0)
                                        <div class="table-footer">
                                            @include('admin.cabang-olahraga.partials.pagination', [
                                                'cabors' => $cabors,
                                            ])
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        $(document).ready(function() {
            // ✅ Declare all variables at the top
            let isLoading = false;
            let searchTimeout;
            let clickTimeout;

            // Tambahkan check jQuery
            if (typeof $ === 'undefined') {
                console.error('jQuery not loaded!');
                return;
            }

            console.log('🚀 AJAX System Loading...');
            console.log('jQuery loaded:', typeof $ !== 'undefined');
            console.log('Current URL:', window.location.href);
            
            // Check for other dependencies
            console.log('jQuery version:', $.fn.jquery);
            console.log('Window object available:', typeof window !== 'undefined');
            console.log('Document object available:', typeof document !== 'undefined');

            // Base URL untuk AJAX requests
            const baseUrl = "{{ route('admin.konfigurasi.cabang-olahraga.index') }}";

            // Initialize filters from URL on page load (like in pelatih page)
            function initializeFiltersFromURL() {
                const urlParams = new URLSearchParams(window.location.search);
                
                // Set form values from URL parameters
                $('#search').val(urlParams.get('search') || '');
                $('#filter-status').val(urlParams.get('status') || '');
                
                updateFilterCountBadge();
            }
            
            // Initialize filters on page load
            initializeFiltersFromURL();
            
            // Debug: Cek elemen yang diperlukan
            console.log('Search element (jQuery):', $('#search').length > 0 ? 'FOUND' : 'NOT FOUND');
            console.log('Search element (native):', document.getElementById('search') ? 'FOUND' : 'NOT FOUND');
            console.log('Filter element:', $('#filter-status').length > 0 ? 'FOUND' : 'NOT FOUND');
            console.log('Table container:', $('#tableContainer').length > 0 ? 'FOUND' : 'NOT FOUND');
            
            // Tambahkan logging untuk memastikan event handler terdaftar
            console.log('Registering event handlers...');
            
            // Test if search element exists
            if ($('#search').length > 0) {
                console.log('✅ Search element found, attaching event handlers');
                
                // Test event attachment
                $('#search').on('test-event', function() {
                    console.log('Test event triggered on search element');
                });
                
                // Trigger test event
                $('#search').trigger('test-event');
            } else {
                console.error('❌ Search element NOT found!');
            }
            
            // Cek apakah semua elemen diperlukan ada
            const requiredElements = {
                'search': document.getElementById('search'),
                'filter-status': document.getElementById('filter-status'),
                'tableContainer': document.getElementById('tableContainer'),
                'export-excel-btn': document.getElementById('export-excel-btn')
            };
            
            Object.keys(requiredElements).forEach(key => {
                console.log(`Element ${key}:`, requiredElements[key] ? 'FOUND' : 'NOT FOUND');
            });

            // ✅ FIXED AJAX Request Function with proper error handling (kept for backward compatibility)
            function performAjaxRequest(params = {}, showLoading = true) {
                if (isLoading) {
                    console.log('⚠️ Request already in progress, skipping...');
                    return Promise.reject('Request in progress');
                }

                // Show loading state
                if (showLoading) {
                    showTableLoading();
                }

                // Get current URL parameters
                const currentParams = new URLSearchParams(window.location.search);
                const newParams = new URLSearchParams();

                // Preserve existing params first
                for (let [key, value] of currentParams) {
                    newParams.set(key, value);
                }

                // Override/add new params
                for (let [key, value] of Object.entries(params)) {
                    if (value !== null && value !== undefined && value !== '') {
                        newParams.set(key, value);
                    } else if (value === '' || value === null) {
                        newParams.delete(key);
                    }
                }

                const url = `${baseUrl}?${newParams.toString()}`;
                console.log('🚀 Making AJAX request to:', url, 'with params:', params);

                return $.ajax({
                        url: url,
                        type: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json, text/html',
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        timeout: 15000, // 15 second timeout
                        cache: false
                    })
                    .done(function(response, textStatus, jqXHR) {
                        console.log('📦 Response received:', response);
                        console.log('📦 Response type:', typeof response);
                        console.log('📦 Status code:', jqXHR.status);

                        // Check if response is JSON
                        let data = response;
                        if (typeof response === 'string') {
                            try {
                                data = JSON.parse(response);
                            } catch (e) {
                                console.log('📦 Response is HTML, parsing...');
                                // If it's HTML, we need to extract the table content
                                handleHtmlResponse(response);
                                return;
                            }
                        }

                        // Handle JSON response
                        if (data && typeof data === 'object') {
                            updateTableContent(data);

                            // Update URL without reload
                            if (url !== window.location.href) {
                                window.history.pushState({}, '', url);
                                console.log('✅ URL updated:', url);
                            }
                        } else {
                            console.warn('⚠️ Invalid response format');
                            fallbackToPageReload(url);
                        }
                    })
                    .fail(function(jqXHR, textStatus, errorThrown) {
                        console.error('❌ AJAX error:', textStatus, errorThrown);
                        console.error('❌ Response status:', jqXHR.status);
                        console.error('❌ Response text:', jqXHR.responseText);
                        console.error('❌ Response headers:', jqXHR.getAllResponseHeaders());

                        showErrorToast('Gagal memuat data. Silakan coba lagi.');

                        // Fallback to page reload after short delay
                        setTimeout(() => {
                            console.log('🔄 Falling back to page reload...');
                            window.location.href = url;
                        }, 1500);
                    })
                    .always(function() {
                        if (showLoading) {
                            hideTableLoading();
                        }
                        console.log('✅ AJAX request completed');
                    });
            }

            // ✅ NEW: Handle HTML response (when server returns full page)
            function handleHtmlResponse(htmlResponse) {
                try {
                    const $response = $(htmlResponse);

                    // Extract table content
                    const tableContent = $response.find('#tableContainer').html();
                    if (tableContent) {
                        $('#tableContainer').html(tableContent);
                        console.log('✅ Table updated from HTML response');
                    }

                    // Extract pagination content
                    const paginationContent = $response.find('.table-footer').html();
                    if (paginationContent) {
                        $('.table-footer').html(paginationContent);
                        console.log('✅ Pagination updated from HTML response');
                    }

                } catch (error) {
                    console.error('❌ Error parsing HTML response:', error);
                    showErrorToast('Terjadi kesalahan saat memuat data.');
                }
            }

            // ✅ NEW: Update table content from JSON response
            function updateTableContent(data) {
                if (data.html || data.table) {
                    const tableContent = data.html || data.table;
                    $('#tableContainer').html(tableContent);
                    console.log('✅ Table content updated from JSON');
                }

                if (data.pagination) {
                    $('.table-footer').html(data.pagination);
                    console.log('✅ Pagination updated from JSON');
                }

                // Update other elements if provided
                if (data.total_records) {
                    $('.total-records').text(data.total_records);
                }
            }
            
            // ✅ Handle HTML response (when server returns full page) - Updated version
            function handleHtmlResponse(htmlResponse) {
                try {
                    const $response = $(htmlResponse);

                    // Extract table content
                    const tableContent = $response.find('#tableContainer').html();
                    if (tableContent) {
                        $('#tableContainer').html(tableContent);
                        console.log('✅ Table updated from HTML response');
                    }

                    // Extract pagination content
                    const paginationContent = $response.find('.table-footer').html();
                    if (paginationContent) {
                        $('.table-footer').html(paginationContent);
                        console.log('✅ Pagination updated from HTML response');
                    }

                } catch (error) {
                    console.error('❌ Error parsing HTML response:', error);
                    showErrorToast('Terjadi kesalahan saat memuat data.');
                }
            }

            // ✅ NEW: Fallback to page reload
            function fallbackToPageReload(url) {
                console.log('🔄 Falling back to page reload...');
                setTimeout(() => {
                    window.location.href = url;
                }, 1000);
            }

            // ✅ Update Export Button URL (like in pelatih page)
    function updateExportButtonUrl() {
        const baseUrl = "{{ route('admin.konfigurasi.cabang-olahraga.export') }}";
        const url = new URL(baseUrl, window.location.origin);
        
        // Get all current parameters from the window URL
        const currentParams = new URLSearchParams(window.location.search);
        
        // Append all current filter and search params to the export URL
        currentParams.forEach((value, key) => {
            if (key !== 'page') { // Don't include pagination in export
                url.searchParams.append(key, value);
            }
        });
        
        // Also get values directly from form elements in case they haven't been applied yet
        const search = $('#search').val();
        const status = $('#filter-status').val();
        
        // Add form values to URL if they exist and aren't already in currentParams
        if (search && !currentParams.has('search')) {
            url.searchParams.set('search', search);
        }
        if (status && !currentParams.has('status')) {
            url.searchParams.set('status', status);
        }
        
        // Add current sorting parameters
        const sortBy = new URLSearchParams(window.location.search).get('sort_by');
        const order = new URLSearchParams(window.location.search).get('order');
        
        if (sortBy) {
            url.searchParams.set('sort_by', sortBy);
        }
        if (order) {
            url.searchParams.set('order', order);
        }
        
        $('#export-excel-btn').attr('href', url.toString());
        console.log('Export button URL updated:', url.toString());
    }

    // ✅ Initialize export functionality
    updateExportButtonUrl();
    
    console.log('✅ Enhanced Export System initialized successfully');
    
    // Tambahkan event listener tambahan untuk debugging
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM fully loaded and parsed');
        const searchElement = document.getElementById('search');
        if (searchElement) {
            console.log('Search element found in DOM');
            searchElement.addEventListener('input', function(e) {
                console.log('Native input event triggered:', e.target.value);
            });
        } else {
            console.error('Search element NOT found in DOM');
        }
    });
    
    // Tambahkan pengecekan tambahan untuk memastikan semua script dijalankan dengan benar
    console.log('Script initialization completed');
    
    // Cek apakah search element ada setelah inisialisasi
    setTimeout(() => {
        console.log('Delayed check - Search element:', document.getElementById('search') ? 'FOUND' : 'NOT FOUND');
    }, 1000);
});

            // ✅ Enhanced Loading State Functions
            function showTableLoading() {
                isLoading = true;
                const tableContainer = $('#tableContainer');

                if (tableContainer.length && !tableContainer.find('.loading-overlay').length) {
                    const overlay = $(`
                <div class="loading-overlay" style="
                    position: absolute !important;
                    top: 0; left: 0; right: 0; bottom: 0;
                    background: rgba(255, 255, 255, 0.9);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    z-index: 9999;
                    border-radius: 8px;
                    backdrop-filter: blur(2px);
                ">
                    <div class="d-flex align-items-center px-3 py-2 bg-white rounded shadow">
                        <div class="spinner-border spinner-border-sm text-primary me-2" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <span class="text-muted">Memuat data...</span>
                    </div>
                </div>
            `);

                    tableContainer.css('position', 'relative').append(overlay);
                }
            }

            function hideTableLoading() {
                isLoading = false;
                $('.loading-overlay').remove();
            }

            // ✅ Enhanced Error Toast Function
            function showErrorToast(message) {
                if (typeof toastr !== 'undefined') {
                    toastr.error(message, 'Error', {
                        timeOut: 5000,
                        closeButton: true,
                        progressBar: true
                    });
                } else if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: message,
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 5000
                    });
                } else {
                    console.error(message);
                    alert(message);
                }
            }

            // ✅ Update Filter Count Badge (like in pelatih page)
            function updateFilterCountBadge() {
                const activeFilters = [
                    $('#filter-status').val()
                ].filter(val => val && val.length > 0).length;

                const badge = $('#filter-count');
                if (activeFilters > 0) {
                    badge.text(activeFilters).removeClass('d-none');
                } else {
                    badge.addClass('d-none');
                }
            }

            // ✅ Update Export Button URL
            function updateExportButtonUrl() {
                // Get current filter values
                const searchValue = $('#search').val();
                const statusValue = $('#filter-status').val();

                // Build URL with current filters
                let exportUrl = "{{ route('admin.konfigurasi.cabang-olahraga.export') }}?";
                const params = new URLSearchParams();

                if (searchValue) {
                    params.append('search', searchValue);
                }

                if (statusValue) {
                    params.append('status', statusValue);
                }

                // Add current sorting parameters if they exist
                const urlParams = new URLSearchParams(window.location.search);
                if (urlParams.has('sort_by')) {
                    params.append('sort_by', urlParams.get('sort_by'));
                }
                if (urlParams.has('order')) {
                    params.append('order', urlParams.get('order'));
                }

                exportUrl += params.toString();
                $('#export-excel-btn').attr('href', exportUrl);
            }

            // ✅ EVENT HANDLERS

            // Search dengan debounce - Auto search seperti di halaman pelatih
            let searchTimeout;
            $(document).off('input.customFilter', '#search').on('input.customFilter', '#search', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    applyFilters();
                }, 300);
            });
            
            // Handle Enter key press
            $(document).off('keypress.customFilter', '#search').on('keypress.customFilter', '#search', function(e) {
                if (e.which === 13) { // Enter key
                    e.preventDefault();
                    applyFilters();
                    return false;
                }
            });
            
            // Function to apply filters (search and other filters)
            function applyFilters() {
                const url = buildURL();
                
                // Get search value
                const search = $('#search').val().trim();
                
                // Set or remove search parameter
                if (search) {
                    url.searchParams.set('search', search);
                } else {
                    url.searchParams.delete('search');
                }
                
                // Get status filter value
                const status = $('#filter-status').val();
                
                // Set or remove status parameter
                if (status) {
                    url.searchParams.set('status', status);
                } else {
                    url.searchParams.delete('status');
                }
                
                // Reset to first page when applying filters
                url.searchParams.delete('page');
                
                // Load filtered results
                loadTable(url.toString());
            }
            
            // Function to build URL with current parameters
            function buildURL() {
                return new URL(window.location.href);
            }
            
            // Function to load table with AJAX
            function loadTable(url) {
                console.log('🔍 Loading table with URL:', url);
                
                $.ajax({
                    url: url,
                    type: 'GET',
                    beforeSend: function() {
                        showTableLoading();
                    },
                    success: function(response) {
                        // Check if response is JSON or HTML
                        if (typeof response === 'object' && response.html) {
                            // JSON response with HTML content
                            $('#tableContainer').html(response.html);
                            if (response.pagination) {
                                $('.table-footer').html(response.pagination);
                            }
                        } else if (typeof response === 'string') {
                            // HTML response
                            try {
                                const $response = $(response);
                                const tableContent = $response.find('#tableContainer').html();
                                const paginationContent = $response.find('.table-footer').html();
                                
                                if (tableContent) {
                                    $('#tableContainer').html(tableContent);
                                }
                                if (paginationContent) {
                                    $('.table-footer').html(paginationContent);
                                }
                            } catch (e) {
                                // If parsing fails, assume it's direct HTML content
                                $('#tableContainer').html(response);
                            }
                        }
                        
                        // Update URL without reload
                        if (url !== window.location.href) {
                            window.history.pushState({}, '', url);
                            console.log('✅ URL updated:', url);
                        }
                        
                        // Update filter badge and export button
                        updateFilterCountBadge();
                        updateExportButtonUrl();
                    },
                    error: function(xhr) {
                        console.error('❌ AJAX error:', xhr);
                        showErrorToast('Gagal memuat data. Silakan coba lagi.');
                    },
                    complete: function() {
                        hideTableLoading();
                    }
                });
            }

            // Apply Filters Button - FIXED: Better event handling (like in pelatih page)
            $(document).off('click.customFilter', '#apply-filters').on('click.customFilter', '#apply-filters', function(e) {
                e.preventDefault();
                e.stopPropagation();
                applyFilters();
                return false;
            });

            // Reset Filters Button - FIXED: Better reset handling (like in pelatih page)
            $(document).off('click.customFilter', '#reset-filters').on('click.customFilter', '#reset-filters', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                // Clear all form inputs
                $('#search').val('');
                $('#filter-status').val('');
                
                // Build clean URL (preserve only per_page if different from default)
                const url = new URL(window.location.origin + window.location.pathname);
                const perPage = $('#ajax-per-page').val();
                if (perPage && perPage !== '10') {
                    url.searchParams.set('per_page', perPage);
                }
                
                // Close dropdown
                $('.dropdown-toggle').dropdown('hide');
                
                // Update filter badge
                updateFilterCountBadge();
                
                // Load clean results
                loadTable(url.toString());
                
                return false;
            });

            // Filter Status Change - FIXED: Prevent default (like in pelatih page)
            $(document).off('change.customFilter', '#filter-status').on('change.customFilter', '#filter-status', function(e) {
                e.preventDefault();
                applyFilters();
                return false;
            });

            // FIXED: Per Page Change Handler - Use event delegation (like in pelatih page)
            $(document).off('change.customFilter', '#ajax-per-page').on('change.customFilter', '#ajax-per-page', function(e) {
                e.preventDefault();
                e.stopPropagation();

                const perPageValue = $(this).val();
                console.log('📄 Per page changed:', perPageValue);

                // Build URL with new per_page value
                const url = buildURL();
                url.searchParams.set('per_page', perPageValue);
                url.searchParams.delete('page'); // Reset to first page
                
                loadTable(url.toString());

                return false;
            });

            // FIXED: Pagination Click Handler - Better event handling (like in pelatih page)
            $(document).off('click.customFilter', '.ajax-pagination').on('click.customFilter', '.ajax-pagination', function(e) {
                e.preventDefault();
                e.stopPropagation();

                const $this = $(this);
                const page = $this.data('page');

                console.log('📄 Pagination clicked, page:', page);

                if (page && !$this.hasClass('processing')) {
                    $this.addClass('processing');

                    // Build URL with new page value
                    const url = buildURL();
                    url.searchParams.set('page', page);
                    
                    loadTable(url.toString())
                        .always(() => {
                            setTimeout(() => {
                                $('.ajax-pagination').removeClass('processing');
                                updateExportButtonUrl(); // Update export button URL after pagination
                            }, 500);
                        });
                }

                return false;
            });

            // FIXED: Sorting Click Handler - Prevent any navigation (like in pelatih page)
            $(document).off('click.customFilter', '.ajax-sort').on('click.customFilter', '.ajax-sort', function(e) {
                e.preventDefault();
                e.stopPropagation();

                const $this = $(this);
                const sortBy = $this.data('sort');

                console.log('🔄 Sort button clicked, sort by:', sortBy);

                if (!sortBy || $this.hasClass('processing')) {
                    console.log('⚠️ No sort data found or already processing');
                    return false;
                }

                $this.addClass('processing');

                const url = buildURL();
                const currentSortBy = url.searchParams.get('sort_by');
                const currentOrder = url.searchParams.get('order');

                // Toggle order if same field, default to asc for new field
                let newOrder = 'asc';
                if (currentSortBy === sortBy && currentOrder === 'asc') {
                    newOrder = 'desc';
                }

                console.log('🔄 Sorting:', sortBy, newOrder);

                // Set new sorting parameters
                url.searchParams.set('sort_by', sortBy);
                url.searchParams.set('order', newOrder);
                url.searchParams.delete('page'); // Reset to first page
                
                loadTable(url.toString())
                    .always(() => {
                        setTimeout(() => {
                            $('.ajax-sort').removeClass('processing');
                            updateExportButtonUrl(); // Update export button URL after sorting
                        }, 500);
                    });

                return false;
            });

            // ✅ CRITICAL: Prevent ALL form submissions on this page
            $(document).off('submit.customFilter', 'form').on('submit.customFilter', 'form', function(e) {
                console.log('🛑 Form submission prevented');
                e.preventDefault();
                return false;
            });

            // ✅ CRITICAL: Prevent default link behavior for any AJAX elements
            $(document).off('click.customFilter', 'a[href*="sort_by"], a[href*="page"], .ajax-sort, .ajax-pagination').on('click.customFilter', 'a[href*="sort_by"], a[href*="page"], .ajax-sort, .ajax-pagination', function(
                e) {
                e.preventDefault();
                return false;
            });

            // ✅ Handle browser back/forward - FIXED: Better handling (like in pelatih page)
            window.addEventListener('popstate', function(event) {
                console.log('🔙 Browser back/forward detected');
                
                // Sync filters with current URL
                initializeFiltersFromURL();
                
                // Load table with current URL
                loadTable(window.location.href);
            });
            
            // ✅ Keyboard shortcuts (like in pelatih page)
            $(document).keydown(function(e) {
                if ((e.ctrlKey || e.metaKey) && e.keyCode === 70) { // Ctrl+F
                    e.preventDefault();
                    $('#search').focus();
                }

                if (e.keyCode === 27) { // Escape
                    $('#search').val('').trigger('input');
                }
            });

            // ✅ Cleanup on page unload
            $(window).on('beforeunload', function() {
                hideTableLoading();
                clearTimeout(searchTimeout);
                clearTimeout(clickTimeout);
                isLoading = false;
            });

            console.log('✅ FIXED Enhanced AJAX system initialized successfully');

            // ✅ Add debugging function
            window.testAjax = function() {
                console.log('🧪 Testing AJAX manually...');
                performAjaxRequest({
                    page: 1
                }, true);
            };

            // ✅ Final diagnostic
            setTimeout(() => {
                console.log('🔍 Final diagnostic:');
                console.log('- Search element:', $('#search').length);
                console.log('- Filter element:', $('#filter-status').length);
                console.log('- Table container:', $('#tableContainer').length);
                console.log('- Sort buttons:', $('.ajax-sort').length);
                console.log('- Pagination buttons:', $('.ajax-pagination').length);
                console.log('💡 Run testAjax() to test manually');
            }, 1000);
        });

        // ✅ Global functions for delete operations (outside document ready)
        window.showDeleteWarning = function(button, caborName, atletCount, pelatihCount) {
            // Build dependency list
            const dependencies = [];
            if (atletCount > 0) dependencies.push(`${atletCount} atlet`);
            if (pelatihCount > 0) dependencies.push(`${pelatihCount} pelatih`);

            // Create HTML for dependency list
            let dependencyListHtml = '';
            if (dependencies.length > 0) {
                dependencyListHtml = '<ul class="mt-2 text-start">';
                dependencies.forEach(dep => {
                    dependencyListHtml += `<li>${dep}</li>`;
                });
                dependencyListHtml += '</ul>';
            }

            Swal.fire({
                title: 'Tidak Dapat Menghapus Cabang Olahraga',
                html: `Cabang olahraga <strong>${caborName}</strong> tidak dapat dihapus karena masih memiliki:${dependencyListHtml}
                <p class="text-muted mt-3">
                    Silakan pindahkan atau hapus data tersebut terlebih dahulu, 
                    atau nonaktifkan cabang olahraga ini.
                </p>`,
                icon: "warning",
                confirmButtonText: 'Mengerti',
                width: '500px'
            });
        };

        window.confirmDelete = function(form) {
            const nama = form.querySelector('button[type="submit"]').title.replace('Hapus ', '');

            Swal.fire({
                title: "Apakah Anda Yakin?",
                html: "<p style='text-align:center'>Setelah data cabang olahraga dihapus, Anda tidak bisa mengembalikannya!</p>",
                icon: "warning",
                showCancelButton: true,
                reverseButtons: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Hapus!',
                cancelButtonText: 'Batalkan!'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Menghapus...',
                        text: 'Mohon tunggu',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        willOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Submit via AJAX
                    const formData = new FormData(form);
                    fetch(form.action, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content')
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: data.message || 'Data cabang olahraga berhasil dihapus',
                                    icon: 'success',
                                    timer: 2000,
                                    showConfirmButton: false
                                });

                                // Reload the table
                                window.location.reload();
                            } else {
                                Swal.fire({
                                    title: 'Error!',
                                    text: data.message || 'Gagal menghapus data cabang olahraga',
                                    icon: 'error'
                                });
                            }
                        })
                        .catch(error => {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Gagal menghapus data cabang olahraga',
                                icon: 'error'
                            });
                        });
                }
            });
            // Return false to prevent default form submission
            return false;
        };

        window.destroyItem = function(button) {
            const route = button.dataset.route;

            Swal.fire({
                title: "Apakah Anda Yakin?",
                html: "<p style='text-align:center'>Setelah data cabang olahraga dihapus, Anda tidak bisa mengembalikannya!</p>",
                icon: "warning",
                showCancelButton: true,
                reverseButtons: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Hapus!',
                cancelButtonText: 'Batalkan!'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Menghapus...',
                        text: 'Mohon tunggu',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        willOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    $.ajax({
                        url: route,
                        type: 'POST',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            _method: 'DELETE'
                        },
                        success: function(response) {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: response.message ||
                                    'Data cabang olahraga berhasil dihapus',
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false
                            });

                            // Reload current page to refresh the table
                            window.location.reload();
                        },
                        error: function(xhr) {
                            Swal.close();

                            try {
                                const response = JSON.parse(xhr.responseText);

                                if (response.reason === 'has_dependencies') {
                                    Swal.fire({
                                        title: 'Tidak Dapat Menghapus Cabang Olahraga',
                                        html: `Cabang olahraga <strong>${response.cabor_name}</strong> tidak dapat dihapus karena masih memiliki ${response.atlet_count + response.pelatih_count} data terkait.<br><br>
                                        <div class="text-start mt-3">
                                            <strong>Data yang terkait:</strong>
                                            <ul class="mt-2">
                                                ${response.atlet_count > 0 ? `<li>${response.atlet_count} atlet</li>` : ''}
                                                ${response.pelatih_count > 0 ? `<li>${response.pelatih_count} pelatih</li>` : ''}
                                            </ul>
                                        </div>
                                        <p class="text-muted mt-3">
                                            Silakan pindahkan atau hapus data yang terkait dengan cabang olahraga ini terlebih dahulu,
                                            atau nonaktifkan data cabang olahraga ini jika diperlukan.
                                        </p>`,
                                        icon: "warning",
                                        confirmButtonText: 'Mengerti',
                                        width: '500px'
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Error!',
                                        text: response.message ||
                                            'Gagal menghapus data cabang olahraga',
                                        icon: 'error'
                                    });
                                }
                            } catch (e) {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Gagal menghapus data cabang olahraga',
                                    icon: 'error'
                                });
                            }
                        }
                    });
                } else {
                    Swal.fire({
                        title: "Aksi Dibatalkan :)",
                        icon: "info",
                        timer: 1500,
                        showConfirmButton: false
                    });
                }
            });
        };
    </script>

    {{-- Notifikasi --}}
    @if (session('cabor_created'))
        <script>
            $(document).ready(() => toastr.success("{{ session('cabor_created') }}"));
        </script>
    @endif

    @if (session('cabor_updated'))
        <script>
            $(document).ready(() => toastr.success("{{ session('cabor_updated') }}"));
        </script>
    @endif

    @if (session('cabor_deleted'))
        <script>
            $(document).ready(() => toastr.success("{{ session('cabor_deleted') }}"));
        </script>
    @endif

    @if (session('error'))
        <script>
            $(document).ready(() => toastr.error("{{ session('error') }}"));
        </script>
    @endif

    @if (session('success'))
        <script>
            $(document).ready(() => toastr.success("{{ session('success') }}"));
        </script>
    @endif
@endsection
