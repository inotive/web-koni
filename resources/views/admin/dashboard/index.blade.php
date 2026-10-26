@extends('layouts.app')

@push('stack-css')
    <style>
        body {
            background-color: #f5f5f5;
        }

        .progress-bar span {
            font-size: 14px;
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
            height: 45px;
        }

        .info-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.175);
            padding: 24px;
            transition: all 0.2s ease-in-out;
            margin-bottom: 1rem;
        }

        /* Apply info-card styling to all Bootstrap cards */
        .card {
            border-radius: 12px !important;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.175) !important;
            transition: all 0.2s ease-in-out;
        }

        .card.shadow-sm {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.175) !important;
        }

        .info-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 18px;
            margin-bottom: 12px;
        }

        .info-value {
            font-size: 20px;
            font-weight: 700;
            color: #151D48;
            margin-bottom: 4px;
        }

        .info-label {
            font-size: 14px;
            color: #A3AED0;
        }

        .dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            display: inline-block;
        }

        .title-kegiatan {
            font-size: 15px;
            font-weight: 600;
            white-space: normal;
            word-break: break-word;
            display: block;
            max-width: 220px;
        }

        .text-bronze {
            color: #CD7F32 !important;
        }

        /* Pagination Styles */
               .pagination {
            margin-bottom: 0;
        }

        .pagination .page-item {
            margin: 0 1px;
        }

        .pagination-sm .page-link {
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
            border-radius: 4px;
            border: 1px solid #dee2e6;
            color: #6c757d;
            margin: 0 2px;
        }

        .pagination-sm .page-item.active .page-link {
            background-color: #1F6B5A;
            border-color: #1F6B5A;
            color: white;
        }

        .pagination-sm .page-link:hover {
            background-color: #f8f9fa;
            border-color: #dee2e6;
            color: #495057;
        }

        .pagination-sm .page-item.disabled .page-link {
            color: #6c757d;
            background-color: #fff;
            border-color: #dee2e6;
        }

        /* Simple Pagination Styles */
        .simple-pagination .page-link {
            border: none !important;
            margin: 0 2px;
            border-radius: 4px !important;
            padding: 6px 12px !important;
            color: #6c757d !important;
            background-color: #f8f9fa !important;
            transition: all 0.2s ease;
        }

        .simple-pagination .page-link:hover {
            background-color: #e9ecef !important;
            color: #495057 !important;
        }

        .simple-pagination .page-item.active .page-link {
            background-color: #007bff !important;
            color: white !important;
        }

        .simple-pagination .page-link:focus {
            box-shadow: none !important;
        }

        /* Pagination Arrows and Numbers */
        .pagination-arrow {
            color: #6c757d;
            text-decoration: none;
            padding: 6px 8px;
            transition: color 0.2s ease;
            cursor: pointer;
        }

        .pagination-arrow:hover {
            color: #0b0b0b;
            text-decoration: none;
        }

        .pagination-arrow.disabled {
            color: #adb5bd;
            cursor: not-allowed;
            opacity: 0.6;
        }

        .pagination-number {
            color: #6c757d;
            text-decoration: none;
            padding: 6px 10px;
            margin: 0 1px;
            border-radius: 4px;
            transition: all 0.2s ease;
            background-color: #f8f9fa;
            border: 1px solid transparent;
            font-size: 0.875rem;
        }

        .pagination-number:hover {
            color: #89add1;
            background-color: #e9ecef;
            text-decoration: none;
        }

        .pagination-number.active {
            background-color: #e4e6e9;
            color: rgb(4, 4, 4);
            border-color: #e0e1e4;
        }

        /* Dropdown icon style */
        .dropdown-icon {
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 4px;
        }

        .dropdown-icon:hover {
            background-color: #e9ecef;
        }

        /* Export specific styles */
        .export-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .export-header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #dee2e6;
        }

        .export-title {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }

        .export-date {
            color: #666;
            font-size: 16px;
        }

        /* Progress bar text styles */
        .progress-bar-text {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 12px;
            pointer-events: none;
            font-size: 12px;
            font-weight: 600;
        }

        /* Tooltip styles */
        .tooltip-inner {
            background-color: #007bff;
            color: white;
            font-size: 0.8rem;
            padding: 0.25rem 0.5rem;
        }

        .tooltip.bs-tooltip-auto[data-popper-placement^=top] .tooltip-arrow::before,
        .tooltip.bs-tooltip-top .tooltip-arrow::before {
            border-top-color: #007bff;
        }

        /* Hide export button during screenshot */
        .hide-for-screenshot {
            visibility: hidden;
        }
    </style>
