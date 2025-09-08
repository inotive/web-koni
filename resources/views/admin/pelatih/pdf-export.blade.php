<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>CV - {{ $pelatih->nama }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background: #fff;
        }

        .container {
            max-width: 210mm;
            margin: 0 auto;
            padding: 30px;
            min-height: 297mm;
        }

        .header {
            text-align: center;
            padding: 30px 0;
            background-color: #F8285A;
            color: white;
            margin: -30px -30px 30px -30px;
        }

        .photo {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid white;
            margin-bottom: 20px;
        }

        .name {
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .cabor {
            font-size: 18px;
            margin-bottom: 20px;
            opacity: 0.9;
        }

        .contact-info {
            display: flex;
            justify-content: center;
            gap: 30px;
            flex-wrap: wrap;
            font-size: 14px;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .section {
            margin-bottom: 30px;
            background: white;
            padding: 25px;
            border-radius: 8px;
            border-left: 4px solid #F8285A;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .section-title {
            font-size: 20px;
            font-weight: bold;
            color: #F8285A;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .info-item {
            padding: 15px 0;
            border-bottom: 1px solid #eee;
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-label {
            font-weight: bold;
            color: #555;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .info-value {
            color: #333;
            font-size: 15px;
        }

        .highlight {
            background-color: #F8285A;
            color: white;
            padding: 4px 12px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: bold;
            display: inline-block;
        }

        @media print {
            .container {
                margin: 0;
                padding: 20px;
                max-width: none;
                width: 100%;
            }

            .header {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }

        @media (max-width: 768px) {
            .info-grid {
                grid-template-columns: 1fr;
            }

            .contact-info {
                flex-direction: column;
                gap: 10px;
            }

            .name {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            @if ($pelatih->foto)
                <img src="{{ public_path('storage/' . $pelatih->foto) }}" alt="Foto" class="photo">
            @endif
            <h1 class="name">{{ $pelatih->nama }}</h1>
            <p class="cabor">{{ $pelatih->cabangOlahraga->nama_cabor ?? 'Pelatih Olahraga' }}</p>

            <div class="contact-info">
                @if($pelatih->email)
                <div class="contact-item">
                    <span>{{ $pelatih->email }}</span>
                </div>
                @endif

                @if($pelatih->no_telepon)
                <div class="contact-item">
                    <span>{{ $pelatih->no_telepon }}</span>
                </div>
                @endif
            </div>
        </div>

        <div class="section">
            <h2 class="section-title">Informasi Pribadi</h2>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Tempat, Tanggal Lahir</div>
                    <div class="info-value">{{ $pelatih->tempat_lahir }}, {{ \Carbon\Carbon::parse($pelatih->tanggal_lahir)->format('d F Y') }}</div>
                </div>

                <div class="info-item">
                    <div class="info-label">Usia</div>
                    <div class="info-value">
                        <span class="highlight">{{ \Carbon\Carbon::parse($pelatih->tanggal_lahir)->age }} Tahun</span>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-label">Jenis Kelamin</div>
                    <div class="info-value">{{ $pelatih->kelamin }}</div>
                </div>

                <div class="info-item">
                    <div class="info-label">Cabang Olahraga</div>
                    <div class="info-value">{{ $pelatih->cabangOlahraga->nama_cabor ?? '-' }}</div>
                </div>

                <div class="info-item">
                    <div class="info-label">Ketersediaan</div>
                    <div class="info-value">
                        <span class="highlight">{{ $pelatih->ketersediaan }}</span>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-label">Alamat</div>
                    <div class="info-value">{{ collect([$pelatih->alamat, $pelatih->alamatkota, $pelatih->alamatprovinsi])->filter()->implode(', ') }}</div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
