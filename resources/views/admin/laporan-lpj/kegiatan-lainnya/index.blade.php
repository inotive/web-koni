@extends('layouts.app')

@section('pageTitle', 'Manajemen Kegiatan Lainnya')
@section('mainSection', 'Laporan Pertanggungjawaban')
@section('currentSection', 'Kegiatan Lainnya')

@section('breadcrumb-title')
    {{-- H1 untuk judul utama halaman --}}
@endsection

@section('breadcrumb-items')
    {{-- Breadcrumb items jika diperlukan --}}
@endsection

@section('content')

    <style>
        body {
            background-color: #f5f5f5;
        }

        /* Table fixed layout for consistent column alignment */
        .table-fixed {
            table-layout: fixed;
        }

        .table-fixed th:nth-child(1),
        .table-fixed td:nth-child(1) {
            width: 40px !important;
        }

        .table-fixed th:nth-child(2),
        .table-fixed td:nth-child(2) {
            width: 280px !important; /* Increased from 250px */
        }

        .table-fixed th:nth-child(3),
        .table-fixed td:nth-child(3) {
            width: 120px !important; /* Increased from 100px */
        }

        .table-fixed th:nth-child(4),
        .table-fixed td:nth-child(4) {
            width: 170px !important; /* Increased from 150px */
        }

        .table-fixed th:nth-child(5),
        .table-fixed td:nth-child(5) {
            width: 170px !important; /* Increased from 150px */
        }

        .table-fixed th:nth-child(6),
        .table-fixed td:nth-child(6) {
            width: 120px !important; /* Increased from 100px */
        }

        .table-fixed th:nth-child(7),
        .table-fixed td:nth-child(7) {
            width: 120px !important; /* Same as before for Dokumen column */
        }

        .table-fixed th:nth-child(8),
        .table-fixed td:nth-child(8) {
            width: 80px !important; /* This is now the Action column (previously 9th) */
        }
        
        .table-fixed th:nth-child(9),
        .table-fixed td:nth-child(9) {
            width: 80px !important;
        }

        table td,
        table th {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .object-fit-cover {
            object-fit: cover;
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
    position: absolute !important;
    right: 0;
    background: white;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    z-index: 1065 !important; /* Higher than dropdown-action */
    min-width: 180px;
    padding: 8px 0;
    margin-top: 5px;
    display: none;
    list-style: none;
}

        .dropdown-menu-custom.show {
    display: block !important;
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
    overflow: visible !important; /* Allow dropdown to overflow table container */
}


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

            .table thead th,
            .table tbody tr td {
                padding: 8px 6px !important;
                font-size: 0.8rem;
            }

            .pagination-arrow,
            .pagination-number {
                padding: 4px 6px;
                font-size: 0.75rem;
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
            border-left-color: var(--bs-tooltip-bg);
            border-right-color: var(--bs-tooltip-bg);
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

        .restricted-action {
            position: relative;
        }

        .restricted-action:hover {
            background-color: transparent !important;
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
    background-color: #ffffff !important;
    color: #333333 !important;
    border-bottom: 1px solid #e9ecef !important;
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

        /* Search input styling to match Sekretariat */
        input[type="search"]::-webkit-search-decoration,
        input[type="search"]::-webkit-search-cancel-button,
        input[type="search"]::-webkit-search-results-button,
        input[type="search"]::-webkit-search-results-decoration {
            -webkit-appearance: none;
            appearance: none;
        }

        /* Updated search input container styling */
        .search-clear-btn {
            position: absolute !important;
            right: 55px !important;
            z-index: 10 !important;
            border: none !important;
            background: transparent !important;
            padding: 8px !important;
        }

        .dropdown-action {
            position: relative;
            z-index: 1055;
            /* Lebih tinggi dari modal */
        }

        .dropdown-menu-custom {
            z-index: 1060 !important;
        }

        .card-body {
    overflow: visible !important;
}

.table-container,
#table-container {
    overflow: visible !important;
    position: relative;
    z-index: 1;
}

/* For mobile responsiveness */
@media (max-width: 768px) {
    .table-responsive {
        overflow-x: auto !important;
        overflow-y: visible !important;
    }
    
    .dropdown-action {
        z-index: 1070 !important;
    }
    
    .dropdown-menu-custom {
        z-index: 1075 !important;
        position: fixed !important; /* Use fixed positioning on mobile */
        right: 10px !important;
        min-width: 140px;
    }
}

/* Additional fix for table scrolling */
.table-fixed {
    table-layout: fixed;
    min-width: 1200px;
    position: relative;
    z-index: 1;
}

/* Ensure last column (action column) has proper overflow */
.table-fixed th:nth-child(9),
.table-fixed td:nth-child(9) {
    width: 80px !important;
    overflow: visible !important; /* Allow dropdown to overflow */
}

/* Fix for when table is inside a card */
.card {
    overflow: visible !important;
}

/* Alternative solution: Make dropdown appear to the left if near right edge */
.dropdown-action.near-edge .dropdown-menu-custom {
    right: auto;
    left: 0;
}

.dropdown-menu-custom {
    z-index: 9999 !important;
}

.dropdown-action.near-edge .dropdown-menu-custom {
    right: auto;
    left: 0;
}
    </style>

    <!-- Updated Page Header to match Sekretariat -->
    <div class="d-flex flex-column mb-8">
        <h1 class="text-dark fw-bold mb-1">Kegiatan Lainnya</h1>
        <div class="text-muted fw-semibold fs-6">Manajemen Laporan Kegiatan Lainnya Anda Sekarang</div>
    </div>

    <!-- Updated Main Container to match Sekretariat -->
    <div class="row col-12 mt-5">
        <div class="card">
            {{-- Card Header - Updated to match Sekretariat --}}
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap py-5">
                <h3 class="card-title fw-bold fs-4 mb-0">Daftar Table Kegiatan Lainnya - 2025</h3>

                {{-- Action Buttons - Updated to match Sekretariat --}}
                <div class="d-flex align-items-center gap-2 flex-wrap ms-auto">
                    {{-- Add Button with role-based restrictions --}}
                    @if (auth()->user()->hasRole('superadmin'))
                        <a href="{{ route('admin.laporan-lpj.kegiatan-lainnya.create') }}" class="btn custom-red-button"
                            style="background-color: #F8285A !important; color: white !important; border-color: #F8285A !important;">
                            <i class="ki-duotone ki-plus fs-2" style="color: white !important;"></i>Tambah Laporan
                        </a>

                        <form action="{{ route('admin.laporan-lpj.kegiatan-lainnya.export') }}" method="POST"
                            class="d-inline">
                            @csrf
                            <input type="hidden" name="data" value="{{ json_encode([]) }}">
                            <input type="hidden" name="title" value="LPJ_Kegiatan-Lainnya_{{ date('Ymd') }}">
                            <button type="submit" class="btn custom-red-button"
                                style="background-color: #F8285A !important; color: white !important; border-color: #F8285A !important;">
                                <i class="fas fa-file-export me-1" style="color: white !important;"></i>Export
                            </button>
                        </form>
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

                    {{-- Updated Search Input to match Sekretariat --}}
                    <div class="input-group position-relative" style="width: 250px;">
                        <input type="search" name="search" id="search" class="form-control"
                            placeholder="Cari kegiatan..." value="{{ request('search') }}" autocomplete="off">

                        <button class="btn btn-outline-secondary search-clear-btn d-none" type="button" id="clear-search">
                            <i class="fas fa-times text-muted"></i>
                        </button>

                        <button class="btn btn-outline-secondary" type="button" id="search-button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Card Body - Updated to match Sekretariat --}}
            <div class="card-body position-relative">
                <div class="loading-overlay d-none" id="loading-overlay">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>

                <div id="table-container">
                    @include('admin.laporan-lpj.kegiatan-lainnya._table')
                </div>
            </div>
        </div>
    </div>

    {{-- Updated Preview Modal to match Sekretariat --}}
    <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
<div class="modal-header bg-white border-bottom">
    <h5 class="modal-title text-dark fw-bold" id="previewModalLabel">
        <i class="fas fa-file-image text-primary me-2"></i>Preview Files
    </h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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

    {{-- Updated Detail Modal to match Sekretariat --}}
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background: #F8285A; color: white;">
                    <h5 class="modal-title" id="detailModalLabel" style="color: white">Detail Kegiatan</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="detailModalBody">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="exportPdfBtn">
                        <i class="fas fa-file-pdf me-1"></i>Export PDF
                    </button>
                </div>
            </div>
        </div>
    </div>
    {{-- Delete Confirmation Modal --}}
    <div class="modal fade" id="modal_delete_confirmation" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h2 class="fw-bold text-white">
                        <i class="fas fa-exclamation-triangle me-2"></i>Konfirmasi Hapus
                    </h2>
                    <div class="btn btn-icon btn-sm btn-active-light-primary" data-bs-dismiss="modal">
                        <i class="fa-solid fa-times fs-1 text-white"></i>
                    </div>
                </div>
                <div class="modal-body text-center py-8">
                    <i class="fas fa-trash-alt text-danger fs-3x mb-4"></i>
                    <h4 class="mb-3">Apakah Anda yakin?</h4>
                    <p class="text-muted mb-0">Data yang telah dihapus tidak dapat dikembalikan.</p>
                    <p class="fw-bold text-dark mt-2" id="delete-item-name"></p>
                </div>
                <div class="modal-footer justify-content-center border-0 pb-6">
                    <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Batal
                    </button>
                    <button type="button" class="btn btn-danger" id="confirm-delete-btn">
                        <span class="indicator-label">
                            <i class="fas fa-trash me-1"></i>Ya, Hapus
                        </span>
                        <span class="indicator-progress">
                            <span class="spinner-border spinner-border-sm align-middle me-2"></span>
                            Menghapus...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Toast Notification Container --}}
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 9999;">
        <div id="toast-success" class="toast align-items-center text-bg-success border-0" role="alert"
            aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="fas fa-check-circle me-2"></i>
                    <span id="toast-success-message">Data berhasil dihapus.</span>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
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
            let currentFiles = [];
            let currentFilenames = []; // Tambahkan ini
            let currentIndex = 0;
            let currentType = '';

            // Debounce function for search
            function debounce(func, wait, immediate) {
                var timeout;
                return function executedFunction() {
                    var context = this;
                    var args = arguments;
                    var later = function() {
                        timeout = null;
                        if (!immediate) func.apply(context, args);
                    };
                    var callNow = immediate && !timeout;
                    clearTimeout(timeout);
                    timeout = setTimeout(later, wait);
                    if (callNow) func.apply(context, args);
                };
            }

            // Initialize DataTable
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

            // Initialize Tooltips
            function initializeTooltips() {
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl, {
                        trigger: 'hover focus'
                    });
                });
            }

            // Initialize Dropdown Events
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

            // Loading functions
            function showLoading() {
                $('#loading-overlay').removeClass('d-none');
            }

            function hideLoading() {
                $('#loading-overlay').addClass('d-none');
            }

            function showSearchLoading() {
                if (!isSearching) {
                    isSearching = true;
                    showLoading();
                }
            }

            function hideSearchLoading() {
                isSearching = false;
                hideLoading();
            }

            // Toggle clear button visibility
            function toggleClearButton() {
                const $searchInput = $('#search');
                const $clearBtn = $('#clear-search');

                if ($searchInput.val().length > 0) {
                    $clearBtn.removeClass('d-none');
                } else {
                    $clearBtn.addClass('d-none');
                }
            }

            // Search functions with improved debounce
            const debouncedSearch = debounce(function(searchValue) {
                doSearch(searchValue);
            }, 300);

            function performSearch(searchValue, immediate = false) {
                if (searchTimeout) {
                    clearTimeout(searchTimeout);
                }

                if (immediate || searchValue === '') {
                    doSearch(searchValue);
                } else {
                    debouncedSearch(searchValue);
                }
            }

            function doSearch(searchValue) {
                showSearchLoading();

                updateTable({
                    'search': searchValue,
                    'page': 1
                }).finally(() => {
                    hideSearchLoading();
                });
            }

            // Update table via AJAX
            function updateTable(params = {}) {
                return new Promise((resolve, reject) => {
                    if (params.search === undefined) {
                        showLoading();
                    }

                    const currentUrl = new URL(window.location.href);

                    // Update URL parameters
                    for (const key in params) {
                        if (params[key] !== null && params[key] !== undefined && params[key] !== '') {
                            currentUrl.searchParams.set(key, params[key]);
                        } else {
                            currentUrl.searchParams.delete(key);
                        }
                    }

                    // Hapus parameter filter yang tidak digunakan lagi
                    currentUrl.searchParams.delete('jenis_kegiatan_filter');
                    currentUrl.searchParams.delete('start_date');
                    currentUrl.searchParams.delete('end_date');

                    $.ajax({
                        url: currentUrl.toString(),
                        type: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        success: function(response) {
                            // Update table container with new data
                            $('#table-container').html(response);
                            hideLoading();

                            // Update browser URL
                            window.history.pushState(null, null, currentUrl.toString());

                            // Reinitialize components
                            initializeDataTable();
                            initializeTooltips();
                            initializeDropdownEvents();

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

            // Show notification
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

            // Update filter count badge
            function updateFilterCount() {
                // Fungsi ini sudah tidak digunakan lagi karena tombol filter telah dihapus
            }

            // Get file icon based on extension
            function getFileIcon(extension) {
                const icons = {
                    'pdf': 'fas fa-file-pdf text-danger',
                    'doc': 'fas fa-file-word text-primary',
                    'docx': 'fas fa-file-word text-primary',
                    'xls': 'fas fa-file-excel text-success',
                    'xlsx': 'fas fa-file-excel text-success',
                    'ppt': 'fas fa-file-powerpoint text-warning',
                    'pptx': 'fas fa-file-powerpoint text-warning',
                    'jpg': 'fas fa-file-image text-info',
                    'jpeg': 'fas fa-file-image text-info',
                    'png': 'fas fa-file-image text-info',
                    'gif': 'fas fa-file-image text-info',
                    'webp': 'fas fa-file-image text-info',
                    'svg': 'fas fa-file-image text-info'
                };
                return icons[extension] || 'fas fa-file text-muted';
            }

            // Preview functions
            function loadPreview() {
                if (!currentFiles || currentFiles.length === 0) {
                    console.error('No files to preview');
                    return;
                }

                const previewSlides = document.getElementById('previewSlides');
                if (!previewSlides) return;

                previewSlides.innerHTML = '';

                currentFiles.forEach((file, index) => {
                    const slide = document.createElement('div');
                    slide.className = `preview-slide ${index === currentIndex ? 'active' : ''}`;

                    // Gunakan nama file dari currentFilenames
                    const fileName = currentFilenames && currentFilenames[index] ? 
                        currentFilenames[index] : file.split('/').pop();
                    const fileExtension = fileName.split('.').pop().toLowerCase();
                    const imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'];
                    const docExtensions = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'];

                    if (currentType === 'image' || currentType === 'foto' ||
                        (currentType === 'auto' && imageExtensions.includes(fileExtension))) {
                        slide.innerHTML = `
                            <img src="/storage/${file}"
                                 alt="Preview"
                                 class="preview-image"
                                 onerror="this.style.display='none'; this.parentElement.innerHTML='<div class=\\'document-placeholder\\'><i class=\\'fas fa-exclamation-triangle text-warning\\' style=\\'font-size: 3rem;\\'></i><h5>Gagal memuat gambar</h5></div>'">
                        `;
                    } else if (fileExtension === 'pdf') {
                        slide.innerHTML = `
                            <iframe src="/storage/${file}"
                                    class="preview-document"
                                    onerror="console.error('Failed to load PDF: /storage/${file}')"></iframe>
                        `;
                    } else if (docExtensions.includes(fileExtension)) {
                        // For document files that can't be previewed directly, show download option
                        const iconClass = getFileIcon(fileExtension);
                        slide.innerHTML = `
                            <div class="document-placeholder">
                                <i class="${iconClass}"></i>
                                <h5>${fileName}</h5>
                                <p>Klik download untuk melihat file ${fileExtension.toUpperCase()}</p>
                                <a href="/storage/${file}" class="btn btn-primary" target="_blank">
                                    <i class="fas fa-external-link-alt me-2"></i>Buka File
                                </a>
                            </div>
                        `;
                    } else {
                        // For unknown file types, show generic file icon
                        slide.innerHTML = `
                            <div class="document-placeholder">
                                <i class="fas fa-file text-muted"></i>
                                <h5>${fileName}</h5>
                                <p>Klik download untuk melihat file</p>
                                <a href="/storage/${file}" class="btn btn-primary" target="_blank">
                                    <i class="fas fa-download me-2"></i>Download
                                </a>
                            </div>
                        `;
                    }

                    previewSlides.appendChild(slide);
                });

                updatePreviewUI();
            }

            function updatePreviewUI() {
                if (!currentFiles || currentFiles.length === 0) return;

                // Gunakan nama file dari currentFilenames
                const fileName = currentFilenames && currentFilenames[currentIndex] ? 
                    currentFilenames[currentIndex] : currentFiles[currentIndex].split('/').pop();
                const currentFileName = document.getElementById('currentFileName');
                const fileCounter = document.getElementById('fileCounter');
                const downloadBtn = document.getElementById('downloadBtn');
                const prevBtn = document.getElementById('prevBtn');
                const nextBtn = document.getElementById('nextBtn');

                if (currentFileName) currentFileName.textContent = fileName;
                if (fileCounter) fileCounter.textContent = `${currentIndex + 1} dari ${currentFiles.length}`;

                if (currentFiles.length > 1) {
                    if (prevBtn) prevBtn.style.display = 'block';
                    if (nextBtn) nextBtn.style.display = 'block';
                } else {
                    if (prevBtn) prevBtn.style.display = 'none';
                    if (nextBtn) nextBtn.style.display = 'none';
                }

                if (downloadBtn) {
                    downloadBtn.onclick = function() {
                        window.open('/storage/' + currentFiles[currentIndex], '_blank');
                    };
                }
            }

            window.showDetailModal = function(data) {
                const modalBody = document.getElementById('detailModalBody');

                if (!modalBody) {
                    console.error('Modal body not found');
                    return;
                }

                const formatRupiah = (num) => {
                    if (!num) return 'Rp 0';
                    return 'Rp ' + parseInt(num).toLocaleString('id-ID');
                };

                let fotoJurnalHtml = '<div class="text-muted fst-italic">Tidak ada foto tersedia</div>';
                if (data.foto_jurnal && Array.isArray(data.foto_jurnal) && data.foto_jurnal.length > 0) {
                    fotoJurnalHtml = `
                        <div class="row g-3">
                            ${data.foto_jurnal.map(f => `
                                    <div class="col-6 col-md-4">
                                        <div class="border rounded overflow-hidden" style="height: 120px;">
                                            <img src="/storage/${f}"
                                                 class="w-100 h-100"
                                                 style="object-fit: cover; cursor: pointer;"
                                                 onclick="window.open('/storage/${f}', '_blank')"
                                                 onerror="this.style.display='none'; this.parentElement.innerHTML='<div class=\\'d-flex align-items-center justify-content-center h-100 text-muted\\'>Error loading image</div>'">
                                        </div>
                                    </div>
                                `).join('')}
                        </div>
                    `;
                }

                let dokumenHtml = '<div class="text-muted fst-italic">Tidak ada dokumen tersedia</div>';
                if (data.dokumen_lpj && Array.isArray(data.dokumen_lpj) && data.dokumen_lpj.length > 0) {
                    dokumenHtml = `
                        <div class="d-flex flex-column gap-2">
                            ${data.dokumen_lpj.map(d => {
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
                                        <label class="fw-semibold text-dark mb-1">Nama Program:</label>
                                        <p class="mb-0 text-dark">${data.nama_program || 'N/A'}</p>
                                    </div>
                                    ${data.nama_kegiatan ? `
                                            <div class="mb-2">
                                                <label class="fw-semibold text-dark mb-1">Nama Kegiatan:</label>
                                                <p class="mb-0 text-dark">${data.nama_kegiatan}</p>
                                            </div>
                                        ` : ''}
                                    ${data.volume ? `
                                            <div class="mb-2">
                                                <label class="fw-semibold text-dark mb-1">Volume:</label>
                                                <p class="mb-0 text-dark">${data.volume}</p>
                                            </div>
                                        ` : ''}
                                    ${data.tempat_kegiatan ? `
                                            <div class="mb-2">
                                                <label class="fw-semibold text-dark mb-1">Tempat Kegiatan:</label>
                                                <p class="mb-0 text-dark">${data.tempat_kegiatan}</p>
                                            </div>
                                        ` : ''}
                                    ${data.tanggal_kegiatan ? `
                                            <div>
                                                <label class="fw-semibold text-dark mb-1">Tanggal Kegiatan:</label>
                                                <p class="mb-0 text-dark">${new Date(data.tanggal_kegiatan).toLocaleDateString('id-ID')}</p>
                                            </div>
                                        ` : ''}
                                </div>
                            </div>

                            ${data.jumlah_harga_satuan || data.jumlah_harga ? `
                                    <div class="mb-4">
                                        <h6 class="fw-bold text-success mb-3 d-flex align-items-center">
                                            <i class="fas fa-calculator me-2"></i>
                                            Rincian Anggaran
                                        </h6>
                                        <div class="bg-light p-3 rounded">
                                            <div class="row g-3">
                                                ${data.jumlah_harga_satuan ? `
                                                <div class="col-md-6">
                                                    <label class="fw-semibold text-dark mb-1">Harga Satuan:</label>
                                                    <p class="mb-0 text-success fs-6 fw-bold">${formatRupiah(data.jumlah_harga_satuan)}</p>
                                                </div>
                                            ` : ''}
                                                ${data.jumlah_harga ? `
                                                <div class="col-md-6">
                                                    <label class="fw-semibold text-dark mb-1">Total Harga:</label>
                                                    <p class="mb-0 text-info fs-6 fw-bold">${formatRupiah(data.jumlah_harga)}</p>
                                                </div>
                                            ` : ''}
                                            </div>
                                        </div>
                                    </div>
                                ` : ''}

                            ${data.sumber_dana ? `
                                    <div class="mb-4">
                                        <h6 class="fw-bold text-info mb-3 d-flex align-items-center">
                                            <i class="fas fa-money-bill me-2"></i>
                                            Sumber Dana
                                        </h6>
                                        <div class="bg-light p-3 rounded">
                                            <p class="mb-0 text-dark">${data.sumber_dana}</p>
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
                                        <i class="fas fa-camera me-1"></i>Foto Jurnal:
                                    </label>
                                    <div class="bg-light p-3 rounded">
                                        ${fotoJurnalHtml}
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

                            ${data.keterangan ? `
                                    <div class="mb-2">
                                        <h6 class="fw-bold text-secondary mb-3 d-flex align-items-center">
                                            <i class="fas fa-sticky-note me-2"></i>
                                            Keterangan
                                        </h6>
                                        <div class="bg-light p-3 rounded">
                                            <p class="mb-0 text-dark">${data.keterangan}</p>
                                        </div>
                                    </div>
                                ` : ''}
                        </div>
                    </div>
                `;

                const modal = new bootstrap.Modal(document.getElementById('detailModal'));
                modal.show();

                // Add event listener for export button
                $('#exportPdfBtn').off('click').on('click', function() {
                    exportToPDF(data);
                });
            };

            function showSlide(index) {
                const previewSlides = document.getElementById('previewSlides');
                if (!previewSlides) return;

                document.querySelectorAll('.preview-slide').forEach((slide, i) => {
                    slide.classList.toggle('active', i === index);
                });
                currentIndex = index;
                updatePreviewUI();
            }

            // Global functions for window object
            window.destroyItem = function(button) {
    const route = button.dataset.route;
    
    if (!route) {
        console.error('Route not found in button data');
        return;
    }

    Swal.fire({
        title: "Apakah Anda Yakin?",
        html: "<p style='text-align:center'>Setelah data kegiatan dihapus, Anda tidak bisa mengembalikannya!</p>",
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
                type: 'POST', // Gunakan POST sebagai transport
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    _method: 'DELETE' // Method spoofing untuk Laravel
                },
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function(response) {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: response.message || 'Data kegiatan berhasil dihapus',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    });

                    // Reload halaman untuk menampilkan perubahan
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                },
                error: function(xhr) {
                    Swal.close();
                    
                    let errorMessage = 'Gagal menghapus data kegiatan';
                    
                    try {
                        const response = JSON.parse(xhr.responseText);
                        
                        if (response.reason === 'has_dependencies') {
                            Swal.fire({
                                title: 'Tidak Dapat Menghapus Data',
                                html: `Data kegiatan <strong>${response.item_name}</strong> tidak dapat dihapus karena masih memiliki data terkait.<br><br>
                                    <p class="text-muted">
                                        Silakan hapus atau ubah data yang terkait terlebih dahulu.
                                    </p>`,
                                icon: "warning",
                                confirmButtonText: 'Mengerti'
                            });
                            return;
                        } else if (response.message) {
                            errorMessage = response.message;
                        }
                    } catch (e) {
                        console.error('Error parsing response:', e);
                        
                        // Handle specific HTTP errors
                        if (xhr.status === 405) {
                            errorMessage = 'Method tidak didukung. Periksa konfigurasi route.';
                        } else if (xhr.status === 404) {
                            errorMessage = 'Data tidak ditemukan.';
                        } else if (xhr.status === 403) {
                            errorMessage = 'Akses ditolak.';
                        }
                    }
                    
                    Swal.fire({
                        title: 'Error!',
                        text: errorMessage,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        } else {
            Swal.fire({
                title: "Aksi Dibatalkan",
                icon: "info",
                timer: 1500,
                showConfirmButton: false
            });
        }
    });
};

            // Export to PDF function
            window.exportToPDF = function(data) {
                // Show loading
                Swal.fire({
                    title: 'Menyiapkan PDF...',
                    text: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    willOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Create form dynamically
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route('admin.laporan-lpj.kegiatan-lainnya.export') }}';
                form.target = '_blank';

                // Add CSRF token
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                form.appendChild(csrfToken);

                // Add data
                const dataInput = document.createElement('input');
                dataInput.type = 'hidden';
                dataInput.name = 'data';
                dataInput.value = JSON.stringify(data);
                form.appendChild(dataInput);

                // Add title
                const titleInput = document.createElement('input');
                titleInput.type = 'hidden';
                titleInput.name = 'title';
                titleInput.value = `LPJ_${data.nama_program}_${new Date().toISOString().split('T')[0]}`;
                form.appendChild(titleInput);

                document.body.appendChild(form);
                form.submit();
                document.body.removeChild(form);

                // Close loading
                Swal.close();
            };

            window.showPreviewModal = function(files, type, title, filenames) {
                if (!files || !Array.isArray(files) || files.length === 0) {
                    console.error('Invalid files data for preview');
                    return;
                }

                currentFiles = files;
                // Jika filenames tidak disediakan, ekstrak dari path file
                currentFilenames = filenames && Array.isArray(filenames) ? filenames : files.map(f => f.split('/').pop());
                currentType = type || 'auto';
                currentIndex = 0;

                const modalTitle = document.getElementById('previewModalLabel');
                if (modalTitle) {
                    modalTitle.textContent = title || 'Preview Files';
                }

                loadPreview();
                $('#previewModal').modal('show');
            };

            // Initialize everything
            initializeDataTable();
            initializeTooltips();
            initializeDropdownEvents();
            toggleClearButton();

            // Event Listeners
            // Search functionality
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

            // Per page select change
            $('#per-page-select').on('change', function() {
                const perPage = $(this).val();
                updateTable({
                    'per_page': perPage,
                    'page': 1
                });
            });

            // Preview modal navigation
            $('#prevBtn').on('click', function() {
                if (currentIndex > 0) {
                    showSlide(currentIndex - 1);
                }
            });

            $('#nextBtn').on('click', function() {
                if (currentIndex < currentFiles.length - 1) {
                    showSlide(currentIndex + 1);
                }
            });

            // Handle preview button clicks
            $(document).on('click', '.preview-btn', function(e) {
                e.preventDefault();
                e.stopPropagation();
                const btn = $(this);

                try {
                    const filesData = btn.attr('data-files');
                    const type = btn.attr('data-type') || 'auto';
                    const title = btn.attr('data-title') || 'Preview Files';
                    const filenamesData = btn.attr('data-filenames'); // Tambahkan ini

                    if (filesData) {
                        const files = JSON.parse(filesData);
                        // Filter out null/empty files
                        const validFiles = files.filter(f => f && f.length > 0);
                        if (validFiles.length > 0) {
                            // Parse filenames jika tersedia
                            let filenames = null;
                            if (filenamesData) {
                                try {
                                    filenames = JSON.parse(filenamesData);
                                } catch (e) {
                                    console.warn('Error parsing filenames data:', e);
                                }
                            }
                            showPreviewModal(validFiles, type, title, filenames);
                        } else {
                            showNotification('Tidak ada file untuk ditampilkan', 'warning');
                        }
                    } else {
                        console.error('No files data found');
                        showNotification('Data file tidak ditemukan', 'error');
                    }
                } catch (error) {
                    console.error('Error parsing preview data:', error);
                    showNotification('Gagal memuat preview file', 'error');
                }
            });

            // Handle Ajukan Perubahan button click
            $(document).on('click', '.ajukan-perubahan-btn', function() {
                const kegiatanId = $(this).data('kegiatan-id');
                const kegiatanName = $(this).data('kegiatan-name');
                
                Swal.fire({
                    title: 'Ajukan Perubahan',
                    html: `
                        <p>Apakah Anda yakin ingin mengajukan perubahan untuk kegiatan:</p>
                        <h5><strong>${kegiatanName}</strong></h5>
                        <p class="mt-3">Setelah diajukan, admin/superadmin akan meninjau permintaan Anda.</p>
                    `,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Ajukan',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/admin/laporan-lpj/kegiatan-lainnya/${kegiatanId}/approve`,
                            method: 'POST',
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content'),
                                catatan_approval: 'Pengajuan perubahan dari user'
                            },
                            success: function(response) {
                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: response.message || 'Pengajuan perubahan berhasil dikirim.',
                                    icon: 'success',
                                    timer: 2000,
                                    showConfirmButton: false
                                }).then(() => {
                                    // Reload halaman untuk menampilkan perubahan
                                    window.location.reload();
                                });
                            },
                            error: function(xhr) {
                                let errorMessage = 'Gagal mengirim pengajuan perubahan.';
                                if (xhr.responseJSON && xhr.responseJSON.message) {
                                    errorMessage = xhr.responseJSON.message;
                                }
                                
                                Swal.fire({
                                    title: 'Error!',
                                    text: errorMessage,
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        });
                    }
                });
            });

            // Keyboard navigation for preview modal
            $(document).on('keydown', function(e) {
                // Check if preview modal is open
                if ($('#previewModal').hasClass('show')) {
                    switch (e.key) {
                        case 'ArrowLeft':
                            if (prevBtn && currentIndex > 0) {
                                showSlide(currentIndex - 1);
                            }
                            break;
                        case 'ArrowRight':
                            if (nextBtn && currentIndex < currentFiles.length - 1) {
                                showSlide(currentIndex + 1);
                            }
                            break;
                        case 'Escape':
                            $('#previewModal').modal('hide');
                            break;
                    }
                }
            });

            // Close preview modal reset
            $('#previewModal').on('hidden.bs.modal', function() {
                currentFiles = [];
                currentFilenames = []; // Tambahkan ini
                currentIndex = 0;
                currentType = '';
            });
        });
    </script>
@endsection
