
<div class="modal fade" tabindex="-1" id="kt_modal_tambah">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Tambah Data Role</h3>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body">
                <form method="POST" action="<?php echo e(route('admin.hak-akses.role.store')); ?>">
                    <?php echo csrf_field(); ?>
                        <div class="input-group mb-5">
                            <div class="col-xl-12 mb-2">
                                <label for="">Nama Role</label>
                            </div>
                            <div class="col-xl-12">
                                <input type="text" class="form-control" id="inputNamaRole" name="name"
                                    value="<?php echo e(old('name')); ?>" required placeholder="Masukkan Nama Role"
                                    aria-label="Username" aria-describedby="basic-addon1" />
                            </div>
                        </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Kembali</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>


        </div>
    </div>
</div>

<?php /**PATH /home/thur/Documents/Inotive/web-koni/resources/views/admin/roles_permission/component/modal-tambah.blade.php ENDPATH**/ ?>