@extends('layouts.app')

@section('pageTitle', 'PBVSI')
@section('mainSection', 'Laporan LPJ')
@section('subSection', 'Bidang Bidang')
@section('subSectionUrl', route('admin.laporan-lpj.bidang.index'))
@section('subSection2', 'Pembinaan Prestasi')
@section('subSection2Url', route('admin.laporan-lpj.bidang.prestasi.index'))
@section('subSection3', 'Cabor permainan')
@section('subSection3Url', route('admin.laporan-lpj.bidang.prestasi.cabor-permainan'))
@section('currentSection', 'PBVSI')

@section('breadcrumb-title')
@endsection

@section('breadcrumb-items')
@endsection

@section('content')
    <style>
        body {
            background-color: #f5f5f5;
        }

        /* Table styling */
        table td,
        table th {
            vertical-align: middle;
            word-wrap: break-word;
            max-width: 200px;
        }

        .object-fit-cover {
            object-fit: cover;
        }

        /* Column widths */
        .table th:nth-child(1) {
            width: 40px;
        }

        .table th:nth-child(2) {
            width: 250px;
        }

        .table th:nth-child(3) {
            width: 100px;
        }

        .table th:nth-child(4) {
            width: 150px;
        }

        .table th:nth-child(5) {
            width: 150px;
        }

        .table th:nth-child(6) {
            width: 100px;
        }

        .table th:nth-child(7) {
            width: 120px;
        }

        .table th:nth-child(8) {
            width: 80px;
        }

        .text-truncate-custom {
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* Dropdown styles from paste 1 and 2 */
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
        }

        .dropdown-toggle-custom:hover {
            background-color: rgba(0, 0, 0, 0.05);
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
        }

        .dropdown-menu-custom.show {
            display: block;
            animation: fadeIn 0.2s ease;
        }

        /* Dropup style */
        .dropup .dropdown-menu-custom {
            bottom: 100%;
            top: auto;
            margin-top: 0;
            margin-bottom: 5px;
        }

        .dropdown-item-custom {
            padding: 8px 16px;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            color: #495057;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .dropdown-item-custom i {
            margin-right: 8px;
            width: 20px;
            text-align: center;
        }

        .dropdown-item-custom:hover {
            background-color: #f8f9fa;
            text-decoration: none;
            color: #495057;
        }

        .dropdown-item-custom.edit:hover {
            background-color: rgb(249, 245, 172) !important;
        }

        .dropdown-item-custom.delete:hover {
            background-color: #ffcad7 !important;
        }

        /* Fixed dropdown styles */
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .table-responsive {
                overflow-x: auto !important;
                overflow-y: visible !important;
            }

            .dropdown-menu-custom {
                position: absolute !important;
                z-index: 9999 !important;
                right: 0 !important;
                left: auto !important;
                min-width: 140px;
            }
        }

        /* Pagination styling */
        .pagination-wrapper .pagination {
            margin-bottom: 0;
        }

        .pagination-wrapper .page-link {
            padding: 0.375rem 0.75rem;
            margin-left: -1px;
            color: #6c757d;
            background-color: #fff;
            border: 1px solid #dee2e6;
        }

        .pagination-wrapper .page-item.active .page-link {
            background-color: #F8285A;
            border-color: #F8285A;
            color: #fff;
        }

        .pagination-wrapper .page-link:hover {
            color: #495057;
            background-color: #e9ecef;
            border-color: #dee2e6;
        }

        /* Loading overlay */
        .loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        /* Custom tooltip styling to match the design */
        .custom-tooltip {
            --bs-tooltip-bg: #ffffff;
            --bs-tooltip-border-color: #e0e0e0;
            --bs-tooltip-color: #333333;
            --bs-tooltip-padding-x: 12px;
            --bs-tooltip-padding-y: 8px;
            --bs-tooltip-border-radius: 8px;
            --bs-tooltip-font-size: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            border: 1px solid var(--bs-tooltip-border-color);
        }

        .custom-tooltip .tooltip-inner {
            background-color: var(--bs-tooltip-bg);
            color: var(--bs-tooltip-color);
            border-radius: var(--bs-tooltip-border-radius);
            padding: var(--bs-tooltip-padding-y) var(--bs-tooltip-padding-x);
            text-align: left;
            max-width: 200px;
        }

        .custom-tooltip .tooltip-arrow::before {
            border-bottom-color: var(--bs-tooltip-bg);
            border-top-color: var(--bs-tooltip-bg);
        }

        .tooltip-content strong {
            color: #333333;
            font-weight: 600;
        }

        /* Restricted button styling */
        .btn-restricted {
            cursor: not-allowed !important;
            opacity: 0.6 !important;
            pointer-events: none;
        }

        .btn-restricted:hover {
            background-color: #F8285A !important;
            border-color: #F8285A !important;
            color: white !important;
        }

        /* Preview Modal Styles */
        .preview-slide {
            display: none;
            width: 100%;
            height: 100%;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 20px;
            position: absolute;
            top: 0;
            left: 0;
        }

        .preview-slide.active {
            display: flex;
        }

        .preview-image {
            max-width: 100%;
            max-height: 80%;
            object-fit: contain;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            background: white;
            padding: 10px;
        }

        .preview-document {
            width: 100%;
            height: 80%;
            border: none;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }

        .document-placeholder {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 80%;
            background: white;
            border: 2px dashed #dee2e6;
            border-radius: 8px;
            text-align: center;
            padding: 40px;
        }

        .document-placeholder i {
            font-size: 4rem;
            color: #6c757d;
            margin-bottom: 1rem;
        }

        .document-placeholder h5 {
            color: #495057;
            margin-bottom: 0.5rem;
        }

        .document-placeholder p {
            color: #6c757d;
            margin-bottom: 1rem;
        }

        .modal-header {
            background-color: #F8285A !important;
            color: white !important;
            border-bottom: 1px solid #F8285A !important;
        }

        /* Restricted action styling */
        .restricted-action {
            position: relative;
        }

        .restricted-action:hover {
            background-color: transparent !important;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

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

            /* Enhanced dropdown delete item styling */
            .dropdown-item-custom.delete:hover {
                background-color: #ffcad7 !important;
                color: #721c24;
            }
    </style>

    <div class="d-flex flex-column mb-8">
        <h1 class="text-dark fw-bold mb-1">Laporan PBVSI</h1>
    </div>

    {{-- Main Content Card --}}
    <div class="row col-12 mt-5">
        <div class="card">
            {{-- Card Header --}}
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap py-5">
                <h3 class="card-title fw-bold fs-4 mb-0">Daftar PBVSI - 2025</h3>

                {{-- Action Buttons --}}
                <div class="d-flex align-items-center gap-2 flex-wrap ms-auto">
                    {{-- Add Button with Access Control --}}
                    @if(auth()->user()->hasRole('superadmin'))
                        <a href="{{ route('admin.laporan-lpj.bidang.prestasi.cabor-permainan.PBVSI.create') }}" class="btn custom-red-button"
                            style="background-color: #F8285A !important; color: white !important; border-color: #F8285A !important;">
                            <i class="ki-duotone ki-plus fs-2" style="color: white !important;"></i>Tambah Laporan
                        </a>
                    @else
                        <div class="position-relative">
                            <button class="btn custom-red-button btn-restricted"
                                    style="background-color: #F8285A !important; color: white !important; border-color: #F8285A !important;"
                                    data-bs-toggle="tooltip"
                                    data-bs-placement="bottom"
                                    data-bs-custom-class="custom-tooltip"
                                    data-bs-html="true"
                                    title="<div class='tooltip-content'>
                                              <strong>Informasi</strong><br>
                                              Ajukan approval untuk<br>
                                              modifikasi laporan
                                           </div>">
                                <i class="ki-duotone ki-plus fs-2" style="color: white !important;"></i>Tambah Laporan
                            </button>
                        </div>
                    @endif

                    {{-- Search Input --}}
                    <div class="input-group position-relative" style="width: 250px;">
                        <input type="search" name="search" id="search" class="form-control"
                            placeholder="Cari program/kegiatan..." value="{{ request('search') }}" autocomplete="off">

                        <button class="btn btn-outline-secondary search-clear-btn d-none" type="button" id="clear-search"
                            style="position: absolute; right: 45px; z-index: 10; border: none; background: transparent; padding: 8px;">
                            <i class="fas fa-times text-muted"></i>
                        </button>

                        <button class="btn btn-outline-secondary" type="button" id="search-button">
                            <i class="fas fa-search"></i>
                        </button>

                        <div class="search-loading-indicator d-none position-absolute"
                            style="right: 50px; top: 50%; transform: translateY(-50%); z-index: 10;">
                            <div class="spinner-border spinner-border-sm text-primary" role="status">
                                <span class="visually-hidden">Cari Kegiatan...</span>
                            </div>
                        </div>
                    </div>

                    {{-- Filter Dropdown --}}
                    <div class="dropdown" style="z-index: 1055">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-filter me-1"></i> Filter
                            <span id="filter-count" class="badge badge-circle badge-danger ms-1 d-none">0</span>
                        </button>
                        <div class="dropdown-menu p-3 shadow" style="min-width: 320px;">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Nama Kegiatan</label>
                                <select id="filter-jenis-kegiatan" class="form-select">
                                    <option value="">Semua Kegiatan</option>
                                    @foreach ($PBVSIData->pluck('nama_program')->unique()->filter() as $kegiatan)
                                        <option value="{{ $kegiatan }}"
                                            {{ request('jenis_kegiatan_filter') == $kegiatan ? 'selected' : '' }}>
                                            {{ $kegiatan }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Filter Action Buttons --}}
                            <div class="d-flex gap-2">
                                <button type="button" id="apply-filters" class="btn btn-primary btn-sm flex-fill">
                                    <i class="ki-duotone ki-check fs-3"></i>Terapkan
                                </button>
                                <button type="button" id="reset-filters" class="btn btn-light btn-sm flex-fill">
                                    <i class="ki-duotone ki-arrows-circle fs-3"></i>Reset
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card Body --}}
            <div class="card-body position-relative">
                <div class="loading-overlay d-none" id="loading-overlay">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>

                <div id="table-container">
                    @include('admin.laporan-lpj.bidang.prestasi.permainan.PBVSI._table')
                </div>
            </div>
        </div>
    </div>

    {{-- Preview Modal --}}
    <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header" style="background: #F8285A; color: white;">
                    <h5 class="modal-title text-white" id="previewModalLabel">Preview Files</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0" style="height: 70vh;">
                    <div class="preview-container h-100 position-relative d-flex align-items-center justify-content-center" style="background: #f8f9fa;">
                        <!-- Slides will be dynamically inserted here -->
                        <div id="previewSlides" class="w-100 h-100"></div>

                        <!-- Navigation buttons -->
                        <button type="button" id="prevBtn" class="btn btn-primary position-absolute start-0 top-50 translate-middle-y ms-3" style="z-index: 10; display: none;">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button type="button" id="nextBtn" class="btn btn-primary position-absolute end-0 top-50 translate-middle-y me-3" style="z-index: 10; display: none;">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <div class="d-flex justify-content-between align-items-center w-100">
                        <div>
                            <strong id="currentFileName">File Name</strong>
                            <div class="text-muted small" id="fileCounter">1 of 1</div>
                        </div>
                        <div>
                            <button type="button" id="downloadBtn" class="btn btn-success btn-sm me-2">
                                <i class="fas fa-download"></i> Download
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Detail Modal Card --}}
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background: #F8285A; color: white;">
                    <h5 class="modal-title" id="detailModalLabel" style="color: white">Detail Mobilisasi Sumber Daya</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="detailModalBody">
                    <!-- Content will be populated by JavaScript -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            let dataTable = null;
            let searchTimeout;
            let isSearching = false;

            function initializeDataTable() {
                const table = $("#kt_datatable_dom_positioning_sumberdaya");

                if (dataTable) {
                    dataTable.destroy();
                }

                if (table.length > 0) {
                    dataTable = table.DataTable({
                        paging: false,
                        info: false,
                        searching: false,
                        ordering: false,
                        responsive: false,
                        autoWidth: false,
                        scrollX: false,
                        language: {
                            emptyTable: "Data tidak ditemukan",
                            zeroRecords: "Tidak ada data yang cocok dengan pencarian"
                        },
                        columnDefs: [{
                            targets: -1,
                            orderable: false,
                            searchable: false
                        }]
                    });
                }
            }

            initializeDataTable();

            function initializeTooltips() {
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl, {
                        trigger: 'hover focus'
                    });
                });
            }

            function initializeDropdownEvents() {
                $(document).off('click', '.dropdown-toggle-custom');
                $(document).off('mouseenter', '.dropdown-action');
                $(document).off('mouseleave', '.dropdown-action');

                $(document).on('click', '.dropdown-toggle-custom', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    const $dropdownAction = $(this).closest('.dropdown-action');
                    const $menu = $dropdownAction.find('.dropdown-menu-custom');

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

                    if (rowIndex === totalRows - 1) {
                        $dropdownAction.addClass('dropup');
                    }
                }

                $(document).on('click', function(e) {
                    if (!$(e.target).closest('.dropdown-action').length) {
                        $('.dropdown-menu-custom').removeClass('show');
                    }
                });

                $(window).on('resize', function() {
                    $('.dropdown-action').each(function() {
                        if ($(this).find('.dropdown-menu-custom').hasClass('show')) {
                            checkDropdownPosition($(this));
                        }
                    });
                });

                if (window.innerWidth > 768) {
                    $(document).on('mouseenter', '.dropdown-action', function() {
                        const $menu = $(this).find('.dropdown-menu-custom');
                        $menu.addClass('show');
                        checkDropdownPosition($(this));
                    }).on('mouseleave', '.dropdown-action', function() {
                        const $menu = $(this).find('.dropdown-menu-custom');
                        setTimeout(() => {
                            if (!$menu.is(':hover')) {
                                $menu.removeClass('show');
                            }
                        }, 100);
                    });

                    $(document).on('mouseenter', '.dropdown-menu-custom', function() {
                        clearTimeout($(this).data('timeout'));
                    }).on('mouseleave', '.dropdown-menu-custom', function() {
                        const $menu = $(this);
                        $menu.data('timeout', setTimeout(() => {
                            $menu.removeClass('show');
                        }, 200));
                    });
                }
            }

            initializeTooltips();
            initializeDropdownEvents();

            function showLoading() {
                $('#loading-overlay').removeClass('d-none');
            }

            function hideLoading() {
                $('#loading-overlay').addClass('d-none');
            }

            function showSearchLoading() {
                if (!isSearching) {
                    isSearching = true;
                    $('.search-loading-indicator').removeClass('d-none');
                    $('#search-button').find('i').removeClass('fa-search').addClass('fa-spinner fa-spin');
                }
            }

            function hideSearchLoading() {
                isSearching = false;
                $('.search-loading-indicator').addClass('d-none');
                $('#search-button').find('i').removeClass('fa-spinner fa-spin').addClass('fa-search');
            }

            function toggleClearButton() {
                const $searchInput = $('#search');
                const $clearBtn = $('#clear-search');

                if ($searchInput.val().length > 0) {
                    $clearBtn.removeClass('d-none');
                } else {
                    $clearBtn.addClass('d-none');
                }
            }

            function performSearch(searchValue, immediate = false) {
                if (searchTimeout) {
                    clearTimeout(searchTimeout);
                }

                if (immediate || searchValue === '') {
                    doSearch(searchValue);
                } else {
                    searchTimeout = setTimeout(() => {
                        doSearch(searchValue);
                    }, 300);
                }
            }

            function doSearch(searchValue) {
                showSearchLoading();

                updateTable({
                    'search': searchValue
                }).finally(() => {
                    hideSearchLoading();
                });
            }

            function updateTable(params = {}) {
                return new Promise((resolve, reject) => {
                    if (params.search === undefined) {
                        showLoading();
                    }

                    const currentUrl = new URL(window.location.href);

                    for (const key in params) {
                        if (params[key] !== null && params[key] !== undefined && params[key] !== '') {
                            currentUrl.searchParams.set(key, params[key]);
                        } else {
                            currentUrl.searchParams.delete(key);
                        }
                    }

                    if (params.search !== undefined || params.jenis_kegiatan_filter !== undefined) {
                        if (!params.page) {
                            currentUrl.searchParams.set('page', 1);
                        }
                    }

                    $.ajax({
                        url: currentUrl.toString(),
                        type: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        success: function(response) {
                            $('#table-container').html(response);
                            hideLoading();

                            window.history.pushState(null, null, currentUrl.toString());

                            initializeDataTable();
                            initializeTooltips();
                            initializeDropdownEvents();
                            updateFilterCount();

                            resolve(response);
                        },
                        error: function(xhr, status, error) {
                            hideLoading();

                            const errorMsg = xhr.status === 0 ?
                                'Koneksi terputus. Silakan coba lagi.' :
                                'Terjadi kesalahan saat memuat data.';

                            showNotification(errorMsg, 'error');
                            reject(error);
                        }
                    });
                });
            }

            function showNotification(message, type = 'info') {
                const alertClass = {
                    'success': 'alert-success',
                    'error': 'alert-danger',
                    'warning': 'alert-warning',
                    'info': 'alert-info'
                }[type] || 'alert-info';

                const notification = $(`
                    <div class="alert ${alertClass} alert-dismissible fade show notification-toast"
                         role="alert" style="position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
                        ${message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                `);

                $('body').append(notification);

                setTimeout(() => {
                    notification.alert('close');
                }, 5000);
            }

            $('#search').on('input', function() {
                const searchValue = $(this).val().trim();
                toggleClearButton();
                performSearch(searchValue);
            });

            $('#clear-search').on('click', function() {
                $('#search').val('').focus();
                toggleClearButton();
                performSearch('', true);
            });

            $('#search-button').on('click', function() {
                const searchValue = $('#search').val().trim();
                performSearch(searchValue, true);
            });

            $('#search').on('keydown', function(e) {
                switch (e.key) {
                    case 'Escape':
                        $(this).val('');
                        toggleClearButton();
                        performSearch('', true);
                        break;

                    case 'Enter':
                        e.preventDefault();
                        const searchValue = $(this).val().trim();
                        performSearch(searchValue, true);
                        break;
                }
            });

            $('#search').on('focus', function() {
                $(this).select();
            });

            toggleClearButton();

            $('#apply-filters').on('click', function() {
                const jenisKegiatan = $('#filter-jenis-kegiatan').val();
                const startDate = $('#filter-start-date').val();
                const endDate = $('#filter-end-date').val();

                updateTable({
                    'jenis_kegiatan_filter': jenisKegiatan,
                    'start_date': startDate,
                    'end_date': endDate
                });
            });

            $('#reset-filters').on('click', function() {
                $('#filter-jenis-kegiatan').val('');
                $('#filter-start-date').val('');
                $('#filter-end-date').val('');
                $('#search').val('');
                toggleClearButton();

                updateTable({
                    'search': '',
                    'jenis_kegiatan_filter': '',
                    'start_date': '',
                    'end_date': ''
                });
            });

            $(document).on('change', '#per-page-select', function() {
                updateTable({
                    'per_page': $(this).val()
                });
            });

            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();
                const url = new URL($(this).attr('href'));
                const page = url.searchParams.get('page');

                updateTable({
                    'page': page
                });
            });

            $(document).on('click', '.sortable-header', function(e) {
                e.preventDefault();
                const url = new URL($(this).attr('href'));
                const sort = url.searchParams.get('sort');
                const direction = url.searchParams.get('direction');

                updateTable({
                    'sort': sort,
                    'direction': direction
                });
            });

            function updateFilterCount() {
                const urlParams = new URLSearchParams(window.location.search);
                let count = 0;

                if (urlParams.get('jenis_kegiatan_filter')) count++;
                if (urlParams.get('start_date') || urlParams.get('end_date')) count++;
                if (urlParams.get('search')) count++;

                const badge = $('#filter-count');
                if (count > 0) {
                    badge.text(count).removeClass('d-none');
                } else {
                    badge.addClass('d-none');
                }
            }

            updateFilterCount();

            // Preview Modal functionality
            let currentFiles = [];
            let currentIndex = 0;
            let currentType = '';

            const previewModal = document.getElementById('previewModal');
            const previewSlides = document.getElementById('previewSlides');
            const currentFileName = document.getElementById('currentFileName');
            const fileCounter = document.getElementById('fileCounter');
            const downloadBtn = document.getElementById('downloadBtn');
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');
            const modalTitle = document.getElementById('previewModalLabel');

            $(document).on('click', '.preview-btn', function() {
                const btn = $(this);
                currentFiles = JSON.parse(btn.attr('data-files'));
                currentType = btn.attr('data-type');
                currentIndex = 0;
                modalTitle.textContent = btn.attr('data-title');

                loadPreview();
            });

            function loadPreview() {
                previewSlides.innerHTML = '';

                currentFiles.forEach((file, index) => {
                    const slide = document.createElement('div');
                    slide.className = `preview-slide ${index === currentIndex ? 'active' : ''}`;

                    if (currentType === 'image') {
                        slide.innerHTML = `
                            <img src="/storage/${file}" alt="Preview" class="preview-image">
                        `;
                    } else {
                        const fileName = file.split('/').pop();
                        const fileExtension = fileName.split('.').pop().toLowerCase();

                        if (fileExtension === 'pdf') {
                            slide.innerHTML = `
                                <iframe src="/storage/${file}" class="preview-document"></iframe>
                            `;
                        } else {
                            const iconClass = getFileIcon(fileExtension);
                            slide.innerHTML = `
                                <div class="document-placeholder">
                                    <i class="${iconClass}"></i>
                                    <h5>${fileName}</h5>
                                    <p>Click download to view this ${fileExtension.toUpperCase()} file</p>
                                    <a href="/storage/${file}" class="btn btn-primary" target="_blank">
                                        <i class="fas fa-external-link-alt me-2"></i>Open File
                                    </a>
                                </div>
                            `;
                        }
                    }

                    previewSlides.appendChild(slide);
                });

                updateUI();
            }

            function updateUI() {
                const fileName = currentFiles[currentIndex].split('/').pop();
                currentFileName.textContent = fileName;
                fileCounter.textContent = `${currentIndex + 1} of ${currentFiles.length}`;

                if (currentFiles.length > 1) {
                    prevBtn.style.display = 'block';
                    nextBtn.style.display = 'block';
                } else {
                    prevBtn.style.display = 'none';
                    nextBtn.style.display = 'none';
                }

                downloadBtn.onclick = function() {
                    window.open('/storage/' + currentFiles[currentIndex], '_blank');
                };
            }

            function showSlide(index) {
                document.querySelectorAll('.preview-slide').forEach((slide, i) => {
                    slide.classList.toggle('active', i === index);
                });
                currentIndex = index;
                updateUI();
            }

            prevBtn.addEventListener('click', function() {
                const newIndex = currentIndex > 0 ? currentIndex - 1 : currentFiles.length - 1;
                showSlide(newIndex);
            });

            nextBtn.addEventListener('click', function() {
                const newIndex = currentIndex < currentFiles.length - 1 ? currentIndex + 1 : 0;
                showSlide(newIndex);
            });

            document.addEventListener('keydown', function(e) {
                if (previewModal.classList.contains('show')) {
                    if (e.key === 'ArrowLeft') {
                        prevBtn.click();
                    } else if (e.key === 'ArrowRight') {
                        nextBtn.click();
                    }
                }
            });

            function getFileIcon(extension) {
                const icons = {
                    'pdf': 'fas fa-file-pdf text-danger',
                    'doc': 'fas fa-file-word text-primary',
                    'docx': 'fas fa-file-word text-primary',
                    'xls': 'fas fa-file-excel text-success',
                    'xlsx': 'fas fa-file-excel text-success',
                    'ppt': 'fas fa-file-powerpoint text-warning',
                    'pptx': 'fas fa-file-powerpoint text-warning'
                };
                return icons[extension] || 'fas fa-file text-muted';
            }

            $('#previewModal').on('show.bs.modal', function() {
                if (currentFiles.length > 0) {
                    showSlide(0);
                }
            });

            const additionalCSS = `
                <style id="enhanced-search-styles">
                    .search-loading-indicator {
                        pointer-events: none;
                    }

                    .search-clear-btn {
                        opacity: 0.7;
                        transition: opacity 0.2s ease;
                    }

                    .search-clear-btn:hover {
                        opacity: 1;
                    }

                    #search:focus {
                        box-shadow: 0 0 0 0.2rem rgba(248, 40, 90, 0.25);
                        border-color: #F8285A;
                    }

                    .notification-toast {
                        animation: slideInRight 0.3s ease-out;
                    }

                    @keyframes slideInRight {
                        from {
                            transform: translateX(100%);
                            opacity: 0;
                        }
                        to {
                            transform: translateX(0);
                            opacity: 1;
                        }
                    }

                    #search.searching {
                        background-image: url("data:image/svg+xml,%3csvg width='20' height='20' viewBox='0 0 20 20' xmlns='http://www.w3.org/2000/svg'%3e%3cg fill='none' fill-rule='evenodd'%3e%3cg fill='%23999' fill-rule='nonzero'%3e%3cpath d='M10 3a7 7 0 1 0 0 14 7 7 0 0 0 0-14zm0-3a10 10 0 1 1 0 20 10 10 0 0 1 0-20z'/%3e%3cpath d='M10 7a3 3 0 1 0 0 6 3 3 0 0 0 0-6zm0-2a5 5 0 1 1 0 10 5 5 0 0 1 0-10z'/%3e%3c/g%3e%3c/g%3e%3c/svg%3e");
                        background-repeat: no-repeat;
                        background-position: right 45px center;
                        animation: spin 1s linear infinite;
                    }

                    @keyframes spin {
                        to { transform: rotate(360deg); }
                    }
                </style>
            `;

            if (!$('#enhanced-search-styles').length) {
                $('head').append(additionalCSS);
            }
        });

        // Detail Modal Function - adapted for Mobilisasi Sumber Daya
        function showDetailModal(PBVSI) {
            const modalBody = document.getElementById('detailModalBody');

            const formatRupiah = (num) => 'Rp ' + parseInt(num).toLocaleString('id-ID');

            // Handle foto_kegiatan display
            let fotoHtml = '<div class="text-muted fst-italic">Tidak ada foto tersedia</div>';
            if (PBVSI.foto_jurnal && PBVSI.foto_jurnal.length > 0) {
                fotoHtml = `
                    <div class="row g-3">
                        ${PBVSI.foto_jurnal.map(f => `
                            <div class="col-6 col-md-4">
                                <div class="border rounded overflow-hidden" style="height: 120px;">
                                    <img src="/storage/${f}"
                                         class="w-100 h-100"
                                         style="object-fit: cover; cursor: pointer;"
                                         onclick="window.open('/storage/${f}', '_blank')">
                                </div>
                            </div>
                        `).join('')}
                    </div>
                `;
            }

            // Handle dokumen_pendukung display
            let dokumenHtml = '<div class="text-muted fst-italic">Tidak ada dokumen tersedia</div>';
            if (PBVSI.dokumen_lpj && PBVSI.dokumen_lpj.length > 0) {
                dokumenHtml = `
                    <div class="d-flex flex-column gap-2">
                        ${PBVSI.dokumen_lpj.map(d => {
                            const name = d.split('/').pop();
                            const extension = name.split('.').pop().toLowerCase();

                            let iconClass = 'fas fa-file text-secondary';
                            if (extension === 'pdf') iconClass = 'fas fa-file-pdf text-danger';
                            else if (['doc', 'docx'].includes(extension)) iconClass = 'fas fa-file-word text-primary';
                            else if (['xls', 'xlsx'].includes(extension)) iconClass = 'fas fa-file-excel text-success';
                            else if (['jpg', 'jpeg', 'png', 'gif'].includes(extension)) iconClass = 'fas fa-file-image text-info';

                            return `
                                <div class="d-flex align-items-center p-2 border rounded bg-light">
                                    <i class="${iconClass} me-3" style="font-size: 1.2em;"></i>
                                    <div class="flex-grow-1">
                                        <div class="fw-medium text-dark">${name}</div>
                                        <small class="text-muted">${extension.toUpperCase()}</small>
                                    </div>
                                    <a href="/storage/${d}"
                                       target="_blank"
                                       class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-download me-1"></i>Unduh
                                    </a>
                                </div>
                            `;
                        }).join('')}
                    </div>
                `;
            }

            modalBody.innerHTML = `
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">

                        <div class="mb-4">
                            <h6 class="fw-bold text-primary mb-3 d-flex align-items-center">
                                <i class="fas fa-info-circle me-2"></i>
                                Informasi Kegiatan
                            </h6>
                            <div class="bg-light p-3 rounded">
                                <div class="mb-2">
                                    <label class="fw-semibold text-dark mb-1">Nama Kegiatan & Program:</label>
                                    <p class="mb-0 text-dark">${PBVSI.nama_program}</p>
                                    <small class="text-muted">${PBVSI.nama_kegiatan}</small>
                                </div>
                                ${PBVSI.tempat_kegiatan ? `
                                    <div class="mb-2">
                                        <label class="fw-semibold text-dark mb-1">Tempat Kegiatan:</label>
                                        <p class="mb-0 text-dark">${PBVSI.tempat_kegiatan}</p>
                                    </div>
                                ` : ''}
                                ${PBVSI.tanggal_kegiatan ? `
                                    <div>
                                        <label class="fw-semibold text-dark mb-1">Tanggal Kegiatan:</label>
                                        <p class="mb-0 text-dark">${new Date(PBVSI.tanggal_kegiatan).toLocaleDateString('id-ID')}</p>
                                    </div>
                                ` : ''}
                            </div>
                        </div>

                        ${PBVSI.jumlah_anggaran ? `
                            <div class="mb-4">
                                <h6 class="fw-bold text-success mb-3 d-flex align-items-center">
                                    <i class="fas fa-calculator me-2"></i>
                                    Rincian Anggaran
                                </h6>
                                <div class="bg-light p-3 rounded">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="fw-semibold text-dark mb-1">Total Anggaran:</label>
                                            <p class="mb-0 text-success fs-5 fw-bold">${formatRupiah(PBVSI.jumlah_anggaran)}</p>
                                        </div>
                                        ${PBVSI.jumlah_realisasi ? `
                                            <div class="col-md-6">
                                                <label class="fw-semibold text-dark mb-1">Realisasi:</label>
                                                <p class="mb-0 text-info fs-5 fw-bold">${formatRupiah(PBVSI.jumlah_realisasi)}</p>
                                            </div>
                                        ` : ''}
                                    </div>
                                </div>
                            </div>
                        ` : ''}

                        ${PBVSI.sumber_dana ? `
                            <div class="mb-4">
                                <h6 class="fw-bold text-info mb-3 d-flex align-items-center">
                                    <i class="fas fa-money-bill me-2"></i>
                                    Sumber Dana
                                </h6>
                                <div class="bg-light p-3 rounded">
                                    <p class="mb-0 text-dark">${PBVSI.sumber_dana}</p>
                                </div>
                            </div>
                        ` : ''}

                        <div class="mb-4">
                            <h6 class="fw-bold text-warning mb-3 d-flex align-items-center">
                                <i class="fas fa-paperclip me-2"></i>
                                Lampiran
                            </h6>

                            <div class="mb-3">
                                <label class="fw-semibold text-dark mb-2 d-block">
                                    <i class="fas fa-camera me-1"></i>Foto Kegiatan:
                                </label>
                                <div class="bg-light p-3 rounded">
                                    ${fotoHtml}
                                </div>
                            </div>

                            <div>
                                <label class="fw-semibold text-dark mb-2 d-block">
                                    <i class="fas fa-file-alt me-1"></i>Dokumen Pendukung:
                                </label>
                                <div class="bg-light p-3 rounded">
                                    ${dokumenHtml}
                                </div>
                            </div>
                        </div>

                        ${PBVSI.keterangan ? `
                            <div class="mb-2">
                                <h6 class="fw-bold text-secondary mb-3 d-flex align-items-center">
                                    <i class="fas fa-sticky-note me-2"></i>
                                    Keterangan
                                </h6>
                                <div class="bg-light p-3 rounded">
                                    <p class="mb-0 text-dark">${PBVSI.keterangan}</p>
                                </div>
                            </div>
                        ` : ''}

                    </div>
                </div>
            `;

            const modal = new bootstrap.Modal(document.getElementById('detailModal'));
            modal.show();
        }
    </script>

    <script>
