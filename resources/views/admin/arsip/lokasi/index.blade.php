@extends('layouts.app')

@section('pageTitle', 'Lokasi Arsip')
@section('mainSection', 'Manajemen Arsip')
@section('currentSection', 'Lokasi Arsip')

@include('admin.arsip._assets')

@php
    $openIds = $selected ? collect($selected->ancestors())->pluck('id')->all() : [];
    $tipeUrutan = array_keys(\App\Models\Arsip\ArsipLokasi::TIPE);
    $tipeAnakDefault = $selected ? ($tipeUrutan[array_search($selected->tipe, $tipeUrutan) + 1] ?? null) : 'gedung';
@endphp

@section('content')
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-6 gap-3">
        <div>
            <h1 class="mb-1">Lokasi Arsip</h1>
            <span class="text-muted">Kelola struktur penyimpanan fisik: Gedung › Ruang › Rak › Baris › Box</span>
        </div>
        <button class="btn btn-primary" onclick="openLokasiModal({ parent_id: '', tipe: 'gedung' })">
            <i class="fa-solid fa-plus"></i> Tambah Gedung
        </button>
    </div>

    <div class="row g-6">
        <div class="col-lg-5">
            <div class="card arsip-card">
                <div class="card-body">
                    <input type="text" class="form-control form-control-sm mb-4" id="treeFilter"
                        placeholder="Cari nama / kode lokasi...">
                    @if ($tree->isEmpty())
                        <div class="text-center text-muted py-10">
                            <i class="fa-solid fa-warehouse fs-2x mb-3 d-block"></i>
                            Belum ada lokasi. Mulai dengan menambahkan gedung.
                        </div>
                    @else
                        <div id="lokasiTree">
                            @include('admin.arsip.lokasi._tree', ['parentId' => 0])
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            @if (!$selected)
                <div class="card arsip-card">
                    <div class="card-body text-center text-muted py-20">
                        <i class="fa-solid fa-hand-pointer fs-2x mb-3 d-block"></i>
                        Pilih lokasi di sebelah kiri untuk melihat detail dan isinya.
                    </div>
                </div>
            @else
                <div class="card arsip-card mb-6">
                    <div class="card-body">
                        <div class="text-muted fs-7 mb-2">{{ $selected->parent?->path }}</div>
                        <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">
                            <div>
                                <h2 class="mb-1">
                                    <i class="fa-solid {{ $selected->ikon }} text-success me-2"></i>{{ $selected->nama }}
                                </h2>
                                <span class="badge badge-light">{{ $selected->tipe_label }}</span>
                                <span class="arsip-kode ms-1">{{ $selected->kode_lengkap }}</span>
                                @unless ($selected->is_aktif)
                                    <span class="badge badge-light-danger ms-1">Nonaktif</span>
                                @endunless
                            </div>
                            <div class="d-flex flex-wrap gap-2">
                                @if ($tipeAnakDefault)
                                    <button class="btn btn-sm btn-light-primary"
                                        onclick="openLokasiModal({ parent_id: {{ $selected->id }}, tipe: '{{ $tipeAnakDefault }}' })">
                                        <i class="fa-solid fa-plus"></i> Sub-lokasi
                                    </button>
                                @endif
                                <button class="btn btn-sm btn-light" onclick="openLokasiModal({{ json_encode($selected->only(['id', 'parent_id', 'tipe', 'kode', 'nama', 'kapasitas', 'keterangan', 'is_aktif'])) }})">
                                    <i class="fa-solid fa-pen"></i> Ubah
                                </button>
                                <div class="btn-group">
                                    <a class="btn btn-sm btn-light" target="_blank"
                                        href="{{ route('admin.arsip.lokasi.label', $selected) }}">
                                        <i class="fa-solid fa-qrcode"></i> Label
                                    </a>
                                    @if ($selected->tipe !== 'box')
                                        <a class="btn btn-sm btn-light" target="_blank" title="Cetak label semua box di dalamnya"
                                            href="{{ route('admin.arsip.lokasi.label', [$selected, 'semua_box' => 1]) }}">
                                            Semua Box
                                        </a>
                                    @endif
                                </div>
                                <form action="{{ route('admin.arsip.lokasi.destroy', $selected) }}" method="POST"
                                    data-confirm="Hapus lokasi {{ $selected->nama }}?">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-light-danger"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </div>
                        </div>

                        <div class="row mt-6 g-4">
                            <div class="col-sm-4">
                                <div class="text-muted fs-7">Sub-lokasi</div>
                                <div class="fs-3 fw-bold">{{ $selected->children->count() }}</div>
                            </div>
                            <div class="col-sm-4">
                                <div class="text-muted fs-7">Arsip tersimpan langsung</div>
                                <div class="fs-3 fw-bold">{{ $arsip->count() }}</div>
                            </div>
                            <div class="col-sm-4">
                                <div class="text-muted fs-7">Kapasitas</div>
                                @if ($selected->kapasitas)
                                    @php $persen = min(100, round($arsip->count() / $selected->kapasitas * 100)); @endphp
                                    <div class="fs-3 fw-bold">{{ $arsip->count() }} / {{ $selected->kapasitas }}</div>
                                    <div class="progress h-6px mt-1">
                                        <div class="progress-bar {{ $persen >= 90 ? 'bg-danger' : ($persen >= 70 ? 'bg-warning' : 'bg-success') }}"
                                            style="width: {{ $persen }}%"></div>
                                    </div>
                                @else
                                    <div class="fs-3 fw-bold">-</div>
                                @endif
                            </div>
                        </div>
                        @if ($selected->keterangan)
                            <div class="mt-4 text-gray-700">{{ $selected->keterangan }}</div>
                        @endif
                    </div>
                </div>

                @if ($selected->children->isNotEmpty())
                    <div class="card arsip-card mb-6">
                        <div class="card-header border-0 pt-5">
                            <h3 class="card-title fw-bold">Sub-lokasi</h3>
                        </div>
                        <div class="card-body pt-0">
                            <div class="row g-3">
                                @foreach ($selected->children as $child)
                                    <div class="col-sm-6 col-xl-4">
                                        <a href="{{ route('admin.arsip.lokasi.index', ['id' => $child->id]) }}"
                                            class="d-block border border-dashed rounded p-3 text-gray-800 text-hover-primary">
                                            <i class="fa-solid {{ $child->ikon }} text-gray-500 me-1"></i>
                                            <span class="fw-semibold">{{ $child->nama }}</span>
                                            <div class="arsip-kode d-inline-block mt-1">{{ $child->kode }}</div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <div class="card arsip-card">
                    <div class="card-header border-0 pt-5">
                        <h3 class="card-title fw-bold">Arsip di lokasi ini</h3>
                        <div class="card-toolbar gap-2">
                            @can('arsip-data')
                                <a href="{{ route('admin.arsip.data.index', ['lokasi' => $selected->id]) }}"
                                    class="btn btn-sm btn-light">Termasuk sub-lokasi</a>
                                <a href="{{ route('admin.arsip.data.create', ['lokasi' => $selected->id]) }}"
                                    class="btn btn-sm btn-light-primary"><i class="fa-solid fa-plus"></i> Arsip</a>
                            @endcan
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        @if ($arsip->isEmpty())
                            <div class="text-muted text-center py-6">Belum ada arsip yang disimpan langsung di lokasi ini.</div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-row-dashed arsip-table">
                                    <thead>
                                        <tr>
                                            <th>Nomor</th>
                                            <th>Judul</th>
                                            <th>Klasifikasi</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($arsip as $item)
                                            <tr>
                                                <td>
                                                    @can('arsip-data')
                                                        <a href="{{ route('admin.arsip.data.show', $item) }}" class="arsip-kode">{{ $item->nomor_arsip }}</a>
                                                    @else
                                                        <span class="arsip-kode">{{ $item->nomor_arsip }}</span>
                                                    @endcan
                                                </td>
                                                <td>{{ $item->judul }}</td>
                                                <td>{{ $item->kategori?->kode_klasifikasi }}</td>
                                                <td><span class="badge {{ $item->status_badge }}">{{ $item->status_label }}</span></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="modal fade" id="lokasiModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form class="modal-content" id="lokasiForm" method="POST" action="{{ route('admin.arsip.lokasi.store') }}">
                @csrf
                <input type="hidden" name="_method" value="POST" id="lokasiMethod">
                <input type="hidden" name="id" id="f_id">
                <div class="modal-header">
                    <h3 class="modal-title" id="lokasiModalTitle">Tambah Lokasi</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body d-grid gap-4">
                    <div>
                        <label class="form-label">Lokasi Induk</label>
                        <select name="parent_id" id="f_parent_id" class="form-select">
                            <option value="">— Tidak ada (level teratas) —</option>
                            @foreach ($lokasiOptions as $opt)
                                <option value="{{ $opt['id'] }}">{{ $opt['label'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row g-4">
                        <div class="col-6">
                            <label class="form-label required">Tipe</label>
                            <select name="tipe" id="f_tipe" class="form-select" required>
                                @foreach (\App\Models\Arsip\ArsipLokasi::TIPE as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label required">Kode</label>
                            <input type="text" name="kode" id="f_kode" class="form-control" maxlength="50" required
                                placeholder="mis. R1, A, BX01">
                        </div>
                    </div>
                    <div>
                        <label class="form-label required">Nama</label>
                        <input type="text" name="nama" id="f_nama" class="form-control" required>
                    </div>
                    <div>
                        <label class="form-label">Kapasitas (jumlah arsip)</label>
                        <input type="number" min="1" name="kapasitas" id="f_kapasitas" class="form-control"
                            placeholder="Kosongkan jika tidak dibatasi">
                    </div>
                    <div>
                        <label class="form-label">Keterangan</label>
                        <textarea name="keterangan" id="f_keterangan" class="form-control" rows="2"></textarea>
                    </div>
                    <div class="form-check form-switch">
                        <input type="hidden" name="is_aktif" value="0">
                        <input class="form-check-input" type="checkbox" name="is_aktif" value="1" id="f_is_aktif" checked>
                        <label class="form-check-label" for="f_is_aktif">Aktif (bisa dipilih sebagai lokasi arsip)</label>
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
        const lokasiModal = new bootstrap.Modal(document.getElementById('lokasiModal'));
        const updateUrl = "{{ route('admin.arsip.lokasi.update', '__ID__') }}";

        function openLokasiModal(data) {
            const isEdit = !!data.id;
            const form = document.getElementById('lokasiForm');
            form.action = isEdit ? updateUrl.replace('__ID__', data.id) : "{{ route('admin.arsip.lokasi.store') }}";
            document.getElementById('lokasiMethod').value = isEdit ? 'PUT' : 'POST';
            document.getElementById('lokasiModalTitle').textContent = isEdit ? 'Ubah Lokasi' : 'Tambah Lokasi';

            document.getElementById('f_id').value = data.id ?? '';
            document.getElementById('f_parent_id').value = data.parent_id ?? '';
            document.getElementById('f_tipe').value = data.tipe ?? 'gedung';
            document.getElementById('f_kode').value = data.kode ?? '';
            document.getElementById('f_nama').value = data.nama ?? '';
            document.getElementById('f_kapasitas').value = data.kapasitas ?? '';
            document.getElementById('f_keterangan').value = data.keterangan ?? '';
            document.getElementById('f_is_aktif').checked = ![false, 0, '0'].includes(data.is_aktif);

            // Saat mengubah, lokasi itu sendiri & turunannya tidak boleh jadi induk
            document.querySelectorAll('#f_parent_id option').forEach(o => o.hidden = false);
            if (isEdit) {
                @if ($selected)
                    const excluded = @json($selected->descendantIds());
                    document.querySelectorAll('#f_parent_id option').forEach(o => {
                        if (excluded.includes(parseInt(o.value))) o.hidden = true;
                    });
                @endif
            }
            lokasiModal.show();
        }

        // Filter pohon lokasi
        document.getElementById('treeFilter')?.addEventListener('input', function() {
            const q = this.value.toLowerCase().trim();
            document.querySelectorAll('#lokasiTree li').forEach(li => {
                li.style.display = !q || li.textContent.toLowerCase().includes(q) ? '' : 'none';
            });
            if (q) document.querySelectorAll('#lokasiTree .collapse').forEach(c => c.classList.add('show'));
        });

        // Ikon caret mengikuti status collapse
        document.querySelectorAll('#lokasiTree .collapse').forEach(el => {
            el.addEventListener('show.bs.collapse', e => {
                e.stopPropagation();
                document.querySelector(`[href="#${el.id}"] .tree-caret`)?.classList.replace('fa-caret-right', 'fa-caret-down');
            });
            el.addEventListener('hide.bs.collapse', e => {
                e.stopPropagation();
                document.querySelector(`[href="#${el.id}"] .tree-caret`)?.classList.replace('fa-caret-down', 'fa-caret-right');
            });
        });

        @if ($errors->any())
            openLokasiModal(@json(old()));
        @endif
    </script>
@endsection
