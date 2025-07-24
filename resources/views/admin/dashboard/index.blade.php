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
    </style>
@endpush

@section('pageTitle', 'Dashboard')

@section('content')
    <div class="container mt-4">
        <div class="mb-4">
            <div class="mb-4">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div>
                        <h2 class="fs-2 mb-1">Selamat Datang, <span class="text-danger">Alessandro</span></h2>
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
                    <div class="info-value">Rp 2.200.000.000</div>
                    <div class="info-label">Total RKA</div>
                </div>
            </div>

            <div class="col-md-6 position-relative">
                <div class="info-card text-start position-relative">
                    {{-- Progress di kanan atas --}}
                    <div class="position-absolute top-0 end-0 mt-7 me-4 d-flex flex-column align-items-end">
                        <span class="text-success fw-semibold small">40% Berjalan</span>
                        <div class="progress bg-light mt-1" style="width: 80px; height: 5px;">
                            <div class="progress-bar bg-success" style="width: 40%;"></div>
                        </div>
                    </div>

                    <div class="info-icon" style="background-color: #FFCC00">
                        <i class="fa-solid fa-bolt" style="color: white;"></i>
                    </div>

                    <div class="info-value">Rp 200.000.000 / 2.200.000.000</div>

                    <div class="info-label mt-1 d-flex align-items-center gap-2">
                        <span
                            class="badge bg-success-subtle text-success fw-semibold px-3 py-1 border border-success-subtle">24
                            Kegiatan Berjalan</span>
                        <span>/</span>
                        <span
                            class="badge bg-primary-subtle text-primary fw-semibold px-3 py-1 border border-primary-subtle">114
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
                    <div class="info-value">48 Cabor</div>
                    <div class="info-label">Total Cabor</div>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="info-card text-start">
                    <div class="info-icon" style="background-color: #D20A11">
                        <i class="fa-solid fa-user-check" style="color: white;"></i>
                    </div>
                    <div class="info-value">20 Pegurus</div>
                    <div class="info-label">Total Pengurus KONI</div>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="info-card text-start">
                    <div class="info-icon" style="background-color: #B817C6">
                        <i class="fa-solid fa-user" style="color: white;"></i>
                    </div>
                    <div class="info-value">20 Pelatih</div>
                    <div class="info-label">Total Pelatih</div>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="info-card text-start">
                    <div class="info-icon" style="background-color: #FF0066;">
                        <i class="fa-solid fa-users" style="color: white;"></i>
                    </div>
                    <div class="info-value">2.500 Atlet</div>
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

                @php
                    $kegiatan = [
                        [
                            'title' => 'Koni',
                            'persen' => 100,
                            'serapan' => '100.000.000',
                            'total' => '100.000.000',
                            'kegiatan' => '10/10',
                        ],
                        [
                            'title' => 'Mobilisasi Sumber Daya & Pemasaran',
                            'persen' => 100,
                            'serapan' => '100.000.000',
                            'total' => '100.000.000',
                            'kegiatan' => '10/10',
                        ],
                        [
                            'title' => 'Hubungan Antar Lembaga',
                            'persen' => 80,
                            'serapan' => '80.000.000',
                            'total' => '100.000.000',
                            'kegiatan' => '8/10',
                        ],
                        [
                            'title' => 'Kesehatan',
                            'persen' => 60,
                            'serapan' => '60.000.000',
                            'total' => '100.000.000',
                            'kegiatan' => '6/10',
                        ],
                        [
                            'title' => 'Organisasi',
                            'persen' => 50,
                            'serapan' => '100.000.000',
                            'total' => '100.000.000',
                            'kegiatan' => '5/10',
                        ],
                        [
                            'title' => 'Pembinaan Hukum Olahraga',
                            'persen' => 40,
                            'serapan' => '40.000.000',
                            'total' => '100.000.000',
                            'kegiatan' => '4/10',
                        ],
                        [
                            'title' => 'Pembinaan Prestasi',
                            'persen' => 60,
                            'serapan' => '60.000.000',
                            'total' => '100.000.000',
                            'kegiatan' => '6/10',
                        ],
                        [
                            'title' => 'Sport Science & Iptek',
                            'persen' => 70,
                            'serapan' => '70.000.000',
                            'total' => '100.000.000',
                            'kegiatan' => '7/10',
                        ],
                        [
                            'title' => 'Sport Science & Iptek',
                            'persen' => 30,
                            'serapan' => '100.000.000',
                            'total' => '100.000.000',
                            'kegiatan' => '10/10',
                        ],
                        [
                            'title' => 'Kegiatan Lainnya',
                            'persen' => 100,
                            'serapan' => '100.000.000',
                            'total' => '100.000.000',
                            'kegiatan' => '10/10',
                        ],
                    ];
                @endphp

                @foreach ($kegiatan as $i => $item)
                    @php
                        $barClass = 'bar-success';
                        if ($item['persen'] <= 30) {
                            $barClass = 'bar-danger';
                        } elseif ($item['persen'] <= 60) {
                            $barClass = 'bar-warning';
                        }
                    @endphp

                    <div class="d-flex align-items-center mb-3 gap-3">
                        <div style="min-width: 220px; max-width: 220px;">
                            <span class="title-kegiatan">{{ $i + 1 }}. {{ $item['title'] }}</span>
                        </div>
                        <div class="flex-grow-1 position-relative">
                            <div class="progress w-100" style="border-radius: 8px;">
                                <div class="progress-bar {{ $barClass }} text-white d-flex justify-content-between align-items-center px-3"
                                    role="progressbar"
                                    style="width: {{ $item['persen'] }}%; font-size: 12px; border-radius: 8px;"
                                    aria-valuenow="{{ $item['persen'] }}" aria-valuemin="0" aria-valuemax="100">
                                    <span>
                                        Serapan : {{ $item['serapan'] }} / {{ $item['total'] }} | {{ $item['kegiatan'] }}
                                    </span>
                                    <span class="fw-bold">{{ $item['persen'] }}%</span>
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
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h5 class="card-title">Prestasi Atlet Terbaru</h5>
                <p class="text-muted">[Table Placeholder]</p>
            </div>
        </div>
    </div>
@endsection

@push('stack-script')
    <script>
        const ctx = document.getElementById('caborChart').getContext('2d');

        const caborChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Koni', 'Basket', 'Tenis Meja', 'Badminton', 'Voli', 'Sepak Bola', 'Lari', 'Lembing',
                    'Tenis', 'Panjat'
                ],
                datasets: [{
                        label: 'Pelatih',
                        data: [3, 10, 2, 2, 3, 10, 2, 1, 3, 3],
                        backgroundColor: '#0d6efd',
                        borderRadius: 4
                    },
                    {
                        label: 'Atlet',
                        data: [20, 20, 2, 2, 25, 24, 4, 3, 2, 3],
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
