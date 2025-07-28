@extends('layouts.app')

@section('pageTitle', 'Manajemen Kegiatan Lainnya')
@section('mainSection', 'Laporan Pertanggungjawaban')
@section('currentSection', 'Kegiatan Lainnya')

{{-- Bagian ini mungkin ada di layout utama (app.blade.php) atau di sini --}}
{{-- Anda bisa membuang komentar breadcrumb-title dan breadcrumb-items jika breadcrumb sudah dihandle di layout --}}
@section('breadcrumb-title')
    {{-- H1 untuk judul utama halaman, bukan di breadcrumb --}}
    {{-- Ini akan menjadi "Bidang Bidang Kegiatan Lainnya" --}}
    {{-- Contoh: <h1 class="d-flex flex-column text-dark fw-bold fs-3 mb-0">Halaman Kegiatan Lainnya</h1> --}}
@endsection

@section('breadcrumb-items')
    {{-- <li class="breadcrumb-item text-gray-600">Kegiatan Lainnya</li> --}}
@endsection


@section('content')

    <style>
        /* CSS yang sudah Anda miliki tetap pertahankan */
        table td,
        table th {
            vertical-align: middle;
            word-wrap: break-word;
            max-width: 200px;
        }

        .object-fit-cover {
            object-fit: cover;
        }

        /* Ini mungkin perlu disesuaikan jika parent container sudah memiliki overflow-x auto */
        /* .table-responsive {
            overflow-x: visible !important;
        } */

        /* Sesuaikan lebar kolom untuk tabel Kegiatan Lainnya */
        /* Pastikan jumlah th dan td di tabel sesuai dengan jumlah ini */
        .table th:nth-child(1) { width: 50px; } /* No */
        .table th:nth-child(2) { width: 250px; } /* Nama Program & Kegiatan (buat lebih lebar) */
        .table th:nth-child(3) { width: 100px; } /* Volume */
        .table th:nth-child(4) { width: 150px; } /* Jumlah Harga Satuan */
        .table th:nth-child(5) { width: 150px; } /* Jumlah Harga */
        .table th:nth-child(6) { width: 100px; } /* Foto Jurnal */
        .table th:nth-child(7) { width: 100px; } /* Dokumen */
        .table th:nth-child(8) { width: 120px; } /* Tanggal Ditambahkan (atau Tanggal Kegiatan jika ada kolom terpisah) */
        .table th:nth-child(9) { width: 100px; } /* Aksi */


        .text-truncate-custom {
            max-width: 200px; /* Sesuaikan jika perlu, harus lebih besar dari th */
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* Responsive adjustments */
        @media (max-width: 1200px) {
            /* Contoh: Sembunyikan kolom tertentu jika layar kecil */
            .table th:nth-child(4), /* Jumlah Harga Satuan */
            .table td:nth-child(4),
            .table th:nth-child(5), /* Jumlah Harga */
            .table td:nth-child(5) {
                /* display: none;  Anda bisa mengaktifkan ini jika ingin menyembunyikan */
            }
        }

        @media (max-width: 768px) {
            .card-body {
                overflow-x: hidden !important;
            }

            .table-responsive {
                overflow-x: auto; /* Ini penting agar tabel bisa discroll horizontal di layar kecil */
                -webkit-overflow-scrolling: touch;
            }
        }
    </style>

    {{-- HEADER UTAMA HALAMAN - MENIRU "Bidang Bidang" --}}
    <div class="d-flex flex-column mb-8">
        <h1 class="text-dark fw-bold mb-1">Kegiatan Lainnya </h1> {{-- Anda bisa ganti "Bidang Bidang Kegiatan" --}}
        <div class="text-muted fw-semibold fs-6">Jelajahi Kegiatan Lainnya Yang Terdaftar</div> {{-- Atau "Manajemen Kegiatan Lainnya" --}}
    </div>

     {{-- Anda bisa menghapus JUDUL HALAMAN UTAMA yang sebelumnya ada jika ini sudah cukup --}}
    {{-- <div class="d-flex justify-content-between align-items-center flex-wrap mb-5">
        <h1 class="text-dark fw-bold fs-2hx mb-0">Kegiatan Lainnya</h1>
    </div> --}}


    <div class="row col-12 mt-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap py-5">
                {{-- Teks "Daftar Table Kegiatan Lainnya - 2025" --}}
                <h3 class="card-title fw-bold fs-4 mb-0">Daftar Table Kegiatan Lainnya - 2025</h3>
                {{-- Grouping tombol di kanan atas tabel --}}

                <div class="d-flex align-items-center gap-2 flex-wrap ms-auto"> {{-- ms-auto untuk push ke kanan --}}
                    <button type="button" class="btn custom-red-button" data-bs-toggle="modal" data-bs-target="#modal_add_kegiatan_lainnya"
                        style="background-color: #F8285A !important; color: white !important; border-color: #F8285A !important;">
                        <i class="ki-duotone ki-plus fs-2" style="color: white !important;"></i>Tambah Laporan
                    </button>

                    {{-- Tombol Export Data (contoh) --}}
                    <button type="button" class="btn btn-light-primary">
                        <i class="ki-duotone ki-document fs-2"></i>Export Data
                    </button>

                    {{-- Search Input (Dipindah ke sini jika ingin di header card) --}}
                    <div class="input-group" style="width: 250px;">
                        <input type="search" name="search" id="search" class="form-control"
                            placeholder="Cari kegiatan..." value="{{ request('search') }}">
                        <button class="btn btn-outline-secondary" type="button" id="search-button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>

                    {{-- Filter Dropdown --}}
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                            data-bs-toggle="dropdown">
                            <i class="fas fa-filter me-1"></i> Filter
                            <span id="filter-count" class="badge badge-circle badge-danger ms-1 d-none">0</span>
                        </button>
                        <div class="dropdown-menu p-3 shadow" style="min-width: 320px;">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Jenis Kegiatan</label>
                                <select id="filter-jenis-kegiatan" class="form-select">
                                    <option value="">Semua Jenis</option>
                                    @foreach ($kegiatanLainnya->pluck('jenis_kegiatan')->unique()->filter() as $jenis)
                                        <option value="{{ $jenis }}" {{ request('jenis_kegiatan_filter') == $jenis ? 'selected' : '' }}>{{ $jenis }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Rentang Tanggal</label>
                                <input type="date" id="filter-start-date" class="form-control mb-2" value="{{ request('start_date') }}">
                                <input type="date" id="filter-end-date" class="form-control" value="{{ request('end_date') }}">
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
                </div> {{-- End Grouping tombol --}}
            </div> {{-- End card-header --}}

            <div class="card-body">
                {{-- Informasi Kegiatan (h2) ini bisa dihapus jika ingin fokus ke judul utama di atas --}}
                {{-- <h2 class="mb-0">Informasi Kegiatan</h2> --}}

                @if ($kegiatanLainnya->isEmpty())
                    <div class="text-center text-muted py-10">
                        <i class="ki-duotone ki-information-5 fs-3x mb-3"></i>
                        <h4>Tidak ada data kegiatan lainnya.</h4>
                    </div>
                @else
                    {{-- Table --}}
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle" id="kt_datatable_dom_positioning_kegiatan">
                            <thead class="bg-light">
                                <tr>
                                    <th>No</th>
                                    <th><a href="{{ sortUrl('nama_program_kegiatan') }}" class="text-dark text-decoration-none">Nama Program & Kegiatan {!! sortIcon('nama_program_kegiatan') !!}</a></th>
                                    <th><a href="{{ sortUrl('volume') }}" class="text-dark text-decoration-none">Volume {!! sortIcon('volume') !!}</a></th>
                                    <th><a href="{{ sortUrl('jumlah_harga_satuan') }}" class="text-dark text-decoration-none">Jumlah Harga Satuan {!! sortIcon('jumlah_harga_satuan') !!}</a></th>
                                    <th><a href="{{ sortUrl('jumlah_harga') }}" class="text-dark text-decoration-none">Jumlah Harga {!! sortIcon('jumlah_harga') !!}</a></th>
                                    <th>Foto Jurnal</th>
                                    <th>Dokumen</th>
                                    {{-- Jika ingin menambahkan kolom Tanggal Kegiatan terpisah: --}}
                                    {{-- <th><a href="{{ sortUrl('tanggal_kegiatan') }}" class="text-dark text-decoration-none">Tanggal Kegiatan {!! sortIcon('tanggal_kegiatan') !!}</a></th> --}}
                                    <th><a href="{{ sortUrl('created_at') }}" class="text-dark text-decoration-none">Ditambahkan {!! sortIcon('created_at') !!}</a></th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($kegiatanLainnya as $index => $kegiatan)
                                    <tr
                                        data-jenis-kegiatan="{{ $kegiatan->jenis_kegiatan ?? '' }}"
                                        data-tanggal="{{ \Carbon\Carbon::parse($kegiatan->tanggal_kegiatan ?? $kegiatan->created_at)->format('Y-m-d') }}">
                                        <td class="text-center">{{ ($kegiatanLainnya->currentPage() - 1) * $kegiatanLainnya->perPage() + $index + 1 }}</td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <strong class="text-truncate-custom" title="{{ $kegiatan->nama_program_kegiatan }}">
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
                                                <a href="{{ asset('storage/' . $kegiatan->foto_jurnal) }}" target="_blank" class="btn btn-sm btn-light-info">Lihat Foto</a>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($kegiatan->dokumen_pendukung)
                                                <a href="{{ asset('storage/' . $kegiatan->dokumen_pendukung) }}" target="_blank" class="btn btn-sm btn-light-primary">Lihat Dokumen</a>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        {{-- Jika ada kolom Tanggal Kegiatan terpisah, tambahkan di sini --}}
                                        {{-- <td>{{ \Carbon\Carbon::parse($kegiatan->tanggal_kegiatan)->format('d M Y') }}</td> --}}
                                        <td>{{ \Carbon\Carbon::parse($kegiatan->created_at)->format('d M Y') }}</td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-1">
                                                {{-- KOREKSI: Hapus 'laporan-pj.' dari sini --}}
                                                <a href="{{ route('admin.kegiatan-lainnya.show', $kegiatan->id) }}"
                                                    class="btn btn-icon btn-sm btn-light-primary" title="Detail">
                                                    <i class="fa-solid fa-eye"></i>
                                                </a>

                                                {{-- KOREKSI: Hapus 'laporan-pj.' dari sini --}}
                                                <a href="{{ route('admin.kegiatan-lainnya.edit', $kegiatan->id) }}"
                                                    class="btn btn-icon btn-sm btn-light-warning" title="Edit">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </a>

                                                {{-- KOREKSI: Hapus 'laporan-pj.' dari sini --}}
                                                <form action="{{ route('admin.kegiatan-lainnya.destroy', $kegiatan->id) }}"
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
                                        <td colspan="9" class="text-center py-5 text-muted">Data tidak ditemukan</td>
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
                                <span class="me-2">Page {{ $kegiatanLainnya->currentPage() }} of {{ $kegiatanLainnya->lastPage() }}</span>
                            </div>

                            <div class="pagination-wrapper">
                                {{ $kegiatanLainnya->appends(request()->query())->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>

                    {{-- Info Text --}}
                    <div class="text-muted mt-2 text-center">
                        Showing {{ $kegiatanLainnya->firstItem() }} to {{ $kegiatanLainnya->lastItem() }} of {{ $kegiatanLainnya->total() }} results
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_add_kegiatan_lainnya" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="fw-bold">Tambah Kegiatan Lainnya</h2>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <i class="fa-solid fa-times fs-1"></i>
                    </div>
                </div>
                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                    <form id="kt_modal_add_kegiatan_form" class="form" action="{{ route('admin.kegiatan-lainnya.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="fv-row mb-7">
                            <label class="required fw-semibold fs-6 mb-2">Nama Program & Kegiatan</label>
                            <input type="text" name="nama_program_kegiatan" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Masukkan nama program dan kegiatan" required/>
                        </div>
                        <div class="fv-row mb-7">
                            <label class="required fw-semibold fs-6 mb-2">Jenis Kegiatan</label>
                            <input type="text" name="jenis_kegiatan" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Contoh: Rapat, Pelatihan, Pembelian" required/>
                        </div>
                           <div class="fv-row mb-7">
                            <label class="required fw-semibold fs-6 mb-2">Tanggal Kegiatan</label>
                            <input type="date" name="tanggal_kegiatan" class="form-control form-control-solid mb-3 mb-lg-0" required/>
                        </div>
                        <div class="fv-row mb-7">
                            <label class="required fw-semibold fs-6 mb-2">Volume</label>
                            <input type="text" name="volume" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Masukkan volume kegiatan (contoh: 20 unit, 1 kegiatan)" required/>
                        </div>
                        <div class="fv-row mb-7">
                            <label class="required fw-semibold fs-6 mb-2">Jumlah Harga Satuan</label>
                            <input type="number" name="jumlah_harga_satuan" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Masukkan jumlah harga satuan" required/>
                        </div>
                        <div class="fv-row mb-7">
                            <label class="required fw-semibold fs-6 mb-2">Jumlah Harga</label>
                            <input type="number" name="jumlah_harga" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Masukkan jumlah harga" required/>
                        </div>
                        <div class="fv-row mb-7">
                            <label class="fw-semibold fs-6 mb-2">Foto Jurnal</label>
                            <input type="file" name="foto_jurnal" class="form-control form-control-solid mb-3 mb-lg-0" accept="image/*"/>
                        </div>
                        <div class="fv-row mb-7">
                            <label class="fw-semibold fs-6 mb-2">Dokumen Pendukung</label>
                            <input type="file" name="dokumen_pendukung" class="form-control form-control-solid mb-3 mb-lg-0" accept=".pdf,.doc,.docx,.xls,.xlsx"/>
                        </div>
                        <div class="text-center pt-15">
                            <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">
                                <span class="indicator-label">Simpan</span>
                                <span class="indicator-progress">Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
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
                // Initialize DataTable ONLY for search and filter functionality
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
                            targets: 0 // No
                        },
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
                    currentUrl.searchParams.set('page', 1); // Reset to first page on most changes
                    window.location.href = currentUrl.toString();
                }

                // Handle per page selection
                $('#per-page-select').on('change', function() {
                    updateUrlAndRedirect({ 'per_page': $(this).val() });
                });

                // Handle search functionality
                $('#search-button').on('click', function() {
                    updateUrlAndRedirect({ 'search': $('#search').val() });
                });

                $('#search').on('keypress', function(e) {
                    if (e.which === 13) { // Enter key
                        $('#search-button').click();
                    }
                });

                // ----- MODIFIKASI UNTUK SERVER-SIDE FILTERING -----
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
                    // KOREKSI: Pastikan ini menggunakan hyphen (-)
                    window.location.href = "{{ route('admin.kegiatan-lainnya.index') }}";
                });

                function updateFilterCount() {
                    const urlParams = new URLSearchParams(window.location.search);
                    let count = 0;
                    if (urlParams.get('jenis_kegiatan_filter')) count++;
                    if (urlParams.get('start_date') || urlParams.get('end_date')) count++;
                    if (urlParams.get('search')) count++; // Jika search juga dianggap filter

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
                background-color: #F8285A; /* Sesuai warna custom-red-button */
                border-color: #F8285A;
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