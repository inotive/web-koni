<?php if($files->isEmpty()): ?>
    <div class="text-center text-muted py-10">
        <div class="d-flex flex-column align-items-center gap-3">
            <svg width="64" height="64" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="32" cy="32" r="32" fill="#F8F9FA" />
                <path
                    d="M32 20C25.3726 20 20 25.3726 20 32C20 38.6274 25.3726 44 32 44C38.6274 44 44 38.6274 44 32C44 25.3726 38.6274 20 32 20ZM32 22C37.5467 22 42 26.4533 42 32C42 37.5467 37.5467 42 32 42C26.4533 42 22 37.5467 22 32C22 26.4533 26.4533 22 32 22Z"
                    fill="#6C7B7F" />
                <path d="M30 28V36H34V28H30ZM30 24V27H34V24H30Z" fill="#6C7B7F" />
            </svg>
            <div class="text-center">
                <div class="fw-bold text-gray-800 mb-1">
                    <?php if(request('search') || request('year')): ?>
                        Tidak ada file yang sesuai dengan pencarian/filter
                    <?php else: ?>
                        Belum ada file
                    <?php endif; ?>
                </div>
                <div class="text-muted">
                    <?php if(request('search') || request('year')): ?>
                        Coba ubah kata kunci pencarian atau filter yang Anda gunakan
                    <?php else: ?>
                        Klik tombol "Tambah File" untuk menambah file baru
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead>
                <tr class="fw-bold text-uppercase text-muted">
                    <th class="bg-light px-6 text-center" style="width: 60px;">No</th>
                    <th class="bg-light px-6 sortable" data-sort="nama_dokumen" style="cursor: pointer;">
                        <div class="d-flex align-items-center justify-content-center gap-2">
                            <span>Nama Dokumen</span>
                            <div class="sort-icon">
                                <?php if(request('sort_by') == 'nama_dokumen'): ?>
                                    <?php if(request('order') == 'asc'): ?>
                                        <i class="fas fa-sort-up text-primary"></i>
                                    <?php else: ?>
                                        <i class="fas fa-sort-down text-primary"></i>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <i class="fas fa-sort text-muted"></i>
                                <?php endif; ?>
                            </div>
                        </div>
                    </th>
                    <th class="bg-light text-start px-6 sortable" data-sort="dokumen_file" style="cursor: pointer;">
                        <div class="d-flex align-items-center justify-content-start gap-2">
                            <span>File Dokumen</span>
                            <div class="sort-icon">
                                <?php if(request('sort_by') == 'dokumen_file'): ?>
                                    <?php if(request('order') == 'asc'): ?>
                                        <i class="fas fa-sort-up text-primary"></i>
                                    <?php else: ?>
                                        <i class="fas fa-sort-down text-primary"></i>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <i class="fas fa-sort text-muted"></i>
                                <?php endif; ?>
                            </div>
                        </div>
                    </th>
                    <th class="bg-light px-6 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="border-bottom">
                <?php $__empty_1 = true; $__currentLoopData = $files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        // Calculate row number correctly for pagination
                        $rowNumber = method_exists($files, 'firstItem') ? $files->firstItem() + $index : $index + 1;
                    ?>
                    <tr data-id="<?php echo e($file->id); ?>" style="position: relative;">
                        <td class="text-center fw-bold px-2"><?php echo e($rowNumber); ?></td>
                        <td class="fw-bold px-6">
                            <div class="d-flex flex-column">
                                <div><?php echo e($file->nama_dokumen); ?></div>
                                <small class="text-muted">
                                    <?php echo e(optional($file->tanggal_dokumen)->format('d M Y')); ?>

                                </small>
                            </div>
                        </td>
                        <td class="px-6 text-start">
                            <?php if($file->dokumen_file): ?>
                                <?php
                                    $fileName = basename($file->dokumen_file);
                                    $fileExtension = strtolower(pathinfo($file->dokumen_file, PATHINFO_EXTENSION));

                                    // Memisahkan timestamp dari nama file
                                    $parts = explode('_', $fileName, 2);
                                    $displayName = count($parts) > 1 ? $parts[1] : $fileName;

                                    // Gunakan path yang sudah dikonfirmasi bekerja
                                    $filePath = 'documents/' . $file->dokumen_file;
                                    $fileUrl = asset('storage/' . $filePath);
                                ?>
                                <div class="document-link-container">
                                    <a href="<?php echo e($fileUrl); ?>" target="_blank" class="document-link"
                                        title="Klik untuk melihat <?php echo e($fileName); ?>">
                                        <?php if($fileExtension === 'pdf'): ?>
                                            <i class="fas fa-file-pdf me-2"></i>
                                        <?php elseif(in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif'])): ?>
                                            <i class="fas fa-file-image me-2"></i>
                                        <?php else: ?>
                                            <i class="fas fa-file-alt me-2"></i>
                                        <?php endif; ?>
                                        <span class="document-link-text"><?php echo e($displayName); ?></span>
                                    </a>
                                </div>
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-2 text-center">
                            <div class="dropdown dropdown-action" data-row-id="<?php echo e($file->id); ?>">
                                <button class="btn btn-sm p-0 dropdown-toggle-custom" type="button">
                                    <svg width="32" height="32" viewBox="0 0 32 32" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <rect width="32" height="32" rx="6" fill="#EFF6FF" />
                                        <rect x="0.5" y="0.5" width="31" height="31" rx="5.5"
                                            stroke="#1B84FF" stroke-opacity="0.2" />
                                        <g clip-path="url(#clip0_2223_4269)">
                                            <path opacity="0.3"
                                                d="M19.4266 7.9375H12.5734C10.0131 7.9375 7.9375 10.0131 7.9375 12.5734V19.4266C7.9375 21.9869 10.0131 24.0625 12.5734 24.0625H19.4266C21.9869 24.0625 24.0625 21.9869 24.0625 19.4266V12.5734C24.0625 10.0131 21.9869 7.9375 19.4266 7.9375Z"
                                                fill="#1B84FF" />
                                            <path
                                                d="M12.251 14.8232C12.8475 14.8233 13.331 15.3067 13.3311 15.9033C13.3311 16.4999 12.8476 16.9833 12.251 16.9834C11.6543 16.9834 11.1709 16.5 11.1709 15.9033C11.1709 15.3067 11.6543 14.8232 12.251 14.8232ZM16.2979 14.8232C16.8945 14.8232 17.3789 15.3066 17.3789 15.9033C17.3789 16.5 16.8945 16.9834 16.2979 16.9834C15.7013 16.9832 15.2178 16.4999 15.2178 15.9033C15.2178 15.3067 15.7013 14.8234 16.2979 14.8232ZM20.3369 14.8232C20.9336 14.8232 21.418 15.3066 21.418 15.9033C21.418 16.5 20.9336 16.9834 20.3369 16.9834C19.7404 16.9832 19.2568 16.4999 19.2568 15.9033C19.2568 15.3068 19.7404 14.8234 20.3369 14.8232Z"
                                                fill="#1B84FF" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_2223_4269">
                                                <rect width="18" height="18" fill="white"
                                                    transform="translate(7 7)" />
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-custom">
                                    <li class="dropdown-item edit"
                                        onclick="openEditModal(<?php echo e($file->id); ?>, '<?php echo e(addslashes($file->nama_dokumen)); ?>', '<?php echo e(optional($file->tanggal_dokumen)->format('Y-m-d')); ?>', '<?php echo e(basename($file->dokumen_file) ?? ''); ?>')">
                                        <i class="ki-outline ki-pencil me-2"></i>Edit File
                                    </li>
                                    <li class="dropdown-item delete"
                                        onclick="deleteFile('<?php echo e($file->id); ?>', '<?php echo e($file->nama_dokumen); ?>', '<?php echo e(route('admin.file-kesekretariat.destroy', $file)); ?>')">
                                        <i class="ki-outline ki-trash me-2"></i>Hapus
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td class="fw-bold p-6 text-center" colspan="4">
                            <div class="d-flex flex-column align-items-center gap-3">
                                <svg width="64" height="64" viewBox="0 0 64 64" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="32" cy="32" r="32" fill="#F8F9FA" />
                                    <path
                                        d="M32 20C25.3726 20 20 25.3726 20 32C20 38.6274 25.3726 44 32 44C38.6274 44 44 38.6274 44 32C44 25.3726 38.6274 20 32 20ZM32 22C37.5467 22 42 26.4533 42 32C42 37.5467 37.5467 42 32 42C26.4533 42 22 37.5467 22 32C22 26.4533 26.4533 22 32 22Z"
                                        fill="#6C7B7F" />
                                    <path d="M30 28V36H34V28H30ZM30 24V27H34V24H30Z" fill="#6C7B7F" />
                                </svg>
                                <div class="text-center">
                                    <div class="fw-bold text-gray-800 mb-1">
                                        <?php if(request('search') || request('year')): ?>
                                            Tidak ada file yang sesuai dengan pencarian/filter
                                        <?php else: ?>
                                            Belum ada file
                                        <?php endif; ?>
                                    </div>
                                    <div class="text-muted">
                                        <?php if(request('search') || request('year')): ?>
                                            Coba ubah kata kunci pencarian atau filter yang Anda gunakan
                                        <?php else: ?>
                                            Klik tombol "Tambah File" untuk menambah file baru
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

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

        <?php if(isset($files) && method_exists($files, 'hasPages') && $files->hasPages()): ?>
            <div class="d-flex align-items-center gap-3">
                <div class="text-muted small">
                    <?php echo e($files->firstItem()); ?>-<?php echo e($files->lastItem()); ?> of <?php echo e($files->total()); ?>

                </div>

                <div class="d-flex align-items-center gap-2">
                    <?php if($files->onFirstPage()): ?>
                        <span class="pagination-arrow disabled">←</span>
                    <?php else: ?>
                        <a href="<?php echo e($files->appends(request()->query())->previousPageUrl()); ?>"
                            class="pagination-arrow pagination-link" aria-label="Previous">←</a>
                    <?php endif; ?>

                    <?php
                        $current = $files->currentPage();
                        $total = $files->lastPage();
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
                                <a href="<?php echo e($files->appends(request()->query())->url($i)); ?>"
                                    class="pagination-number pagination-link"><?php echo e($i); ?></a>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </div>

                    <?php if($files->hasMorePages()): ?>
                        <a href="<?php echo e($files->appends(request()->query())->nextPageUrl()); ?>"
                            class="pagination-arrow pagination-link" aria-label="Next">→</a>
                    <?php else: ?>
                        <span class="pagination-arrow disabled">→</span>
                    <?php endif; ?>
                </div>
            </div>
        <?php elseif(isset($files) && method_exists($files, 'hasPages')): ?>
            <div class="text-muted small">
                1-<?php echo e($files->count()); ?> of <?php echo e($files->total()); ?>

            </div>
        <?php endif; ?>
    </div>
    </div>
<?php endif; ?>

<style>
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

    /* Document info styling */
    .document-info {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    /* Nama dokumen wrapper */
    .document-name-wrapper {
        font-weight: 600;
        color: #495057;
        cursor: default;
        user-select: text;
    }

    .document-name-wrapper i {
        margin-right: 8px;
        flex-shrink: 0;
        color: #6c757d;
    }

    .document-name-text {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        max-width: 100%;
    }

    /* Tanggal dokumen */
    .document-date {
        font-size: 12px;
        color: #6c757d !important;
        font-weight: 400;
        margin-top: 2px;
        padding-left: 0px;
        font-style: italic;
        user-select: none;
        cursor: default !important;
    }

    /* Styling untuk document link yang baru (sama seperti di surat) */
    .document-link-container {
        display: inline-block;
        max-width: 200px;
    }

    .document-link {
        color: #0d6efd !important;
        text-decoration: none !important;
        font-weight: 500;
        font-size: 0.875rem;
        display: inline-flex;
        align-items: center;
        padding: 4px 8px;
        border-radius: 4px;
        transition: all 0.2s ease;
        line-height: 1.4;
        width: 100%;
    }

    .document-link:hover {
        background-color: #e3f2fd;
        color: #1976d2 !important;
        text-decoration: underline !important;
        transform: translateY(-1px);
    }

    .document-link-text {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        flex: 1;
    }

    .document-link i {
        color: #dc3545;
        flex-shrink: 0;
    }

    .document-link i.fa-file-pdf {
        color: #dc3545;
    }

    .document-link i.fa-file-image {
        color: #28a745;
    }

    .document-link i.fa-file-alt {
        color: #28a745;
    }

    /* Sort styling */
    .sortable {
        cursor: pointer;
        position: relative;
        transition: background-color 0.2s ease;
    }

    .sortable:hover {
        background-color: #e9ecef;
    }

    .sort-icon {
        margin-left: 8px;
        color: #6c757d;
        font-size: 12px;
    }

    .sort-icon i {
        transition: color 0.2s ease;
    }

    .sortable:hover .sort-icon i {
        color: #F8285A;
    }

    /* Pagination styling */
    .pagination {
        margin: 0;
        gap: 4px;
    }

    .page-item .page-link {
        border: 1px solid #dee2e6;
        color: #6c757d;
        padding: 8px 12px;
        font-size: 0.875rem;
        border-radius: 6px;
        margin: 0;
        min-width: 40px;
        text-align: center;
        transition: all 0.2s ease;
    }

    .page-item.active .page-link {
        background-color: #F8285A;
        border-color: #F8285A;
        color: white;
    }

    .page-item:not(.disabled) .page-link:hover {
        background-color: #fff5f7;
        border-color: #F8285A;
        color: #F8285A;
    }

    .page-item.disabled .page-link {
        color: #adb5bd;
        background-color: #f8f9fa;
        border-color: #dee2e6;
    }

    /* Empty state styling */
    .empty-state {
        padding: 4rem 2rem;
        text-align: center;
        color: #6c757d;
    }

    .empty-state i {
        font-size: 4rem;
        color: #dee2e6;
        margin-bottom: 1.5rem;
    }

    .empty-state h4 {
        color: #495057;
        margin-bottom: 1rem;
        font-weight: 600;
    }

    .empty-state p {
        color: #6c757d;
        margin-bottom: 1.5rem;
    }

    /* Dropdown action styling */
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
        list-style: none;
        display: none;
    }

    .dropdown-menu-custom.show {
        display: block;
        animation: fadeIn 0.2s ease;
    }

    .dropdown-item {
        padding: 8px 16px;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        color: #495057;
        text-decoration: none;
        font-size: 0.9rem;
    }

    .dropdown-item i {
        margin-right: 8px;
        width: 20px;
        text-align: center;
    }

    .dropdown-item:hover {
        background-color: #f8f9fa;
    }

    .dropdown-item.edit:hover {
        background-color: #fff9c4 !important;
    }

    .dropdown-item.delete:hover {
        background-color: #ffebee !important;
    }

    /* Responsive design */
    @media (max-width: 768px) {

        .table th:nth-child(1),
        .table td:nth-child(1) {
            width: 5% !important;
            font-size: 0.8rem !important;
        }

        .table th:nth-child(2),
        .table td:nth-child(2) {
            width: 45% !important;
        }

        .table th:nth-child(3),
        .table td:nth-child(3) {
            width: 35% !important;
        }

        .table th:nth-child(4),
        .table td:nth-child(4) {
            width: 8% !important;
            min-width: 60px !important;
        }

        .document-name-wrapper {
            padding: 4px 6px;
            font-size: 0.875rem;
        }

        .document-date {
            font-size: 11px;
            padding-left: 20px;
        }

        .d-flex.justify-content-between {
            flex-direction: column;
            gap: 1rem;
            align-items: stretch;
        }

        .pagination {
            justify-content: center;
        }

        /* Responsive design untuk document link */
        .document-link-container {
            max-width: 150px;
        }

        .document-link {
            font-size: 0.8rem;
            padding: 2px 6px;
        }
    }

    /* Loading state */
    .table-loading {
        opacity: 0.6;
        pointer-events: none;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-5px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
<?php /**PATH C:\Users\Javier\Documents\GitHub\web-koni\resources\views/admin/file-kesekretariat/_table.blade.php ENDPATH**/ ?>