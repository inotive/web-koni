<?php $__env->startSection('pageTitle', 'Manajemen Prestasi'); ?>
<?php $__env->startSection('mainSection', 'Konfigurasi'); ?>
<?php $__env->startSection('mainSectionUrl', route('admin.konfigurasi.atlet.index')); ?>
<?php $__env->startSection('subSection', 'Prestasi'); ?>
<?php $__env->startSection('currentSection', 'Daftar Prestasi'); ?>

<?php $__env->startSection('content'); ?>
    <style>
body {
    background-color: #f5f5f5;
}

.main-content {
    background-color: #f5f5f5;
    min-height: 100vh;
    padding: 20px 0;
}

/* Card Styles */
.card {
    background-color: white;
    border-radius: 12px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
    border: 1px solid #e9ecef;
    overflow: visible !important;
}

.card-body {
    padding: 0;
    overflow: visible !important;
}

/* Page Header */
.page-header {
    background-color: transparent;
    padding: 0;
    margin-bottom: 20px;
}

.page-header h3 {
    color: #2c3e50;
    font-size: 1.8rem;
    font-weight: 700;
}

/* Buttons */
.btn-add-prestasi {
    background: linear-gradient(135deg, #F8285A 0%, #e91e63 100%);
    border: none;
    border-radius: 8px;
    padding: 12px 24px;
    font-weight: 600;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(248, 40, 90, 0.3);
    color: white !important;
}

.btn-add-prestasi:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(248, 40, 90, 0.4);
    color: white !important;
}

/* Table Container */
.table-container {
    background-color: white;
    border-radius: 0px 0px 12px 12px;
    overflow: hidden;
}

.table-header {
    background-color: white;
    padding: 20px 25px;
    border-bottom: 1px solid #e9ecef;
    border-radius: 12px 12px 0px 0px;
    overflow: visible !important;
    position: relative;
    z-index: 10;
}

.table-footer {
    background-color: white;
    padding: 15px 25px;
    border-top: 1px solid #e9ecef;
}

/* Table Responsive */
.table-responsive {
    overflow-x: auto;
    overflow-y: visible;
    -webkit-overflow-scrolling: touch;
    border-radius: 8px;
    border: 1px solid #e9ecef;
    background-color: white;
}

/* Table Base Styles */
.table {
    border-collapse: separate !important;
    border-spacing: 0 !important;
    margin: 0 !important;
    background-color: white;
    width: 100%;
    min-width: 1200px;
    border: none;
}

/* Table Header Styles with Sort Fix */
.table thead th {
    background-color: #f8f9fa;
    border: 1px solid #e9ecef;
    border-top: none;
    font-weight: 600;
    font-size: 0.875rem;
    color: #495057;
    white-space: nowrap;
    padding: 12px 8px !important;
    position: relative;
    text-align: center !important;
}

.table thead th:last-child {
    border-right: none;
}

/* Sort Link Styles - NEW */
.table thead th .sort-link {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
    text-decoration: none;
    color: inherit;
    gap: 8px;
}

.table thead th .sort-link:hover {
    text-decoration: none;
    color: inherit;
}

.table thead th .sort-link i {
    flex-shrink: 0;
    margin-left: auto;
}

/* Column-specific alignments */
.table th:nth-child(2) .sort-link,
.table th:nth-child(3) .sort-link,
.table th:nth-child(4) .sort-link,
.table th:nth-child(5) .sort-link,
.table th:nth-child(6) .sort-link,
.table th:nth-child(7) .sort-link,
.table th:nth-child(8) .sort-link {
    justify-content: space-between;
    text-align: left;
}

.table th:nth-child(1),
.table th:nth-child(9) {
    text-align: center !important;
}

/* Table Body Styles */
.table tbody tr {
    border: 1px solid #e9ecef;
    transition: background-color 0.2s ease;
}

.table tbody tr:first-child {
    border-top: none;
}

.table tbody tr:last-child {
    border-bottom: none;
}

.table tbody tr:hover,
.table tbody tr:hover td {
    background-color: #f8f9fa;
}

.table tbody tr td {
    border: 1px solid #e9ecef !important;
    padding: 8px !important;
    font-size: 0.875rem;
    white-space: nowrap;
    vertical-align: middle;
    word-wrap: break-word;
    max-width: 200px;
    text-align: left !important;
    background-color: white;
}

