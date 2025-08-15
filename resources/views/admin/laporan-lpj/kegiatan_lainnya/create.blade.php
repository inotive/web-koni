@extends('layouts.app')

@section('pageTitle', 'Tambah Kegiatan Lainnya')
@section('mainSection', 'Laporan Pertanggungjawaban')
@section('subSection', 'Kegiatan Lainnya')
@section('subSectionUrl', route('admin.laporan-lpj.kegiatan_lainnya.index'))
@section('currentSection', 'Tambah Kegiatan Lainnya')

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

        .required:after {
    content: " *";
    color: #F8285A;
}

.is-invalid {
    border-color: #dc3545 !important;
}

.is-invalid:focus {
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
}

/* Style untuk placeholder */
.form-control::placeholder {
    color: #9ca3af;
    font-size: 0.9rem;
}

.file-upload-text[data-has-file] {
    font-weight: 500;
    color: #0b153a;
    font-style: normal;
}

.file-upload-text:not([data-has-file]) {
    color: #6b7280;
    font-style: italic;
}
    </style>

    <div class="d-flex justify-content-between align-items-center flex-wrap mb-4" style="padding: 20px 20px">
        <h3 class="fw-bold fs-2 mb-0 text-dark">Tambah Kegiatan Lainnya</h3>
    </div>

    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="card card-form">
                    <div class="card-body p-4 p-md-5">
                        <h3 class="fw-bold mb-4">Tambah Data</h3>
                        <form action="{{ route('admin.laporan-lpj.kegiatan_lainnya.store') }}" method="POST"
    enctype="multipart/form-data" id="kegiatan-form">
    @csrf

    <!-- Foto Jurnal Upload -->
    <div class="row align-items-start mb-4">
        <div class="col-md-3">
            <label class="form-label required">Foto Jurnal</label>
            <p class="file-upload-hint">Format: JPG, PNG, GIF (Maks. 10MB)</p>
        </div>
        <div class="col-md-9">
            <label for="foto_jurnal" class="file-upload-wrapper">
                <input type="file" name="foto_jurnal" id="foto_jurnal"
                    class="@error('foto_jurnal') is-invalid @enderror"
                    accept="image/jpeg,image/jpg,image/png,image/gif" required>

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
            <div id="foto-error" class="invalid-feedback d-none">Foto jurnal wajib diisi</div>
        </div>
    </div>

    <!-- Dokumen Pendukung Upload -->
    <div class="row align-items-start mb-4">
        <div class="col-md-3">
            <label class="form-label">Dokumen Pendukung</label>
            <p class="file-upload-hint">Format: PDF, DOC, XLS (Maks. 10MB)</p>
        </div>
        <div class="col-md-9">
            <label for="dokumen_pendukung" class="file-upload-wrapper">
                <input type="file" name="dokumen_pendukung" id="dokumen_pendukung"
                    class="form-control @error('dokumen_pendukung') is-invalid @enderror"
                    accept=".pdf,.doc,.docx,.xls,.xlsx">

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
        </div>
    </div>

    @php
        $fields = [
            'nama_program_kegiatan' => [
                'label' => 'Nama Program & Kegiatan',
                'type' => 'text',
                'placeholder' => 'Masukkan nama program dan kegiatan',
                'required' => true
            ],
            'jenis_kegiatan' => [
                'label' => 'Jenis Kegiatan',
                'type' => 'text',
                'placeholder' => 'Contoh: Rapat, Pelatihan, Pembelian',
                'required' => true
            ],
            'volume' => [
                'label' => 'Volume',
                'type' => 'text',
                'placeholder' => 'Masukkan volume kegiatan (contoh: 20 unit, 1 kegiatan)',
                'required' => true
            ],
            'jumlah_harga_satuan' => [
                'label' => 'Jumlah Harga Satuan',
                'type' => 'number',
                'placeholder' => 'Contoh: 250000 (hanya angka, tanpa titik/koma)',
                'required' => true
            ],
            'jumlah_harga' => [
                'label' => 'Jumlah Harga',
                'type' => 'number',
                'placeholder' => 'Contoh: 5000000 (hanya angka, tanpa titik/koma)',
                'required' => true
            ],
            'keterangan_tambahan' => [
                'label' => 'Keterangan Tambahan',
                'type' => 'text',
                'placeholder' => 'Masukkan keterangan tambahan (opsional)',
                'required' => false
            ],
        ];
    @endphp

    @foreach ($fields as $key => $field)
        <div class="row align-items-center mb-3">
            <div class="col-md-3">
                <label for="{{ $key }}" class="form-label @if($field['required']) required @endif">
                    {{ $field['label'] }}
                </label>
            </div>
            <div class="col-md-9">
                <input type="{{ $field['type'] }}" name="{{ $key }}"
                    id="{{ $key }}"
                    class="form-control @error($key) is-invalid @enderror"
                    placeholder="{{ $field['placeholder'] ?? '' }}"
                    value="{{ old($key) }}"
                    @if($field['required']) required @endif>

                @error($key)
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    @endforeach

    <div class="row mt-4">
        <div class="col-md-9 offset-md-3 d-flex justify-content-between">
            <button type="submit" class="btn btn-danger px-4" id="submit-button">Simpan Data</button>
            <a href="{{ route('admin.laporan-lpj.kegiatan_lainnya.index') }}"
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
    // File upload preview functionality
    const fotoUploadInput = document.getElementById('foto_jurnal');
    const fotoPreviewContainer = document.getElementById('fotoPreviewContainer');
    const fotoFileNameDisplay = document.getElementById('foto-file-name-display');
    
    const dokumenUploadInput = document.getElementById('dokumen_pendukung');
    const dokumenPreviewContainer = document.getElementById('dokumenPreviewContainer');
    const dokumenFileNameDisplay = document.getElementById('dokumen-file-name-display');
    
    // Form validation
    const form = document.getElementById('kegiatan-form');
    const submitButton = document.getElementById('submit-button');
    
    // File upload handling
    fotoUploadInput.addEventListener('change', function() {
        handleFileUpload(this, fotoFileNameDisplay, fotoPreviewContainer, true);
    });
    
    dokumenUploadInput.addEventListener('change', function() {
        handleFileUpload(this, dokumenFileNameDisplay, dokumenPreviewContainer, false);
    });
    
    // Form submission
    form.addEventListener('submit', function(e) {
        if (!validateForm()) {
            e.preventDefault();
        } else {
            // Disable button to prevent double submission
            submitButton.disabled = true;
            submitButton.innerHTML = `
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                Menyimpan...
            `;
        }
    });
    
    // Real-time validation
    form.querySelectorAll('input, textarea').forEach(input => {
        input.addEventListener('input', function() {
            if (this.hasAttribute('required') && this.value.trim()) {
                this.classList.remove('is-invalid');
                const errorMsg = this.nextElementSibling;
                if (errorMsg && errorMsg.classList.contains('invalid-feedback')) {
                    errorMsg.remove();
                }
            }
        });
    });
    
    // Helper functions
    function handleFileUpload(input, displayElement, previewContainer, isImage) {
        const file = input.files[0];
        
        if (file) {
            // Validate file type and size
            if (isImage && !file.type.match('image.*')) {
                showError(input, 'File harus berupa gambar');
                return;
            }
            
            if (!isImage) {
                const validExtensions = ['pdf', 'doc', 'docx', 'xls', 'xlsx'];
                const extension = file.name.split('.').pop().toLowerCase();
                if (!validExtensions.includes(extension)) {
                    showError(input, 'Format dokumen tidak didukung');
                    return;
                }
            }
            
            if (file.size > 10 * 1024 * 1024) {
                showError(input, 'File terlalu besar (maksimal 10MB)');
                return;
            }
            
            // Clear previous preview
            previewContainer.innerHTML = '';
            
            // Display file info
            displayElement.textContent = file.name;
            displayElement.setAttribute('data-has-file', 'true');
            
            if (isImage) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imageDiv = document.createElement('div');
                    imageDiv.innerHTML = `
                        <img src="${e.target.result}" class="preview-image" alt="Preview">
                    `;
                    previewContainer.appendChild(imageDiv);
                };
                reader.readAsDataURL(file);
            } else {
                const fileDiv = document.createElement('div');
                fileDiv.className = 'file-item';
                fileDiv.innerHTML = `
                    <i class="${getFileIcon(file.name)}"></i>
                    <span class="file-name" title="${file.name}">${file.name}</span>
                `;
                previewContainer.appendChild(fileDiv);
            }
            
            // Clear any previous errors
            input.classList.remove('is-invalid');
            const errorMsg = input.nextElementSibling;
            if (errorMsg && errorMsg.classList.contains('invalid-feedback')) {
                errorMsg.remove();
            }
        } else {
            // No file selected - reset display
            displayElement.textContent = 'Seret dan lepas file di sini, atau klik untuk mengunggah';
            displayElement.removeAttribute('data-has-file');
            previewContainer.innerHTML = '';
        }
    }
    
    function validateForm() {
        let isValid = true;
        
        // Validate required fields
        const requiredFields = form.querySelectorAll('[required]');
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                field.classList.add('is-invalid');
                
                // Add error message if not exists
                if (!field.nextElementSibling || !field.nextElementSibling.classList.contains('invalid-feedback')) {
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'invalid-feedback';
                    errorDiv.textContent = 'Field ini wajib diisi';
                    field.parentNode.insertBefore(errorDiv, field.nextSibling);
                }
                
                isValid = false;
            }
        });
        
        // Validate file uploads
        if (!fotoUploadInput.files || fotoUploadInput.files.length === 0) {
            document.getElementById('foto-error').classList.remove('d-none');
            isValid = false;
        } else {
            document.getElementById('foto-error').classList.add('d-none');
        }
        
        // Scroll to first error if any
        if (!isValid) {
            const firstError = form.querySelector('.is-invalid');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }
        
        return isValid;
    }
    
    function showError(input, message) {
        input.value = '';
        input.classList.add('is-invalid');
        
        // Add or update error message
        let errorMsg = input.nextElementSibling;
        if (!errorMsg || !errorMsg.classList.contains('invalid-feedback')) {
            errorMsg = document.createElement('div');
            errorMsg.className = 'invalid-feedback';
            input.parentNode.insertBefore(errorMsg, input.nextSibling);
        }
        errorMsg.textContent = message;
    }
    
    function getFileIcon(fileName) {
        const extension = fileName.split('.').pop().toLowerCase();
        switch(extension) {
            case 'pdf': return 'fas fa-file-pdf';
            case 'doc':
            case 'docx': return 'fas fa-file-word';
            case 'xls':
            case 'xlsx': return 'fas fa-file-excel';
            default: return 'fas fa-file-alt';
        }
    }
    
    // Drag and drop functionality
    const setupDragAndDrop = (wrapper, input) => {
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            wrapper.addEventListener(eventName, preventDefaults, false);
        });
        
        ['dragenter', 'dragover'].forEach(eventName => {
            wrapper.addEventListener(eventName, highlight, false);
        });
        
        ['dragleave', 'drop'].forEach(eventName => {
            wrapper.addEventListener(eventName, unhighlight, false);
        });
        
        wrapper.addEventListener('drop', function(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            input.files = files;
            input.dispatchEvent(new Event('change'));
        });
        
        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }
        
        function highlight() {
            this.style.borderColor = '#0d6efd';
            this.style.backgroundColor = '#e6f0ff';
        }
        
        function unhighlight() {
            this.style.borderColor = '#cfe2ff';
            this.style.backgroundColor = '#edf5ff';
        }
    };
    
    setupDragAndDrop(document.querySelector('label[for="foto_jurnal"]'), fotoUploadInput);
    setupDragAndDrop(document.querySelector('label[for="dokumen_pendukung"]'), dokumenUploadInput);
});
</script>

@endsection