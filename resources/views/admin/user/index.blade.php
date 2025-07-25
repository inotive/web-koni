@extends('layouts.app')


@push('stack-css')
    <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet" />

    <style>
        /* Style dasar tabel */
        table.table th,
        table.table td {
            border: 0.5px solid #F1F1F4 !important;
            vertical-align: middle;
        }

        table.dataTable thead th {
            color: #4B5675 !important;
            position: relative;
        }

        /* Kolom No: pastikan tidak ada ikon bawaan */
        table.dataTable thead>tr>th:nth-child(1)::before,
        table.dataTable thead>tr>th:nth-child(1)::after {
            content: "" !important;
            display: none !important;
        }

        /* Nonaktifkan efek hover cursor dari DataTables jika pakai header custom */
        table.dataTable thead th.sorting,
        table.dataTable thead th.sorting_asc,
        table.dataTable thead th.sorting_desc {
            background-image: none !important;
        }

        /* Ikon sort kustom */
        .sort-header {
            user-select: none;
            cursor: pointer;
        }

        .sort-icon {
            transition: transform 0.3s ease;
        }

        .rotate-asc {
            transform: rotate(180deg);
        }

        .rotate-desc {
            transform: rotate(0deg);
        }
    </style>
@endpush

@section('pageTitle', 'Pengguna')
@section('mainSection', 'Manajemen Pengguna')
@section('currentSection', 'Pengguna')


@section('content')
    <div class="row col-12 mt-5">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold fs-3 mb-1">Daftar Pengguna</span>
                </h3>
                <div class="card-toolbar d-flex gap-2">
                    <div class="col-5">
                        <input type="search" name="search" id="search" class="form-control" placeholder="Search">
                    </div>
                    <a href="#" class="btn text-white" style="background-color: #F8285A;" data-bs-toggle="modal"
                        data-bs-target="#kt_modal_tambah_pengguna">
                        <i class="ki-duotone ki-plus fs-2" style="color: white"></i>Tambah Pengguna
                    </a>
                </div>
            </div>
            <div class="card-body ">
                <div class="row g-12 g-xl-12">
                    <div class="col-xl-12">
                        <table id="kt_datatable_dom_positioning"
                            class="table table-bordered  align-middle text-gray-800 fs-6 gy-5">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-center fw-semibold text-gray-700">No</th>
                                    <th class="text-start fw-semibold text-gray-700 cursor-pointer sort-header "
                                        data-column="1">
                                        <span>Nama</span>
                                        <svg class="sort-icon ms-2 transition-rotate" width="16" height="16"
                                            stroke="currentColor" fill="none" stroke-width="1.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3 7.5 7.5 3m0 0L12 7.5M7.5 3v13.5m13.5 0L16.5 21m0 0L12 16.5m4.5 4.5V7.5" />
                                        </svg>
                                    </th>
                                    <th class="text-center fw-semibold text-gray-700 cursor-pointer sort-header "
                                        data-column="2">
                                        <span>Jabatan</span>
                                        <svg class="sort-icon ms-2 transition-rotate" width="16" height="16"
                                            stroke="currentColor" fill="none" stroke-width="1.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3 7.5 7.5 3m0 0L12 7.5M7.5 3v13.5m13.5 0L16.5 21m0 0L12 16.5m4.5 4.5V7.5" />
                                        </svg>
                                    </th>
                                    <th class="text-center fw-semibold text-gray-700 cursor-pointer sort-header "
                                        data-column="3">
                                        <span>Email</span>
                                        <svg class="sort-icon ms-2 transition-rotate" width="16" height="16"
                                            stroke="currentColor" fill="none" stroke-width="1.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3 7.5 7.5 3m0 0L12 7.5M7.5 3v13.5m13.5 0L16.5 21m0 0L12 16.5m4.5 4.5V7.5" />
                                        </svg>
                                    </th>
                                    <th class="text-center fw-semibold text-gray-700 cursor-pointer sort-header "
                                        data-column="4">
                                        <span>Tanggal Dibuat</span>
                                    </th>
                                    <th class="text-center fw-semibold text-gray-700">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $value)
                                    <tr id="{{ $value->id }}">
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-start">{{ $value->username }}</td>
                                        <td class="text-center text-capitalize">{{ $value->getRoleNames()->first() }}</td>
                                        <td class="text-center">{{ $value->email }}</td>
                                        <td class="text-center">
                                            {{ \Carbon\Carbon::parse($value->created_at)->format('d/m/Y') }}</td>
                                        <td class="text-center">
                                            <div class="dropdown">
                                                <button class="btn btn-sm" type="button" data-bs-toggle="dropdown"
                                                    aria-expanded="false"
                                                    style="padding: 7px; border: 1px solid #DBDFE9; border-radius: 6px;">
                                                    <svg fill="none" stroke-width="1.5" stroke="currentColor"
                                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                                                        width="24" height="24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M12 6.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 12.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 18.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5Z" />
                                                    </svg>
                                                </button>

                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a href="#" data-bs-toggle="modal"
                                                            data-bs-target="#modalEditPengguna{{ $value->id }}"
                                                            class="dropdown-item d-flex align-items-center gap-2">
                                                            <i class="ki-duotone ki-pencil fs-5"></i> Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <button
                                                            class="dropdown-item d-flex align-items-center gap-2 text-danger"
                                                            onclick="destroyItem(this)"
                                                            data-route="{{ route('admin.manajemen-pengguna.pengguna.destroy', $value->id) }}">
                                                            <i class="ki-duotone ki-trash fs-5"></i> Hapus
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{-- End Table --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @foreach ($users as $value)
        @include('admin.user.component.modal', [
            'value' => $value,
            'roles' => $roles,
        ])
    @endforeach
    @include('admin.user.component.modal-tambah', ['roles' => $roles])

@endsection

@section('script')
    <script>
        let table;

        $(document).ready(function() {
            table = $('#kt_datatable_dom_positioning').DataTable({
                paging: true,
                info: true,
                ordering: true,
                columnDefs: [{
                    orderable: false,
                    targets: [0, 4, 5]
                }],
                initComplete: function() {
                    $('#kt_datatable_dom_positioning thead th').removeClass(
                        'sorting sorting_asc sorting_desc');
                }
            });
            table.on('order.dt', function() {
                $('.sort-icon').removeClass('rotate-asc rotate-desc');

                const order = table.order();
                if (order.length > 0) {
                    const colIndex = order[0][0];
                    const direction = order[0][1];

                    const th = $('th[data-column="' + colIndex + '"]');
                    const icon = th.find('.sort-icon');

                    if (direction === 'asc') {
                        icon.addClass('rotate-asc');
                    } else if (direction === 'desc') {
                        icon.addClass('rotate-desc');
                    }
                }
            });

        });

        $('#search').on('keyup', function() {
            table.search(this.value).draw();
        });

        // Fungsi global untuk menghapus data
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
    </script>
@endsection
