@extends('layouts.app')

@section('pageTitle', 'Detail Arsip')
@section('mainSection', 'Manajemen Arsip')
@section('mainSectionUrl', route('admin.arsip.data.index'))
@section('currentSection', $arsip->nomor_arsip)

@include('admin.arsip._assets')

@php $bisaDiubah = in_array($arsip->status, ['aktif', 'inaktif']); @endphp

@section('content')
    <div class="d-flex flex-wrap justify-content-between align-items-start mb-6 gap-3">
        <div>
            <span class="arsip-kode fs-6">{{ $arsip->nomor_arsip }}</span>
            <span class="badge {{ $arsip->status_badge }} ms-1">{{ $arsip->status_label }}</span>
            <h1 class="mt-2 mb-0">{{ $arsip->judul }}</h1>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('admin.arsip.data.index') }}" class="btn btn-light"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
            <a href="{{ route('admin.arsip.data.label', $arsip) }}" target="_blank" class="btn btn-light">
                <i class="fa-solid fa-qrcode"></i> Cetak Label
            </a>
            @if ($bisaDiubah)
                @if ($arsip->media !== 'digital')
                    <button class="btn btn-light-primary" data-bs-toggle="modal" data-bs-target="#pindahModal">
                        <i class="fa-solid fa-right-left"></i> Pindah Lokasi
                    </button>
                @endif
                @can('arsip-peminjaman')
                    <button class="btn btn-light-info" data-bs-toggle="modal" data-bs-target="#pinjamModal">
                        <i class="fa-solid fa-hand-holding"></i> Pinjamkan
                    </button>
                @endcan
                <a href="{{ route('admin.arsip.data.edit', $arsip) }}" class="btn btn-light"><i class="fa-solid fa-pen"></i> Ubah</a>
            @endif
            @if ($arsip->status !== 'dipinjam' && !$arsip->arsip_pemusnahan_id)
                <form action="{{ route('admin.arsip.data.destroy', $arsip) }}" method="POST"
                    data-confirm="Hapus arsip {{ $arsip->nomor_arsip }}? Riwayat mutasi & peminjaman ikut terhapus.">
                    @csrf @method('DELETE')
                    <button class="btn btn-light-danger"><i class="fa-solid fa-trash"></i></button>
                </form>
            @endif
        </div>
    </div>

    <div class="row g-6">
        <div class="col-lg-8">
            <div class="card arsip-card mb-6">
                <div class="card-body">
                    <div class="row g-5">
                        @php
                            $info = [
                                'Klasifikasi' => $arsip->kategori ? "{$arsip->kategori->kode_klasifikasi} - {$arsip->kategori->nama}" : '-',
                                'Tanggal Arsip' => $arsip->tanggal_arsip->translatedFormat('d F Y'),
                                'Jumlah' => "{$arsip->jumlah} {$arsip->satuan}",
                                'Media' => \App\Models\Arsip\Arsip::MEDIA[$arsip->media],
                                'Tingkat Perkembangan' => \App\Models\Arsip\Arsip::TINGKAT[$arsip->tingkat_perkembangan],
                                'Dicatat oleh' => ($arsip->pembuat?->username ?? '-') . ' · ' . $arsip->created_at->format('d/m/Y H:i'),
                            ];
                        @endphp
                        @foreach ($info as $label => $value)
                            <div class="col-sm-6">
                                <div class="text-muted fs-7">{{ $label }}</div>
                                <div class="fw-semibold">{{ $value }}</div>
                            </div>
                        @endforeach
                        @if ($arsip->uraian)
                            <div class="col-12">
                                <div class="text-muted fs-7">Uraian</div>
                                <div style="white-space: pre-line">{{ $arsip->uraian }}</div>
                            </div>
                        @endif
                        @if ($arsip->keterangan)
                            <div class="col-12">
                                <div class="text-muted fs-7">Keterangan</div>
                                <div style="white-space: pre-line">{{ $arsip->keterangan }}</div>
                            </div>
                        @endif
                        @if ($arsip->sumber_label)
                            <div class="col-12">
                                <div class="text-muted fs-7">Ditautkan ke</div>
                                <div class="fw-semibold"><i class="fa-solid fa-link text-gray-500"></i> {{ $arsip->sumber_label }}</div>
                            </div>
                        @endif
                        @if ($arsip->pemusnahan)
                            <div class="col-12">
                                <div class="alert alert-light-danger mb-0">
                                    {{ \App\Models\Arsip\ArsipPemusnahan::JENIS[$arsip->pemusnahan->jenis] }} berdasarkan berita acara
                                    <b>{{ $arsip->pemusnahan->nomor_berita_acara }}</b> tanggal {{ $arsip->pemusnahan->tanggal->format('d/m/Y') }}.
                                    @can('arsip-retensi')
                                        <a href="{{ route('admin.arsip.retensi.berita-acara', $arsip->pemusnahan) }}" target="_blank">Lihat</a>
                                    @endcan
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="card arsip-card mb-6">
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title fw-bold">Riwayat Lokasi</h3>
                </div>
                <div class="card-body pt-0">
                    @forelse ($arsip->mutasi as $m)
                        <div class="d-flex gap-3 mb-4">
                            <i class="fa-solid fa-circle-dot text-success mt-1"></i>
                            <div>
                                <div>
                                    @if ($m->lokasiAsal)
                                        <span class="arsip-kode">{{ $m->lokasiAsal->kode_lengkap }}</span>
                                        <i class="fa-solid fa-arrow-right mx-1 text-gray-500"></i>
                                    @endif
                                    <span class="arsip-kode">{{ $m->lokasiTujuan?->kode_lengkap ?? 'tanpa lokasi' }}</span>
                                </div>
                                <div class="text-muted fs-7">
                                    {{ $m->created_at->format('d/m/Y H:i') }} · {{ $m->user?->username ?? '-' }}
                                    @if ($m->alasan)
                                        · {{ $m->alasan }}
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-muted">Belum ada riwayat perpindahan.</div>
                    @endforelse
                </div>
            </div>

            <div class="card arsip-card">
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title fw-bold">Riwayat Peminjaman</h3>
                </div>
                <div class="card-body pt-0">
                    @if ($arsip->peminjaman->isEmpty())
                        <div class="text-muted">Arsip ini belum pernah dipinjam.</div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-row-dashed arsip-table">
                                <thead>
                                    <tr>
                                        <th>Peminjam</th>
                                        <th>Tgl Pinjam</th>
                                        <th>Rencana Kembali</th>
                                        <th>Dikembalikan</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($arsip->peminjaman as $p)
                                        <tr>
                                            <td>{{ $p->nama_peminjam }}<div class="text-muted fs-7">{{ $p->unit_peminjam }}</div></td>
                                            <td>{{ $p->tanggal_pinjam->format('d/m/Y') }}</td>
                                            <td>{{ $p->tanggal_rencana_kembali->format('d/m/Y') }}</td>
                                            <td>{{ $p->tanggal_kembali?->format('d/m/Y') ?? '-' }}</td>
                                            <td>
                                                @if ($p->is_terlambat)
                                                    <span class="badge badge-light-danger">Terlambat</span>
                                                @elseif ($p->status === 'dipinjam')
                                                    <span class="badge badge-light-info">Dipinjam</span>
                                                @else
                                                    <span class="badge badge-light-success">Dikembalikan</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card arsip-card mb-6">
                <div class="card-body text-center">
                    <img src="{{ $qr }}" alt="QR" style="width: 140px; height: 140px">
                    <div class="text-muted fs-7 mt-2">Pindai untuk membuka halaman arsip ini</div>
                </div>
            </div>

            <div class="card arsip-card mb-6">
                <div class="card-body">
                    <div class="text-muted fs-7 mb-1">Lokasi Penyimpanan</div>
                    @if ($arsip->lokasi)
                        <div class="arsip-kode d-inline-block mb-2">{{ $arsip->lokasi->kode_lengkap }}</div>
                        <div class="fw-semibold">{{ $arsip->lokasi->path }}</div>
                        @can('arsip-lokasi')
                            <a href="{{ route('admin.arsip.lokasi.index', ['id' => $arsip->arsip_lokasi_id]) }}" class="fs-7">Lihat lokasi</a>
                        @endcan
                    @else
                        <div class="text-muted">Tidak ada (arsip digital)</div>
                    @endif
                </div>
            </div>

            @if ($arsip->file_path)
                <div class="card arsip-card mb-6">
                    <div class="card-body">
                        <div class="text-muted fs-7 mb-2">File Digital</div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.arsip.data.file', $arsip) }}" target="_blank" class="btn btn-sm btn-light-primary">
                                <i class="fa-solid fa-eye"></i> Lihat
                            </a>
                            <a href="{{ route('admin.arsip.data.file', [$arsip, 'download' => 1]) }}" class="btn btn-sm btn-light">
                                <i class="fa-solid fa-download"></i> Unduh
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            @if ($arsip->kategori)
                <div class="card arsip-card">
                    <div class="card-body">
                        <div class="text-muted fs-7 mb-2">Jadwal Retensi</div>
                        <div class="d-flex justify-content-between mb-1">
                            <span>Aktif s.d.</span>
                            <span class="fw-semibold {{ $arsip->jatuh_tempo_inaktif->isPast() ? 'text-warning' : '' }}">
                                {{ $arsip->jatuh_tempo_inaktif->format('d/m/Y') }}
                            </span>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <span>Inaktif s.d.</span>
                            <span class="fw-semibold {{ $arsip->jatuh_tempo_retensi->isPast() ? 'text-danger' : '' }}">
                                {{ $arsip->jatuh_tempo_retensi->format('d/m/Y') }}
                            </span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Tindakan akhir</span>
                            <span class="fw-semibold">{{ $arsip->kategori->tindakan_akhir_label }}</span>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @if ($bisaDiubah)
        <div class="modal fade" id="pindahModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <form class="modal-content" method="POST" action="{{ route('admin.arsip.data.pindah', $arsip) }}">
                    @csrf
                    <div class="modal-header">
                        <h3 class="modal-title">Pindah Lokasi Arsip</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body d-grid gap-4">
                        <div>
                            <label class="form-label required">Lokasi Tujuan</label>
                            <select name="arsip_lokasi_id" class="form-select" required>
                                <option value="">— Pilih lokasi —</option>
                                @foreach ($lokasiOptions as $opt)
                                    <option value="{{ $opt['id'] }}" @disabled($opt['id'] == $arsip->arsip_lokasi_id)>{{ $opt['label'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="form-label">Alasan</label>
                            <input type="text" name="alasan" class="form-control" maxlength="255" placeholder="mis. Penataan ulang rak">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Pindahkan</button>
                    </div>
                </form>
            </div>
        </div>

        @can('arsip-peminjaman')
            @include('admin.arsip.peminjaman._modal-pinjam', ['arsipTerpilih' => $arsip])
        @endcan
    @endif
@endsection
