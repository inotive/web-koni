<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\KegiatanLainnya;
use Carbon\Carbon;

class KegiatanLainnyaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kegiatanData = [
            [
                'nama_program_kegiatan' => 'Pelatihan Kewirausahaan',
                'jenis_kegiatan' => 'Pelatihan',
                'volume' => '2 sesi',
                'jumlah_harga_satuan' => 500000,
                'jumlah_harga' => 1000000,
                'foto_jurnal' => json_encode(['kegiatan/pelatihan1.jpg', 'kegiatan/pelatihan2.jpg']),
                'dokumen_pendukung' => json_encode(['dokumen/proposal-pelatihan.pdf']),
                'keterangan_tambahan' => 'Pelatihan untuk pemuda desa',
                'status_approval' => 'approved',
                'approved_at' => Carbon::now()->subDays(5),
                'approved_by' => 1,
                'created_at' => Carbon::now()->subDays(10),
                'updated_at' => Carbon::now()->subDays(5),
            ],
            [
                'nama_program_kegiatan' => 'Bakti Sosial',
                'jenis_kegiatan' => 'Sosial',
                'volume' => '1 hari',
                'jumlah_harga_satuan' => 750000,
                'jumlah_harga' => 750000,
                'foto_jurnal' => json_encode(['kegiatan/baksos1.jpg']),
                'dokumen_pendukung' => json_encode(['dokumen/laporan-baksos.pdf']),
                'keterangan_tambahan' => 'Bakti sosial di panti asuhan',
                'status_approval' => 'pending',
                'approved_at' => null,
                'approved_by' => null,
                'created_at' => Carbon::now()->subDays(3),
                'updated_at' => Carbon::now()->subDays(3),
            ],
            [
                'nama_program_kegiatan' => 'Seminar Pendidikan',
                'jenis_kegiatan' => 'Seminar',
                'volume' => '1 sesi',
                'jumlah_harga_satuan' => 1200000,
                'jumlah_harga' => 1200000,
                'foto_jurnal' => json_encode(['kegiatan/seminar1.jpg', 'kegiatan/seminar2.jpg', 'kegiatan/seminar3.jpg']),
                'dokumen_pendukung' => json_encode(['dokumen/materi-seminar.pdf', 'dokumen/daftar-hadir.pdf']),
                'keterangan_tambahan' => 'Seminar tentang pentingnya pendidikan karakter',
                'status_approval' => 'rejected',
                'approved_at' => null,
                'approved_by' => null,
                'catatan_approval' => 'Anggaran terlalu besar untuk jenis kegiatan ini',
                'created_at' => Carbon::now()->subDays(7),
                'updated_at' => Carbon::now()->subDays(2),
            ]
        ];

        foreach ($kegiatanData as $data) {
            KegiatanLainnya::create($data);
        }
    }
}