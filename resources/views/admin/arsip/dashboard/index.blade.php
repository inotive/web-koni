@extends('layouts.app')

@section('pageTitle', 'Dashboard Arsip')
@section('mainSection', 'Manajemen Arsip')
@section('currentSection', 'Dashboard Arsip')

@include('admin.arsip._assets')

@php
    $statusCards = [
        ['label' => 'Total Arsip', 'value' => $total, 'icon' => 'fa-box-archive', 'color' => 'primary'],
        ['label' => 'Aktif', 'value' => $perStatus['aktif'] ?? 0, 'icon' => 'fa-folder-open', 'color' => 'success'],
        ['label' => 'Inaktif', 'value' => $perStatus['inaktif'] ?? 0, 'icon' => 'fa-folder-closed', 'color' => 'warning'],
        ['label' => 'Dipinjam', 'value' => $perStatus['dipinjam'] ?? 0, 'icon' => 'fa-hand-holding', 'color' => 'info'],
    ];
@endphp

@section('content')
    <div class="mb-6">
        <h1 class="mb-1">Dashboard Arsip</h1>
        <span class="text-muted">Ringkasan kondisi arsip, kapasitas penyimpanan, dan hal yang perlu ditindaklanjuti</span>
    </div>

    <div class="row g-5 mb-6">
        @foreach ($statusCards as $card)
            <div class="col-6 col-lg-3">
                <div class="arsip-stat d-flex align-items-center gap-4">
                    <div class="stat-icon bg-light-{{ $card['color'] }} text-{{ $card['color'] }}">
                        <i class="fa-solid {{ $card['icon'] }}"></i>
                    </div>
                    <div>
                        <div class="fs-2 fw-bold">{{ number_format($card['value']) }}</div>
                        <div class="text-muted fs-7">{{ $card['label'] }}</div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @if ($jumlahTerlambat || $jumlahJatuhTempoInaktif || $jumlahJatuhTempoRetensi)
        <div class="row g-5 mb-6">
            @if ($jumlahTerlambat)
                <div class="col-md-4">
                    <a href="{{ route('admin.arsip.peminjaman.index', ['tab' => 'terlambat']) }}" class="alert alert-light-danger d-flex align-items-center gap-3 mb-0 h-100">
                        <i class="fa-solid fa-clock fs-2 text-danger"></i>
                        <div><b>{{ $jumlahTerlambat }}</b> peminjaman melewati batas waktu pengembalian</div>
                    </a>
                </div>
            @endif
            @if ($jumlahJatuhTempoInaktif)
                <div class="col-md-4">
                    <a href="{{ route('admin.arsip.retensi.index', ['tab' => 'inaktif']) }}" class="alert alert-light-warning d-flex align-items-center gap-3 mb-0 h-100">
                        <i class="fa-solid fa-box fs-2 text-warning"></i>
                        <div><b>{{ $jumlahJatuhTempoInaktif }}</b> arsip aktif sudah waktunya menjadi inaktif</div>
                    </a>
                </div>
            @endif
            @if ($jumlahJatuhTempoRetensi)
                <div class="col-md-4">
                    <a href="{{ route('admin.arsip.retensi.index', ['tab' => 'retensi']) }}" class="alert alert-light-primary d-flex align-items-center gap-3 mb-0 h-100">
                        <i class="fa-solid fa-file-signature fs-2 text-primary"></i>
                        <div><b>{{ $jumlahJatuhTempoRetensi }}</b> arsip habis masa retensi dan perlu ditindaklanjuti</div>
                    </a>
                </div>
            @endif
        </div>
    @endif

    <div class="row g-6">
        <div class="col-lg-6">
            <div class="card arsip-card h-100">
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title fw-bold">Keterisian Box</h3>
                    <div class="card-toolbar text-muted fs-7">
                        {{ $jumlahLokasi['box'] ?? 0 }} box · {{ $jumlahLokasi['rak'] ?? 0 }} rak · {{ $jumlahLokasi['ruang'] ?? 0 }} ruang
                    </div>
                </div>
                <div class="card-body pt-0">
                    @forelse ($box as $b)
                        <div class="mb-4">
                            <div class="d-flex justify-content-between fs-7 mb-1">
                                <a href="{{ route('admin.arsip.lokasi.index', ['id' => $b->id]) }}" class="text-gray-800 text-hover-primary">
                                    <span class="arsip-kode">{{ $b->kode_lengkap }}</span> {{ $b->nama }}
                                </a>
                                <span class="text-muted">{{ $b->terisi }} / {{ $b->kapasitas }}</span>
                            </div>
                            <div class="progress h-6px">
                                <div class="progress-bar {{ $b->persen >= 90 ? 'bg-danger' : ($b->persen >= 70 ? 'bg-warning' : 'bg-success') }}"
                                    style="width: {{ $b->persen }}%"></div>
                            </div>
                        </div>
                    @empty
                        <div class="text-muted">Belum ada box dengan kapasitas yang ditentukan.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card arsip-card h-100">
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title fw-bold">Arsip per Klasifikasi</h3>
                </div>
                <div class="card-body pt-0">
                    @php $maxKategori = max(1, $perKategori->max('arsip_count') ?? 1); @endphp
                    @forelse ($perKategori as $k)
                        <div class="mb-4">
                            <div class="d-flex justify-content-between fs-7 mb-1">
                                <span><span class="arsip-kode">{{ $k->kode_klasifikasi }}</span> {{ $k->nama }}</span>
                                <span class="fw-semibold">{{ $k->arsip_count }}</span>
                            </div>
                            <div class="progress h-6px">
                                <div class="progress-bar bg-primary" style="width: {{ round($k->arsip_count / $maxKategori * 100) }}%"></div>
                            </div>
                        </div>
                    @empty
                        <div class="text-muted">Belum ada arsip yang tersimpan.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card arsip-card h-100">
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title fw-bold">Peminjaman Terlambat</h3>
                </div>
                <div class="card-body pt-0">
                    @forelse ($terlambat as $p)
                        <div class="d-flex justify-content-between border-bottom border-dashed py-3">
                            <div>
                                <span class="arsip-kode">{{ $p->arsip->nomor_arsip }}</span>
                                <div class="fs-7">{{ $p->nama_peminjam }} · {{ $p->unit_peminjam }}</div>
                            </div>
                            <span class="badge badge-light-danger align-self-center">
                                {{ (int) $p->tanggal_rencana_kembali->diffInDays(today()) }} hari
                            </span>
                        </div>
                    @empty
                        <div class="text-muted">Tidak ada peminjaman yang terlambat.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card arsip-card h-100">
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title fw-bold">Arsip Terbaru</h3>
                </div>
                <div class="card-body pt-0">
                    @forelse ($terbaru as $a)
                        <div class="d-flex justify-content-between border-bottom border-dashed py-3 gap-3">
                            <div>
                                @can('arsip-data')
                                    <a href="{{ route('admin.arsip.data.show', $a) }}" class="arsip-kode">{{ $a->nomor_arsip }}</a>
                                @else
                                    <span class="arsip-kode">{{ $a->nomor_arsip }}</span>
                                @endcan
                                <div class="fs-7">{{ $a->judul }}</div>
                            </div>
                            <span class="text-muted fs-7 text-nowrap">{{ $a->created_at->diffForHumans() }}</span>
                        </div>
                    @empty
                        <div class="text-muted">Belum ada arsip.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
