@extends('layouts.app')

@section('pageTitle', 'Manajemen Prestasi')
@section('mainSection', 'Konfigurasi')
@section('mainSectionUrl', route('admin.konfigurasi.atlet.index'))
@section('subSection', 'Prestasi')
@section('currentSection', 'Daftar Prestasi')

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

        .btn-add-prestasi {
            background: linear-gradient(135deg, #F8285A 0%, #e91e63 100%);
            border: none;
            border-radius: 8px;
            padding: 12px 24px;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(248, 40, 90, 0.3);
            color: white !important;
            display: inline-flex;
            align-items: center;
            white-space: nowrap;
        }

        .btn-add-prestasi:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(248, 40, 90, 0.4);
            color: white !important;
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
        }

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
        .table td:nth-child(9) {
            text-align: center;
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

        .control-section {
            display: flex;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        .header-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        .header-title {
            margin: 0;
        }

        .header-controls {
            display: flex;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
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

        @media (max-width: 768px) {
            .d-flex.justify-content-between.align-items-center.flex-wrap {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .d-flex.align-items-center.gap-3 {
                width: 100%;
                flex-wrap: wrap;
                gap: 10px !important;
            }

            .btn-add-prestasi {
                order: 1;
                width: 100%;
                justify-content: center;
            }

            .input-group {
                order: 2;
                width: 100% !important;
            }

            .dropdown {
                order: 3;
                width: 100%;
            }

            .dropdown-toggle {
                width: 100%;
            }

            .table-header,
            .table-footer {
                padding: 15px;
            }

            .stats-cards {
                flex-direction: column !important;
            }

            .stats-card {
                margin-bottom: 15px;
            }

            .control-section {
                flex-direction: column;
                gap: 15px;
            }
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

    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="table-header">
                            <div class="header-wrapper">
                                <h3 class="header-title fw-semibold text-dark">Daftar Kejuaraan</h3>
                                <div class="header-controls">
                                    <a href="{{ route('admin.konfigurasi.prestasi.create') }}" class="btn"
                                        style="background-color: #F8285A !important; color: white !important; border-color: #F8285A !important; border-radius: 6px; padding: 10px 15px; font-weight: 500;">
                                        <i class="ki-duotone ki-plus fs-4 me-2" style="color: white !important;"></i>Tambah
                                        Prestasi
                                    </a>

                                    <div class="input-group" style="width: 280px;">
                                        <input type="search" name="search" id="search" class="form-control"
                                            placeholder="Cari berdasarkan nama..." value="{{ request('search') }}">
                                        <button class="btn btn-outline-secondary" type="button">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>

                                    <div class="dropdown">
                                        <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                            data-bs-toggle="dropdown">
                                            <i class="fas fa-filter me-1"></i> Filter
                                            <span id="filter-count"
                                                class="badge badge-circle badge-danger ms-1 d-none">0</span>
                                        </button>
                                        <div class="dropdown-menu p-3 shadow" style="min-width: 280px;">
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">
                                                    <i class="fas fa-calendar-alt me-1"></i>Tahun
                                                </label>
                                                <select id="filter-tahun" class="form-select">
                                                    <option value="">Semua Tahun</option>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">
                                                    <i class="fas fa-medal me-1"></i>Medali
                                                </label>
                                                <select id="filter-medali" class="form-select">
                                                    <option value="">Semua Medali</option>
                                                    <option value="Emas" {{ request('medali') == 'Emas' ? 'selected' : '' }}>Emas</option>
                                                    <option value="Perak" {{ request('medali') == 'Perak' ? 'selected' : '' }}>Perak</option>
                                                    <option value="Perunggu" {{ request('medali') == 'Perunggu' ? 'selected' : '' }}>Perunggu</option>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">
                                                    <i class="fas fa-layer-group me-1"></i>Tingkat
                                                </label>
                                                <select id="filter-tingkat" class="form-select">
                                                    <option value="">Semua Tingkat</option>
                                                    <option value="Nasional" {{ request('tingkat') == 'Nasional' ? 'selected' : '' }}>Nasional</option>
                                                    <option value="Regional" {{ request('tingkat') == 'Regional' ? 'selected' : '' }}>Regional</option>
                                                    <option value="Provinsi" {{ request('tingkat') == 'Provinsi' ? 'selected' : '' }}>Provinsi</option>
                                                    <option value="Kota/Kabupaten" {{ request('tingkat') == 'Kota/Kabupaten' ? 'selected' : '' }}>Kota/Kabupaten</option>
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

                            @if (!(isset($prestasis) && $prestasis->isEmpty()))
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <div id="filter-info" class="text-muted">
                                        Menampilkan <span
                                            id="showing-count">{{ isset($prestasis) ? $prestasis->count() : 0 }}</span> dari
                                        <span id="total-count">{{ isset($prestasis) ? $prestasis->total() : 0 }}</span>
                                        prestasi
                                    </div>
                                </div>
                            @endif
                        </div>
                    <div class="table-container">


                        <div id="prestasi-table-container">
                            @include('admin.prestasi._table')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    @if (isset($prestasis) && $prestasis->isNotEmpty())
        <script>
            $(document).ready(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                function loadTable(url) {
                    $.ajax({
                        url: url,
                        type: 'GET',
                        beforeSend: function() {
                            $('#prestasi-table-container').html(
                                '<div class="text-center py-5">' +
                                '<div class="spinner-border text-primary" role="status">' +
                                '<span class="visually-hidden">Loading...</span>' +
                                '</div></div>'
                            );
                        },
                        success: function(response) {
                            $('#prestasi-table-container').html(response);
                            updateFilterInfo();
                            bindEvents();
                        },
                        error: function(xhr) {
                            console.error('Error:', xhr.responseText);
                            Swal.fire({
                                title: 'Error!',
                                text: 'Gagal memuat data. Silakan coba lagi.',
                                icon: 'error'
                            });
                        }
                    });
                }

                function bindEvents() {
                    $(document).off('click', '.pagination-link')
                        .on('click', '.pagination-link', function(e) {
                            e.preventDefault();
                            const url = $(this).attr('href');
                            if (url && url !== '#') {
                                loadTable(url);
                                window.history.pushState({}, '', url);
                            }
                        });

                    $(document).off('change', 'select[name="per_page"]')
                        .on('change', 'select[name="per_page"]', function() {
                            const url = new URL(window.location.href);
                            url.searchParams.set('per_page', $(this).val());
                            url.searchParams.delete('page'); // Reset to first page
                            loadTable(url.toString());
                            window.history.pushState({}, '', url.toString());
                        });

                    $(document).off('click', '#apply-filters, #reset-filters')
                        .on('click', '#apply-filters, #reset-filters', function() {
                            const isReset = this.id === 'reset-filters';

                            if (isReset) {
                                $('#filter-tahun, #filter-medali, #filter-tingkat').val('');
                            }

                            const params = new URLSearchParams();
                            const add = (key, val) => {
                                if (val && val.trim() !== '') {
                                    params.set(key, val);
                                }
                            };

                            add('search', $('#search').val());
                            add('tahun', $('#filter-tahun').val());
                            add('medali', $('#filter-medali').val());
                            add('tingkat', $('#filter-tingkat').val());
                            add('per_page', $('select[name="per_page"]').val() || '10');

                            const url = new URL(window.location.href);
                            url.search = params.toString();

                            loadTable(url.toString());
                            window.history.pushState({}, '', url.toString());

                            $('.dropdown-toggle').dropdown('hide');
                        });

                    let searchTimeout;
                    $(document).off('input', '#search')
                        .on('input', '#search', function() {
                            clearTimeout(searchTimeout);
                            const searchTerm = $(this).val();

                            searchTimeout = setTimeout(() => {
                                const url = new URL(window.location.href);
                                if (searchTerm.trim()) {
                                    url.searchParams.set('search', searchTerm);
                                } else {
                                    url.searchParams.delete('search');
                                }
                                url.searchParams.delete('page'); // Reset to first page

                                loadTable(url.toString());
                                window.history.pushState({}, '', url.toString());
                            }, 300);
                        });

                    $(document).off('click', '.btn-delete')
                        .on('click', '.btn-delete', function(e) {
                            e.preventDefault();
                            destroyItem(this);
                        });

                    updateFilterBadge();
                }

                function updateFilterBadge() {
                    const activeFilters = [
                        $('#filter-tahun').val(),
                        $('#filter-medali').val(),
                        $('#filter-tingkat').val(),
                        $('#search').val()
                    ].filter(val => val && val.trim() !== '').length;

                    const badge = $('#filter-count');
                    if (activeFilters > 0) {
                        badge.text(activeFilters).removeClass('d-none');
                    } else {
                        badge.addClass('d-none');
                    }
                }

                function updateFilterInfo() {
                    const tableContainer = $('#prestasi-table-container');
                    const rows = tableContainer.find('tbody tr:not(:has(td[colspan]))').length;
                    $('#showing-count').text(rows);
                }

                window.destroyItem = function(button) {
                const route = $(button).data('route');
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
                        form.innerHTML = `
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="DELETE">
                        `;
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

                function populateTahunDropdown() {
                    const tahunSelect = $('#filter-tahun');
                    const currentTahun = new URLSearchParams(window.location.search).get('tahun');

                    $.ajax({
                        url: "{{ route('admin.konfigurasi.prestasi.index') }}",
                        type: 'GET',
                        data: { get_tahun: 1 },
                        success: function(data) {
                            tahunSelect.empty().append('<option value="">Semua Tahun</option>');
                            if (Array.isArray(data)) {
                                data.forEach(function(year) {
                                    const selected = year == currentTahun ? 'selected' : '';
                                    tahunSelect.append(`<option value="${year}" ${selected}>${year}</option>`);
                                });
                            }
                        },
                        error: function(xhr) {
                            console.error('Error loading years:', xhr.responseText);
                        }
                    });
                }

                window.onpopstate = function(event) {
                    loadTable(window.location.href);
                };

                populateTahunDropdown();
                bindEvents();
                updateFilterBadge();
            });
        </script>
    @endif
@endsection
