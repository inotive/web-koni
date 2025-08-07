<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pelatih;
use App\Models\CabangOlahraga;

class PelatihSeeder extends Seeder
{
    public function run()
    {
        $cabors = CabangOlahraga::all();

        $pelatihs = [
              ['nama' => 'Muhammad Rizki', 'tempat_lahir' => 'Jakarta', 'tanggal_lahir' => '1985-03-15', 'alamat' => 'Jl. Gatot Subroto No. 123', 'kelamin' => 'Laki-laki', 'no_telepon' => '082234567890', 'email' => 'muhammad.rizki@email.com', 'alamatkota' => 'Balikpapan', 'alamatprovinsi'=> 'Kalimantan Timur', 'ketersediaan'=> 'Tersedia'],
            ['nama' => 'Siti Aisyah', 'tempat_lahir' => 'Bandung', 'tanggal_lahir' => '1987-07-22', 'alamat' => 'Jl. Dago No. 45', 'kelamin' => 'Perempuan', 'no_telepon' => '082234567891', 'email' => 'siti.aisyah@email.com', 'alamatkota' => 'Samarinda', 'alamatprovinsi'=> 'Kalimantan Timur', 'ketersediaan'=> 'Tersedia'],
            ['nama' => 'Bambang Sutrisno', 'tempat_lahir' => 'Surabaya', 'tanggal_lahir' => '1984-11-08', 'alamat' => 'Jl. Basuki Rahmat No. 67', 'kelamin' => 'Laki-laki', 'no_telepon' => '082234567892', 'email' => 'bambang.sutrisno@email.com', 'alamatkota' => 'Jakarta', 'alamatprovinsi'=> 'DKI Jakarta', 'ketersediaan'=> 'Tersedia'],
              ['nama' => 'Indira Sari', 'tempat_lahir' => 'Medan', 'tanggal_lahir' => '1986-05-12', 'alamat' => 'Jl. Imam Bonjol No. 89', 'kelamin' => 'Perempuan', 'no_telepon' => '082234567893', 'email' => 'indira.sari@email.com', 'alamatkota' => 'Balikpapan', 'alamatprovinsi'=> 'Kalimantan Timur', 'ketersediaan'=> 'Tersedia'],
            ['nama' => 'Arief Rahman', 'tempat_lahir' => 'Makassar', 'tanggal_lahir' => '1983-09-25', 'alamat' => 'Jl. AP Pettarani No. 12', 'kelamin' => 'Laki-laki', 'no_telepon' => '082234567894', 'email' => 'arief.rahman@email.com', 'alamatkota' => 'Balikpapan', 'alamatprovinsi'=> 'Kalimantan Timur', 'ketersediaan'=> 'Tersedia'],
            ['nama' => 'Dewi Fortuna', 'tempat_lahir' => 'Yogyakarta', 'tanggal_lahir' => '1988-02-18', 'alamat' => 'Jl. Kaliurang No. 34', 'kelamin' => 'Perempuan', 'no_telepon' => '082234567895', 'email' => 'dewi.fortuna@email.com', 'alamatkota' => 'Balikpapan', 'alamatprovinsi'=> 'Kalimantan Timur', 'ketersediaan'=> 'Tersedia'],
            ['nama' => 'Hendra Wijaya', 'tempat_lahir' => 'Palembang', 'tanggal_lahir' => '1985-06-30', 'alamat' => 'Jl. Jendral Sudirman No. 56', 'kelamin' => 'Laki-laki', 'no_telepon' => '082234567896', 'email' => 'hendra.wijaya@email.com', 'alamatkota' => 'Balikpapan', 'alamatprovinsi'=> 'Kalimantan Timur', 'ketersediaan'=> 'Tersedia'],
            ['nama' => 'Lisa Permata', 'tempat_lahir' => 'Semarang', 'tanggal_lahir' => '1987-10-14', 'alamat' => 'Jl. Pemuda No. 78', 'kelamin' => 'Perempuan', 'no_telepon' => '082234567897', 'email' => 'lisa.permata@email.com', 'alamatkota' => 'Balikpapan', 'alamatprovinsi'=> 'Kalimantan Timur', 'ketersediaan'=> 'Tersedia'],
            ['nama' => 'Roni Pratama', 'tempat_lahir' => 'Denpasar', 'tanggal_lahir' => '1984-04-07', 'alamat' => 'Jl. Hayam Wuruk No. 90', 'kelamin' => 'Laki-laki', 'no_telepon' => '082234567898', 'email' => 'roni.pratama@email.com', 'alamatkota' => 'Balikpapan', 'alamatprovinsi'=> 'Kalimantan Timur', 'ketersediaan'=> 'Tidak-Tersedia'],
             ['nama' => 'Fatimah Zahra', 'tempat_lahir' => 'Padang', 'tanggal_lahir' => '1986-08-21', 'alamat' => 'Jl. Prof. Hamka No. 23', 'kelamin' => 'Perempuan', 'no_telepon' => '082234567899', 'email' => 'fatimah.zahra@email.com', 'alamatkota' => 'Balikpapan', 'alamatprovinsi'=> 'Kalimantan Timur', 'ketersediaan'=> 'Tidak-Tersedia'],
            ['nama' => 'Andi Setiawan', 'tempat_lahir' => 'Solo', 'tanggal_lahir' => '1985-12-03', 'alamat' => 'Jl. Dr. Radjiman No. 45', 'kelamin' => 'Laki-laki', 'no_telepon' => '082234567800', 'email' => 'andi.setiawan@email.com', 'alamatkota' => 'Balikpapan', 'alamatprovinsi'=> 'Kalimantan Timur', 'ketersediaan'=> 'Tidak-Tersedia'],
            ['nama' => 'Nina Kartika', 'tempat_lahir' => 'Malang', 'tanggal_lahir' => '1988-01-16', 'alamat' => 'Jl. Veteran No. 67', 'kelamin' => 'Perempuan', 'no_telepon' => '082234567801', 'email' => 'nina.kartika@email.com', 'alamatkota' => 'Balikpapan', 'alamatprovinsi'=> 'Kalimantan Timur', 'ketersediaan'=> 'Tidak-Tersedia'],
            ['nama' => 'Joko Widodo', 'tempat_lahir' => 'Balikpapan', 'tanggal_lahir' => '1983-05-29', 'alamat' => 'Jl. MT Haryono No. 89', 'kelamin' => 'Laki-laki', 'no_telepon' => '082234567802', 'email' => 'joko.widodo@email.com', 'alamatkota' => 'Balikpapan', 'alamatprovinsi'=> 'Kalimantan Timur', 'ketersediaan'=> 'Tidak-Tersedia'],
            ['nama' => 'Dian Sastro', 'tempat_lahir' => 'Banjarmasin', 'tanggal_lahir' => '1987-09-11', 'alamat' => 'Jl. A Yani No. 12', 'kelamin' => 'Perempuan', 'no_telepon' => '082234567803', 'email' => 'dian.sastro@email.com', 'alamatkota' => 'Balikpapan', 'alamatprovinsi'=> 'Kalimantan Timur', 'ketersediaan'=> 'Tersedia'],
            ['nama' => 'Teguh Santoso', 'tempat_lahir' => 'Pontianak', 'tanggal_lahir' => '1986-03-24', 'alamat' => 'Jl. Gajah Mada No. 34', 'kelamin' => 'Laki-laki', 'no_telepon' => '082234567804', 'email' => 'teguh.santoso@email.com', 'alamatkota' => 'Balikpapan', 'alamatprovinsi'=> 'Kalimantan Timur', 'ketersediaan'=> 'Tersedia'],
            ['nama' => 'Lina Susanti', 'tempat_lahir' => 'Pekanbaru', 'tanggal_lahir' => '1985-07-17', 'alamat' => 'Jl. Diponegoro No. 56', 'kelamin' => 'Perempuan', 'no_telepon' => '082234567805', 'email' => 'lina.susanti@email.com', 'alamatkota' => 'Balikpapan', 'alamatprovinsi'=> 'Kalimantan Timur', 'ketersediaan'=> 'Tersedia'],
            ['nama' => 'Rahmad Hidayat', 'tempat_lahir' => 'Jambi', 'tanggal_lahir' => '1984-11-02', 'alamat' => 'Jl. Jendral Sudirman No. 78', 'kelamin' => 'Laki-laki', 'no_telepon' => '082234567806', 'email' => 'rahmad.hidayat@email.com', 'alamatkota' => 'Balikpapan', 'alamatprovinsi'=> 'Kalimantan Timur', 'ketersediaan'=> 'Tersedia'],
            ['nama' => 'Siska Amelia', 'tempat_lahir' => 'Bengkulu', 'tanggal_lahir' => '1988-04-13', 'alamat' => 'Jl. Suprapto No. 90', 'kelamin' => 'Perempuan', 'no_telepon' => '082234567807', 'email' => 'siska.amelia@email.com', 'alamatkota' => 'Balikpapan', 'alamatprovinsi'=> 'Kalimantan Timur', 'ketersediaan'=> 'Tersedia'],
            ['nama' => 'Haris Gunawan', 'tempat_lahir' => 'Lampung', 'tanggal_lahir' => '1983-08-26', 'alamat' => 'Jl. Kartini No. 23', 'kelamin' => 'Laki-laki', 'no_telepon' => '082234567808', 'email' => 'haris.gunawan@email.com', 'alamatkota' => 'Balikpapan', 'alamatprovinsi'=> 'Kalimantan Timur', 'ketersediaan'=> 'Tersedia'],
            ['nama' => 'Maya Sari', 'tempat_lahir' => 'Tangerang', 'tanggal_lahir' => '1987-02-09', 'alamat' => 'Jl. Sudirman No. 45', 'kelamin' => 'Perempuan', 'no_telepon' => '082234567809', 'email' => 'maya.sari.pelatih@email.com', 'alamatkota' => 'Balikpapan', 'alamatprovinsi'=> 'Kalimantan Timur', 'ketersediaan'=> 'Tersedia'],
            ['nama' => 'Rizki Pratama', 'tempat_lahir' => 'Bekasi', 'tanggal_lahir' => '1985-06-22', 'alamat' => 'Jl. Cut Mutiah No. 67', 'kelamin' => 'Laki-laki', 'no_telepon' => '082234567810', 'email' => 'rizki.pratama.pelatih@email.com', 'alamatkota' => 'Balikpapan', 'alamatprovinsi'=> 'Kalimantan Timur', 'ketersediaan'=> 'Tersedia'],
             ['nama' => 'Rina Melati', 'tempat_lahir' => 'Depok', 'tanggal_lahir' => '1986-10-05', 'alamat' => 'Jl. Raya Bogor No. 89', 'kelamin' => 'Perempuan', 'no_telepon' => '082234567811', 'email' => 'rina.melati@email.com', 'alamatkota' => 'Balikpapan', 'alamatprovinsi'=> 'Kalimantan Timur', 'ketersediaan'=> 'Tersedia'],
            ['nama' => 'Bambang Surya', 'tempat_lahir' => 'Bogor', 'tanggal_lahir' => '1984-12-18', 'alamat' => 'Jl. Raya Tajur No. 12', 'kelamin' => 'Laki-laki', 'no_telepon' => '082234567812', 'email' => 'bambang.surya@email.com', 'alamatkota' => 'Balikpapan', 'alamatprovinsi'=> 'Kalimantan Timur', 'ketersediaan'=> 'Tersedia'],
            ['nama' => 'Maria Gonzalez', 'tempat_lahir' => 'Cirebon', 'tanggal_lahir' => '1988-05-31', 'alamat' => 'Jl. Tuparev No. 34', 'kelamin' => 'Perempuan', 'no_telepon' => '082234567813', 'email' => 'maria.gonzalez@email.com', 'alamatkota' => 'Balikpapan', 'alamatprovinsi'=> 'Kalimantan Timur', 'ketersediaan'=> 'Tersedia'],
            ['nama' => 'Ahmad Sulaiman', 'tempat_lahir' => 'Tasikmalaya', 'tanggal_lahir' => '1983-09-14', 'alamat' => 'Jl. Mustofa No. 56', 'kelamin' => 'Laki-laki', 'no_telepon' => '082234567814', 'email' => 'ahmad.sulaiman@email.com', 'alamatkota' => 'Balikpapan', 'alamatprovinsi'=> 'Kalimantan Timur', 'ketersediaan'=> 'Tersedia'],
            ['nama' => 'Siti Nurhaliza', 'tempat_lahir' => 'Garut', 'tanggal_lahir' => '1987-01-27', 'alamat' => 'Jl. Pembangunan No. 78', 'kelamin' => 'Perempuan', 'no_telepon' => '082234567815', 'email' => 'siti.nurhaliza@email.com', 'alamatkota' => 'Balikpapan', 'alamatprovinsi'=> 'Kalimantan Timur', 'ketersediaan'=> 'Tidak-Tersedia'],
            ['nama' => 'Budi Santoso', 'tempat_lahir' => 'Sukabumi', 'tanggal_lahir' => '1985-04-10', 'alamat' => 'Jl. Pelabuan Ratu No. 90', 'kelamin' => 'Laki-laki', 'no_telepon' => '082234567816', 'email' => 'budi.santoso@email.com', 'alamatkota' => 'Balikpapan', 'alamatprovinsi'=> 'Kalimantan Timur', 'ketersediaan'=> 'Tidak-Tersedia'],
        ];

        foreach ($pelatihs as $pelatihData) {
            Pelatih::create([
                'nama' => $pelatihData['nama'],
                'cabor_id' => $cabors->random()->id,
                'tempat_lahir' => $pelatihData['tempat_lahir'],
                'tanggal_lahir' => $pelatihData['tanggal_lahir'],
                'alamat' => $pelatihData['alamat'],
                'kelamin' => $pelatihData['kelamin'],
                'no_telepon' => $pelatihData['no_telepon'],
                'email' => $pelatihData['email'],
                'alamatkota' => $pelatihData['alamatkota'],
                'alamatprovinsi' => $pelatihData['alamatprovinsi'],
                'ketersediaan' => $pelatihData['ketersediaan'],
            ]);
        }
    }
}
