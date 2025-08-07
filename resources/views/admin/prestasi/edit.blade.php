@extends('layouts.app')
@section('pageTitle', 'Edit Prestasi')
@section('mainSection', 'Konfigurasi')
@section('mainSectionUrl', route('admin.konfigurasi.atlet.index'))
@section('subSection', 'Prestasi')
@section('subSectionUrl', route('admin.konfigurasi.prestasi.index'))
@section('currentSection', 'Edit Prestasi')

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

        /* Select2 styling */
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

    <div class="d-flex justify-content-between align-items-center flex-wrap mb-4" style="padding: 20px 20px">
        <h3 class="fw-bold fs-2 mb-0 text-dark">Edit Prestasi</h3>
    </div>

    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="card card-form">
                    <div class="card-body p-4 p-md-5">
                        <h3 class="fw-bold mb-4">Edit Data</h3>
                        <form action="{{ route('admin.konfigurasi.prestasi.update', $prestasi->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row align-items-center mb-3">
                                <div class="col-md-3">
                                    <label class="form-label">Pemilik Prestasi</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control"
                                        value="{{ $prestasi->subject->nama }} ({{ class_basename($prestasi->subject_type) }})"
                                        readonly>
                                </div>
                            </div>

                            <div class="row align-items-center mb-3">
                                <div class="col-md-3">
                                    <label for="kejuaraan" class="form-label">Kejuaraan</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control @error('kejuaraan') is-invalid @enderror"
                                        id="kejuaraan" name="kejuaraan"
                                        value="{{ old('kejuaraan', $prestasi->kejuaraan) }}" required>
                                    @error('kejuaraan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row align-items-center mb-3">
                                <div class="col-md-3">
                                    <label for="nama_prestasi" class="form-label">Nama Prestasi</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control @error('nama_prestasi') is-invalid @enderror"
                                        id="nama_prestasi" name="nama_prestasi"
                                        value="{{ old('nama_prestasi', $prestasi->nama_prestasi) }}" required>
                                    @error('nama_prestasi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row align-items-center mb-3">
                                <div class="col-md-3">
                                    <label for="cabor_id" class="form-label">Cabang Olahraga</label>
                                </div>
                                <div class="col-md-9">
                                    @php
                                        $effectiveCaborId = old(
                                            'cabor_id',
                                            $prestasi->cabor_id ?: $prestasi->subject->cabor_id ?? null,
                                        );
                                    @endphp

                                    <select class="form-select @error('cabor_id') is-invalid @enderror" id="cabor_id"
                                        name="cabor_id" data-selected="{{ $effectiveCaborId }}" required>
                                        <option value="">-- Pilih Cabang Olahraga --</option>
                                        @foreach ($cabors as $cabor)
                                            <option value="{{ $cabor->id }}"
                                                @if ($effectiveCaborId == $cabor->id) selected @endif>
                                                {{ $cabor->nama_cabor }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('cabor_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                    @if (!$prestasi->cabor_id && $prestasi->subject->cabor_id)
                                        <div class="form-hint mt-1" style="color: #fd7e14;">
                                            <i class="fas fa-info-circle"></i>
                                            Menggunakan cabang olahraga dari {{ class_basename($prestasi->subject_type) }}:
                                            {{ $prestasi->subject->cabangOlahraga->nama_cabor ?? 'Unknown' }}
                                        </div>
                                    @endif
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
                            </div>

                            <div class="row align-items-center mb-3">
                                <div class="col-md-3">
                                    <label for="tempat" class="form-label">Tempat Lomba</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control @error('tempat') is-invalid @enderror"
                                        id="tempat" name="tempat" value="{{ old('tempat', $prestasi->tempat) }}"
                                        required>
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
                                        id="tahun" name="tahun" value="{{ old('tahun', $prestasi->tahun) }}"
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
                                        <option value="Emas" @selected(old('medali', $prestasi->medali) == 'Emas')>Emas</option>
                                        <option value="Perak" @selected(old('medali', $prestasi->medali) == 'Perak')>Perak</option>
                                        <option value="Perunggu" @selected(old('medali', $prestasi->medali) == 'Perunggu')>Perunggu</option>
                                    </select>
                                    @error('medali')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-9 offset-md-3 d-flex justify-content-between">
                                    <button type="submit" class="btn btn-danger px-4">Simpan Perubahan</button>
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
        $(document).ready(function() {
            console.log('=== DEBUG SELECT2 PREFILL ===');
            console.log('Available cabors in select:', $('#cabor_id option').map(function() {
                return {
                    value: $(this).val(),
                    text: $(this).text(),
                    debug: $(this).data('debug')
                };
            }).get());

            const selectedValue = "{{ old('cabor_id', $prestasi->cabor_id) }}";
            console.log('Selected value from backend:', selectedValue, typeof selectedValue);

            const optionExists = $('#cabor_id option[value="' + selectedValue + '"]').length > 0;
            console.log('Option exists:', optionExists);

            if (optionExists) {
                console.log('Setting value before Select2 init:', selectedValue);
                $('#cabor_id').val(selectedValue);
            }

            $('#cabor_id').select2({
                theme: 'bootstrap-5',
                placeholder: 'Pilih Cabang Olahraga',
                allowClear: true,
                width: '100%'
            });

            if (selectedValue && optionExists) {
                console.log('Setting value after Select2 init:', selectedValue);
                $('#cabor_id').val(selectedValue).trigger('change');

                setTimeout(function() {
                    const currentValue = $('#cabor_id').val();
                    console.log('Current value after set:', currentValue);
                    console.log('Selected text:', $('#cabor_id option:selected').text());
                }, 100);
            }

            $('#cabor_id').on('select2:open', function() {
                console.log('Select2 opened, current value:', $(this).val());
            });

            $('#cabor_id').on('select2:select', function(e) {
                console.log('Select2 selection changed:', e.params.data);
            });
        });
    </script>

@endsection
