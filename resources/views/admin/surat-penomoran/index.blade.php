@extends('layouts.app')

@section('pageTitle', 'Pengaturan Penomoran Surat')
@section('mainSection', 'Surat Masuk & Keluar')
@section('currentSection', 'Pengaturan Penomoran')

@include('admin.arsip._assets')

@section('content')
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-6 gap-3">
        <div>
            <h1 class="mb-1">Pengaturan Penomoran</h1>
            <span class="text-muted">Format nomor surat keluar dan nomor agenda surat masuk yang dibuat otomatis</span>
        </div>
        <button class="btn btn-primary" onclick="openPenomoranModal({})">
            <i class="fa-solid fa-plus"></i> Tambah Format
        </button>
    </div>

    <div class="card arsip-card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-row-dashed arsip-table">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Berlaku Untuk</th>
                            <th>Format</th>
                            <th>Reset</th>
                            <th>Nomor Terakhir (periode berjalan)</th>
                            <th class="text-center">Dipakai</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($penomoran as $item)
                            <tr class="{{ $item->is_active ? '' : 'opacity-50' }}">
                                <td>
                                    <div class="fw-semibold">
                                        {{ $item->nama }}
                                        @if ($item->is_default)
                                            <span class="badge badge-light-success ms-1">Default</span>
                                        @endif
                                        @unless ($item->is_active)
                                            <span class="badge badge-light ms-1">Nonaktif</span>
                                        @endunless
                                    </div>
                                    @if ($item->keterangan)
                                        <div class="text-muted fs-7">{{ $item->keterangan }}</div>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge {{ $item->berlaku_untuk === 'keluar' ? 'badge-light-primary' : 'badge-light-info' }}">
                                        {{ $item->berlaku_untuk_label }}
                                    </span>
                                </td>
                                <td>
                                    <div><span class="arsip-kode">{{ $item->format }}</span></div>
                                    <div class="text-muted fs-7 mt-1">Contoh: {{ $item->contoh }}</div>
                                    <div class="text-muted fs-8">
                                        {{ $item->scope === 'per_kode' ? 'Urutan per kode' : 'Urutan bersama' }}
                                        · {{ $item->editable ? 'Boleh diedit manual' : 'Terkunci' }}
                                    </div>
                                </td>
                                <td>{{ $item->reset_period_label }}</td>
                                <td>
                                    <div class="text-muted fs-8 mb-1">Periode {{ $item->periode_berjalan === '-' ? 'tanpa reset' : $item->periode_berjalan }}</div>
                                    @forelse ($item->counter_berjalan as $kode => $last)
                                        <div>
                                            @if ($item->scope === 'per_kode')
                                                <span class="arsip-kode">{{ $kode ?: '(tanpa kode)' }}</span>
                                            @endif
                                            <strong>{{ $last }}</strong>
                                        </div>
                                    @empty
                                        <span class="text-muted">Belum ada</span>
                                    @endforelse
                                </td>
                                <td class="text-center">
                                    <div>{{ $item->surat_count }} surat</div>
                                    <div class="text-muted fs-8">{{ $item->templates_count }} template</div>
                                </td>
                                <td class="text-end text-nowrap">
                                    <button class="btn btn-sm btn-icon btn-light-primary" title="Atur nomor terakhir"
                                        onclick="openCounterModal({{ json_encode(['id' => $item->id, 'nama' => $item->nama, 'scope' => $item->scope, 'last' => $item->counter_berjalan->first() ?? 0]) }})">
                                        <i class="fa-solid fa-arrow-up-9-1"></i>
                                    </button>
                                    <button class="btn btn-sm btn-icon btn-light" title="Ubah"
                                        onclick="openPenomoranModal({{ json_encode($item->only(['id', 'nama', 'format', 'digit', 'reset_period', 'scope', 'editable', 'berlaku_untuk', 'is_default', 'is_active', 'keterangan'])) }})">
                                        <i class="fa-solid fa-pen"></i>
                                    </button>
                                    <form action="{{ route('admin.surat-penomoran.destroy', $item) }}" method="POST" class="d-inline"
                                        data-confirm="Hapus format penomoran {{ $item->nama }}?">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-icon btn-light-danger" title="Hapus"><i class="fa-solid fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-10">Belum ada format penomoran.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Modal tambah / ubah format --}}
    <div class="modal fade" id="penomoranModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <form class="modal-content" id="penomoranForm" method="POST">
                @csrf
                <input type="hidden" name="_method" id="penomoranMethod" value="POST">
                <input type="hidden" name="id" id="p_id">
                <div class="modal-header">
                    <h3 class="modal-title" id="penomoranModalTitle">Tambah Format</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body d-grid gap-4">
                    <div class="row g-4">
                        <div class="col-md-7">
                            <label class="form-label required">Nama Format</label>
                            <input type="text" name="nama" id="p_nama" class="form-control" required maxlength="255"
                                placeholder="Contoh: Nomor Surat Keluar DINKES">
                        </div>
                        <div class="col-md-5">
                            <label class="form-label required">Berlaku Untuk</label>
                            <select name="berlaku_untuk" id="p_berlaku_untuk" class="form-select" required>
                                @foreach (\App\Models\SuratPenomoran::BERLAKU_UNTUK as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="form-label required">Format Nomor</label>
                        <input type="text" name="format" id="p_format" class="form-control font-monospace" required maxlength="255">
                        <div class="d-flex flex-wrap gap-2 mt-2">
                            @foreach (\App\Models\SuratPenomoran::TOKENS as $token => $label)
                                <button type="button" class="btn btn-sm btn-light py-1 px-2 token-btn" data-token="{{ $token }}" title="{{ $label }}">
                                    <code>{{ $token }}</code>
                                </button>
                            @endforeach
                        </div>
                        <div class="form-text">Klik token untuk menyisipkan. Teks lain (misalnya <code>DINKES-KAB</code> atau <code>/</code>) ditulis apa adanya.</div>
                        <div class="rounded p-3 mt-3" style="background:#F4FAF7;border:1px solid #E3F1EA">
                            <span class="text-muted fs-7">Contoh hasil:</span>
                            <strong id="p_contoh" class="ms-2 font-monospace">-</strong>
                        </div>
                    </div>

                    <div class="row g-4">
                        <div class="col-md-3">
                            <label class="form-label required">Digit No. Urut</label>
                            <input type="number" min="1" max="10" name="digit" id="p_digit" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label required">Reset Nomor Urut</label>
                            <select name="reset_period" id="p_reset_period" class="form-select" required>
                                @foreach (\App\Models\SuratPenomoran::RESET_PERIOD as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label required">Urutan Nomor</label>
                            <select name="scope" id="p_scope" class="form-select" required>
                                @foreach (\App\Models\SuratPenomoran::SCOPE as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap gap-6">
                        <label class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="editable" value="1" id="p_editable">
                            <span class="form-check-label">Nomor boleh diedit manual</span>
                        </label>
                        <label class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_default" value="1" id="p_is_default">
                            <span class="form-check-label">Jadikan default</span>
                        </label>
                        <label class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="p_is_active">
                            <span class="form-check-label">Aktif</span>
                        </label>
                    </div>

                    <div>
                        <label class="form-label">Keterangan</label>
                        <textarea name="keterangan" id="p_keterangan" class="form-control" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal atur nomor terakhir --}}
    <div class="modal fade" id="counterModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form class="modal-content" id="counterForm" method="POST">
                @csrf
                <div class="modal-header">
                    <h3 class="modal-title">Atur Nomor Terakhir</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body d-grid gap-4">
                    <div class="text-muted fs-7">
                        Format <strong id="c_nama"></strong>. Pakai ini untuk melanjutkan penomoran manual: isi nomor
                        terakhir yang sudah terpakai pada periode berjalan, maka surat berikutnya memakai nomor setelahnya.
                    </div>
                    <div id="c_kode_wrap">
                        <label class="form-label">Kode Surat</label>
                        <input type="text" name="kode" id="c_kode" class="form-control" maxlength="50" placeholder="Contoh: UND">
                        <div class="form-text">Urutan format ini dipisah per kode, jadi isi kode surat yang ingin diatur.</div>
                    </div>
                    <div>
                        <label class="form-label required">Nomor Terakhir</label>
                        <input type="number" min="0" name="last_number" id="c_last_number" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        const penomoranModal = new bootstrap.Modal(document.getElementById('penomoranModal'));
        const counterModal = new bootstrap.Modal(document.getElementById('counterModal'));
        const formatInput = document.getElementById('p_format');
        const digitInput = document.getElementById('p_digit');

        function openPenomoranModal(data) {
            const isEdit = !!data.id;
            const form = document.getElementById('penomoranForm');
            form.action = isEdit ?
                "{{ route('admin.surat-penomoran.update', '__ID__') }}".replace('__ID__', data.id) :
                "{{ route('admin.surat-penomoran.store') }}";
            document.getElementById('penomoranMethod').value = isEdit ? 'PUT' : 'POST';
            document.getElementById('penomoranModalTitle').textContent = isEdit ? 'Ubah Format' : 'Tambah Format';
            document.getElementById('p_id').value = data.id ?? '';
            document.getElementById('p_nama').value = data.nama ?? '';
            document.getElementById('p_berlaku_untuk').value = data.berlaku_untuk ?? 'keluar';
            formatInput.value = data.format ?? '{no}/{kode}/DINKES/{bulan_romawi}/{tahun}';
            digitInput.value = data.digit ?? 3;
            document.getElementById('p_reset_period').value = data.reset_period ?? 'tahunan';
            document.getElementById('p_scope').value = data.scope ?? 'bersama';
            const isNew = data.nama === undefined;
            const bool = v => v === true || v === 1 || v === '1';
            document.getElementById('p_editable').checked = isNew || bool(data.editable);
            document.getElementById('p_is_default').checked = bool(data.is_default);
            document.getElementById('p_is_active').checked = isNew || bool(data.is_active);
            document.getElementById('p_keterangan').value = data.keterangan ?? '';
            refreshContoh();
            penomoranModal.show();
        }

        function openCounterModal(data) {
            document.getElementById('counterForm').action =
                "{{ route('admin.surat-penomoran.counter', '__ID__') }}".replace('__ID__', data.id);
            document.getElementById('c_nama').textContent = data.nama;
            document.getElementById('c_kode_wrap').classList.toggle('d-none', data.scope !== 'per_kode');
            document.getElementById('c_kode').value = '';
            document.getElementById('c_last_number').value = data.last ?? 0;
            counterModal.show();
        }

        let contohTimer;

        function refreshContoh() {
            clearTimeout(contohTimer);
            contohTimer = setTimeout(function() {
                if (!formatInput.value.trim()) {
                    document.getElementById('p_contoh').textContent = '-';
                    return;
                }
                $.get("{{ route('admin.surat-penomoran.preview') }}", {
                    format: formatInput.value,
                    digit: digitInput.value || 3
                }).done(function(res) {
                    document.getElementById('p_contoh').textContent = res.contoh;
                }).fail(function() {
                    document.getElementById('p_contoh').textContent = 'Format tidak valid';
                });
            }, 250);
        }

        formatInput.addEventListener('input', refreshContoh);
        digitInput.addEventListener('input', refreshContoh);

        document.querySelectorAll('.token-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                const token = btn.dataset.token;
                const start = formatInput.selectionStart ?? formatInput.value.length;
                const end = formatInput.selectionEnd ?? formatInput.value.length;
                formatInput.value = formatInput.value.slice(0, start) + token + formatInput.value.slice(end);
                formatInput.focus();
                formatInput.setSelectionRange(start + token.length, start + token.length);
                refreshContoh();
            });
        });

        @if ($errors->any() && old('format') !== null)
            openPenomoranModal(@json(old()));
        @endif
        @if ($errors->any())
            toastr.error(@json($errors->first()), 'Error!');
        @endif
    </script>
@endsection
