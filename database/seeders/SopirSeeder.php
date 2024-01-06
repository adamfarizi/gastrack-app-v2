<?php

namespace Database\Seeders;

use App\Models\Sopir;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SopirSeeder extends Seeder
{
    public function run()
    {
        $sopir = [
        [
            'nama' => 'Asep Kuncen',
            'email' => 'sopir1@example.com',
            'password' => bcrypt('sopir123'),
            'role' => ('sopir'),
            'no_hp' => '088111222',
        ],[
            'nama' => 'Sigit Rendang',
            'email' => 'sopir2@example.com',
            'password' => bcrypt('sopir123'),
            'role' => ('sopir'),
            'no_hp' => '088112232',
        ],
        ];

        foreach ($sopir as $data) {
            Sopir::create($data);
        } 
    }
}
