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

        .btn-add-prestasi {
            background: linear-gradient(135deg, #F8285A 0%, #e91e63 100%);
            border: none;
            border-radius: 8px;
            padding: 12px 24px;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(248, 40, 90, 0.3);
        }

        .btn-add-prestasi:hover {
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
            width: 50px;
            text-align: center;
        }

        .table th:nth-child(2),
        .table td:nth-child(2) {
            width: 120px;
            text-align: center;
        }

        .table th:nth-child(3),
        .table td:nth-child(3) {
            width: 120px;
            text-align: center;
        }

        .table th:nth-child(4),
        .table td:nth-child(4) {
            width: 120px;
            text-align: center;
        }

        .table th:nth-child(5),
        .table td:nth-child(5) {
            width: 120px;
            text-align: center;
        }

        .table th:nth-child(6),
        .table td:nth-child(6) {
            width: 120px;
            text-align: center;
        }

        .table th:nth-child(7),
        .table td:nth-child(7) {
            width: 120px;
            text-align: center;
        }

        .table th:nth-child(8),
        .table td:nth-child(8) {
            width: 120px;
            text-align: center;
        }

        .table th:nth-child(9),
        .table td:nth-child(9) {
            width: 120px;
            text-align: center;
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
        .table td:nth-child(3),
        .table td:nth-child(5),
        .table td:nth-child(6),
        .table td:nth-child(8),
        .table td:nth-child(9) {
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

        .stats-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 12px;
            padding: 20px;
            color: white;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: none;
            min-width: 280px;
        }

        .stats-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .stats-card .card-icon {
            width: 50px;
            height: 50px;
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
        }

        .stats-card .card-icon i {
            font-size: 24px;
            color: white;
        }

        .stats-card .card-title {
            font-size: 0.9rem;
            font-weight: 500;
            opacity: 0.9;
            margin-bottom: 5px;
        }

        .stats-card .card-value {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0;
        }

        .stats-card .card-subtitle {
            font-size: 0.8rem;
            opacity: 0.8;
            margin-top: 5px;
        }

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
    </style>

    <div class="notification-toast">
        @if (session('success'))
            <div class="toast show align-items-center text-white border-0 @if (session('action') === 'store') toast-success @elseif(session('action') === 'update') toast-warning @elseif(session('action') === 'destroy') toast-error @endif"
                role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <i
                            class="fas @if (session('action') === 'store') fa-check-circle @elseif(session('action') === 'update') fa-exclamation-circle @elseif(session('action') === 'destroy') fa-trash-alt @endif me-2"></i>
                        {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
        @endif
    </div>

    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="table-container">
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
                                            placeholder="Cari berdasarkan nama...">
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

                        @if (isset($prestasis) && $prestasis->isEmpty())
                            <div class="empty-state">
                                <i class="fas fa-trophy fs-3x mb-3"></i>
                                <h4>Belum ada data prestasi.</h4>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover align-middle" id="kt_datatable_prestasi">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Prestasi</th>
                                            <th>Cabor</th>
                                            <th>Tingkat</th>
                                            <th>Tempat & Tahun</th>
                                            <th>Medali</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (isset($prestasis))
                                            @forelse ($prestasis as $key => $prestasi)
                                                @php
                                                    $caborNama = $prestasi->subject->cabangOlahraga
                                                        ? $prestasi->subject->cabangOlahraga->nama_cabor
                                                        : '-';
                                                    $jenisKelamin = '';
                                                    if ($prestasi->subject_type === 'App\Models\Atlet') {
                                                        $jenisKelamin =
                                                            $prestasi->subject->jenis_kelamin == 'L'
                                                                ? 'Laki-laki'
                                                                : 'Perempuan';
                                                    } elseif ($prestasi->subject_type === 'App\Models\Pelatih') {
                                                        $jenisKelamin =
                                                            $prestasi->subject->kelamin == 'L'
                                                                ? 'Laki-laki'
                                                                : 'Perempuan';
                                                    }
                                                @endphp
                                                <tr data-tahun="{{ $prestasi->tahun }}"
                                                    data-nama="{{ $prestasi->subject->nama }}">

                                                    <td></td>

                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            @if ($prestasi->subject->foto_atlet ?? ($prestasi->subject->foto_pelatih ?? null))
                                                                <img src="{{ asset('storage/' . ($prestasi->subject->foto_atlet ?? $prestasi->subject->foto_pelatih)) }}"
                                                                    alt="{{ $prestasi->subject->nama }}"
                                                                    class="rounded-circle me-2 object-fit-cover"
                                                                    width="40" height="40">
                                                            @else
                                                                <div class="rounded-circle bg-light me-2 d-flex align-items-center justify-content-center"
                                                                    style="width: 40px; height: 40px;">
                                                                    <i class="fas fa-user text-muted"></i>
                                                                </div>
                                                            @endif
                                                            <div>
                                                                <strong>{{ $prestasi->subject->nama }}</strong><br>
                                                                <small class="text-muted">
                                                                    {{ class_basename($prestasi->subject_type) }}
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </td>

                                                    <td>{{ $jenisKelamin }}</td>

                                                    <td>
                                                        <div class="text-truncate-custom">{{ $prestasi->nama_prestasi }}
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <div class="text-truncate-custom">{{ $caborNama }}</div>
                                                    </td>

                                                    <td>{{ $prestasi->tingkat }}</td>

                                                    <td>
                                                        <div class="d-flex flex-column">
                                                            <span
                                                                class="text-truncate-custom">{{ $prestasi->tempat }}</span>
                                                            <small class="text-muted">{{ $prestasi->tahun }}</small>
                                                        </div>
                                                    </td>

                                                    <td>
                                                        @php
                                                            $iconColor = '';
                                                            switch ($prestasi->medali) {
                                                                case 'Emas':
                                                                    $iconColor = 'text-warning';
                                                                    break;
                                                                case 'Perak':
                                                                    $iconColor = 'text-secondary';
                                                                    break;
                                                                case 'Perunggu':
                                                                    $iconColor = 'text-bronze';
                                                                    break;
                                                                default:
                                                                    $iconColor = 'text-primary';
                                                                    break;
                                                            }
                                                        @endphp
                                                        <span>
                                                            <i class="fas fa-medal me-1 {{ $iconColor }}"></i>
                                                            {{ $prestasi->medali }}
                                                        </span>
                                                    </td>

                                                    <td class="text-center">
                                                        <div class="d-flex justify-content-center gap-1">
                                                            <a href="{{ route('admin.konfigurasi.prestasi.edit', $prestasi->id) }}"
                                                                class="btn btn-icon btn-sm btn-light-warning"
                                                                title="Edit">
                                                                <i class="fa-solid fa-pen-to-square"></i>
                                                            </a>
                                                            <form
                                                                action="{{ route('admin.konfigurasi.prestasi.destroy', $prestasi->id) }}"
                                                                method="POST" class="d-inline"
                                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="btn btn-icon btn-sm btn-light-danger"
                                                                    title="Hapus">
                                                                    <i class="fa-solid fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="9" class="text-center py-5 text-muted">Data tidak
                                                        ditemukan</td>
                                                </tr>
                                            @endforelse
                                        @endif
                                    </tbody>
                                </table>
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

                                    @if (isset($prestasis) && method_exists($prestasis, 'hasPages'))
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="d-flex align-items-center">
                                                <span class="me-2">Page</span>
                                                <select class="form-select form-select-sm" style="width: 80px;"
                                                    onchange="window.location.href = this.value">
                                                    @for ($i = 1; $i <= $prestasis->lastPage(); $i++)
                                                        <option value="{{ $prestasis->url($i) }}"
                                                            {{ $prestasis->currentPage() == $i ? 'selected' : '' }}>
                                                            {{ $i }}
                                                        </option>
                                                    @endfor
                                                </select>
                                                <span class="ms-2">of {{ $prestasis->lastPage() }}</span>
                                            </div>

                                            <div class="btn-group">
                                                <a href="{{ $prestasis->previousPageUrl() }}"
                                                    class="btn btn-outline-secondary {{ $prestasis->onFirstPage() ? 'disabled' : '' }}">
                                                    <i class="fas fa-chevron-left"></i>
                                                </a>
                                                <a href="{{ $prestasis->nextPageUrl() }}"
                                                    class="btn btn-outline-secondary {{ !$prestasis->hasMorePages() ? 'disabled' : '' }}">
                                                    <i class="fas fa-chevron-right"></i>
                                                </a>
                                            </div>
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
    @if (isset($prestasis) && $prestasis->isNotEmpty())
        <script>
            $(document).ready(function() {
                const table = $("#kt_datatable_prestasi").DataTable({
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
                        }
                    ]
                });

                const totalCount = table.rows().count();

                const uniqueYears = new Set();
                table.rows().every(function() {
                    const tahun = $(this.node()).data('tahun');
                    if (tahun) {
                        uniqueYears.add(tahun);
                    }
                });

                const sortedYears = Array.from(uniqueYears).sort().reverse();
                const filterTahun = $('#filter-tahun');
                sortedYears.forEach(function(year) {
                    filterTahun.append(new Option(year, year));
                });

                table.on('draw.dt', function() {
                    const pageInfo = table.page.info();
                    table.column(0, {
                        page: 'current'
                    }).nodes().each(function(cell, i) {
                        cell.innerHTML = i + 1 + pageInfo.start;
                    });
                });

                table.draw();

                $('#search').on('keyup', function() {
                    const searchValue = this.value.toLowerCase();

                    table.rows().every(function() {
                        const row = this.node();
                        const $row = $(row);
                        const nama = $row.data('nama').toLowerCase();

                        if (nama.includes(searchValue)) {
                            $(row).show();
                        } else {
                            $(row).hide();
                        }
                    });

                    updateFilterInfo();
                });

                $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                    const row = table.row(dataIndex).node();
                    const $row = $(row);

                    const tahunFilter = $('#filter-tahun').val();
                    const rowTahun = $row.data('tahun');

                    if (tahunFilter && rowTahun !== tahunFilter) return false;

                    return true;
                });

                $('#apply-filters').on('click', function() {
                    table.draw();
                    updateFilterInfo();
                    updateFilterCount();
                    $('.dropdown-toggle').dropdown('hide');
                });

                $('#reset-filters').on('click', function() {
                    $('#filter-tahun').val('');
                    $('#search').val('');

                    table.rows().every(function() {
                        $(this.node()).show();
                    });

                    table.search('').draw();
                    updateFilterInfo();
                    updateFilterCount();
                    $('.dropdown-toggle').dropdown('hide');
                });

                function updateFilterCount() {
                    const activeFilters = [];

                    if ($('#filter-tahun').val()) activeFilters.push('tahun');

                    const count = activeFilters.length;
                    const badge = $('#filter-count');

                    if (count > 0) {
                        badge.text(count).removeClass('d-none');
                    } else {
                        badge.addClass('d-none');
                    }
                }

                function updateFilterInfo() {
                    const visibleRows = table.rows(':visible').count();
                    $('#showing-count').text(visibleRows);
                    $('#total-count').text(totalCount);
                }

                setTimeout(function() {
                    $('.notification-toast .toast').toast('hide');
                }, 5000);

                updateFilterInfo();
                updateFilterCount();

                $('#filter-tahun').on('change', function() {
                    updateFilterCount();
                });
                $('[data-bs-toggle="tooltip"]').each(function() {
                    new bootstrap.Tooltip(this);
                });
            });
        </script>
    @endif
@endsection
