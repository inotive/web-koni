<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CabangOlahraga;

class CabangOlahragaSeeder extends Seeder
{
 public function run()
    {
        $cabangOlahraga = [
            ['nama_cabor' => 'Sepak Bola', 'ketua_penanggung_jawab' => 'Ahmad Sulaiman', 'status' => 'Aktif', 'tanggal_pembentukan' => '2020-01-15'],
            ['nama_cabor' => 'Bulu Tangkis', 'ketua_penanggung_jawab' => 'Siti Nurhaliza', 'status' => 'Aktif', 'tanggal_pembentukan' => '2019-03-22'],
            ['nama_cabor' => 'Basket', 'ketua_penanggung_jawab' => 'Budi Santoso', 'status' => 'Aktif', 'tanggal_pembentukan' => '2018-05-10'],
            ['nama_cabor' => 'Voli', 'ketua_penanggung_jawab' => 'Maria Gonzalez', 'status' => 'Aktif', 'tanggal_pembentukan' => '2020-07-08'],
            ['nama_cabor' => 'Renang', 'ketua_penanggung_jawab' => 'Dewi Sartika', 'status' => 'Aktif', 'tanggal_pembentukan' => '2019-09-14'],
            ['nama_cabor' => 'Atletik', 'ketua_penanggung_jawab' => 'Hendra Wijaya', 'status' => 'Aktif', 'tanggal_pembentukan' => '2018-11-30'],
            ['nama_cabor' => 'Tenis Meja', 'ketua_penanggung_jawab' => 'Lisa Permata', 'status' => 'Aktif', 'tanggal_pembentukan' => '2021-02-17'],
            ['nama_cabor' => 'Karate', 'ketua_penanggung_jawab' => 'Roni Pratama', 'status' => 'Aktif', 'tanggal_pembentukan' => '2020-04-25'],
            ['nama_cabor' => 'Taekwondo', 'ketua_penanggung_jawab' => 'Sari Indah', 'status' => 'Aktif', 'tanggal_pembentukan' => '2019-06-12'],
            ['nama_cabor' => 'Judo', 'ketua_penanggung_jawab' => 'Andi Setiawan', 'status' => 'Aktif', 'tanggal_pembentukan' => '2021-08-03'],
            ['nama_cabor' => 'Angkat Besi', 'ketua_penanggung_jawab' => 'Fatimah Zahra', 'status' => 'Aktif', 'tanggal_pembentukan' => '2018-10-21'],
            ['nama_cabor' => 'Tinju', 'ketua_penanggung_jawab' => 'Muhammad Ali', 'status' => 'Aktif', 'tanggal_pembentukan' => '2020-12-05'],
            ['nama_cabor' => 'Panahan', 'ketua_penanggung_jawab' => 'Nina Kartika', 'status' => 'Aktif', 'tanggal_pembentukan' => '2019-01-28'],
            ['nama_cabor' => 'Senam', 'ketua_penanggung_jawab' => 'Dian Sastro', 'status' => 'Aktif', 'tanggal_pembentukan' => '2021-03-16'],
            ['nama_cabor' => 'Sepak Takraw', 'ketua_penanggung_jawab' => 'Bambang Surya', 'status' => 'Aktif', 'tanggal_pembentukan' => '2018-05-09'],
            ['nama_cabor' => 'Futsal', 'ketua_penanggung_jawab' => 'Rina Melati', 'status' => 'Aktif', 'tanggal_pembentukan' => '2020-07-23'],
            ['nama_cabor' => 'Tenis Lapangan', 'ketua_penanggung_jawab' => 'Arif Rahman', 'status' => 'Aktif', 'tanggal_pembentukan' => '2019-09-11'],
            ['nama_cabor' => 'Golf', 'ketua_penanggung_jawab' => 'Sinta Dewi', 'status' => 'Tidak Aktif', 'tanggal_pembentukan' => '2021-11-07'],
            ['nama_cabor' => 'Pencak Silat', 'ketua_penanggung_jawab' => 'Joko Widodo', 'status' => 'Aktif', 'tanggal_pembentukan' => '2018-01-19'],
            ['nama_cabor' => 'Wushu', 'ketua_penanggung_jawab' => 'Lina Susanti', 'status' => 'Aktif', 'tanggal_pembentukan' => '2020-03-26'],
            ['nama_cabor' => 'Catur', 'ketua_penanggung_jawab' => 'Rahmad Hidayat', 'status' => 'Aktif', 'tanggal_pembentukan' => '2019-05-14'],
            ['nama_cabor' => 'Bridge', 'ketua_penanggung_jawab' => 'Indira Sari', 'status' => 'Tidak Aktif', 'tanggal_pembentukan' => '2021-07-31'],
            ['nama_cabor' => 'Biliar', 'ketua_penanggung_jawab' => 'Haris Gunawan', 'status' => 'Aktif', 'tanggal_pembentukan' => '2018-09-18'],
            ['nama_cabor' => 'Bowling', 'ketua_penanggung_jawab' => 'Maya Sari', 'status' => 'Aktif', 'tanggal_pembentukan' => '2020-11-24'],
            ['nama_cabor' => 'Esports', 'ketua_penanggung_jawab' => 'Rizki Pratama', 'status' => 'Aktif', 'tanggal_pembentukan' => '2021-01-12'],
            ['nama_cabor' => 'Panjat Tebing', 'ketua_penanggung_jawab' => 'Siska Amelia', 'status' => 'Aktif', 'tanggal_pembentukan' => '2019-04-08'],
            ['nama_cabor' => 'Dayung', 'ketua_penanggung_jawab' => 'Teguh Santoso', 'status' => 'Aktif', 'tanggal_pembentukan' => '2018-06-27'],
        ];

        foreach ($cabangOlahraga as $cabor) {
            CabangOlahraga::create([
                'nama_cabor' => $cabor['nama_cabor'],
                'ketua_penanggung_jawab' => $cabor['ketua_penanggung_jawab'],
                'status' => $cabor['status'],
                'tanggal_pembentukan' => $cabor['tanggal_pembentukan'],
                'terakhir_update' => now(),
            ]);
}
}
}
