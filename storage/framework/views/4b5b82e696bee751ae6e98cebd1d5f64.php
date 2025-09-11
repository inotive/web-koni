<table class="table table-hover align-middle" id="caborTable">
    <thead>
        <tr>
            <th class="text-center">No</th>
            <th>
                <button type="button"
                    class="btn btn-link text-dark text-decoration-none p-0 ajax-sort sortable-header w-100 d-flex justify-content-between align-items-center"
                    data-sort="nama_cabor" title="Sort by Nama Cabor" style="border: none; background: none;">
                    <span class="flex-grow-1 text-start">Nama Cabor</span>
                    <?php echo sortIcon('nama_cabor'); ?>

                </button>
            </th>
            <th>
                <button type="button"
                    class="btn btn-link text-dark text-decoration-none p-0 ajax-sort sortable-header w-100 d-flex justify-content-between align-items-center"
                    data-sort="ketua_penanggung_jawab" title="Sort by Ketua Penanggung Jawab"
                    style="border: none !important; background: none !important;">
                    <span class="flex-grow-1 text-start">Ketua Penanggung Jawab</span>
                    <?php echo sortIcon('ketua_penanggung_jawab'); ?>

                </button>
            </th>
            <th class="text-center">
                <button type="button"
                    class="btn btn-link text-dark text-decoration-none p-0 ajax-sort sortable-header w-100 d-flex justify-content-center align-items-center"
                    data-sort="status" title="Sort by Status"
                    style="border: none !important; background: none !important;">
                    <span class="me-2">Status</span>
                    <?php echo sortIcon('status'); ?>

                </button>
            </th>
            <th>
                <button type="button"
                    class="btn btn-link text-dark text-decoration-none p-0 ajax-sort sortable-header w-100 d-flex justify-content-between align-items-center"
                    data-sort="tanggal_pembentukan" title="Sort by Tanggal Pembentukan"
                    style="border: none !important; background: none !important;">
                    <span class="flex-grow-1 text-start">Tanggal Pembentukan</span>
                    <?php echo sortIcon('tanggal_pembentukan'); ?>

                </button>
            </th>
            <th class="text-center">Jumlah Atlet</th>
            <th class="text-center">Jumlah Pelatih</th>
            <th>
                <button type="button"
                    class="btn btn-link text-dark text-decoration-none p-0 ajax-sort sortable-header w-100 d-flex justify-content-between align-items-center"
                    data-sort="terakhir_update" title="Sort by Terakhir Update"
                    style="border: none !important; background: none !important;">
                    <span class="flex-grow-1 text-start">Terakhir Update</span>
                    <?php echo sortIcon('terakhir_update'); ?>

                </button>
            </th>
            <th class="text-center">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php if(isset($cabors)): ?>
            <?php $__empty_1 = true; $__currentLoopData = $cabors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $cabor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr data-status="<?php echo e($cabor->status); ?>">
                    <td class="text-center"><?php echo e($loop->iteration + ($cabors->currentPage() - 1) * $cabors->perPage()); ?></td>
                    <td>
                        <div class="d-flex align-items-center">
                            <?php if($cabor->icon_cabor): ?>
                                <img src="<?php echo e(asset('storage/' . $cabor->icon_cabor)); ?>" width="40" height="40"
                                    class="rounded object-fit-cover me-3">
                            <?php else: ?>
                                <div class="rounded bg-secondary text-white text-center fw-bold d-flex align-items-center justify-content-center me-3"
                                    style="width: 40px; height: 40px;">
                                    <?php echo e(strtoupper(substr($cabor->nama_cabor, 0, 1))); ?>

                                </div>
                            <?php endif; ?>
                            <div class="d-flex flex-column">
                                <strong class="text-truncate-custom"><?php echo e($cabor->nama_cabor); ?></strong>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="text-truncate-custom" title="<?php echo e($cabor->ketua_penanggung_jawab); ?>">
                            <?php echo e($cabor->ketua_penanggung_jawab); ?>

                        </div>
                    </td>
                    <td class="text-center">
                        <span
                            class="badge <?php echo e($cabor->status == 'Aktif' ? 'badge-light-success' : 'badge-light-danger'); ?>">
                            <?php echo e($cabor->status); ?>

                        </span>
                    </td>
                    <td>
                        <?php echo e(\Carbon\Carbon::parse($cabor->tanggal_pembentukan)->format('d M Y')); ?>

                    </td>
                    <td class="text-center">
                        <?php echo e($cabor->atlets ? $cabor->atlets->count() : 0); ?>

                    </td>
                    <td class="text-center">
                        <?php echo e($cabor->pelatihs ? $cabor->pelatihs->count() : 0); ?>

                    </td>
                    <td>
                        <?php echo e($cabor->terakhir_update ? \Carbon\Carbon::parse($cabor->terakhir_update)->format('M d, Y') : '-'); ?>

                    </td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center gap-1">
                            <a href="<?php echo e(route('admin.konfigurasi.cabang-olahraga.show', $cabor->id)); ?>"
                                class="btn btn-icon btn-sm btn-light-primary" title="Detail">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <a href="<?php echo e(route('admin.konfigurasi.cabang-olahraga.edit', $cabor->id)); ?>"
                                class="btn btn-icon btn-sm btn-light-warning" title="Edit">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>

                            <?php
                                $jumlahAtlet = $cabor->atlets ? $cabor->atlets->count() : 0;
                                $jumlahPelatih = $cabor->pelatihs ? $cabor->pelatihs->count() : 0;
                                $totalData = $jumlahAtlet + $jumlahPelatih;
                            ?>

                            <?php if($totalData > 0): ?>
                                <button type="button" class="btn btn-icon btn-sm btn-light-danger"
                                    title="Tidak dapat dihapus - Ada <?php echo e($totalData); ?> data terkait"
                                    onclick="showDeleteWarning(this, '<?php echo e($cabor->nama_cabor); ?>', <?php echo e($jumlahAtlet); ?>, <?php echo e($jumlahPelatih); ?>)"
                                    style="opacity: 0.6;">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            <?php else: ?>
                                <button type="button" 
                                    class="btn btn-icon btn-sm btn-light-danger" 
                                    title="Hapus <?php echo e($cabor->nama_cabor); ?>"
                                    data-route="<?php echo e(route('admin.konfigurasi.cabang-olahraga.destroy', $cabor->id)); ?>"
                                    onclick="destroyItem(this)">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="9" class="text-center py-5 text-muted">
                        <?php if(request('search') || request('status')): ?>
                            <i class="fas fa-search fs-3x mb-3 text-muted"></i>
                            <h4>Tidak ada data yang cocok dengan pencarian</h4>
                            <p class="mb-0">Coba ubah kata kunci atau filter yang digunakan</p>
                        <?php else: ?>
                            Tidak ada data cabang olahraga
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endif; ?>
        <?php endif; ?>
    </tbody>
