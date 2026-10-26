@extends('layouts.app')

@section('pageTitle', 'Kop Surat')
@section('mainSection', 'Surat Masuk & Keluar')
@section('currentSection', 'Kop Surat')

@include('admin.arsip._assets')

@push('stack-css')
    <style>
        .kop-preview {
            background: #fff;
            border: 1px solid #eef0f3;
            border-radius: 8px;
            padding: 12px 16px;
            font-family: "Times New Roman", Times, serif;
            color: #000;
            overflow: hidden;
        }
    </style>
@endpush

@section('content')
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-6 gap-3">
        <div>
            <h1 class="mb-1">Kop Surat</h1>
            <span class="text-muted">Kop yang dipakai template surat. Template tanpa pilihan kop memakai kop default.</span>
        </div>
        <a href="{{ route('admin.surat-kop.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i> Tambah Kop
        </a>
    </div>

    <div class="row g-6">
        @forelse ($kops as $item)
            <div class="col-xl-6">
                <div class="card arsip-card h-100 {{ $item->is_active ? '' : 'opacity-50' }}">
                    <div class="card-body d-flex flex-column gap-4">
                        <div class="d-flex justify-content-between align-items-start gap-3">
                            <div>
                                <div class="fw-bold fs-5">
                                    {{ $item->nama }}
                                    @if ($item->is_default)
                                        <span class="badge badge-light-success ms-1">Default</span>
                                    @endif
                                    @unless ($item->is_active)
                                        <span class="badge badge-light ms-1">Nonaktif</span>
                                    @endunless
                                </div>
                                <div class="text-muted fs-7">
                                    {{ \App\Models\SuratKop::JENIS[$item->jenis] }} · dipakai {{ $item->templates_count }} template
                                </div>
                            </div>
                            <div class="text-nowrap">
                                <a href="{{ route('admin.surat-kop.show', $item) }}" target="_blank" class="btn btn-sm btn-icon btn-light-primary" title="Preview PDF">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.surat-kop.edit', $item) }}" class="btn btn-sm btn-icon btn-light" title="Ubah">
                                    <i class="fa-solid fa-pen"></i>
                                </a>
                                <form action="{{ route('admin.surat-kop.destroy', $item) }}" method="POST" class="d-inline"
                                    data-confirm="Hapus kop {{ $item->nama }}?">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-icon btn-light-danger" title="Hapus"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </div>
                        </div>
                        <div class="kop-preview">
                            @include('admin.surat-kop._kop', ['kop' => $item->view])
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card arsip-card">
                    <div class="card-body text-center text-muted py-10">Belum ada kop surat.</div>
                </div>
            </div>
        @endforelse
    </div>
@endsection
