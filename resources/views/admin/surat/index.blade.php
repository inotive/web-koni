@extends('layouts.app')

@section('pageTitle', 'Manajemen Sekretariat')
@section('mainSection', 'Laporan Pertanggungjawaban')
@section('currentSection', 'Surat Masuk & Keluar')

@section('breadcrumb-title')
@endsection

@section('breadcrumb-items')
@endsection

@section('style')
<style>
    body {
        background-color: #f5f5f5;
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

    .filter-dropdown {
        position: relative;
        width: 200px;
    }

    .filter-btn {
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

    .filter-btn:hover {
        border-color: #F8285A;
        color: #F8285A;
    }

    .filter-btn.filter-active {
        background-color: #F8285A;
        border-color: #F8285A;
        color: white;
    }

    .filter-menu {
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

    .filter-menu.show {
        display: block;
    }

    .filter-option {
        padding: 12px 16px;
        cursor: pointer;
        transition: background-color 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid #f8f9fa;
    }

    .filter-option:last-child {
        border-bottom: none;
    }

    .filter-option:hover {
        background-color: #f8f9fa;
    }

    .filter-option.active {
        background-color: #F8285A;
        color: white;
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

    .tab-content-custom {
        border-top: none;
    }

    table td,
    table th {
        vertical-align: middle;
        word-wrap: break-word;
        max-width: 200px;
    }

    .text-truncate-custom {
        max-width: 200px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .dropdown-menu {
        z-index: 1055 !important;
        position: absolute !important;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        border: 1px solid rgba(0, 0, 0, 0.15) !important;
    }

    .dropdown {
        position: relative;
        z-index: 1000;
    }

    .btn-icon {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
    }

    .btn-light-warning {
        background-color: #fff3cd;
        border-color: #ffeaa7;
        color: #856404;
    }

    .btn-light-warning:hover {
        background-color: #ffecb5;
        border-color: #ffe69c;
        color: #533f03;
    }

    .btn-light-danger {
        background-color: #f8d7da;
        border-color: #f5c6cb;
        color: #721c24;
    }

    .btn-light-danger:hover {
        background-color: #f1b0b7;
        border-color: #ecadb2;
        color: #491217;
    }

    .btn-light-primary {
        background-color: #d1ecf1;
        border-color: #b8daff;
        color: #0c5460;
    }

    .btn-light-primary:hover {
        background-color: #bee5eb;
        border-color: #a6d8ff;
        color: #062c33;
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

        .search-container {
            width: 100%;
        }

        .filter-dropdown {
            width: 100%;
        }

        .nav-tabs-custom .nav-link {
            padding: 8px 16px;
            font-size: 14px;
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

    .badge-success { background-color: #198754 !important; }
    .badge-primary { background-color: #0d6efd !important; }

    .edit:hover {
        background-color: rgb(249, 245, 172) !important;
    }

    .delete:hover {
        background-color: #ffcad7ff !important;
    }

    .card {
        min-height: auto !important;
        height: auto !important;
    }

    .card-body {
        min-height: auto !important;
        height: auto !important;
        padding: 1.5rem;
    }

    .tab-content {
        min-height: auto !important;
        height: auto !important;
    }

    .tab-pane {
        min-height: auto !important;
        height: auto !important;
    }
</style>
@endsection

@section('content')
    <div class="d-grid gap-5 border-0">
        <div class="d-flex justify-content-between align-items-center container">
            <div class="d-none d-md-block">
                <h1>Surat Masuk & Keluar</h1>
                <span>Manajemen Surat Masuk & Keluar Anda Sekarang</span>
            </div>
            
            <form id="filter" class="d-flex gap-3 filter-container">
                <button type="button" data-bs-toggle="modal" data-bs-target="#add"
                    class="btn btn-active-light-danger d-flex bg-danger align-items-center btn-facebook fw-bold gap-2 rounded border-0 px-4 py-2 text-white">
                    <i class="ki-duotone ki-plus fs-2" style="color: white !important;"></i>
                    Tambah Surat
                </button>

                <div class="search-container">
                    <div class="position-relative bg-light">
                        <i class="ki-outline ki-magnifier fs-2 search-icon"></i>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari surat..." class="form-control border border-gray-500 py-2 search-input" />
                    </div>
                </div>

                <div class="filter-dropdown">
                    <div class="filter-btn {{ (request('jenis_surat') && request('jenis_surat') != 'all') ? 'filter-active' : '' }}" id="filterBtn">
                        <span>
                            @if(request('jenis_surat') == 'masuk')
                                <i class="fas fa-inbox me-2" style="color: #198754;"></i>Surat Masuk
                            @elseif(request('jenis_surat') == 'keluar')
                                <i class="fas fa-paper-plane me-2" style="color: #0d6efd;"></i>Surat Keluar
                            @else
                                <i class="fas fa-filter me-2"></i>Filter Jenis Surat
                            @endif
                        </span>
                        <i class="fas fa-chevron-down" style="font-size: 0.8rem;"></i>
                    </div>

                    <div class="filter-menu" id="filterMenu">
                        <div class="filter-option {{ (request('jenis_surat', 'all') == 'all') ? 'active' : '' }}" data-filter="all">
                            <span>
                                <i class="fas fa-list me-2"></i>
                                Semua Surat
                            </span>
                        </div>
                        <div class="filter-option {{ (request('jenis_surat') == 'masuk') ? 'active' : '' }}" data-filter="masuk">
                            <span>
                                <i class="fas fa-inbox me-2" style="color: #198754;"></i>
                                Surat Masuk
                            </span>
                        </div>
                        <div class="filter-option {{ (request('jenis_surat') == 'keluar') ? 'active' : '' }}" data-filter="keluar">
                            <span>
                                <i class="fas fa-paper-plane me-2" style="color: #0d6efd;"></i>
                                Surat Keluar
                            </span>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <input type="date" name="start_date" value="{{ request('start_date') }}" 
                           class="form-control form-control-sm" placeholder="Dari" style="width: 150px;">
                    <input type="date" name="end_date" value="{{ request('end_date') }}" 
                           class="form-control form-control-sm" placeholder="Sampai" style="width: 150px;">
                </div>

                <input type="hidden" name="jenis_surat" id="jenis_surat_input" value="{{ request('jenis_surat', 'all') }}">
            </form>
        </div>

        <div class="container">
            <div class="card">
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
                                @include('admin.surat._table', ['suratData' => $suratMasuk, 'tableId' => 'masuk'])
                            </div>
                        </div>

                        <div class="tab-pane fade" id="keluar-content" role="tabpanel" aria-labelledby="keluar-tab">
                            <div id="table-keluar">
                                @include('admin.surat._table', ['suratData' => $suratKeluar, 'tableId' => 'keluar'])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="add" tabindex="-1" aria-labelledby="add" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content rounded-4 gap-5 px-10 py-8">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="fs-2 fw-bold leading-5">Tambah Surat</div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form id="formAdd" action="{{ route('admin.surat.store') }}" method="POST"
                        enctype="multipart/form-data" class="d-grid gap-4">
                        @csrf

                        <div>
                            <div class="fw-semibold required mb-3 text-gray-800">Nama Kegiatan</div>
                            <input type="text" name="nama_kegiatan" placeholder="Masukkan Nama Kegiatan"
                                class="form-control bg-light border border-gray-400" required />
                        </div>

                        <div>
                            <div class="fw-semibold required mb-3 text-gray-800">Jenis Surat</div>
                            <select name="jenis_surat" class="form-select bg-light border border-gray-400" required>
                                <option value="">Pilih Jenis Surat</option>
                                <option value="masuk">Surat Masuk</option>
                                <option value="keluar">Surat Keluar</option>
                            </select>
                        </div>

                        <div>
                            <div class="fw-semibold mb-3 text-gray-800">
                                Unggah Dokumen Surat
                                <span class="text-muted">(Opsional)</span>
                            </div>
                            <div class="fv-row">
                                <div class="dropzone" id="dropzone-formAdd">
                                    <div class="dz-message needsclick">
                                        <i class="ki-duotone ki-file-up fs-3x text-primary">
                                            <span class="path1"></span><span class="path2"></span>
                                        </i>
                                        <div class="ms-4">
                                            <h3 class="fs-5 fw-bold mb-1 text-gray-900">Seret atau pilih dokumen surat.</h3>
                                            <span class="fs-7 fw-semibold text-gray-500">Format: PDF, DOC, DOCX. Max. 10 MB.</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="d-grid py-4">
                        <button type="button" onclick="submitForm('formAdd')"
                            class="bg-danger fw-bold d-flex align-items-center justify-content-center gap-2 rounded border-0 p-4 text-white">
                            Tambah Surat
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
    let currentFilter = '{{ request("jenis_surat", "all") }}';
    let currentTab = 'masuk';

    function reloadTable(url = null) {
        let formData = $('#filter').serialize();
        let target = url ?? "{{ route('admin.surat.index') }}";

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

                if (window.history && window.history.pushState) {
                    const url = new URL(window.location);
                    const searchParams = new URLSearchParams(formData);

                    for (const [key, value] of searchParams.entries()) {
                        if (value && key !== 'tab') {
                            url.searchParams.set(key, value);
                        } else if (key !== 'tab') {
                            url.searchParams.delete(key);
                        }
                    }

                    window.history.pushState({}, '', url);
                }
            },
            error: function(xhr) {
                $(`#table-${currentTab}`).removeClass('table-loading');
                $(`#table-${currentTab}`).html(
                    '<div class="py-20 text-center text-danger fw-bold">Terjadi kesalahan saat memuat data.</div>'
                );
            }
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

    Dropzone.autoDiscover = false;
    const dropzones = {};

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

    $(document).ready(function() {
        initializeDropzones();

        $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
            const targetId = $(e.target).attr('data-bs-target');
            currentTab = targetId.replace('#', '').replace('-content', '');
            reloadTable();
        });

        $('#filterBtn').on('click', function(e) {
            e.stopPropagation();
            $('#filterMenu').toggleClass('show');
        });

        $(document).on('click', function() {
            $('#filterMenu').removeClass('show');
        });

        $('.filter-option').on('click', function(e) {
            e.stopPropagation();

            const filterType = $(this).data('filter');
            if (filterType === currentFilter) return;

            $('.filter-option').removeClass('active');
            $(this).addClass('active');

            const filterContent = $(this).find('span').html();
            $('#filterBtn span').html(filterContent);

            if (filterType === 'all') {
                $('#filterBtn').removeClass('filter-active');
            } else {
                $('#filterBtn').addClass('filter-active');
            }

            currentFilter = filterType;

            $('#jenis_surat_input').val(filterType);

            reloadTable();

            $('#filterMenu').removeClass('show');
        });

        $(document).on('input', '#filter input[name="search"]', debounce(function() {
            let keyword = $(this).val();
            if (keyword.length >= 1 || keyword.length === 0) {
                reloadTable();
            }
        }, 300));

        $(document).on('change', '#filter input[name="start_date"], #filter input[name="end_date"]', function() {
            reloadTable();
        });

        $(document).on('change', '#per_page', function() {
            reloadTable();
        });

        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            let url = $(this).attr('href');
            if (url) {
                reloadTable(url);
            }
        });

        $('#filterMenu').on('click', function(e) {
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
        }
    });

    function submitForm(formId) {
        let form = document.getElementById(formId);
        let formData = new FormData(form);

        const dz = dropzones[formId];
        if (dz) {
            const files = dz.getAcceptedFiles();
            if (files.length > 0) {
                files.forEach((file) => {
                    formData.append('dokumen_surat', file);
                });
            }
        }

        fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: formData,
            })
            .then(async response => {
                const data = await response.json();

                if (!response.ok) {
                    $('.modal.show').modal('hide');
                    console.log('Error response from controller:', data);

                    if (data.errors) {
                        for (let field in data.errors) {
                            let msg = data.errors[field].join(', ');
                            toastr.error(msg, "Error!");
                        }
                    } else {
                        toastr.error(data.message || "Gagal menyimpan data", "Error!");
                    }
                } else {
                    $('.modal.show').modal('hide');
                    toastr.success(data.message || "Data berhasil disimpan", "Success!");

                    form.reset();
                    if (dropzones[formId]) {
                        dropzones[formId].removeAllFiles();
                    }

                    reloadTable();
                }
            })
            .catch(error => {
                $('.modal.show').modal('hide');
                console.error('Fetch error:', error);
                toastr.error("Terjadi kesalahan. Silakan coba lagi.", "Error!");
            });
    }

    function deleteItem(formId) {
        if (confirm('Apakah Anda yakin ingin menghapus surat ini?')) {
            fetch(document.getElementById(formId).action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: new FormData(document.getElementById(formId))
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    toastr.success(data.message || "Data berhasil dihapus", "Success!");
                    reloadTable();
                } else {
                    toastr.error(data.message || "Gagal menghapus data", "Error!");
                }
            })
            .catch(error => {
                console.error('Delete error:', error);
                toastr.error("Terjadi kesalahan. Silakan coba lagi.", "Error!");
            });
        }
    }
</script>
@endsection