$(document).ready(function() {
        let deleteId = null;
        let deleteItemName = null;

        // Enhanced delete function (similar to deleteItemEnhanced from paste 1)
        function deleteItemEnhanced(itemId, itemName = 'item ini') {
            // Set the delete ID and item name
            deleteId = itemId;
            deleteItemName = itemName;

            // Update modal content
            $('#deleteId').val(deleteId);
            $('#deleteItemName').text(itemName);

            // Show the modal
            $('#deleteModal').modal('show');
        }

        // When delete button is clicked from dropdown
        $(document).on('click', '.dropdown-item-custom.delete', function(e) {
            e.preventDefault();
            const itemId = $(this).data('id');
            const itemName = $(this).data('name') || 'laporan ini';
            deleteItemEnhanced(itemId, itemName);
        });

        // Handle delete submit with enhanced functionality
        $('#submitBtnDelete').on('click', function() {
            if (!deleteId) {
                toastr.error("ID laporan tidak ditemukan", "Error!");
                return;
            }

            const submitBtn = $(this);
            const url = "{{ route('admin.laporan-lpj.bidang.prestasi.cabor-permainan.PBVSI.destroy', ':id') }}".replace(':id', deleteId);

            // Add loading state
            submitBtn.addClass('btn-loading');
            submitBtn.prop('disabled', true);

            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    _method: 'DELETE'
                },
                success: function(response) {
                    // Remove loading state
                    submitBtn.removeClass('btn-loading');
                    submitBtn.prop('disabled', false);

                    // Close modal
                    $('#deleteModal').modal('hide');

                    // Show success message
                    if (typeof toastr !== 'undefined') {
                        toastr.success(response.message || "Laporan berhasil dihapus", "Success!");
                    } else {
                        alert(response.message || "Laporan berhasil dihapus");
                    }

                    // Reload table if updateTable function exists, otherwise reload page
                    if (typeof updateTable === 'function') {
                        updateTable();
                    } else {
                        location.reload();
                    }
                },
                error: function(xhr) {
                    // Remove loading state
                    submitBtn.removeClass('btn-loading');
                    submitBtn.prop('disabled', false);

                    const errorMsg = xhr.responseJSON?.message || 'Gagal menghapus laporan';

                    if (typeof toastr !== 'undefined') {
                        toastr.error(errorMsg, "Error!");
                    } else {
                        alert(errorMsg);
                    }
                }
            });
        });

        // Reset modal when closed
        $('#deleteModal').on('hidden.bs.modal', function () {
            deleteId = null;
            deleteItemName = null;
            $('#deleteId').val('');
            $('#deleteItemName').text('item ini');

            // Remove loading state if still present
            $('#submitBtnDelete').removeClass('btn-loading').prop('disabled', false);
        });

        // Alternative: Use SweetAlert2 for delete confirmation (like in paste 1)
        function deleteItemWithSwal(itemId, itemName = 'item ini') {
            const url = "{{ route('admin.laporan-lpj.bidang.prestasi.cabor-permainan.PBVSI.destroy', ':id') }}".replace(':id', itemId);

            Swal.fire({
                title: "Apakah Anda Yakin?",
                html: `<p style='text-align:center'>Setelah <strong>${itemName}</strong> dihapus, Anda tidak bisa mengembalikannya!</p>`,
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
                        willOpen: () => Swal.showLoading()
                    });

                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            _method: 'DELETE'
                        },
                        success: function(response) {
                            Swal.close();
                            if (response.success !== false) {
                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: response.message || 'Laporan berhasil dihapus',
                                    icon: 'success',
                                    timer: 2000,
                                    showConfirmButton: false
                                });

                                // Reload table
                                if (typeof updateTable === 'function') {
                                    updateTable();
                                } else {
                                    location.reload();
                                }
                            } else {
                                Swal.fire({
                                    title: 'Gagal!',
                                    text: response.message || 'Terjadi kesalahan saat menghapus',
                                    icon: 'error'
                                });
                            }
                        },
                        error: function(xhr) {
                            Swal.close();
                            Swal.fire({
                                title: 'Error!',
                                text: xhr.responseJSON?.message || 'Terjadi kesalahan jaringan.',
                                icon: 'error'
                            });
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
        }

        // Make functions globally available
        window.deleteItemEnhanced = deleteItemEnhanced;
        window.deleteItemWithSwal = deleteItemWithSwal;
    });
    </script>
@endsection
