<div class="row g-10">
    <button type="button" data-bs-toggle="modal" data-bs-target="#add"
        class="focus-0 col-12 col-sm-6 col-md-3 border-0 bg-transparent"
        style="min-height: 160px; outline: none; box-shadow: none;">
        <div class="h-100 card justify-content-center gap-2 p-3 text-center shadow-sm"
            style="transition: background-color 0.3s;" onmouseover="this.style.backgroundColor='#E5E7EB'"
            onmouseout="this.style.backgroundColor='#ffffff'">
            <i class="ki-outline ki-add-folder text-success" style="font-size: 80px"></i>
            <h5>Tambah RKA</h5>
        </div>
    </button>
    <?php $__empty_1 = true; $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <a href="<?php echo e(route('admin.manajemen-rka.show', $item->id)); ?>" class="col-12 col-sm-6 col-md-3">
            <div class="card gap-2 p-3 text-center shadow-sm" style="transition: background-color 0.3s;"
                onmouseover="this.style.backgroundColor='#E5E7EB'" onmouseout="this.style.backgroundColor='#ffffff'">
                <div class="dropdown text-end">
                    <button class="btn btn-sm p-0" type="button" data-bs-toggle="dropdown">
                        <i class="ki-solid ki-dots-vertical text-danger fw-bold" style="font-size: 30px"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li class="dropdown-item edit" data-bs-toggle="modal" data-bs-target="#edit-<?php echo e($item->id); ?>"
                            onclick="event.preventDefault(); event.stopPropagation();">
                            Ganti Nama
                        </li>
                        <li class="dropdown-item delete"
                            onclick="event.preventDefault(); event.stopPropagation(); confirmDelete('<?php echo e(route('admin.manajemen-rka.destroy', $item->id)); ?>', '<?php echo e($item->name); ?>')">
                            Hapus
                        </li>
                    </ul>
                </div>
                <i class="ki-outline ki-folder text-gray-600" style="font-size: 80px"></i>
                <div class="text-center">
                    <h5 class="d-inline-block text-truncate w-100 mb-0" style="max-width: 200px;"
                        title="<?php echo e($item->name); ?>">
                        <?php echo e($item->name); ?>

                    </h5>
                    <p><?php echo e($item->laporans->count()); ?> Dokumen</p>
                </div>
            </div>
        </a>
        <div class="modal fade" id="edit-<?php echo e($item->id); ?>" tabindex="-1" aria-labelledby="edit-<?php echo e($item->id); ?>"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content rounded-4 gap-5 px-10 py-8">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="fs-2 fw-bold leading-5">Edit Folder <?php echo e($item->name); ?></div>

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form id="form-<?php echo e($item->id); ?>" action="<?php echo e(route('admin.manajemen-rka.update', $item->id)); ?>"
                        method="POST" class="d-grid gap-2">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <div class="fs-4 fw-bold">Tahun RKA</div>
                        <input id="judul" name="judul" type="number" value="<?php echo e($item->name); ?>"
                            class="form-control border border-gray-600" placeholder="Masukkan tahun RKA" />
                    </form>

                    <div class="d-grid py-4">
                        <button type="button" onclick="submitForm('form-<?php echo e($item->id); ?>')"
                            class="bg-danger fw-bold d-flex align-items-center justify-content-center gap-2 rounded border-0 p-4 text-white">
                            Edit Nama Folder
                        </button>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="d-grid justify-content-center">
            <img src="<?php echo e(asset('assets/img/question.png')); ?>" alt="Belum ada RKA" style="height: 230px; width: 200px;">
            <div class="d-grid fw-bold fs-3 text-danger text-center">
                Belum ada RKA ?
                <span class="text-success" style="cursor: pointer;" onmouseover="this.style.textDecoration='underline'"
                    onmouseout="this.style.textDecoration='none'" data-bs-toggle="modal" data-bs-target="#add">
                    Tambah RKA sekarang.
                </span>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php /**PATH D:\Inotive\KONI\web-koni\resources\views/admin/manajemen-rka/components/table-grid.blade.php ENDPATH**/ ?>