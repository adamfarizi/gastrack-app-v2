<?php

namespace Database\Seeders;

use App\Models\Tagihan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagihanSeeder extends Seeder
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
                'tanggal_jatuh_tempo' => '2023-11-25',
                'jumlah_tagihan' => 1300000, // Replace with your desired value
                'status_tagihan' => 'Belum Bayar',
                'tanggal_pembayaran' => null,
                'bukti_pembayaran' => null,
                'id_pelanggan' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],[
                'tanggal_jatuh_tempo' => '2023-12-14',
                'jumlah_tagihan' => 1200000, // Replace with your desired value
                'status_tagihan' => 'Belum Bayar',
                'tanggal_pembayaran' => null,
                'bukti_pembayaran' => null,
                'id_pelanggan' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];
        
        Tagihan::insert($data);

    }
}
