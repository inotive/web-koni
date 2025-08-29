@if(isset($prestasi_list) && $prestasi_list->isNotEmpty())
    <div class="table-responsive">
        <table class="table table-borderless align-middle">
            <thead>
                <tr class="text-muted fw-bold fs-7 text-uppercase gs-0">
                    <th class="min-w-50px">No</th>
                    <th class="min-w-200px">Atlet & Cabor</th>
                    <th class="min-w-200px">Prestasi</th>
                    <th class="min-w-150px">Tempat Lomba</th>
                    <th class="min-w-100px">Usia</th>
                    <th class="min-w-75px">Tahun</th>
                </tr>
            </thead>
            <tbody>
                @foreach($prestasi_list as $index => $prestasi)
                    <tr class="border-bottom border-gray-200">
                        <td>
                            <span class="text-gray-800 fw-bold fs-6">{{ $prestasi_list->firstItem() + $index }}</span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="symbol symbol-40px me-4">
                                    @if(!empty($prestasi->subject->foto))
                                        @php
                                            $fotoPath = '/storage/' . $prestasi->subject->foto;
                                        @endphp
                                        <img src="{{ $fotoPath }}" class="symbol-label rounded-circle" style="object-fit: cover; width: 40px; height: 40px;" alt="{{ $prestasi->subject->nama ?? 'Atlet' }}">
                                    @else
                                        <div class="symbol-label fs-2 fw-bold bg-light-primary text-primary rounded-circle">
                                            {{ substr($prestasi->subject->nama ?? 'N/A', 0, 1) }}
                                        </div>
                                    @endif
                                </div>
                                <div class="d-flex flex-column">
                                    <span class="text-gray-900 fw-bold fs-6">{{ $prestasi->subject->nama ?? 'N/A' }}</span>
                                    <span class="text-muted fs-7">
                                        {{ $prestasi->subject->cabangOlahraga->nama_cabor ?? 'N/A' }}
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td>
                            @php
                                $iconColor = '';
                                switch ($prestasi->medali) {
                                    case 'Emas':
                                        $iconColor = 'text-warning';
                                        break;
                                    case 'Perak':
                                        $iconColor = 'text-dark';
                                        break;
                                    case 'Perunggu':
                                        $iconColor = 'text-bronze';
                                        break;
                                    default:
                                        $iconColor = 'text-primary';
                                        break;
                                }
                            @endphp
                            <div class="d-flex align-items-center mb-1">
                                <i class="fas fa-medal me-2 {{ $iconColor }}"></i>
                                <span class="text-gray-800 fw-bold fs-6">{{ $prestasi->nama_prestasi }}</span>
                            </div>
                            <div class="text-gray-600 fw-semibold fs-7">{{ $prestasi->kejuaraan }}</div>
                        </td>
                        <td>
                            <span class="text-gray-800 fw-bold fs-6">{{ $prestasi->tempat }}</span>
                        </td>
                        <td>
                            @php
                                $usia = '-';
                                if ($prestasi->subject && $prestasi->subject->tanggal_lahir) {
                                    $usia = \Carbon\Carbon::parse($prestasi->subject->tanggal_lahir)->age . ' thn';
                                }
                            @endphp
                            <span class="text-gray-800 fw-bold fs-6">{{ $usia }}</span>
                        </td>
                        <td>
                            <span class="text-gray-800 fw-bold fs-6">{{ $prestasi->tahun }}</span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <div class="text-center py-10">
        <i class="ki-duotone ki-medal text-gray-400 fs-5x mb-5">
            <span class="path1"></span>
            <span class="path2"></span>
            <span class="path3"></span>
            <span class="path4"></span>
        </i>
        <div class="text-gray-500 fs-6">Belum ada prestasi atlet</div>
        <div class="text-gray-400 fs-7">Prestasi atlet akan muncul di sini</div>
    </div>
@endif

<!-- Pagination -->
@if(isset($prestasi_list) && $prestasi_list->hasPages())
    <div class="table-footer mt-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div class="mb-2 mb-md-0">
                <div class="d-flex align-items-center">
                    <span class="me-2">Show</span>
                    <select name="per_page" class="form-select form-select-sm w-auto" id="per-page-select-{{ $type }}">
                        @foreach ([5, 10, 25, 50] as $limit)
                            <option value="{{ $limit }}"
                                {{ request('per_page', 5) == $limit ? 'selected' : '' }}>
                                {{ $limit }}
                            </option>
                        @endforeach
                    </select>
                    <span class="ms-2">per page</span>
                </div>
            </div>

            <div class="d-flex align-items-center gap-2">
                <div class="text-muted small">
                    Menampilkan {{ $prestasi_list->firstItem() }}-{{ $prestasi_list->lastItem() }} dari {{ $prestasi_list->total() }} hasil
                </div>

                @if ($prestasi_list->onFirstPage())
                    <span class="pagination-arrow disabled">←</span>
                @else
                    <a href="{{ $prestasi_list->previousPageUrl() }}"
                       class="pagination-arrow prestasi-pagination-link"
                       data-type="{{ $type }}"
                       aria-label="Previous">←</a>
                @endif

                @php
                    $current = $prestasi_list->currentPage();
                    $total = $prestasi_list->lastPage();
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
                            <a href="{{ $prestasi_list->url($i) }}"
                               class="pagination-number prestasi-pagination-link"
                               data-type="{{ $type }}">{{ $i }}</a>
                        @endif
                    @endfor
                </div>

                @if ($prestasi_list->hasMorePages())
                    <a href="{{ $prestasi_list->nextPageUrl() }}"
                       class="pagination-arrow prestasi-pagination-link"
                       data-type="{{ $type }}"
                       aria-label="Next">→</a>
                @else
                    <span class="pagination-arrow disabled">→</span>
                @endif
            </div>
        </div>
    </div>
@endif
