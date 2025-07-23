@extends('layouts.app')

@section('pageTitle', 'Tambah Cabang Olahraga')
@section('mainSection', 'Manajemen Cabang Olahraga')
@section('currentSection', 'Tambah Cabang Olahraga')

@section('breadcrumb-title')
    <h1 class="text-dark fw-bold fs-3 mb-0">Tambah Cabang Olahraga</h1>
@endsection

@section('content')
<style>
    /* Existing styles from your form */
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

    .form-input, .form-select {
        flex: 1;
        padding: 14px 16px;
        font-size: 14px;
        border: 1px solid #dbdfe9;
        border-radius: 8px;
        background-color: #fcfcfc;
        transition: all 0.2s ease;
    }

    .form-input:focus, .form-select:focus {
        outline: none;
        border-color: #1b84ff;
        background-color: #fff;
        box-shadow: 0 0 0 3px rgba(27, 132, 255, 0.1);
    }

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

    @media (max-width: 768px) {
        .form-field {
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
        }

        .form-label {
            width: 100%;
            min-width: 100%;
        }

        .form-body {
            padding: 16px;
        }

        .form-card-header, .form-actions {
            padding: 16px;
        }
    }

    /* Styles for file upload from your friend's form */
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
        flex: 1; /* Added to make it fill available space */
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
</style>

<div class="form-card">
    <div class="form-card-header">
        <div class="flex items-center gap-2">
            {{-- Assuming you want an icon here, you might need to adjust based on your icon library (e.g., Font Awesome, Lucide) --}}
            {{-- <i data-lucide="dumbbell" class="w-6 h-6 text-red-600"></i> --}}
            <h2 class="form-card-title">Tambah Cabang Olahraga</h2>
        </div>
    </div>

    <form action="{{ route('admin.konfigurasi.cabang-olahraga.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-body">
            {{-- File Upload Field --}}
            <div class="form-field">
                <div class="form-label"><p class="form-label-text">Ikon Cabor</p></div>
                <label for="icon_cabor" class="file-upload-wrapper">
                    <input type="file" name="icon_cabor" id="icon_cabor" class="@error('icon_cabor') is-invalid @enderror">
                    <i class="fas fa-cloud-upload-alt file-upload-icon mb-2"></i> {{-- Requires Font Awesome --}}
                    <p class="file-upload-text mb-1">Seret dan lepas file di sini, atau klik untuk mengunggah.</p>
                    <p class="file-upload-hint" id="file-name-display">80x80px PNG Files</p>
                    @error('icon_cabor') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </label>
            </div>

            <div class="form-field">
                <div class="form-label"><p class="form-label-text">Nama Cabor</p></div>
                <input type="text" class="form-input" name="nama_cabor" value="{{ old('nama_cabor') }}" required>
                @error('nama_cabor') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            </div>

            <div class="form-field">
                <div class="form-label"><p class="form-label-text">Ketua Penanggung Jawab</p></div>
                <input type="text" class="form-input" name="ketua_penanggung_jawab" value="{{ old('ketua_penanggung_jawab') }}" required>
                @error('ketua_penanggung_jawab') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            </div>

            <div class="form-field">
                <div class="form-label"><p class="form-label-text">Status</p></div>
                <select name="status" class="form-select" required>
                    <option value="Aktif" {{ old('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="Tidak Aktif" {{ old('status') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
                @error('status') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            </div>

            <div class="form-field">
                <div class="form-label"><p class="form-label-text">Tanggal Pembentukan</p></div>
                <input type="date" class="form-input" name="tanggal_pembentukan" value="{{ old('tanggal_pembentukan') }}" required>
                @error('tanggal_pembentukan') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            </div>

            <div class="form-field">
                <div class="form-label"><p class="form-label-text">Jumlah Atlet</p></div>
                <input type="number" class="form-input" name="jumlah_atlet" value="{{ old('jumlah_atlet') }}" required>
                @error('jumlah_atlet') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            </div>

            <div class="form-field">
                <div class="form-label"><p class="form-label-text">Jumlah Pelatih</p></div>
                <input type="number" class="form-input" name="jumlah_pelatih" value="{{ old('jumlah_pelatih') }}" required>
                @error('jumlah_pelatih') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('admin.konfigurasi.cabang-olahraga.index') }}" class="btn-secondary">Batal</a>
            <button type="submit" class="btn-primary">Simpan Data</button>
        </div>
    </form>
</div>

<script>
    document.getElementById('icon_cabor').addEventListener('change', function(e) {
        const fileName = e.target.files[0] ? e.target.files[0].name : '80x80px PNG Files';
        document.getElementById('file-name-display').textContent = fileName;
    });
</script>
@endsection