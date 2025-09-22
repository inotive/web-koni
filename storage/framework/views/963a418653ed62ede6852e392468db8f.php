<?php $__env->startSection('pageTitle', 'Detail Pelatih'); ?>
<?php $__env->startSection('mainSection', 'Konfigurasi'); ?>
<?php $__env->startSection('subSection', 'Pelatih'); ?>
<?php $__env->startSection('subSectionUrl', route('admin.konfigurasi.pelatih.index')); ?>
<?php $__env->startSection('currentSection', 'Detail Pelatih'); ?>

<?php $__env->startSection('content'); ?>
<style>
    /* Base Layout */
    body { background-color: #f5f5f5 !important; }

    .main-content {
        background-color: #f5f5f5;
        min-height: 100vh;
        padding: 20px 10px 40px;
    }

    .detail-container {
        gap: 30px;
        width: 100%;
        max-width: 1067px;
        margin: 0 auto;
        padding: 0 20px 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
        box-sizing: border-box;
    }

    /* Cards */
    .detail-card {
        width: 100%;
        max-width: 987px;
        background: #fff;
        border: 1px solid #f1f1f4;
        border-radius: 12px;
        box-shadow: 0 3px 4px 0 rgba(0, 0, 0, 0.03);
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .detail-card-header {
        padding: 20px 30px;
        border-bottom: 1px solid #f1f1f4;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .detail-card-title {
        font-family: "Inter", sans-serif;
        font-size: 16px;
        font-weight: 600;
        color: #071437;
        margin: 0;
    }

    /* Content Rows */
    .detail-body { width: 100%; margin-bottom: 20px; }

    .detail-row {
        padding: 10px 30px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .detail-label {
        width: 220px;
        flex-shrink: 0;
    }

    .detail-label-text {
        font-family: "Inter", sans-serif;
        font-size: 14px;
        color: #78829d;
        margin: 0;
    }

    .detail-value {
        flex: 1;
        font-family: "Inter", sans-serif;
        font-size: 14px;
        color: #252f4a;
        margin: 0;
    }

    .detail-divider {
        height: 1px;
        background-color: #f1f1f4;
        margin: 5px 0;
    }

    /* Photo */
    .detail-photo-container {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        flex: 1;
    }

    .detail-photo-wrapper {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        border: 2px solid #17c653;
        overflow: hidden;
    }

    .detail-photo {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Buttons */
    .btn-secondary, .btn-light-primary, .btn-success, .btn-danger {
        padding: 13px 16px;
        border-radius: 6px;
        font-family: "Inter", sans-serif;
        font-size: 13px;
        font-weight: 500;
        text-decoration: none;
        cursor: pointer;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 10px;
    }

    .btn-secondary {
        background-color: #6b7280;
        color: #fff;
    }

    .btn-secondary:hover { background-color: #4b5563; }

    .btn-success {
        background-color: #198754;
        color: #fff;
    }

    .btn-success:hover {
        background-color: #157347;
    }

    .btn-danger {
        background-color: #dc3545;
        color: #fff;
    }

    .btn-danger:hover {
        background-color: #c82333;
    }

    .edit-icon {
        padding: 6px;
        border-radius: 50%;
        cursor: pointer;
        background: transparent;
    }

    .edit-icon:hover { background-color: #f1f1f4; }

    /* Ketersediaan Dropdown */
    .ketersediaan-dropdown {
        padding: 8px 12px;
        border: 1px solid #f1f1f4;
        border-radius: 6px;
        font-family: "Inter", sans-serif;
        font-size: 13px;
        font-weight: 500;
        min-width: 150px;
        cursor: pointer;
        outline: none;
        transition: all 0.2s ease;
    }

    .ketersediaan-dropdown[data-status="tersedia"] {
        background-color: #eafff1;
        border-color: #17c653;
        color: #04b440;
    }

    .ketersediaan-dropdown[data-status="tidak-tersedia"] {
        background-color: #fef2f2;
        border-color: #ef4444;
        color: #dc2626;
    }

    /* Achievement Table */
    .achievement-table-container {
        border: 1px solid #f1f1f4;
        border-radius: 8px;
        overflow: hidden;
        background: #fff;
    }

    .achievement-table {
        width: 100%;
        border-collapse: collapse;
    }

    .achievement-table th {
        background-color: #fcfcfc;
        color: #4b5675;
        font-size: 13px;
        font-weight: 500;
        padding: 15px 20px;
        text-align: left;
        border-bottom: 1px solid #f1f1f4;
        border-right: 1px solid #f1f1f4;
        cursor: pointer;
    }

    .achievement-table th:last-child { border-right: none; }

    .achievement-table td {
        padding: 18px 20px;
        border-bottom: 1px solid #f1f1f4;
        color: #4b5675;
        font-size: 13px;
        border-right: 1px solid #f1f1f4;
    }

    .achievement-table td:last-child { border-right: none; }
    .achievement-table tr:last-child td { border-bottom: none; }
    .achievement-table tr:hover { background-color: #fafbfc; }

    /* Medal Components */
    .medal-container {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .medal-icon {
        font-size: 18px;
        width: 20px;
        text-align: center;
    }

    .achievement-info {
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    .achievement-name {
        color: #071437;
        font-size: 14px;
        font-weight: 500;
        margin-bottom: 4px;
    }

    .achievement-meta {
        color: #78829d;
        font-size: 12px;
    }

    .text-bronze { color: #CD7F32 !important; }

    /* Empty States */
    .empty-achievement {
        text-align: center;
        padding: 60px 20px;
        color: #78829d;
    }

    .empty-value {
        color: #6b7280;
        font-style: italic;
    }

    /* Pagination */
    .table-footer {
        background-color: white;
        padding: 15px 25px;
        border-top: 1px solid #e9ecef;
        display: flex;
        justify-content: flex-end;
        align-items: center;
    }

    .compact-pagination-container {
        display: flex;
        align-items: center;
        gap: 15px;
        font-size: 14px;
        color: #6b7280;
    }

    .modern-pagination {
        display: flex;
        gap: 2px;
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .modern-pagination .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 32px;
        height: 32px;
        padding: 0 8px;
        border: 1px solid #e5e7eb;
        background: #fff;
        color: #6b7280;
        font-size: 14px;
        text-decoration: none;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.15s ease;
    }

    .modern-pagination .page-link:hover:not(.disabled) {
        background-color: #f9fafb;
        border-color: #d1d5db;
        color: #374151;
    }

    .modern-pagination .page-item.active .page-link {
        background-color: #f3f4f6;
        border-color: #d1d5db;
        color: #1f2937;
        font-weight: 500;
    }

    .modern-pagination .page-item.disabled .page-link {
        color: #d1d5db;
        cursor: not-allowed;
    }

    .pagination-arrow-prev::before { content: "←"; }
    .pagination-arrow-next::before { content: "→"; }

    /* Loading */
    .table-loading { opacity: 0.6; pointer-events: none; }
    .ketersediaan-dropdown.loading { opacity: 0.7; cursor: not-allowed; }

    /* Responsive */
    @media (max-width: 768px) {
        .detail-row {
            flex-direction: column;
            align-items: flex-start;
            gap: 5px;
        }

        .detail-label {
            width: 100%;
        }

        .detail-photo-container {
            justify-content: flex-start;
        }
    }
</style>

<div class="main-content">
    <div class="detail-container">
        <div class="detail-header">
            <h1 class="detail-title">Profil Pelatih</h1>
        </div>

        <div class="detail-card">
            <div class="detail-card-header">
                <h2 class="detail-card-title">Personal Info</h2>
                <a href="<?php echo e(route('admin.konfigurasi.pelatih.export-single-pdf', $pelatih->id)); ?>"
                       class="btn btn-outline-secondary filter-btn-custom btn-export-custom" style="border: #b0b5c3 1px solid;">
                        <i class="fas fa-file-pdf me-1"></i> Export
                    </a>
            </div>

            <div class="detail-body">
                <!-- Photo Row -->
                <div class="detail-row">
                    <div class="detail-label">
                        <p class="detail-label-text">Foto</p>
                    </div>
                    <div class="detail-photo-container">
                        <?php if($pelatih->foto): ?>
                            <div class="detail-photo-wrapper">
                                <img src="<?php echo e(asset('storage/' . $pelatih->foto)); ?>" alt="Foto Pelatih" class="detail-photo">
                            </div>
                        <?php else: ?>
                            <div class="detail-photo-wrapper">
                                <div style="width: 100%; height: 100%; background-color: #f1f1f4; display: flex; align-items: center; justify-content: center;">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"></svg>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <?php
                    $fields = [
                        ['label' => 'Nama', 'value' => $pelatih->nama],
                        ['label' => 'Cabor', 'value' => $pelatih->cabangOlahraga ? $pelatih->cabangOlahraga->nama_cabor : '-'],
                        ['label' => 'Email', 'value' => $pelatih->email ?? '-'],
                        ['label' => 'No Telepon', 'value' => $pelatih->no_telepon ?? '-'],
                        ['label' => 'Tempat Lahir', 'value' => $pelatih->tempat_lahir],
                        ['label' => 'Tanggal Lahir', 'value' => \Carbon\Carbon::parse($pelatih->tanggal_lahir)->format('d M Y')],
                        ['label' => 'Umur', 'value' => \Carbon\Carbon::parse($pelatih->tanggal_lahir)->age . ' Tahun'],
                        ['label' => 'Kelamin', 'value' => $pelatih->kelamin == 'L' ? 'Laki-laki' : 'Perempuan'],
                    ];
                ?>

                <?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="detail-divider"></div>
                    <div class="detail-row">
                        <div class="detail-label">
                            <p class="detail-label-text"><?php echo e($field['label']); ?></p>
                        </div>
                        <p class="detail-value"><?php echo e($field['value']); ?></p>
                        <div class="edit-icon">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"></svg>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <!-- Ketersediaan Row -->
                <div class="detail-divider"></div>
                <div class="detail-row">
                    <div class="detail-label">
                        <p class="detail-label-text">Ketersediaan</p>
                    </div>
                    <div class="detail-value">
                        <select name="ketersediaan" id="ketersediaanSelect" class="ketersediaan-dropdown"
                                data-status="<?php echo e(strtolower(str_replace('-', '-', $pelatih->ketersediaan))); ?>"
                                onchange="submitKetersediaanForm()">
                            <option value="Tersedia" <?php echo e($pelatih->ketersediaan == 'Tersedia' ? 'selected' : ''); ?>>Tersedia</option>
                            <option value="Tidak-Tersedia" <?php echo e($pelatih->ketersediaan == 'Tidak-Tersedia' ? 'selected' : ''); ?>>Tidak Tersedia</option>
                        </select>
                    </div>
                </div>

                <!-- Address Row -->
                <div class="detail-divider"></div>
                <div class="detail-row">
                    <div class="detail-label">
                        <p class="detail-label-text">Alamat</p>
                    </div>
                    <div class="detail-value">
                        <?php if($pelatih->alamatkota && $pelatih->alamatprovinsi): ?>
                            <div><strong><?php echo e($pelatih->alamatkota); ?>, <?php echo e($pelatih->alamatprovinsi); ?></strong></div>
                            <?php if($pelatih->alamat): ?>
                                <div style="font-size: 12px; color: #78829d; margin-top: 4px;"><?php echo e($pelatih->alamat); ?></div>
                            <?php endif; ?>
                        <?php elseif($pelatih->alamat): ?>
                            <div><?php echo e($pelatih->alamat); ?></div>
                        <?php else: ?>
                            <span class="empty-value">Belum ada alamat yang tercantum</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        

        <div class="detail-actions" style="display: flex; gap: 10px; margin-top: 20px;">
            <a href="<?php echo e(match (request('back')) {
                    'cabor'     => route('admin.konfigurasi.cabang-olahraga.show', $pelatih->cabor_id),
                    'prestasi' => route('admin.konfigurasi.prestasi.index', $pelatih->id),
                    default     => route('admin.konfigurasi.pelatih.index'),
                }); ?>" class="btn btn-light-primary">
                <i class="bi bi-arrow-left fs-2"></i> Kembali
            </a>

            
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script>
    // Ketersediaan form submission
    function submitKetersediaanForm() {
        const select = document.getElementById('ketersediaanSelect');
        const csrfToken = document.querySelector('meta[name="csrf-token"]');

        if (!csrfToken) {
            alert('CSRF token not found!');
            return;
        }

        const selectedValue = select.value;
        updateSelectStatus(select, selectedValue);

        select.classList.add('loading');
        select.disabled = true;

        const formData = new FormData();
        formData.append('_token', csrfToken.getAttribute('content'));
        formData.append('_method', 'PATCH');
        formData.append('ketersediaan', selectedValue);

        fetch('<?php echo e(route("admin.konfigurasi.pelatih.updateKetersediaan", $pelatih->id)); ?>', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                alert('Error: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(error => {
            alert('Error: ' + error.message);
        })
        .finally(() => {
            select.classList.remove('loading');
            select.disabled = false;
        });
    }

    function updateSelectStatus(selectElement, value) {
        const status = value === 'Tersedia' ? 'tersedia' : 'tidak-tersedia';
        selectElement.setAttribute('data-status', status);
    }

    // Achievement table management
    $(document).ready(function() {
        let currentSort = { column: 'created_at', direction: 'desc' };
        let currentPage = 1;
        let isLoading = false;

        function loadAchievements(page = 1) {
            if (isLoading) return;

            const container = document.getElementById('achievement-table-container');
            const tbody = document.getElementById('achievement-tbody');

            if (!container || !tbody) return;

            isLoading = true;
            container.classList.add('table-loading');

            const params = new URLSearchParams({
                page: page,
                sort_by: currentSort.column,
                order: currentSort.direction,
                per_page: 3,
                ajax: 1
            });

            fetch(`<?php echo e(route('admin.konfigurasi.pelatih.show', $pelatih->id)); ?>?${params}`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && data.prestasis) {
                    updateTable(data.prestasis, data.pagination);
                    currentPage = page;
                    updateSortIcons();
                    bindPaginationEvents();
                }
            })
            .catch(error => {
                tbody.innerHTML = `<tr><td colspan="3" class="empty-achievement">Error loading achievements</td></tr>`;
            })
            .finally(() => {
                container.classList.remove('table-loading');
                isLoading = false;
            });
        }

        function updateTable(prestasis, pagination) {
            const tbody = document.getElementById('achievement-tbody');
            const paginationInfo = document.getElementById('compact-pagination-info');

            if (!prestasis || prestasis.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="3" class="empty-achievement">
                            <i class="fas fa-trophy"></i>
                            <div>Belum ada data prestasi.</div>
                        </td>
                    </tr>
                `;
            } else {
                tbody.innerHTML = prestasis.map((prestasi, index) => {
                    const medaliType = prestasi.medali?.toLowerCase() || '';
                    const medalIcons = {
                        'emas': '<i class="fas fa-medal text-warning"></i>',
                        'perak': '<i class="fas fa-medal text-dark"></i>',
                        'perunggu': '<i class="fas fa-medal text-bronze"></i>'
                    };
                    const medalIcon = medalIcons[medaliType] || '<i class="fas fa-trophy text-muted"></i>';
                    const rowNumber = pagination?.from + index || index + 1;

                    return `
                        <tr>
                            <td>${rowNumber}</td>
                            <td>
                                <div class="medal-container">
                                    <div class="medal-icon">${medalIcon}</div>
                                    <div class="achievement-info">
                                        <div class="achievement-name">${prestasi.nama_prestasi || 'N/A'}</div>
                                        <div class="achievement-meta">${prestasi.tahun || '-'} • Medali ${prestasi.medali || 'Lainnya'}</div>
                                    </div>
                                </div>
                            </td>
                            <td style="text-align: center;">${prestasi.tempat || '-'}</td>
                        </tr>
                    `;
                }).join('');
            }

            if (paginationInfo && pagination?.total > 0) {
                paginationInfo.textContent = `${pagination.from}-${pagination.to} of ${pagination.total}`;
            }

            if (pagination?.last_page > 1) {
                updatePagination(pagination);
            }
        }

        function updatePagination(pagination) {
            const paginationParent = document.getElementById('modern-pagination');
            if (!paginationParent) return;

            let html = '';
            const current = pagination.current_page;
            const last = pagination.last_page;

            // Previous button
            html += current > 1
                ? `<li class="page-item"><button class="page-link pagination-arrow-prev" data-page="${current - 1}"></button></li>`
                : `<li class="page-item disabled"><span class="page-link pagination-arrow-prev disabled"></span></li>`;

            // Page numbers (simplified logic)
            let start = Math.max(1, current - 2);
            let end = Math.min(last, current + 2);

            for (let i = start; i <= end; i++) {
                if (i === current) {
                    html += `<li class="page-item active"><span class="page-link">${i}</span></li>`;
                } else {
                    html += `<li class="page-item"><button class="page-link" data-page="${i}">${i}</button></li>`;
                }
            }

            // Next button
            html += current < last
                ? `<li class="page-item"><button class="page-link pagination-arrow-next" data-page="${current + 1}"></button></li>`
                : `<li class="page-item disabled"><span class="page-link pagination-arrow-next disabled"></span></li>`;

            paginationParent.innerHTML = html;
        }

        function bindPaginationEvents() {
            document.querySelectorAll('#modern-pagination .page-link[data-page]').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const page = parseInt(this.getAttribute('data-page'));
                    if (page && page !== currentPage && !isLoading) {
                        loadAchievements(page);
                    }
                });
            });
        }

        function updateSortIcons() {
            document.querySelectorAll('.achievement-table th.sortable').forEach(header => {
                const column = header.getAttribute('data-column');
                header.classList.remove('sorted-asc', 'sorted-desc');
                if (column === currentSort.column) {
                    header.classList.add(currentSort.direction === 'desc' ? 'sorted-desc' : 'sorted-asc');
                }
            });
        }

        // Initialize
        document.querySelectorAll('.achievement-table th[data-column]').forEach(header => {
            header.classList.add('sortable');
            header.style.cursor = 'pointer';

            if (!header.querySelector('.sort-icon')) {
                header.appendChild(document.createElement('span')).className = 'sort-icon';
            }

            header.addEventListener('click', function() {
                const column = this.getAttribute('data-column');
                if (currentSort.column === column) {
                    currentSort.direction = currentSort.direction === 'desc' ? 'asc' : 'desc';
                } else {
                    currentSort.column = column;
                    currentSort.direction = 'desc';
                }
                loadAchievements(1);
            });
        });

        // Load initial data
        const initialPage = parseInt(new URLSearchParams(window.location.search).get('page')) || 1;
        loadAchievements(initialPage);

        // Initialize select status
        const select = document.getElementById('ketersediaanSelect');
        if (select) updateSelectStatus(select, select.value);
    });
</script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\ThinkPad\OneDrive\Dokumen\GitHub\web-koni\resources\views/admin/pelatih/show.blade.php ENDPATH**/ ?>