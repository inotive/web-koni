<?php $__env->startSection('pageTitle', 'Detail Laporan Bendahara'); ?>
<?php $__env->startSection('mainSection', 'Main Menu'); ?>
<?php $__env->startSection('subSection', 'Database Bendahara'); ?>
<?php $__env->startSection('subSectionUrl',route('admin.bendahara.index')); ?>
<?php $__env->startSection('currentSection', 'Detail Laporan'); ?>

<?php $__env->startSection('content'); ?>
    <style>
        body {
            background-color: #f8f9fa;
        }

        .main-content {
            padding: 15px 0;
        }

        .card {
            border: none;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .card-header {
            background: #fff;
            border-bottom: 2px solid #F8285A;
            padding: 20px 25px 18px;
        }

        .card-header h3 {
            margin: 8px 0 4px 0 !important;
            padding: 4px 0;
            font-weight: 600;
            color: #2c3e50;
            font-size: 1.4rem;
            line-height: 1.3;
        }

        .card-body {
            padding: 25px;
            background: #fff;
        }

        .info-grid {
            display: grid;
            grid-template-columns: auto 1fr;
            gap: 15px 20px;
            margin-bottom: 25px;
        }

        .info-label {
            font-weight: 600;
            color: #6c757d;
            font-size: 0.9rem;
            white-space: nowrap;
        }

        .info-value {
            font-size: 0.9rem;
            font-weight: 500;
        }

        /* File Section */
        .file-section {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 6px;
            padding: 20px;
            margin-top: 20px;
        }

        .file-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 15px;
        }

        .file-icon-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }

        /* File type colors */
        .file-info.pdf h6, .file-info.pdf .file-meta,
        .file-icon-circle.pdf { color: #dc3545; background: #dc354510; }

        .file-info.doc h6, .file-info.doc .file-meta,
        .file-icon-circle.doc { color: #0d6efd; background: #0d6efd10; }

        .file-info.excel h6, .file-info.excel .file-meta,
        .file-icon-circle.excel { color: #198754; background: #19875410; }

        .file-info.image h6, .file-info.image .file-meta,
        .file-icon-circle.image { color: #fd7e14; background: #fd7e1410; }

        .file-info.other h6, .file-info.other .file-meta,
        .file-icon-circle.other { color: #6c757d; background: #6c757d10; }

        .file-info h6 {
            margin: 0 0 2px;
            font-weight: 600;
        }

        .file-meta {
            font-size: 0.8rem;
            margin: 0;
            font-weight: 500;
        }

        /* Preview */
        .preview-container {
            background: #fff;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            overflow: hidden;
            margin: 15px 0;
        }

        .preview-header {
            background: #f1f3f4;
            padding: 8px 15px;
            border-bottom: 1px solid #dee2e6;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .preview-content { position: relative; }
        .pdf-viewer { width: 100%; height: 500px; border: none; }
        .image-preview {
            max-width: 100%;
            height: auto;
            margin: 0 auto;
            max-height: 400px;
            object-fit: contain;
        }

        .no-preview {
            padding: 40px 20px;
            text-align: center;
            color: #6c757d;
            background: #f8f9fa;
        }

        .no-preview i { font-size: 32px; margin-bottom: 10px; opacity: 0.4; }
        .no-preview h6 { font-weight: 500; margin: 0 0 5px; }
        .no-preview p { font-size: 0.85rem; margin: 0; opacity: 0.8; }

        /* Buttons */
        .btn-group-actions {
            display: flex;
            gap: 8px;
            justify-content: space-between;
            margin-top: 25px;
        }

        .btn-minimal {
            padding: 8px 16px;
            border-radius: 5px;
            font-size: 0.9rem;
            font-weight: 500;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .btn-back { background: #e9ecef; color: #495057; }
        .btn-back:hover { background: #dee2e6; }

        .btn-download { background: #28a745 !important; color: #fff !important; }
        .btn-download:hover { background: #218838 !important; }

        .btn-edit { background: #ffc107 !important; color: #fff !important; }
        .btn-edit:hover { background: #ffb300 !important; }

        /* Status Badge */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .status-badge.success { background: #d4edda; color: #155724; }
        .status-badge.danger { background: #f8d7da; color: #721c24; }
        .status-badge.warning { background: #fff3cd; color: #856404; }

        /* Loading Overlay */
        .loading-overlay {
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(255, 255, 255, 0.9);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 10;
        }
        .loading-overlay.show { display: flex; }

        /* Responsive */
        @media (max-width: 768px) {
            .card-body { padding: 20px 15px; }
            .info-grid { grid-template-columns: 1fr; gap: 8px; }
            .btn-group-actions { flex-direction: column; }
            .file-header { flex-direction: column; align-items: flex-start; }
            .pdf-viewer { height: 300px; }
            .card-header { padding: 15px 20px 12px; }
            .card-header h3 { font-size: 1.2rem; margin: 6px 0 2px 0 !important; }
        }

        @media (max-width: 576px) {
            .main-content { padding: 10px 0; }
            .card-header { padding: 12px 15px 10px; }
            .card-header h3 { font-size: 1.1rem; margin: 4px 0 2px 0 !important; }
            .file-section { padding: 15px; }
        }

    </style>

    <div class="main-content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12 col-xl-10">
                    <div class="card">
                        <div class="card-header">
                            <h3><?php echo e($laporanBendahara->judul); ?></h3>
                        </div>
                        <div class="card-body">
                            <!-- Basic Information -->
                            <div class="info-grid">
                                <h2 class="info-label fw-bold">Dibuat</h2>
                                <span class="info-value fw-bold"><?php echo e($laporanBendahara->created_at->format('d F Y, H:i')); ?></span>

                                <h2 class="info-label fw-bold">Diperbarui</h2>
                                <span class="info-value fw-bold"><?php echo e($laporanBendahara->updated_at->format('d F Y, H:i')); ?></span>
                            </div>

                            <!-- File Section -->
                            <?php if($laporanBendahara->dokumen): ?>
                                <?php
                                    $filePath = storage_path('app/public/' . $laporanBendahara->dokumen);
                                    $fileExists = file_exists($filePath);
                                    $fileName = basename($laporanBendahara->dokumen);
                                    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                                    $fileSize = $fileExists ? number_format(filesize($filePath) / 1024, 2) : '0';

                                    // Determine file type
                                    $fileType = 'other';
                                    $iconClass = 'fa-file';

                                    if ($fileExtension === 'pdf') {
                                        $fileType = 'pdf';
                                        $iconClass = 'fa-file-pdf';
                                    } elseif (in_array($fileExtension, ['doc', 'docx'])) {
                                        $fileType = 'doc';
                                        $iconClass = 'fa-file-word';
                                    } elseif (in_array($fileExtension, ['xls', 'xlsx'])) {
                                        $fileType = 'excel';
                                        $iconClass = 'fa-file-excel';
                                    } elseif (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg'])) {
                                        $fileType = 'image';
                                        $iconClass = 'fa-file-image';
                                    }
                                ?>

                                <div class="file-section">
                                    <div class="file-header">
                                        <div class="file-icon-circle <?php echo e($fileType); ?>">
                                            <i class="fas <?php echo e($iconClass); ?>"></i>
                                        </div>
                                        <div class="file-info">
                                            <h6><?php echo e($fileName); ?></h6>
                                            <p class="file-meta">
                                                <?php echo e(strtoupper($fileExtension)); ?> • <?php echo e($fileSize); ?> KB •
                                                <?php if($fileExists): ?>
                                                    <span class="status-badge success">
                                                        <i class="fas fa-check-circle"></i> Tersedia
                                                    </span>
                                                <?php else: ?>
                                                    <span class="status-badge danger">
                                                        <i class="fas fa-exclamation-circle"></i> Tidak ditemukan
                                                    </span>
                                                <?php endif; ?>
                                            </p>
                                        </div>
                                    </div>

                                    <?php if($fileExists): ?>
                                        <!-- File Preview -->
                                        <div class="preview-container">
                                            <div class="preview-header">
                                                <i class="fas fa-eye me-1"></i> Preview
                                            </div>
                                            <div class="preview-content">
                                                <div class="loading-overlay">
                                                    <div class="spinner-border text-primary" role="status">
                                                        <span class="visually-hidden">Loading...</span>
                                                    </div>
                                                </div>

                                                <?php if($fileExtension === 'pdf'): ?>
                                                    <iframe src="<?php echo e(asset('storage/' . $laporanBendahara->dokumen)); ?>"
                                                            class="pdf-viewer"
                                                            title="PDF Preview"
                                                            onload="hideLoading(this)">
                                                    </iframe>
                                                <?php elseif(in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif', 'bmp'])): ?>
                                                    <img src="<?php echo e(asset('storage/' . $laporanBendahara->dokumen)); ?>"
                                                         alt="Image Preview"
                                                         class="image-preview"
                                                         onload="hideLoading(this)"
                                                         onerror="showPreviewError(this)">
                                                <?php else: ?>
                                                    <div class="no-preview">
                                                        <i class="fas <?php echo e($iconClass); ?>"></i>
                                                        <h6>Preview tidak tersedia</h6>
                                                        <p>File <?php echo e(strtoupper($fileExtension)); ?> tidak dapat ditampilkan sebagai preview</p>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <div class="preview-container">
                                            <div class="preview-content">
                                                <div class="no-preview">
                                                    <i class="fas fa-exclamation-triangle" style="color: #ffc107;"></i>
                                                    <h6>File tidak ditemukan</h6>
                                                    <p>File dokumen tidak dapat ditemukan di server</p>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php else: ?>
                                <div class="file-section">
                                    <div class="preview-container">
                                        <div class="preview-content">
                                            <div class="no-preview">
                                                <i class="fas fa-file-times"></i>
                                                <h6>Tidak ada dokumen</h6>
                                                <p>Laporan ini belum memiliki dokumen terlampir</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Action Buttons -->
                            <div class="btn-group-actions">
                                <a href="<?php echo e(route('admin.bendahara.index')); ?>" class="btn-minimal btn-back">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>

                                <div class="d-flex gap-2">
                                    <?php if($laporanBendahara->dokumen && file_exists(storage_path('app/public/' . $laporanBendahara->dokumen))): ?>
                                        <a href="<?php echo e(route('admin.bendahara.download', $laporanBendahara->id)); ?>"
                                           class="btn-minimal btn-download" id="downloadBtn">
                                            <i class="fas fa-download" style="color: white"></i> Download
                                        </a>
                                    <?php endif; ?>

                                    <a href="<?php echo e(route('admin.bendahara.edit', $laporanBendahara->id)); ?>"
                                       class="btn-minimal btn-edit">
                                        <i class="fas fa-edit"style="color: white"></i> Edit
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script>
$(document).ready(function() {
    // Show loading overlay for previews
    $('.pdf-viewer, .image-preview').each(function() {
        $(this).closest('.preview-content').find('.loading-overlay').addClass('show');
    });

    // Download button loading state
    $('#downloadBtn').on('click', function(e) {
        const $btn = $(this);
        const originalHtml = $btn.html();

        $btn.html('<i class="fas fa-spinner fa-spin"></i> Downloading...');

        setTimeout(() => {
            $btn.html(originalHtml);
        }, 2000);
    });
});

// Hide loading overlay when content loads
function hideLoading(element) {
    $(element).closest('.preview-content').find('.loading-overlay').removeClass('show');
}

// Show error message when preview fails
function showPreviewError(element) {
    $(element).closest('.preview-content').html(`
        <div class="no-preview">
            <i class="fas fa-exclamation-triangle" style="color: #ffc107;"></i>
            <h6>Preview Error</h6>
            <p>Tidak dapat menampilkan preview file</p>
        </div>
    `);
}

// Handle iframe errors (for PDF)
$(document).on('error', 'iframe.pdf-viewer', function() {
    showPreviewError(this);
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/thur/Documents/Inotive/web-koni/resources/views/admin/bendahara/OLD/show.blade.php ENDPATH**/ ?>