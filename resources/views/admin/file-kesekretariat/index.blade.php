@extends('layouts.app')

@section('pageTitle', 'Manajemen File')
@section('mainSection', 'Menu Utama')
@section('currentSection', 'File Kesekretariat')

@section('style')
    <style>                                                                                                                                                                                                                                                                                                                                  ================================= */
        body {
            background-color: #f5f5f5;
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

.table td:nth-child(2),
.table th:nth-child(2) {
    max-width: 300px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

/* 📌 Kolom File Dokumen */
.table td:nth-child(3),
.table th:nth-child(3) {
    max-width: 300px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
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

        /* File Link Text */
        .file-link-text {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            flex: 1;
        }

        /* File Link Styling */
        .file-link {
            color: #495057;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            padding: 4px 8px;
            border-radius: 4px;
            transition: all 0.2s ease;
            line-height: 1.4;
            width: 100%;
        }

        .file-link:hover {
            background-color: #f8f9fa;
            color: #F8285A;
        }

        /* Document Link Styling (sama seperti di tabel) */
        .document-link-container {
            display: inline-block;
            max-width: 100%;
        }

        .document-link {
            color: #0d6efd !important;
            text-decoration: none !important;
            font-weight: 500;
            font-size: 0.875rem;
            display: inline-flex;
            align-items: center;
            padding: 4px 8px;
            border-radius: 4px;
            transition: all 0.2s ease;
            line-height: 1.4;
            width: 100%;
        }

        .document-link:hover {
            background-color: #e3f2fd;
            color: #1976d2 !important;
            text-decoration: underline !important;
            transform: translateY(-1px);
        }

        .document-link-text {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            flex: 1;
            text-align: left;
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
            padding: 1.5rem;
        }

        .d-grid {
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

        .invalid-feedback.d-block {
            display: block !important;
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

        .dropzone.error + .invalid-feedback {
            display: block !important;
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
            max-width: 100%;
            overflow: hidden;
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
            max-width: 100%;
            overflow-x: hidden;
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
            background-color: #f5f5f5 !important;
            /* Force gray background for entire page */
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

        /* Modal responsive fixes */
        @media (max-width: 768px) {
            .modal-dialog {
                margin: 10px;
                max-width: calc(100% - 20px);
            }

            .modal-content {
                padding: 15px !important;
            }

            .modal-content .d-flex {
                flex-wrap: wrap;
            }

            .document-link-container {
                max-width: 200px;
            }

            .document-link-text {
                max-width: 180px;
            }

            .dz-message .ms-4 {
                margin-left: 0 !important;
                margin-top: 1rem;
                text-align: center;
            }

            .dz-message h3 {
                font-size: 1rem;
            }

            .dz-message span {
                font-size: 0.75rem;
            }
        }

        /* Ensure form elements don't overflow */
        .form-control {
            max-width: 100%;
        }

        /* Modal edit specific fixes */
        #editFileModal .modal-dialog {
            max-width: 600px;
            margin: 1rem auto;
        }

        #editFileModal .modal-content {
            max-width: 100%;
            overflow: hidden;
        }

        /* Ensure all form elements in modal don't cause overflow */
        #editFileModal .form-control,
        #editFileModal input,
        #editFileModal textarea,
        #editFileModal select {
            max-width: 100%;
            width: 100%;
            box-sizing: border-box;
        }

        /* Ensure file link container has fixed max width */
        #editFileModal .document-link-container {
            max-width: calc(100% - 50px);
            width: calc(100% - 50px);
            overflow: hidden;
        }

        #editFileModal .document-link-text {
            max-width: 100%;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* CSS khusus untuk elipsis di bagian File Saat Ini */
        #editFileModal #currentFileName {
            display: block;
            width: 100%;
            text-align: left;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            direction: ltr;
            unicode-bidi: bidi-override;
        }

        /* Kontainer file saat ini dengan lebar tetap */
        #editFileModal .document-link-container {
            width: calc(100% - 50px);
            max-width: calc(100% - 50px);
            overflow: hidden;
        }

        /* Custom tooltip styles */
        .custom-tooltip {
            position: absolute;
            background-color: #333;
            color: #fff;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 12px;
            z-index: 10000;
            white-space: nowrap;
            box-shadow: 0 2px 6px rgba(0,0,0,0.2);
            pointer-events: none;
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
            width: 100%;
            box-sizing: border-box;
            max-width: 100%;
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
                
                <div class="d-flex align-items-center">
                    <form method="GET" id="yearFilterFormFileKesekretariat" class="d-flex align-items-center gap-2">
                        @foreach (request()->except('year') as $k => $v)
                            <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                        @endforeach
                        <select name="year" class="form-select" style="width: 120px"
                            onchange="document.getElementById('yearFilterFormFileKesekretariat').submit()">
                            <option value="">Semua Tahun</option>
                            @if (isset($availableYears) && count($availableYears))
                                @foreach ($availableYears as $year)
                                    <option value="{{ $year }}"
                                        {{ (string) $year === (string) ($selectedYear ?? '') ? 'selected' : '' }}>
                                        {{ $year }}</option>
                                @endforeach
                            @else
                                <option value="{{ now()->year }}" {{ request('year') == now()->year ? 'selected' : '' }}>{{ now()->year }}</option>
                            @endif
                        </select>
                    </form>
                </div>
            </form>
        </div>

        <!-- Main Content -->
        <div class="container">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title fw-bold fs-4 mb-0">Daftar File Kesekretariat</h3>
                </div>
                <div class="card-body">
                    <div id="tableContainer">
                        @include('admin.file-kesekretariat._table', ['files' => $files])
                    </div>
                </div>
            </div>
        </div>

        <!-- Toast Container -->
        <div class="toast-container" id="toast-container"></div>

        <!-- Add File Modal -->
        <div class="modal fade" id="tambahFileModal" tabindex="-1" aria-labelledby="tambahFileModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content rounded-4 gap-5 px-10 py-8">
                    <div class="d-flex justify-content-between align-items-center gap-2" style="flex-wrap: wrap;">
                        <div class="fs-2 fw-bold text-truncate leading-5" id="modalTitle" style="flex: 1; min-width: 0;">Tambah File Kesekretariat</div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="flex-shrink: 0;"></button>
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
                            <div class="dropzone" id="dropzone-tambahFileForm" style="width: 100%; max-width: 100%; box-sizing: border-box;">
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





        <!-- Edit File Modal - IMPROVED VERSION -->
        <div class="modal fade" id="editFileModal" tabindex="-1" aria-labelledby="editFileModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content rounded-4 gap-5 px-10 py-8">
                    <div class="d-flex justify-content-between align-items-center gap-2" style="flex-wrap: wrap;">
                        <div class="fs-2 fw-bold text-truncate leading-5" id="editModalTitle" style="flex: 1; min-width: 0;">Edit File Kesekretariat</div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="flex-shrink: 0;"></button>
                    </div>

                    <form id="editFileForm" method="POST" enctype="multipart/form-data" class="d-grid gap-4" style="width: 100%; max-width: 100%;">
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

                        <!-- Current File Information -->
                        <div class="mb-4 p-3 bg-light rounded">
                            <div class="fw-semibold mb-2 text-gray-800">File Saat Ini</div>
                            <div class="d-flex align-items-start" style="max-width: 100%;">
                                <i id="currentFileIcon" class="fas fa-file fa-2x me-3 text-secondary mt-1 flex-shrink-0"></i>
                                <div class="document-link-container" style="width: calc(100% - 50px); max-width: calc(100% - 50px); overflow: hidden;">
                                    <a href="#" id="currentFileLink" target="_blank" class="document-link" style="display: block; width: 100%;">
                                        <span id="currentFileName" class="document-link-text" style="display: block; width: 100%; text-align: left; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="">-</span>
                                    </a>
                                </div>
                            </div>
                            <div class="text-muted small mt-2">File ini akan diganti jika Anda mengunggah file baru</div>
                        </div>

                        <!-- Optional New File Upload -->
                        <!-- SAMAKAN: Dropzone seperti di tambah -->
                        <div>
                            <div class="fw-semibold mb-3 text-gray-800">
                                Ganti File (Opsional)
                                <small class="text-muted fw-normal">- Biarkan kosong jika tidak ingin mengganti
                                    file</small>
                            </div>
                            <div class="dropzone" id="dropzone-editFileForm" style="width: 100%; max-width: 100%; box-sizing: border-box;">
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

        // Tooltip initialization function
        function initializeTooltips() {
            // Fungsi tooltip custom sederhana
            $('[title]').each(function() {
                const $this = $(this);
                const title = $this.attr('title');

                // Hapus title default dan tambahkan atribut data untuk tooltip custom
                if (title && title.length > 0) {
                    $this.removeAttr('title');
                    $this.attr('data-tooltip', title);

                    // Tambahkan event hover untuk menampilkan tooltip
                    $this.hover(
                        function() {
                            // Mouse enter
                            const tooltipText = $(this).attr('data-tooltip');
                            if (tooltipText && tooltipText.length > 0) {
                                // Buat elemen tooltip
                                const tooltipId = 'custom-tooltip-' + Math.random().toString(36).substr(2, 9);
                                const tooltip = $(`<div id="${tooltipId}" class="custom-tooltip" style="
                                    position: absolute;
                                    background-color: #333;
                                    color: #fff;
                                    padding: 5px 10px;
                                    border-radius: 4px;
                                    font-size: 12px;
                                    z-index: 10000;
                                    white-space: nowrap;
                                    box-shadow: 0 2px 6px rgba(0,0,0,0.2);
                                ">${tooltipText}</div>`);

                                $('body').append(tooltip);

                                // Posisikan tooltip
                                const offset = $(this).offset();
                                const tooltipWidth = tooltip.outerWidth();
                                const elementWidth = $(this).outerWidth();

                                tooltip.css({
                                    top: offset.top - tooltip.outerHeight() - 8,
                                    left: offset.left + (elementWidth / 2) - (tooltipWidth / 2)
                                });

                                // Simpan referensi tooltip
                                $(this).data('tooltip-id', tooltipId);
                            }
                        },
                        function() {
                            // Mouse leave
                            const tooltipId = $(this).data('tooltip-id');
                            if (tooltipId) {
                                $('#' + tooltipId).remove();
                                $(this).removeData('tooltip-id');
                            }
                        }
                    );
                }
            });
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

            // Tangani resize window untuk memastikan modal tidak melebar
            $(window).on('resize', function() {
                if ($('#editFileModal').hasClass('show')) {
                    // Terapkan kembali styling lebar tetap
                    $('#editFileModal .modal-dialog').css({
                        'max-width': '600px',
                        'margin': '1rem auto'
                    });

                    $('#editFileModal .document-link-container').css({
                        'width': 'calc(100% - 50px)',
                        'max-width': 'calc(100% - 50px)'
                    });
                }
            });

            $(window).on('resize', function() {
    if ($('#tambahFileModal').hasClass('show')) {
        // Terapkan kembali styling lebar tetap
        $('#tambahFileModal .modal-dialog').css({
            'max-width': '600px',
            'margin': '1rem auto'
        });
    }
});

            // Tambahkan event listener untuk memastikan styling tetap diterapkan
            $('#editFileModal').on('shown.bs.modal', function() {
                // Terapkan styling khusus saat modal ditampilkan
                $('#editFileModal .modal-dialog').css({
                    'max-width': '600px',
                    'margin': '1rem auto'
                });

                $('#editFileModal .document-link-container').css({
                    'width': 'calc(100% - 50px)',
                    'max-width': 'calc(100% - 50px)',
                    'overflow': 'hidden'
                });

                $('#currentFileName').css({
                    'display': 'block',
                    'width': '100%',
                    'text-align': 'left',
                    'overflow': 'hidden',
                    'text-overflow': 'ellipsis',
                    'white-space': 'nowrap'
                });
            });

            let isLoading = false;
            let searchTimeout;
            let editDropzoneInitialized = false;

            const baseUrl = "{{ route('admin.file-kesekretariat.index') }}";

            // Form validation helpers
            function clearFormErrors() {
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').empty().removeClass('d-block');
                $('#dropzone-tambahFileForm').removeClass('error');
                $('#dropzone-editFileForm').removeClass('error');
                $('#nama_dokumen_error').empty();
                $('#tanggal_dokumen_error').empty();
                $('#dokumen_file_error').empty().removeClass('d-block');
                $('#edit_nama_dokumen_error').empty();
                $('#edit_tanggal_dokumen_error').empty();
                $('#edit_dokumen_file_error').empty().removeClass('d-block');
            }

            function showFormErrors(errors) {
                clearFormErrors();
                $.each(errors, function(field, messages) {
                    if (field === 'dokumen_file') {
                        // Tangani error untuk field file khusus
                        const errorDiv = $('#dokumen_file_error');
                        const dropzone = $('#dropzone-tambahFileForm');
                        errorDiv.text(messages[0]).addClass('d-block');
                        dropzone.addClass('error');
                    } else {
                        const input = $(`input[name="${field}"]`);
                        const errorDiv = $(`#${field}_error`);
                        input.addClass('is-invalid');
                        errorDiv.text(messages[0]);
                    }
                });
            }

            function createEllipsisText(text, maxLength = 30) {
    if (!text || text.length <= maxLength) {
        return text;
    }
    return text.substring(0, maxLength) + '...';
}

            // Real-time validation
            $(document).on('input', '#tambahFileForm input[name="nama_dokumen"]', function() {
                if ($(this).val().trim()) {
                    $(this).removeClass('is-invalid');
                    $('#nama_dokumen_error').empty();
                } else {
                    // Tampilkan kembali pesan error jika field kosong
                    $(this).addClass('is-invalid');
                    $('#nama_dokumen_error').text('Nama dokumen wajib diisi');
                }
            });

            $(document).on('input', '#edit_nama_dokumen', function() {
                const value = $(this).val().trim();
                if (value) {
                    $(this).removeClass('is-invalid');
                    $('#edit_nama_dokumen_error').empty();
                } else {
                    // Tampilkan kembali pesan error jika field kosong
                    $(this).addClass('is-invalid');
                    $('#edit_nama_dokumen_error').text('Nama dokumen wajib diisi');
                }
            });

            $(document).on('change', '#tambahFileForm input[name="tanggal_dokumen"]', function() {
                if ($(this).val()) {
                    $(this).removeClass('is-invalid');
                    $('#tanggal_dokumen_error').empty();
                } else {
                    // Tampilkan kembali pesan error jika field kosong
                    $(this).addClass('is-invalid');
                    $('#tanggal_dokumen_error').text('Tanggal dokumen wajib diisi');
                }
            });

            $(document).on('change', '#edit_tanggal_dokumen', function() {
                const value = $(this).val();
                if (value) {
                    $(this).removeClass('is-invalid');
                    $('#edit_tanggal_dokumen_error').empty();
                } else {
                    // Tampilkan kembali pesan error jika field kosong
                    $(this).addClass('is-invalid');
                    $('#edit_tanggal_dokumen_error').text('Tanggal dokumen wajib diisi');
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
                    fileInput.required = true;
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
                        // Hapus error ketika file dipilih
                        $('#dokumen_file_error').empty().removeClass('d-block');
                        $('#dropzone-tambahFileForm').removeClass('error');
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
                        // Hapus error ketika file dipilih
                        $('#dokumen_file_error').empty().removeClass('d-block');
                        $('#dropzone-tambahFileForm').removeClass('error');
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
                errorDiv.classList.remove('d-block');
                dropzoneElement.classList.remove('error');

                if (!file) {
                    errorDiv.textContent = 'File dokumen wajib diunggah';
                    errorDiv.classList.add('d-block');
                    dropzoneElement.classList.add('error');
                    return false;
                }

                if (file.size > maxSize) {
                    errorDiv.textContent = 'Ukuran file tidak boleh lebih dari 10MB';
                    errorDiv.classList.add('d-block');
                    dropzoneElement.classList.add('error');
                    return false;
                }

                if (!allowedTypes.includes(file.type)) {
                    errorDiv.textContent = 'Format file tidak didukung. Gunakan PDF, DOC, DOCX, XLS, atau XLSX';
                    errorDiv.classList.add('d-block');
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

    // Buat nama file dengan elipsis untuk tampilan (sama seperti modal edit)
    const displayFileName = createEllipsisText(file.name, 35);

    dropzoneElement.innerHTML = `
        <div class="file-preview d-flex align-items-center justify-content-between p-3 bg-light rounded" style="width: 100%; max-width: 100%; box-sizing: border-box;">
            <div class="d-flex align-items-center" style="flex: 1; min-width: 0; max-width: calc(100% - 40px);">
                <i class="${fileIcon} fa-2x me-3 flex-shrink-0"></i>
                <div style="flex: 1; min-width: 0; overflow: hidden;">
                    <div class="fw-bold" style="max-width: 100%; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; display: block;" title="${file.name}">
                        ${displayFileName}
                    </div>
                    <small class="text-muted">${fileSize} MB</small>
                </div>
            </div>
            <button type="button" class="btn btn-sm btn-outline-danger remove-file" onclick="removeSelectedFile()" style="flex-shrink: 0; margin-left: 10px;">
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

                // Hanya mengosongkan error jika tidak ada error validasi lain
                const errorDiv = document.getElementById('dokumen_file_error');
                if (errorDiv && !errorDiv.textContent.includes('wajib diunggah')) {
                    errorDiv.textContent = '';
                    errorDiv.classList.remove('d-block');
                }

                // Hanya menghapus kelas error jika tidak ada error validasi lain
                if (!errorDiv || !errorDiv.textContent) {
                    dropzoneElement.classList.remove('error');
                }
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
                    // Untuk edit form, file tidak wajib diisi
                    fileInput.required = false;
                    document.getElementById('editFileForm').appendChild(fileInput);
                } else {
                    fileInput.value = '';
                    fileInput.required = false;
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
                        // Hapus error ketika file dipilih
                        $('#edit_dokumen_file_error').empty().removeClass('d-block');
                        $('#dropzone-editFileForm').removeClass('error');
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
                        // Hapus error ketika file dipilih
                        $('#edit_dokumen_file_error').empty().removeClass('d-block');
                        $('#dropzone-editFileForm').removeClass('error');
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
                if (errorDiv) {
                    errorDiv.textContent = '';
                    errorDiv.classList.remove('d-block');
                }
                dropzoneElement.classList.remove('error');

                if (!file) {
                    // Untuk edit form, file tidak wajib diisi
                    return false;
                }

                if (file.size > maxSize) {
                    if (errorDiv) {
                        errorDiv.textContent = 'Ukuran file tidak boleh lebih dari 10MB';
                        errorDiv.classList.add('d-block');
                    }
                    dropzoneElement.classList.add('error');
                    return false;
                }

                if (!allowedTypes.includes(file.type)) {
                    if (errorDiv) {
                        errorDiv.textContent = 'Format file tidak didukung. Gunakan PDF, DOC, DOCX, XLS, atau XLSX';
                        errorDiv.classList.add('d-block');
                    }
                    dropzoneElement.classList.add('error');
                    return false;
                }

                const fileInput = document.getElementById('edit_dokumen_file_input');
                const dt = new DataTransfer();
                dt.items.add(file);
                fileInput.files = dt.files;

                showEditFilePreview(file, dropzoneElement);

                // Inisialisasi tooltip untuk file yang baru dipilih
                setTimeout(initializeTooltips, 100);

                return true;
            }

            function showEditFilePreview(file, dropzoneElement) {
    const fileExtension = file.name.split('.').pop().toLowerCase();
    const fileIcon = getFileIconForPreview(fileExtension);
    const fileSize = (file.size / (1024 * 1024)).toFixed(2);

    // Buat nama file dengan elipsis untuk tampilan (sama seperti modal edit yang sudah diperbaiki)
    const displayFileName = createEllipsisText(file.name, 35);

    dropzoneElement.innerHTML = `
        <div class="file-preview d-flex align-items-center justify-content-between p-3 bg-light rounded" style="width: 100%; max-width: 100%; box-sizing: border-box;">
            <div class="d-flex align-items-center" style="flex: 1; min-width: 0; max-width: calc(100% - 40px);">
                <i class="${fileIcon} fa-2x me-3 flex-shrink-0"></i>
                <div style="flex: 1; min-width: 0; overflow: hidden;">
                    <div class="fw-bold" style="max-width: 100%; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; display: block;" title="${file.name}">
                        ${displayFileName}
                    </div>
                    <small class="text-muted">${fileSize} MB</small>
                </div>
            </div>
            <button type="button" class="btn btn-sm btn-outline-danger remove-file" onclick="removeEditSelectedFile()" style="flex-shrink: 0; margin-left: 10px;">
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

                // Hapus error hanya jika ada
                const errorDiv = document.getElementById('edit_dokumen_file_error');
                if (errorDiv) {
                    errorDiv.textContent = '';
                    errorDiv.classList.remove('d-block');
                }
                dropzoneElement.classList.remove('error');
            }

            // Edit modal functions
            function openEditModal(id, nama, tanggal, fileName) {
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').empty();

    // Fetch file data from server
    $.ajax({
        url: `/admin/file-kesekretariat/${id}/edit`,
        type: 'GET',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'X-Requested-With': 'XMLHttpRequest'
        },
        success: function(response) {
            if (response.success) {
                const data = response.data;

                $('#edit_file_id').val(data.id);
                $('#edit_nama_dokumen').val(data.nama_dokumen || '');

                // Format date for input
                let formattedDate = '';
                if (data.tanggal_dokumen) {
                    const date = new Date(data.tanggal_dokumen);
                    if (!isNaN(date.getTime())) {
                        const year = date.getFullYear();
                        const month = String(date.getMonth() + 1).padStart(2, '0');
                        const day = String(date.getDate()).padStart(2, '0');
                        formattedDate = `${year}-${month}-${day}`;
                    }
                }
                $('#edit_tanggal_dokumen').val(formattedDate);

                // Update current file display dengan elipsis yang konsisten
                if (data.dokumen_file) {
                    const fileExtension = data.dokumen_file.split('.').pop().toLowerCase();
                    const fileIcon = getFileIconForCurrentFile(fileExtension);

                    // Buat nama file dengan elipsis untuk tampilan
                    const displayFileName = createEllipsisText(data.dokumen_file, 35);

                    // Atur text yang terlihat dengan elipsis dan title untuk tooltip dengan nama lengkap
                    $('#currentFileName').text(displayFileName).attr('title', data.dokumen_file);
                    $('#currentFileIcon').attr('class', `${fileIcon} fa-2x me-3`);
                    $('#currentFileLink').attr('href', data.file_url);
                } else {
                    $('#currentFileName').text('-').attr('title', '');
                    $('#currentFileIcon').attr('class', 'fas fa-file fa-2x me-3 text-secondary');
                    $('#currentFileLink').attr('href', '#');
                }

                $('#editFileForm').attr('action', `/admin/file-kesekretariat/${id}`);
                $('#editFileModal').modal('show');

                // Terapkan styling khusus setelah modal ditampilkan
                setTimeout(function() {
                    // Pastikan modal dialog memiliki lebar maksimum tetap
                    $('#editFileModal .modal-dialog').css({
                        'max-width': '600px',
                        'margin': '1rem auto'
                    });

                    // Pastikan konten modal tidak melebihi lebar container
                    $('#editFileModal .modal-content').css({
                        'max-width': '100%',
                        'overflow': 'hidden'
                    });

                    // Pastikan kontainer file saat ini memiliki lebar tetap
                    $('#editFileModal .document-link-container').css({
                        'width': 'calc(100% - 50px)',
                        'max-width': 'calc(100% - 50px)',
                        'overflow': 'hidden'
                    });

                    // Pastikan text nama file menggunakan elipsis
                    $('#currentFileName').css({
                        'display': 'block',
                        'width': '100%',
                        'text-align': 'left',
                        'overflow': 'hidden',
                        'text-overflow': 'ellipsis',
                        'white-space': 'nowrap',
                        'max-width': '100%'
                    });
                }, 100);
            } else {
                toastr.error(response.message || 'Gagal memuat data file', 'Error!');
            }
        },
        error: function(xhr) {
            let errorMessage = 'Terjadi kesalahan saat memuat data file';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            }
            toastr.error(errorMessage, 'Error!');
        }
    });
}

            // Submit edit form
            function submitEditForm() {
    const form = $('#editFileForm');
    const formData = new FormData(form[0]);
    const fileId = $('#edit_file_id').val();

    // Manual validation
    let isValid = true;

    // Clear previous errors
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').empty();
    $('#dropzone-editFileForm').removeClass('error');

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
                // Tangani error untuk form edit
                $.each(xhr.responseJSON.errors, function(key, value) {
                    if (key === 'dokumen_file') {
                        // Tangani error untuk field file khusus
                        const errorDiv = $('#edit_dokumen_file_error');
                        const dropzone = $('#dropzone-editFileForm');
                        errorDiv.text(value[0]).addClass('d-block');
                        dropzone.addClass('error');
                    } else {
                        $(`#edit_${key}`).addClass('is-invalid');
                        $(`#edit_${key}_error`).text(value[0]);
                    }
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

        // Get current order from URL parameters
        const urlParams = new URLSearchParams(window.location.search);
        const currentSortBy = urlParams.get('sort_by');
        const currentOrder = urlParams.get('order') || 'desc';

        // If clicking on the same column, toggle order; otherwise start with asc
        let newOrder = 'asc';
        if (currentSortBy === sortBy) {
            newOrder = currentOrder === 'asc' ? 'desc' : 'asc';
        }

        const selectedYear = $('select[name="year"]').val(); // Get selected year
        const searchParams = {
            page: 1,
            sort_by: sortBy,
            order: newOrder
        };
        
        if (selectedYear) {
            searchParams.year = selectedYear; // Include year parameter
        }

        performSearch(searchParams, true);
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
            const year = urlParams.get('year'); // Get year from URL params

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
                
                if (year) {
                    searchParams.year = year; // Include year parameter
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
    const year = $('select[name="year"]').val(); // Get selected year

    // Get current URL parameters to maintain state
    const currentUrl = new URLSearchParams(window.location.search);

    if (search) searchParams.set('search', search);
    if (year) searchParams.set('year', year); // Add year parameter
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

    // Keep year if not specified in params
    if (!params.year) {
        const selectedYear = currentUrl.get('year');
        if (selectedYear) {
            searchParams.set('year', selectedYear);
        }
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

    // Clear previous errors
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').empty();
    $('#dropzone-tambahFileForm').removeClass('error');

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
        $('#dokumen_file_error').text('File dokumen wajib diunggah').addClass('d-block');
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
                                    <a href="${fileData.file_url}" class="document-name" target="_blank">
    ${fileData.nama_dokumen}
</a>
                                </div>
                                <div class="document-date">${fileData.tanggal_dokumen_formatted}</div>
                            </div>
                        </td>
                        <td>
    <a href="${fileData.file_url}" class="file-link" target="_blank">
        <i class="${getFileIcon(fileData.extension)} me-2"></i>
        <span class="file-link-text">${fileData.dokumen_file}</span>
    </a>
</td>
                        <td class="text-center">
                            <div class="dropdown dropdown-action">
                                <button class="btn btn-icon btn-sm btn-preview"
                                        onclick="previewFile('${fileData.file_url}', '${fileData.dokumen_file}', '${fileData.extension}')"
                                        title="Preview ${fileData.dokumen_file}">
                                    <i class="fas fa-eye text-primary"></i>
                                </button>
                                <button class="btn btn-icon btn-sm ms-2 dropdown-toggle-action" type="button">
                                    <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect width="32" height="32" rx="6" fill="#EFF6FF"/>
                                        <rect x="0.5" y="0.5" width="31" height="31" rx="5.5" stroke="#1B84FF" stroke-opacity="0.2"/>
                                        <g clip-path="url(#clip0_2223_4269)">
                                            <path opacity="0.3" d="M19.4266 7.9375H12.5734C10.0131 7.9375 7.9375 10.0131 7.9375 12.5734V19.4266C7.9375 21.9869 10.0131 24.0625 12.5734 24.0625H19.4266C21.9869 24.0625 24.0625 21.9869 24.0625 19.4266V12.5734C24.0625 10.0131 21.9869 7.9375 19.4266 7.9375Z" fill="#1B84FF"/>
                                            <path d="M12.251 14.8232C12.8475 14.8233 13.331 15.3067 13.3311 15.9033C13.3311 16.4999 12.8476 16.9833 12.251 16.9834C11.6543 16.9834 11.1709 16.5 11.1709 15.9033C11.1709 15.3067 11.6543 14.8232 12.251 14.8232ZM16.2979 14.8232C16.8945 14.8232 17.3789 15.3066 17.3789 15.9033C17.3789 16.5 16.8945 16.9834 16.2979 16.9834C15.7013 16.9832 15.2178 16.4999 15.2178 15.9033C15.2178 15.3067 15.7013 14.8234 16.2979 14.8232ZM20.3369 14.8232C20.9336 14.8232 21.418 15.3066 21.418 15.9033C21.418 16.5 20.9336 16.9834 20.3369 16.9834C19.7404 16.9832 19.2568 16.4999 19.2568 15.9033C19.2568 15.3068 19.7404 14.8234 20.3369 14.8232Z" fill="#1B84FF"/>
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_2223_4269">
                                                <rect width="18" height="18" fill="white" transform="translate(7 7)"/>
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-action">
                                    <li class="dropdown-item edit"
                                        onclick="openEditModal(${fileData.id}, '${fileData.nama_dokumen}', '${fileData.tanggal_dokumen}', '${fileData.dokumen_file}')">
                                        <i class="ki-outline ki-pencil me-2"></i>Edit File
                                    </li>
                                    <li class="dropdown-item delete"
                                        onclick="deleteFile(${fileData.id}, '${fileData.nama_dokumen}', '/admin/file-kesekretariat/${fileData.id}')">
                                        <i class="ki-outline ki-trash me-2"></i>Hapus
                                    </li>
                                </ul>
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
                                    <a href="${fileData.file_url}" class="document-name" target="_blank">
                                        <i class="${getFileIcon(fileData.extension)}"></i>
                                        ${fileData.nama_dokumen}
                                    </a>
                                </div>
                                <div class="document-date">${fileData.tanggal_dokumen_formatted}</div>
                            </div>
                        </td>
                        <td>
    <a href="${fileData.file_url}" class="file-link" target="_blank">
        <i class="${getFileIcon(fileData.extension)} me-2"></i>
        <span class="file-link-text">${fileData.dokumen_file}</span>
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
                const selectedYear = $('select[name="year"]').val(); // Get selected year
                const searchParams = {page: 1};
                if (selectedYear) {
                    searchParams.year = selectedYear; // Include year parameter
                }
                performSearch(searchParams, true);
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
                const selectedYear = $('select[name="year"]').val(); // Get selected year
                const searchParams = {page: 1, per_page: perPage};
                if (selectedYear) {
                    searchParams.year = selectedYear; // Include year parameter
                }
                performSearch(searchParams, true);
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
            $('select[name="year"]').val(''); // Reset year filter
            $('#filter-file-type').val('');
            $('#filter input[name="search"]').trigger('input');
        }
    </script>
@endsection


