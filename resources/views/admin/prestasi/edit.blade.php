{{-- resources/views/admin/prestasi/edit.blade.php --}}
@extends('layouts.app')

@section('pageTitle', 'Edit Prestasi')
@section('mainSection', 'Konfigurasi')
@section('mainSectionUrl', route('admin.konfigurasi.atlet.index'))
@section('subSection', 'Prestasi')
@section('subSectionUrl', route('admin.prestasi.index'))
@section('currentSection', 'Edit Prestasi')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Form Edit Prestasi</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.prestasi.update', $prestasi->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Pemilik Prestasi</label>
                    <input type="text" class="form-control"
                           value="{{ $prestasi->subject->nama }} ({{ class_basename($prestasi->subject_type) }})"
                           readonly>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="cabor" class="form-label">Cabang Olahraga</label>
                    <input type="text" class="form-control @error('cabor') is-invalid @enderror"
                           id="cabor" name="cabor" value="{{ old('cabor', $prestasi->cabor) }}" required>
                    @error('cabor')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="nama_prestasi" class="form-label">Nama Prestasi</label>
                    <input type="text" class="form-control @error('nama_prestasi') is-invalid @enderror"
                           id="nama_prestasi" name="nama_prestasi"
                           value="{{ old('nama_prestasi', $prestasi->nama_prestasi) }}" required>
                    @error('nama_prestasi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="tingkat" class="form-label">Tingkat Prestasi</label>
                    <select class="form-select @error('tingkat') is-invalid @enderror"
                            id="tingkat" name="tingkat" required>
                        <option value="">-- Pilih Tingkat --</option>
                        <option value="Sekolah" @selected(old('tingkat', $prestasi->tingkat) == 'Sekolah')>Sekolah</option>
                        <option value="Kecamatan" @selected(old('tingkat', $prestasi->tingkat) == 'Kecamatan')>Kecamatan</option>
                        <option value="Kabupaten/Kota" @selected(old('tingkat', $prestasi->tingkat) == 'Kabupaten/Kota')>Kabupaten/Kota</option>
                        <option value="Provinsi" @selected(old('tingkat', $prestasi->tingkat) == 'Provinsi')>Provinsi</option>
                        <option value="Nasional" @selected(old('tingkat', $prestasi->tingkat) == 'Nasional')>Nasional</option>
                        <option value="Internasional" @selected(old('tingkat', $prestasi->tingkat) == 'Internasional')>Internasional</option>
                    </select>
                    @error('tingkat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="tempat" class="form-label">Tempat Lomba</label>
                    <input type="text" class="form-control @error('tempat') is-invalid @enderror"
                           id="tempat" name="tempat" value="{{ old('tempat', $prestasi->tempat) }}" required>
                    @error('tempat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="tahun" class="form-label">Tahun</label>
                    <input type="number" class="form-control @error('tahun') is-invalid @enderror"
                           id="tahun" name="tahun" value="{{ old('tahun', $prestasi->tahun) }}"
                           min="1900" max="{{ date('Y') + 1 }}" required>
                    @error('tahun')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="medali" class="form-label">Medali</label>
                    <select class="form-select @error('medali') is-invalid @enderror"
                            id="medali" name="medali" required>
                        <option value="">-- Pilih Medali --</option>
                        <option value="Emas" @selected(old('medali', $prestasi->medali) == 'Emas')>Emas</option>
                        <option value="Perak" @selected(old('medali', $prestasi->medali) == 'Perak')>Perak</option>
                        <option value="Perunggu" @selected(old('medali', $prestasi->medali) == 'Perunggu')>Perunggu</option>
                    </select>
                    @error('medali')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary me-2">
                    <i class="fas fa-save me-1"></i> Simpan Perubahan
                </button>
                <a href="{{ route('admin.prestasi.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times me-1"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
