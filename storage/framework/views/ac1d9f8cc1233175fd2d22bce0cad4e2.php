
<div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header" style="background: white; color: rgb(0, 0, 0);">
                <h5 class="modal-title text-black" id="previewModalLabel">Preview Files</h5>
                <button type="button" class="btn-close btn-close-black" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0" style="height: 70vh;">
                <div class="preview-container h-100 position-relative d-flex align-items-center justify-content-center" style="background: #f8f9fa;">
                    <div id="previewSlides" class="w-100 h-100"></div>
                    <button type="button" id="prevBtn" class="btn btn-primary position-absolute start-0 top-50 translate-middle-y ms-3" style="z-index: 10; display: none;">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button type="button" id="nextBtn" class="btn btn-primary position-absolute end-0 top-50 translate-middle-y me-3" style="z-index: 10; display: none;">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <div class="d-flex justify-content-between align-items-center w-100">
                    <div>
                        <strong id="currentFileName">File Name</strong>
                        <div class="text-muted small" id="fileCounter">1 of 1</div>
                    </div>
                    <div>
                        <button type="button" id="downloadBtn" class="btn btn-success btn-sm me-2">
                            <i class="fas fa-download"></i> Download
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center"
                style="background: white; color: #333; border-bottom: 1px solid #dee2e6 !important;">
                <h5 class="modal-title me-1" id="detailModalLabel" style="color: #333 !important;">Detail Kegiatan</h5>
                <span id="statusIcon" class="ms-2 fs-6 gap-3"></span>

                <div class="ms-auto d-flex align-items-center gap-2">
                    <button type="button" id="export-pdf-btn" class="btn">
                        <i class="fa-solid fa-file-export" style="color: white"></i>
                        Export Data
                    </button>
                    <button type="button" id="ajukanPerubahanBtn" class="btn">
                        <i class="bi bi-arrow-repeat" style="color: white"></i>
                        <strong>Ajukan Perubahan</strong>
                    </button>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
            </div>

            <div class="modal-body" id="detailModalBody">
                
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="pengajuanModal" tabindex="-1" aria-labelledby="pengajuanModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pengajuanModalLabel">Ajukan Perubahan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="pengajuanForm">
                    <input type="hidden" id="pengajuan_lpj_id" name="lpj_id">
                    <div class="mb-3">
                        <label for="alasan" class="form-label">Alasan Perubahan</label>
                        <textarea class="form-control" id="alasan" name="alasan" rows="4" required></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="submitPengajuanBtn">Kirim Pengajuan</button>
            </div>
        </div>
    </div>
</div>

<?php if($parentId): ?>

<div class="modal fade" id="editTargetModal" tabindex="-1" aria-labelledby="editTargetModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 gap-5 px-10 py-8">
            <div class="d-flex justify-content-between align-items-center">
                <div class="fs-2 fw-bold leading-5">Edit Target Anggaran & Kegiatan</div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="editTargetForm" class="d-grid gap-4">
                <input type="hidden" name="id_lpj" value="<?php echo e($parentId); ?>">

                <div>
                    <div class="fw-semibold required mb-3 text-gray-800">Target Anggaran</div>
                    <input type="text" name="target_anggaran" id="target_anggaran"
                           value="<?php echo e(formatRupiah($target->target_anggaran ?? 0)); ?>"
                           placeholder="Masukkan target anggaran"
                           class="form-control bg-light border border-gray-400" required />
                    <div class="invalid-feedback"></div>
                </div>

                <div>
                    <div class="fw-semibold required mb-3 text-gray-800">Target Kegiatan</div>
                    <input type="number" name="target_kegiatan" id="target_kegiatan"
                           value="<?php echo e($target->target_kegiatan ?? 0); ?>"
                           placeholder="Masukkan jumlah target kegiatan"
                           class="form-control bg-light border border-gray-400" required />
                    <div class="invalid-feedback"></div>
                </div>
            </form>

            <div class="d-grid py-4">
                <button type="button" id="saveTargetBtn"
                        class="bg-danger fw-bold d-flex align-items-center justify-content-center gap-2 rounded border-0 p-4 text-white">
                    <span class="btn-text">Simpan Target</span>
                </button>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<?php /**PATH /home/thur/Documents/Inotive/web-koni/resources/views/admin/laporan-lpj/bidang_new/dynamic/modals.blade.php ENDPATH**/ ?>