@extends('layouts.app')


@push('stack-css')
@endpush
@section('pageTitle', 'Jabatan')
@section('mainSection', 'Manajemen Pengguna')
@section('currentSection', 'Jabatan & Hak Akses')

@section('content')
    <div class="row col-12 mt-5">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold fs-3 mb-1">Daftar Jabatan</span>
                </h3>

                <div class="card-toolbar d-flex gap-2">
                    <div class="col-5">
                        <input type="search" name="search" id="search" class="form-control" placeholder="Search">
                    </div class="">
                    <a href="#" class="btn text-white" style="background-color: #F8285A;" data-bs-toggle="modal"
                        data-bs-target="#kt_modal_tambah">
                        <i class="ki-duotone ki-plus fs-2" style="color: white"></i>Tambah Jabatan</a>
                </div>
            </div>
            <div class="card-body ">
                <div class="row g-12 g-xl-12">
                    <div class="col-xl-12">
                        <table id="kt_datatable_dom_positioning" class="table table-row-bordered gy-5 gs-7 border rounded">
                            <thead>
                                <tr class="fw-bold fs-6 text-gray-800 px-7">
                                    <th class="col-1">No</th>
                                    <th class="col-4 text-start">Name</th>
                                    <th class="col-3 text-start">Total Pengguna</th>
                                    <th class="col-3 text-start">Jumlah Hak Akses</th>
                                    <th class="col-1 text-start">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="table-body" class="text-center">
                                @foreach ($data as $value)
                                    <tr id="{{ $value->id }}">
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-start">{{ $value->name }}</td>
                                        <td class="text-start">{{ $value->assignedUsers->count() }} Pengguna</td>
                                        <td class="text-start">{{ $value->permissions->count() }} Hak Akses</td>
                                        {{-- <td>{{ $value->model_has_role_count }} User</td> --}}
                                        <td class="text-start">
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
                                                        <div>
                                                            <a href="{{ route('admin.manajemen-pengguna.role.show', $value->id) }}"
                                                                class="dropdown-item d-flex align-items-center gap-2">
                                                                {{-- <i class="ki-duotone ki-pencil fs-5"></i> --}}
                                                                Atur Hak Akses
                                                            </a>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <button class="dropdown-item d-flex align-items-center gap-2"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#kt_modal_{{ $value->id }}">
                                                            {{-- <i class="ki-duotone ki-pencil fs-5"></i>  --}}
                                                            Edit Jabatan
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <button
                                                            class="dropdown-item d-flex align-items-center gap-2 text-danger"
                                                            onclick="destroyItem(this)"
                                                            data-route="{{ route('admin.manajemen-pengguna.role.destroy', $value->id) }}">
                                                            {{-- <i class="ki-duotone ki-trash fs-5"></i>  --}}
                                                            Hapus
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

    @include('admin.role.component.modal-tambah')
    @foreach ($data as $value)
        @include('admin.role.component.modal', ['value' => $value])
    @endforeach
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
