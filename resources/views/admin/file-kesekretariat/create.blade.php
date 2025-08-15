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
        /* Base Styles */
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
            padding: 2rem;
        }

        .section-header {
            color: #0b153a;
            font-weight: 700;
            font-size: 1.6rem;
            margin-bottom: 1.5rem;
        }

        /* Form Elements */
        .form-label {
            font-weight: 600;
            color: #495057;
            font-size: 0.95rem;
        }

        .form-control,
        .form-select,
        .form-textarea {
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 0.95rem;
            border: 1px solid #ced4da;
        }

        .form-control:focus,
        .form-select:focus,
        .form-textarea:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.2);
        }

        /* File Upload Area */
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

        /* Buttons */
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

        .btn-secondary {
            background-color: #6c757d;
            border: none;
            border-radius: 8px;
            padding: 12px 24px;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        /* Error Handling */
        .invalid-feedback {
            font-size: 0.85rem;
            color: #e74c3c;
        }

        /* Layout */
        .form-row {
            margin-bottom: 1.5rem;
        }

        /* Preview Container */
        .file-preview-container {
            display: none;
            margin-top: 15px;
        }

        .file-preview {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 12px;
            border: 1px solid #e9ecef;
        }
    </style>
@endsection

@section('content')
    <div class="main-content">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center flex-wrap mb-4" style="padding: 20px 20px">
                <h3 class="fw-bold fs-2 mb-0 text-dark">Tambah File Kesekretariat</h3>
            </div>

            <div class="row">
                <div class="card card-form">
                    <div class="card-body p-4 p-md-5">
                        <h3 class="fw-bold mb-4">Tambah Data</h3>
                        <form action="{{ route('admin.file-kesekretariat.store') }}" method="POST"
                            enctype="multipart/form-data" id="fileUploadForm">
                            @csrf

                            <!-- Nama Dokumen -->
                            <div class="form-row row align-items-center">
                                <div class="col-md-3">
                                    <label for="nama_dokumen" class="form-label">Nama Dokumen <span
                                            class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" name="nama_dokumen" id="nama_dokumen"
                                        class="form-control @error('nama_dokumen') is-invalid @enderror"
                                        placeholder="Masukkan nama dokumen" value="{{ old('nama_dokumen') }}" required>
                                    @error('nama_dokumen')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- File Upload -->
                            <div class="form-row row align-items-start">
                                <div class="col-md-3">
                                    <label for="dokumen_file" class="form-label">File Dokumen</label>
                                    <p class="file-upload-hint">PDF, DOC, DOCX, XLS, XLSX (Max: 2MB)</p>
                                </div>
                                <div class="col-md-9">
                                    <label for="dokumen_file" class="file-upload-wrapper" id="dropArea">
                                        <input type="file" name="dokumen_file" id="dokumen_file"
                                            accept=".pdf,.doc,.docx,.xls,.xlsx"
                                            class="@error('dokumen_file') is-invalid @enderror">
                                        <div class="file-upload-icon-wrapper">
                                            <i class="fas fa-file-upload file-upload-icon"></i>
                                        </div>
                                        <div id="uploadContent">
                                            <p class="file-upload-text" id="file-name-display">
                                                Seret dan lepas file di sini, atau klik untuk mengunggah.
                                            </p>
                                            <p class="file-upload-hint">Format yang didukung: PDF, DOC, DOCX, XLS, XLSX</p>
                                        </div>
                                    </label>

                                    @error('dokumen_file')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror

                                    <div id="filePreviewContainer" class="file-preview-container">
                                        <div class="file-preview d-flex align-items-center">
                                            <i class="fas fa-file-alt me-3" id="filePreviewIcon"></i>
                                            <div>
                                                <p class="mb-1" id="filePreviewName"></p>
                                                <p class="text-muted small" id="filePreviewSize"></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="form-row row mt-4">
                                <div class="col-md-9 offset-md-3 d-flex justify-content-between">
                                    <button type="submit" class="btn btn-danger px-4">
                                        <i class="fas fa-save me-2"></i>Simpan File
                                    </button>
                                    <a href="{{ route('admin.file-kesekretariat.index') }}" class="btn btn-secondary px-4">
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
            const uploadInput = document.getElementById('dokumen_file');
            const dropArea = document.getElementById('dropArea');
            const previewContainer = document.getElementById('filePreviewContainer');
            const uploadContent = document.getElementById('uploadContent');
            const fileNameDisplay = document.getElementById('file-name-display');
            const filePreviewIcon = document.getElementById('filePreviewIcon');
            const filePreviewName = document.getElementById('filePreviewName');
            const filePreviewSize = document.getElementById('filePreviewSize');

            // Define allowed file types and size limit
            const allowedTypes = [
                'application/pdf',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'application/vnd.ms-excel',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
            ];
            const maxFileSize = 2 * 1024 * 1024; // 2MB in bytes

            // Function to get file icon
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

            // File input change handler
            uploadInput.addEventListener('change', function() {
                const file = this.files[0];
                handleFileSelection(file);
            });

            // Handle file selection
            function handleFileSelection(file) {
                if (file) {
                    // Validate file type
                    // Validate file type
                    if (!allowedTypes.includes(file.type)) {
                        const fileExt = '.' + file.name.split('.').pop().toLowerCase();
                        const allowedExt = ['.pdf', '.doc', '.docx', '.xls', '.xlsx'];

                        if (!allowedExt.includes(fileExt)) {
                            alert('Hanya file PDF, DOC, DOCX, XLS, atau XLSX yang diizinkan');+
                            uploadInput.value = '';
                            return;
                        }
                    }

                    // Validate file size
                    if (file.size > maxFileSize) {
                        alert('Ukuran file maksimal 2MB');
                        this.value = '';
                        return;
                    }

                    // Show preview
                    uploadContent.style.display = 'none';
                    previewContainer.style.display = 'block';

                    filePreviewIcon.className = getFileIcon(file.name);
                    filePreviewName.textContent = file.name;
                    filePreviewSize.textContent = formatFileSize(file.size);
                } else {
                    uploadContent.style.display = 'block';
                    previewContainer.style.display = 'none';
                }
            }

            // Drag and drop functionality
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, preventDefaults, false);
            });

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            ['dragenter', 'dragover'].forEach(eventName => {
                dropArea.addEventListener(eventName, highlight, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, unhighlight, false);
            });

            function highlight() {
                dropArea.style.borderColor = '#0d6efd';
                dropArea.style.backgroundColor = '#e6f0ff';
            }

            function unhighlight() {
                dropArea.style.borderColor = '#cfe2ff';
                dropArea.style.backgroundColor = '#edf5ff';
            }

            dropArea.addEventListener('drop', handleDrop, false);

            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;

                if (files.length) {
                    uploadInput.files = files;
                    handleFileSelection(files[0]);
                }
            }
        });
    </script>
@endsection
