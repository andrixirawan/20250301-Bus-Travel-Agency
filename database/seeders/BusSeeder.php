<?php

namespace Database\Seeders;

use App\Models\Bus;
use Illuminate\Database\Seeder;

class BusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $buses = [
            'Sinar Jaya',
            'Harapan Jaya',
            'Rosalia Indah',
            'Juragan 99 Trans',
            'Agra Mas',
            'Tami Jaya',
            'Gunung Harta',
            'Sempati Star',
            'Lorena-Karina',
            'M Trans',
            'Putera Mulya',
            'Pandawa 87',
            'Nusantara',
            'Paradep Trans',
            'Safari Dharma Raya',
            'Bhinneka Sangkuriang Transport',
            'Karya Setiawan Ekatama',
            'Rukun Jaya',
            'Perum PPD',
            'TransJakarta',
            'Big Bird',
            'Eagle High',
            'Damri',
            'Sempati Star',
            'ANS',
            'Raja Perdana Inti (RAPI)',
            'Medan Jaya',
            'Naikilah Perusahaan Minang (NPM)',
            'ALS (Antar Lintas Sumatera)',
            'Eka'
        ];

        foreach ($buses as $busName) {
            Bus::create([
                'name' => $busName,
                'capacity' => rand(40, 50)
            ]);
        }
    }
} 