@extends('layouts.app')
@section('pageTitle', 'Tambah Data Pelatih')
@section('mainSection', 'Konfigurasi')
@section('subSection', 'Pelatih')
@section('subSectionUrl', route('admin.konfigurasi.pelatih.index'))
@section('currentSection', 'Tambah Data Pelatih')
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
</style>

    <div class="d-flex justify-content-between align-items-center flex-wrap mb-4" style="padding: 20px 20px">
                        <h3 class="fw-bold fs-2 mb-0 text-dark">Tambah Pelatih</h3>
    </div>
<div class="main-content">
    <div class="container-fluid">
        <div class="row">

        <div class="card card-form">
            <div class="card-body p-4 p-md-5">
                <h3 class="fw-bold mb-4">Tambah Data</h3>
                <form action="{{ route('admin.konfigurasi.pelatih.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row align-items-start mb-4">
                <div class="col-md-3">
                    <label for="foto" class="form-label"></label>
                    <p class="file-upload-hint">150x150px JPEG, PNG Image</p>
                </div>
                <div class="col-md-9">
                    <label for="foto" class="file-upload-wrapper">
                        <input type="file" name="foto" id="foto" class="@error('foto') is-invalid @enderror">
                        <div class="file-upload-icon-wrapper">
                            <i class="fas fa-upload file-upload-icon"></i>
                        </div>
                        <div>
                            <p class="file-upload-text" id="file-name-display">Seret dan lepas file di sini, atau klik untuk mengunggah.</p>
                        </div>
                    </label>

                    @error('foto')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror

                    <div id="imagePreviewContainer" style="display: none;"></div>
                </div>
            </div>

                    @php
                        $fields = [
                            'nama' => ['label' => 'Nama', 'type' => 'text', 'placeholder' => 'Alessandro Benaya Pinem'],
                            'cabor' => [
                                'label' => 'Cabor',
                                'type' => 'select',
                                'options' => $cabors,
                                ],
                            'email' => [
                                'label' => 'Email',
                                'type' => 'email',
                                'placeholder' => 'emailpelatih@gmail.com',
                            ],
                            'ketersediaan' => [
                                'label' => 'Ketersediaan',
                                'type' => 'select-static',
                                'options' => ['Tersedia', 'Tidak Tersedia'],
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
                                'options' => ['Laki - Laki', 'Perempuan'],
                            ],
                            'alamat' => [
                                'label' => 'Alamat (Sesuai KTP)',
                                'type' => 'text',
                                'placeholder' => 'Jln Prapatan Dalam RT 43 NO.08, Kelurahan Prapatan',
                            ],
                            // 'prestasi' => ['label' => 'Prestasi', 'type' => 'textarea', 'placeholder' => 'Tuliskan prestasi yang diraih, pisahkan dengan baris baru...'],
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
                                        class="form-select @error($key) is-invalid @enderror">
                                        <option value="">Pilih {{ $field['label'] }}</option>
                                        @foreach ($field['options'] as $option)
                                            <option value="{{ $option }}"
                                                {{ old($key) == $option ? 'selected' : '' }}>{{ $option }}</option>
                                        @endforeach
                                    </select>
                                @elseif ($field['type'] === 'select-static')
                                    <select name="{{ $key }}" id="{{ $key }}" class="form-select"
                                        disabled>
                                        <option value="Tersedia">Tersedia</option>
                                    </select>
                                    <small class="text-muted">Fitur ini belum diimplementasikan.</small>
                                @elseif ($field['type'] === 'textarea')
                                    <textarea name="{{ $key }}" id="{{ $key }}" class="form-control @error($key) is-invalid @enderror"
                                        placeholder="{{ $field['placeholder'] }}" rows="3">{{ old($key) }}</textarea>
                                @else
                                    <input type="{{ $field['type'] }}" name="{{ $key }}"
                                        id="{{ $key }}" class="form-control @error($key) is-invalid @enderror"
                                        placeholder="{{ $field['placeholder'] ?? '' }}" value="{{ old($key) }}">
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
            const uploadInput = document.getElementById('foto');
            const fileNameDisplay = document.getElementById('file-name-display');
            const previewContainer = document.getElementById('imagePreviewContainer');

            uploadInput.addEventListener('change', function () {
                const file = this.files[0];
                if (file) {
                    fileNameDisplay.textContent = file.name;

                    if (!file.type.startsWith('image/')) {
                        alert('Hanya file gambar yang diizinkan.');
                        previewContainer.style.display = 'none';
                        previewContainer.innerHTML = '';
                        return;
                    }

                    const reader = new FileReader();

                    reader.onload = function (e) {
                        previewContainer.style.display = 'flex';
                        previewContainer.style.justifyContent = 'center';
                        previewContainer.style.alignItems = 'center';
                        previewContainer.innerHTML = `
                            <div class="d-flex justify-content-center align-items-center mt-3">
                                <img src="${e.target.result}" class="preview-image me-3" alt="Preview Foto"
                                    style="width: 150px; height: 150px; object-fit: cover; border-radius: 8px;">
                            </div>
                        `;
                    };

                    reader.readAsDataURL(file);
                } else {
                    fileNameDisplay.textContent = '150x150px JPEG, PNG Image';
                    previewContainer.style.display = 'none';
                    previewContainer.innerHTML = '';
                }
            });
        });
    </script>

@endsection
