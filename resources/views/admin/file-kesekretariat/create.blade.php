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

@section('style')
    <style>
        .form-label {
            font-weight: 600;
            color: #495057;
            font-size: 1rem;
        }

        .file-upload-wrapper {
            border: 2px dashed #dee2e6;
            border-radius: 8px;
            padding: 2rem;
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

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }

        .btn-success:hover {
            background-color: #218838;
            border-color: #218838;
        }

        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #5a6268;
        }
    </style>
@endsection

@section('content')
    <div class="d-grid gap-5 border-0">
        <div class="d-flex justify-content-between align-items-center container">
            <div class="d-none d-md-block">
                <h1>Tambah File Kesekretariat</h1>
                <span>Unggah dokumen file kesekretariat baru</span>
            </div>
        </div>

        <div class="container">
            <div class="rounded-4 gap-5 px-10 py-8" style="background-color: white; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);">
                <form action="{{ route('admin.file-kesekretariat.store') }}" method="POST"
                    enctype="multipart/form-data" id="fileUploadForm" class="d-grid gap-4">
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
                        <div class="d-grid gap-2">
                            <div class="fs-4 fw-bold">{{ $field['label'] }}</div>
                            <div>
                                @php
                                    $value = old($key, '');
                                @endphp
                                @if ($field['type'] === 'select')
                                    <select name="{{ $key }}" id="{{ $key }}"
                                        class="form-control border border-gray-600 @error($key) is-invalid @enderror"
                                        {{ $field['required'] ? 'required' : '' }}>
                                        <option value="">Pilih {{ $field['label'] }}</option>
                                        @foreach ($field['options'] as $option)
                                            <option value="{{ $option }}" {{ $value == $option ? 'selected' : '' }}>
                                                {{ $option }}</option>
                                        @endforeach
                                    </select>
                                @elseif ($field['type'] === 'textarea')
                                    <textarea name="{{ $key }}" id="{{ $key }}" 
                                        class="form-control border border-gray-600 @error($key) is-invalid @enderror"
                                        placeholder="{{ $field['placeholder'] }}" rows="3" 
                                        {{ $field['required'] ? 'required' : '' }}>{{ $value }}</textarea>
                                @else
                                    <input type="{{ $field['type'] }}" name="{{ $key }}"
                                        id="{{ $key }}" 
                                        class="form-control border border-gray-600 @error($key) is-invalid @enderror"
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

                    <div class="d-grid gap-2">
                        <div class="fs-4 fw-bold">File Dokumen</div>
                        <div>
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

                    <div class="d-flex gap-3 justify-content-end mt-4">
                        <a href="{{ route('admin.file-kesekretariat.index') }}"
                            class="btn btn-secondary px-4 py-2 fw-bold d-flex align-items-center gap-2 rounded border-0">
                            <i class="fas fa-arrow-left"></i>Batal
                        </a>
                        <button type="submit" 
                            class="btn btn-danger px-4 py-2 fw-bold d-flex align-items-center gap-2 rounded border-0">
                            <i class="fas fa-save"></i>Simpan File
                        </button>
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