@if($dokumenLpj && count($dokumenLpj) > 0)
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th width="80" style="text-align: center">No</th>
                    <th width="100">Tipe</th>
                    <th>Nama File</th>
                    <th width="120">Ukuran</th>
                    <th width="150">Tanggal Upload</th>
                    <th width="120"style="text-align: center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($dokumenLpj as $index => $dokumen)
                    @php
                        $filePath = storage_path('app/public/' . $dokumen);
                        $fileName = basename($dokumen);
                        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                        $fileSize = file_exists($filePath) ? filesize($filePath) : 0;
                        $fileSizeFormatted = $fileSize > 0 ? number_format($fileSize / 1024, 1) . ' KB' : 'N/A';
                        if ($fileSize > 1024 * 1024) {
                            $fileSizeFormatted = number_format($fileSize / (1024 * 1024), 1) . ' MB';
                        }

                        // Get file type info
                        $fileTypeInfo = match($fileExtension) {
                            'pdf' => ['icon' => 'fas fa-file-pdf', 'color' => 'text-danger', 'label' => 'PDF'],
                            'doc', 'docx' => ['icon' => 'fas fa-file-word', 'color' => 'text-primary', 'label' => 'Word'],
                            'xls', 'xlsx' => ['icon' => 'fas fa-file-excel', 'color' => 'text-success', 'label' => 'Excel'],
                            'ppt', 'pptx' => ['icon' => 'fas fa-file-powerpoint', 'color' => 'text-warning', 'label' => 'PowerPoint'],
                            'txt' => ['icon' => 'fas fa-file-alt', 'color' => 'text-secondary', 'label' => 'Text'],
                            default => ['icon' => 'fas fa-file', 'color' => 'text-muted', 'label' => 'File']
                        };
                    @endphp
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>
                            <div class="file-type-indicator">
                                <i class="{{ $fileTypeInfo['icon'] }} {{ $fileTypeInfo['color'] }} fs-4"></i>
                                <div class="file-ext-badge">
                                    <span class="badge bg-light text-dark">{{ strtoupper($fileExtension) }}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="file-info">
                                <div class="file-name" title="{{ $fileName }}">{{ $fileName }}</div>
                                <div class="file-type">
                                    <i class="{{ $fileTypeInfo['icon'] }} {{ $fileTypeInfo['color'] }} me-1"></i>
                                    {{ $fileTypeInfo['label'] }}
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
                                @if($fileExtension === 'pdf')
                                    <button type="button"
                                            class="btn btn-sm btn-outline-primary"
                                            data-bs-toggle="modal"
                                            data-bs-target="#pdfModal{{ $index }}"
                                            data-bs-toggle-tooltip="tooltip"
                                            data-bs-placement="top"
                                            title="Preview">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                @else
                                    <a href="{{ asset('storage/' . $dokumen) }}"
                                       target="_blank"
                                       class="btn btn-sm btn-outline-primary"
                                       data-bs-toggle="tooltip"
                                       data-bs-placement="top"
                                       title="Buka">
                                        <i class="fas fa-external-link-alt"></i>
                                    </a>
                                @endif
                                <a href="{{ asset('storage/' . $dokumen) }}"
                                   download="{{ $fileName }}"
                                   class="btn btn-sm btn-outline-success"
                                   data-bs-toggle="tooltip"
                                   data-bs-placement="top"
                                   title="Download">
                                    <i class="fas fa-download"></i>
                                </a>
                            </div>
                        </td>
                    </tr>

                    {{-- PDF Preview Modal --}}
                    @if($fileExtension === 'pdf')
                        <div class="modal fade" id="pdfModal{{ $index }}" tabindex="-1" aria-labelledby="pdfModalLabel{{ $index }}" aria-hidden="true">
                            <div class="modal-dialog modal-xl modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="pdfModalLabel{{ $index }}">
                                            <i class="fas fa-file-pdf text-danger me-2"></i>{{ $fileName }}
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body p-0">
                                        <iframe src="{{ asset('storage/' . $dokumen) }}"
                                                width="100%"
                                                height="600px"
                                                style="border: none;">
                                            <p>Browser Anda tidak mendukung preview PDF.
                                               <a href="{{ asset('storage/' . $dokumen) }}" target="_blank">Klik di sini untuk membuka file</a>
                                            </p>
                                        </iframe>
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
                                                <a href="{{ asset('storage/' . $dokumen) }}"
                                                   target="_blank"
                                                   class="btn btn-outline-primary btn-sm me-2">
                                                    <i class="fas fa-external-link-alt me-1"></i>Buka di Tab Baru
                                                </a>
                                                <a href="{{ asset('storage/' . $dokumen) }}"
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
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <div class="empty-state">
        <i class="fas fa-file-alt"></i>
        <h5 class="mb-2">Tidak ada dokumen LPJ</h5>
        <p class="text-muted mb-0">Belum ada dokumen LPJ yang diupload untuk data ini.</p>
    </div>
@endif

<style>
    .file-type-indicator {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 4px;
    }

    .file-ext-badge {
        font-size: 0.7rem;
    }

    .file-info {
        max-width: 250px;
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

    .modal-body iframe {
        min-height: 600px;
    }

    .file-details {
        display: flex;
        align-items: center;
    }

    .modal-actions {
        display: flex;
        align-items: center;
    }

    /* File type specific colors */
    .text-pdf { color: #dc3545 !important; }
    .text-word { color: #2b579a !important; }
    .text-excel { color: #217346 !important; }
    .text-powerpoint { color: #d24726 !important; }

    @media (max-width: 768px) {
        .modal-dialog {
            margin: 10px;
        }

        .modal-body iframe {
            height: 400px;
        }

        .modal-footer {
            flex-direction: column;
            gap: 10px;
        }

        .file-details,
        .modal-actions {
            width: 100%;
            justify-content: center;
        }

        .file-info {
            max-width: 150px;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize tooltips for document table
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
