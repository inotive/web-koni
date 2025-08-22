@extends('layouts.app')

@section('pageTitle', 'Manajemen File')
@section('mainSection', 'File Kesekretariat')
@section('currentSection', 'File Kesekretariat')

@section('style')
    <style>
        /* =================================
   BASIC LAYOUT & COLORS - UPDATED
================================= */
body {
    background-color: #ffffff; /* Changed from #f5f5f5 to white like file 1 */
}

.card {
    overflow: visible !important;
    border: none;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border-radius: 12px;
    background-color: #ffffff; /* Ensure card background is white */
}

.card-body {
    overflow: visible !important;
    background-color: #ffffff; /* Ensure card body background is white */
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
    background-color: #ffffff; /* White background */
}

.table-loading {
    opacity: 0.6;
    pointer-events: none;
}

/* Table Headers - Updated to match file 1 gray styling */
.table thead th {
    text-align: center !important;
    vertical-align: middle !important;
    background-color: #f8f9fa !important; /* Gray background like file 1 */
    border-bottom: 2px solid #e9ecef;
    font-weight: 600;
    color: #495057;
    padding: 1rem 0.75rem; /* Added consistent padding */
}

.table thead th a {
    justify-content: center;
    color: inherit;
    text-decoration: none;
}

/* Basic table cells */
.table {
    background-color: #ffffff; /* White table background */
}

.table td,
.table th {
    vertical-align: middle;
    word-wrap: break-word;
    max-width: 200px;
    background-color: #ffffff; /* White cell background */
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
    background-color: #ffffff; /* White background */
}

.table th:nth-child(2),
.table td:nth-child(2) {
    width: 40% !important;
    padding: 0.75rem !important;
    max-width: 30% !important;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    background-color: #ffffff; /* White background */
}

.table th:nth-child(3),
.table td:nth-child(3) {
    width: 35% !important;
    padding: 0.75rem !important;
    background-color: #ffffff; /* White background */
}

.table th:nth-child(4),
.table td:nth-child(4) {
    width: 5% !important;
    min-width: 50px !important;
    max-width: 6% !important;
    text-align: center;
    padding: 0.5rem 0.25rem !important;
    background-color: #ffffff; /* White background */
}

/* Table Row Hover Effects */
.table tbody {
    position: relative;
    z-index: 1;
    background-color: #ffffff; /* White background */
}

.table tbody tr {
    position: relative;
    transition: all 0.2s ease;
    background-color: #ffffff; /* White background */
}

.table tbody tr:hover {
    z-index: 10;
    background-color: rgba(248, 40, 90, 0.03);
}

/* =================================
   SORTING FUNCTIONALITY
================================= */
.table th.sortable {
    cursor: pointer;
    position: relative;
    transition: background-color 0.2s ease;
    background-color: #f8f9fa !important; /* Ensure gray background is maintained */
}

