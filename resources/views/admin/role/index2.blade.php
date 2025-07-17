@extends('layouts.app')


@push('stack-css')
    <!-- Kalau Ada Plugin Tambahan -->
@endpush


@section('breadcrumb-title')
    <h1 class="d-flex flex-column text-dark fw-bold fs-3 mb-0">Halaman {{$title}}</h1>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item text-gray-600">{{$title}}</li>

@endsection

@section('content')
    <div class="row col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold fs-3 mb-1">Daftar Role</span>
                </h3>
                <div class="card-toolbar">
                        <a href="#" class="btn btn-sm btn-light-primary" data-bs-toggle="modal"
                            data-bs-target="#kt_modal_tambah">
                            <i class="ki-duotone ki-plus fs-2"></i>Tambah Data</a>
                   
                </div>
            </div>
            <div class="card-body">
                <div class="row g-12 g-xl-12">
                    <div class="col-xl-12">
                        <table id="kt_datatable_dom_positioning"
                            class="table table-striped table-row-bordered gy-5 gs-7 border rounded">
                            <thead>
                                <tr class="fw-bold fs-6 text-gray-800 px-7">
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Jumlah Hak Akses</th>
                                    {{-- <th>Jumlah User</th> --}}
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $value)
                                    <tr id="{{ $value->id }}">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $value->name }}</td>
                                        <td>{{ $value->permissions->count() }} Hak Akses</td>
                                        {{-- <td>{{ $value->model_has_role_count }} User</td> --}}
                                        <td>
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
                                                            <button class="dropdown-item d-flex align-items-center gap-2" 
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#kt_modal_{{ $value->id }}">
                                                                {{-- <i class="ki-duotone ki-pencil fs-5"></i>  --}}
                                                                Edit
                                                            </button>
                                                        </li>
                                                        <li>
                                                            <div>
                                                                <a href="#" class="dropdown-item d-flex align-items-center gap-2">
                                                                    {{-- <i class="ki-duotone ki-pencil fs-5"></i> --}}
                                                                    Atur Hak Akses
                                                                </a>
                                                            </div>
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


@push('stack-script')
   <script>
     $("#kt_datatable_dom_positioning").DataTable({
            "language": {
                "lengthMenu": "Show _MENU_",
            },
            "dom": "<'row'" +
                "<'col-sm-6 d-flex align-items-center justify-conten-start'l>" +
                "<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
                ">" +

                "<'table-responsive'tr>" +

                "<'row'" +
                "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
                "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
                ">"
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
   <script>
    @if (Session::has('pesan')) 
        toastr.{{ Session::get('alert') }}("{{ Session::get('pesan') }}")
    @endif
   </script>
@endpush
