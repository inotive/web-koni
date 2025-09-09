<?php $__env->startSection('pageTitle', 'Edit Data Pelatih'); ?>
<?php $__env->startSection('mainSection', 'Konfigurasi'); ?>
<?php $__env->startSection('mainSectionUrl', route('admin.konfigurasi.pelatih.index')); ?>
<?php $__env->startSection('subSection', 'Pelatih'); ?>
<?php $__env->startSection('subSectionUrl', route('admin.konfigurasi.pelatih.index')); ?>
<?php $__env->startSection('currentSection', 'Edit Data Pelatih'); ?>

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

    .preview-image {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 8px;
        border: 2px solid #e9ecef;
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
    <h3 class="fw-bold fs-2 mb-0 text-dark">Edit Pelatih</h3>
</div>
<div class="main-content">
    <div class="container-fluid">
        <div class="row">

        <div class="card card-form">
            <div class="card-body p-4 p-md-5">
                <h3 class="fw-bold mb-4">Edit Data</h3>
                <form action="<?php echo e(route('admin.konfigurasi.pelatih.update', $pelatih->id)); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    <!-- File Upload -->
                    <div class="row align-items-start mb-4">
                        <div class="col-md-3">
                            <label for="foto" class="form-label">Foto</label>
                            <p class="file-upload-hint">150x150px JPEG, PNG Image</p>
                        </div>
                        <div class="col-md-9">
                            <label for="foto" class="file-upload-wrapper" id="uploadContent">
                                <input type="file" name="foto" id="foto" class="<?php $__errorArgs = ['foto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <div class="file-upload-icon-wrapper">
                                    <?php if($pelatih->foto): ?>
                                        <img src="<?php echo e(Storage::url($pelatih->foto)); ?>" class="preview-image me-2" alt="Current Foto">
                                    <?php else: ?>
                                        <i class="fas fa-upload file-upload-icon"></i>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <p class="file-upload-text mb-1" id="file-name-display">
                                        <?php echo e($pelatih->foto ? 'Klik untuk mengubah foto' : 'Seret dan lepas file di sini, atau klik untuk mengunggah.'); ?>

                                    </p>
                                    <p class="file-upload-hint">Kosongkan jika tidak ingin mengubah foto</p>
                                </div>
                            </label>

                            <?php $__errorArgs = ['foto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                            <div id="imagePreviewContainer" style="display: none;"></div>
                        </div>
                    </div>

                    <?php
                        $fields = [
                            'nama' => ['label' => 'Nama', 'type' => 'text', 'placeholder' => 'Joko Widodo'],
                            'cabor_id' => ['label' => 'Cabang Olahraga', 'type' => 'select', 'options' => $cabors],
                            'email' => ['label' => 'Email', 'type' => 'email', 'placeholder' => 'emailpelatih@gmail.com'],
                            'no_telepon' => ['label' => 'No Telepon', 'type' => 'text', 'placeholder' => '0895 9271 8263'],
                            'tanggal_lahir' => ['label' => 'Tanggal Lahir', 'type' => 'date'],
                            'tempat_lahir' => ['label' => 'Tempat Lahir', 'type' => 'text', 'placeholder' => 'Balikpapan, Kalimantan Timur'],
                            'kelamin' => ['label' => 'Jenis Kelamin', 'type' => 'select', 'options' => $allKelamin],
                            'alamat' => ['label' => 'Alamat', 'type' => 'text', 'placeholder' => 'Jln Prapatan Dalam RT 43 NO.08, Kelurahan Prapatan'],
                            'alamatprovinsi' => ['label' => 'Provinsi', 'type' => 'text', 'placeholder' => 'Contoh: Kalimantan Timur'],
                            'alamatkota' => ['label' => 'Kota/Kabupaten', 'type' => 'text', 'placeholder' => 'Contoh: Balikpapan'],
                        ];
                    ?>

                    <?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="row align-items-center mb-3">
                            <div class="col-md-3">
                                <label for="<?php echo e($key); ?>" class="form-label"><?php echo e($field['label']); ?></label>
                            </div>
                            <div class="col-md-9">
                                <?php
                                    $value = old($key, $pelatih->{$key} ?? '');
                                    if ($field['type'] === 'date' && $value) {
                                        $value = \Carbon\Carbon::parse($value)->format('Y-m-d');
                                    }
                                ?>

                                <?php if($field['type'] === 'select'): ?>
                                    <select name="<?php echo e($key); ?>" id="<?php echo e($key); ?>" class="form-select <?php $__errorArgs = [$key];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                        <option value="">Pilih <?php echo e($field['label']); ?></option>
                                        <?php if($key === 'cabor_id'): ?>
                                            <?php $__currentLoopData = $field['options']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $nama): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($id); ?>" <?php echo e($value == $id ? 'selected' : ''); ?>><?php echo e($nama); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php else: ?>
                                            <?php $__currentLoopData = $field['options']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($option); ?>" <?php echo e($value == $option ? 'selected' : ''); ?>><?php echo e($option); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </select>
                                <?php else: ?>
                                    <input type="<?php echo e($field['type']); ?>" name="<?php echo e($key); ?>" id="<?php echo e($key); ?>"
                                           class="form-control <?php $__errorArgs = [$key];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           placeholder="<?php echo e($field['placeholder'] ?? ''); ?>" value="<?php echo e($value); ?>">
                                            <?php echo e(in_array($key, ['nama','cabor_id','tanggal_lahir','tempat_lahir','kelamin','alamat','alamatprovinsi','alamatkota']) ? '' : ''); ?>

                                <?php endif; ?>
                                <?php $__errorArgs = [$key];
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
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <input type="hidden" name="ketersediaan" value="Tersedia">
                                        <div class="row mt-4">
                        <div class="col-md-3 offset-md-3 d-flex justify-content-between">
                            <button type="submit" class="btn btn-danger px-4">
                                <i class="fas fa-save me-2"></i>Simpan Laporan
                            </button>
                            <a href="<?php echo e(route('admin.konfigurasi.pelatih.index')); ?>"
                                class="btn btn-secondary px-4">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
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
    const uploadInput = document.getElementById('foto');
    const previewContainer = document.getElementById('imagePreviewContainer');
    const fileNameDisplay = document.getElementById('file-name-display');

    uploadInput.addEventListener('change', function() {
        const file = this.files[0];

        if (file) {
            fileNameDisplay.textContent = file.name;

            if (!file.type.match('image.*')) {
                alert('Hanya file gambar yang diizinkan');
                return;
            }

            previewContainer.style.display = 'block';
            previewContainer.innerHTML = '';

            const reader = new FileReader();
            reader.onload = function(e) {
                previewContainer.innerHTML = `
                    <div class="d-flex justify-content-start align-items-center">
                        <img src="${e.target.result}" class="preview-image me-3" alt="Preview Foto">
                        <div>
                            <p class="file-upload-text mb-1">${file.name}</p>
                            <p class="file-upload-hint">Klik untuk mengubah foto</p>
                        </div>
                    </div>
                `;
            };
            reader.readAsDataURL(file);
        } else {
            fileNameDisplay.textContent = 'Seret dan lepas file di sini, atau klik untuk mengunggah.';
            previewContainer.style.display = 'none';
            previewContainer.innerHTML = '';
        }
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Javier\Documents\GitHub\web-koni\resources\views/admin/pelatih/edit.blade.php ENDPATH**/ ?>