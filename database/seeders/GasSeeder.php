<?php

namespace Database\Seeders;

use App\Models\Gas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Gas::create(['harga_gas' => 100000]);
    }
}
