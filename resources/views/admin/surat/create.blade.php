@extends('layouts.app')
@section('pageTitle', 'Tambah Data Surat')
@section('mainSection', 'Menu Utama')
@section('subSection', 'Surat Masuk & Keluar')
@section('subSectionUrl', route('admin.surat.index'))
@section('currentSection', 'Tambah Data Surat')

@section('content')

    <style>
    body {
        background-color: #f5f5f5 !important;
    }

    .main-content {
        background-color: #f5f5f5;
        min-height: 100vh;
        padding: 20px 10px 40px;
    }

    .card-form {
        background-color: white;
        border-radius: 12px;
        border: 1px solid #e9ecef;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
    }

    .section-header {
        color: #0b153a;
        font-weight: 700;
        font-size: 1.6rem;
        margin-bottom: 1rem;
    }

    .file-upload-wrapper {
        display: flex;
        align-items: center;
        gap: 12px;
        border: 1px solid #cfe2ff;
        background-color: #edf5ff;
        border-radius: 10px;
        padding: 16px 20px;
        cursor: pointer;
        transition: all 0.2s ease-in-out;
    }

    .file-upload-wrapper:hover {
        border-color: #0d6efd;
        background-color: #e6f0ff;
    }

    .file-upload-wrapper input[type="file"] {
        display: none;
    }

    .file-upload-icon-wrapper {
        background-color: #d0e7ff;
        padding: 8px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .file-upload-icon {
        font-size: 1.5rem;
        color: #0d6efd;
    }

    .file-upload-text {
        margin: 0;
        font-size: 0.95rem;
        font-weight: 500;
        color: #0b153a;
    }

    .file-upload-hint {
        font-size: 0.8rem;
        color: #6c757d;
        margin-top: 4px;
    }

    .form-control, .form-select {
        border-radius: 8px;
        padding: 10px 14px;
        font-size: 0.95rem;
    }

    .form-control:focus, .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.2);
    }

    .invalid-feedback {
        font-size: 0.85rem;
        color: #e74c3c;
    }

    .btn-danger {
        background: linear-gradient(135deg, #F8285A 0%, #e91e63 100%);
        border: none;
        border-radius: 8px;
        padding: 12px 24px;
        font-weight: 600;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(248, 40, 90, 0.3);
    }

    .btn-danger:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(248, 40, 90, 0.4);
    }

    .file-preview-container {
        margin-top: 12px;
        padding: 12px;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        background-color: #f8f9fa;
    }

    .file-preview-item {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .file-preview-icon {
        color: #dc3545;
        font-size: 1.2rem;
    }

    .file-preview-name {
        font-size: 0.9rem;
        color: #495057;
        margin: 0;
    }

    .file-preview-size {
        font-size: 0.8rem;
        color: #6c757d;
        margin: 0;
    }
</style>

    <div class="d-flex justify-content-between align-items-center flex-wrap mb-4" style="padding: 20px 20px">
        <h3 class="fw-bold fs-2 mb-0 text-dark">Tambah Surat</h3>
    </div>

<div class="main-content">
    <div class="container-fluid">
        <div class="row">
            <div class="card card-form">
                <div class="card-body p-4 p-md-5">
                    <h3 class="fw-bold mb-4">Tambah Data Surat</h3>

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.surat.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Nama Kegiatan --}}
                        <div class="row align-items-center mb-3">
                            <div class="col-md-3">
                                <label for="nama_kegiatan" class="form-label">Nama Kegiatan <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" name="nama_kegiatan" id="nama_kegiatan"
                                    class="form-control @error('nama_kegiatan') is-invalid @enderror"
                                    placeholder="Contoh: Rapat Koordinasi Bulanan"
                                    value="{{ old('nama_kegiatan') }}" required>
                                @error('nama_kegiatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- No Surat --}}
                        <div class="row align-items-center mb-3">
                            <div class="col-md-3">
                                <label for="no_surat" class="form-label">Nomor Surat <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" name="no_surat" id="no_surat"
                                    class="form-control @error('no_surat') is-invalid @enderror"
                                    placeholder="Contoh: 001/SM/I/2025"
                                    value="{{ old('no_surat') }}" required>
                                @error('no_surat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Jenis Surat --}}
                        <div class="row align-items-center mb-3">
                            <div class="col-md-3">
                                <label for="jenis_surat" class="form-label">Jenis Surat <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-9">
                                <select name="jenis_surat" id="jenis_surat"
                                    class="form-select @error('jenis_surat') is-invalid @enderror" required>
                                    <option value="">Pilih Jenis Surat</option>
                                    <option value="masuk" {{ old('jenis_surat') == 'masuk' ? 'selected' : '' }}>Surat Masuk</option>
                                    <option value="keluar" {{ old('jenis_surat') == 'keluar' ? 'selected' : '' }}>Surat Keluar</option>
                                </select>
                                @error('jenis_surat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Dokumen Surat --}}
                        <div class="row align-items-start mb-4">
                            <div class="col-md-3">
                                <label for="dokumen_surat" class="form-label">Dokumen Surat</label>
                                <p class="file-upload-hint">PDF, DOC, DOCX (Max: 10MB)</p>
                            </div>
                            <div class="col-md-9">
                                <label for="dokumen_surat" class="file-upload-wrapper">
                                    <input type="file" name="dokumen_surat" id="dokumen_surat"
                                        class="@error('dokumen_surat') is-invalid @enderror"
                                        accept=".pdf,.doc,.docx">
                                    <div class="file-upload-icon-wrapper">
                                        <i class="fas fa-upload file-upload-icon"></i>
                                    </div>
                                    <div>
                                        <p class="file-upload-text" id="file-name-display">
                                            Seret dan lepas file di sini, atau klik untuk mengunggah.
                                        </p>
                                    </div>
                                </label>

                                @error('dokumen_surat')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror

                                <div id="filePreviewContainer" style="display: none;"></div>
                            </div>
                        </div>

                        {{-- Submit Buttons --}}
                        <div class="row mt-4">
                            <div class="col-md-9 offset-md-3 d-flex justify-content-between">
                                <button type="submit" class="btn btn-danger px-4">
                                    <i class="fas fa-save me-2"></i>Simpan Data
                                </button>
                                <a href="{{ route('admin.surat.index') }}" class="btn btn-secondary px-4">
                                    <i class="fas fa-arrow-left me-2"></i>Kembali
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const uploadInput = document.getElementById('dokumen_surat');
        const previewContainer = document.getElementById('filePreviewContainer');
        const fileNameDisplay = document.getElementById('file-name-display');

        uploadInput.addEventListener('change', function() {
            const file = this.files[0];

            if (file) {
                // Update display text
                fileNameDisplay.textContent = file.name;

                // Validate file type
                const allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
                if (!allowedTypes.includes(file.type)) {
                    alert('Hanya file PDF, DOC, dan DOCX yang diizinkan');
                    this.value = '';
                    fileNameDisplay.textContent = 'Seret dan lepas file di sini, atau klik untuk mengunggah.';
                    previewContainer.style.display = 'none';
                    return;
                }

                // Validate file size (10MB)
                const maxSize = 10 * 1024 * 1024; // 10MB in bytes
                if (file.size > maxSize) {
                    alert('Ukuran file tidak boleh lebih dari 10MB');
                    this.value = '';
                    fileNameDisplay.textContent = 'Seret dan lepas file di sini, atau klik untuk mengunggah.';
                    previewContainer.style.display = 'none';
                    return;
                }

                // Show file preview
                previewContainer.style.display = 'block';

                // Get file icon based on type
                let iconClass = 'fas fa-file';
                if (file.type === 'application/pdf') {
                    iconClass = 'fas fa-file-pdf';
                } else if (file.type.includes('word')) {
                    iconClass = 'fas fa-file-word';
                }

                // Format file size
                const fileSize = (file.size / 1024 / 1024).toFixed(2) + ' MB';

                previewContainer.innerHTML = `
                    <div class="file-preview-container">
                        <div class="file-preview-item">
                            <i class="${iconClass} file-preview-icon"></i>
                            <div>
                                <p class="file-preview-name">${file.name}</p>
                                <p class="file-preview-size">${fileSize}</p>
                            </div>
                        </div>
                    </div>
                `;
            } else {
                fileNameDisplay.textContent = 'Seret dan lepas file di sini, atau klik untuk mengunggah.';
                previewContainer.style.display = 'none';
                previewContainer.innerHTML = '';
            }
        });

        // Handle drag and drop
        const fileUploadWrapper = document.querySelector('.file-upload-wrapper');

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            fileUploadWrapper.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            fileUploadWrapper.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            fileUploadWrapper.addEventListener(eventName, unhighlight, false);
        });

        function highlight(e) {
            fileUploadWrapper.style.borderColor = '#0d6efd';
            fileUploadWrapper.style.backgroundColor = '#e6f0ff';
        }

        function unhighlight(e) {
            fileUploadWrapper.style.borderColor = '#cfe2ff';
            fileUploadWrapper.style.backgroundColor = '#edf5ff';
        }

        fileUploadWrapper.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;

            if (files.length > 0) {
                uploadInput.files = files;
                uploadInput.dispatchEvent(new Event('change'));
            }
        }
    });
</script>

@endsection
