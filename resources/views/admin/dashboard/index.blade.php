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

                    <div class="info-value">Rp {{ number_format($total_rka > 0 ? $total_serapan : 0, 0, ',', '.') }} / Rp {{ number_format($total_rka, 0, ',', '.') }}</div>

                    <div class="info-label mt-1 d-flex align-items-center gap-2">
                        <span
                            class="badge bg-success-subtle text-success fw-semibold px-3 py-1 border border-success-subtle">{{ $kegiatan_berjalan_count }}
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
                            <a href="{{ route('admin.dashboard.export') }}" class="btn btn-light-primary" target="_blank">
                                <i class="fa-solid fa-download me-1"></i> Export Data
                            </a>

                            <form method="GET" id="filter-form">
                                <select name="filter" class="form-select form-select-sm w-auto" onchange="this.form.submit()">
                                    <option value="" {{ request('filter') == '' ? 'selected' : '' }}>Default</option>
                                    <option value="tertinggi" {{ request('filter') == 'tertinggi' ? 'selected' : '' }}>Tertinggi</option>
                                    <option value="terendah" {{ request('filter') == 'terendah' ? 'selected' : '' }}>Terendah</option>
                                </select>
                            </form>
                        </div>
                    </div>
                </div>

                @foreach ($kegiatan->take(8) as $i => $item)
                    @php
                        // Menggunakan nilai serapan yang sudah dihitung di controller
                        $serapan = $item->serapan;
                        $total_budget = $item->total_budget;
                        // Menangani kasus ketika tidak ada RKA
                        $persen = ($total_budget > 0) ? round(($serapan / $total_budget) * 100) : 0;
                        // Menampilkan 0 jika tidak ada RKA
                        $display_serapan = ($total_rka > 0) ? $serapan : 0;
                        $display_budget = $total_budget;

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
                            <div class="progress w-100" style="border-radius: 8px;">
                                <div class="progress-bar {{ $barClass }} text-white d-flex justify-content-between align-items-center px-3"
                                    role="progressbar"
                                    style="width: {{ $persen }}%; font-size: 12px; border-radius: 8px;"
                                    aria-valuenow="{{ $persen }}" aria-valuemin="0" aria-valuemax="100">
                                    <span>
                                        Serapan : Rp {{ number_format($display_serapan, 0, ',', '.') }} / Rp {{ number_format($display_budget, 0, ',', '.') }} | {{ $item->children->where('jumlah_harga', '>', 0)->count() }}/{{ $item->children->count() }}
                                    </span>
                                    <span class="fw-bold">{{ $persen }}%</span>
                                </div>
                            </div>

                        </div>
                    </div>

                    {{-- Collapse untuk Pembinaan Prestasi --}}
                    @if($item->id == 6 && $item->children->count() > 0)
                        <div class="collapse" id="collapsePembinaanPrestasi">
                            <div class="card card-body mt-2 p-3">
                                <h6 class="mb-3">Detail Anak Kegiatan Pembinaan Prestasi</h6>
                                @foreach($item->children as $j => $child)
                                    @php
                                        $child_serapan = $child->jumlah_harga;
                                        $child_budget = isset($child->allocated_budget) ? $child->allocated_budget : 0;
                                        $child_persen = ($child_budget > 0) ? round(($child_serapan / $child_budget) * 100) : 0;

                                        $childBarClass = 'bar-success';
                                        if ($child_persen <= 30) {
                                            $childBarClass = 'bar-danger';
                                        } elseif ($child_persen <= 60) {
                                            $childBarClass = 'bar-warning';
                                        }
                                    @endphp

                                    <div class="d-flex align-items-center mb-2">
                                        <div style="min-width: 200px;">
                                            <span class="text-muted small">{{ $j + 1 }}. {{ $child->nama_program }}</span>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <div class="progress" style="height: 20px;">
                                                <div class="progress-bar {{ $childBarClass }} d-flex justify-content-between align-items-center px-2"
                                                    role="progressbar"
                                                    style="width: {{ $child_persen }}%;"
                                                    aria-valuenow="{{ $child_persen }}" aria-valuemin="0" aria-valuemax="100">
                                                    <span class="text-white" style="font-size: 10px;">
                                                        Rp {{ number_format($child_serapan, 0, ',', '.') }} / Rp {{ number_format($child_budget, 0, ',', '.') }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                {{-- Total untuk Pembinaan Prestasi --}}
                                <div class="d-flex align-items-center mt-3 pt-3 border-top">
                                    <div style="min-width: 200px;">
                                        <span class="fw-bold">Total Serapan:</span>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <span class="fw-bold">
                                            Rp {{ number_format($item->total_serapan, 0, ',', '.') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
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


        <!-- Prestasi Terbaru dengan Tab Navigation -->
        <div class="card border-0 shadow-sm">
            <div class="card-body p-6">
                <div class="d-flex align-items-center justify-content-between mb-6">
                    <h5 class="mb-0">Prestasi Terbaru</h5>
                </div>

                <!-- Tab Navigation -->
                <ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x mb-5 fs-5">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#atlet-prestasi">Atlet</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#pelatih-prestasi">Pelatih</a>
                    </li>
                </ul>

                <!-- Tab Content dengan Pagination -->
                <div id="prestasi-table-container">
                    @include('admin.dashboard.partials.prestasi-table')
                </div>
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

        $(document).ready(function() {
            const prestasiContainer = $('#prestasi-table-container');
            let searchTimeout;

            function loadPrestasi(url) {
                $.ajax({
                    url: url,
                    type: 'GET',
                    beforeSend: function() {
                        prestasiContainer.html(
                            '<div class="text-center py-10">' +
                            '<div class="spinner-border text-primary" role="status">' +
                            '<span class="visually-hidden">Loading...</span>' +
                            '</div></div>'
                        );
                    },
                    success: function(response) {
                        if (response.success) {
                            prestasiContainer.html(response.html);
                            // Update URL
                            if (window.history && window.history.pushState) {
                                window.history.pushState({}, '', url);
                            }
                        } else {
                            handleAjaxError();
                        }
                    },
                    error: function(xhr) {
                        console.error('Error:', xhr.responseText);
                        handleAjaxError();
                    }
                });
            }

            function handleAjaxError() {
                prestasiContainer.html(
                    '<div class="text-center py-10">' +
                    '<div class="text-danger">Terjadi kesalahan saat memuat data. Silakan coba lagi.</div>' +
                    '</div>'
                );
            }

            // Event delegation for search
            prestasiContainer.on('input', '#search-prestasi', function() {
                clearTimeout(searchTimeout);
                const search = $(this).val();

                searchTimeout = setTimeout(() => {
                    const url = new URL('{{ route("admin.dashboard.prestasi-pagination") }}');
                    url.searchParams.set('page', 1);
                    if (search) {
                        url.searchParams.set('search', search);
                    } else {
                        url.searchParams.delete('search');
                    }
                    loadPrestasi(url.toString());
                }, 300); // Debounce 300ms
            });

            // Event delegation for pagination
            prestasiContainer.on('click', '.prestasi-pagination-link', function(e) {
                e.preventDefault();
                const url = $(this).attr('href');
                if (url && url !== '#') {
                    loadPrestasi(url);
                }
            });

            // Handle browser back/forward buttons
            window.onpopstate = function(event) {
                // Check if the state is related to our prestasi table
                if (event.state) {
                    loadPrestasi(location.href);
                }
            };
            
            // Handle per page change
            prestasiContainer.on('change', '#per-page-select', function() {
                const perPage = $(this).val();
                const search = $('#search-prestasi').val();
                
                const url = new URL('{{ route("admin.dashboard.prestasi-pagination") }}');
                url.searchParams.set('page', 1);
                url.searchParams.set('per_page', perPage);
                if (search) {
                    url.searchParams.set('search', search);
                }
                
                loadPrestasi(url.toString());
            });
        });

        // Handle tab switching (this can stay outside the ready block)
        $(document).on('click', '.nav-link[data-bs-toggle="tab"]', function(e) {
            e.preventDefault();
            $(this).tab('show');
        });
    </script>
@endpush
