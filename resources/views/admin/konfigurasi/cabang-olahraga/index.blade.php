@extends('layouts.app')

@push('stack-css')
    {{-- Kalau Ada Plugin Tambahan --}}
@endpush

@section('pageTitle', 'Cabang Olahraga') {{-- Sesuaikan dengan manajemen pengguna --}}
@section('mainSection', 'Konfigurasi')    {{-- Sesuaikan dengan struktur navigasi Anda --}}
@section('currentSection', 'Cabang Olahraga')

@section('content')
    <div class="row col-12 mt-5">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold fs-3 mb-1">Daftar Cabang Olahraga</span>
                </h3>

                {{-- Bagian search dan Tambah Data - disamakan dengan manajemen pengguna --}}
                <div class="card-toolbar d-flex gap-2">
                    <div class="col-5">
                        <input type="search" name="search" id="search" class="form-control" placeholder="Search">
                    </div>
                    <a href="{{ route('admin.konfigurasi.cabang-olahraga.create') }}" class="btn btn-warning">
                        <i class="ki-duotone ki-plus fs-2"></i>
                        Tambah Data
                    </a>
                </div>
            </div>
            <div class="card-body ">
                <div class="row g-12 g-xl-12">
                    <div class="col-xl-12">
                        {{-- Tabel - ubah ID jika perlu, tapi biarkan class untuk styling bawaan --}}
                        <table id="kt_datatable_dom_positioning_cabor" class="table table-row-bordered gy-5 gs-7 border rounded">
                            <thead>
                                <tr class="fw-bold fs-6 text-gray-800 px-7" style="background-color: #FCFCFC">
                                    <th class="col-1 text-center">No</th>
                                    <th class="col-1 text-center">Icon</th> {{-- Untuk Icon --}}
                                    {{-- Kolom yang bisa di-sort, kita akan hapus bagian sorting dari Blade karena DataTables akan mengurusnya --}}
                                    <th class="col-2 text-center">Nama Cabor</th>
                                    <th class="col-2 text-center">Ketua Penanggung Jawab</th>
                                    <th class="col-1 text-center">Status Keaktifan</th>
                                    <th class="col-2 text-center">Tanggal Pembentukan</th>
                                    <th class="col-1 text-center">Jumlah Atlet</th>
                                    <th class="col-1 text-center">Jumlah Pelatih</th>
                                    <th class="col-1 text-center">Terakhir Update</th>
                                    <th class="col-1 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="table-body">
                                @forelse ($cabors as $index => $cabor)
                                    <tr id="{{ $cabor->id }}">
                                        {{-- Perlu diperhatikan: DataTables mengambil alih paginasi, jadi nomor urut `$loop->iteration`
                                           dan `$cabors->currentPage()` ini hanya akan relevan jika Anda memuat data dari server
                                           melalui AJAX dan menggunakan paginasi server-side DataTables.
                                           Untuk DataTables yang bekerja client-side (semua data dimuat di awal),
                                           nomor urut biasanya dihandle langsung oleh DataTables atau Anda bisa
                                           menggunakan index baris DataTables. Namun, untuk sementara, ini tidak akan menimbulkan error.
                                           Jika nomor tidak berurutan setelah DataTables aktif, kita bisa sesuaikan lagi. --}}
                                        <td class="text-center">{{ $loop->iteration + ($cabors->currentPage() - 1) * $cabors->perPage() }}</td>
                                        <td class="text-center">
                                            @if($cabor->icon_cabor)
                                                <img src="{{ asset('storage/' . $cabor->icon_cabor) }}" alt="Icon" class="w-8 h-8 object-contain mx-auto">
                                            @else
                                                <i class="ki-duotone ki-picture fs-2 text-gray-400 mx-auto"></i> {{-- Menggunakan ikon Ki-duotone untuk placeholder --}}
                                            @endif
                                        </td>
                                        <td>{{ $cabor->nama_cabor }}</td>
                                        <td>{{ $cabor->ketua_penanggung_jawab }}</td>
                                        <td class="text-center">
                                            <span class="badge {{ $cabor->status == 'Aktif' ? 'badge-light-success' : 'badge-light-danger' }}"> {{-- Menggunakan kelas badge dari theme Anda --}}
                                                {{ $cabor->status }}
                                            </span>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($cabor->tanggal_pembentukan)->format('d/m/Y') }}</td>
                                        <td class="text-center">{{ $cabor->jumlah_atlet }}</td>
                                        <td class="text-center">{{ $cabor->jumlah_pelatih }}</td>
                                        <td>{{ $cabor->terakhir_update ? \Carbon\Carbon::parse($cabor->terakhir_update)->format('d/m/Y') : '-' }}</td>
                                        <td class="text-center">
                                            <div class="dropdown">
                                                <button class="btn btn-sm" type="button" data-bs-toggle="dropdown"
                                                    aria-expanded="false"
                                                    style="padding: 7px; border: 1px solid #DBDFE9; border-radius: 6px;">
                                                    <svg fill="none" stroke-width="1.5" stroke="currentColor"
                                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                                                        width="24" height="24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M12 6.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 12.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 18.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5Z" />
                                                    </svg>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a href="{{ route('admin.konfigurasi.cabang-olahraga.edit', $cabor->id) }}"
                                                            class="dropdown-item d-flex align-items-center gap-2">
                                                            <i class="ki-duotone ki-pencil fs-5"></i> Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <button class="dropdown-item d-flex align-items-center gap-2 text-danger"
                                                            onclick="destroyItemCabor(this)"
                                                            data-route="{{ route('admin.konfigurasi.cabang-olahraga.destroy', $cabor->id) }}">
                                                            <i class="ki-duotone ki-trash fs-5"></i> Hapus
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center text-gray-500 py-4">Data tidak tersedia</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {{-- Bagian Pagianasi Laravel manual dihapus karena DataTables akan otomatis membuat navigasi paginasi --}}
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                {{-- DataTables akan mengelola paginasi di sini secara otomatis --}}
            </div>
        </div>
    </div>
