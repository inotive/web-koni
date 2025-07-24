@extends('layouts.app')
@section('pageTitle', 'Tambah Data Pelatih')
@section('mainSection', 'Konfigurasi')
@section('mainSectionUrl', route('admin.konfigurasi.pelatih.index'))
@section('subSection', 'Pelatih')
@section('subSectionUrl', route('admin.konfigurasi.pelatih.index'))
@section('currentSection', 'Tambah Data Pelatih')

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
            padding: 2.5rem;
            text-align: center;
            cursor: pointer;
            background-color: #f8f9fa;
            transition: all 0.2s ease-in-out;
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

        .preview-image {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 8px;
        }
    </style>

    <div class="container mt-4">
        <div class="card card-form">
            <div class="card-body p-4 p-md-5">
                <h3 class="fw-bold mb-4">Tambah Data Pelatih</h3>

                <form action="{{ route('admin.konfigurasi.pelatih.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Bagian Foto -->
                    <div class="row align-items-center mb-4">
                        <div class="col-md-3">
                            <label for="foto" class="form-label">Foto</label>
                        </div>
                        <div class="col-md-9">
                            <label for="foto" class="file-upload-wrapper">
                                <input type="file" name="foto" id="foto"
                                    class="@error('foto') is-invalid @enderror">
                                <div id="uploadContent">
                                    <i class="fas fa-cloud-upload-alt file-upload-icon mb-2"></i>
                                    <p class="file-upload-text mb-1">Seret dan lepas file di sini, atau klik untuk
                                        mengunggah.</p>
                                    <p class="file-upload-hint" id="file-name-display">150x150px JPEG, PNG Image</p>
                                </div>
                                @error('foto')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <div id="imagePreviewContainer" style="display: none;"></div>
                            </label>
                        </div>
                    </div>

                    @php
                        $fields = [
                            'nama' => ['label' => 'Nama', 'type' => 'text', 'placeholder' => 'Alessandro Benaya Pinem'],
                            'cabor_id' => [
                                'label' => 'Cabang Olahraga',
                                'type' => 'select',
                                'options' => $cabors, // Pastikan $cabors dikirim sebagai [id => nama_cabor]
                            ],
                            'email' => [
                                'label' => 'Email',
                                'type' => 'email',
                                'placeholder' => 'emailpelatih@gmail.com',
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
                            'kelamin' => [
                                'label' => 'Jenis Kelamin',
                                'type' => 'select',
                                'options' => [
                                    'Laki-laki' => 'Laki-laki',
                                    'Perempuan' => 'Perempuan',
                                ],
                            ],
                            'alamat' => [
                                'label' => 'Alamat',
                                'type' => 'text',
                                'placeholder' => 'Jln Prapatan Dalam RT 43 NO.08, Kelurahan Prapatan',
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
                                        {{ $key === 'cabor_id' ? 'required' : '' }}>
                                        <option value="">Pilih {{ $field['label'] }}</option>
                                        @foreach ($field['options'] as $id => $nama)
                                            <option value="{{ $id }}" {{ old($key) == $id ? 'selected' : '' }}>
                                                {{ $nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                @else
                                    <input type="{{ $field['type'] }}" name="{{ $key }}"
                                        id="{{ $key }}" class="form-control @error($key) is-invalid @enderror"
                                        placeholder="{{ $field['placeholder'] ?? '' }}" value="{{ old($key) }}"
                                        {{ in_array($key, ['nama', 'cabor_id', 'tanggal_lahir', 'tempat_lahir', 'kelamin', 'alamat']) ? 'required' : '' }}>
                                @endif
                                @error($key)
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    @endforeach

                    <div class="row mt-4">
                        <div class="col-md-9 offset-md-3">
                            <button type="submit" class="btn btn-danger px-4">Simpan Data</button>
                            <a href="{{ route('admin.konfigurasi.pelatih.index') }}"
                                class="btn btn-secondary px-4 ms-2">Batal</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const uploadInput = document.getElementById('foto');
            const uploadContent = document.getElementById('uploadContent');
            const previewContainer = document.getElementById('imagePreviewContainer');
            const fileNameDisplay = document.getElementById('file-name-display');

            uploadInput.addEventListener('change', function() {
                const file = this.files[0];

                if (file) {
                    fileNameDisplay.textContent = file.name;

                    if (!file.type.match('image.*')) {
                        alert('Hanya file gambar yang diizinkan');
                        return;
                    }

                    uploadContent.style.display = 'none';
                    previewContainer.style.display = 'block';
                    previewContainer.innerHTML = '';

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewContainer.innerHTML = `
                            <div class="d-flex justify-content-center align-items-center">
                                <img src="${e.target.result}" class="preview-image" alt="Preview Foto">
                                <div class="ms-3">
                                    <p class="file-upload-text mb-1">${file.name}</p>
                                    <p class="file-upload-hint">Klik untuk mengubah foto</p>
                                </div>
                            </div>
                        `;
                    };
                    reader.readAsDataURL(file);
                } else {
                    fileNameDisplay.textContent = '150x150px JPEG, PNG Image';
                    uploadContent.style.display = 'block';
                    previewContainer.style.display = 'none';
                    previewContainer.innerHTML = '';
                }
            });
        });
    </script>
@endsection
