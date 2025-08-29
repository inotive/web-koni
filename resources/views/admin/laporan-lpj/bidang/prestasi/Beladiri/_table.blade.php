<div class="row g-10">
    @forelse($children as $child)
        <a href="{{ route('admin.laporan-lpj.bidang.dynamic.child.index', ['parentId' => $child->id]) }}" class="col-12 col-sm-6 col-md-3">
            <div class="card gap-2 p-3 text-center shadow-sm" style="min-height: 160px; transition: background-color 0.3s;"
                onmouseover="this.style.backgroundColor='#E5E7EB'" onmouseout="this.style.backgroundColor='#ffffff'">
                <i class="ki-outline ki-folder text-gray-600" style="font-size: 80px"></i>
                <div class="text-center">
                    <h5 class="d-inline-block text-truncate w-100 mb-0" style="max-width: 200px;" title="{{ $child->nama_program }}">
                        {{ $child->nama_program }}
                    </h5>
                    <p>{{ $child->children_count }} Dokumen</p>
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