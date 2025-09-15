<!DOCTYPE html>
<html>
<head>
    <title>Laporan LPJ - {{ $kegiatanLainnya->nama_program }}</title>
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
            max-height: 200px;
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

        .photos img,
        .photo-container img {
            display: block;
            margin: 0 auto;
            max-width: 100%;
            max-height: 100%; /* Larger size for PDF */
            border-radius: 6px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
            object-fit: contain; /* Changed from cover to contain to preserve aspect ratio */
        }

        @media print {
            .photo-container img {
                max-height: none !important; /* Remove height restriction on PDF */
                width: auto !important; /* Maintain original aspect ratio */
                height: auto !important; /* Maintain original aspect ratio */
            }
        }

    </style>
</head>
<body>
    <!-- Letterhead that appears on every page -->
    <div class="letterhead">
        @php
            $imagePath = public_path('assets/img/kob-nobg.png');
            $imageData = base64_encode(file_get_contents($imagePath));
            $imageSrc = 'data:image/png;base64,' . $imageData;
        @endphp
        <img src="{{ $imageSrc }}"
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
                    <td>{{ $kegiatanLainnya->nama_program }}</td>
                </tr>
                <tr>
                    <th>Kegiatan</th>
                    <td>{{ $kegiatanLainnya->nama_kegiatan }}</td>
                </tr>
                <tr>
                    <th>Total Anggaran</th>
                    <td class="amount">Rp {{ number_format($kegiatanLainnya->jumlah_harga, 2, ',', '.') }}</td>
                </tr>
                @if($kegiatanLainnya->volume)
                <tr>
                    <th>Volume</th>
                    <td>{{ $kegiatanLainnya->volume }}</td>
                </tr>
                @endif
                @if($kegiatanLainnya->jumlah_harga_satuan)
                <tr>
                    <th>Harga Satuan</th>
                    <td>Rp {{ number_format($kegiatanLainnya->jumlah_harga_satuan, 2, ',', '.') }}</td>
                </tr>
                @endif
                @if($kegiatanLainnya->keterangan_tambahan)
                <tr>
                    <th>Keterangan Tambahan</th>
                    <td>{{ $kegiatanLainnya->keterangan_tambahan }}</td>
                </tr>
                @endif
            </table>

            @if($kegiatanLainnya->foto_jurnal && count($kegiatanLainnya->foto_jurnal) > 0)
                <h3 class="section-title">Dokumentasi Kegiatan</h3>
                <table class="photo-table">
                    <tr>
                        @foreach($kegiatanLainnya->foto_jurnal as $index => $foto)
                            @php
                                $path = is_array($foto) ? ($foto['path'] ?? '') : $foto;
                                $originalName = is_array($foto) ? 
                                               ($foto['original_name'] ?? basename($path)) : 
                                               basename($path);
                            @endphp
                            
                            @if($path && file_exists(storage_path('app/public/' . $path)))
                                <td class="photo-td">
                                    <div class="photo-container">
                                        <img src="{{ storage_path('app/public/' . $path) }}" alt="{{ $originalName }}">
                                        <div class="photo-caption">{{ $originalName }}</div>
                                    </div>
                                </td>
                                @if(($index + 1) % 3 == 0)
                                    </tr><tr> <!-- Start new row every 3 images -->
                                @endif
                            @endif
                        @endforeach
                    </tr>
                </table>
            @endif

            @if(($kegiatanLainnya->dokumen_lpj && count($kegiatanLainnya->dokumen_lpj) > 0) || 
                ($kegiatanLainnya->dokumen_lpj_pdf))
                <h3 class="section-title">Dokumen Pendukung</h3>
                
                @if($kegiatanLainnya->dokumen_lpj_pdf)
                    @php
                        $path = is_array($kegiatanLainnya->dokumen_lpj_pdf) ? 
                                ($kegiatanLainnya->dokumen_lpj_pdf['path'] ?? '') : 
                                $kegiatanLainnya->dokumen_lpj_pdf;
                        $originalName = is_array($kegiatanLainnya->dokumen_lpj_pdf) ? 
                                       ($kegiatanLainnya->dokumen_lpj_pdf['original_name'] ?? basename($path)) : 
                                       basename($path);
                    @endphp
                    
                    @if($path && file_exists(storage_path('app/public/' . $path)))
                        <div class="mb-3">
                            <label class="fw-semibold text-dark mb-2 d-block">
                                <i class="fas fa-file-pdf text-danger me-1"></i>Dokumen LPJ (PDF):
                            </label>
                            <div class="bg-light p-3 rounded">
                                <div class="d-flex align-items-center p-2 border rounded bg-white">
                                    <i class="fas fa-file-pdf text-danger me-3" style="font-size: 1.2em;"></i>
                                    <div class="flex-grow-1">
                                        <div class="fw-medium text-dark">{{ $originalName }}</div>
                                        <small class="text-muted">PDF</small>
                                    </div>
                                    <a href="{{ storage_path('app/public/' . $path) }}"
                                       target="_blank"
                                       class="btn btn-outline-danger btn-sm">
                                        <i class="fas fa-download me-1"></i>Unduh
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif

                @if($kegiatanLainnya->dokumen_lpj && count($kegiatanLainnya->dokumen_lpj) > 0)
                    <div class="d-flex flex-column gap-2">
                        @foreach($kegiatanLainnya->dokumen_lpj as $dokumen)
                            @php
                                $path = is_array($dokumen) ? ($dokumen['path'] ?? '') : $dokumen;
                                $originalName = is_array($dokumen) ? 
                                               ($dokumen['original_name'] ?? basename($path)) : 
                                               basename($path);
                                $extension = pathinfo($originalName, PATHINFO_EXTENSION);
                                
                                $iconClass = 'fas fa-file text-secondary';
                                if ($extension === 'pdf') $iconClass = 'fas fa-file-pdf text-danger';
                                else if (in_array($extension, ['doc', 'docx'])) $iconClass = 'fas fa-file-word text-primary';
                                else if (in_array($extension, ['xls', 'xlsx'])) $iconClass = 'fas fa-file-excel text-success';
                                else if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) $iconClass = 'fas fa-file-image text-info';
                            @endphp
                            
                            @if($path && file_exists(storage_path('app/public/' . $path)))
                                <div class="d-flex align-items-center p-2 border rounded bg-light">
                                    <i class="{{ $iconClass }} me-3" style="font-size: 1.2em;"></i>
                                    <div class="flex-grow-1">
                                        <div class="fw-medium text-dark">{{ $originalName }}</div>
                                        <small class="text-muted">{{ strtoupper($extension) }}</small>
                                    </div>
                                    <a href="{{ storage_path('app/public/' . $path) }}"
                                       target="_blank"
                                       class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-download me-1"></i>Unduh
                                    </a>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif
            @endif
        </div>
    </div>
</body>
</html>