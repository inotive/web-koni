<?php $__env->startSection('pageTitle', 'Tambah Data Atlet'); ?>
<?php $__env->startSection('mainSection', 'Konfigurasi'); ?>
<?php $__env->startSection('subSection', 'Atlet'); ?>
<?php $__env->startSection('subSectionUrl', route('admin.konfigurasi.atlet.index')); ?>
<?php $__env->startSection('currentSection', 'Tambah Data Atlet'); ?>

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
                        <h3 class="fw-bold fs-2 mb-0 text-dark">Tambah Atlet</h3>
    </div>
<div class="main-content">
    <div class="container-fluid">
        <div class="row">

        <div class="card card-form">
            <div class="card-body p-4 p-md-5">
                <h3 class="fw-bold mb-4">Tambah Data</h3>
                <form action="<?php echo e(route('admin.konfigurasi.atlet.store')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="row align-items-start mb-4">
                <div class="col-md-3">
                    <label for="foto" class="form-label">Foto</label>
                    <p class="file-upload-hint">150x150px JPEG, PNG Image</p>
                </div>
                <div class="col-md-9">
                    <label for="foto" class="file-upload-wrapper">
                        <input type="file" name="foto" id="foto" class="<?php $__errorArgs = ['foto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <div class="file-upload-icon-wrapper">
                            <i class="fas fa-upload file-upload-icon"></i>
                        </div>
                        <div>
                            <p class="file-upload-text" id="file-name-display">Seret dan lepas file di sini, atau klik untuk mengunggah.</p>
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
                            'nama' => ['label' => 'Nama', 'type' => 'text', 'placeholder' => 'Masukkan Nama Atlet'],
                            'cabor_id' => [
                                'label' => 'Cabang Olahraga',
                                'type' => 'select',
                                'options' => $cabors,
                            ],
                            'email' => [
                                'label' => 'Email',
                                'type' => 'email',
                                'placeholder' => 'emailatlet@gmail.com',
                            ],
                            'no_telepon' => [
                                'label' => 'No Telepon',
                                'type' => 'text',
                                'placeholder' => '0895 9271 8263',
                            ],
                            'tanggal_lahir' => ['label' => 'Tanggal Lahir', 'type' => 'date'],
                            'tempat_lahir' => [
                                'label' => 'Tempat Lahir',
                                'type' => 'text',
                                'placeholder' => 'Balikpapan, Kalimantan Timur',
                            ],
                            'jenis_kelamin' => [
                                'label' => 'Jenis Kelamin',
                                'type' => 'select',
                                'options' => $allKelamin,
                            ],
                            'alamat' => [
                                'label' => 'Alamat',
                                'type' => 'text',
                                'placeholder' => 'Jln Prapatan Dalam RT 43 NO.08, Kelurahan Prapatan',
                            ],
                            'alamatprovinsi' => [
                                'label' => 'Provinsi',
                                'type' => 'text',
                                'placeholder' => 'Contoh: Kalimantan Timur',
                            ],
                            'alamatkota' => [
                                'label' => 'Kota/Kabupaten',
                                'type' => 'text',
                                'placeholder' => 'Contoh: Balikpapan',
                            ],
                        ];
                    ?>

                    <?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="row align-items-center mb-3">
                            <div class="col-md-3">
                                <label for="<?php echo e($key); ?>" class="form-label"><?php echo e($field['label']); ?></label>
                            </div>
                            <div class="col-md-9">
                                <?php if($field['type'] === 'select'): ?>
                                    <select name="<?php echo e($key); ?>" id="<?php echo e($key); ?>"
                                        class="form-select <?php $__errorArgs = [$key];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        <?php echo e($key === 'cabor_id' ? 'required' : ''); ?>>
                                        <option value="">Pilih <?php echo e($field['label']); ?></option>
                                        <?php if($key === 'cabor_id'): ?>
                                            <?php $__currentLoopData = $field['options']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $nama): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($id); ?>" <?php echo e(old($key) == $id ? 'selected' : ''); ?>>
                                                    <?php echo e($nama); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php else: ?>
                                            <?php $__currentLoopData = $field['options']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($option); ?>"
                                                    <?php echo e(old($key) == $option ? 'selected' : ''); ?>><?php echo e($option); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </select>
                                <?php elseif($field['type'] === 'textarea'): ?>
                                    <textarea name="<?php echo e($key); ?>" id="<?php echo e($key); ?>" class="form-control <?php $__errorArgs = [$key];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        placeholder="<?php echo e($field['placeholder']); ?>" rows="3"><?php echo e(old($key)); ?></textarea>
                                <?php else: ?>
                                    <input type="<?php echo e($field['type']); ?>" name="<?php echo e($key); ?>"
                                        id="<?php echo e($key); ?>" class="form-control <?php $__errorArgs = [$key];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        placeholder="<?php echo e($field['placeholder'] ?? ''); ?>" value="<?php echo e(old($key)); ?>"
                                        <?php echo e(in_array($key, ['nama', 'cabor_id', 'tanggal_lahir', 'tempat_lahir', 'jenis_kelamin', 'alamat', 'alamatprovinsi', 'alamatkota']) ? 'required' : ''); ?>>
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
                     <div class="row">
                        <div class="col-md-9 offset-md-3 d-flex gap-3">
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-save me-2"></i>Simpan
                            </button>
                            <a href="<?php echo e(route('admin.konfigurasi.atlet.index')); ?>"
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
</div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const uploadInput = document.getElementById('foto');
            const uploadContent = document.getElementById('uploadContent');
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

                    uploadContent.style.display = 'none';
                    previewContainer.style.display = 'block';
                    previewContainer.innerHTML = '';

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewContainer.innerHTML = `
                            <div class="d-flex justify-content-center align-items-center">
                                <img src="${e.target.result}" class="preview-image" alt="Preview Foto">
                                <div class="ms-3">
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/thur/Documents/Inotive/web-koni/resources/views/admin/atlet/create.blade.php ENDPATH**/ ?>