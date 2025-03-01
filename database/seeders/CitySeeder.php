<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            [
                'name' => 'Yogyakarta',
                'tourist_attractions' => ['Candi Prambanan', 'Malioboro', 'Keraton Yogyakarta']
            ],
            [
                'name' => 'Bandung',
                'tourist_attractions' => ['Lembang', 'Kawah Putih', 'Gedung Sate']
            ],
            [
                'name' => 'Jakarta',
                'tourist_attractions' => ['Monas', 'Ancol', 'Kota Tua']
            ],
            [
                'name' => 'Bogor',
                'tourist_attractions' => ['Kebun Raya Bogor', 'Puncak', 'Taman Safari']
            ],
            [
                'name' => 'Semarang',
                'tourist_attractions' => ['Lawang Sewu', 'Kota Lama', 'Sam Poo Kong']
            ],
            [
                'name' => 'Surabaya',
                'tourist_attractions' => ['Tugu Pahlawan', 'House of Sampoerna', 'Kenjeran']
            ],
            [
                'name' => 'Malang',
                'tourist_attractions' => ['Batu', 'Jatim Park', 'Museum Angkut']
            ],
            [
                'name' => 'Batu',
                'tourist_attractions' => ['Selecta', 'Alun-alun Batu', 'Coban Rondo']
            ],
            [
                'name' => 'Solo',
                'tourist_attractions' => ['Keraton Solo', 'Pasar Klewer', 'Taman Balekambang']
            ],
            [
                'name' => 'Magelang',
                'tourist_attractions' => ['Candi Borobudur', 'Punthuk Setumbu', 'Gereja Ayam']
            ],
            // ... lanjutan kota-kota lainnya
            [
                'name' => 'Banyuwangi',
                'tourist_attractions' => ['Kawah Ijen', 'Pantai Pulau Merah', 'Baluran']
            ],
            [
                'name' => 'Cirebon',
                'tourist_attractions' => ['Keraton Kasepuhan', 'Gua Sunyaragi', 'Masjid Agung Sang Cipta Rasa']
            ],
            [
                'name' => 'Pangandaran',
                'tourist_attractions' => ['Pantai Pangandaran', 'Green Canyon', 'Batu Karas']
            ],
            // ... tambahkan kota lainnya sesuai daftar
            [
                'name' => 'Denpasar',
                'tourist_attractions' => ['Pantai Sanur', 'Museum Bali']
            ],
            [
                'name' => 'Kuta',
                'tourist_attractions' => ['Pantai Kuta', 'Waterbom Bali']
            ],
            [
                'name' => 'Ubud',
                'tourist_attractions' => ['Monkey Forest', 'Campuhan Ridge Walk']
            ],
            [
                'name' => 'Klungkung',
                'tourist_attractions' => ['Nusa Penida', 'Nusa Lembongan']
            ]
        ];

        foreach ($cities as $city) {
            City::create([
                'name' => $city['name'],
                'tourist_attractions' => $city['tourist_attractions']
            ]);
        }
    }
} 