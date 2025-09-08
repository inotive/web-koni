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

<?php $__env->startSection('pageTitle', $currentParent ? $currentParent->nama_program : 'Root Level'); ?>
<?php $__env->startSection('mainSection', 'Laporan LPJ'); ?>
<?php $__env->startSection('subSection', 'Bidang Bidang'); ?>
<?php $__env->startSection('subSectionUrl', route('admin.laporan-lpj.bidang.index')); ?>
<?php $__env->startSection('subSection2', $parent?->parent?->parent?->nama_program ?? ''); ?>
<?php $__env->startSection('subSection2Url', route('admin.laporan-lpj.bidang.prestasi.index')); ?>
<?php $__env->startSection('subSection3', $parent?->parent?->nama_program ?? ''); ?>
<?php $__env->startSection('subSection3Url', $subSection3Url); ?>

<?php $__env->startSection('currentSection', $currentParent ? $currentParent->nama_program : 'Root Level'); ?>

<?php $__env->startSection('breadcrumb-title'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <style>
        /* Include your existing styles */
        body {
            background-color: #f5f5f5;
        }

        .main-content {
            background-color: #f5f5f5;
            min-height: 100vh;
            padding: 20px 10px 40px;
        }

        /* Navigation Styles */
        .navigation-card {
            background: white;
            border-radius: 12px;
            border: 1px solid #e9ecef;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
            margin-bottom: 20px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            padding: 12px 16px;
            border-bottom: 1px solid #f0f0f0;
            transition: all 0.2s ease;
            text-decoration: none;
            color: #495057;
        }

        .nav-item:hover {
            background-color: #f8f9fa;
            color: #0d6efd;
            text-decoration: none;
        }

        .nav-item:last-child {
            border-bottom: none;
        }

        .nav-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa;
            border-radius: 8px;
            margin-right: 12px;
            font-size: 1.2rem;
        }

        .nav-content {
            flex: 1;
        }

        .nav-title {
            font-weight: 600;
            margin-bottom: 2px;
            color: #212529;
        }

        .nav-subtitle {
            font-size: 0.85rem;
            color: #6c757d;
        }

        .nav-meta {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.8rem;
            color: #6c757d;
        }

        .category-badge {
            background-color: #e3f2fd;
            color: #1976d2;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 0.75rem;
        }

        .data-badge {
            background-color: #e8f5e8;
            color: #2e7d32;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 0.75rem;
        }

        .back-navigation {
            margin-bottom: 20px;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            background-color: #6c757d;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-size: 0.9rem;
            transition: all 0.2s ease;
        }

        .back-btn:hover {
            background-color: #5a6268;
            color: white;
            text-decoration: none;
        }

        /* Table and existing styles */
        table td,
        table th {
            vertical-align: middle;
            word-wrap: break-word;
            max-width: 200px;
        }

        .object-fit-cover {
            object-fit: cover;
        }

        .table th:nth-child(1) { width: 40px; }
        .table th:nth-child(2) { width: 250px; }
        .table th:nth-child(3) { width: 100px; }
        .table th:nth-child(4) { width: 150px; }
        .table th:nth-child(5) { width: 150px; }
        .table th:nth-child(6) { width: 150px; }
        .table th:nth-child(7) { width: 150px; }
        .table th:nth-child(8) { width: 80px; }

        .text-truncate-custom {
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* Dropdown styles */
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

        .btn-restricted {
            cursor: not-allowed !important;
            opacity: 0.6 !important;
            pointer-events: none;
        }

        /* Enhanced Preview Modal Styles */
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
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            background: white;
            padding: 10px;
        }

        .preview-document {
            width: 100%;
            height: 80%;
            border: none;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
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

        /* Custom tooltip styling */
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

        .tooltip-content strong {
            color: #333333;
            font-weight: 600;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .filter-btn-custom {
            border: 1px solid #dee2e6 !important;
            background-color: white;
        }

        .filter-btn-custom:hover {
            background-color: #f8f9fa;
        }

        /* Custom Ajukan Perubahan Button */
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

                #export-pdf-btn {
            background-color: #e63946; /* Modern, softer red */
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
            background-color: #d62828; /* Darker shade for hover */
            box-shadow: 0 3px 8px rgba(214, 40, 40, 0.4);
            transform: translateY(-1px);
        }

        #export-pdf-btn:active {
            background-color: #ba181b; /* Even deeper red for active press */
            transform: translateY(0);
            box-shadow: 0 2px 4px rgba(186, 24, 27, 0.3);
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

    
    <div class="row col-12 mt-5">
        <div class="card">
            
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
                    <span id="statusIcon"class="ms-2 fs-6 gap-3"></span>

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
            const parentId = <?php echo e($parentId ?? 'null'); ?>;

            function initializeDataTable() {
                const table = $("#kt_datatable_dom_positioning_sumberdaya");

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

            initializeDataTable();

            function showLoading() {
                $('#loading-overlay').removeClass('d-none');
            }

            function hideLoading() {
                $('#loading-overlay').addClass('d-none');
            }

            function updateTable(params = {}) {
                return new Promise((resolve, reject) => {
                    if (params.search === undefined) {
                        showLoading();
                    }

                    let baseUrl;
                    if (parentId) {
                        baseUrl = "<?php echo e(route('admin.laporan-lpj.bidang.dynamic.child.index', ':parentId')); ?>".replace(':parentId', parentId);
                    } else {
                        baseUrl = "<?php echo e(route('admin.laporan-lpj.bidang.dynamic.index')); ?>";
                    }

                    const currentUrl = new URL(baseUrl, window.location.origin);

                    for (const key in params) {
                        if (params[key] !== null && params[key] !== undefined && params[key] !== '') {
                            currentUrl.searchParams.set(key, params[key]);
                        } else {
                            currentUrl.searchParams.delete(key);
                        }
                    }

                    if (params.search !== undefined || params.jenis_kegiatan_filter !== undefined) {
                        if (!params.page) {
                            currentUrl.searchParams.set('page', 1);
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

            function initializeTooltips() {
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl, {
                        trigger: 'hover focus'
                    });
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
                });

                $(document).on('click', function(e) {
                    if (!$(e.target).closest('.dropdown-action').length) {
                        $('.dropdown-menu-custom').removeClass('show');
                    }
                });
            }

            function showNotification(message, type = 'info') {
                const alertClass = {
                    'success': 'alert-success',
                    'error': 'alert-danger',
                    'warning': 'alert-warning',
                    'info': 'alert-info'
                }[type] || 'alert-info';

                const notification = $(`
                    <div class="alert ${alertClass} alert-dismissible fade show notification-toast"
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
                updateTable({
                    'page': page
                });
            });

            $(document).on('change', 'select[name="per_page"]', function() {
                const perPage = $(this).val();
                updateTable({
                    'per_page': perPage,
                    'page': 1
                });
            });

            initializeTooltips();
            initializeDropdownEvents();

            window.deleteItemWithSwal = function(itemId, itemName = 'item ini') {
                const url = "<?php echo e(route('admin.laporan-lpj.bidang.dynamic.destroy', ':id')); ?>".replace(':id', itemId);

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

                        $.ajax({
                            url: url,
                            type: 'POST',
                            data: {
                                _token: '<?php echo e(csrf_token()); ?>',
                                _method: 'DELETE'
                            },
                            success: function(response) {
                                Swal.close();
                                if (response.success) {
                                    Swal.fire({
                                        title: 'Berhasil!',
                                        text: response.message || 'Data berhasil dihapus.',
                                        icon: 'success',
                                        timer: 2000,
                                        showConfirmButton: false
                                    });
                                    updateTable();
                                } else {
                                    Swal.fire({
                                        title: 'Gagal!',
                                        text: response.message || 'Terjadi kesalahan saat menghapus',
                                        icon: 'error'
                                    });
                                }
                            },
                            error: function(xhr) {
                                Swal.close();
                                Swal.fire({
                                    title: 'Error!',
                                    text: xhr.responseJSON?.message || 'Terjadi kesalahan jaringan.',
                                    icon: 'error'
                                });
                            }
                        });
                    }
                });
            };

            window.showDetailModal = function (data) {
                const modalBody = document.getElementById('detailModalBody');
                const statusIcon  = document.getElementById('statusIcon');
                const exportBtn = document.getElementById('export-pdf-btn');

                if(exportBtn) {
                    exportBtn.setAttribute('data-lpj-id', data.id);
                }

                if (!modalBody) return;

                /* ---------- status indicator ---------- */
                if (statusIcon) {
                    const canPengajuanModifikasi = <?php echo e(auth()->user()->can('pengajuan-modifikasi-laporan') ? 'true' : 'false'); ?>;
                    const isModifiable   = data.modifiable_by_user_id && data.modifiable_by_user_id == <?php echo e(auth()->id()); ?>;
                    const pengajuan = data.pengajuan ? data.pengajuan.filter(p => p.status === 'disetujui').sort((a, b) => new Date(b.approved_at) - new Date(a.approved_at))[0] : null;
                    const hasToken = pengajuan && pengajuan.token > 0;

                    if (canPengajuanModifikasi || (isModifiable && hasToken)) {
                        statusIcon.innerHTML = 'Terbuka';
                        statusIcon.className = 'badge border-success text-success bg-opacity-20 bg-success fs-7 d-flex align-items-center';
                    } else {
                        statusIcon.innerHTML = 'Terkunci';
                        statusIcon.className = 'badge border-danger text-danger bg-opacity-20 bg-danger fs-7 d-flex align-items-center';
                    }

                    const ajukanBtn = document.getElementById('ajukanPerubahanBtn'); // ✅ target the button
                        if (ajukanBtn) {
                            if (canPengajuanModifikasi || (isModifiable && hasToken)) {
                                ajukanBtn.style.display = 'none'; // hide button if user already owns modifiable
                            } else {
                                ajukanBtn.style.display = ''; // show otherwise
                            }
                        }
                }

                /* ---------- store id for “Ajukan Perubahan” ---------- */
                $('#detailModal').data('lpj-id', data.id);

                /* ---------- populate body ---------- */
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
                                            onclick="window.open('/storage/${f}','_blank')">
                                    </div>
                                </div>`).join('')}
                        </div>`;
                }

                let dokumenHtml = '<div class="text-muted fst-italic">Tidak ada dokumen tersedia</div>';
                if (data.dokumen_pendukung && data.dokumen_pendukung.length) {
                    dokumenHtml = `
                        <div class="d-flex flex-column gap-2">
                            ${data.dokumen_pendukung.map(d => {
                                const name = d.split('/').pop();
                                const ext  = name.split('.').pop().toLowerCase();
                                const icon = {
                                    pdf:'fas fa-file-pdf text-danger',
                                    doc:'fas fa-file-word text-primary',
                                    docx:'fas fa-file-word text-primary',
                                    xls:'fas fa-file-excel text-success',
                                    xlsx:'fas fa-file-excel text-success',
                                    jpg:'fas fa-file-image text-info',
                                    jpeg:'fas fa-file-image text-info',
                                    png:'fas fa-file-image text-info'
                                }[ext] || 'fas fa-file text-secondary';
                                return `
                                    <div class="d-flex align-items-center p-2 border rounded bg-light">
                                        <i class="${icon} me-3" style="font-size:1.2em"></i>
                                        <div class="flex-grow-1">
                                            <div class="fw-medium">${name}</div>
                                            <small class="text-muted">${ext.toUpperCase()}</small>
                                        </div>
                                        <a href="/storage/${d}" target="_blank" class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-download me-1"></i>Unduh
                                        </a>
                                    </div>`;
                            }).join('')}
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
                    </div>`;

                new bootstrap.Modal(document.getElementById('detailModal')).show();
            };

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

            // Export functionality
            $('#export-pdf-btn').on('click', function(e) {
                e.preventDefault();

                const lpjId = $(this).attr('data-lpj-id');

                if (lpjId) {
                    let exportUrl = "<?php echo e(route('admin.laporan-lpj.bidang.dynamic.export-pdf', ':id')); ?>".replace(':id', lpjId);
                    window.location.href = exportUrl;
                } else {
                    console.error('LPJ ID not found for export.');
                    // You could show a user-friendly error message here
                    alert('Tidak dapat mengekspor PDF, ID laporan tidak ditemukan.');
                }
            });

            // Enhanced Preview Modal functionality
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

            // Global preview function
            window.showPreviewModal = function(files, type, title) {
                currentFiles = files;
                currentType = type;
                currentIndex = 0;
                modalTitle.textContent = title || 'Preview Files';

                console.log('Preview modal data:', { files, type, title }); // Debug log

                loadPreview();
                $('#previewModal').modal('show');
            };

            $(document).on('click', '.preview-btn', function(e) {
                e.preventDefault();
                const btn = $(this);
                try {
                    const filesData = btn.attr('data-files');
                    const type = btn.attr('data-type') || 'image';
                    const title = btn.attr('data-title') || 'Preview Files';

                    console.log('Button clicked:', { filesData, type, title }); // Debug log

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

            function loadPreview() {
                if (!previewSlides || !currentFiles || currentFiles.length === 0) {
                    console.error('No preview slides container or files');
                    return;
                }

                previewSlides.innerHTML = '';

                currentFiles.forEach((file, index) => {
                    const slide = document.createElement('div');
                    slide.className = `preview-slide ${index === currentIndex ? 'active' : ''}`;

                    console.log(`Loading file ${index}: ${file}, type: ${currentType}`); // Debug log

                    if (currentType === 'image' || currentType === 'foto') {
                        slide.innerHTML = `
                            <img src="/storage/${file}"
                                 alt="Preview"
                                 class="preview-image"
                                 onerror="console.error('Failed to load image: /storage/${file}')">
                        `;
                    } else if (currentType === 'document' || currentType === 'dokumen') {
                        const fileName = file.split('/').pop();
                        const fileExtension = fileName.split('.').pop().toLowerCase();

                        if (fileExtension === 'pdf') {
                            slide.innerHTML = `
                                <iframe src="/storage/${file}"
                                        class="preview-document"
                                        onerror="console.error('Failed to load PDF: /storage/${file}')"></iframe>
                            `;
                        } else {
                            const iconClass = getFileIcon(fileExtension);
                            slide.innerHTML = `
                                <div class="document-placeholder">
                                    <i class="${iconClass}"></i>
                                    <h5>${fileName}</h5>
                                    <p>Click download to view this ${fileExtension.toUpperCase()} file</p>
                                    <a href="/storage/${file}" class="btn btn-primary" target="_blank">
                                        <i class="fas fa-external-link-alt me-2"></i>Open File
                                    </a>
                                </div>
                            `;
                        }
                    } else {
                        // Auto-detect based on file extension
                        const fileName = file.split('/').pop();
                        const fileExtension = fileName.split('.').pop().toLowerCase();
                        const imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'];

                        if (imageExtensions.includes(fileExtension)) {
                            slide.innerHTML = `
                                <img src="/storage/${file}"
                                     alt="Preview"
                                     class="preview-image"
                                     onerror="console.error('Failed to load image: /storage/${file}')">
                            `;
                        } else {
                            const iconClass = getFileIcon(fileExtension);
                            slide.innerHTML = `
                                <div class="document-placeholder">
                                    <i class="${iconClass}"></i>
                                    <h5>${fileName}</h5>
                                    <p>Click download to view this ${fileExtension.toUpperCase()} file</p>
                                    <a href="/storage/${file}" class="btn btn-primary" target="_blank">
                                        <i class="fas fa-external-link-alt me-2"></i>Open File
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

                const fileName = currentFiles[currentIndex].split('/').pop();
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
                if (!previewSlides) return;

                document.querySelectorAll('.preview-slide').forEach((slide, i) => {
                    slide.classList.toggle('active', i === index);
                });
                currentIndex = index;
                updatePreviewUI();
            }

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
                    }
                }
            });

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
                    'gif': 'fas fa-file-image text-info'
                };
                return icons[extension] || 'fas fa-file text-muted';
            }

            $('#previewModal').on('show.bs.modal', function() {
                if (currentFiles && currentFiles.length > 0) {
                    showSlide(0);
                }
            });

            $('#previewModal').on('shown.bs.modal', function() {
                // Ensure images are properly loaded after modal is fully shown
                const activeSlide = document.querySelector('.preview-slide.active');
                if (activeSlide) {
                    const img = activeSlide.querySelector('img');
                    if (img && !img.complete) {
                        img.onload = function() {
                            console.log('Image loaded successfully');
                        };
                    }
                }
            });

        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\ThinkPad\OneDrive\Dokumen\GitHub\web-koni\resources\views/admin/laporan-lpj/bidang_new/dynamic/index.blade.php ENDPATH**/ ?>