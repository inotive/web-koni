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
                                    {{-- <th>Jumlah Hak Akses</th> --}}
                                    {{-- <th>Jumlah User</th> --}}
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $value)
                                    <tr id="{{ $value->id }}">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $value->name }}</td>
                                        {{-- <td>{{ $value->permissions_count }} Hak Akses</td> --}}
                                        {{-- <td>{{ $value->model_has_role_count }} User</td> --}}
                                        <td>
                                           
                                                {{-- <a href="{{ route('admin.role.setting', $value->id) }}"
                                                    class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1"">
                                                    <i class="ki-solid ki-gear fs-2x"></i>
                                                </a> --}}
                                        
                                                <a href="#"
                                                    class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1"
                                                    data-bs-toggle="modal" data-bs-target="#kt_modal_{{ $value->id }}">
                                                    <i
                                                        class="ki-duotone
                                                ki-pencil fs-2">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                </a>
                                                @include('admin.role.component.modal', [
                                                    'value' => $value,
                                                ])
                                          
                                                <button data-route="{{ route('admin.hak-akses.role.destroy', $value->id) }}"
                                                    class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm"
                                                    onclick="destroyItem(this)">
                                                    <i class="ki-duotone ki-trash fs-2">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                        <span class="path4"></span>
                                                        <span class="path5"></span>
                                                    </i>
                                                </button>
                                           
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
        const destroyItem = (e) => {
            let target = $(e);

            callSwal(target.data('route'))
        }

        const callSwal = (route) => {
            Swal.fire({
                    title: "Apakah Anda Yakin?",
                    html: "<p style='center'>Setelah Data Dihapus maka Anda Tidak Akan Bisa Mengembalikan Data Kembali!</p>",
                    icon: "warning",
                    showCancelButton: true,
                    reverseButtons: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Hapus!',
                    cancelButtonText: 'Batalkan!'
                })
                .then((willDelete) => {
                    if (willDelete.isConfirmed) {
                        (new FormElementHelper)
                        .createAttribute('hidden', '_token', '{{ csrf_token() }}')
                            .createAttribute('hidden', '_method', 'DELETE')
                            .post(route);
                    } else {
                        Swal.fire({
                            title: "Aksi Dibatalkan :)",
                            icon: "info",
                        })
                    }
                })
        }
   </script>
   <script>
    @if (Session::has('pesan')) 
        toastr.{{ Session::get('alert') }}("{{ Session::get('pesan') }}")
    @endif
   </script>
@endpush
