<?php $__env->startSection('pageTitle', 'Edit Kegiatan Lainnya'); ?>
<?php $__env->startSection('mainSection', 'Laporan Pertanggungjawaban'); ?>
<?php $__env->startSection('subSection', 'Kegiatan Lainnya'); ?>
<?php $__env->startSection('subSectionUrl', route('admin.laporan-lpj.kegiatan-lainnya.index')); ?>
<?php $__env->startSection('currentSection', 'Edit Kegiatan Lainnya'); ?>

<?php $__env->startSection('content'); ?>

    <!-- style yang sudah sama persis dengan sekretariat -->
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
            min-height: 80px;
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
            flex-shrink: 0;
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

        .form-control,
        .form-select {
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 0.95rem;
        }

        .form-control:focus,
        .form-select:focus {
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

        .preview-image {
            max-width: 80px;
            max-height: 80px;
            border-radius: 8px;
            object-fit: cover;
            margin-right: 8px;
            margin-bottom: 8px;
        }

        .file-preview {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }

        .file-item {
            display: flex;
            align-items: center;
            background: #f8f9fa;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 0.85rem;
            color: #495057;
            max-width: 250px;
        }

        .file-item i {
            margin-right: 8px;
            color: #6c757d;
        }

        .file-name {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            flex: 1;
        }

        .file-counter {
            background: #007bff;
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 0.75rem;
            margin-left: 8px;
        }

        .current-files-container {
            margin-bottom: 16px;
            padding: 12px;
            background-color: #f8f9fa;
            border-radius: 8px;
            border: 1px solid #dee2e6;
        }

        .current-files-title {
            font-size: 0.9rem;
            font-weight: 600;
            color: #495057;
            margin-bottom: 8px;
        }

        .current-file-item {
            display: flex;
            align-items: center;
            padding: 8px;
            background: white;
            border-radius: 6px;
            border: 1px solid #e9ecef;
            margin-bottom: 8px;
        }

        .current-file-item:last-child {
            margin-bottom: 0;
        }
    </style>

    <div class="d-flex justify-content-between align-items-center flex-wrap mb-4" style="padding: 20px 20px">
        <h3 class="fw-bold fs-2 mb-0 text-dark">Edit Kegiatan Lainnya</h3>
    </div>

    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="card card-form">
                    <div class="card-body p-4 p-md-5">
                        <h3 class="fw-bold mb-4">Edit Data</h3>
                        <form action="<?php echo e(route('admin.laporan-lpj.kegiatan-lainnya.update', $kegiatanLainnya->id)); ?>"
                            method="POST" enctype="multipart/form-data" id="kegiatan-form">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>

                            <!-- Foto Jurnal Upload -->
                            <div class="row align-items-start mb-4">
                                <div class="col-md-3">
                                    <label class="form-label">Foto Jurnal</label>
                                    <p class="file-upload-hint">Maksimal 10 foto, masing-masing hingga 10 MB</p>
                                </div>
                                <div class="col-md-9">
                                    <?php if($kegiatanLainnya->foto_jurnal): ?>
                                        <div class="current-files-container" id="currentFotoContainer">
                                            <div class="current-files-title">Foto Saat Ini:</div>
                                            <div class="d-flex flex-wrap gap-2">
                                                <?php if(is_array($kegiatanLainnya->foto_jurnal)): ?>
                                                    <?php $__currentLoopData = $kegiatanLainnya->foto_jurnal; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $foto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <div class="current-file-item">
                                                            <img src="<?php echo e(asset('storage/' . $foto)); ?>"
                                                                class="preview-image me-2"
                                                                alt="Current Image <?php echo e($index + 1); ?>">
                                                            <div>
                                                                <small class="text-muted d-block">Foto
                                                                    <?php echo e($index + 1); ?></small>
                                                                <a href="<?php echo e(asset('storage/' . $foto)); ?>" target="_blank"
                                                                    class="text-decoration-none small">
                                                                    Lihat foto
                                                                </a>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php else: ?>
                                                    <div class="current-file-item">
                                                        <img src="<?php echo e(asset('storage/' . $kegiatanLainnya->foto_jurnal)); ?>"
                                                            class="preview-image me-2" alt="Current Image">
                                                        <div>
                                                            <small class="text-muted d-block">Foto saat ini</small>
                                                            <a href="<?php echo e(asset('storage/' . $kegiatanLainnya->foto_jurnal)); ?>"
                                                                target="_blank" class="text-decoration-none small">
                                                                Lihat foto
                                                            </a>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <label for="foto_jurnal" class="file-upload-wrapper">
                                        <input type="file" name="foto_jurnal[]" id="foto_jurnal"
                                            class="<?php $__errorArgs = ['foto_jurnal'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            accept="image/jpeg,image/jpg,image/png,image/gif" multiple
                                            <?php echo e(!$kegiatanLainnya->foto_jurnal ? 'required' : ''); ?>>

                                        <div class="d-flex align-items-center gap-12 w-100">
                                            <div class="file-upload-icon-wrapper">
                                                <i class="fas fa-upload file-upload-icon"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <p class="file-upload-text" id="foto-file-name-display">
                                                    <?php echo e($kegiatanLainnya->foto_jurnal ? 'Klik untuk mengganti foto' : 'Seret dan lepas foto di sini, atau klik untuk mengunggah'); ?>

                                                </p>
                                                <div id="fotoPreviewContainer" class="file-preview"></div>
                                            </div>
                                        </div>
                                    </label>

                                    <?php $__errorArgs = ['foto_jurnal'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <?php $__errorArgs = ['foto_jurnal.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <?php if(!$kegiatanLainnya->foto_jurnal && $errors->has('foto_jurnal') && !$errors->has('foto_jurnal.*')): ?>
                                        <div class="invalid-feedback d-block">Foto jurnal wajib diisi.</div>
                                    <?php endif; ?>
                                    <?php if($errors->has('foto_jurnal') && !$errors->has('foto_jurnal.*') && $kegiatanLainnya->foto_jurnal): ?>
                                        <div class="invalid-feedback d-block"><?php echo e($errors->first('foto_jurnal')); ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Dokumen Pendukung Upload -->
                            <div class="row align-items-start mb-4">
                                <div class="col-md-3">
                                    <label class="form-label">Dokumen Pendukung</label>
                                    <p class="file-upload-hint">Maksimal 10 dokumen, masing-masing hingga 10MB</p>
                                </div>
                                <div class="col-md-9">
                                    <?php if($kegiatanLainnya->dokumen_lpj): ?>
                                        <div class="current-files-container" id="currentDokumenContainer">
                                            <div class="current-files-title">Dokumen Saat Ini:</div>
                                            <div class="d-flex flex-wrap gap-2">
                                                <?php if(is_array($kegiatanLainnya->dokumen_lpj)): ?>
                                                    <?php $__currentLoopData = $kegiatanLainnya->dokumen_lpj; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $dokumen): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <div class="current-file-item">
                                                            <i class="fas fa-file-alt me-2 text-primary"
                                                                style="font-size: 1.5rem;"></i>
                                                            <div>
                                                                <small class="text-muted d-block">Dokumen
                                                                    <?php echo e($index + 1); ?></small>
                                                                <a href="<?php echo e(asset('storage/' . $dokumen)); ?>"
                                                                    target="_blank" class="text-decoration-none small">
                                                                    <?php echo e(basename($dokumen)); ?>

                                                                </a>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php else: ?>
                                                    <div class="current-file-item">
                                                        <i class="fas fa-file-alt me-2 text-primary"
                                                            style="font-size: 1.5rem;"></i>
                                                        <div>
                                                            <small class="text-muted d-block">File saat ini:</small>
                                                            <a href="<?php echo e(asset('storage/' . $kegiatanLainnya->dokumen_lpj)); ?>"
                                                                target="_blank" class="text-decoration-none small">
                                                                <?php echo e(basename($kegiatanLainnya->dokumen_lpj)); ?>

                                                            </a>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <label for="dokumen_pendukung" class="file-upload-wrapper">
                                        <input type="file" name="dokumen_pendukung[]" id="dokumen_pendukung"
                                            class="form-control <?php $__errorArgs = ['dokumen_pendukung'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            accept=".pdf,.doc,.docx,.xls,.xlsx" multiple>

                                        <div class="d-flex align-items-center gap-12 w-100">
                                            <div class="file-upload-icon-wrapper">
                                                <i class="fas fa-upload file-upload-icon"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <p class="file-upload-text" id="dokumen-file-name-display">
                                                    <?php echo e($kegiatanLainnya->dokumen_lpj ? 'Klik untuk mengganti dokumen' : 'Seret dan lepas dokumen di sini, atau klik untuk mengunggah'); ?>

                                                </p>
                                                <div id="dokumenPreviewContainer" class="file-preview"></div>
                                            </div>
                                        </div>
                                    </label>

                                    <?php $__errorArgs = ['dokumen_pendukung'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <?php $__errorArgs = ['dokumen_pendukung.*'];
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
                                    'nama_program_kegiatan' => [
                                        'label' => 'Nama Program',
                                        'type' => 'text',
                                        'placeholder' => 'Masukkan nama program',
                                        'db_field' => 'nama_program', // Mapping ke field database
                                    ],
                                    'jenis_kegiatan' => [
                                        'label' => 'Nama Kegiatan',
                                        'type' => 'text',
                                        'placeholder' => 'Contoh: Rapat, Pelatihan, Pembelian',
                                        'db_field' => 'nama_kegiatan', // Mapping ke field database
                                    ],
                                    'volume' => [
                                        'label' => 'Volume',
                                        'type' => 'text',
                                        'placeholder' => 'Contoh: 5 unit, 1 kegiatan',
                                        'db_field' => 'volume',
                                    ],
                                    'jumlah_harga_satuan' => [
                                        'label' => 'Jumlah Harga Satuan',
                                        'type' => 'text',
                                        'placeholder' => 'Rp 0',
                                        'db_field' => 'jumlah_harga_satuan',
                                    ],
                                    'jumlah_harga' => [
                                        'label' => 'Jumlah Harga',
                                        'type' => 'text',
                                        'placeholder' => 'Rp 0',
                                        'db_field' => 'jumlah_harga',
                                    ],
                                    'keterangan_tambahan' => [
                                        'label' => 'Keterangan Tambahan',
                                        'type' => 'text',
                                        'placeholder' => 'Masukkan keterangan tambahan',
                                        'db_field' => 'keterangan_tambahan',
                                    ],
                                ];
                            ?>

                            <?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="row align-items-center mb-3">
                                    <div class="col-md-3">
                                        <label for="<?php echo e($key); ?>" class="form-label"><?php echo e($field['label']); ?></label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="<?php echo e($field['type']); ?>" name="<?php echo e($key); ?>"
                                            id="<?php echo e($key); ?>"
                                            class="form-control <?php $__errorArgs = [$key];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            placeholder="<?php echo e($field['placeholder'] ?? ''); ?>"
                                            'value="<?php echo e(old($key, $kegiatanLainnya->{$field['db_field']})); ?>"'
                                            <?php echo e(in_array($key, ['nama_program_kegiatan', 'jenis_kegiatan', 'volume', 'jumlah_harga_satuan', 'jumlah_harga']) ? 'required' : ''); ?>>

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
                                <div class="col-md-9 offset-md-3 d-flex justify-content-between">
                                    <button type="submit" class="btn btn-danger px-4">Update Data</button>
                                    <a href="<?php echo e(route('admin.laporan-lpj.kegiatan-lainnya.index')); ?>"
                                        class="btn btn-secondary px-4">Kembali</a>
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
            const fotoUploadInput = document.getElementById('foto_jurnal');
            const fotoPreviewContainer = document.getElementById('fotoPreviewContainer');
            const fotoFileNameDisplay = document.getElementById('foto-file-name-display');
            const currentFotoContainer = document.getElementById('currentFotoContainer');

            fotoUploadInput.addEventListener('change', function() {
                const files = Array.from(this.files);

                if (files.length > 10) {
                    alert('Maksimal 10 foto yang dapat diunggah');
                    this.value = '';
                    return;
                }

                if (files.length > 0) {
                    const validFiles = files.filter(file => {
                        if (!file.type.match('image.*')) {
                            alert(`File ${file.name} bukan gambar yang valid`);
                            return false;
                        }
                        if (file.size > 10 * 1024 * 1024) {
                            alert(`File ${file.name} terlalu besar (maksimal 10MB)`);
                            return false;
                        }
                        return true;
                    });

                    if (validFiles.length !== files.length) {
                        this.value = '';
                        return;
                    }

                    if (currentFotoContainer) {
                        currentFotoContainer.style.display = 'none';
                    }

                    fotoFileNameDisplay.textContent =
                        `${files.length} foto baru dipilih (akan mengganti foto lama)`;

                    fotoPreviewContainer.innerHTML = '';
                    files.forEach((file, index) => {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const imageDiv = document.createElement('div');
                            imageDiv.innerHTML = `
                                <img src="${e.target.result}" class="preview-image" alt="Preview ${index + 1}">
                            `;
                            fotoPreviewContainer.appendChild(imageDiv);
                        };
                        reader.readAsDataURL(file);
                    });
                } else {
                    if (currentFotoContainer) {
                        currentFotoContainer.style.display = 'block';
                    }
                    fotoFileNameDisplay.textContent =
                        '<?php echo e($kegiatanLainnya->foto_jurnal ? 'Klik untuk mengganti foto' : 'Seret dan lepas foto di sini, atau klik untuk mengunggah'); ?>';
                    fotoPreviewContainer.innerHTML = '';
                }
            });

            const dokumenUploadInput = document.getElementById('dokumen_pendukung');
            const dokumenPreviewContainer = document.getElementById('dokumenPreviewContainer');
            const dokumenFileNameDisplay = document.getElementById('dokumen-file-name-display');
            const currentDokumenContainer = document.getElementById('currentDokumenContainer');

            dokumenUploadInput.addEventListener('change', function() {
                const files = Array.from(this.files);

                if (files.length > 10) {
                    alert('Maksimal 10 dokumen yang dapat diunggah');
                    this.value = '';
                    return;
                }

                if (files.length > 0) {
                    const validExtensions = ['pdf', 'doc', 'docx', 'xls', 'xlsx'];
                    const validFiles = files.filter(file => {
                        const extension = file.name.split('.').pop().toLowerCase();
                        if (!validExtensions.includes(extension)) {
                            alert(`File ${file.name} format tidak didukung`);
                            return false;
                        }
                        if (file.size > 10 * 1024 * 1024) {
                            alert(`File ${file.name} terlalu besar (maksimal 10MB)`);
                            return false;
                        }
                        return true;
                    });

                    if (validFiles.length !== files.length) {
                        this.value = '';
                        return;
                    }

                    if (currentDokumenContainer) {
                        currentDokumenContainer.style.display = 'none';
                    }

                    dokumenFileNameDisplay.textContent =
                        `${files.length} dokumen baru dipilih (akan mengganti dokumen lama)`;

                    dokumenPreviewContainer.innerHTML = '';
                    files.forEach((file) => {
                        const fileDiv = document.createElement('div');
                        fileDiv.className = 'file-item';

                        const getFileIcon = (fileName) => {
                            const extension = fileName.split('.').pop().toLowerCase();
                            switch (extension) {
                                case 'pdf':
                                    return 'fas fa-file-pdf';
                                case 'doc':
                                case 'docx':
                                    return 'fas fa-file-word';
                                case 'xls':
                                case 'xlsx':
                                    return 'fas fa-file-excel';
                                default:
                                    return 'fas fa-file-alt';
                            }
                        };

                        fileDiv.innerHTML = `
                            <i class="${getFileIcon(file.name)}"></i>
                            <span class="file-name" title="${file.name}">${file.name}</span>
                        `;
                        dokumenPreviewContainer.appendChild(fileDiv);
                    });
                } else {
                    if (currentDokumenContainer) {
                        currentDokumenContainer.style.display = 'block';
                    }
                    dokumenFileNameDisplay.textContent =
                        '<?php echo e($kegiatanLainnya->dokumen_lpj ? 'Klik untuk mengganti dokumen' : 'Seret dan lepas dokumen di sini, atau klik untuk mengunggah'); ?>';
                    dokumenPreviewContainer.innerHTML = '';
                }
            });

            function setupDragAndDrop(wrapperSelector, inputElement) {
                const wrapper = document.querySelector(wrapperSelector);

                ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                    wrapper.addEventListener(eventName, preventDefaults, false);
                });

                function preventDefaults(e) {
                    e.preventDefault();
                    e.stopPropagation();
                }

                ['dragenter', 'dragover'].forEach(eventName => {
                    wrapper.addEventListener(eventName, () => {
                        wrapper.style.borderColor = '#0d6efd';
                        wrapper.style.backgroundColor = '#e6f0ff';
                    }, false);
                });

                ['dragleave', 'drop'].forEach(eventName => {
                    wrapper.addEventListener(eventName, () => {
                        wrapper.style.borderColor = '#cfe2ff';
                        wrapper.style.backgroundColor = '#edf5ff';
                    }, false);
                });

                wrapper.addEventListener('drop', function(e) {
                    const dt = e.dataTransfer;
                    const files = dt.files;
                    inputElement.files = files;
                    inputElement.dispatchEvent(new Event('change'));
                });
            }

            setupDragAndDrop('label[for="foto_jurnal"]', fotoUploadInput);
            setupDragAndDrop('label[for="dokumen_pendukung"]', dokumenUploadInput);
            
            // Format number fields
            const hargaSatuanInput = document.querySelector('input[name="jumlah_harga_satuan"]');
            const jumlahHargaInput = document.querySelector('input[name="jumlah_harga"]');
            const volumeInput = document.querySelector('input[name="volume"]');
            
            // Format number with thousand separator
            function formatNumber(num) {
                return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            }
            
            // Parse formatted number
            function parseNumber(value) {
                return parseFloat(value.replace(/\./g, '')) || 0;
            }
            
            // Format input as user types
            function formatInput(input) {
                let value = input.value.replace(/\D/g, ''); // Remove non-digit characters
                if (value === '') {
                    input.value = '';
                    return;
                }
                
                // Add thousand separators
                value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                input.value = value;
            }
            
            // Calculate total
            function calculateTotal() {
                if (!hargaSatuanInput || !jumlahHargaInput || !volumeInput) return;
                
                const volume = parseFloat(volumeInput.value) || 0;
                const hargaSatuan = parseNumber(hargaSatuanInput.value);
                const total = hargaSatuan * (volume || 1);
                jumlahHargaInput.value = 'Rp ' + formatNumber(total);
            }
            
            // Initialize formatting for number fields
            if (hargaSatuanInput) {
                // Format initial value
                if (hargaSatuanInput.value) {
                    const initialValue = parseNumber(hargaSatuanInput.value);
                    hargaSatuanInput.value = formatNumber(initialValue);
                }
                
                // Add input event listener
                hargaSatuanInput.addEventListener('input', function() {
                    formatInput(this);
                    calculateTotal();
                });
            }
            
            // Make jumlah_harga readonly
            if (jumlahHargaInput) {
                jumlahHargaInput.readOnly = true;
            }
            
            // Add event listener for volume input
            if (volumeInput) {
                volumeInput.addEventListener('input', calculateTotal);
            }
            
            // Calculate initial total
            calculateTotal();
            
            // Handle form submission
            const form = document.getElementById('kegiatan-form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    // Validasi foto jurnal jika tidak ada foto sebelumnya
                    const fotoInput = document.getElementById('foto_jurnal');
                    const currentFotoContainer = document.getElementById('currentFotoContainer');
                    
                    // Jika tidak ada foto sebelumnya dan tidak ada foto baru yang dipilih
                    if (!currentFotoContainer && fotoInput.files.length === 0) {
                        // Tampilkan pesan error
                        let errorDiv = fotoInput.parentNode.querySelector('.invalid-feedback.d-block');
                        if (!errorDiv) {
                            errorDiv = document.createElement('div');
                            errorDiv.className = 'invalid-feedback d-block';
                            fotoInput.parentNode.appendChild(errorDiv);
                        }
                        errorDiv.textContent = 'Foto jurnal wajib diisi.';
                        fotoInput.classList.add('is-invalid');
                        e.preventDefault();
                        return;
                    }
                    
                    // Prepare data for submission
                    const hargaSatuanInput = document.querySelector('input[name="jumlah_harga_satuan"]');
                    if (hargaSatuanInput) {
                        const hargaSatuanValue = parseNumber(hargaSatuanInput.value);
                        
                        // Create hidden input with numeric value
                        let hiddenHargaSatuan = document.querySelector('input[name="jumlah_harga_satuan"][type="hidden"]');
                        if (!hiddenHargaSatuan) {
                            hiddenHargaSatuan = document.createElement('input');
                            hiddenHargaSatuan.type = 'hidden';
                            hiddenHargaSatuan.name = 'jumlah_harga_satuan';
                            form.appendChild(hiddenHargaSatuan);
                        }
                        hiddenHargaSatuan.value = hargaSatuanValue;
                        
                        // Disable original input to prevent submission
                        hargaSatuanInput.disabled = true;
                    }
                });
                
                // Tampilkan pesan error jika ada error dari server
                const fotoInput = document.getElementById('foto_jurnal');
                const currentFotoContainer = document.getElementById('currentFotoContainer');
                if (fotoInput && !currentFotoContainer) {
                    // Cek apakah ada error dari server
                    const errorElements = form.querySelectorAll('.invalid-feedback.d-block');
                    let hasServerError = false;
                    errorElements.forEach(element => {
                        if (element.textContent.includes('Foto jurnal')) {
                            hasServerError = true;
                            fotoInput.classList.add('is-invalid');
                        }
                    });
                }
            }
        });
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Javier\Documents\GitHub\web-koni\resources\views/admin/laporan-lpj/kegiatan-lainnya/edit.blade.php ENDPATH**/ ?>