@extends('layouts.app')

@section('title', 'Edit File Kesekretariat')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">
                    <i class="fas fa-edit me-2"></i>Edit File Kesekretariat
                </h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.file-kesekretariat.update', $fileKesekretariat) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="nama_dokumen" class="form-label">Nama Dokumen</label>
                        <input type="text" 
                               class="form-control @error('nama_dokumen') is-invalid @enderror" 
                               id="nama_dokumen" 
                               name="nama_dokumen" 
                               value="{{ old('nama_dokumen', $fileKesekretariat->nama_dokumen) }}" 
                               placeholder="Masukkan nama dokumen"
                               required>
                        @error('nama_dokumen')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="dokumen_file" class="form-label">File Dokumen</label>
                        <input type="file" 
                               class="form-control @error('dokumen_file') is-invalid @enderror" 
                               id="dokumen_file" 
                               name="dokumen_file" 
                               accept=".pdf,.doc,.docx,.xls,.xlsx">
                        <div class="form-text">
                            File saat ini: <strong>{{ $fileKesekretariat->dokumen_file }}</strong><br>
                            Kosongkan jika tidak ingin mengubah file. Format yang diizinkan: PDF, DOC, DOCX, XLS, XLSX. Maksimal 2MB.
                        </div>
                        @error('dokumen_file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save me-1"></i>Update
                        </button>
                        <a href="{{ route('admin.file-kesekretariat.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i>Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection