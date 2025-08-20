@if ($PTMSIData->isEmpty())
    {{-- Empty State --}}
    <div class="text-center text-muted py-10">
        <i class="ki-duotone ki-information-5 fs-3x mb-3"></i>
        <h4>Tidak ada data mobilisasi sumber daya.</h4>
    </div>
@else
    {{-- Data Table --}}
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle" id="kt_datatable_dom_positioning_sumberdaya">
            {{-- Table Header --}}
            <thead class="bg-light">
                <tr>
                    <th style="text-align: left">No</th>
                    <th>
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'nama_program', 'direction' => (request()->get('sort') == 'nama_program' && request()->get('direction') == 'asc') ? 'desc' : 'asc']) }}"
                            class="text-dark text-decoration-none sortable-header">
                            Nama Program & Kegiatan
                            @if(request()->get('sort') == 'nama_program')
                                <i class="fas fa-sort-{{ request()->get('direction') == 'asc' ? 'up' : 'down' }}"></i>
                            @else
                                <i class="fas fa-sort"></i>
                            @endif
                        </a>
                    </th>
                    <th>
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'volume', 'direction' => (request()->get('sort') == 'volume' && request()->get('direction') == 'asc') ? 'desc' : 'asc']) }}"
                            class="text-dark text-decoration-none sortable-header">
                            Volume
                            @if(request()->get('sort') == 'volume')
                                <i class="fas fa-sort-{{ request()->get('direction') == 'asc' ? 'up' : 'down' }}"></i>
                            @else
                                <i class="fas fa-sort"></i>
                            @endif
                        </a>
                    </th>
                    <th>
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'jumlah_harga_satuan', 'direction' => (request()->get('sort') == 'jumlah_harga_satuan' && request()->get('direction') == 'asc') ? 'desc' : 'asc']) }}"
                            class="text-dark text-decoration-none sortable-header">
                            Jumlah Harga Satuan
                            @if(request()->get('sort') == 'jumlah_harga_satuan')
                                <i class="fas fa-sort-{{ request()->get('direction') == 'asc' ? 'up' : 'down' }}"></i>
                            @else
                                <i class="fas fa-sort"></i>
                            @endif
                        </a>
                    </th>
                    <th>
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'jumlah_harga', 'direction' => (request()->get('sort') == 'jumlah_harga' && request()->get('direction') == 'asc') ? 'desc' : 'asc']) }}"
                            class="text-dark text-decoration-none sortable-header">
                            Jumlah Harga
                            @if(request()->get('sort') == 'jumlah_harga')
                                <i class="fas fa-sort-{{ request()->get('direction') == 'asc' ? 'up' : 'down' }}"></i>
                            @else
                                <i class="fas fa-sort"></i>
                            @endif
                        </a>
                    </th>
                    <th>Foto Jurnal</th>
                    <th>Dokumen LPJ</th>
                    <th style="text-align: center">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($PTMSIData as $index => $data)
                    <tr>
                        <td class="text-center">
                            {{ ($PTMSIData->currentPage() - 1) * $PTMSIData->perPage() + $index + 1 }}
                        </td>
                        <td>
                            <div class="d-flex flex-column">
                                <strong class="text-truncate-custom">{{ $data->nama_program }}</strong>
                                @if ($data->nama_kegiatan)
                                    <small class="text-muted">{{ $data->nama_kegiatan }}</small>
                                @endif
                            </div>
                        </td>
                        <td>{{ $data->volume }}</td>
                        <td>Rp {{ number_format($data->jumlah_harga_satuan, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($data->jumlah_harga, 0, ',', '.') }}</td>
                        <td>
                            @if ($data->foto_jurnal && count($data->foto_jurnal) > 0)
                                <button type="button"
                                        class="btn btn-sm btn-light-info preview-btn"
                                        data-bs-toggle="modal"
                                        data-bs-target="#previewModal"
                                        data-type="image"
                                        data-files="{{ json_encode($data->foto_jurnal) }}"
                                        data-title="Foto Jurnal - {{ $data->nama_program }}">
                                    <i class="fas fa-images me-1"></i>
                                    {{ count($data->foto_jurnal) }} Foto
                                </button>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @if ($data->dokumen_lpj && count($data->dokumen_lpj) > 0)
                                <button type="button"
                                        class="btn btn-sm btn-light-primary preview-btn"
                                        data-bs-toggle="modal"
                                        data-bs-target="#previewModal"
                                        data-type="document"
                                        data-files="{{ json_encode($data->dokumen_lpj) }}"
                                        data-title="Dokumen LPJ - {{ $data->nama_program }}">
                                    <i class="fas fa-file-alt me-1"></i>
                                    {{ count($data->dokumen_lpj) }} Dokumen
                                </button>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="dropdown dropdown-action" data-row-id="{{ $data->id }}">
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
                                    <li>
                                        <a href="javascript:void(0)" class="dropdown-item-custom"
                                           onclick="showDetailModal({{ json_encode($data) }})">
                                            <i class="fas fa-eye me-2"></i> Lihat Detail
                                        </a>
                                    </li>

                                    {{-- Check if user is superadmin for Edit button --}}
                                    @if(auth()->user()->hasRole('superadmin'))
                                        <li>
                                            <a href="{{ route('admin.laporan-lpj.bidang.prestasi.cabor-permainan.PTMSI.edit', $data->id) }}"
                                                class="dropdown-item-custom edit">
                                                <i class="fas fa-edit me-2"></i> Modifikasi
                                            </a>
                                        </li>
                                    @else
                                        <li>
                                            <span class="dropdown-item-custom restricted-action"
                                                data-bs-toggle="tooltip"
                                                data-bs-placement="left"
                                                data-bs-custom-class="custom-tooltip"
                                                data-bs-html="true"
                                                title="<div class='tooltip-content'>
                                                            <strong>Informasi</strong><br>
                                                            Ajukan approval untuk<br>
                                                            modifikasi laporan
                                                        </div>"
                                                style="cursor: not-allowed; opacity: 0.6;">
                                                <i class="fas fa-edit me-2"></i> Modifikasi
                                            </span>
                                        </li>
                                    @endif

                                    {{-- Check if user is superadmin for Delete button --}}
                                    @if(auth()->user()->hasRole('superadmin'))
                                        <li class="dropdown-item-custom delete"
                                            onclick="deleteItemWithSwal({{ $data->id }}, '{{ addslashes($data->nama_program ?? $data->nama_kegiatan ?? 'laporan ini') }}')">
                                            <i class="ki-outline ki-trash me-2"></i>Hapus Laporan
                                        </li>
                                    @else
                                        <li>
                                            <span class="dropdown-item-custom restricted-action"
                                                data-bs-toggle="tooltip"
                                                data-bs-placement="left"
                                                data-bs-custom-class="custom-tooltip"
                                                data-bs-html="true"
                                                title="<div class='tooltip-content'>
                                                            <strong>Informasi</strong><br>
                                                            Ajukan approval untuk<br>
                                                            modifikasi laporan
                                                        </div>"
                                                style="cursor: not-allowed; opacity: 0.6;">
                                                <i class="fas fa-trash me-2"></i> Hapus
                                            </span>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">Data tidak ditemukan</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Enhanced Pagination Section --}}
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

            @if (isset($PTMSIData) && method_exists($PTMSIData, 'hasPages') && $PTMSIData->hasPages())
                <div class="d-flex align-items-center gap-3">
                    <div class="text-muted small">
                        {{ $PTMSIData->firstItem() }}-{{ $PTMSIData->lastItem() }} of
                        {{ $PTMSIData->total() }}
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        @if ($PTMSIData->onFirstPage())
                            <span class="pagination-arrow disabled">←</span>
                        @else
                            <a href="{{ $PTMSIData->appends(request()->query())->previousPageUrl() }}"
                               class="pagination-arrow pagination-link"
                               aria-label="Previous">←</a>
                        @endif

                        @php
                            $current = $PTMSIData->currentPage();
                            $total = $PTMSIData->lastPage();
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
                                    <a href="{{ $PTMSIData->appends(request()->query())->url($i) }}"
                                       class="pagination-number pagination-link">{{ $i }}</a>
                                @endif
                            @endfor
                        </div>

                        @if ($PTMSIData->hasMorePages())
                            <a href="{{ $PTMSIData->appends(request()->query())->nextPageUrl() }}"
                               class="pagination-arrow pagination-link"
                               aria-label="Next">→</a>
                        @else
                            <span class="pagination-arrow disabled">→</span>
                        @endif
                    </div>
                </div>
            @elseif(isset($PTMSIData) && method_exists($PTMSIData, 'hasPages'))
                <div class="text-muted small">
                    1-{{ $PTMSIData->count() }} of {{ $PTMSIData->total() }}
                </div>
            @endif
        </div>
    </div>

    {{-- Complete Custom CSS from both files --}}
    <style>
        .search-highlight {
            background-color: #fff3cd;
            padding: 1px 3px;
            border-radius: 3px;
            font-weight: bold;
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

        .dropdown-item-custom {
            padding: 8px 16px;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            color: #495057;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .dropdown-item-custom i {
            margin-right: 8px;
            width: 20px;
            text-align: center;
        }

        .dropdown-item-custom:hover {
            background-color: #f8f9fa;
            text-decoration: none;
            color: #495057;
        }

        .dropdown-item-custom.edit:hover {
            background-color: rgb(249, 245, 172) !important;
        }

        .dropdown-item-custom.delete:hover {
            background-color: #ffcad7 !important;
        }

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

        /* Simple Pagination Styles */
        .simple-pagination .page-link {
            border: none !important;
            margin: 0 2px;
            border-radius: 4px !important;
            padding: 6px 12px !important;
            color: #6c757d !important;
            background-color: #f8f9fa !important;
            transition: all 0.2s ease;
        }

        .simple-pagination .page-link:hover {
            background-color: #e9ecef !important;
            color: #495057 !important;
        }

        .simple-pagination .page-item.active .page-link {
            background-color: #007bff !important;
            color: white !important;
        }

        .simple-pagination .page-link:focus {
            box-shadow: none !important;
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

        /* Loading States */
        .loading-spinner {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 10;
        }

        .table-loading {
            position: relative;
            opacity: 0.7;
            pointer-events: none;
        }

        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
        }

        /* Toast Notifications */
        .notification-toast {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            min-width: 300px;
        }

        .toast-success { background-color: #51a351; color: white; }
        .toast-error { background-color: #bd362f; color: white; }
        .toast-warning { background-color: #f89406; color: white; }
        .toast-info { background-color: #2f96b4; color: white; }

        .preview-image {
            max-width: 100%;
            max-height: 80%;
            object-fit: contain;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            background: white;
            padding: 10px;
        }

        .preview-document {
            width: 100%;
            height: 80%;
            border: none;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .document-placeholder {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 80%;
            background: white;
            border: 2px dashed #dee2e6;
            border-radius: 8px;
            text-align: center;
            padding: 40px;
        }

        .document-placeholder i {
            font-size: 4rem;
            color: #6c757d;
            margin-bottom: 1rem;
        }

        .document-placeholder h5 {
            color: #495057;
            margin-bottom: 0.5rem;
        }

        .document-placeholder p {
            color: #6c757d;
            margin-bottom: 1rem;
        }

        .custom-tooltip {
            --bs-tooltip-bg: #ffffff;
            --bs-tooltip-border-color: #e0e0e0;
            --bs-tooltip-color: #333333;
            --bs-tooltip-padding-x: 12px;
            --bs-tooltip-padding-y: 8px;
            --bs-tooltip-border-radius: 8px;
            --bs-tooltip-font-size: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            border: 1px solid var(--bs-tooltip-border-color);
        }

        .custom-tooltip .tooltip-inner {
            background-color: var(--bs-tooltip-bg);
            color: var(--bs-tooltip-color);
            border-radius: var(--bs-tooltip-border-radius);
            padding: var(--bs-tooltip-padding-y) var(--bs-tooltip-padding-x);
            text-align: left;
            max-width: 200px;
        }

        .custom-tooltip .tooltip-arrow::before {
            border-left-color: var(--bs-tooltip-bg);
            border-right-color: var(--bs-tooltip-bg);
        }

        .tooltip-content strong {
            color: #333333;
            font-weight: 600;
        }

        .restricted-action {
            position: relative;
        }

        .restricted-action:hover {
            background-color: transparent !important;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
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

            .d-flex.align-items-center.gap-3 {
                flex-direction: column;
                gap: 0.5rem !important;
            }

            .pagination-arrow,
            .pagination-number {
                padding: 4px 6px;
                font-size: 0.75rem;
            }
        }

        @media (max-width: 576px) {
            .pagination-sm .page-link {
                padding: 0.2rem 0.4rem;
                font-size: 0.7rem;
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
@endif
