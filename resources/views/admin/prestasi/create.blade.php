@extends('layouts.app')
@section('pageTitle', 'Tambah Prestasi')
@section('mainSection', 'Konfigurasi')
@section('mainSectionUrl', route('admin.konfigurasi.atlet.index'))
@section('subSection', 'Prestasi')
@section('subSectionUrl', route('admin.konfigurasi.prestasi.index'))
@section('currentSection', 'Tambah Prestasi')
@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Form Tambah Prestasi</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.konfigurasi.prestasi.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Jenis Pemilik</label>
                        <select class="form-select @error('subject_type') is-invalid @enderror" id="subject_type"
                            name="subject_type" required>
                            <option value="">-- Pilih Jenis --</option>
                            <option value="atlet" @selected(old('subject_type', $subjectType ?? null) == 'atlet')>Atlet</option>
                            <option value="pelatih" @selected(old('subject_type', $subjectType ?? null) == 'pelatih')>Pelatih</option>
                        </select>
                        @error('subject_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Pemilik Prestasi</label>
                        <select class="form-select @error('subject_id') is-invalid @enderror" id="subject_id"
                            name="subject_id" required>
                            <option value="">-- Pilih Pemilik --</option>

                            <optgroup label="Atlet">
                                @foreach ($atlets as $a)
                                    <option value="{{ $a->id }}" data-type="atlet"
                                        data-cabor="{{ $a->cabangOlahraga->nama_cabor ?? '' }}"
                                        data-jk="{{ $a->jenis_kelamin }}">
                                        {{ $a->nama }} ({{ $a->jenis_kelamin }})
                                    </option>
                                @endforeach
                            </optgroup>

                            <optgroup label="Pelatih">
                                @foreach ($pelatihs as $p)
                                    <option value="{{ $p->id }}" data-type="pelatih"
                                        data-cabor="{{ $p->cabangOlahraga->nama_cabor ?? '' }}"
                                        data-jk="{{ $p->kelamin }}">
                                        {{ $p->nama }} ({{ $p->kelamin }})
                                    </option>
                                @endforeach
                            </optgroup>
                        </select>
                        @error('subject_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="nama_prestasi" class="form-label">Nama Prestasi</label>
                        <input type="text" class="form-control @error('nama_prestasi') is-invalid @enderror"
                            id="nama_prestasi" name="nama_prestasi" value="{{ old('nama_prestasi') }}" required>
                        @error('nama_prestasi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="cabor" class="form-label">Cabang Olahraga</label>
                        <input type="text" class="form-control @error('cabor') is-invalid @enderror" id="cabor"
                            name="cabor" value="{{ old('cabor', $cabor ?? '') }}" required>
                        @error('cabor')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Field ini akan terisi otomatis saat memilih atlet/pelatih</small>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="tingkat" class="form-label">Tingkat Prestasi</label>
                        <select class="form-select @error('tingkat') is-invalid @enderror" id="tingkat" name="tingkat"
                            required>
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

                    <div class="col-md-6 mb-3">
                        <label for="tempat" class="form-label">Tempat Lomba</label>
                        <input type="text" class="form-control @error('tempat') is-invalid @enderror" id="tempat"
                            name="tempat" value="{{ old('tempat') }}" required>
                        @error('tempat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="tahun" class="form-label">Tahun</label>
                        <input type="number" class="form-control @error('tahun') is-invalid @enderror" id="tahun"
                            name="tahun" value="{{ old('tahun', date('Y')) }}" min="1900" max="{{ date('Y') + 1 }}"
                            required>
                        @error('tahun')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="medali" class="form-label">Medali</label>
                        <select class="form-select @error('medali') is-invalid @enderror" id="medali" name="medali"
                            required>
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

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="fas fa-save me-1"></i> Simpan
                    </button>
                    <a href="{{ route('admin.konfigurasi.prestasi.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times me-1"></i> Batal
                    </a>
                </div>
            </form>
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
                        console.log('Cabor filled:', selectedOption.dataset.cabor);
                    } else {
                        caborInput.value = '';
                        console.log('Cabor cleared');
                    }
                });

                // Trigger untuk initial load jika ada old value
                if (subjectSelect.value) {
                    subjectSelect.dispatchEvent(new Event('change'));
                }
            }
        });
    </script>
@endsection
