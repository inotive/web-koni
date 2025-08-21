@extends('layouts.app')

@section('pageTitle', 'Edit Kegiatan Lainnya')
@section('mainSection', 'Laporan Pertanggungjawaban')
@section('subSection', 'Kegiatan Lainnya')
@section('subSectionUrl', route('admin.laporan-lpj.kegiatan_lainnya.index'))
@section('currentSection', 'Edit Kegiatan Lainnya')

@section('content')

<style>
    body { background-color: #f5f5f5 !important; }
    .main-content { background-color: #f5f5f5; min-height: 100vh; padding: 20px 10px 40px; }
    .card-form { background-color: white; border-radius: 12px; border: 1px solid #e9ecef; box-shadow: 0 2px 12px rgba(0,0,0,.08); }
    .section-header { color: #0b153a; font-weight: 700; font-size: 1.6rem; margin-bottom: 1rem; }
    .file-upload-wrapper { display: flex; align-items: center; gap: 12px; border: 1px solid #cfe2ff; background-color: #edf5ff; border-radius: 10px; padding: 16px 20px; cursor: pointer; transition: all .2s ease-in-out; min-height: 80px; }
    .file-upload-wrapper:hover { border-color: #0d6efd; background-color: #e6f0ff; }
    .file-upload-wrapper input[type="file"] { display: none; }
    .file-upload-icon-wrapper { background-color: #d0e7ff; padding: 8px; border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .file-upload-icon { font-size: 1.5rem; color: #0d6efd; }
    .file-upload-text { margin: 0; font-size: .95rem; font-weight: 500; color: #0b153a; }
    .file-upload-hint { font-size: .8rem; color: #6c757d; margin-top: 4px; }
    .form-control, .form-select { border-radius: 8px; padding: 10px 14px; font-size: .95rem; }
    .form-control:focus, .form-select:focus { border-color: #0d6efd; box-shadow: 0 0 0 .2rem rgba(13,110,253,.2); }
    .invalid-feedback { font-size: .85rem; color: #e74c3c; }
    .btn-danger { background: linear-gradient(135deg,#F8285A 0%,#e91e63 100%); border: none; border-radius: 8px; padding: 12px 24px; font-weight: 600; font-size: .95rem; transition: all .3s ease; box-shadow: 0 2px 8px rgba(248,40,90,.3); }
    .btn-danger:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(248,40,90,.4); }
    .preview-image { max-width: 80px; max-height: 80px; border-radius: 8px; object-fit: cover; margin-right: 8px; margin-bottom: 8px; }
    .file-preview { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 10px; }
    .file-item { display: flex; align-items: center; background: #f8f9fa; padding: 8px 12px; border-radius: 6px; font-size: .85rem; color: #495057; max-width: 250px; }
    .file-item i { margin-right: 8px; color: #6c757d; }
    .file-name { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; flex: 1; }
    .file-counter { background: #007bff; color: white; border-radius: 50%; padding: 2px 6px; font-size: .75rem; margin-left: 8px; }
    .required:after { content:" *"; color:#F8285A; }
    .is-invalid { border-color: #dc3545 !important; }
    .is-invalid:focus { box-shadow: 0 0 0 .2rem rgba(220,53,69,.25) !important; }
    .form-control::placeholder { color: #9ca3af; font-size: .9rem; }
    .file-upload-text[data-has-file] { font-weight: 500; color: #0b153a; font-style: normal; }
    .file-upload-text:not([data-has-file]) { color: #6b7280; font-style: italic; }
    .existing-file { background-color: #e8f5e8; border: 1px solid #c3e6c3; }
    .existing-file-badge { background-color: #28a745; color: white; padding: 2px 6px; border-radius: 4px; font-size: 0.7rem; margin-left: 8px; }
</style>

<div class="d-flex justify-content-between align-items-center flex-wrap mb-4" style="padding: 20px 20px">
    <h3 class="fw-bold fs-2 mb-0 text-dark">Edit Kegiatan Lainnya</h3>
</div>

<div class="main-content">
    <div class="container-fluid">
        <div class="row">
            <div class="card card-form">
                <div class="card-body p-4 p-md-5">
                    <h3 class="fw-bold mb-4">Edit Data</h3>

                    <form action="{{ route('admin.laporan-lpj.kegiatan_lainnya.update', $kegiatan->id) }}"
                          method="POST" enctype="multipart/form-data" id="kegiatan-form">
                        @csrf
                        @method('PUT')

                        <!-- Foto Jurnal -->
                        <div class="row align-items-start mb-4">
                            <div class="col-md-3">
                                <label class="form-label required">Foto Jurnal</label>
                                <p class="file-upload-hint">Format: JPG, PNG, GIF (Maks. 10MB)</p>
                            </div>
                            <div class="col-md-9">
                                <label for="foto_jurnal" class="file-upload-wrapper">
                                    <input type="file" name="foto_jurnal" id="foto_jurnal"
                                           accept="image/jpeg,image/jpg,image/png,image/gif">
                                    <div class="d-flex align-items-center gap-12 w-100">
                                        <div class="file-upload-icon-wrapper">
                                            <i class="fas fa-upload file-upload-icon"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <p class="file-upload-text" id="foto-file-name-display"
                                               data-has-file="{{ $kegiatan->foto_jurnal ? 'true' : '' }}">
                                                {{ $kegiatan->foto_jurnal ? basename($kegiatan->foto_jurnal) : 'Seret dan lepas foto di sini, atau klik untuk mengunggah' }}
                                            </p>
                                            <div id="fotoPreviewContainer" class="file-preview">
                                                @if($kegiatan->foto_jurnal)
                                                    <div class="file-item existing-file">
                                                        <img src="{{ asset('storage/'.$kegiatan->foto_jurnal) }}" class="preview-image" alt="Preview">
                                                        <span class="existing-file-badge">Existing</span>
                                                        <input type="hidden" name="existing_foto_jurnal" value="{{ $kegiatan->foto_jurnal }}">
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </label>
                                @error('foto_jurnal') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <!-- Dokumen Pendukung -->
                        <div class="row align-items-start mb-4">
                            <div class="col-md-3">
                                <label class="form-label">Dokumen Pendukung</label>
                                <p class="file-upload-hint">Format: PDF, DOC, XLS (Maks. 10MB)</p>
                            </div>
                            <div class="col-md-9">
                                <label for="dokumen_pendukung" class="file-upload-wrapper">
                                    <input type="file" name="dokumen_pendukung" id="dokumen_pendukung"
                                           accept=".pdf,.doc,.docx,.xls,.xlsx">
                                    <div class="d-flex align-items-center gap-12 w-100">
                                        <div class="file-upload-icon-wrapper">
                                            <i class="fas fa-upload file-upload-icon"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <p class="file-upload-text" id="dokumen-file-name-display"
                                               data-has-file="{{ $kegiatan->dokumen_pendukung ? 'true' : '' }}">
                                                {{ $kegiatan->dokumen_pendukung ? basename($kegiatan->dokumen_pendukung) : 'Seret dan lepas dokumen di sini, atau klik untuk mengunggah' }}
                                            </p>
                                            <div id="dokumenPreviewContainer" class="file-preview">
                                                @if($kegiatan->dokumen_pendukung)
                                                    <div class="file-item existing-file">
                                                        <i class="{{ \Str::endsWith($kegiatan->dokumen_pendukung, '.pdf') ? 'fas fa-file-pdf' : 'fas fa-file-alt' }}"></i>
                                                        <span class="file-name">{{ basename($kegiatan->dokumen_pendukung) }}</span>
                                                        <span class="existing-file-badge">Existing</span>
                                                        <input type="hidden" name="existing_dokumen_pendukung" value="{{ $kegiatan->dokumen_pendukung }}">
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </label>
                                @error('dokumen_pendukung') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        @php
                            $fields = [
                                'nama_program_kegiatan' => ['label'=>'Nama Program & Kegiatan','type'=>'text','placeholder'=>'Masukkan nama program dan kegiatan','required'=>true],
                                'jenis_kegiatan'        => ['label'=>'Jenis Kegiatan','type'=>'text','placeholder'=>'Contoh: Rapat, Pelatihan, Pembelian','required'=>true],
                                'volume'                => ['label'=>'Volume','type'=>'text','placeholder'=>'Masukkan volume kegiatan (contoh: 20 unit, 1 kegiatan)','required'=>true],
                                'jumlah_harga_satuan'   => ['label'=>'Jumlah Harga Satuan','type'=>'number','placeholder'=>'Contoh: 250000 (hanya angka, tanpa titik/koma)','required'=>true],
                                'jumlah_harga'          => ['label'=>'Jumlah Harga','type'=>'number','placeholder'=>'Contoh: 5000000 (hanya angka, tanpa titik/koma)','required'=>true],
                                'keterangan_tambahan'   => ['label'=>'Keterangan Tambahan','type'=>'text','placeholder'=>'Masukkan keterangan tambahan (opsional)','required'=>false],
                            ];
                        @endphp

                        @foreach($fields as $key => $field)
                            <div class="row align-items-center mb-3">
                                <div class="col-md-3">
                                    <label for="{{ $key }}" class="form-label @if($field['required']) required @endif">
                                        {{ $field['label'] }}
                                    </label>
                                </div>
                                <div class="col-md-9">
                                    <input type="{{ $field['type'] }}" name="{{ $key }}" id="{{ $key }}"
                                           class="form-control @error($key) is-invalid @enderror"
                                           placeholder="{{ $field['placeholder'] }}"
                                           value="{{ old($key, $kegiatan->$key) }}"
                                           @if($field['required']) required @endif>
                                    @error($key) <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        @endforeach

                        <!-- Tanggal Kegiatan (ditambahkan karena ada di create form) -->
                        <div class="row align-items-center mb-3">
                            <div class="col-md-3">
                                <label for="tanggal_kegiatan" class="form-label required">Tanggal Kegiatan</label>
                            </div>
                            <div class="col-md-9">
                                <input type="date" name="tanggal_kegiatan" id="tanggal_kegiatan"
                                       class="form-control @error('tanggal_kegiatan') is-invalid @enderror"
                                       value="{{ old('tanggal_kegiatan', $kegiatan->tanggal_kegiatan ? \Carbon\Carbon::parse($kegiatan->tanggal_kegiatan)->format('Y-m-d') : '') }}"
                                       required>
                                @error('tanggal_kegiatan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-9 offset-md-3 d-flex justify-content-between">
                                <button type="submit" class="btn btn-danger px-4" id="submit-button">Simpan Perubahan</button>
                                <a href="{{ route('admin.laporan-lpj.kegiatan_lainnya.index') }}" class="btn btn-secondary px-4">Kembali</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const fotoUploadInput   = document.getElementById('foto_jurnal');
        const fotoFileName      = document.getElementById('foto-file-name-display');
        const fotoPreview       = document.getElementById('fotoPreviewContainer');

        const dokumenUploadInput = document.getElementById('dokumen_pendukung');
        const dokumenFileName   = document.getElementById('dokumen-file-name-display');
        const dokumenPreview    = document.getElementById('dokumenPreviewContainer');

        const form = document.getElementById('kegiatan-form');
        const submitBtn = document.getElementById('submit-button');

        // Handle file upload changes
        fotoUploadInput.addEventListener('change', () => handleFileUpload(fotoUploadInput, fotoFileName, fotoPreview, true));
        dokumenUploadInput.addEventListener('change', () => handleFileUpload(dokumenUploadInput, dokumenFileName, dokumenPreview, false));

        // Form submission handling
        form.addEventListener('submit', e => {
            if (!validateForm()) {
                e.preventDefault();
            } else {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Menyimpan...';
            }
        });

        function handleFileUpload(input, display, preview, isImg) {
            const file = input.files[0];
            if (!file) return;
            
            // Validate file size (max 10MB)
            if (file.size > 10 * 1024 * 1024) {
                showError(input, 'Maksimal 10 MB');
                input.value = '';
                return;
            }
            
            // Update file name display
            display.textContent = file.name;
            display.setAttribute('data-has-file', 'true');
            
            // Clear existing preview and show new file preview
            preview.innerHTML = '';
            
            if (isImg) {
                // For images, show preview
                const reader = new FileReader();
                reader.onload = e => {
                    preview.innerHTML = `
                        <div class="file-item">
                            <img src="${e.target.result}" class="preview-image" alt="Preview">
                            <span class="existing-file-badge">New</span>
                        </div>
                    `;
                };
                reader.readAsDataURL(file);
            } else {
                // For documents, show icon and name
                preview.innerHTML = `
                    <div class="file-item">
                        <i class="${getFileIcon(file.name)}"></i>
                        <span class="file-name">${file.name}</span>
                        <span class="existing-file-badge">New</span>
                    </div>
                `;
            }
        }
        
        function validateForm() {
            let valid = true;
            
            // Validate all required fields
            form.querySelectorAll('[required]').forEach(el => {
                if (!el.value.trim()) {
                    el.classList.add('is-invalid');
                    valid = false;
                } else {
                    el.classList.remove('is-invalid');
                }
            });
            
            // Scroll to first error if any
            if (!valid) {
                const firstError = form.querySelector('.is-invalid');
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
            
            return valid;
        }
        
        function showError(input, msg) {
            input.classList.add('is-invalid');
            let err = input.nextElementSibling;
            
            if (!err || !err.classList.contains('invalid-feedback')) {
                err = document.createElement('div');
                err.className = 'invalid-feedback';
                input.parentNode.insertBefore(err, input.nextSibling);
            }
            
            err.textContent = msg;
        }
        
        function getFileIcon(name) {
            const ext = name.split('.').pop().toLowerCase();
            switch (ext) {
                case 'pdf': return 'fas fa-file-pdf';
                case 'doc': case 'docx': return 'fas fa-file-word';
                case 'xls': case 'xlsx': return 'fas fa-file-excel';
                default: return 'fas fa-file-alt';
            }
        }
        
        // Drag and drop functionality
        const setupDrag = (wrapper, input) => {
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(evt => {
                wrapper.addEventListener(evt, e => {
                    e.preventDefault();
                    e.stopPropagation();
                }, false);
            });
            
            ['dragenter', 'dragover'].forEach(evt => {
                wrapper.addEventListener(evt, () => {
                    wrapper.style.borderColor = '#0d6efd';
                    wrapper.style.backgroundColor = '#e6f0ff';
                }, false);
            });
            
            ['dragleave', 'drop'].forEach(evt => {
                wrapper.addEventListener(evt, () => {
                    wrapper.style.borderColor = '#cfe2ff';
                    wrapper.style.backgroundColor = '#edf5ff';
                }, false);
            });
            
            wrapper.addEventListener('drop', e => {
                input.files = e.dataTransfer.files;
                input.dispatchEvent(new Event('change'));
            });
        };
        
        // Initialize drag and drop for both file inputs
        setupDrag(document.querySelector('label[for="foto_jurnal"]'), fotoUploadInput);
        setupDrag(document.querySelector('label[for="dokumen_pendukung"]'), dokumenUploadInput);
    });
</script>
@endsection