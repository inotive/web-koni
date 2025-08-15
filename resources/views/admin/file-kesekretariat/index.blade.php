@extends('layouts.app')

@section('pageTitle', 'Manajemen File')
@section('mainSection', 'File Kesekretariat')

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
        .table th:nth-child(1),
        .table td:nth-child(1) {
            width: 20px;
            min-width: 20px;
            text-align: center;
            padding-left: 0.5rem;
            padding-right: 0.5rem;
        }

        .table th:nth-child(2) {
            width: 250px;
        }

        .table th:nth-child(3) {
            width: 200px;
        }

        .table th:nth-child(4) {
            width: 150px;
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

        /* Updated Dropdown Menu Styling - Combined and improved */
        .dropdown-menu {
            z-index: 1055 !important;
            position: absolute !important;
            right: 0 !important;
            left: auto !important;
            top: 100% !important;
            margin-top: 0.125rem !important;
            transform: none !important;
            will-change: transform !important;
        }

        .dropdown {
            position: relative;
            z-index: 1000;
        }

        .dropdown-item {
            padding: 10px 16px;
            font-size: 14px;
            color: #495057;
            display: flex;
            align-items: center;
            text-decoration: none;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
            transition: background-color 0.2s ease;
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
            color: #495057;
        }

        .dropdown-item i {
            width: 16px;
            font-size: 14px;
            margin-right: 8px;
        }

        .cursor-pointer {
            cursor: pointer;
        }

        /* Untuk baris terakhir, gunakan dropup */
        .table tbody tr:nth-last-child(-n+2) .dropdown-menu {
            top: auto !important;
            bottom: 100% !important;
            margin-top: 0 !important;
            margin-bottom: 8px !important;
        }

        /* Loading indicator */
        .search-loading {
            display: none;
            position: absolute;
            right: 40px;
            top: 50%;
            transform: translateY(-50%);
            color: #666;
        }

        .search-container {
            position: relative;
        }

        /* Empty state styling */
        .empty-state {
            padding: 3rem 2rem;
            text-align: center;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 4rem;
            color: #dee2e6;
            margin-bottom: 1rem;
        }

        .empty-state h4 {
            color: #495057;
            margin-bottom: 0.5rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .dropdown-menu {
                right: 0 !important;
                left: auto !important;
            }

            .table-responsive {
                overflow-x: auto !important;
                overflow-y: visible !important;
            }

            .dropdown-menu {
                position: absolute !important;
                right: 0 !important;
                left: auto !important;
                margin-top: 8px !important;
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


        .preview-file:hover {
            background-color: #1570e6 !important;
            /* Sedikit lebih gelap saat hover */
            border-color: #1570e6 !important;
            color: white !important;
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(27, 132, 255, 0.3);
        }

        .file-icon {
            color: #1976d2;
            margin-right: 8px;
        }

        /* Notification styles */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }

        .toast {
            min-width: 300px;
            background-color: white;
            border-left: 4px solid;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .toast.success {
            border-left-color: #28a745;
        }

        .toast.error {
            border-left-color: #dc3545;
        }

        .toast-header {
            background-color: transparent;
            border-bottom: none;
            padding: 12px 16px 8px;
        }

        .toast-body {
            padding: 8px 16px 12px;
            font-size: 14px;
        }

        /* Modal enhancements */
        .modal-content {
            border-radius: 12px;
            border: none;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .modal-header {
            border-bottom: 1px solid #eee;
            padding: 20px 24px;
        }

        .modal-body {
            padding: 24px;
        }

        .modal-footer {
            border-top: 1px solid #eee;
            padding: 16px 24px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        .empty-state-user {
            padding: 3rem;
            text-align: center;
        }

        .empty-state-user i {
            font-size: 5rem;
            color: #e9ecef;
            margin-bottom: 1.5rem;
        }

        .empty-state-user h4 {
            color: #6c757d;
            margin-bottom: 0.5rem;
        }

        .empty-state-user p {
            color: #adb5bd;
        }

        /* Tooltip styling */
        .tooltip-inner {
            font-size: 12px;
            padding: 4px 8px;
        }

        /* Badge for status */
        .badge-active {
            background-color: #d1fae5;
            color: #065f46;
        }

        .badge-inactive {
            background-color: #fee2e2;
            color: #b91c1c;
        }

        /* Button styling fixes */
        .custom-red-button {
            background-color: #F8285A;
            border-color: #F8285A;
            color: white;
        }

        .custom-red-button:hover {
            background-color: #e11e48;
            border-color: #e11e48;
            color: white;
        }

        .table thead th {
            text-align: center;
            vertical-align: middle;
        }

        .table thead th a {
            justify-content: center;
        }

        /* Pagination styling */
        .pagination-wrapper {
            margin-top: 1.5rem;
        }

        .pagination-wrapper .pagination {
            margin-bottom: 0;
        }

        .pagination-wrapper .page-item .page-link {
            min-width: 32px;
            text-align: center;
            color: #6c757d;
            border: 1px solid #dee2e6;
            margin-left: 0;
            border-radius: 4px;
        }

        .pagination-wrapper .page-item.active .page-link {
            background-color: #F8285A;
            border-color: #F8285A;
            color: white;
        }

        .pagination-wrapper .page-item.disabled .page-link {
            color: #adb5bd;
            background-color: #f8f9fa;
            border-color: #dee2e6;
        }

        .pagination-wrapper .page-link:hover {
            color: #495057;
            background-color: #e9ecef;
            border-color: #dee2e6;
        }

        /* Dropdown per page */
        .pagination-wrapper .dropdown-menu {
            min-width: 80px;
        }

        .pagination-wrapper .dropdown-item {
            padding: 0.25rem 1rem;
            text-align: center;
        }

        .file-preview-modal .modal-content {
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .file-preview-modal .modal-body {
            flex: 1;
            padding: 0;
            overflow: hidden;
        }

        .file-preview-container {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa;
        }

        .file-preview-iframe {
            width: 100%;
            height: 100%;
            border: none;
            border-radius: 4px;
        }

        .file-preview-loading {
            text-align: center;
            padding: 50px;
            color: #6c757d;
        }

        .file-preview-loading i {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .file-preview-error {
            text-align: center;
            padding: 50px;
            color: #dc3545;
        }

        .file-preview-error i {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .file-info-badge {
            background-color: #17a2b8;
            color: white;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.8rem;
            margin-left: 10px;
        }

        @media (max-width: 768px) {
            .pagination-wrapper>div {
                width: 100%;
                justify-content: space-between !important;
            }

            .pagination-wrapper .pagination {
                flex-wrap: wrap;
                justify-content: center;
                margin-top: 10px;
            }

            .file-preview-modal .modal-dialog {
                max-width: 95vw;
                width: 95vw;
                height: 85vh;
                margin: 2.5vh auto;
            }

            .table tbody tr:last-child .dropdown-menu {
                top: auto !important;
                bottom: 100% !important;
                margin-top: 0 !important;
                margin-bottom: 0.125rem !important;
            }
        }

        /* Style untuk link file */
        .file-link {
            color: #1B84FF;
            text-decoration: none;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            padding: 4px 8px;
            border-radius: 4px;
        }


        .file-link:hover {
            color: #0d6efd;
            background-color: #f8f9fa;
        }


        .file-link i {
            margin-right: 8px;
        }

        /* Ikon berdasarkan tipe file */
        .file-icon-pdf {
            color: #e74c3c;
            margin-right: 8px;
        }

        .file-icon-doc {
            color: #2c3e50;
            margin-right: 8px;
        }

        .file-icon-xls {
            color: #27ae60;
            margin-right: 8px;
        }

        .file-icon-default {
            color: #7f8c8d;
            margin-right: 8px;
        }

        /* Ukuran kolom */
        .table th:nth-child(1),
        .table td:nth-child(1) {
            width: 50px;
            text-align: center;
        }

        .table th:nth-child(2),
        .table td:nth-child(2) {
            width: 25%;
        }

        .table th:nth-child(3),
        .table td:nth-child(3) {
            width: 30%;
        }

        .table th:nth-child(4),
        .table td:nth-child(4) {
            width: 100px;
            text-align: center;
        }

        .table th:nth-child(5),
        .table td:nth-child(5) {
            width: 150px;
            text-align: center;
        }

        .table th:nth-child(6),
        .table td:nth-child(6) {
            width: 80px;
            text-align: center;
        }
    </style>

    <div class="d-flex flex-column mb-8">
        <h1 class="text-dark fw-bold mb-1">File Kesekretariat</h1>
        <div class="text-muted fw-semibold fs-6">Manajemen File Dokumen Kesekretariat Anda Sekarang</div>
    </div>

    {{-- Toast Notification Container --}}
    <div class="toast-container" id="toast-container"></div>

    {{-- Main Content Card --}}
    <div class="row col-12 mt-5">
        <div class="card">
            {{-- Card Header --}}
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap py-5">
                <h3 class="card-title fw-bold fs-4 mb-0">Daftar File Kesekretariat - 2025</h3>

                {{-- Action Buttons --}}
                <div class="d-flex align-items-center gap-8 flex-wrap ms-auto">
                    {{-- Add Button --}}
                    <button type="button" data-bs-toggle="modal" data-bs-target="#tambahFileModal"
                        class="btn btn-active-light-danger d-flex bg-danger align-items-center btn-facebook fw-bold gap-2 rounded border-0 px-4 py-2 text-white">
                        Tambah File
                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_851_8468)">
                                <path
                                    d="M12.3782 17.0625H5.61375C4.37344 17.0582 3.18528 16.5631 2.309 15.6853C1.43272 14.8075 0.939624 13.6185 0.9375 12.3782V5.62182C0.939624 4.38151 1.43272 3.19249 2.309 2.3147C3.18528 1.43692 4.37344 0.941767 5.61375 0.937507H12.3701C12.9853 0.936447 13.5946 1.05656 14.1633 1.29099C14.7321 1.52542 15.2491 1.86958 15.6848 2.30381C16.1205 2.73804 16.4664 3.25384 16.7028 3.82176C16.9392 4.38968 17.0614 4.9986 17.0625 5.61375V12.3701C17.0636 12.986 16.9432 13.596 16.7082 14.1652C16.4733 14.7345 16.1284 15.2518 15.6933 15.6876C15.2583 16.1235 14.7415 16.4692 14.1727 16.7052C13.6038 16.9411 12.994 17.0625 12.3782 17.0625ZM13.0312 8.19375H9.80625V4.96876C9.80625 4.75492 9.7213 4.54985 9.5701 4.39865C9.4189 4.24745 9.21383 4.16251 9 4.16251C8.78617 4.16251 8.58109 4.24745 8.42989 4.39865C8.27869 4.54985 8.19375 4.75492 8.19375 4.96876V8.19375H4.96875C4.75492 8.19375 4.54984 8.2787 4.39864 8.4299C4.24744 8.5811 4.1625 8.78617 4.1625 9C4.1625 9.21383 4.24744 9.41891 4.39864 9.57011C4.54984 9.72131 4.75492 9.80625 4.96875 9.80625H8.19375V13.0313C8.19375 13.2451 8.27869 13.4502 8.42989 13.6014C8.58109 13.7526 8.78617 13.8375 9 13.8375C9.21383 13.8375 9.4189 13.7526 9.5701 13.6014C9.7213 13.4502 9.80625 13.2451 9.80625 13.0313V9.80625H13.0312C13.2451 9.80625 13.4501 9.72131 13.6013 9.57011C13.7526 9.41891 13.8375 9.21383 13.8375 9C13.8375 8.78617 13.7526 8.5811 13.6013 8.4299C13.4501 8.2787 13.2451 8.19375 13.0312 8.19375Z"
                                    fill="white" />
                            </g>
                            <defs>
                                <clipPath id="clip0_851_8468">
                                    <rect width="18" height="18" fill="white" />
                                </clipPath>
                            </defs>
                        </svg>
                    </button>

                    {{-- Search + Filter --}}
                    <div class="d-flex align-items-center gap-7 flex-wrap">
                        {{-- Search --}}
                        <div class="search-container">
                            <div class="input-group border rounded" style="width: 200px;">
                                <span class="input-group-text bg-transparent border-0">
                                    <i class="fas fa-search"></i>
                                </span>
                                <input type="search" name="search" id="search" class="form-control border-0 py-2"
                                    placeholder="Cari nama dokumen..." value="{{ request('search') }}" autocomplete="off">
                                <div class="search-loading">
                                    <i class="fas fa-spinner fa-spin"></i>
                                </div>
                            </div>
                        </div>

                        {{-- Filter --}}
                        <div class="border rounded" style="width: 120px;">
                            <button
                                class="btn bg-white dropdown-toggle w-100 text-start border-0 py-2 d-flex justify-content-between align-items-center"
                                type="button" data-bs-toggle="dropdown">
                                <span>Filter</span>
                                <div>
                                    <i class="fas fa-filter ms-1"></i>
                                    <span id="filter-count"
                                        class="badge badge-circle badge-danger ms-1 {{ request('file_type') ? '' : 'd-none' }}">
                                        {{ request('file_type') ? 1 : 0 }}
                                    </span>
                                </div>
                            </button>
                            <div class="dropdown-menu p-3 shadow" style="min-width: 320px;">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Tipe File</label>
                                    <select id="filter-file-type" name="file_type" class="form-select">
                                        <option value="">Semua Tipe</option>
                                        <option value="pdf" {{ request('file_type') == 'pdf' ? 'selected' : '' }}>PDF
                                        </option>
                                        <option value="doc" {{ request('file_type') == 'doc' ? 'selected' : '' }}>DOC
                                        </option>
                                        <option value="docx" {{ request('file_type') == 'docx' ? 'selected' : '' }}>DOCX
                                        </option>
                                        <option value="xls" {{ request('file_type') == 'xls' ? 'selected' : '' }}>XLS
                                        </option>
                                        <option value="xlsx" {{ request('file_type') == 'xlsx' ? 'selected' : '' }}>XLSX
                                        </option>
                                    </select>
                                </div>

                                <div class="d-flex gap-2">
                                    <button type="button" id="apply-filters" class="btn btn-primary btn-sm flex-fill">
                                        <i class="fas fa-check"></i> Terapkan
                                    </button>
                                    <button type="button" id="reset-filters" class="btn btn-light btn-sm flex-fill">
                                        <i class="fas fa-redo"></i> Reset
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card Body --}}
            <div class="card-body" id="tableContainer">
    @if ($files->isEmpty())
        <div class="empty-state" id="emptyState">
            @if (request('search') || request('file_type'))
                <i class="fas fa-search"></i>
                <h4>Data tidak ditemukan</h4>
                <p>
                    Tidak ada file yang sesuai dengan pencarian
                    @if (request('search'))
                        <strong>"{{ request('search') }}"</strong>
                    @endif
                    @if (request('file_type'))
                        dengan tipe <strong>{{ strtoupper(request('file_type')) }}</strong>
                    @endif
                </p>
                <button type="button" class="btn btn-outline-primary btn-sm mt-2" onclick="resetAllFilters()">
                    <i class="fas fa-times me-1"></i> Reset Pencarian
                </button>
            @else
                <i class="fas fa-folder-open"></i>
                <h4>Belum ada file yang ditambahkan</h4>
                <p>Klik tombol "Tambah File" untuk menambahkan file baru</p>
            @endif
        </div>
            @else
                {{-- Data Table --}}
                <div class="table-responsive" id="dataTable">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="bg-light">
                            <tr>
                                <th>No</th>
                                <th>
                                    <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'nama_dokumen', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}"
                                        class="text-dark text-decoration-none d-flex align-items-center">
                                        Nama Dokumen
                                        @if (request('sort_by') == 'nama_dokumen')
                                            <i
                                                class="fas fa-arrow-{{ request('order') == 'asc' ? 'up' : 'down' }} ms-1"></i>
                                        @else
                                            <i class="fas fa-sort ms-1 text-muted"></i>
                                        @endif
                                    </a>
                                </th>
                                <th>File Dokumen</th>
                                <th>Ukuran</th>
                                <th>Tanggal Upload</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            @forelse ($files as $index => $file)
                                <tr id="file-row-{{ $file->id }}">
                                    <td class="text-center">{{ $files->firstItem() + $index }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-file-alt file-icon"></i>
                                            <strong class="text-truncate-custom">{{ $file->nama_dokumen }}</strong>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="{{ asset('storage/documents/' . $file->dokumen_file) }}" target="_blank"
                                            class="file-link" title="Klik untuk melihat dokumen">
                                            {{ $file->dokumen_file }}
                                        </a>
                                    </td>
                                    <td>{{ $file->file_size }}</td>
                                    <td>{{ $file->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <button class="btn btn-sm p-0" type="button" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <svg width="32" height="32" viewBox="0 0 32 32" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <rect width="32" height="32" rx="6" fill="#EFF6FF" />
                                                    <rect x="0.5" y="0.5" width="31" height="31" rx="5.5"
                                                        stroke="#1B84FF" stroke-opacity="0.2" />
                                                    <g clip-path="url(#clip0_2223_4269)">
                                                        <path opacity="0.3"
                                                            d="M19.4266 7.9375H12.5734C10.0131 7.9375 7.9375 10.0131 7.9375 12.5734V19.4266C7.9375 21.9869 10.0131 24.0625 12.5734 24.0625H19.4266C21.9869 24.0625 24.0625 21.9869 24.0625 19.4266V12.5734C24.0625 10.0131 21.9869 7.9375 19.4266 7.9375Z"
                                                            fill="#1B84FF" />
                                                        <path
                                                            d="M12.251 14.8232C12.8475 14.8233 13.331 15.3067 13.3311 15.9033C13.3311 16.4999 12.8476 16.9833 12.251 16.9834C11.6543 16.9834 11.1709 16.5 11.1709 15.9033C11.1709 15.3067 11.6543 14.8232 12.251 14.8232ZM16.2979 14.8232C16.8945 14.8232 17.3789 15.3066 17.3789 15.9033C17.3789 16.5 16.8945 16.9834 16.2979 16.9834C15.7013 16.9832 15.2178 16.4999 15.2178 15.9033C15.2178 15.3067 15.7013 14.8234 16.2979 14.8232ZM20.3369 14.8232C20.9336 14.8232 21.418 15.3066 21.418 15.9033C21.418 16.5 20.9336 16.9834 20.3369 16.9834C19.7404 16.9832 19.2568 16.4999 19.2568 15.9033C19.2568 15.3068 19.7404 14.8234 20.3369 14.8232Z"
                                                            fill="#1B84FF" />
                                                    </g>
                                                </svg>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end cursor-pointer">
                                                <li>
                                                    <a href="{{ route('admin.file-kesekretariat.edit', $file) }}"
                                                        class="dropdown-item">
                                                        <i class="fas fa-edit me-2"></i>Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#" class="dropdown-item delete-btn"
                                                        data-file-id="{{ $file->id }}"
                                                        data-file-name="{{ $file->nama_dokumen }}"
                                                        data-delete-url="{{ route('admin.file-kesekretariat.destroy', $file) }}">
                                                        <i class="fas fa-trash me-2"></i>Hapus
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('admin.file-kesekretariat.download', $file) }}"
                                                        class="dropdown-item">
                                                        <i class="fas fa-download me-2"></i>Download
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr id="noDataRow">
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <div class="empty-state">
                                            <i class="fas fa-search"></i>
                                            <h5>Data tidak ditemukan</h5>
                                            <p class="mb-0">Silakan coba kata kunci pencarian yang lain</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if ($files->total() >= 0)
                    <div class="pagination-wrapper">
                        <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap">
                            {{-- Per Page Dropdown --}}
                            <div class="d-flex align-items-center gap-2">
                                <span class="text-muted small">Show</span>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light border dropdown-toggle" type="button"
                                        id="perPageDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                        {{ request('per_page', 10) }}
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="perPageDropdown">
                                        @foreach ([10, 20, 30, 40] as $perPage)
                                            <li>
                                                <a class="dropdown-item {{ request('per_page', 10) == $perPage ? 'active' : '' }}"
                                                    href="#" onclick="updatePerPage({{ $perPage }})">
                                                    {{ $perPage }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <span class="text-muted small">per page</span>
                            </div>

                            {{-- Pagination Info and Controls --}}
                            <div class="d-flex align-items-center gap-3">
                                <div class="text-muted small">
                                    {{ $files->firstItem() }}-{{ $files->lastItem() }} of {{ $files->total() }}
                                </div>

                                <nav aria-label="Page navigation">
                                    <ul class="pagination pagination-sm mb-0">
                                        {{-- Previous --}}
                                        <li class="page-item {{ $files->onFirstPage() ? 'disabled' : '' }}">
                                            <a class="page-link" href="#"
                                                onclick="event.preventDefault(); goToPage({{ $files->currentPage() - 1 }})">
                                                &lt;
                                            </a>
                                        </li>

                                        {{-- First Page --}}
                                        @if ($files->currentPage() > 3)
                                            <li class="page-item">
                                                <a class="page-link" href="#"
                                                    onclick="event.preventDefault(); goToPage(1)">1</a>
                                            </li>
                                            @if ($files->currentPage() > 4)
                                                <li class="page-item disabled">
                                                    <span class="page-link">...</span>
                                                </li>
                                            @endif
                                        @endif

                                        {{-- Page Numbers --}}
                                        @foreach (range(max(1, $files->currentPage() - 2), min($files->lastPage(), $files->currentPage() + 2)) as $page)
                                            <li class="page-item {{ $page == $files->currentPage() ? 'active' : '' }}">
                                                <a class="page-link" href="#"
                                                    onclick="event.preventDefault(); goToPage({{ $page }})">
                                                    {{ $page }}
                                                </a>
                                            </li>
                                        @endforeach

                                        {{-- Last Page --}}
                                        @if ($files->currentPage() < $files->lastPage() - 2)
                                            @if ($files->currentPage() < $files->lastPage() - 3)
                                                <li class="page-item disabled">
                                                    <span class="page-link">...</span>
                                                </li>
                                            @endif
                                            <li class="page-item">
                                                <a class="page-link" href="#"
                                                    onclick="event.preventDefault(); goToPage({{ $files->lastPage() }})">
                                                    {{ $files->lastPage() }}
                                                </a>
                                            </li>
                                        @endif

                                        {{-- Next --}}
                                        <li class="page-item {{ !$files->hasMorePages() ? 'disabled' : '' }}">
                                            <a class="page-link" href="#"
                                                onclick="event.preventDefault(); goToPage({{ $files->currentPage() + 1 }})">
                                                &gt;
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                @endif
                @endif
            </div>
        </div>
    </div>

    {{-- Tambah File Modal --}}
    <div class="modal fade" id="tambahFileModal" tabindex="-1" aria-labelledby="tambahFileModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.file-kesekretariat.store') }}" method="POST"
                    enctype="multipart/form-data" id="tambahFileForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold" id="tambahFileModalLabel">
                            <i class="fas fa-plus-circle me-2"></i>Tambah File Baru
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama_dokumen" class="form-label fw-semibold">
                                Nama Dokumen <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="nama_dokumen" name="nama_dokumen" required
                                placeholder="Masukkan nama dokumen">
                            <div class="invalid-feedback" id="nama_dokumen_error"></div>
                        </div>
                        <div class="mb-3">
                            <label for="dokumen_file" class="form-label fw-semibold">
                                File Dokumen <span class="text-danger">*</span>
                            </label>
                            <input type="file" class="form-control" id="dokumen_file" name="dokumen_file" required
                                accept=".pdf,.doc,.docx,.xls,.xlsx">
                            <div class="form-text text-muted">Format: PDF, DOC, DOCX, XLS, XLSX (Max: 2MB)</div>
                            <div class="invalid-feedback" id="dokumen_file_error"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>Batal
                        </button>
                        <button type="submit" class="btn btn-danger" id="submitBtn">
                            <i class="fas fa-save me-1"></i>Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    

    {{-- Delete Confirmation Modal --}}
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="deleteModalLabel">
                        <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                        Konfirmasi Hapus
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-3">
                        <div class="mb-3">
                            <i class="fas fa-trash-alt text-danger" style="font-size: 48px;"></i>
                        </div>
                        <h6 class="fw-bold mb-3">Apakah Anda yakin ingin menghapus file ini?</h6>
                        <div class="bg-light p-3 rounded">
                            <div class="d-flex align-items-center justify-content-center">
                                <i class="fas fa-file-alt text-primary me-2"></i>
                                <span class="fw-semibold" id="fileName">-</span>
                            </div>
                        </div>
                        <p class="text-muted mt-3 mb-0 small">
                            <i class="fas fa-info-circle me-1"></i>
                            Data yang sudah dihapus tidak dapat dikembalikan
                        </p>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Batal
                    </button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                        <i class="fas fa-trash me-1"></i>Ya, Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection



@section('script')

    <script>
        function getFileIcon(extension) {
            const icons = {
                'pdf': 'fas fa-file-pdf file-icon-pdf',
                'doc': 'fas fa-file-word file-icon-doc',
                'docx': 'fas fa-file-word file-icon-doc',
                'xls': 'fas fa-file-excel file-icon-xls',
                'xlsx': 'fas fa-file-excel file-icon-xls',
                'default': 'fas fa-file file-icon-default'
            };
            return icons[extension.toLowerCase()] || icons['default'];
        }

        // Fungsi untuk menambahkan ikon file
        function addFileIcons() {
            $('.file-link').each(function() {
                const fileName = $(this).text().trim();
                const extension = fileName.split('.').pop();
                const iconClass = getFileIcon(extension);

                // Tambahkan ikon sebelum nama file
                $(this).prepend(`<i class="${iconClass}"></i>`);
            });
        }

        $(document).ready(function() {
            // Panggil fungsi untuk menambahkan ikon
            addFileIcons();

            // Tambahkan juga di callback success AJAX search
            $(document).ajaxSuccess(function() {
                addFileIcons();
            });
        });
        $(document).ready(function() {
            let isLoading = false;
            let searchTimeout;

            const baseUrl = "{{ route('admin.file-kesekretariat.index') }}";

            // Show loading indicator
            function showLoading() {
                $('.search-loading').show();
                isLoading = true;
            }

            // Hide loading indicator
            function hideLoading() {
                $('.search-loading').hide();
                isLoading = false;
            }

            // Fungsi untuk mendapatkan ikon berdasarkan ekstensi file


            // Clear form validation errors
            function clearFormErrors() {
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').empty();
            }

            // Show form validation errors
            function showFormErrors(errors) {
                clearFormErrors();
                $.each(errors, function(field, messages) {
                    const input = $(`#${field}`);
                    const errorDiv = $(`#${field}_error`);

                    input.addClass('is-invalid');
                    errorDiv.text(messages[0]);
                });
            }

            // Get file icon based on file type
            function getFileIcon(fileType) {
                const icons = {
                    'pdf': 'fas fa-file-pdf text-danger',
                    'doc': 'fas fa-file-word text-primary',
                    'docx': 'fas fa-file-word text-primary',
                    'xls': 'fas fa-file-excel text-success',
                    'xlsx': 'fas fa-file-excel text-success',
                    'default': 'fas fa-file-alt text-secondary'
                };
                return icons[fileType.toLowerCase()] || icons['default'];
            }


            // Perform AJAX search request
            function performSearch(params = {}, showLoadingIndicator = true) {
                if (isLoading) return;

                if (showLoadingIndicator) showLoading();

                const searchParams = new URLSearchParams();

                // Get current form values
                const search = $('#search').val().trim();
                const fileType = $('#filter-file-type').val();

                // Add parameters
                if (search) searchParams.set('search', search);
                if (fileType) searchParams.set('file_type', fileType);
                if (params.page) searchParams.set('page', params.page);
                if (params.per_page) searchParams.set('per_page', params.per_page);

                // Add sorting parameters from current URL if they exist
                const currentUrl = new URLSearchParams(window.location.search);
                if (currentUrl.get('sort_by')) searchParams.set('sort_by', currentUrl.get('sort_by'));
                if (currentUrl.get('order')) searchParams.set('order', currentUrl.get('order'));

                const url = `${baseUrl}?${searchParams.toString()}`;

                $.ajax({
                    url: url,
                    type: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'text/html'
                    },
                    success: function(response) {
                        // Update the table container with new content
                        const $response = $(response);
                        const $newTableContainer = $response.find('#tableContainer');

                        if ($newTableContainer.length) {
                            $('#tableContainer').html($newTableContainer.html());
                        }

                        // Update URL without page reload
                        window.history.pushState({}, '', url);

                        // Update filter count badge
                        updateFilterCountBadge();
                    },
                    error: function(xhr, status, error) {
                        console.error('Search error:', error);
                        showNotification('Terjadi kesalahan saat mencari data', 'error');
                    },
                    complete: function() {
                        hideLoading();
                    }
                });
            }

            // Handle form submission for adding new file
            $('#tambahFileForm').on('submit', function(e) {
                e.preventDefault();
                const form = $(this);
                const formData = new FormData(form[0]);

                // Clear previous errors
                clearFormErrors();

                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $('#submitBtn').prop('disabled', true)
                            .html('<i class="fas fa-spinner fa-spin me-1"></i>Menyimpan...');
                    },
                    success: function(response) {
                        $('#tambahFileModal').modal('hide');
                        showNotification('File berhasil ditambahkan', 'success');
                        form.trigger('reset');
                        clearFormErrors();

                        // Reload data table
                        performSearch({
                            page: 1
                        }, true);
                    },
                    error: function(xhr) {
                        if (xhr.status === 422 && xhr.responseJSON.errors) {
                            // Validation errors
                            showFormErrors(xhr.responseJSON.errors);
                        } else {
                            let errorMessage = 'Terjadi kesalahan saat menyimpan file';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            }
                            showNotification(errorMessage, 'error');
                        }
                    },
                    complete: function() {
                        $('#submitBtn').prop('disabled', false)
                            .html('<i class="fas fa-save me-1"></i>Simpan');
                    }
                });
            });

            // Update filter count badge
            function updateFilterCountBadge() {
                let count = 0;
                if ($('#filter-file-type').val()) count++;

                const badge = $('#filter-count');
                badge.text(count);
                badge.toggleClass('d-none', count === 0);
            }

            // Auto search on input
            $('#search').on('input', function() {
                clearTimeout(searchTimeout);
                const query = $(this).val().trim();

                searchTimeout = setTimeout(function() {
                    performSearch({
                        page: 1
                    });
                }, 300);
            });

            // Filter change events
            $('#filter-file-type').on('change', function() {
                performSearch({
                    page: 1
                });
            });

            // Apply filters button
            $('#apply-filters').on('click', function() {
                performSearch({
                    page: 1
                });
                // Close dropdown
                $('.dropdown-menu').removeClass('show');
            });

            // Reset filters button
            $('#reset-filters').on('click', function() {
                $('#search').val('');
                $('#filter-file-type').val('');
                performSearch({
                    page: 1
                });
                // Close dropdown
                $('.dropdown-menu').removeClass('show');
            });

            // Initialize filter count on page load
            updateFilterCountBadge();

            // Delete functionality
            $(document).on('click', '.delete-btn', function(e) {
                e.preventDefault();
                const fileId = $(this).data('file-id');
                const fileName = $(this).data('file-name');
                const deleteUrl = $(this).data('delete-url');

                $('#fileName').text(fileName);
                $('#confirmDeleteBtn').data('delete-url', deleteUrl);
                $('#confirmDeleteBtn').data('file-id', fileId);

                $('#deleteModal').modal('show');
            });

            // Confirm delete
            $('#confirmDeleteBtn').on('click', function() {
                const deleteUrl = $(this).data('delete-url');
                const fileId = $(this).data('file-id');
                const btn = $(this);

                btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i>Menghapus...');

                $.ajax({
                    url: deleteUrl,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#deleteModal').modal('hide');

                        if (response.success) {
                            showNotification(response.message || 'File berhasil dihapus',
                                'success');

                            // Remove the row from table
                            $(`#file-row-${fileId}`).fadeOut(300, function() {
                                $(this).remove();

                                // Check if table is empty after deletion
                                if ($('#tableBody tr:visible').length === 0) {
                                    performSearch(); // Reload the page content
                                }
                            });
                        } else {
                            showNotification(response.message ||
                                'Terjadi kesalahan saat menghapus file', 'error');
                        }
                    },
                    error: function(xhr) {
                        $('#deleteModal').modal('hide');
                        let errorMessage = 'Terjadi kesalahan saat menghapus file';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        showNotification(errorMessage, 'error');
                    },
                    complete: function() {
                        btn.prop('disabled', false).html(
                            '<i class="fas fa-trash me-1"></i>Ya, Hapus');
                    }
                });
            });

            // Reset modal when closed
            $('#tambahFileModal').on('hidden.bs.modal', function() {
                $('#tambahFileForm').trigger('reset');
                clearFormErrors();
            });

            // Reset preview modal when closed
            $('#filePreviewModal').on('hidden.bs.modal', function() {
                $('#filePreviewContainer').html($('#previewLoading'));
            });

            // File input change event for validation
            $('#dokumen_file').on('change', function() {
                const file = this.files[0];
                if (file) {
                    const maxSize = 2 * 1024 * 1024; // 2MB
                    const allowedTypes = ['application/pdf', 'application/msword',
                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                        'application/vnd.ms-excel',
                        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                    ];

                    if (file.size > maxSize) {
                        $(this).addClass('is-invalid');
                        $('#dokumen_file_error').text('Ukuran file tidak boleh lebih dari 2MB');
                        return;
                    }

                    if (!allowedTypes.includes(file.type)) {
                        $(this).addClass('is-invalid');
                        $('#dokumen_file_error').text(
                            'Format file tidak didukung. Gunakan PDF, DOC, DOCX, XLS, atau XLSX');
                        return;
                    }

                    $(this).removeClass('is-invalid');
                    $('#dokumen_file_error').empty();
                }
            });

            // Add tooltip to preview buttons
            $(document).on('mouseenter', '.preview-file', function() {
                $(this).attr('title', 'Klik untuk melihat preview file');
            });
        });

        // Global functions for pagination
        function goToPage(page) {
            const searchParams = new URLSearchParams(window.location.search);
            searchParams.set('page', page);

            const url = `{{ route('admin.file-kesekretariat.index') }}?${searchParams.toString()}`;
            window.location.href = url;
        }

        function updatePerPage(perPage) {
            const searchParams = new URLSearchParams(window.location.search);
            searchParams.set('per_page', perPage);
            searchParams.delete('page'); // Reset ke halaman pertama

            const url = `{{ route('admin.file-kesekretariat.index') }}?${searchParams.toString()}`;
            window.location.href = url;
        }

        function resetAllFilters() {
            $('#search').val('');
            $('#filter-file-type').val('');

            // Trigger search to reload content
            $('#search').trigger('input');
        }
    </script>
@endsection
