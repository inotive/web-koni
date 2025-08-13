@if($files->isEmpty())
    <div class="empty-state">
        <i class="fas fa-folder-open"></i>
        <h4>Belum ada data file yang tersedia.</h4>
        <p>Mulailah dengan menambahkan file baru.</p>
    </div>
@else
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="bg-light">
                <tr>
                    <th>No</th>
                    <th>
                        <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'nama_dokumen', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}"
                           class="text-dark text-decoration-none d-flex align-items-center">
                            Nama Dokumen
                            @if (request('sort_by') == 'nama_dokumen')
                                <i class="fas fa-arrow-{{ request('order') == 'asc' ? 'up' : 'down' }} ms-1"></i>
                            @else
                                <i class="fas fa-sort ms-1 text-muted"></i>
                            @endif
                        </a>
                    </th>
                    <th>File</th>
                    <th>
                        <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'created_at', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}"
                           class="text-dark text-decoration-none d-flex align-items-center">
                            Tanggal Upload
                            @if (request('sort_by') == 'created_at')
                                <i class="fas fa-arrow-{{ request('order') == 'asc' ? 'up' : 'down' }} ms-1"></i>
                            @else
                                <i class="fas fa-sort ms-1 text-muted"></i>
                            @endif
                        </a>
                    </th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                @foreach($files as $index => $file)
                    <tr id="file-row-{{ $file->id }}">
                        <td class="text-center">{{ $files->firstItem() + $index }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-file-alt file-icon"></i>
                                <strong class="text-truncate-custom">{{ $file->nama_dokumen }}</strong>
                            </div>
                        </td>
                        <td>
                            <span class="file-badge">{{ $file->dokumen_file }}</span>
                        </td>
                        <td>{{ $file->created_at->format('d M Y H:i') }}</td>
                        <td class="text-center">
                            <div class="dropdown">
                                <button class="btn btn-sm p-0" type="button" data-bs-toggle="dropdown" data-bs-toggle="tooltip" title="Aksi">
                                    <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <!-- SVG Anda yang sama -->
                                    </svg>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end cursor-pointer">
                                    <li>
                                        <a href="{{ route('admin.file-kesekretariat.show', $file) }}" class="dropdown-item" data-bs-toggle="tooltip" title="Lihat Detail">
                                            <i class="fas fa-eye me-2"></i>Lihat
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.file-kesekretariat.edit', $file) }}" class="dropdown-item" data-bs-toggle="tooltip" title="Edit File">
                                            <i class="fas fa-edit me-2"></i>Edit
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="dropdown-item delete-btn"
                                           data-file-id="{{ $file->id }}"
                                           data-file-name="{{ $file->nama_dokumen }}"
                                           data-delete-url="{{ route('admin.file-kesekretariat.destroy', $file) }}"
                                           data-bs-toggle="tooltip" title="Hapus File">
                                            <i class="fas fa-trash me-2"></i>Hapus
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.file-kesekretariat.download', $file) }}" class="dropdown-item" data-bs-toggle="tooltip" title="Download File">
                                            <i class="fas fa-download me-2"></i>Download
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if ($files->hasPages())
        <!-- Pagination (sama seperti sebelumnya) -->
    @endif
@endif