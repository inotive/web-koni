<form id="filter-gadai" class="d-flex justify-content-end gap-2">
                                <!-- Search -->
                                <div class="col-md-5">
                                    <div class="position-relative bg-light">
                                        <i
                                            class="ki-outline ki-magnifier fs-3 position-absolute top-50 translate-middle-y ms-3"></i>
                                        <input type="text" name="searchGadai" value=""
                                            data-kt-docs-table-filter="search" placeholder="Cari Transaksi"
                                            class="form-control border border-gray-500 px-10 py-2" />
                                    </div>
                                </div>
                                <button type="button" data-bs-toggle="modal" data-bs-target="#filterGadai"
                                    class="btn btn-sm btn-light d-flex align-items-center border border-gray-500 p-0 text-gray-600">
                                    <span class="fs-8 d-none d-md-inline text-nowrap px-3">Filter Berdasarkan</span>
                                    <i class="las la-filter fs-2 border-start border-gray-500 px-3 py-2 text-gray-500"></i>
                                </button>
                                <div class="modal fade" id="filterGadai" tabindex="-1" aria-labelledby="filterGadaiLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Filter Data Gadai</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>

                                            <div class="modal-body d-grid gap-10">
                                                <!-- Filter Bulan -->
                                                <div class="d-flex justify-content-between">
                                                    <div class="col-6 pe-4">
                                                        <label for="bulan" class="form-label">Bulan Masuk
                                                            Barang</label>
                                                        <select class="form-select bg-light" id="bulan"
                                                            name="bulan">
                                                            <option value="">Semua Bulan</option>
                                                            {{-- @foreach (range(1, 12) as $m)
                                                                <option value="{{ $m }}"
                                                                    {{ request('bulan') == $m ? 'selected' : '' }}>
                                                                    {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                                                                </option>
                                                            @endforeach --}}
                                                        </select>
                                                    </div>
                                                    <!-- Filter Tahun -->
                                                    <div class="col-6 ps-4">
                                                        <label for="tahun" class="form-label">Tahun Masuk
                                                            Barang</label>
                                                        <select class="form-select bg-light" id="tahun"
                                                            name="tahun">
                                                            <option value="">Semua Tahun</option>
                                                            {{-- @foreach (range(date('Y'), 2020) as $y)
                                                                <option value="{{ $y }}"
                                                                    {{ request('tahun') == $y ? 'selected' : '' }}>
                                                                    {{ $y }}
                                                                </option>
                                                            @endforeach --}}
                                                        </select>
                                                    </div>
                                                </div>
                                                <div>
                                                    <label for="group" class="form-label">Kelompokkan
                                                        Berdasarkan</label>
                                                    <select name="group" id="group" value=""
                                                        class="form-select bg-light">
                                                        <option value="">Pilih Group</option>
                                                        <option value="status">Status</option>
                                                        <option value="nasabah">Nasabah</option>
                                                        <option value="barang">Barang</option>
                                                        <option value="tipe_gadai">Tipe Gadai</option>
                                                        <option value="tanggal_masuk">Tanggal Masuk</option>
                                                        <option value="bulan_masuk">Bulan Masuk</option>
                                                        <option value="tahun_masuk">Tahun Masuk</option>
                                                        <option value="tanggal_jatuh_tempo">Tanggal Jatuh Tempo</option>
                                                        <option value="bulan_jatuh_tempo">Bulan Jatuh Tempo</option>
                                                        <option value="tahun_jatuh_tempo">Tahun Jatuh Tempo</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <!-- Button akan menutup modal dan form bisa disubmit -->
                                                <button type="submit" class="btn btn-primary"
                                                    data-bs-dismiss="modal">Terapkan Filter</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>