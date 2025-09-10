<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export Informasi Kegiatan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background-color: #f8f9fa;
        }
        .export-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            padding: 20px;
            margin-bottom: 20px;
        }
        .export-header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #dee2e6;
            padding-bottom: 15px;
        }
        .export-title {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }
        .export-date {
            color: #666;
            font-size: 16px;
        }
        .progress-bar span {
            font-size: 12px;
            white-space: nowrap;
            font-weight: 600;
        }
        .bar-danger {
            background-color: #FF0066;
        }
        .bar-warning {
            background-color: #FFCC00;
        }
        .bar-success {
            background-color: #17C653;
        }
        .progress {
            height: 35px;
            border-radius: 8px;
        }
        .title-kegiatan {
            font-size: 14px;
            font-weight: 600;
            white-space: normal;
            word-break: break-word;
            display: block;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .fw-bold {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="export-container">
        <div class="export-header">
            <h2 class="export-title">Informasi Kegiatan</h2>
            <p class="export-date">Tanggal: {{ date('d F Y') }}</p>
        </div>

        @foreach($kegiatan as $i => $item)
            @php
                // Menggunakan nilai serapan yang sudah dihitung di controller
                $serapan = $item->serapan;
                $total_budget = $item->total_budget;
                // Menangani kasus ketika tidak ada RKA
                $persen = ($total_budget > 0) ? round(($serapan / $total_budget) * 100) : 0;
                // Menampilkan 0 jika tidak ada RKA
                $display_serapan = $serapan;
                $display_budget = $total_rka; // Menampilkan total RKA keseluruhan

                $barClass = 'bar-success';
                if ($persen <= 30) {
                    $barClass = 'bar-danger';
                } elseif ($persen <= 60) {
                    $barClass = 'bar-warning';
                }
            @endphp

            <div class="d-flex align-items-center mb-3 gap-3">
                <div style="min-width: 200px; max-width: 200px;">
                    <span class="title-kegiatan">{{ $i + 1 }}. {{ $item->nama_program }}</span>
                </div>
                <div class="flex-grow-1 position-relative">
                    <div class="progress w-100" style="height: 35px;">
                        <div class="progress-bar {{ $barClass }}" 
                            role="progressbar"
                            style="width: {{ $persen }}%;"
                            aria-valuenow="{{ $persen }}" aria-valuemin="0" aria-valuemax="100">
                        </div>
                        <div class="position-absolute w-100 h-100 d-flex justify-content-between align-items-center px-2" style="top: 0; left: 0; pointer-events: none;">
                            <span class="fw-bold" style="color: #151D48; text-shadow: 0 0 2px rgba(255,255,255,0.3);">
                                Rp {{ number_format($display_serapan, 0, ',', '.') }} / Rp {{ number_format($display_budget, 0, ',', '.') }}
                            </span>
                            <span class="fw-bold" style="color: #151D48; text-shadow: 0 0 2px rgba(255,255,255,0.3);">{{ $persen }}%</span>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <div class="mt-4 text-muted">
            <p><small>Dokumen ini dihasilkan pada {{ date('d F Y H:i:s') }}</small></p>
        </div>
    </div>
</body>
</html>