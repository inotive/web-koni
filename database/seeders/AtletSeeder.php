<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Atlet;
use App\Models\CabangOlahraga;

class AtletSeeder extends Seeder
{
    public function run()
    {
        $cabors = CabangOlahraga::all();

        $atlets = [  ['nama' => 'Andi Pratama', 'tempat_lahir' => 'Jakarta', 'tanggal_lahir' => '1995-03-15', 'alamat' => 'Jl. Sudirman No. 123, Jakarta', 'jenis_kelamin' => 'Laki-laki', 'no_telepon' => '081234567890', 'email' => 'andi.pratama@email.com'],
            ['nama' => 'Sari Dewi', 'tempat_lahir' => 'Bandung', 'tanggal_lahir' => '1997-07-22', 'alamat' => 'Jl. Asia Afrika No. 45, Bandung', 'jenis_kelamin' => 'Perempuan', 'no_telepon' => '081234567891', 'email' => 'sari.dewi@email.com'],
            ['nama' => 'Budi Setiawan', 'tempat_lahir' => 'Surabaya', 'tanggal_lahir' => '1994-11-08', 'alamat' => 'Jl. Pemuda No. 67, Surabaya', 'jenis_kelamin' => 'Laki-laki', 'no_telepon' => '081234567892', 'email' => 'budi.setiawan@email.com'],
            ['nama' => 'Maya Sari', 'tempat_lahir' => 'Medan', 'tanggal_lahir' => '1996-05-12', 'alamat' => 'Jl. Sisingamangaraja No. 89, Medan', 'jenis_kelamin' => 'Perempuan', 'no_telepon' => '081234567893', 'email' => 'maya.sari@email.com'],
            ['nama' => 'Rio Fernandez', 'tempat_lahir' => 'Makassar', 'tanggal_lahir' => '1993-09-25', 'alamat' => 'Jl. Pettarani No. 12, Makassar', 'jenis_kelamin' => 'Laki-laki', 'no_telepon' => '081234567894', 'email' => 'rio.fernandez@email.com'],
            ['nama' => 'Nina Agustina', 'tempat_lahir' => 'Yogyakarta', 'tanggal_lahir' => '1998-02-18', 'alamat' => 'Jl. Malioboro No. 34, Yogyakarta', 'jenis_kelamin' => 'Perempuan', 'no_telepon' => '081234567895', 'email' => 'nina.agustina@email.com'],
            ['nama' => 'Doni Saputra', 'tempat_lahir' => 'Palembang', 'tanggal_lahir' => '1995-06-30', 'alamat' => 'Jl. Sudirman No. 56, Palembang', 'jenis_kelamin' => 'Laki-laki', 'no_telepon' => '081234567896', 'email' => 'doni.saputra@email.com'],
            ['nama' => 'Lina Marlina', 'tempat_lahir' => 'Semarang', 'tanggal_lahir' => '1997-10-14', 'alamat' => 'Jl. Pandanaran No. 78, Semarang', 'jenis_kelamin' => 'Perempuan', 'no_telepon' => '081234567897', 'email' => 'lina.marlina@email.com'],
            ['nama' => 'Agus Salim', 'tempat_lahir' => 'Denpasar', 'tanggal_lahir' => '1994-04-07', 'alamat' => 'Jl. Gajah Mada No. 90, Denpasar', 'jenis_kelamin' => 'Laki-laki', 'no_telepon' => '081234567898', 'email' => 'agus.salim@email.com'],
            ['nama' => 'Rina Susanti', 'tempat_lahir' => 'Padang', 'tanggal_lahir' => '1996-08-21', 'alamat' => 'Jl. Ahmad Yani No. 23, Padang', 'jenis_kelamin' => 'Perempuan', 'no_telepon' => '081234567899', 'email' => 'rina.susanti@email.com'],
            ['nama' => 'Fajar Nugroho', 'tempat_lahir' => 'Solo', 'tanggal_lahir' => '1995-12-03', 'alamat' => 'Jl. Slamet Riyadi No. 45, Solo', 'jenis_kelamin' => 'Laki-laki', 'no_telepon' => '081234567800', 'email' => 'fajar.nugroho@email.com'],
            ['nama' => 'Tina Aprilia', 'tempat_lahir' => 'Malang', 'tanggal_lahir' => '1998-01-16', 'alamat' => 'Jl. Ijen No. 67, Malang', 'jenis_kelamin' => 'Perempuan', 'no_telepon' => '081234567801', 'email' => 'tina.aprilia@email.com'],
            ['nama' => 'Hendra Gunawan', 'tempat_lahir' => 'Balikpapan', 'tanggal_lahir' => '1993-05-29', 'alamat' => 'Jl. Jendral Sudirman No. 89, Balikpapan', 'jenis_kelamin' => 'Laki-laki', 'no_telepon' => '081234567802', 'email' => 'hendra.gunawan@email.com'],
            ['nama' => 'Wulan Dari', 'tempat_lahir' => 'Banjarmasin', 'tanggal_lahir' => '1997-09-11', 'alamat' => 'Jl. Lambung Mangkurat No. 12, Banjarmasin', 'jenis_kelamin' => 'Perempuan', 'no_telepon' => '081234567803', 'email' => 'wulan.dari@email.com'],
            ['nama' => 'Kevin Pratama', 'tempat_lahir' => 'Pontianak', 'tanggal_lahir' => '1996-03-24', 'alamat' => 'Jl. Tanjungpura No. 34, Pontianak', 'jenis_kelamin' => 'Laki-laki', 'no_telepon' => '081234567804', 'email' => 'kevin.pratama@email.com'],
            ['nama' => 'Sinta Dewi', 'tempat_lahir' => 'Pekanbaru', 'tanggal_lahir' => '1995-07-17', 'alamat' => 'Jl. Sudirman No. 56, Pekanbaru', 'jenis_kelamin' => 'Perempuan', 'no_telepon' => '081234567805', 'email' => 'sinta.dewi@email.com'],
            ['nama' => 'Rizky Aditya', 'tempat_lahir' => 'Jambi', 'tanggal_lahir' => '1994-11-02', 'alamat' => 'Jl. Gatot Subroto No. 78, Jambi', 'jenis_kelamin' => 'Laki-laki', 'no_telepon' => '081234567806', 'email' => 'rizky.aditya@email.com'],
            ['nama' => 'Indah Permata', 'tempat_lahir' => 'Bengkulu', 'tanggal_lahir' => '1998-04-13', 'alamat' => 'Jl. Raya Fatmawati No. 90, Bengkulu', 'jenis_kelamin' => 'Perempuan', 'no_telepon' => '081234567807', 'email' => 'indah.permata@email.com'],
            ['nama' => 'Ahmad Fauzi', 'tempat_lahir' => 'Lampung', 'tanggal_lahir' => '1993-08-26', 'alamat' => 'Jl. Zainal Abidin Pagar Alam No. 23, Lampung', 'jenis_kelamin' => 'Laki-laki', 'no_telepon' => '081234567808', 'email' => 'ahmad.fauzi@email.com'],
            ['nama' => 'Dewi Sartika', 'tempat_lahir' => 'Tangerang', 'tanggal_lahir' => '1997-02-09', 'alamat' => 'Jl. MH Thamrin No. 45, Tangerang', 'jenis_kelamin' => 'Perempuan', 'no_telepon' => '081234567809', 'email' => 'dewi.sartika@email.com'],
            ['nama' => 'Ilham Hakim', 'tempat_lahir' => 'Bekasi', 'tanggal_lahir' => '1995-06-22', 'alamat' => 'Jl. Ahmad Yani No. 67, Bekasi', 'jenis_kelamin' => 'Laki-laki', 'no_telepon' => '081234567810', 'email' => 'ilham.hakim@email.com'],
            ['nama' => 'Ratna Sari', 'tempat_lahir' => 'Depok', 'tanggal_lahir' => '1996-10-05', 'alamat' => 'Jl. Margonda Raya No. 89, Depok', 'jenis_kelamin' => 'Perempuan', 'no_telepon' => '081234567811', 'email' => 'ratna.sari@email.com'],
            ['nama' => 'Yoga Pratama', 'tempat_lahir' => 'Bogor', 'tanggal_lahir' => '1994-12-18', 'alamat' => 'Jl. Pajajaran No. 12, Bogor', 'jenis_kelamin' => 'Laki-laki', 'no_telepon' => '081234567812', 'email' => 'yoga.pratama@email.com'],
            ['nama' => 'Fitri Handayani', 'tempat_lahir' => 'Cirebon', 'tanggal_lahir' => '1998-05-31', 'alamat' => 'Jl. Siliwangi No. 34, Cirebon', 'jenis_kelamin' => 'Perempuan', 'no_telepon' => '081234567813', 'email' => 'fitri.handayani@email.com'],
            ['nama' => 'Roni Setiawan', 'tempat_lahir' => 'Tasikmalaya', 'tanggal_lahir' => '1993-09-14', 'alamat' => 'Jl. Asia Afrika No. 56, Tasikmalaya', 'jenis_kelamin' => 'Laki-laki', 'no_telepon' => '081234567814', 'email' => 'roni.setiawan@email.com'],
            ['nama' => 'Mega Wati', 'tempat_lahir' => 'Garut', 'tanggal_lahir' => '1997-01-27', 'alamat' => 'Jl. Otto Iskandardinata No. 78, Garut', 'jenis_kelamin' => 'Perempuan', 'no_telepon' => '081234567815', 'email' => 'mega.wati@email.com'],
            ['nama' => 'Dedy Kurniawan', 'tempat_lahir' => 'Sukabumi', 'tanggal_lahir' => '1995-04-10', 'alamat' => 'Jl. Ahmad Yani No. 90, Sukabumi', 'jenis_kelamin' => 'Laki-laki', 'no_telepon' => '081234567816', 'email' => 'dedy.kurniawan@email.com'],
            ];

        foreach ($atlets as $index => $atletData) {
            Atlet::create([
                'nama' => $atletData['nama'],
                'cabor_id' => $cabors->random()->id,
                'tempat_lahir' => $atletData['tempat_lahir'],
                'tanggal_lahir' => $atletData['tanggal_lahir'],
                'alamat' => $atletData['alamat'],
                'jenis_kelamin' => $atletData['jenis_kelamin'],
                'no_telepon' => $atletData['no_telepon'],
                'email' => $atletData['email'],
            ]);
        }
    }
}
