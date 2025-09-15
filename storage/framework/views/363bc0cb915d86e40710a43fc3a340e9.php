<!DOCTYPE html>
<html>
<head>
    <title>Laporan LPJ - <?php echo e($sekretariat->nama_program); ?></title>
    <meta charset="UTF-8">
    <style>
       @page {
            margin: 1cm 1.5cm 1.5cm 1.5cm;
        }

        body {
            font-family: 'Times New Roman', serif;
            font-size: 12pt;
            line-height: 1.4;
            margin: 0;
            padding: 0;
            color: #333;
        }

        /* Header/Letterhead styling */
        .letterhead {
            position: running(header);
            text-align: center;
            margin-bottom: 10px; /* reduced from 20px */
        }

        .letterhead-img {
            width: 100%;
            max-width: 710px;
            height: auto;
            display: block;
            margin: 0 auto;
        }

        .logo-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-width: 120px;
        }

        .logo img {
            width: 90px;
            height: auto;
            object-fit: contain;
        }

        .koni-text {
            font-size: 16pt;
            font-weight: bold;
            color: #d32f2f;
            margin-top: 3px; /* reduced from 5px */
        }

        .header-text {
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: center;
            flex: 1;
        }

        .header-text h1 {
            font-size: 18pt;
            font-weight: bold;
            margin: 0;
            text-transform: uppercase;
            line-height: 1.1; /* reduced */
        }

        .header-text h2 {
            font-size: 16pt;
            font-weight: bold;
            margin: 3px 0; /* reduced from 5px */
            text-transform: uppercase;
            line-height: 1.1; /* reduced */
        }

        .header-contact {
            font-size: 9pt;
            line-height: 1.3; /* reduced */
            margin-top: 5px; /* reduced from 8px */
        }

        .header-contact a {
            color: blue;
            text-decoration: underline;
        }

        .content {

        }

        .document-title {
            text-align: center;
            font-size: 18pt;
            font-weight: bold;
            margin: 15px 0; /* reduced from 30px */
            color: #d32f2f;
            text-transform: uppercase;
            text-decoration: underline;
        }

        .lpj-item {
            page-break-inside: avoid;
            margin-bottom: 15px; /* reduced from 30px */
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            padding: 15px; /* reduced from 25px */
        }

        .program-header {
            background: linear-gradient(135deg, #d32f2f, #f44336);
            color: white;
            padding: 15px; /* reduced from 20px */
            border-radius: 8px 8px 0 0;
            margin: -15px -15px 15px -15px; /* adjusted for new padding */
        }

        .program-header h2 {
            margin: 0;
            font-size: 16pt;
            font-weight: bold;
        }

        .program-header h3 {
            margin: 5px 0 0 0; /* reduced from 8px */
            font-size: 14pt;
            font-weight: normal;
            opacity: 0.9;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0; /* reduced from 20px */
            background: #fff;
            border-radius: 6px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .info-table th {
            background: linear-gradient(135deg, #f5f5f5, #e0e0e0);
            color: #333;
            font-weight: bold;
            padding: 10px 15px; /* reduced vertical padding from 15px */
            text-align: left;
            width: 30%;
            border-bottom: 2px solid #ddd;
        }

        .info-table td {
            padding: 10px 15px; /* reduced vertical padding from 15px */
            border-bottom: 1px solid #eee;
            background: #fafafa;
        }

        .info-table tr:last-child td {
            border-bottom: none;
        }

        .amount {
            font-size: 14pt;
            font-weight: bold;
            color: #2e7d32;
        }

        .section-title {
            font-size: 14pt;
            font-weight: bold;
            color: #000000;
            margin: 20px 0 10px 0; /* reduced from 30px 0 15px 0 */
            padding-bottom: 5px; /* reduced from 8px */
            border-bottom: 2px solid #d32f2f;
        }

        .photos {
            display: flex;
            flex-wrap: wrap;
            gap: 15px; /* spacing between photos */
            justify-content: center;
        }

        .photo-container {
            flex: 1 1 calc(33.33% - 15px); /* 3 per row by default */
            max-width: calc(33.33% - 15px);
            text-align: center;
            background: #fff;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            page-break-inside: avoid; /* prevent splitting on PDF */
        }

        @media (max-width: 768px) {
            .photo-container {
                flex: 1 1 calc(50% - 15px); /* 2 per row on smaller screens */
                max-width: calc(50% - 15px);
            }
        }

        @media (max-width: 480px) {
            .photo-container {
                flex: 1 1 100%; /* 1 per row on very small screens */
                max-width: 100%;
            }
        }


        .photos img {
            max-width: 100%;
            height: auto; /* Maintain aspect ratio */
            border-radius: 6px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
            transition: transform 0.3s ease;
        }

        .photos img:hover {
            transform: scale(1.05);
        }

        .photo-caption {
            margin-top: 8px; /* reduced from 10px */
            font-size: 10pt;
            color: #666;
            font-style: italic;
        }

        /* Print specific styles */
        @media print {
            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .lpj-item {
                box-shadow: 0 2px 8px rgba(0,0,0,0.1);
                border: 1px solid #ddd;
            }

            .lpj-item::before {
                background: #d32f2f;
            }

            .info-table th::after {
                display: none;
            }

            .info-table tr:hover td {
                transform: none;
            }

            .photos img:hover {
                transform: none;
            }

            .photo-container:hover {
                transform: none;
            }

            .amount::before,
            .section-title::before {
                display: none;
            }

            /* Better print page breaks for images */
            .photos {
                page-break-inside: auto;
            }

            .photo-container {
                page-break-inside: avoid;
                break-inside: avoid;
                margin-bottom: 15px;
            }

            /* Reduce spacing on print */
            .letterhead {
                margin-bottom: 5px;
            }

            .content {
                margin-top: 0;
            }
        }

        /* Page break controls */
        .page-break {
            page-break-before: always;
        }

        .no-break {
            page-break-inside: avoid;
        }

        /* Footer styling */
        .signature-section {
            margin-top: 30px; /* reduced from 50px */
            display: flex;
            justify-content: space-between;
        }

        .signature-box {
            text-align: center;
            width: 200px;
        }

        .signature-line {
            border-bottom: 1px solid #333;
            margin: 40px 0 8px 0; /* reduced from 60px 0 10px 0 */
        }

        .signature-title {
            font-weight: bold;
            margin-bottom: 3px; /* reduced from 5px */
        }

        .photo-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 15px;
        }

        .photo-td {
            width: 33%;
            vertical-align: top;
            text-align: center;
        }

        .documents-container {
            margin: 20px 0;
        }

        .document-item {
            display: flex;
            align-items: center;
            padding: 15px;
            margin-bottom: 15px;
            background: #f8f9fa;
            border-radius: 8px;
            border: 1px solid #e9ecef;
        }

        .document-icon {
            margin-right: 15px;
            flex-shrink: 0;
        }

        .document-info {
            flex: 1;
        }

        .document-name {
            font-weight: bold;
            color: #212529;
            margin-bottom: 5px;
            word-break: break-all;
        }

        .document-type {
            font-size: 0.9em;
            color: #6c757d;
            margin-bottom: 3px;
        }

        .document-status {
            font-size: 0.85em;
            color: #28a745;
            font-style: italic;
        }

        .photos img,
        .photo-container img {
            display: block;
            margin: 0 auto;
            max-width: 100%;
            height: auto; /* Maintain aspect ratio */
            border-radius: 6px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }

        @media print {
            .photo-container img {
                max-height: none !important; /* Remove height restrictions for print */
                height: auto;
            }
        }

    </style>
</head>
<body>
    <!-- Letterhead that appears on every page -->
    <div class="letterhead">
        <?php
            $imagePath = public_path('assets/img/kob-nobg.png');
            $imageData = base64_encode(file_get_contents($imagePath));
            $imageSrc = 'data:image/png;base64,' . $imageData;
        ?>
        <img src="<?php echo e($imageSrc); ?>"
             alt="KONI Letterhead"
             style="width: 100%; max-height: 250px; object-fit: contain;"> <!-- reduced max-height from 296px -->
    </div>

    <!-- Main content starts here -->
    <div class="content">
        <div class="lpj-item no-break">
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
                            <?php if(is_array($foto)): ?>
                                <?php
                                    $path = $foto['path'] ?? '';
                                    $originalName = $foto['original_name'] ?? basename($path);
                                ?>
                            <?php else: ?>
                                <?php
                                    $path = $foto;
                                    $originalName = basename($path);
                                ?>
                            <?php endif; ?>
                            
                            <?php if($path && file_exists(storage_path('app/public/' . $path))): ?>
                                <td class="photo-td">
                                    <div class="photo-container">
                                        <img src="<?php echo e(storage_path('app/public/' . $path)); ?>" alt="<?php echo e($originalName); ?>">
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

            <?php if(($sekretariat->dokumen_lpj && count($sekretariat->dokumen_lpj) > 0) || ($sekretariat->dokumen_lpj_pdf)): ?>
                <h3 class="section-title">Dokumen Pendukung</h3>
                <div class="documents-container">
                    <?php if($sekretariat->dokumen_lpj_pdf): ?>
                        <?php
                            if (is_object($sekretariat->dokumen_lpj_pdf)) {
                                $pdfPath = $sekretariat->dokumen_lpj_pdf->path;
                                $pdfOriginalName = $sekretariat->dokumen_lpj_pdf->original_name ?? basename($pdfPath);
                            } elseif (is_array($sekretariat->dokumen_lpj_pdf)) {
                                $pdfPath = isset($sekretariat->dokumen_lpj_pdf['path']) ? $sekretariat->dokumen_lpj_pdf['path'] : '';
                                $pdfOriginalName = isset($sekretariat->dokumen_lpj_pdf['original_name']) ? $sekretariat->dokumen_lpj_pdf['original_name'] : (is_string($pdfPath) ? basename($pdfPath) : '');
                            } elseif (is_string($sekretariat->dokumen_lpj_pdf)) {
                                $pdfPath = $sekretariat->dokumen_lpj_pdf;
                                $pdfOriginalName = basename($pdfPath);
                            }
                        ?>
                        <?php if($pdfPath && file_exists(storage_path('app/public/' . $pdfPath))): ?>
                            <div class="document-item">
                                <div class="document-icon pdf">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="#d32f2f">
                                        <path d="M8.267 14.68c-.184 0-.308.018-.372.036v1.178c.076.018.171.023.302.023.479 0 .774-.242.774-.651 0-.366-.254-.586-.704-.586zm3.487.012c-.2 0-.33.018-.407.036v2.61c.077.018.201.018.313.018.817.006 1.349-.444 1.349-1.396.006-.83-.479-1.268-1.255-1.268z"/>
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6zM9.498 16.19c-.309.29-.765.42-1.296.42a2.23 2.23 0 0 1-.308-.018v1.426H7v-3.936A7.558 7.558 0 0 1 8.219 14c.557 0 .953.106 1.22.319.254.202.426.533.426.923-.001.392-.131.723-.367.948zm3.807 1.355c-.42.349-1.059.515-1.84.515-.468 0-.799-.03-1.024-.06v-3.917A7.947 7.947 0 0 1 11.66 14c.757 0 1.249.136 1.633.426.415.308.675.799.675 1.504 0 .763-.279 1.29-.663 1.615zM17 14.77h-1.532v.911H16.9v.734h-1.432v1.604h-.906V14.03H17v.74zM14 9h-1V4l5 5h-4z"/>
                                    </svg>
                                </div>
                                <div class="document-info">
                                    <div class="document-name"><?php echo e($pdfOriginalName); ?></div>
                                    <div class="document-type">Dokumen PDF</div>
                                    <div class="document-status">Tersedia dalam sistem</div>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php if($sekretariat->dokumen_lpj && count($sekretariat->dokumen_lpj) > 0): ?>
                        <?php $__currentLoopData = $sekretariat->dokumen_lpj; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dokumen): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(is_array($dokumen)): ?>
                                <?php
                                    $path = $dokumen['path'] ?? '';
                                    $originalName = $dokumen['original_name'] ?? basename($path);
                                ?>
                            <?php else: ?>
                                <?php
                                    $path = $dokumen;
                                    $originalName = basename($path);
                                ?>
                            <?php endif; ?>
                            
                            <?php if($path && file_exists(storage_path('app/public/' . $path))): ?>
                                <div class="document-item">
                                    <?php
                                        $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
                                        $iconColor = '#6c757d';
                                        switch($extension) {
                                            case 'pdf':
                                                $iconColor = '#d32f2f';
                                                break;
                                            case 'doc':
                                            case 'docx':
                                                $iconColor = '#1976d2';
                                                break;
                                            case 'xls':
                                            case 'xlsx':
                                                $iconColor = '#388e3c';
                                                break;
                                            default:
                                                $iconColor = '#6c757d';
                                        }
                                    ?>
                                    <div class="document-icon <?php echo e($extension); ?>">
                                        <?php if(in_array($extension, ['pdf'])): ?>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="<?php echo e($iconColor); ?>">
                                                <path d="M8.267 14.68c-.184 0-.308.018-.372.036v1.178c.076.018.171.023.302.023.479 0 .774-.242.774-.651 0-.366-.254-.586-.704-.586zm3.487.012c-.2 0-.33.018-.407.036v2.61c.077.018.201.018.313.018.817.006 1.349-.444 1.349-1.396.006-.83-.479-1.268-1.255-1.268z"/>
                                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6zM9.498 16.19c-.309.29-.765.42-1.296.42a2.23 2.23 0 0 1-.308-.018v1.426H7v-3.936A7.558 7.558 0 0 1 8.219 14c.557 0 .953.106 1.22.319.254.202.426.533.426.923-.001.392-.131.723-.367.948zm3.807 1.355c-.42.349-1.059.515-1.84.515-.468 0-.799-.03-1.024-.06v-3.917A7.947 7.947 0 0 1 11.66 14c.757 0 1.249.136 1.633.426.415.308.675.799.675 1.504 0 .763-.279 1.29-.663 1.615zM17 14.77h-1.532v.911H16.9v.734h-1.432v1.604h-.906V14.03H17v.74zM14 9h-1V4l5 5h-4z"/>
                                            </svg>
                                        <?php elseif(in_array($extension, ['doc', 'docx'])): ?>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="<?php echo e($iconColor); ?>">
                                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6zM7 18v-2h3v-1H7v-2h5v1h-3v1h3v2H7zm7-8V4.5L19.5 10H14z"/>
                                            </svg>
                                        <?php elseif(in_array($extension, ['xls', 'xlsx'])): ?>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="<?php echo e($iconColor); ?>">
                                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6zM7 18v-2h3v-1H7v-2h5v1h-3v1h3v2H7zm7-8V4.5L19.5 10H14z"/>
                                            </svg>
                                        <?php else: ?>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="<?php echo e($iconColor); ?>">
                                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6zM7 18v-2h3v-1H7v-2h5v1h-3v1h3v2H7zm7-8V4.5L19.5 10H14z"/>
                                            </svg>
                                        <?php endif; ?>
                                    </div>
                                    <div class="document-info">
                                        <div class="document-name"><?php echo e($originalName); ?></div>
                                        <div class="document-type">Dokumen <?php echo e(strtoupper($extension)); ?></div>
                                        <div class="document-status">Tersedia dalam sistem</div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html><?php /**PATH /home/thur/Documents/Inotive/web-koni/resources/views/admin/laporan-lpj/sekretariat/export.blade.php ENDPATH**/ ?>