@if (isset($atlet) && $atlet->isEmpty())
    <div class="empty-state">
        <i class="fas fa-search fs-3x mb-3 text-muted"></i>
        @if(request('search') || request()->hasAny(['filter_cabor', 'filter_gender', 'filter_age', 'filter_prestasi']))
            <h4>Tidak ada atlet yang sesuai dengan kriteria pencarian.</h4>
            <p class="text-muted">Coba ubah kata kunci pencarian atau filter yang Anda gunakan.</p>
            {{-- <button class="btn btn-outline-primary" id="reset-all-filters">
                <i class="fas fa-redo me-2"></i>Reset Pencarian
            </button> --}}
        @else
            <h4>Tidak ada data atlet.</h4>
            <p class="text-muted">Belum ada atlet yang terdaftar dalam sistem.</p>
        @endif
    </div>
@else
    <div class="table-responsive">
        <table class="table table-hover align-middle" id="atlet-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Foto</th>
                    <th>
                        <a href="#" class="text-decoration-none text-dark sort-link"
                        data-sort="nama">
                            Nama Atlet & Cabor
                            @if(request('sort_by') == 'nama')
                                @if(request('order') == 'asc')
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
                        <a href="#" class="text-decoration-none text-dark sort-link"
                        data-sort="tanggal_lahir">
                            Tempat & Tanggal Lahir
                            @if(request('sort_by') == 'tanggal_lahir')
                                @if(request('order') == 'asc')
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
                        <a href="#" class="text-decoration-none text-dark sort-link"
                        data-sort="alamat">
                            Alamat
                            @if(request('sort_by') == 'alamat')
                                @if(request('order') == 'asc')
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
                        <a href="#" class="text-decoration-none text-dark sort-link"
                        data-sort="jenis_kelamin">
                            Kelamin
                            @if(request('sort_by') == 'jenis_kelamin')
                                @if(request('order') == 'asc')
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
                        <a href="#" class="text-decoration-none text-dark sort-link"
                        data-sort="tanggal_lahir">
                            Usia
                            @if(request('sort_by') == 'tanggal_lahir')
                                @if(request('order') == 'desc')
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
                        <a href="#" class="text-decoration-none text-dark sort-link"
                        data-sort="no_telepon">
                            Telepon
                            @if(request('sort_by') == 'no_telepon')
                                @if(request('order') == 'asc')
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
                        <a href="#" class="text-decoration-none text-dark sort-link"
                        data-sort="email">
                            Email
                            @if(request('sort_by') == 'email')
                                @if(request('order') == 'asc')
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
                        <a href="#" class="text-decoration-none text-dark sort-link"
                        data-sort="prestasi">
                            Prestasi Terbaru
                            @if(request('sort_by') == 'prestasi')
                                @if(request('order') == 'asc')
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
                        <a href="#" class="text-decoration-none text-dark sort-link"
                        data-sort="updated_at">
                            Terakhir Diupdate
                            @if(request('sort_by') == 'updated_at')
                                @if(request('order') == 'asc')
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
                @if(isset($atlet))
                    @forelse ($atlet as $index => $item)
                        @php
                            $age = $item->tanggal_lahir ? \Carbon\Carbon::parse($item->tanggal_lahir)->age : 0;
                            $hasPrestasi = isset($item->prestasis) && $item->prestasis->isNotEmpty() ? 'ada' : 'tidak';
                            $prestasiTerbaru = isset($item->prestasis) && $item->prestasis->isNotEmpty() ? $item->prestasis->first() : null;
                            $caborNama = $item->cabangOlahraga ? $item->cabangOlahraga->nama_cabor : '-';
                            $medaliType = $prestasiTerbaru ? strtolower($prestasiTerbaru->medali) : '';
                        @endphp
                        <tr>
                            <td>{{ $atlet->firstItem() + $loop->index }}</td>

                            <td>
                                @if ($item->foto)
                                    <img src="{{ Storage::url($item->foto) }}" width="40" height="40" class="rounded-circle object-fit-cover">
                                @else
                                    <div class="rounded-circle bg-secondary text-white text-center fw-bold" style="width: 40px; height: 40px; line-height: 40px;">
                                        {{ strtoupper(substr($item->nama, 0, 1)) }}
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    <strong class="text-truncate-custom">
                                        @if(request('search'))
                                            {!! preg_replace('/(' . preg_quote(request('search'), '/') . ')/i', '<span class="search-highlight">$1</span>', $item->nama) !!}
                                        @else
                                            {{ $item->nama }}
                                        @endif
                                    </strong>
                                    <small class="text-muted">{{ $caborNama }}</small>
                                </div>
                            </td>
                            <td>
                                @if($item->tanggal_lahir)
                                    <div class="d-flex flex-column">
                                        <span class="text-truncate-custom"><strong>{{ \Carbon\Carbon::parse($item->tanggal_lahir)->format('d M Y') }}</strong></span>
                                        @if($item->tempat_lahir)
                                            <small class="text-muted text-truncate-custom">
                                                @if(request('search'))
                                                    {!! preg_replace('/(' . preg_quote(request('search'), '/') . ')/i', '<span class="search-highlight">$1</span>', $item->tempat_lahir) !!}
                                                @else
                                                    {{ $item->tempat_lahir }}
                                                @endif
                                            </small>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($item->alamatkota && $item->alamatprovinsi)
                                    <div class="d-flex flex-column">
                                        <strong class="text-dark text-truncate-custom">
                                            @if(request('search'))
                                                {!! preg_replace('/(' . preg_quote(request('search'), '/') . ')/i', '<span class="search-highlight">$1</span>', $item->alamatkota . ', ' . $item->alamatprovinsi) !!}
                                            @else
                                                {{ $item->alamatkota }}, {{ $item->alamatprovinsi }}
                                            @endif
                                        </strong>
                                        @if($item->alamat)
                                            <small class="text-muted text-truncate-custom" style="font-size: 11px; line-height: 1.2;">
                                                @if(request('search'))
                                                    {!! preg_replace('/(' . preg_quote(request('search'), '/') . ')/i', '<span class="search-highlight">$1</span>', $item->alamat) !!}
                                                @else
                                                    {{ $item->alamat }}
                                                @endif
                                            </small>
                                        @endif
                                    </div>
                                @elseif($item->alamat)
                                    <div class="text-truncate-custom">
                                        @if(request('search'))
                                            {!! preg_replace('/(' . preg_quote(request('search'), '/') . ')/i', '<span class="search-highlight">$1</span>', $item->alamat) !!}
                                        @else
                                            {{ $item->alamat }}
                                        @endif
                                    </div>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ $item->jenis_kelamin }}</td>
                            <td>{{ $age }} Tahun</td>
                            <td>
                                <div class="text-truncate-custom">
                                    @if($item->no_telepon)
                                        @if(request('search'))
                                            {!! preg_replace('/(' . preg_quote(request('search'), '/') . ')/i', '<span class="search-highlight">$1</span>', $item->no_telepon) !!}
                                        @else
                                            {{ $item->no_telepon }}
                                        @endif
                                    @else
                                        -
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="text-truncate-custom" title="{{ $item->email }}">
                                    @if($item->email)
                                        @if(request('search'))
                                            {!! preg_replace('/(' . preg_quote(request('search'), '/') . ')/i', '<span class="search-highlight">$1</span>', $item->email) !!}
                                        @else
                                                {{ $item->email }}
                                        @endif
                                    @else
                                        -
                                    @endif
                                </div>
                            </td>
                            <td>
                                @if($prestasiTerbaru)
                                    <div class="d-flex align-items-center">
                                        <div class="me-2">
                                            @if($medaliType === 'emas')
                                                <i class="fas fa-medal text-warning"></i>
                                            @elseif($medaliType === 'perak')
                                                <i class="fas fa-medal text-secondary"></i>
                                            @elseif($medaliType === 'perunggu')
                                                <i class="fas fa-medal text-bronze"></i>
                                            @endif
                                        </div>
                                        <div class="d-flex flex-column">
                                            <span class="text-truncate-custom">
                                                @if(request('search'))
                                                    {!! preg_replace('/(' . preg_quote(request('search'), '/') . ')/i', '<span class="search-highlight">$1</span>', $prestasiTerbaru->nama_prestasi) !!}
                                                @else
                                                    <strong>{{ $prestasiTerbaru->nama_prestasi }}</strong>
                                                @endif
                                            </span>
                                            <small class="text-muted">{{ $prestasiTerbaru->tahun }}@if($prestasiTerbaru->tempat) • {{ $prestasiTerbaru->tempat }}@endif</small>
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
                                    <a href="{{ route('admin.konfigurasi.atlet.show', ['atlet' => $item->id, 'from' => 'atlet']) }}"
                                    class="btn btn-icon btn-sm btn-light-primary"
                                    title="Detail">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.konfigurasi.atlet.edit', $item->id) }}"
                                    class="btn btn-icon btn-sm btn-light-warning"
                                    title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <button type="button"
                                            class="btn btn-icon btn-sm btn-light-danger"
                                            data-route="{{ route('admin.konfigurasi.atlet.destroy', $item->id) }}"
                                            @if($item->prestasis_count > 0 || $item->prestasis->isNotEmpty())
                                                onclick="showDeleteWarning(this, '{{ $item->nama }}', {{ $item->prestasis->pluck('nama_prestasi') }})"
                                            @else
                                                onclick="destroyItem(this)"
                                            @endif
                                            title="Hapus">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="12" class="text-center py-5 text-muted">Data tidak ditemukan</td>
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

            @if (isset($atlet) && method_exists($atlet, 'hasPages') && $atlet->hasPages())
                <div class="d-flex align-items-center gap-3">
                    <div class="text-muted small">
                        {{ $atlet->firstItem() }}-{{ $atlet->lastItem() }} of
                        {{ $atlet->total() }}
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        @if ($atlet->onFirstPage())
                            <span class="pagination-arrow disabled">←</span>
                        @else
                            <a href="{{ $atlet->appends(request()->query())->previousPageUrl() }}"
                               class="pagination-arrow pagination-link"
                               aria-label="Previous">←</a>
                        @endif

                        @php
                            $current = $atlet->currentPage();
                            $total = $atlet->lastPage();
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
                                    <a href="{{ $atlet->appends(request()->query())->url($i) }}"
                                       class="pagination-number pagination-link">{{ $i }}</a>
                                @endif
                            @endfor
                        </div>

                        @if ($atlet->hasMorePages())
                            <a href="{{ $atlet->appends(request()->query())->nextPageUrl() }}"
                               class="pagination-arrow pagination-link"
                               aria-label="Next">→</a>
                        @else
                            <span class="pagination-arrow disabled">→</span>
                        @endif
                    </div>
                </div>
            @elseif(isset($atlet) && method_exists($atlet, 'hasPages'))
                <div class="text-muted small">
                    1-{{ $atlet->count() }} of {{ $atlet->total() }}
                </div>
            @endif
        </div>
    </div>
@endif

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
