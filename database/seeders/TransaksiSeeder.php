<?php

namespace Database\Seeders;

use App\Models\Transaksi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransaksiSeeder extends Seeder
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
                'resi_transaksi' => 'GT-2502351',
                'tanggal_transaksi' => now(),
                'id_pelanggan' => 1,
                'id_tagihan' => 1,
                'id_admin' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'resi_transaksi' => 'GT-3452112',
                'tanggal_transaksi' => now(),
                'id_pelanggan' => 2,
                'id_tagihan' => 2,
                'id_admin' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        
        Transaksi::insert($data);
        
    }
}
