@extends('layouts.app')

@section('pageTitle', 'Klasifikasi Arsip')
@section('mainSection', 'Manajemen Arsip')
@section('currentSection', 'Klasifikasi & Retensi')

@include('admin.arsip._assets')

@section('content')
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-6 gap-3">
        <div>
            <h1 class="mb-1">Klasifikasi & Jadwal Retensi</h1>
            <span class="text-muted">Kode klasifikasi arsip beserta masa simpan aktif, inaktif, dan tindakan akhirnya</span>
        </div>
        <button class="btn btn-primary" onclick="openKategoriModal({})">
            <i class="fa-solid fa-plus"></i> Tambah Klasifikasi
        </button>
    </div>

    <div class="card arsip-card">
        <div class="card-body">
            <form method="GET" class="mb-5" style="max-width: 320px">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm"
                    placeholder="Cari kode / nama, tekan Enter...">
            </form>

            <div class="table-responsive">
                <table class="table table-row-dashed arsip-table">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Nama Klasifikasi</th>
                            <th class="text-center">Retensi Aktif</th>
                            <th class="text-center">Retensi Inaktif</th>
                            <th>Tindakan Akhir</th>
                            <th class="text-center">Jumlah Arsip</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($kategori as $item)
                            <tr>
                                <td><span class="arsip-kode">{{ $item->kode_klasifikasi }}</span></td>
                                <td>
                                    <div class="fw-semibold">{{ $item->nama }}</div>
                                    @if ($item->keterangan)
                                        <div class="text-muted fs-7">{{ $item->keterangan }}</div>
                                    @endif
                                </td>
                                <td class="text-center">{{ $item->retensi_aktif_tahun }} thn</td>
                                <td class="text-center">{{ $item->retensi_inaktif_tahun }} thn</td>
                                <td>
                                    <span class="badge {{ ['musnah' => 'badge-light-danger', 'permanen' => 'badge-light-primary', 'dinilai_kembali' => 'badge-light-warning'][$item->tindakan_akhir] }}">
                                        {{ $item->tindakan_akhir_label }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    @can('arsip-data')
                                        <a href="{{ route('admin.arsip.data.index', ['kategori' => $item->id]) }}">{{ $item->arsip_count }}</a>
                                    @else
                                        {{ $item->arsip_count }}
                                    @endcan
                                </td>
                                <td class="text-end text-nowrap">
                                    <button class="btn btn-sm btn-icon btn-light" title="Ubah"
                                        onclick="openKategoriModal({{ json_encode($item->only(['id', 'kode_klasifikasi', 'nama', 'retensi_aktif_tahun', 'retensi_inaktif_tahun', 'tindakan_akhir', 'keterangan'])) }})">
                                        <i class="fa-solid fa-pen"></i>
                                    </button>
                                    <form action="{{ route('admin.arsip.kategori.destroy', $item) }}" method="POST" class="d-inline"
                                        data-confirm="Hapus klasifikasi {{ $item->kode_klasifikasi }} - {{ $item->nama }}?">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-icon btn-light-danger" title="Hapus"><i class="fa-solid fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-10">Belum ada klasifikasi arsip.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $kategori->links('pagination::bootstrap-5') }}
        </div>
    </div>

    <div class="modal fade" id="kategoriModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form class="modal-content" id="kategoriForm" method="POST">
                @csrf
                <input type="hidden" name="_method" id="kategoriMethod" value="POST">
                <input type="hidden" name="id" id="k_id">
                <div class="modal-header">
                    <h3 class="modal-title" id="kategoriModalTitle">Tambah Klasifikasi</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body d-grid gap-4">
                    <div class="row g-4">
                        <div class="col-4">
                            <label class="form-label required">Kode</label>
                            <input type="text" name="kode_klasifikasi" id="k_kode_klasifikasi" class="form-control" required maxlength="50">
                        </div>
                        <div class="col-8">
                            <label class="form-label required">Nama</label>
                            <input type="text" name="nama" id="k_nama" class="form-control" required>
                        </div>
                    </div>
                    <div class="row g-4">
                        <div class="col-6">
                            <label class="form-label required">Retensi Aktif (tahun)</label>
                            <input type="number" min="0" max="100" name="retensi_aktif_tahun" id="k_retensi_aktif_tahun" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label required">Retensi Inaktif (tahun)</label>
                            <input type="number" min="0" max="100" name="retensi_inaktif_tahun" id="k_retensi_inaktif_tahun" class="form-control" required>
                        </div>
                    </div>
                    <div>
                        <label class="form-label required">Tindakan Akhir</label>
                        <select name="tindakan_akhir" id="k_tindakan_akhir" class="form-select" required>
                            @foreach (\App\Models\Arsip\ArsipKategori::TINDAKAN_AKHIR as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Keterangan</label>
                        <textarea name="keterangan" id="k_keterangan" class="form-control" rows="2"></textarea>
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
        const kategoriModal = new bootstrap.Modal(document.getElementById('kategoriModal'));

        function openKategoriModal(data) {
            const isEdit = !!data.id;
            const form = document.getElementById('kategoriForm');
            form.action = isEdit ?
                "{{ route('admin.arsip.kategori.update', '__ID__') }}".replace('__ID__', data.id) :
                "{{ route('admin.arsip.kategori.store') }}";
            document.getElementById('kategoriMethod').value = isEdit ? 'PUT' : 'POST';
            document.getElementById('kategoriModalTitle').textContent = isEdit ? 'Ubah Klasifikasi' : 'Tambah Klasifikasi';
            document.getElementById('k_id').value = data.id ?? '';
            document.getElementById('k_kode_klasifikasi').value = data.kode_klasifikasi ?? '';
            document.getElementById('k_nama').value = data.nama ?? '';
            document.getElementById('k_retensi_aktif_tahun').value = data.retensi_aktif_tahun ?? 1;
            document.getElementById('k_retensi_inaktif_tahun').value = data.retensi_inaktif_tahun ?? 1;
            document.getElementById('k_tindakan_akhir').value = data.tindakan_akhir ?? 'musnah';
            document.getElementById('k_keterangan').value = data.keterangan ?? '';
            kategoriModal.show();
        }

        @if ($errors->any())
            openKategoriModal(@json(old()));
        @endif
    </script>
@endsection
