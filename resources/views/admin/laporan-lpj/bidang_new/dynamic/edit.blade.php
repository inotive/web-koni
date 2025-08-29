@extends('layouts.app')

@php
    $subSection3Url = '';

    if ($lpj->parent?->parent) {
        if ($lpj->parent->parent->id == 9) {
            $subSection3Url = route('admin.laporan-lpj.bidang.prestasi.cabor-terukur', [
                'parentId' => $lpj->parent->parent->id
            ]);
        }
            elseif ($lpj->parent->parent->id == 10) {
                $subSection3Url = route('admin.laporan-lpj.bidang.prestasi.cabor-akurasi', [
                    'parentId' => $lpj->parent->parent->id
                ]);
        }
            elseif ($lpj->parent->parent->id == 11) {
                $subSection3Url = route('admin.laporan-lpj.bidang.prestasi.cabor-permainan', [
                    'parentId' => $lpj->parent->parent->id
                ]);
        }
            elseif ($lpj->parent->parent->id == 12) {
                $subSection3Url = route('admin.laporan-lpj.bidang.prestasi.cabor-beladiri', [
                    'parentId' => $lpj->parent->parent->id
                ]);
        }
          else {
            // fallback if needed
            $subSection3Url = route('admin.laporan-lpj.bidang.dynamic.index');
        }
    }
@endphp

