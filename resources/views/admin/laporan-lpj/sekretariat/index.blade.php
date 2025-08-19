@extends('layouts.app')

@section('pageTitle', 'Manajemen Sekretariat')
@section('mainSection', 'Laporan Pertanggungjawaban')
@section('currentSection', 'Sekretariat')

@section('breadcrumb-title')
@endsection

@section('breadcrumb-items')
@endsection

@section('content')
    <style>
        body {
            background-color: #f5f5f5;
        }

        table td,
        table th {
            vertical-align: middle;
            word-wrap: break-word;
            max-width: 200px;
        }

        .object-fit-cover {
            object-fit: cover;
        }

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

        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

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
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            background: white;
            padding: 10px;
        }

        .preview-document {
            width: 100%;
            height: 80%;
            border: none;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
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

        .restricted-action {
            position: relative;
        }

        .restricted-action:hover {
            background-color: transparent !important;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <div class="d-flex flex-column mb-8">
        <h1 class="text-dark fw-bold mb-1">Laporan Sekretariat</h1>
        <div class="text-muted fw-semibold fs-6">Manajemen Laporan Sekretariat Anda Sekarang</div>
    </div>

    <div class="row col-12 mt-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap py-5">
                <h3 class="card-title fw-bold fs-4 mb-0">Daftar Table Sekretariat - 2025</h3>

                <div class="d-flex align-items-center gap-2 flex-wrap ms-auto">
                    @if (auth()->user()->hasRole('superadmin'))
                        <a href="{{ route('admin.laporan-lpj.sekretariat.create') }}" class="btn custom-red-button"
                            style="background-color: #F8285A !important; color: white !important; border-color: #F8285A !important;">
                            <i class="ki-duotone ki-plus fs-2" style="color: white !important;"></i>Tambah Laporan
                        </a>
                    @else
                        <div class="position-relative">
                            <button class="btn custom-red-button btn-restricted"
                                style="background-color: #F8285A !important; color: white !important; border-color: #F8285A !important;"
                                data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip"
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

                    <div class="input-group position-relative" style="width: 250px;">
                        <input type="search" name="search" id="search" class="form-control"
                            placeholder="Cari kegiatan..." value="{{ request('search') }}" autocomplete="off">

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

                    <div class="dropdown" style="z-index: 1055">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-filter me-1"></i> Filter
                            <span id="filter-count" class="badge badge-circle badge-danger ms-1 d-none">0</span>
                        </button>
                        <div class="dropdown-menu p-3 shadow" style="min-width: 320px;">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Jenis Kegiatan</label>
                                <select id="filter-jenis-kegiatan" class="form-select">
                                    <option value="">Semua Jenis</option>
                                    @foreach ($kegiatanLainnya->pluck('jenis_kegiatan')->unique()->filter() as $jenis)
                                        <option value="{{ $jenis }}"
                                            {{ request('jenis_kegiatan_filter') == $jenis ? 'selected' : '' }}>
                                            {{ $jenis }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

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

            <div class="card-body position-relative">
                <div class="loading-overlay d-none" id="loading-overlay">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>

                <div id="table-container">
                    @include('admin.laporan-lpj.sekretariat._table')
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header" style="background: #F8285A; color: white;">
                    <h5 class="modal-title text-white" id="previewModalLabel">Preview Files</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body p-0" style="height: 70vh;">
                    <div class="preview-container h-100 position-relative d-flex align-items-center justify-content-center"
                        style="background: #f8f9fa;">
                        <div id="previewSlides" class="w-100 h-100"></div>

                        <button type="button" id="prevBtn"
                            class="btn btn-primary position-absolute start-0 top-50 translate-middle-y ms-3"
                            style="z-index: 10; display: none;">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button type="button" id="nextBtn"
                            class="btn btn-primary position-absolute end-0 top-50 translate-middle-y me-3"
                            style="z-index: 10; display: none;">
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
    <!-- Modal Detail Card -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background: #F8285A; color: white;">
                    <h5 class="modal-title" id="detailModalLabel" style="color: white">Detail Kegiatan</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="detailModalBody">
                    <!-- Konten akan diisi via JavaScript -->
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
                const table = $("#kt_datatable_dom_positioning_kegiatan");

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
                var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
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
                } [type] || 'alert-info';

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

        function showDetailModal(kegiatan) {
            const modalBody = document.getElementById('detailModalBody');

            const formatRupiah = (num) => 'Rp ' + parseInt(num).toLocaleString('id-ID');

            let fotoHtml = '<div class="text-muted fst-italic">Tidak ada foto tersedia</div>';
            if (kegiatan.foto_jurnal && kegiatan.foto_jurnal.length > 0) {
                fotoHtml = `
            <div class="row g-3">
                ${kegiatan.foto_jurnal.map(f => `
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

            let dokumenHtml = '<div class="text-muted fst-italic">Tidak ada dokumen tersedia</div>';
            if (kegiatan.dokumen_pendukung && kegiatan.dokumen_pendukung.length > 0) {
                dokumenHtml = `
            <div class="d-flex flex-column gap-2">
                ${kegiatan.dokumen_pendukung.map(d => {
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
                        Informasi Program & Kegiatan
                    </h6>
                    <div class="bg-light p-3 rounded">
                        <div class="mb-2">
                            <label class="fw-semibold text-dark mb-1">Nama Kegiatan:</label>
                            <p class="mb-0 text-dark">${kegiatan.nama_program_kegiatan}</p>
                        </div>
                        ${kegiatan.jenis_kegiatan ? `
                                <div>
                                    <label class="fw-semibold text-dark mb-1">Jenis Kegiatan:</label>
                                    <p class="mb-0 text-dark">${kegiatan.jenis_kegiatan}</p>
                                </div>
                            ` : ''}
                    </div>
                </div>

                <div class="mb-4">
                    <h6 class="fw-bold text-success mb-3 d-flex align-items-center">
                        <i class="fas fa-calculator me-2"></i>
                        Rincian Anggaran
                    </h6>
                    <div class="bg-light p-3 rounded">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="fw-semibold text-dark mb-1">Volume:</label>
                                <p class="mb-0 text-dark fs-5 fw-bold">${kegiatan.volume}</p>
                            </div>
                            <div class="col-md-4">
                                <label class="fw-semibold text-dark mb-1">Harga Satuan:</label>
                                <p class="mb-0 text-dark fs-5 fw-bold">${formatRupiah(kegiatan.jumlah_harga_satuan)}</p>
                            </div>
                            <div class="col-md-4">
                                <label class="fw-semibold text-dark mb-1">Jumlah Harga:</label>
                                <p class="mb-0 text-success fs-5 fw-bold">${formatRupiah(kegiatan.jumlah_harga)}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h6 class="fw-bold text-warning mb-3 d-flex align-items-center">
                        <i class="fas fa-paperclip me-2"></i>
                        Lampiran
                    </h6>

                    <div class="mb-3">
                        <label class="fw-semibold text-dark mb-2 d-block">
                            <i class="fas fa-camera me-1"></i>Foto Jurnal:
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

                <div class="mb-2">
                    <h6 class="fw-bold text-info mb-3 d-flex align-items-center">
                        <i class="fas fa-sticky-note me-2"></i>
                        Keterangan Tambahan
                    </h6>
                    <div class="bg-light p-3 rounded">
                        ${kegiatan.keterangan_tambahan ?
                            `<p class="mb-0 text-dark">${kegiatan.keterangan_tambahan}</p>` :
                            '<div class="text-muted fst-italic">Tidak ada keterangan tambahan</div>'
                        }
                    </div>
                </div>

            </div>
        </div>
    `;

            const modal = new bootstrap.Modal(document.getElementById('detailModal'));
            modal.show();
        }
    </script>
@endsection
