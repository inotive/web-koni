<?php
    $subSection3Url = '';

    if ($lpj->parent?->parent) {
        if ($lpj->parent->parent->id == 9) {
            $subSection3Url = route('admin.laporan-lpj.bidang.prestasi.cabor-terukur', [
                'parentId' => $lpj->parent->parent->id
            ]);
        }
            elseif ($lpj->parent->parent->id == 10) {
                $subSection3Url = route('admin.laporan-lpj.bidang.prestasi.cabor-akurasi', [
                    'parentId' => $lpj->parent->parent->id
                ]);
        }
            elseif ($lpj->parent->parent->id == 11) {
                $subSection3Url = route('admin.laporan-lpj.bidang.prestasi.cabor-permainan', [
                    'parentId' => $lpj->parent->parent->id
                ]);
        }
            elseif ($lpj->parent->parent->id == 12) {
                $subSection3Url = route('admin.laporan-lpj.bidang.prestasi.cabor-beladiri', [
                    'parentId' => $lpj->parent->parent->id
                ]);
        }
          else {
            // fallback if needed
            $subSection3Url = route('admin.laporan-lpj.bidang.dynamic.index');
        }
    }
?>

<?php $__env->startSection('pageTitle', 'Edit Laporan LPJ'); ?>
<?php $__env->startSection('mainSection', 'Laporan LPJ'); ?>
<?php $__env->startSection('subSection', 'Bidang Bidang'); ?>
<?php $__env->startSection('subSectionUrl', route('admin.laporan-lpj.bidang.index')); ?>
<?php $__env->startSection('subSection2', $lpj->parent?->parent?->parent?->nama_program ?? ''); ?>
<?php $__env->startSection('subSection2Url', route('admin.laporan-lpj.bidang.prestasi.index')); ?>
<?php $__env->startSection('subSection3', $lpj->parent?->parent?->nama_program ?? ''); ?>
<?php $__env->startSection('subSection3Url', $subSection3Url); ?>
<?php $__env->startSection('subSection4', $lpj->parent?->nama_program ?? ''); ?>
<?php $__env->startSection('subSection4Url', $lpj->parent ? route('admin.laporan-lpj.bidang.dynamic.child.index', ['parentId' => $lpj->parent->id]) : route('admin.laporan-lpj.bidang.dynamic.index')); ?>
<?php $__env->startSection('currentSection', 'Edit Laporan'); ?>

