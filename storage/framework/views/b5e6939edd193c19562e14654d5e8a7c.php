<?php $__env->startSection('pageTitle', 'Pengajuan Modifikasi Laporan'); ?>
<?php $__env->startSection('mainSection', 'Laporan LPJ'); ?>
<?php $__env->startSection('currentSection', 'Pengajuan Modifikasi Laporan'); ?>

<?php $__env->startSection('content'); ?>
    <style>
        /* Body and main content styling */
        body {
            background-color: #f5f5f5;
        }

        .main-content {
            background-color: #f5f5f5;
            min-height: 100vh;
            padding: 20px 10px 40px;
        }

        /* Table and card styling */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .card-header {
            background: white;
            color: black;
            border: none;
        }

        .card-title {
            color: black !important;
        }

        .card-body {
            background: #fafbfc;
        }

        .table {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .table thead th {
            background: #f8f9fa;
            border: none;
            color: #495057;
            font-weight: 600;
            padding: 1rem 0.75rem;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        .table tbody td {
            border: none;
            padding: 1rem 0.75rem;
            vertical-align: middle;
            border-bottom: 1px solid #f1f3f4;
        }

        .table tbody tr:hover {
            background: #f8f9fa;
            transition: background-color 0.2s ease;
        }

        .table td,
        .table th {
            vertical-align: middle;
            word-wrap: break-word;
            max-width: 200px;
        }

        /* Loading overlay */
        .loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10;
        }

        /* Enhanced Modal Styling */
        .modal-dialog-custom {
            max-width: 800px;
        }

        .modal-content-custom {
            border: none;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .modal-header-custom {
            background: white;
            color: #dc3545;
            padding: 1.5rem 2rem;
            border: none;
            border-bottom: 3px solid #dc3545;
        }

        .modal-header-custom .modal-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin: 0;
            color: #dc3545;
        }

        .modal-header-custom .btn-close {
            background: none;
            border: none;
            color: #dc3545;
            opacity: 0.8;
            font-size: 1.2rem;
            padding: 0;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .modal-body-custom {
            padding: 2rem;
            background: #f1f3f5;
            overflow-x: hidden;
        }

        .detail-section {
            background: white;
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            /* border-left: 4px solid #dc3545; */
            overflow: hidden;
        }

        .detail-section:last-child {
            margin-bottom: 0;
        }

        .section-title {
            color: #495057;
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
        }

        .section-title i {
            margin-right: 8px;
            color: #dc3545;
        }

        .detail-item {
            margin-bottom: 1rem;
        }

        .detail-item:last-child {
            margin-bottom: 0;
        }

        .detail-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.25rem;
            font-size: 0.9rem;
        }

        .detail-value {
            color: #6c757d;
            margin: 0;
            line-height: 1.5;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: capitalize;
        }

        .status-menunggu {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }

        .status-disetujui {
            background: #d4edda;
            color: #155724;
            border: 1px solid #00b894;
        }

        .status-ditolak {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #e74c3c;
        }

        .modal-footer-custom {
            background: white;
            padding: 1.5rem 2rem;
            border: none;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
        }

        .action-buttons {
            display: flex;
            gap: 0.75rem;
        }

        .btn-action {
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            border: none;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-approve {
            background: #28a745;
            color: white;
        }

        .btn-approve:hover {
            background: linear-gradient(135deg, #24913e, #28a745);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
            color: white;
        }

        .btn-reject {
            background: #dc3545;
            color: white;
        }

        .btn-reject:hover {
            background: linear-gradient(135deg, #b12a38, #dc3545);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
            color: white;
        }

        .btn-close-custom {
            background: #6c757d;
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-close-custom:hover {
            background: #5a6268;
            color: white;
        }

        .alasan-box {
            padding: 0.4rem 0.5rem; /* smaller top/bottom padding for compact look */
            line-height: 1.4;
            max-height: 120px; /* optional: limit height if text gets very long */
            overflow-y: auto;
            background: #f5f5f5; /* optional: subtle background for clarity */
            border-radius: 4px;  /* optional: make it look neat */
        }

        .alasan-box::-webkit-scrollbar {
            width: 6px;
        }

        .alasan-box::-webkit-scrollbar-track {
            background: #f8f9fa;
            border-radius: 3px;
        }

        .alasan-box::-webkit-scrollbar-thumb {
            background: #dc3545;
            border-radius: 3px;
        }

        .alasan-box::-webkit-scrollbar-thumb:hover {
            background: #b12a38;
        }

        .alasan-box .detail-value {
            margin: 0;
            line-height: 1.4;
            hyphens: auto;
            -webkit-hyphens: auto;
            -ms-hyphens: auto;
            overflow-wrap: anywhere;
        }

        /* Search and filter styling */
        .filter-btn-custom {
            border: 1px solid #dee2e6 !important;
            background-color: white;
        }

        .filter-btn-custom:hover {
            background-color: #f8f9fa;
        }

        /* Pagination styling from documents 1 and 2 */
        .pagination-arrow {
            color: #6c757d;
            text-decoration: none;
            padding: 6px 8px;
            transition: color 0.2s ease;
            cursor: pointer;
        }

        .pagination-arrow:hover {
            color: #0b0b0b;
            text-decoration: none;
        }

        .pagination-arrow.disabled {
            color: #adb5bd;
            cursor: not-allowed;
            opacity: 0.6;
        }

        .pagination-number {
            color: #6c757d;
            text-decoration: none;
            padding: 6px 10px;
            margin: 0 1px;
            border-radius: 4px;
            transition: all 0.2s ease;
            background-color: #f8f9fa;
            border: 1px solid transparent;
            font-size: 0.875rem;
        }

        .pagination-number:hover {
            color: #89add1;
            background-color: #e9ecef;
            text-decoration: none;
        }

        .pagination-number.active {
            background-color: #e4e6e9;
            color: rgb(4, 4, 4);
            border-color: #e0e1e4;
        }

        .text-truncate-custom {
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* Sortable header styling */
        .sortable-header {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .sortable-header:hover {
            color: #0d6efd !important;
        }

        /* Button styling improvements */
        .btn-sm {
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-weight: 500;
            font-size: 0.85rem;
        }

        .btn-outline-primary {
            border-color: #dc3545;
            color: #dc3545;
        }

        .btn-outline-primary:hover {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        /* Toast Notifications */
        .notification-toast {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            min-width: 300px;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .modal-dialog-custom {
                margin: 1rem;
                max-width: calc(100% - 2rem);
            }

            .modal-body-custom {
                padding: 1.5rem;
            }

            .modal-footer-custom {
                flex-direction: column;
                gap: 1rem;
            }

            .action-buttons {
                width: 100%;
                justify-content: center;
            }

            .alasan-box {
                padding: 0.5rem;
                max-height: 120px;
            }

            .table-header,
            .table-footer {
                padding: 15px;
            }

            .d-flex.justify-content-between.align-items-center.flex-wrap {
                flex-direction: column;
                gap: 15px;
            }

            .d-flex.align-items-center.gap-2.flex-wrap {
                justify-content: center;
                width: 100%;
            }

            .table-responsive {
                border-radius: 6px;
            }

            .table thead th,
            .table tbody tr td {
                padding: 8px 6px !important;
                font-size: 0.8rem;
            }

            .d-flex.justify-content-between.align-items-center.flex-wrap {
                flex-direction: column;
                gap: 1rem;
                align-items: center !important;
            }

            .d-flex.align-items-center.gap-3 {
                flex-direction: column;
                gap: 0.5rem !important;
            }

            .pagination-arrow,
            .pagination-number {
                padding: 4px 6px;
                font-size: 0.75rem;
            }
        }

        @media (max-width: 576px) {
            .pagination-sm .page-link {
                padding: 0.2rem 0.4rem;
                font-size: 0.7rem;
            }
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

        .cursor-pointer {
            cursor: pointer;
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

        /* Hover effect for approved date cells */
        .approved-date-cell:hover {
            background-color: rgba(248, 249, 250, 0.5);
            border-radius: 4px;
            transition: background-color 0.2s ease;
        }
        }
    </style>

    <div class="d-flex flex-column mb-8">
        <h1 class="text-dark fw-bold mb-1">Pengajuan Modifikasi Laporan</h1>
        <p class="text-muted">Daftar pengajuan untuk modifikasi data laporan LPJ.</p>
    </div>

    <div class="row col-12 mt-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap py-5">
                <h3 class="card-title fw-bold fs-4 mb-0">Daftar Pengajuan</h3>

                
                <div class="d-flex align-items-center gap-2 flex-wrap ms-auto">
                    
                    <div class="input-group position-relative" style="width: 250px;">
                        <input type="search" name="search" id="search" class="form-control"
                            placeholder="Cari pengajuan..." value="<?php echo e(request('search')); ?>" autocomplete="off">

                        <button class="btn btn-outline-secondary search-clear-btn d-none" type="button" id="clear-search"
                            style="position: absolute; right: 45px; z-index: 10; border: none; background: transparent; padding: 8px;">
                        </button>

                        <button class="btn btn-outline-secondary" type="button" id="search-button">
                            <i class="fas fa-search"></i>
                        </button>

                        <div class="search-loading-indicator d-none position-absolute"
                            style="right: 50px; top: 50%; transform: translateY(-50%); z-index: 10;">
                            <div class="spinner-border spinner-border-sm text-primary" role="status">
                                <span class="visually-hidden">Mencari pengajuan...</span>
                            </div>
                        </div>
                    </div>

                    
                    <div class="dropdown">
                        <button class="btn filter-btn-custom dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-filter me-1"></i> Status
                        </button>
                        <div class="dropdown-menu p-3 shadow" style="min-width: 200px;">
                            <select id="filter-status" class="form-select">
                                <option value="">Semua Status</option>
                                <option value="menunggu persetujuan" <?php echo e(request('status') === 'menunggu persetujuan' ? 'selected' : ''); ?>>Menunggu Persetujuan</option>
                                <option value="disetujui" <?php echo e(request('status') === 'disetujui' ? 'selected' : ''); ?>>Disetujui</option>
                                <option value="ditolak" <?php echo e(request('status') === 'ditolak' ? 'selected' : ''); ?>>Ditolak</option>
                            </select>
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
                    <?php echo $__env->make('admin.laporan-lpj.pengajuan._table', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>
        </div>
    </div>

    
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-custom modal-dialog-centered">
            <div class="modal-content modal-content-custom">
                <div class="modal-header modal-header-custom">
                    <h5 class="modal-title" id="detailModalLabel">
                        <i class="fas fa-file-alt me-2"></i>Detail Pengajuan Modifikasi
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times me-1" style="font-size: 20px; color:#e74c3c"></i>
                    </button>
                </div>
                <div class="modal-body modal-body-custom" id="detailModalBody">
                    <!-- Content will be populated by JavaScript -->
                </div>
                <div class="modal-footer modal-footer-custom" id="detailModalFooter">
                    <button type="button" class="btn btn-close-custom" data-bs-dismiss="modal">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script>
        $(document).ready(function() {
            $.fn.dataTable.ext.errMode = 'none';
            let dataTable = null;
            let searchTimeout;
            let isSearching = false;

            function initializeDataTable() {
                const table = $("#kt_datatable_dom_positioning_pengajuan");

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

            function showLoading() {
                $('#loading-overlay').removeClass('d-none');
            }

            function hideLoading() {
                $('#loading-overlay').addClass('d-none');
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

            function updateTable(params = {}) {
                return new Promise((resolve, reject) => {
                    if (params.search === undefined) {
                        showLoading();
                    }

                    const baseUrl = "<?php echo e(route('admin.laporan-lpj.pengajuan.index')); ?>";
                    const currentUrl = new URL(baseUrl, window.location.origin);

                    for (const key in params) {
                        if (params[key] !== null && params[key] !== undefined && params[key] !== '') {
                            currentUrl.searchParams.set(key, params[key]);
                        } else {
                            currentUrl.searchParams.delete(key);
                        }
                    }

                    if (params.search !== undefined || params.status !== undefined) {
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

            // Initialize everything
            initializeDataTable();
            initializeTooltips();

            // Search functionality with debouncing
            $('#search').on('input', function() {
                const searchValue = $(this).val().trim();

                if (searchTimeout) clearTimeout(searchTimeout);

                // Show/hide clear button
                if (searchValue) {
                    $('.search-clear-btn').removeClass('d-none');
                } else {
                    $('.search-clear-btn').addClass('d-none');
                }

                searchTimeout = setTimeout(() => {
                    updateTable({
                        'search': searchValue,
                        'status': $('#filter-status').val()
                    });
                }, 300);
            });

            // Clear search functionality
            $('#clear-search').on('click', function() {
                $('#search').val('');
                $('.search-clear-btn').addClass('d-none');
                updateTable({
                    'search': '',
                    'status': $('#filter-status').val()
                });
            });

            // Status filter functionality
            $('#filter-status').on('change', function() {
                updateTable({
                    'search': $('#search').val(),
                    'status': $(this).val()
                });
            });

            // Pagination functionality
            $(document).on('click', '.pagination-link', function(e) {
                e.preventDefault();
                const url = new URL($(this).attr('href'));
                const page = url.searchParams.get('page');
                updateTable({
                    'search': $('#search').val(),
                    'status': $('#filter-status').val(),
                    'page': page
                });
            });

            // Per page functionality
            $(document).on('change', 'select[name="per_page"]', function() {
                updateTable({
                    'search': $('#search').val(),
                    'status': $('#filter-status').val(),
                    'per_page': $(this).val(),
                    'page': 1
                });
            });

            // Enhanced detail modal function
            function getStatusBadge(status) {
                const badges = {
                    'menunggu persetujuan': '<span class="status-badge status-menunggu"><i class="fas fa-clock me-1" style="color: #856404;"></i>Menunggu Persetujuan</span>',
                    'disetujui': '<span class="status-badge status-disetujui"><i class="fas fa-check-circle me-1" style="color: #155724;"></i>Disetujui</span>',
                    'ditolak': '<span class="status-badge status-ditolak"><i class="fas fa-times-circle me-1" style="color: #721c24;"></i>Ditolak</span>'
                };
                return badges[status] || `<span class="status-badge">${status}</span>`;
            }

            window.showDetailModal = function(data) {
                const modalBody = $('#detailModalBody');
                const modalFooter = $('#detailModalFooter');
                modalBody.empty();
                modalFooter.find('.action-btn').remove();

                const lpj = data.lpj || {};
                const user = data.user || {};

                const content = `
                    <div class="detail-section">
                        <div class="section-title">
                            <i class="fas fa-calendar-alt"></i>
                            Detail Laporan LPJ
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Program</div>
                            <p class="detail-value">${lpj.nama_program || 'Tidak tersedia'}</p>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Kegiatan</div>
                            <p class="detail-value">${lpj.nama_kegiatan || 'Tidak tersedia'}</p>
                        </div>
                    </div>

                    <div class="detail-section">
                        <div class="section-title">
                            <i class="fas fa-edit"></i>
                            Detail Pengajuan Modifikasi
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Pengaju</div>
                            <p class="detail-value">
                                <i class="fas fa-user me-1 text-muted"></i>
                                ${user ? user.username : 'User not found'}
                            </p>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Tanggal Pengajuan</div>
                            <p class="detail-value">
                                <i class="fas fa-calendar me-1 text-muted"></i>
                                ${data.created_at ? new Date(data.created_at).toLocaleDateString('id-ID', {
                                    year: 'numeric',
                                    month: 'long',
                                    day: 'numeric',
                                    hour: '2-digit',
                                    minute: '2-digit'
                                }) : 'Tidak tersedia'}
                            </p>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Status Pengajuan</div>
                            <div class="detail-value">
                                ${getStatusBadge(data.status)}
                            </div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Alasan Pengajuan</div>
                            <div class="alasan-box">
                                <p class="detail-value mb-0 text-dark">${data.alasan || 'Tidak ada alasan yang diberikan'}</p>
                            </div>
                        </div>
                    </div>
                `;
                modalBody.html(content);

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('pengajuan-modifikasi-laporan')): ?>
                    if (data.status === 'menunggu persetujuan') {
                        const actionButtons = $(`
                            <div class="action-buttons">
                                <button class="btn btn-action btn-approve action-btn" data-action="approve">
                                    <i class="fas fa-check" style="color: white"></i>Terima Pengajuan
                                </button>
                                <button class="btn btn-action btn-reject action-btn" data-action="reject">
                                    <i class="fas fa-times" style="color: white"></i>Tolak Pengajuan
                                </button>
                            </div>
                        `);

                        actionButtons.find('[data-action="approve"]').on('click', () => handlePengajuanAction(data.id, 'disetujui'));
                        actionButtons.find('[data-action="reject"]').on('click', () => handlePengajuanAction(data.id, 'ditolak'));

                        modalFooter.prepend(actionButtons);
                    }
                <?php endif; ?>

                // Apply custom classes to modal
                const modal = document.getElementById('detailModal');
                modal.querySelector('.modal-dialog').className = 'modal-dialog modal-dialog-custom modal-dialog-centered';
                modal.querySelector('.modal-content').className = 'modal-content modal-content-custom';
                modal.querySelector('.modal-header').className = 'modal-header modal-header-custom';
                modal.querySelector('.modal-body').className = 'modal-body modal-body-custom';
                modal.querySelector('.modal-footer').className = 'modal-footer modal-footer-custom';

                new bootstrap.Modal(modal).show();
            };

            window.handlePengajuanAction = function(id, newStatus) {
                const actionText = newStatus === 'disetujui' ? 'menyetujui' : 'menolak';
                const confirmText = newStatus === 'disetujui' ? 'Setujui Pengajuan' : 'Tolak Pengajuan';

                Swal.fire({
                    title: `Konfirmasi ${actionText.charAt(0).toUpperCase() + actionText.slice(1)}`,
                    text: `Apakah Anda yakin ingin ${actionText} pengajuan ini?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: newStatus === 'disetujui' ? '#28a745' : '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: confirmText,
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Show loading
                        Swal.fire({
                            title: 'Memproses...',
                            text: 'Mohon tunggu',
                            allowOutsideClick: false,
                            showConfirmButton: false,
                            willOpen: () => Swal.showLoading()
                        });

                        const url = `/admin/laporan-lpj/pengajuan/${id}/status`;

                        $.ajax({
                            url: url,
                            type: 'POST',
                            data: {
                                _token: '<?php echo e(csrf_token()); ?>',
                                _method: 'PATCH',
                                status: newStatus
                            },
                            success: function(response) {
                                Swal.close();
                                if(response.success) {
                                    const successMessage = newStatus === 'disetujui' ?
                                        'Pengajuan berhasil disetujui!' :
                                        'Pengajuan berhasil ditolak!';

                                    Swal.fire({
                                        title: 'Berhasil!',
                                        text: successMessage,
                                        icon: 'success',
                                        timer: 2000,
                                        showConfirmButton: false
                                    });

                                    $('#detailModal').modal('hide');
                                    updateTable({
                                        'search': $('#search').val(),
                                        'status': $('#filter-status').val()
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Gagal!',
                                        text: response.message || 'Gagal mengubah status pengajuan.',
                                        icon: 'error'
                                    });
                                }
                            },
                            error: function(xhr) {
                                Swal.close();
                                const errorMessage = xhr.responseJSON?.message || 'Terjadi kesalahan. Silakan coba lagi.';
                                Swal.fire({
                                    title: 'Error!',
                                    text: errorMessage,
                                    icon: 'error'
                                });
                            }
                        });
                    }
                });
            };

            // Handle browser back/forward buttons
            window.addEventListener('popstate', function(event) {
                location.reload();
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/gustibagus/Documents/GitHub/web-koni/resources/views/admin/laporan-lpj/pengajuan/index.blade.php ENDPATH**/ ?>