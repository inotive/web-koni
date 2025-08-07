{{-- File: resources/views/admin/cabang-olahraga/partials/pagination.blade.php --}}
<div class="d-flex justify-content-between align-items-center flex-wrap">
    <!-- Per page selector & Info -->
    <div class="d-flex align-items-center gap-2 flex-wrap">
        <div class="d-flex align-items-center gap-2">
            <label class="form-label mb-0">Tampilkan:</label>
            <select class="form-select form-select-sm" style="width: auto;" name="per_page" id="ajax-per-page">
                <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
            </select>
            <span class="text-muted">data per halaman</span>
        </div>

        <div class="text-muted">
            Menampilkan {{ $cabors->count() }} dari {{ $cabors->total() }} total data
            @if (request('search') || request('status'))
                <br><small class="text-info">
                    (Hasil pencarian/filter:
                    @if (request('search'))
                        "{{ request('search') }}"
                    @endif
                    @if (request('status'))
                        Status: {{ request('status') }}
                    @endif
                    )
                </small>
            @endif
        </div>
    </div>

    <!-- Pagination Controls -->
    @if ($cabors->hasPages())
        <div class="d-flex align-items-center gap-3">
            <!-- Range Info -->
            <div class="text-muted">
                @php
                    $from = ($cabors->currentPage() - 1) * $cabors->perPage() + 1;
                    $to = min($from + $cabors->count() - 1, $cabors->total());
                @endphp
                {{ $from }}-{{ $to }} of {{ $cabors->total() }}
            </div>

            <!-- Previous Page Link -->
            @if ($cabors->onFirstPage())
                <span class="pagination-arrow disabled">
                    <i class="fas fa-chevron-left"></i>
                </span>
            @else
                <button type="button" class="pagination-arrow ajax-pagination" data-page="{{ $cabors->currentPage() - 1 }}" title="Previous Page">
                    <i class="fas fa-chevron-left"></i>
                </button>
            @endif

            <!-- Pagination Elements -->
            @php
                $start = max(1, $cabors->currentPage() - 2);
                $end = min($cabors->lastPage(), $cabors->currentPage() + 2);
            @endphp

            {{-- First page link if not in range --}}
            @if ($start > 1)
                <button type="button" class="pagination-number ajax-pagination" data-page="1" title="Page 1">1</button>
                @if ($start > 2)
                    <span class="pagination-dots">...</span>
                @endif
            @endif

            {{-- Page range --}}
            @for ($page = $start; $page <= $end; $page++)
                @if ($page == $cabors->currentPage())
                    <span class="pagination-number active">{{ $page }}</span>
                @else
                    <button type="button" class="pagination-number ajax-pagination" data-page="{{ $page }}" title="Page {{ $page }}">{{ $page }}</button>
                @endif
            @endfor

            {{-- Last page link if not in range --}}
            @if ($end < $cabors->lastPage())
                @if ($end < $cabors->lastPage() - 1)
                    <span class="pagination-dots">...</span>
                @endif
                <button type="button" class="pagination-number ajax-pagination" data-page="{{ $cabors->lastPage() }}" title="Page {{ $cabors->lastPage() }}">{{ $cabors->lastPage() }}</button>
            @endif

            <!-- Next Page Link -->
            @if ($cabors->hasMorePages())
                <button type="button" class="pagination-arrow ajax-pagination" data-page="{{ $cabors->currentPage() + 1 }}" title="Next Page">
                    <i class="fas fa-chevron-right"></i>
                </button>
            @else
                <span class="pagination-arrow disabled">
                    <i class="fas fa-chevron-right"></i>
                </span>
            @endif
        </div>
    @else
        <!-- Single page - no pagination needed -->
        <div class="d-flex align-items-center gap-2">
            <span class="text-muted">1-{{ $cabors->count() }} of {{ $cabors->total() }}</span>
            <span class="pagination-arrow disabled">
                <i class="fas fa-chevron-left"></i>
            </span>
            <span class="pagination-number active">1</span>
            <span class="pagination-arrow disabled">
                <i class="fas fa-chevron-right"></i>
            </span>
        </div>
    @endif
</div>

{{-- CSS Styling untuk Pagination --}}
<style>
.pagination-arrow, .pagination-number {
    border: 1px solid #dee2e6;
    background: white;
    color: #6c757d;
    padding: 8px 12px;
    border-radius: 4px;
    cursor: pointer;
    transition: all 0.2s;
    font-size: 14px;
    min-width: 40px;
    text-align: center;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.pagination-arrow:hover:not(.disabled), 
.pagination-number:hover:not(.active) {
    background-color: #e9ecef;
    border-color: #adb5bd;
    color: #495057;
}

.pagination-arrow.disabled {
    background-color: #f8f9fa;
    color: #ced4da;
    cursor: not-allowed;
    border-color: #e9ecef;
}

.pagination-number.active {
    background-color: #007bff;
    border-color: #007bff;
    color: white;
    font-weight: 600;
}

.pagination-dots {
    color: #6c757d;
    padding: 8px 4px;
    font-weight: bold;
}

.pagination-arrow.processing,
.pagination-number.processing {
    opacity: 0.6;
    pointer-events: none;
}
</style>