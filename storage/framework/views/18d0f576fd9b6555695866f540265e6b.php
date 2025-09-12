<!--begin::Javascript-->
<script>
    var hostUrl = "assets/";
</script>
<!--begin::Global Javascript Bundle(mandatory for all pages)-->
<script src="<?php echo e(asset('assets/js/scripts.bundle.js')); ?>"></script>
<script src="<?php echo e(asset('assets/plugins/global/plugins.bundle.js')); ?>"></script>
<!--end::Global Javascript Bundle-->
<!--begin::Vendors Javascript(used for this page only)-->
<script src="<?php echo e(asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.js')); ?>"></script>
<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
<script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
<script src="https://cdn.amcharts.com/lib/5/map.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/continentsLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/usaLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZonesLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZoneAreasLow.js"></script>
<script src="<?php echo e(asset('assets/plugins/custom/datatables/datatables.bundle.js')); ?>"></script>
<!--end::Vendors Javascript-->
<!--begin::Custom Javascript(used for this page only)-->
<script src="<?php echo e(asset('assets/js/widgets.bundle.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/custom/widgets.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/custom/apps/chat/chat.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/custom/utilities/modals/users-search.js')); ?>"></script>

<!--CKEditor Build Bundles:: Only include the relevant bundles accordingly-->
<script src="<?php echo e(asset('assets/plugins/custom/ckeditor/ckeditor-classic.bundle.js')); ?>"></script>



<script>
    toastr.options = {
        closeButton: true,
        progressBar: true,
        preventDuplicates: true,
        positionClass: "toastr-top-right",
        timeOut: "5000",
        showDuration: "300",
        hideDuration: "1000",
        showEasing: "swing",
        hideEasing: "linear",
        showMethod: "fadeIn",
        hideMethod: "fadeOut"
    };
</script>

<?php if(session()->has('OK')): ?>
    <script>
        toastr.success(<?php echo json_encode(session()->pull('OK')); ?>, 'Success!');
    </script>
<?php endif; ?>

<?php if(session()->has('SUC')): ?>
    <script>
        toastr.success(<?php echo json_encode(session()->pull('SUC')); ?>, 'Success!');
    </script>
<?php endif; ?>

<?php if(session()->has('ERR')): ?>
    <script>
        toastr.error(<?php echo json_encode(session()->pull('ERR')); ?>, 'Error!');
    </script>
<?php endif; ?>

<?php if($errors->any()): ?>
    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <script>
            toastr.error(<?php echo json_encode($error); ?>, "Error!");
        </script>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>

<script>
    $('.datatable').DataTable();
</script>
<!--end::Custom Javascript-->
<!--end::Javascript-->
<?php /**PATH D:\Inotive\KONI\web-koni\resources\views/layouts/js-file.blade.php ENDPATH**/ ?>