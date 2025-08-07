@if (isset($prestasis) && $prestasis->isEmpty())
    <div class="empty-state">
        <i class="fas fa-trophy fs-3x mb-3"></i>
        <h4>Belum ada data prestasi.</h4>
    </div>
@else
    <div class="table-responsive">
        <table class="table table-hover align-middle" id="kt_datatable_prestasi">
            <thead>
                <tr>
                    <th>No</th>

                    <th>
                        <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'nama', 'order' => request('sort_by') == 'nama' && request('order') == 'asc' ? 'desc' : 'asc']) }}"
                           class="text-dark text-decoration-none sort-link">
                            Nama
                            <i class="fas fa-sort{{ request('sort_by') == 'nama' ? (request('order') == 'asc' ? '-up' : '-down') : '' }}"></i>
                        </a>
                    </th>

                    <th>
                        <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'jenis_kelamin', 'order' => request('sort_by') == 'jenis_kelamin' && request('order') == 'asc' ? 'desc' : 'asc']) }}"
                           class="text-dark text-decoration-none sort-link">
                            Jenis Kelamin
                            <i class="fas fa-sort{{ request('sort_by') == 'jenis_kelamin' ? (request('order') == 'asc' ? '-up' : '-down') : '' }}"></i>
                        </a>
                    </th>

                    <th>
                        <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'nama_prestasi', 'order' => request('sort_by') == 'nama_prestasi' && request('order') == 'asc' ? 'desc' : 'asc']) }}"
                           class="text-dark text-decoration-none sort-link">
                            Prestasi
                            <i class="fas fa-sort{{ request('sort_by') == 'nama_prestasi' ? (request('order') == 'asc' ? '-up' : '-down') : '' }}"></i>
                        </a>
                    </th>

                    <th>
                        <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'cabor', 'order' => request('sort_by') == 'cabor' && request('order') == 'asc' ? 'desc' : 'asc']) }}"
                           class="text-dark text-decoration-none sort-link">
                            Cabor
                            <i class="fas fa-sort{{ request('sort_by') == 'cabor' ? (request('order') == 'asc' ? '-up' : '-down') : '' }}"></i>
                        </a>
                    </th>

                    <th>
                        <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'tingkat', 'order' => request('sort_by') == 'tingkat' && request('order') == 'asc' ? 'desc' : 'asc']) }}"
                           class="text-dark text-decoration-none sort-link">
                            Tingkat
                            <i class="fas fa-sort{{ request('sort_by') == 'tingkat' ? (request('order') == 'asc' ? '-up' : '-down') : '' }}"></i>
                        </a>
                    </th>

                    <th>
                        <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'tahun', 'order' => request('sort_by') == 'tahun' && request('order') == 'asc' ? 'desc' : 'asc']) }}"
                           class="text-dark text-decoration-none sort-link">
                            Tempat & Tahun
                            <i class="fas fa-sort{{ request('sort_by') == 'tahun' ? (request('order') == 'asc' ? '-up' : '-down') : '' }}"></i>
                        </a>
                    </th>

                    <th>
                        <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'medali', 'order' => request('sort_by') == 'medali' && request('order') == 'asc' ? 'desc' : 'asc']) }}"
                           class="text-dark text-decoration-none sort-link">
                            Medali
                            <i class="fas fa-sort{{ request('sort_by') == 'medali' ? (request('order') == 'asc' ? '-up' : '-down') : '' }}"></i>
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
                            if ($prestasi->subject_type === 'App\Models\Atlet') {
                                $gender = $prestasi->subject->jenis_kelamin;
                                if ($gender === 'Laki-laki' || $gender === 'L') {
                                    $jenisKelamin = 'Laki-laki';
                                } elseif ($gender === 'Perempuan' || $gender === 'P') {
                                    $jenisKelamin = 'Perempuan';
                                } else {
                                    $jenisKelamin = $gender ?? '-';
                                }
                            } elseif ($prestasi->subject_type === 'App\Models\Pelatih') {
                                $gender = $prestasi->subject->kelamin;
                                if ($gender === 'Laki-laki' || $gender === 'L') {
                                    $jenisKelamin = 'Laki-laki';
                                } elseif ($gender === 'Perempuan' || $gender === 'P') {
                                    $jenisKelamin = 'Perempuan';
                                } else {
                                    $jenisKelamin = $gender ?? '-';
                                }
                            }

                            $rowNumber = ($prestasis->currentPage() - 1) * $prestasis->perPage() + $loop->iteration;

                            $detailRoute = '';
                            if ($prestasi->subject_type === 'App\Models\Atlet') {
                                $detailRoute = route('admin.konfigurasi.atlet.show', [
                                    'atlet' => $prestasi->subject->id,
                                    'from' => 'prestasi',
                                ]);
                            } elseif ($prestasi->subject_type === 'App\Models\Pelatih') {
                                $detailRoute = route('admin.konfigurasi.pelatih.show', [
                                    'pelatih' => $prestasi->subject->id,
                                    'from' => 'prestasi',
                                ]);
                            }
                        @endphp

                        <tr data-tahun="{{ $prestasi->tahun }}" data-nama="{{ $prestasi->subject?->nama ?? '-' }}">
                            <td>{{ $rowNumber }}</td>

                            <td>
                                <div class="d-flex align-items-center">
                                    @if ($prestasi->subject->foto_atlet ?? ($prestasi->subject->foto_pelatih ?? null))
                                        <img src="{{ asset('storage/' . ($prestasi->subject->foto_atlet ?? $prestasi->subject->foto_pelatih)) }}"
                                            alt="{{ $prestasi->subject->nama }}"
                                            class="rounded-circle me-2 object-fit-cover" width="40"
                                            height="40">
                                    @else
                                        <div class="rounded-circle bg-light me-2 d-flex align-items-center justify-content-center"
                                            style="width: 40px; height: 40px;">
                                            <i class="fas fa-user text-muted"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <strong>{{ $prestasi->subject->nama }}</strong><br>
                                        <small class="text-muted">
                                            {{ class_basename($prestasi->subject_type) }}
                                        </small>
                                    </div>
                                </div>
                            </td>

                            <td>{{ $jenisKelamin }}</td>

                            <td>
                                <div>
                                    <strong>{{ $prestasi->nama_prestasi }}</strong><br>
                                    <small class="text-muted">
                                        {{ $prestasi->kejuaraan }}
                                    </small>
                                </div>
                            </td>

                            <td>
                                <div class="text-truncate-custom">
                                    {{ $prestasi->subject?->cabangOlahraga?->nama_cabor ?? '-' }}
                                </div>
                            </td>

                            <td>{{ $prestasi->tingkat }}</td>

                            <td>
                                <div class="d-flex flex-column">
                                    <span class="text-truncate-custom">{{ $prestasi->tempat }}</span>
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
                                            $iconColor = 'text-secondary';
                                            break;
                                        case 'Perunggu':
                                            $iconColor = 'text-bronze';
                                            break;
                                        default:
                                            $iconColor = 'text-primary';
                                            break;
                                    }
                                @endphp
                                <span>
                                    <i class="fas fa-medal me-1 {{ $iconColor }}"></i>
                                    {{ $prestasi->medali }}
                                </span>
                            </td>

                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    @if ($detailRoute)
                                        <a href="{{ $detailRoute }}" class="btn btn-icon btn-sm btn-light-info"
                                            title="Lihat Detail {{ class_basename($prestasi->subject_type) }}"
                                            data-bs-toggle="tooltip">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                    @endif
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
                            <td colspan="9" class="text-center py-5 text-muted">Data tidak ditemukan</td>
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
                            <a href="{{ $prestasis->previousPageUrl() }}" class="pagination-arrow pagination-link"
                                aria-label="Previous">←</a>
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
                                    <a href="{{ $prestasis->url($i) }}"
                                        class="pagination-number pagination-link">{{ $i }}</a>
                                @endif
                            @endfor
                        </div>

                        @if ($prestasis->hasMorePages())
                            <a href="{{ $prestasis->nextPageUrl() }}" class="pagination-arrow pagination-link"
                                aria-label="Next">→</a>
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
