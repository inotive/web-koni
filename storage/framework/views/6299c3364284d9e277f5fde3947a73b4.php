


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
    </style>
</head>
<body>
    <div class="header">
        <h1>DATA DETAIL PELATIH</h1>
    </div>

    <div class="section">
        <div class="section-title">INFORMASI PRIBADI</div>
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

<?php /**PATH /home/thur/Documents/Inotive/web-koni/resources/views/admin/pelatih/pdf-export.blade.php ENDPATH**/ ?>