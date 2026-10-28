@extends('layouts.app')

@php
    $isEdit = $surat->exists;
    $data = old('data', $surat->data_template ?? []);
    $otomatisDefault = !$isEdit && $penomoran;
    $otomatis = $penomoran && !$isEdit && (old('nomor_otomatis', $otomatisDefault ? '1' : '0') === '1' || !$penomoran->editable);
    $nomorTerkunci = $isEdit && $surat->surat_penomoran_id && $penomoran && !$penomoran->editable;
@endphp

@section('pageTitle', $isEdit ? 'Ubah Surat Keluar' : 'Buat Surat Keluar')
@section('mainSection', 'Surat Masuk & Keluar')
@section('mainSectionUrl', route('admin.surat.index', ['jenis_surat' => 'keluar']))
@section('currentSection', $isEdit ? 'Ubah Surat Keluar' : 'Buat dari Template')

@include('admin.arsip._assets')

@push('stack-css')
    <style>
        /* Lebar select2 kode klasifikasi tetap selebar kolom; nama yang panjang dipotong dengan elipsis */
        .klasifikasi-field {
            min-width: 0;
        }

        .klasifikasi-field .select2-container {
            width: 100% !important;
            max-width: 100%;
        }

        .klasifikasi-field .select2-selection__rendered {
            display: block !important;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }
    </style>
@endpush

