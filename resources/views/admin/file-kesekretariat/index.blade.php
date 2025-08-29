@extends('layouts.app')

@section('pageTitle', 'Manajemen File')
@section('mainSection', 'Menu Utama')
@section('currentSection', 'File Kesekretariat')

@section('style')
    <style>
        /* =================================
                                                                                                                                                                               BASIC LAYOUT & COLORS - UPDATED
                                                                                                                                                                            ================================= */
        body {
            background-color: #ffffff;
            /* Changed from #f5f5f5 to white like file 1 */
        }

        .card {
            overflow: visible !important;
            border: none;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border-radius: 12px;
            background-color: #ffffff;
            /* Ensure card background is white */
        }

        .card-body {
            overflow: visible !important;
            background-color: #ffffff;
            /* Ensure card body background is white */
        }

        /* =================================
                                                                                                                                                                               FILTER & SEARCH CONTAINER
                                                                                                                                                                            ================================= */
        .filter-container {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .search-container {
            position: relative;
            width: 250px;
        }

        .search-input {
            padding-left: 45px !important;
        }

        .search-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            pointer-events: none;
            z-index: 10;
        }

        .search-loading {
            display: none;
            position: absolute;
            right: 40px;
            top: 50%;
            transform: translateY(-50%);
            color: #666;
        }

        /* =================================
                                                                                                                                                                               TABLE STYLING - UPDATED TO MATCH FILE 1
                                                                                                                                                                            ================================= */
        .table-responsive {
    overflow: visible !important;
    background-color: #ffffff;
}

        .table-loading {
    opacity: 0.6;
    pointer-events: none;
}

        /* Table Headers - Updated to match file 1 gray styling */
        .table thead th {
    text-align: center !important;
    vertical-align: middle !important;
    background-color: #f8f9fa !important;
    border: none !important; /* Remove all borders */
    font-weight: 600;
    color: #495057;
    padding: 1rem 0.75rem;
}

        .table thead th a {
    justify-content: center;
    color: inherit;
    text-decoration: none;
}

        /* Basic table cells */
        .table {
    background-color: #ffffff;
    border-collapse: separate !important; /* Change from collapse to separate */
    border-spacing: 0 !important;
    border: none !important; /* Remove table border */
}

        .table td,
.table th {
    vertical-align: middle;
    word-wrap: break-word;
    max-width: 200px;
    background-color: #ffffff;
    border: none !important; /* Remove all cell borders */
}
        /* Column Width Configuration - 4 Columns */
        .table th:nth-child(1),
.table td:nth-child(1) {
    width: 3% !important;
    white-space: nowrap;
    text-align: center;
    padding: 0.5rem 0.25rem !important;
    font-size: 0.9rem !important;
    font-weight: 700 !important;
    line-height: 1.2;
    min-width: 40px;
    background-color: #ffffff;
    border: none !important;
}

        .table th:nth-child(2),
.table td:nth-child(2) {
    width: 40% !important;
    padding: 0.75rem !important;
    max-width: 30% !important;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    background-color: #ffffff;
    border: none !important;
}

        .table th:nth-child(3),
.table td:nth-child(3) {
    width: 35% !important;
    padding: 0.75rem !important;
    background-color: #ffffff;
    border: none !important;
    text-align: left !important;
}

        .table th:nth-child(4),
