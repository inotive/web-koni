@if ($files->isEmpty())
    <div class="empty-state" id="emptyState">
        @if (request('search'))
            <i class="fas fa-search"></i>
            <h4>Data tidak ditemukan</h4>
            <p>
                Tidak ada file yang sesuai dengan pencarian
                <strong>"{{ request('search') }}"</strong>
            </p>
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
                    <th style="width: 3% !important;">NO</th>
                    <th class="sortable sort-link" data-sort="nama_dokumen">
                        <div class="d-flex justify-content-center align-items-center">
                            <span>NAMA DOKUMEN</span>
                            <span class="sort-icon ms-2">
                                @if (request('sort_by') == 'nama_dokumen')
                                    <i class="fas fa-arrow-{{ request('order') == 'asc' ? 'up' : 'down' }}"></i>
                                @else
                                    <i class="fas fa-sort text-muted"></i>
                                @endif
                            </span>
                        </div>
                    </th>
                    <th class="sortable sort-link" data-sort="dokumen_file" style="width: 25% !important;">
                        <div class="d-flex justify-content-center align-items-center">
                            <span>FILE DOKUMEN</span>
                            <span class="sort-icon ms-2">
                                @if (request('sort_by') == 'dokumen_file')
                                    <i class="fas fa-arrow-{{ request('order') == 'asc' ? 'up' : 'down' }}"></i>
                                @else
                                    <i class="fas fa-sort text-muted"></i>
                                @endif
                            </span>
                        </div>
                    </th>
                    <th style="width: 5% !important;">AKSI</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                @foreach ($files as $file)
                    <tr id="file-row-{{ $file->id }}">
                        <td class="text-center">{{ $files->firstItem() + $loop->index }}</td>
                        <td>
                            <div class="document-info">
                                <div class="document-name-wrapper">
                                    <span class="document-name-text" title="{{ $file->nama_dokumen }}">
                                        {{ $file->nama_dokumen }}
                                    </span>
                                </div>
                                <div class="document-date">
                                    {{ optional($file->created_at)->format('d/m/Y') ?? '-' }}
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            @if ($file->dokumen_file)
                                @php
                                    $fileName = basename($file->dokumen_file);
                                    $fileUrl = route('admin.file-kesekretariat.download', $file);
                                    $fileExtension = strtolower(pathinfo($file->dokumen_file, PATHINFO_EXTENSION));
                                @endphp
                                <div class="document-link-container">
                                    <a href="javascript:void(0)" class="document-link"
                                        onclick="previewFile('{{ $fileUrl }}', '{{ $fileName }}', '{{ $fileExtension }}')"
                                        title="Klik untuk melihat {{ $fileName }}">
                                        <i class="fas fa-file-{{ $fileExtension == 'pdf' ? 'pdf' : 'alt' }} me-2"></i>
                                        {{ Str::limit($fileName, 25) }}
                                    </a>
                                </div>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="dropdown dropdown-action" data-row-id="{{ $file->id }}">
                                <button class="btn btn-sm p-0 dropdown-toggle-custom" type="button">
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
                                        <defs>
                                            <clipPath id="clip0_2223_4269">
                                                <rect width="18" height="18" fill="white"
                                                    transform="translate(7 7)" />
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </button>

                                <ul class="dropdown-menu dropdown-menu-custom">
                                    <li class="dropdown-item edit"
                                        onclick="openEditModal({{ $file->id }}, '{{ addslashes($file->nama_dokumen) }}', '{{ optional($file->tanggal_dokumen)->format('Y-m-d') }}')">
                                        <i class="ki-outline ki-pencil me-2"></i>Edit
                                    </li>
                                    <li class="dropdown-item delete"
                                        onclick="deleteFile('{{ $file->id }}', '{{ $file->nama_dokumen }}', '{{ route('admin.file-kesekretariat.destroy', $file) }}')">
                                        <i class="ki-outline ki-trash me-2"></i>Hapus
                                    </li>
                                    <li class="dropdown-item"
                                        onclick="window.location='{{ route('admin.file-kesekretariat.download', $file) }}'">
                                        <i class="ki-outline ki-download me-2"></i>Download
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if ($files->total() > 0)
    
        <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap">
            <div class="mb-2 mb-md-0">
                <div class="d-flex align-items-center">
                    <span class="me-2">Show</span>
                    <select name="per_page" class="form-select form-select-sm w-auto">
                        @foreach ([10, 25, 50, 100] as $limit)
                            <option value="{{ $limit }}" {{ request('per_page', 10) == $limit ? 'selected' : '' }}>
                                {{ $limit }}
                            </option>
                        @endforeach
                    </select>
                    <span class="ms-2">per page</span>
                </div>
            </div>

            @if ($files->hasPages())
                <div class="d-flex align-items-center gap-3">
                    <div class="text-muted small">
                        {{ $files->firstItem() }}-{{ $files->lastItem() }} of {{ $files->total() }}
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        @if ($files->onFirstPage())
                            <span class="pagination-arrow disabled">←</span>
                        @else
                            <a href="{{ $files->appends(request()->query())->previousPageUrl() }}"
                                class="pagination-arrow pagination-link" aria-label="Previous">←</a>
                        @endif

                        @php
                            $current = $files->currentPage();
                            $total = $files->lastPage();
                            $start = max(1, $current - 2);
                            $end = min($total, $current + 2);
                            if ($end - $start < 4) {
                                if ($start == 1) {
                                    $end = min($total, $start + 4);
                                } else {
                                    $start = max(1, $end - 4);
                                }
                            }
                        @endphp

                        <div class="d-flex align-items-center">
                            @for ($i = $start; $i <= $end; $i++)
                                @if ($i == $current)
                                    <span class="pagination-number active">{{ $i }}</span>
                                @else
                                    <a href="{{ $files->appends(request()->query())->url($i) }}"
                                        class="pagination-number pagination-link">{{ $i }}</a>
                                @endif
                            @endfor
                        </div>

                        @if ($files->hasMorePages())
                            <a href="{{ $files->appends(request()->query())->nextPageUrl() }}"
                                class="pagination-arrow pagination-link" aria-label="Next">→</a>
                        @else
                            <span class="pagination-arrow disabled">→</span>
                        @endif
                    </div>
                </div>
            @else
                <div class="text-muted small">
                    1-{{ $files->count() }} of {{ $files->total() }}
                </div>
            @endif
        </div>
    </div>
