<!-- Form Pencarian -->
<div class="mb-6">
    <div class="d-flex justify-content-end gap-2">
        <div class="col-md-4">
            <div class="position-relative bg-light">
                <i class="ki-outline ki-magnifier fs-3 position-absolute top-50 translate-middle-y ms-3"></i>
                <input type="text" 
                       id="search-prestasi" 
                       name="search" 
                       value="{{ request('search') }}" 
                       placeholder="Cari Atlet atau Pelatih..." 
                       class="form-control border border-gray-500 px-10 py-2" />
            </div>
        </div>
    </div>
</div>

<div class="tab-content">
    <!-- Prestasi Atlet -->
    <div class="tab-pane fade show active" id="atlet-prestasi" role="tabpanel">
        @if(isset($latest_prestasi) && $latest_prestasi->isNotEmpty())
            @php
                $atletPrestasi = $latest_prestasi->filter(function($prestasi) {
                    return $prestasi->subject_type === 'App\Models\Atlet';
                })->values(); // Reset keys for proper numbering
            @endphp

            @if($atletPrestasi->isNotEmpty())
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
                            @foreach($atletPrestasi as $index => $prestasi)
                                <tr class="border-bottom border-gray-200">
                                    <td>
                                        <span class="text-gray-800 fw-bold fs-6">{{ $index + 1 }}</span>
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
        @else
            <div class="text-center py-10">
                <i class="ki-duotone ki-medal text-gray-400 fs-5x mb-5">
                    <span class="path1"></span>
                    <span class="path2"></span>
                    <span class="path3"></span>
                    <span class="path4"></span>
                </i>
                <div class="text-gray-500 fs-6">Belum ada data prestasi</div>
                <div class="text-gray-400 fs-7">Prestasi atlet akan muncul di sini</div>
            </div>
        @endif
    </div>

    <!-- Prestasi Pelatih -->
    <div class="tab-pane fade" id="pelatih-prestasi" role="tabpanel">
        @if(isset($latest_prestasi) && $latest_prestasi->isNotEmpty())
            @php
                $pelatihPrestasi = $latest_prestasi->filter(function($prestasi) {
                    return $prestasi->subject_type === 'App\Models\Pelatih';
                })->values(); // Reset keys for proper numbering
            @endphp

            @if($pelatihPrestasi->isNotEmpty())
                <div class="table-responsive">
                    <table class="table table-borderless align-middle">
                        <thead>
                            <tr class="text-muted fw-bold fs-7 text-uppercase gs-0">
                                <th class="min-w-50px">No</th>
                                <th class="min-w-200px">Pelatih & Cabor</th>
                                <th class="min-w-200px">Prestasi</th>
                                <th class="min-w-150px">Tempat Lomba</th>
                                <th class="min-w-100px">Usia</th>
                                <th class="min-w-75px">Tahun</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pelatihPrestasi as $index => $prestasi)
                                <tr class="border-bottom border-gray-200">
                                    <td>
                                        <span class="text-gray-800 fw-bold fs-6">{{ $index + 1 }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="symbol symbol-40px me-4">
                                                @if(!empty($prestasi->subject->foto))
                                                    @php
                                                        $fotoPath = '/storage/' . $prestasi->subject->foto;
                                                    @endphp
                                                    <img src="{{ $fotoPath }}" class="symbol-label rounded-circle" style="object-fit: cover; width: 40px; height: 40px;" alt="{{ $prestasi->subject->nama ?? 'Pelatih' }}">
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
                    <div class="text-gray-500 fs-6">Belum ada prestasi pelatih</div>
                    <div class="text-gray-400 fs-7">Prestasi pelatih akan muncul di sini</div>
                </div>
            @endif
        @else
            <div class="text-center py-10">
                <i class="ki-duotone ki-medal text-gray-400 fs-5x mb-5">
                    <span class="path1"></span>
                    <span class="path2"></span>
                    <span class="path3"></span>
                    <span class="path4"></span>
                </i>
                <div class="text-gray-500 fs-6">Belum ada data prestasi</div>
                <div class="text-gray-400 fs-7">Prestasi pelatih akan muncul di sini</div>
            </div>
        @endif
    </div>
</div>

<!-- Pagination -->
@if(isset($latest_prestasi) && $latest_prestasi->hasPages())
<div class="table-footer">
    <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap">
        <div class="mb-2 mb-md-0">
            <div class="d-flex align-items-center">
                <span class="me-2">Show</span>
                <select name="per_page" class="form-select form-select-sm w-auto" id="per-page-select">
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

        <div class="d-flex align-items-center gap-2">
            <div class="text-muted small">
                Menampilkan {{ $latest_prestasi->firstItem() }}-{{ $latest_prestasi->lastItem() }} dari {{ $latest_prestasi->total() }} hasil
            </div>

            @if ($latest_prestasi->onFirstPage())
                <span class="pagination-arrow disabled">←</span>
            @else
                <a href="{{ $latest_prestasi->appends(['per_page' => request('per_page', 10), 'search' => request('search')])->previousPageUrl() }}"
                   class="pagination-arrow prestasi-pagination-link"
                   aria-label="Previous">←</a>
            @endif

            @php
                $current = $latest_prestasi->currentPage();
                $total = $latest_prestasi->lastPage();
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
                        <a href="{{ $latest_prestasi->appends(['per_page' => request('per_page', 10), 'search' => request('search')])->url($i) }}"
                           class="pagination-number prestasi-pagination-link">{{ $i }}</a>
                    @endif
                @endfor
            </div>

            @if ($latest_prestasi->hasMorePages())
                <a href="{{ $latest_prestasi->appends(['per_page' => request('per_page', 10), 'search' => request('search')])->nextPageUrl() }}"
                   class="pagination-arrow prestasi-pagination-link"
                   aria-label="Next">→</a>
            @else
                <span class="pagination-arrow disabled">→</span>
            @endif
        </div>
    </div>
</div>
@endif

<script>
// Re-initialize tab functionality after AJAX load
$(document).ready(function() {
    // Handle tab switching
    $('.nav-link[data-bs-toggle="tab"]').on('click', function(e) {
        e.preventDefault();
        $(this).tab('show');
    });
    
    // Re-initialize search functionality after AJAX load
    initializeSearch();
    
    // Handle per page change
    $(document).on('change', '#per-page-select', function() {
        const perPage = $(this).val();
        const search = $('#search-prestasi').val();
        
        loadPrestasiData(1, search, perPage);
    });
    
    // Handle pagination links
    $(document).on('click', '.prestasi-pagination-link', function(e) {
        e.preventDefault();
        const url = $(this).attr('href');
        if (url && url !== '#') {
            // Extract parameters from URL
            const urlObj = new URL(url);
            const page = urlObj.searchParams.get('page') || 1;
            const search = urlObj.searchParams.get('search') || $('#search-prestasi').val();
            const perPage = urlObj.searchParams.get('per_page') || $('#per-page-select').val();
            
            loadPrestasiData(page, search, perPage);
        }
    });
});

function loadPrestasiData(page, search, perPage) {
    $.ajax({
        url: '{{ route("admin.dashboard.prestasi-pagination") }}',
        type: 'GET',
        data: { 
            page: page,
            search: search,
            per_page: perPage
        },
        beforeSend: function() {
            $('#prestasi-table-container').html(
                '<div class="text-center py-10">' +
                '<div class="spinner-border text-primary" role="status">' +
                '<span class="visually-hidden">Loading...</span>' +
                '</div></div>'
            );
        },
        success: function(response) {
            if (response.success) {
                $('#prestasi-table-container').html(response.html);
                // Re-initialize all functions after content update
                $('.nav-link[data-bs-toggle="tab"]').on('click', function(e) {
                    e.preventDefault();
                    $(this).tab('show');
                });
                initializeSearch(); // Re-initialize search
            } else {
                $('#prestasi-table-container').html(
                    '<div class="text-center py-10">' +
                    '<div class="text-danger">Terjadi kesalahan saat memuat data.</div>' +
                    '</div>'
                );
            }
        },
        error: function(xhr) {
            console.error('Error:', xhr.responseText);
            $('#prestasi-table-container').html(
                '<div class="text-center py-10">' +
                '<div class="text-danger">Terjadi kesalahan saat memuat data.</div>' +
                '</div>'
            );
        }
    });
}

function initializeSearch() {
    let searchTimeout;
    
    // Clear any existing event handlers to prevent duplicates
    $('#search-prestasi').off('input').on('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            const search = $(this).val();
            const perPage = $('#per-page-select').val();
            
            loadPrestasiData(1, search, perPage);
        }, 300); // Debounce 300ms
    });
}
</script>