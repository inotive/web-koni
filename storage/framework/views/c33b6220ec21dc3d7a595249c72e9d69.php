<!DOCTYPE html>
<html>
<head>
    <title>Laporan LPJ - <?php echo e($kegiatanLainnya->nama_program); ?></title>
    <meta charset="UTF-8">
    <style>
        @page {
            margin-top: 160px;   /* reserve space for letterhead */
            margin-left: 30px;
            margin-right: 30px;
            margin-bottom: 40px;
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
            position: fixed;
            top: -160px;   /* move into the reserved top margin */
            left: 0;
            right: 0;
            text-align: center;
            height: 151px; /* actual header image height */
        }

        .letterhead img {
            width: 100%;
            height: auto;
            max-height: 151px; /* match your letterhead (810x151) */
            object-fit: contain;
        }

        /* --- MAIN CONTENT --- */
        .content {
            margin-top: 0;   /* no need for padding-top anymore */
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
        <h3 class="section-title">Detail Program dan Kegiatan</h3>
        <table class="info-table">
            <tr>
                <th>Program</th>
                <td><?php echo e($kegiatanLainnya->nama_program); ?></td>
            </tr>
            <tr>
                <th>Kegiatan</th>
                <td><?php echo e($kegiatanLainnya->nama_kegiatan); ?></td>
            </tr>
            <tr>
                <th>Total Anggaran</th>
                <td class="amount">Rp <?php echo e(number_format($kegiatanLainnya->jumlah_harga, 2, ',', '.')); ?></td>
            </tr>
            <?php if($kegiatanLainnya->created_at): ?>
            <tr>
                <th>Tanggal Ditambahkan</th>
                <td><?php echo e(\Carbon\Carbon::parse($kegiatanLainnya->created_at)->format('d F Y')); ?></td>
            </tr>
            <?php endif; ?>
            <?php if($kegiatanLainnya->tanggal_kegiatan): ?>
            <tr>
                <th>Tanggal Kegiatan</th>
                <td><?php echo e(\Carbon\Carbon::parse($kegiatanLainnya->tanggal_kegiatan)->format('d F Y')); ?></td>
            </tr>
            <?php endif; ?>
            <?php if($kegiatanLainnya->volume): ?>
            <tr>
                <th>Volume</th>
                <td><?php echo e($kegiatanLainnya->volume); ?></td>
            </tr>
            <?php endif; ?>
            <?php if($kegiatanLainnya->jumlah_harga_satuan): ?>
            <tr>
                <th>Harga Satuan</th>
                <td>Rp <?php echo e(number_format($kegiatanLainnya->jumlah_harga_satuan, 2, ',', '.')); ?></td>
            </tr>
            <?php endif; ?>
            <?php if($kegiatanLainnya->keterangan_tambahan): ?>
            <tr>
                <th>Keterangan Tambahan</th>
                <td><?php echo e($kegiatanLainnya->keterangan_tambahan); ?></td>
            </tr>
            <?php endif; ?>
        </table>

        <?php if($kegiatanLainnya->foto_jurnal && count($kegiatanLainnya->foto_jurnal) > 0): ?>
            <h3 class="section-title">Dokumentasi Kegiatan</h3>
            <table class="photo-table">
                <tr>
                    <?php $__currentLoopData = $kegiatanLainnya->foto_jurnal; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $foto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $path = is_array($foto) ? ($foto['path'] ?? '') : $foto;
                        ?>
                        
                        <?php if(file_exists(storage_path('app/public/' . $path))): ?>
                            <td class="photo-td">
                                <div class="photo-container">
                                    <!-- Placeholder for image - using CSS background to avoid GD issues -->
                                    <div style="width: 100%; height: 150px; background-color: #f0f0f0; display: flex; align-items: center; justify-content: center; border: 1px solid #ddd; border-radius: 4px;">
                                        <span style="color: #666; font-size: 12px; text-align: center; padding: 10px;">
                                            Gambar: <?php echo e(pathinfo($path, PATHINFO_FILENAME)); ?><br>
                                            (Lampiran dalam dokumen asli)
                                        </span>
                                    </div>
                                    <div class="photo-caption"><?php echo e(pathinfo($path, PATHINFO_FILENAME)); ?></div>
                                </div>
                            </td>
                            <?php if(($index + 1) % 3 == 0): ?>
                                </tr><tr> <!-- Start new row every 3 images -->
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tr>
            </table>
        <?php endif; ?>
    </div>
</body>
</html><?php /**PATH C:\Users\Javier\Documents\GitHub\web-koni\resources\views/admin/laporan-lpj/kegiatan-lainnya/export.blade.php ENDPATH**/ ?>