<div class="container-fluid">
    <div class="row">
        <!-- Informasi Umum -->
        <div class="col-12">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle text-primary me-2"></i>Informasi Kegiatan
                    </h5>
                </div>
                <div class="card-body">
                    @if($kegiatan->status_approval !== 'approved')
        <div class="alert alert-danger d-flex align-items-center mb-4" role="alert">
            <i class="fas fa-lock me-2 fs-4"></i>
            <div>
                <strong>Status: Terkunci</strong><br>
                <small>Data ini belum disetujui oleh Superadmin. Tidak dapat diedit.</small>
            </div>
        </div>
    @endif
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Nama Program & Kegiatan</label>
                                <p class="mb-0 text-dark">{{ $kegiatan->nama_program_kegiatan }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Jenis Kegiatan</label>
                                <p class="mb-0">
                                    <span class="badge bg-info">{{ $kegiatan->jenis_kegiatan ?? '-' }}</span>
                                </p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Volume</label>
                                <p class="mb-0 text-dark">{{ $kegiatan->volume }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Jumlah Harga Satuan</label>
                                <p class="mb-0 text-success fw-bold">
                                    Rp {{ number_format($kegiatan->jumlah_harga_satuan, 0, ',', '.') }}
                                </p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Jumlah Harga Total</label>
                                <p class="mb-0 text-success fw-bold fs-5">
                                    Rp {{ number_format($kegiatan->jumlah_harga, 0, ',', '.') }}
                                </p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Tanggal Dibuat</label>
                                <p class="mb-0 text-muted">
                                    {{ \Carbon\Carbon::parse($kegiatan->created_at)->format('d F Y, H:i') }} WIB
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Foto dan Dokumen -->
        <div class="col-12">
            <div class="row">
                <!-- Foto Jurnal -->
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-light">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-camera text-success me-2"></i>Foto Jurnal
                            </h5>
                        </div>
                        <div class="card-body text-center">
                            @if($kegiatan->foto_jurnal_url)
                                <div class="position-relative">
                                    <div class="image-container mb-3" style="position: relative; display: inline-block;">
                                        <img src="{{ $kegiatan->foto_jurnal_url }}" 
                                             class="img-fluid rounded shadow-sm cursor-pointer" 
                                             style="max-height: 300px; max-width: 100%; object-fit: contain; cursor: zoom-in;"
                                             alt="Foto Jurnal"
                                             onclick="showImageModal('{{ $kegiatan->foto_jurnal_url }}')"
                                             onerror="handleImageError(this)"
                                             onload="handleImageLoad(this)">
                                        
                                        <!-- Loading placeholder -->
                                        <div class="image-loading position-absolute top-50 start-50 translate-middle" style="display: none;">
                                            <div class="spinner-border text-primary" role="status">
                                                <span class="visually-hidden">Memuat gambar...</span>
                                            </div>
                                        </div>
                                        
                                        <!-- Error placeholder -->
                                        <div class="image-error text-center py-4" style="display: none;">
                                            <i class="fas fa-image text-muted fs-1 mb-2"></i>
                                            <p class="text-muted mb-0">Gambar tidak dapat dimuat</p>
                                            <small class="text-muted">Klik untuk mencoba membuka di tab baru</small>
                                        </div>
                                    </div>
                                    
                                    <div class="d-flex gap-2 justify-content-center">
                                        <a href="{{ $kegiatan->foto_jurnal_url }}" 
                                           target="_blank" 
                                           class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-external-link-alt me-1"></i>Buka di Tab Baru
                                        </a>
                                        <button type="button" 
                                                class="btn btn-outline-success btn-sm" 
                                                onclick="showImageModal('{{ $kegiatan->foto_jurnal_url }}')">
                                            <i class="fas fa-search-plus me-1"></i>Perbesar
                                        </button>
                                    </div>
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <i class="fas fa-image fs-1 text-muted mb-3"></i>
                                    <p class="text-muted mb-0">Tidak ada foto jurnal</p>
                                    <small class="text-muted">File foto belum diunggah atau tidak ditemukan</small>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Dokumen Pendukung -->
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-light">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-file-alt text-warning me-2"></i>Dokumen Pendukung
                            </h5>
                        </div>
                        <div class="card-body text-center">
                            @if($kegiatan->dokumen_info)
                                <div class="d-flex flex-column align-items-center">
                                    <!-- Icon dokumen berdasarkan tipe file -->
                                    <div class="document-icon mb-3">
                                        <i class="{{ $kegiatan->dokumen_info['iconClass'] }}" style="font-size: 4rem;"></i>
                                    </div>
                                    
                                    <!-- Informasi file -->
                                    <div class="document-info mb-3 text-center">
                                        <h6 class="mb-1 fw-bold">{{ $kegiatan->dokumen_info['extension'] }} Document</h6>
                                        <p class="mb-0 text-muted small">{{ $kegiatan->dokumen_info['fileName'] }}</p>
                                    </div>
                                    
                                    <!-- Tombol aksi -->
                                    <div class="d-flex gap-2 flex-wrap justify-content-center">
                                        <!-- Tombol Preview/View -->
                                        <a href="{{ $kegiatan->dokumen_info['url'] }}" 
                                           target="_blank" 
                                           class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-eye me-1"></i>Lihat Dokumen
                                        </a>
                                        
                                        <!-- Tombol Download -->
                                        <a href="{{ $kegiatan->dokumen_info['url'] }}" 
                                           download="{{ $kegiatan->dokumen_info['originalName'] }}"
                                           class="btn btn-outline-success btn-sm">
                                            <i class="fas fa-download me-1"></i>Unduh
                                        </a>
                                        
                                        <!-- Tombol Copy Link -->
                                        <button type="button" 
                                                class="btn btn-outline-secondary btn-sm"
                                                onclick="copyToClipboard('{{ $kegiatan->dokumen_info['url'] }}', this)">
                                            <i class="fas fa-link me-1"></i>Copy Link
                                        </button>
                                    </div>
                                    
                                    <!-- File size info (jika tersedia) -->
                                    <small class="text-muted mt-2">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Klik "Lihat Dokumen" untuk membuka di browser atau "Unduh" untuk menyimpan file
                                    </small>
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <i class="fas fa-file fs-1 text-muted mb-3"></i>
                                    <p class="text-muted mb-0">Tidak ada dokumen pendukung</p>
                                    <small class="text-muted">File dokumen belum diunggah atau tidak ditemukan</small>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Keterangan Tambahan -->
        @if($kegiatan->keterangan_tambahan)
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-sticky-note text-info me-2"></i>Keterangan Tambahan
                    </h5>
                </div>
                <div class="card-body">
                    <div class="bg-light rounded p-3">
                        <p class="mb-0 text-dark">{{ $kegiatan->keterangan_tambahan }}</p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Summary Card -->
        <div class="col-12 mt-3">
            <div class="card border-0 bg-primary bg-opacity-10">
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-4">
                            <h6 class="text-muted mb-1">Volume</h6>
                            <h5 class="text-primary mb-0">{{ $kegiatan->volume }}</h5>
                        </div>
                        <div class="col-md-4">
                            <h6 class="text-muted mb-1">Harga Satuan</h6>
                            <h5 class="text-success mb-0">Rp {{ number_format($kegiatan->jumlah_harga_satuan, 0, ',', '.') }}</h5>
                        </div>
                        <div class="col-md-4">
                            <h6 class="text-muted mb-1">Total Harga</h6>
                            <h4 class="text-success mb-0 fw-bold">Rp {{ number_format($kegiatan->jumlah_harga, 0, ',', '.') }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Function untuk menampilkan gambar dalam modal penuh
function showImageModal(imageUrl) {
    const imageModal = $(`
        <div class="modal fade" id="imageViewModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-image me-2"></i>Foto Jurnal - Detail View
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body text-center p-0">
                        <div class="position-relative">
                            <img src="${imageUrl}" 
                                 class="img-fluid" 
                                 style="max-height: 80vh; max-width: 100%; object-fit: contain;"
                                 onload="handleModalImageLoad(this)"
                                 onerror="handleModalImageError(this)">
                            
                            <!-- Loading for modal image -->
                            <div class="modal-image-loading position-absolute top-50 start-50 translate-middle">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Memuat gambar...</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="${imageUrl}" target="_blank" class="btn btn-primary">
                            <i class="fas fa-external-link-alt me-1"></i>Buka di Tab Baru
                        </a>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `);

    // Remove existing modal if any
    $('#imageViewModal').remove();
    
    // Add to body and show
    $('body').append(imageModal);
    $('#imageViewModal').modal('show');
    
    // Clean up when hidden
    $('#imageViewModal').on('hidden.bs.modal', function() {
        $(this).remove();
    });
}

// Handle image load success
function handleImageLoad(img) {
    $(img).siblings('.image-loading').hide();
    $(img).siblings('.image-error').hide();
    $(img).fadeIn();
}

// Handle image load error
function handleImageError(img) {
    $(img).hide();
    $(img).siblings('.image-loading').hide();
    const errorDiv = $(img).siblings('.image-error');
    errorDiv.show();
    
    // Make error div clickable to try opening in new tab
    errorDiv.css('cursor', 'pointer').on('click', function() {
        window.open($(img).attr('src'), '_blank');
    });
}

// Handle modal image load
function handleModalImageLoad(img) {
    $(img).siblings('.modal-image-loading').hide();
}

// Handle modal image error
function handleModalImageError(img) {
    $(img).hide();
    $(img).siblings('.modal-image-loading').hide();
    $(img).parent().html(`
        <div class="text-center py-5">
            <i class="fas fa-exclamation-triangle text-warning fs-1 mb-3"></i>
            <h5>Gambar Tidak Dapat Dimuat</h5>
            <p class="text-muted">Terjadi masalah saat memuat gambar</p>
        </div>
    `);
}

// Function untuk copy link ke clipboard
function copyToClipboard(text, button) {
    navigator.clipboard.writeText(text).then(function() {
        const originalContent = $(button).html();
        $(button).html('<i class="fas fa-check me-1"></i>Tersalin!');
        $(button).removeClass('btn-outline-secondary').addClass('btn-success');
        
        setTimeout(function() {
            $(button).html(originalContent);
            $(button).removeClass('btn-success').addClass('btn-outline-secondary');
        }, 2000);
    }).catch(function(err) {
        console.error('Could not copy text: ', err);
        // Fallback for older browsers
        const textArea = document.createElement("textarea");
        textArea.value = text;
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();
        try {
            document.execCommand('copy');
            const originalContent = $(button).html();
            $(button).html('<i class="fas fa-check me-1"></i>Tersalin!');
            $(button).removeClass('btn-outline-secondary').addClass('btn-success');
            
            setTimeout(function() {
                $(button).html(originalContent);
                $(button).removeClass('btn-success').addClass('btn-outline-secondary');
            }, 2000);
        } catch (err) {
            console.error('Fallback: Oops, unable to copy', err);
        }
        document.body.removeChild(textArea);
    });
}

// Initialize tooltips
$(document).ready(function() {
    $('[data-bs-toggle="tooltip"]').tooltip();
});
</script>

<style>
/* Custom styles for image and document display */
.image-container img {
    transition: transform 0.3s ease;
}

.image-container img:hover {
    transform: scale(1.05);
}

.document-icon {
    transition: transform 0.3s ease;
}

.document-icon:hover {
    transform: scale(1.1);
}

.cursor-pointer {
    cursor: pointer;
}

.image-loading, .image-error {
    min-height: 200px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .modal-xl {
        margin: 10px;
    }
    
    .d-flex.gap-2 {
        flex-direction: column;
        gap: 0.5rem !important;
    }
    
    .btn-sm {
        width: 100%;
    }
}
</style>