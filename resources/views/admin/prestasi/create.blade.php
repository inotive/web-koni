@extends('layouts.app')
@section('pageTitle', 'Tambah Prestasi')
@section('mainSection', 'Konfigurasi')
@section('mainSectionUrl', route('admin.konfigurasi.atlet.index'))
@section('subSection', 'Prestasi')
@section('subSectionUrl', route('admin.konfigurasi.prestasi.index'))
@section('currentSection', 'Tambah Prestasi')

@section('content')

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"
        rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


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

        .form-hint {
            font-size: 0.8rem;
            color: #6c757d;
            margin-top: 4px;
        }

        <style>

        /* Tambahkan style ini */
        .select2-container--bootstrap-5 .select2-selection {
            border-radius: 8px !important;
            padding: 5px 14px !important;
            min-height: 42px !important;
            border: 1px solid #ced4da !important;
        }

        .select2-container--bootstrap-5 .select2-selection:focus {
            border-color: #0d6efd !important;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.2) !important;
        }

        .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
            padding: 0 !important;
            line-height: 1.5 !important;
        }

        .select2-container--bootstrap-5 .select2-selection--single .select2-selection__arrow {
            height: 40px !important;
        }
    </style>
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
                                    <select class="form-select @error('subject_type') is-invalid @enderror"
                                        id="subject_type" name="subject_type" required>
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
                                    <!-- wrapper agar tidak terjadi geser -->
                                    <div class="d-grid">
                                        <select class="form-select select2-ajax" id="subject_atlet" name="subject_id"
                                            style="display: none;">
                                            <option value="">-- Pilih Atlet --</option>
                                            @foreach ($atlets as $a)
                                                <option value="{{ $a->id }}"
                                                    data-cabor="{{ $a->cabangOlahraga->nama_cabor ?? '' }}">
                                                    {{ $a->nama }} ({{ $a->jenis_kelamin }})
                                                </option>
                                            @endforeach
                                        </select>

                                        <select class="form-select select2-ajax" id="subject_pelatih" name="subject_id"
                                            style="display: none;">
                                            <option value="">-- Pilih Pelatih --</option>
                                            @foreach ($pelatihs as $p)
                                                <option value="{{ $p->id }}"
                                                    data-cabor="{{ $p->cabangOlahraga->nama_cabor ?? '' }}">
                                                    {{ $p->nama }} ({{ $p->kelamin }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    @error('subject_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row align-items-center mb-3">
                                <div class="col-md-3">
                                    <label for="nama_prestasi" class="form-label">Kejuaraan</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control @error('nama_prestasi') is-invalid @enderror"
                                        id="nama_prestasi" name="nama_prestasi" value="{{ old('nama_prestasi') }}"
                                        required>
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
                                    <select class="form-select @error('cabor_id') is-invalid @enderror" id="cabor"
                                        name="cabor_id" required>
                                        <option value="">-- Pilih Cabang Olahraga --</option>
                                        @foreach ($cabors as $cabor)
                                            <option value="{{ $cabor->id }}" @selected(old('cabor_id') == $cabor->id)>
                                                {{ $cabor->nama_cabor }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('cabor_id')
                                        <!-- Perbaikan nama error disesuaikan -->
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row align-items-center mb-3">
                                <div class="col-md-3">
                                    <label for="tingkat" class="form-label">Tingkat Prestasi</label>
                                </div>
                                <div class="col-md-9">
                                    <select class="form-select @error('tingkat') is-invalid @enderror" id="tingkat"
                                        name="tingkat" required>
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
                                    <input type="text" class="form-control @error('tempat') is-invalid @enderror"
                                        id="tempat" name="tempat" value="{{ old('tempat') }}" required>
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
                                    <input type="number" class="form-control @error('tahun') is-invalid @enderror"
                                        id="tahun" name="tahun" value="{{ old('tahun', date('Y')) }}"
                                        min="1900" max="{{ date('Y') + 1 }}" required>
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
                                    <select class="form-select @error('medali') is-invalid @enderror" id="medali"
                                        name="medali" required>
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
                                    <a href="{{ route('admin.konfigurasi.prestasi.index') }}"
                                        class="btn btn-secondary px-4">Kembali</a>
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
    // Inisialisasi Select2 untuk select atlet dan pelatih
    const atletSelect = $('#subject_atlet');
    const pelatihSelect = $('#subject_pelatih');

    $('#subject_atlet, #subject_pelatih').select2({
        theme: 'bootstrap-5',
        placeholder: function() {
            return $(this).attr('id') === 'subject_atlet' ? 'Cari atlet...' : 'Cari pelatih...';
        },
        allowClear: true,
        width: '100%',
        dropdownParent: $('.card-form')
    });

    const subjectTypeSelect = document.getElementById('subject_type');
    const caborInput = $('#cabor');
    const form = document.querySelector('form');

    // Tambahkan hidden input untuk subject_id
    const hiddenSubjectInput = document.createElement('input');
    hiddenSubjectInput.type = 'hidden';
    hiddenSubjectInput.name = 'subject_id';
    form.appendChild(hiddenSubjectInput);

    // Fungsi untuk mengupdate pilihan cabang olahraga
    function updateCabor(selectedOption) {
        if (selectedOption.length && selectedOption.data('cabor')) {
            const caborName = selectedOption.data('cabor');
            // Cari option yang text-nya sama dengan nama cabang olahraga
            const caborOption = $('#cabor option').filter(function() {
                return $(this).text().trim() === caborName;
            });

            if (caborOption.length) {
                caborInput.val(caborOption.val()).trigger('change');
            } else {
                caborInput.val('').trigger('change');
            }
        } else {
            caborInput.val('').trigger('change');
        }
    }

    // Fungsi untuk toggle select atlet/pelatih
    function toggleOptions() {
        const selectedType = subjectTypeSelect.value;

        // Sembunyikan semua select terlebih dahulu
        atletSelect.hide().next('.select2-container').hide();
        pelatihSelect.hide().next('.select2-container').hide();

        // Hapus event listener sebelumnya untuk menghindari duplikasi
        atletSelect.off('change');
        pelatihSelect.off('change');

        // Reset nilai
        atletSelect.val(null).trigger('change');
        pelatihSelect.val(null).trigger('change');
        hiddenSubjectInput.value = '';

        if (selectedType === 'atlet') {
            atletSelect.show().next('.select2-container').show();
            // Set nilai ke hidden input ketika atlet dipilih
            atletSelect.on('change', function() {
                hiddenSubjectInput.value = this.value;
                updateCabor($(this).find(':selected'));
            });
        } else if (selectedType === 'pelatih') {
            pelatihSelect.show().next('.select2-container').show();
            // Set nilai ke hidden input ketika pelatih dipilih
            pelatihSelect.on('change', function() {
                hiddenSubjectInput.value = this.value;
                updateCabor($(this).find(':selected'));
            });
        }
    }

    // Inisialisasi Select2 untuk cabang olahraga
    caborInput.select2({
        theme: 'bootstrap-5',
        placeholder: 'Pilih Cabang Olahraga',
        allowClear: true,
        width: '100%'
    });

    // Event listener untuk perubahan jenis pemilik
    subjectTypeSelect.addEventListener('change', toggleOptions);

    // Panggil pertama kali untuk inisialisasi
    toggleOptions();
});
</script>

@endsection
