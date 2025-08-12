<div style="display: none;" data-filter-counts="{{ json_encode($fileCounts ?? []) }}"></div>

@if (isset($laporanBendahara) && $laporanBendahara->isEmpty())
    <div class="empty-state">
        <i class="fas fa-search fs-3x mb-3 text-muted"></i>
        @if(request('search') || request('filter_type'))
            <h4>Tidak ada laporan yang sesuai dengan filter/pencarian.</h4>
            <p class="text-muted">Coba ubah kata kunci pencarian atau filter yang Anda gunakan.</p>
        @else
            <h4>Tidak ada data laporan bendahara.</h4>
            <p class="text-muted">Belum ada laporan bendahara yang tersimpan dalam sistem.</p>
        @endif
    </div>
@else
    <div class="table-responsive">
        <table class="table table-hover align-middle" id="bendahara-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>
                        <a href="#" class="text-decoration-none text-dark sort-link"
                        data-sort="judul">
                            Judul Laporan
                            @if(request('sort_by') == 'judul')
                                @if(request('order') == 'asc')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort-down"></i>
                                @endif
                            @else
                                <i class="fas fa-sort text-muted"></i>
                            @endif
                        </a>
                    </th>
                    <th>File Laporan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($laporanBendahara))
                    @forelse ($laporanBendahara as $index => $item)
                        @php
                            $extension = $item->dokumen ? strtolower(pathinfo($item->dokumen, PATHINFO_EXTENSION)) : '';
                        @endphp
                        <tr data-extension="{{ $extension }}" data-dokumen="{{ $item->dokumen }}">
                            <td>{{ $laporanBendahara->firstItem() + $loop->index }}</td>

                            <td>
                                <div class="d-flex flex-column">
                                    <strong class="text-dark">
                                        @if(request('search'))
                                            {!! preg_replace('/(' . preg_quote(request('search'), '/') . ')/i', '<span class="search-highlight">$1</span>', $item->judul) !!}
                                        @else
                                            {{ $item->judul }}
                                        @endif
                                    </strong>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</small>
                                </div>
                            </td>

                            <td>
                                @if($item->dokumen)
                                    <div class="d-flex align-items-center">
                                        {{-- Icons that match the filter dropdown exactly --}}
                                        @if($extension == 'pdf')
                                            <i class="fas fa-file-pdf file-icon" style="color: #dc3545; font-size: 16px; margin-right: 8px;"></i>
                                        @elseif(in_array($extension, ['doc', 'docx']))
                                            <i class="fas fa-file-word file-icon" style="color: #0d6efd; font-size: 16px; margin-right: 8px;"></i>
                                        @elseif(in_array($extension, ['xls', 'xlsx']))
                                            <i class="fas fa-file-excel file-icon" style="color: #198754; font-size: 16px; margin-right: 8px;"></i>
                                        @elseif(in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg']))
                                            <i class="fas fa-file-image file-icon" style="color: #fd7e14; font-size: 16px; margin-right: 8px;"></i>
                                        @else
                                            <i class="fas fa-file file-icon" style="color: #6c757d; font-size: 16px; margin-right: 8px;"></i>
                                        @endif

                                        <div>
                                            <div class="fw-semibold file-name" style="color: #dc3545 !important;">
                                                {{ strtoupper($extension) }} File
                                            </div>
                                            @if(file_exists(storage_path('app/public/' . $item->dokumen)))
                                                @php
                                                    $fileSize = filesize(storage_path('app/public/' . $item->dokumen));
                                                    $units = ['B', 'KB', 'MB', 'GB'];
                                                    $factor = floor((strlen($fileSize) - 1) / 3);
                                                    $size = sprintf("%.2f", $fileSize / pow(1024, $factor)) . ' ' . $units[$factor];
                                                @endphp
                                                <small class="text-muted file-size" style="color: #dc3545 !important;">{{ $size }}</small>
                                            @endif
                                        </div>
                                    </div>
                                @else
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-file file-icon" style="color: #6c757d; font-size: 16px; margin-right: 8px;"></i>
                                        <span class="text-muted">Tidak ada file</span>
                                    </div>
                                @endif
                            </td>

                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    {{-- Preview/Detail Button - Light Blue --}}
                                    <a href="{{ route('admin.bendahara.show', $item->id) }}"
                                    class="btn btn-icon btn-sm btn-preview"
                                    style="background-color: #87CEEB !important; border-color: #87CEEB !important; color: #2c5aa0 !important;"
                                    title="Detail">
                                        <i class="fa-solid fa-eye" style="color: #2c5aa0 !important;"></i>
                                    </a>

                                    {{-- Edit Button - Yellow with White Icon --}}
                                    <a href="{{ route('admin.bendahara.edit', $item->id) }}"
                                    class="btn btn-icon btn-sm btn-edit"
                                    style="background-color: #ffc107 !important; border-color: #ffc107 !important; color: white !important;"
                                    title="Edit">
                                        <i class="fa-solid fa-pen-to-square" style="color: white !important;"></i>
                                    </a>

                                    {{-- Delete Button - Red with White Icon --}}
                                    <button type="button"
                                            class="btn btn-icon btn-sm btn-delete"
                                            style="background-color: #dc3545 !important; border-color: #dc3545 !important; color: white !important;"
                                            data-route="{{ route('admin.bendahara.destroy', $item->id) }}"
                                            onclick="destroyItem(this)"
                                            title="Hapus">
                                        <i class="fa-solid fa-trash" style="color: white !important;"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">Data tidak ditemukan</td>
                        </tr>
                    @endforelse
                @endif
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

            @if (isset($laporanBendahara) && method_exists($laporanBendahara, 'hasPages') && $laporanBendahara->hasPages())
                <div class="d-flex align-items-center gap-3">
                    <div class="text-muted small">
                        {{ $laporanBendahara->firstItem() }}-{{ $laporanBendahara->lastItem() }} of
                        {{ $laporanBendahara->total() }}
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        @if ($laporanBendahara->onFirstPage())
                            <span class="pagination-arrow disabled">←</span>
                        @else
                            <a href="{{ $laporanBendahara->appends(request()->query())->previousPageUrl() }}"
                               class="pagination-arrow pagination-link"
                               aria-label="Previous">←</a>
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
                                    <a href="{{ $laporanBendahara->appends(request()->query())->url($i) }}"
                                       class="pagination-number pagination-link">{{ $i }}</a>
                                @endif
                            @endfor
                        </div>

                        @if ($laporanBendahara->hasMorePages())
                            <a href="{{ $laporanBendahara->appends(request()->query())->nextPageUrl() }}"
                               class="pagination-arrow pagination-link"
                               aria-label="Next">→</a>
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
