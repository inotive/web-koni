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
            min-height: 80px;
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
            flex-shrink: 0;
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
            max-width: 80px;
            max-height: 80px;
            border-radius: 8px;
            object-fit: cover;
            margin-right: 8px;
            margin-bottom: 8px;
        }

        .file-preview {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }

        .file-item {
            display: flex;
            align-items: center;
            background: #f8f9fa;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 0.85rem;
            color: #495057;
            max-width: 250px;
        }

        .file-item i {
            margin-right: 8px;
            color: #6c757d;
        }

        .file-name {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            flex: 1;
        }

        .file-counter {
            background: #007bff;
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 0.75rem;
            margin-left: 8px;
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

                            <!-- Foto Jurnal Upload -->
                            <div class="row align-items-start mb-4">
                                <div class="col-md-3">
                                    <label class="form-label">Foto Jurnal</label>
                                    <p class="file-upload-hint">Maksimal 10 foto, masing-masing hingga 10 MB</p>
                                </div>
                                <div class="col-md-9">
                                    <label for="foto_jurnal" class="file-upload-wrapper">
                                        <input type="file" name="foto_jurnal[]" id="foto_jurnal"
                                            class="@error('foto_jurnal') is-invalid @enderror"
                                            accept="image/jpeg,image/jpg,image/png,image/gif" multiple>

                                        <div class="d-flex align-items-center gap-12 w-100">
                                            <div class="file-upload-icon-wrapper">
                                                <i class="fas fa-upload file-upload-icon"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <p class="file-upload-text" id="foto-file-name-display">
                                                    Seret dan lepas foto di sini, atau klik untuk mengunggah
                                                </p>
                                                <div id="fotoPreviewContainer" class="file-preview"></div>
                                            </div>
                                        </div>
                                    </label>

                                    @error('foto_jurnal')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                    @error('foto_jurnal.*')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Dokumen Pendukung Upload -->
                            <div class="row align-items-start mb-4">
                                <div class="col-md-3">
                                    <label class="form-label">Dokumen Pendukung</label>
                                    <p class="file-upload-hint">Maksimal 10 dokumen, masing-masing hingga 10MB</p>
                                </div>
                                <div class="col-md-9">
                                    <label for="dokumen_pendukung" class="file-upload-wrapper">
                                        <input type="file" name="dokumen_pendukung[]" id="dokumen_pendukung"
                                            class="form-control @error('dokumen_pendukung') is-invalid @enderror"
                                            accept=".pdf,.doc,.docx,.xls,.xlsx" multiple>

                                        <div class="d-flex align-items-center gap-12 w-100">
                                            <div class="file-upload-icon-wrapper">
                                                <i class="fas fa-upload file-upload-icon"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <p class="file-upload-text" id="dokumen-file-name-display">
                                                    Seret dan lepas dokumen di sini, atau klik untuk mengunggah
                                                </p>
                                                <div id="dokumenPreviewContainer" class="file-preview"></div>
                                            </div>
                                        </div>
                                    </label>

                                    @error('dokumen_pendukung')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                    @error('dokumen_pendukung.*')
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
                                            value="{{ old($key) }}"
                                            {{ in_array($key, ['nama_program_kegiatan', 'jenis_kegiatan', 'volume', 'jumlah_harga_satuan', 'jumlah_harga']) ? 'required' : '' }}>

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
            const fotoUploadInput = document.getElementById('foto_jurnal');
            const fotoPreviewContainer = document.getElementById('fotoPreviewContainer');
            const fotoFileNameDisplay = document.getElementById('foto-file-name-display');

            fotoUploadInput.addEventListener('change', function() {
                const files = Array.from(this.files);

                if (files.length > 10) {
                    alert('Maksimal 10 foto yang dapat diunggah');
                    this.value = '';
                    return;
                }

                if (files.length > 0) {
                    const validFiles = files.filter(file => {
                        if (!file.type.match('image.*')) {
                            alert(`File ${file.name} bukan gambar yang valid`);
                            return false;
                        }
                        if (file.size > 10 * 1024 * 1024) {
                            alert(`File ${file.name} terlalu besar (maksimal 10MB)`);
                            return false;
                        }
                        return true;
                    });

                    if (validFiles.length !== files.length) {
                        this.value = '';
                        return;
                    }

                    fotoFileNameDisplay.textContent = `${files.length} foto dipilih`;

                    fotoPreviewContainer.innerHTML = '';
                    files.forEach((file, index) => {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const imageDiv = document.createElement('div');
                            imageDiv.innerHTML = `
                                <img src="${e.target.result}" class="preview-image" alt="Preview ${index + 1}">
                            `;
                            fotoPreviewContainer.appendChild(imageDiv);
                        };
                        reader.readAsDataURL(file);
                    });
                } else {
                    fotoFileNameDisplay.textContent = 'Seret dan lepas foto di sini, atau klik untuk mengunggah';
                    fotoPreviewContainer.innerHTML = '';
                }
            });

            const dokumenUploadInput = document.getElementById('dokumen_pendukung');
            const dokumenPreviewContainer = document.getElementById('dokumenPreviewContainer');
            const dokumenFileNameDisplay = document.getElementById('dokumen-file-name-display');

            dokumenUploadInput.addEventListener('change', function() {
                const files = Array.from(this.files);

                if (files.length > 10) {
                    alert('Maksimal 10 dokumen yang dapat diunggah');
                    this.value = '';
                    return;
                }

                if (files.length > 0) {
                    const validExtensions = ['pdf', 'doc', 'docx', 'xls', 'xlsx'];
                    const validFiles = files.filter(file => {
                        const extension = file.name.split('.').pop().toLowerCase();
                        if (!validExtensions.includes(extension)) {
                            alert(`File ${file.name} format tidak didukung`);
                            return false;
                        }
                        if (file.size > 10 * 1024 * 1024) {
                            alert(`File ${file.name} terlalu besar (maksimal 10MB)`);
                            return false;
                        }
                        return true;
                    });

                    if (validFiles.length !== files.length) {
                        this.value = '';
                        return;
                    }

                    dokumenFileNameDisplay.textContent = `${files.length} dokumen dipilih`;

                    dokumenPreviewContainer.innerHTML = '';
                    files.forEach((file) => {
                        const fileDiv = document.createElement('div');
                        fileDiv.className = 'file-item';

                        const getFileIcon = (fileName) => {
                            const extension = fileName.split('.').pop().toLowerCase();
                            switch(extension) {
                                case 'pdf': return 'fas fa-file-pdf';
                                case 'doc':
                                case 'docx': return 'fas fa-file-word';
                                case 'xls':
                                case 'xlsx': return 'fas fa-file-excel';
                                default: return 'fas fa-file-alt';
                            }
                        };

                        fileDiv.innerHTML = `
                            <i class="${getFileIcon(file.name)}"></i>
                            <span class="file-name" title="${file.name}">${file.name}</span>
                        `;
                        dokumenPreviewContainer.appendChild(fileDiv);
                    });
                } else {
                    dokumenFileNameDisplay.textContent = 'Seret dan lepas dokumen di sini, atau klik untuk mengunggah';
                    dokumenPreviewContainer.innerHTML = '';
                }
            });

            const fotoFileUploadWrapper = document.querySelector('label[for="foto_jurnal"]');

            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                fotoFileUploadWrapper.addEventListener(eventName, preventDefaults, false);
            });

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            ['dragenter', 'dragover'].forEach(eventName => {
                fotoFileUploadWrapper.addEventListener(eventName, () => {
                    fotoFileUploadWrapper.style.borderColor = '#0d6efd';
                    fotoFileUploadWrapper.style.backgroundColor = '#e6f0ff';
                }, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                fotoFileUploadWrapper.addEventListener(eventName, () => {
                    fotoFileUploadWrapper.style.borderColor = '#cfe2ff';
                    fotoFileUploadWrapper.style.backgroundColor = '#edf5ff';
                }, false);
            });

            fotoFileUploadWrapper.addEventListener('drop', function(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                fotoUploadInput.files = files;
                fotoUploadInput.dispatchEvent(new Event('change'));
            });

            const dokumenFileUploadWrapper = document.querySelector('label[for="dokumen_pendukung"]');

            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dokumenFileUploadWrapper.addEventListener(eventName, preventDefaults, false);
            });

            ['dragenter', 'dragover'].forEach(eventName => {
                dokumenFileUploadWrapper.addEventListener(eventName, () => {
                    dokumenFileUploadWrapper.style.borderColor = '#0d6efd';
                    dokumenFileUploadWrapper.style.backgroundColor = '#e6f0ff';
                }, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dokumenFileUploadWrapper.addEventListener(eventName, () => {
                    dokumenFileUploadWrapper.style.borderColor = '#cfe2ff';
                    dokumenFileUploadWrapper.style.backgroundColor = '#edf5ff';
                }, false);
            });

            dokumenFileUploadWrapper.addEventListener('drop', function(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                dokumenUploadInput.files = files;
                dokumenUploadInput.dispatchEvent(new Event('change'));
            });
        });
    </script>

@endsection
