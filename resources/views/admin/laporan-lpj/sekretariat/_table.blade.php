@if ($kegiatanLainnya->isEmpty())
    <div class="text-center text-muted py-10">
        <i class="ki-duotone ki-information-5 fs-3x mb-3"></i>
        <h4>Tidak ada data kegiatan sekretariat.</h4>
    </div>
@else
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle" id="kt_datatable_dom_positioning_kegiatan">
            <thead class="bg-light">
                <tr>
                    @php
                        $columns = [
                            ['key' => null, 'title' => 'No', 'sortable' => false],
                            ['key' => 'nama_program_kegiatan', 'title' => 'Nama Program & Kegiatan'],
                            ['key' => 'jumlah_harga', 'title' => 'Total Anggaran'],
                            ['key' => null, 'title' => 'Foto Jurnal', 'sortable' => false],
                            ['key' => null, 'title' => 'Dokumen Pendukung', 'sortable' => false],
                            ['key' => null, 'title' => 'Dokumen SPJ', 'sortable' => false],
                            ['key' => 'created_at', 'title' => 'Tanggal Ditambahkan'],
                            ['key' => null, 'title' => 'Aksi', 'sortable' => false],
                        ];
                    @endphp

                    @foreach ($columns as $column)
                        <th class="text-start">
                            @if (($column['sortable'] ?? true) && $column['key'])
                                <a href="{{ request()->fullUrlWithQuery(['sort' => $column['key'], 'direction' => request('sort') == $column['key'] && request('direction') == 'asc' ? 'desc' : 'asc']) }}"
                                    class="text-dark text-decoration-none sortable-header">
                                    {{ $column['title'] }}
                                    <i
                                        class="fas fa-sort{{ request('sort') == $column['key'] ? '-' . (request('direction') == 'asc' ? 'up' : 'down') : '' }}"></i>
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
                    <tr>
                        <td class="text-start">
                            {{ ($kegiatanLainnya->currentPage() - 1) * $kegiatanLainnya->perPage() + $index + 1 }}
                        </td>
                        {{-- PERBAIKAN: Ubah dari nama_program_kegiatan ke nama_program dan jenis_kegiatan ke nama_kegiatan --}}
                        <td class="text-start">
                            <div class="d-flex flex-column">
                                <strong class="text-truncate-custom">{{ $kegiatan->nama_program }}</strong>
                                @if ($kegiatan->nama_kegiatan)
                                    <small class="text-muted">{{ $kegiatan->nama_kegiatan }}</small>
                                @endif
                            </div>
                        </td>
                        <td class="text-start">Rp {{ number_format($kegiatan->jumlah_harga, 0, ',', '.') }}</td>
                        <td class="text-start">
                            @if ($kegiatan->foto_jurnal && count($kegiatan->foto_jurnal) > 0)
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
                        {{-- PERBAIKAN: Ubah dari dokumen_pendukung ke dokumen_lpj --}}
                        <td class="text-start">
                            @if ($kegiatan->dokumen_lpj && count($kegiatan->dokumen_lpj) > 0)
                                <button type="button" class="btn btn-sm btn-light-primary preview-btn"
                                    data-bs-toggle="modal" data-bs-target="#previewModal" data-type="document"
                                    data-files="{{ json_encode($kegiatan->dokumen_lpj) }}"
                                    data-title="Dokumen Pendukung - {{ $kegiatan->nama_program }}">
                                    <i class="fas fa-file-alt me-1"></i>{{ count($kegiatan->dokumen_lpj) }}
                                    Dokumen
                                </button>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td class="text-start">
                            @if ($kegiatan->dokumen_lpj_pdf)
                                @php
                                    // Handle berbagai tipe data untuk dokumen SPJ PDF
                                    $path = '';
                                    $originalName = '';

                                    if (is_object($kegiatan->dokumen_lpj_pdf)) {
                                        $path = $kegiatan->dokumen_lpj_pdf->path;
                                        $originalName = $kegiatan->dokumen_lpj_pdf->original_name ?? basename($path);
                                    } elseif (is_array($kegiatan->dokumen_lpj_pdf)) {
                                        $path = isset($kegiatan->dokumen_lpj_pdf['path']) ? $kegiatan->dokumen_lpj_pdf['path'] : '';
                                        $originalName = isset($kegiatan->dokumen_lpj_pdf['original_name']) ? $kegiatan->dokumen_lpj_pdf['original_name'] : (is_string($path) ? basename($path) : '');
                                    } elseif (is_string($kegiatan->dokumen_lpj_pdf)) {
                                        $path = $kegiatan->dokumen_lpj_pdf;
                                        $originalName = basename($path);
                                    }

                                    // Pastikan kita punya nama file
                                    if (empty($originalName) && is_string($path)) {
                                        $originalName = basename($path);
                                    }
                                @endphp
                                <a href="{{ asset('storage/' . $path) }}" target="_blank" class="btn btn-sm btn-light-danger">
                                    <i class="fas fa-file-pdf me-1"></i>PDF
                                </a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td class="text-start">{{ $kegiatan->created_at ? $kegiatan->created_at->format('d/m/Y') : '-' }}</td>
                        <td class="text-start">
                            <div class="d-inline-flex gap-2" data-row-id="{{ $kegiatan->id }}">
                                    @php
                                        // Eager load the latest approved pengajuan for the modal JS
                                        if (method_exists($kegiatan, 'pengajuan')) {
                                            $kegiatan->setRelation('pengajuan', $kegiatan->pengajuan()->where('status', 'disetujui')->orderBy('approved_at', 'desc')->first());
                                        }
                                    @endphp
                                    <a title="Lihat Detail" data-row-detail href="javascript:void(0)" class="btn btn-icon btn-sm btn-light-primary"
                                       onclick="showDetailModal({{ json_encode($kegiatan) }})">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                @php
                                    $pengajuan = null;
                                    if (method_exists($kegiatan, 'pengajuan')) {
                                        $pengajuan = $kegiatan->pengajuan()->where('status', 'disetujui')->orderBy('approved_at', 'desc')->first();
                                    }

                                    $isModifiable = isset($kegiatan->modifiable_by_user_id) &&
                                                    auth()->user()->id == $kegiatan->modifiable_by_user_id &&
                                                    $pengajuan && $pengajuan->token > 0;

                                    $canEdit = auth()->user()->hasRole('superadmin') ||
                                               auth()->user()->can('pengajuan-modifikasi-laporan-manage') ||
                                               $isModifiable;
                                @endphp

                                    <a href="{{ $canEdit ? route('admin.laporan-lpj.sekretariat.edit', $kegiatan->id) : 'javascript:void(0)' }}"
                                       class="btn btn-icon btn-sm btn-light-warning edit {{ !$canEdit ? 'restricted-action' : '' }}"
                                       @if(!$canEdit)
                                           data-bs-toggle="tooltip"
                                           data-bs-placement="left"
                                           data-bs-custom-class="custom-tooltip"
                                           data-bs-html="true"
                                           title="<div class='tooltip-content'>
                                                       <strong>Informasi</strong><br>
                                                       Ajukan approval untuk<br>
                                                       modifikasi laporan ini
                                                       <a href='javascript:void(0)' onclick='showDetailModal({{ json_encode($kegiatan) }})' class='text-primary mt-2 d-inline-block' onmouseover='keepTooltipVisible(this)' onmouseout='hideTooltipWithDelay(this)'>Lihat Detail</a>
                                                   </div>"
                                       @else
                                           title="Modifikasi"
                                       @endif
                                       style="{{ !$canEdit ? 'cursor: not-allowed; opacity: 0.6;' : '' }}">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <a href="javascript:void(0)"
                                       class="btn btn-icon btn-sm btn-light-danger delete {{ !$canEdit ? 'restricted-action' : '' }}"
                                       @if($canEdit)
                                           onclick="destroyItem(this)"
                                           data-route="{{ route('admin.laporan-lpj.sekretariat.destroy', $kegiatan->id) }}"
                                           title="Hapus"
                                       @else
                                           data-bs-toggle="tooltip"
                                           data-bs-placement="left"
                                           data-bs-custom-class="custom-tooltip"
                                           data-bs-html="true"
                                           title="<div class='tooltip-content'>
                                                       <strong>Informasi</strong><br>
                                                       Ajukan approval untuk<br>
                                                       menghapus laporan ini
                                                       <a href='javascript:void(0)' onclick='showDetailModal({{ json_encode($kegiatan) }})' class='text-primary mt-2 d-inline-block' onmouseover='keepTooltipVisible(this)' onmouseout='hideTooltipWithDelay(this)'>Lihat Detail</a>
                                                   </div>"
                                       @endif
                                       style="{{ !$canEdit ? 'cursor: not-allowed; opacity: 0.6;' : '' }}">
                                        <i class="fas fa-trash"></i>
                                    </a>
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

    <div class="table-footer">
        <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap">
            <div class="mb-2 mb-md-0">
                <div class="d-flex align-items-center">
                    <span class="me-2">Show</span>
                    <select name="per_page" class="form-select form-select-sm w-auto">
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
            max-height: 300px;
            overflow-y: auto;
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
            background-color: #f8d7da !important;
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
            background-color: #0d6efd;
            border-color: #0d6efd;
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
            background-color: #0d6efd !important;
            color: white !important;
        }

        .simple-pagination .page-link:focus {
            box-shadow: none !important;
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

        .notification-toast {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            min-width: 300px;
        }

        .toast-success {
            background-color: #51a351;
            color: white;
        }

        .toast-error {
            background-color: #bd362f;
            color: white;
        }

        .toast-warning {
            background-color: #f89406;
            color: white;
        }

        .toast-info {
            background-color: #2f96b4;
            color: white;
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

        /* CSS untuk tautan dalam tooltip */
        .tooltip-content a {
            display: inline-block;
            margin-top: 8px;
            padding: 4px 8px;
            background-color: rgba(27, 132, 255, 0.1);
            border-radius: 4px;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .tooltip-content a:hover {
            background-color: rgba(27, 132, 255, 0.2);
            text-decoration: none;
        }

        .tooltip-content a:focus {
            outline: none;
            box-shadow: 0 0 0 2px rgba(27, 132, 255, 0.25);
        }

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
