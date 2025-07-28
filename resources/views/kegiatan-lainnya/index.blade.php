@extends('layouts.app')

@section('pageTitle', 'Laporan LPJ - Kegiatan Lainnya')
@section('mainSection', 'Laporan LPJ')
@section('currentSection', 'Kegiatan Lainnya')

@section('breadcrumb-title')
    {{-- <h1 class="d-flex flex-column text-dark fw-bold fs-3 mb-0">Laporan LPJ - Kegiatan Lainnya</h1> --}}
@endsection

@section('breadcrumb-items')
    {{-- <li class="breadcrumb-item text-gray-600">Laporan LPJ</li>
    <li class="breadcrumb-item text-gray-600">Kegiatan Lainnya</li> --}}
@endsection

@section('content')

<style>
    table td,
    table th {
        vertical-align: middle;
        word-wrap: break-word;
        max-width: 200px;
    }

    .object-fit-cover {
        object-fit: cover;
    }

    .table-responsive {
        overflow-x: visible !important;
    }

    .table th:nth-child(1) {
        width: 50px;
    }

    /* No */
    .table th:nth-child(2) {
        width: 200px;
    }

    /* Nama Program & Kegiatan */
    .table th:nth-child(3) {
        width: 120px;
    }

    /* Volume */
    .table th:nth-child(4) {
        width: 150px;
    }

    /* Jumlah Harga Satuan */
    .table th:nth-child(5) {
        width: 150px;
    }

    /* Jumlah Harga */
    .table th:nth-child(6) {
        width: 100px;
    }

    /* Foto Jurnal */
    .table th:nth-child(7) {
        width: 100px;
    }

    /* Dokumen */
    .table th:nth-child(8) {
        width: 120px;
    }

    /* Aksi */

    .text-truncate-custom {
        max-width: 120px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .currency-format {
        color: #28a745;
        font-weight: 600;
    }

    /* Responsive adjustments */
    @media (max-width: 1200px) {
        .table th:nth-child(4),
        .table th:nth-child(5),
        .table th:nth-child(6),
        .table th:nth-child(7) {
            display: none;
        }

        .table td:nth-child(4),
        .table td:nth-child(5),
        .table td:nth-child(6),
        .table td:nth-child(7) {
            display: none;
        }
    }

    @media (max-width: 768px) {
        .table th:nth-child(3) {
            display: none;
        }

        .table td:nth-child(3) {
            display: none;
        }

        .card-body {
            overflow-x: hidden !important;
        }

        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
    }

    .badge-status {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
    }
</style>

<div class="row col-12 mt-5">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
            <h3 class="card-title fw-bold fs-3 mb-0">Laporan LPJ - Kegiatan Lainnya</h3>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.laporan-lpj.kegiatan-lainnya.export-excel') }}" class="btn btn-success">
                    <i class="fas fa-file-excel me-1"></i>Export Excel
                </a>
                <a href="{{ route('admin.laporan-lpj.kegiatan-lainnya.export-pdf') }}" class="btn btn-danger">
                    <i class="fas fa-file-pdf me-1"></i>Export PDF
                </a>
                <a href="{{ route('admin.laporan-lpj.kegiatan-lainnya.create') }}" class="btn custom-red-button"
                    style="background-color: #F8285A !important; color: white !important; border-color: #F8285A !important;">
                    <i class="ki-duotone ki-plus fs-2" style="color: white !important;"></i>Tambah Kegiatan
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
                <h2 class="mb-0">Laporan Kegiatan Lainnya</h2>

                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <div class="input-group" style="width: 250px;">
                        <input type="search" name="search" id="search" class="form-control"
                            placeholder="Cari kegiatan...">
                        <button class="btn btn-outline-secondary" type="button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>

                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                            data-bs-toggle="dropdown">
                            <i class="fas fa-filter me-1"></i> Filter
                            <span id="filter-count" class="badge badge-circle badge-danger ms-1 d-none">0</span>
                        </button>
                        <div class="dropdown-menu p-3 shadow" style="min-width: 320px;">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Periode Laporan</label>
                                <select id="filter-periode" class="form-select">
                                    <option value="">Semua Periode</option>
                                    <option value="2024">2024</option>
                                    <option value="2023">2023</option>
                                    <option value="2022">2022</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Kategori Program</label>
                                <select id="filter-kategori" class="form-select">
                                    <option value="">Semua Kategori</option>
                                    @foreach ($kegiatans->pluck('kategori_program')->unique()->filter() as $kategori)
                                        <option value="{{ $kategori }}">{{ $kategori }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Rentang Harga</label>
                                <select id="filter-harga" class="form-select">
                                    <option value="">Semua Harga</option>
                                    <option value="0-1000000">< Rp 1.000.000</option>
                                    <option value="1000000-5000000">Rp 1.000.000 - Rp 5.000.000</option>
                                    <option value="5000000-10000000">Rp 5.000.000 - Rp 10.000.000</option>
                                    <option value="10000000+">> Rp 10.000.000</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Status Dokumen</label>
                                <select id="filter-dokumen" class="form-select">
                                    <option value="">Semua</option>
                                    <option value="ada">Ada Dokumen</option>
                                    <option value="tidak">Tidak Ada Dokumen</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Status Foto Jurnal</label>
                                <select id="filter-foto" class="form-select">
                                    <option value="">Semua</option>
                                    <option value="ada">Ada Foto</option>
                                    <option value="tidak">Tidak Ada Foto</option>
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

            @if ($kegiatans->isEmpty())
                <div class="text-center text-muted py-10">
                    <i class="ki-duotone ki-information-5 fs-3x mb-3"></i>
                    <h4>Tidak ada data laporan kegiatan lainnya.</h4>
                </div>
            @else
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div id="filter-info" class="text-muted">
                        Menampilkan <span id="showing-count">{{ $kegiatans->count() }}</span> dari <span
                            id="total-count">{{ $kegiatans->total() }}</span> kegiatan
                    </div>
                </div>

                {{-- Table --}}
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle" id="kt_datatable_dom_positioning">
                        <thead class="bg-light">
                            <tr>
                                <th>No</th>
                                <th><a href="{{ sortUrl('nama_program') }}" class="text-dark text-decoration-none">Nama Program & Kegiatan
                                        {!! sortIcon('nama_program') !!}</a></th>
                                <th class="d-none d-md-table-cell"><a href="{{ sortUrl('volume') }}"
                                        class="text-dark text-decoration-none">Volume {!! sortIcon('volume') !!}</a></th>
                                <th class="d-none d-xl-table-cell"><a href="{{ sortUrl('harga_satuan') }}"
                                        class="text-dark text-decoration-none">Jumlah Harga Satuan {!! sortIcon('harga_satuan') !!}</a></th>
                                <th class="d-none d-xl-table-cell"><a href="{{ sortUrl('jumlah_harga') }}"
                                        class="text-dark text-decoration-none">Jumlah Harga {!! sortIcon('jumlah_harga') !!}</a></th>
                                <th class="d-none d-xl-table-cell">Foto Jurnal</th>
                                <th class="d-none d-xl-table-cell">Dokumen</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($kegiatans as $index => $kegiatan)
                                <tr data-kategori="{{ $kegiatan->kategori_program }}" 
                                    data-harga="{{ $kegiatan->jumlah_harga }}"
                                    data-dokumen="{{ $kegiatan->dokumen ? 'ada' : 'tidak' }}"
                                    data-foto="{{ $kegiatan->foto_jurnal ? 'ada' : 'tidak' }}">
                                    <td class="text-center">{{ ($kegiatans->currentPage() - 1) * $kegiatans->perPage() + $index + 1 }}</td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <strong class="text-truncate-custom">{{ $kegiatan->nama_program }}</strong>
                                            <small class="text-muted">{{ $kegiatan->nama_kegiatan }}</small>
                                            @if($kegiatan->kategori_program)
                                                <span class="badge badge-light-info badge-status mt-1">{{ $kegiatan->kategori_program }}</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="d-none d-md-table-cell">
                                        <div class="d-flex flex-column">
                                            <span class="fw-bold">{{ $kegiatan->volume ?? '-' }}</span>
                                            @if($kegiatan->satuan)
                                                <small class="text-muted">{{ $kegiatan->satuan }}</small>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="d-none d-xl-table-cell">
                                        @if ($kegiatan->harga_satuan)
                                            <span class="currency-format">Rp {{ number_format($kegiatan->harga_satuan, 0, ',', '.') }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="d-none d-xl-table-cell">
                                        @if ($kegiatan->jumlah_harga)
                                            <span class="currency-format fw-bold">Rp {{ number_format($kegiatan->jumlah_harga, 0, ',', '.') }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="d-none d-xl-table-cell text-center">
                                        @if ($kegiatan->foto_jurnal)
                                            <div class="d-flex align-items-center justify-content-center">
                                                <img src="{{ asset('storage/' . $kegiatan->foto_jurnal) }}" width="40"
                                                    height="40" class="rounded object-fit-cover me-2">
                                                <a href="{{ asset('storage/' . $kegiatan->foto_jurnal) }}" target="_blank" 
                                                   class="btn btn-icon btn-sm btn-light-primary" title="Lihat Foto">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </div>
                                        @else
                                            <span class="badge badge-light-secondary">Tidak Ada</span>
                                        @endif
                                    </td>
                                    <td class="d-none d-xl-table-cell text-center">
                                        @if ($kegiatan->dokumen)
                                            <div class="d-flex align-items-center justify-content-center">
                                                <i class="fas fa-file-alt fs-2x text-primary me-2"></i>
                                                <a href="{{ asset('storage/' . $kegiatan->dokumen) }}" target="_blank" 
                                                   class="btn btn-icon btn-sm btn-light-primary" title="Lihat Dokumen">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                            </div>
                                        @else
                                            <span class="badge badge-light-secondary">Tidak Ada</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-1">
                                            <a href="{{ route('admin.laporan-lpj.kegiatan-lainnya.show', $kegiatan->id) }}"
                                                class="btn btn-icon btn-sm btn-light-primary" title="Detail">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>

                                            <a href="{{ route('admin.laporan-lpj.kegiatan-lainnya.edit', $kegiatan->id) }}"
                                                class="btn btn-icon btn-sm btn-light-warning" title="Edit">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>

                                            <form action="{{ route('admin.laporan-lpj.kegiatan-lainnya.destroy', $kegiatan->id) }}"
                                                method="POST" class="d-inline"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus kegiatan ini?')">
                                                @csrf @method('DELETE')
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
                                    <td colspan="8" class="text-center py-5 text-muted">Data tidak ditemukan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Custom Pagination --}}
                <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap">
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

                    {{-- Laravel Pagination Links --}}
                    <div class="d-flex align-items-center gap-3">
                        <div class="d-flex align-items-center">
                            <span class="me-2">Page {{ $kegiatans->currentPage() }} of {{ $kegiatans->lastPage() }}</span>
                        </div>

                        <div class="pagination-wrapper">
                            {{ $kegiatans->appends(request()->query())->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>

                {{-- Info Text --}}
                <div class="text-muted mt-2 text-center">
                    Showing {{ $kegiatans->firstItem() }} to {{ $kegiatans->lastItem() }} of {{ $kegiatans->total() }} results
                </div>
            @endif
        </div>
    </div>
</div>

@endsection

@section('script')
    @if ($kegiatans->isNotEmpty())
        <script>
            $(document).ready(function() {
                // Initialize DataTable ONLY for search and filter functionality
                const table = $("#kt_datatable_dom_positioning").DataTable({
                    paging: false, // Disable DataTables pagination
                    info: false,   // Disable DataTables info
                    searching: false, // We'll handle search manually
                    ordering: true,
                    responsive: true,
                    autoWidth: false,
                    scrollX: false,
                    columnDefs: [{
                            targets: -1,
                            orderable: false,
                            searchable: false
                        },
                        {
                            width: "50px",
                            targets: 0
                        },
                        {
                            width: "200px",
                            targets: 1
                        },
                        {
                            width: "120px",
                            targets: 2
                        },
                    ]
                });

                // Handle per page selection
                $('#per-page-select').on('change', function() {
                    const perPage = $(this).val();
                    const currentUrl = new URL(window.location.href);
                    currentUrl.searchParams.set('per_page', perPage);
                    currentUrl.searchParams.set('page', 1); // Reset to first page
                    window.location.href = currentUrl.toString();
                });

                // Handle search functionality
                $('#search').on('keyup', function() {
                    const searchTerm = this.value.toLowerCase();

                    if (searchTerm === '') {
                        // Show all rows if search is empty
                        table.rows().nodes().to$().show();
                    } else {
                        // Hide all rows first
                        table.rows().nodes().to$().hide();

                        // Show matching rows
                        table.rows().nodes().to$().each(function() {
                            const rowText = $(this).text().toLowerCase();
                            if (rowText.includes(searchTerm)) {
                                $(this).show();
                            }
                        });
                    }

                    updateDisplayCount();
                });

                // Custom filter function
                function applyFilters() {
                    const periodeFilter = $('#filter-periode').val();
                    const kategoriFilter = $('#filter-kategori').val();
                    const hargaFilter = $('#filter-harga').val();
                    const dokumenFilter = $('#filter-dokumen').val();
                    const fotoFilter = $('#filter-foto').val();
                    const searchTerm = $('#search').val().toLowerCase();

                    let visibleCount = 0;

                    table.rows().nodes().to$().each(function() {
                        const $row = $(this);
                        const rowPeriode = $row.data('periode');
                        const rowKategori = $row.data('kategori');
                        const rowHarga = parseInt($row.data('harga'));
                        const rowDokumen = $row.data('dokumen');
                        const rowFoto = $row.data('foto');
                        const rowText = $row.text().toLowerCase();

                        let show = true;

                        // Apply search filter
                        if (searchTerm && !rowText.includes(searchTerm)) {
                            show = false;
                        }

                        // Apply periode filter
                        if (periodeFilter && rowPeriode !== periodeFilter) {
                            show = false;
                        }

                        // Apply kategori filter
                        if (kategoriFilter && rowKategori !== kategoriFilter) {
                            show = false;
                        }

                        // Apply harga filter
                        if (hargaFilter) {
                            if (hargaFilter === '0-1000000') {
                                if (rowHarga >= 1000000) show = false;
                            } else if (hargaFilter === '1000000-5000000') {
                                if (rowHarga < 1000000 || rowHarga > 5000000) show = false;
                            } else if (hargaFilter === '5000000-10000000') {
                                if (rowHarga < 5000000 || rowHarga > 10000000) show = false;
                            } else if (hargaFilter === '10000000+') {
                                if (rowHarga < 10000000) show = false;
                            }
                        }

                        // Apply dokumen filter
                        if (dokumenFilter) {
                            if (dokumenFilter === 'ada' && rowDokumen !== 'ada') show = false;
                            if (dokumenFilter === 'tidak' && rowDokumen !== 'tidak') show = false;
                        }

                        // Apply foto filter
                        if (fotoFilter) {
                            if (fotoFilter === 'ada' && rowFoto !== 'ada') show = false;
                            if (fotoFilter === 'tidak' && rowFoto !== 'tidak') show = false;
                        }

                        if (show) {
                            $row.show();
                            visibleCount++;
                        } else {
                            $row.hide();
                        }
                    });

                    updateDisplayCount();
                }

                // Update display count
                function updateDisplayCount() {
                    const visibleRows = table.rows().nodes().to$().filter(':visible').length;
                    const totalRows = {{ $kegiatans->total() }};
                    $('#showing-count').text(visibleRows);
                    $('#total-count').text(totalRows);
                }

                // Filter event handlers
                $('#apply-filters').on('click', function() {
                    applyFilters();
                    updateFilterCount();
                    $('.dropdown-toggle').dropdown('hide');
                });

                $('#reset-filters').on('click', function() {
                    $('#filter-periode').val('');
                    $('#filter-kategori').val('');
                    $('#filter-harga').val('');
                    $('#filter-dokumen').val('');
                    $('#filter-foto').val('');
                    $('#search').val('');

                    // Show all rows
                    table.rows().nodes().to$().show();
                    updateDisplayCount();
                    updateFilterCount();
                    $('.dropdown-toggle').dropdown('hide');
                });

                function updateFilterCount() {
                    const activeFilters = [];

                    if ($('#filter-periode').val()) activeFilters.push('periode');
                    if ($('#filter-kategori').val()) activeFilters.push('kategori');
                    if ($('#filter-harga').val()) activeFilters.push('harga');
                    if ($('#filter-dokumen').val()) activeFilters.push('dokumen');
                    if ($('#filter-foto').val()) activeFilters.push('foto');

                    const count = activeFilters.length;
                    const badge = $('#filter-count');

                    if (count > 0) {
                        badge.text(count).removeClass('d-none');
                    } else {
                        badge.addClass('d-none');
                    }
                }

                // Initialize
                updateDisplayCount();
                updateFilterCount();
            });
        </script>

        <style>
            /* Custom pagination styling */
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
                background-color: #007bff;
                border-color: #007bff;
                color: #fff;
            }

            .pagination-wrapper .page-link:hover {
                color: #495057;
                background-color: #e9ecef;
                border-color: #dee2e6;
            }
        </style>
    @endif
@endsection