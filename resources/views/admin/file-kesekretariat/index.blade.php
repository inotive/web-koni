@extends('layouts.app')

@section('pageTitle', 'Manajemen File')
@section('mainSection', 'File Kesekretariat')
@section('currentSection', 'File Management')

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

        .dropdown-menu {
            z-index: 1055 !important;
            position: absolute !important;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
            border: 1px solid rgba(0, 0, 0, 0.15) !important;
        }

        .dropdown {
            position: relative;
            z-index: 1000;
        }

        /* Untuk baris terakhir, gunakan dropup */
        .table tbody tr:nth-last-child(-n+2) .dropdown-menu {
            top: auto !important;
            bottom: 100% !important;
            transform: translateY(-8px);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .card-body {
                overflow-x: auto !important;
                overflow-y: visible !important;
            }

            .table-responsive {
                overflow-x: auto !important;
                overflow-y: visible !important;
            }

            .dropdown-menu {
                position: absolute !important;
                z-index: 9999 !important;
                right: 0 !important;
                left: auto !important;
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
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
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
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
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

                    {{-- Search + Filter - SAMA SEPERTI CABOR --}}
<div class="d-flex align-items-center gap-2 flex-wrap">
    {{-- Search --}}
    <div class="input-group border rounded" style="width: 230px;">
        <span class="input-group-text bg-transparent border-0">
            <i class="fas fa-search"></i>
        </span>
        <input type="search" name="search" id="search"
            class="form-control border-0 py-2" placeholder="Cari nama dokumen..."
            value="{{ request('search') }}">
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
                    <option value="pdf" {{ request('file_type') == 'pdf' ? 'selected' : '' }}>PDF</option>
                    <option value="doc" {{ request('file_type') == 'doc' ? 'selected' : '' }}>DOC</option>
                    <option value="docx" {{ request('file_type') == 'docx' ? 'selected' : '' }}>DOCX</option>
                    <option value="xls" {{ request('file_type') == 'xls' ? 'selected' : '' }}>XLS</option>
                    <option value="xlsx" {{ request('file_type') == 'xlsx' ? 'selected' : '' }}>XLSX</option>
                </select>
            </div>

            <div class="d-flex gap-2">
                <button type="button" id="apply-filters"
                    class="btn btn-primary btn-sm flex-fill">
                    <i class="fas fa-check"></i> Terapkan
                </button>
                <button type="button" id="reset-filters"
                    class="btn btn-light btn-sm flex-fill">
                    <i class="fas fa-redo"></i> Reset
                </button>
            </div>
        </div>
    </div>
</div>
                </div>
            </div>

            {{-- Card Body --}}
            <div class="card-body">
                @if ($files->isEmpty())
                    {{-- Empty State --}}
                    <div class="text-center text-muted py-10">
                        <i class="ki-duotone ki-folder-open fs-3x mb-3"></i>
                        <h4>Belum ada file yang ditambahkan</h4>
                        <p>Klik tombol "Tambah File" untuk menambahkan file baru</p>
                    </div>
                @else
                    {{-- Data Table --}}
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle"
                            id="kt_datatable_dom_positioning_files">
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

                            <tbody>
                                @forelse ($files as $index => $file)
                                    <tr id="file-row-{{ $file->id }}">
                                        <td class="text-center">{{ $index + 1 }}</td>
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
                                            <div class="d-flex justify-content-center gap-2">
                                                <a href="{{ route('admin.file-kesekretariat.show', $file) }}"
                                                    class="btn btn-sm btn-icon btn-light-primary" title="Lihat">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.file-kesekretariat.edit', $file) }}"
                                                    class="btn btn-sm btn-icon btn-light-warning" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" 
                                                    class="btn btn-sm btn-icon btn-light-danger delete-btn" 
                                                    title="Hapus"
                                                    data-file-id="{{ $file->id }}"
                                                    data-file-name="{{ $file->nama_dokumen }}"
                                                    data-delete-url="{{ route('admin.file-kesekretariat.destroy', $file) }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5 text-muted">Data tidak ditemukan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination Laravel --}}
                    <div class="pagination-boxed">
                        <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap">
                            {{-- kiri : per-page --}}
                            <div class="d-flex align-items-center">
                                <span class="me-2 small">Show</span>
                                <select name="per_page" class="form-select form-select-sm w-auto"
                                    onchange="location.href='{{ request()->fullUrlWithQuery(['per_page' => '']) }}' + this.value">
                                    @foreach ([10, 25, 50, 100] as $limit)
                                        <option value="{{ $limit }}"
                                            {{ request('per_page', 10) == $limit ? 'selected' : '' }}>
                                            {{ $limit }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="ms-2 small">per page</span>
                            </div>

                            {{-- kanan : info + prev + nomor + next --}}
                            <div class="d-flex align-items-center gap-1">
                                <div class="text-muted small me-2">
                                    {{ $files->firstItem() }}-{{ $files->lastItem() }} of {{ $files->total() }}
                                </div>

                                {{-- Previous --}}
                                <a href="{{ $files->previousPageUrl() ?? '#' }}"
                                    class="btn btn-sm {{ $files->onFirstPage() ? 'btn-outline-secondary disabled' : 'btn-outline-primary' }}">
                                    ←
                                </a>

                                {{-- Numbers --}}
                                @foreach ($files->getUrlRange(1, $files->lastPage()) as $page => $url)
                                    @if ($page == $files->currentPage())
                                        <span class="btn btn-sm btn-primary active">{{ $page }}</span>
                                    @else
                                        <a href="{{ $url }}"
                                            class="btn btn-sm btn-outline-primary">{{ $page }}</a>
                                    @endif
                                @endforeach

                                {{-- Next --}}
                                <a href="{{ $files->nextPageUrl() ?? '#' }}"
                                    class="btn btn-sm {{ $files->hasMorePages() ? 'btn-outline-primary' : 'btn-outline-secondary disabled' }}">
                                    →
                                </a>
                            </div>
                        </div>
                    </div>
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
    @if ($files->isNotEmpty())
        <script>
    $(document).ready(function() {
        // ✅ SAMA SEPERTI CABANG OLAHRAGA
        let isLoading = false;
        let searchTimeout;
        let clickTimeout;

        const baseUrl = "{{ route('admin.file-kesekretariat.index') }}";

        function performAjaxRequest(params = {}, showLoading = true) {
            if (isLoading) return Promise.reject('Request in progress');
            if (showLoading) showTableLoading();

            const newParams = new URLSearchParams(window.location.search);
            for (let [key, value] of Object.entries(params)) {
                if (value === '' || value === null) newParams.delete(key);
                else newParams.set(key, value);
            }

            const url = `${baseUrl}?${newParams.toString()}`;
            return $.ajax({
                url: url,
                type: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json, text/html',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                timeout: 15000,
                cache: false
            }).done(function(response) {
                if (typeof response === 'string') {
                    const $response = $(response);
                    $('#tableContainer').html($response.find('#tableContainer').html());
                    $('.pagination-boxed').html($response.find('.pagination-boxed').html());
                    window.history.pushState({}, '', url);
                } else {
                    console.warn('Invalid response');
                }
            }).always(() => hideTableLoading());
        }

        function updateFilterCountBadge() {
            let count = 0;
            if ($('#filter-file-type').val()) count++;
            $('#filter-count').text(count).toggleClass('d-none', count === 0);
        }

        $('#search').on('input', function () {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                performAjaxRequest({ search: $(this).val().trim(), page: 1 });
                updateFilterCountBadge();
            }, 500);
        });

        $(document).on('change', '#filter-file-type', function () {
            performAjaxRequest({ file_type: $(this).val(), page: 1 });
            updateFilterCountBadge();
        });

        $(document).on('click', '#apply-filters', function () {
            performAjaxRequest({
                search: $('#search').val().trim(),
                file_type: $('#filter-file-type').val(),
                page: 1
            });
            updateFilterCountBadge();
        });

        $(document).on('click', '#reset-filters', function () {
            $('#search').val('');
            $('#filter-file-type').val('');
            performAjaxRequest({ search: '', file_type: '', page: 1 });
            updateFilterCountBadge();
        });

        $(document).on('submit', 'form', e => e.preventDefault());
        updateFilterCountBadge();
    });
</script>
    @endif
@endsection