<?php if($suratData->isEmpty()): ?>
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
                    <?php if(request('search') || request('start_date') || request('end_date')): ?>
                        Tidak ada surat yang sesuai dengan pencarian/filter
                    <?php else: ?>
                        Belum ada surat <?php echo e($tableId); ?>

                    <?php endif; ?>
                </div>
                <div class="text-muted">
                    <?php if(request('search')): ?>
                        Coba ubah kata kunci pencarian
                    <?php elseif(request('start_date') || request('end_date')): ?>
                        <?php if(request('start_date') && request('end_date')): ?>
                            Tidak ada surat antara tanggal <?php echo e(\Carbon\Carbon::parse(request('start_date'))->format('d M Y')); ?> - <?php echo e(\Carbon\Carbon::parse(request('end_date'))->format('d M Y')); ?>

                        <?php elseif(request('start_date')): ?>
                            Tidak ada surat mulai tanggal <?php echo e(\Carbon\Carbon::parse(request('start_date'))->format('d M Y')); ?>

                        <?php else: ?>
                            Tidak ada surat hingga tanggal <?php echo e(\Carbon\Carbon::parse(request('end_date'))->format('d M Y')); ?>

                        <?php endif; ?>
                        <br>Ubah rentang tanggal yang dipilih
                    <?php else: ?>
                        Klik tombol "Tambah Surat" untuk menambah surat baru
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
                    <th class="bg-light px-6">
                        <a href="#" class="text-decoration-none text-muted sort-link" data-sort="nama_kegiatan">
                            Nama Kegiatan
                            <?php if(request('sort_by') == 'nama_kegiatan'): ?>
                                <?php if(request('order') == 'asc'): ?>
                                    <i class="fas fa-sort-up text-primary"></i>
                                <?php else: ?>
                                    <i class="fas fa-sort-down text-primary"></i>
                                <?php endif; ?>
                            <?php else: ?>
                                <i class="fas fa-sort text-muted"></i>
                            <?php endif; ?>
                        </a>
                    </th>
                    <th class="bg-light text-start px-6">
                        <a href="#" class="text-decoration-none text-muted sort-link" data-sort="dokumen_surat">
                            Dokumen
                            <?php if(request('sort_by') == 'dokumen_surat'): ?>
                                <?php if(request('order') == 'asc'): ?>
                                    <i class="fas fa-sort-up text-primary"></i>
                                <?php else: ?>
                                    <i class="fas fa-sort-down text-primary"></i>
                                <?php endif; ?>
                            <?php else: ?>
                                <i class="fas fa-sort text-muted"></i>
                            <?php endif; ?>
                        </a>
                    </th>
                    <th class="bg-light text-center px-6">
                        <a href="#" class="text-decoration-none text-muted sort-link" data-sort="created_at">
                            Tanggal
                            <?php if(request('sort_by') == 'created_at'): ?>
                                <?php if(request('order') == 'asc'): ?>
                                    <i class="fas fa-sort-up text-primary"></i>
                                <?php else: ?>
                                    <i class="fas fa-sort-down text-primary"></i>
                                <?php endif; ?>
                            <?php else: ?>
                                <i class="fas fa-sort text-muted"></i>
                            <?php endif; ?>
                        </a>
                    </th>
                    <th class="bg-light px-6 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="border-bottom">
                <?php $__empty_1 = true; $__currentLoopData = $suratData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $surat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $rowNumber = method_exists($suratData, 'currentPage')
                            ? ($suratData->currentPage() - 1) * $suratData->perPage() + $index + 1
                            : $index + 1;
                    ?>
                    <tr data-jenis-surat="<?php echo e($surat->jenis_surat ?? ''); ?>" style="position: relative;">
                        <td class="text-center fw-bold px-2"><?php echo e($rowNumber); ?></td>
                        <td class="fw-bold px-6">
                            <div class="d-flex flex-column">
                                <div class="text-truncate" style="max-width: 250px;" title="<?php echo e($surat->nama_kegiatan); ?>"><?php echo e($surat->nama_kegiatan); ?></div>
                                <small class="text-muted text-truncate" style="max-width: 250px;" title="<?php echo e($surat->no_surat); ?>">
                                    <?php echo e($surat->no_surat); ?>

                                </small>
                            </div>
                        </td>
                        <td class="px-6 text-start">
                            <?php if($surat->dokumen_surat): ?>
                                <?php
                                    $fileName = basename($surat->dokumen_surat);
                                    $fileUrl = asset('storage/' . $surat->dokumen_surat);
                                    $fileExtension = pathinfo($surat->dokumen_surat, PATHINFO_EXTENSION);
                                ?>
                                <div class="document-link-container">
                                    <a href="<?php echo e($fileUrl); ?>" target="_blank" class="document-link" title="Klik untuk melihat <?php echo e($fileName); ?>">
                                        <i class="fas fa-file-<?php echo e($fileExtension == 'pdf' ? 'pdf' : 'alt'); ?> me-2"></i>
                                        <?php echo e(Str::limit($fileName, 25)); ?>

                                    </a>
                                </div>
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-2 text-center"><?php echo e(Carbon\Carbon::parse($surat->created_at)->format('d M Y')); ?></td>
                        <td class="px-2 text-center">
                            <div class="dropdown dropdown-action" data-row-id="<?php echo e($surat->id); ?>">
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
                                    <li class="dropdown-item edit" data-bs-toggle="modal"
                                        data-bs-target="#edit-<?php echo e($surat->id); ?>">
                                        <i class="ki-outline ki-pencil me-2"></i>Edit Surat
                                    </li>
                                    <li class="dropdown-item delete"
                                        onclick="deleteItem('delete-form-<?php echo e($surat->id); ?>', '<?php echo e($surat->nama_kegiatan); ?>')">
                                        <i class="ki-outline ki-trash me-2"></i>Hapus
                                    </li>
                                </ul>
                                <form id="delete-form-<?php echo e($surat->id); ?>"
                                    action="<?php echo e(route('admin.surat.destroy', $surat->id)); ?>" method="POST"
                                    style="display: none;">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                </form>
                            </div>
                        </td>
                    </tr>

                    <div class="modal fade" id="edit-<?php echo e($surat->id); ?>" tabindex="-1"
                        aria-labelledby="edit-<?php echo e($surat->id); ?>" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content rounded-4 gap-5 px-10 py-8">
                                <div class="d-flex justify-content-between align-items-center gap-2">
                                    <div class="fs-2 fw-bold text-truncate leading-5"
                                        id="editModalTitle-<?php echo e($surat->id); ?>" style="max-width: 90%;">
                                        Edit <?php echo e($surat->jenis_surat == 'masuk' ? 'Surat Masuk' : 'Surat Keluar'); ?>:
                                        <?php echo e(Str::limit($surat->nama_kegiatan, 20)); ?>

                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>

                                <div id="form-<?php echo e($surat->id); ?>"
                                    data-action="<?php echo e(route('admin.surat.update', $surat->id)); ?>" class="d-grid gap-4">
                                    <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                                    <input type="hidden" name="_method" value="PUT">

                                    <div>
                                        <div class="fw-semibold required mb-3 text-gray-800">Nama Kegiatan</div>
                                        <input type="text" name="nama_kegiatan"
                                            value="<?php echo e($surat->nama_kegiatan); ?>" placeholder="Masukkan Nama Kegiatan"
                                            class="form-control bg-light border border-gray-400" required />
                                    </div>

                                    <div>
                                        <div class="fw-semibold required mb-3 text-gray-800">Nomor Surat</div>
                                        <input type="text" name="no_surat" value="<?php echo e($surat->no_surat); ?>"
                                            placeholder="Masukkan Nomor Surat"
                                            class="form-control bg-light border border-gray-400" required />
                                    </div>

                                    <input type="hidden" name="jenis_surat" value="<?php echo e($surat->jenis_surat); ?>">

                                    <div>
                                        <div class="fw-semibold mb-3 text-gray-800">
                                            Unggah Dokumen Baru
                                            <span class="text-muted">(Opsional)</span>
                                        </div>
                                        <div class="fv-row">
                                            <div class="dropzone" id="dropzone-form-<?php echo e($surat->id); ?>">
                                                <div class="dz-message needsclick">
                                                    <i class="ki-duotone ki-file-up fs-3x text-primary">
                                                        <span class="path1"></span><span class="path2"></span>
                                                    </i>
                                                    <div class="ms-4">
                                                        <h3 class="fs-5 fw-bold mb-1 text-gray-900">Seret atau pilih
                                                            dokumen baru.</h3>
                                                        <span class="fs-7 fw-semibold text-gray-500">Format: PDF, DOC,
                                                            DOCX. Max. 10 MB. Kosongkan jika tidak ingin mengubah
                                                            file.</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <?php if($surat->dokumen_surat): ?>
                                            <div class="mt-2 p-3 bg-light rounded">
                                                <small class="text-muted">File saat ini: </small>
                                                <a href="<?php echo e(asset('storage/' . $surat->dokumen_surat)); ?>"
                                                    target="_blank" class="text-primary text-decoration-none fw-bold text-break">
                                                    <?php echo e(basename($surat->dokumen_surat)); ?>

                                                </a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="d-grid py-4">
                                    <button type="button" onclick="submitForm('form-<?php echo e($surat->id); ?>')"
                                        id="editSubmitBtn-<?php echo e($surat->id); ?>"
                                        class="bg-danger fw-bold d-flex align-items-center justify-content-center gap-2 rounded border-0 p-4 text-white">
                                        Update <?php echo e($surat->jenis_surat == 'masuk' ? 'Surat Masuk' : 'Surat Keluar'); ?>

                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td class="fw-bold p-6 text-center" colspan="5">
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
                                        <?php if(request('search') || request('start_date') || request('end_date')): ?>
                                            Tidak ada surat yang sesuai dengan pencarian/filter
                                        <?php else: ?>
                                            Belum ada surat <?php echo e($tableId); ?>

                                        <?php endif; ?>
                                    </div>
                                    <div class="text-muted">
                                        <?php if(request('search') || request('start_date') || request('end_date')): ?>
                                            Coba ubah kata kunci pencarian atau filter yang Anda gunakan
                                        <?php else: ?>
                                            Klik tombol "Tambah Surat" untuk menambah surat baru
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

            <?php if(isset($suratData) && method_exists($suratData, 'hasPages') && $suratData->hasPages()): ?>
                <div class="d-flex align-items-center gap-3">
                    <div class="text-muted small">
                        <?php echo e($suratData->firstItem()); ?>-<?php echo e($suratData->lastItem()); ?> of <?php echo e($suratData->total()); ?>

                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <?php if($suratData->onFirstPage()): ?>
                            <span class="pagination-arrow disabled">←</span>
                        <?php else: ?>
                            <a href="<?php echo e($suratData->appends(request()->query())->previousPageUrl()); ?>"
                                class="pagination-arrow pagination-link" aria-label="Previous">←</a>
                        <?php endif; ?>

                        <?php
                            $current = $suratData->currentPage();
                            $total = $suratData->lastPage();
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
                                    <a href="<?php echo e($suratData->appends(request()->query())->url($i)); ?>"
                                        class="pagination-number pagination-link"><?php echo e($i); ?></a>
                                <?php endif; ?>
                            <?php endfor; ?>
                        </div>

                        <?php if($suratData->hasMorePages()): ?>
                            <a href="<?php echo e($suratData->appends(request()->query())->nextPageUrl()); ?>"
                                class="pagination-arrow pagination-link" aria-label="Next">→</a>
                        <?php else: ?>
                            <span class="pagination-arrow disabled">→</span>
                        <?php endif; ?>
                    </div>
                </div>
            <?php elseif(isset($suratData) && method_exists($suratData, 'hasPages')): ?>
                <div class="text-muted small">
                    1-<?php echo e($suratData->count()); ?> of <?php echo e($suratData->total()); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>