.table td:nth-child(4) {
    width: 5% !important;
    min-width: 50px !important;
    max-width: 6% !important;
    text-align: center;
    padding: 0.5rem 0.25rem !important;
    background-color: #ffffff;
    border: none !important;
}

        /* Table Row Hover Effects */
        .table tbody {
    position: relative;
    z-index: 1;
    background-color: #ffffff;
}

        .table tbody tr {
    position: relative;
    transition: all 0.2s ease;
    background-color: #ffffff;
    border: none !important; /* Remove row borders */
}

        .table tbody tr:hover {
    z-index: 10;
    background-color: rgba(248, 40, 90, 0.03);
}

        .table th.sortable {
            cursor: pointer;
            position: relative;
            transition: background-color 0.2s ease;
            background-color: #f8f9fa !important;
            /* Ensure gray background is maintained */
        }

        .table th.sortable:hover {
            background-color: #e9ecef !important;
            /* Darker gray on hover */
        }

        .table th.sortable .d-flex {
            justify-content: center !important;
            align-items: center;
            gap: 8px;
        }

        .sort-icon {
            font-size: 12px;
            color: #6c757d;
        }

        .sort-icon i {
            transition: color 0.2s ease;
        }

        .table th.sortable:hover .sort-icon i {
            color: #F8285A;
        }

        /* =================================
                                                                                                                                                                               DOCUMENT DISPLAY
                                                                                                                                                                            ================================= */
        .document-info {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .document-name-display {
            display: flex;
            align-items: center;
            min-width: 0;
        }

        .document-name-display>.text-truncate {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            padding-right: 4px;
        }

        .document-name {
            font-weight: 600;
            color: #495057;
            text-decoration: none;
            display: block;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            min-width: 0;
        }

        .document-name:hover {
            color: #F8285A;
            text-decoration: underline;
        }

        .document-name i {
            margin-right: 8px;
            flex-shrink: 0;
            font-size: 16px;
        }

        .document-date {
            font-size: 12px;
            color: #6c757d !important;
            font-weight: 400;
            padding-left: 8px;
            font-style: italic;
            user-select: none;
            pointer-events: none;
            cursor: default !important;
        }

        /* =================================
                                                                                                                                                                               FILE LINK STYLING
                                                                                                                                                                            ================================= */
        .file-link {
            color: #495057;
            text-decoration: none;
            font-family: 'Courier New', monospace;
            font-size: 0.875rem;
            padding: 4px 8px;
            border-radius: 4px;
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            display: inline-block;
            transition: all 0.2s ease;
        }

        .file-link:hover {
            color: #F8285A;
            background: #fdf2f4;
            border-color: #F8285A;
            text-decoration: none;
            transform: translateY(-1px);
        }

        .file-link i {
            margin-right: 6px;
        }

        /* File Icon Colors */
        .file-icon-pdf {
            color: #dc3545;
        }

        .file-icon-doc {
            color: #0d6efd;
        }

        .file-icon-xls {
            color: #198754;
        }

        .file-icon-default {
            color: #6c757d;
        }

        /* =================================
                                                                                                                                                                               DROPDOWN ACTION MENU
                                                                                                                                                                            ================================= */
        .dropdown-action {
            position: relative;
            z-index: 1;
        }

        .dropdown-toggle-action {
            background: transparent !important;
            border: 1px solid #e9ecef !important;
            border-radius: 8px !important;
            transition: all 0.2s ease !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: 32px !important;
            height: 32px !important;
            position: relative;
            z-index: 2;
            cursor: pointer;
            margin: 0 auto;
        }

        .dropdown-toggle-action:hover {
            background-color: #fdf2f4 !important;
            border-color: #F8285A !important;
            transform: translateY(-1px);
            box-shadow: 0 3px 8px rgba(248, 40, 90, 0.2);
        }

        .dropdown-toggle-action:focus {
            outline: none !important;
            box-shadow: 0 0 0 3px rgba(248, 40, 90, 0.2) !important;
        }

        .dropdown-toggle-action svg {
            width: 18px !important;
            height: 18px !important;
        }

        .dropdown-menu-action {
            position: absolute !important;
            right: 0 !important;
            left: auto !important;
            top: 100% !important;
            margin-top: 6px !important;
            border: 1px solid #dee2e6 !important;
            border-radius: 10px !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15) !important;
            z-index: 99999 !important;
            min-width: 180px !important;
            padding: 10px 0 !important;
            background: white !important;
            display: none !important;
            backdrop-filter: blur(10px);
        }

        .dropdown-menu-action.show {
            display: block !important;
        }

        .dropdown-item-action {
            display: flex !important;
            align-items: center !important;
            padding: 10px 16px !important;
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
            background-color: #f8f9fa !important;
            color: #F8285A !important;
            transform: translateX(4px) !important;
        }

        .dropdown-item-action i {
            width: 18px !important;
            font-size: 14px !important;
            margin-right: 10px !important;
            flex-shrink: 0 !important;
        }

        /* Dropdown positioning for last rows */
        .table tbody tr:nth-last-child(-n+2) .dropdown-menu-action {
            top: auto !important;
            bottom: 100% !important;
            margin-top: 0 !important;
            margin-bottom: 6px !important;
        }

        /* =================================
                                                                                                                                                                               MAIN CONTAINER WHITE BACKGROUND
                                                                                                                                                                            ================================= */
        .container {
            background-color: #ffffff;
            /* White background for main container */
            border-radius: 8px;
            padding: 1.5rem;
        }

        .d-grid {
            background-color: #ffffff;
            /* White background for grid container */
        }

        /* =================================
                                                                                                                                                                               BUTTONS & FORM CONTROLS
                                                                                                                                                                            ================================= */
        .custom-red-button,
        .btn-active-light-danger {
            background-color: #F8285A !important;
            border-color: #F8285A !important;
            color: white !important;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .custom-red-button:hover,
        .btn-active-light-danger:hover {
            background-color: #e1244e !important;
            border-color: #e1244e !important;
            color: white !important;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(248, 40, 90, 0.3);
        }

        .form-control {
            border-radius: 8px;
            border: 1px solid #dee2e6;
            padding: 12px 16px;
            transition: all 0.2s ease;
            background-color: #ffffff;
            /* White background */
        }

        .form-control:focus {
            border-color: #F8285A;
            box-shadow: 0 0 0 3px rgba(248, 40, 90, 0.1);
            background-color: #ffffff;
            /* Maintain white background on focus */
        }

        .is-invalid {
            border-color: #dc3545 !important;
        }

        .invalid-feedback {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 4px;
        }

        /* =================================
                                                                                                                                                                               PAGINATION
                                                                                                                                                                            ================================= */
        .pagination-wrapper {
            margin-top: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
            background-color: #ffffff;
            /* White background */
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

        .pagination {
            margin: 0;
            gap: 4px;
        }

        .page-item .page-link {
            border: 1px solid #dee2e6;
            color: #6c757d;
            padding: 8px 12px;
            font-size: 0.875rem;
            border-radius: 6px;
            margin: 0;
            min-width: 40px;
            text-align: center;
            transition: all 0.2s ease;
            background-color: #ffffff;
            /* White background */
        }

        .page-item.active .page-link {
            background-color: #F8285A;
            border-color: #F8285A;
            color: white;
        }

        .page-item:not(.disabled) .page-link:hover {
            background-color: #fdf2f4;
            border-color: #F8285A;
            color: #F8285A;
        }

        .page-item.disabled .page-link {
            color: #adb5bd;
            background-color: #f8f9fa;
            border-color: #dee2e6;
        }

        .table-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid #e9ecef;
            flex-wrap: wrap;
            gap: 1rem;
            background-color: #ffffff;
            /* White background */
        }

        /* =================================
                                                                                                                                                                               DROPZONE STYLING
                                                                                                                                                                            ================================= */
        .dropzone {
            border: 2px dashed #dee2e6;
            border-radius: 8px;
            background: #f8f9fa;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .dropzone:hover,
        .dropzone.drag-over {
            border-color: #F8285A;
            background-color: #fdf2f4;
        }

        .dropzone.error {
            border-color: #dc3545 !important;
            background-color: #f8d7da !important;
        }


        .dz-message {
            padding: 2rem;
            text-align: center;
            color: #6c757d;
        }

        .file-preview {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            background: white;
        }

        /* =================================
                                                                                                                                                                               MODALS & TOASTS
                                                                                                                                                                            ================================= */
        .modal-content {
            border-radius: 12px;
            border: none;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            background-color: #ffffff;
            /* White background */
        }

        .modal-header {
            border-bottom: 1px solid #eee;
            padding: 20px 24px;
            background-color: #ffffff;
            /* White background */
        }

        .modal-body {
            padding: 24px;
            background-color: #ffffff;
            /* White background */
        }

        .modal-footer {
            border-top: 1px solid #eee;
            padding: 16px 24px;
            background-color: #ffffff;
            /* White background */
        }

        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 99999;
        }

        .toast {
            min-width: 300px;
            background-color: white;
            border-left: 4px solid;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
            border-radius: 8px;
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

        /* =================================
                                                                                                                                                                               EMPTY STATE & LOADING
                                                                                                                                                                            ================================= */
        .empty-state {
            padding: 4rem 2rem;
            text-align: center;
            color: #6c757d;
            background-color: #ffffff;
            /* White background */
        }

        .empty-state i {
            font-size: 4rem;
            color: #dee2e6;
            margin-bottom: 1.5rem;
        }

        .empty-state h4 {
            color: #495057;
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .empty-state p {
            color: #6c757d;
            margin-bottom: 1.5rem;
        }

        .loading-spinner {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 3rem;
            background-color: #ffffff;
            /* White background */
        }

        .loading-spinner .spinner-border {
            width: 2.5rem;
            height: 2.5rem;
            color: #F8285A;
        }

        /* =================================
                                                                                                                                                                               UTILITY CLASSES
                                                                                                                                                                            ================================= */
        .text-truncate-custom {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .object-fit-cover {
            object-fit: cover;
        }

        /* =================================
                                                                                                                                                                               PAGE BACKGROUND OVERRIDE
                                                                                                                                                                            ================================= */
        html,
        body,
        .app,
        .main-content {
            background-color: #ffffff !important;
            /* Force white background for entire page */
        }

        /* =================================
                                                                                                                                                                               RESPONSIVE DESIGN
                                                                                                                                                                            ================================= */
        @media (max-width: 768px) {
            .filter-container {
                flex-direction: column;
                align-items: stretch;
                gap: 10px;
            }

            .search-container {
                width: 100%;
            }

            .dropdown-menu-action {
                right: 0 !important;
                left: auto !important;
                z-index: 999999 !important;
                min-width: 160px !important;
            }

            .table-responsive {
                overflow-x: auto !important;
                overflow-y: visible !important;
            }

            .table tbody tr:nth-child(n+2) .dropdown-menu-action {
                top: auto !important;
                bottom: 100% !important;
                margin-top: 0 !important;
                margin-bottom: 6px !important;
            }

            .table tbody tr:first-child .dropdown-menu-action {
                top: 100% !important;
                bottom: auto !important;
                margin-top: 6px !important;
                margin-bottom: 0 !important;
            }

            /* Mobile Column Widths */
            .table th:nth-child(1),
            .table td:nth-child(1) {
                width: 5% !important;
                font-size: 0.8rem !important;
                background-color: #ffffff;
                /* White background */
            }

            .table th:nth-child(2),
            .table td:nth-child(2) {
                width: 45% !important;
                background-color: #ffffff;
                /* White background */
            }

            .table th:nth-child(3),
            .table td:nth-child(3) {
                width: 35% !important;
                background-color: #ffffff;
                /* White background */
            }

            .table th:nth-child(4),
            .table td:nth-child(4) {
                width: 8% !important;
                min-width: 60px !important;
                background-color: #ffffff;
                /* White background */
            }

            .table-footer {
                flex-direction: column;
                align-items: stretch;
                gap: 1rem;
                background-color: #ffffff;
                /* White background */
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

            .document-name {
                padding: 4px 6px;
                font-size: 0.875rem;
            }

            .document-date {
                font-size: 11px;
                padding-left: 6px;
            }

            .text-truncate-custom {
                max-width: 150px;
            }

            .container {
                background-color: #ffffff !important;
                /* White background on mobile */
            }
        }

        [id^="edit-form-row-"] {
            transition: all 0.3s ease-in-out;
        }

        /* Dropzone biru muda */
        .dropzone,
        #dropzone-tambahFileForm,
        #dropzone-editFileForm {
            border: 2px dashed #0d6efd !important;
            border-radius: 10px !important;
            background-color: #e7f3ff !important;
            /* biru muda */
            color: #0d6efd !important;
            transition: all 0.3s ease;
        }

        .dropzone:hover,
        #dropzone-tambahFileForm:hover,
        #dropzone-editFileForm:hover {
            background-color: #cfe2ff !important;
            border-color: #0a58ca !important;
        }

        /* Hanya kolom File Dokumen menjadi rata kiri */
.table td:nth-child(3),
.table th:nth-child(3) {
    text-align: left !important;
}
    </style>
@endsection

@section('content')
    <div class="d-grid gap-5 border-0">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center container">
            <div class="d-none d-md-block">
                <h1>File Kesekretariat</h1>
                <span>Kelola dokumen kesekretariat Anda</span>
            </div>

            <!-- Filter Form -->
            <form id="filter" class="d-flex gap-3 filter-container">
                <input type="hidden" name="sort_by" id="sort_by_input" value="{{ request('sort_by', 'created_at') }}">
                <input type="hidden" name="order" id="order_input" value="{{ request('order', 'desc') }}">
                <button type="button" id="tambahFileBtn"
                    class="btn btn-active-light-danger d-flex bg-danger align-items-center btn-facebook fw-bold gap-2 rounded border-0 px-4 py-2 text-white">
                    <i class="ki-duotone ki-plus fs-2" style="color: white !important;"></i>
                    <span>Tambah File</span>
                </button>

                <div class="search-container">
                    <div class="position-relative bg-light">
                        <i class="ki-outline ki-magnifier fs-2 search-icon"></i>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari nama dokumen..."
                            class="form-control border border-gray-500 py-2 search-input" />
                        <div class="search-loading">
                            <i class="fas fa-spinner fa-spin"></i>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Main Content -->
        <div class="container">
            <h3 class="fw-bold fs-4 mb-3">Daftar File Kesekretariat</h3>
            <div id="tableContainer">
                @include('admin.file-kesekretariat._table', ['files' => $files])
            </div>
        </div>

        <!-- Toast Container -->
        <div class="toast-container" id="toast-container"></div>

        <!-- Add File Modal -->
        <div class="modal fade" id="tambahFileModal" tabindex="-1" aria-labelledby="tambahFileModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content rounded-4 gap-5 px-10 py-8">
                    <div class="d-flex justify-content-between align-items-center gap-2">
                        <div class="fs-2 fw-bold text-truncate leading-5" id="modalTitle">Tambah File Kesekretariat</div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form id="tambahFileForm" method="POST" action="{{ route('admin.file-kesekretariat.store') }}"
                        enctype="multipart/form-data" class="d-grid gap-4">
                        @csrf

                        <!-- Document Name Field -->
                        <div>
                            <div class="fw-semibold required mb-3 text-gray-800">Nama Dokumen</div>
                            <input type="text" name="nama_dokumen" placeholder="Masukkan nama dokumen"
                                class="form-control bg-light border border-gray-400" required>
                            <div class="invalid-feedback" id="nama_dokumen_error"></div>
                        </div>

                        <!-- Document Date Field -->
                        <div>
                            <div class="fw-semibold required mb-3 text-gray-800">Tanggal Dokumen</div>
                            <input type="date" name="tanggal_dokumen"
                                class="form-control bg-light border border-gray-400" required>
                            <div class="invalid-feedback" id="tanggal_dokumen_error"></div>
                            <div class="form-text text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Pilih tanggal pembuatan atau tanggal berlaku dokumen
                            </div>
                        </div>

                        <!-- File Upload Field -->
                        <div>
                            <div class="fw-semibold required mb-3 text-gray-800">File Dokumen</div>
                            <div class="dropzone" id="dropzone-tambahFileForm">
                                <div class="dz-message needsclick">
                                    <i class="ki-duotone ki-file-up fs-3x text-primary">
                                        <span class="path1"></span><span class="path2"></span>
                                    </i>
                                    <div class="ms-4">
                                        <h3 class="fs-5 fw-bold mb-1 text-gray-900">Seret atau pilih dokumen.</h3>
                                        <span class="fs-7 fw-semibold text-gray-500">Format: PDF, DOC, DOCX, XLS, XLSX. Max.
                                            10 MB.</span>
                                    </div>
                                </div>
                            </div>
                            <div class="invalid-feedback" id="dokumen_file_error"></div>
                        </div>
                    </form>

                    <!-- Submit Button -->
                    <div class="d-grid py-4">
                        <button type="button" onclick="submitForm('tambahFileForm')" id="submitBtn"
                            class="bg-danger fw-bold d-flex align-items-center justify-content-center gap-2 rounded border-0 p-4 text-white">
                            <i class="fas fa-save me-1"></i>Simpan File
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- File Preview Modal -->
        <div class="modal fade" id="filePreviewModal" tabindex="-1" aria-labelledby="filePreviewModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="d-flex align-items-center gap-3">
                            <i id="previewFileIcon" class="fas fa-file fa-2x text-primary"></i>
                            <div>
                                <h5 class="modal-title mb-0" id="previewFileName">Preview File</h5>
                                <small class="text-muted" id="previewFileSize"></small>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="button" id="downloadFromPreview" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-download me-1"></i>Download
                            </button>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                    </div>
                    <div class="modal-body p-0" style="height: 75vh; overflow: hidden;">
                        <!-- Loading State -->
                        <div id="previewLoading" class="d-flex justify-content-center align-items-center h-100">
                            <div class="text-center">
                                <div class="spinner-border text-primary mb-3" role="status"
                                    style="width: 3rem; height: 3rem;">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <p class="text-muted">Memuat preview file...</p>
                            </div>
                        </div>

                        <!-- PDF Viewer -->
                        <div id="pdfViewer" class="h-100" style="display: none;">
                            <iframe id="pdfFrame" class="w-100 h-100" frameborder="0"></iframe>
                        </div>

                        <!-- Word/Doc Viewer -->
                        <div id="docViewer" class="h-100 p-4" style="display: none; overflow-y: auto;">
                            <div id="docContent" class="bg-white p-4 border rounded shadow-sm">
                                <!-- Word content will be loaded here -->
                            </div>
                        </div>

                        <!-- Error State -->
                        <div id="previewError" class="d-flex justify-content-center align-items-center h-100"
                            style="display: none;">
                            <div class="text-center">
                                <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                                <h5>Tidak dapat menampilkan preview</h5>
                                <p class="text-muted mb-3">File ini tidak dapat di-preview. Silakan download untuk melihat
                                    isi file.</p>
                                <button type="button" id="downloadFromError" class="btn btn-primary">
                                    <i class="fas fa-download me-1"></i>Download File
                                </button>
                            </div>
                        </div>

                        <!-- Unsupported Format -->
                        <div id="unsupportedFormat" class="d-flex justify-content-center align-items-center h-100"
                            style="display: none;">
                            <div class="text-center">
                                <i class="fas fa-file fa-3x text-secondary mb-3"></i>
                                <h5>Format file tidak didukung untuk preview</h5>
                                <p class="text-muted mb-3">Preview hanya tersedia untuk file PDF dan Word (.doc/.docx)</p>
                                <button type="button" id="downloadUnsupported" class="btn btn-primary">
                                    <i class="fas fa-download me-1"></i>Download File
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit File Modal - IMPROVED VERSION -->
        <div class="modal fade" id="editFileModal" tabindex="-1" aria-labelledby="editFileModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content rounded-4 gap-5 px-10 py-8">
                    <div class="d-flex justify-content-between align-items-center gap-2">
                        <div class="fs-2 fw-bold text-truncate leading-5" id="editModalTitle">Edit File Kesekretariat
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form id="editFileForm" method="POST" enctype="multipart/form-data" class="d-grid gap-4">
                        @csrf
                        @method('PUT')

                        <!-- Hidden ID Field -->
                        <input type="hidden" name="file_id" id="edit_file_id">

                        <!-- Document Name Field -->
                        <div>
                            <div class="fw-semibold required mb-3 text-gray-800">Nama Dokumen</div>
                            <input type="text" name="nama_dokumen" id="edit_nama_dokumen"
                                placeholder="Masukkan nama dokumen" class="form-control bg-light border border-gray-400"
                                required>
                            <div class="invalid-feedback" id="edit_nama_dokumen_error"></div>
                        </div>

                        <!-- Document Date Field -->
                        <div>
                            <div class="fw-semibold required mb-3 text-gray-800">Tanggal Dokumen</div>
                            <input type="date" name="tanggal_dokumen" id="edit_tanggal_dokumen"
                                class="form-control bg-light border border-gray-400" required>
                            <div class="invalid-feedback" id="edit_tanggal_dokumen_error"></div>
                            <div class="form-text text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Pilih tanggal pembuatan atau tanggal berlaku dokumen
                            </div>
                        </div>



                        <!-- Optional New File Upload -->
                        <!-- SAMAKAN: Dropzone seperti di tambah -->
                        <div>
                            <div class="fw-semibold mb-3 text-gray-800">
                                Ganti File (Opsional)
                                <small class="text-muted fw-normal">- Biarkan kosong jika tidak ingin mengganti
                                    file</small>
                            </div>
                            <div class="dropzone" id="dropzone-editFileForm">
                                <div class="dz-message needsclick">
                                    <i class="ki-duotone ki-file-up fs-3x text-primary">
                                        <span class="path1"></span><span class="path2"></span>
                                    </i>
                                    <div class="ms-4">
                                        <h3 class="fs-5 fw-bold mb-1 text-gray-900">Seret atau pilih dokumen baru.</h3>
                                        <span class="fs-7 fw-semibold text-gray-500">
                                            Format: PDF, DOC, DOCX, XLS, XLSX. Max. 10 MB.
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <input type="file" name="dokumen_file" id="edit_dokumen_file_input"
                                style="display: none;" accept=".pdf,.doc,.docx,.xls,.xlsx">
                            <div class="invalid-feedback" id="edit_dokumen_file_error"></div>
                        </div>
                    </form>

                    <!-- Submit Button -->
                    <div class="d-grid py-4">
                        <button type="button" onclick="submitEditForm()" id="editSubmitBtn"
                            class="bg-danger fw-bold d-flex align-items-center justify-content-center gap-2 rounded border-0 p-4 text-white">
                            <i class="fas fa-save me-1"></i>Update File
                        </button>
                    </div>
                </div>
            </div>
        </div>

    @endsection

@section('script')
    <script>
        
        function deleteFile(fileId, fileName, deleteUrl) {
    Swal.fire({
        title: "Apakah Anda Yakin?",
        html: `<p style='text-align:center'>Setelah <strong>${fileName}</strong> dihapus, Anda tidak bisa mengembalikannya!</p>`,
        icon: "warning",
        showCancelButton: true,
        reverseButtons: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Hapus!',
        cancelButtonText: 'Batalkan!'
    }).then((result) => {
        if (result.isConfirmed) {
            // Show loading
            Swal.fire({
                title: 'Menghapus...',
                text: 'Mohon tunggu',
                allowOutsideClick: false,
                showConfirmButton: false,
                willOpen: () => Swal.showLoading()
            });

            // Setup CSRF token
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: deleteUrl,
                type: 'DELETE',
                success: function(response) {
                    Swal.close();
                    if (response.success) {
                        // Show success message
                        Swal.fire({
                            title: 'Berhasil!',
                            text: response.message || 'File berhasil dihapus',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        });

                        // Remove the row from DOM immediately
                        $(`#file-row-${fileId}`).fadeOut(300, function() {
                            $(this).remove();
                            
                            // Check if table is now empty
                            const remainingRows = $('#tableBody tr:visible').length;
                            if (remainingRows === 0) {
                                showEmptyState();
                            } else {
                                // Renumber remaining rows
                                renumberTableRows();
                            }
                        });

                        // Also refresh the table data to ensure consistency
                        setTimeout(() => {
                            performSearch({}, false); // false = don't show loading indicator
                        }, 500);

                    } else {
                        Swal.fire({
                            title: 'Gagal!',
                            text: response.message || 'Terjadi kesalahan saat menghapus',
                            icon: 'error'
                        });
                    }
                },
                error: function(xhr) {
                    Swal.close();
                    let errorMessage = 'Terjadi kesalahan saat menghapus file';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    Swal.fire({
                        title: 'Error!',
                        text: errorMessage,
                        icon: 'error'
                    });
                }
            });
        } else {
            Swal.fire({
                title: "Aksi Dibatalkan",
                icon: "info",
                timer: 1500,
                showConfirmButton: false
            });
        }
    });
}
        // Show empty state when no files
        function showEmptyState() {
            $('#tableBody').html(`
                <tr id="emptyStateMessage">
                    <td colspan="4" class="text-center py-5">
                        <div class="empty-state">
                            <i class="fas fa-folder-open"></i>
                            <h4>Belum ada file</h4>
                            <p>Tambahkan file pertama Anda dengan mengklik tombol "Tambah File"</p>
                        </div>
                    </td>
                </tr>
            `);
        }

        // File preview function
        function previewFile(fileUrl, fileName, fileExtension) {
            const modal = new bootstrap.Modal(document.getElementById('filePreviewModal'));
            const previewFileName = document.getElementById('previewFileName');
            const pdfFrame = document.getElementById('pdfFrame');

            // Reset all viewers
            document.getElementById('pdfViewer').style.display = 'none';
            document.getElementById('docViewer').style.display = 'none';
            document.getElementById('previewError').style.display = 'none';
            document.getElementById('unsupportedFormat').style.display = 'none';

            previewFileName.textContent = fileName;

            if (['pdf', 'doc', 'docx', 'xls', 'xlsx'].includes(fileExtension.toLowerCase())) {
                const googleViewerUrl = `https://docs.google.com/viewer?url=${encodeURIComponent(fileUrl)}&embedded=true`;
                document.getElementById('pdfViewer').style.display = 'block';
                pdfFrame.src = googleViewerUrl;
            } else {
                document.getElementById('unsupportedFormat').style.display = 'block';
            }

            modal.show();
        }

        // Get file icon based on extension
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

        // Get file icon for preview/current file
        function getFileIconForPreview(extension) {
            const icons = {
                'pdf': 'fas fa-file-pdf text-danger',
                'doc': 'fas fa-file-word text-primary',
                'docx': 'fas fa-file-word text-primary',
                'xls': 'fas fa-file-excel text-success',
                'xlsx': 'fas fa-file-excel text-success'
            };
            return icons[extension] || 'fas fa-file text-secondary';
        }

        // Alias for consistency
        function getFileIconForCurrentFile(extension) {
            return getFileIconForPreview(extension);
        }

        // Add file icons to existing links
        function addFileIcons() {
            $('.file-link').each(function() {
                if ($(this).find('i').length === 0) {
                    const fileName = $(this).text().trim();
                    const extension = fileName.split('.').pop();
                    const iconClass = getFileIcon(extension);
                    $(this).prepend(`<i class="${iconClass}"></i>`);
                }
            });
        }

        // Debounce utility function
        function debounce(func, delay) {
            let timeout;
            return function() {
                const context = this, args = arguments;
                clearTimeout(timeout);
                timeout = setTimeout(() => func.apply(context, args), delay);
            };
        }

        // Main document ready function
        $(document).ready(function() {
            // Debounced search for live filtering
            const debouncedSearch = debounce(function() {
                performSearch({ page: 1 }, true);
            }, 300);

            $(document).on('input', 'input[name="search"]', debouncedSearch);
            
            // Also trigger search on Enter key
            $(document).on('keypress', 'input[name="search"]', function(e) {
                if (e.which === 13) { // Enter key
                    e.preventDefault();
                    performSearch({ page: 1 }, true);
                }
            });
            let isLoading = false;
            let searchTimeout;
            let editDropzoneInitialized = false;

            const baseUrl = "{{ route('admin.file-kesekretariat.index') }}";

            // Form validation helpers
            function clearFormErrors() {
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').empty();
                $('#dropzone-tambahFileForm').removeClass('error');
                $('#nama_dokumen_error').empty();
                $('#tanggal_dokumen_error').empty();
                $('#dokumen_file_error').empty();
            }

            function showFormErrors(errors) {
                clearFormErrors();
                $.each(errors, function(field, messages) {
                    const input = $(`input[name="${field}"]`);
                    const errorDiv = $(`#${field}_error`);
                    input.addClass('is-invalid');
                    errorDiv.text(messages[0]);
                });
            }

            // Real-time validation
            $(document).on('input', '#tambahFileForm input[name="nama_dokumen"]', function() {
                if ($(this).val().trim()) {
                    $(this).removeClass('is-invalid');
                    $('#nama_dokumen_error').empty();
                }
            });

            $(document).on('input', '#edit_nama_dokumen', function() {
                const value = $(this).val().trim();
                if (value) {
                    $(this).removeClass('is-invalid');
                    $('#edit_nama_dokumen_error').empty();
                }
            });

            $(document).on('change', '#tambahFileForm input[name="tanggal_dokumen"]', function() {
                if ($(this).val()) {
                    $(this).removeClass('is-invalid');
                    $('#tanggal_dokumen_error').empty();
                }
            });

            $(document).on('change', '#edit_tanggal_dokumen', function() {
                const value = $(this).val();
                if (value) {
                    $(this).removeClass('is-invalid');
                    $('#edit_tanggal_dokumen_error').empty();
                }
            });

            // Dropdown functionality
            $(document).on('click', '.dropdown-toggle-custom', function(e) {
                e.stopPropagation();
                const $menu = $(this).next('.dropdown-menu-custom');
                $('.dropdown-menu-custom').not($menu).removeClass('show');
                $menu.toggleClass('show');
            });

            $(document).on('click', function() {
                $('.dropdown-menu-custom').removeClass('show');
                $('.dropdown-menu-action').removeClass('show');
            });

            $(document).on('click', '.dropdown-menu-action', function(e) {
                e.stopPropagation();
            });

            // Initialize add file dropzone
            function initializeCustomDropzone() {
                const dropzoneElement = document.getElementById('dropzone-tambahFileForm');
                if (!dropzoneElement) return;

                // Replace element to remove previous listeners
                const newDropzoneElement = dropzoneElement.cloneNode(true);
                dropzoneElement.parentNode.replaceChild(newDropzoneElement, dropzoneElement);

                // Ensure file input exists
                let fileInput = document.getElementById('dokumen_file_input');
                if (!fileInput) {
                    fileInput = document.createElement('input');
                    fileInput.type = 'file';
                    fileInput.name = 'dokumen_file';
                    fileInput.id = 'dokumen_file_input';
                    fileInput.accept = '.pdf,.doc,.docx,.xls,.xlsx';
                    fileInput.style.display = 'none';
                    fileInput.required = true;
                    document.getElementById('tambahFileForm').appendChild(fileInput);
                } else {
                    fileInput.value = '';
                }

                let dragCounter = 0;

                // Click to select file
                newDropzoneElement.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    fileInput.click();
                });

                // File selection handler
                fileInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        handleFileSelection(file, newDropzoneElement);
                    }
                });

                // Drag and drop handlers
                newDropzoneElement.addEventListener('dragenter', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    dragCounter++;
                    newDropzoneElement.classList.add('drag-over');
                });

                newDropzoneElement.addEventListener('dragleave', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    dragCounter--;
                    if (dragCounter === 0) {
                        newDropzoneElement.classList.remove('drag-over');
                    }
                });

                newDropzoneElement.addEventListener('dragover', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                });

                newDropzoneElement.addEventListener('drop', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    dragCounter = 0;
                    newDropzoneElement.classList.remove('drag-over');

                    const files = e.dataTransfer.files;
                    if (files.length > 0) {
                        const file = files[0];
                        const dt = new DataTransfer();
                        dt.items.add(file);
                        fileInput.files = dt.files;
                        handleFileSelection(file, newDropzoneElement);
                    }
                });
            }

            // Handle file selection and validation
            function handleFileSelection(file, dropzoneElement) {
                const maxSize = 10 * 1024 * 1024; // 10MB
                const allowedTypes = [
                    'application/pdf',
                    'application/msword',
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    'application/vnd.ms-excel',
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                ];

                const errorDiv = document.getElementById('dokumen_file_error');
                errorDiv.textContent = '';
                dropzoneElement.classList.remove('error');

                if (file.size > maxSize) {
                    errorDiv.textContent = 'Ukuran file tidak boleh lebih dari 10MB';
                    dropzoneElement.classList.add('error');
                    return false;
                }

                if (!allowedTypes.includes(file.type)) {
                    errorDiv.textContent = 'Format file tidak didukung. Gunakan PDF, DOC, DOCX, XLS, atau XLSX';
                    dropzoneElement.classList.add('error');
                    return false;
                }

                const fileInput = document.getElementById('dokumen_file_input');
                const dt = new DataTransfer();
                dt.items.add(file);
                fileInput.files = dt.files;

                showFilePreview(file, dropzoneElement);
                return true;
            }

            // Show file preview in dropzone
            function showFilePreview(file, dropzoneElement) {
                const fileExtension = file.name.split('.').pop().toLowerCase();
                const fileIcon = getFileIconForPreview(fileExtension);
                const fileSize = (file.size / (1024 * 1024)).toFixed(2);

                dropzoneElement.innerHTML = `
                    <div class="file-preview d-flex align-items-center justify-content-between p-3 bg-light rounded">
                        <div class="d-flex align-items-center">
                            <i class="${fileIcon} fa-2x me-3"></i>
                            <div>
                                <div class="fw-bold text-truncate" style="max-width: 200px;" title="${file.name}">
                                    ${file.name}
                                </div>
                                <small class="text-muted">${fileSize} MB</small>
                            </div>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-danger remove-file" onclick="removeSelectedFile()">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                `;
            }

            // Remove selected file
            function removeSelectedFile() {
                const dropzoneElement = document.getElementById('dropzone-tambahFileForm');
                const fileInput = document.getElementById('dokumen_file_input');

                if (fileInput) {
                    fileInput.value = '';
                }

                dropzoneElement.innerHTML = `
                    <div class="dz-message needsclick">
                        <i class="ki-duotone ki-file-up fs-3x text-primary">
                            <span class="path1"></span><span class="path2"></span>
                        </i>
                        <div class="ms-4">
                            <h3 class="fs-5 fw-bold mb-1 text-gray-900">Seret atau pilih dokumen.</h3>
                            <span class="fs-7 fw-semibold text-gray-500">Format: PDF, DOC, DOCX, XLS, XLSX. Max. 10 MB.</span>
                        </div>
                    </div>
                `;

                const errorDiv = document.getElementById('dokumen_file_error');
                if (errorDiv) {
                    errorDiv.textContent = '';
                }
                dropzoneElement.classList.remove('error');
            }

            // Initialize edit file dropzone
            function initializeEditDropzone() {
                const dropzoneElement = document.getElementById('dropzone-editFileForm');
                if (!dropzoneElement) return;

                const newDropzoneElement = dropzoneElement.cloneNode(true);
                dropzoneElement.parentNode.replaceChild(newDropzoneElement, dropzoneElement);

                let fileInput = document.getElementById('edit_dokumen_file_input');
                if (!fileInput) {
                    fileInput = document.createElement('input');
                    fileInput.type = 'file';
                    fileInput.name = 'dokumen_file';
                    fileInput.id = 'edit_dokumen_file_input';
                    fileInput.accept = '.pdf,.doc,.docx,.xls,.xlsx';
                    fileInput.style.display = 'none';
                    document.getElementById('editFileForm').appendChild(fileInput);
                }

                let dragCounter = 0;

                newDropzoneElement.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    fileInput.click();
                });

                fileInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        handleEditFileSelection(file, newDropzoneElement);
                    }
                });

                // Drag and drop handlers
                newDropzoneElement.addEventListener('dragenter', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    dragCounter++;
                    newDropzoneElement.classList.add('drag-over');
                });

                newDropzoneElement.addEventListener('dragleave', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    dragCounter--;
                    if (dragCounter === 0) {
                        newDropzoneElement.classList.remove('drag-over');
                    }
                });

                newDropzoneElement.addEventListener('dragover', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                });

                newDropzoneElement.addEventListener('drop', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    dragCounter = 0;
                    newDropzoneElement.classList.remove('drag-over');

                    const files = e.dataTransfer.files;
                    if (files.length > 0) {
                        const file = files[0];
                        const dt = new DataTransfer();
                        dt.items.add(file);
                        fileInput.files = dt.files;
                        handleEditFileSelection(file, newDropzoneElement);
                    }
                });
            }

            function handleEditFileSelection(file, dropzoneElement) {
                const maxSize = 10 * 1024 * 1024; // 10MB
                const allowedTypes = [
                    'application/pdf',
                    'application/msword',
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    'application/vnd.ms-excel',
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                ];

                const errorDiv = document.getElementById('edit_dokumen_file_error');
                if (errorDiv) errorDiv.textContent = '';
                dropzoneElement.classList.remove('error');

                if (file.size > maxSize) {
                    if (errorDiv) errorDiv.textContent = 'Ukuran file tidak boleh lebih dari 10MB';
                    dropzoneElement.classList.add('error');
                    return false;
                }

                if (!allowedTypes.includes(file.type)) {
                    if (errorDiv) errorDiv.textContent = 'Format file tidak didukung. Gunakan PDF, DOC, DOCX, XLS, atau XLSX';
                    dropzoneElement.classList.add('error');
                    return false;
                }

                const fileInput = document.getElementById('edit_dokumen_file_input');
                const dt = new DataTransfer();
                dt.items.add(file);
                fileInput.files = dt.files;

                showEditFilePreview(file, dropzoneElement);
                return true;
            }

            function showEditFilePreview(file, dropzoneElement) {
                const fileExtension = file.name.split('.').pop().toLowerCase();
                const fileIcon = getFileIconForPreview(fileExtension);
                const fileSize = (file.size / (1024 * 1024)).toFixed(2);

                dropzoneElement.innerHTML = `
                    <div class="file-preview d-flex align-items-center justify-content-between p-3 bg-light rounded">
                        <div class="d-flex align-items-center">
                            <i class="${fileIcon} fa-2x me-3"></i>
                            <div>
                                <div class="fw-bold text-truncate" style="max-width: 200px;" title="${file.name}">
                                    ${file.name}
                                </div>
                                <small class="text-muted">${fileSize} MB</small>
                            </div>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-danger remove-file" onclick="removeEditSelectedFile()">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                `;
            }

            function removeEditSelectedFile() {
                const dropzoneElement = document.getElementById('dropzone-editFileForm');
                const fileInput = document.getElementById('edit_dokumen_file_input');

                if (fileInput) {
                    fileInput.value = '';
                }

                dropzoneElement.innerHTML = `
                    <div class="dz-message needsclick">
                        <i class="ki-duotone ki-file-up fs-3x text-primary">
                            <span class="path1"></span><span class="path2"></span>
                        </i>
                        <div class="ms-4">
                            <h3 class="fs-5 fw-bold mb-1 text-gray-900">Seret atau pilih dokumen baru.</h3>
                            <span class="fs-7 fw-semibold text-gray-500">Format: PDF, DOC, DOCX, XLS, XLSX. Max. 10 MB.</span>
                        </div>
                    </div>
                `;

                const errorDiv = document.getElementById('edit_dokumen_file_error');
                if (errorDiv) {
                    errorDiv.textContent = '';
                }
                dropzoneElement.classList.remove('error');
            }

            // Edit modal functions
            function openEditModal(id, nama, tanggal, fileName) {
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').empty();

                $('#edit_file_id').val(id);
                $('#edit_nama_dokumen').val(nama || '');

                // Format date for input
                let formattedDate = '';
                if (tanggal) {
                    const date = new Date(tanggal);
                    if (!isNaN(date.getTime())) {
                        const year = date.getFullYear();
                        const month = String(date.getMonth() + 1).padStart(2, '0');
                        const day = String(date.getDate()).padStart(2, '0');
                        formattedDate = `${year}-${month}-${day}`;
                    }
                }
                $('#edit_tanggal_dokumen').val(formattedDate);

                // Update current file display
                if (fileName) {
                    const fileExtension = fileName.split('.').pop().toLowerCase();
                    const fileIcon = getFileIconForCurrentFile(fileExtension);
                    $('#currentFileName').text(fileName);
                    $('#currentFileIcon').attr('class', `${fileIcon} fa-2x me-3`);
                }

                $('#editFileForm').attr('action', `/admin/file-kesekretariat/${id}`);
                $('#editFileModal').modal('show');
            }

            // Submit edit form
            function submitEditForm() {
    const form = $('#editFileForm');
    const formData = new FormData(form[0]);
    const fileId = $('#edit_file_id').val();

    // Manual validation
    let isValid = true;
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').empty();

    const namaDokumen = $('#edit_nama_dokumen').val().trim();
    if (!namaDokumen) {
        $('#edit_nama_dokumen_error').text('Nama dokumen wajib diisi');
        $('#edit_nama_dokumen').addClass('is-invalid');
        isValid = false;
    }

    const tanggalDokumen = $('#edit_tanggal_dokumen').val();
    if (!tanggalDokumen) {
        $('#edit_tanggal_dokumen_error').text('Tanggal dokumen wajib diisi');
        $('#edit_tanggal_dokumen').addClass('is-invalid');
        isValid = false;
    }

    if (!isValid) {
        return false;
    }

    const submitBtn = $('#editSubmitBtn');
    const originalText = submitBtn.html();

    $.ajax({
        url: `/admin/file-kesekretariat/${fileId}`,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'X-Requested-With': 'XMLHttpRequest'
        },
        beforeSend: function() {
            submitBtn.prop('disabled', true)
                .html('<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Menyimpan...');
        },
        success: function(response) {
            $('#editFileModal').modal('hide');
            toastr.success(response.message || 'File berhasil diperbarui', 'Berhasil!');
            
            // PERBAIKAN: Force refresh table dengan parameter saat ini
            setTimeout(function() {
                const currentSearch = $('input[name="search"]').val();
                const currentUrl = new URLSearchParams(window.location.search);
                const currentPage = currentUrl.get('page') || 1;
                const currentSortBy = currentUrl.get('sort_by') || 'created_at';
                const currentOrder = currentUrl.get('order') || 'desc';
                
                const searchParams = {
                    page: currentPage,
                    sort_by: currentSortBy,
                    order: currentOrder
                };
                
                if (currentSearch && currentSearch.trim()) {
                    searchParams.search = currentSearch;
                }
                
                performSearch(searchParams, true);
            }, 300);
        },
        error: function(xhr) {
            if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                let errors = xhr.responseJSON.errors;
                $.each(errors, function(key, value) {
                    $(`#edit_${key}`).addClass('is-invalid');
                    $(`#edit_${key}_error`).text(value[0]);
                });
            } else {
                let errorMessage = 'Terjadi kesalahan saat memperbarui file';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                toastr.error(errorMessage, 'Error!');
            }
        },
        complete: function() {
            submitBtn.prop('disabled', false).html(originalText);
        }
    });
}


            // Initialize event handlers
            function initializeEventHandlers() {
    // Remove existing handlers
    $(document).off('click.sorting', 'th.sortable');
    $(document).off('click.dropdown', '.dropdown-toggle-action');
    $(document).off('click.delete', '.delete-btn');
    $(document).off('click.pagination', '.pagination-link'); // Ubah selector ini

    // Sorting functionality
    $(document).on('click.sorting', 'th.sortable', function(e) {
        e.preventDefault();
        const sortBy = $(this).data('sort');
        let currentOrder = $(this).data('order') || 'asc';
        const newOrder = currentOrder === 'asc' ? 'desc' : 'asc';
        $(this).data('order', newOrder);
        performSearch({
            page: 1,
            sort_by: sortBy,
            order: newOrder
        }, true);
    });

                // Dropdown functionality
                $(document).on('click.dropdown', '.dropdown-toggle-action, .dropdown-toggle-custom', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $('.dropdown-menu-action, .dropdown-menu-custom').removeClass('show');
        $(this).next('.dropdown-menu-action, .dropdown-menu-custom').toggleClass('show');
    });


                // Pagination functionality
               $(document).on('click.pagination', '.pagination-link', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        const url = $(this).attr('href');
        console.log('Pagination clicked:', url); // Debug log
        
        if (url && url !== '#' && !$(this).hasClass('disabled')) {
            const urlParams = new URLSearchParams(url.split('?')[1]);
            const page = urlParams.get('page');
            
            if (page) {
                console.log('Going to page:', page); // Debug log
                
                // Get current search and sort parameters
                const currentSearch = $('input[name="search"]').val();
                const currentSortBy = getUrlParameter('sort_by') || 'created_at';
                const currentOrder = getUrlParameter('order') || 'desc';
                const currentPerPage = getUrlParameter('per_page') || '10';
                
                const searchParams = {
                    page: page,
                    sort_by: currentSortBy,
                    order: currentOrder,
                    per_page: currentPerPage
                };
                
                if (currentSearch && currentSearch.trim()) {
                    searchParams.search = currentSearch;
                }
                
                performSearch(searchParams, true);
            }
        }
    });
}
            // Perform AJAX search
            function performSearch(params = {}, showLoadingIndicator = true) {
    if (isLoading) return;

    if (showLoadingIndicator) showLoading();

    const searchParams = new URLSearchParams();
    const search = $('#filter input[name="search"]').val().trim();
    
    // Get current URL parameters to maintain state
    const currentUrl = new URLSearchParams(window.location.search);

    if (search) searchParams.set('search', search);
    if (params.page) searchParams.set('page', params.page);
    if (params.per_page) searchParams.set('per_page', params.per_page);
    if (params.sort_by) searchParams.set('sort_by', params.sort_by);
    if (params.order) searchParams.set('order', params.order);

    // Keep existing parameters if not being changed
    if (!params.sort_by && !params.order) {
        const sortBy = currentUrl.get('sort_by') || 'created_at';
        const order = currentUrl.get('order') || 'desc';
        searchParams.set('sort_by', sortBy);
        searchParams.set('order', order);
    }
    
    // Keep per_page if not specified
    if (!params.per_page) {
        const perPage = currentUrl.get('per_page') || '10';
        searchParams.set('per_page', perPage);
    }

    const baseUrl = "{{ route('admin.file-kesekretariat.index') }}";
    const url = `${baseUrl}?${searchParams.toString()}`;

    $.ajax({
        url: url,
        type: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'text/html'
        },
        beforeSend: function() {
            $('#tableContainer').addClass('table-loading');
        },
        success: function(response) {
            $('#tableContainer').removeClass('table-loading');
            $('#tableContainer').html(response);
            
            initializeEventHandlers();
            addFileIcons();

            // Update URL without refreshing page
            window.history.pushState({}, '', url);
            
            // Scroll to top of table if it's a new search
            if (params.page === 1 || params.search !== undefined) {
                $('html, body').animate({
                    scrollTop: $('#tableContainer').offset().top - 100
                }, 300);
            }
        },
        error: function(xhr, status, error) {
            $('#tableContainer').removeClass('table-loading');
            $('#tableContainer').html(
                '<div class="py-20 text-center text-danger fw-bold">Terjadi kesalahan saat memuat data.</div>'
            );
            console.error('Search error:', error);
            toastr.error('Terjadi kesalahan saat mencari data', 'Error!');
        },
        complete: function() {
            hideLoading();
        }
    });
}

