<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SuratPenomoran;
use App\Models\SuratPenomoranCounter;
use App\Services\NomorSuratGenerator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class SuratPenomoranController extends Controller
{
    public function __construct(private NomorSuratGenerator $generator)
    {
    }

    public function index()
    {
        $penomoran = SuratPenomoran::withCount(['templates', 'surat'])
            ->orderBy('berlaku_untuk')
            ->orderByDesc('is_default')
            ->orderBy('nama')
            ->get();

        // Nomor terakhir pada periode berjalan (per kode bila urutannya dipisah)
        $penomoran->each(function (SuratPenomoran $item) {
            $item->periode_berjalan = $this->generator->periode($item, now());
            $item->counter_berjalan = SuratPenomoranCounter::where('surat_penomoran_id', $item->id)
                ->where('periode', $item->periode_berjalan)
                ->orderBy('kode')
                ->pluck('last_number', 'kode');
            $item->contoh = $this->generator->format($item, 1, now(), ['kode' => 'UND', 'klasifikasi' => '005']);
        });

        return view('admin.surat-penomoran.index', compact('penomoran'));
    }

    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {
            $penomoran = SuratPenomoran::create($this->validated($request));
            $this->syncDefault($penomoran);
        });

        return back()->with('OK', 'Format penomoran berhasil ditambahkan.');
    }

    public function update(Request $request, SuratPenomoran $penomoran)
    {
        DB::transaction(function () use ($request, $penomoran) {
            $penomoran->update($this->validated($request));
            $this->syncDefault($penomoran);
        });

        return back()->with('OK', 'Format penomoran berhasil diperbarui.');
    }

    public function destroy(SuratPenomoran $penomoran)
    {
        if ($penomoran->surat()->exists()) {
            return back()->with('ERR', 'Format sudah dipakai oleh surat. Nonaktifkan saja agar riwayat nomor tetap tersimpan.');
        }

        $penomoran->delete();

        return back()->with('OK', 'Format penomoran berhasil dihapus.');
    }

    /** Preview contoh nomor saat admin mengetik format (AJAX). */
    public function preview(Request $request)
    {
        $request->validate([
            'format' => ['required', 'string', 'max:255'],
            'digit' => ['required', 'integer', 'min:1', 'max:10'],
        ]);

        $penomoran = new SuratPenomoran($request->only('format', 'digit'));
        $tanggal = $request->filled('tanggal') ? Carbon::parse($request->tanggal) : now();

        return response()->json([
            'contoh' => $this->generator->format($penomoran, 7, $tanggal, ['kode' => $request->kode ?: 'UND', 'klasifikasi' => '005']),
        ]);
    }

    /** Mengatur nomor terakhir periode berjalan, misalnya untuk melanjutkan penomoran manual. */
    public function setCounter(Request $request, SuratPenomoran $penomoran)
    {
        $validated = $request->validate([
            'last_number' => ['required', 'integer', 'min:0'],
            'kode' => ['nullable', 'string', 'max:50'],
        ]);

        SuratPenomoranCounter::updateOrCreate(
            $this->generator->counterKey($penomoran, now(), ['kode' => $validated['kode'] ?? '']),
            ['last_number' => $validated['last_number']]
        );

        return back()->with('OK', 'Nomor terakhir berhasil diatur. Surat berikutnya memakai nomor ' . ($validated['last_number'] + 1) . '.');
    }

    private function validated(Request $request): array
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'format' => ['required', 'string', 'max:255', function ($attribute, $value, $fail) {
                if (!str_contains($value, '{no}')) {
                    $fail('Format wajib mengandung token {no}.');
                }
            }],
            'digit' => ['required', 'integer', 'min:1', 'max:10'],
            'reset_period' => ['required', Rule::in(array_keys(SuratPenomoran::RESET_PERIOD))],
            'scope' => ['required', Rule::in(array_keys(SuratPenomoran::SCOPE))],
            'berlaku_untuk' => ['required', Rule::in(array_keys(SuratPenomoran::BERLAKU_UNTUK))],
            'keterangan' => ['nullable', 'string'],
        ]);

        return $validated + [
            'editable' => $request->boolean('editable'),
            'is_default' => $request->boolean('is_default'),
            'is_active' => $request->boolean('is_active'),
        ];
    }

    /** Hanya boleh ada satu format default per jenis (keluar / masuk). */
    private function syncDefault(SuratPenomoran $penomoran): void
    {
        if ($penomoran->is_default) {
            SuratPenomoran::where('berlaku_untuk', $penomoran->berlaku_untuk)
                ->whereKeyNot($penomoran->id)
                ->update(['is_default' => false]);
        }
    }
}
