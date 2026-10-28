{{-- Kop default dari menu Kop Surat untuk export PDF (dompdf) di luar modul surat. --}}
@php $kop = app(\App\Services\SuratTemplateRenderer::class)->defaultKopView(); @endphp
@if ($kop)
    @include('admin.surat-kop._kop', ['kop' => $kop])
@endif
