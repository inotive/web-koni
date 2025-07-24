@extends('layouts.app')
@section('pageTitle', 'Edit Data Pelatih')
@section('mainSection', 'Konfigurasi')
@section('mainSectionUrl', route('admin.konfigurasi.pelatih.index'))
@section('subSection', 'Pelatih')
@section('subSectionUrl', route('admin.konfigurasi.pelatih.index'))
@section('currentSection', 'Edit Data Pelatih')

@section('content')
    <style>
    body {
        background-color: #f5f5f5 !important;
    }

    .main-content {
        background-color: #f5f5f5;
        min-height: 100vh;
        padding: 20px 0;
    }

    .card-form {
        background-color: white;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        border: 1px solid #e9ecef;
    }

    .form-label {
        font-weight: 600;
        color: #2c3e50;
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
        border-color: #e91e63;
        background-color: #f1f1f1;
    }

    .file-upload-wrapper input[type="file"] {
        display: none;
    }

    .file-upload-icon {
        font-size: 2.5rem;
        color: #e91e63;
    }

    .file-upload-text {
        color: #495057;
        font-weight: 500;
    }

    .file-upload-hint {
        color: #6c757d;
        font-size: 0.9em;
    }

    .form-control, .form-select {
        border-radius: 8px;
        padding: 10px 14px;
        font-size: 0.95rem;
    }

    .form-control:focus, .form-select:focus {
        border-color: #e91e63;
        box-shadow: 0 0 0 0.2rem rgba(233, 30, 99, 0.2);
    }

    .invalid-feedback {
        font-size: 0.85rem;
        color: #e74c3c;
    }

    h3.fw-bold {
        color: #2c3e50;
        font-size: 1.6rem;
        font-weight: 700;
    }

    </style>
                <div class="d-flex justify-content-between align-items-center flex-wrap mb-4" style="padding: 20px 30px">
                    <h3 class="fw-bold fs-2 mb-0 text-dark">Edit Pelatih</h3>
                </div>
<div class="main-content">
    <div class="container mt-4">
        <div class="card card-form">
            <div class="card-body p-4 p-md-5">
                <h3 class="fw-bold mb-4">Edit Data Pelatih</h3>

                  <form action="{{ route('admin.konfigurasi.pelatih.update', $pelatih->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row align-items-center mb-4">
                        <div class="col-md-3">
                            <label for="foto" class="form-label">Foto</label>
                        </div>
                        <div class="col-md-9">
                            <label for="foto" class="file-upload-wrapper">
                                <input type="file" name="foto" id="foto"
                                    class="@error('foto') is-invalid @enderror">
                                <div class="d-flex justify-content-center align-items-center">
                                    @if ($pelatih->foto)
                                        <img src="{{ Storage::url($pelatih->foto) }}" alt="Foto Pelatih"
                                            class="current-photo me-3">
                                    @else
                                        <i class="fas fa-cloud-upload-alt file-upload-icon me-3"></i>
                                    @endif
                                    <div>
                                        <p class="file-upload-text mb-1">Klik atau seret file baru untuk mengubah</p>
                                        <p class="file-upload-hint" id="file-name-display">Kosongkan jika tidak ingin
                                            mengubah foto</p>
                                    </div>
                                </div>
                                @error('foto')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </label>
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
                            ], // This field is for design purposes
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
                                @php
                                    $value = old($key, $pelatih->{$key} ?? '');
                                    if ($field['type'] === 'date' && !empty($value)) {
                                        $value = \Carbon\Carbon::parse($value)->format('Y-m-d');
                                    }
                                @endphp
                                @if ($field['type'] === 'select')
                                    <select name="{{ $key }}" id="{{ $key }}"
                                        class="form-select @error($key) is-invalid @enderror">
                                        <option value="">Pilih {{ $field['label'] }}</option>
                                        @foreach ($field['options'] as $option)
                                            <option value="{{ $option }}" {{ $value == $option ? 'selected' : '' }}>
                                                {{ $option }}</option>
                                        @endforeach
                                    </select>
                                @elseif ($field['type'] === 'select-static')
                                    <select name="{{ $key }}" id="{{ $key }}" class="form-select"
                                        disabled>
                                        <option value="Tersedia" selected>Tersedia</option>
                                    </select>
                                    <small class="text-muted">Fitur ini belum diimplementasikan.</small>
                                @elseif ($field['type'] === 'textarea')
                                    <textarea name="{{ $key }}" id="{{ $key }}" class="form-control @error($key) is-invalid @enderror"
                                        placeholder="{{ $field['placeholder'] }}" rows="3">{{ $value }}</textarea>
                                @else
                                    <input type="{{ $field['type'] }}" name="{{ $key }}"
                                        id="{{ $key }}" class="form-control @error($key) is-invalid @enderror"
                                        placeholder="{{ $field['placeholder'] ?? '' }}" value="{{ $value }}">
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
                            <a href="{{ route('admin.konfigurasi.pelatih.index') }}"
                                class="btn btn-secondary px-4">Kembali</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

    <script>
        document.getElementById('foto').addEventListener('change', function(e) {
            const fileName = e.target.files[0] ? e.target.files[0].name :
            'Kosongkan jika tidak ingin mengubah foto';
            document.getElementById('file-name-display').textContent = fileName;
        });
    </script>
@endsection
