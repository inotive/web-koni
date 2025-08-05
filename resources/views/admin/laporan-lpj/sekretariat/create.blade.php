@extends('layouts.app')

@section('pageTitle', 'Tambah Sekretariat')
@section('mainSection', 'Laporan Pertanggungjawaban')
@section('subSection', 'Sekretariat')
@section('subSectionUrl', route('admin.laporan-lpj.sekretariat.index'))
@section('currentSection', 'Tambah Sekretariat')

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

        .form-control,
        .form-select {
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 0.95rem;
        }

        .form-control:focus,
        .form-select:focus {
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

        .preview-image {
            max-width: 100px;
            max-height: 100px;
            border-radius: 8px;
            object-fit: cover;
        }
    </style>

    <div class="d-flex justify-content-between align-items-center flex-wrap mb-4" style="padding: 20px 20px">
        <h3 class="fw-bold fs-2 mb-0 text-dark">Tambah Sekretariat</h3>
    </div>

    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="card card-form">
                    <div class="card-body p-4 p-md-5">
                        <h3 class="fw-bold mb-4">Tambah Data</h3>
                        <form action="{{ route('admin.laporan-lpj.sekretariat.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row align-items-start mb-4">
                                <div class="col-md-3">
                                    <label class="form-label">Foto Jurnal</label>
                                    <p class="file-upload-hint">Maks. 10 file Foto, masing-masing hingga 10 MB</p>
                                </div>
                                <div class="col-md-9">
                                    <label for="foto_jurnal" class="file-upload-wrapper">
                                        <input type="file" name="foto_jurnal" id="foto_jurnal"
                                            class="@error('foto_jurnal') is-invalid @enderror" accept="image/*">

                                        <div class="d-flex align-items-center gap-12">
                                            <div class="file-upload-icon-wrapper">
                                                <i class="fas fa-upload file-upload-icon"></i>
                                            </div>
                                            <div>
                                                <p class="file-upload-text" id="file-name-display">
                                                    Seret dan lepas file di sini, atau klik untuk mengunggah.
                                                </p>
                                                <div id="imagePreviewContainer" class="mt-2"></div>
                                            </div>
                                        </div>
                                    </label>

                                    @error('foto_jurnal')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row align-items-start mb-4">
                                <div class="col-md-3">
                                    <label class="form-label">Dokumen LPJ</label>
                                    <p class="file-upload-hint">Maks. 10 file PDF, masing-masing hingga 10MB</p>
                                </div>
                                <div class="col-md-9">
                                    <label for="dokumen_pendukung" class="file-upload-wrapper">
                                        <input type="file" name="dokumen_pendukung[]" id="dokumen_pendukung"
                                            class="form-control @error('dokumen_pendukung') is-invalid @enderror"
                                            accept=".pdf,.doc,.docx,.xls,.xlsx" multiple>

                                        <div class="d-flex align-items-center gap-12">
                                            <div class="file-upload-icon-wrapper">
                                                <i class="fas fa-upload file-upload-icon"></i>
                                            </div>
                                            <div>
                                                <p class="file-upload-text" id="dokumen-file-name-display">
                                                    Seret dan lepas file di sini, atau klik untuk mengunggah.
                                                </p>
                                                <div id="dokumenPreviewContainer" class="mt-2"></div>
                                            </div>
                                        </div>
                                    </label>

                                    @error('dokumen_pendukung')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            @php
                                $fields = [
                                    'nama_program_kegiatan' => [
                                        'label' => 'Nama Program',
                                        'type' => 'text',
                                        'placeholder' => 'Masukkan nama program',
                                    ],
                                    'jenis_kegiatan' => [
                                        'label' => 'Nama Kegiatan',
                                        'type' => 'text',
                                        'placeholder' => 'Contoh: Rapat, Pelatihan, Pembelian',
                                    ],
                                    'volume' => [
                                        'label' => 'Volume',
                                        'type' => 'text',
                                        'placeholder' => 'Masukkan volume kegiatan (contoh: 20 unit, 1 kegiatan)',
                                    ],
                                    'jumlah_harga_satuan' => [
                                        'label' => 'Jumlah Harga Satuan',
                                        'type' => 'number',
                                        'placeholder' => 'Masukkan jumlah harga satuan',
                                    ],
                                    'jumlah_harga' => [
                                        'label' => 'Jumlah Harga',
                                        'type' => 'number',
                                        'placeholder' => 'Masukkan jumlah harga',
                                    ],
                                                                        'keterangan_tambahan' => [
                                        'label' => 'Keterangan Tambahan',
                                        'type' => 'text',
                                        'placeholder' => 'Masukkan keterangan tambahan',
                                    ],
                                ];
                            @endphp

                            @foreach ($fields as $key => $field)
                                <div class="row align-items-center mb-3">
                                    <div class="col-md-3">
                                        <label for="{{ $key }}" class="form-label">{{ $field['label'] }}</label>
                                    </div>
                                    <div class="col-md-9">
                                        @if ($field['type'] === 'file')
                                            <input type="{{ $field['type'] }}" name="{{ $key }}"
                                                id="{{ $key }}"
                                                class="form-control @error($key) is-invalid @enderror"
                                                placeholder="{{ $field['placeholder'] ?? '' }}" value="{{ old($key) }}"
                                                {{ in_array($key, ['nama_program_kegiatan', 'jenis_kegiatan', 'keterangan_tambahan', 'volume', 'jumlah_harga_satuan', 'jumlah_harga']) ? 'required' : '' }}>
                                        @else
                                            <input type="{{ $field['type'] }}" name="{{ $key }}"
                                                id="{{ $key }}"
                                                class="form-control @error($key) is-invalid @enderror"
                                                placeholder="{{ $field['placeholder'] ?? '' }}"
                                                value="{{ old($key) }}"
                                                {{ in_array($key, ['nama_program_kegiatan', 'jenis_kegiatan', 'keterangan_tambahan', 'volume', 'jumlah_harga_satuan', 'jumlah_harga']) ? 'required' : '' }}>
                                        @endif
                                        @error($key)
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            @endforeach

                            <div class="row mt-4">
                                <div class="col-md-9 offset-md-3 d-flex justify-content-between">
                                    <button type="submit" class="btn btn-danger px-4">Simpan Data</button>
                                    <a href="{{ route('admin.laporan-lpj.sekretariat.index') }}"
                                        class="btn btn-secondary px-4">Kembali</a>
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
            const uploadInput = document.getElementById('foto_jurnal');
            const uploadContent = document.getElementById('uploadContent');
            const previewContainer = document.getElementById('imagePreviewContainer');
            const fileNameDisplay = document.getElementById('file-name-display');

            uploadInput.addEventListener('change', function() {
                const file = this.files[0];

                if (file) {
                    if (!file.type.match('image.*')) {
                        alert('Hanya file gambar yang diizinkan');
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        fileNameDisplay.style.display = 'none';

                        previewContainer.innerHTML = `
                <div class="d-flex align-items-center mt-2">
                    <img src="${e.target.result}" class="preview-image" alt="Preview">
                    <span class="ms-2 file-upload-text">${file.name}</span>
                </div>
            `;
                    };

                    reader.readAsDataURL(file);
                } else {
                    fileNameDisplay.style.display = '';
                    fileNameDisplay.textContent =
                        'Seret dan lepas file di sini, atau klik untuk mengunggah.';
                    previewContainer.innerHTML = '';
                }
            });

            const fileUploadWrapper = document.querySelector('.file-upload-wrapper');

            fileUploadWrapper.addEventListener('dragover', (e) => {
                e.preventDefault();
                fileUploadWrapper.style.borderColor = '#0d6efd';
                fileUploadWrapper.style.backgroundColor = '#e6f0ff';
            });

            fileUploadWrapper.addEventListener('dragleave', () => {
                fileUploadWrapper.style.borderColor = '#cfe2ff';
                fileUploadWrapper.style.backgroundColor = '#edf5ff';
            });

            fileUploadWrapper.addEventListener('drop', (e) => {
                e.preventDefault();
                fileUploadWrapper.style.borderColor = '#cfe2ff';
                fileUploadWrapper.style.backgroundColor = '#edf5ff';

                if (e.dataTransfer.files.length) {
                    uploadInput.files = e.dataTransfer.files;
                    uploadInput.dispatchEvent(new Event('change'));
                }
            });

            // Dokumen Pendukung
            const dokumenUploadInput = document.getElementById('dokumen_pendukung');
            const dokumenFileNameDisplay = document.getElementById('dokumen-file-name-display');
            const dokumenPreviewContainer = document.getElementById('dokumenPreviewContainer');

            dokumenUploadInput.addEventListener('change', function() {
                const file = this.files[0];

                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        dokumenFileNameDisplay.style.display = 'none';

                        dokumenPreviewContainer.innerHTML = `
                <div class="d-flex align-items-center mt-2">
                    <span class="ms-2 file-upload-text">${file.name}</span>
                </div>
            `;
                    };

                    reader.readAsDataURL(file);
                } else {
                    dokumenFileNameDisplay.style.display = '';
                    dokumenFileNameDisplay.textContent =
                        'Seret dan lepas file di sini, atau klik untuk mengunggah.';
                    dokumenPreviewContainer.innerHTML = '';
                }
            });

            const dokumenFileUploadWrapper = document.querySelector('#dokumen_pendukung + .file-upload-wrapper');

            dokumenFileUploadWrapper.addEventListener('dragover', (e) => {
                e.preventDefault();
                dokumenFileUploadWrapper.style.borderColor = '#0d6efd';
                dokumenFileUploadWrapper.style.backgroundColor = '#e6f0ff';
            });

            dokumenFileUploadWrapper.addEventListener('dragleave', () => {
                dokumenFileUploadWrapper.style.borderColor = '#cfe2ff';
                dokumenFileUploadWrapper.style.backgroundColor = '#edf5ff';
            });

            dokumenFileUploadWrapper.addEventListener('drop', (e) => {
                e.preventDefault();
                dokumenFileUploadWrapper.style.borderColor = '#cfe2ff';
                dokumenFileUploadWrapper.style.backgroundColor = '#edf5ff';

                if (e.dataTransfer.files.length) {
                    dokumenUploadInput.files = e.dataTransfer.files;
                    dokumenUploadInput.dispatchEvent(new Event('change'));
                }
            });
        });
    </script>

@endsection