.table th.sortable:hover {
    background-color: #e9ecef !important; /* Darker gray on hover */
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

.document-name-display > .text-truncate {
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
.file-icon-pdf { color: #dc3545; }
.file-icon-doc { color: #0d6efd; }
.file-icon-xls { color: #198754; }
.file-icon-default { color: #6c757d; }

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
    background-color: #ffffff; /* White background for main container */
    border-radius: 8px;
    padding: 1.5rem;
}

.d-grid {
    background-color: #ffffff; /* White background for grid container */
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
    background-color: #ffffff; /* White background */
}

.form-control:focus {
    border-color: #F8285A;
    box-shadow: 0 0 0 3px rgba(248, 40, 90, 0.1);
    background-color: #ffffff; /* Maintain white background on focus */
}

.is-invalid {
    border-color: #dc3545;
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
    background-color: #ffffff; /* White background */
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
    background-color: #ffffff; /* White background */
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
    background-color: #ffffff; /* White background */
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
    border-color: #dc3545;
    background-color: #f8d7da;
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
    background-color: #ffffff; /* White background */
}

.modal-header {
    border-bottom: 1px solid #eee;
    padding: 20px 24px;
    background-color: #ffffff; /* White background */
}

.modal-body {
    padding: 24px;
    background-color: #ffffff; /* White background */
}

.modal-footer {
    border-top: 1px solid #eee;
    padding: 16px 24px;
    background-color: #ffffff; /* White background */
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

.toast.success { border-left-color: #28a745; }
.toast.error { border-left-color: #dc3545; }

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
    background-color: #ffffff; /* White background */
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
    background-color: #ffffff; /* White background */
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
    background-color: #ffffff !important; /* Force white background for entire page */
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
        background-color: #ffffff; /* White background */
    }

    .table th:nth-child(2),
    .table td:nth-child(2) {
        width: 45% !important;
        background-color: #ffffff; /* White background */
    }

    .table th:nth-child(3),
    .table td:nth-child(3) {
        width: 35% !important;
        background-color: #ffffff; /* White background */
    }

    .table th:nth-child(4),
    .table td:nth-child(4) {
        width: 8% !important;
        min-width: 60px !important;
        background-color: #ffffff; /* White background */
    }

    .table-footer {
        flex-direction: column;
        align-items: stretch;
        gap: 1rem;
        background-color: #ffffff; /* White background */
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
        background-color: #ffffff !important; /* White background on mobile */
    }
}
    </style>
@endsection

@section('content')
    <div class="d-grid gap-5 border-0">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center container">
            <div class="d-none d-md-block">
                <h1>File Kesekretariat</h1>
                <span>Manajemen File Dokumen Kesekretariat Anda Sekarang</span>
            </div>

            <!-- Filter Form -->
            <form id="filter" class="d-flex gap-3 filter-container">
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
    <h3 class="fw-bold fs-4 mb-3">Daftar File Kesekretariat - 2025</h3>
    <div id="tableContainer">
        @include('admin.file-kesekretariat._table', ['files' => $files])
    </div>
</div>

    <!-- Toast Container -->
    <div class="toast-container" id="toast-container"></div>

    <!-- Add File Modal -->
    <div class="modal fade" id="tambahFileModal" tabindex="-1" aria-labelledby="tambahFileModalLabel" aria-hidden="true">
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
                        <input type="text" 
                               name="nama_dokumen" 
                               placeholder="Masukkan nama dokumen"
                               class="form-control bg-light border border-gray-400" 
                               required>
                        <div class="invalid-feedback" id="nama_dokumen_error"></div>
                    </div>

                    <!-- Document Date Field -->
                    <div>
                        <div class="fw-semibold required mb-3 text-gray-800">Tanggal Dokumen</div>
                        <input type="date" 
                               name="tanggal_dokumen" 
                               class="form-control bg-light border border-gray-400" 
                               required>
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
                                    <span class="fs-7 fw-semibold text-gray-500">Format: PDF, DOC, DOCX, XLS, XLSX. Max. 10 MB.</span>
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

            // Perform delete request
            $.ajax({
                url: deleteUrl,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function(response) {
                    Swal.close();
                    if (response.success) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: response.message || 'File berhasil dihapus',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        });

                        // Remove the row from table
                        $(`#file-row-${fileId}`).fadeOut(300, function() {
                            $(this).remove();

                            // Check if table is empty after deletion
                            if ($('#tableBody tr:visible').length === 0) {
                                performSearch(); // Reload the page content
                            }
                        });
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
                title: "Aksi Dibatalkan :)",
                icon: "info",
                timer: 1500,
                showConfirmButton: false
            });
        }
    });
}

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
        if ($(this).find('i').length === 0) {
            const fileName = $(this).text().trim();
            const extension = fileName.split('.').pop();
            const iconClass = getFileIcon(extension);

            // Tambahkan ikon sebelum nama file
            $(this).prepend(`<i class="${iconClass}"></i>`);
        }
    });
}

function debounce(func, delay) {
    let timeout;
    return function() {
        const context = this,
            args = arguments;
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(context, args), delay);
    };
}

// Fixed JavaScript code for file management
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
            const input = $(`input[name="${field}"]`);
            const errorDiv = $(`#${field}_error`);

            input.addClass('is-invalid');
            errorDiv.text(messages[0]);
        });
    }

    // Untuk dropdown baru (kalau pakai .dropdown-toggle-custom)
$(document).on('click', '.dropdown-toggle-custom', function (e) {
    e.stopPropagation();
    const $menu = $(this).next('.dropdown-menu-custom');
    $('.dropdown-menu-custom').not($menu).removeClass('show');
    $menu.toggleClass('show');
});

