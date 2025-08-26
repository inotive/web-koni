@extends('layouts.app')

@section('pageTitle', 'Edit Laporan Sekretariat')
@section('mainSection', 'Laporan Pertanggungjawaban')
@section('subSection', 'Sekretariat')
@section('subSectionUrl', route('admin.laporan-lpj.sekretariat.index'))
@section('currentSection', 'Edit Laporan')

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

        .currency-input {
            position: relative;
        }

        .currency-input::before {
            content: "Rp";
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            font-size: 0.95rem;
            z-index: 1;
        }

        .currency-input input {
            padding-left: 35px;
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

        .file-preview-item.existing {
            background-color: #e8f5e8;
            border-color: #28a745;
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

        .existing-files-section {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
        }

        .existing-files-section h6 {
            color: #495057;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .section-divider {
            border: none;
            height: 2px;
            background: linear-gradient(to right, #e9ecef, #dee2e6, #e9ecef);
            margin: 30px 0;
        }
    </style>

    <div class="d-flex justify-content-between align-items-center flex-wrap mb-4" style="padding: 20px 20px">
        <h3 class="fw-bold fs-2 mb-0 text-dark">Edit Laporan Sekretariat</h3>
    </div>

    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="card card-form">
                    <div class="card-body p-4 p-md-5">
                        <h3 class="fw-bold mb-4">Edit Laporan: {{ $sekretariat->nama_program_kegiatan }}</h3>

                        <form action="{{ route('admin.laporan-lpj.sekretariat.update', $sekretariat->id) }}"
                              method="POST"
                              id="lpjForm"
                              enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row align-items-center mb-3">
                                <div class="col-md-3">
                                    <label for="nama_program_kegiatan" class="form-label">
                                        Nama Program & Kegiatan <span class="text-danger">*</span>
                                    </label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" name="nama_program_kegiatan" id="nama_program_kegiatan"
                                        class="form-control @error('nama_program_kegiatan') is-invalid @enderror"
                                        placeholder="Masukkan nama program"
                                        value="{{ old('nama_program_kegiatan', $sekretariat->nama_program_kegiatan) }}" required>
                                    @error('nama_program_kegiatan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row align-items-center mb-3">
                                <div class="col-md-3">
                                    <label for="jenis_kegiatan" class="form-label">
                                        Jenis Kegiatan <span class="text-danger">*</span>
                                    </label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" name="jenis_kegiatan" id="jenis_kegiatan"
                                        class="form-control @error('jenis_kegiatan') is-invalid @enderror"
                                        placeholder="Masukkan nama kegiatan"
                                        value="{{ old('jenis_kegiatan', $sekretariat->jenis_kegiatan) }}" required>
                                    @error('jenis_kegiatan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row align-items-center mb-3">
                                <div class="col-md-3">
                                    <label for="volume" class="form-label">Volume</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" name="volume" id="volume"
                                        class="form-control @error('volume') is-invalid @enderror"
                                        placeholder="Masukkan volume (misal: 100 orang, 5 unit, dll)"
                                        value="{{ old('volume', $sekretariat->volume) }}">
                                    @error('volume')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row align-items-center mb-3">
                                <div class="col-md-3">
                                    <label for="jumlah_harga_satuan" class="form-label">Harga Satuan</label>
                                </div>
                                <div class="col-md-9">
                                    <div class="currency-input">
                                        <input type="text" name="jumlah_harga_satuan" id="jumlah_harga_satuan"
                                            class="form-control @error('jumlah_harga_satuan') is-invalid @enderror"
                                            placeholder="0"
                                            value="{{ old('jumlah_harga_satuan', $sekretariat->jumlah_harga_satuan) }}">
                                    </div>
                                    @error('jumlah_harga_satuan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row align-items-center mb-3">
                                <div class="col-md-3">
                                    <label for="jumlah_harga" class="form-label">Total Harga</label>
                                </div>
                                <div class="col-md-9">
                                    <div class="currency-input">
                                        <input type="text" name="jumlah_harga" id="jumlah_harga"
                                            class="form-control @error('jumlah_harga') is-invalid @enderror"
                                            placeholder="0"
                                            value="{{ old('jumlah_harga', $sekretariat->jumlah_harga) }}">
                                    </div>
                                    @error('jumlah_harga')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row align-items-start mb-4">
                                <div class="col-md-3">
                                    <label class="form-label">Foto Jurnal</label>
                                    <p class="file-upload-hint">Maksimal 10 file foto, masing-masing hingga 10 MB</p>
                                </div>
                                <div class="col-md-9">
                                    @php
                                        $foto_jurnals = $sekretariat->foto_jurnal ? (is_array($sekretariat->foto_jurnal) ? $sekretariat->foto_jurnal : [$sekretariat->foto_jurnal]) : [];
                                    @endphp
                                    @if(count($foto_jurnals) > 0)
                                        <div class="existing-files-section">
                                            <h6><i class="fas fa-images me-2"></i>Foto yang sudah ada:</h6>
                                            <div id="existing-foto-preview">
                                                @foreach($foto_jurnals as $index => $foto)
                                                    <div class="file-preview-item existing" data-file-path="{{ $foto }}">
                                                        <img src="{{ asset('storage/' . $foto) }}" alt="Foto {{ $index + 1 }}" class="preview-image">
                                                        <div class="file-info">
                                                            <div class="file-name">{{ basename($foto) }}</div>
                                                            <div class="file-size">File yang ada</div>
                                                        </div>
                                                        <button type="button" class="remove-file"
                                                                onclick="removeExistingFile(this, 'foto', '{{ $foto }}')">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                        <input type="hidden" name="existing_foto_jurnal[]" value="{{ $foto }}">
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    <label for="foto_jurnal" class="file-upload-wrapper">
                                        <input type="file" name="foto_jurnal[]" id="foto_jurnal"
                                               class="@error('foto_jurnal.*') is-invalid @enderror"
                                               accept="image/*" multiple>

                                        <div class="d-flex align-items-center gap-12">
                                            <div class="file-upload-icon-wrapper">
                                                <i class="fas fa-upload file-upload-icon"></i>
                                            </div>
                                            <div>
                                                <p class="file-upload-text" id="foto-file-name-display">
                                                    Seret dan lepas foto baru di sini, atau klik untuk mengunggah.
                                                </p>
                                            </div>
                                        </div>
                                    </label>

                                    <div id="fotoPreviewContainer" class="preview-container" style="display: none;"></div>
                                    <div id="fotoCounter" class="file-counter"></div>
                                    <div id="fotoMaxWarning" class="max-files-warning" style="display: none;">
                                        Maksimal 10 foto yang dapat diunggah.
                                    </div>

                                    @error('foto_jurnal.*')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row align-items-start mb-4">
                                <div class="col-md-3">
                                    <label class="form-label">Dokumen Pendukung</label>
                                    <p class="file-upload-hint">Maksimal 10 file PDF/Office, masing-masing hingga 10MB</p>
                                </div>
                                <div class="col-md-9">
                                    @php
                                        $dokumens = $sekretariat->dokumen_lpj ? (is_array($sekretariat->dokumen_lpj) ? $sekretariat->dokumen_lpj : [$sekretariat->dokumen_lpj]) : [];
                                    @endphp
                                    @if(count($dokumens) > 0)
                                        <div class="existing-files-section">
                                            <h6><i class="fas fa-file-alt me-2"></i>Dokumen yang sudah ada:</h6>
                                            <div id="existing-dokumen-preview">
                                                @foreach($dokumens as $index => $dokumen)
                                                    @php
                                                        $extension = pathinfo($dokumen, PATHINFO_EXTENSION);
                                                        $icon = match(strtolower($extension)) {
                                                            'pdf' => 'fas fa-file-pdf text-danger',
                                                            'doc', 'docx' => 'fas fa-file-word text-primary',
                                                            'xls', 'xlsx' => 'fas fa-file-excel text-success',
                                                            default => 'fas fa-file text-secondary'
                                                        };
                                                    @endphp
                                                    <div class="file-preview-item existing" data-file-path="{{ $dokumen }}">
                                                        <div class="file-icon">
                                                            <i class="{{ $icon }} fs-4"></i>
                                                        </div>
                                                        <div class="file-info">
                                                            <div class="file-name">{{ basename($dokumen) }}</div>
                                                            <div class="file-size">File yang ada</div>
                                                        </div>
                                                        <button type="button" class="remove-file"
                                                                onclick="removeExistingFile(this, 'dokumen', '{{ $dokumen }}')">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                        <input type="hidden" name="existing_dokumen_lpj[]" value="{{ $dokumen }}">
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    <label for="dokumen_lpj" class="file-upload-wrapper">
                                        <input type="file" name="dokumen_lpj[]" id="dokumen_lpj"
                                               class="@error('dokumen_lpj.*') is-invalid @enderror"
                                               accept=".pdf,.doc,.docx,.xls,.xlsx" multiple>

                                        <div class="d-flex align-items-center gap-12">
                                            <div class="file-upload-icon-wrapper">
                                                <i class="fas fa-upload file-upload-icon"></i>
                                            </div>
                                            <div>
                                                <p class="file-upload-text" id="dokumen-file-name-display">
                                                    Seret dan lepas dokumen baru di sini, atau klik untuk mengunggah.
                                                </p>
                                            </div>
                                        </div>
                                    </label>

                                    <div id="dokumenPreviewContainer" class="preview-container" style="display: none;"></div>
                                    <div id="dokumenCounter" class="file-counter"></div>
                                    <div id="dokumenMaxWarning" class="max-files-warning" style="display: none;">
                                        Maksimal 10 dokumen yang dapat diunggah.
                                    </div>

                                    @error('dokumen_lpj.*')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row align-items-start mb-4">
                                <div class="col-md-3">
                                    <label for="keterangan_tambahan" class="form-label">Keterangan Tambahan</label>
                                </div>
                                <div class="col-md-9">
                                    <textarea name="keterangan_tambahan" id="keterangan_tambahan"
                                        class="form-control @error('keterangan_tambahan') is-invalid @enderror"
                                        placeholder="Masukkan keterangan tambahan (opsional)"
                                        rows="4">{{ old('keterangan_tambahan', $sekretariat->keterangan_tambahan) }}</textarea>
                                    @error('keterangan_tambahan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-9 offset-md-3 d-flex justify-content-between">
                                    <button type="submit" class="btn btn-danger px-4">
                                        <i class="fas fa-save me-2"></i>Simpan Laporan
                                    </button>
                                    <a href="{{ route('admin.laporan-lpj.sekretariat.index') }}"
                                        class="btn btn-secondary px-4">
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
            const MAX_FILES = 10;
            const MAX_FILE_SIZE = 10 * 1024 * 1024; // 10MB

            let selectedFotoFiles = [];
            let selectedDokumenFiles = [];

            let existingFotoFiles = @json($sekretariat->foto_jurnal ? (is_array($sekretariat->foto_jurnal) ? $sekretariat->foto_jurnal : [$sekretariat->foto_jurnal]) : []);
            let existingDokumenFiles = @json($sekretariat->dokumen_lpj ? (is_array($sekretariat->dokumen_lpj) ? $sekretariat->dokumen_lpj : [$sekretariat->dokumen_lpj]) : []);

            // Currency formatting
            const currencyInputs = ['jumlah_harga_satuan', 'jumlah_harga'];

            currencyInputs.forEach(inputId => {
                const input = document.getElementById(inputId);
                if (input) {
                    // Format initial value
                    if (input.value) {
                        let value = input.value.replace(/[^\d]/g, '');
                        if (value) {
                            input.value = parseInt(value).toLocaleString('id-ID');
                        }
                    }

                    input.addEventListener('input', function(e) {
                        let value = e.target.value.replace(/[^\d]/g, '');
                        if (value) {
                            e.target.value = parseInt(value).toLocaleString('id-ID');
                        }
                    });
                }
            });

            // File upload handlers
            const fotoInput = document.getElementById('foto_jurnal');
            const fotoPreviewContainer = document.getElementById('fotoPreviewContainer');
            const fotoFileNameDisplay = document.getElementById('foto-file-name-display');
            const fotoCounter = document.getElementById('fotoCounter');
            const fotoMaxWarning = document.getElementById('fotoMaxWarning');

            const dokumenInput = document.getElementById('dokumen_lpj');
            const dokumenPreviewContainer = document.getElementById('dokumenPreviewContainer');
            const dokumenFileNameDisplay = document.getElementById('dokumen-file-name-display');
            const dokumenCounter = document.getElementById('dokumenCounter');
            const dokumenMaxWarning = document.getElementById('dokumenMaxWarning');

            fotoInput.addEventListener('change', function() {
                handleFileSelection(this.files, 'foto');
            });

            dokumenInput.addEventListener('change', function() {
                handleFileSelection(this.files, 'dokumen');
            });

            function handleFileSelection(files, type) {
                const isPhoto = type === 'foto';
                const currentFiles = isPhoto ? selectedFotoFiles : selectedDokumenFiles;
                const input = isPhoto ? fotoInput : dokumenInput;

                const existingFiles = isPhoto ? existingFotoFiles : existingDokumenFiles;
                const existingFilesCount = existingFiles.length;

                const newFiles = Array.from(files).filter(file => {
                    if (file.size > MAX_FILE_SIZE) {
                        alert(`File "${file.name}" terlalu besar. Maksimal 10MB per file.`);
                        return false;
                    }

                    if (isPhoto && !file.type.match('image.*')) {
                        alert(`File "${file.name}" bukan file gambar yang valid.`);
                        return false;
                    }

                    return true;
                });

                if (existingFilesCount + newFiles.length > MAX_FILES) {
                    alert(`Maksimal ${MAX_FILES} file dapat diunggah. Anda sudah memilih ${existingFilesCount} file.`);
                    // Clear the input to prevent adding the oversized/overcounted files
                    input.value = '';
                    return;
                }
                
                if (isPhoto) {
                    selectedFotoFiles = newFiles;
                } else {
                    selectedDokumenFiles = newFiles;
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

                const existingFiles = isPhoto ? existingFotoFiles : existingDokumenFiles;
                const existingFilesCount = existingFiles.length;

                const totalFiles = existingFilesCount + files.length;

                if (files.length === 0) {
                    container.style.display = 'none';
                    counter.textContent = totalFiles > 0 ? `${totalFiles}/${MAX_FILES} file` : '';
                    maxWarning.style.display = 'none';
                    nameDisplay.textContent = isPhoto ?
                        'Seret dan lepas foto baru di sini, atau klik untuk mengunggah.' :
                        'Seret dan lepas dokumen baru di sini, atau klik untuk mengunggah.';
                    return;
                }

                container.style.display = 'block';
                nameDisplay.textContent = `${files.length} file baru dipilih`;
                counter.textContent = `${totalFiles}/${MAX_FILES} file`;

                if (totalFiles >= MAX_FILES) {
                    maxWarning.style.display = 'block';
                } else {
                    maxWarning.style.display = 'none';
                }

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
                                <button type="button" class="remove-file" onclick="removeNewFile(${index}, '${type}')">
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
                                <button type="button" class="remove-file" onclick="removeNewFile(${index}, '${type}')">
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

            window.removeNewFile = function(index, type) {
                const isPhoto = type === 'foto';

                if (isPhoto) {
                    selectedFotoFiles.splice(index, 1);
                } else {
                    selectedDokumenFiles.splice(index, 1);
                }

                updateFilePreview(type);
                updateFileInput(type);
            };

            window.removeExistingFile = function(button, type, filePath) {
                if (confirm('Apakah Anda yakin ingin menghapus file ini? File akan dihapus permanen setelah disimpan.')) {
                    const item = button.closest('.file-preview-item');
                    item.querySelector('input[type=hidden]').name = `deleted_${type}s[]`;
                    item.style.display = 'none';

                    const isPhoto = type === 'foto';
                    if (isPhoto) {
                        const index = existingFotoFiles.indexOf(filePath);
                        if (index > -1) {
                            existingFotoFiles.splice(index, 1);
                        }
                    } else {
                        const index = existingDokumenFiles.indexOf(filePath);
                        if (index > -1) {
                            existingDokumenFiles.splice(index, 1);
                        }
                    }
                    
                    updateFileCounters();
                }
            };
            
            function updateFileCounters() {
                const totalFotos = existingFotoFiles.length + selectedFotoFiles.length;
                fotoCounter.textContent = totalFotos > 0 ? `${totalFotos}/${MAX_FILES} file` : '';
                fotoMaxWarning.style.display = totalFotos >= MAX_FILES ? 'block' : 'none';

                const totalDokumens = existingDokumenFiles.length + selectedDokumenFiles.length;
                dokumenCounter.textContent = totalDokumens > 0 ? `${totalDokumens}/${MAX_FILES} file` : '';
                dokumenMaxWarning.style.display = totalDokumens >= MAX_FILES ? 'block' : 'none';
            }

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

            updateFileCounters();

            // Form submission
            document.getElementById('lpjForm').addEventListener('submit', function(e) {
                currencyInputs.forEach(inputId => {
                    const input = document.getElementById(inputId);
                    if (input && input.value) {
                        input.value = input.value.replace(/[^\d]/g, '');
                    }
                });
            });
        });

        function calculateTotalPrice() {
            const volumeInput = document.getElementById('volume');
            const unitPriceInput = document.getElementById('jumlah_harga_satuan');
            const totalPriceInput = document.getElementById('jumlah_harga');

            if (!volumeInput || !unitPriceInput || !totalPriceInput) return;

            const volumeValue = volumeInput.value.trim();
            const unitPriceValue = unitPriceInput.value.replace(/[^\d]/g, ''); // Remove formatting

            const volumeMatch = volumeValue.match(/^\d+/);
            const volumeNumber = volumeMatch ? parseInt(volumeMatch[0]) : 0;
            const unitPriceNumber = unitPriceValue ? parseInt(unitPriceValue) : 0;

            if (volumeNumber > 0 && unitPriceNumber > 0) {
                const totalPrice = volumeNumber * unitPriceNumber;
                totalPriceInput.value = totalPrice.toLocaleString('id-ID');
            } else {
                totalPriceInput.value = '';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const volumeInput = document.getElementById('volume');
            const unitPriceInput = document.getElementById('jumlah_harga_satuan');

            if (volumeInput && unitPriceInput) {
                volumeInput.addEventListener('input', calculateTotalPrice);
                unitPriceInput.addEventListener('input', function() {
                    setTimeout(calculateTotalPrice, 10);
                });

                volumeInput.addEventListener('blur', calculateTotalPrice);
                unitPriceInput.addEventListener('blur', calculateTotalPrice);

                calculateTotalPrice();
            }
        });
    </script>
@endsection
