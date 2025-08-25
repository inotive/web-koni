@extends('layouts.app')

@section('pageTitle', 'Edit File')
@section('mainSection', 'File Kesekretariat')
@section('mainSectionUrl', route('admin.file-kesekretariat.index'))
@section('currentSection', 'Edit File')

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

        .current-file {
            background-color: #e8f5e8;
            border: 1px solid #c3e6c3;
            border-radius: 8px;
            padding: 12px 16px;
            margin-bottom: 15px;
        }

        .current-file-icon {
            color: #28a745;
            font-size: 1.2rem;
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

        .btn-download {
            background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
            border: none;
            border-radius: 6px;
            padding: 6px 12px;
            color: white;
            font-size: 0.85rem;
            font-weight: 500;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-download:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(23, 162, 184, 0.3);
            color: white;
            text-decoration: none;
        }

        /* Toast notification styles */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }

        .toast {
            min-width: 350px;
            background-color: white;
            border-left: 4px solid;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            border-radius: 8px;
        }

        .toast.success {
            border-left-color: #10b981;
        }

        .toast.error {
            border-left-color: #ef4444;
        }

        .toast-header {
            background-color: transparent;
            border-bottom: 1px solid #f3f4f6;
            padding: 16px 20px 12px;
            font-weight: 600;
        }

        .toast-body {
            padding: 12px 20px 16px;
            font-size: 14px;
            line-height: 1.5;
        }

        .toast .btn-close {
            margin: 0;
            padding: 0;
        }

        /* Loading overlay */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9998;
        }

        .loading-content {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .loading-spinner-large {
            width: 40px;
            height: 40px;
            border: 3px solid #f3f4f6;
            border-top: 3px solid #6366f1;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 1rem;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .loading-spinner {
            width: 16px;
            height: 16px;
            border: 2px solid transparent;
            border-top: 2px solid currentColor;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            display: inline-block;
            margin-right: 8px;
        }
    </style>

    {{-- Toast Notification Container --}}
    <div class="toast-container" id="toast-container"></div>

    {{-- Loading Overlay --}}
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-content">
            <div class="loading-spinner-large"></div>
            <h5>Menyimpan perubahan...</h5>
            <p class="text-muted mb-0">Mohon tunggu sebentar</p>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center flex-wrap mb-4" style="padding: 20px 20px">
        <h3 class="fw-bold fs-2 mb-0 text-dark">Edit File Kesekretariat</h3>
    </div>

    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="card card-form">
                    <div class="card-body p-4 p-md-5">
                        <h3 class="fw-bold mb-4">Edit Data</h3>
                        <form id="editFileForm" action="{{ route('admin.file-kesekretariat.update', $fileKesekretariat) }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Nama Dokumen -->
                            <div class="row align-items-center mb-4">
                                <div class="col-md-3">
                                    <label for="nama_dokumen" class="form-label">Nama Dokumen <span
                                            class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" name="nama_dokumen" id="nama_dokumen"
                                        class="form-control @error('nama_dokumen') is-invalid @enderror"
                                        placeholder="Contoh: Surat Keputusan Januari 2025"
                                        value="{{ old('nama_dokumen', $fileKesekretariat->nama_dokumen) }}" required>
                                    @error('nama_dokumen')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Dokumen Upload -->
                            <div class="row align-items-start mb-4">
                                <div class="col-md-3">
                                    <label for="dokumen_file" class="form-label">Dokumen File</label>
                                    <p class="file-upload-hint">PDF, DOC, DOCX, XLS, XLSX (Max: 10MB)</p>
                                </div>
                                <div class="col-md-9">
                                    <!-- Current File Display -->
                                    @if ($fileKesekretariat->dokumen_file)
                                        <div class="current-file">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="d-flex align-items-center">
                                                    @php
                                                        $extension = pathinfo(
                                                            $fileKesekretariat->dokumen_file,
                                                            PATHINFO_EXTENSION,
                                                        );
                                                        $iconMap = [
                                                            'pdf' => 'fa-file-pdf',
                                                            'doc' => 'fa-file-word',
                                                            'docx' => 'fa-file-word',
                                                            'xls' => 'fa-file-excel',
                                                            'xlsx' => 'fa-file-excel',
                                                        ];
                                                        $iconClass = $iconMap[$extension] ?? 'fa-file-alt';
                                                    @endphp
                                                    <i class="fas {{ $iconClass }} current-file-icon me-2"></i>
                                                    <div>
                                                        <p class="mb-1 fw-medium">File saat ini:</p>
                                                        <p class="mb-0 text-muted small">
                                                            {{ $fileKesekretariat->dokumen_file }}</p>
                                                    </div>
                                                </div>
                                                <a href="{{ route('admin.file-kesekretariat.download', $fileKesekretariat) }}"
                                                    class="btn-download" target="_blank">
                                                    <i class="fas fa-download me-1"></i> Unduh
                                                </a>
                                            </div>
                                        </div>
                                    @endif

                                    <label for="dokumen_file" class="file-upload-wrapper" id="uploadContent">
                                        <input type="file" name="dokumen_file" id="dokumen_file"
                                            accept=".pdf,.doc,.docx,.xls,.xlsx"
                                            class="@error('dokumen_file') is-invalid @enderror">
                                        <div class="file-upload-icon-wrapper">
                                            <i class="fas fa-file-upload file-upload-icon"></i>
                                        </div>
                                        <div>
                                            <p class="file-upload-text mb-1" id="file-name-display">
                                                {{ $fileKesekretariat->dokumen_file ? 'Klik untuk mengubah dokumen' : 'Seret dan lepas file di sini, atau klik untuk mengunggah.' }}
                                            </p>
                                            <p class="file-upload-hint">
                                                {{ $fileKesekretariat->dokumen_file ? 'Kosongkan jika tidak ingin mengubah dokumen' : 'Format yang didukung: PDF, DOC, DOCX, XLS, XLSX' }}
                                            </p>
                                        </div>
                                    </label>

                                    @error('dokumen_file')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror

                                    <div id="filePreviewContainer" style="display: none; margin-top: 15px;">
                                        <div class="alert alert-info d-flex align-items-center">
                                            <i class="fas fa-file-alt me-2"></i>
                                            <span id="selected-file-name"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Buttons -->
                            <div class="row mt-4">
                                <div class="col-md-9 offset-md-3 d-flex justify-content-between">
                                    <button type="submit" class="btn btn-danger px-4" id="submitBtn">Simpan
                                        Perubahan</button>
                                    <a href="{{ route('admin.file-kesekretariat.index') }}"
                                        class="btn btn-secondary px-4">Kembali</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        $(document).ready(function() {
            let formDirty = false;

            // Show loading overlay
            function showLoading() {
                $('#loadingOverlay').show();
                $('#submitBtn').prop('disabled', true)
                    .html('<div class="loading-spinner"></div>Menyimpan...');
            }

            // Hide loading overlay
            function hideLoading() {
                $('#loadingOverlay').hide();
                $('#submitBtn').prop('disabled', false)
                    .html('Simpan Perubahan');
            }

            // Show notification
            function showNotification(message, type = 'success', duration = 5000) {
                const toastId = 'toast-' + Date.now();
                const iconMap = {
                    'success': 'fa-check-circle',
                    'error': 'fa-exclamation-circle',
                    'warning': 'fa-exclamation-triangle',
                    'info': 'fa-info-circle'
                };

                const titleMap = {
                    'success': 'Berhasil!',
                    'error': 'Error!',
                    'warning': 'Peringatan!',
                    'info': 'Informasi'
                };

                const toast = $(`
                <div class="toast ${type}" role="alert" id="${toastId}" data-bs-delay="${duration}">
                    <div class="toast-header">
                        <i class="fas ${iconMap[type]} me-2"></i>
                        <strong class="me-auto">${titleMap[type]}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
                    </div>
                    <div class="toast-body">${message}</div>
                </div>
            `);

                $('#toast-container').append(toast);
                toast.toast('show');

                // Auto remove after duration + 1 second
                setTimeout(() => {
                    $(`#${toastId}`).remove();
                }, duration + 1000);
            }

            // File upload handling
            const uploadInput = $('#dokumen_file');
            const previewContainer = $('#filePreviewContainer');
            const fileNameDisplay = $('#file-name-display');
            const selectedFileName = $('#selected-file-name');
            const uploadWrapper = $('.file-upload-wrapper');

            // File size formatter
            function formatFileSize(bytes) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
            }

            // Handle file selection
            uploadInput.on('change', function() {
                const file = this.files[0];

                if (file) {
                    // Validate file type
                    const allowedTypes = ['.pdf', '.doc', '.docx', '.xls', '.xlsx'];
                    const fileExtension = '.' + file.name.split('.').pop().toLowerCase();

                    if (!allowedTypes.includes(fileExtension)) {
                        showNotification(
                            'Format file tidak didukung. Hanya diperbolehkan: PDF, DOC, DOCX, XLS, XLSX',
                            'error');
                        this.value = '';
                        return;
                    }

                    // PERBAIKAN: Ubah dari 2MB ke 10MB (10 * 1024 * 1024 bytes)
                    const maxSize = 10 * 1024 * 1024; // 10MB sekarang, bukan 2MB
                    if (file.size > maxSize) {
                        showNotification('Ukuran file terlalu besar. Maksimal 10MB', 'error');
                        this.value = '';
                        return;
                    }

                    fileNameDisplay.textContent = file.name;
                    selectedFileName.textContent = file.name + ' (' + formatFileSize(file.size) + ')';
                    previewContainer.show();
                    formDirty = true;
                } else {
                    fileNameDisplay.textContent =
                        '{{ $fileKesekretariat->dokumen_file ? 'Klik untuk mengubah dokumen' : 'Seret dan lepas file di sini, atau klik untuk mengunggah.' }}';
                    previewContainer.hide();
                }
            });

            // Handle drag and drop
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                uploadWrapper[0].addEventListener(eventName, preventDefaults, false);
            });

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            ['dragenter', 'dragover'].forEach(eventName => {
                uploadWrapper[0].addEventListener(eventName, highlight, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                uploadWrapper[0].addEventListener(eventName, unhighlight, false);
            });

            function highlight() {
                uploadWrapper.css({
                    'border-color': '#0d6efd',
                    'background-color': '#e6f0ff'
                });
            }

            function unhighlight() {
                uploadWrapper.css({
                    'border-color': '#cfe2ff',
                    'background-color': '#edf5ff'
                });
            }

            uploadWrapper[0].addEventListener('drop', handleDrop, false);

            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;

                uploadInput[0].files = files;
                uploadInput.trigger('change');
            }

            // Form validation
            function validateForm() {
                let isValid = true;
                const namaDocumen = $('#nama_dokumen').val().trim();

                // Clear previous validation states
                $('.form-control').removeClass('is-invalid is-valid');
                $('.invalid-feedback').hide();

                // Validate nama dokumen
                if (!namaDocumen) {
                    $('#nama_dokumen').addClass('is-invalid');
                    isValid = false;
                } else if (namaDocumen.length < 3) {
                    $('#nama_dokumen').addClass('is-invalid');
                    isValid = false;
                } else {
                    $('#nama_dokumen').addClass('is-valid');
                }

                return isValid;
            }

            // Real-time validation
            $('#nama_dokumen').on('blur keyup', function() {
                const value = $(this).val().trim();
                $(this).removeClass('is-invalid is-valid');

                if (value && value.length >= 3) {
                    $(this).addClass('is-valid');
                } else if (value) {
                    $(this).addClass('is-invalid');
                }

                if (value !== '{{ old('nama_dokumen', $fileKesekretariat->nama_dokumen) }}') {
                    formDirty = true;
                }
            });

            // Form submission
            $('#editFileForm').on('submit', function(e) {
                e.preventDefault();

                // Validate form
                if (!validateForm()) {
                    showNotification('Mohon perbaiki kesalahan pada form sebelum melanjutkan', 'error');

                    // Focus on first invalid field
                    $('.is-invalid:first').focus();
                    return;
                }

                showLoading();

                // Create FormData for file upload
                const formData = new FormData(this);

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        hideLoading();

                        // Show success notification
                        showNotification('✅ Data berhasil disimpan!', 'success');

                        // Reset form dirty flag
                        formDirty = false;

                        // Redirect after 1.5 seconds
                        setTimeout(function() {
                            window.location.href =
                                "{{ route('admin.file-kesekretariat.index') }}";
                        }, 1500);
                    },
                    error: function(xhr) {
                        hideLoading();

                        if (xhr.status === 422) {
                            // Validation errors
                            const errors = xhr.responseJSON.errors;
                            let firstErrorField = null;

                            // Clear previous validation states
                            $('.form-control').removeClass('is-invalid');
                            $('.invalid-feedback').hide();

                            // Display validation errors
                            $.each(errors, function(field, messages) {
                                const fieldElement = $(`#${field}`);
                                if (fieldElement.length) {
                                    fieldElement.addClass('is-invalid');

                                    let errorHtml = '';
                                    messages.forEach(function(message) {
                                        errorHtml += message + '<br>';
                                    });

                                    fieldElement.siblings('.invalid-feedback')
                                        .html(errorHtml)
                                        .show();

                                    if (!firstErrorField) {
                                        firstErrorField = fieldElement;
                                    }
                                }
                            });

                            // Focus on first error field
                            if (firstErrorField) {
                                firstErrorField.focus();
                            }

                            showNotification(
                                'Terdapat kesalahan pada form. Mohon periksa kembali.',
                                'error');
                        } else if (xhr.status === 413) {
                            showNotification(
                                'File terlalu besar. Maksimal 10MB. Silakan pilih file yang lebih kecil.',
                                'error');
                        } else {
                            // Network or server error
                            showNotification(
                                'Terjadi kesalahan jaringan. Silakan periksa koneksi internet Anda dan coba lagi.',
                                'error', 7000);
                        }
                    }
                });
            });

            // Handle page unload warning if form is dirty
            $(window).on('beforeunload', function(e) {
                if (formDirty) {
                    const message =
                        'Anda memiliki perubahan yang belum disimpan. Apakah Anda yakin ingin meninggalkan halaman ini?';
                    e.returnValue = message;
                    return message;
                }
            });

            // Initialize tooltips
            $('[title]').tooltip();
        });
    </script>
@endsection
