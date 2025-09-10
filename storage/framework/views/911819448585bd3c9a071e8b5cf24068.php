<?php $__env->startSection('pageTitle', 'Manajemen Sekretariat'); ?>
<?php $__env->startSection('mainSection', 'Laporan Pertanggungjawaban'); ?>
<?php $__env->startSection('currentSection', 'Sekretariat'); ?>

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
    </style>

    <div class="d-flex flex-column mb-8">
        <h1 class="text-dark fw-bold mb-1">Laporan Sekretariat</h1>
        
    </div>

    <div class="row col-12 mt-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap py-5">
                <h3 class="card-title fw-bold fs-4 mb-0">Daftar Table Sekretariat - 2025</h3>

                <div class="d-flex align-items-center gap-2 flex-wrap ms-auto">
                    <a href="<?php echo e(route('admin.laporan-lpj.sekretariat.create')); ?>" class="btn btn-primary"
    style="background-color: #F8285A !important; color: white !important; border-color: #F8285A !important;">
    <i class="ki-duotone ki-plus fs-2" style="color: white !important;"></i>Tambah LPJ
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
                    <?php echo $__env->make('admin.laporan-lpj.sekretariat._table', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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
                <div class="modal-header d-flex align-items-center" style="background: white; color: #333; border-bottom: 1px solid #dee2e6 !important;">
                    <div class="d-flex align-items-center gap-3">
                        <h5 class="modal-title mb-0" id="detailModalLabel" style="color: #333 !important;">Detail Kegiatan</h5>
                        <!-- Status Icon -->
                        <span id="statusIcon" class="badge fs-7 d-flex align-items-center" style="padding: 6px 10px;"></span>
                    </div>
                    <div class="ms-auto d-flex align-items-center gap-2">
                        <button type="button" id="exportBtn" class="btn btn-primary">
                            <i class="fas fa-file-export"></i>
                            <strong>Export</strong>
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
        $(document).off('click', '.dropdown-toggle-custom');
        $(document).off('mouseenter', '.dropdown-action');
        $(document).off('mouseleave', '.dropdown-action');

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

            $dropdownAction.removeClass('dropup');

            const $row = $dropdownAction.closest('tr');
            const $table = $row.closest('tbody');
            const rowIndex = $table.find('tr').index($row);
            const totalRows = $table.find('tr').length;

            if (rowIndex === totalRows - 1) {
                $dropdownAction.addClass('dropup');
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

        if (window.innerWidth > 768) {
            $(document).on('mouseenter', '.dropdown-action', function() {
                const $menu = $(this).find('.dropdown-menu-custom');
                $menu.addClass('show');
                checkDropdownPosition($(this));
            }).on('mouseleave', '.dropdown-action', function() {
                const $menu = $(this).find('.dropdown-menu-custom');
                setTimeout(() => {
                    if (!$menu.is(':hover')) {
                        $menu.removeClass('show');
                    }
                }, 100);
            });

            $(document).on('mouseenter', '.dropdown-menu-custom', function() {
                clearTimeout($(this).data('timeout'));
            }).on('mouseleave', '.dropdown-menu-custom', function() {
                const $menu = $(this);
                $menu.data('timeout', setTimeout(() => {
                    $menu.removeClass('show');
                }, 200));
            });
        }
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
            const originalName = typeof file === 'object' && file.original_name ? file.original_name : path.split('/').pop();

            const fileExtension = originalName.split('.').pop().toLowerCase();
            const imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'];

            if (currentType === 'image' || currentType === 'foto' ||
                (currentType === 'auto' && imageExtensions.includes(fileExtension))) {
                slide.innerHTML = `
                    <img src="/storage/${path}"
                         alt="Preview"
                         class="preview-image"
                         onerror="this.style.display='none'; this.parentElement.innerHTML='<div class=\'document-placeholder\'><i class=\'fas fa-exclamation-triangle text-warning\' style=\'font-size: 3rem;\'></i><h5>Gagal memuat gambar</h5></div>'">
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
            html: "<p style='text-align:center'>Setelah data laporan sekretariat dihapus, Anda tidak bisa mengembalikannya!</p>",
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
                            text: response.message || 'Data laporan sekretariat berhasil dihapus',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        });

                        updateTable({});
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
                                    text: response.message || 'Gagal menghapus data laporan sekretariat',
                                    icon: 'error'
                                });
                            }
                        } catch (e) {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Gagal menghapus data laporan sekretariat',
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

    if (!modalBody) {
        console.error('Modal body not found');
        return;
    }

    // Tampilkan status terkunci/terbuka berdasarkan modifiable_by_user_id
    if (statusIcon) {
        // Cek apakah laporan bisa dimodifikasi (terbuka) atau terkunci
        // Kita perlu memeriksa dari sisi PHP apakah user saat ini adalah superadmin, memiliki permission pengajuan-modifikasi-laporan, atau memiliki akses modifikasi
        const isSuperAdmin = <?php echo e(auth()->user()->hasRole('superadmin') ? 'true' : 'false'); ?>;
        const hasApprovalPermission = <?php echo e(auth()->user()->can('pengajuan-modifikasi-laporan') ? 'true' : 'false'); ?>;
        const isModifiableByCurrentUser = data.modifiable_by_user_id && data.modifiable_by_user_id == <?php echo e(auth()->id()); ?>;

        // Jika user adalah superadmin, memiliki permission pengajuan-modifikasi-laporan, atau memiliki akses modifikasi, maka status terbuka
        if (isSuperAdmin || hasApprovalPermission || isModifiableByCurrentUser) {
            statusIcon.innerHTML = 'Terbuka';
            statusIcon.className = 'badge border-success text-success bg-opacity-20 bg-success fs-7 d-flex align-items-center';
        } else {
            statusIcon.innerHTML = 'Terkunci';
            statusIcon.className = 'badge border-danger text-danger bg-opacity-20 bg-danger fs-7 d-flex align-items-center';
        }
    }

    // Simpan ID LPJ dalam data modal
    if (data && data.id) {
        $('#detailModal').data('lpj-id', data.id);
    } else {
        console.error('Data ID tidak ditemukan:', data);
    }

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
                        <div class="border rounded overflow-hidden" style="height: 120px;">
                            <img src="/storage/${path}"
                                 class="w-100 h-100"
                                 style="object-fit: cover; cursor: pointer;"
                                 onclick="window.open('/storage/${path}', '_blank')"
                                 onerror="this.style.display='none'; this.parentElement.innerHTML='<div class=\\'d-flex align-items-center justify-content-center h-100 text-muted\\'>Error loading image</div>'">
                            <div class="text-center small bg-light p-1">${name}</div>
                        </div>
                    </div>
                `}).join('')}
            </div>
        `;
    }

    let dokumenHtml = '<div class="text-muted fst-italic">Tidak ada dokumen tersedia</div>';
    if (data.dokumen_lpj && Array.isArray(data.dokumen_lpj) && data.dokumen_lpj.length > 0) {
        dokumenHtml = `
            <div class="d-flex flex-column gap-2">
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
                        <div class="d-flex align-items-center p-2 border rounded bg-light">
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

    // Tampilkan dokumen LPJ PDF jika ada
    let dokumenLpjPdfHtml = '';
    if (data.dokumen_lpj_pdf) {
        const path = typeof data.dokumen_lpj_pdf === 'object' ? data.dokumen_lpj_pdf.path : data.dokumen_lpj_pdf;
        const name = typeof data.dokumen_lpj_pdf === 'object' ?
            (data.dokumen_lpj_pdf.original_name || path.split('/').pop()) :
            path.split('/').pop();

        dokumenLpjPdfHtml = `
            <div class="mb-3">
                <label class="fw-semibold text-dark mb-2 d-block">
                    <i class="fas fa-file-pdf text-danger me-1"></i>Dokumen LPJ (PDF):
                </label>
                <div class="bg-light p-3 rounded">
                    <div class="d-flex align-items-center p-2 border rounded bg-white">
                        <i class="fas fa-file-pdf text-danger me-3" style="font-size: 1.2em;"></i>
                        <div class="flex-grow-1">
                            <div class="fw-medium text-dark">${name}</div>
                            <small class="text-muted">PDF</small>
                        </div>
                        <a href="/storage/${path}"
                           target="_blank"
                           class="btn btn-outline-danger btn-sm">
                            <i class="fas fa-download me-1"></i>Unduh
                        </a>
                    </div>
                </div>
            </div>
        `;
    }

    modalBody.innerHTML = `
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="mb-4">
                    <h6 class="fw-bold text-primary mb-3 d-flex align-items-center">
                        <i class="fas fa-info-circle me-2"></i>
                        Informasi Kegiatan
                    </h6>
                    <div class="bg-light p-3 rounded">
                        <div class="mb-2">
                            <label class="fw-semibold text-dark mb-1">Nama Program:</label>
                            <p class="mb-0 text-dark">${data.nama_program || 'N/A'}</p>
                        </div>
                        ${data.nama_kegiatan ? `
                            <div class="mb-2">
                                <label class="fw-semibold text-dark mb-1">Nama Kegiatan:</label>
                                <p class="mb-0 text-dark">${data.nama_kegiatan}</p>
                            </div>
                        ` : ''}
                        ${data.volume ? `
                            <div class="mb-2">
                                <label class="fw-semibold text-dark mb-1">Volume:</label>
                                <p class="mb-0 text-dark">${data.volume}</p>
                            </div>
                        ` : ''}
                        ${data.tempat_kegiatan ? `
                            <div class="mb-2">
                                <label class="fw-semibold text-dark mb-1">Tempat Kegiatan:</label>
                                <p class="mb-0 text-dark">${data.tempat_kegiatan}</p>
                            </div>
                        ` : ''}
                        ${data.tanggal_kegiatan ? `
                            <div>
                                <label class="fw-semibold text-dark mb-1">Tanggal Kegiatan:</label>
                                <p class="mb-0 text-dark">${new Date(data.tanggal_kegiatan).toLocaleDateString('id-ID')}</p>
                            </div>
                        ` : ''}
                    </div>
                </div>

                ${data.jumlah_harga_satuan || data.jumlah_harga ? `
                    <div class="mb-4">
                        <h6 class="fw-bold text-success mb-3 d-flex align-items-center">
                            <i class="fas fa-calculator me-2"></i>
                            Rincian Anggaran
                        </h6>
                        <div class="bg-light p-3 rounded">
                            <div class="row g-3">
                                ${data.jumlah_harga_satuan ? `
                                    <div class="col-md-6">
                                        <label class="fw-semibold text-dark mb-1">Harga Satuan:</label>
                                        <p class="mb-0 text-success fs-6 fw-bold">${formatRupiah(data.jumlah_harga_satuan)}</p>
                                    </div>
                                ` : ''}
                                ${data.jumlah_harga ? `
                                    <div class="col-md-6">
                                        <label class="fw-semibold text-dark mb-1">Total Anggaran:</label>
                                        <p class="mb-0 text-info fs-6 fw-bold">${formatRupiah(data.jumlah_harga)}</p>
                                    </div>
                                ` : ''}
                            </div>
                        </div>
                    </div>
                ` : ''}

                ${data.sumber_dana ? `
                    <div class="mb-4">
                        <h6 class="fw-bold text-info mb-3 d-flex align-items-center">
                            <i class="fas fa-money-bill me-2"></i>
                            Sumber Dana
                        </h6>
                        <div class="bg-light p-3 rounded">
                            <p class="mb-0 text-dark">${data.sumber_dana}</p>
                        </div>
                    </div>
                ` : ''}

                <div class="mb-4">
                    <h6 class="fw-bold text-warning mb-3 d-flex align-items-center">
                        <i class="fas fa-paperclip me-2"></i>
                        Lampiran
                    </h6>

                    <div class="mb-3">
                        <label class="fw-semibold text-dark mb-2 d-block">
                            <i class="fas fa-camera me-1"></i>Foto Jurnal:
                        </label>
                        <div class="bg-light p-3 rounded">
                            ${fotoJurnalHtml}
                        </div>
                    </div>

                    ${dokumenLpjPdfHtml}

                    <div>
                        <label class="fw-semibold text-dark mb-2 d-block">
                            <i class="fas fa-file-alt me-1"></i>Dokumen Pendukung:
                        </label>
                        <div class="bg-light p-3 rounded">
                            ${dokumenHtml}
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
                    </div>
                </div>
            </div>
        </div>


                ` : ''}
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

            $('#exportBtn').on('click', function() {
                const lpjId = $('#detailModal').data('lpj-id');
                
                // Periksa apakah ID tersedia
                if (!lpjId) {
                    alert('Terjadi kesalahan: ID laporan tidak ditemukan. Silakan coba muat ulang halaman.');
                    console.error('ID laporan tidak ditemukan di data modal');
                    return;
                }
                
                // Validasi ID
                if (isNaN(lpjId) || lpjId <= 0) {
                    alert('Terjadi kesalahan: ID laporan tidak valid.');
                    console.error('ID laporan tidak valid:', lpjId);
                    return;
                }
                
                // Redirect to export route
                const exportUrl = `/admin/laporan-lpj/sekretariat/${lpjId}/export`;
                console.log('Membuka URL export:', exportUrl);
                
                const exportWindow = window.open(exportUrl, '_blank');
                
                // Periksa apakah window.open berhasil
                if (!exportWindow) {
                    alert('Popup blocker mencegah pembukaan jendela export. Silakan izinkan popup untuk situs ini.');
                }
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

        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\ThinkPad\OneDrive\Dokumen\GitHub\web-koni\resources\views/admin/laporan-lpj/sekretariat/index.blade.php ENDPATH**/ ?>