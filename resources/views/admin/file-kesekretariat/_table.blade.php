<div class="table-responsive">
    <table class="table table-bordered table-hover align-middle">
        <thead class="bg-light">
            <tr>
                <th>No</th>
                <th>
                    <a href="#" class="sort-link" data-sort="nama_dokumen">
                        Nama Dokumen
                        <i class="fas fa-sort{{ request('sort_by')=='nama_dokumen' ? (request('order')=='asc' ? '-up' : '-down') : '' }}"></i>
                    </a>
                </th>
                <th>
                    <a href="#" class="sort-link" data-sort="created_at">
                        File Dokumen
                        <i class="fas fa-sort{{ request('sort_by')=='created_at' ? (request('order')=='asc' ? '-up' : '-down') : '' }}"></i>
                    </a>
                </th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($files as $index => $file)
                <tr>
                    <td class="text-center">{{ $loop->iteration + ($files->currentPage()-1)*$files->perPage() }}</td>
                    <td>{{ $file->nama_dokumen }}</td>
                    <td>{{ $file->dokumen_file }}</td>
                    <td class="text-center">
                        <a href="{{ route('admin.file-kesekretariat.show', $file) }}" class="btn btn-sm btn-icon btn-light-primary" title="Detail"><i class="fas fa-eye"></i></a>
                        <a href="{{ route('admin.file-kesekretariat.edit', $file) }}" class="btn btn-sm btn-icon btn-light-warning" title="Edit"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('admin.file-kesekretariat.destroy', $file) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Hapus file ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-icon btn-light-danger" title="Hapus"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- Laravel Pagination --}}
<div class="pagination-wrapper d-flex justify-content-between align-items-center mt-3">
    <div>{{ $files->onEachSide(1)->links('pagination::bootstrap-5') }}</div>
    <small class="text-muted">
        Menampilkan {{ $files->firstItem() }} - {{ $files->lastItem() }} dari {{ $files->total() }} file
    </small>
</div>