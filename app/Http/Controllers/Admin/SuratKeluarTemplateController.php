<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Arsip\ArsipKategori;
use App\Models\Surat;
use App\Models\SuratTemplate;
use App\Services\NomorSuratGenerator;
use App\Services\SuratTemplateRenderer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

/** Membuat dan mengubah surat keluar dari template surat. */
class SuratKeluarTemplateController extends Controller
{
    public function __construct(
        private NomorSuratGenerator $generator,
        private SuratTemplateRenderer $renderer,
    ) {
    }

    public function create(Request $request)
    {
        $templates = SuratTemplate::active()->orderBy('nama')->get();

        if ($templates->isEmpty()) {
            return redirect()->route(auth()->user()->can('surat-template') ? 'admin.surat-template.index' : 'admin.surat.index')
                ->with('ERR', 'Belum ada template surat yang aktif. Buat template terlebih dahulu.');
        }

        $template = $templates->firstWhere('id', (int) $request->template) ?? $templates->first();
        $surat = new Surat(['tanggal_surat' => now(), 'data_template' => []]);

        return view('admin.surat.template-form', $this->formData($surat, $template, $templates));
    }

    public function store(Request $request)
    {
        $template = SuratTemplate::active()->findOrFail($request->input('surat_template_id'));
        $penomoran = $template->penomoranEfektif();
        $otomatis = $penomoran && ($request->boolean('nomor_otomatis') || !$penomoran->editable);
        if ($otomatis) {
            // Nomor di form hanya perkiraan; nomor final dibuat saat disimpan
            $request->merge(['no_surat' => null]);
        }

        $validated = $request->validate($this->rules($template, $otomatis), [], $this->attributes($template));
        $tanggal = Carbon::parse($validated['tanggal_surat']);

        $surat = DB::transaction(function () use ($validated, $template, $penomoran, $otomatis, $tanggal) {
            $surat = new Surat([
                'nama_kegiatan' => $validated['nama_kegiatan'],
                'jenis_surat' => 'keluar',
                'sumber' => 'template',
                'tanggal_surat' => $tanggal,
                'surat_template_id' => $template->id,
                'surat_penomoran_id' => $otomatis ? $penomoran->id : null,
                'kode_klasifikasi' => $validated['kode_klasifikasi'] ?? null,
                'data_template' => $validated['data'] ?? [],
            ]);
            $surat->no_surat = $otomatis
                ? $this->generator->generate($penomoran, $tanggal, $this->context($template, $surat->kode_klasifikasi))
                : $validated['no_surat'];
            $surat->save();

            // PDF dibuat di dalam transaksi: bila gagal, nomor yang sudah diambil ikut dibatalkan
            $surat->update(['dokumen_surat' => $this->renderer->storeForSurat($surat, $template)]);

            return $surat;
        });

        return redirect()->route('admin.surat.index', ['jenis_surat' => 'keluar'])
            ->with('OK', "Surat {$surat->no_surat} berhasil dibuat.");
    }

    public function edit(Surat $surat)
    {
        abort_unless($surat->isFromTemplate() && $surat->template, 404);

        return view('admin.surat.template-form', $this->formData($surat, $surat->template, collect([$surat->template])));
    }

    public function update(Request $request, Surat $surat)
    {
        abort_unless($surat->isFromTemplate() && $surat->template, 404);
        $template = $surat->template;

        $validated = $request->validate($this->rules($template, false, $surat), [], $this->attributes($template));

        DB::transaction(function () use ($surat, $template, $validated) {
            $surat->fill([
                'nama_kegiatan' => $validated['nama_kegiatan'],
                'no_surat' => $validated['no_surat'],
                'tanggal_surat' => $validated['tanggal_surat'],
                'kode_klasifikasi' => $validated['kode_klasifikasi'] ?? null,
                'data_template' => $validated['data'] ?? [],
            ])->save();

            $surat->update(['dokumen_surat' => $this->renderer->storeForSurat($surat, $template)]);
        });

        return redirect()->route('admin.surat.index', ['jenis_surat' => 'keluar'])
            ->with('OK', "Surat {$surat->no_surat} berhasil diperbarui.");
    }

    /** Preview PDF dari isian form tanpa menyimpan dan tanpa mengambil nomor. */
    public function preview(Request $request)
    {
        $template = SuratTemplate::findOrFail($request->input('surat_template_id'));
        $tanggal = $request->filled('tanggal_surat') ? Carbon::parse($request->tanggal_surat) : now();
        $penomoran = $template->penomoranEfektif();

        $nomor = $request->input('no_surat');
        if ($request->boolean('nomor_otomatis') && $penomoran) {
            $nomor = $this->generator->preview($penomoran, $tanggal, $this->context($template, $request->input('kode_klasifikasi')));
        }

        return $this->renderer->pdf($template, (array) $request->input('data', []), [
            'nomor_surat' => $nomor ?: '(nomor surat)',
            'tanggal_surat' => $tanggal,
            'perihal' => $request->input('nama_kegiatan'),
        ], sample: true)->stream('preview-surat.pdf');
    }

    private function formData(Surat $surat, SuratTemplate $template, $templates): array
    {
        $penomoran = $template->penomoranEfektif();
        // Surat baru memakai klasifikasi template sebagai nilai awal
        $klasifikasi = $surat->exists ? $surat->kode_klasifikasi : $template->kode_klasifikasi;

        return [
            'surat' => $surat,
            'template' => $template,
            'templates' => $templates,
            'penomoran' => $penomoran,
            'klasifikasi' => $klasifikasi,
            'klasifikasiList' => ArsipKategori::orderBy('kode_klasifikasi')->get(['kode_klasifikasi', 'nama']),
            'nomorPreview' => $penomoran && !$surat->exists
                ? $this->generator->preview($penomoran, now(), $this->context($template, $klasifikasi))
                : null,
        ];
    }

    private function rules(SuratTemplate $template, bool $otomatis, ?Surat $surat = null): array
    {
        $rules = [
            'nama_kegiatan' => ['required', 'string', 'max:255'],
            'tanggal_surat' => ['required', 'date'],
            'no_surat' => [$otomatis ? 'nullable' : 'required', 'string', 'max:255', Rule::unique('surat', 'no_surat')->ignore($surat?->id)],
            'kode_klasifikasi' => ['nullable', 'string', 'max:50'],
            'data' => ['nullable', 'array'],
        ];

        foreach ($template->field_list as $field) {
            $rules['data.' . $field['key']] = array_merge(
                [!empty($field['required']) ? 'required' : 'nullable'],
                match ($field['type'] ?? 'text') {
                    'date' => ['date'],
                    'number' => ['numeric'],
                    'textarea' => ['string', 'max:10000'],
                    default => ['string', 'max:1000'],
                }
            );
        }

        return $rules;
    }

    private function attributes(SuratTemplate $template): array
    {
        return collect($template->field_list)
            ->mapWithKeys(fn ($field) => ['data.' . $field['key'] => $field['label']])
            ->merge(['nama_kegiatan' => 'perihal', 'tanggal_surat' => 'tanggal surat', 'no_surat' => 'nomor surat', 'kode_klasifikasi' => 'kode klasifikasi'])
            ->all();
    }

    private function context(SuratTemplate $template, ?string $klasifikasi): array
    {
        return ['kode' => $template->kode, 'klasifikasi' => (string) $klasifikasi];
    }
}
