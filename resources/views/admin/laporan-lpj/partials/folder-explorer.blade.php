{{--
    Tampilan folder ala file explorer.
    Variabel:
    - $folders      : koleksi folder (Lpj) yang ditampilkan, sebaiknya dengan withCount subfolder_count & entry_count
    - $parentFolder : folder tempat folder baru dibuat (null = level paling atas Bidang Bidang)
    - $folderUrl    : closure fn(Lpj $folder) => url untuk membuka folder
    - $trail        : array path [['title' => ..., 'url' => ...|null], ...]
    - $showGrid     : false untuk hanya memuat modal & script (tanpa grid folder)
--}}
@php
    $trail = $trail ?? [];
@endphp

<style>
    .folder-explorer {
        background: #fff;
        border: 1px solid #e9ecef;
        border-radius: 16px;
        padding: 20px 25px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    }

    .folder-path {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 6px;
        font-size: 0.95rem;
    }

    .folder-path a {
        color: #1F6B5A;
        font-weight: 600;
        text-decoration: none;
    }

    .folder-path a:hover {
        text-decoration: underline;
    }

    .folder-path .current {
        color: #071437;
        font-weight: 600;
    }

    .folder-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(210px, 1fr));
        gap: 14px;
    }

    .folder-item {
        position: relative;
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px 16px;
        border: 1px solid #e9ecef;
        border-radius: 12px;
        background: #fff;
        color: inherit;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .folder-item:hover {
        border-color: #1F6B5A;
        background: #F4FAF7;
        color: inherit;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(31, 107, 90, 0.12);
    }

    .folder-item .folder-icon {
        flex-shrink: 0;
        width: 44px;
        height: 44px;
        border-radius: 10px;
        background: #E3F1EA;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .folder-item .folder-icon i {
        font-size: 22px;
        color: #1F6B5A !important;
    }

    .folder-item .folder-name {
        font-weight: 600;
        color: #071437;
        line-height: 1.3;
        word-break: break-word;
        text-decoration: none;
    }

    .folder-item .folder-meta {
        font-size: 0.8rem;
        color: #78829d;
    }

    .folder-item .folder-actions {
        position: absolute;
        top: 6px;
        right: 6px;
        z-index: 2;
    }

    .folder-item .folder-actions .btn {
        padding: 2px 8px;
        color: #78829d;
    }

    .folder-empty {
        border: 1px dashed #d1d5db;
        border-radius: 12px;
        padding: 18px;
        text-align: center;
        color: #78829d;
    }
</style>

@if ($showGrid ?? true)
<div class="folder-explorer mb-5">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div class="folder-path">
            <i class="fa-solid fa-folder-open me-1" style="color:#1F6B5A"></i>
            @foreach ($trail as $crumb)
                @if (!$loop->first)
                    <i class="fa-solid fa-chevron-right text-muted" style="font-size:0.7rem"></i>
                @endif
                @if ($crumb['url'] && !$loop->last)
                    <a href="{{ $crumb['url'] }}">{{ $crumb['title'] }}</a>
                @else
                    <span class="current">{{ $crumb['title'] }}</span>
                @endif
            @endforeach
        </div>

        <button type="button" class="btn btn-light-primary btn-sm" data-bs-toggle="modal"
            data-bs-target="#createFolderModal">
            <i class="fa-solid fa-folder-plus me-1"></i> Tambah Folder
        </button>
    </div>

    @if ($folders->isEmpty())
        <div class="folder-empty">
            <i class="fa-regular fa-folder me-1"></i> Belum ada folder di sini.
        </div>
    @else
        <div class="folder-grid">
            @foreach ($folders as $folder)
                <div class="folder-item">
                    <span class="folder-icon"><i class="fa-solid fa-folder"></i></span>
                    <span class="d-flex flex-column pe-5">
                        <a href="{{ $folderUrl($folder) }}" class="folder-name stretched-link">{{ $folder->nama_program }}</a>
                        <span class="folder-meta">
                            {{ $folder->subfolder_count ?? 0 }} folder · {{ $folder->entry_count ?? 0 }} SPJ
                        </span>
                    </span>
                    <span class="folder-actions dropdown">
                        <button type="button" class="btn btn-sm" data-bs-toggle="dropdown" aria-expanded="false"
                            title="Aksi folder">
                            <i class="fa-solid fa-ellipsis-vertical"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <button type="button" class="dropdown-item js-rename-folder"
                                    data-url="{{ route('admin.laporan-lpj.folder.update', $folder->id) }}"
                                    data-name="{{ $folder->nama_program }}">
                                    <i class="fa-solid fa-pen me-2"></i>Ganti Nama
                                </button>
                            </li>
                            <li>
                                <button type="button" class="dropdown-item text-danger js-delete-folder"
                                    data-url="{{ route('admin.laporan-lpj.folder.destroy', $folder->id) }}"
                                    data-name="{{ $folder->nama_program }}">
                                    <i class="fa-solid fa-trash me-2 text-danger"></i>Hapus
                                </button>
                            </li>
                        </ul>
                    </span>
                </div>
            @endforeach
        </div>
    @endif
</div>

@endif

{{-- Modal tambah folder --}}
<div class="modal fade" id="createFolderModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="{{ route('admin.laporan-lpj.folder.store') }}" class="modal-content">
            @csrf
            @if ($parentFolder)
                <input type="hidden" name="parent_id" value="{{ $parentFolder->id }}">
            @endif
            <div class="modal-header">
                <h5 class="modal-title">Tambah Folder</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <label for="create_nama_folder" class="form-label">Nama Folder <span class="text-danger">*</span></label>
                <input type="text" id="create_nama_folder" name="nama_folder" class="form-control" maxlength="255"
                    placeholder="Contoh: Kegiatan Triwulan I" required>
                <div class="form-text">
                    Folder dibuat di: <strong>{{ $parentFolder?->nama_program ?? 'Bidang Bidang' }}</strong>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal ganti nama folder --}}
