    @extends('layouts.app')

    @section('pageTitle', 'Tambah Kegiatan Lainnya')
    @section('mainSection', 'Laporan Pertanggungjawaban')
    @section('subSection', 'Kegiatan Lainnya')
    @section('subSectionUrl', route('admin.laporan-lpj.kegiatan-lainnya.index'))
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
            }

            .file-upload-wrapper:hover {
                border-color: #0d6efd;
                background-color: #e6f0ff;
            }

            .file-upload-wrapper.dragover {
                border-color: #0d6efd;
                background-color: #e6f0ff;
                transform: scale(1.02);
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

            .preview-container {
                max-height: 300px;
                overflow-y: auto;
                margin-top: 15px;
                border: 1px solid #e9ecef;
                border-radius: 8px;
                padding: 15px;
                background-color: #f8f9fa;
            }

            .file-preview-item {
                display: flex;
                align-items: center;
                gap: 12px;
                padding: 10px;
                border: 1px solid #e9ecef;
                border-radius: 8px;
                background-color: white;
                margin-bottom: 8px;
                transition: all 0.2s ease;
            }

            .file-preview-item:hover {
                border-color: #0d6efd;
                box-shadow: 0 2px 8px rgba(13, 110, 253, 0.1);
            }

            .file-preview-item:last-child {
                margin-bottom: 0;
            }

            .preview-image {
                width: 50px;
                height: 50px;
                object-fit: cover;
                border-radius: 6px;
                border: 1px solid #e9ecef;
            }

            .file-icon {
                width: 50px;
                height: 50px;
                display: flex;
                align-items: center;
                justify-content: center;
                background-color: #f8f9fa;
                border-radius: 6px;
                border: 1px solid #e9ecef;
            }

            .file-info {
                flex: 1;
            }

            .file-name {
                font-weight: 500;
                color: #212529;
                margin-bottom: 4px;
                word-break: break-all;
            }

            .file-size {
                font-size: 0.8rem;
                color: #6c757d;
            }

            .remove-file {
                background: none;
                border: none;
                color: #dc3545;
                font-size: 1.2rem;
                cursor: pointer;
                padding: 5px;
                border-radius: 4px;
                transition: all 0.2s ease;
            }

            .remove-file:hover {
                background-color: #dc3545;
                color: white;
            }

            .file-counter {
                font-size: 0.85rem;
                color: #6c757d;
                margin-top: 8px;
            }

            .max-files-warning {
                color: #e74c3c;
                font-size: 0.85rem;
                margin-top: 8px;
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
                            <form action="{{ route('admin.laporan-lpj.kegiatan-lainnya.store') }}" method="POST"
                                enctype="multipart/form-data" id="kegiatan-form">
                                @csrf

                                <!-- 1. Nama Program & Kegiatan -->
                                <div class="row align-items-center mb-3">
                                    <div class="col-md-3">
                                        <label for="nama_program_kegiatan" class="form-label">
                                            Nama Program & Kegiatan
                                            <span class="text-danger">*</span>
                                        </label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" name="nama_program_kegiatan" id="nama_program_kegiatan"
                                            class="form-control @error('nama_program_kegiatan') is-invalid @enderror"
                                            placeholder="Masukkan nama program dan kegiatan"
                                            value="{{ old('nama_program_kegiatan') }}" required>
                                        @error('nama_program_kegiatan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- 2. Jenis Kegiatan -->
                                <div class="row align-items-center mb-3">
                                    <div class="col-md-3">
                                        <label for="jenis_kegiatan" class="form-label">
                                            Jenis Kegiatan
                                            <span class="text-danger">*</span>
                                        </label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" name="jenis_kegiatan" id="jenis_kegiatan"
                                            class="form-control @error('jenis_kegiatan') is-invalid @enderror"
                                            placeholder="Contoh: Rapat, Pelatihan, Pembelian"
                                            value="{{ old('jenis_kegiatan') }}" required>
                                        @error('jenis_kegiatan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- 3. Volume -->
                                <div class="row align-items-center mb-3">
                                    <div class="col-md-3">
                                        <label for="volume" class="form-label">
                                            Volume
                                            <span class="text-danger">*</span>
                                        </label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" name="volume" id="volume"
                                            class="form-control @error('volume') is-invalid @enderror"
                                            placeholder="Masukkan volume kegiatan (contoh: 20 unit, 1 kegiatan)"
                                            value="{{ old('volume') }}" required>
                                        @error('volume')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- 4. Jumlah Harga Satuan -->
                                <div class="row align-items-center mb-3">
                                    <div class="col-md-3">
                                        <label for="jumlah_harga_satuan" class="form-label">
                                            Jumlah Harga Satuan
                                            <span class="text-danger">*</span>
                                        </label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="number" name="jumlah_harga_satuan" id="jumlah_harga_satuan"
                                            class="form-control @error('jumlah_harga_satuan') is-invalid @enderror"
                                            placeholder="Masukkan jumlah harga satuan"
                                            value="{{ old('jumlah_harga_satuan') }}" required min="0" step="0.01">
                                        @error('jumlah_harga_satuan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- 5. Jumlah Harga -->
                                <div class="row align-items-center mb-3">
                                    <div class="col-md-3">
                                        <label for="jumlah_harga" class="form-label">
                                            Jumlah Harga
                                            <span class="text-danger">*</span>
                                        </label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="number" name="jumlah_harga" id="jumlah_harga"
                                            class="form-control @error('jumlah_harga') is-invalid @enderror"
                                            placeholder="Masukkan jumlah harga" value="{{ old('jumlah_harga') }}" required
                                            min="0" step="0.01">
                                        @error('jumlah_harga')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- 6. Foto Jurnal Upload -->
                                <div class="row align-items-start mb-4">
                                    <div class="col-md-3">
                                        <label class="form-label">Foto Jurnal <span class="text-danger">*</span></label>
                                        <p class="file-upload-hint">Format: JPG, PNG, GIF (Maks. 10MB)</p>
                                    </div>
                                    <div class="col-md-9">
                                        <label for="foto_jurnal" class="file-upload-wrapper">
                                            <input type="file" name="foto_jurnal[]" id="foto_jurnal"
                                                accept="image/jpeg,image/jpg,image/png,image/gif" multiple required>

                                            <div class="d-flex align-items-center gap-12">
                                                <div class="file-upload-icon-wrapper">
                                                    <i class="fas fa-upload file-upload-icon"></i>
                                                </div>
                                                <div>
                                                    <p class="file-upload-text" id="foto-file-name-display">
                                                        Seret dan lepas foto di sini, atau klik untuk mengunggah.
                                                    </p>
                                                </div>
                                            </div>
                                        </label>

                                        <div id="fotoPreviewContainer" class="preview-container" style="display: none;">
                                        </div>
                                        <div id="fotoCounter" class="file-counter"></div>
                                        <div id="fotoMaxWarning" class="max-files-warning" style="display: none;">
                                            Foto jurnal wajib diisi.
                                        </div>

                                        @error('foto_jurnal')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- 7. Dokumen Pendukung Upload -->
                                <div class="row align-items-start mb-4">
                                    <div class="col-md-3">
                                        <label class="form-label">Dokumen Pendukung</label>
                                        <p class="file-upload-hint">Format: PDF, DOC, XLS (Maks. 10MB)</p>
                                    </div>
                                    <div class="col-md-9">
                                        <label for="dokumen_pendukung" class="file-upload-wrapper">
                                            <input type="file" name="dokumen_pendukung[]" id="dokumen_pendukung"
                                                accept=".pdf,.doc,.docx,.xls,.xlsx" multiple>

                                            <div class="d-flex align-items-center gap-12">
                                                <div class="file-upload-icon-wrapper">
                                                    <i class="fas fa-upload file-upload-icon"></i>
                                                </div>
                                                <div>
                                                    <p class="file-upload-text" id="dokumen-file-name-display">
                                                        Seret dan lepas dokumen di sini, atau klik untuk mengunggah.
                                                    </p>
                                                </div>
                                            </div>
                                        </label>

                                        <div id="dokumenPreviewContainer" class="preview-container"
                                            style="display: none;">
                                        </div>
                                        <div id="dokumenCounter" class="file-counter"></div>
                                        <div id="dokumenMaxWarning" class="max-files-warning" style="display: none;">
                                            Dokumen tidak wajib diisi.
                                        </div>

                                        @error('dokumen_pendukung')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- 8. Keterangan Tambahan -->
                                <div class="row align-items-center mb-3">
                                    <div class="col-md-3">
                                        <label for="keterangan_tambahan" class="form-label">
                                            Keterangan Tambahan
                                        </label>
                                    </div>
                                    <div class="col-md-9">
                                        <textarea name="keterangan_tambahan" id="keterangan_tambahan"
                                            class="form-control @error('keterangan_tambahan') is-invalid @enderror"
                                            placeholder="Masukkan keterangan tambahan (opsional)" rows="3">{{ old('keterangan_tambahan') }}</textarea>
                                        @error('keterangan_tambahan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-md-9 offset-md-3">
                                        <div class="d-flex gap-2">
                                            <button type="submit" class="btn btn-danger px-4" id="submit-button">Simpan
                                                Data</button>
                                            <a href="{{ route('admin.laporan-lpj.kegiatan-lainnya.index') }}"
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
            document.addEventListener('DOMContentLoaded', function() {
                const MAX_FILES = 10; // Single file for kegiatan lainnya
                const MAX_FILE_SIZE = 10 * 1024 * 1024;

                let selectedFotoFiles = [];
                let selectedDokumenFiles = [];

                const fotoInput = document.getElementById('foto_jurnal');
                const fotoPreviewContainer = document.getElementById('fotoPreviewContainer');
                const fotoFileNameDisplay = document.getElementById('foto-file-name-display');
                const fotoCounter = document.getElementById('fotoCounter');
                const fotoMaxWarning = document.getElementById('fotoMaxWarning');

                fotoInput.addEventListener('change', function() {
                    handleFileSelection(this.files, 'foto');
                });

                const dokumenInput = document.getElementById('dokumen_pendukung');
                const dokumenPreviewContainer = document.getElementById('dokumenPreviewContainer');
                const dokumenFileNameDisplay = document.getElementById('dokumen-file-name-display');
                const dokumenCounter = document.getElementById('dokumenCounter');
                const dokumenMaxWarning = document.getElementById('dokumenMaxWarning');

                dokumenInput.addEventListener('change', function() {
                    handleFileSelection(this.files, 'dokumen');
                });

                function handleFileSelection(files, type) {
                    const isPhoto = type === 'foto';
                    const input = isPhoto ? fotoInput : dokumenInput;

                    const newFiles = Array.from(files).filter(file => {
                        if (file.size > MAX_FILE_SIZE) {
                            alert(`File "${file.name}" terlalu besar. Maksimal 10MB per file.`);
                            return false;
                        }

                        if (isPhoto && !file.type.match('image.*')) {
                            alert(`File "${file.name}" bukan file gambar yang valid.`);
                            return false;
                        }

                        if (!isPhoto) {
                            const validExtensions = ['pdf', 'doc', 'docx', 'xls', 'xlsx'];
                            const extension = file.name.split('.').pop().toLowerCase();
                            if (!validExtensions.includes(extension)) {
                                alert(`File "${file.name}" format tidak didukung.`);
                                return false;
                            }
                        }

                        return true;
                    });

                    if (newFiles.length === 0) return;

                    // For single file upload, replace existing file
                    // Tambahkan file baru (maksimal 10)
                    const currentFiles = isPhoto ? selectedFotoFiles : selectedDokumenFiles;
                    const totalFiles = currentFiles.length + newFiles.length;

                    if (totalFiles > MAX_FILES) {
                        alert(`Maksimal ${MAX_FILES} file yang diizinkan.`);
                        return;
                    }

                    if (isPhoto) {
                        selectedFotoFiles.push(...newFiles);
                    } else {
                        selectedDokumenFiles.push(...newFiles);
                    }

                    updateFilePreview(type);
                    updateFileInput(type);
                }

                function updateFilePreview(type) {
                    const isPhoto = type === 'foto';
                    const files = isPhoto ? selectedFotoFiles : selectedDokumenFiles;
                    const container = isPhoto ? fotoPreviewContainer : dokumenPreviewContainer;
                    const counter = isPhoto ? fotoCounter : dokumenCounter;
                    const maxWarning = isPhoto ? fotoMaxWarning : dokumenMaxWarning;
                    const nameDisplay = isPhoto ? fotoFileNameDisplay : dokumenFileNameDisplay;

                    if (files.length === 0) {
                        container.style.display = 'none';
                        counter.textContent = '';
                        maxWarning.style.display = 'none';
                        nameDisplay.textContent = isPhoto ?
                            'Seret dan lepas foto di sini, atau klik untuk mengunggah.' :
                            'Seret dan lepas dokumen di sini, atau klik untuk mengunggah.';
                        return;
                    }

                    container.style.display = 'block';
                    nameDisplay.textContent = `${files.length} file dipilih`;
                    counter.textContent = `${files.length} file dipilih`;

                    let previewHTML = '';
                    files.forEach((file, index) => {
                        let fileSize = (file.size / 1024).toFixed(1) + ' KB';
                        if (file.size > 1024 * 1024) {
                            fileSize = (file.size / (1024 * 1024)).toFixed(1) + ' MB';
                        }

                        if (isPhoto) {
                            const imageUrl = URL.createObjectURL(file);
                            previewHTML += `
                <div class="file-preview-item" data-index="${index}">
                    <img src="${imageUrl}" alt="Preview" class="preview-image">
                    <div class="file-info">
                        <div class="file-name">${file.name}</div>
                        <div class="file-size">${fileSize}</div>
                    </div>
                    <button type="button" class="remove-file" onclick="removeFile(${index}, '${type}')">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
                        } else {
                            const extension = file.name.split('.').pop().toLowerCase();
                            const iconClass = getFileIcon(extension);
                            const colorClass = getFileColor(extension);

                            previewHTML += `
                <div class="file-preview-item" data-index="${index}">
                    <div class="file-icon">
                        <i class="${iconClass} ${colorClass} fs-4"></i>
                    </div>
                    <div class="file-info">
                        <div class="file-name">${file.name}</div>
                        <div class="file-size">${fileSize}</div>
                    </div>
                    <button type="button" class="remove-file" onclick="removeFile(${index}, '${type}')">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
                        }
                    });

                    container.innerHTML = previewHTML;
                }

                function updateFileInput(type) {
                    const isPhoto = type === 'foto';
                    const files = isPhoto ? selectedFotoFiles : selectedDokumenFiles;
                    const input = isPhoto ? fotoInput : dokumenInput;

                    const dt = new DataTransfer();
                    files.forEach(file => {
                        dt.items.add(file);
                    });
                    input.files = dt.files;
                }

                window.removeFile = function(index, type) {
                    const isPhoto = type === 'foto';
                    const files = isPhoto ? selectedFotoFiles : selectedDokumenFiles;
                    const file = files[index];

                    if (isPhoto && file) {
                        const imgElements = document.querySelectorAll('.preview-image');
                        imgElements.forEach(img => {
                            if (img.src && img.src.startsWith('blob:')) {
                                URL.revokeObjectURL(img.src);
                            }
                        });
                    }

                    if (isPhoto) {
                        selectedFotoFiles.splice(index, 1);
                    } else {
                        selectedDokumenFiles.splice(index, 1);
                    }

                    updateFilePreview(type);
                    updateFileInput(type);
                };

                function getFileIcon(extension) {
                    const icons = {
                        'pdf': 'fas fa-file-pdf',
                        'doc': 'fas fa-file-word',
                        'docx': 'fas fa-file-word',
                        'xls': 'fas fa-file-excel',
                        'xlsx': 'fas fa-file-excel',
                        'ppt': 'fas fa-file-powerpoint',
                        'pptx': 'fas fa-file-powerpoint'
                    };
                    return icons[extension] || 'fas fa-file';
                }

                function getFileColor(extension) {
                    const colors = {
                        'pdf': 'text-danger',
                        'doc': 'text-primary',
                        'docx': 'text-primary',
                        'xls': 'text-success',
                        'xlsx': 'text-success',
                        'ppt': 'text-warning',
                        'pptx': 'text-warning'
                    };
                    return colors[extension] || 'text-muted';
                }

                // Drag and drop functionality
                const fileUploadWrappers = document.querySelectorAll('.file-upload-wrapper');

                fileUploadWrappers.forEach(wrapper => {
                    wrapper.addEventListener('dragover', (e) => {
                        e.preventDefault();
                        wrapper.classList.add('dragover');
                    });

                    wrapper.addEventListener('dragleave', () => {
                        wrapper.classList.remove('dragover');
                    });

                    wrapper.addEventListener('drop', (e) => {
                        e.preventDefault();
                        wrapper.classList.remove('dragover');

                        const input = wrapper.querySelector('input[type="file"]');
                        if (e.dataTransfer.files.length && input) {
                            const type = input.id === 'foto_jurnal' ? 'foto' : 'dokumen';
                            handleFileSelection(e.dataTransfer.files, type);
                        }
                    });
                });

                // Auto calculate for numeric fields
                const volumeInput = document.getElementById('volume');
                const hargaSatuanInput = document.getElementById('jumlah_harga_satuan');
                const jumlahHargaInput = document.getElementById('jumlah_harga');

                function calculateTotal() {
                    const volume = parseFloat(volumeInput.value) || 0;
                    const hargaSatuan = parseFloat(hargaSatuanInput.value) || 0;
                    const total = hargaSatuan * (volume || 1);
                    jumlahHargaInput.value = total;
                }

                hargaSatuanInput.addEventListener('input', calculateTotal);
                volumeInput.addEventListener('input', function() {
                    const volumeValue = this.value;
                    const numericVolume = parseFloat(volumeValue.replace(/[^\d.]/g, ''));
                    if (!isNaN(numericVolume)) {
                        calculateTotal();
                    }
                });

                // Form validation
                const form = document.getElementById('kegiatan-form');
                const submitButton = document.getElementById('submit-button');

                form.addEventListener('submit', function(e) {
                    if (!validateForm()) {
                        e.preventDefault();
                    } else {
                        submitButton.disabled = true;
                        submitButton.innerHTML = `
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Menyimpan...
                        `;
                    }
                });

                function validateForm() {
                    let isValid = true;

                    const requiredFields = form.querySelectorAll('[required]');
                    requiredFields.forEach(field => {
                        if (field.name === 'foto_jurnal' && selectedFotoFiles.length === 0) {
                            field.classList.add('is-invalid');
                            isValid = false;
                        } else if (field.type !== 'file' && !field.value.trim()) {
                            field.classList.add('is-invalid');
                            isValid = false;
                        } else {
                            field.classList.remove('is-invalid');
                        }
                    });

                    return isValid;
                }
            });
        </script>
    @endsection
