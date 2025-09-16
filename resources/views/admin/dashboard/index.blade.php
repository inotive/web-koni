@extends('layouts.app')

@push('stack-css')
    <style>
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
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            padding: 24px;
            transition: all 0.2s ease-in-out;
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
            background-color: #F8285A;
            border-color: #F8285A;
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
    </style>
@endpush

@section('pageTitle', 'Dashboard')

@section('content')
    <div class="container">
        <div class="mb-4">
            <div class="mb-4">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div>
                        <h2 class="fs-2 mb-1">Selamat Datang, <span class="text-danger">{{ auth()->user()->name }}</span></h2>
                        <p class="text-muted fs-4 mb-0">Platform Digital Terpusat KONI Tabalong dan Cabang Olahraga</p>
                    </div>
                    <div>
                        <select class="form-select form-select-md border-0 shadow-none px-0" style="min-width: 150px;">
                            <option value="2025" selected>Periode 2025</option>
                            <option value="2024">Periode 2024</option>
                            <option value="2023">Periode 2023</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <div class="info-card text-start">
                    <div class="info-icon" style="background-color: #17C653">
                        <i class="fa-solid fa-clipboard-check" style="color: white;"></i>
                    </div>
                    <div class="info-value">Rp {{ number_format($total_rka, 0, ',', '.') }}</div>
                    <div class="info-label">Total RKA</div>
                </div>
            </div>

            <div class="col-md-6 position-relative">
                <div class="info-card text-start position-relative">
                    {{-- Progress di kanan atas --}}
                    <div class="position-absolute top-0 end-0 mt-7 me-4 d-flex flex-column align-items-end">
                        <span class="text-success fw-semibold small">{{ $total_rka > 0 ? round(($total_serapan / $total_rka) * 100) : 0 }}% Berjalan</span>
                        <div class="progress bg-light mt-1" style="width: 80px; height: 5px;">
                            <div class="progress-bar bg-success" style="width: {{ $total_rka > 0 ? ($total_serapan / $total_rka) * 100 : 0 }}%;"></div>
                        </div>
                    </div>

                    <div class="info-icon" style="background-color: #FFCC00">
                        <i class="fa-solid fa-bolt" style="color: white;"></i>
                    </div>

                    <div class="info-value">Rp {{ number_format($total_serapan, 0, ',', '.') }} / Rp {{ number_format($total_rka, 0, ',', '.') }}</div>

                    <div class="info-label mt-1 d-flex align-items-center gap-2">
                        <span
                            class="badge bg-success-subtle text-success fw-semibold px-3 py-1 border border-success-subtle">{{ $kegiatan_berjalan_all ?? $kegiatan_berjalan_count }}
                            Kegiatan Berjalan</span>
                        <span>/</span>
                        <span
                            class="badge bg-primary-subtle text-primary fw-semibold px-3 py-1 border border-primary-subtle">{{ $total_kegiatan_all ?? $kegiatan->count() }}
                            Total Kegiatan</span>
                    </div>
                </div>
            </div>

        </div>

        <div class="row g-4 mb-4">
            <div class="col-md-6 col-xl-3">
                <div class="info-card text-start">
                    <div class="info-icon" style="background-color: #1B84FF">
                        <i class="fa-solid fa-basketball" style="color: white;"></i>
                    </div>
                    <div class="info-value">{{ $total_cabor }} Cabor</div>
                    <div class="info-label">Total Cabor</div>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="info-card text-start">
                    <div class="info-icon" style="background-color: #D20A11">
                        <i class="fa-solid fa-user-check" style="color: white;"></i>
                    </div>
                    <div class="info-value">{{ $total_pengurus }} Pengurus</div>
                    <div class="info-label">Total Pengurus KONI</div>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="info-card text-start">
                    <div class="info-icon" style="background-color: #B817C6">
                        <i class="fa-solid fa-user" style="color: white;"></i>
                    </div>
                    <div class="info-value">{{ $total_pelatih }} Pelatih</div>
                    <div class="info-label">Total Pelatih</div>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="info-card text-start">
                    <div class="info-icon" style="background-color: #FF0066;">
                        <i class="fa-solid fa-users" style="color: white;"></i>
                    </div>
                    <div class="info-value">{{ $total_atlet }} Atlet</div>
                    <div class="info-label">Total Atlet</div>
                </div>
            </div>
        </div>


        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <div class="">
                    <div class="d-flex justify-content-between align-items-center mb-10">
                        <h5 class="card-title mb-0 f-3">Informasi Kegiatan</h5>

                        <div class="d-flex gap-2">
                            <button type="button" id="export-screenshot" class="btn btn-light-primary">
                                <i class="fa-solid fa-download me-1"></i> Export Data
                            </button>
                        </div>
                    </div>
                </div>
                <div id="informasi-kegiatan-content">

                @foreach ($kegiatan as $i => $item)
                    @php
                        // Memastikan nilai serapan adalah numerik dan bukan null
                        $serapan = 0;
                        if (isset($item->serapan) && is_numeric($item->serapan)) {
                            $serapan = (int)$item->serapan;
                        }
                        
                        // Membagi RKA secara merata ke semua kegiatan
                        $rka_per_kegiatan = 0;
                        if (isset($total_rka) && is_numeric($total_rka) && $total_rka > 0) {
                            $jumlah_kegiatan = $kegiatan->count();
                            $rka_per_kegiatan = ($jumlah_kegiatan > 0) ? (int)($total_rka / $jumlah_kegiatan) : 0;
                        }
                        
                        $total_budget = isset($item->total_budget) ? $item->total_budget : 0;
                        
                        // Perhitungan persentase dengan pengecekan aman
                        $persen = 0;
                        if ($rka_per_kegiatan > 0) {
                            $persen = round(($serapan / $rka_per_kegiatan) * 100);
                            // Batasi maksimal 100%
                            $persen = min(100, $persen);
                        }
                        
                        // Menampilkan serapan per kegiatan
                        $display_serapan = $serapan;
                        $display_budget = $rka_per_kegiatan;
                        
                        // Debugging - Hapus komentar untuk debugging
                        /*
                        if ($i == 0) { // Hanya untuk kegiatan pertama
                            echo "<!-- Debug Kegiatan Utama: ";
                            echo "Nama: " . (isset($item->nama_program) ? $item->nama_program : 'N/A') . ", ";
                            echo "Serapan: " . $serapan . ", ";
                            echo "Total RKA: " . (isset($total_rka) ? $total_rka : 'N/A') . ", ";
                            echo "RKA per kegiatan: " . $rka_per_kegiatan . " -->";
                        }
                        */

                        $barClass = 'bar-success';
                        if ($persen <= 30) {
                            $barClass = 'bar-danger';
                        } elseif ($persen <= 60) {
                            $barClass = 'bar-warning';
                        }
                    @endphp

                    <div class="d-flex align-items-center mb-3 gap-3">
                        <div style="min-width: 220px; max-width: 220px;">
                            <div class="d-flex align-items-center justify-content-between">
                                <span class="title-kegiatan">{{ $i + 1 }}. {{ $item->nama_program }}</span>
                                {{-- Icon dropdown untuk Pembinaan Prestasi --}}
                                @if($item->id == 6 && $item->children->count() > 0)
                                    <button class="btn btn-sm p-0 border-0 dropdown-icon ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePembinaanPrestasi" aria-expanded="false" aria-controls="collapsePembinaanPrestasi">
                                        <i class="fas fa-chevron-down text-primary"></i>
                                    </button>
                                @endif
                            </div>
                        </div>
                        <div class="flex-grow-1 position-relative">
                            <div class="progress w-100" style="border-radius: 8px; height: 45px;">
                                <div class="progress-bar {{ $barClass }}"
                                    role="progressbar"
                                    style="width: {{ $persen }}%; border-radius: 8px; opacity: 0.8;"
                                    aria-valuenow="{{ $persen }}" aria-valuemin="0" aria-valuemax="100">
                                </div>
                                <div class="position-absolute w-100 h-100 d-flex justify-content-between align-items-center px-3" style="top: 0; left: 0; pointer-events: none;">
                                    <span class="fw-bold" style="color: #151D48; text-shadow: 0 0 2px rgba(255,255,255,0.3);">
                                        Serapan : Rp {{ number_format($display_serapan, 0, ',', '.') }} / Rp {{ number_format($display_budget, 0, ',', '.') }} | {{ $item->children->where('jumlah_harga', '>', 0)->count() }}/{{ $item->children->count() }}
                                    </span>
                                    <span class="fw-bold" style="color: #151D48; text-shadow: 0 0 2px rgba(255,255,255,0.3);">{{ $persen }}%</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Collapse untuk Pembinaan Prestasi --}}
                    @if($item->id == 6 && $item->children->count() > 0)
                        <div class="collapse" id="collapsePembinaanPrestasi">
                            <div class="card card-body mt-2 p-3">
                                <h6 class="mb-3">Detail Kegiatan Pembinaan Prestasi</h6>
                                @foreach($item->children as $j => $child)
                                    @php
                                        // Memastikan nilai serapan adalah numerik dan bukan null
                                        $child_serapan = 0;
                                        if (isset($child->jumlah_harga) && is_numeric($child->jumlah_harga)) {
                                            $child_serapan = (int)$child->jumlah_harga;
                                        }
                                        
                                        // Membagi RKA kegiatan Pembinaan Prestasi ke anak-anaknya
                                        $rka_per_kegiatan = 0;
                                        if (isset($total_rka) && is_numeric($total_rka) && $total_rka > 0) {
                                            $jumlah_kegiatan = $kegiatan->count();
                                            $rka_per_kegiatan = ($jumlah_kegiatan > 0) ? (int)($total_rka / $jumlah_kegiatan) : 0;
                                        }
                                        
                                        $jumlah_anak = $item->children->count();
                                        $child_budget = 0;
                                        if ($jumlah_anak > 0 && $rka_per_kegiatan > 0) {
                                            $child_budget = (int)($rka_per_kegiatan / $jumlah_anak);
                                        }
                                        
                                        // Perhitungan persentase dengan pengecekan aman
                                        $child_persen = 0;
                                        if ($child_budget > 0) {
                                            $child_persen = round(($child_serapan / $child_budget) * 100);
                                            // Batasi maksimal 100%
                                            $child_persen = min(100, $child_persen);
                                        }
                                        
                                        // Debugging - Hapus komentar untuk debugging
                                        /*
                                        if ($j == 0) { // Hanya untuk anak pertama
                                            echo "<!-- Debug Anak Kegiatan: ";
                                            echo "Nama: " . (isset($child->nama_program) ? $child->nama_program : 'N/A') . ", ";
                                            echo "Serapan: " . $child_serapan . ", ";
                                            echo "RKA per kegiatan: " . $rka_per_kegiatan . ", ";
                                            echo "Jumlah anak: " . $jumlah_anak . ", ";
                                            echo "Budget per anak: " . $child_budget . " -->";
                                        }
                                        */

                                        $childBarClass = 'bar-success';
                                        if ($child_persen <= 30) {
                                            $childBarClass = 'bar-danger';
                                        } elseif ($child_persen <= 60) {
                                            $childBarClass = 'bar-warning';
                                        }
                                    @endphp

                                    <div class="d-flex align-items-center mb-3 gap-3">
                                        <div style="min-width: 220px; max-width: 220px;">
                                            <span class="title-kegiatan">{{ $j + 1 }}. {{ $child->nama_program }}</span>
                                        </div>
                                        <div class="flex-grow-1 position-relative">
                                            <div class="progress w-100" style="border-radius: 8px; height: 45px;">
                                                <div class="progress-bar {{ $childBarClass }}"
                                                    role="progressbar"
                                                    style="width: {{ $child_persen }}%; border-radius: 8px; opacity: 0.8;"
                                                    aria-valuenow="{{ $child_persen }}" aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                                <div class="position-absolute w-100 h-100 d-flex justify-content-between align-items-center px-3" style="top: 0; left: 0; pointer-events: none;">
                                                    <span class="fw-bold" style="color: #151D48; text-shadow: 0 0 2px rgba(255,255,255,0.3);">
                                                        Rp {{ number_format($child_serapan, 0, ',', '.') }} / Rp {{ number_format($child_budget, 0, ',', '.') }}
                                                    </span>
                                                    <span class="fw-bold" style="color: #151D48; text-shadow: 0 0 2px rgba(255,255,255,0.3);">{{ $child_persen }}%</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                {{-- Total untuk Pembinaan Prestasi --}}
                                <div class="d-flex align-items-center mt-3 pt-3 border-top">
                                    <div style="min-width: 220px; max-width: 220px;">
                                        <span class="fw-bold">Total Serapan:</span>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        @php
                                            // Memastikan total serapan adalah numerik
                                            $total_serapan_anak = 0;
                                            if (isset($item->children)) {
                                                $total_serapan_anak = (int)$item->children->sum('jumlah_harga');
                                            }
                                            
                                            // Memastikan nilai RKA adalah numerik
                                            $rka_per_kegiatan = 0;
                                            if (isset($total_rka) && is_numeric($total_rka) && $total_rka > 0) {
                                                $jumlah_kegiatan = $kegiatan->count();
                                                $rka_per_kegiatan = ($jumlah_kegiatan > 0) ? (int)($total_rka / $jumlah_kegiatan) : 0;
                                            }
                                            
                                            // Perhitungan persentase total dengan pengecekan aman
                                            $total_persen_anak = 0;
                                            if ($rka_per_kegiatan > 0) {
                                                $total_persen_anak = round(($total_serapan_anak / $rka_per_kegiatan) * 100);
                                                // Batasi maksimal 100%
                                                $total_persen_anak = min(100, $total_persen_anak);
                                            }
                                        @endphp
                                        <span class="fw-bold">
                                            Rp {{ number_format($total_serapan_anak, 0, ',', '.') }} / Rp {{ number_format($rka_per_kegiatan, 0, ',', '.') }} ({{ $total_persen_anak }}%)
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
                </div>
            </div>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h5 class="card-title">Informasi Pelatih & Peserta Cabor</h5>
                <div class="text-end mt-2 d-flex justify-content-end gap-3 align-items-center">
                    <div class="d-flex align-items-center gap-2">
                        <span class="dot" style="background-color: #17C653;"></span>
                        <span class="badge">Atlet</span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="dot" style="background-color: #0d6efd;"></span>
                        <span class="badge ">Pelatih</span>
                    </div>
                </div>

                <div style="max-height: 600px;">
                    <canvas id="caborChart"></canvas>
                </div>

            </div>
        </div>


        <!-- Prestasi Terbaru -->
        <div class="card border-0 shadow-sm">
            <div class="card-body p-6">
                <div class="d-flex align-items-center justify-content-between mb-6">
                    <h5 class="mb-0">Prestasi Terbaru</h5>
                </div>

                

                                <!-- Prestasi Atlet -->
                <div>
                    @include('admin.dashboard.partials._prestasi-atlet-table', ['prestasi_list' => $latest_prestasi, 'type' => 'atlet'])
                </div>

                <div class="text-center mt-6">
                    <a href="{{ route('admin.konfigurasi.prestasi.index') }}" class="btn btn-primary">
                        Lihat Selengkapnya
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('stack-script')
    <!-- html2canvas library for screenshot functionality -->
    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>

    <script>
        const ctx = document.getElementById('caborChart').getContext('2d');
        const caborData = @json($cabor_chart_data);

        const caborChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: caborData.map(c => c.nama_cabor),
                datasets: [{
                        label: 'Pelatih',
                        data: caborData.map(c => c.pelatihs_count),
                        backgroundColor: '#0d6efd',
                        borderRadius: 4
                    },
                    {
                        label: 'Atlet',
                        data: caborData.map(c => c.atlets_count),
                        backgroundColor: '#17C653',
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
                        intersect: false
                    }
                },
                scales: {
                    x: {
                        stacked: true,
                        ticks: {
                            color: '#2c3e50',
                            font: {
                                weight: 'bold'
                            }
                        }
                    },
                    y: {
                        stacked: true,
                        beginAtZero: true,
                        ticks: {
                            stepSize: 5
                        }
                    }
                }
            }
        });

        // Screenshot functionality for exporting "Informasi Kegiatan" section
        document.getElementById('export-screenshot').addEventListener('click', function() {
            const targetElement = document.getElementById('informasi-kegiatan-content'); // The Informasi Kegiatan section

            html2canvas(targetElement, {
                scale: 2, // Higher scale for better quality
                useCORS: true,
                backgroundColor: '#ffffff'
            }).then(canvas => {
                // Convert canvas to blob
                canvas.toBlob(function(blob) {
                    // Create download link
                    const link = document.createElement('a');
                    link.href = URL.createObjectURL(blob);
                    link.download = 'informasi-kegiatan-' + new Date().toISOString().slice(0, 10) + '.png';
                    link.click();
                });
            }).catch(error => {
                console.error('Error capturing screenshot:', error);
                alert('Gagal mengekspor data. Silakan coba lagi.');
            });
        });
    </script>
@endpush
