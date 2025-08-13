<div style="display: none;" data-filter-counts="{{ json_encode($fileCounts ?? []) }}"></div>

<div style="overflow-x:auto;">
    <table class="table-row-bordered gy-4 table align-middle">
        <thead>
            <tr class="fw-bold text-uppercase text-muted">
                <th class="bg-light px-6 text-center" style="width: 60px;">No</th>
                <th class="bg-light px-20">Judul Laporan</th>
                <th class="bg-light text-center">Ukuran File</th>
                <th class="bg-light text-center">Tipe File</th>
                <th class="bg-light px-8 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="border-bottom">
            @forelse ($laporanBendahara as $index => $item)
                @php
                    $extension = $item->dokumen ? strtolower(pathinfo($item->dokumen, PATHINFO_EXTENSION)) : '';
                    // Calculate proper row number based on pagination
                    $rowNumber = ($laporanBendahara->currentPage() - 1) * $laporanBendahara->perPage() + $index + 1;
                @endphp
                <tr data-extension="{{ $extension }}" data-dokumen="{{ $item->dokumen }}">
                    <td class="text-center fw-bold px-2">
                        {{ $rowNumber }}
                    </td>
                    <td class="fw-bold px-6">
                        @if($item->dokumen)
                            <a href="#" onclick="previewFile('{{ Storage::url($item->dokumen) }}', '{{ $item->judul }}', '{{ $extension }}')" class="text-decoration-none cursor-pointer">
                                @if(request('search'))
                                    {!! preg_replace('/(' . preg_quote(request('search'), '/') . ')/i', '<span class="search-highlight">$1</span>', $item->judul) !!}
                                @else
                                    {{ $item->judul }}
                                @endif
                            </a>
                        @else
                            @if(request('search'))
                                {!! preg_replace('/(' . preg_quote(request('search'), '/') . ')/i', '<span class="search-highlight">$1</span>', $item->judul) !!}
                            @else
                                {{ $item->judul }}
                            @endif
                        @endif
                        <br>
                        <small class="text-muted">{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</small>
                    </td>
                    <td class="px-2 text-center">
                        @if($item->dokumen && Storage::disk('public')->exists($item->dokumen))
                            {{ number_format(Storage::disk('public')->size($item->dokumen) / 1048576, 2) }} MB
                        @else
                            -
                        @endif
                    </td>
                    <td class="px-2 text-center">
                        @if($item->dokumen)
                            @php
                                $extension = strtoupper(pathinfo($item->dokumen, PATHINFO_EXTENSION));
                                $badgeClass = match($extension) {
                                    'PDF' => 'badge-danger',
                                    'DOC', 'DOCX' => 'badge-primary',
                                    'XLS', 'XLSX' => 'badge-success',
                                    'JPG', 'JPEG', 'PNG', 'GIF', 'BMP', 'SVG' => 'badge-warning',
                                    default => 'badge-secondary'
                                };
                            @endphp
                            <span class="badge {{ $badgeClass }}">{{ $extension }}</span>
                        @else
                            -
                        @endif
                    </td>
                    <td class="px-2 text-center position-relative dropdown-wrapper">
                        <div class="dropdown">
                            <button class="btn btn-sm p-0" type="button"
                                        data-bs-toggle="dropdown"
                                        data-bs-boundary="body"
                                        aria-expanded="false">
                                <svg width="32" height="32" viewBox="0 0 32 32" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect width="32" height="32" rx="6" fill="#EFF6FF" />
                                    <rect x="0.5" y="0.5" width="31" height="31" rx="5.5" stroke="#1B84FF"
                                        stroke-opacity="0.2" />
                                    <g clip-path="url(#clip0_2223_4269)">
                                        <path opacity="0.3"
                                            d="M19.4266 7.9375H12.5734C10.0131 7.9375 7.9375 10.0131 7.9375 12.5734V19.4266C7.9375 21.9869 10.0131 24.0625 12.5734 24.0625H19.4266C21.9869 24.0625 24.0625 21.9869 24.0625 19.4266V12.5734C24.0625 10.0131 21.9869 7.9375 19.4266 7.9375Z"
                                            fill="#1B84FF" />
                                        <path
                                            d="M12.251 14.8232C12.8475 14.8233 13.331 15.3067 13.3311 15.9033C13.3311 16.4999 12.8476 16.9833 12.251 16.9834C11.6543 16.9834 11.1709 16.5 11.1709 15.9033C11.1709 15.3067 11.6543 14.8232 12.251 14.8232ZM16.2979 14.8232C16.8945 14.8232 17.3789 15.3066 17.3789 15.9033C17.3789 16.5 16.8945 16.9834 16.2979 16.9834C15.7013 16.9832 15.2178 16.4999 15.2178 15.9033C15.2178 15.3067 15.7013 14.8234 16.2979 14.8232ZM20.3369 14.8232C20.9336 14.8232 21.418 15.3066 21.418 15.9033C21.418 16.5 20.9336 16.9834 20.3369 16.9834C19.7404 16.9832 19.2568 16.4999 19.2568 15.9033C19.2568 15.3068 19.7404 14.8234 20.3369 14.8232Z"
                                            fill="#1B84FF" />
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_2223_4269">
                                            <rect width="18" height="18" fill="white"
                                                transform="translate(7 7)" />
                                        </clipPath>
                                    </defs>
                                </svg>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                @if($item->dokumen)
                                <li class="dropdown-item preview" onclick="previewFile('{{ Storage::url($item->dokumen) }}', '{{ $item->judul }}', '{{ strtolower(pathinfo($item->dokumen, PATHINFO_EXTENSION)) }}')">
                                    <i class="ki-outline ki-eye me-2"></i>Preview Dokumen
                                </li>
                                {{-- <li class="dropdown-item" onclick="window.open('{{ Storage::url($item->dokumen) }}', '_blank')">
                                    <i class="ki-outline ki-down me-2"></i>Download
                                </li> --}}
                                @endif
                                <li class="dropdown-item edit" data-bs-toggle="modal"
                                    data-bs-target="#edit-{{ $item->id }}">
                                    <i class="ki-outline ki-pencil me-2"></i>Edit Laporan
                                </li>
                                <li class="dropdown-item delete"
                                    onclick="deleteItem('delete-form-{{ $item->id }}')">
                                    <i class="ki-outline ki-trash me-2"></i>Hapus
                                </li>

                                <form id="delete-form-{{ $item->id }}"
                                    action="{{ route('admin.bendahara.destroy', $item->id) }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </ul>
                        </div>
                    </td>
                </tr>

                <!-- Edit Modal -->
                <div class="modal fade" id="edit-{{ $item->id }}" tabindex="-1"
                    aria-labelledby="edit-{{ $item->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content rounded-4 gap-5 px-10 py-8">
                            <div class="d-flex justify-content-between align-items-center gap-2">
                                <div class="fs-2 fw-bold text-truncate leading-5">Edit Laporan: {{ Str::limit($item->judul, 20) }}</div>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>

                            <form id="form-{{ $item->id }}" method="POST"
                                action="{{ route('admin.bendahara.update', $item->id) }}"
                                enctype="multipart/form-data" class="d-grid gap-4">
                                @csrf
                                @method('PUT')

                                <div>
                                    <div class="fw-semibold required mb-3 text-gray-800">Judul Laporan</div>
                                    <input type="text" name="judul" value="{{ $item->judul }}"
                                        placeholder="Masukkan Judul Laporan"
                                        class="form-control bg-light border border-gray-400" required />
                                </div>

                                <div>
                                    <div class="fw-semibold mb-3 text-gray-800">
                                        Unggah Dokumen Baru
                                        <span class="text-muted">(Opsional)</span>
                                    </div>
                                    <div class="fv-row">
                                        <div class="dropzone" id="dropzone-form-{{ $item->id }}">
                                            <div class="dz-message needsclick">
                                                <i class="ki-duotone ki-file-up fs-3x text-primary">
                                                    <span class="path1"></span><span class="path2"></span>
                                                </i>
                                                <div class="ms-4">
                                                    <h3 class="fs-5 fw-bold mb-1 text-gray-900">Seret atau pilih dokumen baru.</h3>
                                                    <span class="fs-7 fw-semibold text-gray-500">Format: PDF, DOC, DOCX, XLS, XLSX. Max. 10 MB. Kosongkan jika tidak ingin mengubah file.</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    @if($item->dokumen)
                                    <div class="mt-2 p-3 bg-light rounded">
                                        <small class="text-muted">File saat ini: </small>
                                        <a href="#" onclick="previewFile('{{ Storage::url($item->dokumen) }}', '{{ $item->judul }}', '{{ strtolower(pathinfo($item->dokumen, PATHINFO_EXTENSION)) }}')" class="text-primary text-decoration-none fw-bold">
                                            {{ basename($item->dokumen) }}
                                        </a>
                                    </div>
                                    @endif
                                </div>
                            </form>

                            <div class="d-grid py-4">
                                <button type="button" onclick="submitForm('form-{{ $item->id }}')"
                                    class="bg-danger fw-bold d-flex align-items-center justify-content-center gap-2 rounded border-0 p-4 text-white">
                                    Update Laporan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <tr>
                    <td class="fw-bold p-6 text-center" colspan="5">
                        <div class="d-flex flex-column align-items-center gap-3">
                            <svg width="64" height="64" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="32" cy="32" r="32" fill="#F8F9FA"/>
                                <path d="M32 20C25.3726 20 20 25.3726 20 32C20 38.6274 25.3726 44 32 44C38.6274 44 44 38.6274 44 32C44 25.3726 38.6274 20 32 20ZM32 22C37.5467 22 42 26.4533 42 32C42 37.5467 37.5467 42 32 42C26.4533 42 22 37.5467 22 32C22 26.4533 26.4533 22 32 22Z" fill="#6C7B7F"/>
                                <path d="M30 28V36H34V28H30ZM30 24V27H34V24H30Z" fill="#6C7B7F"/>
                            </svg>
                            <div class="text-center">
                                <div class="fw-bold text-gray-800 mb-1">
                                    @if(request('search') || request('filter_type'))
                                        Tidak ada laporan yang sesuai dengan pencarian/filter
                                    @else
                                        Belum ada laporan bendahara
                                    @endif
                                </div>
                                <div class="text-muted">
                                    @if(request('search') || request('filter_type'))
                                        Coba ubah kata kunci pencarian atau filter yang Anda gunakan
                                    @else
                                        Klik tombol "Tambah Laporan" untuk menambah laporan baru
                                    @endif
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination and Per Page Controls -->
@if(method_exists($laporanBendahara, 'hasPages'))
<div class="border-0 px-10 py-5">
    <div class="d-flex justify-content-between align-items-center col-12">
        <div class="d-flex align-items-center gap-2 text-gray-500">
            <span>Show</span>
            <select id="per_page" name="per_page" class="form-select border border-gray-200 p-2" style="width: 80px;">
                <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                <option value="25" {{ request('per_page', 10) == 25 ? 'selected' : '' }}>25</option>
                <option value="50" {{ request('per_page', 10) == 50 ? 'selected' : '' }}>50</option>
                <option value="100" {{ request('per_page', 10) == 100 ? 'selected' : '' }}>100</option>
            </select>
            <span>per page</span>
        </div>

        <!-- Pagination Links -->
        @if($laporanBendahara->hasPages())
            <nav aria-label="Table pagination">
                {{ $laporanBendahara->appends(request()->query())->links('pagination::bootstrap-5') }}
            </nav>
        @else
            <div class="text-muted">
                Showing {{ $laporanBendahara->firstItem() ?? 0 }} to {{ $laporanBendahara->lastItem() ?? 0 }} of {{ $laporanBendahara->total() }} entries
            </div>
        @endif
    </div>
</div>
@endif
