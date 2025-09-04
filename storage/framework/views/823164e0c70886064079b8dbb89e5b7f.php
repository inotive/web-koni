<!-- Form Pencarian -->
<div class="mb-6">
    <div class="d-flex justify-content-end gap-2">
        <div class="col-md-4">
            <div class="position-relative bg-light">
                <i class="ki-outline ki-magnifier fs-3 position-absolute top-50 translate-middle-y ms-3"></i>
                <input type="text" 
                       id="search-prestasi" 
                       name="search" 
                       value="<?php echo e(request('search')); ?>" 
                       placeholder="Cari Atlet atau Pelatih..." 
                       class="form-control border border-gray-500 px-10 py-2" />
            </div>
        </div>
    </div>
</div>

<div class="tab-content">
    <!-- Prestasi Atlet -->
    <div class="tab-pane fade show active" id="atlet-prestasi" role="tabpanel">
        <?php if(isset($latest_prestasi) && $latest_prestasi->isNotEmpty()): ?>
            <?php
                $atletPrestasi = $latest_prestasi->filter(function($prestasi) {
                    return $prestasi->subject_type === 'App\Models\Atlet';
                })->values(); // Reset keys for proper numbering
            ?>

            <?php if($atletPrestasi->isNotEmpty()): ?>
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
                            <?php $__currentLoopData = $atletPrestasi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $prestasi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="border-bottom border-gray-200">
                                    <td>
                                        <span class="text-gray-800 fw-bold fs-6"><?php echo e($index + 1); ?></span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="symbol symbol-40px me-4">
                                                <?php if(!empty($prestasi->subject->foto)): ?>
                                                    <?php
                                                        $fotoPath = '/storage/' . $prestasi->subject->foto;
                                                    ?>
                                                    <img src="<?php echo e($fotoPath); ?>" class="symbol-label rounded-circle" style="object-fit: cover; width: 40px; height: 40px;" alt="<?php echo e($prestasi->subject->nama ?? 'Atlet'); ?>">
                                                <?php else: ?>
                                                    <div class="symbol-label fs-2 fw-bold bg-light-primary text-primary rounded-circle">
                                                        <?php echo e(substr($prestasi->subject->nama ?? 'N/A', 0, 1)); ?>

                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <span class="text-gray-900 fw-bold fs-6"><?php echo e($prestasi->subject->nama ?? 'N/A'); ?></span>
                                                <span class="text-muted fs-7">
                                                    <?php echo e($prestasi->subject->cabangOlahraga->nama_cabor ?? 'N/A'); ?>

                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <?php
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
                                        ?>
                                        <div class="d-flex align-items-center mb-1">
                                            <i class="fas fa-medal me-2 <?php echo e($iconColor); ?>"></i>
                                            <span class="text-gray-800 fw-bold fs-6"><?php echo e($prestasi->nama_prestasi); ?></span>
                                        </div>
                                        <div class="text-gray-600 fw-semibold fs-7"><?php echo e($prestasi->kejuaraan); ?></div>
                                    </td>
                                    <td>
                                        <span class="text-gray-800 fw-bold fs-6"><?php echo e($prestasi->tempat); ?></span>
                                    </td>
                                    <td>
                                        <?php
                                            $usia = '-';
                                            if ($prestasi->subject && $prestasi->subject->tanggal_lahir) {
                                                $usia = \Carbon\Carbon::parse($prestasi->subject->tanggal_lahir)->age . ' thn';
                                            }
                                        ?>
                                        <span class="text-gray-800 fw-bold fs-6"><?php echo e($usia); ?></span>
                                    </td>
                                    <td>
                                        <span class="text-gray-800 fw-bold fs-6"><?php echo e($prestasi->tahun); ?></span>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
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
            <?php endif; ?>
        <?php else: ?>
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
        <?php endif; ?>
    </div>

    <!-- Prestasi Pelatih -->
    <div class="tab-pane fade" id="pelatih-prestasi" role="tabpanel">
        <?php if(isset($latest_prestasi) && $latest_prestasi->isNotEmpty()): ?>
            <?php
                $pelatihPrestasi = $latest_prestasi->filter(function($prestasi) {
                    return $prestasi->subject_type === 'App\Models\Pelatih';
                })->values(); // Reset keys for proper numbering
            ?>

            <?php if($pelatihPrestasi->isNotEmpty()): ?>
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
                            <?php $__currentLoopData = $pelatihPrestasi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $prestasi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="border-bottom border-gray-200">
                                    <td>
                                        <span class="text-gray-800 fw-bold fs-6"><?php echo e($index + 1); ?></span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="symbol symbol-40px me-4">
                                                <?php if(!empty($prestasi->subject->foto)): ?>
                                                    <?php
                                                        $fotoPath = '/storage/' . $prestasi->subject->foto;
                                                    ?>
                                                    <img src="<?php echo e($fotoPath); ?>" class="symbol-label rounded-circle" style="object-fit: cover; width: 40px; height: 40px;" alt="<?php echo e($prestasi->subject->nama ?? 'Pelatih'); ?>">
                                                <?php else: ?>
                                                    <div class="symbol-label fs-2 fw-bold bg-light-primary text-primary rounded-circle">
                                                        <?php echo e(substr($prestasi->subject->nama ?? 'N/A', 0, 1)); ?>

                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <span class="text-gray-900 fw-bold fs-6"><?php echo e($prestasi->subject->nama ?? 'N/A'); ?></span>
                                                <span class="text-muted fs-7">
                                                    <?php echo e($prestasi->subject->cabangOlahraga->nama_cabor ?? 'N/A'); ?>

                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <?php
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
                                        ?>
                                        <div class="d-flex align-items-center mb-1">
                                            <i class="fas fa-medal me-2 <?php echo e($iconColor); ?>"></i>
                                            <span class="text-gray-800 fw-bold fs-6"><?php echo e($prestasi->nama_prestasi); ?></span>
                                        </div>
                                        <div class="text-gray-600 fw-semibold fs-7"><?php echo e($prestasi->kejuaraan); ?></div>
                                    </td>
                                    <td>
                                        <span class="text-gray-800 fw-bold fs-6"><?php echo e($prestasi->tempat); ?></span>
                                    </td>
                                    <td>
                                        <?php
                                            $usia = '-';
                                            if ($prestasi->subject && $prestasi->subject->tanggal_lahir) {
                                                $usia = \Carbon\Carbon::parse($prestasi->subject->tanggal_lahir)->age . ' thn';
                                            }
                                        ?>
                                        <span class="text-gray-800 fw-bold fs-6"><?php echo e($usia); ?></span>
                                    </td>
                                    <td>
                                        <span class="text-gray-800 fw-bold fs-6"><?php echo e($prestasi->tahun); ?></span>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
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
            <?php endif; ?>
        <?php else: ?>
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
        <?php endif; ?>
    </div>
