@extends('layouts.app')

@section('pageTitle', 'Pelatih')
@section('mainSection', 'Konfigurasi')
@section('currentSection', 'Pelatih')
{{-- @php
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
@endphp --}}

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

    .container-fluid {
        padding: 0 15px;
        max-width: none;
    }

    .d-flex.justify-content-between.align-items-center.flex-wrap {
        flex-wrap: wrap !important;
        gap: 15px;
    }

    .table-container {
        background-color: white;
        border-radius: 0px 0px 20px 20px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        border: 1px solid #e9ecef;
        overflow: hidden;
        width: 100%;
    }

    .table-header {
        background-color: white;
        padding: 20px 25px;
        border-bottom: 1px solid #e9ecef;
        overflow: visible;
    }

    .table-footer {
        background-color: white;
        padding: 15px 25px;
        border-top: 1px solid #e9ecef;
        overflow: visible;
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

    .btn-add-pelatih {
        background: linear-gradient(135deg, #F8285A 0%, #e91e63 100%);
        border: none;
        border-radius: 8px;
        padding: 12px 24px;
        font-weight: 600;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(248, 40, 90, 0.3);
    }

    .btn-add-pelatih:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(248, 40, 90, 0.4);
    }

    .table-responsive {
        overflow-x: auto !important;
        overflow-y: visible !important;
        -webkit-overflow-scrolling: touch;
        border-radius: 0;
        border: none;
        width: 100%;
    }

    .table {
        border-collapse: collapse !important;
        border-spacing: 0 !important;
        margin: 0 !important;
        background-color: white;
        width: 100%;
        min-width: 1200px !important;
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
    .table th:nth-child(2), .table td:nth-child(2) { width: 50px; text-align: center; } /* Foto */
    .table th:nth-child(3), .table td:nth-child(3) { width: 140px; } /* Nama & Cabor */
    .table th:nth-child(4), .table td:nth-child(4) { width: 110px; } /* Tempat & Tanggal Lahir */
    .table th:nth-child(5), .table td:nth-child(5) { width: 100px; } /* Alamat */
    .table th:nth-child(6), .table td:nth-child(6) { width: 70px; text-align: center; } /* Jenis Kelamin */
    .table th:nth-child(7), .table td:nth-child(7) { width: 50px; text-align: center; } /* Usia */
    .table th:nth-child(8), .table td:nth-child(8) { width: 110px; } /* Telepon */
    .table th:nth-child(9), .table td:nth-child(9) { width: 110px; } /* Email */
    .table th:nth-child(10), .table td:nth-child(10) { width: 120px; } /* Prestasi */
    .table th:nth-child(11), .table td:nth-child(11) { width: 90px; } /* Tanggal Update */
    .table th:nth-child(12), .table td:nth-child(12) { width: 80px; text-align: center; } /* Aksi */

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

    /* Updated filter dropdown styles */
    .dropdown-menu.filter-dropdown {
        min-height: auto !important;
        max-height: min(50vh, 350px) !important;
        overflow-y: auto;
        overflow-x: hidden;
        width: 320px;
    }

    .table thead th {
        text-align: center !important;
    }

    .table tbody td {
        text-align: left !important;
    }

    /* Ensure search and filter controls are responsive */
    .d-flex.align-items-center.gap-2.flex-wrap {
        flex-wrap: wrap;
        gap: 10px;
    }

    .input-group {
        min-width: 200px;
        flex: 1;
        max-width: 300px;
    }

    /* Improved filter dropdown scrollbar */
    .dropdown-menu.filter-dropdown::-webkit-scrollbar {
        width: 6px;
    }

    .dropdown-menu.filter-dropdown::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
    }

    .dropdown-menu.filter-dropdown::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 3px;
    }

    .dropdown-menu.filter-dropdown::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }

    /* Improved filter dropdown spacing */
    .dropdown-menu .form-label {
        font-size: 0.875rem;
        margin-bottom: 0.5rem;
    }

    .dropdown-menu .form-select {
        font-size: 0.875rem;
        padding: 0.5rem 0.75rem;
    }

    .dropdown-menu .mb-3 {
        margin-bottom: 1rem !important;
    }

    .dropdown-menu .d-flex.gap-2 {
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid #e9ecef;
    }

    /* Responsive breakpoints for better mobile experience */
    @media (max-width: 1200px) {
        .d-flex.justify-content-between.align-items-center.flex-wrap {
            padding: 10px 15px; /* Reduce padding on smaller screens */
        }

        .table-header,
        .table-footer {
            padding: 15px 20px; /* Reduce padding */
        }
    }

    @media (max-width: 768px) {
        .d-flex.justify-content-between.align-items-center.flex-wrap {
            padding: 10px;
            flex-direction: column;
            align-items: stretch;
        }

        .d-flex.justify-content-between.align-items-center.flex-wrap h2 {
            text-align: center;
            margin-bottom: 15px;
        }

        .table-header,
        .table-footer {
            padding: 15px;
        }

        .d-flex.justify-content-between.align-items-center.mb-3 {
            flex-direction: column;
            gap: 15px;
            align-items: stretch;
        }

        .d-flex.align-items-center.gap-2.flex-wrap {
            justify-content: center;
            width: 100%;
            flex-wrap: wrap;
        }

        .input-group {
            width: 100% !important;
            max-width: none !important;
        }
    }

    @media (max-width: 576px) {
        .btn {
            width: 100%;
            margin-bottom: 10px;
        }

        .d-flex.align-items-center.gap-2.flex-wrap {
            flex-direction: column;
            gap: 10px;
        }

        .input-group {
            margin-bottom: 10px;
        }

        .dropdown-menu.filter-dropdown {
            width: calc(100vw - 30px);
            max-width: 350px;
            left: 15px !important;
            right: 15px !important;
            transform: none !important;
        }
    }

    .pagination .page-link {
        border: none;
        color: #6c757d;
        margin: 0 2px;
        border-radius: 6px;
    }

    .pagination .page-item.active .page-link {
        background-color: #f1f3f5;
        color: #000;
        font-weight: bold;
    }

