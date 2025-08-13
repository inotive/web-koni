<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Surat;
use Carbon\Carbon;

class SuratSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suratData = [
            // Surat Masuk (15 data)
            [
                'nama_kegiatan' => 'Rapat Koordinasi Pembangunan Infrastruktur',
                'no_surat' => 'SK/001/I/2025',
                'jenis_surat' => 'masuk',
                'dokumen_surat' => null,
                'created_at' => Carbon::now()->subDays(25),
                'updated_at' => Carbon::now()->subDays(25),
            ],
            [
                'nama_kegiatan' => 'Undangan Seminar Nasional Teknologi',
                'no_surat' => 'UD/002/I/2025',
                'jenis_surat' => 'masuk',
                'dokumen_surat' => 'undangan_seminar.pdf',
                'created_at' => Carbon::now()->subDays(23),
                'updated_at' => Carbon::now()->subDays(23),
            ],
            [
                'nama_kegiatan' => 'Permohonan Izin Kegiatan Bakti Sosial',
                'no_surat' => 'PZ/003/I/2025',
                'jenis_surat' => 'masuk',
                'dokumen_surat' => null,
                'created_at' => Carbon::now()->subDays(22),
                'updated_at' => Carbon::now()->subDays(22),
            ],
            [
                'nama_kegiatan' => 'Pemberitahuan Audit Internal Tahunan',
                'no_surat' => 'AU/004/I/2025',
                'jenis_surat' => 'masuk',
                'dokumen_surat' => 'audit_internal.pdf',
                'created_at' => Carbon::now()->subDays(20),
                'updated_at' => Carbon::now()->subDays(20),
            ],
            [
                'nama_kegiatan' => 'Usulan Kerjasama Penelitian',
                'no_surat' => 'KS/005/I/2025',
                'jenis_surat' => 'masuk',
                'dokumen_surat' => null,
                'created_at' => Carbon::now()->subDays(18),
                'updated_at' => Carbon::now()->subDays(18),
            ],
            [
                'nama_kegiatan' => 'Undangan Workshop Digital Marketing',
                'no_surat' => 'WS/006/I/2025',
                'jenis_surat' => 'masuk',
                'dokumen_surat' => 'workshop_digital.pdf',
                'created_at' => Carbon::now()->subDays(17),
                'updated_at' => Carbon::now()->subDays(17),
            ],
            [
                'nama_kegiatan' => 'Laporan Evaluasi Kinerja Q4 2024',
                'no_surat' => 'EV/007/I/2025',
                'jenis_surat' => 'masuk',
                'dokumen_surat' => null,
                'created_at' => Carbon::now()->subDays(15),
                'updated_at' => Carbon::now()->subDays(15),
            ],
            [
                'nama_kegiatan' => 'Permohonan Data Statistik Penduduk',
                'no_surat' => 'ST/008/I/2025',
                'jenis_surat' => 'masuk',
                'dokumen_surat' => 'permohonan_data.pdf',
                'created_at' => Carbon::now()->subDays(14),
                'updated_at' => Carbon::now()->subDays(14),
            ],
            [
                'nama_kegiatan' => 'Undangan Rapat Pleno Dewan',
                'no_surat' => 'RP/009/I/2025',
                'jenis_surat' => 'masuk',
                'dokumen_surat' => null,
                'created_at' => Carbon::now()->subDays(12),
                'updated_at' => Carbon::now()->subDays(12),
            ],
            [
                'nama_kegiatan' => 'Pemberitahuan Pelatihan Kepemimpinan',
                'no_surat' => 'PL/010/I/2025',
                'jenis_surat' => 'masuk',
                'dokumen_surat' => 'pelatihan_kepemimpinan.pdf',
                'created_at' => Carbon::now()->subDays(11),
                'updated_at' => Carbon::now()->subDays(11),
            ],
            [
                'nama_kegiatan' => 'Pengajuan Bantuan Dana Kegiatan',
                'no_surat' => 'BD/011/I/2025',
                'jenis_surat' => 'masuk',
                'dokumen_surat' => null,
                'created_at' => Carbon::now()->subDays(10),
                'updated_at' => Carbon::now()->subDays(10),
            ],
            [
                'nama_kegiatan' => 'Undangan Expo Produk UMKM',
                'no_surat' => 'EX/012/I/2025',
                'jenis_surat' => 'masuk',
                'dokumen_surat' => 'expo_umkm.pdf',
                'created_at' => Carbon::now()->subDays(8),
                'updated_at' => Carbon::now()->subDays(8),
            ],
            [
                'nama_kegiatan' => 'Permohonan Rekomendasi Proyek',
                'no_surat' => 'RK/013/I/2025',
                'jenis_surat' => 'masuk',
                'dokumen_surat' => null,
                'created_at' => Carbon::now()->subDays(7),
                'updated_at' => Carbon::now()->subDays(7),
            ],
            [
                'nama_kegiatan' => 'Laporan Monitoring Lingkungan',
                'no_surat' => 'ML/014/I/2025',
                'jenis_surat' => 'masuk',
                'dokumen_surat' => 'monitoring_lingkungan.pdf',
                'created_at' => Carbon::now()->subDays(5),
                'updated_at' => Carbon::now()->subDays(5),
            ],
            [
                'nama_kegiatan' => 'Undangan Sosialisasi Peraturan Baru',
                'no_surat' => 'SO/015/I/2025',
                'jenis_surat' => 'masuk',
                'dokumen_surat' => null,
                'created_at' => Carbon::now()->subDays(3),
                'updated_at' => Carbon::now()->subDays(3),
            ],

            // Surat Keluar (12 data)
            [
                'nama_kegiatan' => 'Surat Tugas Delegasi Konferensi',
                'no_surat' => 'ST/016/I/2025',
                'jenis_surat' => 'keluar',
                'dokumen_surat' => 'surat_tugas_konferensi.pdf',
                'created_at' => Carbon::now()->subDays(24),
                'updated_at' => Carbon::now()->subDays(24),
            ],
            [
                'nama_kegiatan' => 'Pemberitahuan Perubahan Jadwal Meeting',
                'no_surat' => 'PJ/017/I/2025',
                'jenis_surat' => 'keluar',
                'dokumen_surat' => null,
                'created_at' => Carbon::now()->subDays(21),
                'updated_at' => Carbon::now()->subDays(21),
            ],
            [
                'nama_kegiatan' => 'Surat Keterangan Aktif Bekerja',
                'no_surat' => 'SK/018/I/2025',
                'jenis_surat' => 'keluar',
                'dokumen_surat' => 'keterangan_aktif.pdf',
                'created_at' => Carbon::now()->subDays(19),
                'updated_at' => Carbon::now()->subDays(19),
            ],
            [
                'nama_kegiatan' => 'Undangan Rapat Evaluasi Tahunan',
                'no_surat' => 'UD/019/I/2025',
                'jenis_surat' => 'keluar',
                'dokumen_surat' => null,
                'created_at' => Carbon::now()->subDays(16),
                'updated_at' => Carbon::now()->subDays(16),
            ],
            [
                'nama_kegiatan' => 'Surat Rekomendasi Proposal Penelitian',
                'no_surat' => 'RK/020/I/2025',
                'jenis_surat' => 'keluar',
                'dokumen_surat' => 'rekomendasi_penelitian.pdf',
                'created_at' => Carbon::now()->subDays(13),
                'updated_at' => Carbon::now()->subDays(13),
            ],
            [
                'nama_kegiatan' => 'Pemberitahuan Libur Nasional',
                'no_surat' => 'LN/021/I/2025',
                'jenis_surat' => 'keluar',
                'dokumen_surat' => null,
                'created_at' => Carbon::now()->subDays(9),
                'updated_at' => Carbon::now()->subDays(9),
            ],
            [
                'nama_kegiatan' => 'Surat Pengantar Kunjungan Kerja',
                'no_surat' => 'SP/022/I/2025',
                'jenis_surat' => 'keluar',
                'dokumen_surat' => 'pengantar_kunjungan.pdf',
                'created_at' => Carbon::now()->subDays(6),
                'updated_at' => Carbon::now()->subDays(6),
            ],
            [
                'nama_kegiatan' => 'Undangan Pelatihan Internal',
                'no_surat' => 'PI/023/I/2025',
                'jenis_surat' => 'keluar',
                'dokumen_surat' => null,
                'created_at' => Carbon::now()->subDays(4),
                'updated_at' => Carbon::now()->subDays(4),
            ],
            [
                'nama_kegiatan' => 'Surat Permohonan Kerjasama',
                'no_surat' => 'KJ/024/I/2025',
                'jenis_surat' => 'keluar',
                'dokumen_surat' => 'permohonan_kerjasama.pdf',
                'created_at' => Carbon::now()->subDays(2),
                'updated_at' => Carbon::now()->subDays(2),
            ],
            [
                'nama_kegiatan' => 'Pemberitahuan Update Sistem',
                'no_surat' => 'US/025/I/2025',
                'jenis_surat' => 'keluar',
                'dokumen_surat' => null,
                'created_at' => Carbon::now()->subDay(),
                'updated_at' => Carbon::now()->subDay(),
            ],
            [
                'nama_kegiatan' => 'Surat Pengumuman Hasil Seleksi',
                'no_surat' => 'HS/026/I/2025',
                'jenis_surat' => 'keluar',
                'dokumen_surat' => 'hasil_seleksi.pdf',
                'created_at' => Carbon::now()->subHours(12),
                'updated_at' => Carbon::now()->subHours(12),
            ],
            [
                'nama_kegiatan' => 'Undangan Workshop Teknologi AI',
                'no_surat' => 'AI/027/I/2025',
                'jenis_surat' => 'keluar',
                'dokumen_surat' => null,
                'created_at' => Carbon::now()->subHours(6),
                'updated_at' => Carbon::now()->subHours(6),
            ],
        ];

        foreach ($suratData as $data) {
            Surat::create($data);
        }
    }
}