@extends('layouts.app')

@section('pageTitle', 'Database Bendahara')
@section('mainSection', 'Main Menu')
@section('currentSection', 'Database Bendahara')

@section('content')

    <style>
        body {
            background-color: #f5f5f5;
        }

        .main-content {
            background-color: #f5f5f5;
            min-height: 100vh;
            padding: 20px 0;
        }

        /* Card Styles */
        .card {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
            border: 1px solid #e9ecef;
            overflow: visible !important;
        }

        .card-body {
            padding: 0;
            overflow: visible !important;
        }

        /* Page Header */
        .page-header {
            background-color: transparent;
            padding: 0;
            margin-bottom: 20px;
        }

        .page-header h3 {
            color: #2c3e50;
            font-size: 1.8rem;
            font-weight: 700;
        }

        /* Enhanced controls container */
        .controls-container {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .search-container {
            position: relative;
            max-width: 280px;
            flex: 1;
        }

        .search-input {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 12px 20px 12px 45px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            width: 100%;
        }

        .search-input:focus {
            border-color: #F8285A;
            box-shadow: 0 0 0 0.2rem rgba(248, 40, 90, 0.15);
            outline: none;
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

        /* Filter dropdown styling */
        .filter-dropdown {
            position: relative;
        }

        .filter-btn {
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 12px 16px;
            font-size: 0.95rem;
            color: #495057;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            min-width: 140px;
        }

        .filter-btn:hover {
            border-color: #F8285A;
            color: #F8285A;
        }

        .filter-menu {
            position: absolute;
            top: 100%;
            right: 0;
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            z-index: 1000;
            min-width: 220px;
            margin-top: 4px;
            display: none;
            overflow: visible !important;
        }

        .filter-menu.show {
            display: block;
        }

        .filter-option {
            padding: 12px 16px;
            cursor: pointer;
            transition: background-color 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #f8f9fa;
        }

        .filter-option:last-child {
            border-bottom: none;
        }

        .filter-option:hover {
            background-color: #f8f9fa;
        }

        .filter-option.active {
            background-color: #F8285A;
            color: white;
        }

        .filter-option .file-type-icon {
            margin-right: 8px;
            font-size: 16px;
        }

        .filter-option .file-count {
            font-size: 0.85rem;
            opacity: 0.8;
        }

        /* Buttons */
        .btn-add-laporan {
            background: linear-gradient(135deg, #F8285A 0%, #e91e63 100%);
            border: none;
            border-radius: 8px;
            padding: 12px 24px;
            font-weight: 600;
            font-size: 0.95rem;
            color: white;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(248, 40, 90, 0.3);
            white-space: nowrap;
        }

        .btn-add-laporan:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(248, 40, 90, 0.4);
            color: white;
            text-decoration: none;
        }

        /* Table Container */
        .table-container {
            background-color: white;
            border-radius: 0px 0px 12px 12px;
            overflow: hidden;
        }

        .table-header {
            background-color: white;
            padding: 20px 25px;
            border-bottom: 1px solid #e9ecef;
            border-radius: 12px 12px 0px 0px;
            overflow: visible !important;
            position: relative;
            z-index: 10;
        }

        .table-footer {
            background-color: white;
            padding: 15px 25px;
            border-top: 1px solid #e9ecef;
        }

        /* Table Responsive */
        .table-responsive {
            overflow-x: auto;
            overflow-y: visible;
            -webkit-overflow-scrolling: touch;
            border-radius: 8px;
            border: 1px solid #e9ecef;
            background-color: white;
        }

        /* Table Base Styles */
        .table {
            border-collapse: separate !important;
            border-spacing: 0 !important;
            margin: 0 !important;
            background-color: white;
            width: 100%;
            min-width: 800px;
            border: none;
        }

        /* Table Header Styles with Sort Fix */
        .table thead th {
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
            border-top: none;
            font-weight: 600;
            font-size: 0.875rem;
            color: #495057;
            white-space: nowrap;
            padding: 12px 8px !important;
            position: relative;
            text-align: center !important;
        }

        .table thead th:last-child {
            border-right: none;
        }

        /* Sort Link Styles */
        .table thead th .sort-link {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            text-decoration: none;
            color: inherit;
            gap: 8px;
        }

        .table thead th .sort-link:hover {
            text-decoration: none;
            color: inherit;
        }

        .table thead th .sort-link i {
            flex-shrink: 0;
            margin-left: auto;
        }

        /* Table Body Styles */
        .table tbody tr {
            border: 1px solid #e9ecef;
            transition: background-color 0.2s ease;
        }

        .table tbody tr:first-child {
            border-top: none;
        }

        .table tbody tr:last-child {
            border-bottom: none;
        }

        .table tbody tr:hover,
        .table tbody tr:hover td {
            background-color: #f8f9fa;
        }

        .table tbody tr td {
            border: 1px solid #e9ecef !important;
            padding: 8px !important;
            font-size: 0.875rem;
            white-space: nowrap;
            vertical-align: middle;
            word-wrap: break-word;
            max-width: 200px;
            text-align: left !important;
            background-color: white;
        }

        .table tbody tr td:last-child {
            border-right: none !important;
        }

        /* Column Widths and Alignments */
        .table td:first-child,
        .table th:first-child {
            padding-left: 20px !important;
            padding-right: 20px !important;
        }

        .table td:last-child,
        .table th:last-child {
            padding-right: 12px !important;
        }

        /* Specific column widths */
        .table th:nth-child(1), .table td:nth-child(1) { width: 10px; text-align: center !important; }
        .table th:nth-child(2), .table td:nth-child(2) { width: 300px; text-align: left !important; }
        .table th:nth-child(3), .table td:nth-child(3) { width: 300px; text-align: left !important; }
        .table th:nth-child(4), .table td:nth-child(4) { width: 10px; text-align: center !important; }
        .table th:nth-child(5), .table td:nth-child(5) { width: 10px; text-align: center !important; }

        .table td:nth-child(1),
        .table td:nth-child(4),
        .table td:nth-child(5) {
            text-align: center !important;
        }

        /* File Icons */
        .file-icon {
            width: 24px;
            height: 24px;
            margin-right: 8px;
        }

        .file-icon.pdf { color: #dc3545; }
        .file-icon.doc,
        .file-icon.docx { color: #0d6efd; }
        .file-icon.xls,
        .file-icon.xlsx { color: #198754; }

        /* Empty State */
        .empty-state {
            text-align: center;
            color: #6c757d;
            padding: 60px 25px;
            background-color: white;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            margin: 20px;
        }

        /* Form Controls */
        .form-select {
            border-radius: 6px;
            border: 1px solid #dee2e6;
            transition: all 0.2s ease;
        }

        .form-select:focus {
            border-color: #F8285A;
            box-shadow: 0 0 0 0.2rem rgba(248, 40, 90, 0.25);
        }

        .btn-outline-secondary:hover {
            background-color: #f5f5f5;
            border-color: #f5f5f5;
        }

        /* Pagination */
        .pagination {
            margin-bottom: 0;
        }

        .pagination .page-item {
            margin: 0 1px;
        }

        .pagination-sm .page-link {
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
            border-radius: 4px;
            border: 1px solid #dee2e6;
            color: #6c757d;
            margin: 0 2px;
        }

        .pagination-sm .page-item.active .page-link {
            background-color: #F8285A;
            border-color: #F8285A;
            color: white;
        }

        .pagination-sm .page-link:hover {
            background-color: #f8f9fa;
            border-color: #dee2e6;
            color: #495057;
        }

        .pagination-sm .page-item.disabled .page-link {
            color: #6c757d;
            background-color: #fff;
            border-color: #dee2e6;
        }

        /* Pagination Arrows and Numbers */
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

        /* Search highlight */
        .search-highlight {
            background-color: #fff3cd;
            padding: 1px 3px;
            border-radius: 3px;
            font-weight: bold;
        }

        /* Active filter indicator */
        .filter-active {
            background-color: #F8285A !important;
            color: white !important;
            border-color: #F8285A !important;
        }

        .filter-active:hover {
            background-color: #e91e63 !important;
            border-color: #e91e63 !important;
        }

        /* Debug helper */
        .debug-info {
            font-size: 0.7rem;
            color: #6c757d;
            font-style: italic;
            display: none; /* Hidden by default, can be shown for debugging */
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .controls-container {
                flex-direction: column;
                align-items: stretch;
                gap: 15px;
            }

            .search-container {
                max-width: none;
            }

            .filter-dropdown {
                width: 100%;
            }

            .filter-btn {
                justify-content: center;
                width: 100%;
            }

            .table-header,
            .table-footer {
                padding: 15px;
            }

            .d-flex.justify-content-between.align-items-center.flex-wrap {
                flex-direction: column;
                gap: 15px;
            }

            .d-flex.align-items-center.gap-2.flex-wrap {
                justify-content: center;
                width: 100%;
            }

            .table-responsive {
                border-radius: 6px;
            }

            .table thead th,
            .table tbody tr td {
                padding: 8px 6px !important;
                font-size: 0.8rem;
            }

            .table thead th .sort-link {
                gap: 4px;
                font-size: 0.8rem;
            }

            .d-flex.justify-content-between.align-items-center.flex-wrap {
                flex-direction: column;
                gap: 1rem;
                align-items: center !important;
            }

            .pagination-sm .page-link {
                padding: 0.25rem 0.5rem;
                font-size: 0.75rem;
            }
        }

        @media (max-width: 576px) {
            .pagination-sm .page-link {
                padding: 0.2rem 0.4rem;
                font-size: 0.7rem;
            }

            .text-muted {
                font-size: 0.875rem;
            }

            .btn-add-laporan {
                width: 100%;
                margin-bottom: 10px;
            }
        }
        .table-header h2 {
    margin-top: 0.5rem !important;
    margin-bottom: 0.5rem !important;
    padding-top: 0.25rem;
    line-height: 1.3;
}

/* Page title positioning fix */
.d-flex.justify-content-between.align-items-center.flex-wrap h1 {
    margin-bottom: 0.5rem !important;
    padding-bottom: 0;
    line-height: 1.2;
}

/* File name styling - Red color for filename and PDF indicator */
.table tbody tr td .file-name,
.table tbody tr td .file-title,
.table tbody tr td .filename {
    color: #dc3545 !important; /* Bootstrap red */
    font-weight: 600;
}

/* File type indicator (PDF, DOC, etc.) styling */
.table tbody tr td .file-type,
.table tbody tr td .file-extension,
.table tbody tr td .badge {
    background-color: #dc3545 !important;
    color: white !important;
    font-weight: 500;
    padding: 2px 6px;
    border-radius: 4px;
    font-size: 0.75rem;
}

/* File size styling */
.table tbody tr td .file-size {
    color: #dc3545 !important;
    font-weight: 500;
    font-size: 0.85rem;
}

/* File icon styling */
.table tbody tr td i.fas.fa-file-pdf{
    color: #dc3545 !important;
}
.table tbody tr td i.fas.fa-file-word{
    color: #0d6efd !important;
}
.table tbody tr td i.fas.fa-file-excel{
    color: #198754 !important;
}
.table tbody tr td i.fas.fa-file-image{
    color: #fd7e14 !important;
}

/* Eye/Preview button styling - Light blue */
.table tbody tr td .btn-preview,
.table tbody tr td .preview-btn,
.table tbody tr td a[title*="preview" i],
.table tbody tr td a[title*="lihat" i],
.table tbody tr td a.btn:has(i.fa-eye),
.table tbody tr td button:has(i.fa-eye) {
    background-color: #87CEEB !important; /* Light blue */
    border-color: #87CEEB !important;
    color: #2c5aa0 !important; /* Darker blue for text */
}

.table tbody tr td .btn-preview:hover,
.table tbody tr td .preview-btn:hover,
.table tbody tr td a[title*="preview" i]:hover,
.table tbody tr td a[title*="lihat" i]:hover {
    background-color: #6BB6FF !important;
    border-color: #6BB6FF !important;
    color: #1a4480 !important;
}

/* Eye icon specific styling */
.table tbody tr td i.fa-eye,
.table tbody tr td i.fas.fa-eye {
    color: #2c5aa0 !important;
}

/* Date/Time styling for Created At and Updated At columns */
.table tbody tr td .created-at,
.table tbody tr td .updated-at,
.table tbody tr td .date-time,
.table tbody tr td:nth-child(4), /* Assuming 4th column is created_at */
.table tbody tr td:nth-child(5)  /* Assuming 5th column is updated_at */ {
    color: #dc3545 !important;
    font-weight: 500;
}

/* Download button styling - White text and icon */
.table tbody tr td .btn-download,
.table tbody tr td .download-btn,
.table tbody tr td a[title*="download" i],
.table tbody tr td a[href*="download"],
.table tbody tr td a.btn:has(i.fa-download),
.table tbody tr td button:has(i.fa-download) {
    background-color: #28a745 !important; /* Keep green background */
    border-color: #28a745 !important;
    color: white !important;
    font-weight: 500;
}

.table tbody tr td .btn-download:hover,
.table tbody tr td .download-btn:hover,
.table tbody tr td a[title*="download" i]:hover,
.table tbody tr td a[href*="download"]:hover {
    background-color: #218838 !important;
    border-color: #218838 !important;
    color: white !important;
}

/* Download icon specific styling */
.table tbody tr td .btn-download i,
.table tbody tr td .download-btn i,
.table tbody tr td a[title*="download" i] i,
.table tbody tr td a[href*="download"] i,
.table tbody tr td i.fa-download {
    color: white !important;
}

/* Edit button styling - White text and icon */
.table tbody tr td .btn-edit,
.table tbody tr td .edit-btn,
.table tbody tr td a[title*="edit" i],
.table tbody tr td a[href*="edit"],
.table tbody tr td a.btn:has(i.fa-edit),
.table tbody tr td button:has(i.fa-edit),
.table tbody tr td a.btn:has(i.fa-pencil),
.table tbody tr td button:has(i.fa-pencil) {
    background-color: #ffc107 !important; /* Keep yellow/warning background */
    border-color: #ffc107 !important;
    color: white !important;
    font-weight: 500;
}

.table tbody tr td .btn-edit:hover,
.table tbody tr td .edit-btn:hover,
.table tbody tr td a[title*="edit" i]:hover,
.table tbody tr td a[href*="edit"]:hover {
    background-color: #e0a800 !important;
    border-color: #e0a800 !important;
    color: white !important;
}

/* Edit icon specific styling */
.table tbody tr td .btn-edit i,
.table tbody tr td .edit-btn i,
.table tbody tr td a[title*="edit" i] i,
.table tbody tr td a[href*="edit"] i,
.table tbody tr td i.fa-edit,
.table tbody tr td i.fa-pencil,
.table tbody tr td i.fas.fa-edit,
.table tbody tr td i.fas.fa-pencil {
    color: white !important;
}

/* Delete button styling - Keep existing red but ensure white text/icon */
.table tbody tr td .btn-delete,
.table tbody tr td .delete-btn,
.table tbody tr td a[title*="delete" i],
.table tbody tr td a[title*="hapus" i],
.table tbody tr td button[onclick*="destroyItem"] {
    background-color: #dc3545 !important;
    border-color: #dc3545 !important;
    color: white !important;
    font-weight: 500;
}

.table tbody tr td .btn-delete i,
.table tbody tr td .delete-btn i,
.table tbody tr td a[title*="delete" i] i,
.table tbody tr td a[title*="hapus" i] i,
.table tbody tr td button[onclick*="destroyItem"] i,
.table tbody tr td i.fa-trash,
.table tbody tr td i.fas.fa-trash {
    color: white !important;
}

/* Generic action button improvements */
.table tbody tr td .btn-sm {
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
    border-radius: 0.375rem;
    font-weight: 500;
    transition: all 0.2s ease-in-out;
}

.table tbody tr td .btn-sm:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

/* Specific styling for file information rows */
.table tbody tr td:nth-child(2) { /* Assuming 2nd column contains file info */
    color: #dc3545 !important;
}

/* If you have specific classes for file info, add them here */
.file-info,
.file-details,
.document-name {
    color: #dc3545 !important;
    font-weight: 600;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .table-header h2 {
        font-size: 1.5rem;
        margin-top: 0.25rem !important;
    }

    .d-flex.justify-content-between.align-items-center.flex-wrap h1 {
        font-size: 1.75rem;
        margin-bottom: 0.25rem !important;
    }
}

/* Additional utility classes you can use in your HTML */
.text-red {
    color: #dc3545 !important;
}

.text-light-blue {
    color: #87CEEB !important;
}

.btn-light-blue {
    background-color: #87CEEB !important;
    border-color: #87CEEB !important;
    color: #2c5aa0 !important;
}

.btn-light-blue:hover {
    background-color: #6BB6FF !important;
    border-color: #6BB6FF !important;
    color: #1a4480 !important;
}
    </style>

    @if (session('success'))
        <div class="alert alert-{{ session('action') === 'store' ? 'success' : (session('action') === 'update' ? 'warning' : 'danger') }} alert-dismissible fade show"
            role="alert">
            <i
                class="fas {{ session('action') === 'store' ? 'fa-check-circle' : (session('action') === 'update' ? 'fa-exclamation-circle' : 'fa-trash-alt') }} me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center flex-wrap mb-4" style="padding:10px 30px">
        <strong><h1 class="fw-bold fs-2 mb-0 text-dark">Database Bendahara</h1></strong>
        <p></p>
    </div>

    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-header" style="border-radius: 12px 12px 0px 0px">
                                <div class="d-flex justify-content-between align-items-start mb-3"> <!-- Changed to align-items-start -->
                                    <!-- Left side with title and info aligned -->
                                    <div class="d-flex flex-column">
                                        <strong><h2 class="mb-2 fw-bold text-dark">Daftar Laporan Database Bendahara</h2></strong>
                                        @if (!(isset($laporanBendahara) && $laporanBendahara->isEmpty()))
                                            <div id="filter-info" class="text-muted">
                                                Menampilkan <span id="showing-count">{{ isset($laporanBendahara) ? $laporanBendahara->count() : 0 }}</span>
                                                dari <span id="total-count">{{ isset($laporanBendahara) ? $laporanBendahara->total() : 0 }}</span> laporan
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Enhanced Search and Filter Controls -->
                                    <div class="controls-container">
                                        <a href="{{ route('admin.bendahara.create') }}" class="btn btn-add-laporan">
                                            <i class="ki-duotone ki-plus fs-4 me-2" style="color: white !important;"></i>Tambah Laporan
                                        </a>

                                        <!-- Search Container -->
                                        <div class="search-container">
                                            <input
                                                type="text"
                                                class="form-control search-input"
                                                placeholder="Cari laporan..."
                                                id="search"
                                                name="search"
                                                value="{{ request('search') }}"
                                            >
                                            <i class="fas fa-search search-icon"></i>
                                        </div>

                                        <!-- Filter Dropdown -->
                                        <div class="filter-dropdown">
                                            {{-- UPDATED FILTER BUTTON - This shows current active filter --}}
                                            <div class="filter-btn {{ (request('filter_type') && request('filter_type') != 'all') ? 'filter-active' : '' }}" id="filterBtn">
                                                <i class="fas fa-filter"></i>
                                                <span>
                                                    @if(request('filter_type') == 'pdf')
                                                        File PDF
                                                    @elseif(request('filter_type') == 'doc')
                                                        File DOC/DOCX
                                                    @elseif(request('filter_type') == 'excel')
                                                        File Excel
                                                    @elseif(request('filter_type') == 'image')
                                                        File Gambar
                                                    @elseif(request('filter_type') == 'other')
                                                        File Lain
                                                    @else
                                                        Filter
                                                    @endif
                                                </span>
                                                <i class="fas fa-chevron-down ms-1" style="font-size: 0.8rem;"></i>
                                            </div>

                                            {{-- UPDATED FILTER MENU - This shows filter options with counts --}}
                                            <div class="filter-menu" id="filterMenu" data-filter-counts="{{ json_encode($fileCounts ?? []) }}">
                                                <div class="filter-option {{ (request('filter_type', 'all') == 'all') ? 'active' : '' }}" data-filter="all">
                                                    <span>
                                                        <i class="fas fa-list file-type-icon"></i>
                                                        Semua File
                                                    </span>
                                                    <span class="filter-count" id="all-count">{{ $fileCounts['all'] ?? 0 }}</span>
                                                </div>
                                                <div class="filter-option {{ (request('filter_type') == 'pdf') ? 'active' : '' }}" data-filter="pdf">
                                                    <span>
                                                        <i class="fas fa-file-pdf file-type-icon" style="color: #dc3545;"></i>
                                                        File PDF
                                                    </span>
                                                    <span class="filter-count" id="pdf-count">{{ $fileCounts['pdf'] ?? 0 }}</span>
                                                </div>
                                                <div class="filter-option {{ (request('filter_type') == 'doc') ? 'active' : '' }}" data-filter="doc">
                                                    <span>
                                                        <i class="fas fa-file-word file-type-icon" style="color: #0d6efd;"></i>
                                                        File DOC/DOCX
                                                    </span>
                                                    <span class="filter-count" id="doc-count">{{ $fileCounts['doc'] ?? 0 }}</span>
                                                </div>
                                                <div class="filter-option {{ (request('filter_type') == 'excel') ? 'active' : '' }}" data-filter="excel">
                                                    <span>
                                                        <i class="fas fa-file-excel file-type-icon" style="color: #198754;"></i>
                                                        File Excel
                                                    </span>
                                                    <span class="filter-count" id="excel-count">{{ $fileCounts['excel'] ?? 0 }}</span>
                                                </div>
                                                <div class="filter-option {{ (request('filter_type') == 'image') ? 'active' : '' }}" data-filter="image">
                                                    <span>
                                                        <i class="fas fa-file-image file-type-icon" style="color: #fd7e14;"></i>
                                                        File Gambar
                                                    </span>
                                                    <span class="filter-count" id="image-count">{{ $fileCounts['image'] ?? 0 }}</span>
                                                </div>
                                                <div class="filter-option {{ (request('filter_type') == 'other') ? 'active' : '' }}" data-filter="other">
                                                    <span>
                                                        <i class="fas fa-file file-type-icon" style="color: #6c757d;"></i>
                                                        File Lain
                                                    </span>
                                                    <span class="filter-count" id="other-count">{{ $fileCounts['other'] ?? 0 }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-container">
                                @include('admin.bendahara._table')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    @if (isset($laporanBendahara) && $laporanBendahara->isNotEmpty())
        <script>
        $(document).ready(function() {
        let currentFilter = 'all';

        // Initialize sorting from URL on page load
        initializeSortingFromURL();
        updateFilterCounts();

        // Filter dropdown functionality
        $('#filterBtn').on('click', function(e) {
            e.stopPropagation();
            $('#filterMenu').toggleClass('show');
        });

        // Close dropdown when clicking outside
        $(document).on('click', function() {
            $('#filterMenu').removeClass('show');
        });

        // Filter option selection - NOW USES SERVER-SIDE FILTERING
        $('.filter-option').on('click', function(e) {
            e.stopPropagation();

            const filterType = $(this).data('filter');
            if (filterType === currentFilter) return;

            // Update active state
            $('.filter-option').removeClass('active');
            $(this).addClass('active');

            // Update button text and style
            const filterText = $(this).find('span').first().text().trim();
            $('#filterBtn span').text(filterText);

            // Update button style for active filter
            if (filterType === 'all') {
                $('#filterBtn').removeClass('filter-active');
            } else {
                $('#filterBtn').addClass('filter-active');
            }

            currentFilter = filterType;

            // Apply SERVER-SIDE filter
            applyServerSideFilter(filterType);

            $('#filterMenu').removeClass('show');
        });

        // Apply server-side filtering
        function applyServerSideFilter(filterType) {
            const url = buildURL();

            // Set or remove filter parameter
            if (filterType && filterType !== 'all') {
                url.searchParams.set('filter_type', filterType);
            } else {
                url.searchParams.delete('filter_type');
            }

            // Reset to first page when filtering
            url.searchParams.delete('page');

            // Load filtered results from server
            loadTable(url.toString());
        }

        // Update filter counts from server response
        function updateFilterCounts() {
            // These counts will be provided by the server in the view
            // The counts should be passed from the controller
            console.log('Filter counts updated from server data');
        }

        function loadTable(url) {
            $.ajax({
                url: url,
                type: 'GET',
                beforeSend: function() {
                    $('.table-container').html(
                        '<div class="text-center py-5">' +
                        '<div class="spinner-border text-primary" role="status">' +
                        '<span class="visually-hidden">Loading...</span>' +
                        '</div></div>'
                    );
                },
                success: function(response) {
                    $('.table-container').html(response);
                    bindEvents();
                    updateFilterInfo(response);
                    updateURL(url);

                    // Update filter counts from server response
                    updateFilterCountsFromResponse(response);

                    // Re-sync sorting after loading new content
                    syncSortingWithURL();
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    Swal.fire({
                        title: 'Error!',
                        text: 'Gagal memuat data laporan',
                        icon: 'error'
                    });
                }
            });
        }

        function updateFilterCountsFromResponse(response) {
            try {
                // Extract filter counts from the response
                const tempDiv = $('<div>').html(response);

                // Look for count data in the response
                const countData = tempDiv.find('[data-filter-counts]').data('filter-counts');
                if (countData) {
                    $('#all-count').text(countData.all || 0);
                    $('#pdf-count').text(countData.pdf || 0);
                    $('#doc-count').text(countData.doc || 0);
                    $('#excel-count').text(countData.excel || 0);
                    $('#image-count').text(countData.image || 0);
                    $('#other-count').text(countData.other || 0);
                }
            } catch (e) {
                console.log('Could not update filter counts from response');
            }
        }

        function bindEvents() {
            // Remove all previous event bindings to prevent duplicates
            $(document).off('click.customFilter change.customFilter input.customFilter');

            // Pagination links
            $(document).on('click.customFilter', '.pagination-link', function(e) {
                e.preventDefault();
                const url = $(this).attr('href');
                if (url) loadTable(url);
            });

            // Per page selector
            $(document).on('change.customFilter', 'select[name="per_page"]', function() {
                const url = buildURL();
                url.searchParams.set('per_page', $(this).val());
                url.searchParams.delete('page');
                loadTable(url.toString());
            });

            // Sorting links
            $(document).on('click.customFilter', '.sortable, .sort-link', function(e) {
                e.preventDefault();

                const sortBy = $(this).data('sort');
                const url = buildURL();

                // Get current sorting from URL parameters
                const currentSortBy = url.searchParams.get('sort_by');
                const currentOrder = url.searchParams.get('order');

                let newOrder;

                if (currentSortBy === sortBy) {
                    // Same column clicked - cycle through: asc -> desc -> no sort
                    if (currentOrder === 'asc') {
                        newOrder = 'desc';
                    } else if (currentOrder === 'desc') {
                        // Remove sorting (back to default)
                        url.searchParams.delete('sort_by');
                        url.searchParams.delete('order');
                        url.searchParams.delete('page');

                        // Update visual indicators
                        updateSortingVisuals();

                        loadTable(url.toString());
                        return;
                    } else {
                        newOrder = 'asc';
                    }
                } else {
                    // Different column clicked - start with asc
                    newOrder = 'asc';
                }

                // Set new sorting parameters
                url.searchParams.set('sort_by', sortBy);
                url.searchParams.set('order', newOrder);
                url.searchParams.delete('page');

                // Update visual indicators immediately
                updateSortingVisuals(sortBy, newOrder);

                loadTable(url.toString());
            });

            // Search input with debounce
            let searchTimeout;
            $(document).on('input.customFilter', '#search', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    applySearch();
                }, 300);
            });
        }

        function applySearch() {
            const url = buildURL();
            const search = $('#search').val().trim();

            // Set or remove search parameter
            if (search) {
                url.searchParams.set('search', search);
            } else {
                url.searchParams.delete('search');
            }

            // Reset to first page when searching
            url.searchParams.delete('page');

            // Preserve per_page setting
            const perPage = $('select[name="per_page"]').val();
            if (perPage && perPage !== '10') {
                url.searchParams.set('per_page', perPage);
            }

            // Load search results
            loadTable(url.toString());
        }

        function buildURL() {
            return new URL(window.location.href);
        }

        function initializeSortingFromURL() {
            const urlParams = new URLSearchParams(window.location.search);
            const sortBy = urlParams.get('sort_by');
            const order = urlParams.get('order');
            const filterType = urlParams.get('filter_type') || 'all';

            // Set search value from URL
            $('#search').val(urlParams.get('search') || '');
            $('select[name="per_page"]').val(urlParams.get('per_page') || '10');

            // Set filter from URL
            currentFilter = filterType;
            $('.filter-option').removeClass('active');
            $(`.filter-option[data-filter="${filterType}"]`).addClass('active');

            // Update filter button
            if (filterType !== 'all') {
                $('#filterBtn').addClass('filter-active');
                const filterText = $(`.filter-option[data-filter="${filterType}"] span`).first().text().trim();
                $('#filterBtn span').text(filterText);
            }

            updateSortingVisuals(sortBy, order);
        }

        function syncSortingWithURL() {
            const urlParams = new URLSearchParams(window.location.search);
            const sortBy = urlParams.get('sort_by');
            const order = urlParams.get('order');
            const filterType = urlParams.get('filter_type') || 'all';

            // Sync search input
            $('#search').val(urlParams.get('search') || '');

            // Sync per_page selector
            const perPage = urlParams.get('per_page') || '10';
            $('select[name="per_page"]').val(perPage);

            // Sync filter
            currentFilter = filterType;
            $('.filter-option').removeClass('active');
            $(`.filter-option[data-filter="${filterType}"]`).addClass('active');

            updateSortingVisuals(sortBy, order);
        }

        function updateSortingVisuals(activeSortBy = null, activeOrder = null) {
            // Reset all sort indicators
            $('.sort-link').each(function() {
                const $link = $(this);
                const $icon = $link.find('i');
                const sortBy = $link.data('sort');

                // Update data-order for next click
                if (sortBy === activeSortBy) {
                    $link.data('order', activeOrder);

                    // Update icon based on current state
                    if (activeOrder === 'asc') {
                        $icon.removeClass('fa-sort fa-sort-down text-muted').addClass('fa-sort-up');
                    } else if (activeOrder === 'desc') {
                        $icon.removeClass('fa-sort fa-sort-up text-muted').addClass('fa-sort-down');
                    } else {
                        $icon.removeClass('fa-sort-up fa-sort-down').addClass('fa-sort text-muted');
                    }
                } else {
                    // Reset other columns
                    $link.data('order', 'asc');
                    $icon.removeClass('fa-sort-up fa-sort-down').addClass('fa-sort text-muted');
                }
            });
        }

        function updateFilterInfo(response) {
            try {
                const tempDiv = $('<div>').html(response);
                const showingInfo = tempDiv.find('#filter-info, .showing-info').text();
                if (showingInfo) {
                    $('#filter-info, .showing-info').text(showingInfo);
                }
            } catch (e) {
                console.log('Could not update filter info');
            }
        }

        function updateURL(url) {
            if (window.history && window.history.pushState) {
                window.history.pushState({}, '', url);
            }
        }

        // Handle browser back/forward buttons
        window.onpopstate = function() {
            syncSortingWithURL();
            loadTable(window.location.href);
        };

        // Initialize event bindings
        bindEvents();

        // Keyboard shortcuts
        $(document).keydown(function(e) {
            if ((e.ctrlKey || e.metaKey) && e.keyCode === 70) { // Ctrl+F
                e.preventDefault();
                $('#search').focus();
            }

            if (e.keyCode === 27) { // Escape
                $('#search').val('').trigger('input');
                // Reset filter
                currentFilter = 'all';
                $('.filter-option').removeClass('active');
                $('.filter-option[data-filter="all"]').addClass('active');
                $('#filterBtn').removeClass('filter-active');
                $('#filterBtn span').text('Filter');
                applyServerSideFilter('all');
            }
        });

        // Delete functionality
        window.destroyItem = function(button) {
            const route = button.dataset.route;

            Swal.fire({
                title: "Apakah Anda Yakin?",
                html: "<p style='text-align:center'>Setelah data laporan dihapus, Anda tidak bisa mengembalikannya!</p>",
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
                                text: response.message || 'Data laporan berhasil dihapus',
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false
                            });

                            loadTable(window.location.href);
                        },
                        error: function(xhr) {
                            Swal.close();

                            try {
                                const response = JSON.parse(xhr.responseText);
                                Swal.fire({
                                    title: 'Error!',
                                    text: response.message || 'Gagal menghapus data laporan',
                                    icon: 'error'
                                });
                            } catch (e) {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Gagal menghapus data laporan',
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
    });
        </script>
    @endif
@endsection
