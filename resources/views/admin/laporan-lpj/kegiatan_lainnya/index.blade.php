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
        /* Table Styling */
        table td,
        table th {
            vertical-align: middle;
            word-wrap: break-word;
        }

        .object-fit-cover {
            object-fit: cover;
        }

        /* Fixed Column Width Settings dengan perbaikan */
        /* PERBAIKAN: Kolom No - diperbesar agar tidak terpotong */
        .table th:nth-child(1),
        .table td:nth-child(1) {
            width: 70px !important;
            max-width: 70px !important;
            text-align: center !important;
        }

        /* PERBAIKAN: Kolom Nama Program & Kegiatan - header tetap rata */
        .table th:nth-child(2) {
            width: 250px !important;
            max-width: 250px !important;
            white-space: nowrap !important;
            /* Header tetap dalam satu baris */
            overflow: hidden !important;
            text-overflow: ellipsis !important;
        }

        /* Konten dalam td bisa wrap */
        .table td:nth-child(2) {
            white-space: normal !important;
            /* Allow text wrapping untuk konten */
            overflow: visible !important;
            max-width: 250px !important;
            width: 250px !important;
        }

        /* Volume */
        .table th:nth-child(3),
        .table td:nth-child(3) {
            width: 100px !important;
            max-width: 100px !important;
        }

        /* Jumlah Harga Satuan */
        .table th:nth-child(4),
        .table td:nth-child(4) {
            width: 150px !important;
            max-width: 150px !important;
        }

        /* Jumlah Harga */
        .table th:nth-child(5),
        .table td:nth-child(5) {
            width: 150px !important;
            max-width: 150px !important;
        }

        /* Foto Jurnal */
        .table th:nth-child(6),
        .table td:nth-child(6) {
            width: 100px !important;
            max-width: 100px !important;
        }

        /* Dokumen */
        .table th:nth-child(7),
        .table td:nth-child(7) {
            width: 100px !important;
            max-width: 100px !important;
        }

        /* Tanggal Ditambahkan */
        .table th:nth-child(8),
        .table td:nth-child(8) {
            width: 120px !important;
            max-width: 120px !important;
        }

        /* Aksi */
        .table th:nth-child(9),
        .table td:nth-child(9) {
            width: 100px !important;
            max-width: 100px !important;
        }

        /* Text truncation untuk semua header kecuali kolom aksi */
        .table th:not(:last-child):not(:nth-child(2)) {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Text truncation untuk semua cell kecuali action column dan kolom nama program */
        .table td:not(:last-child):not(:nth-child(2)) {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .card-body {
                overflow-x: hidden !important;
            }

            .table-responsive {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }
        }

        /* Custom Pagination Styling */
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

        .highlight {
            background-color: #FFD700;
            padding: 0 2px;
            border-radius: 3px;
        }

        /* TAMBAHAN: Pastikan semua header rata */
        .table thead th {
            vertical-align: middle !important;
            text-align: center !important;
        }

        /* Toast Styling */
.toast {
    min-width: 300px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.toast-body {
    font-weight: 500;
}

/* Loading indicator untuk button */
[data-kt-indicator="on"] .indicator-label {
    display: none;
}

[data-kt-indicator="on"] .indicator-progress {
    display: inline-block;
}

.indicator-progress {
    display: none;
}

/* Modal styling */
#modal_delete_confirmation .modal-content {
    border: none;
    box-shadow: 0 10px 40px rgba(0,0,0,0.2);
}

#modal_delete_confirmation .modal-header.bg-danger {
    border-bottom: 1px solid rgba(255,255,255,0.2);
}

/* Animation for row removal */
@keyframes fadeOut {
    from { opacity: 1; }
    to { opacity: 0; }
}

.fade-out {
    animation: fadeOut 0.5s ease-in-out;
}

body {
    background-color: #f8f9fa !important;
}

/* Background abu-abu untuk container utama */
.container-fluid,
.container-xxl {
    background-color: #f8f9fa !important;
}

/* Background putih untuk card utama agar terlihat kontras */
.card {
    background-color: #ffffff !important;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1) !important;
    border: none !important;
}

/* Background abu-abu muda untuk header table */
.table thead {
    background-color: #e9ecef !important;
}

/* Background abu-abu sangat muda untuk row genap (striped effect) */
.table tbody tr:nth-child(even) {
    background-color: #f8f9fa !important;
}

