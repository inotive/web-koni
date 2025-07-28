@extends('layouts.app')

{{-- @section('pageTitle', 'Rencana Kegiatan Anggaran') --}}
@section('mainSection', 'Manajemen RKA')
@section('currentSection', 'Daftar RKA')


@section('content')
    <div class="gap-4 border-0">
        <div class="d-flex justify-content-between align-items-center container">
            <h1>
                Rencana Kegiatan Anggaran
            </h1>
            <div>
                <input type="search" name="search" id="search" class="form-control bg-light py-2" placeholder="Search">
            </div>
        </div>
        <div class="row g-12 g-xl-12">
            <div class="container my-4">
                <div class="row g-10">
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="h-100 card justify-content-center gap-2 p-3 text-center shadow-sm">
                            <div>
                                <i class="ki-outline ki-add-folder" style="font-size: 80px"></i>
                            </div>
                            <h5>Tambah Folder</h5>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="card gap-2 p-3 text-center shadow-sm">
                            <div class="text-end">
                                <div class="dropdown">
                                    <button class="btn btn-sm p-0" type="button" data-bs-toggle="dropdown">
                                        <i class="ki-solid ki-dots-vertical text-danger fw-bold"
                                            style="font-size: 30px"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li></li>
                                    </ul>
                                </div>
                            </div>
                            <div>
                                <i class="ki-outline ki-folder" style="font-size: 80px"></i>
                            </div>
                            <div>
                                <h5>Folder 1</h5>
                                <p>3 Dokumen</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
