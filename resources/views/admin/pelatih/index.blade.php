@extends('layouts.app')

@section('pageTitle', 'Pelatih')
@section('mainSection', 'Konfigurasi')
@section('currentSection', 'Pelatih')

@section('content')

@php
function sortIcon($field) {
    return '<i class="fas fa-sort text-muted"></i>';
}

function sortUrl($field) {
    return '#';
}
@endphp

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

    table td,
    table th {
        vertical-align: middle;
        word-wrap: break-word;
        max-width: 200px;
        padding: 8px 6px !important; /* Reduced padding */
        border-spacing: 0;
        margin: 0;
    }

    .object-fit-cover {
        object-fit: cover;
    }

    .table-responsive {
        overflow-x: visible !important;
        border-radius: 0;
        border: none;
    }

    .table {
        border-collapse: collapse !important;
        border-spacing: 0 !important;
        margin: 0 !important;
        background-color: white;
        width: 100%;
    }

    .table tbody tr {
        border-spacing: 0;
    }

    .table tbody tr td {
        border-left: none !important;
        border-right: none !important;
        padding-left: 8px !important;
        padding-right: 8px !important;
        font-size: 0.875rem;
        border-bottom: 1px solid #e9ecef;
        white-space: nowrap;
    }

    .table thead th {
        border-left: none !important;
        border-right: none !important;
        border-top: none !important;
        padding-left: 8px !important;
        padding-right: 8px !important;
        background-color: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
        font-weight: 600;
        font-size: 0.875rem;
        color: #495057;
        white-space: nowrap;
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

    .table th:nth-child(1) {
        width: 40px;
        text-align: center;
    }

    /* Foto */
    .table th:nth-child(2) {
        width: 50px;
        text-align: center;
    }

    /* Nama & Cabor */
    .table th:nth-child(3) {
        width: 140px;
    }

    /* Tempat & Tanggal Lahir */
    .table th:nth-child(4) {
        width: 110px;
    }

    /* Alamat */
    .table th:nth-child(5) {
        width: 100px;
    }

    /* Jenis Kelamin */
    .table th:nth-child(6) {
        width: 70px;
        text-align: center;
    }

    /* Usia */
    .table th:nth-child(7) {
        width: 50px;
        text-align: center;
    }

    /* Telepon */
    .table th:nth-child(8) {
        width: 110px;
    }

    /* Email */
    .table th:nth-child(9) {
        width: 110px;
    }

    /* Prestasi */
    .table th:nth-child(10) {
        width: 120px;
    }

    /* Tanggal Update */
    .table th:nth-child(11) {
        width: 90px;
    }

    /* Aksi */
    .table th:nth-child(12) {
        width: 80px;
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

    /* Center align specific columns */
    .table td:nth-child(1),
    .table td:nth-child(2),
    .table td:nth-child(6),
    .table td:nth-child(7),
    .table td:nth-child(12) {
        text-align: center;
    }

    /* Responsive adjustments */
    @media (max-width: 1200px) {

        .table th:nth-child(4),
        .table th:nth-child(5),
        .table th:nth-child(8),
        .table th:nth-child(9),
        .table th:nth-child(10),
        .table th:nth-child(11) {
            display: none;
        }

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
        .table th:nth-child(7) {
            display: none;
        }

        .table td:nth-child(6),
        .table td:nth-child(7) {
            display: none;
        }

        .table-header {
            padding: 15px;
        }

        .table-footer {
            padding: 15px;
        }

        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
    }
</style>
                <div class="d-flex justify-content-between align-items-center flex-wrap mb-4" style="padding:10px 30px">
                    <h2 class="fw-bold fs-2 mb-0 text-dark">Pelatih</h2>
                    <a href="{{ route('admin.konfigurasi.pelatih.create') }}" class="btn"
                        style="background-color: #F8285A !important; color: white !important; border-color: #F8285A !important; border-radius: 8px; padding: 12px 20px; font-weight: 500;">
                        <i class="ki-duotone ki-plus fs-4 me-2" style="color: white !important;"></i>Tambah Pelatih
                    </a>
                </div>

<div class="main-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

                <div class="table-container">
                    <div class="table-header">
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
                                    <div class="dropdown-menu p-3 shadow" style="min-width: 320px;">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Cabang Olahraga</label>
                                            <select id="filter-cabor" class="form-select">
                                                <option value="">Semua Cabor</option>
                                                @if(isset($pelatih))
                                                    @foreach ($pelatih->pluck('cabor')->unique()->filter() as $cabor)
                                                        <option value="{{ $cabor }}">{{ $cabor }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Jenis Kelamin</label>
                                            <select id="filter-gender" class="form-select">
                                                <option value="">Semua</option>
                                                <option value="L">Laki-laki</option>
                                                <option value="P">Perempuan</option>
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
                                                <option value="emas">Medali Emas</option>
                                                <option value="perak">Medali Perak</option>
                                                <option value="perunggu">Medali Perunggu</option>
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

                    @if (isset($pelatih) && $pelatih->isEmpty())
                        <div class="empty-state">
                            <i class="fas fa-info-circle fs-3x mb-3"></i>
                            <h4>Tidak ada data pelatih.</h4>
                        </div>
                    @else
                        {{-- Table --}}
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle" id="kt_datatable_dom_positioning">
                                <thead class="bg-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Foto</th>
                                        <th><a href="{{ sortUrl('nama') }}" class="text-dark text-decoration-none">Nama Pelatih & Cabor
                                                {!! sortIcon('nama') !!}</a></th>
                                        <th class="d-none d-xl-table-cell"><a href="{{ sortUrl('tanggal_lahir') }}"
                                                class="text-dark text-decoration-none">Tempat & Tanggal Lahir
                                                {!! sortIcon('tanggal_lahir') !!}</a></th>
                                        <th class="d-none d-xl-table-cell"><a href="{{ sortUrl('alamat') }}"
                                                class="text-dark text-decoration-none">Alamat {!! sortIcon('alamat') !!}</a></th>
                                        <th class="d-none d-md-table-cell"><a href="{{ sortUrl('kelamin') }}"
                                                class="text-dark text-decoration-none">Kelamin {!! sortIcon('kelamin') !!}</a></th>
                                        <th class="d-none d-md-table-cell"><a href="{{ sortUrl('tanggal_lahir') }}"
                                                class="text-dark text-decoration-none">Usia {!! sortIcon('tanggal_lahir') !!}</a></th>
                                        <th class="d-none d-xl-table-cell"><a href="{{ sortUrl('no_telepon') }}"
                                                class="text-dark text-decoration-none">Telepon {!! sortIcon('no_telepon') !!}</a></th>
                                        <th class="d-none d-xl-table-cell"><a href="{{ sortUrl('email') }}"
                                                class="text-dark text-decoration-none">Email {!! sortIcon('email') !!}</a></th>
                                        <th class="d-none d-xl-table-cell"><a href="{{ sortUrl('prestasi') }}"
                                                class="text-dark text-decoration-none">Prestasi Terbaru {!! sortIcon('prestasi') !!}</a>
                                        </th>
                                        <th class="d-none d-xl-table-cell"><a href="{{ sortUrl('updated_at') }}"
                                                class="text-dark text-decoration-none">Terakhir Diupdate {!! sortIcon('updated_at') !!}</a>
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
                                                $medali = $prestasiTerbaru && isset($prestasiTerbaru->medali) ? strtolower($prestasiTerbaru->medali) : '';
                                            @endphp
                                            <tr data-cabor="{{ $item->cabor }}" data-gender="{{ $item->kelamin }}"
                                                data-age="{{ $age }}"
                                                data-prestasi="{{ $hasPrestasi }}"
                                                data-medali="{{ $medali }}">
                                                <td class="text-center">{{ $index + 1 }}</td>
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
                                                        <small class="text-muted">{{ $item->cabor }}</small>
                                                    </div>
                                                </td>
                                                <td class="d-none d-xl-table-cell">
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
                                                <td class="d-none d-xl-table-cell">
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
                                                <td class="d-none d-md-table-cell">{{ $item->kelamin }}</td>
                                                <td class="d-none d-md-table-cell">{{ $age }} Tahun</td>
                                                <td class="d-none d-xl-table-cell">
                                                    <div class="text-truncate-custom">{{ $item->no_telepon ?? '-' }}</div>
                                                </td>
                                                <td class="d-none d-xl-table-cell">
                                                    <div class="text-truncate-custom" title="{{ $item->email }}">
                                                        {{ $item->email ?? '-' }}</div>
                                                </td>
                                                <td class="d-none d-xl-table-cell">
                                                    @if($prestasiTerbaru)
                                                        <div class="d-flex align-items-center">
                                                            {{-- Bagian Ikon Medali dengan Warna --}}
                                                            @if(isset($prestasiTerbaru->medali))
                                                                <div class="me-3">
                                                                    @if (strtolower($prestasiTerbaru->medali) === 'emas')
                                                                        <i class="fas fa-medal fs-2x text-warning" title="Emas"></i>
                                                                    @elseif(strtolower($prestasiTerbaru->medali) === 'perak')
                                                                        <i class="fas fa-medal fs-2x text-secondary" title="Perak"></i>
                                                                    @elseif(strtolower($prestasiTerbaru->medali) === 'perunggu')
                                                                        <i class="fas fa-medal fs-2x text-bronze" title="Perunggu"></i>
                                                                    @endif
                                                                </div>
                                                            @endif

                                                            {{-- Bagian Teks Prestasi --}}
                                                            <div class="d-flex flex-column">
                                                                <span class="text-truncate-custom">{{ $prestasiTerbaru->nama_prestasi }}</span>
                                                                <small class="text-muted">{{ $prestasiTerbaru->tahun }}@if(isset($prestasiTerbaru->tempat)) • {{ $prestasiTerbaru->tempat }}@endif</small>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td class="d-none d-xl-table-cell">
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
                                                <td colspan="12" class="text-center py-5 text-muted">Data tidak ditemukan</td>
                                            </tr>
                                        @endforelse
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        <!-- Table Footer with Pagination -->
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

                                @if(isset($pelatih) && method_exists($pelatih, 'hasPages'))
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="d-flex align-items-center">
                                            <span class="me-2">Page</span>
                                            <select class="form-select form-select-sm" style="width: 80px;"
                                                    onchange="window.location.href = this.value">
                                                @for ($i = 1; $i <= $pelatih->lastPage(); $i++)
                                                    <option value="{{ $pelatih->url($i) }}"
                                                            {{ $pelatih->currentPage() == $i ? 'selected' : '' }}>
                                                        {{ $i }}
                                                    </option>
                                                @endfor
                                            </select>
                                            <span class="ms-2">of {{ $pelatih->lastPage() }}</span>
                                        </div>

                                        <div class="btn-group">
                                            <a href="{{ $pelatih->previousPageUrl() }}"
                                            class="btn btn-outline-secondary {{ $pelatih->onFirstPage() ? 'disabled' : '' }}">
                                                <i class="fas fa-chevron-left"></i>
                                            </a>
                                            <a href="{{ $pelatih->nextPageUrl() }}"
                                            class="btn btn-outline-secondary {{ !$pelatih->hasMorePages() ? 'disabled' : '' }}">
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
    @if (isset($pelatih) && $pelatih->isNotEmpty())
        <script>
            $(document).ready(function() {
                const table = $("#kt_datatable_dom_positioning").DataTable({
                    paging: false,
                    info: false,
                    searching: true,
                    ordering: true,
                    responsive: true,
                    autoWidth: false,
                    scrollX: false,
                    columnDefs: [
                                {
                                    targets: 0, // "No" column
                                    orderable: true,
                                    searchable: false
                                },
                                {
                                    targets: -1, // "Aksi" column
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
                            ]
                });

                const totalCount = table.rows().count();

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
                    const rowMedali = $row.data('medali');

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
                        if (prestasiFilter === 'emas' && rowMedali !== 'emas') return false;
                        if (prestasiFilter === 'perak' && rowMedali !== 'perak') return false;
                        if (prestasiFilter === 'perunggu' && rowMedali !== 'perunggu') return false;
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
            });
        </script>
    @endif
@endsection
