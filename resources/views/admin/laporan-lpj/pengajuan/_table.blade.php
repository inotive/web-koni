@if ($pengajuans->isEmpty())
    {{-- Empty State --}}
    <div class="text-center text-muted py-10">
        <i class="ki-duotone ki-information-5 fs-3x mb-3"></i>
        <h4>Tidak ada pengajuan modifikasi.</h4>
        <p>Belum ada pengajuan untuk modifikasi laporan LPJ.</p>
    </div>
@else
    {{-- Data Table --}}
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle" id="kt_datatable_dom_positioning_pengajuan">
            {{-- Table Header --}}
            <thead class="bg-light">
                <tr>
                    <th style="text-align: left">No</th>
                    <th>
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'nama_program', 'direction' => (request()->get('sort') == 'nama_program' && request()->get('direction') == 'asc') ? 'desc' : 'asc']) }}"
                            class="text-dark text-decoration-none sortable-header">
                            Program/Kegiatan
                            @if(request()->get('sort') == 'nama_program')
                                <i class="fas fa-sort-{{ request()->get('direction') == 'asc' ? 'up' : 'down' }}"></i>
                            @else
                                <i class="fas fa-sort"></i>
                            @endif
                        </a>
                    </th>
                    <th>
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'user', 'direction' => (request()->get('sort') == 'user' && request()->get('direction') == 'asc') ? 'desc' : 'asc']) }}"
                            class="text-dark text-decoration-none sortable-header">
                            Pengaju
                            @if(request()->get('sort') == 'user')
                                <i class="fas fa-sort-{{ request()->get('direction') == 'asc' ? 'up' : 'down' }}"></i>
                            @else
                                <i class="fas fa-sort"></i>
                            @endif
                        </a>
                    </th>
                    <th>Alasan Pengajuan</th>
                    <th>
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'status', 'direction' => (request()->get('sort') == 'status' && request()->get('direction') == 'asc') ? 'desc' : 'asc']) }}"
                            class="text-dark text-decoration-none sortable-header">
                            Status
                            @if(request()->get('sort') == 'status')
                                <i class="fas fa-sort-{{ request()->get('direction') == 'asc' ? 'up' : 'down' }}"></i>
                            @else
                                <i class="fas fa-sort"></i>
                            @endif
                        </a>
                    </th>
                    <th>
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'created_at', 'direction' => (request()->get('sort') == 'created_at' && request()->get('direction') == 'asc') ? 'desc' : 'asc']) }}"
                            class="text-dark text-decoration-none sortable-header">
                            Tanggal Pengajuan
                            @if(request()->get('sort') == 'created_at')
                                <i class="fas fa-sort-{{ request()->get('direction') == 'asc' ? 'up' : 'down' }}"></i>
                            @else
                                <i class="fas fa-sort"></i>
                            @endif
                        </a>
                    </th>
                    <th>
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'approved_at', 'direction' => (request()->get('sort') == 'approved_at' && request()->get('direction') == 'asc') ? 'desc' : 'asc']) }}"
                        class="text-dark text-decoration-none sortable-header">
                            Tanggal Disetujui
                            @if(request()->get('sort') == 'approved_at')
                                <i class="fas fa-sort-{{ request()->get('direction') == 'asc' ? 'up' : 'down' }}"></i>
                            @else
                                <i class="fas fa-sort"></i>
                            @endif
                        </a>
                    </th>
                    <th style="text-align: center">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($pengajuans as $index => $pengajuan)
                    <tr>
                        <td class="text-center">
                            {{ ($pengajuans->currentPage() - 1) * $pengajuans->perPage() + $index + 1 }}
                        </td>
                        <td>
                            <div class="d-flex flex-column">
                                <strong class="text-truncate-custom">{{ $pengajuan->lpj->nama_program ?? 'N/A' }}</strong>
                                @if ($pengajuan->lpj && $pengajuan->lpj->nama_kegiatan)
                                    <small class="text-muted" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $pengajuan->lpj->nama_kegiatan }}</small>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-user me-2 text-muted"></i>
                                <strong>
                                    @if($pengajuan->user)
                                        {{ $pengajuan->user->username }}
                                    @else
                                        <span class="text-danger">User not found</span>
                                    @endif
                                </strong>
                            </div>
                        </td>
                        <td>
                            <div class="text-truncate-custom"
                                 data-bs-toggle="tooltip"
                                 data-bs-placement="top"
                                 title="{{ $pengajuan->alasan }}">
                                {{ Str::limit($pengajuan->alasan, 35) }}
                            </div>
                        </td>
                        <td>
                            @php
                                $badgeClass = '';
                                $icon = '';
                                $statusText = $pengajuan->status;

                                switch ($pengajuan->status) {
                                    case 'menunggu persetujuan':
                                        $badgeClass = 'status-badge status-menunggu';
                                        $icon = '<i class="fas fa-clock me-1" style="color: #856404;"></i>';
                                        $statusText = 'Menunggu Persetujuan';
                                        break;
                                    case 'disetujui':
                                        $badgeClass = 'status-badge status-disetujui';
                                        $icon = '<i class="fas fa-check-circle me-1" style="color: #155724;"></i>';
                                        $statusText = 'Disetujui';
                                        break;
                                    case 'ditolak':
                                        $badgeClass = 'status-badge status-ditolak';
                                        $icon = '<i class="fas fa-times-circle me-1" style="color: #721c24;"></i>';
                                        $statusText = 'Ditolak';
                                        break;
                                }
                            @endphp
                            <span class="{{ $badgeClass }}">{!! $icon !!}{{ $statusText }}</span>
                        </td>
                        <td>
                            <div class="d-flex flex-column">
                                <span class="fw-medium">{{ $pengajuan->created_at->format('d M Y') }}</span>
                                <small class="text-muted">{{ $pengajuan->created_at->format('H:i') }}</small>
                            </div>
                        </td>
                        <td>
                            @if($pengajuan->status === 'disetujui' && $pengajuan->approved_at)
                                <div class="d-flex flex-column">
                                    <span class="fw-medium">{{ $pengajuan->approved_at->format('d M Y') }}</span>
                                    <small class="text-muted">{{ $pengajuan->approved_at->format('H:i') }}</small>
                                </div>
                            @else
                                <small class="text-muted">-</small>
                            @endif
                        </td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-primary" onclick='showDetailModal(@json($pengajuan))'>
                                <i class="fas fa-eye me-1"></i>Detail
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">Data pengajuan tidak ditemukan</td>
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

            @if (isset($pengajuans) && method_exists($pengajuans, 'hasPages') && $pengajuans->hasPages())
                <div class="d-flex align-items-center gap-3">
                    <div class="text-muted small">
                        {{ $pengajuans->firstItem() }}-{{ $pengajuans->lastItem() }} of
                        {{ $pengajuans->total() }}
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        @if ($pengajuans->onFirstPage())
                            <span class="pagination-arrow disabled">←</span>
                        @else
                            <a href="{{ $pengajuans->appends(request()->query())->previousPageUrl() }}"
                               class="pagination-arrow pagination-link"
                               aria-label="Previous">←</a>
                        @endif

                        @php
                            $current = $pengajuans->currentPage();
                            $total = $pengajuans->lastPage();
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
                                    <a href="{{ $pengajuans->appends(request()->query())->url($i) }}"
                                       class="pagination-number pagination-link">{{ $i }}</a>
                                @endif
                            @endfor
                        </div>

                        @if ($pengajuans->hasMorePages())
                            <a href="{{ $pengajuans->appends(request()->query())->nextPageUrl() }}"
                               class="pagination-arrow pagination-link"
                               aria-label="Next">→</a>
                        @else
                            <span class="pagination-arrow disabled">→</span>
                        @endif
                    </div>
                </div>
            @elseif(isset($pengajuans) && method_exists($pengajuans, 'hasPages'))
                <div class="text-muted small">
                    1-{{ $pengajuans->count() }} of {{ $pengajuans->total() }}
                </div>
            @endif
        </div>
    </div>

    {{-- Complete Custom CSS integrated from documents 1 and 2 --}}
    <style>
        .search-highlight {
            background-color: #fff3cd;
            padding: 1px 3px;
            border-radius: 3px;
            font-weight: bold;
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

        /* Status Badge Styles */
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: capitalize;
        }

        .status-menunggu {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }

        .status-disetujui {
            background: #d4edda;
            color: #155724;
            border: 1px solid #00b894;
        }

        .status-ditolak {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #e74c3c;
        }

        /* Custom tooltip styling */
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
    </style>
@endif
