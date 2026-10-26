@extends('layouts.app')

@section('pageTitle', 'Template Surat')
@section('mainSection', 'Surat Masuk & Keluar')
@section('currentSection', 'Template Surat')

@include('admin.arsip._assets')

@section('content')
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-6 gap-3">
        <div>
            <h1 class="mb-1">Template Surat</h1>
            <span class="text-muted">Template yang bisa dipilih saat membuat surat keluar</span>
        </div>
        <div class="d-flex gap-2">
            @can('surat-penomoran')
                <a href="{{ route('admin.surat-penomoran.index') }}" class="btn btn-light">
                    <i class="fa-solid fa-hashtag"></i> Pengaturan Penomoran
                </a>
            @endcan
            <a href="{{ route('admin.surat-template.create') }}" class="btn btn-primary">
                <i class="fa-solid fa-plus"></i> Tambah Template
            </a>
        </div>
    </div>

    <div class="card arsip-card">
        <div class="card-body">
            <form method="GET" class="mb-5" style="max-width: 320px">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm"
                    placeholder="Cari nama / kode, tekan Enter...">
            </form>

            <div class="table-responsive">
                <table class="table table-row-dashed arsip-table">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Nama Template</th>
                            <th>Penomoran</th>
                            <th class="text-center">Isian</th>
                            <th class="text-center">Dipakai</th>
                            <th class="text-center">Status</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($templates as $item)
                            <tr>
                                <td><span class="arsip-kode">{{ $item->kode }}</span></td>
                                <td>
                                    <div class="fw-semibold">{{ $item->nama }}</div>
                                    @if ($item->keterangan)
                                        <div class="text-muted fs-7">{{ $item->keterangan }}</div>
                                    @endif
                                </td>
                                <td>
                                    @if ($item->penomoran)
                                        {{ $item->penomoran->nama }}
                                    @else
                                        <span class="text-muted">Default surat keluar</span>
                                    @endif
                                </td>
                                <td class="text-center">{{ count($item->field_list) }}</td>
                                <td class="text-center">{{ $item->surat_count }} surat</td>
                                <td class="text-center">
                                    <span class="badge {{ $item->is_active ? 'badge-light-success' : 'badge-light' }}">
                                        {{ $item->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>
                                <td class="text-end text-nowrap">
                                    @if ($item->is_active)
                                        <a href="{{ route('admin.surat.template.create', ['template' => $item->id]) }}"
                                            class="btn btn-sm btn-light-primary" title="Buat surat dari template ini">
                                            <i class="fa-solid fa-file-signature"></i> Buat Surat
                                        </a>
                                    @endif
                                    <a href="{{ route('admin.surat-template.edit', $item) }}" class="btn btn-sm btn-icon btn-light" title="Ubah">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <form action="{{ route('admin.surat-template.destroy', $item) }}" method="POST" class="d-inline"
                                        data-confirm="Hapus template {{ $item->nama }}?">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-icon btn-light-danger" title="Hapus"><i class="fa-solid fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-10">Belum ada template surat.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $templates->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection
