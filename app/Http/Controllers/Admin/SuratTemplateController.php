<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Arsip\ArsipKategori;
use App\Models\SuratKop;
use App\Models\SuratPenomoran;
use App\Models\SuratTemplate;
use App\Services\SuratTemplateRenderer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class SuratTemplateController extends Controller
{
    public function __construct(private SuratTemplateRenderer $renderer)
    {
    }

    public function index(Request $request)
    {
        $templates = SuratTemplate::with('penomoran')
            ->withCount('surat')
            ->when($request->filled('search'), function ($q) use ($request) {
                $q->where(fn ($q) => $q->where('nama', 'like', "%{$request->search}%")
                    ->orWhere('kode', 'like', "%{$request->search}%"));
            })
            ->orderByDesc('is_active')
            ->orderBy('nama')
            ->paginate(15)
            ->withQueryString();

        return view('admin.surat-template.index', compact('templates'));
    }

    public function create()
    {
        return $this->form(new SuratTemplate([
            'is_active' => true,
            'tampilkan_ttd' => true,
            'tampilkan_kop' => true,
            'ukuran_kertas' => 'a4',
            'fields' => [],
        ]));
    }

    public function store(Request $request)
    {
        $template = new SuratTemplate();
        $this->fillAndSave($request, $template);

        return redirect()->route('admin.surat-template.index')->with('OK', 'Template surat berhasil ditambahkan.');
    }

    public function edit(SuratTemplate $template)
    {
        return $this->form($template);
    }

    public function update(Request $request, SuratTemplate $template)
    {
        $this->fillAndSave($request, $template);

        return redirect()->route('admin.surat-template.index')->with('OK', 'Template surat berhasil diperbarui.');
    }

    public function destroy(SuratTemplate $template)
    {
        if ($template->surat()->exists()) {
            return back()->with('ERR', 'Template sudah dipakai oleh surat. Nonaktifkan saja agar surat lama tetap bisa dibuka ulang.');
        }

        Storage::disk('public')->delete(array_filter([$template->kop_surat, $template->ttd]));
        $template->delete();

        return back()->with('OK', 'Template surat berhasil dihapus.');
    }

    /** Preview PDF dari isian form (belum disimpan) dengan data contoh. */
    public function preview(Request $request, ?SuratTemplate $template = null)
    {
        $template = $template?->exists ? $template->replicate() : new SuratTemplate();
        $template->fill($request->only([
            'nama', 'kode', 'kode_klasifikasi', 'surat_penomoran_id', 'surat_kop_id', 'isi', 'penandatangan_nama',
            'penandatangan_jabatan', 'penandatangan_nip', 'kota_surat', 'ukuran_kertas',
        ]));
        $template->tampilkan_ttd = $request->boolean('tampilkan_ttd');
        $template->tampilkan_kop = $request->boolean('tampilkan_kop');
        $template->fields = $this->parseFields($request->input('fields', []));
        $template->isi ??= '';

        // Gambar baru yang belum disimpan dipakai sementara dari file upload
        $tmp = [];
        foreach (['kop_surat', 'ttd'] as $image) {
            if ($request->hasFile($image)) {
                $template->{$image} = $tmp[] = $request->file($image)->store('surat-template/tmp', 'public');
            } elseif ($request->boolean("hapus_{$image}")) {
                $template->{$image} = null;
            }
        }

        // Gambar sudah disematkan sebagai data URI saat view dirender, jadi file sementara aman dihapus
        $pdf = $this->renderer->pdf($template, [], $this->renderer->sampleMeta($template), sample: true);
        Storage::disk('public')->delete($tmp);

        return $pdf->stream('preview-template.pdf');
    }

    private function form(SuratTemplate $template)
    {
        return view('admin.surat-template.form', [
            'template' => $template,
            'penomoranList' => SuratPenomoran::active()->untuk('keluar')->orderByDesc('is_default')->orderBy('nama')->get(),
            'klasifikasiList' => ArsipKategori::orderBy('kode_klasifikasi')->get(['kode_klasifikasi', 'nama']),
            'kopList' => SuratKop::active()->orderBy('nama')->get(['id', 'nama']),
            'kopDefault' => SuratKop::default(),
        ]);
    }

    private function fillAndSave(Request $request, SuratTemplate $template): void
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'kode' => ['required', 'string', 'max:50', 'regex:/^[A-Za-z0-9.\-]+$/'],
            'kode_klasifikasi' => ['nullable', 'string', 'max:50'],
            'surat_penomoran_id' => ['nullable', Rule::exists('surat_penomoran', 'id')->where('berlaku_untuk', 'keluar')],
            'surat_kop_id' => ['nullable', Rule::exists('surat_kop', 'id')],
            'isi' => ['required', 'string'],
            'fields' => ['nullable', 'array'],
            'fields.*.label' => ['required_with:fields', 'string', 'max:100'],
            'fields.*.type' => ['required_with:fields', Rule::in(array_keys(SuratTemplate::FIELD_TYPES))],
            // key & required wajib didaftarkan, kalau tidak dibuang dari $validated dan placeholder lama putus
            'fields.*.key' => ['nullable', 'string', 'max:100'],
            'fields.*.required' => ['nullable'],
            'penandatangan_nama' => ['nullable', 'string', 'max:255'],
            'penandatangan_jabatan' => ['nullable', 'string', 'max:255'],
            'penandatangan_nip' => ['nullable', 'string', 'max:255'],
            'kota_surat' => ['nullable', 'string', 'max:255'],
            'ukuran_kertas' => ['required', Rule::in(['a4', 'f4'])],
            'keterangan' => ['nullable', 'string'],
            'kop_surat' => ['nullable', 'image', 'max:2048'],
            'ttd' => ['nullable', 'image', 'max:1024'],
        ], [
            'kode.regex' => 'Kode hanya boleh berisi huruf, angka, titik, dan tanda hubung.',
        ]);

        $template->fill(collect($validated)->except(['kop_surat', 'ttd', 'fields'])->all());
        $template->kode = strtoupper($validated['kode']);
        $template->fields = $this->parseFields($validated['fields'] ?? []);
        $template->tampilkan_ttd = $request->boolean('tampilkan_ttd');
        $template->tampilkan_kop = $request->boolean('tampilkan_kop');
        $template->is_active = $request->boolean('is_active');

        foreach (['kop_surat', 'ttd'] as $image) {
            if ($request->hasFile($image)) {
                if ($template->{$image}) {
                    Storage::disk('public')->delete($template->{$image});
                }
                $template->{$image} = $request->file($image)->store('surat-template', 'public');
            } elseif ($request->boolean("hapus_{$image}") && $template->{$image}) {
                Storage::disk('public')->delete($template->{$image});
                $template->{$image} = null;
            }
        }

        $template->save();
    }

    /**
     * Rapikan definisi field dari form builder: key dibuat dari label,
     * dan dijamin unik serta tidak bentrok dengan placeholder bawaan.
     */
    private function parseFields(array $fields): array
    {
        $result = [];
        $used = array_keys(SuratTemplate::PLACEHOLDERS);

        foreach (array_values($fields) as $field) {
            $label = trim($field['label'] ?? '');
            if ($label === '') {
                continue;
            }

            $base = Str::snake(Str::ascii(preg_replace('/[^A-Za-z0-9 ]/', ' ', $field['key'] ?? '') ?: $label));
            $base = trim(preg_replace('/_+/', '_', Str::slug($base, '_')), '_') ?: 'field';
            $key = $base;
            for ($i = 2; in_array($key, $used, true); $i++) {
                $key = "{$base}_{$i}";
            }
            $used[] = $key;

            $result[] = [
                'key' => $key,
                'label' => $label,
                'type' => array_key_exists($field['type'] ?? '', SuratTemplate::FIELD_TYPES) ? $field['type'] : 'text',
                'required' => filter_var($field['required'] ?? false, FILTER_VALIDATE_BOOLEAN),
            ];
        }

        return $result;
    }
}
