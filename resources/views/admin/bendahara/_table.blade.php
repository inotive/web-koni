@if ($laporanBendahara->isEmpty())
    <div class="text-center text-muted py-10">
        <div class="d-flex flex-column align-items-center gap-3">
            <svg width="64" height="64" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="32" cy="32" r="32" fill="#F8F9FA" />
                <path d="M32 20C25.3726 20 20 25.3726 20 32C20 38.6274 25.3726 44 32 44C38.6274 44 44 38.6274 44 32C44 25.3726 38.6274 20 32 20ZM32 22C37.5467 22 42 26.4533 42 32C42 37.5467 37.5467 42 32 42C26.4533 42 22 37.5467 22 32C22 26.4533 26.4533 22 32 22Z" fill="#6C7B7F" />
                <path d="M30 28V36H34V28H30ZM30 24V27H34V24H30Z" fill="#6C7B7F" />
            </svg>
            <div class="text-center">
                <div class="fw-bold text-gray-800 mb-1">
                    @if (request('search') || request('filter_type') || request('date_from') || request('date_to'))
                        Tidak ada laporan yang sesuai dengan pencarian/filter
                    @else
                        Belum ada laporan bendahara
                    @endif
                </div>
                <div class="text-muted">
                    @if (request('search') || request('filter_type') || request('date_from') || request('date_to'))
                        Coba ubah kata kunci pencarian atau filter yang Anda gunakan
                    @else
                        Klik tombol "Tambah Laporan" untuk menambah laporan baru
                    @endif
                </div>
            </div>
        </div>
    </div>
