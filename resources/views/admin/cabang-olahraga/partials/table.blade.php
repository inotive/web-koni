{{-- File: resources/views/admin/cabang-olahraga/partials/table.blade.php --}}
<table class="table table-hover align-middle" id="caborTable">
    <thead>
        <tr>
            <th>No</th>
            {{-- CRITICAL FIX: Ensure buttons don't have href and prevent navigation --}}
            <th>
                <button type="button" 
                        class="btn btn-link text-dark text-decoration-none p-0 ajax-sort sortable-header w-100 text-start" 
                        data-sort="nama_cabor" 
                        title="Sort by Nama Cabor"
                        style="border: none !important; background: none !important;">
                    Nama Cabor {!! sortIcon('nama_cabor') !!}
                </button>
            </th>
            <th>
                <button type="button" 
                        class="btn btn-link text-dark text-decoration-none p-0 ajax-sort sortable-header w-100 text-start" 
                        data-sort="ketua_penanggung_jawab" 
                        title="Sort by Ketua Penanggung Jawab"
                        style="border: none !important; background: none !important;">
                    Ketua Penanggung Jawab {!! sortIcon('ketua_penanggung_jawab') !!}
                </button>
            </th>
            <th>
                <button type="button" 
                        class="btn btn-link text-dark text-decoration-none p-0 ajax-sort sortable-header w-100 text-start" 
                        data-sort="status" 
                        title="Sort by Status"
                        style="border: none !important; background: none !important;">
                    Status {!! sortIcon('status') !!}
                </button>
            </th>
            <th>
                <button type="button" 
                        class="btn btn-link text-dark text-decoration-none p-0 ajax-sort sortable-header w-100 text-start" 
                        data-sort="tanggal_pembentukan" 
                        title="Sort by Tanggal Pembentukan"
                        style="border: none !important; background: none !important;">
                    Tanggal Pembentukan {!! sortIcon('tanggal_pembentukan') !!}
                </button>
            </th>
            <th>Jumlah Atlet</th>
            <th>Jumlah Pelatih</th>
            <th>
                <button type="button" 
                        class="btn btn-link text-dark text-decoration-none p-0 ajax-sort sortable-header w-100 text-start" 
                        data-sort="terakhir_update" 
                        title="Sort by Terakhir Update"
                        style="border: none !important; background: none !important;">
                    Terakhir Update {!! sortIcon('terakhir_update') !!}
                </button>
            </th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @if (isset($cabors))
            @forelse ($cabors as $index => $cabor)
                <tr data-status="{{ $cabor->status }}">
                    <td>{{ $loop->iteration + ($cabors->currentPage() - 1) * $cabors->perPage() }}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            @if ($cabor->icon_cabor)
                                <img src="{{ asset('storage/' . $cabor->icon_cabor) }}" width="40" height="40"
                                    class="rounded object-fit-cover me-3">
                            @else
                                <div class="rounded bg-secondary text-white text-center fw-bold d-flex align-items-center justify-content-center me-3"
                                    style="width: 40px; height: 40px;">
                                    {{ strtoupper(substr($cabor->nama_cabor, 0, 1)) }}
                                </div>
                            @endif
                            <div class="d-flex flex-column">
                                <strong class="text-truncate-custom">{{ $cabor->nama_cabor }}</strong>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="text-truncate-custom" title="{{ $cabor->ketua_penanggung_jawab }}">
                            {{ $cabor->ketua_penanggung_jawab }}
                        </div>
                    </td>
                    <td>
                        <span class="badge {{ $cabor->status == 'Aktif' ? 'badge-light-success' : 'badge-light-danger' }}">
                            {{ $cabor->status }}
                        </span>
                    </td>
                    <td>
                        {{ \Carbon\Carbon::parse($cabor->tanggal_pembentukan)->format('d M Y') }}
                    </td>
                    <td>
                        {{ $cabor->atlets ? $cabor->atlets->count() : 0 }}
                    </td>
                    <td>
                        {{ $cabor->pelatihs ? $cabor->pelatihs->count() : 0 }}
                    </td>
                    <td>
                        {{ $cabor->terakhir_update ? \Carbon\Carbon::parse($cabor->terakhir_update)->format('M d, Y') : '-' }}
                    </td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center gap-1">
                            <a href="{{ route('admin.konfigurasi.cabang-olahraga.show', $cabor->id) }}"
                                class="btn btn-icon btn-sm btn-light-primary" title="Detail">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.konfigurasi.cabang-olahraga.edit', $cabor->id) }}"
                                class="btn btn-icon btn-sm btn-light-warning" title="Edit">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>

                            @php
                                $jumlahAtlet = $cabor->atlets ? $cabor->atlets->count() : 0;
                                $jumlahPelatih = $cabor->pelatihs ? $cabor->pelatihs->count() : 0;
                                $totalData = $jumlahAtlet + $jumlahPelatih;
                            @endphp

                            @if ($totalData > 0)
                                <button type="button" class="btn btn-icon btn-sm btn-light-danger"
                                    title="Tidak dapat dihapus - Ada {{ $totalData }} data terkait"
                                    onclick="showDeleteWarning('{{ $cabor->nama_cabor }}', {{ $jumlahAtlet }}, {{ $jumlahPelatih }})"
                                    style="opacity: 0.6;">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            @else
                                <form action="{{ route('admin.konfigurasi.cabang-olahraga.destroy', $cabor->id) }}"
                                    method="POST" class="d-inline delete-form"
                                    onsubmit="return confirmDelete('{{ $cabor->nama_cabor }}')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-icon btn-sm btn-light-danger" title="Hapus">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center py-5 text-muted">
                        @if (request('search') || request('status'))
                            <i class="fas fa-search fs-3x mb-3 text-muted"></i>
                            <h4>Tidak ada data yang cocok dengan pencarian</h4>
                            <p class="mb-0">Coba ubah kata kunci atau filter yang digunakan</p>
                        @else
                            Tidak ada data cabang olahraga
                        @endif
                    </td>
                </tr>
            @endforelse
        @endif
    </tbody>
</table>

{{-- ENHANCED CSS Styling untuk Table Sorting --}}
<style>
.sortable-header {
    font-weight: 600 !important;
    width: 100% !important;
    text-align: left !important;
    border: none !important;
    background: none !important;
    box-shadow: none !important;
    outline: none !important;
    padding: 0 !important;
    margin: 0 !important;
}

.sortable-header:hover {
    color: #007bff !important;
    text-decoration: none !important;
    background: none !important;
}

.sortable-header:focus {
    box-shadow: none !important;
    outline: none !important;
    background: none !important;
}

.sortable-header:active {
    background: none !important;
    box-shadow: none !important;
}

.sortable-header.processing {
    opacity: 0.6;
    pointer-events: none;
}

/* Prevent Bootstrap button styles from interfering */
.sortable-header.btn-link {
    color: inherit !important;
    text-decoration: none !important;
}

.sortable-header.btn-link:hover {
    color: #007bff !important;
    text-decoration: none !important;
}

/* Loading state untuk table */
.table-responsive {
    position: relative;
}

.loading-overlay {
    position: absolute !important;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(255, 255, 255, 0.9);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
    border-radius: 8px;
    backdrop-filter: blur(2px);
}

/* Ensure table headers are not clickable links */
.sortable-header * {
    pointer-events: none;
}

.sortable-header {
    pointer-events: all;
}

/* Target semua tombol sorting */
.sortable-header {
    display: flex !important;
    justify-content: space-between !important;
    align-items: center !important;
    width: 100% !important;
    text-align: left !important;
    color: inherit !important;
    text-decoration: none !important;
}

.sortable-header i {
    margin-left: auto !important;
    flex-shrink: 0 !important;
}
</style>