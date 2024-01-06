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
                'jumlah_pesanan' => 5,
                'harga_pesanan' => 500000,
                'id_transaksi' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tanggal_pesanan' => now(),
                'jumlah_pesanan' => 8,
                'harga_pesanan' => 800000,
                'id_transaksi' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tanggal_pesanan' => now(),
                'jumlah_pesanan' => 2,
                'harga_pesanan' => 200000,
                'id_transaksi' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tanggal_pesanan' => now(),
                'jumlah_pesanan' => 10,
                'harga_pesanan' => 1000000,
                'id_transaksi' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        
        Pesanan::insert($data);
    }
}