<div class="modal fade" id="renameFolderModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="" class="modal-content" id="renameFolderForm">
            @csrf
            @method('PUT')
            <div class="modal-header">
                <h5 class="modal-title">Ganti Nama Folder</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <label for="rename_nama_folder" class="form-label">Nama Folder <span class="text-danger">*</span></label>
                <input type="text" id="rename_nama_folder" name="nama_folder" class="form-control" maxlength="255"
                    required>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- Form hapus folder --}}
<form method="POST" action="" id="deleteFolderForm" class="d-none">
    @csrf
    @method('DELETE')
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.js-rename-folder').forEach(function(button) {
            button.addEventListener('click', function() {
                document.getElementById('renameFolderForm').action = this.dataset.url;
                document.getElementById('rename_nama_folder').value = this.dataset.name;
                bootstrap.Modal.getOrCreateInstance(document.getElementById('renameFolderModal')).show();
            });
        });

        document.querySelectorAll('.js-delete-folder').forEach(function(button) {
            button.addEventListener('click', function() {
                const form = document.getElementById('deleteFolderForm');
                const name = this.dataset.name;
                const url = this.dataset.url;
                const submit = function() {
                    form.action = url;
                    form.submit();
                };

                if (window.Swal) {
                    Swal.fire({
                        title: 'Hapus folder?',
                        text: 'Folder "' + name + '" akan dihapus. Hanya folder kosong yang bisa dihapus.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, hapus',
                        cancelButtonText: 'Batal',
                        confirmButtonColor: '#dc3545'
                    }).then(function(result) {
                        if (result.isConfirmed) {
                            submit();
                        }
                    });
                } else if (confirm('Hapus folder "' + name + '"?')) {
                    submit();
                }
            });
        });

        // Fokus otomatis ke input saat modal terbuka
        ['createFolderModal', 'renameFolderModal'].forEach(function(id) {
            const modal = document.getElementById(id);
            modal.addEventListener('shown.bs.modal', function() {
                modal.querySelector('input[name="nama_folder"]').focus();
            });
        });
    });
</script>
