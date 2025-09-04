<?php if(isset($pelatih) && $pelatih->isEmpty()): ?>
    <div class="empty-state">
        <i class="fas fa-search fs-3x mb-3 text-muted"></i>
        <?php if(request('search') || request()->hasAny(['filter_cabor', 'filter_gender', 'filter_age', 'filter_prestasi'])): ?>
            <h4>Tidak ada pelatih yang sesuai dengan kriteria pencarian.</h4>
            <p class="text-muted">Coba ubah kata kunci pencarian atau filter yang Anda gunakan.</p>
            
        <?php else: ?>
            <h4>Tidak ada data pelatih.</h4>
            <p class="text-muted">Belum ada pelatih yang terdaftar dalam sistem.</p>
        <?php endif; ?>
    </div>
<?php else: ?>
    <div class="table-responsive">
        <table class="table table-hover align-middle" id="pelatih-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Foto</th>
                    <th>
                        <a href="#" class="text-decoration-none text-dark sort-link"
                        data-sort="nama">
                            Nama Pelatih & Cabor
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
                        <a href="#" class="text-decoration-none text-dark sort-link"
                        data-sort="tanggal_lahir">
                            Tempat & Tanggal Lahir
                            <?php if(request('sort_by') == 'tanggal_lahir'): ?>
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
                        <a href="#" class="text-decoration-none text-dark sort-link"
                        data-sort="alamat">
                            Alamat
                            <?php if(request('sort_by') == 'alamat'): ?>
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
                        <a href="#" class="text-decoration-none text-dark sort-link"
                        data-sort="kelamin">
                            Kelamin
                            <?php if(request('sort_by') == 'kelamin'): ?>
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
                        <a href="#" class="text-decoration-none text-dark sort-link"
                        data-sort="tanggal_lahir">
                            Usia
                            <?php if(request('sort_by') == 'tanggal_lahir'): ?>
                                <?php if(request('order') == 'desc'): ?>
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
                        <a href="#" class="text-decoration-none text-dark sort-link"
                        data-sort="no_telepon">
                            Telepon
                            <?php if(request('sort_by') == 'no_telepon'): ?>
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
                        <a href="#" class="text-decoration-none text-dark sort-link"
                        data-sort="email">
                            Email
                            <?php if(request('sort_by') == 'email'): ?>
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
                        <a href="#" class="text-decoration-none text-dark sort-link"
                        data-sort="prestasi">
                            Prestasi Terbaru
                            <?php if(request('sort_by') == 'prestasi'): ?>
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
                        <a href="#" class="text-decoration-none text-dark sort-link"
                        data-sort="updated_at">
                            Terakhir Diupdate
                            <?php if(request('sort_by') == 'updated_at'): ?>
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
                <?php if(isset($pelatih)): ?>
                    <?php $__empty_1 = true; $__currentLoopData = $pelatih; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php
                            $age = $item->tanggal_lahir ? \Carbon\Carbon::parse($item->tanggal_lahir)->age : 0;
                            $hasPrestasi = isset($item->prestasis) && $item->prestasis->isNotEmpty() ? 'ada' : 'tidak';
                            $prestasiTerbaru = isset($item->prestasis) && $item->prestasis->isNotEmpty() ? $item->prestasis->first() : null;
                            $caborNama = $item->cabangOlahraga ? $item->cabangOlahraga->nama_cabor : '-';
                            $medaliType = $prestasiTerbaru ? strtolower($prestasiTerbaru->medali) : '';
                        ?>
                        <tr>
                            <td><?php echo e($pelatih->firstItem() + $loop->index); ?></td>

                            <td>
                                <?php if($item->foto): ?>
                                    <img src="<?php echo e(Storage::url($item->foto)); ?>" width="40" height="40" class="rounded-circle object-fit-cover">
                                <?php else: ?>
                                    <div class="rounded-circle bg-secondary text-white text-center fw-bold" style="width: 40px; height: 40px; line-height: 40px;">
                                        <?php echo e(strtoupper(substr($item->nama, 0, 1))); ?>

                                    </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    <strong class="text-truncate-custom">
                                        <?php if(request('search')): ?>
                                            <?php echo preg_replace('/(' . preg_quote(request('search'), '/') . ')/i', '<span class="search-highlight">$1</span>', $item->nama); ?>

                                        <?php else: ?>
                                            <?php echo e($item->nama); ?>

                                        <?php endif; ?>
                                    </strong>
                                    <small class="text-muted"><?php echo e($caborNama); ?></small>
                                </div>
                            </td>
                            <td>
                                <?php if($item->tanggal_lahir): ?>
                                    <div class="d-flex flex-column">
                                        <span class="text-truncate-custom"><strong><?php echo e(\Carbon\Carbon::parse($item->tanggal_lahir)->format('d M Y')); ?></strong></span>
                                        <?php if($item->tempat_lahir): ?>
                                            <small class="text-muted text-truncate-custom">
                                                <?php if(request('search')): ?>
                                                    <?php echo preg_replace('/(' . preg_quote(request('search'), '/') . ')/i', '<span class="search-highlight">$1</span>', $item->tempat_lahir); ?>

                                                <?php else: ?>
                                                    <?php echo e($item->tempat_lahir); ?>

                                                <?php endif; ?>
                                            </small>
                                        <?php endif; ?>
                                    </div>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($item->alamatkota && $item->alamatprovinsi): ?>
                                    <div class="d-flex flex-column">
                                        <strong class="text-dark text-truncate-custom">
                                            <?php if(request('search')): ?>
                                                <?php echo preg_replace('/(' . preg_quote(request('search'), '/') . ')/i', '<span class="search-highlight">$1</span>', $item->alamatkota . ', ' . $item->alamatprovinsi); ?>

                                            <?php else: ?>
                                                <?php echo e($item->alamatkota); ?>, <?php echo e($item->alamatprovinsi); ?>

                                            <?php endif; ?>
                                        </strong>
                                        <?php if($item->alamat): ?>
                                            <small class="text-muted text-truncate-custom" style="font-size: 11px; line-height: 1.2;">
                                                <?php if(request('search')): ?>
                                                    <?php echo preg_replace('/(' . preg_quote(request('search'), '/') . ')/i', '<span class="search-highlight">$1</span>', $item->alamat); ?>

                                                <?php else: ?>
                                                    <?php echo e($item->alamat); ?>

                                                <?php endif; ?>
                                            </small>
                                        <?php endif; ?>
                                    </div>
                                <?php elseif($item->alamat): ?>
                                    <div class="text-truncate-custom">
                                        <?php if(request('search')): ?>
                                            <?php echo preg_replace('/(' . preg_quote(request('search'), '/') . ')/i', '<span class="search-highlight">$1</span>', $item->alamat); ?>

                                        <?php else: ?>
                                            <?php echo e($item->alamat); ?>

                                        <?php endif; ?>
                                    </div>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo e($item->kelamin); ?></td>
                            <td><?php echo e($age); ?> Tahun</td>
                            <td>
                                <div class="text-truncate-custom">
                                    <?php if($item->no_telepon): ?>
                                        <?php if(request('search')): ?>
                                            <?php echo preg_replace('/(' . preg_quote(request('search'), '/') . ')/i', '<span class="search-highlight">$1</span>', $item->no_telepon); ?>

                                        <?php else: ?>
                                            <?php echo e($item->no_telepon); ?>

                                        <?php endif; ?>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td>
                                <div class="text-truncate-custom" title="<?php echo e($item->email); ?>">
                                    <?php if($item->email): ?>
                                        <?php if(request('search')): ?>
                                            <?php echo preg_replace('/(' . preg_quote(request('search'), '/') . ')/i', '<span class="search-highlight">$1</span>', $item->email); ?>

                                        <?php else: ?>
                                                <?php echo e($item->email); ?>

                                        <?php endif; ?>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td>
                                <?php if($prestasiTerbaru): ?>
                                    <div class="d-flex align-items-center">
                                        <div class="me-2">
                                            <?php if($medaliType === 'emas'): ?>
                                                <i class="fas fa-medal text-warning"></i>
                                            <?php elseif($medaliType === 'perak'): ?>
                                                <i class="fas fa-medal text-dark"></i>
                                            <?php elseif($medaliType === 'perunggu'): ?>
                                                <i class="fas fa-medal text-bronze"></i>
                                            <?php endif; ?>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <span class="text-truncate-custom">
                                                <?php if(request('search')): ?>
                                                    <?php echo preg_replace('/(' . preg_quote(request('search'), '/') . ')/i', '<span class="search-highlight">$1</span>', $prestasiTerbaru->nama_prestasi); ?>

                                                <?php else: ?>
                                                    <strong><?php echo e($prestasiTerbaru->nama_prestasi); ?></strong>
                                                <?php endif; ?>
                                            </span>
                                            <small class="text-muted"><?php echo e($prestasiTerbaru->tahun); ?><?php if($prestasiTerbaru->tempat): ?> • <?php echo e($prestasiTerbaru->tempat); ?><?php endif; ?></small>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php echo e(\Carbon\Carbon::parse($item->updated_at)->format('M d, Y')); ?>

                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="<?php echo e(route('admin.konfigurasi.pelatih.show', $item->id)); ?>"
                                    class="btn btn-icon btn-sm btn-light-primary"
                                    title="Detail">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="<?php echo e(route('admin.konfigurasi.pelatih.edit', $item->id)); ?>"
                                    class="btn btn-icon btn-sm btn-light-warning"
                                    title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <button type="button"
                                            class="btn btn-icon btn-sm btn-light-danger"
                                            data-route="<?php echo e(route('admin.konfigurasi.pelatih.destroy', $item->id)); ?>"
                                            <?php if($item->prestasis_count > 0 || $item->prestasis->isNotEmpty()): ?>
                                                onclick="showDeleteWarning(this, '<?php echo e($item->nama); ?>', <?php echo e($item->prestasis->pluck('nama_prestasi')); ?>)"
                                            <?php else: ?>
                                                onclick="destroyItem(this)"
                                            <?php endif; ?>
                                            title="Hapus">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="12" class="text-center py-5 text-muted">Data tidak ditemukan</td>
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

            <?php if(isset($pelatih) && method_exists($pelatih, 'hasPages') && $pelatih->hasPages()): ?>
                <div class="d-flex align-items-center gap-3">
                    <div class="text-muted small">
                        <?php echo e($pelatih->firstItem()); ?>-<?php echo e($pelatih->lastItem()); ?> of
                        <?php echo e($pelatih->total()); ?>

                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <?php if($pelatih->onFirstPage()): ?>
                            <span class="pagination-arrow disabled">←</span>
                        <?php else: ?>
                            <a href="<?php echo e($pelatih->appends(request()->query())->previousPageUrl()); ?>"
                               class="pagination-arrow pagination-link"
                               aria-label="Previous">←</a>
                        <?php endif; ?>

                        <?php
                            $current = $pelatih->currentPage();
                            $total = $pelatih->lastPage();
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
                                    <a href="<?php echo e($pelatih->appends(request()->query())->url($i)); ?>"
                                       class="pagination-number pagination-link"><?php echo e($i); ?></a>
                                <?php endif; ?>
                            <?php endfor; ?>
                        </div>

                        <?php if($pelatih->hasMorePages()): ?>
                            <a href="<?php echo e($pelatih->appends(request()->query())->nextPageUrl()); ?>"
                               class="pagination-arrow pagination-link"
                               aria-label="Next">→</a>
                        <?php else: ?>
                            <span class="pagination-arrow disabled">→</span>
                        <?php endif; ?>
                    </div>
                </div>
            <?php elseif(isset($pelatih) && method_exists($pelatih, 'hasPages')): ?>
                <div class="text-muted small">
                    1-<?php echo e($pelatih->count()); ?> of <?php echo e($pelatih->total()); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>

<div class="modal fade" id="pelatihDeleteWarningModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                    Tidak Dapat Menghapus Pelatih
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Pelatih <strong id="pelatihName"></strong> tidak dapat dihapus karena masih memiliki:</p>
                <ul id="prestasiList"></ul>
                <p class="text-muted">
                    Silakan hapus semua prestasi yang terkait dengan pelatih ini terlebih dahulu,
                    atau nonaktifkan data pelatih ini jika diperlukan.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /home/thur/Documents/Inotive/web-koni/resources/views/admin/pelatih/_table.blade.php ENDPATH**/ ?>