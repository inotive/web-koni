<?php

namespace Database\Seeders;

use App\Models\SuratKop;
use App\Models\SuratPenomoran;
use App\Models\SuratTemplate;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class SuratTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedKop();

        $keluar = SuratPenomoran::updateOrCreate(['nama' => 'Nomor Surat Keluar'], [
            'format' => '{no}/{kode}/KONI/{bulan_romawi}/{tahun}',
            'digit' => 3,
            'reset_period' => 'tahunan',
            'scope' => 'bersama',
            'editable' => true,
            'berlaku_untuk' => 'keluar',
            'is_default' => true,
            'is_active' => true,
            'keterangan' => 'Satu urutan untuk semua surat keluar, reset setiap tahun.',
        ]);

        SuratPenomoran::updateOrCreate(['nama' => 'Nomor Agenda Surat Masuk'], [
            'format' => '{no}/AGD/{tahun}',
            'digit' => 4,
            'reset_period' => 'tahunan',
            'scope' => 'bersama',
            'editable' => false,
            'berlaku_untuk' => 'masuk',
            'is_default' => true,
            'is_active' => true,
            'keterangan' => 'Nomor agenda surat masuk, reset setiap tahun.',
        ]);

        $kepala = '<table style="border-collapse: collapse; width: 100%;"><tbody>'
            . '<tr><td style="width: 18%;">Nomor</td><td style="width: 2%;">:</td><td>{{nomor_surat}}</td></tr>'
            . '<tr><td>Lampiran</td><td>:</td><td>{{lampiran}}</td></tr>'
            . '<tr><td>Perihal</td><td>:</td><td><strong>{{perihal}}</strong></td></tr>'
            . '</tbody></table><p>&nbsp;</p>';

        SuratTemplate::updateOrCreate(['kode' => 'UND'], [
            'nama' => 'Undangan',
            'surat_penomoran_id' => $keluar->id,
            'isi' => $kepala
                . '<p>Kepada Yth.<br>{{tujuan}}<br>di Tempat</p><p>&nbsp;</p>'
                . '<p>Dengan hormat,</p>'
                . '<p style="text-align: justify;">Sehubungan dengan {{latar_belakang}}, dengan ini kami mengundang Bapak/Ibu untuk hadir pada:</p>'
                . '<table style="border-collapse: collapse; margin-left: 30px;"><tbody>'
                . '<tr><td style="width: 120px;">Hari/Tanggal</td><td>:</td><td>{{tanggal_acara}}</td></tr>'
                . '<tr><td>Waktu</td><td>:</td><td>{{waktu}}</td></tr>'
                . '<tr><td>Tempat</td><td>:</td><td>{{tempat}}</td></tr>'
                . '<tr><td>Acara</td><td>:</td><td>{{acara}}</td></tr>'
                . '</tbody></table><p>&nbsp;</p>'
                . '<p style="text-align: justify;">Demikian undangan ini kami sampaikan. Atas perhatian dan kehadiran Bapak/Ibu, kami ucapkan terima kasih.</p>',
            'fields' => [
                ['key' => 'lampiran', 'label' => 'Lampiran', 'type' => 'text', 'required' => false],
                ['key' => 'tujuan', 'label' => 'Tujuan Surat', 'type' => 'textarea', 'required' => true],
                ['key' => 'latar_belakang', 'label' => 'Sehubungan Dengan', 'type' => 'text', 'required' => true],
                ['key' => 'tanggal_acara', 'label' => 'Hari/Tanggal Acara', 'type' => 'text', 'required' => true],
                ['key' => 'waktu', 'label' => 'Waktu', 'type' => 'text', 'required' => true],
                ['key' => 'tempat', 'label' => 'Tempat', 'type' => 'text', 'required' => true],
                ['key' => 'acara', 'label' => 'Acara', 'type' => 'text', 'required' => true],
            ],
            'tampilkan_ttd' => true,
            'penandatangan_jabatan' => 'Ketua Umum',
            'ukuran_kertas' => 'a4',
            'is_active' => true,
            'keterangan' => 'Contoh template undangan rapat/kegiatan.',
        ]);

        SuratTemplate::updateOrCreate(['kode' => 'ST'], [
            'nama' => 'Surat Tugas',
            'surat_penomoran_id' => $keluar->id,
            'isi' => '<p style="text-align: center;"><strong><u>SURAT TUGAS</u></strong><br>Nomor: {{nomor_surat}}</p><p>&nbsp;</p>'
                . '<p style="text-align: justify;">Yang bertanda tangan di bawah ini, {{penandatangan_jabatan}}, dengan ini menugaskan kepada:</p>'
                . '<table style="border-collapse: collapse; margin-left: 30px;"><tbody>'
                . '<tr><td style="width: 120px;">Nama</td><td>:</td><td>{{nama_petugas}}</td></tr>'
                . '<tr><td>Jabatan</td><td>:</td><td>{{jabatan_petugas}}</td></tr>'
                . '</tbody></table><p>&nbsp;</p>'
                . '<p style="text-align: justify;">Untuk {{keperluan}} yang dilaksanakan pada tanggal {{tanggal_tugas}} bertempat di {{tempat}}.</p>'
                . '<p style="text-align: justify;">Demikian surat tugas ini dibuat untuk dilaksanakan dengan penuh tanggung jawab.</p>',
            'fields' => [
                ['key' => 'nama_petugas', 'label' => 'Nama Petugas', 'type' => 'text', 'required' => true],
                ['key' => 'jabatan_petugas', 'label' => 'Jabatan Petugas', 'type' => 'text', 'required' => true],
                ['key' => 'keperluan', 'label' => 'Keperluan', 'type' => 'textarea', 'required' => true],
                ['key' => 'tanggal_tugas', 'label' => 'Tanggal Tugas', 'type' => 'date', 'required' => true],
                ['key' => 'tempat', 'label' => 'Tempat', 'type' => 'text', 'required' => true],
            ],
            'tampilkan_ttd' => true,
            'penandatangan_jabatan' => 'Ketua Umum',
            'ukuran_kertas' => 'a4',
            'is_active' => true,
            'keterangan' => 'Contoh template surat tugas.',
        ]);
    }

    /** Kop KONI Kabupaten Tabalong dari aset yang sudah ada di public/assets/img. */
    private function seedKop(): void
    {
        $gambar = $this->copyAsset('kop-nobg.png', 'surat-kop/kop-koni-tabalong.png');
        $logo = $this->copyAsset('logo-koni-simplified.png', 'surat-kop/logo-koni.png');

        SuratKop::updateOrCreate(['nama' => 'Kop Resmi KONI Tabalong'], [
            'jenis' => 'gambar',
            'gambar' => $gambar,
            'garis' => 'tidak',
            'is_default' => !SuratKop::where('is_default', true)->where('nama', '!=', 'Kop Resmi KONI Tabalong')->exists(),
            'is_active' => true,
        ]);

        SuratKop::updateOrCreate(['nama' => 'Kop Teks KONI Tabalong'], [
            'jenis' => 'susun',
            'logo_kiri' => $logo,
            'baris' => [
                ['teks' => 'KOMITE OLAHRAGA NASIONAL INDONESIA', 'ukuran' => 15, 'tebal' => true],
                ['teks' => 'KABUPATEN TABALONG', 'ukuran' => 15, 'tebal' => true],
                ['teks' => 'Alamat Sekretariat : Jln. P.H.M.Noor Komplek Stadion Pembataan Tanjung 71571', 'ukuran' => 10, 'tebal' => false],
                ['teks' => 'Kabupaten Tabalong Telp/Fax 0526 2025230', 'ukuran' => 10, 'tebal' => false],
                ['teks' => 'Website : www.konitabalong.net  E-mail : konitabalong@yahoo.co.id', 'ukuran' => 10, 'tebal' => false],
            ],
            'garis' => 'ganda',
            'is_active' => true,
        ]);
    }

    private function copyAsset(string $file, string $target): ?string
    {
        $source = public_path('assets/img/' . $file);
        if (!Storage::disk('public')->exists($target) && is_file($source)) {
            Storage::disk('public')->put($target, file_get_contents($source));
        }

        return Storage::disk('public')->exists($target) ? $target : null;
    }
}
