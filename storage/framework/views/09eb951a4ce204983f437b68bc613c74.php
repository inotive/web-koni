<?php
    $subSection3Url = '';

    if ($parent?->parent) {
        if ($parent->parent->id == 9) {
            $subSection3Url = route('admin.laporan-lpj.bidang.prestasi.cabor-terukur', [
                'parentId' => $parent->parent->id
            ]);
        }
            elseif ($parent->parent->id == 10) {
                $subSection3Url = route('admin.laporan-lpj.bidang.prestasi.cabor-akurasi', [
                    'parentId' => $parent->parent->id
                ]);
        }
            elseif ($parent->parent->id == 11) {
                $subSection3Url = route('admin.laporan-lpj.bidang.prestasi.cabor-permainan', [
                    'parentId' => $parent->parent->id
                ]);
        }
            elseif ($parent->parent->id == 12) {
                $subSection3Url = route('admin.laporan-lpj.bidang.prestasi.cabor-beladiri', [
                    'parentId' => $parent->parent->id
                ]);
        }
          else {
            // fallback if needed
            $subSection3Url = route('admin.laporan-lpj.bidang.dynamic.index');
        }
    }
?>

<?php $__env->startSection('pageTitle', 'Tambah Laporan LPJ'); ?>
<?php $__env->startSection('mainSection', 'Laporan LPJ'); ?>
<?php $__env->startSection('subSection', 'Bidang Bidang'); ?>
<?php $__env->startSection('subSectionUrl', route('admin.laporan-lpj.bidang.index')); ?>
<?php $__env->startSection('subSection2', $parent?->parent?->parent?->nama_program ?? ''); ?>
<?php $__env->startSection('subSection2Url', route('admin.laporan-lpj.bidang.prestasi.index')); ?>
<?php $__env->startSection('subSection3', $parent?->parent?->nama_program ?? ''); ?>
<?php $__env->startSection('subSection3Url', $subSection3Url); ?>
<?php $__env->startSection('subSection4', $parent?->nama_program ?? ''); ?>
<?php $__env->startSection('subSection4Url', $parent ? route('admin.laporan-lpj.bidang.dynamic.child.index', ['parentId' => $parent->id]) : route('admin.laporan-lpj.bidang.dynamic.index')); ?>
<?php $__env->startSection('currentSection', 'Tambah Laporan'); ?>