</table>


<style>
    .sortable-header {
        font-weight: 600 !important;
        width: 100% !important;
        border: none !important;
        background: none !important;
        box-shadow: none !important;
        outline: none !important;
        padding: 0 !important;
        margin: 0 !important;
        color: inherit !important;
    }

    .sortable-header:hover {
        color: #007bff !important;
        text-decoration: none !important;
        background: none !important;
    }

    .sortable-header:focus {
        box-shadow: none !important;
        outline: none !important;
        background: none !important;
    }

    .sortable-header:active {
        background: none !important;
        box-shadow: none !important;
    }

    .sortable-header.processing {
        opacity: 0.6;
        pointer-events: none;
    }

    /* Prevent Bootstrap button styles from interfering */
    .sortable-header.btn-link {
        color: inherit !important;
        text-decoration: none !important;
    }

    .sortable-header.btn-link:hover {
        color: #007bff !important;
        text-decoration: none !important;
    }

    /* Loading state untuk table */
    .table-responsive {
        position: relative;
    }

    .loading-overlay {
        position: absolute !important;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.9);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        border-radius: 8px;
        backdrop-filter: blur(2px);
    }

    /* Ensure table headers are properly clickable */
    .sortable-header * {
        pointer-events: none;
    }

    .sortable-header {
        pointer-events: all;
    }

    /* Consistent header styling */
    .table thead th {
        font-weight: 600;
        border-bottom: 2px solid #e9ecef;
        vertical-align: middle;
        padding: 12px 8px;
    }

    /* Icon positioning */
    .sortable-header i {
        flex-shrink: 0;
        margin-left: 8px;
    }

    /* Center aligned headers */
    .sortable-header.text-center {
        justify-content: center !important;
    }

    .sortable-header.text-center span {
        margin-right: 8px;
        margin-left: 0;
    }
</style><?php /**PATH /Users/gustibagus/Documents/GitHub/web-koni/resources/views/admin/cabang-olahraga/partials/table.blade.php ENDPATH**/ ?>