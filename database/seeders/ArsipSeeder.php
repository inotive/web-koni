<?php

namespace Database\Seeders;

use App\Models\Arsip\ArsipKategori;
use App\Models\Arsip\ArsipLokasi;
use Illuminate\Database\Seeder;

class ArsipSeeder extends Seeder
{
    /**
     * Data awal klasifikasi arsip dan contoh struktur lokasi penyimpanan.
     */
    public function run(): void
    {
        $kategori = [
            ['kode_klasifikasi' => '000', 'nama' => 'Umum', 'retensi_aktif_tahun' => 2, 'retensi_inaktif_tahun' => 3, 'tindakan_akhir' => 'musnah'],
            ['kode_klasifikasi' => '005', 'nama' => 'Undangan', 'retensi_aktif_tahun' => 1, 'retensi_inaktif_tahun' => 1, 'tindakan_akhir' => 'musnah'],
            ['kode_klasifikasi' => '010', 'nama' => 'Surat Masuk & Keluar', 'retensi_aktif_tahun' => 2, 'retensi_inaktif_tahun' => 3, 'tindakan_akhir' => 'dinilai_kembali'],
            ['kode_klasifikasi' => '060', 'nama' => 'Organisasi & Tata Laksana', 'retensi_aktif_tahun' => 5, 'retensi_inaktif_tahun' => 5, 'tindakan_akhir' => 'permanen'],
            ['kode_klasifikasi' => '800', 'nama' => 'Kepegawaian / Kepengurusan', 'retensi_aktif_tahun' => 5, 'retensi_inaktif_tahun' => 5, 'tindakan_akhir' => 'permanen'],
            ['kode_klasifikasi' => '900', 'nama' => 'Keuangan (RKA, LPJ, SPJ)', 'retensi_aktif_tahun' => 2, 'retensi_inaktif_tahun' => 8, 'tindakan_akhir' => 'musnah'],
            ['kode_klasifikasi' => '420', 'nama' => 'Pembinaan Prestasi Olahraga', 'retensi_aktif_tahun' => 3, 'retensi_inaktif_tahun' => 7, 'tindakan_akhir' => 'permanen'],
        ];

        foreach ($kategori as $item) {
            ArsipKategori::updateOrCreate(['kode_klasifikasi' => $item['kode_klasifikasi']], $item);
        }

        if (ArsipLokasi::exists()) {
            return;
        }

        $gedung = ArsipLokasi::create(['tipe' => 'gedung', 'kode' => 'G1', 'nama' => 'Kantor KONI']);
        $ruang = ArsipLokasi::create(['parent_id' => $gedung->id, 'tipe' => 'ruang', 'kode' => 'R1', 'nama' => 'Ruang Arsip']);

        foreach (['A', 'B'] as $rakKode) {
            $rak = ArsipLokasi::create(['parent_id' => $ruang->id, 'tipe' => 'rak', 'kode' => $rakKode, 'nama' => "Rak {$rakKode}"]);
            foreach ([1, 2, 3] as $baris) {
                $row = ArsipLokasi::create(['parent_id' => $rak->id, 'tipe' => 'baris', 'kode' => (string) $baris, 'nama' => "Baris {$baris}"]);
                foreach ([1, 2] as $box) {
                    ArsipLokasi::create([
                        'parent_id' => $row->id,
                        'tipe' => 'box',
                        'kode' => sprintf('BX%02d', $box),
                        'nama' => sprintf('Box %02d', $box),
                        'kapasitas' => 20,
                    ]);
                }
            }
        }
    }
}