@section('content')
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-6 gap-3">
        <div>
            <h1 class="mb-1">{{ $isEdit ? 'Ubah Surat ' . $surat->no_surat : 'Buat Surat Keluar dari Template' }}</h1>
            <span class="text-muted">
                {{ $isEdit ? 'PDF surat dibuat ulang setelah disimpan.' : 'Isi data surat, cek preview, lalu simpan. PDF dibuat otomatis.' }}
            </span>
        </div>
        <a href="{{ route('admin.surat.index', ['jenis_surat' => 'keluar']) }}" class="btn btn-light">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" id="suratForm"
        action="{{ $isEdit ? route('admin.surat.template.update', $surat) : route('admin.surat.template.store') }}">
        @csrf
        @if ($isEdit)
            @method('PUT')
        @endif
        <input type="hidden" name="surat_template_id" value="{{ $template->id }}">

        <div class="row g-6">
            <div class="col-xl-8">
                <div class="card arsip-card mb-6">
                    <div class="card-header border-0 pt-5">
                        <h3 class="card-title fw-bold">Data Surat</h3>
                    </div>
                    <div class="card-body pt-0 d-grid gap-5">
                        @unless ($isEdit)
                            <div>
                                <label class="form-label required">Template Surat</label>
                                <select id="templateSelect" class="form-select">
                                    @foreach ($templates as $t)
                                        <option value="{{ $t->id }}" @selected($t->id === $template->id)>{{ $t->kode }} — {{ $t->nama }}</option>
                                    @endforeach
                                </select>
                                <div class="form-text">Mengganti template akan memuat ulang form.</div>
                            </div>
                        @endunless

                        <div>
                            <label class="form-label required">Perihal</label>
                            <input type="text" name="nama_kegiatan" class="form-control" required maxlength="255"
                                value="{{ old('nama_kegiatan', $surat->nama_kegiatan) }}" placeholder="Contoh: Undangan Rapat Koordinasi">
                        </div>

                        <div class="klasifikasi-field">
                            @php $klasifikasiDipilih = old('kode_klasifikasi', $klasifikasi); @endphp
                            <label class="form-label">Kode Klasifikasi</label>
                            <select name="kode_klasifikasi" id="kodeKlasifikasi" class="form-select" data-control="select2">
                                <option value="">— Tanpa klasifikasi —</option>
                                @if ($klasifikasiDipilih && !$klasifikasiList->contains('kode_klasifikasi', $klasifikasiDipilih))
                                    <option value="{{ $klasifikasiDipilih }}" selected>{{ $klasifikasiDipilih }}</option>
                                @endif
                                @foreach ($klasifikasiList as $k)
                                    <option value="{{ $k->kode_klasifikasi }}" @selected($klasifikasiDipilih === $k->kode_klasifikasi)>
                                        {{ $k->kode_klasifikasi }} — {{ $k->nama }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-text">
                                @if (!$isEdit && $template->kode_klasifikasi)
                                    Nilai awal dari template ({{ $template->kode_klasifikasi }}).
                                @endif
                                Dipakai untuk token <code>{klasifikasi}</code> di nomor surat. Daftar dikelola di Manajemen Arsip → Klasifikasi & Retensi.
                            </div>
                        </div>

                        <div class="row g-4">
                            <div class="col-md-4">
                                <label class="form-label required">Tanggal Surat</label>
                                <input type="date" name="tanggal_surat" id="tanggalSurat" class="form-control" required
                                    value="{{ old('tanggal_surat', $surat->tanggal_surat?->format('Y-m-d')) }}">
                            </div>
                            <div class="col-md-8">
                                <label class="form-label required">Nomor Surat</label>
                                <input type="text" name="no_surat" id="noSurat" class="form-control font-monospace" maxlength="255"
                                    value="{{ old('no_surat', $isEdit ? $surat->no_surat : ($otomatis ? $nomorPreview : '')) }}"
                                    @readonly($otomatis || $nomorTerkunci)>
                                @if ($penomoran && !$isEdit)
                                    <div class="d-flex align-items-center justify-content-between mt-2">
                                        <label class="form-check form-switch mb-0">
                                            <input type="hidden" name="nomor_otomatis" value="0">
                                            <input class="form-check-input" type="checkbox" name="nomor_otomatis" value="1" id="nomorOtomatis"
                                                @checked($otomatis) @disabled(!$penomoran->editable)>
                                            @unless ($penomoran->editable)
                                                <input type="hidden" name="nomor_otomatis" value="1">
                                            @endunless
                                            <span class="form-check-label fs-7">Nomor otomatis</span>
                                        </label>
                                        <span class="text-muted fs-8">Format: {{ $penomoran->nama }}</span>
                                    </div>
                                    <div class="form-text" id="nomorHint">
                                        Nomor di atas adalah perkiraan. Nomor final diambil saat surat disimpan.
                                    </div>
                                @elseif (!$penomoran && !$isEdit)
                                    <div class="form-text">Belum ada format penomoran surat keluar, isi nomor secara manual.</div>
                                @elseif ($nomorTerkunci)
                                    <div class="form-text">Nomor dibuat otomatis dan formatnya tidak mengizinkan perubahan manual.</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card arsip-card">
                    <div class="card-header border-0 pt-5">
                        <h3 class="card-title fw-bold">Isian Template: {{ $template->nama }}</h3>
                    </div>
                    <div class="card-body pt-0 d-grid gap-5">
                        @forelse ($template->field_list as $field)
                            @php
                                $name = "data[{$field['key']}]";
                                $value = $data[$field['key']] ?? '';
                                $required = !empty($field['required']);
                            @endphp
                            <div>
                                <label class="form-label {{ $required ? 'required' : '' }}">{{ $field['label'] }}</label>
                                @switch($field['type'] ?? 'text')
                                    @case('textarea')
                                        <textarea name="{{ $name }}" class="form-control" rows="4" @required($required)>{{ $value }}</textarea>
                                    @break

                                    @case('date')
                                        <input type="date" name="{{ $name }}" class="form-control" value="{{ $value }}" @required($required)>
                                    @break

                                    @case('number')
                                        <input type="number" step="any" name="{{ $name }}" class="form-control" value="{{ $value }}" @required($required)>
                                    @break

                                    @default
                                        <input type="text" name="{{ $name }}" class="form-control" value="{{ $value }}" maxlength="1000" @required($required)>
                                @endswitch
                            </div>
                        @empty
                            <div class="text-muted">Template ini tidak memiliki isian tambahan.</div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="col-xl-4">
                <div class="card arsip-card">
                    <div class="card-header border-0 pt-5">
                        <h3 class="card-title fw-bold">Info Template</h3>
                    </div>
                    <div class="card-body pt-0 d-grid gap-3 fs-7">
                        <div><span class="text-muted">Kode:</span> <span class="arsip-kode">{{ $template->kode }}</span></div>
                        <div><span class="text-muted">Kertas:</span> {{ strtoupper($template->ukuran_kertas) }}</div>
                        @if ($template->tampilkan_ttd)
                            <div>
                                <span class="text-muted">Penandatangan:</span><br>
                                {{ $template->penandatangan_nama ?: '-' }}<br>
                                <span class="text-muted">{{ $template->penandatangan_jabatan }}</span>
                            </div>
                        @endif
                        @if ($template->keterangan)
                            <div class="text-muted">{{ $template->keterangan }}</div>
                        @endif
                        @can('surat-template')
                            <a href="{{ route('admin.surat-template.edit', $template) }}" class="fs-7">
                                <i class="fa-solid fa-pen fs-8"></i> Ubah template
                            </a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-3 mt-6">
            <button type="submit" class="btn btn-light-primary" formtarget="_blank" formnovalidate
                formaction="{{ route('admin.surat.template.preview') }}">
                <i class="fa-solid fa-eye"></i> Preview PDF
            </button>
            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-floppy-disk"></i> {{ $isEdit ? 'Simpan Perubahan' : 'Simpan & Buat PDF' }}
            </button>
        </div>
    </form>
@endsection

@section('script')
    <script>
        const templateSelect = document.getElementById('templateSelect');
        if (templateSelect) {
            templateSelect.addEventListener('change', function() {
                const url = new URL(window.location.href);
                url.searchParams.set('template', this.value);
                window.location.href = url.toString();
            });
        }

        const nomorOtomatis = document.getElementById('nomorOtomatis');
        const noSurat = document.getElementById('noSurat');
        const tanggalSurat = document.getElementById('tanggalSurat');

        function refreshNomor() {
            if (!nomorOtomatis || !nomorOtomatis.checked) return;
            $.get("{{ route('admin.surat.nomor-preview') }}", {
                jenis: 'keluar',
                template_id: {{ $template->id }},
                tanggal: tanggalSurat.value,
                klasifikasi: $('#kodeKlasifikasi').val() || ''
            }).done(function(res) {
                if (res.tersedia) noSurat.value = res.nomor;
            });
        }

        if (nomorOtomatis) {
            nomorOtomatis.addEventListener('change', function() {
                noSurat.readOnly = this.checked;
                document.getElementById('nomorHint').classList.toggle('d-none', !this.checked);
                if (this.checked) {
                    refreshNomor();
                } else {
                    noSurat.focus();
                }
            });
            tanggalSurat.addEventListener('change', refreshNomor);
            // select2 memicu event change lewat jQuery, bukan event native
            $('#kodeKlasifikasi').on('change', refreshNomor);
        }
    </script>
@endsection