</style>

<!-- Page Header - This should be outside main-content for full responsiveness -->
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center flex-wrap mb-4" style="padding:10px 30px">
        <h2 class="fw-bold fs-2 mb-0 text-dark">Pelatih</h2>
        <a href="{{ route('admin.konfigurasi.pelatih.create') }}" class="btn"
            style="background-color: #F8285A !important; color: white !important; border-color: #F8285A !important; border-radius: 8px; padding: 12px 20px; font-weight: 500;">
            <i class="ki-duotone ki-plus fs-4 me-2" style="color: white !important;"></i>Tambah Pelatih
        </a>
    </div>
</div>

<div class="main-content">
    <div class="container-fluid">
        <div class="col-12">
            <!-- Table Header - This is responsive -->
            <div class="table-header" style="border-radius: 20px 20px 0px 0px">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3 class="mb-0 fw-semibold text-dark">Informasi Pelatih</h3>

                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <div class="input-group" style="width: 250px;">
                            <input type="search" name="search" id="search" class="form-control"
                                placeholder="Cari pelatih...">
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
                            <div class="dropdown-menu filter-dropdown p-3 shadow" style="min-width: 320px;">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Cabang Olahraga</label>
                                    <select id="filter-cabor" class="form-select">
                                        <option value="">Semua Cabor</option>
                                        @if(isset($allCabor))
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
                                        @if(isset($allKelamin))
                                            @foreach ($allKelamin as $kelamin)
                                                <option value="{{ $kelamin }}">{{ $kelamin }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Rentang Usia</label>
                                    <select id="filter-age" class="form-select">
                                        <option value="">Semua Usia</option>
                                        <option value="20-30">20-30 tahun</option>
                                        <option value="31-40">31-40 tahun</option>
                                        <option value="41-50">41-50 tahun</option>
                                        <option value="51-60">51-60 tahun</option>
                                        <option value="60+">60+ tahun</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Status Prestasi</label>
                                    <select id="filter-prestasi" class="form-select">
                                        <option value="">Semua</option>
                                        <option value="ada">Ada Prestasi</option>
                                        <option value="tidak">Tidak Ada Prestasi</option>
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

                @if (!(isset($pelatih) && $pelatih->isEmpty()))
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div id="filter-info" class="text-muted">
                            Menampilkan <span id="showing-count">{{ isset($pelatih) ? $pelatih->count() : 0 }}</span> dari <span
                                id="total-count">{{ isset($pelatih) ? $pelatih->count() : 0 }}</span> pelatih
                        </div>
                    </div>
                @endif
            </div>

            <!-- Table Container - Only this part scrolls horizontally -->
            <div class="table-container">
                @if (isset($pelatih) && $pelatih->isEmpty())
                    <div class="empty-state">
                        <i class="fas fa-info-circle fs-3x mb-3"></i>
                        <h4>Tidak ada data pelatih.</h4>
                    </div>
                @else
                    <!-- Only this div has horizontal scroll -->
                    <div class="table-responsive">
                        <table class="table table-hover align-middle" id="kt_datatable_dom_positioning">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Foto</th>
                                    <th>
                                        Nama Pelatih & Cabor
                                        <i class="fas fa-sort text-muted"></i>
                                    </th>
                                    <th>
                                        Tempat & Tanggal Lahir
                                        <i class="fas fa-sort text-muted"></i>
                                    </th>
                                    <th>
                                        Alamat
                                        <i class="fas fa-sort text-muted"></i>
                                    </th>
                                    <th>
                                        Kelamin
                                        <i class="fas fa-sort text-muted"></i>
                                    </th>
                                    <th>
                                        Usia
                                        <i class="fas fa-sort text-muted"></i>
                                    </th>
                                    <th>
                                        Telepon
                                        <i class="fas fa-sort text-muted"></i>
                                    </th>
                                    <th>
                                        Email
                                        <i class="fas fa-sort text-muted"></i>
                                    </th>
                                    <th>
                                        Prestasi Terbaru
                                        <i class="fas fa-sort text-muted"></i>
                                    </th>
                                    <th>
                                        Terakhir Diupdate
                                        <i class="fas fa-sort text-muted"></i>
                                    </th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($pelatih))
                                    @forelse ($pelatih as $index => $item)
                                        @php
                                            $age = $item->tanggal_lahir ? \Carbon\Carbon::parse($item->tanggal_lahir)->age : 0;
                                            $hasPrestasi = isset($item->prestasis) && $item->prestasis->isNotEmpty() ? 'ada' : 'tidak';
                                            $prestasiTerbaru = isset($item->prestasis) && $item->prestasis->isNotEmpty() ? $item->prestasis->first() : null;
                                            $caborNama = $item->cabangOlahraga ? $item->cabangOlahraga->nama_cabor : '-';
                                            $medaliType = $prestasiTerbaru ? strtolower($prestasiTerbaru->medali) : '';
                                        @endphp
                                        <tr data-cabor="{{ $caborNama }}" data-gender="{{ $item->kelamin }}"
                                            data-age="{{ $age }}"
                                            data-prestasi="{{ $hasPrestasi }}"
                                            data-medali="{{ $medaliType }}">

                                            <td></td> {{-- Will be populated by DataTable --}}

                                            <td>
                                                @if ($item->foto)
                                                    <img src="{{ Storage::url($item->foto) }}" width="40" height="40" class="rounded-circle object-fit-cover">
                                                @else
                                                    <div class="rounded-circle bg-secondary text-white text-center fw-bold" style="width: 40px; height: 40px; line-height: 40px;">
                                                        {{ strtoupper(substr($item->nama, 0, 1)) }}
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column">
                                                    <strong class="text-truncate-custom">{{ $item->nama }}</strong>
                                                    <small class="text-muted">{{ $caborNama }}</small>
                                                </div>
                                            </td>
                                            <td>
                                                @if($item->tanggal_lahir)
                                                    <div class="d-flex flex-column">
                                                        <span class="text-truncate-custom">{{ \Carbon\Carbon::parse($item->tanggal_lahir)->format('d M Y') }}</span>
                                                        @if($item->tempat_lahir)
                                                            <small class="text-muted text-truncate-custom">{{ $item->tempat_lahir }}</small>
                                                        @endif
                                                    </div>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($item->alamat)
                                                    @php
                                                        $alamatParts = explode(' ', $item->alamat);
                                                        $lastWord = array_pop($alamatParts);
                                                        $restOfAddress = implode(' ', $alamatParts);
                                                    @endphp
                                                    <div class="d-flex flex-column">
                                                        <strong><span class="fw-bold text-dark text-truncate-custom">{{ $lastWord }}</span></strong>
                                                        <span class="text-muted small text-truncate-custom">{{ $restOfAddress }}</span>
                                                    </div>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>{{ $item->kelamin }}</td>
                                            <td>{{ $age }} Tahun</td>
                                            <td>
                                                <div class="text-truncate-custom">{{ $item->no_telepon ?? '-' }}</div>
                                            </td>
                                            <td>
                                                <div class="text-truncate-custom" title="{{ $item->email }}">
                                                    {{ $item->email ?? '-' }}</div>
                                            </td>
                                            <td>
                                                @if($prestasiTerbaru)
                                                    <div class="d-flex align-items-center">
                                                        <div class="me-2">
                                                            @if($medaliType === 'emas')
                                                                <i class="fas fa-medal text-warning"></i>
                                                            @elseif($medaliType === 'perak')
                                                                <i class="fas fa-medal text-secondary"></i>
                                                            @elseif($medaliType === 'perunggu')
                                                                <i class="fas fa-medal text-bronze"></i>
                                                            @endif
                                                        </div>
                                                    <div class="d-flex flex-column">
                                                        <span class="text-truncate-custom">{{ $prestasiTerbaru->nama_prestasi }}</span>
                                                        <small class="text-muted">{{ $prestasiTerbaru->tahun }}@if($prestasiTerbaru->tempat) • {{ $prestasiTerbaru->tempat }}@endif</small>
                                                    </div>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{ \Carbon\Carbon::parse($item->updated_at)->format('M d, Y') }}</td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center gap-1">
                                                    <a href="{{ route('admin.konfigurasi.pelatih.show', $item->id) }}"
                                                    class="btn btn-icon btn-sm btn-light-primary"
                                                    title="Detail">
                                                        <i class="fa-solid fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.konfigurasi.pelatih.edit', $item->id) }}"
                                                    class="btn btn-icon btn-sm btn-light-warning"
                                                    title="Edit">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </a>
                                                    <form action="{{ route('admin.konfigurasi.pelatih.destroy', $item->id) }}"
                                                            method="POST"
                                                            class="d-inline"
                                                            onsubmit="return confirm('Yakin ingin menghapus pelatih ini?')">
                                                        @csrf @method('DELETE')
                                                        <button type="button"
                                                            class="btn btn-icon btn-sm btn-light-danger"
                                                            data-route="{{ route('admin.konfigurasi.pelatih.destroy', $item->id) }}"
                                                            onclick="destroyItem(this)"
                                                            title="Hapus">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="12" class="text-center py-5 text-muted">Data tidak ditemukan</td>
                                        </tr>
                                    @endforelse
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <!-- Table Footer - This is responsive -->
                    <div class="table-footer mt-3">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">

                            {{-- Left: Show per page --}}
                            <div class="d-flex align-items-center mb-2 mb-md-0">
                                <span class="me-2">Show</span>
                                <select class="form-select form-select-sm w-auto me-2" onchange="window.location.href='?perPage='+this.value">
                                    @foreach([10,25,50,100] as $size)
                                        <option value="{{ $size }}" {{ request('perPage', 10) == $size ? 'selected' : '' }}>
                                            {{ $size }}
                                        </option>
                                    @endforeach
                                </select>
                                <span>per page</span>
                            </div>

                            {{-- Right: X–Y of Z + compact pagination --}}
                            <div class="d-flex align-items-center gap-3 mb-2 mb-md-0">

                                {{-- Showing X–Y of Z --}}
                                <div class="text-muted small">
                                    @if($pelatih->total() > 0)
                                        {{ $pelatih->firstItem() }}–{{ $pelatih->lastItem() }} of {{ $pelatih->total() }}
                                    @else
                                        0 of 0
                                    @endif
                                </div>

                                {{-- Compact pagination --}}
                                @if($pelatih->hasPages())
                                    <nav>
                                        <ul class="pagination mb-0 justify-content-end flex-wrap">

                                            {{-- Previous --}}
                                            <li class="page-item {{ $pelatih->onFirstPage() ? 'disabled' : '' }}">
                                                <a class="page-link" href="{{ $pelatih->previousPageUrl() }}" aria-label="Previous">
                                                    <span aria-hidden="true">&lsaquo;</span>
                                                </a>
                                            </li>

                                            {{-- Page Numbers --}}
                                            @php
                                                $current = $pelatih->currentPage();
                                                $last = $pelatih->lastPage();
                                                $start = max($current - 2, 1);
                                                $end = min($current + 2, $last);
                                            @endphp

                                            @if($start > 1)
                                                <li class="page-item"><a class="page-link" href="{{ $pelatih->url(1) }}">1</a></li>
                                                @if($start > 2)
                                                    <li class="page-item disabled"><span class="page-link">…</span></li>
                                                @endif
                                            @endif

                                            @for ($i = $start; $i <= $end; $i++)
                                                <li class="page-item {{ $current == $i ? 'active' : '' }}">
                                                    <a class="page-link" href="{{ $pelatih->url($i) }}">{{ $i }}</a>
                                                </li>
                                            @endfor

                                            @if($end < $last)
                                                @if($end < $last - 1)
                                                    <li class="page-item disabled"><span class="page-link">…</span></li>
                                                @endif
                                                <li class="page-item"><a class="page-link" href="{{ $pelatih->url($last) }}">{{ $last }}</a></li>
                                            @endif

                                            {{-- Next --}}
                                            <li class="page-item {{ !$pelatih->hasMorePages() ? 'disabled' : '' }}">
                                                <a class="page-link" href="{{ $pelatih->nextPageUrl() }}" aria-label="Next">
                                                    <span aria-hidden="true">&rsaquo;</span>
                                                </a>
                                            </li>

                                        </ul>
                                    </nav>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
    @if (isset($pelatih) && $pelatih->isNotEmpty())
        <script>
            $(document).ready(function() {
                const table = $("#kt_datatable_dom_positioning").DataTable({
                    paging: false,
                    info: false,
                    searching: true,
                    ordering: true,
                    responsive: false,
                    autoWidth: false,
                    scrollX: false,
                    order: [], // No initial sort
                    columnDefs: [
                        {
                            searchable: false,
                            orderable: false,
                            targets: 0 // No column
                        },
                        {
                            targets: 1, // Foto column
                            orderable: false
                        },
                        {
                            targets: -1, // Aksi column
                            orderable: false,
                            searchable: false
                        },
                        { width: "60px", targets: 1 },
                        { width: "150px", targets: 2 },
                    ]
                });

                const totalCount = table.rows().count();

                table.on('order.dt', function() {
                    updateSortIcons();
                });

                function updateSortIcons() {
                    $('th i').removeClass('fa-sort-up fa-sort-down').addClass('fa-sort text-muted');

                    const currentOrder = table.order();

                    if (currentOrder.length > 0) {
                        const columnIndex = currentOrder[0][0];
                        const direction = currentOrder[0][1];

                        const thElement = $('th').eq(columnIndex);
                        const icon = thElement.find('i');

                        if (icon.length > 0) {
                            icon.removeClass('fa-sort text-muted');
                            if (direction === 'asc') {
                                icon.addClass('fa-sort-up');
                            } else {
                                icon.addClass('fa-sort-down');
                            }
                        }
                    }
                }

                table.on('draw.dt', function () {
                    const pageInfo = table.page.info();
                    table.column(0, { page: 'current' }).nodes().each(function (cell, i) {
                        cell.innerHTML = i + 1 + pageInfo.start;
                    });
                });

                table.draw();

                $('#search').on('keyup', function() {
                    table.search(this.value).draw();
                    updateFilterInfo();
                });

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

                    if (caborFilter && rowCabor !== caborFilter) return false;
                    if (genderFilter && rowGender !== genderFilter) return false;

                    if (ageFilter) {
                        if (ageFilter === '60+') {
                            if (rowAge < 60) return false;
                        } else {
                            const [minAge, maxAge] = ageFilter.split('-').map(age => parseInt(age));
                            if (rowAge < minAge || rowAge > maxAge) return false;
                        }
                    }

                    if (prestasiFilter) {
                        if (prestasiFilter === 'ada' && rowPrestasi !== 'ada') return false;
                        if (prestasiFilter === 'tidak' && rowPrestasi !== 'tidak') return false;
                    }

                    return true;
                });

                $('#apply-filters').on('click', function() {
                    table.draw();
                    updateFilterInfo();
                    updateFilterCount();
                    $('.dropdown-toggle').dropdown('hide');
                });

                $('#reset-filters').on('click', function() {
                    $('#filter-cabor').val('');
                    $('#filter-gender').val('');
                    $('#filter-age').val('');
                    $('#filter-prestasi').val('');
                    $('#search').val('');

                    table.search('').draw();
                    updateFilterInfo();
                    updateFilterCount();

                    table.order([]).draw();
                    $('th i').removeClass('fa-sort-up fa-sort-down').addClass('fa-sort text-muted');

                    $('.dropdown-toggle').dropdown('hide');
                });

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

                function updateFilterInfo() {
                    const info = table.page.info();
                    const showingCount = info.recordsDisplay;
                    $('#showing-count').text(showingCount);
                    $('#total-count').text(totalCount);
                }

                updateFilterInfo();
                updateFilterCount();

                $('#filter-cabor, #filter-gender, #filter-age, #filter-prestasi').on('change', function() {
                    updateFilterCount();
                });
            });
        </script>
        <script>
            const destroyItem = (el) => {
                const route = $(el).data('route');

                Swal.fire({
                    title: "Apakah Anda yakin?",
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    cancelButtonText: "Batalkan!",
                    confirmButtonText: "Hapus!",

                }).then((result) => {
                    if (result.isConfirmed) {
                        const form = $('<form>', {
                            action: route,
                            method: 'POST',
                            style: 'display:none'
                        });

                        const csrfInput = $('<input>', {
                            type: 'hidden',
                            name: '_token',
                            value: '{{ csrf_token() }}'
                        });

                        const methodInput = $('<input>', {
                            type: 'hidden',
                            name: '_method',
                            value: 'DELETE'
                        });

                        form.append(csrfInput, methodInput).appendTo('body').submit();
                    }
                });
            };
        </script>
    @endif
@endsection
