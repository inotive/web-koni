@extends('layouts.app')

@section('title', 'Edit Cabang Olahraga')

@section('content')
<style>
    /* Add styles from the 'Tambah Data Pelatih' form for consistent file upload look */
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

    /* Styles to match your existing form layout */
    .container.mt-4 form {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        border: 1px solid #e5e7eb;
        padding: 30px; /* Adjust padding as needed */
    }

    .container.mt-4 form .mb-3 {
        display: flex;
        align-items: center;
        margin-bottom: 24px;
        gap: 24px;
    }

    .container.mt-4 form label {
        width: 200px; /* Consistent label width */
        min-width: 200px;
        font-size: 14px;
        color: #252f4a;
        font-weight: 500;
    }

    .container.mt-4 form input[type="text"],
    .container.mt-4 form input[type="date"],
    .container.mt-4 form input[type="number"],
    .container.mt-4 form select {
        flex: 1; /* Makes input fields take remaining space */
        padding: 10px 15px; /* Adjust padding for inputs */
        font-size: 14px;
        border: 1px solid #dbdfe9;
        border-radius: 8px;
        background-color: #fcfcfc;
        transition: all 0.2s ease;
    }

    .container.mt-4 form input:focus,
    .container.mt-4 form select:focus {
        outline: none;
        border-color: #1b84ff;
        background-color: #fff;
        box-shadow: 0 0 0 3px rgba(27, 132, 255, 0.1);
    }

    .container.mt-4 .btn-primary {
        padding: 10px 20px;
        background-color: #d20a11;
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: background-color 0.2s ease;
    }

    .container.mt-4 .btn-primary:hover {
        background-color: #b91c1c;
    }

    .container.mt-4 .btn-secondary {
        padding: 10px 20px;
        background-color: #6b7280;
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: background-color 0.2s ease;
    }

    .container.mt-4 .btn-secondary:hover {
        background-color: #4b5563;
    }

    .current-icon-display {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 10px; /* Space between upload area and current icon */
        color: #495057;
        font-size: 0.9em;
    }

    .current-icon-display img {
        width: 50px; /* Adjust size as needed for preview */
        height: 50px;
        object-fit: contain;
        border: 1px solid #e0e0e0;
        border-radius: 4px;
    }

    /* Error feedback */
    .invalid-feedback {
        display: block; /* Ensure it's visible */
        width: 100%;
        margin-top: 0.25rem;
        font-size: 0.875em;
        color: #dc3545;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .container.mt-4 form .mb-3 {
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
        }

        .container.mt-4 form label,
        .file-upload-wrapper {
            width: 100%;
            min-width: 100%;
        }

        .container.mt-4 form input[type="text"],
        .container.mt-4 form input[type="date"],
        .container.mt-4 form input[type="number"],
        .container.mt-4 form select {
            width: 100%;
        }
    }
</style>

<div class="container mt-4">
    <div class="card card-form">
        <div class="card-body p-4 p-md-5">
            <h2 class="fw-bold mb-4">Edit Cabang Olahraga</h2>

            <form action="{{ route('admin.konfigurasi.cabang-olahraga.update', $cabor->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Icon Cabor File Upload Field --}}
                <div class="mb-3">
                    <label for="icon_cabor" class="form-label">Ikon Cabor</label>
                    <div>
                        <label for="icon_cabor" class="file-upload-wrapper">
                            <input type="file" name="icon_cabor" id="icon_cabor" class="@error('icon_cabor') is-invalid @enderror">
                            <i class="fas fa-cloud-upload-alt file-upload-icon mb-2"></i>
                            <p class="file-upload-text mb-1">Seret dan lepas file di sini, atau klik untuk mengunggah.</p>
                            <p class="file-upload-hint" id="file-name-display">80x80px PNG Files</p>
                        </label>
                        @error('icon_cabor') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror

                        @if($cabor->icon_cabor)
                        <div class="current-icon-display">
                            <p>Ikon saat ini:</p>
                            <img src="{{ asset('storage/' . $cabor->icon_cabor) }}" alt="Current Icon" class="img-fluid">
                            <span>{{ basename($cabor->icon_cabor) }}</span>
                        </div>
                        @else
                        <div class="current-icon-display">
                            <p>Belum ada ikon diunggah.</p>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="mb-3">
                    <label for="nama_cabor" class="form-label">Nama Cabang Olahraga</label>
                    <input type="text" name="nama_cabor" id="nama_cabor" class="form-control @error('nama_cabor') is-invalid @enderror" value="{{ old('nama_cabor', $cabor->nama_cabor) }}" required>
                    @error('nama_cabor') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="ketua_penanggung_jawab" class="form-label">Ketua Penanggung Jawab</label>
                    <input type="text" name="ketua_penanggung_jawab" id="ketua_penanggung_jawab" class="form-control @error('ketua_penanggung_jawab') is-invalid @enderror" value="{{ old('ketua_penanggung_jawab', $cabor->ketua_penanggung_jawab) }}" required>
                    @error('ketua_penanggung_jawab') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status Keaktifan</label>
                    <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                        <option value="Aktif" {{ old('status', $cabor->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="Tidak Aktif" {{ old('status', $cabor->status) == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                    @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="tanggal_pembentukan" class="form-label">Tanggal Pembentukan</label>
                    <input type="date" name="tanggal_pembentukan" id="tanggal_pembentukan" class="form-control @error('tanggal_pembentukan') is-invalid @enderror" value="{{ old('tanggal_pembentukan', $cabor->tanggal_pembentukan) }}" required>
                    @error('tanggal_pembentukan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="jumlah_atlet" class="form-label">Jumlah Atlet</label>
                    <input type="number" name="jumlah_atlet" id="jumlah_atlet" class="form-control @error('jumlah_atlet') is-invalid @enderror" value="{{ old('jumlah_atlet', $cabor->jumlah_atlet) }}" required>
                    @error('jumlah_atlet') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="jumlah_pelatih" class="form-label">Jumlah Pelatih</label>
                    <input type="number" name="jumlah_pelatih" id="jumlah_pelatih" class="form-control @error('jumlah_pelatih') is-invalid @enderror" value="{{ old('jumlah_pelatih', $cabor->jumlah_pelatih) }}" required>
                    @error('jumlah_pelatih') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('admin.konfigurasi.cabang-olahraga.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Update Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('icon_cabor').addEventListener('change', function(e) {
        const fileName = e.target.files[0] ? e.target.files[0].name : '80x80px PNG Files';
        document.getElementById('file-name-display').textContent = fileName;
    });
</script>
@endsection