<style>
    .search-highlight {
        background-color: #fff3cd;
        padding: 1px 3px;
        border-radius: 3px;
        font-weight: bold;
    }

    /* Styling untuk document link yang baru */
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
        word-break: break-all;
        line-height: 1.4;
    }

    .document-link:hover {
        background-color: #e3f2fd;
        color: #1976d2 !important;
        text-decoration: underline !important;
        transform: translateY(-1px);
    }

    .document-link i {
        color: #dc3545;
        flex-shrink: 0;
    }

    .document-link i.fa-file-pdf {
        color: #dc3545;
    }

    .document-link i.fa-file-alt {
        color: #28a745;
    }

    .sort-link {
        cursor: pointer;
        transition: color 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .sort-link:hover {
        color: #F8285A !important;
        text-decoration: none !important;
    }

    .sort-link i {
        transition: all 0.2s ease;
        font-size: 0.8rem;
        opacity: 0.7;
    }

    .sort-link:hover i {
        opacity: 1;
        transform: scale(1.1);
    }

    .sort-link i.text-primary {
        opacity: 1;
        color: #F8285A !important;
    }

    #per_page {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6,9 12,15 18,9'%3e%3c/polyline%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 8px center;
        background-size: 16px;
        padding-right: 32px !important;
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
        background-color: rgb(249, 245, 172) !important;
    }

    .dropdown-item.delete:hover {
        background-color: #ffcad7 !important;
    }

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

    .badge-success {
        background-color: #198754 !important;
    }

    .badge-primary {
        background-color: #0d6efd !important;
    }

    /* Responsive design untuk document link */
    @media (max-width: 768px) {
        .document-link-container {
            max-width: 150px;
        }

        .document-link {
            font-size: 0.8rem;
            padding: 2px 6px;
        }
    }
</style>
<?php /**PATH /home/thur/Documents/Inotive/web-koni/resources/views/admin/surat/_table.blade.php ENDPATH**/ ?>