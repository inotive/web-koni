<?php if(isset($prestasi_list) && $prestasi_list->isNotEmpty()): ?>
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
                <?php $__currentLoopData = $prestasi_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $prestasi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
<?php /**PATH /home/thur/Documents/Inotive/web-koni/resources/views/admin/dashboard/partials/_prestasi-atlet-table.blade.php ENDPATH**/ ?>