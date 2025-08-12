@if ($sumberDayaData->isEmpty())
    {{-- Empty State --}}
    <div class="text-center text-muted py-10">
        <i class="ki-duotone ki-information-5 fs-3x mb-3"></i>
        <h4>Tidak ada data mobilisasi sumber daya.</h4>
    </div>
@else
    {{-- Data Table --}}
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle" id="kt_datatable_dom_positioning_sumberdaya">
            {{-- Table Header --}}
            <thead class="bg-light">
                <tr>
                    <th>No</th>
                    <th>
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'nama_program', 'direction' => (request()->get('sort') == 'nama_program' && request()->get('direction') == 'asc') ? 'desc' : 'asc']) }}"
                            class="text-dark text-decoration-none sortable-header">
                            Nama Program & Kegiatan
                            @if(request()->get('sort') == 'nama_program')
                                <i class="fas fa-sort-{{ request()->get('direction') == 'asc' ? 'up' : 'down' }}"></i>
                            @else
                                <i class="fas fa-sort"></i>
                            @endif
                        </a>
                    </th>
                    <th>
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'volume', 'direction' => (request()->get('sort') == 'volume' && request()->get('direction') == 'asc') ? 'desc' : 'asc']) }}"
                            class="text-dark text-decoration-none sortable-header">
                            Volume
                            @if(request()->get('sort') == 'volume')
                                <i class="fas fa-sort-{{ request()->get('direction') == 'asc' ? 'up' : 'down' }}"></i>
                            @else
                                <i class="fas fa-sort"></i>
                            @endif
                        </a>
                    </th>
                    <th>
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'jumlah_harga_satuan', 'direction' => (request()->get('sort') == 'jumlah_harga_satuan' && request()->get('direction') == 'asc') ? 'desc' : 'asc']) }}"
                            class="text-dark text-decoration-none sortable-header">
                            Jumlah Harga Satuan
                            @if(request()->get('sort') == 'jumlah_harga_satuan')
                                <i class="fas fa-sort-{{ request()->get('direction') == 'asc' ? 'up' : 'down' }}"></i>
                            @else
                                <i class="fas fa-sort"></i>
                            @endif
                        </a>
                    </th>
                    <th>
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'jumlah_harga', 'direction' => (request()->get('sort') == 'jumlah_harga' && request()->get('direction') == 'asc') ? 'desc' : 'asc']) }}"
                            class="text-dark text-decoration-none sortable-header">
                            Jumlah Harga
                            @if(request()->get('sort') == 'jumlah_harga')
                                <i class="fas fa-sort-{{ request()->get('direction') == 'asc' ? 'up' : 'down' }}"></i>
                            @else
                                <i class="fas fa-sort"></i>
                            @endif
                        </a>
                    </th>
                    <th>Foto Jurnal</th>
                    <th>Dokumen LPJ</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($sumberDayaData as $index => $data)
                    <tr>
                        <td class="text-center">
                            {{ ($sumberDayaData->currentPage() - 1) * $sumberDayaData->perPage() + $index + 1 }}
                        </td>
                        <td>
                            <div class="d-flex flex-column">
                                <strong class="text-truncate-custom">{{ $data->nama_program }}</strong>
                                @if ($data->nama_kegiatan)
                                    <small class="text-muted">{{ $data->nama_kegiatan }}</small>
                                @endif
                            </div>
                        </td>
                        <td>{{ $data->volume }}</td>
                        <td>Rp {{ number_format($data->jumlah_harga_satuan, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($data->jumlah_harga, 0, ',', '.') }}</td>
                        <td>
                            @if ($data->foto_jurnal && count($data->foto_jurnal) > 0)
                                <div class="d-flex flex-wrap gap-1">
                                    @foreach($data->foto_jurnal as $foto)
                                        <a href="{{ asset('storage/' . $foto) }}" target="_blank" class="btn btn-sm btn-light-info">
                                            <i class="fas fa-image me-1"></i>Foto
                                        </a>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @if ($data->dokumen_lpj && count($data->dokumen_lpj) > 0)
                                <div class="d-flex flex-wrap gap-1">
                                    @foreach($data->dokumen_lpj as $dokumen)
                                        @php
                                            $filename = basename($dokumen);
                                            // Check if filename is too long (more than 15 characters)
                                            $displayName = strlen($filename) > 15 ? 'Dokumen' : $filename;
                                        @endphp
                                        <a href="{{ asset('storage/' . $dokumen) }}"
                                           target="_blank"
                                           class="btn btn-sm btn-light-primary"
                                           title="{{ $filename }}"
                                           data-bs-toggle="tooltip"
                                           data-bs-placement="top">
                                            <i class="fas fa-file me-1"></i>{{ $displayName }}
                                        </a>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="dropdown">
                                <button class="btn btn-sm" type="button" data-bs-toggle="dropdown"
                                    data-bs-boundary="window" aria-expanded="false"
                                    style="padding: 7px; border: 1px solid #DBDFE9; border-radius: 6px;">
                                    <svg fill="none" stroke-width="1.5" stroke="currentColor"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg "
                                        width="24" height="24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 6.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 12.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 18.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5Z" />
                                    </svg>
                                </button>

                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="{{ route('admin.laporan-lpj.bidang.mobilisasi-sumberdaya.show', $data->id) }}"
                                            class="dropdown-item d-flex align-items-center gap-2">
                                            <i class="fas fa-eye"></i> Lihat Detail
                                        </a>
                                    </li>

                                    <li>
                                        <a href="{{ route('admin.laporan-lpj.bidang.mobilisasi-sumberdaya.edit', $data->id) }}"
                                            class="dropdown-item d-flex align-items-center gap-2">
                                            <i class="fas fa-edit"></i> Modifikasi
                                        </a>
                                    </li>

                                    <li>
                                        <form
                                            action="{{ route('admin.laporan-lpj.bidang.mobilisasi-sumberdaya.destroy', $data->id) }}"
                                            method="POST" class="d-inline"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="dropdown-item d-flex align-items-center gap-2 text-danger">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">Data tidak ditemukan</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination Controls --}}
    <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap">
        {{-- Per Page Selector --}}
        <div class="mb-2 mb-md-0">
            <div class="d-flex align-items-center">
                <span class="me-2">Show</span>
                <select class="form-select form-select-sm w-auto" id="per-page-select">
                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                </select>
                <span class="ms-2">per page</span>
            </div>
        </div>

        {{-- Pagination Links --}}
        <div class="d-flex align-items-center gap-3">
            <div class="d-flex align-items-center">
                <span class="me-2">Page {{ $sumberDayaData->currentPage() }} of
                    {{ $sumberDayaData->lastPage() }}</span>
            </div>
            <div class="pagination-wrapper">
                {{ $sumberDayaData->appends(request()->query())->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>

    {{-- Initialize Bootstrap Tooltips --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize tooltips for document buttons
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
@endif
