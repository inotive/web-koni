<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Label Arsip</title>
    <style>
        @page {
            margin: 12mm;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            color: #222;
        }

        table.grid {
            width: 100%;
            border-collapse: separate;
            border-spacing: 4mm;
        }

        td.label {
            width: 50%;
            border: 1px dashed #888;
            padding: 3mm;
            vertical-align: top;
            height: 38mm;
        }

        .qr {
            width: 30mm;
            height: 30mm;
        }

        .judul {
            font-size: 8px;
            text-transform: uppercase;
            color: #1F6B5A;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .kode {
            font-size: 15px;
            font-weight: bold;
            margin: 1mm 0;
        }

        .nama {
            font-size: 11px;
            margin-bottom: 1mm;
        }

        .sub {
            font-size: 8px;
            color: #666;
        }

        .instansi {
            font-size: 7px;
            color: #999;
            margin-top: 2mm;
        }
    </style>
</head>

<body>
    <table class="grid">
        @foreach ($labels->chunk(2) as $row)
            <tr>
                @foreach ($row as $label)
                    <td class="label">
                        <table width="100%">
                            <tr>
                                <td style="width: 32mm; vertical-align: top;">
                                    <img src="{{ $label['qr'] }}" class="qr">
                                </td>
                                <td style="vertical-align: top;">
                                    <div class="judul">{{ $label['judul'] }}</div>
                                    <div class="kode">{{ $label['kode'] }}</div>
                                    <div class="nama">{{ \Illuminate\Support\Str::limit($label['nama'], 80) }}</div>
                                    @if ($label['sub'])
                                        <div class="sub">{{ $label['sub'] }}</div>
                                    @endif
                                    <div class="instansi">SIMPATI · Arsip DINKES</div>
                                </td>
                            </tr>
                        </table>
                    </td>
                @endforeach
                @if ($row->count() < 2)
                    <td></td>
                @endif
            </tr>
        @endforeach
    </table>
</body>

</html>
