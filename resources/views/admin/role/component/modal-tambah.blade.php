{{-- modal --}}
<div class="modal fade" tabindex="-1" id="kt_modal_tambah">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Tambah Data Jabatan</h3>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body">
                <form method="POST" action="{{ route('admin.manajemen-pengguna.role.store') }}">
                    @csrf
                        <div class="input-group mb-5">
                            <div class="col-xl-12 mb-2">
                                <label for="">Nama Jabatan</label>
                            </div>
                            <div class="col-xl-12">
                                <input type="text" class="form-control" id="inputNamaRole" name="name"
                                    value="{{ old('name') }}" required placeholder="Masukkan Nama Jabatan"
                                    aria-label="Username" aria-describedby="basic-addon1" />
                            </div>
                        </div>
                    <div class="modal-footer">
                        {{-- <button type="button" class="btn btn-light" data-bs-dismiss="modal">Kembali</button> --}}
                        <div class="col-12">
                            <button type="submit" class="btn w-100 d-flex align-items-center justify-content-center" style="background-color: #F8285A; color: white; border-radius: 8px; padding: 12px 0;">
                                <!-- icon disini -->
                                Simpan Jabatan
                            </button>
                        </div>
                    </div>
                </form>
            </div>


        </div>
    </div>
</div>
{{-- end modal --}}
