<!DOCTYPE html>
<html>
<head>
    <title>Detail pelatih - <?php echo e($pelatih->nama); ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .kop img {
            width: 100%;
            max-height: 120px;
            object-fit: contain;
            display: block;
            margin: 0 auto 10px auto;
        }

        .header {
            text-align: center;
            margin: 0 20px 10px 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 5px;
        }

        .header h1 {
            margin: 0;
            font-size: 18px;
            color: #000;
        }

        .section {
            margin: 0 20px 20px 20px;
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

        .info-container {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .info-left {
            flex: 1;
        }

        .info-photo {
            flex-shrink: 0;
            margin-left: 30px;
            text-align: center;
        }

        .photo {
            width: 110px;
            height: 110px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #333;
        }

        .no-photo {
            width: 110px;
            height: 110px;
            border-radius: 50%;
            border: 3px solid #333;
            background-color: #f2f2f2;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            color: #666;
            text-align: center;
        }

        .footer {
            margin: 30px 20px 0 20px;
            text-align: right;
            font-style: italic;
            font-size: 10px;
        }
    </style>
</head>
<body>
    <div class="kop">
        <img src="assets/img/kop-nobg.png" alt="Kop Surat">
    </div>

    <div class="header">
        <h1>DATA DETAIL PELATIH</h1>
    </div>

    <div class="section">
        <div class="section-title">INFORMASI PRIBADI</div>
        <div class="info-container">
            <div class="info-left">
                <div class="info-photo">
                    <?php if($pelatih->foto): ?>
                        <img src="<?php echo e(public_path('storage/' . $pelatih->foto)); ?>" alt="Foto Pelatih" class="photo">
                    <?php else: ?>
                        <div class="no-photo">Tidak ada foto</div>
                    <?php endif; ?>
                </div>
                <div class="info-row">
                    <div class="info-label">Nama</div>
                    <div class="info-value"><?php echo e($pelatih->nama); ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Cabang Olahraga</div>
                    <div class="info-value"><?php echo e($pelatih->cabangOlahraga->nama_cabor ?? '-'); ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Email</div>
                    <div class="info-value"><?php echo e($pelatih->email ?? '-'); ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">No Telepon</div>
                    <div class="info-value"><?php echo e($pelatih->no_telepon ?? '-'); ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Tempat Lahir</div>
                    <div class="info-value"><?php echo e($pelatih->tempat_lahir ?? '-'); ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Tanggal Lahir</div>
                    <div class="info-value"><?php echo e($pelatih->tanggal_lahir ? \Carbon\Carbon::parse($pelatih->tanggal_lahir)->format('d/m/Y') : '-'); ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Jenis Kelamin</div>
                    <div class="info-value"><?php echo e($pelatih->jenis_kelamin); ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Ketersediaan</div>
                    <div class="info-value"><?php echo e($pelatih->ketersediaan); ?></div>
                </div>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="section-title">ALAMAT</div>
        <div class="info-row">
            <div class="info-label">Alamat</div>
            <div class="info-value"><?php echo e($pelatih->alamat ?? '-'); ?></div>
        </div>
        <div class="info-row">
            <div class="info-label">Kota</div>
            <div class="info-value"><?php echo e($pelatih->alamatkota ?? '-'); ?></div>
        </div>
        <div class="info-row">
            <div class="info-label">Provinsi</div>
            <div class="info-value"><?php echo e($pelatih->alamatprovinsi ?? '-'); ?></div>
        </div>
    </div>

    <div class="footer">
        Dicetak pada: <?php echo e(\Carbon\Carbon::now()->format('d/m/Y H:i:s')); ?>

    </div>
</body>
</html>
<?php /**PATH C:\Users\ThinkPad\OneDrive\Dokumen\GitHub\web-koni\resources\views/admin/pelatih/pdf-export.blade.php ENDPATH**/ ?>