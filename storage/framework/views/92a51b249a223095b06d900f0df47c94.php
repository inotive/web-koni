<!DOCTYPE html>
<html>
<head>
    <title><?php echo e($title); ?></title>
    <meta charset="utf-8">
    <style>
        @page {
            margin-top: 160px;   /* reserve space for header */
            margin-left: 30px;
            margin-right: 30px;
            margin-bottom: 40px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
            color: #333;
        }

        /* --- HEADER IMAGE --- */
        .header {
            position: fixed;
            top: -160px;   /* move into the reserved top margin */
            left: 0;
            right: 0;
            text-align: center;
            height: 151px; /* header height */
        }

        .header img {
            width: 100%;
            height: auto;
            max-height: 151px; /* adjust to your header */
            object-fit: contain;
        }

        /* Kop Surat - for fallback text header if image doesn't load */
        .kop-surat {
            text-align: center;
            border-bottom: 3px solid #dc3545;
            padding: 10px 0;
            margin-bottom: 20px;
        }

        .kop-surat h1 {
            color: #dc3545;
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }

        .kop-surat h2 {
            color: #333;
            margin: 5px 0;
            font-size: 14px;
            font-weight: bold;
        }

        .kop-surat p {
            margin: 2px 0;
            color: #666;
            font-size: 10px;
        }

        /* Konten Utama */
        .container {
            padding: 0 20px;
        }

        .section {
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #dc3545;
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-bottom: 10px;
        }

        .info-item {
            margin-bottom: 8px;
        }

        .info-label {
            font-weight: bold;
            color: #333;
            font-size: 11px;
        }

        .info-value {
            color: #555;
            font-size: 12px;
        }

        /* Tabel */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #dee2e6;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #dc3545;
            color: white;
            font-weight: bold;
        }

        /* Gambar */
        .foto-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            margin-top: 10px;
        }

        .foto-item {
            text-align: center;
        }

        .foto-item img {
            max-width: 100%;
            height: auto; /* Changed from fixed height to auto to maintain aspect ratio */
            object-fit: contain; /* Changed from cover to contain to preserve aspect ratio */
            border: 1px solid #dee2e6;
            border-radius: 4px;
        }

        .foto-item .foto-name {
            font-size: 10px;
            margin-top: 5px;
            color: #666;
        }

        /* Dokumen */
        .dokumen-list {
            margin-top: 10px;
        }

        .dokumen-item {
            padding: 5px 0;
            border-bottom: 1px solid #eee;
            display: flex;
            align-items: center;
        }

        .dokumen-item i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        .no-data {
            color: #999;
            font-style: italic;
            padding: 10px 0;
        }

        /* Footer */
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: right;
            font-size: 10px;
            color: #666;
            padding: 10px 20px;
            border-top: 1px solid #dee2e6;
        }

        /* Halaman Baru */
        .page-break {
            page-break-after: always;
        }

        /* Gambar Full Width */
        .full-width-image {
            width: auto; /* Changed from 100% to auto */
            max-width: 100%;
            height: auto; /* Changed from fixed height to auto */
            object-fit: contain;
            margin: 10px 0;
            border: 1px solid #dee2e6;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <!-- HEADER IMAGE -->
    <div class="header">
        <?php
            $imagePath = public_path('assets/img/kop-nobg.png');
            if(file_exists($imagePath)) {
                $imageMimeType = mime_content_type($imagePath);
                $imageData = base64_encode(file_get_contents($imagePath));
                $imageSrc = 'data:' . $imageMimeType . ';base64,' . $imageData;
                echo '<img src="' . $imageSrc . '" alt="KONI Letterhead">';
            } else {
                // Fallback if image doesn't exist - show the text header
                echo '<div class="kop-surat">
                        <h1>KOMITE OLAHRAGA NASIONAL INDONESIA</h1>
                        <h2>LAPORAN PERTANGGUNGJAWABAN KEGIATAN LAINNYA</h2>
                        <p>Jl. Jenderal Sudirman No. 123, Jakarta Pusat 10210</p>
                        <p>Telp: (021) 1234567 | Email: info@koni.or.id</p>
                      </div>';
            }
        ?>
     </div>

    <!-- Konten Utama -->
    <div class="container">
        <div class="section">
            <div class="section-title">INFORMASI KEGIATAN</div>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Nama Program</div>
                    <div class="info-value"><?php echo e($data['nama_program'] ?? 'N/A'); ?></div>
                </div>
                <?php if(!empty($data['nama_kegiatan'])): ?>
                <div class="info-item">
                    <div class="info-label">Nama Kegiatan</div>
                    <div class="info-value"><?php echo e($data['nama_kegiatan']); ?></div>
                </div>
                <?php endif; ?>
                <?php if(!empty($data['volume'])): ?>
                <div class="info-item">
                    <div class="info-label">Volume</div>
                    <div class="info-value"><?php echo e($data['volume']); ?></div>
                </div>
                <?php endif; ?>
                <?php if(!empty($data['tempat_kegiatan'])): ?>
                <div class="info-item">
                    <div class="info-label">Tempat Kegiatan</div>
                    <div class="info-value"><?php echo e($data['tempat_kegiatan']); ?></div>
                </div>
                <?php endif; ?>
                <?php if(!empty($data['tanggal_kegiatan'])): ?>
                <div class="info-item">
                    <div class="info-label">Tanggal Kegiatan</div>
                    <div class="info-value"><?php echo e(\Carbon\Carbon::parse($data['tanggal_kegiatan'])->format('d/m/Y')); ?></div>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <?php if(!empty($data['jumlah_harga_satuan']) || !empty($data['jumlah_harga'])): ?>
        <div class="section">
            <div class="section-title">RINCIAN ANGGARAN</div>
            <div class="info-grid">
                <?php if(!empty($data['jumlah_harga_satuan'])): ?>
                <div class="info-item">
                    <div class="info-label">Harga Satuan</div>
                    <div class="info-value">Rp <?php echo e(number_format($data['jumlah_harga_satuan'], 0, ',', '.')); ?></div>
                </div>
                <?php endif; ?>
                <?php if(!empty($data['jumlah_harga'])): ?>
                <div class="info-item">
                    <div class="info-label">Total Anggaran</div>
                    <div class="info-value">Rp <?php echo e(number_format($data['jumlah_harga'], 0, ',', '.')); ?></div>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>

        <?php if(!empty($data['sumber_dana'])): ?>
        <div class="section">
            <div class="section-title">SUMBER DANA</div>
            <div class="info-value"><?php echo e($data['sumber_dana']); ?></div>
        </div>
        <?php endif; ?>

        <div class="section">
            <div class="section-title">LAMPIRAN</div>

            <!-- Foto Jurnal -->
            <div class="info-item">
                <div class="info-label">Foto Jurnal:</div>
                <?php if(!empty($data['foto_jurnal']) && is_array($data['foto_jurnal']) && count($data['foto_jurnal']) > 0): ?>
                <div class="foto-container">
                    <?php $__currentLoopData = $data['foto_jurnal']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $foto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $path = is_object($foto) ? $foto->path : (is_array($foto) ? $foto['path'] : $foto);
                            $fullPath = public_path('storage/' . $path);
                            $fileName = basename($path);
                        ?>
                        <?php if(file_exists($fullPath)): ?>
                        <div class="foto-item">
                            <img src="data:image/<?php echo e(pathinfo($fullPath, PATHINFO_EXTENSION)); ?>;base64,<?php echo e(base64_encode(file_get_contents($fullPath))); ?>" alt="<?php echo e($fileName); ?>">
                            <div class="foto-name"><?php echo e($fileName); ?></div>
                        </div>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php else: ?>
                <div class="no-data">Tidak ada foto tersedia</div>
                <?php endif; ?>
            </div>


        </div>

        <?php if(!empty($data['keterangan_tambahan'])): ?>
        <div class="section">
            <div class="section-title">KETERANGAN TAMBAHAN</div>
            <div class="info-value" style="white-space: pre-wrap;"><?php echo e($data['keterangan_tambahan']); ?></div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Footer -->
    <div class="footer">
        Dicetak pada: <?php echo e(date('d F Y H:i:s')); ?>

    </div>
</body>
</html><?php /**PATH /home/thur/Documents/Inotive/web-koni/resources/views/admin/laporan-lpj/kegiatan-lainnya/export-detail.blade.php ENDPATH**/ ?>