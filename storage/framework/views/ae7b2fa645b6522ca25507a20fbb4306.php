<?php if($pengajuans->isEmpty()): ?>
    
    <div class="text-center text-muted py-10">
        <i class="ki-duotone ki-information-5 fs-3x mb-3"></i>
        <h4>Tidak ada pengajuan modifikasi.</h4>
        <p>Belum ada pengajuan untuk modifikasi laporan LPJ.</p>
    </div>
<?php else: ?>
    
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle" id="kt_datatable_dom_positioning_pengajuan">
            
            <thead class="bg-light">
                <tr>
                    <th style="text-align: left">No</th>
                    <th>
                        <a href="<?php echo e(request()->fullUrlWithQuery(['sort' => 'nama_program', 'direction' => (request()->get('sort') == 'nama_program' && request()->get('direction') == 'asc') ? 'desc' : 'asc'])); ?>"
                            class="text-dark text-decoration-none sortable-header">
                            Program/Kegiatan
                            <?php if(request()->get('sort') == 'nama_program'): ?>
                                <i class="fas fa-sort-<?php echo e(request()->get('direction') == 'asc' ? 'up' : 'down'); ?>"></i>
                            <?php else: ?>
                                <i class="fas fa-sort"></i>
                            <?php endif; ?>
                        </a>
                    </th>
                    <th>
                        <a href="<?php echo e(request()->fullUrlWithQuery(['sort' => 'user', 'direction' => (request()->get('sort') == 'user' && request()->get('direction') == 'asc') ? 'desc' : 'asc'])); ?>"
                            class="text-dark text-decoration-none sortable-header">
                            Pengaju
                            <?php if(request()->get('sort') == 'user'): ?>
                                <i class="fas fa-sort-<?php echo e(request()->get('direction') == 'asc' ? 'up' : 'down'); ?>"></i>
                            <?php else: ?>
                                <i class="fas fa-sort"></i>
                            <?php endif; ?>
                        </a>
                    </th>
                    <th>Alasan Pengajuan</th>
                    <th>
                        <a href="<?php echo e(request()->fullUrlWithQuery(['sort' => 'status', 'direction' => (request()->get('sort') == 'status' && request()->get('direction') == 'asc') ? 'desc' : 'asc'])); ?>"
                            class="text-dark text-decoration-none sortable-header">
                            Status
                            <?php if(request()->get('sort') == 'status'): ?>
                                <i class="fas fa-sort-<?php echo e(request()->get('direction') == 'asc' ? 'up' : 'down'); ?>"></i>
                            <?php else: ?>
                                <i class="fas fa-sort"></i>
                            <?php endif; ?>
                        </a>
                    </th>
                    <th>
                        <a href="<?php echo e(request()->fullUrlWithQuery(['sort' => 'created_at', 'direction' => (request()->get('sort') == 'created_at' && request()->get('direction') == 'asc') ? 'desc' : 'asc'])); ?>"
                            class="text-dark text-decoration-none sortable-header">
                            Tanggal Pengajuan
                            <?php if(request()->get('sort') == 'created_at'): ?>
                                <i class="fas fa-sort-<?php echo e(request()->get('direction') == 'asc' ? 'up' : 'down'); ?>"></i>
                            <?php else: ?>
                                <i class="fas fa-sort"></i>
                            <?php endif; ?>
                        </a>
                    </th>
                    <th>
                        <a href="<?php echo e(request()->fullUrlWithQuery(['sort' => 'approved_at', 'direction' => (request()->get('sort') == 'approved_at' && request()->get('direction') == 'asc') ? 'desc' : 'asc'])); ?>"
                        class="text-dark text-decoration-none sortable-header">
                            Tanggal Disetujui
                            <?php if(request()->get('sort') == 'approved_at'): ?>
                                <i class="fas fa-sort-<?php echo e(request()->get('direction') == 'asc' ? 'up' : 'down'); ?>"></i>
                            <?php else: ?>
                                <i class="fas fa-sort"></i>
                            <?php endif; ?>
                        </a>
                    </th>
                    <th style="text-align: center">Aksi</th>
                </tr>
            </thead>

            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $pengajuans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $pengajuan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="text-center">
                            <?php echo e(($pengajuans->currentPage() - 1) * $pengajuans->perPage() + $index + 1); ?>

                        </td>
                        <td class="text-truncate-custom">
                            <div class="d-flex flex-column">
                                <?php if($pengajuan->lpj): ?>
                                    <?php
                                    $lpjRouteParams = [];

                                    if ($pengajuan->lpj->parent_id == 59) {
                                        $routeName = 'admin.laporan-lpj.sekretariat.index';
                                    } elseif ($pengajuan->lpj->parent_id == 88) {
                                        $routeName = 'admin.laporan-lpj.kegiatan-lainnya.index';
                                        } elseif ($pengajuan->lpj->parent_id == 90) {
                                        $routeName = 'admin.laporan-lpj.kegiatan-lainnya.index';
                                    } else {
                                        if ($pengajuan->lpj->parent_id) {
                                            $routeName = 'admin.laporan-lpj.bidang.dynamic.child.index';
                                            $lpjRouteParams['parentId'] = $pengajuan->lpj->parent_id;
                                        } else {
                                            $hasChildren = \App\Models\Lpj::where('parent_id', $pengajuan->lpj->id)->exists();

                                            if ($hasChildren) {
                                                $routeName = 'admin.laporan-lpj.bidang.dynamic.child.index';
                                                $lpjRouteParams['parentId'] = $pengajuan->lpj->id;
                                            } else {
                                                $routeName = 'admin.laporan-lpj.bidang.dynamic.index';
                                            }
                                        }
                                    }
                                ?>

                                    <a href="<?php echo e(route($routeName, $lpjRouteParams)); ?>"
                                       class="text-decoration-none lpj-link"
                                       data-bs-toggle="tooltip"
                                       data-bs-placement="top"
                                       title="Klik untuk melihat detail LPJ">
                                        <strong class="text-truncate-custom text-primary">
                                            <i class="fas fa-external-link-alt me-1 text-muted" style="font-size: 0.8em;"></i>
                                            <?php echo e($pengajuan->lpj->nama_program ?? 'N/A'); ?>

                                        </strong>
                                    </a>

                                    <?php if($pengajuan->lpj->nama_kegiatan): ?>
                                        <small class="text-muted mt-1" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                            <?php echo e($pengajuan->lpj->nama_kegiatan); ?>

                                        </small>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <strong class="text-truncate-custom text-danger">
                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                        LPJ Tidak Ditemukan
                                    </strong>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-user me-2 text-muted"></i>
                                <strong>
                                    <?php if($pengajuan->user): ?>
                                        <?php echo e($pengajuan->user->username); ?>

                                    <?php else: ?>
                                        <span class="text-danger">User not found</span>
                                    <?php endif; ?>
                                </strong>
                            </div>
                        </td>
                        <td>
                            <div class="text-truncate-custom"
                                 data-bs-toggle="tooltip"
                                 data-bs-placement="top"
                                 title="<?php echo e($pengajuan->alasan); ?>">
                                <?php echo e(Str::limit($pengajuan->alasan, 35)); ?>

                            </div>
                        </td>
                        <td>
                            <?php
                                $badgeClass = '';
                                $icon = '';
                                $statusText = $pengajuan->status;

                                switch ($pengajuan->status) {
                                    case 'menunggu persetujuan':
                                        $badgeClass = 'status-badge status-menunggu';
                                        $icon = '<i class="fas fa-clock me-1" style="color: #856404;"></i>';
                                        $statusText = 'Menunggu Persetujuan';
                                        break;
                                    case 'disetujui':
                                        $badgeClass = 'status-badge status-disetujui';
                                        $icon = '<i class="fas fa-check-circle me-1" style="color: #155724;"></i>';
                                        $statusText = 'Disetujui';
                                        break;
                                    case 'ditolak':
                                        $badgeClass = 'status-badge status-ditolak';
                                        $icon = '<i class="fas fa-times-circle me-1" style="color: #721c24;"></i>';
                                        $statusText = 'Ditolak';
                                        break;
                                }
                            ?>
                            <span class="<?php echo e($badgeClass); ?>"><?php echo $icon; ?><?php echo e($statusText); ?></span>
                        </td>
                        <td>
                            <div class="d-flex flex-column">
                                <span class="fw-medium"><?php echo e($pengajuan->created_at->format('d M Y')); ?></span>
                                <small class="text-muted"><?php echo e($pengajuan->created_at->format('H:i')); ?></small>
                            </div>
                        </td>
                        <td>
                            <?php if($pengajuan->status === 'disetujui' && $pengajuan->approved_at): ?>
                                <div class="d-flex flex-column cursor-pointer"
                                    data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    data-bs-html="true"
                                    title="
                                        <strong>Disetujui oleh:</strong><br>
                                        <i class='fas fa-user me-2 text-muted'></i>
                                        <?php echo e($pengajuan->approved_by ? \App\Models\User::find($pengajuan->approved_by)->username ?? 'User tidak ditemukan' : 'User tidak ditemukan'); ?><br>
                                    ">
                                    <span class="fw-medium text-success"><?php echo e($pengajuan->approved_at->format('d M Y')); ?></span>
                                    <small class="text-muted"><?php echo e($pengajuan->approved_at->format('H:i')); ?></small>
                                </div>

                            <?php elseif($pengajuan->status === 'ditolak' && $pengajuan->approved_at): ?>
                                <div class="d-flex flex-column cursor-pointer"
                                    data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    data-bs-html="true"
                                    title="
                                        <strong>Ditolak oleh:</strong><br>
                                        <i class='fas fa-user me-2 text-muted'></i>
                                        <?php echo e($pengajuan->approved_by ? \App\Models\User::find($pengajuan->approved_by)->username ?? 'User tidak ditemukan' : 'User tidak ditemukan'); ?><br>
                                    ">
                                    <span class="fw-medium text-danger"><?php echo e($pengajuan->approved_at->format('d M Y')); ?></span>
                                    <small class="text-muted text-danger"><?php echo e($pengajuan->approved_at->format('H:i')); ?></small>
                                </div>

                            <?php else: ?>
                                <small class="text-muted">-</small>
                            <?php endif; ?>

                        </td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-primary" onclick='showDetailModal(<?php echo json_encode($pengajuan, 15, 512) ?>)'>
                                <i class="fas fa-eye me-1"></i>Detail
                            </button>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">Data pengajuan tidak ditemukan</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    
    <div class="table-footer">
        <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap">
            <div class="mb-2 mb-md-0">
                <div class="d-flex align-items-center">
                    <span class="me-2">Show</span>
                    <select name="per_page" class="form-select form-select-sm w-auto">
                        <?php $__currentLoopData = [10, 25, 50, 100]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $limit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($limit); ?>"
                                <?php echo e(request('per_page', 10) == $limit ? 'selected' : ''); ?>>
                                <?php echo e($limit); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <span class="ms-2">per page</span>
                </div>
            </div>

            <?php if(isset($pengajuans) && method_exists($pengajuans, 'hasPages') && $pengajuans->hasPages()): ?>
                <div class="d-flex align-items-center gap-3">
                    <div class="text-muted small">
                        <?php echo e($pengajuans->firstItem()); ?>-<?php echo e($pengajuans->lastItem()); ?> of
                        <?php echo e($pengajuans->total()); ?>

                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <?php if($pengajuans->onFirstPage()): ?>
                            <span class="pagination-arrow disabled">←</span>
                        <?php else: ?>
                            <a href="<?php echo e($pengajuans->appends(request()->query())->previousPageUrl()); ?>"
                               class="pagination-arrow pagination-link"
                               aria-label="Previous">←</a>
                        <?php endif; ?>

                        <?php
                            $current = $pengajuans->currentPage();
                            $total = $pengajuans->lastPage();
                            $start = max(1, $current - 2);
                            $end = min($total, $current + 2);

                            if ($end - $start < 4) {
                                if ($start == 1) {
                                    $end = min($total, $start + 4);
                                } else {
                                    $start = max(1, $end - 4);
                                }
                            }
                        ?>

                        <div class="d-flex align-items-center">
                            <?php for($i = $start; $i <= $end; $i++): ?>
                                <?php if($i == $current): ?>
                                    <span class="pagination-number active"><?php echo e($i); ?></span>
                                <?php else: ?>
                                    <a href="<?php echo e($pengajuans->appends(request()->query())->url($i)); ?>"
                                       class="pagination-number pagination-link"><?php echo e($i); ?></a>
                                <?php endif; ?>
                            <?php endfor; ?>
                        </div>

                        <?php if($pengajuans->hasMorePages()): ?>
                            <a href="<?php echo e($pengajuans->appends(request()->query())->nextPageUrl()); ?>"
                               class="pagination-arrow pagination-link"
                               aria-label="Next">→</a>
                        <?php else: ?>
                            <span class="pagination-arrow disabled">→</span>
                        <?php endif; ?>
                    </div>
                </div>
            <?php elseif(isset($pengajuans) && method_exists($pengajuans, 'hasPages')): ?>
                <div class="text-muted small">
                    1-<?php echo e($pengajuans->count()); ?> of <?php echo e($pengajuans->total()); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>

    
    <style>
        .search-highlight {
            background-color: #fff3cd;
            padding: 1px 3px;
            border-radius: 3px;
            font-weight: bold;
        }

        .text-truncate-custom {
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* Enhanced LPJ Link Styling */
        .lpj-link {
            position: relative;
            transition: all 0.3s ease;
            border-radius: 4px;
            padding: 2px 0;
            display: inline-block;
        }

        .lpj-link:hover {
            text-decoration: none !important;
            transform: translateX(2px);
        }

        .lpj-link:hover strong {
            color: #0d6efd !important;
            text-shadow: 0 1px 3px rgba(13, 110, 253, 0.2);
        }

        .lpj-link:hover .fas.fa-external-link-alt {
            color: #0d6efd !important;
            transform: scale(1.1);
        }

        .lpj-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, #0d6efd, #6c5ce7);
            transition: width 0.3s ease;
        }

        /* .lpj-link:hover::after {
            width: 100%;
        } */

        /* Link icon animation */
        .lpj-link .fa-external-link-alt {
            transition: all 0.3s ease;
            opacity: 0.7;
        }

        /* Additional styling for missing LPJ indicator */
        .text-danger strong {
            font-weight: 600;
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

        /* Status Badge Styles */
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

        .custom-tooltip .tooltip-arrow::before {
            border-left-color: var(--bs-tooltip-bg);
            border-right-color: var(--bs-tooltip-bg);
        }

        .tooltip-content strong {
            color: #333333;
            font-weight: 600;
        }

        .restricted-action {
            position: relative;
        }

        .restricted-action:hover {
            background-color: transparent !important;
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

        /* Responsive styles for links */
        @media (max-width: 768px) {
            .lpj-link:hover {
                transform: none;
            }

            .lpj-link::after {
                display: none;
            }

            .text-truncate-custom {
                max-width: 150px;
            }
        }
    </style>
<?php endif; ?>
<?php /**PATH /home/thur/Documents/Inotive/web-koni/resources/views/admin/laporan-lpj/pengajuan/_table.blade.php ENDPATH**/ ?>