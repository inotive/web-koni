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
        .table th:nth-child(1) {
            width: 50px;
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
            border: none !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15) !important;
            border-radius: 8px !important;
            padding: 8px 0 !important;
            min-width: 160px !important;
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

        /* File badge styling */
        .file-badge {
            background-color: #e3f2fd;
            color: #1976d2;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
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
                <div class="d-flex align-items-center gap-2 flex-wrap ms-auto">
                    {{-- Add Button --}}
                    <a href="{{ route('admin.file-kesekretariat.create') }}" class="btn custom-red-button"
                        style="background-color: #F8285A !important; color: white !important; border-color: #F8285A !important;">
                        <i class="ki-duotone ki-plus fs-2" style="color: white !important;"></i>Tambah File
                    </a>

                    {{-- Search + Filter --}}
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        {{-- Search --}}
                        <div class="search-container">
                            <div class="input-group border rounded" style="width: 250px;">
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
                    {{-- Empty State --}}
                    <div class="empty-state" id="emptyState">
                        @if (request('search') || request('file_type'))
                            {{-- No search results --}}
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
                            {{-- No data at all --}}
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
                                    <th>
                                        <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'created_at', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}"
                                            class="text-dark text-decoration-none d-flex align-items-center">
                                            File Dokumen
                                            @if (request('sort_by') == 'created_at')
                                                <i
                                                    class="fas fa-arrow-{{ request('order') == 'asc' ? 'up' : 'down' }} ms-1"></i>
                                            @else
                                                <i class="fas fa-sort ms-1 text-muted"></i>
                                            @endif
                                        </a>
                                    </th>
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
                                            <span class="file-badge">{{ $file->dokumen_file }}</span>
                                        </td>
                                        <td class="text-center">
                                            <div class="dropdown">
                                                <button class="btn btn-sm p-0" type="button" data-bs-toggle="dropdown">
                                                    <svg width="32" height="32" viewBox="0 0 32 32" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
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
                                                <ul class="dropdown-menu dropdown-menu-end cursor-pointer">
                                                    <li>
                                                        <a href="{{ route('admin.file-kesekretariat.show', $file->id) }}"
                                                            class="dropdown-item view-btn"
                                                            data-file-url="{{ asset('storage/' . $file->path) }}"
                                                            target="_blank">
                                                            <i class="bi bi-eye"></i> Lihat
                                                        </a>

                                                    </li>
                                                    <li>
                                                        <a href="{{ route('admin.file-kesekretariat.edit', $file) }}"
                                                            class="dropdown-item">
                                                            <i class="fas fa-edit me-2"></i>Edit File
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#" class="dropdown-item delete-btn"
                                                            data-file-id="{{ $file->id }}"
                                                            data-file-name="{{ $file->nama_dokumen }}"
                                                            data-delete-url="{{ route('admin.file-kesekretariat.destroy', $file) }}">
                                                            <i class="fas fa-trash me-2"></i>Hapus File
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr id="noDataRow">
                                        <td colspan="4" class="text-center py-5 text-muted">
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
                    @if ($files->hasPages())
                        <div class="pagination-boxed">
                            <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap">
                                {{-- Left: per-page --}}
                                <div class="d-flex align-items-center">
                                    <span class="me-2 small">Show</span>
                                    <select name="per_page" class="form-select form-select-sm w-auto"
                                        onchange="updatePerPage(this.value)">
                                        @foreach ([10, 25, 50, 100] as $limit)
                                            <option value="{{ $limit }}"
                                                {{ request('per_page', 10) == $limit ? 'selected' : '' }}>
                                                {{ $limit }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="ms-2 small">per page</span>
                                </div>

                                {{-- Right: info + pagination --}}
                                <div class="d-flex align-items-center gap-1">
                                    <div class="text-muted small me-2">
                                        {{ $files->firstItem() }}-{{ $files->lastItem() }} of {{ $files->total() }}
                                    </div>

                                    {{-- Previous --}}
                                    <button type="button"
                                        class="btn btn-sm {{ $files->onFirstPage() ? 'btn-outline-secondary disabled' : 'btn-outline-primary' }}"
                                        {{ $files->onFirstPage() ? 'disabled' : '' }}
                                        onclick="goToPage({{ $files->currentPage() - 1 }})">
                                        ←
                                    </button>

                                    {{-- Numbers --}}
                                    @php
                                        $start = max(1, $files->currentPage() - 2);
                                        $end = min($files->lastPage(), $files->currentPage() + 2);
                                    @endphp

                                    @for ($page = $start; $page <= $end; $page++)
                                        @if ($page == $files->currentPage())
                                            <span class="btn btn-sm btn-primary active">{{ $page }}</span>
                                        @else
                                            <button type="button" class="btn btn-sm btn-outline-primary"
                                                onclick="goToPage({{ $page }})">{{ $page }}</button>
                                        @endif
                                    @endfor

                                    {{-- Next --}}
                                    <button type="button"
                                        class="btn btn-sm {{ $files->hasMorePages() ? 'btn-outline-primary' : 'btn-outline-secondary disabled' }}"
                                        {{ !$files->hasMorePages() ? 'disabled' : '' }}
                                        onclick="goToPage({{ $files->currentPage() + 1 }})">
                                        →
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
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

            // Handle delete from dropdown
            $(document).on('click', '.dropdown-item.delete-btn', function(e) {
                e.preventDefault();

                const fileId = $(this).data('file-id');
                const fileName = $(this).data('file-name');
                const deleteUrl = $(this).data('delete-url');

                $('#fileName').text(fileName);
                $('#confirmDeleteBtn').data('delete-url', deleteUrl);
                $('#confirmDeleteBtn').data('file-id', fileId);

                $('#deleteModal').modal('show');
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
                }, 300); // Reduced timeout for faster response
            });

            // Filter change
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
            });

            // Reset filters button
            $('#reset-filters').on('click', function() {
                $('#search').val('');
                $('#filter-file-type').val('');
                performSearch({
                    page: 1
                });
            });

            // Initialize filter count on page load
            updateFilterCountBadge();

            // Delete functionality
            $(document).on('click', '.delete-btn', function() {
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
                    error: function() {
                        $('#deleteModal').modal('hide');
                        showNotification('Terjadi kesalahan saat menghapus file', 'error');
                    }
                });
            });

            // Show notification
            function showNotification(message, type = 'success') {
                const toast = $(`
                    <div class="toast ${type}" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="4000">
                        <div class="toast-header">
                            <strong class="me-auto">${type === 'success' ? 'Berhasil' : 'Error'}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
                        </div>
                        <div class="toast-body">${message}</div>
                    </div>
                `);

                $('#toast-container').append(toast);
                toast.toast('show');

                // Auto remove after 5 seconds
                setTimeout(() => {
                    toast.remove();
                }, 5000);
            }
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
            searchParams.delete('page'); // Reset to first page

            const url = `{{ route('admin.file-kesekretariat.index') }}?${searchParams.toString()}`;
            window.location.href = url;
        }

        function resetAllFilters() {
            $('#search').val('');
            $('#filter-file-type').val('');

            // Trigger search to reload content
            const event = new Event('input');
            document.getElementById('search').dispatchEvent(event);
        }
    </script>
@endsection
