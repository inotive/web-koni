@extends('layouts.app')
@section('pageTitle', 'Cabang Olahraga')

@section('mainSection', 'Konfigurasi')
@section('mainSectionUrl', route('admin.konfigurasi.cabang-olahraga.index'))
@section('subSection', 'Cabang Olahraga')
@section('subSectionUrl', route('admin.konfigurasi.cabang-olahraga.index'))
@section('currentSection', 'Detail ')

@section('breadcrumb-title')
    {{-- Halaman Detail Cabang Olahraga --}}
@endsection

@section('content')

    <style>
/* Gaya Tab Baru - Kotak Penuh */
.nav-tabs .nav-link {
    border: none !important;
    border-radius: 8px !important;
    padding: 0.75rem 1.5rem !important;
    margin-right: 0.5rem !important;
    color: #6c757d !important;
    background-color: #f8f9fa !important;
    transition: all 0.3s ease !important;
    position: relative;
    display: flex;
    align-items: center;
}

.nav-tabs .nav-link.active {
    background-color: #3e66e0 !important;
    color: white !important;
    box-shadow: 0 4px 8px rgba(248, 40, 90, 0.2);
}

.nav-tabs .nav-link:hover:not(.active) {
    background-color: #e9ecef !important;
    color: #495057 !important;
}

/* Icon dan Teks dalam Tab */
.nav-tabs .nav-link i {
    margin-right: 8px;
    font-size: 1.2rem;
}

.nav-tabs .nav-link .badge {
    margin-left: 8px;
    font-weight: 500;
}

/* Badge khusus untuk tab aktif */
.nav-tabs .nav-link.active .badge {
    background-color: rgba(255,255,255,0.2) !important;
    color: white !important;
    border: 1px solid rgba(255,255,255,0.3);
}

