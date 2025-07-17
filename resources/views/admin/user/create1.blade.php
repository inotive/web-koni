@extends('layouts.app')


@push('stack-css')

@endpush
@section('pageTitle', 'Media Informasi')
@section('mainSection', 'Karir')
{{-- @section('currentSection', 'Daftar Berita') --}}

@section('breadcrumb-title')
    <h1 class="d-flex flex-column text-dark fw-bold fs-3 mb-0">Halaman Pengguna</h1>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item text-gray-600">Pengguna</li>

@endsection

@section('content')
    <div class="row col-12 mt-5 mx-3">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold fs-3 mb-1">Tambah Pengguna</span>
                </h3>
            </div>
            <div class="card-body">
                <div class="">
                    <form method="POST" action="{{ route('admin.media.career.store') }}">
                        @csrf
                        <div class="mb-5">
                            <div class="col-12 mb-4">
                                <div class="d-flex justify-content-between">
                                    <div class="col-4">
                                        <label for="title" class="form-label">Nama Pengguna :</label>
                                        <input type="text" class="form-control" id="username" name="username"
                                        value="{{ old('username') }}" required placeholder="Contoh : Superadmin"/>
                                    </div>
                                    <div class="col-4">
                                        <label for="role" class="form-label">Jabatan :</label>
                                        <select class="form-select" name="role" aria-label="Select example">
                                            <option value="" ></option>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->name }}" class=" text-capitalize">{{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-4">
                                        <label for="email" class="form-label">Email :</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                        value="{{ old('email') }}" required placeholder="Contoh: superadmin@gmail.com"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-4">
                                <label for="" class="form-label">Unggah Foto Pengguna</label>
                                <input type="hidden" name="image" id="image">
                                <!--begin::Dropzone-->
                                <div class="dropzone" id="kt_dropzonejs_store">
                                    <!--begin::Message-->
                                    <div class="dz-message needsclick">
                                        <i class="ki-duotone ki-file-up fs-3x text-primary"><span class="path1"></span><span class="path2"></span></i>

                                        <!--begin::Info-->
                                        <div class="ms-4">
                                            <h3 class="fs-6 fw-bold text-gray-900 mb-1">Seret dan lepas file di sini, atau klik untuk mengunggah.</h3>
                                            <span class="fs-7 fw-semibold text-gray-500">Maximal 5MB & 1 Foto</span>
                                        </div>
                                        <!--end::Info-->
                                    </div>
                                </div>
                                <!--end::Dropzone-->
                            </div>
                        </div>
                        <div class="modal-footer">
                            {{-- <button type="button" class="btn btn-light" data-bs-dismiss="modal">Kembali</button> --}}
                            <div class="col-12 ">
                                <div class=" col-6 d-flex justify-content-start gap-5">
                                    <button type="submit" class="btn w-100 d-flex align-items-center justify-content-center" style="background-color: #FF6A33; color: white; border-radius: 8px; padding: 12px 0;">
                                        <!-- icon disini -->
                                        Simpan Portofolio
                                    </button>
                                    <button type="submit" name="action" value="save_&_create" class="btn w-100 d-flex align-items-center justify-content-center" style="background-color: #FFE8D4; color: #FF6224; border-radius: 8px; padding: 12px 0;">
                                        <!-- icon disini -->
                                        Simpan Portofolio & Buat Lagi
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')

    <script>
        let myDropzone = new Dropzone("#kt_dropzonejs_store", {
            url: "/admin/manajemen-pengguna/pengguna/image",
            paramName: "image",
            maxFiles: 1,
            maxFilesize: 5, // MB
            uploadMultiple: false,
            addRemoveLinks: true,
            acceptedFiles: "image/*", // hanya gambar
            thumbnailWidth: 120,
            thumbnailHeight: 120,
            dictDefaultMessage: "Klik atau seret logo ke sini",
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            init: function () {
                this.on("removedfile", function (file) {
                    $('#image').val('');
                });
                this.on("error", function(file, response) {
                    console.log('Error:', response.message);
                });
            },
            accept: function(file, done) {
                done();               
            },     
            success: function(file, response) {
                $('#image').val(response.path);
                console.log($('#image').val());
            }      
        });
    </script>

    <script>
        $("#end_date").flatpickr();

        document.querySelectorAll('.kt_ckeditor_classic').forEach((element) => {
            ClassicEditor
                .create(element)
                .then(editor => {
                    console.log('Editor initialized', editor);
                })
                .catch(error => {
                    console.error(error);
                });
        });
    </script>
@endsection
