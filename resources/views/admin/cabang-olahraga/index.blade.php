@extends('layouts.app')

@section('pageTitle', 'Cabang Olahraga')
@section('mainSection', 'Konfigurasi')
@section('currentSection', 'Cabang Olahraga')

@php
    if (!function_exists('sortIcon')) {
    function sortIcon($field)
    {
        $currentSort = request('sort_by');
        $currentOrder = request('order');

        if ($currentSort === $field) {
            return $currentOrder === 'asc'
                ? '<i class="fas fa-sort-up"></i>'
                : '<i class="fas fa-sort-down"></i>';
        }

        return '<i class="fas fa-sort text-muted"></i>';
    }
}

if (!function_exists('sortUrl')) {
    function sortUrl($field)
    {
        $currentSort = request('sort_by');
        $currentOrder = request('order');

        $order = ($currentSort === $field && $currentOrder === 'asc')
            ? 'desc'
            : 'asc';

        return request()->fullUrlWithQuery([
            'sort_by' => $field,
            'order' => $order
        ]);
    }
}
@endphp

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
                                        placeholder="Cari cabang olahraga..." value="">
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
                            <table class="table table-hover align-middle" id="caborTable">
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
                                                <td>{{ $loop->iteration + ($cabors->currentPage() - 1) * $cabors->perPage() }}</td>

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

@section('script')
<script>
$(document).ready(function() {
    console.log('Initializing cabor table filters...');

    // Get the table and rows
    const caborTable = $('#caborTable');
    const caborRows = caborTable.find('tbody tr');
    const totalRows = caborRows.length;

    console.log('Found table with', totalRows, 'rows');

    // Search function
    $('#search').on('keyup', function() {
        const searchText = $(this).val().toLowerCase();
        console.log('Search input:', searchText);
        filterCaborTable(searchText, $('#filter-status').val());
        updateCaborInfo();
    });

    // Apply filters button
    $('#apply-filters').on('click', function() {
        console.log('Apply filters clicked');
        const searchText = $('#search').val().toLowerCase();
        const statusFilter = $('#filter-status').val();
        filterCaborTable(searchText, statusFilter);
        updateCaborFilterCount();
        updateCaborInfo();
    });

    // Reset filters button
    $('#reset-filters').on('click', function() {
        console.log('Reset filters clicked');
        $('#search').val('');
        $('#filter-status').val('');
        filterCaborTable('', '');
        updateCaborFilterCount();
        updateCaborInfo();
    });

    // Auto-apply filter when status dropdown changes
    $('#filter-status').on('change', function() {
        console.log('Status filter changed:', $(this).val());
        const searchText = $('#search').val().toLowerCase();
        const statusFilter = $(this).val();
        filterCaborTable(searchText, statusFilter);
        updateCaborFilterCount();
        updateCaborInfo();
    });

    // Main filter function
    function filterCaborTable(searchText, statusFilter) {
        console.log('Filtering with search:', searchText, 'status:', statusFilter);
        let visibleCount = 0;

        caborRows.each(function() {
            const row = $(this);

            // Get data from different columns
            const namaCabor = row.find('td:nth-child(2)').text().toLowerCase(); // Nama Cabor
            const ketuaPj = row.find('td:nth-child(3)').text().toLowerCase();   // Ketua PJ
            const statusBadge = row.find('td:nth-child(4) .badge').text().toLowerCase(); // Status from badge

            // Check search match (search in nama_cabor and ketua_pj)
            const cocokSearch = namaCabor.includes(searchText) ||
                               ketuaPj.includes(searchText) ||
                               searchText === '';

            // Check status filter match
            const cocokFilter = statusBadge.includes(statusFilter.toLowerCase()) ||
                               statusFilter === '';

            // Show/hide row based on filters
            if (cocokSearch && cocokFilter) {
                row.show();
                visibleCount++;
            } else {
                row.hide();
            }
        });

        console.log('Visible rows after filter:', visibleCount);

        // Update info display
        $('#showing-count').text(visibleCount);
        $('#total-count').text(totalRows);

        // Show "no data" message if no rows visible
        if (visibleCount === 0) {
            if (caborTable.find('.no-data-row').length === 0) {
                caborTable.find('tbody').append(`
                    <tr class="no-data-row">
                        <td colspan="9" class="text-center py-5 text-muted">
                            Tidak ada data yang cocok dengan filter
                        </td>
                    </tr>
                `);
            }
            caborTable.find('.no-data-row').show();
        } else {
            caborTable.find('.no-data-row').hide();
        }
    }

    // Update filter count badge
    function updateCaborFilterCount() {
        const filterAktif = [];
        if ($('#filter-status').val()) filterAktif.push('status');

        const jumlah = filterAktif.length;
        const badge = $('#filter-count');

        if (jumlah > 0) {
            badge.text(jumlah).removeClass('d-none');
        } else {
            badge.addClass('d-none');
        }

        console.log('Filter count updated:', jumlah);
    }

    // Update info display
    function updateCaborInfo() {
        const visibleRows = caborRows.filter(':visible').length;
        $('#showing-count').text(visibleRows);
        $('#total-count').text(totalRows);
    }

    // Initialize on page load
    updateCaborFilterCount();
    updateCaborInfo();

    console.log('Search input element:', $('#search').length);
    console.log('Filter status element:', $('#filter-status').length);
    console.log('Apply button element:', $('#apply-filters').length);
    console.log('Reset button element:', $('#reset-filters').length);
});
</script>

{{-- Notifikasi --}}
@if(session('cabor_created'))
    <script>$(document).ready(() => toastr.success("{{ session('cabor_created') }}"));</script>
@endif

<style>
/* Additional responsive styles */
@media (max-width: 768px) {
    .d-flex.justify-content-between {
        flex-direction: column;
        align-items: stretch !important;
        gap: 1rem;
    }

    .table-responsive {
        font-size: 0.875rem;
    }
}

@media (max-width: 576px) {
    .table-responsive {
        font-size: 0.875rem;
    }

    .btn-sm {
        padding: 0.375rem 0.5rem;
    }
}

/* Ensure proper horizontal scrolling for table */
.table-responsive {
    -webkit-overflow-scrolling: touch;
    overflow-x: auto;
}

/* Fix for long text overflow */
.text-truncate {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
</style>
@endsection
