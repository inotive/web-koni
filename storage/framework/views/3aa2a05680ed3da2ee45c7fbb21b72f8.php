<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export Dashboard Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background-color: #f8f9fa;
        }
        .export-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            padding: 20px;
            margin-bottom: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #dee2e6;
            padding-bottom: 15px;
        }
        .table th {
            background-color: #e9ecef;
            font-weight: bold;
        }
        .summary-box {
            background-color: #f1f8ff;
            border-left: 4px solid #007bff;
            padding: 15px;
            margin-bottom: 20px;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .fw-bold {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="export-card">
        <div class="header">
            <h2>Laporan Dashboard Kegiatan</h2>
            <p>Periode: <?php echo e(date('d F Y')); ?></p>
        </div>

        <div class="summary-box">
            <div class="row">
                <div class="col-6">
                    <h5>Total RKA</h5>
                    <h3>Rp <?php echo e(number_format($total_rka, 0, ',', '.')); ?></h3>
                </div>
                <div class="col-6 text-right">
                    <h5>Total Serapan</h5>
                    <h3>Rp <?php echo e(number_format($total_serapan, 0, ',', '.')); ?></h3>
                </div>
            </div>
        </div>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th class="text-center" width="5%">No</th>
                    <th>Nama Kegiatan</th>
                    <th class="text-right" width="20%">Serapan (Rp)</th>
                    <th class="text-right" width="20%">Anggaran (Rp)</th>
                    <th class="text-center" width="10%">%</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $exportData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td class="text-center"><?php echo e($data['no']); ?></td>
                    <td><?php echo e($data['nama_kegiatan']); ?></td>
                    <td class="text-right">Rp <?php echo e(number_format($data['serapan'], 0, ',', '.')); ?></td>
                    <td class="text-right">Rp <?php echo e(number_format($data['anggaran'], 0, ',', '.')); ?></td>
                    <td class="text-center"><?php echo e($data['persen']); ?>%</td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
            <tfoot>
                <tr class="fw-bold">
                    <td colspan="2" class="text-right">TOTAL</td>
                    <td class="text-right">Rp <?php echo e(number_format($total_serapan, 0, ',', '.')); ?></td>
                    <td class="text-right">Rp <?php echo e(number_format($total_rka, 0, ',', '.')); ?></td>
                    <td class="text-center"><?php echo e($total_rka > 0 ? round(($total_serapan / $total_rka) * 100) : 0); ?>%</td>
                </tr>
            </tfoot>
        </table>

        <div class="mt-4 text-muted">
            <p><small>Laporan ini dihasilkan pada <?php echo e(date('d F Y H:i:s')); ?></small></p>
        </div>
    </div>
</body>
</html><?php /**PATH C:\Users\Javier\Documents\GitHub\web-koni\resources\views/admin/dashboard/export.blade.php ENDPATH**/ ?>