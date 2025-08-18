{{-- resources/views/admin/file-kesekretariat/_table.blade.php --}}
@if ($files->isEmpty())
    <div class="empty-state" id="emptyState">
        @if (request('search') || request('file_type'))
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
                                <i class="fas fa-arrow-{{ request('order') == 'asc' ? 'up' : 'down' }} ms-1"></i>
                            @else
                                <i class="fas fa-sort ms-1 text-muted"></i>
                            @endif
                        </a>
                    </th>
                    <th>File Dokumen</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                @foreach ($files as $index => $file)
                    <tr id="file-row-{{ $file->id }}">
                        <td class="text-center">{{ $files->firstItem() + $index }}</td>
                        <td>
                            <div class="document-info">
                                <a href="{{ asset('storage/documents/' . $file->dokumen_file) }}" target="_blank"
                                   class="document-name">
                                    <i class="fas fa-file-alt"></i>
                                    <span class="text-truncate-custom">{{ $file->nama_dokumen }}</span>
                                </a>
                                <div class="document-date">
                                    {{ $file->created_at->format('d/m/Y H:i') }}
                                </div>
                            </div>
                        </td>
                        <td>
                            <a href="{{ asset('storage/documents/' . $file->dokumen_file) }}" target="_blank"
                               class="file-link" title="Klik untuk melihat dokumen">
                                {{ $file->dokumen_file }}
                            </a>
                        </td>
                        <td class="text-center">
                            <div class="dropdown-action">
                                <button class="dropdown-toggle-action" type="button">
                                    <svg width="20" height="20" viewBox="0 0 32 32" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <rect width="32" height="32" rx="6" fill="#EFF6FF"/>
                                        <rect x="0.5" y="0.5" width="31" height="31" rx="5.5"
                                              stroke="#1B84FF" stroke-opacity="0.2"/>
                                        <g clip-path="url(#clip0_2223_4269)">
                                            <path opacity="0.3"
                                                  d="M19.4266 7.9375H12.5734C10.0131 7.9375 7.9375 10.0131 7.9375 12.5734V19.4266C7.9375 21.9869 10.0131 24.0625 12.5734 24.0625H19.4266C21.9869 24.0625 24.0625 21.9869 24.0625 19.4266V12.5734C24.0625 10.0131 21.9869 7.9375 19.4266 7.9375Z"
                                                  fill="#1B84FF"/>
                                            <path
                                                d="M12.251 14.8232C12.8475 14.8233 13.331 15.3067 13.3311 15.9033C13.3311 16.4999 12.8476 16.9833 12.251 16.9834C11.6543 16.9834 11.1709 16.5 11.1709 15.9033C11.1709 15.3067 11.6543 14.8232 12.251 14.8232ZM16.2979 14.8232C16.8945 14.8232 17.3789 15.3066 17.3789 15.9033C17.3789 16.5 16.8945 16.9834 16.2979 16.9834C15.7013 16.9832 15.2178 16.4999 15.2178 15.9033C15.2178 15.3067 15.7013 14.8234 16.2979 14.8232ZM20.3369 14.8232C20.9336 14.8232 21.418 15.3066 21.418 15.9033C21.418 16.5 20.9336 16.9834 20.3369 16.9834C19.7404 16.9832 19.2568 16.4999 19.2568 15.9033C19.2568 15.3068 19.7404 14.8234 20.3369 14.8232Z"
                                                  fill="#1B84FF"/>
                                        </g>
                                    </svg>
                                </button>
                                <div class="dropdown-menu-action">
                                    <a href="{{ route('admin.file-kesekretariat.edit', $file) }}"
                                       class="dropdown-item-action">
                                        <i class="fas fa-edit"></i>Edit
                                    </a>
                                    <a href="#" class="dropdown-item-action delete-btn"
                                       data-file-id="{{ $file->id }}" data-file-name="{{ $file->nama_dokumen }}"
                                       data-delete-url="{{ route('admin.file-kesekretariat.destroy', $file) }}">
                                        <i class="fas fa-trash"></i>Hapus
                                    </a>
                                    <a href="{{ route('admin.file-kesekretariat.download', $file) }}"
                                       class="dropdown-item-action">
                                        <i class="fas fa-download"></i>Download
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if ($files->total() > 0)
<div class="table-footer">
    <!-- Per Page Selector -->
    <div class="per-page-selector">
        <form method="GET" action="{{ url()->current() }}" class="d-flex align-items-center">
            @foreach (request()->except('per_page', 'page') as $key => $value)
                <!-- Hidden inputs for other query parameters -->
            @endforeach
            <span class="me-2">Show</span>
            <select name="per_page" class="form-select form-select-sm" onchange="this.form.submit()">
                @foreach ([10, 25, 50, 100] as $limit)
                    <option value="{{ $limit }}" {{ request('per_page', 10) == $limit ? 'selected' : '' }}>
                        {{ $limit }}
                    </option>
                @endforeach
            </select>
            <span class="ms-2">per page</span>
        </form>
    </div>

                {{-- Pagination Info and Navigation - Right Side --}}
                <div class="d-flex align-items-center gap-3">
                    <div class="text-muted small">
                        Showing {{ $files->firstItem() }} to {{ $files->lastItem() }} of {{ $files->total() }} entries
                    </div>

                    <nav aria-label="Page navigation">
                        <ul class="pagination pagination-sm mb-0">
                            {{-- Previous Page Link --}}
                            <li class="page-item {{ $files->onFirstPage() ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $files->previousPageUrl() }}" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>

                            {{-- Page Numbers --}}
                            @php
                                $current = $files->currentPage();
                                $total   = $files->lastPage();
                                $start   = max(1, $current - 2);
                                $end     = min($total, $current + 2);

                                if ($end - $start < 4) {
                                    $start = max(1, $end - 4);
                                    $end   = min($total, $start + 4);
                                }
                            @endphp

                            @if ($start > 1)
                                <li class="page-item"><a class="page-link" href="{{ $files->url(1) }}">1</a></li>
                                @if ($start > 2)
                                    <li class="page-item disabled"><span class="page-link">...</span></li>
                                @endif
                            @endif

                            @for ($i = $start; $i <= $end; $i++)
                                <li class="page-item {{ $i == $current ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $files->url($i) }}">{{ $i }}</a>
                                </li>
                            @endfor

                            @if ($end < $total)
                                @if ($end < $total - 1)
                                    <li class="page-item disabled"><span class="page-link">...</span></li>
                                @endif
                                <li class="page-item">
                                    <a class="page-link" href="{{ $files->url($total) }}">{{ $total }}</a>
                                </li>
                            @endif

                            {{-- Next Page Link --}}
                            <li class="page-item {{ !$files->hasMorePages() ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $files->nextPageUrl() }}" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    @endif
