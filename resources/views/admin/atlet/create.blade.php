@extends('layouts.app')
@section('pageTitle', 'Tambah Atlet')
@section('mainSection', 'Konfigurasi')
@section('subSection', 'Atlet')
@section('subSectionUrl', route('admin.konfigurasi.atlet.index'))
@section('currentSection', 'Tambah Atlet')

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
            max-width: 100px;
            max-height: 100px;
            border-radius: 8px;
            object-fit: cover;
        }
    </style>

    <div class="d-flex justify-content-between align-items-center flex-wrap mb-4" style="padding: 20px 20px">
        <h3 class="fw-bold fs-2 mb-0 text-dark">Tambah Atlet</h3>
    </div>

    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="card card-form">
                    <div class="card-body p-4 p-md-5">
                        <h3 class="fw-bold mb-4">Tambah Data</h3>
                        <form action="{{ route('admin.konfigurasi.atlet.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row align-items-start mb-4">
                                <div class="col-md-3">
                                    <label class="form-label">Foto Atlet</label>
                                    <p class="file-upload-hint">150×150 px JPEG, PNG Image</p>
                                </div>
                                <div class="col-md-9">
                                    <label for="foto_atlet" class="file-upload-wrapper">
                                        <input type="file" name="foto_atlet" id="foto_atlet"
                                            class="@error('foto_atlet') is-invalid @enderror" accept="image/*">

                                        <div class="d-flex align-items-center gap-12">
                                            <div class="file-upload-icon-wrapper">
                                                <i class="fas fa-upload file-upload-icon"></i>
                                            </div>
                                            <div>
                                                <p class="file-upload-text" id="file-name-display">
                                                    Seret dan lepas file di sini, atau klik untuk mengunggah.
                                                </p>
                                                <div id="imagePreviewContainer" class="mt-2"></div>
                                            </div>
                                        </div>
                                    </label>

                                    @error('foto_atlet')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            @php
                                $fields = [
                                    'nama' => [
                                        'label' => 'Nama Lengkap',
                                        'type' => 'text',
                                        'placeholder' => 'Masukkan nama lengkap',
                                    ],
                                    'cabor_id' => [
                                        'label' => 'Cabang Olahraga',
                                        'type' => 'select',
                                        'options' => $cabors->pluck('nama_cabor', 'id'),
                                    ],
                                    'email' => [
                                        'label' => 'Email',
                                        'type' => 'email',
                                        'placeholder' => 'emailatlet@gmail.com',
                                    ],
                                    'no_telepon' => [
                                        'label' => 'No Telepon',
                                        'type' => 'text',
                                        'placeholder' => '0895 9271 8263',
                                    ],
                                    'tanggal_lahir' => ['label' => 'Tanggal Lahir', 'type' => 'date'],
                                    'tempat_lahir' => [
                                        'label' => 'Tempat Lahir',
                                        'type' => 'text',
                                        'placeholder' => 'Balikpapan, Kalimantan Timur',
                                    ],
                                    'jenis_kelamin' => [
                                        'label' => 'Jenis Kelamin',
                                        'type' => 'select',
                                        'options' => [
                                            'Laki-laki' => 'Laki-laki',
                                            'Perempuan' => 'Perempuan',
                                        ],
                                    ],
                                    'alamat' => [
                                        'label' => 'Alamat (Sesuai KTP)',
                                        'type' => 'textarea',
                                        'placeholder' => 'Jln Prapatan Dalam RT 43 NO.08, Kelurahan Prapatan',
                                    ],
                                    'alamatprovinsi' => [
                                        'label' => 'Provinsi',
                                        'type' => 'text',
                                        'placeholder' => 'Contoh: Kalimantan Timur',
                                    ],
                                    'alamatkota' => [
                                        'label' => 'Kota/Kabupaten',
                                        'type' => 'text',
                                        'placeholder' => 'Contoh: Balikpapan',
                                    ],
                                    'alamatprovinsi' => [
                                        'label' => 'Provinsi',
                                        'type' => 'text',
                                        'placeholder' => 'Contoh: Kalimantan Timur',
                                    ],
                                    'alamatkota' => [
                                        'label' => 'Kota/Kabupaten',
                                        'type' => 'text',
                                        'placeholder' => 'Contoh: Balikpapan',
                                    ],
                                ];
                            @endphp

                            @foreach ($fields as $key => $field)
                                <div class="row align-items-center mb-3">
                                    <div class="col-md-3">
                                        <label for="{{ $key }}" class="form-label">{{ $field['label'] }}</label>
                                    </div>
                                    <div class="col-md-9">
                                        @if ($field['type'] === 'select')
                                            <select name="{{ $key }}" id="{{ $key }}"
                                                class="form-select @error($key) is-invalid @enderror"
{{ in_array($key, ['nama', 'cabor_id', 'tanggal_lahir', 'tempat_lahir', 'jenis_kelamin', 'alamat', 'alamatprovinsi', 'alamatkota']) ? 'required' : '' }}                                                <option value="">Pilih {{ $field['label'] }}</option>
                                                @if ($key === 'cabor_id')
                                                    @foreach ($field['options'] as $id => $nama)
                                                        <option value="{{ $id }}"
                                                            {{ old($key) == $id ? 'selected' : '' }}>
                                                            {{ $nama }}</option>
                                                    @endforeach
                                                @else
                                                    @foreach ($field['options'] as $value => $label)
                                                        <option value="{{ $value }}"
                                                            {{ old($key) == $value ? 'selected' : '' }}>
                                                            {{ $label }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        @elseif ($field['type'] === 'textarea')
                                            <textarea name="{{ $key }}" id="{{ $key }}" class="form-control @error($key) is-invalid @enderror"
                                                placeholder="{{ $field['placeholder'] }}" rows="3"
                                                {{ in_array($key, ['nama', 'cabor_id', 'tanggal_lahir', 'tempat_lahir', 'jenis_kelamin', 'alamat']) ? 'required' : '' }}>{{ old($key) }}</textarea>
                                        @else
                                            <input type="{{ $field['type'] }}" name="{{ $key }}"
                                                id="{{ $key }}"
                                                class="form-control @error($key) is-invalid @enderror"
                                                placeholder="{{ $field['placeholder'] ?? '' }}"
                                                value="{{ old($key) }}"
                                                {{ in_array($key, ['nama', 'cabor_id', 'tanggal_lahir', 'tempat_lahir', 'jenis_kelamin', 'alamat']) ? 'required' : '' }}>
                                        @endif
                                        @error($key)
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            @endforeach

                            <div class="row mt-4">
                                <div class="col-md-9 offset-md-3 d-flex justify-content-between">
                                    <button type="submit" class="btn btn-danger px-4">Simpan Data</button>
                                    <a href="{{ route('admin.konfigurasi.atlet.index') }}"
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
            const uploadInput = document.getElementById('foto_atlet');
            const uploadContent = document.getElementById('uploadContent');
            const previewContainer = document.getElementById('imagePreviewContainer');
            const fileNameDisplay = document.getElementById('file-name-display');

            uploadInput.addEventListener('change', function() {
                const file = this.files[0];

                if (file) {
                    if (!file.type.match('image.*')) {
                        alert('Hanya file gambar yang diizinkan');
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        fileNameDisplay.style.display = 'none';

                        previewContainer.innerHTML = `
                <div class="d-flex align-items-center mt-2">
                    <img src="${e.target.result}" class="preview-image" alt="Preview">
                    <span class="ms-2 file-upload-text">${file.name}</span>
                </div>
            `;
                    };

                    reader.readAsDataURL(file);
                } else {
                    fileNameDisplay.style.display = '';
                    fileNameDisplay.textContent =
                        'Seret dan lepas file di sini, atau klik untuk mengunggah.';
                    previewContainer.innerHTML = '';
                }
            });

            const fileUploadWrapper = document.querySelector('.file-upload-wrapper');

            fileUploadWrapper.addEventListener('dragover', (e) => {
                e.preventDefault();
                fileUploadWrapper.style.borderColor = '#0d6efd';
                fileUploadWrapper.style.backgroundColor = '#e6f0ff';
            });

            fileUploadWrapper.addEventListener('dragleave', () => {
                fileUploadWrapper.style.borderColor = '#cfe2ff';
                fileUploadWrapper.style.backgroundColor = '#edf5ff';
            });

            fileUploadWrapper.addEventListener('drop', (e) => {
                e.preventDefault();
                fileUploadWrapper.style.borderColor = '#cfe2ff';
                fileUploadWrapper.style.backgroundColor = '#edf5ff';

                if (e.dataTransfer.files.length) {
                    uploadInput.files = e.dataTransfer.files;
                    uploadInput.dispatchEvent(new Event('change'));
                }
            });
        });
    </script>

@endsection
