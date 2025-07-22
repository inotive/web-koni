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
                                @if ($permission->name === 'dashboard')
                                    <p class="mb-3 desc">Memberikan hak akses untuk Melihat seluruh data agregat di
                                        dashboard sistem secara real-time.</p>
                                @elseif ($permission->name === 'manajemen-rka')
                                    <p class="mb-3 desc">Memiliki wewenang penuh (Create, Read, Update, Delete) atas data
                                        Rencana Kerja dan Anggaran.</p>
                                @elseif ($permission->name === 'laporan-lpj')
                                    <p class="mb-3 desc">Memegang kontrol penuh atas data Laporan Pertanggungjawaban untuk
                                        keperluan teknis dan administratif.</p>
                                @elseif ($permission->name === 'database-bendahara')
                                    <p class="mb-3 desc">Mengelola seluruh data master yang berkaitan dengan keuangan dan
                                        perbendaharaan KONI.</p>
                                @elseif ($permission->name === 'file-kesekretariatan')
                                    <p class="mb-3 desc">Admin dapat mengelola struktur folder, mengatur kuota penyimpanan,
                                        dan melakukan backup data penting.</p>
                                @elseif ($permission->name === 'surat-masuk-keluar')
                                    <p class="mb-3 desc">Dapat mengakses dan mengelola seluruh data surat-menyurat sebagai
                                        bagian dari tugas pemeliharaan.</p>
                                @elseif ($permission->name === 'pelatih')
                                    <p class="mb-3 desc">Menguasai data master pelatih, termasuk menambah, mengubah, dan
                                        menghapus data secara penuh.</p>
                                @elseif ($permission->name === 'atlet')
                                    <p class="mb-3 desc">Memiliki wewenang penuh untuk mengelola data master atlet di
                                        seluruh cabang olahraga.</p>
                                @elseif ($permission->name === 'pengguna')
                                    <p class="mb-3 desc">Menu ini adalah pusat kontrol keamanan sistem, tempat Admin membuat
                                        akun pengguna baru, mengatur ulang kata sandi.</p>
                                @elseif ($permission->name === 'jabatan')
                                    <p class="mb-3 desc">Keamanan dan struktur sistem, memastikan setiap pengguna hanya bisa
                                        mengakses informasi sesuai jabatannya.</p>
                                @elseif ($permission->name === 'tahun-anggaran')
                                    <p class="mb-3 desc">Mengelola daftar Tahun Anggaran yang menjadi acuan untuk semua
                                        modul keuangan (RKA dan LPJ).</p>
                                @elseif ($permission->name === 'cabang-olahraga')
                                    <p class="mb-3 desc">Bertanggung jawab untuk mengelola data master Cabang Olahraga
                                        (Cabor) yang diakui oleh KONI.</p>
                                @elseif ($permission->name === 'kejuaraan')
                                    <p class="mb-3 desc">Memiliki wewenang penuh untuk mengelola data event skala besar atau
                                        memperbaiki data historis kejuaraan.</p>
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
