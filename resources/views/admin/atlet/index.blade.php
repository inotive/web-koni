@extends('layouts.app')

@section('pageTitle', 'Manajemen Atlet')
@section('mainSection', 'Konfigurasi')
@section('currentSection', 'Atlet')

@section('breadcrumb-title')
@endsection

@section('breadcrumb-items')
@endsection

@section('content')


    <style>
        body {
            background-color: #f5f5f5 !important;
        }

        .main-content {
            background-color: #f5f5f5 !important;
        }

        .table-card {
            background-color: white !important;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .page-header {
            background-color: transparent;
            margin-bottom: 20px;
        }

        .table-container {
            position: relative;
            overflow: hidden;
        }

        .table-header-fixed {
            position: sticky;
            top: 0;
            background-color: white;
            z-index: 10;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        .table-responsive-wrapper {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            border-radius: 8px;
            border: 1px solid #dee2e6;
            margin-left: -1px;
            margin-right: -1px;
        }

        .table-header-container {
            overflow: hidden;
            position: relative;
        }

        .table-responsive {
            overflow-y: auto;
            max-height: calc(100vh - 300px);
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .table-responsive::-webkit-scrollbar {
            display: none;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .table thead th {
            background-color: #f8f9fa !important;
            border-bottom: 2px solid #dee2e6 !important;
            font-weight: 600 !important;
            font-size: 14px !important;
            color: #495057 !important;
            padding: 12px 8px !important;
            text-align: center !important;
            white-space: nowrap;
            position: sticky;
            top: 0;
            z-index: 5;
        }

        .table tbody td {
            padding: 12px 8px !important;
            font-size: 14px;
            color: #495057;
            vertical-align: middle;
        }

        .table tbody tr:hover {
            background-color: #f8f9fa !important;
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

        /* Kolom Responsive */
        @media (max-width: 1200px) {

            .table th:nth-child(4),
            .table th:nth-child(5),
            .table th:nth-child(8),
            .table th:nth-child(9),
            .table th:nth-child(10),
            .table th:nth-child(11),
            .table td:nth-child(4),
            .table td:nth-child(5),
            .table td:nth-child(8),
            .table td:nth-child(9),
            .table td:nth-child(10),
            .table td:nth-child(11) {
                display: none;
            }
        }

        @media (max-width: 768px) {

            .table th:nth-child(6),
            .table th:nth-child(7),
            .table td:nth-child(6),
            .table td:nth-child(7) {
                display: none;
            }
        }

        /* Pagination */
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
            background-color: #007bff;
            border-color: #007bff;
            color: #fff;
        }

        .pagination-wrapper .page-link:hover {
            color: #495057;
            background-color: #e9ecef;
            border-color: #dee2e6;
        }
    </style>

    <div style="background-color: #f5f5f5; min-height: 100vh; padding: 20px 0;">
        <div class="container-fluid">
            <div class="page-header d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold fs-3 mb-0">Atlet</h2>
                <a href="{{ route('admin.konfigurasi.atlet.create') }}" class="btn custom-red-button"
                    style="background-color: #F8285A !important; color: white !important; border-color: #F8285A !important;">
                    <i class="ki-duotone ki-plus fs-2" style="color: white !important;"></i>Tambah Atlet
                </a>
            </div>

            <div class="card table-card">
                <div class="card-body p-3 p-md-4">
                    <div class="table-header-fixed">
                        <div class="table-header-container">
                            <div class="table-header-inner">
                                <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                                    <h3 class="mb-0">Informasi Atlet</h3>
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
                                                <span id="filter-count"
                                                    class="badge badge-circle badge-danger ms-1 d-none">0</span>
                                            </button>
                                            <div class="dropdown-menu p-3 shadow" style="min-width: 320px;">
                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">Cabang Olahraga</label>
                                                    <select id="filter-cabor" class="form-select">
                                                        <option value="">Semua Cabor</option>
                                                        @foreach ($atlets->pluck('cabor')->unique()->filter() as $cabor)
                                                            <option value="{{ $cabor }}">{{ $cabor }}</option>
                                                        @endforeach
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
                                                        <i class="ki-duotone ki-check fs-3"></i>Terapkan
                                                    </button>
                                                    <button type="button" id="reset-filters"
                                                        class="btn btn-light btn-sm flex-fill">
                                                        <i class="ki-duotone ki-arrows-circle fs-3"></i>Reset
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="filter-info" class="text-muted mb-2">
                                    Menampilkan <span id="showing-count">{{ $atlets->count() }}</span> dari
                                    <span id="total-count">{{ $atlets->total() }}</span> atlet
                                </div>
                            </div>

                            <div class="table-responsive-wrapper">
                                <div class="table-responsive">
                                    @if ($atlets->isEmpty())
                                        <div class="text-center text-muted py-10">
                                            <i class="ki-duotone ki-information-5 fs-3x mb-3"></i>
                                            <h4>Tidak ada data atlet.</h4>
                                        </div>
                                    @else
                                        <table class="table table-bordered table-hover align-middle"
                                            id="kt_datatable_dom_positioning">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Foto</th>
                                                    <th>
                                                        <a href="{{ sortUrl('nama') }}"
                                                            class="text-dark text-decoration-none">
                                                            <span>Nama & Cabor</span>
                                                            {!! sortIcon('nama') !!}
                                                        </a>
                                                    </th>
                                                    <th class="d-none d-xl-table-cell">
                                                        <a href="{{ sortUrl('tanggal_lahir') }}"
                                                            class="text-dark text-decoration-none">
                                                            <span>Tempat & Tanggal Lahir</span>
                                                            {!! sortIcon('tanggal_lahir') !!}
                                                        </a>
                                                    </th>
                                                    <th class="d-none d-xl-table-cell">
                                                        <a href="{{ sortUrl('alamat') }}"
                                                            class="text-dark text-decoration-none">
                                                            <span>Alamat</span>
                                                            {!! sortIcon('alamat') !!}
                                                        </a>
                                                    </th>
                                                    <th class="d-none d-md-table-cell">
                                                        <a href="{{ sortUrl('jenis_kelamin') }}"
                                                            class="text-dark text-decoration-none">
                                                            <span>Gender</span>
                                                            {!! sortIcon('jenis_kelamin') !!}
                                                        </a>
                                                    </th>
                                                    <th class="d-none d-md-table-cell">
                                                        <a href="{{ sortUrl('umur') }}"
                                                            class="text-dark text-decoration-none">
                                                            <span>Usia</span>
                                                            {!! sortIcon('umur') !!}
                                                        </a>
                                                    </th>
                                                    <th class="d-none d-xl-table-cell">
                                                        <a href="{{ sortUrl('no_telepon') }}"
                                                            class="text-dark text-decoration-none">
                                                            <span>Telepon</span>
                                                            {!! sortIcon('no_telepon') !!}
                                                        </a>
                                                    </th>
                                                    <th class="d-none d-xl-table-cell">
                                                        <a href="{{ sortUrl('email') }}"
                                                            class="text-dark text-decoration-none">
                                                            <span>Email</span>
                                                            {!! sortIcon('email') !!}
                                                        </a>
                                                    </th>
                                                    <th class="d-none d-xl-table-cell">
                                                        <a href="{{ sortUrl('prestasi') }}"
                                                            class="text-dark text-decoration-none">
                                                            <span>Prestasi</span>
                                                            {!! sortIcon('prestasi') !!}
                                                        </a>
                                                    </th>
                                                    <th class="d-none d-xl-table-cell">
                                                        <a href="{{ sortUrl('created_at') }}"
                                                            class="text-dark text-decoration-none">
                                                            <span>Ditambahkan</span>
                                                            {!! sortIcon('created_at') !!}
                                                        </a>
                                                    </th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($atlets as $index => $atlet)
                                                    <tr data-cabor="{{ $atlet->cabor }}"
                                                        data-gender="{{ $atlet->jenis_kelamin }}"
                                                        data-age="{{ $atlet->umur }}"
                                                        data-prestasi="{{ $atlet->prestasiTerbaru ? 'ada' : 'tidak' }}"
                                                        data-medali="{{ $atlet->prestasiTerbaru ? strtolower($atlet->prestasiTerbaru->medali) : '' }}">
                                                        <td class="text-center row-number">
                                                        </td>
                                                        <td>
                                                            @if ($atlet->foto_atlet)
                                                                <img src="{{ asset('storage/' . $atlet->foto_atlet) }}"
                                                                    width="40" height="40"
                                                                    class="rounded-circle object-fit-cover">
                                                            @else
                                                                <div class="rounded-circle bg-secondary text-white text-center fw-bold"
                                                                    style="width: 40px; height: 40px; line-height: 40px;">
                                                                    {{ strtoupper(substr($atlet->nama, 0, 1)) }}
                                                                </div>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <div class="d-flex flex-column">
                                                                <strong
                                                                    class="text-truncate-custom">{{ $atlet->nama }}</strong>
                                                                <small class="text-muted">{{ $atlet->cabor }}</small>
                                                            </div>
                                                        </td>
                                                        <td class="d-none d-xl-table-cell">
                                                            <div class="d-flex flex-column">
                                                                <span
                                                                    class="text-truncate-custom">{{ \Carbon\Carbon::parse($atlet->tanggal_lahir)->format('d M Y') }}</span>
                                                                @if ($atlet->tempat_lahir)
                                                                    <small
                                                                        class="text-muted text-truncate-custom">{{ $atlet->tempat_lahir }}</small>
                                                                @endif
                                                            </div>
                                                        </td>
                                                        <td class="d-none d-xl-table-cell">
                                                            @if ($atlet->alamat)
                                                                <div class="text-truncate-custom"
                                                                    title="{{ $atlet->alamat }}">
                                                                    {{ $atlet->alamat }}
                                                                </div>
                                                            @else
                                                                <span class="text-muted">-</span>
                                                            @endif
                                                        </td>
                                                        <td class="d-none d-md-table-cell">{{ $atlet->jenis_kelamin }}
                                                        </td>
                                                        <td class="d-none d-md-table-cell">{{ $atlet->umur }}</td>
                                                        <td class="d-none d-xl-table-cell">
                                                            <div class="text-truncate-custom">
                                                                {{ $atlet->no_telepon ?? '-' }}
                                                            </div>
                                                        </td>
                                                        <td class="d-none d-xl-table-cell">
                                                            <div class="text-truncate-custom"
                                                                title="{{ $atlet->email }}">
                                                                {{ $atlet->email ?? '-' }}</div>
                                                        </td>
                                                        <td class="d-none d-xl-table-cell">
                                                            @if ($atlet->prestasiTerbaru)
                                                                <div class="d-flex align-items-center">
                                                                    <div class="me-3">
                                                                        @if (strtolower($atlet->prestasiTerbaru->medali) === 'emas')
                                                                            <i class="fas fa-medal fs-2x text-warning"
                                                                                title="Emas"></i>
                                                                        @elseif(strtolower($atlet->prestasiTerbaru->medali) === 'perak')
                                                                            <i class="fas fa-medal fs-2x text-secondary"
                                                                                title="Perak"></i>
                                                                        @elseif(strtolower($atlet->prestasiTerbaru->medali) === 'perunggu')
                                                                            <i class="fas fa-medal fs-2x text-bronze"
                                                                                title="Perunggu"></i>
                                                                        @endif
                                                                    </div>

                                                                    <div class="d-flex flex-column">
                                                                        <span
                                                                            class="text-truncate-custom">{{ $atlet->prestasiTerbaru->nama_prestasi }}</span>
                                                                        <small
                                                                            class="text-muted">{{ $atlet->prestasiTerbaru->tahun }}</small>
                                                                    </div>
                                                                </div>
                                                            @else
                                                                <span class="text-muted">-</span>
                                                            @endif
                                                        </td>
                                                        <td class="d-none d-xl-table-cell">
                                                            {{ \Carbon\Carbon::parse($atlet->created_at)->format('M d, Y') }}
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="d-flex justify-content-center gap-1">
                                                                <a href="{{ route('admin.konfigurasi.atlet.show', $atlet->id) }}"
                                                                    class="btn btn-icon btn-sm btn-light-primary"
                                                                    title="Detail">
                                                                    <i class="fa-solid fa-eye"></i>
                                                                </a>

                                                                <a href="{{ route('admin.konfigurasi.atlet.edit', $atlet->id) }}"
                                                                    class="btn btn-icon btn-sm btn-light-warning"
                                                                    title="Edit">
                                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                                </a>

                                                                <button class="btn btn-icon btn-sm btn-light-danger"
                                                                    title="Hapus" onclick="destroyItem(this)"
                                                                    data-route="{{ route('admin.konfigurasi.atlet.destroy', $atlet->id) }}">
                                                                    <i class="fa-solid fa-trash"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="12" class="text-center py-5 text-muted">Data tidak
                                                            ditemukan</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    @endif
                                </div>
                            </div>

                            @if ($atlets->isNotEmpty())
                                <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap">
                                    <div class="mb-2 mb-md-0">
                                        <div class="d-flex align-items-center">
                                            <span class="me-2">Show</span>
                                            <select class="form-select form-select-sm w-auto" id="per-page-select">
                                                <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>
                                                    10
                                                </option>
                                                <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>
                                                    25
                                                </option>
                                                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>
                                                    50
                                                </option>
                                                <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>
                                                    100
                                                </option>
                                            </select>
                                            <span class="ms-2">per page</span>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center gap-3">
                                        <div class="d-flex align-items-center">
                                            <span class="me-2">Page {{ $atlets->currentPage() }} of
                                                {{ $atlets->lastPage() }}</span>
                                        </div>

                                        <div class="pagination-wrapper">
                                            {{ $atlets->appends(request()->query())->links('pagination::bootstrap-4') }}
                                        </div>
                                    </div>
                                </div>

                                <div class="text-muted mt-2 text-center">
                                    Showing {{ $atlets->firstItem() }} to {{ $atlets->lastItem() }} of
                                    {{ $atlets->total() }}
                                    results
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('script')
        @if ($atlets->isNotEmpty())
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                $(document).ready(function() {
                    // Inisialisasi DataTable
                    const table = $("#kt_datatable_dom_positioning").DataTable({
                        paging: false,
                        info: false,
                        searching: false,
                        ordering: true,
                        responsive: false,
                        autoWidth: false,
                        serverSide: false,
                        deferRender: true,
                        order: [], // Kosongkan agar tidak override urutan dari server
                        columnDefs: [{
                            targets: 0,
                            orderable: false
                        }, {
                            targets: -1,
                            orderable: false,
                            searchable: false
                        }],
                        drawCallback: function() {
                            updateRowNumbers();
                        },
                        initComplete: function() {
                            updateDisplayCount();
                            updateFilterCount();
                            updateRowNumbers();
                            toggleNoDataMessage();
                        }
                    });

                    // Fungsi untuk menampilkan pesan ketika tidak ada data
                    function toggleNoDataMessage() {
                        const tbody = $('#kt_datatable_dom_positioning tbody');
                        const existingMessage = $('#no-data-message');
                        const visibleRows = tbody.find('tr:visible').not('#no-data-message').length;

                        existingMessage.remove();

                        if (visibleRows === 0) {
                            const noDataHtml = `
                    <tr id="no-data-message">
                        <td colspan="12" class="text-center py-8">
                            <i class="ki-duotone ki-magnifier fs-4x text-muted mb-3"><span class="path1"></span><span class="path2"></span></i>
                            <h4 class="text-muted">Data tidak tersedia</h4>
                            <p class="text-muted">Tidak ada data yang cocok dengan kriteria filter atau pencarian Anda.</p>
                        </td>
                    </tr>
                `;
                            tbody.append(noDataHtml);
                        }
                    }

                    // Fungsi untuk update nomor urut baris
                    function updateRowNumbers() {
                        let counter = 1;
                        $('#kt_datatable_dom_positioning tbody tr:visible').not('#no-data-message').each(function() {
                            $(this).find('.row-number').text(counter++);
                        });
                    }

                    // Fungsi untuk update tampilan jumlah data
                    function updateDisplayCount() {
                        const visibleRows = $('#kt_datatable_dom_positioning tbody tr:visible').not('#no-data-message')
                            .length;
                        const totalRows = {{ $atlets->total() }};
                        $('#showing-count').text(visibleRows);
                        $('#total-count').text(totalRows);
                    }

                    // Fungsi untuk menerapkan filter dan pencarian
                    function applyFiltersAndSearch() {
                        const caborFilter = $('#filter-cabor').val();
                        const genderFilter = $('#filter-gender').val();
                        const ageFilter = $('#filter-age').val();
                        const prestasiFilter = $('#filter-prestasi').val();
                        const searchTerm = $('#search').val().toLowerCase();

                        $('#kt_datatable_dom_positioning tbody tr').each(function() {
                            const $row = $(this);
                            if ($row.attr('id') === 'no-data-message') return;

                            const rowCabor = $row.data('cabor') || '';
                            const rowGender = $row.data('gender') || '';
                            const rowAge = parseInt($row.data('age')) || 0;
                            const rowPrestasi = $row.data('prestasi') || '';
                            const rowMedali = $row.data('medali') || '';
                            const rowText = $row.text().toLowerCase();

                            let show = true;

                            // Filter pencarian
                            if (searchTerm) {
                                const searchWords = searchTerm.split(' ').filter(word => word.length > 0);
                                if (!searchWords.every(word => rowText.includes(word))) {
                                    show = false;
                                }
                            }

                            // Filter cabang olahraga
                            if (caborFilter && rowCabor !== caborFilter) show = false;

                            // Filter jenis kelamin
                            if (genderFilter && rowGender !== genderFilter) show = false;

                            // Filter prestasi
                            if (prestasiFilter) {
                                if (prestasiFilter === 'ada' && rowPrestasi !== 'ada') show = false;
                                if (prestasiFilter === 'tidak' && rowPrestasi !== 'tidak') show = false;
                                if (prestasiFilter === 'emas' && rowMedali !== 'emas') show = false;
                                if (prestasiFilter === 'perak' && rowMedali !== 'perak') show = false;
                                if (prestasiFilter === 'perunggu' && rowMedali !== 'perunggu') show = false;
                            }

                            // Filter usia
                            if (ageFilter && rowAge > 0) {
                                if (ageFilter === '36+') {
                                    if (rowAge < 36) show = false;
                                } else {
                                    const [minAge, maxAge] = ageFilter.split('-').map(age => parseInt(age));
                                    if (rowAge < minAge || rowAge > maxAge) show = false;
                                }
                            } else if (ageFilter && rowAge === 0) {
                                show = false;
                            }

                            $row.toggle(show);
                        });

                        updateRowNumbers();
                        updateDisplayCount();
                        toggleNoDataMessage();
                    }

                    // Fungsi untuk update jumlah filter aktif
                    function updateFilterCount() {
                        const count = [$('#filter-cabor').val(), $('#filter-gender').val(), $('#filter-age').val(), $(
                                '#filter-prestasi').val()]
                            .filter(Boolean).length;
                        const badge = $('#filter-count');
                        count > 0 ? badge.text(count).removeClass('d-none') : badge.addClass('d-none');
                    }

                    // Fungsi global untuk menghapus data dengan konfirmasi SweetAlert2
                    window.destroyItem = function(e) {
                        const route = e.dataset.route;

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

                    // Event listener untuk pencarian
                    $('#search').on('keyup', applyFiltersAndSearch);

                    // Event listener untuk tombol terapkan filter
                    $('#apply-filters').on('click', function() {
                        applyFiltersAndSearch();
                        updateFilterCount();
                        $('.dropdown-toggle').dropdown('hide');
                    });

                    // Event listener untuk tombol reset filter
                    $('#reset-filters').on('click', function() {
                        $('#filter-cabor, #filter-gender, #filter-age, #filter-prestasi').val('');
                        $('#search').val('');

                        $('#kt_datatable_dom_positioning tbody tr').show();

                        updateRowNumbers();
                        updateDisplayCount();
                        updateFilterCount();
                        toggleNoDataMessage();
                        $('.dropdown-toggle').dropdown('hide');
                    });

                    // Event listener untuk perubahan jumlah data per halaman
                    $('#per-page-select').on('change', function() {
                        const perPage = $(this).val();
                        const currentUrl = new URL(window.location.href);
                        currentUrl.searchParams.set('per_page', perPage);
                        currentUrl.searchParams.set('page', 1);
                        window.location.href = currentUrl.toString();
                    });

                    // Inisialisasi awal
                    updateRowNumbers();
                });
            </script>
        @endif
    @endsection
