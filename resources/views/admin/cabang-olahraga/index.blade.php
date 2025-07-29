@extends('layouts.app')

@section('pageTitle', 'Cabang Olahraga')
@section('mainSection', 'Konfigurasi')
@section('currentSection', 'Cabang Olahraga')

@section('content')

<style>
    body {
        background-color: #f5f5f5 !important;
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

    .btn-add-cabor {
        background: linear-gradient(135deg, #F8285A 0%, #e91e63 100%);
        border: none;
        border-radius: 8px;
        padding: 12px 24px;
        font-weight: 600;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(248, 40, 90, 0.3);
    }

    .btn-add-cabor:hover {
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

    .table th:nth-child(1), .table td:nth-child(1) { width: 40px; text-align: center; } /* No */
    .table th:nth-child(2), .table td:nth-child(2) { width: 250px; } /* Nama Cabor */
    .table th:nth-child(3), .table td:nth-child(3) { width: 200px; } /* Ketua Penanggung Jawab */
    .table th:nth-child(4), .table td:nth-child(4) { width: 120px; text-align: center; } /* Status */
    .table th:nth-child(5), .table td:nth-child(5) { width: 150px; } /* Tanggal Pembentukan */
    .table th:nth-child(6), .table td:nth-child(6) { width: 100px; text-align: center; } /* Jumlah Atlet */
    .table th:nth-child(7), .table td:nth-child(7) { width: 100px; text-align: center; } /* Jumlah Pelatih */
    .table th:nth-child(8), .table td:nth-child(8) { width: 150px; } /* Terakhir Update */
    .table th:nth-child(9), .table td:nth-child(9) { width: 120px; text-align: center; } /* Aksi */

    .text-truncate-custom {
        max-width: 180px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .object-fit-cover {
        object-fit: cover;
    }

    .table td:nth-child(1),
    .table td:nth-child(4),
    .table td:nth-child(6),
    .table td:nth-child(7),
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
</style>

<div class="d-flex justify-content-between align-items-center flex-wrap mb-4" style="padding:10px 30px">
    <h2 class="fw-bold fs-2 mb-0 text-dark">Cabang Olahraga</h2>
    <a href="{{ route('admin.konfigurasi.cabang-olahraga.create') }}" class="btn"
        style="background-color: #F8285A !important; color: white !important; border-color: #F8285A !important; border-radius: 8px; padding: 12px 20px; font-weight: 500;">
        <i class="ki-duotone ki-plus fs-4 me-2" style="color: white !important;"></i>Tambah Cabang Olahraga
    </a>
</div>

<div class="main-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="table-container">
                    <div class="table-header">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h3 class="mb-0 fw-semibold text-dark">Informasi Cabang Olahraga</h3>

                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                <div class="input-group" style="width: 250px;">
                                    <input type="search" name="search" id="search" class="form-control"
                                        placeholder="Cari cabang olahraga...">
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
                                            <label class="form-label fw-semibold">Status Keaktifan</label>
                                            <select id="filter-status" class="form-select">
                                                <option value="">Semua Status</option>
                                                <option value="Aktif">Aktif</option>
                                                <option value="Tidak Aktif">Tidak Aktif</option>
                                            </select>
                                        </div>

                                        <div class="d-flex gap-2">
                                            <button type="button" id="apply-filters" class="btn btn-primary btn-sm flex-fill">
                                                <i class="fas fa-check"></i> Terapkan
                                            </button>
                                            <button type="button" id="reset-filters" class="btn btn-light btn-sm flex-fill">
                                                <i class="fas fa-redo"></i> Reset
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if (!(isset($cabors) && $cabors->isEmpty()))
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div id="filter-info" class="text-muted">
                                    Menampilkan <span id="showing-count">{{ isset($cabors) ? $cabors->count() : 0 }}</span> dari <span
                                        id="total-count">{{ isset($cabors) ? $cabors->count() : 0 }}</span> cabang olahraga
                                </div>
                            </div>
                        @endif
                    </div>

                    @if (isset($cabors) && $cabors->isEmpty())
                        <div class="empty-state">
                            <i class="fas fa-info-circle fs-3x mb-3"></i>
                            <h4>Tidak ada data cabang olahraga.</h4>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover align-middle" id="kt_datatable_dom_positioning">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th><a href="{{ sortUrl('nama_cabor') }}" class="text-dark text-decoration-none">Nama Cabor
                                                {!! sortIcon('nama_cabor') !!}</a></th>
                                        <th><a href="{{ sortUrl('ketua_penanggung_jawab') }}"
                                                class="text-dark text-decoration-none">Ketua Penanggung Jawab
                                                {!! sortIcon('ketua_penanggung_jawab') !!}</a></th>
                                        <th><a href="{{ sortUrl('status') }}"
                                                class="text-dark text-decoration-none">Status {!! sortIcon('status') !!}</a></th>
                                        <th><a href="{{ sortUrl('tanggal_pembentukan') }}"
                                                class="text-dark text-decoration-none">Tanggal Pembentukan {!! sortIcon('tanggal_pembentukan') !!}</a></th>
                                        <th>Jumlah Atlet</th>
                                        <th>Jumlah Pelatih</th>
                                        <th><a href="{{ sortUrl('terakhir_update') }}"
                                                class="text-dark text-decoration-none">Terakhir Update {!! sortIcon('terakhir_update') !!}</a>
                                        </th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($cabors))
                                        @forelse ($cabors as $index => $cabor)
                                            <tr data-status="{{ $cabor->status }}">
                                                <td></td> {{-- Will be populated by DataTable --}}

                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        @if ($cabor->icon_cabor)
                                                            <img src="{{ asset('storage/' . $cabor->icon_cabor) }}" width="40" height="40" class="rounded object-fit-cover me-3">
                                                        @else
                                                            <div class="rounded bg-secondary text-white text-center fw-bold d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                                {{ strtoupper(substr($cabor->nama_cabor, 0, 1)) }}
                                                            </div>
                                                        @endif
                                                        <div class="d-flex flex-column">
                                                            <strong class="text-truncate-custom">{{ $cabor->nama_cabor }}</strong>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="text-truncate-custom" title="{{ $cabor->ketua_penanggung_jawab }}">
                                                        {{ $cabor->ketua_penanggung_jawab }}
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge {{ $cabor->status == 'Aktif' ? 'badge-light-success' : 'badge-light-danger' }}">
                                                        {{ $cabor->status }}
                                                    </span>
                                                </td>
                                                <td>
                                                    {{ \Carbon\Carbon::parse($cabor->tanggal_pembentukan)->format('d M Y') }}
                                                </td>
                                                <td>
                                                    {{ $cabor->atlets ? $cabor->atlets->count() : 0 }}
                                                </td>
                                                <td>
                                                    {{ $cabor->pelatihs ? $cabor->pelatihs->count() : 0 }}
                                                </td>
                                                <td>
                                                    {{ $cabor->terakhir_update ? \Carbon\Carbon::parse($cabor->terakhir_update)->format('M d, Y') : '-' }}
                                                </td>
                                                <td class="text-center">
                                                    <div class="d-flex justify-content-center gap-1">
                                                        <a href="{{ route('admin.konfigurasi.cabang-olahraga.show', $cabor->id) }}"
                                                        class="btn btn-icon btn-sm btn-light-primary"
                                                        title="Detail">
                                                            <i class="fa-solid fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('admin.konfigurasi.cabang-olahraga.edit', $cabor->id) }}"
                                                        class="btn btn-icon btn-sm btn-light-warning"
                                                        title="Edit">
                                                            <i class="fa-solid fa-pen-to-square"></i>
                                                        </a>
                                                        <form action="{{ route('admin.konfigurasi.cabang-olahraga.destroy', $cabor->id) }}"
                                                                method="POST"
                                                                class="d-inline"
                                                                onsubmit="return confirm('Yakin ingin menghapus cabang olahraga ini?')">
                                                            @csrf @method('DELETE')
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
                                                <td colspan="9" class="text-center py-5 text-muted">Data tidak ditemukan</td>
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
                                        <select name="per_page" onchange="this.form.submit()" class="form-select form-select-sm w-auto">
                                            @foreach ([10, 25, 50, 100] as $limit)
                                                <option value="{{ $limit }}" {{ request('per_page') == $limit ? 'selected' : '' }}>
                                                    {{ $limit }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <span class="ms-2">per page</span>
                                    </form>
                                </div>

                                @if(isset($cabors) && method_exists($cabors, 'hasPages'))
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="d-flex align-items-center">
                                            <span class="me-2">Page</span>
                                            <select class="form-select form-select-sm" style="width: 80px;"
                                                    onchange="window.location.href = this.value">
                                                @for ($i = 1; $i <= $cabors->lastPage(); $i++)
                                                    <option value="{{ $cabors->url($i) }}"
                                                            {{ $cabors->currentPage() == $i ? 'selected' : '' }}>
                                                        {{ $i }}
                                                    </option>
                                                @endfor
                                            </select>
                                            <span class="ms-2">of {{ $cabors->lastPage() }}</span>
                                        </div>

                                        <div class="btn-group">
                                            <a href="{{ $cabors->previousPageUrl() }}"
                                            class="btn btn-outline-secondary {{ $cabors->onFirstPage() ? 'disabled' : '' }}">
                                                <i class="fas fa-chevron-left"></i>
                                            </a>
                                            <a href="{{ $cabors->nextPageUrl() }}"
                                            class="btn btn-outline-secondary {{ !$cabors->hasMorePages() ? 'disabled' : '' }}">
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

{{-- Bagian script yang diperbaiki --}}
@section('script')
    {{-- Notifikasi untuk Create/Add --}}
    @if(session('cabor_created'))
        <script>
            $(document).ready(function() {
                toastr.success("{{ session('cabor_created') }}");
            });
        </script>
    @endif

    {{-- Notifikasi untuk Update/Edit --}}
    @if(session('cabor_updated'))
        <script>
            $(document).ready(function() {
                toastr.success("{{ session('cabor_updated') }}");
            });
        </script>
    @endif

    {{-- Notifikasi untuk Delete --}}
    @if(session('cabor_deleted'))
        <script>
            $(document).ready(function() {
                toastr.success("{{ session('cabor_deleted') }}");
            });
        </script>
    @endif

    {{-- Notifikasi umum success --}}
    @if(session('success'))
        <script>
            $(document).ready(function() {
                toastr.success("{{ session('success') }}");
            });
        </script>
    @endif

    {{-- Notifikasi umum error --}}
    @if(session('error'))
        <script>
            $(document).ready(function() {
                toastr.error("{{ session('error') }}");
            });
        </script>
    @endif

    {{-- DataTable Script --}}
    @if (isset($cabors) && $cabors->isNotEmpty())
        <script>
            $(document).ready(function() {
                const table = $("#kt_datatable_dom_positioning").DataTable({
                    paging: true, // Ubah ke true
                    pageLength: {{ request('per_page', 10) }}, // Ambil dari parameter per_page
                    lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]], // Opsi per page
                    lengthChange: false, // Disable DataTable length changer karena kita pakai custom
                    info: true, // Enable info
                    searching: true,
                    ordering: true,
                    responsive: false,
                    autoWidth: false,
                    scrollX: false,
                    language: {
                        info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ cabang olahraga",
                        infoEmpty: "Menampilkan 0 sampai 0 dari 0 cabang olahraga",
                        infoFiltered: "(difilter dari _MAX_ total cabang olahraga)",
                        paginate: {
                            first: "Pertama",
                            last: "Terakhir", 
                            next: "Selanjutnya",
                            previous: "Sebelumnya"
                        }
                    },
                    columnDefs: [
                        {
                            searchable: false,
                            orderable: false,
                            targets: 0
                        },
                        {
                            targets: -1,
                            orderable: false,
                            searchable: false
                        },
                        { width: "250px", targets: 1 },
                        { width: "200px", targets: 2 },
                    ],
                    drawCallback: function(settings) {
                        // Update nomor urut
                        const api = this.api();
                        const start = api.page.info().start;
                        api.column(0, {page: 'current'}).nodes().each(function(cell, i) {
                            cell.innerHTML = start + i + 1;
                        });
                        
                        // Update filter info
                        updateCustomFilterInfo();
                    }
                });

                const totalCount = table.rows().count();

                // Custom search
                $('#search').on('keyup', function() {
                    table.search(this.value).draw();
                });

                // Custom filter untuk status
                $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                    const row = table.row(dataIndex).node();
                    const $row = $(row);

                    const statusFilter = $('#filter-status').val();
                    const rowStatus = $row.data('status');

                    if (statusFilter && rowStatus !== statusFilter) return false;

                    return true;
                });

                $('#apply-filters').on('click', function() {
                    table.draw();
                    updateFilterCount();
                    $('.dropdown-toggle').dropdown('hide');
                });

                $('#reset-filters').on('click', function() {
                    $('#filter-status').val('');
                    $('#search').val('');

                    table.search('').draw();
                    updateFilterCount();
                    $('.dropdown-toggle').dropdown('hide');
                });

                function updateFilterCount() {
                    const activeFilters = [];

                    if ($('#filter-status').val()) activeFilters.push('status');

                    const count = activeFilters.length;
                    const badge = $('#filter-count');

                    if (count > 0) {
                        badge.text(count).removeClass('d-none');
                    } else {
                        badge.addClass('d-none');
                    }
                }

                function updateCustomFilterInfo() {
                    const info = table.page.info();
                    $('#showing-count').text(info.recordsDisplay);
                    $('#total-count').text(info.recordsTotal);
                }

                updateFilterCount();

                $('#filter-status').on('change', function() {
                    updateFilterCount();
                });

                // Handle custom per page selector
                $('select[name="per_page"]').on('change', function() {
                    const perPage = $(this).val();
                    // Redirect dengan parameter per_page baru
                    const url = new URL(window.location);
                    url.searchParams.set('per_page', perPage);
                    url.searchParams.delete('page'); // Reset ke halaman 1
                    window.location.href = url.toString();
                });

                // Hide default DataTable pagination karena kita pakai custom
                $('.dataTables_paginate').hide();
                $('.dataTables_info').hide();
                $('.dataTables_length').hide();
            });
        </script>
    @endif
@endsection