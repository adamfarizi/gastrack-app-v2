<?php

namespace Database\Seeders;

use App\Models\MasterPayment;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MasterPaymentSeeder extends Seeder
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
                'nama_master' => 'Ganis Mashuda',
                'bank_master' => 'BCA',
                'kcu_master' => 'Mojokerto',
                'account_master' => '05-0172-6175',
            ],
        ];

        foreach ($data as $item) {
            MasterPayment::create($item);
        }
    }
}
