<?php $__env->startPush('stack-css'); ?>

<?php $__env->stopPush(); ?>
<?php $__env->startSection('pageTitle', 'Manajemen Pengguna'); ?>
<?php $__env->startSection('mainSection', 'Karir'); ?>


<?php $__env->startSection('breadcrumb-title'); ?>
    <h1 class="d-flex flex-column text-dark fw-bold fs-3 mb-0">Halaman Jabatan</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb-items'); ?>
    <li class="breadcrumb-item text-gray-600">Jabatan</li>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="col-12 mt-5">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold fs-3 mb-1">Daftar Jabatan</span>
                </h3>

                <div class="card-toolbar d-flex gap-2">
                    <div class="col-5">
                        <input type="search" name="search" id="search" class="form-control" placeholder="Search">
                    </div>
                        <a href="#" class="btn btn-warning" data-bs-toggle="modal"
                            data-bs-target="#kt_modal_tambah">
                        <i class="ki-duotone ki-plus fs-2"></i>Tambah Jabatan</a>
                    </div>

            </div>
            <div class="card-body col-12">
                <div class="d-flex flex-wrap">
                    <?php $__currentLoopData = $dataPermission; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="gap-2 card-body d-flex flex-column justify-content-between">
                                        <h3 class="m-0 card-title"><?php echo e($value->group); ?></h3>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12 permission-group" data-group="<?php echo e($value->group); ?>">
                                                    <form id="checkboxForm">
                                                        <?php echo csrf_field(); ?>
                                                        <div
                                                            class="mb-2 form-check form-check-custom form-check-solid form-check-sm">
                                                            <input type="hidden" id="roleId" value="<?php echo e($data->id); ?>">
                                                            <input class="select-all form-check-input" type="checkbox"
                                                                value="" id="selectAll<?php echo e($value->group); ?>"
                                                                data-group="<?php echo e($value->group); ?>" />
                                                            <label class="form-check-label" for="selectAll<?php echo e($value->group); ?>">
                                                                Semua Akses
                                                            </label>
                                                        </div>
                                                        <?php
                                                            $names = explode(',', $value->names);
                                                            $displays = explode(',', $value->displays);
                                                            $id = explode(',', $value->id);
                                                        ?>
    
                                                        <?php $__currentLoopData = $names; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <div
                                                                class="mb-2 form-check form-check-custom form-check-solid form-check-sm">
                                                                <input
                                                                    class="form-check-input permission-group permission-checkbox"
                                                                    type="checkbox" name="permissions[]"
                                                                    value="<?php echo e($id[$index]); ?>"
                                                                    data-group="<?php echo e($value->group); ?>" id="<?php echo e($id[$index]); ?>"
                                                                    <?php echo e(in_array($id[$index], $data->permissions->pluck('id')->toArray()) ? 'checked' : null); ?> />
                                                                <label class="form-check-label" for="<?php echo e($id[$index]); ?>">
                                                                    <?php echo e($displays[$index]); ?>

                                                                </label>
                                                            </div>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script>
        $(document).ready(function() {
            $(".select-all").change(function() {
                let group = $(this).data("group");
                let checkboxes = $("[data-group='" + group + "'] .permission-checkbox");
                checkboxes.prop('checked', $(this).prop("checked"));
                updatePermissions();
            });

            $(".permission-checkbox").change(function() {
                let roleId = $('#roleId').val();
                let permissionId = $(this).val();
                let isChecked = $(this).prop('checked');

                if (isChecked) {
                    addSinglePermission(roleId, permissionId);
                } else {
                    removeSinglePermission(roleId, permissionId);
                }
            });

            function updatePermissions() {
                let roleId = $('#roleId').val();
                let permissions = [];
                $(".permission-checkbox:checked").each(function() {
                    permissions.push($(this).val());
                });

                $.ajax({
                    type: "POST",
                    url: "<?php echo e(route('admin.manajemen-pengguna.role.updatePermissions')); ?>",
                    data: {
                        _token: "<?php echo e(csrf_token()); ?>",
                        roleId: roleId,
                        permissions: permissions
                    },
                    success: function(response) {
                        toastr.success(response.message);
                    },
                    error: function(xhr) {
                        toastr.error(xhr.responseJSON.message || "Error updating permissions");
                    }
                });
            }

            function addSinglePermission(roleId, permissionId) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo e(route('admin.manajemen-pengguna.role.updateSinglePermissions')); ?>",
                    data: {
                        _token: "<?php echo e(csrf_token()); ?>",
                        roleId: roleId,
                        permissionId: permissionId
                    },
                    success: function(response) {
                        toastr.success(response.message);
                    },
                    error: function(xhr) {
                        toastr.error(xhr.responseJSON.message || "Error adding permission");
                    }
                });
            }

            function removeSinglePermission(roleId, permissionId) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo e(route('admin.manajemen-pengguna.role.deletePermissions')); ?>",
                    data: {
                        _token: "<?php echo e(csrf_token()); ?>",
                        roleId: roleId,
                        permissionId: permissionId
                    },
                    success: function(response) {
                        toastr.success(response.message);
                    },
                    error: function(xhr) {
                        toastr.error(xhr.responseJSON.message || "Error deleting permission");
                    }
                });
            }
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/thur/Documents/Inotive/web-koni/resources/views/admin/role/setting2.blade.php ENDPATH**/ ?>