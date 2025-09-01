@if ($kegiatanLainnya->isEmpty())
    @if (request('search'))
        {{-- Empty State untuk Search Tidak Ditemukan --}}
        <div class="text-center text-muted py-10">
            <i class="fas fa-search fs-1 mb-3 text-muted"></i>
            <h4>Data tidak ditemukan untuk pencarian "{{ request('search') }}"</h4>
        </div>
    @elseif(request('jenis_kegiatan_filter'))
        {{-- Empty State untuk Filter Tidak Ditemukan --}}
        <div class="text-center text-muted py-10">
            <i class="fas fa-filter fs-1 mb-3 text-muted"></i>
            <h4>Data tidak ditemukan untuk jenis kegiatan "{{ request('jenis_kegiatan_filter') }}"</h4>
            <button class="btn btn-light-primary mt-3"
                onclick="window.location.href='{{ route('admin.laporan-lpj.kegiatan-lainnya.index') }}'">
                Reset Filter
            </button>
        </div>
    @else
        {{-- Empty State untuk Data Kosong --}}
        <div class="text-center text-muted py-10">
            <i class="fas fa-info-circle fs-1 mb-3 text-muted"></i>
            <h4>Data tidak tersedia</h4>
        </div>
    @endif
@else
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle table-fixed"
            id="kt_datatable_dom_positioning_kegiatan">
            <thead class="bg-light">
                <tr>
                    @php
                        $columns = [
                            ['key' => null, 'title' => 'No', 'sortable' => false],
                            ['key' => 'nama_program', 'title' => 'Nama Program & Kegiatan'],
                            ['key' => 'volume', 'title' => 'Volume'],
                            ['key' => 'jumlah_harga_satuan', 'title' => 'Jumlah Harga Satuan'],
                            ['key' => 'jumlah_harga', 'title' => 'Jumlah Harga'],
                            ['key' => null, 'title' => 'Foto Jurnal', 'sortable' => false],
                            ['key' => null, 'title' => 'Dokumen', 'sortable' => false],
                            ['key' => 'created_at', 'title' => 'Ditambahkan'],
                            ['key' => null, 'title' => 'Aksi', 'sortable' => false],
                        ];
                    @endphp

                    @foreach ($columns as $column)
                        <th class="text-start">
                            @if (($column['sortable'] ?? true) && $column['key'])
                                <a href="{{ request()->fullUrlWithQuery([
                                    'sort_by' => $column['key'],
                                    'sort_order' => request('sort_by') === $column['key'] && request('sort_order') === 'asc' ? 'desc' : 'asc',
                                    'page' => 1,
                                ]) }}"
                                    class="text-dark text-decoration-none sortable-header">
                                    {{ $column['title'] }}
                                    @if (request('sort_by') === $column['key'])
                                        @if (request('sort_order') === 'asc')
                                            <i class="fas fa-sort-up text-primary ms-1"></i>
                                        @else
                                            <i class="fas fa-sort-down text-primary ms-1"></i>
                                        @endif
                                    @else
                                        <i class="fas fa-sort text-muted ms-1"></i>
                                    @endif
                                </a>
                            @else
                                {{ $column['title'] }}
                            @endif
                        </th>
                    @endforeach
                </tr>
            </thead>

            <tbody>
                @forelse ($kegiatanLainnya as $index => $kegiatan)
                    <tr data-jenis-kegiatan="{{ $kegiatan->nama_kegiatan ?? '' }}"
                        data-tanggal="{{ \Carbon\Carbon::parse($kegiatan->tanggal_kegiatan ?? $kegiatan->created_at)->format('Y-m-d') }}">
                        <td class="text-center">
                            {{ ($kegiatanLainnya->currentPage() - 1) * $kegiatanLainnya->perPage() + $index + 1 }}
                        </td>

                        <td>
                            <div class="d-flex flex-column">
                                <strong class="text-truncate-custom" title="{{ $kegiatan->nama_program }}">
                                    {{ $kegiatan->nama_program }}
                                </strong>
                                @if ($kegiatan->nama_kegiatan)
                                    <small class="text-muted">{{ $kegiatan->nama_kegiatan }}</small>
                                @endif
                            </div>
                        </td>

                        <td class="text-start">{{ $kegiatan->volume }}</td>

                        <td class="text-start">Rp {{ number_format($kegiatan->jumlah_harga_satuan, 0, ',', '.') }}</td>

                        <td class="text-start">Rp {{ number_format($kegiatan->jumlah_harga, 0, ',', '.') }}</td>

                        <td class="text-start">
                            @if (!empty($kegiatan->foto_jurnal) && is_array($kegiatan->foto_jurnal))
                                <button type="button" class="btn btn-sm btn-light-info preview-btn"
                                    data-bs-toggle="modal" data-bs-target="#previewModal" data-type="image"
                                    data-files="{{ json_encode($kegiatan->foto_jurnal) }}"
                                    data-title="Foto Jurnal - {{ $kegiatan->nama_program }}">
                                    <i class="fas fa-images me-1"></i>{{ count($kegiatan->foto_jurnal) }} Foto
                                </button>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>

                        <td class="text-start">
                            @if (!empty($kegiatan->dokumen_lpj) && is_array($kegiatan->dokumen_lpj))
                                <button type="button" class="btn btn-sm btn-light-primary preview-btn"
                                    data-bs-toggle="modal" data-bs-target="#previewModal" data-type="document"
                                    data-files="{{ json_encode($kegiatan->dokumen_lpj) }}"
                                    data-title="Dokumen LPJ - {{ $kegiatan->nama_program }}">
                                    <i class="fas fa-file-alt me-1"></i>{{ count($kegiatan->dokumen_lpj) }} Dokumen
                                </button>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>

                        <td class="text-start">
                            {{ \Carbon\Carbon::parse($kegiatan->created_at)->format('d M Y') }}
                        </td>

                        <td class="text-center">
                            <div class="dropdown dropdown-action" data-row-id="{{ $kegiatan->id }}">
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
                                    <li>
                                        <a href="javascript:void(0)" class="dropdown-item-custom"
                                            onclick="showDetailModal({{ json_encode($kegiatan) }})">
                                            <i class="fas fa-eye me-2"></i> Lihat Detail
                                        </a>
                                    </li>

                                    @if (auth()->user()->hasRole('superadmin'))
                                        <li><a href="{{ route('admin.laporan-lpj.kegiatan-lainnya.edit', $kegiatan->id) }}"
                                                class="dropdown-item-custom edit">
                                                <i class="fas fa-edit me-2"></i> Modifikasi</a></li>
                                    @else
                                        <li><span class="dropdown-item-custom restricted-action"
                                                data-bs-toggle="tooltip" data-bs-placement="left"
                                                data-bs-custom-class="custom-tooltip" data-bs-html="true"
                                                title="<div class='tooltip-content'><strong>Informasi</strong><br>Ajukan approval untuk<br>modifikasi laporan</div>"
                                                style="cursor: not-allowed; opacity: 0.6;">
                                                <i class="fas fa-edit me-2"></i> Modifikasi</span></li>
                                    @endif

                                    @if (auth()->user()->hasRole('superadmin'))
                                        <li><button type="button"
                                                class="dropdown-item-custom delete border-0 bg-transparent w-100 text-start text-danger"
                                                data-route="{{ route('admin.laporan-lpj.kegiatan-lainnya.destroy', $kegiatan->id) }}"
                                                onclick="destroyItem(this)">
                                                <i class="fas fa-trash me-2"></i> Hapus</button></li>
                                    @else
                                        <li><span class="dropdown-item-custom restricted-action"
                                                data-bs-toggle="tooltip" data-bs-placement="left"
                                                data-bs-custom-class="custom-tooltip" data-bs-html="true"
                                                title="<div class='tooltip-content'><strong>Informasi</strong><br>Ajukan approval untuk<br>modifikasi laporan</div>"
                                                style="cursor: not-allowed; opacity: 0.6;">
                                                <i class="fas fa-trash me-2"></i> Hapus</span></li>
                                    @endif
                                </ul>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center py-5 text-muted">Data tidak ditemukan</td>
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
                    <select name="per_page" class="form-select form-select-sm w-auto" id="per-page-select">
                        @foreach ([10, 25, 50, 100] as $limit)
                            <option value="{{ $limit }}"
                                {{ request('per_page', 10) == $limit ? 'selected' : '' }}>{{ $limit }}</option>
                        @endforeach
                    </select>
                    <span class="ms-2">per page</span>
                </div>
            </div>

            @if (isset($kegiatanLainnya) && method_exists($kegiatanLainnya, 'hasPages') && $kegiatanLainnya->hasPages())
                <div class="d-flex align-items-center gap-3">
                    <div class="text-muted small">
                        {{ $kegiatanLainnya->firstItem() }}-{{ $kegiatanLainnya->lastItem() }} of
                        {{ $kegiatanLainnya->total() }}</div>

                    <div class="d-flex align-items-center gap-2">
                        @if ($kegiatanLainnya->onFirstPage())
                            <span class="pagination-arrow disabled">←</span>
                        @else
                            <a href="{{ $kegiatanLainnya->appends(request()->query())->previousPageUrl() }}"
                                class="pagination-arrow pagination-link" aria-label="Previous">←</a>
                        @endif

                        @php
                            $current = $kegiatanLainnya->currentPage();
                            $total = $kegiatanLainnya->lastPage();
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
                                    <a href="{{ $kegiatanLainnya->appends(request()->query())->url($i) }}"
                                        class="pagination-number pagination-link">{{ $i }}</a>
                                @endif
                            @endfor
                        </div>

                        @if ($kegiatanLainnya->hasMorePages())
                            <a href="{{ $kegiatanLainnya->appends(request()->query())->nextPageUrl() }}"
                                class="pagination-arrow pagination-link" aria-label="Next">→</a>
                        @else
                            <span class="pagination-arrow disabled">→</span>
                        @endif
                    </div>
                </div>
            @elseif(isset($kegiatanLainnya) && method_exists($kegiatanLainnya, 'hasPages'))
                <div class="text-muted small">1-{{ $kegiatanLainnya->count() }} of {{ $kegiatanLainnya->total() }}
                </div>
            @endif
        </div>
    </div>

    <style>
        /* Table fixed layout for consistent column alignment */
        .table-fixed {
            table-layout: fixed;
            min-width: 1200px;
        }

        .table-fixed th:nth-child(1),
        .table-fixed td:nth-child(1) {
            width: 40px !important;
        }

        .table-fixed th:nth-child(2),
        .table-fixed td:nth-child(2) {
            width: 250px !important;
        }

        .table-fixed th:nth-child(3),
        .table-fixed td:nth-child(3) {
            width: 100px !important;
        }

        .table-fixed th:nth-child(4),
        .table-fixed td:nth-child(4) {
            width: 150px !important;
        }

        .table-fixed th:nth-child(5),
        .table-fixed td:nth-child(5) {
            width: 150px !important;
        }

        .table-fixed th:nth-child(6),
        .table-fixed td:nth-child(6) {
            width: 100px !important;
        }

        .table-fixed th:nth-child(7),
        .table-fixed td:nth-child(7) {
            width: 120px !important;
        }

        .table-fixed th:nth-child(8),
        .table-fixed td:nth-child(8) {
            width: 100px !important;
        }

        .table-fixed th:nth-child(9),
        .table-fixed td:nth-child(9) {
            width: 80px !important;
        }

        .text-truncate-custom {
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
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

        @media (max-width: 768px) {

            .table-header,
            .table-footer {
                position: sticky;
                bottom: 0;
                background: white;
                padding: 15px 0;
                border-top: 1px solid #dee2e6;
                z-index: 10;
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

            .dropdown-menu-custom {
                position: absolute !important;
                z-index: 9999 !important;
                right: 0 !important;
                left: auto !important;
                min-width: 140px;
            }

            .pagination-arrow,
            .pagination-number {
                padding: 4px 6px;
                font-size: 0.75rem;
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
