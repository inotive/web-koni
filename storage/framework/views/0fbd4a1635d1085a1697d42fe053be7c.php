
<div class="d-flex justify-content-between align-items-center flex-wrap">
    <!-- Per page selector & Info -->
    <div class="d-flex align-items-center gap-2 flex-wrap">
        <div class="d-flex align-items-center gap-2">
            <label class="form-label mb-0">Tampilkan:</label>
            <select class="form-select form-select-sm" style="width: auto;" name="per_page" id="ajax-per-page">
                <option value="10" <?php echo e(request('per_page', 10) == 10 ? 'selected' : ''); ?>>10</option>
                <option value="25" <?php echo e(request('per_page') == 25 ? 'selected' : ''); ?>>25</option>
                <option value="50" <?php echo e(request('per_page') == 50 ? 'selected' : ''); ?>>50</option>
                <option value="100" <?php echo e(request('per_page') == 100 ? 'selected' : ''); ?>>100</option>
            </select>
            <span class="text-muted">data per halaman</span>
        </div>

        <div class="text-muted">
            Menampilkan <?php echo e($cabors->count()); ?> dari <?php echo e($cabors->total()); ?> total data
            <?php if(request('search') || request('status')): ?>
                <br><small class="text-info">
                    (Hasil pencarian/filter:
                    <?php if(request('search')): ?>
                        "<?php echo e(request('search')); ?>"
                    <?php endif; ?>
                    <?php if(request('status')): ?>
                        Status: <?php echo e(request('status')); ?>

                    <?php endif; ?>
                    )
                </small>
            <?php endif; ?>
        </div>
    </div>

    <!-- Pagination Controls -->
    <?php if($cabors->hasPages()): ?>
        <div class="d-flex align-items-center gap-3">
            <!-- Range Info -->
            <div class="text-muted">
                <?php
                    $from = ($cabors->currentPage() - 1) * $cabors->perPage() + 1;
                    $to = min($from + $cabors->count() - 1, $cabors->total());
                ?>
                <?php echo e($from); ?>-<?php echo e($to); ?> of <?php echo e($cabors->total()); ?>

            </div>

            <!-- Previous Page Link -->
            <?php if($cabors->onFirstPage()): ?>
                <span class="pagination-arrow disabled">
                    <i class="fas fa-chevron-left"></i>
                </span>
            <?php else: ?>
                <button type="button" class="pagination-arrow ajax-pagination" data-page="<?php echo e($cabors->currentPage() - 1); ?>" title="Previous Page">
                    <i class="fas fa-chevron-left"></i>
                </button>
            <?php endif; ?>

            <!-- Pagination Elements -->
            <?php
                $start = max(1, $cabors->currentPage() - 2);
                $end = min($cabors->lastPage(), $cabors->currentPage() + 2);
            ?>

            
            <?php if($start > 1): ?>
                <button type="button" class="pagination-number ajax-pagination" data-page="1" title="Page 1">1</button>
                <?php if($start > 2): ?>
                    <span class="pagination-dots">...</span>
                <?php endif; ?>
            <?php endif; ?>

            
            <?php for($page = $start; $page <= $end; $page++): ?>
                <?php if($page == $cabors->currentPage()): ?>
                    <span class="pagination-number active"><?php echo e($page); ?></span>
                <?php else: ?>
                    <button type="button" class="pagination-number ajax-pagination" data-page="<?php echo e($page); ?>" title="Page <?php echo e($page); ?>"><?php echo e($page); ?></button>
                <?php endif; ?>
            <?php endfor; ?>

            
            <?php if($end < $cabors->lastPage()): ?>
                <?php if($end < $cabors->lastPage() - 1): ?>
                    <span class="pagination-dots">...</span>
                <?php endif; ?>
                <button type="button" class="pagination-number ajax-pagination" data-page="<?php echo e($cabors->lastPage()); ?>" title="Page <?php echo e($cabors->lastPage()); ?>"><?php echo e($cabors->lastPage()); ?></button>
            <?php endif; ?>

            <!-- Next Page Link -->
            <?php if($cabors->hasMorePages()): ?>
                <button type="button" class="pagination-arrow ajax-pagination" data-page="<?php echo e($cabors->currentPage() + 1); ?>" title="Next Page">
                    <i class="fas fa-chevron-right"></i>
                </button>
            <?php else: ?>
                <span class="pagination-arrow disabled">
                    <i class="fas fa-chevron-right"></i>
                </span>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <!-- Single page - no pagination needed -->
        <div class="d-flex align-items-center gap-2">
            <span class="text-muted">1-<?php echo e($cabors->count()); ?> of <?php echo e($cabors->total()); ?></span>
            <span class="pagination-arrow disabled">
                <i class="fas fa-chevron-left"></i>
            </span>
            <span class="pagination-number active">1</span>
            <span class="pagination-arrow disabled">
                <i class="fas fa-chevron-right"></i>
            </span>
        </div>
    <?php endif; ?>
</div>



<style>
.pagination-arrow,
.pagination-number,
.pagination-dots {
    margin: 0 -2px; /* Overlap border untuk tampilan rapat */
    font-size: 11px;
    padding: 2px 6px;
    min-width: 26px;
    height: 24px;
    line-height: 1;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: 1px solid #dee2e6;
    background: white;
    color: #6c757d;
    border-radius: 3px;
    cursor: pointer;
    transition: all 0.2s;
    text-decoration: none;
}

.pagination-arrow:hover:not(.disabled),
.pagination-number:hover:not(.active) {
    background-color: #e9ecef;
    border-color: #adb5bd;
    color: #495057;
}

.pagination-arrow.disabled,
.pagination-number.active {
    cursor: default;
}

.pagination-arrow.disabled {
    background-color: #f8f9fa;
    color: #ced4da;
    border-color: #e9ecef;
}

.pagination-number.active {
    background-color: #007bff;
    border-color: #007bff;
    color: white;
    font-weight: 600;
}

.pagination-dots {
    background: none;
    border: none;
    cursor: default;
    padding: 2px 2px;
}

.pagination-arrow.processing,
.pagination-number.processing {
    opacity: 0.6;
    pointer-events: none;
}
</style><?php /**PATH C:\Users\ThinkPad\OneDrive\Dokumen\GitHub\web-koni\resources\views/admin/cabang-olahraga/partials/pagination.blade.php ENDPATH**/ ?>