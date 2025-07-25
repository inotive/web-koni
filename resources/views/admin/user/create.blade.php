@extends('layouts.app')


@push('stack-css')
    <!-- Kalau Ada Plugin Tambahan -->
@endpush

@section('pageTitle', 'Pengguna')
@section('mainSection', 'Manajemen Pengguna')
@section('subSection')
    <a href="{{ route('admin.manajemen-pengguna.pengguna.index') }}" class="text-muted muted-hover">Pengguna</a>
@endsection
@section('currentSection', 'Tambah Pengguna')

@section('content')
    <div class="row col-12">
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold fs-3 mb-1">Form Tambah Data Pengguna</span>
                    </h3>
                </div>
                <form method="POST" action="{{ route('admin.manajemen-pengguna.pengguna.store') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="input-group mb-5">
                            <div class="col-xl-12 mb-2">
                                <label for="">Username</label>
                            </div>
                            <div class="col-xl-12">
                                <input type="text" class="form-control @error('username') is-invalid @enderror"
                                    id="username" name="username" value="{{ old('username') }}"
                                    placeholder="Masukkan Username" required aria-label="Username"
                                    aria-describedby="basic-addon1" />
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
                                <input type="text" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email') }}" placeholder="Masukkan Email"
                                    required aria-label="Email" aria-describedby="basic-addon1" />
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
                                    value="{{ old('name') }}" required placeholder="Masukkan Nama Lengkap"
                                    aria-label="Username" aria-describedby="basic-addon1" />
                            </div>
                        </div> --}}
                        <div class="input-group mb-5">
                            <div class="col-xl-12 mb-2">
                                <label for="">Password</label>
                            </div>
                            <div class="col-xl-12">
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    name="password" placeholder="Masukkan Password" required aria-label="Username"
                                    aria-describedby="basic-addon1" />
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
                                <select class="form-select" name="role" required data-control="select2"
                                    data-placeholder="Select an option">
                                    @foreach ($roles as $item)
                                        <option value="{{ $item->name }}"
                                            {{ old('role') == $item->name ? 'selected' : '' }}>{{ $item->name }}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <div class="col-12">
                            <div class=" col-12 d-flex justify-content-start gap-5">
                                <button type="submit"
                                    class="btn w-100 h-50 d-flex align-items-center justify-content-center"
                                    style="background-color: #F8285A; color: white; border-radius: 8px; padding: 12px 0;">
                                    <!-- icon disini -->
                                    Simpan Pengguna
                                </button>
                                <button type="submit" name="action" value="save_&_create"
                                    class="btn w-100 h-50 d-flex align-items-center justify-content-center"
                                    style="background-color: #ffe6ec; color: #F8285A; border-radius: 8px; padding: 12px 0;">
                                    <!-- icon disini -->
                                    Simpan & Buat Lagi
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@push('stack-script')
    <script>
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
