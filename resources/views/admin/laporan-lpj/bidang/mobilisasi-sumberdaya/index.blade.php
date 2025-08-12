@extends('layouts.app')

@section('pageTitle', 'Manajemen Mobilisasi Sumber Daya')
@section('mainSection', 'Laporan LPJ')
@section('subSection', 'Bidang-Bidang')
@section('subSectionUrl', route('admin.laporan-lpj.bidang.index'))
@section('currentSection', 'Mobilisasi Sumber Daya')

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
            width: 20px;
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
            width: 100px;
        }

        .table th:nth-child(8) {
            width: 120px;
        }

        .text-truncate-custom {
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        
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
    </style>

    <div class="d-flex flex-column mb-8">
        <h1 class="text-dark fw-bold mb-1">Laporan Mobilisasi Sumber Daya</h1>
        <div class="text-muted fw-semibold fs-6">Manajemen Laporan Mobilisasi Sumber Daya Anda Sekarang</div>
    </div>

    {{-- Main Content Card --}}
    <div class="row col-12 mt-5">
        <div class="card">
            {{-- Card Header --}}
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap py-5">
                <h3 class="card-title fw-bold fs-4 mb-0">Daftar Mobilisasi Sumber Daya - 2025</h3>

                {{-- Action Buttons --}}
                <div class="d-flex align-items-center gap-2 flex-wrap ms-auto">
                    {{-- Add Button --}}
                    <a href="{{ route('admin.laporan-lpj.bidang.mobilisasi-sumberdaya.create') }}" class="btn custom-red-button"
                        style="background-color: #F8285A !important; color: white !important; border-color: #F8285A !important;">
                        <i class="ki-duotone ki-plus fs-2" style="color: white !important;"></i>Tambah Laporan
                    </a>

                    {{-- Search Input --}}
                    <div class="input-group" style="width: 250px;">
                        <input type="search" name="search" id="search" class="form-control"
                            placeholder="Cari program/kegiatan..." value="{{ request('search') }}">
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
                                <label class="form-label fw-semibold">Nama Kegiatan</label>
                                <select id="filter-jenis-kegiatan" class="form-select">
                                    <option value="">Semua Kegiatan</option>
                                    @foreach ($sumberDayaData->pluck('nama_kegiatan')->unique()->filter() as $kegiatan)
                                        <option value="{{ $kegiatan }}"
                                            {{ request('jenis_kegiatan_filter') == $kegiatan ? 'selected' : '' }}>
                                            {{ $kegiatan }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Tanggal Mulai</label>
                                <input type="date" id="filter-start-date" class="form-control" value="{{ request('start_date') }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Tanggal Akhir</label>
                                <input type="date" id="filter-end-date" class="form-control" value="{{ request('end_date') }}">
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
                    @include('admin.laporan-lpj.bidang.mobilisasi-sumberdaya._table')
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            // Initialize DataTable functionality but disable default features
            const table = $("#kt_datatable_dom_positioning_sumberdaya");

            if (table.length > 0) {
                table.DataTable({
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
                    }
                });
            }

            // Dropdown positioning fix
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

            // AJAX functions
            function showLoading() {
                $('#loading-overlay').removeClass('d-none');
            }

            function hideLoading() {
                $('#loading-overlay').addClass('d-none');
            }

            function updateTable(params = {}) {
                showLoading();

                // Get current URL parameters
                const currentUrl = new URL(window.location.href);

                // Merge with new parameters
                for (const key in params) {
                    if (params[key]) {
                        currentUrl.searchParams.set(key, params[key]);
                    } else {
                        currentUrl.searchParams.delete(key);
                    }
                }

                // Always reset to page 1 when filtering/searching
                if (!params.page) {
                    currentUrl.searchParams.set('page', 1);
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

                        // Update URL without page reload
                        window.history.pushState(null, null, currentUrl.toString());

                        // Reinitialize DataTable for new content
                        const newTable = $("#kt_datatable_dom_positioning_sumberdaya");
                        if (newTable.length > 0) {
                            newTable.DataTable({
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
                                }
                            });
                        }

                        updateFilterCount();
                    },
                    error: function() {
                        hideLoading();
                        alert('Terjadi kesalahan saat memuat data');
                    }
                });
            }

            // Search functionality
            $('#search-button').on('click', function() {
                updateTable({
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

                updateTable({
                    'search': '',
                    'jenis_kegiatan_filter': '',
                    'start_date': '',
                    'end_date': ''
                });
            });

            // Per page functionality - delegated event
            $(document).on('change', '#per-page-select', function() {
                updateTable({
                    'per_page': $(this).val()
                });
            });

            // Pagination functionality - delegated event
            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();
                const url = new URL($(this).attr('href'));
                const page = url.searchParams.get('page');

                updateTable({
                    'page': page
                });
            });

            // Sort functionality - delegated event
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
        });
    </script>
@endsection