$(document).on('click', function () {
    $('.dropdown-menu-custom').removeClass('show');
});

    function initializeCustomDropzone() {
        const dropzoneElement = document.getElementById('dropzone-tambahFileForm');
        if (!dropzoneElement) return;
        
        const fileInput = document.createElement('input');
        fileInput.type = 'file';
        fileInput.name = 'dokumen_file';
        fileInput.accept = '.pdf,.doc,.docx,.xls,.xlsx';
        fileInput.style.display = 'none';
        fileInput.required = true;
        
        // Append hidden file input to form
        document.getElementById('tambahFileForm').appendChild(fileInput);
        
        let dragCounter = 0;
        
        // Click to select file
        dropzoneElement.addEventListener('click', function(e) {
            e.preventDefault();
            fileInput.click();
        });
        
        // File selection handler
        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                handleFileSelection(file, dropzoneElement);
            }
        });
        
        // Drag and drop handlers
        dropzoneElement.addEventListener('dragenter', function(e) {
            e.preventDefault();
            e.stopPropagation();
            dragCounter++;
            dropzoneElement.classList.add('drag-over');
        });
        
        dropzoneElement.addEventListener('dragleave', function(e) {
            e.preventDefault();
            e.stopPropagation();
            dragCounter--;
            if (dragCounter === 0) {
                dropzoneElement.classList.remove('drag-over');
            }
        });
        
        dropzoneElement.addEventListener('dragover', function(e) {
            e.preventDefault();
            e.stopPropagation();
        });
        
        dropzoneElement.addEventListener('drop', function(e) {
            e.preventDefault();
            e.stopPropagation();
            dragCounter = 0;
            dropzoneElement.classList.remove('drag-over');
            
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                const file = files[0];
                // Set file to input
                const dt = new DataTransfer();
                dt.items.add(file);
                fileInput.files = dt.files;
                
                handleFileSelection(file, dropzoneElement);
            }
        });
    }

    // Handle file selection and validation
    function handleFileSelection(file, dropzoneElement) {
        // File validation
        const maxSize = 10 * 1024 * 1024; // 10MB
        const allowedTypes = [
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        ];
        
        // Clear previous errors
        const errorDiv = document.getElementById('dokumen_file_error');
        errorDiv.textContent = '';
        dropzoneElement.classList.remove('error');
        
        // Validate file size
        if (file.size > maxSize) {
            errorDiv.textContent = 'Ukuran file tidak boleh lebih dari 10MB';
            dropzoneElement.classList.add('error');
            return false;
        }
        
        // Validate file type
        if (!allowedTypes.includes(file.type)) {
            errorDiv.textContent = 'Format file tidak didukung. Gunakan PDF, DOC, DOCX, XLS, atau XLSX';
            dropzoneElement.classList.add('error');
            return false;
        }
        
        // Show file preview
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

    // Get file icon for preview
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

    // Remove selected file
    function removeSelectedFile() {
        const dropzoneElement = document.getElementById('dropzone-tambahFileForm');
        const fileInput = document.querySelector('#tambahFileForm input[type="file"]');
        
        // Clear file input
        if (fileInput) {
            fileInput.value = '';
        }
        
        // Reset dropzone to original state
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
        
        // Clear any error messages
        const errorDiv = document.getElementById('dokumen_file_error');
        if (errorDiv) {
            errorDiv.textContent = '';
        }
        dropzoneElement.classList.remove('error');
    }

    // Make removeSelectedFile globally available
    window.removeSelectedFile = removeSelectedFile;

    // Initialize all event handlers (called after AJAX content update)
    function initializeEventHandlers() {
        // Remove existing handlers to prevent duplicates
        $(document).off('click.sorting', 'th.sortable');
        $(document).off('click.dropdown', '.dropdown-toggle-action');
        $(document).off('click.delete', '.delete-btn');
        $(document).off('click.pagination', '.page-link');

        // Sorting functionality - FIXED
        $(document).on('click.sorting', 'th.sortable', function(e) {
            e.preventDefault();
            
            const sortBy = $(this).data('sort');
            let currentOrder = $(this).data('order') || 'asc';
            const newOrder = currentOrder === 'asc' ? 'desc' : 'asc';

            console.log('Sorting clicked:', sortBy, 'Current:', currentOrder, 'New:', newOrder);

            // Update the data-order attribute for next click
            $(this).data('order', newOrder);

            // Perform search with sorting
            performSearch({
                page: 1,
                sort_by: sortBy,
                order: newOrder
            }, true);
        });

        // Dropdown functionality
        $(document).on('click.dropdown', '.dropdown-toggle-action', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            // Close other dropdowns
            $('.dropdown-menu-action').removeClass('show');
            
            // Toggle current dropdown
            $(this).next('.dropdown-menu-action').toggleClass('show');
        });

        // Pagination functionality
        $(document).on('click.pagination', '.page-link', function(e) {
            e.preventDefault();
            const url = $(this).attr('href');
            if (url && url !== '#' && !$(this).parent().hasClass('disabled')) {
                const urlParams = new URLSearchParams(url.split('?')[1]);
                const page = urlParams.get('page');
                if (page) {
                    performSearch({ page: page }, true);
                }
            }
        });
    }

    // Perform AJAX search request
    function performSearch(params = {}, showLoadingIndicator = true) {
        if (isLoading) return;

        if (showLoadingIndicator) showLoading();

        const searchParams = new URLSearchParams();

        // Get current form values
        const search = $('#filter input[name="search"]').val().trim();

        // Add parameters
        if (search) searchParams.set('search', search);
        if (params.page) searchParams.set('page', params.page);
        if (params.per_page) searchParams.set('per_page', params.per_page);
        if (params.sort_by) searchParams.set('sort_by', params.sort_by);
        if (params.order) searchParams.set('order', params.order);

        // Keep existing sort parameters if not being changed
        if (!params.sort_by && !params.order) {
            const currentUrl = new URLSearchParams(window.location.search);
            if (currentUrl.get('sort_by')) searchParams.set('sort_by', currentUrl.get('sort_by'));
            if (currentUrl.get('order')) searchParams.set('order', currentUrl.get('order'));
        }

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
                $('#tableContainer').html(
                    '<div class="py-20 text-center"><span class="spinner-border text-danger"></span></div>'
                );
            },
            success: function(response) {
                $('#tableContainer').removeClass('table-loading');
                // Update the table container with new content
                const $response = $(response);
                const $newTableContainer = $response.find('#tableContainer');

                if ($newTableContainer.length) {
                    $('#tableContainer').html($newTableContainer.html());
                    
                    // Re-initialize all event handlers after content update
                    initializeEventHandlers();
                    addFileIcons();
                }

                // Update URL without page reload
                window.history.pushState({}, '', url);
            },
            error: function(xhr, status, error) {
                $('#tableContainer').removeClass('table-loading');
                $('#tableContainer').html(
                    '<div class="py-20 text-center text-danger fw-bold">Terjadi kesalahan saat memuat data.</div>'
                );
                console.error('Search error:', error);
                showNotification('Terjadi kesalahan saat mencari data', 'error');
            },
            complete: function() {
                hideLoading();
            }
        });
    }

    // Fixed form submission function
    function submitForm(formId) {
        const form = $('#' + formId);
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
                performSearch({ page: 1 }, true);
            },
            error: function(xhr) {
                if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
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
                    .html('<i class="fas fa-save me-1"></i>Simpan File');
            }
        });
    }

    // Make functions globally available
    window.submitForm = submitForm;
    window.deleteFile = deleteFile;
    window.showNotification = showNotification;
    window.performSearch = performSearch;

    // Initialize event handlers on page load
    initializeEventHandlers();
    addFileIcons();

    // Button click handlers
    $('#tambahFileBtn').on('click', function() {
        $('#tambahFileModal').modal('show');
    });

    // Handle form submission for adding new file
    $('#tambahFileForm').on('submit', function(e) {
        e.preventDefault();
        submitForm('tambahFileForm');
    });

    // Auto search on input with debounce
    $('#filter input[name="search"]').on('input', debounce(function() {
        performSearch({ page: 1 });
    }, 300));

    // Reset modal when closed
    $('#tambahFileModal').on('hidden.bs.modal', function() {
        $('#tambahFileForm').trigger('reset');
        clearFormErrors();
        removeSelectedFile(); // Reset file selection
    });

    // Initialize dropzone when modal is shown
    $('#tambahFileModal').on('shown.bs.modal', function() {
        initializeCustomDropzone();
    });

    // Close dropdowns when clicking outside
    $(document).on('click', function() {
        $('.dropdown-menu-action').removeClass('show');
    });

    // Prevent dropdown close when clicking inside
    $(document).on('click', '.dropdown-menu-action', function(e) {
        e.stopPropagation();
    });

    // Per page dropdown
    $(document).on('change', 'select[name="per_page"]', function() {
        const perPage = $(this).val();
        performSearch({ page: 1, per_page: perPage }, true);
    });
});

function updatePerPage(perPage) {
    const searchParams = new URLSearchParams(window.location.search);
    searchParams.set('per_page', perPage);
    searchParams.delete('page'); // Reset ke halaman pertama

    const url = "{{ route('admin.file-kesekretariat.index') }}?" + searchParams.toString();
    window.location.href = url;
}

function resetAllFilters() {
    $('#filter input[name="search"]').val('');
    $('#filter-file-type').val('');

    // Trigger search to reload content
    $('#filter input[name="search"]').trigger('input');
}
</script>
@endsection