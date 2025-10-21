<div class="tab-content" id="prestasi-tab-content">
    <!-- Prestasi Atlet -->
    <div class="tab-pane fade show active" id="atlet-prestasi" role="tabpanel">
        <?php echo $__env->make('admin.dashboard.partials._prestasi-atlet-table', ['prestasi_list' => $latest_prestasi, 'type' => 'atlet'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>

    <!-- Prestasi Pelatih -->
    <div class="tab-pane fade" id="pelatih-prestasi" role="tabpanel">
        <?php echo $__env->make('admin.dashboard.partials._prestasi-pelatih-table', ['prestasi_list' => $latest_prestasi_pelatih ?? collect(), 'type' => 'pelatih'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
</div>
<?php /**PATH /home/thur/Documents/Inotive/web-koni/resources/views/admin/dashboard/partials/prestasi-table.blade.php ENDPATH**/ ?>