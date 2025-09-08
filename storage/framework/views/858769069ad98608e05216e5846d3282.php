<?php
    $inputId = $name;
    $previewId = $name . 'PreviewContainer';
    $counterId = $name . 'Counter';
    $warningId = $name . 'MaxWarning';
    $existingInputId = 'existing' . ucfirst(str_replace('_', '', $name)) . 'Input';
    $existingContainerId = 'existing' . ucfirst(str_replace('_', '', $name)) . 'Container';

    $defaultAccept = $type === 'image' ? 'image/*' : '.pdf,.doc,.docx,.xls,.xlsx';
    $acceptAttr = $accept ?? $defaultAccept;

    $defaultHint = $type === 'image'
        ? "Maksimal {$maxFiles} file foto, masing-masing hingga {$maxSize} MB"
        : "Maksimal {$maxFiles} file PDF/Office, masing-masing hingga {$maxSize} MB";
    $hintText = $hint ?? $defaultHint;
?>

<?php
    if (!function_exists('getFileIcon')) {
        function getFileIcon($extension) {
            $icons = [
                'pdf' => 'fas fa-file-pdf',
                'doc' => 'fas fa-file-word',
                'docx' => 'fas fa-file-word',
                'xls' => 'fas fa-file-excel',
                'xlsx' => 'fas fa-file-excel',
                'ppt' => 'fas fa-file-powerpoint',
                'pptx' => 'fas fa-file-powerpoint'
            ];
            return $icons[strtolower($extension)] ?? 'fas fa-file';
        }
    }
    if (!function_exists('getFileColor')) {
        function getFileColor($extension) {
            $colors = [
                'pdf' => 'text-danger',
                'doc' => 'text-primary',
                'docx' => 'text-primary',
                'xls' => 'text-success',
                'xlsx' => 'text-success',
                'ppt' => 'text-warning',
                'pptx' => 'text-warning'
            ];
            return $colors[strtolower($extension)] ?? 'text-muted';
        }
    }
?>

<div class="row align-items-start mb-4">
    <div class="col-md-3">
        <label class="form-label"><?php echo e($label); ?></label>
        <p class="file-upload-hint"><?php echo e($hintText); ?></p>
    </div>
    <div class="col-md-9">
        <?php if(count($existingFiles) > 0): ?>
            <div class="current-files">
                <h6><?php echo e($type === 'image' ? 'Foto' : 'Dokumen'); ?> saat ini:</h6>
                <div id="<?php echo e($existingContainerId); ?>">
                    <?php $__currentLoopData = $existingFiles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $extension = pathinfo($file, PATHINFO_EXTENSION);
                        ?>
                        <div class="existing-file-item" data-type="<?php echo e($name); ?>" data-index="<?php echo e($index); ?>">
                            <?php if($type === 'image'): ?>
                                <img src="<?php echo e(asset('storage/' . $file)); ?>" class="existing-preview-image" alt="Current Image">
                            <?php else: ?>
                                <div class="existing-file-icon">
                                    <i class="<?php echo e(getFileIcon($extension)); ?> <?php echo e(getFileColor($extension)); ?>"></i>
                                </div>
                            <?php endif; ?>
                            <div class="file-info">
                                <div class="file-name"><?php echo e(basename($file)); ?></div>
                                <div class="file-size">File saat ini</div>
                            </div>
                            <a href="<?php echo e(asset('storage/' . $file)); ?>" target="_blank" class="btn btn-sm btn-outline-primary me-2">
                                <i class="fas fa-eye"></i>
                            </a>
                            <button type="button" class="remove-file" onclick="removeExistingFile('<?php echo e($name); ?>', <?php echo e($index); ?>)">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <input type="hidden" name="existing_<?php echo e($name); ?>" id="<?php echo e($existingInputId); ?>" value="<?php echo e(json_encode($existingFiles)); ?>">
            </div>
        <?php endif; ?>

        <label for="<?php echo e($inputId); ?>" class="file-upload-wrapper">
            <input type="file" name="<?php echo e($name); ?>[]" id="<?php echo e($inputId); ?>"
                class="<?php $__errorArgs = [$name];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                accept="<?php echo e($acceptAttr); ?>" multiple>

            <div class="d-flex align-items-center gap-12">
                <div class="file-upload-icon-wrapper">
                    <i class="fas fa-upload file-upload-icon"></i>
                </div>
                <div>
                    <p class="file-upload-text" id="<?php echo e($name); ?>-file-name-display">
                        Seret dan lepas <?php echo e($type === 'image' ? 'foto' : 'dokumen'); ?> baru di sini, atau klik untuk mengunggah.
                    </p>
                </div>
            </div>
        </label>

        <div id="<?php echo e($previewId); ?>" class="preview-container" style="display: none;"></div>
        <div id="<?php echo e($counterId); ?>" class="file-counter"></div>
        <div id="<?php echo e($warningId); ?>" class="max-files-warning" style="display: none;">
            Maksimal <?php echo e($maxFiles); ?> <?php echo e($type === 'image' ? 'foto' : 'dokumen'); ?> yang dapat diunggah.
        </div>

        <?php $__errorArgs = [$name];
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
<?php /**PATH C:\Users\ThinkPad\OneDrive\Dokumen\GitHub\web-koni\resources\views/admin/laporan-lpj/bidang/kesehatan/components/file-upload.blade.php ENDPATH**/ ?>