@endif

<style>
/* Updated Pagination Styles */
.table-footer {
    padding: 1rem 0;
    border-top: 1px solid #e9ecef;
    margin-top: 1rem;
}
.table-footer .d-flex { gap: 1rem; }

.per-page-selector {
    display: flex;
    align-items: center;
    white-space: nowrap;
}
.per-page-toggle {
    min-width: 60px;
    text-align: center;
    display: inline-flex;
    align-items: center;
    justify-content: space-between;
}
.pagination { margin: 0; gap: 2px; }
.page-link {
    min-width: 32px;
    text-align: center;
    border-radius: 4px;
    margin: 0 2px;
    padding: 6px 10px;
    font-size: 0.875rem;
}
.page-item.active .page-link {
    background-color: #1B84FF;
    border-color: #1B84FF;
}
.page-item:not(.active) .page-link:hover {
    background-color: #f0f8ff;
    color: #1B84FF;
}

/* Right-aligned pagination info and navigation */
.table-footer .d-flex:last-child .gap-3 {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-left: auto;
}

/* Responsive Design */
@media (max-width: 767.98px) {
    .table-footer .d-flex {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }
    .table-footer .d-flex .gap-3 {
        width: 100%;
        justify-content: space-between;
        margin-left: 0;
        flex-direction: column;
        gap: 0.5rem;
    }
    .table-footer .gap-3 { align-items: center; }
}

.pagination-info {
    color: #6c757d;
    font-size: 0.875rem;
    white-space: nowrap;
}

/* Document info styling */
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
.document-name i { margin-right: 8px; flex-shrink: 0; }
.document-date {
    font-size: 12px;
    color: #6c757d;
    font-weight: 400;
    margin-top: 2px;
    padding-left: 36px;
}
</style>