.table tbody tr td:last-child {
    border-right: none !important;
}

/* Column Widths and Alignments */
.table td:first-child,
.table th:first-child {
    padding-left: 20px !important;
    padding-right: 20px !important;
}

.table td:last-child,
.table th:last-child {
    padding-right: 12px !important;
}

/* Specific column widths - adjusted for prestasi table */
.table th:nth-child(1), .table td:nth-child(1) { width: 40px; text-align: center !important; }
.table th:nth-child(2), .table td:nth-child(2) { width: 180px; text-align: left !important; }
.table th:nth-child(3), .table td:nth-child(3) { width: 100px; text-align: left !important; }
.table th:nth-child(4), .table td:nth-child(4) { width: 200px; text-align: left !important; }
.table th:nth-child(5), .table td:nth-child(5) { width: 120px; text-align: left !important; }
.table th:nth-child(6), .table td:nth-child(6) { width: 100px; text-align: left !important; }
.table th:nth-child(7), .table td:nth-child(7) { width: 140px; text-align: left !important; }
.table th:nth-child(8), .table td:nth-child(8) { width: 100px; text-align: left !important; }
.table th:nth-child(9), .table td:nth-child(9) { width: 120px; text-align: center !important; }

.table td:nth-child(1),
.table td:nth-child(9) {
    text-align: center;
}

