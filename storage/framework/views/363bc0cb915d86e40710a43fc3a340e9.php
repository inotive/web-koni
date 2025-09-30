<!DOCTYPE html>
<html>
<head>
    <title>Laporan LPJ - <?php echo e($sekretariat->nama_program); ?></title>
    <meta charset="UTF-8">
    <style>
        @page {
            margin-top: 151px;   /* reserve space for letterhead - matching image height */
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
            top: -151px;   /* move into the reserved top margin - matching reserved space */
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
        
        /* First section should have reduced top margin to fill header space */
        .content > .section-title:first-child {
            margin-top: 5px;  /* Reduced top margin to reduce space after header */
        }

        /* --- INFO TABLE --- */
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;  /* Reduced margin to save space */
            font-size: 10pt;     /* Slightly smaller font to save space */
        }

        .info-table th,
        .info-table td {
            padding: 6px 8px;    /* Reduced padding to save space */
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
            border-spacing: 25px;
        }

        .photo-td {
            width: 50%;
            text-align: center;
            vertical-align: top;
        }

        .photo-container {
            background: #fff;
            padding: 8px;
            border-radius: 6px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            display: inline-block;
            width: auto;
            height: auto;
        }

        .photo-container img {
            width: auto;
            height: auto;
            max-width: 100%;
            max-height: none;
            border-radius: 4px;
            object-fit: contain;
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
        <?php if(file_exists(public_path('assets/img/kop-nobg.png'))): ?>
            <img src="<?php echo e(public_path('assets/img/kop-nobg.png')); ?>" alt="KONI Letterhead">
        <?php else: ?>
            <div style="padding: 20px; border: 1px solid #ccc; text-align: center;">
                <h2>KONI LETTERHEAD</h2>
                <p>Header image not found</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- MAIN CONTENT -->
    <div class="content">
            <h3 class="section-title">Detail Program dan Kegiatan</h3>
            <table class="info-table">
                <tr>
                    <th>Program</th>
                    <td><?php echo e($sekretariat->nama_program); ?></td>
                </tr>
                <tr>
                    <th>Kegiatan</th>
                    <td><?php echo e($sekretariat->nama_kegiatan); ?></td>
                </tr>
                <tr>
                    <th>Total Anggaran</th>
                    <td class="amount">Rp <?php echo e(number_format($sekretariat->jumlah_harga, 2, ',', '.')); ?></td>
                </tr>
                <?php if($sekretariat->tanggal_kegiatan): ?>
                <tr>
                    <th>Tanggal Kegiatan</th>
                    <td><?php echo e(\Carbon\Carbon::parse($sekretariat->tanggal_kegiatan)->format('d F Y')); ?></td>
                </tr>
                <?php endif; ?>
                <?php if($sekretariat->lokasi_kegiatan): ?>
                <tr>
                    <th>Lokasi</th>
                    <td><?php echo e($sekretariat->lokasi_kegiatan); ?></td>
                </tr>
                <?php endif; ?>
                <?php if($sekretariat->keterangan_tambahan): ?>
                <tr>
                    <th>Keterangan Tambahan</th>
                    <td><?php echo e($sekretariat->keterangan_tambahan); ?></td>
                </tr>
                <?php endif; ?>
            </table>

            <?php if($sekretariat->foto_jurnal && count($sekretariat->foto_jurnal) > 0): ?>
                <h3 class="section-title">Dokumentasi Kegiatan</h3>
                <table class="photo-table">
                    <tr>
                        <?php $__currentLoopData = $sekretariat->foto_jurnal; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $foto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                if(is_array($foto)) {
                                    $path = $foto['path'] ?? '';
                                    $originalName = $foto['original_name'] ?? basename($path);
                                } else {
                                    $path = $foto;
                                    $originalName = basename($path);
                                }
                                $fullPath = public_path('storage/' . $path);
                            ?>

                            <?php if($path && file_exists($fullPath)): ?>
                                <td class="photo-td">
                                    <div class="photo-container">
                                        <img src="<?php echo e($fullPath); ?>" alt="<?php echo e($originalName); ?>">
                                        <div class="photo-caption"><?php echo e($originalName); ?></div>
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
</html>
<?php /**PATH /home/thur/Documents/Inotive/web-koni/resources/views/admin/laporan-lpj/sekretariat/export.blade.php ENDPATH**/ ?>