<?php $__env->startSection('content'); ?>
<style>
    body { background-color: #f5f5f5 !important; }
    .main-content { background-color: #f5f5f5; min-height: 100vh; padding: 20px 10px 40px; }
    .card-form { background-color: white; border-radius: 12px; border: 1px solid #e9ecef; box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08); }
    .form-control, .form-select { border-radius: 8px; padding: 10px 14px; font-size: 0.95rem; }
    .form-control:focus, .form-select:focus { border-color: #0d6efd; box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.2); }
    .btn-danger { background: linear-gradient(135deg, #F8285A 0%, #e91e63 100%); border: none; border-radius: 8px; padding: 12px 24px; font-weight: 600; font-size: 0.95rem; transition: all 0.3s ease; box-shadow: 0 2px 8px rgba(248, 40, 90, 0.3); }
    .btn-danger:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(248, 40, 90, 0.4); }

    .currency-input { position: relative; }
    .currency-input::before { content: "Rp"; position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #6c757d; font-size: 0.95rem; z-index: 1; }
    .currency-input input { padding-left: 35px; }

    .file-upload-wrapper { display: flex; align-items: center; gap: 12px; border: 1px solid #cfe2ff; background-color: #edf5ff; border-radius: 10px; padding: 16px 20px; cursor: pointer; transition: all 0.2s ease-in-out; }
    .file-upload-wrapper:hover { border-color: #0d6efd; background-color: #e6f0ff; }
    .file-upload-wrapper.dragover { border-color: #0d6efd; background-color: #e6f0ff; transform: scale(1.02); }
    .file-upload-wrapper input[type="file"] { display: none; }
    .file-upload-icon-wrapper { background-color: #d0e7ff; padding: 8px; border-radius: 8px; display: flex; align-items: center; justify-content: center; }
    .file-upload-icon { font-size: 1.5rem; color: #0d6efd; }
    .file-upload-text { margin: 0; font-size: 0.95rem; font-weight: 500; color: #0b153a; }
    .file-upload-hint { font-size: 0.8rem; color: #6c757d; margin-top: 4px; }

    .preview-container { max-height: 300px; overflow-y: auto; margin-top: 15px; border: 1px solid #e9ecef; border-radius: 8px; padding: 15px; background-color: #f8f9fa; }
    .file-preview-item { display: flex; align-items: center; gap: 12px; padding: 10px; border: 1px solid #e9ecef; border-radius: 8px; background-color: white; margin-bottom: 8px; transition: all 0.2s ease; }
    .file-preview-item:hover { border-color: #0d6efd; box-shadow: 0 2px 8px rgba(13, 110, 253, 0.1); }
    .file-preview-item:last-child { margin-bottom: 0; }
    .preview-image { width: 50px; height: 50px; object-fit: cover; border-radius: 6px; border: 1px solid #e9ecef; }
    .file-icon { width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; background-color: #f8f9fa; border-radius: 6px; border: 1px solid #e9ecef; }
    .file-info { flex: 1; }
    .file-name { font-weight: 500; color: #212529; margin-bottom: 4px; word-break: break-all; }
    .file-size { font-size: 0.8rem; color: #6c757d; }
    .remove-file { background: none; border: none; color: #dc3545; font-size: 1.2rem; cursor: pointer; padding: 5px; border-radius: 4px; transition: all 0.2s ease; }
    .remove-file:hover { background-color: #dc3545; color: white; }
    .file-counter { font-size: 0.85rem; color: #6c757d; margin-top: 8px; }
    .max-files-warning { color: #e74c3c; font-size: 0.85rem; margin-top: 8px; }
</style>

<div class="d-flex justify-content-between align-items-center flex-wrap mb-4" style="padding: 20px 20px">
    <h3 class="fw-bold fs-2 mb-0 text-dark">Tambah Laporan LPJ</h3>
</div>

<div class="main-content">
    <div class="container-fluid">
        <div class="row">
            <div class="card card-form">
                <div class="card-body p-4 p-md-5">
                    <h3 class="fw-bold mb-4">Tambah Laporan Baru</h3>

                    <?php if($parent): ?>
                        <div class="alert alert-info mb-4">
                            <i class="fas fa-info-circle me-2"></i>
                            Laporan akan ditambahkan ke dalam kategori: <strong><?php echo e($parent->nama_program); ?></strong>
                        </div>
                    <?php endif; ?>

                    <form action="<?php echo e($parentId ? route('admin.laporan-lpj.bidang.dynamic.child.store', $parentId) : route('admin.laporan-lpj.bidang.dynamic.store')); ?>"
                          method="POST" id="lpjForm" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>

                        
                        <div class="row align-items-center mb-3">
                            <div class="col-md-3">
                                <label for="year" class="form-label">Tahun <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-9">
                                <?php
                                    $currentYear = now()->year;
                                    $startYear = $currentYear - 5;
                                    $endYear = $currentYear + 2;
                                ?>
                                <select name="year" id="year" class="form-select <?php $__errorArgs = ['year'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                    <?php for($y = $endYear; $y >= $startYear; $y--): ?>
                                        <option value="<?php echo e($y); ?>" <?php echo e((int) old('year', $currentYear) === (int) $y ? 'selected' : ''); ?>><?php echo e($y); ?></option>
                                    <?php endfor; ?>
                                </select>
                                <?php $__errorArgs = ['year'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                        <div class="row align-items-center mb-3">
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
                                    placeholder="Masukkan nama program" value="<?php echo e(old('nama_program')); ?>" required>
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

                        <div class="row align-items-center mb-3">
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
                                    placeholder="Masukkan nama kegiatan" value="<?php echo e(old('nama_kegiatan')); ?>" required>
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
                                    class="form-control <?php $__errorArgs = ['volume'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                     value="0">
                                <?php $__errorArgs = ['volume'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            

                        
                        
                                
                                    <input type="hidden" name="jumlah_harga_satuan" id="jumlah_harga_satuan"
                                        class="form-control currency-only <?php $__errorArgs = ['jumlah_harga_satuan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                         value="0">
                                

                        <div class="row align-items-center mb-3">
                            <div class="col-md-3">
                                <label for="jumlah_harga" class="form-label">Total Anggaran</label>
                            </div>
                            <div class="col-md-9">
                                <div class="currency-input">
                                    <input type="text" name="jumlah_harga" id="jumlah_harga"
                                        class="form-control currency-only <?php $__errorArgs = ['jumlah_harga'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        placeholder="0" value="<?php echo e(old('jumlah_harga')); ?>">
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

                        
                        <div class="row align-items-start mb-4">
                            <div class="col-md-3">
                                <label class="form-label">Foto Jurnal</label>
                                <p class="file-upload-hint">Ukuran per file maksimal 10 MB</p>
                            </div>
                            <div class="col-md-9">
                                <label for="foto_jurnal" class="file-upload-wrapper">
                                    <input type="file" name="foto_jurnal[]" id="foto_jurnal" accept="image/*" multiple>
                                    <div class="d-flex align-items-center gap-12">
                                        <div class="file-upload-icon-wrapper">
                                            <i class="fas fa-upload file-upload-icon"></i>
                                        </div>
                                        <div>
                                            <p class="file-upload-text" id="foto_jurnal-file-name-display">
                                                Seret dan lepas foto di sini, atau klik untuk mengunggah.
                                            </p>
                                        </div>
                                    </div>
                                </label>
                                <div id="foto_jurnalPreviewContainer" class="preview-container" style="display: none;"></div>
                                <div id="foto_jurnalCounter" class="file-counter"></div>
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

                        <div class="row align-items-start mb-4">
                            <div class="col-md-3">
                                <label class="form-label">Dokumen pendukung</label>
                                <p class="file-upload-hint">Ukuran per file maksimal 10MB</p>
                            </div>
                            <div class="col-md-9">
                                <label for="dokumen_pendukung" class="file-upload-wrapper">
                                    <input type="file" name="dokumen_pendukung[]" id="dokumen_pendukung" accept=".pdf,.doc,.docx,.xls,.xlsx" multiple>
                                    <div class="d-flex align-items-center gap-12">
                                        <div class="file-upload-icon-wrapper">
                                            <i class="fas fa-upload file-upload-icon"></i>
                                        </div>
                                        <div>
                                            <p class="file-upload-text" id="dokumen_pendukung-file-name-display">
                                                Seret dan lepas dokumen di sini, atau klik untuk mengunggah.
                                            </p>
                                        </div>
                                    </div>
                                </label>
                                <div id="dokumen_pendukungPreviewContainer" class="preview-container" style="display: none;"></div>
                                <div id="dokumen_pendukungCounter" class="file-counter"></div>
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

                        <div class="row align-items-start mb-4">
                            <div class="col-md-3">
                                <label class="form-label">Dokumen LPJ</label>
                                <p class="file-upload-hint">Ukuran per file maksimal 10MB</p>
                            </div>
                            <div class="col-md-9">
                                <label for="dokumen_lpj" class="file-upload-wrapper">
                                    <input type="file" name="dokumen_lpj[]" id="dokumen_lpj" accept=".pdf,.doc,.docx,.xls,.xlsx" multiple>
                                    <div class="d-flex align-items-center gap-12">
                                        <div class="file-upload-icon-wrapper">
                                            <i class="fas fa-upload file-upload-icon"></i>
                                        </div>
                                        <div>
                                            <p class="file-upload-text" id="dokumen_lpj-file-name-display">
                                                Seret dan lepas dokumen di sini, atau klik untuk mengunggah.
                                            </p>
                                        </div>
                                    </div>
                                </label>
                                <div id="dokumen_lpjPreviewContainer" class="preview-container" style="display: none;"></div>
                                <div id="dokumen_lpjCounter" class="file-counter"></div>
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
                                    placeholder="Masukkan keterangan tambahan (opsional)" rows="4"><?php echo e(old('keterangan_tambahan')); ?></textarea>
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
                                <a href="<?php echo e($parentId ? route('admin.laporan-lpj.bidang.dynamic.child.index', $parentId) : route('admin.laporan-lpj.bidang.dynamic.index')); ?>"
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

    let selectedFiles = {
        'foto_jurnal': [],
        'dokumen_lpj': [],
        'dokumen_pendukung': []
    };

    // Fixed Currency Input Handler - Only allows numbers
    function setupCurrencyInput(selector) {
        const inputs = document.querySelectorAll(selector);

        inputs.forEach(input => {
            // Allow only numeric input with proper formatting
            input.addEventListener('input', function(e) {
                // Remove all non-numeric characters
                let value = e.target.value.replace(/[^\d]/g, '');

                // Format with Indonesian number format if there's a value
                if (value) {
                    e.target.value = parseInt(value).toLocaleString('id-ID');
                } else {
                    e.target.value = '';
                }
            });

            // Prevent non-numeric keystrokes
            input.addEventListener('keydown', function(e) {
                const allowedKeys = ['Backspace', 'Tab', 'Delete', 'ArrowLeft', 'ArrowRight', 'Home', 'End'];

                // Allow control keys and numeric keys only
                if (!allowedKeys.includes(e.key) && !/^\d$/.test(e.key)) {
                    e.preventDefault();
                }
            });

            // Handle paste events
            input.addEventListener('paste', function(e) {
                e.preventDefault();
                const paste = (e.clipboardData || window.clipboardData).getData('text');
                const numericValue = paste.replace(/[^\d]/g, '');

                if (numericValue) {
                    e.target.value = parseInt(numericValue).toLocaleString('id-ID');
                    // Trigger input event for any dependent calculations
                    e.target.dispatchEvent(new Event('input', { bubbles: true }));
                }
            });

            // Format initial values
            if (input.value) {
                let value = input.value.replace(/[^\d]/g, '');
                if (value) {
                    input.value = parseInt(value).toLocaleString('id-ID');
                }
            }
        });
    }

    // Initialize currency inputs
    setupCurrencyInput('.currency-only');

    // Volume-based calculation
    function parseVolumeQuantity(volumeText) {
        if (!volumeText || typeof volumeText !== 'string') return 0;

        const numbers = volumeText.match(/\d+/g);
        return numbers ? numbers.reduce((sum, num) => sum + parseInt(num, 10), 0) : 0;
    }

    function calculateTotal() {
        const volumeInput = document.getElementById('volume');
        const unitPriceInput = document.getElementById('jumlah_harga_satuan');
        const totalPriceInput = document.getElementById('jumlah_harga');

        if (!volumeInput || !unitPriceInput || !totalPriceInput) return;

        const volumeValue = volumeInput.value.trim();
        const unitPriceValue = unitPriceInput.value.replace(/[^\d]/g, '');

        const volumeNumber = parseVolumeQuantity(volumeValue);
        const unitPriceNumber = unitPriceValue ? parseInt(unitPriceValue) : 0;

        if (volumeNumber > 0 && unitPriceNumber > 0) {
            const totalPrice = volumeNumber * unitPriceNumber;
            totalPriceInput.value = totalPrice.toLocaleString('id-ID');

            // Visual feedback
            totalPriceInput.style.backgroundColor = '#e8f5e8';
            setTimeout(() => totalPriceInput.style.backgroundColor = '', 1000);
        } else {
            totalPriceInput.value = '';
        }
    }

    // Auto-calculate total when volume or unit price changes
    const volumeInput = document.getElementById('volume');
    const unitPriceInput = document.getElementById('jumlah_harga_satuan');

    if (volumeInput && unitPriceInput) {
        volumeInput.addEventListener('input', calculateTotal);
        unitPriceInput.addEventListener('input', calculateTotal);
        volumeInput.addEventListener('blur', calculateTotal);
        unitPriceInput.addEventListener('blur', calculateTotal);
    }

    // File Upload Handler
    function initFileUpload(inputId) {
        const input = document.getElementById(inputId);
        if (!input) return;

        const previewContainer = document.getElementById(`${inputId}PreviewContainer`);
        const fileNameDisplay = document.getElementById(`${inputId}-file-name-display`);
        const counter = document.getElementById(`${inputId}Counter`);

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
                counter.textContent = '';
                fileNameDisplay.textContent = 'Seret dan lepas file di sini, atau klik untuk mengunggah.';
                return;
            }

            previewContainer.style.display = 'block';
            fileNameDisplay.textContent = `${files.length} file dipilih`;
            counter.textContent = `${files.length} file diupload`;

            let previewHTML = '';
            files.forEach((file, index) => {
                const fileSize = file.size > 1024 * 1024 ?
                    (file.size / (1024 * 1024)).toFixed(1) + ' MB' :
                    (file.size / 1024).toFixed(1) + ' KB';

                if (inputId === 'foto_jurnal') {
                    const imageUrl = URL.createObjectURL(file);
                    previewHTML += `
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
                    const extension = file.name.split('.').pop().toLowerCase();
                    const iconMap = {
                        'pdf': 'fas fa-file-pdf text-danger',
                        'doc': 'fas fa-file-word text-primary',
                        'docx': 'fas fa-file-word text-primary',
                        'xls': 'fas fa-file-excel text-success',
                        'xlsx': 'fas fa-file-excel text-success'
                    };
                    const iconClass = iconMap[extension] || 'fas fa-file text-muted';

                    previewHTML += `
                        <div class="file-preview-item">
                            <div class="file-icon">
                                <i class="${iconClass} fs-4"></i>
                            </div>
                            <div class="file-info">
                                <div class="file-name">${file.name}</div>
                                <div class="file-size">${fileSize}</div>
                            </div>
                            <button type="button" class="remove-file" data-index="${index}" data-input-id="${inputId}">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>`;
                }
            });

            previewContainer.innerHTML = previewHTML;

            previewContainer.querySelectorAll('.remove-file').forEach(button => {
                button.addEventListener('click', function() {
                    const index = parseInt(this.dataset.index);
                    const inputId = this.dataset.inputId;
                    removeFile(index, inputId);
                });
            });
        }

        function updateFileInput(inputId) {
            const files = selectedFiles[inputId];
            const targetInput = document.getElementById(inputId);

            const dt = new DataTransfer();
            files.forEach(file => dt.items.add(file));
            targetInput.files = dt.files;
        }

        function removeFile(index, inputId) {
            selectedFiles[inputId].splice(index, 1);
            updateFilePreview(inputId);
            updateFileInput(inputId);
        }
    }

    // Initialize file uploads
    initFileUpload('foto_jurnal');
    initFileUpload('dokumen_lpj');
    initFileUpload('dokumen_pendukung');

    // Form submission
    document.getElementById('lpjForm').addEventListener('submit', function(e) {
        const requiredFields = this.querySelectorAll('[required]');
        let isValid = true;

        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                isValid = false;
                field.classList.add('is-invalid');
            } else {
                field.classList.remove('is-invalid');
            }
        });

        if (!isValid) {
            e.preventDefault();
            alert('Mohon lengkapi semua field yang wajib diisi!');
            return;
        }

        // Convert formatted currency back to plain numbers for submission
        const currencyFields = document.querySelectorAll('.currency-only');
        currencyFields.forEach(field => {
            if (field.value) {
                field.value = field.value.replace(/[^\d]/g, '');
            }
        });
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/gustibagus/Documents/GitHub/web-koni/resources/views/admin/laporan-lpj/bidang_new/dynamic/create.blade.php ENDPATH**/ ?>