// Additional helper function to show/hide loading
function showLoading() {
    isLoading = true;
    $('.search-loading').show();
}

function hideLoading() {
    isLoading = false;
    $('.search-loading').hide();
}

            // Renumber table rows
            function renumberTableRows() {
                $('#tableBody tr:visible').each(function(index) {
                    $(this).find('td:first-child').text(index + 1);
                });
            }

            // Submit form for adding new file
            function submitForm(formId) {
    const form = $('#' + formId);
    const formData = new FormData(form[0]);

    // Manual validation
    let isValid = true;

    const namaDokumen = form.find('input[name="nama_dokumen"]').val().trim();
    if (!namaDokumen) {
        $('#nama_dokumen_error').text('Nama dokumen wajib diisi');
        form.find('input[name="nama_dokumen"]').addClass('is-invalid');
        isValid = false;
    }

    const tanggalDokumen = form.find('input[name="tanggal_dokumen"]').val();
    if (!tanggalDokumen) {
        $('#tanggal_dokumen_error').text('Tanggal dokumen wajib diisi');
        form.find('input[name="tanggal_dokumen"]').addClass('is-invalid');
        isValid = false;
    }

    const fileInput = document.getElementById('dokumen_file_input');
    if (!fileInput.files || fileInput.files.length === 0) {
        $('#dokumen_file_error').text('File dokumen wajib diunggah');
        $('#dropzone-tambahFileForm').addClass('error');
        isValid = false;
    }

    if (!isValid) {
        const firstError = $('.is-invalid, .error').first();
        if (firstError.length) {
            $('html, body').animate({
                scrollTop: firstError.offset().top - 100
            }, 500);
        }
        return false;
    }

    const submitBtn = $('#submitBtn');
    const originalText = submitBtn.html();

    $.ajax({
        url: form.attr('action'),
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function() {
            submitBtn.prop('disabled', true)
                .html('<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Menyimpan...');
        },
        success: function(response) {
            $('#tambahFileModal').modal('hide');
            toastr.success(response.message || 'File berhasil ditambahkan', 'Berhasil!');
            
            form.trigger('reset');
            clearFormErrors();
            removeSelectedFile();
            
            // PERBAIKAN: Force refresh table dengan sorting yang tepat
            setTimeout(function() {
                // Get current search parameters
                const currentSearch = $('input[name="search"]').val();
                const searchParams = {
                    page: 1,
                    sort_by: 'created_at',
                    order: 'desc'
                };
                
                // Add search if exists
                if (currentSearch && currentSearch.trim()) {
                    searchParams.search = currentSearch;
                }
                
                // Force refresh the entire table
                performSearch(searchParams, true);
                
                // Remove empty state if exists
                $('#emptyStateMessage').remove();
            }, 300);
        },
        error: function(xhr) {
            if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                showFormErrors(xhr.responseJSON.errors);
                const firstError = $('.is-invalid, .error').first();
                if (firstError.length) {
                    $('html, body').animate({
                        scrollTop: firstError.offset().top - 100
                    }, 500);
                }
            } else {
                let errorMessage = 'Terjadi kesalahan saat menyimpan file';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                toastr.error(errorMessage, 'Error!');
            }
        },
        complete: function() {
            submitBtn.prop('disabled', false).html(originalText);
        }
    });
}


            // Append new row to table
            function appendNewRowToTable(fileData) {
                const tableBody = $('#tableBody');
                const newRow = `
                    <tr id="file-row-${fileData.id}" class="fade-in-row">
                        <td class="text-center">${tableBody.children().length + 1}</td>
                        <td>
                            <div class="document-info">
                                <div class="document-name-display">
                                    <a href="#" class="document-name" onclick="previewFile('${fileData.file_url}', '${fileData.nama_dokumen}', '${fileData.extension}')">
    ${fileData.nama_dokumen}
</a>
                                </div>
                                <div class="document-date">${fileData.tanggal_dokumen_formatted}</div>
                            </div>
                        </td>
                        <td>
    <a href="${fileData.file_url}" class="file-link" target="_blank">
        <i class="fas fa-download"></i>
        ${fileData.dokumen_file}
    </a>
</td>
                        <td class="text-center">
                            <div class="dropdown-action">
                                <button class="dropdown-toggle-action" type="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"/>
                                    </svg>
                                </button>
                                <div class="dropdown-menu-action">
                                    <button class="dropdown-item-action btn-edit" 
                                            data-id="${fileData.id}"
                                            data-nama="${fileData.nama_dokumen}"
                                            data-tanggal="${fileData.tanggal_dokumen}"
                                            data-filename="${fileData.dokumen_file}">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <button class="dropdown-item-action text-danger" 
                                            onclick="deleteFile(${fileData.id}, '${fileData.nama_dokumen}', '/admin/file-kesekretariat/${fileData.id}')">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                `;
                
                tableBody.prepend(newRow);
                $(`#file-row-${fileData.id}`).hide().fadeIn(300);
                renumberTableRows();
                $('#emptyStateMessage').remove();
            }

            // Update existing row
            function updateExistingRow(fileData) {
                const row = $(`#file-row-${fileData.id}`);
                if (row.length) {
                    row.html(`
                        <td class="text-center">${row.find('td:first-child').text()}</td>
                        <td>
                            <div class="document-info">
                                <div class="document-name-display">
                                    <a href="#" class="document-name" onclick="previewFile('${fileData.file_url}', '${fileData.nama_dokumen}', '${fileData.extension}')">
                                        <i class="${getFileIcon(fileData.extension)}"></i>
                                        ${fileData.nama_dokumen}
                                    </a>
                                </div>
                                <div class="document-date">${fileData.tanggal_dokumen_formatted}</div>
                            </div>
                        </td>
                        <td>
                            <a href="${fileData.file_url}" class="file-link" target="_blank">
                                <i class="fas fa-download"></i>
                                ${fileData.dokumen_file}
                            </a>
                        </td>
                        <td class="text-center">
                            <div class="dropdown-action">
                                <button class="dropdown-toggle-action" type="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"/>
                                    </svg>
                                </button>
                                <div class="dropdown-menu-action">
                                    <button class="dropdown-item-action btn-edit" 
                                            data-id="${fileData.id}"
                                            data-nama="${fileData.nama_dokumen}"
                                            data-tanggal="${fileData.tanggal_dokumen}"
                                            data-filename="${fileData.dokumen_file}">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <button class="dropdown-item-action text-danger" 
                                            onclick="deleteFile(${fileData.id}, '${fileData.nama_dokumen}', '/admin/file-kesekretariat/${fileData.id}')">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </div>
                            </div>
                        </td>
                    `);
                }
            }

            // Make functions globally available
            window.submitForm = submitForm;
            window.deleteFile = deleteFile;
            window.performSearch = performSearch;
            window.removeSelectedFile = removeSelectedFile;
            window.removeEditSelectedFile = removeEditSelectedFile;
            window.openEditModal = openEditModal;
            window.submitEditForm = submitEditForm;
            window.getFileIconForCurrentFile = getFileIconForCurrentFile;

            // Initialize event handlers on page load
            initializeEventHandlers();
            addFileIcons();

            // Button click handlers
            $('#tambahFileBtn').on('click', function() {
                $('#tambahFileModal').modal('show');
            });

            // Handle form submission for adding new file
            $('#tambahFileModal').on('shown.bs.modal', function() {
                $('#tambahFileForm').off('submit').on('submit', function(e) {
                    e.preventDefault();
                    submitForm('tambahFileForm');
                });
            });

            // Auto search on input
            $('#filter input[name="search"]').on('input', function() {
                performSearch({page: 1}, true);
            });

            // Reset modal when closed
            $('#tambahFileModal').on('hidden.bs.modal', function() {
                $('#tambahFileForm').trigger('reset');
                clearFormErrors();
                removeSelectedFile();
            });

            // Initialize dropzone when modal is shown
            $('#tambahFileModal').on('shown.bs.modal', function() {
                initializeCustomDropzone();
            });

            // Edit modal event handlers
            $('#editFileModal').on('shown.bs.modal', function() {
                if (!editDropzoneInitialized) {
                    initializeEditDropzone();
                    editDropzoneInitialized = true;
                }
            });

            $('#editFileModal').on('hidden.bs.modal', function() {
                $('#editFileForm')[0].reset();
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').empty();
                $('#currentFileName').text('-');
                $('#currentFileIcon').attr('class', 'fas fa-file fa-2x me-3 text-secondary');
                removeEditSelectedFile();
            });

            // Edit button click handler
            $(document).on('click', '.btn-edit', function() {
                const id = $(this).data('id');
                const nama = $(this).data('nama');
                const tanggal = $(this).data('tanggal');
                const filename = $(this).data('filename');
                openEditModal(id, nama, tanggal, filename);
            });

            // Per page dropdown
            $(document).on('change', 'select[name="per_page"]', function() {
                const perPage = $(this).val();
                performSearch({page: 1, per_page: perPage}, true);
            });
        });

        // CSS for animations
        const style = document.createElement('style');
        style.textContent = `
            .fade-in-row {
                animation: fadeIn 0.3s ease-in;
            }
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(-10px); }
                to { opacity: 1; transform: translateY(0); }
            }
        `;
        document.head.append(style);

        // Utility functions
        function updatePerPage(perPage) {
            const searchParams = new URLSearchParams(window.location.search);
            searchParams.set('per_page', perPage);
            searchParams.delete('page');
            const url = "{{ route('admin.file-kesekretariat.index') }}?" + searchParams.toString();
            window.location.href = url;
        }

        function resetAllFilters() {
            $('#filter input[name="search"]').val('');
            $('#filter-file-type').val('');
            $('#filter input[name="search"]').trigger('input');
        }
    </script>
@endsection
