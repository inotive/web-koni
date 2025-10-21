<!DOCTYPE html>
<html>
<head>
    <title>Detail Atlet - <?php echo e($atlet->nama); ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }

        .header h1 {
            margin: 0;
            font-size: 18px;
            color: #000;
        }

        .section {
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #000;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
        }

        .info-row {
            display: flex;
            margin-bottom: 8px;
        }

        .info-label {
            width: 150px;
            font-weight: bold;
        }

        .info-value {
            flex: 1;
        }

        .photo-section {
            display: flex;
            align-items: flex-start;
            margin-bottom: 20px;
        }

        .photo-label {
            width: 150px;
            font-weight: bold;
        }

        .photo-container {
            flex: 1;
            display: flex;
            align-items: center;
        }

        .photo {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #333;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
            font-style: italic;
            font-size: 10px;
        }

        /* --- HEADER IMAGE FOR PDF EXPORT (appears only once at the top) --- */
        .letterhead {
            text-align: center;
            margin-bottom: 20px;
        }

        .letterhead img {
            width: 100%;
            height: auto;
            max-height: 151px; /* match your letterhead (810x151) */
            object-fit: contain;
        }
    </style>
</head>
<body>
    <!-- HEADER IMAGE -->
    <div class="letterhead">
        <?php if(file_exists(public_path('assets/img/kop-nobg.png'))): ?>
            <img src="<?php echo e(public_path('assets/img/kop-nobg.png')); ?>" alt="KONI Letterhead">
        <?php else: ?>
            <div style="padding: 20px; border: 1px solid #ccc; text-align: center;">
                <h2>KONI LETTERHEAD</h2>
                <p>Header image not found</p>
            </div>
        <?php endif; ?>
    </div>

    <div class="header">
        <h1>DATA DETAIL ATLET</h1>
    </div>

    <div class="photo-section">
        <div class="photo-label">Foto Atlet</div>
        <div class="photo-container">
            <?php if($atlet->foto && file_exists(public_path('storage/' . $atlet->foto))): ?>
                <img src="<?php echo e(public_path('storage/' . $atlet->foto)); ?>" alt="Foto Atlet" class="photo">
            <?php else: ?>
                <div style="width: 120px; height: 120px; border: 1px solid #ddd; border-radius: 5px; display: flex; align-items: center; justify-content: center; background-color: #f9f9f9;">
                    <span style="font-size: 10px; text-align: center;">Tidak ada foto</span>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="section">
        <div class="section-title">INFORMASI PRIBADI</div>
        <div class="info-row">
            <div class="info-label">Nama</div>
            <div class="info-value"><?php echo e($atlet->nama); ?></div>
        </div>
        <div class="info-row">
            <div class="info-label">Cabang Olahraga</div>
            <div class="info-value"><?php echo e($atlet->cabangOlahraga->nama_cabor ?? '-'); ?></div>
        </div>
        <div class="info-row">
            <div class="info-label">Email</div>
            <div class="info-value"><?php echo e($atlet->email ?? '-'); ?></div>
        </div>
        <div class="info-row">
            <div class="info-label">No Telepon</div>
            <div class="info-value"><?php echo e($atlet->no_telepon ?? '-'); ?></div>
        </div>
        <div class="info-row">
            <div class="info-label">Tempat Lahir</div>
            <div class="info-value"><?php echo e($atlet->tempat_lahir ?? '-'); ?></div>
        </div>
        <div class="info-row">
            <div class="info-label">Tanggal Lahir</div>
            <div class="info-value"><?php echo e($atlet->tanggal_lahir ? \Carbon\Carbon::parse($atlet->tanggal_lahir)->format('d/m/Y') : '-'); ?></div>
        </div>
        <div class="info-row">
            <div class="info-label">Jenis Kelamin</div>
            <div class="info-value"><?php echo e($atlet->jenis_kelamin); ?></div>
        </div>
        <div class="info-row">
            <div class="info-label">Ketersediaan</div>
            <div class="info-value"><?php echo e($atlet->ketersediaan); ?></div>
        </div>
    </div>

    <div class="section">
        <div class="section-title">ALAMAT</div>
        <div class="info-row">
            <div class="info-label">Alamat</div>
            <div class="info-value"><?php echo e($atlet->alamat ?? '-'); ?></div>
        </div>
        <div class="info-row">
            <div class="info-label">Kota</div>
            <div class="info-value"><?php echo e($atlet->alamatkota ?? '-'); ?></div>
        </div>
        <div class="info-row">
            <div class="info-label">Provinsi</div>
            <div class="info-value"><?php echo e($atlet->alamatprovinsi ?? '-'); ?></div>
        </div>
    </div>

    <div class="section">
        <div class="section-title">RIWAYAT PRESTASI</div>
        <div class="info-row">
            <div class="info-label">Total Prestasi <?php echo e($atlet->nama); ?></div>
        </div>

        <?php if($atlet->prestasis->count() > 0): ?>
        <table>
            <thead>
                <tr>
                    <th width="5%" class="text-center">No</th>
                    <th width="20%">Nama Prestasi</th>
                    <th width="20%">Kejuaraan</th>
                    <th width="15%">Cabang Olahraga</th>
                    <th width="10%">Tingkat</th>
                    <th width="15%">Tempat</th>
                    <th width="8%">Tahun</th>
                    <th width="7%">Medali</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $atlet->prestasis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $prestasi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td class="text-center"><?php echo e($index + 1); ?></td>
                    <td><?php echo e($prestasi->nama_prestasi ?? '-'); ?></td>
                    <td><?php echo e($prestasi->kejuaraan ?? '-'); ?></td>
                    <td><?php echo e($atlet->cabangOlahraga->nama_cabor ?? '-'); ?></td>
                    <td><?php echo e($prestasi->tingkat ?? '-'); ?></td>
                    <td><?php echo e($prestasi->tempat ?? '-'); ?></td>
                    <td><?php echo e($prestasi->tahun ?? '-'); ?></td>
                    <td><?php echo e($prestasi->medali ?? '-'); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        <?php else: ?>
        <div>Tidak ada data prestasi.</div>
        <?php endif; ?>
    </div>

    <div class="footer">
        Dicetak pada: <?php echo e(\Carbon\Carbon::now()->format('d/m/Y H:i:s')); ?>

    </div>
</body>
</html>
<?php /**PATH /home/thur/Documents/Inotive/web-koni/resources/views/admin/atlet/export-pdf.blade.php ENDPATH**/ ?>