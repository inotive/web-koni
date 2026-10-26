@extends('layouts.app')

@php
    $isEdit = $template->exists;
    $fields = old('fields', $template->field_list);
@endphp

@section('pageTitle', $isEdit ? 'Ubah Template Surat' : 'Tambah Template Surat')
@section('mainSection', 'Template Surat')
@section('mainSectionUrl', route('admin.surat-template.index'))
@section('currentSection', $isEdit ? 'Ubah Template' : 'Tambah Template')

@include('admin.arsip._assets')

@push('stack-css')
    <style>
        .placeholder-btn code {
            font-size: .75rem;
        }

        /* Layar lebar: kolom utama ikut scroll halaman, kolom kanan menempel dengan scroll sendiri */
        @media (min-width: 1200px) {
            .template-columns {
                align-items: flex-start;
            }

            .template-scroll {
                position: sticky;
                top: 1rem;
                max-height: calc(100vh - 2rem);
                overflow-y: auto;
                overscroll-behavior: contain;
                padding: 4px 8px 4px 4px;
                scrollbar-width: thin;
            }
        }

        .field-row {
            background: #f9fafb;
            border: 1px solid #eef0f3;
            border-radius: 8px;
            padding: .75rem;
        }
    </style>
@endpush

@section('content')
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-6 gap-3">
        <div>
            <h1 class="mb-1">{{ $isEdit ? 'Ubah Template: ' . $template->nama : 'Tambah Template Surat' }}</h1>
            <span class="text-muted">Tulis isi surat lalu sisipkan placeholder. Placeholder diganti dengan data saat surat dibuat.</span>
        </div>
        <a href="{{ route('admin.surat-template.index') }}" class="btn btn-light">
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

    <form method="POST" enctype="multipart/form-data" id="templateForm"
        action="{{ $isEdit ? route('admin.surat-template.update', $template) : route('admin.surat-template.store') }}">
        @csrf
        @if ($isEdit)
            @method('PUT')
        @endif

        <div class="row g-6 template-columns">
            <div class="col-xl-8">
                <div class="card arsip-card mb-6">
                    <div class="card-header border-0 pt-5">
                        <h3 class="card-title fw-bold">Informasi Template</h3>
                    </div>
                    <div class="card-body pt-0 d-grid gap-5">
                        <div class="row g-4">
                            <div class="col-md-8">
                                <label class="form-label required">Nama Template</label>
                                <input type="text" name="nama" class="form-control" required maxlength="255"
                                    value="{{ old('nama', $template->nama) }}" placeholder="Contoh: Undangan Rapat">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label required">Kode Surat</label>
                                <input type="text" name="kode" class="form-control text-uppercase" required maxlength="50"
                                    value="{{ old('kode', $template->kode) }}" placeholder="UND">
                                <div class="form-text">Dipakai untuk token <code>{kode}</code> di nomor surat.</div>
                            </div>
                        </div>
                        <div class="row g-4">
                            <div class="col-md-5">
                                <label class="form-label">Format Penomoran</label>
                                <select name="surat_penomoran_id" class="form-select">
                                    <option value="">— Pakai default surat keluar —</option>
                                    @foreach ($penomoranList as $p)
                                        <option value="{{ $p->id }}" @selected(old('surat_penomoran_id', $template->surat_penomoran_id) == $p->id)>
                                            {{ $p->nama }} ({{ $p->format }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Kode Klasifikasi</label>
                                <input type="text" name="kode_klasifikasi" class="form-control" maxlength="50" list="klasifikasiList"
                                    value="{{ old('kode_klasifikasi', $template->kode_klasifikasi) }}" placeholder="Opsional">
                                <datalist id="klasifikasiList">
                                    @foreach ($klasifikasiList as $k)
                                        <option value="{{ $k->kode_klasifikasi }}">{{ $k->nama }}</option>
                                    @endforeach
                                </datalist>
                                <div class="form-text">Untuk token <code>{klasifikasi}</code>.</div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label required">Ukuran Kertas</label>
                                <select name="ukuran_kertas" class="form-select" required>
                                    <option value="a4" @selected(old('ukuran_kertas', $template->ukuran_kertas) === 'a4')>A4</option>
                                    <option value="f4" @selected(old('ukuran_kertas', $template->ukuran_kertas) === 'f4')>F4 / Folio</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="form-label">Keterangan</label>
                            <input type="text" name="keterangan" class="form-control" value="{{ old('keterangan', $template->keterangan) }}">
                        </div>
                        <label class="form-check form-switch">
                            <input type="hidden" name="is_active" value="0">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1" @checked(old('is_active', $template->is_active))>
                            <span class="form-check-label">Aktif (bisa dipilih saat membuat surat)</span>
                        </label>
                    </div>
                </div>

                <div class="card arsip-card">
                    <div class="card-header border-0 pt-5">
                        <h3 class="card-title fw-bold">Isi Surat</h3>
                    </div>
                    <div class="card-body pt-0">
                        <div class="mb-3">
                            <div class="text-muted fs-7 mb-2">Klik untuk menyisipkan placeholder di posisi kursor:</div>
                            <div class="d-flex flex-wrap gap-2" id="placeholderBar">
                                @foreach (\App\Models\SuratTemplate::PLACEHOLDERS as $key => $label)
                                    <button type="button" class="btn btn-sm btn-light py-1 px-2 placeholder-btn" data-key="{{ $key }}" title="{{ $label }}">
                                        <code>&#123;&#123;{{ $key }}&#125;&#125;</code>
                                    </button>
                                @endforeach
                            </div>
                        </div>
                        <textarea name="isi" id="isi">{{ old('isi', $template->isi) }}</textarea>
                        <div class="form-text mt-2">
                            Kop surat dan blok tanda tangan ditambahkan otomatis (atur di panel kanan), jadi tidak perlu ditulis di sini.
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 template-scroll">
                <div class="card arsip-card mb-6">
                    <div class="card-header border-0 pt-5">
                        <h3 class="card-title fw-bold">Isian Surat</h3>
                    </div>
                    <div class="card-body pt-0">
                        <div class="text-muted fs-7 mb-4">
                            Isian yang diisi pengguna saat membuat surat, misalnya Tujuan, Hari/Tanggal Acara, Tempat.
                        </div>
                        <div id="fieldList" class="d-grid gap-3"></div>
                        <button type="button" class="btn btn-sm btn-light-primary mt-4 w-100" id="addFieldBtn">
                            <i class="fa-solid fa-plus"></i> Tambah Isian
                        </button>
                    </div>
                </div>

                <div class="card arsip-card mb-6">
                    <div class="card-header border-0 pt-5">
                        <h3 class="card-title fw-bold">Kop Surat</h3>
                    </div>
                    <div class="card-body pt-0 d-grid gap-4">
                        <label class="form-check form-switch">
                            <input type="hidden" name="tampilkan_kop" value="0">
                            <input class="form-check-input" type="checkbox" name="tampilkan_kop" value="1" @checked(old('tampilkan_kop', $template->tampilkan_kop ?? true))>
                            <span class="form-check-label">Tampilkan kop surat</span>
                        </label>
                        <div>
                            <select name="surat_kop_id" class="form-select">
                                <option value="">— Pakai kop default{{ $kopDefault ? ' (' . $kopDefault->nama . ')' : '' }} —</option>
                                @foreach ($kopList as $k)
                                    <option value="{{ $k->id }}" @selected(old('surat_kop_id', $template->surat_kop_id) == $k->id)>{{ $k->nama }}</option>
                                @endforeach
                            </select>
                            <div class="form-text">
                                Atur kop di menu
                                @can('surat-template')
                                    <a href="{{ route('admin.surat-kop.index') }}" target="_blank">Kop Surat</a>.
                                @endcan
                            </div>
                        </div>

                        {{-- Gambar kop khusus template (cara lama) menggantikan pilihan kop di atas --}}
                        @if ($template->kop_surat)
                            <div class="rounded p-3 bg-light-warning">
                                <div class="fs-7 mb-2">Template ini memakai <strong>gambar kop khusus</strong> yang menggantikan pilihan kop di atas:</div>
                                <img src="{{ asset('storage/' . $template->kop_surat) }}" class="img-fluid border rounded bg-white" alt="Kop surat">
                                <label class="form-check mt-2">
                                    <input class="form-check-input" type="checkbox" name="hapus_kop_surat" value="1">
                                    <span class="form-check-label fs-7">Hapus gambar khusus, pakai pilihan kop di atas</span>
                                </label>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="card arsip-card">
                    <div class="card-header border-0 pt-5">
                        <h3 class="card-title fw-bold">Penandatangan</h3>
                    </div>
                    <div class="card-body pt-0 d-grid gap-4">
                        <label class="form-check form-switch">
                            <input type="hidden" name="tampilkan_ttd" value="0">
                            <input class="form-check-input" type="checkbox" name="tampilkan_ttd" value="1" @checked(old('tampilkan_ttd', $template->tampilkan_ttd))>
                            <span class="form-check-label">Tampilkan blok tanda tangan</span>
                        </label>
                        <div>
                            <label class="form-label">Kota Surat</label>
                            <input type="text" name="kota_surat" class="form-control" value="{{ old('kota_surat', $template->kota_surat) }}" placeholder="Contoh: Balikpapan">
                        </div>
                        <div>
                            <label class="form-label">Jabatan</label>
                            <input type="text" name="penandatangan_jabatan" class="form-control" value="{{ old('penandatangan_jabatan', $template->penandatangan_jabatan) }}" placeholder="Ketua Umum">
                        </div>
                        <div>
                            <label class="form-label">Nama</label>
                            <input type="text" name="penandatangan_nama" class="form-control" value="{{ old('penandatangan_nama', $template->penandatangan_nama) }}">
                        </div>
                        <div>
                            <label class="form-label">NIP / NIK</label>
                            <input type="text" name="penandatangan_nip" class="form-control" value="{{ old('penandatangan_nip', $template->penandatangan_nip) }}">
                        </div>
                        <div>
                            <label class="form-label">Gambar Tanda Tangan / Stempel</label>
                            @if ($template->ttd)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $template->ttd) }}" style="max-height: 80px" class="border rounded" alt="Tanda tangan">
                                    <label class="form-check mt-2">
                                        <input class="form-check-input" type="checkbox" name="hapus_ttd" value="1">
                                        <span class="form-check-label">Hapus gambar</span>
                                    </label>
                                </div>
                            @endif
                            <input type="file" name="ttd" class="form-control" accept="image/*">
                            <div class="form-text">Opsional. PNG transparan, maks. 1 MB.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-3 mt-6">
            <button type="submit" class="btn btn-light-primary" formtarget="_blank" formnovalidate
                formaction="{{ $isEdit ? route('admin.surat-template.preview', $template) : route('admin.surat-template.preview') }}">
                <i class="fa-solid fa-eye"></i> Preview PDF
            </button>
            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-floppy-disk"></i> Simpan Template
            </button>
        </div>
    </form>

    <template id="fieldTemplate">
        <div class="field-row">
            <input type="hidden" data-name="key">
            <div class="d-flex gap-2 mb-2">
                <input type="text" class="form-control form-control-sm" data-name="label" placeholder="Label, misal: Tujuan Surat" required>
                <button type="button" class="btn btn-sm btn-icon btn-light-danger remove-field" title="Hapus isian">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="d-flex gap-2 align-items-center">
                <select class="form-select form-select-sm" data-name="type">
                    @foreach (\App\Models\SuratTemplate::FIELD_TYPES as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
                <label class="form-check form-check-sm text-nowrap mb-0">
                    <input type="checkbox" class="form-check-input" data-name="required" value="1">
                    <span class="form-check-label fs-8">Wajib</span>
                </label>
            </div>
            <button type="button" class="btn btn-link btn-sm p-0 mt-2 insert-field fs-8">
                Sisipkan <code class="field-placeholder"></code>
            </button>
        </div>
    </template>
@endsection

@section('script')
    <script src="{{ asset('assets/plugins/custom/tinymce/tinymce.bundle.js') }}"></script>
    <script>
        tinymce.init({
            selector: '#isi',
            license_key: 'gpl',
            // Nama file tinymce.bundle.js tidak dikenali TinyMCE, jadi lokasi skin/icon harus ditulis eksplisit
            base_url: "{{ asset('assets/plugins/custom/tinymce') }}",
            suffix: '.min',
            height: 640,
            menubar: 'edit insert format table',
            plugins: 'lists advlist table code pagebreak fullscreen link',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline | alignleft aligncenter alignright alignjustify gabungbaris | lineheight | bullist numlist outdent indent | table | pagebreak | code fullscreen',
            // dompdf mengabaikan <colgroup>, jadi lebar kolom disimpan di setiap sel
            table_use_colgroups: false,
            table_toolbar: 'tableprops tabledelete | garistabel | tableinsertrowbefore tableinsertrowafter tabledeleterow | tableinsertcolbefore tableinsertcolafter tabledeletecol',
            setup: function(editor) {
                // Tabel tanpa garis: class tabel-polos (garis disembunyikan juga di PDF, lihat pdf.blade.php)
                editor.ui.registry.addToggleButton('garistabel', {
                    icon: 'border-style',
                    text: 'Sembunyikan Garis',
                    tooltip: 'Sembunyikan / tampilkan garis tabel ini',
                    onAction: function() {
                        const table = editor.dom.getParent(editor.selection.getNode(), 'table');
                        if (!table) return;
                        editor.undoManager.transact(function() {
                            editor.dom.toggleClass(table, 'tabel-polos');
                        });
                        editor.nodeChanged();
                    },
                    onSetup: function(api) {
                        const update = function() {
                            const table = editor.dom.getParent(editor.selection.getNode(), 'table');
                            api.setActive(!!table && editor.dom.hasClass(table, 'tabel-polos'));
                        };
                        editor.on('NodeChange', update);
                        update();
                        return function() {
                            editor.off('NodeChange', update);
                        };
                    }
                });

                // Teks hasil salin dari PDF/Word sering berisi <br> di tiap baris, sehingga justify tidak bisa meratakan.
                // Tombol ini mengubah <br> dan spasi ganda pada teks yang diblok menjadi spasi biasa.
                editor.ui.registry.addButton('gabungbaris', {
                    icon: 'unlink',
                    text: 'Gabungkan Baris',
                    tooltip: 'Gabungkan baris pada teks yang diblok agar rata kanan-kiri (justify) berfungsi',
                    onAction: function() {
                        const html = editor.selection.getContent();
                        if (!html.trim()) {
                            editor.notificationManager.open({
                                text: 'Blok dulu teks paragraf yang barisnya ingin digabung.',
                                type: 'info',
                                timeout: 3000
                            });
                            return;
                        }
                        editor.undoManager.transact(function() {
                            editor.selection.setContent(
                                html.replace(/<br\s*\/?>\s*/gi, ' ')
                                .replace(/(&nbsp;| )+/g, ' ')
                                .replace(/ {2,}/g, ' ')
                            );
                        });
                    }
                });
            },
            font_family_formats: 'Times New Roman=Times New Roman,Times,serif; Arial=Arial,Helvetica,sans-serif; Courier New=Courier New,Courier,monospace',
            font_size_formats: '9pt 10pt 11pt 12pt 14pt 16pt 18pt',
            content_style: 'body { font-family: "Times New Roman", Times, serif; font-size: 12pt; line-height: 1.4; max-width: 165mm; margin: 1rem auto; } p { margin: 0 0 8pt; }' +
                // Panduan garis putus-putus untuk tabel tanpa garis; hanya di editor, tidak tercetak
                ' table.tabel-polos, table.tabel-polos td, table.tabel-polos th { border: 1px dashed #c8cdd5 !important; }',
            promotion: false,
            branding: false,
            pagebreak_separator: '<div style="page-break-after: always"></div>',
        }).then(function(editors) {
            if (!editors.length) showPlainIsi();
        }).catch(showPlainIsi);

        // Bila editor gagal dimuat, tampilkan textarea biasa agar isi tetap bisa diketik (HTML)
        function showPlainIsi() {
            const textarea = document.getElementById('isi');
            textarea.style.display = '';
            textarea.classList.add('form-control', 'font-monospace');
            textarea.rows = 20;
            toastr.warning('Editor teks gagal dimuat, isi surat bisa ditulis sebagai HTML.', 'Perhatian');
        }

        function insertPlaceholder(key) {
            const text = '{' + '{' + key + '}' + '}';
            const editor = tinymce.get('isi');
            if (editor && editor.initialized) {
                editor.insertContent(text);
                editor.focus();
                return;
            }
            const textarea = document.getElementById('isi');
            const pos = textarea.selectionStart ?? textarea.value.length;
            textarea.value = textarea.value.slice(0, pos) + text + textarea.value.slice(textarea.selectionEnd ?? pos);
            textarea.focus();
            textarea.setSelectionRange(pos + text.length, pos + text.length);
        }

        function slugKey(text) {
            return text.normalize('NFD').replace(/[̀-ͯ]/g, '').toLowerCase()
                .replace(/[^a-z0-9]+/g, '_').replace(/^_+|_+$/g, '') || 'field';
        }

        const fieldList = document.getElementById('fieldList');
        const fieldTemplate = document.getElementById('fieldTemplate');

        function renumberFields() {
            fieldList.querySelectorAll('.field-row').forEach(function(row, i) {
                row.querySelectorAll('[data-name]').forEach(function(input) {
                    input.name = `fields[${i}][${input.dataset.name}]`;
                });
            });
        }

        function addField(data = {}) {
            const node = fieldTemplate.content.firstElementChild.cloneNode(true);
            const key = node.querySelector('[data-name="key"]');
            const label = node.querySelector('[data-name="label"]');
            const code = node.querySelector('.field-placeholder');

            label.value = data.label ?? '';
            node.querySelector('[data-name="type"]').value = data.type ?? 'text';
            node.querySelector('[data-name="required"]').checked = data.required === true || data.required === '1';
            key.value = data.key ?? '';

            // Field baru: key mengikuti label. Field lama: key dikunci agar placeholder di isi tidak putus.
            const lockedKey = !!data.key;
            const refresh = function() {
                if (!lockedKey) key.value = slugKey(label.value);
                code.textContent = '{' + '{' + (key.value || '...') + '}' + '}';
            };
            label.addEventListener('input', refresh);
            refresh();

            node.querySelector('.remove-field').addEventListener('click', function() {
                node.remove();
                renumberFields();
            });
            node.querySelector('.insert-field').addEventListener('click', function() {
                if (key.value) insertPlaceholder(key.value);
            });

            fieldList.appendChild(node);
            renumberFields();
        }

        document.getElementById('addFieldBtn').addEventListener('click', function() {
            addField();
        });

        document.querySelectorAll('.placeholder-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                insertPlaceholder(btn.dataset.key);
            });
        });

        @json(array_values($fields)).forEach(addField);
    </script>
@endsection
