<?php $__env->startSection('pageTitle', 'Detail Kegiatan Lainnya'); ?>
<?php $__env->startSection('mainSection', 'Laporan Pertanggungjawaban'); ?>
<?php $__env->startSection('currentSection', 'Detail Kegiatan Lainnya'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="d-flex flex-column mb-8">
        <h1 class="text-dark fw-bold mb-1">Detail Kegiatan Lainnya</h1>
        <div class="text-muted fw-semibold fs-6">Informasi lengkap tentang kegiatan lainnya</div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title fw-bold fs-4 mb-0">Informasi Kegiatan Lainnya</h3>
                    <div class="card-toolbar">
                        <a href="<?php echo e(route('admin.laporan-lpj.kegiatan-lainnya.index')); ?>" class="btn btn-light-primary">
                            <i class="ki-duotone ki-arrow-left fs-2"></i>
                            Kembali
                        </a>
                        <a href="<?php echo e(route('admin.laporan-lpj.kegiatan-lainnya.export', $kegiatanLainnya->id)); ?>" 
                           class="btn btn-success ms-2" target="_blank">
                            <i class="fas fa-file-pdf me-1"></i>
                            Export PDF
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-5">
                                <label class="fw-semibold text-dark mb-2">Nama Program:</label>
                                <p class="mb-0 text-dark fs-5"><?php echo e($kegiatanLainnya->nama_program); ?></p>
                            </div>
                            
                            <div class="mb-5">
                                <label class="fw-semibold text-dark mb-2">Nama Kegiatan:</label>
                                <p class="mb-0 text-dark fs-5"><?php echo e($kegiatanLainnya->nama_kegiatan); ?></p>
                            </div>
                            
                            <div class="mb-5">
                                <label class="fw-semibold text-dark mb-2">Volume:</label>
                                <p class="mb-0 text-dark fs-5"><?php echo e($kegiatanLainnya->volume ?? '-'); ?></p>
                            </div>
                            
                            <div class="mb-5">
                                <label class="fw-semibold text-dark mb-2">Harga Satuan:</label>
                                <p class="mb-0 text-dark fs-5">
                                    Rp <?php echo e(number_format($kegiatanLainnya->jumlah_harga_satuan ?? 0, 0, ',', '.')); ?>

                                </p>
                            </div>
                            
                            <div class="mb-5">
                                <label class="fw-semibold text-dark mb-2">Total Anggaran:</label>
                                <p class="mb-0 text-dark fs-5 text-success fw-bold">
                                    Rp <?php echo e(number_format($kegiatanLainnya->jumlah_harga ?? 0, 0, ',', '.')); ?>

                                </p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <?php if($kegiatanLainnya->keterangan_tambahan): ?>
                            <div class="mb-5">
                                <label class="fw-semibold text-dark mb-2">Keterangan Tambahan:</label>
                                <div class="bg-light p-4 rounded">
                                    <p class="mb-0 text-dark" style="white-space: pre-wrap;"><?php echo e($kegiatanLainnya->keterangan_tambahan); ?></p>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <?php if($kegiatanLainnya->foto_jurnal && count($kegiatanLainnya->foto_jurnal) > 0): ?>
                    <div class="mb-8">
                        <h4 class="fw-bold text-primary mb-5 d-flex align-items-center">
                            <i class="fas fa-camera me-2"></i>
                            Dokumentasi Kegiatan Lainnya
                        </h4>
                        <div class="row g-5">
                            <?php $__currentLoopData = $kegiatanLainnya->foto_jurnal; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $foto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $path = is_array($foto) ? ($foto['path'] ?? '') : $foto;
                                    $originalName = is_array($foto) ? 
                                                   ($foto['original_name'] ?? basename($path)) : 
                                                   basename($path);
                                ?>
                                
                                <?php if($path): ?>
                                <div class="col-md-4">
                                    <div class="card border-0 shadow-sm h-100">
                                        <div class="card-body p-0">
                                            <img src="<?php echo e(asset('storage/' . $path)); ?>" 
                                                 alt="Dokumentasi <?php echo e($originalName); ?>" 
                                                 class="w-100 rounded-top object-fit-cover" 
                                                 style="height: 200px;"
                                                 onclick="window.open('<?php echo e(asset('storage/' . $path)); ?>', '_blank')"
                                                 style="cursor: pointer;">
                                            <div class="p-3">
                                                <div class="text-center small text-muted"><?php echo e($originalName); ?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <?php if(($kegiatanLainnya->dokumen_lpj && count($kegiatanLainnya->dokumen_lpj) > 0) || 
                        ($kegiatanLainnya->dokumen_lpj_pdf)): ?>
                    <div>
                        <h4 class="fw-bold text-info mb-5 d-flex align-items-center">
                            <i class="fas fa-file-alt me-2"></i>
                            Dokumen Pendukung Kegiatan Lainnya
                        </h4>
                        
                        <div class="row g-4">
                            <?php if($kegiatanLainnya->dokumen_lpj_pdf): ?>
                                <?php
                                    $path = is_array($kegiatanLainnya->dokumen_lpj_pdf) ? 
                                            ($kegiatanLainnya->dokumen_lpj_pdf['path'] ?? '') : 
                                            $kegiatanLainnya->dokumen_lpj_pdf;
                                    $originalName = is_array($kegiatanLainnya->dokumen_lpj_pdf) ? 
                                                   ($kegiatanLainnya->dokumen_lpj_pdf['original_name'] ?? basename($path)) : 
                                                   basename($path);
                                ?>
                                
                                <?php if($path): ?>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center p-3 border rounded bg-light">
                                        <i class="fas fa-file-pdf text-danger me-3" style="font-size: 2em;"></i>
                                        <div class="flex-grow-1">
                                            <div class="fw-medium text-dark"><?php echo e($originalName); ?></div>
                                            <small class="text-muted">PDF</small>
                                        </div>
                                        <a href="<?php echo e(asset('storage/' . $path)); ?>"
                                           target="_blank"
                                           class="btn btn-outline-danger btn-sm">
                                            <i class="fas fa-download me-1"></i>Unduh
                                        </a>
                                    </div>
                                </div>
                                <?php endif; ?>
                            <?php endif; ?>
                            
                            <?php if($kegiatanLainnya->dokumen_lpj && count($kegiatanLainnya->dokumen_lpj) > 0): ?>
                                <?php $__currentLoopData = $kegiatanLainnya->dokumen_lpj; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dokumen): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $path = is_array($dokumen) ? ($dokumen['path'] ?? '') : $dokumen;
                                        $originalName = is_array($dokumen) ? 
                                                       ($dokumen['original_name'] ?? basename($path)) : 
                                                       basename($path);
                                        $extension = pathinfo($originalName, PATHINFO_EXTENSION);
                                        
                                        $iconClass = 'fas fa-file text-secondary';
                                        if ($extension === 'pdf') $iconClass = 'fas fa-file-pdf text-danger';
                                        else if (in_array($extension, ['doc', 'docx'])) $iconClass = 'fas fa-file-word text-primary';
                                        else if (in_array($extension, ['xls', 'xlsx'])) $iconClass = 'fas fa-file-excel text-success';
                                        else if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) $iconClass = 'fas fa-file-image text-info';
                                    ?>
                                    
                                    <?php if($path): ?>
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center p-3 border rounded bg-light">
                                            <i class="<?php echo e($iconClass); ?> me-3" style="font-size: 2em;"></i>
                                            <div class="flex-grow-1">
                                                <div class="fw-medium text-dark"><?php echo e($originalName); ?></div>
                                                <small class="text-muted"><?php echo e(strtoupper($extension)); ?></small>
                                            </div>
                                            <a href="<?php echo e(asset('storage/' . $path)); ?>"
                                               target="_blank"
                                               class="btn btn-outline-primary btn-sm">
                                                <i class="fas fa-download me-1"></i>Unduh
                                            </a>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/thur/Documents/Inotive/web-koni/resources/views/admin/laporan-lpj/kegiatan-lainnya/show.blade.php ENDPATH**/ ?>