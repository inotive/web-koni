<?php $__env->startSection('pageTitle', 'Edit Cabang Olahraga'); ?>
<?php $__env->startSection('mainSection', 'Konfigurasi'); ?>
<?php $__env->startSection('mainSectionUrl', route('admin.konfigurasi.cabang-olahraga.index')); ?>
<?php $__env->startSection('subSection', 'Cabang Olahraga'); ?>
<?php $__env->startSection('subSectionUrl', route('admin.konfigurasi.cabang-olahraga.index')); ?>
<?php $__env->startSection('currentSection', 'Edit Cabang Olahraga'); ?>
<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/create.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('breadcrumb-title'); ?>
    
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <style>
        body {
            background-color: #f5f5f5;
        }

        .form-label {
            font-weight: 500;
            color: #495057;
        }

        .card-form {
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border: none;
        }

        .file-upload-wrapper {
            border: 2px dashed #dee2e6;
            border-radius: 8px;
            padding: 1.5rem;
            text-align: center;
            cursor: pointer;
            background-color: #f8f9fa;
            transition: all 0.2s ease-in-out;
            position: relative;
        }

        .file-upload-wrapper:hover {
            border-color: #0d6efd;
            background-color: #e9ecef;
        }

        .file-upload-wrapper input[type="file"] {
            display: none;
        }

        .file-upload-icon {
            font-size: 2.5rem;
            color: #0d6efd;
        }

        .file-upload-text {
            color: #495057;
            font-weight: 500;
        }

        .file-upload-hint {
            color: #6c757d;
            font-size: 0.9em;
        }

        .current-photo {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
        }

        .preview-image {
            max-width: 100px;
            max-height: 100px;
            border-radius: 8px;
            object-fit: cover;
        }

        .current-image-container {
            margin-top: 1rem;
        }

        .current-image-label {
            font-size: 0.8rem;
            color: #6c757d;
            margin-bottom: 0.5rem;
            display: block;
        }

        .current-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #dee2e6;
        }

    </style>

    <div class="container mt-4">
        <div class="card card-form">
            <div class="card-body p-4 p-md-5">
                <h3 class="fw-bold mb-4">Edit Data Cabang Olahraga</h3>

                <form action="<?php echo e(route('admin.konfigurasi.cabang-olahraga.update', $cabor->id)); ?>" method="POST"
                    enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    <div class="row align-items-center mb-4">
                        <div class="col-md-3">
                            <label for="icon_cabor" class="form-label">Ikon Cabang Olahraga</label>
                        </div>
                        <div class="col-md-9">
                            <label for="icon_cabor" class="file-upload-wrapper" id="dropArea">
                                <input type="file" name="icon_cabor" id="icon_cabor"
                                    accept=".png,.webp,.svg,image/png,image/webp,image/svg+xml">

                                <!-- Upload content - akan disembunyikan jika ada ikon -->
                                <div class="d-flex justify-content-center align-items-center" id="uploadContent"
                                    <?php if($cabor->icon_cabor): ?> style="display: none !important;" <?php endif; ?>>
                                    <i class="fas fa-cloud-upload-alt file-upload-icon me-3" id="uploadIcon"></i>
                                    <div id="uploadText">
                                        <p class="file-upload-text mb-1">Seret dan lepas file di sini, atau klik untuk
                                            mengunggah</p>
                                        <p class="file-upload-hint" id="file-name-display">PNG, WebP, atau SVG (80x80px)</p>
                                    </div>
                                </div>

                                <!-- Container untuk preview ikon baru -->
                                <div id="imagePreviewContainer" style="display: none;"></div>

                                <!-- Container untuk ikon yang sudah ada - ditampilkan di dalam kotak -->
                                <?php if($cabor->icon_cabor): ?>
                                    <div id="existingImageContainer"
                                        class="d-flex justify-content-center align-items-center">
                                        <img src="<?php echo e(asset('storage/' . $cabor->icon_cabor)); ?>" alt="Ikon Cabor"
                                            class="preview-image me-3"
                                            style="width: 80px; height: 80px; object-fit: contain; border: 1px solid #dee2e6;">
                                        <div>
                                            <p class="file-upload-text mb-1">Ikon Cabor Saat Ini</p>
                                            <p class="file-upload-hint">80x80px</p>
                                            <p class="file-upload-hint">Klik untuk mengubah ikon</p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </label>
                            <?php $__errorArgs = ['icon_cabor'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <?php
                        $fields = [
                            'nama_cabor' => [
                                'label' => 'Nama Cabang Olahraga',
                                'type' => 'text',
                                'placeholder' => 'Masukkan nama cabang olahraga',
                                'required' => true,
                                'value' => $cabor->nama_cabor,
                            ],
                            'ketua_penanggung_jawab' => [
                                'label' => 'Ketua Penanggung Jawab',
                                'type' => 'text',
                                'placeholder' => 'Masukkan nama ketua penanggung jawab',
                                'required' => true,
                                'value' => $cabor->ketua_penanggung_jawab,
                            ],
                            'status' => [
                                'label' => 'Status Keaktifan',
                                'type' => 'select',
                                'options' => ['Aktif', 'Pembinaan'],
                                'required' => true,
                                'value' => $cabor->status,
                            ],
                            'tanggal_pembentukan' => [
                                'label' => 'Tanggal Pembentukan',
                                'type' => 'date',
                                'required' => true,
                                // pastikan formatnya Y-m-d
                                'value' => optional($cabor->tanggal_pembentukan)->format('Y-m-d'),
                            ],
                        ];
                    ?>

                    <?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="row align-items-center mb-3">
                            <div class="col-md-3">
                                <label for="<?php echo e($key); ?>" class="form-label"><?php echo e($field['label']); ?></label>
                            </div>
                            <div class="col-md-9">
                                <?php
                                    $value = old($key, $field['value']);
                                ?>
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
                                        <?php echo e($field['required'] ? 'required' : ''); ?>>
                                        <option value="">Pilih <?php echo e($field['label']); ?></option>
                                        <?php $__currentLoopData = $field['options']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($option); ?>" <?php echo e($value == $option ? 'selected' : ''); ?>>
                                                <?php echo e($option); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                                        placeholder="<?php echo e($field['placeholder']); ?>" rows="3" <?php echo e($field['required'] ? 'required' : ''); ?>><?php echo e($value); ?></textarea>
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
                                        placeholder="<?php echo e($field['placeholder'] ?? ''); ?>" value="<?php echo e($value); ?>"
                                        <?php echo e($field['required'] ? 'required' : ''); ?>

                                        <?php if($field['type'] === 'number'): ?> min="0" <?php endif; ?>>
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

                    <div class="row mt-4">
                        <div class="col-md-9 offset-md-3 d-flex gap-2">
                            <button type="submit" class="btn btn-danger px-4">Update Data</button>
                            <a href="<?php echo e(route('admin.konfigurasi.cabang-olahraga.index')); ?>"
                                class="btn btn-secondary px-4">Batal</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const uploadInput = document.getElementById('icon_cabor');
            const dropArea = document.getElementById('dropArea');
            const uploadContent = document.getElementById('uploadContent');
            const previewContainer = document.getElementById('imagePreviewContainer');
            const existingImageContainer = document.getElementById('existingImageContainer');

            // Define allowed file types
            const allowedTypes = ['image/png', 'image/webp', 'image/svg+xml'];
            const allowedExtensions = ['.png', '.webp', '.svg'];

            // Function to validate file type
            function isValidFileType(file) {
                const fileType = file.type;
                const fileName = file.name.toLowerCase();

                // Check MIME type
                if (allowedTypes.includes(fileType)) {
                    return true;
                }

                // Check file extension as fallback
                return allowedExtensions.some(ext => fileName.endsWith(ext));
            }

            // Function to resize image to 80x80px
            function resizeImage(file, callback) {
                // Skip resize for SVG files
                if (file.type === 'image/svg+xml') {
                    callback(file);
                    return;
                }

                const canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');
                const img = new Image();

                img.onload = function() {
                    // Set canvas size to 80x80
                    canvas.width = 80;
                    canvas.height = 80;

                    // Calculate scaling to fit image in 80x80 while maintaining aspect ratio
                    const scale = Math.min(80 / img.width, 80 / img.height);
                    const scaledWidth = img.width * scale;
                    const scaledHeight = img.height * scale;

                    // Center the image
                    const x = (80 - scaledWidth) / 2;
                    const y = (80 - scaledHeight) / 2;

                    // Fill background with transparent
                    ctx.clearRect(0, 0, 80, 80);

                    // Draw the resized image
                    ctx.drawImage(img, x, y, scaledWidth, scaledHeight);

                    // Convert canvas to blob
                    canvas.toBlob(function(blob) {
                        // Create new File object with resized image
                        const resizedFile = new File([blob], file.name, {
                            type: file.type === 'image/webp' ? 'image/webp' : 'image/png',
                            lastModified: Date.now()
                        });
                        callback(resizedFile);
                    }, file.type === 'image/webp' ? 'image/webp' : 'image/png', 0.9);
                };

                img.src = URL.createObjectURL(file);
            }

            // Image preview functionality with auto resize
            uploadInput.addEventListener('change', function() {
                const file = this.files[0];

                if (file) {
                    if (!isValidFileType(file)) {
                        alert('Hanya file PNG, WebP, atau SVG yang diizinkan');
                        this.value = ''; // Clear the input
                        return;
                    }

                    // Hide upload content and existing image
                    uploadContent.style.display = 'none';
                    if (existingImageContainer) {
                        existingImageContainer.style.display = 'none';
                    }

                    // Show loading state
                    previewContainer.style.display = 'flex';
                    previewContainer.style.justifyContent = 'center';
                    previewContainer.style.alignItems = 'center';
                    previewContainer.innerHTML = `
                    <div class="d-flex justify-content-center align-items-center">
                        <div class="spinner-border text-primary me-3" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <div>
                            <p class="file-upload-text mb-1">Memproses gambar...</p>
                            <p class="file-upload-hint">Mohon tunggu sebentar</p>
                        </div>
                    </div>
                `;

                    // Resize image and update preview
                    resizeImage(file, (resizedFile) => {
                        // Create new FileList with resized file
                        const dt = new DataTransfer();
                        dt.items.add(resizedFile);
                        uploadInput.files = dt.files;

                        // Show preview
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const fileSize = (resizedFile.size / 1024).toFixed(1);
                            const previewContent = `
                        <div class="d-flex justify-content-center align-items-center">
                            <img src="${e.target.result}" class="preview-image me-3" alt="Preview Ikon Cabor" style="width: 80px; height: 80px; object-fit: contain; border-radius: 8px; border: 1px solid #dee2e6;">
                            <div>
                                <p class="file-upload-text mb-1">${resizedFile.name}</p>
                                <p class="file-upload-hint">80x80px • ${fileSize} KB</p>
                                <p class="file-upload-hint">Klik untuk mengubah ikon</p>
                            </div>
                        </div>
                    `;
                            previewContainer.innerHTML = previewContent;
                        };
                        reader.readAsDataURL(resizedFile);
                    });
                } else {
                    // Reset to original state
                    previewContainer.style.display = 'none';
                    previewContainer.innerHTML = '';

                    // Show appropriate content based on whether existing image exists
                    if (existingImageContainer) {
                        existingImageContainer.style.display = 'flex';
                        uploadContent.style.display = 'none';
                    } else {
                        uploadContent.style.display = 'flex';
                    }
                }
            });

            // Drag and drop functionality
            dropArea.addEventListener('dragover', (e) => {
                e.preventDefault();
                dropArea.style.borderColor = '#0d6efd';
                dropArea.style.backgroundColor = '#e9ecef';
            });

            dropArea.addEventListener('dragleave', () => {
                dropArea.style.borderColor = '#dee2e6';
                dropArea.style.backgroundColor = '#f8f9fa';
            });

            dropArea.addEventListener('drop', (e) => {
                e.preventDefault();
                dropArea.style.borderColor = '#dee2e6';
                dropArea.style.backgroundColor = '#f8f9fa';

                if (e.dataTransfer.files.length) {
                    const file = e.dataTransfer.files[0];

                    if (!isValidFileType(file)) {
                        alert('Hanya file PNG, WebP, atau SVG yang diizinkan');
                        return;
                    }

                    // Create DataTransfer object and set it to input
                    const dt = new DataTransfer();
                    dt.items.add(file);
                    uploadInput.files = dt.files;

                    // Trigger change event
                    uploadInput.dispatchEvent(new Event('change'));
                }
            });

            // Form validation
            document.querySelector('form').addEventListener('submit', function(e) {
                const requiredFields = this.querySelectorAll('[required]');
                let isValid = true;

                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        isValid = false;
                        field.style.borderColor = '#ef4444';
                        field.style.boxShadow = '0 0 0 3px rgba(239, 68, 68, 0.1)';
                    } else {
                        field.style.borderColor = '#dbdfe9';
                        field.style.boxShadow = 'none';
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    alert('Mohon lengkapi semua field yang wajib diisi!');
                }
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/thur/Documents/Inotive/web-koni/resources/views/admin/cabang-olahraga/edit.blade.php ENDPATH**/ ?>