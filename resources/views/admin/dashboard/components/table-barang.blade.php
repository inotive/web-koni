<div class="table-reponsive table-bordered py-4 d-flex flex-column gap-4" style="overflow-x: auto;">
    <!--begin::Table-->
    <table class="gs-0 gy-4 m-0 table border border-gray-300 p-0 text-center align-middle">
        <!--begin::Table head-->
        <thead>
            <tr class="fw-bold text-muted p-0">
                <th class="min-w-150px bg-light border border-gray-300 px-2 text-center">Kode Barang</th>
                <th class="min-w-150px bg-light border border-gray-300 px-2 text-center">Nama Barang</th>
                <th class="min-w-100px bg-light border border-gray-300 px-2 text-center">Nama Nasabah</th>
                <th class="min-w-150px bg-light border border-gray-300 px-2 text-center">Tanggal Gadai</th>
                <th class="min-w-150px bg-light border border-gray-300 px-2 text-center">Jatuh Tempo</th>
                <th class="min-w-100px bg-light border border-gray-300 px-2 text-center">Status</th>
            </tr>
        </thead>
        <!--end::Table head-->
        <!--begin::Table body-->
        <tbody>
            @forelse ($nota as $index => $item)
                <tr>
                    <td>{{ $item->nota_gadai_has_item->kode_barang }}</td>
                    <td>{{ $item->nota_gadai_has_item->product->name }}</td>
                    <td>{{ $item->nasabah->nama }}</td>
                    <td>{{ $item->tanggal_masuk->format('d F Y') }}</td>
                    <td>{{ $item->jatuh_tempo->format('d F Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td class="fw-bold py-8 text-gray-600" colspan="9">Tidak ada transaksi ditemukan</td>
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
