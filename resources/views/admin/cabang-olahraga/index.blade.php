@extends('layouts.app')

@section('pageTitle', 'Manajemen Cabang Olahraga')
@section('mainSection', 'Konfigurasi')
@section('currentSection', 'Cabang Olahraga')

@section('breadcrumb-title')
    {{-- <h1 class="d-flex flex-column text-dark fw-bold fs-3 mb-0">Halaman Cabang Olahraga</h1> --}}
@endsection

@section('breadcrumb-items')
    {{-- <li class="breadcrumb-item text-gray-600">Cabang Olahraga</li> --}}
@endsection

@section('content')

    <style>
        table td,
        table th {
            vertical-align: middle;
            word-wrap: break-word;
            white-space: nowrap;
        }

        .object-fit-cover {
            object-fit: cover;
        }

        /* Khusus untuk table wrapper - horizontal scroll */
        .table-wrapper {
            overflow-x: auto;
            overflow-y: visible;
            -webkit-overflow-scrolling: touch;
            width: 100%;
            position: relative;
        }

        /* Table memiliki width minimum agar bisa di-scroll */
        .table {
            min-width: 1200px;
            margin-bottom: 0;
        }

        /* Fixed header styling */
        .table thead th {
            position: sticky;
            top: 0;
            background-color: #f8f9fa !important;
            z-index: 10;
            border-bottom: 2px solid #dee2e6;
            text-align: left !important;
        }

        /* Kolom width settings */
        .table th:nth-child(1) {
            width: 60px;
            min-width: 60px;
            left: 0;
            z-index: 11;
            position: sticky;
            background-color: #f8f9fa !important;
        }

        .table td:nth-child(1) {
            width: 60px;
            min-width: 60px;
            left: 0;
            z-index: 9;
            position: sticky;
            background-color: white;
            border-right: 1px solid #dee2e6;
        }

        .table th:nth-child(2) {
            width: 250px;
            min-width: 250px;
        }

        .table th:nth-child(3) {
            width: 200px;
            min-width: 200px;
        }

        .table th:nth-child(4) {
            width: 120px;
            min-width: 120px;
        }

        .table th:nth-child(5) {
            width: 150px;
            min-width: 150px;
        }

        .table th:nth-child(6) {
            width: 100px;
            min-width: 100px;
        }

        .table th:nth-child(7) {
            width: 100px;
            min-width: 100px;
        }

        .table th:nth-child(8) {
            width: 150px;
            min-width: 150px;
        }

        .table th:nth-child(9) {
            width: 120px;
            min-width: 120px;
        }

        .text-truncate-custom {
            max-width: 180px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* Hapus semua responsive hiding - biarkan semua kolom tampil */
        .table th,
        .table td {
            display: table-cell !important;
        }

        /* Card body tidak perlu overflow hidden */
        .card-body {
            overflow: visible;
        }

        /* Untuk memastikan link sorting di header juga rata kiri */
        .table thead th a {
            text-align: left !important;
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            color: #3f4254 !important;
            text-decoration: none !important;
        }

        .table thead th a:hover {
            color: #1b84ff !important;
        }

        /* Sort icons styling */
        .sort-icon {
            margin-left: 5px;
            font-size: 12px;
            opacity: 0.6;
        }

        .sort-icon.active {
            opacity: 1;
            color: #1b84ff;
        }

        /* Hover effect untuk baris tabel */
        .table tbody tr:hover {
            background-color: #f8f9fa;
        }
    </style>

    <div class="row col-12 mt-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                <h3 class="card-title fw-bold fs-3 mb-0">Cabang Olahraga</h3>
                <a href="{{ route('admin.konfigurasi.cabang-olahraga.create') }}" class="btn custom-red-button"
                    style="background-color: #F8285A !important; color: white !important; border-color: #F8285A !important;">
                    <i class="ki-duotone ki-plus fs-2" style="color: white !important;"></i>Tambah Cabang Olahraga
                </a>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
                    <h2 class="mb-0">Informasi Cabang Olahraga</h2>

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

                @if ($cabors->isEmpty())
                    <div class="text-center text-muted py-10">
                        <i class="ki-duotone ki-information-5 fs-3x mb-3"></i>
                        <h4>Tidak ada data cabang olahraga.</h4>
                    </div>
                @else
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div id="filter-info" class="text-muted">
                            Menampilkan <span id="showing-count">{{ $cabors->count() }}</span> dari <span
                                id="total-count">{{ $cabors->count() }}</span> cabang olahraga
                        </div>
                    </div>

                    {{-- Table with horizontal scroll wrapper --}}
                    <div class="table-wrapper">
                        <table class="table table-bordered table-hover align-middle" id="kt_datatable_dom_positioning">
                            <thead class="bg-light">
                                <tr>
                                    <th>No</th>
                                    <th>
                                        <a href="#" class="sortable" data-column="1">
                                            Nama Cabor
                                            <i class="fas fa-sort sort-icon"></i>
                                        </a>
                                    </th>
                                    <th>
                                        <a href="#" class="sortable" data-column="2">
                                            Ketua Penanggung Jawab
                                            <i class="fas fa-sort sort-icon"></i>
                                        </a>
                                    </th>
                                    <th>
                                        <a href="#" class="sortable" data-column="3">
                                            Status
                                            <i class="fas fa-sort sort-icon"></i>
                                        </a>
                                    </th>
                                    <th>
                                        <a href="#" class="sortable" data-column="4">
                                            Tanggal Pembentukan
                                            <i class="fas fa-sort sort-icon"></i>
                                        </a>
                                    </th>
                                    <th>
                                        <a href="#" class="sortable" data-column="5">
                                            Jumlah Atlet
                                            <i class="fas fa-sort sort-icon"></i>
                                        </a>
                                    </th>
                                    <th>
                                        <a href="#" class="sortable" data-column="6">
                                            Jumlah Pelatih
                                            <i class="fas fa-sort sort-icon"></i>
                                        </a>
                                    </th>
                                    <th>
                                        <a href="#" class="sortable" data-column="7">
                                            Terakhir Update
                                            <i class="fas fa-sort sort-icon"></i>
                                        </a>
                                    </th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($cabors as $index => $cabor)
                                    <tr data-status="{{ $cabor->status }}">
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if ($cabor->icon_cabor)
                                                    <img src="{{ asset('storage/' . $cabor->icon_cabor) }}" width="30"
                                                        height="30" class="rounded object-fit-cover me-3">
                                                @else
                                                    <div class="rounded bg-secondary text-white text-center fw-bold d-flex align-items-center justify-content-center me-3"
                                                        style="width: 30px; height: 30px;">
                                                        <i class="ki-duotone ki-picture fs-6"></i>
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
                                        <td class="text-center">
                                            {{ $cabor->atlets ? $cabor->atlets->count() : 0 }}
                                        </td>
                                        <td class="text-center">
                                            {{ $cabor->pelatihs ? $cabor->pelatihs->count() : 0 }}
                                        </td>
                                        <td>
                                            {{ $cabor->terakhir_update ? \Carbon\Carbon::parse($cabor->terakhir_update)->format('M d, Y') : '-' }}
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-1">
                                                <a href="{{ route('admin.konfigurasi.cabang-olahraga.show', $cabor->id) }}"
                                                    class="btn btn-icon btn-sm btn-light-primary" title="Detail">
                                                    <i class="fa-solid fa-eye"></i>
                                                </a>

                                                <a href="{{ route('admin.konfigurasi.cabang-olahraga.edit', $cabor->id) }}"
                                                    class="btn btn-icon btn-sm btn-light-warning" title="Edit">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </a>

                                                <form action="{{ route('admin.konfigurasi.cabang-olahraga.destroy', $cabor->id) }}"
                                                    method="POST" class="d-inline"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus cabang olahraga ini?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-icon btn-sm btn-light-danger"
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
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination sama seperti di menu Atlet --}}
                    <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap">
                        <div class="mb-2 mb-md-0">
                            <div class="d-flex align-items-center">
                                <span class="me-2">Show</span>
                                <select class="form-select form-select-sm w-auto" id="entries-per-page">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                                <span class="ms-2">per page</span>
                            </div>
                        </div>

                        <div class="d-flex align-items-center gap-3">
                            <div class="d-flex align-items-center">
                                <span class="me-2">Page</span>
                                <select class="form-select form-select-sm" style="width: 80px;" id="page-select">
                                    <option value="1">1</option>
                                </select>
                                <span class="ms-2">of <span id="total-pages">1</span></span>
                            </div>

                            <div class="btn-group">
                                <button class="btn btn-outline-secondary" id="prev-page">
                                    <i class="fas fa-chevron-left"></i>
                                </button>
                                <button class="btn btn-outline-secondary" id="next-page">
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection

