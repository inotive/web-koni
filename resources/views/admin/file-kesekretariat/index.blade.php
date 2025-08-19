    @extends('layouts.app')

    @section('pageTitle', 'Manajemen File')
    @section('mainSection', 'File Kesekretariat')

    @section('breadcrumb-title')
    @endsection

    @section('breadcrumb-items')
    @endsection

    @section('content')

    
        <style>

/* BASIC STYLING */
body {
    background-color: #f5f5f5;
}

/* Basic table styling */
table td,
table th {
    vertical-align: middle;
    word-wrap: break-word;
    max-width: 200px;
}

.object-fit-cover {
    object-fit: cover;
}

/* HEADER TABLE - TENGAH & STYLING */
.table thead th {
    text-align: center !important;
    vertical-align: middle !important;
    background-color: #f8f9fa;
    border-bottom: 2px solid #e9ecef;
    font-weight: 600;
    color: #495057;
}

.table thead th a {
    justify-content: center;
    color: inherit;
    text-decoration: none;
}

/* COLUMN WIDTHS - 4 KOLOM */
.table th:nth-child(1),
.table td:nth-child(1) {
    width: 3% !important;
    white-space: nowrap;
    text-align: center;
    padding: 0.5rem 0.25rem !important;
    font-size: 0.9rem !important; /* Font diperbesar */
    font-weight: 700 !important; /* Bold untuk nomor */
    line-height: 1.2;
    min-width: 40px;
}

.table th:nth-child(2),
.table td:nth-child(2) {
    width: 40% !important; /* Nama dokumen + tanggal */
    padding: 0.75rem !important;
}

.table th:nth-child(3),
.table td:nth-child(3) {
    width: 35% !important; /* File dokumen */
    padding: 0.75rem !important;
}

.table th:nth-child(4),
.table td:nth-child(4) {
    width: 5% !important;
    min-width: 50px !important; /* Minimal width untuk aksi */
    max-width: 6% !important;
    text-align: center;
    padding: 0.5rem 0.25rem !important;
}


.document-info {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.document-name {
    font-weight: 600;
    color: #495057;
    text-decoration: none;
    display: block;        /* ganti inline-block → block */
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    min-width: 0;          /* penting supaya bisa menciut */
}

.document-name:hover {
    color: #1B84FF; /* Warna saat hover */
    text-decoration: underline; /* Garis bawah saat hover */
}

.document-name i {
    margin-right: 8px;
    flex-shrink: 0;
    font-size: 16px;
}

.document-date {
    font-size: 12px;
    color: #6c757d;
    font-weight: 400;
    padding-left: 8px;
    font-style: italic;
}

.text-truncate-custom {
    
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}


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
    color: #1B84FF;
    background: #f0f8ff;
    border-color: #1B84FF;
    text-decoration: none;
    transform: translateY(-1px);
}

.file-link i {
    margin-right: 6px;
}


/* Container untuk overflow */
.card {
    overflow: visible !important;
}

.card-body {
    overflow: visible !important;
}

.table-responsive {
    overflow: visible !important;
}

/* Dropdown container */
.dropdown-action {
    position: relative;
    z-index: 1;
}

/* Tombol dropdown */
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
    background-color: #f0f8ff !important;
    border-color: #1B84FF !important;
    transform: translateY(-1px);
    box-shadow: 0 3px 8px rgba(27, 132, 255, 0.2);
}

.dropdown-toggle-action:focus {
    outline: none !important;
    box-shadow: 0 0 0 3px rgba(27, 132, 255, 0.2) !important;
}

.dropdown-toggle-action svg {
    width: 18px !important;
    height: 18px !important;
}

/* Dropdown menu - PERBAIKAN UTAMA UNTUK OVERLAP */
.dropdown-menu-action {
    position: absolute !important;
    right: 0 !important;
    left: auto !important;
    top: 100% !important;
    margin-top: 6px !important;
    border: 1px solid #dee2e6 !important;
    border-radius: 10px !important;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15) !important;
    z-index: 99999 !important; /* Z-index sangat tinggi */
    min-width: 180px !important;
    padding: 10px 0 !important;
    background: white !important;
    display: none !important;
    backdrop-filter: blur(10px);
}

.dropdown-menu-action.show {
    display: block !important;
}

/* Dropdown items */
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
    color: #1B84FF !important;
    transform: translateX(4px) !important;
}

