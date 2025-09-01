@extends('layouts.app')

@php
    $subSection3Url = '';

    if ($parent?->parent) {
        if ($parent->parent->id == 9) {
            $subSection3Url = route('admin.laporan-lpj.bidang.prestasi.cabor-terukur', [
                'parentId' => $parent->parent->id
            ]);
        }
            elseif ($parent->parent->id == 10) {
                $subSection3Url = route('admin.laporan-lpj.bidang.prestasi.cabor-akurasi', [
                    'parentId' => $parent->parent->id
                ]);
        }
            elseif ($parent->parent->id == 11) {
                $subSection3Url = route('admin.laporan-lpj.bidang.prestasi.cabor-permainan', [
                    'parentId' => $parent->parent->id
                ]);
        }
            elseif ($parent->parent->id == 12) {
                $subSection3Url = route('admin.laporan-lpj.bidang.prestasi.cabor-beladiri', [
                    'parentId' => $parent->parent->id
                ]);
        }
          else {
            // fallback if needed
            $subSection3Url = route('admin.laporan-lpj.bidang.dynamic.index');
        }
    }
@endphp

@section('pageTitle', $currentParent ? $currentParent->nama_program : 'Root Level')
@section('mainSection', 'Laporan LPJ')
@section('subSection', 'Bidang Bidang')
@section('subSectionUrl', route('admin.laporan-lpj.bidang.index'))
@section('subSection2', $parent?->parent?->parent?->nama_program ?? '')
@section('subSection2Url', route('admin.laporan-lpj.bidang.prestasi.index'))
@section('subSection3', $parent?->parent?->nama_program ?? '')
@section('subSection3Url', $subSection3Url)
{{-- @section('subSection3Url', $parent?->parent ? route('admin.laporan-lpj.bidang.dynamic.child.index', ['parentId' => $parent->parent->id]) : '') --}}
@section('currentSection', $currentParent ? $currentParent->nama_program : 'Root Level')

@section('breadcrumb-title')
@endsection

