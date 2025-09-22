<?php $__env->startSection('pageTitle', 'Manajemen Template Surat Masuk & Keluar'); ?>
<?php $__env->startSection('mainSection', 'Menu Utama'); ?>
<?php $__env->startSection('currentSection', 'Surat Masuk & Keluar'); ?>

<?php $__env->startSection('style'); ?>
    <style>
        .is-invalid {
            border-color: #dc3545 !important;
        }


        .filter-container {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .search-container {
            position: relative;
            width: 250px;
        }

        .search-input {
            padding-left: 45px !important;
        }

        .search-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            pointer-events: none;
            z-index: 10;
        }

        .date-filter-container {
            position: relative;
            width: 200px;
        }

        .date-filter-btn {
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 8px 16px;
            font-size: 0.95rem;
            color: #495057;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            text-align: left;
        }

        .date-filter-btn:hover {
            border-color: #F8285A;
            color: #F8285A;
        }

        .date-filter-btn.date-filter-active {
            background-color: #F8285A;
            border-color: #F8285A;
            color: white;
        }

        .date-filter-menu {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            z-index: 1000;
            margin-top: 4px;
            display: none;
        }

        .date-filter-menu.show {
            display: block;
        }

        .date-filter-menu {
            padding: 16px;
            min-width: 280px;
        }

        .date-input-group {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .date-input-wrapper {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .date-input-label {
            font-size: 0.875rem;
            font-weight: 600;
            color: #374151;
        }

        .date-input {
            padding: 8px 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 0.875rem;
            color: #374151;
            background-color: #fff;
            transition: border-color 0.2s ease;
        }

        .date-input:focus {
            outline: none;
            border-color: #F8285A;
            box-shadow: 0 0 0 3px rgba(248, 40, 90, 0.1);
        }

        .date-filter-actions {
            display: flex;
            gap: 8px;
            margin-top: 12px;
            padding-top: 12px;
            border-top: 1px solid #e5e7eb;
        }

        .date-filter-apply {
            flex: 1;
            background-color: #F8285A;
            color: white;
            border: none;
            border-radius: 6px;
            padding: 8px 16px;
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .date-filter-apply:hover {
            background-color: #e1244e;
        }

        .date-filter-clear {
            background-color: #f3f4f6;
            color: #6b7280;
            border: none;
            border-radius: 6px;
            padding: 8px 16px;
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .date-filter-clear:hover {
            background-color: #e5e7eb;
        }

        .nav-tabs-custom {
            border-bottom: 2px solid #e9ecef;
            margin-bottom: 0;
        }

        .nav-tabs-custom .nav-link {
            border: none;
            border-bottom: 3px solid transparent;
            padding: 12px 24px;
            font-weight: 600;
            color: #6c757d;
            background: none;
            border-radius: 0;
            transition: all 0.3s ease;
        }

        .nav-tabs-custom .nav-link:hover {
            border-bottom-color: #F8285A;
            color: #F8285A;
            background: none;
        }

        .nav-tabs-custom .nav-link.active {
            color: #F8285A;
            border-bottom-color: #F8285A;
            background: none;
        }

        .table-loading {
            opacity: 0.6;
            pointer-events: none;
        }

        @media (max-width: 768px) {
            .filter-container {
                flex-direction: column;
                align-items: stretch;
                gap: 10px;
            }

            .search-container,
            .date-filter-container {
                width: 100%;
            }

            .nav-tabs-custom .nav-link {
                padding: 8px 16px;
                font-size: 14px;
            }

            .date-filter-menu {
                min-width: 100%;
                left: 0;
                right: 0;
            }
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="d-grid gap-5 border-0">
        <div class="d-flex justify-content-between align-items-center container">
            <div class="d-none d-md-block">
                <h1>Template Surat Masuk & Keluar</h1>
                <span>Manajemen Template Surat Masuk & Keluar</span>
            </div>

            <form id="filter" class="d-flex gap-3 filter-container">
                <!-- Hidden inputs untuk sorting -->
                <input type="hidden" name="sort_by" id="sort_by_input" value="<?php echo e(request('sort_by', 'created_at')); ?>">
                <input type="hidden" name="order" id="order_input" value="<?php echo e(request('order', 'desc')); ?>">
                <input type="hidden" name="jenis_surat" id="jenis_surat_input" value="<?php echo e(request('jenis_surat', 'all')); ?>">

                <button type="button" id="tambahSuratBtn"
                    class="btn btn-active-light-danger d-flex bg-danger align-items-center btn-facebook fw-bold gap-2 rounded border-0 px-4 py-2 text-white">
                    <i class="ki-duotone ki-plus fs-2" style="color: white !important;"></i>
                    <span id="tambahSuratText">Upload Template</span>
                </button>

                <div class="search-container">
                    <div class="position-relative bg-light">
                        <i class="ki-outline ki-magnifier fs-2 search-icon"></i>
                        <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Cari surat..."
                            class="form-control border border-gray-500 py-2 search-input" />
                    </div>
                </div>
            </form>
        </div>

        <div class="container">
            <div class="card-header border-bottom-0 pb-0">
                <ul class="nav nav-tabs nav-tabs-custom" id="suratTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="masuk-tab" data-bs-toggle="tab" data-bs-target="#masuk-content"
                            type="button" role="tab" aria-controls="masuk-content" aria-selected="true">
                            <i class="fas fa-inbox me-2"></i>Surat Masuk
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="keluar-tab" data-bs-toggle="tab" data-bs-target="#keluar-content"
                            type="button" role="tab" aria-controls="keluar-content" aria-selected="false">
                            <i class="fas fa-paper-plane me-2"></i>Surat Keluar
                        </button>
                    </li>
                </ul>
            </div>

            <div class="card-body">
                <div class="tab-content tab-content-custom" id="suratTabContent">
                    <div class="tab-pane fade show active" id="masuk-content" role="tabpanel" aria-labelledby="masuk-tab">
                        <div id="table-masuk">
                            <?php echo $__env->make('admin.surat._table', [
                                'suratData' => $suratMasuk,
                                'tableId' => 'masuk',
                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="keluar-content" role="tabpanel" aria-labelledby="keluar-tab">
                        <div id="table-keluar">
                            <?php echo $__env->make('admin.surat._table', [
                                'suratData' => $suratKeluar,
                                'tableId' => 'keluar',
                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk Add Surat -->
    <div class="modal fade" id="add" tabindex="-1" aria-labelledby="add" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 gap-5 px-10 py-8">
                <div class="d-flex justify-content-between align-items-center gap-2">
                    <div class="fs-2 fw-bold text-truncate leading-5" id="modalTitle">Upload Template</div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="formAdd" method="POST" action="<?php echo e(route('admin.surat.store')); ?>" enctype="multipart/form-data"
                    class="d-grid gap-4">
                    <?php echo csrf_field(); ?>

                    <div>
                        <div class="fw-semibold required mb-3 text-gray-800">Nama Kegiatan</div>
                        <input type="text" name="nama_kegiatan" placeholder="Masukkan Nama Kegiatan"
                            class="form-control bg-light border border-gray-400" required />
                    </div>

                    <div>
                        <div class="fw-semibold required mb-3 text-gray-800">Nomor Surat</div>
                        <input type="text" name="no_surat" placeholder="Masukkan Nomor Surat"
                            class="form-control bg-light border border-gray-400" required />
                    </div>

                    <input type="hidden" name="jenis_surat" id="hiddenJenisSurat" value="masuk">

                    <div>
                        <div class="fw-semibold mb-3 text-gray-800">
                            Unggah Dokumen
                        </div>
                        <div class="fv-row">
                            <div class="dropzone" id="dropzone-formAdd">
                                <div class="dz-message needsclick">
                                    <i class="ki-duotone ki-file-up fs-3x text-primary">
                                        <span class="path1"></span><span class="path2"></span>
                                    </i>
                                    <div class="ms-4">
                                        <h3 class="fs-5 fw-bold mb-1 text-gray-900">Seret atau pilih dokumen.</h3>
                                        <span class="fs-7 fw-semibold text-gray-500">Format: PDF, DOC, DOCX. Max. 10
                                            MB.</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="d-grid py-4">
                    <button type="button" onclick="submitForm('formAdd')" id="submitBtn"
                        class="bg-danger fw-bold d-flex align-items-center justify-content-center gap-2 rounded border-0 p-4 text-white">
                        Upload Template
                    </button>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
   <script>
        let currentFilter = '<?php echo e(request('jenis_surat', 'all')); ?>';
        let currentTab = 'masuk';
        let currentSort = '<?php echo e(request('sort_by', 'created_at')); ?>';
        let currentOrder = '<?php echo e(request('order', 'desc')); ?>';
        Dropzone.autoDiscover = false;
        const dropzones = {};

        function updateAddButtonText() {
            const buttonText = 'Upload Template';
            const modalTitle = 'Upload Template';
            $('#tambahSuratText').text(buttonText);
            $('#modalTitle').text(modalTitle);
            $('#submitBtn').text(buttonText);
            $('#hiddenJenisSurat').val(currentTab === 'keluar' ? 'keluar' : 'masuk');
        }

        function updateDateFilterButton() {
            const createdDate = $('#createdDateInput').val();
            const button = $('#dateFilterBtn');
            const span = button.find('span');

            if (createdDate) {
                button.addClass('date-filter-active');
                const dateFormatted = formatDateToIndonesian(createdDate);
                span.html(`<i class="fas fa-calendar-check me-2"></i>${dateFormatted}`);
            } else {
                button.removeClass('date-filter-active');
                span.html('<i class="fas fa-calendar me-2"></i>Tanggal Dibuat');
            }
        }

        function reloadTable(url = null) {
            let formData = $('#filter').serialize();
            let target = url || "<?php echo e(route('admin.surat.index')); ?>";
            formData += '&tab=' + currentTab;

            $.ajax({
                url: target,
                data: formData,
                beforeSend: function() {
                    $(`#table-${currentTab}`).addClass('table-loading');
                    $(`#table-${currentTab}`).html(
                        '<div class="py-20 text-center"><span class="spinner-border text-danger"></span></div>'
                    );
                },
                success: function(response) {
                    $(`#table-${currentTab}`).removeClass('table-loading');
                    $(`#table-${currentTab}`).html(response);
                    initializeDropzones();
                    initializeDropdownEvents();
                    initializeSortingEvents();
                    updateURL(formData);
                },
                error: function(xhr) {
                    $(`#table-${currentTab}`).removeClass('table-loading');
                    $(`#table-${currentTab}`).html(
                        '<div class="py-20 text-center text-danger fw-bold">Terjadi kesalahan saat memuat data.</div>'
                    );
                }
            });
        }

        function updateURL(formData) {
            if (window.history && window.history.pushState) {
                const url = new URL(window.location);
                const searchParams = new URLSearchParams(formData);
                for (const [key, value] of searchParams.entries()) {
                    if (value && key !== 'tab') url.searchParams.set(key, value);
                    else if (key !== 'tab') url.searchParams.delete(key);
                }
                window.history.pushState({}, '', url);
            }
        }

        function initializeSortingEvents() {
            $(document).off('click', '.sort-link');

            $(document).on('click', '.sort-link', function(e) {
                e.preventDefault();

                const sortBy = $(this).data('sort');
                let order = 'asc';

                if (currentSort === sortBy) {
                    order = currentOrder === 'asc' ? 'desc' : 'asc';
                }

                currentSort = sortBy;
                currentOrder = order;

                $('#sort_by_input').val(sortBy);
                $('#order_input').val(order);

                reloadTable();
            });
        }

        function initializeDropdownEvents() {
            $(document).off('click', '.dropdown-toggle-custom').on('click', '.dropdown-toggle-custom', function(e) {
                e.preventDefault();
                e.stopPropagation();
                $('.dropdown-menu-custom').removeClass('show');
                $(this).siblings('.dropdown-menu-custom').addClass('show');
            });

            $(document).on('click', function(e) {
                if (!$(e.target).closest('.dropdown-action').length) $('.dropdown-menu-custom').removeClass('show');
            });

            $(document).on('click', '.dropdown-menu-custom', function(e) {
                e.stopPropagation();
            });
        }

        function debounce(func, delay) {
            let timeout;
            return function() {
                const context = this,
                    args = arguments;
                clearTimeout(timeout);
                timeout = setTimeout(() => func.apply(context, args), delay);
            };
        }

        function initializeDropzones() {
            Object.keys(dropzones).forEach(key => {
                if (dropzones[key] && typeof dropzones[key].destroy === 'function') {
                    dropzones[key].destroy();
                    delete dropzones[key];
                }
            });

            if (document.getElementById('dropzone-formAdd')) {
                dropzones['formAdd'] = new Dropzone("#dropzone-formAdd", {
                    url: "#",
                    autoProcessQueue: false,
                    paramName: 'dokumen_surat',
                    maxFiles: 1,
                    maxFilesize: 10,
                    addRemoveLinks: true,
                    acceptedFiles: '.pdf,.doc,.docx',
                });
            }

            document.querySelectorAll('[id^="dropzone-form-"]').forEach(element => {
                const formId = element.id.replace('dropzone-', '');
                if (!dropzones[formId]) {
                    dropzones[formId] = new Dropzone(`#${element.id}`, {
                        url: "#",
                        autoProcessQueue: false,
                        paramName: 'dokumen_surat',
                        maxFiles: 1,
                        maxFilesize: 10,
                        addRemoveLinks: true,
                        acceptedFiles: '.pdf,.doc,.docx',
                    });
                }
            });
        }

        function submitForm(formId) {
            const formElement = document.getElementById(formId);
            if (!formElement) {
                toastr.error("Form tidak ditemukan", "Error!");
                return;
            }

            const requiredFields = formElement.querySelectorAll('[required]');
            let isValid = true;
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('is-invalid');
                } else {
                    field.classList.remove('is-invalid');
                }
            });

            if (!isValid) {
                toastr.error("Harap lengkapi semua field yang wajib diisi.", "Validasi Gagal!");
                return;
            }

            const submitBtn = formElement.closest('.modal').querySelector('button[type="button"][onclick*="submitForm"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = `
        <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
        Mengirim...
    `;

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
                    } else {
                        formData.append(input.name, input.value);
                    }
                });
            }

            const dz = dropzones[formId];
            if (dz) {
                dz.getAcceptedFiles().forEach(file => formData.append('dokumen_surat', file));
            }

            if (formId !== 'formAdd') {
                const hiddenJenisSurat = document.querySelector(`#${formId} input[name="jenis_surat"]`);
                formData.set('jenis_surat', hiddenJenisSurat ? hiddenJenisSurat.value : currentTab);
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

                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;

                    if (!response.ok) {
                        if (data.errors) {
                            Object.entries(data.errors).forEach(([field, msgs]) => toastr.error(msgs.join(', '),
                                "Error!"));
                        } else {
                            toastr.error(data.message || "Gagal menyimpan data", "Error!");
                        }
                    } else {
                        $('.modal.show').addClass('submit-success');

                        if (formId === 'formAdd') {
                            formElement.reset();
                            if (dropzones['formAdd']) {
                                dropzones['formAdd'].removeAllFiles();
                            }
                        }

                        $('.modal.show').modal('hide');
                        toastr.success(data.message || "Data berhasil disimpan", "Success!");
                        updateAddButtonText();
                        reloadTable();
                    }
                })
                .catch(error => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                    toastr.error("Terjadi kesalahan. Silakan coba lagi.", "Error!");
                    console.error('Error:', error);
                });
        }

        function deleteItem(formId, namaKegiatan = 'surat ini') {
            const form = document.getElementById(formId);
            const route = form.action;

            Swal.fire({
                title: "Apakah Anda Yakin?",
                html: `<p style='text-align:center'>Setelah <strong>${namaKegiatan}</strong> dihapus, Anda tidak bisa mengembalikannya!</p>`,
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

                    fetch(route, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: new FormData(form)
                        })
                        .then(response => response.json())
                        .then(data => {
                            Swal.close();
                            if (data.success) {
                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: data.message || 'Surat berhasil dihapus',
                                    icon: 'success',
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                                reloadTable();
                            } else {
                                Swal.fire({
                                    title: 'Gagal!',
                                    text: data.message || 'Terjadi kesalahan saat menghapus',
                                    icon: 'error'
                                });
                            }
                        })
                        .catch(() => {
                            Swal.close();
                            Swal.fire({
                                title: 'Error!',
                                text: 'Terjadi kesalahan jaringan.',
                                icon: 'error'
                            });
                        });
                } else {
                    Swal.fire({
                        title: "Aksi Dibatalkan",
                        icon: "info",
                        timer: 1500,
                        showConfirmButton: false
                    });
                }
            });
        }

        $(document).ready(function() {
            initializeDropzones();
            initializeDropdownEvents();
            initializeSortingEvents();
            updateAddButtonText();
            updateDateFilterButton();

            $('#tambahSuratBtn').on('click', function() {
                $('#add').modal('show');
            });

            $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
                currentTab = $(e.target).attr('data-bs-target').replace('#', '').replace('-content', '');
                updateAddButtonText();
                reloadTable();
            });

            $('#filterBtn').on('click', function(e) {
                e.stopPropagation();
                $('#filterMenu').toggleClass('show');
                $('#dateFilterMenu').removeClass('show');
            });

            $('#dateFilterBtn').on('click', function(e) {
                e.stopPropagation();
                $('#dateFilterMenu').toggleClass('show');
                $('#filterMenu').removeClass('show');
            });

            $(document).on('click', function() {
                $('#filterMenu').removeClass('show');
                $('#dateFilterMenu').removeClass('show');
            });

            $('.filter-option').on('click', function(e) {
                e.stopPropagation();
                const filterType = $(this).data('filter');
                if (filterType === currentFilter) return;

                $('.filter-option').removeClass('active');
                $(this).addClass('active');
                $('#filterBtn span').html($(this).find('span').html());
                $('#filterBtn').toggleClass('filter-active', filterType !== 'all');
                currentFilter = filterType;
                $('#jenis_surat_input').val(filterType);
                reloadTable();
                $('#filterMenu').removeClass('show');
            });

            $('#applyDateFilter').on('click', function() {
                updateDateFilterButton();
                reloadTable();
                $('#dateFilterMenu').removeClass('show');
            });

            $('#clearDateFilter').on('click', function() {
                $('#createdDateInput').val('');
                updateDateFilterButton();
                reloadTable();
                $('#dateFilterMenu').removeClass('show');
            });

            $(document).on('input', '#filter input[name="search"]', debounce(function() {
                reloadTable();
            }, 300));

            $(document).on('change', 'select[name="per_page"]', function() {
                const newPerPage = $(this).val();
                const formData = $('#filter').serialize() + '&tab=' + currentTab + '&per_page=' +
                    newPerPage;

                $.ajax({
                    url: "<?php echo e(route('admin.surat.index')); ?>",
                    data: formData,
                    beforeSend: function() {
                        $(`#table-${currentTab}`).addClass('table-loading');
                        $(`#table-${currentTab}`).html(
                            '<div class="py-20 text-center"><span class="spinner-border text-danger"></span></div>'
                        );
                    },
                    success: function(response) {
                        $(`#table-${currentTab}`).removeClass('table-loading');
                        $(`#table-${currentTab}`).html(response);
                        initializeDropzones();
                        initializeDropdownEvents();
                        initializeSortingEvents();
                        updateURL(formData);
                    },
                    error: function(xhr) {
                        $(`#table-${currentTab}`).removeClass('table-loading');
                        $(`#table-${currentTab}`).html(
                            '<div class="py-20 text-center text-danger fw-bold">Terjadi kesalahan saat memuat data.</div>'
                        );
                    }
                });
            });

            $(document).on('click', '.pagination-link', function(e) {
                e.preventDefault();
                const url = $(this).attr('href');
                if (url) {
                    const page = new URL(url).searchParams.get('page');
                    const formData = $('#filter').serialize() + '&tab=' + currentTab + '&page=' + page;

                    $.ajax({
                        url: "<?php echo e(route('admin.surat.index')); ?>",
                        data: formData,
                        beforeSend: function() {
                            $(`#table-${currentTab}`).addClass('table-loading');
                            $(`#table-${currentTab}`).html(
                                '<div class="py-20 text-center"><span class="spinner-border text-danger"></span></div>'
                            );
                        },
                        success: function(response) {
                            $(`#table-${currentTab}`).removeClass('table-loading');
                            $(`#table-${currentTab}`).html(response);
                            initializeDropzones();
                            initializeDropdownEvents();
                            initializeSortingEvents();
                            updateURL(formData);
                        },
                        error: function(xhr) {
                            $(`#table-${currentTab}`).removeClass('table-loading');
                            $(`#table-${currentTab}`).html(
                                '<div class="py-20 text-center text-danger fw-bold">Terjadi kesalahan saat memuat data.</div>'
                            );
                        }
                    });
                }
            });

            $('#filterMenu, #dateFilterMenu').on('click', function(e) {
                e.stopPropagation();
            });

            const urlParams = new URLSearchParams(window.location.search);
            const filterFromURL = urlParams.get('jenis_surat') || 'all';
            if (filterFromURL !== currentFilter) {
                $(`.filter-option[data-filter="${filterFromURL}"]`).click();
            }

            if (filterFromURL === 'keluar') {
                $('#keluar-tab').tab('show');
                currentTab = 'keluar';
                updateAddButtonText();
            }

            $(document).on('show.bs.modal', '.modal', function(e) {
                const modalId = $(this).attr('id');
                const modal = $(this);

                modal.removeClass('has-changes submit-success');

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

                if (modalId === 'add') {
                    const form = document.getElementById('formAdd');
                    if (form) {
                        form.reset();
                    }
                    if (dropzones['formAdd']) {
                        dropzones['formAdd'].removeAllFiles();
                    }
                } else if (modalId.startsWith('edit-')) {
                    const suratId = modalId.split('-')[1];
                    const formId = `form-${suratId}`;

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
                    }

                    if (dropzones[formId]) {
                        dropzones[formId].removeAllFiles();
                    }
                }

                modal.removeClass('has-changes submit-success');
                modal.removeData('original-data');
            });

            $(document).on('input change', '.modal input, .modal select, .modal textarea', function() {
                const modal = $(this).closest('.modal');
                modal.addClass('has-changes');
            });

            $(document).on('hide.bs.modal', '.modal', function(e) {
                const modal = $(this);

                if (modal.hasClass('submit-success') || !modal.hasClass('has-changes')) {
                    return;
                }
            });
        });

        function formatDateToIndonesian(dateString) {
            if (!dateString) return '';
            const date = new Date(dateString);
            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const year = date.getFullYear();
            return `${day}/${month}/${year}`;
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/thur/Documents/Inotive/web-koni/resources/views/admin/surat/index.blade.php ENDPATH**/ ?>