<div class="table-responsive">
    <table class="table table-hover align-middle" id="kt_datatable_dom_positioning">
        <thead>
    <tr>
        <th>No</th>
        <th>Foto</th>

        {{-- Nama & Cabor --}}
       <th>
    <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'nama', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}"
       class="text-dark text-decoration-none sort-link">
        Nama & Cabor
        <i class="fas fa-sort{{ request('sort_by') == 'nama' ? (request('order') == 'asc' ? '-up' : '-down') : '' }}"></i>
    </a>
</th>

<th>
    <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'tanggal_lahir', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}"
       class="text-dark text-decoration-none sort-link">
        Tempat & Tgl Lahir
        <i class="fas fa-sort{{ request('sort_by') == 'tanggal_lahir' ? (request('order') == 'asc' ? '-up' : '-down') : '' }}"></i>
    </a>
</th>

<th>
    <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'alamat', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}"
       class="text-dark text-decoration-none sort-link">
        Alamat
        <i class="fas fa-sort{{ request('sort_by') == 'alamat' ? (request('order') == 'asc' ? '-up' : '-down') : '' }}"></i>
    </a>
</th>

<th>
    <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'jenis_kelamin', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}"
       class="text-dark text-decoration-none sort-link">
        Jenis Kelamin
        <i class="fas fa-sort{{ request('sort_by') == 'jenis_kelamin' ? (request('order') == 'asc' ? '-up' : '-down') : '' }}"></i>
    </a>
</th>

<th>
    <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'tanggal_lahir', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}"
       class="text-dark text-decoration-none sort-link">
        Usia
        <i class="fas fa-sort{{ request('sort_by') == 'tanggal_lahir' ? (request('order') == 'asc' ? '-up' : '-down') : '' }}"></i>
    </a>
</th>

<th>
    <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'no_telepon', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}"
       class="text-dark text-decoration-none sort-link">
        Telepon
        <i class="fas fa-sort{{ request('sort_by') == 'no_telepon' ? (request('order') == 'asc' ? '-up' : '-down') : '' }}"></i>
    </a>
</th>

<th>
    <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'email', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}"
       class="text-dark text-decoration-none sort-link">
        Email
        <i class="fas fa-sort{{ request('sort_by') == 'email' ? (request('order') == 'asc' ? '-up' : '-down') : '' }}"></i>
    </a>
</th>

<th>
    <a href="{{ request()->fullUrlWithQuery([
        'sort_by' => 'latest_prestasi_at',
        'order'   => request('order') == 'asc' ? 'desc' : 'asc'
    ]) }}" class="text-dark text-decoration-none sort-link">
        Prestasi Terbaru
        <i class="fas fa-sort{{ request('sort_by') == 'latest_prestasi_at' ? (request('order') == 'asc' ? '-up' : '-down') : '' }}"></i>
    </a>
</th>

<th>
    <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'updated_at', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}"
       class="text-dark text-decoration-none sort-link">
        Terakhir Diupdate
        <i class="fas fa-sort{{ request('sort_by') == 'updated_at' ? (request('order') == 'asc' ? '-up' : '-down') : '' }}"></i>
    </a>
</th>

        <th>Aksi</th>
    </tr>
