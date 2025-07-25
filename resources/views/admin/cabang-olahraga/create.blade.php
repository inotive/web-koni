@extends('layouts.app')
@section('pageTitle', 'Tambah Cabang Olahraga')
@section('mainSection', 'Konfigurasi')
@section('mainSectionUrl', route('admin.konfigurasi.cabang-olahraga.index'))
@section('subSection', 'Cabang Olahraga')
@section('subSectionUrl', route('admin.konfigurasi.cabang-olahraga.index'))
@section('currentSection', 'Tambah Cabang Olahraga')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/create.css') }}">
@endpush

@section('breadcrumb-title')
    <h1 class="text-dark fw-bold fs-3 mb-0">Tambah Cabang Olahraga</h1>
@endsection

@section('content')

    <style>
        .form-label {
            font-weight: 500;
            color: #495057;
        }

        .card-form {
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border: none;
        }

        .file-upload-wrapper {
            border: 2px dashed #dee2e6;
            border-radius: 8px;
            padding: 1.5rem;
            text-align: center;
            cursor: pointer;
            background-color: #f8f9fa;
            transition: all 0.2s ease-in-out;
            position: relative;
        }

        .file-upload-wrapper:hover {
            border-color: #0d6efd;
            background-color: #e9ecef;
        }

        .file-upload-wrapper input[type="file"] {
            display: none;
        }

        .file-upload-icon {
            font-size: 2.5rem;
            color: #0d6efd;
        }

        .file-upload-text {
            color: #495057;
            font-weight: 500;
        }

        .file-upload-hint {
            color: #6c757d;
            font-size: 0.9em;
        }

        .current-photo {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
        }

        .preview-image {
            max-width: 100px;
            max-height: 100px;
            border-radius: 8px;
            object-fit: cover;
        }
    </style>

    <div class="container mt-4">
        <div class="card card-form">
            <div class="card-body p-4 p-md-5">
                <h3 class="fw-bold mb-4">Tambah Data Cabang Olahraga</h3>

                <form action="{{ route('admin.konfigurasi.cabang-olahraga.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row align-items-center mb-4">
                        <div class="col-md-3">
                            <label for="icon_cabor" class="form-label">Ikon Cabang Olahraga</label>
                        </div>
                        <div class="col-md-9">
                            <label for="icon_cabor" class="file-upload-wrapper" id="dropArea">
                                <input type="file" name="icon_cabor" id="icon_cabor" accept=".png,.webp,.svg,image/png,image/webp,image/svg+xml">
                                <div class="d-flex justify-content-center align-items-center" id="uploadContent">
                                    <i class="fas fa-cloud-upload-alt file-upload-icon me-3" id="uploadIcon"></i>
                                    <div id="uploadText">
                                        <p class="file-upload-text mb-1">Seret dan lepas file di sini, atau klik untuk
                                            mengunggah</p>
                                        <p class="file-upload-hint" id="file-name-display">PNG, WebP, atau SVG (80x80px)</p>
                                    </div>
                                </div>
                                <div id="imagePreviewContainer" style="display: none;"></div>
                            </label>
                            @error('icon_cabor')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    @php
                        $fields = [
                            'nama_cabor' => [
                                'label' => 'Nama Cabang Olahraga',
                                'type' => 'text',
                                'placeholder' => 'Masukkan nama cabang olahraga',
                                'required' => true,
                            ],
                            'ketua_penanggung_jawab' => [
                                'label' => 'Ketua Penanggung Jawab',
                                'type' => 'text',
                                'placeholder' => 'Masukkan nama ketua penanggung jawab',
                                'required' => true,
                            ],
                            'status' => [
                                'label' => 'Status Keaktifan',
                                'type' => 'select',
                                'options' => ['Aktif', 'Tidak Aktif'],
                                'required' => true,
                            ],
                            'tanggal_pembentukan' => [
                                'label' => 'Tanggal Pembentukan',
                                'type' => 'date',
                                'required' => true,
                            ],
                        ];
                    @endphp

                    @foreach ($fields as $key => $field)
                        <div class="row align-items-center mb-3">
                            <div class="col-md-3">
                                <label for="{{ $key }}" class="form-label">{{ $field['label'] }}</label>
                            </div>
                            <div class="col-md-9">
                                @php
                                    $value = old($key, '');
                                @endphp
                                @if ($field['type'] === 'select')
                                    <select name="{{ $key }}" id="{{ $key }}"
                                        class="form-select @error($key) is-invalid @enderror"
                                        {{ $field['required'] ? 'required' : '' }}>
                                        <option value="">Pilih {{ $field['label'] }}</option>
                                        @foreach ($field['options'] as $option)
                                            <option value="{{ $option }}" {{ $value == $option ? 'selected' : '' }}>
                                                {{ $option }}</option>
                                        @endforeach
                                    </select>
                                @elseif ($field['type'] === 'textarea')
                                    <textarea name="{{ $key }}" id="{{ $key }}" class="form-control @error($key) is-invalid @enderror"
                                        placeholder="{{ $field['placeholder'] }}" rows="3" {{ $field['required'] ? 'required' : '' }}>{{ $value }}</textarea>
                                @else
                                    <input type="{{ $field['type'] }}" name="{{ $key }}"
                                        id="{{ $key }}" class="form-control @error($key) is-invalid @enderror"
                                        placeholder="{{ $field['placeholder'] ?? '' }}" value="{{ $value }}"
                                        {{ $field['required'] ? 'required' : '' }}
                                        @if($field['type'] === 'number') min="0" @endif>
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
                            <a href="{{ route('admin.konfigurasi.cabang-olahraga.index') }}" class="btn btn-secondary px-4">Batal</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const uploadInput = document.getElementById('icon_cabor');
            const dropArea = document.getElementById('dropArea');
            const previewContainer = document.getElementById('imagePreviewContainer');

            // Define allowed file types
            const allowedTypes = ['image/png', 'image/webp', 'image/svg+xml'];
            const allowedExtensions = ['.png', '.webp', '.svg'];

            // Function to validate file type
            function isValidFileType(file) {
                const fileType = file.type;
                const fileName = file.name.toLowerCase();
                
                // Check MIME type
                if (allowedTypes.includes(fileType)) {
                    return true;
                }
                
                // Check file extension as fallback
                return allowedExtensions.some(ext => fileName.endsWith(ext));
            }

            // Function to resize image to 80x80px
            function resizeImage(file, callback) {
                // Skip resize for SVG files
                if (file.type === 'image/svg+xml') {
                    callback(file);
                    return;
                }

                const canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');
                const img = new Image();
                
                img.onload = function() {
                    // Set canvas size to 80x80
                    canvas.width = 80;
                    canvas.height = 80;
                    
                    // Calculate scaling to fit image in 80x80 while maintaining aspect ratio
                    const scale = Math.min(80 / img.width, 80 / img.height);
                    const scaledWidth = img.width * scale;
                    const scaledHeight = img.height * scale;
                    
                    // Center the image
                    const x = (80 - scaledWidth) / 2;
                    const y = (80 - scaledHeight) / 2;
                    
                    // Fill background with transparent
                    ctx.clearRect(0, 0, 80, 80);
                    
                    // Draw the resized image
                    ctx.drawImage(img, x, y, scaledWidth, scaledHeight);
                    
                    // Convert canvas to blob
                    canvas.toBlob(function(blob) {
                        // Create new File object with resized image
                        const resizedFile = new File([blob], file.name, {
                            type: file.type === 'image/webp' ? 'image/webp' : 'image/png',
                            lastModified: Date.now()
                        });
                        callback(resizedFile);
                    }, file.type === 'image/webp' ? 'image/webp' : 'image/png', 0.9);
                };
                
                img.src = URL.createObjectURL(file);
            }

            // Image preview functionality with auto resize
            uploadInput.addEventListener('change', function() {
                const file = this.files[0];
                const uploadContent = document.getElementById('uploadContent');
                const previewContainer = document.getElementById('imagePreviewContainer');

                if (file) {
                    if (!isValidFileType(file)) {
                        alert('Hanya file PNG, WebP, atau SVG yang diizinkan');
                        this.value = ''; // Clear the input
                        return;
                    }

                    // Show loading state
                    uploadContent.style.display = 'none';
                    previewContainer.style.display = 'flex';
                    previewContainer.style.justifyContent = 'center';
                    previewContainer.style.alignItems = 'center';
                    previewContainer.innerHTML = `
                        <div class="d-flex justify-content-center align-items-center">
                            <div class="spinner-border text-primary me-3" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <div>
                                <p class="file-upload-text mb-1">Memproses gambar...</p>
                                <p class="file-upload-hint">Mohon tunggu sebentar</p>
                            </div>
                        </div>
                    `;

                    // Resize image and update preview
                    resizeImage(file, (resizedFile) => {
                        // Create new FileList with resized file
                        const dt = new DataTransfer();
                        dt.items.add(resizedFile);
                        uploadInput.files = dt.files;

                        // Show preview
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const fileSize = (resizedFile.size / 1024).toFixed(1);
                            const previewContent = `
                            <div class="d-flex justify-content-center align-items-center">
                                <img src="${e.target.result}" class="preview-image me-3" alt="Preview Ikon Cabor" style="width: 80px; height: 80px; object-fit: contain; border-radius: 8px; border: 1px solid #dee2e6;">
                                <div>
                                    <p class="file-upload-text mb-1">${resizedFile.name}</p>
                                    <p class="file-upload-hint">80x80px • ${fileSize} KB</p>
                                    <p class="file-upload-hint">Klik untuk mengubah ikon</p>
                                </div>
                            </div>
                        `;
                            previewContainer.innerHTML = previewContent;
                        };
                        reader.readAsDataURL(resizedFile);
                    });
                } else {
                    // Show upload content and hide preview
                    uploadContent.style.display = 'flex';
                    previewContainer.style.display = 'none';
                    previewContainer.innerHTML = '';
                }
            });

            // Drag and drop functionality
            dropArea.addEventListener('dragover', (e) => {
                e.preventDefault();
                dropArea.style.borderColor = '#0d6efd';
                dropArea.style.backgroundColor = '#e9ecef';
            });

            dropArea.addEventListener('dragleave', () => {
                dropArea.style.borderColor = '#dee2e6';
                dropArea.style.backgroundColor = '#f8f9fa';
            });

            dropArea.addEventListener('drop', (e) => {
                e.preventDefault();
                dropArea.style.borderColor = '#dee2e6';
                dropArea.style.backgroundColor = '#f8f9fa';

                if (e.dataTransfer.files.length) {
                    const file = e.dataTransfer.files[0];
                    
                    if (!isValidFileType(file)) {
                        alert('Hanya file PNG, WebP, atau SVG yang diizinkan');
                        return;
                    }
                    
                    // Create DataTransfer object and set it to input
                    const dt = new DataTransfer();
                    dt.items.add(file);
                    uploadInput.files = dt.files;
                    
                    // Trigger change event
                    uploadInput.dispatchEvent(new Event('change'));
                }
            });

            // Form validation
            document.querySelector('form').addEventListener('submit', function(e) {
                const requiredFields = this.querySelectorAll('[required]');
                let isValid = true;

                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        isValid = false;
                        field.style.borderColor = '#ef4444';
                        field.style.boxShadow = '0 0 0 3px rgba(239, 68, 68, 0.1)';
                    } else {
                        field.style.borderColor = '#dbdfe9';
                        field.style.boxShadow = 'none';
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    alert('Mohon lengkapi semua field yang wajib diisi!');
                }
            });
        });
    </script>
@endsection