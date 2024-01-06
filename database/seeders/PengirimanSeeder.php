<?php

namespace Database\Seeders;

use App\Models\Pengiriman;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PengirimanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'kode_pengiriman' => 'GT-'.date('d/m/Y').'-21304311',
                'status_pengiriman' => 'Proses',
                'id_pesanan' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_pengiriman' => 'GT-'.date('d/m/Y').'-112213141',
                'status_pengiriman' => 'Proses',
                'id_pesanan' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_pengiriman' => 'GT-'.date('d/m/Y').'-31150322',
                'status_pengiriman' => 'Proses',
                'id_pesanan' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_pengiriman' => 'GT-'.date('d/m/Y').'-22131451',
                'status_pengiriman' => 'Proses',
                'id_pesanan' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        
        Pengiriman::insert($data);
    }
}
