<div class="row g-10">
    <?php $__empty_1 = true; $__currentLoopData = $children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <a href="<?php echo e(route('admin.laporan-lpj.bidang.dynamic.child.index', ['parentId' => $child->id])); ?>" class="col-12 col-sm-6 col-md-3">
            <div class="card gap-2 p-3 text-center shadow-sm" style="min-height: 160px; transition: background-color 0.3s;"
                onmouseover="this.style.backgroundColor='#E5E7EB'" onmouseout="this.style.backgroundColor='#ffffff'">
                <i class="ki-outline ki-folder text-gray-600" style="font-size: 80px"></i>
                <div class="text-center">
                    <h5 class="d-inline-block text-truncate w-100 mb-0" style="max-width: 200px;" title="<?php echo e($child->nama_program); ?>">
                        <?php echo e($child->nama_program); ?>

                    </h5>
                    <p><?php echo e($child->children_count); ?> Dokumen</p>
                </div>
            </div>
        </a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="col-12">
            <div class="text-center text-muted py-10">
                <i class="ki-duotone ki-information-5 fs-3x mb-3"></i>
                <h4>Tidak ada data.</h4>
            </div>
        </div>
    <?php endif; ?>
</div><?php /**PATH /home/thur/Documents/Inotive/web-koni/resources/views/admin/laporan-lpj/bidang/prestasi/Akurasi/_table.blade.php ENDPATH**/ ?>