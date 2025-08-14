@if ($suratData->isEmpty())
    <div class="text-center text-muted py-10">
        <div class="d-flex flex-column align-items-center gap-3">
            <svg width="64" height="64" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="32" cy="32" r="32" fill="#F8F9FA" />
                <path
                    d="M32 20C25.3726 20 20 25.3726 20 32C20 38.6274 25.3726 44 32 44C38.6274 44 44 38.6274 44 32C44 25.3726 38.6274 20 32 20ZM32 22C37.5467 22 42 26.4533 42 32C42 37.5467 37.5467 42 32 42C26.4533 42 22 37.5467 22 32C22 26.4533 26.4533 22 32 22Z"
                    fill="#6C7B7F" />
                <path d="M30 28V36H34V28H30ZM30 24V27H34V24H30Z" fill="#6C7B7F" />
            </svg>
            <div class="text-center">
                <div class="fw-bold text-gray-800 mb-1">
                    @if (request('search') || request('start_date') || request('end_date'))
                        Tidak ada surat yang sesuai dengan pencarian/filter
                    @else
                        Belum ada surat {{ $tableId }}
                    @endif
                </div>
                <div class="text-muted">
                    @if (request('search') || request('start_date') || request('end_date'))
                        Coba ubah kata kunci pencarian atau filter yang Anda gunakan
                    @else
                        Klik tombol "Tambah Surat" untuk menambah surat baru
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
                    <th class="bg-light px-20">
                        <a href="#" class="text-decoration-none text-dark sort-link" data-sort="nama_kegiatan">
                            Nama Kegiatan
                            @if (request('sort_by') == 'nama_kegiatan')
                                @if (request('order') == 'asc')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort-down"></i>
                                @endif
                            @else
                                <i class="fas fa-sort text-muted"></i>
                            @endif
                        </a>
                    </th>
                    <th class="bg-light text-center">Dokumen</th>
                    <th class="bg-light text-center">
                        <a href="#" class="text-decoration-none text-dark sort-link" data-sort="created_at">
                            Tanggal Dibuat
                            @if (request('sort_by') == 'created_at')
                                @if (request('order') == 'asc')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort-down"></i>
                                @endif
                            @else
                                <i class="fas fa-sort text-muted"></i>
                            @endif
                        </a>
                    </th>
                    <th class="bg-light px-8 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="border-bottom">
                @forelse ($suratData as $index => $surat)
                    @php
                        $rowNumber = method_exists($suratData, 'currentPage')
                            ? ($suratData->currentPage() - 1) * $suratData->perPage() + $index + 1
                            : $index + 1;
                    @endphp
                    <tr data-jenis-surat="{{ $surat->jenis_surat ?? '' }}" style="position: relative;">
                        <td class="text-center fw-bold px-2">{{ $rowNumber }}</td>
                        <td class="fw-bold px-6">
                            <div class="d-flex flex-column">
                                @if (request('search'))
                                    {!! preg_replace(
                                        '/(' . preg_quote(request('search'), '/') . ')/i',
                                        '<span class="search-highlight">$1</span>',
                                        $surat->nama_kegiatan,
                                    ) !!}
                                @else
                                    {{ $surat->nama_kegiatan }}
                                @endif
                            </div>
                            <br>
                            <small class="text-muted">{{ $surat->no_surat }}</small>
                        </td>
                        <td class="px-2 text-center">
                            @if ($surat->dokumen_surat)
                                @php
                                    $fileExtension = pathinfo($surat->dokumen_surat, PATHINFO_EXTENSION);
                                    $fileName = basename($surat->dokumen_surat);
                                    $fileUrl = asset('storage/' . $surat->dokumen_surat);
                                @endphp
                                <button type="button" class="btn btn-sm btn-light-primary preview"
                                    onclick="previewFile('{{ $fileUrl }}', '{{ $fileName }}', '{{ $fileExtension }}')">
                                    <i class="fas fa-eye me-1"></i>Lihat Dokumen
                                </button>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td class="px-2 text-center">{{ \Carbon\Carbon::parse($surat->created_at)->format('d M Y') }}
                        </td>
                        <td class="px-2 text-center">
                            <div class="dropdown dropdown-action" data-row-id="{{ $surat->id }}">
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
                                    <li class="dropdown-item edit" data-bs-toggle="modal"
                                        data-bs-target="#edit-{{ $surat->id }}">
                                        <i class="ki-outline ki-pencil me-2"></i>Edit Surat
                                    </li>
                                    <li class="dropdown-item delete"
                                        onclick="deleteItem('delete-form-{{ $surat->id }}', '{{ $surat->nama_kegiatan }}')">
                                        <i class="ki-outline ki-trash me-2"></i>Hapus
                                    </li>
                                </ul>
                                <form id="delete-form-{{ $surat->id }}"
                                    action="{{ route('admin.surat.destroy', $surat->id) }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>

                    <div class="modal fade" id="edit-{{ $surat->id }}" tabindex="-1"
                        aria-labelledby="edit-{{ $surat->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content rounded-4 gap-5 px-10 py-8">
                                <div class="d-flex justify-content-between align-items-center gap-2">
                                    <div class="fs-2 fw-bold text-truncate leading-5"
                                        id="editModalTitle-{{ $surat->id }}">
                                        Edit {{ $surat->jenis_surat == 'masuk' ? 'Surat Masuk' : 'Surat Keluar' }}:
                                        {{ Str::limit($surat->nama_kegiatan, 20) }}
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>

                                <div id="form-{{ $surat->id }}"
                                    data-action="{{ route('admin.surat.update', $surat->id) }}" class="d-grid gap-4">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="_method" value="PUT">

                                    <div>
                                        <div class="fw-semibold required mb-3 text-gray-800">Nama Kegiatan</div>
                                        <input type="text" name="nama_kegiatan"
                                            value="{{ $surat->nama_kegiatan }}" placeholder="Masukkan Nama Kegiatan"
                                            class="form-control bg-light border border-gray-400" required />
                                    </div>

                                    <div>
                                        <div class="fw-semibold required mb-3 text-gray-800">Nomor Surat</div>
                                        <input type="text" name="no_surat" value="{{ $surat->no_surat }}"
                                            placeholder="Masukkan Nomor Surat"
                                            class="form-control bg-light border border-gray-400" required />
                                    </div>

                                    <input type="hidden" name="jenis_surat" value="{{ $surat->jenis_surat }}">

                                    <div>
                                        <div class="fw-semibold mb-3 text-gray-800">
                                            Unggah Dokumen Baru
                                            <span class="text-muted">(Opsional)</span>
                                        </div>
                                        <div class="fv-row">
                                            <div class="dropzone" id="dropzone-form-{{ $surat->id }}">
                                                <div class="dz-message needsclick">
                                                    <i class="ki-duotone ki-file-up fs-3x text-primary">
                                                        <span class="path1"></span><span class="path2"></span>
                                                    </i>
                                                    <div class="ms-4">
                                                        <h3 class="fs-5 fw-bold mb-1 text-gray-900">Seret atau pilih
                                                            dokumen baru.</h3>
                                                        <span class="fs-7 fw-semibold text-gray-500">Format: PDF, DOC,
                                                            DOCX. Max. 10 MB. Kosongkan jika tidak ingin mengubah
                                                            file.</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        @if ($surat->dokumen_surat)
                                            <div class="mt-2 p-3 bg-light rounded">
                                                <small class="text-muted">File saat ini: </small>
                                                <a href="{{ asset('storage/' . $surat->dokumen_surat) }}"
                                                    target="_blank" class="text-primary text-decoration-none fw-bold">
                                                    {{ basename($surat->dokumen_surat) }}
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="d-grid py-4">
                                    <button type="button" onclick="submitForm('form-{{ $surat->id }}')"
                                        id="editSubmitBtn-{{ $surat->id }}"
                                        class="bg-danger fw-bold d-flex align-items-center justify-content-center gap-2 rounded border-0 p-4 text-white">
                                        Update {{ $surat->jenis_surat == 'masuk' ? 'Surat Masuk' : 'Surat Keluar' }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <tr>
                        <td class="fw-bold p-6 text-center" colspan="5">
                            <div class="d-flex flex-column align-items-center gap-3">
                                <svg width="64" height="64" viewBox="0 0 64 64" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="32" cy="32" r="32" fill="#F8F9FA" />
                                    <path
                                        d="M32 20C25.3726 20 20 25.3726 20 32C20 38.6274 25.3726 44 32 44C38.6274 44 44 38.6274 44 32C44 25.3726 38.6274 20 32 20ZM32 22C37.5467 22 42 26.4533 42 32C42 37.5467 37.5467 42 32 42C26.4533 42 22 37.5467 22 32C22 26.4533 26.4533 22 32 22Z"
                                        fill="#6C7B7F" />
                                    <path d="M30 28V36H34V28H30ZM30 24V27H34V24H30Z" fill="#6C7B7F" />
                                </svg>
                                <div class="text-center">
                                    <div class="fw-bold text-gray-800 mb-1">
                                        @if (request('search') || request('start_date') || request('end_date'))
                                            Tidak ada surat yang sesuai dengan pencarian/filter
                                        @else
                                            Belum ada surat {{ $tableId }}
                                        @endif
                                    </div>
                                    <div class="text-muted">
                                        @if (request('search') || request('start_date') || request('end_date'))
                                            Coba ubah kata kunci pencarian atau filter yang Anda gunakan
                                        @else
                                            Klik tombol "Tambah Surat" untuk menambah surat baru
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

    <div class="table-footer">
        <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap">
            <div class="mb-2 mb-md-0">
                <div class="d-flex align-items-center">
                    <span class="me-2">Show</span>
                    <select name="per_page" class="form-select form-select-sm w-auto">
                        @foreach ([10, 25, 50, 100] as $limit)
                            <option value="{{ $limit }}"
                                {{ request('per_page', 10) == $limit ? 'selected' : '' }}>
                                {{ $limit }}
                            </option>
                        @endforeach
                    </select>
                    <span class="ms-2">per page</span>
                </div>
            </div>

            @if (isset($suratData) && method_exists($suratData, 'hasPages') && $suratData->hasPages())
                <div class="d-flex align-items-center gap-3">
                    <div class="text-muted small">
                        {{ $suratData->firstItem() }}-{{ $suratData->lastItem() }} of {{ $suratData->total() }}
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        @if ($suratData->onFirstPage())
                            <span class="pagination-arrow disabled">←</span>
                        @else
                            <a href="{{ $suratData->appends(request()->query())->previousPageUrl() }}"
                                class="pagination-arrow pagination-link" aria-label="Previous">←</a>
                        @endif

                        @php
                            $current = $suratData->currentPage();
                            $total = $suratData->lastPage();
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
                                    <a href="{{ $suratData->appends(request()->query())->url($i) }}"
                                        class="pagination-number pagination-link">{{ $i }}</a>
                                @endif
                            @endfor
                        </div>

                        @if ($suratData->hasMorePages())
                            <a href="{{ $suratData->appends(request()->query())->nextPageUrl() }}"
                                class="pagination-arrow pagination-link" aria-label="Next">→</a>
                        @else
                            <span class="pagination-arrow disabled">→</span>
                        @endif
                    </div>
                </div>
            @elseif(isset($suratData) && method_exists($suratData, 'hasPages'))
                <div class="text-muted small">
                    1-{{ $suratData->count() }} of {{ $suratData->total() }}
                </div>
            @endif
        </div>
    </div>
@endif

<style>
    .search-highlight {
        background-color: #fff3cd;
        padding: 1px 3px;
        border-radius: 3px;
        font-weight: bold;
    }

    .preview:hover {
        background-color: #F4EEFF !important;
    }

    .sort-link {
        cursor: pointer;
        transition: color 0.2s ease;
    }

    .sort-link:hover {
        color: #F8285A !important;
        text-decoration: none !important;
    }

    .sort-link i {
        transition: color 0.2s ease;
        font-size: 0.8rem;
        margin-left: 4px;
    }

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
        display: none;
        list-style: none;
    }

    .dropdown-menu-custom.show {
        display: block;
        animation: fadeIn 0.2s ease;
    }

    .dropup .dropdown-menu-custom {
        bottom: 100%;
        top: auto;
        margin-top: 0;
        margin-bottom: 5px;
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
        background-color: rgb(249, 245, 172) !important;
    }

    .dropdown-item.delete:hover {
        background-color: #ffcad7 !important;
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

    .badge-success {
        background-color: #198754 !important;
    }

    .badge-primary {
        background-color: #0d6efd !important;
    }
</style>