@endif
@endif

<style>

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
    /* Document info styling */
    .document-info {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    /* Nama dokumen wrapper */
    .document-name-wrapper {
        font-weight: 600;
        color: #495057;
        cursor: default;
        user-select: text;
    }

    .document-name-wrapper i {
        margin-right: 8px;
        flex-shrink: 0;
        color: #6c757d;
    }

    .document-name-text {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        max-width: 100%;
    }

    /* Tanggal dokumen */
    .document-date {
        font-size: 12px;
        color: #6c757d !important;
        font-weight: 400;
        margin-top: 2px;
        padding-left: 0px;
        font-style: italic;
        user-select: none;
        cursor: default !important;
    }

    /* Styling untuk document link yang baru (sama seperti di surat) */
    .document-link-container {
        display: inline-block;
        max-width: 200px;
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
        word-break: break-all;
        line-height: 1.4;
    }

    .document-link:hover {
        background-color: #e3f2fd;
        color: #1976d2 !important;
        text-decoration: underline !important;
        transform: translateY(-1px);
    }

    .document-link i {
        color: #dc3545;
        flex-shrink: 0;
    }

    .document-link i.fa-file-pdf {
        color: #dc3545;
    }

    .document-link i.fa-file-alt {
        color: #28a745;
    }

    /* Sort styling */
    .sortable {
        cursor: pointer;
        position: relative;
        transition: background-color 0.2s ease;
    }

    .sortable:hover {
        background-color: #e9ecef;
    }

    .sort-icon {
        margin-left: 8px;
        color: #6c757d;
        font-size: 12px;
    }

    .sort-icon i {
        transition: color 0.2s ease;
    }

    .sortable:hover .sort-icon i {
        color: #F8285A;
    }

    /* Pagination styling */
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
        background-color: #F8285A;
        border-color: #F8285A;
        color: white;
    }

    .page-item:not(.disabled) .page-link:hover {
        background-color: #fff5f7;
        border-color: #F8285A;
        color: #F8285A;
    }

    .page-item.disabled .page-link {
        color: #adb5bd;
        background-color: #f8f9fa;
        border-color: #dee2e6;
    }

    /* Empty state styling */
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

    /* Dropdown action styling */
    .dropdown-action {
        position: relative;
        display: inline-block;
    }

    .dropdown-toggle-custom {
        background: none;
        border: none;
        cursor: pointer;
        padding: 5px;
        border-radius: 4px;
        transition: all 0.2s ease;
    }

    .dropdown-toggle-custom:hover {
        background-color: rgba(0, 0, 0, 0.05);
    }

    .dropdown-menu-custom {
        position: absolute;
        right: 0;
        background: white;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        z-index: 1000;
        min-width: 180px;
        padding: 8px 0;
        margin-top: 5px;
        list-style: none;
        display: none;
    }

    .dropdown-menu-custom.show {
        display: block;
        animation: fadeIn 0.2s ease;
    }

    .dropdown-item {
        padding: 8px 16px;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        color: #495057;
        text-decoration: none;
        font-size: 0.9rem;
    }

    .dropdown-item i {
        margin-right: 8px;
        width: 20px;
        text-align: center;
    }

    .dropdown-item:hover {
        background-color: #f8f9fa;
    }

    .dropdown-item.edit:hover {
        background-color: #fff9c4 !important;
    }

    .dropdown-item.delete:hover {
        background-color: #ffebee !important;
    }

    /* Responsive design */
    @media (max-width: 768px) {

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

        .document-name-wrapper {
            padding: 4px 6px;
            font-size: 0.875rem;
        }

        .document-date {
            font-size: 11px;
            padding-left: 20px;
        }

        .d-flex.justify-content-between {
            flex-direction: column;
            gap: 1rem;
            align-items: stretch;
        }

        .pagination {
            justify-content: center;
        }

        /* Responsive design untuk document link */
        .document-link-container {
            max-width: 150px;
        }

        .document-link {
            font-size: 0.8rem;
            padding: 2px 6px;
        }
    }

    /* Loading state */
    .table-loading {
        opacity: 0.6;
        pointer-events: none;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-5px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
