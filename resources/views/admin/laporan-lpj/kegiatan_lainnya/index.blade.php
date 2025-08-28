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
            width: 100px !important;
        }

        .table-fixed th:nth-child(9),
        .table-fixed td:nth-child(9) {
            width: 80px !important;
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
            background-color: #F8285A !important;
            color: white !important;
            border-bottom: 1px solid #F8285A !important;
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
                        <a href="{{ route('admin.laporan-lpj.kegiatan_lainnya.create') }}" class="btn custom-red-button"
                            style="background-color: #F8285A !important; color: white !important; border-color: #F8285A !important;">
                            <i class="ki-duotone ki-plus fs-2" style="color: white !important;"></i>Tambah Laporan
                        </a>

<form action="{{ route('admin.laporan-lpj.kegiatan_lainnya.export') }}" method="POST" class="d-inline">
    @csrf
    <input type="hidden" name="data" value="{{ json_encode([]) }}">
    <input type="hidden" name="title" value="LPJ_Kegiatan_Lainnya_{{ date('Ymd') }}">
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

                    {{-- Updated Filter Dropdown to match Sekretariat --}}
                    <div class="dropdown" style="z-index: 1055">
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
                                    @foreach ($kegiatanLainnya->pluck('nama_kegiatan')->unique()->filter() as $jenis)
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

            {{-- Card Body - Updated to match Sekretariat --}}
            <div class="card-body position-relative">
                <div class="loading-overlay d-none" id="loading-overlay">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>

                <div id="table-container">
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
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle table-fixed"
                                id="kt_datatable_dom_positioning_kegiatan">
                                {{-- Table Header --}}
                                <thead class="bg-light">
                                    <tr>
                                        @php
                                            $columns = [
                                                ['key' => null, 'title' => 'No', 'sortable' => false],
                                                ['key' => 'nama_program', 'title' => 'Nama Program & Kegiatan'],
                                                ['key' => 'volume', 'title' => 'Volume'],
                                                ['key' => 'jumlah_harga_satuan', 'title' => 'Jumlah Harga Satuan'],
                                                ['key' => 'jumlah_harga', 'title' => 'Jumlah Harga'],
                                                ['key' => null, 'title' => 'Foto Jurnal', 'sortable' => false],
                                                ['key' => null, 'title' => 'Dokumen', 'sortable' => false],
                                                ['key' => 'created_at', 'title' => 'Ditambahkan'],
                                                ['key' => null, 'title' => 'Aksi', 'sortable' => false],
                                            ];
                                        @endphp

                                        @foreach ($columns as $column)
                                            <th class="text-start">
                                                @if (($column['sortable'] ?? true) && $column['key'])
                                                    <a href="{{ request()->fullUrlWithQuery([
                                                        'sort_by' => $column['key'],
                                                        'sort_order' => request('sort_by') === $column['key'] && request('sort_order') === 'asc' ? 'desc' : 'asc',
                                                        'page' => 1,
                                                    ]) }}"
                                                        class="text-dark text-decoration-none sortable-header">
                                                        {{ $column['title'] }}
                                                        @if (request('sort_by') === $column['key'])
                                                            @if (request('sort_order') === 'asc')
                                                                <i class="fas fa-sort-up text-primary ms-1"></i>
                                                            @else
                                                                <i class="fas fa-sort-down text-primary ms-1"></i>
                                                            @endif
                                                        @else
                                                            <i class="fas fa-sort text-muted ms-1"></i>
                                                        @endif
                                                    </a>
                                                @else
                                                    {{ $column['title'] }}
                                                @endif
                                            </th>
                                        @endforeach
                                    </tr>
                                </thead>

                                {{-- Table Body --}}
                                <tbody>
                                    @forelse ($kegiatanLainnya as $index => $kegiatan)
                                        <tr data-jenis-kegiatan="{{ $kegiatan->nama_kegiatan ?? '' }}"
                                            data-tanggal="{{ \Carbon\Carbon::parse($kegiatan->tanggal_kegiatan ?? $kegiatan->created_at)->format('Y-m-d') }}">
                                            <td class="text-center">
                                                {{ ($kegiatanLainnya->currentPage() - 1) * $kegiatanLainnya->perPage() + $index + 1 }}
                                            </td>

                                            <td>
                                                <div class="d-flex flex-column">
                                                    <strong class="text-truncate-custom"
                                                        title="{{ $kegiatan->nama_program }}">
                                                        {{ $kegiatan->nama_program }}
                                                    </strong>
                                                    @if ($kegiatan->nama_kegiatan)
                                                        <small class="text-muted">{{ $kegiatan->nama_kegiatan }}</small>
                                                    @endif
                                                </div>
                                            </td>

                                            <td class="text-start">{{ $kegiatan->volume }}</td>

                                            <td class="text-start">Rp
                                                {{ number_format($kegiatan->jumlah_harga_satuan, 0, ',', '.') }}</td>

                                            <td class="text-start">Rp
                                                {{ number_format($kegiatan->jumlah_harga, 0, ',', '.') }}</td>

                                            <td class="text-start">
                                                @if (!empty($kegiatan->foto_jurnal) && is_array($kegiatan->foto_jurnal))
                                                    <button type="button" class="btn btn-sm btn-light-info preview-btn"
                                                        data-bs-toggle="modal" data-bs-target="#previewModal"
                                                        data-type="image"
                                                        data-files="{{ json_encode($kegiatan->foto_jurnal) }}"
                                                        data-title="Foto Jurnal - {{ $kegiatan->nama_program }}">
                                                        <i
                                                            class="fas fa-images me-1"></i>{{ count($kegiatan->foto_jurnal) }}
                                                        Foto
                                                    </button>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>

                                            <td class="text-start">
                                                @if (!empty($kegiatan->dokumen_lpj) && is_array($kegiatan->dokumen_lpj))
                                                    <button type="button"
                                                        class="btn btn-sm btn-light-primary preview-btn"
                                                        data-bs-toggle="modal" data-bs-target="#previewModal"
                                                        data-type="document"
                                                        data-files="{{ json_encode($kegiatan->dokumen_lpj) }}"
                                                        data-title="Dokumen LPJ - {{ $kegiatan->nama_program }}">
                                                        <i
                                                            class="fas fa-file-alt me-1"></i>{{ count($kegiatan->dokumen_lpj) }}
                                                        Dokumen
                                                    </button>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>

                                            <td class="text-start">
                                                {{ \Carbon\Carbon::parse($kegiatan->created_at)->format('d M Y') }}
                                            </td>

                                            <td class="text-center">
                                                <div class="dropdown dropdown-action" data-row-id="{{ $kegiatan->id }}">
                                                    <button class="btn btn-sm p-0 dropdown-toggle-custom" type="button">
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
                                                                    <rect width="18" height="18" fill="white"
                                                                        transform="translate(7 7)" />
                                                                </clipPath>
                                                            </defs>
                                                        </svg>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-custom">
                                                        <li>
                                                            <a href="javascript:void(0)" class="dropdown-item-custom"
                                                                onclick="showDetailModal({{ json_encode($kegiatan) }})">
                                                                <i class="fas fa-eye me-2"></i> Lihat Detail
                                                            </a>
                                                        </li>

                                                        @if (auth()->user()->hasRole('superadmin'))
                                                            <li><a href="{{ route('admin.laporan-lpj.kegiatan_lainnya.edit', $kegiatan->id) }}"
                                                                    class="dropdown-item-custom edit">
                                                                    <i class="fas fa-edit me-2"></i> Modifikasi</a></li>
                                                        @else
                                                            <li><span class="dropdown-item-custom restricted-action"
                                                                    data-bs-toggle="tooltip" data-bs-placement="left"
                                                                    data-bs-custom-class="custom-tooltip"
                                                                    data-bs-html="true"
                                                                    title="<div class='tooltip-content'><strong>Informasi</strong><br>Ajukan approval untuk<br>modifikasi laporan</div>"
                                                                    style="cursor: not-allowed; opacity: 0.6;">
                                                                    <i class="fas fa-edit me-2"></i> Modifikasi</span></li>
                                                        @endif

                                                        @if (auth()->user()->hasRole('superadmin'))
                                                            <li><button type="button"
                                                                    class="dropdown-item-custom delete border-0 bg-transparent w-100 text-start text-danger"
                                                                    data-route="{{ route('admin.laporan-lpj.kegiatan_lainnya.destroy', $kegiatan->id) }}"
                                                                    onclick="destroyItem(this)">
                                                                    <i class="fas fa-trash me-2"></i> Hapus</button></li>
                                                        @else
                                                            <li><span class="dropdown-item-custom restricted-action"
                                                                    data-bs-toggle="tooltip" data-bs-placement="left"
                                                                    data-bs-custom-class="custom-tooltip"
                                                                    data-bs-html="true"
                                                                    title="<div class='tooltip-content'><strong>Informasi</strong><br>Ajukan approval untuk<br>modifikasi laporan</div>"
                                                                    style="cursor: not-allowed; opacity: 0.6;">
                                                                    <i class="fas fa-trash me-2"></i> Hapus</span></li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center py-5 text-muted">Data tidak ditemukan
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{-- Custom Pagination Controls --}}
                        <div class="table-footer">
                            <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap">
                                <div class="mb-2 mb-md-0">
                                    <div class="d-flex align-items-center">
                                        <span class="me-2">Show</span>
                                        <select name="per_page" class="form-select form-select-sm w-auto"
                                            id="per-page-select">
                                            @foreach ([10, 25, 50, 100] as $limit)
                                                <option value="{{ $limit }}"
                                                    {{ request('per_page', 10) == $limit ? 'selected' : '' }}>
                                                    {{ $limit }}</option>
                                            @endforeach
                                        </select>
                                        <span class="ms-2">per page</span>
                                    </div>
                                </div>

                                @if (isset($kegiatanLainnya) && method_exists($kegiatanLainnya, 'hasPages') && $kegiatanLainnya->hasPages())
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="text-muted small">
                                            {{ $kegiatanLainnya->firstItem() }}-{{ $kegiatanLainnya->lastItem() }} of
                                            {{ $kegiatanLainnya->total() }}</div>

                                        <div class="d-flex align-items-center gap-2">
                                            @if ($kegiatanLainnya->onFirstPage())
                                                <span class="pagination-arrow disabled">←</span>
                                            @else
                                                <a href="{{ $kegiatanLainnya->appends(request()->query())->previousPageUrl() }}"
                                                    class="pagination-arrow pagination-link" aria-label="Previous">←</a>
                                            @endif

                                            @php
                                                $current = $kegiatanLainnya->currentPage();
                                                $total = $kegiatanLainnya->lastPage();
                                                $start = max(1, $current - 2);
                                                $end = min($total, $current + 2);
                                                if ($end - $start < 4) {
                                                    if ($start == 1) {
                                                        $end = min($total, $start + 4);
                                                    } else {
                                                        $start = max(1, $end - 4);
                                                    }
                                                }
                                            @endphp

                                            <div class="d-flex align-items-center">
                                                @for ($i = $start; $i <= $end; $i++)
                                                    @if ($i == $current)
                                                        <span class="pagination-number active">{{ $i }}</span>
                                                    @else
                                                        <a href="{{ $kegiatanLainnya->appends(request()->query())->url($i) }}"
                                                            class="pagination-number pagination-link">{{ $i }}</a>
                                                    @endif
                                                @endfor
                                            </div>

                                            @if ($kegiatanLainnya->hasMorePages())
                                                <a href="{{ $kegiatanLainnya->appends(request()->query())->nextPageUrl() }}"
                                                    class="pagination-arrow pagination-link" aria-label="Next">→</a>
                                            @else
                                                <span class="pagination-arrow disabled">→</span>
                                            @endif
                                        </div>
                                    </div>
                                @elseif(isset($kegiatanLainnya) && method_exists($kegiatanLainnya, 'hasPages'))
                                    <div class="text-muted small">1-{{ $kegiatanLainnya->count() }} of
                                        {{ $kegiatanLainnya->total() }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Updated Preview Modal to match Sekretariat --}}
    <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header" style="background: #F8285A; color: white;">
                    <h5 class="modal-title text-white" id="previewModalLabel">Preview Files</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
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
            let currentIndex = 0;
            let currentType = '';

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
                // Remove existing event listeners
                $(document).off('click', '.dropdown-toggle-custom');
                $(document).off('mouseenter', '.dropdown-action');
                $(document).off('mouseleave', '.dropdown-action');

                // Click event for dropdown toggle
                $(document).on('click', '.dropdown-toggle-custom', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    const $dropdownAction = $(this).closest('.dropdown-action');
                    const $menu = $dropdownAction.find('.dropdown-menu-custom');

                    // Hide other dropdowns
                    $('.dropdown-menu-custom').not($menu).removeClass('show');

                    // Toggle current dropdown
                    $menu.toggleClass('show');

                    // Check position
                    checkDropdownPosition($dropdownAction);
                });

                function checkDropdownPosition($dropdownAction) {
                    const $menu = $dropdownAction.find('.dropdown-menu-custom');
                    if (!$menu.hasClass('show')) return;

                    // Reset dropup class
                    $dropdownAction.removeClass('dropup');

                    const $row = $dropdownAction.closest('tr');
                    const $table = $row.closest('tbody');
                    const rowIndex = $table.find('tr').index($row);
                    const totalRows = $table.find('tr').length;

                    // If it's the last row, show dropdown upward
                    if (rowIndex === totalRows - 1) {
                        $dropdownAction.addClass('dropup');
                    }
                }

                // Click outside to close dropdowns
                $(document).on('click', function(e) {
                    if (!$(e.target).closest('.dropdown-action').length) {
                        $('.dropdown-menu-custom').removeClass('show');
                    }
                });

                // Responsive dropdown positioning
                $(window).on('resize', function() {
                    $('.dropdown-action').each(function() {
                        if ($(this).find('.dropdown-menu-custom').hasClass('show')) {
                            checkDropdownPosition($(this));
                        }
                    });
                });

                // Desktop hover events
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

            // Search functions
            function performSearch(searchValue, immediate = false) {
                if (searchTimeout) {
                    clearTimeout(searchTimeout);
                }

                if (immediate || searchValue === '') {
                    doSearch(searchValue);
                } else {
                    searchTimeout = setTimeout(() => {
                        doSearch(searchValue);
                    }, 300);
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

                    $.ajax({
                        url: currentUrl.toString(),
                        type: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        success: function(response) {
                            // Update table container with new data
                            $('.card-body').html(response);
                            hideLoading();

                            // Update browser URL
                            window.history.pushState(null, null, currentUrl.toString());

                            // Reinitialize components
                            initializeDataTable();
                            initializeTooltips();
                            initializeDropdownEvents();
                            updateFilterCount();

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
                const urlParams = new URLSearchParams(window.location.search);
                let count = 0;

                if (urlParams.get('jenis_kegiatan_filter')) count++;
                if (urlParams.get('start_date') || urlParams.get('end_date')) count++;

                const badge = $('#filter-count');
                if (count > 0) {
                    badge.text(count).removeClass('d-none');
                } else {
                    badge.addClass('d-none');
                }
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

                    const fileName = file.split('/').pop();
                    const fileExtension = fileName.split('.').pop().toLowerCase();
                    const imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'];

                    if (currentType === 'image' || currentType === 'foto' ||
                        (currentType === 'auto' && imageExtensions.includes(fileExtension))) {
                        slide.innerHTML = `
                    <img src="/storage/${file}"
                         alt="Preview"
                         class="preview-image"
                         onerror="this.style.display='none'; this.parentElement.innerHTML='<div class=\\'document-placeholder\\'><i class=\\'fas fa-exclamation-triangle text-warning\\' style=\\'font-size: 3rem;\\'></i><h5>Gagal memuat gambar</h5></div>'">
                `;
                    } else {
                        if (fileExtension === 'pdf') {
                            slide.innerHTML = `
                        <iframe src="/storage/${file}"
                                class="preview-document"
                                onerror="console.error('Failed to load PDF: /storage/${file}')"></iframe>
                    `;
                        } else {
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
                        }
                    }

                    previewSlides.appendChild(slide);
                });

                updatePreviewUI();
            }

            function updatePreviewUI() {
                if (!currentFiles || currentFiles.length === 0) return;

                const fileName = currentFiles[currentIndex].split('/').pop();
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
                            type: 'DELETE',
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: response.message ||
                                        'Data kegiatan berhasil dihapus',
                                    icon: 'success',
                                    timer: 2000,
                                    showConfirmButton: false
                                });

                                // Reload page to reflect changes
                                setTimeout(() => {
                                    window.location.reload();
                                }, 2000);
                            },
                            error: function(xhr) {
                                Swal.close();

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
                                    } else {
                                        Swal.fire({
                                            title: 'Error!',
                                            text: response.message ||
                                                'Gagal menghapus data kegiatan',
                                            icon: 'error'
                                        });
                                    }
                                } catch (e) {
                                    Swal.fire({
                                        title: 'Error!',
                                        text: 'Gagal menghapus data kegiatan',
                                        icon: 'error'
                                    });
                                }
                            }
                        });
                    } else {
                        Swal.fire({
                            title: "Aksi Dibatalkan :)",
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
                form.action = '{{ route('admin.laporan-lpj.kegiatan_lainnya.export') }}';
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

            // Update showDetailModal function to include export button handler
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

            window.showPreviewModal = function(files, type, title) {
                if (!files || !Array.isArray(files) || files.length === 0) {
                    console.error('Invalid files data for preview');
                    return;
                }

                currentFiles = files;
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
            updateFilterCount();
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

            $('#search').on('focus', function() {
                $(this).select();
            });

            // Filter functionality
            $('#apply-filters').on('click', function() {
                const jenisKegiatan = $('#filter-jenis-kegiatan').val();
                const startDate = $('#filter-start-date').val();
                const endDate = $('#filter-end-date').val();

                updateTable({
                    'jenis_kegiatan_filter': jenisKegiatan,
                    'start_date': startDate,
                    'end_date': endDate,
                    'page': 1
                });
            });

            $('#reset-filters').on('click', function() {
                $('#filter-jenis-kegiatan').val('');
                $('#filter-start-date').val('');
                $('#filter-end-date').val('');
                $('#search').val('');
                toggleClearButton();

                updateTable({
                    'search': '',
                    'jenis_kegiatan_filter': '',
                    'start_date': '',
                    'end_date': '',
                    'page': 1
                });
            });

            // Per page selector
            $('#per-page-select').on('change', function() {
                const perPage = $(this).val();
                updateTable({
                    'per_page': perPage,
                    'page': 1
                });
            });

            // Preview modal events
            $(document).on('click', '.preview-btn', function(e) {
                e.preventDefault();
                const btn = $(this);

                try {
                    const filesData = btn.attr('data-files');
                    const type = btn.attr('data-type') || 'auto';
                    const title = btn.attr('data-title') || 'Preview Files';

                    if (filesData) {
                        const files = JSON.parse(filesData);
                        // Filter out null/empty files
                        const validFiles = files.filter(f => f && f.length > 0);
                        if (validFiles.length > 0) {
                            showPreviewModal(validFiles, type, title);
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

            // Preview navigation
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');

            if (prevBtn) {
                prevBtn.addEventListener('click', function() {
                    const newIndex = currentIndex > 0 ? currentIndex - 1 : currentFiles.length - 1;
                    showSlide(newIndex);
                });
            }

            if (nextBtn) {
                nextBtn.addEventListener('click', function() {
                    const newIndex = currentIndex < currentFiles.length - 1 ? currentIndex + 1 : 0;
                    showSlide(newIndex);
                });
            }

            // Keyboard navigation for preview modal
            document.addEventListener('keydown', function(e) {
                const previewModal = document.getElementById('previewModal');
                if (previewModal && previewModal.classList.contains('show')) {
                    if (e.key === 'ArrowLeft' && prevBtn) {
                        prevBtn.click();
                    } else if (e.key === 'ArrowRight' && nextBtn) {
                        nextBtn.click();
                    } else if (e.key === 'Escape') {
                        $('#previewModal').modal('hide');
                    }
                }
            });

            // Initialize preview modal when shown
            $('#previewModal').on('show.bs.modal', function() {
                if (currentFiles && currentFiles.length > 0) {
                    showSlide(0);
                }
            });
        });
    </script>
@endsection
