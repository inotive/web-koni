@extends('layouts.app')
@section('pageTitle', 'Tambah Prestasi')
@section('mainSection', 'Konfigurasi')
@section('mainSectionUrl', route('admin.konfigurasi.atlet.index'))
@section('subSection', 'Prestasi')
@section('subSectionUrl', route('admin.konfigurasi.prestasi.index'))
@section('currentSection', 'Tambah Prestasi')

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

    .form-control, .form-select {
        border-radius: 8px;
        padding: 10px 14px;
        font-size: 0.95rem;
    }

    .form-control:focus, .form-select:focus {
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

    .form-hint {
        font-size: 0.8rem;
        color: #6c757d;
        margin-top: 4px;
    }
</style>

<div class="d-flex justify-content-between align-items-center flex-wrap mb-4" style="padding: 20px 20px">
    <h3 class="fw-bold fs-2 mb-0 text-dark">Tambah Prestasi</h3>
</div>

<div class="main-content">
    <div class="container-fluid">
        <div class="row">
            <div class="card card-form">
                <div class="card-body p-4 p-md-5">
                    <h3 class="fw-bold mb-4">Tambah Data</h3>
                    <form action="{{ route('admin.konfigurasi.prestasi.store') }}" method="POST">
                        @csrf

                        <div class="row align-items-center mb-3">
                            <div class="col-md-3">
                                <label for="subject_type" class="form-label">Jenis Pemilik</label>
                            </div>
                            <div class="col-md-9">
                                <select class="form-select @error('subject_type') is-invalid @enderror" id="subject_type" name="subject_type" required>
                                    <option value="">-- Pilih Jenis --</option>
                                    <option value="atlet" @selected(old('subject_type', $subjectType ?? null) == 'atlet')>Atlet</option>
                                    <option value="pelatih" @selected(old('subject_type', $subjectType ?? null) == 'pelatih')>Pelatih</option>
                                </select>
                                @error('subject_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row align-items-center mb-3">
                            <div class="col-md-3">
                                <label for="subject_id" class="form-label">Pemilik Prestasi</label>
                            </div>
                            <div class="col-md-9">
                                <select class="form-select @error('subject_id') is-invalid @enderror" id="subject_id" name="subject_id" required>
                                    <option value="">-- Pilih Pemilik --</option>
                                    <optgroup label="Atlet">
                                        @foreach ($atlets as $a)
                                            <option value="{{ $a->id }}" data-type="atlet" data-cabor="{{ $a->cabangOlahraga->nama_cabor ?? '' }}" data-jk="{{ $a->jenis_kelamin }}">
                                                {{ $a->nama }} ({{ $a->jenis_kelamin }})
                                            </option>
                                        @endforeach
                                    </optgroup>
                                    <optgroup label="Pelatih">
                                        @foreach ($pelatihs as $p)
                                            <option value="{{ $p->id }}" data-type="pelatih" data-cabor="{{ $p->cabangOlahraga->nama_cabor ?? '' }}" data-jk="{{ $p->kelamin }}">
                                                {{ $p->nama }} ({{ $p->kelamin }})
                                            </option>
                                        @endforeach
                                    </optgroup>
                                </select>
                                @error('subject_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row align-items-center mb-3">
                            <div class="col-md-3">
                                <label for="nama_prestasi" class="form-label">Nama Prestasi</label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" class="form-control @error('nama_prestasi') is-invalid @enderror" id="nama_prestasi" name="nama_prestasi" value="{{ old('nama_prestasi') }}" required>
                                @error('nama_prestasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row align-items-center mb-3">
                            <div class="col-md-3">
                                <label for="cabor" class="form-label">Cabang Olahraga</label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" class="form-control @error('cabor') is-invalid @enderror" id="cabor" name="cabor" value="{{ old('cabor', $cabor ?? '') }}" required>
                                @error('cabor')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-hint">Field ini akan terisi otomatis saat memilih atlet/pelatih</small>
                            </div>
                        </div>

                        <div class="row align-items-center mb-3">
                            <div class="col-md-3">
                                <label for="tingkat" class="form-label">Tingkat Prestasi</label>
                            </div>
                            <div class="col-md-9">
                                <select class="form-select @error('tingkat') is-invalid @enderror" id="tingkat" name="tingkat" required>
                                    <option value="">-- Pilih Tingkat --</option>
                                    <option value="Sekolah" @selected(old('tingkat') == 'Sekolah')>Sekolah</option>
                                    <option value="Kecamatan" @selected(old('tingkat') == 'Kecamatan')>Kecamatan</option>
                                    <option value="Kabupaten/Kota" @selected(old('tingkat') == 'Kabupaten/Kota')>Kabupaten/Kota</option>
                                    <option value="Provinsi" @selected(old('tingkat') == 'Provinsi')>Provinsi</option>
                                    <option value="Nasional" @selected(old('tingkat') == 'Nasional')>Nasional</option>
                                    <option value="Internasional" @selected(old('tingkat') == 'Internasional')>Internasional</option>
                                </select>
                                @error('tingkat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row align-items-center mb-3">
                            <div class="col-md-3">
                                <label for="tempat" class="form-label">Tempat Lomba</label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" class="form-control @error('tempat') is-invalid @enderror" id="tempat" name="tempat" value="{{ old('tempat') }}" required>
                                @error('tempat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row align-items-center mb-3">
                            <div class="col-md-3">
                                <label for="tahun" class="form-label">Tahun</label>
                            </div>
                            <div class="col-md-9">
                                <input type="number" class="form-control @error('tahun') is-invalid @enderror" id="tahun" name="tahun" value="{{ old('tahun', date('Y')) }}" min="1900" max="{{ date('Y') + 1 }}" required>
                                @error('tahun')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row align-items-center mb-3">
                            <div class="col-md-3">
                                <label for="medali" class="form-label">Medali</label>
                            </div>
                            <div class="col-md-9">
                                <select class="form-select @error('medali') is-invalid @enderror" id="medali" name="medali" required>
                                    <option value="">-- Pilih Medali --</option>
                                    <option value="Emas" @selected(old('medali') == 'Emas')>Emas</option>
                                    <option value="Perak" @selected(old('medali') == 'Perak')>Perak</option>
                                    <option value="Perunggu" @selected(old('medali') == 'Perunggu')>Perunggu</option>
                                </select>
                                @error('medali')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-9 offset-md-3 d-flex justify-content-between">
                                <button type="submit" class="btn btn-danger px-4">Simpan Data</button>
                                <a href="{{ route('admin.konfigurasi.prestasi.index') }}" class="btn btn-secondary px-4">Kembali</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const subjectSelect = document.getElementById('subject_id');
        const caborInput = document.getElementById('cabor');

        if (subjectSelect && caborInput) {
            subjectSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                if (selectedOption && selectedOption.dataset && selectedOption.dataset.cabor) {
                    caborInput.value = selectedOption.dataset.cabor;
                } else {
                    caborInput.value = '';
                }
            });

            if (subjectSelect.value) {
                subjectSelect.dispatchEvent(new Event('change'));
            }
        }
    });
</script>
@endsection
