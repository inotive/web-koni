@extends('layouts.app')


@push('stack-css')
    <style>
        .desc {
            color: #4B5675;
            font-size: 13px;
        }
    </style>
@endpush
@section('pageTitle', 'Manajemen Pengguna')
@section('mainSection', 'Manajemen Pengguna')
@section('subSection')
    <a href="{{ route('admin.manajemen-pengguna.role.index') }}" class="text-muted muted-hover">Jabatan</a>
@endsection
@section('currentSection', 'Kelola Hak Akses')

@section('breadcrumb-title')
    <h1 class="d-flex flex-column text-dark fw-bold fs-3 mb-0">Halaman Hak Akses</h1>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item text-gray-600">Hak Akses</li>

@endsection
@section('content')
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold fs-3 mb-1">Kelola Hak Akses</span>
                    <span class="text-capitalize fs-6 text-muted">{{ $role->name }}</span>
                </h3>
            </div>
            <div class="card-body">
                <div class="d-flex flex-wrap">
                    @foreach ($permissions as $permission)
                        @php
                            $hasPermission = $role->permissions->contains('id', $permission->id);
                        @endphp
                        <div class="col-4 mb-5"> <!-- Responsive columns -->
                            <div class="p-3"> <!-- Remove fixed width/height -->
                                <h6 class="fw-medium mb-5">{{ $permission->display_name }}</h6>
                                @if ($permission->name === 'beranda')
                                    <p class="mb-3 desc">Menampilkan halaman utama situs yang berisi informasi ringkas
                                        perusahaan.</p>
                                @elseif ($permission->name === 'tentang-kami')
                                    <p class="mb-3 desc">Mengelola halaman yang menjelaskan profil, visi, dan misi
                                        perusahaan.</p>
                                @elseif ($permission->name === 'direksi')
                                    <p class="mb-3 desc">Menampilkan informasi struktur dan anggota Direksi perusahaan.</p>
                                @elseif ($permission->name === 'agenda')
                                    <p class="mb-3 desc">Mengatur jadwal kegiatan perusahaan seperti rapat, seminar, atau
                                        acara publik.</p>
                                @elseif ($permission->name === 'berita')
                                    <p class="mb-3 desc">Mengelola publikasi berita resmi perusahaan.</p>
                                @elseif ($permission->name === 'karir')
                                    <p class="mb-3 desc">Menampilkan dan mengatur informasi lowongan kerja yang tersedia.
                                    </p>
                                @elseif ($permission->name === 'sektor-proyek')
                                    <p class="mb-3 desc">Mengelola data terkait sektor atau jenis proyek yang dikerjakan
                                        perusahaan.</p>
                                @elseif ($permission->name === 'portofolio-proyek')
                                    <p class="mb-3 desc">Menampilkan proyek-proyek yang telah diselesaikan sebagai
                                        portofolio perusahaan.</p>
                                @elseif ($permission->name === 'produk-pangan')
                                    <p class="mb-3 desc">Mengatur informasi dan detail produk pangan yang ditawarkan
                                        perusahaan.</p>
                                @elseif ($permission->name === 'pergudangan')
                                    <p class="mb-3 desc">Mengelola layanan atau fasilitas pergudangan milik perusahaan.</p>
                                @elseif ($permission->name === 'rusunawa')
                                    <p class="mb-3 desc">Mengatur informasi seputar rumah susun sewa (rusunawa) yang
                                        dikelola perusahaan.</p>
                                @elseif ($permission->name === 'client-&-vendor')
                                    <p class="mb-3 desc">Mengelola data klien dan vendor yang bekerja sama dengan
                                        perusahaan.</p>
                                @elseif ($permission->name === 'kontak')
                                    <p class="mb-3 desc">Mengelola pesan yang dikirimkan melalui formulir kontak pengguna.
                                    </p>
                                @elseif ($permission->name === 'pengguna')
                                    <p class="mb-3 desc">Menambah, menghapus, dan mengelola akun pengguna sistem.</p>
                                @elseif ($permission->name === 'jabatan')
                                    <p class="mb-3 desc">Mengatur daftar jabatan atau peran yang digunakan dalam manajemen
                                        pengguna.</p>
                                @endif


                                <div class="form-check form-switch form-check-custom form-check-solid">
                                    <input class="form-check-input statusSwitch" name="permissions[]" type="checkbox"
                                        value="{{ $permission->id }}" {{ $hasPermission ? 'checked' : '' }} />

                                    <label class="form-check-label"
                                        for="statusSwitch">{{ $hasPermission ? 'Active' : 'Inactive' }}</label>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $('.statusSwitch').change(function(e) {
            e.preventDefault();
            const id = "{{ $role->id }}";

            let allPermissions = [];
            $('.statusSwitch:checked').each(function() {
                const rawVal = $(this).val();
                if (rawVal) {
                    const ids = rawVal.split(',').map(Number).filter(Boolean);
                    allPermissions = allPermissions.concat(ids);
                }
            });

            console.log('Semua permissions aktif: ', allPermissions);

            $(this).siblings('label').text(this.checked ? 'Active' : 'Inactive');

            $.ajax({
                type: "POST",
                url: "{{ route('admin.manajemen-pengguna.role.updatePermissions') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    roleId: id,
                    permissions: allPermissions.join(',')
                },
                dataType: "json",
                success: function(response) {
                    toastr.success(response.message);
                },
                error: function(xhr) {
                    toastr.error(xhr.responseJSON.message || "Error updating permissions");
                }
            });
        });
    </script>

@endsection