/* Responsif untuk mobile */
@media (max-width: 768px) {
    .nav-tabs .nav-link {
        padding: 0.5rem 1rem !important;
        font-size: 0.875rem;
    }
    
    .nav-tabs .nav-link i {
        font-size: 1rem;
        margin-right: 6px;
    }
}
</style>

    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-6">
            <div class="flex-shrink-0 me-3">
                <a href="{{ route('admin.konfigurasi.cabang-olahraga.index') }}" class="btn btn-light-primary">
                    <i class="ki-duotone ki-arrow-left fs-2">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    Kembali
                </a>
            </div>
            <div class="flex-grow-1">
                <h1 class="page-heading d-flex text-dark fw-bold fs-1 my-0 align-items-center">
                    <i class="ki-duotone ki-sport fs-1 text-primary me-3">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    Detail Cabang Olahraga
                </h1>
            </div>
        </div>

        <div class="card">
            <div class="card-header border-0">
                <div class="card-title w-100">
                    <div class="nav nav-tabs nav-line-tabs nav-stretch fs-6 border-0 overflow-auto flex-nowrap">
                        <div class="nav-item flex-shrink-0">
                            <a class="nav-link active fw-bold" data-bs-toggle="tab" href="#kt_tab_pane_atlet">
                                <i class="ki-duotone ki-people fs-2 me-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                    <span class="path4"></span>
                                    <span class="path5"></span>
                                </i>
                                <span class="d-none d-sm-inline">Informasi </span>Atlet
                                <span class="badge badge-light-primary ms-2">{{ $cabor->atlets->count() ?? 0 }}</span>
                            </a>
                        </div>
                        <div class="nav-item flex-shrink-0">
                            <a class="nav-link fw-bold" data-bs-toggle="tab" href="#kt_tab_pane_pelatih">
                                <i class="ki-duotone ki-teacher fs-2 me-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                <span class="d-none d-sm-inline">Informasi </span>Pelatih
                                <span class="badge badge-light-success ms-2">{{ $cabor->pelatihs->count() ?? 0 }}</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="kt_tab_pane_atlet" role="tabpanel">
                        @if (($cabor->atlets ?? collect())->count() > 0)
                            {{-- Search dan Filter Atlet --}}
                            <div class="card-header border-0 pt-6">
                                <div class="card-title">
                                    <div class="d-flex align-items-center position-relative my-1">
                                        <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                        <input type="text" id="search-atlet"
                                            class="form-control form-control-solid w-250px ps-13"
                                            placeholder="Cari atlet..." />
                                    </div>
                                </div>
                                <div class="card-toolbar">
                                    <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                                        <button type="button" class="btn btn-light-primary me-3"
                                            data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                            <i class="ki-duotone ki-filter fs-2">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                            Filter
                                            <span id="filter-count-atlet"
                                                class="badge badge-light-danger d-none ms-2">0</span>
                                        </button>
                                        <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-kt-menu="true">
                                            <div class="px-7 py-5">
                                                <div class="fs-5 text-dark fw-bold">Filter Atlet</div>
                                            </div>
                                            <div class="separator border-gray-200"></div>
                                            <div class="px-7 py-5">
                                                <div class="mb-10">
                                                    <label class="form-label fw-semibold">Jenis Kelamin:</label>
                                                    <select id="filter-jenis-kelamin-atlet"
                                                        class="form-select form-select-solid fw-bold">
                                                        <option value="">Semua</option>
                                                        <option value="laki-laki">Laki-laki</option>
                                                        <option value="perempuan">Perempuan</option>
                                                    </select>
                                                </div>
                                                <div class="d-flex justify-content-end">
                                                    <button type="button" id="reset-filters-atlet"
                                                        class="btn btn-light btn-active-light-primary fw-bold me-2 px-6">Reset</button>
                                                    <button type="button" id="apply-filters-atlet"
                                                        class="btn btn-primary fw-bold px-6">Terapkan</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- End Search dan Filter Atlet --}}

                            <div class="table-responsive">
                                <table class="table table-row-dashed table-row-gray-300 gy-7 mb-0">
                                    <thead>
                                        <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                            <th class="min-w-50px ps-6">No</th>
                                            <th class="min-w-80px">Foto</th>
                                            <th class="min-w-150px">Nama Atlet</th>
                                            <th class="min-w-200px">Tempat & Tanggal Lahir</th>
                                            <th class="min-w-120px">Jenis Kelamin</th>
                                            <th class="min-w-80px">Usia</th>
                                            <th class="min-w-180px">Prestasi Terbaru</th>
                                            <th class="min-w-150px">Kontak</th>
                                            <th class="min-w-100px text-end pe-6">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($cabor->atlets as $index => $atlet)
                                            <tr>
                                                <td class="ps-6">
                                                    <span class="text-gray-800 fw-bold">{{ $index + 1 }}</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        @if ($atlet->foto)
                                                            <div class="symbol symbol-50px">
                                                                <img src="{{ asset('storage/' . $atlet->foto) }}"
                                                                    alt="Foto {{ $atlet->nama }}"
                                                                    class="rounded object-fit-cover">
                                                            </div>
                                                        @else
                                                            <div class="symbol symbol-50px">
                                                                <div class="symbol-label bg-light-primary text-primary">
                                                                    <i class="ki-duotone ki-user fs-2">
                                                                        <span class="path1"></span>
                                                                        <span class="path2"></span>
                                                                    </i>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column">
                                                        <span
                                                            class="text-gray-800 fw-bold mb-1">{{ $atlet->nama ?? '-' }}</span>
                                                        <span
                                                            class="text-muted fs-7">{{ Str::limit($atlet->alamat_domisili ?? '-', 30) }}</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="text-gray-800 fw-semibold">
                                                        <div>{{ $atlet->tempat_lahir ?? '-' }}</div>
                                                        <div class="text-muted fs-7">
                                                            {{ isset($atlet->tanggal_lahir) ? \Carbon\Carbon::parse($atlet->tanggal_lahir)->translatedFormat('d M Y') : '-' }}
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge badge-light-info">{{ ucfirst($atlet->jenis_kelamin ?? '-') }}</span>
                                                </td>
                                                <td>
                                                    <span class="text-gray-800 fw-semibold">
                                                        {{ isset($atlet->tanggal_lahir) ? \Carbon\Carbon::parse($atlet->tanggal_lahir)->age . ' th' : '-' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="text-gray-600">{{ Str::limit($atlet->prestasi_terbaru ?? '-', 60) }}</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column">
                                                        @if ($atlet->no_telepon)
                                                            <span class="text-gray-800 fs-7 mb-1">
                                                                <i class="ki-duotone ki-phone fs-6 me-1">
                                                                    <span class="path1"></span>
                                                                    <span class="path2"></span>
                                                                </i>
                                                                {{ $atlet->no_telepon }}
                                                            </span>
                                                        @endif
                                                        @if ($atlet->email)
                                                            <span class="text-gray-600 fs-7">
                                                                <i class="ki-duotone ki-sms fs-6 me-1">
                                                                    <span class="path1"></span>
                                                                    <span class="path2"></span>
                                                                </i>
                                                                {{ Str::limit($atlet->email, 20) }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="text-end pe-6">
                                                    <a href="{{ route('admin.konfigurasi.atlet.show', $atlet->id ?? '#') }}"
                                                        class="btn btn-sm btn-light-primary">
                                                        <i class="ki-duotone ki-eye fs-5">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                            <span class="path3"></span>
                                                        </i>
                                                        <span class="d-none d-md-inline ms-1">Lihat</span>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="d-flex flex-column flex-center text-center p-10">
                                <img src="{{ asset('assets/media/illustrations/sketchy-1/2.png') }}" alt=""
                                    class="mw-400px">
                                <div class="pt-10 pb-10">
                                    <h2 class="fs-2 fw-bold text-gray-600">Belum Ada Atlet</h2>
                                    <p class="text-gray-400 fs-6 fw-semibold">
                                        Belum ada atlet yang terdaftar untuk cabang olahraga ini.
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="tab-pane fade" id="kt_tab_pane_pelatih" role="tabpanel">
                        @if (($cabor->pelatihs ?? collect())->count() > 0)
                            {{-- Search dan Filter Pelatih --}}
                            <div class="card-header border-0 pt-6">
                                <div class="card-title">
                                    <div class="d-flex align-items-center position-relative my-1">
                                        <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                        <input type="text" id="search-pelatih"
                                            class="form-control form-control-solid w-250px ps-13"
                                            placeholder="Cari pelatih..." />
                                    </div>
                                </div>
                                <div class="card-toolbar">
                                    <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                                        <button type="button" class="btn btn-light-success me-3"
                                            data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                            <i class="ki-duotone ki-filter fs-2">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                            Filter
                                            <span id="filter-count-pelatih"
                                                class="badge badge-light-danger d-none ms-2">0</span>
                                        </button>
                                        <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px"
                                            data-kt-menu="true">
                                            <div class="px-7 py-5">
                                                <div class="fs-5 text-dark fw-bold">Filter Pelatih</div>
                                            </div>
                                            <div class="separator border-gray-200"></div>
                                            <div class="px-7 py-5">
                                                <div class="mb-10">
                                                    <label class="form-label fw-semibold">Jenis Kelamin:</label>
                                                    <select id="filter-jenis-kelamin-pelatih"
                                                        class="form-select form-select-solid fw-bold">
                                                        <option value="">Semua</option>
                                                        <option value="laki-laki">Laki-laki</option>
                                                        <option value="perempuan">Perempuan</option>
                                                    </select>
                                                </div>
                                                <div class="d-flex justify-content-end">
                                                    <button type="button" id="reset-filters-pelatih"
                                                        class="btn btn-light btn-active-light-success fw-bold me-2 px-6">Reset</button>
                                                    <button type="button" id="apply-filters-pelatih"
                                                        class="btn btn-success fw-bold px-6">Terapkan</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- End Search dan Filter Pelatih --}}

                            <div class="table-responsive">
                                <table class="table table-row-dashed table-row-gray-300 gy-7 mb-0">
                                    <thead>
                                        <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                            <th class="min-w-50px ps-6">No</th>
                                            <th class="min-w-80px">Foto</th>
                                            <th class="min-w-150px">Nama Pelatih</th>
                                            <th class="min-w-200px">Tempat & Tanggal Lahir</th>
                                            <th class="min-w-120px">Jenis Kelamin</th>
                                            <th class="min-w-80px">Usia</th>
                                            <th class="min-w-180px">Prestasi/Sertifikasi</th>
                                            <th class="min-w-150px">Kontak</th>
                                            <th class="min-w-100px text-end pe-6">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($cabor->pelatihs as $index => $pelatih)
                                            <tr>
                                                <td class="ps-6">
                                                    <span class="text-gray-800 fw-bold">{{ $index + 1 }}</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        @if ($pelatih->foto)
                                                            <div class="symbol symbol-50px">
                                                                <img src="{{ asset('storage/' . $pelatih->foto) }}"
                                                                    alt="Foto {{ $pelatih->nama }}"
                                                                    class="rounded object-fit-cover">
                                                            </div>
                                                        @else
                                                            <div class="symbol symbol-50px">
                                                                <div class="symbol-label bg-light-success text-success">
                                                                    <i class="ki-duotone ki-teacher fs-2">
                                                                        <span class="path1"></span>
                                                                        <span class="path2"></span>
                                                                    </i>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column">
                                                        <span
                                                            class="text-gray-800 fw-bold mb-1">{{ $pelatih->nama ?? '-' }}</span>
                                                        <span
                                                            class="text-muted fs-7">{{ Str::limit($pelatih->alamat_domisili ?? '-', 30) }}</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="text-gray-800 fw-semibold">
                                                        <div>{{ $pelatih->tempat_lahir ?? '-' }}</div>
                                                        <div class="text-muted fs-7">
                                                            {{ isset($pelatih->tanggal_lahir) ? \Carbon\Carbon::parse($pelatih->tanggal_lahir)->translatedFormat('d M Y') : '-' }}
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge badge-light-info">{{ ucfirst($pelatih->jenis_kelamin ?? '-') }}</span>
                                                </td>
                                                <td>
                                                    <span class="text-gray-800 fw-semibold">
                                                        {{ isset($pelatih->tanggal_lahir) ? \Carbon\Carbon::parse($pelatih->tanggal_lahir)->age . ' th' : '-' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="text-gray-600">{{ Str::limit($pelatih->prestasi_terbaru ?? '-', 60) }}</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column">
                                                        @if ($pelatih->no_telepon)
                                                            <span class="text-gray-800 fs-7 mb-1">
                                                                <i class="ki-duotone ki-phone fs-6 me-1">
                                                                    <span class="path1"></span>
                                                                    <span class="path2"></span>
                                                                </i>
                                                                {{ $pelatih->no_telepon }}
                                                            </span>
                                                        @endif
                                                        @if ($pelatih->email)
                                                            <span class="text-gray-600 fs-7">
                                                                <i class="ki-duotone ki-sms fs-6 me-1">
                                                                    <span class="path1"></span>
                                                                    <span class="path2"></span>
                                                                </i>
                                                                {{ Str::limit($pelatih->email, 20) }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="text-end pe-6">
                                                    <a href="{{ route('admin.konfigurasi.pelatih.show', $pelatih->id ?? '#') }}"
                                                        class="btn btn-sm btn-light-success">
                                                        <i class="ki-duotone ki-eye fs-5">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                            <span class="path3"></span>
                                                        </i>
                                                        <span class="d-none d-md-inline ms-1">Lihat</span>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="d-flex flex-column flex-center text-center p-10">
                                <img src="{{ asset('assets/media/illustrations/sketchy-1/2.png') }}" alt=""
                                    class="mw-400px">
                                <div class="pt-10 pb-10">
                                    <h2 class="fs-2 fw-bold text-gray-600">Belum Ada Pelatih</h2>
                                    <p class="text-gray-400 fs-6 fw-semibold">
                                        Belum ada pelatih yang terdaftar untuk cabang olahraga ini.
                                    </p>
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
            // Initialize Bootstrap tabs
            var triggerTabList = [].slice.call(document.querySelectorAll('.nav-tabs a'))
            triggerTabList.forEach(function(triggerEl) {
                var tabTrigger = new bootstrap.Tab(triggerEl)

                triggerEl.addEventListener('click', function(event) {
                    event.preventDefault()
                    tabTrigger.show()
                })
            });

            // Fungsi untuk tabel Atlet
            const atletTable = $('table').first(); // Tabel pertama adalah tabel atlet
            const atletRows = atletTable.find('tbody tr');

            $('#search-atlet').on('keyup', function() {
                const searchText = $(this).val().toLowerCase();
                filterAtletTable(searchText, $('#filter-jenis-kelamin-atlet').val());
            });

            $('#apply-filters-atlet').on('click', function() {
                filterAtletTable($('#search-atlet').val().toLowerCase(), $('#filter-jenis-kelamin-atlet')
                    .val());
                updateAtletFilterCount();
            });

            $('#reset-filters-atlet').on('click', function() {
                $('#search-atlet').val('');
                $('#filter-jenis-kelamin-atlet').val('');
                filterAtletTable('', '');
                updateAtletFilterCount();
            });

            function filterAtletTable(searchText, jenisKelamin) {
                atletRows.each(function() {
                    const row = $(this);
                    const nama = row.find('td:nth-child(3)').text().toLowerCase();
                    const jk = row.find('td:nth-child(5)').text().toLowerCase();

                    const cocokSearch = nama.includes(searchText) || searchText === '';
                    const cocokFilter = jk.includes(jenisKelamin) || jenisKelamin === '';

                    if (cocokSearch && cocokFilter) {
                        row.show();
                    } else {
                        row.hide();
                    }
                });
            }

            function updateAtletFilterCount() {
                const filterAktif = [];
                if ($('#filter-jenis-kelamin-atlet').val()) filterAktif.push('jenis_kelamin');

                const jumlah = filterAktif.length;
                const badge = $('#filter-count-atlet');

                if (jumlah > 0) {
                    badge.text(jumlah).removeClass('d-none');
                } else {
                    badge.addClass('d-none');
                }
            }

            // Fungsi untuk tabel Pelatih
            const pelatihTable = $('table').last(); // Tabel terakhir adalah tabel pelatih
            const pelatihRows = pelatihTable.find('tbody tr');

            $('#search-pelatih').on('keyup', function() {
                const searchText = $(this).val().toLowerCase();
                filterPelatihTable(searchText, $('#filter-jenis-kelamin-pelatih').val());
            });

            $('#apply-filters-pelatih').on('click', function() {
                filterPelatihTable($('#search-pelatih').val().toLowerCase(), $(
                    '#filter-jenis-kelamin-pelatih').val());
                updatePelatihFilterCount();
            });

            $('#reset-filters-pelatih').on('click', function() {
                $('#search-pelatih').val('');
                $('#filter-jenis-kelamin-pelatih').val('');
                filterPelatihTable('', '');
                updatePelatihFilterCount();
            });

            function filterPelatihTable(searchText, jenisKelamin) {
                pelatihRows.each(function() {
                    const row = $(this);
                    const nama = row.find('td:nth-child(3)').text().toLowerCase();
                    const jk = row.find('td:nth-child(5)').text().toLowerCase();

                    const cocokSearch = nama.includes(searchText) || searchText === '';
                    const cocokFilter = jk.includes(jenisKelamin) || jenisKelamin === '';

                    if (cocokSearch && cocokFilter) {
                        row.show();
                    } else {
                        row.hide();
                    }
                });
            }

            function updatePelatihFilterCount() {
                const filterAktif = [];
                if ($('#filter-jenis-kelamin-pelatih').val()) filterAktif.push('jenis_kelamin');

                const jumlah = filterAktif.length;
                const badge = $('#filter-count-pelatih');

                if (jumlah > 0) {
                    badge.text(jumlah).removeClass('d-none');
                } else {
                    badge.addClass('d-none');
                }
            }
        });
    </script>

    <style>
        /* Additional responsive styles */
        @media (max-width: 768px) {
            .d-flex.justify-content-between {
                flex-direction: column;
                align-items: stretch !important;
                gap: 1rem;
            }

            .page-heading {
                font-size: 1.5rem !important;
            }

            .nav-tabs {
                border-bottom: 1px solid #e4e6ea;
            }

            .nav-tabs .nav-link {
                padding: 0.75rem 1rem;
                white-space: nowrap;
            }
        }

        @media (max-width: 576px) {
            .page-heading {
                font-size: 1.25rem !important;
            }

            .table-responsive {
                font-size: 0.875rem;
            }

            .symbol {
                width: 40px !important;
                height: 40px !important;
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
