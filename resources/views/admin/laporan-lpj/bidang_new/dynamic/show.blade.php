@extends('layouts.app')

@section('pageTitle', 'Detail Laporan LPJ')
@section('mainSection', 'Laporan LPJ')
@section('subSection', 'Bidang Bidang')
@section('subSectionUrl', route('admin.laporan-lpj.bidang.index'))
@section('currentSection', 'Detail Laporan')

@section('breadcrumb-items')
    @foreach($breadcrumbs as $breadcrumb)
        @if($breadcrumb['active'])
            <li class="breadcrumb-item active">{{ $breadcrumb['title'] }}</li>
        @else
            <li class="breadcrumb-item">
                <a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['title'] }}</a>
            </li>
        @endif
    @endforeach
@endsection

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

        .detail-item {
            display: flex;
            padding: 15px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .detail-item:last-child {
            border-bottom: none;
        }

        .detail-label {
            font-weight: 600;
            color: #495057;
            min-width: 200px;
            flex-shrink: 0;
        }

        .detail-value {
            flex: 1;
            color: #212529;
        }

        .file-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 10px;
        }

        .file-card {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            overflow: hidden;
            background: white;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .file-card:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        .file-preview {
            height: 120px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8f9fa;
            position: relative;
        }

        .file-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .file-preview i {
            font-size: 2rem;
            color: #6c757d;
        }

        .file-info {
            padding: 10px;
            border-top: 1px solid #dee2e6;
        }

        .file-name {
            font-size: 0.85rem;
            font-weight: 500;
            margin-bottom: 5px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .file-size {
            font-size: 0.75rem;
            color: #6c757d;
        }

        .btn-back {
            background: #6c757d;
            border-color: #6c757d;
            color: white;
            border-radius: 8px;
            padding: 12px 24px;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .btn-back:hover {
            background: #5a6268;
            border-color: #5a6268;
            color: white;
        }

        .btn-edit {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            border: none;
            border-radius: 8px;
            padding: 12px 24px;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 123, 255, 0.3);
        }

        .btn-edit:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 123, 255, 0.4);
        }

        .badge-status {
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .badge-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .currency-value {
            font-weight: 600;
            color: #28a745;
            font-size: 1.1rem;
        }

        .section-header {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 15px 20px;
            margin: -20px -20px 20px -20px;
            border-bottom: 1px solid #dee2e6;
        }

        .section-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: #495057;
            margin: 0;
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

        .timestamp-info {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            margin-top: 20px;
        }

        .timestamp-info h6 {
            color: #495057;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .timestamp-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 5px 0;
        }
    </style>

    <div class="d-flex justify-content-between align-items-center flex-wrap mb-4" style="padding: 20px 20px">
        <h3 class="fw-bold fs-2 mb-0 text-dark">Detail Laporan LPJ</h3>
        <div class="d-flex gap-2">
            @if(auth()->user()->hasRole('superadmin'))
                <a href="{{ route('admin.laporan-lpj.bidang.dynamic.edit', $lpj->id) }}"
                   class="btn btn-edit">
                    <i class="fas fa-edit me-2"></i>Edit Laporan
                </a>
            @endif
            <a href="{{ $lpj->parent_id ? route('admin.laporan-lpj.bidang.dynamic.child.index', $lpj->parent_id) : route('admin.laporan-lpj.bidang.dynamic.index') }}"
               class="btn btn-back">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                {{-- Basic Information Card --}}
                <div class="col-12">
                    <div class="card card-detail">
                        <div class="card-body p-4 p-md-5">
                            <div class="section-header">
                                <h4 class="section-title">
                                    <i class="fas fa-info-circle me-2"></i>Informasi Dasar
                                </h4>
                            </div>

                            <div class="detail-item">
                                <div class="detail-label">Nama Program:</div>
                                <div class="detail-value">
                                    <strong>{{ $lpj->nama_program }}</strong>
                                </div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-label">Nama Kegiatan:</div>
                                <div class="detail-value">
                                    <strong>{{ $lpj->nama_kegiatan }}</strong>
                                </div>
                            </div>

                            @if($lpj->volume)
                                <div class="detail-item">
                                    <div class="detail-label">Volume:</div>
                                    <div class="detail-value">{{ $lpj->volume }}</div>
                                </div>
                            @endif

                            @if($lpj->jumlah_harga_satuan)
                                <div class="detail-item">
                                    <div class="detail-label">Harga Satuan:</div>
                                    <div class="detail-value">
                                        <span class="currency-value">Rp {{ number_format($lpj->jumlah_harga_satuan, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            @endif

                            @if($lpj->jumlah_harga)
                                <div class="detail-item">
                                    <div class="detail-label">Total Harga:</div>
                                    <div class="detail-value">
                                        <span class="currency-value">Rp {{ number_format($lpj->jumlah_harga, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            @endif

                            @if($lpj->keterangan_tambahan)
                                <div class="detail-item">
                                    <div class="detail-label">Keterangan Tambahan:</div>
                                    <div class="detail-value">
                                        <div style="white-space: pre-wrap;">{{ $lpj->keterangan_tambahan }}</div>
                                    </div>
                                </div>
                            @endif

                            <div class="detail-item">
                                <div class="detail-label">Status:</div>
                                <div class="detail-value">
                                    <span class="badge badge-status badge-success">
                                        <i class="fas fa-check-circle me-1"></i>Aktif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Foto Jurnal Card --}}
                <div class="col-12">
                    <div class="card card-detail">
                        <div class="card-body p-4 p-md-5">
                            <div class="section-header">
                                <h4 class="section-title">
                                    <i class="fas fa-images me-2"></i>Foto Jurnal
                                </h4>
                            </div>

                            @if($lpj->foto_jurnal && count($lpj->foto_jurnal) > 0)
                                <div class="file-grid">
                                    @foreach($lpj->foto_jurnal as $index => $foto)
                                        <div class="file-card"
                                             onclick="openImageModal('{{ asset('storage/' . $foto) }}', '{{ basename($foto) }}')">
                                            <div class="file-preview">
                                                <img src="{{ asset('storage/' . $foto) }}"
                                                     alt="Foto {{ $index + 1 }}"
                                                     loading="lazy">
                                            </div>
                                            <div class="file-info">
                                                <div class="file-name">{{ basename($foto) }}</div>
                                                <div class="file-size">
                                                    @if(Storage::exists($foto))
                                                        {{ formatFileSize(Storage::size($foto)) }}
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="empty-state">
                                    <i class="fas fa-image"></i>
                                    <p class="mb-0">Tidak ada foto jurnal yang diunggah</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Dokumen LPJ Card --}}
                <div class="col-12">
                    <div class="card card-detail">
                        <div class="card-body p-4 p-md-5">
                            <div class="section-header">
                                <h4 class="section-title">
                                    <i class="fas fa-file-alt me-2"></i>Dokumen LPJ
                                </h4>
                            </div>

                            @if($lpj->dokumen_lpj && count($lpj->dokumen_lpj) > 0)
                                <div class="file-grid">
                                    @foreach($lpj->dokumen_lpj as $index => $dokumen)
                                        @php
                                            $extension = pathinfo($dokumen, PATHINFO_EXTENSION);
                                            $icon = match(strtolower($extension)) {
                                                'pdf' => 'fas fa-file-pdf text-danger',
                                                'doc', 'docx' => 'fas fa-file-word text-primary',
                                                'xls', 'xlsx' => 'fas fa-file-excel text-success',
                                                default => 'fas fa-file text-secondary'
                                            };
                                        @endphp
                                        <div class="file-card"
                                             onclick="downloadFile('{{ asset('storage/' . $dokumen) }}', '{{ basename($dokumen) }}')">
                                            <div class="file-preview">
                                                <i class="{{ $icon }}"></i>
                                            </div>
                                            <div class="file-info">
                                                <div class="file-name">{{ basename($dokumen) }}</div>
                                                <div class="file-size">
                                                    @if(Storage::exists($dokumen))
                                                        {{ formatFileSize(Storage::size($dokumen)) }}
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="empty-state">
                                    <i class="fas fa-file-alt"></i>
                                    <p class="mb-0">Tidak ada dokumen LPJ yang diunggah</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Timestamp Information --}}
                <div class="col-12">
                    <div class="card card-detail">
                        <div class="card-body p-4 p-md-5">
                            <div class="section-header">
                                <h4 class="section-title">
                                    <i class="fas fa-clock me-2"></i>Informasi Waktu
                                </h4>
                            </div>

                            <div class="timestamp-info">
                                <div class="timestamp-item">
                                    <span><strong>Dibuat:</strong></span>
                                    <span>{{ $lpj->created_at->format('d/m/Y H:i:s') }}</span>
                                </div>
                                @if($lpj->updated_at != $lpj->created_at)
                                    <div class="timestamp-item">
                                        <span><strong>Terakhir Diubah:</strong></span>
                                        <span>{{ $lpj->updated_at->format('d/m/Y H:i:s') }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Image Modal --}}
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Preview Foto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center p-0" style="height: 70vh;">
                    <img id="modalImage" src="" alt="Preview"
                         class="img-fluid h-100" style="object-fit: contain;">
                </div>
                <div class="modal-footer">
                    <div class="d-flex justify-content-between align-items-center w-100">
                        <span id="modalImageName" class="fw-bold"></span>
                        <a id="downloadImageBtn" href="" download class="btn btn-success">
                            <i class="fas fa-download me-2"></i>Download
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Open image in modal
        function openImageModal(imageUrl, imageName) {
            document.getElementById('modalImage').src = imageUrl;
            document.getElementById('modalImageName').textContent = imageName;
            document.getElementById('downloadImageBtn').href = imageUrl;
            document.getElementById('downloadImageBtn').download = imageName;

            const modal = new bootstrap.Modal(document.getElementById('imageModal'));
            modal.show();
        }

        // Download file
        function downloadFile(fileUrl, fileName) {
            const link = document.createElement('a');
            link.href = fileUrl;
            link.download = fileName;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }

        // Format file size helper (if not available from backend)
        @if(!function_exists('formatFileSize'))
        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }
        @endif

        // Keyboard navigation for image modal
        document.addEventListener('keydown', function(e) {
            const modal = bootstrap.Modal.getInstance(document.getElementById('imageModal'));
            if (modal && modal._isShown) {
                if (e.key === 'Escape') {
                    modal.hide();
                }
            }
        });

        // Add loading states for images
        document.addEventListener('DOMContentLoaded', function() {
            const images = document.querySelectorAll('.file-preview img');
            images.forEach(img => {
                img.addEventListener('load', function() {
                    this.style.opacity = '1';
                });

                img.addEventListener('error', function() {
                    this.parentElement.innerHTML = '<i class="fas fa-image-slash text-muted"></i>';
                });

                // Add loading spinner initially
                img.style.opacity = '0.5';
            });
        });
    </script>
@endsection

@php
if (!function_exists('formatFileSize')) {
    function formatFileSize($bytes) {
        if ($bytes === 0) return '0 Bytes';
        $k = 1024;
        $sizes = ['Bytes', 'KB', 'MB', 'GB'];
        $i = floor(log($bytes) / log($k));
        return round($bytes / pow($k, $i), 2) . ' ' . $sizes[$i];
    }
}
@endphp
