<?php $__env->startSection('pageTitle', 'Manajemen Kegiatan Lainnya'); ?>
<?php $__env->startSection('mainSection', 'Laporan Pertanggungjawaban'); ?>
<?php $__env->startSection('currentSection', 'Kegiatan Lainnya'); ?>

<?php $__env->startSection('breadcrumb-title'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb-items'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <style>
        #detailModal .btn-outline-primary:hover,
        #detailModal .btn-outline-danger:hover {
            color: #212529 !important;
            background-color: #e9ecef !important;
            border-color: #dee2e6 !important;
        }

        body {
            background-color: #f5f5f5;
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
            width: 150px;
        }

        .table th:nth-child(4) {
            width: 100px;
        }

        .table th:nth-child(5) {
            width: 120px;
        }

        .table th:nth-child(6) {
            width: 80px;
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

        #exportBtn {
            background-color: #0d6efd; /* Blue color like other primary buttons */
            color: white;
            font-weight: 600;
            border: none;
            border-radius: 8px; /* Rounded corners */
            padding: 8px 14px;
            display: inline-flex;
            align-items: center;
            gap: 6px; /* for icon if added */
            font-size: 0.9rem;
            transition: all 0.2s ease;
            box-shadow: 0 2px 6px rgba(13, 110, 253, 0.3);
        }

        #exportBtn:hover {
            background-color: #0b5ed7; /* Slightly darker on hover */
            box-shadow: 0 3px 8px rgba(13, 110, 253, 0.4);
            transform: translateY(-1px);
        }

        #exportBtn:active {
            background-color: #0a58ca;
            transform: translateY(0);
            box-shadow: 0 2px 4px rgba(13, 110, 253, 0.3);
        }

        #ajukanPerubahanBtn {
            background-color: #4CAF50; /* Soft green like screenshot */
            color: white;
            font-weight: 600;
            border: none;
            border-radius: 8px; /* Rounded corners */
            padding: 8px 14px;
            display: inline-flex;
            align-items: center;
            gap: 6px; /* for icon if added */
            font-size: 0.9rem;
            transition: all 0.2s ease;
            box-shadow: 0 2px 6px rgba(76, 175, 80, 0.3);
        }

        #export-pdf-btn {
            background-color: #e63946;
            color: white;
            font-weight: 600;
            border: none;
            border-radius: 8px;
            padding: 8px 14px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.9rem;
            transition: all 0.2s ease;
            box-shadow: 0 2px 6px rgba(230, 57, 70, 0.3);
        }

        #export-pdf-btn:hover {
            background-color: #d62828;
            box-shadow: 0 3px 8px rgba(214, 40, 40, 0.4);
            transform: translateY(-1px);
        }

        #ajukanPerubahanBtn:hover {
            background-color: #43a047; /* Slightly darker on hover */
            box-shadow: 0 3px 8px rgba(76, 175, 80, 0.4);
            transform: translateY(-1px);
        }

        #ajukanPerubahanBtn:active {
            background-color: #388e3c;
            transform: translateY(0);
            box-shadow: 0 2px 4px rgba(76, 175, 80, 0.3);
        }

        .top-progress-wrapper {
            background: white;
            border: 1px solid #e9ecef;
            border-radius: 16px;
            padding: 20px 25px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }

        .required::after {
            content: " *";
            color: #dc3545;
        }

        .btn-loading {
            position: relative;
            pointer-events: none;
            opacity: 0.7;
        }

        .btn-loading::after {
            content: '';
            position: absolute;
            width: 16px;
            height: 16px;
            top: 50%;
            left: 50%;
            margin-left: -8px;
            margin-top: -8px;
            border: 2px solid transparent;
            border-top-color: currentColor;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>

    <div class="d-flex flex-column mb-8">
        <h1 class="text-dark fw-bold mb-1">Kegiatan Lainnya</h1>
        <div class="text-muted fw-semibold fs-6">Manajemen Laporan Kegiatan Lainnya Anda Sekarang</div>
    </div>

    <?php if(isset($current_budget) && isset($target_anggaran)): ?>
    <div class="top-progress-wrapper mb-4">
        <div class="d-flex justify-content-between mt-2">
            <h3 class="text-muted mb-4">Total Anggaran</h3>
            <span class="text-muted">
                <a href="#" data-bs-toggle="modal" data-bs-target="#editTargetModal">
                    <i class="fa-solid fa-pen-to-square"></i>
                </a>
            </span>
        </div>
        <div class="d-flex justify-content-between mb-2">
            <?php
                $percentage = ($target_anggaran > 0) ? ($current_budget / $target_anggaran) * 100 : 0;
            ?>
            <h1 class="fw-bold mb-1">Rp <?php echo e(number_format($current_budget, 0, ",", ".")); ?> / Rp <?php echo e(number_format($target_anggaran, 0, ",", ".")); ?></h1>
            <h3 class="text-muted mb-0" data-bs-toggle="tooltip" title="<?php echo e(round($percentage, 2)); ?>% dari total anggaran">
                <?php echo e(round($percentage)); ?>%
            </h3>
        </div>

        <div class="progress" style="height: 18px; border-radius: 12px; background-color: #f1f1f1;">
            <div class="progress-bar progress-bar-striped progress-bar-animated"
                role="progressbar"
                style="width: <?php echo e($percentage); ?>%; background-color: #F8285A; border-radius: 12px;"
                aria-valuenow="<?php echo e($percentage); ?>"
                aria-valuemin="0"
                aria-valuemax="100">
            </div>
        </div>

        <div class="d-flex flex-row-reverse bd-highlight mt-2">
            <div class="info-label mt-1 d-flex align-items-center gap-2">
                <span class="badge bg-success-subtle text-success fw-semibold px-3 py-1 border border-success-subtle">
                    <?php echo e($kegiatan_count ?? 0); ?> Kegiatan Berjalan
                </span>
                <span>/
                </span>
                <span class="badge bg-primary-subtle text-primary fw-semibold px-3 py-1 border border-primary-subtle">
                    <?php echo e($target_kegiatan ?? 0); ?> Target Kegiatan
                </span>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <div class="col-12 mt-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap py-5">
                <h3 class="card-title fw-bold fs-4 mb-0">Daftar Kegiatan Lainnya - 2025</h3>

                <div class="d-flex align-items-center gap-2 flex-wrap ms-auto">
                    <a href="<?php echo e(route('admin.laporan-lpj.kegiatan-lainnya.create')); ?>" class="btn btn-primary"
    style="background-color: #F8285A !important; color: white !important; border-color: #F8285A !important;">
    <i class="ki-duotone ki-plus fs-2" style="color: white !important;"></i>Tambah Laporan
</a>

                    <div class="input-group position-relative" style="width: 250px;">
                        <input type="search" name="search" id="search" class="form-control"
                            placeholder="Cari kegiatan..." value="<?php echo e(request('search')); ?>" autocomplete="off">

                        <button class="btn btn-outline-secondary search-clear-btn d-none" type="button" id="clear-search"
                            style="position: absolute; right: 55px; z-index: 10; border: none; background: transparent; padding: 8px;">
                            <i class="fas fa-times text-muted"></i>
                        </button>

                        <button class="btn btn-outline-secondary" type="button" id="search-button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>

                    <div class="dropdown" style="z-index: 1055">

                        <div class="dropdown-menu p-3 shadow" style="min-width: 320px;">


                            <div class="d-flex gap-2">

                            </div>
                        </div>
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
    </div>

    <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header" style="background: white; color: #333; border-bottom: 1px solid #dee2e6 !important;">
                    <h5 class="modal-title" id="previewModalLabel" style="color: #333 !important;">Preview Files</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body p-0" style="height: 70vh;">
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
                    <h5 class="modal-title me-1" id="detailModalLabel" style="color: #333 !important;">Detail Kegiatan</h5>
                    <span id="statusIcon" class="ms-2 fs-6 gap-3"></span>

                    <div class="ms-auto d-flex align-items-center gap-2">
                        <button type="button" id="export-pdf-btn" class="btn">
                            <i class="fa-solid fa-file-export" style="color: white"></i>
                            Export Data
                        </button>
                        <button type="button" id="ajukanPerubahanBtn" class="btn">
                            <i class="bi bi-arrow-repeat" style="color: white"></i>
                            <strong>Ajukan Perubahan</strong>
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

    
    <div class="modal fade" id="pengajuanModal" tabindex="-1" aria-labelledby="pengajuanModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                                       <h5 class="modal-title" id="pengajuanModalLabel">Ajukan Perubahan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="pengajuanForm">
                        <input type="hidden" id="pengajuan_lpj_id" name="lpj_id">
                        <div class="mb-3">
                            <label for="alasan" class="form-label">Alasan Perubahan</label>
                            <textarea class="form-control" id="alasan" name="alasan" rows="4" required></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="submitPengajuanBtn">Kirim Pengajuan</button>
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
    }

    function initializeTooltips() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            var tooltip = new bootstrap.Tooltip(tooltipTriggerEl, {
                trigger: 'hover',
                html: true,
                delay: { show: 0, hide: 300 },
                fallbackPlacements: ['left', 'top', 'bottom']
            });

            // Variabel untuk menyimpan timeout
            var hideTimeout;

            // Menangani event saat kursor masuk ke elemen trigger
            tooltipTriggerEl.addEventListener('mouseenter', function () {
                clearTimeout(hideTimeout);
            });

            // Menangani event saat kursor keluar dari elemen trigger
            tooltipTriggerEl.addEventListener('mouseleave', function () {
                hideTimeout = setTimeout(function() {
                    tooltip.hide();
                }, 300);
            });

            // Menangani event saat tooltip ditampilkan
            tooltipTriggerEl.addEventListener('shown.bs.tooltip', function () {
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
        // Explicitly turn off any hover events that might be attached by other scripts or cached versions
        $(document).off('mouseenter mouseleave', '.dropdown-action');
        $(document).off('mouseenter mouseleave', '.dropdown-menu-custom');

        $(document).off('click', '.dropdown-toggle-custom');

        $(document).on('click', '.dropdown-toggle-custom', function(e) {
            e.preventDefault();
            e.stopPropagation();

            const $dropdownAction = $(this).closest('.dropdown-action');
            const $menu = $dropdownAction.find('.dropdown-menu-custom');

            $('.dropdown-menu-custom').not($menu).removeClass('show');

            $menu.toggleClass('show');

            checkDropdownPosition($dropdownAction);
        });

        function checkDropdownPosition($dropdownAction) {
            const $menu = $dropdownAction.find('.dropdown-menu-custom');
            if (!$menu.hasClass('show')) return;

            // Selalu hapus class dropup agar dropdown selalu muncul ke bawah
            $dropdownAction.removeClass('dropup');
            
            // Tambahkan pemeriksaan untuk memastikan dropdown tidak keluar dari viewport
            const dropdownRect = $dropdownAction[0].getBoundingClientRect();
            const menuRect = $menu[0].getBoundingClientRect();
            const viewportHeight = window.innerHeight;
            
            // Jika dropdown akan keluar dari viewport bagian bawah, tetap paksa ke bawah
            // dengan menyesuaikan posisi maksimal
            if (dropdownRect.bottom + menuRect.height > viewportHeight) {
                // Tetap paksa dropdown ke bawah
                $dropdownAction.removeClass('dropup');
                // Sesuaikan posisi jika perlu
                const overflow = dropdownRect.bottom + menuRect.height - viewportHeight;
                if (overflow > 0) {
                    $menu.css('max-height', menuRect.height - overflow - 10);
                    $menu.css('overflow-y', 'auto');
                }
            } else {
                // Reset styling jika tidak diperlukan
                $menu.css('max-height', '');
                $menu.css('overflow-y', '');
            }
        }

        $(document).on('click', function(e) {
            if (!$(e.target).closest('.dropdown-action').length) {
                $('.dropdown-menu-custom').removeClass('show');
            }
        });

        $(window).on('resize', function() {
            $('.dropdown-action').each(function() {
                if ($(this).find('.dropdown-menu-custom').hasClass('show')) {
                    checkDropdownPosition($(this));
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
        }[type] || 'alert-info';

        const notification = $(
            `<div class=\"alert ${alertClass} alert-dismissible fade show notification-toast\"
                 role=\"alert\" style=\"position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px;\">
                ${message}
                <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button>
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
            const originalName = typeof file === 'object' && file.original_name ? file.original_name : path.split('/').pop();

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
        const originalName = typeof file === 'object' && file.original_name ? file.original_name : path.split('/').pop();

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
                            text: response.message || 'Data laporan kegiatan lainnya berhasil dihapus',
                            icon: 'success',
                            timer: 1500,
                            showConfirmButton: false
                        }).then(function () {
                            window.location.reload();
                        });
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
                                    text: response.message || 'Gagal menghapus data laporan kegiatan lainnya',
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

    // REPLACED FUNCTION
    window.showDetailModal = function(data) {
        const modalBody = document.getElementById('detailModalBody');
        const statusIcon = document.getElementById('statusIcon');
        const exportBtn = document.getElementById('export-pdf-btn');
        const ajukanBtn = document.getElementById('ajukanPerubahanBtn');

        if (exportBtn) {
            exportBtn.setAttribute('data-lpj-id', data.id);
            // exportBtn.style.backgroundColor = '#e63946'; // Red color
        }

        // Status indicator & Button Logic
        if (statusIcon && ajukanBtn) {
            // Check if user has direct permission to modify (superadmin)
            const hasDirectPermission = <?php echo e(auth()->user()->can('pengajuan-modifikasi-laporan-manage') ? 'true' : 'false'); ?>;
            
            // Check if there's an approved pengajuan for the current user
            let approvedPengajuan = null;
            if (data.pengajuan && Array.isArray(data.pengajuan)) {
                // Filter for pengajuan that are approved, belong to current user, and have tokens remaining
                approvedPengajuan = data.pengajuan.find(p => 
                    p.user_id == <?php echo e(auth()->id()); ?> && 
                    p.status === 'disetujui' && 
                    p.token > 0
                );
            } else if (data.pengajuan) {
                // If pengajuan is a single object (hasOne relationship)
                if (data.pengajuan.user_id == <?php echo e(auth()->id()); ?> && 
                    data.pengajuan.status === 'disetujui' && 
                    data.pengajuan.token > 0) {
                    approvedPengajuan = data.pengajuan;
                }
            }
            
            // Check if the current user is the one allowed to modify and has approved pengajuan
            const hasApprovedPengajuan = data.modifiable_by_user_id == <?php echo e(auth()->id()); ?> && approvedPengajuan;
            
            // Determine if can modify based on permissions or approved pengajuan
            const canModify = hasDirectPermission || hasApprovedPengajuan;

            if (canModify) {
                statusIcon.innerHTML = 'Terbuka';
                statusIcon.className = 'badge border-success text-success bg-opacity-20 bg-success fs-7';
                ajukanBtn.style.display = 'none'; // Hide "Ajukan Perubahan" when approved
                exportBtn.style.display = ''; // Show "Export"
            } else {
                statusIcon.innerHTML = 'Terkunci';
                statusIcon.className = 'badge border-danger text-danger bg-opacity-20 bg-danger fs-7';
                ajukanBtn.style.display = ''; // Show "Ajukan Perubahan"
                exportBtn.style.display = ''; // Export is always visible
            }
        }

        $('#detailModal').data('lpj-id', data.id);

        const formatRupiah = (num) => 'Rp ' + (parseInt(num, 10) || 0).toLocaleString('id-ID');

        let fotoJurnalHtml = '<div class="text-muted fst-italic">Tidak ada foto tersedia</div>';
        if (data.foto_jurnal && data.foto_jurnal.length) {
            fotoJurnalHtml = `
                <div class="row g-3">
                    ${data.foto_jurnal.map(f => {
                        const path = typeof f === 'object' ? f.path : f;
                        return `
                        <div class="col-6 col-md-4">
                            <div class="border rounded overflow-hidden" style="height:120px">
                                <img src="/storage/${path}" class="w-100 h-100"
                                    style="object-fit:cover;cursor:pointer"
                                    onclick="showPreviewModal(${JSON.stringify(data.foto_jurnal)}, 'image', 'Foto Kegiatan')">
                            </div>
                        </div>`
                    }).join('')}
                </div>`;
        }

        let dokumenHtml = '<div class="text-muted fst-italic">Tidak ada dokumen tersedia</div>';
        if (data.dokumen_lpj && data.dokumen_lpj.length) {
            dokumenHtml = `
                <div class="d-flex flex-column gap-2">
                    ${data.dokumen_lpj.map(d => {
                        const path = typeof d === 'object' ? d.path : d;
                        const name = path.split('/').pop();
                        const ext = name.split('.').pop().toLowerCase();
                        const icon = getFileIcon(ext);
                        return `
                            <div class="d-flex align-items-center p-2 border rounded bg-light">
                                <i class="${icon} me-3" style="font-size:1.2em"></i>
                                <div class="flex-grow-1">
                                    <div class="fw-medium">${name}</div>
                                    <small class="text-muted">${ext.toUpperCase()}</small>
                                </div>
                                <a href="/storage/${path}" target="_blank" class="btn btn-outline-primary btn-sm me-2">
                                    <i class="fas fa-download me-1"></i>Unduh
                                </a>
                            </div>`;
                    }).join('')}
                </div>`;
        }
        
        let dokumenLpjPdfHtml = '';
        if (data.dokumen_lpj_pdf) {
            const path = typeof data.dokumen_lpj_pdf === 'object' ? data.dokumen_lpj_pdf.path : data.dokumen_lpj_pdf;
            const name = path.split('/').pop();
            dokumenLpjPdfHtml = `
            <div class="mb-3">
                <label class="fw-semibold mb-2 d-block"><i class="fas fa-file-pdf text-danger me-1"></i>Dokumen LPJ (PDF):</label>
                <div class="bg-light p-3 rounded">
                    <div class="d-flex align-items-center p-2 border rounded bg-white">
                        <i class="fas fa-file-pdf text-danger me-3" style="font-size:1.2em"></i>
                        <div class="flex-grow-1">
                            <div class="fw-medium">${name}</div>
                            <small class="text-muted">PDF</small>
                        </div>
                        <a href="/storage/${path}" target="_blank" class="btn btn-outline-danger btn-sm">
                            <i class="fas fa-download me-1"></i>Unduh
                        </a>
                    </div>
                </div>
            </div>`;
        }


        modalBody.innerHTML = `
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="mb-4">
                        <h6 class="fw-bold text-primary mb-3"><i class="fas fa-info-circle me-2"></i>Informasi Kegiatan</h6>
                        <div class="bg-light p-3 rounded">
                            <div class="mb-2">
                                <label class="fw-semibold mb-1">Nama Program:</label>
                                <p class="mb-0">${data.nama_program || 'N/A'}</p>
                            </div>
                            ${data.nama_kegiatan ? `
                                <div class="mb-2">
                                    <label class="fw-semibold mb-1">Nama Kegiatan:</label>
                                    <p class="mb-0">${data.nama_kegiatan}</p>
                                </div>
                            ` : ''}
                        </div>
                    </div>

                    <div class="mb-4">
                        <h6 class="fw-bold text-success mb-3"><i class="fas fa-calculator me-2"></i>Total Anggaran</h6>
                        <div class="bg-light p-3 rounded">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    
                                    <p class="mb-0 text-success fs-5 fw-bold">${formatRupiah(data.jumlah_harga)}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h6 class="fw-bold text-warning mb-3"><i class="fas fa-paperclip me-2"></i>Lampiran</h6>
                        <div class="mb-3">
                            <label class="fw-semibold mb-2 d-block"><i class="fas fa-camera me-1"></i>Foto Jurnal:</label>
                            <div class="bg-light p-3 rounded">${fotoJurnalHtml}</div>
                        </div>
                        <div>
                            <label class="fw-semibold mb-2 d-block"><i class="fas fa-file-alt me-1"></i>Dokumen Pendukung:</label>
                            <div class="bg-light p-3 rounded">${dokumenHtml}</div>
                        </div>
                        ${dokumenLpjPdfHtml}
                    </div>

                    ${data.keterangan_tambahan ? `
                        <div class="mb-2">
                            <h6 class="fw-bold mb-3"><i class="fas fa-sticky-note me-2"></i>Keterangan</h6>
                            <div class="bg-light p-3 rounded"><p class="mb-0" style="white-space: pre-wrap;">${data.keterangan_tambahan}</p></div>
                        </div>
                    ` : ''}
                </div>
            </div>
        `;

        new bootstrap.Modal(document.getElementById('detailModal')).show();
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

    initializeDataTable();
    initializeTooltips();
    initializeDropdownEvents();
    updateFilterCount();
    toggleClearButton();

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

    $('#apply-filters').on('click', function() {
        const jenisKegiatan = $('#filter-jenis-kegiatan').val();
        const startDate = $('#filter-start-date').val();
        const endDate = $('#filter-end-date').val();

        updateTable({
            'jenis_kegiatan_filter': jenisKegiatan,
            'start_date': startDate,
            'end_date': endDate,
            'page': 1
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
        });
    });

    $(document).on('change', 'select[name="per_page"]', function() {
        const perPage = $(this).val();
        updateTable({
            'per_page': perPage,
            'page': 1
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

            $('#export-pdf-btn').on('click', function() {
                const lpjId = $('#detailModal').data('lpj-id');

                if (!lpjId) {
                    alert('Terjadi kesalahan: ID laporan tidak ditemukan.');
                    return;
                }
                const exportUrl = `/admin/laporan-lpj/kegiatan-lainnya/${lpjId}/export`;
                window.open(exportUrl, '_blank');
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
                        if(response.success) {
                            $('#alasan').val('');
                            $('#pengajuan_lpj_id').val('');
                            $('#pengajuanModal').modal('hide');
                            showNotification('Pengajuan berhasil dikirim.', 'success');
                        } else {
                            showNotification(response.message || 'Gagal mengirim pengajuan.', 'error');
                        }
                    },
                    error: function() {
                        showNotification('Terjadi kesalahan. Silakan coba lagi.', 'error');
                    }
                });
            });

            $('#pengajuanModal').on('hidden.bs.modal', function () {
                $('#alasan').val('');
                $('#pengajuan_lpj_id').val('');
            });

            // Utility function to format rupiah
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

                return prefix + (split[1] ? rupiah + ',' + split[1] : rupiah);
            };

            const unformatRupiah = (rupiah) => parseInt(String(rupiah).replace(/[^0-9]/g, '')) || 0;

            // Format rupiah input
            $('#target_anggaran').on('keyup', function() {
                $(this).val(formatRupiah($(this).val()));
            });

            // Save target button
            $('#saveTargetBtn').on('click', function() {
                const $submitBtn = $(this);
                const $targetInput = $('#target_anggaran');
                const unformattedValue = unformatRupiah($targetInput.val());

                $targetInput.val(unformattedValue);
                const formData = $('#editTargetForm').serialize();
                $targetInput.val(formatRupiah(unformattedValue));

                $submitBtn.addClass('btn-loading').prop('disabled', true);

                $.ajax({
                    url: "<?php echo e(route('admin.laporan-lpj.kegiatan-lainnya.update-target')); ?>",
                    type: 'POST',
                    data: formData,
                    headers: { 'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>' },
                    success: function(response) {
                        $submitBtn.removeClass('btn-loading').prop('disabled', false);

                        if (response.success) {
                            $('#editTargetModal').modal('hide');
                            showNotification('Target berhasil diperbarui.', 'success');
                            setTimeout(() => window.location.reload(), 100);
                        } else {
                            showNotification(response.message || 'Gagal memperbarui target.', 'error');
                        }
                    },
                    error: function(xhr) {
                        $submitBtn.removeClass('btn-loading').prop('disabled', false);

                        if (xhr.status === 422 && xhr.responseJSON?.errors) {
                            Object.entries(xhr.responseJSON.errors).forEach(([field, messages]) => {
                                const $field = $('#editTargetForm').find(`[name="${field}"]`);
                                $field.addClass('is-invalid');
                                $field.siblings('.invalid-feedback').text(messages.join(', '));
                            });
                        } else {
                            showNotification('Terjadi kesalahan. Silakan coba lagi.', 'error');
                        }
                    }
                });
            });

        });
    </script>

    
    <div class="modal fade" id="editTargetModal" tabindex="-1" aria-labelledby="editTargetModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 gap-5 px-10 py-8">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="fs-2 fw-bold leading-5">Edit Target Anggaran & Kegiatan</div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="editTargetForm" class="d-grid gap-4">
                    <div>
                        <div class="fw-semibold required mb-3 text-gray-800">Target Anggaran</div>
                        <input type="text" name="target_anggaran" id="target_anggaran"
                               value="Rp <?php echo e(number_format($target_anggaran ?? 0, 0, ",", ".")); ?>"
                               placeholder="Masukkan target anggaran"
                               class="form-control bg-light border border-gray-400" required />
                        <div class="invalid-feedback"></div>
                    </div>

                    <div>
                        <div class="fw-semibold required mb-3 text-gray-800">Target Kegiatan</div>
                        <input type="number" name="target_kegiatan" id="target_kegiatan"
                               value="<?php echo e($target_kegiatan ?? 0); ?>"
                               placeholder="Masukkan jumlah target kegiatan"
                               class="form-control bg-light border border-gray-400" required />
                        <div class="invalid-feedback"></div>
                    </div>
                </form>

                <div class="d-grid py-4">
                    <button type="button" id="saveTargetBtn"
                            class="bg-danger fw-bold d-flex align-items-center justify-content-center gap-2 rounded border-0 p-4 text-white">
                        <span class="btn-text">Simpan Target</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/thur/Documents/Inotive/web-koni/resources/views/admin/laporan-lpj/kegiatan-lainnya/index.blade.php ENDPATH**/ ?>