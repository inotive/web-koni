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

        /* Fixed Column Width Settings with text truncation */
        .table th:nth-child(1),
        .table td:nth-child(1) {
            width: 50px !important;
            max-width: 50px !important;
        }

        /* No */
        .table th:nth-child(2),
        .table td:nth-child(2) {
            width: 250px !important;
            max-width: 250px !important;
        }

        /* Nama Program & Kegiatan */
        .table th:nth-child(3),
        .table td:nth-child(3) {
            width: 100px !important;
            max-width: 100px !important;
        }

        /* Volume */
        .table th:nth-child(4),
        .table td:nth-child(4) {
            width: 150px !important;
            max-width: 150px !important;
        }

        /* Jumlah Harga Satuan */
        .table th:nth-child(5),
        .table td:nth-child(5) {
            width: 150px !important;
            max-width: 150px !important;
        }

        /* Jumlah Harga */
        .table th:nth-child(6),
        .table td:nth-child(6) {
            width: 100px !important;
            max-width: 100px !important;
        }

        /* Foto Jurnal */
        .table th:nth-child(7),
        .table td:nth-child(7) {
            width: 100px !important;
            max-width: 100px !important;
        }

        /* Dokumen */
        .table th:nth-child(8),
        .table td:nth-child(8) {
            width: 120px !important;
            max-width: 120px !important;
        }

        /* Tanggal Ditambahkan */
        .table th:nth-child(9),
        .table td:nth-child(9) {
            width: 100px !important;
            max-width: 100px !important;
        }

        /* Aksi */

        /* Text truncation for all cells except action column */
        .table td:not(:last-child) {
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

                {{-- Action Buttons --}}
                <div class="d-flex align-items-center gap-2 flex-wrap ms-auto">
                    {{-- Add Button --}}
                    <button type="button" class="btn custom-red-button" data-bs-toggle="modal"
                        data-bs-target="#modal_add_kegiatan_lainnya"
                        style="background-color: #F8285A !important; color: white !important; border-color: #F8285A !important;">
                        <i class="ki-duotone ki-plus fs-2" style="color: white !important;"></i>Tambah Laporan
                    </button>

                    {{-- Export Button --}}
                    <button type="button" class="btn btn-light-primary">
                        <i class="ki-duotone ki-document fs-2"></i>Export Data
                    </button>

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

                            {{-- Filter by Date Range --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Rentang Tanggal</label>
                                <input type="date" id="filter-start-date" class="form-control mb-2"
                                    value="{{ request('start_date') }}">
                                <input type="date" id="filter-end-date" class="form-control"
                                    value="{{ request('end_date') }}">
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
                    {{-- Empty State --}}
                    <div class="text-center text-muted py-10">
                        <i class="ki-duotone ki-information-5 fs-3x mb-3"></i>
                        <h4>Data tidak tersedia</h4>
                    </div>
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
                                            <div class="d-flex justify-content-center gap-1">
                                                {{-- Detail Button --}}
                                                <a href="{{ route('admin.laporan-lpj.kegiatan_lainnya.show', $kegiatan->id) }}"
                                                    class="btn btn-icon btn-sm btn-light-primary" title="Detail">
                                                    <i class="fa-solid fa-eye"></i>
                                                </a>

                                                {{-- Edit Button --}}
                                                <a href="{{ route('admin.laporan-lpj.kegiatan_lainnya.edit', $kegiatan->id) }}"
                                                    class="btn btn-icon btn-sm btn-light-warning" title="Edit">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </a>

                                                {{-- Delete Button --}}
                                                <form
                                                    action="{{ route('admin.laporan-lpj.kegiatan_lainnya.destroy', $kegiatan->id) }}"
                                                    method="POST" class="d-inline"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus kegiatan ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-icon btn-sm btn-light-danger"
                                                        title="Hapus">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                </form>
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
            <span class="me-2">Page {{ $kegiatanLainnya->currentPage() }} of {{ $kegiatanLainnya->lastPage() }}</span>
        </div>
        <div class="pagination-wrapper">
            <ul class="pagination pagination-sm">
                <!-- Previous Page Link -->
                <li class="page-item {{ $kegiatanLainnya->onFirstPage() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $kegiatanLainnya->previousPageUrl() }}" aria-label="Previous">
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
                    <a class="page-link" href="{{ $kegiatanLainnya->nextPageUrl() }}" aria-label="Next">
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
            

                /// Handle search functionality
    $('#search-button').on('click', function() {
        updateUrlAndRedirect({
            'search': $('#search').val()
        });
    });

                $('#search').on('keypress', function(e) {
                    if (e.which === 13) { // Enter key
                        $('#search-button').click();
                    }
                });

                // Handle filter functionality
                $('#apply-filters').on('click', function() {
                    const jenisKegiatan = $('#filter-jenis-kegiatan').val();
                    const startDate = $('#filter-start-date').val();
                    const endDate = $('#filter-end-date').val();

                    updateUrlAndRedirect({
                        'jenis_kegiatan_filter': jenisKegiatan,
                        'start_date': startDate,
                        'end_date': endDate
                    });
                });

                $('#reset-filters').on('click', function() {
                    window.location.href = "{{ route('admin.laporan-lpj.kegiatan_lainnya.index') }}";
                });

                // Update filter count badge
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

                // Initialize filter count on page load
                updateFilterCount();
            });
        </script>
    @endif
@endsection
