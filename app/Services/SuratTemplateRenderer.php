<?php

namespace App\Services;

use App\Models\Surat;
use App\Models\SuratKop;
use App\Models\SuratTemplate;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SuratTemplateRenderer
{
    /** Ukuran kertas dalam point; F4 = 215 x 330 mm. */
    private const PAPER = [
        'a4' => 'a4',
        'f4' => [0, 0, 609.45, 935.43],
    ];

    /**
     * Mengganti placeholder {{key}} di isi template dengan nilai yang sudah di-escape.
     *
     * @param  array  $data  nilai field dinamis (key => value)
     * @param  array  $meta  nomor_surat, tanggal_surat (Carbon), perihal
     * @param  bool  $sample  tampilkan [Label] untuk nilai kosong (dipakai saat preview template)
     */
    public function renderIsi(SuratTemplate $template, array $data, array $meta, bool $sample = false): string
    {
        $values = $this->values($template, $data, $meta, $sample);

        return preg_replace_callback('/\{\{\s*([a-z0-9_]+)\s*\}\}/i', function ($m) use ($values) {
            return array_key_exists($m[1], $values) ? $values[$m[1]] : $m[0];
        }, $template->isi);
    }

    public function pdf(SuratTemplate $template, array $data, array $meta, bool $sample = false)
    {
        return Pdf::loadView('admin.surat-template.pdf', [
            'template' => $template,
            'isi' => $this->normalizeTables($this->renderIsi($template, $data, $meta, $sample)),
            'meta' => $meta,
            'kop' => $this->kopView($template),
            'ttd' => $this->imageDataUri($template->ttd),
            'tanggalSurat' => $this->formatTanggal($meta['tanggal_surat'] ?? now()),
        ])->setPaper(self::PAPER[$template->ukuran_kertas] ?? 'a4');
    }

    /**
     * Menyesuaikan tabel dari editor agar terbaca dompdf:
     * - lebar kolom di <colgroup><col> (diabaikan dompdf) dipindah ke setiap sel;
     * - tabel yang disembunyikan garisnya lewat border-style hidden/none atau border="0"
     *   diberi class tabel-polos supaya garis sel juga hilang.
     */
    public function normalizeTables(string $html): string
    {
        if (stripos($html, '<table') === false) {
            return $html;
        }

        $doc = new \DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML('<?xml encoding="UTF-8"><div id="isi-root">' . $html . '</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();

        foreach (iterator_to_array($doc->getElementsByTagName('table')) as $table) {
            $style = strtolower($table->getAttribute('style'));
            if (preg_match('/border-style:\s*(hidden|none)/', $style) || $table->getAttribute('border') === '0') {
                $table->setAttribute('class', trim($table->getAttribute('class') . ' tabel-polos'));
            }

            $colgroup = null;
            foreach ($table->childNodes as $child) {
                if ($child instanceof \DOMElement && strtolower($child->tagName) === 'colgroup') {
                    $colgroup = $child;
                    break;
                }
            }
            if (!$colgroup) {
                continue;
            }

            $widths = [];
            foreach ($colgroup->getElementsByTagName('col') as $col) {
                $widths[] = preg_match('/width:\s*([\d.]+(?:%|px|pt|mm|cm))/i', $col->getAttribute('style'), $m) ? $m[1] : null;
            }
            $colgroup->parentNode->removeChild($colgroup);

            foreach ($table->getElementsByTagName('tr') as $tr) {
                // Lewati baris milik tabel bersarang
                $owner = $tr->parentNode;
                while ($owner && !($owner instanceof \DOMElement && strtolower($owner->tagName) === 'table')) {
                    $owner = $owner->parentNode;
                }
                if ($owner !== $table) {
                    continue;
                }

                $index = 0;
                foreach ($tr->childNodes as $cell) {
                    if (!$cell instanceof \DOMElement || !in_array(strtolower($cell->tagName), ['td', 'th'], true)) {
                        continue;
                    }
                    $span = max(1, (int) $cell->getAttribute('colspan'));
                    $width = $this->sumWidths(array_slice($widths, $index, $span));
                    $index += $span;

                    if ($width !== null) {
                        $cellStyle = preg_replace('/(^|;)\s*width:[^;]*/i', '$1', $cell->getAttribute('style'));
                        $cell->setAttribute('style', trim("width: {$width}; " . trim($cellStyle, '; ')));
                    }
                }
            }
        }

        $root = $doc->getElementById('isi-root');
        $result = '';
        foreach ($root->childNodes as $node) {
            $result .= $doc->saveHTML($node);
        }

        return $result;
    }

    /** Jumlahkan lebar kolom yang digabung (colspan); hanya bila satuannya sama. */
    private function sumWidths(array $widths): ?string
    {
        if (!$widths || in_array(null, $widths, true)) {
            return null;
        }
        $unit = preg_replace('/[\d.]/', '', $widths[0]);
        foreach ($widths as $w) {
            if (preg_replace('/[\d.]/', '', $w) !== $unit) {
                return null;
            }
        }

        return round(array_sum(array_map('floatval', $widths)), 4) . $unit;
    }

    /** Render ulang PDF surat dari template, simpan ke disk public, kembalikan path-nya. */
    public function storeForSurat(Surat $surat, SuratTemplate $template): string
    {
        $pdf = $this->pdf($template, $surat->data_template ?? [], [
            'nomor_surat' => $surat->no_surat,
            'tanggal_surat' => $surat->tanggal_surat ?? now(),
            'perihal' => $surat->nama_kegiatan,
        ]);

        $path = 'surat/' . Str::slug($surat->no_surat) . '-' . $surat->id . '.pdf';
        if ($surat->dokumen_surat && $surat->dokumen_surat !== $path) {
            Storage::disk('public')->delete($surat->dokumen_surat);
        }
        Storage::disk('public')->put($path, $pdf->output());

        return $path;
    }

    /** Data contoh untuk preview template. */
    public function sampleMeta(SuratTemplate $template): array
    {
        $penomoran = $template->penomoranEfektif();

        return [
            'nomor_surat' => $penomoran
                ? app(NomorSuratGenerator::class)->format($penomoran, 1, now(), ['kode' => $template->kode, 'klasifikasi' => $template->kode_klasifikasi])
                : '001/' . $template->kode . '/' . now()->year,
            'tanggal_surat' => now(),
            'perihal' => 'Contoh Perihal Surat',
        ];
    }

    public function formatTanggal($tanggal): string
    {
        return Carbon::parse($tanggal)->locale('id')->translatedFormat('j F Y');
    }

    private function values(SuratTemplate $template, array $data, array $meta, bool $sample): array
    {
        $values = [
            'nomor_surat' => e($meta['nomor_surat'] ?? ''),
            'tanggal_surat' => e($this->formatTanggal($meta['tanggal_surat'] ?? now())),
            'perihal' => e($meta['perihal'] ?? ''),
            'kota_surat' => e($template->kota_surat ?? ''),
            'penandatangan_nama' => e($template->penandatangan_nama ?? ''),
            'penandatangan_jabatan' => e($template->penandatangan_jabatan ?? ''),
            'penandatangan_nip' => e($template->penandatangan_nip ?? ''),
        ];

        foreach ($template->field_list as $field) {
            $value = $data[$field['key']] ?? null;

            if (blank($value)) {
                $values[$field['key']] = $sample ? '<span style="background:#fff3cd">[' . e($field['label']) . ']</span>' : '';
                continue;
            }

            $values[$field['key']] = match ($field['type'] ?? 'text') {
                'date' => e($this->formatTanggal($value)),
                'textarea' => nl2br(e($value)),
                default => e($value),
            };
        }

        return $values;
    }

    /** Data kop siap render untuk partial admin.surat-kop._kop; null bila tanpa kop. */
    public function kopView(SuratTemplate $template): ?array
    {
        if (!$template->tampilkan_kop) {
            return null;
        }
        if ($template->kop_surat) {
            return ['jenis' => 'gambar', 'src' => $this->imageDataUri($template->kop_surat)];
        }

        $kop = $template->kopEfektif();

        return $kop ? $this->kopToView($kop) : null;
    }

    public function kopToView(SuratKop $kop): array
    {
        if ($kop->jenis === 'gambar') {
            return ['jenis' => 'gambar', 'src' => $this->imageDataUri($kop->gambar)];
        }

        return [
            'jenis' => 'susun',
            'logo_kiri' => $this->imageDataUri($kop->logo_kiri),
            'logo_kanan' => $this->imageDataUri($kop->logo_kanan),
            'baris' => $kop->baris_list,
            'garis' => $kop->garis,
        ];
    }

    /** PDF berisi kop saja dengan teks contoh, untuk preview di halaman Kop Surat. */
    public function kopPdf(SuratKop $kop)
    {
        $template = new SuratTemplate([
            'isi' => '<p>Contoh isi surat. Kop di atas akan dipakai oleh template yang memilihnya.</p>',
            'tampilkan_ttd' => false,
            'tampilkan_kop' => true,
            'ukuran_kertas' => 'a4',
        ]);

        return Pdf::loadView('admin.surat-template.pdf', [
            'template' => $template,
            'isi' => $template->isi,
            'meta' => ['nomor_surat' => 'Preview ' . $kop->nama],
            'kop' => $this->kopToView($kop),
            'ttd' => null,
            'tanggalSurat' => $this->formatTanggal(now()),
        ])->setPaper('a4');
    }

    /** Gambar disematkan sebagai data URI agar dompdf tidak bergantung pada symlink storage. */
    private function imageDataUri(?string $path): ?string
    {
        if (!$path || !Storage::disk('public')->exists($path)) {
            return null;
        }

        $mime = Storage::disk('public')->mimeType($path) ?: 'image/png';

        return 'data:' . $mime . ';base64,' . base64_encode(Storage::disk('public')->get($path));
    }
}
