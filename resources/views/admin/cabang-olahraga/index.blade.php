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
            max-width: 200px;
        }

        .object-fit-cover {
            object-fit: cover;
        }

        .table-responsive {
            overflow-x: visible !important;
        }

        .table th:nth-child(1) {
            width: 50px;
        }

        /* No */
        .table th:nth-child(2) {
            width: 200px;
        }

        /* Nama Cabor dengan Icon */
        .table th:nth-child(3) {
            width: 180px;
        }

        /* Ketua Penanggung Jawab */
        .table th:nth-child(4) {
            width: 120px;
        }

        /* Status */
        .table th:nth-child(5) {
            width: 120px;
        }

        /* Tanggal Pembentukan */
        .table th:nth-child(6) {
            width: 80px;
        }

        /* Jumlah Atlet */
        .table th:nth-child(7) {
            width: 80px;
        }

        /* Jumlah Pelatih */
        .table th:nth-child(8) {
            width: 120px;
        }

        /* Terakhir Update */
        .table th:nth-child(9) {
            width: 100px;
        }

        .text-truncate-custom {
            max-width: 120px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* Responsive adjustments */
        @media (max-width: 1200px) {

            .table th:nth-child(5),
            .table th:nth-child(6),
            .table th:nth-child(7),
            .table th:nth-child(8) {
                display: none;
            }

            .table td:nth-child(5),
            .table td:nth-child(6),
            .table td:nth-child(7),
            .table td:nth-child(8) {
                display: none;
            }
        }

        @media (max-width: 768px) {

            .table th:nth-child(3),
            .table th:nth-child(4) {
                display: none;
            }

            .table td:nth-child(3),
            .table td:nth-child(4) {
                display: none;
            }

            .card-body {
                overflow-x: hidden !important;
            }

            .table-responsive {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }
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
                        <form method="GET" action="{{ route('admin.konfigurasi.cabang-olahraga.index') }}" class="d-flex align-items-center gap-2">
                            <div class="input-group" style="width: 250px;">
                                <input type="search" name="search" id="search" class="form-control"
                                    placeholder="Cari cabang olahraga..." value="{{ request('search') }}">
                                <button class="btn btn-outline-secondary" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>

                            <div class="dropdown">
                                <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                    data-bs-toggle="dropdown">
                                    <i class="fas fa-filter me-1"></i> Filter
                                    @if(request('filter_status'))
                                        <span class="badge badge-circle badge-danger ms-1">1</span>
                                    @endif
                                </button>
                                <div class="dropdown-menu p-3 shadow" style="min-width: 320px;">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Status Keaktifan</label>
                                        <select name="filter_status" class="form-select">
                                            <option value="">Semua Status</option>
                                            <option value="Aktif" {{ request('filter_status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                            <option value="Tidak Aktif" {{ request('filter_status') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                        </select>
                                    </div>

                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary btn-sm flex-fill">
                                            <i class="ki-duotone ki-check fs-3"></i>Terapkan
                                        </button>
                                        <a href="{{ route('admin.konfigurasi.cabang-olahraga.index') }}" class="btn btn-light btn-sm flex-fill">
                                            <i class="ki-duotone ki-arrows-circle fs-3"></i>Reset
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                @if ($cabors->isEmpty())
                    <div class="text-center text-muted py-10">
                        <i class="ki-duotone ki-information-5 fs-3x mb-3"></i>
                        <h4>Tidak ada data cabang olahraga.</h4>
                    </div>
                @else
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="text-muted">
                            Menampilkan {{ $cabors->firstItem() }} sampai {{ $cabors->lastItem() }} dari {{ $cabors->total() }} cabang olahraga
                        </div>
                        
                        <div class="d-flex align-items-center gap-2">
                            <span class="text-muted">Tampilkan:</span>
                            <form method="GET" action="{{ route('admin.konfigurasi.cabang-olahraga.index') }}" class="d-inline">
                                @foreach(request()->except('perPage') as $key => $value)
                                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                @endforeach
                                <select name="perPage" class="form-select form-select-sm w-auto" onchange="this.form.submit()">
                                    <option value="10" {{ request('perPage', 10) == 10 ? 'selected' : '' }}>10</option>
                                    <option value="25" {{ request('perPage') == 25 ? 'selected' : '' }}>25</option>
                                    <option value="50" {{ request('perPage') == 50 ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ request('perPage') == 100 ? 'selected' : '' }}>100</option>
                                </select>
                            </form>
                            <span class="text-muted">per halaman</span>
                        </div>
                    </div>

                    {{-- Table --}}
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th>No</th>
                                    <th>
                                        <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'nama_cabor', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}" 
                                           class="text-dark text-decoration-none">
                                            Nama Cabor
                                            @if(request('sort_by') == 'nama_cabor')
                                                <i class="fas fa-sort-{{ request('order') == 'asc' ? 'up' : 'down' }}"></i>
                                            @else
                                                <i class="fas fa-sort text-muted"></i>
                                            @endif
                                        </a>
                                    </th>
                                    <th class="d-none d-md-table-cell">
                                        <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'ketua_penanggung_jawab', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}" 
                                           class="text-dark text-decoration-none">
                                            Ketua Penanggung Jawab
                                            @if(request('sort_by') == 'ketua_penanggung_jawab')
                                                <i class="fas fa-sort-{{ request('order') == 'asc' ? 'up' : 'down' }}"></i>
                                            @else
                                                <i class="fas fa-sort text-muted"></i>
                                            @endif
                                        </a>
                                    </th>
                                    <th class="d-none d-md-table-cell">
                                        <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'status', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}" 
                                           class="text-dark text-decoration-none">
                                            Status
                                            @if(request('sort_by') == 'status')
                                                <i class="fas fa-sort-{{ request('order') == 'asc' ? 'up' : 'down' }}"></i>
                                            @else
                                                <i class="fas fa-sort text-muted"></i>
                                            @endif
                                        </a>
                                    </th>
                                    <th class="d-none d-xl-table-cell">
                                        <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'tanggal_pembentukan', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}" 
                                           class="text-dark text-decoration-none">
                                            Tanggal Pembentukan
                                            @if(request('sort_by') == 'tanggal_pembentukan')
                                                <i class="fas fa-sort-{{ request('order') == 'asc' ? 'up' : 'down' }}"></i>
                                            @else
                                                <i class="fas fa-sort text-muted"></i>
                                            @endif
                                        </a>
                                    </th>
                                    <th class="d-none d-xl-table-cell">Jumlah Atlet</th>
                                    <th class="d-none d-xl-table-cell">Jumlah Pelatih</th>
                                    <th class="d-none d-xl-table-cell">
                                        <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'terakhir_update', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}" 
                                           class="text-dark text-decoration-none">
                                            Terakhir Update
                                            @if(request('sort_by') == 'terakhir_update')
                                                <i class="fas fa-sort-{{ request('order') == 'asc' ? 'up' : 'down' }}"></i>
                                            @else
                                                <i class="fas fa-sort text-muted"></i>
                                            @endif
                                        </a>
                                    </th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($cabors as $index => $cabor)
                                    <tr>
                                        <td class="text-center">{{ $cabors->firstItem() + $index }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if ($cabor->icon_cabor)
                                                    <img src="{{ asset('storage/' . $cabor->icon_cabor) }}" width="20"
                                                        height="20" class="rounded object-fit-cover me-3">
                                                @else
                                                    <div class="rounded bg-secondary text-white text-center fw-bold d-flex align-items-center justify-content-center me-3"
                                                        style="width: 40px; height: 40px;">
                                                        <i class="ki-duotone ki-picture fs-2"></i>
                                                    </div>
                                                @endif
                                                <div class="d-flex flex-column">
                                                    <strong class="text-truncate-custom">{{ $cabor->nama_cabor }}</strong>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="d-none d-md-table-cell">
                                            <div class="text-truncate-custom" title="{{ $cabor->ketua_penanggung_jawab }}">
                                                {{ $cabor->ketua_penanggung_jawab }}
                                            </div>
                                        </td>
                                        <td class="d-none d-md-table-cell">
                                            <span class="badge {{ $cabor->status == 'Aktif' ? 'badge-light-success' : 'badge-light-danger' }}">
                                                {{ $cabor->status }}
                                            </span>
                                        </td>
                                        <td class="d-none d-xl-table-cell">
                                            {{ \Carbon\Carbon::parse($cabor->tanggal_pembentukan)->format('d M Y') }}
                                        </td>
                                        <td class="d-none d-xl-table-cell text-center">
                                            {{ $cabor->atlets ? $cabor->atlets->count() : 0 }}
                                        </td>
                                        <td class="d-none d-xl-table-cell text-center">
                                            {{ $cabor->pelatihs ? $cabor->pelatihs->count() : 0 }}
                                        </td>
                                        <td class="d-none d-xl-table-cell">
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

                    {{-- Pagination --}}
                    <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap">
                        <div class="mb-2 mb-md-0">
                            <span class="text-muted">
                                Menampilkan {{ $cabors->firstItem() }} sampai {{ $cabors->lastItem() }} 
                                dari {{ $cabors->total() }} hasil
                            </span>
                        </div>

                        <div>
                            {{ $cabors->links('pagination::bootstrap-4') }}
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
@endsection