<?php $__env->startSection('content'); ?>
<style>
    body {
        background-color: #f5f5f5 !important;
    }

    .main-content {
        background-color: #f5f5f5;
        padding: 20px 10px;
    }

    .card-form {
        background-color: white;
        border-radius: 12px;
        border: 1px solid #e9ecef;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
    }

    .form-control, .form-select {
        border-radius: 8px;
        padding: 10px 14px;
        font-size: 0.95rem;
    }

    .form-control:focus, .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.2);
    }

    .btn-danger {
        background: linear-gradient(135deg, #F8285A 0%, #e91e63 100%);
        border: none;
        border-radius: 8px;
        padding: 12px 24px;
        font-weight: 600;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(248, 40, 90, 0.3);
    }

    .btn-danger:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(248, 40, 90, 0.4);
    }

    .currency-input {
        position: relative;
    }

    .currency-input::before {
        content: "Rp";
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #6c757d;
        font-size: 0.95rem;
        z-index: 1;
    }

    .currency-input input {
        padding-left: 35px;
    }

    .file-upload-wrapper {
        display: flex;
        align-items: center;
        gap: 12px;
        border: 1px solid #cfe2ff;
        background-color: #edf5ff;
        border-radius: 10px;
        padding: 16px 20px;
        cursor: pointer;
        transition: all 0.2s ease-in-out;
    }

    .file-upload-wrapper:hover {
        border-color: #0d6efd;
        background-color: #e6f0ff;
    }

    .file-upload-wrapper input[type="file"] {
        display: none;
    }

    .file-upload-icon-wrapper {
        background-color: #d0e7ff;
        padding: 8px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .file-upload-icon {
        font-size: 1.5rem;
        color: #0d6efd;
    }

    /* Enhanced preview container with scrollable functionality */
    .preview-container {
        margin-top: 15px;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 15px;
        background-color: #f8f9fa;
        /* Dynamic height based on content */
        max-height: none;
        overflow: visible;
    }

    /* Scrollable container when more than 5 items */
    .preview-container.scrollable {
        max-height: 350px; /* Approximately height for 5 items (5 * 64px + padding) */
        overflow-y: auto;
        overflow-x: hidden;
    }

    /* Custom scrollbar styling */
    .preview-container.scrollable::-webkit-scrollbar {
        width: 8px;
    }

    .preview-container.scrollable::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }

    .preview-container.scrollable::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 4px;
        transition: background 0.3s ease;
    }

    .preview-container.scrollable::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }

    /* Firefox scrollbar styling */
    .preview-container.scrollable {
        scrollbar-width: thin;
        scrollbar-color: #c1c1c1 #f1f1f1;
    }

    .file-preview-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px;
        border: 1px solid #e9ecef;
        border-radius: 6px;
        background-color: white;
        margin-bottom: 8px;
        min-height: 64px; /* Consistent height for better scrolling experience */
        transition: all 0.2s ease;
    }

    .file-preview-item:hover {
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        transform: translateY(-1px);
    }

    .file-preview-item.existing {
        background-color: #e8f5e8;
        border-color: #28a745;
    }

    .preview-image, .file-icon {
        width: 40px;
        height: 40px;
        object-fit: cover;
        border-radius: 4px;
        border: 1px solid #e9ecef;
        flex-shrink: 0; /* Prevent shrinking in flex container */
    }

    .file-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f8f9fa;
    }

    .file-info {
        flex: 1;
        min-width: 0; /* Allow text to wrap properly */
    }

    .file-name {
        font-weight: 500;
        color: #212529;
        font-size: 0.9rem;
        word-break: break-word; /* Better word breaking */
        line-height: 1.3;
    }

    .file-size {
        font-size: 0.75rem;
        color: #6c757d;
        margin-top: 2px;
    }

    .remove-file {
        background: none;
        border: none;
        color: #dc3545;
        font-size: 1rem;
        cursor: pointer;
        padding: 6px;
        border-radius: 4px;
        transition: all 0.2s ease;
        flex-shrink: 0; /* Prevent shrinking */
    }

    .remove-file:hover {
        background-color: #dc3545;
        color: white;
        transform: scale(1.1);
    }

    .existing-files-section {
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 12px;
        margin-bottom: 12px;
    }

    .existing-files-section h6 {
        color: #495057;
        font-weight: 600;
        margin-bottom: 8px;
        font-size: 0.9rem;
    }

    /* Scroll indicator for better UX */
    .preview-container.scrollable::after {
        content: "";
        position: absolute;
        bottom: 15px;
        right: 15px;
        width: 20px;
        height: 20px;
        background: linear-gradient(45deg, #0d6efd 0%, #0056b3 100%);
        border-radius: 50%;
        opacity: 0.7;
        animation: scrollPulse 2s infinite;
        pointer-events: none;
    }

    @keyframes scrollPulse {
        0%, 100% {
            opacity: 0.7;
            transform: scale(1);
        }
        50% {
            opacity: 0.4;
            transform: scale(0.9);
        }
    }

    /* Hide scroll indicator when scrolled to bottom */
    .preview-container.scrollable.scrolled-bottom::after {
        display: none;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .preview-container.scrollable {
            max-height: 280px; /* Slightly shorter on mobile */
        }

        .file-preview-item {
            padding: 10px;
            gap: 10px;
        }

        .preview-image, .file-icon {
            width: 35px;
            height: 35px;
        }
}
</style>

<div class="d-flex justify-content-between align-items-center flex-wrap mb-4" style="padding: 20px 20px">
    <h3 class="fw-bold fs-2 mb-0 text-dark">Edit Laporan LPJ</h3>
</div>

<div class="main-content">
    <div class="container-fluid">
        <div class="card card-form">
            <div class="card-body p-4 p-md-5">
                <h3 class="fw-bold mb-4">Edit: <?php echo e($lpj->nama_program); ?></h3>

                <form action="<?php echo e(route('admin.laporan-lpj.bidang.dynamic.update', $lpj->id)); ?>" method="POST" id="lpjForm" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    

                    
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="nama_program" class="form-label">Nama Program <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" name="nama_program" id="nama_program"
                                   class="form-control <?php $__errorArgs = ['nama_program'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   value="<?php echo e(old('nama_program', $lpj->nama_program)); ?>" required>
                            <?php $__errorArgs = ['nama_program'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="nama_kegiatan" class="form-label">Nama Kegiatan <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" name="nama_kegiatan" id="nama_kegiatan"
                                   class="form-control <?php $__errorArgs = ['nama_kegiatan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   value="<?php echo e(old('nama_kegiatan', $lpj->nama_kegiatan)); ?>" required>
                            <?php $__errorArgs = ['nama_kegiatan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    
                            <input type="hidden" name="volume" id="volume"
                                   
                                   value="0">
                            
                        

                    
                    
                                <input type="hidden" name="jumlah_harga_satuan" id="jumlah_harga_satuan"
                                       
                                       inputmode="numeric"
                                       value="0">
                            

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="jumlah_harga" class="form-label">Total Anggaran</label>
                        </div>
                        <div class="col-md-9">
                            <div class="currency-input">
                                <input type="text" name="jumlah_harga" id="jumlah_harga"
                                       class="form-control <?php $__errorArgs = ['jumlah_harga'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       placeholder="0" inputmode="numeric"
                                       value="<?php echo e(old('jumlah_harga', number_format($lpj->jumlah_harga ?? 0, 0, ',', '.'))); ?>">
                            </div>
                            <?php $__errorArgs = ['jumlah_harga'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label class="form-label">Foto Jurnal</label>
                            <small class="text-muted d-block">Ukuran per file maksimal 10MB</small>
                        </div>
                        <div class="col-md-9">
                            <?php if($lpj->foto_jurnal && count($lpj->foto_jurnal) > 0): ?>
                                <div class="existing-files-section">
                                    <h6><i class="fas fa-images me-2"></i>Foto yang sudah ada:</h6>
                                    <?php $__currentLoopData = $lpj->foto_jurnal; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $foto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="file-preview-item existing">
                                            <img src="<?php echo e(asset('storage/' . $foto)); ?>" class="preview-image">
                                            <div class="file-info">
                                                <div class="file-name"><?php echo e(basename($foto)); ?></div>
                                                <div class="file-size">Existing file</div>
                                            </div>
                                            <button type="button" class="remove-file" data-path="<?php echo e($foto); ?>" data-type="existing">
                                                <i class="fas fa-times"></i>
                                            </button>
                                            <input type="hidden" name="existing_foto_jurnal[]" value="<?php echo e($foto); ?>">
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php endif; ?>

                            <label for="foto_jurnal" class="file-upload-wrapper">
                                <input type="file" name="foto_jurnal[]" id="foto_jurnal" accept="image/*" multiple>
                                <div class="file-upload-icon-wrapper">
                                    <i class="fas fa-upload file-upload-icon"></i>
                                </div>
                                <div>
                                    <p class="file-upload-text mb-0">Upload foto baru</p>
                                </div>
                            </label>
                            <div id="foto_jurnalPreview" class="preview-container" style="display: none;"></div>
                            <?php $__errorArgs = ['foto_jurnal.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger mt-2"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label class="form-label">Dokumen pendukung</label>
                            <small class="text-muted d-block">Ukuran per file maksimal 10MB</small>
                        </div>
                        <div class="col-md-9">
                            <?php if($lpj->dokumen_pendukung && count($lpj->dokumen_pendukung) > 0): ?>
                                <div class="existing-files-section">
                                    <h6><i class="fas fa-file-alt me-2"></i>Dokumen yang sudah ada:</h6>
                                    <?php $__currentLoopData = $lpj->dokumen_pendukung; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dokumen): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $ext = pathinfo($dokumen, PATHINFO_EXTENSION);
                                            $icon = match(strtolower($ext)) {
                                                'pdf' => 'fas fa-file-pdf text-danger',
                                                'doc', 'docx' => 'fas fa-file-word text-primary',
                                                'xls', 'xlsx' => 'fas fa-file-excel text-success',
                                                default => 'fas fa-file text-secondary'
                                            };
                                        ?>
                                        <div class="file-preview-item existing">
                                            <div class="file-icon"><i class="<?php echo e($icon); ?>"></i></div>
                                            <div class="file-info">
                                                <div class="file-name"><?php echo e(basename($dokumen)); ?></div>
                                                <div class="file-size">Existing file</div>
                                            </div>
                                            <button type="button" class="remove-file" data-path="<?php echo e($dokumen); ?>" data-type="existing">
                                                <i class="fas fa-times"></i>
                                            </button>
                                            <input type="hidden" name="existing_dokumen_pendukung[]" value="<?php echo e($dokumen); ?>">
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php endif; ?>

                            <label for="dokumen_pendukung" class="file-upload-wrapper">
                                <input type="file" name="dokumen_pendukung[]" id="dokumen_pendukung" accept=".pdf,.doc,.docx" multiple>
                                <div class="file-upload-icon-wrapper">
                                    <i class="fas fa-upload file-upload-icon"></i>
                                </div>
                                <div>
                                    <p class="file-upload-text mb-0">Upload dokumen baru</p>
                                </div>
                            </label>
                            <div id="dokumen_pendukungPreview" class="preview-container" style="display: none;"></div>
                            <?php $__errorArgs = ['dokumen_pendukung.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger mt-2"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label class="form-label">Dokumen LPJ</label>
                            <small class="text-muted d-block">Ukuran per file maksimal 10MB</small>
                        </div>
                        <div class="col-md-9">
                            <?php if($lpj->dokumen_lpj && count($lpj->dokumen_lpj) > 0): ?>
                                <div class="existing-files-section">
                                    <h6><i class="fas fa-file-alt me-2"></i>Dokumen yang sudah ada:</h6>
                                    <?php $__currentLoopData = $lpj->dokumen_lpj; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dokumen): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $ext = pathinfo($dokumen, PATHINFO_EXTENSION);
                                            $icon = match(strtolower($ext)) {
                                                'pdf' => 'fas fa-file-pdf text-danger',
                                                'doc', 'docx' => 'fas fa-file-word text-primary',
                                                'xls', 'xlsx' => 'fas fa-file-excel text-success',
                                                default => 'fas fa-file text-secondary'
                                            };
                                        ?>
                                        <div class="file-preview-item existing">
                                            <div class="file-icon"><i class="<?php echo e($icon); ?>"></i></div>
                                            <div class="file-info">
                                                <div class="file-name"><?php echo e(basename($dokumen)); ?></div>
                                                <div class="file-size">Existing file</div>
                                            </div>
                                            <button type="button" class="remove-file" data-path="<?php echo e($dokumen); ?>" data-type="existing">
                                                <i class="fas fa-times"></i>
                                            </button>
                                            <input type="hidden" name="existing_dokumen_lpj[]" value="<?php echo e($dokumen); ?>">
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php endif; ?>

                            <label for="dokumen_lpj" class="file-upload-wrapper">
                                <input type="file" name="dokumen_lpj[]" id="dokumen_lpj" accept=".pdf,.doc,.docx" multiple>
                                <div class="file-upload-icon-wrapper">
                                    <i class="fas fa-upload file-upload-icon"></i>
                                </div>
                                <div>
                                    <p class="file-upload-text mb-0">Upload dokumen baru</p>
                                </div>
                            </label>
                            <div id="dokumen_lpjPreview" class="preview-container" style="display: none;"></div>
                            <?php $__errorArgs = ['dokumen_lpj.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger mt-2"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-3">
                            <label for="keterangan_tambahan" class="form-label">Keterangan Tambahan</label>
                        </div>
                        <div class="col-md-9">
                            <textarea name="keterangan_tambahan" id="keterangan_tambahan"
                                      class="form-control <?php $__errorArgs = ['keterangan_tambahan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                      rows="4"><?php echo e(old('keterangan_tambahan', $lpj->keterangan_tambahan)); ?></textarea>
                            <?php $__errorArgs = ['keterangan_tambahan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    
                    <div class="row">
                        <div class="col-md-9 offset-md-3 d-flex gap-3">
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-save me-2"></i>Simpan
                            </button>
                            <a href="<?php echo e($lpj->parent_id ? route('admin.laporan-lpj.bidang.dynamic.child.index', $lpj->parent_id) : route('admin.laporan-lpj.bidang.dynamic.index')); ?>"
                               class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const MAX_FILE_SIZE = 10 * 1024 * 1024; // 10MB

    let selectedFiles = {
        'foto_jurnal': [],
        'dokumen_lpj': [],
        'dokumen_pendukung': []
    };

    // ✅ Rupiah formatter WITHOUT prefix
    function initRupiahFormatter() {
        const jumlahHargaInput = document.getElementById('jumlah_harga');

        if (jumlahHargaInput) {
            // Format number with thousand separators (no prefix)
            function formatRupiah(number) {
                let numericValue = number.toString().replace(/[^0-9]/g, '');
                if (numericValue === '') return '';
                return parseInt(numericValue).toLocaleString('id-ID');
            }

            function extractNumeric(value) {
                return value.replace(/[^0-9]/g, '');
            }

            jumlahHargaInput.addEventListener('input', function(e) {
                let cursorPos = e.target.selectionStart;
                let numericValue = extractNumeric(e.target.value);

                let oldLength = e.target.value.length;
                e.target.value = formatRupiah(numericValue);
                let newLength = e.target.value.length;

                // Adjust cursor position based on difference in length
                let diff = newLength - oldLength;
                let newPos = cursorPos + diff;
                e.target.setSelectionRange(newPos, newPos);
            });

            // Format initial value if any
            if (jumlahHargaInput.value) {
                jumlahHargaInput.value = formatRupiah(extractNumeric(jumlahHargaInput.value));
            }

            // Before form submit, strip formatting
            const form = document.getElementById('lpjForm');
            if (form) {
                form.addEventListener('submit', function() {
                    jumlahHargaInput.value = extractNumeric(jumlahHargaInput.value);
                });
            }
        }
    }

    function initFileUpload(inputId) {
        const input = document.getElementById(inputId);
        if (!input) return;

        const previewContainer = document.getElementById(`${inputId}Preview`);

        input.addEventListener('change', function() {
            handleFileSelection(this.files, inputId);
        });

        function handleFileSelection(files, inputId) {
            const newFiles = Array.from(files).filter(file => {
                if (file.size > MAX_FILE_SIZE) {
                    alert(`File "${file.name}" terlalu besar. Maksimal 10MB per file.`);
                    return false;
                }
                if (inputId === 'foto_jurnal' && !file.type.match('image.*')) {
                    alert(`File "${file.name}" bukan file gambar yang valid.`);
                    return false;
                }
                return true;
            });

            selectedFiles[inputId] = [...selectedFiles[inputId], ...newFiles];
            updateFilePreview(inputId);
            updateFileInput(inputId);
        }

        function updateFilePreview(inputId) {
            const files = selectedFiles[inputId];
            if (files.length === 0) {
                previewContainer.style.display = 'none';
                return;
            }

            previewContainer.style.display = 'block';
            previewContainer.innerHTML = files.map((file, index) => {
                const fileSize = file.size > 1024 * 1024 ?
                    (file.size / (1024 * 1024)).toFixed(1) + ' MB' :
                    (file.size / 1024).toFixed(1) + ' KB';

                if (inputId === 'foto_jurnal') {
                    const imageUrl = URL.createObjectURL(file);
                    return `
                        <div class="file-preview-item">
                            <img src="${imageUrl}" alt="Preview" class="preview-image">
                            <div class="file-info">
                                <div class="file-name">${file.name}</div>
                                <div class="file-size">${fileSize}</div>
                            </div>
                            <button type="button" class="remove-file" data-index="${index}" data-input-id="${inputId}">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>`;
                } else {
                    const ext = file.name.split('.').pop().toLowerCase();
                    const iconMap = {
                        'pdf': 'fas fa-file-pdf text-danger',
                        'doc': 'fas fa-file-word text-primary',
                        'docx': 'fas fa-file-word text-primary',
                        'xls': 'fas fa-file-excel text-success',
                        'xlsx': 'fas fa-file-excel text-success'
                    };
                    const iconClass = iconMap[ext] || 'fas fa-file text-muted';

                    return `
                        <div class="file-preview-item">
                            <i class="${iconClass} fs-4"></i>
                            <div class="file-info">
                                <div class="file-name">${file.name}</div>
                                <div class="file-size">${fileSize}</div>
                            </div>
                            <button type="button" class="remove-file" data-index="${index}" data-input-id="${inputId}">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>`;
                }
            }).join('');

            previewContainer.querySelectorAll('.remove-file').forEach(button => {
                button.addEventListener('click', function() {
                    removeFile(parseInt(this.dataset.index), inputId);
                });
            });
        }

        function updateFileInput(inputId) {
            const dt = new DataTransfer();
            selectedFiles[inputId].forEach(file => dt.items.add(file));
            input.files = dt.files;
        }

        function removeFile(index, inputId) {
            selectedFiles[inputId].splice(index, 1);
            updateFilePreview(inputId);
            updateFileInput(inputId);
        }
    }

    document.querySelectorAll('.remove-file[data-type="existing"]').forEach(button => {
        button.addEventListener('click', function() {
            if (confirm('Hapus file ini?')) {
                this.parentElement.remove();
                const form = document.getElementById('lpjForm');
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'deleted_files[]';
                input.value = this.dataset.path;
                form.appendChild(input);
            }
        });
    });

    // ✅ Initialize formatter WITHOUT prefix
    initRupiahFormatter();

    // Initialize file uploads
    initFileUpload('foto_jurnal');
    initFileUpload('dokumen_lpj');
    initFileUpload('dokumen_pendukung');
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\ThinkPad\OneDrive\Dokumen\GitHub\web-koni\resources\views/admin/laporan-lpj/bidang_new/dynamic/edit.blade.php ENDPATH**/ ?>