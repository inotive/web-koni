<div class="table-reponsive table-bordered py-4 d-flex flex-column gap-4" style="overflow-x: auto;">
    <!--begin::Table-->
    <table class="gs-0 gy-4 m-0 table border border-gray-300 p-0 text-center align-middle">
        <!--begin::Table head-->
        <thead>
            <tr class="fw-bold text-muted p-0">
                <th class="min-w-150px bg-light border border-gray-300 px-2 text-center">Tanggal Transaksi</th>
                <th class="min-w-150px bg-light border border-gray-300 px-2 text-center">Nama Nasabah</th>
                <th class="min-w-100px bg-light border border-gray-300 px-2 text-center">Nama Barang</th>
                <th class="min-w-150px bg-light border border-gray-300 px-2 text-center">Status</th>
                <th class="min-w-150px bg-light border border-gray-300 px-2 text-center">Jumlah Pinjaman</th>
            </tr>
        </thead>
        <!--end::Table head-->
        <!--begin::Table body-->
        <?php
            $test = [];
        ?>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $test; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td class="fw-bold py-8 text-gray-600" colspan="9">Tidak ada transaksi ditemukan.</td>
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
<?php /**PATH /home/thur/Documents/Inotive/web-koni/resources/views/admin/dashboard/components/table-riwayat.blade.php ENDPATH**/ ?>