@endsection

@section('script') {{-- Sesuaikan dengan @section('script') yang digunakan di layout Anda --}}
    <script>
        $(document).ready(function() {
            // Inisialisasi DataTables untuk tabel Cabang Olahraga
            const tableCabor = $("#kt_datatable_dom_positioning_cabor").DataTable({
                "language": {
                    "lengthMenu": "Show _MENU_", // Placeholder untuk dropdown jumlah entri
                    "emptyTable": "Data tidak tersedia",
                    "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                    "infoEmpty": "Menampilkan 0 sampai 0 dari 0 entri",
                    "infoFiltered": "(difilter dari _MAX_ total entri)",
                    "search": "Cari:",
                    "paginate": {
                        "first": "Pertama",
                        "last": "Terakhir",
                        "next": "Berikutnya",
                        "previous": "Sebelumnya"
                    }
                },
                "lengthMenu": [
                    [10, 25, 50, 100, -1], // Opsi nilai (numbers of entries)
                    [10, 25, 50, 100, "Semua"] // Label yang akan ditampilkan di dropdown
                ],
                "dom":
                    "<'row'" +
                    "<'col-sm-12 col-md-6 d-flex align-items-center justify-content-start'l>" + // 'l' adalah untuk length changing dropdown (dropdown pagination)
                    "<'col-sm-12 col-md-6 d-flex align-items-center justify-content-end'f>" + // 'f' adalah untuk fitur pencarian
                    ">" +
                    "<'table-responsive'tr>" + // 't' untuk tabel, 'r' untuk processing display
                    "<'row'" +
                    "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" + // 'i' untuk info (jumlah entri)
                    "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" + // 'p' untuk paginasi
                    ">"
            });

            // Hubungkan input search custom ke DataTables
            $('#search').on('keyup', function () {
                tableCabor.search(this.value).draw();
            });

            // Fungsi global untuk menghapus data Cabang Olahraga
            window.destroyItemCabor = function(e) {
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
        });
    </script>
@endsection