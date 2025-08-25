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
        /* CSS yang sudah ada */
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

        /* PERBAIKAN: CSS untuk memastikan header dan body tabel tetap sejajar */
        .table-fixed {
            table-layout: fixed;
        }

        .table-fixed thead th,
        .table-fixed tbody td {
            width: auto !important;
            min-width: 0 !important;
            box-sizing: border-box;
        }

        .table-fixed th:nth-child(1),
        .table-fixed td:nth-child(1) {
            width: 40px !important;
        }

        .table-fixed th:nth-child(2),
        .table-fixed td:nth-child(2) {
            width: 250px !important;
        }

        .table-fixed th:nth-child(3),
        .table-fixed td:nth-child(3) {
            width: 100px !important;
        }

        .table-fixed th:nth-child(4),
        .table-fixed td:nth-child(4) {
            width: 150px !important;
        }

        .table-fixed th:nth-child(5),
        .table-fixed td:nth-child(5) {
            width: 150px !important;
        }

        .table-fixed th:nth-child(6),
        .table-fixed td:nth-child(6) {
            width: 100px !important;
        }

        .table-fixed th:nth-child(7),
        .table-fixed td:nth-child(7) {
            width: 120px !important;
        }

        .table-fixed th:nth-child(8),
        .table-fixed td:nth-child(8) {
            width: 80px !important;
        }

        .table-fixed th:nth-child(9),
        .table-fixed td:nth-child(9) {
            width: 100px !important;
        }

        /* Memastikan konten tabel tidak melebihi lebar kolom */
        .table-fixed td>div {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* Memastikan header dan body memiliki lebar yang sama */
        .table-container {
            position: relative;
        }

        .table-header-fixed {
            position: sticky;
            top: 0;
            z-index: 10;
            background-color: #f8f9fa;
        }

        /* Untuk DataTables - memastikan header dan body sejajar */
        .dataTables_wrapper .table thead th,
        .dataTables_wrapper .table tbody td {
            box-sizing: border-box;
        }

        .dataTables_scrollHead .dataTables_scrollHeadInner {
            width: 100% !important;
        }

        .dataTables_scrollHead .dataTables_scrollHeadInner table {
            width: 100% !important;
        }

        .dataTables_scrollBody table {
            width: 100% !important;
        }
    </style>
    </head>

    <body>
        <div class="container-fluid py-4">
            {{-- Page Header --}}
            <div class="d-flex flex-column mb-4">
                <h1 class="text-dark fw-bold mb-1">Kegiatan Lainnya</h1>
                <div class="text-muted fw-semibold fs-6">Jelajahi Kegiatan Lainnya Yang Terdaftar</div>
            </div>

            {{-- Main Content Card --}}
            <div class="card">
                {{-- Card Header --}}
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap py-4">
                    <h3 class="card-title fw-bold fs-4 mb-0">Daftar Table Kegiatan Lainnya - 2025</h3>

                    @if (request('jenis_kegiatan_filter'))
                        <div class="card-header border-0 pt-3 pb-3 bg-light">
                            <div class="card-title">
                                <div class="d-flex align-items-center position-relative my-1">
                                    <i class="fas fa-filter fs-5 position-absolute ms-4 text-primary"></i>
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
                            <i class="fas fa-plus me-2" style="color: white !important;"></i>Tambah Laporan
                        </a>

                        {{-- Export Button --}}
                        <a href="{{ route('admin.laporan-lpj.kegiatan_lainnya.export', request()->query()) }}"
                            class="btn btn-light-primary" target="_blank">
                            <i class="fas fa-file-export me-2"></i>Export Data
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
                            <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                data-bs-toggle="dropdown">
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
                                        <i class="fas fa-check me-1"></i>Terapkan
                                    </button>
                                    <button type="button" id="reset-filters" class="btn btn-light btn-sm flex-fill">
                                        <i class="fas fa-sync-alt me-1"></i>Reset
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
                                <i class="fas fa-search fs-1 mb-3 text-muted"></i>
                                <h4>Data tidak ditemukan untuk pencarian "{{ request('search') }}"</h4>
                            </div>
                        @elseif(request('jenis_kegiatan_filter'))
                            {{-- Empty State untuk Filter Tidak Ditemukan --}}
                            <div class="text-center text-muted py-10">
                                <i class="fas fa-filter fs-1 mb-3 text-muted"></i>
                                <h4>Data tidak ditemukan untuk jenis kegiatan "{{ request('jenis_kegiatan_filter') }}"</h4>
                                <button class="btn btn-light-primary mt-3"
                                    onclick="window.location.href='{{ route('admin.laporan-lpj.kegiatan_lainnya.index') }}'">
                                    Reset Filter
                                </button>
                            </div>
                        @else
                            {{-- Empty State untuk Data Kosong --}}
                            <div class="text-center text-muted py-10">
                                <i class="fas fa-info-circle fs-1 mb-3 text-muted"></i>
                                <h4>Data tidak tersedia</h4>
                            </div>
                        @endif
                    @else
                        {{-- Data Table --}}
                        <div class="table-container">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover align-middle table-fixed"
                                    id="kt_datatable_dom_positioning_kegiatan">
                                    {{-- Table Header --}}
                                    <thead class="bg-light">
                                        <tr>
                                            <th>No</th>
                                            <th>
                                                <a href="{{ request()->fullUrlWithQuery([
                                                    'sort_by' => 'nama_program_kegiatan',
                                                    'sort_order' => request('sort_by') === 'nama_program_kegiatan' && request('sort_order') === 'asc' ? 'desc' : 'asc',
                                                    'page' => 1,
                                                ]) }}"
                                                    class="text-dark text-decoration-none">
                                                    Nama Program & Kegiatan
                                                    @if (request('sort_by') === 'nama_program_kegiatan')
                                                        @if (request('sort_order') === 'asc')
                                                            <i class="fas fa-sort-up text-primary ms-1"></i>
                                                        @else
                                                            <i class="fas fa-sort-down text-primary ms-1"></i>
                                                        @endif
                                                    @else
                                                        <i class="fas fa-sort text-muted ms-1"></i>
                                                    @endif
                                                </a>
                                            </th>
                                            <th>
                                                <a href="{{ request()->fullUrlWithQuery([
                                                    'sort_by' => 'volume',
                                                    'sort_order' => request('sort_by') === 'volume' && request('sort_order') === 'asc' ? 'desc' : 'asc',
                                                    'page' => 1,
                                                ]) }}"
                                                    class="text-dark text-decoration-none">
                                                    Volume
                                                    @if (request('sort_by') === 'volume')
                                                        @if (request('sort_order') === 'asc')
                                                            <i class="fas fa-sort-up text-primary ms-1"></i>
                                                        @else
                                                            <i class="fas fa-sort-down text-primary ms-1"></i>
                                                        @endif
                                                    @else
                                                        <i class="fas fa-sort text-muted ms-1"></i>
                                                    @endif
                                                </a>
                                            </th>
                                            <th>
                                                <a href="{{ request()->fullUrlWithQuery([
                                                    'sort_by' => 'jumlah_harga_satuan',
                                                    'sort_order' => request('sort_by') === 'jumlah_harga_satuan' && request('sort_order') === 'asc' ? 'desc' : 'asc',
                                                    'page' => 1,
                                                ]) }}"
                                                    class="text-dark text-decoration-none">
                                                    Jumlah Harga Satuan
                                                    @if (request('sort_by') === 'jumlah_harga_satuan')
                                                        @if (request('sort_order') === 'asc')
                                                            <i class="fas fa-sort-up text-primary ms-1"></i>
                                                        @else
                                                            <i class="fas fa-sort-down text-primary ms-1"></i>
                                                        @endif
                                                    @else
                                                        <i class="fas fa-sort text-muted ms-1"></i>
                                                    @endif
                                                </a>
                                            </th>
                                            <th>
                                                <a href="{{ request()->fullUrlWithQuery([
                                                    'sort_by' => 'jumlah_harga',
                                                    'sort_order' => request('sort_by') === 'jumlah_harga' && request('sort_order') === 'asc' ? 'desc' : 'asc',
                                                    'page' => 1,
                                                ]) }}"
                                                    class="text-dark text-decoration-none">
                                                    Jumlah Harga
                                                    @if (request('sort_by') === 'jumlah_harga')
                                                        @if (request('sort_order') === 'asc')
                                                            <i class="fas fa-sort-up text-primary ms-1"></i>
                                                        @else
                                                            <i class="fas fa-sort-down text-primary ms-1"></i>
                                                        @endif
                                                    @else
                                                        <i class="fas fa-sort text-muted ms-1"></i>
                                                    @endif
                                                </a>
                                            </th>
                                            <th>Foto Jurnal</th>
                                            <th>Dokumen</th>
                                            <th>
                                                <a href="{{ request()->fullUrlWithQuery([
                                                    'sort_by' => 'created_at',
                                                    'sort_order' => request('sort_by') === 'created_at' && request('sort_order') === 'asc' ? 'desc' : 'asc',
                                                    'page' => 1,
                                                ]) }}"
                                                    class="text-dark text-decoration-none">
                                                    Ditambahkan
                                                    @if (request('sort_by') === 'created_at')
                                                        @if (request('sort_order') === 'asc')
                                                            <i class="fas fa-sort-up text-primary ms-1"></i>
                                                        @else
                                                            <i class="fas fa-sort-down text-primary ms-1"></i>
                                                        @endif
                                                    @else
                                                        <i class="fas fa-sort text-muted ms-1"></i>
                                                    @endif
                                                </a>
                                            </th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>


                                    {{-- Table Body --}}
                                    <tbody>
                                        @forelse ($kegiatanLainnya as $index => $kegiatan)
                                            @php
                                                $isApproved = $kegiatan->status_approval === 'approved';
                                            @endphp
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
                                                        <small
                                                            class="text-muted">{{ $kegiatan->jenis_kegiatan ?? '-' }}</small>
                                                    </div>
                                                </td>
                                                <td>{{ $kegiatan->volume }}</td>
                                                <td>Rp {{ number_format($kegiatan->jumlah_harga_satuan, 0, ',', '.') }}
                                                </td>
                                                <td>Rp {{ number_format($kegiatan->jumlah_harga, 0, ',', '.') }}</td>
                                                <td>
                                                    @if ($kegiatan->foto_jurnal)
                                                        <a href="{{ asset('storage/' . $kegiatan->foto_jurnal) }}"
                                                            target="_blank" class="btn btn-sm btn-light-info">Lihat
                                                            Foto</a>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($kegiatan->dokumen_pendukung)
                                                        <a href="{{ asset('storage/' . $kegiatan->dokumen_pendukung) }}"
                                                            target="_blank" class="btn btn-sm btn-light-primary">Lihat
                                                            Dokumen</a>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($kegiatan->created_at)->format('d M Y') }}
                                                </td>
                                                <td class="text-center">
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-light" type="button"
                                                            data-bs-toggle="dropdown">
                                                            <i class="fas fa-ellipsis-v"></i>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                <a class="dropdown-item preview-btn"
                                                                    data-files="{{ json_encode([$kegiatan->foto_jurnal, $kegiatan->dokumen_pendukung]) }}"
                                                                    data-type="{{ $kegiatan->foto_jurnal ? 'image' : 'document' }}"
                                                                    data-title="Preview Laporan Kegiatan">
                                                                    <i class="fas fa-eye me-2"></i>Lihat
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item"
                                                                    href="{{ route('admin.laporan-lpj.kegiatan_lainnya.edit', $kegiatan->id) }}">
                                                                    <i class="fas fa-edit me-2"></i>Edit
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <button class="dropdown-item text-danger"
                                                                    onclick="destroyItem(this)"
                                                                    data-route="{{ route('admin.laporan-lpj.kegiatan_lainnya.destroy', $kegiatan->id) }}">
                                                                    <i class="fas fa-trash me-2"></i>Hapus
                                                                </button>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="9" class="text-center py-5 text-muted">Data tidak
                                                    ditemukan</td>
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
                                            <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10
                                            </option>
                                            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25
                                            </option>
                                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50
                                            </option>
                                            <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100
                                            </option>
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
                                                        <a class="page-link"
                                                            href="{{ $url }}">{{ $page }}</a>
                                                    </li>
                                                @endif
                                            @endforeach

                                            <!-- Next Page Link -->
                                            <li
                                                class="page-item {{ !$kegiatanLainnya->hasMorePages() ? 'disabled' : '' }}">
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

        {{-- Modal Detail Kegiatan (Updated) --}}
        <div class="modal fade" id="modal_detail_kegiatan" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h2 class="fw-bold text-white mb-0">
                            <i class="fas fa-eye me-2"></i>Detail Laporan LPJ
                        </h2>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-sm btn-light" id="export-detail-btn">
                                <i class="fas fa-download me-1"></i>Export
                            </button>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                    </div>
                    <div class="modal-body p-0">
                        <div id="detail-kegiatan-content">
                            <!-- Konten akan diisi via AJAX -->
                            <div class="text-center py-10">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <p class="mt-3 text-muted">Memuat detail kegiatan...</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>Tutup
                        </button>
                    </div>
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
                                    class="form-control form-control-solid mb-3 mb-lg-0"
                                    placeholder="Masukkan jumlah harga" required />
                            </div>

                            {{-- Foto Jurnal --}}
                            <div class="fv-row mb-7">
                                <label class="fw-semibold fs-6 mb-2">Foto Jurnal</label>
                                <input type="file" name="foto_jurnal"
                                    class="form-control form-control-solid mb-3 mb-lg-0" accept="image/*" />
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

                    // ========== SEARCH FUNCTIONALITY - OPTIMIZED ==========
                    let searchTimer;
                    const searchDelay = 800;
                    const emptySearchDelay = 300;


                    // Debounced search object
                    const debouncedSearch = {
                        timer: null,
                        isProcessing: false,

                        execute: function(callback, delay) {
                            clearTimeout(this.timer);
                            showSearchLoading(false); // Reset loading state

                            this.timer = setTimeout(() => {
                                showSearchLoading(true);
                                callback();
                            }, delay);
                        },

                        cancel: function() {
                            clearTimeout(this.timer);
                            showSearchLoading(false);
                        }
                    };

                    // Main search function
                    function performSearch() {
                        const searchValue = $('#search').val().trim();

                        if (searchValue === '') {
                            const currentUrl = new URL(window.location.href);
                            currentUrl.searchParams.delete('search');
                            currentUrl.searchParams.set('page', 1);
                            window.location.href = currentUrl.toString();
                        } else {
                            updateUrlAndRedirect({
                                search: searchValue
                            });
                        }
                    }

                    // Handle search button click
                    $('#search-button').on('click', function(e) {
                        e.preventDefault();
                        clearTimeout(searchTimer);
                        performSearch();
                    });

                    // UNIFIED search input handler dengan debouncing
                    $('#search').on('keyup input paste', function(e) {
                        const searchValue = $(this).val().trim();
                        clearTimeout(searchTimer);

                        updateSearchState();
                        addClearSearchButton();

                        // Handle special keys
                        if (e.type === 'keyup') {
                            if (e.keyCode === 13) {
                                e.preventDefault();
                                performSearch();
                                return;
                            }
                            if (e.keyCode === 27) {
                                e.preventDefault();
                                $(this).val('');
                                performSearch();
                                return;
                            }
                        }

                        const delay = searchValue === '' ? emptySearchDelay : searchDelay;
                        searchTimer = setTimeout(performSearch, delay);
                    });


                    // Handle search input focus
                    $('#search').on('focus', function() {
                        $(this).select(); // Select all text when focused
                    });

                    // Prevent form submission if there's a parent form
                    $('#search').closest('form').on('submit', function(e) {
                        e.preventDefault();
                        performSearch();
                    });

                    // Function to show/hide search loading
                    function showSearchLoading(show) {
                        const $searchButton = $('#search-button');
                        const $searchInput = $('#search');

                        if (show) {
                            $searchButton.html('<i class="fas fa-spinner fa-spin"></i>');
                            $searchInput.addClass('pe-5').prop('disabled', true);
                            $('.clear-search-btn').html('<i class="fas fa-spinner fa-spin"></i>').prop('disabled', true);
                        } else {
                            $searchButton.html('<i class="fas fa-search"></i>');
                            $searchInput.removeClass('pe-5').prop('disabled', false);
                            $('.clear-search-btn').html('<i class="fas fa-times"></i>').prop('disabled', false);
                        }
                    }

                    // Update search visual state
                    function updateSearchState() {
                        const searchValue = $('#search').val().trim();
                        const $searchInput = $('#search');

                        if (searchValue) {
                            $searchInput.addClass('border-primary');
                        } else {
                            $searchInput.removeClass('border-primary');
                        }
                    }

                    // Clear search button functionality
                    function addClearSearchButton() {
                        const searchValue = $('#search').val();
                        const $searchGroup = $('#search').closest('.input-group');

                        if (searchValue && searchValue.length > 0) {
                            if (!$searchGroup.find('.clear-search-btn').length) {
                                const clearBtn = $(`
                                <button class="btn btn-outline-secondary clear-search-btn" type="button" title="Hapus pencarian">
                                    <i class="fas fa-times"></i>
                                </button>
                            `);

                                clearBtn.insertAfter('#search-button');

                                // Clear button action - immediate reset
                                clearBtn.on('click', function() {
                                    $('#search').val('').focus();
                                    debouncedSearch.cancel();
                                    performSearch();
                                });
                            }
                        } else {
                            $searchGroup.find('.clear-search-btn').remove();
                        }
                    }

                    // ========== FILTER FUNCTIONALITY ==========
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

                    // ========== KEYBOARD SHORTCUTS ==========
                    // Global keyboard shortcuts
                    $(document).on('keydown', function(e) {
                        // Ctrl/Cmd + K atau "/" untuk focus search
                        if (((e.ctrlKey || e.metaKey) && e.keyCode === 75) || e.keyCode === 191) {
                            // Pastikan tidak dalam input lain atau modal
                            if (!$(e.target).is('input, textarea, select') && !$('.modal.show').length) {
                                e.preventDefault();
                                $('#search').focus().select();
                            }
                        }
                    });

                    // ========== WINDOW EVENTS ==========
                    // Handle browser back/forward
                    window.addEventListener('popstate', function(event) {
                        debouncedSearch.cancel();
                        showSearchLoading(false);
                        location.reload();
                    });

                    // Re-sync search state when window gets focus
                    $(window).on('focus', function() {
                        const urlParams = new URLSearchParams(window.location.search);
                        const urlSearch = urlParams.get('search') || '';
                        const inputSearch = $('#search').val().trim();

                        if (urlSearch !== inputSearch) {
                            $('#search').val(urlSearch);
                            updateSearchState();
                            addClearSearchButton();
                        }
                    });

                    window.destroyItem = function(button) {
                        const route = button.dataset.route;

                        Swal.fire({
                            title: "Apakah Anda Yakin?",
                            html: "<p style='text-align:center'>Setelah data laporan kegiatan dihapus, Anda tidak bisa mengembalikannya!</p>",
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
                                    type: 'DELETE',
                                    data: {
                                        _token: $('meta[name="csrf-token"]').attr('content')
                                    },
                                    success: function(response) {
                                        Swal.fire({
                                            title: 'Berhasil!',
                                            text: response.message ||
                                                'Data laporan kegiatan berhasil dihapus',
                                            icon: 'success',
                                            timer: 2000,
                                            showConfirmButton: false
                                        });
                                        location.reload(); // atau updateTable({}) jika pakai AJAX
                                    },
                                    error: function(xhr) {
                                        Swal.close();
                                        let msg = 'Gagal menghapus data.';
                                        if (xhr.responseJSON && xhr.responseJSON.message) msg = xhr
                                            .responseJSON.message;
                                        Swal.fire({
                                            title: 'Error!',
                                            text: msg,
                                            icon: 'error'
                                        });
                                    }
                                });
                            }
                        });
                    };

                    // ========== INITIALIZATION ==========
                    // Initialize tooltips
                    $('[data-bs-toggle="tooltip"]').tooltip();

                    // Initialize states
                    updateSearchState();
                    addClearSearchButton();
                    highlightSearchTerm();
                    updateFilterCount();

                    // Auto focus search if there's search parameter in URL
                    const urlParams = new URLSearchParams(window.location.search);
                    if (urlParams.get('search')) {
                        $('#search').focus().select();
                        updateSearchState();
                    }

                    // ========== DELETE FUNCTIONALITY ==========
                    let deleteId = null;
                    let deleteUrl = null;

                    // Handle view detail button click
                    $(document).on('click', '.view-detail-btn', function(e) {
                        e.preventDefault();

                        const kegiatanId = $(this).data('id');
                        const kegiatanName = $(this).data('name') || 'Detail Kegiatan';
                        const modal = $('#modal_detail_kegiatan');

                        console.log('Kegiatan ID:', kegiatanId);

                        if (!kegiatanId) {
                            showDetailError('ID kegiatan tidak ditemukan');
                            return;
                        }

                        $('#detail-kegiatan-content').html(`
                        <div class="text-center py-10">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mt-3 text-muted">Memuat detail kegiatan...</p>
                        </div>
                    `);

                        modal.modal('show');

                        const ajaxUrl = `{{ url('admin/laporan-lpj/kegiatan-lainnya') }}/${kegiatanId}`;

                        $.ajax({
                            url: ajaxUrl,
                            type: 'GET',
                            timeout: 15000,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                if (response.success) {
                                    $('#detail-kegiatan-content').html(response.html);

                                    if (response.data && response.data.export_url) {
                                        $('#export-detail-btn').off('click').on('click', function() {
                                            window.open(response.data.export_url, '_blank');
                                        });
                                    }

                                    initializeModalContent();
                                } else {
                                    showDetailError(response.message || 'Gagal memuat detail kegiatan');
                                }
                            },
                            error: function(xhr, status, error) {
                                let errorMessage = 'Gagal memuat detail kegiatan';

                                if (status === 'timeout') {
                                    errorMessage = 'Koneksi timeout. Silakan coba lagi.';
                                } else if (xhr.status === 404) {
                                    errorMessage =
                                        'Data kegiatan tidak ditemukan atau route tidak tersedia.';
                                } else if (xhr.status === 500) {
                                    errorMessage = 'Terjadi kesalahan server. Silakan coba lagi.';
                                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                                    errorMessage = xhr.responseJSON.message;
                                }

                                showDetailError(errorMessage);
                            }
                        });
                    });

                    // Handle delete button click
                    $(document).on('click', '.delete-btn', function(e) {
                        e.preventDefault();

                        deleteId = $(this).data('id');
                        const itemName = $(this).data('name');
                        deleteUrl = "{{ route('admin.laporan-lpj.kegiatan_lainnya.destroy', '') }}/" + deleteId;

                        $('#delete-item-name').text(itemName);
                        $('#modal_delete_confirmation').modal('show');
                    });

                    // Handle confirm delete
                    $('#confirm-delete-btn').click(function() {
                        if (!deleteId || !deleteUrl) return;

                        const $btn = $(this);
                        const $modal = $('#modal_delete_confirmation');

                        $btn.attr('data-kt-indicator', 'on');
                        $btn.prop('disabled', true);

                        const token = $('meta[name="csrf-token"]').attr('content');

                        $.ajax({
                            url: deleteUrl,
                            type: 'POST',
                            data: {
                                _method: 'DELETE',
                                _token: token
                            },
                            timeout: 10000,
                            success: function(response) {
                                $modal.modal('hide');
                                showSuccessToast('✔️ Data berhasil dihapus.');

                                const $row = $(`tr:has(button[data-id="${deleteId}"])`);
                                $row.fadeOut(500, function() {
                                    $(this).remove();
                                    updateRowNumbers();
                                    checkEmptyTable();
                                });

                                resetDeleteState($btn);
                            },
                            error: function(xhr, status, error) {
                                $modal.modal('hide');

                                let errorMessage = '❌ Gagal menghapus data. Silakan coba lagi.';

                                if (status === 'timeout') {
                                    errorMessage = '❌ Koneksi timeout. Silakan coba lagi.';
                                } else if (xhr.status === 500) {
                                    errorMessage = '❌ Terjadi kesalahan server. Silakan coba lagi.';
                                } else if (xhr.status === 403) {
                                    errorMessage =
                                        '❌ Anda tidak memiliki akses untuk menghapus data ini.';
                                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                                    errorMessage = '❌ ' + xhr.responseJSON.message;
                                }

                                showErrorToast(errorMessage);
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

                    // ========== HELPER FUNCTIONS ==========
                    function showDetailError(message) {
                        $('#detail-kegiatan-content').html(`
                        <div class="text-center py-10">
                            <i class="fas fa-exclamation-triangle text-warning fs-3x mb-4"></i>
                            <h4 class="text-dark mb-3">Oops! Terjadi Kesalahan</h4>
                            <p class="text-muted mb-4">${message}</p>
                            <button type="button" class="btn btn-primary" onclick="location.reload()">
                                <i class="fas fa-refresh me-1"></i>Muat Ulang Halaman
                            </button>
                        </div>
                    `);
                    }

                    function initializeModalContent() {
                        $('[data-bs-toggle="tooltip"]').tooltip();

                        $('#detail-kegiatan-content').find('.image-input-wrapper').on('click', function() {
                            const bgImage = $(this).css('background-image');
                            if (bgImage && bgImage !== 'none') {
                                const imageUrl = bgImage.replace(/^url\(["']?/, '').replace(/["']?\)$/, '');
                                showImageModal(imageUrl);
                            }
                        });

                        $('#detail-kegiatan-content').css('scroll-behavior', 'smooth');
                    }

                    function showImageModal(imageUrl) {
                        const imageModal = $(`
                        <div class="modal fade" id="imageViewModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Foto Jurnal</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body text-center p-0">
                                        <img src="${imageUrl}" class="img-fluid" style="max-height: 70vh;">
                                    </div>
                                    <div class="modal-footer">
                                        <a href="${imageUrl}" target="_blank" class="btn btn-primary">
                                            <i class="fas fa-external-link-alt me-1"></i>Buka di Tab Baru
                                        </a>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `);

                        $('#imageViewModal').remove();
                        $('body').append(imageModal);
                        $('#imageViewModal').modal('show');

                        $('#imageViewModal').on('hidden.bs.modal', function() {
                            $(this).remove();
                        });
                    }

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
                        if (!$('#toast-error').length) {
                            const errorToast = `
                            <div id="toast-error" class="toast align-items-center text-bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
                                <div class="d-flex">
                                    <div class="toast-body">
                                        <i class="fas fa-exclamation-circle me-2"></i>
                                        <span id="toast-error-message">Error occurred.</span>
                                    </div>
                                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                                </div>
                            </div>
                        `;
                            $('.position-fixed.top-0.end-0').append(errorToast);
                        }

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

                    // Modal cleanup handlers
                    $('#modal_detail_kegiatan').on('hidden.bs.modal', function() {
                        $('#detail-kegiatan-content').html(`
                        <div class="text-center py-10">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mt-3 text-muted">Memuat detail kegiatan...</p>
                        </div>
                    `);
                        $('#export-detail-btn').off('click');
                    });

                    $('#modal_detail_kegiatan').on('shown.bs.modal', function() {
                        $(document).on('keydown.detailModal', function(e) {
                            if (e.keyCode === 27) {
                                $('#modal_detail_kegiatan').modal('hide');
                            }
                        });
                    });

                    $('#modal_detail_kegiatan').on('hidden.bs.modal', function() {
                        $(document).off('keydown.detailModal');
                    });

                    console.log('✅ Search auto-reset functionality initialized');
                    console.log('📝 Features enabled:');
                    console.log('   - Auto-reset when search is cleared (300ms delay)');
                    console.log('   - Normal search with 800ms debounce');
                    console.log('   - Keyboard shortcuts: Esc to clear, Ctrl+K to focus');
                    console.log('   - Visual feedback and loading states');
                    console.log('   - Unified input handling (keyup, input, paste)');
                });
            </script>
        @endif
    @endsection
