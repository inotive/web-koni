@extends('layouts.app')

@section('pageTitle', 'Tambah File Kesekretariat')
@section('mainSection', 'File Management')
@section('mainSectionUrl', route('admin.file-kesekretariat.index'))
@section('subSection', 'File Kesekretariat')
@section('subSectionUrl', route('admin.file-kesekretariat.index'))
@section('currentSection', 'Tambah File')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/create.css') }}">
@endpush

@section('breadcrumb-title')
    {{-- <h1 class="text-dark fw-bold fs-3 mb-0">Tambah File Kesekretariat</h1> --}}
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

        .preview-file {
            border-radius: 8px;
            padding: 1rem;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
        }

        .file-icon {
            font-size: 2rem;
            color: #198754;
        }

        .btn-danger {
            background-color: #F8285A;
            border-color: #F8285A;
        }

        .btn-danger:hover {
            background-color: #d61e4a;
            border-color: #d61e4a;
        }
    </style>

    <div class="container mt-4">
        <div class="card card-form">
            <div class="card-body p-4 p-md-5">
                <h3 class="fw-bold mb-4">Tambah File Kesekretariat</h3>

                <form action="{{ route('admin.file-kesekretariat.store') }}" method="POST"
                    enctype="multipart/form-data" id="fileUploadForm">
                    @csrf

                    @php
                        $fields = [
                            'nama_dokumen' => [
                                'label' => 'Nama Dokumen',
                                'type' => 'text',
                                'placeholder' => 'Masukkan nama dokumen',
                                'required' => true,
                            ],
                        ];
                    @endphp

                    @foreach ($fields as $key => $field)
                        <div class="row align-items-center mb-4">
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
                                        @if ($field['type'] === 'number') min="0" @endif>
                                @endif
                                @error($key)
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    @endforeach

                    <div class="row align-items-center mb-4">
                        <div class="col-md-3">
                            <label for="dokumen_file" class="form-label">File Dokumen</label>
                        </div>
                        <div class="col-md-9">
                            <label for="dokumen_file" class="file-upload-wrapper" id="dropArea">
                                <input type="file" name="dokumen_file" id="dokumen_file"
                                    accept=".pdf,.doc,.docx,.xls,.xlsx" required>
                                <div class="d-flex justify-content-center align-items-center" id="uploadContent">
                                    <i class="fas fa-cloud-upload-alt file-upload-icon me-3" id="uploadIcon"></i>
                                    <div id="uploadText">
                                        <p class="file-upload-text mb-1">Seret dan lepas file di sini, atau klik untuk
                                            mengunggah</p>
                                        <p class="file-upload-hint" id="file-name-display">PDF, DOC, DOCX, XLS, XLSX (Maks. 2MB)</p>
                                    </div>
                                </div>
                                <div id="filePreviewContainer" style="display: none;"></div>
                            </label>
                            @error('dokumen_file')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-9 offset-md-3 d-flex justify-content-between">
                            <button type="submit" class="btn btn-danger px-4">
                                <i class="fas fa-save me-2"></i>Simpan File
                            </button>
                            <a href="{{ route('admin.file-kesekretariat.index') }}"
                                class="btn btn-secondary px-4">
                                <i class="fas fa-arrow-left me-2"></i>Batal
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const uploadInput = document.getElementById('dokumen_file');
            const dropArea = document.getElementById('dropArea');
            const previewContainer = document.getElementById('filePreviewContainer');
            const uploadContent = document.getElementById('uploadContent');

            // Define allowed file types and size limit
            const allowedTypes = [
                'application/pdf',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'application/vnd.ms-excel',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
            ];
            const allowedExtensions = ['.pdf', '.doc', '.docx', '.xls', '.xlsx'];
            const maxFileSize = 2 * 1024 * 1024; // 2MB in bytes

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

            // Function to validate file size
            function isValidFileSize(file) {
                return file.size <= maxFileSize;
            }

            // Function to get file icon based on extension
            function getFileIcon(filename) {
                const extension = filename.split('.').pop().toLowerCase();
                const iconMap = {
                    'pdf': 'fas fa-file-pdf text-danger',
                    'doc': 'fas fa-file-word text-primary',
                    'docx': 'fas fa-file-word text-primary',
                    'xls': 'fas fa-file-excel text-success',
                    'xlsx': 'fas fa-file-excel text-success'
                };
                return iconMap[extension] || 'fas fa-file text-muted';
            }

            // Function to format file size
            function formatFileSize(bytes) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
            }

            // File preview functionality
            uploadInput.addEventListener('change', function() {
                const file = this.files[0];

                if (file) {
                    // Validate file type
                    if (!isValidFileType(file)) {
                        alert('Hanya file PDF, DOC, DOCX, XLS, atau XLSX yang diizinkan');
                        this.value = '';
                        showUploadContent();
                        return;
                    }

                    // Validate file size
                    if (!isValidFileSize(file)) {
                        alert('Ukuran file maksimal 2MB');
                        this.value = '';
                        showUploadContent();
                        return;
                    }

                    // Show file preview
                    showFilePreview(file);
                } else {
                    showUploadContent();
                }
            });

            function showFilePreview(file) {
                uploadContent.style.display = 'none';
                previewContainer.style.display = 'flex';
                previewContainer.style.justifyContent = 'center';
                previewContainer.style.alignItems = 'center';
                
                const fileIcon = getFileIcon(file.name);
                const fileSize = formatFileSize(file.size);
                
                previewContainer.innerHTML = `
                    <div class="d-flex justify-content-center align-items-center">
                        <i class="${fileIcon}" style="font-size: 3rem; margin-right: 1rem;"></i>
                        <div>
                            <p class="file-upload-text mb-1">${file.name}</p>
                            <p class="file-upload-hint">${fileSize}</p>
                            <p class="file-upload-hint">Klik untuk mengubah file</p>
                        </div>
                    </div>
                `;
            }

            function showUploadContent() {
                uploadContent.style.display = 'flex';
                previewContainer.style.display = 'none';
                previewContainer.innerHTML = '';
            }

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

                    // Validate file type
                    if (!isValidFileType(file)) {
                        alert('Hanya file PDF, DOC, DOCX, XLS, atau XLSX yang diizinkan');
                        return;
                    }

                    // Validate file size
                    if (!isValidFileSize(file)) {
                        alert('Ukuran file maksimal 2MB');
                        return;
                    }

                    // Create DataTransfer object and set it to input
                    const dt = new DataTransfer();
                    dt.items.add(file);
                    uploadInput.files = dt.files;

                    // Show file preview
                    showFilePreview(file);
                }
            });

            // Form validation
            document.querySelector('#fileUploadForm').addEventListener('submit', function(e) {
                const requiredFields = this.querySelectorAll('[required]');
                let isValid = true;

                requiredFields.forEach(field => {
                    if (field.type === 'file') {
                        if (!field.files.length) {
                            isValid = false;
                            dropArea.style.borderColor = '#ef4444';
                        } else {
                            dropArea.style.borderColor = '#dee2e6';
                        }
                    } else if (!field.value.trim()) {
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