<?php if(isset($prestasis) && $prestasis->isEmpty()): ?>
    <div class="empty-state">
        <i class="fas fa-trophy fs-3x mb-3 text-muted"></i>
        <?php if(request('search') || request()->hasAny(['tahun', 'medali', 'tingkat'])): ?>
            <h4>Tidak ada prestasi yang sesuai dengan kriteria pencarian.</h4>
            <p class="text-muted">Coba ubah kata kunci pencarian atau filter yang Anda gunakan.</p>
        <?php else: ?>
            <h4>Belum ada data prestasi.</h4>
            <p class="text-muted">Belum ada prestasi yang terdaftar dalam sistem.</p>
        <?php endif; ?>
    </div>
<?php else: ?>
    <div class="table-responsive">
        <table class="table table-hover align-middle" id="prestasi-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>
                        <a href="<?php echo e(request()->fullUrlWithQuery(['sort_by' => 'nama', 'order' => request('sort_by') == 'nama' && request('order') == 'asc' ? 'desc' : 'asc'])); ?>"
                            class="text-decoration-none text-dark sort-link">
                            Nama & Role
                            <?php if(request('sort_by') == 'nama'): ?>
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
                    <th>
                        <a href="<?php echo e(request()->fullUrlWithQuery(['sort_by' => 'jenis_kelamin', 'order' => request('sort_by') == 'jenis_kelamin' && request('order') == 'asc' ? 'desc' : 'asc'])); ?>"
                            class="text-decoration-none text-dark sort-link">
                            Jenis Kelamin
                            <?php if(request('sort_by') == 'jenis_kelamin'): ?>
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
                    <th>
                        <a href="<?php echo e(request()->fullUrlWithQuery(['sort_by' => 'nama_prestasi', 'order' => request('sort_by') == 'nama_prestasi' && request('order') == 'asc' ? 'desc' : 'asc'])); ?>"
                            class="text-decoration-none text-dark sort-link">
                            Prestasi & Kejuaraan
                            <?php if(request('sort_by') == 'nama_prestasi'): ?>
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
                    <th>
                        <a href="<?php echo e(request()->fullUrlWithQuery(['sort_by' => 'cabor', 'order' => request('sort_by') == 'cabor' && request('order') == 'asc' ? 'desc' : 'asc'])); ?>"
                            class="text-decoration-none text-dark sort-link">
                            Cabor
                            <?php if(request('sort_by') == 'cabor'): ?>
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
                    <th>
                        <a href="<?php echo e(request()->fullUrlWithQuery(['sort_by' => 'tingkat', 'order' => request('sort_by') == 'tingkat' && request('order') == 'asc' ? 'desc' : 'asc'])); ?>"
                            class="text-decoration-none text-dark sort-link">
                            Tingkat
                            <?php if(request('sort_by') == 'tingkat'): ?>
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
                    <th>
                        <a href="<?php echo e(request()->fullUrlWithQuery(['sort_by' => 'tahun', 'order' => request('sort_by') == 'tahun' && request('order') == 'asc' ? 'desc' : 'asc'])); ?>"
                            class="text-decoration-none text-dark sort-link">
                            Tempat & Tahun
                            <?php if(request('sort_by') == 'tahun'): ?>
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
                    <th>
                        <a href="<?php echo e(request()->fullUrlWithQuery(['sort_by' => 'medali', 'order' => request('sort_by') == 'medali' && request('order') == 'asc' ? 'desc' : 'asc'])); ?>"
                            class="text-decoration-none text-dark sort-link">
                            Medali
                            <?php if(request('sort_by') == 'medali'): ?>
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
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if(isset($prestasis)): ?>
                    <?php $__empty_1 = true; $__currentLoopData = $prestasis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $prestasi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php
                            $caborNama = $prestasi->subject->cabangOlahraga
                                ? $prestasi->subject->cabangOlahraga->nama_cabor
                                : '-';

                            $jenisKelamin = '';
                            $gender = $prestasi->subject->jenis_kelamin;
                            if ($gender === 'Laki-laki' || $gender === 'L') {
                                $jenisKelamin = 'Laki-laki';
                            } elseif ($gender === 'Perempuan' || $gender === 'P') {
                                $jenisKelamin = 'Perempuan';
                            } else {
                                $jenisKelamin = $gender ?? '-';
                            }

                            $rowNumber = ($prestasis->currentPage() - 1) * $prestasis->perPage() + $loop->iteration;

                            $detailRoute = route('admin.konfigurasi.atlet.show', [
                                'atlet' => $prestasi->subject->id,
                                'back' => 'prestasi',
                            ]);
                        ?>

                        <tr data-tahun="<?php echo e($prestasi->tahun); ?>" data-nama="<?php echo e($prestasi->subject?->nama ?? '-'); ?>">
                            <td><?php echo e($rowNumber); ?></td>

                            <td>
                                <div class="d-flex flex-column">
                                    <strong class="text-truncate-custom"
                                        title="<?php echo e($prestasi->subject->nama); ?>">
                                        <?php echo e($prestasi->subject->nama); ?>

                                    </strong>
                                    <small class="text-muted">
                                        Atlet
                                    </small>
                                </div>
                            </td>

                            <td><?php echo e($jenisKelamin); ?></td>

                            <td>
                                <div class="d-flex flex-column">
                                    <strong class="text-truncate-custom">
                                        <?php echo e($prestasi->nama_prestasi); ?>

                                    </strong>
                                    <small class="text-muted text-truncate-custom">
                                        <?php echo e($prestasi->kejuaraan); ?>

                                    </small>
                                </div>
                            </td>

                            <td>
                                <div class="text-truncate-custom">
                                    <?php echo e($prestasi->cabangOlahraga?->nama_cabor ?? $prestasi->subject?->cabangOlahraga?->nama_cabor ?? '-'); ?>

                                </div>
                            </td>

                            <td><?php echo e($prestasi->tingkat); ?></td>

                            <td>
                                <div class="d-flex flex-column">
                                    <strong class="text-truncate-custom">
                                        <?php echo e($prestasi->tempat); ?>

                                    </strong>
                                    <small class="text-muted"><?php echo e($prestasi->tahun); ?></small>
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
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-medal me-2 <?php echo e($iconColor); ?>"></i>
                                    <span><?php echo e($prestasi->medali); ?></span>
                                </div>
                            </td>

                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="<?php echo e($detailRoute); ?>" class="btn btn-icon btn-sm btn-light-primary"
                                        title="Lihat Detail Atlet"
                                        data-bs-toggle="tooltip">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="<?php echo e(route('admin.konfigurasi.prestasi.edit', $prestasi->id)); ?>"
                                        class="btn btn-icon btn-sm btn-light-warning" title="Edit"
                                        data-bs-toggle="tooltip">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <button class="btn btn-icon btn-sm btn-light-danger btn-delete" title="Hapus"
                                        data-bs-toggle="tooltip"
                                        data-route="<?php echo e(route('admin.konfigurasi.prestasi.destroy', $prestasi->id)); ?>">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="10" class="text-center py-5 text-muted">Data tidak ditemukan</td>
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

            <?php if(isset($prestasis) && method_exists($prestasis, 'hasPages') && $prestasis->hasPages()): ?>
                <div class="d-flex align-items-center gap-3">
                    <div class="text-muted small">
                        <?php echo e($prestasis->firstItem()); ?>-<?php echo e($prestasis->lastItem()); ?> of
                        <?php echo e($prestasis->total()); ?>

                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <?php if($prestasis->onFirstPage()): ?>
                            <span class="pagination-arrow disabled">←</span>
                        <?php else: ?>
                            <a href="<?php echo e($prestasis->appends(request()->query())->previousPageUrl()); ?>"
                                class="pagination-arrow pagination-link" aria-label="Previous">←</a>
                        <?php endif; ?>

                        <?php
                            $current = $prestasis->currentPage();
                            $total = $prestasis->lastPage();
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
                                    <a href="<?php echo e($prestasis->appends(request()->query())->url($i)); ?>"
                                        class="pagination-number pagination-link"><?php echo e($i); ?></a>
                                <?php endif; ?>
                            <?php endfor; ?>
                        </div>

                        <?php if($prestasis->hasMorePages()): ?>
                            <a href="<?php echo e($prestasis->appends(request()->query())->nextPageUrl()); ?>"
                                class="pagination-arrow pagination-link" aria-label="Next">→</a>
                        <?php else: ?>
                            <span class="pagination-arrow disabled">→</span>
                        <?php endif; ?>
                    </div>
                </div>
            <?php elseif(isset($prestasis) && method_exists($prestasis, 'hasPages')): ?>
                <div class="text-muted small">
                    1-<?php echo e($prestasis->count()); ?> of <?php echo e($prestasis->total()); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>
<?php /**PATH /home/thur/Documents/Inotive/web-koni/resources/views/admin/prestasi/_table.blade.php ENDPATH**/ ?>