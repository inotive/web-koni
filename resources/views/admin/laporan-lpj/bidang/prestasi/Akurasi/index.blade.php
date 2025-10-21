@extends('layouts.app')

@section('pageTitle', 'Cabor Akurasi')
@section('mainSection', 'Laporan LPJ')
@section('subSection', 'Bidang Bidang')
@section('subSectionUrl', route('admin.laporan-lpj.bidang.index', ['year' => $selectedYear]))
@section('subSection2', 'Pembinaan Prestasi')
@section('subSection2Url', route('admin.laporan-lpj.bidang.prestasi.index', ['year' => $selectedYear]))
@section('currentSection', 'Cabor Akurasi')

@section('content')
    <div class="d-grid gap-5 border-0">
        <div class="d-flex justify-content-between align-items-center container">
            <div class="d-none d-md-block">
                <h1>Cabor Akurasi</h1>
                <span>Informasi Cabor Akurasi untuk tahun {{ $selectedYear }}</span>
            </div>
            <form id="filter" action="{{ route('admin.laporan-lpj.bidang.prestasi.cabor-akurasi') }}" method="GET" class="d-flex gap-3">
                <div class="position-relative bg-light" style="width: 180px">
                    <i class="ki-outline ki-magnifier fs-2 position-absolute top-50 translate-middle-y ms-3"></i>
                    <input type="text" name="search" value="{{ request('search') }}" data-kt-docs-table-filter="search"
                        placeholder="Cari Teams" class="form-control border border-gray-500 py-2 ps-12" />
                </div>
            </form>
        </div>

        {{-- @php
            // Calculate totals for this cabor
            $total_anggaran = 0;
            $total_kegiatan = 0;

            // Loop through children to calculate totals
            foreach($children as $child) {
                $total_kegiatan += $child->children_count;

                // Get great grandchildren to calculate anggaran
                $grandchildren = $child->children;
                foreach($grandchildren as $grandchild) {
                    $total_anggaran += $grandchild->jumlah_harga ?? 0;
                }
            }

            $target_anggaran = 200000000; // Example target, replace with actual target
            $target_kegiatan = 20; // Example target, replace with actual target
            $anggaran_percentage = $target_anggaran > 0 ? ($total_anggaran / $target_anggaran) * 100 : 0;
        @endphp

        <div class="container">
            <div class="top-progress-wrapper mb-4">
                <h3 class="text-muted mb-0">Total Anggaran</h3>
                <div class="d-flex justify-content-between mb-2">
                    <h1 class="fw-bold mb-1">Rp. {{ number_format($total_anggaran, 0, ',', '.') }} / Rp. {{ number_format($target_anggaran, 0, ',', '.') }}</h1>
                    <h3 class="text-muted mb-0" data-bs-toggle="tooltip" title="{{ round($anggaran_percentage, 2) }}% dari total anggaran">
                        {{ round($anggaran_percentage) }}%
                    </h3>
                </div>

                <div class="progress" style="height: 18px; border-radius: 12px; background-color: #f1f1f1;">
                    <div class="progress-bar progress-bar-striped progress-bar-animated"
                        role="progressbar"
                        style="width: {{ $anggaran_percentage }}%; background-color: #F8285A; border-radius: 12px;"
                        aria-valuenow="{{ $anggaran_percentage }}"
                        aria-valuemin="0"
                        aria-valuemax="100">
                    </div>
                </div>

                <div class="d-flex flex-row-reverse bd-highlight mt-2">
                    <div class="info-label mt-1 d-flex align-items-center gap-2">
                        <span class="badge bg-success-subtle text-success fw-semibold px-3 py-1 border border-success-subtle">
                            {{ $total_kegiatan }} Kegiatan Berjalan
                        </span>
                        <span>/</span>
                        <span class="badge bg-primary-subtle text-primary fw-semibold px-3 py-1 border border-primary-subtle">
                            {{ $target_kegiatan }} Target Kegiatan
                        </span>
                    </div>
                </div>
            </div>
        </div> --}}

        <div id="table" class="container">
            @include('admin.laporan-lpj.bidang.prestasi.Akurasi._table')
        </div>
    </div>
@endsection

@section('script')
    <script>
        function filterAndSort() {
            const searchValue = $('input[name="search"]').val().toLowerCase();
            const sortBy = $('#sortBy').val();
            const $folders = $('#table .row .col-12, #table .row .col-sm-6, #table .row .col-md-3');

            // Filter folders
            let visibleFolders = [];
            $folders.each(function() {
                const $folder = $(this);
                const folderName = $folder.find('h5').text().toLowerCase();

                if (folderName.includes(searchValue)) {
                    $folder.show();
                    visibleFolders.push($folder);
                } else {
                    $folder.hide();
                }
            });

            // Sort visible folders
            visibleFolders.sort(function(a, b) {
                const nameA = $(a).find('h5').text().toLowerCase();
                const nameB = $(b).find('h5').text().toLowerCase();

                if (sortBy === 'ASC') {
                    return nameA.localeCompare(nameB);
                } else {
                    return nameB.localeCompare(nameA);
                }
            });

            // Reorder folders in the DOM
            const $container = $('#table .row');
            visibleFolders.forEach(function($folder) {
                $container.append($folder);
            });

            // Show "no results" message if no folders match
            if (visibleFolders.length === 0 && searchValue !== '') {
                if ($('#no-results').length === 0) {
                    $container.append(`
                        <div id="no-results" class="col-12 text-center py-5">
                            <div class="text-muted">
                                <i class="ki-outline ki-file-search" style="font-size: 48px;"></i>
                                <h4>Tidak ditemukan hasil</h4>
                                <p>Coba kata kunci lain untuk pencarian</p>
                            </div>
                        </div>
                    `);
                }
            } else {
                $('#no-results').remove();
            }
        }

        function debounce(func, delay) {
            let timeout;
            return function() {
                const context = this,
                    args = arguments;
                clearTimeout(timeout);
                timeout = setTimeout(() => func.apply(context, args), delay);
            };
        }

        $(document).ready(function() {
            // Search functionality
            $(document).on('input', '#filter input[name="search"]', debounce(function() {
                filterAndSort();
            }, 300));

            // Sort functionality
            $(document).on('change', '#sortBy', function() {
                filterAndSort();
            });

            // Initial sort
            filterAndSort();
        });
    </script>
@endsection