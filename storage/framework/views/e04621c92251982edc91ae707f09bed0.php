<?php $__env->startSection('pageTitle', 'Edit Laporan Sport Science'); ?>
<?php $__env->startSection('mainSection', 'Laporan LPJ'); ?>
<?php $__env->startSection('subSection', 'Bidang Bidang'); ?>
<?php $__env->startSection('subSectionUrl', route('admin.laporan-lpj.bidang.index')); ?>
<?php $__env->startSection('subSection2', 'Sport Science & IPTEK'); ?>
<?php $__env->startSection('subSection2Url', route('admin.laporan-lpj.bidang.sport-science.index')); ?>
<?php $__env->startSection('currentSection', 'Edit Laporan Sport Science'); ?>

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

        .file-upload-wrapper.dragover {
            border-color: #0d6efd;
            background-color: #e6f0ff;
            transform: scale(1.02);
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

        .preview-container {
            max-height: 300px;
            overflow-y: auto;
            margin-top: 15px;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 15px;
            background-color: #f8f9fa;
        }

        .file-preview-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            background-color: white;
            margin-bottom: 8px;
            transition: all 0.2s ease;
        }

        .file-preview-item:hover {
            border-color: #0d6efd;
            box-shadow: 0 2px 8px rgba(13, 110, 253, 0.1);
        }

        .file-preview-item:last-child {
            margin-bottom: 0;
        }

        .preview-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 6px;
            border: 1px solid #e9ecef;
        }

        .file-icon {
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa;
            border-radius: 6px;
            border: 1px solid #e9ecef;
        }

        .file-info {
            flex: 1;
        }

        .file-name {
            font-weight: 500;
            color: #212529;
            margin-bottom: 4px;
            word-break: break-all;
        }

        .file-size {
            font-size: 0.8rem;
            color: #6c757d;
        }

        .remove-file {
            background: none;
            border: none;
            color: #dc3545;
            font-size: 1.2rem;
            cursor: pointer;
            padding: 5px;
            border-radius: 4px;
            transition: all 0.2s ease;
        }

        .remove-file:hover {
            background-color: #dc3545;
            color: white;
        }

        .file-counter {
            font-size: 0.85rem;
            color: #6c757d;
            margin-top: 8px;
        }

        .max-files-warning {
            color: #e74c3c;
            font-size: 0.85rem;
            margin-top: 8px;
        }

        .current-files {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            border: 1px solid #e9ecef;
        }

        .current-files h6 {
            color: #495057;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .existing-file-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 8px;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            background-color: white;
            margin-bottom: 6px;
        }

        .existing-file-item:last-child {
            margin-bottom: 0;
        }

        .existing-preview-image {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 4px;
        }

        .existing-file-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa;
            border-radius: 4px;
        }
    </style>

    <div class="d-flex justify-content-between align-items-center flex-wrap mb-4" style="padding: 20px 20px">
        <h3 class="fw-bold fs-2 mb-0 text-dark">Edit Mobilisasi Sumber Daya</h3>
    </div>

    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="card card-form">
                    <div class="card-body p-4 p-md-5">
                        <h3 class="fw-bold mb-4">Edit Data</h3>
                        <form action="<?php echo e(route('admin.laporan-lpj.bidang.sport-science.update', $sportscience->id)); ?>" method="POST"
                            enctype="multipart/form-data" id="sumberDayaEditForm">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>

                            <?php
                                $fields = [
                                    'nama_program' => [
                                        'label' => 'Nama Program',
                                        'type' => 'text',
                                        'placeholder' => 'Masukkan nama program',
                                        'required' => true,
                                    ],
                                    'nama_kegiatan' => [
                                        'label' => 'Nama Kegiatan',
                                        'type' => 'text',
                                        'placeholder' => 'Contoh: Pelatihan, Workshop, Pembelian',
                                        'required' => true,
                                    ],
                                    'volume' => [
                                        'label' => 'Volume',
                                        'type' => 'text',
                                        'placeholder' => 'Masukkan volume kegiatan (contoh: 20 unit, 1 kegiatan)',
                                        'required' => true,
                                    ],
                                    'jumlah_harga_satuan' => [
                                        'label' => 'Jumlah Harga Satuan',
                                        'type' => 'number',
                                        'placeholder' => 'Masukkan jumlah harga satuan',
                                        'required' => true,
                                    ],
                                    'jumlah_harga' => [
                                        'label' => 'Jumlah Harga',
                                        'type' => 'number',
                                        'placeholder' => 'Masukkan jumlah harga',
                                        'required' => true,
                                    ],
                                    'keterangan_tambahan' => [
                                        'label' => 'Keterangan Tambahan',
                                        'type' => 'textarea',
                                        'placeholder' => 'Masukkan keterangan tambahan (opsional)',
                                        'required' => false,
                                    ],
                                ];
                            ?>

                            <?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($key === 'keterangan_tambahan'): ?>
                                
                                <div class="row align-items-start mb-4">
                                    <div class="col-md-3">
                                        <label class="form-label">Foto Jurnal</label>
                                        <p class="file-upload-hint">Maksimal 10 file foto, masing-masing hingga 10 MB</p>
                                    </div>
                                    <div class="col-md-9">
                                        <?php if($sportscience->foto_jurnal && count($sportscience->foto_jurnal) > 0): ?>
                                            <div class="current-files">
                                                <h6>Foto saat ini:</h6>
                                                <div id="existingFotoContainer">
                                                    <?php $__currentLoopData = $sportscience->foto_jurnal; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $foto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <div class="existing-file-item" data-type="foto" data-index="<?php echo e($index); ?>">
                                                            <img src="<?php echo e(asset('storage/' . $foto)); ?>" class="existing-preview-image" alt="Current Image">
                                                            <div class="file-info">
                                                                <div class="file-name"><?php echo e(basename($foto)); ?></div>
                                                                <div class="file-size">File saat ini</div>
                                                            </div>
                                                            <a href="<?php echo e(asset('storage/' . $foto)); ?>" target="_blank" class="btn btn-sm btn-outline-primary me-2">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                            <button type="button" class="remove-file" onclick="removeExistingFile('foto', <?php echo e($index); ?>)">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        </div>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </div>
                                                <input type="hidden" name="existing_foto_jurnal" id="existingFotoInput" value="<?php echo e(json_encode($sportscience->foto_jurnal)); ?>">
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
                                                accept="image/*" multiple>

                                            <div class="d-flex align-items-center gap-12">
                                                <div class="file-upload-icon-wrapper">
                                                    <i class="fas fa-upload file-upload-icon"></i>
                                                </div>
                                                <div>
                                                    <p class="file-upload-text" id="foto-file-name-display">
                                                        Seret dan lepas foto baru di sini, atau klik untuk mengunggah.
                                                    </p>
                                                </div>
                                            </div>
                                        </label>

                                        <div id="fotoPreviewContainer" class="preview-container" style="display: none;"></div>
                                        <div id="fotoCounter" class="file-counter"></div>
                                        <div id="fotoMaxWarning" class="max-files-warning" style="display: none;">
                                            Maksimal 10 foto yang dapat diunggah.
                                        </div>

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
                                    </div>
                                </div>

                                
                                <div class="row align-items-start mb-4">
                                    <div class="col-md-3">
                                        <label class="form-label">Dokumen LPJ</label>
                                        <p class="file-upload-hint">Maksimal 10 file PDF/Office, masing-masing hingga 10MB</p>
                                    </div>
                                    <div class="col-md-9">
                                        <?php if($sportscience->dokumen_lpj && count($sportscience->dokumen_lpj) > 0): ?>
                                            <div class="current-files">
                                                <h6>Dokumen saat ini:</h6>
                                                <div id="existingDokumenContainer">
                                                    <?php $__currentLoopData = $sportscience->dokumen_lpj; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $dokumen): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php
                                                            $extension = pathinfo($dokumen, PATHINFO_EXTENSION);
                                                        ?>
                                                        <div class="existing-file-item" data-type="dokumen" data-index="<?php echo e($index); ?>">
                                                            <div class="existing-file-icon">
                                                                <i class="<?php echo e(getFileIconSport($extension)); ?> <?php echo e(getFileColorSport($extension)); ?>"></i>
                                                            </div>
                                                            <div class="file-info">
                                                                <div class="file-name"><?php echo e(basename($dokumen)); ?></div>
                                                                <div class="file-size">File saat ini</div>
                                                            </div>
                                                            <a href="<?php echo e(asset('storage/' . $dokumen)); ?>" target="_blank" class="btn btn-sm btn-outline-primary me-2">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                            <button type="button" class="remove-file" onclick="removeExistingFile('dokumen', <?php echo e($index); ?>)">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        </div>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </div>
                                                <input type="hidden" name="existing_dokumen_lpj" id="existingDokumenInput" value="<?php echo e(json_encode($sportscience->dokumen_lpj)); ?>">
                                            </div>
                                        <?php endif; ?>

                                        <label for="dokumen_lpj" class="file-upload-wrapper">
                                            <input type="file" name="dokumen_lpj[]" id="dokumen_lpj"
                                                class="form-control <?php $__errorArgs = ['dokumen_lpj'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                accept=".pdf,.doc,.docx,.xls,.xlsx" multiple>

                                            <div class="d-flex align-items-center gap-12">
                                                <div class="file-upload-icon-wrapper">
                                                    <i class="fas fa-upload file-upload-icon"></i>
                                                </div>
                                                <div>
                                                    <p class="file-upload-text" id="dokumen-file-name-display">
                                                        Seret dan lepas dokumen baru di sini, atau klik untuk mengunggah.
                                                    </p>
                                                </div>
                                            </div>
                                        </label>

                                        <div id="dokumenPreviewContainer" class="preview-container" style="display: none;"></div>
                                        <div id="dokumenCounter" class="file-counter"></div>
                                        <div id="dokumenMaxWarning" class="max-files-warning" style="display: none;">
                                            Maksimal 10 dokumen yang dapat diunggah.
                                        </div>

                                        <?php $__errorArgs = ['dokumen_lpj'];
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
                                <?php endif; ?>
                                <div class="row align-items-center mb-3">
                                    <div class="col-md-3">
                                        <label for="<?php echo e($key); ?>" class="form-label">
                                            <?php echo e($field['label']); ?>

                                            <?php if($field['required']): ?>
                                                <span class="text-danger">*</span>
                                            <?php endif; ?>
                                        </label>
                                    </div>
                                    <div class="col-md-9">
                                        <?php if($field['type'] === 'textarea'): ?>
                                            <textarea name="<?php echo e($key); ?>" id="<?php echo e($key); ?>"
                                                class="form-control <?php $__errorArgs = [$key];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                placeholder="<?php echo e($field['placeholder'] ?? ''); ?>"
                                                rows="3"
                                                <?php echo e($field['required'] ? 'required' : ''); ?>><?php echo e(old($key, $sportscience->$key)); ?></textarea>
                                        <?php else: ?>
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
                                                value="<?php echo e(old($key, $sportscience->$key)); ?>"
                                                <?php echo e($field['required'] ? 'required' : ''); ?>

                                                <?php if($field['type'] === 'number'): ?> min="0" step="0.01" <?php endif; ?>>
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
                                <div class="col-md-9 offset-md-3 d-flex justify-content-between">
                                    <button type="submit" class="btn btn-danger px-4">Update Data</button>
                                    <a href="<?php echo e(route('admin.laporan-lpj.bidang.sport-science.index')); ?>"
                                        class="btn btn-secondary px-4">Kembali</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
            function getFileIconSport($extension) {
                $icons = [
                    'pdf' => 'fas fa-file-pdf',
                    'doc' => 'fas fa-file-word',
                    'docx' => 'fas fa-file-word',
                    'xls' => 'fas fa-file-excel',
                    'xlsx' => 'fas fa-file-excel',
                    'ppt' => 'fas fa-file-powerpoint',
                    'pptx' => 'fas fa-file-powerpoint'
                ];
                return $icons[$extension] ?? 'fas fa-file';
            }

            function getFileColorSport($extension) {
                $colors = [
                    'pdf' => 'text-danger',
                    'doc' => 'text-primary',
                    'docx' => 'text-primary',
                    'xls' => 'text-success',
                    'xlsx' => 'text-success',
                    'ppt' => 'text-warning',
                    'pptx' => 'text-warning'
                ];
                return $colors[$extension] ?? 'text-muted';
            }
    ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const MAX_FILES = 10;
            const MAX_FILE_SIZE = 10 * 1024 * 1024; // 10MB

            // File arrays to track selected files
            let selectedFotoFiles = [];
            let selectedDokumenFiles = [];

            // Existing files tracking
            let existingFotoFiles = <?php echo json_encode($sportscience->foto_jurnal ?? [], 15, 512) ?>;
            let existingDokumenFiles = <?php echo json_encode($sportscience->dokumen_lpj ?? [], 15, 512) ?>;

            // Foto Jurnal Upload Handler
            const fotoInput = document.getElementById('foto_jurnal');
            const fotoPreviewContainer = document.getElementById('fotoPreviewContainer');
            const fotoFileNameDisplay = document.getElementById('foto-file-name-display');
            const fotoCounter = document.getElementById('fotoCounter');
            const fotoMaxWarning = document.getElementById('fotoMaxWarning');

            fotoInput.addEventListener('change', function() {
                handleFileSelection(this.files, 'foto');
            });

            // Dokumen LPJ Upload Handler
            const dokumenInput = document.getElementById('dokumen_lpj');
            const dokumenPreviewContainer = document.getElementById('dokumenPreviewContainer');
            const dokumenFileNameDisplay = document.getElementById('dokumen-file-name-display');
            const dokumenCounter = document.getElementById('dokumenCounter');
            const dokumenMaxWarning = document.getElementById('dokumenMaxWarning');

            dokumenInput.addEventListener('change', function() {
                handleFileSelection(this.files, 'dokumen');
            });

            function handleFileSelection(files, type) {
                const isPhoto = type === 'foto';
                const currentFiles = isPhoto ? selectedFotoFiles : selectedDokumenFiles;
                const existingFiles = isPhoto ? existingFotoFiles : existingDokumenFiles;
                const input = isPhoto ? fotoInput : dokumenInput;

                // Convert FileList to Array and filter valid files
                const newFiles = Array.from(files).filter(file => {
                    if (file.size > MAX_FILE_SIZE) {
                        alert(`File "${file.name}" terlalu besar. Maksimal 10MB per file.`);
                        return false;
                    }

                    if (isPhoto && !file.type.match('image.*')) {
                        alert(`File "${file.name}" bukan file gambar yang valid.`);
                        return false;
                    }

                    return true;
                });

                // Check if adding new files would exceed the limit (including existing files)
                const totalFiles = existingFiles.length + currentFiles.length + newFiles.length;
                if (totalFiles > MAX_FILES) {
                    alert(`Maksimal ${MAX_FILES} file dapat diunggah. Anda sudah memiliki ${existingFiles.length + currentFiles.length} file.`);
                    return;
                }

                // Add new files to the current files array
                if (isPhoto) {
                    selectedFotoFiles = [...currentFiles, ...newFiles];
                } else {
                    selectedDokumenFiles = [...currentFiles, ...newFiles];
                }

                updateFilePreview(type);
                updateFileInput(type);
                updateFileCounter(type);
            }

            function updateFilePreview(type) {
                const isPhoto = type === 'foto';
                const files = isPhoto ? selectedFotoFiles : selectedDokumenFiles;
                const container = isPhoto ? fotoPreviewContainer : dokumenPreviewContainer;
                const nameDisplay = isPhoto ? fotoFileNameDisplay : dokumenFileNameDisplay;

                if (files.length === 0) {
                    container.style.display = 'none';
                    nameDisplay.textContent = isPhoto ?
                        'Seret dan lepas foto baru di sini, atau klik untuk mengunggah.' :
                        'Seret dan lepas dokumen baru di sini, atau klik untuk mengunggah.';
                    return;
                }

                container.style.display = 'block';
                nameDisplay.textContent = `${files.length} file baru dipilih`;

                // Generate preview HTML
                let previewHTML = '';
                files.forEach((file, index) => {
                    let fileSize = (file.size / 1024).toFixed(1) + ' KB';
                    if (file.size > 1024 * 1024) {
                        fileSize = (file.size / (1024 * 1024)).toFixed(1) + ' MB';
                    }

                    if (isPhoto) {
                        const imageUrl = URL.createObjectURL(file);
                        previewHTML += `
                            <div class="file-preview-item" data-index="${index}">
                                <img src="${imageUrl}" alt="Preview" class="preview-image">
                                <div class="file-info">
                                    <div class="file-name">${file.name}</div>
                                    <div class="file-size">${fileSize}</div>
                                </div>
                                <button type="button" class="remove-file" onclick="removeNewFile(${index}, '${type}')">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        `;
                    } else {
                        const extension = file.name.split('.').pop().toLowerCase();
                        const iconClass = getFileIcon(extension);
                        const colorClass = getFileColor(extension);

                        previewHTML += `
                            <div class="file-preview-item" data-index="${index}">
                                <div class="file-icon">
                                    <i class="${iconClass} ${colorClass} fs-4"></i>
                                </div>
                                <div class="file-info">
                                    <div class="file-name">${file.name}</div>
                                    <div class="file-size">${fileSize}</div>
                                </div>
                                <button type="button" class="remove-file" onclick="removeNewFile(${index}, '${type}')">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        `;
                    }
                });

                container.innerHTML = previewHTML;
            }

            function updateFileInput(type) {
                const isPhoto = type === 'foto';
                const files = isPhoto ? selectedFotoFiles : selectedDokumenFiles;
                const input = isPhoto ? fotoInput : dokumenInput;

                // Create new FileList using DataTransfer
                const dt = new DataTransfer();
                files.forEach(file => {
                    dt.items.add(file);
                });
                input.files = dt.files;
            }

            function updateFileCounter(type) {
                const isPhoto = type === 'foto';
                const newFiles = isPhoto ? selectedFotoFiles : selectedDokumenFiles;
                const existingFiles = isPhoto ? existingFotoFiles : existingDokumenFiles;
                const counter = isPhoto ? fotoCounter : dokumenCounter;
                const maxWarning = isPhoto ? fotoMaxWarning : dokumenMaxWarning;

                const totalFiles = existingFiles.length + newFiles.length;

                if (totalFiles > 0) {
                    counter.textContent = `Total: ${totalFiles}/${MAX_FILES} file (${existingFiles.length} lama + ${newFiles.length} baru)`;
                } else {
                    counter.textContent = '';
                }

                if (totalFiles >= MAX_FILES) {
                    maxWarning.style.display = 'block';
                } else {
                    maxWarning.style.display = 'none';
                }
            }

            // Global function to remove new files
            window.removeNewFile = function(index, type) {
                const isPhoto = type === 'foto';

                if (isPhoto) {
                    // Revoke object URL to prevent memory leaks for images
                    const file = selectedFotoFiles[index];
                    if (file) {
                        const imgElements = document.querySelectorAll('.preview-image');
                        imgElements.forEach(img => {
                            if (img.src && img.src.startsWith('blob:')) {
                                URL.revokeObjectURL(img.src);
                            }
                        });
                    }
                    selectedFotoFiles.splice(index, 1);
                } else {
                    selectedDokumenFiles.splice(index, 1);
                }

                updateFilePreview(type);
                updateFileInput(type);
                updateFileCounter(type);
            };

            // Global function to remove existing files
            window.removeExistingFile = function(type, index) {
                const isPhoto = type === 'foto';

                if (isPhoto) {
                    existingFotoFiles.splice(index, 1);
                    document.getElementById('existingFotoInput').value = JSON.stringify(existingFotoFiles);
                } else {
                    existingDokumenFiles.splice(index, 1);
                    document.getElementById('existingDokumenInput').value = JSON.stringify(existingDokumenFiles);
                }

                // Remove the item from DOM
                const container = isPhoto ?
                    document.getElementById('existingFotoContainer') :
                    document.getElementById('existingDokumenContainer');

                const items = container.querySelectorAll(`[data-type="${type}"]`);
                items.forEach((item, idx) => {
                    if (idx === index) {
                        item.remove();
                    } else if (idx > index) {
                        // Update data-index for remaining items
                        item.setAttribute('data-index', idx - 1);
                        const removeBtn = item.querySelector('.remove-file');
                        if (removeBtn) {
                            removeBtn.setAttribute('onclick', `removeExistingFile('${type}', ${idx - 1})`);
                        }
                    }
                });

                // Hide current files section if no files left
                if ((isPhoto && existingFotoFiles.length === 0) || (!isPhoto && existingDokumenFiles.length === 0)) {
                    const currentFilesDiv = container.closest('.current-files');
                    if (currentFilesDiv) {
                        currentFilesDiv.style.display = 'none';
                    }
                }

                updateFileCounter(type);
            };

            function getFileIcon(extension) {
                const icons = {
                    'pdf': 'fas fa-file-pdf',
                    'doc': 'fas fa-file-word',
                    'docx': 'fas fa-file-word',
                    'xls': 'fas fa-file-excel',
                    'xlsx': 'fas fa-file-excel',
                    'ppt': 'fas fa-file-powerpoint',
                    'pptx': 'fas fa-file-powerpoint'
                };
                return icons[extension] || 'fas fa-file';
            }

            function getFileColor(extension) {
                const colors = {
                    'pdf': 'text-danger',
                    'doc': 'text-primary',
                    'docx': 'text-primary',
                    'xls': 'text-success',
                    'xlsx': 'text-success',
                    'ppt': 'text-warning',
                    'pptx': 'text-warning'
                };
                return colors[extension] || 'text-muted';
            }

            // Drag and drop functionality
            const fileUploadWrappers = document.querySelectorAll('.file-upload-wrapper');

            fileUploadWrappers.forEach(wrapper => {
                wrapper.addEventListener('dragover', (e) => {
                    e.preventDefault();
                    wrapper.classList.add('dragover');
                });

                wrapper.addEventListener('dragleave', () => {
                    wrapper.classList.remove('dragover');
                });

                wrapper.addEventListener('drop', (e) => {
                    e.preventDefault();
                    wrapper.classList.remove('dragover');

                    const input = wrapper.querySelector('input[type="file"]');
                    if (e.dataTransfer.files.length && input) {
                        const type = input.id === 'foto_jurnal' ? 'foto' : 'dokumen';
                        handleFileSelection(e.dataTransfer.files, type);
                    }
                });
            });

            // Auto-calculate jumlah_harga based on volume and jumlah_harga_satuan
            const volumeInput = document.getElementById('volume');
            const hargaSatuanInput = document.getElementById('jumlah_harga_satuan');
            const jumlahHargaInput = document.getElementById('jumlah_harga');

            function calculateTotal() {
                const volume = parseFloat(volumeInput.value) || 0;
                const hargaSatuan = parseFloat(hargaSatuanInput.value) || 0;
                const total = hargaSatuan * (volume || 1);
                jumlahHargaInput.value = total;
            }

            hargaSatuanInput.addEventListener('input', calculateTotal);
            volumeInput.addEventListener('input', function() {
                const volumeValue = this.value;
                const numericVolume = parseFloat(volumeValue.replace(/[^\d.]/g, ''));
                if (!isNaN(numericVolume)) {
                    calculateTotal();
                }
            });

            // Initialize file counters on page load
            updateFileCounter('foto');
            updateFileCounter('dokumen');
        });
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\ThinkPad\OneDrive\Dokumen\GitHub\web-koni\resources\views/admin/laporan-lpj/bidang/sportscience/edit.blade.php ENDPATH**/ ?>