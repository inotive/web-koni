<?php $__env->startSection('pageTitle', 'Edit Laporan Sekretariat'); ?>
<?php $__env->startSection('mainSection', 'Laporan Pertanggungjawaban'); ?>
<?php $__env->startSection('subSection', 'Sekretariat'); ?>
<?php $__env->startSection('subSectionUrl', route('admin.laporan-lpj.sekretariat.index')); ?>
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

        .file-preview-item.existing {
            background-color: #e8f5e8;
            border-color: #28a745;
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

        .existing-files-section {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
        }

        .existing-files-section h6 {
            color: #495057;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .section-divider {
            border: none;
            height: 2px;
            background: linear-gradient(to right, #e9ecef, #dee2e6, #e9ecef);
            margin: 30px 0;
        }
    </style>

    <div class="d-flex justify-content-between align-items-center flex-wrap mb-4" style="padding: 20px 20px">
        <h3 class="fw-bold fs-2 mb-0 text-dark">Edit Laporan Sekretariat</h3>
    </div>

    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="card card-form">
                    <div class="card-body p-4 p-md-5">
                        <h3 class="fw-bold mb-4">Edit Laporan: <?php echo e($sekretariat->nama_program); ?></h3>

                        <form action="<?php echo e(route('admin.laporan-lpj.sekretariat.update', $sekretariat->id)); ?>"
                              method="POST"
                              id="lpjForm"
                              enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>

                            <div class="row align-items-center mb-3">
                                <div class="col-md-3">
                                    <label for="nama_program_kegiatan" class="form-label">
                                        Nama Program & Kegiatan <span class="text-danger">*</span>
                                    </label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" name="nama_program_kegiatan" id="nama_program_kegiatan"
                                        class="form-control <?php $__errorArgs = ['nama_program_kegiatan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        placeholder="Masukkan nama program"
                                        value="<?php echo e(old('nama_program_kegiatan', $sekretariat->nama_program)); ?>" required>
                                    <?php $__errorArgs = ['nama_program_kegiatan'];
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

                            <div class="row align-items-center mb-3">
                                <div class="col-md-3">
                                    <label for="jenis_kegiatan" class="form-label">
                                        Jenis Kegiatan <span class="text-danger">*</span>
                                    </label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" name="jenis_kegiatan" id="jenis_kegiatan"
                                        class="form-control <?php $__errorArgs = ['jenis_kegiatan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        placeholder="Masukkan nama kegiatan"
                                        value="<?php echo e(old('jenis_kegiatan', $sekretariat->nama_kegiatan)); ?>" required>
                                    <?php $__errorArgs = ['jenis_kegiatan'];
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

                            
                            <div style="display: none;">
                                <div class="row align-items-center mb-3">
                                    <div class="col-md-3">
                                        <label for="volume" class="form-label">Volume</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" name="volume" id="volume"
                                            class="form-control <?php $__errorArgs = ['volume'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            placeholder="Masukkan volume (misal: 100 orang, 5 unit, dll)"
                                            value="<?php echo e(old('volume', $sekretariat->volume)); ?>">
                                        <?php $__errorArgs = ['volume'];
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

                                <div class="row align-items-center mb-3">
                                    <div class="col-md-3">
                                        <label for="jumlah_harga_satuan" class="form-label">Harga Satuan</label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="currency-input">
                                            <input type="text" name="jumlah_harga_satuan" id="jumlah_harga_satuan"
                                                class="form-control <?php $__errorArgs = ['jumlah_harga_satuan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                placeholder="0"
                                                value="<?php echo e(old('jumlah_harga_satuan', $sekretariat->jumlah_harga_satuan)); ?>">
                                        </div>
                                        <?php $__errorArgs = ['jumlah_harga_satuan'];
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
                            </div>

                            <div class="row align-items-center mb-3">
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
                                            placeholder="0"
                                            value="<?php echo e(old('jumlah_harga', $sekretariat->jumlah_harga)); ?>">
                                    </div>
                                    <?php $__errorArgs = ['jumlah_harga'];
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

                            <div class="row align-items-start mb-4">
                                <div class="col-md-3">
                                    <label class="form-label">Foto Jurnal</label>
                                    <p class="file-upload-hint">Unggah foto, masing-masing hingga 10 MB</p>
                                </div>
                                <div class="col-md-9">
                                    <?php
                                        $foto_jurnals = $sekretariat->foto_jurnal ? (is_array($sekretariat->foto_jurnal) ? $sekretariat->foto_jurnal : [$sekretariat->foto_jurnal]) : [];
                                    ?>
                                    <?php if(count($foto_jurnals) > 0): ?>
                                        <div class="existing-files-section">
                                            <h6><i class="fas fa-images me-2"></i>Foto yang sudah ada:</h6>
                                            <div id="existing-foto-preview">
                                                <?php $__currentLoopData = $foto_jurnals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $foto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php
                                                        // Handle berbagai tipe data untuk foto
                                                        $path = '';
                                                        $originalName = '';

                                                        if (is_object($foto)) {
                                                            $path = $foto->path;
                                                            $originalName = $foto->original_name ?? basename($path);
                                                        } elseif (is_array($foto)) {
                                                            $path = isset($foto['path']) ? $foto['path'] : '';
                                                            $originalName = isset($foto['original_name']) ? $foto['original_name'] : (is_string($path) ? basename($path) : '');
                                                        } elseif (is_string($foto)) {
                                                            $path = $foto;
                                                            $originalName = basename($path);
                                                        }

                                                        // Pastikan kita punya nama file
                                                        if (empty($originalName) && is_string($path)) {
                                                            $originalName = basename($path);
                                                        }
                                                    ?>
                                                    <div class="file-preview-item existing" data-file-path="<?php echo e($path); ?>">
                                                        <img src="<?php echo e(asset('storage/' . $path)); ?>" alt="Foto <?php echo e($originalName); ?>" class="preview-image">
                                                        <div class="file-info">
                                                            <div class="file-name"><?php echo e($originalName); ?></div>
                                                            <div class="file-size">File yang ada</div>
                                                        </div>
                                                        <button type="button" class="remove-file"
                                                                onclick="removeExistingFile(this, 'foto', '<?php echo e($path); ?>')">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                        <input type="hidden" name="existing_foto_jurnal[]" value="<?php echo e($path); ?>">
                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <label for="foto_jurnal" class="file-upload-wrapper">
                                        <input type="file" name="foto_jurnal[]" id="foto_jurnal"
                                               class="<?php $__errorArgs = ['foto_jurnal.*'];
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

                                    <?php $__errorArgs = ['foto_jurnal.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger mt-2"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <div class="row align-items-start mb-4">
                                <div class="col-md-3">
                                    <label class="form-label">Dokumen Pendukung</label>
                                    <p class="file-upload-hint">Unggah file PDF, masing-masing hingga 10MB</p>
                                </div>
                                <div class="col-md-9">
                                    <?php
                                        $dokumens = $sekretariat->dokumen_lpj ? (is_array($sekretariat->dokumen_lpj) ? $sekretariat->dokumen_lpj : [$sekretariat->dokumen_lpj]) : [];
                                    ?>
                                    <?php if(count($dokumens) > 0): ?>
                                        <div class="existing-files-section">
                                            <h6><i class="fas fa-file-alt me-2"></i>Dokumen yang sudah ada:</h6>
                                            <div id="existing-dokumen-preview">
                                                <?php $__currentLoopData = $dokumens; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $dokumen): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php
                                                        // Handle berbagai tipe data untuk dokumen
                                                        $path = '';
                                                        $originalName = '';

                                                        if (is_object($dokumen)) {
                                                            $path = $dokumen->path;
                                                            $originalName = $dokumen->original_name;
                                                        } elseif (is_array($dokumen)) {
                                                            $path = isset($dokumen['path']) ? $dokumen['path'] : '';
                                                            $originalName = isset($dokumen['original_name']) ? $dokumen['original_name'] : (is_string($path) ? basename($path) : '');
                                                        } elseif (is_string($dokumen)) {
                                                            $path = $dokumen;
                                                            $originalName = basename($path);
                                                        }

                                                        // Pastikan kita punya nama file
                                                        if (empty($originalName) && is_string($path)) {
                                                            $originalName = basename($path);
                                                        }

                                                        $extension = '';
                                                        if (!empty($originalName)) {
                                                            $extension = pathinfo($originalName, PATHINFO_EXTENSION);
                                                        }

                                                        $icon = 'fas fa-file text-secondary';
                                                        if (!empty($extension)) {
                                                            $icon = match(strtolower($extension)) {
                                                                'pdf' => 'fas fa-file-pdf text-danger',
                                                                'doc', 'docx' => 'fas fa-file-word text-primary',
                                                                'xls', 'xlsx' => 'fas fa-file-excel text-success',
                                                                default => 'fas fa-file text-secondary'
                                                            };
                                                        }
                                                    ?>
                                                    <div class="file-preview-item existing" data-file-path="<?php echo e($path); ?>">
                                                        <div class="file-icon">
                                                            <i class="<?php echo e($icon); ?> fs-4"></i>
                                                        </div>
                                                        <div class="file-info">
                                                            <div class="file-name"><?php echo e($originalName); ?></div>
                                                            <div class="file-size">File yang ada</div>
                                                        </div>
                                                        <button type="button" class="remove-file"
                                                                onclick="removeExistingFile(this, 'dokumen', '<?php echo e($path); ?>')">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                        <input type="hidden" name="existing_dokumen_lpj[]" value="<?php echo e($path); ?>">
                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <label for="dokumen_lpj" class="file-upload-wrapper">
                                        <input type="file" name="dokumen_lpj[]" id="dokumen_lpj"
                                               class="<?php $__errorArgs = ['dokumen_lpj.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                               accept=".pdf" multiple>

                                        <div class="d-flex align-items-center gap-12">
                                            <div class="file-upload-icon-wrapper">
                                                <i class="fas fa-upload file-upload-icon"></i>
                                            </div>
                                            <div>
                                                <p class="file-upload-text" id="dokumen-file-name-display">
                                                    Seret dan lepas dokumen PDF baru di sini, atau klik untuk mengunggah.
                                                </p>
                                            </div>
                                        </div>
                                    </label>

                                    <div id="dokumenPreviewContainer" class="preview-container" style="display: none;"></div>
                                    <div id="dokumenCounter" class="file-counter"></div>

                                    <?php $__errorArgs = ['dokumen_lpj.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger mt-2"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            
                            <div class="row align-items-start mb-4">
                                <div class="col-md-3">
                                    <label class="form-label">Dokumen LPJ</label>
                                    <p class="file-upload-hint">Unggah file PDF (opsional), maksimal 10MB</p>
                                </div>
                                <div class="col-md-9">
                                    <?php
                                        $dokumenLpj = $sekretariat->dokumen_lpj_pdf ?? null;
                                    ?>
                                    <?php if($dokumenLpj): ?>
                                        <div class="existing-files-section">
                                            <h6><i class="fas fa-file-pdf me-2 text-danger"></i>Dokumen LPJ yang sudah ada:</h6>
                                            <div id="existing-dokumen-lpj-preview">
                                                <?php
                                                    // Handle berbagai tipe data untuk dokumen LPJ
                                                    $path = '';
                                                    $originalName = '';

                                                    if (is_object($dokumenLpj)) {
                                                        $path = $dokumenLpj->path;
                                                        $originalName = $dokumenLpj->original_name ?? basename($path);
                                                    } elseif (is_array($dokumenLpj)) {
                                                        $path = isset($dokumenLpj['path']) ? $dokumenLpj['path'] : '';
                                                        $originalName = isset($dokumenLpj['original_name']) ? $dokumenLpj['original_name'] : (is_string($path) ? basename($path) : '');
                                                    } elseif (is_string($dokumenLpj)) {
                                                        $path = $dokumenLpj;
                                                        $originalName = basename($path);
                                                    }

                                                    // Pastikan kita punya nama file
                                                    if (empty($originalName) && is_string($path)) {
                                                        $originalName = basename($path);
                                                    }
                                                ?>
                                                <div class="file-preview-item existing" data-file-path="<?php echo e($path); ?>">
                                                    <div class="file-icon">
                                                        <i class="fas fa-file-pdf text-danger fs-4"></i>
                                                    </div>
                                                    <div class="file-info">
                                                        <div class="file-name"><?php echo e($originalName); ?></div>
                                                        <div class="file-size">File yang ada</div>
                                                    </div>
                                                    <button type="button" class="remove-file"
                                                            onclick="removeExistingDokumenLpj(this, '<?php echo e($path); ?>')">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                    <input type="hidden" name="existing_dokumen_lpj_pdf" value="<?php echo e($path); ?>">
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <label for="dokumen_lpj_pdf" class="file-upload-wrapper">
                                        <input type="file" name="dokumen_lpj_pdf" id="dokumen_lpj_pdf"
                                               class="<?php $__errorArgs = ['dokumen_lpj_pdf'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                               accept=".pdf">

                                        <div class="d-flex align-items-center gap-12">
                                            <div class="file-upload-icon-wrapper">
                                                <i class="fas fa-upload file-upload-icon"></i>
                                            </div>
                                            <div>
                                                <p class="file-upload-text" id="dokumen-lpj-file-name-display">
                                                    Seret dan lepas dokumen LPJ di sini, atau klik untuk mengunggah.
                                                </p>
                                            </div>
                                        </div>
                                    </label>

                                    <div id="dokumenLpjPreviewContainer" class="preview-container" style="display: none;"></div>

                                    <?php $__errorArgs = ['dokumen_lpj_pdf'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger mt-2"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <div class="row align-items-start mb-4">
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
                                        placeholder="Masukkan keterangan tambahan (opsional)"
                                        rows="4"><?php echo e(old('keterangan_tambahan', $sekretariat->keterangan_tambahan)); ?></textarea>
                                    <?php $__errorArgs = ['keterangan_tambahan'];
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

                             <div class="row">
                        <div class="col-md-9 offset-md-3 d-flex gap-3">
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-save me-2"></i>Simpan
                            </button>
                            <a href="<?php echo e(route('admin.laporan-lpj.sekretariat.index')); ?>"
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
            const MAX_FILE_SIZE = 10 * 1024 * 1024; // 10MB

            let selectedFotoFiles = [];
            let selectedDokumenFiles = [];
            let selectedDokumenLpjFile = null;

            // Initialize existing files from PHP
            let existingFotoFiles = [];
            let existingDokumenFiles = [];

            // Safely parse existing files
            try {
                existingFotoFiles = <?php echo json_encode($sekretariat->foto_jurnal ? (is_array($sekretariat->foto_jurnal) ? $sekretariat->foto_jurnal : [$sekretariat->foto_jurnal]) : [], 15, 512) ?>;
                existingDokumenFiles = <?php echo json_encode($sekretariat->dokumen_lpj ? (is_array($sekretariat->dokumen_lpj) ? $sekretariat->dokumen_lpj : [$sekretariat->dokumen_lpj]) : [], 15, 512) ?>;
            } catch (e) {
                console.error('Error parsing existing files:', e);
                existingFotoFiles = [];
                existingDokumenFiles = [];
            }

            // Currency formatting
            const currencyInputs = ['jumlah_harga_satuan', 'jumlah_harga'];

            currencyInputs.forEach(inputId => {
                const input = document.getElementById(inputId);
                if (input) {
                    // Format initial value
                    if (input.value) {
                        let value = input.value.replace(/[^\d]/g, '');
                        if (value) {
                            input.value = parseInt(value).toLocaleString('id-ID');
                        }
                    }

                    input.addEventListener('input', function(e) {
                        let value = e.target.value.replace(/[^\d]/g, '');
                        if (value) {
                            e.target.value = parseInt(value).toLocaleString('id-ID');
                        }
                    });
                }
            });

            // File upload handlers
            const fotoInput = document.getElementById('foto_jurnal');
            const fotoPreviewContainer = document.getElementById('fotoPreviewContainer');
            const fotoFileNameDisplay = document.getElementById('foto-file-name-display');
            const fotoCounter = document.getElementById('fotoCounter');

            const dokumenInput = document.getElementById('dokumen_lpj');
            const dokumenPreviewContainer = document.getElementById('dokumenPreviewContainer');
            const dokumenFileNameDisplay = document.getElementById('dokumen-file-name-display');
            const dokumenCounter = document.getElementById('dokumenCounter');
            const dokumenMaxWarning = document.getElementById('dokumenMaxWarning');

            const dokumenLpjInput = document.getElementById('dokumen_lpj_pdf');
            const dokumenLpjFileNameDisplay = document.getElementById('dokumen-lpj-file-name-display');
            const dokumenLpjPreviewContainer = document.getElementById('dokumenLpjPreviewContainer');

            fotoInput.addEventListener('change', function() {
                handleFileSelection(this.files, 'foto');
            });

            dokumenInput.addEventListener('change', function() {
                handleFileSelection(this.files, 'dokumen');
            });

            dokumenLpjInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    if (file.size > MAX_FILE_SIZE) {
                        alert(`File "${file.name}" terlalu besar. Maksimal 10MB.`);
                        this.value = '';
                        return;
                    }

                    if (!file.name.toLowerCase().endsWith('.pdf')) {
                        alert(`File "${file.name}" bukan file PDF yang valid.`);
                        this.value = '';
                        return;
                    }

                    selectedDokumenLpjFile = file;
                    dokumenLpjFileNameDisplay.textContent = file.name;
                    dokumenLpjPreviewContainer.style.display = 'block';

                    // Tampilkan preview dokumen LPJ
                    const previewHTML = `
                        <div class="file-preview-item">
                            <div class="file-icon">
                                <i class="fas fa-file-pdf text-danger fs-4"></i>
                            </div>
                            <div class="file-info">
                                <div class="file-name">${file.name}</div>
                                <div class="file-size">${(file.size / 1024).toFixed(1)} KB</div>
                            </div>
                        </div>
                    `;
                    dokumenLpjPreviewContainer.innerHTML = previewHTML;
                } else {
                    selectedDokumenLpjFile = null;
                    dokumenLpjFileNameDisplay.textContent = 'Seret dan lepas dokumen LPJ di sini, atau klik untuk mengunggah.';
                    dokumenLpjPreviewContainer.style.display = 'none';
                    dokumenLpjPreviewContainer.innerHTML = '';
                }
            });

            function handleFileSelection(files, type) {
                const isPhoto = type === 'foto';
                const currentFiles = isPhoto ? selectedFotoFiles : selectedDokumenFiles;
                const input = isPhoto ? fotoInput : dokumenInput;

                const existingFiles = isPhoto ? existingFotoFiles : existingDokumenFiles;
                const existingFilesCount = existingFiles.length;

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

                if (isPhoto) {
                    selectedFotoFiles.push(...newFiles);
                } else {
                    selectedDokumenFiles.push(...newFiles);
                }

                updateFilePreview(type);
                updateFileInput(type);
            }

            function updateFilePreview(type) {
                const isPhoto = type === 'foto';
                const files = isPhoto ? selectedFotoFiles : selectedDokumenFiles;
                const container = isPhoto ? fotoPreviewContainer : dokumenPreviewContainer;
                const counter = isPhoto ? fotoCounter : dokumenCounter;
                const nameDisplay = isPhoto ? fotoFileNameDisplay : dokumenFileNameDisplay;

                const existingFiles = isPhoto ? existingFotoFiles : existingDokumenFiles;
                const existingFilesCount = existingFiles.length;

                const totalFiles = existingFilesCount + files.length;

                if (files.length === 0) {
                    container.style.display = 'none';
                    counter.textContent = totalFiles > 0 ? `${totalFiles} file` : '';
                    nameDisplay.textContent = isPhoto ?
                        'Seret dan lepas foto baru di sini, atau klik untuk mengunggah.' :
                        'Seret dan lepas dokumen baru di sini, atau klik untuk mengunggah.';
                    return;
                }

                container.style.display = 'block';
                nameDisplay.textContent = `${files.length} file baru dipilih`;
                counter.textContent = `${totalFiles} file`;

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

                const dt = new DataTransfer();
                files.forEach(file => {
                    dt.items.add(file);
                });
                input.files = dt.files;
            }

            window.removeNewFile = function(index, type) {
                const isPhoto = type === 'foto';

                if (isPhoto) {
                    selectedFotoFiles.splice(index, 1);
                } else {
                    selectedDokumenFiles.splice(index, 1);
                }

                updateFilePreview(type);
                updateFileInput(type);
            };

            window.removeExistingFile = function(button, type, filePath) {
                if (confirm('Apakah Anda yakin ingin menghapus file ini? File akan dihapus permanen setelah disimpan.')) {
                    const item = button.closest('.file-preview-item');
                    // Change input name to mark for deletion
                    const hiddenInput = item.querySelector('input[type=hidden]');
                    if (hiddenInput) {
                        hiddenInput.name = `deleted_${type}s[]`;
                    }
                    item.style.display = 'none';

                    const isPhoto = type === 'foto';
                    if (isPhoto) {
                        const index = existingFotoFiles.findIndex(f => {
                            if (typeof f === 'string') return f === filePath;
                            if (typeof f === 'object' && f !== null) return f.path === filePath;
                            return false;
                        });
                        if (index > -1) {
                            existingFotoFiles.splice(index, 1);
                        }
                    } else {
                        const index = existingDokumenFiles.findIndex(d => {
                            if (typeof d === 'string') return d === filePath;
                            if (typeof d === 'object' && d !== null) return d.path === filePath;
                            return false;
                        });
                        if (index > -1) {
                            existingDokumenFiles.splice(index, 1);
                        }
                    }
                }
            };

            window.removeExistingDokumenLpj = function(button, filePath) {
                if (confirm('Apakah Anda yakin ingin menghapus dokumen LPJ ini? File akan dihapus permanen setelah disimpan.')) {
                    const item = button.closest('.file-preview-item');
                    // Change input name to mark for deletion
                    const hiddenInput = item.querySelector('input[type=hidden]');
                    if (hiddenInput) {
                        hiddenInput.name = 'deleted_dokumen_lpj_pdf';
                    }
                    item.style.display = 'none';
                }
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

            // Form submission
            document.getElementById('lpjForm').addEventListener('submit', function(e) {
                currencyInputs.forEach(inputId => {
                    const input = document.getElementById(inputId);
                    if (input && input.value) {
                        // Remove all non-digit characters but preserve the actual value
                        const numericValue = input.value.replace(/[^\d]/g, '');
                        input.value = numericValue;
                    }
                });
            });

            // Volume and price calculation
            const volumeInput = document.getElementById('volume');
            const unitPriceInput = document.getElementById('jumlah_harga_satuan');

            if (volumeInput && unitPriceInput) {
                volumeInput.addEventListener('input', calculateTotalPrice);
                unitPriceInput.addEventListener('input', function() {
                    setTimeout(calculateTotalPrice, 10);
                });

                volumeInput.addEventListener('blur', calculateTotalPrice);
                unitPriceInput.addEventListener('blur', calculateTotalPrice);

                calculateTotalPrice();
            }
        });

        function calculateTotalPrice() {
            // Kalkulasi otomatis dinonaktifkan, total anggaran diisi manual
            return;
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/thur/Documents/Inotive/web-koni/resources/views/admin/laporan-lpj/sekretariat/edit.blade.php ENDPATH**/ ?>