<div class="row g-10">
    @forelse($children as $child)
        <a href="{{ route('admin.laporan-lpj.bidang.dynamic.child.index', ['parentId' => $child->id]) }}" class="col-12 col-sm-6 col-md-3">
            <div class="card gap-2 p-3 text-center shadow-sm" style="min-height: 220px; transition: background-color 0.3s;"
                onmouseover="this.style.backgroundColor='#E5E7EB'" onmouseout="this.style.backgroundColor='#ffffff'">
                <i class="ki-outline ki-folder text-gray-600" style="font-size: 80px"></i>
                <div class="text-center">
                    <h5 class="d-inline-block text-truncate w-100 mb-0" style="max-width: 200px;" title="{{ $child->nama_program }}">
                        {{ $child->nama_program }}
                    </h5>
                    <p>{{ $child->children_count }} Dokumen</p>

                    @php
                        $anggaran = $child->realisasi_anggaran;
                        $kegiatan = $child->children_count ?? 0;
                        $target_anggaran = $child->target_anggaran_value;
                        $target_kegiatan = $child->target_kegiatan_value;
                        $percentage = $target_anggaran > 0 ? ($anggaran / $target_anggaran) * 100 : 0;
                    @endphp

                    <div class="mt-2">
                        <div class="d-flex justify-content-between mb-1">
                            <small class="fw-bold mb-1">Rp. {{ number_format($anggaran, 0, ',', '.') }} / Rp. {{ number_format($target_anggaran, 0, ',', '.') }}</small>
                        </div>
                        <div class="progress" style="height: 8px; border-radius: 4px;">
                            <div class="progress-bar"
                                role="progressbar"
                                style="width: {{ $percentage }}%; background-color: #F8285A;"
                                aria-valuenow="{{ $percentage }}"
                                aria-valuemin="0"
                                aria-valuemax="100">
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-1">
                            <div class="'d-flex justify-content-start mt-1">
                                <small class="fw-bold bg-success-subtle text-success border border-success-subtle py-1 rounded px-1">{{ $kegiatan }} Kegiatan</small><small class="fw-bold text-muted"> / </small><small class="fw-bold bg-primary-subtle text-primary border border-primary-subtle py-1 rounded px-1">{{ $target_kegiatan}} Target</small>
                            </div>
                            <small class="text-muted">{{ round($percentage) }}%</small>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    @empty
        <div class="col-12">
            <div class="text-center text-muted py-10">
                <i class="ki-duotone ki-information-5 fs-3x mb-3"></i>
                <h4>Tidak ada data.</h4>
            </div>
        </div>
    @endforelse
</div>
