<?php

namespace App\Http\Controllers\Admin\Arsip;

use SimpleSoftwareIO\QrCode\Facades\QrCode;

trait QrLabel
{
    /** QR code SVG sebagai data URI, bisa dipakai di <img> HTML maupun DomPDF. */
    protected function qrDataUri(string $text, int $size = 150): string
    {
        $svg = QrCode::format('svg')->size($size)->margin(0)->generate($text);

        return 'data:image/svg+xml;base64,' . base64_encode($svg);
    }
}
