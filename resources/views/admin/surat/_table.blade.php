@if ($suratData->isEmpty())
    <div class="text-center text-muted py-10">
        <i class="ki-duotone ki-information-5 fs-3x mb-3"></i>
        <h4>Tidak ada data surat {{ $tableId === 'masuk' ? 'masuk' : ($tableId === 'keluar' ? 'keluar' : 'masuk & keluar') }}.</h4>
    </div>
@else
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle"
            id="kt_datatable_dom_positioning_surat_{{ $tableId }}">
            <thead class="bg-light">
                <tr>
                    <th>No</th>
                    <th>
                        <a href="{{ sortUrl('nama_kegiatan') }}"
                            class="text-dark text-decoration-none">
                            Nama Kegiatan {!! sortIcon('nama_kegiatan') !!}
                        </a>
                    </th>
                    <th>Dokumen</th>
                    <th>
                        <a href="{{ sortUrl('created_at') }}" class="text-dark text-decoration-none">
                            Tanggal Dibuat {!! sortIcon('created_at') !!}
                        </a>
                    </th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($suratData as $index => $surat)
                    <tr data-jenis-surat="{{ $surat->jenis_surat ?? '' }}">
                        <td class="text-center">
                            {{ $index + 1 }}
                        </td>
                        <td>
                            <div class="d-flex flex-column">
                                <strong class="text-truncate-custom">{{ $surat->nama_kegiatan }}</strong>
                                @if ($surat->jenis_surat && $tableId === 'semua')
                                    <small class="text-muted">
                                        <span class="badge badge-{{ $surat->jenis_surat == 'masuk' ? 'success' : 'primary' }} badge-sm">
                                            {{ $surat->jenis_surat == 'masuk' ? 'Surat Masuk' : 'Surat Keluar' }}
                                        </span>
                                    </small>
                                @endif
                            </div>
                        </td>
                        <td>
                            @if ($surat->dokumen_surat)
                                <a href="{{ asset('storage/' . $surat->dokumen_surat) }}" target="_blank"
                                    class="btn btn-sm btn-light-primary">
                                    <i class="fas fa-file-pdf me-1"></i>Lihat Dokumen
                                </a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            {{ \Carbon\Carbon::parse($surat->created_at)->format('d M Y H:i') }}
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1">
                                <a href="{{ route('admin.surat.edit', $surat->id) }}"
                                   class="btn btn-icon btn-sm btn-light-warning"
                                   title="Edit">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>

                                <button type="button"
                                        class="btn btn-icon btn-sm btn-light-danger"
                                        data-route="{{ route('admin.surat.destroy', $surat->id) }}"
                                        onclick="destroyItem(this)"
                                        title="Hapus">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">Data tidak ditemukan</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($tableId === 'semua' && $suratData instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap">
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

            <div class="d-flex align-items-center gap-3">
                <div class="d-flex align-items-center">
                    <span class="me-2">Page {{ $suratData->currentPage() }} of {{ $suratData->lastPage() }}</span>
                </div>
                <div class="pagination-wrapper">
                    {{ $suratData->appends(request()->query())->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    @endif
@endif
