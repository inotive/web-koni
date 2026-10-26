@extends('layouts.app')

@php
    $isEdit = $kop->exists;
    $baris = old('baris', $kop->baris_list);
    $jenis = old('jenis', $kop->jenis);
    $view = app(\App\Services\SuratTemplateRenderer::class)->kopToView($kop);
    $logo = [
        'gambar' => $kop->gambar ? ($view['src'] ?? null) : null,
        'logo_kiri' => $view['logo_kiri'] ?? null,
        'logo_kanan' => $view['logo_kanan'] ?? null,
    ];
@endphp

@section('pageTitle', $isEdit ? 'Ubah Kop Surat' : 'Tambah Kop Surat')
@section('mainSection', 'Kop Surat')
@section('mainSectionUrl', route('admin.surat-kop.index'))
@section('currentSection', $isEdit ? 'Ubah Kop' : 'Tambah Kop')

@include('admin.arsip._assets')

@push('stack-css')
    <style>
        .kop-live {
            background: #fff;
            border: 1px solid #e4e6ef;
            border-radius: 8px;
            padding: 16px 20px;
            font-family: "Times New Roman", Times, serif;
            color: #000;
        }

        .baris-row {
            background: #f9fafb;
            border: 1px solid #eef0f3;
            border-radius: 8px;
            padding: .5rem .75rem;
        }
    </style>
@endpush

