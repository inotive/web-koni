<?php

namespace App\Services;

use App\Models\Surat;
use App\Models\SuratPenomoran;
use App\Models\SuratPenomoranCounter;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Membuat nomor surat / nomor agenda berdasarkan format penomoran.
 *
 * preview() hanya menghitung nomor berikutnya tanpa menyimpan apa pun,
 * generate() mengambil nomor secara permanen (counter dikunci selama transaksi)
 * sehingga dua pengguna yang menyimpan bersamaan tidak mendapat nomor yang sama.
 */
class NomorSuratGenerator
{
    private const ROMAWI = [1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];

    /** Batas percobaan melewati nomor yang sudah terpakai (misalnya diisi manual). */
    private const MAX_SKIP = 50;

    public function preview(SuratPenomoran $penomoran, ?Carbon $tanggal = null, array $context = []): string
    {
        $tanggal ??= now();
        $last = SuratPenomoranCounter::where($this->counterKey($penomoran, $tanggal, $context))->value('last_number') ?? 0;

        return $this->nextAvailable($penomoran, $last, $tanggal, $context)[1];
    }

    public function generate(SuratPenomoran $penomoran, ?Carbon $tanggal = null, array $context = []): string
    {
        $tanggal ??= now();
        $key = $this->counterKey($penomoran, $tanggal, $context);

        return DB::transaction(function () use ($penomoran, $tanggal, $context, $key) {
            // insertOrIgnore mencegah error unique saat counter periode baru dibuat bersamaan
            SuratPenomoranCounter::insertOrIgnore($key + ['last_number' => 0, 'created_at' => now(), 'updated_at' => now()]);
            $counter = SuratPenomoranCounter::where($key)->lockForUpdate()->first();

            [$number, $nomor] = $this->nextAvailable($penomoran, $counter->last_number, $tanggal, $context);
            $counter->update(['last_number' => $number]);

            return $nomor;
        });
    }

    /** Menyusun nomor dari format untuk nomor urut tertentu. */
    public function format(SuratPenomoran $penomoran, int $number, ?Carbon $tanggal = null, array $context = []): string
    {
        $tanggal ??= now();

        return strtr($penomoran->format, [
            '{no}' => str_pad($number, max(1, $penomoran->digit), '0', STR_PAD_LEFT),
            '{kode}' => $context['kode'] ?? '',
            '{klasifikasi}' => $context['klasifikasi'] ?? '',
            '{tanggal}' => $tanggal->format('d'),
            '{bulan}' => $tanggal->format('m'),
            '{bulan_romawi}' => self::ROMAWI[$tanggal->month],
            '{tahun}' => $tanggal->format('Y'),
            '{tahun_2}' => $tanggal->format('y'),
        ]);
    }

    public function periode(SuratPenomoran $penomoran, Carbon $tanggal): string
    {
        return match ($penomoran->reset_period) {
            'bulanan' => $tanggal->format('Y-m'),
            'tidak' => '-',
            default => $tanggal->format('Y'),
        };
    }

    /** Kunci baris counter: format + periode (+ kode bila urutan dipisah per kode). */
    public function counterKey(SuratPenomoran $penomoran, Carbon $tanggal, array $context = []): array
    {
        return [
            'surat_penomoran_id' => $penomoran->id,
            'periode' => $this->periode($penomoran, $tanggal),
            'kode' => $penomoran->scope === 'per_kode' ? (string) ($context['kode'] ?? '') : '',
        ];
    }

    /** @return array{0:int,1:string} nomor urut dan nomor lengkap berikutnya yang belum terpakai */
    private function nextAvailable(SuratPenomoran $penomoran, int $last, Carbon $tanggal, array $context): array
    {
        $column = $penomoran->berlaku_untuk === 'masuk' ? 'no_agenda' : 'no_surat';
        $number = $last;

        for ($i = 0; $i < self::MAX_SKIP; $i++) {
            $nomor = $this->format($penomoran, ++$number, $tanggal, $context);
            if (!Surat::where($column, $nomor)->exists()) {
                break;
            }
        }

        return [$number, $nomor];
    }
}
