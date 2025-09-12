<?php $__env->startPush('stack-css'); ?>
    <style>
        .desc {
            color: #4B5675;
            font-size: 13px;
        }
    </style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('pageTitle', 'Manajemen Pengguna'); ?>
<?php $__env->startSection('mainSection', 'Manajemen Pengguna'); ?>
<?php $__env->startSection('subSection'); ?>
    <a href="<?php echo e(route('admin.manajemen-pengguna.role.index')); ?>" class="text-muted muted-hover">Jabatan & Hak Akses</a>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('currentSection', 'Kelola Hak Akses'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold fs-3 mb-1">Kelola Hak Akses</span>
                    <span class="text-capitalize fs-6 text-muted"><?php echo e($role->name); ?></span>
                </h3>
            </div>
            <div class="card-body">
                <div class="d-flex flex-wrap">
                    <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $hasPermission = $role->permissions->contains('id', $permission->id);
                        ?>
                        <div class="col-4 mb-5"> <!-- Responsive columns -->
                            <div class="p-3"> <!-- Remove fixed width/height -->
                                <h6 class="fw-medium mb-5"><?php echo e($permission->display_name); ?></h6>
                                <?php if($permission->name === 'dashboard'): ?>
                                    <p class="mb-3 desc">Memberikan hak akses untuk Melihat seluruh data agregat di
                                        dashboard sistem secara real-time.</p>
                                <?php elseif($permission->name === 'manajemen-rka'): ?>
                                    <p class="mb-3 desc">Memiliki wewenang penuh (Create, Read, Update, Delete) atas data
                                        Rencana Kerja dan Anggaran.</p>
                                <?php elseif($permission->name === 'laporan-lpj-sekretariat'): ?>
                                    <p class="mb-3 desc">Memberikan hak akses untuk mengelola laporan LPJ bagian kesekretariatan.</p>
                                <?php elseif($permission->name === 'laporan-lpj-bidang'): ?>
                                    <p class="mb-3 desc">Memberikan hak akses untuk mengelola laporan LPJ bagian bidang-bidang.</p>
                                <?php elseif($permission->name === 'laporan-lpj-kegiatan-lainnya'): ?>
                                    <p class="mb-3 desc">Memberikan hak akses untuk mengelola laporan LPJ bagian kegiatan lainnya.</p>
                                <?php elseif($permission->name === 'pengajuan-modifikasi-laporan'): ?>
                                    <p class="mb-3 desc">Memberikan wewenang untuk menerima atau tidak menerima pengajuan modifikasi laporan pertanggung jawaban.</p>
                                <?php elseif($permission->name === 'database-bendahara'): ?>
                                    <p class="mb-3 desc">Mengelola seluruh data master yang berkaitan dengan keuangan dan
                                        perbendaharaan KONI.</p>
                                <?php elseif($permission->name === 'file-kesekretariatan'): ?>
                                    <p class="mb-3 desc">Admin dapat mengelola struktur folder, mengatur kuota penyimpanan,
                                        dan melakukan backup data penting.</p>
                                <?php elseif($permission->name === 'surat-masuk-keluar'): ?>
                                    <p class="mb-3 desc">Dapat mengakses dan mengelola seluruh data surat-menyurat sebagai
                                        bagian dari tugas pemeliharaan.</p>
                                <?php elseif($permission->name === 'pelatih'): ?>
                                    <p class="mb-3 desc">Menguasai data master pelatih, termasuk menambah, mengubah, dan
                                        menghapus data secara penuh.</p>
                                <?php elseif($permission->name === 'atlet'): ?>
                                    <p class="mb-3 desc">Memiliki wewenang penuh untuk mengelola data master atlet di
                                        seluruh cabang olahraga.</p>
                                <?php elseif($permission->name === 'pengguna'): ?>
                                    <p class="mb-3 desc">Menu ini adalah pusat kontrol keamanan sistem, tempat Admin membuat
                                        akun pengguna baru, mengatur ulang kata sandi.</p>
                                <?php elseif($permission->name === 'jabatan'): ?>
                                    <p class="mb-3 desc">Keamanan dan struktur sistem, memastikan setiap pengguna hanya bisa
                                        mengakses informasi sesuai jabatannya.</p>
                                <?php elseif($permission->name === 'tahun-anggaran'): ?>
                                    <p class="mb-3 desc">Mengelola daftar Tahun Anggaran yang menjadi acuan untuk semua
                                        modul keuangan (RKA dan LPJ).</p>
                                <?php elseif($permission->name === 'cabang-olahraga'): ?>
                                    <p class="mb-3 desc">Bertanggung jawab untuk mengelola data master Cabang Olahraga
                                        (Cabor) yang diakui oleh KONI.</p>
                                <?php elseif($permission->name === 'kejuaraan'): ?>
                                    <p class="mb-3 desc">Memiliki wewenang penuh untuk mengelola data event skala besar atau
                                        memperbaiki data historis kejuaraan.</p>
                                <?php endif; ?>
                                <div class="form-check form-switch form-check-custom form-check-solid">
                                    <input class="form-check-input statusSwitch" name="permissions[]" type="checkbox"
                                        value="<?php echo e($permission->id); ?>" <?php echo e($hasPermission ? 'checked' : ''); ?> />

                                    <label class="form-check-label"
                                        for="statusSwitch"><?php echo e($hasPermission ? 'Active' : 'Inactive'); ?></label>
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
        $('.statusSwitch').change(function(e) {
            e.preventDefault();
            const id = "<?php echo e($role->id); ?>";

            let allPermissions = [];
            $('.statusSwitch:checked').each(function() {
                const rawVal = $(this).val();
                if (rawVal) {
                    const ids = rawVal.split(',').map(Number).filter(Boolean);
                    allPermissions = allPermissions.concat(ids);
                }
            });

            console.log('Semua permissions aktif: ', allPermissions);

            $(this).siblings('label').text(this.checked ? 'Active' : 'Inactive');

            $.ajax({
                type: "POST",
                url: "<?php echo e(route('admin.manajemen-pengguna.role.updatePermissions')); ?>",
                data: {
                    _token: "<?php echo e(csrf_token()); ?>",
                    roleId: id,
                    permissions: allPermissions.join(',')
                },
                dataType: "json",
                success: function(response) {
                    toastr.success(response.message);
                },
                error: function(xhr) {
                    toastr.error(xhr.responseJSON.message || "Error updating permissions");
                }
            });
        });
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/thur/Documents/Inotive/web-koni/resources/views/admin/role/setting.blade.php ENDPATH**/ ?>