<!DOCTYPE html>
<html>

<head>
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 12px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #F8285A;
            padding-bottom: 10px;
        }

        .header h2 {
            color: #F8285A;
            margin: 0;
        }

        .header .subtitle {
            color: #666;
            font-size: 14px;
        }

        .info-section {
            margin-bottom: 15px;
        }

        .info-section h3 {
            color: #F8285A;
            font-size: 14px;
            border-bottom: 1px solid #ddd;
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
        }

        .info-value {
            color: #555;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .table th {
            background-color: #F8285A;
            color: white;
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
        }

        .table td {
            padding: 8px;
            border: 1px solid #ddd;
        }

        .financial-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin: 15px 0;
        }

        .financial-box {
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .financial-label {
            font-weight: bold;
            color: #333;
        }

        .financial-value {
            color: #F8285A;
            font-size: 14px;
            font-weight: bold;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 10px;
            color: #666;
        }

        .page-break {
            page-break-after: always;
        }

        .text-right {
            text-align: right;
        }

        .mb-3 {
            margin-bottom: 15px;
        }

        .mt-3 {
            margin-top: 15px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>LAPORAN PERTANGGUNGJAWABAN KEGIATAN LAINNYA</h2>
        <div class="subtitle">Dokumen Resmi LPJ Kegiatan Lainnya</div>
    </div>

    <div class="date text-right" style="margin-bottom: 20px;">
        <strong>Tanggal Cetak:</strong> {{ now()->format('d F Y H:i:s') }}
    </div>

    @foreach($data as $item)
    <div class="info-section">
        <h3>INFORMASI KEGIATAN</h3>
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">Nama Program:</span><br>
                <span class="info-value">{{ $item['nama_program'] ?? 'N/A' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Nama Kegiatan:</span><br>
                <span class="info-value">{{ $item['nama_kegiatan'] ?? '-' }}</span>
            </div>
            <div class="info-item" style="display: none;">
                <span class="info-label">Volume:</span><br>
                <span class="info-value">{{ $item['volume'] ?? '-' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Tempat Kegiatan:</span><br>
                <span class="info-value">{{ $item['tempat_kegiatan'] ?? '-' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Tanggal Kegiatan:</span><br>
                <span class="info-value">
                    @if(!empty($item['tanggal_kegiatan']))
                    {{ \Carbon\Carbon::parse($item['tanggal_kegiatan'])->format('d F Y') }}
                    @else
                    -
                    @endif
                </span>
            </div>
        </div>
    </div>

    @if(!empty($item['jumlah_harga_satuan']) || !empty($item['jumlah_harga']))
    <div class="info-section">
        <h3>RINCIAN ANGGARAN</h3>
        <div class="financial-grid">
            @if(!empty($item['jumlah_harga_satuan']))
            <div class="financial-box" style="display: none;">
                <div class="financial-label">Harga Satuan:</div>
                <div class="financial-value">Rp {{ number_format($item['jumlah_harga_satuan'], 0, ',', '.') }}</div>
            </div>
            @endif

            @if(!empty($item['jumlah_harga']))
            <div class="financial-box">
                <div class="financial-label">Total Anggaran:</div>
                <div class="financial-value">Rp {{ number_format($item['jumlah_harga'], 0, ',', '.') }}</div>
            </div>
            @endif
        </div>
    </div>
    @endif

    @if(!empty($item['sumber_dana']))
    <div class="info-section">
        <h3>SUMBER DANA</h3>
        <div class="info-value">{{ $item['sumber_dana'] }}</div>
    </div>
    @endif

    <div class="info-section">
        <h3>LAMPIRAN</h3>

        <div class="mb-3">
            <div class="info-label">Foto Jurnal:</div>
            <div class="info-value">
                @if(!empty($item['foto_jurnal']) && is_array($item['foto_jurnal']))
                {{ count($item['foto_jurnal']) }} file foto
                @else
                Tidak ada foto
                @endif
            </div>
        </div>

        <div class="mb-3">
            <div class="info-label">Dokumen Pendukung:</div>
            <div class="info-value">
                @if(!empty($item['dokumen_lpj']) && is_array($item['dokumen_lpj']))
                {{ count($item['dokumen_lpj']) }} file dokumen
                @else
                Tidak ada dokumen
                @endif
            </div>
        </div>
    </div>

    @if(!empty($item['keterangan_tambahan']))
    <div class="info-section">
        <h3>KETERANGAN TAMBAHAN</h3>
        <div class="info-value">{{ $item['keterangan_tambahan'] }}</div>
    </div>
    @endif

    <div class="footer">
        <div>Dokumen ini dicetak secara otomatis dari Sistem LPJ</div>
        <div>Halaman {{ $loop->iteration }} dari {{ count($data) }}</div>
    </div>

    @if(!$loop->last)
    <div class="page-break"></div>
    @endif
    @endforeach
</body>

</html>