.dropdown-item-action i {
    width: 18px !important;
    font-size: 14px !important;
    margin-right: 10px !important;
    flex-shrink: 0 !important;
}

/* DROPUP untuk baris terakhir - PERBAIKAN UTAMA */
.table tbody tr:nth-last-child(-n+2) .dropdown-menu-action {
    top: auto !important;
    bottom: 100% !important;
    margin-top: 0 !important;
    margin-bottom: 6px !important;
}

/* Table body z-index management */
.table tbody {
    position: relative;
    z-index: 1;
}

.table tbody tr {
    position: relative;
    transition: all 0.2s ease;
}

.table tbody tr:hover {
    z-index: 10;
    background-color: rgba(27, 132, 255, 0.03);
}


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


.empty-state {
    padding: 4rem 2rem;
    text-align: center;
    color: #6c757d;
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
}

.page-item.active .page-link {
    background-color: #1B84FF;
    border-color: #1B84FF;
    color: white;
}

.page-item:not(.disabled) .page-link:hover {
    background-color: #f0f8ff;
    border-color: #1B84FF;
    color: #1B84FF;
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
}


.table th.sortable {
    cursor: pointer;
    position: relative;
    transition: background-color 0.2s ease;
}

.table th.sortable:hover {
    background-color: #e9ecef;
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
    color: #1B84FF;
}


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


