<?php
    $subSection3Url = '';
    if ($parent?->parent) {
        $routes = [
            9 => 'admin.laporan-lpj.bidang.prestasi.cabor-terukur',
            10 => 'admin.laporan-lpj.bidang.prestasi.cabor-akurasi',
            11 => 'admin.laporan-lpj.bidang.prestasi.cabor-permainan',
            12 => 'admin.laporan-lpj.bidang.prestasi.cabor-beladiri'
        ];

        $subSection3Url = isset($routes[$parent->parent->id])
            ? route($routes[$parent->parent->id], ['parentId' => $parent->parent->id])
            : route('admin.laporan-lpj.bidang.dynamic.index');
    }

    if (!function_exists('formatRupiah')) {
        function formatRupiah($number, $prefix = 'Rp ')
        {
            return $prefix . number_format($number, 0, ',', '.');
        }
    }
?>

<?php $__env->startSection('pageTitle', $currentParent ? $currentParent->nama_program : 'Root Level'); ?>
<?php $__env->startSection('mainSection', 'Laporan LPJ'); ?>
<?php $__env->startSection('subSection', 'Bidang Bidang'); ?>
<?php $__env->startSection('subSectionUrl', route('admin.laporan-lpj.bidang.index')); ?>
<?php $__env->startSection('subSection2', $parent?->parent?->parent?->nama_program ?? ''); ?>
<?php $__env->startSection('subSection2Url', route('admin.laporan-lpj.bidang.prestasi.index')); ?>
<?php $__env->startSection('subSection3', $parent?->parent?->nama_program ?? ''); ?>
<?php $__env->startSection('subSection3Url', $subSection3Url); ?>
<?php $__env->startSection('currentSection', $currentParent ? $currentParent->nama_program : 'Root Level'); ?>

