@extends('layouts.app')

@section('pageTitle', 'Database Bendahara')
@section('mainSection', 'Main Menu')
@section('currentSection', 'Database Bendahara')
@section('style')
    <style>

        .preview:hover {
            background-color: #F4EEFF !important;
        }

        .edit:hover {
            background-color: rgb(249, 245, 172) !important;
        }

        .delete:hover {
            background-color: #ffcad7ff !important;
        }

        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Enhanced search and filter styling */
        .filter-container {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .search-container {
            position: relative;
            width: 180px;
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

        /* Filter dropdown styling */
        .filter-dropdown {
            position: relative;
            width: 200px;
        }

        .filter-btn {
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 8px 16px;
            font-size: 0.95rem;
            color: #495057;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            text-align: left;
        }

        .filter-btn:hover {
            border-color: #F8285A;
            color: #F8285A;
        }

        .filter-btn.filter-active {
            background-color: #F8285A;
            border-color: #F8285A;
            color: white;
        }

        .filter-menu {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            z-index: 1000;
            margin-top: 4px;
            display: none;
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

        .filter-option .filter-count {
            font-size: 0.85rem;
            opacity: 0.8;
        }

        /* Search highlight */
        .search-highlight {
            background-color: #fff3cd;
            padding: 1px 3px;
            border-radius: 3px;
            font-weight: bold;
        }

        /* File type badges with consistent colors */
        .badge-danger { background-color: #dc3545 !important; }
        .badge-primary { background-color: #0d6efd !important; }
        .badge-success { background-color: #198754 !important; }
        .badge-warning { background-color: #fd7e14 !important; }
        .badge-secondary { background-color: #6c757d !important; }

        /* Loading state */
        .table-loading {
            opacity: 0.6;
            pointer-events: none;
        }

        /* Fix pagination dropdown arrow */
        #per_page {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6,9 12,15 18,9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 8px center;
            background-size: 16px;
            padding-right: 32px !important;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .filter-container {
                flex-direction: column;
                align-items: stretch;
                gap: 10px;
            }

            .search-container {
                width: 100%;
            }

            .filter-dropdown {
                width: 100%;
            }
        }

        /* File preview modal styling */
        .preview-modal .modal-dialog {
            max-width: 90vw;
            height: 90vh;
        }

        .preview-modal .modal-content {
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .preview-modal .modal-body {
            flex: 1;
            padding: 0;
            overflow: hidden;
        }

        .preview-modal iframe {
            width: 100%;
            height: 100%;
            border: none;
        }

        .preview-error {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 300px;
            text-align: center;
            color: #6c757d;
        }

        .preview-error i {
            font-size: 4rem;
            margin-bottom: 1rem;
            color: #dc3545;
        }

        .dropdown-wrapper .dropdown-menu {
            position: fixed !important;
            inset: auto auto auto auto !important;
            transform: none !important;
            z-index: 1055;
        }
    </style>
@endsection

@section('content')
    <div class="d-grid gap-5 border-0">
        <div class="d-flex justify-content-between align-items-center container">
            <div class="d-none d-md-block">
                <h1>Database Bendahara</h1>
                <span>Kelola laporan bendahara</span>
            </div>
            <form id="filter" class="d-flex gap-3 filter-container">
                <button type="button" data-bs-toggle="modal" data-bs-target="#add"
                    class="btn btn-active-light-danger d-flex bg-danger align-items-center btn-facebook fw-bold gap-2 rounded border-0 px-4 py-2 text-white">
                    Tambah Laporan
                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
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

                <!-- Enhanced Search Container -->
                <div class="search-container">
                    <div class="position-relative bg-light">
                        <i class="ki-outline ki-magnifier fs-2 search-icon"></i>
                        <input type="text" name="search" value="{{ request('search') }}" data-kt-docs-table-filter="search"
                            placeholder="Cari Laporan" class="form-control border border-gray-500 py-2 search-input" />
                    </div>
                </div>

                <!-- Enhanced Filter Dropdown -->
                <div class="filter-dropdown">
                    <div class="filter-btn {{ (request('filter_type') && request('filter_type') != 'all') ? 'filter-active' : '' }}" id="filterBtn">
                        <span>
                            @if(request('filter_type') == 'pdf')
                                <i class="fas fa-file-pdf me-2" style="color: #dc3545;"></i>File PDF
                            @elseif(request('filter_type') == 'doc')
                                <i class="fas fa-file-word me-2" style="color: #0d6efd;"></i>File DOC/DOCX
                            @elseif(request('filter_type') == 'excel')
                                <i class="fas fa-file-excel me-2" style="color: #198754;"></i>File Excel
                            @elseif(request('filter_type') == 'image')
                                <i class="fas fa-file-image me-2" style="color: #fd7e14;"></i>File Gambar
                            @elseif(request('filter_type') == 'other')
                                <i class="fas fa-file me-2" style="color: #6c757d;"></i>File Lain
                            @else
                                <i class="fas fa-filter me-2"></i>Filter Tipe File
                            @endif
                        </span>
                        <i class="fas fa-chevron-down" style="font-size: 0.8rem;"></i>
                    </div>

                    <div class="filter-menu" id="filterMenu" data-filter-counts="{{ json_encode($fileCounts ?? []) }}">
                        <div class="filter-option {{ (request('filter_type', 'all') == 'all') ? 'active' : '' }}" data-filter="all">
                            <span>
                                <i class="fas fa-list file-type-icon"></i>
                                Semua File
                            </span>
                            <span class="filter-count">{{ $fileCounts['all'] ?? 0 }}</span>
                        </div>
                        <div class="filter-option {{ (request('filter_type') == 'pdf') ? 'active' : '' }}" data-filter="pdf">
                            <span>
                                <i class="fas fa-file-pdf file-type-icon" style="color: #dc3545;"></i>
                                File PDF
                            </span>
                            <span class="filter-count">{{ $fileCounts['pdf'] ?? 0 }}</span>
                        </div>
                        <div class="filter-option {{ (request('filter_type') == 'doc') ? 'active' : '' }}" data-filter="doc">
                            <span>
                                <i class="fas fa-file-word file-type-icon" style="color: #0d6efd;"></i>
                                File DOC/DOCX
                            </span>
                            <span class="filter-count">{{ $fileCounts['doc'] ?? 0 }}</span>
                        </div>
                        <div class="filter-option {{ (request('filter_type') == 'excel') ? 'active' : '' }}" data-filter="excel">
                            <span>
                                <i class="fas fa-file-excel file-type-icon" style="color: #198754;"></i>
                                File Excel
                            </span>
                            <span class="filter-count">{{ $fileCounts['excel'] ?? 0 }}</span>
                        </div>
                        <div class="filter-option {{ (request('filter_type') == 'image') ? 'active' : '' }}" data-filter="image">
                            <span>
                                <i class="fas fa-file-image file-type-icon" style="color: #fd7e14;"></i>
                                File Gambar
                            </span>
                            <span class="filter-count">{{ $fileCounts['image'] ?? 0 }}</span>
                        </div>
                        <div class="filter-option {{ (request('filter_type') == 'other') ? 'active' : '' }}" data-filter="other">
                            <span>
                                <i class="fas fa-file file-type-icon" style="color: #6c757d;"></i>
                                File Lain
                            </span>
                            <span class="filter-count">{{ $fileCounts['other'] ?? 0 }}</span>
                        </div>
                    </div>
                </div>

                <!-- Hidden input for maintaining filter state -->
                <input type="hidden" name="filter_type" id="filter_type_input" value="{{ request('filter_type', 'all') }}">
            </form>
        </div>

        <div id="table" class="container">
            @include('admin.bendahara._table', compact('laporanBendahara', 'fileCounts'))
        </div>

        <!-- Add Modal -->
        <div class="modal fade" id="add" tabindex="-1" aria-labelledby="add" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content rounded-4 gap-5 px-10 py-8">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="fs-2 fw-bold leading-5">Tambah Laporan Bendahara</div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form id="formAdd" action="{{ route('admin.bendahara.store') }}" method="POST"
                        enctype="multipart/form-data" class="d-grid gap-4">
                        @csrf

                        <div>
                            <div class="fw-semibold required mb-3 text-gray-800">Judul Laporan</div>
                            <input type="text" name="judul" placeholder="Masukkan Judul Laporan"
                                class="form-control bg-light border border-gray-400" required />
                        </div>

                        <div>
                            <div class="fw-semibold required mb-3 text-gray-800">Unggah Dokumen</div>
                            <div class="fv-row">
                                <div class="dropzone" id="dropzone-formAdd">
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
                            </div>
                        </div>
                    </form>

                    <div class="d-grid py-4">
                        <button type="button" onclick="submitForm('formAdd')"
                            class="bg-danger fw-bold d-flex align-items-center justify-content-center gap-2 rounded border-0 p-4 text-white">
                            Tambah Laporan
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- File Preview Modal -->
        <div class="modal fade preview-modal" id="filePreviewModal" tabindex="-1" aria-labelledby="filePreviewModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="filePreviewModalLabel">Preview Dokumen</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-0">
                        <div id="previewContainer" class="w-100 h-100">
                            <!-- Preview content will be loaded here -->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a id="downloadBtn" href="#" class="btn btn-primary" target="_blank">
                            <i class="ki-outline ki-down me-2"></i>Download File
                        </a>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function reloadTable(url = null) {
            let formData = $('#filter').serialize();
            let target = url ?? "{{ route('admin.bendahara.index') }}";

            $.ajax({
                url: target,
                data: formData,
                beforeSend: function() {
                    $('#table').addClass('table-loading');
                    $('#table').html(
                        '<div class="py-20 text-center"><span class="spinner-border text-danger"></span></div>'
                    );
                },
                success: function(response) {
                    $('#table').removeClass('table-loading');
                    $('#table').html(response);

                    // Reinitialize dropzones for edit modals
                    initializeDropzones();

                    // Update filter counts
                    updateFilterCountsFromResponse(response);

                    // Update URL without page refresh
                    if (window.history && window.history.pushState) {
                        const url = new URL(window.location);
                        const searchParams = new URLSearchParams(formData);

                        // Update URL parameters
                        for (const [key, value] of searchParams.entries()) {
                            if (value) {
                                url.searchParams.set(key, value);
                            } else {
                                url.searchParams.delete(key);
                            }
                        }

                        window.history.pushState({}, '', url);
                    }
                },
                error: function(xhr) {
                    $('#table').removeClass('table-loading');
                    $('#table').html(
                        '<div class="py-20 text-center text-danger fw-bold">Terjadi kesalahan saat memuat data.</div>'
                    );
                }
            });
        }

        function updateFilterCountsFromResponse(response) {
            try {
                const tempDiv = $('<div>').html(response);
                const countData = tempDiv.find('[data-filter-counts]').data('filter-counts');

                if (countData) {
                    // Update filter menu counts
                    $('.filter-option[data-filter="all"] .filter-count').text(countData.all || 0);
                    $('.filter-option[data-filter="pdf"] .filter-count').text(countData.pdf || 0);
                    $('.filter-option[data-filter="doc"] .filter-count').text(countData.doc || 0);
                    $('.filter-option[data-filter="excel"] .filter-count').text(countData.excel || 0);
                    $('.filter-option[data-filter="image"] .filter-count').text(countData.image || 0);
                    $('.filter-option[data-filter="other"] .filter-count').text(countData.other || 0);
                }
            } catch (e) {
                console.log('Could not update filter counts from response');
            }
        }

        function previewFile(fileUrl, fileName, fileExtension) {
            const modal = new bootstrap.Modal(document.getElementById('filePreviewModal'));
            const previewContainer = document.getElementById('previewContainer');
            const modalTitle = document.getElementById('filePreviewModalLabel');
            const downloadBtn = document.getElementById('downloadBtn');

            // Set modal title and download button
            modalTitle.textContent = fileName;
            downloadBtn.href = fileUrl;

            // Clear previous content
            previewContainer.innerHTML = '';

            // Handle different file types
            const ext = fileExtension.toLowerCase();

            if (ext === 'pdf') {
                // PDF preview
                previewContainer.innerHTML = `
                    <iframe src="${fileUrl}" style="width: 100%; height: 70vh;" frameborder="0">
                        <div class="preview-error">
                            <i class="fas fa-file-pdf"></i>
                            <h5>Cannot display PDF</h5>
                            <p>Your browser doesn't support PDF preview. Please download the file to view it.</p>
                        </div>
                    </iframe>
                `;
            } else if (['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg', 'webp'].includes(ext)) {
                // Image preview
                previewContainer.innerHTML = `
                    <div class="d-flex justify-content-center align-items-center" style="height: 70vh;">
                        <img src="${fileUrl}" class="img-fluid" style="max-height: 100%; max-width: 100%;" alt="${fileName}">
                    </div>
                `;
            } else if (['doc', 'docx'].includes(ext)) {
                // Word document preview using Google Docs Viewer
                previewContainer.innerHTML = `
                    <iframe src="https://docs.google.com/gview?url=${encodeURIComponent(fileUrl)}&embedded=true"
                            style="width: 100%; height: 70vh;" frameborder="0">
                        <div class="preview-error">
                            <i class="fas fa-file-word"></i>
                            <h5>Preview not available</h5>
                            <p>Cannot preview this Word document. Please download the file to view it.</p>
                        </div>
                    </iframe>
                `;
            } else if (['xls', 'xlsx'].includes(ext)) {
                // Excel document preview using Google Docs Viewer
                previewContainer.innerHTML = `
                    <iframe src="https://docs.google.com/gview?url=${encodeURIComponent(fileUrl)}&embedded=true"
                            style="width: 100%; height: 70vh;" frameborder="0">
                        <div class="preview-error">
                            <i class="fas fa-file-excel"></i>
                            <h5>Preview not available</h5>
                            <p>Cannot preview this Excel document. Please download the file to view it.</p>
                        </div>
                    </iframe>
                `;
            } else {
                // Unsupported file type
                previewContainer.innerHTML = `
                    <div class="preview-error">
                        <i class="fas fa-file"></i>
                        <h5>Preview not available</h5>
                        <p>This file type cannot be previewed. Please download the file to view it.</p>
                        <small class="text-muted">File type: ${ext.toUpperCase()}</small>
                    </div>
                `;
            }

            modal.show();
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

        Dropzone.autoDiscover = false;
        const dropzones = {};

        function initializeDropzones() {
            // Clear existing dropzones
            Object.keys(dropzones).forEach(key => {
                if (dropzones[key] && typeof dropzones[key].destroy === 'function') {
                    dropzones[key].destroy();
                    delete dropzones[key];
                }
            });

            // Initialize add form dropzone
            if (document.getElementById('dropzone-formAdd')) {
                dropzones['formAdd'] = new Dropzone("#dropzone-formAdd", {
                    url: "#",
                    autoProcessQueue: false,
                    paramName: 'dokumen',
                    maxFiles: 1,
                    maxFilesize: 10,
                    addRemoveLinks: true,
                    acceptedFiles: '.pdf,.doc,.docx,.xls,.xlsx',
                });
            }

            // Initialize edit form dropzones
            document.querySelectorAll('[id^="dropzone-form-"]').forEach(element => {
                const formId = element.id.replace('dropzone-', '');
                if (!dropzones[formId]) {
                    dropzones[formId] = new Dropzone(`#${element.id}`, {
                        url: "#",
                        autoProcessQueue: false,
                        paramName: 'dokumen',
                        maxFiles: 1,
                        maxFilesize: 10,
                        addRemoveLinks: true,
                        acceptedFiles: '.pdf,.doc,.docx,.xls,.xlsx',
                    });
                }
            });
        }

        $(document).ready(function() {
            let currentFilter = '{{ request("filter_type", "all") }}';

            initializeDropzones();

            // Filter dropdown functionality
            $('#filterBtn').on('click', function(e) {
                e.stopPropagation();
                $('#filterMenu').toggleClass('show');
            });

            // Close dropdown when clicking outside
            $(document).on('click', function() {
                $('#filterMenu').removeClass('show');
            });

            // Filter option selection
            $('.filter-option').on('click', function(e) {
                e.stopPropagation();

                const filterType = $(this).data('filter');
                if (filterType === currentFilter) return;

                // Update active state
                $('.filter-option').removeClass('active');
                $(this).addClass('active');

                // Update button content
                const filterContent = $(this).find('span').first().html();
                $('#filterBtn span').html(filterContent);

                // Update button style for active filter
                if (filterType === 'all') {
                    $('#filterBtn').removeClass('filter-active');
                } else {
                    $('#filterBtn').addClass('filter-active');
                }

                currentFilter = filterType;

                // Update hidden input
                $('#filter_type_input').val(filterType);

                // Apply filter
                reloadTable();

                $('#filterMenu').removeClass('show');
            });

            // Search functionality with debounce
            $(document).on('input', '#filter input[name="search"]', debounce(function() {
                let keyword = $(this).val();
                if (keyword.length >= 1 || keyword.length === 0) {
                    reloadTable();
                }
            }, 300));

            // Per page change
            $(document).on('change', '#per_page', function() {
                reloadTable();
            });

            // Pagination clicks
            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();
                let url = $(this).attr('href');
                if (url) {
                    reloadTable(url);
                }
            });

            // Prevent dropdown from closing when clicking inside
            $('#filterMenu').on('click', function(e) {
                e.stopPropagation();
            });

            // Initialize filter from URL on page load
            const urlParams = new URLSearchParams(window.location.search);
            const filterFromURL = urlParams.get('filter_type') || 'all';
            if (filterFromURL !== currentFilter) {
                $(`.filter-option[data-filter="${filterFromURL}"]`).click();
            }
        });

        function submitForm(formId) {
            let form = document.getElementById(formId);
            let formData = new FormData(form);

            const dz = dropzones[formId];
            if (dz) {
                const files = dz.getAcceptedFiles();
                if (files.length > 0) {
                    files.forEach((file) => {
                        formData.append('dokumen', file);
                    });
                }
            }

            fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: formData,
                })
                .then(async response => {
                    const data = await response.json();

                    if (!response.ok) {
                        $('.modal.show').modal('hide');
                        console.log('Error response from controller:', data);

                        if (data.errors) {
                            for (let field in data.errors) {
                                let msg = data.errors[field].join(', ');
                                toastr.error(msg, "Error!");
                            }
                        } else {
                            toastr.error(data.message || "Gagal menyimpan data", "Error!");
                        }
                    } else {
                        $('.modal.show').modal('hide');
                        toastr.success(data.message || "Data berhasil disimpan", "Success!");

                        // Clear form
                        form.reset();
                        if (dropzones[formId]) {
                            dropzones[formId].removeAllFiles();
                        }

                        reloadTable();
                    }
                })
                .catch(error => {
                    $('.modal.show').modal('hide');
                    console.error('Fetch error:', error);
                    toastr.error("Terjadi kesalahan. Silakan coba lagi.", "Error!");
                });
        }

        function deleteItem(formId) {
            if (confirm('Apakah Anda yakin ingin menghapus laporan ini?')) {
                document.getElementById(formId).submit();
            }
        }
    </script>
@endsection
