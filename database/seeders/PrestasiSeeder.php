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

        $prestasis = [  ['nama_prestasi' => 'Juara 1 Kejuaraan Nasional', 'tingkat' => 'Nasional', 'tempat' => 'Jakarta', 'tahun' => 2023, 'medali' => 'Emas'],
            ['nama_prestasi' => 'Juara 2 SEA Games', 'tingkat' => 'Regional', 'tempat' => 'Vietnam', 'tahun' => 2022, 'medali' => 'Perak'],
            ['nama_prestasi' => 'Juara 3 Asian Games', 'tingkat' => 'Regional', 'tempat' => 'China', 'tahun' => 2023, 'medali' => 'Perunggu'],
            ['nama_prestasi' => 'Juara 1 Kejuaraan Provinsi', 'tingkat' => 'Provinsi', 'tempat' => 'Bandung', 'tahun' => 2023, 'medali' => 'Emas'],
            ['nama_prestasi' => 'Juara 2 Piala Walikota', 'tingkat' => 'Kota', 'tempat' => 'Surabaya', 'tahun' => 2022, 'medali' => 'Perak'],
            ['nama_prestasi' => 'Juara 1 Olimpiade Pelajar', 'tingkat' => 'Nasional', 'tempat' => 'Yogyakarta', 'tahun' => 2023, 'medali' => 'Emas'],
            ['nama_prestasi' => 'Juara 3 Kejuaraan Internasional', 'tingkat' => 'Internasional', 'tempat' => 'Malaysia', 'tahun' => 2022, 'medali' => 'Perunggu'],
            ['nama_prestasi' => 'Juara 2 Porda', 'tingkat' => 'Provinsi', 'tempat' => 'Medan', 'tahun' => 2023, 'medali' => 'Perak'],
            ['nama_prestasi' => 'Juara 1 Liga Mahasiswa', 'tingkat' => 'Nasional', 'tempat' => 'Makassar', 'tahun' => 2022, 'medali' => 'Emas'],
            ['nama_prestasi' => 'Juara 3 World Championship', 'tingkat' => 'Internasional', 'tempat' => 'Thailand', 'tahun' => 2023, 'medali' => 'Perunggu'],
            ['nama_prestasi' => 'Juara 1 Kejuaraan Daerah', 'tingkat' => 'Kota', 'tempat' => 'Palembang', 'tahun' => 2022, 'medali' => 'Emas'],
            ['nama_prestasi' => 'Juara 2 Turnamen Nasional', 'tingkat' => 'Nasional', 'tempat' => 'Semarang', 'tahun' => 2023, 'medali' => 'Perak'],
            ['nama_prestasi' => 'Juara 1 Open Tournament', 'tingkat' => 'Internasional', 'tempat' => 'Singapura', 'tahun' => 2022, 'medali' => 'Emas'],
            ['nama_prestasi' => 'Juara 3 Kejuaraan Asia', 'tingkat' => 'Regional', 'tempat' => 'Jepang', 'tahun' => 2023, 'medali' => 'Perunggu'],
            ['nama_prestasi' => 'Juara 2 Grand Prix', 'tingkat' => 'Internasional', 'tempat' => 'Korea Selatan', 'tahun' => 2022, 'medali' => 'Perak'],
            ['nama_prestasi' => 'Juara 1 Piala Gubernur', 'tingkat' => 'Provinsi', 'tempat' => 'Denpasar', 'tahun' => 2023, 'medali' => 'Emas'],
            ['nama_prestasi' => 'Juara 3 Invitational Tournament', 'tingkat' => 'Internasional', 'tempat' => 'Australia', 'tahun' => 2022, 'medali' => 'Perunggu'],
            ['nama_prestasi' => 'Juara 1 Liga Regional', 'tingkat' => 'Regional', 'tempat' => 'Padang', 'tahun' => 2023, 'medali' => 'Emas'],
            ['nama_prestasi' => 'Juara 2 Championship Series', 'tingkat' => 'Nasional', 'tempat' => 'Solo', 'tahun' => 2022, 'medali' => 'Perak'],
            ['nama_prestasi' => 'Juara 1 Junior Championship', 'tingkat' => 'Nasional', 'tempat' => 'Malang', 'tahun' => 2023, 'medali' => 'Emas'],
            ['nama_prestasi' => 'Juara 3 International Cup', 'tingkat' => 'Internasional', 'tempat' => 'Filipina', 'tahun' => 2022, 'medali' => 'Perunggu'],
            ['nama_prestasi' => 'Juara 2 Masters Tournament', 'tingkat' => 'Regional', 'tempat' => 'Balikpapan', 'tahun' => 2023, 'medali' => 'Perak'],
            ['nama_prestasi' => 'Juara 1 Youth Games', 'tingkat' => 'Nasional', 'tempat' => 'Banjarmasin', 'tahun' => 2022, 'medali' => 'Emas'],
            ['nama_prestasi' => 'Juara 3 Pro League', 'tingkat' => 'Internasional', 'tempat' => 'India', 'tahun' => 2023, 'medali' => 'Perunggu'],
            ['nama_prestasi' => 'Juara 2 Elite Championship', 'tingkat' => 'Regional', 'tempat' => 'Pontianak', 'tahun' => 2022, 'medali' => 'Perak'],
            ['nama_prestasi' => 'Juara 1 Super Series', 'tingkat' => 'Nasional', 'tempat' => 'Pekanbaru', 'tahun' => 2023, 'medali' => 'Emas'],
            ['nama_prestasi' => 'Juara 2 Continental Cup', 'tingkat' => 'Regional', 'tempat' => 'Jambi', 'tahun' => 2022, 'medali' => 'Perak'],
        ];
         foreach ($prestasis as $index => $prestasiData) {
            if ($index % 2 == 0) {
                $subject = $atlets->random();
                $subjectType = Atlet::class;
            } else {
                $subject = $pelatihs->random();
                $subjectType = Pelatih::class;
            }

            Prestasi::create([
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
