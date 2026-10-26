@extends('layouts.app')

@section('pageTitle', 'Data Arsip')
@section('mainSection', 'Manajemen Arsip')
@section('currentSection', 'Data Arsip')

@include('admin.arsip._assets')

@section('content')
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-6 gap-3">
        <div>
            <h1 class="mb-1">Data Arsip</h1>
            <span class="text-muted">Daftar seluruh arsip beserta klasifikasi dan lokasi penyimpanannya</span>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.arsip.data.export', request()->query()) }}" class="btn btn-light">
                <i class="fa-solid fa-file-csv"></i> Export CSV
            </a>
            <a href="{{ route('admin.arsip.data.create') }}" class="btn btn-primary">
                <i class="fa-solid fa-plus"></i> Tambah Arsip
            </a>
        </div>
    </div>

    <div class="card arsip-card">
        <div class="card-body">
            <form method="GET" class="row g-3 mb-6" id="filterForm">
                <div class="col-md-4">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm"
                        placeholder="Cari nomor, judul, uraian...">
                </div>
                <div class="col-md-2">
                    <select name="kategori" class="form-select form-select-sm auto-submit">
                        <option value="">Semua klasifikasi</option>
                        @foreach ($kategoriList as $k)
                            <option value="{{ $k->id }}" @selected(request('kategori') == $k->id)>{{ $k->kode_klasifikasi }} - {{ $k->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="lokasi" class="form-select form-select-sm auto-submit">
                        <option value="">Semua lokasi</option>
                        @foreach ($lokasiOptions as $opt)
                            <option value="{{ $opt['id'] }}" @selected(request('lokasi') == $opt['id'])>{{ $opt['label'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-1">
                    <select name="tahun" class="form-select form-select-sm auto-submit">
                        <option value="">Tahun</option>
                        @foreach ($tahunList as $tahun)
                            <option value="{{ $tahun }}" @selected(request('tahun') == $tahun)>{{ $tahun }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select form-select-sm auto-submit">
                        <option value="">Semua status</option>
                        @foreach (\App\Models\Arsip\Arsip::STATUS as $value => $label)
                            <option value="{{ $value }}" @selected(request('status') == $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-1">
                    @if (request()->hasAny(['search', 'kategori', 'lokasi', 'tahun', 'status', 'media']))
                        <a href="{{ route('admin.arsip.data.index') }}" class="btn btn-sm btn-light w-100">Reset</a>
                    @endif
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-row-dashed arsip-table">
                    <thead>
                        <tr>
                            <th>Nomor</th>
                            <th>Judul</th>
                            <th>Klasifikasi</th>
                            <th>Tanggal</th>
                            <th>Lokasi</th>
                            <th>Media</th>
                            <th>Status</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($arsip as $item)
                            <tr>
                                <td><a href="{{ route('admin.arsip.data.show', $item) }}" class="arsip-kode">{{ $item->nomor_arsip }}</a></td>
                                <td>
                                    <a href="{{ route('admin.arsip.data.show', $item) }}" class="text-gray-800 text-hover-primary fw-semibold">{{ $item->judul }}</a>
                                    <div class="text-muted fs-7">{{ $item->jumlah }} {{ $item->satuan }}</div>
                                </td>
                                <td>{{ $item->kategori?->kode_klasifikasi ?? '-' }}</td>
                                <td class="text-nowrap">{{ $item->tanggal_arsip->format('d/m/Y') }}</td>
                                <td>
                                    @if ($item->lokasi)
                                        <span class="arsip-kode" title="{{ $item->lokasi->path }}">{{ $item->lokasi->kode_lengkap }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    {{ \App\Models\Arsip\Arsip::MEDIA[$item->media] }}
                                    @if ($item->file_path)
                                        <i class="fa-solid fa-paperclip text-gray-500" title="Ada file digital"></i>
                                    @endif
                                </td>
                                <td><span class="badge {{ $item->status_badge }}">{{ $item->status_label }}</span></td>
                                <td class="text-end text-nowrap">
                                    <a href="{{ route('admin.arsip.data.show', $item) }}" class="btn btn-sm btn-icon btn-light" title="Detail">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    @if (in_array($item->status, ['aktif', 'inaktif']))
                                        <a href="{{ route('admin.arsip.data.edit', $item) }}" class="btn btn-sm btn-icon btn-light" title="Ubah">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-10">Tidak ada arsip yang cocok.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex flex-wrap justify-content-between align-items-center">
                <span class="text-muted fs-7">Total {{ $arsip->total() }} arsip</span>
                {{ $arsip->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.querySelectorAll('#filterForm .auto-submit').forEach(el => {
            el.addEventListener('change', () => document.getElementById('filterForm').submit());
        });
    </script>
@endsection
