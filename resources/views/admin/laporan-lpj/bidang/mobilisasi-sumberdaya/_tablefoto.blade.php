@if($fotoJurnal && count($fotoJurnal) > 0)
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th width="80" style="text-align: center">No</th>
                    <th width="150">Preview</th>
                    <th>Nama File</th>
                    <th width="120">Ukuran</th>
                    <th width="150">Tanggal Upload</th>
                    <th width="120"style="text-align: center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($fotoJurnal as $index => $foto)
                    @php
                        $filePath = storage_path('app/public/' . $foto);
                        $fileName = basename($foto);
                        $fileSize = file_exists($filePath) ? filesize($filePath) : 0;
                        $fileSizeFormatted = $fileSize > 0 ? number_format($fileSize / 1024, 1) . ' KB' : 'N/A';
                        if ($fileSize > 1024 * 1024) {
                            $fileSizeFormatted = number_format($fileSize / (1024 * 1024), 1) . ' MB';
                        }
                    @endphp
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>
                            <div class="photo-preview-container">
                                <img src="{{ asset('storage/' . $foto) }}"
                                     alt="Preview {{ $fileName }}"
                                     class="photo-preview"
                                     data-bs-toggle="modal"
                                     data-bs-target="#photoModal{{ $index }}"
                                     style="cursor: pointer;">
                            </div>
                        </td>
                        <td>
                            <div class="file-info">
                                <div class="file-name" title="{{ $fileName }}">{{ $fileName }}</div>
                                <div class="file-type">
                                    <i class="fas fa-image text-success me-1"></i>
                                    Image
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark">{{ $fileSizeFormatted }}</span>
                        </td>
                        <td>
                            <small class="text-muted">
                                {{ isset($sumberdaya) ? $sumberdaya->created_at->format('d/m/Y') : date('d/m/Y') }}
                            </small>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ asset('storage/' . $foto) }}"
                                   target="_blank"
                                   class="btn btn-sm btn-outline-primary"
                                   data-bs-toggle="tooltip"
                                   data-bs-placement="top"
                                   title="Lihat">
                                    <i class="fas fa-eye fa-eye"></i>
                                </a>
                                <a href="{{ asset('storage/' . $foto) }}"
                                   download="{{ $fileName }}"
                                   class="btn btn-sm btn-outline-success"
                                   data-bs-toggle="tooltip"
                                   data-bs-placement="top"
                                   title="Download">
                                    <i class="fas fa-download fa-download"></i>
                                </a>
                            </div>
                        </td>
                    </tr>

                    {{-- Photo Modal --}}
                    <div class="modal fade" id="photoModal{{ $index }}" tabindex="-1" aria-labelledby="photoModalLabel{{ $index }}" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="photoModalLabel{{ $index }}">{{ $fileName }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body text-center">
                                    <img src="{{ asset('storage/' . $foto) }}"
                                         alt="{{ $fileName }}"
                                         class="img-fluid rounded"
                                         style="max-height: 70vh; object-fit: contain;">
                                </div>
                                <div class="modal-footer">
                                    <div class="d-flex justify-content-between w-100">
                                        <div class="file-details">
                                            <small class="text-muted">
                                                Ukuran: {{ $fileSizeFormatted }} |
                                                Upload: {{ isset($sumberdaya) ? $sumberdaya->created_at->format('d F Y') : date('d F Y') }}
                                            </small>
                                        </div>
                                        <div class="modal-actions">
                                            <a href="{{ asset('storage/' . $foto) }}"
                                               target="_blank"
                                               class="btn btn-outline-primary btn-sm me-2">
                                                <i class="fas fa-external-link-alt me-1"></i>Buka di Tab Baru
                                            </a>
                                            <a href="{{ asset('storage/' . $foto) }}"
                                               download="{{ $fileName }}"
                                               class="btn btn-success btn-sm">
                                                <i class="fas fa-download me-1"></i>Download
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <div class="empty-state">
        <i class="fas fa-images"></i>
        <h5 class="mb-2">Tidak ada foto jurnal</h5>
        <p class="text-muted mb-0">Belum ada foto jurnal yang diupload untuk data ini.</p>
    </div>
@endif

<style>
    .photo-preview {
        width: 80px;
        height: 60px;
        object-fit: cover;
        border-radius: 8px;
        border: 2px solid #e9ecef;
        transition: all 0.3s ease;
    }

    .photo-preview:hover {
        border-color: #F8285A;
        transform: scale(1.05);
    }

    .photo-preview-container {
        position: relative;
        display: inline-block;
    }

    .photo-preview-container::after {
        content: '\f065';
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
        position: absolute;
        top: 5px;
        right: 5px;
        background: rgba(0, 0, 0, 0.7);
        color: white;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 10px;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .photo-preview-container:hover::after {
        opacity: 1;
    }

    .file-info {
        max-width: 200px;
    }

    .file-name {
        font-weight: 500;
        color: #212529;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        margin-bottom: 4px;
    }

    .file-type {
        font-size: 0.8rem;
        color: #6c757d;
    }

    .btn-group .btn {
        padding: 4px 8px;
    }

    .modal-body img {
        max-width: 100%;
        height: auto;
    }

    .file-details {
        display: flex;
        align-items: center;
    }

    .modal-actions {
        display: flex;
        align-items: center;
    }

    @media (max-width: 768px) {
        .modal-footer {
            flex-direction: column;
            gap: 10px;
        }

        .file-details,
        .modal-actions {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize tooltips for photo table
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
