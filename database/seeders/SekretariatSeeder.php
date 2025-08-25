<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Lpj;

class SekretariatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat parent category untuk Sekretariat terlebih dahulu
        $parentCategory = Lpj::firstOrCreate(
            ['parent_id' => null, 'nama_program' => 'Sekretariat'],
            [
                'nama_kegiatan' => 'Kategori Sekretariat',
                'volume' => '',
                'jumlah_harga_satuan' => 0,
                'jumlah_harga' => 0,
                'icon' => 'fas fa-building'
            ]
        );

        $data = [
            [
                'nama_program_kegiatan' => 'Pengadaan Alat Tulis Kantor',
                'jenis_kegiatan' => 'Pengadaan Barang',
                'keterangan_tambahan' => 'ATK untuk kebutuhan operasional kantor sekretariat',
                'volume' => '50 set',
                'jumlah_harga_satuan' => 25000.00,
                'jumlah_harga' => 1250000.00,
                'foto_jurnal' => ['atk_jurnal_1.jpg', 'atk_jurnal_2.jpg'],
                'dokumen_pendukung' => ['invoice_atk.pdf', 'berita_acara_penerimaan.pdf']
            ],
            [
                'nama_program_kegiatan' => 'Rapat Koordinasi Bulanan',
                'jenis_kegiatan' => 'Rapat/Pertemuan',
                'keterangan_tambahan' => 'Rapat koordinasi rutin bulanan dengan seluruh staff',
                'volume' => '1 kali',
                'jumlah_harga_satuan' => 2500000.00,
                'jumlah_harga' => 2500000.00,
                'foto_jurnal' => ['rapat_koordinasi_1.jpg', 'rapat_koordinasi_2.jpg'],
                'dokumen_pendukung' => ['notulen_rapat.pdf', 'daftar_hadir.pdf']
            ],
            [
                'nama_program_kegiatan' => 'Pelatihan Administrasi Perkantoran',
                'jenis_kegiatan' => 'Pelatihan/Bimbingan Teknis',
                'keterangan_tambahan' => 'Pelatihan untuk meningkatkan kemampuan administrasi staff',
                'volume' => '25 orang',
                'jumlah_harga_satuan' => 150000.00,
                'jumlah_harga' => 3750000.00,
                'foto_jurnal' => ['pelatihan_admin_1.jpg', 'pelatihan_admin_2.jpg'],
                'dokumen_pendukung' => ['sertifikat_pelatihan.pdf', 'materi_pelatihan.pdf']
            ],
            [
                'nama_program_kegiatan' => 'Pemeliharaan Komputer dan Printer',
                'jenis_kegiatan' => 'Pemeliharaan/Maintenance',
                'keterangan_tambahan' => 'Service rutin komputer dan printer kantor',
                'volume' => '15 unit',
                'jumlah_harga_satuan' => 200000.00,
                'jumlah_harga' => 3000000.00,
                'foto_jurnal' => ['maintenance_komputer_1.jpg'],
                'dokumen_pendukung' => ['laporan_maintenance.pdf', 'invoice_service.pdf']
            ],
            [
                'nama_program_kegiatan' => 'Pengadaan Seragam Kerja',
                'jenis_kegiatan' => 'Pengadaan Barang',
                'keterangan_tambahan' => 'Seragam kerja untuk seluruh pegawai sekretariat',
                'volume' => '30 set',
                'jumlah_harga_satuan' => 275000.00,
                'jumlah_harga' => 8250000.00,
                'foto_jurnal' => ['seragam_kerja_1.jpg', 'seragam_kerja_2.jpg'],
                'dokumen_pendukung' => ['kontrak_seragam.pdf', 'berita_acara_serah_terima.pdf']
            ],
            [
                'nama_program_kegiatan' => 'Sosialisasi Peraturan Baru',
                'jenis_kegiatan' => 'Sosialisasi',
                'keterangan_tambahan' => 'Sosialisasi peraturan terbaru kepada seluruh pegawai',
                'volume' => '75 orang',
                'jumlah_harga_satuan' => 45000.00,
                'jumlah_harga' => 3375000.00,
                'foto_jurnal' => ['sosialisasi_1.jpg', 'sosialisasi_2.jpg', 'sosialisasi_3.jpg'],
                'dokumen_pendukung' => ['materi_sosialisasi.pdf', 'daftar_peserta.pdf']
            ],
            [
                'nama_program_kegiatan' => 'Pembelian Meja dan Kursi Kantor',
                'jenis_kegiatan' => 'Pengadaan Barang',
                'keterangan_tambahan' => 'Penambahan furniture untuk ruang kerja baru',
                'volume' => '10 set',
                'jumlah_harga_satuan' => 1250000.00,
                'jumlah_harga' => 12500000.00,
                'foto_jurnal' => ['furniture_1.jpg', 'furniture_2.jpg'],
                'dokumen_pendukung' => ['invoice_furniture.pdf', 'garansi_furniture.pdf']
            ],
            [
                'nama_program_kegiatan' => 'Workshop Manajemen Arsip',
                'jenis_kegiatan' => 'Workshop',
                'keterangan_tambahan' => 'Workshop pengelolaan arsip digital dan manual',
                'volume' => '20 orang',
                'jumlah_harga_satuan' => 180000.00,
                'jumlah_harga' => 3600000.00,
                'foto_jurnal' => ['workshop_arsip_1.jpg'],
                'dokumen_pendukung' => ['sertifikat_workshop.pdf', 'handbook_arsip.pdf']
            ],
            [
                'nama_program_kegiatan' => 'Pengadaan AC untuk Ruang Meeting',
                'jenis_kegiatan' => 'Pengadaan Barang',
                'keterangan_tambahan' => 'Instalasi AC 2 PK untuk ruang meeting utama',
                'volume' => '2 unit',
                'jumlah_harga_satuan' => 4500000.00,
                'jumlah_harga' => 9000000.00,
                'foto_jurnal' => ['instalasi_ac_1.jpg', 'instalasi_ac_2.jpg'],
                'dokumen_pendukung' => ['kontrak_ac.pdf', 'garansi_ac.pdf', 'sertifikat_instalasi.pdf']
            ],
            [
                'nama_program_kegiatan' => 'Seminar Pelayanan Prima',
                'jenis_kegiatan' => 'Seminar',
                'keterangan_tambahan' => 'Seminar peningkatan kualitas pelayanan publik',
                'volume' => '50 orang',
                'jumlah_harga_satuan' => 125000.00,
                'jumlah_harga' => 6250000.00,
                'foto_jurnal' => ['seminar_pelayanan_1.jpg', 'seminar_pelayanan_2.jpg'],
                'dokumen_pendukung' => ['materi_seminar.pdf', 'evaluasi_seminar.pdf']
            ],
            [
                'nama_program_kegiatan' => 'Pengadaan Kendaraan Operasional',
                'jenis_kegiatan' => 'Pengadaan Barang',
                'keterangan_tambahan' => 'Motor untuk keperluan operasional kantor',
                'volume' => '1 unit',
                'jumlah_harga_satuan' => 18500000.00,
                'jumlah_harga' => 18500000.00,
                'foto_jurnal' => ['motor_operasional_1.jpg', 'motor_operasional_2.jpg'],
                'dokumen_pendukung' => ['stnk.pdf', 'bpkb.pdf', 'asuransi.pdf']
            ],
            [
                'nama_program_kegiatan' => 'Renovasi Ruang Arsip',
                'jenis_kegiatan' => 'Renovasi/Konstruksi',
                'keterangan_tambahan' => 'Renovasi dan penataan ulang ruang penyimpanan arsip',
                'volume' => '1 paket',
                'jumlah_harga_satuan' => 15000000.00,
                'jumlah_harga' => 15000000.00,
                'foto_jurnal' => ['renovasi_arsip_1.jpg', 'renovasi_arsip_2.jpg', 'renovasi_arsip_3.jpg'],
                'dokumen_pendukung' => ['kontrak_renovasi.pdf', 'gambar_kerja.pdf', 'berita_acara_selesai.pdf']
            ],
            [
                'nama_program_kegiatan' => 'Pelatihan Microsoft Office Advanced',
                'jenis_kegiatan' => 'Pelatihan/Bimbingan Teknis',
                'keterangan_tambahan' => 'Pelatihan Excel, Word, dan PowerPoint tingkat lanjut',
                'volume' => '18 orang',
                'jumlah_harga_satuan' => 225000.00,
                'jumlah_harga' => 4050000.00,
                'foto_jurnal' => ['pelatihan_office_1.jpg', 'pelatihan_office_2.jpg'],
                'dokumen_pendukung' => ['sertifikat_office.pdf', 'modul_pelatihan.pdf']
            ],
            [
                'nama_program_kegiatan' => 'Pengadaan Server untuk Database',
                'jenis_kegiatan' => 'Pengadaan Barang',
                'keterangan_tambahan' => 'Server untuk menyimpan database aplikasi internal',
                'volume' => '1 unit',
                'jumlah_harga_satuan' => 25000000.00,
                'jumlah_harga' => 25000000.00,
                'foto_jurnal' => ['server_database_1.jpg'],
                'dokumen_pendukung' => ['spesifikasi_server.pdf', 'garansi_server.pdf', 'manual_instalasi.pdf']
            ],
            [
                'nama_program_kegiatan' => 'Rapat Evaluasi Kinerja Tahunan',
                'jenis_kegiatan' => 'Rapat/Pertemuan',
                'keterangan_tambahan' => 'Evaluasi kinerja pegawai dan program kerja tahunan',
                'volume' => '1 kali',
                'jumlah_harga_satuan' => 3750000.00,
                'jumlah_harga' => 3750000.00,
                'foto_jurnal' => ['rapat_evaluasi_1.jpg', 'rapat_evaluasi_2.jpg'],
                'dokumen_pendukung' => ['laporan_evaluasi.pdf', 'rekomendasi_perbaikan.pdf']
            ],
            [
                'nama_program_kegiatan' => 'Pengadaan CCTV untuk Keamanan',
                'jenis_kegiatan' => 'Pengadaan Barang',
                'keterangan_tambahan' => 'Sistem CCTV 8 kamera untuk monitoring keamanan',
                'volume' => '8 unit',
                'jumlah_harga_satuan' => 1750000.00,
                'jumlah_harga' => 14000000.00,
                'foto_jurnal' => ['cctv_instalasi_1.jpg', 'cctv_instalasi_2.jpg'],
                'dokumen_pendukung' => ['kontrak_cctv.pdf', 'diagram_instalasi.pdf', 'manual_operasi.pdf']
            ],
            [
                'nama_program_kegiatan' => 'Kegiatan Team Building',
                'jenis_kegiatan' => 'Kegiatan Sosial',
                'keterangan_tambahan' => 'Kegiatan untuk membangun kerjasama tim pegawai',
                'volume' => '35 orang',
                'jumlah_harga_satuan' => 185000.00,
                'jumlah_harga' => 6475000.00,
                'foto_jurnal' => ['team_building_1.jpg', 'team_building_2.jpg', 'team_building_3.jpg'],
                'dokumen_pendukung' => ['rundown_kegiatan.pdf', 'feedback_peserta.pdf']
            ],
            [
                'nama_program_kegiatan' => 'Pemeliharaan Jaringan Internet',
                'jenis_kegiatan' => 'Pemeliharaan/Maintenance',
                'keterangan_tambahan' => 'Maintenance rutin jaringan dan upgrade bandwidth',
                'volume' => '12 bulan',
                'jumlah_harga_satuan' => 850000.00,
                'jumlah_harga' => 10200000.00,
                'foto_jurnal' => ['maintenance_jaringan_1.jpg'],
                'dokumen_pendukung' => ['laporan_maintenance_jaringan.pdf', 'upgrade_bandwidth.pdf']
            ],
            [
                'nama_program_kegiatan' => 'Pengadaan Sistem Antrian Digital',
                'jenis_kegiatan' => 'Pengadaan Barang',
                'keterangan_tambahan' => 'Sistem antrian elektronik untuk pelayanan publik',
                'volume' => '1 paket',
                'jumlah_harga_satuan' => 12000000.00,
                'jumlah_harga' => 12000000.00,
                'foto_jurnal' => ['antrian_digital_1.jpg', 'antrian_digital_2.jpg'],
                'dokumen_pendukung' => ['spesifikasi_antrian.pdf', 'manual_sistem.pdf', 'training_operator.pdf']
            ],
            [
                'nama_program_kegiatan' => 'Workshop Komunikasi Efektif',
                'jenis_kegiatan' => 'Workshop',
                'keterangan_tambahan' => 'Pelatihan komunikasi untuk meningkatkan pelayanan',
                'volume' => '28 orang',
                'jumlah_harga_satuan' => 160000.00,
                'jumlah_harga' => 4480000.00,
                'foto_jurnal' => ['workshop_komunikasi_1.jpg'],
                'dokumen_pendukung' => ['materi_komunikasi.pdf', 'sertifikat_komunikasi.pdf']
            ],
            [
                'nama_program_kegiatan' => 'Pengadaan Lemari Arsip Besi',
                'jenis_kegiatan' => 'Pengadaan Barang',
                'keterangan_tambahan' => 'Lemari arsip tahan api untuk dokumen penting',
                'volume' => '6 unit',
                'jumlah_harga_satuan' => 2250000.00,
                'jumlah_harga' => 13500000.00,
                'foto_jurnal' => ['lemari_arsip_1.jpg', 'lemari_arsip_2.jpg'],
                'dokumen_pendukung' => ['sertifikat_tahan_api.pdf', 'garansi_lemari.pdf']
            ],
            [
                'nama_program_kegiatan' => 'Seminar Digitalisasi Pelayanan',
                'jenis_kegiatan' => 'Seminar',
                'keterangan_tambahan' => 'Seminar transformasi digital dalam pelayanan publik',
                'volume' => '60 orang',
                'jumlah_harga_satuan' => 110000.00,
                'jumlah_harga' => 6600000.00,
                'foto_jurnal' => ['seminar_digital_1.jpg', 'seminar_digital_2.jpg'],
                'dokumen_pendukung' => ['materi_digitalisasi.pdf', 'roadmap_digital.pdf']
            ],
            [
                'nama_program_kegiatan' => 'Pengadaan Generator Listrik',
                'jenis_kegiatan' => 'Pengadaan Barang',
                'keterangan_tambahan' => 'Generator cadangan 15 KVA untuk antisipasi mati listrik',
                'volume' => '1 unit',
                'jumlah_harga_satuan' => 22000000.00,
                'jumlah_harga' => 22000000.00,
                'foto_jurnal' => ['generator_1.jpg', 'generator_2.jpg'],
                'dokumen_pendukung' => ['spesifikasi_generator.pdf', 'instalasi_generator.pdf', 'pelatihan_operator.pdf']
            ],
            [
                'nama_program_kegiatan' => 'Pelatihan Keselamatan Kerja',
                'jenis_kegiatan' => 'Pelatihan/Bimbingan Teknis',
                'keterangan_tambahan' => 'Pelatihan K3 dan penanganan darurat di tempat kerja',
                'volume' => '40 orang',
                'jumlah_harga_satuan' => 95000.00,
                'jumlah_harga' => 3800000.00,
                'foto_jurnal' => ['pelatihan_k3_1.jpg', 'pelatihan_k3_2.jpg'],
                'dokumen_pendukung' => ['sertifikat_k3.pdf', 'prosedur_darurat.pdf']
            ],
            [
                'nama_program_kegiatan' => 'Pengadaan Sistem Backup Data',
                'jenis_kegiatan' => 'Pengadaan Barang',
                'keterangan_tambahan' => 'Sistem backup otomatis untuk keamanan data',
                'volume' => '1 paket',
                'jumlah_harga_satuan' => 8500000.00,
                'jumlah_harga' => 8500000.00,
                'foto_jurnal' => ['backup_system_1.jpg'],
                'dokumen_pendukung' => ['konfigurasi_backup.pdf', 'schedule_backup.pdf']
            ],
            [
                'nama_program_kegiatan' => 'Rapat Koordinasi dengan Instansi Terkait',
                'jenis_kegiatan' => 'Rapat/Pertemuan',
                'keterangan_tambahan' => 'Koordinasi lintas sektoral untuk sinkronisasi program',
                'volume' => '4 kali',
                'jumlah_harga_satuan' => 1850000.00,
                'jumlah_harga' => 7400000.00,
                'foto_jurnal' => ['rapat_lintas_sektor_1.jpg', 'rapat_lintas_sektor_2.jpg'],
                'dokumen_pendukung' => ['mou_kerjasama.pdf', 'action_plan.pdf']
            ],
            [
                'nama_program_kegiatan' => 'Upgrade Software Aplikasi Internal',
                'jenis_kegiatan' => 'Upgrade/Update Sistem',
                'keterangan_tambahan' => 'Upgrade sistem informasi manajemen internal',
                'volume' => '1 paket',
                'jumlah_harga_satuan' => 15500000.00,
                'jumlah_harga' => 15500000.00,
                'foto_jurnal' => ['upgrade_software_1.jpg'],
                'dokumen_pendukung' => ['dokumentasi_upgrade.pdf', 'testing_report.pdf', 'user_manual_baru.pdf']
            ],
            [
                'nama_program_kegiatan' => 'Program Pembinaan Mental Spiritual',
                'jenis_kegiatan' => 'Kegiatan Sosial',
                'keterangan_tambahan' => 'Kegiatan pembinaan rohani untuk pegawai',
                'volume' => '45 orang',
                'jumlah_harga_satuan' => 75000.00,
                'jumlah_harga' => 3375000.00,
                'foto_jurnal' => ['pembinaan_mental_1.jpg', 'pembinaan_mental_2.jpg'],
                'dokumen_pendukung' => ['materi_pembinaan.pdf', 'jadwal_kegiatan.pdf']
            ]
        ];

        foreach ($data as $item) {
            Lpj::create([
                'parent_id' => $parentCategory->id, // Menggunakan parent_id dari kategori Sekretariat
                'nama_program' => $item['nama_program_kegiatan'], // Map nama_program_kegiatan -> nama_program
                'nama_kegiatan' => $item['jenis_kegiatan'], // Map jenis_kegiatan -> nama_kegiatan
                'volume' => $item['volume'],
                'jumlah_harga_satuan' => $item['jumlah_harga_satuan'],
                'jumlah_harga' => $item['jumlah_harga'],
                'foto_jurnal' => $item['foto_jurnal'],
                'dokumen_lpj' => $item['dokumen_pendukung'], // Map dokumen_pendukung -> dokumen_lpj
                'keterangan_tambahan' => $item['keterangan_tambahan'],
                'icon' => 'fas fa-clipboard-list' // Default icon untuk setiap item
            ]);
        }
    }
}
