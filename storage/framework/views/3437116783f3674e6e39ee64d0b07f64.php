<?php $__env->startSection('pageTitle', 'Database Bendahara'); ?>
<?php $__env->startSection('mainSection', 'Menu Utama'); ?>
<?php $__env->startSection('currentSection', 'Database Bendahara'); ?>

<?php $__env->startSection('style'); ?>
    <style>
        /* Match page background with Sekretariat & Kegiatan Lainnya */
        body {
            background-color: #f5f5f5;
        }

        .filter-container {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .search-container {
            position: relative;
            width: 200px;
        }

        .search-input {
            padding-left: 45px !important;
        }

        .search-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            pointer-events: none;
            z-index: 10;
        }

        .filter-dropdown {
            position: relative;
            width: 200px;
        }

        .filter-btn {
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 8px 16px;
            font-size: 0.95rem;
            color: #495057;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            text-align: left;
        }

        .filter-btn:hover {
            border-color: #F8285A;
            color: #F8285A;
        }

        .filter-btn.filter-active.fas.fa-file-pdf {
            background-color: #F8285A;
            border-color: #F8285A;
            color: white !important;
        }

        .filter-menu {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            z-index: 1000;
            margin-top: 4px;
            display: none;
        }

        .filter-menu.show {
            display: block;
        }

        .filter-option {
            padding: 12px 16px;
            cursor: pointer;
            transition: background-color 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #f8f9fa;
        }

        .filter-option:last-child {
            border-bottom: none;
        }

        .filter-option:hover {
            background-color: #f8f9fa;
        }

        .filter-option.active {
            background-color: #F8285A;
            color: white;
        }

        .filter-option .file-type-icon {
            margin-right: 8px;
            font-size: 16px;
        }

        .filter-option .filter-count {
            font-size: 0.85rem;
            opacity: 0.8;
        }

        .date-filter-container {
            position: relative;
            width: auto;
            /* Changed from 200px to auto */
        }

        .date-filter-btn {
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 8px 12px;
            /* Reduced padding */
            font-size: 0.95rem;
            color: #495057;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            /* Center the icon */
            min-width: 38px;
            /* Minimum width for the button */
            height: 38px;
            /* Fixed height */
        }

        .date-filter-btn:hover {
            border-color: #F8285A;
            color: #F8285A;
        }

        .date-filter-btn.date-filter-active {
            background-color: #F8285A;
            border-color: #F8285A;
            color: white;
        }

        /* Hide the text span, only show icon */
        .date-filter-btn .filter-text {
            display: none;
        }

        .date-filter-btn .fas.fa-chevron-down {
            display: none;
        }

        .date-filter-menu.show {
            display: block;
        }

        .date-presets {
            margin-bottom: 16px;
            padding-bottom: 16px;
            border-bottom: 1px solid #f8f9fa;
        }

        .date-presets-label {
            font-size: 0.85rem;
            font-weight: 500;
            color: #6c757d;
            margin-bottom: 8px;
        }

        .date-preset-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }

        .date-preset-btn {
            padding: 4px 12px;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 16px;
            font-size: 0.8rem;
            color: #6c757d;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .date-preset-btn:hover {
            background-color: #e9ecef;
            border-color: #adb5bd;
        }

        .date-preset-btn.active {
            background-color: #F8285A;
            border-color: #F8285A;
            color: white;
        }

        .date-input-group {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .date-input-wrapper {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .date-input-label {
            font-size: 0.875rem;
            font-weight: 600;
            color: #374151;
        }

        .date-input {
            padding: 8px 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 0.875rem;
            color: #374151;
            background-color: #fff;
            transition: border-color 0.2s ease;
        }

        .date-input:focus {
            outline: none;
            border-color: #F8285A;
            box-shadow: 0 0 0 3px rgba(248, 40, 90, 0.1);
        }

        .date-filter-actions {
            display: flex;
            gap: 8px;
            margin-top: 12px;
            padding-top: 12px;
            border-top: 1px solid #e5e7eb;
        }

        .date-filter-apply {
            flex: 1;
            background-color: #F8285A;
            color: white;
            border: none;
            border-radius: 6px;
            padding: 8px 16px;
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .date-filter-apply:hover {
            background-color: #e1244e;
        }

        .date-filter-clear {
            background-color: #f3f4f6;
            color: #6b7280;
            border: none;
            border-radius: 6px;
            padding: 8px 16px;
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .date-filter-clear:hover {
            background-color: #e5e7eb;
        }

        .table-loading {
            opacity: 0.6;
            pointer-events: none;
        }

        .preview-modal .modal-dialog {
            max-width: 90vw;
            height: 90vh;
        }

        .preview-modal .modal-content {
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .preview-modal .modal-body {
            flex: 1;
            padding: 0;
            overflow: hidden;
        }

        .preview-modal iframe {
            width: 100%;
            height: 100%;
            border: none;
        }

        .preview-error {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 300px;
            text-align: center;
            color: #6c757d;
        }

        .preview-error i {
            font-size: 4rem;
            margin-bottom: 1rem;
            color: #dc3545;
        }

        .modal-content * {
            max-width: 100%;
            box-sizing: border-box;
        }

        /* Specific fix for the current file section */
        .mt-2.p-3.bg-light.rounded {
            max-width: 100%;
            overflow: hidden;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        /* Force filename to break and wrap */
        .mt-2.p-3.bg-light.rounded a {
            display: block;
            word-break: break-all !important;
            overflow-wrap: break-word !important;
            white-space: normal !important;
            line-height: 1.3;
            max-width: 100%;
            hyphens: auto;
        }

        /* Alternative: Truncate with ellipsis if you prefer single line */
        .filename-truncate {
            display: block;
            width: 100%;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 400px;
            /* Adjust as needed */
        }

        /* Form elements should also respect modal width */
        .modal .form-control,
        .modal .dropzone {
            max-width: 100%;
            box-sizing: border-box;
        }

        /* Mobile responsive adjustments */
        @media (max-width: 576px) {
            .modal-dialog {
                max-width: 95vw !important;
                margin: 10px auto;
            }

            .modal-content {
                margin: 0;
                border-radius: 8px;
            }
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
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Enhanced table styling to match header */
        .table tbody td {
            font-weight: 600 !important;
            color: #374151 !important;
            font-size: 0.95rem !important;
            padding: 16px 12px !important;
            vertical-align: middle !important;
        }

        .table tbody td.fw-bold {
            font-weight: 700 !important;
            color: #1f2937 !important;
        }

        .table tbody td small {
            font-weight: 500 !important;
            color: #6b7280 !important;
            font-size: 0.8rem !important;
        }

        .table thead th {
            font-weight: 700 !important;
            color: #374151 !important;
            font-size: 0.9rem !important;
            letter-spacing: 0.025em !important;
            text-transform: uppercase !important;
        }

        .date-filter-menu {
            position: absolute;
            top: 100%;
            right: 0;
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            z-index: 1000;
            margin-top: 4px;
            display: none;
            width: 300px;
            padding: 16px;
        }

        .date-filter-menu.show {
            display: block;
        }

        @media (max-width: 768px) {
            .filter-container {
                flex-direction: column;
                align-items: stretch;
                gap: 10px;
            }

            .search-container,
            .filter-dropdown {
                width: 100%;
            }

            .date-filter-container {
                width: auto;
                align-self: flex-start;
            }

            .date-filter-menu {
                right: 0;
                left: 0;
                min-width: 100%;
                max-width: calc(100vw - 20px);
                margin-left: 0;
                margin-right: 0;
            }
        }

        .date-filter-container.position-left .date-filter-menu {
            right: auto;
            left: 0;
            transform-origin: top left;
        }

        .date-filter-menu.align-right {
            right: 0;
            left: auto;
        }

        .date-filter-menu.align-left {
            right: auto;
            left: 0;
        }

        .date-filter-btn.date-filter-active .fas.fa-calendar,
        .date-filter-btn.date-filter-active .fas.fa-calendar-check {
            color: white !important;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="flex-wrap mb-2 d-flex justify-content-between align-items-center" style="padding:10px 30px">
        <h2 class="mb-0 fw-bold fs-2 text-dark">Database Bendahara</h2>
        <button id="tambahLaporanBtn" class="btn"
            style="background-color: #F8285A !important; color: white !important; border-color: #F8285A !important; border-radius: 8px; padding: 12px 20px; font-weight: 500;">
            <i class="ki-duotone ki-plus fs-4 me-2" style="color: white !important;"></i>Tambah Laporan
        </button>
    </div>
    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="gap-5 border-0 d-grid">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-none d-md-block">
                                        <h3 class="mb-0 fw-bold fs-4">Database Bendahara</h3>
                                        <div class="text-muted small">Kelola laporan bendahara</div>
                                    </div>

                                    <form id="filter" class="gap-3 d-flex filter-container">
                                        

                                        <div class="date-filter-container">
                                            <div class="date-filter-btn <?php echo e(request('date_from') || request('date_to') ? 'date-filter-active' : ''); ?>"
                                                id="dateFilterBtn">
                                                <?php if(request('date_from') || request('date_to')): ?>
                                                    <i class="fas fa-calendar-check"></i>
                                                <?php else: ?>
                                                    <i class="fas fa-calendar"></i>
                                                <?php endif; ?>
                                                <span class="filter-text">
                                                    <?php if(request('date_from') || request('date_to')): ?>
                                                        <?php if(request('date_from') && request('date_to')): ?>
                                                            <?php echo e(\Carbon\Carbon::parse(request('date_from'))->format('d/m/Y')); ?>

                                                            -
                                                            <?php echo e(\Carbon\Carbon::parse(request('date_to'))->format('d/m/Y')); ?>

                                                        <?php elseif(request('date_from')): ?>
                                                            Dari
                                                            <?php echo e(\Carbon\Carbon::parse(request('date_from'))->format('d/m/Y')); ?>

                                                        <?php else: ?>
                                                            Sampai
                                                            <?php echo e(\Carbon\Carbon::parse(request('date_to'))->format('d/m/Y')); ?>

                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                </span>
                                            </div>

                                            <div class="date-filter-menu" id="dateFilterMenu">
                                                <div class="date-presets">
                                                    <div class="date-presets-label">Preset Cepat:</div>
                                                    <div class="date-preset-buttons">
                                                        <button type="button" class="date-preset-btn"
                                                            data-preset="today">Hari Ini</button>
                                                        <button type="button" class="date-preset-btn"
                                                            data-preset="this-week">Minggu Ini</button>
                                                        <button type="button" class="date-preset-btn"
                                                            data-preset="this-month">Bulan Ini</button>
                                                        <button type="button" class="date-preset-btn"
                                                            data-preset="this-year">Tahun Ini</button>
                                                        <button type="button" class="date-preset-btn"
                                                            data-preset="last-30-days">30 Hari
                                                            Terakhir</button>
                                                    </div>
                                                </div>

                                                <div class="date-input-group">
                                                    <div class="date-input-wrapper">
                                                        <label class="date-input-label">Dari Tanggal</label>
                                                        <input type="date" name="date_from"
                                                            value="<?php echo e(request('date_from')); ?>" class="date-input"
                                                            id="dateFromInput">
                                                    </div>
                                                    <div class="date-input-wrapper">
                                                        <label class="date-input-label">Sampai Tanggal</label>
                                                        <input type="date" name="date_to"
                                                            value="<?php echo e(request('date_to')); ?>" class="date-input"
                                                            id="dateToInput">
                                                    </div>
                                                </div>

                                                <div class="date-filter-actions">
                                                    <button type="button" class="date-filter-apply"
                                                        id="applyDateFilter">Terapkan</button>
                                                    <button type="button" class="date-filter-clear"
                                                        id="clearDateFilter">Reset</button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="search-container">
                                            <div class="position-relative bg-light">
                                                <i class="ki-outline ki-magnifier fs-2 search-icon"></i>
                                                <input type="text" name="search" value="<?php echo e(request('search')); ?>"
                                                    placeholder="Cari laporan..."
                                                    class="py-2 border border-gray-500 form-control search-input" />
                                            </div>
                                        </div>

                                        
                                        

                                        <input type="hidden" name="filter_type" id="filter_type_input"
                                            value="<?php echo e(request('filter_type', 'all')); ?>">
                                        <input type="hidden" name="date_from" id="date_from_input"
                                            value="<?php echo e(request('date_from')); ?>">
                                        <input type="hidden" name="date_to" id="date_to_input"
                                            value="<?php echo e(request('date_to')); ?>">
                                        <input type="hidden" name="sort_by" id="sort_by_input"
                                            value="<?php echo e(request('sort_by', 'created_at')); ?>">
                                        <input type="hidden" name="order" id="order_input"
                                            value="<?php echo e(request('order', 'desc')); ?>">
                                    </form>
                                </div>

                                <div id="table">
                                    <?php echo $__env->make(
                                        'admin.bendahara._table',
                                        compact('laporanBendahara', 'fileCounts', 'currentSort'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="add" tabindex="-1" aria-labelledby="add" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="gap-5 px-10 py-8 modal-content rounded-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="leading-5 fs-2 fw-bold">Tambah Laporan Bendahara</div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="formAdd" action="<?php echo e(route('admin.bendahara.store')); ?>" method="POST"
                    enctype="multipart/form-data" class="gap-4 d-grid">
                    <?php echo csrf_field(); ?>

                    <div>
                        <div class="mb-3 text-gray-800 fw-semibold required">Judul Laporan</div>
                        <input type="text" name="judul" placeholder="Masukkan Judul Laporan"
                            class="border border-gray-400 form-control bg-light" required />
                        <div class="invalid-feedback"></div>
                    </div>

                    <div>
                        <div class="mb-3 text-gray-800 fw-semibold required">Tanggal Laporan</div>
                        <input type="date" name="tanggal" placeholder="Pilih Tanggal Laporan"
                            class="border border-gray-400 form-control bg-light" required />
                        <div class="invalid-feedback"></div>
                    </div>

                    <div>
                        <div class="mb-3 text-gray-800 fw-semibold required">Unggah Dokumen</div>
                        <div class="fv-row">
                            <div class="dropzone" id="dropzone-formAdd">
                                <div class="dz-message needsclick">
                                    <i class="ki-duotone ki-file-up fs-3x text-primary">
                                        <span class="path1"></span><span class="path2"></span>
                                    </i>
                                    <div class="ms-4">
                                        <h3 class="mb-1 text-gray-900 fs-5 fw-bold">Seret atau pilih dokumen.</h3>
                                        <span class="text-gray-500 fs-7 fw-semibold">Format: PDF, XLS, XLSX. Max. 10
                                            MB.</span>
                                    </div>
                                </div>
                            </div>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </form>

                <div class="py-4 d-grid">
                    <button type="button" onclick="submitForm('formAdd')" id="submitBtnAdd"
                        class="gap-2 p-4 text-white rounded border-0 bg-danger fw-bold d-flex align-items-center justify-content-center">
                        <span class="btn-text">Tambah Laporan</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- File Preview Modal -->
    <div class="modal fade preview-modal" id="filePreviewModal" tabindex="-1" aria-labelledby="filePreviewModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-truncate" id="filePreviewModalLabel">Preview Dokumen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="p-0 modal-body">
                    <div id="previewContainer" class="w-100 h-100">
                        <!-- Preview content will be loaded here -->
                    </div>
                </div>
                <div class="modal-footer">
                    <a id="downloadBtn" href="#" class="btn btn-primary" target="_blank">
                        <i class="ki-outline ki-down me-2"></i>Download File
                    </a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script>
        let currentFilter = '<?php echo e(request('filter_type', 'all')); ?>';
        let currentSort = '<?php echo e(request('sort_by', 'created_at')); ?>';
        let currentOrder = '<?php echo e(request('order', 'desc')); ?>';
        Dropzone.autoDiscover = false;
        const dropzones = {};

        function previewFile(fileUrl, fileName, fileExtension) {
            const modal = new bootstrap.Modal(document.getElementById('filePreviewModal'));
            const previewContainer = document.getElementById('previewContainer');
            const modalTitle = document.getElementById('filePreviewModalLabel');
            const downloadBtn = document.getElementById('downloadBtn');

            modalTitle.textContent = fileName;
            downloadBtn.href = fileUrl;

            previewContainer.innerHTML = '';

            const ext = fileExtension.toLowerCase();

            if (ext === 'pdf') {
                previewContainer.innerHTML =
                    `<iframe src="${fileUrl}" style="width:100%;height:70vh;border:none;"></iframe>`;
            } else if (['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg', 'webp'].includes(ext)) {
                previewContainer.innerHTML =
                    `<div class="d-flex justify-content-center align-items-center" style="height:70vh;"><img src="${fileUrl}" class="img-fluid" style="max-height:100%;max-width:100%;" alt="${fileName}"></div>`;
            } else if (['xls', 'xlsx'].includes(ext)) {
                previewContainer.innerHTML =
                    `<iframe src="https://docs.google.com/gview?url=${encodeURIComponent(fileUrl)}&embedded=true" style="width:100%;height:70vh;border:none;"></iframe>`;
            } else if (['doc', 'docx'].includes(ext)) {
                previewContainer.innerHTML =
                    `<iframe src="https://docs.google.com/gview?url=${encodeURIComponent(fileUrl)}&embedded=true" style="width:100%;height:70vh;border:none;"></iframe>`;
            } else {
                previewContainer.innerHTML =
                    `<div class="preview-error"><i class="fas fa-file"></i><h5>Preview tidak tersedia</h5><p>Jenis file ini tidak dapat dipreview.</p><small>Jenis file: ${ext.toUpperCase()}</small></div>`;
            }

            modal.show();
        }

        function updateDateFilterButton() {
            const dateFrom = $('#dateFromInput').val();
            const dateTo = $('#dateToInput').val();
            const button = $('#dateFilterBtn');

            // Clear existing content
            button.empty();

            if (dateFrom || dateTo) {
                button.addClass('date-filter-active');
                let dateText = '';
                let icon = '<i class="fas fa-calendar-check"></i>';

                if (dateFrom && dateTo) {
                    dateText = `${formatDateToIndonesian(dateFrom)} - ${formatDateToIndonesian(dateTo)}`;
                } else if (dateFrom) {
                    dateText = `Dari ${formatDateToIndonesian(dateFrom)}`;
                } else {
                    dateText = `Sampai ${formatDateToIndonesian(dateTo)}`;
                }

                // For mobile - show only icon, for desktop - show icon + text
                button.html(`
                    ${icon}
                    <span class="filter-text d-none d-md-inline ms-2">${dateText}</span>
                `);
            } else {
                button.removeClass('date-filter-active');
                let icon = '<i class="fas fa-calendar"></i>';
                button.html(`
                    ${icon}
                `);
            }
        }

        function reloadTable(url = null) {
            let formData = $('#filter').serialize();
            let target = url || "<?php echo e(route('admin.bendahara.index')); ?>";

            $.ajax({
                url: target,
                data: formData,
                beforeSend: function() {
                    $('#table').addClass('table-loading');
                    $('#table').html(
                        '<div class="py-20 text-center"><span class="spinner-border text-danger"></span></div>'
                    );
                },
                success: function(response) {
                    $('#table').removeClass('table-loading');
                    $('#table').html(response);
                    initializeDropzones();
                    initializeDropdownEvents();
                    initializeSortingEvents();
                    updateURL(formData);
                },
                error: function(xhr) {
                    $('#table').removeClass('table-loading');
                    $('#table').html(
                        '<div class="py-20 text-center text-danger fw-bold">Terjadi kesalahan saat memuat data.</div>'
                    );
                }
            });
        }

        function updateURL(formData) {
            if (window.history && window.history.pushState) {
                const url = new URL(window.location);
                const searchParams = new URLSearchParams(formData);
                for (const [key, value] of searchParams.entries()) {
                    if (value) url.searchParams.set(key, value);
                    else url.searchParams.delete(key);
                }
                window.history.pushState({}, '', url);
            }
        }

        function initializeSortingEvents() {
            $(document).off('click', '.sortable').on('click', '.sortable', function(e) {
                e.preventDefault();
                const sortBy = $(this).data('sort');
                let order = $(this).data('order');

                currentSort = sortBy;
                currentOrder = order;
                $('#sort_by_input').val(sortBy);
                $('#order_input').val(order);

                // Update data-order for next click
                const newOrder = order === 'asc' ? 'desc' : 'asc';
                $(this).data('order', newOrder);

                reloadTable();
            });
        }

        function initializeDropdownEvents() {
            $(document).off('click', '.dropdown-toggle-custom').on('click', '.dropdown-toggle-custom', function(e) {
                e.preventDefault();
                e.stopPropagation();
                $('.dropdown-menu-custom').removeClass('show');
                $(this).siblings('.dropdown-menu-custom').addClass('show');
            });

            $(document).on('click', function(e) {
                if (!$(e.target).closest('.dropdown-action').length) $('.dropdown-menu-custom').removeClass('show');
            });

            $(document).on('click', '.dropdown-menu-custom', function(e) {
                e.stopPropagation();
            });
        }

        function debounce(func, delay) {
            let timeout;
            return function() {
                const context = this,
                    args = arguments;
                clearTimeout(timeout);
                timeout = setTimeout(() => func.apply(context, args), delay);
            };
        }

        function initializeDropzones() {
            Object.keys(dropzones).forEach(key => {
                if (dropzones[key] && typeof dropzones[key].destroy === 'function') {
                    dropzones[key].destroy();
                    delete dropzones[key];
                }
            });

            if (document.getElementById('dropzone-formAdd')) {
                dropzones['formAdd'] = new Dropzone("#dropzone-formAdd", {
                    url: "#",
                    autoProcessQueue: false,
                    paramName: 'dokumen',
                    maxFiles: 1,
                    maxFilesize: 10,
                    addRemoveLinks: true,
                    acceptedFiles: '.pdf,.xls,.xlsx',
                });
            }

            document.querySelectorAll('[id^="dropzone-form-"]').forEach(element => {
                const formId = element.id.replace('dropzone-', '');
                if (!dropzones[formId]) {
                    dropzones[formId] = new Dropzone(`#${element.id}`, {
                        url: "#",
                        autoProcessQueue: false,
                        paramName: 'dokumen',
                        maxFiles: 1,
                        maxFilesize: 10,
                        addRemoveLinks: true,
                        acceptedFiles: '.pdf,.xls,.xlsx',
                    });
                }
            });
        }

        function submitForm(formId) {
            const formElement = document.getElementById(formId);
            if (!formElement) {
                toastr.error("Form tidak ditemukan", "Error!");
                return;
            }

            let formData = new FormData();
            let actionUrl;

            if (formId === 'formAdd') {
                formData = new FormData(formElement);
                actionUrl = formElement.action;
            } else {
                actionUrl = formElement.getAttribute('data-action');
                formElement.querySelectorAll('input, select, textarea').forEach(input => {
                    if (input.type === 'file') return;
                    if ((input.type === 'checkbox' || input.type === 'radio') && input.checked) {
                        formData.append(input.name, input.value);
                    } else if (input.type !== 'checkbox' && input.type !== 'radio') {
                        formData.append(input.name, input.value);
                    }
                });
            }

            const dz = dropzones[formId];
            if (dz && dz.getAcceptedFiles().length > 0) {
                dz.getAcceptedFiles().forEach(file => {
                    formData.append('dokumen', file);
                });
            }

            // Add loading state to button
            const submitBtn = document.querySelector(
                `#submitBtn${formId === 'formAdd' ? 'Add' : formId.replace('form-', '')}`);
            if (submitBtn) {
                submitBtn.classList.add('btn-loading');
                submitBtn.disabled = true;
            }

            fetch(actionUrl, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
                            '<?php echo e(csrf_token()); ?>',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: formData,
                })
                .then(async response => {
                    const data = await response.json();

                    // Remove loading state
                    if (submitBtn) {
                        submitBtn.classList.remove('btn-loading');
                        submitBtn.disabled = false;
                    }

                    if (!response.ok) {
                        if (data.errors) {
                            Object.entries(data.errors).forEach(([field, msgs]) => {
                                toastr.error(msgs.join(', '), "Error!");
                            });
                        } else {
                            toastr.error(data.message || "Gagal menyimpan data", "Error!");
                        }
                    } else {
                        // Reset form immediately after successful submission
                        if (formId === 'formAdd') {
                            resetFormAdd();
                        } else {
                            resetEditForm(formId);
                        }
                        window.location.reload();

                        $('.modal.show').addClass('submit-success');
                        $('.modal.show').modal('hide');

                        toastr.success(data.message || "Data berhasil disimpan", "Success!");
                        reloadTable();
                    }
                })
                .catch(error => {
                    // Remove loading state
                    if (submitBtn) {
                        submitBtn.classList.remove('btn-loading');
                        submitBtn.disabled = false;
                    }

                    toastr.error("Terjadi kesalahan. Silakan coba lagi.", "Error!");
                    console.error('Error:', error);
                });
        }

        function resetFormAdd() {
            const form = document.getElementById('formAdd');
            if (form) {
                form.reset();
                // Clear validation errors
                form.querySelectorAll('.invalid-feedback').forEach(el => {
                    el.textContent = '';
                });
                form.querySelectorAll('.is-invalid').forEach(el => {
                    el.classList.remove('is-invalid');
                });
            }

            // Reset dropzone
            if (dropzones['formAdd']) {
                dropzones['formAdd'].removeAllFiles();
            }
        }

        function resetEditForm(formId) {
            const form = document.getElementById(formId);
            if (form) {
                // Reset form fields to their original values
                const modal = $(form).closest('.modal');
                const originalData = modal.data('original-data');

                if (originalData) {
                    form.querySelectorAll('input, select, textarea').forEach(input => {
                        const name = input.getAttribute('name');
                        if (input.type !== 'file' && originalData.hasOwnProperty(name)) {
                            input.value = originalData[name];
                        }
                    });
                }

                // Clear validation errors
                form.querySelectorAll('.invalid-feedback').forEach(el => {
                    el.textContent = '';
                });
                form.querySelectorAll('.is-invalid').forEach(el => {
                    el.classList.remove('is-invalid');
                });
            }

            // Reset dropzone
            if (dropzones[formId]) {
                dropzones[formId].removeAllFiles();
            }
        }

        function deleteItemEnhanced(formId, itemName = 'item ini') {
            const form = document.getElementById(formId);
            if (!form) {
                toastr.error("Form tidak ditemukan", "Error!");
                return;
            }

            const route = form.action;

            Swal.fire({
                title: "Apakah Anda Yakin?",
                html: `<p style='text-align:center'>Setelah <strong>${itemName}</strong> dihapus, Anda tidak bisa mengembalikannya!</p>`,
                icon: "warning",
                showCancelButton: true,
                reverseButtons: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Hapus!',
                cancelButtonText: 'Batalkan!'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Menghapus...',
                        text: 'Mohon tunggu',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        willOpen: () => Swal.showLoading()
                    });

                    fetch(route, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: new FormData(form)
                        })
                        .then(response => response.json())
                        .then(data => {
                            Swal.close();
                            if (data.success) {
                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: data.message || 'Laporan berhasil dihapus',
                                    icon: 'success',
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                                reloadTable();
                            } else {
                                Swal.fire({
                                    title: 'Gagal!',
                                    text: data.message || 'Terjadi kesalahan saat menghapus',
                                    icon: 'error'
                                });
                            }
                        })
                        .catch(() => {
                            Swal.close();
                            Swal.fire({
                                title: 'Error!',
                                text: 'Terjadi kesalahan jaringan.',
                                icon: 'error'
                            });
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
        }

        function formatDateToIndonesian(dateString) {
            if (!dateString) return '';
            const date = new Date(dateString);
            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const year = date.getFullYear();
            return `${day}/${month}/${year}`;
        }

        function setDatePreset(preset) {
            console.log('setDatePreset called with:', preset); // Debug log

            const now = new Date();
            let startDate, endDate;

            switch (preset) {
                case 'today':
                    startDate = endDate = now.toISOString().split('T')[0];
                    break;
                case 'this-week':
                    // Get start of week (Monday)
                    const currentDay = now.getDay(); // 0 = Sunday, 1 = Monday, etc.
                    const mondayOffset = currentDay === 0 ? -6 : 1 - currentDay;

                    const startOfWeek = new Date(now);
                    startOfWeek.setDate(now.getDate() + mondayOffset);

                    const endOfWeek = new Date(startOfWeek);
                    endOfWeek.setDate(startOfWeek.getDate() + 6);

                    startDate = startOfWeek.toISOString().split('T')[0];
                    endDate = endOfWeek.toISOString().split('T')[0];
                    break;
                case 'this-month':
                    startDate = new Date(now.getFullYear(), now.getMonth(), 1).toISOString().split('T')[0];
                    endDate = new Date(now.getFullYear(), now.getMonth() + 1, 0).toISOString().split('T')[0];
                    break;
                case 'this-year':
                    startDate = new Date(now.getFullYear(), 0, 1).toISOString().split('T')[0];
                    endDate = new Date(now.getFullYear(), 11, 31).toISOString().split('T')[0];
                    break;
                case 'last-30-days':
                    endDate = now.toISOString().split('T')[0];
                    const thirtyDaysAgo = new Date(now);
                    thirtyDaysAgo.setDate(now.getDate() - 30);
                    startDate = thirtyDaysAgo.toISOString().split('T')[0];
                    break;
                default:
                    console.log('Unknown preset:', preset);
                    return;
            }

            console.log('Setting dates:', {
                startDate,
                endDate
            }); // Debug log

            // Update all the input fields
            const dateFromInput = document.getElementById('dateFromInput');
            const dateToInput = document.getElementById('dateToInput');
            const dateFromHidden = document.getElementById('date_from_input');
            const dateToHidden = document.getElementById('date_to_input');

            if (dateFromInput) dateFromInput.value = startDate;
            if (dateToInput) dateToInput.value = endDate;
            if (dateFromHidden) dateFromHidden.value = startDate;
            if (dateToHidden) dateToHidden.value = endDate;

            // Update preset button states
            $('.date-preset-btn').removeClass('active');
            $(`.date-preset-btn[data-preset="${preset}"]`).addClass('active');

            // Update the filter button display
            updateDateFilterButton();

            console.log(`Applied preset: ${preset}, Start: ${startDate}, End: ${endDate}`); // Debug log
        }

        function positionDateDropdown() {
            const $container = $('.date-filter-container');
            const $menu = $('.date-filter-menu');

            if ($menu.is(':visible')) {
                const containerRect = $container[0].getBoundingClientRect();
                const menuWidth = $menu.outerWidth();
                const viewportWidth = $(window).width();

                // Check if there's enough space on the right
                const spaceOnRight = viewportWidth - containerRect.right;

                if (spaceOnRight < menuWidth && containerRect.left > menuWidth) {
                    // Not enough space on right, but enough on left - align to left
                    $menu.removeClass('align-right').addClass('align-left');
                } else {
                    // Default: align to right
                    $menu.removeClass('align-left').addClass('align-right');
                }
            }
        }

        $(document).ready(function() {
            initializeDropzones();
            initializeDropdownEvents();
            initializeSortingEvents();
            updateDateFilterButton();

            // Add Laporan button
            $('#tambahLaporanBtn').on('click', function() {
                $('#add').modal('show');
            });

            // Filter dropdown events
            $('#filterBtn').on('click', function(e) {
                e.stopPropagation();
                $('#filterMenu').toggleClass('show');
                $('#dateFilterMenu').removeClass('show');
            });

            // Date filter button click handler
            $('#dateFilterBtn').on('click', function(e) {
                e.stopPropagation();
                const $menu = $('#dateFilterMenu');

                if ($menu.hasClass('show')) {
                    $menu.removeClass('show');
                } else {
                    // Close other menus
                    $('#filterMenu').removeClass('show');

                    // Show this menu
                    $menu.addClass('show');

                    // Position the dropdown after showing it
                    setTimeout(positionDateDropdown, 10);
                }
            });

            $(document).on('click', function() {
                $('#filterMenu').removeClass('show');
                $('#dateFilterMenu').removeClass('show');
            });

            $('#filterMenu, #dateFilterMenu').on('click', function(e) {
                if (!$(e.target).hasClass('date-preset-btn')) {
                    e.stopPropagation();
                }
            });

            // Filter option selection
            $('.filter-option').on('click', function(e) {
                e.stopPropagation();
                const filterType = $(this).data('filter');
                if (filterType === currentFilter) return;

                $('.filter-option').removeClass('active');
                $(this).addClass('active');

                const iconHtml = $(this).find('span').html();
                $('#filterBtn span').html(iconHtml);
                $('#filterBtn').toggleClass('filter-active', filterType !== 'all');

                currentFilter = filterType;
                $('#filter_type_input').val(filterType);
                reloadTable();
                $('#filterMenu').removeClass('show');
            });

            // Date preset buttons - SINGLE EVENT HANDLER
            $(document).off('click', '.date-preset-btn').on('click', '.date-preset-btn', function(e) {
                e.preventDefault();
                e.stopPropagation();

                console.log('Date preset button clicked - NEW HANDLER');
                console.log('Clicked element:', this);
                console.log('Event target:', e.target);

                const preset = $(this).data('preset') || $(this).attr('data-preset');
                console.log('Preset value:', preset);

                if (preset) {
                    setDatePreset(preset);
                } else {
                    console.error('No preset found!');
                }
            });

            // Also try adding a direct click handler as a fallback:
            $(document).on('click', '.date-preset-buttons button', function(e) {
                console.log('Alternative handler triggered');
                e.preventDefault();
                e.stopPropagation();

                const preset = $(this).data('preset') || $(this).attr('data-preset');
                console.log('Alternative handler - Preset value:', preset);

                if (preset) {
                    setDatePreset(preset);
                }
            });

            setTimeout(function() {
                console.log('=== DEBUGGING DATE PRESET ELEMENTS ===');
                console.log('Date preset buttons found:', document.querySelectorAll('.date-preset-btn')
                    .length);

                document.querySelectorAll('.date-preset-btn').forEach((btn, index) => {
                    console.log(`Button ${index}:`, {
                        text: btn.textContent,
                        preset: btn.getAttribute('data-preset')
                    });
                });
            }, 1000);

            // Date filter actions
            $('#applyDateFilter').on('click', function() {
                const dateFrom = $('#dateFromInput').val();
                const dateTo = $('#dateToInput').val();

                $('#date_from_input').val(dateFrom);
                $('#date_to_input').val(dateTo);

                updateDateFilterButton();
                reloadTable();
                $('#dateFilterMenu').removeClass('show');
            });

            $('#clearDateFilter').on('click', function() {
                $('#dateFromInput').val('');
                $('#dateToInput').val('');
                $('#date_from_input').val('');
                $('#date_to_input').val('');

                $('.date-preset-btn').removeClass('active');
                updateDateFilterButton();
                reloadTable();
                $('#dateFilterMenu').removeClass('show');
            });

            // Handle window resize to reposition dropdown if open
            $(window).on('resize', function() {
                if ($('.date-filter-menu').is(':visible')) {
                    positionDateDropdown();
                }
            });

            // Search input with debounce
            $(document).on('input', '#filter input[name="search"]', debounce(function() {
                reloadTable();
            }, 300));

            // Per page change
            $(document).on('change', 'select[name="per_page"]', function() {
                const newPerPage = $(this).val();
                const formData = $('#filter').serialize() + '&per_page=' + newPerPage;

                $.ajax({
                    url: "<?php echo e(route('admin.bendahara.index')); ?>",
                    data: formData,
                    beforeSend: function() {
                        $('#table').addClass('table-loading');
                        $('#table').html(
                            '<div class="py-20 text-center"><span class="spinner-border text-danger"></span></div>'
                        );
                    },
                    success: function(response) {
                        $('#table').removeClass('table-loading');
                        $('#table').html(response);
                        initializeDropzones();
                        initializeDropdownEvents();
                        initializeSortingEvents();
                        updateURL(formData);
                    },
                    error: function(xhr) {
                        $('#table').removeClass('table-loading');
                        $('#table').html(
                            '<div class="py-20 text-center text-danger fw-bold">Terjadi kesalahan saat memuat data.</div>'
                        );
                    }
                });
            });

            // Pagination links
            $(document).on('click', '.pagination-link', function(e) {
                e.preventDefault();
                const url = $(this).attr('href');
                if (url) {
                    const page = new URL(url).searchParams.get('page');
                    const formData = $('#filter').serialize() + '&page=' + page;

                    $.ajax({
                        url: "<?php echo e(route('admin.bendahara.index')); ?>",
                        data: formData,
                        beforeSend: function() {
                            $('#table').addClass('table-loading');
                            $('#table').html(
                                '<div class="py-20 text-center"><span class="spinner-border text-danger"></span></div>'
                            );
                        },
                        success: function(response) {
                            $('#table').removeClass('table-loading');
                            $('#table').html(response);
                            initializeDropzones();
                            initializeDropdownEvents();
                            initializeSortingEvents();
                            updateURL(formData);
                        },
                        error: function(xhr) {
                            $('#table').removeClass('table-loading');
                            $('#table').html(
                                '<div class="py-20 text-center text-danger fw-bold">Terjadi kesalahan saat memuat data.</div>'
                            );
                        }
                    });
                }
            });

            // Modal event handlers
            $(document).on('show.bs.modal', '.modal', function(e) {
                const modalId = $(this).attr('id');
                const modal = $(this);

                modal.removeClass('has-changes submit-success');

                // Store original form data for reset on cancel
                setTimeout(() => {
                    const form = modal.find('form, [id^="form-"]').first();
                    if (form.length) {
                        const originalData = {};
                        form.find('input, select, textarea').each(function() {
                            const input = $(this);
                            if (input.attr('type') !== 'file') {
                                originalData[input.attr('name')] = input.val();
                            }
                        });
                        modal.data('original-data', originalData);
                    }
                }, 100);
            });

            $(document).on('hidden.bs.modal', '.modal', function(e) {
                const modalId = $(this).attr('id');
                const modal = $(this);

                // Only reset if the form was not successfully submitted
                // (successful submissions are already reset in submitForm)
                if (!modal.hasClass('submit-success')) {
                    const originalData = modal.data('original-data');
                    if (originalData) {
                        const form = modal.find('form, [id^="form-"]').first();
                        if (form.length) {
                            form.find('input, select, textarea').each(function() {
                                const input = $(this);
                                const name = input.attr('name');
                                if (input.attr('type') !== 'file' && originalData.hasOwnProperty(
                                        name)) {
                                    input.val(originalData[name]);
                                }
                            });
                        }
                    }

                    // Reset dropzone files
                    if (modalId.startsWith('edit-')) {
                        const itemId = modalId.split('-')[1];
                        const formId = `form-${itemId}`;
                        if (dropzones[formId]) {
                            dropzones[formId].removeAllFiles();
                        }
                    } else if (modalId === 'add') {
                        if (dropzones['formAdd']) {
                            dropzones['formAdd'].removeAllFiles();
                        }
                    }
                }

                // Always clean up modal state
                modal.removeClass('has-changes submit-success');
                modal.removeData('original-data');
            });

            // Track form changes
            $(document).on('input change', '.modal input, .modal select, .modal textarea', function() {
                const modal = $(this).closest('.modal');
                modal.addClass('has-changes');
            });

            // Initialize filter from URL params
            const urlParams = new URLSearchParams(window.location.search);
            const filterFromURL = urlParams.get('filter_type') || 'all';
            if (filterFromURL !== currentFilter) {
                $(`.filter-option[data-filter="${filterFromURL}"]`).click();
            }
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\ThinkPad\OneDrive\Dokumen\GitHub\web-koni\resources\views/admin/bendahara/index.blade.php ENDPATH**/ ?>