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
                return $currentOrder === 'asc' ? '<i class="fas fa-sort-up"></i>' : '<i class="fas fa-sort-down"></i>';
            }

            return '<i class="fas fa-sort text-muted"></i>';
        }
    }

    if (!function_exists('sortUrl')) {
        function sortUrl($field)
        {
            $currentSort = request('sort_by');
            $currentOrder = request('order');

            $order = $currentSort === $field && $currentOrder === 'asc' ? 'desc' : 'asc';

            return request()->fullUrlWithQuery([
                'sort_by' => $field,
                'order' => $order,
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

        .table th:nth-child(1),
        .table td:nth-child(1) {
            width: 40px;
            text-align: center;
        }

        /* No */
        .table th:nth-child(2),
        .table td:nth-child(2) {
            width: 250px;
        }

        /* Nama Cabor */
        .table th:nth-child(3),
        .table td:nth-child(3) {
            width: 200px;
        }

        /* Ketua Penanggung Jawab */
        .table th:nth-child(4),
        .table td:nth-child(4) {
            width: 120px;
            text-align: center;
        }

        /* Status */
        .table th:nth-child(5),
        .table td:nth-child(5) {
            width: 150px;
        }

        /* Tanggal Pembentukan */
        .table th:nth-child(6),
        .table td:nth-child(6) {
            width: 100px;
            text-align: center;
        }

        /* Jumlah Atlet */
        .table th:nth-child(7),
        .table td:nth-child(7) {
            width: 100px;
            text-align: center;
        }

        /* Jumlah Pelatih */
        .table th:nth-child(8),
        .table td:nth-child(8) {
            width: 150px;
        }

        /* Terakhir Update */
        .table th:nth-child(9),
        .table td:nth-child(9) {
            width: 120px;
            text-align: center;
        }

        /* Aksi */

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

        /* Custom pagination styles */
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

        /* Pagination dots style */
        .pagination-dots {
            color: #6c757d;
            padding: 6px 4px;
            font-size: 0.875rem;
        }

        /* Per page selector styling */
        .form-select-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            border-radius: 0.375rem;
            border: 1px solid #dee2e6;
            background-color: #fff;
            min-width: 70px;
        }

        .form-select-sm:focus {
            border-color: #F8285A;
            box-shadow: 0 0 0 0.2rem rgba(248, 40, 90, 0.25);
        }

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

            .pagination-arrow,
            .pagination-number {
                padding: 4px 6px;
                font-size: 0.75rem;
            }
            
            .table-footer .d-flex.justify-content-between {
                flex-direction: column;
                gap: 1rem;
                align-items: center !important;
            }
            
            .d-flex.align-items-center.gap-2.flex-wrap {
                flex-direction: column;
                align-items: center !important;
                gap: 0.5rem !important;
            }
            
            .form-select-sm {
                min-width: 60px;
                font-size: 0.75rem;
                padding: 0.2rem 0.4rem;
            }
        }

        @media (max-width: 576px) {
            .table-responsive {
                font-size: 0.875rem;
            }

            .btn-sm {
                padding: 0.375rem 0.5rem;
            }
            
            .table-footer {
                padding: 10px 15px;
            }
            
            .text-muted {
                font-size: 0.8rem;
                text-align: center;
            }
            
            .form-label {
                font-size: 0.8rem;
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

        .btn-icon.btn-sm {
            width: 32px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0;
        }

        .btn-light-danger[style*="opacity"] {
            cursor: not-allowed;
        }

        #dependencyList {
            padding-left: 1.5rem;
        }

        #dependencyList li {
            margin-bottom: 0.25rem;
            color: #dc3545;
        }

        /* Loading state styles */
        .table-loading {
            position: relative;
        }

        .table-loading::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10;
        }

        .loading-spinner {
            border: 2px solid #f3f3f3;
            border-top: 2px solid #F8285A;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
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
                            <div class="d-flex justify-content-between align-items-center mb-">
                                <h2 class="mb-0 fw-semibold text-dark">Table Daftar Cabor Tabalong</h2>

                                <div class="d-flex align-items-center gap-9 flex-wrap">
                                    <!-- Search Box Form -->
                                    <form method="GET" action="{{ request()->url() }}" id="searchForm" class="d-flex">
                                        <div class="input-group border rounded" style="width: 230px;">
                                            <span class="input-group-text bg-transparent border-0">
                                                <i class="fas fa-search"></i>
                                            </span>
                                            <input type="search" name="search" id="search"
                                                class="form-control border-0 py-2" placeholder="Search Teams..." 
                                                value="{{ request('search') }}">
                                        </div>
                                        <!-- Hidden inputs to preserve other parameters -->
                                        <input type="hidden" name="status" value="{{ request('status') }}">
                                        <input type="hidden" name="per_page" value="{{ request('per_page', 10) }}">
                                        <input type="hidden" name="sort_by" value="{{ request('sort_by') }}">
                                        <input type="hidden" name="order" value="{{ request('order') }}">
                                    </form>

                                    <!-- Filter Button with Icon on Right -->
                                    <div class="border rounded" style="width: 120px; border-width: 1px !important;">
                                        <button
                                            class="btn bg-white dropdown-toggle w-100 text-start border-0 py-2 d-flex justify-content-between align-items-center"
                                            type="button" data-bs-toggle="dropdown">
                                            <span>Filter</span>
                                            <div>
                                                <i class="fas fa-filter ms-1"></i>
                                                <span id="filter-count"
                                                    class="badge badge-circle badge-danger ms-1 {{ request('status') ? '' : 'd-none' }}">
                                                    {{ request('status') ? '1' : '0' }}
                                                </span>
                                            </div>
                                        </button>
                                        <div class="dropdown-menu p-3 shadow" style="min-width: 320px;">
                                            <form method="GET" action="{{ request()->url() }}" id="filterForm">
                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">Status Keaktifan</label>
                                                    <select id="filter-status" name="status" class="form-select">
                                                        <option value="">Semua Status</option>
                                                        <option value="Aktif" {{ request('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                                        <option value="Tidak Aktif" {{ request('status') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                                    </select>
                                                </div>

                                                <!-- Hidden inputs to preserve other parameters -->
                                                <input type="hidden" name="search" value="{{ request('search') }}">
                                                <input type="hidden" name="per_page" value="{{ request('per_page', 10) }}">
                                                <input type="hidden" name="sort_by" value="{{ request('sort_by') }}">
                                                <input type="hidden" name="order" value="{{ request('order') }}">

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
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if (!(isset($cabors) && $cabors->isEmpty()))
                                <div class="d-flex justify-content-between align-items-center mb">
                                </div>
                            @endif
                        </div>

                        @if (isset($cabors) && $cabors->isEmpty())
                            <div class="empty-state">
                                <i class="fas fa-info-circle fs-3x mb-3"></i>
                                <h4>Tidak ada data cabang olahraga.</h4>
                            </div>
                        @else
                            <div class="table-responsive" id="tableContainer">
                                <table class="table table-hover align-middle" id="caborTable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th><a href="{{ sortUrl('nama_cabor') }}"
                                                    class="text-dark text-decoration-none">Nama Cabor
                                                    {!! sortIcon('nama_cabor') !!}</a></th>
                                            <th><a href="{{ sortUrl('ketua_penanggung_jawab') }}"
                                                    class="text-dark text-decoration-none">Ketua Penanggung Jawab
                                                    {!! sortIcon('ketua_penanggung_jawab') !!}</a></th>
                                            <th><a href="{{ sortUrl('status') }}"
                                                    class="text-dark text-decoration-none">Status
                                                    {!! sortIcon('status') !!}</a></th>
                                            <th><a href="{{ sortUrl('tanggal_pembentukan') }}"
                                                    class="text-dark text-decoration-none">Tanggal Pembentukan
                                                    {!! sortIcon('tanggal_pembentukan') !!}</a></th>
                                            <th>Jumlah Atlet</th>
                                            <th>Jumlah Pelatih</th>
                                            <th><a href="{{ sortUrl('terakhir_update') }}"
                                                    class="text-dark text-decoration-none">Terakhir Update
                                                    {!! sortIcon('terakhir_update') !!}</a>
                                            </th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (isset($cabors))
                                            @forelse ($cabors as $index => $cabor)
                                                <tr data-status="{{ $cabor->status }}">
                                                    <td>{{ $loop->iteration + ($cabors->currentPage() - 1) * $cabors->perPage() }}
                                                    </td>

                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            @if ($cabor->icon_cabor)
                                                                <img src="{{ asset('storage/' . $cabor->icon_cabor) }}"
                                                                    width="40" height="40"
                                                                    class="rounded object-fit-cover me-3">
                                                            @else
                                                                <div class="rounded bg-secondary text-white text-center fw-bold d-flex align-items-center justify-content-center me-3"
                                                                    style="width: 40px; height: 40px;">
                                                                    {{ strtoupper(substr($cabor->nama_cabor, 0, 1)) }}
                                                                </div>
                                                            @endif
                                                            <div class="d-flex flex-column">
                                                                <strong
                                                                    class="text-truncate-custom">{{ $cabor->nama_cabor }}</strong>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-truncate-custom"
                                                            title="{{ $cabor->ketua_penanggung_jawab }}">
                                                            {{ $cabor->ketua_penanggung_jawab }}
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="badge {{ $cabor->status == 'Aktif' ? 'badge-light-success' : 'badge-light-danger' }}">
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

                                                            @php
                                                                $jumlahAtlet = $cabor->atlets
                                                                    ? $cabor->atlets->count()
                                                                    : 0;
                                                                $jumlahPelatih = $cabor->pelatihs
                                                                    ? $cabor->pelatihs->count()
                                                                    : 0;
                                                                $totalData = $jumlahAtlet + $jumlahPelatih;
                                                            @endphp

                                                            @if ($totalData > 0)
                                                                <button type="button"
                                                                    class="btn btn-icon btn-sm btn-light-danger"
                                                                    title="Tidak dapat dihapus - Ada {{ $totalData }} data terkait"
                                                                    onclick="showDeleteWarning('{{ $cabor->nama_cabor }}', {{ $jumlahAtlet }}, {{ $jumlahPelatih }})"
                                                                    style="opacity: 0.6;">
                                                                    <i class="fa-solid fa-trash"></i>
                                                                </button>
                                                            @else
                                                                <form
                                                                    action="{{ route('admin.konfigurasi.cabang-olahraga.destroy', $cabor->id) }}"
                                                                    method="POST" class="d-inline"
                                                                    onsubmit="return confirmDelete('{{ $cabor->nama_cabor }}')">
                                                                    @csrf @method('DELETE')
                                                                    <button type="submit"
                                                                        class="btn btn-icon btn-sm btn-light-danger"
                                                                        title="Hapus">
                                                                        <i class="fa-solid fa-trash"></i>
                                                                    </button>
                                                                </form>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="9" class="text-center py-5 text-muted">
                                                        @if(request('search') || request('status'))
                                                            <i class="fas fa-search fs-3x mb-3 text-muted"></i>
                                                            <h4>Tidak ada data yang cocok dengan pencarian</h4>
                                                            <p class="mb-0">Coba ubah kata kunci atau filter yang digunakan</p>
                                                        @else
                                                            Tidak ada data cabang olahraga
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforelse
                                        @endif
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination Section -->
                            @if (isset($cabors) && $cabors->total() > 0)
                                <div class="table-footer">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                                        <!-- Per page selector & Info -->
                                        <div class="d-flex align-items-center gap-2 flex-wrap">
                                            <div class="d-flex align-items-center gap-2">
                                                <label class="form-label mb-0">Tampilkan:</label>
                                                <form method="GET" action="{{ request()->url() }}" id="perPageForm">
                                                    <select class="form-select form-select-sm" style="width: auto;" name="per_page" onchange="this.form.submit()">
                                                        <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                                                        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                                                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                                        <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                                                    </select>
                                                    <!-- Preserve current parameters -->
                                                    <input type="hidden" name="search" value="{{ request('search') }}">
                                                    <input type="hidden" name="status" value="{{ request('status') }}">
                                                    <input type="hidden" name="sort_by" value="{{ request('sort_by') }}">
                                                    <input type="hidden" name="order" value="{{ request('order') }}">
                                                </form>
                                                <span class="text-muted">data per halaman</span>
                                            </div>
                                            
                                            <div class="text-muted">
                                                Menampilkan {{ $cabors->count() }} dari {{ $cabors->total() }} total data
                                                @if(request('search') || request('status'))
                                                    <br><small class="text-info">
                                                        (Hasil pencarian/filter: 
                                                        @if(request('search'))
                                                            "{{ request('search') }}"
                                                        @endif
                                                        @if(request('status'))
                                                            Status: {{ request('status') }}
                                                        @endif
                                                        )
                                                    </small>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Pagination Controls -->
                                        <div class="d-flex align-items-center gap-3">
                                            <!-- Range Info -->
                                            <div class="text-muted">
                                                @php
                                                    $from = ($cabors->currentPage() - 1) * $cabors->perPage() + 1;
                                                    $to = min($from + $cabors->count() - 1, $cabors->total());
                                                @endphp
                                                {{ $from }}-{{ $to }} of {{ $cabors->total() }}
                                            </div>
                                            
                                            @if ($cabors->hasPages())
                                                <!-- Previous Page Link -->
                                                @if ($cabors->onFirstPage())
                                                    <span class="pagination-arrow disabled">
                                                        <i class="fas fa-chevron-left"></i>
                                                    </span>
                                                @else
                                                    <a href="{{ $cabors->appends(request()->query())->previousPageUrl() }}" class="pagination-arrow">
                                                        <i class="fas fa-chevron-left"></i>
                                                    </a>
                                                @endif

                                                <!-- Pagination Elements -->
                                                @php
                                                    $start = max(1, $cabors->currentPage() - 2);
                                                    $end = min($cabors->lastPage(), $cabors->currentPage() + 2);
                                                @endphp

                                                @if($start > 1)
                                                    <a href="{{ $cabors->appends(request()->query())->url(1) }}" class="pagination-number">1</a>
                                                    @if($start > 2)
                                                        <span class="pagination-dots">...</span>
                                                    @endif
                                                @endif

                                                @for ($page = $start; $page <= $end; $page++)
                                                    @if ($page == $cabors->currentPage())
                                                        <span class="pagination-number active">{{ $page }}</span>
                                                    @else
                                                        <a href="{{ $cabors->appends(request()->query())->url($page) }}" class="pagination-number">{{ $page }}</a>
                                                    @endif
                                                @endfor

                                                @if($end < $cabors->lastPage())
                                                    @if($end < $cabors->lastPage() - 1)
                                                        <span class="pagination-dots">...</span>
                                                    @endif
                                                    <a href="{{ $cabors->appends(request()->query())->url($cabors->lastPage()) }}" class="pagination-number">{{ $cabors->lastPage() }}</a>
                                                @endif

                                                <!-- Next Page Link -->
                                                @if ($cabors->hasMorePages())
                                                    <a href="{{ $cabors->appends(request()->query())->nextPageUrl() }}" class="pagination-arrow">
                                                        <i class="fas fa-chevron-right"></i>
                                                    </a>
                                                @else
                                                    <span class="pagination-arrow disabled">
                                                        <i class="fas fa-chevron-right"></i>
                                                    </span>
                                                @endif
                                            @else
                                                <!-- Placeholder when no pagination needed -->
                                                <div class="d-flex align-items-center gap-2">
                                                    <span class="pagination-arrow disabled">
                                                        <i class="fas fa-chevron-left"></i>
                                                    </span>
                                                    <span class="pagination-number active">1</span>
                                                    <span class="pagination-arrow disabled">
                                                        <i class="fas fa-chevron-right"></i>
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Warning Modal -->
    <div class="modal fade" id="deleteWarningModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                        Tidak Dapat Menghapus
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Cabang olahraga <strong id="caborName"></strong>
                        tidak dapat dihapus karena masih memiliki:</p>
                    <ul id="dependencyList"></ul>
                    <p class="text-muted">Silakan pindahkan atau hapus data
                        tersebut terlebih dahulu, atau nonaktifkan cabang
                        olahraga ini.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            console.log('Initializing server-side search and filter...');

            // Auto-submit search with debounce
            let searchTimeout;
            $('#search').on('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    console.log('Submitting search form...');
                    $('#searchForm').submit();
                }, 500); // 500ms delay untuk menghindari request berlebihan
            });

            // Apply filters button
            $('#apply-filters').on('click', function() {
                console.log('Applying filters...');
                
                // Update the search form with filter values
                const statusValue = $('#filter-status').val();
                $('#searchForm input[name="status"]').val(statusValue);
                
                // Submit the search form
                $('#searchForm').submit();
            });

            // Reset filters button
            $('#reset-filters').on('click', function() {
                console.log('Resetting filters...');
                
                // Clear search input
                $('#search').val('');
                $('#filter-status').val('');
                
                // Clear hidden inputs
                $('#searchForm input[name="search"]').val('');
                $('#searchForm input[name="status"]').val('');
                
                // Submit to reset all filters
                window.location.href = "{{ route('admin.konfigurasi.cabang-olahraga.index') }}";
            });

            // Auto-apply filter when status dropdown changes
            $('#filter-status').on('change', function() {
                console.log('Status filter changed, auto-applying...');
                $('#apply-filters').click();
            });

            // Update filter count badge on page load
            updateFilterCountBadge();

            // Show active search/filter indicators
            showActiveFilters();

            console.log('Search and filter initialization complete');
        });

        // Function to update filter count badge
        function updateFilterCountBadge() {
            const activeFilters = [];
            
            if ($('#filter-status').val()) {
                activeFilters.push('status');
            }
            
            const count = activeFilters.length;
            const badge = $('#filter-count');
            
            if (count > 0) {
                badge.text(count).removeClass('d-none');
            } else {
                badge.addClass('d-none');
            }
        }

        // Function to show active search/filter indicators
        function showActiveFilters() {
            const hasSearch = "{{ request('search') }}" !== "";
            const hasFilter = "{{ request('status') }}" !== "";
            
            if (hasSearch || hasFilter) {
                console.log('Active filters detected:', {
                    search: "{{ request('search') }}",
                    status: "{{ request('status') }}"
                });
            }
        }

        // Delete warning modal functions
        function showDeleteWarning(namaCabor, jumlahAtlet, jumlahPelatih) {
            document.getElementById('caborName').textContent = namaCabor;

            const dependencyList = document.getElementById('dependencyList');
            dependencyList.innerHTML = '';

            if (jumlahAtlet > 0) {
                dependencyList.innerHTML += `<li>${jumlahAtlet} atlet yang terdaftar</li>`;
            }

            if (jumlahPelatih > 0) {
                dependencyList.innerHTML += `<li>${jumlahPelatih} pelatih yang terdaftar</li>`;
            }

            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('deleteWarningModal'));
            modal.show();
        }

        function confirmDelete(namaCabor) {
            return confirm(`Yakin ingin menghapus cabang olahraga "${namaCabor}"?\nTindakan ini tidak dapat dibatalkan.`);
        }

        // Loading state management for better UX
        function showTableLoading() {
            const tableContainer = document.getElementById('tableContainer');
            if (tableContainer) {
                tableContainer.classList.add('table-loading');
                const spinner = document.createElement('div');
                spinner.className = 'loading-spinner';
                tableContainer.appendChild(spinner);
            }
        }

        function hideTableLoading() {
            const tableContainer = document.getElementById('tableContainer');
            if (tableContainer) {
                tableContainer.classList.remove('table-loading');
                const spinner = tableContainer.querySelector('.loading-spinner');
                if (spinner) {
                    spinner.remove();
                }
            }
        }

        // Form submission handling with loading state
        $('#searchForm, #filterForm, #perPageForm').on('submit', function() {
            showTableLoading();
        });

        // Handle browser back/forward buttons
        window.addEventListener('pageshow', function() {
            hideTableLoading();
        });
    </script>

    {{-- Notifikasi --}}
    @if (session('cabor_created'))
        <script>
            $(document).ready(() => toastr.success("{{ session('cabor_created') }}"));
        </script>
    @endif

    @if (session('cabor_updated'))
        <script>
            $(document).ready(() => toastr.success("{{ session('cabor_updated') }}"));
        </script>
    @endif

    @if (session('cabor_deleted'))
        <script>
            $(document).ready(() => toastr.success("{{ session('cabor_deleted') }}"));
        </script>
    @endif

    @if (session('error'))
        <script>
            $(document).ready(() => toastr.error("{{ session('error') }}"));
        </script>
    @endif

    @if (session('success'))
        <script>
            $(document).ready(() => toastr.success("{{ session('success') }}"));
        </script>
    @endif
@endsection