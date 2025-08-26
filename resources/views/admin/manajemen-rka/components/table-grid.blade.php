<div class="row g-10">
    <button type="button" data-bs-toggle="modal" data-bs-target="#add"
        class="focus-0 col-12 col-sm-6 col-md-3 border-0 bg-transparent"
        style="min-height: 160px; outline: none; box-shadow: none;">
        <div class="h-100 card justify-content-center gap-2 p-3 text-center shadow-sm"
            style="transition: background-color 0.3s;" onmouseover="this.style.backgroundColor='#E5E7EB'"
            onmouseout="this.style.backgroundColor='#ffffff'">
            <i class="ki-outline ki-add-folder text-success" style="font-size: 80px"></i>
            <h5>Tambah RKA</h5>
        </div>
    </button>
    @forelse ($data as $item)
        <a href="{{ route('admin.manajemen-rka.show', $item->id) }}" class="col-12 col-sm-6 col-md-3">
            <div class="card gap-2 p-3 text-center shadow-sm" style="transition: background-color 0.3s;"
                onmouseover="this.style.backgroundColor='#E5E7EB'" onmouseout="this.style.backgroundColor='#ffffff'">
                <div class="dropdown text-end">
                    <button class="btn btn-sm p-0" type="button" data-bs-toggle="dropdown">
                        <i class="ki-solid ki-dots-vertical text-danger fw-bold" style="font-size: 30px"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li class="dropdown-item edit" data-bs-toggle="modal" data-bs-target="#edit-{{ $item->id }}"
                            onclick="event.preventDefault(); event.stopPropagation();">
                            Ganti Nama
                        </li>
                        <li class="dropdown-item delete"
                            onclick="event.preventDefault(); event.stopPropagation(); confirmDelete('{{ $item->id }}', '{{ $item->name }}')">
                            Hapus
                        </li>
                        <form id="delete-form-{{ $item->id }}"
                            action="{{ route('admin.manajemen-rka.destroy', $item->id) }}" method="POST"
                            style="display:none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </ul>
                </div>
                <i class="ki-outline ki-folder text-gray-600" style="font-size: 80px"></i>
                <div class="text-center">
                    <h5 class="d-inline-block text-truncate w-100 mb-0" style="max-width: 200px;"
                        title="{{ $item->name }}">
                        {{ $item->name }}
                    </h5>
                    <p>{{ $item->laporans->count() }} Dokumen</p>
                </div>
            </div>
        </a>
        <div class="modal fade" id="edit-{{ $item->id }}" tabindex="-1" aria-labelledby="edit-{{ $item->id }}"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content rounded-4 gap-5 px-10 py-8">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="fs-2 fw-bold leading-5">Edit Folder {{ $item->name }}</div>

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form id="form-{{ $item->id }}" action="{{ route('admin.manajemen-rka.update', $item->id) }}"
                        method="POST" class="d-grid gap-2">
                        @csrf
                        @method('PUT')

                        <div class="fs-4 fw-bold">Judul RKA</div>
                        <textarea id="judul" name="judul" class="form-control border border-gray-600" placeholder="Masukkan judul RKA">{{ $item->name }}</textarea>
                    </form>

                    <div class="d-grid py-4">
                        <button type="button" onclick="submitForm('form-{{ $item->id }}')"
                            class="bg-warning fw-bold d-flex align-items-center justify-content-center gap-2 rounded border-0 p-4 text-white">
                            Edit Nama Folder
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="d-grid justify-content-center">
            <img src="{{ asset('assets/img/question.png') }}" alt="Belum ada RKA" style="height: 230px; width: 200px;">
            <div class="d-grid fw-bold fs-3 text-danger text-center">
                Belum ada RKA ?
                <span class="text-success" style="cursor: pointer;" onmouseover="this.style.textDecoration='underline'"
                    onmouseout="this.style.textDecoration='none'" data-bs-toggle="modal" data-bs-target="#add">
                    Tambah RKA sekarang.
                </span>
            </div>
        </div>
    @endforelse
</div>
