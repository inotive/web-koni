<?php $__env->startSection('pageTitle', 'Detail Kegiatan Lainnya'); ?>
<?php $__env->startSection('mainSection', 'Laporan Pertanggungjawaban'); ?>
<?php $__env->startSection('currentSection', 'Kegiatan Lainnya'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <!-- Header dengan tombol kembali -->
    <div class="card-header">
        <h3 class="card-title">Detail Kegiatan</h3>
        <div class="card-toolbar">
            <a href="<?php echo e(route('admin.laporan-lpj.kegiatan-lainnya.index')); ?>" 
               class="btn btn-sm btn-light-primary">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
        </div>
    </div>
    
    <!-- Isi konten detail kegiatan -->
    <div class="card-body">
        <!-- Tampilkan detail kegiatan di sini -->
        <div class="row">
            <div class="col-md-6">
                <p><strong>Nama Kegiatan:</strong> <?php echo e($kegiatan->nama_program_kegiatan); ?></p>
                <!-- Tambahkan field lainnya -->
            </div>
        </div>
    </div>
    
    <!-- Footer dengan tombol aksi -->
    <div class="card-footer">
        <a href="<?php echo e(route('admin.laporan-lpj.kegiatan-lainnya.edit', $kegiatan->id)); ?>" 
           class="btn btn-warning">
            <i class="fas fa-edit me-2"></i> Edit
        </a>
        <!-- Tombol delete -->
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/thur/Documents/Inotive/web-koni/resources/views/admin/file-kesekretariat/show.blade.php ENDPATH**/ ?>