@extends('layouts.app')

@section('pageTitle', 'Edit Sekretariat')
@section('mainSection', 'Laporan Pertanggungjawaban')
@section('subSection', 'Sekretariat')
@section('subSectionUrl', route('admin.laporan-lpj.sekretariat.index'))
@section('currentSection', 'Edit Sekretariat')

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
        <h3 class="fw-bold fs-2 mb-0 text-dark">Edit Sekretariat</h3>
    </div>

    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="card card-form">
                    <div class="card-body p-4 p-md-5">
                        <h3 class="fw-bold mb-4">Edit Data</h3>
                        <form action="{{ route('admin.laporan-lpj.sekretariat.update', $sekretariat->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

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
                                            <div class="flex-grow-1">
                                                @if($sekretariat->foto_jurnal)
                                                    <div class="d-flex align-items-center mb-2" id="currentImageContainer">
                                                        <img src="{{ asset('storage/' . $sekretariat->foto_jurnal) }}" class="preview-image me-3" alt="Current Image">
                                                        <div>
                                                            <small class="text-muted d-block">Foto saat ini</small>
                                                            <a href="{{ asset('storage/' . $sekretariat->foto_jurnal) }}" target="_blank" class="text-decoration-none">
                                                                Lihat foto
                                                            </a>
                                                        </div>
                                                    </div>
                                                @endif
                                                <p class="file-upload-text mb-0" id="file-name-display">
                                                    {{ $sekretariat->foto_jurnal ? 'Klik untuk mengganti foto' : 'Seret dan lepas file di sini, atau klik untuk mengunggah.' }}
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
                                            <div class="flex-grow-1">
                                                @if($sekretariat->dokumen_pendukung)
                                                    <div class="d-flex align-items-center mb-2" id="currentDocumentContainer">
                                                        <i class="fas fa-file-alt me-2 text-primary" style="font-size: 1.5rem;"></i>
                                                        <div>
                                                            <small class="text-muted d-block">File saat ini:</small>
                                                            <a href="{{ asset('storage/' . $sekretariat->dokumen_pendukung) }}" target="_blank" class="text-decoration-none">
                                                                {{ basename($sekretariat->dokumen_pendukung) }}
                                                            </a>
                                                        </div>
                                                    </div>
                                                @endif
                                                <p class="file-upload-text mb-0" id="dokumen-file-name-display">
                                                    {{ $sekretariat->dokumen_pendukung ? 'Klik untuk mengganti dokumen' : 'Seret dan lepas file di sini, atau klik untuk mengunggah.' }}
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
                                        <input type="{{ $field['type'] }}" name="{{ $key }}"
                                            id="{{ $key }}"
                                            class="form-control @error($key) is-invalid @enderror"
                                            placeholder="{{ $field['placeholder'] ?? '' }}"
                                            value="{{ old($key, $sekretariat->$key) }}"
                                            {{ in_array($key, ['nama_program_kegiatan', 'jenis_kegiatan', 'volume', 'jumlah_harga_satuan', 'jumlah_harga']) ? 'required' : '' }}>

                                        @error($key)
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            @endforeach

                            <div class="row mt-4">
                                <div class="col-md-9 offset-md-3 d-flex justify-content-between">
                                    <button type="submit" class="btn btn-danger px-4">Update Data</button>
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
            const previewContainer = document.getElementById('imagePreviewContainer');
            const fileNameDisplay = document.getElementById('file-name-display');
            const currentImageContainer = document.getElementById('currentImageContainer');

            uploadInput.addEventListener('change', function() {
                const file = this.files[0];

                if (file) {
                    if (!file.type.match('image.*')) {
                        alert('Hanya file gambar yang diizinkan');
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        if (currentImageContainer) {
                            currentImageContainer.style.display = 'none';
                        }

                        fileNameDisplay.textContent = 'File baru dipilih: ' + file.name;

                        previewContainer.innerHTML = `
                            <div class="d-flex align-items-center mt-2">
                                <img src="${e.target.result}" class="preview-image me-3" alt="Preview">
                                <span class="file-upload-text">${file.name}</span>
                            </div>
                        `;
                    };

                    reader.readAsDataURL(file);
                } else {
                    if (currentImageContainer) {
                        currentImageContainer.style.display = 'flex';
                    }
                    fileNameDisplay.textContent = '{{ $sekretariat->foto_jurnal ? "Klik untuk mengganti foto" : "Seret dan lepas file di sini, atau klik untuk mengunggah." }}';
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

            const dokumenUploadInput = document.getElementById('dokumen_pendukung');
            const dokumenFileNameDisplay = document.getElementById('dokumen-file-name-display');
            const dokumenPreviewContainer = document.getElementById('dokumenPreviewContainer');
            const currentDocumentContainer = document.getElementById('currentDocumentContainer');

            dokumenUploadInput.addEventListener('change', function() {
                const file = this.files[0];

                if (file) {
                    if (currentDocumentContainer) {
                        currentDocumentContainer.style.display = 'none';
                    }

                    dokumenFileNameDisplay.textContent = 'File baru dipilih: ' + file.name;

                    dokumenPreviewContainer.innerHTML = `
                        <div class="d-flex align-items-center mt-2">
                            <i class="fas fa-file-alt me-2 text-primary" style="font-size: 1.5rem;"></i>
                            <span class="file-upload-text">${file.name}</span>
                        </div>
                    `;
                } else {
                    if (currentDocumentContainer) {
                        currentDocumentContainer.style.display = 'flex';
                    }
                    dokumenFileNameDisplay.textContent = '{{ $sekretariat->dokumen_pendukung ? "Klik untuk mengganti dokumen" : "Seret dan lepas file di sini, atau klik untuk mengunggah." }}';
                    dokumenPreviewContainer.innerHTML = '';
                }
            });

            const dokumenFileUploadWrappers = document.querySelectorAll('label[for="dokumen_pendukung"]');
            dokumenFileUploadWrappers.forEach(wrapper => {
                wrapper.addEventListener('dragover', (e) => {
                    e.preventDefault();
                    wrapper.style.borderColor = '#0d6efd';
                    wrapper.style.backgroundColor = '#e6f0ff';
                });

                wrapper.addEventListener('dragleave', () => {
                    wrapper.style.borderColor = '#cfe2ff';
                    wrapper.style.backgroundColor = '#edf5ff';
                });

                wrapper.addEventListener('drop', (e) => {
                    e.preventDefault();
                    wrapper.style.borderColor = '#cfe2ff';
                    wrapper.style.backgroundColor = '#edf5ff';

                    if (e.dataTransfer.files.length) {
                        dokumenUploadInput.files = e.dataTransfer.files;
                        dokumenUploadInput.dispatchEvent(new Event('change'));
                    }
                });
            });
        });
    </script>

@endsection
