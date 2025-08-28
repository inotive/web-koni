<div style="overflow-x:auto;">
    <table class="table-row-bordered gy-4 table align-middle">
        <thead>
            <tr class="fw-bold text-uppercase text-muted">
                <th class="bg-light text-nowrap text-center">No.</th>
                <th class="bg-light text-nowrap px-20">Nama File</th>
                <th class="bg-light text-nowrap">Total Anggaran</th>
                <th class="bg-light text-nowrap text-center">Ukuran File</th>
                <th class="bg-light text-nowrap text-center">Terakhir diperbarui</th>
                <th class="bg-light text-nowrap px-8 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="border-bottom">
            @php
                $number = ($laporan->currentPage() - 1) * $laporan->perPage() + 1;
            @endphp
            @forelse ($laporan as $item)
                <tr>
                    <td class="text-center">{{ $number++ }}.</td>
                    <td class="fw-bold px-6"
                        style="max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                        <a href="{{ Storage::url($item->file_path) }}" target="_blank" title="{{ $item->name }}">
                            {{ $item->name }}
                        </a>
                    </td>
                    <td class="text-nowrap">
                        Rp. {{ number_format($item->total_anggaran, 0, ',', '.') }}
                    </td>
                    <td class="px-2 text-center">
                        {{ number_format($item->file_size / 1048576, 2) }} MB
                    </td>
                    <td class="px-2 text-center">
                        {{ $item->updated_at->locale('id')->translatedFormat('d M Y') }}
                    </td>
                    <td class="px-2 text-center">
                        <div class="dropdown">
                            <button class="btn btn-sm p-0" type="button" data-bs-toggle="dropdown">
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
                            <ul class="dropdown-menu cursor-pointer">
                                <li class="dropdown-item edit" data-bs-toggle="modal"
                                    data-bs-target="#edit-{{ $item->id }}">
                                    Edit Laporan
                                </li>
                                <li class="dropdown-item delete"
                                    onclick="event.preventDefault(); event.stopPropagation(); confirmDelete('{{ route('admin.laporan-rka.destroy', $item->id) }}', '{{ $item->name }}')">
                                    Hapus
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
                <div class="modal fade" id="edit-{{ $item->id }}" tabindex="-1"
                    aria-labelledby="edit-{{ $item->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content rounded-4 gap-5 px-10 py-8">
                            <div class="d-flex justify-content-between align-items-center gap-2">
                                <div class="fs-2 fw-bold text-truncate leading-5">Edit Laporan {{ $item->name }}
                                </div>

                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>

                            <form id="form-{{ $item->id }}" method="POST"
                                action="{{ route('admin.laporan-rka.update', $item->id) }}"
                                enctype="multipart/form-data" class="d-grid gap-4">
                                @csrf
                                @method('PUT')

                                <div>
                                    <div class="fw-semibold required mb-3 text-gray-800">Total Anggaran</div>
                                    <div class="input-group">
                                        <span class="input-group-text border border-gray-400 pe-0">Rp.</span>
                                        <input type="text" name="total_anggaran"
                                            placeholder="Masukkan total anggaran"
                                            value="{{ number_format($item->total_anggaran, 0, ',', '.') }}"
                                            class="rupiah border-start-0 form-control bg-light border border-gray-400" />
                                    </div>
                                </div>
                                <div>
                                    <div class="fw-semibold required mb-3 text-gray-800">Unggah Laporan Baru</div>
                                    <div class="fv-row">
                                        <!--begin::Dropzone-->
                                        <div class="dropzone" id="dropzone-form-{{ $item->id }}">
                                            <!--begin::Message-->
                                            <div class="dz-message needsclick">
                                                <i class="ki-duotone ki-file-up fs-3x text-primary">
                                                    <span class="path1"></span><span class="path2"></span>
                                                </i>
                                                <!--begin::Info-->
                                                <div class="ms-4">
                                                    <h3 class="fs-5 fw-bold mb-1 text-gray-900">Seret atau pilih
                                                        laporan.</h3>
                                                    <span class="fs-7 fw-semibold text-gray-500">Max. Ukuran File 10
                                                        MB.</span>
                                                </div>
                                                <!--end::Info-->
                                            </div>
                                        </div>
                                        <!--end::Dropzone-->
                                    </div>
                                </div>

                                <div class="bg-light mt-2 rounded p-3">
                                    <small class="text-muted">File saat ini: </small>
                                    <a href="{{ Storage::url($item->file_path) }}" target="_blank">
                                        {{ $item->name }}
                                    </a>
                                </div>

                                <div class="d-grid py-4">
                                    <button type="submit" onclick="submitForm('form-{{ $item->id }}')"
                                        class="bg-danger fw-bold d-flex align-items-center justify-content-center gap-2 rounded border-0 p-4 text-white">
                                        Edit Laporan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <tr>
                    <td class="fw-bold p-6 text-center" colspan="6">
                        Tidak ada laporan ditemukan.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
<!--end::Table-->
<div class="border-0 px-10 py-5">
    <div class="d-flex justify-content-between col-12">
        <div class="d-flex align-items-center gap-2 text-gray-500">
            Show
            <select id="per_page" name="per_page" class="form-select w-75 border border-gray-200 p-2">
                <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10
                </option>
                <option value="25" {{ request('per_page', 10) == 25 ? 'selected' : '' }}>25
                </option>
                <option value="50" {{ request('per_page', 10) == 50 ? 'selected' : '' }}>50
                </option>
                <option value="100" {{ request('per_page', 10) == 100 ? 'selected' : '' }}>100
                </option>
            </select>
            per page
        </div>
        <!-- Paginate -->
        {{ $laporan->links('pagination::bootstrap-5') }}
    </div>
</div>
