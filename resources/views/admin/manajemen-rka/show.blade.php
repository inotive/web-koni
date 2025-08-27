@extends('layouts.app')

@section('pageTitle', 'Rencana Kegiatan Anggaran')
@section('mainSection', 'Menu Utama')
@section('subSection', 'Manajemen RKA')
@section('subSectionUrl', route('admin.manajemen-rka.index'))
@section('currentSection', "{$data->name}")
@section('style')
    <style>
        .edit:hover {
            background-color: rgb(249, 245, 172) !important;
        }

        .delete:hover {
            background-color: #ffcad7ff !important;
        }

        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .btn-loading {
            position: relative;
            pointer-events: none;
        }

        .btn-loading::after {
            content: "";
            position: absolute;
            top: 50%;
            left: 50%;
            width: 1rem;
            height: 1rem;
            border: 2px solid #fff;
            border-top: 2px solid transparent;
            border-radius: 50%;
            animation: spin 0.6s linear infinite;
            transform: translate(-50%, -50%);
        }

        @keyframes spin {
            to {
                transform: translate(-50%, -50%) rotate(360deg);
            }
        }
    </style>
@endsection

@section('content')
    <div class="d-grid gap-5 border-0">
        <div class="d-flex justify-content-between align-items-center container">
            <div class="d-none d-md-block">
                <h1>{{ $data->name }}</h1>
                <span>Laporan Kursus & Pelatihan RKA</span>
            </div>
            <form id="filter" class="d-flex gap-3">
                <button type="button" data-bs-toggle="modal" data-bs-target="#add"
                    class="btn btn-active-light-danger d-flex bg-danger align-items-center btn-facebook fw-bold gap-2 rounded border-0 px-4 py-2 text-white">
                    Tambah Laporan
                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_851_8468)">
                            <path
                                d="M12.3782 17.0625H5.61375C4.37344 17.0582 3.18528 16.5631 2.309 15.6853C1.43272 14.8075 0.939624 13.6185 0.9375 12.3782V5.62182C0.939624 4.38151 1.43272 3.19249 2.309 2.3147C3.18528 1.43692 4.37344 0.941767 5.61375 0.937507H12.3701C12.9853 0.936447 13.5946 1.05656 14.1633 1.29099C14.7321 1.52542 15.2491 1.86958 15.6848 2.30381C16.1205 2.73804 16.4664 3.25384 16.7028 3.82176C16.9392 4.38968 17.0614 4.9986 17.0625 5.61375V12.3701C17.0636 12.986 16.9432 13.596 16.7082 14.1652C16.4733 14.7345 16.1284 15.2518 15.6933 15.6876C15.2583 16.1235 14.7415 16.4692 14.1727 16.7052C13.6038 16.9411 12.994 17.0625 12.3782 17.0625ZM13.0312 8.19375H9.80625V4.96876C9.80625 4.75492 9.7213 4.54985 9.5701 4.39865C9.4189 4.24745 9.21383 4.16251 9 4.16251C8.78617 4.16251 8.58109 4.24745 8.42989 4.39865C8.27869 4.54985 8.19375 4.75492 8.19375 4.96876V8.19375H4.96875C4.75492 8.19375 4.54984 8.2787 4.39864 8.4299C4.24744 8.5811 4.1625 8.78617 4.1625 9C4.1625 9.21383 4.24744 9.41891 4.39864 9.57011C4.54984 9.72131 4.75492 9.80625 4.96875 9.80625H8.19375V13.0313C8.19375 13.2451 8.27869 13.4502 8.42989 13.6014C8.58109 13.7526 8.78617 13.8375 9 13.8375C9.21383 13.8375 9.4189 13.7526 9.5701 13.6014C9.7213 13.4502 9.80625 13.2451 9.80625 13.0313V9.80625H13.0312C13.2451 9.80625 13.4501 9.72131 13.6013 9.57011C13.7526 9.41891 13.8375 9.21383 13.8375 9C13.8375 8.78617 13.7526 8.5811 13.6013 8.4299C13.4501 8.2787 13.2451 8.19375 13.0312 8.19375Z"
                                fill="white" />
                        </g>
                        <defs>
                            <clipPath id="clip0_851_8468">
                                <rect width="18" height="18" fill="white" />
                            </clipPath>
                        </defs>
                    </svg>
                </button>
                <div class="position-relative bg-light" style="width: 180px">
                    <i class="ki-outline ki-magnifier fs-2 position-absolute top-50 translate-middle-y ms-3"></i>
                    <input type="text" name="search" value="{{ request('search') }}" data-kt-docs-table-filter="search"
                        placeholder="Cari Laporan" class="form-control border border-gray-500 py-2 ps-12" />
                </div>
            </form>
        </div>

        <div id="table" class="container">
            @include('admin.manajemen-rka.components.table-laporan', compact('data'))
        </div>

        <div class="modal fade" id="add" tabindex="-1" aria-labelledby="add" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content rounded-4 gap-5 px-10 py-8">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="fs-2 fw-bold leading-5">Tambah Laporan RKA</div>

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form id="formAdd" action="{{ route('admin.laporan-rka.store') }}" method="POST"
                        enctype="multipart/form-data" class="d-grid gap-4">
                        @csrf

                        <input type="hidden" name="rka_id" value="{{ $data->id }}" />
                        <div>
                            <div class="fw-semibold required mb-3 text-gray-800">Total Anggaran</div>
                            <div class="input-group">
                                <span class="input-group-text border border-gray-400 pe-0">Rp.</span>
                                <input type="text" name="total_anggaran" placeholder="Masukkan total anggaran"
                                    class="rupiah border-start-0 form-control bg-light border border-gray-400" />
                            </div>
                        </div>
                        <div>
                            <div class="fw-semibold required mb-3 text-gray-800">Unggah Laporan</div>
                            <div class="fv-row">
                                <!--begin::Dropzone-->
                                <div class="dropzone" id="dropzone-formAdd">
                                    <!--begin::Message-->
                                    <div class="dz-message needsclick">
                                        <i class="ki-duotone ki-file-up fs-3x text-primary">
                                            <span class="path1"></span><span class="path2"></span>
                                        </i>
                                        <!--begin::Info-->
                                        <div class="ms-4">
                                            <h3 class="fs-5 fw-bold mb-1 text-gray-900">Seret atau pilih laporan.</h3>
                                            <span class="fs-7 fw-semibold text-gray-500">Max. Ukuran File 10 MB.</span>
                                        </div>
                                        <!--end::Info-->
                                    </div>
                                </div>
                                <!--end::Dropzone-->
                            </div>
                        </div>

                        <div class="d-grid py-4">
                            <button id="submitBtnAdd" type="submit" onclick="submitForm('formAdd')"
                                class="bg-danger fw-bold d-flex align-items-center justify-content-center gap-2 rounded border-0 p-4 text-white">
                                Tambah Laporan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        const formatRupiah = n => new Intl.NumberFormat('id-ID').format(n);
        const parseRupiah = str => parseInt(str.replace(/\D/g, '')) || 0;

        $('.rupiah').on('input change', function() {
            const raw = $(this).val().replace(/\D/g, '');
            $(this).val(formatRupiah(raw));
        });

        function reloadTable(url = null) {
            let formData = $('#filter').serialize();
            let target = url ?? "{{ route('admin.manajemen-rka.show', $data->id) }}";

            let perPage = $('#per_page').val();
            if (perPage) {
                formData += '&per_page=' + perPage;
            }

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

                    initDropzones();
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

        function confirmDelete(url, name = 'item ini') {
            Swal.fire({
                title: "Apakah Anda Yakin?",
                html: `Hapus <strong>${name}</strong>?`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then(result => {
                if (result.isConfirmed) {
                    fetch(url, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire("Berhasil!", data.message, "success");
                                // Refresh tabel atau hapus baris
                                setTimeout(() => location.reload(), 1500);
                            } else {
                                Swal.fire("Gagal!", data.message, "error");
                            }
                        })
                        .catch(() => {
                            Swal.fire("Error!", "Terjadi kesalahan pada server.", "error");
                        });
                }
            });
        }

        Dropzone.autoDiscover = false;

        let dropzones = {};

        function initDropzones() {
            // Hapus semua Dropzone lama
            for (let key in dropzones) {
                if (dropzones[key]) {
                    dropzones[key].destroy(); // Pastikan destroy instance
                }
            }
            dropzones = {}; // Reset object

            // Dropzone untuk form Add
            if (document.querySelector("#dropzone-formAdd")) {
                dropzones['formAdd'] = new Dropzone("#dropzone-formAdd", {
                    url: "#",
                    autoProcessQueue: false,
                    paramName: 'file',
                    maxFiles: 1,
                    maxFilesize: 10, // MB
                    addRemoveLinks: true,
                    acceptedFiles: '.pdf',
                });
            }

            // Dropzone untuk setiap laporan di tabel
            document.querySelectorAll('[id^="dropzone-form-"]').forEach(el => {
                const formId = el.id.replace('dropzone-', '');
                dropzones[formId] = new Dropzone(`#${el.id}`, {
                    url: "#",
                    autoProcessQueue: false,
                    paramName: 'file',
                    maxFiles: 1,
                    maxFilesize: 10,
                    addRemoveLinks: true,
                    acceptedFiles: '.pdf',
                });
            });
        }

        $(document).ready(function() {
            initDropzones();

            $(document).on('input', '#filter input[name="search"]', debounce(function() {
                let keyword = $(this).val();
                if (keyword.length >= 1 || keyword.length === 0) {
                    reloadTable();
                }
            }, 300));

            $(document).on('change', '#sortBy', function() {
                reloadTable();
            });


            $(document).on('change', '#per_page', function() {
                reloadTable();
            });
        });

        function submitForm(formId) {
            let form = document.getElementById(formId);
            let formData = new FormData(form);

            const dz = dropzones[formId];
            const files = dz.getAcceptedFiles();

            if (files.length > 0) {
                files.forEach((file) => {
                    formData.append('file', file);
                });
            }

            const submitBtn = document.querySelector(
                `#submitBtn${formId === 'formAdd' ? 'Add' : formId.replace('form-', '')}`);
            if (submitBtn) {
                submitBtn.classList.add('btn-loading');
                submitBtn.disabled = true;
            }

            if (formId !== 'formAdd') {
                formData.append('_method', 'PUT'); // untuk edit data
            }

            fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: formData,
                })
                .then(async response => {
                    const data = await response.json();

                    if (!response.ok) {
                        console.log('Error response from controller:', data);

                        if (data.errors) {
                            for (let field in data.errors) {
                                let msg = data.errors[field].join(', ');
                                toastr.error(msg, "Error!");
                            }
                        } else {
                            toastr.error("Gagal menyimpan data", "Error!");
                        }

                        return;
                    } else {
                        $('.modal.show').modal('hide');
                        window.location.reload();

                        reloadTable();
                        form.reset();

                        if (dz) {
                            dz.removeAllFiles(true);
                        }
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                    toastr.error("Terjadi kesalahan. Silakan coba lagi.", "Error!");
                })
                .finally(() => {
                    if (submitBtn) {
                        submitBtn.classList.remove('btn-loading');
                        submitBtn.disabled = false;
                    }
                })
        }
    </script>
@endsection