@section('script')
    @if(session('success'))
        <script>
            $(document).ready(function() {
                toastr.success("{{ session('success') }}");
            });
        </script>
    @endif

    @if(session('error'))
        <script>
            $(document).ready(function() {
                toastr.error("{{ session('error') }}");
            });
        </script>
    @endif

    @if ($cabors->isNotEmpty())
        <script>
            $(document).ready(function() {
                const table = $("#kt_datatable_dom_positioning").DataTable({
                    paging: true,
                    pageLength: 10,
                    info: false,
                    searching: true,
                    ordering: true,
                    responsive: false,
                    autoWidth: false,
                    scrollX: false,
                    lengthChange: false,
                    dom: 'rt',
                    columnDefs: [{
                            targets: [0, -1], // kolom No dan Aksi
                            orderable: false,
                            searchable: false
                        },
                        {
                            width: "60px",
                            targets: 0
                        },
                        {
                            width: "250px",
                            targets: 1
                        },
                        {
                            width: "200px",
                            targets: 2
                        },
                    ],
                    order: [], // No default sorting
                    drawCallback: function(settings) {
                        // Update nomor urut tetap berurutan dari 1
                        const api = this.api();
                        const start = api.page.info().start;
                        
                        // Reset nomor urut selalu mulai dari 1 untuk halaman pertama
                        let counter = start + 1;
                        api.column(0, { page: 'current' }).nodes().each(function(cell, i) {
                            cell.innerHTML = counter++;
                        });
                        
                        updatePaginationControls();
                        updateFilterInfo();
                        updateSortIcons();
                    }
                });

                const totalCount = table.rows().count();

                // Search functionality
                $('#search').on('keyup', function() {
                    table.search(this.value).draw();
                });

                // Custom sorting click handler
                $('.sortable').on('click', function(e) {
                    e.preventDefault();
                    const column = $(this).data('column');
                    
                    // Get current order
                    const currentOrder = table.order();
                    let newOrder = 'asc';
                    
                    // If currently sorting by this column, toggle order
                    if (currentOrder.length > 0 && currentOrder[0][0] === column) {
                        newOrder = currentOrder[0][1] === 'asc' ? 'desc' : 'asc';
                    }
                    
                    // Apply new order
                    table.order([column, newOrder]).draw();
                });

                // Update sort icons
                function updateSortIcons() {
                    // Reset all sort icons
                    $('.sort-icon').removeClass('active fas fa-sort-up fa-sort-down').addClass('fas fa-sort');
                    
                    // Get current order
                    const currentOrder = table.order();
                    if (currentOrder.length > 0) {
                        const columnIndex = currentOrder[0][0];
                        const direction = currentOrder[0][1];
                        
                        const sortIcon = $(`.sortable[data-column="${columnIndex}"] .sort-icon`);
                        sortIcon.removeClass('fas fa-sort').addClass('active');
                        
                        if (direction === 'asc') {
                            sortIcon.addClass('fas fa-sort-up');
                        } else {
                            sortIcon.addClass('fas fa-sort-down');
                        }
                    }
                }

                // Custom filter untuk status
                $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                    const row = table.row(dataIndex).node();
                    const $row = $(row);
                    
                    const statusFilter = $('#filter-status').val();
                    const rowStatus = $row.data('status');

                    if (statusFilter && rowStatus !== statusFilter) return false;
                    
                    return true;
                });

                // Apply filters
                $('#apply-filters').on('click', function() {
                    table.draw();
                    updateFilterCount();
                    $('.dropdown-toggle').dropdown('hide');
                });

                // Reset filters
                $('#reset-filters').on('click', function() {
                    $('#filter-status').val('');
                    $('#search').val('');
                    
                    table.search('').draw();
                    updateFilterCount();
                    $('.dropdown-toggle').dropdown('hide');
                });

                // Entries per page
                $('#entries-per-page').on('change', function() {
                    const length = parseInt($(this).val());
                    table.page.len(length).draw();
                });

                // Page navigation
                $('#page-select').on('change', function() {
                    const page = parseInt($(this).val()) - 1;
                    table.page(page).draw();
                });

                $('#prev-page').on('click', function() {
                    table.page('previous').draw();
                });

                $('#next-page').on('click', function() {
                    table.page('next').draw();
                });

                function updatePaginationControls() {
                    const info = table.page.info();
                    const currentPage = info.page + 1;
                    const totalPages = info.pages;

                    // Update page select options
                    const pageSelect = $('#page-select');
                    pageSelect.empty();
                    for (let i = 1; i <= totalPages; i++) {
                        pageSelect.append(`<option value="${i}" ${i === currentPage ? 'selected' : ''}>${i}</option>`);
                    }

                    // Update total pages
                    $('#total-pages').text(totalPages);

                    // Update navigation buttons
                    $('#prev-page').prop('disabled', info.page === 0).toggleClass('disabled', info.page === 0);
                    $('#next-page').prop('disabled', info.page === info.pages - 1).toggleClass('disabled', info.page === info.pages - 1);
                }

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

                function updateFilterInfo() {
                    const info = table.page.info();
                    const showingCount = info.recordsDisplay;
                    $('#showing-count').text(showingCount);
                    $('#total-count').text(totalCount);
                }

                // Initialize
                updatePaginationControls();
                updateFilterInfo();
                updateFilterCount();
                updateSortIcons();
            });
        </script>
    @endif
@endsection