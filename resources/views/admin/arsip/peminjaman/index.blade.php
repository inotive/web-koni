@extends('layouts.app')

@section('pageTitle', 'Peminjaman Arsip')
@section('mainSection', 'Manajemen Arsip')
@section('currentSection', 'Peminjaman Arsip')

@include('admin.arsip._assets')

@section('content')
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-6 gap-3">
        <div>
            <h1 class="mb-1">Peminjaman Arsip</h1>
            <span class="text-muted">Catat peminjaman dan pengembalian arsip</span>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#pinjamModal">
            <i class="fa-solid fa-plus"></i> Catat Peminjaman
        </button>
    </div>

    <div class="card arsip-card">
        <div class="card-body">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-5">
                <ul class="nav arsip-tabs">
                    <li class="nav-item">
                        <a class="nav-link {{ $tab === 'dipinjam' ? 'active' : '' }}" href="{{ route('admin.arsip.peminjaman.index', ['tab' => 'dipinjam']) }}">
                            Sedang Dipinjam <span class="badge badge-light-info ms-1">{{ $jumlah['dipinjam'] }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $tab === 'terlambat' ? 'active' : '' }}" href="{{ route('admin.arsip.peminjaman.index', ['tab' => 'terlambat']) }}">
                            Terlambat <span class="badge badge-light-danger ms-1">{{ $jumlah['terlambat'] }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $tab === 'riwayat' ? 'active' : '' }}" href="{{ route('admin.arsip.peminjaman.index', ['tab' => 'riwayat']) }}">
                            Riwayat
                        </a>
                    </li>
                </ul>
                <form method="GET" style="width: 280px">
                    <input type="hidden" name="tab" value="{{ $tab }}">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm"
                        placeholder="Cari peminjam / arsip, Enter...">
                </form>
            </div>

            <div class="table-responsive">
                <table class="table table-row-dashed arsip-table">
                    <thead>
                        <tr>
                            <th>Arsip</th>
                            <th>Peminjam</th>
                            <th>Tgl Pinjam</th>
                            <th>Rencana Kembali</th>
                            @if ($tab === 'riwayat')
                                <th>Dikembalikan</th>
                            @endif
                            <th>Petugas</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($peminjaman as $p)
                            <tr>
                                <td>
                                    @can('arsip-data')
                                        <a href="{{ route('admin.arsip.data.show', $p->arsip) }}" class="arsip-kode">{{ $p->arsip->nomor_arsip }}</a>
                                    @else
                                        <span class="arsip-kode">{{ $p->arsip->nomor_arsip }}</span>
                                    @endcan
                                    <div class="fs-7">{{ $p->arsip->judul }}</div>
                                    @if ($p->arsip->lokasi)
                                        <div class="text-muted fs-8">{{ $p->arsip->lokasi->kode_lengkap }}</div>
                                    @endif
                                </td>
                                <td>{{ $p->nama_peminjam }}<div class="text-muted fs-7">{{ $p->unit_peminjam }}</div></td>
                                <td class="text-nowrap">{{ $p->tanggal_pinjam->format('d/m/Y') }}</td>
                                <td class="text-nowrap">
                                    {{ $p->tanggal_rencana_kembali->format('d/m/Y') }}
                                    @if ($p->is_terlambat)
                                        <div class="badge badge-light-danger">
                                            Terlambat {{ (int) $p->tanggal_rencana_kembali->diffInDays(today()) }} hari
                                        </div>
                                    @endif
                                </td>
                                @if ($tab === 'riwayat')
                                    <td class="text-nowrap">{{ $p->tanggal_kembali?->format('d/m/Y') }}</td>
                                @endif
                                <td>{{ $p->petugas?->username ?? '-' }}</td>
                                <td class="text-end">
                                    @if ($p->status === 'dipinjam')
                                        <button class="btn btn-sm btn-light-success"
                                            onclick="openKembali('{{ route('admin.arsip.peminjaman.kembali', $p) }}', '{{ $p->arsip->nomor_arsip }}', '{{ $p->tanggal_pinjam->format('Y-m-d') }}')">
                                            <i class="fa-solid fa-rotate-left"></i> Kembalikan
                                        </button>
                                    @elseif ($p->catatan)
                                        <i class="fa-solid fa-note-sticky text-gray-500" title="{{ $p->catatan }}"></i>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-10">Tidak ada data.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $peminjaman->links('pagination::bootstrap-5') }}
        </div>
    </div>

    @include('admin.arsip.peminjaman._modal-pinjam')

    <div class="modal fade" id="kembaliModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form class="modal-content" method="POST" id="kembaliForm">
                @csrf @method('PATCH')
                <div class="modal-header">
                    <h3 class="modal-title">Pengembalian <span id="kembaliNomor"></span></h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body d-grid gap-4">
                    <div>
                        <label class="form-label required">Tanggal Kembali</label>
                        <input type="date" name="tanggal_kembali" id="tanggalKembali" class="form-control" required
                            value="{{ today()->format('Y-m-d') }}">
                    </div>
                    <div>
                        <label class="form-label">Catatan Kondisi</label>
                        <textarea name="catatan" class="form-control" rows="2" placeholder="mis. Lengkap, kondisi baik"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan Pengembalian</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function openKembali(action, nomor, tanggalPinjam) {
            document.getElementById('kembaliForm').action = action;
            document.getElementById('kembaliNomor').textContent = nomor;
            document.getElementById('tanggalKembali').min = tanggalPinjam;
            new bootstrap.Modal(document.getElementById('kembaliModal')).show();
        }

        @if ($errors->any() && old('nama_peminjam') !== null)
            new bootstrap.Modal(document.getElementById('pinjamModal')).show();
        @endif
    </script>
@endsection
