<div class="table-reponsive table-bordered py-4 d-flex flex-column gap-4" style="overflow-x: auto;">
    <!--begin::Table-->
    <table class="gs-0 gy-4 m-0 table border border-gray-300 p-0 text-center align-middle">
        <!--begin::Table head-->
        <thead>
            <tr class="fw-bold text-muted p-0">
                <th class="min-w-150px bg-light border border-gray-300 px-2 text-center">Kode Barang</th>
                <th class="min-w-150px bg-light border border-gray-300 px-2 text-center">Nama Barang</th>
                <th class="min-w-100px bg-light border border-gray-300 px-2 text-center">Nama Nasabah</th>
                <th class="min-w-150px bg-light border border-gray-300 px-2 text-center">Tanggal Gadai</th>
                <th class="min-w-150px bg-light border border-gray-300 px-2 text-center">Jatuh Tempo</th>
                <th class="min-w-100px bg-light border border-gray-300 px-2 text-center">Status</th>
            </tr>
        </thead>
        <!--end::Table head-->
        <!--begin::Table body-->
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $nota; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($item->nota_gadai_has_item->kode_barang); ?></td>
                    <td><?php echo e($item->nota_gadai_has_item->product->name); ?></td>
                    <td><?php echo e($item->nasabah->nama); ?></td>
                    <td><?php echo e($item->tanggal_masuk->format('d F Y')); ?></td>
                    <td><?php echo e($item->jatuh_tempo->format('d F Y')); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td class="fw-bold py-8 text-gray-600" colspan="9">Tidak ada transaksi ditemukan</td>
                </tr>
            <?php endif; ?>
        </tbody>
        <!--end::Table body-->
    </table>
    <!--end::Table-->
    <div class="px-10">
        <div class="d-flex justify-content-between col-12">
            <div class="d-flex align-items-center gap-2 text-gray-500">
                Show
                <select id="per_page_gadai" name="per_page" class="form-select w-75 border border-gray-300 p-2">
                    <option value="10" <?php echo e(request('per_page', 10) == 10 ? 'selected' : ''); ?>>10</option>
                    <option value="25" <?php echo e(request('per_page', 10) == 25 ? 'selected' : ''); ?>>25</option>
                    <option value="50" <?php echo e(request('per_page', 10) == 50 ? 'selected' : ''); ?>>50</option>
                    <option value="100" <?php echo e(request('per_page', 10) == 100 ? 'selected' : ''); ?>>100</option>
                </select>
                per page
            </div>

            <!-- Paginate -->
            
        </div>
    </div>
</div>
<?php /**PATH /home/thur/Documents/Inotive/web-koni/resources/views/admin/dashboard/components/table-barang.blade.php ENDPATH**/ ?>