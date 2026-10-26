<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>{{ $meta['nomor_surat'] ?? $template->nama }}</title>
    <style>
        @page {
            margin: 12mm 20mm 18mm 25mm;
        }

        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 12pt;
            color: #000;
            line-height: 1.4;
        }

        .isi p {
            margin: 0 0 8pt;
        }

        .isi table {
            border-collapse: collapse;
        }

        .isi table td,
        .isi table th {
            padding: 2pt 4pt;
            vertical-align: top;
        }

        /* Tabel tanpa garis (tombol "Sembunyikan Garis" di editor) */
        .isi table.tabel-polos,
        .isi table.tabel-polos td,
        .isi table.tabel-polos th {
            border: none !important;
        }

        .isi img {
            max-width: 100%;
        }

        .ttd {
            width: 45%;
            margin-left: 55%;
            margin-top: 10mm;
            page-break-inside: avoid;
        }

        .ttd .ttd-img {
            height: 22mm;
        }

        .ttd .ttd-space {
            height: 22mm;
        }

        .ttd .nama {
            font-weight: bold;
            text-decoration: underline;
        }
    </style>
</head>

<body>
    @if ($kop)
        @include('admin.surat-kop._kop', ['kop' => $kop])
    @endif

    <div class="isi">{!! $isi !!}</div>

    @if ($template->tampilkan_ttd)
        <div class="ttd">
            <div>{{ $template->kota_surat ? $template->kota_surat . ', ' : '' }}{{ $tanggalSurat }}</div>
            <div>{{ $template->penandatangan_jabatan }}</div>
            @if ($ttd)
                <img src="{{ $ttd }}" class="ttd-img">
            @else
                <div class="ttd-space"></div>
            @endif
            <div class="nama">{{ $template->penandatangan_nama }}</div>
            @if ($template->penandatangan_nip)
                <div>{{ $template->penandatangan_nip }}</div>
            @endif
        </div>
    @endif
</body>

</html>
