@extends('layouts.app')


@push('stack-css')
    <!-- Kalau Ada Plugin Tambahan -->
@endpush

@section('pageTitle', 'Pengguna')
@section('mainSection', 'Manajemen Pengguna')
@section('subSection')
    <a href="{{ route('admin.manajemen-pengguna.pengguna.index') }}" class="text-muted muted-hover">Pengguna</a>
@endsection
@section('currentSection', 'Edit Pengguna')

@section('content')
    <div class="row col-12">
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold fs-3 mb-1">Form Edit Data Pengguna</span>
                    </h3>
                </div>
                <form method="POST" action="{{ route('admin.manajemen-pengguna.pengguna.update', $pengguna->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="input-group mb-5">
                        <div class="col-xl-12 mb-2 text-center">
                            <!--begin::Image input-->
                            <div class="image-input image-input-circle" data-kt-image-input="true">
                                <!--begin::Image preview wrapper-->
                                <div class="image-input-wrapper w-125px h-125px"
                                    style="background-image: url({{ $pengguna->image ? Storage::url('profile/' . $pengguna->image) : asset('assets/media/svg/avatars/blank.svg') }})"">
                                </div>
                                <!--end::Image preview wrapper-->

                                <!--begin::Edit button-->
                                <label
                                    class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="change" data-bs-toggle="tooltip" data-bs-dismiss="click"
                                    title="Change avatar">
                                    <i class="ki-duotone ki-pencil fs-6"><span class="path1"></span><span
                                            class="path2"></span></i>

                                    <!--begin::Inputs-->
                                    <input type="file" name="image" value=""/>
                                    <!--end::Inputs-->
                                </label>
                                <!--end::Edit button-->

                                <!--begin::Cancel button-->
                                <span
                                    class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="cancel" data-bs-toggle="tooltip" data-bs-dismiss="click"
                                    title="Cancel avatar">
                                    <i class="ki-outline ki-cross fs-3"></i>
                                </span>
                                <!--end::Cancel button-->

                                <!--begin::Remove button-->
                                <span
                                    class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="remove" data-bs-toggle="tooltip" data-bs-dismiss="click"
                                    title="Remove avatar">
                                    <i class="ki-outline ki-cross fs-3"></i>
                                </span>
                                <!--end::Remove button-->
                            </div>

                            <!--end::Image input-->
                        </div>

                    </div>
                    <div class="card-body">
                        <div class="input-group mb-5">
                            <div class="col-xl-12 mb-2">
                                <label for="">Username</label>
                            </div>
                            <div class="col-xl-12">
                                <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username"
                                    value="{{ old('username', $pengguna->username) }}" placeholder="Masukkan Username" required
                                    aria-label="Username" aria-describedby="basic-addon1" />
                                    @error('username')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                            </div>
                        </div>
                        <div class="input-group mb-5">
                            <div class="col-xl-12 mb-2">
                                <label for="">Email</label>
                            </div>
                            <div class="col-xl-12">
                                <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                                    value="{{ old('email', $pengguna->email) }}" placeholder="Masukkan Email" required
                                    aria-label="Username" aria-describedby="basic-addon1" />
                                    @error('email')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                            </div>
                        </div>
                        {{-- <div class="input-group mb-5">
                            <div class="col-xl-12 mb-2">
                                <label for="">Nama Lengkap</label>
                            </div>
                            <div class="col-xl-12">
                                <input type="text" class="form-control" name="name" id="inputNama"
                                    value="{{ old('name', $pengguna->name) }}" required placeholder="Masukkan Nama Lengkap"
                                    aria-label="Username" aria-describedby="basic-addon1" />
                            </div>
                        </div> --}}
                        <div class="input-group mb-5">
                            <div class="col-xl-12 mb-2">
                                <label for="">Password</label>
                            </div>
                            <div class="col-xl-12">
                                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Masukkan Password"
                                    aria-label="Username" aria-describedby="basic-addon1" />
                                    @error('password')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                            </div>
                        </div>
                        <div class="input-group mb-5">
                            <div class="col-xl-12 mb-2">
                                <label for="">Role</label>
                            </div>
                            <div class="col-xl-12">
                                <select class="form-select" name="role" required data-control="select2" data-placeholder="Select an option">
                                    @foreach ($role as $item)
                                        <option value="{{ $item->name }}"
                                            {{ old('role', $pengguna->getRoleNames()->first()) == $item->name ? 'selected' : '' }}>{{ $item->name }}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <div class="col-12">
                                <div class=" col-12 d-flex justify-content-start gap-5">
                                    <button type="submit" class="btn w-100 h-50 d-flex align-items-center justify-content-center" style="background-color: #F8285A; color: white; border-radius: 8px; padding: 12px 0;">
                                        <!-- icon disini -->
                                        Simpan Pengguna
                                    </button>
                                </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold fs-3 mb-1">Daftar Pengguna Pada Sistem</span>
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row g-12 g-xl-12">
                        <div class="col-xl-12">
                            <div class="table-responsive">
                                <table id="kt_datatable_dom_positioning"
                                    class="table table-striped table-row-bordered gy-5 gs-7 border rounded">
                                    <thead>
                                        <tr class="fw-bold fs-6 text-gray-800 px-7">
                                            <th>No</th>
                                            <th>Username</th>
                                            <th>Role</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $value)
                                            <tr id="{{ $value->id }}">
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td>{{ $value->username }}</td>
                                                {{-- <td>{{ $value->name }}</td> --}}
                                                @foreach ($value->getRoleNames() as $roleName)
                                                    <td>{{ $roleName }}</td>
                                                @endforeach
                                                {{-- <td>{{ $value->status_format }}</td> --}}
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
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

    const inputNama = $("#inputNama");

    inputNama.on("input", function(event) {
        const inputValue = inputNama.val();
        const nonNumericValue = inputValue.replace(/[!@#$%^&*="()_+{}\[\]:;<>,.?~\\|0-9/'-]/g, '');
        if (inputValue !== nonNumericValue) {
            inputNama.val(nonNumericValue);
        }
    });

    // const username = $("#username");
    // username.on("input", function(event) {
    //     const inputValue = username.val();
    //     const nonNumericValue = inputValue.replace(/[!@#$%^&*="()_+{}\[\]:;<>,.?~\\|0-9/'-]/g, '');
    //     if (inputValue !== nonNumericValue) {
    //         username.val(nonNumericValue);
    //     }
    // });

    // $('#username').on('keydown', function(e) {
    //     if (e.keyCode === 32) {
    //         e.preventDefault();
    //     }
    // });
</script>
@endpush
