@extends('layouts.app')

@section('pageTitle', 'Manajemen Atlet')
@section('mainSection', 'Konfigurasi')
@section('currentSection', 'Atlet')

@section('breadcrumb-title')
    <h1 class="d-flex flex-column text-dark fw-bold fs-3 mb-0">Halaman Atlet</h1>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item text-gray-600">Atlet</li>
@endsection

@section('content')
    <div class="row col-12 mt-5">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold fs-3 mb-1">Daftar Atlet</span>
                </h3>
                <div class="card-toolbar d-flex gap-2">
                    <div class="col-5">
                        <input type="search" name="search" id="search" class="form-control" placeholder="Cari atlet...">
                    </div>

                    <div class="btn-group">
                        <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="fa-solid fa-filter"></i>
                            <span id="filter-count" class="badge badge-circle badge-danger ms-1 d-none">0</span>
                        </button>
                        <div class="dropdown-menu p-4" style="min-width: 320px;">
                            <h6 class="dropdown-header">Filter Data Atlet</h6>
                            <div class="separator separator-dashed my-3"></div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold fs-7">Cabang Olahraga</label>
                                <select id="filter-cabor" class="form-select form-select-sm">
                                    <option value="">Semua Cabor</option>
                                    @foreach ($atlets->pluck('cabor')->unique()->filter() as $cabor)
                                        <option value="{{ $cabor }}">{{ $cabor }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold fs-7">Jenis Kelamin</label>
                                <select id="filter-gender" class="form-select form-select-sm">
                                    <option value="">Semua</option>
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold fs-7">Rentang Usia</label>
                                <select id="filter-age" class="form-select form-select-sm">
                                    <option value="">Semua Usia</option>
                                    <option value="15-20">15-20 tahun</option>
                                    <option value="21-25">21-25 tahun</option>
                                    <option value="26-30">26-30 tahun</option>
                                    <option value="31-35">31-35 tahun</option>
                                    <option value="36+">36+ tahun</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold fs-7">Status Prestasi</label>
                                <select id="filter-prestasi" class="form-select form-select-sm">
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
                                    <i class="ki-duotone ki-check fs-3"></i>Terapkan
                                </button>
                                <button type="button" id="reset-filters" class="btn btn-light btn-sm flex-fill">
                                    <i class="ki-duotone ki-arrows-circle fs-3"></i>Reset
                                </button>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('admin.konfigurasi.atlet.create') }}" class="btn custom-red-button"
                        style="background-color: #F8285A !important; color: white !important; border-color: #F8285A !important;">
                        <i class="ki-duotone ki-plus fs-2" style="color: white !important;"></i>Tambah Atlet
                    </a>
                </div>
            </div>



            <div class="card-body">
                @if ($atlets->isEmpty())
                    <div class="text-center text-muted py-10">
                        <i class="ki-duotone ki-information-5 fs-3x mb-3"></i>
                        <h4>Tidak ada data atlet.</h4>
                    </div>
                @else
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div id="filter-info" class="text-muted">
                            Menampilkan <span id="showing-count">{{ $atlets->count() }}</span> dari <span
                                id="total-count">{{ $atlets->count() }}</span> atlet
                        </div>
                    </div>

                    <table id="kt_datatable_dom_positioning"
                        class="table table-row-bordered gy-5 gs-7 border rounded w-100">
                        <thead>
                            <tr class="fw-bold fs-6 text-gray-800 px-7 text-center">
                                <th>No</th>
                                <th>Foto Atlet</th>
                                <th>Nama & Cabor</th>
                                <th>Tempat, Tanggal Lahir</th>
                                <th>Alamat</th>
                                <th>Jenis Kelamin</th>
                                <th>Usia</th>
                                <th>No Telepon</th>
                                <th>Email</th>
                                <th>Prestasi Terbaru</th>
                                <th>Tanggal Ditambahkan</th>
                                <th class="text-center sticky-action" style="width: 120px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($atlets as $atlet)
                                <tr data-cabor="{{ $atlet->cabor }}" data-gender="{{ $atlet->jenis_kelamin }}"
                                    data-age="{{ $atlet->umur }}"
                                    data-prestasi="{{ $atlet->prestasiTerbaru ? 'ada' : 'tidak' }}"
                                    data-medali="{{ $atlet->prestasiTerbaru ? strtolower($atlet->prestasiTerbaru->medali) : '' }}">
                                    <td class="text-center">{{ $loop->iteration }}</td>

                                    <td class="text-center">
                                        @if ($atlet->foto_atlet)
                                            <img src="{{ asset('storage/' . $atlet->foto_atlet) }}" alt="Foto Atlet"
                                                width="60" height="60" class="rounded-circle object-fit-cover">
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>

                                    <td>
                                        <div class="fw-semibold">{{ $atlet->nama }}</div>
                                        <div><small class="text-muted">{{ $atlet->cabor }}</small></div>
                                    </td>

                                    <td>{{ $atlet->tempat_lahir }},
                                        {{ \Carbon\Carbon::parse($atlet->tanggal_lahir)->format('d-m-Y') }}</td>
                                    <td>{{ $atlet->alamat }}</td>
                                    <td class="text-center">{{ $atlet->jenis_kelamin }}</td>
                                    <td>{{ $atlet->umur }}</td>
                                    <td>{{ $atlet->no_telepon ?? '-' }}</td>
                                    <td>{{ $atlet->email ?? '-' }}</td>
                                    <td>
                                        @if ($atlet->prestasiTerbaru)
                                            <div class="d-flex align-items-center">
                                                @php
                                                    $medalColor = '#A0A0A0';
                                                    if ($atlet->prestasiTerbaru->medali == 'Emas') {
                                                        $medalColor = '#FFD700';
                                                    } elseif ($atlet->prestasiTerbaru->medali == 'Perak') {
                                                        $medalColor = '#C0C0C0';
                                                    } elseif ($atlet->prestasiTerbaru->medali == 'Perunggu') {
                                                        $medalColor = '#CD7F32';
                                                    }
                                                @endphp
                                                <span class="me-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                        viewBox="0 0 24 24">
                                                        <circle cx="12" cy="12" r="10"
                                                            fill="{{ $medalColor }}" />
                                                        <path
                                                            d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"
                                                            fill="white" opacity="0.7" />
                                                    </svg>
                                                </span>
                                                <div>
                                                    <div class="fw-semibold">{{ $atlet->prestasiTerbaru->nama_prestasi }}
                                                    </div>
                                                    <div class="text-muted fs-7">{{ $atlet->prestasiTerbaru->tahun }}
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>{{ $atlet->created_at->format('d-m-Y') }}</td>

                                    <td class="text-center sticky-action">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('admin.konfigurasi.atlet.show', $atlet->id) }}"
                                                class="btn btn-icon btn-sm btn-light-primary" title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.konfigurasi.atlet.edit', $atlet->id) }}"
                                                class="btn btn-icon btn-sm btn-light-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.konfigurasi.atlet.destroy', $atlet->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus atlet ini?')"
                                                style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-icon btn-sm btn-light-danger"
                                                    title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('script')
    @if ($atlets->isNotEmpty())
        <script>
            $(document).ready(function() {
                const table = $("#kt_datatable_dom_positioning").DataTable({
                    scrollX: true,
                    responsive: true,
                    columnDefs: [{
                        targets: -1,
                        orderable: false,
                        searchable: false
                    }]
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
                        const [minAge, maxAge] = ageFilter.split('-').map(age => {
                            if (age === '36+') return [36, 999];
                            return parseInt(age);
                        });

                        if (ageFilter === '36+') {
                            if (rowAge < 36) return false;
                        } else {
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
