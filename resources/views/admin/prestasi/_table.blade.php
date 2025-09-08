@if (isset($prestasis) && $prestasis->isEmpty())
    <div class="empty-state">
        <i class="fas fa-trophy fs-3x mb-3 text-muted"></i>
        @if (request('search') || request()->hasAny(['tahun', 'medali', 'tingkat']))
            <h4>Tidak ada prestasi yang sesuai dengan kriteria pencarian.</h4>
            <p class="text-muted">Coba ubah kata kunci pencarian atau filter yang Anda gunakan.</p>
        @else
            <h4>Belum ada data prestasi.</h4>
            <p class="text-muted">Belum ada prestasi yang terdaftar dalam sistem.</p>
        @endif
    </div>
@else
    <div class="table-responsive">
        <table class="table table-hover align-middle" id="prestasi-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>
                        <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'nama', 'order' => request('sort_by') == 'nama' && request('order') == 'asc' ? 'desc' : 'asc']) }}"
                            class="text-decoration-none text-dark sort-link">
                            Nama & Role
                            @if (request('sort_by') == 'nama')
                                @if (request('order') == 'asc')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort-down"></i>
                                @endif
                            @else
                                <i class="fas fa-sort text-muted"></i>
                            @endif
                        </a>
                    </th>
                    <th>
                        <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'jenis_kelamin', 'order' => request('sort_by') == 'jenis_kelamin' && request('order') == 'asc' ? 'desc' : 'asc']) }}"
                            class="text-decoration-none text-dark sort-link">
                            Jenis Kelamin
                            @if (request('sort_by') == 'jenis_kelamin')
                                @if (request('order') == 'asc')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort-down"></i>
                                @endif
                            @else
                                <i class="fas fa-sort text-muted"></i>
                            @endif
                        </a>
                    </th>
                    <th>
                        <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'nama_prestasi', 'order' => request('sort_by') == 'nama_prestasi' && request('order') == 'asc' ? 'desc' : 'asc']) }}"
                            class="text-decoration-none text-dark sort-link">
                            Prestasi & Kejuaraan
                            @if (request('sort_by') == 'nama_prestasi')
                                @if (request('order') == 'asc')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort-down"></i>
                                @endif
                            @else
                                <i class="fas fa-sort text-muted"></i>
                            @endif
                        </a>
                    </th>
                    <th>
                        <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'cabor', 'order' => request('sort_by') == 'cabor' && request('order') == 'asc' ? 'desc' : 'asc']) }}"
                            class="text-decoration-none text-dark sort-link">
                            Cabor
                            @if (request('sort_by') == 'cabor')
                                @if (request('order') == 'asc')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort-down"></i>
                                @endif
                            @else
                                <i class="fas fa-sort text-muted"></i>
                            @endif
                        </a>
                    </th>
                    <th>
                        <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'tingkat', 'order' => request('sort_by') == 'tingkat' && request('order') == 'asc' ? 'desc' : 'asc']) }}"
                            class="text-decoration-none text-dark sort-link">
                            Tingkat
                            @if (request('sort_by') == 'tingkat')
                                @if (request('order') == 'asc')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort-down"></i>
                                @endif
                            @else
                                <i class="fas fa-sort text-muted"></i>
                            @endif
                        </a>
                    </th>
                    <th>
                        <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'tahun', 'order' => request('sort_by') == 'tahun' && request('order') == 'asc' ? 'desc' : 'asc']) }}"
                            class="text-decoration-none text-dark sort-link">
                            Tempat & Tahun
                            @if (request('sort_by') == 'tahun')
                                @if (request('order') == 'asc')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort-down"></i>
                                @endif
                            @else
                                <i class="fas fa-sort text-muted"></i>
                            @endif
                        </a>
                    </th>
                    <th>
                        <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'medali', 'order' => request('sort_by') == 'medali' && request('order') == 'asc' ? 'desc' : 'asc']) }}"
                            class="text-decoration-none text-dark sort-link">
                            Medali
                            @if (request('sort_by') == 'medali')
                                @if (request('order') == 'asc')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort-down"></i>
                                @endif
                            @else
                                <i class="fas fa-sort text-muted"></i>
                            @endif
                        </a>
                    </th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if (isset($prestasis))
                    @forelse ($prestasis as $key => $prestasi)
                        @php
                            $caborNama = $prestasi->subject->cabangOlahraga
                                ? $prestasi->subject->cabangOlahraga->nama_cabor
                                : '-';

                            $jenisKelamin = '';
                            $gender = $prestasi->subject->jenis_kelamin;
                            if ($gender === 'Laki-laki' || $gender === 'L') {
                                $jenisKelamin = 'Laki-laki';
                            } elseif ($gender === 'Perempuan' || $gender === 'P') {
                                $jenisKelamin = 'Perempuan';
                            } else {
                                $jenisKelamin = $gender ?? '-';
                            }

                            $rowNumber = ($prestasis->currentPage() - 1) * $prestasis->perPage() + $loop->iteration;

                            $detailRoute = route('admin.konfigurasi.atlet.show', [
                                'atlet' => $prestasi->subject->id,
                                'back' => 'prestasi',
                            ]);
                        @endphp

                        <tr data-tahun="{{ $prestasi->tahun }}" data-nama="{{ $prestasi->subject?->nama ?? '-' }}">
                            <td>{{ $rowNumber }}</td>

                            <td>
                                <div class="d-flex flex-column">
                                    <strong class="text-truncate-custom"
                                        title="{{ $prestasi->subject->nama }}">
                                        {{ $prestasi->subject->nama }}
                                    </strong>
                                    <small class="text-muted">
                                        Atlet
                                    </small>
                                </div>
                            </td>

                            <td>{{ $jenisKelamin }}</td>

                            <td>
                                <div class="d-flex flex-column">
                                    <strong class="text-truncate-custom">
                                        {{ $prestasi->nama_prestasi }}
                                    </strong>
                                    <small class="text-muted text-truncate-custom">
                                        {{ $prestasi->kejuaraan }}
                                    </small>
                                </div>
                            </td>

                            <td>
                                <div class="text-truncate-custom">
                                    {{ $prestasi->cabangOlahraga?->nama_cabor ?? $prestasi->subject?->cabangOlahraga?->nama_cabor ?? '-' }}
                                </div>
                            </td>

                            <td>{{ $prestasi->tingkat }}</td>

                            <td>
                                <div class="d-flex flex-column">
                                    <strong class="text-truncate-custom">
                                        {{ $prestasi->tempat }}
                                    </strong>
                                    <small class="text-muted">{{ $prestasi->tahun }}</small>
                                </div>
                            </td>

                            <td>
                                @php
                                    $iconColor = '';
                                    switch ($prestasi->medali) {
                                        case 'Emas':
                                            $iconColor = 'text-warning';
                                            break;
                                        case 'Perak':
                                            $iconColor = 'text-dark';
                                            break;
                                        case 'Perunggu':
                                            $iconColor = 'text-bronze';
                                            break;
                                        default:
                                            $iconColor = 'text-primary';
                                            break;
                    }
                                @endphp
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-medal me-2 {{ $iconColor }}"></i>
                                    <span>{{ $prestasi->medali }}</span>
                                </div>
                            </td>

                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ $detailRoute }}" class="btn btn-icon btn-sm btn-light-primary"
                                        title="Lihat Detail Atlet"
                                        data-bs-toggle="tooltip">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.konfigurasi.prestasi.edit', $prestasi->id) }}"
                                        class="btn btn-icon btn-sm btn-light-warning" title="Edit"
                                        data-bs-toggle="tooltip">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <button class="btn btn-icon btn-sm btn-light-danger btn-delete" title="Hapus"
                                        data-bs-toggle="tooltip"
                                        data-route="{{ route('admin.konfigurasi.prestasi.destroy', $prestasi->id) }}">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center py-5 text-muted">Data tidak ditemukan</td>
                        </tr>
                    @endforelse
                @endif
            </tbody>
        </table>
    </div>

    <div class="table-footer">
        <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap">
            <div class="mb-2 mb-md-0">
                <div class="d-flex align-items-center">
                    <span class="me-2">Show</span>
                    <select name="per_page" class="form-select form-select-sm w-auto">
                        @foreach ([10, 25, 50, 100] as $limit)
                            <option value="{{ $limit }}"
                                {{ request('per_page', 10) == $limit ? 'selected' : '' }}>
                                {{ $limit }}
                            </option>
                        @endforeach
                    </select>
                    <span class="ms-2">per page</span>
                </div>
            </div>

            @if (isset($prestasis) && method_exists($prestasis, 'hasPages') && $prestasis->hasPages())
                <div class="d-flex align-items-center gap-3">
                    <div class="text-muted small">
                        {{ $prestasis->firstItem() }}-{{ $prestasis->lastItem() }} of
                        {{ $prestasis->total() }}
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        @if ($prestasis->onFirstPage())
                            <span class="pagination-arrow disabled">←</span>
                        @else
                            <a href="{{ $prestasis->appends(request()->query())->previousPageUrl() }}"
                                class="pagination-arrow pagination-link" aria-label="Previous">←</a>
                        @endif

                        @php
                            $current = $prestasis->currentPage();
                            $total = $prestasis->lastPage();
                            $start = max(1, $current - 2);
                            $end = min($total, $current + 2);

                            if ($end - $start < 4) {
                                if ($start == 1) {
                                    $end = min($total, $start + 4);
                                } else {
                                    $start = max(1, $end - 4);
                                }
                            }
                        @endphp

                        <div class="d-flex align-items-center">
                            @for ($i = $start; $i <= $end; $i++)
                                @if ($i == $current)
                                    <span class="pagination-number active">{{ $i }}</span>
                                @else
                                    <a href="{{ $prestasis->appends(request()->query())->url($i) }}"
                                        class="pagination-number pagination-link">{{ $i }}</a>
                                @endif
                            @endfor
                        </div>

                        @if ($prestasis->hasMorePages())
                            <a href="{{ $prestasis->appends(request()->query())->nextPageUrl() }}"
                                class="pagination-arrow pagination-link" aria-label="Next">→</a>
                        @else
                            <span class="pagination-arrow disabled">→</span>
                        @endif
                    </div>
                </div>
            @elseif(isset($prestasis) && method_exists($prestasis, 'hasPages'))
                <div class="text-muted small">
                    1-{{ $prestasis->count() }} of {{ $prestasis->total() }}
                </div>
            @endif
        </div>
    </div>
@endif
