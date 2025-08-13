@extends('layouts.app')

@section('pageTitle', 'Detail File')
@section('mainSection', 'File Kesekretariat')
@section('currentSection', 'Detail File')

@section('content')
<div class="d-flex flex-column mb-8">
    <h1 class="text-dark fw-bold mb-1">Detail File</h1>
    <div class="text-muted fw-semibold fs-6">Informasi Lengkap Mengenai File Anda</div>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">
                    <i class="fas fa-file-alt me-2"></i>Informasi Dokumen
                </h4>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">Nama Dokumen</label>
                    {{-- Perbaikan: Menggunakan variabel $fileKesekretariat --}}
                    <p class="form-control-plaintext">{{ $fileKesekretariat->nama_dokumen }}</p>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">File Dokumen</label>
                    <p class="form-control-plaintext">
                        {{-- Perbaikan: Menggunakan jalur 'documents' --}}
                        <a href="{{ Storage::url('documents/' . $fileKesekretariat->dokumen_file) }}" target="_blank" class="text-decoration-none">
                            <i class="fas fa-file-pdf me-1"></i>
                            {{ $fileKesekretariat->dokumen_file }}
                        </a>
                    </p>
                </div>
                
                <hr>

                <div class="d-flex gap-2">
                    {{-- Perbaikan: Menggunakan variabel $fileKesekretariat --}}
                    <a href="{{ route('admin.file-kesekretariat.edit', $fileKesekretariat) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-1"></i>Edit
                    </a>
                    <a href="{{ route('admin.file-kesekretariat.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i>Kembali ke Daftar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
