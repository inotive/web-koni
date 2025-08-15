<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h2 { color: #333; }
        .date { text-align: right; margin-bottom: 10px; font-size: 12px; }
        .page-break { page-break-after: always; }
    </style>
</head>
<body>
    <div class="header">
        <h2>{{ $title }}</h2>
    </div>
    
    <div class="date">
        Dicetak pada: {{ now()->format('d F Y H:i:s') }}
    </div>
    
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Program & Kegiatan</th>
                <th>Jenis Kegiatan</th>
                <th>Volume</th>
                <th>Harga Satuan</th>
                <th>Total Harga</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->nama_program_kegiatan }}</td>
                <td>{{ $item->jenis_kegiatan ?? '-' }}</td>
                <td>{{ $item->volume }}</td>
                <td>Rp {{ number_format($item->jumlah_harga_satuan, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($item->jumlah_harga, 0, ',', '.') }}</td>
                <td>{{ $item->created_at->format('d M Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>