/* Background putih untuk row ganjil */
.table tbody tr:nth-child(odd) {
    background-color: #ffffff !important;
}

/* Hover effect untuk row */
.table tbody tr:hover {
    background-color: #e3f2fd !important;
}

/* Background abu-abu untuk dropdown menu */
.dropdown-menu {
    background-color: #ffffff !important;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15) !important;
}

/* Background abu-abu untuk pagination */
.pagination-wrapper {
    background-color: #f8f9fa !important;
    padding: 15px !important;
    border-radius: 8px !important;
    margin-top: 20px !important;
}

/* Background putih untuk card header (Daftar Table Kegiatan Lainnya - 2025) */
.card-header {
    background-color: #ffffff !important;
    border-bottom: 1px solid #e9ecef !important;
}

/* Background abu-abu untuk search dan filter controls */
.input-group, 
.dropdown {
    background-color: transparent !important;
}

.form-control, 
.form-select {
    background-color: #ffffff !important;
    border: 1px solid #d1d3e2 !important;
}

/* Background untuk empty state */
.text-center.text-muted.py-10 {
    background-color: #f8f9fa !important;
    border-radius: 8px !important;
    margin: 20px 0 !important;
}

/* Background untuk modal */
.modal-content {
    background-color: #ffffff !important;
}

/* Background putih khusus untuk area filter yang aktif */
.card-header.border-0.pt-3.pb-3.bg-light {
    background-color: #ffffff !important;
}

/* Background untuk toast notifications */
.toast {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2) !important;
}

/* Responsive background adjustments */
@media (max-width: 768px) {
    .card-body {
        background-color: #ffffff !important;
    }
    
    .table-responsive {
        background-color: #ffffff !important;
        border-radius: 8px !important;
        padding: 10px !important;
    }
}

/* Additional styling untuk konsistensi */
.breadcrumb {
    background-color: transparent !important;
}

.btn-light {
    background-color: #f8f9fa !important;
    border-color: #d6d8db !important;
}

.btn-light:hover {
    background-color: #e2e6ea !important;
    border-color: #dae0e5 !important;
}

/* Background untuk area konten utama */
#kt_app_content {
    background-color: #f8f9fa !important;
    min-height: 100vh !important;
}

