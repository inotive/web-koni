<div class="tab-content" id="prestasi-tab-content">
    <!-- Prestasi Atlet -->
    <div class="tab-pane fade show active" id="atlet-prestasi" role="tabpanel">
        @include('admin.dashboard.partials._prestasi-atlet-table', ['prestasi_list' => $latest_prestasi, 'type' => 'atlet'])
    </div>

    <!-- Prestasi Pelatih -->
    <div class="tab-pane fade" id="pelatih-prestasi" role="tabpanel">
        @include('admin.dashboard.partials._prestasi-pelatih-table', ['prestasi_list' => $latest_prestasi_pelatih ?? collect(), 'type' => 'pelatih'])
    </div>
</div>
