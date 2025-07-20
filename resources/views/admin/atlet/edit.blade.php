@extends('layouts.app')
@section('pageTitle', 'Edit Atlet')
@section('mainSection', 'Konfigurasi')
@section('mainSectionUrl', route('admin.konfigurasi.atlet.index'))
@section('subSection', 'Atlet')
@section('subSectionUrl', route('admin.konfigurasi.atlet.index'))
@section('currentSection', 'Edit Atlet')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/create.css') }}">
@endpush

@section('breadcrumb-title')
    <h1 class="text-dark fw-bold fs-3 mb-0">Edit Atlet</h1>
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
    .current-photo {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 8px;
    }
    .preview-image {
        max-width: 100px;
        max-height: 100px;
        border-radius: 8px;
        object-fit: cover;
    }
    .current-image-container {
        margin-top: 1rem;
    }
    .current-image-label {
        font-size: 0.8rem;
        color: #6c757d;
        margin-bottom: 0.5rem;
        display: block;
    }
    .current-image {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #dee2e6;
    }
</style>

<div class="container mt-4">
    <div class="card card-form">
        <div class="card-body p-4 p-md-5">
            <h3 class="fw-bold mb-4">Edit Data Atlet</h3>

            <form action="{{ route('admin.konfigurasi.atlet.update', $atlet->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row align-items-center mb-4">
                    <div class="col-md-3">
                        <label for="foto_atlet" class="form-label">Foto Atlet</label>
                    </div>
                    <div class="col-md-9">
                        <label for="foto_atlet" class="file-upload-wrapper" id="dropArea">
                            <input type="file" name="foto_atlet" id="foto_atlet" accept="image/*">

                            <!-- Upload content - akan disembunyikan jika ada foto -->
                            <div class="d-flex justify-content-center align-items-center" id="uploadContent" @if($atlet->foto_atlet) style="display: none !important;" @endif>
                                <i class="fas fa-cloud-upload-alt file-upload-icon me-3" id="uploadIcon"></i>
                                <div id="uploadText">
                                    <p class="file-upload-text mb-1">Seret dan lepas file di sini, atau klik untuk mengunggah</p>
                                    <p class="file-upload-hint" id="file-name-display">150x150px JPEG, PNG Image</p>
                                </div>
                            </div>

                            <!-- Container untuk preview gambar baru -->
                            <div id="imagePreviewContainer" style="display: none;"></div>

                            <!-- Container untuk gambar yang sudah ada - ditampilkan di dalam kotak -->
                            @if ($atlet->foto_atlet)
                                <div id="existingImageContainer" class="d-flex justify-content-center align-items-center">
                                    <img src="{{ asset('storage/' . $atlet->foto_atlet) }}" alt="Foto Atlet" class="preview-image me-3">
                                    <div>
                                        <p class="file-upload-text mb-1">Foto Atlet Saat Ini</p>
                                        <p class="file-upload-hint">Klik untuk mengubah foto</p>
                                    </div>
                                </div>
                            @endif
                        </label>
                    </div>
                </div>

                @php
                $fields = [
                    'nama' => ['label' => 'Nama Lengkap', 'type' => 'text', 'placeholder' => 'Masukkan nama lengkap', 'required' => true, 'value' => $atlet->nama],
                    'cabor' => ['label' => 'Cabang Olahraga', 'type' => 'select', 'options' => ['Sepak Bola', 'Basket', 'Badminton', 'Renang', 'Atletik', 'Tenis', 'Voli'], 'required' => true, 'value' => $atlet->cabor],
                    'email' => ['label' => 'Email', 'type' => 'email', 'placeholder' => 'emailatlet@gmail.com', 'required' => false, 'value' => $atlet->email],
                    'no_telepon' => ['label' => 'No Telepon', 'type' => 'text', 'placeholder' => '0895 9271 8263', 'required' => false, 'value' => $atlet->no_telepon],
                    'tanggal_lahir' => ['label' => 'Tanggal Lahir', 'type' => 'date', 'required' => true, 'value' => $atlet->tanggal_lahir],
                    'tempat_lahir' => ['label' => 'Tempat Lahir', 'type' => 'text', 'placeholder' => 'Balikpapan, Kalimantan Timur', 'required' => true, 'value' => $atlet->tempat_lahir],
                    'jenis_kelamin' => ['label' => 'Jenis Kelamin', 'type' => 'select', 'options' => ['Laki-laki', 'Perempuan'], 'required' => true, 'value' => $atlet->jenis_kelamin],
                    'alamat' => ['label' => 'Alamat (Sesuai KTP)', 'type' => 'textarea', 'placeholder' => 'Jln Prapatan Dalam RT 43 NO.08, Kelurahan Prapatan', 'required' => true, 'value' => $atlet->alamat],
                ];
                @endphp

                @foreach ($fields as $key => $field)
                <div class="row align-items-center mb-3">
                    <div class="col-md-3">
                        <label for="{{ $key }}" class="form-label">{{ $field['label'] }}</label>
                    </div>
                    <div class="col-md-9">
                        @php
                            $value = old($key, $field['value']);
                        @endphp
                        @if ($field['type'] === 'select')
                            <select name="{{ $key }}" id="{{ $key }}" class="form-select @error($key) is-invalid @enderror" {{ $field['required'] ? 'required' : '' }}>
                                <option value="">Pilih {{ $field['label'] }}</option>
                                @foreach($field['options'] as $option)
                                <option value="{{ $option }}" {{ $value == $option ? 'selected' : '' }}>{{ $option }}</option>
                                @endforeach
                            </select>
                        @elseif ($field['type'] === 'textarea')
                            <textarea name="{{ $key }}" id="{{ $key }}" class="form-control @error($key) is-invalid @enderror" placeholder="{{ $field['placeholder'] }}" rows="3" {{ $field['required'] ? 'required' : '' }}>{{ $value }}</textarea>
                        @else
                            <input type="{{ $field['type'] }}" name="{{ $key }}" id="{{ $key }}" class="form-control @error($key) is-invalid @enderror" placeholder="{{ $field['placeholder'] ?? '' }}" value="{{ $value }}" {{ $field['required'] ? 'required' : '' }}>
                        @endif
                        @error($key) <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                @endforeach

                <div class="row mt-4">
                    <div class="col-md-9 offset-md-3 d-flex justify-content-between">
                        <button type="submit" class="btn btn-danger px-4">Update Data</button>
                        <a href="{{ route('admin.konfigurasi.atlet.index') }}" class="btn btn-secondary px-4">Batal</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const uploadInput = document.getElementById('foto_atlet');
        const dropArea = document.getElementById('dropArea');
        const uploadContent = document.getElementById('uploadContent');
        const previewContainer = document.getElementById('imagePreviewContainer');
        const existingImageContainer = document.getElementById('existingImageContainer');

        // Image preview functionality
        uploadInput.addEventListener('change', function() {
            const file = this.files[0];

            if (file) {
                if (!file.type.match('image.*')) {
                    alert('Hanya file gambar yang diizinkan');
                    return;
                }

                // Hide upload content and existing image
                uploadContent.style.display = 'none';
                if (existingImageContainer) {
                    existingImageContainer.style.display = 'none';
                }

                // Show preview container
                previewContainer.style.display = 'flex';
                previewContainer.style.justifyContent = 'center';
                previewContainer.style.alignItems = 'center';
                previewContainer.innerHTML = '';

                const reader = new FileReader();

                reader.onload = function(e) {
                    const previewContent = `
                        <div class="d-flex justify-content-center align-items-center">
                            <img src="${e.target.result}" class="preview-image me-3" alt="Preview Foto Atlet" style="width: 100px; height: 100px; object-fit: cover; border-radius: 8px;">
                            <div>
                                <p class="file-upload-text mb-1">${file.name}</p>
                                <p class="file-upload-hint">Klik untuk mengubah foto</p>
                            </div>
                        </div>
                    `;
                    previewContainer.innerHTML = previewContent;
                };

                reader.readAsDataURL(file);
            } else {
                // Reset to original state
                previewContainer.style.display = 'none';
                previewContainer.innerHTML = '';

                // Show appropriate content based on whether existing image exists
                if (existingImageContainer) {
                    existingImageContainer.style.display = 'flex';
                    uploadContent.style.display = 'none';
                } else {
                    uploadContent.style.display = 'flex';
                }
            }
        });

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
                uploadInput.files = e.dataTransfer.files;
                uploadInput.dispatchEvent(new Event('change'));
            }
        });

        // Form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const requiredFields = this.querySelectorAll('[required]');
            let isValid = true;

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
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
