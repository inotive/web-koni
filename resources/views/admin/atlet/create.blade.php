@extends('layouts.app')
@section('pageTitle', 'Tambah Atlet')
@section('mainSection', 'Konfigurasi')
@section('mainSectionUrl', route('admin.konfigurasi.atlet.index'))
@section('subSection', 'Atlet')
@section('subSectionUrl', route('admin.konfigurasi.atlet.index'))
@section('currentSection', 'Tambah Atlet')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/create.css') }}">
@endpush

@section('breadcrumb-title')
    <h1 class="text-dark fw-bold fs-3 mb-0">Tambah Atlet</h1>
@endsection

@section('content')

    <style>
        .form-main-container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .form-card {
            width: 100%;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            border: 1px solid #e5e7eb;
            overflow: hidden;
        }

        .form-card-header {
            padding: 24px 32px;
            border-bottom: 1px solid #f1f1f4;
        }

        .form-card-title {
            font-size: 18px;
            font-weight: 600;
            color: #071437;
            margin: 0;
        }

        .form-body {
            padding: 20px 32px;
        }

        /* Form Elements Improvements */
        .form-field {
            display: flex;
            align-items: center;
            margin-bottom: 24px;
            gap: 24px;
        }

        .form-label {
            width: 200px;
            min-width: 200px;
        }

        .form-label-text {
            font-size: 14px;
            color: #252f4a;
            font-weight: 500;
        }

        .form-input,
        .form-select,
        .form-textarea {
            flex: 1;
            padding: 14px 16px;
            font-size: 14px;
            border: 1px solid #dbdfe9;
            border-radius: 8px;
            background-color: #fcfcfc;
            transition: all 0.2s ease;
        }

        .form-input:focus,
        .form-select:focus,
        .form-textarea:focus {
            outline: none;
            border-color: #1b84ff;
            background-color: #fff;
            box-shadow: 0 0 0 3px rgba(27, 132, 255, 0.1);
        }

        .form-textarea {
            min-height: 100px;
            resize: vertical;
        }

        /* Upload Section Improvements */
        .upload-container {
            display: flex;
            margin-bottom: 24px;
            gap: 24px;
        }

        .upload-label {
            width: 200px;
            min-width: 200px;
        }

        .upload-info {
            font-size: 13px;
            color: #6b7280;
            margin-top: 4px;
        }

        .upload-box {
            flex: 1;
            padding: 24px;
            border: 2px dashed #1b84ff;
            border-radius: 8px;
            background-color: #eff6ff;
            display: flex;
            align-items: center;
            gap: 16px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .upload-box:hover {
            background-color: #e0f2fe;
            border-color: #0369a1;
        }

        .upload-icon {
            width: 48px;
            height: 48px;
            color: #1b84ff;
        }

        .upload-text {
            font-size: 14px;
            color: #252f4a;
            font-weight: 500;
        }

        .hidden {
            display: none !important;
        }

        .preview-image {
            max-width: 250px;
            max-height: 250px;
            border-radius: 8px;
            margin-top: 16px;
            border: 1px solid #e5e7eb;
            object-fit: cover;
        }

        #imagePreviewContainer {
            margin-top: 16px;
        }

        /* Buttons Improvements */
        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 16px;
            padding: 24px 32px;
            border-top: 1px solid #f1f1f4;
        }

        .btn-primary {
            padding: 14px 24px;
            background-color: #d20a11;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .btn-primary:hover {
            background-color: #b91c1c;
        }

        .btn-secondary {
            padding: 14px 24px;
            background-color: #6b7280;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .btn-secondary:hover {
            background-color: #4b5563;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {

            .form-field,
            .upload-container {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }

            .form-label,
            .upload-label {
                width: 100%;
                min-width: 100%;
            }

            .form-body {
                padding: 16px;
            }

            .form-card-header,
            .form-actions {
                padding: 16px;
            }
        }
    </style>

    <div class="form-main-container">
        <div class="form-card">
            <div class="form-card-header">
                <h2 class="form-card-title">Tambah Data Atlet</h2>
            </div>

            <form action="{{ route('admin.konfigurasi.atlet.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-body">
                    <div class="upload-container">
                        <div class="upload-label">
                            <p class="form-label-text">Foto Atlet</p>
                            <p class="upload-info">150x150px JPEG, PNG Image</p>
                        </div>
                        <div style="flex: 1;">
                            <label for="foto_atlet" class="upload-box" id="dropArea">
                                <svg class="upload-icon" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M14 2H6C4.89543 2 4 2.89543 4 4V20C4 21.1046 4.89543 22 6 22H18C19.1046 22 20 21.1046 20 20V8L14 2Z"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path d="M14 2V8H20" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path d="M12 18V12" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path d="M9 15L12 12L15 15" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="upload-text">
                                    <p>Seret dan lepas file di sini, atau klik untuk mengunggah.</p>
                                </div>
                            </label>
                            <input type="file" class="hidden" id="foto_atlet" name="foto_atlet" accept="image/*">
                            <div id="imagePreviewContainer"></div>
                        </div>
                    </div>

                    <div class="form-field">
                        <div class="form-label">
                            <p class="form-label-text">Nama Lengkap</p>
                        </div>
                        <input type="text" class="form-input" name="nama" placeholder="Masukkan nama lengkap" required
                            value="{{ old('nama') }}">
                    </div>

                    <div class="form-field">
                        <div class="form-label">
                            <p class="form-label-text">Cabang Olahraga</p>
                        </div>
                        <select class="form-select" name="cabor" required>
                            <option value="">Pilih Cabang Olahraga</option>
                            <option value="Sepak Bola" {{ old('cabor') == 'Sepak Bola' ? 'selected' : '' }}>Sepak Bola
                            </option>
                            <option value="Basket" {{ old('cabor') == 'Basket' ? 'selected' : '' }}>Basket</option>
                            <option value="Badminton" {{ old('cabor') == 'Badminton' ? 'selected' : '' }}>Badminton</option>
                            <option value="Renang" {{ old('cabor') == 'Renang' ? 'selected' : '' }}>Renang</option>
                            <option value="Atletik" {{ old('cabor') == 'Atletik' ? 'selected' : '' }}>Atletik</option>
                            <option value="Tenis" {{ old('cabor') == 'Tenis' ? 'selected' : '' }}>Tenis</option>
                            <option value="Voli" {{ old('cabor') == 'Voli' ? 'selected' : '' }}>Voli</option>
                        </select>
                    </div>

                    <div class="form-field">
                        <div class="form-label">
                            <p class="form-label-text">Email</p>
                        </div>
                        <input type="email" class="form-input" name="email" placeholder="emailatlet@gmail.com"
                            value="{{ old('email') }}">
                    </div>

                    <div class="form-field">
                        <div class="form-label">
                            <p class="form-label-text">No Telepon</p>
                        </div>
                        <input type="text" class="form-input" name="no_telepon" placeholder="0895 9271 8263"
                            value="{{ old('no_telepon') }}">
                    </div>

                    <div class="form-field">
                        <div class="form-label">
                            <p class="form-label-text">Tanggal Lahir</p>
                        </div>
                        <input type="date" class="form-input" name="tanggal_lahir" required
                            value="{{ old('tanggal_lahir') }}">
                    </div>

                    <div class="form-field">
                        <div class="form-label">
                            <p class="form-label-text">Tempat Lahir</p>
                        </div>
                        <input type="text" class="form-input" name="tempat_lahir"
                            placeholder="Balikpapan, Kalimantan Timur" required value="{{ old('tempat_lahir') }}">
                    </div>

                    <div class="form-field">
                        <div class="form-label">
                            <p class="form-label-text">Jenis Kelamin</p>
                        </div>
                        <select class="form-select" name="jenis_kelamin" required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>
                                Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>
                                Perempuan</option>
                        </select>
                    </div>

                    <div class="form-field">
                        <div class="form-label">
                            <p class="form-label-text">Alamat (Sesuai KTP)</p>
                        </div>
                        <textarea class="form-textarea" name="alamat" placeholder="Jln Prapatan Dalam RT 43 NO.08, Kelurahan Prapatan"
                            required>{{ old('alamat') }}</textarea>
                    </div>

                </div>

                <div class="form-actions">
                    <a href="{{ route('admin.konfigurasi.atlet.index') }}" class="btn-secondary">Batal</a>
                    <button type="submit" class="btn-primary">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const uploadInput = document.getElementById('foto_atlet');
            const dropArea = document.getElementById('dropArea');
            const previewContainer = document.getElementById('imagePreviewContainer');

            // Image preview functionality
            uploadInput.addEventListener('change', function() {
                const file = this.files[0];

                // Clear previous preview
                previewContainer.innerHTML = '';

                if (file) {
                    if (!file.type.match('image.*')) {
                        alert('Hanya file gambar yang diizinkan');
                        return;
                    }

                    const reader = new FileReader();

                    reader.onload = function(e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'preview-image';
                        img.alt = 'Preview Foto Atlet';
                        previewContainer.appendChild(img);
                    };

                    reader.readAsDataURL(file);
                }
            });

            // Drag and drop functionality
            dropArea.addEventListener('dragover', (e) => {
                e.preventDefault();
                dropArea.style.borderColor = '#0369a1';
                dropArea.style.backgroundColor = '#e0f2fe';
            });

            dropArea.addEventListener('dragleave', () => {
                dropArea.style.borderColor = '#1b84ff';
                dropArea.style.backgroundColor = '#eff6ff';
            });

            dropArea.addEventListener('drop', (e) => {
                e.preventDefault();
                dropArea.style.borderColor = '#1b84ff';
                dropArea.style.backgroundColor = '#eff6ff';

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
    @endsection2
