<?php

namespace Database\Seeders;

use App\Models\Mobil;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MobilSeeder extends Seeder
{
    public function run()
    {
        $mobil = [
        [
            'identitas_mobil' => 'Mitsubishi Lancer',
            'nopol_mobil' => 'AE 1234 BC',
            'jenis_mobil' => 'Pick Up',
            'vit_mobil' => '50',
        ],[
            'identitas_mobil' => 'Hino Hijau',
            'nopol_mobil' => 'AE 5678 BC',
            'jenis_mobil' => 'Truk',
            'vit_mobil' => '50',
        ],
        ];

        foreach ($mobil as $data) {
            Mobil::create($data);
        } 
    }
}