@section('content')
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-6 gap-3">
        <div>
            <h1 class="mb-1">{{ $isEdit ? 'Ubah Kop: ' . $kop->nama : 'Tambah Kop Surat' }}</h1>
            <span class="text-muted">Upload gambar kop jadi, atau susun logo dan teks langsung di sini.</span>
        </div>
        <a href="{{ route('admin.surat-kop.index') }}" class="btn btn-light">
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

    <form method="POST" enctype="multipart/form-data" id="kopForm"
        action="{{ $isEdit ? route('admin.surat-kop.update', $kop) : route('admin.surat-kop.store') }}">
        @csrf
        @if ($isEdit)
            @method('PUT')
        @endif

        <div class="row g-6">
            <div class="col-xl-5">
                <div class="card arsip-card">
                    <div class="card-body d-grid gap-5">
                        <div>
                            <label class="form-label required">Nama Kop</label>
                            <input type="text" name="nama" class="form-control" required maxlength="255"
                                value="{{ old('nama', $kop->nama) }}" placeholder="Contoh: Kop Resmi KONI">
                        </div>

                        <div>
                            <label class="form-label required">Cara Membuat Kop</label>
                            <div class="d-flex gap-6">
                                @foreach (\App\Models\SuratKop::JENIS as $value => $label)
                                    <label class="form-check">
                                        <input class="form-check-input" type="radio" name="jenis" value="{{ $value }}" @checked($jenis === $value)>
                                        <span class="form-check-label">{{ $label }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- Jenis: gambar --}}
                        <div data-jenis="gambar" class="d-grid gap-3">
                            <label class="form-label mb-0 {{ $kop->gambar ? '' : 'required' }}">Gambar Kop</label>
                            <input type="file" name="gambar" class="form-control" accept="image/*" data-preview="gambar">
                            <div class="form-text mt-0">Gambar selebar halaman, PNG/JPG maks. 2 MB. Rasio sekitar 6:1 pas untuk A4.</div>
                        </div>

                        {{-- Jenis: susun --}}
                        <div data-jenis="susun" class="d-grid gap-5">
                            <div class="row g-4">
                                @foreach (['logo_kiri' => 'Logo Kiri', 'logo_kanan' => 'Logo Kanan'] as $field => $label)
                                    <div class="col-6">
                                        <label class="form-label">{{ $label }}</label>
                                        <input type="file" name="{{ $field }}" class="form-control form-control-sm" accept="image/*" data-preview="{{ $field }}">
                                        @if ($kop->{$field})
                                            <label class="form-check mt-2">
                                                <input class="form-check-input" type="checkbox" name="hapus_{{ $field }}" value="1" data-hapus="{{ $field }}">
                                                <span class="form-check-label fs-7">Hapus logo</span>
                                            </label>
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                            <div>
                                <label class="form-label">Baris Teks</label>
                                <div id="barisList" class="d-grid gap-2"></div>
                                <button type="button" class="btn btn-sm btn-light-primary mt-3 w-100" id="addBarisBtn">
                                    <i class="fa-solid fa-plus"></i> Tambah Baris
                                </button>
                            </div>

                            <div>
                                <label class="form-label">Garis Bawah Kop</label>
                                <select name="garis" class="form-select" id="garisSelect">
                                    @foreach (\App\Models\SuratKop::GARIS as $value => $label)
                                        <option value="{{ $value }}" @selected(old('garis', $kop->garis) === $value)>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-6">
                            <label class="form-check form-switch">
                                <input type="hidden" name="is_default" value="0">
                                <input class="form-check-input" type="checkbox" name="is_default" value="1" @checked(old('is_default', $kop->is_default))>
                                <span class="form-check-label">Jadikan kop default</span>
                            </label>
                            <label class="form-check form-switch">
                                <input type="hidden" name="is_active" value="0">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1" @checked(old('is_active', $kop->is_active))>
                                <span class="form-check-label">Aktif</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-7">
                <div class="card arsip-card">
                    <div class="card-header border-0 pt-5">
                        <h3 class="card-title fw-bold">Preview</h3>
                    </div>
                    <div class="card-body pt-0">
                        <div class="kop-live" id="kopLive"></div>
                        <div class="form-text mt-3">Perkiraan tampilan. Klik <strong>Preview PDF</strong> untuk hasil persis di kertas A4.</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-3 mt-6">
            <button type="submit" class="btn btn-light-primary" formtarget="_blank" formnovalidate
                formaction="{{ $isEdit ? route('admin.surat-kop.preview', $kop) : route('admin.surat-kop.preview') }}">
                <i class="fa-solid fa-eye"></i> Preview PDF
            </button>
            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-floppy-disk"></i> Simpan Kop
            </button>
        </div>
    </form>

    <template id="barisTemplate">
        <div class="baris-row d-flex gap-2 align-items-center">
            <input type="text" class="form-control form-control-sm" data-name="teks" placeholder="Teks baris" maxlength="255">
            <input type="number" class="form-control form-control-sm" data-name="ukuran" min="6" max="30" step="0.5" style="width: 72px" title="Ukuran huruf (pt)">
            <label class="form-check form-check-sm mb-0 text-nowrap" title="Tebal">
                <input type="checkbox" class="form-check-input" data-name="tebal" value="1">
                <span class="form-check-label fw-bold">B</span>
            </label>
            <button type="button" class="btn btn-sm btn-icon btn-light move-up" title="Naikkan"><i class="fa-solid fa-arrow-up"></i></button>
            <button type="button" class="btn btn-sm btn-icon btn-light-danger remove-baris" title="Hapus"><i class="fa-solid fa-xmark"></i></button>
        </div>
    </template>
@endsection

