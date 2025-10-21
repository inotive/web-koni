<?php $__env->startPush('stack-css'); ?>
    <!-- Kalau Ada Plugin Tambahan -->
<?php $__env->stopPush(); ?>


<?php $__env->startSection('breadcrumb-title'); ?>
    <h1 class="d-flex flex-column text-dark fw-bold fs-3 mb-0">Halaman <?php echo e($title); ?></h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb-items'); ?>
<li class="breadcrumb-item text-gray-600"><?php echo e($title); ?></li>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold fs-3 mb-1"><?php echo e($title); ?></span>
                </h3>
            </div>
            <form method="POST" action="<?php echo e(route('admin.profile.profile-update', auth()->user()->id)); ?>" enctype="multipart/form-data">
                <?php echo method_field('PUT'); ?>
                <?php echo csrf_field(); ?>
                <div class="input-group mb-5">
                    <div class="col-xl-12 mb-2 text-center">
                        <!--begin::Image input-->
                        <div class="image-input image-input-circle" data-kt-image-input="true">
                            <!--begin::Image preview wrapper-->
                            <div class="image-input-wrapper w-125px h-125px"
                            style="background-image: url(<?php echo e($data->image != null ? asset('storage/profile/' . $data->image) : asset('assets/media/svg/avatars/blank.svg')); ?> )">
                        </div>
                            <!--end::Image preview wrapper-->

                            <!--begin::Edit button-->
                            <label
                                class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                data-kt-image-input-action="change" data-bs-toggle="tooltip" data-bs-dismiss="click"
                                title="Change avatar">
                                <i class="ki-duotone ki-pencil fs-6"><span class="path1"></span><span
                                        class="path2"></span></i>

                                <!--begin::Inputs-->
                                <input type="file" name="image" value=""/>
                                <!--end::Inputs-->
                            </label>
                            <!--end::Edit button-->

                            <!--begin::Cancel button-->
                            <span
                                class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                data-kt-image-input-action="cancel" data-bs-toggle="tooltip" data-bs-dismiss="click"
                                title="Cancel avatar">
                                <i class="ki-outline ki-cross fs-3"></i>
                            </span>
                            <!--end::Cancel button-->

                            <!--begin::Remove button-->
                            <span
                                class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                data-kt-image-input-action="remove" data-bs-toggle="tooltip" data-bs-dismiss="click"
                                title="Remove avatar">
                                <i class="ki-outline ki-cross fs-3"></i>
                            </span>
                            <!--end::Remove button-->
                        </div>
                        <!--end::Image input-->
                    </div>

                </div>
                <div class="card-body">
                    <div class="input-group mb-5">
                        <div class="col-xl-12 mb-2">
                            <label for="">Username</label>
                        </div>
                        <div class="col-xl-12">
                            <input type="text" class="form-control" id="username" name="username"
                                value="<?php echo e($data->username); ?>" placeholder="Masukkan Username" required
                                aria-label="Username" aria-describedby="basic-addon1" />
                        </div>
                    </div>
                    <div class="input-group mb-5">
                        <div class="col-xl-12 mb-2">
                            <label for="">Email</label>
                        </div>
                        <div class="col-xl-12">
                            <input type="text" class="form-control" id="email" name="email"
                                value="<?php echo e($data->email); ?>" placeholder="Masukkan Email" required
                                aria-label="Username" aria-describedby="basic-addon1" />
                        </div>
                    </div>
                    <div class="input-group mb-5">
                        <div class="col-xl-12 mb-2">
                            <label for="">Nama Lengkap</label>
                        </div>
                        <div class="col-xl-12">
                            <input type="text" class="form-control" name="name" id="inputNama"
                                value="<?php echo e($data->name); ?>" required placeholder="Masukkan Nama Lengkap"
                                aria-label="Username" aria-describedby="basic-addon1" />
                        </div>
                    </div>
                    <div class="input-group mb-5">
                        <div class="col-xl-12 mb-2">
                            <label for="">Password</label>
                        </div>
                        <div class="col-xl-12">
                            <input type="password" class="form-control" name="password" placeholder="Masukkan Password"
                                aria-label="Username" aria-describedby="basic-addon1" value="<?php echo e(!empty($data) ? old('password', null) : old('password')); ?>" />
                                <?php if(!empty($data)): ?>
                                <i>Kosongkan jika anda tidak ingin mengubah password!</i>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="input-group mb-5">
                        <div class="col-xl-12 mb-2">
                            <label for="">Role</label>
                        </div>
                        <div class="col-xl-12">
                            <input type="text" class="form-control" name="role" value="<?php echo e($data->role_select->name); ?>" readonly>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <div class="row gx-4">
                        <div class="col-6">
                            <button class="btn btn-primary submit-btn w-100" type="submit">Simpan</button>
                        </div>
                        <div class="col-6">
                            <a href="<?php echo e(route('admin.dashboard')); ?>"
                                class="w-100 btn btn-outline btn-outline-secondary btn-active-light-secondary text-dark">Kembali</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
   
</div>
   
<?php $__env->stopSection(); ?>


<?php $__env->startPush('stack-script'); ?>
   
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/thur/Documents/Inotive/web-koni/resources/views/admin/profile/index.blade.php ENDPATH**/ ?>