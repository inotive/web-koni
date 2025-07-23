@extends('layouts.app')

@section('pageTitle', 'Pelatih')

@section('mainSection', 'Konfigurasi')
@section('mainSectionUrl', route('admin.konfigurasi.pelatih.index'))
@section('currentSection', 'Pelatih')

@section('content')


@php
function sortIcon($field) {
    if (request('sort') === $field) {
        return request('order') === 'asc' ? '⬆' : '⬇';
    }
    return '<i class="fas fa-sort text-muted"></i>';
}

function sortUrl($field) {
    $order = request('sort') === $field && request('order') === 'asc' ? 'desc' : 'asc';
    return request()->fullUrlWithQuery(['sort' => $field, 'order' => $order]);
}
@endphp

<style>
    table td,
    table th {
        text-overflow: ellipsis;
        overflow: hidden;
        white-space: nowrap;
        vertical-align: middle;
    }
    .object-fit-cover {
        object-fit: cover;
    }
</style>

<div class="row col-12 mt-5">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
            <h3 class="card-title fw-bold fs-3 mb-0">Pelatih</h3>
            <a href="{{ route('admin.konfigurasi.pelatih.create') }}" class="btn btn-sm btn-warning">
                <i class="fas fa-plus me-1"></i> Tambah Data Pelatih
            </a>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Informasi Pelatih</h2>

            <form method="GET" class="d-flex align-items-center gap-2">
                <div class="input-group" style="width: 250px;">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari pelatih...">
                    <button class="btn btn-outline-secondary" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>

                <div class="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-filter me-1"></i> Filter
                    </button>
                    <div class="dropdown-menu p-3 shadow" style="min-width: 250px;">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Kelamin</label>
                            <select name="kelamin" class="form-select" onchange="this.form.submit()">
                                <option value="">Semua</option>
                                @foreach ($allKelamin as $k)
                                    <option value="{{ $k }}" {{ request('kelamin') == $k ? 'selected' : '' }}>{{ $k }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="form-label fw-semibold">Cabang Olahraga</label>
                            <select name="cabor" class="form-select" onchange="this.form.submit()">
                                <option value="">Semua</option>
                                @foreach ($allCabor as $c)
                                    <option value="{{ $c }}" {{ request('cabor') == $c ? 'selected' : '' }}>{{ $c }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </form>
        </div>

            {{-- Table --}}
            <table class="table table-bordered table-hover align-middle text-nowrap">
                <thead class="bg-light">
                    <tr>
                        <th>No</th>
                        <th>Foto</th>
                        <th><a href="{{ sortUrl('nama') }}" class="text-dark text-decoration-none">Nama Pelatih & Cabor {!! sortIcon('nama') !!}</a></th>
                        <th><a href="{{ sortUrl('tanggal_lahir') }}" class="text-dark text-decoration-none">Tempat & Tanggal Lahir {!! sortIcon('tanggal_lahir') !!}</a></th>
                        <th><a href="{{ sortUrl('alamat') }}" class="text-dark text-decoration-none">Alamat {!! sortIcon('alamat') !!}</a></th>
                        <th><a href="{{ sortUrl('kelamin') }}" class="text-dark text-decoration-none">Kelamin {!! sortIcon('kelamin') !!}</a></th>
                        <th><a href="{{ sortUrl('tanggal_lahir') }}" class="text-dark text-decoration-none">Usia {!! sortIcon('tanggal_lahir') !!}</a></th>
                        <th><a href="{{ sortUrl('prestasi') }}" class="text-dark text-decoration-none">Prestasi Terbaru {!! sortIcon('prestasi') !!}</a></th>
                        <th><a href="{{ sortUrl('no_telepon') }}" class="text-dark text-decoration-none">Telepon {!! sortIcon('no_telepon') !!}</a></th>
                        <th><a href="{{ sortUrl('email') }}" class="text-dark text-decoration-none">Email {!! sortIcon('email') !!}</a></th>
                        <th><a href="{{ sortUrl('updated_at') }}" class="text-dark text-decoration-none">Terakhir Diupdate {!! sortIcon('updated_at') !!}</a></th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pelatih as $index => $item)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
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
                                <strong>{{ $item->nama }}</strong><br>
                                <small class="text-muted">{{ $item->cabor }}</small>
                            </td>
                            <td>
                                @if($item->tanggal_lahir)
                                    <strong>{{ \Carbon\Carbon::parse($item->tanggal_lahir)->format('d F Y') }}</strong>
                                    @if($item->tempat_lahir)
                                        <br>
                                        <span class="text-muted">{{ $item->tempat_lahir }}</span>
                                    @endif
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($item->alamat)
                                    @php
                                        $alamatParts = explode(' ', $item->alamat);
                                        $lastWord = array_pop($alamatParts);
                                        $restOfAddress = implode(' ', $alamatParts);
                                    @endphp

                                    <div class="d-flex flex-column">
                                        <strong><span class="fw-bold text-dark">{{ $lastWord }}</span></strong>
                                        <span class="text-muted small">{{ $restOfAddress }}</span>
                                    </div>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ $item->kelamin }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_lahir)->age }} Tahun</td>

                            <td>
                                @if($item->prestasis->isNotEmpty())
                                    @php $p = $item->prestasis->first(); @endphp
                                    <div class="d-flex flex-column">
                                        <span>{{ $p->nama_prestasi }}</span>
                                        <small class="text-muted">{{ $p->tahun }} • {{ $p->tempat }}</small>
                                    </div>
                                {{-- @else
                                    <span class="text-muted">-</span>
                                @endif --}}
                            </td>

                                <div class="d-flex flex-column">
                                    {{-- <span>{{ $firstAchievement }}</span> --}}
                                    {{-- @if($remainingCount > 0)
                                        <small class="text-muted">+{{ $remainingCount }} pencapaian lainnya</small>
                                    @endif --}}
                                </div>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                            <td>{{ $item->no_telepon }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->updated_at)->format('M d, Y') }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('admin.konfigurasi.pelatih.show', $item->id) }}"
                                    class="btn btn-icon btn-sm btn-light-primary"
                                    title="Detail">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>

                                    <a href="{{ route('admin.konfigurasi.pelatih.edit', $item->id) }}"
                                    class="btn btn-icon btn-sm btn-light-warning"
                                    title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>

                                    <form action="{{ route('admin.konfigurasi.pelatih.destroy', $item->id) }}"
                                        method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Yakin ingin menghapus pelatih ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-icon btn-sm btn-light-danger"
                                                title="Hapus">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <div class="modal fade" id="infoModal{{ $item->id }}" tabindex="-1" aria-labelledby="infoModalLabel{{ $item->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="infoModalLabel{{ $item->id }}">Detail Pelatih</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="text-center mb-3">
                                            @if ($item->foto)
                                                <img src="{{ Storage::url($item->foto) }}" width="100" height="100" class="rounded-circle object-fit-cover mb-2">
                                            @else
                                                <div class="rounded-circle bg-secondary text-white text-center fw-bold mx-auto" style="width: 100px; height: 100px; line-height: 100px; font-size: 2rem;">
                                                    {{ strtoupper(substr($item->nama, 0, 1)) }}
                                                </div>
                                            @endif
                                            <h4>{{ $item->nama }}</h4>
                                            <span class="badge bg-primary">{{ $item->cabor }}</span>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <p><strong>Email:</strong><br>{{ $item->email ?? '-' }}</p>
                                                <p><strong>Telepon:</strong><br>{{ $item->no_telepon ?? '-' }}</p>
                                                <p><strong>Jenis Kelamin:</strong><br>{{ $item->kelamin }}</p>
                                            </div>
                                            <div class="col-md-6">
                                                <p><strong>Tempat Lahir:</strong><br>{{ $item->tempat_lahir }}</p>
                                                <p><strong>Tanggal Lahir:</strong><br>{{ \Carbon\Carbon::parse($item->tanggal_lahir)->format('d F Y') }}</p>
                                                <p><strong>Usia:</strong><br>{{ \Carbon\Carbon::parse($item->tanggal_lahir)->age }} Tahun</p>
                                            </div>
                                        </div>

                                        <p><strong>Alamat:</strong><br>{{ $item->alamat }}</p>

                                        @if($item->prestasi)
                                        <p><strong>Prestasi:</strong><br>{{ $item->prestasi }}</p>
                                        @endif

                                        <p class="text-muted"><small>Terakhir diperbarui: {{ \Carbon\Carbon::parse($item->updated_at)->format('d F Y H:i') }}</small></p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="12" class="text-center py-5 text-muted">Data tidak ditemukan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="d-flex justify-content-between align-items-center mt-4">
                <div>
                    <form method="GET" class="d-flex align-items-center">
                        <span class="me-2">Show</span>
                        <select name="per_page" onchange="this.form.submit()" class="form-select form-select-sm w-auto">
                            @foreach ([10, 25, 50, 100] as $limit)
                                <option value="{{ $limit }}" {{ request('per_page') == $limit ? 'selected' : '' }}>
                                    {{ $limit }}
                                </option>
                            @endforeach
                        </select>
                        <span class="ms-2">per page</span>
                    </form>
                </div>

                <div class="d-flex align-items-center gap-3">
                    <div class="d-flex align-items-center">
                        <span class="me-2">Page</span>
                        <select class="form-select form-select-sm" style="width: 80px;"
                                onchange="window.location.href = this.value">
                            @for ($i = 1; $i <= $pelatih->lastPage(); $i++)
                                <option value="{{ $pelatih->url($i) }}"
                                        {{ $pelatih->currentPage() == $i ? 'selected' : '' }}>
                                    {{ $i }}
                                </option>
                            @endfor
                        </select>
                        <span class="ms-2">of {{ $pelatih->lastPage() }}</span>
                    </div>

                    <div class="btn-group">
                        <a href="{{ $pelatih->previousPageUrl() }}"
                        class="btn btn-outline-secondary {{ $pelatih->onFirstPage() ? 'disabled' : '' }}">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                        <a href="{{ $pelatih->nextPageUrl() }}"
                        class="btn btn-outline-secondary {{ !$pelatih->hasMorePages() ? 'disabled' : '' }}">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
