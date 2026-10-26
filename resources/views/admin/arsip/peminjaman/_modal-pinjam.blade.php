{{-- Modal pencatatan peminjaman. Variabel: $arsipTerpilih (Arsip) atau $arsipTersedia (koleksi) --}}
<div class="modal fade" id="pinjamModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content" method="POST" action="{{ route('admin.arsip.peminjaman.store') }}">
            @csrf
            <div class="modal-header">
                <h3 class="modal-title">Catat Peminjaman Arsip</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body d-grid gap-4">
                <div>
                    <label class="form-label required">Arsip</label>
                    @isset($arsipTerpilih)
                        <input type="hidden" name="arsip_id" value="{{ $arsipTerpilih->id }}">
                        <div class="form-control bg-light">{{ $arsipTerpilih->nomor_arsip }} - {{ $arsipTerpilih->judul }}</div>
                    @else
                        <select name="arsip_id" class="form-select" data-control="select2" data-dropdown-parent="#pinjamModal" required>
                            <option value="">— Pilih arsip —</option>
                            @foreach ($arsipTersedia as $a)
                                <option value="{{ $a->id }}" @selected(old('arsip_id') == $a->id)>{{ $a->nomor_arsip }} - {{ $a->judul }}</option>
                            @endforeach
                        </select>
                    @endisset
                </div>
                <div class="row g-4">
                    <div class="col-6">
                        <label class="form-label required">Nama Peminjam</label>
                        <input type="text" name="nama_peminjam" class="form-control" required value="{{ old('nama_peminjam') }}">
                    </div>
                    <div class="col-6">
                        <label class="form-label">Unit / Bidang</label>
                        <input type="text" name="unit_peminjam" class="form-control" value="{{ old('unit_peminjam') }}">
                    </div>
                </div>
                <div class="row g-4">
                    <div class="col-6">
                        <label class="form-label required">Tanggal Pinjam</label>
                        <input type="date" name="tanggal_pinjam" class="form-control" required
                            value="{{ old('tanggal_pinjam', today()->format('Y-m-d')) }}">
                    </div>
                    <div class="col-6">
                        <label class="form-label required">Rencana Kembali</label>
                        <input type="date" name="tanggal_rencana_kembali" class="form-control" required
                            value="{{ old('tanggal_rencana_kembali', today()->addDays(7)->format('Y-m-d')) }}">
                    </div>
                </div>
                <div>
                    <label class="form-label">Catatan / Keperluan</label>
                    <textarea name="catatan" class="form-control" rows="2">{{ old('catatan') }}</textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
