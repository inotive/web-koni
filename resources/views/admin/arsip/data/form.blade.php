@extends('layouts.app')

@php $isEdit = $arsip->exists; @endphp

@section('pageTitle', $isEdit ? 'Ubah Arsip' : 'Tambah Arsip')
@section('mainSection', 'Manajemen Arsip')
@section('mainSectionUrl', route('admin.arsip.data.index'))
@section('currentSection', $isEdit ? 'Ubah Arsip' : 'Tambah Arsip')

@include('admin.arsip._assets')

@section('content')
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-6 gap-3">
        <div>
            <h1 class="mb-1">{{ $isEdit ? 'Ubah Arsip ' . $arsip->nomor_arsip : 'Tambah Arsip' }}</h1>
            <span class="text-muted">{{ $isEdit ? 'Perbarui data arsip' : 'Nomor arsip dibuat otomatis saat disimpan' }}</span>
        </div>
        <a href="{{ $isEdit ? route('admin.arsip.data.show', $arsip) : route('admin.arsip.data.index') }}" class="btn btn-light">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    <form method="POST" enctype="multipart/form-data"
        action="{{ $isEdit ? route('admin.arsip.data.update', $arsip) : route('admin.arsip.data.store') }}">
        @csrf
        @if ($isEdit)
            @method('PUT')
        @endif

        <div class="row g-6">
            <div class="col-lg-8">
                <div class="card arsip-card">
                    <div class="card-header border-0 pt-5">
                        <h3 class="card-title fw-bold">Informasi Arsip</h3>
                    </div>
                    <div class="card-body pt-0 d-grid gap-5">
                        <div>
                            <label class="form-label required">Judul / Perihal</label>
                            <input type="text" name="judul" class="form-control" required maxlength="255"
                                value="{{ old('judul', $arsip->judul) }}">
                        </div>
                        <div>
                            <label class="form-label">Uraian</label>
                            <textarea name="uraian" class="form-control" rows="3">{{ old('uraian', $arsip->uraian) }}</textarea>
                        </div>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label">Klasifikasi</label>
                                <select name="arsip_kategori_id" class="form-select">
                                    <option value="">— Pilih klasifikasi —</option>
                                    @foreach ($kategoriList as $k)
                                        <option value="{{ $k->id }}" @selected(old('arsip_kategori_id', $arsip->arsip_kategori_id) == $k->id)>
                                            {{ $k->kode_klasifikasi }} - {{ $k->nama }} (retensi {{ $k->retensi_aktif_tahun }}+{{ $k->retensi_inaktif_tahun }} thn)
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label required">Tanggal Arsip</label>
                                <input type="date" name="tanggal_arsip" class="form-control" required
                                    value="{{ old('tanggal_arsip', $arsip->tanggal_arsip?->format('Y-m-d')) }}">
                            </div>
                        </div>
                        <div class="row g-4">
                            <div class="col-md-3">
                                <label class="form-label required">Jumlah</label>
                                <input type="number" min="1" name="jumlah" class="form-control" required
                                    value="{{ old('jumlah', $arsip->jumlah) }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label required">Satuan</label>
                                <input type="text" name="satuan" class="form-control" required maxlength="20" list="satuanList"
                                    value="{{ old('satuan', $arsip->satuan) }}">
                                <datalist id="satuanList">
                                    <option value="berkas">
                                    <option value="lembar">
                                    <option value="bundel">
                                    <option value="map">
                                    <option value="buku">
                                </datalist>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label required">Tingkat Perkembangan</label>
                                <select name="tingkat_perkembangan" class="form-select">
                                    @foreach (\App\Models\Arsip\Arsip::TINGKAT as $value => $label)
                                        <option value="{{ $value }}" @selected(old('tingkat_perkembangan', $arsip->tingkat_perkembangan) == $value)>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label required">Status</label>
                                <select name="status" class="form-select">
                                    <option value="aktif" @selected(old('status', $arsip->status) == 'aktif')>Aktif</option>
                                    <option value="inaktif" @selected(old('status', $arsip->status) == 'inaktif')>Inaktif</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="form-label">Keterangan</label>
                            <textarea name="keterangan" class="form-control" rows="2">{{ old('keterangan', $arsip->keterangan) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card arsip-card mb-6">
                    <div class="card-header border-0 pt-5">
                        <h3 class="card-title fw-bold">Media & Lokasi</h3>
                    </div>
                    <div class="card-body pt-0 d-grid gap-5">
                        <div>
                            <label class="form-label required">Media</label>
                            <select name="media" id="media" class="form-select">
                                @foreach (\App\Models\Arsip\Arsip::MEDIA as $value => $label)
                                    <option value="{{ $value }}" @selected(old('media', $arsip->media) == $value)>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="form-label" id="lokasiLabel">Lokasi Penyimpanan</label>
                            <select name="arsip_lokasi_id" class="form-select">
                                <option value="">— Tidak ada —</option>
                                @foreach ($lokasiOptions as $opt)
                                    <option value="{{ $opt['id'] }}" @selected(old('arsip_lokasi_id', $arsip->arsip_lokasi_id) == $opt['id'])>{{ $opt['label'] }}</option>
                                @endforeach
                            </select>
                            <div class="form-text">Arsip bisa disimpan di level mana pun (box, baris, rak, dst).</div>
                        </div>
                        <div>
                            <label class="form-label">File Digital / Scan</label>
                            <input type="file" name="file" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx,.xls,.xlsx">
                            <div class="form-text">PDF, gambar, Word, Excel. Maks 20 MB.</div>
                            @if ($isEdit && $arsip->file_path)
                                <div class="mt-2 d-flex align-items-center gap-3">
                                    <a href="{{ route('admin.arsip.data.file', $arsip) }}" target="_blank">
                                        <i class="fa-solid fa-paperclip"></i> File saat ini
                                    </a>
                                    <label class="form-check form-check-sm">
                                        <input type="checkbox" class="form-check-input" name="hapus_file" value="1">
                                        <span class="form-check-label text-danger">Hapus file</span>
                                    </label>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card arsip-card mb-6">
                    <div class="card-header border-0 pt-5">
                        <h3 class="card-title fw-bold">Tautkan ke Data Lain</h3>
                    </div>
                    <div class="card-body pt-0 d-grid gap-3">
                        @php
                            $oldSumber = old('sumber', $arsip->sumber_key);
                            $oldSumberId = old('sumber_id', $arsip->sumber_id);
                        @endphp
                        <select name="sumber" id="sumber" class="form-select">
                            <option value="">— Tidak ditautkan —</option>
                            <option value="surat" @selected($oldSumber == 'surat')>Surat Masuk & Keluar</option>
                            <option value="file_kesekretariat" @selected($oldSumber == 'file_kesekretariat')>File Kesekretariat</option>
                        </select>
                        <div id="sumberPicker" class="{{ $oldSumber ? '' : 'd-none' }} d-grid gap-2">
                            <input type="text" id="sumberSearch" class="form-control form-control-sm" placeholder="Cari...">
                            <select name="sumber_id" id="sumber_id" class="form-select">
                                @if ($oldSumberId && $sumberText)
                                    <option value="{{ $oldSumberId }}" selected>{{ $sumberText }}</option>
                                @endif
                            </select>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100">
                    <i class="fa-solid fa-floppy-disk"></i> {{ $isEdit ? 'Simpan Perubahan' : 'Simpan Arsip' }}
                </button>
            </div>
        </div>
    </form>
@endsection

@section('script')
    <script>
        const sumberSelect = document.getElementById('sumber');
        const sumberIdSelect = document.getElementById('sumber_id');
        const sumberSearch = document.getElementById('sumberSearch');
        let searchTimer;

        function loadSumber(keepSelected = false) {
            const type = sumberSelect.value;
            document.getElementById('sumberPicker').classList.toggle('d-none', !type);
            if (!type) {
                sumberIdSelect.innerHTML = '';
                return;
            }
            const selected = keepSelected ? sumberIdSelect.value : null;
            const url = new URL("{{ route('admin.arsip.data.sumber-options') }}");
            url.searchParams.set('type', type);
            url.searchParams.set('q', sumberSearch.value);

            fetch(url, { headers: { 'Accept': 'application/json' } })
                .then(r => r.json())
                .then(items => {
                    const current = selected ? sumberIdSelect.querySelector(`option[value="${selected}"]`) : null;
                    sumberIdSelect.innerHTML = '';
                    if (current && !items.some(i => String(i.id) === selected)) sumberIdSelect.appendChild(current);
                    if (!items.length && !current) {
                        sumberIdSelect.add(new Option('Tidak ada data', ''));
                    }
                    items.forEach(i => sumberIdSelect.add(new Option(i.text, i.id, false, String(i.id) === selected)));
                });
        }

        sumberSelect.addEventListener('change', () => {
            sumberSearch.value = '';
            loadSumber(false);
        });
        sumberSearch.addEventListener('input', () => {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(() => loadSumber(true), 300);
        });
        if (sumberSelect.value) loadSumber(true);

        // Lokasi wajib untuk arsip fisik
        const media = document.getElementById('media');
        function toggleLokasiRequired() {
            document.getElementById('lokasiLabel').classList.toggle('required', media.value !== 'digital');
        }
        media.addEventListener('change', toggleLokasiRequired);
        toggleLokasiRequired();
    </script>
@endsection