</div>

<!-- Pagination -->
<?php if(isset($latest_prestasi) && $latest_prestasi->hasPages()): ?>
<div class="table-footer">
    <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap">
        <div class="mb-2 mb-md-0">
            <div class="d-flex align-items-center">
                <span class="me-2">Show</span>
                <select name="per_page" class="form-select form-select-sm w-auto" id="per-page-select">
                    <?php $__currentLoopData = [10, 25, 50, 100]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $limit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($limit); ?>"
                            <?php echo e(request('per_page', 10) == $limit ? 'selected' : ''); ?>>
                            <?php echo e($limit); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <span class="ms-2">per page</span>
            </div>
        </div>

        <div class="d-flex align-items-center gap-2">
            <div class="text-muted small">
                Menampilkan <?php echo e($latest_prestasi->firstItem()); ?>-<?php echo e($latest_prestasi->lastItem()); ?> dari <?php echo e($latest_prestasi->total()); ?> hasil
            </div>

            <?php if($latest_prestasi->onFirstPage()): ?>
                <span class="pagination-arrow disabled">←</span>
            <?php else: ?>
                <a href="<?php echo e($latest_prestasi->appends(['per_page' => request('per_page', 10), 'search' => request('search')])->previousPageUrl()); ?>"
                   class="pagination-arrow prestasi-pagination-link"
                   aria-label="Previous">←</a>
            <?php endif; ?>

            <?php
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
            ?>

            <div class="d-flex align-items-center">
                <?php for($i = $start; $i <= $end; $i++): ?>
                    <?php if($i == $current): ?>
                        <span class="pagination-number active"><?php echo e($i); ?></span>
                    <?php else: ?>
                        <a href="<?php echo e($latest_prestasi->appends(['per_page' => request('per_page', 10), 'search' => request('search')])->url($i)); ?>"
                           class="pagination-number prestasi-pagination-link"><?php echo e($i); ?></a>
                    <?php endif; ?>
                <?php endfor; ?>
            </div>

            <?php if($latest_prestasi->hasMorePages()): ?>
                <a href="<?php echo e($latest_prestasi->appends(['per_page' => request('per_page', 10), 'search' => request('search')])->nextPageUrl()); ?>"
                   class="pagination-arrow prestasi-pagination-link"
                   aria-label="Next">→</a>
            <?php else: ?>
                <span class="pagination-arrow disabled">→</span>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php endif; ?>

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
        url: '<?php echo e(route("admin.dashboard.prestasi-pagination")); ?>',
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
</script><?php /**PATH C:\Users\ThinkPad\OneDrive\Dokumen\GitHub\web-koni\resources\views/admin/dashboard/partials/prestasi-table.blade.php ENDPATH**/ ?>