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
                    <span class="card-label fw-bold fs-3 mb-1">Daftar Permission</span>
                </h3>
                <div class="card-toolbar">
                        <a href="#" class="btn btn-sm btn-light-primary" data-bs-toggle="modal"
                            data-bs-target="#kt_modal_tambah">
                            <i class="ki-duotone ki-plus fs-2"></i>Tambah Data</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row g-12 g-xl-12">
                    <div class="col-xl-12">
                        <table id="kt_datatable_dom_positioning"
                            class="table table-striped table-row-bordered gy-5 gs-7 border rounded">
                            <thead>
                                <tr class="fw-bold fs-6 text-gray-800 px-7">
                                    <th>No</th>
                                    <th>Group</th>
                                    <th>Display Name</th>
                                    <th>Permission</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr id="<?php echo e($value->id); ?>">
                                        <td><?php echo e($loop->iteration); ?></td>
                                        <td><?php echo e($value->group); ?></td>
                                        <td><?php echo e($value->display_name); ?></td>
                                        <td><?php echo e($value->name); ?></td>
                                        <td>                                        
                                                <a href="#"
                                                    class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1"
                                                    data-bs-toggle="modal" data-bs-target="#kt_modal_<?php echo e($value->id); ?>">
                                                    <i
                                                        class="ki-duotone
                                                ki-pencil fs-2">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                </a>
                                                <?php echo $__env->make('admin.permission.component.modal', [
                                                    'value' => $value,
                                                ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                         
                                                <button data-route="<?php echo e(route('admin.hak-akses.permission.destroy', $value->id)); ?>"
                                                    class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm"
                                                    onclick="destroyItem(this)">
                                                    <i class="ki-duotone ki-trash fs-2">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                        <span class="path4"></span>
                                                        <span class="path5"></span>
                                                    </i>
                                                </button>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    
                            </tbody>
                        </table>
                    </div>
    
                </div>
            </div>
        </div>
    
        <?php echo $__env->make('admin.permission.component.modal-tambah', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
<?php $__env->stopSection(); ?>


<?php $__env->startPush('stack-script'); ?>
   <script>
     $("#kt_datatable_dom_positioning").DataTable({
            "language": {
                "lengthMenu": "Show _MENU_",
            },
            "dom": "<'row'" +
                "<'col-sm-6 d-flex align-items-center justify-conten-start'l>" +
                "<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
                ">" +

                "<'table-responsive'tr>" +

                "<'row'" +
                "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
                "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
                ">"
        });
        const destroyItem = (e) => {
            let target = $(e);

            callSwal(target.data('route'))
        }

        const callSwal = (route) => {
            Swal.fire({
                    title: "Apakah Anda Yakin?",
                    html: "<p style='center'>Setelah Data Dihapus maka Anda Tidak Akan Bisa Mengembalikan Data Kembali!</p>",
                    icon: "warning",
                    showCancelButton: true,
                    reverseButtons: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Hapus!',
                    cancelButtonText: 'Batalkan!'
                })
                .then((willDelete) => {
                    if (willDelete.isConfirmed) {
                        (new FormElementHelper)
                        .createAttribute('hidden', '_token', '<?php echo e(csrf_token()); ?>')
                            .createAttribute('hidden', '_method', 'DELETE')
                            .post(route);
                    } else {
                        Swal.fire({
                            title: "Aksi Dibatalkan :)",
                            icon: "info",
                        })
                    }
                })
        }
   </script>
   <script>
    <?php if(Session::has('pesan')): ?> 
        toastr.<?php echo e(Session::get('alert')); ?>("<?php echo e(Session::get('pesan')); ?>")
    <?php endif; ?>
   </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/thur/Documents/Inotive/web-koni/resources/views/admin/permission/index.blade.php ENDPATH**/ ?>