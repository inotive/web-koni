@extends('layouts.app')

@section('pageTitle', 'Manajemen Sekretariat')
@section('mainSection', 'Laporan Pertanggungjawaban')
@section('currentSection', 'Surat Masuk & Keluar')

@section('breadcrumb-title')
@endsection

@section('breadcrumb-items')
@endsection

@section('content')
    <style>
        body {
            background-color: #f5f5f5;
        }

        /* Gaya Tab Navigation - sama seperti di halaman cabor */
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
            background-color: #F8285A !important;
            color: white !important;
            box-shadow: 0 4px 8px rgba(248, 40, 90, 0.2);
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
            width: 50px;
        }

        .table th:nth-child(2) {
            width: 300px;
        }

        .table th:nth-child(3) {
            width: 150px;
        }

        .table th:nth-child(4) {
            width: 150px;
        }

        .table th:nth-child(5) {
            width: 120px;
        }

        .text-truncate-custom {
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* SOLUSI UTAMA UNTUK DROPDOWN */
        .card {
            overflow: visible !important;
        }

        .card-body {
            overflow: visible !important;
        }

        .table-responsive {
            overflow: visible !important;
        }

        .dropdown-menu {
            z-index: 1055 !important;
            position: absolute !important;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
            border: 1px solid rgba(0, 0, 0, 0.15) !important;
        }

        .dropdown {
            position: relative;
            z-index: 1000;
        }

        /* Untuk baris terakhir, gunakan dropup */
        .table tbody tr:nth-last-child(-n+2) .dropdown-menu {
            top: auto !important;
            bottom: 100% !important;
            transform: translateY(-8px);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .card-body {
                overflow-x: auto !important;
                overflow-y: visible !important;
            }

            .table-responsive {
                overflow-x: auto !important;
                overflow-y: visible !important;
            }

            .dropdown-menu {
                position: absolute !important;
                z-index: 9999 !important;
                right: 0 !important;
                left: auto !important;
            }

            .nav-tabs .nav-link {
                padding: 0.5rem 1rem !important;
                font-size: 0.875rem;
            }

            .nav-tabs .nav-link i {
                font-size: 1rem;
                margin-right: 6px;
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
    </style>

    <div class="d-flex flex-column mb-8">
        <h1 class="text-dark fw-bold mb-1">Surat Masuk & Keluar</h1>
        <div class="text-muted fw-semibold fs-6">Manajemen Surat Masuk & Keluar Anda Sekarang</div>
    </div>

    <div class="row col-12 mt-5">
        <div class="card">
            <div class="card-header border-0">
                <div class="card-title w-100">
                    <div class="nav nav-tabs nav-line-tabs nav-stretch fs-6 border-0 overflow-auto flex-nowrap mb-3">
                        <div class="nav-item flex-shrink-0">
                            <a class="nav-link fw-bold active" data-bs-toggle="tab" href="#kt_tab_pane_masuk">
                                <i class="ki-duotone ki-entrance-right fs-2 me-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                <span class="d-none d-sm-inline">Surat </span>Masuk
                                <span class="badge badge-light-success ms-2">{{ $suratMasuk->total() ?? 0 }}</span>
                            </a>
                        </div>
                        <div class="nav-item flex-shrink-0">
                            <a class="nav-link fw-bold" data-bs-toggle="tab" href="#kt_tab_pane_keluar">
                                <i class="ki-duotone ki-entrance-left fs-2 me-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                <span class="d-none d-sm-inline">Surat </span>Keluar
                                <span class="badge badge-light-info ms-2">{{ $suratKeluar->total() ?? 0 }}</span>
                            </a>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <h3 class="fw-bold fs-4 mb-0">Daftar Surat Masuk & Keluar - 2025</h3>

                        <div class="d-flex align-items-center gap-2 flex-wrap ms-auto">
                            {{-- Add Button --}}
                            <a href="{{ route('admin.surat.create') }}" class="btn custom-red-button"
                                style="background-color: #F8285A !important; color: white !important; border-color: #F8285A !important;">
                                <i class="ki-duotone ki-plus fs-2" style="color: white !important;"></i>Tambah Surat
                            </a>

                            {{-- Search Input --}}
                            <div class="input-group" style="width: 250px;">
                                <input type="search" name="search" id="search" class="form-control"
                                    placeholder="Cari surat..." value="{{ request('search') }}">
                                <button class="btn btn-outline-secondary" type="button" id="search-button">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>

                            {{-- Filter Dropdown --}}
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-filter me-1"></i> Filter
                                    <span id="filter-count" class="badge badge-circle badge-danger ms-1 d-none">0</span>
                                </button>
                                <div class="dropdown-menu p-3 shadow" style="min-width: 320px;">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Rentang Tanggal</label>
                                        <div class="row">
                                            <div class="col-6">
                                                <input type="date" id="filter-start-date" class="form-control form-control-sm"
                                                    value="{{ request('start_date') }}" placeholder="Dari">
                                            </div>
                                            <div class="col-6">
                                                <input type="date" id="filter-end-date" class="form-control form-control-sm"
                                                    value="{{ request('end_date') }}" placeholder="Sampai">
                                            </div>
                                        </div>
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
                </div>
            </div>

            {{-- Card Body dengan Tab Content --}}
            <div class="card-body p-0">
                <div class="tab-content">
                    {{-- Tab Surat Masuk --}}
                    <div class="tab-pane fade show active" id="kt_tab_pane_masuk" role="tabpanel">
                        @include('admin.surat._table', ['suratData' => $suratMasuk, 'tableId' => 'masuk'])
                    </div>

                    {{-- Tab Surat Keluar --}}
                    <div class="tab-pane fade" id="kt_tab_pane_keluar" role="tabpanel">
                        @include('admin.surat._table', ['suratData' => $suratKeluar, 'tableId' => 'keluar'])
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

            // Initialize DataTables for each tab
            initializeDataTable('masuk');
            initializeDataTable('keluar');

            function initializeDataTable(type) {
                const tableId = `#kt_datatable_dom_positioning_surat_${type}`;

                if ($(tableId).length) {
                    const table = $(tableId).DataTable({
                        paging: false,
                        info: false,
                        searching: false,
                        ordering: true,
                        responsive: false,
                        autoWidth: false,
                        scrollX: false,
                        columnDefs: [{
                                targets: -1,
                                orderable: false,
                                searchable: false,
                                width: "120px"
                            },
                            {
                                targets: 0,
                                orderable: false,
                                searchable: false,
                                width: "50px"
                            },
                            {
                                targets: [2],
                                orderable: false,
                                searchable: false
                            }
                        ],
                        columns: [
                            null, // No
                            null, // Nama Kegiatan
                            null, // Dokumen
                            null, // Tanggal Dibuat
                            null  // Aksi
                        ],
                        language: {
                            emptyTable: "Data tidak ditemukan",
                            zeroRecords: "Tidak ada data yang cocok dengan pencarian"
                        }
                    });
                }
            }

            // Dropdown positioning logic
            $('.dropdown').on('show.bs.dropdown', function() {
                const $dropdown = $(this);
                const $menu = $dropdown.find('.dropdown-menu');
                const $button = $dropdown.find('.dropdown-toggle');

                const buttonRect = $button[0].getBoundingClientRect();
                const viewportHeight = window.innerHeight;
                const spaceBelow = viewportHeight - buttonRect.bottom;

                if (spaceBelow < 200) {
                    $menu.css({
                        'top': 'auto',
                        'bottom': '100%',
                        'transform': 'translateY(-8px)'
                    });
                }
            });

            $('.table-responsive').on('scroll', function() {
                $('.dropdown.show').dropdown('hide');
            });

            // URL update function
            function updateUrlAndRedirect(params) {
                const currentUrl = new URL(window.location.href);
                for (const key in params) {
                    if (params[key]) {
                        currentUrl.searchParams.set(key, params[key]);
                    } else {
                        currentUrl.searchParams.delete(key);
                    }
                }
                currentUrl.searchParams.set('page', 1);
                window.location.href = currentUrl.toString();
            }

            // Per page selector
            $(document).on('change', '.per-page-select', function() {
                updateUrlAndRedirect({
                    'per_page': $(this).val()
                });
            });

            // Search functionality
            $('#search-button').on('click', function() {
                updateUrlAndRedirect({
                    'search': $('#search').val()
                });
            });

            $('#search').on('keypress', function(e) {
                if (e.which === 13) {
                    $('#search-button').click();
                }
            });

            // Filter functionality
            $('#apply-filters').on('click', function() {
                const startDate = $('#filter-start-date').val();
                const endDate = $('#filter-end-date').val();

                updateUrlAndRedirect({
                    'start_date': startDate,
                    'end_date': endDate
                });
            });

            $('#reset-filters').on('click', function() {
                window.location.href = "{{ route('admin.surat.index') }}";
            });

            // Update filter count
            function updateFilterCount() {
                const urlParams = new URLSearchParams(window.location.search);
                let count = 0;

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
        });
    </script>
@endsection
