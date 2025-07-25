@extends('layouts.app')
@section('pageTitle', 'Edit Data Pelatih')
@section('mainSection', 'Konfigurasi')
@section('mainSectionUrl', route('admin.konfigurasi.pelatih.index'))
@section('subSection', 'Pelatih')
@section('subSectionUrl', route('admin.konfigurasi.pelatih.index'))
@section('currentSection', 'Edit Data Pelatih')

@section('content')
    <style>
        /* CSS sama seperti di create.blade.php */
        .current-photo {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 8px;
        }
    </style>

    <div class="container mt-4">
        <div class="card card-form">
            <div class="card-body p-4 p-md-5">
                <h3 class="fw-bold mb-4">Edit Data Pelatih</h3>

                <form action="{{ route('admin.konfigurasi.pelatih.update', $pelatih->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Bagian Foto -->
                    <div class="row align-items-center mb-4">
                        <div class="col-md-3">
                            <label for="foto" class="form-label">Foto</label>
                        </div>
                        <div class="col-md-9">
                            <label for="foto" class="file-upload-wrapper">
                                <input type="file" name="foto" id="foto" class="@error('foto') is-invalid @enderror">
                                <div class="d-flex justify-content-center align-items-center">
                                    @if ($pelatih->foto)
                                        <img src="{{ Storage::url($pelatih->foto) }}" alt="Foto Pelatih" class="current-photo me-3">
                                    @else
                                        <i class="fas fa-cloud-upload-alt file-upload-icon me-3"></i>
                                    @endif
                                    <div>
                                        <p class="file-upload-text mb-1">Klik atau seret file baru untuk mengubah</p>
                                        <p class="file-upload-hint" id="file-name-display">Kosongkan jika tidak ingin mengubah foto</p>
                                    </div>
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
                                'options' => $cabors,
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
                                'options' => ['Laki-laki', 'Perempuan'],
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
                                @php
                                    $value = old($key, $pelatih->{$key} ?? '');
                                    if ($field['type'] === 'date' && $value) {
                                        $value = \Carbon\Carbon::parse($value)->format('Y-m-d');
                                    }
                                @endphp
                                @if ($field['type'] === 'select')
                                    <select name="{{ $key }}" id="{{ $key }}" 
                                        class="form-select @error($key) is-invalid @enderror"
                                        {{ $key === 'cabor_id' ? 'required' : '' }}>
                                        <option value="">Pilih {{ $field['label'] }}</option>
                                        @foreach ($field['options'] as $id => $nama)
                                            <option value="{{ $id }}" {{ $value == $id ? 'selected' : '' }}>
                                                {{ $nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                @else
                                    <input type="{{ $field['type'] }}" name="{{ $key }}" id="{{ $key }}"
                                        class="form-control @error($key) is-invalid @enderror"
                                        placeholder="{{ $field['placeholder'] ?? '' }}" 
                                        value="{{ $value }}"
                                        {{ in_array($key, ['nama', 'cabor_id', 'tanggal_lahir', 'tempat_lahir', 'kelamin', 'alamat']) ? 'required' : '' }}>
                                @endif
                                @error($key)
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    @endforeach

                    <div class="row mt-4">
                        <div class="col-md-9 offset-md-3 d-flex justify-content-between">
                            <button type="submit" class="btn btn-danger px-4">Simpan Perubahan</button>
                            <a href="{{ route('admin.konfigurasi.pelatih.index') }}" class="btn btn-secondary px-4">Kembali</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const uploadInput = document.getElementById('foto');
            const fileNameDisplay = document.getElementById('file-name-display');
            const previewContainer = document.getElementById('imagePreviewContainer');

            uploadInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    fileNameDisplay.textContent = file.name;

                    if (!file.type.match('image.*')) {
                        alert('Hanya file gambar yang diizinkan');
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewContainer.style.display = 'block';
                        previewContainer.innerHTML = `
                            <div class="d-flex justify-content-center align-items-center mt-3">
                                <img src="${e.target.result}" class="preview-image me-3" 
                                     style="width: 150px; height: 150px; object-fit: cover; border-radius: 8px;">
                                <div>
                                    <p class="file-upload-text mb-1">${file.name}</p>
                                    <p class="file-upload-hint">Klik untuk mengubah foto</p>
                                </div>
                            </div>
                        `;
                    };
                    reader.readAsDataURL(file);
                } else {
                    fileNameDisplay.textContent = 'Kosongkan jika tidak ingin mengubah foto';
                    previewContainer.style.display = 'none';
                    previewContainer.innerHTML = '';
                }
            });
        });
    </script>
@endsection