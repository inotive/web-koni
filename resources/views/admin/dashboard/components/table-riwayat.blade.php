<div class="table-reponsive table-bordered py-4 d-flex flex-column gap-4" style="overflow-x: auto;">
    <!--begin::Table-->
    <table class="gs-0 gy-4 m-0 table border border-gray-300 p-0 text-center align-middle">
        <!--begin::Table head-->
        <thead>
            <tr class="fw-bold text-muted p-0">
                <th class="min-w-150px bg-light border border-gray-300 px-2 text-center">Tanggal Transaksi</th>
                <th class="min-w-150px bg-light border border-gray-300 px-2 text-center">Nama Nasabah</th>
                <th class="min-w-100px bg-light border border-gray-300 px-2 text-center">Nama Barang</th>
                <th class="min-w-150px bg-light border border-gray-300 px-2 text-center">Status</th>
                <th class="min-w-150px bg-light border border-gray-300 px-2 text-center">Jumlah Pinjaman</th>
            </tr>
        </thead>
        <!--end::Table head-->
        <!--begin::Table body-->
        @php
            $test = [];
        @endphp
        <tbody>
            @forelse ($test as $index => $item)
                {{-- <tr>
                    <td class="border border-gray-300 px-5 text-center">
                        <button type="button" class="btn btn-icon btn-sm btn-delete"
                            onclick="showDeleteModal('nota-gadai', {{ $item->id }})">
                            <i class="ki-duotone ki-cross-circle fs-1 text-hover-info text-danger">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </button>

                        <a href="{{ route('nota-gadai.edit', $item->id) }}" class="btn btn-icon btn-sm">
                            <i class="ki-outline ki-pencil text-warning text-hover-info fs-2"></i>
                        </a>

                        <a href="{{ route('nota-gadai.show', $item->id) }}" class="btn btn-icon btn-sm">
                            <i class="ki-outline ki-eye text-primary text-hover-info fs-2"></i>
                        </a>
                    </td>
                    <td class="border border-gray-300 px-2 text-center text-gray-800">
                        @if ($item->nota_gadai_has_penebusan)
                            <div class="badge bg-success rounded-pill text-success gap-2 border-0 bg-opacity-25 p-2">
                                <svg class="text-success" width="6" height="6" viewBox="0 0 6 6" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect width="6" height="6" rx="3" fill="currentColor" />
                                </svg>
                                Sudah ditebus
                            </div>
                        @elseif ($item->jatuh_tempo->isFuture())
                            <div class="badge bg-primary rounded-pill text-primary gap-2 border-0 bg-opacity-25 p-2">
                                <svg class="text-primary" width="6" height="6" viewBox="0 0 6 6" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect width="6" height="6" rx="3" fill="currentColor" />
                                </svg>
                                ({{ ceil(now()->diffInDays($item->jatuh_tempo, false)) }} hari)
                                Belum jatuh tempo
                            </div>
                        @elseif ($item->jatuh_tempo->isPast() && $item->masa_tenggang->isFuture())
                            <div class="badge bg-warning rounded-pill text-orange gap-2 border-0 bg-opacity-25 p-2">
                                <svg class="text-orange" width="6" height="6" viewBox="0 0 6 6" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect width="6" height="6" rx="3" fill="currentColor" />
                                </svg>
                                ({{ ceil(now()->diffInDays($item->jatuh_tempo, false)) }} hari)
                                Belum ditebus
                            </div>
                        @elseif ($item->masa_tenggang->isPast() && $item->masa_lelang->isFuture())
                            <div
                                class="badge bg-danger rounded-pill text-danger gap-2 border-0 bg-opacity-25 px-3 py-2">
                                <svg class="text-danger" width="6" height="6" viewBox="0 0 6 6" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect width="6" height="6" rx="3" fill="currentColor" />
                                </svg>({{ ceil(now()->diffInDays($item->jatuh_tempo, false)) }}
                                hari)
                                Masa Tenggang
                            </div>
                        @elseif ($item->masa_lelang->isPast())
                            <div class="badge rounded-pill gap-2 border-0 bg-gray-500 bg-opacity-25 p-2 text-gray-500">
                                <svg class="text-gray-500" width="6" height="6" viewBox="0 0 6 6"
                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="6" height="6" rx="3" fill="currentColor" />
                                </svg>
                                Masa Lelang
                            </div>
                        @endif
                    </td>
                    <td class="border border-gray-300 text-center text-gray-800">
                        {{ $item->no_gadai }}
                    </td>
                    <td class="border border-gray-300 text-center text-gray-800">
                        {{ $item->nasabah }}
                    </td>
                    <td class="border border-gray-300 text-center text-gray-800">
                        {{ $item->barang }}
                    </td>
                    <td class="border border-gray-300 text-center text-gray-800">
                        {{ $item->tipe_gadai }}
                    </td>
                    <td class="border border-gray-300 text-center text-gray-800">
                        {{ $item->tanggal_masuk->locale('id')->translatedFormat('d M Y') }}
                    </td>
                    <td class="border border-gray-300 text-center text-gray-800">
                        {{ $item->jatuh_tempo->locale('id')->translatedFormat('d M Y') }}
                    </td>
                    <td class="border border-gray-300 text-center text-gray-800">
                        Rp.{{ number_format($item->nominal_pinjaman, 0, ',', '.') }},-
                    </td>
                </tr> --}}
            @empty
                <tr>
                    <td class="fw-bold py-8 text-gray-600" colspan="9">Tidak ada transaksi ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
        <!--end::Table body-->
    </table>
    <!--end::Table-->
    <div class="px-10">
        <div class="d-flex justify-content-between col-12">
            <div class="d-flex align-items-center gap-2 text-gray-500">
                Show
                <select id="per_page_gadai" name="per_page" class="form-select w-75 border border-gray-300 p-2">
                    <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                    <option value="25" {{ request('per_page', 10) == 25 ? 'selected' : '' }}>25</option>
                    <option value="50" {{ request('per_page', 10) == 50 ? 'selected' : '' }}>50</option>
                    <option value="100" {{ request('per_page', 10) == 100 ? 'selected' : '' }}>100</option>
                </select>
                per page
            </div>

            <!-- Paginate -->
            {{-- {{ $test->links('pagination::bootstrap-5') }} --}}
        </div>
    </div>
</div>
