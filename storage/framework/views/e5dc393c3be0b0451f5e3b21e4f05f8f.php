<?php $__env->startPush('stack-css'); ?>
    <style>
        body {
            background-color: #f5f5f5;
        }

        .progress-bar span {
            font-size: 14px;
            white-space: nowrap;
            font-weight: 600;
        }

        .bar-danger {
            background-color: #FF0066;
        }

        .bar-warning {
            background-color: #FFCC00;
        }

        .bar-success {
            background-color: #17C653;
        }

        .progress {
            height: 45px;
        }

        .info-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.175);
            padding: 24px;
            transition: all 0.2s ease-in-out;
            margin-bottom: 1rem;
        }

        /* Apply info-card styling to all Bootstrap cards */
        .card {
            border-radius: 12px !important;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.175) !important;
            transition: all 0.2s ease-in-out;
        }

        .card.shadow-sm {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.175) !important;
        }

        .info-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 18px;
            margin-bottom: 12px;
        }

        .info-value {
            font-size: 20px;
            font-weight: 700;
            color: #151D48;
            margin-bottom: 4px;
        }

        .info-label {
            font-size: 14px;
            color: #A3AED0;
        }

        .dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            display: inline-block;
        }

        .title-kegiatan {
            font-size: 15px;
            font-weight: 600;
            white-space: normal;
            word-break: break-word;
            display: block;
            max-width: 220px;
        }

        .text-bronze {
            color: #CD7F32 !important;
        }

        /* Pagination Styles */
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

        /* Dropdown icon style */
        .dropdown-icon {
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 4px;
        }

        .dropdown-icon:hover {
            background-color: #e9ecef;
        }

        /* Export specific styles */
        .export-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .export-header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #dee2e6;
        }

        .export-title {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }

        .export-date {
            color: #666;
            font-size: 16px;
        }

        /* Progress bar text styles */
        .progress-bar-text {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 12px;
            pointer-events: none;
            font-size: 12px;
            font-weight: 600;
        }

        /* Tooltip styles */
        .tooltip-inner {
            background-color: #007bff;
            color: white;
            font-size: 0.8rem;
            padding: 0.25rem 0.5rem;
        }

        .tooltip.bs-tooltip-auto[data-popper-placement^=top] .tooltip-arrow::before,
        .tooltip.bs-tooltip-top .tooltip-arrow::before {
            border-top-color: #007bff;
        }

        /* Hide export button during screenshot */
        .hide-for-screenshot {
            visibility: hidden;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('pageTitle', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="mb-4">
            <div class="mb-4">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div>
                        <h2 class="fs-2 mb-1">Selamat Datang, <span class="text-danger"><?php echo e(auth()->user()->username); ?></span></h2>
                        <p class="text-muted fs-4 mb-0">Platform Digital Terpusat KONI Tabalong dan Cabang Olahraga</p>
                    </div>
                    <form method="GET" id="yearFilterForm" class="d-flex align-items-center gap-2">
                        <label for="year" class="text-muted mb-0">Tahun:</label>
                        <select name="year" class="form-select" style="width: 120px" onchange="this.form.submit()">
                            <?php if(isset($availableYears) && count($availableYears) > 0): ?>
                                <?php $__currentLoopData = $availableYears; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($year); ?>" <?php echo e((string)$year === (string)($selectedYear ?? now()->year) ? 'selected' : ''); ?>><?php echo e($year); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <option value="<?php echo e(now()->year); ?>" selected><?php echo e(now()->year); ?></option>
                            <?php endif; ?>
                        </select>
                    </form>
                </div>
            </div>
        </div>
        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <div class="info-card text-start">
                    <div class="info-icon" style="background-color: #17C653">
                        <i class="fa-solid fa-clipboard-check" style="color: white;"></i>
                    </div>
                    <div class="info-value">Rp <?php echo e(number_format($total_rka, 0, ',', '.')); ?></div>
                    <div class="info-label">Total RKA</div>
                </div>
            </div>

            <div class="col-md-6 position-relative">
                <div class="info-card text-start position-relative">
                    
                    <?php
                        $kegiatan_berjalan = $kegiatan_berjalan_all ?? $kegiatan_berjalan_count ?? 0;
                        $total_kegiatan = $kegiatan ? $kegiatan->count() : 0;
                        $persen_berjalan = $total_kegiatan > 0 ? round(($kegiatan_berjalan / $total_kegiatan) * 100) : 0;
                    ?>
                    <div class="position-absolute top-0 end-0 mt-7 me-4 d-flex flex-column align-items-end">
                          <span class="text-primary fw-semibold mt-2" style="font-size: 1.2rem;"><?php echo e($total_rka > 0 ? round(($total_serapan / $total_rka) * 100) : 0); ?>% Serapan</span>
                        <div class="progress bg-light mt-1" style="width: 100px; height: 8px;">
                            <div class="progress-bar bg-primary" style="width: <?php echo e($total_rka > 0 ? ($total_serapan / $total_rka) * 100 : 0); ?>%;"></div>
                        </div>

                        <span class="text-success fw-semibold" style="font-size: 1.2rem;"><?php echo e($persen_berjalan); ?>% Keg. Berjalan</span>
                        <div class="progress bg-light mt-1" style="width: 100px; height: 8px;">
                            <div class="progress-bar bg-success" style="width: <?php echo e($persen_berjalan); ?>%;"></div>
                        </div>
                    </div>

                    <div class="info-icon" style="background-color: #FFCC00">
                        <i class="fa-solid fa-bolt" style="color: white;"></i>
                    </div>

                    <div class="info-value">Rp <?php echo e(number_format($total_serapan, 0, ',', '.')); ?> / Rp <?php echo e(number_format($total_rka, 0, ',', '.')); ?></div>

                    <div class="info-label mt-1 d-flex align-items-center gap-2">
                        <span
                            class="badge bg-success-subtle text-success fw-semibold px-3 py-1 border border-success-subtle"><?php echo e($kegiatan_berjalan_all ?? $kegiatan_berjalan_count); ?>

                            Kegiatan Berjalan</span>
                        <span>/</span>
                        <span
                            class="badge bg-primary-subtle text-primary fw-semibold px-3 py-1 border border-primary-subtle"><?php echo e($kegiatan->count()); ?>

                            Total Kegiatan</span>
                    </div>
                </div>
            </div>

        </div>

        <div class="row g-4 mb-4">
            <div class="col-md-6 col-xl-3">
                <div class="info-card text-start">
                    <div class="info-icon" style="background-color: #1B84FF">
                        <i class="fa-solid fa-basketball" style="color: white;"></i>
                    </div>
                    <div class="info-value"><?php echo e($total_cabor); ?> Cabor</div>
                    <div class="info-label">Total Cabor</div>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="info-card text-start">
                    <div class="info-icon" style="background-color: #D20A11">
                        <i class="fa-solid fa-user-check" style="color: white;"></i>
                    </div>
                    <div class="info-value"><?php echo e($total_pengurus); ?> Pengurus</div>
                    <div class="info-label">Total Pengurus KONI</div>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="info-card text-start">
                    <div class="info-icon" style="background-color: #B817C6">
                        <i class="fa-solid fa-user" style="color: white;"></i>
                    </div>
                    <div class="info-value"><?php echo e($total_pelatih); ?> Pelatih</div>
                    <div class="info-label">Total Pelatih</div>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="info-card text-start">
                    <div class="info-icon" style="background-color: #FF0066;">
                        <i class="fa-solid fa-users" style="color: white;"></i>
                    </div>
                    <div class="info-value"><?php echo e($total_atlet); ?> Atlet</div>
                    <div class="info-label">Total Atlet</div>
                </div>
            </div>
        </div>


        <div class="card shadow-sm mb-4">
            <div class="card-body" style="padding: 24px;">
                <div class="">
                    <div class="d-flex justify-content-between align-items-center mb-10">
                        <div>
                            <h5 class="card-title mb-0 f-3">Informasi Serapan Kegiatan Koni Kab.</h5>
                            <h5 class="text-danger mb-0">Tabalong <?php echo e($selectedYear ?? date('Y')); ?></h5>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="button" id="export-screenshot" class="btn btn-light-primary">
                                <i class="fa-solid fa-download me-1"></i> Export Data
                            </button>
                        </div>
                    </div>
                </div>
                <div id="informasi-kegiatan-content">

                <?php $__currentLoopData = $kegiatan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $serapan = $item->serapan ?? 0;
                        $display_serapan = $serapan;

                        // --- Budget & Target Kegiatan Calculation (Generalized) ---
                        $rka_per_kegiatan = 0;
                        $display_target_kegiatan = 0;

                        // Check if the item is a parent category with children
                        if ($item->children && $item->children->count() > 0) {
                            // This is a parent category (like Pembinaan Prestasi, Sport Science, etc.)
                            $parent_target = \App\Models\Target::where('id_lpj', $item->id)->first();

                            // Use parent's target if it exists and is filled
                            if ($parent_target && isset($parent_target->target_anggaran) && $parent_target->target_anggaran > 0) {
                                $rka_per_kegiatan = (int) $parent_target->target_anggaran;
                                $display_target_kegiatan = (int) ($parent_target->target_kegiatan ?? 0);
                            } else {
                                // If no parent budget, fall back to summing children's budgets and targets (recursively)
                                foreach ($item->children as $child_item) {
                                    $child_target_db = \App\Models\Target::where('id_lpj', $child_item->id)->first();
                                    $child_budget = 0;

                                    if ($child_target_db && isset($child_target_db->target_anggaran) && $child_target_db->target_anggaran > 0) {
                                        $child_budget = (int) $child_target_db->target_anggaran;
                                    } else {
                                        if ($child_item->children && $child_item->children->count() > 0) {
                                            foreach ($child_item->children as $grandchild_item) {
                                                $grandchild_target_db = \App\Models\Target::where('id_lpj', $grandchild_item->id)->first();
                                                if ($grandchild_target_db && isset($grandchild_target_db->target_anggaran)) {
                                                    $child_budget += (int) $grandchild_target_db->target_anggaran;
                                                }
                                            }
                                        }
                                    }
                                    $rka_per_kegiatan += $child_budget;

                                    if ($child_target_db) {
                                        $display_target_kegiatan += (int) ($child_target_db->target_kegiatan ?? 0);
                                    }
                                }
                            }
                        } else {
                            // This is a single item or a child with no further children
                            $target = \App\Models\Target::where('id_lpj', $item->id)->first();
                            if ($target) {
                                $rka_per_kegiatan = (int) ($target->target_anggaran ?? 0);
                                $display_target_kegiatan = (int) ($target->target_kegiatan ?? 0);
                            }
                        }
                        $display_budget = $rka_per_kegiatan;
                        // --- End Budget & Target Kegiatan Calculation ---

                        $persen = 0;
                        if ($display_budget > 0) {
                            $persen = round(($serapan / $display_budget) * 100);
                            $persen = min(100, $persen);
                        }

                        $barClass = 'bar-success';
                        if ($persen <= 30) {
                            $barClass = 'bar-danger';
                        } elseif ($persen <= 60) {
                            $barClass = 'bar-warning';
                        }
                    ?>
                    <div class="d-flex align-items-center mb-3 gap-3">
                        <div style="min-width: 220px; max-width: 220px;">
                            <div class="d-flex align-items-center justify-content-between">
                                <span class="title-kegiatan"><?php echo e($i + 1); ?>. <?php echo e($item->nama_program); ?>

                                    <?php if($item->children->count() > 0 && trim($item->nama_program) == 'Pembinaan Prestasi'): ?>
                                        <i class="fas fa-info-circle text-primary ms-1" data-bs-toggle="tooltip" title="Klik untuk melihat detail"></i>
                                    <?php endif; ?>
                                </span>
                                
                                <?php if($item->children->count() > 0 && trim($item->nama_program) == 'Pembinaan Prestasi'): ?>
                                    <button class="btn btn-sm p-0 border-0 dropdown-icon ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?php echo e($item->id); ?>" aria-expanded="false" aria-controls="collapse-<?php echo e($item->id); ?>">
                                        <i class="fas fa-chevron-down text-primary"></i>
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="flex-grow-1 position-relative">
                            <div class="progress w-100" style="border-radius: 8px; height: 45px;">
                                <div class="progress-bar <?php echo e($barClass); ?>"
                                    role="progressbar"
                                    style="width: <?php echo e($persen); ?>%; border-radius: 8px; opacity: 0.8;"
                                    aria-valuenow="<?php echo e($persen); ?>" aria-valuemin="0" aria-valuemax="100">
                                </div>
                                <div class="position-absolute w-100 h-100 d-flex justify-content-between align-items-center px-3" style="top: 0; left: 0; pointer-events: none;">
                                    <span class="fw-bold" style="color: #151D48; text-shadow: 0 0 2px rgba(255,255,255,0.3);">
                                        Serapan : Rp <?php echo e(number_format($display_serapan, 0, ',', '.')); ?> / Rp <?php echo e(number_format($display_budget, 0, ',', '.')); ?> | <?php echo e($item->kegiatan_berjalan_count); ?>/<?php echo e($display_target_kegiatan); ?>

                                    </span>
                                    <span class="fw-bold" style="color: #151D48; text-shadow: 0 0 2px rgba(255,255,255,0.3);"><?php echo e($persen); ?>%</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <?php if($item->children->count() > 0 && trim($item->nama_program) == 'Pembinaan Prestasi'): ?>
                        <div class="collapse" id="collapse-<?php echo e($item->id); ?>">
                            <div class="card card-body mt-2 mb-4" style="padding: 12px; border-radius: 8px;">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="mb-0">Detail Kegiatan <?php echo e($item->nama_program); ?></h6>
                                </div>
                                <?php $__currentLoopData = $item->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $j => $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $child_serapan = $child->serapan_cabor ?? 0;

                                        // --- Child (Cabor) Budget Calculation ---
                                        $child_target_db = \App\Models\Target::where('id_lpj', $child->id)->first();
                                        $child_budget = 0;

                                        if ($child_target_db && isset($child_target_db->target_anggaran) && $child_target_db->target_anggaran > 0) {
                                            $child_budget = (int) $child_target_db->target_anggaran;
                                        } else {
                                            if ($child->children && $child->children->count() > 0) {
                                                foreach ($child->children as $grandchild_item) {
                                                    $grandchild_target_db = \App\Models\Target::where('id_lpj', $grandchild_item->id)->first();
                                                    if ($grandchild_target_db && isset($grandchild_target_db->target_anggaran)) {
                                                        $child_budget += (int) $grandchild_target_db->target_anggaran;
                                                    }
                                                }
                                            }
                                        }
                                        // --- End Child Budget Calculation ---

                                        $child_persen = 0;
                                        if ($child_budget > 0) {
                                            $child_persen = round(($child_serapan / $child_budget) * 100);
                                            $child_persen = min(100, $child_persen);
                                        }

                                        $childBarClass = 'bar-success';
                                        if ($child_persen <= 30) { $childBarClass = 'bar-danger'; }
                                        elseif ($child_persen <= 60) { $childBarClass = 'bar-warning'; }
                                    ?>

                                    <div class="d-flex align-items-center mb-3 gap-3">
                                        <div style="min-width: 220px; max-width: 220px;">
                                            <span class="title-kegiatan"><?php echo e($j + 1); ?>. <?php echo e($child->nama_program); ?></span>
                                        </div>
                                        <div class="flex-grow-1 position-relative">
                                            <div class="progress w-100" style="border-radius: 8px; height: 45px;">
                                                <div class="progress-bar <?php echo e($childBarClass); ?>" role="progressbar" style="width: <?php echo e($child_persen); ?>%; border-radius: 8px; opacity: 0.8;" aria-valuenow="<?php echo e($child_persen); ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                <div class="position-absolute w-100 h-100 d-flex justify-content-between align-items-center px-3" style="top: 0; left: 0; pointer-events: none;">
                                                    <span class="fw-bold" style="color: #151D48; text-shadow: 0 0 2px rgba(255,255,255,0.3);">
                                                        Rp <?php echo e(number_format($child_serapan, 0, ',', '.')); ?> / Rp <?php echo e(number_format($child_budget, 0, ',', '.')); ?>

                                                    </span>
                                                    <span class="fw-bold" style="color: #151D48; text-shadow: 0 0 2px rgba(255,255,255,0.3);"><?php echo e($child_persen); ?>%</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    
                                    <?php if($child->children->count() > 0): ?>
                                        <div class="ms-4 mb-3">
                                            <div class="d-flex align-items-center mb-2">
                                                <h6 class="small text-muted mb-0">Folder dalam <?php echo e($child->nama_program); ?>:</h6>
                                                <button class="btn btn-sm p-0 border-0 dropdown-icon ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#folderCollapse<?php echo e($child->id); ?>" aria-expanded="false" aria-controls="folderCollapse<?php echo e($child->id); ?>">
                                                    <i class="fas fa-chevron-down text-primary"></i>
                                                </button>
                                            </div>
                                            <div class="collapse" id="folderCollapse<?php echo e($child->id); ?>">
                                                <?php $__currentLoopData = $child->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $grandchild): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php
                                                        // Grandchild serapan
                                                        $grandchild_serapan = \App\Models\Lpj::where('parent_id', $grandchild->id)
                                                            ->get()->sum(function($doc) {
                                                                return (int)($doc->jumlah_harga ?? 0);
                                                            });

                                                        // Grandchild budget
                                                        $grandchild_target_db = \App\Models\Target::where('id_lpj', $grandchild->id)->first();
                                                        $grandchild_budget = 0;
                                                        if ($grandchild_target_db && isset($grandchild_target_db->target_anggaran)) {
                                                            $grandchild_budget = (int) $grandchild_target_db->target_anggaran;
                                                        }

                                                        $grandchild_persen = 0;
                                                        if ($grandchild_budget > 0) {
                                                            $grandchild_persen = round(($grandchild_serapan / $grandchild_budget) * 100);
                                                            $grandchild_persen = min(100, $grandchild_persen);
                                                        }

                                                        $grandchildBarClass = 'bar-success';
                                                        if ($grandchild_persen <= 30) { $grandchildBarClass = 'bar-danger'; }
                                                        elseif ($grandchild_persen <= 60) { $grandchildBarClass = 'bar-warning'; }
                                                    ?>

                                                    <div class="d-flex align-items-center mb-2 gap-3">
                                                        <div style="min-width: 200px; max-width: 200px;">
                                                            <span class="small title-kegiatan"><?php echo e(chr(65 + $k)); ?>. <?php echo e($grandchild->nama_program); ?></span>
                                                        </div>
                                                        <div class="flex-grow-1 position-relative">
                                                            <div class="progress w-100" style="border-radius: 6px; height: 35px;">
                                                                <div class="progress-bar <?php echo e($grandchildBarClass); ?>" role="progressbar" style="width: <?php echo e($grandchild_persen); ?>%; border-radius: 6px; opacity: 0.8;" aria-valuenow="<?php echo e($grandchild_persen); ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                                <div class="position-absolute w-100 h-100 d-flex justify-content-between align-items-center px-2" style="top: 0; left: 0; pointer-events: none;">
                                                                    <span class="small fw-bold" style="color: #151D48; text-shadow: 0 0 1px rgba(255,255,255,0.3);">
                                                                        Rp <?php echo e(number_format($grandchild_serapan, 0, ',', '.')); ?> / Rp <?php echo e(number_format($grandchild_budget, 0, ',', '.')); ?>

                                                                    </span>
                                                                    <span class="small fw-bold" style="color: #151D48; text-shadow: 0 0 1px rgba(255,255,255,0.3);"><?php echo e($grandchild_persen); ?>%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-body" style="padding: 24px;">
                <h5 class="card-title">Informasi Pelatih & Peserta Cabor</h5>
                <div class="text-end mt-2 d-flex justify-content-end gap-3 align-items-center">
                    <div class="d-flex align-items-center gap-2">
                        <span class="dot" style="background-color: #17C653;"></span>
                        <span class="badge">Atlet</span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="dot" style="background-color: #0d6efd;"></span>
                        <span class="badge ">Pelatih</span>
                    </div>
                </div>

                <div style="max-height: 600px;">
                    <canvas id="caborChart"></canvas>
                </div>

            </div>
        </div>


        <!-- Prestasi Terbaru -->
        <div class="card shadow-sm mb-4">
            <div class="card-body" style="padding: 24px;">
                <div class="d-flex align-items-center justify-content-between mb-6">
                    <h5 class="mb-0">Prestasi Terbaru</h5>
                </div>



                                <!-- Prestasi Atlet -->
                <div>
                    <?php echo $__env->make('admin.dashboard.partials._prestasi-atlet-table', ['prestasi_list' => $latest_prestasi, 'type' => 'atlet'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>

                <div class="text-center mt-6">
                    <a href="<?php echo e(route('admin.konfigurasi.prestasi.index')); ?>" class="btn btn-primary">
                        Lihat Selengkapnya
                    </a>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('stack-script'); ?>
    <!-- html2canvas library for screenshot functionality -->
    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>

    <script>
        const ctx = document.getElementById('caborChart').getContext('2d');
        const caborData = <?php echo json_encode($cabor_chart_data, 15, 512) ?>;

        const caborChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: caborData.map(c => c.nama_cabor),
                datasets: [{
                        label: 'Pelatih',
                        data: caborData.map(c => c.pelatihs_count),
                        backgroundColor: '#0d6efd',
                        borderRadius: 4
                    },
                    {
                        label: 'Atlet',
                        data: caborData.map(c => c.atlets_count),
                        backgroundColor: '#17C653',
                        borderRadius: 4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    }
                },
                scales: {
                    x: {
                        stacked: true,
                        ticks: {
                            color: '#2c3e50',
                            font: {
                                weight: 'bold'
                            }
                        }
                    },
                    y: {
                        stacked: true,
                        beginAtZero: true,
                        ticks: {
                            stepSize: 5
                        }
                    }
                }
            }
        });

        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        // Screenshot functionality for exporting "Informasi Kegiatan" section
        document.getElementById('export-screenshot').addEventListener('click', function() {
            const targetElement = this.closest('.card'); // Capture the entire card
            const exportButton = this; // Reference to the export button

            // Hide the export button temporarily using CSS class
            exportButton.classList.add('hide-for-screenshot');

            html2canvas(targetElement, {
                scale: 2, // Higher scale for better quality
                useCORS: true,
                backgroundColor: '#ffffff'
            }).then(canvas => {
                // Restore the export button visibility
                exportButton.classList.remove('hide-for-screenshot');

                // Convert canvas to blob
                canvas.toBlob(function(blob) {
                    // Create download link
                    const link = document.createElement('a');
                    link.href = URL.createObjectURL(blob);
                    link.download = 'informasi-kegiatan-' + new Date().toISOString().slice(0, 10) + '.png';
                    link.click();
                });
            }).catch(error => {
                // Restore the export button visibility in case of error
                exportButton.classList.remove('hide-for-screenshot');
                console.error('Error capturing screenshot:', error);
                alert('Gagal mengekspor data. Silakan coba lagi.');
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Javier\Documents\GitHub\web-koni\resources\views/admin/dashboard/index.blade.php ENDPATH**/ ?>