<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Prestasi;
use App\Models\Atlet;
use App\Models\Pelatih;

class PrestasiSeeder extends Seeder
{
    public function run()
    {
        $atlets = Atlet::all();
        $pelatihs = Pelatih::all();

        $prestasis = [
            ['kejuaraan' => 'Kejuaraan Nasional Bulutangkis 2023', 'nama_prestasi' => 'Juara 1 Tunggal Putra', 'tingkat' => 'Nasional', 'tempat' => 'Jakarta', 'tahun' => 2023, 'medali' => 'Emas'],
            ['kejuaraan' => 'SEA Games 2022', 'nama_prestasi' => 'Juara 2 Ganda Campuran', 'tingkat' => 'Regional', 'tempat' => 'Vietnam', 'tahun' => 2022, 'medali' => 'Perak'],
            ['kejuaraan' => 'Asian Games 2023', 'nama_prestasi' => 'Juara 3 Beregu Putri', 'tingkat' => 'Regional', 'tempat' => 'China', 'tahun' => 2023, 'medali' => 'Perunggu'],
            ['kejuaraan' => 'Kejuaraan Provinsi Jawa Barat 2023', 'nama_prestasi' => 'Juara 1 Tunggal Putri', 'tingkat' => 'Provinsi', 'tempat' => 'Bandung', 'tahun' => 2023, 'medali' => 'Emas'],
            ['kejuaraan' => 'Piala Walikota Surabaya 2022', 'nama_prestasi' => 'Juara 2 Ganda Putra', 'tingkat' => 'Kabupaten/Kota', 'tempat' => 'Surabaya', 'tahun' => 2022, 'medali' => 'Perak'],
            ['kejuaraan' => 'Olimpiade Pelajar Nasional 2023', 'nama_prestasi' => 'Juara 1 Kategori SMA', 'tingkat' => 'Nasional', 'tempat' => 'Yogyakarta', 'tahun' => 2023, 'medali' => 'Emas'],
            ['kejuaraan' => 'Malaysia Open 2022', 'nama_prestasi' => 'Juara 3 Tunggal Senior', 'tingkat' => 'Internasional', 'tempat' => 'Malaysia', 'tahun' => 2022, 'medali' => 'Perunggu'],
            ['kejuaraan' => 'PORDA Sumatera Utara 2023', 'nama_prestasi' => 'Juara 2 Beregu Campuran', 'tingkat' => 'Provinsi', 'tempat' => 'Medan', 'tahun' => 2023, 'medali' => 'Perak'],
            ['kejuaraan' => 'Liga Mahasiswa Nasional 2022', 'nama_prestasi' => 'Juara 1 Kategori Umum', 'tingkat' => 'Nasional', 'tempat' => 'Makassar', 'tahun' => 2022, 'medali' => 'Emas'],
            ['kejuaraan' => 'World Championship U-21 2023', 'nama_prestasi' => 'Juara 3 Junior Putra', 'tingkat' => 'Internasional', 'tempat' => 'Thailand', 'tahun' => 2023, 'medali' => 'Perunggu'],
            ['kejuaraan' => 'Kejuaraan Daerah Palembang 2022', 'nama_prestasi' => 'Juara 1 Veteran', 'tingkat' => 'Kabupaten/Kota', 'tempat' => 'Palembang', 'tahun' => 2022, 'medali' => 'Emas'],
            ['kejuaraan' => 'Turnamen Nasional Tenis Meja 2023', 'nama_prestasi' => 'Juara 2 Ganda Putri', 'tingkat' => 'Nasional', 'tempat' => 'Semarang', 'tahun' => 2023, 'medali' => 'Perak'],
            ['kejuaraan' => 'Singapore Open 2022', 'nama_prestasi' => 'Juara 1 Tunggal Putra', 'tingkat' => 'Internasional', 'tempat' => 'Singapura', 'tahun' => 2022, 'medali' => 'Emas'],
            ['kejuaraan' => 'Kejuaraan Asia Renang 2023', 'nama_prestasi' => 'Juara 3 50m Gaya Bebas', 'tingkat' => 'Regional', 'tempat' => 'Jepang', 'tahun' => 2023, 'medali' => 'Perunggu'],
            ['kejuaraan' => 'Grand Prix Korea 2022', 'nama_prestasi' => 'Juara 2 Estafet 4x100m', 'tingkat' => 'Internasional', 'tempat' => 'Korea Selatan', 'tahun' => 2022, 'medali' => 'Perak'],
            ['kejuaraan' => 'Piala Gubernur Bali 2023', 'nama_prestasi' => 'Juara 1 Kategori Yunior', 'tingkat' => 'Provinsi', 'tempat' => 'Denpasar', 'tahun' => 2023, 'medali' => 'Emas'],
            ['kejuaraan' => 'Australia Open Badminton 2022', 'nama_prestasi' => 'Juara 3 Ganda Campuran', 'tingkat' => 'Internasional', 'tempat' => 'Australia', 'tahun' => 2022, 'medali' => 'Perunggu'],
            ['kejuaraan' => 'Liga Regional Sumatera 2023', 'nama_prestasi' => 'Juara 1 Beregu Putra', 'tingkat' => 'Regional', 'tempat' => 'Padang', 'tahun' => 2023, 'medali' => 'Emas'],
            ['kejuaraan' => 'Championship Series Indonesia 2022', 'nama_prestasi' => 'Juara 2 All England', 'tingkat' => 'Nasional', 'tempat' => 'Solo', 'tahun' => 2022, 'medali' => 'Perak'],
            ['kejuaraan' => 'Junior Championship Nasional 2023', 'nama_prestasi' => 'Juara 1 U-18 Putra', 'tingkat' => 'Nasional', 'tempat' => 'Malang', 'tahun' => 2023, 'medali' => 'Emas'],
            ['kejuaraan' => 'International Cup Philippines 2022', 'nama_prestasi' => 'Juara 3 Open Category', 'tingkat' => 'Internasional', 'tempat' => 'Filipina', 'tahun' => 2022, 'medali' => 'Perunggu'],
            ['kejuaraan' => 'Masters Tournament Kalimantan 2023', 'nama_prestasi' => 'Juara 2 Senior Putri', 'tingkat' => 'Regional', 'tempat' => 'Balikpapan', 'tahun' => 2023, 'medali' => 'Perak'],
            ['kejuaraan' => 'Youth Games Indonesia 2022', 'nama_prestasi' => 'Juara 1 Kategori Pelajar', 'tingkat' => 'Nasional', 'tempat' => 'Banjarmasin', 'tahun' => 2022, 'medali' => 'Emas'],
            ['kejuaraan' => 'Pro League India 2023', 'nama_prestasi' => 'Juara 3 International Pro', 'tingkat' => 'Internasional', 'tempat' => 'India', 'tahun' => 2023, 'medali' => 'Perunggu'],
            ['kejuaraan' => 'Elite Championship Borneo 2022', 'nama_prestasi' => 'Juara 2 Elite Masters', 'tingkat' => 'Regional', 'tempat' => 'Pontianak', 'tahun' => 2022, 'medali' => 'Perak'],
            ['kejuaraan' => 'Super Series Riau 2023', 'nama_prestasi' => 'Juara 1 Super League', 'tingkat' => 'Nasional', 'tempat' => 'Pekanbaru', 'tahun' => 2023, 'medali' => 'Emas'],
            ['kejuaraan' => 'Continental Cup ASEAN 2022', 'nama_prestasi' => 'Juara 2 Continental', 'tingkat' => 'Regional', 'tempat' => 'Jambi', 'tahun' => 2022, 'medali' => 'Perak'],
        ];

        foreach ($prestasis as $index => $prestasiData) {
            if ($index % 2 == 0) {
                // Untuk atlet, coba ambil yang berbeda jenis kelamin
                $atletLaki = $atlets->where('jenis_kelamin', 'L')->first();
                $atletPerempuan = $atlets->where('jenis_kelamin', 'P')->first();

                if ($index % 4 == 0 && $atletLaki) {
                    $subject = $atletLaki;
                } elseif ($atletPerempuan) {
                    $subject = $atletPerempuan;
                } else {
                    $subject = $atlets->random();
                }
                $subjectType = Atlet::class;
            } else {
                // Untuk pelatih, coba ambil yang berbeda jenis kelamin
                $pelatihLaki = $pelatihs->where('kelamin', 'L')->first();
                $pelatihPerempuan = $pelatihs->where('kelamin', 'P')->first();

                if ($index % 4 == 1 && $pelatihLaki) {
                    $subject = $pelatihLaki;
                } elseif ($pelatihPerempuan) {
                    $subject = $pelatihPerempuan;
                } else {
                    $subject = $pelatihs->random();
                }
                $subjectType = Pelatih::class;
            }

            Prestasi::create([
                'kejuaraan' => $prestasiData['kejuaraan'],
                'nama_prestasi' => $prestasiData['nama_prestasi'],
                'tingkat' => $prestasiData['tingkat'],
                'tempat' => $prestasiData['tempat'],
                'tahun' => $prestasiData['tahun'],
                'medali' => $prestasiData['medali'],
                'subject_id' => $subject->id,
                'subject_type' => $subjectType,
            ]);
        }
    }
}
