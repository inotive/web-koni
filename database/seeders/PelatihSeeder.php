fix my seeder based on my controller <?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pelatih;

class PelatihSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama' => 'Andrew Arief Muhidin',
                'cabor' => 'Bola Basket',
                'tempat_lahir' => 'Balikpapan',
                'tanggal_lahir' => '2003-01-20',
                'alamat' => 'Tanjung',
                'kelamin' => 'Laki - Laki',
                'no_telepon' => '0812145563412',
                'email' => 'curtis.weaver@example.com',
                'foto' => 'andrew.jpg',
            ],
            [
                'nama' => 'Fathalia Alif Arif',
                'cabor' => 'Tenis',
                'tempat_lahir' => 'Banu Lawas',
                'tanggal_lahir' => '2002-02-15',
                'alamat' => 'Banu Lawas',
                'kelamin' => 'Laki - Laki',
                'no_telepon' => '0812145563437',
                'email' => 'tim.jennings@example.com',
                'foto' => 'fathalia.jpg',
            ],
            [
                'nama' => 'Zeriel Zakly Pratama',
                'cabor' => 'Tenis Meja',
                'tempat_lahir' => 'Jaro',
                'tanggal_lahir' => '2002-01-20',
                'alamat' => 'Jaro',
                'kelamin' => 'Laki - Laki',
                'no_telepon' => '0812145563410',
                'email' => 'nevaeh.simmons@example.com',
                'foto' => 'zeriel.jpg',
            ],
            [
                'nama' => 'Giovano Okta Jovanka',
                'cabor' => 'Catur',
                'tempat_lahir' => 'Tanjung, Kalimantan Selatan',
                'tanggal_lahir' => '2002-01-19',
                'alamat' => 'Haruai',
                'kelamin' => 'Laki - Laki',
                'no_telepon' => '0812145563431',
                'email' => 'alma.lawson@example.com',
                'foto' => 'giovano.jpg',
            ],
            [
                'nama' => 'Dwiko Febrian',
                'cabor' => 'Panjat Tebing',
                'tempat_lahir' => 'Tanjung, Kalimantan Selatan',
                'tanggal_lahir' => '2002-01-20',
                'alamat' => 'Muara Harus',
                'kelamin' => 'Laki - Laki',
                'no_telepon' => '0812145563445',
                'email' => 'michelle.rivera@example.com',
                'foto' => 'dwiko.jpg',
            ],
            [
                'nama' => 'Markson L. Djomie',
                'cabor' => 'Sepak Bola',
                'tempat_lahir' => 'Tanjung, Kalimantan Selatan',
                'tanggal_lahir' => '2002-01-20',
                'alamat' => 'Muara Uya',
                'kelamin' => 'Laki - Laki',
                'no_telepon' => '0812145563432',
                'email' => 'tanya.hill@example.com',
                'foto' => 'markson.jpg',
            ],
            [
                'nama' => 'Mirza Hafizh Fadilah',
                'cabor' => 'Sepak Bola',
                'tempat_lahir' => 'Tanjung, Kalimantan Selatan',
                'tanggal_lahir' => '2002-01-20',
                'alamat' => 'Pugaan',
                'kelamin' => 'Perempuan',
                'no_telepon' => '0812145563434',
                'email' => 'debbie.baker@example.com',
                'foto' => 'mirza.jpg',
            ],
            [
                'nama' => 'Ivanader Natanel Tindaan',
                'cabor' => 'Bola Basket',
                'tempat_lahir' => 'Tanjung, Kalimantan Selatan',
                'tanggal_lahir' => '2002-01-20',
                'alamat' => 'Tanta',
                'kelamin' => 'Laki - Laki',
                'no_telepon' => '0812145563438',
                'email' => 'felicia.reid@example.com',
                'foto' => 'ivanader.jpg',
            ],
            [
                'nama' => 'Darrell Rajendra Wibowo',
                'cabor' => 'Bulu Tangkis',
                'tempat_lahir' => 'Tanjung, Kalimantan Selatan',
                'tanggal_lahir' => '2002-01-19',
                'alamat' => 'Tanjung',
                'kelamin' => 'Laki - Laki',
                'no_telepon' => '0812145563435',
                'email' => 'dolores.chambers@example.com',
                'foto' => 'darrell.jpg',
            ],
            [
                'nama' => 'Hengki Agung Prayoga',
                'cabor' => 'Panjat Tebing',
                'tempat_lahir' => 'Tanjung, Kalimantan Selatan',
                'tanggal_lahir' => '2002-01-19',
                'alamat' => 'Upau',
                'kelamin' => 'Perempuan',
                'no_telepon' => '0812145563430',
                'email' => 'nathan.roberts@example.com',
                'foto' => 'hengki.jpg',
            ],
            [
                'nama' => 'Sul',
                'cabor' => 'Catur',
                'tempat_lahir' => 'Balikpapan, Kalimantan Timur',
                'tanggal_lahir' => '2008-05-24',
                'alamat' => 'Wika blok A1 no 02, Balikpapan',
                'kelamin' => 'Laki-Laki',
                'no_telepon' => '082155182790',
                'email' => 'sul@example.com',
                'foto' => 'sul.jpg',
            ],
            [
                'nama' => 'Pertamina Pt Duta Palma',
                'cabor' => 'Catur',
                'tempat_lahir' => 'Hidup, Minyak',
                'tanggal_lahir' => '1987-03-21',
                'alamat' => 'Jln minyak, indonesia',
                'kelamin' => 'Laki-Laki',
                'no_telepon' => '082135112720',
                'email' => 'sul@example.com',
                'foto' => 'Pertamina.jpg',
            ],
        ];

        foreach ($data as $item) {
            Pelatih::create($item);
        }
    }
}
