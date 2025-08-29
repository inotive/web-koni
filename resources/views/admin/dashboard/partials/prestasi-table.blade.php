<div class="tab-content" id="prestasi-tab-content">
    <!-- Prestasi Atlet -->
    <div class="tab-pane fade show active" id="atlet-prestasi" role="tabpanel">
        @include('admin.dashboard.partials._prestasi-atlet-table', ['prestasi_list' => $latest_prestasi, 'type' => 'atlet'])
    </div>

    <!-- Prestasi Pelatih -->
    <div class="tab-pane fade" id="pelatih-prestasi" role="tabpanel">
        {{-- Konten akan dimuat via AJAX --}}
        <div class="text-center py-10">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>
</div>
