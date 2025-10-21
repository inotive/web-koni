<div style="display: none;" data-filter-counts="<?php echo e(json_encode($fileCounts ?? [])); ?>"></div>

<?php if(isset($laporanBendahara) && $laporanBendahara->isEmpty()): ?>
    <div class="empty-state">
        <i class="fas fa-search fs-3x mb-3 text-muted"></i>
        <?php if(request('search') || request('filter_type')): ?>
            <h4>Tidak ada laporan yang sesuai dengan filter/pencarian.</h4>
            <p class="text-muted">Coba ubah kata kunci pencarian atau filter yang Anda gunakan.</p>
        <?php else: ?>
            <h4>Tidak ada data laporan bendahara.</h4>
            <p class="text-muted">Belum ada laporan bendahara yang tersimpan dalam sistem.</p>
        <?php endif; ?>
    </div>
<?php else: ?>
    <div class="table-responsive">
        <table class="table table-hover align-middle" id="bendahara-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>
                        <a href="#" class="text-decoration-none text-dark sort-link"
                        data-sort="judul">
                            Judul Laporan
                            <?php if(request('sort_by') == 'judul'): ?>
                                <?php if(request('order') == 'asc'): ?>
                                    <i class="fas fa-sort-up"></i>
                                <?php else: ?>
                                    <i class="fas fa-sort-down"></i>
                                <?php endif; ?>
                            <?php else: ?>
                                <i class="fas fa-sort text-muted"></i>
                            <?php endif; ?>
                        </a>
                    </th>
                    <th>File Laporan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if(isset($laporanBendahara)): ?>
                    <?php $__empty_1 = true; $__currentLoopData = $laporanBendahara; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php
                            $extension = $item->dokumen ? strtolower(pathinfo($item->dokumen, PATHINFO_EXTENSION)) : '';
                        ?>
                        <tr data-extension="<?php echo e($extension); ?>" data-dokumen="<?php echo e($item->dokumen); ?>">
                            <td><?php echo e($laporanBendahara->firstItem() + $loop->index); ?></td>

                            <td>
                                <div class="d-flex flex-column">
                                    <strong class="text-dark">
                                        <?php if(request('search')): ?>
                                            <?php echo preg_replace('/(' . preg_quote(request('search'), '/') . ')/i', '<span class="search-highlight">$1</span>', $item->judul); ?>

                                        <?php else: ?>
                                            <?php echo e($item->judul); ?>

                                        <?php endif; ?>
                                    </strong>
                                    <small class="text-muted"><?php echo e(\Carbon\Carbon::parse($item->created_at)->format('d M Y')); ?></small>
                                </div>
                            </td>

                            <td>
                                <?php if($item->dokumen): ?>
                                    <div class="d-flex align-items-center">
                                        
                                        <?php if($extension == 'pdf'): ?>
                                            <i class="fas fa-file-pdf file-icon" style="color: #dc3545; font-size: 16px; margin-right: 8px;"></i>
                                        <?php elseif(in_array($extension, ['doc', 'docx'])): ?>
                                            <i class="fas fa-file-word file-icon" style="color: #0d6efd; font-size: 16px; margin-right: 8px;"></i>
                                        <?php elseif(in_array($extension, ['xls', 'xlsx'])): ?>
                                            <i class="fas fa-file-excel file-icon" style="color: #198754; font-size: 16px; margin-right: 8px;"></i>
                                        <?php elseif(in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg'])): ?>
                                            <i class="fas fa-file-image file-icon" style="color: #fd7e14; font-size: 16px; margin-right: 8px;"></i>
                                        <?php else: ?>
                                            <i class="fas fa-file file-icon" style="color: #6c757d; font-size: 16px; margin-right: 8px;"></i>
                                        <?php endif; ?>

                                        <div>
                                            <div class="fw-semibold file-name" style="color: #dc3545 !important;">
                                                <?php echo e(strtoupper($extension)); ?> File
                                            </div>
                                            <?php if(file_exists(storage_path('app/public/' . $item->dokumen))): ?>
                                                <?php
                                                    $fileSize = filesize(storage_path('app/public/' . $item->dokumen));
                                                    $units = ['B', 'KB', 'MB', 'GB'];
                                                    $factor = floor((strlen($fileSize) - 1) / 3);
                                                    $size = sprintf("%.2f", $fileSize / pow(1024, $factor)) . ' ' . $units[$factor];
                                                ?>
                                                <small class="text-muted file-size" style="color: #dc3545 !important;"><?php echo e($size); ?></small>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-file file-icon" style="color: #6c757d; font-size: 16px; margin-right: 8px;"></i>
                                        <span class="text-muted">Tidak ada file</span>
                                    </div>
                                <?php endif; ?>
                            </td>

                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    
                                    <a href="<?php echo e(route('admin.bendahara.show', $item->id)); ?>"
                                    class="btn btn-icon btn-sm btn-preview"
                                    style="background-color: #87CEEB !important; border-color: #87CEEB !important; color: #2c5aa0 !important;"
                                    title="Detail">
                                        <i class="fa-solid fa-eye" style="color: #2c5aa0 !important;"></i>
                                    </a>

                                    
                                    <a href="#"
                                        class="btn btn-icon btn-sm btn-edit"
                                        data-bs-toggle="modal"
                                        data-bs-target="#addLaporanModal"
                                        data-id="<?php echo e($item->id); ?>"
                                        data-judul="<?php echo e($item->judul); ?>"
                                        data-dokumen="<?php echo e($item->dokumen); ?>"
                                        title="Edit">
                                        <i class="fa-solid fa-pen-to-square" style="color: white !important;"></i>
                                    </a>
                                    
                                    <button type="button"
                                            class="btn btn-icon btn-sm btn-delete"
                                            style="background-color: #dc3545 !important; border-color: #dc3545 !important; color: white !important;"
                                            data-route="<?php echo e(route('admin.bendahara.destroy', $item->id)); ?>"
                                            onclick="destroyItem(this)"
                                            title="Hapus">
                                        <i class="fa-solid fa-trash" style="color: white !important;"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">Data tidak ditemukan</td>
                        </tr>
                    <?php endif; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="table-footer">
        <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap">
            <div class="mb-2 mb-md-0">
                <div class="d-flex align-items-center">
                    <span class="me-2">Show</span>
                    <select name="per_page" class="form-select form-select-sm w-auto">
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

            <?php if(isset($laporanBendahara) && method_exists($laporanBendahara, 'hasPages') && $laporanBendahara->hasPages()): ?>
                <div class="d-flex align-items-center gap-3">
                    <div class="text-muted small">
                        <?php echo e($laporanBendahara->firstItem()); ?>-<?php echo e($laporanBendahara->lastItem()); ?> of
                        <?php echo e($laporanBendahara->total()); ?>

                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <?php if($laporanBendahara->onFirstPage()): ?>
                            <span class="pagination-arrow disabled">←</span>
                        <?php else: ?>
                            <a href="<?php echo e($laporanBendahara->appends(request()->query())->previousPageUrl()); ?>"
                               class="pagination-arrow pagination-link"
                               aria-label="Previous">←</a>
                        <?php endif; ?>

                        <?php
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
                        ?>

                        <div class="d-flex align-items-center">
                            <?php for($i = $start; $i <= $end; $i++): ?>
                                <?php if($i == $current): ?>
                                    <span class="pagination-number active"><?php echo e($i); ?></span>
                                <?php else: ?>
                                    <a href="<?php echo e($laporanBendahara->appends(request()->query())->url($i)); ?>"
                                       class="pagination-number pagination-link"><?php echo e($i); ?></a>
                                <?php endif; ?>
                            <?php endfor; ?>
                        </div>

                        <?php if($laporanBendahara->hasMorePages()): ?>
                            <a href="<?php echo e($laporanBendahara->appends(request()->query())->nextPageUrl()); ?>"
                               class="pagination-arrow pagination-link"
                               aria-label="Next">→</a>
                        <?php else: ?>
                            <span class="pagination-arrow disabled">→</span>
                        <?php endif; ?>
                    </div>
                </div>
            <?php elseif(isset($laporanBendahara) && method_exists($laporanBendahara, 'hasPages')): ?>
                <div class="text-muted small">
                    1-<?php echo e($laporanBendahara->count()); ?> of <?php echo e($laporanBendahara->total()); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>
<?php /**PATH /home/thur/Documents/Inotive/web-koni/resources/views/admin/bendahara/OLD/_tableOLD.blade.php ENDPATH**/ ?>