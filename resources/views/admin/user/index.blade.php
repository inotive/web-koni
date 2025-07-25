@extends('layouts.app')


@push('stack-css')
    <style>
        th.sorting::after {
            float: right;
            font-size: 0.75rem;
            opacity: 0.5;
        }

        th.sorting_asc::after {
            float: right;
            font-size: 0.75rem;
            opacity: 1;
        }

        th.sorting_desc::after {
            float: right;
            font-size: 0.75rem;
            opacity: 1;
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
                        <table id="kt_datatable_dom_positioning" class="table table-row-bordered gy-5 gs-7 border rounded">
                            <thead>
                                <tr class="fw-bold fs-6 text-gray-800 px-7" style="background-color: #FCFCFC">
                                    <th class="col-1 text-center">No</th>
                                    <th class="col-4 text-start">Nama</th>
                                    <th class="col-1 text-center">Jabatan</th>
                                    <th class="col-3 text-center">Email</th>
                                    <th class="col-2 text-center">Tanggal Di Tambahkan</th>
                                    <th class="col-1 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="table-body">
                                @foreach ($users as $value)
                                    <tr id="{{ $value->id }}">
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-center">
                                            <div class="d-flex gap-5">
                                                <div class="text-center align-content-center">
                                                    {{ $value->username }}
                                                </div>
                                            </div>
                                        </td>
                                        @foreach ($value->getRoleNames() as $roleName)
                                            <td class="text-capitalize text-center">{{ $roleName }}</td>
                                        @endforeach
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
                                                        {{-- <form action="{{ route('admin.manajemen-pengguna.pengguna.destroy', $value->id) }}" method="post">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="dropdown-item d-flex align-items-center gap-2 text-danger">
                                                                   <i class="ki-duotone ki-trash fs-5"></i> Hapus
                                                                </button>
                                                            </form> --}}
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
                                    @foreach ($users as $value)
                                        @include('admin.user.component.modal', [
                                            'value' => $value,
                                            'roles' => $roles,
                                        ])
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                        {{-- End Table --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.user.component.modal-tambah', ['roles' => $roles])

@endsection

@section('script')
    <script>
        const table = $("#kt_datatable_dom_positioning").DataTable();
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