@endpush

@section('pageTitle', 'Dashboard')

@section('content')
    <div class="container">
        <div class="mb-8">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h2 class="fs-2 mb-1">Selamat Datang, <span class="text-primary">{{ auth()->user()->username }}</span></h2>
                    <p class="text-muted fs-4 mb-0">Platform Digital Administrasi Terintegrasi</p>
                </div>
                <form method="GET" id="yearFilterForm" class="d-flex align-items-center gap-2">
                    <label for="year" class="text-muted mb-0">Tahun:</label>
                    <select name="year" id="year" class="form-select" style="width: 120px" onchange="this.form.submit()">
                        @if (count($availableYears) > 0)
                            @foreach ($availableYears as $year)
                                <option value="{{ $year }}" {{ (string) $year === (string) $selectedYear ? 'selected' : '' }}>{{ $year }}</option>
                            @endforeach
                        @else
                            <option value="{{ now()->year }}" selected>{{ now()->year }}</option>
                        @endif
                    </select>
                </form>
            </div>
        </div>

        @php
            $persen_serapan = $total_rka > 0 ? min(100, round(($total_serapan / $total_rka) * 100)) : 0;
            $persen_berjalan = $total_kegiatan_all > 0 ? min(100, round(($kegiatan_berjalan_all / $total_kegiatan_all) * 100)) : 0;
        @endphp

        {{-- Ringkasan anggaran --}}
        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <div class="info-card text-start h-100">
                    <div class="info-icon" style="background-color: #1F6B5A">
                        <i class="fa-solid fa-clipboard-check" style="color: white;"></i>
                    </div>
                    <div class="info-value">Rp {{ number_format($total_rka, 0, ',', '.') }}</div>
                    <div class="info-label">Total Rencana Kerja & Anggaran (RKA)</div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="info-card text-start position-relative h-100">
                    <div class="position-absolute top-0 end-0 mt-7 me-4 d-flex flex-column align-items-end">
                        <span class="text-primary fw-semibold" style="font-size: 1.1rem;">{{ $persen_serapan }}% Serapan</span>
                        <div class="progress bg-light mt-1 mb-2" style="width: 100px; height: 8px;">
                            <div class="progress-bar bg-primary" style="width: {{ $persen_serapan }}%;"></div>
                        </div>
                        <span class="text-success fw-semibold" style="font-size: 1.1rem;">{{ $persen_berjalan }}% Keg. Berjalan</span>
                        <div class="progress bg-light mt-1" style="width: 100px; height: 8px;">
                            <div class="progress-bar bg-success" style="width: {{ $persen_berjalan }}%;"></div>
                        </div>
                    </div>

                    <div class="info-icon" style="background-color: #2E8B6E">
                        <i class="fa-solid fa-chart-line" style="color: white;"></i>
                    </div>
                    <div class="info-value">Rp {{ number_format($total_serapan, 0, ',', '.') }} / Rp {{ number_format($total_rka, 0, ',', '.') }}</div>
                    <div class="info-label mt-1 d-flex align-items-center gap-2 flex-wrap">
                        <span class="badge bg-success-subtle text-success fw-semibold px-3 py-1 border border-success-subtle">
                            {{ $kegiatan_berjalan_all }} Kegiatan Berjalan
                        </span>
                        <span>/</span>
                        <span class="badge bg-primary-subtle text-primary fw-semibold px-3 py-1 border border-primary-subtle">
                            {{ $total_kegiatan_all }} Target Kegiatan
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Statistik --}}
        <div class="row g-4 mb-4">
            @php
                $stats = [
                    ['icon' => 'fa-solid fa-hospital', 'color' => '#1F6B5A', 'value' => $total_bidang, 'label' => 'Bidang', 'url' => route('admin.laporan-lpj.bidang.index', ['year' => $selectedYear])],
                    ['icon' => 'fa-solid fa-file-invoice', 'color' => '#00796B', 'value' => $total_lpj, 'label' => 'Dokumen LPJ ' . $selectedYear, 'url' => null],
                    ['icon' => 'fa-solid fa-inbox', 'color' => '#0E6E8C', 'value' => $total_surat_masuk, 'label' => 'Surat Masuk ' . $selectedYear, 'url' => route('admin.surat.index')],
                    ['icon' => 'fa-solid fa-paper-plane', 'color' => '#2E7D32', 'value' => $total_surat_keluar, 'label' => 'Surat Keluar ' . $selectedYear, 'url' => route('admin.surat.index')],
                ];
            @endphp
            @foreach ($stats as $stat)
                <div class="col-md-6 col-xl-3">
                    <div class="info-card text-start position-relative h-100">
                        <div class="info-icon" style="background-color: {{ $stat['color'] }}">
                            <i class="{{ $stat['icon'] }}" style="color: white;"></i>
                        </div>
                        <div class="info-value">{{ number_format($stat['value'], 0, ',', '.') }}</div>
                        <div class="info-label">
                            @if ($stat['url'])
                                <a href="{{ $stat['url'] }}" class="stretched-link text-reset text-decoration-none">{{ $stat['label'] }}</a>
                            @else
                                {{ $stat['label'] }}
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Informasi serapan per unit --}}
        <div class="card shadow-sm mb-4">
            <div class="card-body" style="padding: 24px;">
                <div class="d-flex justify-content-between align-items-center mb-10">
                    <div>
                        <h5 class="card-title mb-0 f-3">Informasi Serapan Kegiatan</h5>
                        <h5 class="text-primary mb-0">Tahun {{ $selectedYear }}</h5>
                    </div>
                    <button type="button" id="export-screenshot" class="btn btn-light-primary">
                        <i class="fa-solid fa-download me-1"></i> Export Data
                    </button>
                </div>

                <div id="informasi-kegiatan-content">
                    @forelse ($units as $i => $unit)
                        @php
                            $barClass = $unit['persen'] <= 30 ? 'bar-danger' : ($unit['persen'] <= 60 ? 'bar-warning' : 'bar-success');
                        @endphp
                        <div class="d-flex align-items-center mb-3 gap-3">
                            <div class="d-flex align-items-center justify-content-between" style="min-width: 240px; max-width: 240px;">
                                <a href="{{ $unit['url'] }}" class="title-kegiatan text-reset text-hover-primary">{{ $i + 1 }}. {{ $unit['nama'] }}</a>
                                @if ($unit['subfolders']->isNotEmpty())
                                    <button class="btn btn-sm p-0 border-0 dropdown-icon ms-2" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse-unit-{{ $unit['id'] }}" aria-expanded="false"
                                        title="Lihat rincian folder">
                                        <i class="fas fa-chevron-down text-primary"></i>
                                    </button>
                                @endif
                            </div>
                            <div class="flex-grow-1 position-relative">
                                <div class="progress w-100" style="border-radius: 8px; height: 45px;">
                                    <div class="progress-bar {{ $barClass }}" role="progressbar"
                                        style="width: {{ $unit['persen'] }}%; border-radius: 8px; opacity: 0.8;"
                                        aria-valuenow="{{ $unit['persen'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                                    <div class="position-absolute w-100 h-100 d-flex justify-content-between align-items-center px-3" style="top: 0; left: 0; pointer-events: none;">
                                        <span class="fw-bold" style="color: #151D48;">
                                            Serapan : Rp {{ number_format($unit['serapan'], 0, ',', '.') }} / Rp {{ number_format($unit['target_anggaran'], 0, ',', '.') }}
                                            | {{ $unit['kegiatan'] }}/{{ $unit['target_kegiatan'] }} kegiatan
                                        </span>
                                        <span class="fw-bold" style="color: #151D48;">{{ $unit['persen'] }}%</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if ($unit['subfolders']->isNotEmpty())
                            <div class="collapse" id="collapse-unit-{{ $unit['id'] }}">
                                <div class="card card-body mt-2 mb-4" style="padding: 12px; border-radius: 8px; background: #F4FAF7;">
                                    <h6 class="mb-3"><i class="fa-solid fa-folder-open me-2" style="color:#1F6B5A"></i>Rincian folder {{ $unit['nama'] }}</h6>
                                    @foreach ($unit['subfolders'] as $j => $sub)
                                        @php
                                            $subBar = $sub['persen'] <= 30 ? 'bar-danger' : ($sub['persen'] <= 60 ? 'bar-warning' : 'bar-success');
                                        @endphp
                                        <div class="d-flex align-items-center mb-2 gap-3">
                                            <div style="min-width: 220px; max-width: 220px;">
                                                <span class="small title-kegiatan">{{ chr(65 + ($j % 26)) }}. {{ $sub['nama'] }}</span>
                                            </div>
                                            <div class="flex-grow-1 position-relative">
                                                <div class="progress w-100" style="border-radius: 6px; height: 35px;">
                                                    <div class="progress-bar {{ $subBar }}" role="progressbar"
                                                        style="width: {{ $sub['persen'] }}%; border-radius: 6px; opacity: 0.8;"></div>
                                                    <div class="position-absolute w-100 h-100 d-flex justify-content-between align-items-center px-2" style="top: 0; left: 0; pointer-events: none;">
                                                        <span class="small fw-bold" style="color: #151D48;">
                                                            Rp {{ number_format($sub['serapan'], 0, ',', '.') }} / Rp {{ number_format($sub['target_anggaran'], 0, ',', '.') }}
                                                            | {{ $sub['jumlah_lpj'] }} LPJ
                                                        </span>
                                                        <span class="small fw-bold" style="color: #151D48;">{{ $sub['persen'] }}%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @empty
                        <div class="text-center text-muted py-6">Belum ada data kegiatan.</div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Grafik serapan per unit --}}
        <div class="card shadow-sm mb-4">
            <div class="card-body" style="padding: 24px;">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                    <h5 class="card-title mb-0">Serapan Anggaran per Bidang {{ $selectedYear }}</h5>
                    <div class="d-flex gap-3 align-items-center">
                        <div class="d-flex align-items-center gap-2">
                            <span class="dot" style="background-color: #1F6B5A;"></span>
                            <span class="badge text-gray-700">Serapan</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="dot" style="background-color: #B5D8C8;"></span>
                            <span class="badge text-gray-700">Target Anggaran</span>
                        </div>
                    </div>
                </div>
                <div style="height: 360px;">
                    <canvas id="serapanChart"></canvas>
                </div>
            </div>
        </div>

        {{-- Aktivitas terbaru --}}
        <div class="row g-4 mb-4">
            <div class="col-lg-6">
                <div class="card shadow-sm h-100">
                    <div class="card-body" style="padding: 24px;">
                        <h5 class="mb-5">LPJ Terbaru</h5>
                        @forelse ($latest_lpj as $lpj)
                            <div class="d-flex align-items-center gap-3 py-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                                <span class="d-flex align-items-center justify-content-center rounded-3 flex-shrink-0"
                                    style="width: 40px; height: 40px; background: #E3F1EA;">
                                    <i class="fa-solid fa-file-invoice" style="color: #1F6B5A;"></i>
                                </span>
                                <div class="flex-grow-1 overflow-hidden">
                                    <div class="fw-semibold text-gray-800 text-truncate">{{ $lpj->nama_program }}</div>
                                    <div class="fs-7 text-muted text-truncate">
                                        <i class="fa-regular fa-folder me-1"></i>{{ $lpj->parent?->nama_program ?? '-' }}
                                        · {{ $lpj->created_at?->format('d M Y') }}
                                    </div>
                                </div>
                                <div class="fw-bold text-gray-800 text-nowrap">Rp {{ number_format($lpj->jumlah_harga, 0, ',', '.') }}</div>
                            </div>
                        @empty
                            <div class="text-center text-muted py-6">Belum ada LPJ pada tahun {{ $selectedYear }}.</div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card shadow-sm h-100">
                    <div class="card-body" style="padding: 24px;">
                        <div class="d-flex justify-content-between align-items-center mb-5">
                            <h5 class="mb-0">Surat Masuk Terbaru</h5>
                            <a href="{{ route('admin.surat.index') }}" class="fs-7 fw-semibold">Lihat semua</a>
                        </div>
                        @forelse ($latest_surat_masuk as $surat)
                            <div class="d-flex align-items-center gap-3 py-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                                <span class="d-flex align-items-center justify-content-center rounded-3 flex-shrink-0"
                                    style="width: 40px; height: 40px; background: #E1F0F5;">
                                    <i class="fa-solid fa-envelope-open-text" style="color: #0E6E8C;"></i>
                                </span>
                                <div class="flex-grow-1 overflow-hidden">
                                    <div class="fw-semibold text-gray-800 text-truncate">{{ $surat->nama_kegiatan }}</div>
                                    <div class="fs-7 text-muted text-truncate">{{ $surat->no_surat }}</div>
                                </div>
                                <div class="fs-7 text-muted text-nowrap">{{ $surat->created_at?->format('d M Y') }}</div>
                            </div>
                        @empty
                            <div class="text-center text-muted py-6">Belum ada surat masuk.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('stack-script')
    <!-- html2canvas library for screenshot functionality -->
    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>

    <script>
        const serapanUnits = @json($units->map(fn ($unit) => ['nama' => $unit['nama'], 'serapan' => $unit['serapan'], 'target' => $unit['target_anggaran']])->values());

        new Chart(document.getElementById('serapanChart').getContext('2d'), {
            type: 'bar',
            data: {
                // Nama panjang dipendekkan ke singkatan dalam kurung, mis. "Bidang ... (P2P)" -> "P2P"
                labels: serapanUnits.map(u => (u.nama.match(/\(([^)]+)\)\s*$/) || [null, u.nama])[1]),
                datasets: [{
                        label: 'Serapan',
                        data: serapanUnits.map(u => u.serapan),
                        backgroundColor: '#1F6B5A',
                        borderRadius: 4
                    },
                    {
                        label: 'Target Anggaran',
                        data: serapanUnits.map(u => u.target),
                        backgroundColor: '#B5D8C8',
                        borderRadius: 4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        callbacks: {
                            title: items => serapanUnits[items[0].dataIndex].nama,
                            label: item => item.dataset.label + ': Rp ' + item.parsed.y.toLocaleString('id-ID')
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            color: '#2c3e50',
                            font: {
                                weight: 'bold'
                            }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: value => 'Rp ' + Number(value).toLocaleString('id-ID')
                        }
                    }
                }
            }
        });

        // Initialize tooltips
        [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]')).forEach(function(el) {
            new bootstrap.Tooltip(el);
        });

        // Screenshot functionality for exporting "Informasi Serapan Kegiatan" section
        document.getElementById('export-screenshot').addEventListener('click', function() {
            const targetElement = this.closest('.card');
            const exportButton = this;

            exportButton.classList.add('hide-for-screenshot');

            html2canvas(targetElement, {
                scale: 2,
                useCORS: true,
                backgroundColor: '#ffffff'
            }).then(canvas => {
                exportButton.classList.remove('hide-for-screenshot');

                canvas.toBlob(function(blob) {
                    const link = document.createElement('a');
                    link.href = URL.createObjectURL(blob);
                    link.download = 'informasi-serapan-{{ $selectedYear }}-' + new Date().toISOString().slice(0, 10) + '.png';
                    link.click();
                });
            }).catch(error => {
                exportButton.classList.remove('hide-for-screenshot');
                console.error('Error capturing screenshot:', error);
                alert('Gagal mengekspor data. Silakan coba lagi.');
            });
        });
    </script>
@endpush
