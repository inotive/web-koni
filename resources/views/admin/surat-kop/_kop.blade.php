{{-- Kop surat untuk PDF (dompdf). $kop berasal dari SuratTemplateRenderer::kopView() / kopToView(). --}}
@if ($kop['jenis'] === 'gambar')
    @if ($kop['src'])
        <div style="width: 100%; margin-bottom: 6mm;"><img src="{{ $kop['src'] }}" style="width: 100%;"></div>
    @endif
@else
    @php
        $hasLogo = $kop['logo_kiri'] || $kop['logo_kanan'];
        $border = ['tunggal' => '2px solid #000', 'ganda' => '4px double #000'][$kop['garis']] ?? null;
    @endphp
    <table style="width: 100%; border-collapse: collapse; margin-bottom: 6mm; {{ $border ? 'border-bottom: ' . $border . ';' : '' }}">
        <tr>
            @if ($hasLogo)
                <td style="width: 22mm; text-align: left; vertical-align: middle; padding-bottom: 2mm;">
                    @if ($kop['logo_kiri'])
                        <img src="{{ $kop['logo_kiri'] }}" style="width: 22mm;">
                    @endif
                </td>
            @endif
            <td style="text-align: center; vertical-align: middle; padding-bottom: 2mm; line-height: 1.2;">
                @foreach ($kop['baris'] as $baris)
                    <div style="font-size: {{ (float) ($baris['ukuran'] ?? 11) }}pt; {{ !empty($baris['tebal']) ? 'font-weight: bold;' : '' }}">
                        {{ $baris['teks'] ?? '' }}
                    </div>
                @endforeach
            </td>
            @if ($hasLogo)
                <td style="width: 22mm; text-align: right; vertical-align: middle; padding-bottom: 2mm;">
                    @if ($kop['logo_kanan'])
                        <img src="{{ $kop['logo_kanan'] }}" style="width: 22mm;">
                    @endif
                </td>
            @endif
        </tr>
    </table>
@endif
