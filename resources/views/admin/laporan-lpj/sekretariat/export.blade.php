<!DOCTYPE html>
<html>
<head>
    <title>Laporan LPJ - {{ $sekretariat->nama_program }}</title>
    <meta charset="UTF-8">
    <style>
       @page {
            margin: 4cm 1.5cm 1.5cm 1.5cm; /* Increased top margin for header */
        }

        body {
            font-family: 'Times New Roman', serif;
            font-size: 12pt;
            line-height: 1.5;
            margin: 0;
            padding: 0;
            color: #333;
        }

        /* --- HEADER --- */
        header {
            position: fixed;
            top: -3.5cm;
            left: 0cm;
            right: 0cm;
            height: 3cm;
            text-align: center;
        }

        header img {
            width: 100%;
            max-height: 3cm;
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
            page-break-inside: avoid; /* Try to avoid breaking table across pages */
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
    <header>
        <img src="{{ public_path('assets/img/kop-nobg.png') }}" alt="KONI Letterhead">
    </header>

    <main>
        <!-- MAIN CONTENT -->
        <div class="content">
            <h3 class="section-title">Detail Program dan Kegiatan</h3>
            <table class="info-table">
                <tr>
                    <th>Program</th>
                    <td>{{ $sekretariat->nama_program }}</td>
                </tr>
                <tr>
                    <th>Kegiatan</th>
                    <td>{{ $sekretariat->nama_kegiatan }}</td>
                </tr>
                <tr>
                    <th>Total Anggaran</th>
                    <td class="amount">Rp {{ number_format($sekretariat->jumlah_harga, 2, ',', '.') }}</td>
                </tr>
                @if($sekretariat->tanggal_kegiatan)
                <tr>
                    <th>Tanggal Kegiatan</th>
                    <td>{{ \Carbon\Carbon::parse($sekretariat->tanggal_kegiatan)->format('d F Y') }}</td>
                </tr>
                @endif
                @if($sekretariat->lokasi_kegiatan)
                <tr>
                    <th>Lokasi</th>
                    <td>{{ $sekretariat->lokasi_kegiatan }}</td>
                </tr>
                @endif
                @if($sekretariat->keterangan_tambahan)
                <tr>
                    <th>Keterangan Tambahan</th>
                    <td>{{ $sekretariat->keterangan_tambahan }}</td>
                </tr>
                @endif
            </table>

            @if($sekretariat->foto_jurnal && count($sekretariat->foto_jurnal) > 0)
                <h3 class="section-title">Dokumentasi Kegiatan</h3>
                <table class="photo-table">
                    <tr>
                        @foreach($sekretariat->foto_jurnal as $index => $foto)
                            @if(is_array($foto))
                                @php
                                    $path = $foto['path'] ?? '';
                                    $originalName = $foto['original_name'] ?? basename($path);
                                @endphp
                            @else
                                @php
                                    $path = $foto;
                                    $originalName = basename($path);
                                @endphp
                            @endif
                            
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
        </div>
    </main>
</body>
</html>