/* Utility Classes */
.text-truncate-custom {
    max-width: 120px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.text-bronze {
    color: #CD7F32 !important;
}

.object-fit-cover {
    object-fit: cover;
}

.badge-circle {
    border-radius: 50%;
    width: 20px;
    height: 20px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 0.75rem;
}

/* Empty State */
.empty-state {
    text-align: center;
    color: #6c757d;
    padding: 60px 25px;
    background-color: white;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    margin: 20px;
}

/* Dropdowns */
.dropdown-menu {
    border: none;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    border-radius: 8px;
    z-index: 1050 !important;
    position: absolute !important;
}

/* Form Controls */
.form-select {
    border-radius: 6px;
    border: 1px solid #dee2e6;
    transition: all 0.2s ease;
}

.form-select:focus {
    border-color: #F8285A;
    box-shadow: 0 0 0 0.2rem rgba(248, 40, 90, 0.25);
}

.btn-outline-secondary:hover {
    background-color: #f5f5f5;
    border-color: #f5f5f5;
}

/* Pagination */
.pagination {
    margin-bottom: 0;
}

.pagination .page-item {
    margin: 0 1px;
}

.pagination-sm .page-link {
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
    border-radius: 4px;
    border: 1px solid #dee2e6;
    color: #6c757d;
    margin: 0 2px;
}

.pagination-sm .page-item.active .page-link {
    background-color: #F8285A;
    border-color: #F8285A;
    color: white;
}

.pagination-sm .page-link:hover {
    background-color: #f8f9fa;
    border-color: #dee2e6;
    color: #495057;
}

.pagination-sm .page-item.disabled .page-link {
    color: #6c757d;
    background-color: #fff;
    border-color: #dee2e6;
}

/* Simple Pagination Styles */
.simple-pagination .page-link {
    border: none !important;
    margin: 0 2px;
    border-radius: 4px !important;
    padding: 6px 12px !important;
    color: #6c757d !important;
    background-color: #f8f9fa !important;
    transition: all 0.2s ease;
}

.simple-pagination .page-link:hover {
    background-color: #e9ecef !important;
    color: #495057 !important;
}

.simple-pagination .page-item.active .page-link {
    background-color: #007bff !important;
    color: white !important;
}

.simple-pagination .page-link:focus {
    box-shadow: none !important;
}

/* Pagination Arrows and Numbers */
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

/* Header Layout Adjustments */
.header-wrapper {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 15px;
    margin-bottom: 20px;
}

.header-title {
    margin: 0;
    color: #2c3e50;
    font-size: 1.5rem;
    font-weight: 600;
}

.header-controls {
    display: flex;
    align-items: center;
    gap: 15px;
    flex-wrap: wrap;
}

/* Control Section */
.control-section {
    display: flex;
    align-items: center;
    gap: 15px;
    flex-wrap: wrap;
}

/* Loading States */
.loading-spinner {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 10;
}

.table-loading {
    position: relative;
    opacity: 0.7;
    pointer-events: none;
}

.spinner-border-sm {
    width: 1rem;
    height: 1rem;
}



/* Filter Button Custom */
.filter-btn-custom {
    border: 1px solid #dee2e6 !important;
    background-color: white;
}

.filter-btn-custom:hover {
    background-color: #f8f9fa;
}

/* Toast Notifications */
.notification-toast {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 9999;
    min-width: 300px;
}

.toast-success { background-color: #51a351; color: white; }
.toast-error { background-color: #bd362f; color: white; }
.toast-warning { background-color: #f89406; color: white; }
.toast-info { background-color: #2f96b4; color: white; }

/* Responsive Styles */
@media (max-width: 768px) {
    .table-header,
    .table-footer {
        padding: 15px;
    }

    .header-wrapper {
        flex-direction: column;
        gap: 15px;
        align-items: flex-start;
    }

    .header-controls {
        width: 100%;
        justify-content: space-between;
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

    .pagination-sm .page-link {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
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

    .btn-add-prestasi {
        width: 100%;
        justify-content: center;
        order: 1;
    }

    .input-group {
        order: 2;
        width: 100% !important;
    }

    .dropdown {
        order: 3;
        width: 100%;
    }

    .dropdown-toggle {
        width: 100%;
    }
}

@media (max-width: 576px) {
    .pagination-sm .page-link {
        padding: 0.2rem 0.4rem;
        font-size: 0.7rem;
    }

    .text-muted {
        font-size: 0.875rem;
    }
}

</style>

    <?php if(session('success')): ?>
        <div class="alert alert-<?php echo e(session('action') === 'store' ? 'success' : (session('action') === 'update' ? 'warning' : 'danger')); ?> alert-dismissible fade show"
            role="alert">
            <i
                class="fas <?php echo e(session('action') === 'store' ? 'fa-check-circle' : (session('action') === 'update' ? 'fa-exclamation-circle' : 'fa-trash-alt')); ?> me-2"></i>
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-header">
                                <div class="header-wrapper">
                                    <h3 class="header-title fw-semibold text-dark">Daftar Kejuaraan</h3>
                                    <div class="header-controls">
                                        <a href="<?php echo e(route('admin.konfigurasi.prestasi.create')); ?>" class="btn"
                                            style="background-color: #F8285A !important; color: white !important; border-color: #F8285A !important; border-radius: 6px; padding: 10px 15px; font-weight: 500;">
                                            <i class="ki-duotone ki-plus fs-4 me-2"
                                                style="color: white !important;"></i>Tambah
                                            Prestasi
                                        </a>

                                        <div class="input-group" style="width: 280px;">
                                            <input type="search" name="search" id="search" class="form-control"
                                                placeholder="Cari berdasarkan nama..." value="<?php echo e(request('search')); ?>">
                                            <button class="btn btn-outline-secondary" type="button">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>


                                         <a href="<?php echo e(url('/admin/konfigurasi/prestasi/export')); ?>" id="export-csv" class="btn btn-outline-secondary filter-btn-custom">
                                        <i class="fas fa-file-csv me-1"></i> Export
                                    </a>
                                        <div class="dropdown">
                                        <button class="btn btn-outline-secondary dropdown-toggle filter-btn-custom" type="button"
                                            data-bs-toggle="dropdown">
                                            <i class="fas fa-filter me-1"></i> Filter
                                            <span id="filter-count" class="badge badge-circle badge-danger ms-1 d-none">0</span>
                                        </button>
                                            <div class="dropdown-menu p-3 shadow" style="min-width: 280px; border: 1px solid #ced4da;">
                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">
                                                        <i class="fas fa-calendar-alt me-1"></i>Tahun
                                                    </label>
                                                    <select id="filter-tahun" class="form-select" style="border: 1px solid #ced4da !important;">
                                                        <option value="">Semua Tahun</option>
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">
                                                        <i class="fas fa-medal me-1"></i>Medali
                                                    </label>
                                                    <select id="filter-medali" class="form-select" style="border: 1px solid #ced4da !important;">
                                                        <option value="">Semua Medali</option>
                                                        <option value="Emas"
                                                            <?php echo e(request('medali') == 'Emas' ? 'selected' : ''); ?>>Emas
                                                        </option>
                                                        <option value="Perak"
                                                            <?php echo e(request('medali') == 'Perak' ? 'selected' : ''); ?>>Perak
                                                        </option>
                                                        <option value="Perunggu"
                                                            <?php echo e(request('medali') == 'Perunggu' ? 'selected' : ''); ?>>Perunggu
                                                        </option>
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">
                                                        <i class="fas fa-layer-group me-1"></i>Tingkat
                                                    </label>
                                                    <select id="filter-tingkat" class="form-select" style="border: 1px solid #ced4da !important;">
                                                        <option value="">Semua Tingkat</option>
                                                        <option value="Nasional"
                                                            <?php echo e(request('tingkat') == 'Nasional' ? 'selected' : ''); ?>>
                                                            Nasional</option>
                                                        <option value="Regional"
                                                            <?php echo e(request('tingkat') == 'Regional' ? 'selected' : ''); ?>>
                                                            Regional</option>
                                                        <option value="Provinsi"
                                                            <?php echo e(request('tingkat') == 'Provinsi' ? 'selected' : ''); ?>>
                                                            Provinsi</option>
                                                        <option value="Kota/Kabupaten"
                                                            <?php echo e(request('tingkat') == 'Kota/Kabupaten' ? 'selected' : ''); ?>>
                                                            Kota/Kabupaten</option>
                                                    </select>
                                                </div>

                                                <div class="d-flex gap-2">
                                                    <button type="button" id="apply-filters"
                                                        class="btn btn-primary btn-sm flex-fill" style="border: 1px solid #0d6efd !important;">
                                                        <i class="fas fa-check"></i> Terapkan
                                                    </button>
                                                    <button type="button" id="reset-filters"
                                                        class="btn btn-light btn-sm flex-fill" style="border: 1px solid #6c757d !important;">
                                                        <i class="fas fa-redo"></i> Reset
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php if(!(isset($prestasis) && $prestasis->isEmpty())): ?>
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <div id="filter-info" class="text-muted">
                                            Menampilkan <span
                                                id="showing-count"><?php echo e(isset($prestasis) ? $prestasis->count() : 0); ?></span>
                                            dari
                                            <span id="total-count"><?php echo e(isset($prestasis) ? $prestasis->total() : 0); ?></span>
                                            prestasi
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="table-container">


                                <div id="prestasi-table-container">
                                    <?php echo $__env->make('admin.prestasi._table', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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
    <?php if(isset($prestasis) && $prestasis->isNotEmpty()): ?>
        <script>
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function loadTable(url) {
        $.ajax({
            url: url,
            type: 'GET',
            beforeSend: function() {
                $('#prestasi-table-container').html(
                    '<div class="text-center py-5">' +
                    '<div class="spinner-border text-primary" role="status">' +
                    '<span class="visually-hidden">Loading...</span>' +
                    '</div></div>'
                );
            },
            success: function(response) {
                $('#prestasi-table-container').html(response);
                updateFilterInfo();
                bindEvents();
                updateSortingIcons();
            },
            error: function(xhr) {
                console.error('Error:', xhr.responseText);
                Swal.fire({
                    title: 'Error!',
                    text: 'Gagal memuat data. Silakan coba lagi.',
                    icon: 'error'
                });
            }
        });
    }

    function updateFilterBadge() {
        // Hanya hitung filter dropdown, BUKAN search field
        const activeFilters = [
            $('#filter-tahun').val(),
            $('#filter-medali').val(),
            $('#filter-tingkat').val()
        ].filter(val => val && val.trim() !== '').length;

        const badge = $('#filter-count');
        if (activeFilters > 0) {
            badge.text(activeFilters).removeClass('d-none');
        } else {
            badge.addClass('d-none');
        }
    }

    function bindEvents() {
        $(document).off('click', '.pagination-link')
            .on('click', '.pagination-link', function(e) {
                e.preventDefault();
                const url = $(this).attr('href');
                if (url && url !== '#') {
                    loadTable(url);
                    window.history.pushState({}, '', url);
                }
            });

        $(document).off('change', 'select[name="per_page"]')
            .on('change', 'select[name="per_page"]', function() {
                const url = new URL(window.location.href);
                url.searchParams.set('per_page', $(this).val());
                url.searchParams.delete('page');
                loadTable(url.toString());
                window.history.pushState({}, '', url.toString());
            });

        $(document).off('click', '.sort-link')
            .on('click', '.sort-link', function(e) {
                e.preventDefault();
                const url = $(this).attr('href');
                if (url && url !== '#') {
                    loadTable(url);
                    window.history.pushState({}, '', url);
                }
            });

        $(document).off('change', '#filter-tahun, #filter-medali, #filter-tingkat')
            .on('change', '#filter-tahun, #filter-medali, #filter-tingkat', function() {
                updateFilterBadge();
            });

        $(document).off('click', '#apply-filters, #reset-filters')
            .on('click', '#apply-filters, #reset-filters', function() {
                const isReset = this.id === 'reset-filters';
                const urlParams = new URLSearchParams(window.location.search);
                const currentSortBy = urlParams.get('sort_by');
                const currentOrder = urlParams.get('order');

                if (isReset) {
                    $('#filter-tahun, #filter-medali, #filter-tingkat').val('');
                }

                const params = new URLSearchParams();

                if (currentSortBy) params.set('sort_by', currentSortBy);
                if (currentOrder) params.set('order', currentOrder);

                const add = (key, val) => {
                    if (val && val.trim() !== '') {
                        params.set(key, val);
                    }
                };

                add('search', $('#search').val());
                add('tahun', $('#filter-tahun').val());
                add('medali', $('#filter-medali').val());
                add('tingkat', $('#filter-tingkat').val());
                add('per_page', $('select[name="per_page"]').val() || '10');

                const url = new URL(window.location.href);
                url.search = params.toString();

                loadTable(url.toString());
                window.history.pushState({}, '', url.toString());

                // Update badge setelah apply/reset
                updateFilterBadge();

                $('.dropdown-toggle').dropdown('hide');
            });

        let searchTimeout;
        $(document).off('input', '#search')
            .on('input', '#search', function() {
                clearTimeout(searchTimeout);
                const searchTerm = $(this).val();

                searchTimeout = setTimeout(() => {
                    const url = new URL(window.location.href);
                    const urlParams = new URLSearchParams(url.search);
                    const currentSortBy = urlParams.get('sort_by');
                    const currentOrder = urlParams.get('order');

                    if (searchTerm.trim()) {
                        url.searchParams.set('search', searchTerm);
                    } else {
                        url.searchParams.delete('search');
                    }

                    if (currentSortBy) url.searchParams.set('sort_by', currentSortBy);
                    if (currentOrder) url.searchParams.set('order', currentOrder);

                    url.searchParams.delete('page');

                    loadTable(url.toString());
                    window.history.pushState({}, '', url.toString());
                }, 300);
            });

        $(document).off('click', '.btn-delete')
            .on('click', '.btn-delete', function(e) {
                e.preventDefault();
                destroyItem(this);
            });
            
        // Export CSV button
        $(document).on('click', '#export-csv', function(e) {
            e.preventDefault();
            
            // Get the base export URL
            const baseUrl = $(this).attr('href');
            const url = new URL(baseUrl, window.location.origin);
            
            // Get all current parameters from the window URL
            const currentParams = new URLSearchParams(window.location.search);
            
            // Append all current filter and search params to the export URL
            currentParams.forEach((value, key) => {
                if (key !== 'page') { // Don't include pagination in export
                    url.searchParams.append(key, value);
                }
            });
            
            // Also get values directly from form elements in case they haven't been applied yet
            const search = $('#search').val();
            const filterTahun = $('#filter-tahun').val();
            const filterMedali = $('#filter-medali').val();
            const filterTingkat = $('#filter-tingkat').val();
            
            // Add form values to URL if they exist and aren't already in currentParams
            if (search && !currentParams.has('search')) {
                url.searchParams.set('search', search);
            }
            if (filterTahun && !currentParams.has('tahun')) {
                url.searchParams.set('tahun', filterTahun);
            }
            if (filterMedali && !currentParams.has('medali')) {
                url.searchParams.set('medali', filterMedali);
            }
            if (filterTingkat && !currentParams.has('tingkat')) {
                url.searchParams.set('tingkat', filterTingkat);
            }
            
            // Add current sorting parameters
            const sortBy = new URLSearchParams(window.location.search).get('sort_by');
            const order = new URLSearchParams(window.location.search).get('order');
            
            if (sortBy) {
                url.searchParams.set('sort_by', sortBy);
            }
            if (order) {
                url.searchParams.set('order', order);
            }
            
            // Show a brief loading indication
            const originalText = $(this).html();
            $(this).html('<i class="fas fa-spinner fa-spin me-1"></i> Exporting...');
            $(this).prop('disabled', true);
            
            // Navigate to the export URL
            window.location.href = url.toString();
            
            // Reset button after a short delay (since page might redirect)
            setTimeout(() => {
                $(this).html(originalText);
                $(this).prop('disabled', false);
            }, 2000);
        });

        updateFilterBadge();
    }

    function updateFilterInfo() {
        const tableContainer = $('#prestasi-table-container');
        const rows = tableContainer.find('tbody tr:not(:has(td[colspan]))').length;
        $('#showing-count').text(rows);
        $('#total-count').text(tableContainer.find('.pagination-info').data('total') || rows);
    }

    function updateSortingIcons() {
        const urlParams = new URLSearchParams(window.location.search);
        const sortBy = urlParams.get('sort_by');
        const order = urlParams.get('order');

        $('.sort-link i').removeClass('fa-sort-up fa-sort-down').addClass('fa-sort');

        if (sortBy) {
            const sortLink = $(`.sort-link[href*="sort_by=${sortBy}"]`);
            if (sortLink.length) {
                const icon = sortLink.find('i');
                icon.removeClass('fa-sort');
                icon.addClass(order === 'asc' ? 'fa-sort-up' : 'fa-sort-down');
            }
        }
    }

    window.destroyItem = function(button) {
        const route = $(button).data('route');
        Swal.fire({
            title: "Apakah Anda Yakin?",
            html: "<p style='text-align:center'>Setelah data dihapus, Anda tidak bisa mengembalikannya!</p>",
            icon: "warning",
            showCancelButton: true,
            reverseButtons: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Hapus!',
            cancelButtonText: 'Batalkan!'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = route;
                form.innerHTML = `
                    <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                    <input type="hidden" name="_method" value="DELETE">
                `;
                document.body.appendChild(form);
                form.submit();
            } else {
                Swal.fire({
                    title: "Aksi Dibatalkan :)",
                    icon: "info",
                });
            }
        });
    };

    // PERBAIKAN UNTUK FUNGSI populateTahunDropdown - HANYA DARI DATABASE
    function populateTahunDropdown() {
        const tahunSelect = $('#filter-tahun');
        const currentTahun = new URLSearchParams(window.location.search).get('tahun');

        $.ajax({
            url: "<?php echo e(route('admin.konfigurasi.prestasi.index')); ?>",
            type: 'GET',
            data: {
                get_tahun: 1
            },
            success: function(data) {
                console.log('Response data:', data); // Debug log

                tahunSelect.empty().append('<option value="">Semua Tahun</option>');

                if (Array.isArray(data) && data.length > 0) {
                    // Sort tahun secara descending (terbaru dulu)
                    data.sort((a, b) => b - a);

                    data.forEach(function(year) {
                        const selected = year == currentTahun ? 'selected' : '';
                        tahunSelect.append(`<option value="${year}" ${selected}>${year}</option>`);
                    });
                } else {
                    console.log('Tidak ada data tahun dari database');
                }
            },
            error: function(xhr) {
                console.error('Error loading years:', xhr.responseText);
                console.log('Gagal memuat data tahun dari database');
            }
        });
    }

    // Set initial filter values dari URL parameters
    const urlParams = new URLSearchParams(window.location.search);
    $('#filter-tahun').val(urlParams.get('tahun') || '');
    $('#filter-medali').val(urlParams.get('medali') || '');
    $('#filter-tingkat').val(urlParams.get('tingkat') || '');

    window.onpopstate = function(event) {
        loadTable(window.location.href);
    };

    // Initialize
    populateTahunDropdown();
    bindEvents();
    updateFilterBadge();
    updateSortingIcons();
});
        </script>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/thur/Documents/Inotive/web-koni/resources/views/admin/prestasi/index.blade.php ENDPATH**/ ?>