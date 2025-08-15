@extends('layouts.app')

@section('pageTitle', 'Detail Mobilisasi Sumber Daya')
@section('mainSection', 'Laporan Pertanggungjawaban')
@section('subSection', 'Mobilisasi Sumber Daya')
@section('subSectionUrl', route('admin.laporan-lpj.bidang.mobilisasi-sumberdaya.index'))
@section('currentSection', 'Detail Mobilisasi Sumber Daya')

@section('content')
    <style>
        body {
            background-color: #f5f5f5 !important;
        }

        .main-content {
            background-color: #f5f5f5;
            min-height: 100vh;
            padding: 20px 10px 40px;
        }

        .card-detail {
            background-color: white;
            border-radius: 12px;
            border: 1px solid #e9ecef;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
            margin-bottom: 20px;
        }

        .detail-header {
            background: linear-gradient(135deg, #F8285A 0%, #e91e63 100%);
            color: white;
            padding: 20px;
            border-radius: 12px 12px 0 0;
        }

        .detail-body {
            padding: 25px;
        }

        .detail-row {
            display: flex;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #f0f0f0;
        }

        .detail-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .detail-label {
            font-weight: 600;
            color: #495057;
            width: 200px;
            flex-shrink: 0;
        }

        .detail-value {
            color: #212529;
            flex: 1;
        }

        .section-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: #212529;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #F8285A;
        }

        .btn-back {
            background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%);
            border: none;
            border-radius: 8px;
            padding: 12px 24px;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(108, 117, 125, 0.3);
            color: white;
            text-decoration: none;
        }

        .btn-back:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(108, 117, 125, 0.4);
            color: white;
        }

        .btn-edit {
            background: linear-gradient(135deg, #F8285A 0%, #e91e63 100%);
            border: none;
            border-radius: 8px;
            padding: 12px 24px;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(248, 40, 90, 0.3);
            color: white;
            text-decoration: none;
        }

        .btn-edit:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(248, 40, 90, 0.4);
            color: white;
        }

        .btn-restricted {
            cursor: not-allowed !important;
            opacity: 0.6 !important;
            pointer-events: none;
        }

        /* Custom tooltip styling */
        .custom-tooltip {
            --bs-tooltip-bg: #ffffff;
            --bs-tooltip-border-color: #e0e0e0;
            --bs-tooltip-color: #333333;
            --bs-tooltip-padding-x: 12px;
            --bs-tooltip-padding-y: 8px;
            --bs-tooltip-border-radius: 8px;
            --bs-tooltip-font-size: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            border: 1px solid var(--bs-tooltip-border-color);
        }

        .custom-tooltip .tooltip-inner {
            background-color: var(--bs-tooltip-bg);
            color: var(--bs-tooltip-color);
            border-radius: var(--bs-tooltip-border-radius);
            padding: var(--bs-tooltip-padding-y) var(--bs-tooltip-padding-x);
            text-align: left;
            max-width: 200px;
        }

        .tooltip-content strong {
            color: #333333;
            font-weight: 600;
        }

        /* File tables styling */
        .file-table {
            margin-top: 20px;
        }

        .file-card {
            border: 1px solid #e9ecef;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .file-card-header {
            background-color: #f8f9fa;
            padding: 15px 20px;
            border-bottom: 1px solid #e9ecef;
            border-radius: 8px 8px 0 0;
        }

        .file-card-body {
            padding: 0;
        }

        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 15px;
            opacity: 0.5;
        }

        @media (max-width: 768px) {
            .detail-row {
                flex-direction: column;
            }

            .detail-label {
                width: 100%;
                margin-bottom: 5px;
            }

            .detail-value {
                padding-left: 0;
            }
        }

            .fa-eye:hover{
                color: white !important;
            }

            .fa-download:hover{
                color: white !important;
            }

    </style>

    <div class="d-flex justify-content-between align-items-center flex-wrap mb-4" style="padding: 20px 20px">
        <h3 class="fw-bold fs-2 mb-0 text-dark">Detail Mobilisasi Sumber Daya</h3>
    </div>

    <div class="main-content">
        <div class="container-fluid">
            {{-- Main Information Card --}}
            <div class="card card-detail">
                <div class="detail-header">
                    <h4 class="mb-0" style="color: white">Informasi Mobilisasi Sumber Daya</h4>
                </div>
                <div class="detail-body">
                    <div class="detail-row">
                        <div class="detail-label">Nama Program:</div>
                        <div class="detail-value">{{ $sumberdaya->nama_program }}</div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-label">Nama Kegiatan:</div>
                        <div class="detail-value">{{ $sumberdaya->nama_kegiatan }}</div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-label">Volume:</div>
                        <div class="detail-value">{{ $sumberdaya->volume }}</div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-label">Jumlah Harga Satuan:</div>
                        <div class="detail-value">Rp {{ number_format($sumberdaya->jumlah_harga_satuan, 0, ',', '.') }}</div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-label">Jumlah Harga:</div>
                        <div class="detail-value">Rp {{ number_format($sumberdaya->jumlah_harga, 0, ',', '.') }}</div>
                    </div>

                    @if($sumberdaya->keterangan_tambahan)
                        <div class="detail-row">
                            <div class="detail-label">Keterangan Tambahan:</div>
                            <div class="detail-value">{{ $sumberdaya->keterangan_tambahan }}</div>
                        </div>
                    @endif

                    <div class="detail-row">
                        <div class="detail-label">Tanggal Dibuat:</div>
                        <div class="detail-value">{{ $sumberdaya->created_at->format('d F Y, H:i') }}</div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-label">Terakhir Diperbarui:</div>
                        <div class="detail-value">{{ $sumberdaya->updated_at->format('d F Y, H:i') }}</div>
                    </div>
                </div>
            </div>

            {{-- Photo Files Card --}}
            <div class="card card-detail file-card">
                <div class="file-card-header">
                    <h5 class="section-title mb-0">
                        <i class="fas fa-images me-2"></i>Foto Jurnal
                        @if($sumberdaya->foto_jurnal && count($sumberdaya->foto_jurnal) > 0)
                            <span class="badge bg-primary ms-2" style="color: white">{{ count($sumberdaya->foto_jurnal) }} file</span>
                        @endif
                    </h5>
                </div>
                <div class="file-card-body">
                    @include('admin.laporan-lpj.bidang.mobilisasi-sumberdaya._tablefoto', ['fotoJurnal' => $sumberdaya->foto_jurnal])
                </div>
            </div>

            {{-- Document Files Card --}}
            <div class="card card-detail file-card">
                <div class="file-card-header">
                    <h5 class="section-title mb-0" >
                        <i class="fas fa-file-alt me-2"></i>Dokumen LPJ
                        @if($sumberdaya->dokumen_lpj && count($sumberdaya->dokumen_lpj) > 0)
                            <span class="badge bg-success ms-2" style="color: white">{{ count($sumberdaya->dokumen_lpj) }} file</span>
                        @endif
                    </h5>
                </div>
                <div class="file-card-body">
                    @include('admin.laporan-lpj.bidang.mobilisasi-sumberdaya._tabledokumen', ['dokumenLpj' => $sumberdaya->dokumen_lpj])
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="d-flex justify-content-between align-items-center mt-4">
                <a href="{{ route('admin.laporan-lpj.bidang.mobilisasi-sumberdaya.index') }}" class="btn-back">
                    <i class="fas fa-arrow-left me-2" style="color: white"></i>Kembali ke Daftar
                </a>

                {{-- Edit Button with Access Control --}}
                @if(auth()->user()->hasRole('superadmin'))
                    <a href="{{ route('admin.laporan-lpj.bidang.mobilisasi-sumberdaya.edit', $sumberdaya->id) }}" class="btn-edit">
                        <i class="fas fa-edit me-2" style="color: white"></i>Edit Data
                    </a>
                @else
                    <div class="position-relative">
                        <button class="btn-edit btn-restricted"
                                data-bs-toggle="tooltip"
                                data-bs-placement="top"
                                data-bs-custom-class="custom-tooltip"
                                data-bs-html="true"
                                title="<div class='tooltip-content'>
                                          <strong>Informasi</strong><br>
                                          Akses dibatasi untuk<br>
                                          User Super Laporan
                                       </div>">
                            <i class="fas fa-edit me-2"></i>Edit Data
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl, {
                    trigger: 'hover focus'
                });
            });
        });
    </script>
@endsection
