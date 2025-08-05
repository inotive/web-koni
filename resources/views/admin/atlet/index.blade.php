@extends('layouts.app')

@section('pageTitle', 'Manajemen Atlet')
@section('mainSection', 'Konfigurasi')
@section('currentSection', 'Atlet')

@section('content')

    <style>
        body {
            background-color: #f5f5f5;
        }

        .main-content {
            background-color: #f5f5f5;
            min-height: 100vh;
            padding: 20px 0;
        }

        .table-container {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
            border: 1px solid #e9ecef;
            overflow: hidden;
        }

        .table-header {
            background-color: white;
            padding: 20px 25px;
            border-bottom: 1px solid #e9ecef;
        }

        .table-footer {
            background-color: white;
            padding: 15px 25px;
            border-top: 1px solid #e9ecef;
        }

        .empty-state {
            text-align: center;
            color: #6c757d;
            padding: 60px 25px;
            background-color: white;
        }

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

        .btn-add-atlet {
            background: linear-gradient(135deg, #F8285A 0%, #e91e63 100%);
            border: none;
            border-radius: 8px;
            padding: 12px 24px;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(248, 40, 90, 0.3);
        }

        .btn-add-atlet:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(248, 40, 90, 0.4);
        }

        .table-responsive {
            overflow-x: auto;
            overflow-y: visible;
            -webkit-overflow-scrolling: touch;
            border-radius: 0;
            border: none;
        }

        .table {
            border-collapse: collapse !important;
            border-spacing: 0 !important;
            margin: 0 !important;
            background-color: white;
            width: 100%;
            min-width: 1200px;
        }

        .table thead th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            border-left: none !important;
            border-right: none !important;
            border-top: none !important;
            font-weight: 600;
            font-size: 0.875rem;
            color: #495057;
            white-space: nowrap;
            padding: 12px 8px !important;
            position: static;
            text-align: center !important;
            /* Header tabel tetap di tengah */
        }

        .table tbody tr td {
            border-left: none !important;
            border-right: none !important;
            padding: 8px !important;
            font-size: 0.875rem;
            border-bottom: 1px solid #e9ecef;
            white-space: nowrap;
            vertical-align: middle;
            word-wrap: break-word;
            max-width: 200px;
            text-align: left !important;
            /* Isi tabel rata kiri */
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        .table td:first-child,
        .table th:first-child {
            padding-left: 12px !important;
        }

        .table td:last-child,
        .table th:last-child {
            padding-right: 12px !important;
        }

        .table th:nth-child(1),
        .table td:nth-child(1) {
            width: 40px;
            text-align: center !important;
            /* Kolom nomor tetap di tengah */
        }

        /* No */
        .table th:nth-child(2),
        .table td:nth-child(2) {
            width: 50px;
            text-align: center;
        }

        /* Foto */
        .table th:nth-child(3),
        .table td:nth-child(3) {
            width: 140px;
            text-align: center;
        }

        /* Nama & Cabor */
        .table th:nth-child(4),
        .table td:nth-child(4) {
            width: 110px;
            text-align: center;
        }

        /* Tempat & Tanggal Lahir */
        .table th:nth-child(5),
        .table td:nth-child(5) {
            width: 100px;
            text-align: center;
        }

        /* Alamat */
        .table th:nth-child(6),
        .table td:nth-child(6) {
            width: 70px;
            text-align: center;
        }

        /* Jenis Kelamin */
        .table th:nth-child(7),
        .table td:nth-child(7) {
            width: 80px;
            text-align: center;
        }

        /* Usia */
        .table th:nth-child(8),
        .table td:nth-child(8) {
            width: 80px;
            text-align: center;
        }

        /* Telepon */
        .table th:nth-child(9),
        .table td:nth-child(9) {
            width: 110px;
            text-align: center;
        }

        /* Email */
        .table th:nth-child(10),
        .table td:nth-child(10) {
            width: 120px;
            text-align: center;
        }

        /* Prestasi */
        .table th:nth-child(11),
        .table td:nth-child(11) {
            width: 90px;
            text-align: center;
        }

        /* Tanggal Update */
        .table th:nth-child(12),
        .table td:nth-child(12) {
            width: 80px;
            text-align: center;
        }

        /* Aksi */

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

        .table td:nth-child(1),
        .table td:nth-child(2),
        .table td:nth-child(6),
        .table td:nth-child(7),
        .table td:nth-child(12) {
            text-align: center;
        }

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
        }

        .dropdown-menu {
            border: none;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            border-radius: 8px;
        }

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

        .badge-circle {
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
        }

        /* Notification styles */
        .notification-toast {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            min-width: 300px;
        }

        .toast-success {
            background-color: #51a351;
            color: white;
        }

        .toast-error {
            background-color: #bd362f;
            color: white;
        }

        .toast-warning {
            background-color: #f89406;
            color: white;
        }

        .toast-info {
            background-color: #2f96b4;
            color: white;
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

        .pagination {
            margin-bottom: 0;
        }

        .pagination .page-item {
            margin: 0 1px;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
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
    </style>

    @if (session('success'))
        <div class="alert alert-{{ session('action') === 'store' ? 'success' : (session('action') === 'update' ? 'warning' : 'danger') }} alert-dismissible fade show"
            role="alert">
            <i
                class="fas {{ session('action') === 'store' ? 'fa-check-circle' : (session('action') === 'update' ? 'fa-exclamation-circle' : 'fa-trash-alt') }} me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center flex-wrap mb-4" style="padding:10px 30px">
        <h2 class="fw-bold fs-2 mb-0 text-dark">Atlet</h2>
        <a href="{{ route('admin.konfigurasi.atlet.create') }}" class="btn"
            style="background-color: #F8285A !important; color: white !important; border-color: #F8285A !important; border-radius: 8px; padding: 12px 20px; font-weight: 500;">
            <i class="ki-duotone ki-plus fs-4 me-2" style="color: white !important;"></i>Tambah Atlet
        </a>
    </div>

    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="table-header">
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
                                                @if (isset($allCabor))
                                                    @foreach ($allCabor as $id => $nama)
                                                        <option value="{{ $nama }}">{{ $nama }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Jenis Kelamin</label>
                                            <select id="filter-gender" class="form-select">
                                                <option value="">Semua</option>
                                                <option value="Laki-laki">Laki-laki</option>
                                                <option value="Perempuan">Perempuan</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Rentang Usia</label>
                                            <select id="filter-age" class="form-select">
                                                <option value="">Semua Usia</option>
                                                <option value="15-20">15-20 tahun</option>
                                                <option value="21-25">21-25 tahun</option>
                                                <option value="26-30">26-30 tahun</option>
                                                <option value="31-35">31-35 tahun</option>
                                                <option value="36+">36+ tahun</option>
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

                        @if (!(isset($atlets) && $atlets->isEmpty()))
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div id="filter-info" class="text-muted">
                                    Menampilkan <span id="showing-count">{{ isset($atlets) ? $atlets->count() : 0 }}</span>
                                    dari <span id="total-count">{{ isset($atlets) ? $atlets->total() : 0 }}</span> atlet
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="table-container">


                        @if (isset($atlets) && $atlets->isEmpty())
                            <div class="empty-state">
                                <i class="fas fa-info-circle fs-3x mb-3"></i>
                                <h4>Tidak ada data atlet.</h4>
                            </div>
                        @else
                            <div class="table-container">
                                @include('admin.atlet._table')
                            </div>
                            <div class="table-footer">
                                <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap">
                                    <div class="mb-2 mb-md-0">
                                        <form method="GET" class="d-flex align-items-center">
                                            <span class="me-2">Show</span>
                                            <select name="per_page" onchange="this.form.submit()"
                                                class="form-select form-select-sm w-auto">
                                                @foreach ([10, 25, 50, 100] as $limit)
                                                    <option value="{{ $limit }}"
                                                        {{ request('per_page') == $limit ? 'selected' : '' }}>
                                                        {{ $limit }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span class="ms-2">per page</span>
                                        </form>
                                    </div>

                                    @if (isset($atlets) && method_exists($atlets, 'hasPages') && $atlets->hasPages())
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="text-muted small">
                                                {{ $atlets->firstItem() }}-{{ $atlets->lastItem() }} of
                                                {{ $atlets->total() }}
                                            </div>

                                            <div class="d-flex align-items-center gap-2">
                                                @if ($atlets->onFirstPage())
                                                    <span class="pagination-arrow disabled">←</span>
                                                @else
                                                    <a href="{{ $atlets->previousPageUrl() }}" class="pagination-arrow"
                                                        aria-label="Previous">←</a>
                                                @endif

                                                @php
                                                    $current = $atlets->currentPage();
                                                    $total = $atlets->lastPage();
                                                    $start = max(1, $current - 2);
                                                    $end = min($total, $current + 2);

                                                    if ($end - $start < 4) {
                                                        if ($start == 1) {
                                                            $end = min($total, $start + 4);
                                                        } else {
                                                            $start = max(1, $end - 4);
                                                        }
                                                    }
                                                @endphp

                                                <div class="d-flex align-items-center">
                                                    @for ($i = $start; $i <= $end; $i++)
                                                        @if ($i == $current)
                                                            <span
                                                                class="pagination-number active">{{ $i }}</span>
                                                        @else
                                                            <a href="{{ $atlets->url($i) }}"
                                                                class="pagination-number">{{ $i }}</a>
                                                        @endif
                                                    @endfor
                                                </div>

                                                @if ($atlets->hasMorePages())
                                                    <a href="{{ $atlets->nextPageUrl() }}" class="pagination-arrow"
                                                        aria-label="Next">→</a>
                                                @else
                                                    <span class="pagination-arrow disabled">→</span>
                                                @endif
                                            </div>
                                        </div>
                                    @elseif(isset($atlets) && method_exists($atlets, 'hasPages'))
                                        <div class="text-muted small">
                                            1-{{ $atlets->count() }} of {{ $atlets->total() }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    @if (isset($atlets) && $atlets->isNotEmpty())
        <script>
  $(document).ready(function() {
    // Fungsi untuk memuat tabel via AJAX
    function loadTable(url) {
        $.ajax({
            url: url,
            type: 'GET',
            beforeSend: function() {
                // Tampilkan loading indicator
                $('.table-container').html('<div class="text-center py-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>');
            },
            success: function(response) {
                $('.table-container').html(response);
                initTableFunctions();
                initDataTable();
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                Swal.fire({
                    title: "Error!",
                    text: "Gagal memuat data",
                    icon: "error"
                });
            }
        });
    }

    // Inisialisasi DataTable
    function initDataTable() {
        const table = $("#kt_datatable_dom_positioning").DataTable({
            paging: false,
            info: false,
            searching: true,
            ordering: true,
            responsive: false,
            autoWidth: false,
            scrollX: false,
            columnDefs: [{
                    searchable: false,
                    orderable: false,
                    targets: 0
                },
                {
                    targets: -1,
                    orderable: false,
                    searchable: false
                },
                {
                    width: "60px",
                    targets: 1
                },
                {
                    width: "150px",
                    targets: 2
                },
            ],
            order: [
                [1, 'asc']
            ],
        });

        // Update nomor urut setelah sorting
        table.on('order.dt', function() {
            const info = table.page.info();
            const start = info.start;
            table.column(0, { search: 'applied', order: 'applied' }).nodes().each(function(cell, i) {
                cell.innerHTML = start + i + 1;
            });
        }).draw();

        // Handle pencarian di DataTable
        $('#search').on('keyup', function() {
            table.search(this.value).draw();
            updateFilterInfo(table);
        });

        // Custom filter untuk DataTable
        $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
            const row = table.row(dataIndex).node();
            const $row = $(row);

            const caborFilter = $('#filter-cabor').val();
            const genderFilter = $('#filter-gender').val();
            const ageFilter = $('#filter-age').val();
            const prestasiFilter = $('#filter-prestasi').val();

            const rowCabor = $row.data('cabor');
            const rowGender = $row.data('gender');
            const rowAge = parseInt($row.data('age'));
            const rowPrestasi = $row.data('prestasi');
            const rowMedali = $row.data('medali');

            if (caborFilter && rowCabor !== caborFilter) return false;
            if (genderFilter && rowGender !== genderFilter) return false;

            if (ageFilter) {
                if (ageFilter === '36+') {
                    if (rowAge < 36) return false;
                } else {
                    const [minAge, maxAge] = ageFilter.split('-').map(age => parseInt(age));
                    if (rowAge < minAge || rowAge > maxAge) return false;
                }
            }

            if (prestasiFilter) {
                if (prestasiFilter === 'ada' && rowPrestasi !== 'ada') return false;
                if (prestasiFilter === 'tidak' && rowPrestasi !== 'tidak') return false;
                if (prestasiFilter === 'emas' && rowMedali !== 'emas') return false;
                if (prestasiFilter === 'perak' && rowMedali !== 'perak') return false;
                if (prestasiFilter === 'perunggu' && rowMedali !== 'perunggu') return false;
            }

            return true;
        });

        return table;
    }

    // Inisialisasi fungsi-fungsi tabel setelah dimuat via AJAX
    function initTableFunctions() {
        // Event handler untuk pagination link
        $(document).off('click', '.pagination-link').on('click', '.pagination-link', function(e) {
            e.preventDefault();
            const url = $(this).attr('href');
            if (url) {
                loadTable(url);
                history.pushState(null, null, url);
            }
        });

        // Event handler untuk per page select
        $(document).off('change', 'select[name="per_page"]').on('change', 'select[name="per_page"]', function() {
            const perPage = $(this).val();
            const currentUrl = new URL(window.location.href);
            currentUrl.searchParams.set('per_page', perPage);
            loadTable(currentUrl.toString());
            history.pushState(null, null, currentUrl.toString());
        });

        // Event handler untuk tombol filter
        $(document).off('click', '#apply-filters, #reset-filters').on('click', '#apply-filters, #reset-filters', function() {
            const isReset = $(this).attr('id') === 'reset-filters';

            if (isReset) {
                $('#filter-cabor').val('');
                $('#filter-gender').val('');
                $('#filter-age').val('');
                $('#filter-prestasi').val('');
                $('#search').val('');
            }

            const formData = {
                cabor: $('#filter-cabor').val(),
                gender: $('#filter-gender').val(),
                age: $('#filter-age').val(),
                prestasi: $('#filter-prestasi').val(),
                search: $('#search').val(),
                per_page: $('select[name="per_page"]').val()
            };

            const currentUrl = new URL(window.location.href);
            Object.keys(formData).forEach(key => {
                if (formData[key]) {
                    currentUrl.searchParams.set(key, formData[key]);
                } else {
                    currentUrl.searchParams.delete(key);
                }
            });

            loadTable(currentUrl.toString());
            history.pushState(null, null, currentUrl.toString());
            $('.dropdown-toggle').dropdown('hide');
        });

        // Event handler untuk tombol search
        $(document).off('keyup', '#search').on('keyup', '#search', function(e) {
            if (e.key === 'Enter') {
                $('#apply-filters').click();
            }
        });

        // Update filter count
        updateFilterCount();
    }

    // Update filter info
    function updateFilterInfo(table) {
        const showingCount = table.rows({ search: 'applied' }).count();
        const totalCount = table.rows().count();
        $('#showing-count').text(showingCount);
        $('#total-count').text(totalCount);
    }

    // Update filter count badge
    function updateFilterCount() {
        const activeFilters = [];

        if ($('#filter-cabor').val()) activeFilters.push('cabor');
        if ($('#filter-gender').val()) activeFilters.push('gender');
        if ($('#filter-age').val()) activeFilters.push('age');
        if ($('#filter-prestasi').val()) activeFilters.push('prestasi');

        const count = activeFilters.length;
        const badge = $('#filter-count');

        if (count > 0) {
            badge.text(count).removeClass('d-none');
        } else {
            badge.addClass('d-none');
        }
    }

    // Handle perubahan filter dropdown
    $(document).on('change', '#filter-cabor, #filter-gender, #filter-age, #filter-prestasi', function() {
        updateFilterCount();
    });

    // Handle browser back/forward buttons
    window.onpopstate = function() {
        loadTable(window.location.href);
    };

    // Inisialisasi pertama kali
    initTableFunctions();
    initDataTable();
});

// Fungsi destroyItem
window.destroyItem = function(button) {
    const route = button.dataset.route;

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

            const token = document.createElement('input');
            token.type = 'hidden';
            token.name = '_token';
            token.value = '{{ csrf_token() }}';

            const method = document.createElement('input');
            method.type = 'hidden';
            method.name = '_method';
            method.value = 'DELETE';

            form.appendChild(token);
            form.appendChild(method);
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
        </script>
    @endif
@endsection
