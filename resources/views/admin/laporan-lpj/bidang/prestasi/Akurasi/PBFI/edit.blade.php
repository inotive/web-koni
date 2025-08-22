@extends('layouts.app')

@section('pageTitle', 'Edit PBFI - Binaraga')
@section('mainSection', 'Laporan LPJ')
@section('subSection', 'Bidang Bidang')
@section('subSectionUrl', route('admin.laporan-lpj.bidang.index'))
@section('subSection2', 'Pembinaan Prestasi')
@section('subSection2Url', route('admin.laporan-lpj.bidang.prestasi.index'))
@section('subSection3', 'Cabor akurasi')
@section('subSection3Url', route('admin.laporan-lpj.bidang.prestasi.cabor-akurasi'))
@section('subSection4', 'PBFI - Binaraga')
@section('subSection4Url', route('admin.laporan-lpj.bidang.prestasi.cabor-akurasi.pbfi.index'))
@section('currentSection', 'Edit PBFI - Binaraga')

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

        .current-files {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            border: 1px solid #e9ecef;
        }

        .current-files h6 {
            color: #495057;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .existing-file-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 8px;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            background-color: white;
            margin-bottom: 6px;
        }

        .existing-file-item:last-child {
            margin-bottom: 0;
        }

        .existing-preview-image {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 4px;
        }

        .existing-file-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa;
            border-radius: 4px;
        }
    </style>

    <div class="d-flex justify-content-between align-items-center flex-wrap mb-4" style="padding: 20px 20px">
        <h3 class="fw-bold fs-2 mb-0 text-dark">Edit Data PBFI - Binaraga</h3>
    </div>

    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="card card-form">
                    <div class="card-body p-4 p-md-5">
                        <h3 class="fw-bold mb-4">Edit Data</h3>
                        <form action="{{ route('admin.laporan-lpj.bidang.prestasi.cabor-akurasi.pbfi.update', $pbfi->id) }}" method="POST"
                            enctype="multipart/form-data" id="sumberDayaEditForm">
                            @csrf
                            @method('PUT')

                            @php
                                $fields = [
                                    'nama_program' => [
                                        'label' => 'Nama Program',
                                        'type' => 'text',
                                        'placeholder' => 'Masukkan nama program',
                                        'required' => true,
                                    ],
                                    'nama_kegiatan' => [
                                        'label' => 'Nama Kegiatan',
                                        'type' => 'text',
                                        'placeholder' => 'Contoh: Pelatihan, Workshop, Pembelian',
                                        'required' => true,
                                    ],
                                    'volume' => [
                                        'label' => 'Volume',
                                        'type' => 'text',
                                        'placeholder' => 'Masukkan volume kegiatan (contoh: 20 unit, 1 kegiatan)',
                                        'required' => true,
                                    ],
                                    'jumlah_harga_satuan' => [
                                        'label' => 'Jumlah Harga Satuan',
                                        'type' => 'number',
                                        'placeholder' => 'Masukkan jumlah harga satuan',
                                        'required' => true,
                                    ],
                                    'jumlah_harga' => [
                                        'label' => 'Jumlah Harga',
                                        'type' => 'number',
                                        'placeholder' => 'Masukkan jumlah harga',
                                        'required' => true,
                                    ],
                                    'keterangan_tambahan' => [
                                        'label' => 'Keterangan Tambahan',
                                        'type' => 'textarea',
                                        'placeholder' => 'Masukkan keterangan tambahan (opsional)',
                                        'required' => false,
                                    ],
                                ];
                            @endphp

                            @foreach ($fields as $key => $field)
                                @if($key === 'keterangan_tambahan')
                                    {{-- File Upload Components --}}
                                    @include('admin.laporan-lpj.bidang.prestasi.akurasi.pbfi.components.file-upload', [
                                        'name' => 'foto_jurnal',
                                        'label' => 'Foto Jurnal',
                                        'type' => 'image',
                                        'maxFiles' => 10,
                                        'maxSize' => 10,
                                        'existingFiles' => $pbfi->foto_jurnal ?? [],
                                        'accept' => 'image/*',
                                        'hint' => 'Maksimal 10 file foto, masing-masing hingga 10 MB'
                                    ])

                                    @include('admin.laporan-lpj.bidang.prestasi.akurasi.pbfi.components.file-upload', [
                                        'name' => 'dokumen_lpj',
                                        'label' => 'Dokumen LPJ',
                                        'type' => 'document',
                                        'maxFiles' => 10,
                                        'maxSize' => 10,
                                        'existingFiles' => $pbfi->dokumen_lpj ?? [],
                                        'accept' => '.pdf,.doc,.docx,.xls,.xlsx',
                                        'hint' => 'Maksimal 10 file PDF/Office, masing-masing hingga 10MB'
                                    ])
                                @endif

                                <div class="row align-items-center mb-3">
                                    <div class="col-md-3">
                                        <label for="{{ $key }}" class="form-label">
                                            {{ $field['label'] }}
                                            @if($field['required'])
                                                <span class="text-danger">*</span>
                                            @endif
                                        </label>
                                    </div>
                                    <div class="col-md-9">
                                        @if ($field['type'] === 'textarea')
                                            <textarea name="{{ $key }}" id="{{ $key }}"
                                                class="form-control @error($key) is-invalid @enderror"
                                                placeholder="{{ $field['placeholder'] ?? '' }}"
                                                rows="3"
                                                {{ $field['required'] ? 'required' : '' }}>{{ old($key, $pbfi->$key) }}</textarea>
                                        @else
                                            <input type="{{ $field['type'] }}" name="{{ $key }}"
                                                id="{{ $key }}"
                                                class="form-control @error($key) is-invalid @enderror"
                                                placeholder="{{ $field['placeholder'] ?? '' }}"
                                                value="{{ old($key, $pbfi->$key) }}"
                                                {{ $field['required'] ? 'required' : '' }}
                                                @if($field['type'] === 'number') min="0" step="0.01" @endif>
                                        @endif

                                        @error($key)
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            @endforeach

                            <div class="row mt-4">
                                <div class="col-md-9 offset-md-3 d-flex justify-content-between">
                                    <button type="submit" class="btn btn-danger px-4">Update Data</button>
                                    <a href="{{ route('admin.laporan-lpj.bidang.prestasi.cabor-akurasi.pbfi.index') }}"
                                        class="btn btn-secondary px-4">Kembali</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Include JavaScript for file uploads --}}
    @include('admin.laporan-lpj.bidang.prestasi.akurasi.pbfi.components.file-upload-scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize file uploads
            initFileUpload({
                name: 'foto_jurnal',
                type: 'image',
                maxFiles: 10,
                maxSize: 10 * 1024 * 1024,
                existingFiles: @json($pbfi->foto_jurnal ?? [])
            });

            initFileUpload({
                name: 'dokumen_lpj',
                type: 'document',
                maxFiles: 10,
                maxSize: 10 * 1024 * 1024,
                existingFiles: @json($pbfi->dokumen_lpj ?? [])
            });
        });
    </script>
@endsection

@push('scripts')
    @stack('scripts')
@endpush