/* Background untuk wrapper content */
#kt_app_content_container {
    background-color: #f8f9fa !important;
}
    </style>    


    {{-- Page Header --}}
    <div class="d-flex flex-column mb-8">
        <h1 class="text-dark fw-bold mb-1">Kegiatan Lainnya</h1>
        <div class="text-muted fw-semibold fs-6">Jelajahi Kegiatan Lainnya Yang Terdaftar</div>
    </div>

    {{-- Main Content Card --}}
    <div class="row col-12 mt-5">
        <div class="card">
            {{-- Card Header --}}
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap py-5">
                <h3 class="card-title fw-bold fs-4 mb-0">Daftar Table Kegiatan Lainnya - 2025</h3>

                @if (request('jenis_kegiatan_filter'))
                    <div class="card-header border-0 pt-3 pb-3 bg-light">
                        <div class="card-title">
                            <div class="d-flex align-items-center position-relative my-1">
                                <i class="ki-duotone ki-filter fs-3 position-absolute ms-4">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                <span class="fs-6 fw-semibold text-gray-700 ms-10">Filter Aktif:</span>
                                <span class="badge badge-light-primary ms-2">
                                    Jenis: {{ request('jenis_kegiatan_filter') }}
                                </span>
                                <button class="btn btn-sm btn-icon btn-light-danger ms-5"
                                    onclick="window.location.href='{{ route('admin.laporan-lpj.kegiatan_lainnya.index') }}'"
                                    title="Hapus filter">
                                    <i class="fa-solid fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endif
                
                {{-- Action Buttons --}}
                <div class="d-flex align-items-center gap-2 flex-wrap ms-auto">
                    {{-- Add Button --}}
                    <a href="{{ route('admin.laporan-lpj.kegiatan_lainnya.create') }}" class="btn custom-red-button"
                        style="background-color: #F8285A !important; color: white !important; border-color: #F8285A !important;">
                        <i class="ki-duotone ki-plus fs-2" style="color: white !important;"></i>Tambah Laporan
                    </a>

                    {{-- Export Button --}}
                    <a href="{{ route('admin.laporan-lpj.kegiatan_lainnya.export', request()->query()) }}"
                        class="btn btn-light-primary" target="_blank">
                        <i class="ki-duotone ki-document fs-2"></i>Export Data
                    </a>

                    {{-- Search Input --}}
                    <div class="input-group" style="width: 250px;">
                        <input type="search" name="search" id="search" class="form-control"
                            placeholder="Cari kegiatan..." value="{{ request('search') }}">
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
                            {{-- Filter by Jenis Kegiatan --}}
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
                @if ($kegiatanLainnya->isEmpty())
                    @if (request('search'))
                        {{-- Empty State untuk Search Tidak Ditemukan --}}
                        <div class="text-center text-muted py-10">
                            <i class="ki-duotone ki-magnifier fs-3x mb-3"></i>
                            <h4>Data tidak ditemukan untuk pencarian "{{ request('search') }}"</h4>
                            <button class="btn btn-light-primary"
                                onclick="window.location.href='{{ route('admin.laporan-lpj.kegiatan_lainnya.index') }}'">
                                Reset Pencarian
                            </button>
                        </div>
                    @elseif(request('jenis_kegiatan_filter'))
                        {{-- Empty State untuk Filter Tidak Ditemukan --}}
                        <div class="text-center text-muted py-10">
                            <i class="ki-duotone ki-filter fs-3x mb-3"></i>
                            <h4>Data tidak ditemukan untuk jenis kegiatan "{{ request('jenis_kegiatan_filter') }}"</h4>
                            <button class="btn btn-light-primary"
                                onclick="window.location.href='{{ route('admin.laporan-lpj.kegiatan_lainnya.index') }}'">
                                Reset Filter
                            </button>
                        </div>
                    @else
                        {{-- Empty State untuk Data Kosong --}}
                        <div class="text-center text-muted py-10">
                            <i class="ki-duotone ki-information-5 fs-3x mb-3"></i>
                            <h4>Data tidak tersedia</h4>
                        </div>
                    @endif
                @else
                    {{-- Data Table --}}
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle"
                            id="kt_datatable_dom_positioning_kegiatan">
                            {{-- Table Header --}}
                            <thead class="bg-light">
                                <tr>
                                    <th>No</th>
                                    <th>
                                        <a href="{{ sortUrl('nama_program_kegiatan') }}"
                                            class="text-dark text-decoration-none">
                                            Nama Program & Kegiatan {!! sortIcon('nama_program_kegiatan') !!}
                                        </a>
                                    </th>
                                    <th>
                                        <a href="{{ sortUrl('volume') }}" class="text-dark text-decoration-none">
                                            Volume {!! sortIcon('volume') !!}
                                        </a>
                                    </th>
                                    <th>
                                        <a href="{{ sortUrl('jumlah_harga_satuan') }}"
                                            class="text-dark text-decoration-none">
                                            Jumlah Harga Satuan {!! sortIcon('jumlah_harga_satuan') !!}
                                        </a>
                                    </th>
                                    <th>
                                        <a href="{{ sortUrl('jumlah_harga') }}" class="text-dark text-decoration-none">
                                            Jumlah Harga {!! sortIcon('jumlah_harga') !!}
                                        </a>
                                    </th>
                                    <th>Foto Jurnal</th>
                                    <th>Dokumen</th>
                                    <th>
                                        <a href="{{ sortUrl('created_at') }}" class="text-dark text-decoration-none">
                                            Ditambahkan {!! sortIcon('created_at') !!}
                                        </a>
                                    </th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>

                            {{-- Table Body --}}
                            <tbody>
                                @forelse ($kegiatanLainnya as $index => $kegiatan)
                                    <tr data-jenis-kegiatan="{{ $kegiatan->jenis_kegiatan ?? '' }}"
                                        data-tanggal="{{ \Carbon\Carbon::parse($kegiatan->tanggal_kegiatan ?? $kegiatan->created_at)->format('Y-m-d') }}">
                                        <td class="text-center">
                                            {{ ($kegiatanLainnya->currentPage() - 1) * $kegiatanLainnya->perPage() + $index + 1 }}
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <strong class="text-truncate-custom"
                                                    title="{{ $kegiatan->nama_program_kegiatan }}">
                                                    {{ $kegiatan->nama_program_kegiatan }}
                                                </strong>
                                                <small class="text-muted">{{ $kegiatan->jenis_kegiatan ?? '-' }}</small>
                                            </div>
                                        </td>
                                        <td>{{ $kegiatan->volume }}</td>
                                        <td>Rp {{ number_format($kegiatan->jumlah_harga_satuan, 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format($kegiatan->jumlah_harga, 0, ',', '.') }}</td>
                                        <td>
                                            @if ($kegiatan->foto_jurnal)
                                                <a href="{{ asset('storage/' . $kegiatan->foto_jurnal) }}" target="_blank"
                                                    class="btn btn-sm btn-light-info">Lihat Foto</a>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($kegiatan->dokumen_pendukung)
                                                <a href="{{ asset('storage/' . $kegiatan->dokumen_pendukung) }}"
                                                    target="_blank" class="btn btn-sm btn-light-primary">Lihat Dokumen</a>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($kegiatan->created_at)->format('d M Y') }}</td>
                                        <td class="text-center">
                                            <div class="dropdown">
                                                <button class="btn btn-sm p-0" type="button" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <svg width="32" height="32" viewBox="0 0 32 32"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <rect width="32" height="32" rx="6"
                                                            fill="#EFF6FF" />
                                                        <rect x="0.5" y="0.5" width="31" height="31"
                                                            rx="5.5" stroke="#1B84FF" stroke-opacity="0.2" />
                                                        <g clip-path="url(#clip0_2223_4269)">
                                                            <path opacity="0.3"
                                                                d="M19.4266 7.9375H12.5734C10.0131 7.9375 7.9375 10.0131 7.9375 12.5734V19.4266C7.9375 21.9869 10.0131 24.0625 12.5734 24.0625H19.4266C21.9869 24.0625 24.0625 21.9869 24.0625 19.4266V12.5734C24.0625 10.0131 21.9869 7.9375 19.4266 7.9375Z"
                                                                fill="#1B84FF" />
                                                            <path
                                                                d="M12.251 14.8232C12.8475 14.8233 13.331 15.3067 13.3311 15.9033C13.3311 16.4999 12.8476 16.9833 12.251 16.9834C11.6543 16.9834 11.1709 16.5 11.1709 15.9033C11.1709 15.3067 11.6543 14.8232 12.251 14.8232ZM16.2979 14.8232C16.8945 14.8232 17.3789 15.3066 17.3789 15.9033C17.3789 16.5 16.8945 16.9834 16.2979 16.9834C15.7013 16.9832 15.2178 16.4999 15.2178 15.9033C15.2178 15.3067 15.7013 14.8234 16.2979 14.8232ZM20.3369 14.8232C20.9336 14.8232 21.418 15.3066 21.418 15.9033C21.418 16.5 20.9336 16.9834 20.3369 16.9834C19.7404 16.9832 19.2568 16.4999 19.2568 15.9033C19.2568 15.3068 19.7404 14.8234 20.3369 14.8232Z"
                                                                fill="#1B84FF" />
                                                        </g>
                                                        <defs>
                                                            <clipPath id="clip0_2223_4269">
                                                                <rect width="16" height="16" fill="white"
                                                                    transform="translate(8 8)" />
                                                            </clipPath>
                                                        </defs>
                                                    </svg>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end cursor-pointer">
                                                    <li>
                                                        <a href="{{ route('admin.laporan-lpj.kegiatan_lainnya.show', $kegiatan->id) }}"
                                                            class="dropdown-item">
                                                            <i class="fa-solid fa-eye me-2"></i>Lihat Detail
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('admin.laporan-lpj.kegiatan_lainnya.edit', $kegiatan->id) }}"
                                                            class="dropdown-item">
                                                            <i class="fa-solid fa-pen-to-square me-2"></i>Modifikasi
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <hr class="dropdown-divider">
                                                    </li>
                                                    <li>
                                                        <button type="button"
                                                            class="dropdown-item text-danger border-0 bg-transparent w-100 text-start delete-btn"
                                                            data-id="{{ $kegiatan->id }}"
                                                            data-name="{{ $kegiatan->nama_program_kegiatan }}">
                                                            <i class="fa-solid fa-trash me-2"></i>Hapus
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-5 text-muted">Data tidak ditemukan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination Controls --}}
                    <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap">
                        <!-- Per Page Selector -->
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

                        <!-- Pagination Links -->
                        <div class="d-flex align-items-center gap-3">
                            <div class="d-flex align-items-center">
                                <span class="me-2">Page {{ $kegiatanLainnya->currentPage() }} of
                                    {{ $kegiatanLainnya->lastPage() }}</span>
                            </div>
                            <div class="pagination-wrapper">
                                <ul class="pagination pagination-sm">
                                    <!-- Previous Page Link -->
                                    <li class="page-item {{ $kegiatanLainnya->onFirstPage() ? 'disabled' : '' }}">
                                        <a class="page-link" href="{{ $kegiatanLainnya->previousPageUrl() }}"
                                            aria-label="Previous">
                                            <i class="fas fa-chevron-left"></i>
                                        </a>
                                    </li>

                                    <!-- Pagination Elements -->
                                    @foreach ($kegiatanLainnya->getUrlRange(1, $kegiatanLainnya->lastPage()) as $page => $url)
                                        @if ($page == $kegiatanLainnya->currentPage())
                                            <li class="page-item active" aria-current="page">
                                                <span class="page-link">{{ $page }}</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                            </li>
                                        @endif
                                    @endforeach

                                    <!-- Next Page Link -->
                                    <li class="page-item {{ !$kegiatanLainnya->hasMorePages() ? 'disabled' : '' }}">
                                        <a class="page-link" href="{{ $kegiatanLainnya->nextPageUrl() }}"
                                            aria-label="Next">
                                            <i class="fas fa-chevron-right"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    {{-- Results Info --}}
                    <div class="text-muted mt-2 text-center">
                        Showing {{ $kegiatanLainnya->firstItem() }} to {{ $kegiatanLainnya->lastItem() }}
                        of {{ $kegiatanLainnya->total() }} results
                    </div>
                @endif
            </div>
        </div>
    </div>


    {{-- Add Modal --}}
<div class="modal fade" id="modal_add_kegiatan_lainnya" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content">
                {{-- Modal Header --}}
                <div class="modal-header">
                    <h2 class="fw-bold">Tambah Kegiatan Lainnya</h2>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <i class="fa-solid fa-times fs-1"></i>
                    </div>
                </div>

                {{-- Modal Body --}}
                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                    <form id="kt_modal_add_kegiatan_form" class="form"
                        action="{{ route('admin.laporan-lpj.kegiatan_lainnya.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        {{-- Nama Program & Kegiatan --}}
                        <div class="fv-row mb-7">
                            <label class="required fw-semibold fs-6 mb-2">Nama Program & Kegiatan</label>
                            <input type="text" name="nama_program_kegiatan"
                                class="form-control form-control-solid mb-3 mb-lg-0"
                                placeholder="Masukkan nama program dan kegiatan" required />
                        </div>

                        {{-- Jenis Kegiatan --}}
                        <div class="fv-row mb-7">
                            <label class="required fw-semibold fs-6 mb-2">Jenis Kegiatan</label>
                            <input type="text" name="jenis_kegiatan"
                                class="form-control form-control-solid mb-3 mb-lg-0"
                                placeholder="Contoh: Rapat, Pelatihan, Pembelian" required />
                        </div>

                        {{-- Tanggal Kegiatan --}}
                        <div class="fv-row mb-7">
                            <label class="required fw-semibold fs-6 mb-2">Tanggal Kegiatan</label>
                            <input type="date" name="tanggal_kegiatan"
                                class="form-control form-control-solid mb-3 mb-lg-0" required />
                        </div>

                        {{-- Volume --}}
                        <div class="fv-row mb-7">
                            <label class="required fw-semibold fs-6 mb-2">Volume</label>
                            <input type="text" name="volume" class="form-control form-control-solid mb-3 mb-lg-0"
                                placeholder="Masukkan volume kegiatan (contoh: 20 unit, 1 kegiatan)" required />
                        </div>

                        {{-- Jumlah Harga Satuan --}}
                        <div class="fv-row mb-7">
                            <label class="required fw-semibold fs-6 mb-2">Jumlah Harga Satuan</label>
                            <input type="number" name="jumlah_harga_satuan"
                                class="form-control form-control-solid mb-3 mb-lg-0"
                                placeholder="Masukkan jumlah harga satuan" required />
                        </div>

                        {{-- Jumlah Harga --}}
                        <div class="fv-row mb-7">
                            <label class="required fw-semibold fs-6 mb-2">Jumlah Harga</label>
                            <input type="number" name="jumlah_harga"
                                class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Masukkan jumlah harga"
                                required />
                        </div>

                        {{-- Foto Jurnal --}}
                        <div class="fv-row mb-7">
                            <label class="fw-semibold fs-6 mb-2">Foto Jurnal</label>
                            <input type="file" name="foto_jurnal" class="form-control form-control-solid mb-3 mb-lg-0"
                                accept="image/*" />
                        </div>

                        {{-- Dokumen Pendukung --}}
                        <div class="fv-row mb-7">
                            <label class="fw-semibold fs-6 mb-2">Dokumen Pendukung</label>
                            <input type="file" name="dokumen_pendukung"
                                class="form-control form-control-solid mb-3 mb-lg-0"
                                accept=".pdf,.doc,.docx,.xls,.xlsx" />
                        </div>

                        {{-- Form Actions --}}
                        <div class="text-center pt-15">
                            <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">
                                <span class="indicator-label">Simpan</span>
                                <span class="indicator-progress">Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                        </div>
                    </form>
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
                <button type="button" class="btn-close btn-close-white me-2 m-auto"
                    data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>  


               
