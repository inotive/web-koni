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
                    return $currentOrder === 'asc'
                        ? '<i class="fas fa-sort-up"></i>'
                        : '<i class="fas fa-sort-down"></i>';
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

            .btn-filter {
                border: 1px solid #000;
                /* garis tipis hitam */
                border-radius: 6px;
                /* sudut melengkung */
                background-color: transparent;
                color: #000;
                padding: 0.375rem 0.75rem;
                font-size: 0.875rem;
                transition: all 0.2s ease-in-out;
            }

            .btn-filter:hover {
                background-color: rgba(0, 0, 0, 0.05);
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
                                                class="btn btn-success" id="export-excel-btn" title="Export ke Excel">
                                                <i class="fas fa-file-excel"></i>
                                            </a>

                                            <div class="input-group" style="width: 250px;">
                                                <input type="search" name="search" id="search" class="form-control"
                                                    placeholder="Cari cabang olahraga..." value="{{ request('search') }}">
                                                <button class="btn btn-outline-secondary" type="button">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>

                                            <div class="dropdown">
                                                <button class="btn btn-filter dropdown-toggle" type="button"
                                                    data-bs-toggle="dropdown">
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
                                                dari <span
                                                    id="total-count">{{ isset($cabors) ? $cabors->total() : 0 }}</span>
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

                // Base URL untuk AJAX requests
                const baseUrl = "{{ route('admin.konfigurasi.cabang-olahraga.index') }}";

                // Debug: Cek elemen yang diperlukan
                console.log('Search element:', $('#search').length > 0 ? 'FOUND' : 'NOT FOUND');
                console.log('Filter element:', $('#filter-status').length > 0 ? 'FOUND' : 'NOT FOUND');
                console.log('Table container:', $('#tableContainer').length > 0 ? 'FOUND' : 'NOT FOUND');

                // ✅ FIXED AJAX Request Function with proper error handling
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

                // ✅ NEW: Fallback to page reload
                function fallbackToPageReload(url) {
                    console.log('🔄 Falling back to page reload...');
                    setTimeout(() => {
                        window.location.href = url;
                    }, 1000);
                }

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

                // ✅ Update Filter Count Badge
                function updateFilterCountBadge() {
                    let count = 0;

                    const statusVal = $('#filter-status').val();
                    if (statusVal) count++;

                    const badge = $('#filter-count');
                    badge.text(count);
                    badge.toggleClass('d-none', count === 0);
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

                // Search dengan debounce - FIXED: Prevent default form submission
                $('#search').on('input', function(e) {
                    e.preventDefault();
                    clearTimeout(searchTimeout);
                    const searchValue = $(this).val().trim();

                    console.log('🔍 Search input:', searchValue);

                    searchTimeout = setTimeout(() => {
                        performAjaxRequest({
                            search: searchValue,
                            page: 1
                        });
                        updateFilterCountBadge();
                        updateExportButtonUrl(); // Update export button URL
                    }, 500);

                    return false; // Prevent any form submission
                });

                // FIXED: Prevent Enter key from submitting form in search
                $('#search').on('keypress', function(e) {
                    if (e.which === 13) { // Enter key
                        e.preventDefault();
                        clearTimeout(searchTimeout);

                        const searchValue = $(this).val().trim();
                        performAjaxRequest({
                            search: searchValue,
                            page: 1
                        });
                        updateFilterCountBadge();

                        return false;
                    }
                });

                // Filter Status Change - FIXED: Prevent default
                $(document).on('change', '#filter-status', function(e) {
                    e.preventDefault();
                    const statusValue = $(this).val();
                    console.log('🔽 Filter status changed:', statusValue);

                    performAjaxRequest({
                        status: statusValue,
                        page: 1
                    });
                    updateFilterCountBadge();

                    return false;
                });

                // Apply Filters Button - FIXED: Better event handling
                $(document).on('click', '#apply-filters', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    const statusValue = $('#filter-status').val();
                    const searchValue = $('#search').val().trim();

                    console.log('✅ Applying filters - Status:', statusValue, 'Search:', searchValue);

                    performAjaxRequest({
                        status: statusValue,
                        search: searchValue,
                        page: 1
                    });
                    updateFilterCountBadge();
                    updateExportButtonUrl(); // Update export button URL

                    return false;
                });

                // Reset Filters Button - FIXED: Better reset handling
                $(document).on('click', '#reset-filters', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    console.log('🔄 Resetting filters');

                    // Clear form fields
                    $('#search').val('');
                    $('#filter-status').val('');

                    // Make AJAX request with empty parameters
                    performAjaxRequest({
                        search: '',
                        status: '',
                        page: 1
                    });
                    updateFilterCountBadge();
                    updateExportButtonUrl(); // Update export button URL

                    return false;
                });

                // FIXED: Per Page Change Handler - Use event delegation
                $(document).on('change', '#ajax-per-page', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    const perPageValue = $(this).val();
                    console.log('📄 Per page changed:', perPageValue);

                    performAjaxRequest({
                        per_page: perPageValue,
                        page: 1
                    });

                    return false;
                });

                // FIXED: Pagination Click Handler - Better event handling
                $(document).on('click', '.ajax-pagination', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    const $this = $(this);
                    const page = $this.data('page');

                    console.log('📄 Pagination clicked, page:', page);

                    if (page && !$this.hasClass('processing')) {
                        $this.addClass('processing');

                        performAjaxRequest({
                                page: page
                            })
                            .always(() => {
                                setTimeout(() => {
                                    $('.ajax-pagination').removeClass('processing');
                                    updateExportButtonUrl
                                (); // Update export button URL after pagination
                                }, 500);
                            });
                    }

                    return false;
                });

                // FIXED: Sorting Click Handler - Prevent any navigation
                $(document).on('click', '.ajax-sort', function(e) {
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

                    const currentParams = new URLSearchParams(window.location.search);
                    const currentSortBy = currentParams.get('sort_by');
                    const currentOrder = currentParams.get('order');

                    // Toggle order if same field, default to asc for new field
                    let newOrder = 'asc';
                    if (currentSortBy === sortBy && currentOrder === 'asc') {
                        newOrder = 'desc';
                    }

                    console.log('🔄 Sorting:', sortBy, newOrder);

                    performAjaxRequest({
                            sort_by: sortBy,
                            order: newOrder,
                            page: 1
                        })
                        .always(() => {
                            setTimeout(() => {
                                $('.ajax-sort').removeClass('processing');
                                updateExportButtonUrl(); // Update export button URL after sorting
                            }, 500);
                        });

                    return false;
                });

                // ✅ CRITICAL: Prevent ALL form submissions on this page
                $(document).on('submit', 'form', function(e) {
                    console.log('🛑 Form submission prevented');
                    e.preventDefault();
                    return false;
                });

                // ✅ CRITICAL: Prevent default link behavior for any AJAX elements
                $(document).on('click', 'a[href*="sort_by"], a[href*="page"], .ajax-sort, .ajax-pagination', function(
                    e) {
                    e.preventDefault();
                    return false;
                });

                // ✅ Add export button click handler
                $('#export-excel-btn').on('click', function(e) {
                    e.preventDefault();
                    exportToExcel();
                });

                // ✅ Initialize on page load
                updateFilterCountBadge();
                updateExportButtonUrl(); // Update export button URL on page load

                // ✅ Handle browser back/forward - FIXED: Better handling
                window.addEventListener('popstate', function(event) {
                    console.log('🔙 Browser back/forward detected');

                    // Get parameters from current URL
                    const urlParams = new URLSearchParams(window.location.search);
                    const params = {};

                    for (let [key, value] of urlParams) {
                        params[key] = value;
                    }

                    // Update form fields to match URL
                    $('#search').val(params.search || '');
                    $('#filter-status').val(params.status || '');

                    // Make AJAX request to load content
                    performAjaxRequest(params, true);
                    updateFilterCountBadge();
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

            // ✅ Global function for export functionality
            window.exportToExcel = function() {
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

                // Redirect to export URL
                window.location.href = exportUrl;
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

                // Base URL untuk AJAX requests
                const baseUrl = "{{ route('admin.konfigurasi.cabang-olahraga.index') }}";

                // Debug: Cek elemen yang diperlukan
                console.log('Search element:', $('#search').length > 0 ? 'FOUND' : 'NOT FOUND');
                console.log('Filter element:', $('#filter-status').length > 0 ? 'FOUND' : 'NOT FOUND');
                console.log('Table container:', $('#tableContainer').length > 0 ? 'FOUND' : 'NOT FOUND');

                // ✅ FIXED AJAX Request Function with proper error handling
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

                // ✅ NEW: Fallback to page reload
                function fallbackToPageReload(url) {
                    console.log('🔄 Falling back to page reload...');
                    setTimeout(() => {
                        window.location.href = url;
                    }, 1000);
                }

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

                // ✅ Update Filter Count Badge
                function updateFilterCountBadge() {
                    let count = 0;

                    const statusVal = $('#filter-status').val();
                    if (statusVal) count++;

                    const badge = $('#filter-count');
                    badge.text(count);
                    badge.toggleClass('d-none', count === 0);
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

                // Search dengan debounce - FIXED: Prevent default form submission
                $('#search').on('input', function(e) {
                    e.preventDefault();
                    clearTimeout(searchTimeout);
                    const searchValue = $(this).val().trim();

                    console.log('🔍 Search input:', searchValue);

                    searchTimeout = setTimeout(() => {
                        performAjaxRequest({
                            search: searchValue,
                            page: 1
                        });
                        updateFilterCountBadge();
                        updateExportButtonUrl(); // Update export button URL
                    }, 500);

                    return false; // Prevent any form submission
                });

                // FIXED: Prevent Enter key from submitting form in search
                $('#search').on('keypress', function(e) {
                    if (e.which === 13) { // Enter key
                        e.preventDefault();
                        clearTimeout(searchTimeout);

                        const searchValue = $(this).val().trim();
                        performAjaxRequest({
                            search: searchValue,
                            page: 1
                        });
                        updateFilterCountBadge();

                        return false;
                    }
                });

                // Filter Status Change - FIXED: Prevent default
                $(document).on('change', '#filter-status', function(e) {
                    e.preventDefault();
                    const statusValue = $(this).val();
                    console.log('🔽 Filter status changed:', statusValue);

                    performAjaxRequest({
                        status: statusValue,
                        page: 1
                    });
                    updateFilterCountBadge();

                    return false;
                });

                // Apply Filters Button - FIXED: Better event handling
                $(document).on('click', '#apply-filters', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    const statusValue = $('#filter-status').val();
                    const searchValue = $('#search').val().trim();

                    console.log('✅ Applying filters - Status:', statusValue, 'Search:', searchValue);

                    performAjaxRequest({
                        status: statusValue,
                        search: searchValue,
                        page: 1
                    });
                    updateFilterCountBadge();
                    updateExportButtonUrl(); // Update export button URL

                    return false;
                });

                // Reset Filters Button - FIXED: Better reset handling
                $(document).on('click', '#reset-filters', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    console.log('🔄 Resetting filters');

                    // Clear form fields
                    $('#search').val('');
                    $('#filter-status').val('');

                    // Make AJAX request with empty parameters
                    performAjaxRequest({
                        search: '',
                        status: '',
                        page: 1
                    });
                    updateFilterCountBadge();
                    updateExportButtonUrl(); // Update export button URL

                    return false;
                });

                // FIXED: Per Page Change Handler - Use event delegation
                $(document).on('change', '#ajax-per-page', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    const perPageValue = $(this).val();
                    console.log('📄 Per page changed:', perPageValue);

                    performAjaxRequest({
                        per_page: perPageValue,
                        page: 1
                    });

                    return false;
                });

                // FIXED: Pagination Click Handler - Better event handling
                $(document).on('click', '.ajax-pagination', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    const $this = $(this);
                    const page = $this.data('page');

                    console.log('📄 Pagination clicked, page:', page);

                    if (page && !$this.hasClass('processing')) {
                        $this.addClass('processing');

                        performAjaxRequest({
                                page: page
                            })
                            .always(() => {
                                setTimeout(() => {
                                    $('.ajax-pagination').removeClass('processing');
                                    updateExportButtonUrl
                                (); // Update export button URL after pagination
                                }, 500);
                            });
                    }

                    return false;
                });

                // FIXED: Sorting Click Handler - Prevent any navigation
                $(document).on('click', '.ajax-sort', function(e) {
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

                    const currentParams = new URLSearchParams(window.location.search);
                    const currentSortBy = currentParams.get('sort_by');
                    const currentOrder = currentParams.get('order');

                    // Toggle order if same field, default to asc for new field
                    let newOrder = 'asc';
                    if (currentSortBy === sortBy && currentOrder === 'asc') {
                        newOrder = 'desc';
                    }

                    console.log('🔄 Sorting:', sortBy, newOrder);

                    performAjaxRequest({
                            sort_by: sortBy,
                            order: newOrder,
                            page: 1
                        })
                        .always(() => {
                            setTimeout(() => {
                                $('.ajax-sort').removeClass('processing');
                                updateExportButtonUrl(); // Update export button URL after sorting
                            }, 500);
                        });

                    return false;
                });

                // ✅ CRITICAL: Prevent ALL form submissions on this page
                $(document).on('submit', 'form', function(e) {
                    console.log('🛑 Form submission prevented');
                    e.preventDefault();
                    return false;
                });

                // ✅ CRITICAL: Prevent default link behavior for any AJAX elements
                $(document).on('click', 'a[href*="sort_by"], a[href*="page"], .ajax-sort, .ajax-pagination', function(
                    e) {
                    e.preventDefault();
                    return false;
                });

                // ✅ Add export button click handler
                $('#export-excel-btn').on('click', function(e) {
                    2 e.preventDefault();
                    3
                    4 // Get current filter values
                    5
                    const searchValue = $('#search').val();
                    6
                    const statusValue = $('#filter-status').val();
                    7
                    8 // Build URL with current filters
                    9
                    let exportUrl = "{{ route('admin.konfigurasi.cabang-olahraga.export') }}?";
                    10
                    const params = new URLSearchParams();
                    11
                    12
                    if (searchValue) {
                        13 params.append('search', searchValue);
                        14
                    }
                    15
                    16
                    if (statusValue) {
                        17 params.append('status', statusValue);
                        18
                    }
                    19
                    20 // Add current sorting parameters if they exist
                    21
                    const urlParams = new URLSearchParams(window.location.search);
                    22
                    if (urlParams.has('sort_by')) {
                        23 params.append('sort_by', urlParams.get('sort_by'));
                        24
                    }
                    25
                    if (urlParams.has('order')) {
                        26 params.append('order', urlParams.get('order'));
                        27
                    }
                    28
                    29 exportUrl += params.toString();
                    31 // Redirect to export URL
                    32 window.location.href = exportUrl;
                    33
                });


                // ✅ Initialize on page load
                updateFilterCountBadge();
                updateExportButtonUrl(); // Update export button URL on page load

                // ✅ Handle browser back/forward - FIXED: Better handling
                window.addEventListener('popstate', function(event) {
                    console.log('🔙 Browser back/forward detected');

                    // Get parameters from current URL
                    const urlParams = new URLSearchParams(window.location.search);
                    const params = {};

                    for (let [key, value] of urlParams) {
                        params[key] = value;
                    }

                    // Update form fields to match URL
                    $('#search').val(params.search || '');
                    $('#filter-status').val(params.status || '');

                    // Make AJAX request to load content
                    performAjaxRequest(params, true);
                    updateFilterCountBadge();
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

            // ✅ Global function for export functionality
            window.exportToExcel = function() {
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

                // Redirect to export URL
                window.location.href = exportUrl;
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
