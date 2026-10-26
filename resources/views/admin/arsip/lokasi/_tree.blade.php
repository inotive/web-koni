{{-- Node pohon lokasi (rekursif). Variabel: $tree, $parentId, $selected, $openIds --}}
<ul class="list-unstyled {{ $parentId ? 'ms-5 border-start ps-3' : '' }} mb-0">
    @foreach ($tree->get($parentId, []) as $node)
        @php
            $hasChildren = $tree->has($node->id);
            $isOpen = in_array($node->id, $openIds);
            $isSelected = $selected && $selected->id === $node->id;
        @endphp
        <li class="my-1">
            <div class="d-flex align-items-center gap-2">
                @if ($hasChildren)
                    <a href="#tree-{{ $node->id }}" data-bs-toggle="collapse" class="text-gray-500 w-15px"
                        aria-expanded="{{ $isOpen ? 'true' : 'false' }}">
                        <i class="fa-solid fa-caret-{{ $isOpen ? 'down' : 'right' }} tree-caret"></i>
                    </a>
                @else
                    <span class="w-15px"></span>
                @endif
                <a href="{{ route('admin.arsip.lokasi.index', ['id' => $node->id]) }}"
                    class="d-flex align-items-center gap-2 px-2 py-1 rounded flex-grow-1 {{ $isSelected ? 'bg-light-success text-success fw-bold' : 'text-gray-800 text-hover-primary' }} {{ $node->is_aktif ? '' : 'opacity-50' }}">
                    <i class="fa-solid {{ $node->ikon }} {{ $isSelected ? 'text-success' : 'text-gray-500' }}"></i>
                    <span>{{ $node->nama }}</span>
                    <span class="arsip-kode ms-auto">{{ $node->kode }}</span>
                    @if ($node->jumlah_arsip)
                        <span class="badge badge-light-primary">{{ $node->jumlah_arsip }}</span>
                    @endif
                </a>
            </div>
            @if ($hasChildren)
                <div class="collapse {{ $isOpen ? 'show' : '' }}" id="tree-{{ $node->id }}">
                    @include('admin.arsip.lokasi._tree', ['parentId' => $node->id])
                </div>
            @endif
        </li>
    @endforeach
</ul>
