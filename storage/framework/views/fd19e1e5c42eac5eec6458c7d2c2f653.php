<?php $__env->startSection('pageTitle', 'Tambah Prestasi'); ?>
<?php $__env->startSection('mainSection', 'Konfigurasi'); ?>
<?php $__env->startSection('mainSectionUrl', route('admin.konfigurasi.atlet.index')); ?>
<?php $__env->startSection('subSection', 'Prestasi'); ?>
<?php $__env->startSection('subSectionUrl', route('admin.konfigurasi.prestasi.index')); ?>
<?php $__env->startSection('currentSection', 'Tambah Prestasi'); ?>

<?php $__env->startSection('content'); ?>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"
        rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


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

        .form-hint {
            font-size: 0.8rem;
            color: #6c757d;
            margin-top: 4px;
        }

        <style>

        /* Tambahkan style ini */
        .select2-container--bootstrap-5 .select2-selection {
            border-radius: 8px !important;
            padding: 5px 14px !important;
            min-height: 42px !important;
            border: 1px solid #ced4da !important;
        }

        .select2-container--bootstrap-5 .select2-selection:focus {
            border-color: #0d6efd !important;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.2) !important;
        }

        .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
            padding: 0 !important;
            line-height: 1.5 !important;
        }

        .select2-container--bootstrap-5 .select2-selection--single .select2-selection__arrow {
            height: 40px !important;
        }
    </style>
    </style>

    <div class="d-flex justify-content-between align-items-center flex-wrap mb-4" style="padding: 20px 20px">
        <h3 class="fw-bold fs-2 mb-0 text-dark">Tambah Prestasi</h3>
    </div>

    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="card card-form">
                    <div class="card-body p-4 p-md-5">
                        <h3 class="fw-bold mb-4">Tambah Data</h3>
                        <form action="<?php echo e(route('admin.konfigurasi.prestasi.store')); ?>" method="POST">
                            <?php echo csrf_field(); ?>

                            <input type="hidden" name="subject_type" value="atlet">

                            <input type="hidden" name="subject_type" value="atlet">
                            <div class="row align-items-center mb-3">
                                <div class="col-md-3">
                                    <label for="subject_id" class="form-label">Nama Atlet</label>
                                </div>
                                <div class="col-md-9">
                                    <select class="form-select select2-ajax <?php $__errorArgs = ['subject_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="subject_atlet" name="subject_id" required>
                                        <option value="">-- Pilih Atlet --</option>
                                        <?php $__currentLoopData = $atlets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($a->id); ?>"
                                                data-cabor="<?php echo e($a->cabangOlahraga->nama_cabor ?? ''); ?>">
                                                <?php echo e($a->nama); ?> (<?php echo e($a->jenis_kelamin); ?>)
                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php $__errorArgs = ['subject_id'];
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
                                    <label for="kejuaraan" class="form-label">Kejuaraan</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control <?php $__errorArgs = ['kejuaraan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        id="kejuaraan" name="kejuaraan" value="<?php echo e(old('kejuaraan')); ?>" required>
                                    <?php $__errorArgs = ['kejuaraan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <div class="form-hint">Contoh: Kejuaraan Nasional Bulutangkis 2023</div>
                                </div>
                            </div>
                            <div class="row align-items-center mb-3">
                                <div class="col-md-3">
                                    <label for="nama_prestasi" class="form-label">Nama Prestasi</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control <?php $__errorArgs = ['nama_prestasi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        id="nama_prestasi" name="nama_prestasi" value="<?php echo e(old('nama_prestasi')); ?>"
                                        required>
                                    <?php $__errorArgs = ['nama_prestasi'];
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
                                    <label for="cabor" class="form-label">Cabang Olahraga</label>
                                </div>
                                <div class="col-md-9">
                                    <select class="form-select <?php $__errorArgs = ['cabor_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="cabor"
                                        name="cabor_id" required>
                                        <option value="">-- Pilih Cabang Olahraga --</option>
                                        <?php $__currentLoopData = $cabors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cabor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($cabor->id); ?>" <?php if(old('cabor_id') == $cabor->id): echo 'selected'; endif; ?>>
                                                <?php echo e($cabor->nama_cabor); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php $__errorArgs = ['cabor_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <!-- Perbaikan nama error disesuaikan -->
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <div class="row align-items-center mb-3">
                                <div class="col-md-3">
                                    <label for="tingkat" class="form-label">Tingkat Prestasi</label>
                                </div>
                                <div class="col-md-9">
                                    <select class="form-select <?php $__errorArgs = ['tingkat'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="tingkat"
                                        name="tingkat" required>
                                        <option value="">-- Pilih Tingkat --</option>
                                        <option value="Sekolah" <?php if(old('tingkat') == 'Sekolah'): echo 'selected'; endif; ?>>Sekolah</option>
                                        <option value="Kecamatan" <?php if(old('tingkat') == 'Kecamatan'): echo 'selected'; endif; ?>>Kecamatan</option>
                                        <option value="Kabupaten/Kota" <?php if(old('tingkat') == 'Kabupaten/Kota'): echo 'selected'; endif; ?>>Kabupaten/Kota</option>
                                        <option value="Provinsi" <?php if(old('tingkat') == 'Provinsi'): echo 'selected'; endif; ?>>Provinsi</option>
                                        <option value="Nasional" <?php if(old('tingkat') == 'Nasional'): echo 'selected'; endif; ?>>Nasional</option>
                                        <option value="Internasional" <?php if(old('tingkat') == 'Internasional'): echo 'selected'; endif; ?>>Internasional</option>
                                    </select>
                                    <?php $__errorArgs = ['tingkat'];
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
                                    <label for="tempat" class="form-label">Tempat Lomba</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control <?php $__errorArgs = ['tempat'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        id="tempat" name="tempat" value="<?php echo e(old('tempat')); ?>" required>
                                    <?php $__errorArgs = ['tempat'];
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
                                    <label for="tahun" class="form-label">Tahun</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="number" class="form-control <?php $__errorArgs = ['tahun'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        id="tahun" name="tahun" value="<?php echo e(old('tahun', date('Y'))); ?>"
                                        min="1900" max="<?php echo e(date('Y') + 1); ?>" required>
                                    <?php $__errorArgs = ['tahun'];
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
                                    <label for="medali" class="form-label">Medali</label>
                                </div>
                                <div class="col-md-9">
                                    <select class="form-select <?php $__errorArgs = ['medali'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="medali"
                                        name="medali" required>
                                        <option value="">-- Pilih Medali --</option>
                                        <option value="Emas" <?php if(old('medali') == 'Emas'): echo 'selected'; endif; ?>>Emas</option>
                                        <option value="Perak" <?php if(old('medali') == 'Perak'): echo 'selected'; endif; ?>>Perak</option>
                                        <option value="Perunggu" <?php if(old('medali') == 'Perunggu'): echo 'selected'; endif; ?>>Perunggu</option>
                                    </select>
                                    <?php $__errorArgs = ['medali'];
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
                            <a href="<?php echo e(route('admin.konfigurasi.prestasi.index')); ?>"
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
            const atletSelect = $('#subject_atlet');
            const caborInput = $('#cabor');
            const form = document.querySelector('form');

            function updateCabor(selectedOption) {
                if (selectedOption.length && selectedOption.data('cabor')) {
                    const caborName = selectedOption.data('cabor');
                    const caborOption = $('#cabor option').filter(function() {
                        return $(this).text().trim() === caborName;
                    });

                    if (caborOption.length) {
                        caborInput.val(caborOption.val()).trigger('change');
                    } else {
                        caborInput.val('').trigger('change');
                    }
                } else {
                    caborInput.val('').trigger('change');
                }
            }

            // Inisialisasi Select2 untuk atlet
            atletSelect.select2({
                theme: 'bootstrap-5',
                placeholder: 'Cari atlet...',
                allowClear: true,
                width: '100%',
                dropdownParent: $('.card-form')
            });

            // Event listener untuk perubahan pada select atlet
            atletSelect.on('change', function() {
                const selectedValue = $(this).val();

                if (selectedValue) {
                    updateCabor($(this).find(':selected'));
                } else {
                    caborInput.val('').trigger('change');
                }
            });

            // Inisialisasi Select2 untuk cabor
            caborInput.select2({
                theme: 'bootstrap-5',
                placeholder: 'Pilih Cabang Olahraga',
                allowClear: true,
                width: '100%'
            });
        });
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/thur/Documents/Inotive/web-koni/resources/views/admin/prestasi/create.blade.php ENDPATH**/ ?>