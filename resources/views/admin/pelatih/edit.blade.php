@extends('layouts.app')
@section('pageTitle', 'Edit Data Pelatih')
@section('mainSection', 'Konfigurasi')
@section('mainSectionUrl', route('admin.konfigurasi.pelatih.index'))
@section('subSection', 'Pelatih')
@section('subSectionUrl', route('admin.konfigurasi.pelatih.index'))
@section('currentSection', 'Edit Data Pelatih')

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
    </style>

    <div class="container mt-4">
        <div class="card card-form">
            <div class="card-body p-4 p-md-5">
                <h3 class="fw-bold mb-4">Edit Data Pelatih</h3>

                [cite_start]<form action="{{ route('admin.konfigurasi.pelatih.update', $pelatih->id) }}" method="POST"
                    enctype="multipart/form-data"> [cite: 580]
                    @csrf
                    [cite_start]@method('PUT') [cite: 582]

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

    <script>
        document.getElementById('foto').addEventListener('change', function(e) {
            const fileName = e.target.files[0] ? e.target.files[0].name :
            'Kosongkan jika tidak ingin mengubah foto';
            document.getElementById('file-name-display').textContent = fileName;
        });
    </script>
@endsection
