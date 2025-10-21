<?php $__env->startSection('pageTitle', 'Tambah Kategori'); ?>
<?php $__env->startSection('mainSection', 'Laporan LPJ'); ?>
<?php $__env->startSection('subSection', 'Bidang Bidang'); ?>
<?php $__env->startSection('subSectionUrl', route('admin.laporan-lpj.bidang.index')); ?>
<?php $__env->startSection('currentSection', 'Tambah Kategori'); ?>

<?php $__env->startSection('breadcrumb-items'); ?>
    <?php $__currentLoopData = $breadcrumbs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $breadcrumb): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if($breadcrumb['active']): ?>
            <li class="breadcrumb-item active"><?php echo e($breadcrumb['title']); ?></li>
        <?php else: ?>
            <li class="breadcrumb-item">
                <a href="<?php echo e($breadcrumb['url']); ?>"><?php echo e($breadcrumb['title']); ?></a>
            </li>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php $__env->stopSection(); ?>

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

        .icon-preview {
            font-size: 2rem;
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa;
            border: 2px dashed #dee2e6;
            border-radius: 8px;
            color: #6c757d;
        }

        .icon-preview.selected {
            background-color: #e3f2fd;
            border-color: #2196f3;
            color: #2196f3;
        }

        .icon-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(60px, 1fr));
            gap: 10px;
            max-height: 300px;
            overflow-y: auto;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 8px;
            border: 1px solid #dee2e6;
        }

        .icon-option {
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: white;
            border: 2px solid #dee2e6;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
            font-size: 1.5rem;
            color: #6c757d;
        }

        .icon-option:hover {
            border-color: #2196f3;
            color: #2196f3;
            background-color: #f5f5f5;
        }

        .icon-option.selected {
            border-color: #2196f3;
            background-color: #e3f2fd;
            color: #2196f3;
        }
    </style>

    <div class="d-flex justify-content-between align-items-center flex-wrap mb-4" style="padding: 20px 20px">
        <h3 class="fw-bold fs-2 mb-0 text-dark">Tambah Kategori</h3>
    </div>

    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="card card-form">
                    <div class="card-body p-4 p-md-5">
                        <h3 class="fw-bold mb-4">Tambah Kategori Baru</h3>

                        <?php if($parent): ?>
                            <div class="alert alert-info mb-4">
                                <i class="fas fa-info-circle me-2"></i>
                                Kategori akan ditambahkan sebagai sub-kategori dari:
                                <strong><?php echo e($parent->nama_program); ?></strong>
                            </div>
                        <?php endif; ?>

                        <form action="<?php echo e($parentId ? route('admin.laporan-lpj.bidang.dynamic.child.store-category', $parentId) : route('admin.laporan-lpj.bidang.dynamic.store-category')); ?>"
                              method="POST" id="categoryForm">
                            <?php echo csrf_field(); ?>

                            <div class="row align-items-center mb-3">
                                <div class="col-md-3">
                                    <label for="nama_program" class="form-label">
                                        Nama Program <span class="text-danger">*</span>
                                    </label>
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
                                        placeholder="Masukkan nama program/kategori"
                                        value="<?php echo e(old('nama_program')); ?>" required>
                                    <?php $__errorArgs = ['nama_program'];
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
                                    <label for="nama_kegiatan" class="form-label">
                                        Nama Kegiatan <span class="text-danger">*</span>
                                    </label>
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
                                        placeholder="Masukkan nama kegiatan"
                                        value="<?php echo e(old('nama_kegiatan')); ?>" required>
                                    <?php $__errorArgs = ['nama_kegiatan'];
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
                                    <label for="icon" class="form-label">Icon (Opsional)</label>
                                    <p class="small text-muted">Pilih icon untuk kategori ini</p>
                                </div>
                                <div class="col-md-9">
                                    <div class="d-flex align-items-center gap-3 mb-3">
                                        <div id="icon-preview" class="icon-preview">
                                            <i class="fas fa-folder"></i>
                                        </div>
                                        <div>
                                            <input type="hidden" name="icon" id="selected-icon" value="fas fa-folder">
                                            <p class="mb-0">Preview icon yang dipilih</p>
                                            <small class="text-muted" id="icon-class-display">fas fa-folder</small>
                                        </div>
                                    </div>

                                    <div class="icon-grid" id="icon-selector">
                                        <!-- Icons will be populated by JavaScript -->
                                    </div>
                                </div>
                            </div>

                            <div class="row align-items-center mb-4">
                                <div class="col-md-3">
                                    <label for="keterangan_tambahan" class="form-label">
                                        Keterangan Tambahan
                                    </label>
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
                                        rows="3"><?php echo e(old('keterangan_tambahan')); ?></textarea>
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

                            <div class="row mt-4">
                                <div class="col-md-9 offset-md-3 d-flex justify-content-between">
                                    <button type="submit" class="btn btn-danger px-4">Simpan Kategori</button>
                                    <a href="<?php echo e($parentId ? route('admin.laporan-lpj.bidang.dynamic.child.index', $parentId) : route('admin.laporan-lpj.bidang.dynamic.index')); ?>"
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
            // Available icons for categories
            const availableIcons = [
                'fas fa-folder', 'fas fa-folder-open', 'fas fa-archive', 'fas fa-box',
                'fas fa-briefcase', 'fas fa-clipboard', 'fas fa-file-alt', 'fas fa-tasks',
                'fas fa-project-diagram', 'fas fa-sitemap', 'fas fa-chart-bar', 'fas fa-chart-pie',
                'fas fa-trophy', 'fas fa-medal', 'fas fa-award', 'fas fa-star',
                'fas fa-users', 'fas fa-user-tie', 'fas fa-user-graduate', 'fas fa-chalkboard-teacher',
                'fas fa-dumbbell', 'fas fa-running', 'fas fa-volleyball-ball', 'fas fa-basketball-ball',
                'fas fa-football-ball', 'fas fa-table-tennis', 'fas fa-swimming-pool', 'fas fa-bicycle',
                'fas fa-gavel', 'fas fa-balance-scale', 'fas fa-book', 'fas fa-graduation-cap',
                'fas fa-lightbulb', 'fas fa-rocket', 'fas fa-target', 'fas fa-bullseye',
                'fas fa-cog', 'fas fa-tools', 'fas fa-wrench', 'fas fa-hammer'
            ];

            const iconGrid = document.getElementById('icon-selector');
            const iconPreview = document.getElementById('icon-preview');
            const selectedIconInput = document.getElementById('selected-icon');
            const iconClassDisplay = document.getElementById('icon-class-display');

            // Populate icon grid
            availableIcons.forEach(iconClass => {
                const iconOption = document.createElement('div');
                iconOption.className = 'icon-option';
                iconOption.innerHTML = `<i class="${iconClass}"></i>`;
                iconOption.dataset.icon = iconClass;

                // Set default selection
                if (iconClass === 'fas fa-folder') {
                    iconOption.classList.add('selected');
                }

                iconOption.addEventListener('click', function() {
                    // Remove previous selection
                    document.querySelectorAll('.icon-option').forEach(opt => {
                        opt.classList.remove('selected');
                    });

                    // Add selection to clicked icon
                    this.classList.add('selected');

                    // Update preview
                    const selectedIcon = this.dataset.icon;
                    iconPreview.innerHTML = `<i class="${selectedIcon}"></i>`;
                    iconPreview.classList.add('selected');
                    selectedIconInput.value = selectedIcon;
                    iconClassDisplay.textContent = selectedIcon;
                });

                iconGrid.appendChild(iconOption);
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/thur/Documents/Inotive/web-koni/resources/views/admin/laporan-lpj/bidang_new/dynamic/create-category.blade.php ENDPATH**/ ?>