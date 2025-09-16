<!DOCTYPE html>
<html>
<head>
    <title>Laporan LPJ - <?php echo e($lpj->nama_program); ?></title>
    <meta charset="UTF-8">
    <style>
       @page {
            margin: 1cm 1.5cm 1.5cm 1.5cm;
        }

        body {
            font-family: 'Times New Roman', serif;
            font-size: 12pt;
            line-height: 1.5;
            margin: 0;
            padding: 0;
            color: #333;
        }

        /* --- HEADER IMAGE --- */
        .letterhead {
            text-align: center;
            margin-bottom: 20px;
        }

        .letterhead img {
            width: 100%;
            max-height: 200px;  /* adjust for PDF */
            object-fit: contain;
        }

        /* --- DOCUMENT TITLE --- */
        .document-title {
            text-align: center;
            font-size: 18pt;
            font-weight: bold;
            margin: 20px 0;
            color: #d32f2f;
            text-transform: uppercase;
        }

        /* --- SECTIONS --- */
        .section-title {
            font-size: 14pt;
            font-weight: bold;
            margin: 25px 0 10px 0;
            padding-left: 8px;
            border-left: 5px solid #d32f2f;
            color: #333;
        }

        /* --- INFO TABLE --- */
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 11pt;
        }

        .info-table th,
        .info-table td {
            padding: 10px 12px;
            border: 1px solid #ddd;
        }

        .info-table th {
            background: #f5f5f5;
            text-align: left;
            width: 30%;
        }

        .info-table tr:nth-child(even) td {
            background: #fafafa;
        }

        .amount {
            font-size: 13pt;
            font-weight: bold;
            color: #2e7d32;
        }

        /* --- PHOTO GRID --- */
        .photo-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 15px;
        }

        .photo-td {
            width: 33%;
            text-align: center;
            vertical-align: top;
        }

        .photo-container {
            background: #fff;
            padding: 8px;
            border-radius: 6px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .photo-container img {
            max-width: 100%;
            border-radius: 4px;
            object-fit: cover;
        }

        .photo-caption {
            font-size: 9pt;
            margin-top: 5px;
            color: #555;
            font-style: italic;
        }

        /* --- SIGNATURE --- */
        .signature-section {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
        }

        .signature-box {
            text-align: center;
            width: 220px;
        }

        .signature-line {
            border-bottom: 1px solid #333;
            margin: 50px 0 8px 0;
        }

        .signature-title {
            font-weight: bold;
            font-size: 11pt;
        }

        /* --- PRINT OPTIMIZATION --- */
        @media print {
            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>
    <!-- HEADER IMAGE -->
    <div class="letterhead">
        <img src="<?php echo e(public_path('assets/img/kop-nobg.png')); ?>" alt="KONI Letterhead">
    </div>

    <!-- MAIN CONTENT -->
    <div class="content">
        <div class="document-title">Laporan LPJ</div>

        <h3 class="section-title">Detail Program dan Kegiatan</h3>
        <table class="info-table">
            <tr>
                <th>Program</th>
                <td><?php echo e($lpj->nama_program); ?></td>
            </tr>
            <tr>
                <th>Kegiatan</th>
                <td><?php echo e($lpj->nama_kegiatan); ?></td>
            </tr>
            <tr>
                <th>Total Anggaran</th>
                <td class="amount">Rp <?php echo e(number_format($lpj->jumlah_harga, 2, ',', '.')); ?></td>
            </tr>
            <?php if($lpj->created_at): ?>
            <tr>
                <th>Tanggal Ditambahkan</th>
                <td class="fw-bold"><?php echo e(\Carbon\Carbon::parse($lpj->created_at)->format('d F Y')); ?></td>
            </tr>
            <?php endif; ?>
            <?php if($lpj->lokasi_kegiatan): ?>
            <tr>
                <th>Lokasi</th>
                <td><?php echo e($lpj->lokasi_kegiatan); ?></td>
            </tr>
            <?php endif; ?>
            <?php if($lpj->keterangan_tambahan): ?>
            <tr>
                <th>Keterangan Tambahan</th>
                <td><?php echo e($lpj->keterangan_tambahan); ?></td>
            </tr>
            <?php endif; ?>
        </table>

        <?php if($lpj->foto_jurnal && count($lpj->foto_jurnal) > 0): ?>
            <h3 class="section-title">Dokumentasi Kegiatan</h3>
            <table class="photo-table">
                <tr>
                    <?php $__currentLoopData = $lpj->foto_jurnal; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $foto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(file_exists(storage_path('app/public/' . $foto))): ?>
                            <td class="photo-td">
                                <div class="photo-container">
                                    <img src="<?php echo e(storage_path('app/public/' . $foto)); ?>" alt="Dokumentasi <?php echo e($index + 1); ?>">
                                    <div class="photo-caption">Dokumentasi <?php echo e($index + 1); ?></div>
                                </div>
                            </td>
                            <?php if(($index + 1) % 3 == 0): ?>
                                </tr><tr>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tr>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>
<?php /**PATH C:\Users\ThinkPad\OneDrive\Dokumen\GitHub\web-koni\resources\views/admin/laporan-lpj/bidang_new/dynamic/pdf-export.blade.php ENDPATH**/ ?>