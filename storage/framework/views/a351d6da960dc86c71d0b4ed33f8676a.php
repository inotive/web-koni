<?php $__env->startSection('pageTitle', 'Manajemen Kegiatan Lainnya'); ?>
<?php $__env->startSection('mainSection', 'Laporan Pertanggungjawaban'); ?>
<?php $__env->startSection('currentSection', 'Kegiatan Lainnya'); ?>

<?php $__env->startSection('breadcrumb-title'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb-items'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <style>
        body {
            background-color: #f5f5f5 !important;
        }

        .main-content {
            background-color: #f5f5f5;
            min-height: 100vh;
            padding: 20px 0;
        }

        table td,
        table th {
            vertical-align: middle;
            word-wrap: break-word;
            max-width: 200px;
        }

        .object-fit-cover {
            object-fit: cover;
        }

        .table th:nth-child(1) {
            width: 40px;
        }

        .table th:nth-child(2) {
            width: 250px;
        }

        .table th:nth-child(3) {
            width: 100px;
        }

        .table th:nth-child(4) {
            width: 150px;
        }

        .table th:nth-child(5) {
            width: 150px;
        }

        .table th:nth-child(6) {
            width: 100px;
        }

        .table th:nth-child(7) {
            width: 120px;
        }

        .table th:nth-child(8) {
            width: 80px;
        }

        .text-truncate-custom {
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .dropdown-action {
            position: relative;
            display: inline-block;
        }

        .dropdown-toggle-custom {
            background: none;
            border: none;
            cursor: pointer;
            padding: 5px;
            border-radius: 4px;
            transition: all 0.2s ease;
        }

        .dropdown-toggle-custom:hover {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .dropdown-menu-custom {
            position: absolute;
            right: 0;
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            min-width: 180px;
            padding: 8px 0;
            margin-top: 5px;
            display: none;
            list-style: none;
            /* Ensure dropdown doesn't go outside viewport */
            max-height: 300px;
            overflow-y: auto;
            /* Additional positioning constraints */
            max-width: 90vw;
        }

        .dropdown-menu-custom.show {
            display: block;
            animation: fadeIn 0.2s ease;
        }

        .dropup .dropdown-menu-custom {
            bottom: 100%;
            top: auto;
            margin-top: 0;
            margin-bottom: 5px;
        }

        .dropdown-item-custom {
            padding: 8px 16px;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            color: #495057;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .dropdown-item-custom i {
            margin-right: 8px;
            width: 20px;
            text-align: center;
        }

        .dropdown-item-custom:hover {
            background-color: #f8f9fa;
            text-decoration: none;
            color: #495057;
        }

        .dropdown-item-custom.edit:hover {
            background-color: rgb(249, 245, 172) !important;
        }

        .dropdown-item-custom.delete:hover {
            background-color: #ffcad7 !important;
        }

        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        @media (max-width: 768px) {
            .table-responsive {
                overflow-x: auto !important;
                overflow-y: visible !important;
            }

            .dropdown-menu-custom {
                position: absolute !important;
                z-index: 9999 !important;
                right: 0 !important;
                left: auto !important;
                min-width: 140px;
            }
        }

        .pagination-wrapper .pagination {
            margin-bottom: 0;
        }

        .pagination-wrapper .page-link {
            padding: 0.375rem 0.75rem;
            margin-left: -1px;
            color: #6c757d;
            background-color: #fff;
            border: 1px solid #dee2e6;
        }

        .pagination-wrapper .page-item.active .page-link {
            background-color: #0d6efd;
            border-color: #0d6efd;
            color: #fff;
        }

        .pagination-wrapper .page-link:hover {
            color: #495057;
            background-color: #e9ecef;
            border-color: #dee2e6;
        }

        .loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .custom-tooltip {
            --bs-tooltip-bg: #ffffff;
            --bs-tooltip-border-color: #e0e0e0;
            --bs-tooltip-color: #333333;
            --bs-tooltip-padding-x: 12px;
            --bs-tooltip-padding-y: 8px;
            --bs-tooltip-border-radius: 8px;
            --bs-tooltip-font-size: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            border: 1px solid var(--bs-tooltip-border-color);
        }

        .custom-tooltip .tooltip-inner {
            background-color: var(--bs-tooltip-bg);
            color: var(--bs-tooltip-color);
            border-radius: var(--bs-tooltip-border-radius);
            padding: var(--bs-tooltip-padding-y) var(--bs-tooltip-padding-x);
            text-align: left;
            max-width: 200px;
        }

        .custom-tooltip .tooltip-arrow::before {
            border-bottom-color: var(--bs-tooltip-bg);
            border-top-color: var(--bs-tooltip-bg);
        }

        .tooltip-content strong {
            color: #333333;
            font-weight: 600;
        }

        .btn-restricted {
            cursor: not-allowed !important;
            opacity: 0.6 !important;
            pointer-events: none;
        }

        .btn-restricted:hover {
            background-color: #6c757d !important;
            border-color: #6c757d !important;
            color: white !important;
        }

        .preview-slide {
            display: none;
            width: 100%;
            height: 100%;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 20px;
            position: absolute;
            top: 0;
            left: 0;
        }

        .preview-slide.active {
            display: flex;
        }

        .preview-image {
            max-width: 100%;
            max-height: 80%;
            object-fit: contain;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            background: white;
            padding: 10px;
        }

        .preview-document {
            width: 100%;
            height: 80%;
            border: none;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .document-placeholder {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 80%;
            background: white;
            border: 2px dashed #dee2e6;
            border-radius: 8px;
            text-align: center;
            padding: 40px;
        }

        .document-placeholder i {
            font-size: 4rem;
            color: #6c757d;
            margin-bottom: 1rem;
        }

        .document-placeholder h5 {
            color: #495057;
            margin-bottom: 0.5rem;
        }

        .document-placeholder p {
            color: #6c757d;
            margin-bottom: 1rem;
        }

        .modal-header {
            background-color: white !important;
            color: #333 !important;
            border-bottom: 1px solid #dee2e6 !important;
        }

        .restricted-action {
            position: relative;
        }

        .restricted-action:hover {
            background-color: transparent !important;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        input[type="search"]::-webkit-search-decoration,
        input[type="search"]::-webkit-search-cancel-button,
        input[type="search"]::-webkit-search-results-button,
        input[type="search"]::-webkit-search-results-decoration {
            -webkit-appearance: none;
            appearance: none;
        }

        #ajukanPerubahanBtn {
            background-color: #4CAF50;
            /* Soft green like screenshot */
            color: white;
            font-weight: 600;
            border: none;
            border-radius: 8px;
            /* Rounded corners */
            padding: 8px 14px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            /* for icon if added */
            font-size: 0.9rem;
            transition: all 0.2s ease;
            box-shadow: 0 2px 6px rgba(76, 175, 80, 0.3);
        }

        #ajukanPerubahanBtn:hover {
            background-color: #43a047;
            /* Slightly darker on hover */
            box-shadow: 0 3px 8px rgba(76, 175, 80, 0.4);
            transform: translateY(-1px);
        }

        #ajukanPerubahanBtn:active {
            background-color: #388e3c;
            transform: translateY(0);
            box-shadow: 0 2px 4px rgba(76, 175, 80, 0.3);
        }

        /* Progress bar styling - matching bidang-bidang module */
        .top-progress-wrapper {
            background: white;
            border: 1px solid #e9ecef;
            border-radius: 16px;
            padding: 20px 25px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }

        .info-label {
            font-size: 14px;
            color: #A3AED0;
        }

        .badge.bg-success-subtle {
            background-color: #dcfce7 !important;
            color: #15803d !important;
            border: 1px solid #bbf7d0 !important;
        }

        .badge.bg-primary-subtle {
            background-color: #dbeafe !important;
            color: #1d4ed8 !important;
            border: 1px solid #bfdbfe !important;
        }

        .badge.fw-semibold {
            font-weight: 600 !important;
        }

        /* Styling untuk tombol edit (hanya ikon) */
        #editAnggaranBtn {
            border-color: #0d6efd;
            color: #0d6efd;
            padding: 5px 8px;
        }

        #editAnggaranBtn:hover {
            background-color: #0d6efd;
            color: white;
        }

        #pengajuanModal .modal-dialog {
            max-width: 500px;
            margin: 1.75rem auto;
        }

        #pengajuanModal .modal-content {
            border: none;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        #pengajuanModal .modal-header {
            background: white;
            border-bottom: 1px solid #e9ecef;
            padding: 24px 32px 20px;
            border-radius: 16px 16px 0 0;
        }

        #pengajuanModal .modal-title {
            font-size: 20px;
            font-weight: 600;
            color: #1a1a1a;
            margin: 0;
        }

        #pengajuanModal .btn-close {
            padding: 0;
            margin: 0;
            width: 24px;
            height: 24px;
            background: none;
            border: none;
            opacity: 0.6;
            transition: opacity 0.2s ease;
        }

        #pengajuanModal .btn-close:hover {
            opacity: 1;
        }

        #pengajuanModal .modal-body {
            padding: 32px;
            background: white;
        }

        #pengajuanModal .form-label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 12px;
            font-size: 14px;
        }

        #pengajuanModal .form-control {
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            padding: 12px 16px;
            font-size: 14px;
            line-height: 1.5;
            background-color: #f9fafb;
            transition: all 0.2s ease;
            resize: vertical;
            min-height: 120px;
        }

        #pengajuanModal .form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            background-color: white;
            outline: none;
        }

        #pengajuanModal .form-control::placeholder {
            color: #9ca3af;
            opacity: 1;
        }

        #pengajuanModal .modal-footer {
            padding: 24px 32px 32px;
            background: white;
            border-top: none;
            display: flex;
            justify-content: flex-end;
            gap: 12px;
        }

        #pengajuanModal .btn-secondary {
            background-color: #f3f4f6;
            border: 1px solid #d1d5db;
            color: #374151;
            font-weight: 500;
            padding: 10px 20px;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        #pengajuanModal .btn-secondary:hover {
            background-color: #e5e7eb;
            border-color: #9ca3af;
            color: #1f2937;
        }

        #pengajuanModal .btn-primary {
            background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
            border: none;
            color: white;
            font-weight: 600;
            padding: 10px 24px;
            border-radius: 8px;
            transition: all 0.2s ease;
            box-shadow: 0 2px 4px rgba(34, 197, 94, 0.2);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        #pengajuanModal .btn-primary:hover {
            background: linear-gradient(135deg, #16a34a 0%, #15803d 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(34, 197, 94, 0.3);
        }

        #pengajuanModal .btn-primary:active {
            transform: translateY(0);
            box-shadow: 0 2px 4px rgba(34, 197, 94, 0.2);
        }

        /* Icon untuk tombol konfirmasi */
        #pengajuanModal .btn-primary::before {
            content: "✓";
            font-size: 16px;
            font-weight: bold;
        }

        /* Responsive adjustments */
        @media (max-width: 576px) {
            #pengajuanModal .modal-dialog {
                margin: 0.5rem;
                max-width: calc(100% - 1rem);
            }

            #pengajuanModal .modal-header,
            #pengajuanModal .modal-body,
            #pengajuanModal .modal-footer {
                padding-left: 20px;
                padding-right: 20px;
            }

            #pengajuanModal .btn-close {
                right: 16px;
                top: 16px;
            }

            #pengajuanModal .btn-primary {
                width: 100%;
                max-width: none;
            }
        }

        /* Loading state untuk tombol submit */
        #pengajuanModal .btn-primary.loading {
            pointer-events: none;
            opacity: 0.7;
        }

        #pengajuanModal .btn-primary.loading::before {
            content: "";
            width: 16px;
            height: 16px;
            border: 2px solid transparent;
            border-top: 2px solid currentColor;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>

    <div class="flex-wrap gap-3 mb-4 d-flex justify-content-between align-items-center">
        <div>
            <strong>
                <h1 class="mb-1 fw-bold">Kegiatan Lainnya</h1>
            </strong>
            <h3 class="mb-0 text-muted">Manajemen Laporan Kegiatan Lainnya Anda Sekarang</h3>
        </div>

        <div class="d-flex align-items-center gap-2">
            <!-- Button moved to next to search input -->
        </div>
    </div>

    <div class="mb-4 row g-3">
        <div class="col-12">
            <div class="top-progress-wrapper">
                <div class="mb-3 d-flex justify-content-between align-items-center">
                    <h3 class="mb-0 text-muted">Total Anggaran</h3>
                    <!-- Tombol Edit (hanya ikon) -->
                    <a href="#" class="btn btn-sm btn-outline-primary" id="editAnggaranBtn"
                        title="Edit Target Anggaran">
                        <i class="fas fa-edit"></i>
                    </a>
                </div>

                <?php
                    // Default values - these will be overridden by JavaScript if saved values exist
                    $defaultTargetAnggaran = 200000000000; // 200 miliar
                    $defaultTargetKegiatan = 10;
                    
                    $targetAnggaran = $targetAnggaran ?? $defaultTargetAnggaran;
                    $targetKegiatan = $targetKegiatan ?? $defaultTargetKegiatan;
                    
                    $totalKegiatan = $totalKegiatan ?? ($kegiatanLainnya->total() ?? 0);
                    $kegiatanPercentage = $totalKegiatan > 0 ? min(($totalKegiatan / $targetKegiatan) * 100, 100) : 0;

                    $anggaranPercentage = ($totalAnggaran ?? 0) > 0 ? min((($totalAnggaran ?? 0) / $targetAnggaran) * 100, 100) : 0;
                    
                    // Format percentage display to match bidang-bidang module
                    $anggaranPercentageDisplay = 0;
                    if ($anggaranPercentage > 0 && $anggaranPercentage < 1) {
                        $anggaranPercentageDisplay = number_format($anggaranPercentage, 1, '.', '');
                    } else {
                        $anggaranPercentageDisplay = round($anggaranPercentage);
                    }
                ?>

                <div class="mb-2 d-flex justify-content-between">
                    <h1 id="anggaranDisplay" class="mb-1 fw-bold">Rp. <?php echo e(number_format($totalAnggaran ?? 0, 0, ',', '.')); ?>

                        / Rp. <?php echo e(number_format($targetAnggaran, 0, ',', '.')); ?></h1>
                    <h3 id="anggaranPercentage" class="text-muted mb-0" data-bs-toggle="tooltip"
                        title="<?php echo e(number_format($anggaranPercentage, 2, '.', '')); ?>% dari total anggaran">
                        <?php echo e($anggaranPercentageDisplay); ?>%
                    </h3>
                </div>

                <!-- Hidden inputs to store default values for JavaScript -->
                <input type="hidden" id="defaultTargetAnggaran" value="<?php echo e($defaultTargetAnggaran); ?>">
                <input type="hidden" id="defaultTargetKegiatan" value="<?php echo e($defaultTargetKegiatan); ?>">

                <div class="progress" style="height: 18px; border-radius: 12px; background-color: #f1f1f1;">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                        style="width: <?php echo e($anggaranPercentage); ?>%; background-color: #F8285A; border-radius: 12px;"
                        aria-valuenow="<?php echo e($anggaranPercentage); ?>" aria-valuemin="0" aria-valuemax="100">
                    </div>
                </div>

                <div class="flex-row-reverse mt-2 d-flex bd-highlight">
                    <div class="gap-2 mt-1 info-label d-flex align-items-center">
                        <span
                            class="px-3 py-1 border badge bg-success-subtle text-success fw-semibold border-success-subtle">
                            <span id="kegiatanBerjalan"><?php echo e($totalKegiatan); ?></span> Kegiatan Berjalan
                        </span>
                        <span>/</span>
                        <span
                            class="px-3 py-1 border badge bg-primary-subtle text-primary fw-semibold border-primary-subtle">
                            <?php echo e($targetKegiatan); ?> Target Kegiatan
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="flex-wrap py-5 card-header d-flex justify-content-between align-items-center">
            <h3 class="mb-0 card-title fw-bold fs-4">Daftar Kegiatan Lainnya - 2025</h3>

            <div class="d-flex align-items-center gap-2 flex-wrap">
                <a href="<?php echo e(route('admin.laporan-lpj.kegiatan-lainnya.create')); ?>" class="btn btn-primary"
                    style="background-color: #F8285A !important; color: white !important; border-color: #F8285A !important;">
                    <i class="ki-duotone ki-plus fs-2" style="color: white !important;"></i>Tambah Laporan
                </a>
                
                <div class="input-group position-relative" style="width: 250px;">
                    <input type="search" name="search" id="search" class="form-control" placeholder="Cari kegiatan..."
                        value="<?php echo e(request('search')); ?>" autocomplete="off">

                    <button class="btn btn-outline-secondary search-clear-btn d-none" type="button" id="clear-search"
                        style="position: absolute; right: 55px; z-index: 10; border: none; background: transparent; padding: 8px;">
                        <i class="fas fa-times text-muted"></i>
                    </button>

                    <button class="btn btn-outline-secondary" type="button" id="search-button">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="card-body position-relative">
            <div class="loading-overlay d-none" id="loading-overlay">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>

            <div id="table-container">
                <?php echo $__env->make('admin.laporan-lpj.kegiatan-lainnya._table', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>
    </div>

    <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header"
                    style="background: white; color: #333; border-bottom: 1px solid #dee2e6 !important;">
                    <h5 class="modal-title" id="previewModalLabel" style="color: #333 !important;">Preview Files</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="p-0 modal-body" style="height: 70vh;">
                    <div class="preview-container h-100 position-relative d-flex align-items-center justify-content-center"
                        style="background: #f8f9fa;">
                        <div id="previewSlides" class="w-100 h-100"></div>

                        <button type="button" id="prevBtn"
                            class="btn btn-primary position-absolute start-0 top-50 translate-middle-y ms-3"
                            style="z-index: 10; display: none;">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button type="button" id="nextBtn"
                            class="btn btn-primary position-absolute end-0 top-50 translate-middle-y me-3"
                            style="z-index: 10; display: none;">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <div class="d-flex justify-content-between align-items-center w-100">
                        <div>
                            <strong id="currentFileName">File Name</strong>
                            <div class="text-muted small" id="fileCounter">1 of 1</div>
                        </div>
                        <div>
                            <button type="button" id="downloadBtn" class="btn btn-success btn-sm me-2">
                                <i class="fas fa-download"></i> Download
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Detail Card -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center"
                    style="background: white; color: #333; border-bottom: 1px solid #dee2e6 !important;">
                    <h5 class="modal-title" id="detailModalLabel" style="color: #333 !important;">Detail Kegiatan</h5>
                    <!-- Status Icon -->
                    <div id="statusIconContainer" class="d-flex align-items-center ms-2">
                        <span id="statusIcon" class="badge fs-7 d-flex align-items-center"
                            style="padding: 6px 10px;"></span>
                    </div>
                    <!-- Tombol Export -->
                    <div class="gap-2 ms-auto d-flex align-items-center">
                        <a href="#" id="exportBtn" class="btn btn-success btn-sm" target="_blank">
                            <i class="fas fa-file-pdf me-1"></i> Export PDF
                        </a>

                        <button type="button" id="ajukanPerubahanBtn">
                            <i class="bi bi-arrow-repeat" style="color: white"></i> <strong>Ajukan Perubahan</strong>
                        </button>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                </div>
                <div class="modal-body" id="detailModalBody">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    
    <div class="modal fade" id="pengajuanModal" tabindex="-1" aria-labelledby="pengajuanModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pengajuanModalLabel">Pengajuan Perubahan</h5>
                    <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal" aria-label="Close"
                        style="border: none; background: transparent;">
                        <i class="fas fa-times text-dark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="pengajuanForm">
                        <input type="hidden" id="pengajuan_lpj_id" name="lpj_id">
                        <div class="mb-2">
                            <label for="alasan" class="form-label">Keterangan Perubahan</label>
                            <textarea class="form-control" id="alasan" name="alasan" rows="2"
                                placeholder="Silahkan mengisi keterangan perubahan dengan jelas" required></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary w-100 d-flex justify-content-center align-items-center"
                        id="submitPengajuanBtn">
                        Kirim Pengajuan
                    </button>
                </div>
            </div>
        </div>
    </div>

    
    <div class="modal fade" id="editAnggaranModal" tabindex="-1" aria-labelledby="editAnggaranModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="gap-5 px-10 py-8 modal-content rounded-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="leading-5 fs-2 fw-bold">Edit Target Anggaran & Kegiatan</div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="editAnggaranForm" class="gap-4 d-grid">
                    <div>
                        <div class="mb-3 text-gray-800 fw-semibold required">Target Anggaran</div>
                        <input type="text" name="target_anggaran" id="target_anggaran"
                            value="<?php echo e(number_format($targetAnggaran ?? 200000000000, 0, ',', '.')); ?>"
                            placeholder="Masukkan target anggaran" class="form-control bg-light border border-gray-400"
                            required data-original-value="<?php echo e($targetAnggaran ?? 200000000000); ?>" />
                        <div class="invalid-feedback"></div>
                    </div>

                    <div>
                        <div class="mb-3 text-gray-800 fw-semibold required">Target Kegiatan</div>
                        <input type="number" name="target_kegiatan" id="target_kegiatan"
                            value="<?php echo e($targetKegiatan ?? 10); ?>" placeholder="Masukkan jumlah target kegiatan"
                            class="form-control bg-light border border-gray-400" required 
                            data-original-value="<?php echo e($targetKegiatan ?? 10); ?>" />
                        <div class="invalid-feedback"></div>
                    </div>
                </form>

                <div class="py-4 d-grid">
                    <button type="button" id="simpanAnggaranBtn"
                        class="gap-2 p-4 text-white rounded border-0 bg-danger fw-bold d-flex align-items-center justify-content-center">
                        <span class="btn-text">Simpan Target</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script>
        $(document).ready(function() {
            let dataTable = null;
            let searchTimeout;
            let isSearching = false;
            let currentFiles = [];
            let currentIndex = 0;
            let currentType = '';

            // Load saved target values from localStorage and update the UI
            function loadSavedTargets() {
                try {
                    const savedTargetAnggaran = localStorage.getItem('kegiatanLainnya_targetAnggaran');
                    const savedTargetKegiatan = localStorage.getItem('kegiatanLainnya_targetKegiatan');
                    
                    if (savedTargetAnggaran) {
                        const targetAnggaranInput = document.getElementById('target_anggaran');
                        if (targetAnggaranInput) {
                            // Format the saved value for display
                            const formattedValue = new Intl.NumberFormat('id-ID').format(savedTargetAnggaran);
                            targetAnggaranInput.value = formattedValue;
                        }
                        
                        // Update the display immediately if we're on the page
                        updateDisplayWithSavedTargets(parseInt(savedTargetAnggaran), parseInt(savedTargetKegiatan) || 10);
                    }
                    
                    if (savedTargetKegiatan) {
                        const targetKegiatanInput = document.getElementById('target_kegiatan');
                        if (targetKegiatanInput) {
                            targetKegiatanInput.value = savedTargetKegiatan;
                        }
                    }
                } catch (e) {
                    console.warn('Could not load saved targets from localStorage:', e);
                }
            }

            // Update the display with saved target values
            function updateDisplayWithSavedTargets(targetAnggaran, targetKegiatan) {
                // Update the anggaran display if elements exist
                const anggaranDisplay = document.getElementById('anggaranDisplay');
                const anggaranPercentage = document.getElementById('anggaranPercentage');
                
                if (anggaranDisplay && anggaranPercentage) {
                    // Get current anggaran value from display
                    const currentDisplay = anggaranDisplay.textContent;
                    const currentAnggaranMatch = currentDisplay.match(/Rp\.\s*([0-9.]+)/);
                    if (currentAnggaranMatch) {
                        const currentAnggaran = parseInt(currentAnggaranMatch[1].replace(/\./g, '')) || 0;
                        
                        // Calculate new percentage
                        const percentage = targetAnggaran > 0 ? Math.min((currentAnggaran / targetAnggaran) * 100, 100) : 0;
                        
                        // Format percentage display
                        let percentageDisplay;
                        if (percentage > 0 && percentage < 1) {
                            percentageDisplay = percentage.toFixed(1);
                        } else {
                            percentageDisplay = Math.round(percentage);
                        }
                        
                        // Update displays
                        anggaranDisplay.innerHTML = `Rp. ${currentAnggaran.toLocaleString('id-ID')} / Rp. ${targetAnggaran.toLocaleString('id-ID')}`;
                        anggaranPercentage.innerHTML = `${percentageDisplay}%`;
                        anggaranPercentage.setAttribute('data-bs-original-title', `${percentage.toFixed(2)}% dari total anggaran`);
                        
                        // Update progress bar
                        const progressBar = document.querySelector('.progress-bar');
                        if (progressBar) {
                            progressBar.style.width = percentage + '%';
                            progressBar.setAttribute('aria-valuenow', percentage);
                        }
                    }
                }
            }

            // Utility function to format number as Rupiah
            const formatRupiah = (angka, prefix = 'Rp ') => {
                const number = String(angka).replace(/[^\d]/g, '');
                const split = number.split(',');
                const sisa = split[0].length % 3;
                let rupiah = split[0].substr(0, sisa);
                const ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                if (ribuan) {
                    const separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                return prefix + rupiah;
            };

            const previewModal = document.getElementById('previewModal');
            const previewSlides = document.getElementById('previewSlides');
            const currentFileName = document.getElementById('currentFileName');
            const fileCounter = document.getElementById('fileCounter');
            const downloadBtn = document.getElementById('downloadBtn');
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');
            const modalTitle = document.getElementById('previewModalLabel');

            function initializeDataTable() {
                const table = $("#kt_datatable_dom_positioning_kegiatan");

                if (dataTable) {
                    dataTable.destroy();
                }

                // Adjust padding based on number of rows
                const rowCount = table.find('tbody tr').length;
                const tableContainer = table.closest('.table-responsive');
                if (rowCount === 1) {
                    tableContainer.css('padding-bottom', '60px');
                    // Also add top padding to ensure dropdown menu has space
                    tableContainer.css('padding-top', '60px');
                } else {
                    tableContainer.css('padding-bottom', '');
                    tableContainer.css('padding-top', '');
                }

                if (table.length > 0) {
                    dataTable = table.DataTable({
                        paging: false,
                        info: false,
                        searching: false,
                        ordering: false,
                        responsive: false,
                        autoWidth: false,
                        scrollX: false,
                        language: {
                            emptyTable: "Data tidak ditemukan",
                            zeroRecords: "Tidak ada data yang cocok dengan pencarian"
                        },
                        columnDefs: [{
                            targets: -1,
                            orderable: false,
                            searchable: false
                        }]
                    });
                }
                
                // Observe table changes to re-adjust padding
                const observer = new MutationObserver(function(mutations) {
                    const currentRowCount = table.find('tbody tr').length;
                    if (currentRowCount === 1) {
                        tableContainer.css('padding-bottom', '60px');
                        tableContainer.css('padding-top', '60px');
                    } else {
                        tableContainer.css('padding-bottom', '');
                        tableContainer.css('padding-top', '');
                    }
                });
                
                if (tableContainer.length) {
                    observer.observe(tableContainer[0], {
                        childList: true,
                        subtree: true
                    });
                }
            }

            function initializeTooltips() {
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                    var tooltip = new bootstrap.Tooltip(tooltipTriggerEl, {
                        trigger: 'hover',
                        html: true,
                        delay: {
                            show: 0,
                            hide: 300
                        },
                        fallbackPlacements: ['left', 'top', 'bottom']
                    });

                    // Variabel untuk menyimpan timeout
                    var hideTimeout;

                    // Menangani event saat kursor masuk ke elemen trigger
                    tooltipTriggerEl.addEventListener('mouseenter', function() {
                        clearTimeout(hideTimeout);
                    });

                    // Menangani event saat kursor keluar dari elemen trigger
                    tooltipTriggerEl.addEventListener('mouseleave', function() {
                        hideTimeout = setTimeout(function() {
                            tooltip.hide();
                        }, 300);
                    });

                    // Menangani event saat tooltip ditampilkan
                    tooltipTriggerEl.addEventListener('shown.bs.tooltip', function() {
                        var tooltipEl = document.querySelector('.tooltip');
                        if (tooltipEl) {
                            // Menambahkan event listener untuk mencegah tooltip menghilang saat kursor di atasnya
                            tooltipEl.addEventListener('mouseenter', function() {
                                clearTimeout(hideTimeout);
                            });

                            tooltipEl.addEventListener('mouseleave', function() {
                                hideTimeout = setTimeout(function() {
                                    tooltip.hide();
                                }, 300);
                            });
                        }
                    });

                    return tooltip;
                });
            }

            function initializeDropdownEvents() {
                // Hapus semua event listener lama
                $(document).off('click', '.dropdown-toggle-custom');
                $(document).off('mouseenter', '.dropdown-action');
                $(document).off('mouseleave', '.dropdown-action');
                $(document).off('mouseenter', '.dropdown-menu-custom');
                $(document).off('mouseleave', '.dropdown-menu-custom');

                // Tambahkan event listener untuk menutup dropdown saat klik di luar
                $(document).on('click', function(e) {
                    if (!$(e.target).closest('.dropdown-action').length) {
                        $('.dropdown-menu-custom').removeClass('show');
                    }
                });

                // Tambahkan event listener untuk menutup dropdown saat resize window
                $(window).on('resize', function() {
                    $('.dropdown-action').each(function() {
                        const dropdownActionElement = this;
                        const $menu = $(dropdownActionElement).find('.dropdown-menu-custom');
                        if ($menu.hasClass('show')) {
                            checkDropdownPositionJQuery(dropdownActionElement);
                        }
                    });
                });
            }

            function showLoading() {
                $('#loading-overlay').removeClass('d-none');
            }

            function hideLoading() {
                $('#loading-overlay').addClass('d-none');
            }

            function showSearchLoading() {
                if (!isSearching) {
                    isSearching = true;
                    showLoading();
                }
            }

            function hideSearchLoading() {
                isSearching = false;
                hideLoading();
            }

            function toggleClearButton() {
                const $searchInput = $('#search');
                const $clearBtn = $('#clear-search');

                if ($searchInput.val().length > 0) {
                    $clearBtn.removeClass('d-none');
                } else {
                    $clearBtn.addClass('d-none');
                }
            }

            function performSearch(searchValue, immediate = false) {
                if (searchTimeout) {
                    clearTimeout(searchTimeout);
                }

                if (immediate || searchValue === '') {
                    doSearch(searchValue);
                } else {
                    searchTimeout = setTimeout(() => {
                        doSearch(searchValue);
                    }, 300);
                }
            }

            function doSearch(searchValue) {
                showSearchLoading();

                updateTable({
                    'search': searchValue,
                    'page': 1
                }).finally(() => {
                    hideSearchLoading();
                    updateSummaryCards(); // Ensure summary cards are updated after search
                });
            }

            function updateTable(params = {}) {
                return new Promise((resolve, reject) => {
                    if (params.search === undefined) {
                        showLoading();
                    }

                    const currentUrl = new URL(window.location.href);

                    for (const key in params) {
                        if (params[key] !== null && params[key] !== undefined && params[key] !== '') {
                            currentUrl.searchParams.set(key, params[key]);
                        } else {
                            currentUrl.searchParams.delete(key);
                        }
                    }

                    $.ajax({
                        url: currentUrl.toString(),
                        type: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        success: function(response) {
                            $('#table-container').html(response);
                            hideLoading();

                            window.history.pushState(null, null, currentUrl.toString());

                            initializeDataTable();
                            initializeTooltips();
                            initializeDropdownEvents();
                            updateFilterCount();
                            updateSummaryCards(); // Update summary cards after table update

                            resolve(response);
                        },
                        error: function(xhr, status, error) {
                            hideLoading();

                            const errorMsg = xhr.status === 0 ?
                                'Koneksi terputus. Silakan coba lagi.' :
                                'Terjadi kesalahan saat memuat data.';

                            showNotification(errorMsg, 'error');
                            reject(error);
                        }
                    });
                });
            }

            function showNotification(message, type = 'info') {
                const alertClass = {
                    'success': 'alert-success',
                    'error': 'alert-danger',
                    'warning': 'alert-warning',
                    'info': 'alert-info'
                } [type] || 'alert-info';

                const notification = $(
                    `<div class="alert ${alertClass} alert-dismissible fade show notification-toast"
                 role="alert" style="position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `);

                $('body').append(notification);

                setTimeout(() => {
                    notification.alert('close');
                }, 5000);
            }

            function updateFilterCount() {
                const urlParams = new URLSearchParams(window.location.search);
                let count = 0;

                if (urlParams.get('jenis_kegiatan_filter')) count++;
                if (urlParams.get('start_date') || urlParams.get('end_date')) count++;

                const badge = $('#filter-count');
                if (count > 0) {
                    badge.text(count).removeClass('d-none');
                } else {
                    badge.addClass('d-none');
                }
            }

            function getFileIcon(extension) {
                const icons = {
                    'pdf': 'fas fa-file-pdf text-danger',
                    'doc': 'fas fa-file-word text-primary',
                    'docx': 'fas fa-file-word text-primary',
                    'xls': 'fas fa-file-excel text-success',
                    'xlsx': 'fas fa-file-excel text-success',
                    'ppt': 'fas fa-file-powerpoint text-warning',
                    'pptx': 'fas fa-file-powerpoint text-warning',
                    'jpg': 'fas fa-file-image text-info',
                    'jpeg': 'fas fa-file-image text-info',
                    'png': 'fas fa-file-image text-info',
                    'gif': 'fas fa-file-image text-info',
                    'webp': 'fas fa-file-image text-info',
                    'svg': 'fas fa-file-image text-info'
                };
                return icons[extension] || 'fas fa-file text-muted';
            }

            function loadPreview() {
                if (!previewSlides || !currentFiles || currentFiles.length === 0) {
                    console.error('No preview slides container or files');
                    return;
                }

                previewSlides.innerHTML = '';

                currentFiles.forEach((file, index) => {
                    const slide = document.createElement('div');
                    slide.className = `preview-slide ${index === currentIndex ? 'active' : ''}`;

                    const path = typeof file === 'object' && file.path ? file.path : file;
                    const originalName = typeof file === 'object' && file.original_name ? file
                        .original_name : path.split('/').pop();

                    const fileExtension = originalName.split('.').pop().toLowerCase();
                    const imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'];

                    if (currentType === 'image' || currentType === 'foto' ||
                        (currentType === 'auto' && imageExtensions.includes(fileExtension))) {
                        slide.innerHTML = `
                    <img src="/storage/${path}"
                         alt="Preview"
                         class="preview-image"
                         onerror="this.style.display='none'; this.parentElement.innerHTML='<div class=\'document-placeholder\'><i class=\'fas fa-exclamation-triangle text-warning\' style=\'font-size: 3rem;\'></i><h5>Gagal memuat gambar</h5></div>">
                `;
                    } else {
                        if (fileExtension === 'pdf') {
                            slide.innerHTML = `
                        <iframe src="/storage/${path}"
                                class="preview-document"
                                onerror="console.error('Failed to load PDF: /storage/${path}')"></iframe>
                    `;
                        } else {
                            const iconClass = getFileIcon(fileExtension);
                            slide.innerHTML = `
                        <div class="document-placeholder">
                            <i class="${iconClass}"></i>
                            <h5>${originalName}</h5>
                            <p>Klik download untuk melihat file ${fileExtension.toUpperCase()}</p>
                            <a href="/storage/${path}" class="btn btn-primary" target="_blank">
                                <i class="fas fa-external-link-alt me-2"></i>Buka File
                            </a>
                        </div>
                    `;
                        }
                    }

                    previewSlides.appendChild(slide);
                });

                updatePreviewUI();
            }

            function updatePreviewUI() {
                if (!currentFiles || currentFiles.length === 0) return;

                const file = currentFiles[currentIndex];
                const path = typeof file === 'object' && file.path ? file.path : file;
                const originalName = typeof file === 'object' && file.original_name ? file.original_name : path
                    .split('/').pop();

                if (currentFileName) currentFileName.textContent = originalName;
                if (fileCounter) fileCounter.textContent = `${currentIndex + 1} dari ${currentFiles.length}`;

                if (currentFiles.length > 1) {
                    if (prevBtn) prevBtn.style.display = 'block';
                    if (nextBtn) nextBtn.style.display = 'block';
                } else {
                    if (prevBtn) prevBtn.style.display = 'none';
                    if (nextBtn) nextBtn.style.display = 'none';
                }

                if (downloadBtn) {
                    downloadBtn.onclick = function() {
                        const link = document.createElement('a');
                        link.href = '/storage/' + path;
                        link.setAttribute('download', originalName);
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);
                    };
                }
            }

            function showSlide(index) {
                if (!previewSlides) return;

                document.querySelectorAll('.preview-slide').forEach((slide, i) => {
                    slide.classList.toggle('active', i === index);
                });
                currentIndex = index;
                updatePreviewUI();
            }

            window.destroyItem = function(button) {
                const route = button.dataset.route;

                Swal.fire({
                    title: "Apakah Anda Yakin?",
                    html: "<p style='text-align:center'>Setelah data laporan kegiatan lainnya dihapus, Anda tidak bisa mengembalikannya!</p>",
                    icon: "warning",
                    showCancelButton: true,
                    reverseButtons: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Hapus!',
                    cancelButtonText: 'Batalkan!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Menghapus...',
                            text: 'Mohon tunggu',
                            allowOutsideClick: false,
                            showConfirmButton: false,
                            willOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        $.ajax({
                            url: route,
                            type: 'DELETE',
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: response.message ||
                                        'Data laporan kegiatan lainnya berhasil dihapus',
                                    icon: 'success',
                                    timer: 2000,
                                    showConfirmButton: false
                                });

                                // Update table and summary cards after a short delay to ensure DOM is ready
                                setTimeout(function() {
                                    updateTable({});
                                    updateSummaryCards(); // Refresh the progress card and summary cards
                                }, 100);
                            },
                            error: function(xhr) {
                                Swal.close();

                                try {
                                    const response = JSON.parse(xhr.responseText);

                                    if (response.reason === 'has_dependencies') {
                                        Swal.fire({
                                            title: 'Tidak Dapat Menghapus Data',
                                            html: `Data laporan <strong>${response.item_name}</strong> tidak dapat dihapus karena masih memiliki data terkait.<br><br>
                                <p class="text-muted">
                                    Silakan hapus atau ubah data yang terkait terlebih dahulu.
                                </p>`,
                                            icon: "warning",
                                            confirmButtonText: 'Mengerti'
                                        });
                                    } else {
                                        Swal.fire({
                                            title: 'Error!',
                                            text: response.message ||
                                                'Gagal menghapus data laporan kegiatan lainnya',
                                            icon: 'error'
                                        });
                                    }
                                } catch (e) {
                                    Swal.fire({
                                        title: 'Error!',
                                        text: 'Gagal menghapus data laporan kegiatan lainnya',
                                        icon: 'error'
                                    });
                                }
                            }
                        });
                    } else {
                        Swal.fire({
                            title: "Aksi Dibatalkan :)",
                            icon: "info",
                            timer: 1500,
                            showConfirmButton: false
                        });
                    }
                });
            };

            window.showDetailModal = function(data) {
                const modalBody = document.getElementById('detailModalBody');
                const statusIcon = document.getElementById('statusIcon');
                const exportBtn = document.getElementById('exportBtn');
                const ajukanPerubahanBtn = document.getElementById('ajukanPerubahanBtn');

                if (!modalBody) {
                    console.error('Modal body not found');
                    return;
                }

                // Set URL export berdasarkan ID kegiatan
                if (exportBtn && data && data.id) {
                    exportBtn.href = `/admin/laporan-lpj/kegiatan-lainnya/${data.id}/export`;
                    // Ubah warna tombol export menjadi merah
                    exportBtn.className = 'btn btn-danger btn-sm';
                }

                // Tampilkan status terkunci/terbuka berdasarkan modifiable_by_user_id
                if (statusIcon) {
                    // Cek apakah laporan bisa dimodifikasi (terbuka) atau terkunci
                    // Kita perlu memeriksa dari sisi PHP apakah user saat ini adalah superadmin, memiliki permission pengajuan-modifikasi-laporan, atau memiliki akses modifikasi
                    const isSuperAdmin = <?php echo e(auth()->user()->hasRole('superadmin') ? 'true' : 'false'); ?>;
                    const hasApprovalPermission =
                        <?php echo e(auth()->user()->can('pengajuan-modifikasi-laporan-manage') ? 'true' : 'false'); ?>;
                    const isModifiableByCurrentUser = data.modifiable_by_user_id && data
                        .modifiable_by_user_id == <?php echo e(auth()->id()); ?>;

                    // Jika user adalah superadmin, memiliki permission pengajuan-modifikasi-laporan, atau memiliki akses modifikasi, maka status terbuka
                    if (isSuperAdmin || hasApprovalPermission || isModifiableByCurrentUser) {
                        statusIcon.innerHTML = '<i class="fas fa-lock-open me-1"></i> Terbuka';
                        statusIcon.className = 'badge bg-success fs-7 d-flex align-items-center';
                    } else {
                        statusIcon.innerHTML = '<i class="fas fa-lock me-1"></i> Terkunci';
                        statusIcon.className = 'badge bg-danger fs-7 d-flex align-items-center';
                    }
                }

                // Cek apakah token modifikasi sudah kadaluarsa atau sudah digunakan
                const isTokenExpiredOrUsed = data.modification_token_status === 'expired' || data
                    .modification_token_status === 'used';

                    // Jika user adalah superadmin, memiliki permission pengajuan-modifikasi-laporan, atau memiliki akses modifikasi, maka status terbuka
                    // Kecuali jika token sudah kadaluarsa atau sudah digunakan
                    if ((isSuperAdmin || hasApprovalPermission || isModifiableByCurrentUser) && !
                        isTokenExpiredOrUsed) {
                        statusIcon.innerHTML = 'Terbuka';
                        statusIcon.className = 'badge bg-success-subtle text-success fw-semibold fs-7 d-flex align-items-center';
                        statusIcon.style.cssText = 'padding: 6px 10px; border: 1px solid #bbf7d0;';

                        // Sembunyikan tombol "Ajukan Perubahan" saat status Terbuka
                        if (ajukanPerubahanBtn) {
                            ajukanPerubahanBtn.style.display = 'none';
                        }
                    } else {
                        statusIcon.innerHTML = 'Terkunci';
                        statusIcon.className = 'badge bg-danger fw-semibold fs-7 d-flex align-items-center';
                        statusIcon.style.cssText = 'padding: 6px 10px;';

                    // Tampilkan tombol "Ajukan Perubahan" saat status Terkunci
                    if (ajukanPerubahanBtn) {
                        ajukanPerubahanBtn.style.display = 'inline-flex';
                    }
                }
            }

            // Simpan ID LPJ dalam data modal
            $('#detailModal').data('lpj-id', data.id);

            const formatRupiah = (num) => {
                if (!num) return 'Rp 0';
                return 'Rp ' + parseInt(num).toLocaleString('id-ID');
            };

            let fotoJurnalHtml = '<div class="text-muted fst-italic">Tidak ada foto tersedia</div>';
            if (data.foto_jurnal && Array.isArray(data.foto_jurnal) && data.foto_jurnal.length > 0) {
                fotoJurnalHtml = `
            <div class="row g-3">
                ${data.foto_jurnal.map(f => {
                    const path = typeof f === 'object' ? f.path : f;
                    const name = typeof f === 'object' ? (f.original_name || path.split('/').pop()) : path.split('/').pop();
                    return `
                                    <div class="col-6 col-md-4">
                                        <div class="overflow-hidden rounded border" style="height: 120px;">
                                            <img src="/storage/${path}"
                                                 class="w-100 h-100"
                                                 style="object-fit: cover; cursor: pointer;"
                                                 onclick="window.open('/storage/${path}', '_blank')"
                                                 onerror="this.style.display='none'; this.parentElement.innerHTML='<div class=\\'d-flex align-items-center justify-content-center h-100 text-muted\\'>Error loading image</div>'">
                                            <div class="p-1 text-center small bg-light">${name}</div>
                                        </div>
                                    </div>
                                `}).join('')}
            </div>
        `;
            }

            let dokumenHtml = '<div class="text-muted fst-italic">Tidak ada dokumen tersedia</div>';
            if (data.dokumen_lpj && Array.isArray(data.dokumen_lpj) && data.dokumen_lpj.length > 0) {
                dokumenHtml = `
            <div class="gap-2 d-flex flex-column">
                ${data.dokumen_lpj.map(d => {
                    const path = typeof d === 'object' ? d.path : d;
                    const name = typeof d === 'object' ? (d.original_name || path.split('/').pop()) : path.split('/').pop();
                    const extension = name.split('.').pop().toLowerCase();

                    let iconClass = 'fas fa-file text-secondary';
                    if (extension === 'pdf') iconClass = 'fas fa-file-pdf text-danger';
                    else if (['doc', 'docx'].includes(extension)) iconClass = 'fas fa-file-word text-primary';
                    else if (['xls', 'xlsx'].includes(extension)) iconClass = 'fas fa-file-excel text-success';
                    else if (['jpg', 'jpeg', 'png', 'gif'].includes(extension)) iconClass = 'fas fa-file-image text-info';

                    return `
                                        <div class="p-2 rounded border d-flex align-items-center bg-light">
                                            <i class="${iconClass} me-3" style="font-size: 1.2em;"></i>
                                            <div class="flex-grow-1">
                                                <div class="fw-medium text-dark">${name}</div>
                                                <small class="text-muted">${extension.toUpperCase()}</small>
                                            </div>
                                            <a href="/storage/${path}"
                                               target="_blank"
                                               class="btn btn-outline-primary btn-sm">
                                                <i class="fas fa-download me-1"></i>Unduh
                                            </a>
                                        </div>
                                    `;
                }).join('')}
            </div>
        `;
            }

            // Tambahkan penanganan untuk Dokumen LPJ (PDF)
            let dokumenLpjHtml = '<div class="text-muted fst-italic">Tidak ada dokumen LPJ tersedia</div>';
            if (data.dokumen_lpj_pdf && Array.isArray(data.dokumen_lpj_pdf) && data.dokumen_lpj_pdf.length > 0) {
                dokumenLpjHtml = `
            <div class="gap-2 d-flex flex-column">
                ${data.dokumen_lpj_pdf.map(d => {
                    const path = typeof d === 'object' ? d.path : d;
                    const name = typeof d === 'object' ? (d.original_name || path.split('/').pop()) : path.split('/').pop();
                    const extension = name.split('.').pop().toLowerCase();

                    // Untuk dokumen LPJ PDF, selalu gunakan ikon PDF
                    const iconClass = 'fas fa-file-pdf text-danger';

                    return `
                                <div class="p-2 rounded border d-flex align-items-center bg-light">
                                    <i class="${iconClass} me-3" style="font-size: 1.2em;"></i>
                                    <div class="flex-grow-1">
                                        <div class="fw-medium text-dark">${name}</div>
                                        <small class="text-muted">${extension.toUpperCase()}</small>
                                    </div>
                                    <a href="/storage/${path}"
                                       target="_blank"
                                       class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-download me-1"></i>Unduh
                                    </a>
                                </div>
                            `;
                }).join('')}
            </div>
        `;
            }

            modalBody.innerHTML = `
        <div class="border-0 shadow-sm card">
            <div class="p-4 card-body">
                <div class="mb-4">
                    <h6 class="mb-3 fw-bold text-primary d-flex align-items-center">
                        <i class="fas fa-info-circle me-2"></i>
                        Informasi Kegiatan
                    </h6>
                    <div class="p-3 rounded bg-light">
                        <div class="mb-2">
                            <label class="mb-1 fw-semibold text-dark">Nama Program:</label>
                            <p class="mb-0 text-dark">${data.nama_program || 'N/A'}</p>
                        </div>
                        ${data.nama_kegiatan ? `
                                            <div class="mb-2">
                                                <label class="mb-1 fw-semibold text-dark">Nama Kegiatan:</label>
                                                <p class="mb-0 text-dark">${data.nama_kegiatan}</p>
                                            </div>
                                        ` : ''}
                        ${data.volume ? `
                                            <div class="mb-2">
                                                <label class="mb-1 fw-semibold text-dark">Volume:</label>
                                                <p class="mb-0 text-dark">${data.volume}</p>
                                            </div>
                                        ` : ''}
                        ${data.tempat_kegiatan ? `
                                            <div class="mb-2">
                                                <label class="mb-1 fw-semibold text-dark">Tempat Kegiatan:</label>
                                                <p class="mb-0 text-dark">${data.tempat_kegiatan}</p>
                                            </div>
                                        ` : ''}
                        ${data.tanggal_kegiatan ? `
                                            <div>
                                                <label class="mb-1 fw-semibold text-dark">Tanggal Kegiatan:</label>
                                                <p class="mb-0 text-dark">${new Date(data.tanggal_kegiatan).toLocaleDateString('id-ID').split('/').join('/')}</p>
                                            </div>
                                        ` : ''}
                    </div>
                </div>

                ${data.jumlah_harga_satuan || data.jumlah_harga ? `
                                    <div class="mb-4">
                                        <h6 class="mb-3 fw-bold text-success d-flex align-items-center">
                                            <i class="fas fa-calculator me-2"></i>
                                            Rincian Anggaran
                                        </h6>
                                        <div class="p-3 rounded bg-light">
                                            <div class="row g-3">
                                                ${data.jumlah_harga_satuan ? `
                                    <div class="col-md-6">
                                        <label class="mb-1 fw-semibold text-dark">Harga Satuan:</label>
                                        <p class="mb-0 text-success fs-6 fw-bold">${formatRupiah(data.jumlah_harga_satuan)}</p>
                                    </div>
                                ` : ''}
                                                ${data.jumlah_harga ? `
                                    <div class="col-md-6">
                                        <label class="mb-1 fw-semibold text-dark">Total Anggaran:</label>
                                        <p class="mb-0 text-info fs-6 fw-bold">${formatRupiah(data.jumlah_harga)}</p>
                                    </div>
                                ` : ''}
                                            </div>
                                        </div>
                                    </div>
                                ` : ''}

                ${data.sumber_dana ? `
                                    <div class="mb-4">
                                        <h6 class="mb-3 fw-bold text-info d-flex align-items-center">
                                            <i class="fas fa-money-bill me-2"></i>
                                            Sumber Dana
                                        </h6>
                                        <div class="p-3 rounded bg-light">
                                            <p class="mb-0 text-dark">${data.sumber_dana}</p>
                                        </div>
                                    </div>
                                ` : ''}

                <div class="mb-4">
                    <h6 class="mb-3 fw-bold text-warning d-flex align-items-center">
                        <i class="fas fa-paperclip me-2"></i>
                        Lampiran
                    </h6>

                    <div class="mb-3">
                        <label class="mb-2 fw-semibold text-dark d-block">
                            <i class="fas fa-camera me-1"></i>Foto Jurnal:
                        </label>
                        <div class="p-3 rounded bg-light">
                            ${fotoJurnalHtml}
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="mb-2 fw-semibold text-dark d-block">
                            <i class="fas fa-file-alt me-1"></i>Dokumen Pendukung:
                        </label>
                        <div class="p-3 rounded bg-light">
                            ${dokumenHtml}
                        </div>
                    </div>

                    <div>
                        <label class="mb-2 fw-semibold text-dark d-block">
                            <i class="fas fa-file-pdf me-1"></i>Dokumen LPJ:
                        </label>
                        <div class="p-3 rounded bg-light">
                            ${dokumenLpjHtml}
                        </div>
                    </div>
                </div>

                ${data.keterangan_tambahan ? `
                                <div class="mb-4">
                                    <h6 class="fw-bold text-dark mb-3 d-flex align-items-center">
                                        <i class="fas fa-sticky-note me-2"></i>
                                        Keterangan Tambahan
                                    </h6>
                                    <div class="bg-light p-3 rounded">
                                        <p class="mb-0 text-dark" style="white-space: pre-wrap;">${data.keterangan_tambahan}</p>
                                    </div>
                                </div>
                            ` : ''}
            </div>
        </div>
    `;

            const modal = new bootstrap.Modal(document.getElementById('detailModal'));
            modal.show();
        };

        window.showPreviewModal = function(files, type, title) {
            if (!files || !Array.isArray(files) || files.length === 0) {
                console.error('Invalid files data for preview');
                return;
            }

            currentFiles = files;
            currentType = type || 'auto';
            currentIndex = 0;

            if (modalTitle) {
                modalTitle.textContent = title || 'Preview Files';
            }

            loadPreview();
            $('#previewModal').modal('show');
        };

            // Initialize the page
            loadSavedTargets();
            initializeDataTable();
            initializeTooltips();
            initializeDropdownEvents();
            updateFilterCount();
            toggleClearButton();
            updateSummaryCards(); // Initialize summary cards on page load

        $('#search').on('input', function() {
            const searchValue = $(this).val().trim();
            toggleClearButton();
            performSearch(searchValue);
        });

        $('#clear-search').on('click', function() {
            $('#search').val('').focus();
            toggleClearButton();
            performSearch('', true);
        });

        $('#search-button').on('click', function() {
            const searchValue = $('#search').val().trim();
            performSearch(searchValue, true);
        });

        $('#search').on('keydown', function(e) {
            switch (e.key) {
                case 'Escape':
                    $(this).val('');
                    toggleClearButton();
                    performSearch('', true);
                    break;

                case 'Enter':
                    e.preventDefault();
                    const searchValue = $(this).val().trim();
                    performSearch(searchValue, true);
                    break;
            }
        });

        $('#search').on('focus', function() {
            $(this).select();
        });

        // Fungsi untuk tombol edit anggaran
        $('#editAnggaranBtn').on('click', function(e) {
            e.preventDefault();
            // Tampilkan modal edit anggaran
            $('#editAnggaranModal').modal('show');
        });

        // Fungsi untuk memformat input anggaran secara real-time
        $('#target_anggaran').on('input', function() {
            let value = $(this).val();

            // Hapus semua karakter non-digit
            value = value.replace(/[^\d]/g, '');

            // Format sebagai Rupiah jika ada nilai
            if (value) {
                // Format dengan fungsi utilitas
                value = formatRupiah(value);
            }

            $(this).val(value);
        });

        // Fungsi untuk menyimpan perubahan anggaran
        $('#simpanAnggaranBtn').on('click', function() {
            // Ambil nilai dari input
            let targetAnggaran = $('#target_anggaran').val();
            const targetKegiatan = $('#target_kegiatan').val();

            // Validasi input
            if (!targetAnggaran || !targetKegiatan) {
                alert('Harap isi semua field dengan benar.');
                return;
            }

                // Hapus format Rupiah dari input anggaran
                targetAnggaran = targetAnggaran.replace(/[Rp.\s]/g, '');

                // Pastikan targetAnggaran adalah angka yang valid
                targetAnggaran = parseInt(targetAnggaran) || 0;

                // Simpan ke localStorage agar persisten setelah refresh
                try {
                    if (targetAnggaran === 200000000000 && targetKegiatan == 10) {
                        // If resetting to default values, remove from localStorage
                        localStorage.removeItem('kegiatanLainnya_targetAnggaran');
                        localStorage.removeItem('kegiatanLainnya_targetKegiatan');
                    } else {
                        localStorage.setItem('kegiatanLainnya_targetAnggaran', targetAnggaran);
                        localStorage.setItem('kegiatanLainnya_targetKegiatan', targetKegiatan);
                    }
                } catch (e) {
                    console.warn('Could not save targets to localStorage:', e);
                }

            // Format angka dengan pemisah ribuan
            const formattedAnggaran = formatRupiah(targetAnggaran);

                // Update tampilan target anggaran
                const currentAnggaranText = $('#anggaranDisplay').text();
                const currentAnggaranParts = currentAnggaranText.split(' / Rp. ');
                const currentAnggaran = currentAnggaranParts[0].replace('Rp. ', '').replace(/\./g, '');
                const currentAnggaranValue = parseInt(currentAnggaran) || 0;

                // Hitung persentase baru dengan pembatasan maksimal 100%
                const anggaranPercentage = targetAnggaran > 0 ? Math.min((currentAnggaranValue / targetAnggaran) * 100, 100) : 0;
                
                // Use consistent rounding method - show 1 decimal place when percentage is small
                let anggaranPercentageDisplay;
                if (anggaranPercentage > 0 && anggaranPercentage < 1) {
                    anggaranPercentageDisplay = anggaranPercentage.toFixed(1);
                } else {
                    anggaranPercentageDisplay = Math.round(anggaranPercentage);
                }

                // Update tampilan
                $('#anggaranDisplay').html(
                    `Rp. ${formatRupiah(currentAnggaran, '')} / Rp. ${formatRupiah(targetAnggaran, '')}`
                );
                $('#anggaranPercentage').html(`${anggaranPercentageDisplay}%`);
                $('#anggaranPercentage').attr('data-bs-original-title',
                    `${anggaranPercentage.toFixed(2)}% dari total anggaran`);
                $('.progress-bar').css('width', anggaranPercentage + '%').attr('aria-valuenow',
                    anggaranPercentage);

                // Update target kegiatan
                const currentKegiatanText = $('#kegiatanBerjalan').text();
                const currentKegiatan = parseInt(currentKegiatanText) || 0;
                const kegiatanPercentage = targetKegiatan > 0 ? Math.min((currentKegiatan / targetKegiatan) * 100, 100) : 0;
                const kegiatanPercentageRounded = Math.round(kegiatanPercentage);

            $('.badge.bg-primary-subtle').html(`${targetKegiatan} Target Kegiatan`);

            // Tutup modal
            $('#editAnggaranModal').modal('hide');

            // Tampilkan notifikasi
            showNotification('Target anggaran berhasil diperbarui.', 'success');
        });

        $('#apply-filters').on('click', function() {
            const jenisKegiatan = $('#filter-jenis-kegiatan').val();
            const startDate = $('#filter-start-date').val();
            const endDate = $('#filter-end-date').val();

                updateTable({
                    'jenis_kegiatan_filter': jenisKegiatan,
                    'start_date': startDate,
                    'end_date': endDate,
                    'page': 1
                }).then(() => {
                    updateSummaryCards(); // Ensure summary cards are updated after filter
                });
            });

        $('#reset-filters').on('click', function() {
            $('#filter-jenis-kegiatan').val('');
            $('#filter-start-date').val('');
            $('#filter-end-date').val('');
            $('#search').val('');
            toggleClearButton();

                updateTable({
                    'search': '',
                    'jenis_kegiatan_filter': '',
                    'start_date': '',
                    'end_date': '',
                    'page': 1
                }).then(() => {
                    updateSummaryCards(); // Ensure summary cards are updated after reset
                });
            });

            function updateSummaryCards() {
                // Get the updated table data after deletion
                const table = $("#kt_datatable_dom_positioning_kegiatan");
                const tableRows = table.find('tbody tr').not(':contains("Data tidak ditemukan")');
                const totalKegiatan = tableRows.length;

                let totalAnggaran = 0;
                tableRows.each(function() {
                    const anggaranText = $(this).find('td').eq(2).text().trim();
                    if (anggaranText && anggaranText !== '-') {
                        const anggaranValue = parseInt(anggaranText.replace(/[Rp\s\.,]/g, '')) || 0;
                        totalAnggaran += anggaranValue;
                    }
                });

                // Get target values from localStorage or use defaults
                let targetAnggaran = 200000000000; // 200 miliar default
                let targetKegiatan = 10; // default target kegiatan
                
                try {
                    const savedTargetAnggaran = localStorage.getItem('kegiatanLainnya_targetAnggaran');
                    const savedTargetKegiatan = localStorage.getItem('kegiatanLainnya_targetKegiatan');
                    
                    if (savedTargetAnggaran) {
                        targetAnggaran = parseInt(savedTargetAnggaran) || targetAnggaran;
                    }
                    
                    if (savedTargetKegiatan) {
                        targetKegiatan = parseInt(savedTargetKegiatan) || targetKegiatan;
                    }
                } catch (e) {
                    console.warn('Could not load saved targets from localStorage:', e);
                }

                // Update header display
                const anggaranPercentage = totalAnggaran > 0 ? Math.min((totalAnggaran / targetAnggaran) * 100, 100) : 0;

                // Use consistent rounding method - show 1 decimal place when percentage is small
                let anggaranPercentageDisplay;
                if (anggaranPercentage > 0 && anggaranPercentage < 1) {
                    anggaranPercentageDisplay = anggaranPercentage.toFixed(1);
                } else {
                    anggaranPercentageDisplay = Math.round(anggaranPercentage);
                }

                // Update anggaran display dengan ID yang unik
                $('#anggaranDisplay').html(
                    `Rp. ${totalAnggaran.toLocaleString('id-ID')} / Rp. ${targetAnggaran.toLocaleString('id-ID')}`
                );
                $('#anggaranPercentage').html(`${anggaranPercentageDisplay}%`);
                $('#anggaranPercentage').attr('data-bs-original-title',
                    `${anggaranPercentage.toFixed(2)}% dari total anggaran`);
                
                // Reinitialize tooltip with updated content
                const tooltipElement = document.getElementById('anggaranPercentage');
                if (tooltipElement) {
                    const tooltip = bootstrap.Tooltip.getInstance(tooltipElement);
                    if (tooltip) {
                        tooltip.dispose();
                    }
                    new bootstrap.Tooltip(tooltipElement);
                }

            // Update progress bar
            $('.progress-bar').css('width', anggaranPercentage + '%').attr('aria-valuenow', anggaranPercentage);

                // Update kegiatan info dengan ID yang unik
                const kegiatanPercentage = totalKegiatan > 0 ? Math.min((totalKegiatan / targetKegiatan) * 100, 100) : 0;

                $('#kegiatanBerjalan').html(`${totalKegiatan}`);
                
                // Update target kegiatan badge
                $('.badge.bg-primary-subtle').html(`${targetKegiatan} Target Kegiatan`);
            }

        // Modifikasi fungsi updateTable yang sudah ada, tambahkan updateSummaryCards() di success callback

            $(document).on('change', 'select[name="per_page"]', function() {
                const perPage = $(this).val();
                updateTable({
                    'per_page': perPage,
                    'page': 1
                }).then(() => {
                    updateSummaryCards(); // Ensure summary cards are updated after page size change
                });
            });

        $(document).on('click', '.pagination-link', function(e) {
            e.preventDefault();
            const href = $(this).attr('href');

            if (href && href !== '#') {
                const url = new URL(href);
                const page = url.searchParams.get('page');

                    if (page) {
                        updateTable({
                            'page': page
                        }).then(() => {
                            updateSummaryCards(); // Ensure summary cards are updated after page change
                        });
                    }
                }
            });

        $(document).on('click', '.sortable-header', function(e) {
            e.preventDefault();
            const url = new URL($(this).attr('href'));
            const sort = url.searchParams.get('sort');
            const direction = url.searchParams.get('direction');

                updateTable({
                    'sort': sort,
                    'direction': direction,
                    'page': 1
                }).then(() => {
                    updateSummaryCards(); // Ensure summary cards are updated after sort
                });
            });

        $(document).on('click', '.preview-btn', function(e) {
            e.preventDefault();
            const btn = $(this);

            try {
                const filesData = btn.attr('data-files');
                const type = btn.attr('data-type') || 'auto';
                const title = btn.attr('data-title') || 'Preview Files';

                if (filesData) {
                    const files = JSON.parse(filesData);
                    showPreviewModal(files, type, title);
                } else {
                    console.error('No files data found');
                }
            } catch (error) {
                console.error('Error parsing preview data:', error);
            }
        });

        // Fungsi untuk menjaga tooltip tetap terlihat
        window.keepTooltipVisible = function(element) {
            const tooltip = bootstrap.Tooltip.getInstance(element);
            if (tooltip) {
                clearTimeout(element.tooltipHideTimeout);
            }
        };

        // Fungsi untuk menyembunyikan tooltip dengan delay
        window.hideTooltipWithDelay = function(element) {
            const tooltip = bootstrap.Tooltip.getInstance(element);
            if (tooltip) {
                element.tooltipHideTimeout = setTimeout(() => {
                    tooltip.hide();
                }, 300); // 300ms delay
            }
        };

        // Menangani interaksi dengan tooltip
        $(document).on('mouseenter', '.tooltip', function() {
            // Saat kursor masuk ke tooltip, batalkan penutupan
            const triggeringElement = $('.restricted-action[data-bs-toggle="tooltip"]');
            if (triggeringElement.length > 0) {
                clearTimeout(triggeringElement[0].tooltipHideTimeout);
            }
        });

        $(document).on('mouseleave', '.tooltip', function() {
            // Saat kursor keluar dari tooltip, sembunyikan tooltip dengan delay
            const triggeringElement = $('.restricted-action[data-bs-toggle="tooltip"]');
            if (triggeringElement.length > 0) {
                const tooltip = bootstrap.Tooltip.getInstance(triggeringElement[0]);
                if (tooltip) {
                    triggeringElement[0].tooltipHideTimeout = setTimeout(() => {
                        tooltip.hide();
                    }, 300);
                }
            }
        });

        $(document).on('mouseenter', '.tooltip-content a', function() {
            // Saat kursor masuk ke tautan dalam tooltip, batalkan penutupan
            const triggeringElement = $('.restricted-action[data-bs-toggle="tooltip"]');
            if (triggeringElement.length > 0) {
                clearTimeout(triggeringElement[0].tooltipHideTimeout);
            }
        });

        $(document).on('mouseleave', '.tooltip-content a', function() {
            // Saat kursor keluar dari tautan dalam tooltip, sembunyikan tooltip dengan delay
            const triggeringElement = $('.restricted-action[data-bs-toggle="tooltip"]');
            if (triggeringElement.length > 0) {
                const tooltip = bootstrap.Tooltip.getInstance(triggeringElement[0]);
                if (tooltip) {
                    triggeringElement[0].tooltipHideTimeout = setTimeout(() => {
                        tooltip.hide();
                    }, 300);
                }
            }
        });

        if (prevBtn) {
            prevBtn.addEventListener('click', function() {
                const newIndex = currentIndex > 0 ? currentIndex - 1 : currentFiles.length - 1;
                showSlide(newIndex);
            });
        }

            if (nextBtn) {
                nextBtn.addEventListener('click', function() {
                    const newIndex = currentIndex < currentFiles.length - 1 ? currentIndex + 1 : 0;
                    showSlide(newIndex);
                });
            }

            // Fungsi untuk toggle dropdown menu dengan onclick
            window.toggleDropdown = function(button) {
                const $dropdownAction = $(button).closest('.dropdown-action');
                const $menu = $dropdownAction.find('.dropdown-menu-custom');

                // Tutup semua dropdown yang terbuka kecuali yang sedang di-toggle
                $('.dropdown-menu-custom').not($menu).removeClass('show');

                // Toggle dropdown yang diklik
                $menu.toggleClass('show');

                // Periksa posisi dropdown setelah a short delay to ensure proper rendering
                setTimeout(function() {
                    checkDropdownPositionJQuery($dropdownAction[0]);
                }, 10);
            };
            
            // Fungsi untuk memeriksa posisi dropdown
            function checkDropdownPosition(dropdownAction) {
                const menu = dropdownAction.querySelector('.dropdown-menu-custom');
                if (!menu.classList.contains('show')) return;
                
                dropdownAction.classList.remove('dropup');
                
                const row = dropdownAction.closest('tr');
                const table = row.closest('tbody');
                const rowIndex = Array.from(table.querySelectorAll('tr')).indexOf(row);
                const totalRows = table.querySelectorAll('tr').length;
                
                if (rowIndex === totalRows - 1) {
                    dropdownAction.classList.add('dropup');
                }
            }

            // Fungsi untuk memeriksa posisi dropdown (versi jQuery untuk kompatibilitas)
            function checkDropdownPositionJQuery(dropdownActionElement) {
                const $menu = $(dropdownActionElement).find('.dropdown-menu-custom');
                if (!$menu.hasClass('show')) return;

                // Reset classes and styles
                $(dropdownActionElement).removeClass('dropup');
                $menu.css({
                    'top': '',
                    'bottom': '',
                    'left': '',
                    'right': '0'
                });

                const $row = $(dropdownActionElement).closest('tr');
                const $table = $row.closest('tbody');
                const rowIndex = $table.find('tr').index($row);
                const totalRows = $table.find('tr').length;

                // Get positions
                const dropdownRect = dropdownActionElement.getBoundingClientRect();
                const menuHeight = $menu.outerHeight();
                const menuWidth = $menu.outerWidth();
                
                // Calculate available space
                const spaceBelow = window.innerHeight - dropdownRect.bottom;
                const spaceAbove = dropdownRect.top;
                const spaceRight = window.innerWidth - dropdownRect.left;

                // Determine if we should use dropup
                // Only use dropup if there's significantly more space above than below
                const needsDropup = spaceBelow < menuHeight && spaceAbove > spaceBelow + 50;
                    
                if (needsDropup) {
                    $(dropdownActionElement).addClass('dropup');
                }
                
                // Additional viewport constraint adjustments
                const isDropup = $(dropdownActionElement).hasClass('dropup');
                
                // Adjust for horizontal viewport constraints
                if (dropdownRect.right + menuWidth > window.innerWidth) {
                    // Menu would go off right edge
                    $menu.css({
                        'left': 'auto',
                        'right': '0'
                    });
                }
                
                // Adjust for vertical viewport constraints
                if (isDropup) {
                    // For dropup, check if it goes above the viewport
                    if (dropdownRect.top - menuHeight < 0) {
                        // Not enough space above, force normal dropdown
                        $(dropdownActionElement).removeClass('dropup');
                        // Position menu at the top of the viewport with a small buffer
                        const topPosition = Math.max(5, Math.abs(dropdownRect.top - menuHeight));
                        $menu.css('top', topPosition + 'px');
                    }
                } else {
                    // For dropdown, check if it goes below the viewport
                    if (dropdownRect.bottom + menuHeight > window.innerHeight) {
                        // Check if we have more space above
                        if (spaceAbove > spaceBelow && menuHeight <= spaceAbove) {
                            // Switch to dropup
                            $(dropdownActionElement).addClass('dropup');
                        } else {
                            // Adjust position to keep menu within viewport
                            const adjustment = window.innerHeight - (dropdownRect.bottom + menuHeight) - 5; // 5px buffer
                            if (adjustment < 0) {
                                $menu.css('top', adjustment + 'px');
                            }
                        }
                    }
                }
                
                // Ensure the dropdown menu is fully visible by scrolling if necessary
                setTimeout(function() {
                    const menuRect = $menu[0].getBoundingClientRect();
                    if (menuRect.bottom > window.innerHeight) {
                        const scrollTop = menuRect.bottom - window.innerHeight + 10;
                        window.scrollBy(0, scrollTop);
                    } else if (menuRect.top < 0) {
                        const scrollTop = menuRect.top - 10;
                        window.scrollBy(0, scrollTop);
                    }
                }, 50);
            }

        document.addEventListener('keydown', function(e) {
            if (previewModal && previewModal.classList.contains('show')) {
                if (e.key === 'ArrowLeft' && prevBtn) {
                    prevBtn.click();
                } else if (e.key === 'ArrowRight' && nextBtn) {
                    nextBtn.click();
                } else if (e.key === 'Escape') {
                    $('#previewModal').modal('hide');
                }
            }
        });

        $('#previewModal').on('show.bs.modal', function() {
            if (currentFiles && currentFiles.length > 0) {
                showSlide(0);
            }
        });

        $('#ajukanPerubahanBtn').on('click', function() {
            const lpjId = $('#detailModal').data('lpj-id');
            $('#pengajuan_lpj_id').val(lpjId);
            $('#detailModal').modal('hide');
            new bootstrap.Modal(document.getElementById('pengajuanModal')).show();
        });

        $('#submitPengajuanBtn').on('click', function() {
            const lpjId = $('#pengajuan_lpj_id').val();
            const alasan = $('#alasan').val();

            if (!alasan.trim()) {
                alert('Alasan harus diisi.');
                return;
            }

            $.ajax({
                url: "<?php echo e(route('admin.laporan-lpj.pengajuan.store')); ?>",
                type: 'POST',
                data: {
                    _token: '<?php echo e(csrf_token()); ?>',
                    lpj_id: lpjId,
                    alasan: alasan,
                    user_id: <?php echo e(auth()->id()); ?>

                },
                success: function(response) {
                    if (response.success) {
                        $('#alasan').val('');
                        $('#pengajuan_lpj_id').val('');
                        $('#pengajuanModal').modal('hide');

                        // Setelah pengajuan berhasil, ubah status menjadi Terkunci
                        const statusIcon = document.getElementById('statusIcon');
                        const ajukanPerubahanBtn = document.getElementById(
                            'ajukanPerubahanBtn');

                        if (statusIcon) {
                            statusIcon.innerHTML =
                                '<i class="fas fa-lock me-1"></i> Terkunci';
                            statusIcon.className =
                                'badge bg-danger fs-7 d-flex align-items-center';
                        }

                        if (ajukanPerubahanBtn) {
                            ajukanPerubahanBtn.style.display = 'inline-flex';
                        }

                        showNotification('Pengajuan berhasil dikirim.', 'success');
                    } else {
                        showNotification(response.message || 'Gagal mengirim pengajuan.',
                            'error');
                    }
                },
                error: function() {
                    showNotification('Terjadi kesalahan. Silakan coba lagi.', 'error');
                }
            });
        });

        $('#pengajuanModal').on('hidden.bs.modal', function() {
            $('#alasan').val('');
            $('#pengajuan_lpj_id').val('');
        });

        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\ThinkPad\OneDrive\Dokumen\GitHub\web-koni\resources\views/admin/laporan-lpj/kegiatan-lainnya/index.blade.php ENDPATH**/ ?>