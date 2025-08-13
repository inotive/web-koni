@extends('layouts.app')

@section('pageTitle', 'Tambah Mobilisasi Sumber Daya')
@section('mainSection', 'Laporan Pertanggungjawaban')
@section('subSection', 'Mobilisasi Sumber Daya')
@section('subSectionUrl', route('admin.laporan-lpj.bidang.mobilisasi-sumberdaya.index'))
@section('currentSection', 'Tambah Mobilisasi Sumber Daya')

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
        <h3 class="fw-bold fs-2 mb-0 text-dark">Tambah Mobilisasi Sumber Daya</h3>
    </div>

    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="card card-form">
                    <div class="card-body p-4 p-md-5">
                        <h3 class="fw-bold mb-4">Tambah Data</h3>
                        <form action="{{ route('admin.laporan-lpj.bidang.mobilisasi-sumberdaya.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf

                            @php
                                $fields = [
                                    'nama_program' => [
                                        'label' => 'Nama Program',
                                        'type' => 'text',
                                        'placeholder' => 'Masukkan nama program',
                                        'required' => true,
                                    ],
                                    'nama_kegiatan' => [
                                        'label' => 'Nama Kegiatan',
                                        'type' => 'text',
                                        'placeholder' => 'Contoh: Pelatihan, Workshop, Pembelian',
                                        'required' => true,
                                    ],
                                    'volume' => [
                                        'label' => 'Volume',
                                        'type' => 'text',
                                        'placeholder' => 'Masukkan volume kegiatan (contoh: 20 unit, 1 kegiatan)',
                                        'required' => true,
                                    ],
                                    'jumlah_harga_satuan' => [
                                        'label' => 'Jumlah Harga Satuan',
                                        'type' => 'number',
                                        'placeholder' => 'Masukkan jumlah harga satuan',
                                        'required' => true,
                                    ],
                                    'jumlah_harga' => [
                                        'label' => 'Jumlah Harga',
                                        'type' => 'number',
                                        'placeholder' => 'Masukkan jumlah harga',
                                        'required' => true,
                                    ],
                                    'keterangan_tambahan' => [
                                        'label' => 'Keterangan Tambahan',
                                        'type' => 'textarea',
                                        'placeholder' => 'Masukkan keterangan tambahan (opsional)',
                                        'required' => false,
                                    ],
                                ];
                            @endphp

                            @foreach ($fields as $key => $field)
                                @if($key === 'keterangan_tambahan')
                                {{-- Foto Jurnal Upload --}}
                                <div class="row align-items-start mb-4">
                                    <div class="col-md-3">
                                        <label class="form-label">Foto Jurnal</label>
                                        <p class="file-upload-hint">File Foto, hingga 10 MB</p>
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

                                {{-- Dokumen LPJ Upload --}}
                                <div class="row align-items-start mb-4">
                                    <div class="col-md-3">
                                        <label class="form-label">Dokumen LPJ</label>
                                        <p class="file-upload-hint">File PDF/Office, masing-masing hingga 10MB</p>
                                    </div>
                                    <div class="col-md-9">
                                        <label for="dokumen_lpj" class="file-upload-wrapper">
                                            <input type="file" name="dokumen_lpj[]" id="dokumen_lpj"
                                                class="form-control @error('dokumen_lpj') is-invalid @enderror"
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

                                        @error('dokumen_lpj')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            @endif
                                <div class="row align-items-center mb-3">
                                    <div class="col-md-3">
                                        <label for="{{ $key }}" class="form-label">
                                            {{ $field['label'] }}
                                            @if($field['required'])
                                                <span class="text-danger">*</span>
                                            @endif
                                        </label>
                                    </div>
                                    <div class="col-md-9">
                                        @if ($field['type'] === 'textarea')
                                            <textarea name="{{ $key }}" id="{{ $key }}"
                                                class="form-control @error($key) is-invalid @enderror"
                                                placeholder="{{ $field['placeholder'] ?? '' }}"
                                                rows="3"
                                                {{ $field['required'] ? 'required' : '' }}>{{ old($key) }}</textarea>
                                        @else
                                            <input type="{{ $field['type'] }}" name="{{ $key }}"
                                                id="{{ $key }}"
                                                class="form-control @error($key) is-invalid @enderror"
                                                placeholder="{{ $field['placeholder'] ?? '' }}"
                                                value="{{ old($key) }}"
                                                {{ $field['required'] ? 'required' : '' }}
                                                @if($field['type'] === 'number') min="0" step="0.01" @endif>
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
                                    <a href="{{ route('admin.laporan-lpj.bidang.mobilisasi-sumberdaya.index') }}"
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
            // Foto Jurnal Upload
            const uploadInput = document.getElementById('foto_jurnal');
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
                    fileNameDisplay.textContent = 'Seret dan lepas file di sini, atau klik untuk mengunggah.';
                    previewContainer.innerHTML = '';
                }
            });

            // Dokumen LPJ Upload
            const dokumenUploadInput = document.getElementById('dokumen_lpj');
            const dokumenFileNameDisplay = document.getElementById('dokumen-file-name-display');
            const dokumenPreviewContainer = document.getElementById('dokumenPreviewContainer');

            dokumenUploadInput.addEventListener('change', function() {
                const files = this.files;

                if (files.length > 0) {
                    dokumenFileNameDisplay.style.display = 'none';

                    let fileList = '';
                    for (let i = 0; i < files.length; i++) {
                        fileList += `
                            <div class="d-flex align-items-center mt-2">
                                <i class="fas fa-file-alt me-2 text-primary"></i>
                                <span class="file-upload-text">${files[i].name}</span>
                            </div>
                        `;
                    }
                    dokumenPreviewContainer.innerHTML = fileList;
                } else {
                    dokumenFileNameDisplay.style.display = '';
                    dokumenFileNameDisplay.textContent = 'Seret dan lepas file di sini, atau klik untuk mengunggah.';
                    dokumenPreviewContainer.innerHTML = '';
                }
            });

            // Drag and drop functionality
            const fileUploadWrappers = document.querySelectorAll('.file-upload-wrapper');

            fileUploadWrappers.forEach(wrapper => {
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

                    const input = wrapper.querySelector('input[type="file"]');
                    if (e.dataTransfer.files.length && input) {
                        input.files = e.dataTransfer.files;
                        input.dispatchEvent(new Event('change'));
                    }
                });
            });

            // Auto-calculate jumlah_harga based on volume and jumlah_harga_satuan
            const volumeInput = document.getElementById('volume');
            const hargaSatuanInput = document.getElementById('jumlah_harga_satuan');
            const jumlahHargaInput = document.getElementById('jumlah_harga');

            function calculateTotal() {
                const volume = parseFloat(volumeInput.value) || 0;
                const hargaSatuan = parseFloat(hargaSatuanInput.value) || 0;

                // Simple calculation - you might want to modify this logic
                const total = hargaSatuan * (volume || 1);
                jumlahHargaInput.value = total;
            }

            hargaSatuanInput.addEventListener('input', calculateTotal);
            volumeInput.addEventListener('input', function() {
                // Only calculate if volume is a number
                const volumeValue = this.value;
                const numericVolume = parseFloat(volumeValue.replace(/[^\d.]/g, ''));
                if (!isNaN(numericVolume)) {
                    calculateTotal();
                }
            });
        });
    </script>

@endsection