<?php $__env->startSection('content'); ?>
    <style>
        body { background-color: #f5f5f5; }

        .main-content {
            background-color: #f5f5f5;
            min-height: 100vh;
            padding: 20px 10px 40px;
        }

        /* Table styles */
        .table {
            table-layout: fixed !important;
            width: 100%;
        }

        .table th:nth-child(1) { width: 40px; }
        .table th:nth-child(2) { width: 250px; }
        .table th:nth-child(3) { width: 200px; }
        .table th:nth-child(4) { width: 150px; }
        .table th:nth-child(5) { width: 200px; }
        .table th:nth-child(6) { width: 150px; }
        .table th:nth-child(7) { width: 210px; }
        .table th:nth-child(8) { width: 80px; }

        /* Dropdown styles */
        .dropdown-action { position: relative; display: inline-block; }

        .dropdown-toggle-custom {
            background: none;
            border: none;
            cursor: pointer;
            padding: 5px;
            border-radius: 4px;
            transition: all 0.2s ease;
        }

        .dropdown-toggle-custom:hover { background-color: rgba(0, 0, 0, 0.05); }

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

        .dropdown-menu-custom.show { display: block; }

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

        .dropdown-item-custom:hover {
            background-color: #f8f9fa;
            text-decoration: none;
            color: #495057;
        }

        /* Button styles */
        #ajukanPerubahanBtn {
            background-color: #4CAF50;
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
            box-shadow: 0 2px 6px rgba(76, 175, 80, 0.3);
        }

        #ajukanPerubahanBtn:hover {
            background-color: #43a047;
            box-shadow: 0 3px 8px rgba(76, 175, 80, 0.4);
            transform: translateY(-1px);
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

        /* Modal styles */
        .modal .form-control:focus {
            border-color: #F8285A;
            box-shadow: 0 0 0 0.25rem rgba(248, 40, 90, 0.1);
        }

        .text-truncate-custom {
            display: block;
            max-width: 250px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
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

        .top-progress-wrapper {
            background: white;
            border: 1px solid #e9ecef;
            border-radius: 16px;
            padding: 20px 25px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }

        /* Hide edit modal content initially to prevent flash */
        #editTargetModal .modal-content {
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        #editTargetModal.show .modal-content {
            opacity: 1;
        }

        .tooltip-approved {
            --bs-tooltip-bg: #ffffff;
            --bs-tooltip-border-color: #e0e0e0;
            --bs-tooltip-color: #333333;
            --bs-tooltip-padding-x: 12px;
            --bs-tooltip-padding-y: 10px;
            --bs-tooltip-border-radius: 8px;
            --bs-tooltip-font-size: 13px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            border: 1px solid var(--bs-tooltip-border-color);
        }

        .tooltip-approved .tooltip-inner {
            background-color: var(--bs-tooltip-bg);
            color: var(--bs-tooltip-color);
            border-radius: var(--bs-tooltip-border-radius);
            padding: var(--bs-tooltip-padding-y) var(--bs-tooltip-padding-x);
            text-align: left;
            max-width: 250px;
            line-height: 1.4;
        }

        .tooltip-approved .tooltip-arrow::before {
            border-top-color: var(--bs-tooltip-bg);
            border-bottom-color: var(--bs-tooltip-bg);
        }
    </style>

    <div class="d-flex flex-column mb-8">
        <h1 class="text-dark fw-bold mb-1">
            Laporan <?php echo e($currentParent ? $currentParent->nama_program : 'Root Level'); ?>

        </h1>
        <?php if($currentParent): ?>
            <p class="text-muted"><?php echo e($currentParent->breadcrumb); ?></p>
        <?php endif; ?>
    </div>

    <?php if($parentId): ?>
    <div class="top-progress-wrapper mb-4">
        <div class="d-flex justify-content-between mt-2">
            <h1 class="text-muted mb-0">Total Anggaran</h1>
            <span class="text-muted">
                <a href="#" data-bs-toggle="modal" data-bs-target="#editTargetModal">
                    <i class="fa-solid fa-pen-to-square"></i>
                </a>
            </span>
        </div>
        <div class="d-flex justify-content-between mb-2">
            <?php
                $percentage = ($target && $target->target_anggaran > 0) ? ($current_budget / $target->target_anggaran) * 100 : 0;
            ?>
            <h1 class="fw-bold mb-1"><?php echo e(formatRupiah($current_budget)); ?> / <?php echo e(formatRupiah($target->target_anggaran ?? 0)); ?></h1>
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
                    <?php echo e($kegiatan_count); ?> Kegiatan Berjalan
                </span>
                <span>/</span>
                <span class="badge bg-primary-subtle text-primary fw-semibold px-3 py-1 border border-primary-subtle">
                    <?php echo e($target->target_kegiatan ?? 0); ?> Target Kegiatan
                </span>
            </div>
        </div>
    </div>
    <?php endif; ?>

    
    <div class="card mt-5">
        
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap py-5">
            <h3 class="card-title fw-bold fs-4 mb-0">
                Daftar <?php echo e($currentParent ? $currentParent->nama_program : 'Root Level'); ?>

            </h3>

            
            <div class="d-flex align-items-center gap-2 flex-wrap ms-auto">
                <a href="<?php echo e($parentId ? route('admin.laporan-lpj.bidang.dynamic.child.create', $parentId) : route('admin.laporan-lpj.bidang.dynamic.create')); ?>"
                       class="btn custom-red-button"
                       style="background-color: #F8285A !important; color: white !important; border-color: #F8285A !important;">
                        <i class="ki-duotone ki-plus fs-2" style="color: white !important;"></i>Tambah Laporan
                    </a>

                
                <div class="input-group position-relative" style="width: 250px;">
                    <input type="search" name="search" id="search" class="form-control"
                        placeholder="Cari program/kegiatan..." value="<?php echo e(request('search')); ?>" autocomplete="off">

                    <button class="btn btn-outline-secondary search-clear-btn d-none" type="button" id="clear-search"
                        style="position: absolute; right: 45px; z-index: 10; border: none; background: transparent; padding: 8px;">
                        <i class="fas fa-times text-muted"></i>
                    </button>

                    <button class="btn btn-outline-secondary" type="button" id="search-button">
                        <i class="fas fa-search"></i>
                    </button>

                    <div class="search-loading-indicator d-none position-absolute"
                        style="right: 50px; top: 50%; transform: translateY(-50%); z-index: 10;">
                        <div class="spinner-border spinner-border-sm text-primary" role="status">
                            <span class="visually-hidden">Cari Kegiatan...</span>
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
                <?php echo $__env->make('admin.laporan-lpj.bidang_new.dynamic._table', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>
    </div>

    
    <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header" style="background: white; color: rgb(0, 0, 0);">
                    <h5 class="modal-title text-black" id="previewModalLabel">Preview Files</h5>
                    <button type="button" class="btn-close btn-close-black" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0" style="height: 70vh;">
                    <div class="preview-container h-100 position-relative d-flex align-items-center justify-content-center" style="background: #f8f9fa;">
                        <div id="previewSlides" class="w-100 h-100"></div>
                        <button type="button" id="prevBtn" class="btn btn-primary position-absolute start-0 top-50 translate-middle-y ms-3" style="z-index: 10; display: none;">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button type="button" id="nextBtn" class="btn btn-primary position-absolute end-0 top-50 translate-middle-y me-3" style="z-index: 10; display: none;">
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

<?php if($parentId): ?>

<div class="modal fade" id="editTargetModal" tabindex="-1" aria-labelledby="editTargetModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 gap-5 px-10 py-8">
            <div class="d-flex justify-content-between align-items-center">
                <div class="fs-2 fw-bold leading-5">Edit Target Anggaran & Kegiatan</div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="editTargetForm" class="d-grid gap-4">
                <input type="hidden" name="id_lpj" value="<?php echo e($parentId); ?>">

                <div>
                    <div class="fw-semibold required mb-3 text-gray-800">Target Anggaran</div>
                    <input type="text" name="target_anggaran" id="target_anggaran"
                           value="<?php echo e(formatRupiah($target->target_anggaran ?? 0)); ?>"
                           placeholder="Masukkan target anggaran"
                           class="form-control bg-light border border-gray-400" required />
                    <div class="invalid-feedback"></div>
                </div>

                <div>
                    <div class="fw-semibold required mb-3 text-gray-800">Target Kegiatan</div>
                    <input type="number" name="target_kegiatan" id="target_kegiatan"
                           value="<?php echo e($target->target_kegiatan ?? 0); ?>"
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
<?php endif; ?>

<?php $__env->startSection('script'); ?>
<script>
$(document).ready(function() {
    let dataTable = null;
    let searchTimeout;
    const parentId = <?php echo e($parentId ?? 'null'); ?>;

    // Utility functions
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

    const showNotification = (message, type = 'info') => {
        const alertClass = {
            'success': 'alert-success',
            'error': 'alert-danger',
            'warning': 'alert-warning',
            'info': 'alert-info'
        }[type] || 'alert-info';

        const notification = $(`
            <div class="alert ${alertClass} alert-dismissible fade show"
                style="position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `);

        $('body').append(notification);
        setTimeout(() => notification.alert('close'), 5000);
    };

    // Reset form functions (enhanced from Document 2)
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

        // Reset dropzone if exists
        if (typeof dropzones !== 'undefined' && dropzones['formAdd']) {
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

        // Reset dropzone if exists
        if (typeof dropzones !== 'undefined' && dropzones[formId]) {
            dropzones[formId].removeAllFiles();
        }
    }

    // Initialize DataTable
    function initializeDataTable() {
        const table = $("#kt_datatable_dom_positioning_sumberdaya");
        if (dataTable) dataTable.destroy();

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
                }
            });
        }
    }

    // Update table with AJAX
    function updateTable(params = {}) {
        return new Promise((resolve, reject) => {
            $('#loading-overlay').removeClass('d-none');

            let baseUrl = parentId
                ? "<?php echo e(route('admin.laporan-lpj.bidang.dynamic.child.index', ':parentId')); ?>".replace(':parentId', parentId)
                : "<?php echo e(route('admin.laporan-lpj.bidang.dynamic.index')); ?>";

            const currentUrl = new URL(baseUrl, window.location.origin);
            for (const key in params) {
                if (params[key] !== null && params[key] !== undefined && params[key] !== '') {
                    currentUrl.searchParams.set(key, params[key]);
                }
            }

            $.ajax({
                url: currentUrl.toString(),
                type: 'GET',
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                success: function(response) {
                    $('#table-container').html(response);
                    $('#loading-overlay').addClass('d-none');
                    window.history.pushState(null, null, currentUrl.toString());
                    initializeDataTable();
                    initializeDropdownEvents();
                    resolve(response);
                },
                error: function(xhr) {
                    $('#loading-overlay').addClass('d-none');
                    showNotification('Terjadi kesalahan saat memuat data.', 'error');
                    reject(xhr);
                }
            });
        });
    }

    // Initialize dropdown events
    function initializeDropdownEvents() {
        $(document).off('click', '.dropdown-toggle-custom');

        $(document).on('click', '.dropdown-toggle-custom', function(e) {
            e.preventDefault();
            e.stopPropagation();

            const $menu = $(this).closest('.dropdown-action').find('.dropdown-menu-custom');
            $('.dropdown-menu-custom').not($menu).removeClass('show');
            $menu.toggleClass('show');
        });

        $(document).on('click', function(e) {
            if (!$(e.target).closest('.dropdown-action').length) {
                $('.dropdown-menu-custom').removeClass('show');
            }
        });
    }

    // Search functionality
    $('#search').on('input', function() {
        const searchValue = $(this).val().trim();
        if (searchTimeout) clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            updateTable({ 'search': searchValue });
        }, 300);
    });

    // Pagination handling
    $(document).on('click', '.pagination-link', function(e) {
        e.preventDefault();
        const url = new URL($(this).attr('href'));
        const page = url.searchParams.get('page');
        updateTable({ 'page': page });
    });

    // Per page dropdown handler
    $(document).on('change', 'select[name="per_page"]', function() {
        const perPage = $(this).val();
        updateTable({
            'per_page': perPage,
            'page': 1
        });
    });

    // Delete function
    window.deleteItemWithSwal = function(itemId, itemName = 'item ini') {
        const url = "<?php echo e(route('admin.laporan-lpj.bidang.dynamic.destroy', ':id')); ?>".replace(':id', itemId);

        Swal.fire({
            title: "Apakah Anda Yakin?",
            html: `<p style='text-align:center'>Setelah <strong>${itemName}</strong> dihapus, Anda tidak bisa mengembalikannya!</p>`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Hapus!',
            cancelButtonText: 'Batalkan!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: { _token: '<?php echo e(csrf_token()); ?>', _method: 'DELETE' },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('Berhasil!', 'Data berhasil dihapus.', 'success');
                            updateTable();
                        } else {
                            Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus', 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error!', 'Terjadi kesalahan jaringan.', 'error');
                    }
                });
            }
        });
    };

    // Enhanced form submission function (adapted from Document 2)
    window.submitForm = function(formId) {
        const formElement = document.getElementById(formId);
        if (!formElement) {
            showNotification("Form tidak ditemukan", "error");
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

        // Handle dropzone files if available
        if (typeof dropzones !== 'undefined') {
            const dz = dropzones[formId];
            if (dz && dz.getAcceptedFiles().length > 0) {
                dz.getAcceptedFiles().forEach(file => {
                    formData.append('dokumen', file);
                });
            }
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
                            showNotification(msgs.join(', '), "error");
                        });
                    } else {
                        showNotification(data.message || "Gagal menyimpan data", "error");
                    }
                } else {
                    // Reset form immediately after successful submission
                    if (formId === 'formAdd') {
                        resetFormAdd();
                    } else {
                        resetEditForm(formId);
                    }

                    $('.modal.show').addClass('submit-success');
                    $('.modal.show').modal('hide');

                    showNotification(data.message || "Data berhasil disimpan", "success");
                    updateTable();
                }
            })
            .catch(error => {
                // Remove loading state
                if (submitBtn) {
                    submitBtn.classList.remove('btn-loading');
                    submitBtn.disabled = false;
                }

                showNotification("Terjadi kesalahan. Silakan coba lagi.", "error");
                console.error('Error:', error);
            });
    };

    // Show detail modal
    window.showDetailModal = function(data) {
        const modalBody = document.getElementById('detailModalBody');
        const statusIcon = document.getElementById('statusIcon');
        const exportBtn = document.getElementById('export-pdf-btn');

        if (exportBtn) exportBtn.setAttribute('data-lpj-id', data.id);

        // Status indicator
        if (statusIcon) {
            const canModify = <?php echo e(auth()->user()->can('pengajuan-modifikasi-laporan') ? 'true' : 'false'); ?>;
            const isModifiable = data.modifiable_by_user_id && data.modifiable_by_user_id == <?php echo e(auth()->id()); ?>;

            if (canModify || isModifiable) {
                statusIcon.innerHTML = 'Terbuka';
                statusIcon.className = 'badge border-success text-success bg-opacity-20 bg-success fs-7';
                document.getElementById('ajukanPerubahanBtn').style.display = 'none';
            } else {
                statusIcon.innerHTML = 'Terkunci';
                statusIcon.className = 'badge border-danger text-danger bg-opacity-20 bg-danger fs-7';
                document.getElementById('ajukanPerubahanBtn').style.display = '';
            }
        }

        $('#detailModal').data('lpj-id', data.id);

        // Populate modal content with full functionality
        const formatRupiah = (num) => 'Rp ' + (parseInt(num, 10) || 0).toLocaleString('id-ID');

        let fotoJurnalHtml = '<div class="text-muted fst-italic">Tidak ada foto tersedia</div>';
        if (data.foto_jurnal && data.foto_jurnal.length) {
            fotoJurnalHtml = `
                <div class="row g-3">
                    ${data.foto_jurnal.map(f => `
                        <div class="col-6 col-md-4">
                            <div class="border rounded overflow-hidden" style="height:120px">
                                <img src="/storage/${f}" class="w-100 h-100"
                                    style="object-fit:cover;cursor:pointer"
                                    onclick="showPreviewModal(['${data.foto_jurnal.join("','")}'], 'image', 'Foto Kegiatan')">
                            </div>
                        </div>`).join('')}
                </div>
                <div class="mt-2">
                    <button type="button" class="btn btn-outline-primary btn-sm preview-btn"
                            data-files='${JSON.stringify(data.foto_jurnal)}'
                            data-type="image"
                            data-title="Foto Kegiatan">
                    </button>
                </div>`;
        }

        let dokumenHtml = '<div class="text-muted fst-italic">Tidak ada dokumen tersedia</div>';
        if (data.dokumen_pendukung && data.dokumen_pendukung.length) {
            dokumenHtml = `
                <div class="d-flex flex-column gap-2">
                    ${data.dokumen_pendukung.map(d => {
                        const name = d.split('/').pop();
                        const ext = name.split('.').pop().toLowerCase();
                        const icon = {
                            pdf: 'fas fa-file-pdf text-danger',
                            doc: 'fas fa-file-word text-primary',
                            docx: 'fas fa-file-word text-primary',
                            xls: 'fas fa-file-excel text-success',
                            xlsx: 'fas fa-file-excel text-success',
                            jpg: 'fas fa-file-image text-info',
                            jpeg: 'fas fa-file-image text-info',
                            png: 'fas fa-file-image text-info'
                        }[ext] || 'fas fa-file text-secondary';
                        return `
                            <div class="d-flex align-items-center p-2 border rounded bg-light">
                                <i class="${icon} me-3" style="font-size:1.2em"></i>
                                <div class="flex-grow-1">
                                    <div class="fw-medium">${name}</div>
                                    <small class="text-muted">${ext.toUpperCase()}</small>
                                </div>
                                <a href="/storage/${d}" target="_blank" class="btn btn-outline-primary btn-sm me-2">
                                    <i class="fas fa-download me-1"></i>Unduh
                                </a>
                            </div>`;
                    }).join('')}
                </div>
                <div class="mt-2">
                    <button type="button" class="btn btn-outline-secondary btn-sm preview-btn"
                            data-files='${JSON.stringify(data.dokumen_pendukung)}'
                            data-type="document"
                            data-title="Dokumen Pendukung">
                    </button>
                </div>`;
        }

        modalBody.innerHTML = `
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="mb-4">
                        <h6 class="fw-bold text-primary mb-3"><i class="fas fa-info-circle me-2"></i>Informasi Kegiatan</h6>
                        <div class="bg-light p-3 rounded">
                            <div class="mb-2">
                                <label class="fw-semibold mb-1">Nama Kegiatan & Program:</label>
                                <p class="mb-0">${data.nama_program || data.nama_kegiatan || 'N/A'}</p>
                                ${data.nama_kegiatan && data.nama_program ? `<small class="text-muted">${data.nama_kegiatan}</small>` : ''}
                            </div>
                            ${data.tempat_kegiatan ? `
                                <div class="mb-2">
                                    <label class="fw-semibold mb-1">Tempat Kegiatan:</label>
                                    <p class="mb-0">${data.tempat_kegiatan}</p>
                                </div>` : ''}
                            ${data.tanggal_kegiatan ? `
                                <div>
                                    <label class="fw-semibold mb-1">Tanggal Kegiatan:</label>
                                    <p class="mb-0">${new Date(data.tanggal_kegiatan).toLocaleDateString('id-ID')}</p>
                                </div>` : ''}
                        </div>
                    </div>

                    ${data.jumlah_anggaran || data.jumlah_realisasi ? `
                        <div class="mb-4">
                            <h6 class="fw-bold text-success mb-3"><i class="fas fa-calculator me-2"></i>Rincian Anggaran</h6>
                            <div class="bg-light p-3 rounded">
                                <div class="row g-3">
                                    ${data.jumlah_anggaran ? `
                                        <div class="col-md-6">
                                            <label class="fw-semibold mb-1">Total Anggaran:</label>
                                            <p class="mb-0 text-success fs-5 fw-bold">${formatRupiah(data.jumlah_anggaran)}</p>
                                        </div>` : ''}
                                    ${data.jumlah_realisasi ? `
                                        <div class="col-md-6">
                                            <label class="fw-semibold mb-1">Realisasi:</label>
                                            <p class="mb-0 text-info fs-5 fw-bold">${formatRupiah(data.jumlah_realisasi)}</p>
                                        </div>` : ''}
                                </div>
                            </div>
                        </div>` : ''}

                    <div class="mb-4">
                        <h6 class="fw-bold text-warning mb-3"><i class="fas fa-paperclip me-2"></i>Lampiran</h6>
                        <div class="mb-3">
                            <label class="fw-semibold mb-2 d-block"><i class="fas fa-camera me-1"></i>Foto Kegiatan:</label>
                            <div class="bg-light p-3 rounded">${fotoJurnalHtml}</div>
                        </div>
                        <div>
                            <label class="fw-semibold mb-2 d-block"><i class="fas fa-file-alt me-1"></i>Dokumen Pendukung:</label>
                            <div class="bg-light p-3 rounded">${dokumenHtml}</div>
                        </div>
                    </div>

                    ${data.keterangan ? `
                        <div class="mb-2">
                            <h6 class="fw-bold text-secondary mb-3"><i class="fas fa-sticky-note me-2"></i>Keterangan</h6>
                            <div class="bg-light p-3 rounded"><p class="mb-0">${data.keterangan}</p></div>
                        </div>` : ''}
                </div>
            </div>
        `;

        new bootstrap.Modal(document.getElementById('detailModal')).show();
    };

    // Pengajuan modal handlers
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

    // Export PDF functionality
    $('#export-pdf-btn').on('click', function(e) {
        e.preventDefault();
        const lpjId = $(this).attr('data-lpj-id');

        if (lpjId) {
            let exportUrl = "<?php echo e(route('admin.laporan-lpj.bidang.dynamic.export-pdf', ':id')); ?>".replace(':id', lpjId);
            window.location.href = exportUrl;
        } else {
            alert('Tidak dapat mengekspor PDF, ID laporan tidak ditemukan.');
        }
    });

    // Preview modal functionality
    let currentFiles = [];
    let currentIndex = 0;

    window.showPreviewModal = function(files, type, title) {
        currentFiles = files;
        currentIndex = 0;

        const previewSlides = document.getElementById('previewSlides');
        const modalTitle = document.getElementById('previewModalLabel');

        modalTitle.textContent = title || 'Preview Files';
        previewSlides.innerHTML = '';

        currentFiles.forEach((file, index) => {
            const slide = document.createElement('div');
            slide.className = `preview-slide ${index === currentIndex ? 'active' : ''}`;
            slide.style.cssText = `
                display: ${index === currentIndex ? 'flex' : 'none'};
                width: 100%;
                height: 100%;
                align-items: center;
                justify-content: center;
                position: absolute;
                top: 0;
                left: 0;
            `;

            const fileName = file.split('/').pop();
            const fileExtension = fileName.split('.').pop().toLowerCase();
            const imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

            if (imageExtensions.includes(fileExtension)) {
                slide.innerHTML = `<img src="/storage/${file}" alt="Preview" style="max-width: 100%; max-height: 80%; object-fit: contain; border-radius: 8px;">`;
            } else if (fileExtension === 'pdf') {
                slide.innerHTML = `<iframe src="/storage/${file}" style="width: 100%; height: 80%; border: none; border-radius: 8px;"></iframe>`;
            } else {
                slide.innerHTML = `
                    <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 40px; background: white; border: 2px dashed #dee2e6; border-radius: 8px;">
                        <i class="fas fa-file" style="font-size: 4rem; color: #6c757d; margin-bottom: 1rem;"></i>
                        <h5>${fileName}</h5>
                        <a href="/storage/${file}" class="btn btn-primary" target="_blank">Open File</a>
                    </div>
                `;
            }

            previewSlides.appendChild(slide);
        });

        updatePreviewUI();
        $('#previewModal').modal('show');
    };

    function updatePreviewUI() {
        const fileName = currentFiles[currentIndex]?.split('/').pop() || '';
        const fileCounter = document.getElementById('fileCounter');
        const currentFileName = document.getElementById('currentFileName');
        const downloadBtn = document.getElementById('downloadBtn');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');

        if (currentFileName) currentFileName.textContent = fileName;
        if (fileCounter) fileCounter.textContent = `${currentIndex + 1} of ${currentFiles.length}`;

        if (currentFiles.length > 1) {
            if (prevBtn) prevBtn.style.display = 'block';
            if (nextBtn) nextBtn.style.display = 'block';
        } else {
            if (prevBtn) prevBtn.style.display = 'none';
            if (nextBtn) nextBtn.style.display = 'none';
        }

        if (downloadBtn) {
            downloadBtn.onclick = function() {
                window.open('/storage/' + currentFiles[currentIndex], '_blank');
            };
        }
    }

    function showSlide(index) {
        document.querySelectorAll('.preview-slide').forEach((slide, i) => {
            slide.style.display = i === index ? 'flex' : 'none';
        });
        currentIndex = index;
        updatePreviewUI();
    }

    $('#prevBtn').on('click', function() {
        const newIndex = currentIndex > 0 ? currentIndex - 1 : currentFiles.length - 1;
        showSlide(newIndex);
    });

    $('#nextBtn').on('click', function() {
        const newIndex = currentIndex < currentFiles.length - 1 ? currentIndex + 1 : 0;
        showSlide(newIndex);
    });

    $(document).on('click', '.preview-btn', function(e) {
        e.preventDefault();
        try {
            const filesData = $(this).attr('data-files');
            const type = $(this).attr('data-type') || 'image';
            const title = $(this).attr('data-title') || 'Preview Files';

            if (filesData) {
                const files = JSON.parse(filesData);
                showPreviewModal(files, type, title);
            }
        } catch (error) {
            console.error('Error parsing preview data:', error);
        }
    });

    // Edit Target Modal functionality
    const $editModal = $('#editTargetModal');
    const $editForm = $('#editTargetForm');

    // Format rupiah input
    $('#target_anggaran').on('keyup', function() {
        $(this).val(formatRupiah($(this).val()));
    });

    // Fix modal flash issue by showing content only when modal is actually shown
    $editModal.on('show.bs.modal', function() {
        setTimeout(() => {
            $(this).find('.modal-content').css('opacity', '1');
        }, 50);
    });

    $editModal.on('hidden.bs.modal', function() {
        $(this).find('.modal-content').css('opacity', '0');
        $editForm.find('.invalid-feedback').text('');
        $editForm.find('.is-invalid').removeClass('is-invalid');
    });

    // Save target button
    $('#saveTargetBtn').on('click', function() {
        const $submitBtn = $(this);
        const $targetInput = $('#target_anggaran');
        const unformattedValue = unformatRupiah($targetInput.val());

        $targetInput.val(unformattedValue);
        const formData = $editForm.serialize();
        $targetInput.val(formatRupiah(unformattedValue));

        $submitBtn.addClass('btn-loading').prop('disabled', true);

        $.ajax({
            url: "<?php echo e(route('admin.laporan-lpj.bidang.dynamic.target.store-or-update')); ?>",
            type: 'POST',
            data: formData,
            headers: { 'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>' },
            success: function(response) {
                $submitBtn.removeClass('btn-loading').prop('disabled', false);

                if (response.success) {
                    $editModal.modal('hide');
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
                        const $field = $editForm.find(`[name="${field}"]`);
                        $field.addClass('is-invalid');
                        $field.siblings('.invalid-feedback').text(messages.join(', '));
                    });
                } else {
                    showNotification('Terjadi kesalahan. Silakan coba lagi.', 'error');
                }
            }
        });
    });

    // Enhanced Modal Event Handlers (from Document 2)
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
                        if (input.attr('type') !== 'file' && originalData.hasOwnProperty(name)) {
                            input.val(originalData[name]);
                        }
                    });
                }
            }

            // Reset dropzone files
            if (typeof dropzones !== 'undefined') {
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
    // Initialize everything
    initializeDataTable();
    initializeDropdownEvents();
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\ThinkPad\OneDrive\Dokumen\GitHub\web-koni\resources\views/admin/laporan-lpj/bidang_new/dynamic/index.blade.php ENDPATH**/ ?>