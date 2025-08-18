    @extends('layouts.app')

    @section('pageTitle', 'Manajemen File')
    @section('mainSection', 'File Kesekretariat')

    @section('breadcrumb-title')
    @endsection

    @section('breadcrumb-items')
    @endsection

    @section('content')
        <style>
            /* Updated CSS untuk struktur tabel baru */
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

/* Updated Column widths - hanya 4 kolom sekarang */
.table th:nth-child(1),
.table td:nth-child(1) {
    width: 3% !important;          /* rapat ke kiri */
    white-space: nowrap;
    text-align: center;
    padding: 0.125rem 0.25rem !important;
    font-size: 0.75rem;
    line-height: 1;
}

.table th:nth-child(2),
.table td:nth-child(2) {
    width: 40%; /* Lebih lebar untuk nama dokumen + tanggal */
}

.table th:nth-child(3),
.table td:nth-child(3) {
    width: 35%; /* Untuk tipe file */
}

/* Kolom aksi diperkecil */
/* Kolom Aksi super kecil */
.table th:nth-child(4),
.table td:nth-child(4) {
    width: 5% !important;
    min-width: auto !important;
    max-width: 6% !important;
    text-align: center;
    padding: 0 !important;
}

/* Tombol dropdown rapat */
.dropdown-toggle-action {
    width: 24px !important;
    height: 24px !important;
    padding: 0 !important;
    margin: 0 auto;
    border: none;
    background: transparent;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

/* Style untuk nama dokumen dengan tanggal di bawahnya */
.document-info {
    display: flex;
    flex-direction: column;
}

.document-name {
    font-weight: 600;
    color: #1B84FF;
    text-decoration: none;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    padding: 4px 8px;
    border-radius: 6px;
    border: 1px solid transparent;
    margin-bottom: 4px;
}

.document-name:hover {
    color: #0d6efd;
    background-color: #f0f8ff;
    border-color: #e3f2fd;
    transform: translateY(-1px);
    text-decoration: none;
}

.document-name i {
    margin-right: 8px;
    flex-shrink: 0;
}

.document-date {
    font-size: 12px;
    color: #6c757d;
    font-weight: 400;
    margin-top: 2px;
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

/* Dropdown action styling - smaller and more compact */
.dropdown-action {
    position: relative;
}

.dropdown-toggle-action {
    background: transparent !important;
    border: none !important;
    padding: 2px !important;
    border-radius: 6px !important;
    transition: all 0.2s ease !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    width: 28px !important;
    height: 28px !important;
}

.dropdown-toggle-action:hover {
    background-color: #f0f8ff !important;
    border-color: #e3f2fd !important;
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(27, 132, 255, 0.1);
}

.dropdown-toggle-action:focus {
    box-shadow: 0 0 0 2px rgba(248, 40, 90, 0.2) !important;
}

.dropdown-toggle-action svg {
    width: 20px !important;
    height: 20px !important;
}

.dropdown-menu-action {
    position: absolute !important;
    right: 0 !important;
    left: auto !important;
    top: 100% !important;
    margin-top: 4px !important;
    border: 1px solid #e9ecef !important;
    border-radius: 8px !important;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12) !important;
    z-index: 1055 !important;
    min-width: 160px !important;
    padding: 8px 0 !important;
    background: white !important;
    display: none !important;
}

.dropdown-menu-action.show {
    display: block !important;
}

.dropdown-item-action {
    display: flex !important;
    align-items: center !important;
    padding: 8px 16px !important;
    font-size: 14px !important;
    color: #495057 !important;
    text-decoration: none !important;
    border: none !important;
    background: none !important;
    width: 100% !important;
    text-align: left !important;
    transition: all 0.2s ease !important;
    cursor: pointer !important;
}

.dropdown-item-action:hover {
    background-color: #f0f8ff !important;
    color: #1B84FF !important;
    transform: translateX(2px) !important;
}

.dropdown-item-action i {
    width: 16px !important;
    font-size: 14px !important;
    margin-right: 8px !important;
    flex-shrink: 0 !important;
}

/* Untuk baris terakhir, gunakan dropup */
.table tbody tr:nth-last-child(-n+2) .dropdown-menu-action {
    top: auto !important;
    bottom: 100% !important;
    margin-top: 0 !important;
    margin-bottom: 4px !important;
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
    .dropdown-menu-action {
        right: 0 !important;
        left: auto !important;
    }

    .table-responsive {
        overflow-x: auto !important;
        overflow-y: visible !important;
    }

    .dropdown-menu-action {
        position: absolute !important;
        right: 0 !important;
        left: auto !important;
        margin-top: 8px !important;
    }

    /* Responsive column widths */
    .table th:nth-child(2),
    .table td:nth-child(2) {
        width: 50%;
    }

    .table th:nth-child(3),
    .table td:nth-child(3) {
        width: 30%;
    }
}

/* Pagination styling - improved */
.pagination-wrapper {
    margin-top: 1.5rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 1rem;
    flex-wrap: wrap;
}

.pagination-info {
    color: #6c757d;
    font-size: 0.875rem;
    white-space: nowrap;
}

.pagination-controls {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.per-page-selector {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    color: #6c757d;
}

.per-page-dropdown {
    position: relative;
}

.per-page-btn {
    background: white;
    border: 1px solid #dee2e6;
    border-radius: 6px;
    padding: 6px 12px;
    font-size: 0.875rem;
    color: #495057;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    min-width: 60px;
    justify-content: space-between;
}

.per-page-btn:hover {
    border-color: #F8285A;
}

.per-page-menu {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: white;
    border: 1px solid #dee2e6;
    border-radius: 6px;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
    z-index: 1000;
    margin-top: 4px;
    display: none;
}

.per-page-menu.show {
    display: block;
}

.per-page-option {
    padding: 8px 16px;
    font-size: 0.875rem;
    color: #495057;
    cursor: pointer;
    border: none;
    background: none;
    width: 100%;
    text-align: left;
    transition: background-color 0.2s ease;
}

.per-page-option:hover {
    background-color: #f8f9fa;
}

.per-page-option.active {
    background-color: #F8285A;
    color: white;
}

.pagination {
    margin: 0;
    gap: 2px;
}

.page-item .page-link {
    border: 1px solid #dee2e6;
    color: #6c757d;
    padding: 6px 12px;
    font-size: 0.875rem;
    border-radius: 6px;
    margin: 0;
    min-width: 36px;
    text-align: center;
    transition: all 0.2s ease;
}

.page-item.active .page-link {
    background-color: #F8285A;
    border-color: #F8285A;
    color: white;
}

.page-item:not(.disabled) .page-link:hover {
    background-color: #f8f9fa;
    border-color: #dee2e6;
    color: #495057;
}

.page-item.disabled .page-link {
    color: #adb5bd;
    background-color: #f8f9fa;
    border-color: #dee2e6;
}

.preview-file:hover {
    background-color: #1570e6 !important;
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

/* Ikon berdasarkan tipe file */
.file-icon-pdf {
    color: #e74c3c;
}

.file-icon-doc {
    color: #2c3e50;
}

.file-icon-xls {
    color: #27ae60;
}

.file-icon-default {
    color: #7f8c8d;
}

/* Table loading state */
.table-loading {
    opacity: 0.6;
    pointer-events: none;
}

.loading-spinner {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 2rem;
}

.loading-spinner .spinner-border {
    width: 2rem;
    height: 2rem;
    color: #F8285A;
}

.table-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 1.5rem;
    flex-wrap: wrap;
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
    .pagination-wrapper {
        flex-direction: column;
        align-items: stretch;
        gap: 1rem;
    }

    .pagination-controls {
        justify-content: space-between;
        width: 100%;
    }

    .pagination {
        flex-wrap: wrap;
        justify-content: center;
        gap: 2px;
    }

    .file-preview-modal .modal-dialog {
        max-width: 95vw;
        width: 95vw;
        height: 85vh;
        margin: 2.5vh auto;
    }

    .table tbody tr:last-child .dropdown-menu-action {
        top: auto !important;
        bottom: 100% !important;
        margin-top: 0 !important;
        margin-bottom: 0.125rem !important;
    }

    .table-footer {
        flex-direction: column;
        align-items: stretch;
        gap: 1rem;
    }

    .pagination-controls {
        justify-content: space-between;
        width: 100%;
    }
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
<div class="card-header d-flex justify-content-between align-items-center flex-wrap py-3">
    {{-- Judul di kiri --}}
    <div class="d-flex flex-column">
        <h3 class="card-title fw-bold fs-4 mb-0">Daftar File Kesekretariat - 2025</h3>
        <span class="text-muted fs-6">
            Menampilkan <span id="showing-start">1</span>-<span id="showing-end">{{ $files->count() }}</span> dari <b>{{ $files->total() }}</b> data
        </span>
    </div>
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
                                        placeholder="Cari nama dokumen..." value="{{ request('search') }}"
                                        autocomplete="off">
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
                                            <option value="docx" {{ request('file_type') == 'docx' ? 'selected' : '' }}>
                                                DOCX
                                            </option>
                                            <option value="xls" {{ request('file_type') == 'xls' ? 'selected' : '' }}>XLS
                                            </option>
                                            <option value="xlsx" {{ request('file_type') == 'xlsx' ? 'selected' : '' }}>
                                                XLSX
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
                    @include('admin.file-kesekretariat._table', ['files' => $files])
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
                                <input type="file" class="form-control" id="dokumen_file" name="dokumen_file"
                                    required accept=".pdf,.doc,.docx,.xls,.xlsx">
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
    // Fungsi untuk menambahkan notifikasi
    function showNotification(message, type = 'success') {
        const toastId = 'toast-' + Date.now();
        const icon = type === 'success' ? 'check-circle' : 'exclamation-triangle';
        const bgColor = type === 'success' ? 'success' : 'error';
        
        const toastHtml = `
            <div class="toast ${bgColor}" id="${toastId}" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000">
                <div class="toast-header">
                    <i class="fas fa-${icon} me-2 ${type === 'success' ? 'text-success' : 'text-danger'}"></i>
                    <strong class="me-auto">${type === 'success' ? 'Berhasil' : 'Error'}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    ${message}
                </div>
            </div>
        `;
        
        $('#toast-container').append(toastHtml);
        
        const toastElement = new bootstrap.Toast(document.getElementById(toastId));
        toastElement.show();
        
        // Auto remove after hide
        document.getElementById(toastId).addEventListener('hidden.bs.toast', function () {
            $(this).remove();
        });
    }

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

        // Dropdown functionality
        $(document).on('click', '.dropdown-toggle-action', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            // Close other dropdowns
            $('.dropdown-menu-action').removeClass('show');
            
            // Toggle current dropdown
            $(this).next('.dropdown-menu-action').toggleClass('show');
        });

        // Per-page dropdown functionality
        $(document).on('click', '.per-page-btn', function(e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).next('.per-page-menu').toggleClass('show');
        });

        // Close dropdowns when clicking outside
        $(document).on('click', function() {
            $('.dropdown-menu-action').removeClass('show');
            $('.per-page-menu').removeClass('show');
        });

        // Prevent dropdown close when clicking inside
        $(document).on('click', '.dropdown-menu-action, .per-page-menu', function(e) {
            e.stopPropagation();
        });
    });

    // Global functions for pagination
    function goToPage(page) {
        performSearch({
            page: page
        }, true);
    }

    // Event listener untuk pagination links
    $(document).on('click', '.pagination-link', function(e) {
        e.preventDefault();
        const url = $(this).attr('href');
        if (url && url !== '#') {
            const page = url.split('page=')[1];
            goToPage(page);
        }
    });

    // Per page dropdown
    $(document).on('click', '.per-page-option', function() {
        const perPage = $(this).data('value');
        performSearch({
            page: 1,
            per_page: perPage
        }, true);
    });

    function updatePerPage(perPage) {
        const searchParams = new URLSearchParams(window.location.search);
        searchParams.set('per_page', perPage);
        searchParams.delete('page'); // Reset ke halaman pertama

        const url = "{{ route('admin.file-kesekretariat.index') }}?" + searchParams.toString();
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
