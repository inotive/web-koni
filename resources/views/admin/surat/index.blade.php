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

        /* Tab Navigation Styling */
        .nav-tabs-custom {
            border-bottom: 2px solid #e9ecef;
            margin-bottom: 0;
        }

        .nav-tabs-custom .nav-link {
            border: none;
            border-bottom: 3px solid transparent;
            padding: 12px 24px;
            font-weight: 600;
            color: #6c757d;
            background: none;
            border-radius: 0;
            transition: all 0.3s ease;
        }

        .nav-tabs-custom .nav-link:hover {
            border-bottom-color: #F8285A;
            color: #F8285A;
            background: none;
        }

        .nav-tabs-custom .nav-link.active {
            color: #F8285A;
            border-bottom-color: #F8285A;
            background: none;
        }

        .tab-content-custom {
            border-top: none;
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

            .nav-tabs-custom .nav-link {
                padding: 8px 16px;
                font-size: 14px;
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

    {{-- Main Content Card --}}
    <div class="row col-12 mt-5">
        <div class="card">
            {{-- Tab Navigation --}}
            <div class="card-header border-bottom-0 pb-0">
                <ul class="nav nav-tabs nav-tabs-custom" id="suratTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="semua-tab" data-bs-toggle="tab" data-bs-target="#semua-content"
                                type="button" role="tab" aria-controls="semua-content" aria-selected="true">
                            <i class="fas fa-list me-2"></i>Semua Surat
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="masuk-tab" data-bs-toggle="tab" data-bs-target="#masuk-content"
                                type="button" role="tab" aria-controls="masuk-content" aria-selected="false">
                            <i class="fas fa-inbox me-2"></i>Surat Masuk
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="keluar-tab" data-bs-toggle="tab" data-bs-target="#keluar-content"
                                type="button" role="tab" aria-controls="keluar-content" aria-selected="false">
                            <i class="fas fa-paper-plane me-2"></i>Surat Keluar
                        </button>
                    </li>
                </ul>
            </div>

            {{-- Card Header with Title and Actions --}}
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap py-5 border-top-0">
                <h3 class="card-title fw-bold fs-4 mb-0">Daftar Surat Masuk & Keluar - 2025</h3>

                {{-- Action Buttons --}}
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
                                <label class="form-label fw-semibold">Jenis Surat</label>
                                <select id="filter-jenis-surat" class="form-select">
                                    <option value="">Semua Jenis</option>
                                    <option value="masuk" {{ request('jenis_surat') == 'masuk' ? 'selected' : '' }}>
                                        Surat Masuk
                                    </option>
                                    <option value="keluar" {{ request('jenis_surat') == 'keluar' ? 'selected' : '' }}>
                                        Surat Keluar
                                    </option>
                                </select>
                            </div>

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

            {{-- Tab Content --}}
            <div class="card-body">
                <div class="tab-content tab-content-custom" id="suratTabContent">
                    {{-- Semua Surat Tab --}}
                    <div class="tab-pane fade show active" id="semua-content" role="tabpanel" aria-labelledby="semua-tab">
                        @include('admin.surat._table', ['suratData' => $suratMasukKeluar, 'tableId' => 'semua'])
                    </div>

                    {{-- Surat Masuk Tab --}}
                    <div class="tab-pane fade" id="masuk-content" role="tabpanel" aria-labelledby="masuk-tab">
                        @php
                            $suratMasuk = $suratMasukKeluar->filter(function($item) {
                                return $item->jenis_surat === 'masuk';
                            });
                        @endphp
                        @include('admin.surat._table', ['suratData' => $suratMasuk, 'tableId' => 'masuk'])
                    </div>

                    {{-- Surat Keluar Tab --}}
                    <div class="tab-pane fade" id="keluar-content" role="tabpanel" aria-labelledby="keluar-tab">
                        @php
                            $suratKeluar = $suratMasukKeluar->filter(function($item) {
                                return $item->jenis_surat === 'keluar';
                            });
                        @endphp
                        @include('admin.surat._table', ['suratData' => $suratKeluar, 'tableId' => 'keluar'])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @if ($suratMasukKeluar->isNotEmpty())
        <script>
            $(document).ready(function() {
                // Initialize DataTables for each tab
                function initializeDataTable(tableId) {
                    const table = $(`#kt_datatable_dom_positioning_surat_${tableId}`).DataTable({
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

                // Initialize all tables
                initializeDataTable('semua');
                initializeDataTable('masuk');
                initializeDataTable('keluar');

                // Tab change handler
                $('#suratTabs button[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
                    const targetId = $(e.target).attr('data-bs-target');
                    const tableId = targetId.replace('#', '').replace('-content', '');

                    // Trigger table redraw to fix layout issues
                    setTimeout(() => {
                        $(`#kt_datatable_dom_positioning_surat_${tableId}`).DataTable().columns.adjust();
                    }, 100);
                });

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

                $('#per-page-select').on('change', function() {
                    updateUrlAndRedirect({
                        'per_page': $(this).val()
                    });
                });

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

                $('#apply-filters').on('click', function() {
                    const jenisSurat = $('#filter-jenis-surat').val();
                    const startDate = $('#filter-start-date').val();
                    const endDate = $('#filter-end-date').val();

                    updateUrlAndRedirect({
                        'jenis_surat': jenisSurat,
                        'start_date': startDate,
                        'end_date': endDate
                    });
                });

                $('#reset-filters').on('click', function() {
                    window.location.href = "{{ route('admin.surat.index') }}";
                });

                function updateFilterCount() {
                    const urlParams = new URLSearchParams(window.location.search);
                    let count = 0;

                    if (urlParams.get('jenis_surat')) count++;
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

                // Handle active tab based on URL parameters
                const urlParams = new URLSearchParams(window.location.search);
                const jenisSurat = urlParams.get('jenis_surat');

                if (jenisSurat === 'masuk') {
                    $('#masuk-tab').tab('show');
                } else if (jenisSurat === 'keluar') {
                    $('#keluar-tab').tab('show');
                }
            });
        </script>
    @endif
@endsection
