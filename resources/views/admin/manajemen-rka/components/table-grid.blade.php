<div class="row g-10">
    <button type="button" data-bs-toggle="modal" data-bs-target="#modal" class="focus-0 border-0 bg-transparent col-12 col-sm-6 col-md-3"
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
                <div class="text-end">
                    <div class="dropdown">
                        <button class="btn btn-sm p-0" type="button" data-bs-toggle="dropdown">
                            <i class="ki-solid ki-dots-vertical text-danger fw-bold" style="font-size: 30px"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li></li>
                        </ul>
                    </div>
                </div>
                <i class="ki-outline ki-folder text-gray-600" style="font-size: 80px"></i>
                <div>
                    <h5>{{ $item->name }}</h5>
                    <p>3 Dokumen</p>
                </div>
            </div>
        </a>
    @empty
        <div class="d-grid justify-content-center">
            <img src="{{ asset('assets/img/question.png') }}" alt="Belum ada RKA" style="height: 230px; width: 200px;">
            <div class="d-grid fw-bold fs-3 text-danger text-center">
                Belum ada RKA ?
                <span class="text-success">Tambah RKA sekarang.</span>
            </div>
        </div>
    @endforelse
</div>
