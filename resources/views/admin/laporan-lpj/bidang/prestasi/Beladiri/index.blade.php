@extends('layouts.app')

@section('pageTitle', 'Cabor Beladiri')
@section('mainSection', 'Laporan LPJ')
@section('subSection', 'Bidang Bidang')
@section('subSectionUrl', route('admin.laporan-lpj.bidang.index'))
@section('subSection2', 'Pembinaan Prestasi')
@section('subSection2Url', route('admin.laporan-lpj.bidang.prestasi.index'))
@section('currentSection', 'Cabor Beladiri')

@section('content')
    <div class="d-grid gap-5 border-0">
        <div class="d-flex justify-content-between align-items-center container">
            <div class="d-none d-md-block">
                <h1>Cabor Beladiri</h1>
                <span>Informasi Cabor Beladiri</span>
            </div>
            <form id="filter" class="d-flex gap-3">
                <div class="position-relative bg-light" style="width: 180px">
                    <i class="ki-outline ki-magnifier fs-2 position-absolute top-50 translate-middle-y ms-3"></i>
                    <input type="text" name="search" value="{{ request('search') }}" data-kt-docs-table-filter="search"
                        placeholder="Cari Teams" class="form-control border border-gray-500 py-2 ps-12" />
                </div>
                {{-- <select name="sortBy" id="sortBy" class="form-select border border-gray-500 py-2" style="width: 85px">
                    <option value="ASC">A - Z</option>
                    <option value="DESC">Z - A</option>
                </select> --}}
            </form>
        </div>

        <div id="table" class="container">
            @include('admin.laporan-lpj.bidang.prestasi.beladiri._table')
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
