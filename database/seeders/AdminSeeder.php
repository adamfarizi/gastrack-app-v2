<?php
// database/seeders/AdminSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $admin = [
        [
            'nama' => 'Super Admin',
            'email' => 'admin@example.com',
            'role' => 'Super Admin',
            'password' => bcrypt('admin123'),
        ],[
            'nama' => 'Admin Ucok',
            'email' => 'admin1@example.com',
            'role' => 'Admin',
            'password' => bcrypt('admin123'),
        ]
        ];

        foreach ($admin as $data) {
            User::create($data);
        }    
    }
}
