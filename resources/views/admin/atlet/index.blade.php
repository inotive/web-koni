@extends('layouts.app')

@section('pageTitle', 'Manajemen Atlet')
@section('mainSection', 'Konfigurasi')
@section('currentSection', 'Atlet')

@section('content')

    {{-- CSS styles tetap sama seperti sebelumnya --}}
    <style>
        body {
            background-color: #f5f5f5;
        }

        .main-content {
            background-color: #f5f5f5;
            min-height: 100vh;
            padding: 20px 0;
        }

        .table-container {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
            border: 1px solid #e9ecef;
            overflow: hidden;
        }

        .table-header {
            background-color: white;
            padding: 20px 25px;
            border-bottom: 1px solid #e9ecef;
        }

        .table-footer {
            background-color: white;
            padding: 15px 25px;
            border-top: 1px solid #e9ecef;
        }

        .empty-state {
            text-align: center;
            color: #6c757d;
            padding: 60px 25px;
            background-color: white;
        }

        .page-header {
            background-color: transparent;
            padding: 0;
            margin-bottom: 20px;
        }

        .page-header h3 {
            color: #2c3e50;
            font-size: 1.8rem;
            font-weight: 700;
        }

        .btn-add-atlet {
            background: linear-gradient(135deg, #F8285A 0%, #e91e63 100%);
            border: none;
            border-radius: 8px;
            padding: 12px 24px;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(248, 40, 90, 0.3);
        }

        .btn-add-atlet:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(248, 40, 90, 0.4);
        }

        .table-responsive {
            overflow-x: auto;
            overflow-y: visible;
            -webkit-overflow-scrolling: touch;
            border-radius: 0;
            border: none;
        }

        .table {
            border-collapse: collapse !important;
            border-spacing: 0 !important;
            margin: 0 !important;
            background-color: white;
            width: 100%;
            min-width: 1200px;
        }

        .table thead th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            border-left: none !important;
            border-right: none !important;
            border-top: none !important;
            font-weight: 600;
            font-size: 0.875rem;
            color: #495057;
            white-space: nowrap;
            padding: 12px 8px !important;
            position: static;
            text-align: center !important;
        }

        .table tbody tr td {
            border-left: none !important;
            border-right: none !important;
            padding: 8px !important;
            font-size: 0.875rem;
            border-bottom: 1px solid #e9ecef;
            white-space: nowrap;
            vertical-align: middle;
            word-wrap: break-word;
            max-width: 200px;
            text-align: left !important;
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        .table td:first-child,
        .table th:first-child {
            padding-left: 12px !important;
        }

        .table td:last-child,
        .table th:last-child {
            padding-right: 12px !important;
        }

        .table th:nth-child(1),
        .table td:nth-child(1) {
            width: 40px;
            text-align: center !important;
        }

        /* Kolom styling yang sudah ada sebelumnya - dikurkan untuk singkat */
        /* ... (semua styling CSS lainnya tetap sama) ... */

        .text-truncate-custom {
            max-width: 120px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .text-bronze {
            color: #CD7F32 !important;
        }

        .object-fit-cover {
            object-fit: cover;
        }

        .table td:nth-child(1),
        .table td:nth-child(2),
        .table td:nth-child(6),
        .table td:nth-child(7),
        .table td:nth-child(12) {
            text-align: center;
        }

        .btn-light-danger[style*="opacity"] {
            cursor: not-allowed;
        }

        #prestasiList {
            padding-left: 1.5rem;
        }

        #prestasiList li {
            margin-bottom: 0.25rem;
            color: #dc3545;
        }

        /* CSS lainnya tetap sama */
    </style>

    @if (session('success'))
        <div class="alert alert-{{ session('action') === 'store' ? 'success' : (session('action') === 'update' ? 'warning' : 'danger') }} alert-dismissible fade show"
            role="alert">
            <i
                class="fas {{ session('action') === 'store' ? 'fa-check-circle' : (session('action') === 'update' ? 'fa-exclamation-circle' : 'fa-trash-alt') }} me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center flex-wrap mb-4" style="padding:10px 30px">
        <h2 class="fw-bold fs-2 mb-0 text-dark">Atlet</h2>
        <a href="{{ route('admin.konfigurasi.atlet.create') }}" class="btn"
            style="background-color: #F8285A !important; color: white !important; border-color: #F8285A !important; border-radius: 8px; padding: 12px 20px; font-weight: 500;">
            <i class="ki-duotone ki-plus fs-4 me-2" style="color: white !important;"></i>Tambah Atlet
        </a>
    </div>

    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="table-header">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h3 class="mb-0 fw-semibold text-dark">Informasi Atlet</h3>

                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                <div class="input-group" style="width: 250px;">
                                    <input type="search" name="search" id="search" class="form-control"
                                        placeholder="Cari atlet...">
                                    <button class="btn btn-outline-secondary" type="button">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>

                                <div class="dropdown">
                                    <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                        data-bs-toggle="dropdown">
                                        <i class="fas fa-filter me-1"></i> Filter
                                        <span id="filter-count" class="badge badge-circle badge-danger ms-1 d-none">0</span>
                                    </button>
                                    <div class="dropdown-menu p-3 shadow" style="min-width: 320px;">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Cabang Olahraga</label>
                                            <select id="filter-cabor" class="form-select">
                                                <option value="">Semua Cabor</option>
                                                @if (isset($allCabor))
                                                    @foreach ($allCabor as $id => $nama)
                                                        <option value="{{ $nama }}">{{ $nama }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Jenis Kelamin</label>
                                            <select id="filter-gender" class="form-select">
                                                <option value="">Semua</option>
                                                <option value="Laki-laki">Laki-laki</option>
                                                <option value="Perempuan">Perempuan</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Rentang Usia</label>
                                            <select id="filter-age" class="form-select">
                                                <option value="">Semua Usia</option>
                                                <option value="15-20">15-20 tahun</option>
                                                <option value="21-25">21-25 tahun</option>
                                                <option value="26-30">26-30 tahun</option>
                                                <option value="31-35">31-35 tahun</option>
                                                <option value="36+">36+ tahun</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Status Prestasi</label>
                                            <select id="filter-prestasi" class="form-select">
                                                <option value="">Semua</option>
                                                <option value="ada">Ada Prestasi</option>
                                                <option value="tidak">Tidak Ada Prestasi</option>
                                                <option value="emas">Medali Emas</option>
                                                <option value="perak">Medali Perak</option>
                                                <option value="perunggu">Medali Perunggu</option>
                                            </select>
                                        </div>

                                        <div class="d-flex gap-2">
                                            <button type="button" id="apply-filters"
                                                class="btn btn-primary btn-sm flex-fill">
                                                <i class="fas fa-check"></i> Terapkan
                                            </button>
                                            <button type="button" id="reset-filters"
                                                class="btn btn-light btn-sm flex-fill">
                                                <i class="fas fa-redo"></i> Reset
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if (!(isset($atlets) && $atlets->isEmpty()))
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div id="filter-info" class="text-muted">
                                    Menampilkan <span id="showing-count">{{ isset($atlets) ? $atlets->count() : 0 }}</span>
                                    dari <span id="total-count">{{ isset($atlets) ? $atlets->total() : 0 }}</span> atlet
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="table-container">
                        @include('admin.atlet._table')
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Peringatan Delete untuk Atlet --}}
    <div class="modal fade" id="atletDeleteWarningModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                        Tidak Dapat Menghapus Atlet
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Atlet <strong id="atletName"></strong> tidak dapat dihapus karena masih memiliki:</p>
                    <ul id="prestasiList"></ul>
                    <p class="text-muted">
                        Silakan hapus semua prestasi yang terkait dengan atlet ini terlebih dahulu,
                        atau nonaktifkan data atlet ini jika diperlukan.
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    @if (isset($atlets) && $atlets->isNotEmpty())
        <script>
            $(document).ready(function() {

                function loadTable(url) {
                    $.ajax({
                        url: url,
                        type: 'GET',
                        beforeSend: function() {
                            $('.table-container').html(
                                '<div class="text-center py-5">' +
                                '<div class="spinner-border text-primary" role="status">' +
                                '<span class="visually-hidden">Loading...</span>' +
                                '</div></div>'
                            );
                        },
                        success: function(response) {
                            $('.table-container').html(response);
                            bindEvents();
                        },
                        error: function(xhr) {
                            console.error(xhr.responseText);
                            Swal.fire({
                                title: 'Error!',
                                text: 'Gagal memuat data',
                                icon: 'error'
                            });
                        }
                    });
                }

                function bindEvents() {
                    $(document).off('click', '.pagination-link')
                        .on('click', '.pagination-link', function(e) {
                            e.preventDefault();
                            const url = $(this).attr('href');
                            if (url) loadTable(url);
                        });

                    $(document).off('change', 'select[name="per_page"]')
                        .on('change', 'select[name="per_page"]', function() {
                            const url = new URL(window.location.href);
                            url.searchParams.set('per_page', $(this).val());
                            loadTable(url.toString());
                        });

                    $(document).off('click', '#apply-filters, #reset-filters')
                        .on('click', '#apply-filters, #reset-filters', function() {
                            const isReset = this.id === 'reset-filters';
                            if (isReset) {
                                $('#filter-cabor, #filter-gender, #filter-age, #filter-prestasi, #search').val('');
                            }

                            const params = new URLSearchParams();
                            const add = (key, val) => {
                                if (val) params.set(key, val);
                                else params.delete(key);
                            };

                            add('search', $('#search').val());
                            add('cabor', $('#filter-cabor').val());
                            add('gender', $('#filter-gender').val());
                            add('age', $('#filter-age').val());
                            add('prestasi', $('#filter-prestasi').val());
                            add('per_page', $('select[name="per_page"]').val());

                            const url = new URL(window.location.href);
                            url.search = params.toString();
                            loadTable(url.toString());
                            $('.dropdown-toggle').dropdown('hide');
                        });

                    let searchTimeout;
                    $(document).off('input', '#search')
                        .on('input', '#search', function() {
                            clearTimeout(searchTimeout);
                            searchTimeout = setTimeout(() => {
                                const url = new URL(window.location.href);
                                url.searchParams.set('search', $(this).val());
                                loadTable(url.toString());
                            }, 300);
                        });

                    $(document).off('click', '.btn-delete')
                        .on('click', '.btn-delete', function(e) {
                            e.preventDefault();
                            const route = $(this).data('route');
                            destroyItem(this);
                        });

                    updateFilterBadge();
                }

                function updateFilterBadge() {
                    const active = [
                        $('#filter-cabor').val(),
                        $('#filter-gender').val(),
                        $('#filter-age').val(),
                        $('#filter-prestasi').val()
                    ].filter(Boolean).length;

                    const badge = $('#filter-count');
                    active ? badge.text(active).removeClass('d-none') :
                        badge.addClass('d-none');
                }

                window.onpopstate = () => loadTable(window.location.href);

                bindEvents();
            });

            // Global function untuk handle delete dengan peringatan prestasi
            window.destroyItem = function(button) {
                const route = $(button).data('route');
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
                        form.innerHTML = `
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="DELETE">
                        `;
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

            // Global function untuk menampilkan peringatan delete atlet dengan prestasi
            window.showAtletDeleteWarning = function(namaAtlet, jumlahPrestasi) {
                document.getElementById('atletName').textContent = namaAtlet;

                const prestasiList = document.getElementById('prestasiList');
                prestasiList.innerHTML = '';

                if (jumlahPrestasi > 0) {
                    prestasiList.innerHTML += `<li>${jumlahPrestasi} prestasi yang tercatat</li>`;
                }

                // Set link untuk melihat prestasi (opsional - bisa disesuaikan dengan route Anda)
                const viewBtn = document.getElementById('viewPrestasiBtn');
                // viewBtn.href = route untuk melihat detail atlet atau prestasi

                // Show modal
                const modal = new bootstrap.Modal(document.getElementById('atletDeleteWarningModal'));
                modal.show();
            };
        </script>
    @endif
@endsection
