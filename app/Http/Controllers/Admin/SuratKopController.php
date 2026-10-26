<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SuratKop;
use App\Services\SuratTemplateRenderer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class SuratKopController extends Controller
{
    private const IMAGES = ['gambar', 'logo_kiri', 'logo_kanan'];

    public function __construct(private SuratTemplateRenderer $renderer)
    {
    }

    public function index()
    {
        $kops = SuratKop::withCount('templates')
            ->orderByDesc('is_default')
            ->orderByDesc('is_active')
            ->orderBy('nama')
            ->get()
            ->each(fn (SuratKop $kop) => $kop->view = $this->renderer->kopToView($kop));

        return view('admin.surat-kop.index', compact('kops'));
    }

    public function create()
    {
        return view('admin.surat-kop.form', ['kop' => new SuratKop([
            'jenis' => 'susun',
            'garis' => 'ganda',
            'is_active' => true,
            'baris' => [
                ['teks' => 'KOMITE OLAHRAGA NASIONAL INDONESIA', 'ukuran' => 14, 'tebal' => true],
                ['teks' => '', 'ukuran' => 11, 'tebal' => false],
            ],
        ])]);
    }

    public function store(Request $request)
    {
        $this->save($request, new SuratKop());

        return redirect()->route('admin.surat-kop.index')->with('OK', 'Kop surat berhasil ditambahkan.');
    }

    public function edit(SuratKop $kop)
    {
        return view('admin.surat-kop.form', compact('kop'));
    }

    public function update(Request $request, SuratKop $kop)
    {
        $this->save($request, $kop);

        return redirect()->route('admin.surat-kop.index')->with('OK', 'Kop surat berhasil diperbarui.');
    }

    public function destroy(SuratKop $kop)
    {
        if ($kop->templates()->exists()) {
            return back()->with('ERR', 'Kop masih dipilih oleh template. Ganti kop di template tersebut atau nonaktifkan kop ini.');
        }

        Storage::disk('public')->delete(array_filter($kop->only(self::IMAGES)));
        $kop->delete();

        return back()->with('OK', 'Kop surat berhasil dihapus.');
    }

    public function show(SuratKop $kop)
    {
        return $this->renderer->kopPdf($kop)->stream('kop-' . $kop->id . '.pdf');
    }

    /** Preview dari isian form tanpa menyimpan. */
    public function preview(Request $request, ?SuratKop $kop = null)
    {
        $kop = $kop?->exists ? $kop->replicate() : new SuratKop();
        $kop->fill($request->only('jenis', 'garis'));
        $kop->baris = $this->parseBaris($request->input('baris', []));

        $tmp = [];
        foreach (self::IMAGES as $image) {
            if ($request->hasFile($image)) {
                $kop->{$image} = $tmp[] = $request->file($image)->store('surat-kop/tmp', 'public');
            } elseif ($request->boolean("hapus_{$image}")) {
                $kop->{$image} = null;
            }
        }

        // Gambar disematkan sebagai data URI saat view dirender, jadi file sementara aman dihapus
        $pdf = $this->renderer->kopPdf($kop);
        Storage::disk('public')->delete($tmp);

        return $pdf->stream('preview-kop.pdf');
    }

    private function save(Request $request, SuratKop $kop): void
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'jenis' => ['required', Rule::in(array_keys(SuratKop::JENIS))],
            'garis' => ['required', Rule::in(array_keys(SuratKop::GARIS))],
            'baris' => ['nullable', 'array'],
            'baris.*.teks' => ['nullable', 'string', 'max:255'],
            'baris.*.ukuran' => ['nullable', 'numeric', 'min:6', 'max:30'],
            'gambar' => [$request->jenis === 'gambar' && !$kop->gambar ? 'required' : 'nullable', 'image', 'max:2048'],
            'logo_kiri' => ['nullable', 'image', 'max:1024'],
            'logo_kanan' => ['nullable', 'image', 'max:1024'],
        ], [
            'gambar.required' => 'Gambar kop wajib di-upload untuk jenis "Upload gambar kop".',
        ]);

        DB::transaction(function () use ($request, $kop, $validated) {
            $kop->fill([
                'nama' => $validated['nama'],
                'jenis' => $validated['jenis'],
                'garis' => $validated['garis'],
                'baris' => $this->parseBaris($validated['baris'] ?? []),
                'is_default' => $request->boolean('is_default'),
                'is_active' => $request->boolean('is_active'),
            ]);

            foreach (self::IMAGES as $image) {
                if ($request->hasFile($image)) {
                    if ($kop->{$image}) {
                        Storage::disk('public')->delete($kop->{$image});
                    }
                    $kop->{$image} = $request->file($image)->store('surat-kop', 'public');
                } elseif ($request->boolean("hapus_{$image}") && $kop->{$image}) {
                    Storage::disk('public')->delete($kop->{$image});
                    $kop->{$image} = null;
                }
            }

            $kop->save();

            // Hanya boleh ada satu kop default
            if ($kop->is_default) {
                SuratKop::whereKeyNot($kop->id)->update(['is_default' => false]);
            }
        });
    }

    private function parseBaris(array $baris): array
    {
        return collect($baris)
            ->filter(fn ($b) => trim($b['teks'] ?? '') !== '')
            ->map(fn ($b) => [
                'teks' => trim($b['teks']),
                'ukuran' => (float) ($b['ukuran'] ?? 11) ?: 11,
                'tebal' => filter_var($b['tebal'] ?? false, FILTER_VALIDATE_BOOLEAN),
            ])
            ->values()
            ->all();
    }
}
