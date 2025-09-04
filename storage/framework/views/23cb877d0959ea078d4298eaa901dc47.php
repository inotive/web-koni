<?php $__env->startSection('pageTitle', 'Manajemen Atlet'); ?>
<?php $__env->startSection('mainSection', 'Konfigurasi'); ?>
<?php $__env->startSection('currentSection', 'Atlet'); ?>

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
        .btn-add-pelatih {
            background: linear-gradient(135deg, #F8285A 0%, #e91e63 100%);
            border: none;
            border-radius: 8px;
            padding: 12px 24px;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(248, 40, 90, 0.3);
        }

        .btn-add-pelatih:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(248, 40, 90, 0.4);
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
            font-weight: bold !important;
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
        .table th:nth-child(3) .sort-link,
        .table th:nth-child(4) .sort-link,
        .table th:nth-child(5) .sort-link,
        .table th:nth-child(9) .sort-link,
        .table th:nth-child(10) .sort-link,
        .table th:nth-child(11) .sort-link {
            justify-content: space-between;
            text-align: left;
        }

        .table th:nth-child(1) .sort-link,
        .table th:nth-child(2) .sort-link,
        .table th:nth-child(6) .sort-link,
        .table th:nth-child(7) .sort-link,
        .table th:nth-child(8) .sort-link,
        .table th:nth-child(12) .sort-link {
            justify-content: center;
            text-align: center;
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

        /* Specific column widths */
        .table th:nth-child(1), .table td:nth-child(1) { width: 40px; text-align: center !important; }
        .table th:nth-child(2), .table td:nth-child(2) { width: 50px; text-align: center; }
        .table th:nth-child(3), .table td:nth-child(3) { width: 140px; text-align: left !important; }
        .table th:nth-child(4), .table td:nth-child(4) { width: 110px; text-align: left !important; }
        .table th:nth-child(5), .table td:nth-child(5) { width: 100px; text-align: left !important; }
        .table th:nth-child(6), .table td:nth-child(6) { width: 70px; text-align: left !important; }
        .table th:nth-child(7), .table td:nth-child(7) { width: 80px; text-align: left !important; }
        .table th:nth-child(8), .table td:nth-child(8) { width: 80px; text-align: left !important; }
        .table th:nth-child(9), .table td:nth-child(9) { width: 110px; text-align: left !important; }
        .table th:nth-child(10), .table td:nth-child(10) { width: 120px; text-align: left !important; }
        .table th:nth-child(11), .table td:nth-child(11) { width: 90px; text-align: left !important; }
        .table th:nth-child(12), .table td:nth-child(12) { width: 80px; text-align: center !important; }

        .table td:nth-child(1),
        .table td:nth-child(2),
        .table td:nth-child(6),
        .table td:nth-child(7),
        .table td:nth-child(12) {
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

            .table thead th .sort-link {
                gap: 4px;
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

    <div class="d-flex justify-content-between align-items-center flex-wrap mb-4" style="padding:10px 30px">
        <h2 class="fw-bold fs-2 mb-0 text-dark">Atlet</h2>
        <a href="<?php echo e(route('admin.konfigurasi.atlet.create')); ?>" class="btn"
            style="background-color: #F8285A !important; color: white !important; border-color: #F8285A !important; border-radius: 8px; padding: 12px 20px; font-weight: 500;">
            <i class="ki-duotone ki-plus fs-4 me-2" style="color: white !important;"></i>Tambah Atlet
        </a>
    </div>



    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                        <div class="table-header" style="border-radius: 12px 12px 0px 0px">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h3 class="mb-0 fw-semibold text-dark">Informasi Atlet</h3>

                                <div class="d-flex align-items-center gap-2 flex-wrap">
                                    <div class="input-group" style="width: 250px;">
                                        <input type="search" name="search" id="search" class="form-control"
                                            placeholder="Cari atlet...">
                                        <button class="btn btn-outline-secondary" type="button">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>

                                    <div class="dropdown">
                                        <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                            data-bs-toggle="dropdown">
                                            <i class="fas fa-filter me-1"></i> Filter
                                            <span id="filter-count" class="badge badge-circle badge-danger ms-1 d-none">0</span>
                                        </button>
                                        <div class="dropdown-menu p-3 shadow" style="min-width: 320px;">
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Cabang Olahraga</label>
                                                <select id="filter-cabor" class="form-select">
                                                    <option value="">Semua Cabor</option>
                                                    <?php if(isset($allCabor)): ?>
                                                        <?php $__currentLoopData = $allCabor; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $nama): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($nama); ?>"><?php echo e($nama); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php endif; ?>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Jenis Kelamin</label>
                                                <select id="filter-gender" class="form-select">
                                                    <option value="">Semua</option>
                                                    <option value="Laki-Laki">Laki-Laki</option>
                                                    <option value="Perempuan">Perempuan</option>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Rentang Usia</label>
                                                <select id="filter-age" class="form-select">
                                                    <option value="">Semua Usia</option>
                                                    <option value="20-30">20-30 tahun</option>
                                                    <option value="31-40">31-40 tahun</option>
                                                    <option value="41-50">41-50 tahun</option>
                                                    <option value="51-60">51-60 tahun</option>
                                                    <option value="60+">60+ tahun</option>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Status Prestasi</label>
                                                <select id="filter-prestasi" class="form-select">
                                                    <option value="">Semua</option>
                                                    <option value="ada">Ada Prestasi</option>
                                                    <option value="tidak">Tidak Ada Prestasi</option>
                                                    <option value="emas">Medali Emas</option>
                                                    <option value="perak">Medali Perak</option>
                                                    <option value="perunggu">Medali Perunggu</option>
                                                </select>
                                            </div>

                                            <div class="d-flex gap-2">
                                                <button type="button" id="apply-filters"
                                                    class="btn btn-primary btn-sm flex-fill">
                                                    <i class="fas fa-check"></i> Terapkan
                                                </button>
                                                <button type="button" id="reset-filters"
                                                    class="btn btn-light btn-sm flex-fill">
                                                    <i class="fas fa-redo"></i> Reset
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php if(!(isset($atlet) && $atlet->isEmpty())): ?>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div id="filter-info" class="text-muted">
                                        Menampilkan <span id="showing-count"><?php echo e(isset($atlet) ? $atlet->count() : 0); ?></span>
                                        dari <span id="total-count"><?php echo e(isset($atlet) ? $atlet->total() : 0); ?></span> atlet
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="table-container">
                            <?php echo $__env->make('admin.atlet._table', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <?php if(isset($atlet) && $atlet->isNotEmpty()): ?>
        <script>
        $(document).ready(function() {
            // Initialize filters from URL on page load
            initializeFiltersFromURL();
            initializeSortingFromURL();

            function loadTable(url) {
                $.ajax({
                    url: url,
                    type: 'GET',
                    beforeSend: function() {
                        $('.table-container').html(
                            '<div class="text-center py-5">' +
                            '<div class="spinner-border text-primary" role="status">' +
                            '<span class="visually-hidden">Loading...</span>' +
                            '</div></div>'
                        );
                    },
                    success: function(response) {
                        $('.table-container').html(response);
                        bindEvents();
                        updateFilterInfo(response);
                        updateURL(url);
                        // Re-sync filters and sorting after loading new content
                        syncFiltersWithURL();
                        syncSortingWithURL();
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        Swal.fire({
                            title: 'Error!',
                            text: 'Gagal memuat data atlet',
                            icon: 'error'
                        });
                    }
                });
            }

            function bindEvents() {
                // Remove all previous event bindings to prevent duplicates
                $(document).off('click.customFilter change.customFilter input.customFilter');

                // Pagination links
                $(document).on('click.customFilter', '.pagination-link', function(e) {
                    e.preventDefault();
                    const url = $(this).attr('href');
                    if (url) loadTable(url);
                });

                // Per page selector
                $(document).on('change.customFilter', 'select[name="per_page"]', function() {
                    const url = buildURL();
                    url.searchParams.set('per_page', $(this).val());
                    url.searchParams.delete('page');
                    loadTable(url.toString());
                });

                // Sorting links - FIXED VERSION
                $(document).on('click.customFilter', '.sortable, .sort-link', function(e) {
                    e.preventDefault();

                    const sortBy = $(this).data('sort');
                    const url = buildURL();

                    // Get current sorting from URL parameters
                    const currentSortBy = url.searchParams.get('sort_by');
                    const currentOrder = url.searchParams.get('order');

                    let newOrder;

                    if (currentSortBy === sortBy) {
                        // Same column clicked - cycle through: asc -> desc -> no sort
                        if (currentOrder === 'asc') {
                            newOrder = 'desc';
                        } else if (currentOrder === 'desc') {
                            // Remove sorting (back to default)
                            url.searchParams.delete('sort_by');
                            url.searchParams.delete('order');
                            url.searchParams.delete('page');

                            // Update visual indicators
                            updateSortingVisuals();

                            loadTable(url.toString());
                            return;
                        } else {
                            newOrder = 'asc';
                        }
                    } else {
                        // Different column clicked - start with asc
                        newOrder = 'asc';
                    }

                    // Set new sorting parameters
                    url.searchParams.set('sort_by', sortBy);
                    url.searchParams.set('order', newOrder);
                    url.searchParams.delete('page');

                    // Update visual indicators immediately
                    updateSortingVisuals(sortBy, newOrder);

                    loadTable(url.toString());
                });

                // Filter buttons
                $(document).on('click.customFilter', '#apply-filters', function() {
                    applyFilters();
                });

                $(document).on('click.customFilter', '#reset-filters', function() {
                    resetFilters();
                });

                $(document).on('click.customFilter', '#reset-all-filters', function() {
                    resetFilters();
                });

                // Search input with debounce
                let searchTimeout;
                $(document).on('input.customFilter', '#search', function() {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(() => {
                        applyFilters();
                    }, 300);
                });

                // Quick filters
                $(document).on('click.customFilter', '.quick-filter', function(e) {
                    e.preventDefault();
                    const filterType = $(this).data('filter-type');
                    const filterValue = $(this).data('filter-value');

                    $(`#filter-${filterType}`).val(filterValue);
                    applyFilters();
                });

                // Update filter badge when dropdowns change
                $(document).on('change.customFilter', '#filter-cabor, #filter-gender, #filter-age, #filter-prestasi, #filter-ketersediaan', function() {
                    updateFilterBadge();
                });

                updateFilterBadge();
            }

            function applyFilters() {
                const url = buildURL();

                // Get all filter values
                const search = $('#search').val().trim();
                const cabor = $('#filter-cabor').val();
                const gender = $('#filter-gender').val();
                const age = $('#filter-age').val();
                const prestasi = $('#filter-prestasi').val();
                const ketersediaan = $('#filter-ketersediaan').val();

                // Set or remove search parameter
                if (search) {
                    url.searchParams.set('search', search);
                } else {
                    url.searchParams.delete('search');
                }

                // Set or remove filter parameters
                if (cabor) {
                    url.searchParams.set('filter_cabor', cabor);
                } else {
                    url.searchParams.delete('filter_cabor');
                }

                if (gender) {
                    url.searchParams.set('filter_gender', gender);
                } else {
                    url.searchParams.delete('filter_gender');
                }

                if (age) {
                    url.searchParams.set('filter_age', age);
                } else {
                    url.searchParams.delete('filter_age');
                }

                if (prestasi) {
                    url.searchParams.set('filter_prestasi', prestasi);
                } else {
                    url.searchParams.delete('filter_prestasi');
                }

                if (ketersediaan) {
                    url.searchParams.set('filter_ketersediaan', ketersediaan);
                } else {
                    url.searchParams.delete('filter_ketersediaan');
                }

                // Reset to first page when applying filters
                url.searchParams.delete('page');

                // Preserve per_page setting
                const perPage = $('select[name="per_page"]').val();
                if (perPage && perPage !== '10') {
                    url.searchParams.set('per_page', perPage);
                }

                // Close dropdown
                $('.dropdown-toggle').dropdown('hide');

                // Load filtered results
                loadTable(url.toString());
            }

            function resetFilters() {
                // Clear all form inputs
                $('#search').val('');
                $('#filter-cabor').val('');
                $('#filter-gender').val('');
                $('#filter-age').val('');
                $('#filter-prestasi').val('');
                $('#filter-ketersediaan').val('');

                // Build clean URL (preserve only per_page if different from default)
                const url = new URL(window.location.origin + window.location.pathname);
                const perPage = $('select[name="per_page"]').val();
                if (perPage && perPage !== '10') {
                    url.searchParams.set('per_page', perPage);
                }

                // Close dropdown
                $('.dropdown-toggle').dropdown('hide');

                // Update filter badge
                updateFilterBadge();

                // Load clean results
                loadTable(url.toString());
            }

            function buildURL() {
                return new URL(window.location.href);
            }

            function initializeFiltersFromURL() {
                const urlParams = new URLSearchParams(window.location.search);

                // Set form values from URL parameters
                $('#search').val(urlParams.get('search') || '');
                $('#filter-cabor').val(urlParams.get('filter_cabor') || '');
                $('#filter-gender').val(urlParams.get('filter_gender') || '');
                $('#filter-age').val(urlParams.get('filter_age') || '');
                $('#filter-prestasi').val(urlParams.get('filter_prestasi') || '');
                $('#filter-ketersediaan').val(urlParams.get('filter_ketersediaan') || '');
                $('select[name="per_page"]').val(urlParams.get('per_page') || '10');

                updateFilterBadge();
            }

            function initializeSortingFromURL() {
                const urlParams = new URLSearchParams(window.location.search);
                const sortBy = urlParams.get('sort_by');
                const order = urlParams.get('order');

                updateSortingVisuals(sortBy, order);
            }

            function syncFiltersWithURL() {
                const urlParams = new URLSearchParams(window.location.search);

                // Sync all filter elements with current URL
                $('#search').val(urlParams.get('search') || '');
                $('#filter-cabor').val(urlParams.get('filter_cabor') || '');
                $('#filter-gender').val(urlParams.get('filter_gender') || '');
                $('#filter-age').val(urlParams.get('filter_age') || '');
                $('#filter-prestasi').val(urlParams.get('filter_prestasi') || '');
                $('#filter-ketersediaan').val(urlParams.get('filter_ketersediaan') || '');

                // Sync per_page selector
                const perPage = urlParams.get('per_page') || '10';
                $('select[name="per_page"]').val(perPage);

                updateFilterBadge();
            }

            function syncSortingWithURL() {
                const urlParams = new URLSearchParams(window.location.search);
                const sortBy = urlParams.get('sort_by');
                const order = urlParams.get('order');

                updateSortingVisuals(sortBy, order);
            }

            function updateSortingVisuals(activeSortBy = null, activeOrder = null) {
                // Reset all sort indicators
                $('.sort-link').each(function() {
                    const $link = $(this);
                    const $icon = $link.find('i');
                    const sortBy = $link.data('sort');

                    // Update data-order for next click
                    if (sortBy === activeSortBy) {
                        $link.data('order', activeOrder);

                        // Update icon based on current state
                        if (activeOrder === 'asc') {
                            $icon.removeClass('fa-sort fa-sort-down text-muted').addClass('fa-sort-up');
                        } else if (activeOrder === 'desc') {
                            $icon.removeClass('fa-sort fa-sort-up text-muted').addClass('fa-sort-down');
                        } else {
                            $icon.removeClass('fa-sort-up fa-sort-down').addClass('fa-sort text-muted');
                        }
                    } else {
                        // Reset other columns
                        $link.data('order', 'asc');
                        $icon.removeClass('fa-sort-up fa-sort-down').addClass('fa-sort text-muted');
                    }
                });
            }

            function updateFilterBadge() {
                const activeFilters = [
                    $('#filter-cabor').val(),
                    $('#filter-gender').val(),
                    $('#filter-age').val(),
                    $('#filter-prestasi').val(),
                    $('#filter-ketersediaan').val()
                ].filter(val => val && val.length > 0).length;

                const badge = $('#filter-count');
                if (activeFilters > 0) {
                    badge.text(activeFilters).removeClass('d-none');
                } else {
                    badge.addClass('d-none');
                }
            }

            function updateFilterInfo(response) {
                try {
                    const tempDiv = $('<div>').html(response);
                    const showingInfo = tempDiv.find('#filter-info, .showing-info').text();
                    if (showingInfo) {
                        $('#filter-info, .showing-info').text(showingInfo);
                    }
                } catch (e) {
                    console.log('Could not update filter info');
                }
            }

            function updateURL(url) {
                if (window.history && window.history.pushState) {
                    window.history.pushState({}, '', url);
                }
            }

            // Handle browser back/forward buttons
            window.onpopstate = function() {
                syncFiltersWithURL();
                syncSortingWithURL();
                loadTable(window.location.href);
            };

            // Initialize event bindings
            bindEvents();

            // Keyboard shortcuts
            $(document).keydown(function(e) {
                if ((e.ctrlKey || e.metaKey) && e.keyCode === 70) { // Ctrl+F
                    e.preventDefault();
                    $('#search').focus();
                }

                if (e.keyCode === 27) { // Escape
                    $('#search').val('').trigger('input');
                }
            });

            // Delete functionality (existing code preserved)
            window.showDeleteWarning = function(button, atletName, prestasiList) {
                $('#atletName').text(atletName);

                const prestasiListElement = $('#prestasiList');
                prestasiListElement.empty();

                if (prestasiList && prestasiList.length > 0) {
                    prestasiList.forEach(function(prestasi) {
                        prestasiListElement.append(`<li>${prestasi}</li>`);
                    });
                } else {
                    prestasiListElement.append('<li>Prestasi yang terkait</li>');
                }

                $('#atletDeleteWarningModal').modal('show');
            };

            window.destroyItem = function(button) {
                const route = button.dataset.route;

                Swal.fire({
                    title: "Apakah Anda Yakin?",
                    html: "<p style='text-align:center'>Setelah data atlet dihapus, Anda tidak bisa mengembalikannya!</p>",
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
                            willOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        $.ajax({
                            url: route,
                            type: 'DELETE',
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content') || '<?php echo e(csrf_token()); ?>'
                            },
                            success: function(response) {
                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: response.message || 'Data atlet berhasil dihapus',
                                    icon: 'success',
                                    timer: 2000,
                                    showConfirmButton: false
                                });

                                loadTable(window.location.href);
                            },
                            error: function(xhr) {
                                Swal.close();

                                try {
                                    const response = JSON.parse(xhr.responseText);

                                    if (response.reason === 'has_prestasis') {
                                        Swal.fire({
                                            title: 'Tidak Dapat Menghapus Atlet',
                                            html: `Atlet <strong>${response.atlet_name}</strong> tidak dapat dihapus karena masih memiliki ${response.prestasi_count} prestasi terkait.<br><br>
                                            <div class="text-start mt-3">
                                                <strong>Prestasi yang terkait:</strong>
                                                <ul class="mt-2">
                                                    ${response.prestasi_list.map(prestasi => `<li>${prestasi}</li>`).join('')}
                                                </ul>
                                            </div>
                                            <p class="text-muted mt-3">
                                                Silakan hapus semua prestasi yang terkait dengan atlet ini terlebih dahulu,
                                                atau nonaktifkan data atlet ini jika diperlukan.
                                            </p>`,
                                            icon: "warning",
                                            confirmButtonText: 'Mengerti',
                                            width: '500px'
                                        });
                                    }
                                    else if (response.reason === 'has_atlets') {
                                        Swal.fire({
                                            title: 'Tidak Dapat Menghapus Atlet',
                                            html: `Atlet <strong>${response.atlet_name}</strong> tidak dapat dihapus karena masih memiliki ${response.atlet_count} atlet terkait.<br><br>
                                            <p class="text-muted">
                                                Silakan pindahkan atau hapus atlet yang terkait dengan atlet ini terlebih dahulu,
                                                atau nonaktifkan data atlet ini jika diperlukan.
                                            </p>`,
                                            icon: "warning",
                                            confirmButtonText: 'Mengerti'
                                        });
                                    } else {
                                        Swal.fire({
                                            title: 'Error!',
                                            text: response.message || 'Gagal menghapus data atlet',
                                            icon: 'error'
                                        });
                                    }
                                } catch (e) {
                                    Swal.fire({
                                        title: 'Error!',
                                        text: 'Gagal menghapus data atlet',
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
        });
        </script>
    <?php endif; ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\ThinkPad\OneDrive\Dokumen\GitHub\web-koni\resources\views/admin/atlet/index.blade.php ENDPATH**/ ?>