@extends('layouts.app')

@php
    $subSection3Url = '';
    if ($lpj->parent?->parent) {
        $subSection3Url = match($lpj->parent->parent->id) {
            9 => route('admin.laporan-lpj.bidang.prestasi.cabor-terukur', ['parentId' => 9]),
            10 => route('admin.laporan-lpj.bidang.prestasi.cabor-akurasi', ['parentId' => 10]),
            11 => route('admin.laporan-lpj.bidang.prestasi.cabor-permainan', ['parentId' => 11]),
            12 => route('admin.laporan-lpj.bidang.prestasi.cabor-beladiri', ['parentId' => 12]),
            default => route('admin.laporan-lpj.bidang.dynamic.index')
        };
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
@section('subSection4', $lpj->parent?->nama_program ?? '')
@section('subSection4Url', $lpj->parent ? route('admin.laporan-lpj.bidang.dynamic.child.index', ['parentId' => $lpj->parent->id]) : route('admin.laporan-lpj.bidang.dynamic.index'))
@section('currentSection', 'Edit Laporan')

@section('content')
<style>
    body { background-color: #f5f5f5 !important; }
    .main-content { background-color: #f5f5f5; min-height: 100vh; padding: 20px 10px 40px; }
    .card-form { background-color: white; border-radius: 12px; border: 1px solid #e9ecef; box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08); }
    .form-control, .form-select { border-radius: 8px; padding: 10px 14px; font-size: 0.95rem; }
    .form-control:focus, .form-select:focus { border-color: #0d6efd; box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.2); }
    .btn-danger { background: linear-gradient(135deg, #F8285A 0%, #e91e63 100%); border: none; border-radius: 8px; padding: 12px 24px; font-weight: 600; font-size: 0.95rem; transition: all 0.3s ease; box-shadow: 0 2px 8px rgba(248, 40, 90, 0.3); }
    .btn-danger:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(248, 40, 90, 0.4); }

    .currency-input { position: relative; }
    .currency-input::before { content: "Rp"; position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #6c757d; font-size: 0.95rem; z-index: 1; }
    .currency-input input { padding-left: 35px; }

    .file-upload-wrapper { display: flex; align-items: center; gap: 12px; border: 1px solid #cfe2ff; background-color: #edf5ff; border-radius: 10px; padding: 16px 20px; cursor: pointer; transition: all 0.2s ease-in-out; }
    .file-upload-wrapper:hover { border-color: #0d6efd; background-color: #e6f0ff; }
    .file-upload-wrapper input[type="file"] { display: none; }
    .file-upload-icon-wrapper { background-color: #d0e7ff; padding: 8px; border-radius: 8px; display: flex; align-items: center; justify-content: center; }
    .file-upload-icon { font-size: 1.5rem; color: #0d6efd; }

    .preview-container { max-height: 250px; overflow-y: auto; margin-top: 15px; border: 1px solid #e9ecef; border-radius: 8px; padding: 15px; background-color: #f8f9fa; }
    .file-preview-item { display: flex; align-items: center; gap: 12px; padding: 8px; border: 1px solid #e9ecef; border-radius: 6px; background-color: white; margin-bottom: 6px; }
    .file-preview-item.existing { background-color: #e8f5e8; border-color: #28a745; }
    .preview-image, .file-icon { width: 40px; height: 40px; object-fit: cover; border-radius: 4px; border: 1px solid #e9ecef; }
    .file-icon { display: flex; align-items: center; justify-content: center; background-color: #f8f9fa; }
    .file-info { flex: 1; }
    .file-name { font-weight: 500; color: #212529; font-size: 0.9rem; word-break: break-all; }
    .file-size { font-size: 0.75rem; color: #6c757d; }
    .remove-file { background: none; border: none; color: #dc3545; font-size: 1rem; cursor: pointer; padding: 4px; border-radius: 4px; transition: all 0.2s ease; }
    .remove-file:hover { background-color: #dc3545; color: white; }
    .existing-files-section { background-color: #f8f9fa; border-radius: 8px; padding: 12px; margin-bottom: 12px; }
    .existing-files-section h6 { color: #495057; font-weight: 600; margin-bottom: 8px; font-size: 0.9rem; }
</style>

<div class="d-flex justify-content-between align-items-center flex-wrap mb-4" style="padding: 20px 20px">
    <h3 class="fw-bold fs-2 mb-0 text-dark">Edit Laporan LPJ</h3>
</div>

<div class="main-content">
    <div class="container-fluid">
        <div class="card card-form">
            <div class="card-body p-4 p-md-5">
                <h3 class="fw-bold mb-4">Edit: {{ $lpj->nama_program }}</h3>

                <form action="{{ route('admin.laporan-lpj.bidang.dynamic.update', $lpj->id) }}" method="POST" id="lpjForm" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Basic Information --}}
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="nama_program" class="form-label">Nama Program <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" name="nama_program" id="nama_program"
                                   class="form-control @error('nama_program') is-invalid @enderror"
                                   value="{{ old('nama_program', $lpj->nama_program) }}" required>
                            @error('nama_program')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="nama_kegiatan" class="form-label">Nama Kegiatan <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" name="nama_kegiatan" id="nama_kegiatan"
                                   class="form-control @error('nama_kegiatan') is-invalid @enderror"
                                   value="{{ old('nama_kegiatan', $lpj->nama_kegiatan) }}" required>
                            @error('nama_kegiatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="volume" class="form-label">Volume</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" name="volume" id="volume"
                                   class="form-control @error('volume') is-invalid @enderror"
                                   placeholder="100 orang, 5 unit, dll"
                                   value="{{ old('volume', $lpj->volume) }}">
                            @error('volume')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    {{-- Price Fields --}}
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="jumlah_harga_satuan" class="form-label">Harga Satuan</label>
                        </div>
                        <div class="col-md-9">
                            <div class="currency-input">
                                <input type="text" name="jumlah_harga_satuan" id="jumlah_harga_satuan"
                                       class="form-control @error('jumlah_harga_satuan') is-invalid @enderror"
                                       placeholder="0" inputmode="numeric"
                                       value="{{ old('jumlah_harga_satuan', number_format($lpj->jumlah_harga_satuan ?? 0, 0, ',', '.')) }}">
                            </div>
                            @error('jumlah_harga_satuan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="jumlah_harga" class="form-label">Total Harga</label>
                        </div>
                        <div class="col-md-9">
                            <div class="currency-input">
                                <input type="text" name="jumlah_harga" id="jumlah_harga"
                                       class="form-control @error('jumlah_harga') is-invalid @enderror"
                                       placeholder="0" inputmode="numeric"
                                       value="{{ old('jumlah_harga', number_format($lpj->jumlah_harga ?? 0, 0, ',', '.')) }}">
                            </div>
                            @error('jumlah_harga')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    {{-- File Uploads --}}
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label class="form-label">Foto Jurnal</label>
                            <small class="text-muted d-block">Max 10 foto, 10MB each</small>
                        </div>
                        <div class="col-md-9">
                            @if($lpj->foto_jurnal && count($lpj->foto_jurnal) > 0)
                                <div class="existing-files-section">
                                    <h6><i class="fas fa-images me-2"></i>Foto Existing:</h6>
                                    @foreach($lpj->foto_jurnal as $foto)
                                        <div class="file-preview-item existing">
                                            <img src="{{ asset('storage/' . $foto) }}" class="preview-image">
                                            <div class="file-info">
                                                <div class="file-name">{{ basename($foto) }}</div>
                                                <div class="file-size">Existing file</div>
                                            </div>
                                            <button type="button" class="remove-file" onclick="removeExistingFile(this, '{{ $foto }}', 'foto')">
                                                <i class="fas fa-times"></i>
                                            </button>
                                            <input type="hidden" name="existing_foto_jurnal[]" value="{{ $foto }}">
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            <label for="foto_jurnal" class="file-upload-wrapper">
                                <input type="file" name="foto_jurnal[]" id="foto_jurnal" accept="image/*" multiple>
                                <div class="file-upload-icon-wrapper">
                                    <i class="fas fa-upload file-upload-icon"></i>
                                </div>
                                <div>
                                    <p class="file-upload-text mb-0">Upload foto baru</p>
                                </div>
                            </label>
                            <div id="fotoPreview" class="preview-container" style="display: none;"></div>
                            @error('foto_jurnal.*')<div class="text-danger mt-2">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label class="form-label">Dokumen LPJ</label>
                            <small class="text-muted d-block">Max 10 files, 10MB each</small>
                        </div>
                        <div class="col-md-9">
                            @if($lpj->dokumen_lpj && count($lpj->dokumen_lpj) > 0)
                                <div class="existing-files-section">
                                    <h6><i class="fas fa-file-alt me-2"></i>Dokumen Existing:</h6>
                                    @foreach($lpj->dokumen_lpj as $dokumen)
                                        @php
                                            $ext = pathinfo($dokumen, PATHINFO_EXTENSION);
                                            $icon = match(strtolower($ext)) {
                                                'pdf' => 'fas fa-file-pdf text-danger',
                                                'doc', 'docx' => 'fas fa-file-word text-primary',
                                                'xls', 'xlsx' => 'fas fa-file-excel text-success',
                                                default => 'fas fa-file text-secondary'
                                            };
                                        @endphp
                                        <div class="file-preview-item existing">
                                            <div class="file-icon"><i class="{{ $icon }}"></i></div>
                                            <div class="file-info">
                                                <div class="file-name">{{ basename($dokumen) }}</div>
                                                <div class="file-size">Existing file</div>
                                            </div>
                                            <button type="button" class="remove-file" onclick="removeExistingFile(this, '{{ $dokumen }}', 'dokumen')">
                                                <i class="fas fa-times"></i>
                                            </button>
                                            <input type="hidden" name="existing_dokumen_lpj[]" value="{{ $dokumen }}">
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            <label for="dokumen_lpj" class="file-upload-wrapper">
                                <input type="file" name="dokumen_lpj[]" id="dokumen_lpj" accept=".pdf,.doc,.docx,.xls,.xlsx" multiple>
                                <div class="file-upload-icon-wrapper">
                                    <i class="fas fa-upload file-upload-icon"></i>
                                </div>
                                <div>
                                    <p class="file-upload-text mb-0">Upload dokumen baru</p>
                                </div>
                            </label>
                            <div id="dokumenPreview" class="preview-container" style="display: none;"></div>
                            @error('dokumen_lpj.*')<div class="text-danger mt-2">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-3">
                            <label for="keterangan_tambahan" class="form-label">Keterangan Tambahan</label>
                        </div>
                        <div class="col-md-9">
                            <textarea name="keterangan_tambahan" id="keterangan_tambahan"
                                      class="form-control @error('keterangan_tambahan') is-invalid @enderror"
                                      rows="4">{{ old('keterangan_tambahan', $lpj->keterangan_tambahan) }}</textarea>
                            @error('keterangan_tambahan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="row">
                        <div class="col-md-9 offset-md-3 d-flex gap-3">
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-save me-2"></i>Simpan
                            </button>
                            <a href="{{ $lpj->parent_id ? route('admin.laporan-lpj.bidang.dynamic.child.index', $lpj->parent_id) : route('admin.laporan-lpj.bidang.dynamic.index') }}"
                               class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const MAX_FILES = 10;
    const MAX_FILE_SIZE = 10 * 1024 * 1024;

    // Currency formatting with number-only validation
    function formatCurrency(input) {
        // Remove all non-numeric characters
        let value = input.value.replace(/[^\d]/g, '');

        if (value) {
            // Format with Indonesian number format
            input.value = parseInt(value).toLocaleString('id-ID');
        } else {
            input.value = '';
        }
    }

    // Set up currency inputs
    ['jumlah_harga_satuan', 'jumlah_harga'].forEach(id => {
        const input = document.getElementById(id);
        if (input) {
            // Prevent non-numeric input
            input.addEventListener('keypress', function(e) {
                // Allow: backspace, delete, tab, escape, enter, period, and numbers
                if ([46, 8, 9, 27, 13].indexOf(e.keyCode) !== -1 ||
                    (e.keyCode >= 48 && e.keyCode <= 57) ||
                    (e.keyCode >= 96 && e.keyCode <= 105)) {
                    return;
                }
                e.preventDefault();
            });

            // Format on input
            input.addEventListener('input', function() {
                formatCurrency(this);
                calculateTotal();
            });

            // Prevent paste of non-numeric content
            input.addEventListener('paste', function(e) {
                e.preventDefault();
                let paste = (e.clipboardData || window.clipboardData).getData('text');
                let numericValue = paste.replace(/[^\d]/g, '');
                if (numericValue) {
                    this.value = parseInt(numericValue).toLocaleString('id-ID');
                    calculateTotal();
                }
            });
        }
    });

    // Calculate total price
    function calculateTotal() {
        const volumeEl = document.getElementById('volume');
        const unitPriceEl = document.getElementById('jumlah_harga_satuan');
        const totalPriceEl = document.getElementById('jumlah_harga');

        if (!volumeEl || !unitPriceEl || !totalPriceEl) return;

        const volume = parseVolume(volumeEl.value);
        const unitPrice = parseInt(unitPriceEl.value.replace(/[^\d]/g, '') || '0');

        if (volume > 0 && unitPrice > 0) {
            const total = volume * unitPrice;
            totalPriceEl.value = total.toLocaleString('id-ID');
        }
    }

    function parseVolume(text) {
        if (!text) return 0;
        const numbers = text.match(/\d+/g);
        return numbers ? numbers.reduce((sum, num) => sum + parseInt(num), 0) : 0;
    }

    // File upload handlers
    function setupFileUpload(inputId, previewId, type) {
        const input = document.getElementById(inputId);
        const preview = document.getElementById(previewId);

        if (!input || !preview) return;

        input.addEventListener('change', function() {
            const files = Array.from(this.files);
            updatePreview(files, preview, type);
        });
    }

    function updatePreview(files, container, type) {
        if (files.length === 0) {
            container.style.display = 'none';
            return;
        }

        container.style.display = 'block';
        let html = '';

        files.forEach((file, index) => {
            const size = formatFileSize(file.size);

            if (type === 'foto') {
                const url = URL.createObjectURL(file);
                html += `
                    <div class="file-preview-item">
                        <img src="${url}" class="preview-image">
                        <div class="file-info">
                            <div class="file-name">${file.name}</div>
                            <div class="file-size">${size}</div>
                        </div>
                        <button type="button" class="remove-file" onclick="removeFile(${index}, '${type}')">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                `;
            } else {
                const ext = file.name.split('.').pop().toLowerCase();
                const icon = getFileIcon(ext);
                html += `
                    <div class="file-preview-item">
                        <div class="file-icon"><i class="${icon}"></i></div>
                        <div class="file-info">
                            <div class="file-name">${file.name}</div>
                            <div class="file-size">${size}</div>
                        </div>
                        <button type="button" class="remove-file" onclick="removeFile(${index}, '${type}')">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                `;
            }
        });

        container.innerHTML = html;
    }

    function formatFileSize(bytes) {
        return bytes > 1024 * 1024 ?
            (bytes / (1024 * 1024)).toFixed(1) + ' MB' :
            (bytes / 1024).toFixed(1) + ' KB';
    }

    function getFileIcon(ext) {
        const icons = {
            'pdf': 'fas fa-file-pdf text-danger',
            'doc': 'fas fa-file-word text-primary', 'docx': 'fas fa-file-word text-primary',
            'xls': 'fas fa-file-excel text-success', 'xlsx': 'fas fa-file-excel text-success'
        };
        return icons[ext] || 'fas fa-file text-secondary';
    }

    // Global functions for button actions
    window.removeFile = function(index, type) {
        const inputId = type === 'foto' ? 'foto_jurnal' : 'dokumen_lpj';
        const input = document.getElementById(inputId);
        const files = Array.from(input.files);
        files.splice(index, 1);

        const dt = new DataTransfer();
        files.forEach(file => dt.items.add(file));
        input.files = dt.files;

        const preview = document.getElementById(type + 'Preview');
        updatePreview(files, preview, type);
    };

    window.removeExistingFile = function(button, filePath, type) {
        if (confirm('Hapus file ini?')) {
            button.parentElement.remove();
        }
    };

    // Form submission
    document.getElementById('lpjForm').addEventListener('submit', function() {
        // Convert formatted numbers back to plain numbers for submission
        ['jumlah_harga_satuan', 'jumlah_harga'].forEach(id => {
            const input = document.getElementById(id);
            if (input?.value) {
                input.value = input.value.replace(/[^\d]/g, '');
            }
        });
    });

    // Setup file uploads
    setupFileUpload('foto_jurnal', 'fotoPreview', 'foto');
    setupFileUpload('dokumen_lpj', 'dokumenPreview', 'dokumen');

    // Volume input listener for auto-calculation
    document.getElementById('volume')?.addEventListener('input', calculateTotal);

    // Initial calculation
    calculateTotal();
});
</script>
@endsection
