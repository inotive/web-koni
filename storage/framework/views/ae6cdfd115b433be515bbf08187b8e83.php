<!DOCTYPE html>
<html>
<head>
    <title>Laporan LPJ</title>
    <style>
        body { font-family: sans-serif; }
        .lpj-item { page-break-inside: avoid; margin-bottom: 20px; border: 1px solid #ccc; padding: 15px; }
        h1, h2, h3 { color: #333; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background-color: #f2f2f2; }
        .photos img { max-width: 200px; margin: 5px; }
        .page-break { page-break-after: always; }
    </style>
</head>
<body>
    <h1>Laporan Pertanggungjawaban (LPJ)</h1>

    <?php $__currentLoopData = $lpjData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lpj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="lpj-item">
            <h2><?php echo e($lpj->nama_program); ?></h2>
            <h3><?php echo e($lpj->nama_kegiatan); ?></h3>

            <table>
                <tr>
                    <th>Total Anggaran</th>
                    <td>Rp <?php echo e(number_format($lpj->jumlah_harga, 2, ',', '.')); ?></td>
                </tr>
                <?php if($lpj->keterangan_tambahan): ?>
                <tr>
                    <th>Keterangan</th>
                    <td><?php echo e($lpj->keterangan_tambahan); ?></td>
                </tr>
                <?php endif; ?>
            </table>

            <?php if($lpj->foto_jurnal && count($lpj->foto_jurnal) > 0): ?>
                <h3>Lampiran Foto Jurnal</h3>
                <div class="photos">
                    <?php $__currentLoopData = $lpj->foto_jurnal; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $foto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(file_exists(storage_path('app/public/' . $foto))): ?>
                            <img src="<?php echo e(storage_path('app/public/' . $foto)); ?>">
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>
        </div>
        <?php if(!$loop->last): ?>
            <div class="page-break"></div>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</body>
</html><?php /**PATH C:\Users\ThinkPad\OneDrive\Dokumen\GitHub\web-koni\resources\views/admin/laporan-lpj/bidang_new/dynamic/pdf-export-all.blade.php ENDPATH**/ ?>