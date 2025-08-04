@extends('layouts.app')

{{-- @section('pageTitle', 'Rencana Kegiatan Anggaran') --}}
@section('mainSection', 'Manajemen RKA')
@section('currentSection', 'Daftar RKA')

@section('content')
    <div class="d-grid gap-5 border-0">
        <div class="d-flex justify-content-between align-items-center container">
            <div>
                <h1>Manajemen RKA</h1>
                <span>Pemusatan Rencana Kegiatan Anggaran</span>
            </div>
            <form id="filter" class="d-flex gap-3">
                <div class="position-relative bg-light" style="width: 180px">
                    <i class="ki-outline ki-magnifier fs-2 position-absolute top-50 translate-middle-y ms-3"></i>
                    <input type="text" name="search" value="{{ request('search') }}" data-kt-docs-table-filter="search"
                        placeholder="Cari Lembaga" class="form-control border border-gray-500 py-2 ps-12" />
                </div>
                <select name="sortBy" id="sortBy" class="form-select border border-gray-500 py-2" style="width: 85px">
                    <option value="ASC">A - Z</option>
                    <option value="DESC">Z - A</option>
                </select>
            </form>
        </div>

        <div id="table" class="container">
            @include('admin.manajemen-rka.components.table-grid', compact('data'))
        </div>

        <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="modal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content rounded-4 gap-5 px-10 py-8">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="fs-2 fw-bold leading-5">Tambah Folder RKA</div>

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form id="form" action="{{ route('admin.manajemen-rka.store') }}" method="POST" class="d-grid gap-2">
                        <div class="fs-4 fw-bold">Judul RKA</div>
                        <textarea id="judul" name="judul" class="form-control border border-gray-600" placeholder="Masukkan judul RKA"></textarea>
                    </form>

                    <div class="d-grid py-4">
                        <button type="button" onclick="submitForm()"
                            class="bg-success d-flex align-items-center justify-content-center gap-2 rounded border-0 p-4 text-white">
                            Tambah Folder
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        // const table = $("#kt_datatable_dom_positioning").DataTable();
        // $('#search').on('keyup', function() {
        //     table.search(this.value).draw();
        // });

        // // Fungsi global untuk menghapus data
        // window.destroyItem = function(e) {
        //     const route = e.dataset.route;

        //     Swal.fire({
        //         title: "Apakah Anda Yakin?",
        //         html: "<p style='text-align:center'>Setelah data dihapus, Anda tidak bisa mengembalikannya!</p>",
        //         icon: "warning",
        //         showCancelButton: true,
        //         reverseButtons: true,
        //         confirmButtonColor: '#d33',
        //         cancelButtonColor: '#3085d6',
        //         confirmButtonText: 'Hapus!',
        //         cancelButtonText: 'Batalkan!'
        //     }).then((result) => {
        //         if (result.isConfirmed) {
        //             const form = document.createElement('form');
        //             form.method = 'POST';
        //             form.action = route;

        //             const token = document.createElement('input');
        //             token.type = 'hidden';
        //             token.name = '_token';
        //             token.value = '{{ csrf_token() }}';

        //             const method = document.createElement('input');
        //             method.type = 'hidden';
        //             method.name = '_method';
        //             method.value = 'DELETE';

        //             form.appendChild(token);
        //             form.appendChild(method);
        //             document.body.appendChild(form);
        //             form.submit();
        //         } else {
        //             Swal.fire({
        //                 title: "Aksi Dibatalkan :)",
        //                 icon: "info",
        //             });
        //         }
        //     });
        // };
        function submitForm() {
            let form = document.getElementById('form');
            let formData = new FormData(form);

            fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: formData,
                })
                .then(async response => {
                    const data = await response.json();

                    if (!response.ok) {

                        $('.modal.show').modal('hide');
                        console.log('Error response from controller:', data);

                        if (data.errors) {
                            for (let field in data.errors) {
                                let msg = data.errors[field].join(', ');
                                toastr.error(msg, "Error!");
                            }
                        } else {
                            toastr.error("Gagal menyimpan data", "Error!");
                        }
                    } else {
                        $('.modal.show').modal('hide');
                        reloadTable();
                    }
                })
                .catch(error => {
                    $('.modal.show').modal('hide');
                    console.error('Fetch error:', error);
                    toastr.error("Terjadi kesalahan. Silakan coba lagi.", "Error!");
                });
        }

        function reloadTable(url = null) {
            let formData = $('#filter').serialize();
            let target = url ?? "{{ route('admin.manajemen-rka.index') }}";

            $.ajax({
                url: target,
                data: formData,
                beforeSend: function() {
                    $('#table').html(
                        '<div class="py-20 text-center"><span class="spinner-border text-danger"></span></div>'
                    );
                },
                success: function(response) {
                    $('#table').html(response);
                },
                error: function(xhr) {
                    $('#table').html(
                        '<div class="py-20 text-center text-danger fw-bold">Terjadi kesalahan saat memuat data.</div>'
                    );
                }
            });
        }

        function debounce(func, delay) {
            let timeout;
            return function() {
                const context = this,
                    args = arguments;
                clearTimeout(timeout);
                timeout = setTimeout(() => func.apply(context, args), delay);
            };
        }

        $(document).ready(function() {
            $(document).on('input', '#filter input[name="search"]', debounce(function() {
                let keyword = $(this).val();
                if (keyword.length >= 1 || keyword.length === 0) {
                    reloadTable();
                }
            }, 300));

            $(document).on('change', '#sortBy', function() {
                reloadTable();
            });
        });
    </script>
@endsection
