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
    </style>

    <div class="d-flex flex-column mb-8">
        <h1 class="text-dark fw-bold mb-1">Surat Masuk & Keluar</h1>
        <div class="text-muted fw-semibold fs-6">Manajemen Surat Masuk & Keluar Anda Sekarang</div>
    </div>

    {{-- Main Content Card --}}
    <div class="row col-12 mt-5">
        <div class="card">
            {{-- Card Header --}}
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap py-5">
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

            {{-- Card Body --}}
            <div class="card-body">
                @if ($surat->isEmpty())
                    {{-- Empty State --}}
                    <div class="text-center text-muted py-10">
                        <i class="ki-duotone ki-information-5 fs-3x mb-3"></i>
                        <h4>Tidak ada data surat masuk & keluar.</h4>
                    </div>
                @else
                    {{-- Data Table --}}
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle"
                            id="kt_datatable_dom_positioning_surat">
                            {{-- Table Header --}}
                            <thead class="bg-light">
                                <tr>
                                    <th>No</th>
                                    <th>
                                        <a href="{{ sortUrl('nama_kegiatan') }}"
                                            class="text-dark text-decoration-none">
                                            Nama Kegiatan {!! sortIcon('nama_kegiatan') !!}
                                        </a>
                                    </th>
                                    <th>Dokumen</th>
                                    <th>
                                        <a href="{{ sortUrl('created_at') }}" class="text-dark text-decoration-none">
                                            Tanggal Dibuat {!! sortIcon('created_at') !!}
                                        </a>
                                    </th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($suratMasukKeluar as $index => $surat)
                                    <tr data-jenis-surat="{{ $surat->jenis_surat ?? '' }}">
                                        <td class="text-center">
                                            {{ ($suratMasukKeluar->currentPage() - 1) * $suratMasukKeluar->perPage() + $index + 1 }}
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <strong class="text-truncate-custom">{{ $surat->nama_kegiatan }}</strong>
                                                @if ($surat->jenis_surat)
                                                    <small class="text-muted">
                                                        <span class="badge badge-{{ $surat->jenis_surat == 'masuk' ? 'success' : 'primary' }} badge-sm">
                                                            {{ $surat->jenis_surat == 'masuk' ? 'Surat Masuk' : 'Surat Keluar' }}
                                                        </span>
                                                    </small>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            @if ($surat->dokumen_surat)
                                                <a href="{{ asset('storage/' . $surat->dokumen_surat) }}" target="_blank"
                                                    class="btn btn-sm btn-light-primary">
                                                    <i class="fas fa-file-pdf me-1"></i>Lihat Dokumen
                                                </a>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($surat->created_at)->format('d M Y H:i') }}
                                        </td>
                                        <td class="text-center">
                                            <div class="dropdown">
                                                <button class="btn btn-sm" type="button" data-bs-toggle="dropdown"
                                                    data-bs-boundary="window" aria-expanded="false"
                                                    style="padding: 7px; border: 1px solid #DBDFE9; border-radius: 6px;">
                                                    <svg fill="none" stroke-width="1.5" stroke="currentColor"
                                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg "
                                                        width="24" height="24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M12 6.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 12.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 18.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5Z" />
                                                    </svg>
                                                </button>

                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a href="{{ route('admin.surat.show', $surat->id) }}"
                                                            class="dropdown-item d-flex align-items-center gap-2">
                                                            <i class="fas fa-eye"></i> Lihat Detail
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a href="{{ route('admin.surat.edit', $surat->id) }}"
                                                            class="dropdown-item d-flex align-items-center gap-2">
                                                            <i class="fas fa-edit"></i> Modifikasi
                                                        </a>
                                                    </li>

                                                    @if ($surat->dokumen_surat)
                                                        <li>
                                                            <a href="{{ asset('storage/' . $surat->dokumen_surat) }}"
                                                               target="_blank"
                                                               class="dropdown-item d-flex align-items-center gap-2">
                                                                <i class="fas fa-download"></i> Download
                                                            </a>
                                                        </li>
                                                    @endif

                                                    <li><hr class="dropdown-divider"></li>

                                                    <li>
                                                        <form
                                                            action="{{ route('admin.surat.destroy', $surat->id) }}"
                                                            method="POST" class="d-inline"
                                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus surat ini?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="dropdown-item d-flex align-items-center gap-2 text-danger">
                                                                <i class="fas fa-trash"></i> Hapus
                                                            </button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5 text-muted">Data tidak ditemukan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination Controls --}}
                    <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap">
                        {{-- Per Page Selector --}}
                        <div class="mb-2 mb-md-0">
                            <div class="d-flex align-items-center">
                                <span class="me-2">Show</span>
                                <select class="form-select form-select-sm w-auto" id="per-page-select">
                                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                                </select>
                                <span class="ms-2">per page</span>
                            </div>
                        </div>

                        {{-- Pagination Links --}}
                        <div class="d-flex align-items-center gap-3">
                            <div class="d-flex align-items-center">
                                <span class="me-2">Page {{ $suratMasukKeluar->currentPage() }} of
                                    {{ $suratMasukKeluar->lastPage() }}</span>
                            </div>
                            <div class="pagination-wrapper">
                                {{ $suratMasukKeluar->appends(request()->query())->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('script')
    @if ($suratMasukKeluar->isNotEmpty())
        <script>
            $(document).ready(function() {
                const table = $("#kt_datatable_dom_positioning_surat").DataTable({
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
            });
        </script>
    @endif
@endsection
