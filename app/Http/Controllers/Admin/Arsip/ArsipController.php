<?php

namespace App\Http\Controllers\Admin\Arsip;

use App\Http\Controllers\Controller;
use App\Models\Arsip\Arsip;
use App\Models\Arsip\ArsipKategori;
use App\Models\Arsip\ArsipLokasi;
use App\Models\Arsip\ArsipMutasi;
use App\Models\FileKesekretariat;
use App\Models\Surat;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ArsipController extends Controller
{
    use QrLabel;

    public function index(Request $request)
    {
        $arsip = $this->filteredQuery($request)
            ->with(['kategori', 'lokasi.parent.parent.parent.parent'])
            ->paginate($request->integer('per_page', 15))
            ->withQueryString();

        return view('admin.arsip.data.index', [
            'arsip' => $arsip,
            'kategoriList' => ArsipKategori::orderBy('kode_klasifikasi')->get(),
            'lokasiOptions' => ArsipLokasi::options(),
            'tahunList' => Arsip::selectRaw('YEAR(tanggal_arsip) as tahun')->distinct()->orderByDesc('tahun')->pluck('tahun'),
        ]);
    }

    public function create(Request $request)
    {
        $arsip = new Arsip([
            'tanggal_arsip' => now(),
            'arsip_lokasi_id' => $request->lokasi,
            'jumlah' => 1,
            'satuan' => 'berkas',
            'media' => 'fisik',
            'tingkat_perkembangan' => 'asli',
            'status' => 'aktif',
        ]);

        // Prefill dari Surat / File Kesekretariat, mis. ?sumber=surat&sumber_id=5
        if ($request->filled('sumber') && isset(Arsip::SUMBER[$request->sumber])) {
            $sumber = Arsip::SUMBER[$request->sumber]::find($request->sumber_id);
            if ($sumber) {
                $arsip->sumber_type = $sumber::class;
                $arsip->sumber_id = $sumber->id;
                $arsip->judul = $sumber instanceof Surat ? $sumber->nama_kegiatan : $sumber->nama_dokumen;
                if ($sumber instanceof FileKesekretariat) {
                    $arsip->tanggal_arsip = $sumber->tanggal_dokumen;
                }
            }
        }

        return view('admin.arsip.data.form', $this->formData($arsip));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        $arsip = DB::transaction(function () use ($request, $data) {
            $data['nomor_arsip'] = Arsip::generateNomor(Carbon::parse($data['tanggal_arsip']));
            $data['created_by'] = auth()->id();
            if ($request->hasFile('file')) {
                $data['file_path'] = $request->file('file')->store('arsip', 'public');
            }

            $arsip = Arsip::create($data);

            if ($arsip->arsip_lokasi_id) {
                ArsipMutasi::create([
                    'arsip_id' => $arsip->id,
                    'lokasi_tujuan_id' => $arsip->arsip_lokasi_id,
                    'alasan' => 'Penempatan awal',
                    'user_id' => auth()->id(),
                ]);
            }

            return $arsip;
        });

        return redirect()->route('admin.arsip.data.show', $arsip)
            ->with('OK', "Arsip {$arsip->nomor_arsip} berhasil disimpan.");
    }

    public function show(Arsip $arsip)
    {
        $arsip->load([
            'kategori', 'lokasi', 'pembuat', 'sumber', 'pemusnahan',
            'peminjaman.petugas', 'mutasi.lokasiAsal', 'mutasi.lokasiTujuan', 'mutasi.user',
        ]);

        return view('admin.arsip.data.show', [
            'arsip' => $arsip,
            'qr' => $this->qrDataUri(route('admin.arsip.data.show', $arsip), 120),
            'lokasiOptions' => ArsipLokasi::options(),
        ]);
    }

    public function edit(Arsip $arsip)
    {
        if (!$this->bisaDiubah($arsip)) {
            return back()->with('ERR', "Arsip berstatus {$arsip->status_label} tidak bisa diubah.");
        }

        return view('admin.arsip.data.form', $this->formData($arsip));
    }

    public function update(Request $request, Arsip $arsip)
    {
        if (!$this->bisaDiubah($arsip)) {
            return back()->with('ERR', "Arsip berstatus {$arsip->status_label} tidak bisa diubah.");
        }

        $data = $this->validated($request, $arsip);
        $lokasiLama = $arsip->arsip_lokasi_id;

        DB::transaction(function () use ($request, $arsip, $data, $lokasiLama) {
            if ($request->hasFile('file')) {
                $this->hapusFile($arsip);
                $data['file_path'] = $request->file('file')->store('arsip', 'public');
            } elseif ($request->boolean('hapus_file')) {
                $this->hapusFile($arsip);
                $data['file_path'] = null;
            }

            $arsip->update($data);

            if ($lokasiLama != $arsip->arsip_lokasi_id) {
                ArsipMutasi::create([
                    'arsip_id' => $arsip->id,
                    'lokasi_asal_id' => $lokasiLama,
                    'lokasi_tujuan_id' => $arsip->arsip_lokasi_id,
                    'alasan' => 'Perubahan data arsip',
                    'user_id' => auth()->id(),
                ]);
            }
        });

        return redirect()->route('admin.arsip.data.show', $arsip)->with('OK', 'Arsip berhasil diperbarui.');
    }

    public function destroy(Arsip $arsip)
    {
        if ($arsip->status === 'dipinjam') {
            return back()->with('ERR', 'Arsip yang sedang dipinjam tidak bisa dihapus.');
        }
        if ($arsip->arsip_pemusnahan_id) {
            return back()->with('ERR', 'Arsip yang sudah tercatat di berita acara tidak bisa dihapus.');
        }

        $this->hapusFile($arsip);
        $arsip->delete();

        return redirect()->route('admin.arsip.data.index')->with('OK', 'Arsip berhasil dihapus.');
    }

    public function pindah(Request $request, Arsip $arsip)
    {
        $data = $request->validate([
            'arsip_lokasi_id' => ['required', 'exists:arsip_lokasi,id'],
            'alasan' => ['nullable', 'string', 'max:255'],
        ]);

        if (!$this->bisaDiubah($arsip)) {
            return back()->with('ERR', "Arsip berstatus {$arsip->status_label} tidak bisa dipindahkan.");
        }
        if ($data['arsip_lokasi_id'] == $arsip->arsip_lokasi_id) {
            return back()->with('ERR', 'Lokasi tujuan sama dengan lokasi saat ini.');
        }

        $tujuan = ArsipLokasi::find($data['arsip_lokasi_id']);
        if ($tujuan->isPenuh()) {
            return back()->with('ERR', "{$tujuan->tipe_label} {$tujuan->nama} sudah penuh (kapasitas {$tujuan->kapasitas}).");
        }

        DB::transaction(function () use ($arsip, $data) {
            ArsipMutasi::create([
                'arsip_id' => $arsip->id,
                'lokasi_asal_id' => $arsip->arsip_lokasi_id,
                'lokasi_tujuan_id' => $data['arsip_lokasi_id'],
                'alasan' => $data['alasan'] ?? null,
                'user_id' => auth()->id(),
            ]);
            $arsip->update(['arsip_lokasi_id' => $data['arsip_lokasi_id']]);
        });

        return back()->with('OK', 'Arsip berhasil dipindahkan ke ' . $tujuan->path . '.');
    }

    public function file(Request $request, Arsip $arsip)
    {
        if (!$arsip->file_path || !Storage::disk('public')->exists($arsip->file_path)) {
            return back()->with('ERR', 'File arsip tidak ditemukan.');
        }

        $nama = $arsip->nomor_arsip . '.' . pathinfo($arsip->file_path, PATHINFO_EXTENSION);

        return $request->boolean('download')
            ? Storage::disk('public')->download($arsip->file_path, $nama)
            : response()->file(Storage::disk('public')->path($arsip->file_path));
    }

    public function label(Arsip $arsip)
    {
        $labels = collect([[
            'judul' => 'Arsip',
            'kode' => $arsip->nomor_arsip,
            'nama' => $arsip->judul,
            'sub' => $arsip->lokasi ? $arsip->lokasi->kode_lengkap . ' · ' . $arsip->lokasi->path : null,
            'qr' => $this->qrDataUri(route('admin.arsip.data.show', $arsip)),
        ]]);

        return Pdf::loadView('admin.arsip.label-pdf', compact('labels'))
            ->setPaper('a4')
            ->stream('label-' . $arsip->nomor_arsip . '.pdf');
    }

    public function export(Request $request)
    {
        $rows = $this->filteredQuery($request)->with(['kategori', 'lokasi.parent.parent.parent.parent'])->get();
        $filename = 'data-arsip-' . now()->format('Ymd-His') . '.csv';

        return response()->streamDownload(function () use ($rows) {
            $handle = fopen('php://output', 'w');
            fwrite($handle, "\xEF\xBB\xBF");
            fputcsv($handle, [
                'Nomor Arsip', 'Judul', 'Klasifikasi', 'Tanggal Arsip', 'Jumlah', 'Satuan', 'Media',
                'Tingkat Perkembangan', 'Status', 'Kode Lokasi', 'Lokasi', 'Jatuh Tempo Retensi', 'Keterangan',
            ]);
            foreach ($rows as $row) {
                fputcsv($handle, [
                    $row->nomor_arsip,
                    $row->judul,
                    $row->kategori ? "{$row->kategori->kode_klasifikasi} - {$row->kategori->nama}" : '',
                    $row->tanggal_arsip->format('d/m/Y'),
                    $row->jumlah,
                    $row->satuan,
                    Arsip::MEDIA[$row->media] ?? $row->media,
                    Arsip::TINGKAT[$row->tingkat_perkembangan] ?? $row->tingkat_perkembangan,
                    $row->status_label,
                    $row->lokasi?->kode_lengkap,
                    $row->lokasi?->path,
                    $row->jatuh_tempo_retensi?->format('d/m/Y'),
                    $row->keterangan,
                ]);
            }
            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv; charset=utf-8']);
    }

    /** Opsi sumber (Surat / File Kesekretariat) untuk select di form, via AJAX. */
    public function sumberOptions(Request $request)
    {
        $search = $request->get('q');

        $items = match ($request->get('type')) {
            'surat' => Surat::when($search, fn ($q) => $q->where('no_surat', 'like', "%{$search}%")->orWhere('nama_kegiatan', 'like', "%{$search}%"))
                ->latest()->limit(50)->get()
                ->map(fn ($s) => ['id' => $s->id, 'text' => "[{$s->jenis_surat}] {$s->no_surat} - {$s->nama_kegiatan}"]),
            'file_kesekretariat' => FileKesekretariat::when($search, fn ($q) => $q->where('nama_dokumen', 'like', "%{$search}%"))
                ->latest()->limit(50)->get()
                ->map(fn ($f) => ['id' => $f->id, 'text' => $f->nama_dokumen . ' (' . $f->tanggal_dokumen?->format('d/m/Y') . ')']),
            default => collect(),
        };

        return response()->json($items->values());
    }

    private function filteredQuery(Request $request)
    {
        $query = Arsip::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(fn ($q) => $q->where('nomor_arsip', 'like', "%{$search}%")
                ->orWhere('judul', 'like', "%{$search}%")
                ->orWhere('uraian', 'like', "%{$search}%"));
        }
        if ($request->filled('kategori')) {
            $query->where('arsip_kategori_id', $request->kategori);
        }
        if ($request->filled('lokasi') && $lokasi = ArsipLokasi::find($request->lokasi)) {
            $query->whereIn('arsip_lokasi_id', $lokasi->descendantIds());
        }
        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_arsip', $request->tahun);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('media')) {
            $query->where('media', $request->media);
        }

        $sort = in_array($request->sort, ['nomor_arsip', 'judul', 'tanggal_arsip', 'created_at']) ? $request->sort : 'created_at';
        $order = $request->order === 'asc' ? 'asc' : 'desc';

        return $query->orderBy($sort, $order)->orderByDesc('id');
    }

    private function formData(Arsip $arsip): array
    {
        $sumberText = null;
        if ($arsip->sumber_type && $arsip->sumber_id) {
            $arsip->load('sumber');
            $sumberText = $arsip->sumber_label;
        }

        return [
            'arsip' => $arsip,
            'kategoriList' => ArsipKategori::orderBy('kode_klasifikasi')->get(),
            'lokasiOptions' => ArsipLokasi::options(),
            'sumberText' => $sumberText,
        ];
    }

    private function validated(Request $request, ?Arsip $arsip = null): array
    {
        $data = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'uraian' => ['nullable', 'string'],
            'arsip_kategori_id' => ['nullable', 'exists:arsip_kategori,id'],
            'arsip_lokasi_id' => ['nullable', 'exists:arsip_lokasi,id'],
            'tanggal_arsip' => ['required', 'date'],
            'jumlah' => ['required', 'integer', 'min:1'],
            'satuan' => ['required', 'string', 'max:20'],
            'media' => ['required', Rule::in(array_keys(Arsip::MEDIA))],
            'tingkat_perkembangan' => ['required', Rule::in(array_keys(Arsip::TINGKAT))],
            'status' => ['required', Rule::in(['aktif', 'inaktif'])],
            'file' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx', 'max:20480'],
            'sumber' => ['nullable', Rule::in(array_keys(Arsip::SUMBER))],
            'sumber_id' => ['nullable', 'required_with:sumber', 'integer'],
            'keterangan' => ['nullable', 'string'],
        ], [], [
            'arsip_kategori_id' => 'klasifikasi',
            'arsip_lokasi_id' => 'lokasi',
            'file' => 'file arsip',
        ]);

        if ($data['media'] !== 'digital' && empty($data['arsip_lokasi_id'])) {
            abort(back()->withInput()->with('ERR', 'Arsip fisik wajib memiliki lokasi penyimpanan.'));
        }

        $lokasiBerubah = $data['arsip_lokasi_id'] && $data['arsip_lokasi_id'] != $arsip?->arsip_lokasi_id;
        if ($lokasiBerubah && ($lokasi = ArsipLokasi::find($data['arsip_lokasi_id']))->isPenuh()) {
            abort(back()->withInput()->with('ERR', "{$lokasi->tipe_label} {$lokasi->nama} sudah penuh (kapasitas {$lokasi->kapasitas})."));
        }

        if (!empty($data['sumber'])) {
            $class = Arsip::SUMBER[$data['sumber']];
            if (!$class::whereKey($data['sumber_id'])->exists()) {
                abort(back()->withInput()->with('ERR', 'Data sumber yang ditautkan tidak ditemukan.'));
            }
            $data['sumber_type'] = $class;
        } else {
            $data['sumber_type'] = null;
            $data['sumber_id'] = null;
        }

        unset($data['sumber'], $data['file']);

        return $data;
    }

    private function bisaDiubah(Arsip $arsip): bool
    {
        return in_array($arsip->status, ['aktif', 'inaktif']);
    }

    private function hapusFile(Arsip $arsip): void
    {
        if ($arsip->file_path) {
            Storage::disk('public')->delete($arsip->file_path);
        }
    }
}