@endsection

@section('script')
    @if ($kegiatanLainnya->isNotEmpty())
        <script>
            $(document).ready(function() {
                // Initialize DataTable for search and filter functionality
                const table = $("#kt_datatable_dom_positioning_kegiatan").DataTable({
                    paging: false,
                    info: false,
                    searching: false,
                    ordering: true,
                    responsive: true,
                    autoWidth: false,
                    scrollX: false,
                    columnDefs: [{
                            targets: -1, // Last column (Aksi)
                            orderable: false,
                            searchable: false
                        },
                        {
                            width: "50px",
                            targets: 0 // No column
                        }
                    ]
                });

                // Helper function to update URL and redirect for server-side operations
                function updateUrlAndRedirect(params) {
                    const currentUrl = new URL(window.location.href);
                    for (const key in params) {
                        if (params[key]) {
                            currentUrl.searchParams.set(key, params[key]);
                        } else {
                            currentUrl.searchParams.delete(key);
                        }
                    }
                    currentUrl.searchParams.set('page', 1); // Reset to first page
                    window.location.href = currentUrl.toString();
                }

                // Handle per page selection
                $('#per-page-select').on('change', function() {
                    const perPage = $(this).val();
                    const currentUrl = new URL(window.location.href);

                    // Update per_page parameter
                    currentUrl.searchParams.set('per_page', perPage);
                    // Reset to first page when changing per_page
                    currentUrl.searchParams.set('page', 1);

                    window.location.href = currentUrl.toString();
                });

                // Handle search functionality
                $('#search-button').on('click', function() {
                    updateUrlAndRedirect({
                        'search': $('#search').val()
                    });
                });

                let searchTimer;
                $('#search').on('keyup', function() {
                    clearTimeout(searchTimer);
                    searchTimer = setTimeout(() => {
                        updateUrlAndRedirect({
                            'search': $('#search').val()
                        });
                    }, 500);
                });

                // Handle filter functionality
                $('#apply-filters').on('click', function() {
                    const jenisKegiatan = $('#filter-jenis-kegiatan').val();
                    updateUrlAndRedirect({
                        'jenis_kegiatan_filter': jenisKegiatan
                    });
                });

                $('#reset-filters').on('click', function() {
                    window.location.href = "{{ route('admin.laporan-lpj.kegiatan_lainnya.index') }}";
                });

                // Update filter count badge
                function updateFilterCount() {
                    const hasFilter = new URLSearchParams(window.location.search).has('jenis_kegiatan_filter');
                    const badge = $('#filter-count');
                    if (hasFilter) {
                        badge.text('1').removeClass('d-none');
                    } else {
                        badge.addClass('d-none');
                    }
                }

                // Highlight search term
                function highlightSearchTerm() {
                    const searchTerm = "{{ request('search') }}";
                    if (searchTerm) {
                        $('td').each(function() {
                            const text = $(this).text();
                            const highlighted = text.replace(
                                new RegExp(searchTerm, 'gi'),
                                match => `<span class="bg-warning">${match}</span>`
                            );
                            if (highlighted !== text) {
                                $(this).html(highlighted);
                            }
                        });
                    }
                }

                // Initialize highlight and filter count
                highlightSearchTerm();
                updateFilterCount();

                // === DELETE FUNCTIONALITY === 
                let deleteId = null;
                let deleteUrl = null;

                // Handle delete button click
                $(document).on('click', '.delete-btn', function(e) {
                    e.preventDefault();
                    
                    deleteId = $(this).data('id');
                    const itemName = $(this).data('name');
                    deleteUrl = "{{ route('admin.laporan-lpj.kegiatan_lainnya.destroy', '') }}/" + deleteId;
                    
                    // Set item name in modal
                    $('#delete-item-name').text(itemName);
                    
                    // Show modal
                    $('#modal_delete_confirmation').modal('show');
                });

                // Handle confirm delete
                $('#confirm-delete-btn').click(function() {
                    if (!deleteId || !deleteUrl) return;

                    const $btn = $(this);
                    const $modal = $('#modal_delete_confirmation');

                    // Show loading state
                    $btn.attr('data-kt-indicator', 'on');
                    $btn.prop('disabled', true);

                    // Create CSRF token
                    const token = $('meta[name="csrf-token"]').attr('content');

                    // Perform AJAX delete
                    $.ajax({
                        url: deleteUrl,
                        type: 'POST',
                        data: {
                            _method: 'DELETE',
                            _token: token
                        },
                        timeout: 10000, // 10 seconds timeout
                        success: function(response) {
                            // Hide modal
                            $modal.modal('hide');
                            
                            // Show success notification
                            showSuccessToast('✔️ Data berhasil dihapus.');
                            
                            // Remove row from table with animation
                            const $row = $(`tr:has(button[data-id="${deleteId}"])`);
                            $row.fadeOut(500, function() {
                                $(this).remove();
                                updateRowNumbers();
                                checkEmptyTable();
                            });
                            
                            // Reset states
                            resetDeleteState($btn);
                            
                        },
                        error: function(xhr, status, error) {
                            // Hide modal
                            $modal.modal('hide');
                            
                            let errorMessage = '❌ Gagal menghapus data. Silakan coba lagi.';
                            
                            // Handle different error types
                            if (status === 'timeout') {
                                errorMessage = '❌ Koneksi timeout. Silakan coba lagi.';
                            } else if (xhr.status === 500) {
                                errorMessage = '❌ Terjadi kesalahan server. Silakan coba lagi.';
                            } else if (xhr.status === 403) {
                                errorMessage = '❌ Anda tidak memiliki akses untuk menghapus data ini.';
                            } else if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = '❌ ' + xhr.responseJSON.message;
                            }
                            
                            // Show error notification
                            showErrorToast(errorMessage);
                            
                            // Reset states
                            resetDeleteState($btn);
                        }
                    });
                });

                // Reset modal when closed
                $('#modal_delete_confirmation').on('hidden.bs.modal', function() {
                    const $btn = $('#confirm-delete-btn');
                    resetDeleteState($btn);
                    deleteId = null;
                    deleteUrl = null;
                });

                // Helper functions for delete
                function resetDeleteState($btn) {
                    $btn.attr('data-kt-indicator', 'off');
                    $btn.prop('disabled', false);
                }

                function showSuccessToast(message) {
                    $('#toast-success-message').text(message);
                    const toast = new bootstrap.Toast(document.getElementById('toast-success'));
                    toast.show();
                }

                function showErrorToast(message) {
                    $('#toast-error-message').text(message);
                    const toast = new bootstrap.Toast(document.getElementById('toast-error'));
                    toast.show();
                }

                function updateRowNumbers() {
                    const currentPage = {{ $kegiatanLainnya->currentPage() ?? 1 }};
                    const perPage = {{ $kegiatanLainnya->perPage() ?? 10 }};
                    const startNumber = (currentPage - 1) * perPage;
                    
                    $('#kt_datatable_dom_positioning_kegiatan tbody tr').each(function(index) {
                        $(this).find('td:first').text(startNumber + index + 1);
                    });
                }

                function checkEmptyTable() {
                    const $tbody = $('#kt_datatable_dom_positioning_kegiatan tbody');
                    if ($tbody.find('tr').length === 0) {
                        $tbody.html(`
                            <tr>
                                <td colspan="9" class="text-center py-5 text-muted">
                                    <i class="ki-duotone ki-information-5 fs-3x mb-3"></i>
                                    <br>Data tidak tersedia
                                </td>
                            </tr>
                        `);
                    }
                }
            });
        </script>
    @endif
@endsection