@section('pageTitle', 'Edit Laporan LPJ')
@section('mainSection', 'Laporan LPJ')
@section('subSection', 'Bidang Bidang')
@section('subSectionUrl', route('admin.laporan-lpj.bidang.index'))
@section('subSection2', $lpj->parent?->parent?->parent?->nama_program ?? '')
@section('subSection2Url', route('admin.laporan-lpj.bidang.prestasi.index'))
@section('subSection3', $lpj->parent?->parent?->nama_program ?? '')
@section('subSection3Url', $subSection3Url)
{{-- @section('subSection3Url', $lpj->parent?->parent ? route('admin.laporan-lpj.bidang.dynamic.child.index', ['parentId' => $lpj->parent->parent->id]) : '') --}}
@section('subSection4', $lpj->parent?->nama_program ?? '')
@section('subSection4Url', $lpj->parent ? route('admin.laporan-lpj.bidang.dynamic.child.index', ['parentId' => $lpj->parent->id]) : route('admin.laporan-lpj.bidang.dynamic.index'))
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
        <h3 class="fw-bold fs-2 mb-0 text-dark">Edit Laporan LPJ</h3>
    </div>

    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="card card-form">
                    <div class="card-body p-4 p-md-5">
                        <h3 class="fw-bold mb-4">Edit Laporan: {{ $lpj->nama_program }}</h3>

                        <form action="{{ route('admin.laporan-lpj.bidang.dynamic.update', $lpj->id) }}"
                              method="POST"
                              id="lpjForm"
                              enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row align-items-center mb-3">
                                <div class="col-md-3">
                                    <label for="nama_program" class="form-label">
                                        Nama Program <span class="text-danger">*</span>
                                    </label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" name="nama_program" id="nama_program"
                                        class="form-control @error('nama_program') is-invalid @enderror"
                                        placeholder="Masukkan nama program"
                                        value="{{ old('nama_program', $lpj->nama_program) }}" required>
                                    @error('nama_program')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row align-items-center mb-3">
                                <div class="col-md-3">
                                    <label for="nama_kegiatan" class="form-label">
                                        Nama Kegiatan <span class="text-danger">*</span>
                                    </label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" name="nama_kegiatan" id="nama_kegiatan"
                                        class="form-control @error('nama_kegiatan') is-invalid @enderror"
                                        placeholder="Masukkan nama kegiatan"
                                        value="{{ old('nama_kegiatan', $lpj->nama_kegiatan) }}" required>
                                    @error('nama_kegiatan')
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
                                        value="{{ old('volume', $lpj->volume) }}">
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
                                            value="{{ old('jumlah_harga_satuan', $lpj->jumlah_harga_satuan) }}">
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
                                            value="{{ old('jumlah_harga', $lpj->jumlah_harga) }}">
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
                                    @if($lpj->foto_jurnal && count($lpj->foto_jurnal) > 0)
                                        <div class="existing-files-section">
                                            <h6><i class="fas fa-images me-2"></i>Foto yang sudah ada:</h6>
                                            <div id="existing-foto-preview">
                                                @foreach($lpj->foto_jurnal as $index => $foto)
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
                                    <label class="form-label">Dokumen LPJ</label>
                                    <p class="file-upload-hint">Maksimal 10 file PDF/Office, masing-masing hingga 10MB</p>
                                </div>
                                <div class="col-md-9">
                                    @if($lpj->dokumen_lpj && count($lpj->dokumen_lpj) > 0)
                                        <div class="existing-files-section">
                                            <h6><i class="fas fa-file-alt me-2"></i>Dokumen yang sudah ada:</h6>
                                            <div id="existing-dokumen-preview">
                                                @foreach($lpj->dokumen_lpj as $index => $dokumen)
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
                                        rows="4">{{ old('keterangan_tambahan', $lpj->keterangan_tambahan) }}</textarea>
                                    @error('keterangan_tambahan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-3 offset-md-3 d-flex justify-content-between">
                                    <button type="submit" class="btn btn-danger px-4">
                                        <i class="fas fa-save me-2"></i>Simpan Laporan
                                    </button>
                                    <a href="{{ $lpj->parent_id ? route('admin.laporan-lpj.bidang.dynamic.child.index', $lpj->parent_id) : route('admin.laporan-lpj.bidang.dynamic.index') }}"
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

            let existingFotoFiles = @json($lpj->foto_jurnal ?? []);
            let existingDokumenFiles = @json($lpj->dokumen_lpj ?? []);

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

                if (existingFilesCount + currentFiles.length + newFiles.length > MAX_FILES) {
                    alert(`Maksimal ${MAX_FILES} file dapat diunggah. Anda sudah memiliki ${existingFilesCount + currentFiles.length} file.`);
                    return;
                }

                if (isPhoto) {
                    selectedFotoFiles = [...currentFiles, ...newFiles];
                } else {
                    selectedDokumenFiles = [...currentFiles, ...newFiles];
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
                    const file = selectedFotoFiles[index];
                    if (file) {
                        const imgElements = document.querySelectorAll('.preview-image');
                        imgElements.forEach(img => {
                            if (img.src && img.src.startsWith('blob:')) {
                                    URL.revokeObjectURL(img.src);
                            }
                        });
                    }
                    selectedFotoFiles.splice(index, 1);
                } else {
                    selectedDokumenFiles.splice(index, 1);
                }

                updateFilePreview(type);
                updateFileInput(type);
            };

            window.removeExistingFile = function(button, type, filePath) {
                if (confirm('Apakah Anda yakin ingin menghapus file ini?')) {
                    button.parentElement.remove();

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
                    const counter = isPhoto ? fotoCounter : dokumenCounter;
                    const maxWarning = isPhoto ? fotoMaxWarning : dokumenMaxWarning;
                    const newFilesCount = isPhoto ? selectedFotoFiles.length : selectedDokumenFiles.length;

                    const existingFiles = isPhoto ? existingFotoFiles : existingDokumenFiles;
                    const existingFilesCount = existingFiles.length;

                    const totalFiles = existingFilesCount + newFilesCount;
                    counter.textContent = totalFiles > 0 ? `${totalFiles}/${MAX_FILES} file` : '';

                    if (totalFiles >= MAX_FILES) {
                        maxWarning.style.display = 'block';
                    } else {
                        maxWarning.style.display = 'none';
                    }
                }
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

            // Initialize counters for existing files
            function initializeCounters() {
                const existingFotoCount = existingFotoFiles.length;
                const existingDokumenCount = existingDokumenFiles.length;

                if (existingFotoCount > 0) {
                    fotoCounter.textContent = `${existingFotoCount}/${MAX_FILES} file`;
                    if (existingFotoCount >= MAX_FILES) {
                        fotoMaxWarning.style.display = 'block';
                    }
                }

                if (existingDokumenCount > 0) {
                    dokumenCounter.textContent = `${existingDokumenCount}/${MAX_FILES} file`;
                    if (existingDokumenCount >= MAX_FILES) {
                        dokumenMaxWarning.style.display = 'block';
                    }
                }
            }

            initializeCounters();

            // Preview existing images on click
            document.querySelectorAll('.existing .preview-image').forEach(img => {
                img.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const modal = document.createElement('div');
                    modal.className = 'modal fade';
                    modal.innerHTML = `
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Preview Gambar</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body text-center">
                                    <img src="${this.src}" class="img-fluid" style="max-height: 70vh;">
                                </div>
                            </div>
                        </div>
                    `;
                    document.body.appendChild(modal);
                    const bootstrapModal = new bootstrap.Modal(modal);
                    bootstrapModal.show();

                    modal.addEventListener('hidden.bs.modal', () => {
                        modal.remove();
                    });
                });
            });

            // Form submission
            document.getElementById('lpjForm').addEventListener('submit', function(e) {
                currencyInputs.forEach(inputId => {
                    const input = document.getElementById(inputId);
                    if (input && input.value) {
                        input.value = input.value.replace(/[^\d]/g, '');
                    }
                });

                const submitBtn = document.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
                submitBtn.disabled = true;

                setTimeout(() => {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                }, 10000);
            });

            // Auto-save draft functionality
            let autoSaveTimeout;
            const formInputs = document.querySelectorAll('#lpjForm input, #lpjForm textarea');

            formInputs.forEach(input => {
                input.addEventListener('input', function() {
                    clearTimeout(autoSaveTimeout);
                    autoSaveTimeout = setTimeout(() => {
                        saveDraft();
                    }, 3000);
                });
            });

            function saveDraft() {
                const formData = new FormData(document.getElementById('lpjForm'));
                const draftData = {};

                for (let [key, value] of formData.entries()) {
                    if (key !== '_token' && key !== '_method' && !key.includes('file') && !key.includes('existing_')) {
                        draftData[key] = value;
                    }
                }

                localStorage.setItem('lpj_edit_draft_{{ $lpj->id }}', JSON.stringify(draftData));

                const draftIndicator = document.createElement('div');
                draftIndicator.className = 'alert alert-info position-fixed';
                draftIndicator.style.cssText = 'top: 20px; right: 20px; z-index: 9999; opacity: 0.9;';
                draftIndicator.innerHTML = '<small><i class="fas fa-save me-1"></i>Draft tersimpan otomatis</small>';
                document.body.appendChild(draftIndicator);

                setTimeout(() => {
                    draftIndicator.remove();
                }, 2000);
            }

            function loadDraft() {
                const draftData = localStorage.getItem('lpj_edit_draft_{{ $lpj->id }}');
                if (draftData) {
                    try {
                        const data = JSON.parse(draftData);
                        for (let [key, value] of Object.entries(data)) {
                            const input = document.querySelector(`[name="${key}"]`);
                            if (input && input.value === '') {
                                input.value = value;
                            }
                        }
                    } catch (e) {
                        console.error('Error loading draft:', e);
                    }
                }
            }

            loadDraft();

            window.addEventListener('beforeunload', function() {
                if (document.querySelector('.alert-success')) {
                    localStorage.removeItem('lpj_edit_draft_{{ $lpj->id }}');
                }
            });
        });

        function parseVolumeQuantity(volumeText) {
            if (!volumeText || typeof volumeText !== 'string') {
                return 0;
            }

            // Extract all numbers from the text using regex
            const numbers = volumeText.match(/\d+/g);

            if (!numbers || numbers.length === 0) {
                return 0;
            }

            // Convert to integers and sum them up
            const total = numbers.reduce((sum, num) => sum + parseInt(num, 10), 0);

            return total;
        }

        function calculateTotalPrice() {
            const volumeInput = document.getElementById('volume');
            const unitPriceInput = document.getElementById('jumlah_harga_satuan');
            const totalPriceInput = document.getElementById('jumlah_harga');

            if (!volumeInput || !unitPriceInput || !totalPriceInput) return;

            const volumeValue = volumeInput.value.trim();
            const unitPriceValue = unitPriceInput.value.replace(/[^\d]/g, ''); // Remove formatting

            // Parse volume using the enhanced function
            const volumeNumber = parseVolumeQuantity(volumeValue);
            const unitPriceNumber = unitPriceValue ? parseInt(unitPriceValue) : 0;

            console.log('Volume text:', volumeValue);
            console.log('Parsed volume quantity:', volumeNumber);
            console.log('Unit price:', unitPriceNumber);

            if (volumeNumber > 0 && unitPriceNumber > 0) {
                const totalPrice = volumeNumber * unitPriceNumber;
                totalPriceInput.value = totalPrice.toLocaleString('id-ID');

                // Add visual feedback
                totalPriceInput.style.backgroundColor = '#e8f5e8';
                setTimeout(() => {
                    totalPriceInput.style.backgroundColor = '';
                }, 1000);

                // Show breakdown in console for debugging
                console.log('Total calculation:', volumeNumber, 'x', unitPriceNumber, '=', totalPrice);
            } else if (volumeNumber === 0 || unitPriceNumber === 0) {
                totalPriceInput.value = '';
            }
        }

        // Enhanced version with visual feedback showing the breakdown
        function calculateTotalPriceWithBreakdown() {
            const volumeInput = document.getElementById('volume');
            const unitPriceInput = document.getElementById('jumlah_harga_satuan');
            const totalPriceInput = document.getElementById('jumlah_harga');

            if (!volumeInput || !unitPriceInput || !totalPriceInput) return;

            const volumeValue = volumeInput.value.trim();
            const unitPriceValue = unitPriceInput.value.replace(/[^\d]/g, '');

            // Parse volume and show breakdown
            const numbers = volumeValue.match(/\d+/g);
            const volumeNumber = parseVolumeQuantity(volumeValue);
            const unitPriceNumber = unitPriceValue ? parseInt(unitPriceValue) : 0;

            // Remove any existing breakdown display
            const existingBreakdown = document.getElementById('volume-breakdown');
            if (existingBreakdown) {
                existingBreakdown.remove();
            }

            if (volumeNumber > 0 && unitPriceNumber > 0) {
                const totalPrice = volumeNumber * unitPriceNumber;
                totalPriceInput.value = totalPrice.toLocaleString('id-ID');

                // Show breakdown if multiple numbers were found
                if (numbers && numbers.length > 1) {
                    const breakdown = document.createElement('small');
                    breakdown.id = 'volume-breakdown';
                    breakdown.className = 'text-info mt-1 d-block';
                   // breakdown.innerHTML = `<i class="fas fa-calculator me-1"></i>Perhitungan: ${numbers.join(' + ')} = ${volumeNumber} × ${unitPriceNumber.toLocaleString('id-ID')} = ${totalPrice.toLocaleString('id-ID')}`;

                    volumeInput.parentNode.appendChild(breakdown);

                    // Auto-hide breakdown after 5 seconds
                    setTimeout(() => {
                        if (breakdown.parentNode) {
                            breakdown.remove();
                        }
                    }, 5000);
                }

                // Add visual feedback
                totalPriceInput.style.backgroundColor = '#e8f5e8';
                setTimeout(() => {
                    totalPriceInput.style.backgroundColor = '';
                }, 1000);
            } else if (volumeNumber === 0 || unitPriceNumber === 0) {
                totalPriceInput.value = '';
            }
        }

        // Test function to verify the parsing works correctly
        function testVolumeParser() {
            const testCases = [
                "12 orang",
                "12 orang kantor 14 orang kampung",
                "5 unit kantor 3 unit gudang 2 unit lapangan",
                "100 peserta workshop 50 peserta seminar",
                "25 kg beras 15 kg gula 10 kg minyak",
                "no numbers here",
                "",
                "50",
                "10 item pertama 20 item kedua 30 item ketiga"
            ];

            console.log("Testing Volume Parser:");
            testCases.forEach(testCase => {
                const result = parseVolumeQuantity(testCase);
                console.log(`"${testCase}" → ${result}`);
            });
        }

        // Integration with your existing form
        document.addEventListener('DOMContentLoaded', function() {
            const volumeInput = document.getElementById('volume');
            const unitPriceInput = document.getElementById('jumlah_harga_satuan');

            if (volumeInput && unitPriceInput) {
                // Use the enhanced version with breakdown display
                volumeInput.addEventListener('input', calculateTotalPriceWithBreakdown);
                unitPriceInput.addEventListener('input', function() {
                    setTimeout(calculateTotalPriceWithBreakdown, 10);
                });

                volumeInput.addEventListener('blur', calculateTotalPriceWithBreakdown);
                unitPriceInput.addEventListener('blur', calculateTotalPriceWithBreakdown);

                // Initial calculation
                calculateTotalPriceWithBreakdown();

                // Add placeholder text to help users understand the format
                if (volumeInput.placeholder.includes('misal: 100 orang')) {
                    volumeInput.placeholder = "Masukkan volume (100 orang, 5 unit)";
                }
            }

            // Uncomment to run tests
            // testVolumeParser();
        });
    </script>
@endsection