</thead>
        <tbody>
            @if (isset($atlets))
                @forelse ($atlets as $index => $item)
                    @php
                        $age = $item->tanggal_lahir
                            ? \Carbon\Carbon::parse($item->tanggal_lahir)->age
                            : 0;
                        $hasPrestasi =
                            isset($item->prestasis) && $item->prestasis->isNotEmpty()
                                ? 'ada'
                                : 'tidak';
                        $prestasiTerbaru =
                            isset($item->prestasis) && $item->prestasis->isNotEmpty()
                                ? $item->prestasis->first()
                                : null;
                        $caborNama = $item->cabangOlahraga
                            ? $item->cabangOlahraga->nama_cabor
                            : '-';
                        $medaliType = $prestasiTerbaru
                            ? strtolower($prestasiTerbaru->medali)
                            : '';

                        $jumlahPrestasi = $item->prestasis ? $item->prestasis->count() : 0;
                    @endphp
                    <tr data-cabor="{{ $caborNama }}"
                        data-gender="{{ $item->jenis_kelamin }}"
                        data-age="{{ $age }}" data-prestasi="{{ $hasPrestasi }}"
                        data-medali="{{ $medaliType }}">

                       <td>{{ ($atlets->currentPage() - 1) * $atlets->perPage() + $loop->iteration }}</td>

                        <td>
                            @if ($item->foto_atlet)
                                <img src="{{ Storage::url($item->foto_atlet) }}"
                                    width="40" height="40"
                                    class="rounded-circle object-fit-cover">
                            @else
                                <div class="rounded-circle bg-secondary text-white text-center fw-bold"
                                    style="width: 40px; height: 40px; line-height: 40px;">
                                    {{ strtoupper(substr($item->nama, 0, 1)) }}
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex flex-column">
                                <strong
                                    class="text-truncate-custom">{{ $item->nama }}</strong>
                                <small class="text-muted">{{ $caborNama }}</small>
                            </div>
                        </td>
                        <td>
                            @if ($item->tanggal_lahir)
                                <div class="d-flex flex-column">
                                    <span
                                        class="text-truncate-custom">{{ \Carbon\Carbon::parse($item->tanggal_lahir)->format('d M Y') }}</span>
                                    @if ($item->tempat_lahir)
                                        <small
                                            class="text-muted text-truncate-custom">{{ $item->tempat_lahir }}</small>
                                    @endif
                                </div>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @if ($item->alamat)
                                @php
                                    $alamatParts = explode(' ', $item->alamat);
                                    $lastWord = array_pop($alamatParts);
                                    $restOfAddress = implode(' ', $alamatParts);
                                @endphp
                                <div class="d-flex flex-column">
                                    <strong><span
                                            class="fw-bold text-dark text-truncate-custom">{{ $lastWord }}</span></strong>
                                    <span
                                        class="text-muted small text-truncate-custom">{{ $restOfAddress }}</span>
                                </div>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>{{ $item->jenis_kelamin }}</td>
                        <td>{{ $age }} Tahun</td>
                        <td>
                            <div class="text-truncate-custom">{{ $item->no_telepon ?? '-' }}
                            </div>
                        </td>
                        <td>
                            <div class="text-truncate-custom" title="{{ $item->email }}">
                                {{ $item->email ?? '-' }}</div>
                        </td>
                        <td>
                            @if ($prestasiTerbaru)
                                <div class="d-flex align-items-center">
                                    <div class="me-2">
                                        @if ($medaliType === 'emas')
                                            <i class="fas fa-medal text-warning"></i>
                                        @elseif($medaliType === 'perak')
                                            <i class="fas fa-medal text-secondary"></i>
                                        @elseif($medaliType === 'perunggu')
                                            <i class="fas fa-medal text-bronze"></i>
                                        @endif
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span
                                            class="text-truncate-custom">{{ $prestasiTerbaru->nama_prestasi }}</span>
                                        <small
                                            class="text-muted">{{ $prestasiTerbaru->tahun }}
                                            @if ($prestasiTerbaru->tempat)
                                                • {{ $prestasiTerbaru->tempat }}
                                            @endif
                                        </small>
                                    </div>
                                </div>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            {{ \Carbon\Carbon::parse($item->updated_at)->format('M d, Y') }}
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1">
                                <a href="{{ route('admin.konfigurasi.atlet.show', $item->id) }}"
                                    class="btn btn-icon btn-sm btn-light-primary"
                                    title="Detail">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.konfigurasi.atlet.edit', $item->id) }}"
                                    class="btn btn-icon btn-sm btn-light-warning"
                                    title="Edit">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>

                                {{-- Logic untuk tombol delete dengan peringatan prestasi --}}
                                @if ($jumlahPrestasi > 0)
                                    <button type="button"
                                        class="btn btn-icon btn-sm btn-light-danger"
                                        title="Tidak dapat dihapus - Atlet memiliki {{ $jumlahPrestasi }} prestasi"
                                        onclick="showAtletDeleteWarning('{{ $item->nama }}', {{ $jumlahPrestasi }})"
                                        style="opacity: 0.6;">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                @else
                                    <button type="button"
                                        class="btn btn-icon btn-sm btn-light-danger btn-delete"
                                        data-route="{{ route('admin.konfigurasi.atlet.destroy', $item->id) }}"
                                        title="Hapus">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="12" class="text-center py-5 text-muted">Data tidak
                            ditemukan</td>
                    </tr>
                @endforelse
            @endif
        </tbody>
    </table>
</div>

{{-- Pagination section tetap sama --}}
<div class="table-footer">
    <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap">
        <div class="mb-2 mb-md-0">
            <form method="GET" class="d-flex align-items-center" id="per-page-form">
                <span class="me-2">Show</span>
                <select name="per_page" class="form-select form-select-sm w-auto">
                    @foreach ([10, 25, 50, 100] as $limit)
                        <option value="{{ $limit }}"
                            {{ request('per_page') == $limit ? 'selected' : '' }}>
                            {{ $limit }}
                        </option>
                    @endforeach
                </select>
                <span class="ms-2">per page</span>
            </form>
        </div>

        @if (isset($atlets) && method_exists($atlets, 'hasPages') && $atlets->hasPages())
            <div class="d-flex align-items-center gap-3">
                <div class="text-muted small">
                    {{ $atlets->firstItem() }}-{{ $atlets->lastItem() }} of
                    {{ $atlets->total() }}
                </div>

                <div class="d-flex align-items-center gap-2">
                    @if ($atlets->onFirstPage())
                        <span class="pagination-arrow disabled">←</span>
                    @else
                        <a href="{{ $atlets->previousPageUrl() }}" class="pagination-arrow pagination-link"
                            aria-label="Previous">←</a>
                    @endif

                    @php
                        $current = $atlets->currentPage();
                        $total = $atlets->lastPage();
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
                                <span
                                    class="pagination-number active">{{ $i }}</span>
                            @else
                                <a href="{{ $atlets->url($i) }}"
                                    class="pagination-number pagination-link">{{ $i }}</a>
                            @endif
                        @endfor
                    </div>

                    @if ($atlets->hasMorePages())
                        <a href="{{ $atlets->nextPageUrl() }}" class="pagination-arrow pagination-link"
                            aria-label="Next">→</a>
                    @else
                        <span class="pagination-arrow disabled">→</span>
                    @endif
                </div>
            </div>
        @elseif(isset($atlets) && method_exists($atlets, 'hasPages'))
            <div class="text-muted small">
                1-{{ $atlets->count() }} of {{ $atlets->total() }}
            </div>
        @endif
    </div>
</div>
