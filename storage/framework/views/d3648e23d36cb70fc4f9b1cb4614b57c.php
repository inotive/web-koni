<!-- Modal Edit Pengguna -->
<div class="modal fade" id="modalEditPengguna<?php echo e($value->id); ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Edit Data Pengguna</h3>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-1"></i>
                </div>
            </div>

            <div class="modal-body">
                <form method="POST" action="<?php echo e(route('admin.manajemen-pengguna.pengguna.update', $value->id)); ?>"
                    enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    <div class="mb-5">
                        <label for="username<?php echo e($value->id); ?>" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="username<?php echo e($value->id); ?>" name="username"
                            value="<?php echo e(old('username', $value->username)); ?>" required>
                    </div>

                    <div class="mb-5">
                        <label for="role<?php echo e($value->id); ?>" class="form-label">Jabatan</label>
                        <select class="form-select" name="role" id="role<?php echo e($value->id); ?>" data-control="select2"
                            required>
                            <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($item->name); ?>"
                                    <?php echo e($value->getRoleNames()->first() == $item->name ? 'selected' : ''); ?>>
                                    <?php echo e($item->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="mb-5">
                        <label for="email<?php echo e($value->id); ?>" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" id="email<?php echo e($value->id); ?>"
                            value="<?php echo e(old('email', $value->email)); ?>" required>
                    </div>

                    <div class="mb-5">
                        <label for="password<?php echo e($value->id); ?>" class="form-label">Kata Sandi (Opsional)</label>
                        <div class="input-group">
                            <input type="password" class="form-control" name="password"
                                id="passwordInput<?php echo e($value->id); ?>" placeholder="Kosongkan jika tidak diubah">
                            <span class="input-group-text toggle-password" data-id="<?php echo e($value->id); ?>"
                                style="cursor: pointer;">
                                <i class="fa-solid fa-eye" id="toggleIcon<?php echo e($value->id); ?>"></i>
                            </span>
                        </div>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn w-100"
                            style="background-color: #D20A11; color: white; border-radius: 8px;">
                            <i class="ki-duotone ki-pencil fs-2" style="color: white"></i>Update Pengguna
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->startPush('stack-script'); ?>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".toggle-password").forEach(btn => {
                btn.addEventListener("click", function() {
                    const id = this.dataset.id;
                    const input = document.getElementById(`passwordInput${id}`);
                    const icon = document.getElementById(`toggleIcon${id}`);
                    const type = input.getAttribute("type") === "password" ? "text" : "password";
                    input.setAttribute("type", type);
                    icon.classList.toggle("fa-eye");
                    icon.classList.toggle("fa-eye-slash");
                });
            });
        });
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\Users\Javier\Documents\GitHub\web-koni\resources\views/admin/user/component/modal.blade.php ENDPATH**/ ?>