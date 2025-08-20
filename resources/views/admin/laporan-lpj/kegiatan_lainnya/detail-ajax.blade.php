@extends('layouts.app')

@section('pageTitle', 'Detail Kegiatan Lainnya')
@section('mainSection', 'Laporan Pertanggungjawaban')
@section('currentSection', 'Kegiatan Lainnya')

@section('breadcrumb-title')
@endsection

@section('breadcrumb-items')
@endsection

@section('content')
    <style>
        body {
            background-color: #f5f5f5;
        }

        .detail-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .detail-header {
            background: linear-gradient(135deg, #F8285A 0%, #e91e63 100%);
            padding: 30px;
            color: white;
            position: relative;
        }

        .detail-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }

        .detail-header-content {
            position: relative;
            z-index: 1;
        }

        .detail-title {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 8px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .detail-subtitle {
            font-size: 14px;
            opacity: 0.9;
            font-weight: 400;
        }

        .action-badges {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        .action-badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.3);
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
        }

        .action-badge:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .action-badge.locked {
            background: rgba(255, 193, 7, 0.2);
            color: #fff;
            border-color: rgba(255, 193, 7, 0.5);
        }

        .action-badge.edit {
            background: rgba(13, 202, 240, 0.2);
            color: #fff;
            border-color: rgba(13, 202, 240, 0.5);
        }

        .action-badge.export {
            background: rgba(25, 135, 84, 0.2);
            color: #fff;
            border-color: rgba(25, 135, 84, 0.5);
        }

        .detail-section {
            padding: 30px;
            border-bottom: 1px solid #f0f0f0;
        }

        .detail-section:last-child {
            border-bottom: none;
        }

        .section-title {
            font-size: 18px;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-title::before {
            content: '';
            width: 4px;
            height: 24px;
            background: linear-gradient(135deg, #F8285A, #e91e63);
            border-radius: 2px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .info-item {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid #F8285A;
            transition: all 0.3s ease;
        }

        .info-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(248, 40, 90, 0.1);
        }

        .info-label {
            font-size: 13px;
            color: #64748b;
            margin-bottom: 6px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-value {
            font-size: 15px;
            color: #1e293b;
            font-weight: 600;
            line-height: 1.4;
        }

        .budget-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .budget-card {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 24px;
            border-radius: 12px;
            text-align: center;
            border: 1px solid #dee2e6;
            transition: all 0.3s ease;
        }

        .budget-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            border-color: #F8285A;
        }

        .budget-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #F8285A, #e91e63);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 12px;
            color: white;
            font-size: 20px;
        }

        .budget-label {
            font-size: 13px;
            color: #64748b;
            margin-bottom: 8px;
            font-weight: 500;
            text-transform: uppercase;
        }

        .budget-value {
            font-size: 18px;
            color: #1e293b;
            font-weight: 700;
        }

        .total-budget {
            background: linear-gradient(135deg, #F8285A, #e91e63);
            color: white;
            padding: 30px;
            border-radius: 12px;
            text-align: center;
            margin-top: 20px;
        }

        .total-budget .budget-label {
            color: rgba(255, 255, 255, 0.8);
        }

        .total-budget .budget-value {
            color: white;
            font-size: 24px;
        }

        .attachments-grid {
            display: grid;
            gap: 24px;
        }

        .attachment-section {
            background: #f8f9fa;
            padding: 24px;
            border-radius: 12px;
            border: 2px dashed #dee2e6;
            transition: all 0.3s ease;
        }

        .attachment-section:hover {
            border-color: #F8285A;
            background: #fdf2f8;
        }

        .attachment-title {
            font-size: 16px;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .document-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            background: white;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            margin-bottom: 8px;
            transition: all 0.3s ease;
        }

        .document-item:hover {
            border-color: #F8285A;
            box-shadow: 0 2px 8px rgba(248, 40, 90, 0.1);
        }

        .document-icon {
            width: 40px;
            height: 40px;
            background: #F8285A;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 16px;
        }

        .document-info {
            flex: 1;
        }

        .document-name {
            font-size: 14px;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 2px;
        }

        .document-size {
            font-size: 12px;
            color: #64748b;
        }

        .document-actions {
            display: flex;
            gap: 8px;
        }

        .btn-action {
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
            border: 1px solid;
        }

        .btn-view {
            background: #3b82f6;
            color: white;
            border-color: #3b82f6;
        }

        .btn-view:hover {
            background: #2563eb;
            color: white;
            transform: translateY(-1px);
        }

        .btn-download {
            background: #10b981;
            color: white;
            border-color: #10b981;
        }

        .btn-download:hover {
            background: #059669;
            color: white;
            transform: translateY(-1px);
        }

        .photo-gallery {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 12px;
            margin-top: 16px;
        }

        .photo-item {
            aspect-ratio: 1;
            border-radius: 12px;
            overflow: hidden;
            background: #f1f5f9;
            border: 2px solid #e2e8f0;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
        }

        .photo-item:hover {
            transform: scale(1.05);
            border-color: #F8285A;
            box-shadow: 0 4px 20px rgba(248, 40, 90, 0.2);
        }

        .photo-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .photo-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .photo-item:hover .photo-overlay {
            opacity: 1;
        }

        .photo-overlay i {
            color: white;
            font-size: 24px;
        }

        .no-data {
            text-align: center;
            padding: 40px;
            color: #64748b;
            font-style: italic;
        }

        .back-button {
            position: fixed;
            top: 100px;
            left: 30px;
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #F8285A, #e91e63);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            font-size: 18px;
            box-shadow: 0 4px 15px rgba(248, 40, 90, 0.3);
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .back-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(248, 40, 90, 0.4);
            color: white;
        }

        .custom-tooltip {
            --bs-tooltip-bg: #1e293b;
            --bs-tooltip-border-color: #334155;
            --bs-tooltip-color: #f8fafc;
            --bs-tooltip-padding-x: 12px;
            --bs-tooltip-padding-y: 8px;
            --bs-tooltip-border-radius: 8px;
            --bs-tooltip-font-size: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        @media (max-width: 768px) {
            .detail-container {
                margin: 10px;
                border-radius: 8px;
            }

            .detail-header {
                padding: 20px;
            }

            .detail-title {
                font-size: 20px;
            }

            .detail-section {
                padding: 20px;
            }

            .info-grid {
                grid-template-columns: 1fr;
                gap: 16px;
            }

            .budget-grid {
                grid-template-columns: 1fr;
                gap: 16px;
            }

            .action-badges {
                flex-direction: column;
                gap: 8px;
            }

            .back-button {
                top: 20px;
                left: 20px;
                width: 45px;
                height: 45px;
            }

            .photo-gallery {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .detail-container {
            animation: fadeIn 0.5s ease;
        }
    </style>

    <!-- Back Button -->
    <a href="{{ route('admin.laporan-lpj.kegiatan-lainnya.index') }}" class="back-button" 
       data-bs-toggle="tooltip" data-bs-placement="right" 
       data-bs-custom-class="custom-tooltip"
       title="Kembali ke Daftar Kegiatan">
        <i class="fas fa-arrow-left"></i>
    </a>

    <div class="d-flex flex-column mb-8">
        <h1 class="text-dark fw-bold mb-1">Detail Kegiatan Lainnya</h1>
        <div class="text-muted fw-semibold fs-6">Informasi Lengkap Laporan Pertanggungjawaban</div>
    </div>

    <div class="detail-container">
        <!-- Header Section -->
        <div class="detail-header">
            <div class="detail-header-content">
                <h1 class="detail-title">{{ $kegiatan->nama_kegiatan ?? 'Detail Laporan LPJ' }}</h1>
                <p class="detail-subtitle">Laporan Pertanggungjawaban Kegiatan</p>
                
                <div class="action-badges">
                    @if(auth()->user()->hasRole('superadmin'))
                        <div class="action-badge edit" data-bs-toggle="tooltip" title="Edit Kegiatan">
                            <i class="fas fa-edit"></i>
                            Edit Kegiatan
                        </div>
                        <div class="action-badge export" data-bs-toggle="tooltip" title="Export Data">
                            <i class="fas fa-download"></i>
                            Export Data
                        </div>
                    @else
                        <div class="action-badge locked" data-bs-toggle="tooltip" title="Data Terkunci">
                            <i class="fas fa-lock"></i>
                            Terkunci
                        </div>
                        <div class="action-badge edit" data-bs-toggle="tooltip" title="Ajukan Perubahan">
                            <i class="fas fa-edit"></i>
                            Ajukan Perubahan
                        </div>
                        <div class="action-badge export" data-bs-toggle="tooltip" title="Export Data">
                            <i class="fas fa-download"></i>
                            Export Data
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Program Information Section -->
        <div class="detail-section">
            <h2 class="section-title">
                <i class="fas fa-info-circle text-primary"></i>
                Informasi Program & Kegiatan
            </h2>
            
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Nama Program</div>
                    <div class="info-value">{{ $kegiatan->nama_program ?? 'Program Peningkatan Kapasitas Pelatih dan Wasit' }}</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Nama Kegiatan</div>
                    <div class="info-value">{{ $kegiatan->nama_kegiatan ?? 'Pelatihan Pelatih Bulutangkis Level Pratama' }}</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Jenis Kegiatan</div>
                    <div class="info-value">{{ $kegiatan->jenis_kegiatan ?? 'Pelatihan' }}</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Tanggal Kegiatan</div>
                    <div class="info-value">{{ $kegiatan->tanggal_kegiatan ? \Carbon\Carbon::parse($kegiatan->tanggal_kegiatan)->format('d F Y') : '15 Januari 2025' }}</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Lokasi</div>
                    <div class="info-value">{{ $kegiatan->lokasi ?? 'Jakarta Sports Center' }}</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Status</div>
                    <div class="info-value">
                        <span class="badge bg-success">{{ $kegiatan->status ?? 'Selesai' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Budget Section -->
        <div class="detail-section">
            <h2 class="section-title">
                <i class="fas fa-calculator text-success"></i>
                Rincian Anggaran
            </h2>
            
            <div class="budget-grid">
                <div class="budget-card">
                    <div class="budget-icon">
                        <i class="fas fa-boxes"></i>
                    </div>
                    <div class="budget-label">Volume</div>
                    <div class="budget-value">{{ $kegiatan->volume ?? '220' }} Volume</div>
                </div>
                
                <div class="budget-card">
                    <div class="budget-icon">
                        <i class="fas fa-tag"></i>
                    </div>
                    <div class="budget-label">Harga Satuan</div>
                    <div class="budget-value">Rp {{ number_format($kegiatan->harga_satuan ?? 20000000, 0, ',', '.') }}</div>
                </div>
            </div>
            
            <div class="total-budget">
                <div class="budget-label">Total Anggaran</div>
                <div class="budget-value">Rp {{ number_format($kegiatan->jumlah_harga ?? 200000000, 0, ',', '.') }}</div>
            </div>
        </div>

        <!-- Attachments Section -->
        <div class="detail-section">
            <h2 class="section-title">
                <i class="fas fa-paperclip text-warning"></i>
                Lampiran
            </h2>
            
            <div class="attachments-grid">
                <!-- Document Section -->
                <div class="attachment-section">
                    <h4 class="attachment-title">
                        <i class="fas fa-file-pdf text-danger"></i>
                        Dokumen LPJ
                    </h4>
                    
                    @if($kegiatan->dokumen_lpj ?? true)
                        <div class="document-item">
                            <div class="document-icon">
                                <i class="fas fa-file-pdf"></i>
                            </div>
                            <div class="document-info">
                                <div class="document-name">{{ $kegiatan->nama_dokumen ?? 'Document_LPJ_Bulutangkis_2025.pdf' }}</div>
                                <div class="document-size">{{ $kegiatan->ukuran_dokumen ?? '2.5 MB' }}</div>
                            </div>
                            <div class="document-actions">
                                <a href="#" class="btn-action btn-view" data-bs-toggle="tooltip" title="Lihat Dokumen">
                                    <i class="fas fa-eye"></i> Lihat
                                </a>
                                <a href="#" class="btn-action btn-download" data-bs-toggle="tooltip" title="Unduh Dokumen">
                                    <i class="fas fa-download"></i> Unduh
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="no-data">
                            <i class="fas fa-file-slash text-muted mb-2" style="font-size: 2rem;"></i>
                            <p>Tidak ada dokumen yang diunggah</p>
                        </div>
                    @endif
                </div>
                
                <!-- Photo Section -->
                <div class="attachment-section">
                    <h4 class="attachment-title">
                        <i class="fas fa-images text-info"></i>
                        Foto Jurnal ({{ $kegiatan->foto_count ?? 3 }} Foto)
                    </h4>
                    
                    @if($kegiatan->foto_jurnal ?? true)
                        <div class="photo-gallery">
                            <div class="photo-item" data-bs-toggle="modal" data-bs-target="#photoModal" data-photo="1">
                                <img src="https://via.placeholder.com/300x300/f8f9fa/666?text=Foto+Kegiatan+1" alt="Foto Jurnal 1">
                                <div class="photo-overlay">
                                    <i class="fas fa-search-plus"></i>
                                </div>
                            </div>
                            <div class="photo-item" data-bs-toggle="modal" data-bs-target="#photoModal" data-photo="2">
                                <img src="https://via.placeholder.com/300x300/f8f9fa/666?text=Foto+Kegiatan+2" alt="Foto Jurnal 2">
                                <div class="photo-overlay">
                                    <i class="fas fa-search-plus"></i>
                                </div>
                            </div>
                            <div class="photo-item" data-bs-toggle="modal" data-bs-target="#photoModal" data-photo="3">
                                <img src="https://via.placeholder.com/300x300/f8f9fa/666?text=Foto+Kegiatan+3" alt="Foto Jurnal 3">
                                <div class="photo-overlay">
                                    <i class="fas fa-search-plus"></i>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="no-data">
                            <i class="fas fa-image text-muted mb-2" style="font-size: 2rem;"></i>
                            <p>Tidak ada foto yang diunggah</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Additional Information -->
        <div class="detail-section">
            <h2 class="section-title">
                <i class="fas fa-sticky-note text-secondary"></i>
                Keterangan Tambahan
            </h2>
            
            @if($kegiatan->keterangan ?? false)
                <div class="info-item">
                    <div class="info-label">Catatan</div>
                    <div class="info-value">{{ $kegiatan->keterangan }}</div>
                </div>
            @else
                <div class="no-data">
                    <i class="fas fa-comment-slash text-muted mb-2" style="font-size: 2rem;"></i>
                    <p>Tidak ada keterangan tambahan</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Photo Modal -->
    <div class="modal fade" id="photoModal" tabindex="-1" aria-labelledby="photoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="background: #F8285A; color: white;">
                    <h5 class="modal-title text-white" id="photoModalLabel">Foto Jurnal</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-0">
                    <img id="modalPhoto" src="" alt="Foto" class="w-100" style="max-height: 70vh; object-fit: contain;">
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-success btn-sm">
                        <i class="fas fa-download"></i> Unduh Foto
                    </button>
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Action badge clicks
            $('.action-badge').click(function(e) {
                e.preventDefault();
                const action = $(this).find('i').hasClass('fa-lock') ? 'locked' : 
                              $(this).find('i').hasClass('fa-edit') ? 'edit' : 'export';
                
                switch(action) {
                    case 'edit':
                        if ($(this).hasClass('edit') && !$(this).hasClass('locked')) {
                            @if(auth()->user()->hasRole('superadmin'))
                                window.location.href = "{{ route('admin.laporan-lpj.kegiatan-lainnya.edit', $kegiatan->id ?? 1) }}";
                            @else
                                Swal.fire({
                                    title: 'Ajukan Perubahan',
                                    text: 'Anda akan mengajukan permintaan perubahan untuk kegiatan ini.',
                                    icon: 'question',
                                    showCancelButton: true,
                                    confirmButtonColor: '#F8285A',
                                    cancelButtonColor: '#6c757d',
                                    confirmButtonText: 'Ya, Ajukan',
                                    cancelButtonText: 'Batal'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        // Logic untuk ajukan perubahan
                                        Swal.fire({
                                            title: 'Berhasil!',
                                            text: 'Permintaan perubahan telah diajukan.',
                                            icon: 'success',
                                            confirmButtonColor: '#F8285A'
                                        });
                                    }
                                });
                            @endif
                        }
                        break;
                    case 'export':
                        Swal.fire({
                            title: 'Export Data',
                            text: 'Pilih format export yang diinginkan',
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonColor: '#F8285A',
                            cancelButtonColor: '#6c757d',
                            confirmButtonText: 'Export PDF',
                            cancelButtonText: 'Batal'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Logic export
                                const loadingToast = Swal.fire({
                                    title: 'Memproses Export...',
                                    allowOutsideClick: false,
                                    showConfirmButton: false,
                                    didOpen: () => {
                                        Swal.showLoading();
                                    }
                                });

                                // Simulate export process
                                setTimeout(() => {
                                    loadingToast.close();
                                    Swal.fire({
                                        title: 'Export Berhasil!',
                                        text: 'File telah berhasil diexport.',
                                        icon: 'success',
                                        confirmButtonColor: '#F8285A'
                                    });
                                }, 2000);
                            }
                        });
                        break;
                    case 'locked':
                        Swal.fire({
                            title: 'Data Terkunci',
                            text: 'Data ini telah dikunci dan tidak dapat diubah. Hubungi administrator untuk informasi lebih lanjut.',
                            icon: 'info',
                            confirmButtonColor: '#F8285A'
                        });
                        break;
                }
            });

            // Document action clicks
            $('.btn-view, .btn-download').click(function(e) {
                e.preventDefault();
                const action = $(this).hasClass('btn-view') ? 'view' : 'download';
                const fileName = $(this).closest('.document-item').find('.document-name').text();
                
                if (action === 'view') {
                    // Open preview modal or new window
                    Swal.fire({
                        title: 'Membuka Dokumen...',
                        text: 'Dokumen akan dibuka di tab baru',
                        icon: 'info',
                        timer: 1500,
                        showConfirmButton: false
                    });
                    // window.open(documentUrl, '_blank');
                } else {
                    // Download file
                    Swal.fire({
                        title: 'Mengunduh File...',
                        text: fileName,
                        icon: 'success',
                        timer: 1500,
                        showConfirmButton: false
                    });
                    // Download logic here
                }
            });

            // Photo modal functionality
            $('.photo-item').click(function() {
                const photoSrc = $(this).find('img').attr('src');
                const photoAlt = $(this).find('img').attr('alt');
                
                $('#modalPhoto').attr('src', photoSrc);
                $('#photoModalLabel').text(photoAlt);
            });

            // Photo download in modal
            $('#photoModal .btn-success').click(function() {
                const photoSrc = $('#modalPhoto').attr('src');
                Swal.fire({
                    title: 'Mengunduh Foto...',
                    icon: 'success',
                    timer: 1000,
                    showConfirmButton: false
                });
                // Download photo logic here
            });

            // Smooth scrolling for internal links
            $('a[href^="#"]').click(function(e) {
                e.preventDefault();
                const target = $($(this).attr('href'));
                if (target.length) {
                    $('html, body').animate({
                        scrollTop: target.offset().top - 100
                    }, 500);
                }
            });

            // Add loading states for buttons
            $('.action-badge, .btn-action').click(function() {
                const $btn = $(this);
                const originalContent = $btn.html();
                
                $btn.html('<i class="fas fa-spinner fa-spin"></i> Memproses...');
                $btn.prop('disabled', true);
                
                setTimeout(() => {
                    $btn.html(originalContent);
                    $btn.prop('disabled', false);
                }, 1000);
            });

            // Print functionality
            if (window.location.hash === '#print') {
                window.print();
            }

            // Add keyboard shortcuts
            $(document).keydown(function(e) {
                // Ctrl/Cmd + P for print
                if ((e.ctrlKey || e.metaKey) && e.keyCode === 80) {
                    e.preventDefault();
                    window.print();
                }
                
                // ESC to close modals
                if (e.keyCode === 27) {
                    $('.modal').modal('hide');
                }
            });

            // Lazy loading for images
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src || img.src;
                        img.classList.remove('lazy');
                        observer.unobserve(img);
                    }
                });
            });

            document.querySelectorAll('img[data-src]').forEach(img => {
                imageObserver.observe(img);
            });

            // Add success animation for completed actions
            function showSuccessAnimation() {
                $('body').append(`
                    <div class="success-animation" style="position: fixed; top: 20px; right: 20px; z-index: 9999;">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            <strong>Berhasil!</strong> Aksi telah berhasil dilakukan.
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    </div>
                `);
                
                setTimeout(() => {
                    $('.success-animation').fadeOut(300, function() {
                        $(this).remove();
                    });
                }, 3000);
            }

            // Add error handling for network issues
            window.addEventListener('online', function() {
                Swal.fire({
                    title: 'Koneksi Pulih',
                    text: 'Koneksi internet telah pulih',
                    icon: 'success',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
            });

            window.addEventListener('offline', function() {
                Swal.fire({
                    title: 'Koneksi Terputus',
                    text: 'Periksa koneksi internet Anda',
                    icon: 'warning',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 5000
                });
            });
        });

        // Additional utility functions
        function formatCurrency(amount) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(amount);
        }

        function formatDate(dateString) {
            return new Intl.DateTimeFormat('id-ID', {
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            }).format(new Date(dateString));
        }

        // Print styles
        const printStyles = `
            <style media="print">
                body * { visibility: hidden; }
                .detail-container, .detail-container * { visibility: visible; }
                .detail-container { 
                    position: static !important; 
                    margin: 0 !important;
                    box-shadow: none !important;
                }
                .action-badges, .back-button, 
                .btn-action, .photo-overlay { display: none !important; }
                .detail-header { background: #F8285A !important; }
                .photo-item { cursor: default !important; }
                .photo-item:hover { transform: none !important; }
            </style>
        `;
        
        $('head').append(printStyles);
    </script>

    <!-- SweetAlert2 for enhanced notifications -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection