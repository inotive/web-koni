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
                        <span class="text-success fw-semibold small">0% Berjalan</span>
                        <div class="progress bg-light mt-1" style="width: 80px; height: 5px;">
                            <div class="progress-bar bg-success" style="width: 0%;"></div>
                        </div>
                    </div>

                    <div class="info-icon" style="background-color: #FFCC00">
                        <i class="fa-solid fa-bolt" style="color: white;"></i>
                    </div>

                    <div class="info-value">Rp 0 / Rp {{ number_format($total_rka, 0, ',', '.') }}</div>

                    <div class="info-label mt-1 d-flex align-items-center gap-2">
                        <span
                            class="badge bg-success-subtle text-success fw-semibold px-3 py-1 border border-success-subtle">0
                            Kegiatan Berjalan</span>
                        <span>/</span>
                        <span
                            class="badge bg-primary-subtle text-primary fw-semibold px-3 py-1 border border-primary-subtle">{{ $kegiatan->count() }}
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
                            <button class="btn btn-light-primary">
                                <i class="fa-solid fa-download me-1"></i> Export Data
                            </button>

                            <select class="form-select form-select-sm w-auto">
                                <option selected>Filter Berdasarkan: Tertinggi</option>
                                <option value="tertinggi">Tertinggi</option>
                                <option value="terendah">Terendah</option>
                            </select>
                        </div>
                    </div>
                </div>

                @foreach ($kegiatan as $i => $item)
                    @php
                        $persen = 0;
                        if ($item->jumlah_harga > 0) {
                            $persen = 0; // Assuming serapan is 0
                        } else {
                            $persen = 100;
                        }

                        $barClass = 'bar-success';
                        if ($persen <= 30) {
                            $barClass = 'bar-danger';
                        } elseif ($persen <= 60) {
                            $barClass = 'bar-warning';
                        }
                    @endphp

                    <div class="d-flex align-items-center mb-3 gap-3">
                        <div style="min-width: 220px; max-width: 220px;">
                            <span class="title-kegiatan">{{ $i + 1 }}. {{ $item->nama_program }}</span>
                        </div>
                        <div class="flex-grow-1 position-relative">
                            <div class="progress w-100" style="border-radius: 8px;">
                                <div class="progress-bar {{ $barClass }} text-white d-flex justify-content-between align-items-center px-3"
                                    role="progressbar"
                                    style="width: {{ $persen }}%; font-size: 12px; border-radius: 8px;"
                                    aria-valuenow="{{ $persen }}" aria-valuemin="0" aria-valuemax="100">
                                    <span>
                                        Serapan : Rp 0 / Rp {{ number_format($item->jumlah_harga, 0, ',', '.') }} | 0/{{ $item->children->count() }}
                                    </span>
                                    <span class="fw-bold">{{ $persen }}%</span>
                                </div>
                            </div>

                        </div>
                    </div>
                @endforeach
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


        <!-- Prestasi Atlet Terbaru -->
        <div class="card border-0 shadow-sm">
            <div class="card-body p-6">
                <div class="d-flex align-items-center justify-content-between mb-6">
                    <h5 class="mb-0">Prestasi Atlet Terbaru</h5>
                </div>

                @if(isset($latest_prestasi) && $latest_prestasi->isNotEmpty())
                    <div class="table-responsive">
                        <table class="table table-borderless align-middle">
                            <thead>
                                <tr class="text-muted fw-bold fs-7 text-uppercase gs-0">
                                    <th class="min-w-150px">Atlet & Cabor</th>
                                    <th class="min-w-125px">Prestasi</th>
                                    <th class="min-w-125px">Kejuaraan</th>
                                    <th class="min-w-100px">Medali</th>
                                    <th class="min-w-75px">Tahun</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($latest_prestasi as $prestasi)
                                    <tr class="border-bottom border-gray-200">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="symbol symbol-40px me-4">
                                                    @if(!empty($prestasi->subject->foto))
                                                        @php
                                                            $fotoPath = '/storage/' . $prestasi->subject->foto;
                                                        @endphp
                                                        <img src="{{ $fotoPath }}" class="symbol-label rounded-circle" style="object-fit: cover; width: 40px; height: 40px;" alt="{{ $prestasi->subject->nama ?? 'Atlet' }}">
                                                    @else
                                                        <div class="symbol-label fs-2 fw-bold bg-light-primary text-primary rounded-circle">
                                                            {{ substr($prestasi->subject->nama ?? 'N/A', 0, 1) }}
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <span class="text-gray-900 fw-bold fs-6">{{ $prestasi->subject->nama ?? 'N/A' }}</span>
                                                    <span class="text-muted fs-7">
                                                        {{ $prestasi->subject->cabangOlahraga->nama_cabor ?? 'N/A' }}
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-gray-800 fw-bold fs-6">{{ $prestasi->nama_prestasi }}</span>
                                        </td>
                                        <td>
                                            <span class="text-gray-600 fw-semibold fs-7">{{ $prestasi->kejuaraan }}</span>
                                        </td>
                                        <td>
                                            @php
                                                $iconColor = '';
                                                switch ($prestasi->medali) {
                                                    case 'Emas':
                                                        $iconColor = 'text-warning';
                                                        break;
                                                    case 'Perak':
                                                        $iconColor = 'text-dark';
                                                        break;
                                                    case 'Perunggu':
                                                        $iconColor = 'text-bronze';
                                                        break;
                                                    default:
                                                        $iconColor = 'text-primary';
                                                        break;
                                                }
                                            @endphp
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-medal me-2 {{ $iconColor }}"></i>
                                                <span>{{ $prestasi->medali }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-gray-800 fw-bold fs-7">{{ $prestasi->tahun }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-10">
                        <i class="ki-duotone ki-medal text-gray-400 fs-5x mb-5">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                            <span class="path4"></span>
                        </i>
                        <div class="text-gray-500 fs-6">Belum ada data prestasi</div>
                        <div class="text-gray-400 fs-7">Prestasi atlet akan muncul di sini</div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('stack-script')
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
    </script>
@endpush