.modal-content {
    border-radius: 12px;
    border: none;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
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


.custom-red-button {
    background-color: #F8285A;
    border-color: #F8285A;
    color: white;
    transition: all 0.2s ease;
}

.custom-red-button:hover {
    background-color: #e11e48;
    border-color: #e11e48;
    color: white;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(248, 40, 90, 0.3);
}

@media (max-width: 768px) {
    /* Dropdown positioning di mobile */
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
    
    /* Mobile dropup rule - mulai dari baris ke-2 */
    .table tbody tr:nth-child(n+2) .dropdown-menu-action {
        top: auto !important;
        bottom: 100% !important;
        margin-top: 0 !important;
        margin-bottom: 6px !important;
    }
    
    /* Baris pertama tetap dropdown biasa */
    .table tbody tr:first-child .dropdown-menu-action {
        top: 100% !important;
        bottom: auto !important;
        margin-top: 6px !important;
        margin-bottom: 0 !important;
    }

    /* Column widths for mobile */
    .table th:nth-child(1),
    .table td:nth-child(1) {
        width: 5% !important;
        font-size: 0.8rem !important;
    }

    .table th:nth-child(2),
    .table td:nth-child(2) {
        width: 45% !important;
    }

    .table th:nth-child(3),
    .table td:nth-child(3) {
        width: 35% !important;
    }

    .table th:nth-child(4),
    .table td:nth-child(4) {
        width: 8% !important;
        min-width: 60px !important;
    }

    /* Table footer responsive */
    .table-footer {
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

    /* Document info mobile */
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
}

.table-loading {
    opacity: 0.6;
    pointer-events: none;
}

.loading-spinner {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 3rem;
}

.loading-spinner .spinner-border {
    width: 2.5rem;
    height: 2.5rem;
    color: #1B84FF;
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
<div class="modal fade" id="tambahFileModal" tabindex="-1" aria-labelledby="tambahFileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 gap-5 px-10 py-8">
            <div class="d-flex justify-content-between align-items-center gap-2">
                <div class="fs-2 fw-bold text-truncate leading-5" id="modalTitle">Tambah File Kesekretariat</div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="tambahFileForm" method="POST" action="{{ route('admin.file-kesekretariat.store') }}" enctype="multipart/form-data" class="d-grid gap-4">
                @csrf

                {{-- Nama Dokumen --}}
                <div>
                    <div class="fw-semibold required mb-3 text-gray-800">Nama Dokumen</div>
                    <input type="text" 
                           name="nama_dokumen" 
                           placeholder="Masukkan nama dokumen"
                           class="form-control bg-light border border-gray-400" 
                           required>
                    <div class="invalid-feedback" id="nama_dokumen_error"></div>
                </div>

                {{-- Tanggal Dokumen --}}
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

                {{-- File Upload --}}
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

function initializeCustomDropzone() {
    const dropzoneElement = document.getElementById('dropzone-tambahFileForm');
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

    // Add file icons to file links
    function addFileIcons() {
        $('.file-link').each(function() {
            if ($(this).find('i').length === 0) {
                const fileName = $(this).text().trim();
                const extension = fileName.split('.').pop();
                const iconClass = getFileIcon(extension);
                $(this).prepend(`<i class="${iconClass}" style="margin-right: 8px;"></i>`);
            }
        });
    }

    // Perform AJAX search request
    function performSearch(params = {}, showLoadingIndicator = true) {
        if (isLoading) return;

        if (showLoadingIndicator) showLoading();

        const searchParams = new URLSearchParams();

        // Get current form values
        const search = $('#search').val().trim();

        // Add parameters
        if (search) searchParams.set('search', search);
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
                    // Add file icons after updating content
                    addFileIcons();
                }

                // Update URL without page reload
                window.history.pushState({}, '', url);
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

    // Make submitForm globally available
    window.submitForm = submitForm;

    // Handle form submission for adding new file
    $('#tambahFileForm').on('submit', function(e) {
        e.preventDefault();
        submitForm('tambahFileForm');
    });

    // Auto search on input
    $('#search').on('input', function() {
        clearTimeout(searchTimeout);
        const query = $(this).val().trim();

        searchTimeout = setTimeout(function() {
            performSearch({ page: 1 });
        }, 300);
    });

    // Delete file function
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

                            // Remove the row from table or reload if needed
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
            }
        });
    }

    // Make deleteFile globally available
    window.deleteFile = deleteFile;

    // Handle delete button clicks
    $(document).on('click', '.delete-btn', function(e) {
        e.preventDefault();
        const fileId = $(this).data('file-id');
        const fileName = $(this).data('file-name');
        const deleteUrl = $(this).data('delete-url');
        
        deleteFile(fileId, fileName, deleteUrl);
    });

    // Show notification function
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

    // Make showNotification globally available
    window.showNotification = showNotification;

    // File input change event for validation
    $('#dokumen_file').on('change', function() {
        const file = this.files[0];
        if (file) {
            const maxSize = 10 * 1024 * 1024; // 10MB
            const allowedTypes = [
                'application/pdf',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'application/vnd.ms-excel',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
            ];

            if (file.size > maxSize) {
                $(this).addClass('is-invalid');
                $('#dokumen_file_error').text('Ukuran file tidak boleh lebih dari 10MB');
                return;
            }

            if (!allowedTypes.includes(file.type)) {
                $(this).addClass('is-invalid');
                $('#dokumen_file_error').text('Format file tidak didukung. Gunakan PDF, DOC, DOCX, XLS, atau XLSX');
                return;
            }

            $(this).removeClass('is-invalid');
            $('#dokumen_file_error').empty();
            
            // Show file preview if elements exist
            if ($('#uploadContent').length && $('#filePreview').length) {
                $('#uploadContent').addClass('d-none');
                $('#filePreview').removeClass('d-none');
                $('#fileName').text(file.name);
                $('#fileSize').text((file.size / (1024 * 1024)).toFixed(2) + ' MB');
                
                // Set file icon based on type
                const extension = file.name.split('.').pop().toLowerCase();
                const iconClass = getFileIcon(extension);
                $('#fileIcon').removeClass().addClass(iconClass + ' fa-2x');
            }
        }
    });

    // Reset modal when closed
    $('#tambahFileModal').on('hidden.bs.modal', function() {
        $('#tambahFileForm').trigger('reset');
        clearFormErrors();
        // Reset file preview if exists
        if ($('#filePreview').length && $('#uploadContent').length) {
            $('#filePreview').addClass('d-none');
            $('#uploadContent').removeClass('d-none');
        }
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

    // Close dropdowns when clicking outside
    $(document).on('click', function() {
        $('.dropdown-menu-action').removeClass('show');
    });

    // Prevent dropdown close when clicking inside
    $(document).on('click', '.dropdown-menu-action', function(e) {
        e.stopPropagation();
    });

    // Event listener untuk pagination links
    $(document).on('click', '.pagination-link', function(e) {
        e.preventDefault();
        const url = $(this).attr('href');
        if (url && url !== '#') {
            const page = url.split('page=')[1];
            performSearch({ page: page }, true);
        }
    });

    // Per page dropdown
    $(document).on('click', '.per-page-option', function() {
        const perPage = $(this).data('value');
        performSearch({ page: 1, per_page: perPage }, true);
    });

    // Initial file icons setup
    addFileIcons();
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