@else
    <div style="overflow-x:auto;">
        <table class="table-row-bordered gy-4 table align-middle">
            <thead>
                <tr class="fw-bold text-uppercase text-muted">
                    <th class="bg-light px-6 text-center" style="width: 60px;">No</th>
                    <th class="bg-light px-20 sortable cursor-pointer" data-sort="judul" data-order="{{ ($currentSort['sort_by'] ?? '') === 'judul' && ($currentSort['order'] ?? '') === 'asc' ? 'desc' : 'asc' }}">
                        <div class="d-flex align-items-center justify-content-between">
                            <span>Judul Laporan</span>
                            <div class="sort-icons">
                                @if(($currentSort['sort_by'] ?? '') === 'judul')
                                    @if(($currentSort['order'] ?? '') === 'asc')
                                        <i class="fas fa-sort-up text-primary"></i>
                                    @else
                                        <i class="fas fa-sort-down text-primary"></i>
                                    @endif
                                @else
                                    <i class="fas fa-sort text-muted opacity-50"></i>
                                @endif
                            </div>
                        </div>
                    </th>
                    <th class="bg-light text-center sortable cursor-pointer" data-sort="file_size" data-order="{{ ($currentSort['sort_by'] ?? '') === 'file_size' && ($currentSort['order'] ?? '') === 'desc' ? 'asc' : 'desc' }}">
                        <div class="d-flex align-items-center justify-content-center">
                            <span>Ukuran File</span>
                            <div class="sort-icons ms-2">
                                @if(($currentSort['sort_by'] ?? '') === 'file_size')
                                    @if(($currentSort['order'] ?? '') === 'desc')
                                        <i class="fas fa-sort-down text-primary"></i>
                                    @else
                                        <i class="fas fa-sort-up text-primary"></i>
                                    @endif
                                @else
                                    <i class="fas fa-sort text-muted opacity-50"></i>
                                @endif
                            </div>
                        </div>
                    </th>
                    <th class="bg-light text-center">Tipe File</th>
                    <th class="bg-light px-8 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="border-bottom">
                @forelse ($laporanBendahara as $index => $item)
                    @php
                        $extension = $item->dokumen ? strtolower(pathinfo($item->dokumen, PATHINFO_EXTENSION)) : '';
                        $rowNumber = ($laporanBendahara->currentPage() - 1) * $laporanBendahara->perPage() + $index + 1;
                    @endphp
                    <tr data-extension="{{ $extension }}" data-dokumen="{{ $item->dokumen }}">
                        <td class="text-center fw-bold px-2">{{ $rowNumber }}</td>
                        <td class="fw-bold px-6">
                            <div class="d-flex flex-column">
                                @if($item->dokumen)
                                    <a href="#" onclick="previewFile('{{ Storage::url($item->dokumen) }}', '{{ $item->judul }}', '{{ $extension }}')"
                                       class="text-decoration-none cursor-pointer text-primary text-truncate d-block" style="font-size: 15px; max-width: 200px;" title="{{ $item->judul }}">
                                        @if(request('search'))
                                            {!! preg_replace('/(' . preg_quote(request('search'), '/') . ')/i', '<span class="search-highlight">$1</span>', $item->judul) !!}
                                        @else
                                            {{ $item->judul }}
                                        @endif
                                    </a>
                                @else
                                    <span class="text-truncate d-block" style="max-width: 250px;" title="{{ $item->judul }}">
                                        @if(request('search'))
                                            {!! preg_replace('/(' . preg_quote(request('search'), '/') . ')/i', '<span class="search-highlight">$1</span>', $item->judul) !!}
                                        @else
                                            {{ $item->judul }}
                                        @endif
                                    </span>
                                @endif
                            </div>
                            <span class="text-muted">{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</span>
                        </td>
                        <td class="px-2 text-center">
                            @if($item->dokumen && Storage::disk('public')->exists($item->dokumen))
                                {{ number_format(Storage::disk('public')->size($item->dokumen) / 1048576, 2) }} MB
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-2 text-center">
                            @if($item->dokumen)
                                @php
                                    $fileExtension = strtoupper(pathinfo($item->dokumen, PATHINFO_EXTENSION));
                                    $badgeClass = match($fileExtension) {
                                        'PDF' => 'badge-danger',
                                        'XLS', 'XLSX' => 'badge-success',
                                        default => 'badge-secondary'
                                    };
                                @endphp
                                <span class="badge {{ $badgeClass }}">{{ $fileExtension }}</span>
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-2 text-center">
                            <div class="dropdown dropdown-action" data-row-id="{{ $item->id }}">
                                <button class="btn btn-sm p-0 dropdown-toggle-custom" type="button">
                                    <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect width="32" height="32" rx="6" fill="#EFF6FF" />
                                        <rect x="0.5" y="0.5" width="31" height="31" rx="5.5" stroke="#1B84FF" stroke-opacity="0.2" />
                                        <g clip-path="url(#clip0_2223_4269)">
                                            <path opacity="0.3" d="M19.4266 7.9375H12.5734C10.0131 7.9375 7.9375 10.0131 7.9375 12.5734V19.4266C7.9375 21.9869 10.0131 24.0625 12.5734 24.0625H19.4266C21.9869 24.0625 24.0625 21.9869 24.0625 19.4266V12.5734C24.0625 10.0131 21.9869 7.9375 19.4266 7.9375Z" fill="#1B84FF" />
                                            <path d="M12.251 14.8232C12.8475 14.8233 13.331 15.3067 13.3311 15.9033C13.3311 16.4999 12.8476 16.9833 12.251 16.9834C11.6543 16.9834 11.1709 16.5 11.1709 15.9033C11.1709 15.3067 11.6543 14.8232 12.251 14.8232ZM16.2979 14.8232C16.8945 14.8232 17.3789 15.3066 17.3789 15.9033C17.3789 16.5 16.8945 16.9834 16.2979 16.9834C15.7013 16.9832 15.2178 16.4999 15.2178 15.9033C15.2178 15.3067 15.7013 14.8234 16.2979 14.8232ZM20.3369 14.8232C20.9336 14.8232 21.418 15.3066 21.418 15.9033C21.418 16.5 20.9336 16.9834 20.3369 16.9834C19.7404 16.9832 19.2568 16.4999 19.2568 15.9033C19.2568 15.3068 19.7404 14.8234 20.3369 14.8232Z" fill="#1B84FF" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_2223_4269">
                                                <rect width="18" height="18" fill="white" transform="translate(7 7)" />
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-custom">
                                    @if($item->dokumen)
                                        <li class="dropdown-item preview" onclick="previewFile('{{ Storage::url($item->dokumen) }}', '{{ $item->judul }}', '{{ strtolower(pathinfo($item->dokumen, PATHINFO_EXTENSION)) }}')">
                                            <i class="ki-outline ki-eye me-2"></i>Preview Dokumen
                                        </li>
                                    @endif
                                    <li class="dropdown-item edit" data-bs-toggle="modal" data-bs-target="#edit-{{ $item->id }}">
                                        <i class="ki-outline ki-pencil me-2"></i>Edit Laporan
                                    </li>
                                    <li class="dropdown-item delete" onclick="deleteItemEnhanced('delete-form-{{ $item->id }}', '{{ $item->judul }}')">
                                        <i class="ki-outline ki-trash me-2"></i>Hapus
                                    </li>
                                </ul>
                                <form id="delete-form-{{ $item->id }}" action="{{ route('admin.bendahara.destroy', $item->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="edit-{{ $item->id }}" tabindex="-1" aria-labelledby="edit-{{ $item->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content rounded-4 gap-5 px-10 py-8">
                                <div class="d-flex justify-content-between align-items-center gap-2">
                                    <div class="fs-2 fw-bold text-truncate leading-5" title="{{ $item->judul }}">
                                        Edit Laporan: {{ $item->judul }}
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                <div id="form-{{ $item->id }}" data-action="{{ route('admin.bendahara.update', $item->id) }}" class="d-grid gap-4">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="_method" value="PUT">

                                    <div>
                                        <div class="fw-semibold required mb-3 text-gray-800">Judul Laporan</div>
                                        <input type="text" name="judul" value="{{ $item->judul }}" placeholder="Masukkan Judul Laporan" class="form-control bg-light border border-gray-400" required />
                                        <div class="invalid-feedback"></div>
                                    </div>

                                    <div>
                                        <div class="fw-semibold required mb-3 text-gray-800">Tanggal Laporan</div>
                                        <input type="date" name="tanggal" value="{{ $item->tanggal }}" class="form-control bg-light border border-gray-400" required />
                                        <div class="invalid-feedback"></div>
                                    </div>

                                    <div>
                                        <div class="fw-semibold mb-3 text-gray-800">
                                            Unggah Dokumen Baru
                                            <span class="text-muted">(Opsional)</span>
                                        </div>
                                        <div class="fv-row">
                                            <div class="dropzone" id="dropzone-form-{{ $item->id }}">
                                                <div class="dz-message needsclick">
                                                    <i class="ki-duotone ki-file-up fs-3x text-primary">
                                                        <span class="path1"></span><span class="path2"></span>
                                                    </i>
                                                    <div class="ms-4">
                                                        <h3 class="fs-5 fw-bold mb-1 text-gray-900">Seret atau pilih dokumen baru.</h3>
                                                        <span class="fs-7 fw-semibold text-gray-500">Format: PDF, XLS, XLSX. Max. 10 MB. Kosongkan jika tidak ingin mengubah file.</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="invalid-feedback"></div>
                                        </div>

                                        @if($item->dokumen)
                                            <div class="mt-2 p-3 bg-light rounded">
                                                <small class="text-muted">File saat ini: </small>
                                                <a href="#"
                                                    onclick="previewFile('{{ Storage::url($item->dokumen) }}', '{{ $item->judul }}', '{{ strtolower(pathinfo($item->dokumen, PATHINFO_EXTENSION)) }}')"
                                                    class="text-primary text-decoration-none fw-bold d-block filename-truncate"
                                                    title="{{ basename($item->dokumen) }}"
                                                    style="max-width: 100%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                    {{ basename($item->dokumen) }}
                                                </a>
                                                <div class="mt-1">
                                                    <small class="text-muted">
                                                        Klik untuk preview •
                                                        {{ number_format(Storage::disk('public')->size($item->dokumen) / 1048576, 2) }} MB
                                                    </small>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="d-grid py-4">
                                    <button type="button" onclick="submitForm('form-{{ $item->id }}')" id="submitBtn{{ $item->id }}" class="bg-danger fw-bold d-flex align-items-center justify-content-center gap-2 rounded border-0 p-4 text-white">
                                        <span class="btn-text">Update Laporan</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <tr>
                        <td class="fw-bold p-6 text-center" colspan="6">
                            <div class="d-flex flex-column align-items-center gap-3">
                                <svg width="64" height="64" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="32" cy="32" r="32" fill="#F8F9FA"/>
                                    <path d="M32 20C25.3726 20 20 25.3726 20 32C20 38.6274 25.3726 44 32 44C38.6274 44 44 38.6274 44 32C44 25.3726 38.6274 20 32 20ZM32 22C37.5467 22 42 26.4533 42 32C42 37.5467 37.5467 42 32 42C26.4533 42 22 37.5467 22 32C22 26.4533 26.4533 22 32 22Z" fill="#6C7B7F"/>
                                    <path d="M30 28V36H34V28H30ZM30 24V27H34V24H30Z" fill="#6C7B7F"/>
                                </svg>
                                <div class="text-center">
                                    <div class="fw-bold text-gray-800 mb-1">
                                        @if(request('search') || request('filter_type') || request('date_from') || request('date_to'))
                                            Tidak ada laporan yang sesuai dengan pencarian/filter
                                        @else
                                            Belum ada laporan bendahara
                                        @endif
                                    </div>
                                    <div class="text-muted">
                                        @if(request('search') || request('filter_type') || request('date_from') || request('date_to'))
                                            Coba ubah kata kunci pencarian atau filter yang Anda gunakan
                                        @else
                                            Klik tombol "Tambah Laporan" untuk menambah laporan baru
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination and Per Page Controls -->
    <div class="table-footer">
        <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap">
            <div class="mb-2 mb-md-0">
                <div class="d-flex align-items-center">
                    <span class="me-2">Show</span>
                    <select name="per_page" class="form-select form-select-sm w-auto per-page-select">
                        @foreach ([10, 25, 50, 100] as $limit)
                            <option value="{{ $limit }}" {{ request('per_page', 10) == $limit ? 'selected' : '' }}>
                                {{ $limit }}
                            </option>
                        @endforeach
                    </select>
                    <span class="ms-2">per page</span>
                </div>
            </div>

            @if (isset($laporanBendahara) && method_exists($laporanBendahara, 'hasPages') && $laporanBendahara->hasPages())
                <div class="d-flex align-items-center gap-3">
                    <div class="text-muted small">
                        {{ $laporanBendahara->firstItem() }}-{{ $laporanBendahara->lastItem() }} of {{ $laporanBendahara->total() }}
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        @if ($laporanBendahara->onFirstPage())
                            <span class="pagination-arrow disabled">←</span>
                        @else
                            <a href="{{ $laporanBendahara->appends(request()->query())->previousPageUrl() }}" class="pagination-arrow pagination-link" aria-label="Previous">←</a>
                        @endif

                        @php
                            $current = $laporanBendahara->currentPage();
                            $total = $laporanBendahara->lastPage();
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
                                    <a href="{{ $laporanBendahara->appends(request()->query())->url($i) }}" class="pagination-number pagination-link">{{ $i }}</a>
                                @endif
                            @endfor
                        </div>

                        @if ($laporanBendahara->hasMorePages())
                            <a href="{{ $laporanBendahara->appends(request()->query())->nextPageUrl() }}" class="pagination-arrow pagination-link" aria-label="Next">→</a>
                        @else
                            <span class="pagination-arrow disabled">→</span>
                        @endif
                    </div>
                </div>
            @elseif(isset($laporanBendahara) && method_exists($laporanBendahara, 'hasPages'))
                <div class="text-muted small">
                    1-{{ $laporanBendahara->count() }} of {{ $laporanBendahara->total() }}
                </div>
            @endif
        </div>
    </div>
@endif

<style>
    .text-truncate {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .search-highlight {
        background-color: #fff3cd;
        padding: 1px 3px;
        border-radius: 3px;
        font-weight: bold;
    }

    .preview:hover {
        background-color: #F4EEFF !important;
    }

    .sortable {
        cursor: pointer;
        user-select: none;
        transition: all 0.2s ease;
    }

    .sortable:hover {
        background-color: rgba(248, 40, 90, 0.05) !important;
    }

    .sort-icons {
        transition: all 0.2s ease;
    }

    .sortable:hover .sort-icons i {
        opacity: 1 !important;
        color: #F8285A !important;
    }

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
        transform: scale(1.05);
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
        display: none;
        list-style: none;
        opacity: 0;
        transform: translateY(-10px);
        transition: all 0.2s ease;
        pointer-events: none;
    }

    .dropdown-menu-custom.show {
        display: block;
        opacity: 1;
        transform: translateY(0);
        pointer-events: auto;
        animation: dropdownFadeIn 0.2s ease forwards;
    }

    @keyframes dropdownFadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .dropup .dropdown-menu-custom {
        bottom: 100%;
        top: auto;
        margin-top: 0;
        margin-bottom: 5px;
        transform: translateY(10px);
    }

    .dropup .dropdown-menu-custom.show {
        transform: translateY(0);
        animation: dropupFadeIn 0.2s ease forwards;
    }

    @keyframes dropupFadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
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
        position: relative;
        overflow: hidden;
    }

    .dropdown-item::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 0;
        background: linear-gradient(90deg, transparent, rgba(248, 40, 90, 0.1));
        transition: width 0.3s ease;
        z-index: -1;
    }

    .dropdown-item:hover::before {
        width: 100%;
    }

    .dropdown-item i {
        margin-right: 8px;
        width: 20px;
        text-align: center;
        transition: transform 0.2s ease;
    }

    .dropdown-item:hover i {
        transform: scale(1.1);
    }

    .dropdown-item:hover {
        background-color: #f8f9fa;
        transform: translateX(2px);
    }

    .dropdown-item.preview:hover {
        background-color: #F4EEFF !important;
        color: #6f42c1;
    }

    .dropdown-item.edit:hover {
        background-color: rgb(249, 245, 172) !important;
        color: #856404;
    }

    .dropdown-item.delete:hover {
        background-color: #ffcad7 !important;
        color: #721c24;
    }

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

    .badge-success { background-color: #198754 !important; }
    .badge-danger { background-color: #dc3545 !important; }
    .badge-secondary { background-color: #6c757d !important; }

    .per-page-select {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6,9 12,15 18,9'%3e%3c/polyline%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 8px center;
        background-size: 16px;
        padding-right: 32px !important;
    }

    @media (max-width: 768px) {
        .dropdown-menu-custom {
            position: fixed;
            right: 10px;
            left: auto;
            min-width: 200px;
            max-width: calc(100vw - 20px);
        }

        .dropdown-item {
            padding: 12px 16px;
            font-size: 1rem;
        }

        .dropdown-item:hover::before {
            width: 0;
        }

        .dropdown-item:hover {
            transform: none;
        }

        .file-name-truncate {
            display: inline-block;
            max-width: 100%;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            vertical-align: middle;
        }

        .file-name-wrap {
            word-break: break-all;
            white-space: normal;
        }

        .mt-2.p-3.bg-light.rounded {
            word-break: break-word;
            overflow-wrap: break-word;
        }

        .mt-2.p-3.bg-light.rounded .file-name-truncate {
            display: block;
            max-width: 100%;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            line-height: 1.4;
        }

        /* Alternative approach - allow wrapping but limit height */
        .file-name-wrap {
            word-break: break-all;
            white-space: normal;
            max-height: 3em; /* Roughly 2-3 lines */
            overflow: hidden;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        /* For mobile devices */
        @media (max-width: 768px) {
            .file-name-truncate {
                display: inline-block;
                max-width: 100%;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
                vertical-align: middle;
            }

            .file-name-wrap {
                word-break: break-all;
                white-space: normal;
            }
        }
    }
</style>
