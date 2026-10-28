<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>{{ $pemusnahan->nomor_berita_acara }}</title>
    <style>
        @page {
            margin: 18mm 16mm;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10.5px;
            color: #222;
            line-height: 1.5;
        }

        h2 {
            text-align: center;
            margin: 0;
            font-size: 14px;
            text-transform: uppercase;
        }

        .nomor {
            text-align: center;
            margin-bottom: 18px;
        }

        table.data {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0 20px;
        }

        table.data th,
        table.data td {
            border: 1px solid #555;
            padding: 4px 6px;
            vertical-align: top;
        }

        table.data th {
            background: #eee;
            font-size: 9.5px;
        }

        .ttd {
            width: 100%;
            margin-top: 30px;
        }

        .ttd td {
            width: 50%;
            text-align: center;
            vertical-align: top;
        }
    </style>
</head>

<body>
    @php $isMusnah = $pemusnahan->jenis === 'musnah'; @endphp

    @include('admin.surat-kop._kop-default')

    <h2>Berita Acara {{ $isMusnah ? 'Pemusnahan Arsip' : 'Penyerahan Arsip Statis (Permanen)' }}</h2>
    <div class="nomor">Nomor: {{ $pemusnahan->nomor_berita_acara }}</div>

    <p>
        Pada hari ini, {{ $pemusnahan->tanggal->translatedFormat('l, d F Y') }}, telah dilakukan
        {{ $isMusnah ? 'pemusnahan' : 'penyerahan sebagai arsip permanen' }} terhadap
        {{ $pemusnahan->arsip->count() }} arsip yang telah habis masa retensinya sesuai Jadwal Retensi Arsip,
        dengan rincian sebagai berikut:
    </p>

    <table class="data">
        <thead>
            <tr>
                <th style="width: 22px">No</th>
                <th>Nomor Arsip</th>
                <th>Judul / Perihal</th>
                <th>Klasifikasi</th>
                <th>Tanggal</th>
                <th>Jumlah</th>
                <th>Lokasi Asal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pemusnahan->arsip->sortBy('nomor_arsip')->values() as $i => $a)
                <tr>
                    <td style="text-align: center">{{ $i + 1 }}</td>
                    <td>{{ $a->nomor_arsip }}</td>
                    <td>{{ $a->judul }}</td>
                    <td>{{ $a->kategori?->kode_klasifikasi }}</td>
                    <td>{{ $a->tanggal_arsip->format('d/m/Y') }}</td>
                    <td>{{ $a->jumlah }} {{ $a->satuan }}</td>
                    <td>{{ $a->lokasi?->kode_lengkap ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @if ($pemusnahan->keterangan)
        <p><b>Keterangan:</b><br>{!! nl2br(e($pemusnahan->keterangan)) !!}</p>
    @endif

    <p>Demikian berita acara ini dibuat dengan sebenarnya untuk dipergunakan sebagaimana mestinya.</p>

    <table class="ttd">
        <tr>
            <td>
                Yang Melaksanakan,<br><br><br><br><br>
                ( {{ $pemusnahan->user?->username ?? '..............................' }} )
            </td>
            <td>
                Mengetahui,<br><br><br><br><br>
                ( .............................. )
            </td>
        </tr>
    </table>
</body>

</html>