@section('content')
    <style>
        /* Include your existing styles */
        body {
            background-color: #f5f5f5;
        }

        .main-content {
            background-color: #f5f5f5;
            min-height: 100vh;
            padding: 20px 10px 40px;
        }

        /* Navigation Styles */
        .navigation-card {
            background: white;
            border-radius: 12px;
            border: 1px solid #e9ecef;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
            margin-bottom: 20px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            padding: 12px 16px;
            border-bottom: 1px solid #f0f0f0;
            transition: all 0.2s ease;
            text-decoration: none;
            color: #495057;
        }

        .nav-item:hover {
            background-color: #f8f9fa;
            color: #0d6efd;
            text-decoration: none;
        }

        .nav-item:last-child {
            border-bottom: none;
        }

        .nav-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa;
            border-radius: 8px;
            margin-right: 12px;
            font-size: 1.2rem;
        }

        .nav-content {
            flex: 1;
        }

        .nav-title {
            font-weight: 600;
            margin-bottom: 2px;
            color: #212529;
        }

        .nav-subtitle {
            font-size: 0.85rem;
            color: #6c757d;
        }

        .nav-meta {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.8rem;
            color: #6c757d;
        }

        .category-badge {
            background-color: #e3f2fd;
            color: #1976d2;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 0.75rem;
        }

        .data-badge {
            background-color: #e8f5e8;
            color: #2e7d32;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 0.75rem;
        }

        .back-navigation {
            margin-bottom: 20px;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            background-color: #6c757d;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-size: 0.9rem;
            transition: all 0.2s ease;
        }

        .back-btn:hover {
            background-color: #5a6268;
            color: white;
            text-decoration: none;
        }

        /* Table and existing styles */
        table td,
        table th {
            vertical-align: middle;
            word-wrap: break-word;
            max-width: 200px;
        }

        .object-fit-cover {
            object-fit: cover;
        }

        .table th:nth-child(1) { width: 40px; }
        .table th:nth-child(2) { width: 250px; }
        .table th:nth-child(3) { width: 100px; }
        .table th:nth-child(4) { width: 150px; }
        .table th:nth-child(5) { width: 150px; }
        .table th:nth-child(6) { width: 100px; }
        .table th:nth-child(7) { width: 120px; }
        .table th:nth-child(8) { width: 80px; }

        .text-truncate-custom {
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* Dropdown styles */
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

        .btn-restricted {
            cursor: not-allowed !important;
            opacity: 0.6 !important;
            pointer-events: none;
        }

        /* Enhanced Preview Modal Styles */
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

        /* Custom tooltip styling */
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

        .tooltip-content strong {
            color: #333333;
            font-weight: 600;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .filter-btn-custom {
            border: 1px solid #dee2e6 !important;
            background-color: white;
        }

        .filter-btn-custom:hover {
            background-color: #f8f9fa;
        }

        /* Custom Ajukan Perubahan Button */
        #ajukanPerubahanBtn {
            background-color: #4CAF50; /* Soft green like screenshot */
            color: white;
            font-weight: 600;
            border: none;
            border-radius: 8px; /* Rounded corners */
            padding: 8px 14px;
            display: inline-flex;
            align-items: center;
            gap: 6px; /* for icon if added */
            font-size: 0.9rem;
            transition: all 0.2s ease;
            box-shadow: 0 2px 6px rgba(76, 175, 80, 0.3);
        }

        #ajukanPerubahanBtn:hover {
            background-color: #43a047; /* Slightly darker on hover */
            box-shadow: 0 3px 8px rgba(76, 175, 80, 0.4);
            transform: translateY(-1px);
        }

        #ajukanPerubahanBtn:active {
            background-color: #388e3c;
            transform: translateY(0);
            box-shadow: 0 2px 4px rgba(76, 175, 80, 0.3);
        }
    </style>

    <div class="d-flex flex-column mb-8">
        <h1 class="text-dark fw-bold mb-1">
            Laporan {{ $currentParent ? $currentParent->nama_program : 'Root Level' }}
        </h1>
        @if($currentParent)
            <p class="text-muted">{{ $currentParent->breadcrumb }}</p>
        @endif
    </div>

    {{-- Main Content Card --}}
    <div class="row col-12 mt-5">
        <div class="card">
            {{-- Card Header --}}
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap py-5">
                <h3 class="card-title fw-bold fs-4 mb-0">
                    Daftar {{ $currentParent ? $currentParent->nama_program : 'Root Level' }}
                </h3>

                {{-- Action Buttons --}}
                <div class="d-flex align-items-center gap-2 flex-wrap ms-auto">
                    <a href="{{ $parentId ? route('admin.laporan-lpj.bidang.dynamic.child.create', $parentId) : route('admin.laporan-lpj.bidang.dynamic.create') }}"
                           class="btn custom-red-button"
                           style="background-color: #F8285A !important; color: white !important; border-color: #F8285A !important;">
                            <i class="ki-duotone ki-plus fs-2" style="color: white !important;"></i>Tambah Laporan
                        </a>

                    <div class="btn-group">
                        <button type="button" class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: #F8285A !important; color: white !important; border-color: #F8285A !important;">
                            <i class="fas fa-file-export me-1" style="color: white !important;"></i>Export
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" id="export-excel-btn" href="#" style="font-weight: bold; background-color: #2e7d32; color: white;"> <i class="fa-solid fa-file-excel" style="color: white"></i> Export to Excel</a></li>
                        </ul>
                    </div>

                    {{-- Search Input --}}
                    <div class="input-group position-relative" style="width: 250px;">
                        <input type="search" name="search" id="search" class="form-control"
                            placeholder="Cari program/kegiatan..." value="{{ request('search') }}" autocomplete="off">

                        <button class="btn btn-outline-secondary search-clear-btn d-none" type="button" id="clear-search"
                            style="position: absolute; right: 45px; z-index: 10; border: none; background: transparent; padding: 8px;">
                            <i class="fas fa-times text-muted"></i>
                        </button>

                        <button class="btn btn-outline-secondary" type="button" id="search-button">
                            <i class="fas fa-search"></i>
                        </button>

                        <div class="search-loading-indicator d-none position-absolute"
                            style="right: 50px; top: 50%; transform: translateY(-50%); z-index: 10;">
                            <div class="spinner-border spinner-border-sm text-primary" role="status">
                                <span class="visually-hidden">Cari Kegiatan...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card Body --}}
            <div class="card-body position-relative">
                <div class="loading-overlay d-none" id="loading-overlay">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>

                <div id="table-container">
                    @include('admin.laporan-lpj.bidang_new.dynamic._table')
                </div>
            </div>
        </div>
    </div>

    {{-- Enhanced Preview Modal --}}
    <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header" style="background: white; color: rgb(0, 0, 0);">
                    <h5 class="modal-title text-black" id="previewModalLabel">Preview Files</h5>
                    <button type="button" class="btn-close btn-close-black" data-bs-dismiss="modal" aria-label="Close"></button>
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

    {{-- Enhanced Detail Modal --}}
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                    <h5 class="modal-title" id="detailModalLabel">Detail Data</h5>
                    <div class="ms-auto d-flex align-items-center gap-2">
                        <button type="button" id="ajukanPerubahanBtn">
                            <i class="bi bi-arrow-repeat" style="color: white"></i> <strong>Ajukan Perubahan</strong>
                        </button>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                </div>
                <div class="modal-body" id="detailModalBody">
                    <!-- Content will be populated by JavaScript -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Pengajuan Modal --}}
    <div class="modal fade" id="pengajuanModal" tabindex="-1" aria-labelledby="pengajuanModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pengajuanModalLabel">Ajukan Perubahan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="pengajuanForm">
                        <input type="hidden" id="pengajuan_lpj_id" name="lpj_id">
                        <div class="mb-3">
                            <label for="alasan" class="form-label">Alasan Perubahan</label>
                            <textarea class="form-control" id="alasan" name="alasan" rows="4" required></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="submitPengajuanBtn">Kirim Pengajuan</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            let dataTable = null;
            let searchTimeout;
            let isSearching = false;
            const parentId = {{ $parentId ?? 'null' }};

            function initializeDataTable() {
                const table = $("#kt_datatable_dom_positioning_sumberdaya");

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

            function showLoading() {
                $('#loading-overlay').removeClass('d-none');
            }

            function hideLoading() {
                $('#loading-overlay').addClass('d-none');
            }

            function updateTable(params = {}) {
                return new Promise((resolve, reject) => {
                    if (params.search === undefined) {
                        showLoading();
                    }

                    let baseUrl;
                    if (parentId) {
                        baseUrl = "{{ route('admin.laporan-lpj.bidang.dynamic.child.index', ':parentId') }}".replace(':parentId', parentId);
                    } else {
                        baseUrl = "{{ route('admin.laporan-lpj.bidang.dynamic.index') }}";
                    }

                    const currentUrl = new URL(baseUrl, window.location.origin);

                    for (const key in params) {
                        if (params[key] !== null && params[key] !== undefined && params[key] !== '') {
                            currentUrl.searchParams.set(key, params[key]);
                        } else {
                            currentUrl.searchParams.delete(key);
                        }
                    }

                    if (params.search !== undefined || params.jenis_kegiatan_filter !== undefined) {
                        if (!params.page) {
                            currentUrl.searchParams.set('page', 1);
                        }
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

                            resolve(response);
                        },
                        error: function(xhr, status, error) {
                            hideLoading();
                            const errorMsg = xhr.status === 0 ?
                                'Koneksi terputus. Silakan coba lagi.' :
                                'Terjadi kesalahan saat memuat data.';
                            showNotification(errorMsg, 'error');
                            reject(error);
                        }
                    });
                });
            }

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
                });

                $(document).on('click', function(e) {
                    if (!$(e.target).closest('.dropdown-action').length) {
                        $('.dropdown-menu-custom').removeClass('show');
                    }
                });
            }

            function showNotification(message, type = 'info') {
                const alertClass = {
                    'success': 'alert-success',
                    'error': 'alert-danger',
                    'warning': 'alert-warning',
                    'info': 'alert-info'
                }[type] || 'alert-info';

                const notification = $(`
                    <div class="alert ${alertClass} alert-dismissible fade show notification-toast"
                         role="alert" style="position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
                        ${message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                `);

                $('body').append(notification);

                setTimeout(() => {
                    notification.alert('close');
                }, 5000);
            }

            $('#search').on('input', function() {
                const searchValue = $(this).val().trim();
                if (searchTimeout) clearTimeout(searchTimeout);

                searchTimeout = setTimeout(() => {
                    updateTable({ 'search': searchValue });
                }, 300);
            });

            $(document).on('click', '.pagination-link', function(e) {
                e.preventDefault();
                const url = new URL($(this).attr('href'));
                const page = url.searchParams.get('page');
                updateTable({
                    'page': page
                });
            });

            initializeTooltips();
            initializeDropdownEvents();

            window.deleteItemWithSwal = function(itemId, itemName = 'item ini') {
                const url = "{{ route('admin.laporan-lpj.bidang.dynamic.destroy', ':id') }}".replace(':id', itemId);

                Swal.fire({
                    title: "Apakah Anda Yakin?",
                    html: `<p style='text-align:center'>Setelah <strong>${itemName}</strong> dihapus, Anda tidak bisa mengembalikannya!</p>`,
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

                        $.ajax({
                            url: url,
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                _method: 'DELETE'
                            },
                            success: function(response) {
                                Swal.close();
                                if (response.success !== false) {
                                    Swal.fire({
                                        title: 'Berhasil!',
                                        text: response.message || 'Data berhasil dihapus',
                                        icon: 'success',
                                        timer: 2000,
                                        showConfirmButton: false
                                    });
                                    updateTable();
                                } else {
                                    Swal.fire({
                                        title: 'Gagal!',
                                        text: response.message || 'Terjadi kesalahan saat menghapus',
                                        icon: 'error'
                                    });
                                }
                            },
                            error: function(xhr) {
                                Swal.close();
                                Swal.fire({
                                    title: 'Error!',
                                    text: xhr.responseJSON?.message || 'Terjadi kesalahan jaringan.',
                                    icon: 'error'
                                });
                            }
                        });
                    }
                });
            };

            window.showDetailModal = function(data) {
                const modalBody = document.getElementById('detailModalBody');
                const formatRupiah = (num) => 'Rp ' + (parseInt(num, 10) || 0).toLocaleString('id-ID');
                $('#detailModal').data('lpj-id', data.id);

                let fotoJurnalHtml = '<div class="text-muted fst-italic">Tidak ada foto tersedia</div>';
                if (data.foto_jurnal && data.foto_jurnal.length > 0) {
                    fotoJurnalHtml = `
                        <div class="row g-3">
                            ${data.foto_jurnal.map(f => `
                                <div class="col-6 col-md-4">
                                    <div class="border rounded overflow-hidden" style="height: 120px;">
                                        <img src="/storage/${f}"
                                            class="w-100 h-100"
                                            style="object-fit: cover; cursor: pointer;"
                                            onclick="window.open('/storage/${f}', '_blank')"
                                            onerror="this.src='data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%22120%22 height=%22120%22><rect width=%22100%25%22 height=%22100%25%22 fill=%22%23f8f9fa%22/><text x=%2250%25%22 y=%2250%25%22 text-anchor=%22middle%22 dy=%22.3em%22 fill=%22%236c757d%22>Not found</text></svg>';">
                                    </div>
                                </div>
                            `).join('')}
                        </div>
                    `;
                }

                let dokumenHtml = '<div class="text-muted fst-italic">Tidak ada dokumen tersedia</div>';
                if (data.dokumen_lpj && data.dokumen_lpj.length > 0) {
                    dokumenHtml = `
                        <div class="d-flex flex-column gap-2">
                            ${data.dokumen_lpj.map(d => {
                                const name = d.split('/').pop();
                                const extension = name.split('.').pop().toLowerCase();
                                let iconClass = 'fas fa-file text-secondary';
                                if (extension === 'pdf') iconClass = 'fas fa-file-pdf text-danger';
                                else if (['doc', 'docx'].includes(extension)) iconClass = 'fas fa-file-word text-primary';
                                else if (['xls', 'xlsx'].includes(extension)) iconClass = 'fas fa-file-excel text-success';
                                else if (['jpg', 'jpeg', 'png', 'gif'].includes(extension)) iconClass = 'fas fa-file-image text-info';

                                return `
                                    <div class="d-flex align-items-center p-2 border rounded bg-light">
                                        <i class="${iconClass} me-3" style="font-size: 1.2em;"></i>
                                        <div class="flex-grow-1">
                                            <div class="fw-medium text-dark">${name}</div>
                                            <small class="text-muted">${extension.toUpperCase()}</small>
                                        </div>
                                        <a href="/storage/${d}" target="_blank" class="btn btn-outline-primary btn-sm"><i class="fas fa-download me-1"></i>Unduh</a>
                                    </div>
                                `;
                            }).join('')}
                        </div>
                    `;
                }

                modalBody.innerHTML = `
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="mb-4">
                                <h6 class="fw-bold text-primary mb-3"><i class="fas fa-info-circle me-2"></i>Informasi Kegiatan</h6>
                                <div class="bg-light p-3 rounded">
                                    <p><strong>Nama Program:</strong> <br>
                                        ${data.nama_program || 'N/A'}</p>
                                    <p><strong>Nama Kegiatan:</strong> <br>
                                        ${data.nama_kegiatan || 'N/A'}</p>
                                </div>
                            </div>

                            ${data.jumlah_anggaran || data.jumlah_realisasi ? `
                            <div class="mb-4">
                                <h6 class="fw-bold text-success mb-3"><i class="fas fa-calculator me-2"></i>Rincian Anggaran</h6>
                                <div class="bg-light p-3 rounded">
                                    <div class="row g-3">
                                        ${data.jumlah_anggaran ? `<div class="col-md-6"><label class="fw-semibold">Total Anggaran:</label><p class="fs-5 fw-bold">${formatRupiah(data.jumlah_anggaran)}</p></div>` : ''}
                                        ${data.jumlah_realisasi ? `<div class="col-md-6"><label class="fw-semibold">Realisasi:</label><p class="fs-5 fw-bold">${formatRupiah(data.jumlah_realisasi)}</p></div>` : ''}
                                    </div>
                                </div>
                            </div>
                            ` : ''}

                            ${data.jumlah_harga_satuan || data.volume || data.jumlah_harga ? `
                            <div class="mb-4">
                                <h6 class="fw-bold text-info mb-3"><i class="fas fa-box me-2"></i>Detail Item</h6>
                                <div class="bg-light p-3 rounded">
                                    <div class="row g-3">
                                        ${data.jumlah_harga_satuan ? `<div class="col-md-4"><label class="fw-semibold">Harga Satuan:</label><p>${formatRupiah(data.jumlah_harga_satuan)}</p></div>` : ''}
                                        ${data.volume ? `<div class="col-md-4"><label class="fw-semibold">Volume:</label><p>${data.volume}</p></div>` : ''}
                                        ${data.jumlah_harga ? `<div class="col-md-4"><label class="fw-semibold">Total Harga:</label><p class="fw-bold">${formatRupiah(data.jumlah_harga)}</p></div>` : ''}
                                    </div>
                                </div>
                            </div>
                            ` : ''}

                            <div class="mb-4">
                                <h6 class="fw-bold text-warning mb-3"><i class="fas fa-paperclip me-2"></i>Lampiran</h6>
                                <label class="fw-semibold mb-2">Foto Kegiatan:</label>
                                <div class="bg-light p-3 rounded mb-3">${fotoJurnalHtml}</div>
                                <label class="fw-semibold mb-2">Dokumen Pendukung:</label>
                                <div class="bg-light p-3 rounded">${dokumenHtml}</div>
                            </div>

                            ${data.keterangan ? `
                            <div>
                                <h6 class="fw-bold text-secondary mb-3"><i class="fas fa-sticky-note me-2"></i>Keterangan</h6>
                                <div class="bg-light p-3 rounded"><p>${data.keterangan}</p></div>
                            </div>
                            ` : ''}
                        </div>
                    </div>
                `;

                const modal = new bootstrap.Modal(document.getElementById('detailModal'));
                modal.show();
            };

            $('#ajukanPerubahanBtn').on('click', function() {
                const lpjId = $('#detailModal').data('lpj-id');
                $('#pengajuan_lpj_id').val(lpjId);
                $('#detailModal').modal('hide');
                new bootstrap.Modal(document.getElementById('pengajuanModal')).show();
            });

            $('#submitPengajuanBtn').on('click', function() {
                const lpjId = $('#pengajuan_lpj_id').val();
                const alasan = $('#alasan').val();

                if (!alasan.trim()) {
                    alert('Alasan harus diisi.');
                    return;
                }

                $.ajax({
                    url: "{{ route('admin.laporan-lpj.pengajuan.store') }}",
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        lpj_id: lpjId,
                        alasan: alasan,
                        user_id: {{ auth()->id() }}
                    },
                    success: function(response) {
                        if(response.success) {
                            $('#alasan').val('');
                            $('#pengajuan_lpj_id').val('');
                            $('#pengajuanModal').modal('hide');
                            showNotification('Pengajuan berhasil dikirim.', 'success');
                        } else {
                            showNotification(response.message || 'Gagal mengirim pengajuan.', 'error');
                        }
                    },
                    error: function() {
                        showNotification('Terjadi kesalahan. Silakan coba lagi.', 'error');
                    }
                });
            });

            $('#pengajuanModal').on('hidden.bs.modal', function () {
                $('#alasan').val('');
                $('#pengajuan_lpj_id').val('');
            });

        });
    </script>
@endsection