@section('script')
    <script>
        const images = @json($logo);
        const barisList = document.getElementById('barisList');
        const live = document.getElementById('kopLive');

        function currentJenis() {
            return document.querySelector('input[name="jenis"]:checked')?.value ?? 'susun';
        }

        function renumberBaris() {
            barisList.querySelectorAll('.baris-row').forEach(function(row, i) {
                row.querySelectorAll('[data-name]').forEach(function(input) {
                    input.name = `baris[${i}][${input.dataset.name}]`;
                });
            });
            renderLive();
        }

        function addBaris(data = {}) {
            const node = document.getElementById('barisTemplate').content.firstElementChild.cloneNode(true);
            node.querySelector('[data-name="teks"]').value = data.teks ?? '';
            node.querySelector('[data-name="ukuran"]').value = data.ukuran ?? 11;
            node.querySelector('[data-name="tebal"]').checked = data.tebal === true || data.tebal === '1';
            node.querySelector('.remove-baris').addEventListener('click', function() {
                node.remove();
                renumberBaris();
            });
            node.querySelector('.move-up').addEventListener('click', function() {
                if (node.previousElementSibling) {
                    barisList.insertBefore(node, node.previousElementSibling);
                    renumberBaris();
                }
            });
            node.addEventListener('input', renderLive);
            node.addEventListener('change', renderLive);
            barisList.appendChild(node);
            renumberBaris();
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        // Tiruan ringan dari partial admin.surat-kop._kop agar perubahan langsung terlihat
        function renderLive() {
            if (currentJenis() === 'gambar') {
                live.innerHTML = images.gambar ?
                    `<img src="${images.gambar}" style="width:100%">` :
                    '<div class="text-muted text-center py-6">Belum ada gambar kop.</div>';
                return;
            }

            const rows = [...barisList.querySelectorAll('.baris-row')].map(function(row) {
                const teks = row.querySelector('[data-name="teks"]').value;
                const ukuran = parseFloat(row.querySelector('[data-name="ukuran"]').value) || 11;
                const tebal = row.querySelector('[data-name="tebal"]').checked;
                return teks.trim() ? `<div style="font-size:${ukuran}pt;${tebal ? 'font-weight:bold;' : ''}">${escapeHtml(teks)}</div>` : '';
            }).join('');

            const logo = function(key, align) {
                return `<td style="width:22mm;text-align:${align};vertical-align:middle;padding-bottom:2mm">${images[key] ? `<img src="${images[key]}" style="width:22mm">` : ''}</td>`;
            };
            const hasLogo = images.logo_kiri || images.logo_kanan;
            const border = {
                tunggal: '2px solid #000',
                ganda: '4px double #000'
            }[document.getElementById('garisSelect').value];

            live.innerHTML = `<table style="width:100%;border-collapse:collapse;${border ? 'border-bottom:' + border : ''}"><tr>` +
                (hasLogo ? logo('logo_kiri', 'left') : '') +
                `<td style="text-align:center;vertical-align:middle;padding-bottom:2mm;line-height:1.2">${rows || '<span class="text-muted">Tambahkan baris teks</span>'}</td>` +
                (hasLogo ? logo('logo_kanan', 'right') : '') +
                '</tr></table>';
        }

        function toggleJenis() {
            const jenis = currentJenis();
            document.querySelectorAll('[data-jenis]').forEach(function(el) {
                el.classList.toggle('d-none', el.dataset.jenis !== jenis);
            });
            renderLive();
        }

        document.querySelectorAll('input[name="jenis"]').forEach(function(radio) {
            radio.addEventListener('change', toggleJenis);
        });
        document.getElementById('garisSelect').addEventListener('change', renderLive);
        document.getElementById('addBarisBtn').addEventListener('click', function() {
            addBaris();
        });

        // Gambar baru yang dipilih langsung tampil di preview
        document.querySelectorAll('[data-preview]').forEach(function(input) {
            input.addEventListener('change', function() {
                const file = input.files[0];
                if (!file) return;
                const reader = new FileReader();
                reader.onload = function(e) {
                    images[input.dataset.preview] = e.target.result;
                    renderLive();
                };
                reader.readAsDataURL(file);
            });
        });
        document.querySelectorAll('[data-hapus]').forEach(function(checkbox) {
            const original = images[checkbox.dataset.hapus];
            checkbox.addEventListener('change', function() {
                images[checkbox.dataset.hapus] = checkbox.checked ? null : original;
                renderLive();
            });
        });

        @json(array_values($baris)).forEach(addBaris);
        toggleJenis();
    </script>
@endsection
