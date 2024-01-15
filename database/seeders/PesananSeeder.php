<?php

namespace Database\Seeders;

use App\Models\Pesanan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PesananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminId = 1;
        $id_pelanggan = 1;

        $data = [
            [
                'tanggal_pesanan' => now(),
                'jumlah_bar' => 15,
                'jumlah_m3' => 2500,
                'harga_pesanan' => 500000,
                'id_transaksi' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tanggal_pesanan' => now(),
                'jumlah_bar' => 20,
                'jumlah_m3' => 3000,
                'harga_pesanan' => 1000000,
                'id_transaksi' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tanggal_pesanan' => now(),
                'jumlah_bar' => 15,
                'jumlah_m3' => 2500,
                'harga_pesanan' => 500000,
                'id_transaksi' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tanggal_pesanan' => now(),
                'jumlah_bar' => 10,
                'jumlah_m3' => 2000,
                'harga_pesanan' => 400000,
                'id_transaksi' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        
        Pesanan::insert($data);
    }
}
