@extends('layouts.app')

@section('pageTitle', 'Penyusutan Arsip')
@section('mainSection', 'Manajemen Arsip')
@section('currentSection', 'Penyusutan Arsip')

@include('admin.arsip._assets')

@section('content')
    <div class="mb-6">
        <h1 class="mb-1">Penyusutan Arsip</h1>
        <span class="text-muted">Pantau jadwal retensi, pindahkan arsip ke inaktif, dan proses pemusnahan / penyerahan permanen</span>
    </div>

    <div class="card arsip-card">
        <div class="card-body">
            <ul class="nav arsip-tabs mb-5">
                <li class="nav-item">
                    <a class="nav-link {{ $tab === 'retensi' ? 'active' : '' }}" href="{{ route('admin.arsip.retensi.index', ['tab' => 'retensi']) }}">
                        Habis Masa Retensi <span class="badge badge-light-danger ms-1">{{ $jumlah['retensi'] }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $tab === 'inaktif' ? 'active' : '' }}" href="{{ route('admin.arsip.retensi.index', ['tab' => 'inaktif']) }}">
                        Waktunya Inaktif <span class="badge badge-light-warning ms-1">{{ $jumlah['inaktif'] }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $tab === 'berita-acara' ? 'active' : '' }}" href="{{ route('admin.arsip.retensi.index', ['tab' => 'berita-acara']) }}">
                        Berita Acara
                    </a>
                </li>
            </ul>

            @if ($tab === 'berita-acara')
                <div class="table-responsive">
                    <table class="table table-row-dashed arsip-table">
                        <thead>
                            <tr>
                                <th>Nomor Berita Acara</th>
                                <th>Tanggal</th>
                                <th>Jenis</th>
                                <th class="text-center">Jumlah Arsip</th>
                                <th>Dibuat oleh</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $ba)
                                <tr>
                                    <td class="fw-semibold">{{ $ba->nomor_berita_acara }}</td>
                                    <td>{{ $ba->tanggal->format('d/m/Y') }}</td>
                                    <td>
                                        <span class="badge {{ $ba->jenis === 'musnah' ? 'badge-light-danger' : 'badge-light-primary' }}">
                                            {{ \App\Models\Arsip\ArsipPemusnahan::JENIS[$ba->jenis] }}
                                        </span>
                                    </td>
                                    <td class="text-center">{{ $ba->arsip_count }}</td>
                                    <td>{{ $ba->user?->username ?? '-' }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.arsip.retensi.berita-acara', $ba) }}" target="_blank" class="btn btn-sm btn-light">
                                            <i class="fa-solid fa-file-pdf"></i> PDF
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-10">Belum ada berita acara.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @else
                <form method="POST" id="bulkForm"
                    action="{{ $tab === 'inaktif' ? route('admin.arsip.retensi.inaktifkan') : route('admin.arsip.retensi.proses') }}">
                    @csrf
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
                        <span class="text-muted fs-7">
                            @if ($tab === 'inaktif')
                                Arsip berstatus aktif yang masa retensi aktifnya sudah lewat.
                            @else
                                Arsip yang masa retensi aktif + inaktifnya sudah lewat dan perlu ditindaklanjuti.
                            @endif
                        </span>
                        @if ($tab === 'inaktif')
                            <button type="submit" class="btn btn-sm btn-warning" id="bulkBtn" disabled
                                data-confirm-msg="Pindahkan arsip terpilih ke status inaktif?">
                                <i class="fa-solid fa-box"></i> Jadikan Inaktif (<span class="selCount">0</span>)
                            </button>
                        @else
                            <button type="button" class="btn btn-sm btn-danger" id="bulkBtn" disabled
                                data-bs-toggle="modal" data-bs-target="#prosesModal">
                                <i class="fa-solid fa-file-signature"></i> Buat Berita Acara (<span class="selCount">0</span>)
                            </button>
                        @endif
                    </div>

                    <div class="table-responsive">
                        <table class="table table-row-dashed arsip-table">
                            <thead>
                                <tr>
                                    <th class="w-25px">
                                        <input type="checkbox" class="form-check-input" id="checkAll">
                                    </th>
                                    <th>Nomor</th>
                                    <th>Judul</th>
                                    <th>Klasifikasi</th>
                                    <th>Tanggal Arsip</th>
                                    <th>Jatuh Tempo</th>
                                    @if ($tab === 'retensi')
                                        <th>Tindakan Akhir</th>
                                    @endif
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data as $item)
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="form-check-input row-check" name="ids[]" value="{{ $item->id }}"
                                                @disabled($item->status === 'dipinjam')>
                                        </td>
                                        <td>
                                            @can('arsip-data')
                                                <a href="{{ route('admin.arsip.data.show', $item) }}" class="arsip-kode">{{ $item->nomor_arsip }}</a>
                                            @else
                                                <span class="arsip-kode">{{ $item->nomor_arsip }}</span>
                                            @endcan
                                        </td>
                                        <td>
                                            {{ $item->judul }}
                                            @if ($item->lokasi)
                                                <div class="text-muted fs-8">{{ $item->lokasi->kode_lengkap }}</div>
                                            @endif
                                        </td>
                                        <td>{{ $item->kategori->kode_klasifikasi }}</td>
                                        <td class="text-nowrap">{{ $item->tanggal_arsip->format('d/m/Y') }}</td>
                                        <td class="text-nowrap text-danger">
                                            {{ ($tab === 'inaktif' ? $item->jatuh_tempo_inaktif : $item->jatuh_tempo_retensi)->format('d/m/Y') }}
                                        </td>
                                        @if ($tab === 'retensi')
                                            <td>{{ $item->kategori->tindakan_akhir_label }}</td>
                                        @endif
                                        <td><span class="badge {{ $item->status_badge }}">{{ $item->status_label }}</span></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted py-10">Tidak ada arsip yang jatuh tempo.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $data->links('pagination::bootstrap-5') }}

                    @if ($tab === 'retensi')
                        <div class="modal fade" id="prosesModal" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3 class="modal-title">Buat Berita Acara</h3>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body d-grid gap-4">
                                        <div class="alert alert-light-warning mb-0">
                                            <span class="selCount">0</span> arsip terpilih akan diubah statusnya dan tidak bisa diubah lagi.
                                        </div>
                                        <div>
                                            <label class="form-label required">Jenis</label>
                                            <select name="jenis" class="form-select" required>
                                                @foreach (\App\Models\Arsip\ArsipPemusnahan::JENIS as $value => $label)
                                                    <option value="{{ $value }}">{{ $label }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="row g-4">
                                            <div class="col-7">
                                                <label class="form-label required">Nomor Berita Acara</label>
                                                <input type="text" name="nomor_berita_acara" class="form-control" required value="{{ old('nomor_berita_acara', $nomorBaru) }}">
                                            </div>
                                            <div class="col-5">
                                                <label class="form-label required">Tanggal</label>
                                                <input type="date" name="tanggal" class="form-control" required value="{{ old('tanggal', today()->format('Y-m-d')) }}">
                                            </div>
                                        </div>
                                        <div>
                                            <label class="form-label">Keterangan</label>
                                            <textarea name="keterangan" class="form-control" rows="2" placeholder="mis. Disaksikan oleh ..., metode pencacahan"></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-danger">Proses</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </form>
            @endif
        </div>
    </div>
@endsection

@section('script')
    <script>
        (function() {
            const checks = () => document.querySelectorAll('.row-check:not(:disabled)');
            const bulkBtn = document.getElementById('bulkBtn');
            if (!bulkBtn) return;

            function refresh() {
                const n = document.querySelectorAll('.row-check:checked').length;
                document.querySelectorAll('.selCount').forEach(el => el.textContent = n);
                bulkBtn.disabled = n === 0;
            }

            document.getElementById('checkAll')?.addEventListener('change', function() {
                checks().forEach(c => c.checked = this.checked);
                refresh();
            });
            checks().forEach(c => c.addEventListener('change', refresh));

            // Konfirmasi tombol "Jadikan Inaktif"
            if (bulkBtn.dataset.confirmMsg) {
                document.getElementById('bulkForm').dataset.confirm = bulkBtn.dataset.confirmMsg;
            }
        })();
    </script>
@endsection
