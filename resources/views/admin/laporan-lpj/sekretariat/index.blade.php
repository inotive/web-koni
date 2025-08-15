@extends('layouts.app')

@section('pageTitle', 'Manajemen Sekretariat')
@section('mainSection', 'Laporan Pertanggungjawaban')
@section('currentSection', 'Sekretariat')

@section('breadcrumb-title')
@endsection

@section('breadcrumb-items')
@endsection

@section('content')
    <style>
        body {
            background-color: #f5f5f5;
        }

        table td,
        table th {
            vertical-align: middle;
            word-wrap: break-word;
            max-width: 200px;
        }

        .object-fit-cover {
            object-fit: cover;
        }

        .table th:nth-child(1) {
            width: 40px;
        }

        .table th:nth-child(2) {
            width: 250px;
        }

        .table th:nth-child(3) {
            width: 100px;
        }

        .table th:nth-child(4) {
            width: 150px;
        }

        .table th:nth-child(5) {
            width: 150px;
        }

        .table th:nth-child(6) {
            width: 100px;
        }

        .table th:nth-child(7) {
            width: 120px;
        }

        .table th:nth-child(8) {
            width: 80px;
        }

        .text-truncate-custom {
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
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

        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        @media (max-width: 768px) {
            .table-responsive {
                overflow-x: auto !important;
                overflow-y: visible !important;
            }

            .dropdown-menu-custom {
                position: absolute !important;
                z-index: 9999 !important;
                right: 0 !important;
                left: auto !important;
                min-width: 140px;
            }
        }

        .pagination-wrapper .pagination {
            margin-bottom: 0;
        }

        .pagination-wrapper .page-link {
            padding: 0.375rem 0.75rem;
            margin-left: -1px;
            color: #6c757d;
            background-color: #fff;
            border: 1px solid #dee2e6;
        }

        .pagination-wrapper .page-item.active .page-link {
            background-color: #F8285A;
            border-color: #F8285A;
            color: #fff;
        }

        .pagination-wrapper .page-link:hover {
            color: #495057;
            background-color: #e9ecef;
            border-color: #dee2e6;
        }

        .loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

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
            border-bottom-color: var(--bs-tooltip-bg);
            border-top-color: var(--bs-tooltip-bg);
        }

        .tooltip-content strong {
            color: #333333;
            font-weight: 600;
        }

        .btn-restricted {
            cursor: not-allowed !important;
            opacity: 0.6 !important;
            pointer-events: none;
        }

        .btn-restricted:hover {
            background-color: #F8285A !important;
            border-color: #F8285A !important;
            color: white !important;
        }

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

        .modal-header {
            background-color: #F8285A !important;
            color: white !important;
            border-bottom: 1px solid #F8285A !important;
        }

        .restricted-action {
            position: relative;
        }

        .restricted-action:hover {
            background-color: transparent !important;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>

    <div class="d-flex flex-column mb-8">
        <h1 class="text-dark fw-bold mb-1">Laporan Sekretariat</h1>
        <div class="text-muted fw-semibold fs-6">Manajemen Laporan Sekretariat Anda Sekarang</div>
    </div>

    <div class="row col-12 mt-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap py-5">
                <h3 class="card-title fw-bold fs-4 mb-0">Daftar Table Sekretariat - 2025</h3>

                <div class="d-flex align-items-center gap-2 flex-wrap ms-auto">
                    @if(auth()->user()->hasRole('superadmin'))
                        <a href="{{ route('admin.laporan-lpj.sekretariat.create') }}" class="btn custom-red-button"
                            style="background-color: #F8285A !important; color: white !important; border-color: #F8285A !important;">
                            <i class="ki-duotone ki-plus fs-2" style="color: white !important;"></i>Tambah Laporan
                        </a>
                    @else
                        <div class="position-relative">
                            <button class="btn custom-red-button btn-restricted"
                                    style="background-color: #F8285A !important; color: white !important; border-color: #F8285A !important;"
                                    data-bs-toggle="tooltip"
                                    data-bs-placement="bottom"
                                    data-bs-custom-class="custom-tooltip"
                                    data-bs-html="true"
                                    title="<div class='tooltip-content'>
                                              <strong>Informasi</strong><br>
                                              Ajukan approval untuk<br>
                                              modifikasi laporan
                                           </div>">
                                <i class="ki-duotone ki-plus fs-2" style="color: white !important;"></i>Tambah Laporan
                            </button>
                        </div>
                    @endif

                    <div class="input-group" style="width: 250px;">
                        <input type="search" name="search" id="search" class="form-control"
                            placeholder="Cari kegiatan..." value="{{ request('search') }}">
                        <button class="btn btn-outline-secondary" type="button" id="search-button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>

                    <div class="dropdown" style="z-index: 1055">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-filter me-1"></i> Filter
                            <span id="filter-count" class="badge badge-circle badge-danger ms-1 d-none">0</span>
                        </button>
                        <div class="dropdown-menu p-3 shadow" style="min-width: 320px;">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Jenis Kegiatan</label>
                                <select id="filter-jenis-kegiatan" class="form-select">
                                    <option value="">Semua Jenis</option>
                                    @foreach ($kegiatanLainnya->pluck('jenis_kegiatan')->unique()->filter() as $jenis)
                                        <option value="{{ $jenis }}"
                                            {{ request('jenis_kegiatan_filter') == $jenis ? 'selected' : '' }}>
                                            {{ $jenis }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="button" id="apply-filters" class="btn btn-primary btn-sm flex-fill">
                                    <i class="ki-duotone ki-check fs-3"></i>Terapkan
                                </button>
                                <button type="button" id="reset-filters" class="btn btn-light btn-sm flex-fill">
                                    <i class="ki-duotone ki-arrows-circle fs-3"></i>Reset
                                </button>
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
                    @include('admin.laporan-lpj.sekretariat._table')
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header" style="background: #F8285A; color: white;">
                    <h5 class="modal-title text-white" id="previewModalLabel">Preview Files</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
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
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            let dataTable = null;

            function initializeDataTable() {
                const table = $("#kt_datatable_dom_positioning_kegiatan");

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

                    checkDropdownPosition($dropdownAction);
                });

                function checkDropdownPosition($dropdownAction) {
                    const $menu = $dropdownAction.find('.dropdown-menu-custom');
                    if (!$menu.hasClass('show')) return;

                    $dropdownAction.removeClass('dropup');

                    const $row = $dropdownAction.closest('tr');
                    const $table = $row.closest('tbody');
                    const rowIndex = $table.find('tr').index($row);
                    const totalRows = $table.find('tr').length;

                    if (rowIndex === totalRows - 1) {
                        $dropdownAction.addClass('dropup');
                    }
                }

                $(document).on('click', function(e) {
                    if (!$(e.target).closest('.dropdown-action').length) {
                        $('.dropdown-menu-custom').removeClass('show');
                    }
                });

                $(window).on('resize', function() {
                    $('.dropdown-action').each(function() {
                        if ($(this).find('.dropdown-menu-custom').hasClass('show')) {
                            checkDropdownPosition($(this));
                        }
                    });
                });

                if (window.innerWidth > 768) {
                    $(document).on('mouseenter', '.dropdown-action', function() {
                        const $menu = $(this).find('.dropdown-menu-custom');
                        $menu.addClass('show');
                        checkDropdownPosition($(this));
                    }).on('mouseleave', '.dropdown-action', function() {
                        const $menu = $(this).find('.dropdown-menu-custom');
                        setTimeout(() => {
                            if (!$menu.is(':hover')) {
                                $menu.removeClass('show');
                            }
                        }, 100);
                    });

                    $(document).on('mouseenter', '.dropdown-menu-custom', function() {
                        clearTimeout($(this).data('timeout'));
                    }).on('mouseleave', '.dropdown-menu-custom', function() {
                        const $menu = $(this);
                        $menu.data('timeout', setTimeout(() => {
                            $menu.removeClass('show');
                        }, 200));
                    });
                }
            }

            initializeTooltips();
            initializeDropdownEvents();

            function showLoading() {
                $('#loading-overlay').removeClass('d-none');
            }

            function hideLoading() {
                $('#loading-overlay').addClass('d-none');
            }

            function updateTable(params = {}) {
                showLoading();

                const currentUrl = new URL(window.location.href);

                for (const key in params) {
                    if (params[key]) {
                        currentUrl.searchParams.set(key, params[key]);
                    } else {
                        currentUrl.searchParams.delete(key);
                    }
                }

                if (!params.page) {
                    currentUrl.searchParams.set('page', 1);
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
                        updateFilterCount();
                    },
                    error: function() {
                        hideLoading();
                        alert('Terjadi kesalahan saat memuat data');
                    }
                });
            }

            $('#search-button').on('click', function() {
                updateTable({
                    'search': $('#search').val()
                });
            });

            $('#search').on('keypress', function(e) {
                if (e.which === 13) {
                    $('#search-button').click();
                }
            });

            $('#apply-filters').on('click', function() {
                const jenisKegiatan = $('#filter-jenis-kegiatan').val();
                const startDate = $('#filter-start-date').val();
                const endDate = $('#filter-end-date').val();

                updateTable({
                    'jenis_kegiatan_filter': jenisKegiatan,
                    'start_date': startDate,
                    'end_date': endDate
                });
            });

            $('#reset-filters').on('click', function() {
                $('#filter-jenis-kegiatan').val('');
                $('#filter-start-date').val('');
                $('#filter-end-date').val('');
                $('#search').val('');

                updateTable({
                    'search': '',
                    'jenis_kegiatan_filter': '',
                    'start_date': '',
                    'end_date': ''
                });
            });

            $(document).on('change', '#per-page-select', function() {
                updateTable({
                    'per_page': $(this).val()
                });
            });

            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();
                const url = new URL($(this).attr('href'));
                const page = url.searchParams.get('page');

                updateTable({
                    'page': page
                });
            });

            $(document).on('click', '.sortable-header', function(e) {
                e.preventDefault();
                const url = new URL($(this).attr('href'));
                const sort = url.searchParams.get('sort');
                const direction = url.searchParams.get('direction');

                updateTable({
                    'sort': sort,
                    'direction': direction
                });
            });

            function updateFilterCount() {
                const urlParams = new URLSearchParams(window.location.search);
                let count = 0;

                if (urlParams.get('jenis_kegiatan_filter')) count++;
                if (urlParams.get('start_date') || urlParams.get('end_date')) count++;
                if (urlParams.get('search')) count++;

                const badge = $('#filter-count');
                if (count > 0) {
                    badge.text(count).removeClass('d-none');
                } else {
                    badge.addClass('d-none');
                }
            }

            updateFilterCount();

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

            $(document).on('click', '.preview-btn', function() {
                const btn = $(this);
                currentFiles = JSON.parse(btn.attr('data-files'));
                currentType = btn.attr('data-type');
                currentIndex = 0;
                modalTitle.textContent = btn.attr('data-title');

                loadPreview();
            });

            function loadPreview() {
                previewSlides.innerHTML = '';

                currentFiles.forEach((file, index) => {
                    const slide = document.createElement('div');
                    slide.className = `preview-slide ${index === currentIndex ? 'active' : ''}`;

                    if (currentType === 'image') {
                        slide.innerHTML = `
                            <img src="/storage/${file}" alt="Preview" class="preview-image">
                        `;
                    } else {
                        const fileName = file.split('/').pop();
                        const fileExtension = fileName.split('.').pop().toLowerCase();

                        if (fileExtension === 'pdf') {
                            slide.innerHTML = `
                                <iframe src="/storage/${file}" class="preview-document"></iframe>
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

                updateUI();
            }

            function updateUI() {
                const fileName = currentFiles[currentIndex].split('/').pop();
                currentFileName.textContent = fileName;
                fileCounter.textContent = `${currentIndex + 1} of ${currentFiles.length}`;

                if (currentFiles.length > 1) {
                    prevBtn.style.display = 'block';
                    nextBtn.style.display = 'block';
                } else {
                    prevBtn.style.display = 'none';
                    nextBtn.style.display = 'none';
                }

                downloadBtn.onclick = function() {
                    window.open('/storage/' + currentFiles[currentIndex], '_blank');
                };
            }

            function showSlide(index) {
                document.querySelectorAll('.preview-slide').forEach((slide, i) => {
                    slide.classList.toggle('active', i === index);
                });
                currentIndex = index;
                updateUI();
            }

            prevBtn.addEventListener('click', function() {
                const newIndex = currentIndex > 0 ? currentIndex - 1 : currentFiles.length - 1;
                showSlide(newIndex);
            });

            nextBtn.addEventListener('click', function() {
                const newIndex = currentIndex < currentFiles.length - 1 ? currentIndex + 1 : 0;
                showSlide(newIndex);
            });

            document.addEventListener('keydown', function(e) {
                if (previewModal.classList.contains('show')) {
                    if (e.key === 'ArrowLeft') {
                        prevBtn.click();
                    } else if (e.key === 'ArrowRight') {
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
                    'pptx': 'fas fa-file-powerpoint text-warning'
                };
                return icons[extension] || 'fas fa-file text-muted';
            }

            $('#previewModal').on('show.bs.modal', function() {
                if (currentFiles.length > 0) {
                    showSlide(0);
                }
            });
        });
    </script>
@endsection
