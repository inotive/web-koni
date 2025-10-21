<?php $__env->startSection('pageTitle', 'Tambah Laporan Bendahara'); ?>
<?php $__env->startSection('mainSection', 'Bendahara'); ?>
<?php $__env->startSection('subSection', 'Laporan'); ?>
<?php $__env->startSection('subSectionUrl', route('admin.bendahara.index')); ?>
<?php $__env->startSection('currentSection', 'Tambah Laporan Bendahara'); ?>

<?php $__env->startSection('content'); ?>

<style>
    body {
        background-color: #f5f5f5 !important;
    }

    .main-content {
        background-color: #f5f5f5;
        min-height: 100vh;
        padding: 20px 10px 40px;
    }

    .card-form {
        background-color: white;
        border-radius: 12px;
        border: 1px solid #e9ecef;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
    }

    .section-header {
        color: #0b153a;
        font-weight: 700;
        font-size: 1.6rem;
        margin-bottom: 1rem;
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

    .file-upload-text {
        margin: 0;
        font-size: 0.95rem;
        font-weight: 500;
        color: #0b153a;
    }

    .file-upload-hint {
        font-size: 0.8rem;
        color: #6c757d;
        margin-top: 4px;
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

    .invalid-feedback {
        font-size: 0.85rem;
        color: #e74c3c;
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
</style>

<div class="d-flex justify-content-between align-items-center flex-wrap mb-4" style="padding: 20px 20px">
    <h3 class="fw-bold fs-2 mb-0 text-dark">Tambah Laporan Bendahara</h3>
</div>

<div class="main-content">
    <div class="container-fluid">
        <div class="row">
            <div class="card card-form">
                <div class="card-body p-4 p-md-5">
                    <h3 class="fw-bold mb-4">Tambah Data</h3>
                    <form action="<?php echo e(route('admin.bendahara.store')); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>

                        <!-- Judul -->
                        <div class="row align-items-center mb-4">
                            <div class="col-md-3">
                                <label for="judul" class="form-label">Judul Laporan <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" name="judul" id="judul"
                                       class="form-control <?php $__errorArgs = ['judul'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       placeholder="Contoh: Laporan Keuangan Bulan Januari 2025"
                                       value="<?php echo e(old('judul')); ?>" required>
                                <?php $__errorArgs = ['judul'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <!-- Dokumen Upload -->
                        <div class="row align-items-start mb-4">
                            <div class="col-md-3">
                                <label for="dokumen" class="form-label">Dokumen</label>
                                <p class="file-upload-hint">PDF, DOC, DOCX, XLS, XLSX (Max: 5MB)</p>
                            </div>
                            <div class="col-md-9">
                                <label for="dokumen" class="file-upload-wrapper">
                                    <input type="file" name="dokumen" id="dokumen"
                                           accept=".pdf,.doc,.docx,.xls,.xlsx"
                                           class="<?php $__errorArgs = ['dokumen'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                    <div class="file-upload-icon-wrapper">
                                        <i class="fas fa-file-upload file-upload-icon"></i>
                                    </div>
                                    <div>
                                        <p class="file-upload-text" id="file-name-display">
                                            Seret dan lepas file di sini, atau klik untuk mengunggah.
                                        </p>
                                        <p class="file-upload-hint">Format yang didukung: PDF, DOC, DOCX, XLS, XLSX</p>
                                    </div>
                                </label>

                                <?php $__errorArgs = ['dokumen'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                                <div id="filePreviewContainer" style="display: none; margin-top: 15px;">
                                    <div class="alert alert-info d-flex align-items-center">
                                        <i class="fas fa-file-alt me-2"></i>
                                        <span id="selected-file-name"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="row mt-4">
                            <div class="col-md-9 offset-md-3 d-flex justify-content-between">
                                <button type="submit" class="btn btn-danger px-4">Simpan Data</button>
                                <a href="<?php echo e(route('admin.bendahara.index')); ?>" class="btn btn-secondary px-4">Kembali</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const uploadInput = document.getElementById('dokumen');
        const previewContainer = document.getElementById('filePreviewContainer');
        const fileNameDisplay = document.getElementById('file-name-display');
        const selectedFileName = document.getElementById('selected-file-name');

        uploadInput.addEventListener('change', function() {
            const file = this.files[0];

            if (file) {
                // Validate file type
                const allowedTypes = ['.pdf', '.doc', '.docx', '.xls', '.xlsx'];
                const fileExtension = '.' + file.name.split('.').pop().toLowerCase();

                if (!allowedTypes.includes(fileExtension)) {
                    alert('Format file tidak didukung. Hanya diperbolehkan: PDF, DOC, DOCX, XLS, XLSX');
                    this.value = '';
                    return;
                }

                // Validate file size (5MB = 5 * 1024 * 1024 bytes)
                if (file.size > 5 * 1024 * 1024) {
                    alert('Ukuran file terlalu besar. Maksimal 5MB');
                    this.value = '';
                    return;
                }

                fileNameDisplay.textContent = file.name;
                selectedFileName.textContent = file.name;
                previewContainer.style.display = 'block';
            } else {
                fileNameDisplay.textContent = 'Seret dan lepas file di sini, atau klik untuk mengunggah.';
                previewContainer.style.display = 'none';
            }
        });

        // Handle drag and drop
        const uploadWrapper = document.querySelector('.file-upload-wrapper');

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            uploadWrapper.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            uploadWrapper.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            uploadWrapper.addEventListener(eventName, unhighlight, false);
        });

        function highlight() {
            uploadWrapper.style.borderColor = '#0d6efd';
            uploadWrapper.style.backgroundColor = '#e6f0ff';
        }

        function unhighlight() {
            uploadWrapper.style.borderColor = '#cfe2ff';
            uploadWrapper.style.backgroundColor = '#edf5ff';
        }

        uploadWrapper.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;

            uploadInput.files = files;
            uploadInput.dispatchEvent(new Event('change'));
        }
    });
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/thur/Documents/Inotive/web-koni/resources/views/admin/bendahara/OLD/create.blade.php ENDPATH**/ ?>