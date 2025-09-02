@extends('layouts.app')

@section('pageTitle', 'Detail Laporan Kegiatan Lainnya')
@section('mainSection', 'Laporan Pertanggungjawaban')
@section('subSection', 'Kegiatan Lainnya')
@section('subSectionUrl', route('admin.laporan-lpj.kegiatan-lainnya.index'))
@section('currentSection', 'Detail Laporan')

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

        .currency-input {
            position: relative;
        }

        .currency-input::before {
            content: "Rp";
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            font-size: 0.95rem;
            z-index: 1;
        }

        .currency-input input {
            padding-left: 35px;
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

        .file-upload-wrapper.dragover {
            border-color: #0d6efd;
            background-color: #e6f0ff;
            transform: scale(1.02);
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

        .preview-container {
            max-height: 300px;
            overflow-y: auto;
            margin-top: 15px;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 15px;
            background-color: #f8f9fa;
        }

        .file-preview-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            background-color: white;
            margin-bottom: 8px;
            transition: all 0.2s ease;
        }

        .file-preview-item:hover {
            border-color: #0d6efd;
            box-shadow: 0 2px 8px rgba(13, 110, 253, 0.1);
        }

        .file-preview-item:last-child {
            margin-bottom: 0;
        }

        .preview-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 6px;
            border: 1px solid #e9ecef;
        }

        .file-icon {
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa;
            border-radius: 6px;
            border: 1px solid #e9ecef;
        }

        .file-info {
            flex: 1;
        }

        .file-name {
            font-weight: 500;
            color: #212529;
            margin-bottom: 4px;
            word-break: break-all;
        }

        .file-size {
            font-size: 0.8rem;
            color: #6c757d;
        }

        .remove-file {
            background: none;
            border: none;
            color: #dc3545;
            font-size: 1.2rem;
            cursor: pointer;
            padding: 5px;
            border-radius: 4px;
            transition: all 0.2s ease;
        }

        .remove-file:hover {
            background-color: #dc3545;
            color: white;
        }

        .file-counter {
            font-size: 0.85rem;
            color: #6c757d;
            margin-top: 8px;
        }

        .max-files-warning {
            color: #e74c3c;
            font-size: 0.85rem;
            margin-top: 8px;
        }

        .existing-files-section {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
        }

        .existing-files-section h6 {
            color: #495057;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .section-divider {
            border: none;
            height: 2px;
            background: linear-gradient(to right, #e9ecef, #dee2e6, #e9ecef);
            margin: 30px 0;
        }
    </style>

    <div class="d-flex justify-content-between align-items-center flex-wrap mb-4" style="padding: 20px 20px">
        <h3 class="fw-bold fs-2 mb-0 text-dark">Detail Laporan Kegiatan Lainnya</h3>
    </div>

    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="card card-form">
                    <div class="card-body p-4 p-md-5">
                        <h3 class="fw-bold mb-4">Detail Laporan: {{ $kegiatanLainnya->nama_program }}</h3>

                        <form>
                            <div class="row align-items-center mb-3">
                                <div class="col-md-3">
                                    <label class="form-label">Nama Program & Kegiatan</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" value="{{ $kegiatanLainnya->nama_program }}" readonly>
                                </div>
                            </div>

                            <div class="row align-items-center mb-3">
                                <div class="col-md-3">
                                    <label class="form-label">Jenis Kegiatan</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" value="{{ $kegiatanLainnya->nama_kegiatan }}" readonly>
                                </div>
                            </div>

                            <div class="row align-items-center mb-3">
                                <div class="col-md-3">
                                    <label class="form-label">Volume</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" value="{{ $kegiatanLainnya->volume }}" readonly>
                                </div>
                            </div>

                            <div class="row align-items-center mb-3">
                                <div class="col-md-3">
                                    <label class="form-label">Harga Satuan</label>
                                </div>
                                <div class="col-md-9">
                                    <div class="currency-input">
                                        <input type="text" class="form-control" value="Rp {{ number_format($kegiatanLainnya->jumlah_harga_satuan, 0, ',', '.') }}" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row align-items-center mb-3">
                                <div class="col-md-3">
                                    <label class="form-label">Total Harga</label>
                                </div>
                                <div class="col-md-9">
                                    <div class="currency-input">
                                        <input type="text" class="form-control" value="Rp {{ number_format($kegiatanLainnya->jumlah_harga, 0, ',', '.') }}" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row align-items-start mb-4">
                                <div class="col-md-3">
                                    <label class="form-label">Foto Jurnal</label>
                                    <p class="file-upload-hint">Maksimal 10 file foto, masing-masing hingga 10 MB</p>
                                </div>
                                <div class="col-md-9">
                                    @php
                                        $foto_jurnals = $kegiatanLainnya->foto_jurnal ? (is_array($kegiatanLainnya->foto_jurnal) ? $kegiatanLainnya->foto_jurnal : [$kegiatanLainnya->foto_jurnal]) : [];
                                    @endphp
                                    @if(count($foto_jurnals) > 0)
                                        <div class="existing-files-section">
                                            <h6><i class="fas fa-images me-2"></i>Foto yang sudah ada:</h6>
                                            <div id="existing-foto-preview">
                                                @foreach($foto_jurnals as $index => $foto)
                                                    @php
                                                        // Handle berbagai tipe data untuk foto
                                                        $path = '';
                                                        $originalName = '';

                                                        if (is_object($foto)) {
                                                            $path = $foto->path;
                                                            $originalName = $foto->original_name ?? basename($path);
                                                        } elseif (is_array($foto)) {
                                                            $path = isset($foto['path']) ? $foto['path'] : '';
                                                            $originalName = isset($foto['original_name']) ? $foto['original_name'] : (is_string($path) ? basename($path) : '');
                                                        } elseif (is_string($foto)) {
                                                            $path = $foto;
                                                            $originalName = basename($path);
                                                        }

                                                        // Pastikan kita punya nama file
                                                        if (empty($originalName) && is_string($path)) {
                                                            $originalName = basename($path);
                                                        }
                                                    @endphp
                                                    <div class="file-preview-item existing" data-file-path="{{ $path }}">
                                                        <img src="{{ asset('storage/' . $path) }}" alt="Foto {{ $originalName }}" class="preview-image">
                                                        <div class="file-info">
                                                            <div class="file-name">{{ $originalName }}</div>
                                                            <div class="file-size">File yang ada</div>
                                                        </div>
                                                        <a href="{{ asset('storage/' . $path) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                                            <i class="fas fa-eye me-1"></i>Lihat
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @else
                                        <div class="alert alert-info">
                                            <i class="fas fa-info-circle me-2"></i>
                                            Tidak ada foto jurnal yang diunggah.
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="row align-items-start mb-4">
                                <div class="col-md-3">
                                    <label class="form-label">Dokumen Pendukung</label>
                                    <p class="file-upload-hint">Maksimal 10 file PDF/Office, masing-masing hingga 10MB</p>
                                </div>
                                <div class="col-md-9">
                                    @php
                                        $dokumens = $kegiatanLainnya->dokumen_lpj ? (is_array($kegiatanLainnya->dokumen_lpj) ? $kegiatanLainnya->dokumen_lpj : [$kegiatanLainnya->dokumen_lpj]) : [];
                                    @endphp
                                    @if(count($dokumens) > 0)
                                        <div class="existing-files-section">
                                            <h6><i class="fas fa-file-alt me-2"></i>Dokumen yang sudah ada:</h6>
                                            <div id="existing-dokumen-preview">
                                                @foreach($dokumens as $index => $dokumen)
                                                    @php
                                                        // Handle berbagai tipe data untuk dokumen
                                                        $path = '';
                                                        $originalName = '';

                                                        if (is_object($dokumen)) {
                                                            $path = $dokumen->path;
                                                            $originalName = $dokumen->original_name;
                                                        } elseif (is_array($dokumen)) {
                                                            $path = isset($dokumen['path']) ? $dokumen['path'] : '';
                                                            $originalName = isset($dokumen['original_name']) ? $dokumen['original_name'] : (is_string($path) ? basename($path) : '');
                                                        } elseif (is_string($dokumen)) {
                                                            $path = $dokumen;
                                                            $originalName = basename($path);
                                                        }

                                                        // Pastikan kita punya nama file
                                                        if (empty($originalName) && is_string($path)) {
                                                            $originalName = basename($path);
                                                        }

                                                        $extension = '';
                                                        if (!empty($originalName)) {
                                                            $extension = pathinfo($originalName, PATHINFO_EXTENSION);
                                                        }

                                                        $icon = 'fas fa-file text-secondary';
                                                        if (!empty($extension)) {
                                                            $icon = match(strtolower($extension)) {
                                                                'pdf' => 'fas fa-file-pdf text-danger',
                                                                'doc', 'docx' => 'fas fa-file-word text-primary',
                                                                'xls', 'xlsx' => 'fas fa-file-excel text-success',
                                                                default => 'fas fa-file text-secondary'
                                                            };
                                                        }
                                                    @endphp
                                                    <div class="file-preview-item existing" data-file-path="{{ $path }}">
                                                        <div class="file-icon">
                                                            <i class="{{ $icon }} fs-4"></i>
                                                        </div>
                                                        <div class="file-info">
                                                            <div class="file-name">{{ $originalName }}</div>
                                                            <div class="file-size">File yang ada</div>
                                                        </div>
                                                        <a href="{{ asset('storage/' . $path) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                                            <i class="fas fa-download me-1"></i>Unduh
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @else
                                        <div class="alert alert-info">
                                            <i class="fas fa-info-circle me-2"></i>
                                            Tidak ada dokumen pendukung yang diunggah.
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="row align-items-start mb-4">
                                <div class="col-md-3">
                                    <label class="form-label">Keterangan Tambahan</label>
                                </div>
                                <div class="col-md-9">
                                    @if($kegiatanLainnya->keterangan_tambahan)
                                        <textarea class="form-control" rows="4" readonly>{{ $kegiatanLainnya->keterangan_tambahan }}</textarea>
                                    @else
                                        <div class="alert alert-info">
                                            <i class="fas fa-info-circle me-2"></i>
                                            Tidak ada keterangan tambahan.
                                        </div>
                                    @endif
                                </div>
                            </div>

                             <div class="row">
                        <div class="col-md-9 offset-md-3 d-flex gap-3">
                            <a href="{{ route('admin.laporan-lpj.kegiatan-lainnya.index') }}"
                               class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                        </div>
                    </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection