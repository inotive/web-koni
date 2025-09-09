<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Sekretariat - {{ $sekretariat->nama_program }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            font-size: 12pt;
        }
        
        @page {
            margin: 80px 50px 30px 50px;
            header: page-header;
            footer: page-footer;
        }
        
        #header {
            position: fixed;
            top: -60px;
            left: 0;
            right: 0;
            height: 80px;
            text-align: center;
            border-bottom: 3px solid #2c3e50;
        }
        
        #footer {
            position: fixed;
            bottom: -30px;
            left: 0;
            right: 0;
            height: 50px;
            text-align: center;
            font-size: 10pt;
            color: #7f8c8d;
            border-top: 1px solid #eee;
            padding-top: 5px;
        }
        
        .page-number:before {
            content: "Halaman " counter(page);
        }
        
        .kop-surat {
            text-align: center;
            margin-bottom: 10px;
        }
        
        .kop-surat h1 {
            font-size: 18pt;
            margin: 0;
            color: #2c3e50;
            font-weight: 600;
            letter-spacing: 1px;
        }
        
        .kop-surat h2 {
            font-size: 15pt;
            margin: 5px 0;
            color: #34495e;
            font-weight: 500;
        }
        
        .kop-surat p {
            font-size: 10pt;
            margin: 2px 0;
            color: #7f8c8d;
        }
        
        .divider {
            border-top: 1px solid #bdc3c7;
            margin: 15px 0;
        }
        
        .content {
            margin-top: 20px;
        }
        
        .section {
            margin-bottom: 25px;
        }
        
        .section-title {
            font-size: 14pt;
            font-weight: 600;
            margin-bottom: 15px;
            color: #2c3e50;
            border-bottom: 2px solid #3498db;
            padding-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .info-table th {
            background-color: #ecf0f1;
            padding: 12px 15px;
            text-align: left;
            font-weight: 600;
            width: 30%;
            border: 1px solid #bdc3c7;
            color: #2c3e50;
        }
        
        .info-table td {
            padding: 12px 15px;
            border: 1px solid #bdc3c7;
            background-color: #fff;
        }
        
        .foto-container {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 15px;
        }
        
        .foto-item {
            width: 140px;
            border: 1px solid #bdc3c7;
            padding: 10px;
            text-align: center;
            background-color: #fff;
            border-radius: 6px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            transition: transform 0.2s;
        }
        
        .foto-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }
        
        .foto-item img {
            max-width: 100%;
            height: 110px;
            object-fit: cover;
            border-radius: 4px;
            border: 1px solid #eee;
        }
        
        .foto-item .foto-name {
            font-size: 9pt;
            margin-top: 8px;
            color: #34495e;
            word-break: break-word;
            font-weight: 500;
        }
        
        .dokumen-container {
            margin-top: 15px;
        }
        
        .dokumen-item {
            padding: 15px;
            border: 1px solid #bdc3c7;
            margin-bottom: 12px;
            background-color: #fff;
            border-left: 4px solid #3498db;
            border-radius: 0 4px 4px 0;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        
        .dokumen-item .dokumen-name {
            font-size: 11pt;
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .dokumen-item .dokumen-path {
            font-size: 9pt;
            color: #7f8c8d;
            font-style: italic;
        }
        
        .no-data {
            font-style: italic;
            color: #95a5a6;
            text-align: center;
            padding: 25px;
            background-color: #f8f9fa;
            border: 1px dashed #bdc3c7;
            border-radius: 6px;
            margin: 10px 0;
        }
        
        .keterangan {
            background-color: #e3f2fd;
            padding: 15px;
            border-left: 4px solid #2196f3;
            margin-top: 10px;
            border-radius: 0 4px 4px 0;
            font-size: 10pt;
        }
        
        .keterangan strong {
            color: #0d47a1;
        }
        
        .page-break {
            page-break-before: always;
        }
        
        .footer-note {
            font-size: 9pt;
            color: #95a5a6;
            text-align: center;
            margin-top: 30px;
            font-style: italic;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 4px;
        }
        
        /* Icon styling */
        .section-title:before {
            content: "▸ ";
            color: #3498db;
        }
    </style>
</head>
<body>
    <htmlpageheader name="page-header">
        <div class="kop-surat">
            <h1>KOMITE OLAHRAGA NASIONAL INDONESIA</h1>
            <h2>KONI KABUPATEN/KOTA</h2>
            <p>Alamat: Jl. Contoh Alamat No. 123, Kota/Kabupaten</p>
            <p>Telp: (021) 12345678 | Email: info@konikotakab.go.id</p>
        </div>
        <div class="divider"></div>
    </htmlpageheader>

    <htmlpagefooter name="page-footer">
        <div class="page-number"></div>
    </htmlpagefooter>

    <div class="content">
        <div class="section">
            <div class="section-title">Informasi Kegiatan</div>
            <table class="info-table">
                <tr>
                    <th>Nama Program</th>
                    <td>{{ $sekretariat->nama_program }}</td>
                </tr>
                
                @if($sekretariat->nama_kegiatan)
                <tr>
                    <th>Nama Kegiatan</th>
                    <td>{{ $sekretariat->nama_kegiatan }}</td>
                </tr>
                @endif
                
                @if($sekretariat->volume)
                <tr>
                    <th>Volume</th>
                    <td>{{ $sekretariat->volume }}</td>
                </tr>
                @endif
                
                @if($sekretariat->jumlah_harga_satuan)
                <tr>
                    <th>Harga Satuan</th>
                    <td>Rp {{ number_format($sekretariat->jumlah_harga_satuan, 0, ',', '.') }}</td>
                </tr>
                @endif
                
                @if($sekretariat->jumlah_harga)
                <tr>
                    <th>Total Anggaran</th>
                    <td>Rp {{ number_format($sekretariat->jumlah_harga, 0, ',', '.') }}</td>
                </tr>
                @endif
                
                @if($sekretariat->keterangan_tambahan)
                <tr>
                    <th>Keterangan Tambahan</th>
                    <td>{{ $sekretariat->keterangan_tambahan }}</td>
                </tr>
                @endif
            </table>
        </div>

        <div class="section">
            <div class="section-title">Lampiran Foto Jurnal</div>
            @if($sekretariat->foto_jurnal && count($sekretariat->foto_jurnal) > 0)
                <div class="foto-container">
                    @foreach($sekretariat->foto_jurnal as $foto)
                        @php
                            $path = '';
                            $originalName = '';
                            
                            if (is_object($foto)) {
                                $path = $foto->path;
                                $originalName = $foto->original_name ?? basename($path);
                            } elseif (is_array($foto)) {
                                $path = isset($foto['path']) ? $foto['path'] : '';
                                $originalName = isset($foto['original_name']) ? $foto['original_name'] : (is_string($path) ? basename($path) : '');
                            } elseif (is_string($foto)) {
                                $path = $foto;
                                $originalName = basename($path);
                            }
                            
                            // Check if file exists
                            $fileExists = $path && Storage::disk('public')->exists($path);
                        @endphp
                        
                        @if($fileExists)
                            <div class="foto-item">
                                <img src="{{ storage_path('app/public/' . $path) }}" alt="Foto Jurnal">
                                <div class="foto-name">{{ $originalName }}</div>
                            </div>
                        @else
                            <div class="foto-item">
                                <div style="height: 110px; display: flex; align-items: center; justify-content: center; background-color: #f8f9fa; border: 1px solid #eee; border-radius: 4px;">
                                    <span style="color: #95a5a6; font-size: 9pt;">Gambar tidak tersedia</span>
                                </div>
                                <div class="foto-name">{{ $originalName }}</div>
                            </div>
                        @endif
                    @endforeach
                </div>
            @else
                <div class="no-data">Tidak ada foto jurnal tersedia</div>
            @endif
        </div>

        <div class="section">
            <div class="section-title">Dokumen Pendukung</div>
            @if($sekretariat->dokumen_lpj && count($sekretariat->dokumen_lpj) > 0)
                <div class="dokumen-container">
                    @foreach($sekretariat->dokumen_lpj as $dokumen)
                        @php
                            $path = '';
                            $originalName = '';
                            
                            if (is_object($dokumen)) {
                                $path = $dokumen->path;
                                $originalName = $dokumen->original_name ?? basename($path);
                            } elseif (is_array($dokumen)) {
                                $path = isset($dokumen['path']) ? $dokumen['path'] : '';
                                $originalName = isset($dokumen['original_name']) ? $dokumen['original_name'] : (is_string($path) ? basename($path) : '');
                            } elseif (is_string($dokumen)) {
                                $path = $dokumen;
                                $originalName = basename($path);
                            }
                            
                            // Check if file exists
                            $fileExists = $path && Storage::disk('public')->exists($path);
                        @endphp
                        
                        @if($path)
                            <div class="dokumen-item">
                                <div class="dokumen-name">{{ $originalName }}</div>
                                <div class="dokumen-path">{{ $fileExists ? 'File tersedia' : 'File tidak ditemukan' }}</div>
                            </div>
                        @endif
                    @endforeach
                </div>
            @else
                <div class="no-data">Tidak ada dokumen pendukung tersedia</div>
            @endif
        </div>

        <div class="section">
            <div class="section-title">Dokumen LPJ</div>
            @if($sekretariat->dokumen_lpj_pdf)
                @php
                    $path = '';
                    $originalName = '';
                    
                    if (is_object($sekretariat->dokumen_lpj_pdf)) {
                        $path = $sekretariat->dokumen_lpj_pdf->path;
                        $originalName = $sekretariat->dokumen_lpj_pdf->original_name ?? basename($path);
                    } elseif (is_array($sekretariat->dokumen_lpj_pdf)) {
                        $path = isset($sekretariat->dokumen_lpj_pdf['path']) ? $sekretariat->dokumen_lpj_pdf['path'] : '';
                        $originalName = isset($sekretariat->dokumen_lpj_pdf['original_name']) ? $sekretariat->dokumen_lpj_pdf['original_name'] : (is_string($path) ? basename($path) : '');
                    } elseif (is_string($sekretariat->dokumen_lpj_pdf)) {
                        $path = $sekretariat->dokumen_lpj_pdf;
                        $originalName = basename($path);
                    }
                    
                    // Check if file exists
                    $fileExists = $path && Storage::disk('public')->exists($path);
                @endphp
                
                @if($path)
                    <div class="dokumen-item">
                        <div class="dokumen-name">{{ $originalName }}</div>
                        <div class="dokumen-path">{{ $fileExists ? 'File PDF tersedia sebagai lampiran' : 'File PDF tidak ditemukan' }}</div>
                    </div>
                    <div class="keterangan">
                        <strong>Catatan:</strong> File PDF ini {{ $fileExists ? 'dapat diakses terpisah sebagai bagian dari laporan' : 'tidak tersedia' }}
                    </div>
                @endif
            @else
                <div class="no-data">Tidak ada dokumen LPJ tersedia</div>
            @endif
        </div>
        
        <div class="footer-note">
            Dokumen ini dicetak pada {{ date('d F Y H:i') }} dan merupakan laporan resmi kegiatan sekretariat.
        </div>
    </div>
</body>
</html>